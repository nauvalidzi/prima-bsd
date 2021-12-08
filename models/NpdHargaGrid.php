<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdHargaGrid extends NpdHarga
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_harga';

    // Page object name
    public $PageObjName = "NpdHargaGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpd_hargagrid";
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

        // Table object (npd_harga)
        if (!isset($GLOBALS["npd_harga"]) || get_class($GLOBALS["npd_harga"]) == PROJECT_NAMESPACE . "npd_harga") {
            $GLOBALS["npd_harga"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        $this->AddUrl = "NpdHargaAdd";

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
        $this->id->Visible = false;
        $this->idnpd->setVisibility();
        $this->tglpengajuan->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->bentuk->Visible = false;
        $this->viskositasbarang->setVisibility();
        $this->idaplikasibarang->setVisibility();
        $this->ukuranwadah->Visible = false;
        $this->bahanwadah->Visible = false;
        $this->warnawadah->Visible = false;
        $this->bentukwadah->Visible = false;
        $this->jenistutup->Visible = false;
        $this->bahantutup->Visible = false;
        $this->warnatutup->Visible = false;
        $this->bentuktutup->Visible = false;
        $this->segel->Visible = false;
        $this->catatanprimer->Visible = false;
        $this->packingkarton->Visible = false;
        $this->keteranganpacking->Visible = false;
        $this->beltkarton->Visible = false;
        $this->keteranganbelt->Visible = false;
        $this->bariskarton->Visible = false;
        $this->kolomkarton->Visible = false;
        $this->stackkarton->Visible = false;
        $this->isikarton->Visible = false;
        $this->jenislabel->Visible = false;
        $this->keteranganjenislabel->Visible = false;
        $this->kualitaslabel->Visible = false;
        $this->jumlahwarnalabel->Visible = false;
        $this->etiketlabel->Visible = false;
        $this->keteranganetiket->Visible = false;
        $this->kategoridelivery->Visible = false;
        $this->alamatpengiriman->Visible = false;
        $this->orderperdana->Visible = false;
        $this->orderkontrak->Visible = false;
        $this->hargapcs->setVisibility();
        $this->lampiran->Visible = false;
        $this->disetujui->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->Visible = false;
        $this->readonly->Visible = false;
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
        $this->setupLookupOptions($this->idnpd);
        $this->setupLookupOptions($this->idnpd_sample);
        $this->setupLookupOptions($this->idaplikasibarang);

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
        if ($CurrentForm->hasValue("x_idnpd") && $CurrentForm->hasValue("o_idnpd") && $this->idnpd->CurrentValue != $this->idnpd->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_tglpengajuan") && $CurrentForm->hasValue("o_tglpengajuan") && $this->tglpengajuan->CurrentValue != $this->tglpengajuan->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idnpd_sample") && $CurrentForm->hasValue("o_idnpd_sample") && $this->idnpd_sample->CurrentValue != $this->idnpd_sample->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_viskositasbarang") && $CurrentForm->hasValue("o_viskositasbarang") && $this->viskositasbarang->CurrentValue != $this->viskositasbarang->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idaplikasibarang") && $CurrentForm->hasValue("o_idaplikasibarang") && $this->idaplikasibarang->CurrentValue != $this->idaplikasibarang->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_hargapcs") && $CurrentForm->hasValue("o_hargapcs") && $this->hargapcs->CurrentValue != $this->hargapcs->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_disetujui") && $CurrentForm->hasValue("o_disetujui") && $this->disetujui->CurrentValue != $this->disetujui->OldValue) {
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
        $this->idnpd->clearErrorMessage();
        $this->tglpengajuan->clearErrorMessage();
        $this->idnpd_sample->clearErrorMessage();
        $this->viskositasbarang->clearErrorMessage();
        $this->idaplikasibarang->clearErrorMessage();
        $this->hargapcs->clearErrorMessage();
        $this->disetujui->clearErrorMessage();
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
            if ($Security->canView() && $this->showOptionLink("view")) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit() && $this->showOptionLink("edit")) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete() && $this->showOptionLink("delete")) {
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
        $this->idnpd->CurrentValue = null;
        $this->idnpd->OldValue = $this->idnpd->CurrentValue;
        $this->tglpengajuan->CurrentValue = null;
        $this->tglpengajuan->OldValue = $this->tglpengajuan->CurrentValue;
        $this->idnpd_sample->CurrentValue = null;
        $this->idnpd_sample->OldValue = $this->idnpd_sample->CurrentValue;
        $this->bentuk->CurrentValue = null;
        $this->bentuk->OldValue = $this->bentuk->CurrentValue;
        $this->viskositasbarang->CurrentValue = null;
        $this->viskositasbarang->OldValue = $this->viskositasbarang->CurrentValue;
        $this->idaplikasibarang->CurrentValue = null;
        $this->idaplikasibarang->OldValue = $this->idaplikasibarang->CurrentValue;
        $this->ukuranwadah->CurrentValue = null;
        $this->ukuranwadah->OldValue = $this->ukuranwadah->CurrentValue;
        $this->bahanwadah->CurrentValue = null;
        $this->bahanwadah->OldValue = $this->bahanwadah->CurrentValue;
        $this->warnawadah->CurrentValue = null;
        $this->warnawadah->OldValue = $this->warnawadah->CurrentValue;
        $this->bentukwadah->CurrentValue = null;
        $this->bentukwadah->OldValue = $this->bentukwadah->CurrentValue;
        $this->jenistutup->CurrentValue = null;
        $this->jenistutup->OldValue = $this->jenistutup->CurrentValue;
        $this->bahantutup->CurrentValue = null;
        $this->bahantutup->OldValue = $this->bahantutup->CurrentValue;
        $this->warnatutup->CurrentValue = null;
        $this->warnatutup->OldValue = $this->warnatutup->CurrentValue;
        $this->bentuktutup->CurrentValue = null;
        $this->bentuktutup->OldValue = $this->bentuktutup->CurrentValue;
        $this->segel->CurrentValue = 1;
        $this->segel->OldValue = $this->segel->CurrentValue;
        $this->catatanprimer->CurrentValue = null;
        $this->catatanprimer->OldValue = $this->catatanprimer->CurrentValue;
        $this->packingkarton->CurrentValue = null;
        $this->packingkarton->OldValue = $this->packingkarton->CurrentValue;
        $this->keteranganpacking->CurrentValue = null;
        $this->keteranganpacking->OldValue = $this->keteranganpacking->CurrentValue;
        $this->beltkarton->CurrentValue = null;
        $this->beltkarton->OldValue = $this->beltkarton->CurrentValue;
        $this->keteranganbelt->CurrentValue = null;
        $this->keteranganbelt->OldValue = $this->keteranganbelt->CurrentValue;
        $this->bariskarton->CurrentValue = null;
        $this->bariskarton->OldValue = $this->bariskarton->CurrentValue;
        $this->kolomkarton->CurrentValue = null;
        $this->kolomkarton->OldValue = $this->kolomkarton->CurrentValue;
        $this->stackkarton->CurrentValue = null;
        $this->stackkarton->OldValue = $this->stackkarton->CurrentValue;
        $this->isikarton->CurrentValue = null;
        $this->isikarton->OldValue = $this->isikarton->CurrentValue;
        $this->jenislabel->CurrentValue = null;
        $this->jenislabel->OldValue = $this->jenislabel->CurrentValue;
        $this->keteranganjenislabel->CurrentValue = null;
        $this->keteranganjenislabel->OldValue = $this->keteranganjenislabel->CurrentValue;
        $this->kualitaslabel->CurrentValue = null;
        $this->kualitaslabel->OldValue = $this->kualitaslabel->CurrentValue;
        $this->jumlahwarnalabel->CurrentValue = null;
        $this->jumlahwarnalabel->OldValue = $this->jumlahwarnalabel->CurrentValue;
        $this->etiketlabel->CurrentValue = null;
        $this->etiketlabel->OldValue = $this->etiketlabel->CurrentValue;
        $this->keteranganetiket->CurrentValue = null;
        $this->keteranganetiket->OldValue = $this->keteranganetiket->CurrentValue;
        $this->kategoridelivery->CurrentValue = null;
        $this->kategoridelivery->OldValue = $this->kategoridelivery->CurrentValue;
        $this->alamatpengiriman->CurrentValue = null;
        $this->alamatpengiriman->OldValue = $this->alamatpengiriman->CurrentValue;
        $this->orderperdana->CurrentValue = null;
        $this->orderperdana->OldValue = $this->orderperdana->CurrentValue;
        $this->orderkontrak->CurrentValue = null;
        $this->orderkontrak->OldValue = $this->orderkontrak->CurrentValue;
        $this->hargapcs->CurrentValue = null;
        $this->hargapcs->OldValue = $this->hargapcs->CurrentValue;
        $this->lampiran->Upload->DbValue = null;
        $this->lampiran->OldValue = $this->lampiran->Upload->DbValue;
        $this->lampiran->Upload->Index = $this->RowIndex;
        $this->disetujui->CurrentValue = 1;
        $this->disetujui->OldValue = $this->disetujui->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
        $this->created_by->OldValue = $this->created_by->CurrentValue;
        $this->readonly->CurrentValue = 0;
        $this->readonly->OldValue = $this->readonly->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

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

        // Check field name 'tglpengajuan' first before field var 'x_tglpengajuan'
        $val = $CurrentForm->hasValue("tglpengajuan") ? $CurrentForm->getValue("tglpengajuan") : $CurrentForm->getValue("x_tglpengajuan");
        if (!$this->tglpengajuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglpengajuan->Visible = false; // Disable update for API request
            } else {
                $this->tglpengajuan->setFormValue($val);
            }
            $this->tglpengajuan->CurrentValue = UnFormatDateTime($this->tglpengajuan->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_tglpengajuan")) {
            $this->tglpengajuan->setOldValue($CurrentForm->getValue("o_tglpengajuan"));
        }

        // Check field name 'idnpd_sample' first before field var 'x_idnpd_sample'
        $val = $CurrentForm->hasValue("idnpd_sample") ? $CurrentForm->getValue("idnpd_sample") : $CurrentForm->getValue("x_idnpd_sample");
        if (!$this->idnpd_sample->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd_sample->Visible = false; // Disable update for API request
            } else {
                $this->idnpd_sample->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idnpd_sample")) {
            $this->idnpd_sample->setOldValue($CurrentForm->getValue("o_idnpd_sample"));
        }

        // Check field name 'viskositasbarang' first before field var 'x_viskositasbarang'
        $val = $CurrentForm->hasValue("viskositasbarang") ? $CurrentForm->getValue("viskositasbarang") : $CurrentForm->getValue("x_viskositasbarang");
        if (!$this->viskositasbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositasbarang->Visible = false; // Disable update for API request
            } else {
                $this->viskositasbarang->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_viskositasbarang")) {
            $this->viskositasbarang->setOldValue($CurrentForm->getValue("o_viskositasbarang"));
        }

        // Check field name 'idaplikasibarang' first before field var 'x_idaplikasibarang'
        $val = $CurrentForm->hasValue("idaplikasibarang") ? $CurrentForm->getValue("idaplikasibarang") : $CurrentForm->getValue("x_idaplikasibarang");
        if (!$this->idaplikasibarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idaplikasibarang->Visible = false; // Disable update for API request
            } else {
                $this->idaplikasibarang->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idaplikasibarang")) {
            $this->idaplikasibarang->setOldValue($CurrentForm->getValue("o_idaplikasibarang"));
        }

        // Check field name 'hargapcs' first before field var 'x_hargapcs'
        $val = $CurrentForm->hasValue("hargapcs") ? $CurrentForm->getValue("hargapcs") : $CurrentForm->getValue("x_hargapcs");
        if (!$this->hargapcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hargapcs->Visible = false; // Disable update for API request
            } else {
                $this->hargapcs->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_hargapcs")) {
            $this->hargapcs->setOldValue($CurrentForm->getValue("o_hargapcs"));
        }

        // Check field name 'disetujui' first before field var 'x_disetujui'
        $val = $CurrentForm->hasValue("disetujui") ? $CurrentForm->getValue("disetujui") : $CurrentForm->getValue("x_disetujui");
        if (!$this->disetujui->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->disetujui->Visible = false; // Disable update for API request
            } else {
                $this->disetujui->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_disetujui")) {
            $this->disetujui->setOldValue($CurrentForm->getValue("o_disetujui"));
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
                        $this->id->CurrentValue = $this->id->FormValue;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->tglpengajuan->CurrentValue = $this->tglpengajuan->FormValue;
        $this->tglpengajuan->CurrentValue = UnFormatDateTime($this->tglpengajuan->CurrentValue, 0);
        $this->idnpd_sample->CurrentValue = $this->idnpd_sample->FormValue;
        $this->viskositasbarang->CurrentValue = $this->viskositasbarang->FormValue;
        $this->idaplikasibarang->CurrentValue = $this->idaplikasibarang->FormValue;
        $this->hargapcs->CurrentValue = $this->hargapcs->FormValue;
        $this->disetujui->CurrentValue = $this->disetujui->FormValue;
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
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositasbarang->setDbValue($row['viskositasbarang']);
        $this->idaplikasibarang->setDbValue($row['idaplikasibarang']);
        $this->ukuranwadah->setDbValue($row['ukuranwadah']);
        $this->bahanwadah->setDbValue($row['bahanwadah']);
        $this->warnawadah->setDbValue($row['warnawadah']);
        $this->bentukwadah->setDbValue($row['bentukwadah']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->bahantutup->setDbValue($row['bahantutup']);
        $this->warnatutup->setDbValue($row['warnatutup']);
        $this->bentuktutup->setDbValue($row['bentuktutup']);
        $this->segel->setDbValue($row['segel']);
        $this->catatanprimer->setDbValue($row['catatanprimer']);
        $this->packingkarton->setDbValue($row['packingkarton']);
        $this->keteranganpacking->setDbValue($row['keteranganpacking']);
        $this->beltkarton->setDbValue($row['beltkarton']);
        $this->keteranganbelt->setDbValue($row['keteranganbelt']);
        $this->bariskarton->setDbValue($row['bariskarton']);
        $this->kolomkarton->setDbValue($row['kolomkarton']);
        $this->stackkarton->setDbValue($row['stackkarton']);
        $this->isikarton->setDbValue($row['isikarton']);
        $this->jenislabel->setDbValue($row['jenislabel']);
        $this->keteranganjenislabel->setDbValue($row['keteranganjenislabel']);
        $this->kualitaslabel->setDbValue($row['kualitaslabel']);
        $this->jumlahwarnalabel->setDbValue($row['jumlahwarnalabel']);
        $this->etiketlabel->setDbValue($row['etiketlabel']);
        $this->keteranganetiket->setDbValue($row['keteranganetiket']);
        $this->kategoridelivery->setDbValue($row['kategoridelivery']);
        $this->alamatpengiriman->setDbValue($row['alamatpengiriman']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderkontrak->setDbValue($row['orderkontrak']);
        $this->hargapcs->setDbValue($row['hargapcs']);
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->lampiran->setDbValue($this->lampiran->Upload->DbValue);
        $this->lampiran->Upload->Index = $this->RowIndex;
        $this->disetujui->setDbValue($row['disetujui']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['tglpengajuan'] = $this->tglpengajuan->CurrentValue;
        $row['idnpd_sample'] = $this->idnpd_sample->CurrentValue;
        $row['bentuk'] = $this->bentuk->CurrentValue;
        $row['viskositasbarang'] = $this->viskositasbarang->CurrentValue;
        $row['idaplikasibarang'] = $this->idaplikasibarang->CurrentValue;
        $row['ukuranwadah'] = $this->ukuranwadah->CurrentValue;
        $row['bahanwadah'] = $this->bahanwadah->CurrentValue;
        $row['warnawadah'] = $this->warnawadah->CurrentValue;
        $row['bentukwadah'] = $this->bentukwadah->CurrentValue;
        $row['jenistutup'] = $this->jenistutup->CurrentValue;
        $row['bahantutup'] = $this->bahantutup->CurrentValue;
        $row['warnatutup'] = $this->warnatutup->CurrentValue;
        $row['bentuktutup'] = $this->bentuktutup->CurrentValue;
        $row['segel'] = $this->segel->CurrentValue;
        $row['catatanprimer'] = $this->catatanprimer->CurrentValue;
        $row['packingkarton'] = $this->packingkarton->CurrentValue;
        $row['keteranganpacking'] = $this->keteranganpacking->CurrentValue;
        $row['beltkarton'] = $this->beltkarton->CurrentValue;
        $row['keteranganbelt'] = $this->keteranganbelt->CurrentValue;
        $row['bariskarton'] = $this->bariskarton->CurrentValue;
        $row['kolomkarton'] = $this->kolomkarton->CurrentValue;
        $row['stackkarton'] = $this->stackkarton->CurrentValue;
        $row['isikarton'] = $this->isikarton->CurrentValue;
        $row['jenislabel'] = $this->jenislabel->CurrentValue;
        $row['keteranganjenislabel'] = $this->keteranganjenislabel->CurrentValue;
        $row['kualitaslabel'] = $this->kualitaslabel->CurrentValue;
        $row['jumlahwarnalabel'] = $this->jumlahwarnalabel->CurrentValue;
        $row['etiketlabel'] = $this->etiketlabel->CurrentValue;
        $row['keteranganetiket'] = $this->keteranganetiket->CurrentValue;
        $row['kategoridelivery'] = $this->kategoridelivery->CurrentValue;
        $row['alamatpengiriman'] = $this->alamatpengiriman->CurrentValue;
        $row['orderperdana'] = $this->orderperdana->CurrentValue;
        $row['orderkontrak'] = $this->orderkontrak->CurrentValue;
        $row['hargapcs'] = $this->hargapcs->CurrentValue;
        $row['lampiran'] = $this->lampiran->Upload->DbValue;
        $row['disetujui'] = $this->disetujui->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['created_by'] = $this->created_by->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
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

        // tglpengajuan

        // idnpd_sample

        // bentuk

        // viskositasbarang

        // idaplikasibarang

        // ukuranwadah

        // bahanwadah

        // warnawadah

        // bentukwadah

        // jenistutup

        // bahantutup

        // warnatutup

        // bentuktutup

        // segel

        // catatanprimer

        // packingkarton

        // keteranganpacking

        // beltkarton

        // keteranganbelt

        // bariskarton

        // kolomkarton

        // stackkarton

        // isikarton

        // jenislabel

        // keteranganjenislabel

        // kualitaslabel

        // jumlahwarnalabel

        // etiketlabel

        // keteranganetiket

        // kategoridelivery

        // alamatpengiriman

        // orderperdana

        // orderkontrak

        // hargapcs

        // lampiran

        // disetujui

        // created_at

        // created_by

        // readonly
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
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
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0)" : "";
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

            // bentuk
            $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
            $this->bentuk->ViewCustomAttributes = "";

            // viskositasbarang
            $this->viskositasbarang->ViewValue = $this->viskositasbarang->CurrentValue;
            $this->viskositasbarang->ViewCustomAttributes = "";

            // idaplikasibarang
            $curVal = trim(strval($this->idaplikasibarang->CurrentValue));
            if ($curVal != "") {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->lookupCacheOption($curVal);
                if ($this->idaplikasibarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idaplikasibarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idaplikasibarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->displayValue($arwrk);
                    } else {
                        $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->CurrentValue;
                    }
                }
            } else {
                $this->idaplikasibarang->ViewValue = null;
            }
            $this->idaplikasibarang->ViewCustomAttributes = "";

            // ukuranwadah
            $this->ukuranwadah->ViewValue = $this->ukuranwadah->CurrentValue;
            $this->ukuranwadah->ViewCustomAttributes = "";

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

            // packingkarton
            $this->packingkarton->ViewValue = $this->packingkarton->CurrentValue;
            $this->packingkarton->ViewCustomAttributes = "";

            // keteranganpacking
            $this->keteranganpacking->ViewValue = $this->keteranganpacking->CurrentValue;
            $this->keteranganpacking->ViewCustomAttributes = "";

            // beltkarton
            $this->beltkarton->ViewValue = $this->beltkarton->CurrentValue;
            $this->beltkarton->ViewCustomAttributes = "";

            // keteranganbelt
            $this->keteranganbelt->ViewValue = $this->keteranganbelt->CurrentValue;
            $this->keteranganbelt->ViewCustomAttributes = "";

            // bariskarton
            $this->bariskarton->ViewValue = $this->bariskarton->CurrentValue;
            $this->bariskarton->ViewValue = FormatNumber($this->bariskarton->ViewValue, 0, -2, -2, -2);
            $this->bariskarton->ViewCustomAttributes = "";

            // kolomkarton
            $this->kolomkarton->ViewValue = $this->kolomkarton->CurrentValue;
            $this->kolomkarton->ViewValue = FormatNumber($this->kolomkarton->ViewValue, 0, -2, -2, -2);
            $this->kolomkarton->ViewCustomAttributes = "";

            // stackkarton
            $this->stackkarton->ViewValue = $this->stackkarton->CurrentValue;
            $this->stackkarton->ViewValue = FormatNumber($this->stackkarton->ViewValue, 0, -2, -2, -2);
            $this->stackkarton->ViewCustomAttributes = "";

            // isikarton
            $this->isikarton->ViewValue = $this->isikarton->CurrentValue;
            $this->isikarton->ViewValue = FormatNumber($this->isikarton->ViewValue, 0, -2, -2, -2);
            $this->isikarton->ViewCustomAttributes = "";

            // jenislabel
            $this->jenislabel->ViewValue = $this->jenislabel->CurrentValue;
            $this->jenislabel->ViewCustomAttributes = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->ViewValue = $this->keteranganjenislabel->CurrentValue;
            $this->keteranganjenislabel->ViewCustomAttributes = "";

            // kualitaslabel
            $this->kualitaslabel->ViewValue = $this->kualitaslabel->CurrentValue;
            $this->kualitaslabel->ViewCustomAttributes = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->ViewValue = $this->jumlahwarnalabel->CurrentValue;
            $this->jumlahwarnalabel->ViewCustomAttributes = "";

            // etiketlabel
            $this->etiketlabel->ViewValue = $this->etiketlabel->CurrentValue;
            $this->etiketlabel->ViewCustomAttributes = "";

            // keteranganetiket
            $this->keteranganetiket->ViewValue = $this->keteranganetiket->CurrentValue;
            $this->keteranganetiket->ViewCustomAttributes = "";

            // kategoridelivery
            $this->kategoridelivery->ViewValue = $this->kategoridelivery->CurrentValue;
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

            // hargapcs
            $this->hargapcs->ViewValue = $this->hargapcs->CurrentValue;
            $this->hargapcs->ViewValue = FormatCurrency($this->hargapcs->ViewValue, 2, -2, -2, -2);
            $this->hargapcs->ViewCustomAttributes = "";

            // lampiran
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->ViewValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->ViewValue = "";
            }
            $this->lampiran->ViewCustomAttributes = "";

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

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

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

            // viskositasbarang
            $this->viskositasbarang->LinkCustomAttributes = "";
            $this->viskositasbarang->HrefValue = "";
            $this->viskositasbarang->TooltipValue = "";

            // idaplikasibarang
            $this->idaplikasibarang->LinkCustomAttributes = "";
            $this->idaplikasibarang->HrefValue = "";
            $this->idaplikasibarang->TooltipValue = "";

            // hargapcs
            $this->hargapcs->LinkCustomAttributes = "";
            $this->hargapcs->HrefValue = "";
            $this->hargapcs->TooltipValue = "";

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";
            $this->disetujui->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
                $this->idnpd->OldValue = $this->idnpd->CurrentValue;
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                    if ($this->idnpd->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
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
            } else {
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                } else {
                    $this->idnpd->ViewValue = $this->idnpd->Lookup !== null && is_array($this->idnpd->Lookup->Options) ? $curVal : null;
                }
                if ($this->idnpd->ViewValue !== null) { // Load from cache
                    $this->idnpd->EditValue = array_values($this->idnpd->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idnpd->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idnpd->EditValue = $arwrk;
                }
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // tglpengajuan
            $this->tglpengajuan->EditAttrs["class"] = "form-control";
            $this->tglpengajuan->EditCustomAttributes = "";
            $this->tglpengajuan->EditValue = HtmlEncode(FormatDateTime($this->tglpengajuan->CurrentValue, 8));
            $this->tglpengajuan->PlaceHolder = RemoveHtml($this->tglpengajuan->caption());

            // idnpd_sample
            $this->idnpd_sample->EditAttrs["class"] = "form-control";
            $this->idnpd_sample->EditCustomAttributes = "";
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            } else {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->Lookup !== null && is_array($this->idnpd_sample->Lookup->Options) ? $curVal : null;
            }
            if ($this->idnpd_sample->ViewValue !== null) { // Load from cache
                $this->idnpd_sample->EditValue = array_values($this->idnpd_sample->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idnpd_sample->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idnpd_sample->EditValue = $arwrk;
            }
            $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

            // viskositasbarang
            $this->viskositasbarang->EditAttrs["class"] = "form-control";
            $this->viskositasbarang->EditCustomAttributes = "";
            if (!$this->viskositasbarang->Raw) {
                $this->viskositasbarang->CurrentValue = HtmlDecode($this->viskositasbarang->CurrentValue);
            }
            $this->viskositasbarang->EditValue = HtmlEncode($this->viskositasbarang->CurrentValue);
            $this->viskositasbarang->PlaceHolder = RemoveHtml($this->viskositasbarang->caption());

            // idaplikasibarang
            $this->idaplikasibarang->EditAttrs["class"] = "form-control";
            $this->idaplikasibarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idaplikasibarang->CurrentValue));
            if ($curVal != "") {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->lookupCacheOption($curVal);
            } else {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->Lookup !== null && is_array($this->idaplikasibarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idaplikasibarang->ViewValue !== null) { // Load from cache
                $this->idaplikasibarang->EditValue = array_values($this->idaplikasibarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idaplikasibarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idaplikasibarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idaplikasibarang->EditValue = $arwrk;
            }
            $this->idaplikasibarang->PlaceHolder = RemoveHtml($this->idaplikasibarang->caption());

            // hargapcs
            $this->hargapcs->EditAttrs["class"] = "form-control";
            $this->hargapcs->EditCustomAttributes = "";
            $this->hargapcs->EditValue = HtmlEncode($this->hargapcs->CurrentValue);
            $this->hargapcs->PlaceHolder = RemoveHtml($this->hargapcs->caption());

            // disetujui
            $this->disetujui->EditCustomAttributes = "";
            $this->disetujui->EditValue = $this->disetujui->options(false);
            $this->disetujui->PlaceHolder = RemoveHtml($this->disetujui->caption());

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // tglpengajuan
            $this->tglpengajuan->LinkCustomAttributes = "";
            $this->tglpengajuan->HrefValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";

            // viskositasbarang
            $this->viskositasbarang->LinkCustomAttributes = "";
            $this->viskositasbarang->HrefValue = "";

            // idaplikasibarang
            $this->idaplikasibarang->LinkCustomAttributes = "";
            $this->idaplikasibarang->HrefValue = "";

            // hargapcs
            $this->hargapcs->LinkCustomAttributes = "";
            $this->hargapcs->HrefValue = "";

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
                $this->idnpd->OldValue = $this->idnpd->CurrentValue;
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                    if ($this->idnpd->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $lookupFilter = function() {
                            return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
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
            } else {
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                } else {
                    $this->idnpd->ViewValue = $this->idnpd->Lookup !== null && is_array($this->idnpd->Lookup->Options) ? $curVal : null;
                }
                if ($this->idnpd->ViewValue !== null) { // Load from cache
                    $this->idnpd->EditValue = array_values($this->idnpd->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idnpd->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idnpd->EditValue = $arwrk;
                }
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // tglpengajuan
            $this->tglpengajuan->EditAttrs["class"] = "form-control";
            $this->tglpengajuan->EditCustomAttributes = "";
            $this->tglpengajuan->EditValue = HtmlEncode(FormatDateTime($this->tglpengajuan->CurrentValue, 8));
            $this->tglpengajuan->PlaceHolder = RemoveHtml($this->tglpengajuan->caption());

            // idnpd_sample
            $this->idnpd_sample->EditAttrs["class"] = "form-control";
            $this->idnpd_sample->EditCustomAttributes = "";
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            } else {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->Lookup !== null && is_array($this->idnpd_sample->Lookup->Options) ? $curVal : null;
            }
            if ($this->idnpd_sample->ViewValue !== null) { // Load from cache
                $this->idnpd_sample->EditValue = array_values($this->idnpd_sample->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idnpd_sample->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idnpd_sample->EditValue = $arwrk;
            }
            $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

            // viskositasbarang
            $this->viskositasbarang->EditAttrs["class"] = "form-control";
            $this->viskositasbarang->EditCustomAttributes = "";
            if (!$this->viskositasbarang->Raw) {
                $this->viskositasbarang->CurrentValue = HtmlDecode($this->viskositasbarang->CurrentValue);
            }
            $this->viskositasbarang->EditValue = HtmlEncode($this->viskositasbarang->CurrentValue);
            $this->viskositasbarang->PlaceHolder = RemoveHtml($this->viskositasbarang->caption());

            // idaplikasibarang
            $this->idaplikasibarang->EditAttrs["class"] = "form-control";
            $this->idaplikasibarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idaplikasibarang->CurrentValue));
            if ($curVal != "") {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->lookupCacheOption($curVal);
            } else {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->Lookup !== null && is_array($this->idaplikasibarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idaplikasibarang->ViewValue !== null) { // Load from cache
                $this->idaplikasibarang->EditValue = array_values($this->idaplikasibarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idaplikasibarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idaplikasibarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idaplikasibarang->EditValue = $arwrk;
            }
            $this->idaplikasibarang->PlaceHolder = RemoveHtml($this->idaplikasibarang->caption());

            // hargapcs
            $this->hargapcs->EditAttrs["class"] = "form-control";
            $this->hargapcs->EditCustomAttributes = "";
            $this->hargapcs->EditValue = HtmlEncode($this->hargapcs->CurrentValue);
            $this->hargapcs->PlaceHolder = RemoveHtml($this->hargapcs->caption());

            // disetujui
            $this->disetujui->EditCustomAttributes = "";
            $this->disetujui->EditValue = $this->disetujui->options(false);
            $this->disetujui->PlaceHolder = RemoveHtml($this->disetujui->caption());

            // Edit refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // tglpengajuan
            $this->tglpengajuan->LinkCustomAttributes = "";
            $this->tglpengajuan->HrefValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";

            // viskositasbarang
            $this->viskositasbarang->LinkCustomAttributes = "";
            $this->viskositasbarang->HrefValue = "";

            // idaplikasibarang
            $this->idaplikasibarang->LinkCustomAttributes = "";
            $this->idaplikasibarang->HrefValue = "";

            // hargapcs
            $this->hargapcs->LinkCustomAttributes = "";
            $this->hargapcs->HrefValue = "";

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";
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
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if ($this->tglpengajuan->Required) {
            if (!$this->tglpengajuan->IsDetailKey && EmptyValue($this->tglpengajuan->FormValue)) {
                $this->tglpengajuan->addErrorMessage(str_replace("%s", $this->tglpengajuan->caption(), $this->tglpengajuan->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglpengajuan->FormValue)) {
            $this->tglpengajuan->addErrorMessage($this->tglpengajuan->getErrorMessage(false));
        }
        if ($this->idnpd_sample->Required) {
            if (!$this->idnpd_sample->IsDetailKey && EmptyValue($this->idnpd_sample->FormValue)) {
                $this->idnpd_sample->addErrorMessage(str_replace("%s", $this->idnpd_sample->caption(), $this->idnpd_sample->RequiredErrorMessage));
            }
        }
        if ($this->viskositasbarang->Required) {
            if (!$this->viskositasbarang->IsDetailKey && EmptyValue($this->viskositasbarang->FormValue)) {
                $this->viskositasbarang->addErrorMessage(str_replace("%s", $this->viskositasbarang->caption(), $this->viskositasbarang->RequiredErrorMessage));
            }
        }
        if ($this->idaplikasibarang->Required) {
            if (!$this->idaplikasibarang->IsDetailKey && EmptyValue($this->idaplikasibarang->FormValue)) {
                $this->idaplikasibarang->addErrorMessage(str_replace("%s", $this->idaplikasibarang->caption(), $this->idaplikasibarang->RequiredErrorMessage));
            }
        }
        if ($this->hargapcs->Required) {
            if (!$this->hargapcs->IsDetailKey && EmptyValue($this->hargapcs->FormValue)) {
                $this->hargapcs->addErrorMessage(str_replace("%s", $this->hargapcs->caption(), $this->hargapcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->hargapcs->FormValue)) {
            $this->hargapcs->addErrorMessage($this->hargapcs->getErrorMessage(false));
        }
        if ($this->disetujui->Required) {
            if ($this->disetujui->FormValue == "") {
                $this->disetujui->addErrorMessage(str_replace("%s", $this->disetujui->caption(), $this->disetujui->RequiredErrorMessage));
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

            // idnpd
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->ReadOnly = true;
            }
            $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, $this->idnpd->ReadOnly);

            // tglpengajuan
            $this->tglpengajuan->setDbValueDef($rsnew, UnFormatDateTime($this->tglpengajuan->CurrentValue, 0), CurrentDate(), $this->tglpengajuan->ReadOnly);

            // idnpd_sample
            $this->idnpd_sample->setDbValueDef($rsnew, $this->idnpd_sample->CurrentValue, 0, $this->idnpd_sample->ReadOnly);

            // viskositasbarang
            $this->viskositasbarang->setDbValueDef($rsnew, $this->viskositasbarang->CurrentValue, "", $this->viskositasbarang->ReadOnly);

            // idaplikasibarang
            $this->idaplikasibarang->setDbValueDef($rsnew, $this->idaplikasibarang->CurrentValue, 0, $this->idaplikasibarang->ReadOnly);

            // hargapcs
            $this->hargapcs->setDbValueDef($rsnew, $this->hargapcs->CurrentValue, 0, $this->hargapcs->ReadOnly);

            // disetujui
            $this->disetujui->setDbValueDef($rsnew, $this->disetujui->CurrentValue, 0, $this->disetujui->ReadOnly);

            // Check referential integrity for master table 'npd'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_npd();
            $keyValue = $rsnew['idnpd'] ?? $rsold['idnpd'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("npd")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "npd", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }

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

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "npd") {
            $this->idnpd->CurrentValue = $this->idnpd->getSessionValue();
        }

        // Check referential integrity for master table 'npd_harga'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_npd();
        if (strval($this->idnpd->CurrentValue) != "") {
            $masterFilter = str_replace("@id@", AdjustSql($this->idnpd->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("npd")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "npd", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, strval($this->idnpd->CurrentValue) == "");

        // tglpengajuan
        $this->tglpengajuan->setDbValueDef($rsnew, UnFormatDateTime($this->tglpengajuan->CurrentValue, 0), CurrentDate(), false);

        // idnpd_sample
        $this->idnpd_sample->setDbValueDef($rsnew, $this->idnpd_sample->CurrentValue, 0, strval($this->idnpd_sample->CurrentValue) == "");

        // viskositasbarang
        $this->viskositasbarang->setDbValueDef($rsnew, $this->viskositasbarang->CurrentValue, "", false);

        // idaplikasibarang
        $this->idaplikasibarang->setDbValueDef($rsnew, $this->idaplikasibarang->CurrentValue, 0, false);

        // hargapcs
        $this->hargapcs->setDbValueDef($rsnew, $this->hargapcs->CurrentValue, 0, false);

        // disetujui
        $this->disetujui->setDbValueDef($rsnew, $this->disetujui->CurrentValue, 0, strval($this->disetujui->CurrentValue) == "");

        // created_by
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            $rsnew['created_by'] = CurrentUserID();
        }

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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "npd") {
            $masterTbl = Container("npd");
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
                case "x_idnpd":
                    $lookupFilter = function () {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0)" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idaplikasibarang":
                    break;
                case "x_segel":
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
