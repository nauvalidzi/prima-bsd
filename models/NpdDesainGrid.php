<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdDesainGrid extends NpdDesain
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_desain';

    // Page object name
    public $PageObjName = "NpdDesainGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpd_desaingrid";
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

        // Table object (npd_desain)
        if (!isset($GLOBALS["npd_desain"]) || get_class($GLOBALS["npd_desain"]) == PROJECT_NAMESPACE . "npd_desain") {
            $GLOBALS["npd_desain"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        $this->AddUrl = "NpdDesainAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_desain');
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
                $doc = new $class(Container("npd_desain"));
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
        $this->idnpd->setVisibility();
        $this->idcustomer->setVisibility();
        $this->status->setVisibility();
        $this->tanggal_terima->setVisibility();
        $this->tanggal_submit->setVisibility();
        $this->nama_produk->setVisibility();
        $this->klaim_bahan->setVisibility();
        $this->campaign_produk->setVisibility();
        $this->konsep->setVisibility();
        $this->tema_warna->setVisibility();
        $this->no_notifikasi->setVisibility();
        $this->jenis_kemasan->setVisibility();
        $this->posisi_label->setVisibility();
        $this->bahan_label->setVisibility();
        $this->draft_layout->setVisibility();
        $this->keterangan->Visible = false;
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
        if ($CurrentForm->hasValue("x_idnpd") && $CurrentForm->hasValue("o_idnpd") && $this->idnpd->CurrentValue != $this->idnpd->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idcustomer") && $CurrentForm->hasValue("o_idcustomer") && $this->idcustomer->CurrentValue != $this->idcustomer->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status") && $CurrentForm->hasValue("o_status") && $this->status->CurrentValue != $this->status->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_tanggal_terima") && $CurrentForm->hasValue("o_tanggal_terima") && $this->tanggal_terima->CurrentValue != $this->tanggal_terima->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_tanggal_submit") && $CurrentForm->hasValue("o_tanggal_submit") && $this->tanggal_submit->CurrentValue != $this->tanggal_submit->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_nama_produk") && $CurrentForm->hasValue("o_nama_produk") && $this->nama_produk->CurrentValue != $this->nama_produk->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_klaim_bahan") && $CurrentForm->hasValue("o_klaim_bahan") && $this->klaim_bahan->CurrentValue != $this->klaim_bahan->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_campaign_produk") && $CurrentForm->hasValue("o_campaign_produk") && $this->campaign_produk->CurrentValue != $this->campaign_produk->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_konsep") && $CurrentForm->hasValue("o_konsep") && $this->konsep->CurrentValue != $this->konsep->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_tema_warna") && $CurrentForm->hasValue("o_tema_warna") && $this->tema_warna->CurrentValue != $this->tema_warna->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_no_notifikasi") && $CurrentForm->hasValue("o_no_notifikasi") && $this->no_notifikasi->CurrentValue != $this->no_notifikasi->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_jenis_kemasan") && $CurrentForm->hasValue("o_jenis_kemasan") && $this->jenis_kemasan->CurrentValue != $this->jenis_kemasan->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_posisi_label") && $CurrentForm->hasValue("o_posisi_label") && $this->posisi_label->CurrentValue != $this->posisi_label->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bahan_label") && $CurrentForm->hasValue("o_bahan_label") && $this->bahan_label->CurrentValue != $this->bahan_label->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_draft_layout") && $CurrentForm->hasValue("o_draft_layout") && $this->draft_layout->CurrentValue != $this->draft_layout->OldValue) {
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
        $this->idnpd->clearErrorMessage();
        $this->idcustomer->clearErrorMessage();
        $this->status->clearErrorMessage();
        $this->tanggal_terima->clearErrorMessage();
        $this->tanggal_submit->clearErrorMessage();
        $this->nama_produk->clearErrorMessage();
        $this->klaim_bahan->clearErrorMessage();
        $this->campaign_produk->clearErrorMessage();
        $this->konsep->clearErrorMessage();
        $this->tema_warna->clearErrorMessage();
        $this->no_notifikasi->clearErrorMessage();
        $this->jenis_kemasan->clearErrorMessage();
        $this->posisi_label->clearErrorMessage();
        $this->bahan_label->clearErrorMessage();
        $this->draft_layout->clearErrorMessage();
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
                if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        if ($this->CurrentMode == "view") { // View mode
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
                $item->Visible = false;
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
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->tanggal_terima->CurrentValue = null;
        $this->tanggal_terima->OldValue = $this->tanggal_terima->CurrentValue;
        $this->tanggal_submit->CurrentValue = null;
        $this->tanggal_submit->OldValue = $this->tanggal_submit->CurrentValue;
        $this->nama_produk->CurrentValue = null;
        $this->nama_produk->OldValue = $this->nama_produk->CurrentValue;
        $this->klaim_bahan->CurrentValue = null;
        $this->klaim_bahan->OldValue = $this->klaim_bahan->CurrentValue;
        $this->campaign_produk->CurrentValue = null;
        $this->campaign_produk->OldValue = $this->campaign_produk->CurrentValue;
        $this->konsep->CurrentValue = null;
        $this->konsep->OldValue = $this->konsep->CurrentValue;
        $this->tema_warna->CurrentValue = null;
        $this->tema_warna->OldValue = $this->tema_warna->CurrentValue;
        $this->no_notifikasi->CurrentValue = null;
        $this->no_notifikasi->OldValue = $this->no_notifikasi->CurrentValue;
        $this->jenis_kemasan->CurrentValue = null;
        $this->jenis_kemasan->OldValue = $this->jenis_kemasan->CurrentValue;
        $this->posisi_label->CurrentValue = null;
        $this->posisi_label->OldValue = $this->posisi_label->CurrentValue;
        $this->bahan_label->CurrentValue = null;
        $this->bahan_label->OldValue = $this->bahan_label->CurrentValue;
        $this->draft_layout->CurrentValue = null;
        $this->draft_layout->OldValue = $this->draft_layout->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
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

        // Check field name 'idcustomer' first before field var 'x_idcustomer'
        $val = $CurrentForm->hasValue("idcustomer") ? $CurrentForm->getValue("idcustomer") : $CurrentForm->getValue("x_idcustomer");
        if (!$this->idcustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idcustomer->Visible = false; // Disable update for API request
            } else {
                $this->idcustomer->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idcustomer")) {
            $this->idcustomer->setOldValue($CurrentForm->getValue("o_idcustomer"));
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

        // Check field name 'tanggal_terima' first before field var 'x_tanggal_terima'
        $val = $CurrentForm->hasValue("tanggal_terima") ? $CurrentForm->getValue("tanggal_terima") : $CurrentForm->getValue("x_tanggal_terima");
        if (!$this->tanggal_terima->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_terima->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_terima->setFormValue($val);
            }
            $this->tanggal_terima->CurrentValue = UnFormatDateTime($this->tanggal_terima->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_tanggal_terima")) {
            $this->tanggal_terima->setOldValue($CurrentForm->getValue("o_tanggal_terima"));
        }

        // Check field name 'tanggal_submit' first before field var 'x_tanggal_submit'
        $val = $CurrentForm->hasValue("tanggal_submit") ? $CurrentForm->getValue("tanggal_submit") : $CurrentForm->getValue("x_tanggal_submit");
        if (!$this->tanggal_submit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_submit->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_submit->setFormValue($val);
            }
            $this->tanggal_submit->CurrentValue = UnFormatDateTime($this->tanggal_submit->CurrentValue, 0);
        }
        if ($CurrentForm->hasValue("o_tanggal_submit")) {
            $this->tanggal_submit->setOldValue($CurrentForm->getValue("o_tanggal_submit"));
        }

        // Check field name 'nama_produk' first before field var 'x_nama_produk'
        $val = $CurrentForm->hasValue("nama_produk") ? $CurrentForm->getValue("nama_produk") : $CurrentForm->getValue("x_nama_produk");
        if (!$this->nama_produk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_produk->Visible = false; // Disable update for API request
            } else {
                $this->nama_produk->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_nama_produk")) {
            $this->nama_produk->setOldValue($CurrentForm->getValue("o_nama_produk"));
        }

        // Check field name 'klaim_bahan' first before field var 'x_klaim_bahan'
        $val = $CurrentForm->hasValue("klaim_bahan") ? $CurrentForm->getValue("klaim_bahan") : $CurrentForm->getValue("x_klaim_bahan");
        if (!$this->klaim_bahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->klaim_bahan->Visible = false; // Disable update for API request
            } else {
                $this->klaim_bahan->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_klaim_bahan")) {
            $this->klaim_bahan->setOldValue($CurrentForm->getValue("o_klaim_bahan"));
        }

        // Check field name 'campaign_produk' first before field var 'x_campaign_produk'
        $val = $CurrentForm->hasValue("campaign_produk") ? $CurrentForm->getValue("campaign_produk") : $CurrentForm->getValue("x_campaign_produk");
        if (!$this->campaign_produk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->campaign_produk->Visible = false; // Disable update for API request
            } else {
                $this->campaign_produk->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_campaign_produk")) {
            $this->campaign_produk->setOldValue($CurrentForm->getValue("o_campaign_produk"));
        }

        // Check field name 'konsep' first before field var 'x_konsep'
        $val = $CurrentForm->hasValue("konsep") ? $CurrentForm->getValue("konsep") : $CurrentForm->getValue("x_konsep");
        if (!$this->konsep->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->konsep->Visible = false; // Disable update for API request
            } else {
                $this->konsep->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_konsep")) {
            $this->konsep->setOldValue($CurrentForm->getValue("o_konsep"));
        }

        // Check field name 'tema_warna' first before field var 'x_tema_warna'
        $val = $CurrentForm->hasValue("tema_warna") ? $CurrentForm->getValue("tema_warna") : $CurrentForm->getValue("x_tema_warna");
        if (!$this->tema_warna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tema_warna->Visible = false; // Disable update for API request
            } else {
                $this->tema_warna->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_tema_warna")) {
            $this->tema_warna->setOldValue($CurrentForm->getValue("o_tema_warna"));
        }

        // Check field name 'no_notifikasi' first before field var 'x_no_notifikasi'
        $val = $CurrentForm->hasValue("no_notifikasi") ? $CurrentForm->getValue("no_notifikasi") : $CurrentForm->getValue("x_no_notifikasi");
        if (!$this->no_notifikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_notifikasi->Visible = false; // Disable update for API request
            } else {
                $this->no_notifikasi->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_no_notifikasi")) {
            $this->no_notifikasi->setOldValue($CurrentForm->getValue("o_no_notifikasi"));
        }

        // Check field name 'jenis_kemasan' first before field var 'x_jenis_kemasan'
        $val = $CurrentForm->hasValue("jenis_kemasan") ? $CurrentForm->getValue("jenis_kemasan") : $CurrentForm->getValue("x_jenis_kemasan");
        if (!$this->jenis_kemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenis_kemasan->Visible = false; // Disable update for API request
            } else {
                $this->jenis_kemasan->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_jenis_kemasan")) {
            $this->jenis_kemasan->setOldValue($CurrentForm->getValue("o_jenis_kemasan"));
        }

        // Check field name 'posisi_label' first before field var 'x_posisi_label'
        $val = $CurrentForm->hasValue("posisi_label") ? $CurrentForm->getValue("posisi_label") : $CurrentForm->getValue("x_posisi_label");
        if (!$this->posisi_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->posisi_label->Visible = false; // Disable update for API request
            } else {
                $this->posisi_label->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_posisi_label")) {
            $this->posisi_label->setOldValue($CurrentForm->getValue("o_posisi_label"));
        }

        // Check field name 'bahan_label' first before field var 'x_bahan_label'
        $val = $CurrentForm->hasValue("bahan_label") ? $CurrentForm->getValue("bahan_label") : $CurrentForm->getValue("x_bahan_label");
        if (!$this->bahan_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahan_label->Visible = false; // Disable update for API request
            } else {
                $this->bahan_label->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_bahan_label")) {
            $this->bahan_label->setOldValue($CurrentForm->getValue("o_bahan_label"));
        }

        // Check field name 'draft_layout' first before field var 'x_draft_layout'
        $val = $CurrentForm->hasValue("draft_layout") ? $CurrentForm->getValue("draft_layout") : $CurrentForm->getValue("x_draft_layout");
        if (!$this->draft_layout->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->draft_layout->Visible = false; // Disable update for API request
            } else {
                $this->draft_layout->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_draft_layout")) {
            $this->draft_layout->setOldValue($CurrentForm->getValue("o_draft_layout"));
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
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->tanggal_terima->CurrentValue = $this->tanggal_terima->FormValue;
        $this->tanggal_terima->CurrentValue = UnFormatDateTime($this->tanggal_terima->CurrentValue, 0);
        $this->tanggal_submit->CurrentValue = $this->tanggal_submit->FormValue;
        $this->tanggal_submit->CurrentValue = UnFormatDateTime($this->tanggal_submit->CurrentValue, 0);
        $this->nama_produk->CurrentValue = $this->nama_produk->FormValue;
        $this->klaim_bahan->CurrentValue = $this->klaim_bahan->FormValue;
        $this->campaign_produk->CurrentValue = $this->campaign_produk->FormValue;
        $this->konsep->CurrentValue = $this->konsep->FormValue;
        $this->tema_warna->CurrentValue = $this->tema_warna->FormValue;
        $this->no_notifikasi->CurrentValue = $this->no_notifikasi->FormValue;
        $this->jenis_kemasan->CurrentValue = $this->jenis_kemasan->FormValue;
        $this->posisi_label->CurrentValue = $this->posisi_label->FormValue;
        $this->bahan_label->CurrentValue = $this->bahan_label->FormValue;
        $this->draft_layout->CurrentValue = $this->draft_layout->FormValue;
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
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->status->setDbValue($row['status']);
        $this->tanggal_terima->setDbValue($row['tanggal_terima']);
        $this->tanggal_submit->setDbValue($row['tanggal_submit']);
        $this->nama_produk->setDbValue($row['nama_produk']);
        $this->klaim_bahan->setDbValue($row['klaim_bahan']);
        $this->campaign_produk->setDbValue($row['campaign_produk']);
        $this->konsep->setDbValue($row['konsep']);
        $this->tema_warna->setDbValue($row['tema_warna']);
        $this->no_notifikasi->setDbValue($row['no_notifikasi']);
        $this->jenis_kemasan->setDbValue($row['jenis_kemasan']);
        $this->posisi_label->setDbValue($row['posisi_label']);
        $this->bahan_label->setDbValue($row['bahan_label']);
        $this->draft_layout->setDbValue($row['draft_layout']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['tanggal_terima'] = $this->tanggal_terima->CurrentValue;
        $row['tanggal_submit'] = $this->tanggal_submit->CurrentValue;
        $row['nama_produk'] = $this->nama_produk->CurrentValue;
        $row['klaim_bahan'] = $this->klaim_bahan->CurrentValue;
        $row['campaign_produk'] = $this->campaign_produk->CurrentValue;
        $row['konsep'] = $this->konsep->CurrentValue;
        $row['tema_warna'] = $this->tema_warna->CurrentValue;
        $row['no_notifikasi'] = $this->no_notifikasi->CurrentValue;
        $row['jenis_kemasan'] = $this->jenis_kemasan->CurrentValue;
        $row['posisi_label'] = $this->posisi_label->CurrentValue;
        $row['bahan_label'] = $this->bahan_label->CurrentValue;
        $row['draft_layout'] = $this->draft_layout->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
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

        // idcustomer

        // status

        // tanggal_terima

        // tanggal_submit

        // nama_produk

        // klaim_bahan

        // campaign_produk

        // konsep

        // tema_warna

        // no_notifikasi

        // jenis_kemasan

        // posisi_label

        // bahan_label

        // draft_layout

        // keterangan

        // created_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // idnpd
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";

            // idcustomer
            $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
            $this->idcustomer->ViewValue = FormatNumber($this->idcustomer->ViewValue, 0, -2, -2, -2);
            $this->idcustomer->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // tanggal_terima
            $this->tanggal_terima->ViewValue = $this->tanggal_terima->CurrentValue;
            $this->tanggal_terima->ViewValue = FormatDateTime($this->tanggal_terima->ViewValue, 0);
            $this->tanggal_terima->ViewCustomAttributes = "";

            // tanggal_submit
            $this->tanggal_submit->ViewValue = $this->tanggal_submit->CurrentValue;
            $this->tanggal_submit->ViewValue = FormatDateTime($this->tanggal_submit->ViewValue, 0);
            $this->tanggal_submit->ViewCustomAttributes = "";

            // nama_produk
            $this->nama_produk->ViewValue = $this->nama_produk->CurrentValue;
            $this->nama_produk->ViewCustomAttributes = "";

            // klaim_bahan
            $this->klaim_bahan->ViewValue = $this->klaim_bahan->CurrentValue;
            $this->klaim_bahan->ViewCustomAttributes = "";

            // campaign_produk
            $this->campaign_produk->ViewValue = $this->campaign_produk->CurrentValue;
            $this->campaign_produk->ViewCustomAttributes = "";

            // konsep
            $this->konsep->ViewValue = $this->konsep->CurrentValue;
            $this->konsep->ViewCustomAttributes = "";

            // tema_warna
            $this->tema_warna->ViewValue = $this->tema_warna->CurrentValue;
            $this->tema_warna->ViewCustomAttributes = "";

            // no_notifikasi
            $this->no_notifikasi->ViewValue = $this->no_notifikasi->CurrentValue;
            $this->no_notifikasi->ViewCustomAttributes = "";

            // jenis_kemasan
            $this->jenis_kemasan->ViewValue = $this->jenis_kemasan->CurrentValue;
            $this->jenis_kemasan->ViewCustomAttributes = "";

            // posisi_label
            $this->posisi_label->ViewValue = $this->posisi_label->CurrentValue;
            $this->posisi_label->ViewCustomAttributes = "";

            // bahan_label
            $this->bahan_label->ViewValue = $this->bahan_label->CurrentValue;
            $this->bahan_label->ViewCustomAttributes = "";

            // draft_layout
            $this->draft_layout->ViewValue = $this->draft_layout->CurrentValue;
            $this->draft_layout->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // tanggal_terima
            $this->tanggal_terima->LinkCustomAttributes = "";
            $this->tanggal_terima->HrefValue = "";
            $this->tanggal_terima->TooltipValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";
            $this->tanggal_submit->TooltipValue = "";

            // nama_produk
            $this->nama_produk->LinkCustomAttributes = "";
            $this->nama_produk->HrefValue = "";
            $this->nama_produk->TooltipValue = "";

            // klaim_bahan
            $this->klaim_bahan->LinkCustomAttributes = "";
            $this->klaim_bahan->HrefValue = "";
            $this->klaim_bahan->TooltipValue = "";

            // campaign_produk
            $this->campaign_produk->LinkCustomAttributes = "";
            $this->campaign_produk->HrefValue = "";
            $this->campaign_produk->TooltipValue = "";

            // konsep
            $this->konsep->LinkCustomAttributes = "";
            $this->konsep->HrefValue = "";
            $this->konsep->TooltipValue = "";

            // tema_warna
            $this->tema_warna->LinkCustomAttributes = "";
            $this->tema_warna->HrefValue = "";
            $this->tema_warna->TooltipValue = "";

            // no_notifikasi
            $this->no_notifikasi->LinkCustomAttributes = "";
            $this->no_notifikasi->HrefValue = "";
            $this->no_notifikasi->TooltipValue = "";

            // jenis_kemasan
            $this->jenis_kemasan->LinkCustomAttributes = "";
            $this->jenis_kemasan->HrefValue = "";
            $this->jenis_kemasan->TooltipValue = "";

            // posisi_label
            $this->posisi_label->LinkCustomAttributes = "";
            $this->posisi_label->HrefValue = "";
            $this->posisi_label->TooltipValue = "";

            // bahan_label
            $this->bahan_label->LinkCustomAttributes = "";
            $this->bahan_label->HrefValue = "";
            $this->bahan_label->TooltipValue = "";

            // draft_layout
            $this->draft_layout->LinkCustomAttributes = "";
            $this->draft_layout->HrefValue = "";
            $this->draft_layout->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
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

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $this->idcustomer->EditValue = HtmlEncode($this->idcustomer->CurrentValue);
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // tanggal_terima
            $this->tanggal_terima->EditAttrs["class"] = "form-control";
            $this->tanggal_terima->EditCustomAttributes = "";
            $this->tanggal_terima->EditValue = HtmlEncode(FormatDateTime($this->tanggal_terima->CurrentValue, 8));
            $this->tanggal_terima->PlaceHolder = RemoveHtml($this->tanggal_terima->caption());

            // tanggal_submit
            $this->tanggal_submit->EditAttrs["class"] = "form-control";
            $this->tanggal_submit->EditCustomAttributes = "";
            $this->tanggal_submit->EditValue = HtmlEncode(FormatDateTime($this->tanggal_submit->CurrentValue, 8));
            $this->tanggal_submit->PlaceHolder = RemoveHtml($this->tanggal_submit->caption());

            // nama_produk
            $this->nama_produk->EditAttrs["class"] = "form-control";
            $this->nama_produk->EditCustomAttributes = "";
            if (!$this->nama_produk->Raw) {
                $this->nama_produk->CurrentValue = HtmlDecode($this->nama_produk->CurrentValue);
            }
            $this->nama_produk->EditValue = HtmlEncode($this->nama_produk->CurrentValue);
            $this->nama_produk->PlaceHolder = RemoveHtml($this->nama_produk->caption());

            // klaim_bahan
            $this->klaim_bahan->EditAttrs["class"] = "form-control";
            $this->klaim_bahan->EditCustomAttributes = "";
            if (!$this->klaim_bahan->Raw) {
                $this->klaim_bahan->CurrentValue = HtmlDecode($this->klaim_bahan->CurrentValue);
            }
            $this->klaim_bahan->EditValue = HtmlEncode($this->klaim_bahan->CurrentValue);
            $this->klaim_bahan->PlaceHolder = RemoveHtml($this->klaim_bahan->caption());

            // campaign_produk
            $this->campaign_produk->EditAttrs["class"] = "form-control";
            $this->campaign_produk->EditCustomAttributes = "";
            if (!$this->campaign_produk->Raw) {
                $this->campaign_produk->CurrentValue = HtmlDecode($this->campaign_produk->CurrentValue);
            }
            $this->campaign_produk->EditValue = HtmlEncode($this->campaign_produk->CurrentValue);
            $this->campaign_produk->PlaceHolder = RemoveHtml($this->campaign_produk->caption());

            // konsep
            $this->konsep->EditAttrs["class"] = "form-control";
            $this->konsep->EditCustomAttributes = "";
            if (!$this->konsep->Raw) {
                $this->konsep->CurrentValue = HtmlDecode($this->konsep->CurrentValue);
            }
            $this->konsep->EditValue = HtmlEncode($this->konsep->CurrentValue);
            $this->konsep->PlaceHolder = RemoveHtml($this->konsep->caption());

            // tema_warna
            $this->tema_warna->EditAttrs["class"] = "form-control";
            $this->tema_warna->EditCustomAttributes = "";
            if (!$this->tema_warna->Raw) {
                $this->tema_warna->CurrentValue = HtmlDecode($this->tema_warna->CurrentValue);
            }
            $this->tema_warna->EditValue = HtmlEncode($this->tema_warna->CurrentValue);
            $this->tema_warna->PlaceHolder = RemoveHtml($this->tema_warna->caption());

            // no_notifikasi
            $this->no_notifikasi->EditAttrs["class"] = "form-control";
            $this->no_notifikasi->EditCustomAttributes = "";
            if (!$this->no_notifikasi->Raw) {
                $this->no_notifikasi->CurrentValue = HtmlDecode($this->no_notifikasi->CurrentValue);
            }
            $this->no_notifikasi->EditValue = HtmlEncode($this->no_notifikasi->CurrentValue);
            $this->no_notifikasi->PlaceHolder = RemoveHtml($this->no_notifikasi->caption());

            // jenis_kemasan
            $this->jenis_kemasan->EditAttrs["class"] = "form-control";
            $this->jenis_kemasan->EditCustomAttributes = "";
            if (!$this->jenis_kemasan->Raw) {
                $this->jenis_kemasan->CurrentValue = HtmlDecode($this->jenis_kemasan->CurrentValue);
            }
            $this->jenis_kemasan->EditValue = HtmlEncode($this->jenis_kemasan->CurrentValue);
            $this->jenis_kemasan->PlaceHolder = RemoveHtml($this->jenis_kemasan->caption());

            // posisi_label
            $this->posisi_label->EditAttrs["class"] = "form-control";
            $this->posisi_label->EditCustomAttributes = "";
            if (!$this->posisi_label->Raw) {
                $this->posisi_label->CurrentValue = HtmlDecode($this->posisi_label->CurrentValue);
            }
            $this->posisi_label->EditValue = HtmlEncode($this->posisi_label->CurrentValue);
            $this->posisi_label->PlaceHolder = RemoveHtml($this->posisi_label->caption());

            // bahan_label
            $this->bahan_label->EditAttrs["class"] = "form-control";
            $this->bahan_label->EditCustomAttributes = "";
            if (!$this->bahan_label->Raw) {
                $this->bahan_label->CurrentValue = HtmlDecode($this->bahan_label->CurrentValue);
            }
            $this->bahan_label->EditValue = HtmlEncode($this->bahan_label->CurrentValue);
            $this->bahan_label->PlaceHolder = RemoveHtml($this->bahan_label->caption());

            // draft_layout
            $this->draft_layout->EditAttrs["class"] = "form-control";
            $this->draft_layout->EditCustomAttributes = "";
            if (!$this->draft_layout->Raw) {
                $this->draft_layout->CurrentValue = HtmlDecode($this->draft_layout->CurrentValue);
            }
            $this->draft_layout->EditValue = HtmlEncode($this->draft_layout->CurrentValue);
            $this->draft_layout->PlaceHolder = RemoveHtml($this->draft_layout->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // tanggal_terima
            $this->tanggal_terima->LinkCustomAttributes = "";
            $this->tanggal_terima->HrefValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";

            // nama_produk
            $this->nama_produk->LinkCustomAttributes = "";
            $this->nama_produk->HrefValue = "";

            // klaim_bahan
            $this->klaim_bahan->LinkCustomAttributes = "";
            $this->klaim_bahan->HrefValue = "";

            // campaign_produk
            $this->campaign_produk->LinkCustomAttributes = "";
            $this->campaign_produk->HrefValue = "";

            // konsep
            $this->konsep->LinkCustomAttributes = "";
            $this->konsep->HrefValue = "";

            // tema_warna
            $this->tema_warna->LinkCustomAttributes = "";
            $this->tema_warna->HrefValue = "";

            // no_notifikasi
            $this->no_notifikasi->LinkCustomAttributes = "";
            $this->no_notifikasi->HrefValue = "";

            // jenis_kemasan
            $this->jenis_kemasan->LinkCustomAttributes = "";
            $this->jenis_kemasan->HrefValue = "";

            // posisi_label
            $this->posisi_label->LinkCustomAttributes = "";
            $this->posisi_label->HrefValue = "";

            // bahan_label
            $this->bahan_label->LinkCustomAttributes = "";
            $this->bahan_label->HrefValue = "";

            // draft_layout
            $this->draft_layout->LinkCustomAttributes = "";
            $this->draft_layout->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $this->idcustomer->EditValue = HtmlEncode($this->idcustomer->CurrentValue);
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // tanggal_terima
            $this->tanggal_terima->EditAttrs["class"] = "form-control";
            $this->tanggal_terima->EditCustomAttributes = "";
            $this->tanggal_terima->EditValue = HtmlEncode(FormatDateTime($this->tanggal_terima->CurrentValue, 8));
            $this->tanggal_terima->PlaceHolder = RemoveHtml($this->tanggal_terima->caption());

            // tanggal_submit
            $this->tanggal_submit->EditAttrs["class"] = "form-control";
            $this->tanggal_submit->EditCustomAttributes = "";
            $this->tanggal_submit->EditValue = HtmlEncode(FormatDateTime($this->tanggal_submit->CurrentValue, 8));
            $this->tanggal_submit->PlaceHolder = RemoveHtml($this->tanggal_submit->caption());

            // nama_produk
            $this->nama_produk->EditAttrs["class"] = "form-control";
            $this->nama_produk->EditCustomAttributes = "";
            if (!$this->nama_produk->Raw) {
                $this->nama_produk->CurrentValue = HtmlDecode($this->nama_produk->CurrentValue);
            }
            $this->nama_produk->EditValue = HtmlEncode($this->nama_produk->CurrentValue);
            $this->nama_produk->PlaceHolder = RemoveHtml($this->nama_produk->caption());

            // klaim_bahan
            $this->klaim_bahan->EditAttrs["class"] = "form-control";
            $this->klaim_bahan->EditCustomAttributes = "";
            if (!$this->klaim_bahan->Raw) {
                $this->klaim_bahan->CurrentValue = HtmlDecode($this->klaim_bahan->CurrentValue);
            }
            $this->klaim_bahan->EditValue = HtmlEncode($this->klaim_bahan->CurrentValue);
            $this->klaim_bahan->PlaceHolder = RemoveHtml($this->klaim_bahan->caption());

            // campaign_produk
            $this->campaign_produk->EditAttrs["class"] = "form-control";
            $this->campaign_produk->EditCustomAttributes = "";
            if (!$this->campaign_produk->Raw) {
                $this->campaign_produk->CurrentValue = HtmlDecode($this->campaign_produk->CurrentValue);
            }
            $this->campaign_produk->EditValue = HtmlEncode($this->campaign_produk->CurrentValue);
            $this->campaign_produk->PlaceHolder = RemoveHtml($this->campaign_produk->caption());

            // konsep
            $this->konsep->EditAttrs["class"] = "form-control";
            $this->konsep->EditCustomAttributes = "";
            if (!$this->konsep->Raw) {
                $this->konsep->CurrentValue = HtmlDecode($this->konsep->CurrentValue);
            }
            $this->konsep->EditValue = HtmlEncode($this->konsep->CurrentValue);
            $this->konsep->PlaceHolder = RemoveHtml($this->konsep->caption());

            // tema_warna
            $this->tema_warna->EditAttrs["class"] = "form-control";
            $this->tema_warna->EditCustomAttributes = "";
            if (!$this->tema_warna->Raw) {
                $this->tema_warna->CurrentValue = HtmlDecode($this->tema_warna->CurrentValue);
            }
            $this->tema_warna->EditValue = HtmlEncode($this->tema_warna->CurrentValue);
            $this->tema_warna->PlaceHolder = RemoveHtml($this->tema_warna->caption());

            // no_notifikasi
            $this->no_notifikasi->EditAttrs["class"] = "form-control";
            $this->no_notifikasi->EditCustomAttributes = "";
            if (!$this->no_notifikasi->Raw) {
                $this->no_notifikasi->CurrentValue = HtmlDecode($this->no_notifikasi->CurrentValue);
            }
            $this->no_notifikasi->EditValue = HtmlEncode($this->no_notifikasi->CurrentValue);
            $this->no_notifikasi->PlaceHolder = RemoveHtml($this->no_notifikasi->caption());

            // jenis_kemasan
            $this->jenis_kemasan->EditAttrs["class"] = "form-control";
            $this->jenis_kemasan->EditCustomAttributes = "";
            if (!$this->jenis_kemasan->Raw) {
                $this->jenis_kemasan->CurrentValue = HtmlDecode($this->jenis_kemasan->CurrentValue);
            }
            $this->jenis_kemasan->EditValue = HtmlEncode($this->jenis_kemasan->CurrentValue);
            $this->jenis_kemasan->PlaceHolder = RemoveHtml($this->jenis_kemasan->caption());

            // posisi_label
            $this->posisi_label->EditAttrs["class"] = "form-control";
            $this->posisi_label->EditCustomAttributes = "";
            if (!$this->posisi_label->Raw) {
                $this->posisi_label->CurrentValue = HtmlDecode($this->posisi_label->CurrentValue);
            }
            $this->posisi_label->EditValue = HtmlEncode($this->posisi_label->CurrentValue);
            $this->posisi_label->PlaceHolder = RemoveHtml($this->posisi_label->caption());

            // bahan_label
            $this->bahan_label->EditAttrs["class"] = "form-control";
            $this->bahan_label->EditCustomAttributes = "";
            if (!$this->bahan_label->Raw) {
                $this->bahan_label->CurrentValue = HtmlDecode($this->bahan_label->CurrentValue);
            }
            $this->bahan_label->EditValue = HtmlEncode($this->bahan_label->CurrentValue);
            $this->bahan_label->PlaceHolder = RemoveHtml($this->bahan_label->caption());

            // draft_layout
            $this->draft_layout->EditAttrs["class"] = "form-control";
            $this->draft_layout->EditCustomAttributes = "";
            if (!$this->draft_layout->Raw) {
                $this->draft_layout->CurrentValue = HtmlDecode($this->draft_layout->CurrentValue);
            }
            $this->draft_layout->EditValue = HtmlEncode($this->draft_layout->CurrentValue);
            $this->draft_layout->PlaceHolder = RemoveHtml($this->draft_layout->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // Edit refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // tanggal_terima
            $this->tanggal_terima->LinkCustomAttributes = "";
            $this->tanggal_terima->HrefValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";

            // nama_produk
            $this->nama_produk->LinkCustomAttributes = "";
            $this->nama_produk->HrefValue = "";

            // klaim_bahan
            $this->klaim_bahan->LinkCustomAttributes = "";
            $this->klaim_bahan->HrefValue = "";

            // campaign_produk
            $this->campaign_produk->LinkCustomAttributes = "";
            $this->campaign_produk->HrefValue = "";

            // konsep
            $this->konsep->LinkCustomAttributes = "";
            $this->konsep->HrefValue = "";

            // tema_warna
            $this->tema_warna->LinkCustomAttributes = "";
            $this->tema_warna->HrefValue = "";

            // no_notifikasi
            $this->no_notifikasi->LinkCustomAttributes = "";
            $this->no_notifikasi->HrefValue = "";

            // jenis_kemasan
            $this->jenis_kemasan->LinkCustomAttributes = "";
            $this->jenis_kemasan->HrefValue = "";

            // posisi_label
            $this->posisi_label->LinkCustomAttributes = "";
            $this->posisi_label->HrefValue = "";

            // bahan_label
            $this->bahan_label->LinkCustomAttributes = "";
            $this->bahan_label->HrefValue = "";

            // draft_layout
            $this->draft_layout->LinkCustomAttributes = "";
            $this->draft_layout->HrefValue = "";

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
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idnpd->FormValue)) {
            $this->idnpd->addErrorMessage($this->idnpd->getErrorMessage(false));
        }
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idcustomer->FormValue)) {
            $this->idcustomer->addErrorMessage($this->idcustomer->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_terima->Required) {
            if (!$this->tanggal_terima->IsDetailKey && EmptyValue($this->tanggal_terima->FormValue)) {
                $this->tanggal_terima->addErrorMessage(str_replace("%s", $this->tanggal_terima->caption(), $this->tanggal_terima->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_terima->FormValue)) {
            $this->tanggal_terima->addErrorMessage($this->tanggal_terima->getErrorMessage(false));
        }
        if ($this->tanggal_submit->Required) {
            if (!$this->tanggal_submit->IsDetailKey && EmptyValue($this->tanggal_submit->FormValue)) {
                $this->tanggal_submit->addErrorMessage(str_replace("%s", $this->tanggal_submit->caption(), $this->tanggal_submit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_submit->FormValue)) {
            $this->tanggal_submit->addErrorMessage($this->tanggal_submit->getErrorMessage(false));
        }
        if ($this->nama_produk->Required) {
            if (!$this->nama_produk->IsDetailKey && EmptyValue($this->nama_produk->FormValue)) {
                $this->nama_produk->addErrorMessage(str_replace("%s", $this->nama_produk->caption(), $this->nama_produk->RequiredErrorMessage));
            }
        }
        if ($this->klaim_bahan->Required) {
            if (!$this->klaim_bahan->IsDetailKey && EmptyValue($this->klaim_bahan->FormValue)) {
                $this->klaim_bahan->addErrorMessage(str_replace("%s", $this->klaim_bahan->caption(), $this->klaim_bahan->RequiredErrorMessage));
            }
        }
        if ($this->campaign_produk->Required) {
            if (!$this->campaign_produk->IsDetailKey && EmptyValue($this->campaign_produk->FormValue)) {
                $this->campaign_produk->addErrorMessage(str_replace("%s", $this->campaign_produk->caption(), $this->campaign_produk->RequiredErrorMessage));
            }
        }
        if ($this->konsep->Required) {
            if (!$this->konsep->IsDetailKey && EmptyValue($this->konsep->FormValue)) {
                $this->konsep->addErrorMessage(str_replace("%s", $this->konsep->caption(), $this->konsep->RequiredErrorMessage));
            }
        }
        if ($this->tema_warna->Required) {
            if (!$this->tema_warna->IsDetailKey && EmptyValue($this->tema_warna->FormValue)) {
                $this->tema_warna->addErrorMessage(str_replace("%s", $this->tema_warna->caption(), $this->tema_warna->RequiredErrorMessage));
            }
        }
        if ($this->no_notifikasi->Required) {
            if (!$this->no_notifikasi->IsDetailKey && EmptyValue($this->no_notifikasi->FormValue)) {
                $this->no_notifikasi->addErrorMessage(str_replace("%s", $this->no_notifikasi->caption(), $this->no_notifikasi->RequiredErrorMessage));
            }
        }
        if ($this->jenis_kemasan->Required) {
            if (!$this->jenis_kemasan->IsDetailKey && EmptyValue($this->jenis_kemasan->FormValue)) {
                $this->jenis_kemasan->addErrorMessage(str_replace("%s", $this->jenis_kemasan->caption(), $this->jenis_kemasan->RequiredErrorMessage));
            }
        }
        if ($this->posisi_label->Required) {
            if (!$this->posisi_label->IsDetailKey && EmptyValue($this->posisi_label->FormValue)) {
                $this->posisi_label->addErrorMessage(str_replace("%s", $this->posisi_label->caption(), $this->posisi_label->RequiredErrorMessage));
            }
        }
        if ($this->bahan_label->Required) {
            if (!$this->bahan_label->IsDetailKey && EmptyValue($this->bahan_label->FormValue)) {
                $this->bahan_label->addErrorMessage(str_replace("%s", $this->bahan_label->caption(), $this->bahan_label->RequiredErrorMessage));
            }
        }
        if ($this->draft_layout->Required) {
            if (!$this->draft_layout->IsDetailKey && EmptyValue($this->draft_layout->FormValue)) {
                $this->draft_layout->addErrorMessage(str_replace("%s", $this->draft_layout->caption(), $this->draft_layout->RequiredErrorMessage));
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

            // idnpd
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->ReadOnly = true;
            }
            $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, null, $this->idnpd->ReadOnly);

            // idcustomer
            $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, null, $this->idcustomer->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

            // tanggal_terima
            $this->tanggal_terima->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_terima->CurrentValue, 0), null, $this->tanggal_terima->ReadOnly);

            // tanggal_submit
            $this->tanggal_submit->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_submit->CurrentValue, 0), null, $this->tanggal_submit->ReadOnly);

            // nama_produk
            $this->nama_produk->setDbValueDef($rsnew, $this->nama_produk->CurrentValue, null, $this->nama_produk->ReadOnly);

            // klaim_bahan
            $this->klaim_bahan->setDbValueDef($rsnew, $this->klaim_bahan->CurrentValue, null, $this->klaim_bahan->ReadOnly);

            // campaign_produk
            $this->campaign_produk->setDbValueDef($rsnew, $this->campaign_produk->CurrentValue, null, $this->campaign_produk->ReadOnly);

            // konsep
            $this->konsep->setDbValueDef($rsnew, $this->konsep->CurrentValue, null, $this->konsep->ReadOnly);

            // tema_warna
            $this->tema_warna->setDbValueDef($rsnew, $this->tema_warna->CurrentValue, null, $this->tema_warna->ReadOnly);

            // no_notifikasi
            $this->no_notifikasi->setDbValueDef($rsnew, $this->no_notifikasi->CurrentValue, null, $this->no_notifikasi->ReadOnly);

            // jenis_kemasan
            $this->jenis_kemasan->setDbValueDef($rsnew, $this->jenis_kemasan->CurrentValue, null, $this->jenis_kemasan->ReadOnly);

            // posisi_label
            $this->posisi_label->setDbValueDef($rsnew, $this->posisi_label->CurrentValue, null, $this->posisi_label->ReadOnly);

            // bahan_label
            $this->bahan_label->setDbValueDef($rsnew, $this->bahan_label->CurrentValue, null, $this->bahan_label->ReadOnly);

            // draft_layout
            $this->draft_layout->setDbValueDef($rsnew, $this->draft_layout->CurrentValue, null, $this->draft_layout->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), CurrentDate(), $this->created_at->ReadOnly);

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

        // Check referential integrity for master table 'npd_desain'
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
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, null, false);

        // idcustomer
        $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, false);

        // tanggal_terima
        $this->tanggal_terima->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_terima->CurrentValue, 0), null, false);

        // tanggal_submit
        $this->tanggal_submit->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_submit->CurrentValue, 0), null, false);

        // nama_produk
        $this->nama_produk->setDbValueDef($rsnew, $this->nama_produk->CurrentValue, null, false);

        // klaim_bahan
        $this->klaim_bahan->setDbValueDef($rsnew, $this->klaim_bahan->CurrentValue, null, false);

        // campaign_produk
        $this->campaign_produk->setDbValueDef($rsnew, $this->campaign_produk->CurrentValue, null, false);

        // konsep
        $this->konsep->setDbValueDef($rsnew, $this->konsep->CurrentValue, null, false);

        // tema_warna
        $this->tema_warna->setDbValueDef($rsnew, $this->tema_warna->CurrentValue, null, false);

        // no_notifikasi
        $this->no_notifikasi->setDbValueDef($rsnew, $this->no_notifikasi->CurrentValue, null, false);

        // jenis_kemasan
        $this->jenis_kemasan->setDbValueDef($rsnew, $this->jenis_kemasan->CurrentValue, null, false);

        // posisi_label
        $this->posisi_label->setDbValueDef($rsnew, $this->posisi_label->CurrentValue, null, false);

        // bahan_label
        $this->bahan_label->setDbValueDef($rsnew, $this->bahan_label->CurrentValue, null, false);

        // draft_layout
        $this->draft_layout->setDbValueDef($rsnew, $this->draft_layout->CurrentValue, null, false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), CurrentDate(), false);

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
