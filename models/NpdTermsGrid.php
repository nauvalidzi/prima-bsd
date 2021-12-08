<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdTermsGrid extends NpdTerms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_terms';

    // Page object name
    public $PageObjName = "NpdTermsGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpd_termsgrid";
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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

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
        $this->AddUrl = "NpdTermsAdd";

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

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
    public $ShowOtherOptions = false;
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

        // Set up lookup cache

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

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

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
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
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAll();
            $rs->closeCursor();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
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

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_id") && $CurrentForm->hasValue("o_id") && $this->id->CurrentValue != $this->id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idnpd") && $CurrentForm->hasValue("o_idnpd") && $this->idnpd->CurrentValue != $this->idnpd->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status") && $CurrentForm->hasValue("o_status") && $this->status->CurrentValue != $this->status->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_tglsubmit") && $CurrentForm->hasValue("o_tglsubmit") && $this->tglsubmit->CurrentValue != $this->tglsubmit->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_sifat_order") && $CurrentForm->hasValue("o_sifat_order") && ConvertToBool($this->sifat_order->CurrentValue) != ConvertToBool($this->sifat_order->OldValue)) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ukuran_utama") && $CurrentForm->hasValue("o_ukuran_utama") && $this->ukuran_utama->CurrentValue != $this->ukuran_utama->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_isi") && $CurrentForm->hasValue("o_utama_harga_isi") && $this->utama_harga_isi->CurrentValue != $this->utama_harga_isi->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_isi_order") && $CurrentForm->hasValue("o_utama_harga_isi_order") && $this->utama_harga_isi_order->CurrentValue != $this->utama_harga_isi_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_primer") && $CurrentForm->hasValue("o_utama_harga_primer") && $this->utama_harga_primer->CurrentValue != $this->utama_harga_primer->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_primer_order") && $CurrentForm->hasValue("o_utama_harga_primer_order") && $this->utama_harga_primer_order->CurrentValue != $this->utama_harga_primer_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_sekunder") && $CurrentForm->hasValue("o_utama_harga_sekunder") && $this->utama_harga_sekunder->CurrentValue != $this->utama_harga_sekunder->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_sekunder_order") && $CurrentForm->hasValue("o_utama_harga_sekunder_order") && $this->utama_harga_sekunder_order->CurrentValue != $this->utama_harga_sekunder_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_label") && $CurrentForm->hasValue("o_utama_harga_label") && $this->utama_harga_label->CurrentValue != $this->utama_harga_label->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_label_order") && $CurrentForm->hasValue("o_utama_harga_label_order") && $this->utama_harga_label_order->CurrentValue != $this->utama_harga_label_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_total") && $CurrentForm->hasValue("o_utama_harga_total") && $this->utama_harga_total->CurrentValue != $this->utama_harga_total->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_utama_harga_total_order") && $CurrentForm->hasValue("o_utama_harga_total_order") && $this->utama_harga_total_order->CurrentValue != $this->utama_harga_total_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_ukuran_lain") && $CurrentForm->hasValue("o_ukuran_lain") && $this->ukuran_lain->CurrentValue != $this->ukuran_lain->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_isi") && $CurrentForm->hasValue("o_lain_harga_isi") && $this->lain_harga_isi->CurrentValue != $this->lain_harga_isi->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_isi_order") && $CurrentForm->hasValue("o_lain_harga_isi_order") && $this->lain_harga_isi_order->CurrentValue != $this->lain_harga_isi_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_primer") && $CurrentForm->hasValue("o_lain_harga_primer") && $this->lain_harga_primer->CurrentValue != $this->lain_harga_primer->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_primer_order") && $CurrentForm->hasValue("o_lain_harga_primer_order") && $this->lain_harga_primer_order->CurrentValue != $this->lain_harga_primer_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_sekunder") && $CurrentForm->hasValue("o_lain_harga_sekunder") && $this->lain_harga_sekunder->CurrentValue != $this->lain_harga_sekunder->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_sekunder_order") && $CurrentForm->hasValue("o_lain_harga_sekunder_order") && $this->lain_harga_sekunder_order->CurrentValue != $this->lain_harga_sekunder_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_label") && $CurrentForm->hasValue("o_lain_harga_label") && $this->lain_harga_label->CurrentValue != $this->lain_harga_label->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_label_order") && $CurrentForm->hasValue("o_lain_harga_label_order") && $this->lain_harga_label_order->CurrentValue != $this->lain_harga_label_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_total") && $CurrentForm->hasValue("o_lain_harga_total") && $this->lain_harga_total->CurrentValue != $this->lain_harga_total->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_lain_harga_total_order") && $CurrentForm->hasValue("o_lain_harga_total_order") && $this->lain_harga_total_order->CurrentValue != $this->lain_harga_total_order->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_isi_bahan_aktif") && $CurrentForm->hasValue("o_isi_bahan_aktif") && $this->isi_bahan_aktif->CurrentValue != $this->isi_bahan_aktif->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_isi_bahan_lain") && $CurrentForm->hasValue("o_isi_bahan_lain") && $this->isi_bahan_lain->CurrentValue != $this->isi_bahan_lain->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_isi_parfum") && $CurrentForm->hasValue("o_isi_parfum") && $this->isi_parfum->CurrentValue != $this->isi_parfum->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_isi_estetika") && $CurrentForm->hasValue("o_isi_estetika") && $this->isi_estetika->CurrentValue != $this->isi_estetika->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_kemasan_wadah") && $CurrentForm->hasValue("o_kemasan_wadah") && $this->kemasan_wadah->CurrentValue != $this->kemasan_wadah->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_kemasan_tutup") && $CurrentForm->hasValue("o_kemasan_tutup") && $this->kemasan_tutup->CurrentValue != $this->kemasan_tutup->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_kemasan_sekunder") && $CurrentForm->hasValue("o_kemasan_sekunder") && $this->kemasan_sekunder->CurrentValue != $this->kemasan_sekunder->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_label_desain") && $CurrentForm->hasValue("o_label_desain") && $this->label_desain->CurrentValue != $this->label_desain->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_label_cetak") && $CurrentForm->hasValue("o_label_cetak") && $this->label_cetak->CurrentValue != $this->label_cetak->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_label_lainlain") && $CurrentForm->hasValue("o_label_lainlain") && $this->label_lainlain->CurrentValue != $this->label_lainlain->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_delivery_pickup") && $CurrentForm->hasValue("o_delivery_pickup") && $this->delivery_pickup->CurrentValue != $this->delivery_pickup->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_delivery_singlepoint") && $CurrentForm->hasValue("o_delivery_singlepoint") && $this->delivery_singlepoint->CurrentValue != $this->delivery_singlepoint->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_delivery_multipoint") && $CurrentForm->hasValue("o_delivery_multipoint") && $this->delivery_multipoint->CurrentValue != $this->delivery_multipoint->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_delivery_jumlahpoint") && $CurrentForm->hasValue("o_delivery_jumlahpoint") && $this->delivery_jumlahpoint->CurrentValue != $this->delivery_jumlahpoint->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_delivery_termslain") && $CurrentForm->hasValue("o_delivery_termslain") && $this->delivery_termslain->CurrentValue != $this->delivery_termslain->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_dibuatdi") && $CurrentForm->hasValue("o_dibuatdi") && $this->dibuatdi->CurrentValue != $this->dibuatdi->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_created_at") && $CurrentForm->hasValue("o_created_at") && $this->created_at->CurrentValue != $this->created_at->OldValue) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->id->clearErrorMessage();
        $this->idnpd->clearErrorMessage();
        $this->status->clearErrorMessage();
        $this->tglsubmit->clearErrorMessage();
        $this->sifat_order->clearErrorMessage();
        $this->ukuran_utama->clearErrorMessage();
        $this->utama_harga_isi->clearErrorMessage();
        $this->utama_harga_isi_order->clearErrorMessage();
        $this->utama_harga_primer->clearErrorMessage();
        $this->utama_harga_primer_order->clearErrorMessage();
        $this->utama_harga_sekunder->clearErrorMessage();
        $this->utama_harga_sekunder_order->clearErrorMessage();
        $this->utama_harga_label->clearErrorMessage();
        $this->utama_harga_label_order->clearErrorMessage();
        $this->utama_harga_total->clearErrorMessage();
        $this->utama_harga_total_order->clearErrorMessage();
        $this->ukuran_lain->clearErrorMessage();
        $this->lain_harga_isi->clearErrorMessage();
        $this->lain_harga_isi_order->clearErrorMessage();
        $this->lain_harga_primer->clearErrorMessage();
        $this->lain_harga_primer_order->clearErrorMessage();
        $this->lain_harga_sekunder->clearErrorMessage();
        $this->lain_harga_sekunder_order->clearErrorMessage();
        $this->lain_harga_label->clearErrorMessage();
        $this->lain_harga_label_order->clearErrorMessage();
        $this->lain_harga_total->clearErrorMessage();
        $this->lain_harga_total_order->clearErrorMessage();
        $this->isi_bahan_aktif->clearErrorMessage();
        $this->isi_bahan_lain->clearErrorMessage();
        $this->isi_parfum->clearErrorMessage();
        $this->isi_estetika->clearErrorMessage();
        $this->kemasan_wadah->clearErrorMessage();
        $this->kemasan_tutup->clearErrorMessage();
        $this->kemasan_sekunder->clearErrorMessage();
        $this->label_desain->clearErrorMessage();
        $this->label_cetak->clearErrorMessage();
        $this->label_lainlain->clearErrorMessage();
        $this->delivery_pickup->clearErrorMessage();
        $this->delivery_singlepoint->clearErrorMessage();
        $this->delivery_multipoint->clearErrorMessage();
        $this->delivery_jumlahpoint->clearErrorMessage();
        $this->delivery_termslain->clearErrorMessage();
        $this->dibuatdi->clearErrorMessage();
        $this->created_at->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
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

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = false;
            $item->Visible = false; // Default hidden
        }

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

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
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
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $option->UseDropDownButton = false;
        $option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $option->UseButtonGroup = true;
        //$option->ButtonClass = ""; // Class for button group
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
            if ($this->AllowAddDeleteRow) {
                $option = $options["addedit"];
                $option->UseDropDownButton = false;
                $item = &$option->add("addblankrow");
                $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                $item->Visible = $Security->canAdd();
                $this->ShowOtherOptions = $item->Visible;
            }
        }
        if ($this->CurrentMode == "view") { // Check view mode
            $option = $options["addedit"];
            $item = $option["add"];
            $this->ShowOtherOptions = $item && $item->Visible;
        }
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
        $this->idnpd->CurrentValue = 0;
        $this->idnpd->OldValue = $this->idnpd->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->tglsubmit->CurrentValue = null;
        $this->tglsubmit->OldValue = $this->tglsubmit->CurrentValue;
        $this->sifat_order->CurrentValue = 0;
        $this->sifat_order->OldValue = $this->sifat_order->CurrentValue;
        $this->ukuran_utama->CurrentValue = null;
        $this->ukuran_utama->OldValue = $this->ukuran_utama->CurrentValue;
        $this->utama_harga_isi->CurrentValue = null;
        $this->utama_harga_isi->OldValue = $this->utama_harga_isi->CurrentValue;
        $this->utama_harga_isi_order->CurrentValue = null;
        $this->utama_harga_isi_order->OldValue = $this->utama_harga_isi_order->CurrentValue;
        $this->utama_harga_primer->CurrentValue = null;
        $this->utama_harga_primer->OldValue = $this->utama_harga_primer->CurrentValue;
        $this->utama_harga_primer_order->CurrentValue = null;
        $this->utama_harga_primer_order->OldValue = $this->utama_harga_primer_order->CurrentValue;
        $this->utama_harga_sekunder->CurrentValue = null;
        $this->utama_harga_sekunder->OldValue = $this->utama_harga_sekunder->CurrentValue;
        $this->utama_harga_sekunder_order->CurrentValue = null;
        $this->utama_harga_sekunder_order->OldValue = $this->utama_harga_sekunder_order->CurrentValue;
        $this->utama_harga_label->CurrentValue = null;
        $this->utama_harga_label->OldValue = $this->utama_harga_label->CurrentValue;
        $this->utama_harga_label_order->CurrentValue = null;
        $this->utama_harga_label_order->OldValue = $this->utama_harga_label_order->CurrentValue;
        $this->utama_harga_total->CurrentValue = null;
        $this->utama_harga_total->OldValue = $this->utama_harga_total->CurrentValue;
        $this->utama_harga_total_order->CurrentValue = null;
        $this->utama_harga_total_order->OldValue = $this->utama_harga_total_order->CurrentValue;
        $this->ukuran_lain->CurrentValue = null;
        $this->ukuran_lain->OldValue = $this->ukuran_lain->CurrentValue;
        $this->lain_harga_isi->CurrentValue = null;
        $this->lain_harga_isi->OldValue = $this->lain_harga_isi->CurrentValue;
        $this->lain_harga_isi_order->CurrentValue = null;
        $this->lain_harga_isi_order->OldValue = $this->lain_harga_isi_order->CurrentValue;
        $this->lain_harga_primer->CurrentValue = null;
        $this->lain_harga_primer->OldValue = $this->lain_harga_primer->CurrentValue;
        $this->lain_harga_primer_order->CurrentValue = null;
        $this->lain_harga_primer_order->OldValue = $this->lain_harga_primer_order->CurrentValue;
        $this->lain_harga_sekunder->CurrentValue = null;
        $this->lain_harga_sekunder->OldValue = $this->lain_harga_sekunder->CurrentValue;
        $this->lain_harga_sekunder_order->CurrentValue = null;
        $this->lain_harga_sekunder_order->OldValue = $this->lain_harga_sekunder_order->CurrentValue;
        $this->lain_harga_label->CurrentValue = null;
        $this->lain_harga_label->OldValue = $this->lain_harga_label->CurrentValue;
        $this->lain_harga_label_order->CurrentValue = null;
        $this->lain_harga_label_order->OldValue = $this->lain_harga_label_order->CurrentValue;
        $this->lain_harga_total->CurrentValue = null;
        $this->lain_harga_total->OldValue = $this->lain_harga_total->CurrentValue;
        $this->lain_harga_total_order->CurrentValue = null;
        $this->lain_harga_total_order->OldValue = $this->lain_harga_total_order->CurrentValue;
        $this->isi_bahan_aktif->CurrentValue = null;
        $this->isi_bahan_aktif->OldValue = $this->isi_bahan_aktif->CurrentValue;
        $this->isi_bahan_lain->CurrentValue = null;
        $this->isi_bahan_lain->OldValue = $this->isi_bahan_lain->CurrentValue;
        $this->isi_parfum->CurrentValue = null;
        $this->isi_parfum->OldValue = $this->isi_parfum->CurrentValue;
        $this->isi_estetika->CurrentValue = null;
        $this->isi_estetika->OldValue = $this->isi_estetika->CurrentValue;
        $this->kemasan_wadah->CurrentValue = null;
        $this->kemasan_wadah->OldValue = $this->kemasan_wadah->CurrentValue;
        $this->kemasan_tutup->CurrentValue = null;
        $this->kemasan_tutup->OldValue = $this->kemasan_tutup->CurrentValue;
        $this->kemasan_sekunder->CurrentValue = null;
        $this->kemasan_sekunder->OldValue = $this->kemasan_sekunder->CurrentValue;
        $this->label_desain->CurrentValue = null;
        $this->label_desain->OldValue = $this->label_desain->CurrentValue;
        $this->label_cetak->CurrentValue = null;
        $this->label_cetak->OldValue = $this->label_cetak->CurrentValue;
        $this->label_lainlain->CurrentValue = null;
        $this->label_lainlain->OldValue = $this->label_lainlain->CurrentValue;
        $this->delivery_pickup->CurrentValue = null;
        $this->delivery_pickup->OldValue = $this->delivery_pickup->CurrentValue;
        $this->delivery_singlepoint->CurrentValue = null;
        $this->delivery_singlepoint->OldValue = $this->delivery_singlepoint->CurrentValue;
        $this->delivery_multipoint->CurrentValue = null;
        $this->delivery_multipoint->OldValue = $this->delivery_multipoint->CurrentValue;
        $this->delivery_jumlahpoint->CurrentValue = null;
        $this->delivery_jumlahpoint->OldValue = $this->delivery_jumlahpoint->CurrentValue;
        $this->delivery_termslain->CurrentValue = null;
        $this->delivery_termslain->OldValue = $this->delivery_termslain->CurrentValue;
        $this->catatan_khusus->CurrentValue = null;
        $this->catatan_khusus->OldValue = $this->catatan_khusus->CurrentValue;
        $this->dibuatdi->CurrentValue = null;
        $this->dibuatdi->OldValue = $this->dibuatdi->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id->Visible = false; // Disable update for API request
            } else {
                $this->id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_id")) {
            $this->id->setOldValue($CurrentForm->getValue("o_id"));
        }

        // Check field name 'idnpd' first before field var 'x_idnpd'
        $val = $CurrentForm->hasValue("idnpd") ? $CurrentForm->getValue("idnpd") : $CurrentForm->getValue("x_idnpd");
        if (!$this->idnpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd->Visible = false; // Disable update for API request
            } else {
                $this->idnpd->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idnpd")) {
            $this->idnpd->setOldValue($CurrentForm->getValue("o_idnpd"));
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_status")) {
            $this->status->setOldValue($CurrentForm->getValue("o_status"));
        }

        // Check field name 'tglsubmit' first before field var 'x_tglsubmit'
        $val = $CurrentForm->hasValue("tglsubmit") ? $CurrentForm->getValue("tglsubmit") : $CurrentForm->getValue("x_tglsubmit");
        if (!$this->tglsubmit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglsubmit->Visible = false; // Disable update for API request
            } else {
                $this->tglsubmit->setFormValue($val);
            }
            $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_tglsubmit")) {
            $this->tglsubmit->setOldValue($CurrentForm->getValue("o_tglsubmit"));
        }

        // Check field name 'sifat_order' first before field var 'x_sifat_order'
        $val = $CurrentForm->hasValue("sifat_order") ? $CurrentForm->getValue("sifat_order") : $CurrentForm->getValue("x_sifat_order");
        if (!$this->sifat_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sifat_order->Visible = false; // Disable update for API request
            } else {
                $this->sifat_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_sifat_order")) {
            $this->sifat_order->setOldValue($CurrentForm->getValue("o_sifat_order"));
        }

        // Check field name 'ukuran_utama' first before field var 'x_ukuran_utama'
        $val = $CurrentForm->hasValue("ukuran_utama") ? $CurrentForm->getValue("ukuran_utama") : $CurrentForm->getValue("x_ukuran_utama");
        if (!$this->ukuran_utama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran_utama->Visible = false; // Disable update for API request
            } else {
                $this->ukuran_utama->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ukuran_utama")) {
            $this->ukuran_utama->setOldValue($CurrentForm->getValue("o_ukuran_utama"));
        }

        // Check field name 'utama_harga_isi' first before field var 'x_utama_harga_isi'
        $val = $CurrentForm->hasValue("utama_harga_isi") ? $CurrentForm->getValue("utama_harga_isi") : $CurrentForm->getValue("x_utama_harga_isi");
        if (!$this->utama_harga_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_isi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_isi->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_isi")) {
            $this->utama_harga_isi->setOldValue($CurrentForm->getValue("o_utama_harga_isi"));
        }

        // Check field name 'utama_harga_isi_order' first before field var 'x_utama_harga_isi_order'
        $val = $CurrentForm->hasValue("utama_harga_isi_order") ? $CurrentForm->getValue("utama_harga_isi_order") : $CurrentForm->getValue("x_utama_harga_isi_order");
        if (!$this->utama_harga_isi_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_isi_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_isi_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_isi_order")) {
            $this->utama_harga_isi_order->setOldValue($CurrentForm->getValue("o_utama_harga_isi_order"));
        }

        // Check field name 'utama_harga_primer' first before field var 'x_utama_harga_primer'
        $val = $CurrentForm->hasValue("utama_harga_primer") ? $CurrentForm->getValue("utama_harga_primer") : $CurrentForm->getValue("x_utama_harga_primer");
        if (!$this->utama_harga_primer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_primer->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_primer->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_primer")) {
            $this->utama_harga_primer->setOldValue($CurrentForm->getValue("o_utama_harga_primer"));
        }

        // Check field name 'utama_harga_primer_order' first before field var 'x_utama_harga_primer_order'
        $val = $CurrentForm->hasValue("utama_harga_primer_order") ? $CurrentForm->getValue("utama_harga_primer_order") : $CurrentForm->getValue("x_utama_harga_primer_order");
        if (!$this->utama_harga_primer_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_primer_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_primer_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_primer_order")) {
            $this->utama_harga_primer_order->setOldValue($CurrentForm->getValue("o_utama_harga_primer_order"));
        }

        // Check field name 'utama_harga_sekunder' first before field var 'x_utama_harga_sekunder'
        $val = $CurrentForm->hasValue("utama_harga_sekunder") ? $CurrentForm->getValue("utama_harga_sekunder") : $CurrentForm->getValue("x_utama_harga_sekunder");
        if (!$this->utama_harga_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_sekunder->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_sekunder")) {
            $this->utama_harga_sekunder->setOldValue($CurrentForm->getValue("o_utama_harga_sekunder"));
        }

        // Check field name 'utama_harga_sekunder_order' first before field var 'x_utama_harga_sekunder_order'
        $val = $CurrentForm->hasValue("utama_harga_sekunder_order") ? $CurrentForm->getValue("utama_harga_sekunder_order") : $CurrentForm->getValue("x_utama_harga_sekunder_order");
        if (!$this->utama_harga_sekunder_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_sekunder_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_sekunder_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_sekunder_order")) {
            $this->utama_harga_sekunder_order->setOldValue($CurrentForm->getValue("o_utama_harga_sekunder_order"));
        }

        // Check field name 'utama_harga_label' first before field var 'x_utama_harga_label'
        $val = $CurrentForm->hasValue("utama_harga_label") ? $CurrentForm->getValue("utama_harga_label") : $CurrentForm->getValue("x_utama_harga_label");
        if (!$this->utama_harga_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_label->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_label->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_label")) {
            $this->utama_harga_label->setOldValue($CurrentForm->getValue("o_utama_harga_label"));
        }

        // Check field name 'utama_harga_label_order' first before field var 'x_utama_harga_label_order'
        $val = $CurrentForm->hasValue("utama_harga_label_order") ? $CurrentForm->getValue("utama_harga_label_order") : $CurrentForm->getValue("x_utama_harga_label_order");
        if (!$this->utama_harga_label_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_label_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_label_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_label_order")) {
            $this->utama_harga_label_order->setOldValue($CurrentForm->getValue("o_utama_harga_label_order"));
        }

        // Check field name 'utama_harga_total' first before field var 'x_utama_harga_total'
        $val = $CurrentForm->hasValue("utama_harga_total") ? $CurrentForm->getValue("utama_harga_total") : $CurrentForm->getValue("x_utama_harga_total");
        if (!$this->utama_harga_total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_total->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_total->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_total")) {
            $this->utama_harga_total->setOldValue($CurrentForm->getValue("o_utama_harga_total"));
        }

        // Check field name 'utama_harga_total_order' first before field var 'x_utama_harga_total_order'
        $val = $CurrentForm->hasValue("utama_harga_total_order") ? $CurrentForm->getValue("utama_harga_total_order") : $CurrentForm->getValue("x_utama_harga_total_order");
        if (!$this->utama_harga_total_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_total_order->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_total_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_utama_harga_total_order")) {
            $this->utama_harga_total_order->setOldValue($CurrentForm->getValue("o_utama_harga_total_order"));
        }

        // Check field name 'ukuran_lain' first before field var 'x_ukuran_lain'
        $val = $CurrentForm->hasValue("ukuran_lain") ? $CurrentForm->getValue("ukuran_lain") : $CurrentForm->getValue("x_ukuran_lain");
        if (!$this->ukuran_lain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran_lain->Visible = false; // Disable update for API request
            } else {
                $this->ukuran_lain->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ukuran_lain")) {
            $this->ukuran_lain->setOldValue($CurrentForm->getValue("o_ukuran_lain"));
        }

        // Check field name 'lain_harga_isi' first before field var 'x_lain_harga_isi'
        $val = $CurrentForm->hasValue("lain_harga_isi") ? $CurrentForm->getValue("lain_harga_isi") : $CurrentForm->getValue("x_lain_harga_isi");
        if (!$this->lain_harga_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_isi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_isi->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_isi")) {
            $this->lain_harga_isi->setOldValue($CurrentForm->getValue("o_lain_harga_isi"));
        }

        // Check field name 'lain_harga_isi_order' first before field var 'x_lain_harga_isi_order'
        $val = $CurrentForm->hasValue("lain_harga_isi_order") ? $CurrentForm->getValue("lain_harga_isi_order") : $CurrentForm->getValue("x_lain_harga_isi_order");
        if (!$this->lain_harga_isi_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_isi_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_isi_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_isi_order")) {
            $this->lain_harga_isi_order->setOldValue($CurrentForm->getValue("o_lain_harga_isi_order"));
        }

        // Check field name 'lain_harga_primer' first before field var 'x_lain_harga_primer'
        $val = $CurrentForm->hasValue("lain_harga_primer") ? $CurrentForm->getValue("lain_harga_primer") : $CurrentForm->getValue("x_lain_harga_primer");
        if (!$this->lain_harga_primer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_primer->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_primer->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_primer")) {
            $this->lain_harga_primer->setOldValue($CurrentForm->getValue("o_lain_harga_primer"));
        }

        // Check field name 'lain_harga_primer_order' first before field var 'x_lain_harga_primer_order'
        $val = $CurrentForm->hasValue("lain_harga_primer_order") ? $CurrentForm->getValue("lain_harga_primer_order") : $CurrentForm->getValue("x_lain_harga_primer_order");
        if (!$this->lain_harga_primer_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_primer_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_primer_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_primer_order")) {
            $this->lain_harga_primer_order->setOldValue($CurrentForm->getValue("o_lain_harga_primer_order"));
        }

        // Check field name 'lain_harga_sekunder' first before field var 'x_lain_harga_sekunder'
        $val = $CurrentForm->hasValue("lain_harga_sekunder") ? $CurrentForm->getValue("lain_harga_sekunder") : $CurrentForm->getValue("x_lain_harga_sekunder");
        if (!$this->lain_harga_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_sekunder->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_sekunder")) {
            $this->lain_harga_sekunder->setOldValue($CurrentForm->getValue("o_lain_harga_sekunder"));
        }

        // Check field name 'lain_harga_sekunder_order' first before field var 'x_lain_harga_sekunder_order'
        $val = $CurrentForm->hasValue("lain_harga_sekunder_order") ? $CurrentForm->getValue("lain_harga_sekunder_order") : $CurrentForm->getValue("x_lain_harga_sekunder_order");
        if (!$this->lain_harga_sekunder_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_sekunder_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_sekunder_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_sekunder_order")) {
            $this->lain_harga_sekunder_order->setOldValue($CurrentForm->getValue("o_lain_harga_sekunder_order"));
        }

        // Check field name 'lain_harga_label' first before field var 'x_lain_harga_label'
        $val = $CurrentForm->hasValue("lain_harga_label") ? $CurrentForm->getValue("lain_harga_label") : $CurrentForm->getValue("x_lain_harga_label");
        if (!$this->lain_harga_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_label->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_label->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_label")) {
            $this->lain_harga_label->setOldValue($CurrentForm->getValue("o_lain_harga_label"));
        }

        // Check field name 'lain_harga_label_order' first before field var 'x_lain_harga_label_order'
        $val = $CurrentForm->hasValue("lain_harga_label_order") ? $CurrentForm->getValue("lain_harga_label_order") : $CurrentForm->getValue("x_lain_harga_label_order");
        if (!$this->lain_harga_label_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_label_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_label_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_label_order")) {
            $this->lain_harga_label_order->setOldValue($CurrentForm->getValue("o_lain_harga_label_order"));
        }

        // Check field name 'lain_harga_total' first before field var 'x_lain_harga_total'
        $val = $CurrentForm->hasValue("lain_harga_total") ? $CurrentForm->getValue("lain_harga_total") : $CurrentForm->getValue("x_lain_harga_total");
        if (!$this->lain_harga_total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_total->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_total->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_total")) {
            $this->lain_harga_total->setOldValue($CurrentForm->getValue("o_lain_harga_total"));
        }

        // Check field name 'lain_harga_total_order' first before field var 'x_lain_harga_total_order'
        $val = $CurrentForm->hasValue("lain_harga_total_order") ? $CurrentForm->getValue("lain_harga_total_order") : $CurrentForm->getValue("x_lain_harga_total_order");
        if (!$this->lain_harga_total_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_total_order->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_total_order->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_lain_harga_total_order")) {
            $this->lain_harga_total_order->setOldValue($CurrentForm->getValue("o_lain_harga_total_order"));
        }

        // Check field name 'isi_bahan_aktif' first before field var 'x_isi_bahan_aktif'
        $val = $CurrentForm->hasValue("isi_bahan_aktif") ? $CurrentForm->getValue("isi_bahan_aktif") : $CurrentForm->getValue("x_isi_bahan_aktif");
        if (!$this->isi_bahan_aktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_bahan_aktif->Visible = false; // Disable update for API request
            } else {
                $this->isi_bahan_aktif->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_isi_bahan_aktif")) {
            $this->isi_bahan_aktif->setOldValue($CurrentForm->getValue("o_isi_bahan_aktif"));
        }

        // Check field name 'isi_bahan_lain' first before field var 'x_isi_bahan_lain'
        $val = $CurrentForm->hasValue("isi_bahan_lain") ? $CurrentForm->getValue("isi_bahan_lain") : $CurrentForm->getValue("x_isi_bahan_lain");
        if (!$this->isi_bahan_lain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_bahan_lain->Visible = false; // Disable update for API request
            } else {
                $this->isi_bahan_lain->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_isi_bahan_lain")) {
            $this->isi_bahan_lain->setOldValue($CurrentForm->getValue("o_isi_bahan_lain"));
        }

        // Check field name 'isi_parfum' first before field var 'x_isi_parfum'
        $val = $CurrentForm->hasValue("isi_parfum") ? $CurrentForm->getValue("isi_parfum") : $CurrentForm->getValue("x_isi_parfum");
        if (!$this->isi_parfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_parfum->Visible = false; // Disable update for API request
            } else {
                $this->isi_parfum->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_isi_parfum")) {
            $this->isi_parfum->setOldValue($CurrentForm->getValue("o_isi_parfum"));
        }

        // Check field name 'isi_estetika' first before field var 'x_isi_estetika'
        $val = $CurrentForm->hasValue("isi_estetika") ? $CurrentForm->getValue("isi_estetika") : $CurrentForm->getValue("x_isi_estetika");
        if (!$this->isi_estetika->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isi_estetika->Visible = false; // Disable update for API request
            } else {
                $this->isi_estetika->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_isi_estetika")) {
            $this->isi_estetika->setOldValue($CurrentForm->getValue("o_isi_estetika"));
        }

        // Check field name 'kemasan_wadah' first before field var 'x_kemasan_wadah'
        $val = $CurrentForm->hasValue("kemasan_wadah") ? $CurrentForm->getValue("kemasan_wadah") : $CurrentForm->getValue("x_kemasan_wadah");
        if (!$this->kemasan_wadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_wadah->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_wadah->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_kemasan_wadah")) {
            $this->kemasan_wadah->setOldValue($CurrentForm->getValue("o_kemasan_wadah"));
        }

        // Check field name 'kemasan_tutup' first before field var 'x_kemasan_tutup'
        $val = $CurrentForm->hasValue("kemasan_tutup") ? $CurrentForm->getValue("kemasan_tutup") : $CurrentForm->getValue("x_kemasan_tutup");
        if (!$this->kemasan_tutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_tutup->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_tutup->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_kemasan_tutup")) {
            $this->kemasan_tutup->setOldValue($CurrentForm->getValue("o_kemasan_tutup"));
        }

        // Check field name 'kemasan_sekunder' first before field var 'x_kemasan_sekunder'
        $val = $CurrentForm->hasValue("kemasan_sekunder") ? $CurrentForm->getValue("kemasan_sekunder") : $CurrentForm->getValue("x_kemasan_sekunder");
        if (!$this->kemasan_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_sekunder->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_kemasan_sekunder")) {
            $this->kemasan_sekunder->setOldValue($CurrentForm->getValue("o_kemasan_sekunder"));
        }

        // Check field name 'label_desain' first before field var 'x_label_desain'
        $val = $CurrentForm->hasValue("label_desain") ? $CurrentForm->getValue("label_desain") : $CurrentForm->getValue("x_label_desain");
        if (!$this->label_desain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_desain->Visible = false; // Disable update for API request
            } else {
                $this->label_desain->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_label_desain")) {
            $this->label_desain->setOldValue($CurrentForm->getValue("o_label_desain"));
        }

        // Check field name 'label_cetak' first before field var 'x_label_cetak'
        $val = $CurrentForm->hasValue("label_cetak") ? $CurrentForm->getValue("label_cetak") : $CurrentForm->getValue("x_label_cetak");
        if (!$this->label_cetak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_cetak->Visible = false; // Disable update for API request
            } else {
                $this->label_cetak->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_label_cetak")) {
            $this->label_cetak->setOldValue($CurrentForm->getValue("o_label_cetak"));
        }

        // Check field name 'label_lainlain' first before field var 'x_label_lainlain'
        $val = $CurrentForm->hasValue("label_lainlain") ? $CurrentForm->getValue("label_lainlain") : $CurrentForm->getValue("x_label_lainlain");
        if (!$this->label_lainlain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_lainlain->Visible = false; // Disable update for API request
            } else {
                $this->label_lainlain->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_label_lainlain")) {
            $this->label_lainlain->setOldValue($CurrentForm->getValue("o_label_lainlain"));
        }

        // Check field name 'delivery_pickup' first before field var 'x_delivery_pickup'
        $val = $CurrentForm->hasValue("delivery_pickup") ? $CurrentForm->getValue("delivery_pickup") : $CurrentForm->getValue("x_delivery_pickup");
        if (!$this->delivery_pickup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_pickup->Visible = false; // Disable update for API request
            } else {
                $this->delivery_pickup->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_delivery_pickup")) {
            $this->delivery_pickup->setOldValue($CurrentForm->getValue("o_delivery_pickup"));
        }

        // Check field name 'delivery_singlepoint' first before field var 'x_delivery_singlepoint'
        $val = $CurrentForm->hasValue("delivery_singlepoint") ? $CurrentForm->getValue("delivery_singlepoint") : $CurrentForm->getValue("x_delivery_singlepoint");
        if (!$this->delivery_singlepoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_singlepoint->Visible = false; // Disable update for API request
            } else {
                $this->delivery_singlepoint->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_delivery_singlepoint")) {
            $this->delivery_singlepoint->setOldValue($CurrentForm->getValue("o_delivery_singlepoint"));
        }

        // Check field name 'delivery_multipoint' first before field var 'x_delivery_multipoint'
        $val = $CurrentForm->hasValue("delivery_multipoint") ? $CurrentForm->getValue("delivery_multipoint") : $CurrentForm->getValue("x_delivery_multipoint");
        if (!$this->delivery_multipoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_multipoint->Visible = false; // Disable update for API request
            } else {
                $this->delivery_multipoint->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_delivery_multipoint")) {
            $this->delivery_multipoint->setOldValue($CurrentForm->getValue("o_delivery_multipoint"));
        }

        // Check field name 'delivery_jumlahpoint' first before field var 'x_delivery_jumlahpoint'
        $val = $CurrentForm->hasValue("delivery_jumlahpoint") ? $CurrentForm->getValue("delivery_jumlahpoint") : $CurrentForm->getValue("x_delivery_jumlahpoint");
        if (!$this->delivery_jumlahpoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_jumlahpoint->Visible = false; // Disable update for API request
            } else {
                $this->delivery_jumlahpoint->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_delivery_jumlahpoint")) {
            $this->delivery_jumlahpoint->setOldValue($CurrentForm->getValue("o_delivery_jumlahpoint"));
        }

        // Check field name 'delivery_termslain' first before field var 'x_delivery_termslain'
        $val = $CurrentForm->hasValue("delivery_termslain") ? $CurrentForm->getValue("delivery_termslain") : $CurrentForm->getValue("x_delivery_termslain");
        if (!$this->delivery_termslain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_termslain->Visible = false; // Disable update for API request
            } else {
                $this->delivery_termslain->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_delivery_termslain")) {
            $this->delivery_termslain->setOldValue($CurrentForm->getValue("o_delivery_termslain"));
        }

        // Check field name 'dibuatdi' first before field var 'x_dibuatdi'
        $val = $CurrentForm->hasValue("dibuatdi") ? $CurrentForm->getValue("dibuatdi") : $CurrentForm->getValue("x_dibuatdi");
        if (!$this->dibuatdi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dibuatdi->Visible = false; // Disable update for API request
            } else {
                $this->dibuatdi->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_dibuatdi")) {
            $this->dibuatdi->setOldValue($CurrentForm->getValue("o_dibuatdi"));
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_created_at")) {
            $this->created_at->setOldValue($CurrentForm->getValue("o_created_at"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        $this->sifat_order->CurrentValue = $this->sifat_order->FormValue;
        $this->ukuran_utama->CurrentValue = $this->ukuran_utama->FormValue;
        $this->utama_harga_isi->CurrentValue = $this->utama_harga_isi->FormValue;
        $this->utama_harga_isi_order->CurrentValue = $this->utama_harga_isi_order->FormValue;
        $this->utama_harga_primer->CurrentValue = $this->utama_harga_primer->FormValue;
        $this->utama_harga_primer_order->CurrentValue = $this->utama_harga_primer_order->FormValue;
        $this->utama_harga_sekunder->CurrentValue = $this->utama_harga_sekunder->FormValue;
        $this->utama_harga_sekunder_order->CurrentValue = $this->utama_harga_sekunder_order->FormValue;
        $this->utama_harga_label->CurrentValue = $this->utama_harga_label->FormValue;
        $this->utama_harga_label_order->CurrentValue = $this->utama_harga_label_order->FormValue;
        $this->utama_harga_total->CurrentValue = $this->utama_harga_total->FormValue;
        $this->utama_harga_total_order->CurrentValue = $this->utama_harga_total_order->FormValue;
        $this->ukuran_lain->CurrentValue = $this->ukuran_lain->FormValue;
        $this->lain_harga_isi->CurrentValue = $this->lain_harga_isi->FormValue;
        $this->lain_harga_isi_order->CurrentValue = $this->lain_harga_isi_order->FormValue;
        $this->lain_harga_primer->CurrentValue = $this->lain_harga_primer->FormValue;
        $this->lain_harga_primer_order->CurrentValue = $this->lain_harga_primer_order->FormValue;
        $this->lain_harga_sekunder->CurrentValue = $this->lain_harga_sekunder->FormValue;
        $this->lain_harga_sekunder_order->CurrentValue = $this->lain_harga_sekunder_order->FormValue;
        $this->lain_harga_label->CurrentValue = $this->lain_harga_label->FormValue;
        $this->lain_harga_label_order->CurrentValue = $this->lain_harga_label_order->FormValue;
        $this->lain_harga_total->CurrentValue = $this->lain_harga_total->FormValue;
        $this->lain_harga_total_order->CurrentValue = $this->lain_harga_total_order->FormValue;
        $this->isi_bahan_aktif->CurrentValue = $this->isi_bahan_aktif->FormValue;
        $this->isi_bahan_lain->CurrentValue = $this->isi_bahan_lain->FormValue;
        $this->isi_parfum->CurrentValue = $this->isi_parfum->FormValue;
        $this->isi_estetika->CurrentValue = $this->isi_estetika->FormValue;
        $this->kemasan_wadah->CurrentValue = $this->kemasan_wadah->FormValue;
        $this->kemasan_tutup->CurrentValue = $this->kemasan_tutup->FormValue;
        $this->kemasan_sekunder->CurrentValue = $this->kemasan_sekunder->FormValue;
        $this->label_desain->CurrentValue = $this->label_desain->FormValue;
        $this->label_cetak->CurrentValue = $this->label_cetak->FormValue;
        $this->label_lainlain->CurrentValue = $this->label_lainlain->FormValue;
        $this->delivery_pickup->CurrentValue = $this->delivery_pickup->FormValue;
        $this->delivery_singlepoint->CurrentValue = $this->delivery_singlepoint->FormValue;
        $this->delivery_multipoint->CurrentValue = $this->delivery_multipoint->FormValue;
        $this->delivery_jumlahpoint->CurrentValue = $this->delivery_jumlahpoint->FormValue;
        $this->delivery_termslain->CurrentValue = $this->delivery_termslain->FormValue;
        $this->dibuatdi->CurrentValue = $this->dibuatdi->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
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
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['tglsubmit'] = $this->tglsubmit->CurrentValue;
        $row['sifat_order'] = $this->sifat_order->CurrentValue;
        $row['ukuran_utama'] = $this->ukuran_utama->CurrentValue;
        $row['utama_harga_isi'] = $this->utama_harga_isi->CurrentValue;
        $row['utama_harga_isi_order'] = $this->utama_harga_isi_order->CurrentValue;
        $row['utama_harga_primer'] = $this->utama_harga_primer->CurrentValue;
        $row['utama_harga_primer_order'] = $this->utama_harga_primer_order->CurrentValue;
        $row['utama_harga_sekunder'] = $this->utama_harga_sekunder->CurrentValue;
        $row['utama_harga_sekunder_order'] = $this->utama_harga_sekunder_order->CurrentValue;
        $row['utama_harga_label'] = $this->utama_harga_label->CurrentValue;
        $row['utama_harga_label_order'] = $this->utama_harga_label_order->CurrentValue;
        $row['utama_harga_total'] = $this->utama_harga_total->CurrentValue;
        $row['utama_harga_total_order'] = $this->utama_harga_total_order->CurrentValue;
        $row['ukuran_lain'] = $this->ukuran_lain->CurrentValue;
        $row['lain_harga_isi'] = $this->lain_harga_isi->CurrentValue;
        $row['lain_harga_isi_order'] = $this->lain_harga_isi_order->CurrentValue;
        $row['lain_harga_primer'] = $this->lain_harga_primer->CurrentValue;
        $row['lain_harga_primer_order'] = $this->lain_harga_primer_order->CurrentValue;
        $row['lain_harga_sekunder'] = $this->lain_harga_sekunder->CurrentValue;
        $row['lain_harga_sekunder_order'] = $this->lain_harga_sekunder_order->CurrentValue;
        $row['lain_harga_label'] = $this->lain_harga_label->CurrentValue;
        $row['lain_harga_label_order'] = $this->lain_harga_label_order->CurrentValue;
        $row['lain_harga_total'] = $this->lain_harga_total->CurrentValue;
        $row['lain_harga_total_order'] = $this->lain_harga_total_order->CurrentValue;
        $row['isi_bahan_aktif'] = $this->isi_bahan_aktif->CurrentValue;
        $row['isi_bahan_lain'] = $this->isi_bahan_lain->CurrentValue;
        $row['isi_parfum'] = $this->isi_parfum->CurrentValue;
        $row['isi_estetika'] = $this->isi_estetika->CurrentValue;
        $row['kemasan_wadah'] = $this->kemasan_wadah->CurrentValue;
        $row['kemasan_tutup'] = $this->kemasan_tutup->CurrentValue;
        $row['kemasan_sekunder'] = $this->kemasan_sekunder->CurrentValue;
        $row['label_desain'] = $this->label_desain->CurrentValue;
        $row['label_cetak'] = $this->label_cetak->CurrentValue;
        $row['label_lainlain'] = $this->label_lainlain->CurrentValue;
        $row['delivery_pickup'] = $this->delivery_pickup->CurrentValue;
        $row['delivery_singlepoint'] = $this->delivery_singlepoint->CurrentValue;
        $row['delivery_multipoint'] = $this->delivery_multipoint->CurrentValue;
        $row['delivery_jumlahpoint'] = $this->delivery_jumlahpoint->CurrentValue;
        $row['delivery_termslain'] = $this->delivery_termslain->CurrentValue;
        $row['catatan_khusus'] = $this->catatan_khusus->CurrentValue;
        $row['dibuatdi'] = $this->dibuatdi->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
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
        $this->CopyUrl = $this->getCopyUrl();
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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->CurrentValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
                $this->idnpd->OldValue = $this->idnpd->CurrentValue;
                $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
                $this->idnpd->ViewCustomAttributes = "";
            } else {
                $this->idnpd->EditValue = HtmlEncode($this->idnpd->CurrentValue);
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // tglsubmit
            $this->tglsubmit->EditAttrs["class"] = "form-control";
            $this->tglsubmit->EditCustomAttributes = "";
            $this->tglsubmit->EditValue = HtmlEncode(FormatDateTime($this->tglsubmit->CurrentValue, 8));
            $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

            // sifat_order
            $this->sifat_order->EditCustomAttributes = "";
            $this->sifat_order->EditValue = $this->sifat_order->options(false);
            $this->sifat_order->PlaceHolder = RemoveHtml($this->sifat_order->caption());

            // ukuran_utama
            $this->ukuran_utama->EditAttrs["class"] = "form-control";
            $this->ukuran_utama->EditCustomAttributes = "";
            if (!$this->ukuran_utama->Raw) {
                $this->ukuran_utama->CurrentValue = HtmlDecode($this->ukuran_utama->CurrentValue);
            }
            $this->ukuran_utama->EditValue = HtmlEncode($this->ukuran_utama->CurrentValue);
            $this->ukuran_utama->PlaceHolder = RemoveHtml($this->ukuran_utama->caption());

            // utama_harga_isi
            $this->utama_harga_isi->EditAttrs["class"] = "form-control";
            $this->utama_harga_isi->EditCustomAttributes = "";
            $this->utama_harga_isi->EditValue = HtmlEncode($this->utama_harga_isi->CurrentValue);
            $this->utama_harga_isi->PlaceHolder = RemoveHtml($this->utama_harga_isi->caption());

            // utama_harga_isi_order
            $this->utama_harga_isi_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_isi_order->EditCustomAttributes = "";
            $this->utama_harga_isi_order->EditValue = HtmlEncode($this->utama_harga_isi_order->CurrentValue);
            $this->utama_harga_isi_order->PlaceHolder = RemoveHtml($this->utama_harga_isi_order->caption());

            // utama_harga_primer
            $this->utama_harga_primer->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer->EditCustomAttributes = "";
            $this->utama_harga_primer->EditValue = HtmlEncode($this->utama_harga_primer->CurrentValue);
            $this->utama_harga_primer->PlaceHolder = RemoveHtml($this->utama_harga_primer->caption());

            // utama_harga_primer_order
            $this->utama_harga_primer_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer_order->EditCustomAttributes = "";
            $this->utama_harga_primer_order->EditValue = HtmlEncode($this->utama_harga_primer_order->CurrentValue);
            $this->utama_harga_primer_order->PlaceHolder = RemoveHtml($this->utama_harga_primer_order->caption());

            // utama_harga_sekunder
            $this->utama_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder->EditCustomAttributes = "";
            $this->utama_harga_sekunder->EditValue = HtmlEncode($this->utama_harga_sekunder->CurrentValue);
            $this->utama_harga_sekunder->PlaceHolder = RemoveHtml($this->utama_harga_sekunder->caption());

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder_order->EditCustomAttributes = "";
            $this->utama_harga_sekunder_order->EditValue = HtmlEncode($this->utama_harga_sekunder_order->CurrentValue);
            $this->utama_harga_sekunder_order->PlaceHolder = RemoveHtml($this->utama_harga_sekunder_order->caption());

            // utama_harga_label
            $this->utama_harga_label->EditAttrs["class"] = "form-control";
            $this->utama_harga_label->EditCustomAttributes = "";
            $this->utama_harga_label->EditValue = HtmlEncode($this->utama_harga_label->CurrentValue);
            $this->utama_harga_label->PlaceHolder = RemoveHtml($this->utama_harga_label->caption());

            // utama_harga_label_order
            $this->utama_harga_label_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_label_order->EditCustomAttributes = "";
            $this->utama_harga_label_order->EditValue = HtmlEncode($this->utama_harga_label_order->CurrentValue);
            $this->utama_harga_label_order->PlaceHolder = RemoveHtml($this->utama_harga_label_order->caption());

            // utama_harga_total
            $this->utama_harga_total->EditAttrs["class"] = "form-control";
            $this->utama_harga_total->EditCustomAttributes = "";
            $this->utama_harga_total->EditValue = HtmlEncode($this->utama_harga_total->CurrentValue);
            $this->utama_harga_total->PlaceHolder = RemoveHtml($this->utama_harga_total->caption());

            // utama_harga_total_order
            $this->utama_harga_total_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_total_order->EditCustomAttributes = "";
            $this->utama_harga_total_order->EditValue = HtmlEncode($this->utama_harga_total_order->CurrentValue);
            $this->utama_harga_total_order->PlaceHolder = RemoveHtml($this->utama_harga_total_order->caption());

            // ukuran_lain
            $this->ukuran_lain->EditAttrs["class"] = "form-control";
            $this->ukuran_lain->EditCustomAttributes = "";
            if (!$this->ukuran_lain->Raw) {
                $this->ukuran_lain->CurrentValue = HtmlDecode($this->ukuran_lain->CurrentValue);
            }
            $this->ukuran_lain->EditValue = HtmlEncode($this->ukuran_lain->CurrentValue);
            $this->ukuran_lain->PlaceHolder = RemoveHtml($this->ukuran_lain->caption());

            // lain_harga_isi
            $this->lain_harga_isi->EditAttrs["class"] = "form-control";
            $this->lain_harga_isi->EditCustomAttributes = "";
            $this->lain_harga_isi->EditValue = HtmlEncode($this->lain_harga_isi->CurrentValue);
            $this->lain_harga_isi->PlaceHolder = RemoveHtml($this->lain_harga_isi->caption());

            // lain_harga_isi_order
            $this->lain_harga_isi_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_isi_order->EditCustomAttributes = "";
            $this->lain_harga_isi_order->EditValue = HtmlEncode($this->lain_harga_isi_order->CurrentValue);
            $this->lain_harga_isi_order->PlaceHolder = RemoveHtml($this->lain_harga_isi_order->caption());

            // lain_harga_primer
            $this->lain_harga_primer->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer->EditCustomAttributes = "";
            $this->lain_harga_primer->EditValue = HtmlEncode($this->lain_harga_primer->CurrentValue);
            $this->lain_harga_primer->PlaceHolder = RemoveHtml($this->lain_harga_primer->caption());

            // lain_harga_primer_order
            $this->lain_harga_primer_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer_order->EditCustomAttributes = "";
            $this->lain_harga_primer_order->EditValue = HtmlEncode($this->lain_harga_primer_order->CurrentValue);
            $this->lain_harga_primer_order->PlaceHolder = RemoveHtml($this->lain_harga_primer_order->caption());

            // lain_harga_sekunder
            $this->lain_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder->EditCustomAttributes = "";
            $this->lain_harga_sekunder->EditValue = HtmlEncode($this->lain_harga_sekunder->CurrentValue);
            $this->lain_harga_sekunder->PlaceHolder = RemoveHtml($this->lain_harga_sekunder->caption());

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder_order->EditCustomAttributes = "";
            $this->lain_harga_sekunder_order->EditValue = HtmlEncode($this->lain_harga_sekunder_order->CurrentValue);
            $this->lain_harga_sekunder_order->PlaceHolder = RemoveHtml($this->lain_harga_sekunder_order->caption());

            // lain_harga_label
            $this->lain_harga_label->EditAttrs["class"] = "form-control";
            $this->lain_harga_label->EditCustomAttributes = "";
            $this->lain_harga_label->EditValue = HtmlEncode($this->lain_harga_label->CurrentValue);
            $this->lain_harga_label->PlaceHolder = RemoveHtml($this->lain_harga_label->caption());

            // lain_harga_label_order
            $this->lain_harga_label_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_label_order->EditCustomAttributes = "";
            $this->lain_harga_label_order->EditValue = HtmlEncode($this->lain_harga_label_order->CurrentValue);
            $this->lain_harga_label_order->PlaceHolder = RemoveHtml($this->lain_harga_label_order->caption());

            // lain_harga_total
            $this->lain_harga_total->EditAttrs["class"] = "form-control";
            $this->lain_harga_total->EditCustomAttributes = "";
            $this->lain_harga_total->EditValue = HtmlEncode($this->lain_harga_total->CurrentValue);
            $this->lain_harga_total->PlaceHolder = RemoveHtml($this->lain_harga_total->caption());

            // lain_harga_total_order
            $this->lain_harga_total_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_total_order->EditCustomAttributes = "";
            $this->lain_harga_total_order->EditValue = HtmlEncode($this->lain_harga_total_order->CurrentValue);
            $this->lain_harga_total_order->PlaceHolder = RemoveHtml($this->lain_harga_total_order->caption());

            // isi_bahan_aktif
            $this->isi_bahan_aktif->EditAttrs["class"] = "form-control";
            $this->isi_bahan_aktif->EditCustomAttributes = "";
            if (!$this->isi_bahan_aktif->Raw) {
                $this->isi_bahan_aktif->CurrentValue = HtmlDecode($this->isi_bahan_aktif->CurrentValue);
            }
            $this->isi_bahan_aktif->EditValue = HtmlEncode($this->isi_bahan_aktif->CurrentValue);
            $this->isi_bahan_aktif->PlaceHolder = RemoveHtml($this->isi_bahan_aktif->caption());

            // isi_bahan_lain
            $this->isi_bahan_lain->EditAttrs["class"] = "form-control";
            $this->isi_bahan_lain->EditCustomAttributes = "";
            if (!$this->isi_bahan_lain->Raw) {
                $this->isi_bahan_lain->CurrentValue = HtmlDecode($this->isi_bahan_lain->CurrentValue);
            }
            $this->isi_bahan_lain->EditValue = HtmlEncode($this->isi_bahan_lain->CurrentValue);
            $this->isi_bahan_lain->PlaceHolder = RemoveHtml($this->isi_bahan_lain->caption());

            // isi_parfum
            $this->isi_parfum->EditAttrs["class"] = "form-control";
            $this->isi_parfum->EditCustomAttributes = "";
            if (!$this->isi_parfum->Raw) {
                $this->isi_parfum->CurrentValue = HtmlDecode($this->isi_parfum->CurrentValue);
            }
            $this->isi_parfum->EditValue = HtmlEncode($this->isi_parfum->CurrentValue);
            $this->isi_parfum->PlaceHolder = RemoveHtml($this->isi_parfum->caption());

            // isi_estetika
            $this->isi_estetika->EditAttrs["class"] = "form-control";
            $this->isi_estetika->EditCustomAttributes = "";
            if (!$this->isi_estetika->Raw) {
                $this->isi_estetika->CurrentValue = HtmlDecode($this->isi_estetika->CurrentValue);
            }
            $this->isi_estetika->EditValue = HtmlEncode($this->isi_estetika->CurrentValue);
            $this->isi_estetika->PlaceHolder = RemoveHtml($this->isi_estetika->caption());

            // kemasan_wadah
            $this->kemasan_wadah->EditAttrs["class"] = "form-control";
            $this->kemasan_wadah->EditCustomAttributes = "";
            $this->kemasan_wadah->EditValue = HtmlEncode($this->kemasan_wadah->CurrentValue);
            $this->kemasan_wadah->PlaceHolder = RemoveHtml($this->kemasan_wadah->caption());

            // kemasan_tutup
            $this->kemasan_tutup->EditAttrs["class"] = "form-control";
            $this->kemasan_tutup->EditCustomAttributes = "";
            $this->kemasan_tutup->EditValue = HtmlEncode($this->kemasan_tutup->CurrentValue);
            $this->kemasan_tutup->PlaceHolder = RemoveHtml($this->kemasan_tutup->caption());

            // kemasan_sekunder
            $this->kemasan_sekunder->EditAttrs["class"] = "form-control";
            $this->kemasan_sekunder->EditCustomAttributes = "";
            if (!$this->kemasan_sekunder->Raw) {
                $this->kemasan_sekunder->CurrentValue = HtmlDecode($this->kemasan_sekunder->CurrentValue);
            }
            $this->kemasan_sekunder->EditValue = HtmlEncode($this->kemasan_sekunder->CurrentValue);
            $this->kemasan_sekunder->PlaceHolder = RemoveHtml($this->kemasan_sekunder->caption());

            // label_desain
            $this->label_desain->EditAttrs["class"] = "form-control";
            $this->label_desain->EditCustomAttributes = "";
            if (!$this->label_desain->Raw) {
                $this->label_desain->CurrentValue = HtmlDecode($this->label_desain->CurrentValue);
            }
            $this->label_desain->EditValue = HtmlEncode($this->label_desain->CurrentValue);
            $this->label_desain->PlaceHolder = RemoveHtml($this->label_desain->caption());

            // label_cetak
            $this->label_cetak->EditAttrs["class"] = "form-control";
            $this->label_cetak->EditCustomAttributes = "";
            if (!$this->label_cetak->Raw) {
                $this->label_cetak->CurrentValue = HtmlDecode($this->label_cetak->CurrentValue);
            }
            $this->label_cetak->EditValue = HtmlEncode($this->label_cetak->CurrentValue);
            $this->label_cetak->PlaceHolder = RemoveHtml($this->label_cetak->caption());

            // label_lainlain
            $this->label_lainlain->EditAttrs["class"] = "form-control";
            $this->label_lainlain->EditCustomAttributes = "";
            if (!$this->label_lainlain->Raw) {
                $this->label_lainlain->CurrentValue = HtmlDecode($this->label_lainlain->CurrentValue);
            }
            $this->label_lainlain->EditValue = HtmlEncode($this->label_lainlain->CurrentValue);
            $this->label_lainlain->PlaceHolder = RemoveHtml($this->label_lainlain->caption());

            // delivery_pickup
            $this->delivery_pickup->EditAttrs["class"] = "form-control";
            $this->delivery_pickup->EditCustomAttributes = "";
            if (!$this->delivery_pickup->Raw) {
                $this->delivery_pickup->CurrentValue = HtmlDecode($this->delivery_pickup->CurrentValue);
            }
            $this->delivery_pickup->EditValue = HtmlEncode($this->delivery_pickup->CurrentValue);
            $this->delivery_pickup->PlaceHolder = RemoveHtml($this->delivery_pickup->caption());

            // delivery_singlepoint
            $this->delivery_singlepoint->EditAttrs["class"] = "form-control";
            $this->delivery_singlepoint->EditCustomAttributes = "";
            if (!$this->delivery_singlepoint->Raw) {
                $this->delivery_singlepoint->CurrentValue = HtmlDecode($this->delivery_singlepoint->CurrentValue);
            }
            $this->delivery_singlepoint->EditValue = HtmlEncode($this->delivery_singlepoint->CurrentValue);
            $this->delivery_singlepoint->PlaceHolder = RemoveHtml($this->delivery_singlepoint->caption());

            // delivery_multipoint
            $this->delivery_multipoint->EditAttrs["class"] = "form-control";
            $this->delivery_multipoint->EditCustomAttributes = "";
            if (!$this->delivery_multipoint->Raw) {
                $this->delivery_multipoint->CurrentValue = HtmlDecode($this->delivery_multipoint->CurrentValue);
            }
            $this->delivery_multipoint->EditValue = HtmlEncode($this->delivery_multipoint->CurrentValue);
            $this->delivery_multipoint->PlaceHolder = RemoveHtml($this->delivery_multipoint->caption());

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->EditAttrs["class"] = "form-control";
            $this->delivery_jumlahpoint->EditCustomAttributes = "";
            if (!$this->delivery_jumlahpoint->Raw) {
                $this->delivery_jumlahpoint->CurrentValue = HtmlDecode($this->delivery_jumlahpoint->CurrentValue);
            }
            $this->delivery_jumlahpoint->EditValue = HtmlEncode($this->delivery_jumlahpoint->CurrentValue);
            $this->delivery_jumlahpoint->PlaceHolder = RemoveHtml($this->delivery_jumlahpoint->caption());

            // delivery_termslain
            $this->delivery_termslain->EditAttrs["class"] = "form-control";
            $this->delivery_termslain->EditCustomAttributes = "";
            if (!$this->delivery_termslain->Raw) {
                $this->delivery_termslain->CurrentValue = HtmlDecode($this->delivery_termslain->CurrentValue);
            }
            $this->delivery_termslain->EditValue = HtmlEncode($this->delivery_termslain->CurrentValue);
            $this->delivery_termslain->PlaceHolder = RemoveHtml($this->delivery_termslain->caption());

            // dibuatdi
            $this->dibuatdi->EditAttrs["class"] = "form-control";
            $this->dibuatdi->EditCustomAttributes = "";
            if (!$this->dibuatdi->Raw) {
                $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
            }
            $this->dibuatdi->EditValue = HtmlEncode($this->dibuatdi->CurrentValue);
            $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // sifat_order
            $this->sifat_order->LinkCustomAttributes = "";
            $this->sifat_order->HrefValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->LinkCustomAttributes = "";
            $this->utama_harga_isi_order->HrefValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->LinkCustomAttributes = "";
            $this->utama_harga_primer_order->HrefValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_order->HrefValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->LinkCustomAttributes = "";
            $this->utama_harga_label_order->HrefValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->LinkCustomAttributes = "";
            $this->utama_harga_total_order->HrefValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->LinkCustomAttributes = "";
            $this->lain_harga_isi_order->HrefValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->LinkCustomAttributes = "";
            $this->lain_harga_primer_order->HrefValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_order->HrefValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->LinkCustomAttributes = "";
            $this->lain_harga_label_order->HrefValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->LinkCustomAttributes = "";
            $this->lain_harga_total_order->HrefValue = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->LinkCustomAttributes = "";
            $this->isi_bahan_aktif->HrefValue = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->LinkCustomAttributes = "";
            $this->isi_bahan_lain->HrefValue = "";

            // isi_parfum
            $this->isi_parfum->LinkCustomAttributes = "";
            $this->isi_parfum->HrefValue = "";

            // isi_estetika
            $this->isi_estetika->LinkCustomAttributes = "";
            $this->isi_estetika->HrefValue = "";

            // kemasan_wadah
            $this->kemasan_wadah->LinkCustomAttributes = "";
            $this->kemasan_wadah->HrefValue = "";

            // kemasan_tutup
            $this->kemasan_tutup->LinkCustomAttributes = "";
            $this->kemasan_tutup->HrefValue = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->LinkCustomAttributes = "";
            $this->kemasan_sekunder->HrefValue = "";

            // label_desain
            $this->label_desain->LinkCustomAttributes = "";
            $this->label_desain->HrefValue = "";

            // label_cetak
            $this->label_cetak->LinkCustomAttributes = "";
            $this->label_cetak->HrefValue = "";

            // label_lainlain
            $this->label_lainlain->LinkCustomAttributes = "";
            $this->label_lainlain->HrefValue = "";

            // delivery_pickup
            $this->delivery_pickup->LinkCustomAttributes = "";
            $this->delivery_pickup->HrefValue = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->LinkCustomAttributes = "";
            $this->delivery_singlepoint->HrefValue = "";

            // delivery_multipoint
            $this->delivery_multipoint->LinkCustomAttributes = "";
            $this->delivery_multipoint->HrefValue = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->LinkCustomAttributes = "";
            $this->delivery_jumlahpoint->HrefValue = "";

            // delivery_termslain
            $this->delivery_termslain->LinkCustomAttributes = "";
            $this->delivery_termslain->HrefValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->CurrentValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
                $this->idnpd->OldValue = $this->idnpd->CurrentValue;
                $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
                $this->idnpd->ViewCustomAttributes = "";
            } else {
                $this->idnpd->EditValue = HtmlEncode($this->idnpd->CurrentValue);
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // tglsubmit
            $this->tglsubmit->EditAttrs["class"] = "form-control";
            $this->tglsubmit->EditCustomAttributes = "";
            $this->tglsubmit->EditValue = HtmlEncode(FormatDateTime($this->tglsubmit->CurrentValue, 8));
            $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

            // sifat_order
            $this->sifat_order->EditCustomAttributes = "";
            $this->sifat_order->EditValue = $this->sifat_order->options(false);
            $this->sifat_order->PlaceHolder = RemoveHtml($this->sifat_order->caption());

            // ukuran_utama
            $this->ukuran_utama->EditAttrs["class"] = "form-control";
            $this->ukuran_utama->EditCustomAttributes = "";
            if (!$this->ukuran_utama->Raw) {
                $this->ukuran_utama->CurrentValue = HtmlDecode($this->ukuran_utama->CurrentValue);
            }
            $this->ukuran_utama->EditValue = HtmlEncode($this->ukuran_utama->CurrentValue);
            $this->ukuran_utama->PlaceHolder = RemoveHtml($this->ukuran_utama->caption());

            // utama_harga_isi
            $this->utama_harga_isi->EditAttrs["class"] = "form-control";
            $this->utama_harga_isi->EditCustomAttributes = "";
            $this->utama_harga_isi->EditValue = HtmlEncode($this->utama_harga_isi->CurrentValue);
            $this->utama_harga_isi->PlaceHolder = RemoveHtml($this->utama_harga_isi->caption());

            // utama_harga_isi_order
            $this->utama_harga_isi_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_isi_order->EditCustomAttributes = "";
            $this->utama_harga_isi_order->EditValue = HtmlEncode($this->utama_harga_isi_order->CurrentValue);
            $this->utama_harga_isi_order->PlaceHolder = RemoveHtml($this->utama_harga_isi_order->caption());

            // utama_harga_primer
            $this->utama_harga_primer->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer->EditCustomAttributes = "";
            $this->utama_harga_primer->EditValue = HtmlEncode($this->utama_harga_primer->CurrentValue);
            $this->utama_harga_primer->PlaceHolder = RemoveHtml($this->utama_harga_primer->caption());

            // utama_harga_primer_order
            $this->utama_harga_primer_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer_order->EditCustomAttributes = "";
            $this->utama_harga_primer_order->EditValue = HtmlEncode($this->utama_harga_primer_order->CurrentValue);
            $this->utama_harga_primer_order->PlaceHolder = RemoveHtml($this->utama_harga_primer_order->caption());

            // utama_harga_sekunder
            $this->utama_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder->EditCustomAttributes = "";
            $this->utama_harga_sekunder->EditValue = HtmlEncode($this->utama_harga_sekunder->CurrentValue);
            $this->utama_harga_sekunder->PlaceHolder = RemoveHtml($this->utama_harga_sekunder->caption());

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder_order->EditCustomAttributes = "";
            $this->utama_harga_sekunder_order->EditValue = HtmlEncode($this->utama_harga_sekunder_order->CurrentValue);
            $this->utama_harga_sekunder_order->PlaceHolder = RemoveHtml($this->utama_harga_sekunder_order->caption());

            // utama_harga_label
            $this->utama_harga_label->EditAttrs["class"] = "form-control";
            $this->utama_harga_label->EditCustomAttributes = "";
            $this->utama_harga_label->EditValue = HtmlEncode($this->utama_harga_label->CurrentValue);
            $this->utama_harga_label->PlaceHolder = RemoveHtml($this->utama_harga_label->caption());

            // utama_harga_label_order
            $this->utama_harga_label_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_label_order->EditCustomAttributes = "";
            $this->utama_harga_label_order->EditValue = HtmlEncode($this->utama_harga_label_order->CurrentValue);
            $this->utama_harga_label_order->PlaceHolder = RemoveHtml($this->utama_harga_label_order->caption());

            // utama_harga_total
            $this->utama_harga_total->EditAttrs["class"] = "form-control";
            $this->utama_harga_total->EditCustomAttributes = "";
            $this->utama_harga_total->EditValue = HtmlEncode($this->utama_harga_total->CurrentValue);
            $this->utama_harga_total->PlaceHolder = RemoveHtml($this->utama_harga_total->caption());

            // utama_harga_total_order
            $this->utama_harga_total_order->EditAttrs["class"] = "form-control";
            $this->utama_harga_total_order->EditCustomAttributes = "";
            $this->utama_harga_total_order->EditValue = HtmlEncode($this->utama_harga_total_order->CurrentValue);
            $this->utama_harga_total_order->PlaceHolder = RemoveHtml($this->utama_harga_total_order->caption());

            // ukuran_lain
            $this->ukuran_lain->EditAttrs["class"] = "form-control";
            $this->ukuran_lain->EditCustomAttributes = "";
            if (!$this->ukuran_lain->Raw) {
                $this->ukuran_lain->CurrentValue = HtmlDecode($this->ukuran_lain->CurrentValue);
            }
            $this->ukuran_lain->EditValue = HtmlEncode($this->ukuran_lain->CurrentValue);
            $this->ukuran_lain->PlaceHolder = RemoveHtml($this->ukuran_lain->caption());

            // lain_harga_isi
            $this->lain_harga_isi->EditAttrs["class"] = "form-control";
            $this->lain_harga_isi->EditCustomAttributes = "";
            $this->lain_harga_isi->EditValue = HtmlEncode($this->lain_harga_isi->CurrentValue);
            $this->lain_harga_isi->PlaceHolder = RemoveHtml($this->lain_harga_isi->caption());

            // lain_harga_isi_order
            $this->lain_harga_isi_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_isi_order->EditCustomAttributes = "";
            $this->lain_harga_isi_order->EditValue = HtmlEncode($this->lain_harga_isi_order->CurrentValue);
            $this->lain_harga_isi_order->PlaceHolder = RemoveHtml($this->lain_harga_isi_order->caption());

            // lain_harga_primer
            $this->lain_harga_primer->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer->EditCustomAttributes = "";
            $this->lain_harga_primer->EditValue = HtmlEncode($this->lain_harga_primer->CurrentValue);
            $this->lain_harga_primer->PlaceHolder = RemoveHtml($this->lain_harga_primer->caption());

            // lain_harga_primer_order
            $this->lain_harga_primer_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer_order->EditCustomAttributes = "";
            $this->lain_harga_primer_order->EditValue = HtmlEncode($this->lain_harga_primer_order->CurrentValue);
            $this->lain_harga_primer_order->PlaceHolder = RemoveHtml($this->lain_harga_primer_order->caption());

            // lain_harga_sekunder
            $this->lain_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder->EditCustomAttributes = "";
            $this->lain_harga_sekunder->EditValue = HtmlEncode($this->lain_harga_sekunder->CurrentValue);
            $this->lain_harga_sekunder->PlaceHolder = RemoveHtml($this->lain_harga_sekunder->caption());

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder_order->EditCustomAttributes = "";
            $this->lain_harga_sekunder_order->EditValue = HtmlEncode($this->lain_harga_sekunder_order->CurrentValue);
            $this->lain_harga_sekunder_order->PlaceHolder = RemoveHtml($this->lain_harga_sekunder_order->caption());

            // lain_harga_label
            $this->lain_harga_label->EditAttrs["class"] = "form-control";
            $this->lain_harga_label->EditCustomAttributes = "";
            $this->lain_harga_label->EditValue = HtmlEncode($this->lain_harga_label->CurrentValue);
            $this->lain_harga_label->PlaceHolder = RemoveHtml($this->lain_harga_label->caption());

            // lain_harga_label_order
            $this->lain_harga_label_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_label_order->EditCustomAttributes = "";
            $this->lain_harga_label_order->EditValue = HtmlEncode($this->lain_harga_label_order->CurrentValue);
            $this->lain_harga_label_order->PlaceHolder = RemoveHtml($this->lain_harga_label_order->caption());

            // lain_harga_total
            $this->lain_harga_total->EditAttrs["class"] = "form-control";
            $this->lain_harga_total->EditCustomAttributes = "";
            $this->lain_harga_total->EditValue = HtmlEncode($this->lain_harga_total->CurrentValue);
            $this->lain_harga_total->PlaceHolder = RemoveHtml($this->lain_harga_total->caption());

            // lain_harga_total_order
            $this->lain_harga_total_order->EditAttrs["class"] = "form-control";
            $this->lain_harga_total_order->EditCustomAttributes = "";
            $this->lain_harga_total_order->EditValue = HtmlEncode($this->lain_harga_total_order->CurrentValue);
            $this->lain_harga_total_order->PlaceHolder = RemoveHtml($this->lain_harga_total_order->caption());

            // isi_bahan_aktif
            $this->isi_bahan_aktif->EditAttrs["class"] = "form-control";
            $this->isi_bahan_aktif->EditCustomAttributes = "";
            if (!$this->isi_bahan_aktif->Raw) {
                $this->isi_bahan_aktif->CurrentValue = HtmlDecode($this->isi_bahan_aktif->CurrentValue);
            }
            $this->isi_bahan_aktif->EditValue = HtmlEncode($this->isi_bahan_aktif->CurrentValue);
            $this->isi_bahan_aktif->PlaceHolder = RemoveHtml($this->isi_bahan_aktif->caption());

            // isi_bahan_lain
            $this->isi_bahan_lain->EditAttrs["class"] = "form-control";
            $this->isi_bahan_lain->EditCustomAttributes = "";
            if (!$this->isi_bahan_lain->Raw) {
                $this->isi_bahan_lain->CurrentValue = HtmlDecode($this->isi_bahan_lain->CurrentValue);
            }
            $this->isi_bahan_lain->EditValue = HtmlEncode($this->isi_bahan_lain->CurrentValue);
            $this->isi_bahan_lain->PlaceHolder = RemoveHtml($this->isi_bahan_lain->caption());

            // isi_parfum
            $this->isi_parfum->EditAttrs["class"] = "form-control";
            $this->isi_parfum->EditCustomAttributes = "";
            if (!$this->isi_parfum->Raw) {
                $this->isi_parfum->CurrentValue = HtmlDecode($this->isi_parfum->CurrentValue);
            }
            $this->isi_parfum->EditValue = HtmlEncode($this->isi_parfum->CurrentValue);
            $this->isi_parfum->PlaceHolder = RemoveHtml($this->isi_parfum->caption());

            // isi_estetika
            $this->isi_estetika->EditAttrs["class"] = "form-control";
            $this->isi_estetika->EditCustomAttributes = "";
            if (!$this->isi_estetika->Raw) {
                $this->isi_estetika->CurrentValue = HtmlDecode($this->isi_estetika->CurrentValue);
            }
            $this->isi_estetika->EditValue = HtmlEncode($this->isi_estetika->CurrentValue);
            $this->isi_estetika->PlaceHolder = RemoveHtml($this->isi_estetika->caption());

            // kemasan_wadah
            $this->kemasan_wadah->EditAttrs["class"] = "form-control";
            $this->kemasan_wadah->EditCustomAttributes = "";
            $this->kemasan_wadah->EditValue = HtmlEncode($this->kemasan_wadah->CurrentValue);
            $this->kemasan_wadah->PlaceHolder = RemoveHtml($this->kemasan_wadah->caption());

            // kemasan_tutup
            $this->kemasan_tutup->EditAttrs["class"] = "form-control";
            $this->kemasan_tutup->EditCustomAttributes = "";
            $this->kemasan_tutup->EditValue = HtmlEncode($this->kemasan_tutup->CurrentValue);
            $this->kemasan_tutup->PlaceHolder = RemoveHtml($this->kemasan_tutup->caption());

            // kemasan_sekunder
            $this->kemasan_sekunder->EditAttrs["class"] = "form-control";
            $this->kemasan_sekunder->EditCustomAttributes = "";
            if (!$this->kemasan_sekunder->Raw) {
                $this->kemasan_sekunder->CurrentValue = HtmlDecode($this->kemasan_sekunder->CurrentValue);
            }
            $this->kemasan_sekunder->EditValue = HtmlEncode($this->kemasan_sekunder->CurrentValue);
            $this->kemasan_sekunder->PlaceHolder = RemoveHtml($this->kemasan_sekunder->caption());

            // label_desain
            $this->label_desain->EditAttrs["class"] = "form-control";
            $this->label_desain->EditCustomAttributes = "";
            if (!$this->label_desain->Raw) {
                $this->label_desain->CurrentValue = HtmlDecode($this->label_desain->CurrentValue);
            }
            $this->label_desain->EditValue = HtmlEncode($this->label_desain->CurrentValue);
            $this->label_desain->PlaceHolder = RemoveHtml($this->label_desain->caption());

            // label_cetak
            $this->label_cetak->EditAttrs["class"] = "form-control";
            $this->label_cetak->EditCustomAttributes = "";
            if (!$this->label_cetak->Raw) {
                $this->label_cetak->CurrentValue = HtmlDecode($this->label_cetak->CurrentValue);
            }
            $this->label_cetak->EditValue = HtmlEncode($this->label_cetak->CurrentValue);
            $this->label_cetak->PlaceHolder = RemoveHtml($this->label_cetak->caption());

            // label_lainlain
            $this->label_lainlain->EditAttrs["class"] = "form-control";
            $this->label_lainlain->EditCustomAttributes = "";
            if (!$this->label_lainlain->Raw) {
                $this->label_lainlain->CurrentValue = HtmlDecode($this->label_lainlain->CurrentValue);
            }
            $this->label_lainlain->EditValue = HtmlEncode($this->label_lainlain->CurrentValue);
            $this->label_lainlain->PlaceHolder = RemoveHtml($this->label_lainlain->caption());

            // delivery_pickup
            $this->delivery_pickup->EditAttrs["class"] = "form-control";
            $this->delivery_pickup->EditCustomAttributes = "";
            if (!$this->delivery_pickup->Raw) {
                $this->delivery_pickup->CurrentValue = HtmlDecode($this->delivery_pickup->CurrentValue);
            }
            $this->delivery_pickup->EditValue = HtmlEncode($this->delivery_pickup->CurrentValue);
            $this->delivery_pickup->PlaceHolder = RemoveHtml($this->delivery_pickup->caption());

            // delivery_singlepoint
            $this->delivery_singlepoint->EditAttrs["class"] = "form-control";
            $this->delivery_singlepoint->EditCustomAttributes = "";
            if (!$this->delivery_singlepoint->Raw) {
                $this->delivery_singlepoint->CurrentValue = HtmlDecode($this->delivery_singlepoint->CurrentValue);
            }
            $this->delivery_singlepoint->EditValue = HtmlEncode($this->delivery_singlepoint->CurrentValue);
            $this->delivery_singlepoint->PlaceHolder = RemoveHtml($this->delivery_singlepoint->caption());

            // delivery_multipoint
            $this->delivery_multipoint->EditAttrs["class"] = "form-control";
            $this->delivery_multipoint->EditCustomAttributes = "";
            if (!$this->delivery_multipoint->Raw) {
                $this->delivery_multipoint->CurrentValue = HtmlDecode($this->delivery_multipoint->CurrentValue);
            }
            $this->delivery_multipoint->EditValue = HtmlEncode($this->delivery_multipoint->CurrentValue);
            $this->delivery_multipoint->PlaceHolder = RemoveHtml($this->delivery_multipoint->caption());

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->EditAttrs["class"] = "form-control";
            $this->delivery_jumlahpoint->EditCustomAttributes = "";
            if (!$this->delivery_jumlahpoint->Raw) {
                $this->delivery_jumlahpoint->CurrentValue = HtmlDecode($this->delivery_jumlahpoint->CurrentValue);
            }
            $this->delivery_jumlahpoint->EditValue = HtmlEncode($this->delivery_jumlahpoint->CurrentValue);
            $this->delivery_jumlahpoint->PlaceHolder = RemoveHtml($this->delivery_jumlahpoint->caption());

            // delivery_termslain
            $this->delivery_termslain->EditAttrs["class"] = "form-control";
            $this->delivery_termslain->EditCustomAttributes = "";
            if (!$this->delivery_termslain->Raw) {
                $this->delivery_termslain->CurrentValue = HtmlDecode($this->delivery_termslain->CurrentValue);
            }
            $this->delivery_termslain->EditValue = HtmlEncode($this->delivery_termslain->CurrentValue);
            $this->delivery_termslain->PlaceHolder = RemoveHtml($this->delivery_termslain->caption());

            // dibuatdi
            $this->dibuatdi->EditAttrs["class"] = "form-control";
            $this->dibuatdi->EditCustomAttributes = "";
            if (!$this->dibuatdi->Raw) {
                $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
            }
            $this->dibuatdi->EditValue = HtmlEncode($this->dibuatdi->CurrentValue);
            $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // sifat_order
            $this->sifat_order->LinkCustomAttributes = "";
            $this->sifat_order->HrefValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->LinkCustomAttributes = "";
            $this->utama_harga_isi_order->HrefValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->LinkCustomAttributes = "";
            $this->utama_harga_primer_order->HrefValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_order->HrefValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->LinkCustomAttributes = "";
            $this->utama_harga_label_order->HrefValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->LinkCustomAttributes = "";
            $this->utama_harga_total_order->HrefValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->LinkCustomAttributes = "";
            $this->lain_harga_isi_order->HrefValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->LinkCustomAttributes = "";
            $this->lain_harga_primer_order->HrefValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_order->HrefValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->LinkCustomAttributes = "";
            $this->lain_harga_label_order->HrefValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->LinkCustomAttributes = "";
            $this->lain_harga_total_order->HrefValue = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->LinkCustomAttributes = "";
            $this->isi_bahan_aktif->HrefValue = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->LinkCustomAttributes = "";
            $this->isi_bahan_lain->HrefValue = "";

            // isi_parfum
            $this->isi_parfum->LinkCustomAttributes = "";
            $this->isi_parfum->HrefValue = "";

            // isi_estetika
            $this->isi_estetika->LinkCustomAttributes = "";
            $this->isi_estetika->HrefValue = "";

            // kemasan_wadah
            $this->kemasan_wadah->LinkCustomAttributes = "";
            $this->kemasan_wadah->HrefValue = "";

            // kemasan_tutup
            $this->kemasan_tutup->LinkCustomAttributes = "";
            $this->kemasan_tutup->HrefValue = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->LinkCustomAttributes = "";
            $this->kemasan_sekunder->HrefValue = "";

            // label_desain
            $this->label_desain->LinkCustomAttributes = "";
            $this->label_desain->HrefValue = "";

            // label_cetak
            $this->label_cetak->LinkCustomAttributes = "";
            $this->label_cetak->HrefValue = "";

            // label_lainlain
            $this->label_lainlain->LinkCustomAttributes = "";
            $this->label_lainlain->HrefValue = "";

            // delivery_pickup
            $this->delivery_pickup->LinkCustomAttributes = "";
            $this->delivery_pickup->HrefValue = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->LinkCustomAttributes = "";
            $this->delivery_singlepoint->HrefValue = "";

            // delivery_multipoint
            $this->delivery_multipoint->LinkCustomAttributes = "";
            $this->delivery_multipoint->HrefValue = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->LinkCustomAttributes = "";
            $this->delivery_jumlahpoint->HrefValue = "";

            // delivery_termslain
            $this->delivery_termslain->LinkCustomAttributes = "";
            $this->delivery_termslain->HrefValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id->FormValue)) {
            $this->id->addErrorMessage($this->id->getErrorMessage(false));
        }
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idnpd->FormValue)) {
            $this->idnpd->addErrorMessage($this->idnpd->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->tglsubmit->Required) {
            if (!$this->tglsubmit->IsDetailKey && EmptyValue($this->tglsubmit->FormValue)) {
                $this->tglsubmit->addErrorMessage(str_replace("%s", $this->tglsubmit->caption(), $this->tglsubmit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglsubmit->FormValue)) {
            $this->tglsubmit->addErrorMessage($this->tglsubmit->getErrorMessage(false));
        }
        if ($this->sifat_order->Required) {
            if ($this->sifat_order->FormValue == "") {
                $this->sifat_order->addErrorMessage(str_replace("%s", $this->sifat_order->caption(), $this->sifat_order->RequiredErrorMessage));
            }
        }
        if ($this->ukuran_utama->Required) {
            if (!$this->ukuran_utama->IsDetailKey && EmptyValue($this->ukuran_utama->FormValue)) {
                $this->ukuran_utama->addErrorMessage(str_replace("%s", $this->ukuran_utama->caption(), $this->ukuran_utama->RequiredErrorMessage));
            }
        }
        if ($this->utama_harga_isi->Required) {
            if (!$this->utama_harga_isi->IsDetailKey && EmptyValue($this->utama_harga_isi->FormValue)) {
                $this->utama_harga_isi->addErrorMessage(str_replace("%s", $this->utama_harga_isi->caption(), $this->utama_harga_isi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_isi->FormValue)) {
            $this->utama_harga_isi->addErrorMessage($this->utama_harga_isi->getErrorMessage(false));
        }
        if ($this->utama_harga_isi_order->Required) {
            if (!$this->utama_harga_isi_order->IsDetailKey && EmptyValue($this->utama_harga_isi_order->FormValue)) {
                $this->utama_harga_isi_order->addErrorMessage(str_replace("%s", $this->utama_harga_isi_order->caption(), $this->utama_harga_isi_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_isi_order->FormValue)) {
            $this->utama_harga_isi_order->addErrorMessage($this->utama_harga_isi_order->getErrorMessage(false));
        }
        if ($this->utama_harga_primer->Required) {
            if (!$this->utama_harga_primer->IsDetailKey && EmptyValue($this->utama_harga_primer->FormValue)) {
                $this->utama_harga_primer->addErrorMessage(str_replace("%s", $this->utama_harga_primer->caption(), $this->utama_harga_primer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_primer->FormValue)) {
            $this->utama_harga_primer->addErrorMessage($this->utama_harga_primer->getErrorMessage(false));
        }
        if ($this->utama_harga_primer_order->Required) {
            if (!$this->utama_harga_primer_order->IsDetailKey && EmptyValue($this->utama_harga_primer_order->FormValue)) {
                $this->utama_harga_primer_order->addErrorMessage(str_replace("%s", $this->utama_harga_primer_order->caption(), $this->utama_harga_primer_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_primer_order->FormValue)) {
            $this->utama_harga_primer_order->addErrorMessage($this->utama_harga_primer_order->getErrorMessage(false));
        }
        if ($this->utama_harga_sekunder->Required) {
            if (!$this->utama_harga_sekunder->IsDetailKey && EmptyValue($this->utama_harga_sekunder->FormValue)) {
                $this->utama_harga_sekunder->addErrorMessage(str_replace("%s", $this->utama_harga_sekunder->caption(), $this->utama_harga_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_sekunder->FormValue)) {
            $this->utama_harga_sekunder->addErrorMessage($this->utama_harga_sekunder->getErrorMessage(false));
        }
        if ($this->utama_harga_sekunder_order->Required) {
            if (!$this->utama_harga_sekunder_order->IsDetailKey && EmptyValue($this->utama_harga_sekunder_order->FormValue)) {
                $this->utama_harga_sekunder_order->addErrorMessage(str_replace("%s", $this->utama_harga_sekunder_order->caption(), $this->utama_harga_sekunder_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_sekunder_order->FormValue)) {
            $this->utama_harga_sekunder_order->addErrorMessage($this->utama_harga_sekunder_order->getErrorMessage(false));
        }
        if ($this->utama_harga_label->Required) {
            if (!$this->utama_harga_label->IsDetailKey && EmptyValue($this->utama_harga_label->FormValue)) {
                $this->utama_harga_label->addErrorMessage(str_replace("%s", $this->utama_harga_label->caption(), $this->utama_harga_label->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_label->FormValue)) {
            $this->utama_harga_label->addErrorMessage($this->utama_harga_label->getErrorMessage(false));
        }
        if ($this->utama_harga_label_order->Required) {
            if (!$this->utama_harga_label_order->IsDetailKey && EmptyValue($this->utama_harga_label_order->FormValue)) {
                $this->utama_harga_label_order->addErrorMessage(str_replace("%s", $this->utama_harga_label_order->caption(), $this->utama_harga_label_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_label_order->FormValue)) {
            $this->utama_harga_label_order->addErrorMessage($this->utama_harga_label_order->getErrorMessage(false));
        }
        if ($this->utama_harga_total->Required) {
            if (!$this->utama_harga_total->IsDetailKey && EmptyValue($this->utama_harga_total->FormValue)) {
                $this->utama_harga_total->addErrorMessage(str_replace("%s", $this->utama_harga_total->caption(), $this->utama_harga_total->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_total->FormValue)) {
            $this->utama_harga_total->addErrorMessage($this->utama_harga_total->getErrorMessage(false));
        }
        if ($this->utama_harga_total_order->Required) {
            if (!$this->utama_harga_total_order->IsDetailKey && EmptyValue($this->utama_harga_total_order->FormValue)) {
                $this->utama_harga_total_order->addErrorMessage(str_replace("%s", $this->utama_harga_total_order->caption(), $this->utama_harga_total_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_total_order->FormValue)) {
            $this->utama_harga_total_order->addErrorMessage($this->utama_harga_total_order->getErrorMessage(false));
        }
        if ($this->ukuran_lain->Required) {
            if (!$this->ukuran_lain->IsDetailKey && EmptyValue($this->ukuran_lain->FormValue)) {
                $this->ukuran_lain->addErrorMessage(str_replace("%s", $this->ukuran_lain->caption(), $this->ukuran_lain->RequiredErrorMessage));
            }
        }
        if ($this->lain_harga_isi->Required) {
            if (!$this->lain_harga_isi->IsDetailKey && EmptyValue($this->lain_harga_isi->FormValue)) {
                $this->lain_harga_isi->addErrorMessage(str_replace("%s", $this->lain_harga_isi->caption(), $this->lain_harga_isi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_isi->FormValue)) {
            $this->lain_harga_isi->addErrorMessage($this->lain_harga_isi->getErrorMessage(false));
        }
        if ($this->lain_harga_isi_order->Required) {
            if (!$this->lain_harga_isi_order->IsDetailKey && EmptyValue($this->lain_harga_isi_order->FormValue)) {
                $this->lain_harga_isi_order->addErrorMessage(str_replace("%s", $this->lain_harga_isi_order->caption(), $this->lain_harga_isi_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_isi_order->FormValue)) {
            $this->lain_harga_isi_order->addErrorMessage($this->lain_harga_isi_order->getErrorMessage(false));
        }
        if ($this->lain_harga_primer->Required) {
            if (!$this->lain_harga_primer->IsDetailKey && EmptyValue($this->lain_harga_primer->FormValue)) {
                $this->lain_harga_primer->addErrorMessage(str_replace("%s", $this->lain_harga_primer->caption(), $this->lain_harga_primer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_primer->FormValue)) {
            $this->lain_harga_primer->addErrorMessage($this->lain_harga_primer->getErrorMessage(false));
        }
        if ($this->lain_harga_primer_order->Required) {
            if (!$this->lain_harga_primer_order->IsDetailKey && EmptyValue($this->lain_harga_primer_order->FormValue)) {
                $this->lain_harga_primer_order->addErrorMessage(str_replace("%s", $this->lain_harga_primer_order->caption(), $this->lain_harga_primer_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_primer_order->FormValue)) {
            $this->lain_harga_primer_order->addErrorMessage($this->lain_harga_primer_order->getErrorMessage(false));
        }
        if ($this->lain_harga_sekunder->Required) {
            if (!$this->lain_harga_sekunder->IsDetailKey && EmptyValue($this->lain_harga_sekunder->FormValue)) {
                $this->lain_harga_sekunder->addErrorMessage(str_replace("%s", $this->lain_harga_sekunder->caption(), $this->lain_harga_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_sekunder->FormValue)) {
            $this->lain_harga_sekunder->addErrorMessage($this->lain_harga_sekunder->getErrorMessage(false));
        }
        if ($this->lain_harga_sekunder_order->Required) {
            if (!$this->lain_harga_sekunder_order->IsDetailKey && EmptyValue($this->lain_harga_sekunder_order->FormValue)) {
                $this->lain_harga_sekunder_order->addErrorMessage(str_replace("%s", $this->lain_harga_sekunder_order->caption(), $this->lain_harga_sekunder_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_sekunder_order->FormValue)) {
            $this->lain_harga_sekunder_order->addErrorMessage($this->lain_harga_sekunder_order->getErrorMessage(false));
        }
        if ($this->lain_harga_label->Required) {
            if (!$this->lain_harga_label->IsDetailKey && EmptyValue($this->lain_harga_label->FormValue)) {
                $this->lain_harga_label->addErrorMessage(str_replace("%s", $this->lain_harga_label->caption(), $this->lain_harga_label->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_label->FormValue)) {
            $this->lain_harga_label->addErrorMessage($this->lain_harga_label->getErrorMessage(false));
        }
        if ($this->lain_harga_label_order->Required) {
            if (!$this->lain_harga_label_order->IsDetailKey && EmptyValue($this->lain_harga_label_order->FormValue)) {
                $this->lain_harga_label_order->addErrorMessage(str_replace("%s", $this->lain_harga_label_order->caption(), $this->lain_harga_label_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_label_order->FormValue)) {
            $this->lain_harga_label_order->addErrorMessage($this->lain_harga_label_order->getErrorMessage(false));
        }
        if ($this->lain_harga_total->Required) {
            if (!$this->lain_harga_total->IsDetailKey && EmptyValue($this->lain_harga_total->FormValue)) {
                $this->lain_harga_total->addErrorMessage(str_replace("%s", $this->lain_harga_total->caption(), $this->lain_harga_total->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_total->FormValue)) {
            $this->lain_harga_total->addErrorMessage($this->lain_harga_total->getErrorMessage(false));
        }
        if ($this->lain_harga_total_order->Required) {
            if (!$this->lain_harga_total_order->IsDetailKey && EmptyValue($this->lain_harga_total_order->FormValue)) {
                $this->lain_harga_total_order->addErrorMessage(str_replace("%s", $this->lain_harga_total_order->caption(), $this->lain_harga_total_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_total_order->FormValue)) {
            $this->lain_harga_total_order->addErrorMessage($this->lain_harga_total_order->getErrorMessage(false));
        }
        if ($this->isi_bahan_aktif->Required) {
            if (!$this->isi_bahan_aktif->IsDetailKey && EmptyValue($this->isi_bahan_aktif->FormValue)) {
                $this->isi_bahan_aktif->addErrorMessage(str_replace("%s", $this->isi_bahan_aktif->caption(), $this->isi_bahan_aktif->RequiredErrorMessage));
            }
        }
        if ($this->isi_bahan_lain->Required) {
            if (!$this->isi_bahan_lain->IsDetailKey && EmptyValue($this->isi_bahan_lain->FormValue)) {
                $this->isi_bahan_lain->addErrorMessage(str_replace("%s", $this->isi_bahan_lain->caption(), $this->isi_bahan_lain->RequiredErrorMessage));
            }
        }
        if ($this->isi_parfum->Required) {
            if (!$this->isi_parfum->IsDetailKey && EmptyValue($this->isi_parfum->FormValue)) {
                $this->isi_parfum->addErrorMessage(str_replace("%s", $this->isi_parfum->caption(), $this->isi_parfum->RequiredErrorMessage));
            }
        }
        if ($this->isi_estetika->Required) {
            if (!$this->isi_estetika->IsDetailKey && EmptyValue($this->isi_estetika->FormValue)) {
                $this->isi_estetika->addErrorMessage(str_replace("%s", $this->isi_estetika->caption(), $this->isi_estetika->RequiredErrorMessage));
            }
        }
        if ($this->kemasan_wadah->Required) {
            if (!$this->kemasan_wadah->IsDetailKey && EmptyValue($this->kemasan_wadah->FormValue)) {
                $this->kemasan_wadah->addErrorMessage(str_replace("%s", $this->kemasan_wadah->caption(), $this->kemasan_wadah->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->kemasan_wadah->FormValue)) {
            $this->kemasan_wadah->addErrorMessage($this->kemasan_wadah->getErrorMessage(false));
        }
        if ($this->kemasan_tutup->Required) {
            if (!$this->kemasan_tutup->IsDetailKey && EmptyValue($this->kemasan_tutup->FormValue)) {
                $this->kemasan_tutup->addErrorMessage(str_replace("%s", $this->kemasan_tutup->caption(), $this->kemasan_tutup->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->kemasan_tutup->FormValue)) {
            $this->kemasan_tutup->addErrorMessage($this->kemasan_tutup->getErrorMessage(false));
        }
        if ($this->kemasan_sekunder->Required) {
            if (!$this->kemasan_sekunder->IsDetailKey && EmptyValue($this->kemasan_sekunder->FormValue)) {
                $this->kemasan_sekunder->addErrorMessage(str_replace("%s", $this->kemasan_sekunder->caption(), $this->kemasan_sekunder->RequiredErrorMessage));
            }
        }
        if ($this->label_desain->Required) {
            if (!$this->label_desain->IsDetailKey && EmptyValue($this->label_desain->FormValue)) {
                $this->label_desain->addErrorMessage(str_replace("%s", $this->label_desain->caption(), $this->label_desain->RequiredErrorMessage));
            }
        }
        if ($this->label_cetak->Required) {
            if (!$this->label_cetak->IsDetailKey && EmptyValue($this->label_cetak->FormValue)) {
                $this->label_cetak->addErrorMessage(str_replace("%s", $this->label_cetak->caption(), $this->label_cetak->RequiredErrorMessage));
            }
        }
        if ($this->label_lainlain->Required) {
            if (!$this->label_lainlain->IsDetailKey && EmptyValue($this->label_lainlain->FormValue)) {
                $this->label_lainlain->addErrorMessage(str_replace("%s", $this->label_lainlain->caption(), $this->label_lainlain->RequiredErrorMessage));
            }
        }
        if ($this->delivery_pickup->Required) {
            if (!$this->delivery_pickup->IsDetailKey && EmptyValue($this->delivery_pickup->FormValue)) {
                $this->delivery_pickup->addErrorMessage(str_replace("%s", $this->delivery_pickup->caption(), $this->delivery_pickup->RequiredErrorMessage));
            }
        }
        if ($this->delivery_singlepoint->Required) {
            if (!$this->delivery_singlepoint->IsDetailKey && EmptyValue($this->delivery_singlepoint->FormValue)) {
                $this->delivery_singlepoint->addErrorMessage(str_replace("%s", $this->delivery_singlepoint->caption(), $this->delivery_singlepoint->RequiredErrorMessage));
            }
        }
        if ($this->delivery_multipoint->Required) {
            if (!$this->delivery_multipoint->IsDetailKey && EmptyValue($this->delivery_multipoint->FormValue)) {
                $this->delivery_multipoint->addErrorMessage(str_replace("%s", $this->delivery_multipoint->caption(), $this->delivery_multipoint->RequiredErrorMessage));
            }
        }
        if ($this->delivery_jumlahpoint->Required) {
            if (!$this->delivery_jumlahpoint->IsDetailKey && EmptyValue($this->delivery_jumlahpoint->FormValue)) {
                $this->delivery_jumlahpoint->addErrorMessage(str_replace("%s", $this->delivery_jumlahpoint->caption(), $this->delivery_jumlahpoint->RequiredErrorMessage));
            }
        }
        if ($this->delivery_termslain->Required) {
            if (!$this->delivery_termslain->IsDetailKey && EmptyValue($this->delivery_termslain->FormValue)) {
                $this->delivery_termslain->addErrorMessage(str_replace("%s", $this->delivery_termslain->caption(), $this->delivery_termslain->RequiredErrorMessage));
            }
        }
        if ($this->dibuatdi->Required) {
            if (!$this->dibuatdi->IsDetailKey && EmptyValue($this->dibuatdi->FormValue)) {
                $this->dibuatdi->addErrorMessage(str_replace("%s", $this->dibuatdi->caption(), $this->dibuatdi->RequiredErrorMessage));
            }
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->created_at->FormValue)) {
            $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // id
            $this->id->setDbValueDef($rsnew, $this->id->CurrentValue, 0, $this->id->ReadOnly);

            // idnpd
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->ReadOnly = true;
            }
            $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, $this->idnpd->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

            // tglsubmit
            $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), null, $this->tglsubmit->ReadOnly);

            // sifat_order
            $tmpBool = $this->sifat_order->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->sifat_order->setDbValueDef($rsnew, $tmpBool, 0, $this->sifat_order->ReadOnly);

            // ukuran_utama
            $this->ukuran_utama->setDbValueDef($rsnew, $this->ukuran_utama->CurrentValue, null, $this->ukuran_utama->ReadOnly);

            // utama_harga_isi
            $this->utama_harga_isi->setDbValueDef($rsnew, $this->utama_harga_isi->CurrentValue, null, $this->utama_harga_isi->ReadOnly);

            // utama_harga_isi_order
            $this->utama_harga_isi_order->setDbValueDef($rsnew, $this->utama_harga_isi_order->CurrentValue, null, $this->utama_harga_isi_order->ReadOnly);

            // utama_harga_primer
            $this->utama_harga_primer->setDbValueDef($rsnew, $this->utama_harga_primer->CurrentValue, null, $this->utama_harga_primer->ReadOnly);

            // utama_harga_primer_order
            $this->utama_harga_primer_order->setDbValueDef($rsnew, $this->utama_harga_primer_order->CurrentValue, null, $this->utama_harga_primer_order->ReadOnly);

            // utama_harga_sekunder
            $this->utama_harga_sekunder->setDbValueDef($rsnew, $this->utama_harga_sekunder->CurrentValue, null, $this->utama_harga_sekunder->ReadOnly);

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->setDbValueDef($rsnew, $this->utama_harga_sekunder_order->CurrentValue, null, $this->utama_harga_sekunder_order->ReadOnly);

            // utama_harga_label
            $this->utama_harga_label->setDbValueDef($rsnew, $this->utama_harga_label->CurrentValue, null, $this->utama_harga_label->ReadOnly);

            // utama_harga_label_order
            $this->utama_harga_label_order->setDbValueDef($rsnew, $this->utama_harga_label_order->CurrentValue, null, $this->utama_harga_label_order->ReadOnly);

            // utama_harga_total
            $this->utama_harga_total->setDbValueDef($rsnew, $this->utama_harga_total->CurrentValue, null, $this->utama_harga_total->ReadOnly);

            // utama_harga_total_order
            $this->utama_harga_total_order->setDbValueDef($rsnew, $this->utama_harga_total_order->CurrentValue, null, $this->utama_harga_total_order->ReadOnly);

            // ukuran_lain
            $this->ukuran_lain->setDbValueDef($rsnew, $this->ukuran_lain->CurrentValue, null, $this->ukuran_lain->ReadOnly);

            // lain_harga_isi
            $this->lain_harga_isi->setDbValueDef($rsnew, $this->lain_harga_isi->CurrentValue, null, $this->lain_harga_isi->ReadOnly);

            // lain_harga_isi_order
            $this->lain_harga_isi_order->setDbValueDef($rsnew, $this->lain_harga_isi_order->CurrentValue, null, $this->lain_harga_isi_order->ReadOnly);

            // lain_harga_primer
            $this->lain_harga_primer->setDbValueDef($rsnew, $this->lain_harga_primer->CurrentValue, null, $this->lain_harga_primer->ReadOnly);

            // lain_harga_primer_order
            $this->lain_harga_primer_order->setDbValueDef($rsnew, $this->lain_harga_primer_order->CurrentValue, null, $this->lain_harga_primer_order->ReadOnly);

            // lain_harga_sekunder
            $this->lain_harga_sekunder->setDbValueDef($rsnew, $this->lain_harga_sekunder->CurrentValue, null, $this->lain_harga_sekunder->ReadOnly);

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->setDbValueDef($rsnew, $this->lain_harga_sekunder_order->CurrentValue, null, $this->lain_harga_sekunder_order->ReadOnly);

            // lain_harga_label
            $this->lain_harga_label->setDbValueDef($rsnew, $this->lain_harga_label->CurrentValue, null, $this->lain_harga_label->ReadOnly);

            // lain_harga_label_order
            $this->lain_harga_label_order->setDbValueDef($rsnew, $this->lain_harga_label_order->CurrentValue, null, $this->lain_harga_label_order->ReadOnly);

            // lain_harga_total
            $this->lain_harga_total->setDbValueDef($rsnew, $this->lain_harga_total->CurrentValue, null, $this->lain_harga_total->ReadOnly);

            // lain_harga_total_order
            $this->lain_harga_total_order->setDbValueDef($rsnew, $this->lain_harga_total_order->CurrentValue, null, $this->lain_harga_total_order->ReadOnly);

            // isi_bahan_aktif
            $this->isi_bahan_aktif->setDbValueDef($rsnew, $this->isi_bahan_aktif->CurrentValue, null, $this->isi_bahan_aktif->ReadOnly);

            // isi_bahan_lain
            $this->isi_bahan_lain->setDbValueDef($rsnew, $this->isi_bahan_lain->CurrentValue, null, $this->isi_bahan_lain->ReadOnly);

            // isi_parfum
            $this->isi_parfum->setDbValueDef($rsnew, $this->isi_parfum->CurrentValue, null, $this->isi_parfum->ReadOnly);

            // isi_estetika
            $this->isi_estetika->setDbValueDef($rsnew, $this->isi_estetika->CurrentValue, null, $this->isi_estetika->ReadOnly);

            // kemasan_wadah
            $this->kemasan_wadah->setDbValueDef($rsnew, $this->kemasan_wadah->CurrentValue, null, $this->kemasan_wadah->ReadOnly);

            // kemasan_tutup
            $this->kemasan_tutup->setDbValueDef($rsnew, $this->kemasan_tutup->CurrentValue, null, $this->kemasan_tutup->ReadOnly);

            // kemasan_sekunder
            $this->kemasan_sekunder->setDbValueDef($rsnew, $this->kemasan_sekunder->CurrentValue, null, $this->kemasan_sekunder->ReadOnly);

            // label_desain
            $this->label_desain->setDbValueDef($rsnew, $this->label_desain->CurrentValue, null, $this->label_desain->ReadOnly);

            // label_cetak
            $this->label_cetak->setDbValueDef($rsnew, $this->label_cetak->CurrentValue, null, $this->label_cetak->ReadOnly);

            // label_lainlain
            $this->label_lainlain->setDbValueDef($rsnew, $this->label_lainlain->CurrentValue, null, $this->label_lainlain->ReadOnly);

            // delivery_pickup
            $this->delivery_pickup->setDbValueDef($rsnew, $this->delivery_pickup->CurrentValue, null, $this->delivery_pickup->ReadOnly);

            // delivery_singlepoint
            $this->delivery_singlepoint->setDbValueDef($rsnew, $this->delivery_singlepoint->CurrentValue, null, $this->delivery_singlepoint->ReadOnly);

            // delivery_multipoint
            $this->delivery_multipoint->setDbValueDef($rsnew, $this->delivery_multipoint->CurrentValue, null, $this->delivery_multipoint->ReadOnly);

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->setDbValueDef($rsnew, $this->delivery_jumlahpoint->CurrentValue, null, $this->delivery_jumlahpoint->ReadOnly);

            // delivery_termslain
            $this->delivery_termslain->setDbValueDef($rsnew, $this->delivery_termslain->CurrentValue, null, $this->delivery_termslain->ReadOnly);

            // dibuatdi
            $this->dibuatdi->setDbValueDef($rsnew, $this->dibuatdi->CurrentValue, null, $this->dibuatdi->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), CurrentDate(), $this->created_at->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);

            // Check for duplicate key when key changed
            if ($updateRow) {
                $newKeyFilter = $this->getRecordFilter($rsnew);
                if ($newKeyFilter != $oldKeyFilter) {
                    $rsChk = $this->loadRs($newKeyFilter)->fetch();
                    if ($rsChk !== false) {
                        $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                        $this->setFailureMessage($keyErrMsg);
                        $updateRow = false;
                    }
                }
            }
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "npd") {
            $this->idnpd->CurrentValue = $this->idnpd->getSessionValue();
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // id
        $this->id->setDbValueDef($rsnew, $this->id->CurrentValue, 0, strval($this->id->CurrentValue) == "");

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, strval($this->idnpd->CurrentValue) == "");

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, false);

        // tglsubmit
        $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), null, false);

        // sifat_order
        $tmpBool = $this->sifat_order->CurrentValue;
        if ($tmpBool != "1" && $tmpBool != "0") {
            $tmpBool = !empty($tmpBool) ? "1" : "0";
        }
        $this->sifat_order->setDbValueDef($rsnew, $tmpBool, 0, strval($this->sifat_order->CurrentValue) == "");

        // ukuran_utama
        $this->ukuran_utama->setDbValueDef($rsnew, $this->ukuran_utama->CurrentValue, null, false);

        // utama_harga_isi
        $this->utama_harga_isi->setDbValueDef($rsnew, $this->utama_harga_isi->CurrentValue, null, false);

        // utama_harga_isi_order
        $this->utama_harga_isi_order->setDbValueDef($rsnew, $this->utama_harga_isi_order->CurrentValue, null, false);

        // utama_harga_primer
        $this->utama_harga_primer->setDbValueDef($rsnew, $this->utama_harga_primer->CurrentValue, null, false);

        // utama_harga_primer_order
        $this->utama_harga_primer_order->setDbValueDef($rsnew, $this->utama_harga_primer_order->CurrentValue, null, false);

        // utama_harga_sekunder
        $this->utama_harga_sekunder->setDbValueDef($rsnew, $this->utama_harga_sekunder->CurrentValue, null, false);

        // utama_harga_sekunder_order
        $this->utama_harga_sekunder_order->setDbValueDef($rsnew, $this->utama_harga_sekunder_order->CurrentValue, null, false);

        // utama_harga_label
        $this->utama_harga_label->setDbValueDef($rsnew, $this->utama_harga_label->CurrentValue, null, false);

        // utama_harga_label_order
        $this->utama_harga_label_order->setDbValueDef($rsnew, $this->utama_harga_label_order->CurrentValue, null, false);

        // utama_harga_total
        $this->utama_harga_total->setDbValueDef($rsnew, $this->utama_harga_total->CurrentValue, null, false);

        // utama_harga_total_order
        $this->utama_harga_total_order->setDbValueDef($rsnew, $this->utama_harga_total_order->CurrentValue, null, false);

        // ukuran_lain
        $this->ukuran_lain->setDbValueDef($rsnew, $this->ukuran_lain->CurrentValue, null, false);

        // lain_harga_isi
        $this->lain_harga_isi->setDbValueDef($rsnew, $this->lain_harga_isi->CurrentValue, null, false);

        // lain_harga_isi_order
        $this->lain_harga_isi_order->setDbValueDef($rsnew, $this->lain_harga_isi_order->CurrentValue, null, false);

        // lain_harga_primer
        $this->lain_harga_primer->setDbValueDef($rsnew, $this->lain_harga_primer->CurrentValue, null, false);

        // lain_harga_primer_order
        $this->lain_harga_primer_order->setDbValueDef($rsnew, $this->lain_harga_primer_order->CurrentValue, null, false);

        // lain_harga_sekunder
        $this->lain_harga_sekunder->setDbValueDef($rsnew, $this->lain_harga_sekunder->CurrentValue, null, false);

        // lain_harga_sekunder_order
        $this->lain_harga_sekunder_order->setDbValueDef($rsnew, $this->lain_harga_sekunder_order->CurrentValue, null, false);

        // lain_harga_label
        $this->lain_harga_label->setDbValueDef($rsnew, $this->lain_harga_label->CurrentValue, null, false);

        // lain_harga_label_order
        $this->lain_harga_label_order->setDbValueDef($rsnew, $this->lain_harga_label_order->CurrentValue, null, false);

        // lain_harga_total
        $this->lain_harga_total->setDbValueDef($rsnew, $this->lain_harga_total->CurrentValue, null, false);

        // lain_harga_total_order
        $this->lain_harga_total_order->setDbValueDef($rsnew, $this->lain_harga_total_order->CurrentValue, null, false);

        // isi_bahan_aktif
        $this->isi_bahan_aktif->setDbValueDef($rsnew, $this->isi_bahan_aktif->CurrentValue, null, false);

        // isi_bahan_lain
        $this->isi_bahan_lain->setDbValueDef($rsnew, $this->isi_bahan_lain->CurrentValue, null, false);

        // isi_parfum
        $this->isi_parfum->setDbValueDef($rsnew, $this->isi_parfum->CurrentValue, null, false);

        // isi_estetika
        $this->isi_estetika->setDbValueDef($rsnew, $this->isi_estetika->CurrentValue, null, false);

        // kemasan_wadah
        $this->kemasan_wadah->setDbValueDef($rsnew, $this->kemasan_wadah->CurrentValue, null, false);

        // kemasan_tutup
        $this->kemasan_tutup->setDbValueDef($rsnew, $this->kemasan_tutup->CurrentValue, null, false);

        // kemasan_sekunder
        $this->kemasan_sekunder->setDbValueDef($rsnew, $this->kemasan_sekunder->CurrentValue, null, false);

        // label_desain
        $this->label_desain->setDbValueDef($rsnew, $this->label_desain->CurrentValue, null, false);

        // label_cetak
        $this->label_cetak->setDbValueDef($rsnew, $this->label_cetak->CurrentValue, null, false);

        // label_lainlain
        $this->label_lainlain->setDbValueDef($rsnew, $this->label_lainlain->CurrentValue, null, false);

        // delivery_pickup
        $this->delivery_pickup->setDbValueDef($rsnew, $this->delivery_pickup->CurrentValue, null, false);

        // delivery_singlepoint
        $this->delivery_singlepoint->setDbValueDef($rsnew, $this->delivery_singlepoint->CurrentValue, null, false);

        // delivery_multipoint
        $this->delivery_multipoint->setDbValueDef($rsnew, $this->delivery_multipoint->CurrentValue, null, false);

        // delivery_jumlahpoint
        $this->delivery_jumlahpoint->setDbValueDef($rsnew, $this->delivery_jumlahpoint->CurrentValue, null, false);

        // delivery_termslain
        $this->delivery_termslain->setDbValueDef($rsnew, $this->delivery_termslain->CurrentValue, null, false);

        // dibuatdi
        $this->dibuatdi->setDbValueDef($rsnew, $this->dibuatdi->CurrentValue, null, false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), CurrentDate(), false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['id']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "npd") {
            $masterTbl = Container("npd");
            $this->idnpd->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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
}
