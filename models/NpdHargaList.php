<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdHargaList extends NpdHarga
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_harga';

    // Page object name
    public $PageObjName = "NpdHargaList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpd_hargalist";
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

        // Table object (npd_harga)
        if (!isset($GLOBALS["npd_harga"]) || get_class($GLOBALS["npd_harga"]) == PROJECT_NAMESPACE . "npd_harga") {
            $GLOBALS["npd_harga"] = &$this;
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
        $this->AddUrl = "NpdHargaAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "NpdHargaDelete";
        $this->MultiUpdateUrl = "NpdHargaUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_harga');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fnpd_hargalistsrch";

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
                $doc = new $class(Container("npd_harga"));
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
        $this->idnpd->setVisibility();
        $this->tglpengajuan->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->nama->setVisibility();
        $this->bentuk->Visible = false;
        $this->viskositas->Visible = false;
        $this->warna->setVisibility();
        $this->bauparfum->setVisibility();
        $this->aplikasisediaan->Visible = false;
        $this->volume->Visible = false;
        $this->bahanaktif->Visible = false;
        $this->volumewadah->Visible = false;
        $this->bahanwadah->Visible = false;
        $this->warnawadah->Visible = false;
        $this->bentukwadah->Visible = false;
        $this->jenistutup->Visible = false;
        $this->bahantutup->Visible = false;
        $this->warnatutup->Visible = false;
        $this->bentuktutup->Visible = false;
        $this->segel->Visible = false;
        $this->catatanprimer->Visible = false;
        $this->packingproduk->Visible = false;
        $this->keteranganpacking->Visible = false;
        $this->beltkarton->Visible = false;
        $this->keteranganbelt->Visible = false;
        $this->kartonluar->Visible = false;
        $this->bariskarton->Visible = false;
        $this->kolomkarton->Visible = false;
        $this->stackkarton->Visible = false;
        $this->isikarton->Visible = false;
        $this->jenislabel->Visible = false;
        $this->keteranganjenislabel->Visible = false;
        $this->kualitaslabel->Visible = false;
        $this->jumlahwarnalabel->Visible = false;
        $this->metaliklabel->Visible = false;
        $this->etiketlabel->Visible = false;
        $this->keteranganlabel->Visible = false;
        $this->kategoridelivery->Visible = false;
        $this->alamatpengiriman->Visible = false;
        $this->orderperdana->Visible = false;
        $this->orderkontrak->Visible = false;
        $this->hargaperpcs->Visible = false;
        $this->hargaperkarton->Visible = false;
        $this->lampiran->Visible = false;
        $this->prepared_by->Visible = false;
        $this->checked_by->Visible = false;
        $this->approved_by->Visible = false;
        $this->approved_date->Visible = false;
        $this->disetujui->Visible = false;
        $this->created_at->Visible = false;
        $this->readonly->Visible = false;
        $this->updated_at->Visible = false;
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

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
        $this->setupLookupOptions($this->idnpd);
        $this->setupLookupOptions($this->idnpd_sample);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->aplikasisediaan);
        $this->setupLookupOptions($this->jenislabel);
        $this->setupLookupOptions($this->kualitaslabel);
        $this->setupLookupOptions($this->kategoridelivery);

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

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "npd") {
            $masterTbl = Container("npd");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("NpdList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

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
        $filterList = Concat($filterList, $this->idnpd->AdvancedSearch->toJson(), ","); // Field idnpd
        $filterList = Concat($filterList, $this->tglpengajuan->AdvancedSearch->toJson(), ","); // Field tglpengajuan
        $filterList = Concat($filterList, $this->idnpd_sample->AdvancedSearch->toJson(), ","); // Field idnpd_sample
        $filterList = Concat($filterList, $this->nama->AdvancedSearch->toJson(), ","); // Field nama
        $filterList = Concat($filterList, $this->bentuk->AdvancedSearch->toJson(), ","); // Field bentuk
        $filterList = Concat($filterList, $this->viskositas->AdvancedSearch->toJson(), ","); // Field viskositas
        $filterList = Concat($filterList, $this->warna->AdvancedSearch->toJson(), ","); // Field warna
        $filterList = Concat($filterList, $this->bauparfum->AdvancedSearch->toJson(), ","); // Field bauparfum
        $filterList = Concat($filterList, $this->aplikasisediaan->AdvancedSearch->toJson(), ","); // Field aplikasisediaan
        $filterList = Concat($filterList, $this->volume->AdvancedSearch->toJson(), ","); // Field volume
        $filterList = Concat($filterList, $this->bahanaktif->AdvancedSearch->toJson(), ","); // Field bahanaktif
        $filterList = Concat($filterList, $this->volumewadah->AdvancedSearch->toJson(), ","); // Field volumewadah
        $filterList = Concat($filterList, $this->bahanwadah->AdvancedSearch->toJson(), ","); // Field bahanwadah
        $filterList = Concat($filterList, $this->warnawadah->AdvancedSearch->toJson(), ","); // Field warnawadah
        $filterList = Concat($filterList, $this->bentukwadah->AdvancedSearch->toJson(), ","); // Field bentukwadah
        $filterList = Concat($filterList, $this->jenistutup->AdvancedSearch->toJson(), ","); // Field jenistutup
        $filterList = Concat($filterList, $this->bahantutup->AdvancedSearch->toJson(), ","); // Field bahantutup
        $filterList = Concat($filterList, $this->warnatutup->AdvancedSearch->toJson(), ","); // Field warnatutup
        $filterList = Concat($filterList, $this->bentuktutup->AdvancedSearch->toJson(), ","); // Field bentuktutup
        $filterList = Concat($filterList, $this->segel->AdvancedSearch->toJson(), ","); // Field segel
        $filterList = Concat($filterList, $this->catatanprimer->AdvancedSearch->toJson(), ","); // Field catatanprimer
        $filterList = Concat($filterList, $this->packingproduk->AdvancedSearch->toJson(), ","); // Field packingproduk
        $filterList = Concat($filterList, $this->keteranganpacking->AdvancedSearch->toJson(), ","); // Field keteranganpacking
        $filterList = Concat($filterList, $this->beltkarton->AdvancedSearch->toJson(), ","); // Field beltkarton
        $filterList = Concat($filterList, $this->keteranganbelt->AdvancedSearch->toJson(), ","); // Field keteranganbelt
        $filterList = Concat($filterList, $this->kartonluar->AdvancedSearch->toJson(), ","); // Field kartonluar
        $filterList = Concat($filterList, $this->bariskarton->AdvancedSearch->toJson(), ","); // Field bariskarton
        $filterList = Concat($filterList, $this->kolomkarton->AdvancedSearch->toJson(), ","); // Field kolomkarton
        $filterList = Concat($filterList, $this->stackkarton->AdvancedSearch->toJson(), ","); // Field stackkarton
        $filterList = Concat($filterList, $this->isikarton->AdvancedSearch->toJson(), ","); // Field isikarton
        $filterList = Concat($filterList, $this->jenislabel->AdvancedSearch->toJson(), ","); // Field jenislabel
        $filterList = Concat($filterList, $this->keteranganjenislabel->AdvancedSearch->toJson(), ","); // Field keteranganjenislabel
        $filterList = Concat($filterList, $this->kualitaslabel->AdvancedSearch->toJson(), ","); // Field kualitaslabel
        $filterList = Concat($filterList, $this->jumlahwarnalabel->AdvancedSearch->toJson(), ","); // Field jumlahwarnalabel
        $filterList = Concat($filterList, $this->metaliklabel->AdvancedSearch->toJson(), ","); // Field metaliklabel
        $filterList = Concat($filterList, $this->etiketlabel->AdvancedSearch->toJson(), ","); // Field etiketlabel
        $filterList = Concat($filterList, $this->keteranganlabel->AdvancedSearch->toJson(), ","); // Field keteranganlabel
        $filterList = Concat($filterList, $this->kategoridelivery->AdvancedSearch->toJson(), ","); // Field kategoridelivery
        $filterList = Concat($filterList, $this->alamatpengiriman->AdvancedSearch->toJson(), ","); // Field alamatpengiriman
        $filterList = Concat($filterList, $this->orderperdana->AdvancedSearch->toJson(), ","); // Field orderperdana
        $filterList = Concat($filterList, $this->orderkontrak->AdvancedSearch->toJson(), ","); // Field orderkontrak
        $filterList = Concat($filterList, $this->hargaperpcs->AdvancedSearch->toJson(), ","); // Field hargaperpcs
        $filterList = Concat($filterList, $this->hargaperkarton->AdvancedSearch->toJson(), ","); // Field hargaperkarton
        $filterList = Concat($filterList, $this->lampiran->AdvancedSearch->toJson(), ","); // Field lampiran
        $filterList = Concat($filterList, $this->prepared_by->AdvancedSearch->toJson(), ","); // Field prepared_by
        $filterList = Concat($filterList, $this->checked_by->AdvancedSearch->toJson(), ","); // Field checked_by
        $filterList = Concat($filterList, $this->approved_by->AdvancedSearch->toJson(), ","); // Field approved_by
        $filterList = Concat($filterList, $this->approved_date->AdvancedSearch->toJson(), ","); // Field approved_date
        $filterList = Concat($filterList, $this->disetujui->AdvancedSearch->toJson(), ","); // Field disetujui
        $filterList = Concat($filterList, $this->created_at->AdvancedSearch->toJson(), ","); // Field created_at
        $filterList = Concat($filterList, $this->readonly->AdvancedSearch->toJson(), ","); // Field readonly
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fnpd_hargalistsrch", $filters);
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

        // Field idnpd
        $this->idnpd->AdvancedSearch->SearchValue = @$filter["x_idnpd"];
        $this->idnpd->AdvancedSearch->SearchOperator = @$filter["z_idnpd"];
        $this->idnpd->AdvancedSearch->SearchCondition = @$filter["v_idnpd"];
        $this->idnpd->AdvancedSearch->SearchValue2 = @$filter["y_idnpd"];
        $this->idnpd->AdvancedSearch->SearchOperator2 = @$filter["w_idnpd"];
        $this->idnpd->AdvancedSearch->save();

        // Field tglpengajuan
        $this->tglpengajuan->AdvancedSearch->SearchValue = @$filter["x_tglpengajuan"];
        $this->tglpengajuan->AdvancedSearch->SearchOperator = @$filter["z_tglpengajuan"];
        $this->tglpengajuan->AdvancedSearch->SearchCondition = @$filter["v_tglpengajuan"];
        $this->tglpengajuan->AdvancedSearch->SearchValue2 = @$filter["y_tglpengajuan"];
        $this->tglpengajuan->AdvancedSearch->SearchOperator2 = @$filter["w_tglpengajuan"];
        $this->tglpengajuan->AdvancedSearch->save();

        // Field idnpd_sample
        $this->idnpd_sample->AdvancedSearch->SearchValue = @$filter["x_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchOperator = @$filter["z_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchCondition = @$filter["v_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchValue2 = @$filter["y_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchOperator2 = @$filter["w_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->save();

        // Field nama
        $this->nama->AdvancedSearch->SearchValue = @$filter["x_nama"];
        $this->nama->AdvancedSearch->SearchOperator = @$filter["z_nama"];
        $this->nama->AdvancedSearch->SearchCondition = @$filter["v_nama"];
        $this->nama->AdvancedSearch->SearchValue2 = @$filter["y_nama"];
        $this->nama->AdvancedSearch->SearchOperator2 = @$filter["w_nama"];
        $this->nama->AdvancedSearch->save();

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

        // Field bauparfum
        $this->bauparfum->AdvancedSearch->SearchValue = @$filter["x_bauparfum"];
        $this->bauparfum->AdvancedSearch->SearchOperator = @$filter["z_bauparfum"];
        $this->bauparfum->AdvancedSearch->SearchCondition = @$filter["v_bauparfum"];
        $this->bauparfum->AdvancedSearch->SearchValue2 = @$filter["y_bauparfum"];
        $this->bauparfum->AdvancedSearch->SearchOperator2 = @$filter["w_bauparfum"];
        $this->bauparfum->AdvancedSearch->save();

        // Field aplikasisediaan
        $this->aplikasisediaan->AdvancedSearch->SearchValue = @$filter["x_aplikasisediaan"];
        $this->aplikasisediaan->AdvancedSearch->SearchOperator = @$filter["z_aplikasisediaan"];
        $this->aplikasisediaan->AdvancedSearch->SearchCondition = @$filter["v_aplikasisediaan"];
        $this->aplikasisediaan->AdvancedSearch->SearchValue2 = @$filter["y_aplikasisediaan"];
        $this->aplikasisediaan->AdvancedSearch->SearchOperator2 = @$filter["w_aplikasisediaan"];
        $this->aplikasisediaan->AdvancedSearch->save();

        // Field volume
        $this->volume->AdvancedSearch->SearchValue = @$filter["x_volume"];
        $this->volume->AdvancedSearch->SearchOperator = @$filter["z_volume"];
        $this->volume->AdvancedSearch->SearchCondition = @$filter["v_volume"];
        $this->volume->AdvancedSearch->SearchValue2 = @$filter["y_volume"];
        $this->volume->AdvancedSearch->SearchOperator2 = @$filter["w_volume"];
        $this->volume->AdvancedSearch->save();

        // Field bahanaktif
        $this->bahanaktif->AdvancedSearch->SearchValue = @$filter["x_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchOperator = @$filter["z_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchCondition = @$filter["v_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchValue2 = @$filter["y_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchOperator2 = @$filter["w_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->save();

        // Field volumewadah
        $this->volumewadah->AdvancedSearch->SearchValue = @$filter["x_volumewadah"];
        $this->volumewadah->AdvancedSearch->SearchOperator = @$filter["z_volumewadah"];
        $this->volumewadah->AdvancedSearch->SearchCondition = @$filter["v_volumewadah"];
        $this->volumewadah->AdvancedSearch->SearchValue2 = @$filter["y_volumewadah"];
        $this->volumewadah->AdvancedSearch->SearchOperator2 = @$filter["w_volumewadah"];
        $this->volumewadah->AdvancedSearch->save();

        // Field bahanwadah
        $this->bahanwadah->AdvancedSearch->SearchValue = @$filter["x_bahanwadah"];
        $this->bahanwadah->AdvancedSearch->SearchOperator = @$filter["z_bahanwadah"];
        $this->bahanwadah->AdvancedSearch->SearchCondition = @$filter["v_bahanwadah"];
        $this->bahanwadah->AdvancedSearch->SearchValue2 = @$filter["y_bahanwadah"];
        $this->bahanwadah->AdvancedSearch->SearchOperator2 = @$filter["w_bahanwadah"];
        $this->bahanwadah->AdvancedSearch->save();

        // Field warnawadah
        $this->warnawadah->AdvancedSearch->SearchValue = @$filter["x_warnawadah"];
        $this->warnawadah->AdvancedSearch->SearchOperator = @$filter["z_warnawadah"];
        $this->warnawadah->AdvancedSearch->SearchCondition = @$filter["v_warnawadah"];
        $this->warnawadah->AdvancedSearch->SearchValue2 = @$filter["y_warnawadah"];
        $this->warnawadah->AdvancedSearch->SearchOperator2 = @$filter["w_warnawadah"];
        $this->warnawadah->AdvancedSearch->save();

        // Field bentukwadah
        $this->bentukwadah->AdvancedSearch->SearchValue = @$filter["x_bentukwadah"];
        $this->bentukwadah->AdvancedSearch->SearchOperator = @$filter["z_bentukwadah"];
        $this->bentukwadah->AdvancedSearch->SearchCondition = @$filter["v_bentukwadah"];
        $this->bentukwadah->AdvancedSearch->SearchValue2 = @$filter["y_bentukwadah"];
        $this->bentukwadah->AdvancedSearch->SearchOperator2 = @$filter["w_bentukwadah"];
        $this->bentukwadah->AdvancedSearch->save();

        // Field jenistutup
        $this->jenistutup->AdvancedSearch->SearchValue = @$filter["x_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchOperator = @$filter["z_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchCondition = @$filter["v_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchValue2 = @$filter["y_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchOperator2 = @$filter["w_jenistutup"];
        $this->jenistutup->AdvancedSearch->save();

        // Field bahantutup
        $this->bahantutup->AdvancedSearch->SearchValue = @$filter["x_bahantutup"];
        $this->bahantutup->AdvancedSearch->SearchOperator = @$filter["z_bahantutup"];
        $this->bahantutup->AdvancedSearch->SearchCondition = @$filter["v_bahantutup"];
        $this->bahantutup->AdvancedSearch->SearchValue2 = @$filter["y_bahantutup"];
        $this->bahantutup->AdvancedSearch->SearchOperator2 = @$filter["w_bahantutup"];
        $this->bahantutup->AdvancedSearch->save();

        // Field warnatutup
        $this->warnatutup->AdvancedSearch->SearchValue = @$filter["x_warnatutup"];
        $this->warnatutup->AdvancedSearch->SearchOperator = @$filter["z_warnatutup"];
        $this->warnatutup->AdvancedSearch->SearchCondition = @$filter["v_warnatutup"];
        $this->warnatutup->AdvancedSearch->SearchValue2 = @$filter["y_warnatutup"];
        $this->warnatutup->AdvancedSearch->SearchOperator2 = @$filter["w_warnatutup"];
        $this->warnatutup->AdvancedSearch->save();

        // Field bentuktutup
        $this->bentuktutup->AdvancedSearch->SearchValue = @$filter["x_bentuktutup"];
        $this->bentuktutup->AdvancedSearch->SearchOperator = @$filter["z_bentuktutup"];
        $this->bentuktutup->AdvancedSearch->SearchCondition = @$filter["v_bentuktutup"];
        $this->bentuktutup->AdvancedSearch->SearchValue2 = @$filter["y_bentuktutup"];
        $this->bentuktutup->AdvancedSearch->SearchOperator2 = @$filter["w_bentuktutup"];
        $this->bentuktutup->AdvancedSearch->save();

        // Field segel
        $this->segel->AdvancedSearch->SearchValue = @$filter["x_segel"];
        $this->segel->AdvancedSearch->SearchOperator = @$filter["z_segel"];
        $this->segel->AdvancedSearch->SearchCondition = @$filter["v_segel"];
        $this->segel->AdvancedSearch->SearchValue2 = @$filter["y_segel"];
        $this->segel->AdvancedSearch->SearchOperator2 = @$filter["w_segel"];
        $this->segel->AdvancedSearch->save();

        // Field catatanprimer
        $this->catatanprimer->AdvancedSearch->SearchValue = @$filter["x_catatanprimer"];
        $this->catatanprimer->AdvancedSearch->SearchOperator = @$filter["z_catatanprimer"];
        $this->catatanprimer->AdvancedSearch->SearchCondition = @$filter["v_catatanprimer"];
        $this->catatanprimer->AdvancedSearch->SearchValue2 = @$filter["y_catatanprimer"];
        $this->catatanprimer->AdvancedSearch->SearchOperator2 = @$filter["w_catatanprimer"];
        $this->catatanprimer->AdvancedSearch->save();

        // Field packingproduk
        $this->packingproduk->AdvancedSearch->SearchValue = @$filter["x_packingproduk"];
        $this->packingproduk->AdvancedSearch->SearchOperator = @$filter["z_packingproduk"];
        $this->packingproduk->AdvancedSearch->SearchCondition = @$filter["v_packingproduk"];
        $this->packingproduk->AdvancedSearch->SearchValue2 = @$filter["y_packingproduk"];
        $this->packingproduk->AdvancedSearch->SearchOperator2 = @$filter["w_packingproduk"];
        $this->packingproduk->AdvancedSearch->save();

        // Field keteranganpacking
        $this->keteranganpacking->AdvancedSearch->SearchValue = @$filter["x_keteranganpacking"];
        $this->keteranganpacking->AdvancedSearch->SearchOperator = @$filter["z_keteranganpacking"];
        $this->keteranganpacking->AdvancedSearch->SearchCondition = @$filter["v_keteranganpacking"];
        $this->keteranganpacking->AdvancedSearch->SearchValue2 = @$filter["y_keteranganpacking"];
        $this->keteranganpacking->AdvancedSearch->SearchOperator2 = @$filter["w_keteranganpacking"];
        $this->keteranganpacking->AdvancedSearch->save();

        // Field beltkarton
        $this->beltkarton->AdvancedSearch->SearchValue = @$filter["x_beltkarton"];
        $this->beltkarton->AdvancedSearch->SearchOperator = @$filter["z_beltkarton"];
        $this->beltkarton->AdvancedSearch->SearchCondition = @$filter["v_beltkarton"];
        $this->beltkarton->AdvancedSearch->SearchValue2 = @$filter["y_beltkarton"];
        $this->beltkarton->AdvancedSearch->SearchOperator2 = @$filter["w_beltkarton"];
        $this->beltkarton->AdvancedSearch->save();

        // Field keteranganbelt
        $this->keteranganbelt->AdvancedSearch->SearchValue = @$filter["x_keteranganbelt"];
        $this->keteranganbelt->AdvancedSearch->SearchOperator = @$filter["z_keteranganbelt"];
        $this->keteranganbelt->AdvancedSearch->SearchCondition = @$filter["v_keteranganbelt"];
        $this->keteranganbelt->AdvancedSearch->SearchValue2 = @$filter["y_keteranganbelt"];
        $this->keteranganbelt->AdvancedSearch->SearchOperator2 = @$filter["w_keteranganbelt"];
        $this->keteranganbelt->AdvancedSearch->save();

        // Field kartonluar
        $this->kartonluar->AdvancedSearch->SearchValue = @$filter["x_kartonluar"];
        $this->kartonluar->AdvancedSearch->SearchOperator = @$filter["z_kartonluar"];
        $this->kartonluar->AdvancedSearch->SearchCondition = @$filter["v_kartonluar"];
        $this->kartonluar->AdvancedSearch->SearchValue2 = @$filter["y_kartonluar"];
        $this->kartonluar->AdvancedSearch->SearchOperator2 = @$filter["w_kartonluar"];
        $this->kartonluar->AdvancedSearch->save();

        // Field bariskarton
        $this->bariskarton->AdvancedSearch->SearchValue = @$filter["x_bariskarton"];
        $this->bariskarton->AdvancedSearch->SearchOperator = @$filter["z_bariskarton"];
        $this->bariskarton->AdvancedSearch->SearchCondition = @$filter["v_bariskarton"];
        $this->bariskarton->AdvancedSearch->SearchValue2 = @$filter["y_bariskarton"];
        $this->bariskarton->AdvancedSearch->SearchOperator2 = @$filter["w_bariskarton"];
        $this->bariskarton->AdvancedSearch->save();

        // Field kolomkarton
        $this->kolomkarton->AdvancedSearch->SearchValue = @$filter["x_kolomkarton"];
        $this->kolomkarton->AdvancedSearch->SearchOperator = @$filter["z_kolomkarton"];
        $this->kolomkarton->AdvancedSearch->SearchCondition = @$filter["v_kolomkarton"];
        $this->kolomkarton->AdvancedSearch->SearchValue2 = @$filter["y_kolomkarton"];
        $this->kolomkarton->AdvancedSearch->SearchOperator2 = @$filter["w_kolomkarton"];
        $this->kolomkarton->AdvancedSearch->save();

        // Field stackkarton
        $this->stackkarton->AdvancedSearch->SearchValue = @$filter["x_stackkarton"];
        $this->stackkarton->AdvancedSearch->SearchOperator = @$filter["z_stackkarton"];
        $this->stackkarton->AdvancedSearch->SearchCondition = @$filter["v_stackkarton"];
        $this->stackkarton->AdvancedSearch->SearchValue2 = @$filter["y_stackkarton"];
        $this->stackkarton->AdvancedSearch->SearchOperator2 = @$filter["w_stackkarton"];
        $this->stackkarton->AdvancedSearch->save();

        // Field isikarton
        $this->isikarton->AdvancedSearch->SearchValue = @$filter["x_isikarton"];
        $this->isikarton->AdvancedSearch->SearchOperator = @$filter["z_isikarton"];
        $this->isikarton->AdvancedSearch->SearchCondition = @$filter["v_isikarton"];
        $this->isikarton->AdvancedSearch->SearchValue2 = @$filter["y_isikarton"];
        $this->isikarton->AdvancedSearch->SearchOperator2 = @$filter["w_isikarton"];
        $this->isikarton->AdvancedSearch->save();

        // Field jenislabel
        $this->jenislabel->AdvancedSearch->SearchValue = @$filter["x_jenislabel"];
        $this->jenislabel->AdvancedSearch->SearchOperator = @$filter["z_jenislabel"];
        $this->jenislabel->AdvancedSearch->SearchCondition = @$filter["v_jenislabel"];
        $this->jenislabel->AdvancedSearch->SearchValue2 = @$filter["y_jenislabel"];
        $this->jenislabel->AdvancedSearch->SearchOperator2 = @$filter["w_jenislabel"];
        $this->jenislabel->AdvancedSearch->save();

        // Field keteranganjenislabel
        $this->keteranganjenislabel->AdvancedSearch->SearchValue = @$filter["x_keteranganjenislabel"];
        $this->keteranganjenislabel->AdvancedSearch->SearchOperator = @$filter["z_keteranganjenislabel"];
        $this->keteranganjenislabel->AdvancedSearch->SearchCondition = @$filter["v_keteranganjenislabel"];
        $this->keteranganjenislabel->AdvancedSearch->SearchValue2 = @$filter["y_keteranganjenislabel"];
        $this->keteranganjenislabel->AdvancedSearch->SearchOperator2 = @$filter["w_keteranganjenislabel"];
        $this->keteranganjenislabel->AdvancedSearch->save();

        // Field kualitaslabel
        $this->kualitaslabel->AdvancedSearch->SearchValue = @$filter["x_kualitaslabel"];
        $this->kualitaslabel->AdvancedSearch->SearchOperator = @$filter["z_kualitaslabel"];
        $this->kualitaslabel->AdvancedSearch->SearchCondition = @$filter["v_kualitaslabel"];
        $this->kualitaslabel->AdvancedSearch->SearchValue2 = @$filter["y_kualitaslabel"];
        $this->kualitaslabel->AdvancedSearch->SearchOperator2 = @$filter["w_kualitaslabel"];
        $this->kualitaslabel->AdvancedSearch->save();

        // Field jumlahwarnalabel
        $this->jumlahwarnalabel->AdvancedSearch->SearchValue = @$filter["x_jumlahwarnalabel"];
        $this->jumlahwarnalabel->AdvancedSearch->SearchOperator = @$filter["z_jumlahwarnalabel"];
        $this->jumlahwarnalabel->AdvancedSearch->SearchCondition = @$filter["v_jumlahwarnalabel"];
        $this->jumlahwarnalabel->AdvancedSearch->SearchValue2 = @$filter["y_jumlahwarnalabel"];
        $this->jumlahwarnalabel->AdvancedSearch->SearchOperator2 = @$filter["w_jumlahwarnalabel"];
        $this->jumlahwarnalabel->AdvancedSearch->save();

        // Field metaliklabel
        $this->metaliklabel->AdvancedSearch->SearchValue = @$filter["x_metaliklabel"];
        $this->metaliklabel->AdvancedSearch->SearchOperator = @$filter["z_metaliklabel"];
        $this->metaliklabel->AdvancedSearch->SearchCondition = @$filter["v_metaliklabel"];
        $this->metaliklabel->AdvancedSearch->SearchValue2 = @$filter["y_metaliklabel"];
        $this->metaliklabel->AdvancedSearch->SearchOperator2 = @$filter["w_metaliklabel"];
        $this->metaliklabel->AdvancedSearch->save();

        // Field etiketlabel
        $this->etiketlabel->AdvancedSearch->SearchValue = @$filter["x_etiketlabel"];
        $this->etiketlabel->AdvancedSearch->SearchOperator = @$filter["z_etiketlabel"];
        $this->etiketlabel->AdvancedSearch->SearchCondition = @$filter["v_etiketlabel"];
        $this->etiketlabel->AdvancedSearch->SearchValue2 = @$filter["y_etiketlabel"];
        $this->etiketlabel->AdvancedSearch->SearchOperator2 = @$filter["w_etiketlabel"];
        $this->etiketlabel->AdvancedSearch->save();

        // Field keteranganlabel
        $this->keteranganlabel->AdvancedSearch->SearchValue = @$filter["x_keteranganlabel"];
        $this->keteranganlabel->AdvancedSearch->SearchOperator = @$filter["z_keteranganlabel"];
        $this->keteranganlabel->AdvancedSearch->SearchCondition = @$filter["v_keteranganlabel"];
        $this->keteranganlabel->AdvancedSearch->SearchValue2 = @$filter["y_keteranganlabel"];
        $this->keteranganlabel->AdvancedSearch->SearchOperator2 = @$filter["w_keteranganlabel"];
        $this->keteranganlabel->AdvancedSearch->save();

        // Field kategoridelivery
        $this->kategoridelivery->AdvancedSearch->SearchValue = @$filter["x_kategoridelivery"];
        $this->kategoridelivery->AdvancedSearch->SearchOperator = @$filter["z_kategoridelivery"];
        $this->kategoridelivery->AdvancedSearch->SearchCondition = @$filter["v_kategoridelivery"];
        $this->kategoridelivery->AdvancedSearch->SearchValue2 = @$filter["y_kategoridelivery"];
        $this->kategoridelivery->AdvancedSearch->SearchOperator2 = @$filter["w_kategoridelivery"];
        $this->kategoridelivery->AdvancedSearch->save();

        // Field alamatpengiriman
        $this->alamatpengiriman->AdvancedSearch->SearchValue = @$filter["x_alamatpengiriman"];
        $this->alamatpengiriman->AdvancedSearch->SearchOperator = @$filter["z_alamatpengiriman"];
        $this->alamatpengiriman->AdvancedSearch->SearchCondition = @$filter["v_alamatpengiriman"];
        $this->alamatpengiriman->AdvancedSearch->SearchValue2 = @$filter["y_alamatpengiriman"];
        $this->alamatpengiriman->AdvancedSearch->SearchOperator2 = @$filter["w_alamatpengiriman"];
        $this->alamatpengiriman->AdvancedSearch->save();

        // Field orderperdana
        $this->orderperdana->AdvancedSearch->SearchValue = @$filter["x_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchOperator = @$filter["z_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchCondition = @$filter["v_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchValue2 = @$filter["y_orderperdana"];
        $this->orderperdana->AdvancedSearch->SearchOperator2 = @$filter["w_orderperdana"];
        $this->orderperdana->AdvancedSearch->save();

        // Field orderkontrak
        $this->orderkontrak->AdvancedSearch->SearchValue = @$filter["x_orderkontrak"];
        $this->orderkontrak->AdvancedSearch->SearchOperator = @$filter["z_orderkontrak"];
        $this->orderkontrak->AdvancedSearch->SearchCondition = @$filter["v_orderkontrak"];
        $this->orderkontrak->AdvancedSearch->SearchValue2 = @$filter["y_orderkontrak"];
        $this->orderkontrak->AdvancedSearch->SearchOperator2 = @$filter["w_orderkontrak"];
        $this->orderkontrak->AdvancedSearch->save();

        // Field hargaperpcs
        $this->hargaperpcs->AdvancedSearch->SearchValue = @$filter["x_hargaperpcs"];
        $this->hargaperpcs->AdvancedSearch->SearchOperator = @$filter["z_hargaperpcs"];
        $this->hargaperpcs->AdvancedSearch->SearchCondition = @$filter["v_hargaperpcs"];
        $this->hargaperpcs->AdvancedSearch->SearchValue2 = @$filter["y_hargaperpcs"];
        $this->hargaperpcs->AdvancedSearch->SearchOperator2 = @$filter["w_hargaperpcs"];
        $this->hargaperpcs->AdvancedSearch->save();

        // Field hargaperkarton
        $this->hargaperkarton->AdvancedSearch->SearchValue = @$filter["x_hargaperkarton"];
        $this->hargaperkarton->AdvancedSearch->SearchOperator = @$filter["z_hargaperkarton"];
        $this->hargaperkarton->AdvancedSearch->SearchCondition = @$filter["v_hargaperkarton"];
        $this->hargaperkarton->AdvancedSearch->SearchValue2 = @$filter["y_hargaperkarton"];
        $this->hargaperkarton->AdvancedSearch->SearchOperator2 = @$filter["w_hargaperkarton"];
        $this->hargaperkarton->AdvancedSearch->save();

        // Field lampiran
        $this->lampiran->AdvancedSearch->SearchValue = @$filter["x_lampiran"];
        $this->lampiran->AdvancedSearch->SearchOperator = @$filter["z_lampiran"];
        $this->lampiran->AdvancedSearch->SearchCondition = @$filter["v_lampiran"];
        $this->lampiran->AdvancedSearch->SearchValue2 = @$filter["y_lampiran"];
        $this->lampiran->AdvancedSearch->SearchOperator2 = @$filter["w_lampiran"];
        $this->lampiran->AdvancedSearch->save();

        // Field prepared_by
        $this->prepared_by->AdvancedSearch->SearchValue = @$filter["x_prepared_by"];
        $this->prepared_by->AdvancedSearch->SearchOperator = @$filter["z_prepared_by"];
        $this->prepared_by->AdvancedSearch->SearchCondition = @$filter["v_prepared_by"];
        $this->prepared_by->AdvancedSearch->SearchValue2 = @$filter["y_prepared_by"];
        $this->prepared_by->AdvancedSearch->SearchOperator2 = @$filter["w_prepared_by"];
        $this->prepared_by->AdvancedSearch->save();

        // Field checked_by
        $this->checked_by->AdvancedSearch->SearchValue = @$filter["x_checked_by"];
        $this->checked_by->AdvancedSearch->SearchOperator = @$filter["z_checked_by"];
        $this->checked_by->AdvancedSearch->SearchCondition = @$filter["v_checked_by"];
        $this->checked_by->AdvancedSearch->SearchValue2 = @$filter["y_checked_by"];
        $this->checked_by->AdvancedSearch->SearchOperator2 = @$filter["w_checked_by"];
        $this->checked_by->AdvancedSearch->save();

        // Field approved_by
        $this->approved_by->AdvancedSearch->SearchValue = @$filter["x_approved_by"];
        $this->approved_by->AdvancedSearch->SearchOperator = @$filter["z_approved_by"];
        $this->approved_by->AdvancedSearch->SearchCondition = @$filter["v_approved_by"];
        $this->approved_by->AdvancedSearch->SearchValue2 = @$filter["y_approved_by"];
        $this->approved_by->AdvancedSearch->SearchOperator2 = @$filter["w_approved_by"];
        $this->approved_by->AdvancedSearch->save();

        // Field approved_date
        $this->approved_date->AdvancedSearch->SearchValue = @$filter["x_approved_date"];
        $this->approved_date->AdvancedSearch->SearchOperator = @$filter["z_approved_date"];
        $this->approved_date->AdvancedSearch->SearchCondition = @$filter["v_approved_date"];
        $this->approved_date->AdvancedSearch->SearchValue2 = @$filter["y_approved_date"];
        $this->approved_date->AdvancedSearch->SearchOperator2 = @$filter["w_approved_date"];
        $this->approved_date->AdvancedSearch->save();

        // Field disetujui
        $this->disetujui->AdvancedSearch->SearchValue = @$filter["x_disetujui"];
        $this->disetujui->AdvancedSearch->SearchOperator = @$filter["z_disetujui"];
        $this->disetujui->AdvancedSearch->SearchCondition = @$filter["v_disetujui"];
        $this->disetujui->AdvancedSearch->SearchValue2 = @$filter["y_disetujui"];
        $this->disetujui->AdvancedSearch->SearchOperator2 = @$filter["w_disetujui"];
        $this->disetujui->AdvancedSearch->save();

        // Field created_at
        $this->created_at->AdvancedSearch->SearchValue = @$filter["x_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator = @$filter["z_created_at"];
        $this->created_at->AdvancedSearch->SearchCondition = @$filter["v_created_at"];
        $this->created_at->AdvancedSearch->SearchValue2 = @$filter["y_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator2 = @$filter["w_created_at"];
        $this->created_at->AdvancedSearch->save();

        // Field readonly
        $this->readonly->AdvancedSearch->SearchValue = @$filter["x_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator = @$filter["z_readonly"];
        $this->readonly->AdvancedSearch->SearchCondition = @$filter["v_readonly"];
        $this->readonly->AdvancedSearch->SearchValue2 = @$filter["y_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator2 = @$filter["w_readonly"];
        $this->readonly->AdvancedSearch->save();

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
        $this->buildBasicSearchSql($where, $this->nama, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bentuk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->viskositas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->warna, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bauparfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->volume, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bahanaktif, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->volumewadah, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bahanwadah, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->warnawadah, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bentukwadah, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jenistutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bahantutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->warnatutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bentuktutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->catatanprimer, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->packingproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->keteranganpacking, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->beltkarton, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->keteranganbelt, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kartonluar, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jenislabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->keteranganjenislabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kualitaslabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jumlahwarnalabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->metaliklabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->etiketlabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->keteranganlabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kategoridelivery, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->alamatpengiriman, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->lampiran, $arKeywords, $type);
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
            $this->updateSort($this->idnpd); // idnpd
            $this->updateSort($this->tglpengajuan); // tglpengajuan
            $this->updateSort($this->idnpd_sample); // idnpd_sample
            $this->updateSort($this->nama); // nama
            $this->updateSort($this->warna); // warna
            $this->updateSort($this->bauparfum); // bauparfum
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

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->idnpd->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id->setSort("");
                $this->idnpd->setSort("");
                $this->tglpengajuan->setSort("");
                $this->idnpd_sample->setSort("");
                $this->nama->setSort("");
                $this->bentuk->setSort("");
                $this->viskositas->setSort("");
                $this->warna->setSort("");
                $this->bauparfum->setSort("");
                $this->aplikasisediaan->setSort("");
                $this->volume->setSort("");
                $this->bahanaktif->setSort("");
                $this->volumewadah->setSort("");
                $this->bahanwadah->setSort("");
                $this->warnawadah->setSort("");
                $this->bentukwadah->setSort("");
                $this->jenistutup->setSort("");
                $this->bahantutup->setSort("");
                $this->warnatutup->setSort("");
                $this->bentuktutup->setSort("");
                $this->segel->setSort("");
                $this->catatanprimer->setSort("");
                $this->packingproduk->setSort("");
                $this->keteranganpacking->setSort("");
                $this->beltkarton->setSort("");
                $this->keteranganbelt->setSort("");
                $this->kartonluar->setSort("");
                $this->bariskarton->setSort("");
                $this->kolomkarton->setSort("");
                $this->stackkarton->setSort("");
                $this->isikarton->setSort("");
                $this->jenislabel->setSort("");
                $this->keteranganjenislabel->setSort("");
                $this->kualitaslabel->setSort("");
                $this->jumlahwarnalabel->setSort("");
                $this->metaliklabel->setSort("");
                $this->etiketlabel->setSort("");
                $this->keteranganlabel->setSort("");
                $this->kategoridelivery->setSort("");
                $this->alamatpengiriman->setSort("");
                $this->orderperdana->setSort("");
                $this->orderkontrak->setSort("");
                $this->hargaperpcs->setSort("");
                $this->hargaperkarton->setSort("");
                $this->lampiran->setSort("");
                $this->prepared_by->setSort("");
                $this->checked_by->setSort("");
                $this->approved_by->setSort("");
                $this->approved_date->setSort("");
                $this->disetujui->setSort("");
                $this->created_at->setSort("");
                $this->readonly->setSort("");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fnpd_hargalistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fnpd_hargalistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fnpd_hargalist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->tglpengajuan->setDbValue($row['tglpengajuan']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->nama->setDbValue($row['nama']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->bauparfum->setDbValue($row['bauparfum']);
        $this->aplikasisediaan->setDbValue($row['aplikasisediaan']);
        $this->volume->setDbValue($row['volume']);
        $this->bahanaktif->setDbValue($row['bahanaktif']);
        $this->volumewadah->setDbValue($row['volumewadah']);
        $this->bahanwadah->setDbValue($row['bahanwadah']);
        $this->warnawadah->setDbValue($row['warnawadah']);
        $this->bentukwadah->setDbValue($row['bentukwadah']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->bahantutup->setDbValue($row['bahantutup']);
        $this->warnatutup->setDbValue($row['warnatutup']);
        $this->bentuktutup->setDbValue($row['bentuktutup']);
        $this->segel->setDbValue($row['segel']);
        $this->catatanprimer->setDbValue($row['catatanprimer']);
        $this->packingproduk->setDbValue($row['packingproduk']);
        $this->keteranganpacking->setDbValue($row['keteranganpacking']);
        $this->beltkarton->setDbValue($row['beltkarton']);
        $this->keteranganbelt->setDbValue($row['keteranganbelt']);
        $this->kartonluar->setDbValue($row['kartonluar']);
        $this->bariskarton->setDbValue($row['bariskarton']);
        $this->kolomkarton->setDbValue($row['kolomkarton']);
        $this->stackkarton->setDbValue($row['stackkarton']);
        $this->isikarton->setDbValue($row['isikarton']);
        $this->jenislabel->setDbValue($row['jenislabel']);
        $this->keteranganjenislabel->setDbValue($row['keteranganjenislabel']);
        $this->kualitaslabel->setDbValue($row['kualitaslabel']);
        $this->jumlahwarnalabel->setDbValue($row['jumlahwarnalabel']);
        $this->metaliklabel->setDbValue($row['metaliklabel']);
        $this->etiketlabel->setDbValue($row['etiketlabel']);
        $this->keteranganlabel->setDbValue($row['keteranganlabel']);
        $this->kategoridelivery->setDbValue($row['kategoridelivery']);
        $this->alamatpengiriman->setDbValue($row['alamatpengiriman']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderkontrak->setDbValue($row['orderkontrak']);
        $this->hargaperpcs->setDbValue($row['hargaperpcs']);
        $this->hargaperkarton->setDbValue($row['hargaperkarton']);
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->lampiran->setDbValue($this->lampiran->Upload->DbValue);
        $this->prepared_by->setDbValue($row['prepared_by']);
        $this->checked_by->setDbValue($row['checked_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->approved_date->setDbValue($row['approved_date']);
        $this->disetujui->setDbValue($row['disetujui']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['tglpengajuan'] = null;
        $row['idnpd_sample'] = null;
        $row['nama'] = null;
        $row['bentuk'] = null;
        $row['viskositas'] = null;
        $row['warna'] = null;
        $row['bauparfum'] = null;
        $row['aplikasisediaan'] = null;
        $row['volume'] = null;
        $row['bahanaktif'] = null;
        $row['volumewadah'] = null;
        $row['bahanwadah'] = null;
        $row['warnawadah'] = null;
        $row['bentukwadah'] = null;
        $row['jenistutup'] = null;
        $row['bahantutup'] = null;
        $row['warnatutup'] = null;
        $row['bentuktutup'] = null;
        $row['segel'] = null;
        $row['catatanprimer'] = null;
        $row['packingproduk'] = null;
        $row['keteranganpacking'] = null;
        $row['beltkarton'] = null;
        $row['keteranganbelt'] = null;
        $row['kartonluar'] = null;
        $row['bariskarton'] = null;
        $row['kolomkarton'] = null;
        $row['stackkarton'] = null;
        $row['isikarton'] = null;
        $row['jenislabel'] = null;
        $row['keteranganjenislabel'] = null;
        $row['kualitaslabel'] = null;
        $row['jumlahwarnalabel'] = null;
        $row['metaliklabel'] = null;
        $row['etiketlabel'] = null;
        $row['keteranganlabel'] = null;
        $row['kategoridelivery'] = null;
        $row['alamatpengiriman'] = null;
        $row['orderperdana'] = null;
        $row['orderkontrak'] = null;
        $row['hargaperpcs'] = null;
        $row['hargaperkarton'] = null;
        $row['lampiran'] = null;
        $row['prepared_by'] = null;
        $row['checked_by'] = null;
        $row['approved_by'] = null;
        $row['approved_date'] = null;
        $row['disetujui'] = null;
        $row['created_at'] = null;
        $row['readonly'] = null;
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

        // idnpd

        // tglpengajuan

        // idnpd_sample

        // nama

        // bentuk

        // viskositas

        // warna

        // bauparfum

        // aplikasisediaan

        // volume

        // bahanaktif

        // volumewadah

        // bahanwadah

        // warnawadah

        // bentukwadah

        // jenistutup

        // bahantutup

        // warnatutup

        // bentuktutup

        // segel

        // catatanprimer

        // packingproduk

        // keteranganpacking

        // beltkarton

        // keteranganbelt

        // kartonluar

        // bariskarton

        // kolomkarton

        // stackkarton

        // isikarton

        // jenislabel

        // keteranganjenislabel

        // kualitaslabel

        // jumlahwarnalabel

        // metaliklabel

        // etiketlabel

        // keteranganlabel

        // kategoridelivery

        // alamatpengiriman

        // orderperdana

        // orderkontrak

        // hargaperpcs

        // hargaperkarton

        // lampiran

        // prepared_by

        // checked_by

        // approved_by

        // approved_date

        // disetujui

        // created_at

        // readonly

        // updated_at
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
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirmsample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // tglpengajuan
            $this->tglpengajuan->ViewValue = $this->tglpengajuan->CurrentValue;
            $this->tglpengajuan->ViewValue = FormatDateTime($this->tglpengajuan->ViewValue, 0);
            $this->tglpengajuan->ViewCustomAttributes = "";

            // idnpd_sample
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
                if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirmsample WHERE readonly=0)" : "";
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
            $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
                if ($this->viskositas->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
            $this->bauparfum->ViewValue = $this->bauparfum->CurrentValue;
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

            // volumewadah
            $this->volumewadah->ViewValue = $this->volumewadah->CurrentValue;
            $this->volumewadah->ViewCustomAttributes = "";

            // bahanwadah
            $this->bahanwadah->ViewValue = $this->bahanwadah->CurrentValue;
            $this->bahanwadah->ViewCustomAttributes = "";

            // warnawadah
            $this->warnawadah->ViewValue = $this->warnawadah->CurrentValue;
            $this->warnawadah->ViewCustomAttributes = "";

            // bentukwadah
            $this->bentukwadah->ViewValue = $this->bentukwadah->CurrentValue;
            $this->bentukwadah->ViewCustomAttributes = "";

            // jenistutup
            $this->jenistutup->ViewValue = $this->jenistutup->CurrentValue;
            $this->jenistutup->ViewCustomAttributes = "";

            // bahantutup
            $this->bahantutup->ViewValue = $this->bahantutup->CurrentValue;
            $this->bahantutup->ViewCustomAttributes = "";

            // warnatutup
            $this->warnatutup->ViewValue = $this->warnatutup->CurrentValue;
            $this->warnatutup->ViewCustomAttributes = "";

            // bentuktutup
            $this->bentuktutup->ViewValue = $this->bentuktutup->CurrentValue;
            $this->bentuktutup->ViewCustomAttributes = "";

            // segel
            if (strval($this->segel->CurrentValue) != "") {
                $this->segel->ViewValue = $this->segel->optionCaption($this->segel->CurrentValue);
            } else {
                $this->segel->ViewValue = null;
            }
            $this->segel->ViewCustomAttributes = "";

            // catatanprimer
            $this->catatanprimer->ViewValue = $this->catatanprimer->CurrentValue;
            $this->catatanprimer->ViewCustomAttributes = "";

            // packingproduk
            $this->packingproduk->ViewValue = $this->packingproduk->CurrentValue;
            $this->packingproduk->ViewCustomAttributes = "";

            // keteranganpacking
            $this->keteranganpacking->ViewValue = $this->keteranganpacking->CurrentValue;
            $this->keteranganpacking->ViewCustomAttributes = "";

            // beltkarton
            $this->beltkarton->ViewValue = $this->beltkarton->CurrentValue;
            $this->beltkarton->ViewCustomAttributes = "";

            // keteranganbelt
            $this->keteranganbelt->ViewValue = $this->keteranganbelt->CurrentValue;
            $this->keteranganbelt->ViewCustomAttributes = "";

            // kartonluar
            $this->kartonluar->ViewValue = $this->kartonluar->CurrentValue;
            $this->kartonluar->ViewCustomAttributes = "";

            // bariskarton
            $this->bariskarton->ViewValue = $this->bariskarton->CurrentValue;
            $this->bariskarton->ViewCustomAttributes = "";

            // kolomkarton
            $this->kolomkarton->ViewValue = $this->kolomkarton->CurrentValue;
            $this->kolomkarton->ViewCustomAttributes = "";

            // stackkarton
            $this->stackkarton->ViewValue = $this->stackkarton->CurrentValue;
            $this->stackkarton->ViewCustomAttributes = "";

            // isikarton
            $this->isikarton->ViewValue = $this->isikarton->CurrentValue;
            $this->isikarton->ViewCustomAttributes = "";

            // jenislabel
            $curVal = trim(strval($this->jenislabel->CurrentValue));
            if ($curVal != "") {
                $this->jenislabel->ViewValue = $this->jenislabel->lookupCacheOption($curVal);
                if ($this->jenislabel->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->jenislabel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jenislabel->Lookup->renderViewRow($rswrk[0]);
                        $this->jenislabel->ViewValue = $this->jenislabel->displayValue($arwrk);
                    } else {
                        $this->jenislabel->ViewValue = $this->jenislabel->CurrentValue;
                    }
                }
            } else {
                $this->jenislabel->ViewValue = null;
            }
            $this->jenislabel->ViewCustomAttributes = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->ViewValue = $this->keteranganjenislabel->CurrentValue;
            $this->keteranganjenislabel->ViewCustomAttributes = "";

            // kualitaslabel
            $curVal = trim(strval($this->kualitaslabel->CurrentValue));
            if ($curVal != "") {
                $this->kualitaslabel->ViewValue = $this->kualitaslabel->lookupCacheOption($curVal);
                if ($this->kualitaslabel->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kualitaslabel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kualitaslabel->Lookup->renderViewRow($rswrk[0]);
                        $this->kualitaslabel->ViewValue = $this->kualitaslabel->displayValue($arwrk);
                    } else {
                        $this->kualitaslabel->ViewValue = $this->kualitaslabel->CurrentValue;
                    }
                }
            } else {
                $this->kualitaslabel->ViewValue = null;
            }
            $this->kualitaslabel->ViewCustomAttributes = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->ViewValue = $this->jumlahwarnalabel->CurrentValue;
            $this->jumlahwarnalabel->ViewCustomAttributes = "";

            // metaliklabel
            $this->metaliklabel->ViewValue = $this->metaliklabel->CurrentValue;
            $this->metaliklabel->ViewCustomAttributes = "";

            // etiketlabel
            $this->etiketlabel->ViewValue = $this->etiketlabel->CurrentValue;
            $this->etiketlabel->ViewCustomAttributes = "";

            // keteranganlabel
            $this->keteranganlabel->ViewValue = $this->keteranganlabel->CurrentValue;
            $this->keteranganlabel->ViewCustomAttributes = "";

            // kategoridelivery
            $curVal = trim(strval($this->kategoridelivery->CurrentValue));
            if ($curVal != "") {
                $this->kategoridelivery->ViewValue = $this->kategoridelivery->lookupCacheOption($curVal);
                if ($this->kategoridelivery->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kategoridelivery->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kategoridelivery->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kategoridelivery->Lookup->renderViewRow($row);
                            $this->kategoridelivery->ViewValue->add($this->kategoridelivery->displayValue($arwrk));
                        }
                    } else {
                        $this->kategoridelivery->ViewValue = $this->kategoridelivery->CurrentValue;
                    }
                }
            } else {
                $this->kategoridelivery->ViewValue = null;
            }
            $this->kategoridelivery->ViewCustomAttributes = "";

            // alamatpengiriman
            $this->alamatpengiriman->ViewValue = $this->alamatpengiriman->CurrentValue;
            $this->alamatpengiriman->ViewCustomAttributes = "";

            // orderperdana
            $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
            $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
            $this->orderperdana->ViewCustomAttributes = "";

            // orderkontrak
            $this->orderkontrak->ViewValue = $this->orderkontrak->CurrentValue;
            $this->orderkontrak->ViewValue = FormatNumber($this->orderkontrak->ViewValue, 0, -2, -2, -2);
            $this->orderkontrak->ViewCustomAttributes = "";

            // hargaperpcs
            $this->hargaperpcs->ViewValue = $this->hargaperpcs->CurrentValue;
            $this->hargaperpcs->ViewValue = FormatCurrency($this->hargaperpcs->ViewValue, 2, -2, -2, -2);
            $this->hargaperpcs->ViewCustomAttributes = "";

            // hargaperkarton
            $this->hargaperkarton->ViewValue = $this->hargaperkarton->CurrentValue;
            $this->hargaperkarton->ViewValue = FormatNumber($this->hargaperkarton->ViewValue, 0, -2, -2, -2);
            $this->hargaperkarton->ViewCustomAttributes = "";

            // lampiran
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->ViewValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->ViewValue = "";
            }
            $this->lampiran->ViewCustomAttributes = "";

            // prepared_by
            $this->prepared_by->ViewValue = $this->prepared_by->CurrentValue;
            $this->prepared_by->ViewValue = FormatNumber($this->prepared_by->ViewValue, 0, -2, -2, -2);
            $this->prepared_by->ViewCustomAttributes = "";

            // checked_by
            $this->checked_by->ViewValue = $this->checked_by->CurrentValue;
            $this->checked_by->ViewValue = FormatNumber($this->checked_by->ViewValue, 0, -2, -2, -2);
            $this->checked_by->ViewCustomAttributes = "";

            // approved_by
            $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
            $this->approved_by->ViewValue = FormatNumber($this->approved_by->ViewValue, 0, -2, -2, -2);
            $this->approved_by->ViewCustomAttributes = "";

            // approved_date
            $this->approved_date->ViewValue = $this->approved_date->CurrentValue;
            $this->approved_date->ViewValue = FormatNumber($this->approved_date->ViewValue, 0, -2, -2, -2);
            $this->approved_date->ViewCustomAttributes = "";

            // disetujui
            if (strval($this->disetujui->CurrentValue) != "") {
                $this->disetujui->ViewValue = $this->disetujui->optionCaption($this->disetujui->CurrentValue);
            } else {
                $this->disetujui->ViewValue = null;
            }
            $this->disetujui->ViewCustomAttributes = "";

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

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // tglpengajuan
            $this->tglpengajuan->LinkCustomAttributes = "";
            $this->tglpengajuan->HrefValue = "";
            $this->tglpengajuan->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // bauparfum
            $this->bauparfum->LinkCustomAttributes = "";
            $this->bauparfum->HrefValue = "";
            $this->bauparfum->TooltipValue = "";
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fnpd_hargalistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);

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
                case "x_idnpd":
                    $lookupFilter = function () {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirmsample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirmsample WHERE readonly=0)" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_viskositas":
                    break;
                case "x_warna":
                    break;
                case "x_aplikasisediaan":
                    break;
                case "x_segel":
                    break;
                case "x_jenislabel":
                    break;
                case "x_kualitaslabel":
                    break;
                case "x_kategoridelivery":
                    break;
                case "x_disetujui":
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
        if ($this->readonly->CurrentValue == 1) {
        	$this->ListOptions->Items["edit"]->Body = "";
        	$this->ListOptions->Items["delete"]->Body = "";
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
