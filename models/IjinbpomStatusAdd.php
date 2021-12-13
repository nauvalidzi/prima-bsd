<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class IjinbpomStatusAdd extends IjinbpomStatus
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'ijinbpom_status';

    // Page object name
    public $PageObjName = "IjinbpomStatusAdd";

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

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (ijinbpom_status)
        if (!isset($GLOBALS["ijinbpom_status"]) || get_class($GLOBALS["ijinbpom_status"]) == PROJECT_NAMESPACE . "ijinbpom_status") {
            $GLOBALS["ijinbpom_status"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'ijinbpom_status');
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

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("ijinbpom_status"));
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
                    if ($pageName == "IjinbpomStatusView") {
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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
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
        $this->idijinbpom->Visible = false;
        $this->idpegawai->setVisibility();
        $this->status->setVisibility();
        $this->targetmulai->setVisibility();
        $this->tglmulai->setVisibility();
        $this->targetselesai->setVisibility();
        $this->tglselesai->setVisibility();
        $this->keterangan->setVisibility();
        $this->lampiran->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->setVisibility();
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
        $this->setupLookupOptions($this->idpegawai);

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
                    $this->terminate("IjinbpomStatusList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "IjinbpomStatusList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "IjinbpomStatusView") {
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
        $this->lampiran->Upload->Index = $CurrentForm->Index;
        $this->lampiran->Upload->uploadFile();
        $this->lampiran->CurrentValue = $this->lampiran->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->idijinbpom->CurrentValue = null;
        $this->idijinbpom->OldValue = $this->idijinbpom->CurrentValue;
        $this->idpegawai->CurrentValue = CurrentUserID();
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->targetmulai->CurrentValue = null;
        $this->targetmulai->OldValue = $this->targetmulai->CurrentValue;
        $this->tglmulai->CurrentValue = null;
        $this->tglmulai->OldValue = $this->tglmulai->CurrentValue;
        $this->targetselesai->CurrentValue = null;
        $this->targetselesai->OldValue = $this->targetselesai->CurrentValue;
        $this->tglselesai->CurrentValue = null;
        $this->tglselesai->OldValue = $this->tglselesai->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->lampiran->Upload->DbValue = null;
        $this->lampiran->OldValue = $this->lampiran->Upload->DbValue;
        $this->lampiran->CurrentValue = null; // Clear file related field
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idpegawai' first before field var 'x_idpegawai'
        $val = $CurrentForm->hasValue("idpegawai") ? $CurrentForm->getValue("idpegawai") : $CurrentForm->getValue("x_idpegawai");
        if (!$this->idpegawai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idpegawai->Visible = false; // Disable update for API request
            } else {
                $this->idpegawai->setFormValue($val);
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

        // Check field name 'targetmulai' first before field var 'x_targetmulai'
        $val = $CurrentForm->hasValue("targetmulai") ? $CurrentForm->getValue("targetmulai") : $CurrentForm->getValue("x_targetmulai");
        if (!$this->targetmulai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->targetmulai->Visible = false; // Disable update for API request
            } else {
                $this->targetmulai->setFormValue($val);
            }
            $this->targetmulai->CurrentValue = UnFormatDateTime($this->targetmulai->CurrentValue, 0);
        }

        // Check field name 'tglmulai' first before field var 'x_tglmulai'
        $val = $CurrentForm->hasValue("tglmulai") ? $CurrentForm->getValue("tglmulai") : $CurrentForm->getValue("x_tglmulai");
        if (!$this->tglmulai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglmulai->Visible = false; // Disable update for API request
            } else {
                $this->tglmulai->setFormValue($val);
            }
            $this->tglmulai->CurrentValue = UnFormatDateTime($this->tglmulai->CurrentValue, 0);
        }

        // Check field name 'targetselesai' first before field var 'x_targetselesai'
        $val = $CurrentForm->hasValue("targetselesai") ? $CurrentForm->getValue("targetselesai") : $CurrentForm->getValue("x_targetselesai");
        if (!$this->targetselesai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->targetselesai->Visible = false; // Disable update for API request
            } else {
                $this->targetselesai->setFormValue($val);
            }
            $this->targetselesai->CurrentValue = UnFormatDateTime($this->targetselesai->CurrentValue, 0);
        }

        // Check field name 'tglselesai' first before field var 'x_tglselesai'
        $val = $CurrentForm->hasValue("tglselesai") ? $CurrentForm->getValue("tglselesai") : $CurrentForm->getValue("x_tglselesai");
        if (!$this->tglselesai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglselesai->Visible = false; // Disable update for API request
            } else {
                $this->tglselesai->setFormValue($val);
            }
            $this->tglselesai->CurrentValue = UnFormatDateTime($this->tglselesai->CurrentValue, 0);
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

        // Check field name 'created_by' first before field var 'x_created_by'
        $val = $CurrentForm->hasValue("created_by") ? $CurrentForm->getValue("created_by") : $CurrentForm->getValue("x_created_by");
        if (!$this->created_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_by->Visible = false; // Disable update for API request
            } else {
                $this->created_by->setFormValue($val);
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
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->targetmulai->CurrentValue = $this->targetmulai->FormValue;
        $this->targetmulai->CurrentValue = UnFormatDateTime($this->targetmulai->CurrentValue, 0);
        $this->tglmulai->CurrentValue = $this->tglmulai->FormValue;
        $this->tglmulai->CurrentValue = UnFormatDateTime($this->tglmulai->CurrentValue, 0);
        $this->targetselesai->CurrentValue = $this->targetselesai->FormValue;
        $this->targetselesai->CurrentValue = UnFormatDateTime($this->targetselesai->CurrentValue, 0);
        $this->tglselesai->CurrentValue = $this->tglselesai->FormValue;
        $this->tglselesai->CurrentValue = UnFormatDateTime($this->tglselesai->CurrentValue, 0);
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->created_by->CurrentValue = $this->created_by->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->idijinbpom->setDbValue($row['idijinbpom']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->status->setDbValue($row['status']);
        $this->targetmulai->setDbValue($row['targetmulai']);
        $this->tglmulai->setDbValue($row['tglmulai']);
        $this->targetselesai->setDbValue($row['targetselesai']);
        $this->tglselesai->setDbValue($row['tglselesai']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->lampiran->setDbValue($this->lampiran->Upload->DbValue);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idijinbpom'] = $this->idijinbpom->CurrentValue;
        $row['idpegawai'] = $this->idpegawai->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['targetmulai'] = $this->targetmulai->CurrentValue;
        $row['tglmulai'] = $this->tglmulai->CurrentValue;
        $row['targetselesai'] = $this->targetselesai->CurrentValue;
        $row['tglselesai'] = $this->tglselesai->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
        $row['lampiran'] = $this->lampiran->Upload->DbValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['created_by'] = $this->created_by->CurrentValue;
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

        // idijinbpom

        // idpegawai

        // status

        // targetmulai

        // tglmulai

        // targetselesai

        // tglselesai

        // keterangan

        // lampiran

        // created_at

        // created_by
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idijinbpom
            $this->idijinbpom->ViewValue = $this->idijinbpom->CurrentValue;
            $this->idijinbpom->ViewValue = FormatNumber($this->idijinbpom->ViewValue, 0, -2, -2, -2);
            $this->idijinbpom->ViewCustomAttributes = "";

            // idpegawai
            $curVal = trim(strval($this->idpegawai->CurrentValue));
            if ($curVal != "") {
                $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
                if ($this->idpegawai->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idpegawai->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idpegawai->Lookup->renderViewRow($rswrk[0]);
                        $this->idpegawai->ViewValue = $this->idpegawai->displayValue($arwrk);
                    } else {
                        $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
                    }
                }
            } else {
                $this->idpegawai->ViewValue = null;
            }
            $this->idpegawai->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // targetmulai
            $this->targetmulai->ViewValue = $this->targetmulai->CurrentValue;
            $this->targetmulai->ViewValue = FormatDateTime($this->targetmulai->ViewValue, 0);
            $this->targetmulai->ViewCustomAttributes = "";

            // tglmulai
            $this->tglmulai->ViewValue = $this->tglmulai->CurrentValue;
            $this->tglmulai->ViewValue = FormatDateTime($this->tglmulai->ViewValue, 0);
            $this->tglmulai->ViewCustomAttributes = "";

            // targetselesai
            $this->targetselesai->ViewValue = $this->targetselesai->CurrentValue;
            $this->targetselesai->ViewValue = FormatDateTime($this->targetselesai->ViewValue, 0);
            $this->targetselesai->ViewCustomAttributes = "";

            // tglselesai
            $this->tglselesai->ViewValue = $this->tglselesai->CurrentValue;
            $this->tglselesai->ViewValue = FormatDateTime($this->tglselesai->ViewValue, 0);
            $this->tglselesai->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // lampiran
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->ViewValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->ViewValue = "";
            }
            $this->lampiran->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // targetmulai
            $this->targetmulai->LinkCustomAttributes = "";
            $this->targetmulai->HrefValue = "";
            $this->targetmulai->TooltipValue = "";

            // tglmulai
            $this->tglmulai->LinkCustomAttributes = "";
            $this->tglmulai->HrefValue = "";
            $this->tglmulai->TooltipValue = "";

            // targetselesai
            $this->targetselesai->LinkCustomAttributes = "";
            $this->targetselesai->HrefValue = "";
            $this->targetselesai->TooltipValue = "";

            // tglselesai
            $this->tglselesai->LinkCustomAttributes = "";
            $this->tglselesai->HrefValue = "";
            $this->tglselesai->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // lampiran
            $this->lampiran->LinkCustomAttributes = "";
            $this->lampiran->HrefValue = "";
            $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;
            $this->lampiran->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            $curVal = trim(strval($this->idpegawai->CurrentValue));
            if ($curVal != "") {
                $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
            } else {
                $this->idpegawai->ViewValue = $this->idpegawai->Lookup !== null && is_array($this->idpegawai->Lookup->Options) ? $curVal : null;
            }
            if ($this->idpegawai->ViewValue !== null) { // Load from cache
                $this->idpegawai->EditValue = array_values($this->idpegawai->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idpegawai->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idpegawai->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idpegawai->EditValue = $arwrk;
            }
            $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // targetmulai
            $this->targetmulai->EditAttrs["class"] = "form-control";
            $this->targetmulai->EditCustomAttributes = "";
            $this->targetmulai->EditValue = HtmlEncode(FormatDateTime($this->targetmulai->CurrentValue, 8));
            $this->targetmulai->PlaceHolder = RemoveHtml($this->targetmulai->caption());

            // tglmulai
            $this->tglmulai->EditAttrs["class"] = "form-control";
            $this->tglmulai->EditCustomAttributes = "";
            $this->tglmulai->EditValue = HtmlEncode(FormatDateTime($this->tglmulai->CurrentValue, 8));
            $this->tglmulai->PlaceHolder = RemoveHtml($this->tglmulai->caption());

            // targetselesai
            $this->targetselesai->EditAttrs["class"] = "form-control";
            $this->targetselesai->EditCustomAttributes = "";
            $this->targetselesai->EditValue = HtmlEncode(FormatDateTime($this->targetselesai->CurrentValue, 8));
            $this->targetselesai->PlaceHolder = RemoveHtml($this->targetselesai->caption());

            // tglselesai
            $this->tglselesai->EditAttrs["class"] = "form-control";
            $this->tglselesai->EditCustomAttributes = "";
            $this->tglselesai->EditValue = HtmlEncode(FormatDateTime($this->tglselesai->CurrentValue, 8));
            $this->tglselesai->PlaceHolder = RemoveHtml($this->tglselesai->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            if (!$this->keterangan->Raw) {
                $this->keterangan->CurrentValue = HtmlDecode($this->keterangan->CurrentValue);
            }
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // lampiran
            $this->lampiran->EditAttrs["class"] = "form-control";
            $this->lampiran->EditCustomAttributes = "";
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->EditValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->EditValue = "";
            }
            if (!EmptyValue($this->lampiran->CurrentValue)) {
                $this->lampiran->Upload->FileName = $this->lampiran->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->lampiran);
            }

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->CurrentValue = CurrentUserID();

            // Add refer script

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // targetmulai
            $this->targetmulai->LinkCustomAttributes = "";
            $this->targetmulai->HrefValue = "";

            // tglmulai
            $this->tglmulai->LinkCustomAttributes = "";
            $this->tglmulai->HrefValue = "";

            // targetselesai
            $this->targetselesai->LinkCustomAttributes = "";
            $this->targetselesai->HrefValue = "";

            // tglselesai
            $this->tglselesai->LinkCustomAttributes = "";
            $this->tglselesai->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";

            // lampiran
            $this->lampiran->LinkCustomAttributes = "";
            $this->lampiran->HrefValue = "";
            $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
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
        if ($this->idpegawai->Required) {
            if (!$this->idpegawai->IsDetailKey && EmptyValue($this->idpegawai->FormValue)) {
                $this->idpegawai->addErrorMessage(str_replace("%s", $this->idpegawai->caption(), $this->idpegawai->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->targetmulai->Required) {
            if (!$this->targetmulai->IsDetailKey && EmptyValue($this->targetmulai->FormValue)) {
                $this->targetmulai->addErrorMessage(str_replace("%s", $this->targetmulai->caption(), $this->targetmulai->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->targetmulai->FormValue)) {
            $this->targetmulai->addErrorMessage($this->targetmulai->getErrorMessage(false));
        }
        if ($this->tglmulai->Required) {
            if (!$this->tglmulai->IsDetailKey && EmptyValue($this->tglmulai->FormValue)) {
                $this->tglmulai->addErrorMessage(str_replace("%s", $this->tglmulai->caption(), $this->tglmulai->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglmulai->FormValue)) {
            $this->tglmulai->addErrorMessage($this->tglmulai->getErrorMessage(false));
        }
        if ($this->targetselesai->Required) {
            if (!$this->targetselesai->IsDetailKey && EmptyValue($this->targetselesai->FormValue)) {
                $this->targetselesai->addErrorMessage(str_replace("%s", $this->targetselesai->caption(), $this->targetselesai->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->targetselesai->FormValue)) {
            $this->targetselesai->addErrorMessage($this->targetselesai->getErrorMessage(false));
        }
        if ($this->tglselesai->Required) {
            if (!$this->tglselesai->IsDetailKey && EmptyValue($this->tglselesai->FormValue)) {
                $this->tglselesai->addErrorMessage(str_replace("%s", $this->tglselesai->caption(), $this->tglselesai->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglselesai->FormValue)) {
            $this->tglselesai->addErrorMessage($this->tglselesai->getErrorMessage(false));
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }
        if ($this->lampiran->Required) {
            if ($this->lampiran->Upload->FileName == "" && !$this->lampiran->Upload->KeepFile) {
                $this->lampiran->addErrorMessage(str_replace("%s", $this->lampiran->caption(), $this->lampiran->RequiredErrorMessage));
            }
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
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

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->created_by->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->created_by->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->created_by->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $masterFilter = $this->sqlMasterFilter_ijinbpom();
            if (strval($this->idijinbpom->CurrentValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($this->idijinbpom->CurrentValue, "DB"), $masterFilter);
            } else {
                $masterFilter = "";
            }
            if ($masterFilter != "") {
                $rsmaster = Container("ijinbpom")->loadRs($masterFilter)->fetch(\PDO::FETCH_ASSOC);
                $masterRecordExists = $rsmaster !== false;
                $validMasterKey = true;
                if ($masterRecordExists) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['created_by']);
                } elseif ($this->getCurrentMasterTable() == "ijinbpom") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idpegawai
        $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, 0, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", false);

        // targetmulai
        $this->targetmulai->setDbValueDef($rsnew, UnFormatDateTime($this->targetmulai->CurrentValue, 0), CurrentDate(), false);

        // tglmulai
        $this->tglmulai->setDbValueDef($rsnew, UnFormatDateTime($this->tglmulai->CurrentValue, 0), CurrentDate(), false);

        // targetselesai
        $this->targetselesai->setDbValueDef($rsnew, UnFormatDateTime($this->targetselesai->CurrentValue, 0), CurrentDate(), false);

        // tglselesai
        $this->tglselesai->setDbValueDef($rsnew, UnFormatDateTime($this->tglselesai->CurrentValue, 0), null, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, false);

        // lampiran
        if ($this->lampiran->Visible && !$this->lampiran->Upload->KeepFile) {
            $this->lampiran->Upload->DbValue = ""; // No need to delete old file
            if ($this->lampiran->Upload->FileName == "") {
                $rsnew['lampiran'] = null;
            } else {
                $rsnew['lampiran'] = $this->lampiran->Upload->FileName;
            }
        }

        // created_by
        $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, false);

        // idijinbpom
        if ($this->idijinbpom->getSessionValue() != "") {
            $rsnew['idijinbpom'] = $this->idijinbpom->getSessionValue();
        }
        if ($this->lampiran->Visible && !$this->lampiran->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->lampiran->Upload->DbValue) ? [] : [$this->lampiran->htmlDecode($this->lampiran->Upload->DbValue)];
            if (!EmptyValue($this->lampiran->Upload->FileName)) {
                $newFiles = [$this->lampiran->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->lampiran, $this->lampiran->Upload->Index);
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
                            $file1 = UniqueFilename($this->lampiran->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->lampiran->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->lampiran->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->lampiran->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->lampiran->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->lampiran->setDbValueDef($rsnew, $this->lampiran->Upload->FileName, null, false);
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
                if ($this->lampiran->Visible && !$this->lampiran->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->lampiran->Upload->DbValue) ? [] : [$this->lampiran->htmlDecode($this->lampiran->Upload->DbValue)];
                    if (!EmptyValue($this->lampiran->Upload->FileName)) {
                        $newFiles = [$this->lampiran->Upload->FileName];
                        $newFiles2 = [$this->lampiran->htmlDecode($rsnew['lampiran'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->lampiran, $this->lampiran->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->lampiran->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->lampiran->oldPhysicalUploadPath() . $oldFile);
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
            // lampiran
            CleanUploadTempPath($this->lampiran, $this->lampiran->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->created_by->CurrentValue);
        }
        return true;
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
            if ($masterTblVar == "ijinbpom") {
                $validMaster = true;
                $masterTbl = Container("ijinbpom");
                if (($parm = Get("fk_id", Get("idijinbpom"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idijinbpom->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idijinbpom->setSessionValue($this->idijinbpom->QueryStringValue);
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
            if ($masterTblVar == "ijinbpom") {
                $validMaster = true;
                $masterTbl = Container("ijinbpom");
                if (($parm = Post("fk_id", Post("idijinbpom"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idijinbpom->setFormValue($masterTbl->id->FormValue);
                    $this->idijinbpom->setSessionValue($this->idijinbpom->FormValue);
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
            if ($masterTblVar != "ijinbpom") {
                if ($this->idijinbpom->CurrentValue == "") {
                    $this->idijinbpom->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("IjinbpomStatusList"), "", $this->TableVar, true);
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
                case "x_idpegawai":
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
