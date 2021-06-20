<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class VNpdCustomerList extends VNpdCustomer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'v_npd_customer';

    // Page object name
    public $PageObjName = "VNpdCustomerList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fv_npd_customerlist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (v_npd_customer)
        if (!isset($GLOBALS["v_npd_customer"]) || get_class($GLOBALS["v_npd_customer"]) == PROJECT_NAMESPACE . "v_npd_customer") {
            $GLOBALS["v_npd_customer"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "VNpdCustomerAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "VNpdCustomerDelete";
        $this->MultiUpdateUrl = "VNpdCustomerUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'v_npd_customer');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fv_npd_customerlistsrch";

        // List actions
        $this->ListActions = new ListActions();
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
                $doc = new $class(Container("v_npd_customer"));
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 15;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,15,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id->setVisibility();
        $this->statuskategori->setVisibility();
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->kodeorder->setVisibility();
        $this->idbrand->setVisibility();
        $this->nama->setVisibility();
        $this->idkategoribarang->setVisibility();
        $this->idjenisbarang->setVisibility();
        $this->idproduct_acuan->setVisibility();
        $this->idkualitasbarang->setVisibility();
        $this->kemasanbarang->setVisibility();
        $this->label->setVisibility();
        $this->bahan->setVisibility();
        $this->ukuran->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->harga->setVisibility();
        $this->tambahan->setVisibility();
        $this->orderperdana->setVisibility();
        $this->orderreguler->setVisibility();
        $this->status->setVisibility();
        $this->idproduct->setVisibility();
        $this->created_at->setVisibility();
        $this->created_by->setVisibility();
        $this->selesai->setVisibility();
        $this->readonly->setVisibility();
        $this->nama_pemesan->setVisibility();
        $this->alamat_pemesan->setVisibility();
        $this->jabatan_pemesan->setVisibility();
        $this->hp_pemesan->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 15; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new NumericPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 15; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->statuskategori->AdvancedSearch->toJson(), ","); // Field statuskategori
        $filterList = Concat($filterList, $this->idpegawai->AdvancedSearch->toJson(), ","); // Field idpegawai
        $filterList = Concat($filterList, $this->idcustomer->AdvancedSearch->toJson(), ","); // Field idcustomer
        $filterList = Concat($filterList, $this->kodeorder->AdvancedSearch->toJson(), ","); // Field kodeorder
        $filterList = Concat($filterList, $this->idbrand->AdvancedSearch->toJson(), ","); // Field idbrand
        $filterList = Concat($filterList, $this->nama->AdvancedSearch->toJson(), ","); // Field nama
        $filterList = Concat($filterList, $this->idkategoribarang->AdvancedSearch->toJson(), ","); // Field idkategoribarang
        $filterList = Concat($filterList, $this->idjenisbarang->AdvancedSearch->toJson(), ","); // Field idjenisbarang
        $filterList = Concat($filterList, $this->idproduct_acuan->AdvancedSearch->toJson(), ","); // Field idproduct_acuan
        $filterList = Concat($filterList, $this->idkualitasbarang->AdvancedSearch->toJson(), ","); // Field idkualitasbarang
        $filterList = Concat($filterList, $this->kemasanbarang->AdvancedSearch->toJson(), ","); // Field kemasanbarang
        $filterList = Concat($filterList, $this->label->AdvancedSearch->toJson(), ","); // Field label
        $filterList = Concat($filterList, $this->bahan->AdvancedSearch->toJson(), ","); // Field bahan
        $filterList = Concat($filterList, $this->ukuran->AdvancedSearch->toJson(), ","); // Field ukuran
        $filterList = Concat($filterList, $this->warna->AdvancedSearch->toJson(), ","); // Field warna
        $filterList = Concat($filterList, $this->parfum->AdvancedSearch->toJson(), ","); // Field parfum
        $filterList = Concat($filterList, $this->harga->AdvancedSearch->toJson(), ","); // Field harga
        $filterList = Concat($filterList, $this->tambahan->AdvancedSearch->toJson(), ","); // Field tambahan
        $filterList = Concat($filterList, $this->orderperdana->AdvancedSearch->toJson(), ","); // Field orderperdana
        $filterList = Concat($filterList, $this->orderreguler->AdvancedSearch->toJson(), ","); // Field orderreguler
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->idproduct->AdvancedSearch->toJson(), ","); // Field idproduct
        $filterList = Concat($filterList, $this->created_at->AdvancedSearch->toJson(), ","); // Field created_at
        $filterList = Concat($filterList, $this->created_by->AdvancedSearch->toJson(), ","); // Field created_by
        $filterList = Concat($filterList, $this->selesai->AdvancedSearch->toJson(), ","); // Field selesai
        $filterList = Concat($filterList, $this->readonly->AdvancedSearch->toJson(), ","); // Field readonly
        $filterList = Concat($filterList, $this->nama_pemesan->AdvancedSearch->toJson(), ","); // Field nama_pemesan
        $filterList = Concat($filterList, $this->alamat_pemesan->AdvancedSearch->toJson(), ","); // Field alamat_pemesan
        $filterList = Concat($filterList, $this->jabatan_pemesan->AdvancedSearch->toJson(), ","); // Field jabatan_pemesan
        $filterList = Concat($filterList, $this->hp_pemesan->AdvancedSearch->toJson(), ","); // Field hp_pemesan
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fv_npd_customerlistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field id
        $this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
        $this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
        $this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
        $this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
        $this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
        $this->id->AdvancedSearch->save();

        // Field statuskategori
        $this->statuskategori->AdvancedSearch->SearchValue = @$filter["x_statuskategori"];
        $this->statuskategori->AdvancedSearch->SearchOperator = @$filter["z_statuskategori"];
        $this->statuskategori->AdvancedSearch->SearchCondition = @$filter["v_statuskategori"];
        $this->statuskategori->AdvancedSearch->SearchValue2 = @$filter["y_statuskategori"];
        $this->statuskategori->AdvancedSearch->SearchOperator2 = @$filter["w_statuskategori"];
        $this->statuskategori->AdvancedSearch->save();

        // Field idpegawai
        $this->idpegawai->AdvancedSearch->SearchValue = @$filter["x_idpegawai"];
        $this->idpegawai->AdvancedSearch->SearchOperator = @$filter["z_idpegawai"];
        $this->idpegawai->AdvancedSearch->SearchCondition = @$filter["v_idpegawai"];
        $this->idpegawai->AdvancedSearch->SearchValue2 = @$filter["y_idpegawai"];
        $this->idpegawai->AdvancedSearch->SearchOperator2 = @$filter["w_idpegawai"];
        $this->idpegawai->AdvancedSearch->save();

        // Field idcustomer
        $this->idcustomer->AdvancedSearch->SearchValue = @$filter["x_idcustomer"];
        $this->idcustomer->AdvancedSearch->SearchOperator = @$filter["z_idcustomer"];
        $this->idcustomer->AdvancedSearch->SearchCondition = @$filter["v_idcustomer"];
        $this->idcustomer->AdvancedSearch->SearchValue2 = @$filter["y_idcustomer"];
        $this->idcustomer->AdvancedSearch->SearchOperator2 = @$filter["w_idcustomer"];
        $this->idcustomer->AdvancedSearch->save();

        // Field kodeorder
        $this->kodeorder->AdvancedSearch->SearchValue = @$filter["x_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchOperator = @$filter["z_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchCondition = @$filter["v_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchValue2 = @$filter["y_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchOperator2 = @$filter["w_kodeorder"];
        $this->kodeorder->AdvancedSearch->save();

        // Field idbrand
        $this->idbrand->AdvancedSearch->SearchValue = @$filter["x_idbrand"];
        $this->idbrand->AdvancedSearch->SearchOperator = @$filter["z_idbrand"];
        $this->idbrand->AdvancedSearch->SearchCondition = @$filter["v_idbrand"];
        $this->idbrand->AdvancedSearch->SearchValue2 = @$filter["y_idbrand"];
        $this->idbrand->AdvancedSearch->SearchOperator2 = @$filter["w_idbrand"];
        $this->idbrand->AdvancedSearch->save();

        // Field nama
        $this->nama->AdvancedSearch->SearchValue = @$filter["x_nama"];
        $this->nama->AdvancedSearch->SearchOperator = @$filter["z_nama"];
        $this->nama->AdvancedSearch->SearchCondition = @$filter["v_nama"];
        $this->nama->AdvancedSearch->SearchValue2 = @$filter["y_nama"];
        $this->nama->AdvancedSearch->SearchOperator2 = @$filter["w_nama"];
        $this->nama->AdvancedSearch->save();

        // Field idkategoribarang
        $this->idkategoribarang->AdvancedSearch->SearchValue = @$filter["x_idkategoribarang"];
        $this->idkategoribarang->AdvancedSearch->SearchOperator = @$filter["z_idkategoribarang"];
        $this->idkategoribarang->AdvancedSearch->SearchCondition = @$filter["v_idkategoribarang"];
        $this->idkategoribarang->AdvancedSearch->SearchValue2 = @$filter["y_idkategoribarang"];
        $this->idkategoribarang->AdvancedSearch->SearchOperator2 = @$filter["w_idkategoribarang"];
        $this->idkategoribarang->AdvancedSearch->save();

        // Field idjenisbarang
        $this->idjenisbarang->AdvancedSearch->SearchValue = @$filter["x_idjenisbarang"];
        $this->idjenisbarang->AdvancedSearch->SearchOperator = @$filter["z_idjenisbarang"];
        $this->idjenisbarang->AdvancedSearch->SearchCondition = @$filter["v_idjenisbarang"];
        $this->idjenisbarang->AdvancedSearch->SearchValue2 = @$filter["y_idjenisbarang"];
        $this->idjenisbarang->AdvancedSearch->SearchOperator2 = @$filter["w_idjenisbarang"];
        $this->idjenisbarang->AdvancedSearch->save();

        // Field idproduct_acuan
        $this->idproduct_acuan->AdvancedSearch->SearchValue = @$filter["x_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchOperator = @$filter["z_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchCondition = @$filter["v_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchValue2 = @$filter["y_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchOperator2 = @$filter["w_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->save();

        // Field idkualitasbarang
        $this->idkualitasbarang->AdvancedSearch->SearchValue = @$filter["x_idkualitasbarang"];
        $this->idkualitasbarang->AdvancedSearch->SearchOperator = @$filter["z_idkualitasbarang"];
        $this->idkualitasbarang->AdvancedSearch->SearchCondition = @$filter["v_idkualitasbarang"];
        $this->idkualitasbarang->AdvancedSearch->SearchValue2 = @$filter["y_idkualitasbarang"];
        $this->idkualitasbarang->AdvancedSearch->SearchOperator2 = @$filter["w_idkualitasbarang"];
        $this->idkualitasbarang->AdvancedSearch->save();

        // Field kemasanbarang
        $this->kemasanbarang->AdvancedSearch->SearchValue = @$filter["x_kemasanbarang"];
        $this->kemasanbarang->AdvancedSearch->SearchOperator = @$filter["z_kemasanbarang"];
        $this->kemasanbarang->AdvancedSearch->SearchCondition = @$filter["v_kemasanbarang"];
        $this->kemasanbarang->AdvancedSearch->SearchValue2 = @$filter["y_kemasanbarang"];
        $this->kemasanbarang->AdvancedSearch->SearchOperator2 = @$filter["w_kemasanbarang"];
        $this->kemasanbarang->AdvancedSearch->save();

        // Field label
        $this->label->AdvancedSearch->SearchValue = @$filter["x_label"];
        $this->label->AdvancedSearch->SearchOperator = @$filter["z_label"];
        $this->label->AdvancedSearch->SearchCondition = @$filter["v_label"];
        $this->label->AdvancedSearch->SearchValue2 = @$filter["y_label"];
        $this->label->AdvancedSearch->SearchOperator2 = @$filter["w_label"];
        $this->label->AdvancedSearch->save();

        // Field bahan
        $this->bahan->AdvancedSearch->SearchValue = @$filter["x_bahan"];
        $this->bahan->AdvancedSearch->SearchOperator = @$filter["z_bahan"];
        $this->bahan->AdvancedSearch->SearchCondition = @$filter["v_bahan"];
        $this->bahan->AdvancedSearch->SearchValue2 = @$filter["y_bahan"];
        $this->bahan->AdvancedSearch->SearchOperator2 = @$filter["w_bahan"];
        $this->bahan->AdvancedSearch->save();

        // Field ukuran
        $this->ukuran->AdvancedSearch->SearchValue = @$filter["x_ukuran"];
        $this->ukuran->AdvancedSearch->SearchOperator = @$filter["z_ukuran"];
        $this->ukuran->AdvancedSearch->SearchCondition = @$filter["v_ukuran"];
        $this->ukuran->AdvancedSearch->SearchValue2 = @$filter["y_ukuran"];
        $this->ukuran->AdvancedSearch->SearchOperator2 = @$filter["w_ukuran"];
        $this->ukuran->AdvancedSearch->save();

        // Field warna
        $this->warna->AdvancedSearch->SearchValue = @$filter["x_warna"];
        $this->warna->AdvancedSearch->SearchOperator = @$filter["z_warna"];
        $this->warna->AdvancedSearch->SearchCondition = @$filter["v_warna"];
        $this->warna->AdvancedSearch->SearchValue2 = @$filter["y_warna"];
        $this->warna->AdvancedSearch->SearchOperator2 = @$filter["w_warna"];
        $this->warna->AdvancedSearch->save();

        // Field parfum
        $this->parfum->AdvancedSearch->SearchValue = @$filter["x_parfum"];
        $this->parfum->AdvancedSearch->SearchOperator = @$filter["z_parfum"];
        $this->parfum->AdvancedSearch->SearchCondition = @$filter["v_parfum"];
        $this->parfum->AdvancedSearch->SearchValue2 = @$filter["y_parfum"];
        $this->parfum->AdvancedSearch->SearchOperator2 = @$filter["w_parfum"];
        $this->parfum->AdvancedSearch->save();

        // Field harga
        $this->harga->AdvancedSearch->SearchValue = @$filter["x_harga"];
        $this->harga->AdvancedSearch->SearchOperator = @$filter["z_harga"];
        $this->harga->AdvancedSearch->SearchCondition = @$filter["v_harga"];
        $this->harga->AdvancedSearch->SearchValue2 = @$filter["y_harga"];
        $this->harga->AdvancedSearch->SearchOperator2 = @$filter["w_harga"];
        $this->harga->AdvancedSearch->save();

        // Field tambahan
        $this->tambahan->AdvancedSearch->SearchValue = @$filter["x_tambahan"];
        $this->tambahan->AdvancedSearch->SearchOperator = @$filter["z_tambahan"];
        $this->tambahan->AdvancedSearch->SearchCondition = @$filter["v_tambahan"];
        $this->tambahan->AdvancedSearch->SearchValue2 = @$filter["y_tambahan"];
        $this->tambahan->AdvancedSearch->SearchOperator2 = @$filter["w_tambahan"];
        $this->tambahan->AdvancedSearch->save();

        // Field orderperdana
        $this->orderperdana->AdvancedSearch->SearchValue = @$filter["x_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchOperator = @$filter["z_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchCondition = @$filter["v_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchValue2 = @$filter["y_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchOperator2 = @$filter["w_orderperdana"];
        $this->orderperdana->AdvancedSearch->save();

        // Field orderreguler
        $this->orderreguler->AdvancedSearch->SearchValue = @$filter["x_orderreguler"];
        $this->orderreguler->AdvancedSearch->SearchOperator = @$filter["z_orderreguler"];
        $this->orderreguler->AdvancedSearch->SearchCondition = @$filter["v_orderreguler"];
        $this->orderreguler->AdvancedSearch->SearchValue2 = @$filter["y_orderreguler"];
        $this->orderreguler->AdvancedSearch->SearchOperator2 = @$filter["w_orderreguler"];
        $this->orderreguler->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field idproduct
        $this->idproduct->AdvancedSearch->SearchValue = @$filter["x_idproduct"];
        $this->idproduct->AdvancedSearch->SearchOperator = @$filter["z_idproduct"];
        $this->idproduct->AdvancedSearch->SearchCondition = @$filter["v_idproduct"];
        $this->idproduct->AdvancedSearch->SearchValue2 = @$filter["y_idproduct"];
        $this->idproduct->AdvancedSearch->SearchOperator2 = @$filter["w_idproduct"];
        $this->idproduct->AdvancedSearch->save();

        // Field created_at
        $this->created_at->AdvancedSearch->SearchValue = @$filter["x_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator = @$filter["z_created_at"];
        $this->created_at->AdvancedSearch->SearchCondition = @$filter["v_created_at"];
        $this->created_at->AdvancedSearch->SearchValue2 = @$filter["y_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator2 = @$filter["w_created_at"];
        $this->created_at->AdvancedSearch->save();

        // Field created_by
        $this->created_by->AdvancedSearch->SearchValue = @$filter["x_created_by"];
        $this->created_by->AdvancedSearch->SearchOperator = @$filter["z_created_by"];
        $this->created_by->AdvancedSearch->SearchCondition = @$filter["v_created_by"];
        $this->created_by->AdvancedSearch->SearchValue2 = @$filter["y_created_by"];
        $this->created_by->AdvancedSearch->SearchOperator2 = @$filter["w_created_by"];
        $this->created_by->AdvancedSearch->save();

        // Field selesai
        $this->selesai->AdvancedSearch->SearchValue = @$filter["x_selesai"];
        $this->selesai->AdvancedSearch->SearchOperator = @$filter["z_selesai"];
        $this->selesai->AdvancedSearch->SearchCondition = @$filter["v_selesai"];
        $this->selesai->AdvancedSearch->SearchValue2 = @$filter["y_selesai"];
        $this->selesai->AdvancedSearch->SearchOperator2 = @$filter["w_selesai"];
        $this->selesai->AdvancedSearch->save();

        // Field readonly
        $this->readonly->AdvancedSearch->SearchValue = @$filter["x_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator = @$filter["z_readonly"];
        $this->readonly->AdvancedSearch->SearchCondition = @$filter["v_readonly"];
        $this->readonly->AdvancedSearch->SearchValue2 = @$filter["y_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator2 = @$filter["w_readonly"];
        $this->readonly->AdvancedSearch->save();

        // Field nama_pemesan
        $this->nama_pemesan->AdvancedSearch->SearchValue = @$filter["x_nama_pemesan"];
        $this->nama_pemesan->AdvancedSearch->SearchOperator = @$filter["z_nama_pemesan"];
        $this->nama_pemesan->AdvancedSearch->SearchCondition = @$filter["v_nama_pemesan"];
        $this->nama_pemesan->AdvancedSearch->SearchValue2 = @$filter["y_nama_pemesan"];
        $this->nama_pemesan->AdvancedSearch->SearchOperator2 = @$filter["w_nama_pemesan"];
        $this->nama_pemesan->AdvancedSearch->save();

        // Field alamat_pemesan
        $this->alamat_pemesan->AdvancedSearch->SearchValue = @$filter["x_alamat_pemesan"];
        $this->alamat_pemesan->AdvancedSearch->SearchOperator = @$filter["z_alamat_pemesan"];
        $this->alamat_pemesan->AdvancedSearch->SearchCondition = @$filter["v_alamat_pemesan"];
        $this->alamat_pemesan->AdvancedSearch->SearchValue2 = @$filter["y_alamat_pemesan"];
        $this->alamat_pemesan->AdvancedSearch->SearchOperator2 = @$filter["w_alamat_pemesan"];
        $this->alamat_pemesan->AdvancedSearch->save();

        // Field jabatan_pemesan
        $this->jabatan_pemesan->AdvancedSearch->SearchValue = @$filter["x_jabatan_pemesan"];
        $this->jabatan_pemesan->AdvancedSearch->SearchOperator = @$filter["z_jabatan_pemesan"];
        $this->jabatan_pemesan->AdvancedSearch->SearchCondition = @$filter["v_jabatan_pemesan"];
        $this->jabatan_pemesan->AdvancedSearch->SearchValue2 = @$filter["y_jabatan_pemesan"];
        $this->jabatan_pemesan->AdvancedSearch->SearchOperator2 = @$filter["w_jabatan_pemesan"];
        $this->jabatan_pemesan->AdvancedSearch->save();

        // Field hp_pemesan
        $this->hp_pemesan->AdvancedSearch->SearchValue = @$filter["x_hp_pemesan"];
        $this->hp_pemesan->AdvancedSearch->SearchOperator = @$filter["z_hp_pemesan"];
        $this->hp_pemesan->AdvancedSearch->SearchCondition = @$filter["v_hp_pemesan"];
        $this->hp_pemesan->AdvancedSearch->SearchValue2 = @$filter["y_hp_pemesan"];
        $this->hp_pemesan->AdvancedSearch->SearchOperator2 = @$filter["w_hp_pemesan"];
        $this->hp_pemesan->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->statuskategori, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kodeorder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->nama, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasanbarang, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->label, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bahan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuran, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->warna, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->parfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tambahan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->status, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->idproduct, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->nama_pemesan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->alamat_pemesan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jabatan_pemesan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->hp_pemesan, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->statuskategori); // statuskategori
            $this->updateSort($this->idpegawai); // idpegawai
            $this->updateSort($this->idcustomer); // idcustomer
            $this->updateSort($this->kodeorder); // kodeorder
            $this->updateSort($this->idbrand); // idbrand
            $this->updateSort($this->nama); // nama
            $this->updateSort($this->idkategoribarang); // idkategoribarang
            $this->updateSort($this->idjenisbarang); // idjenisbarang
            $this->updateSort($this->idproduct_acuan); // idproduct_acuan
            $this->updateSort($this->idkualitasbarang); // idkualitasbarang
            $this->updateSort($this->kemasanbarang); // kemasanbarang
            $this->updateSort($this->label); // label
            $this->updateSort($this->bahan); // bahan
            $this->updateSort($this->ukuran); // ukuran
            $this->updateSort($this->warna); // warna
            $this->updateSort($this->parfum); // parfum
            $this->updateSort($this->harga); // harga
            $this->updateSort($this->tambahan); // tambahan
            $this->updateSort($this->orderperdana); // orderperdana
            $this->updateSort($this->orderreguler); // orderreguler
            $this->updateSort($this->status); // status
            $this->updateSort($this->idproduct); // idproduct
            $this->updateSort($this->created_at); // created_at
            $this->updateSort($this->created_by); // created_by
            $this->updateSort($this->selesai); // selesai
            $this->updateSort($this->readonly); // readonly
            $this->updateSort($this->nama_pemesan); // nama_pemesan
            $this->updateSort($this->alamat_pemesan); // alamat_pemesan
            $this->updateSort($this->jabatan_pemesan); // jabatan_pemesan
            $this->updateSort($this->hp_pemesan); // hp_pemesan
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id->setSort("");
                $this->statuskategori->setSort("");
                $this->idpegawai->setSort("");
                $this->idcustomer->setSort("");
                $this->kodeorder->setSort("");
                $this->idbrand->setSort("");
                $this->nama->setSort("");
                $this->idkategoribarang->setSort("");
                $this->idjenisbarang->setSort("");
                $this->idproduct_acuan->setSort("");
                $this->idkualitasbarang->setSort("");
                $this->kemasanbarang->setSort("");
                $this->label->setSort("");
                $this->bahan->setSort("");
                $this->ukuran->setSort("");
                $this->warna->setSort("");
                $this->parfum->setSort("");
                $this->harga->setSort("");
                $this->tambahan->setSort("");
                $this->orderperdana->setSort("");
                $this->orderreguler->setSort("");
                $this->status->setSort("");
                $this->idproduct->setSort("");
                $this->created_at->setSort("");
                $this->created_by->setSort("");
                $this->selesai->setSort("");
                $this->readonly->setSort("");
                $this->nama_pemesan->setSort("");
                $this->alamat_pemesan->setSort("");
                $this->jabatan_pemesan->setSort("");
                $this->hp_pemesan->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = false;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") { // View mode
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fv_npd_customerlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fv_npd_customerlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fv_npd_customerlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
        // Hide detail items for dropdown if necessary
        $this->ListOptions->hideDetailItemsForDropDown();
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
        global $Security, $Language;
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $this->statuskategori->setDbValue($row['statuskategori']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->nama->setDbValue($row['nama']);
        $this->idkategoribarang->setDbValue($row['idkategoribarang']);
        $this->idjenisbarang->setDbValue($row['idjenisbarang']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->idkualitasbarang->setDbValue($row['idkualitasbarang']);
        $this->kemasanbarang->setDbValue($row['kemasanbarang']);
        $this->label->setDbValue($row['label']);
        $this->bahan->setDbValue($row['bahan']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->harga->setDbValue($row['harga']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderreguler->setDbValue($row['orderreguler']);
        $this->status->setDbValue($row['status']);
        $this->idproduct->setDbValue($row['idproduct']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->selesai->setDbValue($row['selesai']);
        $this->readonly->setDbValue($row['readonly']);
        $this->nama_pemesan->setDbValue($row['nama_pemesan']);
        $this->alamat_pemesan->setDbValue($row['alamat_pemesan']);
        $this->jabatan_pemesan->setDbValue($row['jabatan_pemesan']);
        $this->hp_pemesan->setDbValue($row['hp_pemesan']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['statuskategori'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['kodeorder'] = null;
        $row['idbrand'] = null;
        $row['nama'] = null;
        $row['idkategoribarang'] = null;
        $row['idjenisbarang'] = null;
        $row['idproduct_acuan'] = null;
        $row['idkualitasbarang'] = null;
        $row['kemasanbarang'] = null;
        $row['label'] = null;
        $row['bahan'] = null;
        $row['ukuran'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['harga'] = null;
        $row['tambahan'] = null;
        $row['orderperdana'] = null;
        $row['orderreguler'] = null;
        $row['status'] = null;
        $row['idproduct'] = null;
        $row['created_at'] = null;
        $row['created_by'] = null;
        $row['selesai'] = null;
        $row['readonly'] = null;
        $row['nama_pemesan'] = null;
        $row['alamat_pemesan'] = null;
        $row['jabatan_pemesan'] = null;
        $row['hp_pemesan'] = null;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // statuskategori

        // idpegawai

        // idcustomer

        // kodeorder

        // idbrand

        // nama

        // idkategoribarang

        // idjenisbarang

        // idproduct_acuan

        // idkualitasbarang

        // kemasanbarang

        // label

        // bahan

        // ukuran

        // warna

        // parfum

        // harga

        // tambahan

        // orderperdana

        // orderreguler

        // status

        // idproduct

        // created_at

        // created_by

        // selesai

        // readonly

        // nama_pemesan

        // alamat_pemesan

        // jabatan_pemesan

        // hp_pemesan
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // statuskategori
            $this->statuskategori->ViewValue = $this->statuskategori->CurrentValue;
            $this->statuskategori->ViewCustomAttributes = "";

            // idpegawai
            $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
            $this->idpegawai->ViewValue = FormatNumber($this->idpegawai->ViewValue, 0, -2, -2, -2);
            $this->idpegawai->ViewCustomAttributes = "";

            // idcustomer
            $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
            $this->idcustomer->ViewValue = FormatNumber($this->idcustomer->ViewValue, 0, -2, -2, -2);
            $this->idcustomer->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // idbrand
            $this->idbrand->ViewValue = $this->idbrand->CurrentValue;
            $this->idbrand->ViewValue = FormatNumber($this->idbrand->ViewValue, 0, -2, -2, -2);
            $this->idbrand->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // idkategoribarang
            $this->idkategoribarang->ViewValue = $this->idkategoribarang->CurrentValue;
            $this->idkategoribarang->ViewValue = FormatNumber($this->idkategoribarang->ViewValue, 0, -2, -2, -2);
            $this->idkategoribarang->ViewCustomAttributes = "";

            // idjenisbarang
            $this->idjenisbarang->ViewValue = $this->idjenisbarang->CurrentValue;
            $this->idjenisbarang->ViewValue = FormatNumber($this->idjenisbarang->ViewValue, 0, -2, -2, -2);
            $this->idjenisbarang->ViewCustomAttributes = "";

            // idproduct_acuan
            $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->CurrentValue;
            $this->idproduct_acuan->ViewValue = FormatNumber($this->idproduct_acuan->ViewValue, 0, -2, -2, -2);
            $this->idproduct_acuan->ViewCustomAttributes = "";

            // idkualitasbarang
            $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->CurrentValue;
            $this->idkualitasbarang->ViewValue = FormatNumber($this->idkualitasbarang->ViewValue, 0, -2, -2, -2);
            $this->idkualitasbarang->ViewCustomAttributes = "";

            // kemasanbarang
            $this->kemasanbarang->ViewValue = $this->kemasanbarang->CurrentValue;
            $this->kemasanbarang->ViewCustomAttributes = "";

            // label
            $this->label->ViewValue = $this->label->CurrentValue;
            $this->label->ViewCustomAttributes = "";

            // bahan
            $this->bahan->ViewValue = $this->bahan->CurrentValue;
            $this->bahan->ViewCustomAttributes = "";

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $this->parfum->ViewValue = $this->parfum->CurrentValue;
            $this->parfum->ViewCustomAttributes = "";

            // harga
            $this->harga->ViewValue = $this->harga->CurrentValue;
            $this->harga->ViewValue = FormatNumber($this->harga->ViewValue, 0, -2, -2, -2);
            $this->harga->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // orderperdana
            $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
            $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
            $this->orderperdana->ViewCustomAttributes = "";

            // orderreguler
            $this->orderreguler->ViewValue = $this->orderreguler->CurrentValue;
            $this->orderreguler->ViewValue = FormatNumber($this->orderreguler->ViewValue, 0, -2, -2, -2);
            $this->orderreguler->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // idproduct
            $this->idproduct->ViewValue = $this->idproduct->CurrentValue;
            $this->idproduct->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // selesai
            if (ConvertToBool($this->selesai->CurrentValue)) {
                $this->selesai->ViewValue = $this->selesai->tagCaption(1) != "" ? $this->selesai->tagCaption(1) : "Yes";
            } else {
                $this->selesai->ViewValue = $this->selesai->tagCaption(2) != "" ? $this->selesai->tagCaption(2) : "No";
            }
            $this->selesai->ViewCustomAttributes = "";

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

            // nama_pemesan
            $this->nama_pemesan->ViewValue = $this->nama_pemesan->CurrentValue;
            $this->nama_pemesan->ViewCustomAttributes = "";

            // alamat_pemesan
            $this->alamat_pemesan->ViewValue = $this->alamat_pemesan->CurrentValue;
            $this->alamat_pemesan->ViewCustomAttributes = "";

            // jabatan_pemesan
            $this->jabatan_pemesan->ViewValue = $this->jabatan_pemesan->CurrentValue;
            $this->jabatan_pemesan->ViewCustomAttributes = "";

            // hp_pemesan
            $this->hp_pemesan->ViewValue = $this->hp_pemesan->CurrentValue;
            $this->hp_pemesan->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // statuskategori
            $this->statuskategori->LinkCustomAttributes = "";
            $this->statuskategori->HrefValue = "";
            $this->statuskategori->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";
            $this->idbrand->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // idkategoribarang
            $this->idkategoribarang->LinkCustomAttributes = "";
            $this->idkategoribarang->HrefValue = "";
            $this->idkategoribarang->TooltipValue = "";

            // idjenisbarang
            $this->idjenisbarang->LinkCustomAttributes = "";
            $this->idjenisbarang->HrefValue = "";
            $this->idjenisbarang->TooltipValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";
            $this->idproduct_acuan->TooltipValue = "";

            // idkualitasbarang
            $this->idkualitasbarang->LinkCustomAttributes = "";
            $this->idkualitasbarang->HrefValue = "";
            $this->idkualitasbarang->TooltipValue = "";

            // kemasanbarang
            $this->kemasanbarang->LinkCustomAttributes = "";
            $this->kemasanbarang->HrefValue = "";
            $this->kemasanbarang->TooltipValue = "";

            // label
            $this->label->LinkCustomAttributes = "";
            $this->label->HrefValue = "";
            $this->label->TooltipValue = "";

            // bahan
            $this->bahan->LinkCustomAttributes = "";
            $this->bahan->HrefValue = "";
            $this->bahan->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";
            $this->harga->TooltipValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";
            $this->tambahan->TooltipValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";
            $this->orderperdana->TooltipValue = "";

            // orderreguler
            $this->orderreguler->LinkCustomAttributes = "";
            $this->orderreguler->HrefValue = "";
            $this->orderreguler->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // idproduct
            $this->idproduct->LinkCustomAttributes = "";
            $this->idproduct->HrefValue = "";
            $this->idproduct->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";

            // selesai
            $this->selesai->LinkCustomAttributes = "";
            $this->selesai->HrefValue = "";
            $this->selesai->TooltipValue = "";

            // readonly
            $this->readonly->LinkCustomAttributes = "";
            $this->readonly->HrefValue = "";
            $this->readonly->TooltipValue = "";

            // nama_pemesan
            $this->nama_pemesan->LinkCustomAttributes = "";
            $this->nama_pemesan->HrefValue = "";
            $this->nama_pemesan->TooltipValue = "";

            // alamat_pemesan
            $this->alamat_pemesan->LinkCustomAttributes = "";
            $this->alamat_pemesan->HrefValue = "";
            $this->alamat_pemesan->TooltipValue = "";

            // jabatan_pemesan
            $this->jabatan_pemesan->LinkCustomAttributes = "";
            $this->jabatan_pemesan->HrefValue = "";
            $this->jabatan_pemesan->TooltipValue = "";

            // hp_pemesan
            $this->hp_pemesan->LinkCustomAttributes = "";
            $this->hp_pemesan->HrefValue = "";
            $this->hp_pemesan->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv_npd_customerlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
