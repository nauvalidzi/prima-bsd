<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdConfirmdummyAdd extends NpdConfirmdummy
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_confirmdummy';

    // Page object name
    public $PageObjName = "NpdConfirmdummyAdd";

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

        // Table object (npd_confirmdummy)
        if (!isset($GLOBALS["npd_confirmdummy"]) || get_class($GLOBALS["npd_confirmdummy"]) == PROJECT_NAMESPACE . "npd_confirmdummy") {
            $GLOBALS["npd_confirmdummy"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_confirmdummy');
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
                $doc = new $class(Container("npd_confirmdummy"));
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
                    if ($pageName == "NpdConfirmdummyView") {
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
        $this->idnpd->setVisibility();
        $this->dummydepan->setVisibility();
        $this->dummybelakang->setVisibility();
        $this->dummyatas->setVisibility();
        $this->dummysamping->setVisibility();
        $this->catatan->setVisibility();
        $this->ttd->setVisibility();
        $this->checked_by->setVisibility();
        $this->approved_by->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
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
        $this->setupLookupOptions($this->checked_by);
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
                    $this->terminate("NpdConfirmdummyList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "NpdConfirmdummyList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdConfirmdummyView") {
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
        $this->dummydepan->CurrentValue = null;
        $this->dummydepan->OldValue = $this->dummydepan->CurrentValue;
        $this->dummybelakang->CurrentValue = null;
        $this->dummybelakang->OldValue = $this->dummybelakang->CurrentValue;
        $this->dummyatas->CurrentValue = null;
        $this->dummyatas->OldValue = $this->dummyatas->CurrentValue;
        $this->dummysamping->CurrentValue = null;
        $this->dummysamping->OldValue = $this->dummysamping->CurrentValue;
        $this->catatan->CurrentValue = null;
        $this->catatan->OldValue = $this->catatan->CurrentValue;
        $this->ttd->CurrentValue = null;
        $this->ttd->OldValue = $this->ttd->CurrentValue;
        $this->checked_by->CurrentValue = null;
        $this->checked_by->OldValue = $this->checked_by->CurrentValue;
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

        // Check field name 'dummydepan' first before field var 'x_dummydepan'
        $val = $CurrentForm->hasValue("dummydepan") ? $CurrentForm->getValue("dummydepan") : $CurrentForm->getValue("x_dummydepan");
        if (!$this->dummydepan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dummydepan->Visible = false; // Disable update for API request
            } else {
                $this->dummydepan->setFormValue($val);
            }
        }

        // Check field name 'dummybelakang' first before field var 'x_dummybelakang'
        $val = $CurrentForm->hasValue("dummybelakang") ? $CurrentForm->getValue("dummybelakang") : $CurrentForm->getValue("x_dummybelakang");
        if (!$this->dummybelakang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dummybelakang->Visible = false; // Disable update for API request
            } else {
                $this->dummybelakang->setFormValue($val);
            }
        }

        // Check field name 'dummyatas' first before field var 'x_dummyatas'
        $val = $CurrentForm->hasValue("dummyatas") ? $CurrentForm->getValue("dummyatas") : $CurrentForm->getValue("x_dummyatas");
        if (!$this->dummyatas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dummyatas->Visible = false; // Disable update for API request
            } else {
                $this->dummyatas->setFormValue($val);
            }
        }

        // Check field name 'dummysamping' first before field var 'x_dummysamping'
        $val = $CurrentForm->hasValue("dummysamping") ? $CurrentForm->getValue("dummysamping") : $CurrentForm->getValue("x_dummysamping");
        if (!$this->dummysamping->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dummysamping->Visible = false; // Disable update for API request
            } else {
                $this->dummysamping->setFormValue($val);
            }
        }

        // Check field name 'catatan' first before field var 'x_catatan'
        $val = $CurrentForm->hasValue("catatan") ? $CurrentForm->getValue("catatan") : $CurrentForm->getValue("x_catatan");
        if (!$this->catatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatan->Visible = false; // Disable update for API request
            } else {
                $this->catatan->setFormValue($val);
            }
        }

        // Check field name 'ttd' first before field var 'x_ttd'
        $val = $CurrentForm->hasValue("ttd") ? $CurrentForm->getValue("ttd") : $CurrentForm->getValue("x_ttd");
        if (!$this->ttd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ttd->Visible = false; // Disable update for API request
            } else {
                $this->ttd->setFormValue($val);
            }
            $this->ttd->CurrentValue = UnFormatDateTime($this->ttd->CurrentValue, 0);
        }

        // Check field name 'checked_by' first before field var 'x_checked_by'
        $val = $CurrentForm->hasValue("checked_by") ? $CurrentForm->getValue("checked_by") : $CurrentForm->getValue("x_checked_by");
        if (!$this->checked_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->checked_by->Visible = false; // Disable update for API request
            } else {
                $this->checked_by->setFormValue($val);
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->dummydepan->CurrentValue = $this->dummydepan->FormValue;
        $this->dummybelakang->CurrentValue = $this->dummybelakang->FormValue;
        $this->dummyatas->CurrentValue = $this->dummyatas->FormValue;
        $this->dummysamping->CurrentValue = $this->dummysamping->FormValue;
        $this->catatan->CurrentValue = $this->catatan->FormValue;
        $this->ttd->CurrentValue = $this->ttd->FormValue;
        $this->ttd->CurrentValue = UnFormatDateTime($this->ttd->CurrentValue, 0);
        $this->checked_by->CurrentValue = $this->checked_by->FormValue;
        $this->approved_by->CurrentValue = $this->approved_by->FormValue;
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
        $this->dummydepan->setDbValue($row['dummydepan']);
        $this->dummybelakang->setDbValue($row['dummybelakang']);
        $this->dummyatas->setDbValue($row['dummyatas']);
        $this->dummysamping->setDbValue($row['dummysamping']);
        $this->catatan->setDbValue($row['catatan']);
        $this->ttd->setDbValue($row['ttd']);
        $this->checked_by->setDbValue($row['checked_by']);
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
        $row['dummydepan'] = $this->dummydepan->CurrentValue;
        $row['dummybelakang'] = $this->dummybelakang->CurrentValue;
        $row['dummyatas'] = $this->dummyatas->CurrentValue;
        $row['dummysamping'] = $this->dummysamping->CurrentValue;
        $row['catatan'] = $this->catatan->CurrentValue;
        $row['ttd'] = $this->ttd->CurrentValue;
        $row['checked_by'] = $this->checked_by->CurrentValue;
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

        // dummydepan

        // dummybelakang

        // dummyatas

        // dummysamping

        // catatan

        // ttd

        // checked_by

        // approved_by

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";

            // dummydepan
            $this->dummydepan->ViewValue = $this->dummydepan->CurrentValue;
            $this->dummydepan->ViewCustomAttributes = "";

            // dummybelakang
            $this->dummybelakang->ViewValue = $this->dummybelakang->CurrentValue;
            $this->dummybelakang->ViewCustomAttributes = "";

            // dummyatas
            $this->dummyatas->ViewValue = $this->dummyatas->CurrentValue;
            $this->dummyatas->ViewCustomAttributes = "";

            // dummysamping
            $this->dummysamping->ViewValue = $this->dummysamping->CurrentValue;
            $this->dummysamping->ViewCustomAttributes = "";

            // catatan
            $this->catatan->ViewValue = $this->catatan->CurrentValue;
            $this->catatan->ViewCustomAttributes = "";

            // ttd
            $this->ttd->ViewValue = $this->ttd->CurrentValue;
            $this->ttd->ViewValue = FormatDateTime($this->ttd->ViewValue, 0);
            $this->ttd->ViewCustomAttributes = "";

            // checked_by
            $curVal = trim(strval($this->checked_by->CurrentValue));
            if ($curVal != "") {
                $this->checked_by->ViewValue = $this->checked_by->lookupCacheOption($curVal);
                if ($this->checked_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->checked_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->checked_by->Lookup->renderViewRow($rswrk[0]);
                        $this->checked_by->ViewValue = $this->checked_by->displayValue($arwrk);
                    } else {
                        $this->checked_by->ViewValue = $this->checked_by->CurrentValue;
                    }
                }
            } else {
                $this->checked_by->ViewValue = null;
            }
            $this->checked_by->ViewCustomAttributes = "";

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

            // dummydepan
            $this->dummydepan->LinkCustomAttributes = "";
            $this->dummydepan->HrefValue = "";
            $this->dummydepan->TooltipValue = "";

            // dummybelakang
            $this->dummybelakang->LinkCustomAttributes = "";
            $this->dummybelakang->HrefValue = "";
            $this->dummybelakang->TooltipValue = "";

            // dummyatas
            $this->dummyatas->LinkCustomAttributes = "";
            $this->dummyatas->HrefValue = "";
            $this->dummyatas->TooltipValue = "";

            // dummysamping
            $this->dummysamping->LinkCustomAttributes = "";
            $this->dummysamping->HrefValue = "";
            $this->dummysamping->TooltipValue = "";

            // catatan
            $this->catatan->LinkCustomAttributes = "";
            $this->catatan->HrefValue = "";
            $this->catatan->TooltipValue = "";

            // ttd
            $this->ttd->LinkCustomAttributes = "";
            $this->ttd->HrefValue = "";
            $this->ttd->TooltipValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";
            $this->checked_by->TooltipValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";
            $this->approved_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            $this->idnpd->EditValue = HtmlEncode($this->idnpd->CurrentValue);
            $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());

            // dummydepan
            $this->dummydepan->EditAttrs["class"] = "form-control";
            $this->dummydepan->EditCustomAttributes = "";
            if (!$this->dummydepan->Raw) {
                $this->dummydepan->CurrentValue = HtmlDecode($this->dummydepan->CurrentValue);
            }
            $this->dummydepan->EditValue = HtmlEncode($this->dummydepan->CurrentValue);
            $this->dummydepan->PlaceHolder = RemoveHtml($this->dummydepan->caption());

            // dummybelakang
            $this->dummybelakang->EditAttrs["class"] = "form-control";
            $this->dummybelakang->EditCustomAttributes = "";
            if (!$this->dummybelakang->Raw) {
                $this->dummybelakang->CurrentValue = HtmlDecode($this->dummybelakang->CurrentValue);
            }
            $this->dummybelakang->EditValue = HtmlEncode($this->dummybelakang->CurrentValue);
            $this->dummybelakang->PlaceHolder = RemoveHtml($this->dummybelakang->caption());

            // dummyatas
            $this->dummyatas->EditAttrs["class"] = "form-control";
            $this->dummyatas->EditCustomAttributes = "";
            if (!$this->dummyatas->Raw) {
                $this->dummyatas->CurrentValue = HtmlDecode($this->dummyatas->CurrentValue);
            }
            $this->dummyatas->EditValue = HtmlEncode($this->dummyatas->CurrentValue);
            $this->dummyatas->PlaceHolder = RemoveHtml($this->dummyatas->caption());

            // dummysamping
            $this->dummysamping->EditAttrs["class"] = "form-control";
            $this->dummysamping->EditCustomAttributes = "";
            if (!$this->dummysamping->Raw) {
                $this->dummysamping->CurrentValue = HtmlDecode($this->dummysamping->CurrentValue);
            }
            $this->dummysamping->EditValue = HtmlEncode($this->dummysamping->CurrentValue);
            $this->dummysamping->PlaceHolder = RemoveHtml($this->dummysamping->caption());

            // catatan
            $this->catatan->EditAttrs["class"] = "form-control";
            $this->catatan->EditCustomAttributes = "";
            $this->catatan->EditValue = HtmlEncode($this->catatan->CurrentValue);
            $this->catatan->PlaceHolder = RemoveHtml($this->catatan->caption());

            // ttd
            $this->ttd->EditAttrs["class"] = "form-control";
            $this->ttd->EditCustomAttributes = "";
            $this->ttd->EditValue = HtmlEncode(FormatDateTime($this->ttd->CurrentValue, 8));
            $this->ttd->PlaceHolder = RemoveHtml($this->ttd->caption());

            // checked_by
            $this->checked_by->EditAttrs["class"] = "form-control";
            $this->checked_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->checked_by->CurrentValue));
            if ($curVal != "") {
                $this->checked_by->ViewValue = $this->checked_by->lookupCacheOption($curVal);
            } else {
                $this->checked_by->ViewValue = $this->checked_by->Lookup !== null && is_array($this->checked_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->checked_by->ViewValue !== null) { // Load from cache
                $this->checked_by->EditValue = array_values($this->checked_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->checked_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->checked_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->checked_by->EditValue = $arwrk;
            }
            $this->checked_by->PlaceHolder = RemoveHtml($this->checked_by->caption());

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

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // dummydepan
            $this->dummydepan->LinkCustomAttributes = "";
            $this->dummydepan->HrefValue = "";

            // dummybelakang
            $this->dummybelakang->LinkCustomAttributes = "";
            $this->dummybelakang->HrefValue = "";

            // dummyatas
            $this->dummyatas->LinkCustomAttributes = "";
            $this->dummyatas->HrefValue = "";

            // dummysamping
            $this->dummysamping->LinkCustomAttributes = "";
            $this->dummysamping->HrefValue = "";

            // catatan
            $this->catatan->LinkCustomAttributes = "";
            $this->catatan->HrefValue = "";

            // ttd
            $this->ttd->LinkCustomAttributes = "";
            $this->ttd->HrefValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";
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
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idnpd->FormValue)) {
            $this->idnpd->addErrorMessage($this->idnpd->getErrorMessage(false));
        }
        if ($this->dummydepan->Required) {
            if (!$this->dummydepan->IsDetailKey && EmptyValue($this->dummydepan->FormValue)) {
                $this->dummydepan->addErrorMessage(str_replace("%s", $this->dummydepan->caption(), $this->dummydepan->RequiredErrorMessage));
            }
        }
        if ($this->dummybelakang->Required) {
            if (!$this->dummybelakang->IsDetailKey && EmptyValue($this->dummybelakang->FormValue)) {
                $this->dummybelakang->addErrorMessage(str_replace("%s", $this->dummybelakang->caption(), $this->dummybelakang->RequiredErrorMessage));
            }
        }
        if ($this->dummyatas->Required) {
            if (!$this->dummyatas->IsDetailKey && EmptyValue($this->dummyatas->FormValue)) {
                $this->dummyatas->addErrorMessage(str_replace("%s", $this->dummyatas->caption(), $this->dummyatas->RequiredErrorMessage));
            }
        }
        if ($this->dummysamping->Required) {
            if (!$this->dummysamping->IsDetailKey && EmptyValue($this->dummysamping->FormValue)) {
                $this->dummysamping->addErrorMessage(str_replace("%s", $this->dummysamping->caption(), $this->dummysamping->RequiredErrorMessage));
            }
        }
        if ($this->catatan->Required) {
            if (!$this->catatan->IsDetailKey && EmptyValue($this->catatan->FormValue)) {
                $this->catatan->addErrorMessage(str_replace("%s", $this->catatan->caption(), $this->catatan->RequiredErrorMessage));
            }
        }
        if ($this->ttd->Required) {
            if (!$this->ttd->IsDetailKey && EmptyValue($this->ttd->FormValue)) {
                $this->ttd->addErrorMessage(str_replace("%s", $this->ttd->caption(), $this->ttd->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ttd->FormValue)) {
            $this->ttd->addErrorMessage($this->ttd->getErrorMessage(false));
        }
        if ($this->checked_by->Required) {
            if (!$this->checked_by->IsDetailKey && EmptyValue($this->checked_by->FormValue)) {
                $this->checked_by->addErrorMessage(str_replace("%s", $this->checked_by->caption(), $this->checked_by->RequiredErrorMessage));
            }
        }
        if ($this->approved_by->Required) {
            if (!$this->approved_by->IsDetailKey && EmptyValue($this->approved_by->FormValue)) {
                $this->approved_by->addErrorMessage(str_replace("%s", $this->approved_by->caption(), $this->approved_by->RequiredErrorMessage));
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
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, false);

        // dummydepan
        $this->dummydepan->setDbValueDef($rsnew, $this->dummydepan->CurrentValue, null, false);

        // dummybelakang
        $this->dummybelakang->setDbValueDef($rsnew, $this->dummybelakang->CurrentValue, null, false);

        // dummyatas
        $this->dummyatas->setDbValueDef($rsnew, $this->dummyatas->CurrentValue, null, false);

        // dummysamping
        $this->dummysamping->setDbValueDef($rsnew, $this->dummysamping->CurrentValue, null, false);

        // catatan
        $this->catatan->setDbValueDef($rsnew, $this->catatan->CurrentValue, null, false);

        // ttd
        $this->ttd->setDbValueDef($rsnew, UnFormatDateTime($this->ttd->CurrentValue, 0), null, false);

        // checked_by
        $this->checked_by->setDbValueDef($rsnew, $this->checked_by->CurrentValue, null, false);

        // approved_by
        $this->approved_by->setDbValueDef($rsnew, $this->approved_by->CurrentValue, null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdConfirmdummyList"), "", $this->TableVar, true);
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
                case "x_checked_by":
                    break;
                case "x_approved_by":
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
