<?php

namespace PHPMaker2021\production2;

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
        $this->idpegawai->Visible = false;
        $this->idcustomer->setVisibility();
        $this->idbrand->Visible = false;
        $this->tanggal_order->setVisibility();
        $this->target_selesai->Visible = false;
        $this->sifatorder->setVisibility();
        $this->kodeorder->setVisibility();
        $this->nomororder->Visible = false;
        $this->idproduct_acuan->Visible = false;
        $this->kategoriproduk->setVisibility();
        $this->jenisproduk->setVisibility();
        $this->fungsiproduk->Visible = false;
        $this->kualitasproduk->Visible = false;
        $this->bahan_campaign->Visible = false;
        $this->ukuransediaan->Visible = false;
        $this->satuansediaan->Visible = false;
        $this->bentuk->Visible = false;
        $this->viskositas->Visible = false;
        $this->warna->Visible = false;
        $this->parfum->Visible = false;
        $this->aplikasi->Visible = false;
        $this->estetika->Visible = false;
        $this->tambahan->Visible = false;
        $this->ukurankemasan->Visible = false;
        $this->satuankemasan->Visible = false;
        $this->kemasanwadah->Visible = false;
        $this->kemasantutup->Visible = false;
        $this->kemasancatatan->Visible = false;
        $this->ukurankemasansekunder->Visible = false;
        $this->satuankemasansekunder->Visible = false;
        $this->kemasanbahan->Visible = false;
        $this->kemasanbentuk->Visible = false;
        $this->kemasankomposisi->Visible = false;
        $this->kemasancatatansekunder->Visible = false;
        $this->labelbahan->Visible = false;
        $this->labelkualitas->Visible = false;
        $this->labelposisi->Visible = false;
        $this->labelcatatan->Visible = false;
        $this->labeltekstur->Visible = false;
        $this->labelprint->Visible = false;
        $this->labeljmlwarna->Visible = false;
        $this->labelcatatanhotprint->Visible = false;
        $this->ukuran_utama->Visible = false;
        $this->utama_harga_isi->Visible = false;
        $this->utama_harga_isi_proyeksi->Visible = false;
        $this->utama_harga_primer->Visible = false;
        $this->utama_harga_primer_proyeksi->Visible = false;
        $this->utama_harga_sekunder->Visible = false;
        $this->utama_harga_sekunder_proyeksi->Visible = false;
        $this->utama_harga_label->Visible = false;
        $this->utama_harga_label_proyeksi->Visible = false;
        $this->utama_harga_total->Visible = false;
        $this->utama_harga_total_proyeksi->Visible = false;
        $this->ukuran_lain->Visible = false;
        $this->lain_harga_isi->Visible = false;
        $this->lain_harga_isi_proyeksi->Visible = false;
        $this->lain_harga_primer->Visible = false;
        $this->lain_harga_primer_proyeksi->Visible = false;
        $this->lain_harga_sekunder->Visible = false;
        $this->lain_harga_sekunder_proyeksi->Visible = false;
        $this->lain_harga_label->Visible = false;
        $this->lain_harga_label_proyeksi->Visible = false;
        $this->lain_harga_total->Visible = false;
        $this->lain_harga_total_proyeksi->Visible = false;
        $this->delivery_pickup->Visible = false;
        $this->delivery_singlepoint->Visible = false;
        $this->delivery_multipoint->Visible = false;
        $this->delivery_termlain->Visible = false;
        $this->status->setVisibility();
        $this->readonly->Visible = false;
        $this->receipt_by->Visible = false;
        $this->approve_by->Visible = false;
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->selesai->Visible = false;
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
        $this->setupLookupOptions($this->idbrand);
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->kategoriproduk);
        $this->setupLookupOptions($this->jenisproduk);
        $this->setupLookupOptions($this->satuansediaan);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->parfum);
        $this->setupLookupOptions($this->aplikasi);
        $this->setupLookupOptions($this->estetika);
        $this->setupLookupOptions($this->satuankemasan);
        $this->setupLookupOptions($this->kemasanwadah);
        $this->setupLookupOptions($this->kemasantutup);
        $this->setupLookupOptions($this->satuankemasansekunder);
        $this->setupLookupOptions($this->kemasanbahan);
        $this->setupLookupOptions($this->kemasanbentuk);
        $this->setupLookupOptions($this->kemasankomposisi);
        $this->setupLookupOptions($this->labelbahan);
        $this->setupLookupOptions($this->labelkualitas);
        $this->setupLookupOptions($this->labelposisi);
        $this->setupLookupOptions($this->labeltekstur);
        $this->setupLookupOptions($this->labelprint);
        $this->setupLookupOptions($this->approve_by);

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
        $filterList = Concat($filterList, $this->idpegawai->AdvancedSearch->toJson(), ","); // Field idpegawai
        $filterList = Concat($filterList, $this->idcustomer->AdvancedSearch->toJson(), ","); // Field idcustomer
        $filterList = Concat($filterList, $this->idbrand->AdvancedSearch->toJson(), ","); // Field idbrand
        $filterList = Concat($filterList, $this->tanggal_order->AdvancedSearch->toJson(), ","); // Field tanggal_order
        $filterList = Concat($filterList, $this->target_selesai->AdvancedSearch->toJson(), ","); // Field target_selesai
        $filterList = Concat($filterList, $this->sifatorder->AdvancedSearch->toJson(), ","); // Field sifatorder
        $filterList = Concat($filterList, $this->kodeorder->AdvancedSearch->toJson(), ","); // Field kodeorder
        $filterList = Concat($filterList, $this->nomororder->AdvancedSearch->toJson(), ","); // Field nomororder
        $filterList = Concat($filterList, $this->kategoriproduk->AdvancedSearch->toJson(), ","); // Field kategoriproduk
        $filterList = Concat($filterList, $this->jenisproduk->AdvancedSearch->toJson(), ","); // Field jenisproduk
        $filterList = Concat($filterList, $this->fungsiproduk->AdvancedSearch->toJson(), ","); // Field fungsiproduk
        $filterList = Concat($filterList, $this->kualitasproduk->AdvancedSearch->toJson(), ","); // Field kualitasproduk
        $filterList = Concat($filterList, $this->bahan_campaign->AdvancedSearch->toJson(), ","); // Field bahan_campaign
        $filterList = Concat($filterList, $this->ukuransediaan->AdvancedSearch->toJson(), ","); // Field ukuransediaan
        $filterList = Concat($filterList, $this->satuansediaan->AdvancedSearch->toJson(), ","); // Field satuansediaan
        $filterList = Concat($filterList, $this->bentuk->AdvancedSearch->toJson(), ","); // Field bentuk
        $filterList = Concat($filterList, $this->viskositas->AdvancedSearch->toJson(), ","); // Field viskositas
        $filterList = Concat($filterList, $this->warna->AdvancedSearch->toJson(), ","); // Field warna
        $filterList = Concat($filterList, $this->parfum->AdvancedSearch->toJson(), ","); // Field parfum
        $filterList = Concat($filterList, $this->aplikasi->AdvancedSearch->toJson(), ","); // Field aplikasi
        $filterList = Concat($filterList, $this->estetika->AdvancedSearch->toJson(), ","); // Field estetika
        $filterList = Concat($filterList, $this->tambahan->AdvancedSearch->toJson(), ","); // Field tambahan
        $filterList = Concat($filterList, $this->ukurankemasan->AdvancedSearch->toJson(), ","); // Field ukurankemasan
        $filterList = Concat($filterList, $this->satuankemasan->AdvancedSearch->toJson(), ","); // Field satuankemasan
        $filterList = Concat($filterList, $this->kemasanwadah->AdvancedSearch->toJson(), ","); // Field kemasanwadah
        $filterList = Concat($filterList, $this->kemasantutup->AdvancedSearch->toJson(), ","); // Field kemasantutup
        $filterList = Concat($filterList, $this->kemasancatatan->AdvancedSearch->toJson(), ","); // Field kemasancatatan
        $filterList = Concat($filterList, $this->ukurankemasansekunder->AdvancedSearch->toJson(), ","); // Field ukurankemasansekunder
        $filterList = Concat($filterList, $this->satuankemasansekunder->AdvancedSearch->toJson(), ","); // Field satuankemasansekunder
        $filterList = Concat($filterList, $this->kemasanbahan->AdvancedSearch->toJson(), ","); // Field kemasanbahan
        $filterList = Concat($filterList, $this->kemasanbentuk->AdvancedSearch->toJson(), ","); // Field kemasanbentuk
        $filterList = Concat($filterList, $this->kemasankomposisi->AdvancedSearch->toJson(), ","); // Field kemasankomposisi
        $filterList = Concat($filterList, $this->kemasancatatansekunder->AdvancedSearch->toJson(), ","); // Field kemasancatatansekunder
        $filterList = Concat($filterList, $this->labelbahan->AdvancedSearch->toJson(), ","); // Field labelbahan
        $filterList = Concat($filterList, $this->labelkualitas->AdvancedSearch->toJson(), ","); // Field labelkualitas
        $filterList = Concat($filterList, $this->labelposisi->AdvancedSearch->toJson(), ","); // Field labelposisi
        $filterList = Concat($filterList, $this->labelcatatan->AdvancedSearch->toJson(), ","); // Field labelcatatan
        $filterList = Concat($filterList, $this->labeltekstur->AdvancedSearch->toJson(), ","); // Field labeltekstur
        $filterList = Concat($filterList, $this->labelprint->AdvancedSearch->toJson(), ","); // Field labelprint
        $filterList = Concat($filterList, $this->labeljmlwarna->AdvancedSearch->toJson(), ","); // Field labeljmlwarna
        $filterList = Concat($filterList, $this->labelcatatanhotprint->AdvancedSearch->toJson(), ","); // Field labelcatatanhotprint
        $filterList = Concat($filterList, $this->ukuran_utama->AdvancedSearch->toJson(), ","); // Field ukuran_utama
        $filterList = Concat($filterList, $this->utama_harga_isi->AdvancedSearch->toJson(), ","); // Field utama_harga_isi
        $filterList = Concat($filterList, $this->utama_harga_isi_proyeksi->AdvancedSearch->toJson(), ","); // Field utama_harga_isi_proyeksi
        $filterList = Concat($filterList, $this->utama_harga_primer->AdvancedSearch->toJson(), ","); // Field utama_harga_primer
        $filterList = Concat($filterList, $this->utama_harga_primer_proyeksi->AdvancedSearch->toJson(), ","); // Field utama_harga_primer_proyeksi
        $filterList = Concat($filterList, $this->utama_harga_sekunder->AdvancedSearch->toJson(), ","); // Field utama_harga_sekunder
        $filterList = Concat($filterList, $this->utama_harga_sekunder_proyeksi->AdvancedSearch->toJson(), ","); // Field utama_harga_sekunder_proyeksi
        $filterList = Concat($filterList, $this->utama_harga_label->AdvancedSearch->toJson(), ","); // Field utama_harga_label
        $filterList = Concat($filterList, $this->utama_harga_label_proyeksi->AdvancedSearch->toJson(), ","); // Field utama_harga_label_proyeksi
        $filterList = Concat($filterList, $this->utama_harga_total->AdvancedSearch->toJson(), ","); // Field utama_harga_total
        $filterList = Concat($filterList, $this->utama_harga_total_proyeksi->AdvancedSearch->toJson(), ","); // Field utama_harga_total_proyeksi
        $filterList = Concat($filterList, $this->ukuran_lain->AdvancedSearch->toJson(), ","); // Field ukuran_lain
        $filterList = Concat($filterList, $this->lain_harga_isi->AdvancedSearch->toJson(), ","); // Field lain_harga_isi
        $filterList = Concat($filterList, $this->lain_harga_isi_proyeksi->AdvancedSearch->toJson(), ","); // Field lain_harga_isi_proyeksi
        $filterList = Concat($filterList, $this->lain_harga_primer->AdvancedSearch->toJson(), ","); // Field lain_harga_primer
        $filterList = Concat($filterList, $this->lain_harga_primer_proyeksi->AdvancedSearch->toJson(), ","); // Field lain_harga_primer_proyeksi
        $filterList = Concat($filterList, $this->lain_harga_sekunder->AdvancedSearch->toJson(), ","); // Field lain_harga_sekunder
        $filterList = Concat($filterList, $this->lain_harga_sekunder_proyeksi->AdvancedSearch->toJson(), ","); // Field lain_harga_sekunder_proyeksi
        $filterList = Concat($filterList, $this->lain_harga_label->AdvancedSearch->toJson(), ","); // Field lain_harga_label
        $filterList = Concat($filterList, $this->lain_harga_label_proyeksi->AdvancedSearch->toJson(), ","); // Field lain_harga_label_proyeksi
        $filterList = Concat($filterList, $this->lain_harga_total->AdvancedSearch->toJson(), ","); // Field lain_harga_total
        $filterList = Concat($filterList, $this->lain_harga_total_proyeksi->AdvancedSearch->toJson(), ","); // Field lain_harga_total_proyeksi
        $filterList = Concat($filterList, $this->delivery_pickup->AdvancedSearch->toJson(), ","); // Field delivery_pickup
        $filterList = Concat($filterList, $this->delivery_singlepoint->AdvancedSearch->toJson(), ","); // Field delivery_singlepoint
        $filterList = Concat($filterList, $this->delivery_multipoint->AdvancedSearch->toJson(), ","); // Field delivery_multipoint
        $filterList = Concat($filterList, $this->delivery_termlain->AdvancedSearch->toJson(), ","); // Field delivery_termlain
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->readonly->AdvancedSearch->toJson(), ","); // Field readonly
        $filterList = Concat($filterList, $this->receipt_by->AdvancedSearch->toJson(), ","); // Field receipt_by
        $filterList = Concat($filterList, $this->approve_by->AdvancedSearch->toJson(), ","); // Field approve_by
        $filterList = Concat($filterList, $this->created_at->AdvancedSearch->toJson(), ","); // Field created_at
        $filterList = Concat($filterList, $this->updated_at->AdvancedSearch->toJson(), ","); // Field updated_at
        $filterList = Concat($filterList, $this->selesai->AdvancedSearch->toJson(), ","); // Field selesai
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

        // Field idbrand
        $this->idbrand->AdvancedSearch->SearchValue = @$filter["x_idbrand"];
        $this->idbrand->AdvancedSearch->SearchOperator = @$filter["z_idbrand"];
        $this->idbrand->AdvancedSearch->SearchCondition = @$filter["v_idbrand"];
        $this->idbrand->AdvancedSearch->SearchValue2 = @$filter["y_idbrand"];
        $this->idbrand->AdvancedSearch->SearchOperator2 = @$filter["w_idbrand"];
        $this->idbrand->AdvancedSearch->save();

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

        // Field sifatorder
        $this->sifatorder->AdvancedSearch->SearchValue = @$filter["x_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchOperator = @$filter["z_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchCondition = @$filter["v_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchValue2 = @$filter["y_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchOperator2 = @$filter["w_sifatorder"];
        $this->sifatorder->AdvancedSearch->save();

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

        // Field kategoriproduk
        $this->kategoriproduk->AdvancedSearch->SearchValue = @$filter["x_kategoriproduk"];
        $this->kategoriproduk->AdvancedSearch->SearchOperator = @$filter["z_kategoriproduk"];
        $this->kategoriproduk->AdvancedSearch->SearchCondition = @$filter["v_kategoriproduk"];
        $this->kategoriproduk->AdvancedSearch->SearchValue2 = @$filter["y_kategoriproduk"];
        $this->kategoriproduk->AdvancedSearch->SearchOperator2 = @$filter["w_kategoriproduk"];
        $this->kategoriproduk->AdvancedSearch->save();

        // Field jenisproduk
        $this->jenisproduk->AdvancedSearch->SearchValue = @$filter["x_jenisproduk"];
        $this->jenisproduk->AdvancedSearch->SearchOperator = @$filter["z_jenisproduk"];
        $this->jenisproduk->AdvancedSearch->SearchCondition = @$filter["v_jenisproduk"];
        $this->jenisproduk->AdvancedSearch->SearchValue2 = @$filter["y_jenisproduk"];
        $this->jenisproduk->AdvancedSearch->SearchOperator2 = @$filter["w_jenisproduk"];
        $this->jenisproduk->AdvancedSearch->save();

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

        // Field ukuransediaan
        $this->ukuransediaan->AdvancedSearch->SearchValue = @$filter["x_ukuransediaan"];
        $this->ukuransediaan->AdvancedSearch->SearchOperator = @$filter["z_ukuransediaan"];
        $this->ukuransediaan->AdvancedSearch->SearchCondition = @$filter["v_ukuransediaan"];
        $this->ukuransediaan->AdvancedSearch->SearchValue2 = @$filter["y_ukuransediaan"];
        $this->ukuransediaan->AdvancedSearch->SearchOperator2 = @$filter["w_ukuransediaan"];
        $this->ukuransediaan->AdvancedSearch->save();

        // Field satuansediaan
        $this->satuansediaan->AdvancedSearch->SearchValue = @$filter["x_satuansediaan"];
        $this->satuansediaan->AdvancedSearch->SearchOperator = @$filter["z_satuansediaan"];
        $this->satuansediaan->AdvancedSearch->SearchCondition = @$filter["v_satuansediaan"];
        $this->satuansediaan->AdvancedSearch->SearchValue2 = @$filter["y_satuansediaan"];
        $this->satuansediaan->AdvancedSearch->SearchOperator2 = @$filter["w_satuansediaan"];
        $this->satuansediaan->AdvancedSearch->save();

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

        // Field satuankemasan
        $this->satuankemasan->AdvancedSearch->SearchValue = @$filter["x_satuankemasan"];
        $this->satuankemasan->AdvancedSearch->SearchOperator = @$filter["z_satuankemasan"];
        $this->satuankemasan->AdvancedSearch->SearchCondition = @$filter["v_satuankemasan"];
        $this->satuankemasan->AdvancedSearch->SearchValue2 = @$filter["y_satuankemasan"];
        $this->satuankemasan->AdvancedSearch->SearchOperator2 = @$filter["w_satuankemasan"];
        $this->satuankemasan->AdvancedSearch->save();

        // Field kemasanwadah
        $this->kemasanwadah->AdvancedSearch->SearchValue = @$filter["x_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchOperator = @$filter["z_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchCondition = @$filter["v_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchValue2 = @$filter["y_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchOperator2 = @$filter["w_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->save();

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

        // Field ukurankemasansekunder
        $this->ukurankemasansekunder->AdvancedSearch->SearchValue = @$filter["x_ukurankemasansekunder"];
        $this->ukurankemasansekunder->AdvancedSearch->SearchOperator = @$filter["z_ukurankemasansekunder"];
        $this->ukurankemasansekunder->AdvancedSearch->SearchCondition = @$filter["v_ukurankemasansekunder"];
        $this->ukurankemasansekunder->AdvancedSearch->SearchValue2 = @$filter["y_ukurankemasansekunder"];
        $this->ukurankemasansekunder->AdvancedSearch->SearchOperator2 = @$filter["w_ukurankemasansekunder"];
        $this->ukurankemasansekunder->AdvancedSearch->save();

        // Field satuankemasansekunder
        $this->satuankemasansekunder->AdvancedSearch->SearchValue = @$filter["x_satuankemasansekunder"];
        $this->satuankemasansekunder->AdvancedSearch->SearchOperator = @$filter["z_satuankemasansekunder"];
        $this->satuankemasansekunder->AdvancedSearch->SearchCondition = @$filter["v_satuankemasansekunder"];
        $this->satuankemasansekunder->AdvancedSearch->SearchValue2 = @$filter["y_satuankemasansekunder"];
        $this->satuankemasansekunder->AdvancedSearch->SearchOperator2 = @$filter["w_satuankemasansekunder"];
        $this->satuankemasansekunder->AdvancedSearch->save();

        // Field kemasanbahan
        $this->kemasanbahan->AdvancedSearch->SearchValue = @$filter["x_kemasanbahan"];
        $this->kemasanbahan->AdvancedSearch->SearchOperator = @$filter["z_kemasanbahan"];
        $this->kemasanbahan->AdvancedSearch->SearchCondition = @$filter["v_kemasanbahan"];
        $this->kemasanbahan->AdvancedSearch->SearchValue2 = @$filter["y_kemasanbahan"];
        $this->kemasanbahan->AdvancedSearch->SearchOperator2 = @$filter["w_kemasanbahan"];
        $this->kemasanbahan->AdvancedSearch->save();

        // Field kemasanbentuk
        $this->kemasanbentuk->AdvancedSearch->SearchValue = @$filter["x_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchOperator = @$filter["z_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchCondition = @$filter["v_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchValue2 = @$filter["y_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->SearchOperator2 = @$filter["w_kemasanbentuk"];
        $this->kemasanbentuk->AdvancedSearch->save();

        // Field kemasankomposisi
        $this->kemasankomposisi->AdvancedSearch->SearchValue = @$filter["x_kemasankomposisi"];
        $this->kemasankomposisi->AdvancedSearch->SearchOperator = @$filter["z_kemasankomposisi"];
        $this->kemasankomposisi->AdvancedSearch->SearchCondition = @$filter["v_kemasankomposisi"];
        $this->kemasankomposisi->AdvancedSearch->SearchValue2 = @$filter["y_kemasankomposisi"];
        $this->kemasankomposisi->AdvancedSearch->SearchOperator2 = @$filter["w_kemasankomposisi"];
        $this->kemasankomposisi->AdvancedSearch->save();

        // Field kemasancatatansekunder
        $this->kemasancatatansekunder->AdvancedSearch->SearchValue = @$filter["x_kemasancatatansekunder"];
        $this->kemasancatatansekunder->AdvancedSearch->SearchOperator = @$filter["z_kemasancatatansekunder"];
        $this->kemasancatatansekunder->AdvancedSearch->SearchCondition = @$filter["v_kemasancatatansekunder"];
        $this->kemasancatatansekunder->AdvancedSearch->SearchValue2 = @$filter["y_kemasancatatansekunder"];
        $this->kemasancatatansekunder->AdvancedSearch->SearchOperator2 = @$filter["w_kemasancatatansekunder"];
        $this->kemasancatatansekunder->AdvancedSearch->save();

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

        // Field labeltekstur
        $this->labeltekstur->AdvancedSearch->SearchValue = @$filter["x_labeltekstur"];
        $this->labeltekstur->AdvancedSearch->SearchOperator = @$filter["z_labeltekstur"];
        $this->labeltekstur->AdvancedSearch->SearchCondition = @$filter["v_labeltekstur"];
        $this->labeltekstur->AdvancedSearch->SearchValue2 = @$filter["y_labeltekstur"];
        $this->labeltekstur->AdvancedSearch->SearchOperator2 = @$filter["w_labeltekstur"];
        $this->labeltekstur->AdvancedSearch->save();

        // Field labelprint
        $this->labelprint->AdvancedSearch->SearchValue = @$filter["x_labelprint"];
        $this->labelprint->AdvancedSearch->SearchOperator = @$filter["z_labelprint"];
        $this->labelprint->AdvancedSearch->SearchCondition = @$filter["v_labelprint"];
        $this->labelprint->AdvancedSearch->SearchValue2 = @$filter["y_labelprint"];
        $this->labelprint->AdvancedSearch->SearchOperator2 = @$filter["w_labelprint"];
        $this->labelprint->AdvancedSearch->save();

        // Field labeljmlwarna
        $this->labeljmlwarna->AdvancedSearch->SearchValue = @$filter["x_labeljmlwarna"];
        $this->labeljmlwarna->AdvancedSearch->SearchOperator = @$filter["z_labeljmlwarna"];
        $this->labeljmlwarna->AdvancedSearch->SearchCondition = @$filter["v_labeljmlwarna"];
        $this->labeljmlwarna->AdvancedSearch->SearchValue2 = @$filter["y_labeljmlwarna"];
        $this->labeljmlwarna->AdvancedSearch->SearchOperator2 = @$filter["w_labeljmlwarna"];
        $this->labeljmlwarna->AdvancedSearch->save();

        // Field labelcatatanhotprint
        $this->labelcatatanhotprint->AdvancedSearch->SearchValue = @$filter["x_labelcatatanhotprint"];
        $this->labelcatatanhotprint->AdvancedSearch->SearchOperator = @$filter["z_labelcatatanhotprint"];
        $this->labelcatatanhotprint->AdvancedSearch->SearchCondition = @$filter["v_labelcatatanhotprint"];
        $this->labelcatatanhotprint->AdvancedSearch->SearchValue2 = @$filter["y_labelcatatanhotprint"];
        $this->labelcatatanhotprint->AdvancedSearch->SearchOperator2 = @$filter["w_labelcatatanhotprint"];
        $this->labelcatatanhotprint->AdvancedSearch->save();

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

        // Field utama_harga_isi_proyeksi
        $this->utama_harga_isi_proyeksi->AdvancedSearch->SearchValue = @$filter["x_utama_harga_isi_proyeksi"];
        $this->utama_harga_isi_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_isi_proyeksi"];
        $this->utama_harga_isi_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_isi_proyeksi"];
        $this->utama_harga_isi_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_isi_proyeksi"];
        $this->utama_harga_isi_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_isi_proyeksi"];
        $this->utama_harga_isi_proyeksi->AdvancedSearch->save();

        // Field utama_harga_primer
        $this->utama_harga_primer->AdvancedSearch->SearchValue = @$filter["x_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_primer"];
        $this->utama_harga_primer->AdvancedSearch->save();

        // Field utama_harga_primer_proyeksi
        $this->utama_harga_primer_proyeksi->AdvancedSearch->SearchValue = @$filter["x_utama_harga_primer_proyeksi"];
        $this->utama_harga_primer_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_primer_proyeksi"];
        $this->utama_harga_primer_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_primer_proyeksi"];
        $this->utama_harga_primer_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_primer_proyeksi"];
        $this->utama_harga_primer_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_primer_proyeksi"];
        $this->utama_harga_primer_proyeksi->AdvancedSearch->save();

        // Field utama_harga_sekunder
        $this->utama_harga_sekunder->AdvancedSearch->SearchValue = @$filter["x_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_sekunder"];
        $this->utama_harga_sekunder->AdvancedSearch->save();

        // Field utama_harga_sekunder_proyeksi
        $this->utama_harga_sekunder_proyeksi->AdvancedSearch->SearchValue = @$filter["x_utama_harga_sekunder_proyeksi"];
        $this->utama_harga_sekunder_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_sekunder_proyeksi"];
        $this->utama_harga_sekunder_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_sekunder_proyeksi"];
        $this->utama_harga_sekunder_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_sekunder_proyeksi"];
        $this->utama_harga_sekunder_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_sekunder_proyeksi"];
        $this->utama_harga_sekunder_proyeksi->AdvancedSearch->save();

        // Field utama_harga_label
        $this->utama_harga_label->AdvancedSearch->SearchValue = @$filter["x_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_label"];
        $this->utama_harga_label->AdvancedSearch->save();

        // Field utama_harga_label_proyeksi
        $this->utama_harga_label_proyeksi->AdvancedSearch->SearchValue = @$filter["x_utama_harga_label_proyeksi"];
        $this->utama_harga_label_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_label_proyeksi"];
        $this->utama_harga_label_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_label_proyeksi"];
        $this->utama_harga_label_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_label_proyeksi"];
        $this->utama_harga_label_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_label_proyeksi"];
        $this->utama_harga_label_proyeksi->AdvancedSearch->save();

        // Field utama_harga_total
        $this->utama_harga_total->AdvancedSearch->SearchValue = @$filter["x_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_total"];
        $this->utama_harga_total->AdvancedSearch->save();

        // Field utama_harga_total_proyeksi
        $this->utama_harga_total_proyeksi->AdvancedSearch->SearchValue = @$filter["x_utama_harga_total_proyeksi"];
        $this->utama_harga_total_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_utama_harga_total_proyeksi"];
        $this->utama_harga_total_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_utama_harga_total_proyeksi"];
        $this->utama_harga_total_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_utama_harga_total_proyeksi"];
        $this->utama_harga_total_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_utama_harga_total_proyeksi"];
        $this->utama_harga_total_proyeksi->AdvancedSearch->save();

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

        // Field lain_harga_isi_proyeksi
        $this->lain_harga_isi_proyeksi->AdvancedSearch->SearchValue = @$filter["x_lain_harga_isi_proyeksi"];
        $this->lain_harga_isi_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_isi_proyeksi"];
        $this->lain_harga_isi_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_isi_proyeksi"];
        $this->lain_harga_isi_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_isi_proyeksi"];
        $this->lain_harga_isi_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_isi_proyeksi"];
        $this->lain_harga_isi_proyeksi->AdvancedSearch->save();

        // Field lain_harga_primer
        $this->lain_harga_primer->AdvancedSearch->SearchValue = @$filter["x_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_primer"];
        $this->lain_harga_primer->AdvancedSearch->save();

        // Field lain_harga_primer_proyeksi
        $this->lain_harga_primer_proyeksi->AdvancedSearch->SearchValue = @$filter["x_lain_harga_primer_proyeksi"];
        $this->lain_harga_primer_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_primer_proyeksi"];
        $this->lain_harga_primer_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_primer_proyeksi"];
        $this->lain_harga_primer_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_primer_proyeksi"];
        $this->lain_harga_primer_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_primer_proyeksi"];
        $this->lain_harga_primer_proyeksi->AdvancedSearch->save();

        // Field lain_harga_sekunder
        $this->lain_harga_sekunder->AdvancedSearch->SearchValue = @$filter["x_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_sekunder"];
        $this->lain_harga_sekunder->AdvancedSearch->save();

        // Field lain_harga_sekunder_proyeksi
        $this->lain_harga_sekunder_proyeksi->AdvancedSearch->SearchValue = @$filter["x_lain_harga_sekunder_proyeksi"];
        $this->lain_harga_sekunder_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_sekunder_proyeksi"];
        $this->lain_harga_sekunder_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_sekunder_proyeksi"];
        $this->lain_harga_sekunder_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_sekunder_proyeksi"];
        $this->lain_harga_sekunder_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_sekunder_proyeksi"];
        $this->lain_harga_sekunder_proyeksi->AdvancedSearch->save();

        // Field lain_harga_label
        $this->lain_harga_label->AdvancedSearch->SearchValue = @$filter["x_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_label"];
        $this->lain_harga_label->AdvancedSearch->save();

        // Field lain_harga_label_proyeksi
        $this->lain_harga_label_proyeksi->AdvancedSearch->SearchValue = @$filter["x_lain_harga_label_proyeksi"];
        $this->lain_harga_label_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_label_proyeksi"];
        $this->lain_harga_label_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_label_proyeksi"];
        $this->lain_harga_label_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_label_proyeksi"];
        $this->lain_harga_label_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_label_proyeksi"];
        $this->lain_harga_label_proyeksi->AdvancedSearch->save();

        // Field lain_harga_total
        $this->lain_harga_total->AdvancedSearch->SearchValue = @$filter["x_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_total"];
        $this->lain_harga_total->AdvancedSearch->save();

        // Field lain_harga_total_proyeksi
        $this->lain_harga_total_proyeksi->AdvancedSearch->SearchValue = @$filter["x_lain_harga_total_proyeksi"];
        $this->lain_harga_total_proyeksi->AdvancedSearch->SearchOperator = @$filter["z_lain_harga_total_proyeksi"];
        $this->lain_harga_total_proyeksi->AdvancedSearch->SearchCondition = @$filter["v_lain_harga_total_proyeksi"];
        $this->lain_harga_total_proyeksi->AdvancedSearch->SearchValue2 = @$filter["y_lain_harga_total_proyeksi"];
        $this->lain_harga_total_proyeksi->AdvancedSearch->SearchOperator2 = @$filter["w_lain_harga_total_proyeksi"];
        $this->lain_harga_total_proyeksi->AdvancedSearch->save();

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

        // Field delivery_termlain
        $this->delivery_termlain->AdvancedSearch->SearchValue = @$filter["x_delivery_termlain"];
        $this->delivery_termlain->AdvancedSearch->SearchOperator = @$filter["z_delivery_termlain"];
        $this->delivery_termlain->AdvancedSearch->SearchCondition = @$filter["v_delivery_termlain"];
        $this->delivery_termlain->AdvancedSearch->SearchValue2 = @$filter["y_delivery_termlain"];
        $this->delivery_termlain->AdvancedSearch->SearchOperator2 = @$filter["w_delivery_termlain"];
        $this->delivery_termlain->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field readonly
        $this->readonly->AdvancedSearch->SearchValue = @$filter["x_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator = @$filter["z_readonly"];
        $this->readonly->AdvancedSearch->SearchCondition = @$filter["v_readonly"];
        $this->readonly->AdvancedSearch->SearchValue2 = @$filter["y_readonly"];
        $this->readonly->AdvancedSearch->SearchOperator2 = @$filter["w_readonly"];
        $this->readonly->AdvancedSearch->save();

        // Field receipt_by
        $this->receipt_by->AdvancedSearch->SearchValue = @$filter["x_receipt_by"];
        $this->receipt_by->AdvancedSearch->SearchOperator = @$filter["z_receipt_by"];
        $this->receipt_by->AdvancedSearch->SearchCondition = @$filter["v_receipt_by"];
        $this->receipt_by->AdvancedSearch->SearchValue2 = @$filter["y_receipt_by"];
        $this->receipt_by->AdvancedSearch->SearchOperator2 = @$filter["w_receipt_by"];
        $this->receipt_by->AdvancedSearch->save();

        // Field approve_by
        $this->approve_by->AdvancedSearch->SearchValue = @$filter["x_approve_by"];
        $this->approve_by->AdvancedSearch->SearchOperator = @$filter["z_approve_by"];
        $this->approve_by->AdvancedSearch->SearchCondition = @$filter["v_approve_by"];
        $this->approve_by->AdvancedSearch->SearchValue2 = @$filter["y_approve_by"];
        $this->approve_by->AdvancedSearch->SearchOperator2 = @$filter["w_approve_by"];
        $this->approve_by->AdvancedSearch->save();

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

        // Field selesai
        $this->selesai->AdvancedSearch->SearchValue = @$filter["x_selesai"];
        $this->selesai->AdvancedSearch->SearchOperator = @$filter["z_selesai"];
        $this->selesai->AdvancedSearch->SearchCondition = @$filter["v_selesai"];
        $this->selesai->AdvancedSearch->SearchValue2 = @$filter["y_selesai"];
        $this->selesai->AdvancedSearch->SearchOperator2 = @$filter["w_selesai"];
        $this->selesai->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->sifatorder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kodeorder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->nomororder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->fungsiproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kualitasproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bahan_campaign, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuransediaan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->satuansediaan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bentuk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->viskositas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->warna, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->parfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->aplikasi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->estetika, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->tambahan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukurankemasan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->satuankemasan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasanwadah, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasantutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasancatatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukurankemasansekunder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->satuankemasansekunder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasanbahan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasankomposisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasancatatansekunder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelbahan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelkualitas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelposisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelcatatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labeltekstur, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelprint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelcatatanhotprint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuran_utama, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuran_lain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_pickup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_singlepoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_multipoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->delivery_termlain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->status, $arKeywords, $type);
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
            $this->updateSort($this->idcustomer); // idcustomer
            $this->updateSort($this->tanggal_order); // tanggal_order
            $this->updateSort($this->sifatorder); // sifatorder
            $this->updateSort($this->kodeorder); // kodeorder
            $this->updateSort($this->kategoriproduk); // kategoriproduk
            $this->updateSort($this->jenisproduk); // jenisproduk
            $this->updateSort($this->status); // status
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
                $this->idpegawai->setSort("");
                $this->idcustomer->setSort("");
                $this->idbrand->setSort("");
                $this->tanggal_order->setSort("");
                $this->target_selesai->setSort("");
                $this->sifatorder->setSort("");
                $this->kodeorder->setSort("");
                $this->nomororder->setSort("");
                $this->idproduct_acuan->setSort("");
                $this->kategoriproduk->setSort("");
                $this->jenisproduk->setSort("");
                $this->fungsiproduk->setSort("");
                $this->kualitasproduk->setSort("");
                $this->bahan_campaign->setSort("");
                $this->ukuransediaan->setSort("");
                $this->satuansediaan->setSort("");
                $this->bentuk->setSort("");
                $this->viskositas->setSort("");
                $this->warna->setSort("");
                $this->parfum->setSort("");
                $this->aplikasi->setSort("");
                $this->estetika->setSort("");
                $this->tambahan->setSort("");
                $this->ukurankemasan->setSort("");
                $this->satuankemasan->setSort("");
                $this->kemasanwadah->setSort("");
                $this->kemasantutup->setSort("");
                $this->kemasancatatan->setSort("");
                $this->ukurankemasansekunder->setSort("");
                $this->satuankemasansekunder->setSort("");
                $this->kemasanbahan->setSort("");
                $this->kemasanbentuk->setSort("");
                $this->kemasankomposisi->setSort("");
                $this->kemasancatatansekunder->setSort("");
                $this->labelbahan->setSort("");
                $this->labelkualitas->setSort("");
                $this->labelposisi->setSort("");
                $this->labelcatatan->setSort("");
                $this->labeltekstur->setSort("");
                $this->labelprint->setSort("");
                $this->labeljmlwarna->setSort("");
                $this->labelcatatanhotprint->setSort("");
                $this->ukuran_utama->setSort("");
                $this->utama_harga_isi->setSort("");
                $this->utama_harga_isi_proyeksi->setSort("");
                $this->utama_harga_primer->setSort("");
                $this->utama_harga_primer_proyeksi->setSort("");
                $this->utama_harga_sekunder->setSort("");
                $this->utama_harga_sekunder_proyeksi->setSort("");
                $this->utama_harga_label->setSort("");
                $this->utama_harga_label_proyeksi->setSort("");
                $this->utama_harga_total->setSort("");
                $this->utama_harga_total_proyeksi->setSort("");
                $this->ukuran_lain->setSort("");
                $this->lain_harga_isi->setSort("");
                $this->lain_harga_isi_proyeksi->setSort("");
                $this->lain_harga_primer->setSort("");
                $this->lain_harga_primer_proyeksi->setSort("");
                $this->lain_harga_sekunder->setSort("");
                $this->lain_harga_sekunder_proyeksi->setSort("");
                $this->lain_harga_label->setSort("");
                $this->lain_harga_label_proyeksi->setSort("");
                $this->lain_harga_total->setSort("");
                $this->lain_harga_total_proyeksi->setSort("");
                $this->delivery_pickup->setSort("");
                $this->delivery_singlepoint->setSort("");
                $this->delivery_multipoint->setSort("");
                $this->delivery_termlain->setSort("");
                $this->status->setSort("");
                $this->readonly->setSort("");
                $this->receipt_by->setSort("");
                $this->approve_by->setSort("");
                $this->created_at->setSort("");
                $this->updated_at->setSort("");
                $this->selesai->setSort("");
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

        // "detail_npd_confirmsample"
        $item = &$this->ListOptions->add("detail_npd_confirmsample");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_confirmsample') && !$this->ShowMultipleDetails;
        $item->OnLeft = false;
        $item->ShowInButtonGroup = false;

        // "detail_npd_harga"
        $item = &$this->ListOptions->add("detail_npd_harga");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'npd_harga') && !$this->ShowMultipleDetails;
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
        $pages->add("npd_confirmsample");
        $pages->add("npd_harga");
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

        // "sequence"
        $item = &$this->ListOptions->add("sequence");
        $item->CssClass = "text-nowrap";
        $item->Visible = true;
        $item->OnLeft = true; // Always on left
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

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
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

        // "detail_npd_confirmsample"
        $opt = $this->ListOptions["detail_npd_confirmsample"];
        if ($Security->allowList(CurrentProjectID() . 'npd_confirmsample')) {
            $body = $Language->phrase("DetailLink") . $Language->TablePhrase("npd_confirmsample", "TblCaption");
            $body .= "&nbsp;" . str_replace("%c", Container("npd_confirmsample")->Count, $Language->phrase("DetailCount"));
            $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode("NpdConfirmsampleList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("NpdConfirmsampleGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirmsample");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . HtmlImageAndText($caption) . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "npd_confirmsample";
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
                $item = &$option->add("detailadd_npd_confirmsample");
                $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirmsample");
                $detailPage = Container("NpdConfirmsampleGrid");
                $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
                $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
                $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'npd') && $Security->canAdd());
                if ($item->Visible) {
                    if ($detailTableLink != "") {
                        $detailTableLink .= ",";
                    }
                    $detailTableLink .= "npd_confirmsample";
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
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idnpd`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_npd_confirmsample"
        if ($this->DetailPages && $this->DetailPages["npd_confirmsample"] && $this->DetailPages["npd_confirmsample"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_npd_confirmsample"];
            $url = "NpdConfirmsamplePreview?t=npd&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"npd_confirmsample\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'npd')) {
                $label = $Language->TablePhrase("npd_confirmsample", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("npd_confirmsample")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"npd_confirmsample\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("NpdConfirmsampleList?" . Config("TABLE_SHOW_MASTER") . "=npd&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("npd_confirmsample", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("NpdConfirmsampleGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'npd')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=npd_confirmsample");
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
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->sifatorder->setDbValue($row['sifatorder']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuransediaan->setDbValue($row['ukuransediaan']);
        $this->satuansediaan->setDbValue($row['satuansediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->estetika->setDbValue($row['estetika']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->satuankemasan->setDbValue($row['satuankemasan']);
        $this->kemasanwadah->setDbValue($row['kemasanwadah']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->ukurankemasansekunder->setDbValue($row['ukurankemasansekunder']);
        $this->satuankemasansekunder->setDbValue($row['satuankemasansekunder']);
        $this->kemasanbahan->setDbValue($row['kemasanbahan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasankomposisi->setDbValue($row['kemasankomposisi']);
        $this->kemasancatatansekunder->setDbValue($row['kemasancatatansekunder']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->labeltekstur->setDbValue($row['labeltekstur']);
        $this->labelprint->setDbValue($row['labelprint']);
        $this->labeljmlwarna->setDbValue($row['labeljmlwarna']);
        $this->labelcatatanhotprint->setDbValue($row['labelcatatanhotprint']);
        $this->ukuran_utama->setDbValue($row['ukuran_utama']);
        $this->utama_harga_isi->setDbValue($row['utama_harga_isi']);
        $this->utama_harga_isi_proyeksi->setDbValue($row['utama_harga_isi_proyeksi']);
        $this->utama_harga_primer->setDbValue($row['utama_harga_primer']);
        $this->utama_harga_primer_proyeksi->setDbValue($row['utama_harga_primer_proyeksi']);
        $this->utama_harga_sekunder->setDbValue($row['utama_harga_sekunder']);
        $this->utama_harga_sekunder_proyeksi->setDbValue($row['utama_harga_sekunder_proyeksi']);
        $this->utama_harga_label->setDbValue($row['utama_harga_label']);
        $this->utama_harga_label_proyeksi->setDbValue($row['utama_harga_label_proyeksi']);
        $this->utama_harga_total->setDbValue($row['utama_harga_total']);
        $this->utama_harga_total_proyeksi->setDbValue($row['utama_harga_total_proyeksi']);
        $this->ukuran_lain->setDbValue($row['ukuran_lain']);
        $this->lain_harga_isi->setDbValue($row['lain_harga_isi']);
        $this->lain_harga_isi_proyeksi->setDbValue($row['lain_harga_isi_proyeksi']);
        $this->lain_harga_primer->setDbValue($row['lain_harga_primer']);
        $this->lain_harga_primer_proyeksi->setDbValue($row['lain_harga_primer_proyeksi']);
        $this->lain_harga_sekunder->setDbValue($row['lain_harga_sekunder']);
        $this->lain_harga_sekunder_proyeksi->setDbValue($row['lain_harga_sekunder_proyeksi']);
        $this->lain_harga_label->setDbValue($row['lain_harga_label']);
        $this->lain_harga_label_proyeksi->setDbValue($row['lain_harga_label_proyeksi']);
        $this->lain_harga_total->setDbValue($row['lain_harga_total']);
        $this->lain_harga_total_proyeksi->setDbValue($row['lain_harga_total_proyeksi']);
        $this->delivery_pickup->setDbValue($row['delivery_pickup']);
        $this->delivery_singlepoint->setDbValue($row['delivery_singlepoint']);
        $this->delivery_multipoint->setDbValue($row['delivery_multipoint']);
        $this->delivery_termlain->setDbValue($row['delivery_termlain']);
        $this->status->setDbValue($row['status']);
        $this->readonly->setDbValue($row['readonly']);
        $this->receipt_by->setDbValue($row['receipt_by']);
        $this->approve_by->setDbValue($row['approve_by']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->selesai->setDbValue($row['selesai']);
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
        $detailTbl = Container("npd_confirmsample");
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
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['idbrand'] = null;
        $row['tanggal_order'] = null;
        $row['target_selesai'] = null;
        $row['sifatorder'] = null;
        $row['kodeorder'] = null;
        $row['nomororder'] = null;
        $row['idproduct_acuan'] = null;
        $row['kategoriproduk'] = null;
        $row['jenisproduk'] = null;
        $row['fungsiproduk'] = null;
        $row['kualitasproduk'] = null;
        $row['bahan_campaign'] = null;
        $row['ukuransediaan'] = null;
        $row['satuansediaan'] = null;
        $row['bentuk'] = null;
        $row['viskositas'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['aplikasi'] = null;
        $row['estetika'] = null;
        $row['tambahan'] = null;
        $row['ukurankemasan'] = null;
        $row['satuankemasan'] = null;
        $row['kemasanwadah'] = null;
        $row['kemasantutup'] = null;
        $row['kemasancatatan'] = null;
        $row['ukurankemasansekunder'] = null;
        $row['satuankemasansekunder'] = null;
        $row['kemasanbahan'] = null;
        $row['kemasanbentuk'] = null;
        $row['kemasankomposisi'] = null;
        $row['kemasancatatansekunder'] = null;
        $row['labelbahan'] = null;
        $row['labelkualitas'] = null;
        $row['labelposisi'] = null;
        $row['labelcatatan'] = null;
        $row['labeltekstur'] = null;
        $row['labelprint'] = null;
        $row['labeljmlwarna'] = null;
        $row['labelcatatanhotprint'] = null;
        $row['ukuran_utama'] = null;
        $row['utama_harga_isi'] = null;
        $row['utama_harga_isi_proyeksi'] = null;
        $row['utama_harga_primer'] = null;
        $row['utama_harga_primer_proyeksi'] = null;
        $row['utama_harga_sekunder'] = null;
        $row['utama_harga_sekunder_proyeksi'] = null;
        $row['utama_harga_label'] = null;
        $row['utama_harga_label_proyeksi'] = null;
        $row['utama_harga_total'] = null;
        $row['utama_harga_total_proyeksi'] = null;
        $row['ukuran_lain'] = null;
        $row['lain_harga_isi'] = null;
        $row['lain_harga_isi_proyeksi'] = null;
        $row['lain_harga_primer'] = null;
        $row['lain_harga_primer_proyeksi'] = null;
        $row['lain_harga_sekunder'] = null;
        $row['lain_harga_sekunder_proyeksi'] = null;
        $row['lain_harga_label'] = null;
        $row['lain_harga_label_proyeksi'] = null;
        $row['lain_harga_total'] = null;
        $row['lain_harga_total_proyeksi'] = null;
        $row['delivery_pickup'] = null;
        $row['delivery_singlepoint'] = null;
        $row['delivery_multipoint'] = null;
        $row['delivery_termlain'] = null;
        $row['status'] = null;
        $row['readonly'] = null;
        $row['receipt_by'] = null;
        $row['approve_by'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['selesai'] = null;
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

        // idpegawai

        // idcustomer

        // idbrand

        // tanggal_order

        // target_selesai

        // sifatorder

        // kodeorder

        // nomororder

        // idproduct_acuan
        $this->idproduct_acuan->CellCssStyle = "white-space: nowrap;";

        // kategoriproduk

        // jenisproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuransediaan

        // satuansediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aplikasi

        // estetika

        // tambahan

        // ukurankemasan

        // satuankemasan

        // kemasanwadah

        // kemasantutup

        // kemasancatatan

        // ukurankemasansekunder

        // satuankemasansekunder

        // kemasanbahan

        // kemasanbentuk

        // kemasankomposisi

        // kemasancatatansekunder

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

        // labeltekstur

        // labelprint

        // labeljmlwarna

        // labelcatatanhotprint

        // ukuran_utama

        // utama_harga_isi

        // utama_harga_isi_proyeksi

        // utama_harga_primer

        // utama_harga_primer_proyeksi

        // utama_harga_sekunder

        // utama_harga_sekunder_proyeksi

        // utama_harga_label

        // utama_harga_label_proyeksi

        // utama_harga_total

        // utama_harga_total_proyeksi

        // ukuran_lain

        // lain_harga_isi

        // lain_harga_isi_proyeksi

        // lain_harga_primer

        // lain_harga_primer_proyeksi

        // lain_harga_sekunder

        // lain_harga_sekunder_proyeksi

        // lain_harga_label

        // lain_harga_label_proyeksi

        // lain_harga_total

        // lain_harga_total_proyeksi

        // delivery_pickup

        // delivery_singlepoint

        // delivery_multipoint

        // delivery_termlain

        // status

        // readonly

        // receipt_by

        // approve_by

        // created_at

        // updated_at

        // selesai
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // idbrand
            $curVal = trim(strval($this->idbrand->CurrentValue));
            if ($curVal != "") {
                $this->idbrand->ViewValue = $this->idbrand->lookupCacheOption($curVal);
                if ($this->idbrand->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idbrand`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idbrand->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idbrand->Lookup->renderViewRow($rswrk[0]);
                        $this->idbrand->ViewValue = $this->idbrand->displayValue($arwrk);
                    } else {
                        $this->idbrand->ViewValue = $this->idbrand->CurrentValue;
                    }
                }
            } else {
                $this->idbrand->ViewValue = null;
            }
            $this->idbrand->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // sifatorder
            if (strval($this->sifatorder->CurrentValue) != "") {
                $this->sifatorder->ViewValue = $this->sifatorder->optionCaption($this->sifatorder->CurrentValue);
            } else {
                $this->sifatorder->ViewValue = null;
            }
            $this->sifatorder->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // nomororder
            $this->nomororder->ViewValue = $this->nomororder->CurrentValue;
            $this->nomororder->ViewCustomAttributes = "";

            // kategoriproduk
            $curVal = trim(strval($this->kategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->lookupCacheOption($curVal);
                if ($this->kategoriproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->kategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kategoriproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->displayValue($arwrk);
                    } else {
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
                    }
                }
            } else {
                $this->kategoriproduk->ViewValue = null;
            }
            $this->kategoriproduk->ViewCustomAttributes = "";

            // jenisproduk
            $curVal = trim(strval($this->jenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->jenisproduk->ViewValue = $this->jenisproduk->lookupCacheOption($curVal);
                if ($this->jenisproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jenisproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->jenisproduk->ViewValue = $this->jenisproduk->displayValue($arwrk);
                    } else {
                        $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
                    }
                }
            } else {
                $this->jenisproduk->ViewValue = null;
            }
            $this->jenisproduk->ViewCustomAttributes = "";

            // fungsiproduk
            $this->fungsiproduk->ViewValue = $this->fungsiproduk->CurrentValue;
            $this->fungsiproduk->ViewCustomAttributes = "";

            // kualitasproduk
            if (strval($this->kualitasproduk->CurrentValue) != "") {
                $this->kualitasproduk->ViewValue = $this->kualitasproduk->optionCaption($this->kualitasproduk->CurrentValue);
            } else {
                $this->kualitasproduk->ViewValue = null;
            }
            $this->kualitasproduk->ViewCustomAttributes = "";

            // bahan_campaign
            $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
            $this->bahan_campaign->ViewCustomAttributes = "";

            // ukuransediaan
            $this->ukuransediaan->ViewValue = $this->ukuransediaan->CurrentValue;
            $this->ukuransediaan->ViewCustomAttributes = "";

            // satuansediaan
            $curVal = trim(strval($this->satuansediaan->CurrentValue));
            if ($curVal != "") {
                $this->satuansediaan->ViewValue = $this->satuansediaan->lookupCacheOption($curVal);
                if ($this->satuansediaan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->satuansediaan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuansediaan->Lookup->renderViewRow($rswrk[0]);
                        $this->satuansediaan->ViewValue = $this->satuansediaan->displayValue($arwrk);
                    } else {
                        $this->satuansediaan->ViewValue = $this->satuansediaan->CurrentValue;
                    }
                }
            } else {
                $this->satuansediaan->ViewValue = null;
            }
            $this->satuansediaan->ViewCustomAttributes = "";

            // bentuk
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
                if ($this->bentuk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bentuk->Lookup->renderViewRow($rswrk[0]);
                        $this->bentuk->ViewValue = $this->bentuk->displayValue($arwrk);
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
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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

            // parfum
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
                if ($this->parfum->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->parfum->Lookup->renderViewRow($rswrk[0]);
                        $this->parfum->ViewValue = $this->parfum->displayValue($arwrk);
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
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->aplikasi->Lookup->renderViewRow($rswrk[0]);
                        $this->aplikasi->ViewValue = $this->aplikasi->displayValue($arwrk);
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
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->estetika->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->estetika->Lookup->renderViewRow($rswrk[0]);
                        $this->estetika->ViewValue = $this->estetika->displayValue($arwrk);
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

            // satuankemasan
            $curVal = trim(strval($this->satuankemasan->CurrentValue));
            if ($curVal != "") {
                $this->satuankemasan->ViewValue = $this->satuankemasan->lookupCacheOption($curVal);
                if ($this->satuankemasan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->satuankemasan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuankemasan->Lookup->renderViewRow($rswrk[0]);
                        $this->satuankemasan->ViewValue = $this->satuankemasan->displayValue($arwrk);
                    } else {
                        $this->satuankemasan->ViewValue = $this->satuankemasan->CurrentValue;
                    }
                }
            } else {
                $this->satuankemasan->ViewValue = null;
            }
            $this->satuankemasan->ViewCustomAttributes = "";

            // kemasanwadah
            $curVal = trim(strval($this->kemasanwadah->CurrentValue));
            if ($curVal != "") {
                $this->kemasanwadah->ViewValue = $this->kemasanwadah->lookupCacheOption($curVal);
                if ($this->kemasanwadah->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasanwadah->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasanwadah->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasanwadah->ViewValue = $this->kemasanwadah->displayValue($arwrk);
                    } else {
                        $this->kemasanwadah->ViewValue = $this->kemasanwadah->CurrentValue;
                    }
                }
            } else {
                $this->kemasanwadah->ViewValue = null;
            }
            $this->kemasanwadah->ViewCustomAttributes = "";

            // kemasantutup
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
                if ($this->kemasantutup->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasantutup->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasantutup->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasantutup->ViewValue = $this->kemasantutup->displayValue($arwrk);
                    } else {
                        $this->kemasantutup->ViewValue = $this->kemasantutup->CurrentValue;
                    }
                }
            } else {
                $this->kemasantutup->ViewValue = null;
            }
            $this->kemasantutup->ViewCustomAttributes = "";

            // ukurankemasansekunder
            $this->ukurankemasansekunder->ViewValue = $this->ukurankemasansekunder->CurrentValue;
            $this->ukurankemasansekunder->ViewCustomAttributes = "";

            // satuankemasansekunder
            $curVal = trim(strval($this->satuankemasansekunder->CurrentValue));
            if ($curVal != "") {
                $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->lookupCacheOption($curVal);
                if ($this->satuankemasansekunder->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->satuankemasansekunder->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuankemasansekunder->Lookup->renderViewRow($rswrk[0]);
                        $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->displayValue($arwrk);
                    } else {
                        $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->CurrentValue;
                    }
                }
            } else {
                $this->satuankemasansekunder->ViewValue = null;
            }
            $this->satuankemasansekunder->ViewCustomAttributes = "";

            // kemasanbahan
            $curVal = trim(strval($this->kemasanbahan->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbahan->ViewValue = $this->kemasanbahan->lookupCacheOption($curVal);
                if ($this->kemasanbahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasanbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasanbahan->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasanbahan->ViewValue = $this->kemasanbahan->displayValue($arwrk);
                    } else {
                        $this->kemasanbahan->ViewValue = $this->kemasanbahan->CurrentValue;
                    }
                }
            } else {
                $this->kemasanbahan->ViewValue = null;
            }
            $this->kemasanbahan->ViewCustomAttributes = "";

            // kemasanbentuk
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
                if ($this->kemasanbentuk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasanbentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasanbentuk->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->displayValue($arwrk);
                    } else {
                        $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->CurrentValue;
                    }
                }
            } else {
                $this->kemasanbentuk->ViewValue = null;
            }
            $this->kemasanbentuk->ViewCustomAttributes = "";

            // kemasankomposisi
            $curVal = trim(strval($this->kemasankomposisi->CurrentValue));
            if ($curVal != "") {
                $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->lookupCacheOption($curVal);
                if ($this->kemasankomposisi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasankomposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasankomposisi->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->displayValue($arwrk);
                    } else {
                        $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->CurrentValue;
                    }
                }
            } else {
                $this->kemasankomposisi->ViewValue = null;
            }
            $this->kemasankomposisi->ViewCustomAttributes = "";

            // labelbahan
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
                if ($this->labelbahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelbahan->Lookup->renderViewRow($rswrk[0]);
                        $this->labelbahan->ViewValue = $this->labelbahan->displayValue($arwrk);
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
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelkualitas->Lookup->renderViewRow($rswrk[0]);
                        $this->labelkualitas->ViewValue = $this->labelkualitas->displayValue($arwrk);
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
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelposisi->Lookup->renderViewRow($rswrk[0]);
                        $this->labelposisi->ViewValue = $this->labelposisi->displayValue($arwrk);
                    } else {
                        $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
                    }
                }
            } else {
                $this->labelposisi->ViewValue = null;
            }
            $this->labelposisi->ViewCustomAttributes = "";

            // labeltekstur
            $curVal = trim(strval($this->labeltekstur->CurrentValue));
            if ($curVal != "") {
                $this->labeltekstur->ViewValue = $this->labeltekstur->lookupCacheOption($curVal);
                if ($this->labeltekstur->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labeltekstur->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labeltekstur->Lookup->renderViewRow($rswrk[0]);
                        $this->labeltekstur->ViewValue = $this->labeltekstur->displayValue($arwrk);
                    } else {
                        $this->labeltekstur->ViewValue = $this->labeltekstur->CurrentValue;
                    }
                }
            } else {
                $this->labeltekstur->ViewValue = null;
            }
            $this->labeltekstur->ViewCustomAttributes = "";

            // labelprint
            $curVal = trim(strval($this->labelprint->CurrentValue));
            if ($curVal != "") {
                $this->labelprint->ViewValue = $this->labelprint->lookupCacheOption($curVal);
                if ($this->labelprint->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelprint->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelprint->Lookup->renderViewRow($rswrk[0]);
                        $this->labelprint->ViewValue = $this->labelprint->displayValue($arwrk);
                    } else {
                        $this->labelprint->ViewValue = $this->labelprint->CurrentValue;
                    }
                }
            } else {
                $this->labelprint->ViewValue = null;
            }
            $this->labelprint->ViewCustomAttributes = "";

            // labeljmlwarna
            $this->labeljmlwarna->ViewValue = $this->labeljmlwarna->CurrentValue;
            $this->labeljmlwarna->ViewCustomAttributes = "";

            // ukuran_utama
            $this->ukuran_utama->ViewValue = $this->ukuran_utama->CurrentValue;
            $this->ukuran_utama->ViewCustomAttributes = "";

            // utama_harga_isi
            $this->utama_harga_isi->ViewValue = $this->utama_harga_isi->CurrentValue;
            $this->utama_harga_isi->ViewValue = FormatNumber($this->utama_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi->ViewCustomAttributes = "";

            // utama_harga_isi_proyeksi
            $this->utama_harga_isi_proyeksi->ViewValue = $this->utama_harga_isi_proyeksi->CurrentValue;
            $this->utama_harga_isi_proyeksi->ViewValue = FormatNumber($this->utama_harga_isi_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi_proyeksi->ViewCustomAttributes = "";

            // utama_harga_primer
            $this->utama_harga_primer->ViewValue = $this->utama_harga_primer->CurrentValue;
            $this->utama_harga_primer->ViewValue = FormatNumber($this->utama_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer->ViewCustomAttributes = "";

            // utama_harga_primer_proyeksi
            $this->utama_harga_primer_proyeksi->ViewValue = $this->utama_harga_primer_proyeksi->CurrentValue;
            $this->utama_harga_primer_proyeksi->ViewValue = FormatNumber($this->utama_harga_primer_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer_proyeksi->ViewCustomAttributes = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->ViewValue = $this->utama_harga_sekunder->CurrentValue;
            $this->utama_harga_sekunder->ViewValue = FormatNumber($this->utama_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder->ViewCustomAttributes = "";

            // utama_harga_sekunder_proyeksi
            $this->utama_harga_sekunder_proyeksi->ViewValue = $this->utama_harga_sekunder_proyeksi->CurrentValue;
            $this->utama_harga_sekunder_proyeksi->ViewValue = FormatNumber($this->utama_harga_sekunder_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder_proyeksi->ViewCustomAttributes = "";

            // utama_harga_label
            $this->utama_harga_label->ViewValue = $this->utama_harga_label->CurrentValue;
            $this->utama_harga_label->ViewValue = FormatNumber($this->utama_harga_label->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label->ViewCustomAttributes = "";

            // utama_harga_label_proyeksi
            $this->utama_harga_label_proyeksi->ViewValue = $this->utama_harga_label_proyeksi->CurrentValue;
            $this->utama_harga_label_proyeksi->ViewValue = FormatNumber($this->utama_harga_label_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label_proyeksi->ViewCustomAttributes = "";

            // utama_harga_total
            $this->utama_harga_total->ViewValue = $this->utama_harga_total->CurrentValue;
            $this->utama_harga_total->ViewValue = FormatNumber($this->utama_harga_total->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total->ViewCustomAttributes = "";

            // utama_harga_total_proyeksi
            $this->utama_harga_total_proyeksi->ViewValue = $this->utama_harga_total_proyeksi->CurrentValue;
            $this->utama_harga_total_proyeksi->ViewValue = FormatNumber($this->utama_harga_total_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total_proyeksi->ViewCustomAttributes = "";

            // ukuran_lain
            $this->ukuran_lain->ViewValue = $this->ukuran_lain->CurrentValue;
            $this->ukuran_lain->ViewCustomAttributes = "";

            // lain_harga_isi
            $this->lain_harga_isi->ViewValue = $this->lain_harga_isi->CurrentValue;
            $this->lain_harga_isi->ViewValue = FormatNumber($this->lain_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi->ViewCustomAttributes = "";

            // lain_harga_isi_proyeksi
            $this->lain_harga_isi_proyeksi->ViewValue = $this->lain_harga_isi_proyeksi->CurrentValue;
            $this->lain_harga_isi_proyeksi->ViewValue = FormatNumber($this->lain_harga_isi_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi_proyeksi->ViewCustomAttributes = "";

            // lain_harga_primer
            $this->lain_harga_primer->ViewValue = $this->lain_harga_primer->CurrentValue;
            $this->lain_harga_primer->ViewValue = FormatNumber($this->lain_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer->ViewCustomAttributes = "";

            // lain_harga_primer_proyeksi
            $this->lain_harga_primer_proyeksi->ViewValue = $this->lain_harga_primer_proyeksi->CurrentValue;
            $this->lain_harga_primer_proyeksi->ViewValue = FormatNumber($this->lain_harga_primer_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer_proyeksi->ViewCustomAttributes = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->ViewValue = $this->lain_harga_sekunder->CurrentValue;
            $this->lain_harga_sekunder->ViewValue = FormatNumber($this->lain_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder->ViewCustomAttributes = "";

            // lain_harga_sekunder_proyeksi
            $this->lain_harga_sekunder_proyeksi->ViewValue = $this->lain_harga_sekunder_proyeksi->CurrentValue;
            $this->lain_harga_sekunder_proyeksi->ViewValue = FormatNumber($this->lain_harga_sekunder_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder_proyeksi->ViewCustomAttributes = "";

            // lain_harga_label
            $this->lain_harga_label->ViewValue = $this->lain_harga_label->CurrentValue;
            $this->lain_harga_label->ViewValue = FormatNumber($this->lain_harga_label->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label->ViewCustomAttributes = "";

            // lain_harga_label_proyeksi
            $this->lain_harga_label_proyeksi->ViewValue = $this->lain_harga_label_proyeksi->CurrentValue;
            $this->lain_harga_label_proyeksi->ViewValue = FormatNumber($this->lain_harga_label_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label_proyeksi->ViewCustomAttributes = "";

            // lain_harga_total
            $this->lain_harga_total->ViewValue = $this->lain_harga_total->CurrentValue;
            $this->lain_harga_total->ViewValue = FormatNumber($this->lain_harga_total->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total->ViewCustomAttributes = "";

            // lain_harga_total_proyeksi
            $this->lain_harga_total_proyeksi->ViewValue = $this->lain_harga_total_proyeksi->CurrentValue;
            $this->lain_harga_total_proyeksi->ViewValue = FormatNumber($this->lain_harga_total_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total_proyeksi->ViewCustomAttributes = "";

            // delivery_pickup
            $this->delivery_pickup->ViewValue = $this->delivery_pickup->CurrentValue;
            $this->delivery_pickup->ViewCustomAttributes = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->ViewValue = $this->delivery_singlepoint->CurrentValue;
            $this->delivery_singlepoint->ViewCustomAttributes = "";

            // delivery_multipoint
            $this->delivery_multipoint->ViewValue = $this->delivery_multipoint->CurrentValue;
            $this->delivery_multipoint->ViewCustomAttributes = "";

            // delivery_termlain
            $this->delivery_termlain->ViewValue = $this->delivery_termlain->CurrentValue;
            $this->delivery_termlain->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // readonly
            if (strval($this->readonly->CurrentValue) != "") {
                $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
            } else {
                $this->readonly->ViewValue = null;
            }
            $this->readonly->ViewCustomAttributes = "";

            // receipt_by
            $this->receipt_by->ViewValue = $this->receipt_by->CurrentValue;
            $this->receipt_by->ViewValue = FormatNumber($this->receipt_by->ViewValue, 0, -2, -2, -2);
            $this->receipt_by->ViewCustomAttributes = "";

            // approve_by
            $curVal = trim(strval($this->approve_by->CurrentValue));
            if ($curVal != "") {
                $this->approve_by->ViewValue = $this->approve_by->lookupCacheOption($curVal);
                if ($this->approve_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->approve_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->approve_by->Lookup->renderViewRow($rswrk[0]);
                        $this->approve_by->ViewValue = $this->approve_by->displayValue($arwrk);
                    } else {
                        $this->approve_by->ViewValue = $this->approve_by->CurrentValue;
                    }
                }
            } else {
                $this->approve_by->ViewValue = null;
            }
            $this->approve_by->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 11);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 17);
            $this->updated_at->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";
            $this->sifatorder->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";
            $this->kategoriproduk->TooltipValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";
            $this->jenisproduk->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
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
                case "x_idbrand":
                    break;
                case "x_sifatorder":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_kategoriproduk":
                    break;
                case "x_jenisproduk":
                    break;
                case "x_kualitasproduk":
                    break;
                case "x_satuansediaan":
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
                case "x_satuankemasan":
                    break;
                case "x_kemasanwadah":
                    break;
                case "x_kemasantutup":
                    break;
                case "x_satuankemasansekunder":
                    break;
                case "x_kemasanbahan":
                    break;
                case "x_kemasanbentuk":
                    break;
                case "x_kemasankomposisi":
                    break;
                case "x_labelbahan":
                    break;
                case "x_labelkualitas":
                    break;
                case "x_labelposisi":
                    break;
                case "x_labeltekstur":
                    break;
                case "x_labelprint":
                    break;
                case "x_status":
                    break;
                case "x_readonly":
                    break;
                case "x_approve_by":
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

        //$item = &$this->ListOptions->add("aksi");
        //$item->Header = "Action";
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

        //if ($this->selesai->CurrentValue == 0) {
        //	$this->ListOptions->Items["aksi"]->Body = "<a href=\"javascript:selesai(".$this->id->CurrentValue.")\">Tandai Selesai</a>";
        //} else {
        //	$this->ListOptions->Items["aksi"]->Body = "<a href=\"javascript:belumselesai(".$this->id->CurrentValue.")\">Tandai Belum Selesai</a>";
        //}
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
