<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class CustomerAdd extends Customer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'customer';

    // Page object name
    public $PageObjName = "CustomerAdd";

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

        // Table object (customer)
        if (!isset($GLOBALS["customer"]) || get_class($GLOBALS["customer"]) == PROJECT_NAMESPACE . "customer") {
            $GLOBALS["customer"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

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
                    if ($pageName == "CustomerView") {
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
        $this->kode->setVisibility();
        $this->idtipecustomer->setVisibility();
        $this->idpegawai->setVisibility();
        $this->nama->setVisibility();
        $this->jenis_usaha->setVisibility();
        $this->jabatan->setVisibility();
        $this->idprov->setVisibility();
        $this->idkab->setVisibility();
        $this->idkec->setVisibility();
        $this->idkel->setVisibility();
        $this->kodepos->setVisibility();
        $this->alamat->setVisibility();
        $this->telpon->setVisibility();
        $this->hp->setVisibility();
        $this->_email->setVisibility();
        $this->website->setVisibility();
        $this->foto->setVisibility();
        $this->ktp->setVisibility();
        $this->npwp->setVisibility();
        $this->limit_kredit_order->setVisibility();
        $this->jatuh_tempo_invoice->setVisibility();
        $this->kodenpd->setVisibility();
        $this->klinik->setVisibility();
        $this->keterangan->setVisibility();
        $this->aktif->Visible = false;
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
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
        $this->setupLookupOptions($this->idtipecustomer);
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idprov);
        $this->setupLookupOptions($this->idkab);
        $this->setupLookupOptions($this->idkec);
        $this->setupLookupOptions($this->idkel);
        $this->setupLookupOptions($this->jatuh_tempo_invoice);

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
                    $this->terminate("CustomerList"); // No matching record, return to list
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
                    $returnUrl = $this->GetViewUrl();
                    if (GetPageName($returnUrl) == "CustomerList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "CustomerView") {
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
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
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
        $this->foto->CurrentValue = null; // Clear file related field
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

        // Check field name 'idtipecustomer' first before field var 'x_idtipecustomer'
        $val = $CurrentForm->hasValue("idtipecustomer") ? $CurrentForm->getValue("idtipecustomer") : $CurrentForm->getValue("x_idtipecustomer");
        if (!$this->idtipecustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idtipecustomer->Visible = false; // Disable update for API request
            } else {
                $this->idtipecustomer->setFormValue($val);
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

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
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

        // Check field name 'jabatan' first before field var 'x_jabatan'
        $val = $CurrentForm->hasValue("jabatan") ? $CurrentForm->getValue("jabatan") : $CurrentForm->getValue("x_jabatan");
        if (!$this->jabatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatan->Visible = false; // Disable update for API request
            } else {
                $this->jabatan->setFormValue($val);
            }
        }

        // Check field name 'idprov' first before field var 'x_idprov'
        $val = $CurrentForm->hasValue("idprov") ? $CurrentForm->getValue("idprov") : $CurrentForm->getValue("x_idprov");
        if (!$this->idprov->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idprov->Visible = false; // Disable update for API request
            } else {
                $this->idprov->setFormValue($val);
            }
        }

        // Check field name 'idkab' first before field var 'x_idkab'
        $val = $CurrentForm->hasValue("idkab") ? $CurrentForm->getValue("idkab") : $CurrentForm->getValue("x_idkab");
        if (!$this->idkab->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkab->Visible = false; // Disable update for API request
            } else {
                $this->idkab->setFormValue($val);
            }
        }

        // Check field name 'idkec' first before field var 'x_idkec'
        $val = $CurrentForm->hasValue("idkec") ? $CurrentForm->getValue("idkec") : $CurrentForm->getValue("x_idkec");
        if (!$this->idkec->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkec->Visible = false; // Disable update for API request
            } else {
                $this->idkec->setFormValue($val);
            }
        }

        // Check field name 'idkel' first before field var 'x_idkel'
        $val = $CurrentForm->hasValue("idkel") ? $CurrentForm->getValue("idkel") : $CurrentForm->getValue("x_idkel");
        if (!$this->idkel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkel->Visible = false; // Disable update for API request
            } else {
                $this->idkel->setFormValue($val);
            }
        }

        // Check field name 'kodepos' first before field var 'x_kodepos'
        $val = $CurrentForm->hasValue("kodepos") ? $CurrentForm->getValue("kodepos") : $CurrentForm->getValue("x_kodepos");
        if (!$this->kodepos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodepos->Visible = false; // Disable update for API request
            } else {
                $this->kodepos->setFormValue($val);
            }
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

        // Check field name 'telpon' first before field var 'x_telpon'
        $val = $CurrentForm->hasValue("telpon") ? $CurrentForm->getValue("telpon") : $CurrentForm->getValue("x_telpon");
        if (!$this->telpon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telpon->Visible = false; // Disable update for API request
            } else {
                $this->telpon->setFormValue($val);
            }
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

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'website' first before field var 'x_website'
        $val = $CurrentForm->hasValue("website") ? $CurrentForm->getValue("website") : $CurrentForm->getValue("x_website");
        if (!$this->website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->website->Visible = false; // Disable update for API request
            } else {
                $this->website->setFormValue($val);
            }
        }

        // Check field name 'ktp' first before field var 'x_ktp'
        $val = $CurrentForm->hasValue("ktp") ? $CurrentForm->getValue("ktp") : $CurrentForm->getValue("x_ktp");
        if (!$this->ktp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ktp->Visible = false; // Disable update for API request
            } else {
                $this->ktp->setFormValue($val);
            }
        }

        // Check field name 'npwp' first before field var 'x_npwp'
        $val = $CurrentForm->hasValue("npwp") ? $CurrentForm->getValue("npwp") : $CurrentForm->getValue("x_npwp");
        if (!$this->npwp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->npwp->Visible = false; // Disable update for API request
            } else {
                $this->npwp->setFormValue($val);
            }
        }

        // Check field name 'limit_kredit_order' first before field var 'x_limit_kredit_order'
        $val = $CurrentForm->hasValue("limit_kredit_order") ? $CurrentForm->getValue("limit_kredit_order") : $CurrentForm->getValue("x_limit_kredit_order");
        if (!$this->limit_kredit_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->limit_kredit_order->Visible = false; // Disable update for API request
            } else {
                $this->limit_kredit_order->setFormValue($val);
            }
        }

        // Check field name 'jatuh_tempo_invoice' first before field var 'x_jatuh_tempo_invoice'
        $val = $CurrentForm->hasValue("jatuh_tempo_invoice") ? $CurrentForm->getValue("jatuh_tempo_invoice") : $CurrentForm->getValue("x_jatuh_tempo_invoice");
        if (!$this->jatuh_tempo_invoice->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jatuh_tempo_invoice->Visible = false; // Disable update for API request
            } else {
                $this->jatuh_tempo_invoice->setFormValue($val);
            }
        }

        // Check field name 'kodenpd' first before field var 'x_kodenpd'
        $val = $CurrentForm->hasValue("kodenpd") ? $CurrentForm->getValue("kodenpd") : $CurrentForm->getValue("x_kodenpd");
        if (!$this->kodenpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodenpd->Visible = false; // Disable update for API request
            } else {
                $this->kodenpd->setFormValue($val);
            }
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

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
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
        $this->idtipecustomer->CurrentValue = $this->idtipecustomer->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->jenis_usaha->CurrentValue = $this->jenis_usaha->FormValue;
        $this->jabatan->CurrentValue = $this->jabatan->FormValue;
        $this->idprov->CurrentValue = $this->idprov->FormValue;
        $this->idkab->CurrentValue = $this->idkab->FormValue;
        $this->idkec->CurrentValue = $this->idkec->FormValue;
        $this->idkel->CurrentValue = $this->idkel->FormValue;
        $this->kodepos->CurrentValue = $this->kodepos->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->telpon->CurrentValue = $this->telpon->FormValue;
        $this->hp->CurrentValue = $this->hp->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->website->CurrentValue = $this->website->FormValue;
        $this->ktp->CurrentValue = $this->ktp->FormValue;
        $this->npwp->CurrentValue = $this->npwp->FormValue;
        $this->limit_kredit_order->CurrentValue = $this->limit_kredit_order->FormValue;
        $this->jatuh_tempo_invoice->CurrentValue = $this->jatuh_tempo_invoice->FormValue;
        $this->kodenpd->CurrentValue = $this->kodenpd->FormValue;
        $this->klinik->CurrentValue = $this->klinik->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
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
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";
            $this->jabatan->TooltipValue = "";

            // idprov
            $this->idprov->LinkCustomAttributes = "";
            $this->idprov->HrefValue = "";
            $this->idprov->TooltipValue = "";

            // idkab
            $this->idkab->LinkCustomAttributes = "";
            $this->idkab->HrefValue = "";
            $this->idkab->TooltipValue = "";

            // idkec
            $this->idkec->LinkCustomAttributes = "";
            $this->idkec->HrefValue = "";
            $this->idkec->TooltipValue = "";

            // idkel
            $this->idkel->LinkCustomAttributes = "";
            $this->idkel->HrefValue = "";
            $this->idkel->TooltipValue = "";

            // kodepos
            $this->kodepos->LinkCustomAttributes = "";
            $this->kodepos->HrefValue = "";
            $this->kodepos->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // telpon
            $this->telpon->LinkCustomAttributes = "";
            $this->telpon->HrefValue = "";
            $this->telpon->TooltipValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";
            $this->hp->TooltipValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";
            $this->website->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = "%u"; // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";
            if ($this->foto->UseColorbox) {
                if (EmptyValue($this->foto->TooltipValue)) {
                    $this->foto->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->foto->LinkAttrs["data-rel"] = "customer_x_foto";
                $this->foto->LinkAttrs->appendClass("ew-lightbox");
            }

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            $this->ktp->HrefValue = "";
            $this->ktp->TooltipValue = "";

            // npwp
            $this->npwp->LinkCustomAttributes = "";
            $this->npwp->HrefValue = "";
            $this->npwp->TooltipValue = "";

            // limit_kredit_order
            $this->limit_kredit_order->LinkCustomAttributes = "";
            $this->limit_kredit_order->HrefValue = "";
            $this->limit_kredit_order->TooltipValue = "";

            // jatuh_tempo_invoice
            $this->jatuh_tempo_invoice->LinkCustomAttributes = "";
            $this->jatuh_tempo_invoice->HrefValue = "";
            $this->jatuh_tempo_invoice->TooltipValue = "";

            // kodenpd
            $this->kodenpd->LinkCustomAttributes = "";
            $this->kodenpd->HrefValue = "";
            $this->kodenpd->TooltipValue = "";

            // klinik
            $this->klinik->LinkCustomAttributes = "";
            $this->klinik->HrefValue = "";
            $this->klinik->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";
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

            // jabatan
            $this->jabatan->EditAttrs["class"] = "form-control";
            $this->jabatan->EditCustomAttributes = "";
            if (!$this->jabatan->Raw) {
                $this->jabatan->CurrentValue = HtmlDecode($this->jabatan->CurrentValue);
            }
            $this->jabatan->EditValue = HtmlEncode($this->jabatan->CurrentValue);
            $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

            // idprov
            $this->idprov->EditAttrs["class"] = "form-control";
            $this->idprov->EditCustomAttributes = "";
            $curVal = trim(strval($this->idprov->CurrentValue));
            if ($curVal != "") {
                $this->idprov->ViewValue = $this->idprov->lookupCacheOption($curVal);
            } else {
                $this->idprov->ViewValue = $this->idprov->Lookup !== null && is_array($this->idprov->Lookup->Options) ? $curVal : null;
            }
            if ($this->idprov->ViewValue !== null) { // Load from cache
                $this->idprov->EditValue = array_values($this->idprov->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idprov->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idprov->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idprov->EditValue = $arwrk;
            }
            $this->idprov->PlaceHolder = RemoveHtml($this->idprov->caption());

            // idkab
            $this->idkab->EditAttrs["class"] = "form-control";
            $this->idkab->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkab->CurrentValue));
            if ($curVal != "") {
                $this->idkab->ViewValue = $this->idkab->lookupCacheOption($curVal);
            } else {
                $this->idkab->ViewValue = $this->idkab->Lookup !== null && is_array($this->idkab->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkab->ViewValue !== null) { // Load from cache
                $this->idkab->EditValue = array_values($this->idkab->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkab->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkab->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkab->EditValue = $arwrk;
            }
            $this->idkab->PlaceHolder = RemoveHtml($this->idkab->caption());

            // idkec
            $this->idkec->EditAttrs["class"] = "form-control";
            $this->idkec->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkec->CurrentValue));
            if ($curVal != "") {
                $this->idkec->ViewValue = $this->idkec->lookupCacheOption($curVal);
            } else {
                $this->idkec->ViewValue = $this->idkec->Lookup !== null && is_array($this->idkec->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkec->ViewValue !== null) { // Load from cache
                $this->idkec->EditValue = array_values($this->idkec->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkec->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkec->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkec->EditValue = $arwrk;
            }
            $this->idkec->PlaceHolder = RemoveHtml($this->idkec->caption());

            // idkel
            $this->idkel->EditAttrs["class"] = "form-control";
            $this->idkel->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkel->CurrentValue));
            if ($curVal != "") {
                $this->idkel->ViewValue = $this->idkel->lookupCacheOption($curVal);
            } else {
                $this->idkel->ViewValue = $this->idkel->Lookup !== null && is_array($this->idkel->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkel->ViewValue !== null) { // Load from cache
                $this->idkel->EditValue = array_values($this->idkel->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkel->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkel->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkel->EditValue = $arwrk;
            }
            $this->idkel->PlaceHolder = RemoveHtml($this->idkel->caption());

            // kodepos
            $this->kodepos->EditAttrs["class"] = "form-control";
            $this->kodepos->EditCustomAttributes = "";
            if (!$this->kodepos->Raw) {
                $this->kodepos->CurrentValue = HtmlDecode($this->kodepos->CurrentValue);
            }
            $this->kodepos->EditValue = HtmlEncode($this->kodepos->CurrentValue);
            $this->kodepos->PlaceHolder = RemoveHtml($this->kodepos->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // telpon
            $this->telpon->EditAttrs["class"] = "form-control";
            $this->telpon->EditCustomAttributes = "";
            if (!$this->telpon->Raw) {
                $this->telpon->CurrentValue = HtmlDecode($this->telpon->CurrentValue);
            }
            $this->telpon->EditValue = HtmlEncode($this->telpon->CurrentValue);
            $this->telpon->PlaceHolder = RemoveHtml($this->telpon->caption());

            // hp
            $this->hp->EditAttrs["class"] = "form-control";
            $this->hp->EditCustomAttributes = "";
            if (!$this->hp->Raw) {
                $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
            }
            $this->hp->EditValue = HtmlEncode($this->hp->CurrentValue);
            $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // website
            $this->website->EditAttrs["class"] = "form-control";
            $this->website->EditCustomAttributes = "";
            if (!$this->website->Raw) {
                $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
            }
            $this->website->EditValue = HtmlEncode($this->website->CurrentValue);
            $this->website->PlaceHolder = RemoveHtml($this->website->caption());

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->foto->CurrentValue)) {
                $this->foto->Upload->FileName = $this->foto->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->foto);
            }

            // ktp
            $this->ktp->EditAttrs["class"] = "form-control";
            $this->ktp->EditCustomAttributes = "";
            if (!$this->ktp->Raw) {
                $this->ktp->CurrentValue = HtmlDecode($this->ktp->CurrentValue);
            }
            $this->ktp->EditValue = HtmlEncode($this->ktp->CurrentValue);
            $this->ktp->PlaceHolder = RemoveHtml($this->ktp->caption());

            // npwp
            $this->npwp->EditAttrs["class"] = "form-control";
            $this->npwp->EditCustomAttributes = "";
            if (!$this->npwp->Raw) {
                $this->npwp->CurrentValue = HtmlDecode($this->npwp->CurrentValue);
            }
            $this->npwp->EditValue = HtmlEncode($this->npwp->CurrentValue);
            $this->npwp->PlaceHolder = RemoveHtml($this->npwp->caption());

            // limit_kredit_order
            $this->limit_kredit_order->EditAttrs["class"] = "form-control";
            $this->limit_kredit_order->EditCustomAttributes = "";
            $this->limit_kredit_order->EditValue = HtmlEncode($this->limit_kredit_order->CurrentValue);
            $this->limit_kredit_order->PlaceHolder = RemoveHtml($this->limit_kredit_order->caption());

            // jatuh_tempo_invoice
            $this->jatuh_tempo_invoice->EditAttrs["class"] = "form-control";
            $this->jatuh_tempo_invoice->EditCustomAttributes = "";
            $curVal = trim(strval($this->jatuh_tempo_invoice->CurrentValue));
            if ($curVal != "") {
                $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->lookupCacheOption($curVal);
            } else {
                $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->Lookup !== null && is_array($this->jatuh_tempo_invoice->Lookup->Options) ? $curVal : null;
            }
            if ($this->jatuh_tempo_invoice->ViewValue !== null) { // Load from cache
                $this->jatuh_tempo_invoice->EditValue = array_values($this->jatuh_tempo_invoice->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->jatuh_tempo_invoice->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->jatuh_tempo_invoice->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->jatuh_tempo_invoice->EditValue = $arwrk;
            }
            $this->jatuh_tempo_invoice->PlaceHolder = RemoveHtml($this->jatuh_tempo_invoice->caption());

            // kodenpd
            $this->kodenpd->EditAttrs["class"] = "form-control";
            $this->kodenpd->EditCustomAttributes = "";
            if (!$this->kodenpd->Raw) {
                $this->kodenpd->CurrentValue = HtmlDecode($this->kodenpd->CurrentValue);
            }
            $this->kodenpd->EditValue = HtmlEncode($this->kodenpd->CurrentValue);
            $this->kodenpd->PlaceHolder = RemoveHtml($this->kodenpd->caption());

            // klinik
            $this->klinik->EditAttrs["class"] = "form-control";
            $this->klinik->EditCustomAttributes = "";
            if (!$this->klinik->Raw) {
                $this->klinik->CurrentValue = HtmlDecode($this->klinik->CurrentValue);
            }
            $this->klinik->EditValue = HtmlEncode($this->klinik->CurrentValue);
            $this->klinik->PlaceHolder = RemoveHtml($this->klinik->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

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

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";

            // idprov
            $this->idprov->LinkCustomAttributes = "";
            $this->idprov->HrefValue = "";

            // idkab
            $this->idkab->LinkCustomAttributes = "";
            $this->idkab->HrefValue = "";

            // idkec
            $this->idkec->LinkCustomAttributes = "";
            $this->idkec->HrefValue = "";

            // idkel
            $this->idkel->LinkCustomAttributes = "";
            $this->idkel->HrefValue = "";

            // kodepos
            $this->kodepos->LinkCustomAttributes = "";
            $this->kodepos->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // telpon
            $this->telpon->LinkCustomAttributes = "";
            $this->telpon->HrefValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = "%u"; // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            $this->ktp->HrefValue = "";

            // npwp
            $this->npwp->LinkCustomAttributes = "";
            $this->npwp->HrefValue = "";

            // limit_kredit_order
            $this->limit_kredit_order->LinkCustomAttributes = "";
            $this->limit_kredit_order->HrefValue = "";

            // jatuh_tempo_invoice
            $this->jatuh_tempo_invoice->LinkCustomAttributes = "";
            $this->jatuh_tempo_invoice->HrefValue = "";

            // kodenpd
            $this->kodenpd->LinkCustomAttributes = "";
            $this->kodenpd->HrefValue = "";

            // klinik
            $this->klinik->LinkCustomAttributes = "";
            $this->klinik->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
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
        if ($this->jabatan->Required) {
            if (!$this->jabatan->IsDetailKey && EmptyValue($this->jabatan->FormValue)) {
                $this->jabatan->addErrorMessage(str_replace("%s", $this->jabatan->caption(), $this->jabatan->RequiredErrorMessage));
            }
        }
        if ($this->idprov->Required) {
            if (!$this->idprov->IsDetailKey && EmptyValue($this->idprov->FormValue)) {
                $this->idprov->addErrorMessage(str_replace("%s", $this->idprov->caption(), $this->idprov->RequiredErrorMessage));
            }
        }
        if ($this->idkab->Required) {
            if (!$this->idkab->IsDetailKey && EmptyValue($this->idkab->FormValue)) {
                $this->idkab->addErrorMessage(str_replace("%s", $this->idkab->caption(), $this->idkab->RequiredErrorMessage));
            }
        }
        if ($this->idkec->Required) {
            if (!$this->idkec->IsDetailKey && EmptyValue($this->idkec->FormValue)) {
                $this->idkec->addErrorMessage(str_replace("%s", $this->idkec->caption(), $this->idkec->RequiredErrorMessage));
            }
        }
        if ($this->idkel->Required) {
            if (!$this->idkel->IsDetailKey && EmptyValue($this->idkel->FormValue)) {
                $this->idkel->addErrorMessage(str_replace("%s", $this->idkel->caption(), $this->idkel->RequiredErrorMessage));
            }
        }
        if ($this->kodepos->Required) {
            if (!$this->kodepos->IsDetailKey && EmptyValue($this->kodepos->FormValue)) {
                $this->kodepos->addErrorMessage(str_replace("%s", $this->kodepos->caption(), $this->kodepos->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->telpon->Required) {
            if (!$this->telpon->IsDetailKey && EmptyValue($this->telpon->FormValue)) {
                $this->telpon->addErrorMessage(str_replace("%s", $this->telpon->caption(), $this->telpon->RequiredErrorMessage));
            }
        }
        if ($this->hp->Required) {
            if (!$this->hp->IsDetailKey && EmptyValue($this->hp->FormValue)) {
                $this->hp->addErrorMessage(str_replace("%s", $this->hp->caption(), $this->hp->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->_email->FormValue)) {
            $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
        }
        if ($this->website->Required) {
            if (!$this->website->IsDetailKey && EmptyValue($this->website->FormValue)) {
                $this->website->addErrorMessage(str_replace("%s", $this->website->caption(), $this->website->RequiredErrorMessage));
            }
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->ktp->Required) {
            if (!$this->ktp->IsDetailKey && EmptyValue($this->ktp->FormValue)) {
                $this->ktp->addErrorMessage(str_replace("%s", $this->ktp->caption(), $this->ktp->RequiredErrorMessage));
            }
        }
        if ($this->npwp->Required) {
            if (!$this->npwp->IsDetailKey && EmptyValue($this->npwp->FormValue)) {
                $this->npwp->addErrorMessage(str_replace("%s", $this->npwp->caption(), $this->npwp->RequiredErrorMessage));
            }
        }
        if ($this->limit_kredit_order->Required) {
            if (!$this->limit_kredit_order->IsDetailKey && EmptyValue($this->limit_kredit_order->FormValue)) {
                $this->limit_kredit_order->addErrorMessage(str_replace("%s", $this->limit_kredit_order->caption(), $this->limit_kredit_order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->limit_kredit_order->FormValue)) {
            $this->limit_kredit_order->addErrorMessage($this->limit_kredit_order->getErrorMessage(false));
        }
        if ($this->jatuh_tempo_invoice->Required) {
            if (!$this->jatuh_tempo_invoice->IsDetailKey && EmptyValue($this->jatuh_tempo_invoice->FormValue)) {
                $this->jatuh_tempo_invoice->addErrorMessage(str_replace("%s", $this->jatuh_tempo_invoice->caption(), $this->jatuh_tempo_invoice->RequiredErrorMessage));
            }
        }
        if ($this->kodenpd->Required) {
            if (!$this->kodenpd->IsDetailKey && EmptyValue($this->kodenpd->FormValue)) {
                $this->kodenpd->addErrorMessage(str_replace("%s", $this->kodenpd->caption(), $this->kodenpd->RequiredErrorMessage));
            }
        }
        if ($this->klinik->Required) {
            if (!$this->klinik->IsDetailKey && EmptyValue($this->klinik->FormValue)) {
                $this->klinik->addErrorMessage(str_replace("%s", $this->klinik->caption(), $this->klinik->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("AlamatCustomerGrid");
        if (in_array("alamat_customer", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("OrderGrid");
        if (in_array("order", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("InvoiceGrid");
        if (in_array("invoice", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("VListCustomerBrandsGrid");
        if (in_array("v_list_customer_brands", $detailTblVar) && $detailPage->DetailAdd) {
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

        // jabatan
        $this->jabatan->setDbValueDef($rsnew, $this->jabatan->CurrentValue, null, false);

        // idprov
        $this->idprov->setDbValueDef($rsnew, $this->idprov->CurrentValue, null, false);

        // idkab
        $this->idkab->setDbValueDef($rsnew, $this->idkab->CurrentValue, null, false);

        // idkec
        $this->idkec->setDbValueDef($rsnew, $this->idkec->CurrentValue, null, false);

        // idkel
        $this->idkel->setDbValueDef($rsnew, $this->idkel->CurrentValue, null, false);

        // kodepos
        $this->kodepos->setDbValueDef($rsnew, $this->kodepos->CurrentValue, null, false);

        // alamat
        $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, null, false);

        // telpon
        $this->telpon->setDbValueDef($rsnew, $this->telpon->CurrentValue, null, false);

        // hp
        $this->hp->setDbValueDef($rsnew, $this->hp->CurrentValue, null, strval($this->hp->CurrentValue) == "");

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

        // website
        $this->website->setDbValueDef($rsnew, $this->website->CurrentValue, null, false);

        // foto
        if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
            $this->foto->Upload->DbValue = ""; // No need to delete old file
            if ($this->foto->Upload->FileName == "") {
                $rsnew['foto'] = null;
            } else {
                $rsnew['foto'] = $this->foto->Upload->FileName;
            }
        }

        // ktp
        $this->ktp->setDbValueDef($rsnew, $this->ktp->CurrentValue, null, false);

        // npwp
        $this->npwp->setDbValueDef($rsnew, $this->npwp->CurrentValue, null, false);

        // limit_kredit_order
        $this->limit_kredit_order->setDbValueDef($rsnew, $this->limit_kredit_order->CurrentValue, null, false);

        // jatuh_tempo_invoice
        $this->jatuh_tempo_invoice->setDbValueDef($rsnew, $this->jatuh_tempo_invoice->CurrentValue, null, false);

        // kodenpd
        $this->kodenpd->setDbValueDef($rsnew, $this->kodenpd->CurrentValue, null, false);

        // klinik
        $this->klinik->setDbValueDef($rsnew, $this->klinik->CurrentValue, null, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, false);
        if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode(strval($this->foto->Upload->DbValue)));
            if (!EmptyValue($this->foto->Upload->FileName)) {
                $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), strval($this->foto->Upload->FileName));
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
                $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, null, false);
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
                if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode(strval($this->foto->Upload->DbValue)));
                    if (!EmptyValue($this->foto->Upload->FileName)) {
                        $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->Upload->FileName);
                        $newFiles2 = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode($rsnew['foto']));
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
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("AlamatCustomerGrid");
            if (in_array("alamat_customer", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idcustomer->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "alamat_customer"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idcustomer->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("OrderGrid");
            if (in_array("order", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idcustomer->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "order"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idcustomer->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("InvoiceGrid");
            if (in_array("invoice", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idcustomer->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "invoice"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idcustomer->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("VListCustomerBrandsGrid");
            if (in_array("v_list_customer_brands", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idcustomer->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "v_list_customer_brands"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idcustomer->setSessionValue(""); // Clear master key if insert failed
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
            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
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
            if (in_array("alamat_customer", $detailTblVar)) {
                $detailPageObj = Container("AlamatCustomerGrid");
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
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
                }
            }
            if (in_array("order", $detailTblVar)) {
                $detailPageObj = Container("OrderGrid");
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
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
                }
            }
            if (in_array("invoice", $detailTblVar)) {
                $detailPageObj = Container("InvoiceGrid");
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
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
                    $detailPageObj->id->setSessionValue(""); // Clear session key
                }
            }
            if (in_array("v_list_customer_brands", $detailTblVar)) {
                $detailPageObj = Container("VListCustomerBrandsGrid");
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
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CustomerList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('alamat_customer');
        $pages->add('order');
        $pages->add('invoice');
        $pages->add('v_list_customer_brands');
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
        $this->jatuh_tempo_invoice->CurrentValue = 5;
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
        $count = ExecuteScalar("SELECT COUNT(*) FROM customer WHERE kodenpd='".$this->kodenpd->FormValue."'");
        if ($count>0) {
        	$customError = "Kode NPD sudah terpakai.";
    //        $this->kodenpd->addErrorMessage("Kode NPD sudah terpakai.");
            return false;
        }
        return true;
    }
}
