<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class StocksEdit extends Stocks
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'stocks';

    // Page object name
    public $PageObjName = "StocksEdit";

    // Rendering View
    public $RenderingView = false;

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

        // Table object (stocks)
        if (!isset($GLOBALS["stocks"]) || get_class($GLOBALS["stocks"]) == PROJECT_NAMESPACE . "stocks") {
            $GLOBALS["stocks"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'stocks');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
                $doc = new $class(Container("stocks"));
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "StocksView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->prop_id->setVisibility();
        $this->prop_code->setVisibility();
        $this->idproduct->setVisibility();
        $this->stok_masuk->setVisibility();
        $this->stok_keluar->setVisibility();
        $this->stok_akhir->setVisibility();
        $this->aktif->setVisibility();
        $this->keterangan->setVisibility();
        $this->created_at->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("StocksList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "StocksList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'prop_id' first before field var 'x_prop_id'
        $val = $CurrentForm->hasValue("prop_id") ? $CurrentForm->getValue("prop_id") : $CurrentForm->getValue("x_prop_id");
        if (!$this->prop_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->prop_id->Visible = false; // Disable update for API request
            } else {
                $this->prop_id->setFormValue($val);
            }
        }

        // Check field name 'prop_code' first before field var 'x_prop_code'
        $val = $CurrentForm->hasValue("prop_code") ? $CurrentForm->getValue("prop_code") : $CurrentForm->getValue("x_prop_code");
        if (!$this->prop_code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->prop_code->Visible = false; // Disable update for API request
            } else {
                $this->prop_code->setFormValue($val);
            }
        }

        // Check field name 'idproduct' first before field var 'x_idproduct'
        $val = $CurrentForm->hasValue("idproduct") ? $CurrentForm->getValue("idproduct") : $CurrentForm->getValue("x_idproduct");
        if (!$this->idproduct->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idproduct->Visible = false; // Disable update for API request
            } else {
                $this->idproduct->setFormValue($val);
            }
        }

        // Check field name 'stok_masuk' first before field var 'x_stok_masuk'
        $val = $CurrentForm->hasValue("stok_masuk") ? $CurrentForm->getValue("stok_masuk") : $CurrentForm->getValue("x_stok_masuk");
        if (!$this->stok_masuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->stok_masuk->Visible = false; // Disable update for API request
            } else {
                $this->stok_masuk->setFormValue($val);
            }
        }

        // Check field name 'stok_keluar' first before field var 'x_stok_keluar'
        $val = $CurrentForm->hasValue("stok_keluar") ? $CurrentForm->getValue("stok_keluar") : $CurrentForm->getValue("x_stok_keluar");
        if (!$this->stok_keluar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->stok_keluar->Visible = false; // Disable update for API request
            } else {
                $this->stok_keluar->setFormValue($val);
            }
        }

        // Check field name 'stok_akhir' first before field var 'x_stok_akhir'
        $val = $CurrentForm->hasValue("stok_akhir") ? $CurrentForm->getValue("stok_akhir") : $CurrentForm->getValue("x_stok_akhir");
        if (!$this->stok_akhir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->stok_akhir->Visible = false; // Disable update for API request
            } else {
                $this->stok_akhir->setFormValue($val);
            }
        }

        // Check field name 'aktif' first before field var 'x_aktif'
        $val = $CurrentForm->hasValue("aktif") ? $CurrentForm->getValue("aktif") : $CurrentForm->getValue("x_aktif");
        if (!$this->aktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aktif->Visible = false; // Disable update for API request
            } else {
                $this->aktif->setFormValue($val);
            }
        }

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
            }
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->prop_id->CurrentValue = $this->prop_id->FormValue;
        $this->prop_code->CurrentValue = $this->prop_code->FormValue;
        $this->idproduct->CurrentValue = $this->idproduct->FormValue;
        $this->stok_masuk->CurrentValue = $this->stok_masuk->FormValue;
        $this->stok_keluar->CurrentValue = $this->stok_keluar->FormValue;
        $this->stok_akhir->CurrentValue = $this->stok_akhir->FormValue;
        $this->aktif->CurrentValue = $this->aktif->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
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
        $this->prop_id->setDbValue($row['prop_id']);
        $this->prop_code->setDbValue($row['prop_code']);
        $this->idproduct->setDbValue($row['idproduct']);
        $this->stok_masuk->setDbValue($row['stok_masuk']);
        $this->stok_keluar->setDbValue($row['stok_keluar']);
        $this->stok_akhir->setDbValue($row['stok_akhir']);
        $this->aktif->setDbValue($row['aktif']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['prop_id'] = null;
        $row['prop_code'] = null;
        $row['idproduct'] = null;
        $row['stok_masuk'] = null;
        $row['stok_keluar'] = null;
        $row['stok_akhir'] = null;
        $row['aktif'] = null;
        $row['keterangan'] = null;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // prop_id

        // prop_code

        // idproduct

        // stok_masuk

        // stok_keluar

        // stok_akhir

        // aktif

        // keterangan

        // created_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // prop_id
            $this->prop_id->ViewValue = $this->prop_id->CurrentValue;
            $this->prop_id->ViewValue = FormatNumber($this->prop_id->ViewValue, 0, -2, -2, -2);
            $this->prop_id->ViewCustomAttributes = "";

            // prop_code
            $this->prop_code->ViewValue = $this->prop_code->CurrentValue;
            $this->prop_code->ViewCustomAttributes = "";

            // idproduct
            $this->idproduct->ViewValue = $this->idproduct->CurrentValue;
            $this->idproduct->ViewValue = FormatNumber($this->idproduct->ViewValue, 0, -2, -2, -2);
            $this->idproduct->ViewCustomAttributes = "";

            // stok_masuk
            $this->stok_masuk->ViewValue = $this->stok_masuk->CurrentValue;
            $this->stok_masuk->ViewValue = FormatNumber($this->stok_masuk->ViewValue, 0, -2, -2, -2);
            $this->stok_masuk->ViewCustomAttributes = "";

            // stok_keluar
            $this->stok_keluar->ViewValue = $this->stok_keluar->CurrentValue;
            $this->stok_keluar->ViewValue = FormatNumber($this->stok_keluar->ViewValue, 0, -2, -2, -2);
            $this->stok_keluar->ViewCustomAttributes = "";

            // stok_akhir
            $this->stok_akhir->ViewValue = $this->stok_akhir->CurrentValue;
            $this->stok_akhir->ViewValue = FormatNumber($this->stok_akhir->ViewValue, 0, -2, -2, -2);
            $this->stok_akhir->ViewCustomAttributes = "";

            // aktif
            if (ConvertToBool($this->aktif->CurrentValue)) {
                $this->aktif->ViewValue = $this->aktif->tagCaption(1) != "" ? $this->aktif->tagCaption(1) : "Yes";
            } else {
                $this->aktif->ViewValue = $this->aktif->tagCaption(2) != "" ? $this->aktif->tagCaption(2) : "No";
            }
            $this->aktif->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // prop_id
            $this->prop_id->LinkCustomAttributes = "";
            $this->prop_id->HrefValue = "";
            $this->prop_id->TooltipValue = "";

            // prop_code
            $this->prop_code->LinkCustomAttributes = "";
            $this->prop_code->HrefValue = "";
            $this->prop_code->TooltipValue = "";

            // idproduct
            $this->idproduct->LinkCustomAttributes = "";
            $this->idproduct->HrefValue = "";
            $this->idproduct->TooltipValue = "";

            // stok_masuk
            $this->stok_masuk->LinkCustomAttributes = "";
            $this->stok_masuk->HrefValue = "";
            $this->stok_masuk->TooltipValue = "";

            // stok_keluar
            $this->stok_keluar->LinkCustomAttributes = "";
            $this->stok_keluar->HrefValue = "";
            $this->stok_keluar->TooltipValue = "";

            // stok_akhir
            $this->stok_akhir->LinkCustomAttributes = "";
            $this->stok_akhir->HrefValue = "";
            $this->stok_akhir->TooltipValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";
            $this->aktif->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // prop_id
            $this->prop_id->EditAttrs["class"] = "form-control";
            $this->prop_id->EditCustomAttributes = "";
            $this->prop_id->EditValue = HtmlEncode($this->prop_id->CurrentValue);
            $this->prop_id->PlaceHolder = RemoveHtml($this->prop_id->caption());

            // prop_code
            $this->prop_code->EditAttrs["class"] = "form-control";
            $this->prop_code->EditCustomAttributes = "";
            if (!$this->prop_code->Raw) {
                $this->prop_code->CurrentValue = HtmlDecode($this->prop_code->CurrentValue);
            }
            $this->prop_code->EditValue = HtmlEncode($this->prop_code->CurrentValue);
            $this->prop_code->PlaceHolder = RemoveHtml($this->prop_code->caption());

            // idproduct
            $this->idproduct->EditAttrs["class"] = "form-control";
            $this->idproduct->EditCustomAttributes = "";
            $this->idproduct->EditValue = HtmlEncode($this->idproduct->CurrentValue);
            $this->idproduct->PlaceHolder = RemoveHtml($this->idproduct->caption());

            // stok_masuk
            $this->stok_masuk->EditAttrs["class"] = "form-control";
            $this->stok_masuk->EditCustomAttributes = "";
            $this->stok_masuk->EditValue = HtmlEncode($this->stok_masuk->CurrentValue);
            $this->stok_masuk->PlaceHolder = RemoveHtml($this->stok_masuk->caption());

            // stok_keluar
            $this->stok_keluar->EditAttrs["class"] = "form-control";
            $this->stok_keluar->EditCustomAttributes = "";
            $this->stok_keluar->EditValue = HtmlEncode($this->stok_keluar->CurrentValue);
            $this->stok_keluar->PlaceHolder = RemoveHtml($this->stok_keluar->caption());

            // stok_akhir
            $this->stok_akhir->EditAttrs["class"] = "form-control";
            $this->stok_akhir->EditCustomAttributes = "";
            $this->stok_akhir->EditValue = HtmlEncode($this->stok_akhir->CurrentValue);
            $this->stok_akhir->PlaceHolder = RemoveHtml($this->stok_akhir->caption());

            // aktif
            $this->aktif->EditCustomAttributes = "";
            $this->aktif->EditValue = $this->aktif->options(false);
            $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // prop_id
            $this->prop_id->LinkCustomAttributes = "";
            $this->prop_id->HrefValue = "";

            // prop_code
            $this->prop_code->LinkCustomAttributes = "";
            $this->prop_code->HrefValue = "";

            // idproduct
            $this->idproduct->LinkCustomAttributes = "";
            $this->idproduct->HrefValue = "";

            // stok_masuk
            $this->stok_masuk->LinkCustomAttributes = "";
            $this->stok_masuk->HrefValue = "";

            // stok_keluar
            $this->stok_keluar->LinkCustomAttributes = "";
            $this->stok_keluar->HrefValue = "";

            // stok_akhir
            $this->stok_akhir->LinkCustomAttributes = "";
            $this->stok_akhir->HrefValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";

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
        if ($this->prop_id->Required) {
            if (!$this->prop_id->IsDetailKey && EmptyValue($this->prop_id->FormValue)) {
                $this->prop_id->addErrorMessage(str_replace("%s", $this->prop_id->caption(), $this->prop_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->prop_id->FormValue)) {
            $this->prop_id->addErrorMessage($this->prop_id->getErrorMessage(false));
        }
        if ($this->prop_code->Required) {
            if (!$this->prop_code->IsDetailKey && EmptyValue($this->prop_code->FormValue)) {
                $this->prop_code->addErrorMessage(str_replace("%s", $this->prop_code->caption(), $this->prop_code->RequiredErrorMessage));
            }
        }
        if ($this->idproduct->Required) {
            if (!$this->idproduct->IsDetailKey && EmptyValue($this->idproduct->FormValue)) {
                $this->idproduct->addErrorMessage(str_replace("%s", $this->idproduct->caption(), $this->idproduct->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idproduct->FormValue)) {
            $this->idproduct->addErrorMessage($this->idproduct->getErrorMessage(false));
        }
        if ($this->stok_masuk->Required) {
            if (!$this->stok_masuk->IsDetailKey && EmptyValue($this->stok_masuk->FormValue)) {
                $this->stok_masuk->addErrorMessage(str_replace("%s", $this->stok_masuk->caption(), $this->stok_masuk->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->stok_masuk->FormValue)) {
            $this->stok_masuk->addErrorMessage($this->stok_masuk->getErrorMessage(false));
        }
        if ($this->stok_keluar->Required) {
            if (!$this->stok_keluar->IsDetailKey && EmptyValue($this->stok_keluar->FormValue)) {
                $this->stok_keluar->addErrorMessage(str_replace("%s", $this->stok_keluar->caption(), $this->stok_keluar->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->stok_keluar->FormValue)) {
            $this->stok_keluar->addErrorMessage($this->stok_keluar->getErrorMessage(false));
        }
        if ($this->stok_akhir->Required) {
            if (!$this->stok_akhir->IsDetailKey && EmptyValue($this->stok_akhir->FormValue)) {
                $this->stok_akhir->addErrorMessage(str_replace("%s", $this->stok_akhir->caption(), $this->stok_akhir->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->stok_akhir->FormValue)) {
            $this->stok_akhir->addErrorMessage($this->stok_akhir->getErrorMessage(false));
        }
        if ($this->aktif->Required) {
            if ($this->aktif->FormValue == "") {
                $this->aktif->addErrorMessage(str_replace("%s", $this->aktif->caption(), $this->aktif->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
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

            // prop_id
            $this->prop_id->setDbValueDef($rsnew, $this->prop_id->CurrentValue, 0, $this->prop_id->ReadOnly);

            // prop_code
            $this->prop_code->setDbValueDef($rsnew, $this->prop_code->CurrentValue, "", $this->prop_code->ReadOnly);

            // idproduct
            $this->idproduct->setDbValueDef($rsnew, $this->idproduct->CurrentValue, 0, $this->idproduct->ReadOnly);

            // stok_masuk
            $this->stok_masuk->setDbValueDef($rsnew, $this->stok_masuk->CurrentValue, 0, $this->stok_masuk->ReadOnly);

            // stok_keluar
            $this->stok_keluar->setDbValueDef($rsnew, $this->stok_keluar->CurrentValue, 0, $this->stok_keluar->ReadOnly);

            // stok_akhir
            $this->stok_akhir->setDbValueDef($rsnew, $this->stok_akhir->CurrentValue, 0, $this->stok_akhir->ReadOnly);

            // aktif
            $tmpBool = $this->aktif->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->aktif->setDbValueDef($rsnew, $tmpBool, 0, $this->aktif->ReadOnly);

            // keterangan
            $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, "", $this->keterangan->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), CurrentDate(), $this->created_at->ReadOnly);

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("StocksList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
}
