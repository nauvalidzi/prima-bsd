<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdDesainAdd extends NpdDesain
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_desain';

    // Page object name
    public $PageObjName = "NpdDesainAdd";

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

        // Table object (npd_desain)
        if (!isset($GLOBALS["npd_desain"]) || get_class($GLOBALS["npd_desain"]) == PROJECT_NAMESPACE . "npd_desain") {
            $GLOBALS["npd_desain"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_desain');
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
                $doc = new $class(Container("npd_desain"));
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
                    if ($pageName == "NpdDesainView") {
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
        $this->tglterima->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->nama_produk->setVisibility();
        $this->klaim_bahan->setVisibility();
        $this->campaign_produk->setVisibility();
        $this->konsepwarna->setVisibility();
        $this->no_notifikasi->setVisibility();
        $this->jenis_kemasan->setVisibility();
        $this->posisi_label->setVisibility();
        $this->bahan_label->setVisibility();
        $this->draft_layout->setVisibility();
        $this->keterangan->setVisibility();
        $this->submitted_by->setVisibility();
        $this->checked1_by->setVisibility();
        $this->checked2_by->setVisibility();
        $this->approved_by->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
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
                    $this->terminate("NpdDesainList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "NpdDesainList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdDesainView") {
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->idnpd->CurrentValue = null;
        $this->idnpd->OldValue = $this->idnpd->CurrentValue;
        $this->tglterima->CurrentValue = null;
        $this->tglterima->OldValue = $this->tglterima->CurrentValue;
        $this->tglsubmit->CurrentValue = null;
        $this->tglsubmit->OldValue = $this->tglsubmit->CurrentValue;
        $this->nama_produk->CurrentValue = null;
        $this->nama_produk->OldValue = $this->nama_produk->CurrentValue;
        $this->klaim_bahan->CurrentValue = null;
        $this->klaim_bahan->OldValue = $this->klaim_bahan->CurrentValue;
        $this->campaign_produk->CurrentValue = null;
        $this->campaign_produk->OldValue = $this->campaign_produk->CurrentValue;
        $this->konsepwarna->CurrentValue = null;
        $this->konsepwarna->OldValue = $this->konsepwarna->CurrentValue;
        $this->no_notifikasi->CurrentValue = null;
        $this->no_notifikasi->OldValue = $this->no_notifikasi->CurrentValue;
        $this->jenis_kemasan->CurrentValue = null;
        $this->jenis_kemasan->OldValue = $this->jenis_kemasan->CurrentValue;
        $this->posisi_label->CurrentValue = null;
        $this->posisi_label->OldValue = $this->posisi_label->CurrentValue;
        $this->bahan_label->CurrentValue = null;
        $this->bahan_label->OldValue = $this->bahan_label->CurrentValue;
        $this->draft_layout->CurrentValue = null;
        $this->draft_layout->OldValue = $this->draft_layout->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->submitted_by->CurrentValue = null;
        $this->submitted_by->OldValue = $this->submitted_by->CurrentValue;
        $this->checked1_by->CurrentValue = null;
        $this->checked1_by->OldValue = $this->checked1_by->CurrentValue;
        $this->checked2_by->CurrentValue = null;
        $this->checked2_by->OldValue = $this->checked2_by->CurrentValue;
        $this->approved_by->CurrentValue = null;
        $this->approved_by->OldValue = $this->approved_by->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
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

        // Check field name 'tglterima' first before field var 'x_tglterima'
        $val = $CurrentForm->hasValue("tglterima") ? $CurrentForm->getValue("tglterima") : $CurrentForm->getValue("x_tglterima");
        if (!$this->tglterima->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglterima->Visible = false; // Disable update for API request
            } else {
                $this->tglterima->setFormValue($val);
            }
            $this->tglterima->CurrentValue = UnFormatDateTime($this->tglterima->CurrentValue, 0);
        }

        // Check field name 'tglsubmit' first before field var 'x_tglsubmit'
        $val = $CurrentForm->hasValue("tglsubmit") ? $CurrentForm->getValue("tglsubmit") : $CurrentForm->getValue("x_tglsubmit");
        if (!$this->tglsubmit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglsubmit->Visible = false; // Disable update for API request
            } else {
                $this->tglsubmit->setFormValue($val);
            }
            $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        }

        // Check field name 'nama_produk' first before field var 'x_nama_produk'
        $val = $CurrentForm->hasValue("nama_produk") ? $CurrentForm->getValue("nama_produk") : $CurrentForm->getValue("x_nama_produk");
        if (!$this->nama_produk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_produk->Visible = false; // Disable update for API request
            } else {
                $this->nama_produk->setFormValue($val);
            }
        }

        // Check field name 'klaim_bahan' first before field var 'x_klaim_bahan'
        $val = $CurrentForm->hasValue("klaim_bahan") ? $CurrentForm->getValue("klaim_bahan") : $CurrentForm->getValue("x_klaim_bahan");
        if (!$this->klaim_bahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->klaim_bahan->Visible = false; // Disable update for API request
            } else {
                $this->klaim_bahan->setFormValue($val);
            }
        }

        // Check field name 'campaign_produk' first before field var 'x_campaign_produk'
        $val = $CurrentForm->hasValue("campaign_produk") ? $CurrentForm->getValue("campaign_produk") : $CurrentForm->getValue("x_campaign_produk");
        if (!$this->campaign_produk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->campaign_produk->Visible = false; // Disable update for API request
            } else {
                $this->campaign_produk->setFormValue($val);
            }
        }

        // Check field name 'konsepwarna' first before field var 'x_konsepwarna'
        $val = $CurrentForm->hasValue("konsepwarna") ? $CurrentForm->getValue("konsepwarna") : $CurrentForm->getValue("x_konsepwarna");
        if (!$this->konsepwarna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->konsepwarna->Visible = false; // Disable update for API request
            } else {
                $this->konsepwarna->setFormValue($val);
            }
        }

        // Check field name 'no_notifikasi' first before field var 'x_no_notifikasi'
        $val = $CurrentForm->hasValue("no_notifikasi") ? $CurrentForm->getValue("no_notifikasi") : $CurrentForm->getValue("x_no_notifikasi");
        if (!$this->no_notifikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_notifikasi->Visible = false; // Disable update for API request
            } else {
                $this->no_notifikasi->setFormValue($val);
            }
        }

        // Check field name 'jenis_kemasan' first before field var 'x_jenis_kemasan'
        $val = $CurrentForm->hasValue("jenis_kemasan") ? $CurrentForm->getValue("jenis_kemasan") : $CurrentForm->getValue("x_jenis_kemasan");
        if (!$this->jenis_kemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenis_kemasan->Visible = false; // Disable update for API request
            } else {
                $this->jenis_kemasan->setFormValue($val);
            }
        }

        // Check field name 'posisi_label' first before field var 'x_posisi_label'
        $val = $CurrentForm->hasValue("posisi_label") ? $CurrentForm->getValue("posisi_label") : $CurrentForm->getValue("x_posisi_label");
        if (!$this->posisi_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->posisi_label->Visible = false; // Disable update for API request
            } else {
                $this->posisi_label->setFormValue($val);
            }
        }

        // Check field name 'bahan_label' first before field var 'x_bahan_label'
        $val = $CurrentForm->hasValue("bahan_label") ? $CurrentForm->getValue("bahan_label") : $CurrentForm->getValue("x_bahan_label");
        if (!$this->bahan_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahan_label->Visible = false; // Disable update for API request
            } else {
                $this->bahan_label->setFormValue($val);
            }
        }

        // Check field name 'draft_layout' first before field var 'x_draft_layout'
        $val = $CurrentForm->hasValue("draft_layout") ? $CurrentForm->getValue("draft_layout") : $CurrentForm->getValue("x_draft_layout");
        if (!$this->draft_layout->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->draft_layout->Visible = false; // Disable update for API request
            } else {
                $this->draft_layout->setFormValue($val);
            }
        }

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
            }
        }

        // Check field name 'submitted_by' first before field var 'x_submitted_by'
        $val = $CurrentForm->hasValue("submitted_by") ? $CurrentForm->getValue("submitted_by") : $CurrentForm->getValue("x_submitted_by");
        if (!$this->submitted_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->submitted_by->Visible = false; // Disable update for API request
            } else {
                $this->submitted_by->setFormValue($val);
            }
        }

        // Check field name 'checked1_by' first before field var 'x_checked1_by'
        $val = $CurrentForm->hasValue("checked1_by") ? $CurrentForm->getValue("checked1_by") : $CurrentForm->getValue("x_checked1_by");
        if (!$this->checked1_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->checked1_by->Visible = false; // Disable update for API request
            } else {
                $this->checked1_by->setFormValue($val);
            }
        }

        // Check field name 'checked2_by' first before field var 'x_checked2_by'
        $val = $CurrentForm->hasValue("checked2_by") ? $CurrentForm->getValue("checked2_by") : $CurrentForm->getValue("x_checked2_by");
        if (!$this->checked2_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->checked2_by->Visible = false; // Disable update for API request
            } else {
                $this->checked2_by->setFormValue($val);
            }
        }

        // Check field name 'approved_by' first before field var 'x_approved_by'
        $val = $CurrentForm->hasValue("approved_by") ? $CurrentForm->getValue("approved_by") : $CurrentForm->getValue("x_approved_by");
        if (!$this->approved_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->approved_by->Visible = false; // Disable update for API request
            } else {
                $this->approved_by->setFormValue($val);
            }
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        }

        // Check field name 'updated_at' first before field var 'x_updated_at'
        $val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
        if (!$this->updated_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_at->Visible = false; // Disable update for API request
            } else {
                $this->updated_at->setFormValue($val);
            }
            $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->tglterima->CurrentValue = $this->tglterima->FormValue;
        $this->tglterima->CurrentValue = UnFormatDateTime($this->tglterima->CurrentValue, 0);
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        $this->nama_produk->CurrentValue = $this->nama_produk->FormValue;
        $this->klaim_bahan->CurrentValue = $this->klaim_bahan->FormValue;
        $this->campaign_produk->CurrentValue = $this->campaign_produk->FormValue;
        $this->konsepwarna->CurrentValue = $this->konsepwarna->FormValue;
        $this->no_notifikasi->CurrentValue = $this->no_notifikasi->FormValue;
        $this->jenis_kemasan->CurrentValue = $this->jenis_kemasan->FormValue;
        $this->posisi_label->CurrentValue = $this->posisi_label->FormValue;
        $this->bahan_label->CurrentValue = $this->bahan_label->FormValue;
        $this->draft_layout->CurrentValue = $this->draft_layout->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->submitted_by->CurrentValue = $this->submitted_by->FormValue;
        $this->checked1_by->CurrentValue = $this->checked1_by->FormValue;
        $this->checked2_by->CurrentValue = $this->checked2_by->FormValue;
        $this->approved_by->CurrentValue = $this->approved_by->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
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
        $this->tglterima->setDbValue($row['tglterima']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->nama_produk->setDbValue($row['nama_produk']);
        $this->klaim_bahan->setDbValue($row['klaim_bahan']);
        $this->campaign_produk->setDbValue($row['campaign_produk']);
        $this->konsepwarna->setDbValue($row['konsepwarna']);
        $this->no_notifikasi->setDbValue($row['no_notifikasi']);
        $this->jenis_kemasan->setDbValue($row['jenis_kemasan']);
        $this->posisi_label->setDbValue($row['posisi_label']);
        $this->bahan_label->setDbValue($row['bahan_label']);
        $this->draft_layout->setDbValue($row['draft_layout']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->submitted_by->setDbValue($row['submitted_by']);
        $this->checked1_by->setDbValue($row['checked1_by']);
        $this->checked2_by->setDbValue($row['checked2_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['tglterima'] = $this->tglterima->CurrentValue;
        $row['tglsubmit'] = $this->tglsubmit->CurrentValue;
        $row['nama_produk'] = $this->nama_produk->CurrentValue;
        $row['klaim_bahan'] = $this->klaim_bahan->CurrentValue;
        $row['campaign_produk'] = $this->campaign_produk->CurrentValue;
        $row['konsepwarna'] = $this->konsepwarna->CurrentValue;
        $row['no_notifikasi'] = $this->no_notifikasi->CurrentValue;
        $row['jenis_kemasan'] = $this->jenis_kemasan->CurrentValue;
        $row['posisi_label'] = $this->posisi_label->CurrentValue;
        $row['bahan_label'] = $this->bahan_label->CurrentValue;
        $row['draft_layout'] = $this->draft_layout->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
        $row['submitted_by'] = $this->submitted_by->CurrentValue;
        $row['checked1_by'] = $this->checked1_by->CurrentValue;
        $row['checked2_by'] = $this->checked2_by->CurrentValue;
        $row['approved_by'] = $this->approved_by->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
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

        // tglterima

        // tglsubmit

        // nama_produk

        // klaim_bahan

        // campaign_produk

        // konsepwarna

        // no_notifikasi

        // jenis_kemasan

        // posisi_label

        // bahan_label

        // draft_layout

        // keterangan

        // submitted_by

        // checked1_by

        // checked2_by

        // approved_by

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // idnpd
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";

            // tglterima
            $this->tglterima->ViewValue = $this->tglterima->CurrentValue;
            $this->tglterima->ViewValue = FormatDateTime($this->tglterima->ViewValue, 0);
            $this->tglterima->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

            // nama_produk
            $this->nama_produk->ViewValue = $this->nama_produk->CurrentValue;
            $this->nama_produk->ViewCustomAttributes = "";

            // klaim_bahan
            $this->klaim_bahan->ViewValue = $this->klaim_bahan->CurrentValue;
            $this->klaim_bahan->ViewCustomAttributes = "";

            // campaign_produk
            $this->campaign_produk->ViewValue = $this->campaign_produk->CurrentValue;
            $this->campaign_produk->ViewCustomAttributes = "";

            // konsepwarna
            $this->konsepwarna->ViewValue = $this->konsepwarna->CurrentValue;
            $this->konsepwarna->ViewCustomAttributes = "";

            // no_notifikasi
            $this->no_notifikasi->ViewValue = $this->no_notifikasi->CurrentValue;
            $this->no_notifikasi->ViewCustomAttributes = "";

            // jenis_kemasan
            $this->jenis_kemasan->ViewValue = $this->jenis_kemasan->CurrentValue;
            $this->jenis_kemasan->ViewCustomAttributes = "";

            // posisi_label
            $this->posisi_label->ViewValue = $this->posisi_label->CurrentValue;
            $this->posisi_label->ViewCustomAttributes = "";

            // bahan_label
            $this->bahan_label->ViewValue = $this->bahan_label->CurrentValue;
            $this->bahan_label->ViewCustomAttributes = "";

            // draft_layout
            $this->draft_layout->ViewValue = $this->draft_layout->CurrentValue;
            $this->draft_layout->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // submitted_by
            $this->submitted_by->ViewValue = $this->submitted_by->CurrentValue;
            $this->submitted_by->ViewValue = FormatNumber($this->submitted_by->ViewValue, 0, -2, -2, -2);
            $this->submitted_by->ViewCustomAttributes = "";

            // checked1_by
            $this->checked1_by->ViewValue = $this->checked1_by->CurrentValue;
            $this->checked1_by->ViewValue = FormatNumber($this->checked1_by->ViewValue, 0, -2, -2, -2);
            $this->checked1_by->ViewCustomAttributes = "";

            // checked2_by
            $this->checked2_by->ViewValue = $this->checked2_by->CurrentValue;
            $this->checked2_by->ViewValue = FormatNumber($this->checked2_by->ViewValue, 0, -2, -2, -2);
            $this->checked2_by->ViewCustomAttributes = "";

            // approved_by
            $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
            $this->approved_by->ViewValue = FormatNumber($this->approved_by->ViewValue, 0, -2, -2, -2);
            $this->approved_by->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // tglterima
            $this->tglterima->LinkCustomAttributes = "";
            $this->tglterima->HrefValue = "";
            $this->tglterima->TooltipValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";
            $this->tglsubmit->TooltipValue = "";

            // nama_produk
            $this->nama_produk->LinkCustomAttributes = "";
            $this->nama_produk->HrefValue = "";
            $this->nama_produk->TooltipValue = "";

            // klaim_bahan
            $this->klaim_bahan->LinkCustomAttributes = "";
            $this->klaim_bahan->HrefValue = "";
            $this->klaim_bahan->TooltipValue = "";

            // campaign_produk
            $this->campaign_produk->LinkCustomAttributes = "";
            $this->campaign_produk->HrefValue = "";
            $this->campaign_produk->TooltipValue = "";

            // konsepwarna
            $this->konsepwarna->LinkCustomAttributes = "";
            $this->konsepwarna->HrefValue = "";
            $this->konsepwarna->TooltipValue = "";

            // no_notifikasi
            $this->no_notifikasi->LinkCustomAttributes = "";
            $this->no_notifikasi->HrefValue = "";
            $this->no_notifikasi->TooltipValue = "";

            // jenis_kemasan
            $this->jenis_kemasan->LinkCustomAttributes = "";
            $this->jenis_kemasan->HrefValue = "";
            $this->jenis_kemasan->TooltipValue = "";

            // posisi_label
            $this->posisi_label->LinkCustomAttributes = "";
            $this->posisi_label->HrefValue = "";
            $this->posisi_label->TooltipValue = "";

            // bahan_label
            $this->bahan_label->LinkCustomAttributes = "";
            $this->bahan_label->HrefValue = "";
            $this->bahan_label->TooltipValue = "";

            // draft_layout
            $this->draft_layout->LinkCustomAttributes = "";
            $this->draft_layout->HrefValue = "";
            $this->draft_layout->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // submitted_by
            $this->submitted_by->LinkCustomAttributes = "";
            $this->submitted_by->HrefValue = "";
            $this->submitted_by->TooltipValue = "";

            // checked1_by
            $this->checked1_by->LinkCustomAttributes = "";
            $this->checked1_by->HrefValue = "";
            $this->checked1_by->TooltipValue = "";

            // checked2_by
            $this->checked2_by->LinkCustomAttributes = "";
            $this->checked2_by->HrefValue = "";
            $this->checked2_by->TooltipValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";
            $this->approved_by->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            $this->idnpd->EditValue = HtmlEncode($this->idnpd->CurrentValue);
            $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());

            // tglterima
            $this->tglterima->EditAttrs["class"] = "form-control";
            $this->tglterima->EditCustomAttributes = "";
            $this->tglterima->EditValue = HtmlEncode(FormatDateTime($this->tglterima->CurrentValue, 8));
            $this->tglterima->PlaceHolder = RemoveHtml($this->tglterima->caption());

            // tglsubmit
            $this->tglsubmit->EditAttrs["class"] = "form-control";
            $this->tglsubmit->EditCustomAttributes = "";
            $this->tglsubmit->EditValue = HtmlEncode(FormatDateTime($this->tglsubmit->CurrentValue, 8));
            $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

            // nama_produk
            $this->nama_produk->EditAttrs["class"] = "form-control";
            $this->nama_produk->EditCustomAttributes = "";
            if (!$this->nama_produk->Raw) {
                $this->nama_produk->CurrentValue = HtmlDecode($this->nama_produk->CurrentValue);
            }
            $this->nama_produk->EditValue = HtmlEncode($this->nama_produk->CurrentValue);
            $this->nama_produk->PlaceHolder = RemoveHtml($this->nama_produk->caption());

            // klaim_bahan
            $this->klaim_bahan->EditAttrs["class"] = "form-control";
            $this->klaim_bahan->EditCustomAttributes = "";
            if (!$this->klaim_bahan->Raw) {
                $this->klaim_bahan->CurrentValue = HtmlDecode($this->klaim_bahan->CurrentValue);
            }
            $this->klaim_bahan->EditValue = HtmlEncode($this->klaim_bahan->CurrentValue);
            $this->klaim_bahan->PlaceHolder = RemoveHtml($this->klaim_bahan->caption());

            // campaign_produk
            $this->campaign_produk->EditAttrs["class"] = "form-control";
            $this->campaign_produk->EditCustomAttributes = "";
            if (!$this->campaign_produk->Raw) {
                $this->campaign_produk->CurrentValue = HtmlDecode($this->campaign_produk->CurrentValue);
            }
            $this->campaign_produk->EditValue = HtmlEncode($this->campaign_produk->CurrentValue);
            $this->campaign_produk->PlaceHolder = RemoveHtml($this->campaign_produk->caption());

            // konsepwarna
            $this->konsepwarna->EditAttrs["class"] = "form-control";
            $this->konsepwarna->EditCustomAttributes = "";
            if (!$this->konsepwarna->Raw) {
                $this->konsepwarna->CurrentValue = HtmlDecode($this->konsepwarna->CurrentValue);
            }
            $this->konsepwarna->EditValue = HtmlEncode($this->konsepwarna->CurrentValue);
            $this->konsepwarna->PlaceHolder = RemoveHtml($this->konsepwarna->caption());

            // no_notifikasi
            $this->no_notifikasi->EditAttrs["class"] = "form-control";
            $this->no_notifikasi->EditCustomAttributes = "";
            if (!$this->no_notifikasi->Raw) {
                $this->no_notifikasi->CurrentValue = HtmlDecode($this->no_notifikasi->CurrentValue);
            }
            $this->no_notifikasi->EditValue = HtmlEncode($this->no_notifikasi->CurrentValue);
            $this->no_notifikasi->PlaceHolder = RemoveHtml($this->no_notifikasi->caption());

            // jenis_kemasan
            $this->jenis_kemasan->EditAttrs["class"] = "form-control";
            $this->jenis_kemasan->EditCustomAttributes = "";
            if (!$this->jenis_kemasan->Raw) {
                $this->jenis_kemasan->CurrentValue = HtmlDecode($this->jenis_kemasan->CurrentValue);
            }
            $this->jenis_kemasan->EditValue = HtmlEncode($this->jenis_kemasan->CurrentValue);
            $this->jenis_kemasan->PlaceHolder = RemoveHtml($this->jenis_kemasan->caption());

            // posisi_label
            $this->posisi_label->EditAttrs["class"] = "form-control";
            $this->posisi_label->EditCustomAttributes = "";
            if (!$this->posisi_label->Raw) {
                $this->posisi_label->CurrentValue = HtmlDecode($this->posisi_label->CurrentValue);
            }
            $this->posisi_label->EditValue = HtmlEncode($this->posisi_label->CurrentValue);
            $this->posisi_label->PlaceHolder = RemoveHtml($this->posisi_label->caption());

            // bahan_label
            $this->bahan_label->EditAttrs["class"] = "form-control";
            $this->bahan_label->EditCustomAttributes = "";
            if (!$this->bahan_label->Raw) {
                $this->bahan_label->CurrentValue = HtmlDecode($this->bahan_label->CurrentValue);
            }
            $this->bahan_label->EditValue = HtmlEncode($this->bahan_label->CurrentValue);
            $this->bahan_label->PlaceHolder = RemoveHtml($this->bahan_label->caption());

            // draft_layout
            $this->draft_layout->EditAttrs["class"] = "form-control";
            $this->draft_layout->EditCustomAttributes = "";
            if (!$this->draft_layout->Raw) {
                $this->draft_layout->CurrentValue = HtmlDecode($this->draft_layout->CurrentValue);
            }
            $this->draft_layout->EditValue = HtmlEncode($this->draft_layout->CurrentValue);
            $this->draft_layout->PlaceHolder = RemoveHtml($this->draft_layout->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // submitted_by
            $this->submitted_by->EditAttrs["class"] = "form-control";
            $this->submitted_by->EditCustomAttributes = "";
            $this->submitted_by->EditValue = HtmlEncode($this->submitted_by->CurrentValue);
            $this->submitted_by->PlaceHolder = RemoveHtml($this->submitted_by->caption());

            // checked1_by
            $this->checked1_by->EditAttrs["class"] = "form-control";
            $this->checked1_by->EditCustomAttributes = "";
            $this->checked1_by->EditValue = HtmlEncode($this->checked1_by->CurrentValue);
            $this->checked1_by->PlaceHolder = RemoveHtml($this->checked1_by->caption());

            // checked2_by
            $this->checked2_by->EditAttrs["class"] = "form-control";
            $this->checked2_by->EditCustomAttributes = "";
            $this->checked2_by->EditValue = HtmlEncode($this->checked2_by->CurrentValue);
            $this->checked2_by->PlaceHolder = RemoveHtml($this->checked2_by->caption());

            // approved_by
            $this->approved_by->EditAttrs["class"] = "form-control";
            $this->approved_by->EditCustomAttributes = "";
            $this->approved_by->EditValue = HtmlEncode($this->approved_by->CurrentValue);
            $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // tglterima
            $this->tglterima->LinkCustomAttributes = "";
            $this->tglterima->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // nama_produk
            $this->nama_produk->LinkCustomAttributes = "";
            $this->nama_produk->HrefValue = "";

            // klaim_bahan
            $this->klaim_bahan->LinkCustomAttributes = "";
            $this->klaim_bahan->HrefValue = "";

            // campaign_produk
            $this->campaign_produk->LinkCustomAttributes = "";
            $this->campaign_produk->HrefValue = "";

            // konsepwarna
            $this->konsepwarna->LinkCustomAttributes = "";
            $this->konsepwarna->HrefValue = "";

            // no_notifikasi
            $this->no_notifikasi->LinkCustomAttributes = "";
            $this->no_notifikasi->HrefValue = "";

            // jenis_kemasan
            $this->jenis_kemasan->LinkCustomAttributes = "";
            $this->jenis_kemasan->HrefValue = "";

            // posisi_label
            $this->posisi_label->LinkCustomAttributes = "";
            $this->posisi_label->HrefValue = "";

            // bahan_label
            $this->bahan_label->LinkCustomAttributes = "";
            $this->bahan_label->HrefValue = "";

            // draft_layout
            $this->draft_layout->LinkCustomAttributes = "";
            $this->draft_layout->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";

            // submitted_by
            $this->submitted_by->LinkCustomAttributes = "";
            $this->submitted_by->HrefValue = "";

            // checked1_by
            $this->checked1_by->LinkCustomAttributes = "";
            $this->checked1_by->HrefValue = "";

            // checked2_by
            $this->checked2_by->LinkCustomAttributes = "";
            $this->checked2_by->HrefValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
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
        if (!CheckInteger($this->idnpd->FormValue)) {
            $this->idnpd->addErrorMessage($this->idnpd->getErrorMessage(false));
        }
        if ($this->tglterima->Required) {
            if (!$this->tglterima->IsDetailKey && EmptyValue($this->tglterima->FormValue)) {
                $this->tglterima->addErrorMessage(str_replace("%s", $this->tglterima->caption(), $this->tglterima->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglterima->FormValue)) {
            $this->tglterima->addErrorMessage($this->tglterima->getErrorMessage(false));
        }
        if ($this->tglsubmit->Required) {
            if (!$this->tglsubmit->IsDetailKey && EmptyValue($this->tglsubmit->FormValue)) {
                $this->tglsubmit->addErrorMessage(str_replace("%s", $this->tglsubmit->caption(), $this->tglsubmit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglsubmit->FormValue)) {
            $this->tglsubmit->addErrorMessage($this->tglsubmit->getErrorMessage(false));
        }
        if ($this->nama_produk->Required) {
            if (!$this->nama_produk->IsDetailKey && EmptyValue($this->nama_produk->FormValue)) {
                $this->nama_produk->addErrorMessage(str_replace("%s", $this->nama_produk->caption(), $this->nama_produk->RequiredErrorMessage));
            }
        }
        if ($this->klaim_bahan->Required) {
            if (!$this->klaim_bahan->IsDetailKey && EmptyValue($this->klaim_bahan->FormValue)) {
                $this->klaim_bahan->addErrorMessage(str_replace("%s", $this->klaim_bahan->caption(), $this->klaim_bahan->RequiredErrorMessage));
            }
        }
        if ($this->campaign_produk->Required) {
            if (!$this->campaign_produk->IsDetailKey && EmptyValue($this->campaign_produk->FormValue)) {
                $this->campaign_produk->addErrorMessage(str_replace("%s", $this->campaign_produk->caption(), $this->campaign_produk->RequiredErrorMessage));
            }
        }
        if ($this->konsepwarna->Required) {
            if (!$this->konsepwarna->IsDetailKey && EmptyValue($this->konsepwarna->FormValue)) {
                $this->konsepwarna->addErrorMessage(str_replace("%s", $this->konsepwarna->caption(), $this->konsepwarna->RequiredErrorMessage));
            }
        }
        if ($this->no_notifikasi->Required) {
            if (!$this->no_notifikasi->IsDetailKey && EmptyValue($this->no_notifikasi->FormValue)) {
                $this->no_notifikasi->addErrorMessage(str_replace("%s", $this->no_notifikasi->caption(), $this->no_notifikasi->RequiredErrorMessage));
            }
        }
        if ($this->jenis_kemasan->Required) {
            if (!$this->jenis_kemasan->IsDetailKey && EmptyValue($this->jenis_kemasan->FormValue)) {
                $this->jenis_kemasan->addErrorMessage(str_replace("%s", $this->jenis_kemasan->caption(), $this->jenis_kemasan->RequiredErrorMessage));
            }
        }
        if ($this->posisi_label->Required) {
            if (!$this->posisi_label->IsDetailKey && EmptyValue($this->posisi_label->FormValue)) {
                $this->posisi_label->addErrorMessage(str_replace("%s", $this->posisi_label->caption(), $this->posisi_label->RequiredErrorMessage));
            }
        }
        if ($this->bahan_label->Required) {
            if (!$this->bahan_label->IsDetailKey && EmptyValue($this->bahan_label->FormValue)) {
                $this->bahan_label->addErrorMessage(str_replace("%s", $this->bahan_label->caption(), $this->bahan_label->RequiredErrorMessage));
            }
        }
        if ($this->draft_layout->Required) {
            if (!$this->draft_layout->IsDetailKey && EmptyValue($this->draft_layout->FormValue)) {
                $this->draft_layout->addErrorMessage(str_replace("%s", $this->draft_layout->caption(), $this->draft_layout->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }
        if ($this->submitted_by->Required) {
            if (!$this->submitted_by->IsDetailKey && EmptyValue($this->submitted_by->FormValue)) {
                $this->submitted_by->addErrorMessage(str_replace("%s", $this->submitted_by->caption(), $this->submitted_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->submitted_by->FormValue)) {
            $this->submitted_by->addErrorMessage($this->submitted_by->getErrorMessage(false));
        }
        if ($this->checked1_by->Required) {
            if (!$this->checked1_by->IsDetailKey && EmptyValue($this->checked1_by->FormValue)) {
                $this->checked1_by->addErrorMessage(str_replace("%s", $this->checked1_by->caption(), $this->checked1_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->checked1_by->FormValue)) {
            $this->checked1_by->addErrorMessage($this->checked1_by->getErrorMessage(false));
        }
        if ($this->checked2_by->Required) {
            if (!$this->checked2_by->IsDetailKey && EmptyValue($this->checked2_by->FormValue)) {
                $this->checked2_by->addErrorMessage(str_replace("%s", $this->checked2_by->caption(), $this->checked2_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->checked2_by->FormValue)) {
            $this->checked2_by->addErrorMessage($this->checked2_by->getErrorMessage(false));
        }
        if ($this->approved_by->Required) {
            if (!$this->approved_by->IsDetailKey && EmptyValue($this->approved_by->FormValue)) {
                $this->approved_by->addErrorMessage(str_replace("%s", $this->approved_by->caption(), $this->approved_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->approved_by->FormValue)) {
            $this->approved_by->addErrorMessage($this->approved_by->getErrorMessage(false));
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->created_at->FormValue)) {
            $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
        }
        if ($this->updated_at->Required) {
            if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->updated_at->FormValue)) {
            $this->updated_at->addErrorMessage($this->updated_at->getErrorMessage(false));
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
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, null, false);

        // tglterima
        $this->tglterima->setDbValueDef($rsnew, UnFormatDateTime($this->tglterima->CurrentValue, 0), null, false);

        // tglsubmit
        $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), null, false);

        // nama_produk
        $this->nama_produk->setDbValueDef($rsnew, $this->nama_produk->CurrentValue, null, false);

        // klaim_bahan
        $this->klaim_bahan->setDbValueDef($rsnew, $this->klaim_bahan->CurrentValue, null, false);

        // campaign_produk
        $this->campaign_produk->setDbValueDef($rsnew, $this->campaign_produk->CurrentValue, null, false);

        // konsepwarna
        $this->konsepwarna->setDbValueDef($rsnew, $this->konsepwarna->CurrentValue, null, false);

        // no_notifikasi
        $this->no_notifikasi->setDbValueDef($rsnew, $this->no_notifikasi->CurrentValue, null, false);

        // jenis_kemasan
        $this->jenis_kemasan->setDbValueDef($rsnew, $this->jenis_kemasan->CurrentValue, null, false);

        // posisi_label
        $this->posisi_label->setDbValueDef($rsnew, $this->posisi_label->CurrentValue, null, false);

        // bahan_label
        $this->bahan_label->setDbValueDef($rsnew, $this->bahan_label->CurrentValue, null, false);

        // draft_layout
        $this->draft_layout->setDbValueDef($rsnew, $this->draft_layout->CurrentValue, null, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, false);

        // submitted_by
        $this->submitted_by->setDbValueDef($rsnew, $this->submitted_by->CurrentValue, null, false);

        // checked1_by
        $this->checked1_by->setDbValueDef($rsnew, $this->checked1_by->CurrentValue, null, false);

        // checked2_by
        $this->checked2_by->setDbValueDef($rsnew, $this->checked2_by->CurrentValue, null, false);

        // approved_by
        $this->approved_by->setDbValueDef($rsnew, $this->approved_by->CurrentValue, null, false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), CurrentDate(), false);

        // updated_at
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), CurrentDate(), false);

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
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdDesainList"), "", $this->TableVar, true);
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
