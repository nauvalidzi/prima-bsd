<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class AlamatCustomerGrid extends AlamatCustomer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'alamat_customer';

    // Page object name
    public $PageObjName = "AlamatCustomerGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "falamat_customergrid";
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

        // Table object (alamat_customer)
        if (!isset($GLOBALS["alamat_customer"]) || get_class($GLOBALS["alamat_customer"]) == PROJECT_NAMESPACE . "alamat_customer") {
            $GLOBALS["alamat_customer"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        $this->AddUrl = "AlamatCustomerAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'alamat_customer');
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
                $doc = new $class(Container("alamat_customer"));
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
        $this->idcustomer->Visible = false;
        $this->alias->setVisibility();
        $this->penerima->setVisibility();
        $this->telepon->setVisibility();
        $this->alamat->setVisibility();
        $this->idprovinsi->setVisibility();
        $this->idkabupaten->setVisibility();
        $this->idkecamatan->setVisibility();
        $this->idkelurahan->setVisibility();
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
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idprovinsi);
        $this->setupLookupOptions($this->idkabupaten);
        $this->setupLookupOptions($this->idkecamatan);
        $this->setupLookupOptions($this->idkelurahan);

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
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "customer") {
            $masterTbl = Container("customer");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("CustomerList"); // Return to master page
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
        if ($CurrentForm->hasValue("x_alias") && $CurrentForm->hasValue("o_alias") && $this->alias->CurrentValue != $this->alias->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_penerima") && $CurrentForm->hasValue("o_penerima") && $this->penerima->CurrentValue != $this->penerima->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_telepon") && $CurrentForm->hasValue("o_telepon") && $this->telepon->CurrentValue != $this->telepon->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_alamat") && $CurrentForm->hasValue("o_alamat") && $this->alamat->CurrentValue != $this->alamat->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idprovinsi") && $CurrentForm->hasValue("o_idprovinsi") && $this->idprovinsi->CurrentValue != $this->idprovinsi->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idkabupaten") && $CurrentForm->hasValue("o_idkabupaten") && $this->idkabupaten->CurrentValue != $this->idkabupaten->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idkecamatan") && $CurrentForm->hasValue("o_idkecamatan") && $this->idkecamatan->CurrentValue != $this->idkecamatan->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_idkelurahan") && $CurrentForm->hasValue("o_idkelurahan") && $this->idkelurahan->CurrentValue != $this->idkelurahan->OldValue) {
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
        $this->alias->clearErrorMessage();
        $this->penerima->clearErrorMessage();
        $this->telepon->clearErrorMessage();
        $this->alamat->clearErrorMessage();
        $this->idprovinsi->clearErrorMessage();
        $this->idkabupaten->clearErrorMessage();
        $this->idkecamatan->clearErrorMessage();
        $this->idkelurahan->clearErrorMessage();
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
                        $this->idcustomer->setSessionValue("");
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
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->alias->CurrentValue = null;
        $this->alias->OldValue = $this->alias->CurrentValue;
        $this->penerima->CurrentValue = null;
        $this->penerima->OldValue = $this->penerima->CurrentValue;
        $this->telepon->CurrentValue = null;
        $this->telepon->OldValue = $this->telepon->CurrentValue;
        $this->alamat->CurrentValue = null;
        $this->alamat->OldValue = $this->alamat->CurrentValue;
        $this->idprovinsi->CurrentValue = null;
        $this->idprovinsi->OldValue = $this->idprovinsi->CurrentValue;
        $this->idkabupaten->CurrentValue = null;
        $this->idkabupaten->OldValue = $this->idkabupaten->CurrentValue;
        $this->idkecamatan->CurrentValue = null;
        $this->idkecamatan->OldValue = $this->idkecamatan->CurrentValue;
        $this->idkelurahan->CurrentValue = null;
        $this->idkelurahan->OldValue = $this->idkelurahan->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

        // Check field name 'alias' first before field var 'x_alias'
        $val = $CurrentForm->hasValue("alias") ? $CurrentForm->getValue("alias") : $CurrentForm->getValue("x_alias");
        if (!$this->alias->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alias->Visible = false; // Disable update for API request
            } else {
                $this->alias->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_alias")) {
            $this->alias->setOldValue($CurrentForm->getValue("o_alias"));
        }

        // Check field name 'penerima' first before field var 'x_penerima'
        $val = $CurrentForm->hasValue("penerima") ? $CurrentForm->getValue("penerima") : $CurrentForm->getValue("x_penerima");
        if (!$this->penerima->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->penerima->Visible = false; // Disable update for API request
            } else {
                $this->penerima->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_penerima")) {
            $this->penerima->setOldValue($CurrentForm->getValue("o_penerima"));
        }

        // Check field name 'telepon' first before field var 'x_telepon'
        $val = $CurrentForm->hasValue("telepon") ? $CurrentForm->getValue("telepon") : $CurrentForm->getValue("x_telepon");
        if (!$this->telepon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telepon->Visible = false; // Disable update for API request
            } else {
                $this->telepon->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_telepon")) {
            $this->telepon->setOldValue($CurrentForm->getValue("o_telepon"));
        }

        // Check field name 'alamat' first before field var 'x_alamat'
        $val = $CurrentForm->hasValue("alamat") ? $CurrentForm->getValue("alamat") : $CurrentForm->getValue("x_alamat");
        if (!$this->alamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamat->Visible = false; // Disable update for API request
            } else {
                $this->alamat->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_alamat")) {
            $this->alamat->setOldValue($CurrentForm->getValue("o_alamat"));
        }

        // Check field name 'idprovinsi' first before field var 'x_idprovinsi'
        $val = $CurrentForm->hasValue("idprovinsi") ? $CurrentForm->getValue("idprovinsi") : $CurrentForm->getValue("x_idprovinsi");
        if (!$this->idprovinsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idprovinsi->Visible = false; // Disable update for API request
            } else {
                $this->idprovinsi->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idprovinsi")) {
            $this->idprovinsi->setOldValue($CurrentForm->getValue("o_idprovinsi"));
        }

        // Check field name 'idkabupaten' first before field var 'x_idkabupaten'
        $val = $CurrentForm->hasValue("idkabupaten") ? $CurrentForm->getValue("idkabupaten") : $CurrentForm->getValue("x_idkabupaten");
        if (!$this->idkabupaten->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkabupaten->Visible = false; // Disable update for API request
            } else {
                $this->idkabupaten->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idkabupaten")) {
            $this->idkabupaten->setOldValue($CurrentForm->getValue("o_idkabupaten"));
        }

        // Check field name 'idkecamatan' first before field var 'x_idkecamatan'
        $val = $CurrentForm->hasValue("idkecamatan") ? $CurrentForm->getValue("idkecamatan") : $CurrentForm->getValue("x_idkecamatan");
        if (!$this->idkecamatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkecamatan->Visible = false; // Disable update for API request
            } else {
                $this->idkecamatan->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idkecamatan")) {
            $this->idkecamatan->setOldValue($CurrentForm->getValue("o_idkecamatan"));
        }

        // Check field name 'idkelurahan' first before field var 'x_idkelurahan'
        $val = $CurrentForm->hasValue("idkelurahan") ? $CurrentForm->getValue("idkelurahan") : $CurrentForm->getValue("x_idkelurahan");
        if (!$this->idkelurahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkelurahan->Visible = false; // Disable update for API request
            } else {
                $this->idkelurahan->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_idkelurahan")) {
            $this->idkelurahan->setOldValue($CurrentForm->getValue("o_idkelurahan"));
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
        $this->alias->CurrentValue = $this->alias->FormValue;
        $this->penerima->CurrentValue = $this->penerima->FormValue;
        $this->telepon->CurrentValue = $this->telepon->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->idprovinsi->CurrentValue = $this->idprovinsi->FormValue;
        $this->idkabupaten->CurrentValue = $this->idkabupaten->FormValue;
        $this->idkecamatan->CurrentValue = $this->idkecamatan->FormValue;
        $this->idkelurahan->CurrentValue = $this->idkelurahan->FormValue;
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
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->alias->setDbValue($row['alias']);
        $this->penerima->setDbValue($row['penerima']);
        $this->telepon->setDbValue($row['telepon']);
        $this->alamat->setDbValue($row['alamat']);
        $this->idprovinsi->setDbValue($row['idprovinsi']);
        $this->idkabupaten->setDbValue($row['idkabupaten']);
        $this->idkecamatan->setDbValue($row['idkecamatan']);
        $this->idkelurahan->setDbValue($row['idkelurahan']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['alias'] = $this->alias->CurrentValue;
        $row['penerima'] = $this->penerima->CurrentValue;
        $row['telepon'] = $this->telepon->CurrentValue;
        $row['alamat'] = $this->alamat->CurrentValue;
        $row['idprovinsi'] = $this->idprovinsi->CurrentValue;
        $row['idkabupaten'] = $this->idkabupaten->CurrentValue;
        $row['idkecamatan'] = $this->idkecamatan->CurrentValue;
        $row['idkelurahan'] = $this->idkelurahan->CurrentValue;
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

        // idcustomer

        // alias

        // penerima

        // telepon

        // alamat

        // idprovinsi

        // idkabupaten

        // idkecamatan

        // idkelurahan
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // alias
            $this->alias->ViewValue = $this->alias->CurrentValue;
            $this->alias->ViewCustomAttributes = "";

            // penerima
            $this->penerima->ViewValue = $this->penerima->CurrentValue;
            $this->penerima->ViewCustomAttributes = "";

            // telepon
            $this->telepon->ViewValue = $this->telepon->CurrentValue;
            $this->telepon->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // idprovinsi
            $curVal = trim(strval($this->idprovinsi->CurrentValue));
            if ($curVal != "") {
                $this->idprovinsi->ViewValue = $this->idprovinsi->lookupCacheOption($curVal);
                if ($this->idprovinsi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idprovinsi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idprovinsi->Lookup->renderViewRow($rswrk[0]);
                        $this->idprovinsi->ViewValue = $this->idprovinsi->displayValue($arwrk);
                    } else {
                        $this->idprovinsi->ViewValue = $this->idprovinsi->CurrentValue;
                    }
                }
            } else {
                $this->idprovinsi->ViewValue = null;
            }
            $this->idprovinsi->ViewCustomAttributes = "";

            // idkabupaten
            $curVal = trim(strval($this->idkabupaten->CurrentValue));
            if ($curVal != "") {
                $this->idkabupaten->ViewValue = $this->idkabupaten->lookupCacheOption($curVal);
                if ($this->idkabupaten->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkabupaten->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkabupaten->Lookup->renderViewRow($rswrk[0]);
                        $this->idkabupaten->ViewValue = $this->idkabupaten->displayValue($arwrk);
                    } else {
                        $this->idkabupaten->ViewValue = $this->idkabupaten->CurrentValue;
                    }
                }
            } else {
                $this->idkabupaten->ViewValue = null;
            }
            $this->idkabupaten->ViewCustomAttributes = "";

            // idkecamatan
            $curVal = trim(strval($this->idkecamatan->CurrentValue));
            if ($curVal != "") {
                $this->idkecamatan->ViewValue = $this->idkecamatan->lookupCacheOption($curVal);
                if ($this->idkecamatan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkecamatan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkecamatan->Lookup->renderViewRow($rswrk[0]);
                        $this->idkecamatan->ViewValue = $this->idkecamatan->displayValue($arwrk);
                    } else {
                        $this->idkecamatan->ViewValue = $this->idkecamatan->CurrentValue;
                    }
                }
            } else {
                $this->idkecamatan->ViewValue = null;
            }
            $this->idkecamatan->ViewCustomAttributes = "";

            // idkelurahan
            $curVal = trim(strval($this->idkelurahan->CurrentValue));
            if ($curVal != "") {
                $this->idkelurahan->ViewValue = $this->idkelurahan->lookupCacheOption($curVal);
                if ($this->idkelurahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkelurahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkelurahan->Lookup->renderViewRow($rswrk[0]);
                        $this->idkelurahan->ViewValue = $this->idkelurahan->displayValue($arwrk);
                    } else {
                        $this->idkelurahan->ViewValue = $this->idkelurahan->CurrentValue;
                    }
                }
            } else {
                $this->idkelurahan->ViewValue = null;
            }
            $this->idkelurahan->ViewCustomAttributes = "";

            // alias
            $this->alias->LinkCustomAttributes = "";
            $this->alias->HrefValue = "";
            $this->alias->TooltipValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";
            $this->penerima->TooltipValue = "";

            // telepon
            $this->telepon->LinkCustomAttributes = "";
            $this->telepon->HrefValue = "";
            $this->telepon->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // idprovinsi
            $this->idprovinsi->LinkCustomAttributes = "";
            $this->idprovinsi->HrefValue = "";
            $this->idprovinsi->TooltipValue = "";

            // idkabupaten
            $this->idkabupaten->LinkCustomAttributes = "";
            $this->idkabupaten->HrefValue = "";
            $this->idkabupaten->TooltipValue = "";

            // idkecamatan
            $this->idkecamatan->LinkCustomAttributes = "";
            $this->idkecamatan->HrefValue = "";
            $this->idkecamatan->TooltipValue = "";

            // idkelurahan
            $this->idkelurahan->LinkCustomAttributes = "";
            $this->idkelurahan->HrefValue = "";
            $this->idkelurahan->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // alias
            $this->alias->EditAttrs["class"] = "form-control";
            $this->alias->EditCustomAttributes = "";
            if (!$this->alias->Raw) {
                $this->alias->CurrentValue = HtmlDecode($this->alias->CurrentValue);
            }
            $this->alias->EditValue = HtmlEncode($this->alias->CurrentValue);
            $this->alias->PlaceHolder = RemoveHtml($this->alias->caption());

            // penerima
            $this->penerima->EditAttrs["class"] = "form-control";
            $this->penerima->EditCustomAttributes = "";
            if (!$this->penerima->Raw) {
                $this->penerima->CurrentValue = HtmlDecode($this->penerima->CurrentValue);
            }
            $this->penerima->EditValue = HtmlEncode($this->penerima->CurrentValue);
            $this->penerima->PlaceHolder = RemoveHtml($this->penerima->caption());

            // telepon
            $this->telepon->EditAttrs["class"] = "form-control";
            $this->telepon->EditCustomAttributes = "";
            if (!$this->telepon->Raw) {
                $this->telepon->CurrentValue = HtmlDecode($this->telepon->CurrentValue);
            }
            $this->telepon->EditValue = HtmlEncode($this->telepon->CurrentValue);
            $this->telepon->PlaceHolder = RemoveHtml($this->telepon->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // idprovinsi
            $this->idprovinsi->EditAttrs["class"] = "form-control";
            $this->idprovinsi->EditCustomAttributes = "";
            $curVal = trim(strval($this->idprovinsi->CurrentValue));
            if ($curVal != "") {
                $this->idprovinsi->ViewValue = $this->idprovinsi->lookupCacheOption($curVal);
            } else {
                $this->idprovinsi->ViewValue = $this->idprovinsi->Lookup !== null && is_array($this->idprovinsi->Lookup->Options) ? $curVal : null;
            }
            if ($this->idprovinsi->ViewValue !== null) { // Load from cache
                $this->idprovinsi->EditValue = array_values($this->idprovinsi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idprovinsi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idprovinsi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idprovinsi->EditValue = $arwrk;
            }
            $this->idprovinsi->PlaceHolder = RemoveHtml($this->idprovinsi->caption());

            // idkabupaten
            $this->idkabupaten->EditAttrs["class"] = "form-control";
            $this->idkabupaten->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkabupaten->CurrentValue));
            if ($curVal != "") {
                $this->idkabupaten->ViewValue = $this->idkabupaten->lookupCacheOption($curVal);
            } else {
                $this->idkabupaten->ViewValue = $this->idkabupaten->Lookup !== null && is_array($this->idkabupaten->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkabupaten->ViewValue !== null) { // Load from cache
                $this->idkabupaten->EditValue = array_values($this->idkabupaten->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkabupaten->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkabupaten->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkabupaten->EditValue = $arwrk;
            }
            $this->idkabupaten->PlaceHolder = RemoveHtml($this->idkabupaten->caption());

            // idkecamatan
            $this->idkecamatan->EditAttrs["class"] = "form-control";
            $this->idkecamatan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkecamatan->CurrentValue));
            if ($curVal != "") {
                $this->idkecamatan->ViewValue = $this->idkecamatan->lookupCacheOption($curVal);
            } else {
                $this->idkecamatan->ViewValue = $this->idkecamatan->Lookup !== null && is_array($this->idkecamatan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkecamatan->ViewValue !== null) { // Load from cache
                $this->idkecamatan->EditValue = array_values($this->idkecamatan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkecamatan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkecamatan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkecamatan->EditValue = $arwrk;
            }
            $this->idkecamatan->PlaceHolder = RemoveHtml($this->idkecamatan->caption());

            // idkelurahan
            $this->idkelurahan->EditAttrs["class"] = "form-control";
            $this->idkelurahan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkelurahan->CurrentValue));
            if ($curVal != "") {
                $this->idkelurahan->ViewValue = $this->idkelurahan->lookupCacheOption($curVal);
            } else {
                $this->idkelurahan->ViewValue = $this->idkelurahan->Lookup !== null && is_array($this->idkelurahan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkelurahan->ViewValue !== null) { // Load from cache
                $this->idkelurahan->EditValue = array_values($this->idkelurahan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkelurahan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkelurahan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkelurahan->EditValue = $arwrk;
            }
            $this->idkelurahan->PlaceHolder = RemoveHtml($this->idkelurahan->caption());

            // Add refer script

            // alias
            $this->alias->LinkCustomAttributes = "";
            $this->alias->HrefValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";

            // telepon
            $this->telepon->LinkCustomAttributes = "";
            $this->telepon->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // idprovinsi
            $this->idprovinsi->LinkCustomAttributes = "";
            $this->idprovinsi->HrefValue = "";

            // idkabupaten
            $this->idkabupaten->LinkCustomAttributes = "";
            $this->idkabupaten->HrefValue = "";

            // idkecamatan
            $this->idkecamatan->LinkCustomAttributes = "";
            $this->idkecamatan->HrefValue = "";

            // idkelurahan
            $this->idkelurahan->LinkCustomAttributes = "";
            $this->idkelurahan->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // alias
            $this->alias->EditAttrs["class"] = "form-control";
            $this->alias->EditCustomAttributes = "";
            if (!$this->alias->Raw) {
                $this->alias->CurrentValue = HtmlDecode($this->alias->CurrentValue);
            }
            $this->alias->EditValue = HtmlEncode($this->alias->CurrentValue);
            $this->alias->PlaceHolder = RemoveHtml($this->alias->caption());

            // penerima
            $this->penerima->EditAttrs["class"] = "form-control";
            $this->penerima->EditCustomAttributes = "";
            if (!$this->penerima->Raw) {
                $this->penerima->CurrentValue = HtmlDecode($this->penerima->CurrentValue);
            }
            $this->penerima->EditValue = HtmlEncode($this->penerima->CurrentValue);
            $this->penerima->PlaceHolder = RemoveHtml($this->penerima->caption());

            // telepon
            $this->telepon->EditAttrs["class"] = "form-control";
            $this->telepon->EditCustomAttributes = "";
            if (!$this->telepon->Raw) {
                $this->telepon->CurrentValue = HtmlDecode($this->telepon->CurrentValue);
            }
            $this->telepon->EditValue = HtmlEncode($this->telepon->CurrentValue);
            $this->telepon->PlaceHolder = RemoveHtml($this->telepon->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // idprovinsi
            $this->idprovinsi->EditAttrs["class"] = "form-control";
            $this->idprovinsi->EditCustomAttributes = "";
            $curVal = trim(strval($this->idprovinsi->CurrentValue));
            if ($curVal != "") {
                $this->idprovinsi->ViewValue = $this->idprovinsi->lookupCacheOption($curVal);
            } else {
                $this->idprovinsi->ViewValue = $this->idprovinsi->Lookup !== null && is_array($this->idprovinsi->Lookup->Options) ? $curVal : null;
            }
            if ($this->idprovinsi->ViewValue !== null) { // Load from cache
                $this->idprovinsi->EditValue = array_values($this->idprovinsi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idprovinsi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idprovinsi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idprovinsi->EditValue = $arwrk;
            }
            $this->idprovinsi->PlaceHolder = RemoveHtml($this->idprovinsi->caption());

            // idkabupaten
            $this->idkabupaten->EditAttrs["class"] = "form-control";
            $this->idkabupaten->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkabupaten->CurrentValue));
            if ($curVal != "") {
                $this->idkabupaten->ViewValue = $this->idkabupaten->lookupCacheOption($curVal);
            } else {
                $this->idkabupaten->ViewValue = $this->idkabupaten->Lookup !== null && is_array($this->idkabupaten->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkabupaten->ViewValue !== null) { // Load from cache
                $this->idkabupaten->EditValue = array_values($this->idkabupaten->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkabupaten->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkabupaten->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkabupaten->EditValue = $arwrk;
            }
            $this->idkabupaten->PlaceHolder = RemoveHtml($this->idkabupaten->caption());

            // idkecamatan
            $this->idkecamatan->EditAttrs["class"] = "form-control";
            $this->idkecamatan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkecamatan->CurrentValue));
            if ($curVal != "") {
                $this->idkecamatan->ViewValue = $this->idkecamatan->lookupCacheOption($curVal);
            } else {
                $this->idkecamatan->ViewValue = $this->idkecamatan->Lookup !== null && is_array($this->idkecamatan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkecamatan->ViewValue !== null) { // Load from cache
                $this->idkecamatan->EditValue = array_values($this->idkecamatan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkecamatan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkecamatan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkecamatan->EditValue = $arwrk;
            }
            $this->idkecamatan->PlaceHolder = RemoveHtml($this->idkecamatan->caption());

            // idkelurahan
            $this->idkelurahan->EditAttrs["class"] = "form-control";
            $this->idkelurahan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkelurahan->CurrentValue));
            if ($curVal != "") {
                $this->idkelurahan->ViewValue = $this->idkelurahan->lookupCacheOption($curVal);
            } else {
                $this->idkelurahan->ViewValue = $this->idkelurahan->Lookup !== null && is_array($this->idkelurahan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkelurahan->ViewValue !== null) { // Load from cache
                $this->idkelurahan->EditValue = array_values($this->idkelurahan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkelurahan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkelurahan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkelurahan->EditValue = $arwrk;
            }
            $this->idkelurahan->PlaceHolder = RemoveHtml($this->idkelurahan->caption());

            // Edit refer script

            // alias
            $this->alias->LinkCustomAttributes = "";
            $this->alias->HrefValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";

            // telepon
            $this->telepon->LinkCustomAttributes = "";
            $this->telepon->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // idprovinsi
            $this->idprovinsi->LinkCustomAttributes = "";
            $this->idprovinsi->HrefValue = "";

            // idkabupaten
            $this->idkabupaten->LinkCustomAttributes = "";
            $this->idkabupaten->HrefValue = "";

            // idkecamatan
            $this->idkecamatan->LinkCustomAttributes = "";
            $this->idkecamatan->HrefValue = "";

            // idkelurahan
            $this->idkelurahan->LinkCustomAttributes = "";
            $this->idkelurahan->HrefValue = "";
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
        if ($this->alias->Required) {
            if (!$this->alias->IsDetailKey && EmptyValue($this->alias->FormValue)) {
                $this->alias->addErrorMessage(str_replace("%s", $this->alias->caption(), $this->alias->RequiredErrorMessage));
            }
        }
        if ($this->penerima->Required) {
            if (!$this->penerima->IsDetailKey && EmptyValue($this->penerima->FormValue)) {
                $this->penerima->addErrorMessage(str_replace("%s", $this->penerima->caption(), $this->penerima->RequiredErrorMessage));
            }
        }
        if ($this->telepon->Required) {
            if (!$this->telepon->IsDetailKey && EmptyValue($this->telepon->FormValue)) {
                $this->telepon->addErrorMessage(str_replace("%s", $this->telepon->caption(), $this->telepon->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->idprovinsi->Required) {
            if (!$this->idprovinsi->IsDetailKey && EmptyValue($this->idprovinsi->FormValue)) {
                $this->idprovinsi->addErrorMessage(str_replace("%s", $this->idprovinsi->caption(), $this->idprovinsi->RequiredErrorMessage));
            }
        }
        if ($this->idkabupaten->Required) {
            if (!$this->idkabupaten->IsDetailKey && EmptyValue($this->idkabupaten->FormValue)) {
                $this->idkabupaten->addErrorMessage(str_replace("%s", $this->idkabupaten->caption(), $this->idkabupaten->RequiredErrorMessage));
            }
        }
        if ($this->idkecamatan->Required) {
            if (!$this->idkecamatan->IsDetailKey && EmptyValue($this->idkecamatan->FormValue)) {
                $this->idkecamatan->addErrorMessage(str_replace("%s", $this->idkecamatan->caption(), $this->idkecamatan->RequiredErrorMessage));
            }
        }
        if ($this->idkelurahan->Required) {
            if (!$this->idkelurahan->IsDetailKey && EmptyValue($this->idkelurahan->FormValue)) {
                $this->idkelurahan->addErrorMessage(str_replace("%s", $this->idkelurahan->caption(), $this->idkelurahan->RequiredErrorMessage));
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

            // alias
            $this->alias->setDbValueDef($rsnew, $this->alias->CurrentValue, "", $this->alias->ReadOnly);

            // penerima
            $this->penerima->setDbValueDef($rsnew, $this->penerima->CurrentValue, "", $this->penerima->ReadOnly);

            // telepon
            $this->telepon->setDbValueDef($rsnew, $this->telepon->CurrentValue, "", $this->telepon->ReadOnly);

            // alamat
            $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, null, $this->alamat->ReadOnly);

            // idprovinsi
            $this->idprovinsi->setDbValueDef($rsnew, $this->idprovinsi->CurrentValue, "", $this->idprovinsi->ReadOnly);

            // idkabupaten
            $this->idkabupaten->setDbValueDef($rsnew, $this->idkabupaten->CurrentValue, "", $this->idkabupaten->ReadOnly);

            // idkecamatan
            $this->idkecamatan->setDbValueDef($rsnew, $this->idkecamatan->CurrentValue, "", $this->idkecamatan->ReadOnly);

            // idkelurahan
            $this->idkelurahan->setDbValueDef($rsnew, $this->idkelurahan->CurrentValue, null, $this->idkelurahan->ReadOnly);

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
        if ($this->getCurrentMasterTable() == "customer") {
            $this->idcustomer->CurrentValue = $this->idcustomer->getSessionValue();
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // alias
        $this->alias->setDbValueDef($rsnew, $this->alias->CurrentValue, "", false);

        // penerima
        $this->penerima->setDbValueDef($rsnew, $this->penerima->CurrentValue, "", false);

        // telepon
        $this->telepon->setDbValueDef($rsnew, $this->telepon->CurrentValue, "", strval($this->telepon->CurrentValue) == "");

        // alamat
        $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, null, false);

        // idprovinsi
        $this->idprovinsi->setDbValueDef($rsnew, $this->idprovinsi->CurrentValue, "", false);

        // idkabupaten
        $this->idkabupaten->setDbValueDef($rsnew, $this->idkabupaten->CurrentValue, "", false);

        // idkecamatan
        $this->idkecamatan->setDbValueDef($rsnew, $this->idkecamatan->CurrentValue, "", false);

        // idkelurahan
        $this->idkelurahan->setDbValueDef($rsnew, $this->idkelurahan->CurrentValue, null, false);

        // idcustomer
        if ($this->idcustomer->getSessionValue() != "") {
            $rsnew['idcustomer'] = $this->idcustomer->getSessionValue();
        }

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
        if ($masterTblVar == "customer") {
            $masterTbl = Container("customer");
            $this->idcustomer->Visible = false;
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
                case "x_idcustomer":
                    break;
                case "x_idprovinsi":
                    break;
                case "x_idkabupaten":
                    break;
                case "x_idkecamatan":
                    break;
                case "x_idkelurahan":
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
