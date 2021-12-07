<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class CustomerGrid extends Customer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'customer';

    // Page object name
    public $PageObjName = "CustomerGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fcustomergrid";
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

        // Table object (customer)
        if (!isset($GLOBALS["customer"]) || get_class($GLOBALS["customer"]) == PROJECT_NAMESPACE . "customer") {
            $GLOBALS["customer"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        $this->AddUrl = "CustomerAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'customer');
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
                $doc = new $class(Container("customer"));
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
        $this->kode->setVisibility();
        $this->idtipecustomer->setVisibility();
        $this->idpegawai->setVisibility();
        $this->nama->setVisibility();
        $this->jenis_usaha->setVisibility();
        $this->jabatan->Visible = false;
        $this->idprov->Visible = false;
        $this->idkab->Visible = false;
        $this->idkec->Visible = false;
        $this->idkel->Visible = false;
        $this->kodepos->Visible = false;
        $this->alamat->Visible = false;
        $this->telpon->Visible = false;
        $this->hp->setVisibility();
        $this->_email->Visible = false;
        $this->website->Visible = false;
        $this->foto->Visible = false;
        $this->ktp->Visible = false;
        $this->npwp->Visible = false;
        $this->limit_kredit_order->Visible = false;
        $this->jatuh_tempo_invoice->Visible = false;
        $this->kodenpd->Visible = false;
        $this->klinik->setVisibility();
        $this->keterangan->Visible = false;
        $this->aktif->Visible = false;
        $this->created_at->Visible = false;
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

        // Set up lookup cache
        $this->setupLookupOptions($this->idtipecustomer);
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idprov);
        $this->setupLookupOptions($this->idkab);
        $this->setupLookupOptions($this->idkec);
        $this->setupLookupOptions($this->idkel);
        $this->setupLookupOptions($this->jatuh_tempo_invoice);

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

        // Add master User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
                if ($this->getCurrentMasterTable() == "pegawai") {
                    $this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "pegawai"); // Add master User ID filter
                }
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "pegawai") {
            $masterTbl = Container("pegawai");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("PegawaiList"); // Return to master page
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
        if ($CurrentForm->hasValue("x_kode") && $CurrentForm->hasValue("o_kode") && $this->kode->CurrentValue != $this->kode->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idtipecustomer") && $CurrentForm->hasValue("o_idtipecustomer") && $this->idtipecustomer->CurrentValue != $this->idtipecustomer->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idpegawai") && $CurrentForm->hasValue("o_idpegawai") && $this->idpegawai->CurrentValue != $this->idpegawai->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_nama") && $CurrentForm->hasValue("o_nama") && $this->nama->CurrentValue != $this->nama->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_jenis_usaha") && $CurrentForm->hasValue("o_jenis_usaha") && $this->jenis_usaha->CurrentValue != $this->jenis_usaha->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_hp") && $CurrentForm->hasValue("o_hp") && $this->hp->CurrentValue != $this->hp->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_klinik") && $CurrentForm->hasValue("o_klinik") && $this->klinik->CurrentValue != $this->klinik->OldValue) {
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
        $this->kode->clearErrorMessage();
        $this->idtipecustomer->clearErrorMessage();
        $this->idpegawai->clearErrorMessage();
        $this->nama->clearErrorMessage();
        $this->jenis_usaha->clearErrorMessage();
        $this->hp->clearErrorMessage();
        $this->klinik->clearErrorMessage();
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
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->idpegawai->setSessionValue("");
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

        // "sequence"
        $opt = $this->ListOptions["sequence"];
        $opt->Body = FormatSequenceNumber($this->RecordCount);
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
        $links = "";
        $btngrps = "";
        $sqlwrk = "`idcustomer`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_alamat_customer"
        if ($this->DetailPages && $this->DetailPages["alamat_customer"] && $this->DetailPages["alamat_customer"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_alamat_customer"];
            $url = "AlamatCustomerPreview?t=customer&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"alamat_customer\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'customer')) {
                $label = $Language->TablePhrase("alamat_customer", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("alamat_customer")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"alamat_customer\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("AlamatCustomerList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("alamat_customer", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("AlamatCustomerGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=alamat_customer");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=alamat_customer");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idcustomer`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_brand_customer"
        if ($this->DetailPages && $this->DetailPages["brand_customer"] && $this->DetailPages["brand_customer"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_brand_customer"];
            $url = "BrandCustomerPreview?t=customer&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"brand_customer\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'customer')) {
                $label = $Language->TablePhrase("brand_customer", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("brand_customer")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"brand_customer\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("BrandCustomerList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("brand_customer", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("BrandCustomerGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=brand_customer");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=brand_customer");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idcustomer`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_order"
        if ($this->DetailPages && $this->DetailPages["order"] && $this->DetailPages["order"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_order"];
            $url = "OrderPreview?t=customer&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"order\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'customer')) {
                $label = $Language->TablePhrase("order", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("order")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"order\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("OrderList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("order", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("OrderGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=order");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=order");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }
        $sqlwrk = "`idcustomer`=" . AdjustSql($this->id->CurrentValue, $this->Dbid) . "";

        // Column "detail_invoice"
        if ($this->DetailPages && $this->DetailPages["invoice"] && $this->DetailPages["invoice"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_invoice"];
            $url = "InvoicePreview?t=customer&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"invoice\" data-url=\"" . $url . "\">";
            if ($Security->allowList(CurrentProjectID() . 'customer')) {
                $label = $Language->TablePhrase("invoice", "TblCaption");
                $label .= "&nbsp;" . JsEncode(str_replace("%c", Container("invoice")->Count, $Language->phrase("DetailCount")));
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"invoice\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("InvoiceList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . $Language->TablePhrase("invoice", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</a>";
            }
            $detailPageObj = Container("InvoiceGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=invoice");
                $btngrp .= "<a href=\"#\" class=\"mr-2\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=invoice");
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
        $this->kode->CurrentValue = null;
        $this->kode->OldValue = $this->kode->CurrentValue;
        $this->idtipecustomer->CurrentValue = null;
        $this->idtipecustomer->OldValue = $this->idtipecustomer->CurrentValue;
        $this->idpegawai->CurrentValue = null;
        $this->idpegawai->OldValue = $this->idpegawai->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->jenis_usaha->CurrentValue = null;
        $this->jenis_usaha->OldValue = $this->jenis_usaha->CurrentValue;
        $this->jabatan->CurrentValue = null;
        $this->jabatan->OldValue = $this->jabatan->CurrentValue;
        $this->idprov->CurrentValue = null;
        $this->idprov->OldValue = $this->idprov->CurrentValue;
        $this->idkab->CurrentValue = null;
        $this->idkab->OldValue = $this->idkab->CurrentValue;
        $this->idkec->CurrentValue = null;
        $this->idkec->OldValue = $this->idkec->CurrentValue;
        $this->idkel->CurrentValue = null;
        $this->idkel->OldValue = $this->idkel->CurrentValue;
        $this->kodepos->CurrentValue = null;
        $this->kodepos->OldValue = $this->kodepos->CurrentValue;
        $this->alamat->CurrentValue = null;
        $this->alamat->OldValue = $this->alamat->CurrentValue;
        $this->telpon->CurrentValue = null;
        $this->telpon->OldValue = $this->telpon->CurrentValue;
        $this->hp->CurrentValue = null;
        $this->hp->OldValue = $this->hp->CurrentValue;
        $this->_email->CurrentValue = null;
        $this->_email->OldValue = $this->_email->CurrentValue;
        $this->website->CurrentValue = null;
        $this->website->OldValue = $this->website->CurrentValue;
        $this->foto->Upload->DbValue = null;
        $this->foto->OldValue = $this->foto->Upload->DbValue;
        $this->foto->Upload->Index = $this->RowIndex;
        $this->ktp->CurrentValue = null;
        $this->ktp->OldValue = $this->ktp->CurrentValue;
        $this->npwp->CurrentValue = null;
        $this->npwp->OldValue = $this->npwp->CurrentValue;
        $this->limit_kredit_order->CurrentValue = null;
        $this->limit_kredit_order->OldValue = $this->limit_kredit_order->CurrentValue;
        $this->jatuh_tempo_invoice->CurrentValue = null;
        $this->jatuh_tempo_invoice->OldValue = $this->jatuh_tempo_invoice->CurrentValue;
        $this->kodenpd->CurrentValue = null;
        $this->kodenpd->OldValue = $this->kodenpd->CurrentValue;
        $this->klinik->CurrentValue = null;
        $this->klinik->OldValue = $this->klinik->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->aktif->CurrentValue = null;
        $this->aktif->OldValue = $this->aktif->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = CurrentDate();
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

        // Check field name 'kode' first before field var 'x_kode'
        $val = $CurrentForm->hasValue("kode") ? $CurrentForm->getValue("kode") : $CurrentForm->getValue("x_kode");
        if (!$this->kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode->Visible = false; // Disable update for API request
            } else {
                $this->kode->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_kode")) {
            $this->kode->setOldValue($CurrentForm->getValue("o_kode"));
        }

        // Check field name 'idtipecustomer' first before field var 'x_idtipecustomer'
        $val = $CurrentForm->hasValue("idtipecustomer") ? $CurrentForm->getValue("idtipecustomer") : $CurrentForm->getValue("x_idtipecustomer");
        if (!$this->idtipecustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idtipecustomer->Visible = false; // Disable update for API request
            } else {
                $this->idtipecustomer->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idtipecustomer")) {
            $this->idtipecustomer->setOldValue($CurrentForm->getValue("o_idtipecustomer"));
        }

        // Check field name 'idpegawai' first before field var 'x_idpegawai'
        $val = $CurrentForm->hasValue("idpegawai") ? $CurrentForm->getValue("idpegawai") : $CurrentForm->getValue("x_idpegawai");
        if (!$this->idpegawai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idpegawai->Visible = false; // Disable update for API request
            } else {
                $this->idpegawai->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idpegawai")) {
            $this->idpegawai->setOldValue($CurrentForm->getValue("o_idpegawai"));
        }

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_nama")) {
            $this->nama->setOldValue($CurrentForm->getValue("o_nama"));
        }

        // Check field name 'jenis_usaha' first before field var 'x_jenis_usaha'
        $val = $CurrentForm->hasValue("jenis_usaha") ? $CurrentForm->getValue("jenis_usaha") : $CurrentForm->getValue("x_jenis_usaha");
        if (!$this->jenis_usaha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenis_usaha->Visible = false; // Disable update for API request
            } else {
                $this->jenis_usaha->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_jenis_usaha")) {
            $this->jenis_usaha->setOldValue($CurrentForm->getValue("o_jenis_usaha"));
        }

        // Check field name 'hp' first before field var 'x_hp'
        $val = $CurrentForm->hasValue("hp") ? $CurrentForm->getValue("hp") : $CurrentForm->getValue("x_hp");
        if (!$this->hp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hp->Visible = false; // Disable update for API request
            } else {
                $this->hp->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_hp")) {
            $this->hp->setOldValue($CurrentForm->getValue("o_hp"));
        }

        // Check field name 'klinik' first before field var 'x_klinik'
        $val = $CurrentForm->hasValue("klinik") ? $CurrentForm->getValue("klinik") : $CurrentForm->getValue("x_klinik");
        if (!$this->klinik->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->klinik->Visible = false; // Disable update for API request
            } else {
                $this->klinik->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_klinik")) {
            $this->klinik->setOldValue($CurrentForm->getValue("o_klinik"));
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->idtipecustomer->CurrentValue = $this->idtipecustomer->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->jenis_usaha->CurrentValue = $this->jenis_usaha->FormValue;
        $this->hp->CurrentValue = $this->hp->FormValue;
        $this->klinik->CurrentValue = $this->klinik->FormValue;
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
        $this->kode->setDbValue($row['kode']);
        $this->idtipecustomer->setDbValue($row['idtipecustomer']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->nama->setDbValue($row['nama']);
        $this->jenis_usaha->setDbValue($row['jenis_usaha']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->idprov->setDbValue($row['idprov']);
        $this->idkab->setDbValue($row['idkab']);
        $this->idkec->setDbValue($row['idkec']);
        $this->idkel->setDbValue($row['idkel']);
        $this->kodepos->setDbValue($row['kodepos']);
        $this->alamat->setDbValue($row['alamat']);
        $this->telpon->setDbValue($row['telpon']);
        $this->hp->setDbValue($row['hp']);
        $this->_email->setDbValue($row['email']);
        $this->website->setDbValue($row['website']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->foto->Upload->Index = $this->RowIndex;
        $this->ktp->setDbValue($row['ktp']);
        $this->npwp->setDbValue($row['npwp']);
        $this->limit_kredit_order->setDbValue($row['limit_kredit_order']);
        $this->jatuh_tempo_invoice->setDbValue($row['jatuh_tempo_invoice']);
        $this->kodenpd->setDbValue($row['kodenpd']);
        $this->klinik->setDbValue($row['klinik']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->aktif->setDbValue($row['aktif']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['kode'] = $this->kode->CurrentValue;
        $row['idtipecustomer'] = $this->idtipecustomer->CurrentValue;
        $row['idpegawai'] = $this->idpegawai->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['jenis_usaha'] = $this->jenis_usaha->CurrentValue;
        $row['jabatan'] = $this->jabatan->CurrentValue;
        $row['idprov'] = $this->idprov->CurrentValue;
        $row['idkab'] = $this->idkab->CurrentValue;
        $row['idkec'] = $this->idkec->CurrentValue;
        $row['idkel'] = $this->idkel->CurrentValue;
        $row['kodepos'] = $this->kodepos->CurrentValue;
        $row['alamat'] = $this->alamat->CurrentValue;
        $row['telpon'] = $this->telpon->CurrentValue;
        $row['hp'] = $this->hp->CurrentValue;
        $row['email'] = $this->_email->CurrentValue;
        $row['website'] = $this->website->CurrentValue;
        $row['foto'] = $this->foto->Upload->DbValue;
        $row['ktp'] = $this->ktp->CurrentValue;
        $row['npwp'] = $this->npwp->CurrentValue;
        $row['limit_kredit_order'] = $this->limit_kredit_order->CurrentValue;
        $row['jatuh_tempo_invoice'] = $this->jatuh_tempo_invoice->CurrentValue;
        $row['kodenpd'] = $this->kodenpd->CurrentValue;
        $row['klinik'] = $this->klinik->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
        $row['aktif'] = $this->aktif->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
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

        // kode

        // idtipecustomer

        // idpegawai

        // nama

        // jenis_usaha

        // jabatan

        // idprov

        // idkab

        // idkec

        // idkel

        // kodepos

        // alamat

        // telpon

        // hp

        // email

        // website

        // foto

        // ktp

        // npwp

        // limit_kredit_order

        // jatuh_tempo_invoice

        // kodenpd

        // klinik

        // keterangan

        // aktif

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // idtipecustomer
            $curVal = trim(strval($this->idtipecustomer->CurrentValue));
            if ($curVal != "") {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->lookupCacheOption($curVal);
                if ($this->idtipecustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idtipecustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idtipecustomer->Lookup->renderViewRow($rswrk[0]);
                        $this->idtipecustomer->ViewValue = $this->idtipecustomer->displayValue($arwrk);
                    } else {
                        $this->idtipecustomer->ViewValue = $this->idtipecustomer->CurrentValue;
                    }
                }
            } else {
                $this->idtipecustomer->ViewValue = null;
            }
            $this->idtipecustomer->ViewCustomAttributes = "";

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

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // jenis_usaha
            $this->jenis_usaha->ViewValue = $this->jenis_usaha->CurrentValue;
            $this->jenis_usaha->ViewCustomAttributes = "";

            // jabatan
            $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
            $this->jabatan->ViewCustomAttributes = "";

            // idprov
            $curVal = trim(strval($this->idprov->CurrentValue));
            if ($curVal != "") {
                $this->idprov->ViewValue = $this->idprov->lookupCacheOption($curVal);
                if ($this->idprov->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idprov->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idprov->Lookup->renderViewRow($rswrk[0]);
                        $this->idprov->ViewValue = $this->idprov->displayValue($arwrk);
                    } else {
                        $this->idprov->ViewValue = $this->idprov->CurrentValue;
                    }
                }
            } else {
                $this->idprov->ViewValue = null;
            }
            $this->idprov->ViewCustomAttributes = "";

            // idkab
            $curVal = trim(strval($this->idkab->CurrentValue));
            if ($curVal != "") {
                $this->idkab->ViewValue = $this->idkab->lookupCacheOption($curVal);
                if ($this->idkab->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkab->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkab->Lookup->renderViewRow($rswrk[0]);
                        $this->idkab->ViewValue = $this->idkab->displayValue($arwrk);
                    } else {
                        $this->idkab->ViewValue = $this->idkab->CurrentValue;
                    }
                }
            } else {
                $this->idkab->ViewValue = null;
            }
            $this->idkab->ViewCustomAttributes = "";

            // idkec
            $curVal = trim(strval($this->idkec->CurrentValue));
            if ($curVal != "") {
                $this->idkec->ViewValue = $this->idkec->lookupCacheOption($curVal);
                if ($this->idkec->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkec->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkec->Lookup->renderViewRow($rswrk[0]);
                        $this->idkec->ViewValue = $this->idkec->displayValue($arwrk);
                    } else {
                        $this->idkec->ViewValue = $this->idkec->CurrentValue;
                    }
                }
            } else {
                $this->idkec->ViewValue = null;
            }
            $this->idkec->ViewCustomAttributes = "";

            // idkel
            $curVal = trim(strval($this->idkel->CurrentValue));
            if ($curVal != "") {
                $this->idkel->ViewValue = $this->idkel->lookupCacheOption($curVal);
                if ($this->idkel->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkel->Lookup->renderViewRow($rswrk[0]);
                        $this->idkel->ViewValue = $this->idkel->displayValue($arwrk);
                    } else {
                        $this->idkel->ViewValue = $this->idkel->CurrentValue;
                    }
                }
            } else {
                $this->idkel->ViewValue = null;
            }
            $this->idkel->ViewCustomAttributes = "";

            // kodepos
            $this->kodepos->ViewValue = $this->kodepos->CurrentValue;
            $this->kodepos->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // telpon
            $this->telpon->ViewValue = $this->telpon->CurrentValue;
            $this->telpon->ViewCustomAttributes = "";

            // hp
            $this->hp->ViewValue = $this->hp->CurrentValue;
            $this->hp->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // website
            $this->website->ViewValue = $this->website->CurrentValue;
            $this->website->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

            // ktp
            $this->ktp->ViewValue = $this->ktp->CurrentValue;
            $this->ktp->ViewCustomAttributes = "";

            // npwp
            $this->npwp->ViewValue = $this->npwp->CurrentValue;
            $this->npwp->ViewCustomAttributes = "";

            // limit_kredit_order
            $this->limit_kredit_order->ViewValue = $this->limit_kredit_order->CurrentValue;
            $this->limit_kredit_order->ViewValue = FormatCurrency($this->limit_kredit_order->ViewValue, 2, -2, -2, -2);
            $this->limit_kredit_order->ViewCustomAttributes = "";

            // jatuh_tempo_invoice
            $curVal = trim(strval($this->jatuh_tempo_invoice->CurrentValue));
            if ($curVal != "") {
                $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->lookupCacheOption($curVal);
                if ($this->jatuh_tempo_invoice->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jatuh_tempo_invoice->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jatuh_tempo_invoice->Lookup->renderViewRow($rswrk[0]);
                        $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->displayValue($arwrk);
                    } else {
                        $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->CurrentValue;
                    }
                }
            } else {
                $this->jatuh_tempo_invoice->ViewValue = null;
            }
            $this->jatuh_tempo_invoice->ViewCustomAttributes = "";

            // kodenpd
            $this->kodenpd->ViewValue = $this->kodenpd->CurrentValue;
            $this->kodenpd->ViewCustomAttributes = "";

            // klinik
            $this->klinik->ViewValue = $this->klinik->CurrentValue;
            $this->klinik->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // aktif
            if (strval($this->aktif->CurrentValue) != "") {
                $this->aktif->ViewValue = $this->aktif->optionCaption($this->aktif->CurrentValue);
            } else {
                $this->aktif->ViewValue = null;
            }
            $this->aktif->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // idtipecustomer
            $this->idtipecustomer->LinkCustomAttributes = "";
            $this->idtipecustomer->HrefValue = "";
            $this->idtipecustomer->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // jenis_usaha
            $this->jenis_usaha->LinkCustomAttributes = "";
            $this->jenis_usaha->HrefValue = "";
            $this->jenis_usaha->TooltipValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";
            $this->hp->TooltipValue = "";

            // klinik
            $this->klinik->LinkCustomAttributes = "";
            $this->klinik->HrefValue = "";
            $this->klinik->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "readonly";
            if (!$this->kode->Raw) {
                $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
            }
            $this->kode->EditValue = HtmlEncode($this->kode->CurrentValue);
            $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

            // idtipecustomer
            $this->idtipecustomer->EditAttrs["class"] = "form-control";
            $this->idtipecustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idtipecustomer->CurrentValue));
            if ($curVal != "") {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->lookupCacheOption($curVal);
            } else {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->Lookup !== null && is_array($this->idtipecustomer->Lookup->Options) ? $curVal : null;
            }
            if ($this->idtipecustomer->ViewValue !== null) { // Load from cache
                $this->idtipecustomer->EditValue = array_values($this->idtipecustomer->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idtipecustomer->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idtipecustomer->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idtipecustomer->EditValue = $arwrk;
            }
            $this->idtipecustomer->PlaceHolder = RemoveHtml($this->idtipecustomer->caption());

            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            if ($this->idpegawai->getSessionValue() != "") {
                $this->idpegawai->CurrentValue = GetForeignKeyValue($this->idpegawai->getSessionValue());
                $this->idpegawai->OldValue = $this->idpegawai->CurrentValue;
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
            } else {
                $curVal = trim(strval($this->idpegawai->CurrentValue));
                if ($curVal != "") {
                    $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
                } else {
                    $this->idpegawai->ViewValue = $this->idpegawai->Lookup !== null && is_array($this->idpegawai->Lookup->Options) ? $curVal : null;
                }
                if ($this->idpegawai->ViewValue !== null) { // Load from cache
                    $this->idpegawai->EditValue = array_values($this->idpegawai->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idpegawai->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->idpegawai->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idpegawai->EditValue = $arwrk;
                }
                $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());
            }

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // jenis_usaha
            $this->jenis_usaha->EditAttrs["class"] = "form-control";
            $this->jenis_usaha->EditCustomAttributes = "";
            if (!$this->jenis_usaha->Raw) {
                $this->jenis_usaha->CurrentValue = HtmlDecode($this->jenis_usaha->CurrentValue);
            }
            $this->jenis_usaha->EditValue = HtmlEncode($this->jenis_usaha->CurrentValue);
            $this->jenis_usaha->PlaceHolder = RemoveHtml($this->jenis_usaha->caption());

            // hp
            $this->hp->EditAttrs["class"] = "form-control";
            $this->hp->EditCustomAttributes = "";
            if (!$this->hp->Raw) {
                $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
            }
            $this->hp->EditValue = HtmlEncode($this->hp->CurrentValue);
            $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

            // klinik
            $this->klinik->EditAttrs["class"] = "form-control";
            $this->klinik->EditCustomAttributes = "";
            if (!$this->klinik->Raw) {
                $this->klinik->CurrentValue = HtmlDecode($this->klinik->CurrentValue);
            }
            $this->klinik->EditValue = HtmlEncode($this->klinik->CurrentValue);
            $this->klinik->PlaceHolder = RemoveHtml($this->klinik->caption());

            // Add refer script

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";

            // idtipecustomer
            $this->idtipecustomer->LinkCustomAttributes = "";
            $this->idtipecustomer->HrefValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // jenis_usaha
            $this->jenis_usaha->LinkCustomAttributes = "";
            $this->jenis_usaha->HrefValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";

            // klinik
            $this->klinik->LinkCustomAttributes = "";
            $this->klinik->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "readonly";
            $this->kode->EditValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // idtipecustomer
            $this->idtipecustomer->EditAttrs["class"] = "form-control";
            $this->idtipecustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idtipecustomer->CurrentValue));
            if ($curVal != "") {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->lookupCacheOption($curVal);
            } else {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->Lookup !== null && is_array($this->idtipecustomer->Lookup->Options) ? $curVal : null;
            }
            if ($this->idtipecustomer->ViewValue !== null) { // Load from cache
                $this->idtipecustomer->EditValue = array_values($this->idtipecustomer->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idtipecustomer->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idtipecustomer->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idtipecustomer->EditValue = $arwrk;
            }
            $this->idtipecustomer->PlaceHolder = RemoveHtml($this->idtipecustomer->caption());

            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            if ($this->idpegawai->getSessionValue() != "") {
                $this->idpegawai->CurrentValue = GetForeignKeyValue($this->idpegawai->getSessionValue());
                $this->idpegawai->OldValue = $this->idpegawai->CurrentValue;
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
            } else {
                $curVal = trim(strval($this->idpegawai->CurrentValue));
                if ($curVal != "") {
                    $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
                } else {
                    $this->idpegawai->ViewValue = $this->idpegawai->Lookup !== null && is_array($this->idpegawai->Lookup->Options) ? $curVal : null;
                }
                if ($this->idpegawai->ViewValue !== null) { // Load from cache
                    $this->idpegawai->EditValue = array_values($this->idpegawai->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idpegawai->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->idpegawai->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idpegawai->EditValue = $arwrk;
                }
                $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());
            }

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // jenis_usaha
            $this->jenis_usaha->EditAttrs["class"] = "form-control";
            $this->jenis_usaha->EditCustomAttributes = "";
            if (!$this->jenis_usaha->Raw) {
                $this->jenis_usaha->CurrentValue = HtmlDecode($this->jenis_usaha->CurrentValue);
            }
            $this->jenis_usaha->EditValue = HtmlEncode($this->jenis_usaha->CurrentValue);
            $this->jenis_usaha->PlaceHolder = RemoveHtml($this->jenis_usaha->caption());

            // hp
            $this->hp->EditAttrs["class"] = "form-control";
            $this->hp->EditCustomAttributes = "";
            if (!$this->hp->Raw) {
                $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
            }
            $this->hp->EditValue = HtmlEncode($this->hp->CurrentValue);
            $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

            // klinik
            $this->klinik->EditAttrs["class"] = "form-control";
            $this->klinik->EditCustomAttributes = "";
            if (!$this->klinik->Raw) {
                $this->klinik->CurrentValue = HtmlDecode($this->klinik->CurrentValue);
            }
            $this->klinik->EditValue = HtmlEncode($this->klinik->CurrentValue);
            $this->klinik->PlaceHolder = RemoveHtml($this->klinik->caption());

            // Edit refer script

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // idtipecustomer
            $this->idtipecustomer->LinkCustomAttributes = "";
            $this->idtipecustomer->HrefValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // jenis_usaha
            $this->jenis_usaha->LinkCustomAttributes = "";
            $this->jenis_usaha->HrefValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";

            // klinik
            $this->klinik->LinkCustomAttributes = "";
            $this->klinik->HrefValue = "";
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
        if ($this->kode->Required) {
            if (!$this->kode->IsDetailKey && EmptyValue($this->kode->FormValue)) {
                $this->kode->addErrorMessage(str_replace("%s", $this->kode->caption(), $this->kode->RequiredErrorMessage));
            }
        }
        if ($this->idtipecustomer->Required) {
            if (!$this->idtipecustomer->IsDetailKey && EmptyValue($this->idtipecustomer->FormValue)) {
                $this->idtipecustomer->addErrorMessage(str_replace("%s", $this->idtipecustomer->caption(), $this->idtipecustomer->RequiredErrorMessage));
            }
        }
        if ($this->idpegawai->Required) {
            if (!$this->idpegawai->IsDetailKey && EmptyValue($this->idpegawai->FormValue)) {
                $this->idpegawai->addErrorMessage(str_replace("%s", $this->idpegawai->caption(), $this->idpegawai->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->jenis_usaha->Required) {
            if (!$this->jenis_usaha->IsDetailKey && EmptyValue($this->jenis_usaha->FormValue)) {
                $this->jenis_usaha->addErrorMessage(str_replace("%s", $this->jenis_usaha->caption(), $this->jenis_usaha->RequiredErrorMessage));
            }
        }
        if ($this->hp->Required) {
            if (!$this->hp->IsDetailKey && EmptyValue($this->hp->FormValue)) {
                $this->hp->addErrorMessage(str_replace("%s", $this->hp->caption(), $this->hp->RequiredErrorMessage));
            }
        }
        if (!CheckByRegEx($this->hp->FormValue, "/^(62)8[1-9][0-9]{7,11}$/")) {
            $this->hp->addErrorMessage($this->hp->getErrorMessage(false));
        }
        if ($this->klinik->Required) {
            if (!$this->klinik->IsDetailKey && EmptyValue($this->klinik->FormValue)) {
                $this->klinik->addErrorMessage(str_replace("%s", $this->klinik->caption(), $this->klinik->RequiredErrorMessage));
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
        if ($this->kode->CurrentValue != "") { // Check field with unique index
            $filterChk = "(`kode` = '" . AdjustSql($this->kode->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->kode->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->kode->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
        if ($this->hp->CurrentValue != "") { // Check field with unique index
            $filterChk = "(`hp` = '" . AdjustSql($this->hp->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->hp->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->hp->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
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

            // idtipecustomer
            $this->idtipecustomer->setDbValueDef($rsnew, $this->idtipecustomer->CurrentValue, 0, $this->idtipecustomer->ReadOnly);

            // idpegawai
            if ($this->idpegawai->getSessionValue() != "") {
                $this->idpegawai->ReadOnly = true;
            }
            $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, 0, $this->idpegawai->ReadOnly);

            // nama
            $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

            // jenis_usaha
            $this->jenis_usaha->setDbValueDef($rsnew, $this->jenis_usaha->CurrentValue, null, $this->jenis_usaha->ReadOnly);

            // hp
            $this->hp->setDbValueDef($rsnew, $this->hp->CurrentValue, "", $this->hp->ReadOnly);

            // klinik
            $this->klinik->setDbValueDef($rsnew, $this->klinik->CurrentValue, null, $this->klinik->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
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

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $masterFilter = $this->sqlMasterFilter_pegawai();
            if (strval($this->idpegawai->CurrentValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($this->idpegawai->CurrentValue, "DB"), $masterFilter);
            } else {
                $masterFilter = "";
            }
            if ($masterFilter != "") {
                $rsmaster = Container("pegawai")->loadRs($masterFilter)->fetch(\PDO::FETCH_ASSOC);
                $masterRecordExists = $rsmaster !== false;
                $validMasterKey = true;
                if ($masterRecordExists) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['id']);
                } elseif ($this->getCurrentMasterTable() == "pegawai") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
            }
        }

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "pegawai") {
            $this->idpegawai->CurrentValue = $this->idpegawai->getSessionValue();
        }
        if ($this->kode->CurrentValue != "") { // Check field with unique index
            $filter = "(`kode` = '" . AdjustSql($this->kode->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->kode->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->kode->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        if ($this->hp->CurrentValue != "") { // Check field with unique index
            $filter = "(`hp` = '" . AdjustSql($this->hp->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->hp->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->hp->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // kode
        $this->kode->setDbValueDef($rsnew, $this->kode->CurrentValue, "", false);

        // idtipecustomer
        $this->idtipecustomer->setDbValueDef($rsnew, $this->idtipecustomer->CurrentValue, 0, false);

        // idpegawai
        $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, 0, false);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", false);

        // jenis_usaha
        $this->jenis_usaha->setDbValueDef($rsnew, $this->jenis_usaha->CurrentValue, null, false);

        // hp
        $this->hp->setDbValueDef($rsnew, $this->hp->CurrentValue, "", false);

        // klinik
        $this->klinik->setDbValueDef($rsnew, $this->klinik->CurrentValue, null, false);

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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "pegawai") {
            $masterTbl = Container("pegawai");
            $this->idpegawai->Visible = false;
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
                case "x_idtipecustomer":
                    break;
                case "x_idpegawai":
                    break;
                case "x_idprov":
                    break;
                case "x_idkab":
                    break;
                case "x_idkec":
                    break;
                case "x_idkel":
                    break;
                case "x_jatuh_tempo_invoice":
                    break;
                case "x_aktif":
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
        echo "
        <style>
        	.ew-list-other-options .ew-add-edit-option {
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
