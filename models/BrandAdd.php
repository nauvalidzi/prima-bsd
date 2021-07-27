<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class BrandAdd extends Brand
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'brand';

    // Page object name
    public $PageObjName = "BrandAdd";

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

        // Table object (brand)
        if (!isset($GLOBALS["brand"]) || get_class($GLOBALS["brand"]) == PROJECT_NAMESPACE . "brand") {
            $GLOBALS["brand"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'brand');
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
                $doc = new $class(Container("brand"));
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
                    if ($pageName == "BrandView") {
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
        $this->idcustomer->setVisibility();
        $this->title->setVisibility();
        $this->kode->setVisibility();
        $this->logo->setVisibility();
        $this->titipmerk->setVisibility();
        $this->ijinhaki->setVisibility();
        $this->ijinbpom->setVisibility();
        $this->aktaperusahaan->setVisibility();
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
        $this->setupLookupOptions($this->idcustomer);

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
                    $this->terminate("BrandList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "BrandList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "BrandView") {
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
        $this->logo->Upload->Index = $CurrentForm->Index;
        $this->logo->Upload->uploadFile();
        $this->logo->CurrentValue = $this->logo->Upload->FileName;
        $this->aktaperusahaan->Upload->Index = $CurrentForm->Index;
        $this->aktaperusahaan->Upload->uploadFile();
        $this->aktaperusahaan->CurrentValue = $this->aktaperusahaan->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->title->CurrentValue = null;
        $this->title->OldValue = $this->title->CurrentValue;
        $this->kode->CurrentValue = null;
        $this->kode->OldValue = $this->kode->CurrentValue;
        $this->logo->Upload->DbValue = null;
        $this->logo->OldValue = $this->logo->Upload->DbValue;
        $this->logo->CurrentValue = null; // Clear file related field
        $this->titipmerk->CurrentValue = 1;
        $this->ijinhaki->CurrentValue = 0;
        $this->ijinbpom->CurrentValue = 0;
        $this->aktaperusahaan->Upload->DbValue = null;
        $this->aktaperusahaan->OldValue = $this->aktaperusahaan->Upload->DbValue;
        $this->aktaperusahaan->CurrentValue = null; // Clear file related field
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idcustomer' first before field var 'x_idcustomer'
        $val = $CurrentForm->hasValue("idcustomer") ? $CurrentForm->getValue("idcustomer") : $CurrentForm->getValue("x_idcustomer");
        if (!$this->idcustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idcustomer->Visible = false; // Disable update for API request
            } else {
                $this->idcustomer->setFormValue($val);
            }
        }

        // Check field name 'title' first before field var 'x_title'
        $val = $CurrentForm->hasValue("title") ? $CurrentForm->getValue("title") : $CurrentForm->getValue("x_title");
        if (!$this->title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->title->Visible = false; // Disable update for API request
            } else {
                $this->title->setFormValue($val);
            }
        }

        // Check field name 'kode' first before field var 'x_kode'
        $val = $CurrentForm->hasValue("kode") ? $CurrentForm->getValue("kode") : $CurrentForm->getValue("x_kode");
        if (!$this->kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode->Visible = false; // Disable update for API request
            } else {
                $this->kode->setFormValue($val);
            }
        }

        // Check field name 'titipmerk' first before field var 'x_titipmerk'
        $val = $CurrentForm->hasValue("titipmerk") ? $CurrentForm->getValue("titipmerk") : $CurrentForm->getValue("x_titipmerk");
        if (!$this->titipmerk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titipmerk->Visible = false; // Disable update for API request
            } else {
                $this->titipmerk->setFormValue($val);
            }
        }

        // Check field name 'ijinhaki' first before field var 'x_ijinhaki'
        $val = $CurrentForm->hasValue("ijinhaki") ? $CurrentForm->getValue("ijinhaki") : $CurrentForm->getValue("x_ijinhaki");
        if (!$this->ijinhaki->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ijinhaki->Visible = false; // Disable update for API request
            } else {
                $this->ijinhaki->setFormValue($val);
            }
        }

        // Check field name 'ijinbpom' first before field var 'x_ijinbpom'
        $val = $CurrentForm->hasValue("ijinbpom") ? $CurrentForm->getValue("ijinbpom") : $CurrentForm->getValue("x_ijinbpom");
        if (!$this->ijinbpom->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ijinbpom->Visible = false; // Disable update for API request
            } else {
                $this->ijinbpom->setFormValue($val);
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
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->title->CurrentValue = $this->title->FormValue;
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->titipmerk->CurrentValue = $this->titipmerk->FormValue;
        $this->ijinhaki->CurrentValue = $this->ijinhaki->FormValue;
        $this->ijinbpom->CurrentValue = $this->ijinbpom->FormValue;
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
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->title->setDbValue($row['title']);
        $this->kode->setDbValue($row['kode']);
        $this->logo->Upload->DbValue = $row['logo'];
        $this->logo->setDbValue($this->logo->Upload->DbValue);
        $this->titipmerk->setDbValue($row['titipmerk']);
        $this->ijinhaki->setDbValue($row['ijinhaki']);
        $this->ijinbpom->setDbValue($row['ijinbpom']);
        $this->aktaperusahaan->Upload->DbValue = $row['aktaperusahaan'];
        $this->aktaperusahaan->setDbValue($this->aktaperusahaan->Upload->DbValue);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['title'] = $this->title->CurrentValue;
        $row['kode'] = $this->kode->CurrentValue;
        $row['logo'] = $this->logo->Upload->DbValue;
        $row['titipmerk'] = $this->titipmerk->CurrentValue;
        $row['ijinhaki'] = $this->ijinhaki->CurrentValue;
        $row['ijinbpom'] = $this->ijinbpom->CurrentValue;
        $row['aktaperusahaan'] = $this->aktaperusahaan->Upload->DbValue;
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

        // idcustomer

        // title

        // kode

        // logo

        // titipmerk

        // ijinhaki

        // ijinbpom

        // aktaperusahaan

        // created_at

        // created_by
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idcustomer
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                        $this->idcustomer->ViewValue = $this->idcustomer->displayValue($arwrk);
                    } else {
                        $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
                    }
                }
            } else {
                $this->idcustomer->ViewValue = null;
            }
            $this->idcustomer->ViewCustomAttributes = "";

            // title
            $this->title->ViewValue = $this->title->CurrentValue;
            $this->title->ViewCustomAttributes = "";

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // logo
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->ImageAlt = $this->logo->alt();
                $this->logo->ViewValue = $this->logo->Upload->DbValue;
            } else {
                $this->logo->ViewValue = "";
            }
            $this->logo->ViewCustomAttributes = "";

            // titipmerk
            if (strval($this->titipmerk->CurrentValue) != "") {
                $this->titipmerk->ViewValue = $this->titipmerk->optionCaption($this->titipmerk->CurrentValue);
            } else {
                $this->titipmerk->ViewValue = null;
            }
            $this->titipmerk->ViewCustomAttributes = "";

            // ijinhaki
            if (strval($this->ijinhaki->CurrentValue) != "") {
                $this->ijinhaki->ViewValue = $this->ijinhaki->optionCaption($this->ijinhaki->CurrentValue);
            } else {
                $this->ijinhaki->ViewValue = null;
            }
            $this->ijinhaki->ViewCustomAttributes = "";

            // ijinbpom
            if (strval($this->ijinbpom->CurrentValue) != "") {
                $this->ijinbpom->ViewValue = $this->ijinbpom->optionCaption($this->ijinbpom->CurrentValue);
            } else {
                $this->ijinbpom->ViewValue = null;
            }
            $this->ijinbpom->ViewCustomAttributes = "";

            // aktaperusahaan
            if (!EmptyValue($this->aktaperusahaan->Upload->DbValue)) {
                $this->aktaperusahaan->ImageAlt = $this->aktaperusahaan->alt();
                $this->aktaperusahaan->ViewValue = $this->aktaperusahaan->Upload->DbValue;
            } else {
                $this->aktaperusahaan->ViewValue = "";
            }
            $this->aktaperusahaan->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // title
            $this->title->LinkCustomAttributes = "";
            $this->title->HrefValue = "";
            $this->title->TooltipValue = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // logo
            $this->logo->LinkCustomAttributes = "";
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->HrefValue = GetFileUploadUrl($this->logo, $this->logo->htmlDecode($this->logo->Upload->DbValue)); // Add prefix/suffix
                $this->logo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->logo->HrefValue = FullUrl($this->logo->HrefValue, "href");
                }
            } else {
                $this->logo->HrefValue = "";
            }
            $this->logo->ExportHrefValue = $this->logo->UploadPath . $this->logo->Upload->DbValue;
            $this->logo->TooltipValue = "";
            if ($this->logo->UseColorbox) {
                if (EmptyValue($this->logo->TooltipValue)) {
                    $this->logo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->logo->LinkAttrs["data-rel"] = "brand_x_logo";
                $this->logo->LinkAttrs->appendClass("ew-lightbox");
            }

            // titipmerk
            $this->titipmerk->LinkCustomAttributes = "";
            $this->titipmerk->HrefValue = "";
            $this->titipmerk->TooltipValue = "";

            // ijinhaki
            $this->ijinhaki->LinkCustomAttributes = "";
            $this->ijinhaki->HrefValue = "";
            $this->ijinhaki->TooltipValue = "";

            // ijinbpom
            $this->ijinbpom->LinkCustomAttributes = "";
            $this->ijinbpom->HrefValue = "";
            $this->ijinbpom->TooltipValue = "";

            // aktaperusahaan
            $this->aktaperusahaan->LinkCustomAttributes = "";
            if (!EmptyValue($this->aktaperusahaan->Upload->DbValue)) {
                $this->aktaperusahaan->HrefValue = GetFileUploadUrl($this->aktaperusahaan, $this->aktaperusahaan->htmlDecode($this->aktaperusahaan->Upload->DbValue)); // Add prefix/suffix
                $this->aktaperusahaan->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->aktaperusahaan->HrefValue = FullUrl($this->aktaperusahaan->HrefValue, "href");
                }
            } else {
                $this->aktaperusahaan->HrefValue = "";
            }
            $this->aktaperusahaan->ExportHrefValue = $this->aktaperusahaan->UploadPath . $this->aktaperusahaan->Upload->DbValue;
            $this->aktaperusahaan->TooltipValue = "";
            if ($this->aktaperusahaan->UseColorbox) {
                if (EmptyValue($this->aktaperusahaan->TooltipValue)) {
                    $this->aktaperusahaan->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->aktaperusahaan->LinkAttrs["data-rel"] = "brand_x_aktaperusahaan";
                $this->aktaperusahaan->LinkAttrs->appendClass("ew-lightbox");
            }

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            if ($this->idcustomer->getSessionValue() != "") {
                $this->idcustomer->CurrentValue = GetForeignKeyValue($this->idcustomer->getSessionValue());
                $curVal = trim(strval($this->idcustomer->CurrentValue));
                if ($curVal != "") {
                    $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                    if ($this->idcustomer->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                            $this->idcustomer->ViewValue = $this->idcustomer->displayValue($arwrk);
                        } else {
                            $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
                        }
                    }
                } else {
                    $this->idcustomer->ViewValue = null;
                }
                $this->idcustomer->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->idcustomer->CurrentValue));
                if ($curVal != "") {
                    $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                } else {
                    $this->idcustomer->ViewValue = $this->idcustomer->Lookup !== null && is_array($this->idcustomer->Lookup->Options) ? $curVal : null;
                }
                if ($this->idcustomer->ViewValue !== null) { // Load from cache
                    $this->idcustomer->EditValue = array_values($this->idcustomer->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idcustomer->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->idcustomer->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idcustomer->EditValue = $arwrk;
                }
                $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());
            }

            // title
            $this->title->EditAttrs["class"] = "form-control";
            $this->title->EditCustomAttributes = "";
            if (!$this->title->Raw) {
                $this->title->CurrentValue = HtmlDecode($this->title->CurrentValue);
            }
            $this->title->EditValue = HtmlEncode($this->title->CurrentValue);
            $this->title->PlaceHolder = RemoveHtml($this->title->caption());

            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "";
            if (!$this->kode->Raw) {
                $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
            }
            $this->kode->EditValue = HtmlEncode($this->kode->CurrentValue);
            $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

            // logo
            $this->logo->EditAttrs["class"] = "form-control";
            $this->logo->EditCustomAttributes = "";
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->ImageAlt = $this->logo->alt();
                $this->logo->EditValue = $this->logo->Upload->DbValue;
            } else {
                $this->logo->EditValue = "";
            }
            if (!EmptyValue($this->logo->CurrentValue)) {
                $this->logo->Upload->FileName = $this->logo->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->logo);
            }

            // titipmerk
            $this->titipmerk->EditCustomAttributes = "";
            $this->titipmerk->EditValue = $this->titipmerk->options(false);
            $this->titipmerk->PlaceHolder = RemoveHtml($this->titipmerk->caption());

            // ijinhaki
            $this->ijinhaki->EditCustomAttributes = "";
            $this->ijinhaki->EditValue = $this->ijinhaki->options(false);
            $this->ijinhaki->PlaceHolder = RemoveHtml($this->ijinhaki->caption());

            // ijinbpom
            $this->ijinbpom->EditCustomAttributes = "";
            $this->ijinbpom->EditValue = $this->ijinbpom->options(false);
            $this->ijinbpom->PlaceHolder = RemoveHtml($this->ijinbpom->caption());

            // aktaperusahaan
            $this->aktaperusahaan->EditAttrs["class"] = "form-control";
            $this->aktaperusahaan->EditCustomAttributes = "";
            if (!EmptyValue($this->aktaperusahaan->Upload->DbValue)) {
                $this->aktaperusahaan->ImageAlt = $this->aktaperusahaan->alt();
                $this->aktaperusahaan->EditValue = $this->aktaperusahaan->Upload->DbValue;
            } else {
                $this->aktaperusahaan->EditValue = "";
            }
            if (!EmptyValue($this->aktaperusahaan->CurrentValue)) {
                $this->aktaperusahaan->Upload->FileName = $this->aktaperusahaan->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->aktaperusahaan);
            }

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->CurrentValue = CurrentUserID();

            // Add refer script

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // title
            $this->title->LinkCustomAttributes = "";
            $this->title->HrefValue = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";

            // logo
            $this->logo->LinkCustomAttributes = "";
            if (!EmptyValue($this->logo->Upload->DbValue)) {
                $this->logo->HrefValue = GetFileUploadUrl($this->logo, $this->logo->htmlDecode($this->logo->Upload->DbValue)); // Add prefix/suffix
                $this->logo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->logo->HrefValue = FullUrl($this->logo->HrefValue, "href");
                }
            } else {
                $this->logo->HrefValue = "";
            }
            $this->logo->ExportHrefValue = $this->logo->UploadPath . $this->logo->Upload->DbValue;

            // titipmerk
            $this->titipmerk->LinkCustomAttributes = "";
            $this->titipmerk->HrefValue = "";

            // ijinhaki
            $this->ijinhaki->LinkCustomAttributes = "";
            $this->ijinhaki->HrefValue = "";

            // ijinbpom
            $this->ijinbpom->LinkCustomAttributes = "";
            $this->ijinbpom->HrefValue = "";

            // aktaperusahaan
            $this->aktaperusahaan->LinkCustomAttributes = "";
            if (!EmptyValue($this->aktaperusahaan->Upload->DbValue)) {
                $this->aktaperusahaan->HrefValue = GetFileUploadUrl($this->aktaperusahaan, $this->aktaperusahaan->htmlDecode($this->aktaperusahaan->Upload->DbValue)); // Add prefix/suffix
                $this->aktaperusahaan->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->aktaperusahaan->HrefValue = FullUrl($this->aktaperusahaan->HrefValue, "href");
                }
            } else {
                $this->aktaperusahaan->HrefValue = "";
            }
            $this->aktaperusahaan->ExportHrefValue = $this->aktaperusahaan->UploadPath . $this->aktaperusahaan->Upload->DbValue;

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
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if ($this->title->Required) {
            if (!$this->title->IsDetailKey && EmptyValue($this->title->FormValue)) {
                $this->title->addErrorMessage(str_replace("%s", $this->title->caption(), $this->title->RequiredErrorMessage));
            }
        }
        if ($this->kode->Required) {
            if (!$this->kode->IsDetailKey && EmptyValue($this->kode->FormValue)) {
                $this->kode->addErrorMessage(str_replace("%s", $this->kode->caption(), $this->kode->RequiredErrorMessage));
            }
        }
        if ($this->logo->Required) {
            if ($this->logo->Upload->FileName == "" && !$this->logo->Upload->KeepFile) {
                $this->logo->addErrorMessage(str_replace("%s", $this->logo->caption(), $this->logo->RequiredErrorMessage));
            }
        }
        if ($this->titipmerk->Required) {
            if ($this->titipmerk->FormValue == "") {
                $this->titipmerk->addErrorMessage(str_replace("%s", $this->titipmerk->caption(), $this->titipmerk->RequiredErrorMessage));
            }
        }
        if ($this->ijinhaki->Required) {
            if ($this->ijinhaki->FormValue == "") {
                $this->ijinhaki->addErrorMessage(str_replace("%s", $this->ijinhaki->caption(), $this->ijinhaki->RequiredErrorMessage));
            }
        }
        if ($this->ijinbpom->Required) {
            if ($this->ijinbpom->FormValue == "") {
                $this->ijinbpom->addErrorMessage(str_replace("%s", $this->ijinbpom->caption(), $this->ijinbpom->RequiredErrorMessage));
            }
        }
        if ($this->aktaperusahaan->Required) {
            if ($this->aktaperusahaan->Upload->FileName == "" && !$this->aktaperusahaan->Upload->KeepFile) {
                $this->aktaperusahaan->addErrorMessage(str_replace("%s", $this->aktaperusahaan->caption(), $this->aktaperusahaan->RequiredErrorMessage));
            }
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ProductGrid");
        if (in_array("product", $detailTblVar) && $detailPage->DetailAdd) {
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

        // idcustomer
        $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, null, false);

        // title
        $this->title->setDbValueDef($rsnew, $this->title->CurrentValue, "", false);

        // kode
        $this->kode->setDbValueDef($rsnew, $this->kode->CurrentValue, null, false);

        // logo
        if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
            $this->logo->Upload->DbValue = ""; // No need to delete old file
            if ($this->logo->Upload->FileName == "") {
                $rsnew['logo'] = null;
            } else {
                $rsnew['logo'] = $this->logo->Upload->FileName;
            }
        }

        // titipmerk
        $this->titipmerk->setDbValueDef($rsnew, $this->titipmerk->CurrentValue, 0, strval($this->titipmerk->CurrentValue) == "");

        // ijinhaki
        $this->ijinhaki->setDbValueDef($rsnew, $this->ijinhaki->CurrentValue, 0, strval($this->ijinhaki->CurrentValue) == "");

        // ijinbpom
        $this->ijinbpom->setDbValueDef($rsnew, $this->ijinbpom->CurrentValue, null, false);

        // aktaperusahaan
        if ($this->aktaperusahaan->Visible && !$this->aktaperusahaan->Upload->KeepFile) {
            $this->aktaperusahaan->Upload->DbValue = ""; // No need to delete old file
            if ($this->aktaperusahaan->Upload->FileName == "") {
                $rsnew['aktaperusahaan'] = null;
            } else {
                $rsnew['aktaperusahaan'] = $this->aktaperusahaan->Upload->FileName;
            }
        }

        // created_by
        $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, false);
        if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->logo->Upload->DbValue) ? [] : [$this->logo->htmlDecode($this->logo->Upload->DbValue)];
            if (!EmptyValue($this->logo->Upload->FileName)) {
                $newFiles = [$this->logo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->logo, $this->logo->Upload->Index);
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
                            $file1 = UniqueFilename($this->logo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->logo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->logo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->logo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->logo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->logo->setDbValueDef($rsnew, $this->logo->Upload->FileName, null, false);
            }
        }
        if ($this->aktaperusahaan->Visible && !$this->aktaperusahaan->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->aktaperusahaan->Upload->DbValue) ? [] : [$this->aktaperusahaan->htmlDecode($this->aktaperusahaan->Upload->DbValue)];
            if (!EmptyValue($this->aktaperusahaan->Upload->FileName)) {
                $newFiles = [$this->aktaperusahaan->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->aktaperusahaan, $this->aktaperusahaan->Upload->Index);
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
                            $file1 = UniqueFilename($this->aktaperusahaan->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->aktaperusahaan->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->aktaperusahaan->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->aktaperusahaan->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->aktaperusahaan->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->aktaperusahaan->setDbValueDef($rsnew, $this->aktaperusahaan->Upload->FileName, null, false);
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
                if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->logo->Upload->DbValue) ? [] : [$this->logo->htmlDecode($this->logo->Upload->DbValue)];
                    if (!EmptyValue($this->logo->Upload->FileName)) {
                        $newFiles = [$this->logo->Upload->FileName];
                        $newFiles2 = [$this->logo->htmlDecode($rsnew['logo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->logo, $this->logo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->logo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->logo->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->aktaperusahaan->Visible && !$this->aktaperusahaan->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->aktaperusahaan->Upload->DbValue) ? [] : [$this->aktaperusahaan->htmlDecode($this->aktaperusahaan->Upload->DbValue)];
                    if (!EmptyValue($this->aktaperusahaan->Upload->FileName)) {
                        $newFiles = [$this->aktaperusahaan->Upload->FileName];
                        $newFiles2 = [$this->aktaperusahaan->htmlDecode($rsnew['aktaperusahaan'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->aktaperusahaan, $this->aktaperusahaan->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->aktaperusahaan->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->aktaperusahaan->oldPhysicalUploadPath() . $oldFile);
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
            $detailPage = Container("ProductGrid");
            if (in_array("product", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idbrand->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "product"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idbrand->setSessionValue(""); // Clear master key if insert failed
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
            // logo
            CleanUploadTempPath($this->logo, $this->logo->Upload->Index);

            // aktaperusahaan
            CleanUploadTempPath($this->aktaperusahaan, $this->aktaperusahaan->Upload->Index);
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
            if ($masterTblVar == "customer") {
                $validMaster = true;
                $masterTbl = Container("customer");
                if (($parm = Get("fk_id", Get("idcustomer"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idcustomer->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idcustomer->setSessionValue($this->idcustomer->QueryStringValue);
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
            if ($masterTblVar == "customer") {
                $validMaster = true;
                $masterTbl = Container("customer");
                if (($parm = Post("fk_id", Post("idcustomer"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idcustomer->setFormValue($masterTbl->id->FormValue);
                    $this->idcustomer->setSessionValue($this->idcustomer->FormValue);
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
            if ($masterTblVar != "customer") {
                if ($this->idcustomer->CurrentValue == "") {
                    $this->idcustomer->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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
            if (in_array("product", $detailTblVar)) {
                $detailPageObj = Container("ProductGrid");
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
                    $detailPageObj->idbrand->IsDetailKey = true;
                    $detailPageObj->idbrand->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idbrand->setSessionValue($detailPageObj->idbrand->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("BrandList"), "", $this->TableVar, true);
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
                case "x_idcustomer":
                    break;
                case "x_titipmerk":
                    break;
                case "x_ijinhaki":
                    break;
                case "x_ijinbpom":
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
        $count = ExecuteScalar("SELECT COUNT(*) FROM brand WHERE kode='".$this->kode->FormValue."'");
        if ($count>0) {
        	$customError = "Kode Brand sudah terpakai.";
    //        $this->kode->addErrorMessage("Kode Brand sudah terpakai.");
            return false;
        }
        return true;
    }
}
