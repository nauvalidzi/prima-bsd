<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class OrderPengembanganList extends OrderPengembangan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'order_pengembangan';

    // Page object name
    public $PageObjName = "OrderPengembanganList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "forder_pengembanganlist";
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

        // Table object (order_pengembangan)
        if (!isset($GLOBALS["order_pengembangan"]) || get_class($GLOBALS["order_pengembangan"]) == PROJECT_NAMESPACE . "order_pengembangan") {
            $GLOBALS["order_pengembangan"] = &$this;
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
        $this->AddUrl = "OrderPengembanganAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "OrderPengembanganDelete";
        $this->MultiUpdateUrl = "OrderPengembanganUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'order_pengembangan');
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
        $this->FilterOptions->TagClassName = "ew-filter-option forder_pengembanganlistsrch";

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
                $doc = new $class(Container("order_pengembangan"));
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
        $this->id->setVisibility();
        $this->cpo_jenis->setVisibility();
        $this->ordernum->setVisibility();
        $this->order_kode->setVisibility();
        $this->orderterimatgl->setVisibility();
        $this->produk_fungsi->setVisibility();
        $this->produk_kualitas->setVisibility();
        $this->produk_campaign->setVisibility();
        $this->kemasan_satuan->setVisibility();
        $this->ordertgl->setVisibility();
        $this->custcode->setVisibility();
        $this->perushnama->setVisibility();
        $this->perushalamat->setVisibility();
        $this->perushcp->setVisibility();
        $this->perushjabatan->setVisibility();
        $this->perushphone->setVisibility();
        $this->perushmobile->setVisibility();
        $this->bencmark->setVisibility();
        $this->kategoriproduk->setVisibility();
        $this->jenisproduk->setVisibility();
        $this->bentuksediaan->setVisibility();
        $this->sediaan_ukuran->setVisibility();
        $this->sediaan_ukuran_satuan->setVisibility();
        $this->produk_viskositas->setVisibility();
        $this->konsepproduk->setVisibility();
        $this->fragrance->setVisibility();
        $this->aroma->setVisibility();
        $this->bahanaktif->setVisibility();
        $this->warna->setVisibility();
        $this->produk_warna_jenis->setVisibility();
        $this->aksesoris->setVisibility();
        $this->produk_lainlain->Visible = false;
        $this->statusproduk->setVisibility();
        $this->parfum->setVisibility();
        $this->catatan->setVisibility();
        $this->rencanakemasan->setVisibility();
        $this->keterangan->Visible = false;
        $this->ekspetasiharga->setVisibility();
        $this->kemasan->setVisibility();
        $this->volume->setVisibility();
        $this->jenistutup->setVisibility();
        $this->catatanpackaging->Visible = false;
        $this->infopackaging->setVisibility();
        $this->ukuran->setVisibility();
        $this->desainprodukkemasan->setVisibility();
        $this->desaindiinginkan->setVisibility();
        $this->mereknotifikasi->setVisibility();
        $this->kategoristatus->setVisibility();
        $this->kemasan_ukuran_satuan->setVisibility();
        $this->notifikasicatatan->Visible = false;
        $this->label_ukuran->Visible = false;
        $this->infolabel->setVisibility();
        $this->labelkualitas->setVisibility();
        $this->labelposisi->setVisibility();
        $this->labelcatatan->Visible = false;
        $this->dibuatdi->setVisibility();
        $this->tanggal->setVisibility();
        $this->penerima->setVisibility();
        $this->createat->setVisibility();
        $this->createby->setVisibility();
        $this->statusdokumen->setVisibility();
        $this->update_at->setVisibility();
        $this->status_data->setVisibility();
        $this->harga_rnd->setVisibility();
        $this->aplikasi_sediaan->setVisibility();
        $this->hu_hrg_isi->setVisibility();
        $this->hu_hrg_isi_pro->setVisibility();
        $this->hu_hrg_kms_primer->setVisibility();
        $this->hu_hrg_kms_primer_pro->setVisibility();
        $this->hu_hrg_kms_sekunder->setVisibility();
        $this->hu_hrg_kms_sekunder_pro->setVisibility();
        $this->hu_hrg_label->setVisibility();
        $this->hu_hrg_label_pro->setVisibility();
        $this->hu_hrg_total->setVisibility();
        $this->hu_hrg_total_pro->setVisibility();
        $this->hl_hrg_isi->setVisibility();
        $this->hl_hrg_isi_pro->setVisibility();
        $this->hl_hrg_kms_primer->setVisibility();
        $this->hl_hrg_kms_primer_pro->setVisibility();
        $this->hl_hrg_kms_sekunder->setVisibility();
        $this->hl_hrg_kms_sekunder_pro->setVisibility();
        $this->hl_hrg_label->setVisibility();
        $this->hl_hrg_label_pro->setVisibility();
        $this->hl_hrg_total->setVisibility();
        $this->hl_hrg_total_pro->setVisibility();
        $this->bs_bahan_aktif_tick->setVisibility();
        $this->bs_bahan_aktif->Visible = false;
        $this->bs_bahan_lain->Visible = false;
        $this->bs_parfum->Visible = false;
        $this->bs_estetika->Visible = false;
        $this->bs_kms_wadah->Visible = false;
        $this->bs_kms_tutup->Visible = false;
        $this->bs_kms_sekunder->Visible = false;
        $this->bs_label_desain->Visible = false;
        $this->bs_label_cetak->Visible = false;
        $this->bs_label_lain->Visible = false;
        $this->dlv_pickup->Visible = false;
        $this->dlv_singlepoint->Visible = false;
        $this->dlv_multipoint->Visible = false;
        $this->dlv_multipoint_jml->Visible = false;
        $this->dlv_term_lain->Visible = false;
        $this->catatan_khusus->Visible = false;
        $this->aju_tgl->setVisibility();
        $this->aju_oleh->setVisibility();
        $this->proses_tgl->setVisibility();
        $this->proses_oleh->setVisibility();
        $this->revisi_tgl->setVisibility();
        $this->revisi_oleh->setVisibility();
        $this->revisi_akun_tgl->setVisibility();
        $this->revisi_akun_oleh->setVisibility();
        $this->revisi_rnd_tgl->setVisibility();
        $this->revisi_rnd_oleh->setVisibility();
        $this->rnd_tgl->setVisibility();
        $this->rnd_oleh->setVisibility();
        $this->ap_tgl->setVisibility();
        $this->ap_oleh->setVisibility();
        $this->batal_tgl->setVisibility();
        $this->batal_oleh->setVisibility();
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
        $filterList = Concat($filterList, $this->cpo_jenis->AdvancedSearch->toJson(), ","); // Field cpo_jenis
        $filterList = Concat($filterList, $this->ordernum->AdvancedSearch->toJson(), ","); // Field ordernum
        $filterList = Concat($filterList, $this->order_kode->AdvancedSearch->toJson(), ","); // Field order_kode
        $filterList = Concat($filterList, $this->orderterimatgl->AdvancedSearch->toJson(), ","); // Field orderterimatgl
        $filterList = Concat($filterList, $this->produk_fungsi->AdvancedSearch->toJson(), ","); // Field produk_fungsi
        $filterList = Concat($filterList, $this->produk_kualitas->AdvancedSearch->toJson(), ","); // Field produk_kualitas
        $filterList = Concat($filterList, $this->produk_campaign->AdvancedSearch->toJson(), ","); // Field produk_campaign
        $filterList = Concat($filterList, $this->kemasan_satuan->AdvancedSearch->toJson(), ","); // Field kemasan_satuan
        $filterList = Concat($filterList, $this->ordertgl->AdvancedSearch->toJson(), ","); // Field ordertgl
        $filterList = Concat($filterList, $this->custcode->AdvancedSearch->toJson(), ","); // Field custcode
        $filterList = Concat($filterList, $this->perushnama->AdvancedSearch->toJson(), ","); // Field perushnama
        $filterList = Concat($filterList, $this->perushalamat->AdvancedSearch->toJson(), ","); // Field perushalamat
        $filterList = Concat($filterList, $this->perushcp->AdvancedSearch->toJson(), ","); // Field perushcp
        $filterList = Concat($filterList, $this->perushjabatan->AdvancedSearch->toJson(), ","); // Field perushjabatan
        $filterList = Concat($filterList, $this->perushphone->AdvancedSearch->toJson(), ","); // Field perushphone
        $filterList = Concat($filterList, $this->perushmobile->AdvancedSearch->toJson(), ","); // Field perushmobile
        $filterList = Concat($filterList, $this->bencmark->AdvancedSearch->toJson(), ","); // Field bencmark
        $filterList = Concat($filterList, $this->kategoriproduk->AdvancedSearch->toJson(), ","); // Field kategoriproduk
        $filterList = Concat($filterList, $this->jenisproduk->AdvancedSearch->toJson(), ","); // Field jenisproduk
        $filterList = Concat($filterList, $this->bentuksediaan->AdvancedSearch->toJson(), ","); // Field bentuksediaan
        $filterList = Concat($filterList, $this->sediaan_ukuran->AdvancedSearch->toJson(), ","); // Field sediaan_ukuran
        $filterList = Concat($filterList, $this->sediaan_ukuran_satuan->AdvancedSearch->toJson(), ","); // Field sediaan_ukuran_satuan
        $filterList = Concat($filterList, $this->produk_viskositas->AdvancedSearch->toJson(), ","); // Field produk_viskositas
        $filterList = Concat($filterList, $this->konsepproduk->AdvancedSearch->toJson(), ","); // Field konsepproduk
        $filterList = Concat($filterList, $this->fragrance->AdvancedSearch->toJson(), ","); // Field fragrance
        $filterList = Concat($filterList, $this->aroma->AdvancedSearch->toJson(), ","); // Field aroma
        $filterList = Concat($filterList, $this->bahanaktif->AdvancedSearch->toJson(), ","); // Field bahanaktif
        $filterList = Concat($filterList, $this->warna->AdvancedSearch->toJson(), ","); // Field warna
        $filterList = Concat($filterList, $this->produk_warna_jenis->AdvancedSearch->toJson(), ","); // Field produk_warna_jenis
        $filterList = Concat($filterList, $this->aksesoris->AdvancedSearch->toJson(), ","); // Field aksesoris
        $filterList = Concat($filterList, $this->produk_lainlain->AdvancedSearch->toJson(), ","); // Field produk_lainlain
        $filterList = Concat($filterList, $this->statusproduk->AdvancedSearch->toJson(), ","); // Field statusproduk
        $filterList = Concat($filterList, $this->parfum->AdvancedSearch->toJson(), ","); // Field parfum
        $filterList = Concat($filterList, $this->catatan->AdvancedSearch->toJson(), ","); // Field catatan
        $filterList = Concat($filterList, $this->rencanakemasan->AdvancedSearch->toJson(), ","); // Field rencanakemasan
        $filterList = Concat($filterList, $this->keterangan->AdvancedSearch->toJson(), ","); // Field keterangan
        $filterList = Concat($filterList, $this->ekspetasiharga->AdvancedSearch->toJson(), ","); // Field ekspetasiharga
        $filterList = Concat($filterList, $this->kemasan->AdvancedSearch->toJson(), ","); // Field kemasan
        $filterList = Concat($filterList, $this->volume->AdvancedSearch->toJson(), ","); // Field volume
        $filterList = Concat($filterList, $this->jenistutup->AdvancedSearch->toJson(), ","); // Field jenistutup
        $filterList = Concat($filterList, $this->catatanpackaging->AdvancedSearch->toJson(), ","); // Field catatanpackaging
        $filterList = Concat($filterList, $this->infopackaging->AdvancedSearch->toJson(), ","); // Field infopackaging
        $filterList = Concat($filterList, $this->ukuran->AdvancedSearch->toJson(), ","); // Field ukuran
        $filterList = Concat($filterList, $this->desainprodukkemasan->AdvancedSearch->toJson(), ","); // Field desainprodukkemasan
        $filterList = Concat($filterList, $this->desaindiinginkan->AdvancedSearch->toJson(), ","); // Field desaindiinginkan
        $filterList = Concat($filterList, $this->mereknotifikasi->AdvancedSearch->toJson(), ","); // Field mereknotifikasi
        $filterList = Concat($filterList, $this->kategoristatus->AdvancedSearch->toJson(), ","); // Field kategoristatus
        $filterList = Concat($filterList, $this->kemasan_ukuran_satuan->AdvancedSearch->toJson(), ","); // Field kemasan_ukuran_satuan
        $filterList = Concat($filterList, $this->notifikasicatatan->AdvancedSearch->toJson(), ","); // Field notifikasicatatan
        $filterList = Concat($filterList, $this->label_ukuran->AdvancedSearch->toJson(), ","); // Field label_ukuran
        $filterList = Concat($filterList, $this->infolabel->AdvancedSearch->toJson(), ","); // Field infolabel
        $filterList = Concat($filterList, $this->labelkualitas->AdvancedSearch->toJson(), ","); // Field labelkualitas
        $filterList = Concat($filterList, $this->labelposisi->AdvancedSearch->toJson(), ","); // Field labelposisi
        $filterList = Concat($filterList, $this->labelcatatan->AdvancedSearch->toJson(), ","); // Field labelcatatan
        $filterList = Concat($filterList, $this->dibuatdi->AdvancedSearch->toJson(), ","); // Field dibuatdi
        $filterList = Concat($filterList, $this->tanggal->AdvancedSearch->toJson(), ","); // Field tanggal
        $filterList = Concat($filterList, $this->penerima->AdvancedSearch->toJson(), ","); // Field penerima
        $filterList = Concat($filterList, $this->createat->AdvancedSearch->toJson(), ","); // Field createat
        $filterList = Concat($filterList, $this->createby->AdvancedSearch->toJson(), ","); // Field createby
        $filterList = Concat($filterList, $this->statusdokumen->AdvancedSearch->toJson(), ","); // Field statusdokumen
        $filterList = Concat($filterList, $this->update_at->AdvancedSearch->toJson(), ","); // Field update_at
        $filterList = Concat($filterList, $this->status_data->AdvancedSearch->toJson(), ","); // Field status_data
        $filterList = Concat($filterList, $this->harga_rnd->AdvancedSearch->toJson(), ","); // Field harga_rnd
        $filterList = Concat($filterList, $this->aplikasi_sediaan->AdvancedSearch->toJson(), ","); // Field aplikasi_sediaan
        $filterList = Concat($filterList, $this->hu_hrg_isi->AdvancedSearch->toJson(), ","); // Field hu_hrg_isi
        $filterList = Concat($filterList, $this->hu_hrg_isi_pro->AdvancedSearch->toJson(), ","); // Field hu_hrg_isi_pro
        $filterList = Concat($filterList, $this->hu_hrg_kms_primer->AdvancedSearch->toJson(), ","); // Field hu_hrg_kms_primer
        $filterList = Concat($filterList, $this->hu_hrg_kms_primer_pro->AdvancedSearch->toJson(), ","); // Field hu_hrg_kms_primer_pro
        $filterList = Concat($filterList, $this->hu_hrg_kms_sekunder->AdvancedSearch->toJson(), ","); // Field hu_hrg_kms_sekunder
        $filterList = Concat($filterList, $this->hu_hrg_kms_sekunder_pro->AdvancedSearch->toJson(), ","); // Field hu_hrg_kms_sekunder_pro
        $filterList = Concat($filterList, $this->hu_hrg_label->AdvancedSearch->toJson(), ","); // Field hu_hrg_label
        $filterList = Concat($filterList, $this->hu_hrg_label_pro->AdvancedSearch->toJson(), ","); // Field hu_hrg_label_pro
        $filterList = Concat($filterList, $this->hu_hrg_total->AdvancedSearch->toJson(), ","); // Field hu_hrg_total
        $filterList = Concat($filterList, $this->hu_hrg_total_pro->AdvancedSearch->toJson(), ","); // Field hu_hrg_total_pro
        $filterList = Concat($filterList, $this->hl_hrg_isi->AdvancedSearch->toJson(), ","); // Field hl_hrg_isi
        $filterList = Concat($filterList, $this->hl_hrg_isi_pro->AdvancedSearch->toJson(), ","); // Field hl_hrg_isi_pro
        $filterList = Concat($filterList, $this->hl_hrg_kms_primer->AdvancedSearch->toJson(), ","); // Field hl_hrg_kms_primer
        $filterList = Concat($filterList, $this->hl_hrg_kms_primer_pro->AdvancedSearch->toJson(), ","); // Field hl_hrg_kms_primer_pro
        $filterList = Concat($filterList, $this->hl_hrg_kms_sekunder->AdvancedSearch->toJson(), ","); // Field hl_hrg_kms_sekunder
        $filterList = Concat($filterList, $this->hl_hrg_kms_sekunder_pro->AdvancedSearch->toJson(), ","); // Field hl_hrg_kms_sekunder_pro
        $filterList = Concat($filterList, $this->hl_hrg_label->AdvancedSearch->toJson(), ","); // Field hl_hrg_label
        $filterList = Concat($filterList, $this->hl_hrg_label_pro->AdvancedSearch->toJson(), ","); // Field hl_hrg_label_pro
        $filterList = Concat($filterList, $this->hl_hrg_total->AdvancedSearch->toJson(), ","); // Field hl_hrg_total
        $filterList = Concat($filterList, $this->hl_hrg_total_pro->AdvancedSearch->toJson(), ","); // Field hl_hrg_total_pro
        $filterList = Concat($filterList, $this->bs_bahan_aktif_tick->AdvancedSearch->toJson(), ","); // Field bs_bahan_aktif_tick
        $filterList = Concat($filterList, $this->bs_bahan_aktif->AdvancedSearch->toJson(), ","); // Field bs_bahan_aktif
        $filterList = Concat($filterList, $this->bs_bahan_lain->AdvancedSearch->toJson(), ","); // Field bs_bahan_lain
        $filterList = Concat($filterList, $this->bs_parfum->AdvancedSearch->toJson(), ","); // Field bs_parfum
        $filterList = Concat($filterList, $this->bs_estetika->AdvancedSearch->toJson(), ","); // Field bs_estetika
        $filterList = Concat($filterList, $this->bs_kms_wadah->AdvancedSearch->toJson(), ","); // Field bs_kms_wadah
        $filterList = Concat($filterList, $this->bs_kms_tutup->AdvancedSearch->toJson(), ","); // Field bs_kms_tutup
        $filterList = Concat($filterList, $this->bs_kms_sekunder->AdvancedSearch->toJson(), ","); // Field bs_kms_sekunder
        $filterList = Concat($filterList, $this->bs_label_desain->AdvancedSearch->toJson(), ","); // Field bs_label_desain
        $filterList = Concat($filterList, $this->bs_label_cetak->AdvancedSearch->toJson(), ","); // Field bs_label_cetak
        $filterList = Concat($filterList, $this->bs_label_lain->AdvancedSearch->toJson(), ","); // Field bs_label_lain
        $filterList = Concat($filterList, $this->dlv_pickup->AdvancedSearch->toJson(), ","); // Field dlv_pickup
        $filterList = Concat($filterList, $this->dlv_singlepoint->AdvancedSearch->toJson(), ","); // Field dlv_singlepoint
        $filterList = Concat($filterList, $this->dlv_multipoint->AdvancedSearch->toJson(), ","); // Field dlv_multipoint
        $filterList = Concat($filterList, $this->dlv_multipoint_jml->AdvancedSearch->toJson(), ","); // Field dlv_multipoint_jml
        $filterList = Concat($filterList, $this->dlv_term_lain->AdvancedSearch->toJson(), ","); // Field dlv_term_lain
        $filterList = Concat($filterList, $this->catatan_khusus->AdvancedSearch->toJson(), ","); // Field catatan_khusus
        $filterList = Concat($filterList, $this->aju_tgl->AdvancedSearch->toJson(), ","); // Field aju_tgl
        $filterList = Concat($filterList, $this->aju_oleh->AdvancedSearch->toJson(), ","); // Field aju_oleh
        $filterList = Concat($filterList, $this->proses_tgl->AdvancedSearch->toJson(), ","); // Field proses_tgl
        $filterList = Concat($filterList, $this->proses_oleh->AdvancedSearch->toJson(), ","); // Field proses_oleh
        $filterList = Concat($filterList, $this->revisi_tgl->AdvancedSearch->toJson(), ","); // Field revisi_tgl
        $filterList = Concat($filterList, $this->revisi_oleh->AdvancedSearch->toJson(), ","); // Field revisi_oleh
        $filterList = Concat($filterList, $this->revisi_akun_tgl->AdvancedSearch->toJson(), ","); // Field revisi_akun_tgl
        $filterList = Concat($filterList, $this->revisi_akun_oleh->AdvancedSearch->toJson(), ","); // Field revisi_akun_oleh
        $filterList = Concat($filterList, $this->revisi_rnd_tgl->AdvancedSearch->toJson(), ","); // Field revisi_rnd_tgl
        $filterList = Concat($filterList, $this->revisi_rnd_oleh->AdvancedSearch->toJson(), ","); // Field revisi_rnd_oleh
        $filterList = Concat($filterList, $this->rnd_tgl->AdvancedSearch->toJson(), ","); // Field rnd_tgl
        $filterList = Concat($filterList, $this->rnd_oleh->AdvancedSearch->toJson(), ","); // Field rnd_oleh
        $filterList = Concat($filterList, $this->ap_tgl->AdvancedSearch->toJson(), ","); // Field ap_tgl
        $filterList = Concat($filterList, $this->ap_oleh->AdvancedSearch->toJson(), ","); // Field ap_oleh
        $filterList = Concat($filterList, $this->batal_tgl->AdvancedSearch->toJson(), ","); // Field batal_tgl
        $filterList = Concat($filterList, $this->batal_oleh->AdvancedSearch->toJson(), ","); // Field batal_oleh
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
            $UserProfile->setSearchFilters(CurrentUserName(), "forder_pengembanganlistsrch", $filters);
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

        // Field cpo_jenis
        $this->cpo_jenis->AdvancedSearch->SearchValue = @$filter["x_cpo_jenis"];
        $this->cpo_jenis->AdvancedSearch->SearchOperator = @$filter["z_cpo_jenis"];
        $this->cpo_jenis->AdvancedSearch->SearchCondition = @$filter["v_cpo_jenis"];
        $this->cpo_jenis->AdvancedSearch->SearchValue2 = @$filter["y_cpo_jenis"];
        $this->cpo_jenis->AdvancedSearch->SearchOperator2 = @$filter["w_cpo_jenis"];
        $this->cpo_jenis->AdvancedSearch->save();

        // Field ordernum
        $this->ordernum->AdvancedSearch->SearchValue = @$filter["x_ordernum"];
        $this->ordernum->AdvancedSearch->SearchOperator = @$filter["z_ordernum"];
        $this->ordernum->AdvancedSearch->SearchCondition = @$filter["v_ordernum"];
        $this->ordernum->AdvancedSearch->SearchValue2 = @$filter["y_ordernum"];
        $this->ordernum->AdvancedSearch->SearchOperator2 = @$filter["w_ordernum"];
        $this->ordernum->AdvancedSearch->save();

        // Field order_kode
        $this->order_kode->AdvancedSearch->SearchValue = @$filter["x_order_kode"];
        $this->order_kode->AdvancedSearch->SearchOperator = @$filter["z_order_kode"];
        $this->order_kode->AdvancedSearch->SearchCondition = @$filter["v_order_kode"];
        $this->order_kode->AdvancedSearch->SearchValue2 = @$filter["y_order_kode"];
        $this->order_kode->AdvancedSearch->SearchOperator2 = @$filter["w_order_kode"];
        $this->order_kode->AdvancedSearch->save();

        // Field orderterimatgl
        $this->orderterimatgl->AdvancedSearch->SearchValue = @$filter["x_orderterimatgl"];
        $this->orderterimatgl->AdvancedSearch->SearchOperator = @$filter["z_orderterimatgl"];
        $this->orderterimatgl->AdvancedSearch->SearchCondition = @$filter["v_orderterimatgl"];
        $this->orderterimatgl->AdvancedSearch->SearchValue2 = @$filter["y_orderterimatgl"];
        $this->orderterimatgl->AdvancedSearch->SearchOperator2 = @$filter["w_orderterimatgl"];
        $this->orderterimatgl->AdvancedSearch->save();

        // Field produk_fungsi
        $this->produk_fungsi->AdvancedSearch->SearchValue = @$filter["x_produk_fungsi"];
        $this->produk_fungsi->AdvancedSearch->SearchOperator = @$filter["z_produk_fungsi"];
        $this->produk_fungsi->AdvancedSearch->SearchCondition = @$filter["v_produk_fungsi"];
        $this->produk_fungsi->AdvancedSearch->SearchValue2 = @$filter["y_produk_fungsi"];
        $this->produk_fungsi->AdvancedSearch->SearchOperator2 = @$filter["w_produk_fungsi"];
        $this->produk_fungsi->AdvancedSearch->save();

        // Field produk_kualitas
        $this->produk_kualitas->AdvancedSearch->SearchValue = @$filter["x_produk_kualitas"];
        $this->produk_kualitas->AdvancedSearch->SearchOperator = @$filter["z_produk_kualitas"];
        $this->produk_kualitas->AdvancedSearch->SearchCondition = @$filter["v_produk_kualitas"];
        $this->produk_kualitas->AdvancedSearch->SearchValue2 = @$filter["y_produk_kualitas"];
        $this->produk_kualitas->AdvancedSearch->SearchOperator2 = @$filter["w_produk_kualitas"];
        $this->produk_kualitas->AdvancedSearch->save();

        // Field produk_campaign
        $this->produk_campaign->AdvancedSearch->SearchValue = @$filter["x_produk_campaign"];
        $this->produk_campaign->AdvancedSearch->SearchOperator = @$filter["z_produk_campaign"];
        $this->produk_campaign->AdvancedSearch->SearchCondition = @$filter["v_produk_campaign"];
        $this->produk_campaign->AdvancedSearch->SearchValue2 = @$filter["y_produk_campaign"];
        $this->produk_campaign->AdvancedSearch->SearchOperator2 = @$filter["w_produk_campaign"];
        $this->produk_campaign->AdvancedSearch->save();

        // Field kemasan_satuan
        $this->kemasan_satuan->AdvancedSearch->SearchValue = @$filter["x_kemasan_satuan"];
        $this->kemasan_satuan->AdvancedSearch->SearchOperator = @$filter["z_kemasan_satuan"];
        $this->kemasan_satuan->AdvancedSearch->SearchCondition = @$filter["v_kemasan_satuan"];
        $this->kemasan_satuan->AdvancedSearch->SearchValue2 = @$filter["y_kemasan_satuan"];
        $this->kemasan_satuan->AdvancedSearch->SearchOperator2 = @$filter["w_kemasan_satuan"];
        $this->kemasan_satuan->AdvancedSearch->save();

        // Field ordertgl
        $this->ordertgl->AdvancedSearch->SearchValue = @$filter["x_ordertgl"];
        $this->ordertgl->AdvancedSearch->SearchOperator = @$filter["z_ordertgl"];
        $this->ordertgl->AdvancedSearch->SearchCondition = @$filter["v_ordertgl"];
        $this->ordertgl->AdvancedSearch->SearchValue2 = @$filter["y_ordertgl"];
        $this->ordertgl->AdvancedSearch->SearchOperator2 = @$filter["w_ordertgl"];
        $this->ordertgl->AdvancedSearch->save();

        // Field custcode
        $this->custcode->AdvancedSearch->SearchValue = @$filter["x_custcode"];
        $this->custcode->AdvancedSearch->SearchOperator = @$filter["z_custcode"];
        $this->custcode->AdvancedSearch->SearchCondition = @$filter["v_custcode"];
        $this->custcode->AdvancedSearch->SearchValue2 = @$filter["y_custcode"];
        $this->custcode->AdvancedSearch->SearchOperator2 = @$filter["w_custcode"];
        $this->custcode->AdvancedSearch->save();

        // Field perushnama
        $this->perushnama->AdvancedSearch->SearchValue = @$filter["x_perushnama"];
        $this->perushnama->AdvancedSearch->SearchOperator = @$filter["z_perushnama"];
        $this->perushnama->AdvancedSearch->SearchCondition = @$filter["v_perushnama"];
        $this->perushnama->AdvancedSearch->SearchValue2 = @$filter["y_perushnama"];
        $this->perushnama->AdvancedSearch->SearchOperator2 = @$filter["w_perushnama"];
        $this->perushnama->AdvancedSearch->save();

        // Field perushalamat
        $this->perushalamat->AdvancedSearch->SearchValue = @$filter["x_perushalamat"];
        $this->perushalamat->AdvancedSearch->SearchOperator = @$filter["z_perushalamat"];
        $this->perushalamat->AdvancedSearch->SearchCondition = @$filter["v_perushalamat"];
        $this->perushalamat->AdvancedSearch->SearchValue2 = @$filter["y_perushalamat"];
        $this->perushalamat->AdvancedSearch->SearchOperator2 = @$filter["w_perushalamat"];
        $this->perushalamat->AdvancedSearch->save();

        // Field perushcp
        $this->perushcp->AdvancedSearch->SearchValue = @$filter["x_perushcp"];
        $this->perushcp->AdvancedSearch->SearchOperator = @$filter["z_perushcp"];
        $this->perushcp->AdvancedSearch->SearchCondition = @$filter["v_perushcp"];
        $this->perushcp->AdvancedSearch->SearchValue2 = @$filter["y_perushcp"];
        $this->perushcp->AdvancedSearch->SearchOperator2 = @$filter["w_perushcp"];
        $this->perushcp->AdvancedSearch->save();

        // Field perushjabatan
        $this->perushjabatan->AdvancedSearch->SearchValue = @$filter["x_perushjabatan"];
        $this->perushjabatan->AdvancedSearch->SearchOperator = @$filter["z_perushjabatan"];
        $this->perushjabatan->AdvancedSearch->SearchCondition = @$filter["v_perushjabatan"];
        $this->perushjabatan->AdvancedSearch->SearchValue2 = @$filter["y_perushjabatan"];
        $this->perushjabatan->AdvancedSearch->SearchOperator2 = @$filter["w_perushjabatan"];
        $this->perushjabatan->AdvancedSearch->save();

        // Field perushphone
        $this->perushphone->AdvancedSearch->SearchValue = @$filter["x_perushphone"];
        $this->perushphone->AdvancedSearch->SearchOperator = @$filter["z_perushphone"];
        $this->perushphone->AdvancedSearch->SearchCondition = @$filter["v_perushphone"];
        $this->perushphone->AdvancedSearch->SearchValue2 = @$filter["y_perushphone"];
        $this->perushphone->AdvancedSearch->SearchOperator2 = @$filter["w_perushphone"];
        $this->perushphone->AdvancedSearch->save();

        // Field perushmobile
        $this->perushmobile->AdvancedSearch->SearchValue = @$filter["x_perushmobile"];
        $this->perushmobile->AdvancedSearch->SearchOperator = @$filter["z_perushmobile"];
        $this->perushmobile->AdvancedSearch->SearchCondition = @$filter["v_perushmobile"];
        $this->perushmobile->AdvancedSearch->SearchValue2 = @$filter["y_perushmobile"];
        $this->perushmobile->AdvancedSearch->SearchOperator2 = @$filter["w_perushmobile"];
        $this->perushmobile->AdvancedSearch->save();

        // Field bencmark
        $this->bencmark->AdvancedSearch->SearchValue = @$filter["x_bencmark"];
        $this->bencmark->AdvancedSearch->SearchOperator = @$filter["z_bencmark"];
        $this->bencmark->AdvancedSearch->SearchCondition = @$filter["v_bencmark"];
        $this->bencmark->AdvancedSearch->SearchValue2 = @$filter["y_bencmark"];
        $this->bencmark->AdvancedSearch->SearchOperator2 = @$filter["w_bencmark"];
        $this->bencmark->AdvancedSearch->save();

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

        // Field bentuksediaan
        $this->bentuksediaan->AdvancedSearch->SearchValue = @$filter["x_bentuksediaan"];
        $this->bentuksediaan->AdvancedSearch->SearchOperator = @$filter["z_bentuksediaan"];
        $this->bentuksediaan->AdvancedSearch->SearchCondition = @$filter["v_bentuksediaan"];
        $this->bentuksediaan->AdvancedSearch->SearchValue2 = @$filter["y_bentuksediaan"];
        $this->bentuksediaan->AdvancedSearch->SearchOperator2 = @$filter["w_bentuksediaan"];
        $this->bentuksediaan->AdvancedSearch->save();

        // Field sediaan_ukuran
        $this->sediaan_ukuran->AdvancedSearch->SearchValue = @$filter["x_sediaan_ukuran"];
        $this->sediaan_ukuran->AdvancedSearch->SearchOperator = @$filter["z_sediaan_ukuran"];
        $this->sediaan_ukuran->AdvancedSearch->SearchCondition = @$filter["v_sediaan_ukuran"];
        $this->sediaan_ukuran->AdvancedSearch->SearchValue2 = @$filter["y_sediaan_ukuran"];
        $this->sediaan_ukuran->AdvancedSearch->SearchOperator2 = @$filter["w_sediaan_ukuran"];
        $this->sediaan_ukuran->AdvancedSearch->save();

        // Field sediaan_ukuran_satuan
        $this->sediaan_ukuran_satuan->AdvancedSearch->SearchValue = @$filter["x_sediaan_ukuran_satuan"];
        $this->sediaan_ukuran_satuan->AdvancedSearch->SearchOperator = @$filter["z_sediaan_ukuran_satuan"];
        $this->sediaan_ukuran_satuan->AdvancedSearch->SearchCondition = @$filter["v_sediaan_ukuran_satuan"];
        $this->sediaan_ukuran_satuan->AdvancedSearch->SearchValue2 = @$filter["y_sediaan_ukuran_satuan"];
        $this->sediaan_ukuran_satuan->AdvancedSearch->SearchOperator2 = @$filter["w_sediaan_ukuran_satuan"];
        $this->sediaan_ukuran_satuan->AdvancedSearch->save();

        // Field produk_viskositas
        $this->produk_viskositas->AdvancedSearch->SearchValue = @$filter["x_produk_viskositas"];
        $this->produk_viskositas->AdvancedSearch->SearchOperator = @$filter["z_produk_viskositas"];
        $this->produk_viskositas->AdvancedSearch->SearchCondition = @$filter["v_produk_viskositas"];
        $this->produk_viskositas->AdvancedSearch->SearchValue2 = @$filter["y_produk_viskositas"];
        $this->produk_viskositas->AdvancedSearch->SearchOperator2 = @$filter["w_produk_viskositas"];
        $this->produk_viskositas->AdvancedSearch->save();

        // Field konsepproduk
        $this->konsepproduk->AdvancedSearch->SearchValue = @$filter["x_konsepproduk"];
        $this->konsepproduk->AdvancedSearch->SearchOperator = @$filter["z_konsepproduk"];
        $this->konsepproduk->AdvancedSearch->SearchCondition = @$filter["v_konsepproduk"];
        $this->konsepproduk->AdvancedSearch->SearchValue2 = @$filter["y_konsepproduk"];
        $this->konsepproduk->AdvancedSearch->SearchOperator2 = @$filter["w_konsepproduk"];
        $this->konsepproduk->AdvancedSearch->save();

        // Field fragrance
        $this->fragrance->AdvancedSearch->SearchValue = @$filter["x_fragrance"];
        $this->fragrance->AdvancedSearch->SearchOperator = @$filter["z_fragrance"];
        $this->fragrance->AdvancedSearch->SearchCondition = @$filter["v_fragrance"];
        $this->fragrance->AdvancedSearch->SearchValue2 = @$filter["y_fragrance"];
        $this->fragrance->AdvancedSearch->SearchOperator2 = @$filter["w_fragrance"];
        $this->fragrance->AdvancedSearch->save();

        // Field aroma
        $this->aroma->AdvancedSearch->SearchValue = @$filter["x_aroma"];
        $this->aroma->AdvancedSearch->SearchOperator = @$filter["z_aroma"];
        $this->aroma->AdvancedSearch->SearchCondition = @$filter["v_aroma"];
        $this->aroma->AdvancedSearch->SearchValue2 = @$filter["y_aroma"];
        $this->aroma->AdvancedSearch->SearchOperator2 = @$filter["w_aroma"];
        $this->aroma->AdvancedSearch->save();

        // Field bahanaktif
        $this->bahanaktif->AdvancedSearch->SearchValue = @$filter["x_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchOperator = @$filter["z_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchCondition = @$filter["v_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchValue2 = @$filter["y_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->SearchOperator2 = @$filter["w_bahanaktif"];
        $this->bahanaktif->AdvancedSearch->save();

        // Field warna
        $this->warna->AdvancedSearch->SearchValue = @$filter["x_warna"];
        $this->warna->AdvancedSearch->SearchOperator = @$filter["z_warna"];
        $this->warna->AdvancedSearch->SearchCondition = @$filter["v_warna"];
        $this->warna->AdvancedSearch->SearchValue2 = @$filter["y_warna"];
        $this->warna->AdvancedSearch->SearchOperator2 = @$filter["w_warna"];
        $this->warna->AdvancedSearch->save();

        // Field produk_warna_jenis
        $this->produk_warna_jenis->AdvancedSearch->SearchValue = @$filter["x_produk_warna_jenis"];
        $this->produk_warna_jenis->AdvancedSearch->SearchOperator = @$filter["z_produk_warna_jenis"];
        $this->produk_warna_jenis->AdvancedSearch->SearchCondition = @$filter["v_produk_warna_jenis"];
        $this->produk_warna_jenis->AdvancedSearch->SearchValue2 = @$filter["y_produk_warna_jenis"];
        $this->produk_warna_jenis->AdvancedSearch->SearchOperator2 = @$filter["w_produk_warna_jenis"];
        $this->produk_warna_jenis->AdvancedSearch->save();

        // Field aksesoris
        $this->aksesoris->AdvancedSearch->SearchValue = @$filter["x_aksesoris"];
        $this->aksesoris->AdvancedSearch->SearchOperator = @$filter["z_aksesoris"];
        $this->aksesoris->AdvancedSearch->SearchCondition = @$filter["v_aksesoris"];
        $this->aksesoris->AdvancedSearch->SearchValue2 = @$filter["y_aksesoris"];
        $this->aksesoris->AdvancedSearch->SearchOperator2 = @$filter["w_aksesoris"];
        $this->aksesoris->AdvancedSearch->save();

        // Field produk_lainlain
        $this->produk_lainlain->AdvancedSearch->SearchValue = @$filter["x_produk_lainlain"];
        $this->produk_lainlain->AdvancedSearch->SearchOperator = @$filter["z_produk_lainlain"];
        $this->produk_lainlain->AdvancedSearch->SearchCondition = @$filter["v_produk_lainlain"];
        $this->produk_lainlain->AdvancedSearch->SearchValue2 = @$filter["y_produk_lainlain"];
        $this->produk_lainlain->AdvancedSearch->SearchOperator2 = @$filter["w_produk_lainlain"];
        $this->produk_lainlain->AdvancedSearch->save();

        // Field statusproduk
        $this->statusproduk->AdvancedSearch->SearchValue = @$filter["x_statusproduk"];
        $this->statusproduk->AdvancedSearch->SearchOperator = @$filter["z_statusproduk"];
        $this->statusproduk->AdvancedSearch->SearchCondition = @$filter["v_statusproduk"];
        $this->statusproduk->AdvancedSearch->SearchValue2 = @$filter["y_statusproduk"];
        $this->statusproduk->AdvancedSearch->SearchOperator2 = @$filter["w_statusproduk"];
        $this->statusproduk->AdvancedSearch->save();

        // Field parfum
        $this->parfum->AdvancedSearch->SearchValue = @$filter["x_parfum"];
        $this->parfum->AdvancedSearch->SearchOperator = @$filter["z_parfum"];
        $this->parfum->AdvancedSearch->SearchCondition = @$filter["v_parfum"];
        $this->parfum->AdvancedSearch->SearchValue2 = @$filter["y_parfum"];
        $this->parfum->AdvancedSearch->SearchOperator2 = @$filter["w_parfum"];
        $this->parfum->AdvancedSearch->save();

        // Field catatan
        $this->catatan->AdvancedSearch->SearchValue = @$filter["x_catatan"];
        $this->catatan->AdvancedSearch->SearchOperator = @$filter["z_catatan"];
        $this->catatan->AdvancedSearch->SearchCondition = @$filter["v_catatan"];
        $this->catatan->AdvancedSearch->SearchValue2 = @$filter["y_catatan"];
        $this->catatan->AdvancedSearch->SearchOperator2 = @$filter["w_catatan"];
        $this->catatan->AdvancedSearch->save();

        // Field rencanakemasan
        $this->rencanakemasan->AdvancedSearch->SearchValue = @$filter["x_rencanakemasan"];
        $this->rencanakemasan->AdvancedSearch->SearchOperator = @$filter["z_rencanakemasan"];
        $this->rencanakemasan->AdvancedSearch->SearchCondition = @$filter["v_rencanakemasan"];
        $this->rencanakemasan->AdvancedSearch->SearchValue2 = @$filter["y_rencanakemasan"];
        $this->rencanakemasan->AdvancedSearch->SearchOperator2 = @$filter["w_rencanakemasan"];
        $this->rencanakemasan->AdvancedSearch->save();

        // Field keterangan
        $this->keterangan->AdvancedSearch->SearchValue = @$filter["x_keterangan"];
        $this->keterangan->AdvancedSearch->SearchOperator = @$filter["z_keterangan"];
        $this->keterangan->AdvancedSearch->SearchCondition = @$filter["v_keterangan"];
        $this->keterangan->AdvancedSearch->SearchValue2 = @$filter["y_keterangan"];
        $this->keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_keterangan"];
        $this->keterangan->AdvancedSearch->save();

        // Field ekspetasiharga
        $this->ekspetasiharga->AdvancedSearch->SearchValue = @$filter["x_ekspetasiharga"];
        $this->ekspetasiharga->AdvancedSearch->SearchOperator = @$filter["z_ekspetasiharga"];
        $this->ekspetasiharga->AdvancedSearch->SearchCondition = @$filter["v_ekspetasiharga"];
        $this->ekspetasiharga->AdvancedSearch->SearchValue2 = @$filter["y_ekspetasiharga"];
        $this->ekspetasiharga->AdvancedSearch->SearchOperator2 = @$filter["w_ekspetasiharga"];
        $this->ekspetasiharga->AdvancedSearch->save();

        // Field kemasan
        $this->kemasan->AdvancedSearch->SearchValue = @$filter["x_kemasan"];
        $this->kemasan->AdvancedSearch->SearchOperator = @$filter["z_kemasan"];
        $this->kemasan->AdvancedSearch->SearchCondition = @$filter["v_kemasan"];
        $this->kemasan->AdvancedSearch->SearchValue2 = @$filter["y_kemasan"];
        $this->kemasan->AdvancedSearch->SearchOperator2 = @$filter["w_kemasan"];
        $this->kemasan->AdvancedSearch->save();

        // Field volume
        $this->volume->AdvancedSearch->SearchValue = @$filter["x_volume"];
        $this->volume->AdvancedSearch->SearchOperator = @$filter["z_volume"];
        $this->volume->AdvancedSearch->SearchCondition = @$filter["v_volume"];
        $this->volume->AdvancedSearch->SearchValue2 = @$filter["y_volume"];
        $this->volume->AdvancedSearch->SearchOperator2 = @$filter["w_volume"];
        $this->volume->AdvancedSearch->save();

        // Field jenistutup
        $this->jenistutup->AdvancedSearch->SearchValue = @$filter["x_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchOperator = @$filter["z_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchCondition = @$filter["v_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchValue2 = @$filter["y_jenistutup"];
        $this->jenistutup->AdvancedSearch->SearchOperator2 = @$filter["w_jenistutup"];
        $this->jenistutup->AdvancedSearch->save();

        // Field catatanpackaging
        $this->catatanpackaging->AdvancedSearch->SearchValue = @$filter["x_catatanpackaging"];
        $this->catatanpackaging->AdvancedSearch->SearchOperator = @$filter["z_catatanpackaging"];
        $this->catatanpackaging->AdvancedSearch->SearchCondition = @$filter["v_catatanpackaging"];
        $this->catatanpackaging->AdvancedSearch->SearchValue2 = @$filter["y_catatanpackaging"];
        $this->catatanpackaging->AdvancedSearch->SearchOperator2 = @$filter["w_catatanpackaging"];
        $this->catatanpackaging->AdvancedSearch->save();

        // Field infopackaging
        $this->infopackaging->AdvancedSearch->SearchValue = @$filter["x_infopackaging"];
        $this->infopackaging->AdvancedSearch->SearchOperator = @$filter["z_infopackaging"];
        $this->infopackaging->AdvancedSearch->SearchCondition = @$filter["v_infopackaging"];
        $this->infopackaging->AdvancedSearch->SearchValue2 = @$filter["y_infopackaging"];
        $this->infopackaging->AdvancedSearch->SearchOperator2 = @$filter["w_infopackaging"];
        $this->infopackaging->AdvancedSearch->save();

        // Field ukuran
        $this->ukuran->AdvancedSearch->SearchValue = @$filter["x_ukuran"];
        $this->ukuran->AdvancedSearch->SearchOperator = @$filter["z_ukuran"];
        $this->ukuran->AdvancedSearch->SearchCondition = @$filter["v_ukuran"];
        $this->ukuran->AdvancedSearch->SearchValue2 = @$filter["y_ukuran"];
        $this->ukuran->AdvancedSearch->SearchOperator2 = @$filter["w_ukuran"];
        $this->ukuran->AdvancedSearch->save();

        // Field desainprodukkemasan
        $this->desainprodukkemasan->AdvancedSearch->SearchValue = @$filter["x_desainprodukkemasan"];
        $this->desainprodukkemasan->AdvancedSearch->SearchOperator = @$filter["z_desainprodukkemasan"];
        $this->desainprodukkemasan->AdvancedSearch->SearchCondition = @$filter["v_desainprodukkemasan"];
        $this->desainprodukkemasan->AdvancedSearch->SearchValue2 = @$filter["y_desainprodukkemasan"];
        $this->desainprodukkemasan->AdvancedSearch->SearchOperator2 = @$filter["w_desainprodukkemasan"];
        $this->desainprodukkemasan->AdvancedSearch->save();

        // Field desaindiinginkan
        $this->desaindiinginkan->AdvancedSearch->SearchValue = @$filter["x_desaindiinginkan"];
        $this->desaindiinginkan->AdvancedSearch->SearchOperator = @$filter["z_desaindiinginkan"];
        $this->desaindiinginkan->AdvancedSearch->SearchCondition = @$filter["v_desaindiinginkan"];
        $this->desaindiinginkan->AdvancedSearch->SearchValue2 = @$filter["y_desaindiinginkan"];
        $this->desaindiinginkan->AdvancedSearch->SearchOperator2 = @$filter["w_desaindiinginkan"];
        $this->desaindiinginkan->AdvancedSearch->save();

        // Field mereknotifikasi
        $this->mereknotifikasi->AdvancedSearch->SearchValue = @$filter["x_mereknotifikasi"];
        $this->mereknotifikasi->AdvancedSearch->SearchOperator = @$filter["z_mereknotifikasi"];
        $this->mereknotifikasi->AdvancedSearch->SearchCondition = @$filter["v_mereknotifikasi"];
        $this->mereknotifikasi->AdvancedSearch->SearchValue2 = @$filter["y_mereknotifikasi"];
        $this->mereknotifikasi->AdvancedSearch->SearchOperator2 = @$filter["w_mereknotifikasi"];
        $this->mereknotifikasi->AdvancedSearch->save();

        // Field kategoristatus
        $this->kategoristatus->AdvancedSearch->SearchValue = @$filter["x_kategoristatus"];
        $this->kategoristatus->AdvancedSearch->SearchOperator = @$filter["z_kategoristatus"];
        $this->kategoristatus->AdvancedSearch->SearchCondition = @$filter["v_kategoristatus"];
        $this->kategoristatus->AdvancedSearch->SearchValue2 = @$filter["y_kategoristatus"];
        $this->kategoristatus->AdvancedSearch->SearchOperator2 = @$filter["w_kategoristatus"];
        $this->kategoristatus->AdvancedSearch->save();

        // Field kemasan_ukuran_satuan
        $this->kemasan_ukuran_satuan->AdvancedSearch->SearchValue = @$filter["x_kemasan_ukuran_satuan"];
        $this->kemasan_ukuran_satuan->AdvancedSearch->SearchOperator = @$filter["z_kemasan_ukuran_satuan"];
        $this->kemasan_ukuran_satuan->AdvancedSearch->SearchCondition = @$filter["v_kemasan_ukuran_satuan"];
        $this->kemasan_ukuran_satuan->AdvancedSearch->SearchValue2 = @$filter["y_kemasan_ukuran_satuan"];
        $this->kemasan_ukuran_satuan->AdvancedSearch->SearchOperator2 = @$filter["w_kemasan_ukuran_satuan"];
        $this->kemasan_ukuran_satuan->AdvancedSearch->save();

        // Field notifikasicatatan
        $this->notifikasicatatan->AdvancedSearch->SearchValue = @$filter["x_notifikasicatatan"];
        $this->notifikasicatatan->AdvancedSearch->SearchOperator = @$filter["z_notifikasicatatan"];
        $this->notifikasicatatan->AdvancedSearch->SearchCondition = @$filter["v_notifikasicatatan"];
        $this->notifikasicatatan->AdvancedSearch->SearchValue2 = @$filter["y_notifikasicatatan"];
        $this->notifikasicatatan->AdvancedSearch->SearchOperator2 = @$filter["w_notifikasicatatan"];
        $this->notifikasicatatan->AdvancedSearch->save();

        // Field label_ukuran
        $this->label_ukuran->AdvancedSearch->SearchValue = @$filter["x_label_ukuran"];
        $this->label_ukuran->AdvancedSearch->SearchOperator = @$filter["z_label_ukuran"];
        $this->label_ukuran->AdvancedSearch->SearchCondition = @$filter["v_label_ukuran"];
        $this->label_ukuran->AdvancedSearch->SearchValue2 = @$filter["y_label_ukuran"];
        $this->label_ukuran->AdvancedSearch->SearchOperator2 = @$filter["w_label_ukuran"];
        $this->label_ukuran->AdvancedSearch->save();

        // Field infolabel
        $this->infolabel->AdvancedSearch->SearchValue = @$filter["x_infolabel"];
        $this->infolabel->AdvancedSearch->SearchOperator = @$filter["z_infolabel"];
        $this->infolabel->AdvancedSearch->SearchCondition = @$filter["v_infolabel"];
        $this->infolabel->AdvancedSearch->SearchValue2 = @$filter["y_infolabel"];
        $this->infolabel->AdvancedSearch->SearchOperator2 = @$filter["w_infolabel"];
        $this->infolabel->AdvancedSearch->save();

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

        // Field dibuatdi
        $this->dibuatdi->AdvancedSearch->SearchValue = @$filter["x_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchOperator = @$filter["z_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchCondition = @$filter["v_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchValue2 = @$filter["y_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchOperator2 = @$filter["w_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->save();

        // Field tanggal
        $this->tanggal->AdvancedSearch->SearchValue = @$filter["x_tanggal"];
        $this->tanggal->AdvancedSearch->SearchOperator = @$filter["z_tanggal"];
        $this->tanggal->AdvancedSearch->SearchCondition = @$filter["v_tanggal"];
        $this->tanggal->AdvancedSearch->SearchValue2 = @$filter["y_tanggal"];
        $this->tanggal->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal"];
        $this->tanggal->AdvancedSearch->save();

        // Field penerima
        $this->penerima->AdvancedSearch->SearchValue = @$filter["x_penerima"];
        $this->penerima->AdvancedSearch->SearchOperator = @$filter["z_penerima"];
        $this->penerima->AdvancedSearch->SearchCondition = @$filter["v_penerima"];
        $this->penerima->AdvancedSearch->SearchValue2 = @$filter["y_penerima"];
        $this->penerima->AdvancedSearch->SearchOperator2 = @$filter["w_penerima"];
        $this->penerima->AdvancedSearch->save();

        // Field createat
        $this->createat->AdvancedSearch->SearchValue = @$filter["x_createat"];
        $this->createat->AdvancedSearch->SearchOperator = @$filter["z_createat"];
        $this->createat->AdvancedSearch->SearchCondition = @$filter["v_createat"];
        $this->createat->AdvancedSearch->SearchValue2 = @$filter["y_createat"];
        $this->createat->AdvancedSearch->SearchOperator2 = @$filter["w_createat"];
        $this->createat->AdvancedSearch->save();

        // Field createby
        $this->createby->AdvancedSearch->SearchValue = @$filter["x_createby"];
        $this->createby->AdvancedSearch->SearchOperator = @$filter["z_createby"];
        $this->createby->AdvancedSearch->SearchCondition = @$filter["v_createby"];
        $this->createby->AdvancedSearch->SearchValue2 = @$filter["y_createby"];
        $this->createby->AdvancedSearch->SearchOperator2 = @$filter["w_createby"];
        $this->createby->AdvancedSearch->save();

        // Field statusdokumen
        $this->statusdokumen->AdvancedSearch->SearchValue = @$filter["x_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchOperator = @$filter["z_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchCondition = @$filter["v_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchValue2 = @$filter["y_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->SearchOperator2 = @$filter["w_statusdokumen"];
        $this->statusdokumen->AdvancedSearch->save();

        // Field update_at
        $this->update_at->AdvancedSearch->SearchValue = @$filter["x_update_at"];
        $this->update_at->AdvancedSearch->SearchOperator = @$filter["z_update_at"];
        $this->update_at->AdvancedSearch->SearchCondition = @$filter["v_update_at"];
        $this->update_at->AdvancedSearch->SearchValue2 = @$filter["y_update_at"];
        $this->update_at->AdvancedSearch->SearchOperator2 = @$filter["w_update_at"];
        $this->update_at->AdvancedSearch->save();

        // Field status_data
        $this->status_data->AdvancedSearch->SearchValue = @$filter["x_status_data"];
        $this->status_data->AdvancedSearch->SearchOperator = @$filter["z_status_data"];
        $this->status_data->AdvancedSearch->SearchCondition = @$filter["v_status_data"];
        $this->status_data->AdvancedSearch->SearchValue2 = @$filter["y_status_data"];
        $this->status_data->AdvancedSearch->SearchOperator2 = @$filter["w_status_data"];
        $this->status_data->AdvancedSearch->save();

        // Field harga_rnd
        $this->harga_rnd->AdvancedSearch->SearchValue = @$filter["x_harga_rnd"];
        $this->harga_rnd->AdvancedSearch->SearchOperator = @$filter["z_harga_rnd"];
        $this->harga_rnd->AdvancedSearch->SearchCondition = @$filter["v_harga_rnd"];
        $this->harga_rnd->AdvancedSearch->SearchValue2 = @$filter["y_harga_rnd"];
        $this->harga_rnd->AdvancedSearch->SearchOperator2 = @$filter["w_harga_rnd"];
        $this->harga_rnd->AdvancedSearch->save();

        // Field aplikasi_sediaan
        $this->aplikasi_sediaan->AdvancedSearch->SearchValue = @$filter["x_aplikasi_sediaan"];
        $this->aplikasi_sediaan->AdvancedSearch->SearchOperator = @$filter["z_aplikasi_sediaan"];
        $this->aplikasi_sediaan->AdvancedSearch->SearchCondition = @$filter["v_aplikasi_sediaan"];
        $this->aplikasi_sediaan->AdvancedSearch->SearchValue2 = @$filter["y_aplikasi_sediaan"];
        $this->aplikasi_sediaan->AdvancedSearch->SearchOperator2 = @$filter["w_aplikasi_sediaan"];
        $this->aplikasi_sediaan->AdvancedSearch->save();

        // Field hu_hrg_isi
        $this->hu_hrg_isi->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_isi"];
        $this->hu_hrg_isi->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_isi"];
        $this->hu_hrg_isi->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_isi"];
        $this->hu_hrg_isi->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_isi"];
        $this->hu_hrg_isi->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_isi"];
        $this->hu_hrg_isi->AdvancedSearch->save();

        // Field hu_hrg_isi_pro
        $this->hu_hrg_isi_pro->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_isi_pro"];
        $this->hu_hrg_isi_pro->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_isi_pro"];
        $this->hu_hrg_isi_pro->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_isi_pro"];
        $this->hu_hrg_isi_pro->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_isi_pro"];
        $this->hu_hrg_isi_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_isi_pro"];
        $this->hu_hrg_isi_pro->AdvancedSearch->save();

        // Field hu_hrg_kms_primer
        $this->hu_hrg_kms_primer->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_kms_primer"];
        $this->hu_hrg_kms_primer->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_kms_primer"];
        $this->hu_hrg_kms_primer->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_kms_primer"];
        $this->hu_hrg_kms_primer->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_kms_primer"];
        $this->hu_hrg_kms_primer->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_kms_primer"];
        $this->hu_hrg_kms_primer->AdvancedSearch->save();

        // Field hu_hrg_kms_primer_pro
        $this->hu_hrg_kms_primer_pro->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_kms_primer_pro"];
        $this->hu_hrg_kms_primer_pro->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_kms_primer_pro"];
        $this->hu_hrg_kms_primer_pro->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_kms_primer_pro"];
        $this->hu_hrg_kms_primer_pro->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_kms_primer_pro"];
        $this->hu_hrg_kms_primer_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_kms_primer_pro"];
        $this->hu_hrg_kms_primer_pro->AdvancedSearch->save();

        // Field hu_hrg_kms_sekunder
        $this->hu_hrg_kms_sekunder->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_kms_sekunder"];
        $this->hu_hrg_kms_sekunder->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_kms_sekunder"];
        $this->hu_hrg_kms_sekunder->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_kms_sekunder"];
        $this->hu_hrg_kms_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_kms_sekunder"];
        $this->hu_hrg_kms_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_kms_sekunder"];
        $this->hu_hrg_kms_sekunder->AdvancedSearch->save();

        // Field hu_hrg_kms_sekunder_pro
        $this->hu_hrg_kms_sekunder_pro->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_kms_sekunder_pro"];
        $this->hu_hrg_kms_sekunder_pro->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_kms_sekunder_pro"];
        $this->hu_hrg_kms_sekunder_pro->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_kms_sekunder_pro"];
        $this->hu_hrg_kms_sekunder_pro->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_kms_sekunder_pro"];
        $this->hu_hrg_kms_sekunder_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_kms_sekunder_pro"];
        $this->hu_hrg_kms_sekunder_pro->AdvancedSearch->save();

        // Field hu_hrg_label
        $this->hu_hrg_label->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_label"];
        $this->hu_hrg_label->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_label"];
        $this->hu_hrg_label->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_label"];
        $this->hu_hrg_label->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_label"];
        $this->hu_hrg_label->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_label"];
        $this->hu_hrg_label->AdvancedSearch->save();

        // Field hu_hrg_label_pro
        $this->hu_hrg_label_pro->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_label_pro"];
        $this->hu_hrg_label_pro->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_label_pro"];
        $this->hu_hrg_label_pro->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_label_pro"];
        $this->hu_hrg_label_pro->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_label_pro"];
        $this->hu_hrg_label_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_label_pro"];
        $this->hu_hrg_label_pro->AdvancedSearch->save();

        // Field hu_hrg_total
        $this->hu_hrg_total->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_total"];
        $this->hu_hrg_total->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_total"];
        $this->hu_hrg_total->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_total"];
        $this->hu_hrg_total->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_total"];
        $this->hu_hrg_total->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_total"];
        $this->hu_hrg_total->AdvancedSearch->save();

        // Field hu_hrg_total_pro
        $this->hu_hrg_total_pro->AdvancedSearch->SearchValue = @$filter["x_hu_hrg_total_pro"];
        $this->hu_hrg_total_pro->AdvancedSearch->SearchOperator = @$filter["z_hu_hrg_total_pro"];
        $this->hu_hrg_total_pro->AdvancedSearch->SearchCondition = @$filter["v_hu_hrg_total_pro"];
        $this->hu_hrg_total_pro->AdvancedSearch->SearchValue2 = @$filter["y_hu_hrg_total_pro"];
        $this->hu_hrg_total_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hu_hrg_total_pro"];
        $this->hu_hrg_total_pro->AdvancedSearch->save();

        // Field hl_hrg_isi
        $this->hl_hrg_isi->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_isi"];
        $this->hl_hrg_isi->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_isi"];
        $this->hl_hrg_isi->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_isi"];
        $this->hl_hrg_isi->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_isi"];
        $this->hl_hrg_isi->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_isi"];
        $this->hl_hrg_isi->AdvancedSearch->save();

        // Field hl_hrg_isi_pro
        $this->hl_hrg_isi_pro->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_isi_pro"];
        $this->hl_hrg_isi_pro->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_isi_pro"];
        $this->hl_hrg_isi_pro->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_isi_pro"];
        $this->hl_hrg_isi_pro->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_isi_pro"];
        $this->hl_hrg_isi_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_isi_pro"];
        $this->hl_hrg_isi_pro->AdvancedSearch->save();

        // Field hl_hrg_kms_primer
        $this->hl_hrg_kms_primer->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_kms_primer"];
        $this->hl_hrg_kms_primer->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_kms_primer"];
        $this->hl_hrg_kms_primer->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_kms_primer"];
        $this->hl_hrg_kms_primer->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_kms_primer"];
        $this->hl_hrg_kms_primer->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_kms_primer"];
        $this->hl_hrg_kms_primer->AdvancedSearch->save();

        // Field hl_hrg_kms_primer_pro
        $this->hl_hrg_kms_primer_pro->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_kms_primer_pro"];
        $this->hl_hrg_kms_primer_pro->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_kms_primer_pro"];
        $this->hl_hrg_kms_primer_pro->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_kms_primer_pro"];
        $this->hl_hrg_kms_primer_pro->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_kms_primer_pro"];
        $this->hl_hrg_kms_primer_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_kms_primer_pro"];
        $this->hl_hrg_kms_primer_pro->AdvancedSearch->save();

        // Field hl_hrg_kms_sekunder
        $this->hl_hrg_kms_sekunder->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_kms_sekunder"];
        $this->hl_hrg_kms_sekunder->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_kms_sekunder"];
        $this->hl_hrg_kms_sekunder->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_kms_sekunder"];
        $this->hl_hrg_kms_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_kms_sekunder"];
        $this->hl_hrg_kms_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_kms_sekunder"];
        $this->hl_hrg_kms_sekunder->AdvancedSearch->save();

        // Field hl_hrg_kms_sekunder_pro
        $this->hl_hrg_kms_sekunder_pro->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_kms_sekunder_pro"];
        $this->hl_hrg_kms_sekunder_pro->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_kms_sekunder_pro"];
        $this->hl_hrg_kms_sekunder_pro->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_kms_sekunder_pro"];
        $this->hl_hrg_kms_sekunder_pro->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_kms_sekunder_pro"];
        $this->hl_hrg_kms_sekunder_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_kms_sekunder_pro"];
        $this->hl_hrg_kms_sekunder_pro->AdvancedSearch->save();

        // Field hl_hrg_label
        $this->hl_hrg_label->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_label"];
        $this->hl_hrg_label->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_label"];
        $this->hl_hrg_label->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_label"];
        $this->hl_hrg_label->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_label"];
        $this->hl_hrg_label->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_label"];
        $this->hl_hrg_label->AdvancedSearch->save();

        // Field hl_hrg_label_pro
        $this->hl_hrg_label_pro->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_label_pro"];
        $this->hl_hrg_label_pro->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_label_pro"];
        $this->hl_hrg_label_pro->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_label_pro"];
        $this->hl_hrg_label_pro->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_label_pro"];
        $this->hl_hrg_label_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_label_pro"];
        $this->hl_hrg_label_pro->AdvancedSearch->save();

        // Field hl_hrg_total
        $this->hl_hrg_total->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_total"];
        $this->hl_hrg_total->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_total"];
        $this->hl_hrg_total->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_total"];
        $this->hl_hrg_total->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_total"];
        $this->hl_hrg_total->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_total"];
        $this->hl_hrg_total->AdvancedSearch->save();

        // Field hl_hrg_total_pro
        $this->hl_hrg_total_pro->AdvancedSearch->SearchValue = @$filter["x_hl_hrg_total_pro"];
        $this->hl_hrg_total_pro->AdvancedSearch->SearchOperator = @$filter["z_hl_hrg_total_pro"];
        $this->hl_hrg_total_pro->AdvancedSearch->SearchCondition = @$filter["v_hl_hrg_total_pro"];
        $this->hl_hrg_total_pro->AdvancedSearch->SearchValue2 = @$filter["y_hl_hrg_total_pro"];
        $this->hl_hrg_total_pro->AdvancedSearch->SearchOperator2 = @$filter["w_hl_hrg_total_pro"];
        $this->hl_hrg_total_pro->AdvancedSearch->save();

        // Field bs_bahan_aktif_tick
        $this->bs_bahan_aktif_tick->AdvancedSearch->SearchValue = @$filter["x_bs_bahan_aktif_tick"];
        $this->bs_bahan_aktif_tick->AdvancedSearch->SearchOperator = @$filter["z_bs_bahan_aktif_tick"];
        $this->bs_bahan_aktif_tick->AdvancedSearch->SearchCondition = @$filter["v_bs_bahan_aktif_tick"];
        $this->bs_bahan_aktif_tick->AdvancedSearch->SearchValue2 = @$filter["y_bs_bahan_aktif_tick"];
        $this->bs_bahan_aktif_tick->AdvancedSearch->SearchOperator2 = @$filter["w_bs_bahan_aktif_tick"];
        $this->bs_bahan_aktif_tick->AdvancedSearch->save();

        // Field bs_bahan_aktif
        $this->bs_bahan_aktif->AdvancedSearch->SearchValue = @$filter["x_bs_bahan_aktif"];
        $this->bs_bahan_aktif->AdvancedSearch->SearchOperator = @$filter["z_bs_bahan_aktif"];
        $this->bs_bahan_aktif->AdvancedSearch->SearchCondition = @$filter["v_bs_bahan_aktif"];
        $this->bs_bahan_aktif->AdvancedSearch->SearchValue2 = @$filter["y_bs_bahan_aktif"];
        $this->bs_bahan_aktif->AdvancedSearch->SearchOperator2 = @$filter["w_bs_bahan_aktif"];
        $this->bs_bahan_aktif->AdvancedSearch->save();

        // Field bs_bahan_lain
        $this->bs_bahan_lain->AdvancedSearch->SearchValue = @$filter["x_bs_bahan_lain"];
        $this->bs_bahan_lain->AdvancedSearch->SearchOperator = @$filter["z_bs_bahan_lain"];
        $this->bs_bahan_lain->AdvancedSearch->SearchCondition = @$filter["v_bs_bahan_lain"];
        $this->bs_bahan_lain->AdvancedSearch->SearchValue2 = @$filter["y_bs_bahan_lain"];
        $this->bs_bahan_lain->AdvancedSearch->SearchOperator2 = @$filter["w_bs_bahan_lain"];
        $this->bs_bahan_lain->AdvancedSearch->save();

        // Field bs_parfum
        $this->bs_parfum->AdvancedSearch->SearchValue = @$filter["x_bs_parfum"];
        $this->bs_parfum->AdvancedSearch->SearchOperator = @$filter["z_bs_parfum"];
        $this->bs_parfum->AdvancedSearch->SearchCondition = @$filter["v_bs_parfum"];
        $this->bs_parfum->AdvancedSearch->SearchValue2 = @$filter["y_bs_parfum"];
        $this->bs_parfum->AdvancedSearch->SearchOperator2 = @$filter["w_bs_parfum"];
        $this->bs_parfum->AdvancedSearch->save();

        // Field bs_estetika
        $this->bs_estetika->AdvancedSearch->SearchValue = @$filter["x_bs_estetika"];
        $this->bs_estetika->AdvancedSearch->SearchOperator = @$filter["z_bs_estetika"];
        $this->bs_estetika->AdvancedSearch->SearchCondition = @$filter["v_bs_estetika"];
        $this->bs_estetika->AdvancedSearch->SearchValue2 = @$filter["y_bs_estetika"];
        $this->bs_estetika->AdvancedSearch->SearchOperator2 = @$filter["w_bs_estetika"];
        $this->bs_estetika->AdvancedSearch->save();

        // Field bs_kms_wadah
        $this->bs_kms_wadah->AdvancedSearch->SearchValue = @$filter["x_bs_kms_wadah"];
        $this->bs_kms_wadah->AdvancedSearch->SearchOperator = @$filter["z_bs_kms_wadah"];
        $this->bs_kms_wadah->AdvancedSearch->SearchCondition = @$filter["v_bs_kms_wadah"];
        $this->bs_kms_wadah->AdvancedSearch->SearchValue2 = @$filter["y_bs_kms_wadah"];
        $this->bs_kms_wadah->AdvancedSearch->SearchOperator2 = @$filter["w_bs_kms_wadah"];
        $this->bs_kms_wadah->AdvancedSearch->save();

        // Field bs_kms_tutup
        $this->bs_kms_tutup->AdvancedSearch->SearchValue = @$filter["x_bs_kms_tutup"];
        $this->bs_kms_tutup->AdvancedSearch->SearchOperator = @$filter["z_bs_kms_tutup"];
        $this->bs_kms_tutup->AdvancedSearch->SearchCondition = @$filter["v_bs_kms_tutup"];
        $this->bs_kms_tutup->AdvancedSearch->SearchValue2 = @$filter["y_bs_kms_tutup"];
        $this->bs_kms_tutup->AdvancedSearch->SearchOperator2 = @$filter["w_bs_kms_tutup"];
        $this->bs_kms_tutup->AdvancedSearch->save();

        // Field bs_kms_sekunder
        $this->bs_kms_sekunder->AdvancedSearch->SearchValue = @$filter["x_bs_kms_sekunder"];
        $this->bs_kms_sekunder->AdvancedSearch->SearchOperator = @$filter["z_bs_kms_sekunder"];
        $this->bs_kms_sekunder->AdvancedSearch->SearchCondition = @$filter["v_bs_kms_sekunder"];
        $this->bs_kms_sekunder->AdvancedSearch->SearchValue2 = @$filter["y_bs_kms_sekunder"];
        $this->bs_kms_sekunder->AdvancedSearch->SearchOperator2 = @$filter["w_bs_kms_sekunder"];
        $this->bs_kms_sekunder->AdvancedSearch->save();

        // Field bs_label_desain
        $this->bs_label_desain->AdvancedSearch->SearchValue = @$filter["x_bs_label_desain"];
        $this->bs_label_desain->AdvancedSearch->SearchOperator = @$filter["z_bs_label_desain"];
        $this->bs_label_desain->AdvancedSearch->SearchCondition = @$filter["v_bs_label_desain"];
        $this->bs_label_desain->AdvancedSearch->SearchValue2 = @$filter["y_bs_label_desain"];
        $this->bs_label_desain->AdvancedSearch->SearchOperator2 = @$filter["w_bs_label_desain"];
        $this->bs_label_desain->AdvancedSearch->save();

        // Field bs_label_cetak
        $this->bs_label_cetak->AdvancedSearch->SearchValue = @$filter["x_bs_label_cetak"];
        $this->bs_label_cetak->AdvancedSearch->SearchOperator = @$filter["z_bs_label_cetak"];
        $this->bs_label_cetak->AdvancedSearch->SearchCondition = @$filter["v_bs_label_cetak"];
        $this->bs_label_cetak->AdvancedSearch->SearchValue2 = @$filter["y_bs_label_cetak"];
        $this->bs_label_cetak->AdvancedSearch->SearchOperator2 = @$filter["w_bs_label_cetak"];
        $this->bs_label_cetak->AdvancedSearch->save();

        // Field bs_label_lain
        $this->bs_label_lain->AdvancedSearch->SearchValue = @$filter["x_bs_label_lain"];
        $this->bs_label_lain->AdvancedSearch->SearchOperator = @$filter["z_bs_label_lain"];
        $this->bs_label_lain->AdvancedSearch->SearchCondition = @$filter["v_bs_label_lain"];
        $this->bs_label_lain->AdvancedSearch->SearchValue2 = @$filter["y_bs_label_lain"];
        $this->bs_label_lain->AdvancedSearch->SearchOperator2 = @$filter["w_bs_label_lain"];
        $this->bs_label_lain->AdvancedSearch->save();

        // Field dlv_pickup
        $this->dlv_pickup->AdvancedSearch->SearchValue = @$filter["x_dlv_pickup"];
        $this->dlv_pickup->AdvancedSearch->SearchOperator = @$filter["z_dlv_pickup"];
        $this->dlv_pickup->AdvancedSearch->SearchCondition = @$filter["v_dlv_pickup"];
        $this->dlv_pickup->AdvancedSearch->SearchValue2 = @$filter["y_dlv_pickup"];
        $this->dlv_pickup->AdvancedSearch->SearchOperator2 = @$filter["w_dlv_pickup"];
        $this->dlv_pickup->AdvancedSearch->save();

        // Field dlv_singlepoint
        $this->dlv_singlepoint->AdvancedSearch->SearchValue = @$filter["x_dlv_singlepoint"];
        $this->dlv_singlepoint->AdvancedSearch->SearchOperator = @$filter["z_dlv_singlepoint"];
        $this->dlv_singlepoint->AdvancedSearch->SearchCondition = @$filter["v_dlv_singlepoint"];
        $this->dlv_singlepoint->AdvancedSearch->SearchValue2 = @$filter["y_dlv_singlepoint"];
        $this->dlv_singlepoint->AdvancedSearch->SearchOperator2 = @$filter["w_dlv_singlepoint"];
        $this->dlv_singlepoint->AdvancedSearch->save();

        // Field dlv_multipoint
        $this->dlv_multipoint->AdvancedSearch->SearchValue = @$filter["x_dlv_multipoint"];
        $this->dlv_multipoint->AdvancedSearch->SearchOperator = @$filter["z_dlv_multipoint"];
        $this->dlv_multipoint->AdvancedSearch->SearchCondition = @$filter["v_dlv_multipoint"];
        $this->dlv_multipoint->AdvancedSearch->SearchValue2 = @$filter["y_dlv_multipoint"];
        $this->dlv_multipoint->AdvancedSearch->SearchOperator2 = @$filter["w_dlv_multipoint"];
        $this->dlv_multipoint->AdvancedSearch->save();

        // Field dlv_multipoint_jml
        $this->dlv_multipoint_jml->AdvancedSearch->SearchValue = @$filter["x_dlv_multipoint_jml"];
        $this->dlv_multipoint_jml->AdvancedSearch->SearchOperator = @$filter["z_dlv_multipoint_jml"];
        $this->dlv_multipoint_jml->AdvancedSearch->SearchCondition = @$filter["v_dlv_multipoint_jml"];
        $this->dlv_multipoint_jml->AdvancedSearch->SearchValue2 = @$filter["y_dlv_multipoint_jml"];
        $this->dlv_multipoint_jml->AdvancedSearch->SearchOperator2 = @$filter["w_dlv_multipoint_jml"];
        $this->dlv_multipoint_jml->AdvancedSearch->save();

        // Field dlv_term_lain
        $this->dlv_term_lain->AdvancedSearch->SearchValue = @$filter["x_dlv_term_lain"];
        $this->dlv_term_lain->AdvancedSearch->SearchOperator = @$filter["z_dlv_term_lain"];
        $this->dlv_term_lain->AdvancedSearch->SearchCondition = @$filter["v_dlv_term_lain"];
        $this->dlv_term_lain->AdvancedSearch->SearchValue2 = @$filter["y_dlv_term_lain"];
        $this->dlv_term_lain->AdvancedSearch->SearchOperator2 = @$filter["w_dlv_term_lain"];
        $this->dlv_term_lain->AdvancedSearch->save();

        // Field catatan_khusus
        $this->catatan_khusus->AdvancedSearch->SearchValue = @$filter["x_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchOperator = @$filter["z_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchCondition = @$filter["v_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchValue2 = @$filter["y_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->SearchOperator2 = @$filter["w_catatan_khusus"];
        $this->catatan_khusus->AdvancedSearch->save();

        // Field aju_tgl
        $this->aju_tgl->AdvancedSearch->SearchValue = @$filter["x_aju_tgl"];
        $this->aju_tgl->AdvancedSearch->SearchOperator = @$filter["z_aju_tgl"];
        $this->aju_tgl->AdvancedSearch->SearchCondition = @$filter["v_aju_tgl"];
        $this->aju_tgl->AdvancedSearch->SearchValue2 = @$filter["y_aju_tgl"];
        $this->aju_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_aju_tgl"];
        $this->aju_tgl->AdvancedSearch->save();

        // Field aju_oleh
        $this->aju_oleh->AdvancedSearch->SearchValue = @$filter["x_aju_oleh"];
        $this->aju_oleh->AdvancedSearch->SearchOperator = @$filter["z_aju_oleh"];
        $this->aju_oleh->AdvancedSearch->SearchCondition = @$filter["v_aju_oleh"];
        $this->aju_oleh->AdvancedSearch->SearchValue2 = @$filter["y_aju_oleh"];
        $this->aju_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_aju_oleh"];
        $this->aju_oleh->AdvancedSearch->save();

        // Field proses_tgl
        $this->proses_tgl->AdvancedSearch->SearchValue = @$filter["x_proses_tgl"];
        $this->proses_tgl->AdvancedSearch->SearchOperator = @$filter["z_proses_tgl"];
        $this->proses_tgl->AdvancedSearch->SearchCondition = @$filter["v_proses_tgl"];
        $this->proses_tgl->AdvancedSearch->SearchValue2 = @$filter["y_proses_tgl"];
        $this->proses_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_proses_tgl"];
        $this->proses_tgl->AdvancedSearch->save();

        // Field proses_oleh
        $this->proses_oleh->AdvancedSearch->SearchValue = @$filter["x_proses_oleh"];
        $this->proses_oleh->AdvancedSearch->SearchOperator = @$filter["z_proses_oleh"];
        $this->proses_oleh->AdvancedSearch->SearchCondition = @$filter["v_proses_oleh"];
        $this->proses_oleh->AdvancedSearch->SearchValue2 = @$filter["y_proses_oleh"];
        $this->proses_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_proses_oleh"];
        $this->proses_oleh->AdvancedSearch->save();

        // Field revisi_tgl
        $this->revisi_tgl->AdvancedSearch->SearchValue = @$filter["x_revisi_tgl"];
        $this->revisi_tgl->AdvancedSearch->SearchOperator = @$filter["z_revisi_tgl"];
        $this->revisi_tgl->AdvancedSearch->SearchCondition = @$filter["v_revisi_tgl"];
        $this->revisi_tgl->AdvancedSearch->SearchValue2 = @$filter["y_revisi_tgl"];
        $this->revisi_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_revisi_tgl"];
        $this->revisi_tgl->AdvancedSearch->save();

        // Field revisi_oleh
        $this->revisi_oleh->AdvancedSearch->SearchValue = @$filter["x_revisi_oleh"];
        $this->revisi_oleh->AdvancedSearch->SearchOperator = @$filter["z_revisi_oleh"];
        $this->revisi_oleh->AdvancedSearch->SearchCondition = @$filter["v_revisi_oleh"];
        $this->revisi_oleh->AdvancedSearch->SearchValue2 = @$filter["y_revisi_oleh"];
        $this->revisi_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_revisi_oleh"];
        $this->revisi_oleh->AdvancedSearch->save();

        // Field revisi_akun_tgl
        $this->revisi_akun_tgl->AdvancedSearch->SearchValue = @$filter["x_revisi_akun_tgl"];
        $this->revisi_akun_tgl->AdvancedSearch->SearchOperator = @$filter["z_revisi_akun_tgl"];
        $this->revisi_akun_tgl->AdvancedSearch->SearchCondition = @$filter["v_revisi_akun_tgl"];
        $this->revisi_akun_tgl->AdvancedSearch->SearchValue2 = @$filter["y_revisi_akun_tgl"];
        $this->revisi_akun_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_revisi_akun_tgl"];
        $this->revisi_akun_tgl->AdvancedSearch->save();

        // Field revisi_akun_oleh
        $this->revisi_akun_oleh->AdvancedSearch->SearchValue = @$filter["x_revisi_akun_oleh"];
        $this->revisi_akun_oleh->AdvancedSearch->SearchOperator = @$filter["z_revisi_akun_oleh"];
        $this->revisi_akun_oleh->AdvancedSearch->SearchCondition = @$filter["v_revisi_akun_oleh"];
        $this->revisi_akun_oleh->AdvancedSearch->SearchValue2 = @$filter["y_revisi_akun_oleh"];
        $this->revisi_akun_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_revisi_akun_oleh"];
        $this->revisi_akun_oleh->AdvancedSearch->save();

        // Field revisi_rnd_tgl
        $this->revisi_rnd_tgl->AdvancedSearch->SearchValue = @$filter["x_revisi_rnd_tgl"];
        $this->revisi_rnd_tgl->AdvancedSearch->SearchOperator = @$filter["z_revisi_rnd_tgl"];
        $this->revisi_rnd_tgl->AdvancedSearch->SearchCondition = @$filter["v_revisi_rnd_tgl"];
        $this->revisi_rnd_tgl->AdvancedSearch->SearchValue2 = @$filter["y_revisi_rnd_tgl"];
        $this->revisi_rnd_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_revisi_rnd_tgl"];
        $this->revisi_rnd_tgl->AdvancedSearch->save();

        // Field revisi_rnd_oleh
        $this->revisi_rnd_oleh->AdvancedSearch->SearchValue = @$filter["x_revisi_rnd_oleh"];
        $this->revisi_rnd_oleh->AdvancedSearch->SearchOperator = @$filter["z_revisi_rnd_oleh"];
        $this->revisi_rnd_oleh->AdvancedSearch->SearchCondition = @$filter["v_revisi_rnd_oleh"];
        $this->revisi_rnd_oleh->AdvancedSearch->SearchValue2 = @$filter["y_revisi_rnd_oleh"];
        $this->revisi_rnd_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_revisi_rnd_oleh"];
        $this->revisi_rnd_oleh->AdvancedSearch->save();

        // Field rnd_tgl
        $this->rnd_tgl->AdvancedSearch->SearchValue = @$filter["x_rnd_tgl"];
        $this->rnd_tgl->AdvancedSearch->SearchOperator = @$filter["z_rnd_tgl"];
        $this->rnd_tgl->AdvancedSearch->SearchCondition = @$filter["v_rnd_tgl"];
        $this->rnd_tgl->AdvancedSearch->SearchValue2 = @$filter["y_rnd_tgl"];
        $this->rnd_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_rnd_tgl"];
        $this->rnd_tgl->AdvancedSearch->save();

        // Field rnd_oleh
        $this->rnd_oleh->AdvancedSearch->SearchValue = @$filter["x_rnd_oleh"];
        $this->rnd_oleh->AdvancedSearch->SearchOperator = @$filter["z_rnd_oleh"];
        $this->rnd_oleh->AdvancedSearch->SearchCondition = @$filter["v_rnd_oleh"];
        $this->rnd_oleh->AdvancedSearch->SearchValue2 = @$filter["y_rnd_oleh"];
        $this->rnd_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_rnd_oleh"];
        $this->rnd_oleh->AdvancedSearch->save();

        // Field ap_tgl
        $this->ap_tgl->AdvancedSearch->SearchValue = @$filter["x_ap_tgl"];
        $this->ap_tgl->AdvancedSearch->SearchOperator = @$filter["z_ap_tgl"];
        $this->ap_tgl->AdvancedSearch->SearchCondition = @$filter["v_ap_tgl"];
        $this->ap_tgl->AdvancedSearch->SearchValue2 = @$filter["y_ap_tgl"];
        $this->ap_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_ap_tgl"];
        $this->ap_tgl->AdvancedSearch->save();

        // Field ap_oleh
        $this->ap_oleh->AdvancedSearch->SearchValue = @$filter["x_ap_oleh"];
        $this->ap_oleh->AdvancedSearch->SearchOperator = @$filter["z_ap_oleh"];
        $this->ap_oleh->AdvancedSearch->SearchCondition = @$filter["v_ap_oleh"];
        $this->ap_oleh->AdvancedSearch->SearchValue2 = @$filter["y_ap_oleh"];
        $this->ap_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_ap_oleh"];
        $this->ap_oleh->AdvancedSearch->save();

        // Field batal_tgl
        $this->batal_tgl->AdvancedSearch->SearchValue = @$filter["x_batal_tgl"];
        $this->batal_tgl->AdvancedSearch->SearchOperator = @$filter["z_batal_tgl"];
        $this->batal_tgl->AdvancedSearch->SearchCondition = @$filter["v_batal_tgl"];
        $this->batal_tgl->AdvancedSearch->SearchValue2 = @$filter["y_batal_tgl"];
        $this->batal_tgl->AdvancedSearch->SearchOperator2 = @$filter["w_batal_tgl"];
        $this->batal_tgl->AdvancedSearch->save();

        // Field batal_oleh
        $this->batal_oleh->AdvancedSearch->SearchValue = @$filter["x_batal_oleh"];
        $this->batal_oleh->AdvancedSearch->SearchOperator = @$filter["z_batal_oleh"];
        $this->batal_oleh->AdvancedSearch->SearchCondition = @$filter["v_batal_oleh"];
        $this->batal_oleh->AdvancedSearch->SearchValue2 = @$filter["y_batal_oleh"];
        $this->batal_oleh->AdvancedSearch->SearchOperator2 = @$filter["w_batal_oleh"];
        $this->batal_oleh->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->cpo_jenis, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ordernum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->order_kode, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->produk_fungsi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->produk_kualitas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->produk_campaign, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasan_satuan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->perushnama, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->perushalamat, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->perushcp, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->perushjabatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->perushphone, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->perushmobile, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bencmark, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kategoriproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jenisproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bentuksediaan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->sediaan_ukuran_satuan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->produk_viskositas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->konsepproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->fragrance, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->aroma, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bahanaktif, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->warna, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->produk_warna_jenis, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->aksesoris, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->produk_lainlain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->statusproduk, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->parfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->catatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->rencanakemasan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->keterangan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->jenistutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->catatanpackaging, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->infopackaging, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->desainprodukkemasan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->desaindiinginkan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->mereknotifikasi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kategoristatus, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasan_ukuran_satuan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->notifikasicatatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->label_ukuran, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->infolabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelkualitas, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelposisi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->labelcatatan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dibuatdi, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->statusdokumen, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->status_data, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->aplikasi_sediaan, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_bahan_aktif_tick, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_bahan_aktif, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_bahan_lain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_parfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_estetika, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_kms_wadah, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_kms_tutup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_kms_sekunder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_label_desain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_label_cetak, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->bs_label_lain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dlv_pickup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dlv_singlepoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dlv_multipoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dlv_multipoint_jml, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dlv_term_lain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->catatan_khusus, $arKeywords, $type);
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
            $this->updateSort($this->cpo_jenis); // cpo_jenis
            $this->updateSort($this->ordernum); // ordernum
            $this->updateSort($this->order_kode); // order_kode
            $this->updateSort($this->orderterimatgl); // orderterimatgl
            $this->updateSort($this->produk_fungsi); // produk_fungsi
            $this->updateSort($this->produk_kualitas); // produk_kualitas
            $this->updateSort($this->produk_campaign); // produk_campaign
            $this->updateSort($this->kemasan_satuan); // kemasan_satuan
            $this->updateSort($this->ordertgl); // ordertgl
            $this->updateSort($this->custcode); // custcode
            $this->updateSort($this->perushnama); // perushnama
            $this->updateSort($this->perushalamat); // perushalamat
            $this->updateSort($this->perushcp); // perushcp
            $this->updateSort($this->perushjabatan); // perushjabatan
            $this->updateSort($this->perushphone); // perushphone
            $this->updateSort($this->perushmobile); // perushmobile
            $this->updateSort($this->bencmark); // bencmark
            $this->updateSort($this->kategoriproduk); // kategoriproduk
            $this->updateSort($this->jenisproduk); // jenisproduk
            $this->updateSort($this->bentuksediaan); // bentuksediaan
            $this->updateSort($this->sediaan_ukuran); // sediaan_ukuran
            $this->updateSort($this->sediaan_ukuran_satuan); // sediaan_ukuran_satuan
            $this->updateSort($this->produk_viskositas); // produk_viskositas
            $this->updateSort($this->konsepproduk); // konsepproduk
            $this->updateSort($this->fragrance); // fragrance
            $this->updateSort($this->aroma); // aroma
            $this->updateSort($this->bahanaktif); // bahanaktif
            $this->updateSort($this->warna); // warna
            $this->updateSort($this->produk_warna_jenis); // produk_warna_jenis
            $this->updateSort($this->aksesoris); // aksesoris
            $this->updateSort($this->statusproduk); // statusproduk
            $this->updateSort($this->parfum); // parfum
            $this->updateSort($this->catatan); // catatan
            $this->updateSort($this->rencanakemasan); // rencanakemasan
            $this->updateSort($this->ekspetasiharga); // ekspetasiharga
            $this->updateSort($this->kemasan); // kemasan
            $this->updateSort($this->volume); // volume
            $this->updateSort($this->jenistutup); // jenistutup
            $this->updateSort($this->infopackaging); // infopackaging
            $this->updateSort($this->ukuran); // ukuran
            $this->updateSort($this->desainprodukkemasan); // desainprodukkemasan
            $this->updateSort($this->desaindiinginkan); // desaindiinginkan
            $this->updateSort($this->mereknotifikasi); // mereknotifikasi
            $this->updateSort($this->kategoristatus); // kategoristatus
            $this->updateSort($this->kemasan_ukuran_satuan); // kemasan_ukuran_satuan
            $this->updateSort($this->infolabel); // infolabel
            $this->updateSort($this->labelkualitas); // labelkualitas
            $this->updateSort($this->labelposisi); // labelposisi
            $this->updateSort($this->dibuatdi); // dibuatdi
            $this->updateSort($this->tanggal); // tanggal
            $this->updateSort($this->penerima); // penerima
            $this->updateSort($this->createat); // createat
            $this->updateSort($this->createby); // createby
            $this->updateSort($this->statusdokumen); // statusdokumen
            $this->updateSort($this->update_at); // update_at
            $this->updateSort($this->status_data); // status_data
            $this->updateSort($this->harga_rnd); // harga_rnd
            $this->updateSort($this->aplikasi_sediaan); // aplikasi_sediaan
            $this->updateSort($this->hu_hrg_isi); // hu_hrg_isi
            $this->updateSort($this->hu_hrg_isi_pro); // hu_hrg_isi_pro
            $this->updateSort($this->hu_hrg_kms_primer); // hu_hrg_kms_primer
            $this->updateSort($this->hu_hrg_kms_primer_pro); // hu_hrg_kms_primer_pro
            $this->updateSort($this->hu_hrg_kms_sekunder); // hu_hrg_kms_sekunder
            $this->updateSort($this->hu_hrg_kms_sekunder_pro); // hu_hrg_kms_sekunder_pro
            $this->updateSort($this->hu_hrg_label); // hu_hrg_label
            $this->updateSort($this->hu_hrg_label_pro); // hu_hrg_label_pro
            $this->updateSort($this->hu_hrg_total); // hu_hrg_total
            $this->updateSort($this->hu_hrg_total_pro); // hu_hrg_total_pro
            $this->updateSort($this->hl_hrg_isi); // hl_hrg_isi
            $this->updateSort($this->hl_hrg_isi_pro); // hl_hrg_isi_pro
            $this->updateSort($this->hl_hrg_kms_primer); // hl_hrg_kms_primer
            $this->updateSort($this->hl_hrg_kms_primer_pro); // hl_hrg_kms_primer_pro
            $this->updateSort($this->hl_hrg_kms_sekunder); // hl_hrg_kms_sekunder
            $this->updateSort($this->hl_hrg_kms_sekunder_pro); // hl_hrg_kms_sekunder_pro
            $this->updateSort($this->hl_hrg_label); // hl_hrg_label
            $this->updateSort($this->hl_hrg_label_pro); // hl_hrg_label_pro
            $this->updateSort($this->hl_hrg_total); // hl_hrg_total
            $this->updateSort($this->hl_hrg_total_pro); // hl_hrg_total_pro
            $this->updateSort($this->bs_bahan_aktif_tick); // bs_bahan_aktif_tick
            $this->updateSort($this->aju_tgl); // aju_tgl
            $this->updateSort($this->aju_oleh); // aju_oleh
            $this->updateSort($this->proses_tgl); // proses_tgl
            $this->updateSort($this->proses_oleh); // proses_oleh
            $this->updateSort($this->revisi_tgl); // revisi_tgl
            $this->updateSort($this->revisi_oleh); // revisi_oleh
            $this->updateSort($this->revisi_akun_tgl); // revisi_akun_tgl
            $this->updateSort($this->revisi_akun_oleh); // revisi_akun_oleh
            $this->updateSort($this->revisi_rnd_tgl); // revisi_rnd_tgl
            $this->updateSort($this->revisi_rnd_oleh); // revisi_rnd_oleh
            $this->updateSort($this->rnd_tgl); // rnd_tgl
            $this->updateSort($this->rnd_oleh); // rnd_oleh
            $this->updateSort($this->ap_tgl); // ap_tgl
            $this->updateSort($this->ap_oleh); // ap_oleh
            $this->updateSort($this->batal_tgl); // batal_tgl
            $this->updateSort($this->batal_oleh); // batal_oleh
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
                $this->cpo_jenis->setSort("");
                $this->ordernum->setSort("");
                $this->order_kode->setSort("");
                $this->orderterimatgl->setSort("");
                $this->produk_fungsi->setSort("");
                $this->produk_kualitas->setSort("");
                $this->produk_campaign->setSort("");
                $this->kemasan_satuan->setSort("");
                $this->ordertgl->setSort("");
                $this->custcode->setSort("");
                $this->perushnama->setSort("");
                $this->perushalamat->setSort("");
                $this->perushcp->setSort("");
                $this->perushjabatan->setSort("");
                $this->perushphone->setSort("");
                $this->perushmobile->setSort("");
                $this->bencmark->setSort("");
                $this->kategoriproduk->setSort("");
                $this->jenisproduk->setSort("");
                $this->bentuksediaan->setSort("");
                $this->sediaan_ukuran->setSort("");
                $this->sediaan_ukuran_satuan->setSort("");
                $this->produk_viskositas->setSort("");
                $this->konsepproduk->setSort("");
                $this->fragrance->setSort("");
                $this->aroma->setSort("");
                $this->bahanaktif->setSort("");
                $this->warna->setSort("");
                $this->produk_warna_jenis->setSort("");
                $this->aksesoris->setSort("");
                $this->produk_lainlain->setSort("");
                $this->statusproduk->setSort("");
                $this->parfum->setSort("");
                $this->catatan->setSort("");
                $this->rencanakemasan->setSort("");
                $this->keterangan->setSort("");
                $this->ekspetasiharga->setSort("");
                $this->kemasan->setSort("");
                $this->volume->setSort("");
                $this->jenistutup->setSort("");
                $this->catatanpackaging->setSort("");
                $this->infopackaging->setSort("");
                $this->ukuran->setSort("");
                $this->desainprodukkemasan->setSort("");
                $this->desaindiinginkan->setSort("");
                $this->mereknotifikasi->setSort("");
                $this->kategoristatus->setSort("");
                $this->kemasan_ukuran_satuan->setSort("");
                $this->notifikasicatatan->setSort("");
                $this->label_ukuran->setSort("");
                $this->infolabel->setSort("");
                $this->labelkualitas->setSort("");
                $this->labelposisi->setSort("");
                $this->labelcatatan->setSort("");
                $this->dibuatdi->setSort("");
                $this->tanggal->setSort("");
                $this->penerima->setSort("");
                $this->createat->setSort("");
                $this->createby->setSort("");
                $this->statusdokumen->setSort("");
                $this->update_at->setSort("");
                $this->status_data->setSort("");
                $this->harga_rnd->setSort("");
                $this->aplikasi_sediaan->setSort("");
                $this->hu_hrg_isi->setSort("");
                $this->hu_hrg_isi_pro->setSort("");
                $this->hu_hrg_kms_primer->setSort("");
                $this->hu_hrg_kms_primer_pro->setSort("");
                $this->hu_hrg_kms_sekunder->setSort("");
                $this->hu_hrg_kms_sekunder_pro->setSort("");
                $this->hu_hrg_label->setSort("");
                $this->hu_hrg_label_pro->setSort("");
                $this->hu_hrg_total->setSort("");
                $this->hu_hrg_total_pro->setSort("");
                $this->hl_hrg_isi->setSort("");
                $this->hl_hrg_isi_pro->setSort("");
                $this->hl_hrg_kms_primer->setSort("");
                $this->hl_hrg_kms_primer_pro->setSort("");
                $this->hl_hrg_kms_sekunder->setSort("");
                $this->hl_hrg_kms_sekunder_pro->setSort("");
                $this->hl_hrg_label->setSort("");
                $this->hl_hrg_label_pro->setSort("");
                $this->hl_hrg_total->setSort("");
                $this->hl_hrg_total_pro->setSort("");
                $this->bs_bahan_aktif_tick->setSort("");
                $this->bs_bahan_aktif->setSort("");
                $this->bs_bahan_lain->setSort("");
                $this->bs_parfum->setSort("");
                $this->bs_estetika->setSort("");
                $this->bs_kms_wadah->setSort("");
                $this->bs_kms_tutup->setSort("");
                $this->bs_kms_sekunder->setSort("");
                $this->bs_label_desain->setSort("");
                $this->bs_label_cetak->setSort("");
                $this->bs_label_lain->setSort("");
                $this->dlv_pickup->setSort("");
                $this->dlv_singlepoint->setSort("");
                $this->dlv_multipoint->setSort("");
                $this->dlv_multipoint_jml->setSort("");
                $this->dlv_term_lain->setSort("");
                $this->catatan_khusus->setSort("");
                $this->aju_tgl->setSort("");
                $this->aju_oleh->setSort("");
                $this->proses_tgl->setSort("");
                $this->proses_oleh->setSort("");
                $this->revisi_tgl->setSort("");
                $this->revisi_oleh->setSort("");
                $this->revisi_akun_tgl->setSort("");
                $this->revisi_akun_oleh->setSort("");
                $this->revisi_rnd_tgl->setSort("");
                $this->revisi_rnd_oleh->setSort("");
                $this->rnd_tgl->setSort("");
                $this->rnd_oleh->setSort("");
                $this->ap_tgl->setSort("");
                $this->ap_oleh->setSort("");
                $this->batal_tgl->setSort("");
                $this->batal_oleh->setSort("");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"forder_pengembanganlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"forder_pengembanganlistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.forder_pengembanganlist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
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
        $this->cpo_jenis->setDbValue($row['cpo_jenis']);
        $this->ordernum->setDbValue($row['ordernum']);
        $this->order_kode->setDbValue($row['order_kode']);
        $this->orderterimatgl->setDbValue($row['orderterimatgl']);
        $this->produk_fungsi->setDbValue($row['produk_fungsi']);
        $this->produk_kualitas->setDbValue($row['produk_kualitas']);
        $this->produk_campaign->setDbValue($row['produk_campaign']);
        $this->kemasan_satuan->setDbValue($row['kemasan_satuan']);
        $this->ordertgl->setDbValue($row['ordertgl']);
        $this->custcode->setDbValue($row['custcode']);
        $this->perushnama->setDbValue($row['perushnama']);
        $this->perushalamat->setDbValue($row['perushalamat']);
        $this->perushcp->setDbValue($row['perushcp']);
        $this->perushjabatan->setDbValue($row['perushjabatan']);
        $this->perushphone->setDbValue($row['perushphone']);
        $this->perushmobile->setDbValue($row['perushmobile']);
        $this->bencmark->setDbValue($row['bencmark']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->bentuksediaan->setDbValue($row['bentuksediaan']);
        $this->sediaan_ukuran->setDbValue($row['sediaan_ukuran']);
        $this->sediaan_ukuran_satuan->setDbValue($row['sediaan_ukuran_satuan']);
        $this->produk_viskositas->setDbValue($row['produk_viskositas']);
        $this->konsepproduk->setDbValue($row['konsepproduk']);
        $this->fragrance->setDbValue($row['fragrance']);
        $this->aroma->setDbValue($row['aroma']);
        $this->bahanaktif->setDbValue($row['bahanaktif']);
        $this->warna->setDbValue($row['warna']);
        $this->produk_warna_jenis->setDbValue($row['produk_warna_jenis']);
        $this->aksesoris->setDbValue($row['aksesoris']);
        $this->produk_lainlain->setDbValue($row['produk_lainlain']);
        $this->statusproduk->setDbValue($row['statusproduk']);
        $this->parfum->setDbValue($row['parfum']);
        $this->catatan->setDbValue($row['catatan']);
        $this->rencanakemasan->setDbValue($row['rencanakemasan']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->ekspetasiharga->setDbValue($row['ekspetasiharga']);
        $this->kemasan->setDbValue($row['kemasan']);
        $this->volume->setDbValue($row['volume']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->catatanpackaging->setDbValue($row['catatanpackaging']);
        $this->infopackaging->setDbValue($row['infopackaging']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->desainprodukkemasan->setDbValue($row['desainprodukkemasan']);
        $this->desaindiinginkan->setDbValue($row['desaindiinginkan']);
        $this->mereknotifikasi->setDbValue($row['mereknotifikasi']);
        $this->kategoristatus->setDbValue($row['kategoristatus']);
        $this->kemasan_ukuran_satuan->setDbValue($row['kemasan_ukuran_satuan']);
        $this->notifikasicatatan->setDbValue($row['notifikasicatatan']);
        $this->label_ukuran->setDbValue($row['label_ukuran']);
        $this->infolabel->setDbValue($row['infolabel']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->tanggal->setDbValue($row['tanggal']);
        $this->penerima->setDbValue($row['penerima']);
        $this->createat->setDbValue($row['createat']);
        $this->createby->setDbValue($row['createby']);
        $this->statusdokumen->setDbValue($row['statusdokumen']);
        $this->update_at->setDbValue($row['update_at']);
        $this->status_data->setDbValue($row['status_data']);
        $this->harga_rnd->setDbValue($row['harga_rnd']);
        $this->aplikasi_sediaan->setDbValue($row['aplikasi_sediaan']);
        $this->hu_hrg_isi->setDbValue($row['hu_hrg_isi']);
        $this->hu_hrg_isi_pro->setDbValue($row['hu_hrg_isi_pro']);
        $this->hu_hrg_kms_primer->setDbValue($row['hu_hrg_kms_primer']);
        $this->hu_hrg_kms_primer_pro->setDbValue($row['hu_hrg_kms_primer_pro']);
        $this->hu_hrg_kms_sekunder->setDbValue($row['hu_hrg_kms_sekunder']);
        $this->hu_hrg_kms_sekunder_pro->setDbValue($row['hu_hrg_kms_sekunder_pro']);
        $this->hu_hrg_label->setDbValue($row['hu_hrg_label']);
        $this->hu_hrg_label_pro->setDbValue($row['hu_hrg_label_pro']);
        $this->hu_hrg_total->setDbValue($row['hu_hrg_total']);
        $this->hu_hrg_total_pro->setDbValue($row['hu_hrg_total_pro']);
        $this->hl_hrg_isi->setDbValue($row['hl_hrg_isi']);
        $this->hl_hrg_isi_pro->setDbValue($row['hl_hrg_isi_pro']);
        $this->hl_hrg_kms_primer->setDbValue($row['hl_hrg_kms_primer']);
        $this->hl_hrg_kms_primer_pro->setDbValue($row['hl_hrg_kms_primer_pro']);
        $this->hl_hrg_kms_sekunder->setDbValue($row['hl_hrg_kms_sekunder']);
        $this->hl_hrg_kms_sekunder_pro->setDbValue($row['hl_hrg_kms_sekunder_pro']);
        $this->hl_hrg_label->setDbValue($row['hl_hrg_label']);
        $this->hl_hrg_label_pro->setDbValue($row['hl_hrg_label_pro']);
        $this->hl_hrg_total->setDbValue($row['hl_hrg_total']);
        $this->hl_hrg_total_pro->setDbValue($row['hl_hrg_total_pro']);
        $this->bs_bahan_aktif_tick->setDbValue($row['bs_bahan_aktif_tick']);
        $this->bs_bahan_aktif->setDbValue($row['bs_bahan_aktif']);
        $this->bs_bahan_lain->setDbValue($row['bs_bahan_lain']);
        $this->bs_parfum->setDbValue($row['bs_parfum']);
        $this->bs_estetika->setDbValue($row['bs_estetika']);
        $this->bs_kms_wadah->setDbValue($row['bs_kms_wadah']);
        $this->bs_kms_tutup->setDbValue($row['bs_kms_tutup']);
        $this->bs_kms_sekunder->setDbValue($row['bs_kms_sekunder']);
        $this->bs_label_desain->setDbValue($row['bs_label_desain']);
        $this->bs_label_cetak->setDbValue($row['bs_label_cetak']);
        $this->bs_label_lain->setDbValue($row['bs_label_lain']);
        $this->dlv_pickup->setDbValue($row['dlv_pickup']);
        $this->dlv_singlepoint->setDbValue($row['dlv_singlepoint']);
        $this->dlv_multipoint->setDbValue($row['dlv_multipoint']);
        $this->dlv_multipoint_jml->setDbValue($row['dlv_multipoint_jml']);
        $this->dlv_term_lain->setDbValue($row['dlv_term_lain']);
        $this->catatan_khusus->setDbValue($row['catatan_khusus']);
        $this->aju_tgl->setDbValue($row['aju_tgl']);
        $this->aju_oleh->setDbValue($row['aju_oleh']);
        $this->proses_tgl->setDbValue($row['proses_tgl']);
        $this->proses_oleh->setDbValue($row['proses_oleh']);
        $this->revisi_tgl->setDbValue($row['revisi_tgl']);
        $this->revisi_oleh->setDbValue($row['revisi_oleh']);
        $this->revisi_akun_tgl->setDbValue($row['revisi_akun_tgl']);
        $this->revisi_akun_oleh->setDbValue($row['revisi_akun_oleh']);
        $this->revisi_rnd_tgl->setDbValue($row['revisi_rnd_tgl']);
        $this->revisi_rnd_oleh->setDbValue($row['revisi_rnd_oleh']);
        $this->rnd_tgl->setDbValue($row['rnd_tgl']);
        $this->rnd_oleh->setDbValue($row['rnd_oleh']);
        $this->ap_tgl->setDbValue($row['ap_tgl']);
        $this->ap_oleh->setDbValue($row['ap_oleh']);
        $this->batal_tgl->setDbValue($row['batal_tgl']);
        $this->batal_oleh->setDbValue($row['batal_oleh']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['cpo_jenis'] = null;
        $row['ordernum'] = null;
        $row['order_kode'] = null;
        $row['orderterimatgl'] = null;
        $row['produk_fungsi'] = null;
        $row['produk_kualitas'] = null;
        $row['produk_campaign'] = null;
        $row['kemasan_satuan'] = null;
        $row['ordertgl'] = null;
        $row['custcode'] = null;
        $row['perushnama'] = null;
        $row['perushalamat'] = null;
        $row['perushcp'] = null;
        $row['perushjabatan'] = null;
        $row['perushphone'] = null;
        $row['perushmobile'] = null;
        $row['bencmark'] = null;
        $row['kategoriproduk'] = null;
        $row['jenisproduk'] = null;
        $row['bentuksediaan'] = null;
        $row['sediaan_ukuran'] = null;
        $row['sediaan_ukuran_satuan'] = null;
        $row['produk_viskositas'] = null;
        $row['konsepproduk'] = null;
        $row['fragrance'] = null;
        $row['aroma'] = null;
        $row['bahanaktif'] = null;
        $row['warna'] = null;
        $row['produk_warna_jenis'] = null;
        $row['aksesoris'] = null;
        $row['produk_lainlain'] = null;
        $row['statusproduk'] = null;
        $row['parfum'] = null;
        $row['catatan'] = null;
        $row['rencanakemasan'] = null;
        $row['keterangan'] = null;
        $row['ekspetasiharga'] = null;
        $row['kemasan'] = null;
        $row['volume'] = null;
        $row['jenistutup'] = null;
        $row['catatanpackaging'] = null;
        $row['infopackaging'] = null;
        $row['ukuran'] = null;
        $row['desainprodukkemasan'] = null;
        $row['desaindiinginkan'] = null;
        $row['mereknotifikasi'] = null;
        $row['kategoristatus'] = null;
        $row['kemasan_ukuran_satuan'] = null;
        $row['notifikasicatatan'] = null;
        $row['label_ukuran'] = null;
        $row['infolabel'] = null;
        $row['labelkualitas'] = null;
        $row['labelposisi'] = null;
        $row['labelcatatan'] = null;
        $row['dibuatdi'] = null;
        $row['tanggal'] = null;
        $row['penerima'] = null;
        $row['createat'] = null;
        $row['createby'] = null;
        $row['statusdokumen'] = null;
        $row['update_at'] = null;
        $row['status_data'] = null;
        $row['harga_rnd'] = null;
        $row['aplikasi_sediaan'] = null;
        $row['hu_hrg_isi'] = null;
        $row['hu_hrg_isi_pro'] = null;
        $row['hu_hrg_kms_primer'] = null;
        $row['hu_hrg_kms_primer_pro'] = null;
        $row['hu_hrg_kms_sekunder'] = null;
        $row['hu_hrg_kms_sekunder_pro'] = null;
        $row['hu_hrg_label'] = null;
        $row['hu_hrg_label_pro'] = null;
        $row['hu_hrg_total'] = null;
        $row['hu_hrg_total_pro'] = null;
        $row['hl_hrg_isi'] = null;
        $row['hl_hrg_isi_pro'] = null;
        $row['hl_hrg_kms_primer'] = null;
        $row['hl_hrg_kms_primer_pro'] = null;
        $row['hl_hrg_kms_sekunder'] = null;
        $row['hl_hrg_kms_sekunder_pro'] = null;
        $row['hl_hrg_label'] = null;
        $row['hl_hrg_label_pro'] = null;
        $row['hl_hrg_total'] = null;
        $row['hl_hrg_total_pro'] = null;
        $row['bs_bahan_aktif_tick'] = null;
        $row['bs_bahan_aktif'] = null;
        $row['bs_bahan_lain'] = null;
        $row['bs_parfum'] = null;
        $row['bs_estetika'] = null;
        $row['bs_kms_wadah'] = null;
        $row['bs_kms_tutup'] = null;
        $row['bs_kms_sekunder'] = null;
        $row['bs_label_desain'] = null;
        $row['bs_label_cetak'] = null;
        $row['bs_label_lain'] = null;
        $row['dlv_pickup'] = null;
        $row['dlv_singlepoint'] = null;
        $row['dlv_multipoint'] = null;
        $row['dlv_multipoint_jml'] = null;
        $row['dlv_term_lain'] = null;
        $row['catatan_khusus'] = null;
        $row['aju_tgl'] = null;
        $row['aju_oleh'] = null;
        $row['proses_tgl'] = null;
        $row['proses_oleh'] = null;
        $row['revisi_tgl'] = null;
        $row['revisi_oleh'] = null;
        $row['revisi_akun_tgl'] = null;
        $row['revisi_akun_oleh'] = null;
        $row['revisi_rnd_tgl'] = null;
        $row['revisi_rnd_oleh'] = null;
        $row['rnd_tgl'] = null;
        $row['rnd_oleh'] = null;
        $row['ap_tgl'] = null;
        $row['ap_oleh'] = null;
        $row['batal_tgl'] = null;
        $row['batal_oleh'] = null;
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

        // Convert decimal values if posted back
        if ($this->sediaan_ukuran->FormValue == $this->sediaan_ukuran->CurrentValue && is_numeric(ConvertToFloatString($this->sediaan_ukuran->CurrentValue))) {
            $this->sediaan_ukuran->CurrentValue = ConvertToFloatString($this->sediaan_ukuran->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ekspetasiharga->FormValue == $this->ekspetasiharga->CurrentValue && is_numeric(ConvertToFloatString($this->ekspetasiharga->CurrentValue))) {
            $this->ekspetasiharga->CurrentValue = ConvertToFloatString($this->ekspetasiharga->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->volume->FormValue == $this->volume->CurrentValue && is_numeric(ConvertToFloatString($this->volume->CurrentValue))) {
            $this->volume->CurrentValue = ConvertToFloatString($this->volume->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->harga_rnd->FormValue == $this->harga_rnd->CurrentValue && is_numeric(ConvertToFloatString($this->harga_rnd->CurrentValue))) {
            $this->harga_rnd->CurrentValue = ConvertToFloatString($this->harga_rnd->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_isi->FormValue == $this->hu_hrg_isi->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_isi->CurrentValue))) {
            $this->hu_hrg_isi->CurrentValue = ConvertToFloatString($this->hu_hrg_isi->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_isi_pro->FormValue == $this->hu_hrg_isi_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_isi_pro->CurrentValue))) {
            $this->hu_hrg_isi_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_isi_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_primer->FormValue == $this->hu_hrg_kms_primer->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_primer->CurrentValue))) {
            $this->hu_hrg_kms_primer->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_primer->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_primer_pro->FormValue == $this->hu_hrg_kms_primer_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_primer_pro->CurrentValue))) {
            $this->hu_hrg_kms_primer_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_primer_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_sekunder->FormValue == $this->hu_hrg_kms_sekunder->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_sekunder->CurrentValue))) {
            $this->hu_hrg_kms_sekunder->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_sekunder->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_sekunder_pro->FormValue == $this->hu_hrg_kms_sekunder_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_sekunder_pro->CurrentValue))) {
            $this->hu_hrg_kms_sekunder_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_sekunder_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_label->FormValue == $this->hu_hrg_label->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_label->CurrentValue))) {
            $this->hu_hrg_label->CurrentValue = ConvertToFloatString($this->hu_hrg_label->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_label_pro->FormValue == $this->hu_hrg_label_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_label_pro->CurrentValue))) {
            $this->hu_hrg_label_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_label_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_total->FormValue == $this->hu_hrg_total->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_total->CurrentValue))) {
            $this->hu_hrg_total->CurrentValue = ConvertToFloatString($this->hu_hrg_total->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_total_pro->FormValue == $this->hu_hrg_total_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_total_pro->CurrentValue))) {
            $this->hu_hrg_total_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_total_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_isi->FormValue == $this->hl_hrg_isi->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_isi->CurrentValue))) {
            $this->hl_hrg_isi->CurrentValue = ConvertToFloatString($this->hl_hrg_isi->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_isi_pro->FormValue == $this->hl_hrg_isi_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_isi_pro->CurrentValue))) {
            $this->hl_hrg_isi_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_isi_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_primer->FormValue == $this->hl_hrg_kms_primer->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_primer->CurrentValue))) {
            $this->hl_hrg_kms_primer->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_primer->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_primer_pro->FormValue == $this->hl_hrg_kms_primer_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_primer_pro->CurrentValue))) {
            $this->hl_hrg_kms_primer_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_primer_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_sekunder->FormValue == $this->hl_hrg_kms_sekunder->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_sekunder->CurrentValue))) {
            $this->hl_hrg_kms_sekunder->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_sekunder->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_sekunder_pro->FormValue == $this->hl_hrg_kms_sekunder_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_sekunder_pro->CurrentValue))) {
            $this->hl_hrg_kms_sekunder_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_sekunder_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_label->FormValue == $this->hl_hrg_label->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_label->CurrentValue))) {
            $this->hl_hrg_label->CurrentValue = ConvertToFloatString($this->hl_hrg_label->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_label_pro->FormValue == $this->hl_hrg_label_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_label_pro->CurrentValue))) {
            $this->hl_hrg_label_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_label_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_total->FormValue == $this->hl_hrg_total->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_total->CurrentValue))) {
            $this->hl_hrg_total->CurrentValue = ConvertToFloatString($this->hl_hrg_total->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_total_pro->FormValue == $this->hl_hrg_total_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_total_pro->CurrentValue))) {
            $this->hl_hrg_total_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_total_pro->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // cpo_jenis

        // ordernum

        // order_kode

        // orderterimatgl

        // produk_fungsi

        // produk_kualitas

        // produk_campaign

        // kemasan_satuan

        // ordertgl

        // custcode

        // perushnama

        // perushalamat

        // perushcp

        // perushjabatan

        // perushphone

        // perushmobile

        // bencmark

        // kategoriproduk

        // jenisproduk

        // bentuksediaan

        // sediaan_ukuran

        // sediaan_ukuran_satuan

        // produk_viskositas

        // konsepproduk

        // fragrance

        // aroma

        // bahanaktif

        // warna

        // produk_warna_jenis

        // aksesoris

        // produk_lainlain

        // statusproduk

        // parfum

        // catatan

        // rencanakemasan

        // keterangan

        // ekspetasiharga

        // kemasan

        // volume

        // jenistutup

        // catatanpackaging

        // infopackaging

        // ukuran

        // desainprodukkemasan

        // desaindiinginkan

        // mereknotifikasi

        // kategoristatus

        // kemasan_ukuran_satuan

        // notifikasicatatan

        // label_ukuran

        // infolabel

        // labelkualitas

        // labelposisi

        // labelcatatan

        // dibuatdi

        // tanggal

        // penerima

        // createat

        // createby

        // statusdokumen

        // update_at

        // status_data

        // harga_rnd

        // aplikasi_sediaan

        // hu_hrg_isi

        // hu_hrg_isi_pro

        // hu_hrg_kms_primer

        // hu_hrg_kms_primer_pro

        // hu_hrg_kms_sekunder

        // hu_hrg_kms_sekunder_pro

        // hu_hrg_label

        // hu_hrg_label_pro

        // hu_hrg_total

        // hu_hrg_total_pro

        // hl_hrg_isi

        // hl_hrg_isi_pro

        // hl_hrg_kms_primer

        // hl_hrg_kms_primer_pro

        // hl_hrg_kms_sekunder

        // hl_hrg_kms_sekunder_pro

        // hl_hrg_label

        // hl_hrg_label_pro

        // hl_hrg_total

        // hl_hrg_total_pro

        // bs_bahan_aktif_tick

        // bs_bahan_aktif

        // bs_bahan_lain

        // bs_parfum

        // bs_estetika

        // bs_kms_wadah

        // bs_kms_tutup

        // bs_kms_sekunder

        // bs_label_desain

        // bs_label_cetak

        // bs_label_lain

        // dlv_pickup

        // dlv_singlepoint

        // dlv_multipoint

        // dlv_multipoint_jml

        // dlv_term_lain

        // catatan_khusus

        // aju_tgl

        // aju_oleh

        // proses_tgl

        // proses_oleh

        // revisi_tgl

        // revisi_oleh

        // revisi_akun_tgl

        // revisi_akun_oleh

        // revisi_rnd_tgl

        // revisi_rnd_oleh

        // rnd_tgl

        // rnd_oleh

        // ap_tgl

        // ap_oleh

        // batal_tgl

        // batal_oleh
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
            $this->id->ViewCustomAttributes = "";

            // cpo_jenis
            $this->cpo_jenis->ViewValue = $this->cpo_jenis->CurrentValue;
            $this->cpo_jenis->ViewCustomAttributes = "";

            // ordernum
            $this->ordernum->ViewValue = $this->ordernum->CurrentValue;
            $this->ordernum->ViewCustomAttributes = "";

            // order_kode
            $this->order_kode->ViewValue = $this->order_kode->CurrentValue;
            $this->order_kode->ViewCustomAttributes = "";

            // orderterimatgl
            $this->orderterimatgl->ViewValue = $this->orderterimatgl->CurrentValue;
            $this->orderterimatgl->ViewValue = FormatDateTime($this->orderterimatgl->ViewValue, 0);
            $this->orderterimatgl->ViewCustomAttributes = "";

            // produk_fungsi
            $this->produk_fungsi->ViewValue = $this->produk_fungsi->CurrentValue;
            $this->produk_fungsi->ViewCustomAttributes = "";

            // produk_kualitas
            $this->produk_kualitas->ViewValue = $this->produk_kualitas->CurrentValue;
            $this->produk_kualitas->ViewCustomAttributes = "";

            // produk_campaign
            $this->produk_campaign->ViewValue = $this->produk_campaign->CurrentValue;
            $this->produk_campaign->ViewCustomAttributes = "";

            // kemasan_satuan
            $this->kemasan_satuan->ViewValue = $this->kemasan_satuan->CurrentValue;
            $this->kemasan_satuan->ViewCustomAttributes = "";

            // ordertgl
            $this->ordertgl->ViewValue = $this->ordertgl->CurrentValue;
            $this->ordertgl->ViewValue = FormatDateTime($this->ordertgl->ViewValue, 0);
            $this->ordertgl->ViewCustomAttributes = "";

            // custcode
            $this->custcode->ViewValue = $this->custcode->CurrentValue;
            $this->custcode->ViewValue = FormatNumber($this->custcode->ViewValue, 0, -2, -2, -2);
            $this->custcode->ViewCustomAttributes = "";

            // perushnama
            $this->perushnama->ViewValue = $this->perushnama->CurrentValue;
            $this->perushnama->ViewCustomAttributes = "";

            // perushalamat
            $this->perushalamat->ViewValue = $this->perushalamat->CurrentValue;
            $this->perushalamat->ViewCustomAttributes = "";

            // perushcp
            $this->perushcp->ViewValue = $this->perushcp->CurrentValue;
            $this->perushcp->ViewCustomAttributes = "";

            // perushjabatan
            $this->perushjabatan->ViewValue = $this->perushjabatan->CurrentValue;
            $this->perushjabatan->ViewCustomAttributes = "";

            // perushphone
            $this->perushphone->ViewValue = $this->perushphone->CurrentValue;
            $this->perushphone->ViewCustomAttributes = "";

            // perushmobile
            $this->perushmobile->ViewValue = $this->perushmobile->CurrentValue;
            $this->perushmobile->ViewCustomAttributes = "";

            // bencmark
            $this->bencmark->ViewValue = $this->bencmark->CurrentValue;
            $this->bencmark->ViewCustomAttributes = "";

            // kategoriproduk
            $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
            $this->kategoriproduk->ViewCustomAttributes = "";

            // jenisproduk
            $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
            $this->jenisproduk->ViewCustomAttributes = "";

            // bentuksediaan
            $this->bentuksediaan->ViewValue = $this->bentuksediaan->CurrentValue;
            $this->bentuksediaan->ViewCustomAttributes = "";

            // sediaan_ukuran
            $this->sediaan_ukuran->ViewValue = $this->sediaan_ukuran->CurrentValue;
            $this->sediaan_ukuran->ViewValue = FormatNumber($this->sediaan_ukuran->ViewValue, 2, -2, -2, -2);
            $this->sediaan_ukuran->ViewCustomAttributes = "";

            // sediaan_ukuran_satuan
            $this->sediaan_ukuran_satuan->ViewValue = $this->sediaan_ukuran_satuan->CurrentValue;
            $this->sediaan_ukuran_satuan->ViewCustomAttributes = "";

            // produk_viskositas
            $this->produk_viskositas->ViewValue = $this->produk_viskositas->CurrentValue;
            $this->produk_viskositas->ViewCustomAttributes = "";

            // konsepproduk
            $this->konsepproduk->ViewValue = $this->konsepproduk->CurrentValue;
            $this->konsepproduk->ViewCustomAttributes = "";

            // fragrance
            $this->fragrance->ViewValue = $this->fragrance->CurrentValue;
            $this->fragrance->ViewCustomAttributes = "";

            // aroma
            $this->aroma->ViewValue = $this->aroma->CurrentValue;
            $this->aroma->ViewCustomAttributes = "";

            // bahanaktif
            $this->bahanaktif->ViewValue = $this->bahanaktif->CurrentValue;
            $this->bahanaktif->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // produk_warna_jenis
            $this->produk_warna_jenis->ViewValue = $this->produk_warna_jenis->CurrentValue;
            $this->produk_warna_jenis->ViewCustomAttributes = "";

            // aksesoris
            $this->aksesoris->ViewValue = $this->aksesoris->CurrentValue;
            $this->aksesoris->ViewCustomAttributes = "";

            // statusproduk
            $this->statusproduk->ViewValue = $this->statusproduk->CurrentValue;
            $this->statusproduk->ViewCustomAttributes = "";

            // parfum
            $this->parfum->ViewValue = $this->parfum->CurrentValue;
            $this->parfum->ViewCustomAttributes = "";

            // catatan
            $this->catatan->ViewValue = $this->catatan->CurrentValue;
            $this->catatan->ViewCustomAttributes = "";

            // rencanakemasan
            $this->rencanakemasan->ViewValue = $this->rencanakemasan->CurrentValue;
            $this->rencanakemasan->ViewCustomAttributes = "";

            // ekspetasiharga
            $this->ekspetasiharga->ViewValue = $this->ekspetasiharga->CurrentValue;
            $this->ekspetasiharga->ViewValue = FormatNumber($this->ekspetasiharga->ViewValue, 2, -2, -2, -2);
            $this->ekspetasiharga->ViewCustomAttributes = "";

            // kemasan
            $this->kemasan->ViewValue = $this->kemasan->CurrentValue;
            $this->kemasan->ViewCustomAttributes = "";

            // volume
            $this->volume->ViewValue = $this->volume->CurrentValue;
            $this->volume->ViewValue = FormatNumber($this->volume->ViewValue, 2, -2, -2, -2);
            $this->volume->ViewCustomAttributes = "";

            // jenistutup
            $this->jenistutup->ViewValue = $this->jenistutup->CurrentValue;
            $this->jenistutup->ViewCustomAttributes = "";

            // infopackaging
            $this->infopackaging->ViewValue = $this->infopackaging->CurrentValue;
            $this->infopackaging->ViewCustomAttributes = "";

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewValue = FormatNumber($this->ukuran->ViewValue, 0, -2, -2, -2);
            $this->ukuran->ViewCustomAttributes = "";

            // desainprodukkemasan
            $this->desainprodukkemasan->ViewValue = $this->desainprodukkemasan->CurrentValue;
            $this->desainprodukkemasan->ViewCustomAttributes = "";

            // desaindiinginkan
            $this->desaindiinginkan->ViewValue = $this->desaindiinginkan->CurrentValue;
            $this->desaindiinginkan->ViewCustomAttributes = "";

            // mereknotifikasi
            $this->mereknotifikasi->ViewValue = $this->mereknotifikasi->CurrentValue;
            $this->mereknotifikasi->ViewCustomAttributes = "";

            // kategoristatus
            $this->kategoristatus->ViewValue = $this->kategoristatus->CurrentValue;
            $this->kategoristatus->ViewCustomAttributes = "";

            // kemasan_ukuran_satuan
            $this->kemasan_ukuran_satuan->ViewValue = $this->kemasan_ukuran_satuan->CurrentValue;
            $this->kemasan_ukuran_satuan->ViewCustomAttributes = "";

            // infolabel
            $this->infolabel->ViewValue = $this->infolabel->CurrentValue;
            $this->infolabel->ViewCustomAttributes = "";

            // labelkualitas
            $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
            $this->labelkualitas->ViewCustomAttributes = "";

            // labelposisi
            $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
            $this->labelposisi->ViewCustomAttributes = "";

            // dibuatdi
            $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
            $this->dibuatdi->ViewCustomAttributes = "";

            // tanggal
            $this->tanggal->ViewValue = $this->tanggal->CurrentValue;
            $this->tanggal->ViewValue = FormatDateTime($this->tanggal->ViewValue, 0);
            $this->tanggal->ViewCustomAttributes = "";

            // penerima
            $this->penerima->ViewValue = $this->penerima->CurrentValue;
            $this->penerima->ViewValue = FormatNumber($this->penerima->ViewValue, 0, -2, -2, -2);
            $this->penerima->ViewCustomAttributes = "";

            // createat
            $this->createat->ViewValue = $this->createat->CurrentValue;
            $this->createat->ViewValue = FormatDateTime($this->createat->ViewValue, 0);
            $this->createat->ViewCustomAttributes = "";

            // createby
            $this->createby->ViewValue = $this->createby->CurrentValue;
            $this->createby->ViewValue = FormatNumber($this->createby->ViewValue, 0, -2, -2, -2);
            $this->createby->ViewCustomAttributes = "";

            // statusdokumen
            $this->statusdokumen->ViewValue = $this->statusdokumen->CurrentValue;
            $this->statusdokumen->ViewCustomAttributes = "";

            // update_at
            $this->update_at->ViewValue = $this->update_at->CurrentValue;
            $this->update_at->ViewValue = FormatDateTime($this->update_at->ViewValue, 0);
            $this->update_at->ViewCustomAttributes = "";

            // status_data
            $this->status_data->ViewValue = $this->status_data->CurrentValue;
            $this->status_data->ViewCustomAttributes = "";

            // harga_rnd
            $this->harga_rnd->ViewValue = $this->harga_rnd->CurrentValue;
            $this->harga_rnd->ViewValue = FormatNumber($this->harga_rnd->ViewValue, 2, -2, -2, -2);
            $this->harga_rnd->ViewCustomAttributes = "";

            // aplikasi_sediaan
            $this->aplikasi_sediaan->ViewValue = $this->aplikasi_sediaan->CurrentValue;
            $this->aplikasi_sediaan->ViewCustomAttributes = "";

            // hu_hrg_isi
            $this->hu_hrg_isi->ViewValue = $this->hu_hrg_isi->CurrentValue;
            $this->hu_hrg_isi->ViewValue = FormatNumber($this->hu_hrg_isi->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_isi->ViewCustomAttributes = "";

            // hu_hrg_isi_pro
            $this->hu_hrg_isi_pro->ViewValue = $this->hu_hrg_isi_pro->CurrentValue;
            $this->hu_hrg_isi_pro->ViewValue = FormatNumber($this->hu_hrg_isi_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_isi_pro->ViewCustomAttributes = "";

            // hu_hrg_kms_primer
            $this->hu_hrg_kms_primer->ViewValue = $this->hu_hrg_kms_primer->CurrentValue;
            $this->hu_hrg_kms_primer->ViewValue = FormatNumber($this->hu_hrg_kms_primer->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_primer->ViewCustomAttributes = "";

            // hu_hrg_kms_primer_pro
            $this->hu_hrg_kms_primer_pro->ViewValue = $this->hu_hrg_kms_primer_pro->CurrentValue;
            $this->hu_hrg_kms_primer_pro->ViewValue = FormatNumber($this->hu_hrg_kms_primer_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_primer_pro->ViewCustomAttributes = "";

            // hu_hrg_kms_sekunder
            $this->hu_hrg_kms_sekunder->ViewValue = $this->hu_hrg_kms_sekunder->CurrentValue;
            $this->hu_hrg_kms_sekunder->ViewValue = FormatNumber($this->hu_hrg_kms_sekunder->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_sekunder->ViewCustomAttributes = "";

            // hu_hrg_kms_sekunder_pro
            $this->hu_hrg_kms_sekunder_pro->ViewValue = $this->hu_hrg_kms_sekunder_pro->CurrentValue;
            $this->hu_hrg_kms_sekunder_pro->ViewValue = FormatNumber($this->hu_hrg_kms_sekunder_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_sekunder_pro->ViewCustomAttributes = "";

            // hu_hrg_label
            $this->hu_hrg_label->ViewValue = $this->hu_hrg_label->CurrentValue;
            $this->hu_hrg_label->ViewValue = FormatNumber($this->hu_hrg_label->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_label->ViewCustomAttributes = "";

            // hu_hrg_label_pro
            $this->hu_hrg_label_pro->ViewValue = $this->hu_hrg_label_pro->CurrentValue;
            $this->hu_hrg_label_pro->ViewValue = FormatNumber($this->hu_hrg_label_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_label_pro->ViewCustomAttributes = "";

            // hu_hrg_total
            $this->hu_hrg_total->ViewValue = $this->hu_hrg_total->CurrentValue;
            $this->hu_hrg_total->ViewValue = FormatNumber($this->hu_hrg_total->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_total->ViewCustomAttributes = "";

            // hu_hrg_total_pro
            $this->hu_hrg_total_pro->ViewValue = $this->hu_hrg_total_pro->CurrentValue;
            $this->hu_hrg_total_pro->ViewValue = FormatNumber($this->hu_hrg_total_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_total_pro->ViewCustomAttributes = "";

            // hl_hrg_isi
            $this->hl_hrg_isi->ViewValue = $this->hl_hrg_isi->CurrentValue;
            $this->hl_hrg_isi->ViewValue = FormatNumber($this->hl_hrg_isi->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_isi->ViewCustomAttributes = "";

            // hl_hrg_isi_pro
            $this->hl_hrg_isi_pro->ViewValue = $this->hl_hrg_isi_pro->CurrentValue;
            $this->hl_hrg_isi_pro->ViewValue = FormatNumber($this->hl_hrg_isi_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_isi_pro->ViewCustomAttributes = "";

            // hl_hrg_kms_primer
            $this->hl_hrg_kms_primer->ViewValue = $this->hl_hrg_kms_primer->CurrentValue;
            $this->hl_hrg_kms_primer->ViewValue = FormatNumber($this->hl_hrg_kms_primer->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_primer->ViewCustomAttributes = "";

            // hl_hrg_kms_primer_pro
            $this->hl_hrg_kms_primer_pro->ViewValue = $this->hl_hrg_kms_primer_pro->CurrentValue;
            $this->hl_hrg_kms_primer_pro->ViewValue = FormatNumber($this->hl_hrg_kms_primer_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_primer_pro->ViewCustomAttributes = "";

            // hl_hrg_kms_sekunder
            $this->hl_hrg_kms_sekunder->ViewValue = $this->hl_hrg_kms_sekunder->CurrentValue;
            $this->hl_hrg_kms_sekunder->ViewValue = FormatNumber($this->hl_hrg_kms_sekunder->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_sekunder->ViewCustomAttributes = "";

            // hl_hrg_kms_sekunder_pro
            $this->hl_hrg_kms_sekunder_pro->ViewValue = $this->hl_hrg_kms_sekunder_pro->CurrentValue;
            $this->hl_hrg_kms_sekunder_pro->ViewValue = FormatNumber($this->hl_hrg_kms_sekunder_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_sekunder_pro->ViewCustomAttributes = "";

            // hl_hrg_label
            $this->hl_hrg_label->ViewValue = $this->hl_hrg_label->CurrentValue;
            $this->hl_hrg_label->ViewValue = FormatNumber($this->hl_hrg_label->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_label->ViewCustomAttributes = "";

            // hl_hrg_label_pro
            $this->hl_hrg_label_pro->ViewValue = $this->hl_hrg_label_pro->CurrentValue;
            $this->hl_hrg_label_pro->ViewValue = FormatNumber($this->hl_hrg_label_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_label_pro->ViewCustomAttributes = "";

            // hl_hrg_total
            $this->hl_hrg_total->ViewValue = $this->hl_hrg_total->CurrentValue;
            $this->hl_hrg_total->ViewValue = FormatNumber($this->hl_hrg_total->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_total->ViewCustomAttributes = "";

            // hl_hrg_total_pro
            $this->hl_hrg_total_pro->ViewValue = $this->hl_hrg_total_pro->CurrentValue;
            $this->hl_hrg_total_pro->ViewValue = FormatNumber($this->hl_hrg_total_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_total_pro->ViewCustomAttributes = "";

            // bs_bahan_aktif_tick
            $this->bs_bahan_aktif_tick->ViewValue = $this->bs_bahan_aktif_tick->CurrentValue;
            $this->bs_bahan_aktif_tick->ViewCustomAttributes = "";

            // aju_tgl
            $this->aju_tgl->ViewValue = $this->aju_tgl->CurrentValue;
            $this->aju_tgl->ViewValue = FormatDateTime($this->aju_tgl->ViewValue, 0);
            $this->aju_tgl->ViewCustomAttributes = "";

            // aju_oleh
            $this->aju_oleh->ViewValue = $this->aju_oleh->CurrentValue;
            $this->aju_oleh->ViewValue = FormatNumber($this->aju_oleh->ViewValue, 0, -2, -2, -2);
            $this->aju_oleh->ViewCustomAttributes = "";

            // proses_tgl
            $this->proses_tgl->ViewValue = $this->proses_tgl->CurrentValue;
            $this->proses_tgl->ViewValue = FormatDateTime($this->proses_tgl->ViewValue, 0);
            $this->proses_tgl->ViewCustomAttributes = "";

            // proses_oleh
            $this->proses_oleh->ViewValue = $this->proses_oleh->CurrentValue;
            $this->proses_oleh->ViewValue = FormatNumber($this->proses_oleh->ViewValue, 0, -2, -2, -2);
            $this->proses_oleh->ViewCustomAttributes = "";

            // revisi_tgl
            $this->revisi_tgl->ViewValue = $this->revisi_tgl->CurrentValue;
            $this->revisi_tgl->ViewValue = FormatDateTime($this->revisi_tgl->ViewValue, 0);
            $this->revisi_tgl->ViewCustomAttributes = "";

            // revisi_oleh
            $this->revisi_oleh->ViewValue = $this->revisi_oleh->CurrentValue;
            $this->revisi_oleh->ViewValue = FormatNumber($this->revisi_oleh->ViewValue, 0, -2, -2, -2);
            $this->revisi_oleh->ViewCustomAttributes = "";

            // revisi_akun_tgl
            $this->revisi_akun_tgl->ViewValue = $this->revisi_akun_tgl->CurrentValue;
            $this->revisi_akun_tgl->ViewValue = FormatDateTime($this->revisi_akun_tgl->ViewValue, 0);
            $this->revisi_akun_tgl->ViewCustomAttributes = "";

            // revisi_akun_oleh
            $this->revisi_akun_oleh->ViewValue = $this->revisi_akun_oleh->CurrentValue;
            $this->revisi_akun_oleh->ViewValue = FormatNumber($this->revisi_akun_oleh->ViewValue, 0, -2, -2, -2);
            $this->revisi_akun_oleh->ViewCustomAttributes = "";

            // revisi_rnd_tgl
            $this->revisi_rnd_tgl->ViewValue = $this->revisi_rnd_tgl->CurrentValue;
            $this->revisi_rnd_tgl->ViewValue = FormatDateTime($this->revisi_rnd_tgl->ViewValue, 0);
            $this->revisi_rnd_tgl->ViewCustomAttributes = "";

            // revisi_rnd_oleh
            $this->revisi_rnd_oleh->ViewValue = $this->revisi_rnd_oleh->CurrentValue;
            $this->revisi_rnd_oleh->ViewValue = FormatNumber($this->revisi_rnd_oleh->ViewValue, 0, -2, -2, -2);
            $this->revisi_rnd_oleh->ViewCustomAttributes = "";

            // rnd_tgl
            $this->rnd_tgl->ViewValue = $this->rnd_tgl->CurrentValue;
            $this->rnd_tgl->ViewValue = FormatDateTime($this->rnd_tgl->ViewValue, 0);
            $this->rnd_tgl->ViewCustomAttributes = "";

            // rnd_oleh
            $this->rnd_oleh->ViewValue = $this->rnd_oleh->CurrentValue;
            $this->rnd_oleh->ViewValue = FormatNumber($this->rnd_oleh->ViewValue, 0, -2, -2, -2);
            $this->rnd_oleh->ViewCustomAttributes = "";

            // ap_tgl
            $this->ap_tgl->ViewValue = $this->ap_tgl->CurrentValue;
            $this->ap_tgl->ViewValue = FormatDateTime($this->ap_tgl->ViewValue, 0);
            $this->ap_tgl->ViewCustomAttributes = "";

            // ap_oleh
            $this->ap_oleh->ViewValue = $this->ap_oleh->CurrentValue;
            $this->ap_oleh->ViewValue = FormatNumber($this->ap_oleh->ViewValue, 0, -2, -2, -2);
            $this->ap_oleh->ViewCustomAttributes = "";

            // batal_tgl
            $this->batal_tgl->ViewValue = $this->batal_tgl->CurrentValue;
            $this->batal_tgl->ViewValue = FormatDateTime($this->batal_tgl->ViewValue, 0);
            $this->batal_tgl->ViewCustomAttributes = "";

            // batal_oleh
            $this->batal_oleh->ViewValue = $this->batal_oleh->CurrentValue;
            $this->batal_oleh->ViewValue = FormatNumber($this->batal_oleh->ViewValue, 0, -2, -2, -2);
            $this->batal_oleh->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // cpo_jenis
            $this->cpo_jenis->LinkCustomAttributes = "";
            $this->cpo_jenis->HrefValue = "";
            $this->cpo_jenis->TooltipValue = "";

            // ordernum
            $this->ordernum->LinkCustomAttributes = "";
            $this->ordernum->HrefValue = "";
            $this->ordernum->TooltipValue = "";

            // order_kode
            $this->order_kode->LinkCustomAttributes = "";
            $this->order_kode->HrefValue = "";
            $this->order_kode->TooltipValue = "";

            // orderterimatgl
            $this->orderterimatgl->LinkCustomAttributes = "";
            $this->orderterimatgl->HrefValue = "";
            $this->orderterimatgl->TooltipValue = "";

            // produk_fungsi
            $this->produk_fungsi->LinkCustomAttributes = "";
            $this->produk_fungsi->HrefValue = "";
            $this->produk_fungsi->TooltipValue = "";

            // produk_kualitas
            $this->produk_kualitas->LinkCustomAttributes = "";
            $this->produk_kualitas->HrefValue = "";
            $this->produk_kualitas->TooltipValue = "";

            // produk_campaign
            $this->produk_campaign->LinkCustomAttributes = "";
            $this->produk_campaign->HrefValue = "";
            $this->produk_campaign->TooltipValue = "";

            // kemasan_satuan
            $this->kemasan_satuan->LinkCustomAttributes = "";
            $this->kemasan_satuan->HrefValue = "";
            $this->kemasan_satuan->TooltipValue = "";

            // ordertgl
            $this->ordertgl->LinkCustomAttributes = "";
            $this->ordertgl->HrefValue = "";
            $this->ordertgl->TooltipValue = "";

            // custcode
            $this->custcode->LinkCustomAttributes = "";
            $this->custcode->HrefValue = "";
            $this->custcode->TooltipValue = "";

            // perushnama
            $this->perushnama->LinkCustomAttributes = "";
            $this->perushnama->HrefValue = "";
            $this->perushnama->TooltipValue = "";

            // perushalamat
            $this->perushalamat->LinkCustomAttributes = "";
            $this->perushalamat->HrefValue = "";
            $this->perushalamat->TooltipValue = "";

            // perushcp
            $this->perushcp->LinkCustomAttributes = "";
            $this->perushcp->HrefValue = "";
            $this->perushcp->TooltipValue = "";

            // perushjabatan
            $this->perushjabatan->LinkCustomAttributes = "";
            $this->perushjabatan->HrefValue = "";
            $this->perushjabatan->TooltipValue = "";

            // perushphone
            $this->perushphone->LinkCustomAttributes = "";
            $this->perushphone->HrefValue = "";
            $this->perushphone->TooltipValue = "";

            // perushmobile
            $this->perushmobile->LinkCustomAttributes = "";
            $this->perushmobile->HrefValue = "";
            $this->perushmobile->TooltipValue = "";

            // bencmark
            $this->bencmark->LinkCustomAttributes = "";
            $this->bencmark->HrefValue = "";
            $this->bencmark->TooltipValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";
            $this->kategoriproduk->TooltipValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";
            $this->jenisproduk->TooltipValue = "";

            // bentuksediaan
            $this->bentuksediaan->LinkCustomAttributes = "";
            $this->bentuksediaan->HrefValue = "";
            $this->bentuksediaan->TooltipValue = "";

            // sediaan_ukuran
            $this->sediaan_ukuran->LinkCustomAttributes = "";
            $this->sediaan_ukuran->HrefValue = "";
            $this->sediaan_ukuran->TooltipValue = "";

            // sediaan_ukuran_satuan
            $this->sediaan_ukuran_satuan->LinkCustomAttributes = "";
            $this->sediaan_ukuran_satuan->HrefValue = "";
            $this->sediaan_ukuran_satuan->TooltipValue = "";

            // produk_viskositas
            $this->produk_viskositas->LinkCustomAttributes = "";
            $this->produk_viskositas->HrefValue = "";
            $this->produk_viskositas->TooltipValue = "";

            // konsepproduk
            $this->konsepproduk->LinkCustomAttributes = "";
            $this->konsepproduk->HrefValue = "";
            $this->konsepproduk->TooltipValue = "";

            // fragrance
            $this->fragrance->LinkCustomAttributes = "";
            $this->fragrance->HrefValue = "";
            $this->fragrance->TooltipValue = "";

            // aroma
            $this->aroma->LinkCustomAttributes = "";
            $this->aroma->HrefValue = "";
            $this->aroma->TooltipValue = "";

            // bahanaktif
            $this->bahanaktif->LinkCustomAttributes = "";
            $this->bahanaktif->HrefValue = "";
            $this->bahanaktif->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // produk_warna_jenis
            $this->produk_warna_jenis->LinkCustomAttributes = "";
            $this->produk_warna_jenis->HrefValue = "";
            $this->produk_warna_jenis->TooltipValue = "";

            // aksesoris
            $this->aksesoris->LinkCustomAttributes = "";
            $this->aksesoris->HrefValue = "";
            $this->aksesoris->TooltipValue = "";

            // statusproduk
            $this->statusproduk->LinkCustomAttributes = "";
            $this->statusproduk->HrefValue = "";
            $this->statusproduk->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // catatan
            $this->catatan->LinkCustomAttributes = "";
            $this->catatan->HrefValue = "";
            $this->catatan->TooltipValue = "";

            // rencanakemasan
            $this->rencanakemasan->LinkCustomAttributes = "";
            $this->rencanakemasan->HrefValue = "";
            $this->rencanakemasan->TooltipValue = "";

            // ekspetasiharga
            $this->ekspetasiharga->LinkCustomAttributes = "";
            $this->ekspetasiharga->HrefValue = "";
            $this->ekspetasiharga->TooltipValue = "";

            // kemasan
            $this->kemasan->LinkCustomAttributes = "";
            $this->kemasan->HrefValue = "";
            $this->kemasan->TooltipValue = "";

            // volume
            $this->volume->LinkCustomAttributes = "";
            $this->volume->HrefValue = "";
            $this->volume->TooltipValue = "";

            // jenistutup
            $this->jenistutup->LinkCustomAttributes = "";
            $this->jenistutup->HrefValue = "";
            $this->jenistutup->TooltipValue = "";

            // infopackaging
            $this->infopackaging->LinkCustomAttributes = "";
            $this->infopackaging->HrefValue = "";
            $this->infopackaging->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";

            // desainprodukkemasan
            $this->desainprodukkemasan->LinkCustomAttributes = "";
            $this->desainprodukkemasan->HrefValue = "";
            $this->desainprodukkemasan->TooltipValue = "";

            // desaindiinginkan
            $this->desaindiinginkan->LinkCustomAttributes = "";
            $this->desaindiinginkan->HrefValue = "";
            $this->desaindiinginkan->TooltipValue = "";

            // mereknotifikasi
            $this->mereknotifikasi->LinkCustomAttributes = "";
            $this->mereknotifikasi->HrefValue = "";
            $this->mereknotifikasi->TooltipValue = "";

            // kategoristatus
            $this->kategoristatus->LinkCustomAttributes = "";
            $this->kategoristatus->HrefValue = "";
            $this->kategoristatus->TooltipValue = "";

            // kemasan_ukuran_satuan
            $this->kemasan_ukuran_satuan->LinkCustomAttributes = "";
            $this->kemasan_ukuran_satuan->HrefValue = "";
            $this->kemasan_ukuran_satuan->TooltipValue = "";

            // infolabel
            $this->infolabel->LinkCustomAttributes = "";
            $this->infolabel->HrefValue = "";
            $this->infolabel->TooltipValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";
            $this->labelkualitas->TooltipValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";
            $this->labelposisi->TooltipValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";
            $this->dibuatdi->TooltipValue = "";

            // tanggal
            $this->tanggal->LinkCustomAttributes = "";
            $this->tanggal->HrefValue = "";
            $this->tanggal->TooltipValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";
            $this->penerima->TooltipValue = "";

            // createat
            $this->createat->LinkCustomAttributes = "";
            $this->createat->HrefValue = "";
            $this->createat->TooltipValue = "";

            // createby
            $this->createby->LinkCustomAttributes = "";
            $this->createby->HrefValue = "";
            $this->createby->TooltipValue = "";

            // statusdokumen
            $this->statusdokumen->LinkCustomAttributes = "";
            $this->statusdokumen->HrefValue = "";
            $this->statusdokumen->TooltipValue = "";

            // update_at
            $this->update_at->LinkCustomAttributes = "";
            $this->update_at->HrefValue = "";
            $this->update_at->TooltipValue = "";

            // status_data
            $this->status_data->LinkCustomAttributes = "";
            $this->status_data->HrefValue = "";
            $this->status_data->TooltipValue = "";

            // harga_rnd
            $this->harga_rnd->LinkCustomAttributes = "";
            $this->harga_rnd->HrefValue = "";
            $this->harga_rnd->TooltipValue = "";

            // aplikasi_sediaan
            $this->aplikasi_sediaan->LinkCustomAttributes = "";
            $this->aplikasi_sediaan->HrefValue = "";
            $this->aplikasi_sediaan->TooltipValue = "";

            // hu_hrg_isi
            $this->hu_hrg_isi->LinkCustomAttributes = "";
            $this->hu_hrg_isi->HrefValue = "";
            $this->hu_hrg_isi->TooltipValue = "";

            // hu_hrg_isi_pro
            $this->hu_hrg_isi_pro->LinkCustomAttributes = "";
            $this->hu_hrg_isi_pro->HrefValue = "";
            $this->hu_hrg_isi_pro->TooltipValue = "";

            // hu_hrg_kms_primer
            $this->hu_hrg_kms_primer->LinkCustomAttributes = "";
            $this->hu_hrg_kms_primer->HrefValue = "";
            $this->hu_hrg_kms_primer->TooltipValue = "";

            // hu_hrg_kms_primer_pro
            $this->hu_hrg_kms_primer_pro->LinkCustomAttributes = "";
            $this->hu_hrg_kms_primer_pro->HrefValue = "";
            $this->hu_hrg_kms_primer_pro->TooltipValue = "";

            // hu_hrg_kms_sekunder
            $this->hu_hrg_kms_sekunder->LinkCustomAttributes = "";
            $this->hu_hrg_kms_sekunder->HrefValue = "";
            $this->hu_hrg_kms_sekunder->TooltipValue = "";

            // hu_hrg_kms_sekunder_pro
            $this->hu_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
            $this->hu_hrg_kms_sekunder_pro->HrefValue = "";
            $this->hu_hrg_kms_sekunder_pro->TooltipValue = "";

            // hu_hrg_label
            $this->hu_hrg_label->LinkCustomAttributes = "";
            $this->hu_hrg_label->HrefValue = "";
            $this->hu_hrg_label->TooltipValue = "";

            // hu_hrg_label_pro
            $this->hu_hrg_label_pro->LinkCustomAttributes = "";
            $this->hu_hrg_label_pro->HrefValue = "";
            $this->hu_hrg_label_pro->TooltipValue = "";

            // hu_hrg_total
            $this->hu_hrg_total->LinkCustomAttributes = "";
            $this->hu_hrg_total->HrefValue = "";
            $this->hu_hrg_total->TooltipValue = "";

            // hu_hrg_total_pro
            $this->hu_hrg_total_pro->LinkCustomAttributes = "";
            $this->hu_hrg_total_pro->HrefValue = "";
            $this->hu_hrg_total_pro->TooltipValue = "";

            // hl_hrg_isi
            $this->hl_hrg_isi->LinkCustomAttributes = "";
            $this->hl_hrg_isi->HrefValue = "";
            $this->hl_hrg_isi->TooltipValue = "";

            // hl_hrg_isi_pro
            $this->hl_hrg_isi_pro->LinkCustomAttributes = "";
            $this->hl_hrg_isi_pro->HrefValue = "";
            $this->hl_hrg_isi_pro->TooltipValue = "";

            // hl_hrg_kms_primer
            $this->hl_hrg_kms_primer->LinkCustomAttributes = "";
            $this->hl_hrg_kms_primer->HrefValue = "";
            $this->hl_hrg_kms_primer->TooltipValue = "";

            // hl_hrg_kms_primer_pro
            $this->hl_hrg_kms_primer_pro->LinkCustomAttributes = "";
            $this->hl_hrg_kms_primer_pro->HrefValue = "";
            $this->hl_hrg_kms_primer_pro->TooltipValue = "";

            // hl_hrg_kms_sekunder
            $this->hl_hrg_kms_sekunder->LinkCustomAttributes = "";
            $this->hl_hrg_kms_sekunder->HrefValue = "";
            $this->hl_hrg_kms_sekunder->TooltipValue = "";

            // hl_hrg_kms_sekunder_pro
            $this->hl_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
            $this->hl_hrg_kms_sekunder_pro->HrefValue = "";
            $this->hl_hrg_kms_sekunder_pro->TooltipValue = "";

            // hl_hrg_label
            $this->hl_hrg_label->LinkCustomAttributes = "";
            $this->hl_hrg_label->HrefValue = "";
            $this->hl_hrg_label->TooltipValue = "";

            // hl_hrg_label_pro
            $this->hl_hrg_label_pro->LinkCustomAttributes = "";
            $this->hl_hrg_label_pro->HrefValue = "";
            $this->hl_hrg_label_pro->TooltipValue = "";

            // hl_hrg_total
            $this->hl_hrg_total->LinkCustomAttributes = "";
            $this->hl_hrg_total->HrefValue = "";
            $this->hl_hrg_total->TooltipValue = "";

            // hl_hrg_total_pro
            $this->hl_hrg_total_pro->LinkCustomAttributes = "";
            $this->hl_hrg_total_pro->HrefValue = "";
            $this->hl_hrg_total_pro->TooltipValue = "";

            // bs_bahan_aktif_tick
            $this->bs_bahan_aktif_tick->LinkCustomAttributes = "";
            $this->bs_bahan_aktif_tick->HrefValue = "";
            $this->bs_bahan_aktif_tick->TooltipValue = "";

            // aju_tgl
            $this->aju_tgl->LinkCustomAttributes = "";
            $this->aju_tgl->HrefValue = "";
            $this->aju_tgl->TooltipValue = "";

            // aju_oleh
            $this->aju_oleh->LinkCustomAttributes = "";
            $this->aju_oleh->HrefValue = "";
            $this->aju_oleh->TooltipValue = "";

            // proses_tgl
            $this->proses_tgl->LinkCustomAttributes = "";
            $this->proses_tgl->HrefValue = "";
            $this->proses_tgl->TooltipValue = "";

            // proses_oleh
            $this->proses_oleh->LinkCustomAttributes = "";
            $this->proses_oleh->HrefValue = "";
            $this->proses_oleh->TooltipValue = "";

            // revisi_tgl
            $this->revisi_tgl->LinkCustomAttributes = "";
            $this->revisi_tgl->HrefValue = "";
            $this->revisi_tgl->TooltipValue = "";

            // revisi_oleh
            $this->revisi_oleh->LinkCustomAttributes = "";
            $this->revisi_oleh->HrefValue = "";
            $this->revisi_oleh->TooltipValue = "";

            // revisi_akun_tgl
            $this->revisi_akun_tgl->LinkCustomAttributes = "";
            $this->revisi_akun_tgl->HrefValue = "";
            $this->revisi_akun_tgl->TooltipValue = "";

            // revisi_akun_oleh
            $this->revisi_akun_oleh->LinkCustomAttributes = "";
            $this->revisi_akun_oleh->HrefValue = "";
            $this->revisi_akun_oleh->TooltipValue = "";

            // revisi_rnd_tgl
            $this->revisi_rnd_tgl->LinkCustomAttributes = "";
            $this->revisi_rnd_tgl->HrefValue = "";
            $this->revisi_rnd_tgl->TooltipValue = "";

            // revisi_rnd_oleh
            $this->revisi_rnd_oleh->LinkCustomAttributes = "";
            $this->revisi_rnd_oleh->HrefValue = "";
            $this->revisi_rnd_oleh->TooltipValue = "";

            // rnd_tgl
            $this->rnd_tgl->LinkCustomAttributes = "";
            $this->rnd_tgl->HrefValue = "";
            $this->rnd_tgl->TooltipValue = "";

            // rnd_oleh
            $this->rnd_oleh->LinkCustomAttributes = "";
            $this->rnd_oleh->HrefValue = "";
            $this->rnd_oleh->TooltipValue = "";

            // ap_tgl
            $this->ap_tgl->LinkCustomAttributes = "";
            $this->ap_tgl->HrefValue = "";
            $this->ap_tgl->TooltipValue = "";

            // ap_oleh
            $this->ap_oleh->LinkCustomAttributes = "";
            $this->ap_oleh->HrefValue = "";
            $this->ap_oleh->TooltipValue = "";

            // batal_tgl
            $this->batal_tgl->LinkCustomAttributes = "";
            $this->batal_tgl->HrefValue = "";
            $this->batal_tgl->TooltipValue = "";

            // batal_oleh
            $this->batal_oleh->LinkCustomAttributes = "";
            $this->batal_oleh->HrefValue = "";
            $this->batal_oleh->TooltipValue = "";
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"forder_pengembanganlistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
