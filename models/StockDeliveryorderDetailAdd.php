<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class StockDeliveryorderDetailAdd extends StockDeliveryorderDetail
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'stock_deliveryorder_detail';

    // Page object name
    public $PageObjName = "StockDeliveryorderDetailAdd";

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

        // Table object (stock_deliveryorder_detail)
        if (!isset($GLOBALS["stock_deliveryorder_detail"]) || get_class($GLOBALS["stock_deliveryorder_detail"]) == PROJECT_NAMESPACE . "stock_deliveryorder_detail") {
            $GLOBALS["stock_deliveryorder_detail"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'stock_deliveryorder_detail');
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
                $doc = new $class(Container("stock_deliveryorder_detail"));
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
                    if ($pageName == "StockDeliveryorderDetailView") {
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
        $this->pid->Visible = false;
        $this->idstockorder->setVisibility();
        $this->idstockorder_detail->setVisibility();
        $this->totalorder->setVisibility();
        $this->sisa->setVisibility();
        $this->jumlahkirim->setVisibility();
        $this->keterangan->setVisibility();
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
        $this->setupLookupOptions($this->idstockorder);
        $this->setupLookupOptions($this->idstockorder_detail);

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
                    $this->terminate("StockDeliveryorderDetailList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "StockDeliveryorderDetailList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "StockDeliveryorderDetailView") {
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
        $this->pid->CurrentValue = null;
        $this->pid->OldValue = $this->pid->CurrentValue;
        $this->idstockorder->CurrentValue = null;
        $this->idstockorder->OldValue = $this->idstockorder->CurrentValue;
        $this->idstockorder_detail->CurrentValue = null;
        $this->idstockorder_detail->OldValue = $this->idstockorder_detail->CurrentValue;
        $this->totalorder->CurrentValue = null;
        $this->totalorder->OldValue = $this->totalorder->CurrentValue;
        $this->sisa->CurrentValue = null;
        $this->sisa->OldValue = $this->sisa->CurrentValue;
        $this->jumlahkirim->CurrentValue = null;
        $this->jumlahkirim->OldValue = $this->jumlahkirim->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idstockorder' first before field var 'x_idstockorder'
        $val = $CurrentForm->hasValue("idstockorder") ? $CurrentForm->getValue("idstockorder") : $CurrentForm->getValue("x_idstockorder");
        if (!$this->idstockorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idstockorder->Visible = false; // Disable update for API request
            } else {
                $this->idstockorder->setFormValue($val);
            }
        }

        // Check field name 'idstockorder_detail' first before field var 'x_idstockorder_detail'
        $val = $CurrentForm->hasValue("idstockorder_detail") ? $CurrentForm->getValue("idstockorder_detail") : $CurrentForm->getValue("x_idstockorder_detail");
        if (!$this->idstockorder_detail->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idstockorder_detail->Visible = false; // Disable update for API request
            } else {
                $this->idstockorder_detail->setFormValue($val);
            }
        }

        // Check field name 'totalorder' first before field var 'x_totalorder'
        $val = $CurrentForm->hasValue("totalorder") ? $CurrentForm->getValue("totalorder") : $CurrentForm->getValue("x_totalorder");
        if (!$this->totalorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totalorder->Visible = false; // Disable update for API request
            } else {
                $this->totalorder->setFormValue($val);
            }
        }

        // Check field name 'sisa' first before field var 'x_sisa'
        $val = $CurrentForm->hasValue("sisa") ? $CurrentForm->getValue("sisa") : $CurrentForm->getValue("x_sisa");
        if (!$this->sisa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sisa->Visible = false; // Disable update for API request
            } else {
                $this->sisa->setFormValue($val);
            }
        }

        // Check field name 'jumlahkirim' first before field var 'x_jumlahkirim'
        $val = $CurrentForm->hasValue("jumlahkirim") ? $CurrentForm->getValue("jumlahkirim") : $CurrentForm->getValue("x_jumlahkirim");
        if (!$this->jumlahkirim->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahkirim->Visible = false; // Disable update for API request
            } else {
                $this->jumlahkirim->setFormValue($val);
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idstockorder->CurrentValue = $this->idstockorder->FormValue;
        $this->idstockorder_detail->CurrentValue = $this->idstockorder_detail->FormValue;
        $this->totalorder->CurrentValue = $this->totalorder->FormValue;
        $this->sisa->CurrentValue = $this->sisa->FormValue;
        $this->jumlahkirim->CurrentValue = $this->jumlahkirim->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
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
        $this->pid->setDbValue($row['pid']);
        $this->idstockorder->setDbValue($row['idstockorder']);
        $this->idstockorder_detail->setDbValue($row['idstockorder_detail']);
        $this->totalorder->setDbValue($row['totalorder']);
        $this->sisa->setDbValue($row['sisa']);
        $this->jumlahkirim->setDbValue($row['jumlahkirim']);
        $this->keterangan->setDbValue($row['keterangan']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['pid'] = $this->pid->CurrentValue;
        $row['idstockorder'] = $this->idstockorder->CurrentValue;
        $row['idstockorder_detail'] = $this->idstockorder_detail->CurrentValue;
        $row['totalorder'] = $this->totalorder->CurrentValue;
        $row['sisa'] = $this->sisa->CurrentValue;
        $row['jumlahkirim'] = $this->jumlahkirim->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
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

        // pid

        // idstockorder

        // idstockorder_detail

        // totalorder

        // sisa

        // jumlahkirim

        // keterangan
        if ($this->RowType == ROWTYPE_VIEW) {
            // idstockorder
            $curVal = trim(strval($this->idstockorder->CurrentValue));
            if ($curVal != "") {
                $this->idstockorder->ViewValue = $this->idstockorder->lookupCacheOption($curVal);
                if ($this->idstockorder->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" ) ? "totalsisa > 0" : "";;
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idstockorder->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idstockorder->Lookup->renderViewRow($rswrk[0]);
                        $this->idstockorder->ViewValue = $this->idstockorder->displayValue($arwrk);
                    } else {
                        $this->idstockorder->ViewValue = $this->idstockorder->CurrentValue;
                    }
                }
            } else {
                $this->idstockorder->ViewValue = null;
            }
            $this->idstockorder->ViewCustomAttributes = "";

            // idstockorder_detail
            $curVal = trim(strval($this->idstockorder_detail->CurrentValue));
            if ($curVal != "") {
                $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->lookupCacheOption($curVal);
                if ($this->idstockorder_detail->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idstockorder_detail`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" ) ? "sisa_order > 0" : "";;
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idstockorder_detail->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idstockorder_detail->Lookup->renderViewRow($rswrk[0]);
                        $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->displayValue($arwrk);
                    } else {
                        $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->CurrentValue;
                    }
                }
            } else {
                $this->idstockorder_detail->ViewValue = null;
            }
            $this->idstockorder_detail->ViewCustomAttributes = "";

            // totalorder
            $this->totalorder->ViewValue = $this->totalorder->CurrentValue;
            $this->totalorder->ViewValue = FormatNumber($this->totalorder->ViewValue, 0, -2, -2, -2);
            $this->totalorder->ViewCustomAttributes = "";

            // sisa
            $this->sisa->ViewValue = $this->sisa->CurrentValue;
            $this->sisa->ViewValue = FormatNumber($this->sisa->ViewValue, 0, -2, -2, -2);
            $this->sisa->ViewCustomAttributes = "";

            // jumlahkirim
            $this->jumlahkirim->ViewValue = $this->jumlahkirim->CurrentValue;
            $this->jumlahkirim->ViewValue = FormatNumber($this->jumlahkirim->ViewValue, 0, -2, -2, -2);
            $this->jumlahkirim->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // idstockorder
            $this->idstockorder->LinkCustomAttributes = "";
            $this->idstockorder->HrefValue = "";
            $this->idstockorder->TooltipValue = "";

            // idstockorder_detail
            $this->idstockorder_detail->LinkCustomAttributes = "";
            $this->idstockorder_detail->HrefValue = "";
            $this->idstockorder_detail->TooltipValue = "";

            // totalorder
            $this->totalorder->LinkCustomAttributes = "";
            $this->totalorder->HrefValue = "";
            $this->totalorder->TooltipValue = "";

            // sisa
            $this->sisa->LinkCustomAttributes = "";
            $this->sisa->HrefValue = "";
            $this->sisa->TooltipValue = "";

            // jumlahkirim
            $this->jumlahkirim->LinkCustomAttributes = "";
            $this->jumlahkirim->HrefValue = "";
            $this->jumlahkirim->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idstockorder
            $this->idstockorder->EditAttrs["class"] = "form-control";
            $this->idstockorder->EditCustomAttributes = "";
            $curVal = trim(strval($this->idstockorder->CurrentValue));
            if ($curVal != "") {
                $this->idstockorder->ViewValue = $this->idstockorder->lookupCacheOption($curVal);
            } else {
                $this->idstockorder->ViewValue = $this->idstockorder->Lookup !== null && is_array($this->idstockorder->Lookup->Options) ? $curVal : null;
            }
            if ($this->idstockorder->ViewValue !== null) { // Load from cache
                $this->idstockorder->EditValue = array_values($this->idstockorder->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idstockorder->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" ) ? "totalsisa > 0" : "";;
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idstockorder->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->idstockorder->Lookup->renderViewRow($row);
                $this->idstockorder->EditValue = $arwrk;
            }
            $this->idstockorder->PlaceHolder = RemoveHtml($this->idstockorder->caption());

            // idstockorder_detail
            $this->idstockorder_detail->EditAttrs["class"] = "form-control";
            $this->idstockorder_detail->EditCustomAttributes = "";
            $curVal = trim(strval($this->idstockorder_detail->CurrentValue));
            if ($curVal != "") {
                $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->lookupCacheOption($curVal);
            } else {
                $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->Lookup !== null && is_array($this->idstockorder_detail->Lookup->Options) ? $curVal : null;
            }
            if ($this->idstockorder_detail->ViewValue !== null) { // Load from cache
                $this->idstockorder_detail->EditValue = array_values($this->idstockorder_detail->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`idstockorder_detail`" . SearchString("=", $this->idstockorder_detail->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" ) ? "sisa_order > 0" : "";;
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idstockorder_detail->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idstockorder_detail->EditValue = $arwrk;
            }
            $this->idstockorder_detail->PlaceHolder = RemoveHtml($this->idstockorder_detail->caption());

            // totalorder
            $this->totalorder->EditAttrs["class"] = "form-control";
            $this->totalorder->EditCustomAttributes = "readonly";
            $this->totalorder->EditValue = HtmlEncode($this->totalorder->CurrentValue);
            $this->totalorder->PlaceHolder = RemoveHtml($this->totalorder->caption());

            // sisa
            $this->sisa->EditAttrs["class"] = "form-control";
            $this->sisa->EditCustomAttributes = "readonly";
            $this->sisa->EditValue = HtmlEncode($this->sisa->CurrentValue);
            $this->sisa->PlaceHolder = RemoveHtml($this->sisa->caption());

            // jumlahkirim
            $this->jumlahkirim->EditAttrs["class"] = "form-control";
            $this->jumlahkirim->EditCustomAttributes = "";
            $this->jumlahkirim->EditValue = HtmlEncode($this->jumlahkirim->CurrentValue);
            $this->jumlahkirim->PlaceHolder = RemoveHtml($this->jumlahkirim->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // Add refer script

            // idstockorder
            $this->idstockorder->LinkCustomAttributes = "";
            $this->idstockorder->HrefValue = "";

            // idstockorder_detail
            $this->idstockorder_detail->LinkCustomAttributes = "";
            $this->idstockorder_detail->HrefValue = "";

            // totalorder
            $this->totalorder->LinkCustomAttributes = "";
            $this->totalorder->HrefValue = "";

            // sisa
            $this->sisa->LinkCustomAttributes = "";
            $this->sisa->HrefValue = "";

            // jumlahkirim
            $this->jumlahkirim->LinkCustomAttributes = "";
            $this->jumlahkirim->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
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
        if ($this->idstockorder->Required) {
            if (!$this->idstockorder->IsDetailKey && EmptyValue($this->idstockorder->FormValue)) {
                $this->idstockorder->addErrorMessage(str_replace("%s", $this->idstockorder->caption(), $this->idstockorder->RequiredErrorMessage));
            }
        }
        if ($this->idstockorder_detail->Required) {
            if (!$this->idstockorder_detail->IsDetailKey && EmptyValue($this->idstockorder_detail->FormValue)) {
                $this->idstockorder_detail->addErrorMessage(str_replace("%s", $this->idstockorder_detail->caption(), $this->idstockorder_detail->RequiredErrorMessage));
            }
        }
        if ($this->totalorder->Required) {
            if (!$this->totalorder->IsDetailKey && EmptyValue($this->totalorder->FormValue)) {
                $this->totalorder->addErrorMessage(str_replace("%s", $this->totalorder->caption(), $this->totalorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->totalorder->FormValue)) {
            $this->totalorder->addErrorMessage($this->totalorder->getErrorMessage(false));
        }
        if ($this->sisa->Required) {
            if (!$this->sisa->IsDetailKey && EmptyValue($this->sisa->FormValue)) {
                $this->sisa->addErrorMessage(str_replace("%s", $this->sisa->caption(), $this->sisa->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->sisa->FormValue)) {
            $this->sisa->addErrorMessage($this->sisa->getErrorMessage(false));
        }
        if ($this->jumlahkirim->Required) {
            if (!$this->jumlahkirim->IsDetailKey && EmptyValue($this->jumlahkirim->FormValue)) {
                $this->jumlahkirim->addErrorMessage(str_replace("%s", $this->jumlahkirim->caption(), $this->jumlahkirim->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahkirim->FormValue)) {
            $this->jumlahkirim->addErrorMessage($this->jumlahkirim->getErrorMessage(false));
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
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

        // Check referential integrity for master table 'stock_deliveryorder_detail'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_stock_deliveryorder();
        if ($this->pid->getSessionValue() != "") {
        $masterFilter = str_replace("@id@", AdjustSql($this->pid->getSessionValue(), "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("stock_deliveryorder")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "stock_deliveryorder", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idstockorder
        $this->idstockorder->setDbValueDef($rsnew, $this->idstockorder->CurrentValue, 0, false);

        // idstockorder_detail
        $this->idstockorder_detail->setDbValueDef($rsnew, $this->idstockorder_detail->CurrentValue, 0, false);

        // totalorder
        $this->totalorder->setDbValueDef($rsnew, $this->totalorder->CurrentValue, 0, false);

        // sisa
        $this->sisa->setDbValueDef($rsnew, $this->sisa->CurrentValue, 0, false);

        // jumlahkirim
        $this->jumlahkirim->setDbValueDef($rsnew, $this->jumlahkirim->CurrentValue, 0, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, false);

        // pid
        if ($this->pid->getSessionValue() != "") {
            $rsnew['pid'] = $this->pid->getSessionValue();
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
            if ($masterTblVar == "stock_deliveryorder") {
                $validMaster = true;
                $masterTbl = Container("stock_deliveryorder");
                if (($parm = Get("fk_id", Get("pid"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->pid->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->pid->setSessionValue($this->pid->QueryStringValue);
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
            if ($masterTblVar == "stock_deliveryorder") {
                $validMaster = true;
                $masterTbl = Container("stock_deliveryorder");
                if (($parm = Post("fk_id", Post("pid"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->pid->setFormValue($masterTbl->id->FormValue);
                    $this->pid->setSessionValue($this->pid->FormValue);
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
            if ($masterTblVar != "stock_deliveryorder") {
                if ($this->pid->CurrentValue == "") {
                    $this->pid->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("StockDeliveryorderDetailList"), "", $this->TableVar, true);
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
                case "x_idstockorder":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" ) ? "totalsisa > 0" : "";;
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idstockorder_detail":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" ) ? "sisa_order > 0" : "";;
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
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
