<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdTermsList extends NpdTerms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_terms';

    // Page object name
    public $PageObjName = "NpdTermsList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpd_termslist";
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

        // Table object (npd_terms)
        if (!isset($GLOBALS["npd_terms"]) || get_class($GLOBALS["npd_terms"]) == PROJECT_NAMESPACE . "npd_terms") {
            $GLOBALS["npd_terms"] = &$this;
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
        $this->AddUrl = "NpdTermsAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "NpdTermsDelete";
        $this->MultiUpdateUrl = "NpdTermsUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_terms');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fnpd_termslistsrch";

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
                $doc = new $class(Container("npd_terms"));
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
        $this->idnpd->setVisibility();
        $this->status->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->sifat_order->setVisibility();
        $this->ukuran_utama->setVisibility();
        $this->utama_harga_isi->setVisibility();
        $this->utama_harga_isi_order->setVisibility();
        $this->utama_harga_primer->setVisibility();
        $this->utama_harga_primer_order->setVisibility();
        $this->utama_harga_sekunder->setVisibility();
        $this->utama_harga_sekunder_order->setVisibility();
        $this->utama_harga_label->setVisibility();
        $this->utama_harga_label_order->setVisibility();
        $this->utama_harga_total->setVisibility();
        $this->utama_harga_total_order->setVisibility();
        $this->ukuran_lain->setVisibility();
        $this->lain_harga_isi->setVisibility();
        $this->lain_harga_isi_order->setVisibility();
        $this->lain_harga_primer->setVisibility();
        $this->lain_harga_primer_order->setVisibility();
        $this->lain_harga_sekunder->setVisibility();
        $this->lain_harga_sekunder_order->setVisibility();
        $this->lain_harga_label->setVisibility();
        $this->lain_harga_label_order->setVisibility();
        $this->lain_harga_total->setVisibility();
        $this->lain_harga_total_order->setVisibility();
        $this->isi_bahan_aktif->setVisibility();
        $this->isi_bahan_lain->setVisibility();
        $this->isi_parfum->setVisibility();
        $this->isi_estetika->setVisibility();
        $this->kemasan_wadah->setVisibility();
        $this->kemasan_tutup->setVisibility();
        $this->kemasan_sekunder->setVisibility();
        $this->label_desain->setVisibility();
        $this->label_cetak->setVisibility();
        $this->label_lainlain->setVisibility();
        $this->delivery_pickup->setVisibility();
        $this->delivery_singlepoint->setVisibility();
        $this->delivery_multipoint->setVisibility();
        $this->delivery_jumlahpoint->setVisibility();
        $this->delivery_termslain->setVisibility();
        $this->catatan_khusus->Visible = false;
        $this->dibuatdi->setVisibility();
        $this->created_at->setVisibility();
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
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->tglsubmit->AdvancedSearch->toJson(), ","); // Field tglsubmit
        $filterList = Concat($filterList, $this->sifat_order->AdvancedSearch->toJson(), ","); // Field sifat_order
        $filterList = Concat($filterList, $this->ukuran_utama->AdvancedSearch->toJson(), ","); // Field ukuran_utama
        $filterList = Concat($filterList, $this->utama_harga_isi->AdvancedSearch->toJson(), ","); // Field utama_harga_isi
        $filterList = Concat($filterList, $this->utama_harga_isi_order->AdvancedSearch->toJson(), ","); // Field utama_harga_isi_order
        $filterList = Concat($filterList, $this->utama_harga_primer->AdvancedSearch->toJson(), ","); // Field utama_harga_primer
        $filterList = Concat($filterList, $this->utama_harga_primer_order->AdvancedSearch->toJson(), ","); // Field utama_harga_primer_order
        $filterList = Concat($filterList, $this->utama_harga_sekunder->AdvancedSearch->toJson(), ","); // Field utama_harga_sekunder
        $filterList = Concat($filterList, $this->utama_harga_sekunder_order->AdvancedSearch->toJson(), ","); // Field utama_harga_sekunder_order
        $filterList = Concat($filterList, $this->utama_harga_label->AdvancedSearch->toJson(), ","); // Field utama_harga_label
        $filterList = Concat($filterList, $this->utama_harga_label_order->AdvancedSearch->toJson(), ","); // Field utama_harga_label_order
        $filterList = Concat($filterList, $this->utama_harga_total->AdvancedSearch->toJson(), ","); // Field utama_harga_total
        $filterList = Concat($filterList, $this->utama_harga_total_order->AdvancedSearch->toJson(), ","); // Field utama_harga_total_order
        $filterList = Concat($filterList, $this->ukuran_lain->AdvancedSearch->toJson(), ","); // Field ukuran_lain
        $filterList = Concat($filterList, $this->lain_harga_isi->AdvancedSearch->toJson(), ","); // Field lain_harga_isi
        $filterList = Concat($filterList, $this->lain_harga_isi_order->AdvancedSearch->toJson(), ","); // Field lain_harga_isi_order
        $filterList = Concat($filterList, $this->lain_harga_primer->AdvancedSearch->toJson(), ","); // Field lain_harga_primer
        $filterList = Concat($filterList, $this->lain_harga_primer_order->AdvancedSearch->toJson(), ","); // Field lain_harga_primer_order
        $filterList = Concat($filterList, $this->lain_harga_sekunder->AdvancedSearch->toJson(), ","); // Field lain_harga_sekunder
        $filterList = Concat($filterList, $this->lain_harga_sekunder_order->AdvancedSearch->toJson(), ","); // Field lain_harga_sekunder_order
        $filterList = Concat($filterList, $this->lain_harga_label->AdvancedSearch->toJson(), ","); // Field lain_harga_label
        $filterList = Concat($filterList, $this->lain_harga_label_order->AdvancedSearch->toJson(), ","); // Field lain_harga_label_order
        $filterList = Concat($filterList, $this->lain_harga_total->AdvancedSearch->toJson(), ","); // Field lain_harga_total
        $filterList = Concat($filterList, $this->lain_harga_total_order->AdvancedSearch->toJson(), ","); // Field lain_harga_total_order
        $filterList = Concat($filterList, $this->isi_bahan_aktif->AdvancedSearch->toJson(), ","); // Field isi_bahan_aktif
        $filterList = Concat($filterList, $this->isi_bahan_lain->AdvancedSearch->toJson(), ","); // Field isi_bahan_lain
        $filterList = Concat($filterList, $this->isi_parfum->AdvancedSearch->toJson(), ","); // Field isi_parfum
        $filterList = Concat($filterList, $this->isi_estetika->AdvancedSearch->toJson(), ","); // Field isi_estetika
        $filterList = Concat($filterList, $this->kemasan_wadah->AdvancedSearch->toJson(), ","); // Field kemasan_wadah
        $filterList = Concat($filterList, $this->kemasan_tutup->AdvancedSearch->toJson(), ","); // Field kemasan_tutup
        $filterList = Concat($filterList, $this->kemasan_sekunder->AdvancedSearch->toJson(), ","); // Field kemasan_sekunder
        $filterList = Concat($filterList, $this->label_desain->AdvancedSearch->toJson(), ","); // Field label_desain
        $filterList = Concat($filterList, $this->label_cetak->AdvancedSearch->toJson(), ","); // Field label_cetak
        $filterList = Concat($filterList, $this->label_lainlain->AdvancedSearch->toJson(), ","); // Field label_lainlain
        $filterList = Concat($filterList, $this->delivery_pickup->AdvancedSearch->toJson(), ","); // Field delivery_pickup
        $filterList = Concat($filterList, $this->delivery_singlepoint->AdvancedSearch->toJson(), ","); // Field delivery_singlepoint
        $filterList = Concat($filterList, $this->delivery_multipoint->AdvancedSearch->toJson(), ","); // Field delivery_multipoint
        $filterList = Concat($filterList, $this->delivery_jumlahpoint->AdvancedSearch->toJson(), ","); // Field delivery_jumlahpoint
        $filterList = Concat($filterList, $this->delivery_termslain->AdvancedSearch->toJson(), ","); // Field delivery_termslain
        $filterList = Concat($filterList, $this->catatan_khusus->AdvancedSearch->toJson(), ","); // Field catatan_khusus
        $filterList = Concat($filterList, $this->dibuatdi->AdvancedSearch->toJson(), ","); // Field dibuatdi
        $filterList = Concat($filterList, $this->created_at->AdvancedSearch->toJson(), ","); // Field created_at
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fnpd_termslistsrch", $filters);
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

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field tglsubmit
        $this->tglsubmit->AdvancedSearch->SearchValue = @$filter["x_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchOperator = @$filter["z_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchCondition = @$filter["v_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchValue2 = @$filter["y_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchOperator2 = @$filter["w_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->save();

        // Field sifat_order
        $this->sifat_order->AdvancedSearch->SearchValue = @$filter["x_sifat_order"];
        $this->sifat_order->AdvancedSearch->SearchOperator = @$filter["z_sifat_order"];
        $this->sifat_order->AdvancedSearch->SearchCondition = @$filter["v_sifat_order"];
        $this->sifat_order->AdvancedSearch->SearchValue2 = @$filter["y_sifat_order"];
        $this->sifat_order->AdvancedSearch->SearchOperator2 = @$filter["w_sifat_order"];
        $this->sifat_order->AdvancedSearch->save();

        // Field ukuran_utama
        $this->ukuran_utama->AdvancedSearch->SearchValue = @$filter["x_ukuran_utama"];
        $this->ukuran_utama->AdvancedSearch->SearchOperator = @$filter["z_ukuran_utama"];
        $this->ukuran_utama->AdvancedSearch->SearchCondition = @$filter["v_ukuran_utama"];
        $this->ukuran_utama->AdvancedSearch->SearchValue2 = @$filter["y_ukuran_utama"];
        $this->ukuran_utama->AdvancedSearch->SearchOperator2 = @$filter["w_ukuran_utama"];
        $this->ukuran_utama->AdvancedSearch->save();

        // Field utama_harga_isi
        $this->utama_harga_isi->AdvancedSearch->SearchValue = @$filter["x_utama_harga_isi"];
        $this->utama_harga_isi->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_isi"];
        $this->utama_harga_isi->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_isi"];
        $this->utama_harga_isi->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_isi"];
        $this->utama_harga_isi->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_isi"];
        $this->utama_harga_isi->AdvancedSearch->save();

        // Field utama_harga_isi_order
        $this->utama_harga_isi_order->AdvancedSearch->SearchValue = @$filter["x_utama_harga_isi_order"];
        $this->utama_harga_isi_order->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_isi_order"];
        $this->utama_harga_isi_order->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_isi_order"];
        $this->utama_harga_isi_order->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_isi_order"];
        $this->utama_harga_isi_order->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_isi_order"];
        $this->utama_harga_isi_order->AdvancedSearch->save();

        // Field utama_harga_primer
        $this->utama_harga_primer->AdvancedSearch->SearchValue = @$filter["x_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->save();

        // Field utama_harga_primer_order
        $this->utama_harga_primer_order->AdvancedSearch->SearchValue = @$filter["x_utama_harga_primer_order"];
        $this->utama_harga_primer_order->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_primer_order"];
        $this->utama_harga_primer_order->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_primer_order"];
        $this->utama_harga_primer_order->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_primer_order"];
        $this->utama_harga_primer_order->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_primer_order"];
        $this->utama_harga_primer_order->AdvancedSearch->save();

        // Field utama_harga_sekunder
        $this->utama_harga_sekunder->AdvancedSearch->SearchValue = @$filter["x_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->save();

        // Field utama_harga_sekunder_order
        $this->utama_harga_sekunder_order->AdvancedSearch->SearchValue = @$filter["x_utama_harga_sekunder_order"];
        $this->utama_harga_sekunder_order->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_sekunder_order"];
        $this->utama_harga_sekunder_order->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_sekunder_order"];
        $this->utama_harga_sekunder_order->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_sekunder_order"];
        $this->utama_harga_sekunder_order->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_sekunder_order"];
        $this->utama_harga_sekunder_order->AdvancedSearch->save();

        // Field utama_harga_label
        $this->utama_harga_label->AdvancedSearch->SearchValue = @$filter["x_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->save();

        // Field utama_harga_label_order
        $this->utama_harga_label_order->AdvancedSearch->SearchValue = @$filter["x_utama_harga_label_order"];
        $this->utama_harga_label_order->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_label_order"];
        $this->utama_harga_label_order->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_label_order"];
        $this->utama_harga_label_order->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_label_order"];
        $this->utama_harga_label_order->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_label_order"];
        $this->utama_harga_label_order->AdvancedSearch->save();

        // Field utama_harga_total
        $this->utama_harga_total->AdvancedSearch->SearchValue = @$filter["x_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->save();

        // Field utama_harga_total_order
        $this->utama_harga_total_order->AdvancedSearch->SearchValue = @$filter["x_utama_harga_total_order"];
        $this->utama_harga_total_order->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_total_order"];
        $this->utama_harga_total_order->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_total_order"];
        $this->utama_harga_total_order->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_total_order"];
        $this->utama_harga_total_order->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_total_order"];
        $this->utama_harga_total_order->AdvancedSearch->save();

        // Field ukuran_lain
        $this->ukuran_lain->AdvancedSearch->SearchValue = @$filter["x_ukuran_lain"];
        $this->ukuran_lain->AdvancedSearch->SearchOperator = @$filter["z_ukuran_lain"];
        $this->ukuran_lain->AdvancedSearch->SearchCondition = @$filter["v_ukuran_lain"];
        $this->ukuran_lain->AdvancedSearch->SearchValue2 = @$filter["y_ukuran_lain"];
        $this->ukuran_lain->AdvancedSearch->SearchOperator2 = @$filter["w_ukuran_lain"];
        $this->ukuran_lain->AdvancedSearch->save();

        // Field lain_harga_isi
        $this->lain_harga_isi->AdvancedSearch->SearchValue = @$filter["x_lain_harga_isi"];
        $this->lain_harga_isi->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_isi"];
        $this->lain_harga_isi->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_isi"];
        $this->lain_harga_isi->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_isi"];
        $this->lain_harga_isi->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_isi"];
        $this->lain_harga_isi->AdvancedSearch->save();

        // Field lain_harga_isi_order
        $this->lain_harga_isi_order->AdvancedSearch->SearchValue = @$filter["x_lain_harga_isi_order"];
        $this->lain_harga_isi_order->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_isi_order"];
        $this->lain_harga_isi_order->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_isi_order"];
        $this->lain_harga_isi_order->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_isi_order"];
        $this->lain_harga_isi_order->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_isi_order"];
        $this->lain_harga_isi_order->AdvancedSearch->save();

        // Field lain_harga_primer
        $this->lain_harga_primer->AdvancedSearch->SearchValue = @$filter["x_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->save();

        // Field lain_harga_primer_order
        $this->lain_harga_primer_order->AdvancedSearch->SearchValue = @$filter["x_lain_harga_primer_order"];
        $this->lain_harga_primer_order->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_primer_order"];
        $this->lain_harga_primer_order->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_primer_order"];
        $this->lain_harga_primer_order->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_primer_order"];
        $this->lain_harga_primer_order->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_primer_order"];
        $this->lain_harga_primer_order->AdvancedSearch->save();

        // Field lain_harga_sekunder
        $this->lain_harga_sekunder->AdvancedSearch->SearchValue = @$filter["x_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->save();

        // Field lain_harga_sekunder_order
        $this->lain_harga_sekunder_order->AdvancedSearch->SearchValue = @$filter["x_lain_harga_sekunder_order"];
        $this->lain_harga_sekunder_order->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_sekunder_order"];
        $this->lain_harga_sekunder_order->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_sekunder_order"];
        $this->lain_harga_sekunder_order->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_sekunder_order"];
        $this->lain_harga_sekunder_order->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_sekunder_order"];
        $this->lain_harga_sekunder_order->AdvancedSearch->save();

        // Field lain_harga_label
        $this->lain_harga_label->AdvancedSearch->SearchValue = @$filter["x_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->save();

        // Field lain_harga_label_order
        $this->lain_harga_label_order->AdvancedSearch->SearchValue = @$filter["x_lain_harga_label_order"];
        $this->lain_harga_label_order->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_label_order"];
        $this->lain_harga_label_order->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_label_order"];
        $this->lain_harga_label_order->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_label_order"];
        $this->lain_harga_label_order->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_label_order"];
        $this->lain_harga_label_order->AdvancedSearch->save();

        // Field lain_harga_total
        $this->lain_harga_total->AdvancedSearch->SearchValue = @$filter["x_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->save();

        // Field lain_harga_total_order
        $this->lain_harga_total_order->AdvancedSearch->SearchValue = @$filter["x_lain_harga_total_order"];
        $this->lain_harga_total_order->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_total_order"];
        $this->lain_harga_total_order->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_total_order"];
        $this->lain_harga_total_order->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_total_order"];
        $this->lain_harga_total_order->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_total_order"];
        $this->lain_harga_total_order->AdvancedSearch->save();

        // Field isi_bahan_aktif
        $this->isi_bahan_aktif->AdvancedSearch->SearchValue = @$filter["x_isi_bahan_aktif"];
        $this->isi_bahan_aktif->AdvancedSearch->SearchOperator = @$filter["z_isi_bahan_aktif"];
        $this->isi_bahan_aktif->AdvancedSearch->SearchCondition = @$filter["v_isi_bahan_aktif"];
        $this->isi_bahan_aktif->AdvancedSearch->SearchValue2 = @$filter["y_isi_bahan_aktif"];
        $this->isi_bahan_aktif->AdvancedSearch->SearchOperator2 = @$filter["w_isi_bahan_aktif"];
        $this->isi_bahan_aktif->AdvancedSearch->save();

        // Field isi_bahan_lain
        $this->isi_bahan_lain->AdvancedSearch->SearchValue = @$filter["x_isi_bahan_lain"];
        $this->isi_bahan_lain->AdvancedSearch->SearchOperator = @$filter["z_isi_bahan_lain"];
        $this->isi_bahan_lain->AdvancedSearch->SearchCondition = @$filter["v_isi_bahan_lain"];
        $this->isi_bahan_lain->AdvancedSearch->SearchValue2 = @$filter["y_isi_bahan_lain"];
        $this->isi_bahan_lain->AdvancedSearch->SearchOperator2 = @$filter["w_isi_bahan_lain"];
        $this->isi_bahan_lain->AdvancedSearch->save();

        // Field isi_parfum
        $this->isi_parfum->AdvancedSearch->SearchValue = @$filter["x_isi_parfum"];
        $this->isi_parfum->AdvancedSearch->SearchOperator = @$filter["z_isi_parfum"];
        $this->isi_parfum->AdvancedSearch->SearchCondition = @$filter["v_isi_parfum"];
        $this->isi_parfum->AdvancedSearch->SearchValue2 = @$filter["y_isi_parfum"];
        $this->isi_parfum->AdvancedSearch->SearchOperator2 = @$filter["w_isi_parfum"];
        $this->isi_parfum->AdvancedSearch->save();

        // Field isi_estetika
        $this->isi_estetika->AdvancedSearch->SearchValue = @$filter["x_isi_estetika"];
        $this->isi_estetika->AdvancedSearch->SearchOperator = @$filter["z_isi_estetika"];
        $this->isi_estetika->AdvancedSearch->SearchCondition = @$filter["v_isi_estetika"];
        $this->isi_estetika->AdvancedSearch->SearchValue2 = @$filter["y_isi_estetika"];
        $this->isi_estetika->AdvancedSearch->SearchOperator2 = @$filter["w_isi_estetika"];
        $this->isi_estetika->AdvancedSearch->save();

        // Field kemasan_wadah
        $this->kemasan_wadah->AdvancedSearch->SearchValue = @$filter["x_kemasan_wadah"];
        $this->kemasan_wadah->AdvancedSearch->SearchOperator = @$filter["z_kemasan_wadah"];
        $this->kemasan_wadah->AdvancedSearch->SearchCondition = @$filter["v_kemasan_wadah"];
        $this->kemasan_wadah->AdvancedSearch->SearchValue2 = @$filter["y_kemasan_wadah"];
        $this->kemasan_wadah->AdvancedSearch->SearchOperator2 = @$filter["w_kemasan_wadah"];
        $this->kemasan_wadah->AdvancedSearch->save();

        // Field kemasan_tutup
        $this->kemasan_tutup->AdvancedSearch->SearchValue = @$filter["x_kemasan_tutup"];
        $this->kemasan_tutup->AdvancedSearch->SearchOperator = @$filter["z_kemasan_tutup"];
        $this->kemasan_tutup->AdvancedSearch->SearchCondition = @$filter["v_kemasan_tutup"];
        $this->kemasan_tutup->AdvancedSearch->SearchValue2 = @$filter["y_kemasan_tutup"];
        $this->kemasan_tutup->AdvancedSearch->SearchOperator2 = @$filter["w_kemasan_tutup"];
        $this->kemasan_tutup->AdvancedSearch->save();

        // Field kemasan_sekunder
        $this->kemasan_sekunder->AdvancedSearch->SearchValue = @$filter["x_kemasan_sekunder"];
        $this->kemasan_sekunder->AdvancedSearch->SearchOperator = @$filter["z_kemasan_sekunder"];
        $this->kemasan_sekunder->AdvancedSearch->SearchCondition = @$filter["v_kemasan_sekunder"];
        $this->kemasan_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_kemasan_sekunder"];
        $this->kemasan_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_kemasan_sekunder"];
        $this->kemasan_sekunder->AdvancedSearch->save();

        // Field label_desain
        $this->label_desain->AdvancedSearch->SearchValue = @$filter["x_label_desain"];
        $this->label_desain->AdvancedSearch->SearchOperator = @$filter["z_label_desain"];
        $this->label_desain->AdvancedSearch->SearchCondition = @$filter["v_label_desain"];
        $this->label_desain->AdvancedSearch->SearchValue2 = @$filter["y_label_desain"];
        $this->label_desain->AdvancedSearch->SearchOperator2 = @$filter["w_label_desain"];
        $this->label_desain->AdvancedSearch->save();

        // Field label_cetak
        $this->label_cetak->AdvancedSearch->SearchValue = @$filter["x_label_cetak"];
        $this->label_cetak->AdvancedSearch->SearchOperator = @$filter["z_label_cetak"];
        $this->label_cetak->AdvancedSearch->SearchCondition = @$filter["v_label_cetak"];
        $this->label_cetak->AdvancedSearch->SearchValue2 = @$filter["y_label_cetak"];
        $this->label_cetak->AdvancedSearch->SearchOperator2 = @$filter["w_label_cetak"];
        $this->label_cetak->AdvancedSearch->save();

        // Field label_lainlain
        $this->label_lainlain->AdvancedSearch->SearchValue = @$filter["x_label_lainlain"];
        $this->label_lainlain->AdvancedSearch->SearchOperator = @$filter["z_label_lainlain"];
        $this->label_lainlain->AdvancedSearch->SearchCondition = @$filter["v_label_lainlain"];
        $this->label_lainlain->AdvancedSearch->SearchValue2 = @$filter["y_label_lainlain"];
        $this->label_lainlain->AdvancedSearch->SearchOperator2 = @$filter["w_label_lainlain"];
        $this->label_lainlain->AdvancedSearch->save();

        // Field delivery_pickup
        $this->delivery_pickup->AdvancedSearch->SearchValue = @$filter["x_delivery_pickup"];
        $this->delivery_pickup->AdvancedSearch->SearchOperator = @$filter["z_delivery_pickup"];
        $this->delivery_pickup->AdvancedSearch->SearchCondition = @$filter["v_delivery_pickup"];
        $this->delivery_pickup->AdvancedSearch->SearchValue2 = @$filter["y_delivery_pickup"];
        $this->delivery_pickup->AdvancedSearch->SearchOperator2 = @$filter["w_delivery_pickup"];
        $this->delivery_pickup->AdvancedSearch->save();

        // Field delivery_singlepoint
        $this->delivery_singlepoint->AdvancedSearch->SearchValue = @$filter["x_delivery_singlepoint"];
        $this->delivery_singlepoint->AdvancedSearch->SearchOperator = @$filter["z_delivery_singlepoint"];
        $this->delivery_singlepoint->AdvancedSearch->SearchCondition = @$filter["v_delivery_singlepoint"];
        $this->delivery_singlepoint->AdvancedSearch->SearchValue2 = @$filter["y_delivery_singlepoint"];
        $this->delivery_singlepoint->AdvancedSearch->SearchOperator2 = @$filter["w_delivery_singlepoint"];
        $this->delivery_singlepoint->AdvancedSearch->save();

        // Field delivery_multipoint
        $this->delivery_multipoint->AdvancedSearch->SearchValue = @$filter["x_delivery_multipoint"];
        $this->delivery_multipoint->AdvancedSearch->SearchOperator = @$filter["z_delivery_multipoint"];
        $this->delivery_multipoint->AdvancedSearch->SearchCondition = @$filter["v_delivery_multipoint"];
        $this->delivery_multipoint->AdvancedSearch->SearchValue2 = @$filter["y_delivery_multipoint"];
        $this->delivery_multipoint->AdvancedSearch->SearchOperator2 = @$filter["w_delivery_multipoint"];
        $this->delivery_multipoint->AdvancedSearch->save();

        // Field delivery_jumlahpoint
        $this->delivery_jumlahpoint->AdvancedSearch->SearchValue = @$filter["x_delivery_jumlahpoint"];
        $this->delivery_jumlahpoint->AdvancedSearch->SearchOperator = @$filter["z_delivery_jumlahpoint"];
        $this->delivery_jumlahpoint->AdvancedSearch->SearchCondition = @$filter["v_delivery_jumlahpoint"];
        $this->delivery_jumlahpoint->AdvancedSearch->SearchValue2 = @$filter["y_delivery_jumlahpoint"];
        $this->delivery_jumlahpoint->AdvancedSearch->SearchOperator2 = @$filter["w_delivery_jumlahpoint"];
        $this->delivery_jumlahpoint->AdvancedSearch->save();

        // Field delivery_termslain
        $this->delivery_termslain->AdvancedSearch->SearchValue = @$filter["x_delivery_termslain"];
        $this->delivery_termslain->AdvancedSearch->SearchOperator = @$filter["z_delivery_termslain"];
        $this->delivery_termslain->AdvancedSearch->SearchCondition = @$filter["v_delivery_termslain"];
        $this->delivery_termslain->AdvancedSearch->SearchValue2 = @$filter["y_delivery_termslain"];
        $this->delivery_termslain->AdvancedSearch->SearchOperator2 = @$filter["w_delivery_termslain"];
        $this->delivery_termslain->AdvancedSearch->save();

        // Field catatan_khusus
        $this->catatan_khusus->AdvancedSearch->SearchValue = @$filter["x_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchOperator = @$filter["z_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchCondition = @$filter["v_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchValue2 = @$filter["y_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchOperator2 = @$filter["w_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->save();

        // Field dibuatdi
        $this->dibuatdi->AdvancedSearch->SearchValue = @$filter["x_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchOperator = @$filter["z_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchCondition = @$filter["v_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchValue2 = @$filter["y_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchOperator2 = @$filter["w_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->save();

        // Field created_at
        $this->created_at->AdvancedSearch->SearchValue = @$filter["x_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator = @$filter["z_created_at"];
        $this->created_at->AdvancedSearch->SearchCondition = @$filter["v_created_at"];
        $this->created_at->AdvancedSearch->SearchValue2 = @$filter["y_created_at"];
        $this->created_at->AdvancedSearch->SearchOperator2 = @$filter["w_created_at"];
        $this->created_at->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->status, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuran_utama, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuran_lain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isi_bahan_aktif, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isi_bahan_lain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isi_parfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isi_estetika, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasan_sekunder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->label_desain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->label_cetak, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->label_lainlain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_pickup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_singlepoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_multipoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_jumlahpoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_termslain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->catatan_khusus, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dibuatdi, $arKeywords, $type);
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
            $this->updateSort($this->idnpd); // idnpd
            $this->updateSort($this->status); // status
            $this->updateSort($this->tglsubmit); // tglsubmit
            $this->updateSort($this->sifat_order); // sifat_order
            $this->updateSort($this->ukuran_utama); // ukuran_utama
            $this->updateSort($this->utama_harga_isi); // utama_harga_isi
            $this->updateSort($this->utama_harga_isi_order); // utama_harga_isi_order
            $this->updateSort($this->utama_harga_primer); // utama_harga_primer
            $this->updateSort($this->utama_harga_primer_order); // utama_harga_primer_order
            $this->updateSort($this->utama_harga_sekunder); // utama_harga_sekunder
            $this->updateSort($this->utama_harga_sekunder_order); // utama_harga_sekunder_order
            $this->updateSort($this->utama_harga_label); // utama_harga_label
            $this->updateSort($this->utama_harga_label_order); // utama_harga_label_order
            $this->updateSort($this->utama_harga_total); // utama_harga_total
            $this->updateSort($this->utama_harga_total_order); // utama_harga_total_order
            $this->updateSort($this->ukuran_lain); // ukuran_lain
            $this->updateSort($this->lain_harga_isi); // lain_harga_isi
            $this->updateSort($this->lain_harga_isi_order); // lain_harga_isi_order
            $this->updateSort($this->lain_harga_primer); // lain_harga_primer
            $this->updateSort($this->lain_harga_primer_order); // lain_harga_primer_order
            $this->updateSort($this->lain_harga_sekunder); // lain_harga_sekunder
            $this->updateSort($this->lain_harga_sekunder_order); // lain_harga_sekunder_order
            $this->updateSort($this->lain_harga_label); // lain_harga_label
            $this->updateSort($this->lain_harga_label_order); // lain_harga_label_order
            $this->updateSort($this->lain_harga_total); // lain_harga_total
            $this->updateSort($this->lain_harga_total_order); // lain_harga_total_order
            $this->updateSort($this->isi_bahan_aktif); // isi_bahan_aktif
            $this->updateSort($this->isi_bahan_lain); // isi_bahan_lain
            $this->updateSort($this->isi_parfum); // isi_parfum
            $this->updateSort($this->isi_estetika); // isi_estetika
            $this->updateSort($this->kemasan_wadah); // kemasan_wadah
            $this->updateSort($this->kemasan_tutup); // kemasan_tutup
            $this->updateSort($this->kemasan_sekunder); // kemasan_sekunder
            $this->updateSort($this->label_desain); // label_desain
            $this->updateSort($this->label_cetak); // label_cetak
            $this->updateSort($this->label_lainlain); // label_lainlain
            $this->updateSort($this->delivery_pickup); // delivery_pickup
            $this->updateSort($this->delivery_singlepoint); // delivery_singlepoint
            $this->updateSort($this->delivery_multipoint); // delivery_multipoint
            $this->updateSort($this->delivery_jumlahpoint); // delivery_jumlahpoint
            $this->updateSort($this->delivery_termslain); // delivery_termslain
            $this->updateSort($this->dibuatdi); // dibuatdi
            $this->updateSort($this->created_at); // created_at
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
                $this->status->setSort("");
                $this->tglsubmit->setSort("");
                $this->sifat_order->setSort("");
                $this->ukuran_utama->setSort("");
                $this->utama_harga_isi->setSort("");
                $this->utama_harga_isi_order->setSort("");
                $this->utama_harga_primer->setSort("");
                $this->utama_harga_primer_order->setSort("");
                $this->utama_harga_sekunder->setSort("");
                $this->utama_harga_sekunder_order->setSort("");
                $this->utama_harga_label->setSort("");
                $this->utama_harga_label_order->setSort("");
                $this->utama_harga_total->setSort("");
                $this->utama_harga_total_order->setSort("");
                $this->ukuran_lain->setSort("");
                $this->lain_harga_isi->setSort("");
                $this->lain_harga_isi_order->setSort("");
                $this->lain_harga_primer->setSort("");
                $this->lain_harga_primer_order->setSort("");
                $this->lain_harga_sekunder->setSort("");
                $this->lain_harga_sekunder_order->setSort("");
                $this->lain_harga_label->setSort("");
                $this->lain_harga_label_order->setSort("");
                $this->lain_harga_total->setSort("");
                $this->lain_harga_total_order->setSort("");
                $this->isi_bahan_aktif->setSort("");
                $this->isi_bahan_lain->setSort("");
                $this->isi_parfum->setSort("");
                $this->isi_estetika->setSort("");
                $this->kemasan_wadah->setSort("");
                $this->kemasan_tutup->setSort("");
                $this->kemasan_sekunder->setSort("");
                $this->label_desain->setSort("");
                $this->label_cetak->setSort("");
                $this->label_lainlain->setSort("");
                $this->delivery_pickup->setSort("");
                $this->delivery_singlepoint->setSort("");
                $this->delivery_multipoint->setSort("");
                $this->delivery_jumlahpoint->setSort("");
                $this->delivery_termslain->setSort("");
                $this->catatan_khusus->setSort("");
                $this->dibuatdi->setSort("");
                $this->created_at->setSort("");
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

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
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

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fnpd_termslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fnpd_termslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fnpd_termslist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->status->setDbValue($row['status']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->sifat_order->setDbValue($row['sifat_order']);
        $this->ukuran_utama->setDbValue($row['ukuran_utama']);
        $this->utama_harga_isi->setDbValue($row['utama_harga_isi']);
        $this->utama_harga_isi_order->setDbValue($row['utama_harga_isi_order']);
        $this->utama_harga_primer->setDbValue($row['utama_harga_primer']);
        $this->utama_harga_primer_order->setDbValue($row['utama_harga_primer_order']);
        $this->utama_harga_sekunder->setDbValue($row['utama_harga_sekunder']);
        $this->utama_harga_sekunder_order->setDbValue($row['utama_harga_sekunder_order']);
        $this->utama_harga_label->setDbValue($row['utama_harga_label']);
        $this->utama_harga_label_order->setDbValue($row['utama_harga_label_order']);
        $this->utama_harga_total->setDbValue($row['utama_harga_total']);
        $this->utama_harga_total_order->setDbValue($row['utama_harga_total_order']);
        $this->ukuran_lain->setDbValue($row['ukuran_lain']);
        $this->lain_harga_isi->setDbValue($row['lain_harga_isi']);
        $this->lain_harga_isi_order->setDbValue($row['lain_harga_isi_order']);
        $this->lain_harga_primer->setDbValue($row['lain_harga_primer']);
        $this->lain_harga_primer_order->setDbValue($row['lain_harga_primer_order']);
        $this->lain_harga_sekunder->setDbValue($row['lain_harga_sekunder']);
        $this->lain_harga_sekunder_order->setDbValue($row['lain_harga_sekunder_order']);
        $this->lain_harga_label->setDbValue($row['lain_harga_label']);
        $this->lain_harga_label_order->setDbValue($row['lain_harga_label_order']);
        $this->lain_harga_total->setDbValue($row['lain_harga_total']);
        $this->lain_harga_total_order->setDbValue($row['lain_harga_total_order']);
        $this->isi_bahan_aktif->setDbValue($row['isi_bahan_aktif']);
        $this->isi_bahan_lain->setDbValue($row['isi_bahan_lain']);
        $this->isi_parfum->setDbValue($row['isi_parfum']);
        $this->isi_estetika->setDbValue($row['isi_estetika']);
        $this->kemasan_wadah->setDbValue($row['kemasan_wadah']);
        $this->kemasan_tutup->setDbValue($row['kemasan_tutup']);
        $this->kemasan_sekunder->setDbValue($row['kemasan_sekunder']);
        $this->label_desain->setDbValue($row['label_desain']);
        $this->label_cetak->setDbValue($row['label_cetak']);
        $this->label_lainlain->setDbValue($row['label_lainlain']);
        $this->delivery_pickup->setDbValue($row['delivery_pickup']);
        $this->delivery_singlepoint->setDbValue($row['delivery_singlepoint']);
        $this->delivery_multipoint->setDbValue($row['delivery_multipoint']);
        $this->delivery_jumlahpoint->setDbValue($row['delivery_jumlahpoint']);
        $this->delivery_termslain->setDbValue($row['delivery_termslain']);
        $this->catatan_khusus->setDbValue($row['catatan_khusus']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['status'] = null;
        $row['tglsubmit'] = null;
        $row['sifat_order'] = null;
        $row['ukuran_utama'] = null;
        $row['utama_harga_isi'] = null;
        $row['utama_harga_isi_order'] = null;
        $row['utama_harga_primer'] = null;
        $row['utama_harga_primer_order'] = null;
        $row['utama_harga_sekunder'] = null;
        $row['utama_harga_sekunder_order'] = null;
        $row['utama_harga_label'] = null;
        $row['utama_harga_label_order'] = null;
        $row['utama_harga_total'] = null;
        $row['utama_harga_total_order'] = null;
        $row['ukuran_lain'] = null;
        $row['lain_harga_isi'] = null;
        $row['lain_harga_isi_order'] = null;
        $row['lain_harga_primer'] = null;
        $row['lain_harga_primer_order'] = null;
        $row['lain_harga_sekunder'] = null;
        $row['lain_harga_sekunder_order'] = null;
        $row['lain_harga_label'] = null;
        $row['lain_harga_label_order'] = null;
        $row['lain_harga_total'] = null;
        $row['lain_harga_total_order'] = null;
        $row['isi_bahan_aktif'] = null;
        $row['isi_bahan_lain'] = null;
        $row['isi_parfum'] = null;
        $row['isi_estetika'] = null;
        $row['kemasan_wadah'] = null;
        $row['kemasan_tutup'] = null;
        $row['kemasan_sekunder'] = null;
        $row['label_desain'] = null;
        $row['label_cetak'] = null;
        $row['label_lainlain'] = null;
        $row['delivery_pickup'] = null;
        $row['delivery_singlepoint'] = null;
        $row['delivery_multipoint'] = null;
        $row['delivery_jumlahpoint'] = null;
        $row['delivery_termslain'] = null;
        $row['catatan_khusus'] = null;
        $row['dibuatdi'] = null;
        $row['created_at'] = null;
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

        // status

        // tglsubmit

        // sifat_order

        // ukuran_utama

        // utama_harga_isi

        // utama_harga_isi_order

        // utama_harga_primer

        // utama_harga_primer_order

        // utama_harga_sekunder

        // utama_harga_sekunder_order

        // utama_harga_label

        // utama_harga_label_order

        // utama_harga_total

        // utama_harga_total_order

        // ukuran_lain

        // lain_harga_isi

        // lain_harga_isi_order

        // lain_harga_primer

        // lain_harga_primer_order

        // lain_harga_sekunder

        // lain_harga_sekunder_order

        // lain_harga_label

        // lain_harga_label_order

        // lain_harga_total

        // lain_harga_total_order

        // isi_bahan_aktif

        // isi_bahan_lain

        // isi_parfum

        // isi_estetika

        // kemasan_wadah

        // kemasan_tutup

        // kemasan_sekunder

        // label_desain

        // label_cetak

        // label_lainlain

        // delivery_pickup

        // delivery_singlepoint

        // delivery_multipoint

        // delivery_jumlahpoint

        // delivery_termslain

        // catatan_khusus

        // dibuatdi

        // created_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

            // sifat_order
            if (ConvertToBool($this->sifat_order->CurrentValue)) {
                $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(1) != "" ? $this->sifat_order->tagCaption(1) : "Yes";
            } else {
                $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(2) != "" ? $this->sifat_order->tagCaption(2) : "No";
            }
            $this->sifat_order->ViewCustomAttributes = "";

            // ukuran_utama
            $this->ukuran_utama->ViewValue = $this->ukuran_utama->CurrentValue;
            $this->ukuran_utama->ViewCustomAttributes = "";

            // utama_harga_isi
            $this->utama_harga_isi->ViewValue = $this->utama_harga_isi->CurrentValue;
            $this->utama_harga_isi->ViewValue = FormatNumber($this->utama_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi->ViewCustomAttributes = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->ViewValue = $this->utama_harga_isi_order->CurrentValue;
            $this->utama_harga_isi_order->ViewValue = FormatNumber($this->utama_harga_isi_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi_order->ViewCustomAttributes = "";

            // utama_harga_primer
            $this->utama_harga_primer->ViewValue = $this->utama_harga_primer->CurrentValue;
            $this->utama_harga_primer->ViewValue = FormatNumber($this->utama_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer->ViewCustomAttributes = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->ViewValue = $this->utama_harga_primer_order->CurrentValue;
            $this->utama_harga_primer_order->ViewValue = FormatNumber($this->utama_harga_primer_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer_order->ViewCustomAttributes = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->ViewValue = $this->utama_harga_sekunder->CurrentValue;
            $this->utama_harga_sekunder->ViewValue = FormatNumber($this->utama_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder->ViewCustomAttributes = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->ViewValue = $this->utama_harga_sekunder_order->CurrentValue;
            $this->utama_harga_sekunder_order->ViewValue = FormatNumber($this->utama_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder_order->ViewCustomAttributes = "";

            // utama_harga_label
            $this->utama_harga_label->ViewValue = $this->utama_harga_label->CurrentValue;
            $this->utama_harga_label->ViewValue = FormatNumber($this->utama_harga_label->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label->ViewCustomAttributes = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->ViewValue = $this->utama_harga_label_order->CurrentValue;
            $this->utama_harga_label_order->ViewValue = FormatNumber($this->utama_harga_label_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label_order->ViewCustomAttributes = "";

            // utama_harga_total
            $this->utama_harga_total->ViewValue = $this->utama_harga_total->CurrentValue;
            $this->utama_harga_total->ViewValue = FormatNumber($this->utama_harga_total->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total->ViewCustomAttributes = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->ViewValue = $this->utama_harga_total_order->CurrentValue;
            $this->utama_harga_total_order->ViewValue = FormatNumber($this->utama_harga_total_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total_order->ViewCustomAttributes = "";

            // ukuran_lain
            $this->ukuran_lain->ViewValue = $this->ukuran_lain->CurrentValue;
            $this->ukuran_lain->ViewCustomAttributes = "";

            // lain_harga_isi
            $this->lain_harga_isi->ViewValue = $this->lain_harga_isi->CurrentValue;
            $this->lain_harga_isi->ViewValue = FormatNumber($this->lain_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi->ViewCustomAttributes = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->ViewValue = $this->lain_harga_isi_order->CurrentValue;
            $this->lain_harga_isi_order->ViewValue = FormatNumber($this->lain_harga_isi_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi_order->ViewCustomAttributes = "";

            // lain_harga_primer
            $this->lain_harga_primer->ViewValue = $this->lain_harga_primer->CurrentValue;
            $this->lain_harga_primer->ViewValue = FormatNumber($this->lain_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer->ViewCustomAttributes = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->ViewValue = $this->lain_harga_primer_order->CurrentValue;
            $this->lain_harga_primer_order->ViewValue = FormatNumber($this->lain_harga_primer_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer_order->ViewCustomAttributes = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->ViewValue = $this->lain_harga_sekunder->CurrentValue;
            $this->lain_harga_sekunder->ViewValue = FormatNumber($this->lain_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder->ViewCustomAttributes = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->ViewValue = $this->lain_harga_sekunder_order->CurrentValue;
            $this->lain_harga_sekunder_order->ViewValue = FormatNumber($this->lain_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder_order->ViewCustomAttributes = "";

            // lain_harga_label
            $this->lain_harga_label->ViewValue = $this->lain_harga_label->CurrentValue;
            $this->lain_harga_label->ViewValue = FormatNumber($this->lain_harga_label->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label->ViewCustomAttributes = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->ViewValue = $this->lain_harga_label_order->CurrentValue;
            $this->lain_harga_label_order->ViewValue = FormatNumber($this->lain_harga_label_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label_order->ViewCustomAttributes = "";

            // lain_harga_total
            $this->lain_harga_total->ViewValue = $this->lain_harga_total->CurrentValue;
            $this->lain_harga_total->ViewValue = FormatNumber($this->lain_harga_total->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total->ViewCustomAttributes = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->ViewValue = $this->lain_harga_total_order->CurrentValue;
            $this->lain_harga_total_order->ViewValue = FormatNumber($this->lain_harga_total_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total_order->ViewCustomAttributes = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->ViewValue = $this->isi_bahan_aktif->CurrentValue;
            $this->isi_bahan_aktif->ViewCustomAttributes = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->ViewValue = $this->isi_bahan_lain->CurrentValue;
            $this->isi_bahan_lain->ViewCustomAttributes = "";

            // isi_parfum
            $this->isi_parfum->ViewValue = $this->isi_parfum->CurrentValue;
            $this->isi_parfum->ViewCustomAttributes = "";

            // isi_estetika
            $this->isi_estetika->ViewValue = $this->isi_estetika->CurrentValue;
            $this->isi_estetika->ViewCustomAttributes = "";

            // kemasan_wadah
            $this->kemasan_wadah->ViewValue = $this->kemasan_wadah->CurrentValue;
            $this->kemasan_wadah->ViewValue = FormatNumber($this->kemasan_wadah->ViewValue, 0, -2, -2, -2);
            $this->kemasan_wadah->ViewCustomAttributes = "";

            // kemasan_tutup
            $this->kemasan_tutup->ViewValue = $this->kemasan_tutup->CurrentValue;
            $this->kemasan_tutup->ViewValue = FormatNumber($this->kemasan_tutup->ViewValue, 0, -2, -2, -2);
            $this->kemasan_tutup->ViewCustomAttributes = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->ViewValue = $this->kemasan_sekunder->CurrentValue;
            $this->kemasan_sekunder->ViewCustomAttributes = "";

            // label_desain
            $this->label_desain->ViewValue = $this->label_desain->CurrentValue;
            $this->label_desain->ViewCustomAttributes = "";

            // label_cetak
            $this->label_cetak->ViewValue = $this->label_cetak->CurrentValue;
            $this->label_cetak->ViewCustomAttributes = "";

            // label_lainlain
            $this->label_lainlain->ViewValue = $this->label_lainlain->CurrentValue;
            $this->label_lainlain->ViewCustomAttributes = "";

            // delivery_pickup
            $this->delivery_pickup->ViewValue = $this->delivery_pickup->CurrentValue;
            $this->delivery_pickup->ViewCustomAttributes = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->ViewValue = $this->delivery_singlepoint->CurrentValue;
            $this->delivery_singlepoint->ViewCustomAttributes = "";

            // delivery_multipoint
            $this->delivery_multipoint->ViewValue = $this->delivery_multipoint->CurrentValue;
            $this->delivery_multipoint->ViewCustomAttributes = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->ViewValue = $this->delivery_jumlahpoint->CurrentValue;
            $this->delivery_jumlahpoint->ViewCustomAttributes = "";

            // delivery_termslain
            $this->delivery_termslain->ViewValue = $this->delivery_termslain->CurrentValue;
            $this->delivery_termslain->ViewCustomAttributes = "";

            // dibuatdi
            $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
            $this->dibuatdi->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";
            $this->tglsubmit->TooltipValue = "";

            // sifat_order
            $this->sifat_order->LinkCustomAttributes = "";
            $this->sifat_order->HrefValue = "";
            $this->sifat_order->TooltipValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";
            $this->ukuran_utama->TooltipValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";
            $this->utama_harga_isi->TooltipValue = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->LinkCustomAttributes = "";
            $this->utama_harga_isi_order->HrefValue = "";
            $this->utama_harga_isi_order->TooltipValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";
            $this->utama_harga_primer->TooltipValue = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->LinkCustomAttributes = "";
            $this->utama_harga_primer_order->HrefValue = "";
            $this->utama_harga_primer_order->TooltipValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";
            $this->utama_harga_sekunder->TooltipValue = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_order->HrefValue = "";
            $this->utama_harga_sekunder_order->TooltipValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";
            $this->utama_harga_label->TooltipValue = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->LinkCustomAttributes = "";
            $this->utama_harga_label_order->HrefValue = "";
            $this->utama_harga_label_order->TooltipValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";
            $this->utama_harga_total->TooltipValue = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->LinkCustomAttributes = "";
            $this->utama_harga_total_order->HrefValue = "";
            $this->utama_harga_total_order->TooltipValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";
            $this->ukuran_lain->TooltipValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";
            $this->lain_harga_isi->TooltipValue = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->LinkCustomAttributes = "";
            $this->lain_harga_isi_order->HrefValue = "";
            $this->lain_harga_isi_order->TooltipValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";
            $this->lain_harga_primer->TooltipValue = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->LinkCustomAttributes = "";
            $this->lain_harga_primer_order->HrefValue = "";
            $this->lain_harga_primer_order->TooltipValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";
            $this->lain_harga_sekunder->TooltipValue = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_order->HrefValue = "";
            $this->lain_harga_sekunder_order->TooltipValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";
            $this->lain_harga_label->TooltipValue = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->LinkCustomAttributes = "";
            $this->lain_harga_label_order->HrefValue = "";
            $this->lain_harga_label_order->TooltipValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";
            $this->lain_harga_total->TooltipValue = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->LinkCustomAttributes = "";
            $this->lain_harga_total_order->HrefValue = "";
            $this->lain_harga_total_order->TooltipValue = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->LinkCustomAttributes = "";
            $this->isi_bahan_aktif->HrefValue = "";
            $this->isi_bahan_aktif->TooltipValue = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->LinkCustomAttributes = "";
            $this->isi_bahan_lain->HrefValue = "";
            $this->isi_bahan_lain->TooltipValue = "";

            // isi_parfum
            $this->isi_parfum->LinkCustomAttributes = "";
            $this->isi_parfum->HrefValue = "";
            $this->isi_parfum->TooltipValue = "";

            // isi_estetika
            $this->isi_estetika->LinkCustomAttributes = "";
            $this->isi_estetika->HrefValue = "";
            $this->isi_estetika->TooltipValue = "";

            // kemasan_wadah
            $this->kemasan_wadah->LinkCustomAttributes = "";
            $this->kemasan_wadah->HrefValue = "";
            $this->kemasan_wadah->TooltipValue = "";

            // kemasan_tutup
            $this->kemasan_tutup->LinkCustomAttributes = "";
            $this->kemasan_tutup->HrefValue = "";
            $this->kemasan_tutup->TooltipValue = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->LinkCustomAttributes = "";
            $this->kemasan_sekunder->HrefValue = "";
            $this->kemasan_sekunder->TooltipValue = "";

            // label_desain
            $this->label_desain->LinkCustomAttributes = "";
            $this->label_desain->HrefValue = "";
            $this->label_desain->TooltipValue = "";

            // label_cetak
            $this->label_cetak->LinkCustomAttributes = "";
            $this->label_cetak->HrefValue = "";
            $this->label_cetak->TooltipValue = "";

            // label_lainlain
            $this->label_lainlain->LinkCustomAttributes = "";
            $this->label_lainlain->HrefValue = "";
            $this->label_lainlain->TooltipValue = "";

            // delivery_pickup
            $this->delivery_pickup->LinkCustomAttributes = "";
            $this->delivery_pickup->HrefValue = "";
            $this->delivery_pickup->TooltipValue = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->LinkCustomAttributes = "";
            $this->delivery_singlepoint->HrefValue = "";
            $this->delivery_singlepoint->TooltipValue = "";

            // delivery_multipoint
            $this->delivery_multipoint->LinkCustomAttributes = "";
            $this->delivery_multipoint->HrefValue = "";
            $this->delivery_multipoint->TooltipValue = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->LinkCustomAttributes = "";
            $this->delivery_jumlahpoint->HrefValue = "";
            $this->delivery_jumlahpoint->TooltipValue = "";

            // delivery_termslain
            $this->delivery_termslain->LinkCustomAttributes = "";
            $this->delivery_termslain->HrefValue = "";
            $this->delivery_termslain->TooltipValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";
            $this->dibuatdi->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fnpd_termslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_sifat_order":
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
