<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class OrderPengembanganDelete extends OrderPengembangan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'order_pengembangan';

    // Page object name
    public $PageObjName = "OrderPengembanganDelete";

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
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
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
        $this->produk_lainlain->Visible = false;
        $this->statusproduk->setVisibility();
        $this->parfum->setVisibility();
        $this->catatan->setVisibility();
        $this->rencanakemasan->setVisibility();
        $this->keterangan->Visible = false;
        $this->ekspetasiharga->setVisibility();
        $this->kemasan->setVisibility();
        $this->volume->setVisibility();
        $this->jenistutup->setVisibility();
        $this->catatanpackaging->Visible = false;
        $this->infopackaging->setVisibility();
        $this->ukuran->setVisibility();
        $this->desainprodukkemasan->setVisibility();
        $this->desaindiinginkan->setVisibility();
        $this->mereknotifikasi->setVisibility();
        $this->kategoristatus->setVisibility();
        $this->kemasan_ukuran_satuan->setVisibility();
        $this->notifikasicatatan->Visible = false;
        $this->label_ukuran->Visible = false;
        $this->infolabel->setVisibility();
        $this->labelkualitas->setVisibility();
        $this->labelposisi->setVisibility();
        $this->labelcatatan->Visible = false;
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
        $this->bs_bahan_aktif->Visible = false;
        $this->bs_bahan_lain->Visible = false;
        $this->bs_parfum->Visible = false;
        $this->bs_estetika->Visible = false;
        $this->bs_kms_wadah->Visible = false;
        $this->bs_kms_tutup->Visible = false;
        $this->bs_kms_sekunder->Visible = false;
        $this->bs_label_desain->Visible = false;
        $this->bs_label_cetak->Visible = false;
        $this->bs_label_lain->Visible = false;
        $this->dlv_pickup->Visible = false;
        $this->dlv_singlepoint->Visible = false;
        $this->dlv_multipoint->Visible = false;
        $this->dlv_multipoint_jml->Visible = false;
        $this->dlv_term_lain->Visible = false;
        $this->catatan_khusus->Visible = false;
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("OrderPengembanganList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("OrderPengembanganList"); // Return to list
                return;
            }
        }

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

            // infolabel
            $this->infolabel->ViewValue = $this->infolabel->CurrentValue;
            $this->infolabel->ViewCustomAttributes = "";

            // labelkualitas
            $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
            $this->labelkualitas->ViewCustomAttributes = "";

            // labelposisi
            $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
            $this->labelposisi->ViewCustomAttributes = "";

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
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
        $conn->beginTransaction();

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
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("OrderPengembanganList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
