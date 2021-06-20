<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class OrderPengembanganEdit extends OrderPengembangan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'order_pengembangan';

    // Page object name
    public $PageObjName = "OrderPengembanganEdit";

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

        // Table object (order_pengembangan)
        if (!isset($GLOBALS["order_pengembangan"]) || get_class($GLOBALS["order_pengembangan"]) == PROJECT_NAMESPACE . "order_pengembangan") {
            $GLOBALS["order_pengembangan"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'order_pengembangan');
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
                $doc = new $class(Container("order_pengembangan"));
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
                    if ($pageName == "OrderPengembanganView") {
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
        $this->cpo_jenis->setVisibility();
        $this->ordernum->setVisibility();
        $this->order_kode->setVisibility();
        $this->orderterimatgl->setVisibility();
        $this->produk_fungsi->setVisibility();
        $this->produk_kualitas->setVisibility();
        $this->produk_campaign->setVisibility();
        $this->kemasan_satuan->setVisibility();
        $this->ordertgl->setVisibility();
        $this->custcode->setVisibility();
        $this->perushnama->setVisibility();
        $this->perushalamat->setVisibility();
        $this->perushcp->setVisibility();
        $this->perushjabatan->setVisibility();
        $this->perushphone->setVisibility();
        $this->perushmobile->setVisibility();
        $this->bencmark->setVisibility();
        $this->kategoriproduk->setVisibility();
        $this->jenisproduk->setVisibility();
        $this->bentuksediaan->setVisibility();
        $this->sediaan_ukuran->setVisibility();
        $this->sediaan_ukuran_satuan->setVisibility();
        $this->produk_viskositas->setVisibility();
        $this->konsepproduk->setVisibility();
        $this->fragrance->setVisibility();
        $this->aroma->setVisibility();
        $this->bahanaktif->setVisibility();
        $this->warna->setVisibility();
        $this->produk_warna_jenis->setVisibility();
        $this->aksesoris->setVisibility();
        $this->produk_lainlain->setVisibility();
        $this->statusproduk->setVisibility();
        $this->parfum->setVisibility();
        $this->catatan->setVisibility();
        $this->rencanakemasan->setVisibility();
        $this->keterangan->setVisibility();
        $this->ekspetasiharga->setVisibility();
        $this->kemasan->setVisibility();
        $this->volume->setVisibility();
        $this->jenistutup->setVisibility();
        $this->catatanpackaging->setVisibility();
        $this->infopackaging->setVisibility();
        $this->ukuran->setVisibility();
        $this->desainprodukkemasan->setVisibility();
        $this->desaindiinginkan->setVisibility();
        $this->mereknotifikasi->setVisibility();
        $this->kategoristatus->setVisibility();
        $this->kemasan_ukuran_satuan->setVisibility();
        $this->notifikasicatatan->setVisibility();
        $this->label_ukuran->setVisibility();
        $this->infolabel->setVisibility();
        $this->labelkualitas->setVisibility();
        $this->labelposisi->setVisibility();
        $this->labelcatatan->setVisibility();
        $this->dibuatdi->setVisibility();
        $this->tanggal->setVisibility();
        $this->penerima->setVisibility();
        $this->createat->setVisibility();
        $this->createby->setVisibility();
        $this->statusdokumen->setVisibility();
        $this->update_at->setVisibility();
        $this->status_data->setVisibility();
        $this->harga_rnd->setVisibility();
        $this->aplikasi_sediaan->setVisibility();
        $this->hu_hrg_isi->setVisibility();
        $this->hu_hrg_isi_pro->setVisibility();
        $this->hu_hrg_kms_primer->setVisibility();
        $this->hu_hrg_kms_primer_pro->setVisibility();
        $this->hu_hrg_kms_sekunder->setVisibility();
        $this->hu_hrg_kms_sekunder_pro->setVisibility();
        $this->hu_hrg_label->setVisibility();
        $this->hu_hrg_label_pro->setVisibility();
        $this->hu_hrg_total->setVisibility();
        $this->hu_hrg_total_pro->setVisibility();
        $this->hl_hrg_isi->setVisibility();
        $this->hl_hrg_isi_pro->setVisibility();
        $this->hl_hrg_kms_primer->setVisibility();
        $this->hl_hrg_kms_primer_pro->setVisibility();
        $this->hl_hrg_kms_sekunder->setVisibility();
        $this->hl_hrg_kms_sekunder_pro->setVisibility();
        $this->hl_hrg_label->setVisibility();
        $this->hl_hrg_label_pro->setVisibility();
        $this->hl_hrg_total->setVisibility();
        $this->hl_hrg_total_pro->setVisibility();
        $this->bs_bahan_aktif_tick->setVisibility();
        $this->bs_bahan_aktif->setVisibility();
        $this->bs_bahan_lain->setVisibility();
        $this->bs_parfum->setVisibility();
        $this->bs_estetika->setVisibility();
        $this->bs_kms_wadah->setVisibility();
        $this->bs_kms_tutup->setVisibility();
        $this->bs_kms_sekunder->setVisibility();
        $this->bs_label_desain->setVisibility();
        $this->bs_label_cetak->setVisibility();
        $this->bs_label_lain->setVisibility();
        $this->dlv_pickup->setVisibility();
        $this->dlv_singlepoint->setVisibility();
        $this->dlv_multipoint->setVisibility();
        $this->dlv_multipoint_jml->setVisibility();
        $this->dlv_term_lain->setVisibility();
        $this->catatan_khusus->setVisibility();
        $this->aju_tgl->setVisibility();
        $this->aju_oleh->setVisibility();
        $this->proses_tgl->setVisibility();
        $this->proses_oleh->setVisibility();
        $this->revisi_tgl->setVisibility();
        $this->revisi_oleh->setVisibility();
        $this->revisi_akun_tgl->setVisibility();
        $this->revisi_akun_oleh->setVisibility();
        $this->revisi_rnd_tgl->setVisibility();
        $this->revisi_rnd_oleh->setVisibility();
        $this->rnd_tgl->setVisibility();
        $this->rnd_oleh->setVisibility();
        $this->ap_tgl->setVisibility();
        $this->ap_oleh->setVisibility();
        $this->batal_tgl->setVisibility();
        $this->batal_oleh->setVisibility();
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
                    $this->terminate("OrderPengembanganList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "OrderPengembanganList") {
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
            if (IsApi() && $val === null) {
                $this->id->Visible = false; // Disable update for API request
            } else {
                $this->id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_id")) {
            $this->id->setOldValue($CurrentForm->getValue("o_id"));
        }

        // Check field name 'cpo_jenis' first before field var 'x_cpo_jenis'
        $val = $CurrentForm->hasValue("cpo_jenis") ? $CurrentForm->getValue("cpo_jenis") : $CurrentForm->getValue("x_cpo_jenis");
        if (!$this->cpo_jenis->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cpo_jenis->Visible = false; // Disable update for API request
            } else {
                $this->cpo_jenis->setFormValue($val);
            }
        }

        // Check field name 'ordernum' first before field var 'x_ordernum'
        $val = $CurrentForm->hasValue("ordernum") ? $CurrentForm->getValue("ordernum") : $CurrentForm->getValue("x_ordernum");
        if (!$this->ordernum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ordernum->Visible = false; // Disable update for API request
            } else {
                $this->ordernum->setFormValue($val);
            }
        }

        // Check field name 'order_kode' first before field var 'x_order_kode'
        $val = $CurrentForm->hasValue("order_kode") ? $CurrentForm->getValue("order_kode") : $CurrentForm->getValue("x_order_kode");
        if (!$this->order_kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->order_kode->Visible = false; // Disable update for API request
            } else {
                $this->order_kode->setFormValue($val);
            }
        }

        // Check field name 'orderterimatgl' first before field var 'x_orderterimatgl'
        $val = $CurrentForm->hasValue("orderterimatgl") ? $CurrentForm->getValue("orderterimatgl") : $CurrentForm->getValue("x_orderterimatgl");
        if (!$this->orderterimatgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orderterimatgl->Visible = false; // Disable update for API request
            } else {
                $this->orderterimatgl->setFormValue($val);
            }
            $this->orderterimatgl->CurrentValue = UnFormatDateTime($this->orderterimatgl->CurrentValue, 0);
        }

        // Check field name 'produk_fungsi' first before field var 'x_produk_fungsi'
        $val = $CurrentForm->hasValue("produk_fungsi") ? $CurrentForm->getValue("produk_fungsi") : $CurrentForm->getValue("x_produk_fungsi");
        if (!$this->produk_fungsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk_fungsi->Visible = false; // Disable update for API request
            } else {
                $this->produk_fungsi->setFormValue($val);
            }
        }

        // Check field name 'produk_kualitas' first before field var 'x_produk_kualitas'
        $val = $CurrentForm->hasValue("produk_kualitas") ? $CurrentForm->getValue("produk_kualitas") : $CurrentForm->getValue("x_produk_kualitas");
        if (!$this->produk_kualitas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk_kualitas->Visible = false; // Disable update for API request
            } else {
                $this->produk_kualitas->setFormValue($val);
            }
        }

        // Check field name 'produk_campaign' first before field var 'x_produk_campaign'
        $val = $CurrentForm->hasValue("produk_campaign") ? $CurrentForm->getValue("produk_campaign") : $CurrentForm->getValue("x_produk_campaign");
        if (!$this->produk_campaign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk_campaign->Visible = false; // Disable update for API request
            } else {
                $this->produk_campaign->setFormValue($val);
            }
        }

        // Check field name 'kemasan_satuan' first before field var 'x_kemasan_satuan'
        $val = $CurrentForm->hasValue("kemasan_satuan") ? $CurrentForm->getValue("kemasan_satuan") : $CurrentForm->getValue("x_kemasan_satuan");
        if (!$this->kemasan_satuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_satuan->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_satuan->setFormValue($val);
            }
        }

        // Check field name 'ordertgl' first before field var 'x_ordertgl'
        $val = $CurrentForm->hasValue("ordertgl") ? $CurrentForm->getValue("ordertgl") : $CurrentForm->getValue("x_ordertgl");
        if (!$this->ordertgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ordertgl->Visible = false; // Disable update for API request
            } else {
                $this->ordertgl->setFormValue($val);
            }
            $this->ordertgl->CurrentValue = UnFormatDateTime($this->ordertgl->CurrentValue, 0);
        }

        // Check field name 'custcode' first before field var 'x_custcode'
        $val = $CurrentForm->hasValue("custcode") ? $CurrentForm->getValue("custcode") : $CurrentForm->getValue("x_custcode");
        if (!$this->custcode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->custcode->Visible = false; // Disable update for API request
            } else {
                $this->custcode->setFormValue($val);
            }
        }

        // Check field name 'perushnama' first before field var 'x_perushnama'
        $val = $CurrentForm->hasValue("perushnama") ? $CurrentForm->getValue("perushnama") : $CurrentForm->getValue("x_perushnama");
        if (!$this->perushnama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perushnama->Visible = false; // Disable update for API request
            } else {
                $this->perushnama->setFormValue($val);
            }
        }

        // Check field name 'perushalamat' first before field var 'x_perushalamat'
        $val = $CurrentForm->hasValue("perushalamat") ? $CurrentForm->getValue("perushalamat") : $CurrentForm->getValue("x_perushalamat");
        if (!$this->perushalamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perushalamat->Visible = false; // Disable update for API request
            } else {
                $this->perushalamat->setFormValue($val);
            }
        }

        // Check field name 'perushcp' first before field var 'x_perushcp'
        $val = $CurrentForm->hasValue("perushcp") ? $CurrentForm->getValue("perushcp") : $CurrentForm->getValue("x_perushcp");
        if (!$this->perushcp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perushcp->Visible = false; // Disable update for API request
            } else {
                $this->perushcp->setFormValue($val);
            }
        }

        // Check field name 'perushjabatan' first before field var 'x_perushjabatan'
        $val = $CurrentForm->hasValue("perushjabatan") ? $CurrentForm->getValue("perushjabatan") : $CurrentForm->getValue("x_perushjabatan");
        if (!$this->perushjabatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perushjabatan->Visible = false; // Disable update for API request
            } else {
                $this->perushjabatan->setFormValue($val);
            }
        }

        // Check field name 'perushphone' first before field var 'x_perushphone'
        $val = $CurrentForm->hasValue("perushphone") ? $CurrentForm->getValue("perushphone") : $CurrentForm->getValue("x_perushphone");
        if (!$this->perushphone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perushphone->Visible = false; // Disable update for API request
            } else {
                $this->perushphone->setFormValue($val);
            }
        }

        // Check field name 'perushmobile' first before field var 'x_perushmobile'
        $val = $CurrentForm->hasValue("perushmobile") ? $CurrentForm->getValue("perushmobile") : $CurrentForm->getValue("x_perushmobile");
        if (!$this->perushmobile->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perushmobile->Visible = false; // Disable update for API request
            } else {
                $this->perushmobile->setFormValue($val);
            }
        }

        // Check field name 'bencmark' first before field var 'x_bencmark'
        $val = $CurrentForm->hasValue("bencmark") ? $CurrentForm->getValue("bencmark") : $CurrentForm->getValue("x_bencmark");
        if (!$this->bencmark->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bencmark->Visible = false; // Disable update for API request
            } else {
                $this->bencmark->setFormValue($val);
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

        // Check field name 'bentuksediaan' first before field var 'x_bentuksediaan'
        $val = $CurrentForm->hasValue("bentuksediaan") ? $CurrentForm->getValue("bentuksediaan") : $CurrentForm->getValue("x_bentuksediaan");
        if (!$this->bentuksediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuksediaan->Visible = false; // Disable update for API request
            } else {
                $this->bentuksediaan->setFormValue($val);
            }
        }

        // Check field name 'sediaan_ukuran' first before field var 'x_sediaan_ukuran'
        $val = $CurrentForm->hasValue("sediaan_ukuran") ? $CurrentForm->getValue("sediaan_ukuran") : $CurrentForm->getValue("x_sediaan_ukuran");
        if (!$this->sediaan_ukuran->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sediaan_ukuran->Visible = false; // Disable update for API request
            } else {
                $this->sediaan_ukuran->setFormValue($val);
            }
        }

        // Check field name 'sediaan_ukuran_satuan' first before field var 'x_sediaan_ukuran_satuan'
        $val = $CurrentForm->hasValue("sediaan_ukuran_satuan") ? $CurrentForm->getValue("sediaan_ukuran_satuan") : $CurrentForm->getValue("x_sediaan_ukuran_satuan");
        if (!$this->sediaan_ukuran_satuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sediaan_ukuran_satuan->Visible = false; // Disable update for API request
            } else {
                $this->sediaan_ukuran_satuan->setFormValue($val);
            }
        }

        // Check field name 'produk_viskositas' first before field var 'x_produk_viskositas'
        $val = $CurrentForm->hasValue("produk_viskositas") ? $CurrentForm->getValue("produk_viskositas") : $CurrentForm->getValue("x_produk_viskositas");
        if (!$this->produk_viskositas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk_viskositas->Visible = false; // Disable update for API request
            } else {
                $this->produk_viskositas->setFormValue($val);
            }
        }

        // Check field name 'konsepproduk' first before field var 'x_konsepproduk'
        $val = $CurrentForm->hasValue("konsepproduk") ? $CurrentForm->getValue("konsepproduk") : $CurrentForm->getValue("x_konsepproduk");
        if (!$this->konsepproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->konsepproduk->Visible = false; // Disable update for API request
            } else {
                $this->konsepproduk->setFormValue($val);
            }
        }

        // Check field name 'fragrance' first before field var 'x_fragrance'
        $val = $CurrentForm->hasValue("fragrance") ? $CurrentForm->getValue("fragrance") : $CurrentForm->getValue("x_fragrance");
        if (!$this->fragrance->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fragrance->Visible = false; // Disable update for API request
            } else {
                $this->fragrance->setFormValue($val);
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

        // Check field name 'bahanaktif' first before field var 'x_bahanaktif'
        $val = $CurrentForm->hasValue("bahanaktif") ? $CurrentForm->getValue("bahanaktif") : $CurrentForm->getValue("x_bahanaktif");
        if (!$this->bahanaktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahanaktif->Visible = false; // Disable update for API request
            } else {
                $this->bahanaktif->setFormValue($val);
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

        // Check field name 'produk_warna_jenis' first before field var 'x_produk_warna_jenis'
        $val = $CurrentForm->hasValue("produk_warna_jenis") ? $CurrentForm->getValue("produk_warna_jenis") : $CurrentForm->getValue("x_produk_warna_jenis");
        if (!$this->produk_warna_jenis->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk_warna_jenis->Visible = false; // Disable update for API request
            } else {
                $this->produk_warna_jenis->setFormValue($val);
            }
        }

        // Check field name 'aksesoris' first before field var 'x_aksesoris'
        $val = $CurrentForm->hasValue("aksesoris") ? $CurrentForm->getValue("aksesoris") : $CurrentForm->getValue("x_aksesoris");
        if (!$this->aksesoris->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aksesoris->Visible = false; // Disable update for API request
            } else {
                $this->aksesoris->setFormValue($val);
            }
        }

        // Check field name 'produk_lainlain' first before field var 'x_produk_lainlain'
        $val = $CurrentForm->hasValue("produk_lainlain") ? $CurrentForm->getValue("produk_lainlain") : $CurrentForm->getValue("x_produk_lainlain");
        if (!$this->produk_lainlain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk_lainlain->Visible = false; // Disable update for API request
            } else {
                $this->produk_lainlain->setFormValue($val);
            }
        }

        // Check field name 'statusproduk' first before field var 'x_statusproduk'
        $val = $CurrentForm->hasValue("statusproduk") ? $CurrentForm->getValue("statusproduk") : $CurrentForm->getValue("x_statusproduk");
        if (!$this->statusproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->statusproduk->Visible = false; // Disable update for API request
            } else {
                $this->statusproduk->setFormValue($val);
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

        // Check field name 'catatan' first before field var 'x_catatan'
        $val = $CurrentForm->hasValue("catatan") ? $CurrentForm->getValue("catatan") : $CurrentForm->getValue("x_catatan");
        if (!$this->catatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatan->Visible = false; // Disable update for API request
            } else {
                $this->catatan->setFormValue($val);
            }
        }

        // Check field name 'rencanakemasan' first before field var 'x_rencanakemasan'
        $val = $CurrentForm->hasValue("rencanakemasan") ? $CurrentForm->getValue("rencanakemasan") : $CurrentForm->getValue("x_rencanakemasan");
        if (!$this->rencanakemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rencanakemasan->Visible = false; // Disable update for API request
            } else {
                $this->rencanakemasan->setFormValue($val);
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

        // Check field name 'ekspetasiharga' first before field var 'x_ekspetasiharga'
        $val = $CurrentForm->hasValue("ekspetasiharga") ? $CurrentForm->getValue("ekspetasiharga") : $CurrentForm->getValue("x_ekspetasiharga");
        if (!$this->ekspetasiharga->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ekspetasiharga->Visible = false; // Disable update for API request
            } else {
                $this->ekspetasiharga->setFormValue($val);
            }
        }

        // Check field name 'kemasan' first before field var 'x_kemasan'
        $val = $CurrentForm->hasValue("kemasan") ? $CurrentForm->getValue("kemasan") : $CurrentForm->getValue("x_kemasan");
        if (!$this->kemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan->Visible = false; // Disable update for API request
            } else {
                $this->kemasan->setFormValue($val);
            }
        }

        // Check field name 'volume' first before field var 'x_volume'
        $val = $CurrentForm->hasValue("volume") ? $CurrentForm->getValue("volume") : $CurrentForm->getValue("x_volume");
        if (!$this->volume->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->volume->Visible = false; // Disable update for API request
            } else {
                $this->volume->setFormValue($val);
            }
        }

        // Check field name 'jenistutup' first before field var 'x_jenistutup'
        $val = $CurrentForm->hasValue("jenistutup") ? $CurrentForm->getValue("jenistutup") : $CurrentForm->getValue("x_jenistutup");
        if (!$this->jenistutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenistutup->Visible = false; // Disable update for API request
            } else {
                $this->jenistutup->setFormValue($val);
            }
        }

        // Check field name 'catatanpackaging' first before field var 'x_catatanpackaging'
        $val = $CurrentForm->hasValue("catatanpackaging") ? $CurrentForm->getValue("catatanpackaging") : $CurrentForm->getValue("x_catatanpackaging");
        if (!$this->catatanpackaging->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatanpackaging->Visible = false; // Disable update for API request
            } else {
                $this->catatanpackaging->setFormValue($val);
            }
        }

        // Check field name 'infopackaging' first before field var 'x_infopackaging'
        $val = $CurrentForm->hasValue("infopackaging") ? $CurrentForm->getValue("infopackaging") : $CurrentForm->getValue("x_infopackaging");
        if (!$this->infopackaging->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->infopackaging->Visible = false; // Disable update for API request
            } else {
                $this->infopackaging->setFormValue($val);
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

        // Check field name 'desainprodukkemasan' first before field var 'x_desainprodukkemasan'
        $val = $CurrentForm->hasValue("desainprodukkemasan") ? $CurrentForm->getValue("desainprodukkemasan") : $CurrentForm->getValue("x_desainprodukkemasan");
        if (!$this->desainprodukkemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desainprodukkemasan->Visible = false; // Disable update for API request
            } else {
                $this->desainprodukkemasan->setFormValue($val);
            }
        }

        // Check field name 'desaindiinginkan' first before field var 'x_desaindiinginkan'
        $val = $CurrentForm->hasValue("desaindiinginkan") ? $CurrentForm->getValue("desaindiinginkan") : $CurrentForm->getValue("x_desaindiinginkan");
        if (!$this->desaindiinginkan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desaindiinginkan->Visible = false; // Disable update for API request
            } else {
                $this->desaindiinginkan->setFormValue($val);
            }
        }

        // Check field name 'mereknotifikasi' first before field var 'x_mereknotifikasi'
        $val = $CurrentForm->hasValue("mereknotifikasi") ? $CurrentForm->getValue("mereknotifikasi") : $CurrentForm->getValue("x_mereknotifikasi");
        if (!$this->mereknotifikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mereknotifikasi->Visible = false; // Disable update for API request
            } else {
                $this->mereknotifikasi->setFormValue($val);
            }
        }

        // Check field name 'kategoristatus' first before field var 'x_kategoristatus'
        $val = $CurrentForm->hasValue("kategoristatus") ? $CurrentForm->getValue("kategoristatus") : $CurrentForm->getValue("x_kategoristatus");
        if (!$this->kategoristatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategoristatus->Visible = false; // Disable update for API request
            } else {
                $this->kategoristatus->setFormValue($val);
            }
        }

        // Check field name 'kemasan_ukuran_satuan' first before field var 'x_kemasan_ukuran_satuan'
        $val = $CurrentForm->hasValue("kemasan_ukuran_satuan") ? $CurrentForm->getValue("kemasan_ukuran_satuan") : $CurrentForm->getValue("x_kemasan_ukuran_satuan");
        if (!$this->kemasan_ukuran_satuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasan_ukuran_satuan->Visible = false; // Disable update for API request
            } else {
                $this->kemasan_ukuran_satuan->setFormValue($val);
            }
        }

        // Check field name 'notifikasicatatan' first before field var 'x_notifikasicatatan'
        $val = $CurrentForm->hasValue("notifikasicatatan") ? $CurrentForm->getValue("notifikasicatatan") : $CurrentForm->getValue("x_notifikasicatatan");
        if (!$this->notifikasicatatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->notifikasicatatan->Visible = false; // Disable update for API request
            } else {
                $this->notifikasicatatan->setFormValue($val);
            }
        }

        // Check field name 'label_ukuran' first before field var 'x_label_ukuran'
        $val = $CurrentForm->hasValue("label_ukuran") ? $CurrentForm->getValue("label_ukuran") : $CurrentForm->getValue("x_label_ukuran");
        if (!$this->label_ukuran->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label_ukuran->Visible = false; // Disable update for API request
            } else {
                $this->label_ukuran->setFormValue($val);
            }
        }

        // Check field name 'infolabel' first before field var 'x_infolabel'
        $val = $CurrentForm->hasValue("infolabel") ? $CurrentForm->getValue("infolabel") : $CurrentForm->getValue("x_infolabel");
        if (!$this->infolabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->infolabel->Visible = false; // Disable update for API request
            } else {
                $this->infolabel->setFormValue($val);
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

        // Check field name 'dibuatdi' first before field var 'x_dibuatdi'
        $val = $CurrentForm->hasValue("dibuatdi") ? $CurrentForm->getValue("dibuatdi") : $CurrentForm->getValue("x_dibuatdi");
        if (!$this->dibuatdi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dibuatdi->Visible = false; // Disable update for API request
            } else {
                $this->dibuatdi->setFormValue($val);
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

        // Check field name 'penerima' first before field var 'x_penerima'
        $val = $CurrentForm->hasValue("penerima") ? $CurrentForm->getValue("penerima") : $CurrentForm->getValue("x_penerima");
        if (!$this->penerima->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->penerima->Visible = false; // Disable update for API request
            } else {
                $this->penerima->setFormValue($val);
            }
        }

        // Check field name 'createat' first before field var 'x_createat'
        $val = $CurrentForm->hasValue("createat") ? $CurrentForm->getValue("createat") : $CurrentForm->getValue("x_createat");
        if (!$this->createat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createat->Visible = false; // Disable update for API request
            } else {
                $this->createat->setFormValue($val);
            }
            $this->createat->CurrentValue = UnFormatDateTime($this->createat->CurrentValue, 0);
        }

        // Check field name 'createby' first before field var 'x_createby'
        $val = $CurrentForm->hasValue("createby") ? $CurrentForm->getValue("createby") : $CurrentForm->getValue("x_createby");
        if (!$this->createby->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createby->Visible = false; // Disable update for API request
            } else {
                $this->createby->setFormValue($val);
            }
        }

        // Check field name 'statusdokumen' first before field var 'x_statusdokumen'
        $val = $CurrentForm->hasValue("statusdokumen") ? $CurrentForm->getValue("statusdokumen") : $CurrentForm->getValue("x_statusdokumen");
        if (!$this->statusdokumen->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->statusdokumen->Visible = false; // Disable update for API request
            } else {
                $this->statusdokumen->setFormValue($val);
            }
        }

        // Check field name 'update_at' first before field var 'x_update_at'
        $val = $CurrentForm->hasValue("update_at") ? $CurrentForm->getValue("update_at") : $CurrentForm->getValue("x_update_at");
        if (!$this->update_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->update_at->Visible = false; // Disable update for API request
            } else {
                $this->update_at->setFormValue($val);
            }
            $this->update_at->CurrentValue = UnFormatDateTime($this->update_at->CurrentValue, 0);
        }

        // Check field name 'status_data' first before field var 'x_status_data'
        $val = $CurrentForm->hasValue("status_data") ? $CurrentForm->getValue("status_data") : $CurrentForm->getValue("x_status_data");
        if (!$this->status_data->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status_data->Visible = false; // Disable update for API request
            } else {
                $this->status_data->setFormValue($val);
            }
        }

        // Check field name 'harga_rnd' first before field var 'x_harga_rnd'
        $val = $CurrentForm->hasValue("harga_rnd") ? $CurrentForm->getValue("harga_rnd") : $CurrentForm->getValue("x_harga_rnd");
        if (!$this->harga_rnd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->harga_rnd->Visible = false; // Disable update for API request
            } else {
                $this->harga_rnd->setFormValue($val);
            }
        }

        // Check field name 'aplikasi_sediaan' first before field var 'x_aplikasi_sediaan'
        $val = $CurrentForm->hasValue("aplikasi_sediaan") ? $CurrentForm->getValue("aplikasi_sediaan") : $CurrentForm->getValue("x_aplikasi_sediaan");
        if (!$this->aplikasi_sediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasi_sediaan->Visible = false; // Disable update for API request
            } else {
                $this->aplikasi_sediaan->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_isi' first before field var 'x_hu_hrg_isi'
        $val = $CurrentForm->hasValue("hu_hrg_isi") ? $CurrentForm->getValue("hu_hrg_isi") : $CurrentForm->getValue("x_hu_hrg_isi");
        if (!$this->hu_hrg_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_isi->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_isi->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_isi_pro' first before field var 'x_hu_hrg_isi_pro'
        $val = $CurrentForm->hasValue("hu_hrg_isi_pro") ? $CurrentForm->getValue("hu_hrg_isi_pro") : $CurrentForm->getValue("x_hu_hrg_isi_pro");
        if (!$this->hu_hrg_isi_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_isi_pro->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_isi_pro->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_kms_primer' first before field var 'x_hu_hrg_kms_primer'
        $val = $CurrentForm->hasValue("hu_hrg_kms_primer") ? $CurrentForm->getValue("hu_hrg_kms_primer") : $CurrentForm->getValue("x_hu_hrg_kms_primer");
        if (!$this->hu_hrg_kms_primer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_kms_primer->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_kms_primer->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_kms_primer_pro' first before field var 'x_hu_hrg_kms_primer_pro'
        $val = $CurrentForm->hasValue("hu_hrg_kms_primer_pro") ? $CurrentForm->getValue("hu_hrg_kms_primer_pro") : $CurrentForm->getValue("x_hu_hrg_kms_primer_pro");
        if (!$this->hu_hrg_kms_primer_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_kms_primer_pro->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_kms_primer_pro->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_kms_sekunder' first before field var 'x_hu_hrg_kms_sekunder'
        $val = $CurrentForm->hasValue("hu_hrg_kms_sekunder") ? $CurrentForm->getValue("hu_hrg_kms_sekunder") : $CurrentForm->getValue("x_hu_hrg_kms_sekunder");
        if (!$this->hu_hrg_kms_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_kms_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_kms_sekunder->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_kms_sekunder_pro' first before field var 'x_hu_hrg_kms_sekunder_pro'
        $val = $CurrentForm->hasValue("hu_hrg_kms_sekunder_pro") ? $CurrentForm->getValue("hu_hrg_kms_sekunder_pro") : $CurrentForm->getValue("x_hu_hrg_kms_sekunder_pro");
        if (!$this->hu_hrg_kms_sekunder_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_kms_sekunder_pro->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_kms_sekunder_pro->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_label' first before field var 'x_hu_hrg_label'
        $val = $CurrentForm->hasValue("hu_hrg_label") ? $CurrentForm->getValue("hu_hrg_label") : $CurrentForm->getValue("x_hu_hrg_label");
        if (!$this->hu_hrg_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_label->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_label->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_label_pro' first before field var 'x_hu_hrg_label_pro'
        $val = $CurrentForm->hasValue("hu_hrg_label_pro") ? $CurrentForm->getValue("hu_hrg_label_pro") : $CurrentForm->getValue("x_hu_hrg_label_pro");
        if (!$this->hu_hrg_label_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_label_pro->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_label_pro->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_total' first before field var 'x_hu_hrg_total'
        $val = $CurrentForm->hasValue("hu_hrg_total") ? $CurrentForm->getValue("hu_hrg_total") : $CurrentForm->getValue("x_hu_hrg_total");
        if (!$this->hu_hrg_total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_total->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_total->setFormValue($val);
            }
        }

        // Check field name 'hu_hrg_total_pro' first before field var 'x_hu_hrg_total_pro'
        $val = $CurrentForm->hasValue("hu_hrg_total_pro") ? $CurrentForm->getValue("hu_hrg_total_pro") : $CurrentForm->getValue("x_hu_hrg_total_pro");
        if (!$this->hu_hrg_total_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hu_hrg_total_pro->Visible = false; // Disable update for API request
            } else {
                $this->hu_hrg_total_pro->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_isi' first before field var 'x_hl_hrg_isi'
        $val = $CurrentForm->hasValue("hl_hrg_isi") ? $CurrentForm->getValue("hl_hrg_isi") : $CurrentForm->getValue("x_hl_hrg_isi");
        if (!$this->hl_hrg_isi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_isi->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_isi->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_isi_pro' first before field var 'x_hl_hrg_isi_pro'
        $val = $CurrentForm->hasValue("hl_hrg_isi_pro") ? $CurrentForm->getValue("hl_hrg_isi_pro") : $CurrentForm->getValue("x_hl_hrg_isi_pro");
        if (!$this->hl_hrg_isi_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_isi_pro->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_isi_pro->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_kms_primer' first before field var 'x_hl_hrg_kms_primer'
        $val = $CurrentForm->hasValue("hl_hrg_kms_primer") ? $CurrentForm->getValue("hl_hrg_kms_primer") : $CurrentForm->getValue("x_hl_hrg_kms_primer");
        if (!$this->hl_hrg_kms_primer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_kms_primer->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_kms_primer->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_kms_primer_pro' first before field var 'x_hl_hrg_kms_primer_pro'
        $val = $CurrentForm->hasValue("hl_hrg_kms_primer_pro") ? $CurrentForm->getValue("hl_hrg_kms_primer_pro") : $CurrentForm->getValue("x_hl_hrg_kms_primer_pro");
        if (!$this->hl_hrg_kms_primer_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_kms_primer_pro->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_kms_primer_pro->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_kms_sekunder' first before field var 'x_hl_hrg_kms_sekunder'
        $val = $CurrentForm->hasValue("hl_hrg_kms_sekunder") ? $CurrentForm->getValue("hl_hrg_kms_sekunder") : $CurrentForm->getValue("x_hl_hrg_kms_sekunder");
        if (!$this->hl_hrg_kms_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_kms_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_kms_sekunder->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_kms_sekunder_pro' first before field var 'x_hl_hrg_kms_sekunder_pro'
        $val = $CurrentForm->hasValue("hl_hrg_kms_sekunder_pro") ? $CurrentForm->getValue("hl_hrg_kms_sekunder_pro") : $CurrentForm->getValue("x_hl_hrg_kms_sekunder_pro");
        if (!$this->hl_hrg_kms_sekunder_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_kms_sekunder_pro->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_kms_sekunder_pro->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_label' first before field var 'x_hl_hrg_label'
        $val = $CurrentForm->hasValue("hl_hrg_label") ? $CurrentForm->getValue("hl_hrg_label") : $CurrentForm->getValue("x_hl_hrg_label");
        if (!$this->hl_hrg_label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_label->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_label->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_label_pro' first before field var 'x_hl_hrg_label_pro'
        $val = $CurrentForm->hasValue("hl_hrg_label_pro") ? $CurrentForm->getValue("hl_hrg_label_pro") : $CurrentForm->getValue("x_hl_hrg_label_pro");
        if (!$this->hl_hrg_label_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_label_pro->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_label_pro->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_total' first before field var 'x_hl_hrg_total'
        $val = $CurrentForm->hasValue("hl_hrg_total") ? $CurrentForm->getValue("hl_hrg_total") : $CurrentForm->getValue("x_hl_hrg_total");
        if (!$this->hl_hrg_total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_total->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_total->setFormValue($val);
            }
        }

        // Check field name 'hl_hrg_total_pro' first before field var 'x_hl_hrg_total_pro'
        $val = $CurrentForm->hasValue("hl_hrg_total_pro") ? $CurrentForm->getValue("hl_hrg_total_pro") : $CurrentForm->getValue("x_hl_hrg_total_pro");
        if (!$this->hl_hrg_total_pro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hl_hrg_total_pro->Visible = false; // Disable update for API request
            } else {
                $this->hl_hrg_total_pro->setFormValue($val);
            }
        }

        // Check field name 'bs_bahan_aktif_tick' first before field var 'x_bs_bahan_aktif_tick'
        $val = $CurrentForm->hasValue("bs_bahan_aktif_tick") ? $CurrentForm->getValue("bs_bahan_aktif_tick") : $CurrentForm->getValue("x_bs_bahan_aktif_tick");
        if (!$this->bs_bahan_aktif_tick->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_bahan_aktif_tick->Visible = false; // Disable update for API request
            } else {
                $this->bs_bahan_aktif_tick->setFormValue($val);
            }
        }

        // Check field name 'bs_bahan_aktif' first before field var 'x_bs_bahan_aktif'
        $val = $CurrentForm->hasValue("bs_bahan_aktif") ? $CurrentForm->getValue("bs_bahan_aktif") : $CurrentForm->getValue("x_bs_bahan_aktif");
        if (!$this->bs_bahan_aktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_bahan_aktif->Visible = false; // Disable update for API request
            } else {
                $this->bs_bahan_aktif->setFormValue($val);
            }
        }

        // Check field name 'bs_bahan_lain' first before field var 'x_bs_bahan_lain'
        $val = $CurrentForm->hasValue("bs_bahan_lain") ? $CurrentForm->getValue("bs_bahan_lain") : $CurrentForm->getValue("x_bs_bahan_lain");
        if (!$this->bs_bahan_lain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_bahan_lain->Visible = false; // Disable update for API request
            } else {
                $this->bs_bahan_lain->setFormValue($val);
            }
        }

        // Check field name 'bs_parfum' first before field var 'x_bs_parfum'
        $val = $CurrentForm->hasValue("bs_parfum") ? $CurrentForm->getValue("bs_parfum") : $CurrentForm->getValue("x_bs_parfum");
        if (!$this->bs_parfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_parfum->Visible = false; // Disable update for API request
            } else {
                $this->bs_parfum->setFormValue($val);
            }
        }

        // Check field name 'bs_estetika' first before field var 'x_bs_estetika'
        $val = $CurrentForm->hasValue("bs_estetika") ? $CurrentForm->getValue("bs_estetika") : $CurrentForm->getValue("x_bs_estetika");
        if (!$this->bs_estetika->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_estetika->Visible = false; // Disable update for API request
            } else {
                $this->bs_estetika->setFormValue($val);
            }
        }

        // Check field name 'bs_kms_wadah' first before field var 'x_bs_kms_wadah'
        $val = $CurrentForm->hasValue("bs_kms_wadah") ? $CurrentForm->getValue("bs_kms_wadah") : $CurrentForm->getValue("x_bs_kms_wadah");
        if (!$this->bs_kms_wadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_kms_wadah->Visible = false; // Disable update for API request
            } else {
                $this->bs_kms_wadah->setFormValue($val);
            }
        }

        // Check field name 'bs_kms_tutup' first before field var 'x_bs_kms_tutup'
        $val = $CurrentForm->hasValue("bs_kms_tutup") ? $CurrentForm->getValue("bs_kms_tutup") : $CurrentForm->getValue("x_bs_kms_tutup");
        if (!$this->bs_kms_tutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_kms_tutup->Visible = false; // Disable update for API request
            } else {
                $this->bs_kms_tutup->setFormValue($val);
            }
        }

        // Check field name 'bs_kms_sekunder' first before field var 'x_bs_kms_sekunder'
        $val = $CurrentForm->hasValue("bs_kms_sekunder") ? $CurrentForm->getValue("bs_kms_sekunder") : $CurrentForm->getValue("x_bs_kms_sekunder");
        if (!$this->bs_kms_sekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_kms_sekunder->Visible = false; // Disable update for API request
            } else {
                $this->bs_kms_sekunder->setFormValue($val);
            }
        }

        // Check field name 'bs_label_desain' first before field var 'x_bs_label_desain'
        $val = $CurrentForm->hasValue("bs_label_desain") ? $CurrentForm->getValue("bs_label_desain") : $CurrentForm->getValue("x_bs_label_desain");
        if (!$this->bs_label_desain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_label_desain->Visible = false; // Disable update for API request
            } else {
                $this->bs_label_desain->setFormValue($val);
            }
        }

        // Check field name 'bs_label_cetak' first before field var 'x_bs_label_cetak'
        $val = $CurrentForm->hasValue("bs_label_cetak") ? $CurrentForm->getValue("bs_label_cetak") : $CurrentForm->getValue("x_bs_label_cetak");
        if (!$this->bs_label_cetak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_label_cetak->Visible = false; // Disable update for API request
            } else {
                $this->bs_label_cetak->setFormValue($val);
            }
        }

        // Check field name 'bs_label_lain' first before field var 'x_bs_label_lain'
        $val = $CurrentForm->hasValue("bs_label_lain") ? $CurrentForm->getValue("bs_label_lain") : $CurrentForm->getValue("x_bs_label_lain");
        if (!$this->bs_label_lain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bs_label_lain->Visible = false; // Disable update for API request
            } else {
                $this->bs_label_lain->setFormValue($val);
            }
        }

        // Check field name 'dlv_pickup' first before field var 'x_dlv_pickup'
        $val = $CurrentForm->hasValue("dlv_pickup") ? $CurrentForm->getValue("dlv_pickup") : $CurrentForm->getValue("x_dlv_pickup");
        if (!$this->dlv_pickup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dlv_pickup->Visible = false; // Disable update for API request
            } else {
                $this->dlv_pickup->setFormValue($val);
            }
        }

        // Check field name 'dlv_singlepoint' first before field var 'x_dlv_singlepoint'
        $val = $CurrentForm->hasValue("dlv_singlepoint") ? $CurrentForm->getValue("dlv_singlepoint") : $CurrentForm->getValue("x_dlv_singlepoint");
        if (!$this->dlv_singlepoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dlv_singlepoint->Visible = false; // Disable update for API request
            } else {
                $this->dlv_singlepoint->setFormValue($val);
            }
        }

        // Check field name 'dlv_multipoint' first before field var 'x_dlv_multipoint'
        $val = $CurrentForm->hasValue("dlv_multipoint") ? $CurrentForm->getValue("dlv_multipoint") : $CurrentForm->getValue("x_dlv_multipoint");
        if (!$this->dlv_multipoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dlv_multipoint->Visible = false; // Disable update for API request
            } else {
                $this->dlv_multipoint->setFormValue($val);
            }
        }

        // Check field name 'dlv_multipoint_jml' first before field var 'x_dlv_multipoint_jml'
        $val = $CurrentForm->hasValue("dlv_multipoint_jml") ? $CurrentForm->getValue("dlv_multipoint_jml") : $CurrentForm->getValue("x_dlv_multipoint_jml");
        if (!$this->dlv_multipoint_jml->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dlv_multipoint_jml->Visible = false; // Disable update for API request
            } else {
                $this->dlv_multipoint_jml->setFormValue($val);
            }
        }

        // Check field name 'dlv_term_lain' first before field var 'x_dlv_term_lain'
        $val = $CurrentForm->hasValue("dlv_term_lain") ? $CurrentForm->getValue("dlv_term_lain") : $CurrentForm->getValue("x_dlv_term_lain");
        if (!$this->dlv_term_lain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dlv_term_lain->Visible = false; // Disable update for API request
            } else {
                $this->dlv_term_lain->setFormValue($val);
            }
        }

        // Check field name 'catatan_khusus' first before field var 'x_catatan_khusus'
        $val = $CurrentForm->hasValue("catatan_khusus") ? $CurrentForm->getValue("catatan_khusus") : $CurrentForm->getValue("x_catatan_khusus");
        if (!$this->catatan_khusus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatan_khusus->Visible = false; // Disable update for API request
            } else {
                $this->catatan_khusus->setFormValue($val);
            }
        }

        // Check field name 'aju_tgl' first before field var 'x_aju_tgl'
        $val = $CurrentForm->hasValue("aju_tgl") ? $CurrentForm->getValue("aju_tgl") : $CurrentForm->getValue("x_aju_tgl");
        if (!$this->aju_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aju_tgl->Visible = false; // Disable update for API request
            } else {
                $this->aju_tgl->setFormValue($val);
            }
            $this->aju_tgl->CurrentValue = UnFormatDateTime($this->aju_tgl->CurrentValue, 0);
        }

        // Check field name 'aju_oleh' first before field var 'x_aju_oleh'
        $val = $CurrentForm->hasValue("aju_oleh") ? $CurrentForm->getValue("aju_oleh") : $CurrentForm->getValue("x_aju_oleh");
        if (!$this->aju_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aju_oleh->Visible = false; // Disable update for API request
            } else {
                $this->aju_oleh->setFormValue($val);
            }
        }

        // Check field name 'proses_tgl' first before field var 'x_proses_tgl'
        $val = $CurrentForm->hasValue("proses_tgl") ? $CurrentForm->getValue("proses_tgl") : $CurrentForm->getValue("x_proses_tgl");
        if (!$this->proses_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->proses_tgl->Visible = false; // Disable update for API request
            } else {
                $this->proses_tgl->setFormValue($val);
            }
            $this->proses_tgl->CurrentValue = UnFormatDateTime($this->proses_tgl->CurrentValue, 0);
        }

        // Check field name 'proses_oleh' first before field var 'x_proses_oleh'
        $val = $CurrentForm->hasValue("proses_oleh") ? $CurrentForm->getValue("proses_oleh") : $CurrentForm->getValue("x_proses_oleh");
        if (!$this->proses_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->proses_oleh->Visible = false; // Disable update for API request
            } else {
                $this->proses_oleh->setFormValue($val);
            }
        }

        // Check field name 'revisi_tgl' first before field var 'x_revisi_tgl'
        $val = $CurrentForm->hasValue("revisi_tgl") ? $CurrentForm->getValue("revisi_tgl") : $CurrentForm->getValue("x_revisi_tgl");
        if (!$this->revisi_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisi_tgl->Visible = false; // Disable update for API request
            } else {
                $this->revisi_tgl->setFormValue($val);
            }
            $this->revisi_tgl->CurrentValue = UnFormatDateTime($this->revisi_tgl->CurrentValue, 0);
        }

        // Check field name 'revisi_oleh' first before field var 'x_revisi_oleh'
        $val = $CurrentForm->hasValue("revisi_oleh") ? $CurrentForm->getValue("revisi_oleh") : $CurrentForm->getValue("x_revisi_oleh");
        if (!$this->revisi_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisi_oleh->Visible = false; // Disable update for API request
            } else {
                $this->revisi_oleh->setFormValue($val);
            }
        }

        // Check field name 'revisi_akun_tgl' first before field var 'x_revisi_akun_tgl'
        $val = $CurrentForm->hasValue("revisi_akun_tgl") ? $CurrentForm->getValue("revisi_akun_tgl") : $CurrentForm->getValue("x_revisi_akun_tgl");
        if (!$this->revisi_akun_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisi_akun_tgl->Visible = false; // Disable update for API request
            } else {
                $this->revisi_akun_tgl->setFormValue($val);
            }
            $this->revisi_akun_tgl->CurrentValue = UnFormatDateTime($this->revisi_akun_tgl->CurrentValue, 0);
        }

        // Check field name 'revisi_akun_oleh' first before field var 'x_revisi_akun_oleh'
        $val = $CurrentForm->hasValue("revisi_akun_oleh") ? $CurrentForm->getValue("revisi_akun_oleh") : $CurrentForm->getValue("x_revisi_akun_oleh");
        if (!$this->revisi_akun_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisi_akun_oleh->Visible = false; // Disable update for API request
            } else {
                $this->revisi_akun_oleh->setFormValue($val);
            }
        }

        // Check field name 'revisi_rnd_tgl' first before field var 'x_revisi_rnd_tgl'
        $val = $CurrentForm->hasValue("revisi_rnd_tgl") ? $CurrentForm->getValue("revisi_rnd_tgl") : $CurrentForm->getValue("x_revisi_rnd_tgl");
        if (!$this->revisi_rnd_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisi_rnd_tgl->Visible = false; // Disable update for API request
            } else {
                $this->revisi_rnd_tgl->setFormValue($val);
            }
            $this->revisi_rnd_tgl->CurrentValue = UnFormatDateTime($this->revisi_rnd_tgl->CurrentValue, 0);
        }

        // Check field name 'revisi_rnd_oleh' first before field var 'x_revisi_rnd_oleh'
        $val = $CurrentForm->hasValue("revisi_rnd_oleh") ? $CurrentForm->getValue("revisi_rnd_oleh") : $CurrentForm->getValue("x_revisi_rnd_oleh");
        if (!$this->revisi_rnd_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->revisi_rnd_oleh->Visible = false; // Disable update for API request
            } else {
                $this->revisi_rnd_oleh->setFormValue($val);
            }
        }

        // Check field name 'rnd_tgl' first before field var 'x_rnd_tgl'
        $val = $CurrentForm->hasValue("rnd_tgl") ? $CurrentForm->getValue("rnd_tgl") : $CurrentForm->getValue("x_rnd_tgl");
        if (!$this->rnd_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rnd_tgl->Visible = false; // Disable update for API request
            } else {
                $this->rnd_tgl->setFormValue($val);
            }
            $this->rnd_tgl->CurrentValue = UnFormatDateTime($this->rnd_tgl->CurrentValue, 0);
        }

        // Check field name 'rnd_oleh' first before field var 'x_rnd_oleh'
        $val = $CurrentForm->hasValue("rnd_oleh") ? $CurrentForm->getValue("rnd_oleh") : $CurrentForm->getValue("x_rnd_oleh");
        if (!$this->rnd_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rnd_oleh->Visible = false; // Disable update for API request
            } else {
                $this->rnd_oleh->setFormValue($val);
            }
        }

        // Check field name 'ap_tgl' first before field var 'x_ap_tgl'
        $val = $CurrentForm->hasValue("ap_tgl") ? $CurrentForm->getValue("ap_tgl") : $CurrentForm->getValue("x_ap_tgl");
        if (!$this->ap_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ap_tgl->Visible = false; // Disable update for API request
            } else {
                $this->ap_tgl->setFormValue($val);
            }
            $this->ap_tgl->CurrentValue = UnFormatDateTime($this->ap_tgl->CurrentValue, 0);
        }

        // Check field name 'ap_oleh' first before field var 'x_ap_oleh'
        $val = $CurrentForm->hasValue("ap_oleh") ? $CurrentForm->getValue("ap_oleh") : $CurrentForm->getValue("x_ap_oleh");
        if (!$this->ap_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ap_oleh->Visible = false; // Disable update for API request
            } else {
                $this->ap_oleh->setFormValue($val);
            }
        }

        // Check field name 'batal_tgl' first before field var 'x_batal_tgl'
        $val = $CurrentForm->hasValue("batal_tgl") ? $CurrentForm->getValue("batal_tgl") : $CurrentForm->getValue("x_batal_tgl");
        if (!$this->batal_tgl->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->batal_tgl->Visible = false; // Disable update for API request
            } else {
                $this->batal_tgl->setFormValue($val);
            }
            $this->batal_tgl->CurrentValue = UnFormatDateTime($this->batal_tgl->CurrentValue, 0);
        }

        // Check field name 'batal_oleh' first before field var 'x_batal_oleh'
        $val = $CurrentForm->hasValue("batal_oleh") ? $CurrentForm->getValue("batal_oleh") : $CurrentForm->getValue("x_batal_oleh");
        if (!$this->batal_oleh->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->batal_oleh->Visible = false; // Disable update for API request
            } else {
                $this->batal_oleh->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->cpo_jenis->CurrentValue = $this->cpo_jenis->FormValue;
        $this->ordernum->CurrentValue = $this->ordernum->FormValue;
        $this->order_kode->CurrentValue = $this->order_kode->FormValue;
        $this->orderterimatgl->CurrentValue = $this->orderterimatgl->FormValue;
        $this->orderterimatgl->CurrentValue = UnFormatDateTime($this->orderterimatgl->CurrentValue, 0);
        $this->produk_fungsi->CurrentValue = $this->produk_fungsi->FormValue;
        $this->produk_kualitas->CurrentValue = $this->produk_kualitas->FormValue;
        $this->produk_campaign->CurrentValue = $this->produk_campaign->FormValue;
        $this->kemasan_satuan->CurrentValue = $this->kemasan_satuan->FormValue;
        $this->ordertgl->CurrentValue = $this->ordertgl->FormValue;
        $this->ordertgl->CurrentValue = UnFormatDateTime($this->ordertgl->CurrentValue, 0);
        $this->custcode->CurrentValue = $this->custcode->FormValue;
        $this->perushnama->CurrentValue = $this->perushnama->FormValue;
        $this->perushalamat->CurrentValue = $this->perushalamat->FormValue;
        $this->perushcp->CurrentValue = $this->perushcp->FormValue;
        $this->perushjabatan->CurrentValue = $this->perushjabatan->FormValue;
        $this->perushphone->CurrentValue = $this->perushphone->FormValue;
        $this->perushmobile->CurrentValue = $this->perushmobile->FormValue;
        $this->bencmark->CurrentValue = $this->bencmark->FormValue;
        $this->kategoriproduk->CurrentValue = $this->kategoriproduk->FormValue;
        $this->jenisproduk->CurrentValue = $this->jenisproduk->FormValue;
        $this->bentuksediaan->CurrentValue = $this->bentuksediaan->FormValue;
        $this->sediaan_ukuran->CurrentValue = $this->sediaan_ukuran->FormValue;
        $this->sediaan_ukuran_satuan->CurrentValue = $this->sediaan_ukuran_satuan->FormValue;
        $this->produk_viskositas->CurrentValue = $this->produk_viskositas->FormValue;
        $this->konsepproduk->CurrentValue = $this->konsepproduk->FormValue;
        $this->fragrance->CurrentValue = $this->fragrance->FormValue;
        $this->aroma->CurrentValue = $this->aroma->FormValue;
        $this->bahanaktif->CurrentValue = $this->bahanaktif->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->produk_warna_jenis->CurrentValue = $this->produk_warna_jenis->FormValue;
        $this->aksesoris->CurrentValue = $this->aksesoris->FormValue;
        $this->produk_lainlain->CurrentValue = $this->produk_lainlain->FormValue;
        $this->statusproduk->CurrentValue = $this->statusproduk->FormValue;
        $this->parfum->CurrentValue = $this->parfum->FormValue;
        $this->catatan->CurrentValue = $this->catatan->FormValue;
        $this->rencanakemasan->CurrentValue = $this->rencanakemasan->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->ekspetasiharga->CurrentValue = $this->ekspetasiharga->FormValue;
        $this->kemasan->CurrentValue = $this->kemasan->FormValue;
        $this->volume->CurrentValue = $this->volume->FormValue;
        $this->jenistutup->CurrentValue = $this->jenistutup->FormValue;
        $this->catatanpackaging->CurrentValue = $this->catatanpackaging->FormValue;
        $this->infopackaging->CurrentValue = $this->infopackaging->FormValue;
        $this->ukuran->CurrentValue = $this->ukuran->FormValue;
        $this->desainprodukkemasan->CurrentValue = $this->desainprodukkemasan->FormValue;
        $this->desaindiinginkan->CurrentValue = $this->desaindiinginkan->FormValue;
        $this->mereknotifikasi->CurrentValue = $this->mereknotifikasi->FormValue;
        $this->kategoristatus->CurrentValue = $this->kategoristatus->FormValue;
        $this->kemasan_ukuran_satuan->CurrentValue = $this->kemasan_ukuran_satuan->FormValue;
        $this->notifikasicatatan->CurrentValue = $this->notifikasicatatan->FormValue;
        $this->label_ukuran->CurrentValue = $this->label_ukuran->FormValue;
        $this->infolabel->CurrentValue = $this->infolabel->FormValue;
        $this->labelkualitas->CurrentValue = $this->labelkualitas->FormValue;
        $this->labelposisi->CurrentValue = $this->labelposisi->FormValue;
        $this->labelcatatan->CurrentValue = $this->labelcatatan->FormValue;
        $this->dibuatdi->CurrentValue = $this->dibuatdi->FormValue;
        $this->tanggal->CurrentValue = $this->tanggal->FormValue;
        $this->tanggal->CurrentValue = UnFormatDateTime($this->tanggal->CurrentValue, 0);
        $this->penerima->CurrentValue = $this->penerima->FormValue;
        $this->createat->CurrentValue = $this->createat->FormValue;
        $this->createat->CurrentValue = UnFormatDateTime($this->createat->CurrentValue, 0);
        $this->createby->CurrentValue = $this->createby->FormValue;
        $this->statusdokumen->CurrentValue = $this->statusdokumen->FormValue;
        $this->update_at->CurrentValue = $this->update_at->FormValue;
        $this->update_at->CurrentValue = UnFormatDateTime($this->update_at->CurrentValue, 0);
        $this->status_data->CurrentValue = $this->status_data->FormValue;
        $this->harga_rnd->CurrentValue = $this->harga_rnd->FormValue;
        $this->aplikasi_sediaan->CurrentValue = $this->aplikasi_sediaan->FormValue;
        $this->hu_hrg_isi->CurrentValue = $this->hu_hrg_isi->FormValue;
        $this->hu_hrg_isi_pro->CurrentValue = $this->hu_hrg_isi_pro->FormValue;
        $this->hu_hrg_kms_primer->CurrentValue = $this->hu_hrg_kms_primer->FormValue;
        $this->hu_hrg_kms_primer_pro->CurrentValue = $this->hu_hrg_kms_primer_pro->FormValue;
        $this->hu_hrg_kms_sekunder->CurrentValue = $this->hu_hrg_kms_sekunder->FormValue;
        $this->hu_hrg_kms_sekunder_pro->CurrentValue = $this->hu_hrg_kms_sekunder_pro->FormValue;
        $this->hu_hrg_label->CurrentValue = $this->hu_hrg_label->FormValue;
        $this->hu_hrg_label_pro->CurrentValue = $this->hu_hrg_label_pro->FormValue;
        $this->hu_hrg_total->CurrentValue = $this->hu_hrg_total->FormValue;
        $this->hu_hrg_total_pro->CurrentValue = $this->hu_hrg_total_pro->FormValue;
        $this->hl_hrg_isi->CurrentValue = $this->hl_hrg_isi->FormValue;
        $this->hl_hrg_isi_pro->CurrentValue = $this->hl_hrg_isi_pro->FormValue;
        $this->hl_hrg_kms_primer->CurrentValue = $this->hl_hrg_kms_primer->FormValue;
        $this->hl_hrg_kms_primer_pro->CurrentValue = $this->hl_hrg_kms_primer_pro->FormValue;
        $this->hl_hrg_kms_sekunder->CurrentValue = $this->hl_hrg_kms_sekunder->FormValue;
        $this->hl_hrg_kms_sekunder_pro->CurrentValue = $this->hl_hrg_kms_sekunder_pro->FormValue;
        $this->hl_hrg_label->CurrentValue = $this->hl_hrg_label->FormValue;
        $this->hl_hrg_label_pro->CurrentValue = $this->hl_hrg_label_pro->FormValue;
        $this->hl_hrg_total->CurrentValue = $this->hl_hrg_total->FormValue;
        $this->hl_hrg_total_pro->CurrentValue = $this->hl_hrg_total_pro->FormValue;
        $this->bs_bahan_aktif_tick->CurrentValue = $this->bs_bahan_aktif_tick->FormValue;
        $this->bs_bahan_aktif->CurrentValue = $this->bs_bahan_aktif->FormValue;
        $this->bs_bahan_lain->CurrentValue = $this->bs_bahan_lain->FormValue;
        $this->bs_parfum->CurrentValue = $this->bs_parfum->FormValue;
        $this->bs_estetika->CurrentValue = $this->bs_estetika->FormValue;
        $this->bs_kms_wadah->CurrentValue = $this->bs_kms_wadah->FormValue;
        $this->bs_kms_tutup->CurrentValue = $this->bs_kms_tutup->FormValue;
        $this->bs_kms_sekunder->CurrentValue = $this->bs_kms_sekunder->FormValue;
        $this->bs_label_desain->CurrentValue = $this->bs_label_desain->FormValue;
        $this->bs_label_cetak->CurrentValue = $this->bs_label_cetak->FormValue;
        $this->bs_label_lain->CurrentValue = $this->bs_label_lain->FormValue;
        $this->dlv_pickup->CurrentValue = $this->dlv_pickup->FormValue;
        $this->dlv_singlepoint->CurrentValue = $this->dlv_singlepoint->FormValue;
        $this->dlv_multipoint->CurrentValue = $this->dlv_multipoint->FormValue;
        $this->dlv_multipoint_jml->CurrentValue = $this->dlv_multipoint_jml->FormValue;
        $this->dlv_term_lain->CurrentValue = $this->dlv_term_lain->FormValue;
        $this->catatan_khusus->CurrentValue = $this->catatan_khusus->FormValue;
        $this->aju_tgl->CurrentValue = $this->aju_tgl->FormValue;
        $this->aju_tgl->CurrentValue = UnFormatDateTime($this->aju_tgl->CurrentValue, 0);
        $this->aju_oleh->CurrentValue = $this->aju_oleh->FormValue;
        $this->proses_tgl->CurrentValue = $this->proses_tgl->FormValue;
        $this->proses_tgl->CurrentValue = UnFormatDateTime($this->proses_tgl->CurrentValue, 0);
        $this->proses_oleh->CurrentValue = $this->proses_oleh->FormValue;
        $this->revisi_tgl->CurrentValue = $this->revisi_tgl->FormValue;
        $this->revisi_tgl->CurrentValue = UnFormatDateTime($this->revisi_tgl->CurrentValue, 0);
        $this->revisi_oleh->CurrentValue = $this->revisi_oleh->FormValue;
        $this->revisi_akun_tgl->CurrentValue = $this->revisi_akun_tgl->FormValue;
        $this->revisi_akun_tgl->CurrentValue = UnFormatDateTime($this->revisi_akun_tgl->CurrentValue, 0);
        $this->revisi_akun_oleh->CurrentValue = $this->revisi_akun_oleh->FormValue;
        $this->revisi_rnd_tgl->CurrentValue = $this->revisi_rnd_tgl->FormValue;
        $this->revisi_rnd_tgl->CurrentValue = UnFormatDateTime($this->revisi_rnd_tgl->CurrentValue, 0);
        $this->revisi_rnd_oleh->CurrentValue = $this->revisi_rnd_oleh->FormValue;
        $this->rnd_tgl->CurrentValue = $this->rnd_tgl->FormValue;
        $this->rnd_tgl->CurrentValue = UnFormatDateTime($this->rnd_tgl->CurrentValue, 0);
        $this->rnd_oleh->CurrentValue = $this->rnd_oleh->FormValue;
        $this->ap_tgl->CurrentValue = $this->ap_tgl->FormValue;
        $this->ap_tgl->CurrentValue = UnFormatDateTime($this->ap_tgl->CurrentValue, 0);
        $this->ap_oleh->CurrentValue = $this->ap_oleh->FormValue;
        $this->batal_tgl->CurrentValue = $this->batal_tgl->FormValue;
        $this->batal_tgl->CurrentValue = UnFormatDateTime($this->batal_tgl->CurrentValue, 0);
        $this->batal_oleh->CurrentValue = $this->batal_oleh->FormValue;
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
        $this->cpo_jenis->setDbValue($row['cpo_jenis']);
        $this->ordernum->setDbValue($row['ordernum']);
        $this->order_kode->setDbValue($row['order_kode']);
        $this->orderterimatgl->setDbValue($row['orderterimatgl']);
        $this->produk_fungsi->setDbValue($row['produk_fungsi']);
        $this->produk_kualitas->setDbValue($row['produk_kualitas']);
        $this->produk_campaign->setDbValue($row['produk_campaign']);
        $this->kemasan_satuan->setDbValue($row['kemasan_satuan']);
        $this->ordertgl->setDbValue($row['ordertgl']);
        $this->custcode->setDbValue($row['custcode']);
        $this->perushnama->setDbValue($row['perushnama']);
        $this->perushalamat->setDbValue($row['perushalamat']);
        $this->perushcp->setDbValue($row['perushcp']);
        $this->perushjabatan->setDbValue($row['perushjabatan']);
        $this->perushphone->setDbValue($row['perushphone']);
        $this->perushmobile->setDbValue($row['perushmobile']);
        $this->bencmark->setDbValue($row['bencmark']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->bentuksediaan->setDbValue($row['bentuksediaan']);
        $this->sediaan_ukuran->setDbValue($row['sediaan_ukuran']);
        $this->sediaan_ukuran_satuan->setDbValue($row['sediaan_ukuran_satuan']);
        $this->produk_viskositas->setDbValue($row['produk_viskositas']);
        $this->konsepproduk->setDbValue($row['konsepproduk']);
        $this->fragrance->setDbValue($row['fragrance']);
        $this->aroma->setDbValue($row['aroma']);
        $this->bahanaktif->setDbValue($row['bahanaktif']);
        $this->warna->setDbValue($row['warna']);
        $this->produk_warna_jenis->setDbValue($row['produk_warna_jenis']);
        $this->aksesoris->setDbValue($row['aksesoris']);
        $this->produk_lainlain->setDbValue($row['produk_lainlain']);
        $this->statusproduk->setDbValue($row['statusproduk']);
        $this->parfum->setDbValue($row['parfum']);
        $this->catatan->setDbValue($row['catatan']);
        $this->rencanakemasan->setDbValue($row['rencanakemasan']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->ekspetasiharga->setDbValue($row['ekspetasiharga']);
        $this->kemasan->setDbValue($row['kemasan']);
        $this->volume->setDbValue($row['volume']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->catatanpackaging->setDbValue($row['catatanpackaging']);
        $this->infopackaging->setDbValue($row['infopackaging']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->desainprodukkemasan->setDbValue($row['desainprodukkemasan']);
        $this->desaindiinginkan->setDbValue($row['desaindiinginkan']);
        $this->mereknotifikasi->setDbValue($row['mereknotifikasi']);
        $this->kategoristatus->setDbValue($row['kategoristatus']);
        $this->kemasan_ukuran_satuan->setDbValue($row['kemasan_ukuran_satuan']);
        $this->notifikasicatatan->setDbValue($row['notifikasicatatan']);
        $this->label_ukuran->setDbValue($row['label_ukuran']);
        $this->infolabel->setDbValue($row['infolabel']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->tanggal->setDbValue($row['tanggal']);
        $this->penerima->setDbValue($row['penerima']);
        $this->createat->setDbValue($row['createat']);
        $this->createby->setDbValue($row['createby']);
        $this->statusdokumen->setDbValue($row['statusdokumen']);
        $this->update_at->setDbValue($row['update_at']);
        $this->status_data->setDbValue($row['status_data']);
        $this->harga_rnd->setDbValue($row['harga_rnd']);
        $this->aplikasi_sediaan->setDbValue($row['aplikasi_sediaan']);
        $this->hu_hrg_isi->setDbValue($row['hu_hrg_isi']);
        $this->hu_hrg_isi_pro->setDbValue($row['hu_hrg_isi_pro']);
        $this->hu_hrg_kms_primer->setDbValue($row['hu_hrg_kms_primer']);
        $this->hu_hrg_kms_primer_pro->setDbValue($row['hu_hrg_kms_primer_pro']);
        $this->hu_hrg_kms_sekunder->setDbValue($row['hu_hrg_kms_sekunder']);
        $this->hu_hrg_kms_sekunder_pro->setDbValue($row['hu_hrg_kms_sekunder_pro']);
        $this->hu_hrg_label->setDbValue($row['hu_hrg_label']);
        $this->hu_hrg_label_pro->setDbValue($row['hu_hrg_label_pro']);
        $this->hu_hrg_total->setDbValue($row['hu_hrg_total']);
        $this->hu_hrg_total_pro->setDbValue($row['hu_hrg_total_pro']);
        $this->hl_hrg_isi->setDbValue($row['hl_hrg_isi']);
        $this->hl_hrg_isi_pro->setDbValue($row['hl_hrg_isi_pro']);
        $this->hl_hrg_kms_primer->setDbValue($row['hl_hrg_kms_primer']);
        $this->hl_hrg_kms_primer_pro->setDbValue($row['hl_hrg_kms_primer_pro']);
        $this->hl_hrg_kms_sekunder->setDbValue($row['hl_hrg_kms_sekunder']);
        $this->hl_hrg_kms_sekunder_pro->setDbValue($row['hl_hrg_kms_sekunder_pro']);
        $this->hl_hrg_label->setDbValue($row['hl_hrg_label']);
        $this->hl_hrg_label_pro->setDbValue($row['hl_hrg_label_pro']);
        $this->hl_hrg_total->setDbValue($row['hl_hrg_total']);
        $this->hl_hrg_total_pro->setDbValue($row['hl_hrg_total_pro']);
        $this->bs_bahan_aktif_tick->setDbValue($row['bs_bahan_aktif_tick']);
        $this->bs_bahan_aktif->setDbValue($row['bs_bahan_aktif']);
        $this->bs_bahan_lain->setDbValue($row['bs_bahan_lain']);
        $this->bs_parfum->setDbValue($row['bs_parfum']);
        $this->bs_estetika->setDbValue($row['bs_estetika']);
        $this->bs_kms_wadah->setDbValue($row['bs_kms_wadah']);
        $this->bs_kms_tutup->setDbValue($row['bs_kms_tutup']);
        $this->bs_kms_sekunder->setDbValue($row['bs_kms_sekunder']);
        $this->bs_label_desain->setDbValue($row['bs_label_desain']);
        $this->bs_label_cetak->setDbValue($row['bs_label_cetak']);
        $this->bs_label_lain->setDbValue($row['bs_label_lain']);
        $this->dlv_pickup->setDbValue($row['dlv_pickup']);
        $this->dlv_singlepoint->setDbValue($row['dlv_singlepoint']);
        $this->dlv_multipoint->setDbValue($row['dlv_multipoint']);
        $this->dlv_multipoint_jml->setDbValue($row['dlv_multipoint_jml']);
        $this->dlv_term_lain->setDbValue($row['dlv_term_lain']);
        $this->catatan_khusus->setDbValue($row['catatan_khusus']);
        $this->aju_tgl->setDbValue($row['aju_tgl']);
        $this->aju_oleh->setDbValue($row['aju_oleh']);
        $this->proses_tgl->setDbValue($row['proses_tgl']);
        $this->proses_oleh->setDbValue($row['proses_oleh']);
        $this->revisi_tgl->setDbValue($row['revisi_tgl']);
        $this->revisi_oleh->setDbValue($row['revisi_oleh']);
        $this->revisi_akun_tgl->setDbValue($row['revisi_akun_tgl']);
        $this->revisi_akun_oleh->setDbValue($row['revisi_akun_oleh']);
        $this->revisi_rnd_tgl->setDbValue($row['revisi_rnd_tgl']);
        $this->revisi_rnd_oleh->setDbValue($row['revisi_rnd_oleh']);
        $this->rnd_tgl->setDbValue($row['rnd_tgl']);
        $this->rnd_oleh->setDbValue($row['rnd_oleh']);
        $this->ap_tgl->setDbValue($row['ap_tgl']);
        $this->ap_oleh->setDbValue($row['ap_oleh']);
        $this->batal_tgl->setDbValue($row['batal_tgl']);
        $this->batal_oleh->setDbValue($row['batal_oleh']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['cpo_jenis'] = null;
        $row['ordernum'] = null;
        $row['order_kode'] = null;
        $row['orderterimatgl'] = null;
        $row['produk_fungsi'] = null;
        $row['produk_kualitas'] = null;
        $row['produk_campaign'] = null;
        $row['kemasan_satuan'] = null;
        $row['ordertgl'] = null;
        $row['custcode'] = null;
        $row['perushnama'] = null;
        $row['perushalamat'] = null;
        $row['perushcp'] = null;
        $row['perushjabatan'] = null;
        $row['perushphone'] = null;
        $row['perushmobile'] = null;
        $row['bencmark'] = null;
        $row['kategoriproduk'] = null;
        $row['jenisproduk'] = null;
        $row['bentuksediaan'] = null;
        $row['sediaan_ukuran'] = null;
        $row['sediaan_ukuran_satuan'] = null;
        $row['produk_viskositas'] = null;
        $row['konsepproduk'] = null;
        $row['fragrance'] = null;
        $row['aroma'] = null;
        $row['bahanaktif'] = null;
        $row['warna'] = null;
        $row['produk_warna_jenis'] = null;
        $row['aksesoris'] = null;
        $row['produk_lainlain'] = null;
        $row['statusproduk'] = null;
        $row['parfum'] = null;
        $row['catatan'] = null;
        $row['rencanakemasan'] = null;
        $row['keterangan'] = null;
        $row['ekspetasiharga'] = null;
        $row['kemasan'] = null;
        $row['volume'] = null;
        $row['jenistutup'] = null;
        $row['catatanpackaging'] = null;
        $row['infopackaging'] = null;
        $row['ukuran'] = null;
        $row['desainprodukkemasan'] = null;
        $row['desaindiinginkan'] = null;
        $row['mereknotifikasi'] = null;
        $row['kategoristatus'] = null;
        $row['kemasan_ukuran_satuan'] = null;
        $row['notifikasicatatan'] = null;
        $row['label_ukuran'] = null;
        $row['infolabel'] = null;
        $row['labelkualitas'] = null;
        $row['labelposisi'] = null;
        $row['labelcatatan'] = null;
        $row['dibuatdi'] = null;
        $row['tanggal'] = null;
        $row['penerima'] = null;
        $row['createat'] = null;
        $row['createby'] = null;
        $row['statusdokumen'] = null;
        $row['update_at'] = null;
        $row['status_data'] = null;
        $row['harga_rnd'] = null;
        $row['aplikasi_sediaan'] = null;
        $row['hu_hrg_isi'] = null;
        $row['hu_hrg_isi_pro'] = null;
        $row['hu_hrg_kms_primer'] = null;
        $row['hu_hrg_kms_primer_pro'] = null;
        $row['hu_hrg_kms_sekunder'] = null;
        $row['hu_hrg_kms_sekunder_pro'] = null;
        $row['hu_hrg_label'] = null;
        $row['hu_hrg_label_pro'] = null;
        $row['hu_hrg_total'] = null;
        $row['hu_hrg_total_pro'] = null;
        $row['hl_hrg_isi'] = null;
        $row['hl_hrg_isi_pro'] = null;
        $row['hl_hrg_kms_primer'] = null;
        $row['hl_hrg_kms_primer_pro'] = null;
        $row['hl_hrg_kms_sekunder'] = null;
        $row['hl_hrg_kms_sekunder_pro'] = null;
        $row['hl_hrg_label'] = null;
        $row['hl_hrg_label_pro'] = null;
        $row['hl_hrg_total'] = null;
        $row['hl_hrg_total_pro'] = null;
        $row['bs_bahan_aktif_tick'] = null;
        $row['bs_bahan_aktif'] = null;
        $row['bs_bahan_lain'] = null;
        $row['bs_parfum'] = null;
        $row['bs_estetika'] = null;
        $row['bs_kms_wadah'] = null;
        $row['bs_kms_tutup'] = null;
        $row['bs_kms_sekunder'] = null;
        $row['bs_label_desain'] = null;
        $row['bs_label_cetak'] = null;
        $row['bs_label_lain'] = null;
        $row['dlv_pickup'] = null;
        $row['dlv_singlepoint'] = null;
        $row['dlv_multipoint'] = null;
        $row['dlv_multipoint_jml'] = null;
        $row['dlv_term_lain'] = null;
        $row['catatan_khusus'] = null;
        $row['aju_tgl'] = null;
        $row['aju_oleh'] = null;
        $row['proses_tgl'] = null;
        $row['proses_oleh'] = null;
        $row['revisi_tgl'] = null;
        $row['revisi_oleh'] = null;
        $row['revisi_akun_tgl'] = null;
        $row['revisi_akun_oleh'] = null;
        $row['revisi_rnd_tgl'] = null;
        $row['revisi_rnd_oleh'] = null;
        $row['rnd_tgl'] = null;
        $row['rnd_oleh'] = null;
        $row['ap_tgl'] = null;
        $row['ap_oleh'] = null;
        $row['batal_tgl'] = null;
        $row['batal_oleh'] = null;
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

        // Convert decimal values if posted back
        if ($this->sediaan_ukuran->FormValue == $this->sediaan_ukuran->CurrentValue && is_numeric(ConvertToFloatString($this->sediaan_ukuran->CurrentValue))) {
            $this->sediaan_ukuran->CurrentValue = ConvertToFloatString($this->sediaan_ukuran->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->ekspetasiharga->FormValue == $this->ekspetasiharga->CurrentValue && is_numeric(ConvertToFloatString($this->ekspetasiharga->CurrentValue))) {
            $this->ekspetasiharga->CurrentValue = ConvertToFloatString($this->ekspetasiharga->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->volume->FormValue == $this->volume->CurrentValue && is_numeric(ConvertToFloatString($this->volume->CurrentValue))) {
            $this->volume->CurrentValue = ConvertToFloatString($this->volume->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->harga_rnd->FormValue == $this->harga_rnd->CurrentValue && is_numeric(ConvertToFloatString($this->harga_rnd->CurrentValue))) {
            $this->harga_rnd->CurrentValue = ConvertToFloatString($this->harga_rnd->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_isi->FormValue == $this->hu_hrg_isi->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_isi->CurrentValue))) {
            $this->hu_hrg_isi->CurrentValue = ConvertToFloatString($this->hu_hrg_isi->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_isi_pro->FormValue == $this->hu_hrg_isi_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_isi_pro->CurrentValue))) {
            $this->hu_hrg_isi_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_isi_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_primer->FormValue == $this->hu_hrg_kms_primer->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_primer->CurrentValue))) {
            $this->hu_hrg_kms_primer->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_primer->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_primer_pro->FormValue == $this->hu_hrg_kms_primer_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_primer_pro->CurrentValue))) {
            $this->hu_hrg_kms_primer_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_primer_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_sekunder->FormValue == $this->hu_hrg_kms_sekunder->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_sekunder->CurrentValue))) {
            $this->hu_hrg_kms_sekunder->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_sekunder->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_kms_sekunder_pro->FormValue == $this->hu_hrg_kms_sekunder_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_kms_sekunder_pro->CurrentValue))) {
            $this->hu_hrg_kms_sekunder_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_kms_sekunder_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_label->FormValue == $this->hu_hrg_label->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_label->CurrentValue))) {
            $this->hu_hrg_label->CurrentValue = ConvertToFloatString($this->hu_hrg_label->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_label_pro->FormValue == $this->hu_hrg_label_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_label_pro->CurrentValue))) {
            $this->hu_hrg_label_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_label_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_total->FormValue == $this->hu_hrg_total->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_total->CurrentValue))) {
            $this->hu_hrg_total->CurrentValue = ConvertToFloatString($this->hu_hrg_total->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hu_hrg_total_pro->FormValue == $this->hu_hrg_total_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hu_hrg_total_pro->CurrentValue))) {
            $this->hu_hrg_total_pro->CurrentValue = ConvertToFloatString($this->hu_hrg_total_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_isi->FormValue == $this->hl_hrg_isi->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_isi->CurrentValue))) {
            $this->hl_hrg_isi->CurrentValue = ConvertToFloatString($this->hl_hrg_isi->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_isi_pro->FormValue == $this->hl_hrg_isi_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_isi_pro->CurrentValue))) {
            $this->hl_hrg_isi_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_isi_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_primer->FormValue == $this->hl_hrg_kms_primer->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_primer->CurrentValue))) {
            $this->hl_hrg_kms_primer->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_primer->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_primer_pro->FormValue == $this->hl_hrg_kms_primer_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_primer_pro->CurrentValue))) {
            $this->hl_hrg_kms_primer_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_primer_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_sekunder->FormValue == $this->hl_hrg_kms_sekunder->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_sekunder->CurrentValue))) {
            $this->hl_hrg_kms_sekunder->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_sekunder->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_kms_sekunder_pro->FormValue == $this->hl_hrg_kms_sekunder_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_kms_sekunder_pro->CurrentValue))) {
            $this->hl_hrg_kms_sekunder_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_kms_sekunder_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_label->FormValue == $this->hl_hrg_label->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_label->CurrentValue))) {
            $this->hl_hrg_label->CurrentValue = ConvertToFloatString($this->hl_hrg_label->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_label_pro->FormValue == $this->hl_hrg_label_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_label_pro->CurrentValue))) {
            $this->hl_hrg_label_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_label_pro->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_total->FormValue == $this->hl_hrg_total->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_total->CurrentValue))) {
            $this->hl_hrg_total->CurrentValue = ConvertToFloatString($this->hl_hrg_total->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->hl_hrg_total_pro->FormValue == $this->hl_hrg_total_pro->CurrentValue && is_numeric(ConvertToFloatString($this->hl_hrg_total_pro->CurrentValue))) {
            $this->hl_hrg_total_pro->CurrentValue = ConvertToFloatString($this->hl_hrg_total_pro->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // cpo_jenis

        // ordernum

        // order_kode

        // orderterimatgl

        // produk_fungsi

        // produk_kualitas

        // produk_campaign

        // kemasan_satuan

        // ordertgl

        // custcode

        // perushnama

        // perushalamat

        // perushcp

        // perushjabatan

        // perushphone

        // perushmobile

        // bencmark

        // kategoriproduk

        // jenisproduk

        // bentuksediaan

        // sediaan_ukuran

        // sediaan_ukuran_satuan

        // produk_viskositas

        // konsepproduk

        // fragrance

        // aroma

        // bahanaktif

        // warna

        // produk_warna_jenis

        // aksesoris

        // produk_lainlain

        // statusproduk

        // parfum

        // catatan

        // rencanakemasan

        // keterangan

        // ekspetasiharga

        // kemasan

        // volume

        // jenistutup

        // catatanpackaging

        // infopackaging

        // ukuran

        // desainprodukkemasan

        // desaindiinginkan

        // mereknotifikasi

        // kategoristatus

        // kemasan_ukuran_satuan

        // notifikasicatatan

        // label_ukuran

        // infolabel

        // labelkualitas

        // labelposisi

        // labelcatatan

        // dibuatdi

        // tanggal

        // penerima

        // createat

        // createby

        // statusdokumen

        // update_at

        // status_data

        // harga_rnd

        // aplikasi_sediaan

        // hu_hrg_isi

        // hu_hrg_isi_pro

        // hu_hrg_kms_primer

        // hu_hrg_kms_primer_pro

        // hu_hrg_kms_sekunder

        // hu_hrg_kms_sekunder_pro

        // hu_hrg_label

        // hu_hrg_label_pro

        // hu_hrg_total

        // hu_hrg_total_pro

        // hl_hrg_isi

        // hl_hrg_isi_pro

        // hl_hrg_kms_primer

        // hl_hrg_kms_primer_pro

        // hl_hrg_kms_sekunder

        // hl_hrg_kms_sekunder_pro

        // hl_hrg_label

        // hl_hrg_label_pro

        // hl_hrg_total

        // hl_hrg_total_pro

        // bs_bahan_aktif_tick

        // bs_bahan_aktif

        // bs_bahan_lain

        // bs_parfum

        // bs_estetika

        // bs_kms_wadah

        // bs_kms_tutup

        // bs_kms_sekunder

        // bs_label_desain

        // bs_label_cetak

        // bs_label_lain

        // dlv_pickup

        // dlv_singlepoint

        // dlv_multipoint

        // dlv_multipoint_jml

        // dlv_term_lain

        // catatan_khusus

        // aju_tgl

        // aju_oleh

        // proses_tgl

        // proses_oleh

        // revisi_tgl

        // revisi_oleh

        // revisi_akun_tgl

        // revisi_akun_oleh

        // revisi_rnd_tgl

        // revisi_rnd_oleh

        // rnd_tgl

        // rnd_oleh

        // ap_tgl

        // ap_oleh

        // batal_tgl

        // batal_oleh
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
            $this->id->ViewCustomAttributes = "";

            // cpo_jenis
            $this->cpo_jenis->ViewValue = $this->cpo_jenis->CurrentValue;
            $this->cpo_jenis->ViewCustomAttributes = "";

            // ordernum
            $this->ordernum->ViewValue = $this->ordernum->CurrentValue;
            $this->ordernum->ViewCustomAttributes = "";

            // order_kode
            $this->order_kode->ViewValue = $this->order_kode->CurrentValue;
            $this->order_kode->ViewCustomAttributes = "";

            // orderterimatgl
            $this->orderterimatgl->ViewValue = $this->orderterimatgl->CurrentValue;
            $this->orderterimatgl->ViewValue = FormatDateTime($this->orderterimatgl->ViewValue, 0);
            $this->orderterimatgl->ViewCustomAttributes = "";

            // produk_fungsi
            $this->produk_fungsi->ViewValue = $this->produk_fungsi->CurrentValue;
            $this->produk_fungsi->ViewCustomAttributes = "";

            // produk_kualitas
            $this->produk_kualitas->ViewValue = $this->produk_kualitas->CurrentValue;
            $this->produk_kualitas->ViewCustomAttributes = "";

            // produk_campaign
            $this->produk_campaign->ViewValue = $this->produk_campaign->CurrentValue;
            $this->produk_campaign->ViewCustomAttributes = "";

            // kemasan_satuan
            $this->kemasan_satuan->ViewValue = $this->kemasan_satuan->CurrentValue;
            $this->kemasan_satuan->ViewCustomAttributes = "";

            // ordertgl
            $this->ordertgl->ViewValue = $this->ordertgl->CurrentValue;
            $this->ordertgl->ViewValue = FormatDateTime($this->ordertgl->ViewValue, 0);
            $this->ordertgl->ViewCustomAttributes = "";

            // custcode
            $this->custcode->ViewValue = $this->custcode->CurrentValue;
            $this->custcode->ViewValue = FormatNumber($this->custcode->ViewValue, 0, -2, -2, -2);
            $this->custcode->ViewCustomAttributes = "";

            // perushnama
            $this->perushnama->ViewValue = $this->perushnama->CurrentValue;
            $this->perushnama->ViewCustomAttributes = "";

            // perushalamat
            $this->perushalamat->ViewValue = $this->perushalamat->CurrentValue;
            $this->perushalamat->ViewCustomAttributes = "";

            // perushcp
            $this->perushcp->ViewValue = $this->perushcp->CurrentValue;
            $this->perushcp->ViewCustomAttributes = "";

            // perushjabatan
            $this->perushjabatan->ViewValue = $this->perushjabatan->CurrentValue;
            $this->perushjabatan->ViewCustomAttributes = "";

            // perushphone
            $this->perushphone->ViewValue = $this->perushphone->CurrentValue;
            $this->perushphone->ViewCustomAttributes = "";

            // perushmobile
            $this->perushmobile->ViewValue = $this->perushmobile->CurrentValue;
            $this->perushmobile->ViewCustomAttributes = "";

            // bencmark
            $this->bencmark->ViewValue = $this->bencmark->CurrentValue;
            $this->bencmark->ViewCustomAttributes = "";

            // kategoriproduk
            $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
            $this->kategoriproduk->ViewCustomAttributes = "";

            // jenisproduk
            $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
            $this->jenisproduk->ViewCustomAttributes = "";

            // bentuksediaan
            $this->bentuksediaan->ViewValue = $this->bentuksediaan->CurrentValue;
            $this->bentuksediaan->ViewCustomAttributes = "";

            // sediaan_ukuran
            $this->sediaan_ukuran->ViewValue = $this->sediaan_ukuran->CurrentValue;
            $this->sediaan_ukuran->ViewValue = FormatNumber($this->sediaan_ukuran->ViewValue, 2, -2, -2, -2);
            $this->sediaan_ukuran->ViewCustomAttributes = "";

            // sediaan_ukuran_satuan
            $this->sediaan_ukuran_satuan->ViewValue = $this->sediaan_ukuran_satuan->CurrentValue;
            $this->sediaan_ukuran_satuan->ViewCustomAttributes = "";

            // produk_viskositas
            $this->produk_viskositas->ViewValue = $this->produk_viskositas->CurrentValue;
            $this->produk_viskositas->ViewCustomAttributes = "";

            // konsepproduk
            $this->konsepproduk->ViewValue = $this->konsepproduk->CurrentValue;
            $this->konsepproduk->ViewCustomAttributes = "";

            // fragrance
            $this->fragrance->ViewValue = $this->fragrance->CurrentValue;
            $this->fragrance->ViewCustomAttributes = "";

            // aroma
            $this->aroma->ViewValue = $this->aroma->CurrentValue;
            $this->aroma->ViewCustomAttributes = "";

            // bahanaktif
            $this->bahanaktif->ViewValue = $this->bahanaktif->CurrentValue;
            $this->bahanaktif->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // produk_warna_jenis
            $this->produk_warna_jenis->ViewValue = $this->produk_warna_jenis->CurrentValue;
            $this->produk_warna_jenis->ViewCustomAttributes = "";

            // aksesoris
            $this->aksesoris->ViewValue = $this->aksesoris->CurrentValue;
            $this->aksesoris->ViewCustomAttributes = "";

            // produk_lainlain
            $this->produk_lainlain->ViewValue = $this->produk_lainlain->CurrentValue;
            $this->produk_lainlain->ViewCustomAttributes = "";

            // statusproduk
            $this->statusproduk->ViewValue = $this->statusproduk->CurrentValue;
            $this->statusproduk->ViewCustomAttributes = "";

            // parfum
            $this->parfum->ViewValue = $this->parfum->CurrentValue;
            $this->parfum->ViewCustomAttributes = "";

            // catatan
            $this->catatan->ViewValue = $this->catatan->CurrentValue;
            $this->catatan->ViewCustomAttributes = "";

            // rencanakemasan
            $this->rencanakemasan->ViewValue = $this->rencanakemasan->CurrentValue;
            $this->rencanakemasan->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // ekspetasiharga
            $this->ekspetasiharga->ViewValue = $this->ekspetasiharga->CurrentValue;
            $this->ekspetasiharga->ViewValue = FormatNumber($this->ekspetasiharga->ViewValue, 2, -2, -2, -2);
            $this->ekspetasiharga->ViewCustomAttributes = "";

            // kemasan
            $this->kemasan->ViewValue = $this->kemasan->CurrentValue;
            $this->kemasan->ViewCustomAttributes = "";

            // volume
            $this->volume->ViewValue = $this->volume->CurrentValue;
            $this->volume->ViewValue = FormatNumber($this->volume->ViewValue, 2, -2, -2, -2);
            $this->volume->ViewCustomAttributes = "";

            // jenistutup
            $this->jenistutup->ViewValue = $this->jenistutup->CurrentValue;
            $this->jenistutup->ViewCustomAttributes = "";

            // catatanpackaging
            $this->catatanpackaging->ViewValue = $this->catatanpackaging->CurrentValue;
            $this->catatanpackaging->ViewCustomAttributes = "";

            // infopackaging
            $this->infopackaging->ViewValue = $this->infopackaging->CurrentValue;
            $this->infopackaging->ViewCustomAttributes = "";

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewValue = FormatNumber($this->ukuran->ViewValue, 0, -2, -2, -2);
            $this->ukuran->ViewCustomAttributes = "";

            // desainprodukkemasan
            $this->desainprodukkemasan->ViewValue = $this->desainprodukkemasan->CurrentValue;
            $this->desainprodukkemasan->ViewCustomAttributes = "";

            // desaindiinginkan
            $this->desaindiinginkan->ViewValue = $this->desaindiinginkan->CurrentValue;
            $this->desaindiinginkan->ViewCustomAttributes = "";

            // mereknotifikasi
            $this->mereknotifikasi->ViewValue = $this->mereknotifikasi->CurrentValue;
            $this->mereknotifikasi->ViewCustomAttributes = "";

            // kategoristatus
            $this->kategoristatus->ViewValue = $this->kategoristatus->CurrentValue;
            $this->kategoristatus->ViewCustomAttributes = "";

            // kemasan_ukuran_satuan
            $this->kemasan_ukuran_satuan->ViewValue = $this->kemasan_ukuran_satuan->CurrentValue;
            $this->kemasan_ukuran_satuan->ViewCustomAttributes = "";

            // notifikasicatatan
            $this->notifikasicatatan->ViewValue = $this->notifikasicatatan->CurrentValue;
            $this->notifikasicatatan->ViewCustomAttributes = "";

            // label_ukuran
            $this->label_ukuran->ViewValue = $this->label_ukuran->CurrentValue;
            $this->label_ukuran->ViewCustomAttributes = "";

            // infolabel
            $this->infolabel->ViewValue = $this->infolabel->CurrentValue;
            $this->infolabel->ViewCustomAttributes = "";

            // labelkualitas
            $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
            $this->labelkualitas->ViewCustomAttributes = "";

            // labelposisi
            $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
            $this->labelposisi->ViewCustomAttributes = "";

            // labelcatatan
            $this->labelcatatan->ViewValue = $this->labelcatatan->CurrentValue;
            $this->labelcatatan->ViewCustomAttributes = "";

            // dibuatdi
            $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
            $this->dibuatdi->ViewCustomAttributes = "";

            // tanggal
            $this->tanggal->ViewValue = $this->tanggal->CurrentValue;
            $this->tanggal->ViewValue = FormatDateTime($this->tanggal->ViewValue, 0);
            $this->tanggal->ViewCustomAttributes = "";

            // penerima
            $this->penerima->ViewValue = $this->penerima->CurrentValue;
            $this->penerima->ViewValue = FormatNumber($this->penerima->ViewValue, 0, -2, -2, -2);
            $this->penerima->ViewCustomAttributes = "";

            // createat
            $this->createat->ViewValue = $this->createat->CurrentValue;
            $this->createat->ViewValue = FormatDateTime($this->createat->ViewValue, 0);
            $this->createat->ViewCustomAttributes = "";

            // createby
            $this->createby->ViewValue = $this->createby->CurrentValue;
            $this->createby->ViewValue = FormatNumber($this->createby->ViewValue, 0, -2, -2, -2);
            $this->createby->ViewCustomAttributes = "";

            // statusdokumen
            $this->statusdokumen->ViewValue = $this->statusdokumen->CurrentValue;
            $this->statusdokumen->ViewCustomAttributes = "";

            // update_at
            $this->update_at->ViewValue = $this->update_at->CurrentValue;
            $this->update_at->ViewValue = FormatDateTime($this->update_at->ViewValue, 0);
            $this->update_at->ViewCustomAttributes = "";

            // status_data
            $this->status_data->ViewValue = $this->status_data->CurrentValue;
            $this->status_data->ViewCustomAttributes = "";

            // harga_rnd
            $this->harga_rnd->ViewValue = $this->harga_rnd->CurrentValue;
            $this->harga_rnd->ViewValue = FormatNumber($this->harga_rnd->ViewValue, 2, -2, -2, -2);
            $this->harga_rnd->ViewCustomAttributes = "";

            // aplikasi_sediaan
            $this->aplikasi_sediaan->ViewValue = $this->aplikasi_sediaan->CurrentValue;
            $this->aplikasi_sediaan->ViewCustomAttributes = "";

            // hu_hrg_isi
            $this->hu_hrg_isi->ViewValue = $this->hu_hrg_isi->CurrentValue;
            $this->hu_hrg_isi->ViewValue = FormatNumber($this->hu_hrg_isi->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_isi->ViewCustomAttributes = "";

            // hu_hrg_isi_pro
            $this->hu_hrg_isi_pro->ViewValue = $this->hu_hrg_isi_pro->CurrentValue;
            $this->hu_hrg_isi_pro->ViewValue = FormatNumber($this->hu_hrg_isi_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_isi_pro->ViewCustomAttributes = "";

            // hu_hrg_kms_primer
            $this->hu_hrg_kms_primer->ViewValue = $this->hu_hrg_kms_primer->CurrentValue;
            $this->hu_hrg_kms_primer->ViewValue = FormatNumber($this->hu_hrg_kms_primer->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_primer->ViewCustomAttributes = "";

            // hu_hrg_kms_primer_pro
            $this->hu_hrg_kms_primer_pro->ViewValue = $this->hu_hrg_kms_primer_pro->CurrentValue;
            $this->hu_hrg_kms_primer_pro->ViewValue = FormatNumber($this->hu_hrg_kms_primer_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_primer_pro->ViewCustomAttributes = "";

            // hu_hrg_kms_sekunder
            $this->hu_hrg_kms_sekunder->ViewValue = $this->hu_hrg_kms_sekunder->CurrentValue;
            $this->hu_hrg_kms_sekunder->ViewValue = FormatNumber($this->hu_hrg_kms_sekunder->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_sekunder->ViewCustomAttributes = "";

            // hu_hrg_kms_sekunder_pro
            $this->hu_hrg_kms_sekunder_pro->ViewValue = $this->hu_hrg_kms_sekunder_pro->CurrentValue;
            $this->hu_hrg_kms_sekunder_pro->ViewValue = FormatNumber($this->hu_hrg_kms_sekunder_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_kms_sekunder_pro->ViewCustomAttributes = "";

            // hu_hrg_label
            $this->hu_hrg_label->ViewValue = $this->hu_hrg_label->CurrentValue;
            $this->hu_hrg_label->ViewValue = FormatNumber($this->hu_hrg_label->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_label->ViewCustomAttributes = "";

            // hu_hrg_label_pro
            $this->hu_hrg_label_pro->ViewValue = $this->hu_hrg_label_pro->CurrentValue;
            $this->hu_hrg_label_pro->ViewValue = FormatNumber($this->hu_hrg_label_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_label_pro->ViewCustomAttributes = "";

            // hu_hrg_total
            $this->hu_hrg_total->ViewValue = $this->hu_hrg_total->CurrentValue;
            $this->hu_hrg_total->ViewValue = FormatNumber($this->hu_hrg_total->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_total->ViewCustomAttributes = "";

            // hu_hrg_total_pro
            $this->hu_hrg_total_pro->ViewValue = $this->hu_hrg_total_pro->CurrentValue;
            $this->hu_hrg_total_pro->ViewValue = FormatNumber($this->hu_hrg_total_pro->ViewValue, 2, -2, -2, -2);
            $this->hu_hrg_total_pro->ViewCustomAttributes = "";

            // hl_hrg_isi
            $this->hl_hrg_isi->ViewValue = $this->hl_hrg_isi->CurrentValue;
            $this->hl_hrg_isi->ViewValue = FormatNumber($this->hl_hrg_isi->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_isi->ViewCustomAttributes = "";

            // hl_hrg_isi_pro
            $this->hl_hrg_isi_pro->ViewValue = $this->hl_hrg_isi_pro->CurrentValue;
            $this->hl_hrg_isi_pro->ViewValue = FormatNumber($this->hl_hrg_isi_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_isi_pro->ViewCustomAttributes = "";

            // hl_hrg_kms_primer
            $this->hl_hrg_kms_primer->ViewValue = $this->hl_hrg_kms_primer->CurrentValue;
            $this->hl_hrg_kms_primer->ViewValue = FormatNumber($this->hl_hrg_kms_primer->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_primer->ViewCustomAttributes = "";

            // hl_hrg_kms_primer_pro
            $this->hl_hrg_kms_primer_pro->ViewValue = $this->hl_hrg_kms_primer_pro->CurrentValue;
            $this->hl_hrg_kms_primer_pro->ViewValue = FormatNumber($this->hl_hrg_kms_primer_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_primer_pro->ViewCustomAttributes = "";

            // hl_hrg_kms_sekunder
            $this->hl_hrg_kms_sekunder->ViewValue = $this->hl_hrg_kms_sekunder->CurrentValue;
            $this->hl_hrg_kms_sekunder->ViewValue = FormatNumber($this->hl_hrg_kms_sekunder->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_sekunder->ViewCustomAttributes = "";

            // hl_hrg_kms_sekunder_pro
            $this->hl_hrg_kms_sekunder_pro->ViewValue = $this->hl_hrg_kms_sekunder_pro->CurrentValue;
            $this->hl_hrg_kms_sekunder_pro->ViewValue = FormatNumber($this->hl_hrg_kms_sekunder_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_kms_sekunder_pro->ViewCustomAttributes = "";

            // hl_hrg_label
            $this->hl_hrg_label->ViewValue = $this->hl_hrg_label->CurrentValue;
            $this->hl_hrg_label->ViewValue = FormatNumber($this->hl_hrg_label->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_label->ViewCustomAttributes = "";

            // hl_hrg_label_pro
            $this->hl_hrg_label_pro->ViewValue = $this->hl_hrg_label_pro->CurrentValue;
            $this->hl_hrg_label_pro->ViewValue = FormatNumber($this->hl_hrg_label_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_label_pro->ViewCustomAttributes = "";

            // hl_hrg_total
            $this->hl_hrg_total->ViewValue = $this->hl_hrg_total->CurrentValue;
            $this->hl_hrg_total->ViewValue = FormatNumber($this->hl_hrg_total->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_total->ViewCustomAttributes = "";

            // hl_hrg_total_pro
            $this->hl_hrg_total_pro->ViewValue = $this->hl_hrg_total_pro->CurrentValue;
            $this->hl_hrg_total_pro->ViewValue = FormatNumber($this->hl_hrg_total_pro->ViewValue, 2, -2, -2, -2);
            $this->hl_hrg_total_pro->ViewCustomAttributes = "";

            // bs_bahan_aktif_tick
            $this->bs_bahan_aktif_tick->ViewValue = $this->bs_bahan_aktif_tick->CurrentValue;
            $this->bs_bahan_aktif_tick->ViewCustomAttributes = "";

            // bs_bahan_aktif
            $this->bs_bahan_aktif->ViewValue = $this->bs_bahan_aktif->CurrentValue;
            $this->bs_bahan_aktif->ViewCustomAttributes = "";

            // bs_bahan_lain
            $this->bs_bahan_lain->ViewValue = $this->bs_bahan_lain->CurrentValue;
            $this->bs_bahan_lain->ViewCustomAttributes = "";

            // bs_parfum
            $this->bs_parfum->ViewValue = $this->bs_parfum->CurrentValue;
            $this->bs_parfum->ViewCustomAttributes = "";

            // bs_estetika
            $this->bs_estetika->ViewValue = $this->bs_estetika->CurrentValue;
            $this->bs_estetika->ViewCustomAttributes = "";

            // bs_kms_wadah
            $this->bs_kms_wadah->ViewValue = $this->bs_kms_wadah->CurrentValue;
            $this->bs_kms_wadah->ViewCustomAttributes = "";

            // bs_kms_tutup
            $this->bs_kms_tutup->ViewValue = $this->bs_kms_tutup->CurrentValue;
            $this->bs_kms_tutup->ViewCustomAttributes = "";

            // bs_kms_sekunder
            $this->bs_kms_sekunder->ViewValue = $this->bs_kms_sekunder->CurrentValue;
            $this->bs_kms_sekunder->ViewCustomAttributes = "";

            // bs_label_desain
            $this->bs_label_desain->ViewValue = $this->bs_label_desain->CurrentValue;
            $this->bs_label_desain->ViewCustomAttributes = "";

            // bs_label_cetak
            $this->bs_label_cetak->ViewValue = $this->bs_label_cetak->CurrentValue;
            $this->bs_label_cetak->ViewCustomAttributes = "";

            // bs_label_lain
            $this->bs_label_lain->ViewValue = $this->bs_label_lain->CurrentValue;
            $this->bs_label_lain->ViewCustomAttributes = "";

            // dlv_pickup
            $this->dlv_pickup->ViewValue = $this->dlv_pickup->CurrentValue;
            $this->dlv_pickup->ViewCustomAttributes = "";

            // dlv_singlepoint
            $this->dlv_singlepoint->ViewValue = $this->dlv_singlepoint->CurrentValue;
            $this->dlv_singlepoint->ViewCustomAttributes = "";

            // dlv_multipoint
            $this->dlv_multipoint->ViewValue = $this->dlv_multipoint->CurrentValue;
            $this->dlv_multipoint->ViewCustomAttributes = "";

            // dlv_multipoint_jml
            $this->dlv_multipoint_jml->ViewValue = $this->dlv_multipoint_jml->CurrentValue;
            $this->dlv_multipoint_jml->ViewCustomAttributes = "";

            // dlv_term_lain
            $this->dlv_term_lain->ViewValue = $this->dlv_term_lain->CurrentValue;
            $this->dlv_term_lain->ViewCustomAttributes = "";

            // catatan_khusus
            $this->catatan_khusus->ViewValue = $this->catatan_khusus->CurrentValue;
            $this->catatan_khusus->ViewCustomAttributes = "";

            // aju_tgl
            $this->aju_tgl->ViewValue = $this->aju_tgl->CurrentValue;
            $this->aju_tgl->ViewValue = FormatDateTime($this->aju_tgl->ViewValue, 0);
            $this->aju_tgl->ViewCustomAttributes = "";

            // aju_oleh
            $this->aju_oleh->ViewValue = $this->aju_oleh->CurrentValue;
            $this->aju_oleh->ViewValue = FormatNumber($this->aju_oleh->ViewValue, 0, -2, -2, -2);
            $this->aju_oleh->ViewCustomAttributes = "";

            // proses_tgl
            $this->proses_tgl->ViewValue = $this->proses_tgl->CurrentValue;
            $this->proses_tgl->ViewValue = FormatDateTime($this->proses_tgl->ViewValue, 0);
            $this->proses_tgl->ViewCustomAttributes = "";

            // proses_oleh
            $this->proses_oleh->ViewValue = $this->proses_oleh->CurrentValue;
            $this->proses_oleh->ViewValue = FormatNumber($this->proses_oleh->ViewValue, 0, -2, -2, -2);
            $this->proses_oleh->ViewCustomAttributes = "";

            // revisi_tgl
            $this->revisi_tgl->ViewValue = $this->revisi_tgl->CurrentValue;
            $this->revisi_tgl->ViewValue = FormatDateTime($this->revisi_tgl->ViewValue, 0);
            $this->revisi_tgl->ViewCustomAttributes = "";

            // revisi_oleh
            $this->revisi_oleh->ViewValue = $this->revisi_oleh->CurrentValue;
            $this->revisi_oleh->ViewValue = FormatNumber($this->revisi_oleh->ViewValue, 0, -2, -2, -2);
            $this->revisi_oleh->ViewCustomAttributes = "";

            // revisi_akun_tgl
            $this->revisi_akun_tgl->ViewValue = $this->revisi_akun_tgl->CurrentValue;
            $this->revisi_akun_tgl->ViewValue = FormatDateTime($this->revisi_akun_tgl->ViewValue, 0);
            $this->revisi_akun_tgl->ViewCustomAttributes = "";

            // revisi_akun_oleh
            $this->revisi_akun_oleh->ViewValue = $this->revisi_akun_oleh->CurrentValue;
            $this->revisi_akun_oleh->ViewValue = FormatNumber($this->revisi_akun_oleh->ViewValue, 0, -2, -2, -2);
            $this->revisi_akun_oleh->ViewCustomAttributes = "";

            // revisi_rnd_tgl
            $this->revisi_rnd_tgl->ViewValue = $this->revisi_rnd_tgl->CurrentValue;
            $this->revisi_rnd_tgl->ViewValue = FormatDateTime($this->revisi_rnd_tgl->ViewValue, 0);
            $this->revisi_rnd_tgl->ViewCustomAttributes = "";

            // revisi_rnd_oleh
            $this->revisi_rnd_oleh->ViewValue = $this->revisi_rnd_oleh->CurrentValue;
            $this->revisi_rnd_oleh->ViewValue = FormatNumber($this->revisi_rnd_oleh->ViewValue, 0, -2, -2, -2);
            $this->revisi_rnd_oleh->ViewCustomAttributes = "";

            // rnd_tgl
            $this->rnd_tgl->ViewValue = $this->rnd_tgl->CurrentValue;
            $this->rnd_tgl->ViewValue = FormatDateTime($this->rnd_tgl->ViewValue, 0);
            $this->rnd_tgl->ViewCustomAttributes = "";

            // rnd_oleh
            $this->rnd_oleh->ViewValue = $this->rnd_oleh->CurrentValue;
            $this->rnd_oleh->ViewValue = FormatNumber($this->rnd_oleh->ViewValue, 0, -2, -2, -2);
            $this->rnd_oleh->ViewCustomAttributes = "";

            // ap_tgl
            $this->ap_tgl->ViewValue = $this->ap_tgl->CurrentValue;
            $this->ap_tgl->ViewValue = FormatDateTime($this->ap_tgl->ViewValue, 0);
            $this->ap_tgl->ViewCustomAttributes = "";

            // ap_oleh
            $this->ap_oleh->ViewValue = $this->ap_oleh->CurrentValue;
            $this->ap_oleh->ViewValue = FormatNumber($this->ap_oleh->ViewValue, 0, -2, -2, -2);
            $this->ap_oleh->ViewCustomAttributes = "";

            // batal_tgl
            $this->batal_tgl->ViewValue = $this->batal_tgl->CurrentValue;
            $this->batal_tgl->ViewValue = FormatDateTime($this->batal_tgl->ViewValue, 0);
            $this->batal_tgl->ViewCustomAttributes = "";

            // batal_oleh
            $this->batal_oleh->ViewValue = $this->batal_oleh->CurrentValue;
            $this->batal_oleh->ViewValue = FormatNumber($this->batal_oleh->ViewValue, 0, -2, -2, -2);
            $this->batal_oleh->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // cpo_jenis
            $this->cpo_jenis->LinkCustomAttributes = "";
            $this->cpo_jenis->HrefValue = "";
            $this->cpo_jenis->TooltipValue = "";

            // ordernum
            $this->ordernum->LinkCustomAttributes = "";
            $this->ordernum->HrefValue = "";
            $this->ordernum->TooltipValue = "";

            // order_kode
            $this->order_kode->LinkCustomAttributes = "";
            $this->order_kode->HrefValue = "";
            $this->order_kode->TooltipValue = "";

            // orderterimatgl
            $this->orderterimatgl->LinkCustomAttributes = "";
            $this->orderterimatgl->HrefValue = "";
            $this->orderterimatgl->TooltipValue = "";

            // produk_fungsi
            $this->produk_fungsi->LinkCustomAttributes = "";
            $this->produk_fungsi->HrefValue = "";
            $this->produk_fungsi->TooltipValue = "";

            // produk_kualitas
            $this->produk_kualitas->LinkCustomAttributes = "";
            $this->produk_kualitas->HrefValue = "";
            $this->produk_kualitas->TooltipValue = "";

            // produk_campaign
            $this->produk_campaign->LinkCustomAttributes = "";
            $this->produk_campaign->HrefValue = "";
            $this->produk_campaign->TooltipValue = "";

            // kemasan_satuan
            $this->kemasan_satuan->LinkCustomAttributes = "";
            $this->kemasan_satuan->HrefValue = "";
            $this->kemasan_satuan->TooltipValue = "";

            // ordertgl
            $this->ordertgl->LinkCustomAttributes = "";
            $this->ordertgl->HrefValue = "";
            $this->ordertgl->TooltipValue = "";

            // custcode
            $this->custcode->LinkCustomAttributes = "";
            $this->custcode->HrefValue = "";
            $this->custcode->TooltipValue = "";

            // perushnama
            $this->perushnama->LinkCustomAttributes = "";
            $this->perushnama->HrefValue = "";
            $this->perushnama->TooltipValue = "";

            // perushalamat
            $this->perushalamat->LinkCustomAttributes = "";
            $this->perushalamat->HrefValue = "";
            $this->perushalamat->TooltipValue = "";

            // perushcp
            $this->perushcp->LinkCustomAttributes = "";
            $this->perushcp->HrefValue = "";
            $this->perushcp->TooltipValue = "";

            // perushjabatan
            $this->perushjabatan->LinkCustomAttributes = "";
            $this->perushjabatan->HrefValue = "";
            $this->perushjabatan->TooltipValue = "";

            // perushphone
            $this->perushphone->LinkCustomAttributes = "";
            $this->perushphone->HrefValue = "";
            $this->perushphone->TooltipValue = "";

            // perushmobile
            $this->perushmobile->LinkCustomAttributes = "";
            $this->perushmobile->HrefValue = "";
            $this->perushmobile->TooltipValue = "";

            // bencmark
            $this->bencmark->LinkCustomAttributes = "";
            $this->bencmark->HrefValue = "";
            $this->bencmark->TooltipValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";
            $this->kategoriproduk->TooltipValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";
            $this->jenisproduk->TooltipValue = "";

            // bentuksediaan
            $this->bentuksediaan->LinkCustomAttributes = "";
            $this->bentuksediaan->HrefValue = "";
            $this->bentuksediaan->TooltipValue = "";

            // sediaan_ukuran
            $this->sediaan_ukuran->LinkCustomAttributes = "";
            $this->sediaan_ukuran->HrefValue = "";
            $this->sediaan_ukuran->TooltipValue = "";

            // sediaan_ukuran_satuan
            $this->sediaan_ukuran_satuan->LinkCustomAttributes = "";
            $this->sediaan_ukuran_satuan->HrefValue = "";
            $this->sediaan_ukuran_satuan->TooltipValue = "";

            // produk_viskositas
            $this->produk_viskositas->LinkCustomAttributes = "";
            $this->produk_viskositas->HrefValue = "";
            $this->produk_viskositas->TooltipValue = "";

            // konsepproduk
            $this->konsepproduk->LinkCustomAttributes = "";
            $this->konsepproduk->HrefValue = "";
            $this->konsepproduk->TooltipValue = "";

            // fragrance
            $this->fragrance->LinkCustomAttributes = "";
            $this->fragrance->HrefValue = "";
            $this->fragrance->TooltipValue = "";

            // aroma
            $this->aroma->LinkCustomAttributes = "";
            $this->aroma->HrefValue = "";
            $this->aroma->TooltipValue = "";

            // bahanaktif
            $this->bahanaktif->LinkCustomAttributes = "";
            $this->bahanaktif->HrefValue = "";
            $this->bahanaktif->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // produk_warna_jenis
            $this->produk_warna_jenis->LinkCustomAttributes = "";
            $this->produk_warna_jenis->HrefValue = "";
            $this->produk_warna_jenis->TooltipValue = "";

            // aksesoris
            $this->aksesoris->LinkCustomAttributes = "";
            $this->aksesoris->HrefValue = "";
            $this->aksesoris->TooltipValue = "";

            // produk_lainlain
            $this->produk_lainlain->LinkCustomAttributes = "";
            $this->produk_lainlain->HrefValue = "";
            $this->produk_lainlain->TooltipValue = "";

            // statusproduk
            $this->statusproduk->LinkCustomAttributes = "";
            $this->statusproduk->HrefValue = "";
            $this->statusproduk->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // catatan
            $this->catatan->LinkCustomAttributes = "";
            $this->catatan->HrefValue = "";
            $this->catatan->TooltipValue = "";

            // rencanakemasan
            $this->rencanakemasan->LinkCustomAttributes = "";
            $this->rencanakemasan->HrefValue = "";
            $this->rencanakemasan->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // ekspetasiharga
            $this->ekspetasiharga->LinkCustomAttributes = "";
            $this->ekspetasiharga->HrefValue = "";
            $this->ekspetasiharga->TooltipValue = "";

            // kemasan
            $this->kemasan->LinkCustomAttributes = "";
            $this->kemasan->HrefValue = "";
            $this->kemasan->TooltipValue = "";

            // volume
            $this->volume->LinkCustomAttributes = "";
            $this->volume->HrefValue = "";
            $this->volume->TooltipValue = "";

            // jenistutup
            $this->jenistutup->LinkCustomAttributes = "";
            $this->jenistutup->HrefValue = "";
            $this->jenistutup->TooltipValue = "";

            // catatanpackaging
            $this->catatanpackaging->LinkCustomAttributes = "";
            $this->catatanpackaging->HrefValue = "";
            $this->catatanpackaging->TooltipValue = "";

            // infopackaging
            $this->infopackaging->LinkCustomAttributes = "";
            $this->infopackaging->HrefValue = "";
            $this->infopackaging->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";

            // desainprodukkemasan
            $this->desainprodukkemasan->LinkCustomAttributes = "";
            $this->desainprodukkemasan->HrefValue = "";
            $this->desainprodukkemasan->TooltipValue = "";

            // desaindiinginkan
            $this->desaindiinginkan->LinkCustomAttributes = "";
            $this->desaindiinginkan->HrefValue = "";
            $this->desaindiinginkan->TooltipValue = "";

            // mereknotifikasi
            $this->mereknotifikasi->LinkCustomAttributes = "";
            $this->mereknotifikasi->HrefValue = "";
            $this->mereknotifikasi->TooltipValue = "";

            // kategoristatus
            $this->kategoristatus->LinkCustomAttributes = "";
            $this->kategoristatus->HrefValue = "";
            $this->kategoristatus->TooltipValue = "";

            // kemasan_ukuran_satuan
            $this->kemasan_ukuran_satuan->LinkCustomAttributes = "";
            $this->kemasan_ukuran_satuan->HrefValue = "";
            $this->kemasan_ukuran_satuan->TooltipValue = "";

            // notifikasicatatan
            $this->notifikasicatatan->LinkCustomAttributes = "";
            $this->notifikasicatatan->HrefValue = "";
            $this->notifikasicatatan->TooltipValue = "";

            // label_ukuran
            $this->label_ukuran->LinkCustomAttributes = "";
            $this->label_ukuran->HrefValue = "";
            $this->label_ukuran->TooltipValue = "";

            // infolabel
            $this->infolabel->LinkCustomAttributes = "";
            $this->infolabel->HrefValue = "";
            $this->infolabel->TooltipValue = "";

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

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";
            $this->dibuatdi->TooltipValue = "";

            // tanggal
            $this->tanggal->LinkCustomAttributes = "";
            $this->tanggal->HrefValue = "";
            $this->tanggal->TooltipValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";
            $this->penerima->TooltipValue = "";

            // createat
            $this->createat->LinkCustomAttributes = "";
            $this->createat->HrefValue = "";
            $this->createat->TooltipValue = "";

            // createby
            $this->createby->LinkCustomAttributes = "";
            $this->createby->HrefValue = "";
            $this->createby->TooltipValue = "";

            // statusdokumen
            $this->statusdokumen->LinkCustomAttributes = "";
            $this->statusdokumen->HrefValue = "";
            $this->statusdokumen->TooltipValue = "";

            // update_at
            $this->update_at->LinkCustomAttributes = "";
            $this->update_at->HrefValue = "";
            $this->update_at->TooltipValue = "";

            // status_data
            $this->status_data->LinkCustomAttributes = "";
            $this->status_data->HrefValue = "";
            $this->status_data->TooltipValue = "";

            // harga_rnd
            $this->harga_rnd->LinkCustomAttributes = "";
            $this->harga_rnd->HrefValue = "";
            $this->harga_rnd->TooltipValue = "";

            // aplikasi_sediaan
            $this->aplikasi_sediaan->LinkCustomAttributes = "";
            $this->aplikasi_sediaan->HrefValue = "";
            $this->aplikasi_sediaan->TooltipValue = "";

            // hu_hrg_isi
            $this->hu_hrg_isi->LinkCustomAttributes = "";
            $this->hu_hrg_isi->HrefValue = "";
            $this->hu_hrg_isi->TooltipValue = "";

            // hu_hrg_isi_pro
            $this->hu_hrg_isi_pro->LinkCustomAttributes = "";
            $this->hu_hrg_isi_pro->HrefValue = "";
            $this->hu_hrg_isi_pro->TooltipValue = "";

            // hu_hrg_kms_primer
            $this->hu_hrg_kms_primer->LinkCustomAttributes = "";
            $this->hu_hrg_kms_primer->HrefValue = "";
            $this->hu_hrg_kms_primer->TooltipValue = "";

            // hu_hrg_kms_primer_pro
            $this->hu_hrg_kms_primer_pro->LinkCustomAttributes = "";
            $this->hu_hrg_kms_primer_pro->HrefValue = "";
            $this->hu_hrg_kms_primer_pro->TooltipValue = "";

            // hu_hrg_kms_sekunder
            $this->hu_hrg_kms_sekunder->LinkCustomAttributes = "";
            $this->hu_hrg_kms_sekunder->HrefValue = "";
            $this->hu_hrg_kms_sekunder->TooltipValue = "";

            // hu_hrg_kms_sekunder_pro
            $this->hu_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
            $this->hu_hrg_kms_sekunder_pro->HrefValue = "";
            $this->hu_hrg_kms_sekunder_pro->TooltipValue = "";

            // hu_hrg_label
            $this->hu_hrg_label->LinkCustomAttributes = "";
            $this->hu_hrg_label->HrefValue = "";
            $this->hu_hrg_label->TooltipValue = "";

            // hu_hrg_label_pro
            $this->hu_hrg_label_pro->LinkCustomAttributes = "";
            $this->hu_hrg_label_pro->HrefValue = "";
            $this->hu_hrg_label_pro->TooltipValue = "";

            // hu_hrg_total
            $this->hu_hrg_total->LinkCustomAttributes = "";
            $this->hu_hrg_total->HrefValue = "";
            $this->hu_hrg_total->TooltipValue = "";

            // hu_hrg_total_pro
            $this->hu_hrg_total_pro->LinkCustomAttributes = "";
            $this->hu_hrg_total_pro->HrefValue = "";
            $this->hu_hrg_total_pro->TooltipValue = "";

            // hl_hrg_isi
            $this->hl_hrg_isi->LinkCustomAttributes = "";
            $this->hl_hrg_isi->HrefValue = "";
            $this->hl_hrg_isi->TooltipValue = "";

            // hl_hrg_isi_pro
            $this->hl_hrg_isi_pro->LinkCustomAttributes = "";
            $this->hl_hrg_isi_pro->HrefValue = "";
            $this->hl_hrg_isi_pro->TooltipValue = "";

            // hl_hrg_kms_primer
            $this->hl_hrg_kms_primer->LinkCustomAttributes = "";
            $this->hl_hrg_kms_primer->HrefValue = "";
            $this->hl_hrg_kms_primer->TooltipValue = "";

            // hl_hrg_kms_primer_pro
            $this->hl_hrg_kms_primer_pro->LinkCustomAttributes = "";
            $this->hl_hrg_kms_primer_pro->HrefValue = "";
            $this->hl_hrg_kms_primer_pro->TooltipValue = "";

            // hl_hrg_kms_sekunder
            $this->hl_hrg_kms_sekunder->LinkCustomAttributes = "";
            $this->hl_hrg_kms_sekunder->HrefValue = "";
            $this->hl_hrg_kms_sekunder->TooltipValue = "";

            // hl_hrg_kms_sekunder_pro
            $this->hl_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
            $this->hl_hrg_kms_sekunder_pro->HrefValue = "";
            $this->hl_hrg_kms_sekunder_pro->TooltipValue = "";

            // hl_hrg_label
            $this->hl_hrg_label->LinkCustomAttributes = "";
            $this->hl_hrg_label->HrefValue = "";
            $this->hl_hrg_label->TooltipValue = "";

            // hl_hrg_label_pro
            $this->hl_hrg_label_pro->LinkCustomAttributes = "";
            $this->hl_hrg_label_pro->HrefValue = "";
            $this->hl_hrg_label_pro->TooltipValue = "";

            // hl_hrg_total
            $this->hl_hrg_total->LinkCustomAttributes = "";
            $this->hl_hrg_total->HrefValue = "";
            $this->hl_hrg_total->TooltipValue = "";

            // hl_hrg_total_pro
            $this->hl_hrg_total_pro->LinkCustomAttributes = "";
            $this->hl_hrg_total_pro->HrefValue = "";
            $this->hl_hrg_total_pro->TooltipValue = "";

            // bs_bahan_aktif_tick
            $this->bs_bahan_aktif_tick->LinkCustomAttributes = "";
            $this->bs_bahan_aktif_tick->HrefValue = "";
            $this->bs_bahan_aktif_tick->TooltipValue = "";

            // bs_bahan_aktif
            $this->bs_bahan_aktif->LinkCustomAttributes = "";
            $this->bs_bahan_aktif->HrefValue = "";
            $this->bs_bahan_aktif->TooltipValue = "";

            // bs_bahan_lain
            $this->bs_bahan_lain->LinkCustomAttributes = "";
            $this->bs_bahan_lain->HrefValue = "";
            $this->bs_bahan_lain->TooltipValue = "";

            // bs_parfum
            $this->bs_parfum->LinkCustomAttributes = "";
            $this->bs_parfum->HrefValue = "";
            $this->bs_parfum->TooltipValue = "";

            // bs_estetika
            $this->bs_estetika->LinkCustomAttributes = "";
            $this->bs_estetika->HrefValue = "";
            $this->bs_estetika->TooltipValue = "";

            // bs_kms_wadah
            $this->bs_kms_wadah->LinkCustomAttributes = "";
            $this->bs_kms_wadah->HrefValue = "";
            $this->bs_kms_wadah->TooltipValue = "";

            // bs_kms_tutup
            $this->bs_kms_tutup->LinkCustomAttributes = "";
            $this->bs_kms_tutup->HrefValue = "";
            $this->bs_kms_tutup->TooltipValue = "";

            // bs_kms_sekunder
            $this->bs_kms_sekunder->LinkCustomAttributes = "";
            $this->bs_kms_sekunder->HrefValue = "";
            $this->bs_kms_sekunder->TooltipValue = "";

            // bs_label_desain
            $this->bs_label_desain->LinkCustomAttributes = "";
            $this->bs_label_desain->HrefValue = "";
            $this->bs_label_desain->TooltipValue = "";

            // bs_label_cetak
            $this->bs_label_cetak->LinkCustomAttributes = "";
            $this->bs_label_cetak->HrefValue = "";
            $this->bs_label_cetak->TooltipValue = "";

            // bs_label_lain
            $this->bs_label_lain->LinkCustomAttributes = "";
            $this->bs_label_lain->HrefValue = "";
            $this->bs_label_lain->TooltipValue = "";

            // dlv_pickup
            $this->dlv_pickup->LinkCustomAttributes = "";
            $this->dlv_pickup->HrefValue = "";
            $this->dlv_pickup->TooltipValue = "";

            // dlv_singlepoint
            $this->dlv_singlepoint->LinkCustomAttributes = "";
            $this->dlv_singlepoint->HrefValue = "";
            $this->dlv_singlepoint->TooltipValue = "";

            // dlv_multipoint
            $this->dlv_multipoint->LinkCustomAttributes = "";
            $this->dlv_multipoint->HrefValue = "";
            $this->dlv_multipoint->TooltipValue = "";

            // dlv_multipoint_jml
            $this->dlv_multipoint_jml->LinkCustomAttributes = "";
            $this->dlv_multipoint_jml->HrefValue = "";
            $this->dlv_multipoint_jml->TooltipValue = "";

            // dlv_term_lain
            $this->dlv_term_lain->LinkCustomAttributes = "";
            $this->dlv_term_lain->HrefValue = "";
            $this->dlv_term_lain->TooltipValue = "";

            // catatan_khusus
            $this->catatan_khusus->LinkCustomAttributes = "";
            $this->catatan_khusus->HrefValue = "";
            $this->catatan_khusus->TooltipValue = "";

            // aju_tgl
            $this->aju_tgl->LinkCustomAttributes = "";
            $this->aju_tgl->HrefValue = "";
            $this->aju_tgl->TooltipValue = "";

            // aju_oleh
            $this->aju_oleh->LinkCustomAttributes = "";
            $this->aju_oleh->HrefValue = "";
            $this->aju_oleh->TooltipValue = "";

            // proses_tgl
            $this->proses_tgl->LinkCustomAttributes = "";
            $this->proses_tgl->HrefValue = "";
            $this->proses_tgl->TooltipValue = "";

            // proses_oleh
            $this->proses_oleh->LinkCustomAttributes = "";
            $this->proses_oleh->HrefValue = "";
            $this->proses_oleh->TooltipValue = "";

            // revisi_tgl
            $this->revisi_tgl->LinkCustomAttributes = "";
            $this->revisi_tgl->HrefValue = "";
            $this->revisi_tgl->TooltipValue = "";

            // revisi_oleh
            $this->revisi_oleh->LinkCustomAttributes = "";
            $this->revisi_oleh->HrefValue = "";
            $this->revisi_oleh->TooltipValue = "";

            // revisi_akun_tgl
            $this->revisi_akun_tgl->LinkCustomAttributes = "";
            $this->revisi_akun_tgl->HrefValue = "";
            $this->revisi_akun_tgl->TooltipValue = "";

            // revisi_akun_oleh
            $this->revisi_akun_oleh->LinkCustomAttributes = "";
            $this->revisi_akun_oleh->HrefValue = "";
            $this->revisi_akun_oleh->TooltipValue = "";

            // revisi_rnd_tgl
            $this->revisi_rnd_tgl->LinkCustomAttributes = "";
            $this->revisi_rnd_tgl->HrefValue = "";
            $this->revisi_rnd_tgl->TooltipValue = "";

            // revisi_rnd_oleh
            $this->revisi_rnd_oleh->LinkCustomAttributes = "";
            $this->revisi_rnd_oleh->HrefValue = "";
            $this->revisi_rnd_oleh->TooltipValue = "";

            // rnd_tgl
            $this->rnd_tgl->LinkCustomAttributes = "";
            $this->rnd_tgl->HrefValue = "";
            $this->rnd_tgl->TooltipValue = "";

            // rnd_oleh
            $this->rnd_oleh->LinkCustomAttributes = "";
            $this->rnd_oleh->HrefValue = "";
            $this->rnd_oleh->TooltipValue = "";

            // ap_tgl
            $this->ap_tgl->LinkCustomAttributes = "";
            $this->ap_tgl->HrefValue = "";
            $this->ap_tgl->TooltipValue = "";

            // ap_oleh
            $this->ap_oleh->LinkCustomAttributes = "";
            $this->ap_oleh->HrefValue = "";
            $this->ap_oleh->TooltipValue = "";

            // batal_tgl
            $this->batal_tgl->LinkCustomAttributes = "";
            $this->batal_tgl->HrefValue = "";
            $this->batal_tgl->TooltipValue = "";

            // batal_oleh
            $this->batal_oleh->LinkCustomAttributes = "";
            $this->batal_oleh->HrefValue = "";
            $this->batal_oleh->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->CurrentValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // cpo_jenis
            $this->cpo_jenis->EditAttrs["class"] = "form-control";
            $this->cpo_jenis->EditCustomAttributes = "";
            if (!$this->cpo_jenis->Raw) {
                $this->cpo_jenis->CurrentValue = HtmlDecode($this->cpo_jenis->CurrentValue);
            }
            $this->cpo_jenis->EditValue = HtmlEncode($this->cpo_jenis->CurrentValue);
            $this->cpo_jenis->PlaceHolder = RemoveHtml($this->cpo_jenis->caption());

            // ordernum
            $this->ordernum->EditAttrs["class"] = "form-control";
            $this->ordernum->EditCustomAttributes = "";
            if (!$this->ordernum->Raw) {
                $this->ordernum->CurrentValue = HtmlDecode($this->ordernum->CurrentValue);
            }
            $this->ordernum->EditValue = HtmlEncode($this->ordernum->CurrentValue);
            $this->ordernum->PlaceHolder = RemoveHtml($this->ordernum->caption());

            // order_kode
            $this->order_kode->EditAttrs["class"] = "form-control";
            $this->order_kode->EditCustomAttributes = "";
            if (!$this->order_kode->Raw) {
                $this->order_kode->CurrentValue = HtmlDecode($this->order_kode->CurrentValue);
            }
            $this->order_kode->EditValue = HtmlEncode($this->order_kode->CurrentValue);
            $this->order_kode->PlaceHolder = RemoveHtml($this->order_kode->caption());

            // orderterimatgl
            $this->orderterimatgl->EditAttrs["class"] = "form-control";
            $this->orderterimatgl->EditCustomAttributes = "";
            $this->orderterimatgl->EditValue = HtmlEncode(FormatDateTime($this->orderterimatgl->CurrentValue, 8));
            $this->orderterimatgl->PlaceHolder = RemoveHtml($this->orderterimatgl->caption());

            // produk_fungsi
            $this->produk_fungsi->EditAttrs["class"] = "form-control";
            $this->produk_fungsi->EditCustomAttributes = "";
            if (!$this->produk_fungsi->Raw) {
                $this->produk_fungsi->CurrentValue = HtmlDecode($this->produk_fungsi->CurrentValue);
            }
            $this->produk_fungsi->EditValue = HtmlEncode($this->produk_fungsi->CurrentValue);
            $this->produk_fungsi->PlaceHolder = RemoveHtml($this->produk_fungsi->caption());

            // produk_kualitas
            $this->produk_kualitas->EditAttrs["class"] = "form-control";
            $this->produk_kualitas->EditCustomAttributes = "";
            if (!$this->produk_kualitas->Raw) {
                $this->produk_kualitas->CurrentValue = HtmlDecode($this->produk_kualitas->CurrentValue);
            }
            $this->produk_kualitas->EditValue = HtmlEncode($this->produk_kualitas->CurrentValue);
            $this->produk_kualitas->PlaceHolder = RemoveHtml($this->produk_kualitas->caption());

            // produk_campaign
            $this->produk_campaign->EditAttrs["class"] = "form-control";
            $this->produk_campaign->EditCustomAttributes = "";
            if (!$this->produk_campaign->Raw) {
                $this->produk_campaign->CurrentValue = HtmlDecode($this->produk_campaign->CurrentValue);
            }
            $this->produk_campaign->EditValue = HtmlEncode($this->produk_campaign->CurrentValue);
            $this->produk_campaign->PlaceHolder = RemoveHtml($this->produk_campaign->caption());

            // kemasan_satuan
            $this->kemasan_satuan->EditAttrs["class"] = "form-control";
            $this->kemasan_satuan->EditCustomAttributes = "";
            if (!$this->kemasan_satuan->Raw) {
                $this->kemasan_satuan->CurrentValue = HtmlDecode($this->kemasan_satuan->CurrentValue);
            }
            $this->kemasan_satuan->EditValue = HtmlEncode($this->kemasan_satuan->CurrentValue);
            $this->kemasan_satuan->PlaceHolder = RemoveHtml($this->kemasan_satuan->caption());

            // ordertgl
            $this->ordertgl->EditAttrs["class"] = "form-control";
            $this->ordertgl->EditCustomAttributes = "";
            $this->ordertgl->EditValue = HtmlEncode(FormatDateTime($this->ordertgl->CurrentValue, 8));
            $this->ordertgl->PlaceHolder = RemoveHtml($this->ordertgl->caption());

            // custcode
            $this->custcode->EditAttrs["class"] = "form-control";
            $this->custcode->EditCustomAttributes = "";
            $this->custcode->EditValue = HtmlEncode($this->custcode->CurrentValue);
            $this->custcode->PlaceHolder = RemoveHtml($this->custcode->caption());

            // perushnama
            $this->perushnama->EditAttrs["class"] = "form-control";
            $this->perushnama->EditCustomAttributes = "";
            if (!$this->perushnama->Raw) {
                $this->perushnama->CurrentValue = HtmlDecode($this->perushnama->CurrentValue);
            }
            $this->perushnama->EditValue = HtmlEncode($this->perushnama->CurrentValue);
            $this->perushnama->PlaceHolder = RemoveHtml($this->perushnama->caption());

            // perushalamat
            $this->perushalamat->EditAttrs["class"] = "form-control";
            $this->perushalamat->EditCustomAttributes = "";
            if (!$this->perushalamat->Raw) {
                $this->perushalamat->CurrentValue = HtmlDecode($this->perushalamat->CurrentValue);
            }
            $this->perushalamat->EditValue = HtmlEncode($this->perushalamat->CurrentValue);
            $this->perushalamat->PlaceHolder = RemoveHtml($this->perushalamat->caption());

            // perushcp
            $this->perushcp->EditAttrs["class"] = "form-control";
            $this->perushcp->EditCustomAttributes = "";
            if (!$this->perushcp->Raw) {
                $this->perushcp->CurrentValue = HtmlDecode($this->perushcp->CurrentValue);
            }
            $this->perushcp->EditValue = HtmlEncode($this->perushcp->CurrentValue);
            $this->perushcp->PlaceHolder = RemoveHtml($this->perushcp->caption());

            // perushjabatan
            $this->perushjabatan->EditAttrs["class"] = "form-control";
            $this->perushjabatan->EditCustomAttributes = "";
            if (!$this->perushjabatan->Raw) {
                $this->perushjabatan->CurrentValue = HtmlDecode($this->perushjabatan->CurrentValue);
            }
            $this->perushjabatan->EditValue = HtmlEncode($this->perushjabatan->CurrentValue);
            $this->perushjabatan->PlaceHolder = RemoveHtml($this->perushjabatan->caption());

            // perushphone
            $this->perushphone->EditAttrs["class"] = "form-control";
            $this->perushphone->EditCustomAttributes = "";
            if (!$this->perushphone->Raw) {
                $this->perushphone->CurrentValue = HtmlDecode($this->perushphone->CurrentValue);
            }
            $this->perushphone->EditValue = HtmlEncode($this->perushphone->CurrentValue);
            $this->perushphone->PlaceHolder = RemoveHtml($this->perushphone->caption());

            // perushmobile
            $this->perushmobile->EditAttrs["class"] = "form-control";
            $this->perushmobile->EditCustomAttributes = "";
            if (!$this->perushmobile->Raw) {
                $this->perushmobile->CurrentValue = HtmlDecode($this->perushmobile->CurrentValue);
            }
            $this->perushmobile->EditValue = HtmlEncode($this->perushmobile->CurrentValue);
            $this->perushmobile->PlaceHolder = RemoveHtml($this->perushmobile->caption());

            // bencmark
            $this->bencmark->EditAttrs["class"] = "form-control";
            $this->bencmark->EditCustomAttributes = "";
            if (!$this->bencmark->Raw) {
                $this->bencmark->CurrentValue = HtmlDecode($this->bencmark->CurrentValue);
            }
            $this->bencmark->EditValue = HtmlEncode($this->bencmark->CurrentValue);
            $this->bencmark->PlaceHolder = RemoveHtml($this->bencmark->caption());

            // kategoriproduk
            $this->kategoriproduk->EditAttrs["class"] = "form-control";
            $this->kategoriproduk->EditCustomAttributes = "";
            if (!$this->kategoriproduk->Raw) {
                $this->kategoriproduk->CurrentValue = HtmlDecode($this->kategoriproduk->CurrentValue);
            }
            $this->kategoriproduk->EditValue = HtmlEncode($this->kategoriproduk->CurrentValue);
            $this->kategoriproduk->PlaceHolder = RemoveHtml($this->kategoriproduk->caption());

            // jenisproduk
            $this->jenisproduk->EditAttrs["class"] = "form-control";
            $this->jenisproduk->EditCustomAttributes = "";
            if (!$this->jenisproduk->Raw) {
                $this->jenisproduk->CurrentValue = HtmlDecode($this->jenisproduk->CurrentValue);
            }
            $this->jenisproduk->EditValue = HtmlEncode($this->jenisproduk->CurrentValue);
            $this->jenisproduk->PlaceHolder = RemoveHtml($this->jenisproduk->caption());

            // bentuksediaan
            $this->bentuksediaan->EditAttrs["class"] = "form-control";
            $this->bentuksediaan->EditCustomAttributes = "";
            if (!$this->bentuksediaan->Raw) {
                $this->bentuksediaan->CurrentValue = HtmlDecode($this->bentuksediaan->CurrentValue);
            }
            $this->bentuksediaan->EditValue = HtmlEncode($this->bentuksediaan->CurrentValue);
            $this->bentuksediaan->PlaceHolder = RemoveHtml($this->bentuksediaan->caption());

            // sediaan_ukuran
            $this->sediaan_ukuran->EditAttrs["class"] = "form-control";
            $this->sediaan_ukuran->EditCustomAttributes = "";
            $this->sediaan_ukuran->EditValue = HtmlEncode($this->sediaan_ukuran->CurrentValue);
            $this->sediaan_ukuran->PlaceHolder = RemoveHtml($this->sediaan_ukuran->caption());
            if (strval($this->sediaan_ukuran->EditValue) != "" && is_numeric($this->sediaan_ukuran->EditValue)) {
                $this->sediaan_ukuran->EditValue = FormatNumber($this->sediaan_ukuran->EditValue, -2, -2, -2, -2);
            }

            // sediaan_ukuran_satuan
            $this->sediaan_ukuran_satuan->EditAttrs["class"] = "form-control";
            $this->sediaan_ukuran_satuan->EditCustomAttributes = "";
            if (!$this->sediaan_ukuran_satuan->Raw) {
                $this->sediaan_ukuran_satuan->CurrentValue = HtmlDecode($this->sediaan_ukuran_satuan->CurrentValue);
            }
            $this->sediaan_ukuran_satuan->EditValue = HtmlEncode($this->sediaan_ukuran_satuan->CurrentValue);
            $this->sediaan_ukuran_satuan->PlaceHolder = RemoveHtml($this->sediaan_ukuran_satuan->caption());

            // produk_viskositas
            $this->produk_viskositas->EditAttrs["class"] = "form-control";
            $this->produk_viskositas->EditCustomAttributes = "";
            if (!$this->produk_viskositas->Raw) {
                $this->produk_viskositas->CurrentValue = HtmlDecode($this->produk_viskositas->CurrentValue);
            }
            $this->produk_viskositas->EditValue = HtmlEncode($this->produk_viskositas->CurrentValue);
            $this->produk_viskositas->PlaceHolder = RemoveHtml($this->produk_viskositas->caption());

            // konsepproduk
            $this->konsepproduk->EditAttrs["class"] = "form-control";
            $this->konsepproduk->EditCustomAttributes = "";
            if (!$this->konsepproduk->Raw) {
                $this->konsepproduk->CurrentValue = HtmlDecode($this->konsepproduk->CurrentValue);
            }
            $this->konsepproduk->EditValue = HtmlEncode($this->konsepproduk->CurrentValue);
            $this->konsepproduk->PlaceHolder = RemoveHtml($this->konsepproduk->caption());

            // fragrance
            $this->fragrance->EditAttrs["class"] = "form-control";
            $this->fragrance->EditCustomAttributes = "";
            if (!$this->fragrance->Raw) {
                $this->fragrance->CurrentValue = HtmlDecode($this->fragrance->CurrentValue);
            }
            $this->fragrance->EditValue = HtmlEncode($this->fragrance->CurrentValue);
            $this->fragrance->PlaceHolder = RemoveHtml($this->fragrance->caption());

            // aroma
            $this->aroma->EditAttrs["class"] = "form-control";
            $this->aroma->EditCustomAttributes = "";
            if (!$this->aroma->Raw) {
                $this->aroma->CurrentValue = HtmlDecode($this->aroma->CurrentValue);
            }
            $this->aroma->EditValue = HtmlEncode($this->aroma->CurrentValue);
            $this->aroma->PlaceHolder = RemoveHtml($this->aroma->caption());

            // bahanaktif
            $this->bahanaktif->EditAttrs["class"] = "form-control";
            $this->bahanaktif->EditCustomAttributes = "";
            if (!$this->bahanaktif->Raw) {
                $this->bahanaktif->CurrentValue = HtmlDecode($this->bahanaktif->CurrentValue);
            }
            $this->bahanaktif->EditValue = HtmlEncode($this->bahanaktif->CurrentValue);
            $this->bahanaktif->PlaceHolder = RemoveHtml($this->bahanaktif->caption());

            // warna
            $this->warna->EditAttrs["class"] = "form-control";
            $this->warna->EditCustomAttributes = "";
            if (!$this->warna->Raw) {
                $this->warna->CurrentValue = HtmlDecode($this->warna->CurrentValue);
            }
            $this->warna->EditValue = HtmlEncode($this->warna->CurrentValue);
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // produk_warna_jenis
            $this->produk_warna_jenis->EditAttrs["class"] = "form-control";
            $this->produk_warna_jenis->EditCustomAttributes = "";
            if (!$this->produk_warna_jenis->Raw) {
                $this->produk_warna_jenis->CurrentValue = HtmlDecode($this->produk_warna_jenis->CurrentValue);
            }
            $this->produk_warna_jenis->EditValue = HtmlEncode($this->produk_warna_jenis->CurrentValue);
            $this->produk_warna_jenis->PlaceHolder = RemoveHtml($this->produk_warna_jenis->caption());

            // aksesoris
            $this->aksesoris->EditAttrs["class"] = "form-control";
            $this->aksesoris->EditCustomAttributes = "";
            if (!$this->aksesoris->Raw) {
                $this->aksesoris->CurrentValue = HtmlDecode($this->aksesoris->CurrentValue);
            }
            $this->aksesoris->EditValue = HtmlEncode($this->aksesoris->CurrentValue);
            $this->aksesoris->PlaceHolder = RemoveHtml($this->aksesoris->caption());

            // produk_lainlain
            $this->produk_lainlain->EditAttrs["class"] = "form-control";
            $this->produk_lainlain->EditCustomAttributes = "";
            $this->produk_lainlain->EditValue = HtmlEncode($this->produk_lainlain->CurrentValue);
            $this->produk_lainlain->PlaceHolder = RemoveHtml($this->produk_lainlain->caption());

            // statusproduk
            $this->statusproduk->EditAttrs["class"] = "form-control";
            $this->statusproduk->EditCustomAttributes = "";
            if (!$this->statusproduk->Raw) {
                $this->statusproduk->CurrentValue = HtmlDecode($this->statusproduk->CurrentValue);
            }
            $this->statusproduk->EditValue = HtmlEncode($this->statusproduk->CurrentValue);
            $this->statusproduk->PlaceHolder = RemoveHtml($this->statusproduk->caption());

            // parfum
            $this->parfum->EditAttrs["class"] = "form-control";
            $this->parfum->EditCustomAttributes = "";
            if (!$this->parfum->Raw) {
                $this->parfum->CurrentValue = HtmlDecode($this->parfum->CurrentValue);
            }
            $this->parfum->EditValue = HtmlEncode($this->parfum->CurrentValue);
            $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

            // catatan
            $this->catatan->EditAttrs["class"] = "form-control";
            $this->catatan->EditCustomAttributes = "";
            if (!$this->catatan->Raw) {
                $this->catatan->CurrentValue = HtmlDecode($this->catatan->CurrentValue);
            }
            $this->catatan->EditValue = HtmlEncode($this->catatan->CurrentValue);
            $this->catatan->PlaceHolder = RemoveHtml($this->catatan->caption());

            // rencanakemasan
            $this->rencanakemasan->EditAttrs["class"] = "form-control";
            $this->rencanakemasan->EditCustomAttributes = "";
            if (!$this->rencanakemasan->Raw) {
                $this->rencanakemasan->CurrentValue = HtmlDecode($this->rencanakemasan->CurrentValue);
            }
            $this->rencanakemasan->EditValue = HtmlEncode($this->rencanakemasan->CurrentValue);
            $this->rencanakemasan->PlaceHolder = RemoveHtml($this->rencanakemasan->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // ekspetasiharga
            $this->ekspetasiharga->EditAttrs["class"] = "form-control";
            $this->ekspetasiharga->EditCustomAttributes = "";
            $this->ekspetasiharga->EditValue = HtmlEncode($this->ekspetasiharga->CurrentValue);
            $this->ekspetasiharga->PlaceHolder = RemoveHtml($this->ekspetasiharga->caption());
            if (strval($this->ekspetasiharga->EditValue) != "" && is_numeric($this->ekspetasiharga->EditValue)) {
                $this->ekspetasiharga->EditValue = FormatNumber($this->ekspetasiharga->EditValue, -2, -2, -2, -2);
            }

            // kemasan
            $this->kemasan->EditAttrs["class"] = "form-control";
            $this->kemasan->EditCustomAttributes = "";
            if (!$this->kemasan->Raw) {
                $this->kemasan->CurrentValue = HtmlDecode($this->kemasan->CurrentValue);
            }
            $this->kemasan->EditValue = HtmlEncode($this->kemasan->CurrentValue);
            $this->kemasan->PlaceHolder = RemoveHtml($this->kemasan->caption());

            // volume
            $this->volume->EditAttrs["class"] = "form-control";
            $this->volume->EditCustomAttributes = "";
            $this->volume->EditValue = HtmlEncode($this->volume->CurrentValue);
            $this->volume->PlaceHolder = RemoveHtml($this->volume->caption());
            if (strval($this->volume->EditValue) != "" && is_numeric($this->volume->EditValue)) {
                $this->volume->EditValue = FormatNumber($this->volume->EditValue, -2, -2, -2, -2);
            }

            // jenistutup
            $this->jenistutup->EditAttrs["class"] = "form-control";
            $this->jenistutup->EditCustomAttributes = "";
            if (!$this->jenistutup->Raw) {
                $this->jenistutup->CurrentValue = HtmlDecode($this->jenistutup->CurrentValue);
            }
            $this->jenistutup->EditValue = HtmlEncode($this->jenistutup->CurrentValue);
            $this->jenistutup->PlaceHolder = RemoveHtml($this->jenistutup->caption());

            // catatanpackaging
            $this->catatanpackaging->EditAttrs["class"] = "form-control";
            $this->catatanpackaging->EditCustomAttributes = "";
            $this->catatanpackaging->EditValue = HtmlEncode($this->catatanpackaging->CurrentValue);
            $this->catatanpackaging->PlaceHolder = RemoveHtml($this->catatanpackaging->caption());

            // infopackaging
            $this->infopackaging->EditAttrs["class"] = "form-control";
            $this->infopackaging->EditCustomAttributes = "";
            if (!$this->infopackaging->Raw) {
                $this->infopackaging->CurrentValue = HtmlDecode($this->infopackaging->CurrentValue);
            }
            $this->infopackaging->EditValue = HtmlEncode($this->infopackaging->CurrentValue);
            $this->infopackaging->PlaceHolder = RemoveHtml($this->infopackaging->caption());

            // ukuran
            $this->ukuran->EditAttrs["class"] = "form-control";
            $this->ukuran->EditCustomAttributes = "";
            $this->ukuran->EditValue = HtmlEncode($this->ukuran->CurrentValue);
            $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

            // desainprodukkemasan
            $this->desainprodukkemasan->EditAttrs["class"] = "form-control";
            $this->desainprodukkemasan->EditCustomAttributes = "";
            if (!$this->desainprodukkemasan->Raw) {
                $this->desainprodukkemasan->CurrentValue = HtmlDecode($this->desainprodukkemasan->CurrentValue);
            }
            $this->desainprodukkemasan->EditValue = HtmlEncode($this->desainprodukkemasan->CurrentValue);
            $this->desainprodukkemasan->PlaceHolder = RemoveHtml($this->desainprodukkemasan->caption());

            // desaindiinginkan
            $this->desaindiinginkan->EditAttrs["class"] = "form-control";
            $this->desaindiinginkan->EditCustomAttributes = "";
            if (!$this->desaindiinginkan->Raw) {
                $this->desaindiinginkan->CurrentValue = HtmlDecode($this->desaindiinginkan->CurrentValue);
            }
            $this->desaindiinginkan->EditValue = HtmlEncode($this->desaindiinginkan->CurrentValue);
            $this->desaindiinginkan->PlaceHolder = RemoveHtml($this->desaindiinginkan->caption());

            // mereknotifikasi
            $this->mereknotifikasi->EditAttrs["class"] = "form-control";
            $this->mereknotifikasi->EditCustomAttributes = "";
            if (!$this->mereknotifikasi->Raw) {
                $this->mereknotifikasi->CurrentValue = HtmlDecode($this->mereknotifikasi->CurrentValue);
            }
            $this->mereknotifikasi->EditValue = HtmlEncode($this->mereknotifikasi->CurrentValue);
            $this->mereknotifikasi->PlaceHolder = RemoveHtml($this->mereknotifikasi->caption());

            // kategoristatus
            $this->kategoristatus->EditAttrs["class"] = "form-control";
            $this->kategoristatus->EditCustomAttributes = "";
            if (!$this->kategoristatus->Raw) {
                $this->kategoristatus->CurrentValue = HtmlDecode($this->kategoristatus->CurrentValue);
            }
            $this->kategoristatus->EditValue = HtmlEncode($this->kategoristatus->CurrentValue);
            $this->kategoristatus->PlaceHolder = RemoveHtml($this->kategoristatus->caption());

            // kemasan_ukuran_satuan
            $this->kemasan_ukuran_satuan->EditAttrs["class"] = "form-control";
            $this->kemasan_ukuran_satuan->EditCustomAttributes = "";
            if (!$this->kemasan_ukuran_satuan->Raw) {
                $this->kemasan_ukuran_satuan->CurrentValue = HtmlDecode($this->kemasan_ukuran_satuan->CurrentValue);
            }
            $this->kemasan_ukuran_satuan->EditValue = HtmlEncode($this->kemasan_ukuran_satuan->CurrentValue);
            $this->kemasan_ukuran_satuan->PlaceHolder = RemoveHtml($this->kemasan_ukuran_satuan->caption());

            // notifikasicatatan
            $this->notifikasicatatan->EditAttrs["class"] = "form-control";
            $this->notifikasicatatan->EditCustomAttributes = "";
            $this->notifikasicatatan->EditValue = HtmlEncode($this->notifikasicatatan->CurrentValue);
            $this->notifikasicatatan->PlaceHolder = RemoveHtml($this->notifikasicatatan->caption());

            // label_ukuran
            $this->label_ukuran->EditAttrs["class"] = "form-control";
            $this->label_ukuran->EditCustomAttributes = "";
            $this->label_ukuran->EditValue = HtmlEncode($this->label_ukuran->CurrentValue);
            $this->label_ukuran->PlaceHolder = RemoveHtml($this->label_ukuran->caption());

            // infolabel
            $this->infolabel->EditAttrs["class"] = "form-control";
            $this->infolabel->EditCustomAttributes = "";
            if (!$this->infolabel->Raw) {
                $this->infolabel->CurrentValue = HtmlDecode($this->infolabel->CurrentValue);
            }
            $this->infolabel->EditValue = HtmlEncode($this->infolabel->CurrentValue);
            $this->infolabel->PlaceHolder = RemoveHtml($this->infolabel->caption());

            // labelkualitas
            $this->labelkualitas->EditAttrs["class"] = "form-control";
            $this->labelkualitas->EditCustomAttributes = "";
            if (!$this->labelkualitas->Raw) {
                $this->labelkualitas->CurrentValue = HtmlDecode($this->labelkualitas->CurrentValue);
            }
            $this->labelkualitas->EditValue = HtmlEncode($this->labelkualitas->CurrentValue);
            $this->labelkualitas->PlaceHolder = RemoveHtml($this->labelkualitas->caption());

            // labelposisi
            $this->labelposisi->EditAttrs["class"] = "form-control";
            $this->labelposisi->EditCustomAttributes = "";
            if (!$this->labelposisi->Raw) {
                $this->labelposisi->CurrentValue = HtmlDecode($this->labelposisi->CurrentValue);
            }
            $this->labelposisi->EditValue = HtmlEncode($this->labelposisi->CurrentValue);
            $this->labelposisi->PlaceHolder = RemoveHtml($this->labelposisi->caption());

            // labelcatatan
            $this->labelcatatan->EditAttrs["class"] = "form-control";
            $this->labelcatatan->EditCustomAttributes = "";
            $this->labelcatatan->EditValue = HtmlEncode($this->labelcatatan->CurrentValue);
            $this->labelcatatan->PlaceHolder = RemoveHtml($this->labelcatatan->caption());

            // dibuatdi
            $this->dibuatdi->EditAttrs["class"] = "form-control";
            $this->dibuatdi->EditCustomAttributes = "";
            if (!$this->dibuatdi->Raw) {
                $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
            }
            $this->dibuatdi->EditValue = HtmlEncode($this->dibuatdi->CurrentValue);
            $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

            // tanggal
            $this->tanggal->EditAttrs["class"] = "form-control";
            $this->tanggal->EditCustomAttributes = "";
            $this->tanggal->EditValue = HtmlEncode(FormatDateTime($this->tanggal->CurrentValue, 8));
            $this->tanggal->PlaceHolder = RemoveHtml($this->tanggal->caption());

            // penerima
            $this->penerima->EditAttrs["class"] = "form-control";
            $this->penerima->EditCustomAttributes = "";
            $this->penerima->EditValue = HtmlEncode($this->penerima->CurrentValue);
            $this->penerima->PlaceHolder = RemoveHtml($this->penerima->caption());

            // createat
            $this->createat->EditAttrs["class"] = "form-control";
            $this->createat->EditCustomAttributes = "";
            $this->createat->EditValue = HtmlEncode(FormatDateTime($this->createat->CurrentValue, 8));
            $this->createat->PlaceHolder = RemoveHtml($this->createat->caption());

            // createby
            $this->createby->EditAttrs["class"] = "form-control";
            $this->createby->EditCustomAttributes = "";
            $this->createby->EditValue = HtmlEncode($this->createby->CurrentValue);
            $this->createby->PlaceHolder = RemoveHtml($this->createby->caption());

            // statusdokumen
            $this->statusdokumen->EditAttrs["class"] = "form-control";
            $this->statusdokumen->EditCustomAttributes = "";
            if (!$this->statusdokumen->Raw) {
                $this->statusdokumen->CurrentValue = HtmlDecode($this->statusdokumen->CurrentValue);
            }
            $this->statusdokumen->EditValue = HtmlEncode($this->statusdokumen->CurrentValue);
            $this->statusdokumen->PlaceHolder = RemoveHtml($this->statusdokumen->caption());

            // update_at
            $this->update_at->EditAttrs["class"] = "form-control";
            $this->update_at->EditCustomAttributes = "";
            $this->update_at->EditValue = HtmlEncode(FormatDateTime($this->update_at->CurrentValue, 8));
            $this->update_at->PlaceHolder = RemoveHtml($this->update_at->caption());

            // status_data
            $this->status_data->EditAttrs["class"] = "form-control";
            $this->status_data->EditCustomAttributes = "";
            if (!$this->status_data->Raw) {
                $this->status_data->CurrentValue = HtmlDecode($this->status_data->CurrentValue);
            }
            $this->status_data->EditValue = HtmlEncode($this->status_data->CurrentValue);
            $this->status_data->PlaceHolder = RemoveHtml($this->status_data->caption());

            // harga_rnd
            $this->harga_rnd->EditAttrs["class"] = "form-control";
            $this->harga_rnd->EditCustomAttributes = "";
            $this->harga_rnd->EditValue = HtmlEncode($this->harga_rnd->CurrentValue);
            $this->harga_rnd->PlaceHolder = RemoveHtml($this->harga_rnd->caption());
            if (strval($this->harga_rnd->EditValue) != "" && is_numeric($this->harga_rnd->EditValue)) {
                $this->harga_rnd->EditValue = FormatNumber($this->harga_rnd->EditValue, -2, -2, -2, -2);
            }

            // aplikasi_sediaan
            $this->aplikasi_sediaan->EditAttrs["class"] = "form-control";
            $this->aplikasi_sediaan->EditCustomAttributes = "";
            if (!$this->aplikasi_sediaan->Raw) {
                $this->aplikasi_sediaan->CurrentValue = HtmlDecode($this->aplikasi_sediaan->CurrentValue);
            }
            $this->aplikasi_sediaan->EditValue = HtmlEncode($this->aplikasi_sediaan->CurrentValue);
            $this->aplikasi_sediaan->PlaceHolder = RemoveHtml($this->aplikasi_sediaan->caption());

            // hu_hrg_isi
            $this->hu_hrg_isi->EditAttrs["class"] = "form-control";
            $this->hu_hrg_isi->EditCustomAttributes = "";
            $this->hu_hrg_isi->EditValue = HtmlEncode($this->hu_hrg_isi->CurrentValue);
            $this->hu_hrg_isi->PlaceHolder = RemoveHtml($this->hu_hrg_isi->caption());
            if (strval($this->hu_hrg_isi->EditValue) != "" && is_numeric($this->hu_hrg_isi->EditValue)) {
                $this->hu_hrg_isi->EditValue = FormatNumber($this->hu_hrg_isi->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_isi_pro
            $this->hu_hrg_isi_pro->EditAttrs["class"] = "form-control";
            $this->hu_hrg_isi_pro->EditCustomAttributes = "";
            $this->hu_hrg_isi_pro->EditValue = HtmlEncode($this->hu_hrg_isi_pro->CurrentValue);
            $this->hu_hrg_isi_pro->PlaceHolder = RemoveHtml($this->hu_hrg_isi_pro->caption());
            if (strval($this->hu_hrg_isi_pro->EditValue) != "" && is_numeric($this->hu_hrg_isi_pro->EditValue)) {
                $this->hu_hrg_isi_pro->EditValue = FormatNumber($this->hu_hrg_isi_pro->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_kms_primer
            $this->hu_hrg_kms_primer->EditAttrs["class"] = "form-control";
            $this->hu_hrg_kms_primer->EditCustomAttributes = "";
            $this->hu_hrg_kms_primer->EditValue = HtmlEncode($this->hu_hrg_kms_primer->CurrentValue);
            $this->hu_hrg_kms_primer->PlaceHolder = RemoveHtml($this->hu_hrg_kms_primer->caption());
            if (strval($this->hu_hrg_kms_primer->EditValue) != "" && is_numeric($this->hu_hrg_kms_primer->EditValue)) {
                $this->hu_hrg_kms_primer->EditValue = FormatNumber($this->hu_hrg_kms_primer->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_kms_primer_pro
            $this->hu_hrg_kms_primer_pro->EditAttrs["class"] = "form-control";
            $this->hu_hrg_kms_primer_pro->EditCustomAttributes = "";
            $this->hu_hrg_kms_primer_pro->EditValue = HtmlEncode($this->hu_hrg_kms_primer_pro->CurrentValue);
            $this->hu_hrg_kms_primer_pro->PlaceHolder = RemoveHtml($this->hu_hrg_kms_primer_pro->caption());
            if (strval($this->hu_hrg_kms_primer_pro->EditValue) != "" && is_numeric($this->hu_hrg_kms_primer_pro->EditValue)) {
                $this->hu_hrg_kms_primer_pro->EditValue = FormatNumber($this->hu_hrg_kms_primer_pro->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_kms_sekunder
            $this->hu_hrg_kms_sekunder->EditAttrs["class"] = "form-control";
            $this->hu_hrg_kms_sekunder->EditCustomAttributes = "";
            $this->hu_hrg_kms_sekunder->EditValue = HtmlEncode($this->hu_hrg_kms_sekunder->CurrentValue);
            $this->hu_hrg_kms_sekunder->PlaceHolder = RemoveHtml($this->hu_hrg_kms_sekunder->caption());
            if (strval($this->hu_hrg_kms_sekunder->EditValue) != "" && is_numeric($this->hu_hrg_kms_sekunder->EditValue)) {
                $this->hu_hrg_kms_sekunder->EditValue = FormatNumber($this->hu_hrg_kms_sekunder->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_kms_sekunder_pro
            $this->hu_hrg_kms_sekunder_pro->EditAttrs["class"] = "form-control";
            $this->hu_hrg_kms_sekunder_pro->EditCustomAttributes = "";
            $this->hu_hrg_kms_sekunder_pro->EditValue = HtmlEncode($this->hu_hrg_kms_sekunder_pro->CurrentValue);
            $this->hu_hrg_kms_sekunder_pro->PlaceHolder = RemoveHtml($this->hu_hrg_kms_sekunder_pro->caption());
            if (strval($this->hu_hrg_kms_sekunder_pro->EditValue) != "" && is_numeric($this->hu_hrg_kms_sekunder_pro->EditValue)) {
                $this->hu_hrg_kms_sekunder_pro->EditValue = FormatNumber($this->hu_hrg_kms_sekunder_pro->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_label
            $this->hu_hrg_label->EditAttrs["class"] = "form-control";
            $this->hu_hrg_label->EditCustomAttributes = "";
            $this->hu_hrg_label->EditValue = HtmlEncode($this->hu_hrg_label->CurrentValue);
            $this->hu_hrg_label->PlaceHolder = RemoveHtml($this->hu_hrg_label->caption());
            if (strval($this->hu_hrg_label->EditValue) != "" && is_numeric($this->hu_hrg_label->EditValue)) {
                $this->hu_hrg_label->EditValue = FormatNumber($this->hu_hrg_label->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_label_pro
            $this->hu_hrg_label_pro->EditAttrs["class"] = "form-control";
            $this->hu_hrg_label_pro->EditCustomAttributes = "";
            $this->hu_hrg_label_pro->EditValue = HtmlEncode($this->hu_hrg_label_pro->CurrentValue);
            $this->hu_hrg_label_pro->PlaceHolder = RemoveHtml($this->hu_hrg_label_pro->caption());
            if (strval($this->hu_hrg_label_pro->EditValue) != "" && is_numeric($this->hu_hrg_label_pro->EditValue)) {
                $this->hu_hrg_label_pro->EditValue = FormatNumber($this->hu_hrg_label_pro->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_total
            $this->hu_hrg_total->EditAttrs["class"] = "form-control";
            $this->hu_hrg_total->EditCustomAttributes = "";
            $this->hu_hrg_total->EditValue = HtmlEncode($this->hu_hrg_total->CurrentValue);
            $this->hu_hrg_total->PlaceHolder = RemoveHtml($this->hu_hrg_total->caption());
            if (strval($this->hu_hrg_total->EditValue) != "" && is_numeric($this->hu_hrg_total->EditValue)) {
                $this->hu_hrg_total->EditValue = FormatNumber($this->hu_hrg_total->EditValue, -2, -2, -2, -2);
            }

            // hu_hrg_total_pro
            $this->hu_hrg_total_pro->EditAttrs["class"] = "form-control";
            $this->hu_hrg_total_pro->EditCustomAttributes = "";
            $this->hu_hrg_total_pro->EditValue = HtmlEncode($this->hu_hrg_total_pro->CurrentValue);
            $this->hu_hrg_total_pro->PlaceHolder = RemoveHtml($this->hu_hrg_total_pro->caption());
            if (strval($this->hu_hrg_total_pro->EditValue) != "" && is_numeric($this->hu_hrg_total_pro->EditValue)) {
                $this->hu_hrg_total_pro->EditValue = FormatNumber($this->hu_hrg_total_pro->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_isi
            $this->hl_hrg_isi->EditAttrs["class"] = "form-control";
            $this->hl_hrg_isi->EditCustomAttributes = "";
            $this->hl_hrg_isi->EditValue = HtmlEncode($this->hl_hrg_isi->CurrentValue);
            $this->hl_hrg_isi->PlaceHolder = RemoveHtml($this->hl_hrg_isi->caption());
            if (strval($this->hl_hrg_isi->EditValue) != "" && is_numeric($this->hl_hrg_isi->EditValue)) {
                $this->hl_hrg_isi->EditValue = FormatNumber($this->hl_hrg_isi->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_isi_pro
            $this->hl_hrg_isi_pro->EditAttrs["class"] = "form-control";
            $this->hl_hrg_isi_pro->EditCustomAttributes = "";
            $this->hl_hrg_isi_pro->EditValue = HtmlEncode($this->hl_hrg_isi_pro->CurrentValue);
            $this->hl_hrg_isi_pro->PlaceHolder = RemoveHtml($this->hl_hrg_isi_pro->caption());
            if (strval($this->hl_hrg_isi_pro->EditValue) != "" && is_numeric($this->hl_hrg_isi_pro->EditValue)) {
                $this->hl_hrg_isi_pro->EditValue = FormatNumber($this->hl_hrg_isi_pro->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_kms_primer
            $this->hl_hrg_kms_primer->EditAttrs["class"] = "form-control";
            $this->hl_hrg_kms_primer->EditCustomAttributes = "";
            $this->hl_hrg_kms_primer->EditValue = HtmlEncode($this->hl_hrg_kms_primer->CurrentValue);
            $this->hl_hrg_kms_primer->PlaceHolder = RemoveHtml($this->hl_hrg_kms_primer->caption());
            if (strval($this->hl_hrg_kms_primer->EditValue) != "" && is_numeric($this->hl_hrg_kms_primer->EditValue)) {
                $this->hl_hrg_kms_primer->EditValue = FormatNumber($this->hl_hrg_kms_primer->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_kms_primer_pro
            $this->hl_hrg_kms_primer_pro->EditAttrs["class"] = "form-control";
            $this->hl_hrg_kms_primer_pro->EditCustomAttributes = "";
            $this->hl_hrg_kms_primer_pro->EditValue = HtmlEncode($this->hl_hrg_kms_primer_pro->CurrentValue);
            $this->hl_hrg_kms_primer_pro->PlaceHolder = RemoveHtml($this->hl_hrg_kms_primer_pro->caption());
            if (strval($this->hl_hrg_kms_primer_pro->EditValue) != "" && is_numeric($this->hl_hrg_kms_primer_pro->EditValue)) {
                $this->hl_hrg_kms_primer_pro->EditValue = FormatNumber($this->hl_hrg_kms_primer_pro->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_kms_sekunder
            $this->hl_hrg_kms_sekunder->EditAttrs["class"] = "form-control";
            $this->hl_hrg_kms_sekunder->EditCustomAttributes = "";
            $this->hl_hrg_kms_sekunder->EditValue = HtmlEncode($this->hl_hrg_kms_sekunder->CurrentValue);
            $this->hl_hrg_kms_sekunder->PlaceHolder = RemoveHtml($this->hl_hrg_kms_sekunder->caption());
            if (strval($this->hl_hrg_kms_sekunder->EditValue) != "" && is_numeric($this->hl_hrg_kms_sekunder->EditValue)) {
                $this->hl_hrg_kms_sekunder->EditValue = FormatNumber($this->hl_hrg_kms_sekunder->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_kms_sekunder_pro
            $this->hl_hrg_kms_sekunder_pro->EditAttrs["class"] = "form-control";
            $this->hl_hrg_kms_sekunder_pro->EditCustomAttributes = "";
            $this->hl_hrg_kms_sekunder_pro->EditValue = HtmlEncode($this->hl_hrg_kms_sekunder_pro->CurrentValue);
            $this->hl_hrg_kms_sekunder_pro->PlaceHolder = RemoveHtml($this->hl_hrg_kms_sekunder_pro->caption());
            if (strval($this->hl_hrg_kms_sekunder_pro->EditValue) != "" && is_numeric($this->hl_hrg_kms_sekunder_pro->EditValue)) {
                $this->hl_hrg_kms_sekunder_pro->EditValue = FormatNumber($this->hl_hrg_kms_sekunder_pro->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_label
            $this->hl_hrg_label->EditAttrs["class"] = "form-control";
            $this->hl_hrg_label->EditCustomAttributes = "";
            $this->hl_hrg_label->EditValue = HtmlEncode($this->hl_hrg_label->CurrentValue);
            $this->hl_hrg_label->PlaceHolder = RemoveHtml($this->hl_hrg_label->caption());
            if (strval($this->hl_hrg_label->EditValue) != "" && is_numeric($this->hl_hrg_label->EditValue)) {
                $this->hl_hrg_label->EditValue = FormatNumber($this->hl_hrg_label->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_label_pro
            $this->hl_hrg_label_pro->EditAttrs["class"] = "form-control";
            $this->hl_hrg_label_pro->EditCustomAttributes = "";
            $this->hl_hrg_label_pro->EditValue = HtmlEncode($this->hl_hrg_label_pro->CurrentValue);
            $this->hl_hrg_label_pro->PlaceHolder = RemoveHtml($this->hl_hrg_label_pro->caption());
            if (strval($this->hl_hrg_label_pro->EditValue) != "" && is_numeric($this->hl_hrg_label_pro->EditValue)) {
                $this->hl_hrg_label_pro->EditValue = FormatNumber($this->hl_hrg_label_pro->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_total
            $this->hl_hrg_total->EditAttrs["class"] = "form-control";
            $this->hl_hrg_total->EditCustomAttributes = "";
            $this->hl_hrg_total->EditValue = HtmlEncode($this->hl_hrg_total->CurrentValue);
            $this->hl_hrg_total->PlaceHolder = RemoveHtml($this->hl_hrg_total->caption());
            if (strval($this->hl_hrg_total->EditValue) != "" && is_numeric($this->hl_hrg_total->EditValue)) {
                $this->hl_hrg_total->EditValue = FormatNumber($this->hl_hrg_total->EditValue, -2, -2, -2, -2);
            }

            // hl_hrg_total_pro
            $this->hl_hrg_total_pro->EditAttrs["class"] = "form-control";
            $this->hl_hrg_total_pro->EditCustomAttributes = "";
            $this->hl_hrg_total_pro->EditValue = HtmlEncode($this->hl_hrg_total_pro->CurrentValue);
            $this->hl_hrg_total_pro->PlaceHolder = RemoveHtml($this->hl_hrg_total_pro->caption());
            if (strval($this->hl_hrg_total_pro->EditValue) != "" && is_numeric($this->hl_hrg_total_pro->EditValue)) {
                $this->hl_hrg_total_pro->EditValue = FormatNumber($this->hl_hrg_total_pro->EditValue, -2, -2, -2, -2);
            }

            // bs_bahan_aktif_tick
            $this->bs_bahan_aktif_tick->EditAttrs["class"] = "form-control";
            $this->bs_bahan_aktif_tick->EditCustomAttributes = "";
            if (!$this->bs_bahan_aktif_tick->Raw) {
                $this->bs_bahan_aktif_tick->CurrentValue = HtmlDecode($this->bs_bahan_aktif_tick->CurrentValue);
            }
            $this->bs_bahan_aktif_tick->EditValue = HtmlEncode($this->bs_bahan_aktif_tick->CurrentValue);
            $this->bs_bahan_aktif_tick->PlaceHolder = RemoveHtml($this->bs_bahan_aktif_tick->caption());

            // bs_bahan_aktif
            $this->bs_bahan_aktif->EditAttrs["class"] = "form-control";
            $this->bs_bahan_aktif->EditCustomAttributes = "";
            $this->bs_bahan_aktif->EditValue = HtmlEncode($this->bs_bahan_aktif->CurrentValue);
            $this->bs_bahan_aktif->PlaceHolder = RemoveHtml($this->bs_bahan_aktif->caption());

            // bs_bahan_lain
            $this->bs_bahan_lain->EditAttrs["class"] = "form-control";
            $this->bs_bahan_lain->EditCustomAttributes = "";
            $this->bs_bahan_lain->EditValue = HtmlEncode($this->bs_bahan_lain->CurrentValue);
            $this->bs_bahan_lain->PlaceHolder = RemoveHtml($this->bs_bahan_lain->caption());

            // bs_parfum
            $this->bs_parfum->EditAttrs["class"] = "form-control";
            $this->bs_parfum->EditCustomAttributes = "";
            $this->bs_parfum->EditValue = HtmlEncode($this->bs_parfum->CurrentValue);
            $this->bs_parfum->PlaceHolder = RemoveHtml($this->bs_parfum->caption());

            // bs_estetika
            $this->bs_estetika->EditAttrs["class"] = "form-control";
            $this->bs_estetika->EditCustomAttributes = "";
            $this->bs_estetika->EditValue = HtmlEncode($this->bs_estetika->CurrentValue);
            $this->bs_estetika->PlaceHolder = RemoveHtml($this->bs_estetika->caption());

            // bs_kms_wadah
            $this->bs_kms_wadah->EditAttrs["class"] = "form-control";
            $this->bs_kms_wadah->EditCustomAttributes = "";
            $this->bs_kms_wadah->EditValue = HtmlEncode($this->bs_kms_wadah->CurrentValue);
            $this->bs_kms_wadah->PlaceHolder = RemoveHtml($this->bs_kms_wadah->caption());

            // bs_kms_tutup
            $this->bs_kms_tutup->EditAttrs["class"] = "form-control";
            $this->bs_kms_tutup->EditCustomAttributes = "";
            $this->bs_kms_tutup->EditValue = HtmlEncode($this->bs_kms_tutup->CurrentValue);
            $this->bs_kms_tutup->PlaceHolder = RemoveHtml($this->bs_kms_tutup->caption());

            // bs_kms_sekunder
            $this->bs_kms_sekunder->EditAttrs["class"] = "form-control";
            $this->bs_kms_sekunder->EditCustomAttributes = "";
            $this->bs_kms_sekunder->EditValue = HtmlEncode($this->bs_kms_sekunder->CurrentValue);
            $this->bs_kms_sekunder->PlaceHolder = RemoveHtml($this->bs_kms_sekunder->caption());

            // bs_label_desain
            $this->bs_label_desain->EditAttrs["class"] = "form-control";
            $this->bs_label_desain->EditCustomAttributes = "";
            $this->bs_label_desain->EditValue = HtmlEncode($this->bs_label_desain->CurrentValue);
            $this->bs_label_desain->PlaceHolder = RemoveHtml($this->bs_label_desain->caption());

            // bs_label_cetak
            $this->bs_label_cetak->EditAttrs["class"] = "form-control";
            $this->bs_label_cetak->EditCustomAttributes = "";
            $this->bs_label_cetak->EditValue = HtmlEncode($this->bs_label_cetak->CurrentValue);
            $this->bs_label_cetak->PlaceHolder = RemoveHtml($this->bs_label_cetak->caption());

            // bs_label_lain
            $this->bs_label_lain->EditAttrs["class"] = "form-control";
            $this->bs_label_lain->EditCustomAttributes = "";
            $this->bs_label_lain->EditValue = HtmlEncode($this->bs_label_lain->CurrentValue);
            $this->bs_label_lain->PlaceHolder = RemoveHtml($this->bs_label_lain->caption());

            // dlv_pickup
            $this->dlv_pickup->EditAttrs["class"] = "form-control";
            $this->dlv_pickup->EditCustomAttributes = "";
            $this->dlv_pickup->EditValue = HtmlEncode($this->dlv_pickup->CurrentValue);
            $this->dlv_pickup->PlaceHolder = RemoveHtml($this->dlv_pickup->caption());

            // dlv_singlepoint
            $this->dlv_singlepoint->EditAttrs["class"] = "form-control";
            $this->dlv_singlepoint->EditCustomAttributes = "";
            $this->dlv_singlepoint->EditValue = HtmlEncode($this->dlv_singlepoint->CurrentValue);
            $this->dlv_singlepoint->PlaceHolder = RemoveHtml($this->dlv_singlepoint->caption());

            // dlv_multipoint
            $this->dlv_multipoint->EditAttrs["class"] = "form-control";
            $this->dlv_multipoint->EditCustomAttributes = "";
            $this->dlv_multipoint->EditValue = HtmlEncode($this->dlv_multipoint->CurrentValue);
            $this->dlv_multipoint->PlaceHolder = RemoveHtml($this->dlv_multipoint->caption());

            // dlv_multipoint_jml
            $this->dlv_multipoint_jml->EditAttrs["class"] = "form-control";
            $this->dlv_multipoint_jml->EditCustomAttributes = "";
            $this->dlv_multipoint_jml->EditValue = HtmlEncode($this->dlv_multipoint_jml->CurrentValue);
            $this->dlv_multipoint_jml->PlaceHolder = RemoveHtml($this->dlv_multipoint_jml->caption());

            // dlv_term_lain
            $this->dlv_term_lain->EditAttrs["class"] = "form-control";
            $this->dlv_term_lain->EditCustomAttributes = "";
            $this->dlv_term_lain->EditValue = HtmlEncode($this->dlv_term_lain->CurrentValue);
            $this->dlv_term_lain->PlaceHolder = RemoveHtml($this->dlv_term_lain->caption());

            // catatan_khusus
            $this->catatan_khusus->EditAttrs["class"] = "form-control";
            $this->catatan_khusus->EditCustomAttributes = "";
            $this->catatan_khusus->EditValue = HtmlEncode($this->catatan_khusus->CurrentValue);
            $this->catatan_khusus->PlaceHolder = RemoveHtml($this->catatan_khusus->caption());

            // aju_tgl
            $this->aju_tgl->EditAttrs["class"] = "form-control";
            $this->aju_tgl->EditCustomAttributes = "";
            $this->aju_tgl->EditValue = HtmlEncode(FormatDateTime($this->aju_tgl->CurrentValue, 8));
            $this->aju_tgl->PlaceHolder = RemoveHtml($this->aju_tgl->caption());

            // aju_oleh
            $this->aju_oleh->EditAttrs["class"] = "form-control";
            $this->aju_oleh->EditCustomAttributes = "";
            $this->aju_oleh->EditValue = HtmlEncode($this->aju_oleh->CurrentValue);
            $this->aju_oleh->PlaceHolder = RemoveHtml($this->aju_oleh->caption());

            // proses_tgl
            $this->proses_tgl->EditAttrs["class"] = "form-control";
            $this->proses_tgl->EditCustomAttributes = "";
            $this->proses_tgl->EditValue = HtmlEncode(FormatDateTime($this->proses_tgl->CurrentValue, 8));
            $this->proses_tgl->PlaceHolder = RemoveHtml($this->proses_tgl->caption());

            // proses_oleh
            $this->proses_oleh->EditAttrs["class"] = "form-control";
            $this->proses_oleh->EditCustomAttributes = "";
            $this->proses_oleh->EditValue = HtmlEncode($this->proses_oleh->CurrentValue);
            $this->proses_oleh->PlaceHolder = RemoveHtml($this->proses_oleh->caption());

            // revisi_tgl
            $this->revisi_tgl->EditAttrs["class"] = "form-control";
            $this->revisi_tgl->EditCustomAttributes = "";
            $this->revisi_tgl->EditValue = HtmlEncode(FormatDateTime($this->revisi_tgl->CurrentValue, 8));
            $this->revisi_tgl->PlaceHolder = RemoveHtml($this->revisi_tgl->caption());

            // revisi_oleh
            $this->revisi_oleh->EditAttrs["class"] = "form-control";
            $this->revisi_oleh->EditCustomAttributes = "";
            $this->revisi_oleh->EditValue = HtmlEncode($this->revisi_oleh->CurrentValue);
            $this->revisi_oleh->PlaceHolder = RemoveHtml($this->revisi_oleh->caption());

            // revisi_akun_tgl
            $this->revisi_akun_tgl->EditAttrs["class"] = "form-control";
            $this->revisi_akun_tgl->EditCustomAttributes = "";
            $this->revisi_akun_tgl->EditValue = HtmlEncode(FormatDateTime($this->revisi_akun_tgl->CurrentValue, 8));
            $this->revisi_akun_tgl->PlaceHolder = RemoveHtml($this->revisi_akun_tgl->caption());

            // revisi_akun_oleh
            $this->revisi_akun_oleh->EditAttrs["class"] = "form-control";
            $this->revisi_akun_oleh->EditCustomAttributes = "";
            $this->revisi_akun_oleh->EditValue = HtmlEncode($this->revisi_akun_oleh->CurrentValue);
            $this->revisi_akun_oleh->PlaceHolder = RemoveHtml($this->revisi_akun_oleh->caption());

            // revisi_rnd_tgl
            $this->revisi_rnd_tgl->EditAttrs["class"] = "form-control";
            $this->revisi_rnd_tgl->EditCustomAttributes = "";
            $this->revisi_rnd_tgl->EditValue = HtmlEncode(FormatDateTime($this->revisi_rnd_tgl->CurrentValue, 8));
            $this->revisi_rnd_tgl->PlaceHolder = RemoveHtml($this->revisi_rnd_tgl->caption());

            // revisi_rnd_oleh
            $this->revisi_rnd_oleh->EditAttrs["class"] = "form-control";
            $this->revisi_rnd_oleh->EditCustomAttributes = "";
            $this->revisi_rnd_oleh->EditValue = HtmlEncode($this->revisi_rnd_oleh->CurrentValue);
            $this->revisi_rnd_oleh->PlaceHolder = RemoveHtml($this->revisi_rnd_oleh->caption());

            // rnd_tgl
            $this->rnd_tgl->EditAttrs["class"] = "form-control";
            $this->rnd_tgl->EditCustomAttributes = "";
            $this->rnd_tgl->EditValue = HtmlEncode(FormatDateTime($this->rnd_tgl->CurrentValue, 8));
            $this->rnd_tgl->PlaceHolder = RemoveHtml($this->rnd_tgl->caption());

            // rnd_oleh
            $this->rnd_oleh->EditAttrs["class"] = "form-control";
            $this->rnd_oleh->EditCustomAttributes = "";
            $this->rnd_oleh->EditValue = HtmlEncode($this->rnd_oleh->CurrentValue);
            $this->rnd_oleh->PlaceHolder = RemoveHtml($this->rnd_oleh->caption());

            // ap_tgl
            $this->ap_tgl->EditAttrs["class"] = "form-control";
            $this->ap_tgl->EditCustomAttributes = "";
            $this->ap_tgl->EditValue = HtmlEncode(FormatDateTime($this->ap_tgl->CurrentValue, 8));
            $this->ap_tgl->PlaceHolder = RemoveHtml($this->ap_tgl->caption());

            // ap_oleh
            $this->ap_oleh->EditAttrs["class"] = "form-control";
            $this->ap_oleh->EditCustomAttributes = "";
            $this->ap_oleh->EditValue = HtmlEncode($this->ap_oleh->CurrentValue);
            $this->ap_oleh->PlaceHolder = RemoveHtml($this->ap_oleh->caption());

            // batal_tgl
            $this->batal_tgl->EditAttrs["class"] = "form-control";
            $this->batal_tgl->EditCustomAttributes = "";
            $this->batal_tgl->EditValue = HtmlEncode(FormatDateTime($this->batal_tgl->CurrentValue, 8));
            $this->batal_tgl->PlaceHolder = RemoveHtml($this->batal_tgl->caption());

            // batal_oleh
            $this->batal_oleh->EditAttrs["class"] = "form-control";
            $this->batal_oleh->EditCustomAttributes = "";
            $this->batal_oleh->EditValue = HtmlEncode($this->batal_oleh->CurrentValue);
            $this->batal_oleh->PlaceHolder = RemoveHtml($this->batal_oleh->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // cpo_jenis
            $this->cpo_jenis->LinkCustomAttributes = "";
            $this->cpo_jenis->HrefValue = "";

            // ordernum
            $this->ordernum->LinkCustomAttributes = "";
            $this->ordernum->HrefValue = "";

            // order_kode
            $this->order_kode->LinkCustomAttributes = "";
            $this->order_kode->HrefValue = "";

            // orderterimatgl
            $this->orderterimatgl->LinkCustomAttributes = "";
            $this->orderterimatgl->HrefValue = "";

            // produk_fungsi
            $this->produk_fungsi->LinkCustomAttributes = "";
            $this->produk_fungsi->HrefValue = "";

            // produk_kualitas
            $this->produk_kualitas->LinkCustomAttributes = "";
            $this->produk_kualitas->HrefValue = "";

            // produk_campaign
            $this->produk_campaign->LinkCustomAttributes = "";
            $this->produk_campaign->HrefValue = "";

            // kemasan_satuan
            $this->kemasan_satuan->LinkCustomAttributes = "";
            $this->kemasan_satuan->HrefValue = "";

            // ordertgl
            $this->ordertgl->LinkCustomAttributes = "";
            $this->ordertgl->HrefValue = "";

            // custcode
            $this->custcode->LinkCustomAttributes = "";
            $this->custcode->HrefValue = "";

            // perushnama
            $this->perushnama->LinkCustomAttributes = "";
            $this->perushnama->HrefValue = "";

            // perushalamat
            $this->perushalamat->LinkCustomAttributes = "";
            $this->perushalamat->HrefValue = "";

            // perushcp
            $this->perushcp->LinkCustomAttributes = "";
            $this->perushcp->HrefValue = "";

            // perushjabatan
            $this->perushjabatan->LinkCustomAttributes = "";
            $this->perushjabatan->HrefValue = "";

            // perushphone
            $this->perushphone->LinkCustomAttributes = "";
            $this->perushphone->HrefValue = "";

            // perushmobile
            $this->perushmobile->LinkCustomAttributes = "";
            $this->perushmobile->HrefValue = "";

            // bencmark
            $this->bencmark->LinkCustomAttributes = "";
            $this->bencmark->HrefValue = "";

            // kategoriproduk
            $this->kategoriproduk->LinkCustomAttributes = "";
            $this->kategoriproduk->HrefValue = "";

            // jenisproduk
            $this->jenisproduk->LinkCustomAttributes = "";
            $this->jenisproduk->HrefValue = "";

            // bentuksediaan
            $this->bentuksediaan->LinkCustomAttributes = "";
            $this->bentuksediaan->HrefValue = "";

            // sediaan_ukuran
            $this->sediaan_ukuran->LinkCustomAttributes = "";
            $this->sediaan_ukuran->HrefValue = "";

            // sediaan_ukuran_satuan
            $this->sediaan_ukuran_satuan->LinkCustomAttributes = "";
            $this->sediaan_ukuran_satuan->HrefValue = "";

            // produk_viskositas
            $this->produk_viskositas->LinkCustomAttributes = "";
            $this->produk_viskositas->HrefValue = "";

            // konsepproduk
            $this->konsepproduk->LinkCustomAttributes = "";
            $this->konsepproduk->HrefValue = "";

            // fragrance
            $this->fragrance->LinkCustomAttributes = "";
            $this->fragrance->HrefValue = "";

            // aroma
            $this->aroma->LinkCustomAttributes = "";
            $this->aroma->HrefValue = "";

            // bahanaktif
            $this->bahanaktif->LinkCustomAttributes = "";
            $this->bahanaktif->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // produk_warna_jenis
            $this->produk_warna_jenis->LinkCustomAttributes = "";
            $this->produk_warna_jenis->HrefValue = "";

            // aksesoris
            $this->aksesoris->LinkCustomAttributes = "";
            $this->aksesoris->HrefValue = "";

            // produk_lainlain
            $this->produk_lainlain->LinkCustomAttributes = "";
            $this->produk_lainlain->HrefValue = "";

            // statusproduk
            $this->statusproduk->LinkCustomAttributes = "";
            $this->statusproduk->HrefValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";

            // catatan
            $this->catatan->LinkCustomAttributes = "";
            $this->catatan->HrefValue = "";

            // rencanakemasan
            $this->rencanakemasan->LinkCustomAttributes = "";
            $this->rencanakemasan->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";

            // ekspetasiharga
            $this->ekspetasiharga->LinkCustomAttributes = "";
            $this->ekspetasiharga->HrefValue = "";

            // kemasan
            $this->kemasan->LinkCustomAttributes = "";
            $this->kemasan->HrefValue = "";

            // volume
            $this->volume->LinkCustomAttributes = "";
            $this->volume->HrefValue = "";

            // jenistutup
            $this->jenistutup->LinkCustomAttributes = "";
            $this->jenistutup->HrefValue = "";

            // catatanpackaging
            $this->catatanpackaging->LinkCustomAttributes = "";
            $this->catatanpackaging->HrefValue = "";

            // infopackaging
            $this->infopackaging->LinkCustomAttributes = "";
            $this->infopackaging->HrefValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";

            // desainprodukkemasan
            $this->desainprodukkemasan->LinkCustomAttributes = "";
            $this->desainprodukkemasan->HrefValue = "";

            // desaindiinginkan
            $this->desaindiinginkan->LinkCustomAttributes = "";
            $this->desaindiinginkan->HrefValue = "";

            // mereknotifikasi
            $this->mereknotifikasi->LinkCustomAttributes = "";
            $this->mereknotifikasi->HrefValue = "";

            // kategoristatus
            $this->kategoristatus->LinkCustomAttributes = "";
            $this->kategoristatus->HrefValue = "";

            // kemasan_ukuran_satuan
            $this->kemasan_ukuran_satuan->LinkCustomAttributes = "";
            $this->kemasan_ukuran_satuan->HrefValue = "";

            // notifikasicatatan
            $this->notifikasicatatan->LinkCustomAttributes = "";
            $this->notifikasicatatan->HrefValue = "";

            // label_ukuran
            $this->label_ukuran->LinkCustomAttributes = "";
            $this->label_ukuran->HrefValue = "";

            // infolabel
            $this->infolabel->LinkCustomAttributes = "";
            $this->infolabel->HrefValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";

            // labelcatatan
            $this->labelcatatan->LinkCustomAttributes = "";
            $this->labelcatatan->HrefValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";

            // tanggal
            $this->tanggal->LinkCustomAttributes = "";
            $this->tanggal->HrefValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";

            // createat
            $this->createat->LinkCustomAttributes = "";
            $this->createat->HrefValue = "";

            // createby
            $this->createby->LinkCustomAttributes = "";
            $this->createby->HrefValue = "";

            // statusdokumen
            $this->statusdokumen->LinkCustomAttributes = "";
            $this->statusdokumen->HrefValue = "";

            // update_at
            $this->update_at->LinkCustomAttributes = "";
            $this->update_at->HrefValue = "";

            // status_data
            $this->status_data->LinkCustomAttributes = "";
            $this->status_data->HrefValue = "";

            // harga_rnd
            $this->harga_rnd->LinkCustomAttributes = "";
            $this->harga_rnd->HrefValue = "";

            // aplikasi_sediaan
            $this->aplikasi_sediaan->LinkCustomAttributes = "";
            $this->aplikasi_sediaan->HrefValue = "";

            // hu_hrg_isi
            $this->hu_hrg_isi->LinkCustomAttributes = "";
            $this->hu_hrg_isi->HrefValue = "";

            // hu_hrg_isi_pro
            $this->hu_hrg_isi_pro->LinkCustomAttributes = "";
            $this->hu_hrg_isi_pro->HrefValue = "";

            // hu_hrg_kms_primer
            $this->hu_hrg_kms_primer->LinkCustomAttributes = "";
            $this->hu_hrg_kms_primer->HrefValue = "";

            // hu_hrg_kms_primer_pro
            $this->hu_hrg_kms_primer_pro->LinkCustomAttributes = "";
            $this->hu_hrg_kms_primer_pro->HrefValue = "";

            // hu_hrg_kms_sekunder
            $this->hu_hrg_kms_sekunder->LinkCustomAttributes = "";
            $this->hu_hrg_kms_sekunder->HrefValue = "";

            // hu_hrg_kms_sekunder_pro
            $this->hu_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
            $this->hu_hrg_kms_sekunder_pro->HrefValue = "";

            // hu_hrg_label
            $this->hu_hrg_label->LinkCustomAttributes = "";
            $this->hu_hrg_label->HrefValue = "";

            // hu_hrg_label_pro
            $this->hu_hrg_label_pro->LinkCustomAttributes = "";
            $this->hu_hrg_label_pro->HrefValue = "";

            // hu_hrg_total
            $this->hu_hrg_total->LinkCustomAttributes = "";
            $this->hu_hrg_total->HrefValue = "";

            // hu_hrg_total_pro
            $this->hu_hrg_total_pro->LinkCustomAttributes = "";
            $this->hu_hrg_total_pro->HrefValue = "";

            // hl_hrg_isi
            $this->hl_hrg_isi->LinkCustomAttributes = "";
            $this->hl_hrg_isi->HrefValue = "";

            // hl_hrg_isi_pro
            $this->hl_hrg_isi_pro->LinkCustomAttributes = "";
            $this->hl_hrg_isi_pro->HrefValue = "";

            // hl_hrg_kms_primer
            $this->hl_hrg_kms_primer->LinkCustomAttributes = "";
            $this->hl_hrg_kms_primer->HrefValue = "";

            // hl_hrg_kms_primer_pro
            $this->hl_hrg_kms_primer_pro->LinkCustomAttributes = "";
            $this->hl_hrg_kms_primer_pro->HrefValue = "";

            // hl_hrg_kms_sekunder
            $this->hl_hrg_kms_sekunder->LinkCustomAttributes = "";
            $this->hl_hrg_kms_sekunder->HrefValue = "";

            // hl_hrg_kms_sekunder_pro
            $this->hl_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
            $this->hl_hrg_kms_sekunder_pro->HrefValue = "";

            // hl_hrg_label
            $this->hl_hrg_label->LinkCustomAttributes = "";
            $this->hl_hrg_label->HrefValue = "";

            // hl_hrg_label_pro
            $this->hl_hrg_label_pro->LinkCustomAttributes = "";
            $this->hl_hrg_label_pro->HrefValue = "";

            // hl_hrg_total
            $this->hl_hrg_total->LinkCustomAttributes = "";
            $this->hl_hrg_total->HrefValue = "";

            // hl_hrg_total_pro
            $this->hl_hrg_total_pro->LinkCustomAttributes = "";
            $this->hl_hrg_total_pro->HrefValue = "";

            // bs_bahan_aktif_tick
            $this->bs_bahan_aktif_tick->LinkCustomAttributes = "";
            $this->bs_bahan_aktif_tick->HrefValue = "";

            // bs_bahan_aktif
            $this->bs_bahan_aktif->LinkCustomAttributes = "";
            $this->bs_bahan_aktif->HrefValue = "";

            // bs_bahan_lain
            $this->bs_bahan_lain->LinkCustomAttributes = "";
            $this->bs_bahan_lain->HrefValue = "";

            // bs_parfum
            $this->bs_parfum->LinkCustomAttributes = "";
            $this->bs_parfum->HrefValue = "";

            // bs_estetika
            $this->bs_estetika->LinkCustomAttributes = "";
            $this->bs_estetika->HrefValue = "";

            // bs_kms_wadah
            $this->bs_kms_wadah->LinkCustomAttributes = "";
            $this->bs_kms_wadah->HrefValue = "";

            // bs_kms_tutup
            $this->bs_kms_tutup->LinkCustomAttributes = "";
            $this->bs_kms_tutup->HrefValue = "";

            // bs_kms_sekunder
            $this->bs_kms_sekunder->LinkCustomAttributes = "";
            $this->bs_kms_sekunder->HrefValue = "";

            // bs_label_desain
            $this->bs_label_desain->LinkCustomAttributes = "";
            $this->bs_label_desain->HrefValue = "";

            // bs_label_cetak
            $this->bs_label_cetak->LinkCustomAttributes = "";
            $this->bs_label_cetak->HrefValue = "";

            // bs_label_lain
            $this->bs_label_lain->LinkCustomAttributes = "";
            $this->bs_label_lain->HrefValue = "";

            // dlv_pickup
            $this->dlv_pickup->LinkCustomAttributes = "";
            $this->dlv_pickup->HrefValue = "";

            // dlv_singlepoint
            $this->dlv_singlepoint->LinkCustomAttributes = "";
            $this->dlv_singlepoint->HrefValue = "";

            // dlv_multipoint
            $this->dlv_multipoint->LinkCustomAttributes = "";
            $this->dlv_multipoint->HrefValue = "";

            // dlv_multipoint_jml
            $this->dlv_multipoint_jml->LinkCustomAttributes = "";
            $this->dlv_multipoint_jml->HrefValue = "";

            // dlv_term_lain
            $this->dlv_term_lain->LinkCustomAttributes = "";
            $this->dlv_term_lain->HrefValue = "";

            // catatan_khusus
            $this->catatan_khusus->LinkCustomAttributes = "";
            $this->catatan_khusus->HrefValue = "";

            // aju_tgl
            $this->aju_tgl->LinkCustomAttributes = "";
            $this->aju_tgl->HrefValue = "";

            // aju_oleh
            $this->aju_oleh->LinkCustomAttributes = "";
            $this->aju_oleh->HrefValue = "";

            // proses_tgl
            $this->proses_tgl->LinkCustomAttributes = "";
            $this->proses_tgl->HrefValue = "";

            // proses_oleh
            $this->proses_oleh->LinkCustomAttributes = "";
            $this->proses_oleh->HrefValue = "";

            // revisi_tgl
            $this->revisi_tgl->LinkCustomAttributes = "";
            $this->revisi_tgl->HrefValue = "";

            // revisi_oleh
            $this->revisi_oleh->LinkCustomAttributes = "";
            $this->revisi_oleh->HrefValue = "";

            // revisi_akun_tgl
            $this->revisi_akun_tgl->LinkCustomAttributes = "";
            $this->revisi_akun_tgl->HrefValue = "";

            // revisi_akun_oleh
            $this->revisi_akun_oleh->LinkCustomAttributes = "";
            $this->revisi_akun_oleh->HrefValue = "";

            // revisi_rnd_tgl
            $this->revisi_rnd_tgl->LinkCustomAttributes = "";
            $this->revisi_rnd_tgl->HrefValue = "";

            // revisi_rnd_oleh
            $this->revisi_rnd_oleh->LinkCustomAttributes = "";
            $this->revisi_rnd_oleh->HrefValue = "";

            // rnd_tgl
            $this->rnd_tgl->LinkCustomAttributes = "";
            $this->rnd_tgl->HrefValue = "";

            // rnd_oleh
            $this->rnd_oleh->LinkCustomAttributes = "";
            $this->rnd_oleh->HrefValue = "";

            // ap_tgl
            $this->ap_tgl->LinkCustomAttributes = "";
            $this->ap_tgl->HrefValue = "";

            // ap_oleh
            $this->ap_oleh->LinkCustomAttributes = "";
            $this->ap_oleh->HrefValue = "";

            // batal_tgl
            $this->batal_tgl->LinkCustomAttributes = "";
            $this->batal_tgl->HrefValue = "";

            // batal_oleh
            $this->batal_oleh->LinkCustomAttributes = "";
            $this->batal_oleh->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id->FormValue)) {
            $this->id->addErrorMessage($this->id->getErrorMessage(false));
        }
        if ($this->cpo_jenis->Required) {
            if (!$this->cpo_jenis->IsDetailKey && EmptyValue($this->cpo_jenis->FormValue)) {
                $this->cpo_jenis->addErrorMessage(str_replace("%s", $this->cpo_jenis->caption(), $this->cpo_jenis->RequiredErrorMessage));
            }
        }
        if ($this->ordernum->Required) {
            if (!$this->ordernum->IsDetailKey && EmptyValue($this->ordernum->FormValue)) {
                $this->ordernum->addErrorMessage(str_replace("%s", $this->ordernum->caption(), $this->ordernum->RequiredErrorMessage));
            }
        }
        if ($this->order_kode->Required) {
            if (!$this->order_kode->IsDetailKey && EmptyValue($this->order_kode->FormValue)) {
                $this->order_kode->addErrorMessage(str_replace("%s", $this->order_kode->caption(), $this->order_kode->RequiredErrorMessage));
            }
        }
        if ($this->orderterimatgl->Required) {
            if (!$this->orderterimatgl->IsDetailKey && EmptyValue($this->orderterimatgl->FormValue)) {
                $this->orderterimatgl->addErrorMessage(str_replace("%s", $this->orderterimatgl->caption(), $this->orderterimatgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->orderterimatgl->FormValue)) {
            $this->orderterimatgl->addErrorMessage($this->orderterimatgl->getErrorMessage(false));
        }
        if ($this->produk_fungsi->Required) {
            if (!$this->produk_fungsi->IsDetailKey && EmptyValue($this->produk_fungsi->FormValue)) {
                $this->produk_fungsi->addErrorMessage(str_replace("%s", $this->produk_fungsi->caption(), $this->produk_fungsi->RequiredErrorMessage));
            }
        }
        if ($this->produk_kualitas->Required) {
            if (!$this->produk_kualitas->IsDetailKey && EmptyValue($this->produk_kualitas->FormValue)) {
                $this->produk_kualitas->addErrorMessage(str_replace("%s", $this->produk_kualitas->caption(), $this->produk_kualitas->RequiredErrorMessage));
            }
        }
        if ($this->produk_campaign->Required) {
            if (!$this->produk_campaign->IsDetailKey && EmptyValue($this->produk_campaign->FormValue)) {
                $this->produk_campaign->addErrorMessage(str_replace("%s", $this->produk_campaign->caption(), $this->produk_campaign->RequiredErrorMessage));
            }
        }
        if ($this->kemasan_satuan->Required) {
            if (!$this->kemasan_satuan->IsDetailKey && EmptyValue($this->kemasan_satuan->FormValue)) {
                $this->kemasan_satuan->addErrorMessage(str_replace("%s", $this->kemasan_satuan->caption(), $this->kemasan_satuan->RequiredErrorMessage));
            }
        }
        if ($this->ordertgl->Required) {
            if (!$this->ordertgl->IsDetailKey && EmptyValue($this->ordertgl->FormValue)) {
                $this->ordertgl->addErrorMessage(str_replace("%s", $this->ordertgl->caption(), $this->ordertgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ordertgl->FormValue)) {
            $this->ordertgl->addErrorMessage($this->ordertgl->getErrorMessage(false));
        }
        if ($this->custcode->Required) {
            if (!$this->custcode->IsDetailKey && EmptyValue($this->custcode->FormValue)) {
                $this->custcode->addErrorMessage(str_replace("%s", $this->custcode->caption(), $this->custcode->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->custcode->FormValue)) {
            $this->custcode->addErrorMessage($this->custcode->getErrorMessage(false));
        }
        if ($this->perushnama->Required) {
            if (!$this->perushnama->IsDetailKey && EmptyValue($this->perushnama->FormValue)) {
                $this->perushnama->addErrorMessage(str_replace("%s", $this->perushnama->caption(), $this->perushnama->RequiredErrorMessage));
            }
        }
        if ($this->perushalamat->Required) {
            if (!$this->perushalamat->IsDetailKey && EmptyValue($this->perushalamat->FormValue)) {
                $this->perushalamat->addErrorMessage(str_replace("%s", $this->perushalamat->caption(), $this->perushalamat->RequiredErrorMessage));
            }
        }
        if ($this->perushcp->Required) {
            if (!$this->perushcp->IsDetailKey && EmptyValue($this->perushcp->FormValue)) {
                $this->perushcp->addErrorMessage(str_replace("%s", $this->perushcp->caption(), $this->perushcp->RequiredErrorMessage));
            }
        }
        if ($this->perushjabatan->Required) {
            if (!$this->perushjabatan->IsDetailKey && EmptyValue($this->perushjabatan->FormValue)) {
                $this->perushjabatan->addErrorMessage(str_replace("%s", $this->perushjabatan->caption(), $this->perushjabatan->RequiredErrorMessage));
            }
        }
        if ($this->perushphone->Required) {
            if (!$this->perushphone->IsDetailKey && EmptyValue($this->perushphone->FormValue)) {
                $this->perushphone->addErrorMessage(str_replace("%s", $this->perushphone->caption(), $this->perushphone->RequiredErrorMessage));
            }
        }
        if ($this->perushmobile->Required) {
            if (!$this->perushmobile->IsDetailKey && EmptyValue($this->perushmobile->FormValue)) {
                $this->perushmobile->addErrorMessage(str_replace("%s", $this->perushmobile->caption(), $this->perushmobile->RequiredErrorMessage));
            }
        }
        if ($this->bencmark->Required) {
            if (!$this->bencmark->IsDetailKey && EmptyValue($this->bencmark->FormValue)) {
                $this->bencmark->addErrorMessage(str_replace("%s", $this->bencmark->caption(), $this->bencmark->RequiredErrorMessage));
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
        if ($this->bentuksediaan->Required) {
            if (!$this->bentuksediaan->IsDetailKey && EmptyValue($this->bentuksediaan->FormValue)) {
                $this->bentuksediaan->addErrorMessage(str_replace("%s", $this->bentuksediaan->caption(), $this->bentuksediaan->RequiredErrorMessage));
            }
        }
        if ($this->sediaan_ukuran->Required) {
            if (!$this->sediaan_ukuran->IsDetailKey && EmptyValue($this->sediaan_ukuran->FormValue)) {
                $this->sediaan_ukuran->addErrorMessage(str_replace("%s", $this->sediaan_ukuran->caption(), $this->sediaan_ukuran->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->sediaan_ukuran->FormValue)) {
            $this->sediaan_ukuran->addErrorMessage($this->sediaan_ukuran->getErrorMessage(false));
        }
        if ($this->sediaan_ukuran_satuan->Required) {
            if (!$this->sediaan_ukuran_satuan->IsDetailKey && EmptyValue($this->sediaan_ukuran_satuan->FormValue)) {
                $this->sediaan_ukuran_satuan->addErrorMessage(str_replace("%s", $this->sediaan_ukuran_satuan->caption(), $this->sediaan_ukuran_satuan->RequiredErrorMessage));
            }
        }
        if ($this->produk_viskositas->Required) {
            if (!$this->produk_viskositas->IsDetailKey && EmptyValue($this->produk_viskositas->FormValue)) {
                $this->produk_viskositas->addErrorMessage(str_replace("%s", $this->produk_viskositas->caption(), $this->produk_viskositas->RequiredErrorMessage));
            }
        }
        if ($this->konsepproduk->Required) {
            if (!$this->konsepproduk->IsDetailKey && EmptyValue($this->konsepproduk->FormValue)) {
                $this->konsepproduk->addErrorMessage(str_replace("%s", $this->konsepproduk->caption(), $this->konsepproduk->RequiredErrorMessage));
            }
        }
        if ($this->fragrance->Required) {
            if (!$this->fragrance->IsDetailKey && EmptyValue($this->fragrance->FormValue)) {
                $this->fragrance->addErrorMessage(str_replace("%s", $this->fragrance->caption(), $this->fragrance->RequiredErrorMessage));
            }
        }
        if ($this->aroma->Required) {
            if (!$this->aroma->IsDetailKey && EmptyValue($this->aroma->FormValue)) {
                $this->aroma->addErrorMessage(str_replace("%s", $this->aroma->caption(), $this->aroma->RequiredErrorMessage));
            }
        }
        if ($this->bahanaktif->Required) {
            if (!$this->bahanaktif->IsDetailKey && EmptyValue($this->bahanaktif->FormValue)) {
                $this->bahanaktif->addErrorMessage(str_replace("%s", $this->bahanaktif->caption(), $this->bahanaktif->RequiredErrorMessage));
            }
        }
        if ($this->warna->Required) {
            if (!$this->warna->IsDetailKey && EmptyValue($this->warna->FormValue)) {
                $this->warna->addErrorMessage(str_replace("%s", $this->warna->caption(), $this->warna->RequiredErrorMessage));
            }
        }
        if ($this->produk_warna_jenis->Required) {
            if (!$this->produk_warna_jenis->IsDetailKey && EmptyValue($this->produk_warna_jenis->FormValue)) {
                $this->produk_warna_jenis->addErrorMessage(str_replace("%s", $this->produk_warna_jenis->caption(), $this->produk_warna_jenis->RequiredErrorMessage));
            }
        }
        if ($this->aksesoris->Required) {
            if (!$this->aksesoris->IsDetailKey && EmptyValue($this->aksesoris->FormValue)) {
                $this->aksesoris->addErrorMessage(str_replace("%s", $this->aksesoris->caption(), $this->aksesoris->RequiredErrorMessage));
            }
        }
        if ($this->produk_lainlain->Required) {
            if (!$this->produk_lainlain->IsDetailKey && EmptyValue($this->produk_lainlain->FormValue)) {
                $this->produk_lainlain->addErrorMessage(str_replace("%s", $this->produk_lainlain->caption(), $this->produk_lainlain->RequiredErrorMessage));
            }
        }
        if ($this->statusproduk->Required) {
            if (!$this->statusproduk->IsDetailKey && EmptyValue($this->statusproduk->FormValue)) {
                $this->statusproduk->addErrorMessage(str_replace("%s", $this->statusproduk->caption(), $this->statusproduk->RequiredErrorMessage));
            }
        }
        if ($this->parfum->Required) {
            if (!$this->parfum->IsDetailKey && EmptyValue($this->parfum->FormValue)) {
                $this->parfum->addErrorMessage(str_replace("%s", $this->parfum->caption(), $this->parfum->RequiredErrorMessage));
            }
        }
        if ($this->catatan->Required) {
            if (!$this->catatan->IsDetailKey && EmptyValue($this->catatan->FormValue)) {
                $this->catatan->addErrorMessage(str_replace("%s", $this->catatan->caption(), $this->catatan->RequiredErrorMessage));
            }
        }
        if ($this->rencanakemasan->Required) {
            if (!$this->rencanakemasan->IsDetailKey && EmptyValue($this->rencanakemasan->FormValue)) {
                $this->rencanakemasan->addErrorMessage(str_replace("%s", $this->rencanakemasan->caption(), $this->rencanakemasan->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }
        if ($this->ekspetasiharga->Required) {
            if (!$this->ekspetasiharga->IsDetailKey && EmptyValue($this->ekspetasiharga->FormValue)) {
                $this->ekspetasiharga->addErrorMessage(str_replace("%s", $this->ekspetasiharga->caption(), $this->ekspetasiharga->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->ekspetasiharga->FormValue)) {
            $this->ekspetasiharga->addErrorMessage($this->ekspetasiharga->getErrorMessage(false));
        }
        if ($this->kemasan->Required) {
            if (!$this->kemasan->IsDetailKey && EmptyValue($this->kemasan->FormValue)) {
                $this->kemasan->addErrorMessage(str_replace("%s", $this->kemasan->caption(), $this->kemasan->RequiredErrorMessage));
            }
        }
        if ($this->volume->Required) {
            if (!$this->volume->IsDetailKey && EmptyValue($this->volume->FormValue)) {
                $this->volume->addErrorMessage(str_replace("%s", $this->volume->caption(), $this->volume->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->volume->FormValue)) {
            $this->volume->addErrorMessage($this->volume->getErrorMessage(false));
        }
        if ($this->jenistutup->Required) {
            if (!$this->jenistutup->IsDetailKey && EmptyValue($this->jenistutup->FormValue)) {
                $this->jenistutup->addErrorMessage(str_replace("%s", $this->jenistutup->caption(), $this->jenistutup->RequiredErrorMessage));
            }
        }
        if ($this->catatanpackaging->Required) {
            if (!$this->catatanpackaging->IsDetailKey && EmptyValue($this->catatanpackaging->FormValue)) {
                $this->catatanpackaging->addErrorMessage(str_replace("%s", $this->catatanpackaging->caption(), $this->catatanpackaging->RequiredErrorMessage));
            }
        }
        if ($this->infopackaging->Required) {
            if (!$this->infopackaging->IsDetailKey && EmptyValue($this->infopackaging->FormValue)) {
                $this->infopackaging->addErrorMessage(str_replace("%s", $this->infopackaging->caption(), $this->infopackaging->RequiredErrorMessage));
            }
        }
        if ($this->ukuran->Required) {
            if (!$this->ukuran->IsDetailKey && EmptyValue($this->ukuran->FormValue)) {
                $this->ukuran->addErrorMessage(str_replace("%s", $this->ukuran->caption(), $this->ukuran->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ukuran->FormValue)) {
            $this->ukuran->addErrorMessage($this->ukuran->getErrorMessage(false));
        }
        if ($this->desainprodukkemasan->Required) {
            if (!$this->desainprodukkemasan->IsDetailKey && EmptyValue($this->desainprodukkemasan->FormValue)) {
                $this->desainprodukkemasan->addErrorMessage(str_replace("%s", $this->desainprodukkemasan->caption(), $this->desainprodukkemasan->RequiredErrorMessage));
            }
        }
        if ($this->desaindiinginkan->Required) {
            if (!$this->desaindiinginkan->IsDetailKey && EmptyValue($this->desaindiinginkan->FormValue)) {
                $this->desaindiinginkan->addErrorMessage(str_replace("%s", $this->desaindiinginkan->caption(), $this->desaindiinginkan->RequiredErrorMessage));
            }
        }
        if ($this->mereknotifikasi->Required) {
            if (!$this->mereknotifikasi->IsDetailKey && EmptyValue($this->mereknotifikasi->FormValue)) {
                $this->mereknotifikasi->addErrorMessage(str_replace("%s", $this->mereknotifikasi->caption(), $this->mereknotifikasi->RequiredErrorMessage));
            }
        }
        if ($this->kategoristatus->Required) {
            if (!$this->kategoristatus->IsDetailKey && EmptyValue($this->kategoristatus->FormValue)) {
                $this->kategoristatus->addErrorMessage(str_replace("%s", $this->kategoristatus->caption(), $this->kategoristatus->RequiredErrorMessage));
            }
        }
        if ($this->kemasan_ukuran_satuan->Required) {
            if (!$this->kemasan_ukuran_satuan->IsDetailKey && EmptyValue($this->kemasan_ukuran_satuan->FormValue)) {
                $this->kemasan_ukuran_satuan->addErrorMessage(str_replace("%s", $this->kemasan_ukuran_satuan->caption(), $this->kemasan_ukuran_satuan->RequiredErrorMessage));
            }
        }
        if ($this->notifikasicatatan->Required) {
            if (!$this->notifikasicatatan->IsDetailKey && EmptyValue($this->notifikasicatatan->FormValue)) {
                $this->notifikasicatatan->addErrorMessage(str_replace("%s", $this->notifikasicatatan->caption(), $this->notifikasicatatan->RequiredErrorMessage));
            }
        }
        if ($this->label_ukuran->Required) {
            if (!$this->label_ukuran->IsDetailKey && EmptyValue($this->label_ukuran->FormValue)) {
                $this->label_ukuran->addErrorMessage(str_replace("%s", $this->label_ukuran->caption(), $this->label_ukuran->RequiredErrorMessage));
            }
        }
        if ($this->infolabel->Required) {
            if (!$this->infolabel->IsDetailKey && EmptyValue($this->infolabel->FormValue)) {
                $this->infolabel->addErrorMessage(str_replace("%s", $this->infolabel->caption(), $this->infolabel->RequiredErrorMessage));
            }
        }
        if ($this->labelkualitas->Required) {
            if (!$this->labelkualitas->IsDetailKey && EmptyValue($this->labelkualitas->FormValue)) {
                $this->labelkualitas->addErrorMessage(str_replace("%s", $this->labelkualitas->caption(), $this->labelkualitas->RequiredErrorMessage));
            }
        }
        if ($this->labelposisi->Required) {
            if (!$this->labelposisi->IsDetailKey && EmptyValue($this->labelposisi->FormValue)) {
                $this->labelposisi->addErrorMessage(str_replace("%s", $this->labelposisi->caption(), $this->labelposisi->RequiredErrorMessage));
            }
        }
        if ($this->labelcatatan->Required) {
            if (!$this->labelcatatan->IsDetailKey && EmptyValue($this->labelcatatan->FormValue)) {
                $this->labelcatatan->addErrorMessage(str_replace("%s", $this->labelcatatan->caption(), $this->labelcatatan->RequiredErrorMessage));
            }
        }
        if ($this->dibuatdi->Required) {
            if (!$this->dibuatdi->IsDetailKey && EmptyValue($this->dibuatdi->FormValue)) {
                $this->dibuatdi->addErrorMessage(str_replace("%s", $this->dibuatdi->caption(), $this->dibuatdi->RequiredErrorMessage));
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
        if ($this->penerima->Required) {
            if (!$this->penerima->IsDetailKey && EmptyValue($this->penerima->FormValue)) {
                $this->penerima->addErrorMessage(str_replace("%s", $this->penerima->caption(), $this->penerima->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->penerima->FormValue)) {
            $this->penerima->addErrorMessage($this->penerima->getErrorMessage(false));
        }
        if ($this->createat->Required) {
            if (!$this->createat->IsDetailKey && EmptyValue($this->createat->FormValue)) {
                $this->createat->addErrorMessage(str_replace("%s", $this->createat->caption(), $this->createat->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->createat->FormValue)) {
            $this->createat->addErrorMessage($this->createat->getErrorMessage(false));
        }
        if ($this->createby->Required) {
            if (!$this->createby->IsDetailKey && EmptyValue($this->createby->FormValue)) {
                $this->createby->addErrorMessage(str_replace("%s", $this->createby->caption(), $this->createby->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->createby->FormValue)) {
            $this->createby->addErrorMessage($this->createby->getErrorMessage(false));
        }
        if ($this->statusdokumen->Required) {
            if (!$this->statusdokumen->IsDetailKey && EmptyValue($this->statusdokumen->FormValue)) {
                $this->statusdokumen->addErrorMessage(str_replace("%s", $this->statusdokumen->caption(), $this->statusdokumen->RequiredErrorMessage));
            }
        }
        if ($this->update_at->Required) {
            if (!$this->update_at->IsDetailKey && EmptyValue($this->update_at->FormValue)) {
                $this->update_at->addErrorMessage(str_replace("%s", $this->update_at->caption(), $this->update_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->update_at->FormValue)) {
            $this->update_at->addErrorMessage($this->update_at->getErrorMessage(false));
        }
        if ($this->status_data->Required) {
            if (!$this->status_data->IsDetailKey && EmptyValue($this->status_data->FormValue)) {
                $this->status_data->addErrorMessage(str_replace("%s", $this->status_data->caption(), $this->status_data->RequiredErrorMessage));
            }
        }
        if ($this->harga_rnd->Required) {
            if (!$this->harga_rnd->IsDetailKey && EmptyValue($this->harga_rnd->FormValue)) {
                $this->harga_rnd->addErrorMessage(str_replace("%s", $this->harga_rnd->caption(), $this->harga_rnd->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->harga_rnd->FormValue)) {
            $this->harga_rnd->addErrorMessage($this->harga_rnd->getErrorMessage(false));
        }
        if ($this->aplikasi_sediaan->Required) {
            if (!$this->aplikasi_sediaan->IsDetailKey && EmptyValue($this->aplikasi_sediaan->FormValue)) {
                $this->aplikasi_sediaan->addErrorMessage(str_replace("%s", $this->aplikasi_sediaan->caption(), $this->aplikasi_sediaan->RequiredErrorMessage));
            }
        }
        if ($this->hu_hrg_isi->Required) {
            if (!$this->hu_hrg_isi->IsDetailKey && EmptyValue($this->hu_hrg_isi->FormValue)) {
                $this->hu_hrg_isi->addErrorMessage(str_replace("%s", $this->hu_hrg_isi->caption(), $this->hu_hrg_isi->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_isi->FormValue)) {
            $this->hu_hrg_isi->addErrorMessage($this->hu_hrg_isi->getErrorMessage(false));
        }
        if ($this->hu_hrg_isi_pro->Required) {
            if (!$this->hu_hrg_isi_pro->IsDetailKey && EmptyValue($this->hu_hrg_isi_pro->FormValue)) {
                $this->hu_hrg_isi_pro->addErrorMessage(str_replace("%s", $this->hu_hrg_isi_pro->caption(), $this->hu_hrg_isi_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_isi_pro->FormValue)) {
            $this->hu_hrg_isi_pro->addErrorMessage($this->hu_hrg_isi_pro->getErrorMessage(false));
        }
        if ($this->hu_hrg_kms_primer->Required) {
            if (!$this->hu_hrg_kms_primer->IsDetailKey && EmptyValue($this->hu_hrg_kms_primer->FormValue)) {
                $this->hu_hrg_kms_primer->addErrorMessage(str_replace("%s", $this->hu_hrg_kms_primer->caption(), $this->hu_hrg_kms_primer->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_kms_primer->FormValue)) {
            $this->hu_hrg_kms_primer->addErrorMessage($this->hu_hrg_kms_primer->getErrorMessage(false));
        }
        if ($this->hu_hrg_kms_primer_pro->Required) {
            if (!$this->hu_hrg_kms_primer_pro->IsDetailKey && EmptyValue($this->hu_hrg_kms_primer_pro->FormValue)) {
                $this->hu_hrg_kms_primer_pro->addErrorMessage(str_replace("%s", $this->hu_hrg_kms_primer_pro->caption(), $this->hu_hrg_kms_primer_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_kms_primer_pro->FormValue)) {
            $this->hu_hrg_kms_primer_pro->addErrorMessage($this->hu_hrg_kms_primer_pro->getErrorMessage(false));
        }
        if ($this->hu_hrg_kms_sekunder->Required) {
            if (!$this->hu_hrg_kms_sekunder->IsDetailKey && EmptyValue($this->hu_hrg_kms_sekunder->FormValue)) {
                $this->hu_hrg_kms_sekunder->addErrorMessage(str_replace("%s", $this->hu_hrg_kms_sekunder->caption(), $this->hu_hrg_kms_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_kms_sekunder->FormValue)) {
            $this->hu_hrg_kms_sekunder->addErrorMessage($this->hu_hrg_kms_sekunder->getErrorMessage(false));
        }
        if ($this->hu_hrg_kms_sekunder_pro->Required) {
            if (!$this->hu_hrg_kms_sekunder_pro->IsDetailKey && EmptyValue($this->hu_hrg_kms_sekunder_pro->FormValue)) {
                $this->hu_hrg_kms_sekunder_pro->addErrorMessage(str_replace("%s", $this->hu_hrg_kms_sekunder_pro->caption(), $this->hu_hrg_kms_sekunder_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_kms_sekunder_pro->FormValue)) {
            $this->hu_hrg_kms_sekunder_pro->addErrorMessage($this->hu_hrg_kms_sekunder_pro->getErrorMessage(false));
        }
        if ($this->hu_hrg_label->Required) {
            if (!$this->hu_hrg_label->IsDetailKey && EmptyValue($this->hu_hrg_label->FormValue)) {
                $this->hu_hrg_label->addErrorMessage(str_replace("%s", $this->hu_hrg_label->caption(), $this->hu_hrg_label->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_label->FormValue)) {
            $this->hu_hrg_label->addErrorMessage($this->hu_hrg_label->getErrorMessage(false));
        }
        if ($this->hu_hrg_label_pro->Required) {
            if (!$this->hu_hrg_label_pro->IsDetailKey && EmptyValue($this->hu_hrg_label_pro->FormValue)) {
                $this->hu_hrg_label_pro->addErrorMessage(str_replace("%s", $this->hu_hrg_label_pro->caption(), $this->hu_hrg_label_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_label_pro->FormValue)) {
            $this->hu_hrg_label_pro->addErrorMessage($this->hu_hrg_label_pro->getErrorMessage(false));
        }
        if ($this->hu_hrg_total->Required) {
            if (!$this->hu_hrg_total->IsDetailKey && EmptyValue($this->hu_hrg_total->FormValue)) {
                $this->hu_hrg_total->addErrorMessage(str_replace("%s", $this->hu_hrg_total->caption(), $this->hu_hrg_total->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_total->FormValue)) {
            $this->hu_hrg_total->addErrorMessage($this->hu_hrg_total->getErrorMessage(false));
        }
        if ($this->hu_hrg_total_pro->Required) {
            if (!$this->hu_hrg_total_pro->IsDetailKey && EmptyValue($this->hu_hrg_total_pro->FormValue)) {
                $this->hu_hrg_total_pro->addErrorMessage(str_replace("%s", $this->hu_hrg_total_pro->caption(), $this->hu_hrg_total_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hu_hrg_total_pro->FormValue)) {
            $this->hu_hrg_total_pro->addErrorMessage($this->hu_hrg_total_pro->getErrorMessage(false));
        }
        if ($this->hl_hrg_isi->Required) {
            if (!$this->hl_hrg_isi->IsDetailKey && EmptyValue($this->hl_hrg_isi->FormValue)) {
                $this->hl_hrg_isi->addErrorMessage(str_replace("%s", $this->hl_hrg_isi->caption(), $this->hl_hrg_isi->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_isi->FormValue)) {
            $this->hl_hrg_isi->addErrorMessage($this->hl_hrg_isi->getErrorMessage(false));
        }
        if ($this->hl_hrg_isi_pro->Required) {
            if (!$this->hl_hrg_isi_pro->IsDetailKey && EmptyValue($this->hl_hrg_isi_pro->FormValue)) {
                $this->hl_hrg_isi_pro->addErrorMessage(str_replace("%s", $this->hl_hrg_isi_pro->caption(), $this->hl_hrg_isi_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_isi_pro->FormValue)) {
            $this->hl_hrg_isi_pro->addErrorMessage($this->hl_hrg_isi_pro->getErrorMessage(false));
        }
        if ($this->hl_hrg_kms_primer->Required) {
            if (!$this->hl_hrg_kms_primer->IsDetailKey && EmptyValue($this->hl_hrg_kms_primer->FormValue)) {
                $this->hl_hrg_kms_primer->addErrorMessage(str_replace("%s", $this->hl_hrg_kms_primer->caption(), $this->hl_hrg_kms_primer->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_kms_primer->FormValue)) {
            $this->hl_hrg_kms_primer->addErrorMessage($this->hl_hrg_kms_primer->getErrorMessage(false));
        }
        if ($this->hl_hrg_kms_primer_pro->Required) {
            if (!$this->hl_hrg_kms_primer_pro->IsDetailKey && EmptyValue($this->hl_hrg_kms_primer_pro->FormValue)) {
                $this->hl_hrg_kms_primer_pro->addErrorMessage(str_replace("%s", $this->hl_hrg_kms_primer_pro->caption(), $this->hl_hrg_kms_primer_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_kms_primer_pro->FormValue)) {
            $this->hl_hrg_kms_primer_pro->addErrorMessage($this->hl_hrg_kms_primer_pro->getErrorMessage(false));
        }
        if ($this->hl_hrg_kms_sekunder->Required) {
            if (!$this->hl_hrg_kms_sekunder->IsDetailKey && EmptyValue($this->hl_hrg_kms_sekunder->FormValue)) {
                $this->hl_hrg_kms_sekunder->addErrorMessage(str_replace("%s", $this->hl_hrg_kms_sekunder->caption(), $this->hl_hrg_kms_sekunder->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_kms_sekunder->FormValue)) {
            $this->hl_hrg_kms_sekunder->addErrorMessage($this->hl_hrg_kms_sekunder->getErrorMessage(false));
        }
        if ($this->hl_hrg_kms_sekunder_pro->Required) {
            if (!$this->hl_hrg_kms_sekunder_pro->IsDetailKey && EmptyValue($this->hl_hrg_kms_sekunder_pro->FormValue)) {
                $this->hl_hrg_kms_sekunder_pro->addErrorMessage(str_replace("%s", $this->hl_hrg_kms_sekunder_pro->caption(), $this->hl_hrg_kms_sekunder_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_kms_sekunder_pro->FormValue)) {
            $this->hl_hrg_kms_sekunder_pro->addErrorMessage($this->hl_hrg_kms_sekunder_pro->getErrorMessage(false));
        }
        if ($this->hl_hrg_label->Required) {
            if (!$this->hl_hrg_label->IsDetailKey && EmptyValue($this->hl_hrg_label->FormValue)) {
                $this->hl_hrg_label->addErrorMessage(str_replace("%s", $this->hl_hrg_label->caption(), $this->hl_hrg_label->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_label->FormValue)) {
            $this->hl_hrg_label->addErrorMessage($this->hl_hrg_label->getErrorMessage(false));
        }
        if ($this->hl_hrg_label_pro->Required) {
            if (!$this->hl_hrg_label_pro->IsDetailKey && EmptyValue($this->hl_hrg_label_pro->FormValue)) {
                $this->hl_hrg_label_pro->addErrorMessage(str_replace("%s", $this->hl_hrg_label_pro->caption(), $this->hl_hrg_label_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_label_pro->FormValue)) {
            $this->hl_hrg_label_pro->addErrorMessage($this->hl_hrg_label_pro->getErrorMessage(false));
        }
        if ($this->hl_hrg_total->Required) {
            if (!$this->hl_hrg_total->IsDetailKey && EmptyValue($this->hl_hrg_total->FormValue)) {
                $this->hl_hrg_total->addErrorMessage(str_replace("%s", $this->hl_hrg_total->caption(), $this->hl_hrg_total->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_total->FormValue)) {
            $this->hl_hrg_total->addErrorMessage($this->hl_hrg_total->getErrorMessage(false));
        }
        if ($this->hl_hrg_total_pro->Required) {
            if (!$this->hl_hrg_total_pro->IsDetailKey && EmptyValue($this->hl_hrg_total_pro->FormValue)) {
                $this->hl_hrg_total_pro->addErrorMessage(str_replace("%s", $this->hl_hrg_total_pro->caption(), $this->hl_hrg_total_pro->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->hl_hrg_total_pro->FormValue)) {
            $this->hl_hrg_total_pro->addErrorMessage($this->hl_hrg_total_pro->getErrorMessage(false));
        }
        if ($this->bs_bahan_aktif_tick->Required) {
            if (!$this->bs_bahan_aktif_tick->IsDetailKey && EmptyValue($this->bs_bahan_aktif_tick->FormValue)) {
                $this->bs_bahan_aktif_tick->addErrorMessage(str_replace("%s", $this->bs_bahan_aktif_tick->caption(), $this->bs_bahan_aktif_tick->RequiredErrorMessage));
            }
        }
        if ($this->bs_bahan_aktif->Required) {
            if (!$this->bs_bahan_aktif->IsDetailKey && EmptyValue($this->bs_bahan_aktif->FormValue)) {
                $this->bs_bahan_aktif->addErrorMessage(str_replace("%s", $this->bs_bahan_aktif->caption(), $this->bs_bahan_aktif->RequiredErrorMessage));
            }
        }
        if ($this->bs_bahan_lain->Required) {
            if (!$this->bs_bahan_lain->IsDetailKey && EmptyValue($this->bs_bahan_lain->FormValue)) {
                $this->bs_bahan_lain->addErrorMessage(str_replace("%s", $this->bs_bahan_lain->caption(), $this->bs_bahan_lain->RequiredErrorMessage));
            }
        }
        if ($this->bs_parfum->Required) {
            if (!$this->bs_parfum->IsDetailKey && EmptyValue($this->bs_parfum->FormValue)) {
                $this->bs_parfum->addErrorMessage(str_replace("%s", $this->bs_parfum->caption(), $this->bs_parfum->RequiredErrorMessage));
            }
        }
        if ($this->bs_estetika->Required) {
            if (!$this->bs_estetika->IsDetailKey && EmptyValue($this->bs_estetika->FormValue)) {
                $this->bs_estetika->addErrorMessage(str_replace("%s", $this->bs_estetika->caption(), $this->bs_estetika->RequiredErrorMessage));
            }
        }
        if ($this->bs_kms_wadah->Required) {
            if (!$this->bs_kms_wadah->IsDetailKey && EmptyValue($this->bs_kms_wadah->FormValue)) {
                $this->bs_kms_wadah->addErrorMessage(str_replace("%s", $this->bs_kms_wadah->caption(), $this->bs_kms_wadah->RequiredErrorMessage));
            }
        }
        if ($this->bs_kms_tutup->Required) {
            if (!$this->bs_kms_tutup->IsDetailKey && EmptyValue($this->bs_kms_tutup->FormValue)) {
                $this->bs_kms_tutup->addErrorMessage(str_replace("%s", $this->bs_kms_tutup->caption(), $this->bs_kms_tutup->RequiredErrorMessage));
            }
        }
        if ($this->bs_kms_sekunder->Required) {
            if (!$this->bs_kms_sekunder->IsDetailKey && EmptyValue($this->bs_kms_sekunder->FormValue)) {
                $this->bs_kms_sekunder->addErrorMessage(str_replace("%s", $this->bs_kms_sekunder->caption(), $this->bs_kms_sekunder->RequiredErrorMessage));
            }
        }
        if ($this->bs_label_desain->Required) {
            if (!$this->bs_label_desain->IsDetailKey && EmptyValue($this->bs_label_desain->FormValue)) {
                $this->bs_label_desain->addErrorMessage(str_replace("%s", $this->bs_label_desain->caption(), $this->bs_label_desain->RequiredErrorMessage));
            }
        }
        if ($this->bs_label_cetak->Required) {
            if (!$this->bs_label_cetak->IsDetailKey && EmptyValue($this->bs_label_cetak->FormValue)) {
                $this->bs_label_cetak->addErrorMessage(str_replace("%s", $this->bs_label_cetak->caption(), $this->bs_label_cetak->RequiredErrorMessage));
            }
        }
        if ($this->bs_label_lain->Required) {
            if (!$this->bs_label_lain->IsDetailKey && EmptyValue($this->bs_label_lain->FormValue)) {
                $this->bs_label_lain->addErrorMessage(str_replace("%s", $this->bs_label_lain->caption(), $this->bs_label_lain->RequiredErrorMessage));
            }
        }
        if ($this->dlv_pickup->Required) {
            if (!$this->dlv_pickup->IsDetailKey && EmptyValue($this->dlv_pickup->FormValue)) {
                $this->dlv_pickup->addErrorMessage(str_replace("%s", $this->dlv_pickup->caption(), $this->dlv_pickup->RequiredErrorMessage));
            }
        }
        if ($this->dlv_singlepoint->Required) {
            if (!$this->dlv_singlepoint->IsDetailKey && EmptyValue($this->dlv_singlepoint->FormValue)) {
                $this->dlv_singlepoint->addErrorMessage(str_replace("%s", $this->dlv_singlepoint->caption(), $this->dlv_singlepoint->RequiredErrorMessage));
            }
        }
        if ($this->dlv_multipoint->Required) {
            if (!$this->dlv_multipoint->IsDetailKey && EmptyValue($this->dlv_multipoint->FormValue)) {
                $this->dlv_multipoint->addErrorMessage(str_replace("%s", $this->dlv_multipoint->caption(), $this->dlv_multipoint->RequiredErrorMessage));
            }
        }
        if ($this->dlv_multipoint_jml->Required) {
            if (!$this->dlv_multipoint_jml->IsDetailKey && EmptyValue($this->dlv_multipoint_jml->FormValue)) {
                $this->dlv_multipoint_jml->addErrorMessage(str_replace("%s", $this->dlv_multipoint_jml->caption(), $this->dlv_multipoint_jml->RequiredErrorMessage));
            }
        }
        if ($this->dlv_term_lain->Required) {
            if (!$this->dlv_term_lain->IsDetailKey && EmptyValue($this->dlv_term_lain->FormValue)) {
                $this->dlv_term_lain->addErrorMessage(str_replace("%s", $this->dlv_term_lain->caption(), $this->dlv_term_lain->RequiredErrorMessage));
            }
        }
        if ($this->catatan_khusus->Required) {
            if (!$this->catatan_khusus->IsDetailKey && EmptyValue($this->catatan_khusus->FormValue)) {
                $this->catatan_khusus->addErrorMessage(str_replace("%s", $this->catatan_khusus->caption(), $this->catatan_khusus->RequiredErrorMessage));
            }
        }
        if ($this->aju_tgl->Required) {
            if (!$this->aju_tgl->IsDetailKey && EmptyValue($this->aju_tgl->FormValue)) {
                $this->aju_tgl->addErrorMessage(str_replace("%s", $this->aju_tgl->caption(), $this->aju_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->aju_tgl->FormValue)) {
            $this->aju_tgl->addErrorMessage($this->aju_tgl->getErrorMessage(false));
        }
        if ($this->aju_oleh->Required) {
            if (!$this->aju_oleh->IsDetailKey && EmptyValue($this->aju_oleh->FormValue)) {
                $this->aju_oleh->addErrorMessage(str_replace("%s", $this->aju_oleh->caption(), $this->aju_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->aju_oleh->FormValue)) {
            $this->aju_oleh->addErrorMessage($this->aju_oleh->getErrorMessage(false));
        }
        if ($this->proses_tgl->Required) {
            if (!$this->proses_tgl->IsDetailKey && EmptyValue($this->proses_tgl->FormValue)) {
                $this->proses_tgl->addErrorMessage(str_replace("%s", $this->proses_tgl->caption(), $this->proses_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->proses_tgl->FormValue)) {
            $this->proses_tgl->addErrorMessage($this->proses_tgl->getErrorMessage(false));
        }
        if ($this->proses_oleh->Required) {
            if (!$this->proses_oleh->IsDetailKey && EmptyValue($this->proses_oleh->FormValue)) {
                $this->proses_oleh->addErrorMessage(str_replace("%s", $this->proses_oleh->caption(), $this->proses_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->proses_oleh->FormValue)) {
            $this->proses_oleh->addErrorMessage($this->proses_oleh->getErrorMessage(false));
        }
        if ($this->revisi_tgl->Required) {
            if (!$this->revisi_tgl->IsDetailKey && EmptyValue($this->revisi_tgl->FormValue)) {
                $this->revisi_tgl->addErrorMessage(str_replace("%s", $this->revisi_tgl->caption(), $this->revisi_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->revisi_tgl->FormValue)) {
            $this->revisi_tgl->addErrorMessage($this->revisi_tgl->getErrorMessage(false));
        }
        if ($this->revisi_oleh->Required) {
            if (!$this->revisi_oleh->IsDetailKey && EmptyValue($this->revisi_oleh->FormValue)) {
                $this->revisi_oleh->addErrorMessage(str_replace("%s", $this->revisi_oleh->caption(), $this->revisi_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->revisi_oleh->FormValue)) {
            $this->revisi_oleh->addErrorMessage($this->revisi_oleh->getErrorMessage(false));
        }
        if ($this->revisi_akun_tgl->Required) {
            if (!$this->revisi_akun_tgl->IsDetailKey && EmptyValue($this->revisi_akun_tgl->FormValue)) {
                $this->revisi_akun_tgl->addErrorMessage(str_replace("%s", $this->revisi_akun_tgl->caption(), $this->revisi_akun_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->revisi_akun_tgl->FormValue)) {
            $this->revisi_akun_tgl->addErrorMessage($this->revisi_akun_tgl->getErrorMessage(false));
        }
        if ($this->revisi_akun_oleh->Required) {
            if (!$this->revisi_akun_oleh->IsDetailKey && EmptyValue($this->revisi_akun_oleh->FormValue)) {
                $this->revisi_akun_oleh->addErrorMessage(str_replace("%s", $this->revisi_akun_oleh->caption(), $this->revisi_akun_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->revisi_akun_oleh->FormValue)) {
            $this->revisi_akun_oleh->addErrorMessage($this->revisi_akun_oleh->getErrorMessage(false));
        }
        if ($this->revisi_rnd_tgl->Required) {
            if (!$this->revisi_rnd_tgl->IsDetailKey && EmptyValue($this->revisi_rnd_tgl->FormValue)) {
                $this->revisi_rnd_tgl->addErrorMessage(str_replace("%s", $this->revisi_rnd_tgl->caption(), $this->revisi_rnd_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->revisi_rnd_tgl->FormValue)) {
            $this->revisi_rnd_tgl->addErrorMessage($this->revisi_rnd_tgl->getErrorMessage(false));
        }
        if ($this->revisi_rnd_oleh->Required) {
            if (!$this->revisi_rnd_oleh->IsDetailKey && EmptyValue($this->revisi_rnd_oleh->FormValue)) {
                $this->revisi_rnd_oleh->addErrorMessage(str_replace("%s", $this->revisi_rnd_oleh->caption(), $this->revisi_rnd_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->revisi_rnd_oleh->FormValue)) {
            $this->revisi_rnd_oleh->addErrorMessage($this->revisi_rnd_oleh->getErrorMessage(false));
        }
        if ($this->rnd_tgl->Required) {
            if (!$this->rnd_tgl->IsDetailKey && EmptyValue($this->rnd_tgl->FormValue)) {
                $this->rnd_tgl->addErrorMessage(str_replace("%s", $this->rnd_tgl->caption(), $this->rnd_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->rnd_tgl->FormValue)) {
            $this->rnd_tgl->addErrorMessage($this->rnd_tgl->getErrorMessage(false));
        }
        if ($this->rnd_oleh->Required) {
            if (!$this->rnd_oleh->IsDetailKey && EmptyValue($this->rnd_oleh->FormValue)) {
                $this->rnd_oleh->addErrorMessage(str_replace("%s", $this->rnd_oleh->caption(), $this->rnd_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->rnd_oleh->FormValue)) {
            $this->rnd_oleh->addErrorMessage($this->rnd_oleh->getErrorMessage(false));
        }
        if ($this->ap_tgl->Required) {
            if (!$this->ap_tgl->IsDetailKey && EmptyValue($this->ap_tgl->FormValue)) {
                $this->ap_tgl->addErrorMessage(str_replace("%s", $this->ap_tgl->caption(), $this->ap_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ap_tgl->FormValue)) {
            $this->ap_tgl->addErrorMessage($this->ap_tgl->getErrorMessage(false));
        }
        if ($this->ap_oleh->Required) {
            if (!$this->ap_oleh->IsDetailKey && EmptyValue($this->ap_oleh->FormValue)) {
                $this->ap_oleh->addErrorMessage(str_replace("%s", $this->ap_oleh->caption(), $this->ap_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->ap_oleh->FormValue)) {
            $this->ap_oleh->addErrorMessage($this->ap_oleh->getErrorMessage(false));
        }
        if ($this->batal_tgl->Required) {
            if (!$this->batal_tgl->IsDetailKey && EmptyValue($this->batal_tgl->FormValue)) {
                $this->batal_tgl->addErrorMessage(str_replace("%s", $this->batal_tgl->caption(), $this->batal_tgl->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->batal_tgl->FormValue)) {
            $this->batal_tgl->addErrorMessage($this->batal_tgl->getErrorMessage(false));
        }
        if ($this->batal_oleh->Required) {
            if (!$this->batal_oleh->IsDetailKey && EmptyValue($this->batal_oleh->FormValue)) {
                $this->batal_oleh->addErrorMessage(str_replace("%s", $this->batal_oleh->caption(), $this->batal_oleh->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->batal_oleh->FormValue)) {
            $this->batal_oleh->addErrorMessage($this->batal_oleh->getErrorMessage(false));
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

            // id
            $this->id->setDbValueDef($rsnew, $this->id->CurrentValue, 0, $this->id->ReadOnly);

            // cpo_jenis
            $this->cpo_jenis->setDbValueDef($rsnew, $this->cpo_jenis->CurrentValue, "", $this->cpo_jenis->ReadOnly);

            // ordernum
            $this->ordernum->setDbValueDef($rsnew, $this->ordernum->CurrentValue, null, $this->ordernum->ReadOnly);

            // order_kode
            $this->order_kode->setDbValueDef($rsnew, $this->order_kode->CurrentValue, null, $this->order_kode->ReadOnly);

            // orderterimatgl
            $this->orderterimatgl->setDbValueDef($rsnew, UnFormatDateTime($this->orderterimatgl->CurrentValue, 0), null, $this->orderterimatgl->ReadOnly);

            // produk_fungsi
            $this->produk_fungsi->setDbValueDef($rsnew, $this->produk_fungsi->CurrentValue, null, $this->produk_fungsi->ReadOnly);

            // produk_kualitas
            $this->produk_kualitas->setDbValueDef($rsnew, $this->produk_kualitas->CurrentValue, null, $this->produk_kualitas->ReadOnly);

            // produk_campaign
            $this->produk_campaign->setDbValueDef($rsnew, $this->produk_campaign->CurrentValue, null, $this->produk_campaign->ReadOnly);

            // kemasan_satuan
            $this->kemasan_satuan->setDbValueDef($rsnew, $this->kemasan_satuan->CurrentValue, null, $this->kemasan_satuan->ReadOnly);

            // ordertgl
            $this->ordertgl->setDbValueDef($rsnew, UnFormatDateTime($this->ordertgl->CurrentValue, 0), null, $this->ordertgl->ReadOnly);

            // custcode
            $this->custcode->setDbValueDef($rsnew, $this->custcode->CurrentValue, null, $this->custcode->ReadOnly);

            // perushnama
            $this->perushnama->setDbValueDef($rsnew, $this->perushnama->CurrentValue, null, $this->perushnama->ReadOnly);

            // perushalamat
            $this->perushalamat->setDbValueDef($rsnew, $this->perushalamat->CurrentValue, null, $this->perushalamat->ReadOnly);

            // perushcp
            $this->perushcp->setDbValueDef($rsnew, $this->perushcp->CurrentValue, null, $this->perushcp->ReadOnly);

            // perushjabatan
            $this->perushjabatan->setDbValueDef($rsnew, $this->perushjabatan->CurrentValue, null, $this->perushjabatan->ReadOnly);

            // perushphone
            $this->perushphone->setDbValueDef($rsnew, $this->perushphone->CurrentValue, null, $this->perushphone->ReadOnly);

            // perushmobile
            $this->perushmobile->setDbValueDef($rsnew, $this->perushmobile->CurrentValue, null, $this->perushmobile->ReadOnly);

            // bencmark
            $this->bencmark->setDbValueDef($rsnew, $this->bencmark->CurrentValue, null, $this->bencmark->ReadOnly);

            // kategoriproduk
            $this->kategoriproduk->setDbValueDef($rsnew, $this->kategoriproduk->CurrentValue, null, $this->kategoriproduk->ReadOnly);

            // jenisproduk
            $this->jenisproduk->setDbValueDef($rsnew, $this->jenisproduk->CurrentValue, null, $this->jenisproduk->ReadOnly);

            // bentuksediaan
            $this->bentuksediaan->setDbValueDef($rsnew, $this->bentuksediaan->CurrentValue, null, $this->bentuksediaan->ReadOnly);

            // sediaan_ukuran
            $this->sediaan_ukuran->setDbValueDef($rsnew, $this->sediaan_ukuran->CurrentValue, null, $this->sediaan_ukuran->ReadOnly);

            // sediaan_ukuran_satuan
            $this->sediaan_ukuran_satuan->setDbValueDef($rsnew, $this->sediaan_ukuran_satuan->CurrentValue, null, $this->sediaan_ukuran_satuan->ReadOnly);

            // produk_viskositas
            $this->produk_viskositas->setDbValueDef($rsnew, $this->produk_viskositas->CurrentValue, null, $this->produk_viskositas->ReadOnly);

            // konsepproduk
            $this->konsepproduk->setDbValueDef($rsnew, $this->konsepproduk->CurrentValue, null, $this->konsepproduk->ReadOnly);

            // fragrance
            $this->fragrance->setDbValueDef($rsnew, $this->fragrance->CurrentValue, null, $this->fragrance->ReadOnly);

            // aroma
            $this->aroma->setDbValueDef($rsnew, $this->aroma->CurrentValue, null, $this->aroma->ReadOnly);

            // bahanaktif
            $this->bahanaktif->setDbValueDef($rsnew, $this->bahanaktif->CurrentValue, null, $this->bahanaktif->ReadOnly);

            // warna
            $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, null, $this->warna->ReadOnly);

            // produk_warna_jenis
            $this->produk_warna_jenis->setDbValueDef($rsnew, $this->produk_warna_jenis->CurrentValue, null, $this->produk_warna_jenis->ReadOnly);

            // aksesoris
            $this->aksesoris->setDbValueDef($rsnew, $this->aksesoris->CurrentValue, null, $this->aksesoris->ReadOnly);

            // produk_lainlain
            $this->produk_lainlain->setDbValueDef($rsnew, $this->produk_lainlain->CurrentValue, null, $this->produk_lainlain->ReadOnly);

            // statusproduk
            $this->statusproduk->setDbValueDef($rsnew, $this->statusproduk->CurrentValue, null, $this->statusproduk->ReadOnly);

            // parfum
            $this->parfum->setDbValueDef($rsnew, $this->parfum->CurrentValue, null, $this->parfum->ReadOnly);

            // catatan
            $this->catatan->setDbValueDef($rsnew, $this->catatan->CurrentValue, null, $this->catatan->ReadOnly);

            // rencanakemasan
            $this->rencanakemasan->setDbValueDef($rsnew, $this->rencanakemasan->CurrentValue, null, $this->rencanakemasan->ReadOnly);

            // keterangan
            $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, $this->keterangan->ReadOnly);

            // ekspetasiharga
            $this->ekspetasiharga->setDbValueDef($rsnew, $this->ekspetasiharga->CurrentValue, null, $this->ekspetasiharga->ReadOnly);

            // kemasan
            $this->kemasan->setDbValueDef($rsnew, $this->kemasan->CurrentValue, null, $this->kemasan->ReadOnly);

            // volume
            $this->volume->setDbValueDef($rsnew, $this->volume->CurrentValue, null, $this->volume->ReadOnly);

            // jenistutup
            $this->jenistutup->setDbValueDef($rsnew, $this->jenistutup->CurrentValue, null, $this->jenistutup->ReadOnly);

            // catatanpackaging
            $this->catatanpackaging->setDbValueDef($rsnew, $this->catatanpackaging->CurrentValue, null, $this->catatanpackaging->ReadOnly);

            // infopackaging
            $this->infopackaging->setDbValueDef($rsnew, $this->infopackaging->CurrentValue, null, $this->infopackaging->ReadOnly);

            // ukuran
            $this->ukuran->setDbValueDef($rsnew, $this->ukuran->CurrentValue, null, $this->ukuran->ReadOnly);

            // desainprodukkemasan
            $this->desainprodukkemasan->setDbValueDef($rsnew, $this->desainprodukkemasan->CurrentValue, null, $this->desainprodukkemasan->ReadOnly);

            // desaindiinginkan
            $this->desaindiinginkan->setDbValueDef($rsnew, $this->desaindiinginkan->CurrentValue, null, $this->desaindiinginkan->ReadOnly);

            // mereknotifikasi
            $this->mereknotifikasi->setDbValueDef($rsnew, $this->mereknotifikasi->CurrentValue, null, $this->mereknotifikasi->ReadOnly);

            // kategoristatus
            $this->kategoristatus->setDbValueDef($rsnew, $this->kategoristatus->CurrentValue, null, $this->kategoristatus->ReadOnly);

            // kemasan_ukuran_satuan
            $this->kemasan_ukuran_satuan->setDbValueDef($rsnew, $this->kemasan_ukuran_satuan->CurrentValue, null, $this->kemasan_ukuran_satuan->ReadOnly);

            // notifikasicatatan
            $this->notifikasicatatan->setDbValueDef($rsnew, $this->notifikasicatatan->CurrentValue, null, $this->notifikasicatatan->ReadOnly);

            // label_ukuran
            $this->label_ukuran->setDbValueDef($rsnew, $this->label_ukuran->CurrentValue, null, $this->label_ukuran->ReadOnly);

            // infolabel
            $this->infolabel->setDbValueDef($rsnew, $this->infolabel->CurrentValue, null, $this->infolabel->ReadOnly);

            // labelkualitas
            $this->labelkualitas->setDbValueDef($rsnew, $this->labelkualitas->CurrentValue, null, $this->labelkualitas->ReadOnly);

            // labelposisi
            $this->labelposisi->setDbValueDef($rsnew, $this->labelposisi->CurrentValue, null, $this->labelposisi->ReadOnly);

            // labelcatatan
            $this->labelcatatan->setDbValueDef($rsnew, $this->labelcatatan->CurrentValue, null, $this->labelcatatan->ReadOnly);

            // dibuatdi
            $this->dibuatdi->setDbValueDef($rsnew, $this->dibuatdi->CurrentValue, null, $this->dibuatdi->ReadOnly);

            // tanggal
            $this->tanggal->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal->CurrentValue, 0), null, $this->tanggal->ReadOnly);

            // penerima
            $this->penerima->setDbValueDef($rsnew, $this->penerima->CurrentValue, null, $this->penerima->ReadOnly);

            // createat
            $this->createat->setDbValueDef($rsnew, UnFormatDateTime($this->createat->CurrentValue, 0), null, $this->createat->ReadOnly);

            // createby
            $this->createby->setDbValueDef($rsnew, $this->createby->CurrentValue, null, $this->createby->ReadOnly);

            // statusdokumen
            $this->statusdokumen->setDbValueDef($rsnew, $this->statusdokumen->CurrentValue, null, $this->statusdokumen->ReadOnly);

            // update_at
            $this->update_at->setDbValueDef($rsnew, UnFormatDateTime($this->update_at->CurrentValue, 0), null, $this->update_at->ReadOnly);

            // status_data
            $this->status_data->setDbValueDef($rsnew, $this->status_data->CurrentValue, null, $this->status_data->ReadOnly);

            // harga_rnd
            $this->harga_rnd->setDbValueDef($rsnew, $this->harga_rnd->CurrentValue, null, $this->harga_rnd->ReadOnly);

            // aplikasi_sediaan
            $this->aplikasi_sediaan->setDbValueDef($rsnew, $this->aplikasi_sediaan->CurrentValue, null, $this->aplikasi_sediaan->ReadOnly);

            // hu_hrg_isi
            $this->hu_hrg_isi->setDbValueDef($rsnew, $this->hu_hrg_isi->CurrentValue, null, $this->hu_hrg_isi->ReadOnly);

            // hu_hrg_isi_pro
            $this->hu_hrg_isi_pro->setDbValueDef($rsnew, $this->hu_hrg_isi_pro->CurrentValue, null, $this->hu_hrg_isi_pro->ReadOnly);

            // hu_hrg_kms_primer
            $this->hu_hrg_kms_primer->setDbValueDef($rsnew, $this->hu_hrg_kms_primer->CurrentValue, null, $this->hu_hrg_kms_primer->ReadOnly);

            // hu_hrg_kms_primer_pro
            $this->hu_hrg_kms_primer_pro->setDbValueDef($rsnew, $this->hu_hrg_kms_primer_pro->CurrentValue, null, $this->hu_hrg_kms_primer_pro->ReadOnly);

            // hu_hrg_kms_sekunder
            $this->hu_hrg_kms_sekunder->setDbValueDef($rsnew, $this->hu_hrg_kms_sekunder->CurrentValue, null, $this->hu_hrg_kms_sekunder->ReadOnly);

            // hu_hrg_kms_sekunder_pro
            $this->hu_hrg_kms_sekunder_pro->setDbValueDef($rsnew, $this->hu_hrg_kms_sekunder_pro->CurrentValue, null, $this->hu_hrg_kms_sekunder_pro->ReadOnly);

            // hu_hrg_label
            $this->hu_hrg_label->setDbValueDef($rsnew, $this->hu_hrg_label->CurrentValue, null, $this->hu_hrg_label->ReadOnly);

            // hu_hrg_label_pro
            $this->hu_hrg_label_pro->setDbValueDef($rsnew, $this->hu_hrg_label_pro->CurrentValue, null, $this->hu_hrg_label_pro->ReadOnly);

            // hu_hrg_total
            $this->hu_hrg_total->setDbValueDef($rsnew, $this->hu_hrg_total->CurrentValue, null, $this->hu_hrg_total->ReadOnly);

            // hu_hrg_total_pro
            $this->hu_hrg_total_pro->setDbValueDef($rsnew, $this->hu_hrg_total_pro->CurrentValue, null, $this->hu_hrg_total_pro->ReadOnly);

            // hl_hrg_isi
            $this->hl_hrg_isi->setDbValueDef($rsnew, $this->hl_hrg_isi->CurrentValue, null, $this->hl_hrg_isi->ReadOnly);

            // hl_hrg_isi_pro
            $this->hl_hrg_isi_pro->setDbValueDef($rsnew, $this->hl_hrg_isi_pro->CurrentValue, null, $this->hl_hrg_isi_pro->ReadOnly);

            // hl_hrg_kms_primer
            $this->hl_hrg_kms_primer->setDbValueDef($rsnew, $this->hl_hrg_kms_primer->CurrentValue, null, $this->hl_hrg_kms_primer->ReadOnly);

            // hl_hrg_kms_primer_pro
            $this->hl_hrg_kms_primer_pro->setDbValueDef($rsnew, $this->hl_hrg_kms_primer_pro->CurrentValue, null, $this->hl_hrg_kms_primer_pro->ReadOnly);

            // hl_hrg_kms_sekunder
            $this->hl_hrg_kms_sekunder->setDbValueDef($rsnew, $this->hl_hrg_kms_sekunder->CurrentValue, null, $this->hl_hrg_kms_sekunder->ReadOnly);

            // hl_hrg_kms_sekunder_pro
            $this->hl_hrg_kms_sekunder_pro->setDbValueDef($rsnew, $this->hl_hrg_kms_sekunder_pro->CurrentValue, null, $this->hl_hrg_kms_sekunder_pro->ReadOnly);

            // hl_hrg_label
            $this->hl_hrg_label->setDbValueDef($rsnew, $this->hl_hrg_label->CurrentValue, null, $this->hl_hrg_label->ReadOnly);

            // hl_hrg_label_pro
            $this->hl_hrg_label_pro->setDbValueDef($rsnew, $this->hl_hrg_label_pro->CurrentValue, null, $this->hl_hrg_label_pro->ReadOnly);

            // hl_hrg_total
            $this->hl_hrg_total->setDbValueDef($rsnew, $this->hl_hrg_total->CurrentValue, null, $this->hl_hrg_total->ReadOnly);

            // hl_hrg_total_pro
            $this->hl_hrg_total_pro->setDbValueDef($rsnew, $this->hl_hrg_total_pro->CurrentValue, null, $this->hl_hrg_total_pro->ReadOnly);

            // bs_bahan_aktif_tick
            $this->bs_bahan_aktif_tick->setDbValueDef($rsnew, $this->bs_bahan_aktif_tick->CurrentValue, null, $this->bs_bahan_aktif_tick->ReadOnly);

            // bs_bahan_aktif
            $this->bs_bahan_aktif->setDbValueDef($rsnew, $this->bs_bahan_aktif->CurrentValue, null, $this->bs_bahan_aktif->ReadOnly);

            // bs_bahan_lain
            $this->bs_bahan_lain->setDbValueDef($rsnew, $this->bs_bahan_lain->CurrentValue, null, $this->bs_bahan_lain->ReadOnly);

            // bs_parfum
            $this->bs_parfum->setDbValueDef($rsnew, $this->bs_parfum->CurrentValue, null, $this->bs_parfum->ReadOnly);

            // bs_estetika
            $this->bs_estetika->setDbValueDef($rsnew, $this->bs_estetika->CurrentValue, null, $this->bs_estetika->ReadOnly);

            // bs_kms_wadah
            $this->bs_kms_wadah->setDbValueDef($rsnew, $this->bs_kms_wadah->CurrentValue, null, $this->bs_kms_wadah->ReadOnly);

            // bs_kms_tutup
            $this->bs_kms_tutup->setDbValueDef($rsnew, $this->bs_kms_tutup->CurrentValue, null, $this->bs_kms_tutup->ReadOnly);

            // bs_kms_sekunder
            $this->bs_kms_sekunder->setDbValueDef($rsnew, $this->bs_kms_sekunder->CurrentValue, null, $this->bs_kms_sekunder->ReadOnly);

            // bs_label_desain
            $this->bs_label_desain->setDbValueDef($rsnew, $this->bs_label_desain->CurrentValue, null, $this->bs_label_desain->ReadOnly);

            // bs_label_cetak
            $this->bs_label_cetak->setDbValueDef($rsnew, $this->bs_label_cetak->CurrentValue, null, $this->bs_label_cetak->ReadOnly);

            // bs_label_lain
            $this->bs_label_lain->setDbValueDef($rsnew, $this->bs_label_lain->CurrentValue, null, $this->bs_label_lain->ReadOnly);

            // dlv_pickup
            $this->dlv_pickup->setDbValueDef($rsnew, $this->dlv_pickup->CurrentValue, null, $this->dlv_pickup->ReadOnly);

            // dlv_singlepoint
            $this->dlv_singlepoint->setDbValueDef($rsnew, $this->dlv_singlepoint->CurrentValue, null, $this->dlv_singlepoint->ReadOnly);

            // dlv_multipoint
            $this->dlv_multipoint->setDbValueDef($rsnew, $this->dlv_multipoint->CurrentValue, null, $this->dlv_multipoint->ReadOnly);

            // dlv_multipoint_jml
            $this->dlv_multipoint_jml->setDbValueDef($rsnew, $this->dlv_multipoint_jml->CurrentValue, null, $this->dlv_multipoint_jml->ReadOnly);

            // dlv_term_lain
            $this->dlv_term_lain->setDbValueDef($rsnew, $this->dlv_term_lain->CurrentValue, null, $this->dlv_term_lain->ReadOnly);

            // catatan_khusus
            $this->catatan_khusus->setDbValueDef($rsnew, $this->catatan_khusus->CurrentValue, null, $this->catatan_khusus->ReadOnly);

            // aju_tgl
            $this->aju_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->aju_tgl->CurrentValue, 0), null, $this->aju_tgl->ReadOnly);

            // aju_oleh
            $this->aju_oleh->setDbValueDef($rsnew, $this->aju_oleh->CurrentValue, null, $this->aju_oleh->ReadOnly);

            // proses_tgl
            $this->proses_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->proses_tgl->CurrentValue, 0), null, $this->proses_tgl->ReadOnly);

            // proses_oleh
            $this->proses_oleh->setDbValueDef($rsnew, $this->proses_oleh->CurrentValue, null, $this->proses_oleh->ReadOnly);

            // revisi_tgl
            $this->revisi_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->revisi_tgl->CurrentValue, 0), null, $this->revisi_tgl->ReadOnly);

            // revisi_oleh
            $this->revisi_oleh->setDbValueDef($rsnew, $this->revisi_oleh->CurrentValue, null, $this->revisi_oleh->ReadOnly);

            // revisi_akun_tgl
            $this->revisi_akun_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->revisi_akun_tgl->CurrentValue, 0), null, $this->revisi_akun_tgl->ReadOnly);

            // revisi_akun_oleh
            $this->revisi_akun_oleh->setDbValueDef($rsnew, $this->revisi_akun_oleh->CurrentValue, null, $this->revisi_akun_oleh->ReadOnly);

            // revisi_rnd_tgl
            $this->revisi_rnd_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->revisi_rnd_tgl->CurrentValue, 0), null, $this->revisi_rnd_tgl->ReadOnly);

            // revisi_rnd_oleh
            $this->revisi_rnd_oleh->setDbValueDef($rsnew, $this->revisi_rnd_oleh->CurrentValue, null, $this->revisi_rnd_oleh->ReadOnly);

            // rnd_tgl
            $this->rnd_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->rnd_tgl->CurrentValue, 0), null, $this->rnd_tgl->ReadOnly);

            // rnd_oleh
            $this->rnd_oleh->setDbValueDef($rsnew, $this->rnd_oleh->CurrentValue, null, $this->rnd_oleh->ReadOnly);

            // ap_tgl
            $this->ap_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->ap_tgl->CurrentValue, 0), null, $this->ap_tgl->ReadOnly);

            // ap_oleh
            $this->ap_oleh->setDbValueDef($rsnew, $this->ap_oleh->CurrentValue, null, $this->ap_oleh->ReadOnly);

            // batal_tgl
            $this->batal_tgl->setDbValueDef($rsnew, UnFormatDateTime($this->batal_tgl->CurrentValue, 0), null, $this->batal_tgl->ReadOnly);

            // batal_oleh
            $this->batal_oleh->setDbValueDef($rsnew, $this->batal_oleh->CurrentValue, null, $this->batal_oleh->ReadOnly);

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("OrderPengembanganList"), "", $this->TableVar, true);
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
