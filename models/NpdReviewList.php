<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdReviewList extends NpdReview
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_review';

    // Page object name
    public $PageObjName = "NpdReviewList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpd_reviewlist";
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

        // Table object (npd_review)
        if (!isset($GLOBALS["npd_review"]) || get_class($GLOBALS["npd_review"]) == PROJECT_NAMESPACE . "npd_review") {
            $GLOBALS["npd_review"] = &$this;
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
        $this->AddUrl = "NpdReviewAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "NpdReviewDelete";
        $this->MultiUpdateUrl = "NpdReviewUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_review');
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
        $this->FilterOptions->TagClassName = "ew-filter-option fnpd_reviewlistsrch";

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
                $doc = new $class(Container("npd_review"));
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
        $this->idnpd_sample->setVisibility();
        $this->tanggal_review->setVisibility();
        $this->tanggal_submit->setVisibility();
        $this->wadah->Visible = false;
        $this->bentuk_opsi->Visible = false;
        $this->bentuk_revisi->Visible = false;
        $this->viskositas_opsi->Visible = false;
        $this->viskositas_revisi->Visible = false;
        $this->jeniswarna_opsi->Visible = false;
        $this->jeniswarna_revisi->Visible = false;
        $this->tonewarna_opsi->Visible = false;
        $this->tonewarna_revisi->Visible = false;
        $this->gradasiwarna_opsi->Visible = false;
        $this->gradasiwarna_revisi->Visible = false;
        $this->bauparfum_opsi->Visible = false;
        $this->bauparfum_revisi->Visible = false;
        $this->estetika_opsi->Visible = false;
        $this->estetika_revisi->Visible = false;
        $this->aplikasiawal_opsi->Visible = false;
        $this->aplikasiawal_revisi->Visible = false;
        $this->aplikasilama_opsi->Visible = false;
        $this->aplikasilama_revisi->Visible = false;
        $this->efekpositif_opsi->Visible = false;
        $this->efekpositif_revisi->Visible = false;
        $this->efeknegatif_opsi->Visible = false;
        $this->efeknegatif_revisi->Visible = false;
        $this->kesimpulan->Visible = false;
        $this->status->setVisibility();
        $this->created_at->Visible = false;
        $this->readonly->Visible = false;
        $this->ukuran->setVisibility();
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
        $filterList = Concat($filterList, $this->idnpd_sample->AdvancedSearch->toJson(), ","); // Field idnpd_sample
        $filterList = Concat($filterList, $this->tanggal_review->AdvancedSearch->toJson(), ","); // Field tanggal_review
        $filterList = Concat($filterList, $this->tanggal_submit->AdvancedSearch->toJson(), ","); // Field tanggal_submit
        $filterList = Concat($filterList, $this->wadah->AdvancedSearch->toJson(), ","); // Field wadah
        $filterList = Concat($filterList, $this->bentuk_opsi->AdvancedSearch->toJson(), ","); // Field bentuk_opsi
        $filterList = Concat($filterList, $this->bentuk_revisi->AdvancedSearch->toJson(), ","); // Field bentuk_revisi
        $filterList = Concat($filterList, $this->viskositas_opsi->AdvancedSearch->toJson(), ","); // Field viskositas_opsi
        $filterList = Concat($filterList, $this->viskositas_revisi->AdvancedSearch->toJson(), ","); // Field viskositas_revisi
        $filterList = Concat($filterList, $this->jeniswarna_opsi->AdvancedSearch->toJson(), ","); // Field jeniswarna_opsi
        $filterList = Concat($filterList, $this->jeniswarna_revisi->AdvancedSearch->toJson(), ","); // Field jeniswarna_revisi
        $filterList = Concat($filterList, $this->tonewarna_opsi->AdvancedSearch->toJson(), ","); // Field tonewarna_opsi
        $filterList = Concat($filterList, $this->tonewarna_revisi->AdvancedSearch->toJson(), ","); // Field tonewarna_revisi
        $filterList = Concat($filterList, $this->gradasiwarna_opsi->AdvancedSearch->toJson(), ","); // Field gradasiwarna_opsi
        $filterList = Concat($filterList, $this->gradasiwarna_revisi->AdvancedSearch->toJson(), ","); // Field gradasiwarna_revisi
        $filterList = Concat($filterList, $this->bauparfum_opsi->AdvancedSearch->toJson(), ","); // Field bauparfum_opsi
        $filterList = Concat($filterList, $this->bauparfum_revisi->AdvancedSearch->toJson(), ","); // Field bauparfum_revisi
        $filterList = Concat($filterList, $this->estetika_opsi->AdvancedSearch->toJson(), ","); // Field estetika_opsi
        $filterList = Concat($filterList, $this->estetika_revisi->AdvancedSearch->toJson(), ","); // Field estetika_revisi
        $filterList = Concat($filterList, $this->aplikasiawal_opsi->AdvancedSearch->toJson(), ","); // Field aplikasiawal_opsi
        $filterList = Concat($filterList, $this->aplikasiawal_revisi->AdvancedSearch->toJson(), ","); // Field aplikasiawal_revisi
        $filterList = Concat($filterList, $this->aplikasilama_opsi->AdvancedSearch->toJson(), ","); // Field aplikasilama_opsi
        $filterList = Concat($filterList, $this->aplikasilama_revisi->AdvancedSearch->toJson(), ","); // Field aplikasilama_revisi
        $filterList = Concat($filterList, $this->efekpositif_opsi->AdvancedSearch->toJson(), ","); // Field efekpositif_opsi
        $filterList = Concat($filterList, $this->efekpositif_revisi->AdvancedSearch->toJson(), ","); // Field efekpositif_revisi
        $filterList = Concat($filterList, $this->efeknegatif_opsi->AdvancedSearch->toJson(), ","); // Field efeknegatif_opsi
        $filterList = Concat($filterList, $this->efeknegatif_revisi->AdvancedSearch->toJson(), ","); // Field efeknegatif_revisi
        $filterList = Concat($filterList, $this->kesimpulan->AdvancedSearch->toJson(), ","); // Field kesimpulan
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->created_at->AdvancedSearch->toJson(), ","); // Field created_at
        $filterList = Concat($filterList, $this->readonly->AdvancedSearch->toJson(), ","); // Field readonly
        $filterList = Concat($filterList, $this->ukuran->AdvancedSearch->toJson(), ","); // Field ukuran
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
            $UserProfile->setSearchFilters(CurrentUserName(), "fnpd_reviewlistsrch", $filters);
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

        // Field idnpd_sample
        $this->idnpd_sample->AdvancedSearch->SearchValue = @$filter["x_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchOperator = @$filter["z_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchCondition = @$filter["v_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchValue2 = @$filter["y_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->SearchOperator2 = @$filter["w_idnpd_sample"];
        $this->idnpd_sample->AdvancedSearch->save();

        // Field tanggal_review
        $this->tanggal_review->AdvancedSearch->SearchValue = @$filter["x_tanggal_review"];
        $this->tanggal_review->AdvancedSearch->SearchOperator = @$filter["z_tanggal_review"];
        $this->tanggal_review->AdvancedSearch->SearchCondition = @$filter["v_tanggal_review"];
        $this->tanggal_review->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_review"];
        $this->tanggal_review->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_review"];
        $this->tanggal_review->AdvancedSearch->save();

        // Field tanggal_submit
        $this->tanggal_submit->AdvancedSearch->SearchValue = @$filter["x_tanggal_submit"];
        $this->tanggal_submit->AdvancedSearch->SearchOperator = @$filter["z_tanggal_submit"];
        $this->tanggal_submit->AdvancedSearch->SearchCondition = @$filter["v_tanggal_submit"];
        $this->tanggal_submit->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_submit"];
        $this->tanggal_submit->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_submit"];
        $this->tanggal_submit->AdvancedSearch->save();

        // Field wadah
        $this->wadah->AdvancedSearch->SearchValue = @$filter["x_wadah"];
        $this->wadah->AdvancedSearch->SearchOperator = @$filter["z_wadah"];
        $this->wadah->AdvancedSearch->SearchCondition = @$filter["v_wadah"];
        $this->wadah->AdvancedSearch->SearchValue2 = @$filter["y_wadah"];
        $this->wadah->AdvancedSearch->SearchOperator2 = @$filter["w_wadah"];
        $this->wadah->AdvancedSearch->save();

        // Field bentuk_opsi
        $this->bentuk_opsi->AdvancedSearch->SearchValue = @$filter["x_bentuk_opsi"];
        $this->bentuk_opsi->AdvancedSearch->SearchOperator = @$filter["z_bentuk_opsi"];
        $this->bentuk_opsi->AdvancedSearch->SearchCondition = @$filter["v_bentuk_opsi"];
        $this->bentuk_opsi->AdvancedSearch->SearchValue2 = @$filter["y_bentuk_opsi"];
        $this->bentuk_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_bentuk_opsi"];
        $this->bentuk_opsi->AdvancedSearch->save();

        // Field bentuk_revisi
        $this->bentuk_revisi->AdvancedSearch->SearchValue = @$filter["x_bentuk_revisi"];
        $this->bentuk_revisi->AdvancedSearch->SearchOperator = @$filter["z_bentuk_revisi"];
        $this->bentuk_revisi->AdvancedSearch->SearchCondition = @$filter["v_bentuk_revisi"];
        $this->bentuk_revisi->AdvancedSearch->SearchValue2 = @$filter["y_bentuk_revisi"];
        $this->bentuk_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_bentuk_revisi"];
        $this->bentuk_revisi->AdvancedSearch->save();

        // Field viskositas_opsi
        $this->viskositas_opsi->AdvancedSearch->SearchValue = @$filter["x_viskositas_opsi"];
        $this->viskositas_opsi->AdvancedSearch->SearchOperator = @$filter["z_viskositas_opsi"];
        $this->viskositas_opsi->AdvancedSearch->SearchCondition = @$filter["v_viskositas_opsi"];
        $this->viskositas_opsi->AdvancedSearch->SearchValue2 = @$filter["y_viskositas_opsi"];
        $this->viskositas_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_viskositas_opsi"];
        $this->viskositas_opsi->AdvancedSearch->save();

        // Field viskositas_revisi
        $this->viskositas_revisi->AdvancedSearch->SearchValue = @$filter["x_viskositas_revisi"];
        $this->viskositas_revisi->AdvancedSearch->SearchOperator = @$filter["z_viskositas_revisi"];
        $this->viskositas_revisi->AdvancedSearch->SearchCondition = @$filter["v_viskositas_revisi"];
        $this->viskositas_revisi->AdvancedSearch->SearchValue2 = @$filter["y_viskositas_revisi"];
        $this->viskositas_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_viskositas_revisi"];
        $this->viskositas_revisi->AdvancedSearch->save();

        // Field jeniswarna_opsi
        $this->jeniswarna_opsi->AdvancedSearch->SearchValue = @$filter["x_jeniswarna_opsi"];
        $this->jeniswarna_opsi->AdvancedSearch->SearchOperator = @$filter["z_jeniswarna_opsi"];
        $this->jeniswarna_opsi->AdvancedSearch->SearchCondition = @$filter["v_jeniswarna_opsi"];
        $this->jeniswarna_opsi->AdvancedSearch->SearchValue2 = @$filter["y_jeniswarna_opsi"];
        $this->jeniswarna_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_jeniswarna_opsi"];
        $this->jeniswarna_opsi->AdvancedSearch->save();

        // Field jeniswarna_revisi
        $this->jeniswarna_revisi->AdvancedSearch->SearchValue = @$filter["x_jeniswarna_revisi"];
        $this->jeniswarna_revisi->AdvancedSearch->SearchOperator = @$filter["z_jeniswarna_revisi"];
        $this->jeniswarna_revisi->AdvancedSearch->SearchCondition = @$filter["v_jeniswarna_revisi"];
        $this->jeniswarna_revisi->AdvancedSearch->SearchValue2 = @$filter["y_jeniswarna_revisi"];
        $this->jeniswarna_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_jeniswarna_revisi"];
        $this->jeniswarna_revisi->AdvancedSearch->save();

        // Field tonewarna_opsi
        $this->tonewarna_opsi->AdvancedSearch->SearchValue = @$filter["x_tonewarna_opsi"];
        $this->tonewarna_opsi->AdvancedSearch->SearchOperator = @$filter["z_tonewarna_opsi"];
        $this->tonewarna_opsi->AdvancedSearch->SearchCondition = @$filter["v_tonewarna_opsi"];
        $this->tonewarna_opsi->AdvancedSearch->SearchValue2 = @$filter["y_tonewarna_opsi"];
        $this->tonewarna_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_tonewarna_opsi"];
        $this->tonewarna_opsi->AdvancedSearch->save();

        // Field tonewarna_revisi
        $this->tonewarna_revisi->AdvancedSearch->SearchValue = @$filter["x_tonewarna_revisi"];
        $this->tonewarna_revisi->AdvancedSearch->SearchOperator = @$filter["z_tonewarna_revisi"];
        $this->tonewarna_revisi->AdvancedSearch->SearchCondition = @$filter["v_tonewarna_revisi"];
        $this->tonewarna_revisi->AdvancedSearch->SearchValue2 = @$filter["y_tonewarna_revisi"];
        $this->tonewarna_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_tonewarna_revisi"];
        $this->tonewarna_revisi->AdvancedSearch->save();

        // Field gradasiwarna_opsi
        $this->gradasiwarna_opsi->AdvancedSearch->SearchValue = @$filter["x_gradasiwarna_opsi"];
        $this->gradasiwarna_opsi->AdvancedSearch->SearchOperator = @$filter["z_gradasiwarna_opsi"];
        $this->gradasiwarna_opsi->AdvancedSearch->SearchCondition = @$filter["v_gradasiwarna_opsi"];
        $this->gradasiwarna_opsi->AdvancedSearch->SearchValue2 = @$filter["y_gradasiwarna_opsi"];
        $this->gradasiwarna_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_gradasiwarna_opsi"];
        $this->gradasiwarna_opsi->AdvancedSearch->save();

        // Field gradasiwarna_revisi
        $this->gradasiwarna_revisi->AdvancedSearch->SearchValue = @$filter["x_gradasiwarna_revisi"];
        $this->gradasiwarna_revisi->AdvancedSearch->SearchOperator = @$filter["z_gradasiwarna_revisi"];
        $this->gradasiwarna_revisi->AdvancedSearch->SearchCondition = @$filter["v_gradasiwarna_revisi"];
        $this->gradasiwarna_revisi->AdvancedSearch->SearchValue2 = @$filter["y_gradasiwarna_revisi"];
        $this->gradasiwarna_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_gradasiwarna_revisi"];
        $this->gradasiwarna_revisi->AdvancedSearch->save();

        // Field bauparfum_opsi
        $this->bauparfum_opsi->AdvancedSearch->SearchValue = @$filter["x_bauparfum_opsi"];
        $this->bauparfum_opsi->AdvancedSearch->SearchOperator = @$filter["z_bauparfum_opsi"];
        $this->bauparfum_opsi->AdvancedSearch->SearchCondition = @$filter["v_bauparfum_opsi"];
        $this->bauparfum_opsi->AdvancedSearch->SearchValue2 = @$filter["y_bauparfum_opsi"];
        $this->bauparfum_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_bauparfum_opsi"];
        $this->bauparfum_opsi->AdvancedSearch->save();

        // Field bauparfum_revisi
        $this->bauparfum_revisi->AdvancedSearch->SearchValue = @$filter["x_bauparfum_revisi"];
        $this->bauparfum_revisi->AdvancedSearch->SearchOperator = @$filter["z_bauparfum_revisi"];
        $this->bauparfum_revisi->AdvancedSearch->SearchCondition = @$filter["v_bauparfum_revisi"];
        $this->bauparfum_revisi->AdvancedSearch->SearchValue2 = @$filter["y_bauparfum_revisi"];
        $this->bauparfum_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_bauparfum_revisi"];
        $this->bauparfum_revisi->AdvancedSearch->save();

        // Field estetika_opsi
        $this->estetika_opsi->AdvancedSearch->SearchValue = @$filter["x_estetika_opsi"];
        $this->estetika_opsi->AdvancedSearch->SearchOperator = @$filter["z_estetika_opsi"];
        $this->estetika_opsi->AdvancedSearch->SearchCondition = @$filter["v_estetika_opsi"];
        $this->estetika_opsi->AdvancedSearch->SearchValue2 = @$filter["y_estetika_opsi"];
        $this->estetika_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_estetika_opsi"];
        $this->estetika_opsi->AdvancedSearch->save();

        // Field estetika_revisi
        $this->estetika_revisi->AdvancedSearch->SearchValue = @$filter["x_estetika_revisi"];
        $this->estetika_revisi->AdvancedSearch->SearchOperator = @$filter["z_estetika_revisi"];
        $this->estetika_revisi->AdvancedSearch->SearchCondition = @$filter["v_estetika_revisi"];
        $this->estetika_revisi->AdvancedSearch->SearchValue2 = @$filter["y_estetika_revisi"];
        $this->estetika_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_estetika_revisi"];
        $this->estetika_revisi->AdvancedSearch->save();

        // Field aplikasiawal_opsi
        $this->aplikasiawal_opsi->AdvancedSearch->SearchValue = @$filter["x_aplikasiawal_opsi"];
        $this->aplikasiawal_opsi->AdvancedSearch->SearchOperator = @$filter["z_aplikasiawal_opsi"];
        $this->aplikasiawal_opsi->AdvancedSearch->SearchCondition = @$filter["v_aplikasiawal_opsi"];
        $this->aplikasiawal_opsi->AdvancedSearch->SearchValue2 = @$filter["y_aplikasiawal_opsi"];
        $this->aplikasiawal_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_aplikasiawal_opsi"];
        $this->aplikasiawal_opsi->AdvancedSearch->save();

        // Field aplikasiawal_revisi
        $this->aplikasiawal_revisi->AdvancedSearch->SearchValue = @$filter["x_aplikasiawal_revisi"];
        $this->aplikasiawal_revisi->AdvancedSearch->SearchOperator = @$filter["z_aplikasiawal_revisi"];
        $this->aplikasiawal_revisi->AdvancedSearch->SearchCondition = @$filter["v_aplikasiawal_revisi"];
        $this->aplikasiawal_revisi->AdvancedSearch->SearchValue2 = @$filter["y_aplikasiawal_revisi"];
        $this->aplikasiawal_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_aplikasiawal_revisi"];
        $this->aplikasiawal_revisi->AdvancedSearch->save();

        // Field aplikasilama_opsi
        $this->aplikasilama_opsi->AdvancedSearch->SearchValue = @$filter["x_aplikasilama_opsi"];
        $this->aplikasilama_opsi->AdvancedSearch->SearchOperator = @$filter["z_aplikasilama_opsi"];
        $this->aplikasilama_opsi->AdvancedSearch->SearchCondition = @$filter["v_aplikasilama_opsi"];
        $this->aplikasilama_opsi->AdvancedSearch->SearchValue2 = @$filter["y_aplikasilama_opsi"];
        $this->aplikasilama_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_aplikasilama_opsi"];
        $this->aplikasilama_opsi->AdvancedSearch->save();

        // Field aplikasilama_revisi
        $this->aplikasilama_revisi->AdvancedSearch->SearchValue = @$filter["x_aplikasilama_revisi"];
        $this->aplikasilama_revisi->AdvancedSearch->SearchOperator = @$filter["z_aplikasilama_revisi"];
        $this->aplikasilama_revisi->AdvancedSearch->SearchCondition = @$filter["v_aplikasilama_revisi"];
        $this->aplikasilama_revisi->AdvancedSearch->SearchValue2 = @$filter["y_aplikasilama_revisi"];
        $this->aplikasilama_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_aplikasilama_revisi"];
        $this->aplikasilama_revisi->AdvancedSearch->save();

        // Field efekpositif_opsi
        $this->efekpositif_opsi->AdvancedSearch->SearchValue = @$filter["x_efekpositif_opsi"];
        $this->efekpositif_opsi->AdvancedSearch->SearchOperator = @$filter["z_efekpositif_opsi"];
        $this->efekpositif_opsi->AdvancedSearch->SearchCondition = @$filter["v_efekpositif_opsi"];
        $this->efekpositif_opsi->AdvancedSearch->SearchValue2 = @$filter["y_efekpositif_opsi"];
        $this->efekpositif_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_efekpositif_opsi"];
        $this->efekpositif_opsi->AdvancedSearch->save();

        // Field efekpositif_revisi
        $this->efekpositif_revisi->AdvancedSearch->SearchValue = @$filter["x_efekpositif_revisi"];
        $this->efekpositif_revisi->AdvancedSearch->SearchOperator = @$filter["z_efekpositif_revisi"];
        $this->efekpositif_revisi->AdvancedSearch->SearchCondition = @$filter["v_efekpositif_revisi"];
        $this->efekpositif_revisi->AdvancedSearch->SearchValue2 = @$filter["y_efekpositif_revisi"];
        $this->efekpositif_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_efekpositif_revisi"];
        $this->efekpositif_revisi->AdvancedSearch->save();

        // Field efeknegatif_opsi
        $this->efeknegatif_opsi->AdvancedSearch->SearchValue = @$filter["x_efeknegatif_opsi"];
        $this->efeknegatif_opsi->AdvancedSearch->SearchOperator = @$filter["z_efeknegatif_opsi"];
        $this->efeknegatif_opsi->AdvancedSearch->SearchCondition = @$filter["v_efeknegatif_opsi"];
        $this->efeknegatif_opsi->AdvancedSearch->SearchValue2 = @$filter["y_efeknegatif_opsi"];
        $this->efeknegatif_opsi->AdvancedSearch->SearchOperator2 = @$filter["w_efeknegatif_opsi"];
        $this->efeknegatif_opsi->AdvancedSearch->save();

        // Field efeknegatif_revisi
        $this->efeknegatif_revisi->AdvancedSearch->SearchValue = @$filter["x_efeknegatif_revisi"];
        $this->efeknegatif_revisi->AdvancedSearch->SearchOperator = @$filter["z_efeknegatif_revisi"];
        $this->efeknegatif_revisi->AdvancedSearch->SearchCondition = @$filter["v_efeknegatif_revisi"];
        $this->efeknegatif_revisi->AdvancedSearch->SearchValue2 = @$filter["y_efeknegatif_revisi"];
        $this->efeknegatif_revisi->AdvancedSearch->SearchOperator2 = @$filter["w_efeknegatif_revisi"];
        $this->efeknegatif_revisi->AdvancedSearch->save();

        // Field kesimpulan
        $this->kesimpulan->AdvancedSearch->SearchValue = @$filter["x_kesimpulan"];
        $this->kesimpulan->AdvancedSearch->SearchOperator = @$filter["z_kesimpulan"];
        $this->kesimpulan->AdvancedSearch->SearchCondition = @$filter["v_kesimpulan"];
        $this->kesimpulan->AdvancedSearch->SearchValue2 = @$filter["y_kesimpulan"];
        $this->kesimpulan->AdvancedSearch->SearchOperator2 = @$filter["w_kesimpulan"];
        $this->kesimpulan->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

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

        // Field ukuran
        $this->ukuran->AdvancedSearch->SearchValue = @$filter["x_ukuran"];
        $this->ukuran->AdvancedSearch->SearchOperator = @$filter["z_ukuran"];
        $this->ukuran->AdvancedSearch->SearchCondition = @$filter["v_ukuran"];
        $this->ukuran->AdvancedSearch->SearchValue2 = @$filter["y_ukuran"];
        $this->ukuran->AdvancedSearch->SearchOperator2 = @$filter["w_ukuran"];
        $this->ukuran->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->wadah, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bentuk_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->viskositas_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jeniswarna_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tonewarna_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->gradasiwarna_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bauparfum_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->estetika_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->aplikasiawal_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->aplikasilama_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->efekpositif_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->efeknegatif_revisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kesimpulan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuran, $arKeywords, $type);
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
            $this->updateSort($this->idnpd_sample); // idnpd_sample
            $this->updateSort($this->tanggal_review); // tanggal_review
            $this->updateSort($this->tanggal_submit); // tanggal_submit
            $this->updateSort($this->status); // status
            $this->updateSort($this->ukuran); // ukuran
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
                $this->idnpd_sample->setSort("");
                $this->tanggal_review->setSort("");
                $this->tanggal_submit->setSort("");
                $this->wadah->setSort("");
                $this->bentuk_opsi->setSort("");
                $this->bentuk_revisi->setSort("");
                $this->viskositas_opsi->setSort("");
                $this->viskositas_revisi->setSort("");
                $this->jeniswarna_opsi->setSort("");
                $this->jeniswarna_revisi->setSort("");
                $this->tonewarna_opsi->setSort("");
                $this->tonewarna_revisi->setSort("");
                $this->gradasiwarna_opsi->setSort("");
                $this->gradasiwarna_revisi->setSort("");
                $this->bauparfum_opsi->setSort("");
                $this->bauparfum_revisi->setSort("");
                $this->estetika_opsi->setSort("");
                $this->estetika_revisi->setSort("");
                $this->aplikasiawal_opsi->setSort("");
                $this->aplikasiawal_revisi->setSort("");
                $this->aplikasilama_opsi->setSort("");
                $this->aplikasilama_revisi->setSort("");
                $this->efekpositif_opsi->setSort("");
                $this->efekpositif_revisi->setSort("");
                $this->efeknegatif_opsi->setSort("");
                $this->efeknegatif_revisi->setSort("");
                $this->kesimpulan->setSort("");
                $this->status->setSort("");
                $this->created_at->setSort("");
                $this->readonly->setSort("");
                $this->ukuran->setSort("");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fnpd_reviewlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fnpd_reviewlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fnpd_reviewlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->tanggal_review->setDbValue($row['tanggal_review']);
        $this->tanggal_submit->setDbValue($row['tanggal_submit']);
        $this->wadah->setDbValue($row['wadah']);
        $this->bentuk_opsi->setDbValue($row['bentuk_opsi']);
        $this->bentuk_revisi->setDbValue($row['bentuk_revisi']);
        $this->viskositas_opsi->setDbValue($row['viskositas_opsi']);
        $this->viskositas_revisi->setDbValue($row['viskositas_revisi']);
        $this->jeniswarna_opsi->setDbValue($row['jeniswarna_opsi']);
        $this->jeniswarna_revisi->setDbValue($row['jeniswarna_revisi']);
        $this->tonewarna_opsi->setDbValue($row['tonewarna_opsi']);
        $this->tonewarna_revisi->setDbValue($row['tonewarna_revisi']);
        $this->gradasiwarna_opsi->setDbValue($row['gradasiwarna_opsi']);
        $this->gradasiwarna_revisi->setDbValue($row['gradasiwarna_revisi']);
        $this->bauparfum_opsi->setDbValue($row['bauparfum_opsi']);
        $this->bauparfum_revisi->setDbValue($row['bauparfum_revisi']);
        $this->estetika_opsi->setDbValue($row['estetika_opsi']);
        $this->estetika_revisi->setDbValue($row['estetika_revisi']);
        $this->aplikasiawal_opsi->setDbValue($row['aplikasiawal_opsi']);
        $this->aplikasiawal_revisi->setDbValue($row['aplikasiawal_revisi']);
        $this->aplikasilama_opsi->setDbValue($row['aplikasilama_opsi']);
        $this->aplikasilama_revisi->setDbValue($row['aplikasilama_revisi']);
        $this->efekpositif_opsi->setDbValue($row['efekpositif_opsi']);
        $this->efekpositif_revisi->setDbValue($row['efekpositif_revisi']);
        $this->efeknegatif_opsi->setDbValue($row['efeknegatif_opsi']);
        $this->efeknegatif_revisi->setDbValue($row['efeknegatif_revisi']);
        $this->kesimpulan->setDbValue($row['kesimpulan']);
        $this->status->setDbValue($row['status']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->ukuran->setDbValue($row['ukuran']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['idnpd_sample'] = null;
        $row['tanggal_review'] = null;
        $row['tanggal_submit'] = null;
        $row['wadah'] = null;
        $row['bentuk_opsi'] = null;
        $row['bentuk_revisi'] = null;
        $row['viskositas_opsi'] = null;
        $row['viskositas_revisi'] = null;
        $row['jeniswarna_opsi'] = null;
        $row['jeniswarna_revisi'] = null;
        $row['tonewarna_opsi'] = null;
        $row['tonewarna_revisi'] = null;
        $row['gradasiwarna_opsi'] = null;
        $row['gradasiwarna_revisi'] = null;
        $row['bauparfum_opsi'] = null;
        $row['bauparfum_revisi'] = null;
        $row['estetika_opsi'] = null;
        $row['estetika_revisi'] = null;
        $row['aplikasiawal_opsi'] = null;
        $row['aplikasiawal_revisi'] = null;
        $row['aplikasilama_opsi'] = null;
        $row['aplikasilama_revisi'] = null;
        $row['efekpositif_opsi'] = null;
        $row['efekpositif_revisi'] = null;
        $row['efeknegatif_opsi'] = null;
        $row['efeknegatif_revisi'] = null;
        $row['kesimpulan'] = null;
        $row['status'] = null;
        $row['created_at'] = null;
        $row['readonly'] = null;
        $row['ukuran'] = null;
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

        // idnpd_sample

        // tanggal_review

        // tanggal_submit

        // wadah

        // bentuk_opsi

        // bentuk_revisi

        // viskositas_opsi

        // viskositas_revisi

        // jeniswarna_opsi

        // jeniswarna_revisi

        // tonewarna_opsi

        // tonewarna_revisi

        // gradasiwarna_opsi

        // gradasiwarna_revisi

        // bauparfum_opsi

        // bauparfum_revisi

        // estetika_opsi

        // estetika_revisi

        // aplikasiawal_opsi

        // aplikasiawal_revisi

        // aplikasilama_opsi

        // aplikasilama_revisi

        // efekpositif_opsi

        // efekpositif_revisi

        // efeknegatif_opsi

        // efeknegatif_revisi

        // kesimpulan

        // status

        // created_at

        // readonly

        // ukuran
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
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

            // idnpd_sample
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
                if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return CurrentPageID() == "add" ? "`status`=0" : "";
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

            // tanggal_review
            $this->tanggal_review->ViewValue = $this->tanggal_review->CurrentValue;
            $this->tanggal_review->ViewValue = FormatDateTime($this->tanggal_review->ViewValue, 0);
            $this->tanggal_review->ViewCustomAttributes = "";

            // tanggal_submit
            $this->tanggal_submit->ViewValue = $this->tanggal_submit->CurrentValue;
            $this->tanggal_submit->ViewValue = FormatDateTime($this->tanggal_submit->ViewValue, 0);
            $this->tanggal_submit->ViewCustomAttributes = "";

            // wadah
            $this->wadah->ViewValue = $this->wadah->CurrentValue;
            $this->wadah->ViewCustomAttributes = "";

            // bentuk_opsi
            if (strval($this->bentuk_opsi->CurrentValue) != "") {
                $this->bentuk_opsi->ViewValue = $this->bentuk_opsi->optionCaption($this->bentuk_opsi->CurrentValue);
            } else {
                $this->bentuk_opsi->ViewValue = null;
            }
            $this->bentuk_opsi->ViewCustomAttributes = "";

            // bentuk_revisi
            $this->bentuk_revisi->ViewValue = $this->bentuk_revisi->CurrentValue;
            $this->bentuk_revisi->ViewCustomAttributes = "";

            // viskositas_opsi
            if (strval($this->viskositas_opsi->CurrentValue) != "") {
                $this->viskositas_opsi->ViewValue = $this->viskositas_opsi->optionCaption($this->viskositas_opsi->CurrentValue);
            } else {
                $this->viskositas_opsi->ViewValue = null;
            }
            $this->viskositas_opsi->ViewCustomAttributes = "";

            // viskositas_revisi
            $this->viskositas_revisi->ViewValue = $this->viskositas_revisi->CurrentValue;
            $this->viskositas_revisi->ViewCustomAttributes = "";

            // jeniswarna_opsi
            if (strval($this->jeniswarna_opsi->CurrentValue) != "") {
                $this->jeniswarna_opsi->ViewValue = $this->jeniswarna_opsi->optionCaption($this->jeniswarna_opsi->CurrentValue);
            } else {
                $this->jeniswarna_opsi->ViewValue = null;
            }
            $this->jeniswarna_opsi->ViewCustomAttributes = "";

            // jeniswarna_revisi
            $this->jeniswarna_revisi->ViewValue = $this->jeniswarna_revisi->CurrentValue;
            $this->jeniswarna_revisi->ViewCustomAttributes = "";

            // tonewarna_opsi
            if (strval($this->tonewarna_opsi->CurrentValue) != "") {
                $this->tonewarna_opsi->ViewValue = $this->tonewarna_opsi->optionCaption($this->tonewarna_opsi->CurrentValue);
            } else {
                $this->tonewarna_opsi->ViewValue = null;
            }
            $this->tonewarna_opsi->ViewCustomAttributes = "";

            // tonewarna_revisi
            $this->tonewarna_revisi->ViewValue = $this->tonewarna_revisi->CurrentValue;
            $this->tonewarna_revisi->ViewCustomAttributes = "";

            // gradasiwarna_opsi
            if (strval($this->gradasiwarna_opsi->CurrentValue) != "") {
                $this->gradasiwarna_opsi->ViewValue = $this->gradasiwarna_opsi->optionCaption($this->gradasiwarna_opsi->CurrentValue);
            } else {
                $this->gradasiwarna_opsi->ViewValue = null;
            }
            $this->gradasiwarna_opsi->ViewCustomAttributes = "";

            // gradasiwarna_revisi
            $this->gradasiwarna_revisi->ViewValue = $this->gradasiwarna_revisi->CurrentValue;
            $this->gradasiwarna_revisi->ViewCustomAttributes = "";

            // bauparfum_opsi
            if (strval($this->bauparfum_opsi->CurrentValue) != "") {
                $this->bauparfum_opsi->ViewValue = $this->bauparfum_opsi->optionCaption($this->bauparfum_opsi->CurrentValue);
            } else {
                $this->bauparfum_opsi->ViewValue = null;
            }
            $this->bauparfum_opsi->ViewCustomAttributes = "";

            // bauparfum_revisi
            $this->bauparfum_revisi->ViewValue = $this->bauparfum_revisi->CurrentValue;
            $this->bauparfum_revisi->ViewCustomAttributes = "";

            // estetika_opsi
            if (strval($this->estetika_opsi->CurrentValue) != "") {
                $this->estetika_opsi->ViewValue = $this->estetika_opsi->optionCaption($this->estetika_opsi->CurrentValue);
            } else {
                $this->estetika_opsi->ViewValue = null;
            }
            $this->estetika_opsi->ViewCustomAttributes = "";

            // estetika_revisi
            $this->estetika_revisi->ViewValue = $this->estetika_revisi->CurrentValue;
            $this->estetika_revisi->ViewCustomAttributes = "";

            // aplikasiawal_opsi
            if (strval($this->aplikasiawal_opsi->CurrentValue) != "") {
                $this->aplikasiawal_opsi->ViewValue = $this->aplikasiawal_opsi->optionCaption($this->aplikasiawal_opsi->CurrentValue);
            } else {
                $this->aplikasiawal_opsi->ViewValue = null;
            }
            $this->aplikasiawal_opsi->ViewCustomAttributes = "";

            // aplikasiawal_revisi
            $this->aplikasiawal_revisi->ViewValue = $this->aplikasiawal_revisi->CurrentValue;
            $this->aplikasiawal_revisi->ViewCustomAttributes = "";

            // aplikasilama_opsi
            if (strval($this->aplikasilama_opsi->CurrentValue) != "") {
                $this->aplikasilama_opsi->ViewValue = $this->aplikasilama_opsi->optionCaption($this->aplikasilama_opsi->CurrentValue);
            } else {
                $this->aplikasilama_opsi->ViewValue = null;
            }
            $this->aplikasilama_opsi->ViewCustomAttributes = "";

            // aplikasilama_revisi
            $this->aplikasilama_revisi->ViewValue = $this->aplikasilama_revisi->CurrentValue;
            $this->aplikasilama_revisi->ViewCustomAttributes = "";

            // efekpositif_opsi
            if (strval($this->efekpositif_opsi->CurrentValue) != "") {
                $this->efekpositif_opsi->ViewValue = $this->efekpositif_opsi->optionCaption($this->efekpositif_opsi->CurrentValue);
            } else {
                $this->efekpositif_opsi->ViewValue = null;
            }
            $this->efekpositif_opsi->ViewCustomAttributes = "";

            // efekpositif_revisi
            $this->efekpositif_revisi->ViewValue = $this->efekpositif_revisi->CurrentValue;
            $this->efekpositif_revisi->ViewCustomAttributes = "";

            // efeknegatif_opsi
            if (strval($this->efeknegatif_opsi->CurrentValue) != "") {
                $this->efeknegatif_opsi->ViewValue = $this->efeknegatif_opsi->optionCaption($this->efeknegatif_opsi->CurrentValue);
            } else {
                $this->efeknegatif_opsi->ViewValue = null;
            }
            $this->efeknegatif_opsi->ViewCustomAttributes = "";

            // efeknegatif_revisi
            $this->efeknegatif_revisi->ViewValue = $this->efeknegatif_revisi->CurrentValue;
            $this->efeknegatif_revisi->ViewCustomAttributes = "";

            // kesimpulan
            $this->kesimpulan->ViewValue = $this->kesimpulan->CurrentValue;
            $this->kesimpulan->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

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

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // tanggal_review
            $this->tanggal_review->LinkCustomAttributes = "";
            $this->tanggal_review->HrefValue = "";
            $this->tanggal_review->TooltipValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";
            $this->tanggal_submit->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fnpd_reviewlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "`status`=0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_bentuk_opsi":
                    break;
                case "x_viskositas_opsi":
                    break;
                case "x_jeniswarna_opsi":
                    break;
                case "x_tonewarna_opsi":
                    break;
                case "x_gradasiwarna_opsi":
                    break;
                case "x_bauparfum_opsi":
                    break;
                case "x_estetika_opsi":
                    break;
                case "x_aplikasiawal_opsi":
                    break;
                case "x_aplikasilama_opsi":
                    break;
                case "x_efekpositif_opsi":
                    break;
                case "x_efeknegatif_opsi":
                    break;
                case "x_status":
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
