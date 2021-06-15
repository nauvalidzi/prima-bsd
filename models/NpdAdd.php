<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdAdd extends Npd
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd';

    // Page object name
    public $PageObjName = "NpdAdd";

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

        // Table object (npd)
        if (!isset($GLOBALS["npd"]) || get_class($GLOBALS["npd"]) == PROJECT_NAMESPACE . "npd") {
            $GLOBALS["npd"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "NpdView") {
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
    public $DetailPages; // Detail pages object

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
        $this->statuskategori->setVisibility();
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->kodeorder->setVisibility();
        $this->idbrand->setVisibility();
        $this->nama->setVisibility();
        $this->idkategoribarang->setVisibility();
        $this->idjenisbarang->setVisibility();
        $this->idproduct_acuan->setVisibility();
        $this->idkualitasbarang->setVisibility();
        $this->kemasanbarang->setVisibility();
        $this->label->setVisibility();
        $this->bahan->setVisibility();
        $this->ukuran->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->harga->setVisibility();
        $this->tambahan->setVisibility();
        $this->orderperdana->setVisibility();
        $this->orderreguler->setVisibility();
        $this->status->setVisibility();
        $this->selesai->Visible = false;
        $this->idproduct->Visible = false;
        $this->created_at->Visible = false;
        $this->created_by->setVisibility();
        $this->readonly->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idbrand);
        $this->setupLookupOptions($this->idkategoribarang);
        $this->setupLookupOptions($this->idjenisbarang);
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->idkualitasbarang);

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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("NpdList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "NpdList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdView") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->statuskategori->CurrentValue = "Baru";
        $this->idpegawai->CurrentValue = CurrentUserID();
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->kodeorder->CurrentValue = null;
        $this->kodeorder->OldValue = $this->kodeorder->CurrentValue;
        $this->idbrand->CurrentValue = null;
        $this->idbrand->OldValue = $this->idbrand->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->idkategoribarang->CurrentValue = null;
        $this->idkategoribarang->OldValue = $this->idkategoribarang->CurrentValue;
        $this->idjenisbarang->CurrentValue = null;
        $this->idjenisbarang->OldValue = $this->idjenisbarang->CurrentValue;
        $this->idproduct_acuan->CurrentValue = null;
        $this->idproduct_acuan->OldValue = $this->idproduct_acuan->CurrentValue;
        $this->idkualitasbarang->CurrentValue = null;
        $this->idkualitasbarang->OldValue = $this->idkualitasbarang->CurrentValue;
        $this->kemasanbarang->CurrentValue = null;
        $this->kemasanbarang->OldValue = $this->kemasanbarang->CurrentValue;
        $this->label->CurrentValue = null;
        $this->label->OldValue = $this->label->CurrentValue;
        $this->bahan->CurrentValue = null;
        $this->bahan->OldValue = $this->bahan->CurrentValue;
        $this->ukuran->CurrentValue = null;
        $this->ukuran->OldValue = $this->ukuran->CurrentValue;
        $this->warna->CurrentValue = null;
        $this->warna->OldValue = $this->warna->CurrentValue;
        $this->parfum->CurrentValue = null;
        $this->parfum->OldValue = $this->parfum->CurrentValue;
        $this->harga->CurrentValue = null;
        $this->harga->OldValue = $this->harga->CurrentValue;
        $this->tambahan->CurrentValue = null;
        $this->tambahan->OldValue = $this->tambahan->CurrentValue;
        $this->orderperdana->CurrentValue = null;
        $this->orderperdana->OldValue = $this->orderperdana->CurrentValue;
        $this->orderreguler->CurrentValue = null;
        $this->orderreguler->OldValue = $this->orderreguler->CurrentValue;
        $this->status->CurrentValue = "Baru";
        $this->selesai->CurrentValue = 0;
        $this->idproduct->CurrentValue = null;
        $this->idproduct->OldValue = $this->idproduct->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
        $this->readonly->CurrentValue = 0;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'statuskategori' first before field var 'x_statuskategori'
        $val = $CurrentForm->hasValue("statuskategori") ? $CurrentForm->getValue("statuskategori") : $CurrentForm->getValue("x_statuskategori");
        if (!$this->statuskategori->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->statuskategori->Visible = false; // Disable update for API request
            } else {
                $this->statuskategori->setFormValue($val);
            }
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

        // Check field name 'idcustomer' first before field var 'x_idcustomer'
        $val = $CurrentForm->hasValue("idcustomer") ? $CurrentForm->getValue("idcustomer") : $CurrentForm->getValue("x_idcustomer");
        if (!$this->idcustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idcustomer->Visible = false; // Disable update for API request
            } else {
                $this->idcustomer->setFormValue($val);
            }
        }

        // Check field name 'kodeorder' first before field var 'x_kodeorder'
        $val = $CurrentForm->hasValue("kodeorder") ? $CurrentForm->getValue("kodeorder") : $CurrentForm->getValue("x_kodeorder");
        if (!$this->kodeorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodeorder->Visible = false; // Disable update for API request
            } else {
                $this->kodeorder->setFormValue($val);
            }
        }

        // Check field name 'idbrand' first before field var 'x_idbrand'
        $val = $CurrentForm->hasValue("idbrand") ? $CurrentForm->getValue("idbrand") : $CurrentForm->getValue("x_idbrand");
        if (!$this->idbrand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idbrand->Visible = false; // Disable update for API request
            } else {
                $this->idbrand->setFormValue($val);
            }
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

        // Check field name 'idkategoribarang' first before field var 'x_idkategoribarang'
        $val = $CurrentForm->hasValue("idkategoribarang") ? $CurrentForm->getValue("idkategoribarang") : $CurrentForm->getValue("x_idkategoribarang");
        if (!$this->idkategoribarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkategoribarang->Visible = false; // Disable update for API request
            } else {
                $this->idkategoribarang->setFormValue($val);
            }
        }

        // Check field name 'idjenisbarang' first before field var 'x_idjenisbarang'
        $val = $CurrentForm->hasValue("idjenisbarang") ? $CurrentForm->getValue("idjenisbarang") : $CurrentForm->getValue("x_idjenisbarang");
        if (!$this->idjenisbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idjenisbarang->Visible = false; // Disable update for API request
            } else {
                $this->idjenisbarang->setFormValue($val);
            }
        }

        // Check field name 'idproduct_acuan' first before field var 'x_idproduct_acuan'
        $val = $CurrentForm->hasValue("idproduct_acuan") ? $CurrentForm->getValue("idproduct_acuan") : $CurrentForm->getValue("x_idproduct_acuan");
        if (!$this->idproduct_acuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idproduct_acuan->Visible = false; // Disable update for API request
            } else {
                $this->idproduct_acuan->setFormValue($val);
            }
        }

        // Check field name 'idkualitasbarang' first before field var 'x_idkualitasbarang'
        $val = $CurrentForm->hasValue("idkualitasbarang") ? $CurrentForm->getValue("idkualitasbarang") : $CurrentForm->getValue("x_idkualitasbarang");
        if (!$this->idkualitasbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkualitasbarang->Visible = false; // Disable update for API request
            } else {
                $this->idkualitasbarang->setFormValue($val);
            }
        }

        // Check field name 'kemasanbarang' first before field var 'x_kemasanbarang'
        $val = $CurrentForm->hasValue("kemasanbarang") ? $CurrentForm->getValue("kemasanbarang") : $CurrentForm->getValue("x_kemasanbarang");
        if (!$this->kemasanbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanbarang->Visible = false; // Disable update for API request
            } else {
                $this->kemasanbarang->setFormValue($val);
            }
        }

        // Check field name 'label' first before field var 'x_label'
        $val = $CurrentForm->hasValue("label") ? $CurrentForm->getValue("label") : $CurrentForm->getValue("x_label");
        if (!$this->label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label->Visible = false; // Disable update for API request
            } else {
                $this->label->setFormValue($val);
            }
        }

        // Check field name 'bahan' first before field var 'x_bahan'
        $val = $CurrentForm->hasValue("bahan") ? $CurrentForm->getValue("bahan") : $CurrentForm->getValue("x_bahan");
        if (!$this->bahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahan->Visible = false; // Disable update for API request
            } else {
                $this->bahan->setFormValue($val);
            }
        }

        // Check field name 'ukuran' first before field var 'x_ukuran'
        $val = $CurrentForm->hasValue("ukuran") ? $CurrentForm->getValue("ukuran") : $CurrentForm->getValue("x_ukuran");
        if (!$this->ukuran->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran->Visible = false; // Disable update for API request
            } else {
                $this->ukuran->setFormValue($val);
            }
        }

        // Check field name 'warna' first before field var 'x_warna'
        $val = $CurrentForm->hasValue("warna") ? $CurrentForm->getValue("warna") : $CurrentForm->getValue("x_warna");
        if (!$this->warna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->warna->Visible = false; // Disable update for API request
            } else {
                $this->warna->setFormValue($val);
            }
        }

        // Check field name 'parfum' first before field var 'x_parfum'
        $val = $CurrentForm->hasValue("parfum") ? $CurrentForm->getValue("parfum") : $CurrentForm->getValue("x_parfum");
        if (!$this->parfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->parfum->Visible = false; // Disable update for API request
            } else {
                $this->parfum->setFormValue($val);
            }
        }

        // Check field name 'harga' first before field var 'x_harga'
        $val = $CurrentForm->hasValue("harga") ? $CurrentForm->getValue("harga") : $CurrentForm->getValue("x_harga");
        if (!$this->harga->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->harga->Visible = false; // Disable update for API request
            } else {
                $this->harga->setFormValue($val);
            }
        }

        // Check field name 'tambahan' first before field var 'x_tambahan'
        $val = $CurrentForm->hasValue("tambahan") ? $CurrentForm->getValue("tambahan") : $CurrentForm->getValue("x_tambahan");
        if (!$this->tambahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tambahan->Visible = false; // Disable update for API request
            } else {
                $this->tambahan->setFormValue($val);
            }
        }

        // Check field name 'orderperdana' first before field var 'x_orderperdana'
        $val = $CurrentForm->hasValue("orderperdana") ? $CurrentForm->getValue("orderperdana") : $CurrentForm->getValue("x_orderperdana");
        if (!$this->orderperdana->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orderperdana->Visible = false; // Disable update for API request
            } else {
                $this->orderperdana->setFormValue($val);
            }
        }

        // Check field name 'orderreguler' first before field var 'x_orderreguler'
        $val = $CurrentForm->hasValue("orderreguler") ? $CurrentForm->getValue("orderreguler") : $CurrentForm->getValue("x_orderreguler");
        if (!$this->orderreguler->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orderreguler->Visible = false; // Disable update for API request
            } else {
                $this->orderreguler->setFormValue($val);
            }
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->statuskategori->CurrentValue = $this->statuskategori->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->kodeorder->CurrentValue = $this->kodeorder->FormValue;
        $this->idbrand->CurrentValue = $this->idbrand->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->idkategoribarang->CurrentValue = $this->idkategoribarang->FormValue;
        $this->idjenisbarang->CurrentValue = $this->idjenisbarang->FormValue;
        $this->idproduct_acuan->CurrentValue = $this->idproduct_acuan->FormValue;
        $this->idkualitasbarang->CurrentValue = $this->idkualitasbarang->FormValue;
        $this->kemasanbarang->CurrentValue = $this->kemasanbarang->FormValue;
        $this->label->CurrentValue = $this->label->FormValue;
        $this->bahan->CurrentValue = $this->bahan->FormValue;
        $this->ukuran->CurrentValue = $this->ukuran->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->parfum->CurrentValue = $this->parfum->FormValue;
        $this->harga->CurrentValue = $this->harga->FormValue;
        $this->tambahan->CurrentValue = $this->tambahan->FormValue;
        $this->orderperdana->CurrentValue = $this->orderperdana->FormValue;
        $this->orderreguler->CurrentValue = $this->orderreguler->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
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
        $this->statuskategori->setDbValue($row['statuskategori']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->nama->setDbValue($row['nama']);
        $this->idkategoribarang->setDbValue($row['idkategoribarang']);
        $this->idjenisbarang->setDbValue($row['idjenisbarang']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->idkualitasbarang->setDbValue($row['idkualitasbarang']);
        $this->kemasanbarang->setDbValue($row['kemasanbarang']);
        $this->label->setDbValue($row['label']);
        $this->bahan->setDbValue($row['bahan']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->harga->setDbValue($row['harga']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderreguler->setDbValue($row['orderreguler']);
        $this->status->setDbValue($row['status']);
        $this->selesai->setDbValue($row['selesai']);
        $this->idproduct->setDbValue($row['idproduct']);
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
        $row['statuskategori'] = $this->statuskategori->CurrentValue;
        $row['idpegawai'] = $this->idpegawai->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['kodeorder'] = $this->kodeorder->CurrentValue;
        $row['idbrand'] = $this->idbrand->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['idkategoribarang'] = $this->idkategoribarang->CurrentValue;
        $row['idjenisbarang'] = $this->idjenisbarang->CurrentValue;
        $row['idproduct_acuan'] = $this->idproduct_acuan->CurrentValue;
        $row['idkualitasbarang'] = $this->idkualitasbarang->CurrentValue;
        $row['kemasanbarang'] = $this->kemasanbarang->CurrentValue;
        $row['label'] = $this->label->CurrentValue;
        $row['bahan'] = $this->bahan->CurrentValue;
        $row['ukuran'] = $this->ukuran->CurrentValue;
        $row['warna'] = $this->warna->CurrentValue;
        $row['parfum'] = $this->parfum->CurrentValue;
        $row['harga'] = $this->harga->CurrentValue;
        $row['tambahan'] = $this->tambahan->CurrentValue;
        $row['orderperdana'] = $this->orderperdana->CurrentValue;
        $row['orderreguler'] = $this->orderreguler->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['selesai'] = $this->selesai->CurrentValue;
        $row['idproduct'] = $this->idproduct->CurrentValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // statuskategori

        // idpegawai

        // idcustomer

        // kodeorder

        // idbrand

        // nama

        // idkategoribarang

        // idjenisbarang

        // idproduct_acuan

        // idkualitasbarang

        // kemasanbarang

        // label

        // bahan

        // ukuran

        // warna

        // parfum

        // harga

        // tambahan

        // orderperdana

        // orderreguler

        // status

        // selesai

        // idproduct

        // created_at

        // created_by

        // readonly
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // statuskategori
            if (strval($this->statuskategori->CurrentValue) != "") {
                $this->statuskategori->ViewValue = $this->statuskategori->optionCaption($this->statuskategori->CurrentValue);
            } else {
                $this->statuskategori->ViewValue = null;
            }
            $this->statuskategori->ViewCustomAttributes = "";

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

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // idbrand
            $curVal = trim(strval($this->idbrand->CurrentValue));
            if ($curVal != "") {
                $this->idbrand->ViewValue = $this->idbrand->lookupCacheOption($curVal);
                if ($this->idbrand->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // idkategoribarang
            $curVal = trim(strval($this->idkategoribarang->CurrentValue));
            if ($curVal != "") {
                $this->idkategoribarang->ViewValue = $this->idkategoribarang->lookupCacheOption($curVal);
                if ($this->idkategoribarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkategoribarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkategoribarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idkategoribarang->ViewValue = $this->idkategoribarang->displayValue($arwrk);
                    } else {
                        $this->idkategoribarang->ViewValue = $this->idkategoribarang->CurrentValue;
                    }
                }
            } else {
                $this->idkategoribarang->ViewValue = null;
            }
            $this->idkategoribarang->ViewCustomAttributes = "";

            // idjenisbarang
            $curVal = trim(strval($this->idjenisbarang->CurrentValue));
            if ($curVal != "") {
                $this->idjenisbarang->ViewValue = $this->idjenisbarang->lookupCacheOption($curVal);
                if ($this->idjenisbarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idjenisbarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idjenisbarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idjenisbarang->ViewValue = $this->idjenisbarang->displayValue($arwrk);
                    } else {
                        $this->idjenisbarang->ViewValue = $this->idjenisbarang->CurrentValue;
                    }
                }
            } else {
                $this->idjenisbarang->ViewValue = null;
            }
            $this->idjenisbarang->ViewCustomAttributes = "";

            // idproduct_acuan
            $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
            if ($curVal != "") {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
                if ($this->idproduct_acuan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idproduct_acuan->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idproduct_acuan->Lookup->renderViewRow($rswrk[0]);
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->displayValue($arwrk);
                    } else {
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->CurrentValue;
                    }
                }
            } else {
                $this->idproduct_acuan->ViewValue = null;
            }
            $this->idproduct_acuan->ViewCustomAttributes = "";

            // idkualitasbarang
            $curVal = trim(strval($this->idkualitasbarang->CurrentValue));
            if ($curVal != "") {
                $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->lookupCacheOption($curVal);
                if ($this->idkualitasbarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkualitasbarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkualitasbarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->displayValue($arwrk);
                    } else {
                        $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->CurrentValue;
                    }
                }
            } else {
                $this->idkualitasbarang->ViewValue = null;
            }
            $this->idkualitasbarang->ViewCustomAttributes = "";

            // kemasanbarang
            $this->kemasanbarang->ViewValue = $this->kemasanbarang->CurrentValue;
            $this->kemasanbarang->ViewCustomAttributes = "";

            // label
            $this->label->ViewValue = $this->label->CurrentValue;
            $this->label->ViewCustomAttributes = "";

            // bahan
            $this->bahan->ViewValue = $this->bahan->CurrentValue;
            $this->bahan->ViewCustomAttributes = "";

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $this->parfum->ViewValue = $this->parfum->CurrentValue;
            $this->parfum->ViewCustomAttributes = "";

            // harga
            $this->harga->ViewValue = $this->harga->CurrentValue;
            $this->harga->ViewValue = FormatCurrency($this->harga->ViewValue, 2, -2, -2, -2);
            $this->harga->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // orderperdana
            $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
            $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
            $this->orderperdana->ViewCustomAttributes = "";

            // orderreguler
            $this->orderreguler->ViewValue = $this->orderreguler->CurrentValue;
            $this->orderreguler->ViewValue = FormatNumber($this->orderreguler->ViewValue, 0, -2, -2, -2);
            $this->orderreguler->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

            // idproduct
            $this->idproduct->ViewValue = $this->idproduct->CurrentValue;
            $this->idproduct->ViewCustomAttributes = "";

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

            // statuskategori
            $this->statuskategori->LinkCustomAttributes = "";
            $this->statuskategori->HrefValue = "";
            $this->statuskategori->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";
            $this->idbrand->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // idkategoribarang
            $this->idkategoribarang->LinkCustomAttributes = "";
            $this->idkategoribarang->HrefValue = "";
            $this->idkategoribarang->TooltipValue = "";

            // idjenisbarang
            $this->idjenisbarang->LinkCustomAttributes = "";
            $this->idjenisbarang->HrefValue = "";
            $this->idjenisbarang->TooltipValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";
            $this->idproduct_acuan->TooltipValue = "";

            // idkualitasbarang
            $this->idkualitasbarang->LinkCustomAttributes = "";
            $this->idkualitasbarang->HrefValue = "";
            $this->idkualitasbarang->TooltipValue = "";

            // kemasanbarang
            $this->kemasanbarang->LinkCustomAttributes = "";
            $this->kemasanbarang->HrefValue = "";
            $this->kemasanbarang->TooltipValue = "";

            // label
            $this->label->LinkCustomAttributes = "";
            $this->label->HrefValue = "";
            $this->label->TooltipValue = "";

            // bahan
            $this->bahan->LinkCustomAttributes = "";
            $this->bahan->HrefValue = "";
            $this->bahan->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";
            $this->harga->TooltipValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";
            $this->tambahan->TooltipValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";
            $this->orderperdana->TooltipValue = "";

            // orderreguler
            $this->orderreguler->LinkCustomAttributes = "";
            $this->orderreguler->HrefValue = "";
            $this->orderreguler->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // statuskategori
            $this->statuskategori->EditAttrs["class"] = "form-control";
            $this->statuskategori->EditCustomAttributes = "";
            $this->statuskategori->EditValue = $this->statuskategori->options(true);
            $this->statuskategori->PlaceHolder = RemoveHtml($this->statuskategori->caption());

            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
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
                $sqlWrk = $this->idcustomer->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idcustomer->EditValue = $arwrk;
            }
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

            // kodeorder
            $this->kodeorder->EditAttrs["class"] = "form-control";
            $this->kodeorder->EditCustomAttributes = "readonly";
            if (!$this->kodeorder->Raw) {
                $this->kodeorder->CurrentValue = HtmlDecode($this->kodeorder->CurrentValue);
            }
            $this->kodeorder->EditValue = HtmlEncode($this->kodeorder->CurrentValue);
            $this->kodeorder->PlaceHolder = RemoveHtml($this->kodeorder->caption());

            // idbrand
            $this->idbrand->EditAttrs["class"] = "form-control";
            $this->idbrand->EditCustomAttributes = "";
            $curVal = trim(strval($this->idbrand->CurrentValue));
            if ($curVal != "") {
                $this->idbrand->ViewValue = $this->idbrand->lookupCacheOption($curVal);
            } else {
                $this->idbrand->ViewValue = $this->idbrand->Lookup !== null && is_array($this->idbrand->Lookup->Options) ? $curVal : null;
            }
            if ($this->idbrand->ViewValue !== null) { // Load from cache
                $this->idbrand->EditValue = array_values($this->idbrand->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idbrand->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idbrand->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idbrand->EditValue = $arwrk;
            }
            $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // idkategoribarang
            $this->idkategoribarang->EditAttrs["class"] = "form-control";
            $this->idkategoribarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkategoribarang->CurrentValue));
            if ($curVal != "") {
                $this->idkategoribarang->ViewValue = $this->idkategoribarang->lookupCacheOption($curVal);
            } else {
                $this->idkategoribarang->ViewValue = $this->idkategoribarang->Lookup !== null && is_array($this->idkategoribarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkategoribarang->ViewValue !== null) { // Load from cache
                $this->idkategoribarang->EditValue = array_values($this->idkategoribarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkategoribarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkategoribarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkategoribarang->EditValue = $arwrk;
            }
            $this->idkategoribarang->PlaceHolder = RemoveHtml($this->idkategoribarang->caption());

            // idjenisbarang
            $this->idjenisbarang->EditAttrs["class"] = "form-control";
            $this->idjenisbarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idjenisbarang->CurrentValue));
            if ($curVal != "") {
                $this->idjenisbarang->ViewValue = $this->idjenisbarang->lookupCacheOption($curVal);
            } else {
                $this->idjenisbarang->ViewValue = $this->idjenisbarang->Lookup !== null && is_array($this->idjenisbarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idjenisbarang->ViewValue !== null) { // Load from cache
                $this->idjenisbarang->EditValue = array_values($this->idjenisbarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idjenisbarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idjenisbarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idjenisbarang->EditValue = $arwrk;
            }
            $this->idjenisbarang->PlaceHolder = RemoveHtml($this->idjenisbarang->caption());

            // idproduct_acuan
            $this->idproduct_acuan->EditAttrs["class"] = "form-control";
            $this->idproduct_acuan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
            if ($curVal != "") {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
            } else {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->Lookup !== null && is_array($this->idproduct_acuan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idproduct_acuan->ViewValue !== null) { // Load from cache
                $this->idproduct_acuan->EditValue = array_values($this->idproduct_acuan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idproduct_acuan->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idproduct_acuan->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idproduct_acuan->EditValue = $arwrk;
            }
            $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

            // idkualitasbarang
            $this->idkualitasbarang->EditAttrs["class"] = "form-control";
            $this->idkualitasbarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkualitasbarang->CurrentValue));
            if ($curVal != "") {
                $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->lookupCacheOption($curVal);
            } else {
                $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->Lookup !== null && is_array($this->idkualitasbarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkualitasbarang->ViewValue !== null) { // Load from cache
                $this->idkualitasbarang->EditValue = array_values($this->idkualitasbarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkualitasbarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkualitasbarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkualitasbarang->EditValue = $arwrk;
            }
            $this->idkualitasbarang->PlaceHolder = RemoveHtml($this->idkualitasbarang->caption());

            // kemasanbarang
            $this->kemasanbarang->EditAttrs["class"] = "form-control";
            $this->kemasanbarang->EditCustomAttributes = "";
            $this->kemasanbarang->EditValue = HtmlEncode($this->kemasanbarang->CurrentValue);
            $this->kemasanbarang->PlaceHolder = RemoveHtml($this->kemasanbarang->caption());

            // label
            $this->label->EditAttrs["class"] = "form-control";
            $this->label->EditCustomAttributes = "";
            $this->label->EditValue = HtmlEncode($this->label->CurrentValue);
            $this->label->PlaceHolder = RemoveHtml($this->label->caption());

            // bahan
            $this->bahan->EditAttrs["class"] = "form-control";
            $this->bahan->EditCustomAttributes = "";
            if (!$this->bahan->Raw) {
                $this->bahan->CurrentValue = HtmlDecode($this->bahan->CurrentValue);
            }
            $this->bahan->EditValue = HtmlEncode($this->bahan->CurrentValue);
            $this->bahan->PlaceHolder = RemoveHtml($this->bahan->caption());

            // ukuran
            $this->ukuran->EditAttrs["class"] = "form-control";
            $this->ukuran->EditCustomAttributes = "";
            if (!$this->ukuran->Raw) {
                $this->ukuran->CurrentValue = HtmlDecode($this->ukuran->CurrentValue);
            }
            $this->ukuran->EditValue = HtmlEncode($this->ukuran->CurrentValue);
            $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

            // warna
            $this->warna->EditAttrs["class"] = "form-control";
            $this->warna->EditCustomAttributes = "";
            if (!$this->warna->Raw) {
                $this->warna->CurrentValue = HtmlDecode($this->warna->CurrentValue);
            }
            $this->warna->EditValue = HtmlEncode($this->warna->CurrentValue);
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // parfum
            $this->parfum->EditAttrs["class"] = "form-control";
            $this->parfum->EditCustomAttributes = "";
            if (!$this->parfum->Raw) {
                $this->parfum->CurrentValue = HtmlDecode($this->parfum->CurrentValue);
            }
            $this->parfum->EditValue = HtmlEncode($this->parfum->CurrentValue);
            $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

            // harga
            $this->harga->EditAttrs["class"] = "form-control";
            $this->harga->EditCustomAttributes = "";
            $this->harga->EditValue = HtmlEncode($this->harga->CurrentValue);
            $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());

            // tambahan
            $this->tambahan->EditAttrs["class"] = "form-control";
            $this->tambahan->EditCustomAttributes = "";
            $this->tambahan->EditValue = HtmlEncode($this->tambahan->CurrentValue);
            $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

            // orderperdana
            $this->orderperdana->EditAttrs["class"] = "form-control";
            $this->orderperdana->EditCustomAttributes = "";
            $this->orderperdana->EditValue = HtmlEncode($this->orderperdana->CurrentValue);
            $this->orderperdana->PlaceHolder = RemoveHtml($this->orderperdana->caption());

            // orderreguler
            $this->orderreguler->EditAttrs["class"] = "form-control";
            $this->orderreguler->EditCustomAttributes = "";
            $this->orderreguler->EditValue = HtmlEncode($this->orderreguler->CurrentValue);
            $this->orderreguler->PlaceHolder = RemoveHtml($this->orderreguler->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->CurrentValue = CurrentUserID();

            // Add refer script

            // statuskategori
            $this->statuskategori->LinkCustomAttributes = "";
            $this->statuskategori->HrefValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // idkategoribarang
            $this->idkategoribarang->LinkCustomAttributes = "";
            $this->idkategoribarang->HrefValue = "";

            // idjenisbarang
            $this->idjenisbarang->LinkCustomAttributes = "";
            $this->idjenisbarang->HrefValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";

            // idkualitasbarang
            $this->idkualitasbarang->LinkCustomAttributes = "";
            $this->idkualitasbarang->HrefValue = "";

            // kemasanbarang
            $this->kemasanbarang->LinkCustomAttributes = "";
            $this->kemasanbarang->HrefValue = "";

            // label
            $this->label->LinkCustomAttributes = "";
            $this->label->HrefValue = "";

            // bahan
            $this->bahan->LinkCustomAttributes = "";
            $this->bahan->HrefValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";

            // orderreguler
            $this->orderreguler->LinkCustomAttributes = "";
            $this->orderreguler->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

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
        if ($this->statuskategori->Required) {
            if (!$this->statuskategori->IsDetailKey && EmptyValue($this->statuskategori->FormValue)) {
                $this->statuskategori->addErrorMessage(str_replace("%s", $this->statuskategori->caption(), $this->statuskategori->RequiredErrorMessage));
            }
        }
        if ($this->idpegawai->Required) {
            if (!$this->idpegawai->IsDetailKey && EmptyValue($this->idpegawai->FormValue)) {
                $this->idpegawai->addErrorMessage(str_replace("%s", $this->idpegawai->caption(), $this->idpegawai->RequiredErrorMessage));
            }
        }
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if ($this->kodeorder->Required) {
            if (!$this->kodeorder->IsDetailKey && EmptyValue($this->kodeorder->FormValue)) {
                $this->kodeorder->addErrorMessage(str_replace("%s", $this->kodeorder->caption(), $this->kodeorder->RequiredErrorMessage));
            }
        }
        if ($this->idbrand->Required) {
            if (!$this->idbrand->IsDetailKey && EmptyValue($this->idbrand->FormValue)) {
                $this->idbrand->addErrorMessage(str_replace("%s", $this->idbrand->caption(), $this->idbrand->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->idkategoribarang->Required) {
            if (!$this->idkategoribarang->IsDetailKey && EmptyValue($this->idkategoribarang->FormValue)) {
                $this->idkategoribarang->addErrorMessage(str_replace("%s", $this->idkategoribarang->caption(), $this->idkategoribarang->RequiredErrorMessage));
            }
        }
        if ($this->idjenisbarang->Required) {
            if (!$this->idjenisbarang->IsDetailKey && EmptyValue($this->idjenisbarang->FormValue)) {
                $this->idjenisbarang->addErrorMessage(str_replace("%s", $this->idjenisbarang->caption(), $this->idjenisbarang->RequiredErrorMessage));
            }
        }
        if ($this->idproduct_acuan->Required) {
            if (!$this->idproduct_acuan->IsDetailKey && EmptyValue($this->idproduct_acuan->FormValue)) {
                $this->idproduct_acuan->addErrorMessage(str_replace("%s", $this->idproduct_acuan->caption(), $this->idproduct_acuan->RequiredErrorMessage));
            }
        }
        if ($this->idkualitasbarang->Required) {
            if (!$this->idkualitasbarang->IsDetailKey && EmptyValue($this->idkualitasbarang->FormValue)) {
                $this->idkualitasbarang->addErrorMessage(str_replace("%s", $this->idkualitasbarang->caption(), $this->idkualitasbarang->RequiredErrorMessage));
            }
        }
        if ($this->kemasanbarang->Required) {
            if (!$this->kemasanbarang->IsDetailKey && EmptyValue($this->kemasanbarang->FormValue)) {
                $this->kemasanbarang->addErrorMessage(str_replace("%s", $this->kemasanbarang->caption(), $this->kemasanbarang->RequiredErrorMessage));
            }
        }
        if ($this->label->Required) {
            if (!$this->label->IsDetailKey && EmptyValue($this->label->FormValue)) {
                $this->label->addErrorMessage(str_replace("%s", $this->label->caption(), $this->label->RequiredErrorMessage));
            }
        }
        if ($this->bahan->Required) {
            if (!$this->bahan->IsDetailKey && EmptyValue($this->bahan->FormValue)) {
                $this->bahan->addErrorMessage(str_replace("%s", $this->bahan->caption(), $this->bahan->RequiredErrorMessage));
            }
        }
        if ($this->ukuran->Required) {
            if (!$this->ukuran->IsDetailKey && EmptyValue($this->ukuran->FormValue)) {
                $this->ukuran->addErrorMessage(str_replace("%s", $this->ukuran->caption(), $this->ukuran->RequiredErrorMessage));
            }
        }
        if ($this->warna->Required) {
            if (!$this->warna->IsDetailKey && EmptyValue($this->warna->FormValue)) {
                $this->warna->addErrorMessage(str_replace("%s", $this->warna->caption(), $this->warna->RequiredErrorMessage));
            }
        }
        if ($this->parfum->Required) {
            if (!$this->parfum->IsDetailKey && EmptyValue($this->parfum->FormValue)) {
                $this->parfum->addErrorMessage(str_replace("%s", $this->parfum->caption(), $this->parfum->RequiredErrorMessage));
            }
        }
        if ($this->harga->Required) {
            if (!$this->harga->IsDetailKey && EmptyValue($this->harga->FormValue)) {
                $this->harga->addErrorMessage(str_replace("%s", $this->harga->caption(), $this->harga->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->harga->FormValue)) {
            $this->harga->addErrorMessage($this->harga->getErrorMessage(false));
        }
        if ($this->tambahan->Required) {
            if (!$this->tambahan->IsDetailKey && EmptyValue($this->tambahan->FormValue)) {
                $this->tambahan->addErrorMessage(str_replace("%s", $this->tambahan->caption(), $this->tambahan->RequiredErrorMessage));
            }
        }
        if ($this->orderperdana->Required) {
            if (!$this->orderperdana->IsDetailKey && EmptyValue($this->orderperdana->FormValue)) {
                $this->orderperdana->addErrorMessage(str_replace("%s", $this->orderperdana->caption(), $this->orderperdana->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->orderperdana->FormValue)) {
            $this->orderperdana->addErrorMessage($this->orderperdana->getErrorMessage(false));
        }
        if ($this->orderreguler->Required) {
            if (!$this->orderreguler->IsDetailKey && EmptyValue($this->orderreguler->FormValue)) {
                $this->orderreguler->addErrorMessage(str_replace("%s", $this->orderreguler->caption(), $this->orderreguler->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->orderreguler->FormValue)) {
            $this->orderreguler->addErrorMessage($this->orderreguler->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("NpdStatusGrid");
        if (in_array("npd_status", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdSampleGrid");
        if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdReviewGrid");
        if (in_array("npd_review", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdConfirmGrid");
        if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdHargaGrid");
        if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // statuskategori
        $this->statuskategori->setDbValueDef($rsnew, $this->statuskategori->CurrentValue, "", strval($this->statuskategori->CurrentValue) == "");

        // idpegawai
        $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, 0, false);

        // idcustomer
        $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, 0, false);

        // kodeorder
        $this->kodeorder->setDbValueDef($rsnew, $this->kodeorder->CurrentValue, "", false);

        // idbrand
        $this->idbrand->setDbValueDef($rsnew, $this->idbrand->CurrentValue, 0, false);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", false);

        // idkategoribarang
        $this->idkategoribarang->setDbValueDef($rsnew, $this->idkategoribarang->CurrentValue, 0, false);

        // idjenisbarang
        $this->idjenisbarang->setDbValueDef($rsnew, $this->idjenisbarang->CurrentValue, 0, false);

        // idproduct_acuan
        $this->idproduct_acuan->setDbValueDef($rsnew, $this->idproduct_acuan->CurrentValue, 0, false);

        // idkualitasbarang
        $this->idkualitasbarang->setDbValueDef($rsnew, $this->idkualitasbarang->CurrentValue, 0, false);

        // kemasanbarang
        $this->kemasanbarang->setDbValueDef($rsnew, $this->kemasanbarang->CurrentValue, "", false);

        // label
        $this->label->setDbValueDef($rsnew, $this->label->CurrentValue, "", false);

        // bahan
        $this->bahan->setDbValueDef($rsnew, $this->bahan->CurrentValue, "", false);

        // ukuran
        $this->ukuran->setDbValueDef($rsnew, $this->ukuran->CurrentValue, "", false);

        // warna
        $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, "", false);

        // parfum
        $this->parfum->setDbValueDef($rsnew, $this->parfum->CurrentValue, "", false);

        // harga
        $this->harga->setDbValueDef($rsnew, $this->harga->CurrentValue, 0, false);

        // tambahan
        $this->tambahan->setDbValueDef($rsnew, $this->tambahan->CurrentValue, null, false);

        // orderperdana
        $this->orderperdana->setDbValueDef($rsnew, $this->orderperdana->CurrentValue, null, false);

        // orderreguler
        $this->orderreguler->setDbValueDef($rsnew, $this->orderreguler->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", false);

        // created_by
        $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, false);

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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("NpdStatusGrid");
            if (in_array("npd_status", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_status"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdSampleGrid");
            if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_sample"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdReviewGrid");
            if (in_array("npd_review", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_review"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdConfirmGrid");
            if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_confirm"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdHargaGrid");
            if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_harga"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
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

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("npd_status", $detailTblVar)) {
                $detailPageObj = Container("NpdStatusGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_sample", $detailTblVar)) {
                $detailPageObj = Container("NpdSampleGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                    $detailPageObj->idserahterima->setSessionValue(""); // Clear session key
                }
            }
            if (in_array("npd_review", $detailTblVar)) {
                $detailPageObj = Container("NpdReviewGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_confirm", $detailTblVar)) {
                $detailPageObj = Container("NpdConfirmGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_harga", $detailTblVar)) {
                $detailPageObj = Container("NpdHargaGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('npd_status');
        $pages->add('npd_sample');
        $pages->add('npd_review');
        $pages->add('npd_confirm');
        $pages->add('npd_harga');
        $this->DetailPages = $pages;
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
                case "x_statuskategori":
                    break;
                case "x_idpegawai":
                    break;
                case "x_idcustomer":
                    break;
                case "x_idbrand":
                    break;
                case "x_idkategoribarang":
                    break;
                case "x_idjenisbarang":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idkualitasbarang":
                    break;
                case "x_selesai":
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
        $this->warna->CustomMsg = "Gelap / Terang / Transparan / Opaq / Lainnya";
        $this->label->CustomMsg = "Transparan / Vynil";
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
