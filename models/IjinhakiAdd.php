<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class IjinhakiAdd extends Ijinhaki
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'ijinhaki';

    // Page object name
    public $PageObjName = "IjinhakiAdd";

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

        // Table object (ijinhaki)
        if (!isset($GLOBALS["ijinhaki"]) || get_class($GLOBALS["ijinhaki"]) == PROJECT_NAMESPACE . "ijinhaki") {
            $GLOBALS["ijinhaki"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'ijinhaki');
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
                $doc = new $class(Container("ijinhaki"));
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
                    if ($pageName == "IjinhakiView") {
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
        $this->ktp->setVisibility();
        $this->npwp->setVisibility();
        $this->nib->setVisibility();
        $this->akta_pendirian->setVisibility();
        $this->sk_umk->setVisibility();
        $this->ttd_pemohon->setVisibility();
        $this->nama_brand->setVisibility();
        $this->label_brand->setVisibility();
        $this->deskripsi_brand->setVisibility();
        $this->unsur_brand->setVisibility();
        $this->submitted_by->setVisibility();
        $this->checked1_by->setVisibility();
        $this->checked2_by->setVisibility();
        $this->approved_by->setVisibility();
        $this->status->setVisibility();
        $this->selesai->Visible = false;
        $this->created_at->Visible = false;
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
        $this->setupLookupOptions($this->submitted_by);
        $this->setupLookupOptions($this->checked1_by);
        $this->setupLookupOptions($this->checked2_by);
        $this->setupLookupOptions($this->approved_by);

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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("IjinhakiList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "IjinhakiList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "IjinhakiView") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->akta_pendirian->Upload->Index = $CurrentForm->Index;
        $this->akta_pendirian->Upload->uploadFile();
        $this->akta_pendirian->CurrentValue = $this->akta_pendirian->Upload->FileName;
        $this->ttd_pemohon->Upload->Index = $CurrentForm->Index;
        $this->ttd_pemohon->Upload->uploadFile();
        $this->ttd_pemohon->CurrentValue = $this->ttd_pemohon->Upload->FileName;
        $this->label_brand->Upload->Index = $CurrentForm->Index;
        $this->label_brand->Upload->uploadFile();
        $this->label_brand->CurrentValue = $this->label_brand->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->idnpd->CurrentValue = null;
        $this->idnpd->OldValue = $this->idnpd->CurrentValue;
        $this->tglterima->CurrentValue = CurrentDate();
        $this->tglsubmit->CurrentValue = CurrentDate();
        $this->ktp->CurrentValue = null;
        $this->ktp->OldValue = $this->ktp->CurrentValue;
        $this->npwp->CurrentValue = null;
        $this->npwp->OldValue = $this->npwp->CurrentValue;
        $this->nib->CurrentValue = null;
        $this->nib->OldValue = $this->nib->CurrentValue;
        $this->akta_pendirian->Upload->DbValue = null;
        $this->akta_pendirian->OldValue = $this->akta_pendirian->Upload->DbValue;
        $this->akta_pendirian->CurrentValue = null; // Clear file related field
        $this->sk_umk->CurrentValue = null;
        $this->sk_umk->OldValue = $this->sk_umk->CurrentValue;
        $this->ttd_pemohon->Upload->DbValue = null;
        $this->ttd_pemohon->OldValue = $this->ttd_pemohon->Upload->DbValue;
        $this->ttd_pemohon->CurrentValue = null; // Clear file related field
        $this->nama_brand->CurrentValue = null;
        $this->nama_brand->OldValue = $this->nama_brand->CurrentValue;
        $this->label_brand->Upload->DbValue = null;
        $this->label_brand->OldValue = $this->label_brand->Upload->DbValue;
        $this->label_brand->CurrentValue = null; // Clear file related field
        $this->deskripsi_brand->CurrentValue = null;
        $this->deskripsi_brand->OldValue = $this->deskripsi_brand->CurrentValue;
        $this->unsur_brand->CurrentValue = null;
        $this->unsur_brand->OldValue = $this->unsur_brand->CurrentValue;
        $this->submitted_by->CurrentValue = null;
        $this->submitted_by->OldValue = $this->submitted_by->CurrentValue;
        $this->checked1_by->CurrentValue = null;
        $this->checked1_by->OldValue = $this->checked1_by->CurrentValue;
        $this->checked2_by->CurrentValue = null;
        $this->checked2_by->OldValue = $this->checked2_by->CurrentValue;
        $this->approved_by->CurrentValue = null;
        $this->approved_by->OldValue = $this->approved_by->CurrentValue;
        $this->status->CurrentValue = 'Baru';
        $this->selesai->CurrentValue = null;
        $this->selesai->OldValue = $this->selesai->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->readonly->CurrentValue = null;
        $this->readonly->OldValue = $this->readonly->CurrentValue;
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

        // Check field name 'ktp' first before field var 'x_ktp'
        $val = $CurrentForm->hasValue("ktp") ? $CurrentForm->getValue("ktp") : $CurrentForm->getValue("x_ktp");
        if (!$this->ktp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ktp->Visible = false; // Disable update for API request
            } else {
                $this->ktp->setFormValue($val);
            }
        }

        // Check field name 'npwp' first before field var 'x_npwp'
        $val = $CurrentForm->hasValue("npwp") ? $CurrentForm->getValue("npwp") : $CurrentForm->getValue("x_npwp");
        if (!$this->npwp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->npwp->Visible = false; // Disable update for API request
            } else {
                $this->npwp->setFormValue($val);
            }
        }

        // Check field name 'nib' first before field var 'x_nib'
        $val = $CurrentForm->hasValue("nib") ? $CurrentForm->getValue("nib") : $CurrentForm->getValue("x_nib");
        if (!$this->nib->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nib->Visible = false; // Disable update for API request
            } else {
                $this->nib->setFormValue($val);
            }
        }

        // Check field name 'sk_umk' first before field var 'x_sk_umk'
        $val = $CurrentForm->hasValue("sk_umk") ? $CurrentForm->getValue("sk_umk") : $CurrentForm->getValue("x_sk_umk");
        if (!$this->sk_umk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sk_umk->Visible = false; // Disable update for API request
            } else {
                $this->sk_umk->setFormValue($val);
            }
        }

        // Check field name 'nama_brand' first before field var 'x_nama_brand'
        $val = $CurrentForm->hasValue("nama_brand") ? $CurrentForm->getValue("nama_brand") : $CurrentForm->getValue("x_nama_brand");
        if (!$this->nama_brand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_brand->Visible = false; // Disable update for API request
            } else {
                $this->nama_brand->setFormValue($val);
            }
        }

        // Check field name 'deskripsi_brand' first before field var 'x_deskripsi_brand'
        $val = $CurrentForm->hasValue("deskripsi_brand") ? $CurrentForm->getValue("deskripsi_brand") : $CurrentForm->getValue("x_deskripsi_brand");
        if (!$this->deskripsi_brand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deskripsi_brand->Visible = false; // Disable update for API request
            } else {
                $this->deskripsi_brand->setFormValue($val);
            }
        }

        // Check field name 'unsur_brand' first before field var 'x_unsur_brand'
        $val = $CurrentForm->hasValue("unsur_brand") ? $CurrentForm->getValue("unsur_brand") : $CurrentForm->getValue("x_unsur_brand");
        if (!$this->unsur_brand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unsur_brand->Visible = false; // Disable update for API request
            } else {
                $this->unsur_brand->setFormValue($val);
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

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
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
        $this->tglterima->CurrentValue = $this->tglterima->FormValue;
        $this->tglterima->CurrentValue = UnFormatDateTime($this->tglterima->CurrentValue, 0);
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        $this->ktp->CurrentValue = $this->ktp->FormValue;
        $this->npwp->CurrentValue = $this->npwp->FormValue;
        $this->nib->CurrentValue = $this->nib->FormValue;
        $this->sk_umk->CurrentValue = $this->sk_umk->FormValue;
        $this->nama_brand->CurrentValue = $this->nama_brand->FormValue;
        $this->deskripsi_brand->CurrentValue = $this->deskripsi_brand->FormValue;
        $this->unsur_brand->CurrentValue = $this->unsur_brand->FormValue;
        $this->submitted_by->CurrentValue = $this->submitted_by->FormValue;
        $this->checked1_by->CurrentValue = $this->checked1_by->FormValue;
        $this->checked2_by->CurrentValue = $this->checked2_by->FormValue;
        $this->approved_by->CurrentValue = $this->approved_by->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
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
        $this->ktp->setDbValue($row['ktp']);
        $this->npwp->setDbValue($row['npwp']);
        $this->nib->setDbValue($row['nib']);
        $this->akta_pendirian->Upload->DbValue = $row['akta_pendirian'];
        $this->akta_pendirian->setDbValue($this->akta_pendirian->Upload->DbValue);
        $this->sk_umk->setDbValue($row['sk_umk']);
        $this->ttd_pemohon->Upload->DbValue = $row['ttd_pemohon'];
        $this->ttd_pemohon->setDbValue($this->ttd_pemohon->Upload->DbValue);
        $this->nama_brand->setDbValue($row['nama_brand']);
        $this->label_brand->Upload->DbValue = $row['label_brand'];
        $this->label_brand->setDbValue($this->label_brand->Upload->DbValue);
        $this->deskripsi_brand->setDbValue($row['deskripsi_brand']);
        $this->unsur_brand->setDbValue($row['unsur_brand']);
        $this->submitted_by->setDbValue($row['submitted_by']);
        $this->checked1_by->setDbValue($row['checked1_by']);
        $this->checked2_by->setDbValue($row['checked2_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->status->setDbValue($row['status']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
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
        $row['ktp'] = $this->ktp->CurrentValue;
        $row['npwp'] = $this->npwp->CurrentValue;
        $row['nib'] = $this->nib->CurrentValue;
        $row['akta_pendirian'] = $this->akta_pendirian->Upload->DbValue;
        $row['sk_umk'] = $this->sk_umk->CurrentValue;
        $row['ttd_pemohon'] = $this->ttd_pemohon->Upload->DbValue;
        $row['nama_brand'] = $this->nama_brand->CurrentValue;
        $row['label_brand'] = $this->label_brand->Upload->DbValue;
        $row['deskripsi_brand'] = $this->deskripsi_brand->CurrentValue;
        $row['unsur_brand'] = $this->unsur_brand->CurrentValue;
        $row['submitted_by'] = $this->submitted_by->CurrentValue;
        $row['checked1_by'] = $this->checked1_by->CurrentValue;
        $row['checked2_by'] = $this->checked2_by->CurrentValue;
        $row['approved_by'] = $this->approved_by->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['selesai'] = $this->selesai->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
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

        // tglterima

        // tglsubmit

        // ktp

        // npwp

        // nib

        // akta_pendirian

        // sk_umk

        // ttd_pemohon

        // nama_brand

        // label_brand

        // deskripsi_brand

        // unsur_brand

        // submitted_by

        // checked1_by

        // checked2_by

        // approved_by

        // status

        // selesai

        // created_at

        // readonly
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
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

            // tglterima
            $this->tglterima->ViewValue = $this->tglterima->CurrentValue;
            $this->tglterima->ViewValue = FormatDateTime($this->tglterima->ViewValue, 0);
            $this->tglterima->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

            // ktp
            $this->ktp->ViewValue = $this->ktp->CurrentValue;
            $this->ktp->ViewCustomAttributes = "";

            // npwp
            $this->npwp->ViewValue = $this->npwp->CurrentValue;
            $this->npwp->ViewCustomAttributes = "";

            // nib
            $this->nib->ViewValue = $this->nib->CurrentValue;
            $this->nib->ViewCustomAttributes = "";

            // akta_pendirian
            if (!EmptyValue($this->akta_pendirian->Upload->DbValue)) {
                $this->akta_pendirian->ViewValue = $this->akta_pendirian->Upload->DbValue;
            } else {
                $this->akta_pendirian->ViewValue = "";
            }
            $this->akta_pendirian->ViewCustomAttributes = "";

            // sk_umk
            $this->sk_umk->ViewValue = $this->sk_umk->CurrentValue;
            $this->sk_umk->ViewCustomAttributes = "";

            // ttd_pemohon
            if (!EmptyValue($this->ttd_pemohon->Upload->DbValue)) {
                $this->ttd_pemohon->ViewValue = $this->ttd_pemohon->Upload->DbValue;
            } else {
                $this->ttd_pemohon->ViewValue = "";
            }
            $this->ttd_pemohon->ViewCustomAttributes = "";

            // nama_brand
            $this->nama_brand->ViewValue = $this->nama_brand->CurrentValue;
            $this->nama_brand->ViewCustomAttributes = "";

            // label_brand
            if (!EmptyValue($this->label_brand->Upload->DbValue)) {
                $this->label_brand->ViewValue = $this->label_brand->Upload->DbValue;
            } else {
                $this->label_brand->ViewValue = "";
            }
            $this->label_brand->ViewCustomAttributes = "";

            // deskripsi_brand
            $this->deskripsi_brand->ViewValue = $this->deskripsi_brand->CurrentValue;
            $this->deskripsi_brand->ViewCustomAttributes = "";

            // unsur_brand
            $this->unsur_brand->ViewValue = $this->unsur_brand->CurrentValue;
            $this->unsur_brand->ViewCustomAttributes = "";

            // submitted_by
            $curVal = trim(strval($this->submitted_by->CurrentValue));
            if ($curVal != "") {
                $this->submitted_by->ViewValue = $this->submitted_by->lookupCacheOption($curVal);
                if ($this->submitted_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->submitted_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->submitted_by->Lookup->renderViewRow($rswrk[0]);
                        $this->submitted_by->ViewValue = $this->submitted_by->displayValue($arwrk);
                    } else {
                        $this->submitted_by->ViewValue = $this->submitted_by->CurrentValue;
                    }
                }
            } else {
                $this->submitted_by->ViewValue = null;
            }
            $this->submitted_by->ViewCustomAttributes = "";

            // checked1_by
            $curVal = trim(strval($this->checked1_by->CurrentValue));
            if ($curVal != "") {
                $this->checked1_by->ViewValue = $this->checked1_by->lookupCacheOption($curVal);
                if ($this->checked1_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->checked1_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->checked1_by->Lookup->renderViewRow($rswrk[0]);
                        $this->checked1_by->ViewValue = $this->checked1_by->displayValue($arwrk);
                    } else {
                        $this->checked1_by->ViewValue = $this->checked1_by->CurrentValue;
                    }
                }
            } else {
                $this->checked1_by->ViewValue = null;
            }
            $this->checked1_by->ViewCustomAttributes = "";

            // checked2_by
            $curVal = trim(strval($this->checked2_by->CurrentValue));
            if ($curVal != "") {
                $this->checked2_by->ViewValue = $this->checked2_by->lookupCacheOption($curVal);
                if ($this->checked2_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->checked2_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->checked2_by->Lookup->renderViewRow($rswrk[0]);
                        $this->checked2_by->ViewValue = $this->checked2_by->displayValue($arwrk);
                    } else {
                        $this->checked2_by->ViewValue = $this->checked2_by->CurrentValue;
                    }
                }
            } else {
                $this->checked2_by->ViewValue = null;
            }
            $this->checked2_by->ViewCustomAttributes = "";

            // approved_by
            $curVal = trim(strval($this->approved_by->CurrentValue));
            if ($curVal != "") {
                $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
                if ($this->approved_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->approved_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->approved_by->Lookup->renderViewRow($rswrk[0]);
                        $this->approved_by->ViewValue = $this->approved_by->displayValue($arwrk);
                    } else {
                        $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
                    }
                }
            } else {
                $this->approved_by->ViewValue = null;
            }
            $this->approved_by->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

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

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            $this->ktp->HrefValue = "";
            $this->ktp->TooltipValue = "";

            // npwp
            $this->npwp->LinkCustomAttributes = "";
            $this->npwp->HrefValue = "";
            $this->npwp->TooltipValue = "";

            // nib
            $this->nib->LinkCustomAttributes = "";
            $this->nib->HrefValue = "";
            $this->nib->TooltipValue = "";

            // akta_pendirian
            $this->akta_pendirian->LinkCustomAttributes = "";
            $this->akta_pendirian->HrefValue = "";
            $this->akta_pendirian->ExportHrefValue = $this->akta_pendirian->UploadPath . $this->akta_pendirian->Upload->DbValue;
            $this->akta_pendirian->TooltipValue = "";

            // sk_umk
            $this->sk_umk->LinkCustomAttributes = "";
            $this->sk_umk->HrefValue = "";
            $this->sk_umk->TooltipValue = "";

            // ttd_pemohon
            $this->ttd_pemohon->LinkCustomAttributes = "";
            $this->ttd_pemohon->HrefValue = "";
            $this->ttd_pemohon->ExportHrefValue = $this->ttd_pemohon->UploadPath . $this->ttd_pemohon->Upload->DbValue;
            $this->ttd_pemohon->TooltipValue = "";

            // nama_brand
            $this->nama_brand->LinkCustomAttributes = "";
            $this->nama_brand->HrefValue = "";
            $this->nama_brand->TooltipValue = "";

            // label_brand
            $this->label_brand->LinkCustomAttributes = "";
            $this->label_brand->HrefValue = "";
            $this->label_brand->ExportHrefValue = $this->label_brand->UploadPath . $this->label_brand->Upload->DbValue;
            $this->label_brand->TooltipValue = "";

            // deskripsi_brand
            $this->deskripsi_brand->LinkCustomAttributes = "";
            $this->deskripsi_brand->HrefValue = "";
            $this->deskripsi_brand->TooltipValue = "";

            // unsur_brand
            $this->unsur_brand->LinkCustomAttributes = "";
            $this->unsur_brand->HrefValue = "";
            $this->unsur_brand->TooltipValue = "";

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

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
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
                $this->idnpd->EditValue = $arwrk;
            }
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

            // ktp
            $this->ktp->EditAttrs["class"] = "form-control";
            $this->ktp->EditCustomAttributes = "";
            if (!$this->ktp->Raw) {
                $this->ktp->CurrentValue = HtmlDecode($this->ktp->CurrentValue);
            }
            $this->ktp->EditValue = HtmlEncode($this->ktp->CurrentValue);
            $this->ktp->PlaceHolder = RemoveHtml($this->ktp->caption());

            // npwp
            $this->npwp->EditAttrs["class"] = "form-control";
            $this->npwp->EditCustomAttributes = "";
            if (!$this->npwp->Raw) {
                $this->npwp->CurrentValue = HtmlDecode($this->npwp->CurrentValue);
            }
            $this->npwp->EditValue = HtmlEncode($this->npwp->CurrentValue);
            $this->npwp->PlaceHolder = RemoveHtml($this->npwp->caption());

            // nib
            $this->nib->EditAttrs["class"] = "form-control";
            $this->nib->EditCustomAttributes = "";
            if (!$this->nib->Raw) {
                $this->nib->CurrentValue = HtmlDecode($this->nib->CurrentValue);
            }
            $this->nib->EditValue = HtmlEncode($this->nib->CurrentValue);
            $this->nib->PlaceHolder = RemoveHtml($this->nib->caption());

            // akta_pendirian
            $this->akta_pendirian->EditAttrs["class"] = "form-control";
            $this->akta_pendirian->EditCustomAttributes = "";
            if (!EmptyValue($this->akta_pendirian->Upload->DbValue)) {
                $this->akta_pendirian->EditValue = $this->akta_pendirian->Upload->DbValue;
            } else {
                $this->akta_pendirian->EditValue = "";
            }
            if (!EmptyValue($this->akta_pendirian->CurrentValue)) {
                $this->akta_pendirian->Upload->FileName = $this->akta_pendirian->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->akta_pendirian);
            }

            // sk_umk
            $this->sk_umk->EditAttrs["class"] = "form-control";
            $this->sk_umk->EditCustomAttributes = "";
            if (!$this->sk_umk->Raw) {
                $this->sk_umk->CurrentValue = HtmlDecode($this->sk_umk->CurrentValue);
            }
            $this->sk_umk->EditValue = HtmlEncode($this->sk_umk->CurrentValue);
            $this->sk_umk->PlaceHolder = RemoveHtml($this->sk_umk->caption());

            // ttd_pemohon
            $this->ttd_pemohon->EditAttrs["class"] = "form-control";
            $this->ttd_pemohon->EditCustomAttributes = "";
            if (!EmptyValue($this->ttd_pemohon->Upload->DbValue)) {
                $this->ttd_pemohon->EditValue = $this->ttd_pemohon->Upload->DbValue;
            } else {
                $this->ttd_pemohon->EditValue = "";
            }
            if (!EmptyValue($this->ttd_pemohon->CurrentValue)) {
                $this->ttd_pemohon->Upload->FileName = $this->ttd_pemohon->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->ttd_pemohon);
            }

            // nama_brand
            $this->nama_brand->EditAttrs["class"] = "form-control";
            $this->nama_brand->EditCustomAttributes = "";
            if (!$this->nama_brand->Raw) {
                $this->nama_brand->CurrentValue = HtmlDecode($this->nama_brand->CurrentValue);
            }
            $this->nama_brand->EditValue = HtmlEncode($this->nama_brand->CurrentValue);
            $this->nama_brand->PlaceHolder = RemoveHtml($this->nama_brand->caption());

            // label_brand
            $this->label_brand->EditAttrs["class"] = "form-control";
            $this->label_brand->EditCustomAttributes = "";
            if (!EmptyValue($this->label_brand->Upload->DbValue)) {
                $this->label_brand->EditValue = $this->label_brand->Upload->DbValue;
            } else {
                $this->label_brand->EditValue = "";
            }
            if (!EmptyValue($this->label_brand->CurrentValue)) {
                $this->label_brand->Upload->FileName = $this->label_brand->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->label_brand);
            }

            // deskripsi_brand
            $this->deskripsi_brand->EditAttrs["class"] = "form-control";
            $this->deskripsi_brand->EditCustomAttributes = "";
            $this->deskripsi_brand->EditValue = HtmlEncode($this->deskripsi_brand->CurrentValue);
            $this->deskripsi_brand->PlaceHolder = RemoveHtml($this->deskripsi_brand->caption());

            // unsur_brand
            $this->unsur_brand->EditAttrs["class"] = "form-control";
            $this->unsur_brand->EditCustomAttributes = "";
            if (!$this->unsur_brand->Raw) {
                $this->unsur_brand->CurrentValue = HtmlDecode($this->unsur_brand->CurrentValue);
            }
            $this->unsur_brand->EditValue = HtmlEncode($this->unsur_brand->CurrentValue);
            $this->unsur_brand->PlaceHolder = RemoveHtml($this->unsur_brand->caption());

            // submitted_by
            $this->submitted_by->EditAttrs["class"] = "form-control";
            $this->submitted_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->submitted_by->CurrentValue));
            if ($curVal != "") {
                $this->submitted_by->ViewValue = $this->submitted_by->lookupCacheOption($curVal);
            } else {
                $this->submitted_by->ViewValue = $this->submitted_by->Lookup !== null && is_array($this->submitted_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->submitted_by->ViewValue !== null) { // Load from cache
                $this->submitted_by->EditValue = array_values($this->submitted_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->submitted_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->submitted_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->submitted_by->EditValue = $arwrk;
            }
            $this->submitted_by->PlaceHolder = RemoveHtml($this->submitted_by->caption());

            // checked1_by
            $this->checked1_by->EditAttrs["class"] = "form-control";
            $this->checked1_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->checked1_by->CurrentValue));
            if ($curVal != "") {
                $this->checked1_by->ViewValue = $this->checked1_by->lookupCacheOption($curVal);
            } else {
                $this->checked1_by->ViewValue = $this->checked1_by->Lookup !== null && is_array($this->checked1_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->checked1_by->ViewValue !== null) { // Load from cache
                $this->checked1_by->EditValue = array_values($this->checked1_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->checked1_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->checked1_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->checked1_by->EditValue = $arwrk;
            }
            $this->checked1_by->PlaceHolder = RemoveHtml($this->checked1_by->caption());

            // checked2_by
            $this->checked2_by->EditAttrs["class"] = "form-control";
            $this->checked2_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->checked2_by->CurrentValue));
            if ($curVal != "") {
                $this->checked2_by->ViewValue = $this->checked2_by->lookupCacheOption($curVal);
            } else {
                $this->checked2_by->ViewValue = $this->checked2_by->Lookup !== null && is_array($this->checked2_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->checked2_by->ViewValue !== null) { // Load from cache
                $this->checked2_by->EditValue = array_values($this->checked2_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->checked2_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->checked2_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->checked2_by->EditValue = $arwrk;
            }
            $this->checked2_by->PlaceHolder = RemoveHtml($this->checked2_by->caption());

            // approved_by
            $this->approved_by->EditAttrs["class"] = "form-control";
            $this->approved_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->approved_by->CurrentValue));
            if ($curVal != "") {
                $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
            } else {
                $this->approved_by->ViewValue = $this->approved_by->Lookup !== null && is_array($this->approved_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->approved_by->ViewValue !== null) { // Load from cache
                $this->approved_by->EditValue = array_values($this->approved_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->approved_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->approved_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->approved_by->EditValue = $arwrk;
            }
            $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(true);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

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

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            $this->ktp->HrefValue = "";

            // npwp
            $this->npwp->LinkCustomAttributes = "";
            $this->npwp->HrefValue = "";

            // nib
            $this->nib->LinkCustomAttributes = "";
            $this->nib->HrefValue = "";

            // akta_pendirian
            $this->akta_pendirian->LinkCustomAttributes = "";
            $this->akta_pendirian->HrefValue = "";
            $this->akta_pendirian->ExportHrefValue = $this->akta_pendirian->UploadPath . $this->akta_pendirian->Upload->DbValue;

            // sk_umk
            $this->sk_umk->LinkCustomAttributes = "";
            $this->sk_umk->HrefValue = "";

            // ttd_pemohon
            $this->ttd_pemohon->LinkCustomAttributes = "";
            $this->ttd_pemohon->HrefValue = "";
            $this->ttd_pemohon->ExportHrefValue = $this->ttd_pemohon->UploadPath . $this->ttd_pemohon->Upload->DbValue;

            // nama_brand
            $this->nama_brand->LinkCustomAttributes = "";
            $this->nama_brand->HrefValue = "";

            // label_brand
            $this->label_brand->LinkCustomAttributes = "";
            $this->label_brand->HrefValue = "";
            $this->label_brand->ExportHrefValue = $this->label_brand->UploadPath . $this->label_brand->Upload->DbValue;

            // deskripsi_brand
            $this->deskripsi_brand->LinkCustomAttributes = "";
            $this->deskripsi_brand->HrefValue = "";

            // unsur_brand
            $this->unsur_brand->LinkCustomAttributes = "";
            $this->unsur_brand->HrefValue = "";

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

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
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
        if ($this->ktp->Required) {
            if (!$this->ktp->IsDetailKey && EmptyValue($this->ktp->FormValue)) {
                $this->ktp->addErrorMessage(str_replace("%s", $this->ktp->caption(), $this->ktp->RequiredErrorMessage));
            }
        }
        if ($this->npwp->Required) {
            if (!$this->npwp->IsDetailKey && EmptyValue($this->npwp->FormValue)) {
                $this->npwp->addErrorMessage(str_replace("%s", $this->npwp->caption(), $this->npwp->RequiredErrorMessage));
            }
        }
        if ($this->nib->Required) {
            if (!$this->nib->IsDetailKey && EmptyValue($this->nib->FormValue)) {
                $this->nib->addErrorMessage(str_replace("%s", $this->nib->caption(), $this->nib->RequiredErrorMessage));
            }
        }
        if ($this->akta_pendirian->Required) {
            if ($this->akta_pendirian->Upload->FileName == "" && !$this->akta_pendirian->Upload->KeepFile) {
                $this->akta_pendirian->addErrorMessage(str_replace("%s", $this->akta_pendirian->caption(), $this->akta_pendirian->RequiredErrorMessage));
            }
        }
        if ($this->sk_umk->Required) {
            if (!$this->sk_umk->IsDetailKey && EmptyValue($this->sk_umk->FormValue)) {
                $this->sk_umk->addErrorMessage(str_replace("%s", $this->sk_umk->caption(), $this->sk_umk->RequiredErrorMessage));
            }
        }
        if ($this->ttd_pemohon->Required) {
            if ($this->ttd_pemohon->Upload->FileName == "" && !$this->ttd_pemohon->Upload->KeepFile) {
                $this->ttd_pemohon->addErrorMessage(str_replace("%s", $this->ttd_pemohon->caption(), $this->ttd_pemohon->RequiredErrorMessage));
            }
        }
        if ($this->nama_brand->Required) {
            if (!$this->nama_brand->IsDetailKey && EmptyValue($this->nama_brand->FormValue)) {
                $this->nama_brand->addErrorMessage(str_replace("%s", $this->nama_brand->caption(), $this->nama_brand->RequiredErrorMessage));
            }
        }
        if ($this->label_brand->Required) {
            if ($this->label_brand->Upload->FileName == "" && !$this->label_brand->Upload->KeepFile) {
                $this->label_brand->addErrorMessage(str_replace("%s", $this->label_brand->caption(), $this->label_brand->RequiredErrorMessage));
            }
        }
        if ($this->deskripsi_brand->Required) {
            if (!$this->deskripsi_brand->IsDetailKey && EmptyValue($this->deskripsi_brand->FormValue)) {
                $this->deskripsi_brand->addErrorMessage(str_replace("%s", $this->deskripsi_brand->caption(), $this->deskripsi_brand->RequiredErrorMessage));
            }
        }
        if ($this->unsur_brand->Required) {
            if (!$this->unsur_brand->IsDetailKey && EmptyValue($this->unsur_brand->FormValue)) {
                $this->unsur_brand->addErrorMessage(str_replace("%s", $this->unsur_brand->caption(), $this->unsur_brand->RequiredErrorMessage));
            }
        }
        if ($this->submitted_by->Required) {
            if (!$this->submitted_by->IsDetailKey && EmptyValue($this->submitted_by->FormValue)) {
                $this->submitted_by->addErrorMessage(str_replace("%s", $this->submitted_by->caption(), $this->submitted_by->RequiredErrorMessage));
            }
        }
        if ($this->checked1_by->Required) {
            if (!$this->checked1_by->IsDetailKey && EmptyValue($this->checked1_by->FormValue)) {
                $this->checked1_by->addErrorMessage(str_replace("%s", $this->checked1_by->caption(), $this->checked1_by->RequiredErrorMessage));
            }
        }
        if ($this->checked2_by->Required) {
            if (!$this->checked2_by->IsDetailKey && EmptyValue($this->checked2_by->FormValue)) {
                $this->checked2_by->addErrorMessage(str_replace("%s", $this->checked2_by->caption(), $this->checked2_by->RequiredErrorMessage));
            }
        }
        if ($this->approved_by->Required) {
            if (!$this->approved_by->IsDetailKey && EmptyValue($this->approved_by->FormValue)) {
                $this->approved_by->addErrorMessage(str_replace("%s", $this->approved_by->caption(), $this->approved_by->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("IjinhakiStatusGrid");
        if (in_array("ijinhaki_status", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, false);

        // tglterima
        $this->tglterima->setDbValueDef($rsnew, UnFormatDateTime($this->tglterima->CurrentValue, 0), null, false);

        // tglsubmit
        $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), null, false);

        // ktp
        $this->ktp->setDbValueDef($rsnew, $this->ktp->CurrentValue, null, false);

        // npwp
        $this->npwp->setDbValueDef($rsnew, $this->npwp->CurrentValue, null, false);

        // nib
        $this->nib->setDbValueDef($rsnew, $this->nib->CurrentValue, null, false);

        // akta_pendirian
        if ($this->akta_pendirian->Visible && !$this->akta_pendirian->Upload->KeepFile) {
            $this->akta_pendirian->Upload->DbValue = ""; // No need to delete old file
            if ($this->akta_pendirian->Upload->FileName == "") {
                $rsnew['akta_pendirian'] = null;
            } else {
                $rsnew['akta_pendirian'] = $this->akta_pendirian->Upload->FileName;
            }
        }

        // sk_umk
        $this->sk_umk->setDbValueDef($rsnew, $this->sk_umk->CurrentValue, null, false);

        // ttd_pemohon
        if ($this->ttd_pemohon->Visible && !$this->ttd_pemohon->Upload->KeepFile) {
            $this->ttd_pemohon->Upload->DbValue = ""; // No need to delete old file
            if ($this->ttd_pemohon->Upload->FileName == "") {
                $rsnew['ttd_pemohon'] = null;
            } else {
                $rsnew['ttd_pemohon'] = $this->ttd_pemohon->Upload->FileName;
            }
        }

        // nama_brand
        $this->nama_brand->setDbValueDef($rsnew, $this->nama_brand->CurrentValue, "", false);

        // label_brand
        if ($this->label_brand->Visible && !$this->label_brand->Upload->KeepFile) {
            $this->label_brand->Upload->DbValue = ""; // No need to delete old file
            if ($this->label_brand->Upload->FileName == "") {
                $rsnew['label_brand'] = null;
            } else {
                $rsnew['label_brand'] = $this->label_brand->Upload->FileName;
            }
        }

        // deskripsi_brand
        $this->deskripsi_brand->setDbValueDef($rsnew, $this->deskripsi_brand->CurrentValue, null, false);

        // unsur_brand
        $this->unsur_brand->setDbValueDef($rsnew, $this->unsur_brand->CurrentValue, null, false);

        // submitted_by
        $this->submitted_by->setDbValueDef($rsnew, $this->submitted_by->CurrentValue, null, false);

        // checked1_by
        $this->checked1_by->setDbValueDef($rsnew, $this->checked1_by->CurrentValue, null, false);

        // checked2_by
        $this->checked2_by->setDbValueDef($rsnew, $this->checked2_by->CurrentValue, null, false);

        // approved_by
        $this->approved_by->setDbValueDef($rsnew, $this->approved_by->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", false);
        if ($this->akta_pendirian->Visible && !$this->akta_pendirian->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->akta_pendirian->Upload->DbValue) ? [] : [$this->akta_pendirian->htmlDecode($this->akta_pendirian->Upload->DbValue)];
            if (!EmptyValue($this->akta_pendirian->Upload->FileName)) {
                $newFiles = [$this->akta_pendirian->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->akta_pendirian, $this->akta_pendirian->Upload->Index);
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
                            $file1 = UniqueFilename($this->akta_pendirian->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->akta_pendirian->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->akta_pendirian->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->akta_pendirian->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->akta_pendirian->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->akta_pendirian->setDbValueDef($rsnew, $this->akta_pendirian->Upload->FileName, null, false);
            }
        }
        if ($this->ttd_pemohon->Visible && !$this->ttd_pemohon->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->ttd_pemohon->Upload->DbValue) ? [] : [$this->ttd_pemohon->htmlDecode($this->ttd_pemohon->Upload->DbValue)];
            if (!EmptyValue($this->ttd_pemohon->Upload->FileName)) {
                $newFiles = [$this->ttd_pemohon->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->ttd_pemohon, $this->ttd_pemohon->Upload->Index);
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
                            $file1 = UniqueFilename($this->ttd_pemohon->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->ttd_pemohon->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->ttd_pemohon->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->ttd_pemohon->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->ttd_pemohon->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->ttd_pemohon->setDbValueDef($rsnew, $this->ttd_pemohon->Upload->FileName, null, false);
            }
        }
        if ($this->label_brand->Visible && !$this->label_brand->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->label_brand->Upload->DbValue) ? [] : [$this->label_brand->htmlDecode($this->label_brand->Upload->DbValue)];
            if (!EmptyValue($this->label_brand->Upload->FileName)) {
                $newFiles = [$this->label_brand->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->label_brand, $this->label_brand->Upload->Index);
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
                            $file1 = UniqueFilename($this->label_brand->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->label_brand->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->label_brand->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->label_brand->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->label_brand->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->label_brand->setDbValueDef($rsnew, $this->label_brand->Upload->FileName, null, false);
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
                if ($this->akta_pendirian->Visible && !$this->akta_pendirian->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->akta_pendirian->Upload->DbValue) ? [] : [$this->akta_pendirian->htmlDecode($this->akta_pendirian->Upload->DbValue)];
                    if (!EmptyValue($this->akta_pendirian->Upload->FileName)) {
                        $newFiles = [$this->akta_pendirian->Upload->FileName];
                        $newFiles2 = [$this->akta_pendirian->htmlDecode($rsnew['akta_pendirian'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->akta_pendirian, $this->akta_pendirian->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->akta_pendirian->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->akta_pendirian->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->ttd_pemohon->Visible && !$this->ttd_pemohon->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->ttd_pemohon->Upload->DbValue) ? [] : [$this->ttd_pemohon->htmlDecode($this->ttd_pemohon->Upload->DbValue)];
                    if (!EmptyValue($this->ttd_pemohon->Upload->FileName)) {
                        $newFiles = [$this->ttd_pemohon->Upload->FileName];
                        $newFiles2 = [$this->ttd_pemohon->htmlDecode($rsnew['ttd_pemohon'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->ttd_pemohon, $this->ttd_pemohon->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->ttd_pemohon->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->ttd_pemohon->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->label_brand->Visible && !$this->label_brand->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->label_brand->Upload->DbValue) ? [] : [$this->label_brand->htmlDecode($this->label_brand->Upload->DbValue)];
                    if (!EmptyValue($this->label_brand->Upload->FileName)) {
                        $newFiles = [$this->label_brand->Upload->FileName];
                        $newFiles2 = [$this->label_brand->htmlDecode($rsnew['label_brand'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->label_brand, $this->label_brand->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->label_brand->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->label_brand->oldPhysicalUploadPath() . $oldFile);
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("IjinhakiStatusGrid");
            if (in_array("ijinhaki_status", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idijinhaki->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "ijinhaki_status"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idijinhaki->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // akta_pendirian
            CleanUploadTempPath($this->akta_pendirian, $this->akta_pendirian->Upload->Index);

            // ttd_pemohon
            CleanUploadTempPath($this->ttd_pemohon, $this->ttd_pemohon->Upload->Index);

            // label_brand
            CleanUploadTempPath($this->label_brand, $this->label_brand->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("ijinhaki_status", $detailTblVar)) {
                $detailPageObj = Container("IjinhakiStatusGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idijinhaki->IsDetailKey = true;
                    $detailPageObj->idijinhaki->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idijinhaki->setSessionValue($detailPageObj->idijinhaki->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("IjinhakiList"), "", $this->TableVar, true);
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
                case "x_submitted_by":
                    break;
                case "x_checked1_by":
                    break;
                case "x_checked2_by":
                    break;
                case "x_approved_by":
                    break;
                case "x_status":
                    break;
                case "x_selesai":
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
