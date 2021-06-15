<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PembayaranAdd extends Pembayaran
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'pembayaran';

    // Page object name
    public $PageObjName = "PembayaranAdd";

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

        // Table object (pembayaran)
        if (!isset($GLOBALS["pembayaran"]) || get_class($GLOBALS["pembayaran"]) == PROJECT_NAMESPACE . "pembayaran") {
            $GLOBALS["pembayaran"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'pembayaran');
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
                $doc = new $class(Container("pembayaran"));
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
                    if ($pageName == "PembayaranView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->id->Visible = false;
        $this->kode->setVisibility();
        $this->tanggal->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idinvoice->setVisibility();
        $this->totaltagihan->setVisibility();
        $this->sisatagihan->setVisibility();
        $this->jumlahbayar->setVisibility();
        $this->idtipepayment->setVisibility();
        $this->bukti->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->setVisibility();
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
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idinvoice);
        $this->setupLookupOptions($this->idtipepayment);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PembayaranList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "PembayaranList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "PembayaranView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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
        $this->bukti->Upload->Index = $CurrentForm->Index;
        $this->bukti->Upload->uploadFile();
        $this->bukti->CurrentValue = $this->bukti->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->kode->CurrentValue = null;
        $this->kode->OldValue = $this->kode->CurrentValue;
        $this->tanggal->CurrentValue = null;
        $this->tanggal->OldValue = $this->tanggal->CurrentValue;
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->idinvoice->CurrentValue = null;
        $this->idinvoice->OldValue = $this->idinvoice->CurrentValue;
        $this->totaltagihan->CurrentValue = null;
        $this->totaltagihan->OldValue = $this->totaltagihan->CurrentValue;
        $this->sisatagihan->CurrentValue = null;
        $this->sisatagihan->OldValue = $this->sisatagihan->CurrentValue;
        $this->jumlahbayar->CurrentValue = null;
        $this->jumlahbayar->OldValue = $this->jumlahbayar->CurrentValue;
        $this->idtipepayment->CurrentValue = null;
        $this->idtipepayment->OldValue = $this->idtipepayment->CurrentValue;
        $this->bukti->Upload->DbValue = null;
        $this->bukti->OldValue = $this->bukti->Upload->DbValue;
        $this->bukti->CurrentValue = null; // Clear file related field
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'kode' first before field var 'x_kode'
        $val = $CurrentForm->hasValue("kode") ? $CurrentForm->getValue("kode") : $CurrentForm->getValue("x_kode");
        if (!$this->kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode->Visible = false; // Disable update for API request
            } else {
                $this->kode->setFormValue($val);
            }
        }

        // Check field name 'tanggal' first before field var 'x_tanggal'
        $val = $CurrentForm->hasValue("tanggal") ? $CurrentForm->getValue("tanggal") : $CurrentForm->getValue("x_tanggal");
        if (!$this->tanggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal->Visible = false; // Disable update for API request
            } else {
                $this->tanggal->setFormValue($val);
            }
            $this->tanggal->CurrentValue = UnFormatDateTime($this->tanggal->CurrentValue, 0);
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

        // Check field name 'idinvoice' first before field var 'x_idinvoice'
        $val = $CurrentForm->hasValue("idinvoice") ? $CurrentForm->getValue("idinvoice") : $CurrentForm->getValue("x_idinvoice");
        if (!$this->idinvoice->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idinvoice->Visible = false; // Disable update for API request
            } else {
                $this->idinvoice->setFormValue($val);
            }
        }

        // Check field name 'totaltagihan' first before field var 'x_totaltagihan'
        $val = $CurrentForm->hasValue("totaltagihan") ? $CurrentForm->getValue("totaltagihan") : $CurrentForm->getValue("x_totaltagihan");
        if (!$this->totaltagihan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totaltagihan->Visible = false; // Disable update for API request
            } else {
                $this->totaltagihan->setFormValue($val);
            }
        }

        // Check field name 'sisatagihan' first before field var 'x_sisatagihan'
        $val = $CurrentForm->hasValue("sisatagihan") ? $CurrentForm->getValue("sisatagihan") : $CurrentForm->getValue("x_sisatagihan");
        if (!$this->sisatagihan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sisatagihan->Visible = false; // Disable update for API request
            } else {
                $this->sisatagihan->setFormValue($val);
            }
        }

        // Check field name 'jumlahbayar' first before field var 'x_jumlahbayar'
        $val = $CurrentForm->hasValue("jumlahbayar") ? $CurrentForm->getValue("jumlahbayar") : $CurrentForm->getValue("x_jumlahbayar");
        if (!$this->jumlahbayar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahbayar->Visible = false; // Disable update for API request
            } else {
                $this->jumlahbayar->setFormValue($val);
            }
        }

        // Check field name 'idtipepayment' first before field var 'x_idtipepayment'
        $val = $CurrentForm->hasValue("idtipepayment") ? $CurrentForm->getValue("idtipepayment") : $CurrentForm->getValue("x_idtipepayment");
        if (!$this->idtipepayment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idtipepayment->Visible = false; // Disable update for API request
            } else {
                $this->idtipepayment->setFormValue($val);
            }
        }

        // Check field name 'created_by' first before field var 'x_created_by'
        $val = $CurrentForm->hasValue("created_by") ? $CurrentForm->getValue("created_by") : $CurrentForm->getValue("x_created_by");
        if (!$this->created_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_by->Visible = false; // Disable update for API request
            } else {
                $this->created_by->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->tanggal->CurrentValue = $this->tanggal->FormValue;
        $this->tanggal->CurrentValue = UnFormatDateTime($this->tanggal->CurrentValue, 0);
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->idinvoice->CurrentValue = $this->idinvoice->FormValue;
        $this->totaltagihan->CurrentValue = $this->totaltagihan->FormValue;
        $this->sisatagihan->CurrentValue = $this->sisatagihan->FormValue;
        $this->jumlahbayar->CurrentValue = $this->jumlahbayar->FormValue;
        $this->idtipepayment->CurrentValue = $this->idtipepayment->FormValue;
        $this->created_by->CurrentValue = $this->created_by->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->tanggal->setDbValue($row['tanggal']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idinvoice->setDbValue($row['idinvoice']);
        $this->totaltagihan->setDbValue($row['totaltagihan']);
        $this->sisatagihan->setDbValue($row['sisatagihan']);
        $this->jumlahbayar->setDbValue($row['jumlahbayar']);
        $this->idtipepayment->setDbValue($row['idtipepayment']);
        $this->bukti->Upload->DbValue = $row['bukti'];
        $this->bukti->setDbValue($this->bukti->Upload->DbValue);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['kode'] = $this->kode->CurrentValue;
        $row['tanggal'] = $this->tanggal->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['idinvoice'] = $this->idinvoice->CurrentValue;
        $row['totaltagihan'] = $this->totaltagihan->CurrentValue;
        $row['sisatagihan'] = $this->sisatagihan->CurrentValue;
        $row['jumlahbayar'] = $this->jumlahbayar->CurrentValue;
        $row['idtipepayment'] = $this->idtipepayment->CurrentValue;
        $row['bukti'] = $this->bukti->Upload->DbValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['created_by'] = $this->created_by->CurrentValue;
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

        // kode

        // tanggal

        // idcustomer

        // idinvoice

        // totaltagihan

        // sisatagihan

        // jumlahbayar

        // idtipepayment

        // bukti

        // created_at

        // created_by
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
            $this->id->ViewCustomAttributes = "";

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // tanggal
            $this->tanggal->ViewValue = $this->tanggal->CurrentValue;
            $this->tanggal->ViewValue = FormatDateTime($this->tanggal->ViewValue, 0);
            $this->tanggal->ViewCustomAttributes = "";

            // idcustomer
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "id > 0";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // idinvoice
            $curVal = trim(strval($this->idinvoice->CurrentValue));
            if ($curVal != "") {
                $this->idinvoice->ViewValue = $this->idinvoice->lookupCacheOption($curVal);
                if ($this->idinvoice->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add") ? "aktif = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idinvoice->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idinvoice->Lookup->renderViewRow($rswrk[0]);
                        $this->idinvoice->ViewValue = $this->idinvoice->displayValue($arwrk);
                    } else {
                        $this->idinvoice->ViewValue = $this->idinvoice->CurrentValue;
                    }
                }
            } else {
                $this->idinvoice->ViewValue = null;
            }
            $this->idinvoice->ViewCustomAttributes = "";

            // totaltagihan
            $this->totaltagihan->ViewValue = $this->totaltagihan->CurrentValue;
            $this->totaltagihan->ViewValue = FormatCurrency($this->totaltagihan->ViewValue, 2, -2, -2, -2);
            $this->totaltagihan->ViewCustomAttributes = "";

            // sisatagihan
            $this->sisatagihan->ViewValue = $this->sisatagihan->CurrentValue;
            $this->sisatagihan->ViewValue = FormatCurrency($this->sisatagihan->ViewValue, 2, -2, -2, -2);
            $this->sisatagihan->ViewCustomAttributes = "";

            // jumlahbayar
            $this->jumlahbayar->ViewValue = $this->jumlahbayar->CurrentValue;
            $this->jumlahbayar->ViewValue = FormatCurrency($this->jumlahbayar->ViewValue, 2, -2, -2, -2);
            $this->jumlahbayar->ViewCustomAttributes = "";

            // idtipepayment
            $curVal = trim(strval($this->idtipepayment->CurrentValue));
            if ($curVal != "") {
                $this->idtipepayment->ViewValue = $this->idtipepayment->lookupCacheOption($curVal);
                if ($this->idtipepayment->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idtipepayment->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idtipepayment->Lookup->renderViewRow($rswrk[0]);
                        $this->idtipepayment->ViewValue = $this->idtipepayment->displayValue($arwrk);
                    } else {
                        $this->idtipepayment->ViewValue = $this->idtipepayment->CurrentValue;
                    }
                }
            } else {
                $this->idtipepayment->ViewValue = null;
            }
            $this->idtipepayment->ViewCustomAttributes = "";

            // bukti
            if (!EmptyValue($this->bukti->Upload->DbValue)) {
                $this->bukti->ViewValue = $this->bukti->Upload->DbValue;
            } else {
                $this->bukti->ViewValue = "";
            }
            $this->bukti->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // tanggal
            $this->tanggal->LinkCustomAttributes = "";
            $this->tanggal->HrefValue = "";
            $this->tanggal->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idinvoice
            $this->idinvoice->LinkCustomAttributes = "";
            $this->idinvoice->HrefValue = "";
            $this->idinvoice->TooltipValue = "";

            // totaltagihan
            $this->totaltagihan->LinkCustomAttributes = "";
            $this->totaltagihan->HrefValue = "";
            $this->totaltagihan->TooltipValue = "";

            // sisatagihan
            $this->sisatagihan->LinkCustomAttributes = "";
            $this->sisatagihan->HrefValue = "";
            $this->sisatagihan->TooltipValue = "";

            // jumlahbayar
            $this->jumlahbayar->LinkCustomAttributes = "";
            $this->jumlahbayar->HrefValue = "";
            $this->jumlahbayar->TooltipValue = "";

            // idtipepayment
            $this->idtipepayment->LinkCustomAttributes = "";
            $this->idtipepayment->HrefValue = "";
            $this->idtipepayment->TooltipValue = "";

            // bukti
            $this->bukti->LinkCustomAttributes = "";
            $this->bukti->HrefValue = "";
            $this->bukti->ExportHrefValue = $this->bukti->UploadPath . $this->bukti->Upload->DbValue;
            $this->bukti->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "readonly";
            if (!$this->kode->Raw) {
                $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
            }
            $this->kode->EditValue = HtmlEncode($this->kode->CurrentValue);
            $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

            // tanggal
            $this->tanggal->EditAttrs["class"] = "form-control";
            $this->tanggal->EditCustomAttributes = "";
            $this->tanggal->EditValue = HtmlEncode(FormatDateTime($this->tanggal->CurrentValue, 8));
            $this->tanggal->PlaceHolder = RemoveHtml($this->tanggal->caption());

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
            } else {
                $this->idcustomer->ViewValue = $this->idcustomer->Lookup !== null && is_array($this->idcustomer->Lookup->Options) ? $curVal : null;
            }
            if ($this->idcustomer->ViewValue !== null) { // Load from cache
                $this->idcustomer->EditValue = array_values($this->idcustomer->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idcustomer->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "id > 0";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idcustomer->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idcustomer->EditValue = $arwrk;
            }
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

            // idinvoice
            $this->idinvoice->EditAttrs["class"] = "form-control";
            $this->idinvoice->EditCustomAttributes = "";
            $curVal = trim(strval($this->idinvoice->CurrentValue));
            if ($curVal != "") {
                $this->idinvoice->ViewValue = $this->idinvoice->lookupCacheOption($curVal);
            } else {
                $this->idinvoice->ViewValue = $this->idinvoice->Lookup !== null && is_array($this->idinvoice->Lookup->Options) ? $curVal : null;
            }
            if ($this->idinvoice->ViewValue !== null) { // Load from cache
                $this->idinvoice->EditValue = array_values($this->idinvoice->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idinvoice->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentPageID() == "add") ? "aktif = 1" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idinvoice->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idinvoice->EditValue = $arwrk;
            }
            $this->idinvoice->PlaceHolder = RemoveHtml($this->idinvoice->caption());

            // totaltagihan
            $this->totaltagihan->EditAttrs["class"] = "form-control";
            $this->totaltagihan->EditCustomAttributes = "readonly";
            $this->totaltagihan->EditValue = HtmlEncode($this->totaltagihan->CurrentValue);
            $this->totaltagihan->PlaceHolder = RemoveHtml($this->totaltagihan->caption());

            // sisatagihan
            $this->sisatagihan->EditAttrs["class"] = "form-control";
            $this->sisatagihan->EditCustomAttributes = "readonly";
            $this->sisatagihan->EditValue = HtmlEncode($this->sisatagihan->CurrentValue);
            $this->sisatagihan->PlaceHolder = RemoveHtml($this->sisatagihan->caption());

            // jumlahbayar
            $this->jumlahbayar->EditAttrs["class"] = "form-control";
            $this->jumlahbayar->EditCustomAttributes = "";
            $this->jumlahbayar->EditValue = HtmlEncode($this->jumlahbayar->CurrentValue);
            $this->jumlahbayar->PlaceHolder = RemoveHtml($this->jumlahbayar->caption());

            // idtipepayment
            $this->idtipepayment->EditAttrs["class"] = "form-control";
            $this->idtipepayment->EditCustomAttributes = "";
            $curVal = trim(strval($this->idtipepayment->CurrentValue));
            if ($curVal != "") {
                $this->idtipepayment->ViewValue = $this->idtipepayment->lookupCacheOption($curVal);
            } else {
                $this->idtipepayment->ViewValue = $this->idtipepayment->Lookup !== null && is_array($this->idtipepayment->Lookup->Options) ? $curVal : null;
            }
            if ($this->idtipepayment->ViewValue !== null) { // Load from cache
                $this->idtipepayment->EditValue = array_values($this->idtipepayment->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idtipepayment->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idtipepayment->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idtipepayment->EditValue = $arwrk;
            }
            $this->idtipepayment->PlaceHolder = RemoveHtml($this->idtipepayment->caption());

            // bukti
            $this->bukti->EditAttrs["class"] = "form-control";
            $this->bukti->EditCustomAttributes = "";
            if (!EmptyValue($this->bukti->Upload->DbValue)) {
                $this->bukti->EditValue = $this->bukti->Upload->DbValue;
            } else {
                $this->bukti->EditValue = "";
            }
            if (!EmptyValue($this->bukti->CurrentValue)) {
                $this->bukti->Upload->FileName = $this->bukti->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->bukti);
            }

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->CurrentValue = CurrentUserID();

            // Add refer script

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";

            // tanggal
            $this->tanggal->LinkCustomAttributes = "";
            $this->tanggal->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // idinvoice
            $this->idinvoice->LinkCustomAttributes = "";
            $this->idinvoice->HrefValue = "";

            // totaltagihan
            $this->totaltagihan->LinkCustomAttributes = "";
            $this->totaltagihan->HrefValue = "";

            // sisatagihan
            $this->sisatagihan->LinkCustomAttributes = "";
            $this->sisatagihan->HrefValue = "";

            // jumlahbayar
            $this->jumlahbayar->LinkCustomAttributes = "";
            $this->jumlahbayar->HrefValue = "";

            // idtipepayment
            $this->idtipepayment->LinkCustomAttributes = "";
            $this->idtipepayment->HrefValue = "";

            // bukti
            $this->bukti->LinkCustomAttributes = "";
            $this->bukti->HrefValue = "";
            $this->bukti->ExportHrefValue = $this->bukti->UploadPath . $this->bukti->Upload->DbValue;

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
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
        if ($this->tanggal->Required) {
            if (!$this->tanggal->IsDetailKey && EmptyValue($this->tanggal->FormValue)) {
                $this->tanggal->addErrorMessage(str_replace("%s", $this->tanggal->caption(), $this->tanggal->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal->FormValue)) {
            $this->tanggal->addErrorMessage($this->tanggal->getErrorMessage(false));
        }
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if ($this->idinvoice->Required) {
            if (!$this->idinvoice->IsDetailKey && EmptyValue($this->idinvoice->FormValue)) {
                $this->idinvoice->addErrorMessage(str_replace("%s", $this->idinvoice->caption(), $this->idinvoice->RequiredErrorMessage));
            }
        }
        if ($this->totaltagihan->Required) {
            if (!$this->totaltagihan->IsDetailKey && EmptyValue($this->totaltagihan->FormValue)) {
                $this->totaltagihan->addErrorMessage(str_replace("%s", $this->totaltagihan->caption(), $this->totaltagihan->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->totaltagihan->FormValue)) {
            $this->totaltagihan->addErrorMessage($this->totaltagihan->getErrorMessage(false));
        }
        if ($this->sisatagihan->Required) {
            if (!$this->sisatagihan->IsDetailKey && EmptyValue($this->sisatagihan->FormValue)) {
                $this->sisatagihan->addErrorMessage(str_replace("%s", $this->sisatagihan->caption(), $this->sisatagihan->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->sisatagihan->FormValue)) {
            $this->sisatagihan->addErrorMessage($this->sisatagihan->getErrorMessage(false));
        }
        if ($this->jumlahbayar->Required) {
            if (!$this->jumlahbayar->IsDetailKey && EmptyValue($this->jumlahbayar->FormValue)) {
                $this->jumlahbayar->addErrorMessage(str_replace("%s", $this->jumlahbayar->caption(), $this->jumlahbayar->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahbayar->FormValue)) {
            $this->jumlahbayar->addErrorMessage($this->jumlahbayar->getErrorMessage(false));
        }
        if ($this->idtipepayment->Required) {
            if (!$this->idtipepayment->IsDetailKey && EmptyValue($this->idtipepayment->FormValue)) {
                $this->idtipepayment->addErrorMessage(str_replace("%s", $this->idtipepayment->caption(), $this->idtipepayment->RequiredErrorMessage));
            }
        }
        if ($this->bukti->Required) {
            if ($this->bukti->Upload->FileName == "" && !$this->bukti->Upload->KeepFile) {
                $this->bukti->addErrorMessage(str_replace("%s", $this->bukti->caption(), $this->bukti->RequiredErrorMessage));
            }
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
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
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // kode
        $this->kode->setDbValueDef($rsnew, $this->kode->CurrentValue, "", false);

        // tanggal
        $this->tanggal->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal->CurrentValue, 0), CurrentDate(), false);

        // idcustomer
        $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, 0, false);

        // idinvoice
        $this->idinvoice->setDbValueDef($rsnew, $this->idinvoice->CurrentValue, 0, false);

        // totaltagihan
        $this->totaltagihan->setDbValueDef($rsnew, $this->totaltagihan->CurrentValue, 0, false);

        // sisatagihan
        $this->sisatagihan->setDbValueDef($rsnew, $this->sisatagihan->CurrentValue, 0, false);

        // jumlahbayar
        $this->jumlahbayar->setDbValueDef($rsnew, $this->jumlahbayar->CurrentValue, 0, false);

        // idtipepayment
        $this->idtipepayment->setDbValueDef($rsnew, $this->idtipepayment->CurrentValue, 0, false);

        // bukti
        if ($this->bukti->Visible && !$this->bukti->Upload->KeepFile) {
            $this->bukti->Upload->DbValue = ""; // No need to delete old file
            if ($this->bukti->Upload->FileName == "") {
                $rsnew['bukti'] = null;
            } else {
                $rsnew['bukti'] = $this->bukti->Upload->FileName;
            }
        }

        // created_by
        $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, false);
        if ($this->bukti->Visible && !$this->bukti->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->bukti->Upload->DbValue) ? [] : [$this->bukti->htmlDecode($this->bukti->Upload->DbValue)];
            if (!EmptyValue($this->bukti->Upload->FileName)) {
                $newFiles = [$this->bukti->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->bukti, $this->bukti->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->bukti->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->bukti->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->bukti->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->bukti->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->bukti->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->bukti->setDbValueDef($rsnew, $this->bukti->Upload->FileName, null, false);
            }
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
                if ($this->bukti->Visible && !$this->bukti->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->bukti->Upload->DbValue) ? [] : [$this->bukti->htmlDecode($this->bukti->Upload->DbValue)];
                    if (!EmptyValue($this->bukti->Upload->FileName)) {
                        $newFiles = [$this->bukti->Upload->FileName];
                        $newFiles2 = [$this->bukti->htmlDecode($rsnew['bukti'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->bukti, $this->bukti->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->bukti->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->bukti->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
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
            // bukti
            CleanUploadTempPath($this->bukti, $this->bukti->Upload->Index);
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PembayaranList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                    $lookupFilter = function () {
                        return "id > 0";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idinvoice":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add") ? "aktif = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idtipepayment":
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
}
