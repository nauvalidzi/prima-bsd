<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdConfirmsampleAdd extends NpdConfirmsample
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_confirmsample';

    // Page object name
    public $PageObjName = "NpdConfirmsampleAdd";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Custom template
        $this->UseCustomTemplate = true;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (npd_confirmsample)
        if (!isset($GLOBALS["npd_confirmsample"]) || get_class($GLOBALS["npd_confirmsample"]) == PROJECT_NAMESPACE . "npd_confirmsample") {
            $GLOBALS["npd_confirmsample"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_confirmsample');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;
        if (Post("customexport") === null) {
             // Page Unload event
            if (method_exists($this, "pageUnload")) {
                $this->pageUnload();
            }

            // Global Page Unloaded event (in userfn*.php)
            Page_Unloaded();
        }

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            if (is_array(Session(SESSION_TEMP_IMAGES))) { // Restore temp images
                $TempImages = Session(SESSION_TEMP_IMAGES);
            }
            if (Post("data") !== null) {
                $content = Post("data");
            }
            $ExportFileName = Post("filename", "");
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("npd_confirmsample"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if ($this->CustomExport) { // Save temp images array for custom export
            if (is_array($TempImages)) {
                $_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "NpdConfirmsampleView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->idnpd->setVisibility();
        $this->tglkonfirmasi->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->nama->setVisibility();
        $this->bentuk->setVisibility();
        $this->viskositas->setVisibility();
        $this->warna->setVisibility();
        $this->bauparfum->setVisibility();
        $this->aplikasisediaan->setVisibility();
        $this->volume->setVisibility();
        $this->campaign->setVisibility();
        $this->alasansetuju->setVisibility();
        $this->foto->setVisibility();
        $this->namapemesan->setVisibility();
        $this->alamatpemesan->setVisibility();
        $this->personincharge->setVisibility();
        $this->jabatan->setVisibility();
        $this->notelp->setVisibility();
        $this->created_at->Visible = false;
        $this->receipt_by->setVisibility();
        $this->readonly->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->idnpd);
        $this->setupLookupOptions($this->idnpd_sample);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->bauparfum);
        $this->setupLookupOptions($this->aplikasisediaan);
        $this->setupLookupOptions($this->receipt_by);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("NpdConfirmsampleList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "NpdConfirmsampleList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdConfirmsampleView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->idnpd->CurrentValue = null;
        $this->idnpd->OldValue = $this->idnpd->CurrentValue;
        $this->tglkonfirmasi->CurrentValue = CurrentDate();
        $this->idnpd_sample->CurrentValue = null;
        $this->idnpd_sample->OldValue = $this->idnpd_sample->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->bentuk->CurrentValue = null;
        $this->bentuk->OldValue = $this->bentuk->CurrentValue;
        $this->viskositas->CurrentValue = null;
        $this->viskositas->OldValue = $this->viskositas->CurrentValue;
        $this->warna->CurrentValue = null;
        $this->warna->OldValue = $this->warna->CurrentValue;
        $this->bauparfum->CurrentValue = null;
        $this->bauparfum->OldValue = $this->bauparfum->CurrentValue;
        $this->aplikasisediaan->CurrentValue = null;
        $this->aplikasisediaan->OldValue = $this->aplikasisediaan->CurrentValue;
        $this->volume->CurrentValue = null;
        $this->volume->OldValue = $this->volume->CurrentValue;
        $this->campaign->CurrentValue = null;
        $this->campaign->OldValue = $this->campaign->CurrentValue;
        $this->alasansetuju->CurrentValue = null;
        $this->alasansetuju->OldValue = $this->alasansetuju->CurrentValue;
        $this->foto->Upload->DbValue = null;
        $this->foto->OldValue = $this->foto->Upload->DbValue;
        $this->foto->CurrentValue = null; // Clear file related field
        $this->namapemesan->CurrentValue = null;
        $this->namapemesan->OldValue = $this->namapemesan->CurrentValue;
        $this->alamatpemesan->CurrentValue = null;
        $this->alamatpemesan->OldValue = $this->alamatpemesan->CurrentValue;
        $this->personincharge->CurrentValue = null;
        $this->personincharge->OldValue = $this->personincharge->CurrentValue;
        $this->jabatan->CurrentValue = null;
        $this->jabatan->OldValue = $this->jabatan->CurrentValue;
        $this->notelp->CurrentValue = null;
        $this->notelp->OldValue = $this->notelp->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->receipt_by->CurrentValue = CurrentUserID();
        $this->readonly->CurrentValue = 0;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idnpd' first before field var 'x_idnpd'
        $val = $CurrentForm->hasValue("idnpd") ? $CurrentForm->getValue("idnpd") : $CurrentForm->getValue("x_idnpd");
        if (!$this->idnpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd->Visible = false; // Disable update for API request
            } else {
                $this->idnpd->setFormValue($val);
            }
        }

        // Check field name 'tglkonfirmasi' first before field var 'x_tglkonfirmasi'
        $val = $CurrentForm->hasValue("tglkonfirmasi") ? $CurrentForm->getValue("tglkonfirmasi") : $CurrentForm->getValue("x_tglkonfirmasi");
        if (!$this->tglkonfirmasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglkonfirmasi->Visible = false; // Disable update for API request
            } else {
                $this->tglkonfirmasi->setFormValue($val);
            }
            $this->tglkonfirmasi->CurrentValue = UnFormatDateTime($this->tglkonfirmasi->CurrentValue, 0);
        }

        // Check field name 'idnpd_sample' first before field var 'x_idnpd_sample'
        $val = $CurrentForm->hasValue("idnpd_sample") ? $CurrentForm->getValue("idnpd_sample") : $CurrentForm->getValue("x_idnpd_sample");
        if (!$this->idnpd_sample->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd_sample->Visible = false; // Disable update for API request
            } else {
                $this->idnpd_sample->setFormValue($val);
            }
        }

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'bentuk' first before field var 'x_bentuk'
        $val = $CurrentForm->hasValue("bentuk") ? $CurrentForm->getValue("bentuk") : $CurrentForm->getValue("x_bentuk");
        if (!$this->bentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuk->Visible = false; // Disable update for API request
            } else {
                $this->bentuk->setFormValue($val);
            }
        }

        // Check field name 'viskositas' first before field var 'x_viskositas'
        $val = $CurrentForm->hasValue("viskositas") ? $CurrentForm->getValue("viskositas") : $CurrentForm->getValue("x_viskositas");
        if (!$this->viskositas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositas->Visible = false; // Disable update for API request
            } else {
                $this->viskositas->setFormValue($val);
            }
        }

        // Check field name 'warna' first before field var 'x_warna'
        $val = $CurrentForm->hasValue("warna") ? $CurrentForm->getValue("warna") : $CurrentForm->getValue("x_warna");
        if (!$this->warna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->warna->Visible = false; // Disable update for API request
            } else {
                $this->warna->setFormValue($val);
            }
        }

        // Check field name 'bauparfum' first before field var 'x_bauparfum'
        $val = $CurrentForm->hasValue("bauparfum") ? $CurrentForm->getValue("bauparfum") : $CurrentForm->getValue("x_bauparfum");
        if (!$this->bauparfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bauparfum->Visible = false; // Disable update for API request
            } else {
                $this->bauparfum->setFormValue($val);
            }
        }

        // Check field name 'aplikasisediaan' first before field var 'x_aplikasisediaan'
        $val = $CurrentForm->hasValue("aplikasisediaan") ? $CurrentForm->getValue("aplikasisediaan") : $CurrentForm->getValue("x_aplikasisediaan");
        if (!$this->aplikasisediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasisediaan->Visible = false; // Disable update for API request
            } else {
                $this->aplikasisediaan->setFormValue($val);
            }
        }

        // Check field name 'volume' first before field var 'x_volume'
        $val = $CurrentForm->hasValue("volume") ? $CurrentForm->getValue("volume") : $CurrentForm->getValue("x_volume");
        if (!$this->volume->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->volume->Visible = false; // Disable update for API request
            } else {
                $this->volume->setFormValue($val);
            }
        }

        // Check field name 'campaign' first before field var 'x_campaign'
        $val = $CurrentForm->hasValue("campaign") ? $CurrentForm->getValue("campaign") : $CurrentForm->getValue("x_campaign");
        if (!$this->campaign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->campaign->Visible = false; // Disable update for API request
            } else {
                $this->campaign->setFormValue($val);
            }
        }

        // Check field name 'alasansetuju' first before field var 'x_alasansetuju'
        $val = $CurrentForm->hasValue("alasansetuju") ? $CurrentForm->getValue("alasansetuju") : $CurrentForm->getValue("x_alasansetuju");
        if (!$this->alasansetuju->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alasansetuju->Visible = false; // Disable update for API request
            } else {
                $this->alasansetuju->setFormValue($val);
            }
        }

        // Check field name 'namapemesan' first before field var 'x_namapemesan'
        $val = $CurrentForm->hasValue("namapemesan") ? $CurrentForm->getValue("namapemesan") : $CurrentForm->getValue("x_namapemesan");
        if (!$this->namapemesan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->namapemesan->Visible = false; // Disable update for API request
            } else {
                $this->namapemesan->setFormValue($val);
            }
        }

        // Check field name 'alamatpemesan' first before field var 'x_alamatpemesan'
        $val = $CurrentForm->hasValue("alamatpemesan") ? $CurrentForm->getValue("alamatpemesan") : $CurrentForm->getValue("x_alamatpemesan");
        if (!$this->alamatpemesan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamatpemesan->Visible = false; // Disable update for API request
            } else {
                $this->alamatpemesan->setFormValue($val);
            }
        }

        // Check field name 'personincharge' first before field var 'x_personincharge'
        $val = $CurrentForm->hasValue("personincharge") ? $CurrentForm->getValue("personincharge") : $CurrentForm->getValue("x_personincharge");
        if (!$this->personincharge->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->personincharge->Visible = false; // Disable update for API request
            } else {
                $this->personincharge->setFormValue($val);
            }
        }

        // Check field name 'jabatan' first before field var 'x_jabatan'
        $val = $CurrentForm->hasValue("jabatan") ? $CurrentForm->getValue("jabatan") : $CurrentForm->getValue("x_jabatan");
        if (!$this->jabatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatan->Visible = false; // Disable update for API request
            } else {
                $this->jabatan->setFormValue($val);
            }
        }

        // Check field name 'notelp' first before field var 'x_notelp'
        $val = $CurrentForm->hasValue("notelp") ? $CurrentForm->getValue("notelp") : $CurrentForm->getValue("x_notelp");
        if (!$this->notelp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->notelp->Visible = false; // Disable update for API request
            } else {
                $this->notelp->setFormValue($val);
            }
        }

        // Check field name 'receipt_by' first before field var 'x_receipt_by'
        $val = $CurrentForm->hasValue("receipt_by") ? $CurrentForm->getValue("receipt_by") : $CurrentForm->getValue("x_receipt_by");
        if (!$this->receipt_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receipt_by->Visible = false; // Disable update for API request
            } else {
                $this->receipt_by->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->tglkonfirmasi->CurrentValue = $this->tglkonfirmasi->FormValue;
        $this->tglkonfirmasi->CurrentValue = UnFormatDateTime($this->tglkonfirmasi->CurrentValue, 0);
        $this->idnpd_sample->CurrentValue = $this->idnpd_sample->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->bentuk->CurrentValue = $this->bentuk->FormValue;
        $this->viskositas->CurrentValue = $this->viskositas->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->bauparfum->CurrentValue = $this->bauparfum->FormValue;
        $this->aplikasisediaan->CurrentValue = $this->aplikasisediaan->FormValue;
        $this->volume->CurrentValue = $this->volume->FormValue;
        $this->campaign->CurrentValue = $this->campaign->FormValue;
        $this->alasansetuju->CurrentValue = $this->alasansetuju->FormValue;
        $this->namapemesan->CurrentValue = $this->namapemesan->FormValue;
        $this->alamatpemesan->CurrentValue = $this->alamatpemesan->FormValue;
        $this->personincharge->CurrentValue = $this->personincharge->FormValue;
        $this->jabatan->CurrentValue = $this->jabatan->FormValue;
        $this->notelp->CurrentValue = $this->notelp->FormValue;
        $this->receipt_by->CurrentValue = $this->receipt_by->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->idnpd->setDbValue($row['idnpd']);
        $this->tglkonfirmasi->setDbValue($row['tglkonfirmasi']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->nama->setDbValue($row['nama']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->bauparfum->setDbValue($row['bauparfum']);
        $this->aplikasisediaan->setDbValue($row['aplikasisediaan']);
        $this->volume->setDbValue($row['volume']);
        $this->campaign->setDbValue($row['campaign']);
        $this->alasansetuju->setDbValue($row['alasansetuju']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->namapemesan->setDbValue($row['namapemesan']);
        $this->alamatpemesan->setDbValue($row['alamatpemesan']);
        $this->personincharge->setDbValue($row['personincharge']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->notelp->setDbValue($row['notelp']);
        $this->created_at->setDbValue($row['created_at']);
        $this->receipt_by->setDbValue($row['receipt_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['tglkonfirmasi'] = $this->tglkonfirmasi->CurrentValue;
        $row['idnpd_sample'] = $this->idnpd_sample->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['bentuk'] = $this->bentuk->CurrentValue;
        $row['viskositas'] = $this->viskositas->CurrentValue;
        $row['warna'] = $this->warna->CurrentValue;
        $row['bauparfum'] = $this->bauparfum->CurrentValue;
        $row['aplikasisediaan'] = $this->aplikasisediaan->CurrentValue;
        $row['volume'] = $this->volume->CurrentValue;
        $row['campaign'] = $this->campaign->CurrentValue;
        $row['alasansetuju'] = $this->alasansetuju->CurrentValue;
        $row['foto'] = $this->foto->Upload->DbValue;
        $row['namapemesan'] = $this->namapemesan->CurrentValue;
        $row['alamatpemesan'] = $this->alamatpemesan->CurrentValue;
        $row['personincharge'] = $this->personincharge->CurrentValue;
        $row['jabatan'] = $this->jabatan->CurrentValue;
        $row['notelp'] = $this->notelp->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['receipt_by'] = $this->receipt_by->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // idnpd

        // tglkonfirmasi

        // idnpd_sample

        // nama

        // bentuk

        // viskositas

        // warna

        // bauparfum

        // aplikasisediaan

        // volume

        // campaign

        // alasansetuju

        // foto

        // namapemesan

        // alamatpemesan

        // personincharge

        // jabatan

        // notelp

        // created_at

        // receipt_by

        // readonly
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $curVal = trim(strval($this->idnpd->CurrentValue));
            if ($curVal != "") {
                $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                if ($this->idnpd->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                    } else {
                        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                    }
                }
            } else {
                $this->idnpd->ViewValue = null;
            }
            $this->idnpd->ViewCustomAttributes = "";

            // tglkonfirmasi
            $this->tglkonfirmasi->ViewValue = $this->tglkonfirmasi->CurrentValue;
            $this->tglkonfirmasi->ViewValue = FormatDateTime($this->tglkonfirmasi->ViewValue, 0);
            $this->tglkonfirmasi->ViewCustomAttributes = "";

            // idnpd_sample
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
                if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_review WHERE `status`=1 AND readonly=0)" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd_sample->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd_sample->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->displayValue($arwrk);
                    } else {
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->CurrentValue;
                    }
                }
            } else {
                $this->idnpd_sample->ViewValue = null;
            }
            $this->idnpd_sample->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // bentuk
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
                if ($this->bentuk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bentuk->Lookup->renderViewRow($rswrk[0]);
                        $this->bentuk->ViewValue = $this->bentuk->displayValue($arwrk);
                    } else {
                        $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
                    }
                }
            } else {
                $this->bentuk->ViewValue = null;
            }
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
                if ($this->viskositas->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->viskositas->Lookup->renderViewRow($rswrk[0]);
                        $this->viskositas->ViewValue = $this->viskositas->displayValue($arwrk);
                    } else {
                        $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
                    }
                }
            } else {
                $this->viskositas->ViewValue = null;
            }
            $this->viskositas->ViewCustomAttributes = "";

            // warna
            $curVal = trim(strval($this->warna->CurrentValue));
            if ($curVal != "") {
                $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
                if ($this->warna->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->warna->Lookup->renderViewRow($rswrk[0]);
                        $this->warna->ViewValue = $this->warna->displayValue($arwrk);
                    } else {
                        $this->warna->ViewValue = $this->warna->CurrentValue;
                    }
                }
            } else {
                $this->warna->ViewValue = null;
            }
            $this->warna->ViewCustomAttributes = "";

            // bauparfum
            $curVal = trim(strval($this->bauparfum->CurrentValue));
            if ($curVal != "") {
                $this->bauparfum->ViewValue = $this->bauparfum->lookupCacheOption($curVal);
                if ($this->bauparfum->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->bauparfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bauparfum->Lookup->renderViewRow($rswrk[0]);
                        $this->bauparfum->ViewValue = $this->bauparfum->displayValue($arwrk);
                    } else {
                        $this->bauparfum->ViewValue = $this->bauparfum->CurrentValue;
                    }
                }
            } else {
                $this->bauparfum->ViewValue = null;
            }
            $this->bauparfum->ViewCustomAttributes = "";

            // aplikasisediaan
            $curVal = trim(strval($this->aplikasisediaan->CurrentValue));
            if ($curVal != "") {
                $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->lookupCacheOption($curVal);
                if ($this->aplikasisediaan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->aplikasisediaan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->aplikasisediaan->Lookup->renderViewRow($rswrk[0]);
                        $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->displayValue($arwrk);
                    } else {
                        $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->CurrentValue;
                    }
                }
            } else {
                $this->aplikasisediaan->ViewValue = null;
            }
            $this->aplikasisediaan->ViewCustomAttributes = "";

            // volume
            $this->volume->ViewValue = $this->volume->CurrentValue;
            $this->volume->ViewCustomAttributes = "";

            // campaign
            $this->campaign->ViewValue = $this->campaign->CurrentValue;
            $this->campaign->ViewCustomAttributes = "";

            // alasansetuju
            $this->alasansetuju->ViewValue = $this->alasansetuju->CurrentValue;
            $this->alasansetuju->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

            // namapemesan
            $this->namapemesan->ViewValue = $this->namapemesan->CurrentValue;
            $this->namapemesan->ViewCustomAttributes = "";

            // alamatpemesan
            $this->alamatpemesan->ViewValue = $this->alamatpemesan->CurrentValue;
            $this->alamatpemesan->ViewCustomAttributes = "";

            // personincharge
            $this->personincharge->ViewValue = $this->personincharge->CurrentValue;
            $this->personincharge->ViewCustomAttributes = "";

            // jabatan
            $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
            $this->jabatan->ViewCustomAttributes = "";

            // notelp
            $this->notelp->ViewValue = $this->notelp->CurrentValue;
            $this->notelp->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // receipt_by
            $curVal = trim(strval($this->receipt_by->CurrentValue));
            if ($curVal != "") {
                $this->receipt_by->ViewValue = $this->receipt_by->lookupCacheOption($curVal);
                if ($this->receipt_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->receipt_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->receipt_by->Lookup->renderViewRow($rswrk[0]);
                        $this->receipt_by->ViewValue = $this->receipt_by->displayValue($arwrk);
                    } else {
                        $this->receipt_by->ViewValue = $this->receipt_by->CurrentValue;
                    }
                }
            } else {
                $this->receipt_by->ViewValue = null;
            }
            $this->receipt_by->ViewCustomAttributes = "";

            // readonly
            if (strval($this->readonly->CurrentValue) != "") {
                $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
            } else {
                $this->readonly->ViewValue = null;
            }
            $this->readonly->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // tglkonfirmasi
            $this->tglkonfirmasi->LinkCustomAttributes = "";
            $this->tglkonfirmasi->HrefValue = "";
            $this->tglkonfirmasi->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";
            $this->bentuk->TooltipValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";
            $this->viskositas->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // bauparfum
            $this->bauparfum->LinkCustomAttributes = "";
            $this->bauparfum->HrefValue = "";
            $this->bauparfum->TooltipValue = "";

            // aplikasisediaan
            $this->aplikasisediaan->LinkCustomAttributes = "";
            $this->aplikasisediaan->HrefValue = "";
            $this->aplikasisediaan->TooltipValue = "";

            // volume
            $this->volume->LinkCustomAttributes = "";
            $this->volume->HrefValue = "";
            $this->volume->TooltipValue = "";

            // campaign
            $this->campaign->LinkCustomAttributes = "";
            $this->campaign->HrefValue = "";
            $this->campaign->TooltipValue = "";

            // alasansetuju
            $this->alasansetuju->LinkCustomAttributes = "";
            $this->alasansetuju->HrefValue = "";
            $this->alasansetuju->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";

            // namapemesan
            $this->namapemesan->LinkCustomAttributes = "";
            $this->namapemesan->HrefValue = "";
            $this->namapemesan->TooltipValue = "";

            // alamatpemesan
            $this->alamatpemesan->LinkCustomAttributes = "";
            $this->alamatpemesan->HrefValue = "";
            $this->alamatpemesan->TooltipValue = "";

            // personincharge
            $this->personincharge->LinkCustomAttributes = "";
            $this->personincharge->HrefValue = "";
            $this->personincharge->TooltipValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";
            $this->jabatan->TooltipValue = "";

            // notelp
            $this->notelp->LinkCustomAttributes = "";
            $this->notelp->HrefValue = "";
            $this->notelp->TooltipValue = "";

            // receipt_by
            $this->receipt_by->LinkCustomAttributes = "";
            $this->receipt_by->HrefValue = "";
            $this->receipt_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                    if ($this->idnpd->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                            $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                        } else {
                            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                        }
                    }
                } else {
                    $this->idnpd->ViewValue = null;
                }
                $this->idnpd->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                } else {
                    $this->idnpd->ViewValue = $this->idnpd->Lookup !== null && is_array($this->idnpd->Lookup->Options) ? $curVal : null;
                }
                if ($this->idnpd->ViewValue !== null) { // Load from cache
                    $this->idnpd->EditValue = array_values($this->idnpd->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idnpd->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->idnpd->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    foreach ($arwrk as &$row)
                        $row = $this->idnpd->Lookup->renderViewRow($row);
                    $this->idnpd->EditValue = $arwrk;
                }
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // tglkonfirmasi
            $this->tglkonfirmasi->EditAttrs["class"] = "form-control";
            $this->tglkonfirmasi->EditCustomAttributes = "";
            $this->tglkonfirmasi->EditValue = HtmlEncode(FormatDateTime($this->tglkonfirmasi->CurrentValue, 8));
            $this->tglkonfirmasi->PlaceHolder = RemoveHtml($this->tglkonfirmasi->caption());

            // idnpd_sample
            $this->idnpd_sample->EditAttrs["class"] = "form-control";
            $this->idnpd_sample->EditCustomAttributes = "";
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            } else {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->Lookup !== null && is_array($this->idnpd_sample->Lookup->Options) ? $curVal : null;
            }
            if ($this->idnpd_sample->ViewValue !== null) { // Load from cache
                $this->idnpd_sample->EditValue = array_values($this->idnpd_sample->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idnpd_sample->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_review WHERE `status`=1 AND readonly=0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idnpd_sample->EditValue = $arwrk;
            }
            $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // bentuk
            $this->bentuk->EditCustomAttributes = "";
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
            } else {
                $this->bentuk->ViewValue = $this->bentuk->Lookup !== null && is_array($this->bentuk->Lookup->Options) ? $curVal : null;
            }
            if ($this->bentuk->ViewValue !== null) { // Load from cache
                $this->bentuk->EditValue = array_values($this->bentuk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->bentuk->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->bentuk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->bentuk->EditValue = $arwrk;
            }
            $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

            // viskositas
            $this->viskositas->EditCustomAttributes = "";
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
            } else {
                $this->viskositas->ViewValue = $this->viskositas->Lookup !== null && is_array($this->viskositas->Lookup->Options) ? $curVal : null;
            }
            if ($this->viskositas->ViewValue !== null) { // Load from cache
                $this->viskositas->EditValue = array_values($this->viskositas->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->viskositas->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->viskositas->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->viskositas->EditValue = $arwrk;
            }
            $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

            // warna
            $this->warna->EditCustomAttributes = "";
            $curVal = trim(strval($this->warna->CurrentValue));
            if ($curVal != "") {
                $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
            } else {
                $this->warna->ViewValue = $this->warna->Lookup !== null && is_array($this->warna->Lookup->Options) ? $curVal : null;
            }
            if ($this->warna->ViewValue !== null) { // Load from cache
                $this->warna->EditValue = array_values($this->warna->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->warna->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->warna->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->warna->EditValue = $arwrk;
            }
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // bauparfum
            $this->bauparfum->EditCustomAttributes = "";
            $curVal = trim(strval($this->bauparfum->CurrentValue));
            if ($curVal != "") {
                $this->bauparfum->ViewValue = $this->bauparfum->lookupCacheOption($curVal);
            } else {
                $this->bauparfum->ViewValue = $this->bauparfum->Lookup !== null && is_array($this->bauparfum->Lookup->Options) ? $curVal : null;
            }
            if ($this->bauparfum->ViewValue !== null) { // Load from cache
                $this->bauparfum->EditValue = array_values($this->bauparfum->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->bauparfum->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->bauparfum->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->bauparfum->EditValue = $arwrk;
            }
            $this->bauparfum->PlaceHolder = RemoveHtml($this->bauparfum->caption());

            // aplikasisediaan
            $this->aplikasisediaan->EditCustomAttributes = "";
            $curVal = trim(strval($this->aplikasisediaan->CurrentValue));
            if ($curVal != "") {
                $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->lookupCacheOption($curVal);
            } else {
                $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->Lookup !== null && is_array($this->aplikasisediaan->Lookup->Options) ? $curVal : null;
            }
            if ($this->aplikasisediaan->ViewValue !== null) { // Load from cache
                $this->aplikasisediaan->EditValue = array_values($this->aplikasisediaan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->aplikasisediaan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->aplikasisediaan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->aplikasisediaan->EditValue = $arwrk;
            }
            $this->aplikasisediaan->PlaceHolder = RemoveHtml($this->aplikasisediaan->caption());

            // volume
            $this->volume->EditAttrs["class"] = "form-control";
            $this->volume->EditCustomAttributes = "";
            if (!$this->volume->Raw) {
                $this->volume->CurrentValue = HtmlDecode($this->volume->CurrentValue);
            }
            $this->volume->EditValue = HtmlEncode($this->volume->CurrentValue);
            $this->volume->PlaceHolder = RemoveHtml($this->volume->caption());

            // campaign
            $this->campaign->EditAttrs["class"] = "form-control";
            $this->campaign->EditCustomAttributes = "";
            if (!$this->campaign->Raw) {
                $this->campaign->CurrentValue = HtmlDecode($this->campaign->CurrentValue);
            }
            $this->campaign->EditValue = HtmlEncode($this->campaign->CurrentValue);
            $this->campaign->PlaceHolder = RemoveHtml($this->campaign->caption());

            // alasansetuju
            $this->alasansetuju->EditAttrs["class"] = "form-control";
            $this->alasansetuju->EditCustomAttributes = "";
            $this->alasansetuju->EditValue = HtmlEncode($this->alasansetuju->CurrentValue);
            $this->alasansetuju->PlaceHolder = RemoveHtml($this->alasansetuju->caption());

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->foto->CurrentValue)) {
                $this->foto->Upload->FileName = $this->foto->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->foto);
            }

            // namapemesan
            $this->namapemesan->EditAttrs["class"] = "form-control";
            $this->namapemesan->EditCustomAttributes = "";
            if (!$this->namapemesan->Raw) {
                $this->namapemesan->CurrentValue = HtmlDecode($this->namapemesan->CurrentValue);
            }
            $this->namapemesan->EditValue = HtmlEncode($this->namapemesan->CurrentValue);
            $this->namapemesan->PlaceHolder = RemoveHtml($this->namapemesan->caption());

            // alamatpemesan
            $this->alamatpemesan->EditAttrs["class"] = "form-control";
            $this->alamatpemesan->EditCustomAttributes = "";
            if (!$this->alamatpemesan->Raw) {
                $this->alamatpemesan->CurrentValue = HtmlDecode($this->alamatpemesan->CurrentValue);
            }
            $this->alamatpemesan->EditValue = HtmlEncode($this->alamatpemesan->CurrentValue);
            $this->alamatpemesan->PlaceHolder = RemoveHtml($this->alamatpemesan->caption());

            // personincharge
            $this->personincharge->EditAttrs["class"] = "form-control";
            $this->personincharge->EditCustomAttributes = "";
            if (!$this->personincharge->Raw) {
                $this->personincharge->CurrentValue = HtmlDecode($this->personincharge->CurrentValue);
            }
            $this->personincharge->EditValue = HtmlEncode($this->personincharge->CurrentValue);
            $this->personincharge->PlaceHolder = RemoveHtml($this->personincharge->caption());

            // jabatan
            $this->jabatan->EditAttrs["class"] = "form-control";
            $this->jabatan->EditCustomAttributes = "";
            if (!$this->jabatan->Raw) {
                $this->jabatan->CurrentValue = HtmlDecode($this->jabatan->CurrentValue);
            }
            $this->jabatan->EditValue = HtmlEncode($this->jabatan->CurrentValue);
            $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

            // notelp
            $this->notelp->EditAttrs["class"] = "form-control";
            $this->notelp->EditCustomAttributes = "";
            if (!$this->notelp->Raw) {
                $this->notelp->CurrentValue = HtmlDecode($this->notelp->CurrentValue);
            }
            $this->notelp->EditValue = HtmlEncode($this->notelp->CurrentValue);
            $this->notelp->PlaceHolder = RemoveHtml($this->notelp->caption());

            // receipt_by
            $this->receipt_by->EditAttrs["class"] = "form-control";
            $this->receipt_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->receipt_by->CurrentValue));
            if ($curVal != "") {
                $this->receipt_by->ViewValue = $this->receipt_by->lookupCacheOption($curVal);
            } else {
                $this->receipt_by->ViewValue = $this->receipt_by->Lookup !== null && is_array($this->receipt_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->receipt_by->ViewValue !== null) { // Load from cache
                $this->receipt_by->EditValue = array_values($this->receipt_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->receipt_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->receipt_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->receipt_by->EditValue = $arwrk;
            }
            $this->receipt_by->PlaceHolder = RemoveHtml($this->receipt_by->caption());

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // tglkonfirmasi
            $this->tglkonfirmasi->LinkCustomAttributes = "";
            $this->tglkonfirmasi->HrefValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // bauparfum
            $this->bauparfum->LinkCustomAttributes = "";
            $this->bauparfum->HrefValue = "";

            // aplikasisediaan
            $this->aplikasisediaan->LinkCustomAttributes = "";
            $this->aplikasisediaan->HrefValue = "";

            // volume
            $this->volume->LinkCustomAttributes = "";
            $this->volume->HrefValue = "";

            // campaign
            $this->campaign->LinkCustomAttributes = "";
            $this->campaign->HrefValue = "";

            // alasansetuju
            $this->alasansetuju->LinkCustomAttributes = "";
            $this->alasansetuju->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;

            // namapemesan
            $this->namapemesan->LinkCustomAttributes = "";
            $this->namapemesan->HrefValue = "";

            // alamatpemesan
            $this->alamatpemesan->LinkCustomAttributes = "";
            $this->alamatpemesan->HrefValue = "";

            // personincharge
            $this->personincharge->LinkCustomAttributes = "";
            $this->personincharge->HrefValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";

            // notelp
            $this->notelp->LinkCustomAttributes = "";
            $this->notelp->HrefValue = "";

            // receipt_by
            $this->receipt_by->LinkCustomAttributes = "";
            $this->receipt_by->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }

        // Save data for Custom Template
        if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD) {
            $this->Rows[] = $this->customTemplateFieldValues();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if ($this->tglkonfirmasi->Required) {
            if (!$this->tglkonfirmasi->IsDetailKey && EmptyValue($this->tglkonfirmasi->FormValue)) {
                $this->tglkonfirmasi->addErrorMessage(str_replace("%s", $this->tglkonfirmasi->caption(), $this->tglkonfirmasi->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglkonfirmasi->FormValue)) {
            $this->tglkonfirmasi->addErrorMessage($this->tglkonfirmasi->getErrorMessage(false));
        }
        if ($this->idnpd_sample->Required) {
            if (!$this->idnpd_sample->IsDetailKey && EmptyValue($this->idnpd_sample->FormValue)) {
                $this->idnpd_sample->addErrorMessage(str_replace("%s", $this->idnpd_sample->caption(), $this->idnpd_sample->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->bentuk->Required) {
            if ($this->bentuk->FormValue == "") {
                $this->bentuk->addErrorMessage(str_replace("%s", $this->bentuk->caption(), $this->bentuk->RequiredErrorMessage));
            }
        }
        if ($this->viskositas->Required) {
            if ($this->viskositas->FormValue == "") {
                $this->viskositas->addErrorMessage(str_replace("%s", $this->viskositas->caption(), $this->viskositas->RequiredErrorMessage));
            }
        }
        if ($this->warna->Required) {
            if ($this->warna->FormValue == "") {
                $this->warna->addErrorMessage(str_replace("%s", $this->warna->caption(), $this->warna->RequiredErrorMessage));
            }
        }
        if ($this->bauparfum->Required) {
            if ($this->bauparfum->FormValue == "") {
                $this->bauparfum->addErrorMessage(str_replace("%s", $this->bauparfum->caption(), $this->bauparfum->RequiredErrorMessage));
            }
        }
        if ($this->aplikasisediaan->Required) {
            if ($this->aplikasisediaan->FormValue == "") {
                $this->aplikasisediaan->addErrorMessage(str_replace("%s", $this->aplikasisediaan->caption(), $this->aplikasisediaan->RequiredErrorMessage));
            }
        }
        if ($this->volume->Required) {
            if (!$this->volume->IsDetailKey && EmptyValue($this->volume->FormValue)) {
                $this->volume->addErrorMessage(str_replace("%s", $this->volume->caption(), $this->volume->RequiredErrorMessage));
            }
        }
        if ($this->campaign->Required) {
            if (!$this->campaign->IsDetailKey && EmptyValue($this->campaign->FormValue)) {
                $this->campaign->addErrorMessage(str_replace("%s", $this->campaign->caption(), $this->campaign->RequiredErrorMessage));
            }
        }
        if ($this->alasansetuju->Required) {
            if (!$this->alasansetuju->IsDetailKey && EmptyValue($this->alasansetuju->FormValue)) {
                $this->alasansetuju->addErrorMessage(str_replace("%s", $this->alasansetuju->caption(), $this->alasansetuju->RequiredErrorMessage));
            }
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->namapemesan->Required) {
            if (!$this->namapemesan->IsDetailKey && EmptyValue($this->namapemesan->FormValue)) {
                $this->namapemesan->addErrorMessage(str_replace("%s", $this->namapemesan->caption(), $this->namapemesan->RequiredErrorMessage));
            }
        }
        if ($this->alamatpemesan->Required) {
            if (!$this->alamatpemesan->IsDetailKey && EmptyValue($this->alamatpemesan->FormValue)) {
                $this->alamatpemesan->addErrorMessage(str_replace("%s", $this->alamatpemesan->caption(), $this->alamatpemesan->RequiredErrorMessage));
            }
        }
        if ($this->personincharge->Required) {
            if (!$this->personincharge->IsDetailKey && EmptyValue($this->personincharge->FormValue)) {
                $this->personincharge->addErrorMessage(str_replace("%s", $this->personincharge->caption(), $this->personincharge->RequiredErrorMessage));
            }
        }
        if ($this->jabatan->Required) {
            if (!$this->jabatan->IsDetailKey && EmptyValue($this->jabatan->FormValue)) {
                $this->jabatan->addErrorMessage(str_replace("%s", $this->jabatan->caption(), $this->jabatan->RequiredErrorMessage));
            }
        }
        if ($this->notelp->Required) {
            if (!$this->notelp->IsDetailKey && EmptyValue($this->notelp->FormValue)) {
                $this->notelp->addErrorMessage(str_replace("%s", $this->notelp->caption(), $this->notelp->RequiredErrorMessage));
            }
        }
        if ($this->receipt_by->Required) {
            if (!$this->receipt_by->IsDetailKey && EmptyValue($this->receipt_by->FormValue)) {
                $this->receipt_by->addErrorMessage(str_replace("%s", $this->receipt_by->caption(), $this->receipt_by->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check referential integrity for master table 'npd_confirmsample'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_npd();
        if (strval($this->idnpd->CurrentValue) != "") {
            $masterFilter = str_replace("@id@", AdjustSql($this->idnpd->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("npd")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "npd", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, false);

        // tglkonfirmasi
        $this->tglkonfirmasi->setDbValueDef($rsnew, UnFormatDateTime($this->tglkonfirmasi->CurrentValue, 0), CurrentDate(), false);

        // idnpd_sample
        $this->idnpd_sample->setDbValueDef($rsnew, $this->idnpd_sample->CurrentValue, 0, false);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", false);

        // bentuk
        $this->bentuk->setDbValueDef($rsnew, $this->bentuk->CurrentValue, null, false);

        // viskositas
        $this->viskositas->setDbValueDef($rsnew, $this->viskositas->CurrentValue, null, false);

        // warna
        $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, null, false);

        // bauparfum
        $this->bauparfum->setDbValueDef($rsnew, $this->bauparfum->CurrentValue, null, false);

        // aplikasisediaan
        $this->aplikasisediaan->setDbValueDef($rsnew, $this->aplikasisediaan->CurrentValue, null, false);

        // volume
        $this->volume->setDbValueDef($rsnew, $this->volume->CurrentValue, null, false);

        // campaign
        $this->campaign->setDbValueDef($rsnew, $this->campaign->CurrentValue, null, false);

        // alasansetuju
        $this->alasansetuju->setDbValueDef($rsnew, $this->alasansetuju->CurrentValue, null, false);

        // foto
        if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
            $this->foto->Upload->DbValue = ""; // No need to delete old file
            if ($this->foto->Upload->FileName == "") {
                $rsnew['foto'] = null;
            } else {
                $rsnew['foto'] = $this->foto->Upload->FileName;
            }
        }

        // namapemesan
        $this->namapemesan->setDbValueDef($rsnew, $this->namapemesan->CurrentValue, "", false);

        // alamatpemesan
        $this->alamatpemesan->setDbValueDef($rsnew, $this->alamatpemesan->CurrentValue, null, false);

        // personincharge
        $this->personincharge->setDbValueDef($rsnew, $this->personincharge->CurrentValue, null, false);

        // jabatan
        $this->jabatan->setDbValueDef($rsnew, $this->jabatan->CurrentValue, null, false);

        // notelp
        $this->notelp->setDbValueDef($rsnew, $this->notelp->CurrentValue, null, false);

        // receipt_by
        $this->receipt_by->setDbValueDef($rsnew, $this->receipt_by->CurrentValue, null, false);
        if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : [$this->foto->htmlDecode($this->foto->Upload->DbValue)];
            if (!EmptyValue($this->foto->Upload->FileName)) {
                $newFiles = [$this->foto->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->foto, $this->foto->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->foto->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->foto->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->foto->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->foto->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->foto->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
                if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : [$this->foto->htmlDecode($this->foto->Upload->DbValue)];
                    if (!EmptyValue($this->foto->Upload->FileName)) {
                        $newFiles = [$this->foto->Upload->FileName];
                        $newFiles2 = [$this->foto->htmlDecode($rsnew['foto'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->foto, $this->foto->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->foto->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Get("fk_id", Get("idnpd"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idnpd->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idnpd->setSessionValue($this->idnpd->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Post("fk_id", Post("idnpd"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idnpd->setFormValue($masterTbl->id->FormValue);
                    $this->idnpd->setSessionValue($this->idnpd->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "npd") {
                if ($this->idnpd->CurrentValue == "") {
                    $this->idnpd->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdConfirmsampleList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_idnpd":
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_review WHERE `status`=1 AND readonly=0)" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_bentuk":
                    break;
                case "x_viskositas":
                    break;
                case "x_warna":
                    break;
                case "x_bauparfum":
                    break;
                case "x_aplikasisediaan":
                    break;
                case "x_receipt_by":
                    break;
                case "x_readonly":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
        $idnpd = $this->idnpd->CurrentValue;
        if (!empty($idnpd)) {
        $pemesan = ExecuteRow("SELECT nama, jabatan, alamat, hp FROM customer WHERE id = (SELECT idcustomer FROM npd WHERE id = ".$idnpd.")");
        $this->namapemesan->EditValue = $pemesan['nama'];
        $this->alamatpemesan->EditValue = $pemesan['alamat'];
        $this->jabatan->EditValue = $pemesan['jabatan'];
        $this->notelp->EditValue = $pemesan['hp'];
        }
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
