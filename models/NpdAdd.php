<?php

namespace PHPMaker2021\production2;

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

        // Custom template
        $this->UseCustomTemplate = true;

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
        if (Post("customexport") === null) {
             // Page Unload event
            if (method_exists($this, "pageUnload")) {
                $this->pageUnload();
            }

            // Global Page Unloaded event (in userfn*.php)
            Page_Unloaded();
        }

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            if (is_array(Session(SESSION_TEMP_IMAGES))) { // Restore temp images
                $TempImages = Session(SESSION_TEMP_IMAGES);
            }
            if (Post("data") !== null) {
                $content = Post("data");
            }
            $ExportFileName = Post("filename", "");
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
        if ($this->CustomExport) { // Save temp images array for custom export
            if (is_array($TempImages)) {
                $_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
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
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idbrand->setVisibility();
        $this->tanggal_order->setVisibility();
        $this->target_selesai->setVisibility();
        $this->sifatorder->setVisibility();
        $this->kodeorder->setVisibility();
        $this->nomororder->setVisibility();
        $this->idproduct_acuan->setVisibility();
        $this->kategoriproduk->setVisibility();
        $this->jenisproduk->setVisibility();
        $this->fungsiproduk->setVisibility();
        $this->kualitasproduk->setVisibility();
        $this->bahan_campaign->setVisibility();
        $this->ukuransediaan->setVisibility();
        $this->satuansediaan->setVisibility();
        $this->bentuk->setVisibility();
        $this->viskositas->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->aroma->setVisibility();
        $this->aplikasi->setVisibility();
        $this->estetika->setVisibility();
        $this->tambahan->setVisibility();
        $this->ukurankemasan->setVisibility();
        $this->satuankemasan->setVisibility();
        $this->kemasanwadah->setVisibility();
        $this->kemasantutup->setVisibility();
        $this->kemasancatatan->setVisibility();
        $this->ukurankemasansekunder->setVisibility();
        $this->satuankemasansekunder->setVisibility();
        $this->kemasanbahan->setVisibility();
        $this->kemasanbentuk->setVisibility();
        $this->kemasankomposisi->setVisibility();
        $this->kemasancatatansekunder->setVisibility();
        $this->labelbahan->setVisibility();
        $this->labelkualitas->setVisibility();
        $this->labelposisi->setVisibility();
        $this->labelcatatan->setVisibility();
        $this->labeltekstur->setVisibility();
        $this->labelprint->setVisibility();
        $this->labeljmlwarna->setVisibility();
        $this->labelcatatanhotprint->setVisibility();
        $this->ukuran_utama->setVisibility();
        $this->utama_harga_isi->setVisibility();
        $this->utama_harga_isi_proyeksi->setVisibility();
        $this->utama_harga_primer->setVisibility();
        $this->utama_harga_primer_proyeksi->setVisibility();
        $this->utama_harga_sekunder->setVisibility();
        $this->utama_harga_sekunder_proyeksi->setVisibility();
        $this->utama_harga_label->setVisibility();
        $this->utama_harga_label_proyeksi->setVisibility();
        $this->utama_harga_total->setVisibility();
        $this->utama_harga_total_proyeksi->setVisibility();
        $this->ukuran_lain->setVisibility();
        $this->lain_harga_isi->setVisibility();
        $this->lain_harga_isi_proyeksi->setVisibility();
        $this->lain_harga_primer->setVisibility();
        $this->lain_harga_primer_proyeksi->setVisibility();
        $this->lain_harga_sekunder->setVisibility();
        $this->lain_harga_sekunder_proyeksi->setVisibility();
        $this->lain_harga_label->setVisibility();
        $this->lain_harga_label_proyeksi->setVisibility();
        $this->lain_harga_total->setVisibility();
        $this->lain_harga_total_proyeksi->setVisibility();
        $this->delivery_pickup->setVisibility();
        $this->delivery_singlepoint->setVisibility();
        $this->delivery_multipoint->setVisibility();
        $this->delivery_termlain->setVisibility();
        $this->status->setVisibility();
        $this->readonly->Visible = false;
        $this->receipt_by->setVisibility();
        $this->approve_by->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->selesai->Visible = false;
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
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->kategoriproduk);
        $this->setupLookupOptions($this->jenisproduk);
        $this->setupLookupOptions($this->satuansediaan);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->parfum);
        $this->setupLookupOptions($this->aplikasi);
        $this->setupLookupOptions($this->estetika);
        $this->setupLookupOptions($this->satuankemasan);
        $this->setupLookupOptions($this->kemasanwadah);
        $this->setupLookupOptions($this->kemasantutup);
        $this->setupLookupOptions($this->satuankemasansekunder);
        $this->setupLookupOptions($this->kemasanbahan);
        $this->setupLookupOptions($this->kemasanbentuk);
        $this->setupLookupOptions($this->kemasankomposisi);
        $this->setupLookupOptions($this->labelbahan);
        $this->setupLookupOptions($this->labelkualitas);
        $this->setupLookupOptions($this->labelposisi);
        $this->setupLookupOptions($this->labeltekstur);
        $this->setupLookupOptions($this->labelprint);
        $this->setupLookupOptions($this->approve_by);

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
        $this->idpegawai->CurrentValue = CurrentUserID();
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->idbrand->CurrentValue = null;
        $this->idbrand->OldValue = $this->idbrand->CurrentValue;
        $this->tanggal_order->CurrentValue = CurrentDate();
        $this->target_selesai->CurrentValue = CurrentDate();
        $this->sifatorder->CurrentValue = null;
        $this->sifatorder->OldValue = $this->sifatorder->CurrentValue;
        $this->kodeorder->CurrentValue = null;
        $this->kodeorder->OldValue = $this->kodeorder->CurrentValue;
        $this->nomororder->CurrentValue = null;
        $this->nomororder->OldValue = $this->nomororder->CurrentValue;
        $this->idproduct_acuan->CurrentValue = null;
        $this->idproduct_acuan->OldValue = $this->idproduct_acuan->CurrentValue;
        $this->kategoriproduk->CurrentValue = null;
        $this->kategoriproduk->OldValue = $this->kategoriproduk->CurrentValue;
        $this->jenisproduk->CurrentValue = null;
        $this->jenisproduk->OldValue = $this->jenisproduk->CurrentValue;
        $this->fungsiproduk->CurrentValue = null;
        $this->fungsiproduk->OldValue = $this->fungsiproduk->CurrentValue;
        $this->kualitasproduk->CurrentValue = null;
        $this->kualitasproduk->OldValue = $this->kualitasproduk->CurrentValue;
        $this->bahan_campaign->CurrentValue = null;
        $this->bahan_campaign->OldValue = $this->bahan_campaign->CurrentValue;
        $this->ukuransediaan->CurrentValue = null;
        $this->ukuransediaan->OldValue = $this->ukuransediaan->CurrentValue;
        $this->satuansediaan->CurrentValue = null;
        $this->satuansediaan->OldValue = $this->satuansediaan->CurrentValue;
        $this->bentuk->CurrentValue = null;
        $this->bentuk->OldValue = $this->bentuk->CurrentValue;
        $this->viskositas->CurrentValue = null;
        $this->viskositas->OldValue = $this->viskositas->CurrentValue;
        $this->warna->CurrentValue = null;
        $this->warna->OldValue = $this->warna->CurrentValue;
        $this->parfum->CurrentValue = null;
        $this->parfum->OldValue = $this->parfum->CurrentValue;
        $this->aroma->CurrentValue = null;
        $this->aroma->OldValue = $this->aroma->CurrentValue;
        $this->aplikasi->CurrentValue = null;
        $this->aplikasi->OldValue = $this->aplikasi->CurrentValue;
        $this->estetika->CurrentValue = null;
        $this->estetika->OldValue = $this->estetika->CurrentValue;
        $this->tambahan->CurrentValue = null;
        $this->tambahan->OldValue = $this->tambahan->CurrentValue;
        $this->ukurankemasan->CurrentValue = null;
        $this->ukurankemasan->OldValue = $this->ukurankemasan->CurrentValue;
        $this->satuankemasan->CurrentValue = null;
        $this->satuankemasan->OldValue = $this->satuankemasan->CurrentValue;
        $this->kemasanwadah->CurrentValue = null;
        $this->kemasanwadah->OldValue = $this->kemasanwadah->CurrentValue;
        $this->kemasantutup->CurrentValue = null;
        $this->kemasantutup->OldValue = $this->kemasantutup->CurrentValue;
        $this->kemasancatatan->CurrentValue = null;
        $this->kemasancatatan->OldValue = $this->kemasancatatan->CurrentValue;
        $this->ukurankemasansekunder->CurrentValue = null;
        $this->ukurankemasansekunder->OldValue = $this->ukurankemasansekunder->CurrentValue;
        $this->satuankemasansekunder->CurrentValue = null;
        $this->satuankemasansekunder->OldValue = $this->satuankemasansekunder->CurrentValue;
        $this->kemasanbahan->CurrentValue = null;
        $this->kemasanbahan->OldValue = $this->kemasanbahan->CurrentValue;
        $this->kemasanbentuk->CurrentValue = null;
        $this->kemasanbentuk->OldValue = $this->kemasanbentuk->CurrentValue;
        $this->kemasankomposisi->CurrentValue = null;
        $this->kemasankomposisi->OldValue = $this->kemasankomposisi->CurrentValue;
        $this->kemasancatatansekunder->CurrentValue = null;
        $this->kemasancatatansekunder->OldValue = $this->kemasancatatansekunder->CurrentValue;
        $this->labelbahan->CurrentValue = null;
        $this->labelbahan->OldValue = $this->labelbahan->CurrentValue;
        $this->labelkualitas->CurrentValue = null;
        $this->labelkualitas->OldValue = $this->labelkualitas->CurrentValue;
        $this->labelposisi->CurrentValue = null;
        $this->labelposisi->OldValue = $this->labelposisi->CurrentValue;
        $this->labelcatatan->CurrentValue = null;
        $this->labelcatatan->OldValue = $this->labelcatatan->CurrentValue;
        $this->labeltekstur->CurrentValue = null;
        $this->labeltekstur->OldValue = $this->labeltekstur->CurrentValue;
        $this->labelprint->CurrentValue = null;
        $this->labelprint->OldValue = $this->labelprint->CurrentValue;
        $this->labeljmlwarna->CurrentValue = null;
        $this->labeljmlwarna->OldValue = $this->labeljmlwarna->CurrentValue;
        $this->labelcatatanhotprint->CurrentValue = null;
        $this->labelcatatanhotprint->OldValue = $this->labelcatatanhotprint->CurrentValue;
        $this->ukuran_utama->CurrentValue = null;
        $this->ukuran_utama->OldValue = $this->ukuran_utama->CurrentValue;
        $this->utama_harga_isi->CurrentValue = null;
        $this->utama_harga_isi->OldValue = $this->utama_harga_isi->CurrentValue;
        $this->utama_harga_isi_proyeksi->CurrentValue = null;
        $this->utama_harga_isi_proyeksi->OldValue = $this->utama_harga_isi_proyeksi->CurrentValue;
        $this->utama_harga_primer->CurrentValue = null;
        $this->utama_harga_primer->OldValue = $this->utama_harga_primer->CurrentValue;
        $this->utama_harga_primer_proyeksi->CurrentValue = null;
        $this->utama_harga_primer_proyeksi->OldValue = $this->utama_harga_primer_proyeksi->CurrentValue;
        $this->utama_harga_sekunder->CurrentValue = null;
        $this->utama_harga_sekunder->OldValue = $this->utama_harga_sekunder->CurrentValue;
        $this->utama_harga_sekunder_proyeksi->CurrentValue = null;
        $this->utama_harga_sekunder_proyeksi->OldValue = $this->utama_harga_sekunder_proyeksi->CurrentValue;
        $this->utama_harga_label->CurrentValue = null;
        $this->utama_harga_label->OldValue = $this->utama_harga_label->CurrentValue;
        $this->utama_harga_label_proyeksi->CurrentValue = null;
        $this->utama_harga_label_proyeksi->OldValue = $this->utama_harga_label_proyeksi->CurrentValue;
        $this->utama_harga_total->CurrentValue = null;
        $this->utama_harga_total->OldValue = $this->utama_harga_total->CurrentValue;
        $this->utama_harga_total_proyeksi->CurrentValue = null;
        $this->utama_harga_total_proyeksi->OldValue = $this->utama_harga_total_proyeksi->CurrentValue;
        $this->ukuran_lain->CurrentValue = null;
        $this->ukuran_lain->OldValue = $this->ukuran_lain->CurrentValue;
        $this->lain_harga_isi->CurrentValue = null;
        $this->lain_harga_isi->OldValue = $this->lain_harga_isi->CurrentValue;
        $this->lain_harga_isi_proyeksi->CurrentValue = null;
        $this->lain_harga_isi_proyeksi->OldValue = $this->lain_harga_isi_proyeksi->CurrentValue;
        $this->lain_harga_primer->CurrentValue = null;
        $this->lain_harga_primer->OldValue = $this->lain_harga_primer->CurrentValue;
        $this->lain_harga_primer_proyeksi->CurrentValue = null;
        $this->lain_harga_primer_proyeksi->OldValue = $this->lain_harga_primer_proyeksi->CurrentValue;
        $this->lain_harga_sekunder->CurrentValue = null;
        $this->lain_harga_sekunder->OldValue = $this->lain_harga_sekunder->CurrentValue;
        $this->lain_harga_sekunder_proyeksi->CurrentValue = null;
        $this->lain_harga_sekunder_proyeksi->OldValue = $this->lain_harga_sekunder_proyeksi->CurrentValue;
        $this->lain_harga_label->CurrentValue = null;
        $this->lain_harga_label->OldValue = $this->lain_harga_label->CurrentValue;
        $this->lain_harga_label_proyeksi->CurrentValue = null;
        $this->lain_harga_label_proyeksi->OldValue = $this->lain_harga_label_proyeksi->CurrentValue;
        $this->lain_harga_total->CurrentValue = null;
        $this->lain_harga_total->OldValue = $this->lain_harga_total->CurrentValue;
        $this->lain_harga_total_proyeksi->CurrentValue = null;
        $this->lain_harga_total_proyeksi->OldValue = $this->lain_harga_total_proyeksi->CurrentValue;
        $this->delivery_pickup->CurrentValue = null;
        $this->delivery_pickup->OldValue = $this->delivery_pickup->CurrentValue;
        $this->delivery_singlepoint->CurrentValue = null;
        $this->delivery_singlepoint->OldValue = $this->delivery_singlepoint->CurrentValue;
        $this->delivery_multipoint->CurrentValue = null;
        $this->delivery_multipoint->OldValue = $this->delivery_multipoint->CurrentValue;
        $this->delivery_termlain->CurrentValue = null;
        $this->delivery_termlain->OldValue = $this->delivery_termlain->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->readonly->CurrentValue = 0;
        $this->receipt_by->CurrentValue = 0;
        $this->approve_by->CurrentValue = 0;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
        $this->selesai->CurrentValue = CurrentDate();
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

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

        // Check field name 'idbrand' first before field var 'x_idbrand'
        $val = $CurrentForm->hasValue("idbrand") ? $CurrentForm->getValue("idbrand") : $CurrentForm->getValue("x_idbrand");
        if (!$this->idbrand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idbrand->Visible = false; // Disable update for API request
            } else {
                $this->idbrand->setFormValue($val);
            }
        }

        // Check field name 'tanggal_order' first before field var 'x_tanggal_order'
        $val = $CurrentForm->hasValue("tanggal_order") ? $CurrentForm->getValue("tanggal_order") : $CurrentForm->getValue("x_tanggal_order");
        if (!$this->tanggal_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_order->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_order->setFormValue($val);
            }
            $this->tanggal_order->CurrentValue = UnFormatDateTime($this->tanggal_order->CurrentValue, 0);
        }

        // Check field name 'target_selesai' first before field var 'x_target_selesai'
        $val = $CurrentForm->hasValue("target_selesai") ? $CurrentForm->getValue("target_selesai") : $CurrentForm->getValue("x_target_selesai");
        if (!$this->target_selesai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->target_selesai->Visible = false; // Disable update for API request
            } else {
                $this->target_selesai->setFormValue($val);
            }
            $this->target_selesai->CurrentValue = UnFormatDateTime($this->target_selesai->CurrentValue, 0);
        }

        // Check field name 'sifatorder' first before field var 'x_sifatorder'
        $val = $CurrentForm->hasValue("sifatorder") ? $CurrentForm->getValue("sifatorder") : $CurrentForm->getValue("x_sifatorder");
        if (!$this->sifatorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sifatorder->Visible = false; // Disable update for API request
            } else {
                $this->sifatorder->setFormValue($val);
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

        // Check field name 'nomororder' first before field var 'x_nomororder'
        $val = $CurrentForm->hasValue("nomororder") ? $CurrentForm->getValue("nomororder") : $CurrentForm->getValue("x_nomororder");
        if (!$this->nomororder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomororder->Visible = false; // Disable update for API request
            } else {
                $this->nomororder->setFormValue($val);
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

        // Check field name 'kategoriproduk' first before field var 'x_kategoriproduk'
        $val = $CurrentForm->hasValue("kategoriproduk") ? $CurrentForm->getValue("kategoriproduk") : $CurrentForm->getValue("x_kategoriproduk");
        if (!$this->kategoriproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategoriproduk->Visible = false; // Disable update for API request
            } else {
                $this->kategoriproduk->setFormValue($val);
            }
        }

        // Check field name 'jenisproduk' first before field var 'x_jenisproduk'
        $val = $CurrentForm->hasValue("jenisproduk") ? $CurrentForm->getValue("jenisproduk") : $CurrentForm->getValue("x_jenisproduk");
        if (!$this->jenisproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenisproduk->Visible = false; // Disable update for API request
            } else {
                $this->jenisproduk->setFormValue($val);
            }
        }

        // Check field name 'fungsiproduk' first before field var 'x_fungsiproduk'
        $val = $CurrentForm->hasValue("fungsiproduk") ? $CurrentForm->getValue("fungsiproduk") : $CurrentForm->getValue("x_fungsiproduk");
        if (!$this->fungsiproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fungsiproduk->Visible = false; // Disable update for API request
            } else {
                $this->fungsiproduk->setFormValue($val);
            }
        }

        // Check field name 'kualitasproduk' first before field var 'x_kualitasproduk'
        $val = $CurrentForm->hasValue("kualitasproduk") ? $CurrentForm->getValue("kualitasproduk") : $CurrentForm->getValue("x_kualitasproduk");
        if (!$this->kualitasproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kualitasproduk->Visible = false; // Disable update for API request
            } else {
                $this->kualitasproduk->setFormValue($val);
            }
        }

        // Check field name 'bahan_campaign' first before field var 'x_bahan_campaign'
        $val = $CurrentForm->hasValue("bahan_campaign") ? $CurrentForm->getValue("bahan_campaign") : $CurrentForm->getValue("x_bahan_campaign");
        if (!$this->bahan_campaign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahan_campaign->Visible = false; // Disable update for API request
            } else {
                $this->bahan_campaign->setFormValue($val);
            }
        }

        // Check field name 'ukuransediaan' first before field var 'x_ukuransediaan'
        $val = $CurrentForm->hasValue("ukuransediaan") ? $CurrentForm->getValue("ukuransediaan") : $CurrentForm->getValue("x_ukuransediaan");
        if (!$this->ukuransediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuransediaan->Visible = false; // Disable update for API request
            } else {
                $this->ukuransediaan->setFormValue($val);
            }
        }

        // Check field name 'satuansediaan' first before field var 'x_satuansediaan'
        $val = $CurrentForm->hasValue("satuansediaan") ? $CurrentForm->getValue("satuansediaan") : $CurrentForm->getValue("x_satuansediaan");
        if (!$this->satuansediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->satuansediaan->Visible = false; // Disable update for API request
            } else {
                $this->satuansediaan->setFormValue($val);
            }
        }

        // Check field name 'bentuk' first before field var 'x_bentuk'
        $val = $CurrentForm->hasValue("bentuk") ? $CurrentForm->getValue("bentuk") : $CurrentForm->getValue("x_bentuk");
        if (!$this->bentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuk->Visible = false; // Disable update for API request
            } else {
                $this->bentuk->setFormValue($val);
            }
        }

        // Check field name 'viskositas' first before field var 'x_viskositas'
        $val = $CurrentForm->hasValue("viskositas") ? $CurrentForm->getValue("viskositas") : $CurrentForm->getValue("x_viskositas");
        if (!$this->viskositas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositas->Visible = false; // Disable update for API request
            } else {
                $this->viskositas->setFormValue($val);
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

        // Check field name 'aroma' first before field var 'x_aroma'
        $val = $CurrentForm->hasValue("aroma") ? $CurrentForm->getValue("aroma") : $CurrentForm->getValue("x_aroma");
        if (!$this->aroma->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aroma->Visible = false; // Disable update for API request
            } else {
                $this->aroma->setFormValue($val);
            }
        }

        // Check field name 'aplikasi' first before field var 'x_aplikasi'
        $val = $CurrentForm->hasValue("aplikasi") ? $CurrentForm->getValue("aplikasi") : $CurrentForm->getValue("x_aplikasi");
        if (!$this->aplikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasi->setFormValue($val);
            }
        }

        // Check field name 'estetika' first before field var 'x_estetika'
        $val = $CurrentForm->hasValue("estetika") ? $CurrentForm->getValue("estetika") : $CurrentForm->getValue("x_estetika");
        if (!$this->estetika->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estetika->Visible = false; // Disable update for API request
            } else {
                $this->estetika->setFormValue($val);
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

        // Check field name 'ukurankemasan' first before field var 'x_ukurankemasan'
        $val = $CurrentForm->hasValue("ukurankemasan") ? $CurrentForm->getValue("ukurankemasan") : $CurrentForm->getValue("x_ukurankemasan");
        if (!$this->ukurankemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukurankemasan->Visible = false; // Disable update for API request
            } else {
                $this->ukurankemasan->setFormValue($val);
            }
        }

        // Check field name 'satuankemasan' first before field var 'x_satuankemasan'
        $val = $CurrentForm->hasValue("satuankemasan") ? $CurrentForm->getValue("satuankemasan") : $CurrentForm->getValue("x_satuankemasan");
        if (!$this->satuankemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->satuankemasan->Visible = false; // Disable update for API request
            } else {
                $this->satuankemasan->setFormValue($val);
            }
        }

        // Check field name 'kemasanwadah' first before field var 'x_kemasanwadah'
        $val = $CurrentForm->hasValue("kemasanwadah") ? $CurrentForm->getValue("kemasanwadah") : $CurrentForm->getValue("x_kemasanwadah");
        if (!$this->kemasanwadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanwadah->Visible = false; // Disable update for API request
            } else {
                $this->kemasanwadah->setFormValue($val);
            }
        }

        // Check field name 'kemasantutup' first before field var 'x_kemasantutup'
        $val = $CurrentForm->hasValue("kemasantutup") ? $CurrentForm->getValue("kemasantutup") : $CurrentForm->getValue("x_kemasantutup");
        if (!$this->kemasantutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasantutup->Visible = false; // Disable update for API request
            } else {
                $this->kemasantutup->setFormValue($val);
            }
        }

        // Check field name 'kemasancatatan' first before field var 'x_kemasancatatan'
        $val = $CurrentForm->hasValue("kemasancatatan") ? $CurrentForm->getValue("kemasancatatan") : $CurrentForm->getValue("x_kemasancatatan");
        if (!$this->kemasancatatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasancatatan->Visible = false; // Disable update for API request
            } else {
                $this->kemasancatatan->setFormValue($val);
            }
        }

        // Check field name 'ukurankemasansekunder' first before field var 'x_ukurankemasansekunder'
        $val = $CurrentForm->hasValue("ukurankemasansekunder") ? $CurrentForm->getValue("ukurankemasansekunder") : $CurrentForm->getValue("x_ukurankemasansekunder");
        if (!$this->ukurankemasansekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukurankemasansekunder->Visible = false; // Disable update for API request
            } else {
                $this->ukurankemasansekunder->setFormValue($val);
            }
        }

        // Check field name 'satuankemasansekunder' first before field var 'x_satuankemasansekunder'
        $val = $CurrentForm->hasValue("satuankemasansekunder") ? $CurrentForm->getValue("satuankemasansekunder") : $CurrentForm->getValue("x_satuankemasansekunder");
        if (!$this->satuankemasansekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->satuankemasansekunder->Visible = false; // Disable update for API request
            } else {
                $this->satuankemasansekunder->setFormValue($val);
            }
        }

        // Check field name 'kemasanbahan' first before field var 'x_kemasanbahan'
        $val = $CurrentForm->hasValue("kemasanbahan") ? $CurrentForm->getValue("kemasanbahan") : $CurrentForm->getValue("x_kemasanbahan");
        if (!$this->kemasanbahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanbahan->Visible = false; // Disable update for API request
            } else {
                $this->kemasanbahan->setFormValue($val);
            }
        }

        // Check field name 'kemasanbentuk' first before field var 'x_kemasanbentuk'
        $val = $CurrentForm->hasValue("kemasanbentuk") ? $CurrentForm->getValue("kemasanbentuk") : $CurrentForm->getValue("x_kemasanbentuk");
        if (!$this->kemasanbentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanbentuk->Visible = false; // Disable update for API request
            } else {
                $this->kemasanbentuk->setFormValue($val);
            }
        }

        // Check field name 'kemasankomposisi' first before field var 'x_kemasankomposisi'
        $val = $CurrentForm->hasValue("kemasankomposisi") ? $CurrentForm->getValue("kemasankomposisi") : $CurrentForm->getValue("x_kemasankomposisi");
        if (!$this->kemasankomposisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasankomposisi->Visible = false; // Disable update for API request
            } else {
                $this->kemasankomposisi->setFormValue($val);
            }
        }

        // Check field name 'kemasancatatansekunder' first before field var 'x_kemasancatatansekunder'
        $val = $CurrentForm->hasValue("kemasancatatansekunder") ? $CurrentForm->getValue("kemasancatatansekunder") : $CurrentForm->getValue("x_kemasancatatansekunder");
        if (!$this->kemasancatatansekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasancatatansekunder->Visible = false; // Disable update for API request
            } else {
                $this->kemasancatatansekunder->setFormValue($val);
            }
        }

        // Check field name 'labelbahan' first before field var 'x_labelbahan'
        $val = $CurrentForm->hasValue("labelbahan") ? $CurrentForm->getValue("labelbahan") : $CurrentForm->getValue("x_labelbahan");
        if (!$this->labelbahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelbahan->Visible = false; // Disable update for API request
            } else {
                $this->labelbahan->setFormValue($val);
            }
        }

        // Check field name 'labelkualitas' first before field var 'x_labelkualitas'
        $val = $CurrentForm->hasValue("labelkualitas") ? $CurrentForm->getValue("labelkualitas") : $CurrentForm->getValue("x_labelkualitas");
        if (!$this->labelkualitas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelkualitas->Visible = false; // Disable update for API request
            } else {
                $this->labelkualitas->setFormValue($val);
            }
        }

        // Check field name 'labelposisi' first before field var 'x_labelposisi'
        $val = $CurrentForm->hasValue("labelposisi") ? $CurrentForm->getValue("labelposisi") : $CurrentForm->getValue("x_labelposisi");
        if (!$this->labelposisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelposisi->Visible = false; // Disable update for API request
            } else {
                $this->labelposisi->setFormValue($val);
            }
        }

        // Check field name 'labelcatatan' first before field var 'x_labelcatatan'
        $val = $CurrentForm->hasValue("labelcatatan") ? $CurrentForm->getValue("labelcatatan") : $CurrentForm->getValue("x_labelcatatan");
        if (!$this->labelcatatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelcatatan->Visible = false; // Disable update for API request
            } else {
                $this->labelcatatan->setFormValue($val);
            }
        }

        // Check field name 'labeltekstur' first before field var 'x_labeltekstur'
        $val = $CurrentForm->hasValue("labeltekstur") ? $CurrentForm->getValue("labeltekstur") : $CurrentForm->getValue("x_labeltekstur");
        if (!$this->labeltekstur->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labeltekstur->Visible = false; // Disable update for API request
            } else {
                $this->labeltekstur->setFormValue($val);
            }
        }

        // Check field name 'labelprint' first before field var 'x_labelprint'
        $val = $CurrentForm->hasValue("labelprint") ? $CurrentForm->getValue("labelprint") : $CurrentForm->getValue("x_labelprint");
        if (!$this->labelprint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelprint->Visible = false; // Disable update for API request
            } else {
                $this->labelprint->setFormValue($val);
            }
        }

        // Check field name 'labeljmlwarna' first before field var 'x_labeljmlwarna'
        $val = $CurrentForm->hasValue("labeljmlwarna") ? $CurrentForm->getValue("labeljmlwarna") : $CurrentForm->getValue("x_labeljmlwarna");
        if (!$this->labeljmlwarna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labeljmlwarna->Visible = false; // Disable update for API request
            } else {
                $this->labeljmlwarna->setFormValue($val);
            }
        }

        // Check field name 'labelcatatanhotprint' first before field var 'x_labelcatatanhotprint'
        $val = $CurrentForm->hasValue("labelcatatanhotprint") ? $CurrentForm->getValue("labelcatatanhotprint") : $CurrentForm->getValue("x_labelcatatanhotprint");
        if (!$this->labelcatatanhotprint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelcatatanhotprint->Visible = false; // Disable update for API request
            } else {
                $this->labelcatatanhotprint->setFormValue($val);
            }
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

        // Check field name 'utama_harga_isi' first before field var 'x_utama_harga_isi'
        $val = $CurrentForm->hasValue("utama_harga_isi") ? $CurrentForm->getValue("utama_harga_isi") : $CurrentForm->getValue("x_utama_harga_isi");
        if (!$this->utama_harga_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_isi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_isi->setFormValue($val);
            }
        }

        // Check field name 'utama_harga_isi_proyeksi' first before field var 'x_utama_harga_isi_proyeksi'
        $val = $CurrentForm->hasValue("utama_harga_isi_proyeksi") ? $CurrentForm->getValue("utama_harga_isi_proyeksi") : $CurrentForm->getValue("x_utama_harga_isi_proyeksi");
        if (!$this->utama_harga_isi_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_isi_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_isi_proyeksi->setFormValue($val);
            }
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

        // Check field name 'utama_harga_primer_proyeksi' first before field var 'x_utama_harga_primer_proyeksi'
        $val = $CurrentForm->hasValue("utama_harga_primer_proyeksi") ? $CurrentForm->getValue("utama_harga_primer_proyeksi") : $CurrentForm->getValue("x_utama_harga_primer_proyeksi");
        if (!$this->utama_harga_primer_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_primer_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_primer_proyeksi->setFormValue($val);
            }
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

        // Check field name 'utama_harga_sekunder_proyeksi' first before field var 'x_utama_harga_sekunder_proyeksi'
        $val = $CurrentForm->hasValue("utama_harga_sekunder_proyeksi") ? $CurrentForm->getValue("utama_harga_sekunder_proyeksi") : $CurrentForm->getValue("x_utama_harga_sekunder_proyeksi");
        if (!$this->utama_harga_sekunder_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_sekunder_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_sekunder_proyeksi->setFormValue($val);
            }
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

        // Check field name 'utama_harga_label_proyeksi' first before field var 'x_utama_harga_label_proyeksi'
        $val = $CurrentForm->hasValue("utama_harga_label_proyeksi") ? $CurrentForm->getValue("utama_harga_label_proyeksi") : $CurrentForm->getValue("x_utama_harga_label_proyeksi");
        if (!$this->utama_harga_label_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_label_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_label_proyeksi->setFormValue($val);
            }
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

        // Check field name 'utama_harga_total_proyeksi' first before field var 'x_utama_harga_total_proyeksi'
        $val = $CurrentForm->hasValue("utama_harga_total_proyeksi") ? $CurrentForm->getValue("utama_harga_total_proyeksi") : $CurrentForm->getValue("x_utama_harga_total_proyeksi");
        if (!$this->utama_harga_total_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utama_harga_total_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->utama_harga_total_proyeksi->setFormValue($val);
            }
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

        // Check field name 'lain_harga_isi' first before field var 'x_lain_harga_isi'
        $val = $CurrentForm->hasValue("lain_harga_isi") ? $CurrentForm->getValue("lain_harga_isi") : $CurrentForm->getValue("x_lain_harga_isi");
        if (!$this->lain_harga_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_isi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_isi->setFormValue($val);
            }
        }

        // Check field name 'lain_harga_isi_proyeksi' first before field var 'x_lain_harga_isi_proyeksi'
        $val = $CurrentForm->hasValue("lain_harga_isi_proyeksi") ? $CurrentForm->getValue("lain_harga_isi_proyeksi") : $CurrentForm->getValue("x_lain_harga_isi_proyeksi");
        if (!$this->lain_harga_isi_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_isi_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_isi_proyeksi->setFormValue($val);
            }
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

        // Check field name 'lain_harga_primer_proyeksi' first before field var 'x_lain_harga_primer_proyeksi'
        $val = $CurrentForm->hasValue("lain_harga_primer_proyeksi") ? $CurrentForm->getValue("lain_harga_primer_proyeksi") : $CurrentForm->getValue("x_lain_harga_primer_proyeksi");
        if (!$this->lain_harga_primer_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_primer_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_primer_proyeksi->setFormValue($val);
            }
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

        // Check field name 'lain_harga_sekunder_proyeksi' first before field var 'x_lain_harga_sekunder_proyeksi'
        $val = $CurrentForm->hasValue("lain_harga_sekunder_proyeksi") ? $CurrentForm->getValue("lain_harga_sekunder_proyeksi") : $CurrentForm->getValue("x_lain_harga_sekunder_proyeksi");
        if (!$this->lain_harga_sekunder_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_sekunder_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_sekunder_proyeksi->setFormValue($val);
            }
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

        // Check field name 'lain_harga_label_proyeksi' first before field var 'x_lain_harga_label_proyeksi'
        $val = $CurrentForm->hasValue("lain_harga_label_proyeksi") ? $CurrentForm->getValue("lain_harga_label_proyeksi") : $CurrentForm->getValue("x_lain_harga_label_proyeksi");
        if (!$this->lain_harga_label_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_label_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_label_proyeksi->setFormValue($val);
            }
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

        // Check field name 'lain_harga_total_proyeksi' first before field var 'x_lain_harga_total_proyeksi'
        $val = $CurrentForm->hasValue("lain_harga_total_proyeksi") ? $CurrentForm->getValue("lain_harga_total_proyeksi") : $CurrentForm->getValue("x_lain_harga_total_proyeksi");
        if (!$this->lain_harga_total_proyeksi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lain_harga_total_proyeksi->Visible = false; // Disable update for API request
            } else {
                $this->lain_harga_total_proyeksi->setFormValue($val);
            }
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

        // Check field name 'delivery_singlepoint' first before field var 'x_delivery_singlepoint'
        $val = $CurrentForm->hasValue("delivery_singlepoint") ? $CurrentForm->getValue("delivery_singlepoint") : $CurrentForm->getValue("x_delivery_singlepoint");
        if (!$this->delivery_singlepoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_singlepoint->Visible = false; // Disable update for API request
            } else {
                $this->delivery_singlepoint->setFormValue($val);
            }
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

        // Check field name 'delivery_termlain' first before field var 'x_delivery_termlain'
        $val = $CurrentForm->hasValue("delivery_termlain") ? $CurrentForm->getValue("delivery_termlain") : $CurrentForm->getValue("x_delivery_termlain");
        if (!$this->delivery_termlain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->delivery_termlain->Visible = false; // Disable update for API request
            } else {
                $this->delivery_termlain->setFormValue($val);
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

        // Check field name 'receipt_by' first before field var 'x_receipt_by'
        $val = $CurrentForm->hasValue("receipt_by") ? $CurrentForm->getValue("receipt_by") : $CurrentForm->getValue("x_receipt_by");
        if (!$this->receipt_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receipt_by->Visible = false; // Disable update for API request
            } else {
                $this->receipt_by->setFormValue($val);
            }
        }

        // Check field name 'approve_by' first before field var 'x_approve_by'
        $val = $CurrentForm->hasValue("approve_by") ? $CurrentForm->getValue("approve_by") : $CurrentForm->getValue("x_approve_by");
        if (!$this->approve_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->approve_by->Visible = false; // Disable update for API request
            } else {
                $this->approve_by->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->idbrand->CurrentValue = $this->idbrand->FormValue;
        $this->tanggal_order->CurrentValue = $this->tanggal_order->FormValue;
        $this->tanggal_order->CurrentValue = UnFormatDateTime($this->tanggal_order->CurrentValue, 0);
        $this->target_selesai->CurrentValue = $this->target_selesai->FormValue;
        $this->target_selesai->CurrentValue = UnFormatDateTime($this->target_selesai->CurrentValue, 0);
        $this->sifatorder->CurrentValue = $this->sifatorder->FormValue;
        $this->kodeorder->CurrentValue = $this->kodeorder->FormValue;
        $this->nomororder->CurrentValue = $this->nomororder->FormValue;
        $this->idproduct_acuan->CurrentValue = $this->idproduct_acuan->FormValue;
        $this->kategoriproduk->CurrentValue = $this->kategoriproduk->FormValue;
        $this->jenisproduk->CurrentValue = $this->jenisproduk->FormValue;
        $this->fungsiproduk->CurrentValue = $this->fungsiproduk->FormValue;
        $this->kualitasproduk->CurrentValue = $this->kualitasproduk->FormValue;
        $this->bahan_campaign->CurrentValue = $this->bahan_campaign->FormValue;
        $this->ukuransediaan->CurrentValue = $this->ukuransediaan->FormValue;
        $this->satuansediaan->CurrentValue = $this->satuansediaan->FormValue;
        $this->bentuk->CurrentValue = $this->bentuk->FormValue;
        $this->viskositas->CurrentValue = $this->viskositas->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->parfum->CurrentValue = $this->parfum->FormValue;
        $this->aroma->CurrentValue = $this->aroma->FormValue;
        $this->aplikasi->CurrentValue = $this->aplikasi->FormValue;
        $this->estetika->CurrentValue = $this->estetika->FormValue;
        $this->tambahan->CurrentValue = $this->tambahan->FormValue;
        $this->ukurankemasan->CurrentValue = $this->ukurankemasan->FormValue;
        $this->satuankemasan->CurrentValue = $this->satuankemasan->FormValue;
        $this->kemasanwadah->CurrentValue = $this->kemasanwadah->FormValue;
        $this->kemasantutup->CurrentValue = $this->kemasantutup->FormValue;
        $this->kemasancatatan->CurrentValue = $this->kemasancatatan->FormValue;
        $this->ukurankemasansekunder->CurrentValue = $this->ukurankemasansekunder->FormValue;
        $this->satuankemasansekunder->CurrentValue = $this->satuankemasansekunder->FormValue;
        $this->kemasanbahan->CurrentValue = $this->kemasanbahan->FormValue;
        $this->kemasanbentuk->CurrentValue = $this->kemasanbentuk->FormValue;
        $this->kemasankomposisi->CurrentValue = $this->kemasankomposisi->FormValue;
        $this->kemasancatatansekunder->CurrentValue = $this->kemasancatatansekunder->FormValue;
        $this->labelbahan->CurrentValue = $this->labelbahan->FormValue;
        $this->labelkualitas->CurrentValue = $this->labelkualitas->FormValue;
        $this->labelposisi->CurrentValue = $this->labelposisi->FormValue;
        $this->labelcatatan->CurrentValue = $this->labelcatatan->FormValue;
        $this->labeltekstur->CurrentValue = $this->labeltekstur->FormValue;
        $this->labelprint->CurrentValue = $this->labelprint->FormValue;
        $this->labeljmlwarna->CurrentValue = $this->labeljmlwarna->FormValue;
        $this->labelcatatanhotprint->CurrentValue = $this->labelcatatanhotprint->FormValue;
        $this->ukuran_utama->CurrentValue = $this->ukuran_utama->FormValue;
        $this->utama_harga_isi->CurrentValue = $this->utama_harga_isi->FormValue;
        $this->utama_harga_isi_proyeksi->CurrentValue = $this->utama_harga_isi_proyeksi->FormValue;
        $this->utama_harga_primer->CurrentValue = $this->utama_harga_primer->FormValue;
        $this->utama_harga_primer_proyeksi->CurrentValue = $this->utama_harga_primer_proyeksi->FormValue;
        $this->utama_harga_sekunder->CurrentValue = $this->utama_harga_sekunder->FormValue;
        $this->utama_harga_sekunder_proyeksi->CurrentValue = $this->utama_harga_sekunder_proyeksi->FormValue;
        $this->utama_harga_label->CurrentValue = $this->utama_harga_label->FormValue;
        $this->utama_harga_label_proyeksi->CurrentValue = $this->utama_harga_label_proyeksi->FormValue;
        $this->utama_harga_total->CurrentValue = $this->utama_harga_total->FormValue;
        $this->utama_harga_total_proyeksi->CurrentValue = $this->utama_harga_total_proyeksi->FormValue;
        $this->ukuran_lain->CurrentValue = $this->ukuran_lain->FormValue;
        $this->lain_harga_isi->CurrentValue = $this->lain_harga_isi->FormValue;
        $this->lain_harga_isi_proyeksi->CurrentValue = $this->lain_harga_isi_proyeksi->FormValue;
        $this->lain_harga_primer->CurrentValue = $this->lain_harga_primer->FormValue;
        $this->lain_harga_primer_proyeksi->CurrentValue = $this->lain_harga_primer_proyeksi->FormValue;
        $this->lain_harga_sekunder->CurrentValue = $this->lain_harga_sekunder->FormValue;
        $this->lain_harga_sekunder_proyeksi->CurrentValue = $this->lain_harga_sekunder_proyeksi->FormValue;
        $this->lain_harga_label->CurrentValue = $this->lain_harga_label->FormValue;
        $this->lain_harga_label_proyeksi->CurrentValue = $this->lain_harga_label_proyeksi->FormValue;
        $this->lain_harga_total->CurrentValue = $this->lain_harga_total->FormValue;
        $this->lain_harga_total_proyeksi->CurrentValue = $this->lain_harga_total_proyeksi->FormValue;
        $this->delivery_pickup->CurrentValue = $this->delivery_pickup->FormValue;
        $this->delivery_singlepoint->CurrentValue = $this->delivery_singlepoint->FormValue;
        $this->delivery_multipoint->CurrentValue = $this->delivery_multipoint->FormValue;
        $this->delivery_termlain->CurrentValue = $this->delivery_termlain->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->receipt_by->CurrentValue = $this->receipt_by->FormValue;
        $this->approve_by->CurrentValue = $this->approve_by->FormValue;
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
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->sifatorder->setDbValue($row['sifatorder']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuransediaan->setDbValue($row['ukuransediaan']);
        $this->satuansediaan->setDbValue($row['satuansediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aroma->setDbValue($row['aroma']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->estetika->setDbValue($row['estetika']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->satuankemasan->setDbValue($row['satuankemasan']);
        $this->kemasanwadah->setDbValue($row['kemasanwadah']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->ukurankemasansekunder->setDbValue($row['ukurankemasansekunder']);
        $this->satuankemasansekunder->setDbValue($row['satuankemasansekunder']);
        $this->kemasanbahan->setDbValue($row['kemasanbahan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasankomposisi->setDbValue($row['kemasankomposisi']);
        $this->kemasancatatansekunder->setDbValue($row['kemasancatatansekunder']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->labeltekstur->setDbValue($row['labeltekstur']);
        $this->labelprint->setDbValue($row['labelprint']);
        $this->labeljmlwarna->setDbValue($row['labeljmlwarna']);
        $this->labelcatatanhotprint->setDbValue($row['labelcatatanhotprint']);
        $this->ukuran_utama->setDbValue($row['ukuran_utama']);
        $this->utama_harga_isi->setDbValue($row['utama_harga_isi']);
        $this->utama_harga_isi_proyeksi->setDbValue($row['utama_harga_isi_proyeksi']);
        $this->utama_harga_primer->setDbValue($row['utama_harga_primer']);
        $this->utama_harga_primer_proyeksi->setDbValue($row['utama_harga_primer_proyeksi']);
        $this->utama_harga_sekunder->setDbValue($row['utama_harga_sekunder']);
        $this->utama_harga_sekunder_proyeksi->setDbValue($row['utama_harga_sekunder_proyeksi']);
        $this->utama_harga_label->setDbValue($row['utama_harga_label']);
        $this->utama_harga_label_proyeksi->setDbValue($row['utama_harga_label_proyeksi']);
        $this->utama_harga_total->setDbValue($row['utama_harga_total']);
        $this->utama_harga_total_proyeksi->setDbValue($row['utama_harga_total_proyeksi']);
        $this->ukuran_lain->setDbValue($row['ukuran_lain']);
        $this->lain_harga_isi->setDbValue($row['lain_harga_isi']);
        $this->lain_harga_isi_proyeksi->setDbValue($row['lain_harga_isi_proyeksi']);
        $this->lain_harga_primer->setDbValue($row['lain_harga_primer']);
        $this->lain_harga_primer_proyeksi->setDbValue($row['lain_harga_primer_proyeksi']);
        $this->lain_harga_sekunder->setDbValue($row['lain_harga_sekunder']);
        $this->lain_harga_sekunder_proyeksi->setDbValue($row['lain_harga_sekunder_proyeksi']);
        $this->lain_harga_label->setDbValue($row['lain_harga_label']);
        $this->lain_harga_label_proyeksi->setDbValue($row['lain_harga_label_proyeksi']);
        $this->lain_harga_total->setDbValue($row['lain_harga_total']);
        $this->lain_harga_total_proyeksi->setDbValue($row['lain_harga_total_proyeksi']);
        $this->delivery_pickup->setDbValue($row['delivery_pickup']);
        $this->delivery_singlepoint->setDbValue($row['delivery_singlepoint']);
        $this->delivery_multipoint->setDbValue($row['delivery_multipoint']);
        $this->delivery_termlain->setDbValue($row['delivery_termlain']);
        $this->status->setDbValue($row['status']);
        $this->readonly->setDbValue($row['readonly']);
        $this->receipt_by->setDbValue($row['receipt_by']);
        $this->approve_by->setDbValue($row['approve_by']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->selesai->setDbValue($row['selesai']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idpegawai'] = $this->idpegawai->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['idbrand'] = $this->idbrand->CurrentValue;
        $row['tanggal_order'] = $this->tanggal_order->CurrentValue;
        $row['target_selesai'] = $this->target_selesai->CurrentValue;
        $row['sifatorder'] = $this->sifatorder->CurrentValue;
        $row['kodeorder'] = $this->kodeorder->CurrentValue;
        $row['nomororder'] = $this->nomororder->CurrentValue;
        $row['idproduct_acuan'] = $this->idproduct_acuan->CurrentValue;
        $row['kategoriproduk'] = $this->kategoriproduk->CurrentValue;
        $row['jenisproduk'] = $this->jenisproduk->CurrentValue;
        $row['fungsiproduk'] = $this->fungsiproduk->CurrentValue;
        $row['kualitasproduk'] = $this->kualitasproduk->CurrentValue;
        $row['bahan_campaign'] = $this->bahan_campaign->CurrentValue;
        $row['ukuransediaan'] = $this->ukuransediaan->CurrentValue;
        $row['satuansediaan'] = $this->satuansediaan->CurrentValue;
        $row['bentuk'] = $this->bentuk->CurrentValue;
        $row['viskositas'] = $this->viskositas->CurrentValue;
        $row['warna'] = $this->warna->CurrentValue;
        $row['parfum'] = $this->parfum->CurrentValue;
        $row['aroma'] = $this->aroma->CurrentValue;
        $row['aplikasi'] = $this->aplikasi->CurrentValue;
        $row['estetika'] = $this->estetika->CurrentValue;
        $row['tambahan'] = $this->tambahan->CurrentValue;
        $row['ukurankemasan'] = $this->ukurankemasan->CurrentValue;
        $row['satuankemasan'] = $this->satuankemasan->CurrentValue;
        $row['kemasanwadah'] = $this->kemasanwadah->CurrentValue;
        $row['kemasantutup'] = $this->kemasantutup->CurrentValue;
        $row['kemasancatatan'] = $this->kemasancatatan->CurrentValue;
        $row['ukurankemasansekunder'] = $this->ukurankemasansekunder->CurrentValue;
        $row['satuankemasansekunder'] = $this->satuankemasansekunder->CurrentValue;
        $row['kemasanbahan'] = $this->kemasanbahan->CurrentValue;
        $row['kemasanbentuk'] = $this->kemasanbentuk->CurrentValue;
        $row['kemasankomposisi'] = $this->kemasankomposisi->CurrentValue;
        $row['kemasancatatansekunder'] = $this->kemasancatatansekunder->CurrentValue;
        $row['labelbahan'] = $this->labelbahan->CurrentValue;
        $row['labelkualitas'] = $this->labelkualitas->CurrentValue;
        $row['labelposisi'] = $this->labelposisi->CurrentValue;
        $row['labelcatatan'] = $this->labelcatatan->CurrentValue;
        $row['labeltekstur'] = $this->labeltekstur->CurrentValue;
        $row['labelprint'] = $this->labelprint->CurrentValue;
        $row['labeljmlwarna'] = $this->labeljmlwarna->CurrentValue;
        $row['labelcatatanhotprint'] = $this->labelcatatanhotprint->CurrentValue;
        $row['ukuran_utama'] = $this->ukuran_utama->CurrentValue;
        $row['utama_harga_isi'] = $this->utama_harga_isi->CurrentValue;
        $row['utama_harga_isi_proyeksi'] = $this->utama_harga_isi_proyeksi->CurrentValue;
        $row['utama_harga_primer'] = $this->utama_harga_primer->CurrentValue;
        $row['utama_harga_primer_proyeksi'] = $this->utama_harga_primer_proyeksi->CurrentValue;
        $row['utama_harga_sekunder'] = $this->utama_harga_sekunder->CurrentValue;
        $row['utama_harga_sekunder_proyeksi'] = $this->utama_harga_sekunder_proyeksi->CurrentValue;
        $row['utama_harga_label'] = $this->utama_harga_label->CurrentValue;
        $row['utama_harga_label_proyeksi'] = $this->utama_harga_label_proyeksi->CurrentValue;
        $row['utama_harga_total'] = $this->utama_harga_total->CurrentValue;
        $row['utama_harga_total_proyeksi'] = $this->utama_harga_total_proyeksi->CurrentValue;
        $row['ukuran_lain'] = $this->ukuran_lain->CurrentValue;
        $row['lain_harga_isi'] = $this->lain_harga_isi->CurrentValue;
        $row['lain_harga_isi_proyeksi'] = $this->lain_harga_isi_proyeksi->CurrentValue;
        $row['lain_harga_primer'] = $this->lain_harga_primer->CurrentValue;
        $row['lain_harga_primer_proyeksi'] = $this->lain_harga_primer_proyeksi->CurrentValue;
        $row['lain_harga_sekunder'] = $this->lain_harga_sekunder->CurrentValue;
        $row['lain_harga_sekunder_proyeksi'] = $this->lain_harga_sekunder_proyeksi->CurrentValue;
        $row['lain_harga_label'] = $this->lain_harga_label->CurrentValue;
        $row['lain_harga_label_proyeksi'] = $this->lain_harga_label_proyeksi->CurrentValue;
        $row['lain_harga_total'] = $this->lain_harga_total->CurrentValue;
        $row['lain_harga_total_proyeksi'] = $this->lain_harga_total_proyeksi->CurrentValue;
        $row['delivery_pickup'] = $this->delivery_pickup->CurrentValue;
        $row['delivery_singlepoint'] = $this->delivery_singlepoint->CurrentValue;
        $row['delivery_multipoint'] = $this->delivery_multipoint->CurrentValue;
        $row['delivery_termlain'] = $this->delivery_termlain->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
        $row['receipt_by'] = $this->receipt_by->CurrentValue;
        $row['approve_by'] = $this->approve_by->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        $row['selesai'] = $this->selesai->CurrentValue;
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

        // idpegawai

        // idcustomer

        // idbrand

        // tanggal_order

        // target_selesai

        // sifatorder

        // kodeorder

        // nomororder

        // idproduct_acuan

        // kategoriproduk

        // jenisproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuransediaan

        // satuansediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aroma

        // aplikasi

        // estetika

        // tambahan

        // ukurankemasan

        // satuankemasan

        // kemasanwadah

        // kemasantutup

        // kemasancatatan

        // ukurankemasansekunder

        // satuankemasansekunder

        // kemasanbahan

        // kemasanbentuk

        // kemasankomposisi

        // kemasancatatansekunder

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

        // labeltekstur

        // labelprint

        // labeljmlwarna

        // labelcatatanhotprint

        // ukuran_utama

        // utama_harga_isi

        // utama_harga_isi_proyeksi

        // utama_harga_primer

        // utama_harga_primer_proyeksi

        // utama_harga_sekunder

        // utama_harga_sekunder_proyeksi

        // utama_harga_label

        // utama_harga_label_proyeksi

        // utama_harga_total

        // utama_harga_total_proyeksi

        // ukuran_lain

        // lain_harga_isi

        // lain_harga_isi_proyeksi

        // lain_harga_primer

        // lain_harga_primer_proyeksi

        // lain_harga_sekunder

        // lain_harga_sekunder_proyeksi

        // lain_harga_label

        // lain_harga_label_proyeksi

        // lain_harga_total

        // lain_harga_total_proyeksi

        // delivery_pickup

        // delivery_singlepoint

        // delivery_multipoint

        // delivery_termlain

        // status

        // readonly

        // receipt_by

        // approve_by

        // created_at

        // updated_at

        // selesai
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // idbrand
            $curVal = trim(strval($this->idbrand->CurrentValue));
            if ($curVal != "") {
                $this->idbrand->ViewValue = $this->idbrand->lookupCacheOption($curVal);
                if ($this->idbrand->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idbrand`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
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

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // sifatorder
            if (strval($this->sifatorder->CurrentValue) != "") {
                $this->sifatorder->ViewValue = $this->sifatorder->optionCaption($this->sifatorder->CurrentValue);
            } else {
                $this->sifatorder->ViewValue = null;
            }
            $this->sifatorder->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // nomororder
            $this->nomororder->ViewValue = $this->nomororder->CurrentValue;
            $this->nomororder->ViewCustomAttributes = "";

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

            // kategoriproduk
            $curVal = trim(strval($this->kategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->lookupCacheOption($curVal);
                if ($this->kategoriproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->kategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kategoriproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->displayValue($arwrk);
                    } else {
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
                    }
                }
            } else {
                $this->kategoriproduk->ViewValue = null;
            }
            $this->kategoriproduk->ViewCustomAttributes = "";

            // jenisproduk
            $curVal = trim(strval($this->jenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->jenisproduk->ViewValue = $this->jenisproduk->lookupCacheOption($curVal);
                if ($this->jenisproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jenisproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->jenisproduk->ViewValue = $this->jenisproduk->displayValue($arwrk);
                    } else {
                        $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
                    }
                }
            } else {
                $this->jenisproduk->ViewValue = null;
            }
            $this->jenisproduk->ViewCustomAttributes = "";

            // fungsiproduk
            $this->fungsiproduk->ViewValue = $this->fungsiproduk->CurrentValue;
            $this->fungsiproduk->ViewCustomAttributes = "";

            // kualitasproduk
            if (strval($this->kualitasproduk->CurrentValue) != "") {
                $this->kualitasproduk->ViewValue = $this->kualitasproduk->optionCaption($this->kualitasproduk->CurrentValue);
            } else {
                $this->kualitasproduk->ViewValue = null;
            }
            $this->kualitasproduk->ViewCustomAttributes = "";

            // bahan_campaign
            $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
            $this->bahan_campaign->ViewCustomAttributes = "";

            // ukuransediaan
            $this->ukuransediaan->ViewValue = $this->ukuransediaan->CurrentValue;
            $this->ukuransediaan->ViewCustomAttributes = "";

            // satuansediaan
            $curVal = trim(strval($this->satuansediaan->CurrentValue));
            if ($curVal != "") {
                $this->satuansediaan->ViewValue = $this->satuansediaan->lookupCacheOption($curVal);
                if ($this->satuansediaan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->satuansediaan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuansediaan->Lookup->renderViewRow($rswrk[0]);
                        $this->satuansediaan->ViewValue = $this->satuansediaan->displayValue($arwrk);
                    } else {
                        $this->satuansediaan->ViewValue = $this->satuansediaan->CurrentValue;
                    }
                }
            } else {
                $this->satuansediaan->ViewValue = null;
            }
            $this->satuansediaan->ViewCustomAttributes = "";

            // bentuk
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
                if ($this->bentuk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bentuk->Lookup->renderViewRow($rswrk[0]);
                        $this->bentuk->ViewValue = $this->bentuk->displayValue($arwrk);
                    } else {
                        $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
                    }
                }
            } else {
                $this->bentuk->ViewValue = null;
            }
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
                if ($this->viskositas->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->viskositas->Lookup->renderViewRow($rswrk[0]);
                        $this->viskositas->ViewValue = $this->viskositas->displayValue($arwrk);
                    } else {
                        $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
                    }
                }
            } else {
                $this->viskositas->ViewValue = null;
            }
            $this->viskositas->ViewCustomAttributes = "";

            // warna
            $curVal = trim(strval($this->warna->CurrentValue));
            if ($curVal != "") {
                $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
                if ($this->warna->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->warna->Lookup->renderViewRow($rswrk[0]);
                        $this->warna->ViewValue = $this->warna->displayValue($arwrk);
                    } else {
                        $this->warna->ViewValue = $this->warna->CurrentValue;
                    }
                }
            } else {
                $this->warna->ViewValue = null;
            }
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
                if ($this->parfum->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->parfum->Lookup->renderViewRow($rswrk[0]);
                        $this->parfum->ViewValue = $this->parfum->displayValue($arwrk);
                    } else {
                        $this->parfum->ViewValue = $this->parfum->CurrentValue;
                    }
                }
            } else {
                $this->parfum->ViewValue = null;
            }
            $this->parfum->ViewCustomAttributes = "";

            // aroma
            $this->aroma->ViewValue = $this->aroma->CurrentValue;
            $this->aroma->ViewCustomAttributes = "";

            // aplikasi
            $curVal = trim(strval($this->aplikasi->CurrentValue));
            if ($curVal != "") {
                $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
                if ($this->aplikasi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->aplikasi->Lookup->renderViewRow($rswrk[0]);
                        $this->aplikasi->ViewValue = $this->aplikasi->displayValue($arwrk);
                    } else {
                        $this->aplikasi->ViewValue = $this->aplikasi->CurrentValue;
                    }
                }
            } else {
                $this->aplikasi->ViewValue = null;
            }
            $this->aplikasi->ViewCustomAttributes = "";

            // estetika
            $curVal = trim(strval($this->estetika->CurrentValue));
            if ($curVal != "") {
                $this->estetika->ViewValue = $this->estetika->lookupCacheOption($curVal);
                if ($this->estetika->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->estetika->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->estetika->Lookup->renderViewRow($rswrk[0]);
                        $this->estetika->ViewValue = $this->estetika->displayValue($arwrk);
                    } else {
                        $this->estetika->ViewValue = $this->estetika->CurrentValue;
                    }
                }
            } else {
                $this->estetika->ViewValue = null;
            }
            $this->estetika->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // ukurankemasan
            $this->ukurankemasan->ViewValue = $this->ukurankemasan->CurrentValue;
            $this->ukurankemasan->ViewCustomAttributes = "";

            // satuankemasan
            $curVal = trim(strval($this->satuankemasan->CurrentValue));
            if ($curVal != "") {
                $this->satuankemasan->ViewValue = $this->satuankemasan->lookupCacheOption($curVal);
                if ($this->satuankemasan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->satuankemasan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuankemasan->Lookup->renderViewRow($rswrk[0]);
                        $this->satuankemasan->ViewValue = $this->satuankemasan->displayValue($arwrk);
                    } else {
                        $this->satuankemasan->ViewValue = $this->satuankemasan->CurrentValue;
                    }
                }
            } else {
                $this->satuankemasan->ViewValue = null;
            }
            $this->satuankemasan->ViewCustomAttributes = "";

            // kemasanwadah
            $curVal = trim(strval($this->kemasanwadah->CurrentValue));
            if ($curVal != "") {
                $this->kemasanwadah->ViewValue = $this->kemasanwadah->lookupCacheOption($curVal);
                if ($this->kemasanwadah->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasanwadah->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasanwadah->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasanwadah->ViewValue = $this->kemasanwadah->displayValue($arwrk);
                    } else {
                        $this->kemasanwadah->ViewValue = $this->kemasanwadah->CurrentValue;
                    }
                }
            } else {
                $this->kemasanwadah->ViewValue = null;
            }
            $this->kemasanwadah->ViewCustomAttributes = "";

            // kemasantutup
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
                if ($this->kemasantutup->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasantutup->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasantutup->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasantutup->ViewValue = $this->kemasantutup->displayValue($arwrk);
                    } else {
                        $this->kemasantutup->ViewValue = $this->kemasantutup->CurrentValue;
                    }
                }
            } else {
                $this->kemasantutup->ViewValue = null;
            }
            $this->kemasantutup->ViewCustomAttributes = "";

            // kemasancatatan
            $this->kemasancatatan->ViewValue = $this->kemasancatatan->CurrentValue;
            $this->kemasancatatan->ViewCustomAttributes = "";

            // ukurankemasansekunder
            $this->ukurankemasansekunder->ViewValue = $this->ukurankemasansekunder->CurrentValue;
            $this->ukurankemasansekunder->ViewCustomAttributes = "";

            // satuankemasansekunder
            $curVal = trim(strval($this->satuankemasansekunder->CurrentValue));
            if ($curVal != "") {
                $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->lookupCacheOption($curVal);
                if ($this->satuankemasansekunder->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->satuankemasansekunder->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuankemasansekunder->Lookup->renderViewRow($rswrk[0]);
                        $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->displayValue($arwrk);
                    } else {
                        $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->CurrentValue;
                    }
                }
            } else {
                $this->satuankemasansekunder->ViewValue = null;
            }
            $this->satuankemasansekunder->ViewCustomAttributes = "";

            // kemasanbahan
            $curVal = trim(strval($this->kemasanbahan->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbahan->ViewValue = $this->kemasanbahan->lookupCacheOption($curVal);
                if ($this->kemasanbahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasanbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasanbahan->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasanbahan->ViewValue = $this->kemasanbahan->displayValue($arwrk);
                    } else {
                        $this->kemasanbahan->ViewValue = $this->kemasanbahan->CurrentValue;
                    }
                }
            } else {
                $this->kemasanbahan->ViewValue = null;
            }
            $this->kemasanbahan->ViewCustomAttributes = "";

            // kemasanbentuk
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
                if ($this->kemasanbentuk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasanbentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasanbentuk->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->displayValue($arwrk);
                    } else {
                        $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->CurrentValue;
                    }
                }
            } else {
                $this->kemasanbentuk->ViewValue = null;
            }
            $this->kemasanbentuk->ViewCustomAttributes = "";

            // kemasankomposisi
            $curVal = trim(strval($this->kemasankomposisi->CurrentValue));
            if ($curVal != "") {
                $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->lookupCacheOption($curVal);
                if ($this->kemasankomposisi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kemasankomposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kemasankomposisi->Lookup->renderViewRow($rswrk[0]);
                        $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->displayValue($arwrk);
                    } else {
                        $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->CurrentValue;
                    }
                }
            } else {
                $this->kemasankomposisi->ViewValue = null;
            }
            $this->kemasankomposisi->ViewCustomAttributes = "";

            // kemasancatatansekunder
            $this->kemasancatatansekunder->ViewValue = $this->kemasancatatansekunder->CurrentValue;
            $this->kemasancatatansekunder->ViewCustomAttributes = "";

            // labelbahan
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
                if ($this->labelbahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelbahan->Lookup->renderViewRow($rswrk[0]);
                        $this->labelbahan->ViewValue = $this->labelbahan->displayValue($arwrk);
                    } else {
                        $this->labelbahan->ViewValue = $this->labelbahan->CurrentValue;
                    }
                }
            } else {
                $this->labelbahan->ViewValue = null;
            }
            $this->labelbahan->ViewCustomAttributes = "";

            // labelkualitas
            $curVal = trim(strval($this->labelkualitas->CurrentValue));
            if ($curVal != "") {
                $this->labelkualitas->ViewValue = $this->labelkualitas->lookupCacheOption($curVal);
                if ($this->labelkualitas->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelkualitas->Lookup->renderViewRow($rswrk[0]);
                        $this->labelkualitas->ViewValue = $this->labelkualitas->displayValue($arwrk);
                    } else {
                        $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
                    }
                }
            } else {
                $this->labelkualitas->ViewValue = null;
            }
            $this->labelkualitas->ViewCustomAttributes = "";

            // labelposisi
            $curVal = trim(strval($this->labelposisi->CurrentValue));
            if ($curVal != "") {
                $this->labelposisi->ViewValue = $this->labelposisi->lookupCacheOption($curVal);
                if ($this->labelposisi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelposisi->Lookup->renderViewRow($rswrk[0]);
                        $this->labelposisi->ViewValue = $this->labelposisi->displayValue($arwrk);
                    } else {
                        $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
                    }
                }
            } else {
                $this->labelposisi->ViewValue = null;
            }
            $this->labelposisi->ViewCustomAttributes = "";

            // labelcatatan
            $this->labelcatatan->ViewValue = $this->labelcatatan->CurrentValue;
            $this->labelcatatan->ViewCustomAttributes = "";

            // labeltekstur
            $curVal = trim(strval($this->labeltekstur->CurrentValue));
            if ($curVal != "") {
                $this->labeltekstur->ViewValue = $this->labeltekstur->lookupCacheOption($curVal);
                if ($this->labeltekstur->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labeltekstur->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labeltekstur->Lookup->renderViewRow($rswrk[0]);
                        $this->labeltekstur->ViewValue = $this->labeltekstur->displayValue($arwrk);
                    } else {
                        $this->labeltekstur->ViewValue = $this->labeltekstur->CurrentValue;
                    }
                }
            } else {
                $this->labeltekstur->ViewValue = null;
            }
            $this->labeltekstur->ViewCustomAttributes = "";

            // labelprint
            $curVal = trim(strval($this->labelprint->CurrentValue));
            if ($curVal != "") {
                $this->labelprint->ViewValue = $this->labelprint->lookupCacheOption($curVal);
                if ($this->labelprint->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelprint->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelprint->Lookup->renderViewRow($rswrk[0]);
                        $this->labelprint->ViewValue = $this->labelprint->displayValue($arwrk);
                    } else {
                        $this->labelprint->ViewValue = $this->labelprint->CurrentValue;
                    }
                }
            } else {
                $this->labelprint->ViewValue = null;
            }
            $this->labelprint->ViewCustomAttributes = "";

            // labeljmlwarna
            $this->labeljmlwarna->ViewValue = $this->labeljmlwarna->CurrentValue;
            $this->labeljmlwarna->ViewCustomAttributes = "";

            // labelcatatanhotprint
            $this->labelcatatanhotprint->ViewValue = $this->labelcatatanhotprint->CurrentValue;
            $this->labelcatatanhotprint->ViewCustomAttributes = "";

            // ukuran_utama
            $this->ukuran_utama->ViewValue = $this->ukuran_utama->CurrentValue;
            $this->ukuran_utama->ViewCustomAttributes = "";

            // utama_harga_isi
            $this->utama_harga_isi->ViewValue = $this->utama_harga_isi->CurrentValue;
            $this->utama_harga_isi->ViewValue = FormatNumber($this->utama_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi->ViewCustomAttributes = "";

            // utama_harga_isi_proyeksi
            $this->utama_harga_isi_proyeksi->ViewValue = $this->utama_harga_isi_proyeksi->CurrentValue;
            $this->utama_harga_isi_proyeksi->ViewValue = FormatNumber($this->utama_harga_isi_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi_proyeksi->ViewCustomAttributes = "";

            // utama_harga_primer
            $this->utama_harga_primer->ViewValue = $this->utama_harga_primer->CurrentValue;
            $this->utama_harga_primer->ViewValue = FormatNumber($this->utama_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer->ViewCustomAttributes = "";

            // utama_harga_primer_proyeksi
            $this->utama_harga_primer_proyeksi->ViewValue = $this->utama_harga_primer_proyeksi->CurrentValue;
            $this->utama_harga_primer_proyeksi->ViewValue = FormatNumber($this->utama_harga_primer_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer_proyeksi->ViewCustomAttributes = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->ViewValue = $this->utama_harga_sekunder->CurrentValue;
            $this->utama_harga_sekunder->ViewValue = FormatNumber($this->utama_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder->ViewCustomAttributes = "";

            // utama_harga_sekunder_proyeksi
            $this->utama_harga_sekunder_proyeksi->ViewValue = $this->utama_harga_sekunder_proyeksi->CurrentValue;
            $this->utama_harga_sekunder_proyeksi->ViewValue = FormatNumber($this->utama_harga_sekunder_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder_proyeksi->ViewCustomAttributes = "";

            // utama_harga_label
            $this->utama_harga_label->ViewValue = $this->utama_harga_label->CurrentValue;
            $this->utama_harga_label->ViewValue = FormatNumber($this->utama_harga_label->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label->ViewCustomAttributes = "";

            // utama_harga_label_proyeksi
            $this->utama_harga_label_proyeksi->ViewValue = $this->utama_harga_label_proyeksi->CurrentValue;
            $this->utama_harga_label_proyeksi->ViewValue = FormatNumber($this->utama_harga_label_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label_proyeksi->ViewCustomAttributes = "";

            // utama_harga_total
            $this->utama_harga_total->ViewValue = $this->utama_harga_total->CurrentValue;
            $this->utama_harga_total->ViewValue = FormatNumber($this->utama_harga_total->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total->ViewCustomAttributes = "";

            // utama_harga_total_proyeksi
            $this->utama_harga_total_proyeksi->ViewValue = $this->utama_harga_total_proyeksi->CurrentValue;
            $this->utama_harga_total_proyeksi->ViewValue = FormatNumber($this->utama_harga_total_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total_proyeksi->ViewCustomAttributes = "";

            // ukuran_lain
            $this->ukuran_lain->ViewValue = $this->ukuran_lain->CurrentValue;
            $this->ukuran_lain->ViewCustomAttributes = "";

            // lain_harga_isi
            $this->lain_harga_isi->ViewValue = $this->lain_harga_isi->CurrentValue;
            $this->lain_harga_isi->ViewValue = FormatNumber($this->lain_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi->ViewCustomAttributes = "";

            // lain_harga_isi_proyeksi
            $this->lain_harga_isi_proyeksi->ViewValue = $this->lain_harga_isi_proyeksi->CurrentValue;
            $this->lain_harga_isi_proyeksi->ViewValue = FormatNumber($this->lain_harga_isi_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi_proyeksi->ViewCustomAttributes = "";

            // lain_harga_primer
            $this->lain_harga_primer->ViewValue = $this->lain_harga_primer->CurrentValue;
            $this->lain_harga_primer->ViewValue = FormatNumber($this->lain_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer->ViewCustomAttributes = "";

            // lain_harga_primer_proyeksi
            $this->lain_harga_primer_proyeksi->ViewValue = $this->lain_harga_primer_proyeksi->CurrentValue;
            $this->lain_harga_primer_proyeksi->ViewValue = FormatNumber($this->lain_harga_primer_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer_proyeksi->ViewCustomAttributes = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->ViewValue = $this->lain_harga_sekunder->CurrentValue;
            $this->lain_harga_sekunder->ViewValue = FormatNumber($this->lain_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder->ViewCustomAttributes = "";

            // lain_harga_sekunder_proyeksi
            $this->lain_harga_sekunder_proyeksi->ViewValue = $this->lain_harga_sekunder_proyeksi->CurrentValue;
            $this->lain_harga_sekunder_proyeksi->ViewValue = FormatNumber($this->lain_harga_sekunder_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder_proyeksi->ViewCustomAttributes = "";

            // lain_harga_label
            $this->lain_harga_label->ViewValue = $this->lain_harga_label->CurrentValue;
            $this->lain_harga_label->ViewValue = FormatNumber($this->lain_harga_label->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label->ViewCustomAttributes = "";

            // lain_harga_label_proyeksi
            $this->lain_harga_label_proyeksi->ViewValue = $this->lain_harga_label_proyeksi->CurrentValue;
            $this->lain_harga_label_proyeksi->ViewValue = FormatNumber($this->lain_harga_label_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label_proyeksi->ViewCustomAttributes = "";

            // lain_harga_total
            $this->lain_harga_total->ViewValue = $this->lain_harga_total->CurrentValue;
            $this->lain_harga_total->ViewValue = FormatNumber($this->lain_harga_total->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total->ViewCustomAttributes = "";

            // lain_harga_total_proyeksi
            $this->lain_harga_total_proyeksi->ViewValue = $this->lain_harga_total_proyeksi->CurrentValue;
            $this->lain_harga_total_proyeksi->ViewValue = FormatNumber($this->lain_harga_total_proyeksi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total_proyeksi->ViewCustomAttributes = "";

            // delivery_pickup
            $this->delivery_pickup->ViewValue = $this->delivery_pickup->CurrentValue;
            $this->delivery_pickup->ViewCustomAttributes = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->ViewValue = $this->delivery_singlepoint->CurrentValue;
            $this->delivery_singlepoint->ViewCustomAttributes = "";

            // delivery_multipoint
            $this->delivery_multipoint->ViewValue = $this->delivery_multipoint->CurrentValue;
            $this->delivery_multipoint->ViewCustomAttributes = "";

            // delivery_termlain
            $this->delivery_termlain->ViewValue = $this->delivery_termlain->CurrentValue;
            $this->delivery_termlain->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // readonly
            if (strval($this->readonly->CurrentValue) != "") {
                $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
            } else {
                $this->readonly->ViewValue = null;
            }
            $this->readonly->ViewCustomAttributes = "";

            // receipt_by
            $this->receipt_by->ViewValue = $this->receipt_by->CurrentValue;
            $this->receipt_by->ViewValue = FormatNumber($this->receipt_by->ViewValue, 0, -2, -2, -2);
            $this->receipt_by->ViewCustomAttributes = "";

            // approve_by
            $curVal = trim(strval($this->approve_by->CurrentValue));
            if ($curVal != "") {
                $this->approve_by->ViewValue = $this->approve_by->lookupCacheOption($curVal);
                if ($this->approve_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->approve_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->approve_by->Lookup->renderViewRow($rswrk[0]);
                        $this->approve_by->ViewValue = $this->approve_by->displayValue($arwrk);
                    } else {
                        $this->approve_by->ViewValue = $this->approve_by->CurrentValue;
                    }
                }
            } else {
                $this->approve_by->ViewValue = null;
            }
            $this->approve_by->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 11);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 17);
            $this->updated_at->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";
            $this->idbrand->TooltipValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";
            $this->target_selesai->TooltipValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";
            $this->sifatorder->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";
            $this->nomororder->TooltipValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";
            $this->idproduct_acuan->TooltipValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";
            $this->kategoriproduk->TooltipValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";
            $this->jenisproduk->TooltipValue = "";

            // fungsiproduk
            $this->fungsiproduk->LinkCustomAttributes = "";
            $this->fungsiproduk->HrefValue = "";
            $this->fungsiproduk->TooltipValue = "";

            // kualitasproduk
            $this->kualitasproduk->LinkCustomAttributes = "";
            $this->kualitasproduk->HrefValue = "";
            $this->kualitasproduk->TooltipValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";
            $this->bahan_campaign->TooltipValue = "";

            // ukuransediaan
            $this->ukuransediaan->LinkCustomAttributes = "";
            $this->ukuransediaan->HrefValue = "";
            $this->ukuransediaan->TooltipValue = "";

            // satuansediaan
            $this->satuansediaan->LinkCustomAttributes = "";
            $this->satuansediaan->HrefValue = "";
            $this->satuansediaan->TooltipValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";
            $this->bentuk->TooltipValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";
            $this->viskositas->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // aroma
            $this->aroma->LinkCustomAttributes = "";
            $this->aroma->HrefValue = "";
            $this->aroma->TooltipValue = "";

            // aplikasi
            $this->aplikasi->LinkCustomAttributes = "";
            $this->aplikasi->HrefValue = "";
            $this->aplikasi->TooltipValue = "";

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";
            $this->estetika->TooltipValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";
            $this->tambahan->TooltipValue = "";

            // ukurankemasan
            $this->ukurankemasan->LinkCustomAttributes = "";
            $this->ukurankemasan->HrefValue = "";
            $this->ukurankemasan->TooltipValue = "";

            // satuankemasan
            $this->satuankemasan->LinkCustomAttributes = "";
            $this->satuankemasan->HrefValue = "";
            $this->satuankemasan->TooltipValue = "";

            // kemasanwadah
            $this->kemasanwadah->LinkCustomAttributes = "";
            $this->kemasanwadah->HrefValue = "";
            $this->kemasanwadah->TooltipValue = "";

            // kemasantutup
            $this->kemasantutup->LinkCustomAttributes = "";
            $this->kemasantutup->HrefValue = "";
            $this->kemasantutup->TooltipValue = "";

            // kemasancatatan
            $this->kemasancatatan->LinkCustomAttributes = "";
            $this->kemasancatatan->HrefValue = "";
            $this->kemasancatatan->TooltipValue = "";

            // ukurankemasansekunder
            $this->ukurankemasansekunder->LinkCustomAttributes = "";
            $this->ukurankemasansekunder->HrefValue = "";
            $this->ukurankemasansekunder->TooltipValue = "";

            // satuankemasansekunder
            $this->satuankemasansekunder->LinkCustomAttributes = "";
            $this->satuankemasansekunder->HrefValue = "";
            $this->satuankemasansekunder->TooltipValue = "";

            // kemasanbahan
            $this->kemasanbahan->LinkCustomAttributes = "";
            $this->kemasanbahan->HrefValue = "";
            $this->kemasanbahan->TooltipValue = "";

            // kemasanbentuk
            $this->kemasanbentuk->LinkCustomAttributes = "";
            $this->kemasanbentuk->HrefValue = "";
            $this->kemasanbentuk->TooltipValue = "";

            // kemasankomposisi
            $this->kemasankomposisi->LinkCustomAttributes = "";
            $this->kemasankomposisi->HrefValue = "";
            $this->kemasankomposisi->TooltipValue = "";

            // kemasancatatansekunder
            $this->kemasancatatansekunder->LinkCustomAttributes = "";
            $this->kemasancatatansekunder->HrefValue = "";
            $this->kemasancatatansekunder->TooltipValue = "";

            // labelbahan
            $this->labelbahan->LinkCustomAttributes = "";
            $this->labelbahan->HrefValue = "";
            $this->labelbahan->TooltipValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";
            $this->labelkualitas->TooltipValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";
            $this->labelposisi->TooltipValue = "";

            // labelcatatan
            $this->labelcatatan->LinkCustomAttributes = "";
            $this->labelcatatan->HrefValue = "";
            $this->labelcatatan->TooltipValue = "";

            // labeltekstur
            $this->labeltekstur->LinkCustomAttributes = "";
            $this->labeltekstur->HrefValue = "";
            $this->labeltekstur->TooltipValue = "";

            // labelprint
            $this->labelprint->LinkCustomAttributes = "";
            $this->labelprint->HrefValue = "";
            $this->labelprint->TooltipValue = "";

            // labeljmlwarna
            $this->labeljmlwarna->LinkCustomAttributes = "";
            $this->labeljmlwarna->HrefValue = "";
            $this->labeljmlwarna->TooltipValue = "";

            // labelcatatanhotprint
            $this->labelcatatanhotprint->LinkCustomAttributes = "";
            $this->labelcatatanhotprint->HrefValue = "";
            $this->labelcatatanhotprint->TooltipValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";
            $this->ukuran_utama->TooltipValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";
            $this->utama_harga_isi->TooltipValue = "";

            // utama_harga_isi_proyeksi
            $this->utama_harga_isi_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_isi_proyeksi->HrefValue = "";
            $this->utama_harga_isi_proyeksi->TooltipValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";
            $this->utama_harga_primer->TooltipValue = "";

            // utama_harga_primer_proyeksi
            $this->utama_harga_primer_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_primer_proyeksi->HrefValue = "";
            $this->utama_harga_primer_proyeksi->TooltipValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";
            $this->utama_harga_sekunder->TooltipValue = "";

            // utama_harga_sekunder_proyeksi
            $this->utama_harga_sekunder_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_proyeksi->HrefValue = "";
            $this->utama_harga_sekunder_proyeksi->TooltipValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";
            $this->utama_harga_label->TooltipValue = "";

            // utama_harga_label_proyeksi
            $this->utama_harga_label_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_label_proyeksi->HrefValue = "";
            $this->utama_harga_label_proyeksi->TooltipValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";
            $this->utama_harga_total->TooltipValue = "";

            // utama_harga_total_proyeksi
            $this->utama_harga_total_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_total_proyeksi->HrefValue = "";
            $this->utama_harga_total_proyeksi->TooltipValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";
            $this->ukuran_lain->TooltipValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";
            $this->lain_harga_isi->TooltipValue = "";

            // lain_harga_isi_proyeksi
            $this->lain_harga_isi_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_isi_proyeksi->HrefValue = "";
            $this->lain_harga_isi_proyeksi->TooltipValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";
            $this->lain_harga_primer->TooltipValue = "";

            // lain_harga_primer_proyeksi
            $this->lain_harga_primer_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_primer_proyeksi->HrefValue = "";
            $this->lain_harga_primer_proyeksi->TooltipValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";
            $this->lain_harga_sekunder->TooltipValue = "";

            // lain_harga_sekunder_proyeksi
            $this->lain_harga_sekunder_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_proyeksi->HrefValue = "";
            $this->lain_harga_sekunder_proyeksi->TooltipValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";
            $this->lain_harga_label->TooltipValue = "";

            // lain_harga_label_proyeksi
            $this->lain_harga_label_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_label_proyeksi->HrefValue = "";
            $this->lain_harga_label_proyeksi->TooltipValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";
            $this->lain_harga_total->TooltipValue = "";

            // lain_harga_total_proyeksi
            $this->lain_harga_total_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_total_proyeksi->HrefValue = "";
            $this->lain_harga_total_proyeksi->TooltipValue = "";

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

            // delivery_termlain
            $this->delivery_termlain->LinkCustomAttributes = "";
            $this->delivery_termlain->HrefValue = "";
            $this->delivery_termlain->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // receipt_by
            $this->receipt_by->LinkCustomAttributes = "";
            $this->receipt_by->HrefValue = "";
            $this->receipt_by->TooltipValue = "";

            // approve_by
            $this->approve_by->LinkCustomAttributes = "";
            $this->approve_by->HrefValue = "";
            $this->approve_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
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
                    $filterWrk = "`idbrand`" . SearchString("=", $this->idbrand->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idbrand->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idbrand->EditValue = $arwrk;
            }
            $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());

            // tanggal_order
            $this->tanggal_order->EditAttrs["class"] = "form-control";
            $this->tanggal_order->EditCustomAttributes = "";
            $this->tanggal_order->EditValue = HtmlEncode(FormatDateTime($this->tanggal_order->CurrentValue, 8));
            $this->tanggal_order->PlaceHolder = RemoveHtml($this->tanggal_order->caption());

            // target_selesai
            $this->target_selesai->EditAttrs["class"] = "form-control";
            $this->target_selesai->EditCustomAttributes = "";
            $this->target_selesai->EditValue = HtmlEncode(FormatDateTime($this->target_selesai->CurrentValue, 8));
            $this->target_selesai->PlaceHolder = RemoveHtml($this->target_selesai->caption());

            // sifatorder
            $this->sifatorder->EditCustomAttributes = "";
            $this->sifatorder->EditValue = $this->sifatorder->options(false);
            $this->sifatorder->PlaceHolder = RemoveHtml($this->sifatorder->caption());

            // kodeorder
            $this->kodeorder->EditAttrs["class"] = "form-control";
            $this->kodeorder->EditCustomAttributes = "";
            if (!$this->kodeorder->Raw) {
                $this->kodeorder->CurrentValue = HtmlDecode($this->kodeorder->CurrentValue);
            }
            $this->kodeorder->EditValue = HtmlEncode($this->kodeorder->CurrentValue);
            $this->kodeorder->PlaceHolder = RemoveHtml($this->kodeorder->caption());

            // nomororder
            $this->nomororder->EditAttrs["class"] = "form-control";
            $this->nomororder->EditCustomAttributes = "";
            if (!$this->nomororder->Raw) {
                $this->nomororder->CurrentValue = HtmlDecode($this->nomororder->CurrentValue);
            }
            $this->nomororder->EditValue = HtmlEncode($this->nomororder->CurrentValue);
            $this->nomororder->PlaceHolder = RemoveHtml($this->nomororder->caption());

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

            // kategoriproduk
            $this->kategoriproduk->EditAttrs["class"] = "form-control";
            $this->kategoriproduk->EditCustomAttributes = "";
            $curVal = trim(strval($this->kategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->lookupCacheOption($curVal);
            } else {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->Lookup !== null && is_array($this->kategoriproduk->Lookup->Options) ? $curVal : null;
            }
            if ($this->kategoriproduk->ViewValue !== null) { // Load from cache
                $this->kategoriproduk->EditValue = array_values($this->kategoriproduk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->kategoriproduk->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->kategoriproduk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kategoriproduk->EditValue = $arwrk;
            }
            $this->kategoriproduk->PlaceHolder = RemoveHtml($this->kategoriproduk->caption());

            // jenisproduk
            $this->jenisproduk->EditAttrs["class"] = "form-control";
            $this->jenisproduk->EditCustomAttributes = "";
            $curVal = trim(strval($this->jenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->jenisproduk->ViewValue = $this->jenisproduk->lookupCacheOption($curVal);
            } else {
                $this->jenisproduk->ViewValue = $this->jenisproduk->Lookup !== null && is_array($this->jenisproduk->Lookup->Options) ? $curVal : null;
            }
            if ($this->jenisproduk->ViewValue !== null) { // Load from cache
                $this->jenisproduk->EditValue = array_values($this->jenisproduk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->jenisproduk->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->jenisproduk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->jenisproduk->EditValue = $arwrk;
            }
            $this->jenisproduk->PlaceHolder = RemoveHtml($this->jenisproduk->caption());

            // fungsiproduk
            $this->fungsiproduk->EditAttrs["class"] = "form-control";
            $this->fungsiproduk->EditCustomAttributes = "";
            if (!$this->fungsiproduk->Raw) {
                $this->fungsiproduk->CurrentValue = HtmlDecode($this->fungsiproduk->CurrentValue);
            }
            $this->fungsiproduk->EditValue = HtmlEncode($this->fungsiproduk->CurrentValue);
            $this->fungsiproduk->PlaceHolder = RemoveHtml($this->fungsiproduk->caption());

            // kualitasproduk
            $this->kualitasproduk->EditCustomAttributes = "";
            $this->kualitasproduk->EditValue = $this->kualitasproduk->options(false);
            $this->kualitasproduk->PlaceHolder = RemoveHtml($this->kualitasproduk->caption());

            // bahan_campaign
            $this->bahan_campaign->EditAttrs["class"] = "form-control";
            $this->bahan_campaign->EditCustomAttributes = "";
            $this->bahan_campaign->EditValue = HtmlEncode($this->bahan_campaign->CurrentValue);
            $this->bahan_campaign->PlaceHolder = RemoveHtml($this->bahan_campaign->caption());

            // ukuransediaan
            $this->ukuransediaan->EditAttrs["class"] = "form-control";
            $this->ukuransediaan->EditCustomAttributes = "";
            if (!$this->ukuransediaan->Raw) {
                $this->ukuransediaan->CurrentValue = HtmlDecode($this->ukuransediaan->CurrentValue);
            }
            $this->ukuransediaan->EditValue = HtmlEncode($this->ukuransediaan->CurrentValue);
            $this->ukuransediaan->PlaceHolder = RemoveHtml($this->ukuransediaan->caption());

            // satuansediaan
            $this->satuansediaan->EditAttrs["class"] = "form-control";
            $this->satuansediaan->EditCustomAttributes = "";
            $curVal = trim(strval($this->satuansediaan->CurrentValue));
            if ($curVal != "") {
                $this->satuansediaan->ViewValue = $this->satuansediaan->lookupCacheOption($curVal);
            } else {
                $this->satuansediaan->ViewValue = $this->satuansediaan->Lookup !== null && is_array($this->satuansediaan->Lookup->Options) ? $curVal : null;
            }
            if ($this->satuansediaan->ViewValue !== null) { // Load from cache
                $this->satuansediaan->EditValue = array_values($this->satuansediaan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`nama`" . SearchString("=", $this->satuansediaan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->satuansediaan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->satuansediaan->EditValue = $arwrk;
            }
            $this->satuansediaan->PlaceHolder = RemoveHtml($this->satuansediaan->caption());

            // bentuk
            $this->bentuk->EditCustomAttributes = "";
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
            } else {
                $this->bentuk->ViewValue = $this->bentuk->Lookup !== null && is_array($this->bentuk->Lookup->Options) ? $curVal : null;
            }
            if ($this->bentuk->ViewValue !== null) { // Load from cache
                $this->bentuk->EditValue = array_values($this->bentuk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->bentuk->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->bentuk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->bentuk->EditValue = $arwrk;
            }
            $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

            // viskositas
            $this->viskositas->EditCustomAttributes = "";
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
            } else {
                $this->viskositas->ViewValue = $this->viskositas->Lookup !== null && is_array($this->viskositas->Lookup->Options) ? $curVal : null;
            }
            if ($this->viskositas->ViewValue !== null) { // Load from cache
                $this->viskositas->EditValue = array_values($this->viskositas->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->viskositas->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->viskositas->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->viskositas->EditValue = $arwrk;
            }
            $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

            // warna
            $this->warna->EditCustomAttributes = "";
            $curVal = trim(strval($this->warna->CurrentValue));
            if ($curVal != "") {
                $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
            } else {
                $this->warna->ViewValue = $this->warna->Lookup !== null && is_array($this->warna->Lookup->Options) ? $curVal : null;
            }
            if ($this->warna->ViewValue !== null) { // Load from cache
                $this->warna->EditValue = array_values($this->warna->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->warna->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->warna->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->warna->EditValue = $arwrk;
            }
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // parfum
            $this->parfum->EditAttrs["class"] = "form-control";
            $this->parfum->EditCustomAttributes = "";
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
            } else {
                $this->parfum->ViewValue = $this->parfum->Lookup !== null && is_array($this->parfum->Lookup->Options) ? $curVal : null;
            }
            if ($this->parfum->ViewValue !== null) { // Load from cache
                $this->parfum->EditValue = array_values($this->parfum->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->parfum->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->parfum->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->parfum->EditValue = $arwrk;
            }
            $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

            // aroma
            $this->aroma->EditAttrs["class"] = "form-control";
            $this->aroma->EditCustomAttributes = "";
            if (!$this->aroma->Raw) {
                $this->aroma->CurrentValue = HtmlDecode($this->aroma->CurrentValue);
            }
            $this->aroma->EditValue = HtmlEncode($this->aroma->CurrentValue);
            $this->aroma->PlaceHolder = RemoveHtml($this->aroma->caption());

            // aplikasi
            $this->aplikasi->EditCustomAttributes = "";
            $curVal = trim(strval($this->aplikasi->CurrentValue));
            if ($curVal != "") {
                $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
            } else {
                $this->aplikasi->ViewValue = $this->aplikasi->Lookup !== null && is_array($this->aplikasi->Lookup->Options) ? $curVal : null;
            }
            if ($this->aplikasi->ViewValue !== null) { // Load from cache
                $this->aplikasi->EditValue = array_values($this->aplikasi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->aplikasi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->aplikasi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->aplikasi->EditValue = $arwrk;
            }
            $this->aplikasi->PlaceHolder = RemoveHtml($this->aplikasi->caption());

            // estetika
            $this->estetika->EditCustomAttributes = "";
            $curVal = trim(strval($this->estetika->CurrentValue));
            if ($curVal != "") {
                $this->estetika->ViewValue = $this->estetika->lookupCacheOption($curVal);
            } else {
                $this->estetika->ViewValue = $this->estetika->Lookup !== null && is_array($this->estetika->Lookup->Options) ? $curVal : null;
            }
            if ($this->estetika->ViewValue !== null) { // Load from cache
                $this->estetika->EditValue = array_values($this->estetika->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->estetika->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->estetika->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->estetika->EditValue = $arwrk;
            }
            $this->estetika->PlaceHolder = RemoveHtml($this->estetika->caption());

            // tambahan
            $this->tambahan->EditAttrs["class"] = "form-control";
            $this->tambahan->EditCustomAttributes = "";
            $this->tambahan->EditValue = HtmlEncode($this->tambahan->CurrentValue);
            $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

            // ukurankemasan
            $this->ukurankemasan->EditAttrs["class"] = "form-control";
            $this->ukurankemasan->EditCustomAttributes = "";
            if (!$this->ukurankemasan->Raw) {
                $this->ukurankemasan->CurrentValue = HtmlDecode($this->ukurankemasan->CurrentValue);
            }
            $this->ukurankemasan->EditValue = HtmlEncode($this->ukurankemasan->CurrentValue);
            $this->ukurankemasan->PlaceHolder = RemoveHtml($this->ukurankemasan->caption());

            // satuankemasan
            $this->satuankemasan->EditAttrs["class"] = "form-control";
            $this->satuankemasan->EditCustomAttributes = "";
            $curVal = trim(strval($this->satuankemasan->CurrentValue));
            if ($curVal != "") {
                $this->satuankemasan->ViewValue = $this->satuankemasan->lookupCacheOption($curVal);
            } else {
                $this->satuankemasan->ViewValue = $this->satuankemasan->Lookup !== null && is_array($this->satuankemasan->Lookup->Options) ? $curVal : null;
            }
            if ($this->satuankemasan->ViewValue !== null) { // Load from cache
                $this->satuankemasan->EditValue = array_values($this->satuankemasan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`nama`" . SearchString("=", $this->satuankemasan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->satuankemasan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->satuankemasan->EditValue = $arwrk;
            }
            $this->satuankemasan->PlaceHolder = RemoveHtml($this->satuankemasan->caption());

            // kemasanwadah
            $this->kemasanwadah->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasanwadah->CurrentValue));
            if ($curVal != "") {
                $this->kemasanwadah->ViewValue = $this->kemasanwadah->lookupCacheOption($curVal);
            } else {
                $this->kemasanwadah->ViewValue = $this->kemasanwadah->Lookup !== null && is_array($this->kemasanwadah->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasanwadah->ViewValue !== null) { // Load from cache
                $this->kemasanwadah->EditValue = array_values($this->kemasanwadah->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->kemasanwadah->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kemasanwadah->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasanwadah->EditValue = $arwrk;
            }
            $this->kemasanwadah->PlaceHolder = RemoveHtml($this->kemasanwadah->caption());

            // kemasantutup
            $this->kemasantutup->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
            } else {
                $this->kemasantutup->ViewValue = $this->kemasantutup->Lookup !== null && is_array($this->kemasantutup->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasantutup->ViewValue !== null) { // Load from cache
                $this->kemasantutup->EditValue = array_values($this->kemasantutup->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->kemasantutup->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kemasantutup->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasantutup->EditValue = $arwrk;
            }
            $this->kemasantutup->PlaceHolder = RemoveHtml($this->kemasantutup->caption());

            // kemasancatatan
            $this->kemasancatatan->EditAttrs["class"] = "form-control";
            $this->kemasancatatan->EditCustomAttributes = "";
            $this->kemasancatatan->EditValue = HtmlEncode($this->kemasancatatan->CurrentValue);
            $this->kemasancatatan->PlaceHolder = RemoveHtml($this->kemasancatatan->caption());

            // ukurankemasansekunder
            $this->ukurankemasansekunder->EditAttrs["class"] = "form-control";
            $this->ukurankemasansekunder->EditCustomAttributes = "";
            if (!$this->ukurankemasansekunder->Raw) {
                $this->ukurankemasansekunder->CurrentValue = HtmlDecode($this->ukurankemasansekunder->CurrentValue);
            }
            $this->ukurankemasansekunder->EditValue = HtmlEncode($this->ukurankemasansekunder->CurrentValue);
            $this->ukurankemasansekunder->PlaceHolder = RemoveHtml($this->ukurankemasansekunder->caption());

            // satuankemasansekunder
            $this->satuankemasansekunder->EditAttrs["class"] = "form-control";
            $this->satuankemasansekunder->EditCustomAttributes = "";
            $curVal = trim(strval($this->satuankemasansekunder->CurrentValue));
            if ($curVal != "") {
                $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->lookupCacheOption($curVal);
            } else {
                $this->satuankemasansekunder->ViewValue = $this->satuankemasansekunder->Lookup !== null && is_array($this->satuankemasansekunder->Lookup->Options) ? $curVal : null;
            }
            if ($this->satuankemasansekunder->ViewValue !== null) { // Load from cache
                $this->satuankemasansekunder->EditValue = array_values($this->satuankemasansekunder->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`nama`" . SearchString("=", $this->satuankemasansekunder->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->satuankemasansekunder->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->satuankemasansekunder->EditValue = $arwrk;
            }
            $this->satuankemasansekunder->PlaceHolder = RemoveHtml($this->satuankemasansekunder->caption());

            // kemasanbahan
            $this->kemasanbahan->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasanbahan->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbahan->ViewValue = $this->kemasanbahan->lookupCacheOption($curVal);
            } else {
                $this->kemasanbahan->ViewValue = $this->kemasanbahan->Lookup !== null && is_array($this->kemasanbahan->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasanbahan->ViewValue !== null) { // Load from cache
                $this->kemasanbahan->EditValue = array_values($this->kemasanbahan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->kemasanbahan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kemasanbahan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasanbahan->EditValue = $arwrk;
            }
            $this->kemasanbahan->PlaceHolder = RemoveHtml($this->kemasanbahan->caption());

            // kemasanbentuk
            $this->kemasanbentuk->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
            } else {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->Lookup !== null && is_array($this->kemasanbentuk->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasanbentuk->ViewValue !== null) { // Load from cache
                $this->kemasanbentuk->EditValue = array_values($this->kemasanbentuk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->kemasanbentuk->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kemasanbentuk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasanbentuk->EditValue = $arwrk;
            }
            $this->kemasanbentuk->PlaceHolder = RemoveHtml($this->kemasanbentuk->caption());

            // kemasankomposisi
            $this->kemasankomposisi->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasankomposisi->CurrentValue));
            if ($curVal != "") {
                $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->lookupCacheOption($curVal);
            } else {
                $this->kemasankomposisi->ViewValue = $this->kemasankomposisi->Lookup !== null && is_array($this->kemasankomposisi->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasankomposisi->ViewValue !== null) { // Load from cache
                $this->kemasankomposisi->EditValue = array_values($this->kemasankomposisi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->kemasankomposisi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kemasankomposisi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasankomposisi->EditValue = $arwrk;
            }
            $this->kemasankomposisi->PlaceHolder = RemoveHtml($this->kemasankomposisi->caption());

            // kemasancatatansekunder
            $this->kemasancatatansekunder->EditAttrs["class"] = "form-control";
            $this->kemasancatatansekunder->EditCustomAttributes = "";
            $this->kemasancatatansekunder->EditValue = HtmlEncode($this->kemasancatatansekunder->CurrentValue);
            $this->kemasancatatansekunder->PlaceHolder = RemoveHtml($this->kemasancatatansekunder->caption());

            // labelbahan
            $this->labelbahan->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
            } else {
                $this->labelbahan->ViewValue = $this->labelbahan->Lookup !== null && is_array($this->labelbahan->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelbahan->ViewValue !== null) { // Load from cache
                $this->labelbahan->EditValue = array_values($this->labelbahan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->labelbahan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelbahan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelbahan->EditValue = $arwrk;
            }
            $this->labelbahan->PlaceHolder = RemoveHtml($this->labelbahan->caption());

            // labelkualitas
            $this->labelkualitas->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelkualitas->CurrentValue));
            if ($curVal != "") {
                $this->labelkualitas->ViewValue = $this->labelkualitas->lookupCacheOption($curVal);
            } else {
                $this->labelkualitas->ViewValue = $this->labelkualitas->Lookup !== null && is_array($this->labelkualitas->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelkualitas->ViewValue !== null) { // Load from cache
                $this->labelkualitas->EditValue = array_values($this->labelkualitas->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->labelkualitas->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelkualitas->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelkualitas->EditValue = $arwrk;
            }
            $this->labelkualitas->PlaceHolder = RemoveHtml($this->labelkualitas->caption());

            // labelposisi
            $this->labelposisi->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelposisi->CurrentValue));
            if ($curVal != "") {
                $this->labelposisi->ViewValue = $this->labelposisi->lookupCacheOption($curVal);
            } else {
                $this->labelposisi->ViewValue = $this->labelposisi->Lookup !== null && is_array($this->labelposisi->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelposisi->ViewValue !== null) { // Load from cache
                $this->labelposisi->EditValue = array_values($this->labelposisi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->labelposisi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelposisi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelposisi->EditValue = $arwrk;
            }
            $this->labelposisi->PlaceHolder = RemoveHtml($this->labelposisi->caption());

            // labelcatatan
            $this->labelcatatan->EditAttrs["class"] = "form-control";
            $this->labelcatatan->EditCustomAttributes = "";
            $this->labelcatatan->EditValue = HtmlEncode($this->labelcatatan->CurrentValue);
            $this->labelcatatan->PlaceHolder = RemoveHtml($this->labelcatatan->caption());

            // labeltekstur
            $this->labeltekstur->EditCustomAttributes = "";
            $curVal = trim(strval($this->labeltekstur->CurrentValue));
            if ($curVal != "") {
                $this->labeltekstur->ViewValue = $this->labeltekstur->lookupCacheOption($curVal);
            } else {
                $this->labeltekstur->ViewValue = $this->labeltekstur->Lookup !== null && is_array($this->labeltekstur->Lookup->Options) ? $curVal : null;
            }
            if ($this->labeltekstur->ViewValue !== null) { // Load from cache
                $this->labeltekstur->EditValue = array_values($this->labeltekstur->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->labeltekstur->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labeltekstur->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labeltekstur->EditValue = $arwrk;
            }
            $this->labeltekstur->PlaceHolder = RemoveHtml($this->labeltekstur->caption());

            // labelprint
            $this->labelprint->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelprint->CurrentValue));
            if ($curVal != "") {
                $this->labelprint->ViewValue = $this->labelprint->lookupCacheOption($curVal);
            } else {
                $this->labelprint->ViewValue = $this->labelprint->Lookup !== null && is_array($this->labelprint->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelprint->ViewValue !== null) { // Load from cache
                $this->labelprint->EditValue = array_values($this->labelprint->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->labelprint->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelprint->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelprint->EditValue = $arwrk;
            }
            $this->labelprint->PlaceHolder = RemoveHtml($this->labelprint->caption());

            // labeljmlwarna
            $this->labeljmlwarna->EditAttrs["class"] = "form-control";
            $this->labeljmlwarna->EditCustomAttributes = "";
            $this->labeljmlwarna->EditValue = HtmlEncode($this->labeljmlwarna->CurrentValue);
            $this->labeljmlwarna->PlaceHolder = RemoveHtml($this->labeljmlwarna->caption());

            // labelcatatanhotprint
            $this->labelcatatanhotprint->EditAttrs["class"] = "form-control";
            $this->labelcatatanhotprint->EditCustomAttributes = "";
            $this->labelcatatanhotprint->EditValue = HtmlEncode($this->labelcatatanhotprint->CurrentValue);
            $this->labelcatatanhotprint->PlaceHolder = RemoveHtml($this->labelcatatanhotprint->caption());

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

            // utama_harga_isi_proyeksi
            $this->utama_harga_isi_proyeksi->EditAttrs["class"] = "form-control";
            $this->utama_harga_isi_proyeksi->EditCustomAttributes = "";
            $this->utama_harga_isi_proyeksi->EditValue = HtmlEncode($this->utama_harga_isi_proyeksi->CurrentValue);
            $this->utama_harga_isi_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_isi_proyeksi->caption());

            // utama_harga_primer
            $this->utama_harga_primer->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer->EditCustomAttributes = "";
            $this->utama_harga_primer->EditValue = HtmlEncode($this->utama_harga_primer->CurrentValue);
            $this->utama_harga_primer->PlaceHolder = RemoveHtml($this->utama_harga_primer->caption());

            // utama_harga_primer_proyeksi
            $this->utama_harga_primer_proyeksi->EditAttrs["class"] = "form-control";
            $this->utama_harga_primer_proyeksi->EditCustomAttributes = "";
            $this->utama_harga_primer_proyeksi->EditValue = HtmlEncode($this->utama_harga_primer_proyeksi->CurrentValue);
            $this->utama_harga_primer_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_primer_proyeksi->caption());

            // utama_harga_sekunder
            $this->utama_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder->EditCustomAttributes = "";
            $this->utama_harga_sekunder->EditValue = HtmlEncode($this->utama_harga_sekunder->CurrentValue);
            $this->utama_harga_sekunder->PlaceHolder = RemoveHtml($this->utama_harga_sekunder->caption());

            // utama_harga_sekunder_proyeksi
            $this->utama_harga_sekunder_proyeksi->EditAttrs["class"] = "form-control";
            $this->utama_harga_sekunder_proyeksi->EditCustomAttributes = "";
            $this->utama_harga_sekunder_proyeksi->EditValue = HtmlEncode($this->utama_harga_sekunder_proyeksi->CurrentValue);
            $this->utama_harga_sekunder_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_sekunder_proyeksi->caption());

            // utama_harga_label
            $this->utama_harga_label->EditAttrs["class"] = "form-control";
            $this->utama_harga_label->EditCustomAttributes = "";
            $this->utama_harga_label->EditValue = HtmlEncode($this->utama_harga_label->CurrentValue);
            $this->utama_harga_label->PlaceHolder = RemoveHtml($this->utama_harga_label->caption());

            // utama_harga_label_proyeksi
            $this->utama_harga_label_proyeksi->EditAttrs["class"] = "form-control";
            $this->utama_harga_label_proyeksi->EditCustomAttributes = "";
            $this->utama_harga_label_proyeksi->EditValue = HtmlEncode($this->utama_harga_label_proyeksi->CurrentValue);
            $this->utama_harga_label_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_label_proyeksi->caption());

            // utama_harga_total
            $this->utama_harga_total->EditAttrs["class"] = "form-control";
            $this->utama_harga_total->EditCustomAttributes = "";
            $this->utama_harga_total->EditValue = HtmlEncode($this->utama_harga_total->CurrentValue);
            $this->utama_harga_total->PlaceHolder = RemoveHtml($this->utama_harga_total->caption());

            // utama_harga_total_proyeksi
            $this->utama_harga_total_proyeksi->EditAttrs["class"] = "form-control";
            $this->utama_harga_total_proyeksi->EditCustomAttributes = "";
            $this->utama_harga_total_proyeksi->EditValue = HtmlEncode($this->utama_harga_total_proyeksi->CurrentValue);
            $this->utama_harga_total_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_total_proyeksi->caption());

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

            // lain_harga_isi_proyeksi
            $this->lain_harga_isi_proyeksi->EditAttrs["class"] = "form-control";
            $this->lain_harga_isi_proyeksi->EditCustomAttributes = "";
            $this->lain_harga_isi_proyeksi->EditValue = HtmlEncode($this->lain_harga_isi_proyeksi->CurrentValue);
            $this->lain_harga_isi_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_isi_proyeksi->caption());

            // lain_harga_primer
            $this->lain_harga_primer->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer->EditCustomAttributes = "";
            $this->lain_harga_primer->EditValue = HtmlEncode($this->lain_harga_primer->CurrentValue);
            $this->lain_harga_primer->PlaceHolder = RemoveHtml($this->lain_harga_primer->caption());

            // lain_harga_primer_proyeksi
            $this->lain_harga_primer_proyeksi->EditAttrs["class"] = "form-control";
            $this->lain_harga_primer_proyeksi->EditCustomAttributes = "";
            $this->lain_harga_primer_proyeksi->EditValue = HtmlEncode($this->lain_harga_primer_proyeksi->CurrentValue);
            $this->lain_harga_primer_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_primer_proyeksi->caption());

            // lain_harga_sekunder
            $this->lain_harga_sekunder->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder->EditCustomAttributes = "";
            $this->lain_harga_sekunder->EditValue = HtmlEncode($this->lain_harga_sekunder->CurrentValue);
            $this->lain_harga_sekunder->PlaceHolder = RemoveHtml($this->lain_harga_sekunder->caption());

            // lain_harga_sekunder_proyeksi
            $this->lain_harga_sekunder_proyeksi->EditAttrs["class"] = "form-control";
            $this->lain_harga_sekunder_proyeksi->EditCustomAttributes = "";
            $this->lain_harga_sekunder_proyeksi->EditValue = HtmlEncode($this->lain_harga_sekunder_proyeksi->CurrentValue);
            $this->lain_harga_sekunder_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_sekunder_proyeksi->caption());

            // lain_harga_label
            $this->lain_harga_label->EditAttrs["class"] = "form-control";
            $this->lain_harga_label->EditCustomAttributes = "";
            $this->lain_harga_label->EditValue = HtmlEncode($this->lain_harga_label->CurrentValue);
            $this->lain_harga_label->PlaceHolder = RemoveHtml($this->lain_harga_label->caption());

            // lain_harga_label_proyeksi
            $this->lain_harga_label_proyeksi->EditAttrs["class"] = "form-control";
            $this->lain_harga_label_proyeksi->EditCustomAttributes = "";
            $this->lain_harga_label_proyeksi->EditValue = HtmlEncode($this->lain_harga_label_proyeksi->CurrentValue);
            $this->lain_harga_label_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_label_proyeksi->caption());

            // lain_harga_total
            $this->lain_harga_total->EditAttrs["class"] = "form-control";
            $this->lain_harga_total->EditCustomAttributes = "";
            $this->lain_harga_total->EditValue = HtmlEncode($this->lain_harga_total->CurrentValue);
            $this->lain_harga_total->PlaceHolder = RemoveHtml($this->lain_harga_total->caption());

            // lain_harga_total_proyeksi
            $this->lain_harga_total_proyeksi->EditAttrs["class"] = "form-control";
            $this->lain_harga_total_proyeksi->EditCustomAttributes = "";
            $this->lain_harga_total_proyeksi->EditValue = HtmlEncode($this->lain_harga_total_proyeksi->CurrentValue);
            $this->lain_harga_total_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_total_proyeksi->caption());

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

            // delivery_termlain
            $this->delivery_termlain->EditAttrs["class"] = "form-control";
            $this->delivery_termlain->EditCustomAttributes = "";
            if (!$this->delivery_termlain->Raw) {
                $this->delivery_termlain->CurrentValue = HtmlDecode($this->delivery_termlain->CurrentValue);
            }
            $this->delivery_termlain->EditValue = HtmlEncode($this->delivery_termlain->CurrentValue);
            $this->delivery_termlain->PlaceHolder = RemoveHtml($this->delivery_termlain->caption());

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // receipt_by
            $this->receipt_by->EditAttrs["class"] = "form-control";
            $this->receipt_by->EditCustomAttributes = "";
            $this->receipt_by->EditValue = HtmlEncode($this->receipt_by->CurrentValue);
            $this->receipt_by->PlaceHolder = RemoveHtml($this->receipt_by->caption());

            // approve_by
            $this->approve_by->EditAttrs["class"] = "form-control";
            $this->approve_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->approve_by->CurrentValue));
            if ($curVal != "") {
                $this->approve_by->ViewValue = $this->approve_by->lookupCacheOption($curVal);
            } else {
                $this->approve_by->ViewValue = $this->approve_by->Lookup !== null && is_array($this->approve_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->approve_by->ViewValue !== null) { // Load from cache
                $this->approve_by->EditValue = array_values($this->approve_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->approve_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->approve_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->approve_by->EditValue = $arwrk;
            }
            $this->approve_by->PlaceHolder = RemoveHtml($this->approve_by->caption());

            // Add refer script

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";

            // fungsiproduk
            $this->fungsiproduk->LinkCustomAttributes = "";
            $this->fungsiproduk->HrefValue = "";

            // kualitasproduk
            $this->kualitasproduk->LinkCustomAttributes = "";
            $this->kualitasproduk->HrefValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";

            // ukuransediaan
            $this->ukuransediaan->LinkCustomAttributes = "";
            $this->ukuransediaan->HrefValue = "";

            // satuansediaan
            $this->satuansediaan->LinkCustomAttributes = "";
            $this->satuansediaan->HrefValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";

            // aroma
            $this->aroma->LinkCustomAttributes = "";
            $this->aroma->HrefValue = "";

            // aplikasi
            $this->aplikasi->LinkCustomAttributes = "";
            $this->aplikasi->HrefValue = "";

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";

            // ukurankemasan
            $this->ukurankemasan->LinkCustomAttributes = "";
            $this->ukurankemasan->HrefValue = "";

            // satuankemasan
            $this->satuankemasan->LinkCustomAttributes = "";
            $this->satuankemasan->HrefValue = "";

            // kemasanwadah
            $this->kemasanwadah->LinkCustomAttributes = "";
            $this->kemasanwadah->HrefValue = "";

            // kemasantutup
            $this->kemasantutup->LinkCustomAttributes = "";
            $this->kemasantutup->HrefValue = "";

            // kemasancatatan
            $this->kemasancatatan->LinkCustomAttributes = "";
            $this->kemasancatatan->HrefValue = "";

            // ukurankemasansekunder
            $this->ukurankemasansekunder->LinkCustomAttributes = "";
            $this->ukurankemasansekunder->HrefValue = "";

            // satuankemasansekunder
            $this->satuankemasansekunder->LinkCustomAttributes = "";
            $this->satuankemasansekunder->HrefValue = "";

            // kemasanbahan
            $this->kemasanbahan->LinkCustomAttributes = "";
            $this->kemasanbahan->HrefValue = "";

            // kemasanbentuk
            $this->kemasanbentuk->LinkCustomAttributes = "";
            $this->kemasanbentuk->HrefValue = "";

            // kemasankomposisi
            $this->kemasankomposisi->LinkCustomAttributes = "";
            $this->kemasankomposisi->HrefValue = "";

            // kemasancatatansekunder
            $this->kemasancatatansekunder->LinkCustomAttributes = "";
            $this->kemasancatatansekunder->HrefValue = "";

            // labelbahan
            $this->labelbahan->LinkCustomAttributes = "";
            $this->labelbahan->HrefValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";

            // labelcatatan
            $this->labelcatatan->LinkCustomAttributes = "";
            $this->labelcatatan->HrefValue = "";

            // labeltekstur
            $this->labeltekstur->LinkCustomAttributes = "";
            $this->labeltekstur->HrefValue = "";

            // labelprint
            $this->labelprint->LinkCustomAttributes = "";
            $this->labelprint->HrefValue = "";

            // labeljmlwarna
            $this->labeljmlwarna->LinkCustomAttributes = "";
            $this->labeljmlwarna->HrefValue = "";

            // labelcatatanhotprint
            $this->labelcatatanhotprint->LinkCustomAttributes = "";
            $this->labelcatatanhotprint->HrefValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";

            // utama_harga_isi_proyeksi
            $this->utama_harga_isi_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_isi_proyeksi->HrefValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";

            // utama_harga_primer_proyeksi
            $this->utama_harga_primer_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_primer_proyeksi->HrefValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";

            // utama_harga_sekunder_proyeksi
            $this->utama_harga_sekunder_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_proyeksi->HrefValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";

            // utama_harga_label_proyeksi
            $this->utama_harga_label_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_label_proyeksi->HrefValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";

            // utama_harga_total_proyeksi
            $this->utama_harga_total_proyeksi->LinkCustomAttributes = "";
            $this->utama_harga_total_proyeksi->HrefValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";

            // lain_harga_isi_proyeksi
            $this->lain_harga_isi_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_isi_proyeksi->HrefValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";

            // lain_harga_primer_proyeksi
            $this->lain_harga_primer_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_primer_proyeksi->HrefValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";

            // lain_harga_sekunder_proyeksi
            $this->lain_harga_sekunder_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_proyeksi->HrefValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";

            // lain_harga_label_proyeksi
            $this->lain_harga_label_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_label_proyeksi->HrefValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";

            // lain_harga_total_proyeksi
            $this->lain_harga_total_proyeksi->LinkCustomAttributes = "";
            $this->lain_harga_total_proyeksi->HrefValue = "";

            // delivery_pickup
            $this->delivery_pickup->LinkCustomAttributes = "";
            $this->delivery_pickup->HrefValue = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->LinkCustomAttributes = "";
            $this->delivery_singlepoint->HrefValue = "";

            // delivery_multipoint
            $this->delivery_multipoint->LinkCustomAttributes = "";
            $this->delivery_multipoint->HrefValue = "";

            // delivery_termlain
            $this->delivery_termlain->LinkCustomAttributes = "";
            $this->delivery_termlain->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // receipt_by
            $this->receipt_by->LinkCustomAttributes = "";
            $this->receipt_by->HrefValue = "";

            // approve_by
            $this->approve_by->LinkCustomAttributes = "";
            $this->approve_by->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }

        // Save data for Custom Template
        if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD) {
            $this->Rows[] = $this->customTemplateFieldValues();
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
        if ($this->idbrand->Required) {
            if (!$this->idbrand->IsDetailKey && EmptyValue($this->idbrand->FormValue)) {
                $this->idbrand->addErrorMessage(str_replace("%s", $this->idbrand->caption(), $this->idbrand->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_order->Required) {
            if (!$this->tanggal_order->IsDetailKey && EmptyValue($this->tanggal_order->FormValue)) {
                $this->tanggal_order->addErrorMessage(str_replace("%s", $this->tanggal_order->caption(), $this->tanggal_order->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_order->FormValue)) {
            $this->tanggal_order->addErrorMessage($this->tanggal_order->getErrorMessage(false));
        }
        if ($this->target_selesai->Required) {
            if (!$this->target_selesai->IsDetailKey && EmptyValue($this->target_selesai->FormValue)) {
                $this->target_selesai->addErrorMessage(str_replace("%s", $this->target_selesai->caption(), $this->target_selesai->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->target_selesai->FormValue)) {
            $this->target_selesai->addErrorMessage($this->target_selesai->getErrorMessage(false));
        }
        if ($this->sifatorder->Required) {
            if ($this->sifatorder->FormValue == "") {
                $this->sifatorder->addErrorMessage(str_replace("%s", $this->sifatorder->caption(), $this->sifatorder->RequiredErrorMessage));
            }
        }
        if ($this->kodeorder->Required) {
            if (!$this->kodeorder->IsDetailKey && EmptyValue($this->kodeorder->FormValue)) {
                $this->kodeorder->addErrorMessage(str_replace("%s", $this->kodeorder->caption(), $this->kodeorder->RequiredErrorMessage));
            }
        }
        if ($this->nomororder->Required) {
            if (!$this->nomororder->IsDetailKey && EmptyValue($this->nomororder->FormValue)) {
                $this->nomororder->addErrorMessage(str_replace("%s", $this->nomororder->caption(), $this->nomororder->RequiredErrorMessage));
            }
        }
        if ($this->idproduct_acuan->Required) {
            if (!$this->idproduct_acuan->IsDetailKey && EmptyValue($this->idproduct_acuan->FormValue)) {
                $this->idproduct_acuan->addErrorMessage(str_replace("%s", $this->idproduct_acuan->caption(), $this->idproduct_acuan->RequiredErrorMessage));
            }
        }
        if ($this->kategoriproduk->Required) {
            if (!$this->kategoriproduk->IsDetailKey && EmptyValue($this->kategoriproduk->FormValue)) {
                $this->kategoriproduk->addErrorMessage(str_replace("%s", $this->kategoriproduk->caption(), $this->kategoriproduk->RequiredErrorMessage));
            }
        }
        if ($this->jenisproduk->Required) {
            if (!$this->jenisproduk->IsDetailKey && EmptyValue($this->jenisproduk->FormValue)) {
                $this->jenisproduk->addErrorMessage(str_replace("%s", $this->jenisproduk->caption(), $this->jenisproduk->RequiredErrorMessage));
            }
        }
        if ($this->fungsiproduk->Required) {
            if (!$this->fungsiproduk->IsDetailKey && EmptyValue($this->fungsiproduk->FormValue)) {
                $this->fungsiproduk->addErrorMessage(str_replace("%s", $this->fungsiproduk->caption(), $this->fungsiproduk->RequiredErrorMessage));
            }
        }
        if ($this->kualitasproduk->Required) {
            if ($this->kualitasproduk->FormValue == "") {
                $this->kualitasproduk->addErrorMessage(str_replace("%s", $this->kualitasproduk->caption(), $this->kualitasproduk->RequiredErrorMessage));
            }
        }
        if ($this->bahan_campaign->Required) {
            if (!$this->bahan_campaign->IsDetailKey && EmptyValue($this->bahan_campaign->FormValue)) {
                $this->bahan_campaign->addErrorMessage(str_replace("%s", $this->bahan_campaign->caption(), $this->bahan_campaign->RequiredErrorMessage));
            }
        }
        if ($this->ukuransediaan->Required) {
            if (!$this->ukuransediaan->IsDetailKey && EmptyValue($this->ukuransediaan->FormValue)) {
                $this->ukuransediaan->addErrorMessage(str_replace("%s", $this->ukuransediaan->caption(), $this->ukuransediaan->RequiredErrorMessage));
            }
        }
        if ($this->satuansediaan->Required) {
            if (!$this->satuansediaan->IsDetailKey && EmptyValue($this->satuansediaan->FormValue)) {
                $this->satuansediaan->addErrorMessage(str_replace("%s", $this->satuansediaan->caption(), $this->satuansediaan->RequiredErrorMessage));
            }
        }
        if ($this->bentuk->Required) {
            if ($this->bentuk->FormValue == "") {
                $this->bentuk->addErrorMessage(str_replace("%s", $this->bentuk->caption(), $this->bentuk->RequiredErrorMessage));
            }
        }
        if ($this->viskositas->Required) {
            if ($this->viskositas->FormValue == "") {
                $this->viskositas->addErrorMessage(str_replace("%s", $this->viskositas->caption(), $this->viskositas->RequiredErrorMessage));
            }
        }
        if ($this->warna->Required) {
            if ($this->warna->FormValue == "") {
                $this->warna->addErrorMessage(str_replace("%s", $this->warna->caption(), $this->warna->RequiredErrorMessage));
            }
        }
        if ($this->parfum->Required) {
            if (!$this->parfum->IsDetailKey && EmptyValue($this->parfum->FormValue)) {
                $this->parfum->addErrorMessage(str_replace("%s", $this->parfum->caption(), $this->parfum->RequiredErrorMessage));
            }
        }
        if ($this->aroma->Required) {
            if (!$this->aroma->IsDetailKey && EmptyValue($this->aroma->FormValue)) {
                $this->aroma->addErrorMessage(str_replace("%s", $this->aroma->caption(), $this->aroma->RequiredErrorMessage));
            }
        }
        if ($this->aplikasi->Required) {
            if ($this->aplikasi->FormValue == "") {
                $this->aplikasi->addErrorMessage(str_replace("%s", $this->aplikasi->caption(), $this->aplikasi->RequiredErrorMessage));
            }
        }
        if ($this->estetika->Required) {
            if ($this->estetika->FormValue == "") {
                $this->estetika->addErrorMessage(str_replace("%s", $this->estetika->caption(), $this->estetika->RequiredErrorMessage));
            }
        }
        if ($this->tambahan->Required) {
            if (!$this->tambahan->IsDetailKey && EmptyValue($this->tambahan->FormValue)) {
                $this->tambahan->addErrorMessage(str_replace("%s", $this->tambahan->caption(), $this->tambahan->RequiredErrorMessage));
            }
        }
        if ($this->ukurankemasan->Required) {
            if (!$this->ukurankemasan->IsDetailKey && EmptyValue($this->ukurankemasan->FormValue)) {
                $this->ukurankemasan->addErrorMessage(str_replace("%s", $this->ukurankemasan->caption(), $this->ukurankemasan->RequiredErrorMessage));
            }
        }
        if ($this->satuankemasan->Required) {
            if (!$this->satuankemasan->IsDetailKey && EmptyValue($this->satuankemasan->FormValue)) {
                $this->satuankemasan->addErrorMessage(str_replace("%s", $this->satuankemasan->caption(), $this->satuankemasan->RequiredErrorMessage));
            }
        }
        if ($this->kemasanwadah->Required) {
            if ($this->kemasanwadah->FormValue == "") {
                $this->kemasanwadah->addErrorMessage(str_replace("%s", $this->kemasanwadah->caption(), $this->kemasanwadah->RequiredErrorMessage));
            }
        }
        if ($this->kemasantutup->Required) {
            if ($this->kemasantutup->FormValue == "") {
                $this->kemasantutup->addErrorMessage(str_replace("%s", $this->kemasantutup->caption(), $this->kemasantutup->RequiredErrorMessage));
            }
        }
        if ($this->kemasancatatan->Required) {
            if (!$this->kemasancatatan->IsDetailKey && EmptyValue($this->kemasancatatan->FormValue)) {
                $this->kemasancatatan->addErrorMessage(str_replace("%s", $this->kemasancatatan->caption(), $this->kemasancatatan->RequiredErrorMessage));
            }
        }
        if ($this->ukurankemasansekunder->Required) {
            if (!$this->ukurankemasansekunder->IsDetailKey && EmptyValue($this->ukurankemasansekunder->FormValue)) {
                $this->ukurankemasansekunder->addErrorMessage(str_replace("%s", $this->ukurankemasansekunder->caption(), $this->ukurankemasansekunder->RequiredErrorMessage));
            }
        }
        if ($this->satuankemasansekunder->Required) {
            if (!$this->satuankemasansekunder->IsDetailKey && EmptyValue($this->satuankemasansekunder->FormValue)) {
                $this->satuankemasansekunder->addErrorMessage(str_replace("%s", $this->satuankemasansekunder->caption(), $this->satuankemasansekunder->RequiredErrorMessage));
            }
        }
        if ($this->kemasanbahan->Required) {
            if ($this->kemasanbahan->FormValue == "") {
                $this->kemasanbahan->addErrorMessage(str_replace("%s", $this->kemasanbahan->caption(), $this->kemasanbahan->RequiredErrorMessage));
            }
        }
        if ($this->kemasanbentuk->Required) {
            if ($this->kemasanbentuk->FormValue == "") {
                $this->kemasanbentuk->addErrorMessage(str_replace("%s", $this->kemasanbentuk->caption(), $this->kemasanbentuk->RequiredErrorMessage));
            }
        }
        if ($this->kemasankomposisi->Required) {
            if ($this->kemasankomposisi->FormValue == "") {
                $this->kemasankomposisi->addErrorMessage(str_replace("%s", $this->kemasankomposisi->caption(), $this->kemasankomposisi->RequiredErrorMessage));
            }
        }
        if ($this->kemasancatatansekunder->Required) {
            if (!$this->kemasancatatansekunder->IsDetailKey && EmptyValue($this->kemasancatatansekunder->FormValue)) {
                $this->kemasancatatansekunder->addErrorMessage(str_replace("%s", $this->kemasancatatansekunder->caption(), $this->kemasancatatansekunder->RequiredErrorMessage));
            }
        }
        if ($this->labelbahan->Required) {
            if ($this->labelbahan->FormValue == "") {
                $this->labelbahan->addErrorMessage(str_replace("%s", $this->labelbahan->caption(), $this->labelbahan->RequiredErrorMessage));
            }
        }
        if ($this->labelkualitas->Required) {
            if ($this->labelkualitas->FormValue == "") {
                $this->labelkualitas->addErrorMessage(str_replace("%s", $this->labelkualitas->caption(), $this->labelkualitas->RequiredErrorMessage));
            }
        }
        if ($this->labelposisi->Required) {
            if ($this->labelposisi->FormValue == "") {
                $this->labelposisi->addErrorMessage(str_replace("%s", $this->labelposisi->caption(), $this->labelposisi->RequiredErrorMessage));
            }
        }
        if ($this->labelcatatan->Required) {
            if (!$this->labelcatatan->IsDetailKey && EmptyValue($this->labelcatatan->FormValue)) {
                $this->labelcatatan->addErrorMessage(str_replace("%s", $this->labelcatatan->caption(), $this->labelcatatan->RequiredErrorMessage));
            }
        }
        if ($this->labeltekstur->Required) {
            if ($this->labeltekstur->FormValue == "") {
                $this->labeltekstur->addErrorMessage(str_replace("%s", $this->labeltekstur->caption(), $this->labeltekstur->RequiredErrorMessage));
            }
        }
        if ($this->labelprint->Required) {
            if ($this->labelprint->FormValue == "") {
                $this->labelprint->addErrorMessage(str_replace("%s", $this->labelprint->caption(), $this->labelprint->RequiredErrorMessage));
            }
        }
        if ($this->labeljmlwarna->Required) {
            if (!$this->labeljmlwarna->IsDetailKey && EmptyValue($this->labeljmlwarna->FormValue)) {
                $this->labeljmlwarna->addErrorMessage(str_replace("%s", $this->labeljmlwarna->caption(), $this->labeljmlwarna->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->labeljmlwarna->FormValue)) {
            $this->labeljmlwarna->addErrorMessage($this->labeljmlwarna->getErrorMessage(false));
        }
        if ($this->labelcatatanhotprint->Required) {
            if (!$this->labelcatatanhotprint->IsDetailKey && EmptyValue($this->labelcatatanhotprint->FormValue)) {
                $this->labelcatatanhotprint->addErrorMessage(str_replace("%s", $this->labelcatatanhotprint->caption(), $this->labelcatatanhotprint->RequiredErrorMessage));
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
        if ($this->utama_harga_isi_proyeksi->Required) {
            if (!$this->utama_harga_isi_proyeksi->IsDetailKey && EmptyValue($this->utama_harga_isi_proyeksi->FormValue)) {
                $this->utama_harga_isi_proyeksi->addErrorMessage(str_replace("%s", $this->utama_harga_isi_proyeksi->caption(), $this->utama_harga_isi_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_isi_proyeksi->FormValue)) {
            $this->utama_harga_isi_proyeksi->addErrorMessage($this->utama_harga_isi_proyeksi->getErrorMessage(false));
        }
        if ($this->utama_harga_primer->Required) {
            if (!$this->utama_harga_primer->IsDetailKey && EmptyValue($this->utama_harga_primer->FormValue)) {
                $this->utama_harga_primer->addErrorMessage(str_replace("%s", $this->utama_harga_primer->caption(), $this->utama_harga_primer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_primer->FormValue)) {
            $this->utama_harga_primer->addErrorMessage($this->utama_harga_primer->getErrorMessage(false));
        }
        if ($this->utama_harga_primer_proyeksi->Required) {
            if (!$this->utama_harga_primer_proyeksi->IsDetailKey && EmptyValue($this->utama_harga_primer_proyeksi->FormValue)) {
                $this->utama_harga_primer_proyeksi->addErrorMessage(str_replace("%s", $this->utama_harga_primer_proyeksi->caption(), $this->utama_harga_primer_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_primer_proyeksi->FormValue)) {
            $this->utama_harga_primer_proyeksi->addErrorMessage($this->utama_harga_primer_proyeksi->getErrorMessage(false));
        }
        if ($this->utama_harga_sekunder->Required) {
            if (!$this->utama_harga_sekunder->IsDetailKey && EmptyValue($this->utama_harga_sekunder->FormValue)) {
                $this->utama_harga_sekunder->addErrorMessage(str_replace("%s", $this->utama_harga_sekunder->caption(), $this->utama_harga_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_sekunder->FormValue)) {
            $this->utama_harga_sekunder->addErrorMessage($this->utama_harga_sekunder->getErrorMessage(false));
        }
        if ($this->utama_harga_sekunder_proyeksi->Required) {
            if (!$this->utama_harga_sekunder_proyeksi->IsDetailKey && EmptyValue($this->utama_harga_sekunder_proyeksi->FormValue)) {
                $this->utama_harga_sekunder_proyeksi->addErrorMessage(str_replace("%s", $this->utama_harga_sekunder_proyeksi->caption(), $this->utama_harga_sekunder_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_sekunder_proyeksi->FormValue)) {
            $this->utama_harga_sekunder_proyeksi->addErrorMessage($this->utama_harga_sekunder_proyeksi->getErrorMessage(false));
        }
        if ($this->utama_harga_label->Required) {
            if (!$this->utama_harga_label->IsDetailKey && EmptyValue($this->utama_harga_label->FormValue)) {
                $this->utama_harga_label->addErrorMessage(str_replace("%s", $this->utama_harga_label->caption(), $this->utama_harga_label->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_label->FormValue)) {
            $this->utama_harga_label->addErrorMessage($this->utama_harga_label->getErrorMessage(false));
        }
        if ($this->utama_harga_label_proyeksi->Required) {
            if (!$this->utama_harga_label_proyeksi->IsDetailKey && EmptyValue($this->utama_harga_label_proyeksi->FormValue)) {
                $this->utama_harga_label_proyeksi->addErrorMessage(str_replace("%s", $this->utama_harga_label_proyeksi->caption(), $this->utama_harga_label_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_label_proyeksi->FormValue)) {
            $this->utama_harga_label_proyeksi->addErrorMessage($this->utama_harga_label_proyeksi->getErrorMessage(false));
        }
        if ($this->utama_harga_total->Required) {
            if (!$this->utama_harga_total->IsDetailKey && EmptyValue($this->utama_harga_total->FormValue)) {
                $this->utama_harga_total->addErrorMessage(str_replace("%s", $this->utama_harga_total->caption(), $this->utama_harga_total->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_total->FormValue)) {
            $this->utama_harga_total->addErrorMessage($this->utama_harga_total->getErrorMessage(false));
        }
        if ($this->utama_harga_total_proyeksi->Required) {
            if (!$this->utama_harga_total_proyeksi->IsDetailKey && EmptyValue($this->utama_harga_total_proyeksi->FormValue)) {
                $this->utama_harga_total_proyeksi->addErrorMessage(str_replace("%s", $this->utama_harga_total_proyeksi->caption(), $this->utama_harga_total_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utama_harga_total_proyeksi->FormValue)) {
            $this->utama_harga_total_proyeksi->addErrorMessage($this->utama_harga_total_proyeksi->getErrorMessage(false));
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
        if ($this->lain_harga_isi_proyeksi->Required) {
            if (!$this->lain_harga_isi_proyeksi->IsDetailKey && EmptyValue($this->lain_harga_isi_proyeksi->FormValue)) {
                $this->lain_harga_isi_proyeksi->addErrorMessage(str_replace("%s", $this->lain_harga_isi_proyeksi->caption(), $this->lain_harga_isi_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_isi_proyeksi->FormValue)) {
            $this->lain_harga_isi_proyeksi->addErrorMessage($this->lain_harga_isi_proyeksi->getErrorMessage(false));
        }
        if ($this->lain_harga_primer->Required) {
            if (!$this->lain_harga_primer->IsDetailKey && EmptyValue($this->lain_harga_primer->FormValue)) {
                $this->lain_harga_primer->addErrorMessage(str_replace("%s", $this->lain_harga_primer->caption(), $this->lain_harga_primer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_primer->FormValue)) {
            $this->lain_harga_primer->addErrorMessage($this->lain_harga_primer->getErrorMessage(false));
        }
        if ($this->lain_harga_primer_proyeksi->Required) {
            if (!$this->lain_harga_primer_proyeksi->IsDetailKey && EmptyValue($this->lain_harga_primer_proyeksi->FormValue)) {
                $this->lain_harga_primer_proyeksi->addErrorMessage(str_replace("%s", $this->lain_harga_primer_proyeksi->caption(), $this->lain_harga_primer_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_primer_proyeksi->FormValue)) {
            $this->lain_harga_primer_proyeksi->addErrorMessage($this->lain_harga_primer_proyeksi->getErrorMessage(false));
        }
        if ($this->lain_harga_sekunder->Required) {
            if (!$this->lain_harga_sekunder->IsDetailKey && EmptyValue($this->lain_harga_sekunder->FormValue)) {
                $this->lain_harga_sekunder->addErrorMessage(str_replace("%s", $this->lain_harga_sekunder->caption(), $this->lain_harga_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_sekunder->FormValue)) {
            $this->lain_harga_sekunder->addErrorMessage($this->lain_harga_sekunder->getErrorMessage(false));
        }
        if ($this->lain_harga_sekunder_proyeksi->Required) {
            if (!$this->lain_harga_sekunder_proyeksi->IsDetailKey && EmptyValue($this->lain_harga_sekunder_proyeksi->FormValue)) {
                $this->lain_harga_sekunder_proyeksi->addErrorMessage(str_replace("%s", $this->lain_harga_sekunder_proyeksi->caption(), $this->lain_harga_sekunder_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_sekunder_proyeksi->FormValue)) {
            $this->lain_harga_sekunder_proyeksi->addErrorMessage($this->lain_harga_sekunder_proyeksi->getErrorMessage(false));
        }
        if ($this->lain_harga_label->Required) {
            if (!$this->lain_harga_label->IsDetailKey && EmptyValue($this->lain_harga_label->FormValue)) {
                $this->lain_harga_label->addErrorMessage(str_replace("%s", $this->lain_harga_label->caption(), $this->lain_harga_label->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_label->FormValue)) {
            $this->lain_harga_label->addErrorMessage($this->lain_harga_label->getErrorMessage(false));
        }
        if ($this->lain_harga_label_proyeksi->Required) {
            if (!$this->lain_harga_label_proyeksi->IsDetailKey && EmptyValue($this->lain_harga_label_proyeksi->FormValue)) {
                $this->lain_harga_label_proyeksi->addErrorMessage(str_replace("%s", $this->lain_harga_label_proyeksi->caption(), $this->lain_harga_label_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_label_proyeksi->FormValue)) {
            $this->lain_harga_label_proyeksi->addErrorMessage($this->lain_harga_label_proyeksi->getErrorMessage(false));
        }
        if ($this->lain_harga_total->Required) {
            if (!$this->lain_harga_total->IsDetailKey && EmptyValue($this->lain_harga_total->FormValue)) {
                $this->lain_harga_total->addErrorMessage(str_replace("%s", $this->lain_harga_total->caption(), $this->lain_harga_total->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_total->FormValue)) {
            $this->lain_harga_total->addErrorMessage($this->lain_harga_total->getErrorMessage(false));
        }
        if ($this->lain_harga_total_proyeksi->Required) {
            if (!$this->lain_harga_total_proyeksi->IsDetailKey && EmptyValue($this->lain_harga_total_proyeksi->FormValue)) {
                $this->lain_harga_total_proyeksi->addErrorMessage(str_replace("%s", $this->lain_harga_total_proyeksi->caption(), $this->lain_harga_total_proyeksi->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lain_harga_total_proyeksi->FormValue)) {
            $this->lain_harga_total_proyeksi->addErrorMessage($this->lain_harga_total_proyeksi->getErrorMessage(false));
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
        if ($this->delivery_termlain->Required) {
            if (!$this->delivery_termlain->IsDetailKey && EmptyValue($this->delivery_termlain->FormValue)) {
                $this->delivery_termlain->addErrorMessage(str_replace("%s", $this->delivery_termlain->caption(), $this->delivery_termlain->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->receipt_by->Required) {
            if (!$this->receipt_by->IsDetailKey && EmptyValue($this->receipt_by->FormValue)) {
                $this->receipt_by->addErrorMessage(str_replace("%s", $this->receipt_by->caption(), $this->receipt_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->receipt_by->FormValue)) {
            $this->receipt_by->addErrorMessage($this->receipt_by->getErrorMessage(false));
        }
        if ($this->approve_by->Required) {
            if (!$this->approve_by->IsDetailKey && EmptyValue($this->approve_by->FormValue)) {
                $this->approve_by->addErrorMessage(str_replace("%s", $this->approve_by->caption(), $this->approve_by->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("NpdSampleGrid");
        if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdReviewGrid");
        if (in_array("npd_review", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdConfirmsampleGrid");
        if (in_array("npd_confirmsample", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdHargaGrid");
        if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdDesainGrid");
        if (in_array("npd_desain", $detailTblVar) && $detailPage->DetailAdd) {
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
        if ($this->kodeorder->CurrentValue != "") { // Check field with unique index
            $filter = "(`kodeorder` = '" . AdjustSql($this->kodeorder->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->kodeorder->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->kodeorder->CurrentValue, $idxErrMsg);
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

        // idpegawai
        $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, null, false);

        // idcustomer
        $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, null, false);

        // idbrand
        $this->idbrand->setDbValueDef($rsnew, $this->idbrand->CurrentValue, null, false);

        // tanggal_order
        $this->tanggal_order->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_order->CurrentValue, 0), null, false);

        // target_selesai
        $this->target_selesai->setDbValueDef($rsnew, UnFormatDateTime($this->target_selesai->CurrentValue, 0), null, false);

        // sifatorder
        $this->sifatorder->setDbValueDef($rsnew, $this->sifatorder->CurrentValue, "", false);

        // kodeorder
        $this->kodeorder->setDbValueDef($rsnew, $this->kodeorder->CurrentValue, null, false);

        // nomororder
        $this->nomororder->setDbValueDef($rsnew, $this->nomororder->CurrentValue, null, false);

        // idproduct_acuan
        $this->idproduct_acuan->setDbValueDef($rsnew, $this->idproduct_acuan->CurrentValue, null, false);

        // kategoriproduk
        $this->kategoriproduk->setDbValueDef($rsnew, $this->kategoriproduk->CurrentValue, null, false);

        // jenisproduk
        $this->jenisproduk->setDbValueDef($rsnew, $this->jenisproduk->CurrentValue, null, false);

        // fungsiproduk
        $this->fungsiproduk->setDbValueDef($rsnew, $this->fungsiproduk->CurrentValue, null, false);

        // kualitasproduk
        $this->kualitasproduk->setDbValueDef($rsnew, $this->kualitasproduk->CurrentValue, null, false);

        // bahan_campaign
        $this->bahan_campaign->setDbValueDef($rsnew, $this->bahan_campaign->CurrentValue, null, false);

        // ukuransediaan
        $this->ukuransediaan->setDbValueDef($rsnew, $this->ukuransediaan->CurrentValue, null, false);

        // satuansediaan
        $this->satuansediaan->setDbValueDef($rsnew, $this->satuansediaan->CurrentValue, null, false);

        // bentuk
        $this->bentuk->setDbValueDef($rsnew, $this->bentuk->CurrentValue, null, false);

        // viskositas
        $this->viskositas->setDbValueDef($rsnew, $this->viskositas->CurrentValue, null, false);

        // warna
        $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, null, false);

        // parfum
        $this->parfum->setDbValueDef($rsnew, $this->parfum->CurrentValue, null, false);

        // aroma
        $this->aroma->setDbValueDef($rsnew, $this->aroma->CurrentValue, null, false);

        // aplikasi
        $this->aplikasi->setDbValueDef($rsnew, $this->aplikasi->CurrentValue, null, false);

        // estetika
        $this->estetika->setDbValueDef($rsnew, $this->estetika->CurrentValue, null, false);

        // tambahan
        $this->tambahan->setDbValueDef($rsnew, $this->tambahan->CurrentValue, null, false);

        // ukurankemasan
        $this->ukurankemasan->setDbValueDef($rsnew, $this->ukurankemasan->CurrentValue, null, false);

        // satuankemasan
        $this->satuankemasan->setDbValueDef($rsnew, $this->satuankemasan->CurrentValue, null, false);

        // kemasanwadah
        $this->kemasanwadah->setDbValueDef($rsnew, $this->kemasanwadah->CurrentValue, null, false);

        // kemasantutup
        $this->kemasantutup->setDbValueDef($rsnew, $this->kemasantutup->CurrentValue, null, false);

        // kemasancatatan
        $this->kemasancatatan->setDbValueDef($rsnew, $this->kemasancatatan->CurrentValue, null, false);

        // ukurankemasansekunder
        $this->ukurankemasansekunder->setDbValueDef($rsnew, $this->ukurankemasansekunder->CurrentValue, null, false);

        // satuankemasansekunder
        $this->satuankemasansekunder->setDbValueDef($rsnew, $this->satuankemasansekunder->CurrentValue, null, false);

        // kemasanbahan
        $this->kemasanbahan->setDbValueDef($rsnew, $this->kemasanbahan->CurrentValue, null, false);

        // kemasanbentuk
        $this->kemasanbentuk->setDbValueDef($rsnew, $this->kemasanbentuk->CurrentValue, null, false);

        // kemasankomposisi
        $this->kemasankomposisi->setDbValueDef($rsnew, $this->kemasankomposisi->CurrentValue, null, false);

        // kemasancatatansekunder
        $this->kemasancatatansekunder->setDbValueDef($rsnew, $this->kemasancatatansekunder->CurrentValue, null, false);

        // labelbahan
        $this->labelbahan->setDbValueDef($rsnew, $this->labelbahan->CurrentValue, null, false);

        // labelkualitas
        $this->labelkualitas->setDbValueDef($rsnew, $this->labelkualitas->CurrentValue, null, false);

        // labelposisi
        $this->labelposisi->setDbValueDef($rsnew, $this->labelposisi->CurrentValue, null, false);

        // labelcatatan
        $this->labelcatatan->setDbValueDef($rsnew, $this->labelcatatan->CurrentValue, null, false);

        // labeltekstur
        $this->labeltekstur->setDbValueDef($rsnew, $this->labeltekstur->CurrentValue, null, false);

        // labelprint
        $this->labelprint->setDbValueDef($rsnew, $this->labelprint->CurrentValue, null, false);

        // labeljmlwarna
        $this->labeljmlwarna->setDbValueDef($rsnew, $this->labeljmlwarna->CurrentValue, null, false);

        // labelcatatanhotprint
        $this->labelcatatanhotprint->setDbValueDef($rsnew, $this->labelcatatanhotprint->CurrentValue, null, false);

        // ukuran_utama
        $this->ukuran_utama->setDbValueDef($rsnew, $this->ukuran_utama->CurrentValue, null, false);

        // utama_harga_isi
        $this->utama_harga_isi->setDbValueDef($rsnew, $this->utama_harga_isi->CurrentValue, null, false);

        // utama_harga_isi_proyeksi
        $this->utama_harga_isi_proyeksi->setDbValueDef($rsnew, $this->utama_harga_isi_proyeksi->CurrentValue, null, false);

        // utama_harga_primer
        $this->utama_harga_primer->setDbValueDef($rsnew, $this->utama_harga_primer->CurrentValue, null, false);

        // utama_harga_primer_proyeksi
        $this->utama_harga_primer_proyeksi->setDbValueDef($rsnew, $this->utama_harga_primer_proyeksi->CurrentValue, null, false);

        // utama_harga_sekunder
        $this->utama_harga_sekunder->setDbValueDef($rsnew, $this->utama_harga_sekunder->CurrentValue, null, false);

        // utama_harga_sekunder_proyeksi
        $this->utama_harga_sekunder_proyeksi->setDbValueDef($rsnew, $this->utama_harga_sekunder_proyeksi->CurrentValue, null, false);

        // utama_harga_label
        $this->utama_harga_label->setDbValueDef($rsnew, $this->utama_harga_label->CurrentValue, null, false);

        // utama_harga_label_proyeksi
        $this->utama_harga_label_proyeksi->setDbValueDef($rsnew, $this->utama_harga_label_proyeksi->CurrentValue, null, false);

        // utama_harga_total
        $this->utama_harga_total->setDbValueDef($rsnew, $this->utama_harga_total->CurrentValue, null, false);

        // utama_harga_total_proyeksi
        $this->utama_harga_total_proyeksi->setDbValueDef($rsnew, $this->utama_harga_total_proyeksi->CurrentValue, null, false);

        // ukuran_lain
        $this->ukuran_lain->setDbValueDef($rsnew, $this->ukuran_lain->CurrentValue, null, false);

        // lain_harga_isi
        $this->lain_harga_isi->setDbValueDef($rsnew, $this->lain_harga_isi->CurrentValue, null, false);

        // lain_harga_isi_proyeksi
        $this->lain_harga_isi_proyeksi->setDbValueDef($rsnew, $this->lain_harga_isi_proyeksi->CurrentValue, null, false);

        // lain_harga_primer
        $this->lain_harga_primer->setDbValueDef($rsnew, $this->lain_harga_primer->CurrentValue, null, false);

        // lain_harga_primer_proyeksi
        $this->lain_harga_primer_proyeksi->setDbValueDef($rsnew, $this->lain_harga_primer_proyeksi->CurrentValue, null, false);

        // lain_harga_sekunder
        $this->lain_harga_sekunder->setDbValueDef($rsnew, $this->lain_harga_sekunder->CurrentValue, null, false);

        // lain_harga_sekunder_proyeksi
        $this->lain_harga_sekunder_proyeksi->setDbValueDef($rsnew, $this->lain_harga_sekunder_proyeksi->CurrentValue, null, false);

        // lain_harga_label
        $this->lain_harga_label->setDbValueDef($rsnew, $this->lain_harga_label->CurrentValue, null, false);

        // lain_harga_label_proyeksi
        $this->lain_harga_label_proyeksi->setDbValueDef($rsnew, $this->lain_harga_label_proyeksi->CurrentValue, null, false);

        // lain_harga_total
        $this->lain_harga_total->setDbValueDef($rsnew, $this->lain_harga_total->CurrentValue, null, false);

        // lain_harga_total_proyeksi
        $this->lain_harga_total_proyeksi->setDbValueDef($rsnew, $this->lain_harga_total_proyeksi->CurrentValue, null, false);

        // delivery_pickup
        $this->delivery_pickup->setDbValueDef($rsnew, $this->delivery_pickup->CurrentValue, null, false);

        // delivery_singlepoint
        $this->delivery_singlepoint->setDbValueDef($rsnew, $this->delivery_singlepoint->CurrentValue, null, false);

        // delivery_multipoint
        $this->delivery_multipoint->setDbValueDef($rsnew, $this->delivery_multipoint->CurrentValue, null, false);

        // delivery_termlain
        $this->delivery_termlain->setDbValueDef($rsnew, $this->delivery_termlain->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, 0, strval($this->status->CurrentValue) == "");

        // receipt_by
        $this->receipt_by->setDbValueDef($rsnew, $this->receipt_by->CurrentValue, null, false);

        // approve_by
        $this->approve_by->setDbValueDef($rsnew, $this->approve_by->CurrentValue, null, false);

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
            $detailPage = Container("NpdConfirmsampleGrid");
            if (in_array("npd_confirmsample", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_confirmsample"); // Load user level of detail table
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
            $detailPage = Container("NpdDesainGrid");
            if (in_array("npd_desain", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_desain"); // Load user level of detail table
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
            if (in_array("npd_confirmsample", $detailTblVar)) {
                $detailPageObj = Container("NpdConfirmsampleGrid");
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
            if (in_array("npd_desain", $detailTblVar)) {
                $detailPageObj = Container("NpdDesainGrid");
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
        $pages->add('npd_sample');
        $pages->add('npd_review');
        $pages->add('npd_confirmsample');
        $pages->add('npd_harga');
        $pages->add('npd_desain');
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
                case "x_idpegawai":
                    break;
                case "x_idcustomer":
                    break;
                case "x_idbrand":
                    break;
                case "x_sifatorder":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_kategoriproduk":
                    break;
                case "x_jenisproduk":
                    break;
                case "x_kualitasproduk":
                    break;
                case "x_satuansediaan":
                    break;
                case "x_bentuk":
                    break;
                case "x_viskositas":
                    break;
                case "x_warna":
                    break;
                case "x_parfum":
                    break;
                case "x_aplikasi":
                    break;
                case "x_estetika":
                    break;
                case "x_satuankemasan":
                    break;
                case "x_kemasanwadah":
                    break;
                case "x_kemasantutup":
                    break;
                case "x_satuankemasansekunder":
                    break;
                case "x_kemasanbahan":
                    break;
                case "x_kemasanbentuk":
                    break;
                case "x_kemasankomposisi":
                    break;
                case "x_labelbahan":
                    break;
                case "x_labelkualitas":
                    break;
                case "x_labelposisi":
                    break;
                case "x_labeltekstur":
                    break;
                case "x_labelprint":
                    break;
                case "x_status":
                    break;
                case "x_readonly":
                    break;
                case "x_approve_by":
                    break;
                case "x_selesai":
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
