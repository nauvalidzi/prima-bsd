<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdList extends Npd
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd';

    // Page object name
    public $PageObjName = "NpdList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpdlist";
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

        // Table object (npd)
        if (!isset($GLOBALS["npd"]) || get_class($GLOBALS["npd"]) == PROJECT_NAMESPACE . "npd") {
            $GLOBALS["npd"] = &$this;
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
        $this->AddUrl = "NpdAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "NpdDelete";
        $this->MultiUpdateUrl = "NpdUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fnpdlistsrch";

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
                $doc = new $class(Container("npd"));
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
        $this->id->Visible = false;
        $this->tanggal_order->setVisibility();
        $this->target_selesai->setVisibility();
        $this->status->setVisibility();
        $this->kodeorder->setVisibility();
        $this->nomororder->setVisibility();
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idproduct_acuan->Visible = false;
        $this->idjenisproduk->Visible = false;
        $this->idkategoriproduk->Visible = false;
        $this->fungsiproduk->Visible = false;
        $this->kualitasproduk->Visible = false;
        $this->bahan_campaign->Visible = false;
        $this->ukuran_sediaan->Visible = false;
        $this->bentuk->Visible = false;
        $this->viskositas->Visible = false;
        $this->warna->Visible = false;
        $this->parfum->Visible = false;
        $this->aplikasi->Visible = false;
        $this->estetika->Visible = false;
        $this->tambahan->Visible = false;
        $this->ukurankemasan->Visible = false;
        $this->kemasanbentuk->Visible = false;
        $this->kemasantutup->Visible = false;
        $this->kemasancatatan->Visible = false;
        $this->labelbahan->Visible = false;
        $this->labelkualitas->Visible = false;
        $this->labelposisi->Visible = false;
        $this->labelcatatan->Visible = false;
        $this->statusdokumen->Visible = false;
        $this->readonly->Visible = false;
        $this->selesai->Visible = false;
        $this->created_at->Visible = false;
        $this->updated_at->setVisibility();
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
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->idjenisproduk);
        $this->setupLookupOptions($this->idkategoriproduk);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->parfum);
        $this->setupLookupOptions($this->aplikasi);
        $this->setupLookupOptions($this->estetika);
        $this->setupLookupOptions($this->kemasanbentuk);
        $this->setupLookupOptions($this->kemasantutup);
        $this->setupLookupOptions($this->labelbahan);
        $this->setupLookupOptions($this->labelkualitas);
        $this->setupLookupOptions($this->labelposisi);

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
        $filterList = Concat($filterList, $this->tanggal_order->AdvancedSearch->toJson(), ","); // Field tanggal_order
        $filterList = Concat($filterList, $this->target_selesai->AdvancedSearch->toJson(), ","); // Field target_selesai
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->kodeorder->AdvancedSearch->toJson(), ","); // Field kodeorder
        $filterList = Concat($filterList, $this->nomororder->AdvancedSearch->toJson(), ","); // Field nomororder
        $filterList = Concat($filterList, $this->idpegawai->AdvancedSearch->toJson(), ","); // Field idpegawai
        $filterList = Concat($filterList, $this->idcustomer->AdvancedSearch->toJson(), ","); // Field idcustomer
        $filterList = Concat($filterList, $this->idproduct_acuan->AdvancedSearch->toJson(), ","); // Field idproduct_acuan
        $filterList = Concat($filterList, $this->idjenisproduk->AdvancedSearch->toJson(), ","); // Field idjenisproduk
        $filterList = Concat($filterList, $this->idkategoriproduk->AdvancedSearch->toJson(), ","); // Field idkategoriproduk
        $filterList = Concat($filterList, $this->fungsiproduk->AdvancedSearch->toJson(), ","); // Field fungsiproduk
        $filterList = Concat($filterList, $this->kualitasproduk->AdvancedSearch->toJson(), ","); // Field kualitasproduk
        $filterList = Concat($filterList, $this->bahan_campaign->AdvancedSearch->toJson(), ","); // Field bahan_campaign
        $filterList = Concat($filterList, $this->ukuran_sediaan->AdvancedSearch->toJson(), ","); // Field ukuran_sediaan
        $filterList = Concat($filterList, $this->bentuk->AdvancedSearch->toJson(), ","); // Field bentuk
        $filterList = Concat($filterList, $this->viskositas->AdvancedSearch->toJson(), ","); // Field viskositas
        $filterList = Concat($filterList, $this->warna->AdvancedSearch->toJson(), ","); // Field warna
        $filterList = Concat($filterList, $this->parfum->AdvancedSearch->toJson(), ","); // Field parfum
        $filterList = Concat($filterList, $this->aplikasi->AdvancedSearch->toJson(), ","); // Field aplikasi
        $filterList = Concat($filterList, $this->estetika->AdvancedSearch->toJson(), ","); // Field estetika
        $filterList = Concat($filterList, $this->tambahan->AdvancedSearch->toJson(), ","); // Field tambahan
        $filterList = Concat($filterList, $this->ukurankemasan->AdvancedSearch->toJson(), ","); // Field ukurankemasan
        $filterList = Concat($filterList, $this->kemasanbentuk->AdvancedSearch->toJson(), ","); // Field kemasanbentuk
        $filterList = Concat($filterList, $this->kemasantutup->AdvancedSearch->toJson(), ","); // Field kemasantutup
        $filterList = Concat($filterList, $this->kemasancatatan->AdvancedSearch->toJson(), ","); // Field kemasancatatan
        $filterList = Concat($filterList, $this->labelbahan->AdvancedSearch->toJson(), ","); // Field labelbahan
        $filterList = Concat($filterList, $this->labelkualitas->AdvancedSearch->toJson(), ","); // Field labelkualitas
        $filterList = Concat($filterList, $this->labelposisi->AdvancedSearch->toJson(), ","); // Field labelposisi
        $filterList = Concat($filterList, $this->labelcatatan->AdvancedSearch->toJson(), ","); // Field labelcatatan
        $filterList = Concat($filterList, $this->statusdokumen->AdvancedSearch->toJson(), ","); // Field statusdokumen
        $filterList = Concat($filterList, $this->readonly->AdvancedSearch->toJson(), ","); // Field readonly
        $filterList = Concat($filterList, $this->selesai->AdvancedSearch->toJson(), ","); // Field selesai
        $filterList = Concat($filterList, $this->created_at->AdvancedSearch->toJson(), ","); // Field created_at
        $filterList = Concat($filterList, $this->updated_at->AdvancedSearch->toJson(), ","); // Field updated_at
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fnpdlistsrch", $filters);
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

        // Field tanggal_order
        $this->tanggal_order->AdvancedSearch->SearchValue = @$filter["x_tanggal_order"];
        $this->tanggal_order->AdvancedSearch->SearchOperator = @$filter["z_tanggal_order"];
        $this->tanggal_order->AdvancedSearch->SearchCondition = @$filter["v_tanggal_order"];
        $this->tanggal_order->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_order"];
        $this->tanggal_order->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_order"];
        $this->tanggal_order->AdvancedSearch->save();

        // Field target_selesai
        $this->target_selesai->AdvancedSearch->SearchValue = @$filter["x_target_selesai"];
        $this->target_selesai->AdvancedSearch->SearchOperator = @$filter["z_target_selesai"];
        $this->target_selesai->AdvancedSearch->SearchCondition = @$filter["v_target_selesai"];
        $this->target_selesai->AdvancedSearch->SearchValue2 = @$filter["y_target_selesai"];
        $this->target_selesai->AdvancedSearch->SearchOperator2 = @$filter["w_target_selesai"];
        $this->target_selesai->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field kodeorder
        $this->kodeorder->AdvancedSearch->SearchValue = @$filter["x_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchOperator = @$filter["z_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchCondition = @$filter["v_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchValue2 = @$filter["y_kodeorder"];
        $this->kodeorder->AdvancedSearch->SearchOperator2 = @$filter["w_kodeorder"];
        $this->kodeorder->AdvancedSearch->save();

        // Field nomororder
        $this->nomororder->AdvancedSearch->SearchValue = @$filter["x_nomororder"];
        $this->nomororder->AdvancedSearch->SearchOperator = @$filter["z_nomororder"];
        $this->nomororder->AdvancedSearch->SearchCondition = @$filter["v_nomororder"];
        $this->nomororder->AdvancedSearch->SearchValue2 = @$filter["y_nomororder"];
        $this->nomororder->AdvancedSearch->SearchOperator2 = @$filter["w_nomororder"];
        $this->nomororder->AdvancedSearch->save();

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

        // Field idproduct_acuan
        $this->idproduct_acuan->AdvancedSearch->SearchValue = @$filter["x_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchOperator = @$filter["z_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchCondition = @$filter["v_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchValue2 = @$filter["y_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->SearchOperator2 = @$filter["w_idproduct_acuan"];
        $this->idproduct_acuan->AdvancedSearch->save();

        // Field idjenisproduk
        $this->idjenisproduk->AdvancedSearch->SearchValue = @$filter["x_idjenisproduk"];
        $this->idjenisproduk->AdvancedSearch->SearchOperator = @$filter["z_idjenisproduk"];
        $this->idjenisproduk->AdvancedSearch->SearchCondition = @$filter["v_idjenisproduk"];
        $this->idjenisproduk->AdvancedSearch->SearchValue2 = @$filter["y_idjenisproduk"];
        $this->idjenisproduk->AdvancedSearch->SearchOperator2 = @$filter["w_idjenisproduk"];
        $this->idjenisproduk->AdvancedSearch->save();

        // Field idkategoriproduk
        $this->idkategoriproduk->AdvancedSearch->SearchValue = @$filter["x_idkategoriproduk"];
        $this->idkategoriproduk->AdvancedSearch->SearchOperator = @$filter["z_idkategoriproduk"];
        $this->idkategoriproduk->AdvancedSearch->SearchCondition = @$filter["v_idkategoriproduk"];
        $this->idkategoriproduk->AdvancedSearch->SearchValue2 = @$filter["y_idkategoriproduk"];
        $this->idkategoriproduk->AdvancedSearch->SearchOperator2 = @$filter["w_idkategoriproduk"];
        $this->idkategoriproduk->AdvancedSearch->save();

        // Field fungsiproduk
        $this->fungsiproduk->AdvancedSearch->SearchValue = @$filter["x_fungsiproduk"];
        $this->fungsiproduk->AdvancedSearch->SearchOperator = @$filter["z_fungsiproduk"];
        $this->fungsiproduk->AdvancedSearch->SearchCondition = @$filter["v_fungsiproduk"];
        $this->fungsiproduk->AdvancedSearch->SearchValue2 = @$filter["y_fungsiproduk"];
        $this->fungsiproduk->AdvancedSearch->SearchOperator2 = @$filter["w_fungsiproduk"];
        $this->fungsiproduk->AdvancedSearch->save();

        // Field kualitasproduk
        $this->kualitasproduk->AdvancedSearch->SearchValue = @$filter["x_kualitasproduk"];
        $this->kualitasproduk->AdvancedSearch->SearchOperator = @$filter["z_kualitasproduk"];
        $this->kualitasproduk->AdvancedSearch->SearchCondition = @$filter["v_kualitasproduk"];
        $this->kualitasproduk->AdvancedSearch->SearchValue2 = @$filter["y_kualitasproduk"];
        $this->kualitasproduk->AdvancedSearch->SearchOperator2 = @$filter["w_kualitasproduk"];
        $this->kualitasproduk->AdvancedSearch->save();

        // Field bahan_campaign
        $this->bahan_campaign->AdvancedSearch->SearchValue = @$filter["x_bahan_campaign"];
        $this->bahan_campaign->AdvancedSearch->SearchOperator = @$filter["z_bahan_campaign"];
        $this->bahan_campaign->AdvancedSearch->SearchCondition = @$filter["v_bahan_campaign"];
        $this->bahan_campaign->AdvancedSearch->SearchValue2 = @$filter["y_bahan_campaign"];
        $this->bahan_campaign->AdvancedSearch->SearchOperator2 = @$filter["w_bahan_campaign"];
        $this->bahan_campaign->AdvancedSearch->save();

        // Field ukuran_sediaan
        $this->ukuran_sediaan->AdvancedSearch->SearchValue = @$filter["x_ukuran_sediaan"];
        $this->ukuran_sediaan->AdvancedSearch->SearchOperator = @$filter["z_ukuran_sediaan"];
        $this->ukuran_sediaan->AdvancedSearch->SearchCondition = @$filter["v_ukuran_sediaan"];
        $this->ukuran_sediaan->AdvancedSearch->SearchValue2 = @$filter["y_ukuran_sediaan"];
        $this->ukuran_sediaan->AdvancedSearch->SearchOperator2 = @$filter["w_ukuran_sediaan"];
        $this->ukuran_sediaan->AdvancedSearch->save();

        // Field bentuk
        $this->bentuk->AdvancedSearch->SearchValue = @$filter["x_bentuk"];
        $this->bentuk->AdvancedSearch->SearchOperator = @$filter["z_bentuk"];
        $this->bentuk->AdvancedSearch->SearchCondition = @$filter["v_bentuk"];
        $this->bentuk->AdvancedSearch->SearchValue2 = @$filter["y_bentuk"];
        $this->bentuk->AdvancedSearch->SearchOperator2 = @$filter["w_bentuk"];
        $this->bentuk->AdvancedSearch->save();

        // Field viskositas
        $this->viskositas->AdvancedSearch->SearchValue = @$filter["x_viskositas"];
        $this->viskositas->AdvancedSearch->SearchOperator = @$filter["z_viskositas"];
        $this->viskositas->AdvancedSearch->SearchCondition = @$filter["v_viskositas"];
        $this->viskositas->AdvancedSearch->SearchValue2 = @$filter["y_viskositas"];
        $this->viskositas->AdvancedSearch->SearchOperator2 = @$filter["w_viskositas"];
        $this->viskositas->AdvancedSearch->save();

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

        // Field aplikasi
        $this->aplikasi->AdvancedSearch->SearchValue = @$filter["x_aplikasi"];
        $this->aplikasi->AdvancedSearch->SearchOperator = @$filter["z_aplikasi"];
        $this->aplikasi->AdvancedSearch->SearchCondition = @$filter["v_aplikasi"];
        $this->aplikasi->AdvancedSearch->SearchValue2 = @$filter["y_aplikasi"];
        $this->aplikasi->AdvancedSearch->SearchOperator2 = @$filter["w_aplikasi"];
        $this->aplikasi->AdvancedSearch->save();

        // Field estetika
        $this->estetika->AdvancedSearch->SearchValue = @$filter["x_estetika"];
        $this->estetika->AdvancedSearch->SearchOperator = @$filter["z_estetika"];
        $this->estetika->AdvancedSearch->SearchCondition = @$filter["v_estetika"];
        $this->estetika->AdvancedSearch->SearchValue2 = @$filter["y_estetika"];
        $this->estetika->AdvancedSearch->SearchOperator2 = @$filter["w_estetika"];
        $this->estetika->AdvancedSearch->save();

        // Field tambahan
        $this->tambahan->AdvancedSearch->SearchValue = @$filter["x_tambahan"];
        $this->tambahan->AdvancedSearch->SearchOperator = @$filter["z_tambahan"];
        $this->tambahan->AdvancedSearch->SearchCondition = @$filter["v_tambahan"];
        $this->tambahan->AdvancedSearch->SearchValue2 = @$filter["y_tambahan"];
        $this->tambahan->AdvancedSearch->SearchOperator2 = @$filter["w_tambahan"];
        $this->tambahan->AdvancedSearch->save();

        // Field ukurankemasan
        $this->ukurankemasan->AdvancedSearch->SearchValue = @$filter["x_ukurankemasan"];
        $this->ukurankemasan->AdvancedSearch->SearchOperator = @$filter["z_ukurankemasan"];
        $this->ukurankemasan->AdvancedSearch->SearchCondition = @$filter["v_ukurankemasan"];
        $this->ukurankemasan->AdvancedSearch->SearchValue2 = @$filter["y_ukurankemasan"];
        $this->ukurankemasan->AdvancedSearch->SearchOperator2 = @$filter["w_ukurankemasan"];
        $this->ukurankemasan->AdvancedSearch->save();

        // Field kemasanbentuk
        $this->kemasanbentuk->AdvancedSearch->SearchValue = @$filter["x_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchOperator = @$filter["z_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchCondition = @$filter["v_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchValue2 = @$filter["y_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchOperator2 = @$filter["w_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->save();

        // Field kemasantutup
        $this->kemasantutup->AdvancedSearch->SearchValue = @$filter["x_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchOperator = @$filter["z_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchCondition = @$filter["v_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchValue2 = @$filter["y_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchOperator2 = @$filter["w_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->save();

        // Field kemasancatatan
        $this->kemasancatatan->AdvancedSearch->SearchValue = @$filter["x_kemasancatatan"];
        $this->kemasancatatan->AdvancedSearch->SearchOperator = @$filter["z_kemasancatatan"];
        $this->kemasancatatan->AdvancedSearch->SearchCondition = @$filter["v_kemasancatatan"];
        $this->kemasancatatan->AdvancedSearch->SearchValue2 = @$filter["y_kemasancatatan"];
        $this->kemasancatatan->AdvancedSearch->SearchOperator2 = @$filter["w_kemasancatatan"];
        $this->kemasancatatan->AdvancedSearch->save();

        // Field labelbahan
        $this->labelbahan->AdvancedSearch->SearchValue = @$filter["x_labelbahan"];
        $this->labelbahan->AdvancedSearch->SearchOperator = @$filter["z_labelbahan"];
        $this->labelbahan->AdvancedSearch->SearchCondition = @$filter["v_labelbahan"];
        $this->labelbahan->AdvancedSearch->SearchValue2 = @$filter["y_labelbahan"];
        $this->labelbahan->AdvancedSearch->SearchOperator2 = @$filter["w_labelbahan"];
        $this->labelbahan->AdvancedSearch->save();

        // Field labelkualitas
        $this->labelkualitas->AdvancedSearch->SearchValue = @$filter["x_labelkualitas"];
        $this->labelkualitas->AdvancedSearch->SearchOperator = @$filter["z_labelkualitas"];
        $this->labelkualitas->AdvancedSearch->SearchCondition = @$filter["v_labelkualitas"];
        $this->labelkualitas->AdvancedSearch->SearchValue2 = @$filter["y_labelkualitas"];
        $this->labelkualitas->AdvancedSearch->SearchOperator2 = @$filter["w_labelkualitas"];
        $this->labelkualitas->AdvancedSearch->save();

        // Field labelposisi
        $this->labelposisi->AdvancedSearch->SearchValue = @$filter["x_labelposisi"];
        $this->labelposisi->AdvancedSearch->SearchOperator = @$filter["z_labelposisi"];
        $this->labelposisi->AdvancedSearch->SearchCondition = @$filter["v_labelposisi"];
        $this->labelposisi->AdvancedSearch->SearchValue2 = @$filter["y_labelposisi"];
        $this->labelposisi->AdvancedSearch->SearchOperator2 = @$filter["w_labelposisi"];
        $this->labelposisi->AdvancedSearch->save();

        // Field labelcatatan
        $this->labelcatatan->AdvancedSearch->SearchValue = @$filter["x_labelcatatan"];
        $this->labelcatatan->AdvancedSearch->SearchOperator = @$filter["z_labelcatatan"];
        $this->labelcatatan->AdvancedSearch->SearchCondition = @$filter["v_labelcatatan"];
        $this->labelcatatan->AdvancedSearch->SearchValue2 = @$filter["y_labelcatatan"];
        $this->labelcatatan->AdvancedSearch->SearchOperator2 = @$filter["w_labelcatatan"];
        $this->labelcatatan->AdvancedSearch->save();

        // Field statusdokumen
        $this->statusdokumen->AdvancedSearch->SearchValue = @$filter["x_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchOperator = @$filter["z_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchCondition = @$filter["v_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchValue2 = @$filter["y_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchOperator2 = @$filter["w_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->save();

        // Field readonly
        $this->readonly->AdvancedSearch->SearchValue = @$filter["x_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator = @$filter["z_readonly"];
        $this->readonly->AdvancedSearch->SearchCondition = @$filter["v_readonly"];
        $this->readonly->AdvancedSearch->SearchValue2 = @$filter["y_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator2 = @$filter["w_readonly"];
        $this->readonly->AdvancedSearch->save();

        // Field selesai
        $this->selesai->AdvancedSearch->SearchValue = @$filter["x_selesai"];
        $this->selesai->AdvancedSearch->SearchOperator = @$filter["z_selesai"];
        $this->selesai->AdvancedSearch->SearchCondition = @$filter["v_selesai"];
        $this->selesai->AdvancedSearch->SearchValue2 = @$filter["y_selesai"];
        $this->selesai->AdvancedSearch->SearchOperator2 = @$filter["w_selesai"];
        $this->selesai->AdvancedSearch->save();

        // Field created_at
        $this->created_at->AdvancedSearch->SearchValue = @$filter["x_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator = @$filter["z_created_at"];
        $this->created_at->AdvancedSearch->SearchCondition = @$filter["v_created_at"];
        $this->created_at->AdvancedSearch->SearchValue2 = @$filter["y_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator2 = @$filter["w_created_at"];
        $this->created_at->AdvancedSearch->save();

        // Field updated_at
        $this->updated_at->AdvancedSearch->SearchValue = @$filter["x_updated_at"];
        $this->updated_at->AdvancedSearch->SearchOperator = @$filter["z_updated_at"];
        $this->updated_at->AdvancedSearch->SearchCondition = @$filter["v_updated_at"];
        $this->updated_at->AdvancedSearch->SearchValue2 = @$filter["y_updated_at"];
        $this->updated_at->AdvancedSearch->SearchOperator2 = @$filter["w_updated_at"];
        $this->updated_at->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->status, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kodeorder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->nomororder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->fungsiproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kualitasproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bahan_campaign, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuran_sediaan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bentuk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->viskositas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->warna, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->parfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->aplikasi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->estetika, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tambahan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukurankemasan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasantutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasancatatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelbahan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelkualitas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelposisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelcatatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->statusdokumen, $arKeywords, $type);
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
            $this->updateSort($this->tanggal_order); // tanggal_order
            $this->updateSort($this->target_selesai); // target_selesai
            $this->updateSort($this->status); // status
            $this->updateSort($this->kodeorder); // kodeorder
            $this->updateSort($this->nomororder); // nomororder
            $this->updateSort($this->idpegawai); // idpegawai
            $this->updateSort($this->idcustomer); // idcustomer
            $this->updateSort($this->updated_at); // updated_at
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "`id` ASC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->id->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->id->setSort("ASC");
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
                $this->tanggal_order->setSort("");
                $this->target_selesai->setSort("");
                $this->status->setSort("");
                $this->kodeorder->setSort("");
                $this->nomororder->setSort("");
                $this->idpegawai->setSort("");
                $this->idcustomer->setSort("");
                $this->idproduct_acuan->setSort("");
                $this->idjenisproduk->setSort("");
                $this->idkategoriproduk->setSort("");
                $this->fungsiproduk->setSort("");
                $this->kualitasproduk->setSort("");
                $this->bahan_campaign->setSort("");
                $this->ukuran_sediaan->setSort("");
                $this->bentuk->setSort("");
                $this->viskositas->setSort("");
                $this->warna->setSort("");
                $this->parfum->setSort("");
                $this->aplikasi->setSort("");
                $this->estetika->setSort("");
                $this->tambahan->setSort("");
                $this->ukurankemasan->setSort("");
                $this->kemasanbentuk->setSort("");
                $this->kemasantutup->setSort("");
                $this->kemasancatatan->setSort("");
                $this->labelbahan->setSort("");
                $this->labelkualitas->setSort("");
                $this->labelposisi->setSort("");
                $this->labelcatatan->setSort("");
                $this->statusdokumen->setSort("");
                $this->readonly->setSort("");
                $this->selesai->setSort("");
                $this->created_at->setSort("");
                $this->updated_at->setSort("");
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

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // "detail_npd_sample"
        $item = &$this->ListOptions->add("detail_npd_sample");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_sample') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_npd_review"
        $item = &$this->ListOptions->add("detail_npd_review");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_review') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_npd_confirm"
        $item = &$this->ListOptions->add("detail_npd_confirm");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_confirm') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_npd_harga"
        $item = &$this->ListOptions->add("detail_npd_harga");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_harga') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_npd_desain"
        $item = &$this->ListOptions->add("detail_npd_desain");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_desain') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_npd_terms"
        $item = &$this->ListOptions->add("detail_npd_terms");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_terms') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails;
            $item->OnLeft = false;
            $item->ShowInButtonGroup = false;
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("npd_sample");
        $pages->add("npd_review");
        $pages->add("npd_confirm");
        $pages->add("npd_harga");
        $pages->add("npd_desain");
        $pages->add("npd_terms");
        $this->DetailPages = $pages;

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
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
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
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_npd_sample"
        $opt = $this->ListOptions["detail_npd_sample"];
        if ($Security->allowList(CurrentProjectID() . 'npd_sample')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("npd_sample", "TblCaption");
            $body .= "&nbsp;" . str_replace("%c", Container("npd_sample")->Count, $Language->phrase("DetailCount"));
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("NpdSampleList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("NpdSampleGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_sample");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "npd_sample";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_sample");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "npd_sample";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_npd_review"
        $opt = $this->ListOptions["detail_npd_review"];
        if ($Security->allowList(CurrentProjectID() . 'npd_review')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("npd_review", "TblCaption");
            $body .= "&nbsp;" . str_replace("%c", Container("npd_review")->Count, $Language->phrase("DetailCount"));
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("NpdReviewList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("NpdReviewGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_review");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "npd_review";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_review");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "npd_review";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_npd_confirm"
        $opt = $this->ListOptions["detail_npd_confirm"];
        if ($Security->allowList(CurrentProjectID() . 'npd_confirm')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("npd_confirm", "TblCaption");
            $body .= "&nbsp;" . str_replace("%c", Container("npd_confirm")->Count, $Language->phrase("DetailCount"));
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("NpdConfirmList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("NpdConfirmGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirm");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "npd_confirm";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirm");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "npd_confirm";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_npd_harga"
        $opt = $this->ListOptions["detail_npd_harga"];
        if ($Security->allowList(CurrentProjectID() . 'npd_harga')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("npd_harga", "TblCaption");
            $body .= "&nbsp;" . str_replace("%c", Container("npd_harga")->Count, $Language->phrase("DetailCount"));
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("NpdHargaList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("NpdHargaGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_harga");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "npd_harga";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_harga");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "npd_harga";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_npd_desain"
        $opt = $this->ListOptions["detail_npd_desain"];
        if ($Security->allowList(CurrentProjectID() . 'npd_desain')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("npd_desain", "TblCaption");
            $body .= "&nbsp;" . str_replace("%c", Container("npd_desain")->Count, $Language->phrase("DetailCount"));
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("NpdDesainList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("NpdDesainGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_desain");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "npd_desain";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_desain");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "npd_desain";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_npd_terms"
        $opt = $this->ListOptions["detail_npd_terms"];
        if ($Security->allowList(CurrentProjectID() . 'npd_terms')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("npd_terms", "TblCaption");
            $body .= "&nbsp;" . str_replace("%c", Container("npd_terms")->Count, $Language->phrase("DetailCount"));
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("NpdTermsList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("NpdTermsGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_terms");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "npd_terms";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_terms");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "npd_terms";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode($this->GetCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailCopyLink")) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlTitle($Language->phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
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
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
                $item = &$option->add("detailadd_npd_sample");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=npd_sample");
                $detailPage = Container("NpdSampleGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'npd') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "npd_sample";
                }
                $item = &$option->add("detailadd_npd_review");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=npd_review");
                $detailPage = Container("NpdReviewGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'npd') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "npd_review";
                }
                $item = &$option->add("detailadd_npd_confirm");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirm");
                $detailPage = Container("NpdConfirmGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'npd') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "npd_confirm";
                }
                $item = &$option->add("detailadd_npd_harga");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=npd_harga");
                $detailPage = Container("NpdHargaGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'npd') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "npd_harga";
                }
                $item = &$option->add("detailadd_npd_desain");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=npd_desain");
                $detailPage = Container("NpdDesainGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'npd') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "npd_desain";
                }
                $item = &$option->add("detailadd_npd_terms");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=npd_terms");
                $detailPage = Container("NpdTermsGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'npd') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "npd_terms";
                }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            $item->Visible = $detailTableLink != "" && $Security->canAdd();
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fnpdlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fnpdlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fnpdlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $links = "";
        $btngrps = "";
        $sqlwrk = "`idnpd`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_npd_sample"
        if ($this->DetailPages && $this->DetailPages["npd_sample"] && $this->DetailPages["npd_sample"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_npd_sample"];
            $url = "NpdSamplePreview?t=npd&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"npd_sample\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'npd')) {
                $label = $Language->TablePhrase("npd_sample", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("npd_sample")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"npd_sample\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("NpdSampleList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("npd_sample", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("NpdSampleGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_sample");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_sample");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idnpd`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_npd_review"
        if ($this->DetailPages && $this->DetailPages["npd_review"] && $this->DetailPages["npd_review"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_npd_review"];
            $url = "NpdReviewPreview?t=npd&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"npd_review\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'npd')) {
                $label = $Language->TablePhrase("npd_review", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("npd_review")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"npd_review\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("NpdReviewList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("npd_review", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("NpdReviewGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_review");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_review");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idnpd`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_npd_confirm"
        if ($this->DetailPages && $this->DetailPages["npd_confirm"] && $this->DetailPages["npd_confirm"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_npd_confirm"];
            $url = "NpdConfirmPreview?t=npd&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"npd_confirm\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'npd')) {
                $label = $Language->TablePhrase("npd_confirm", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("npd_confirm")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"npd_confirm\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("NpdConfirmList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("npd_confirm", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("NpdConfirmGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirm");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirm");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idnpd`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_npd_harga"
        if ($this->DetailPages && $this->DetailPages["npd_harga"] && $this->DetailPages["npd_harga"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_npd_harga"];
            $url = "NpdHargaPreview?t=npd&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"npd_harga\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'npd')) {
                $label = $Language->TablePhrase("npd_harga", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("npd_harga")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"npd_harga\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("NpdHargaList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("npd_harga", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("NpdHargaGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_harga");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_harga");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idnpd`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_npd_desain"
        if ($this->DetailPages && $this->DetailPages["npd_desain"] && $this->DetailPages["npd_desain"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_npd_desain"];
            $url = "NpdDesainPreview?t=npd&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"npd_desain\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'npd')) {
                $label = $Language->TablePhrase("npd_desain", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("npd_desain")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"npd_desain\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("NpdDesainList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("npd_desain", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("NpdDesainGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_desain");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_desain");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idnpd`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_npd_terms"
        if ($this->DetailPages && $this->DetailPages["npd_terms"] && $this->DetailPages["npd_terms"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_npd_terms"];
            $url = "NpdTermsPreview?t=npd&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"npd_terms\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'npd')) {
                $label = $Language->TablePhrase("npd_terms", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("npd_terms")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"npd_terms\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("NpdTermsList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("npd_terms", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("NpdTermsGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_terms");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=npd_terms");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }

        // Hide detail items if necessary
        $this->ListOptions->hideDetailItemsForDropDown();

        // Column "preview"
        $option = $this->ListOptions["preview"];
        if (!$option) { // Add preview column
            $option = &$this->ListOptions->add("preview");
            $option->OnLeft = false;
            if ($option->OnLeft) {
                $option->moveTo($this->ListOptions->itemPos("checkbox") + 1);
            } else {
                $option->moveTo($this->ListOptions->itemPos("checkbox"));
            }
            $option->Visible = !($this->isExport() || $this->isGridAdd() || $this->isGridEdit());
            $option->ShowInDropDown = false;
            $option->ShowInButtonGroup = false;
        }
        if ($option) {
            $option->Body = "<i class=\"ew-preview-row-btn ew-icon icon-expand\"></i>";
            $option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }

        // Column "details" (Multiple details)
        $option = $this->ListOptions["details"];
        if ($option) {
            $option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }
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
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->status->setDbValue($row['status']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->idjenisproduk->setDbValue($row['idjenisproduk']);
        $this->idkategoriproduk->setDbValue($row['idkategoriproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->estetika->setDbValue($row['estetika']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->statusdokumen->setDbValue($row['statusdokumen']);
        $this->readonly->setDbValue($row['readonly']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $detailTbl = Container("npd_sample");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_review");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_confirm");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_harga");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_desain");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("npd_terms");
        $detailFilter = $detailTbl->sqlDetailFilter_npd();
        $detailFilter = str_replace("@idnpd@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("npd");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['tanggal_order'] = null;
        $row['target_selesai'] = null;
        $row['status'] = null;
        $row['kodeorder'] = null;
        $row['nomororder'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['idproduct_acuan'] = null;
        $row['idjenisproduk'] = null;
        $row['idkategoriproduk'] = null;
        $row['fungsiproduk'] = null;
        $row['kualitasproduk'] = null;
        $row['bahan_campaign'] = null;
        $row['ukuran_sediaan'] = null;
        $row['bentuk'] = null;
        $row['viskositas'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['aplikasi'] = null;
        $row['estetika'] = null;
        $row['tambahan'] = null;
        $row['ukurankemasan'] = null;
        $row['kemasanbentuk'] = null;
        $row['kemasantutup'] = null;
        $row['kemasancatatan'] = null;
        $row['labelbahan'] = null;
        $row['labelkualitas'] = null;
        $row['labelposisi'] = null;
        $row['labelcatatan'] = null;
        $row['statusdokumen'] = null;
        $row['readonly'] = null;
        $row['selesai'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
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

        // tanggal_order

        // target_selesai

        // status

        // kodeorder

        // nomororder

        // idpegawai

        // idcustomer

        // idproduct_acuan

        // idjenisproduk

        // idkategoriproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuran_sediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aplikasi

        // estetika

        // tambahan

        // ukurankemasan

        // kemasanbentuk

        // kemasantutup

        // kemasancatatan

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

        // statusdokumen

        // readonly

        // selesai

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // nomororder
            $this->nomororder->ViewValue = $this->nomororder->CurrentValue;
            $this->nomororder->ViewCustomAttributes = "";

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

            // idcustomer
            $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
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

            // idproduct_acuan
            $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
            if ($curVal != "") {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
                if ($this->idproduct_acuan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idproduct_acuan->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idproduct_acuan->Lookup->renderViewRow($rswrk[0]);
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->displayValue($arwrk);
                    } else {
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->CurrentValue;
                    }
                }
            } else {
                $this->idproduct_acuan->ViewValue = null;
            }
            $this->idproduct_acuan->ViewCustomAttributes = "";

            // idjenisproduk
            $curVal = trim(strval($this->idjenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->idjenisproduk->ViewValue = $this->idjenisproduk->lookupCacheOption($curVal);
                if ($this->idjenisproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idjenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idjenisproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->idjenisproduk->ViewValue = $this->idjenisproduk->displayValue($arwrk);
                    } else {
                        $this->idjenisproduk->ViewValue = $this->idjenisproduk->CurrentValue;
                    }
                }
            } else {
                $this->idjenisproduk->ViewValue = null;
            }
            $this->idjenisproduk->ViewCustomAttributes = "";

            // idkategoriproduk
            $curVal = trim(strval($this->idkategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->lookupCacheOption($curVal);
                if ($this->idkategoriproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkategoriproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->displayValue($arwrk);
                    } else {
                        $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->CurrentValue;
                    }
                }
            } else {
                $this->idkategoriproduk->ViewValue = null;
            }
            $this->idkategoriproduk->ViewCustomAttributes = "";

            // fungsiproduk
            $this->fungsiproduk->ViewValue = $this->fungsiproduk->CurrentValue;
            $this->fungsiproduk->ViewCustomAttributes = "";

            // kualitasproduk
            $this->kualitasproduk->ViewValue = $this->kualitasproduk->CurrentValue;
            $this->kualitasproduk->ViewCustomAttributes = "";

            // bahan_campaign
            $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
            $this->bahan_campaign->ViewCustomAttributes = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->ViewValue = $this->ukuran_sediaan->CurrentValue;
            $this->ukuran_sediaan->ViewCustomAttributes = "";

            // bentuk
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
                if ($this->bentuk->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->bentuk->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->bentuk->Lookup->renderViewRow($row);
                            $this->bentuk->ViewValue->add($this->bentuk->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->viskositas->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->viskositas->Lookup->renderViewRow($row);
                            $this->viskositas->ViewValue->add($this->viskositas->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->warna->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->warna->Lookup->renderViewRow($row);
                            $this->warna->ViewValue->add($this->warna->displayValue($arwrk));
                        }
                    } else {
                        $this->warna->ViewValue = $this->warna->CurrentValue;
                    }
                }
            } else {
                $this->warna->ViewValue = null;
            }
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
                if ($this->parfum->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->parfum->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->parfum->Lookup->renderViewRow($row);
                            $this->parfum->ViewValue->add($this->parfum->displayValue($arwrk));
                        }
                    } else {
                        $this->parfum->ViewValue = $this->parfum->CurrentValue;
                    }
                }
            } else {
                $this->parfum->ViewValue = null;
            }
            $this->parfum->ViewCustomAttributes = "";

            // aplikasi
            $curVal = trim(strval($this->aplikasi->CurrentValue));
            if ($curVal != "") {
                $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
                if ($this->aplikasi->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->aplikasi->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->aplikasi->Lookup->renderViewRow($row);
                            $this->aplikasi->ViewValue->add($this->aplikasi->displayValue($arwrk));
                        }
                    } else {
                        $this->aplikasi->ViewValue = $this->aplikasi->CurrentValue;
                    }
                }
            } else {
                $this->aplikasi->ViewValue = null;
            }
            $this->aplikasi->ViewCustomAttributes = "";

            // estetika
            $curVal = trim(strval($this->estetika->CurrentValue));
            if ($curVal != "") {
                $this->estetika->ViewValue = $this->estetika->lookupCacheOption($curVal);
                if ($this->estetika->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->estetika->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->estetika->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->estetika->Lookup->renderViewRow($row);
                            $this->estetika->ViewValue->add($this->estetika->displayValue($arwrk));
                        }
                    } else {
                        $this->estetika->ViewValue = $this->estetika->CurrentValue;
                    }
                }
            } else {
                $this->estetika->ViewValue = null;
            }
            $this->estetika->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // ukurankemasan
            $this->ukurankemasan->ViewValue = $this->ukurankemasan->CurrentValue;
            $this->ukurankemasan->ViewCustomAttributes = "";

            // kemasanbentuk
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
                if ($this->kemasanbentuk->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kemasanbentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kemasanbentuk->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kemasanbentuk->Lookup->renderViewRow($row);
                            $this->kemasanbentuk->ViewValue->add($this->kemasanbentuk->displayValue($arwrk));
                        }
                    } else {
                        $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->CurrentValue;
                    }
                }
            } else {
                $this->kemasanbentuk->ViewValue = null;
            }
            $this->kemasanbentuk->ViewCustomAttributes = "";

            // kemasantutup
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
                if ($this->kemasantutup->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kemasantutup->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kemasantutup->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kemasantutup->Lookup->renderViewRow($row);
                            $this->kemasantutup->ViewValue->add($this->kemasantutup->displayValue($arwrk));
                        }
                    } else {
                        $this->kemasantutup->ViewValue = $this->kemasantutup->CurrentValue;
                    }
                }
            } else {
                $this->kemasantutup->ViewValue = null;
            }
            $this->kemasantutup->ViewCustomAttributes = "";

            // labelbahan
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
                if ($this->labelbahan->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelbahan->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelbahan->Lookup->renderViewRow($row);
                            $this->labelbahan->ViewValue->add($this->labelbahan->displayValue($arwrk));
                        }
                    } else {
                        $this->labelbahan->ViewValue = $this->labelbahan->CurrentValue;
                    }
                }
            } else {
                $this->labelbahan->ViewValue = null;
            }
            $this->labelbahan->ViewCustomAttributes = "";

            // labelkualitas
            $curVal = trim(strval($this->labelkualitas->CurrentValue));
            if ($curVal != "") {
                $this->labelkualitas->ViewValue = $this->labelkualitas->lookupCacheOption($curVal);
                if ($this->labelkualitas->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelkualitas->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelkualitas->Lookup->renderViewRow($row);
                            $this->labelkualitas->ViewValue->add($this->labelkualitas->displayValue($arwrk));
                        }
                    } else {
                        $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
                    }
                }
            } else {
                $this->labelkualitas->ViewValue = null;
            }
            $this->labelkualitas->ViewCustomAttributes = "";

            // labelposisi
            $curVal = trim(strval($this->labelposisi->CurrentValue));
            if ($curVal != "") {
                $this->labelposisi->ViewValue = $this->labelposisi->lookupCacheOption($curVal);
                if ($this->labelposisi->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelposisi->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelposisi->Lookup->renderViewRow($row);
                            $this->labelposisi->ViewValue->add($this->labelposisi->displayValue($arwrk));
                        }
                    } else {
                        $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
                    }
                }
            } else {
                $this->labelposisi->ViewValue = null;
            }
            $this->labelposisi->ViewCustomAttributes = "";

            // statusdokumen
            $this->statusdokumen->ViewValue = $this->statusdokumen->CurrentValue;
            $this->statusdokumen->ViewCustomAttributes = "";

            // readonly
            if (strval($this->readonly->CurrentValue) != "") {
                $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
            } else {
                $this->readonly->ViewValue = null;
            }
            $this->readonly->ViewCustomAttributes = "";

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

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";
            $this->target_selesai->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";
            $this->nomororder->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fnpdlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_idpegawai":
                    break;
                case "x_idcustomer":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idjenisproduk":
                    break;
                case "x_idkategoriproduk":
                    break;
                case "x_bentuk":
                    break;
                case "x_viskositas":
                    break;
                case "x_warna":
                    break;
                case "x_parfum":
                    break;
                case "x_aplikasi":
                    break;
                case "x_estetika":
                    break;
                case "x_kemasanbentuk":
                    break;
                case "x_kemasantutup":
                    break;
                case "x_labelbahan":
                    break;
                case "x_labelkualitas":
                    break;
                case "x_labelposisi":
                    break;
                case "x_readonly":
                    break;
                case "x_selesai":
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
        echo "
        <style>
        	.ew-list-other-options .ew-detail-option {
        		display: none;
        	}
        </style>
        ";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
        echo "
        <script>

        function selesai(id) {
    		$.get('/bsd/api/npd/selesai/'+id, function(data) {
    			if (data == 1) {
    				location.reload();
    			} else {
    				alert('Gagal menandai selesai : '+data);
    			}
    		});
    	}

        function belumselesai(id) {
    		$.get('/bsd/api/npd/belumselesai/'+id, function(data) {
    			if (data == 1) {
    				location.reload();
    			} else {
    				alert('Gagal menandai belum selesai : '+data);
    			}
    		});
    	}
        </script>
        ";
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
        $this->ListOptions->Items["details"]->Visible = false;
        $item = &$this->ListOptions->add("aksi");
        $item->Header = "Action";
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
        if ($this->readonly->CurrentValue == 1) {
        	$this->ListOptions->Items["delete"]->Body = false;
        }
        if ($this->selesai->CurrentValue == 0) {
        	$this->ListOptions->Items["aksi"]->Body = "<a href=\"javascript:selesai(".$this->id->CurrentValue.")\">Tandai Selesai</a>";
        } else {
        	$this->ListOptions->Items["aksi"]->Body = "<a href=\"javascript:belumselesai(".$this->id->CurrentValue.")\">Tandai Belum Selesai</a>";
        }
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
