<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class ProductEdit extends Product
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'product';

    // Page object name
    public $PageObjName = "ProductEdit";

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

        // Table object (product)
        if (!isset($GLOBALS["product"]) || get_class($GLOBALS["product"]) == PROJECT_NAMESPACE . "product") {
            $GLOBALS["product"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'product');
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
                $doc = new $class(Container("product"));
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
                    if ($pageName == "ProductView") {
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
        $this->id->Visible = false;
        $this->idbrand->setVisibility();
        $this->kode->setVisibility();
        $this->nama->setVisibility();
        $this->idkategoribarang->setVisibility();
        $this->idjenisbarang->setVisibility();
        $this->idkualitasbarang->setVisibility();
        $this->idproduct_acuan->setVisibility();
        $this->ukuran->setVisibility();
        $this->netto->Visible = false;
        $this->kemasanbarang->setVisibility();
        $this->satuan->Visible = false;
        $this->harga->setVisibility();
        $this->bahan->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->label->setVisibility();
        $this->foto->setVisibility();
        $this->tambahan->setVisibility();
        $this->ijinbpom->setVisibility();
        $this->aktif->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
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
        $this->setupLookupOptions($this->idbrand);
        $this->setupLookupOptions($this->idkategoribarang);
        $this->setupLookupOptions($this->idjenisbarang);
        $this->setupLookupOptions($this->idproduct_acuan);

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

            // Set up master detail parameters
            $this->setupMasterParms();

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
                    $this->terminate("ProductList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ProductList") {
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
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idbrand' first before field var 'x_idbrand'
        $val = $CurrentForm->hasValue("idbrand") ? $CurrentForm->getValue("idbrand") : $CurrentForm->getValue("x_idbrand");
        if (!$this->idbrand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idbrand->Visible = false; // Disable update for API request
            } else {
                $this->idbrand->setFormValue($val);
            }
        }

        // Check field name 'kode' first before field var 'x_kode'
        $val = $CurrentForm->hasValue("kode") ? $CurrentForm->getValue("kode") : $CurrentForm->getValue("x_kode");
        if (!$this->kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode->Visible = false; // Disable update for API request
            } else {
                $this->kode->setFormValue($val);
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

        // Check field name 'idkualitasbarang' first before field var 'x_idkualitasbarang'
        $val = $CurrentForm->hasValue("idkualitasbarang") ? $CurrentForm->getValue("idkualitasbarang") : $CurrentForm->getValue("x_idkualitasbarang");
        if (!$this->idkualitasbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkualitasbarang->Visible = false; // Disable update for API request
            } else {
                $this->idkualitasbarang->setFormValue($val);
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

        // Check field name 'ukuran' first before field var 'x_ukuran'
        $val = $CurrentForm->hasValue("ukuran") ? $CurrentForm->getValue("ukuran") : $CurrentForm->getValue("x_ukuran");
        if (!$this->ukuran->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran->Visible = false; // Disable update for API request
            } else {
                $this->ukuran->setFormValue($val);
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

        // Check field name 'harga' first before field var 'x_harga'
        $val = $CurrentForm->hasValue("harga") ? $CurrentForm->getValue("harga") : $CurrentForm->getValue("x_harga");
        if (!$this->harga->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->harga->Visible = false; // Disable update for API request
            } else {
                $this->harga->setFormValue($val);
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

        // Check field name 'label' first before field var 'x_label'
        $val = $CurrentForm->hasValue("label") ? $CurrentForm->getValue("label") : $CurrentForm->getValue("x_label");
        if (!$this->label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label->Visible = false; // Disable update for API request
            } else {
                $this->label->setFormValue($val);
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

        // Check field name 'ijinbpom' first before field var 'x_ijinbpom'
        $val = $CurrentForm->hasValue("ijinbpom") ? $CurrentForm->getValue("ijinbpom") : $CurrentForm->getValue("x_ijinbpom");
        if (!$this->ijinbpom->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ijinbpom->Visible = false; // Disable update for API request
            } else {
                $this->ijinbpom->setFormValue($val);
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->idbrand->CurrentValue = $this->idbrand->FormValue;
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->idkategoribarang->CurrentValue = $this->idkategoribarang->FormValue;
        $this->idjenisbarang->CurrentValue = $this->idjenisbarang->FormValue;
        $this->idkualitasbarang->CurrentValue = $this->idkualitasbarang->FormValue;
        $this->idproduct_acuan->CurrentValue = $this->idproduct_acuan->FormValue;
        $this->ukuran->CurrentValue = $this->ukuran->FormValue;
        $this->kemasanbarang->CurrentValue = $this->kemasanbarang->FormValue;
        $this->harga->CurrentValue = $this->harga->FormValue;
        $this->bahan->CurrentValue = $this->bahan->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->parfum->CurrentValue = $this->parfum->FormValue;
        $this->label->CurrentValue = $this->label->FormValue;
        $this->tambahan->CurrentValue = $this->tambahan->FormValue;
        $this->ijinbpom->CurrentValue = $this->ijinbpom->FormValue;
        $this->aktif->CurrentValue = $this->aktif->FormValue;
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
        $this->idbrand->setDbValue($row['idbrand']);
        $this->kode->setDbValue($row['kode']);
        $this->nama->setDbValue($row['nama']);
        $this->idkategoribarang->setDbValue($row['idkategoribarang']);
        $this->idjenisbarang->setDbValue($row['idjenisbarang']);
        $this->idkualitasbarang->setDbValue($row['idkualitasbarang']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->netto->setDbValue($row['netto']);
        $this->kemasanbarang->setDbValue($row['kemasanbarang']);
        $this->satuan->setDbValue($row['satuan']);
        $this->harga->setDbValue($row['harga']);
        $this->bahan->setDbValue($row['bahan']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->label->setDbValue($row['label']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ijinbpom->setDbValue($row['ijinbpom']);
        $this->aktif->setDbValue($row['aktif']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idbrand'] = null;
        $row['kode'] = null;
        $row['nama'] = null;
        $row['idkategoribarang'] = null;
        $row['idjenisbarang'] = null;
        $row['idkualitasbarang'] = null;
        $row['idproduct_acuan'] = null;
        $row['ukuran'] = null;
        $row['netto'] = null;
        $row['kemasanbarang'] = null;
        $row['satuan'] = null;
        $row['harga'] = null;
        $row['bahan'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['label'] = null;
        $row['foto'] = null;
        $row['tambahan'] = null;
        $row['ijinbpom'] = null;
        $row['aktif'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
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

        // idbrand

        // kode

        // nama

        // idkategoribarang

        // idjenisbarang

        // idkualitasbarang

        // idproduct_acuan

        // ukuran

        // netto

        // kemasanbarang

        // satuan

        // harga

        // bahan

        // warna

        // parfum

        // label

        // foto

        // tambahan

        // ijinbpom

        // aktif

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

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

            // idkualitasbarang
            $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->CurrentValue;
            $this->idkualitasbarang->ViewValue = FormatNumber($this->idkualitasbarang->ViewValue, 0, -2, -2, -2);
            $this->idkualitasbarang->ViewCustomAttributes = "";

            // idproduct_acuan
            $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
            if ($curVal != "") {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
                if ($this->idproduct_acuan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add") ? "idbrand > 1" : "";
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

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewCustomAttributes = "";

            // kemasanbarang
            $this->kemasanbarang->ViewValue = $this->kemasanbarang->CurrentValue;
            $this->kemasanbarang->ViewCustomAttributes = "";

            // harga
            $this->harga->ViewValue = $this->harga->CurrentValue;
            $this->harga->ViewValue = FormatCurrency($this->harga->ViewValue, 2, -2, -2, -2);
            $this->harga->ViewCustomAttributes = "";

            // bahan
            $this->bahan->ViewValue = $this->bahan->CurrentValue;
            $this->bahan->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $this->parfum->ViewValue = $this->parfum->CurrentValue;
            $this->parfum->ViewCustomAttributes = "";

            // label
            $this->label->ViewValue = $this->label->CurrentValue;
            $this->label->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // ijinbpom
            if (strval($this->ijinbpom->CurrentValue) != "") {
                $this->ijinbpom->ViewValue = $this->ijinbpom->optionCaption($this->ijinbpom->CurrentValue);
            } else {
                $this->ijinbpom->ViewValue = null;
            }
            $this->ijinbpom->ViewCustomAttributes = "";

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
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 11);
            $this->updated_at->ViewCustomAttributes = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";
            $this->idbrand->TooltipValue = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

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

            // idkualitasbarang
            $this->idkualitasbarang->LinkCustomAttributes = "";
            $this->idkualitasbarang->HrefValue = "";
            $this->idkualitasbarang->TooltipValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";
            $this->idproduct_acuan->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";

            // kemasanbarang
            $this->kemasanbarang->LinkCustomAttributes = "";
            $this->kemasanbarang->HrefValue = "";
            $this->kemasanbarang->TooltipValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";
            $this->harga->TooltipValue = "";

            // bahan
            $this->bahan->LinkCustomAttributes = "";
            $this->bahan->HrefValue = "";
            $this->bahan->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // label
            $this->label->LinkCustomAttributes = "";
            $this->label->HrefValue = "";
            $this->label->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";
            $this->tambahan->TooltipValue = "";

            // ijinbpom
            $this->ijinbpom->LinkCustomAttributes = "";
            $this->ijinbpom->HrefValue = "";
            $this->ijinbpom->TooltipValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";
            $this->aktif->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // idbrand
            $this->idbrand->EditAttrs["class"] = "form-control";
            $this->idbrand->EditCustomAttributes = "";
            if ($this->idbrand->getSessionValue() != "") {
                $this->idbrand->CurrentValue = GetForeignKeyValue($this->idbrand->getSessionValue());
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
            } else {
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
            }

            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "";
            if (!$this->kode->Raw) {
                $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
            }
            $this->kode->EditValue = HtmlEncode($this->kode->CurrentValue);
            $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

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

            // idkualitasbarang
            $this->idkualitasbarang->EditAttrs["class"] = "form-control";
            $this->idkualitasbarang->EditCustomAttributes = "";
            $this->idkualitasbarang->EditValue = HtmlEncode($this->idkualitasbarang->CurrentValue);
            $this->idkualitasbarang->PlaceHolder = RemoveHtml($this->idkualitasbarang->caption());

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
                    return (CurrentPageID() == "add") ? "idbrand > 1" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idproduct_acuan->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idproduct_acuan->EditValue = $arwrk;
            }
            $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

            // ukuran
            $this->ukuran->EditAttrs["class"] = "form-control";
            $this->ukuran->EditCustomAttributes = "";
            if (!$this->ukuran->Raw) {
                $this->ukuran->CurrentValue = HtmlDecode($this->ukuran->CurrentValue);
            }
            $this->ukuran->EditValue = HtmlEncode($this->ukuran->CurrentValue);
            $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

            // kemasanbarang
            $this->kemasanbarang->EditAttrs["class"] = "form-control";
            $this->kemasanbarang->EditCustomAttributes = "";
            if (!$this->kemasanbarang->Raw) {
                $this->kemasanbarang->CurrentValue = HtmlDecode($this->kemasanbarang->CurrentValue);
            }
            $this->kemasanbarang->EditValue = HtmlEncode($this->kemasanbarang->CurrentValue);
            $this->kemasanbarang->PlaceHolder = RemoveHtml($this->kemasanbarang->caption());

            // harga
            $this->harga->EditAttrs["class"] = "form-control";
            $this->harga->EditCustomAttributes = "";
            $this->harga->EditValue = HtmlEncode($this->harga->CurrentValue);
            $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());

            // bahan
            $this->bahan->EditAttrs["class"] = "form-control";
            $this->bahan->EditCustomAttributes = "";
            if (!$this->bahan->Raw) {
                $this->bahan->CurrentValue = HtmlDecode($this->bahan->CurrentValue);
            }
            $this->bahan->EditValue = HtmlEncode($this->bahan->CurrentValue);
            $this->bahan->PlaceHolder = RemoveHtml($this->bahan->caption());

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

            // label
            $this->label->EditAttrs["class"] = "form-control";
            $this->label->EditCustomAttributes = "";
            if (!$this->label->Raw) {
                $this->label->CurrentValue = HtmlDecode($this->label->CurrentValue);
            }
            $this->label->EditValue = HtmlEncode($this->label->CurrentValue);
            $this->label->PlaceHolder = RemoveHtml($this->label->caption());

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->foto->CurrentValue)) {
                $this->foto->Upload->FileName = $this->foto->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->foto);
            }

            // tambahan
            $this->tambahan->EditAttrs["class"] = "form-control";
            $this->tambahan->EditCustomAttributes = "";
            $this->tambahan->EditValue = HtmlEncode($this->tambahan->CurrentValue);
            $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

            // ijinbpom
            $this->ijinbpom->EditCustomAttributes = "";
            $this->ijinbpom->EditValue = $this->ijinbpom->options(false);
            $this->ijinbpom->PlaceHolder = RemoveHtml($this->ijinbpom->caption());

            // aktif
            $this->aktif->EditCustomAttributes = "";
            $this->aktif->EditValue = $this->aktif->options(false);
            $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

            // Edit refer script

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // idkategoribarang
            $this->idkategoribarang->LinkCustomAttributes = "";
            $this->idkategoribarang->HrefValue = "";

            // idjenisbarang
            $this->idjenisbarang->LinkCustomAttributes = "";
            $this->idjenisbarang->HrefValue = "";

            // idkualitasbarang
            $this->idkualitasbarang->LinkCustomAttributes = "";
            $this->idkualitasbarang->HrefValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";

            // kemasanbarang
            $this->kemasanbarang->LinkCustomAttributes = "";
            $this->kemasanbarang->HrefValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";

            // bahan
            $this->bahan->LinkCustomAttributes = "";
            $this->bahan->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";

            // label
            $this->label->LinkCustomAttributes = "";
            $this->label->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";

            // ijinbpom
            $this->ijinbpom->LinkCustomAttributes = "";
            $this->ijinbpom->HrefValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";
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
        if ($this->idbrand->Required) {
            if (!$this->idbrand->IsDetailKey && EmptyValue($this->idbrand->FormValue)) {
                $this->idbrand->addErrorMessage(str_replace("%s", $this->idbrand->caption(), $this->idbrand->RequiredErrorMessage));
            }
        }
        if ($this->kode->Required) {
            if (!$this->kode->IsDetailKey && EmptyValue($this->kode->FormValue)) {
                $this->kode->addErrorMessage(str_replace("%s", $this->kode->caption(), $this->kode->RequiredErrorMessage));
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
        if ($this->idkualitasbarang->Required) {
            if (!$this->idkualitasbarang->IsDetailKey && EmptyValue($this->idkualitasbarang->FormValue)) {
                $this->idkualitasbarang->addErrorMessage(str_replace("%s", $this->idkualitasbarang->caption(), $this->idkualitasbarang->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idkualitasbarang->FormValue)) {
            $this->idkualitasbarang->addErrorMessage($this->idkualitasbarang->getErrorMessage(false));
        }
        if ($this->idproduct_acuan->Required) {
            if (!$this->idproduct_acuan->IsDetailKey && EmptyValue($this->idproduct_acuan->FormValue)) {
                $this->idproduct_acuan->addErrorMessage(str_replace("%s", $this->idproduct_acuan->caption(), $this->idproduct_acuan->RequiredErrorMessage));
            }
        }
        if ($this->ukuran->Required) {
            if (!$this->ukuran->IsDetailKey && EmptyValue($this->ukuran->FormValue)) {
                $this->ukuran->addErrorMessage(str_replace("%s", $this->ukuran->caption(), $this->ukuran->RequiredErrorMessage));
            }
        }
        if ($this->kemasanbarang->Required) {
            if (!$this->kemasanbarang->IsDetailKey && EmptyValue($this->kemasanbarang->FormValue)) {
                $this->kemasanbarang->addErrorMessage(str_replace("%s", $this->kemasanbarang->caption(), $this->kemasanbarang->RequiredErrorMessage));
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
        if ($this->bahan->Required) {
            if (!$this->bahan->IsDetailKey && EmptyValue($this->bahan->FormValue)) {
                $this->bahan->addErrorMessage(str_replace("%s", $this->bahan->caption(), $this->bahan->RequiredErrorMessage));
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
        if ($this->label->Required) {
            if (!$this->label->IsDetailKey && EmptyValue($this->label->FormValue)) {
                $this->label->addErrorMessage(str_replace("%s", $this->label->caption(), $this->label->RequiredErrorMessage));
            }
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->tambahan->Required) {
            if (!$this->tambahan->IsDetailKey && EmptyValue($this->tambahan->FormValue)) {
                $this->tambahan->addErrorMessage(str_replace("%s", $this->tambahan->caption(), $this->tambahan->RequiredErrorMessage));
            }
        }
        if ($this->ijinbpom->Required) {
            if ($this->ijinbpom->FormValue == "") {
                $this->ijinbpom->addErrorMessage(str_replace("%s", $this->ijinbpom->caption(), $this->ijinbpom->RequiredErrorMessage));
            }
        }
        if ($this->aktif->Required) {
            if ($this->aktif->FormValue == "") {
                $this->aktif->addErrorMessage(str_replace("%s", $this->aktif->caption(), $this->aktif->RequiredErrorMessage));
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

            // idbrand
            if ($this->idbrand->getSessionValue() != "") {
                $this->idbrand->ReadOnly = true;
            }
            $this->idbrand->setDbValueDef($rsnew, $this->idbrand->CurrentValue, 0, $this->idbrand->ReadOnly);

            // kode
            $this->kode->setDbValueDef($rsnew, $this->kode->CurrentValue, "", $this->kode->ReadOnly);

            // nama
            $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

            // idkategoribarang
            $this->idkategoribarang->setDbValueDef($rsnew, $this->idkategoribarang->CurrentValue, null, $this->idkategoribarang->ReadOnly);

            // idjenisbarang
            $this->idjenisbarang->setDbValueDef($rsnew, $this->idjenisbarang->CurrentValue, null, $this->idjenisbarang->ReadOnly);

            // idkualitasbarang
            $this->idkualitasbarang->setDbValueDef($rsnew, $this->idkualitasbarang->CurrentValue, null, $this->idkualitasbarang->ReadOnly);

            // idproduct_acuan
            $this->idproduct_acuan->setDbValueDef($rsnew, $this->idproduct_acuan->CurrentValue, null, $this->idproduct_acuan->ReadOnly);

            // ukuran
            $this->ukuran->setDbValueDef($rsnew, $this->ukuran->CurrentValue, null, $this->ukuran->ReadOnly);

            // kemasanbarang
            $this->kemasanbarang->setDbValueDef($rsnew, $this->kemasanbarang->CurrentValue, null, $this->kemasanbarang->ReadOnly);

            // harga
            $this->harga->setDbValueDef($rsnew, $this->harga->CurrentValue, null, $this->harga->ReadOnly);

            // bahan
            $this->bahan->setDbValueDef($rsnew, $this->bahan->CurrentValue, null, $this->bahan->ReadOnly);

            // warna
            $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, null, $this->warna->ReadOnly);

            // parfum
            $this->parfum->setDbValueDef($rsnew, $this->parfum->CurrentValue, null, $this->parfum->ReadOnly);

            // label
            $this->label->setDbValueDef($rsnew, $this->label->CurrentValue, null, $this->label->ReadOnly);

            // foto
            if ($this->foto->Visible && !$this->foto->ReadOnly && !$this->foto->Upload->KeepFile) {
                $this->foto->Upload->DbValue = $rsold['foto']; // Get original value
                if ($this->foto->Upload->FileName == "") {
                    $rsnew['foto'] = null;
                } else {
                    $rsnew['foto'] = $this->foto->Upload->FileName;
                }
            }

            // tambahan
            $this->tambahan->setDbValueDef($rsnew, $this->tambahan->CurrentValue, null, $this->tambahan->ReadOnly);

            // ijinbpom
            $this->ijinbpom->setDbValueDef($rsnew, $this->ijinbpom->CurrentValue, null, $this->ijinbpom->ReadOnly);

            // aktif
            $this->aktif->setDbValueDef($rsnew, $this->aktif->CurrentValue, null, $this->aktif->ReadOnly);

            // Check referential integrity for master table 'brand'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_brand();
            $keyValue = $rsnew['idbrand'] ?? $rsold['idbrand'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("brand")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "brand", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }
            if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : [$this->foto->htmlDecode($this->foto->Upload->DbValue)];
                if (!EmptyValue($this->foto->Upload->FileName)) {
                    $newFiles = [$this->foto->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->foto, $this->foto->Upload->Index);
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
                                $file1 = UniqueFilename($this->foto->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->foto->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->foto->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->foto->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->foto->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, null, $this->foto->ReadOnly);
                }
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
                    if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : [$this->foto->htmlDecode($this->foto->Upload->DbValue)];
                        if (!EmptyValue($this->foto->Upload->FileName)) {
                            $newFiles = [$this->foto->Upload->FileName];
                            $newFiles2 = [$this->foto->htmlDecode($rsnew['foto'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->foto, $this->foto->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->foto->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
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
            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "brand") {
                $validMaster = true;
                $masterTbl = Container("brand");
                if (($parm = Get("fk_id", Get("idbrand"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idbrand->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idbrand->setSessionValue($this->idbrand->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "brand") {
                $validMaster = true;
                $masterTbl = Container("brand");
                if (($parm = Post("fk_id", Post("idbrand"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idbrand->setFormValue($masterTbl->id->FormValue);
                    $this->idbrand->setSessionValue($this->idbrand->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);
            $this->setSessionWhere($this->getDetailFilter());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "brand") {
                if ($this->idbrand->CurrentValue == "") {
                    $this->idbrand->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ProductList"), "", $this->TableVar, true);
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
                case "x_idbrand":
                    break;
                case "x_idkategoribarang":
                    break;
                case "x_idjenisbarang":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add") ? "idbrand > 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_ijinbpom":
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
    //    $count = ExecuteScalar("SELECT COUNT(*) FROM product WHERE kode='".$this->kode->FormValue."'");
    //    if ($count>0) {
    //        $this->kode->addErrorMessage("Kode Brand sudah terpakai.");
    //        return false;
    //    }
        return true;
    }
}
