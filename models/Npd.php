<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd
 */
class Npd extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $idpegawai;
    public $idcustomer;
    public $idbrand;
    public $tanggal_order;
    public $target_selesai;
    public $sifatorder;
    public $kodeorder;
    public $nomororder;
    public $idproduct_acuan;
    public $kategoriproduk;
    public $jenisproduk;
    public $fungsiproduk;
    public $kualitasproduk;
    public $bahan_campaign;
    public $ukuransediaan;
    public $satuansediaan;
    public $bentuk;
    public $viskositas;
    public $warna;
    public $parfum;
    public $aroma;
    public $aplikasi;
    public $aksesoris;
    public $tambahan;
    public $ukurankemasan;
    public $satuankemasan;
    public $kemasanbentuk;
    public $kemasantutup;
    public $kemasancatatan;
    public $labelukuran;
    public $labelbahan;
    public $labelkualitas;
    public $labelposisi;
    public $labelcatatan;
    public $ukuran_utama;
    public $utama_harga_isi;
    public $utama_harga_isi_proyeksi;
    public $utama_harga_primer;
    public $utama_harga_primer_proyeksi;
    public $utama_harga_sekunder;
    public $utama_harga_sekunder_proyeksi;
    public $utama_harga_label;
    public $utama_harga_label_proyeksi;
    public $utama_harga_total;
    public $utama_harga_total_proyeksi;
    public $ukuran_lain;
    public $lain_harga_isi;
    public $lain_harga_isi_proyeksi;
    public $lain_harga_primer;
    public $lain_harga_primer_proyeksi;
    public $lain_harga_sekunder;
    public $lain_harga_sekunder_proyeksi;
    public $lain_harga_label;
    public $lain_harga_label_proyeksi;
    public $lain_harga_total;
    public $lain_harga_total_proyeksi;
    public $delivery_pickup;
    public $delivery_singlepoint;
    public $delivery_multipoint;
    public $delivery_termlain;
    public $status;
    public $readonly;
    public $created_at;
    public $updated_at;
    public $receipt_by;
    public $approve_by;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'npd';
        $this->TableName = 'npd';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = true; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('npd', 'npd', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idpegawai
        $this->idpegawai = new DbField('npd', 'npd', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idpegawai->Required = true; // Required field
        $this->idpegawai->Sortable = true; // Allow sort
        $this->idpegawai->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idpegawai->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idpegawai->Lookup = new Lookup('idpegawai', 'pegawai', false, 'id', ["kode","nama","",""], [], ["x_idcustomer"], [], [], [], [], '', '');
                break;
            default:
                $this->idpegawai->Lookup = new Lookup('idpegawai', 'pegawai', false, 'id', ["kode","nama","",""], [], ["x_idcustomer"], [], [], [], [], '', '');
                break;
        }
        $this->idpegawai->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idpegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idpegawai->Param, "CustomMsg");
        $this->Fields['idpegawai'] = &$this->idpegawai;

        // idcustomer
        $this->idcustomer = new DbField('npd', 'npd', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 20, 20, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idcustomer->Required = true; // Required field
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idcustomer->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], ["x_idpegawai"], ["x_idbrand"], ["idpegawai"], ["x_idpegawai"], [], [], '', '');
                break;
            default:
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], ["x_idpegawai"], ["x_idbrand"], ["idpegawai"], ["x_idpegawai"], [], [], '', '');
                break;
        }
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // idbrand
        $this->idbrand = new DbField('npd', 'npd', 'x_idbrand', 'idbrand', '`idbrand`', '`idbrand`', 20, 20, -1, false, '`idbrand`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idbrand->Sortable = true; // Allow sort
        $this->idbrand->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idbrand->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idbrand->Lookup = new Lookup('idbrand', 'v_brand_customer', false, 'idbrand', ["nama_brand","","",""], ["x_idcustomer"], [], ["idcustomer"], ["x_idcustomer"], [], [], '', '');
                break;
            default:
                $this->idbrand->Lookup = new Lookup('idbrand', 'v_brand_customer', false, 'idbrand', ["nama_brand","","",""], ["x_idcustomer"], [], ["idcustomer"], ["x_idcustomer"], [], [], '', '');
                break;
        }
        $this->idbrand->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idbrand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idbrand->Param, "CustomMsg");
        $this->Fields['idbrand'] = &$this->idbrand;

        // tanggal_order
        $this->tanggal_order = new DbField('npd', 'npd', 'x_tanggal_order', 'tanggal_order', '`tanggal_order`', CastDateFieldForLike("`tanggal_order`", 0, "DB"), 133, 10, 0, false, '`tanggal_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_order->Sortable = true; // Allow sort
        $this->tanggal_order->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_order->Param, "CustomMsg");
        $this->Fields['tanggal_order'] = &$this->tanggal_order;

        // target_selesai
        $this->target_selesai = new DbField('npd', 'npd', 'x_target_selesai', 'target_selesai', '`target_selesai`', CastDateFieldForLike("`target_selesai`", 0, "DB"), 133, 10, 0, false, '`target_selesai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->target_selesai->Sortable = true; // Allow sort
        $this->target_selesai->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->target_selesai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->target_selesai->Param, "CustomMsg");
        $this->Fields['target_selesai'] = &$this->target_selesai;

        // sifatorder
        $this->sifatorder = new DbField('npd', 'npd', 'x_sifatorder', 'sifatorder', '`sifatorder`', '`sifatorder`', 200, 50, -1, false, '`sifatorder`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->sifatorder->Nullable = false; // NOT NULL field
        $this->sifatorder->Required = true; // Required field
        $this->sifatorder->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->sifatorder->Lookup = new Lookup('sifatorder', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->sifatorder->Lookup = new Lookup('sifatorder', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->sifatorder->OptionCount = 3;
        $this->sifatorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sifatorder->Param, "CustomMsg");
        $this->Fields['sifatorder'] = &$this->sifatorder;

        // kodeorder
        $this->kodeorder = new DbField('npd', 'npd', 'x_kodeorder', 'kodeorder', '`kodeorder`', '`kodeorder`', 200, 50, -1, false, '`kodeorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeorder->Required = true; // Required field
        $this->kodeorder->Sortable = true; // Allow sort
        $this->kodeorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeorder->Param, "CustomMsg");
        $this->Fields['kodeorder'] = &$this->kodeorder;

        // nomororder
        $this->nomororder = new DbField('npd', 'npd', 'x_nomororder', 'nomororder', '`nomororder`', '`nomororder`', 200, 50, -1, false, '`nomororder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nomororder->Sortable = true; // Allow sort
        $this->nomororder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nomororder->Param, "CustomMsg");
        $this->Fields['nomororder'] = &$this->nomororder;

        // idproduct_acuan
        $this->idproduct_acuan = new DbField('npd', 'npd', 'x_idproduct_acuan', 'idproduct_acuan', '`idproduct_acuan`', '`idproduct_acuan`', 20, 20, -1, false, '`idproduct_acuan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idproduct_acuan->Sortable = false; // Allow sort
        $this->idproduct_acuan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idproduct_acuan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idproduct_acuan->Lookup = new Lookup('idproduct_acuan', 'product', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idproduct_acuan->Lookup = new Lookup('idproduct_acuan', 'product', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idproduct_acuan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idproduct_acuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idproduct_acuan->Param, "CustomMsg");
        $this->Fields['idproduct_acuan'] = &$this->idproduct_acuan;

        // kategoriproduk
        $this->kategoriproduk = new DbField('npd', 'npd', 'x_kategoriproduk', 'kategoriproduk', '`kategoriproduk`', '`kategoriproduk`', 200, 50, -1, false, '`kategoriproduk`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->kategoriproduk->Sortable = true; // Allow sort
        $this->kategoriproduk->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->kategoriproduk->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->kategoriproduk->Lookup = new Lookup('kategoriproduk', 'npd_master_spesifikasi', true, 'grup', ["grup","","",""], [], ["x_jenisproduk"], [], [], [], [], '`grup` ASC', '');
                break;
            default:
                $this->kategoriproduk->Lookup = new Lookup('kategoriproduk', 'npd_master_spesifikasi', true, 'grup', ["grup","","",""], [], ["x_jenisproduk"], [], [], [], [], '`grup` ASC', '');
                break;
        }
        $this->kategoriproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategoriproduk->Param, "CustomMsg");
        $this->Fields['kategoriproduk'] = &$this->kategoriproduk;

        // jenisproduk
        $this->jenisproduk = new DbField('npd', 'npd', 'x_jenisproduk', 'jenisproduk', '`jenisproduk`', '`jenisproduk`', 200, 50, -1, false, '`jenisproduk`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->jenisproduk->Sortable = true; // Allow sort
        $this->jenisproduk->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->jenisproduk->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->jenisproduk->Lookup = new Lookup('jenisproduk', 'npd_master_spesifikasi', true, 'kategori', ["kategori","","",""], ["x_kategoriproduk"], ["x_bentuk"], ["grup"], ["x_grup"], [], [], '`kategori` ASC', '');
                break;
            default:
                $this->jenisproduk->Lookup = new Lookup('jenisproduk', 'npd_master_spesifikasi', true, 'kategori', ["kategori","","",""], ["x_kategoriproduk"], ["x_bentuk"], ["grup"], ["x_grup"], [], [], '`kategori` ASC', '');
                break;
        }
        $this->jenisproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenisproduk->Param, "CustomMsg");
        $this->Fields['jenisproduk'] = &$this->jenisproduk;

        // fungsiproduk
        $this->fungsiproduk = new DbField('npd', 'npd', 'x_fungsiproduk', 'fungsiproduk', '`fungsiproduk`', '`fungsiproduk`', 200, 255, -1, false, '`fungsiproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fungsiproduk->Sortable = true; // Allow sort
        $this->fungsiproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fungsiproduk->Param, "CustomMsg");
        $this->Fields['fungsiproduk'] = &$this->fungsiproduk;

        // kualitasproduk
        $this->kualitasproduk = new DbField('npd', 'npd', 'x_kualitasproduk', 'kualitasproduk', '`kualitasproduk`', '`kualitasproduk`', 200, 50, -1, false, '`kualitasproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kualitasproduk->Sortable = true; // Allow sort
        $this->kualitasproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kualitasproduk->Param, "CustomMsg");
        $this->Fields['kualitasproduk'] = &$this->kualitasproduk;

        // bahan_campaign
        $this->bahan_campaign = new DbField('npd', 'npd', 'x_bahan_campaign', 'bahan_campaign', '`bahan_campaign`', '`bahan_campaign`', 201, 65535, -1, false, '`bahan_campaign`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bahan_campaign->Sortable = true; // Allow sort
        $this->bahan_campaign->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahan_campaign->Param, "CustomMsg");
        $this->Fields['bahan_campaign'] = &$this->bahan_campaign;

        // ukuransediaan
        $this->ukuransediaan = new DbField('npd', 'npd', 'x_ukuransediaan', 'ukuransediaan', '`ukuransediaan`', '`ukuransediaan`', 200, 255, -1, false, '`ukuransediaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuransediaan->Sortable = true; // Allow sort
        $this->ukuransediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuransediaan->Param, "CustomMsg");
        $this->Fields['ukuransediaan'] = &$this->ukuransediaan;

        // satuansediaan
        $this->satuansediaan = new DbField('npd', 'npd', 'x_satuansediaan', 'satuansediaan', '`satuansediaan`', '`satuansediaan`', 200, 255, -1, false, '`satuansediaan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->satuansediaan->Sortable = true; // Allow sort
        $this->satuansediaan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->satuansediaan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->satuansediaan->Lookup = new Lookup('satuansediaan', 'satuan', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->satuansediaan->Lookup = new Lookup('satuansediaan', 'satuan', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->satuansediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->satuansediaan->Param, "CustomMsg");
        $this->Fields['satuansediaan'] = &$this->satuansediaan;

        // bentuk
        $this->bentuk = new DbField('npd', 'npd', 'x_bentuk', 'bentuk', '`bentuk`', '`bentuk`', 200, 255, -1, false, '`bentuk`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->bentuk->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->bentuk->Lookup = new Lookup('bentuk', 'npd_master_spesifikasi', true, 'sediaan', ["sediaan","","",""], ["x_jenisproduk"], [], ["kategori"], ["x_kategori"], [], [], '`sediaan` ASC', '');
                break;
            default:
                $this->bentuk->Lookup = new Lookup('bentuk', 'npd_master_spesifikasi', true, 'sediaan', ["sediaan","","",""], ["x_jenisproduk"], [], ["kategori"], ["x_kategori"], [], [], '`sediaan` ASC', '');
                break;
        }
        $this->bentuk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentuk->Param, "CustomMsg");
        $this->Fields['bentuk'] = &$this->bentuk;

        // viskositas
        $this->viskositas = new DbField('npd', 'npd', 'x_viskositas', 'viskositas', '`viskositas`', '`viskositas`', 200, 255, -1, false, '`viskositas`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->viskositas->Sortable = true; // Allow sort
        $this->viskositas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->viskositas->Param, "CustomMsg");
        $this->Fields['viskositas'] = &$this->viskositas;

        // warna
        $this->warna = new DbField('npd', 'npd', 'x_warna', 'warna', '`warna`', '`warna`', 200, 255, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warna->Sortable = true; // Allow sort
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // parfum
        $this->parfum = new DbField('npd', 'npd', 'x_parfum', 'parfum', '`parfum`', '`parfum`', 200, 255, -1, false, '`parfum`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->parfum->Sortable = true; // Allow sort
        $this->parfum->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->parfum->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->parfum->Lookup = new Lookup('parfum', 'npd_master_spesifikasi', true, 'fragrance', ["fragrance","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->parfum->Lookup = new Lookup('parfum', 'npd_master_spesifikasi', true, 'fragrance', ["fragrance","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->parfum->Param, "CustomMsg");
        $this->Fields['parfum'] = &$this->parfum;

        // aroma
        $this->aroma = new DbField('npd', 'npd', 'x_aroma', 'aroma', '`aroma`', '`aroma`', 200, 255, -1, false, '`aroma`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aroma->Sortable = true; // Allow sort
        $this->aroma->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aroma->Param, "CustomMsg");
        $this->Fields['aroma'] = &$this->aroma;

        // aplikasi
        $this->aplikasi = new DbField('npd', 'npd', 'x_aplikasi', 'aplikasi', '`aplikasi`', '`aplikasi`', 200, 255, -1, false, '`aplikasi`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->aplikasi->Sortable = true; // Allow sort
        $this->aplikasi->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->aplikasi->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasi->Lookup = new Lookup('aplikasi', 'npd_master_spesifikasi', true, 'aplikasi_sediaan', ["aplikasi_sediaan","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasi->Lookup = new Lookup('aplikasi', 'npd_master_spesifikasi', true, 'aplikasi_sediaan', ["aplikasi_sediaan","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasi->Param, "CustomMsg");
        $this->Fields['aplikasi'] = &$this->aplikasi;

        // aksesoris
        $this->aksesoris = new DbField('npd', 'npd', 'x_aksesoris', 'aksesoris', '`aksesoris`', '`aksesoris`', 200, 255, -1, false, '`aksesoris`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aksesoris->Sortable = true; // Allow sort
        $this->aksesoris->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aksesoris->Param, "CustomMsg");
        $this->Fields['aksesoris'] = &$this->aksesoris;

        // tambahan
        $this->tambahan = new DbField('npd', 'npd', 'x_tambahan', 'tambahan', '`tambahan`', '`tambahan`', 201, 65535, -1, false, '`tambahan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->tambahan->Sortable = true; // Allow sort
        $this->tambahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tambahan->Param, "CustomMsg");
        $this->Fields['tambahan'] = &$this->tambahan;

        // ukurankemasan
        $this->ukurankemasan = new DbField('npd', 'npd', 'x_ukurankemasan', 'ukurankemasan', '`ukurankemasan`', '`ukurankemasan`', 200, 255, -1, false, '`ukurankemasan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukurankemasan->Sortable = true; // Allow sort
        $this->ukurankemasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukurankemasan->Param, "CustomMsg");
        $this->Fields['ukurankemasan'] = &$this->ukurankemasan;

        // satuankemasan
        $this->satuankemasan = new DbField('npd', 'npd', 'x_satuankemasan', 'satuankemasan', '`satuankemasan`', '`satuankemasan`', 200, 255, -1, false, '`satuankemasan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->satuankemasan->Sortable = true; // Allow sort
        $this->satuankemasan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->satuankemasan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->satuankemasan->Lookup = new Lookup('satuankemasan', 'satuan', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->satuankemasan->Lookup = new Lookup('satuankemasan', 'satuan', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->satuankemasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->satuankemasan->Param, "CustomMsg");
        $this->Fields['satuankemasan'] = &$this->satuankemasan;

        // kemasanbentuk
        $this->kemasanbentuk = new DbField('npd', 'npd', 'x_kemasanbentuk', 'kemasanbentuk', '`kemasanbentuk`', '`kemasanbentuk`', 200, 255, -1, false, '`kemasanbentuk`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->kemasanbentuk->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kemasanbentuk->Lookup = new Lookup('kemasanbentuk', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kemasanbentuk->Lookup = new Lookup('kemasanbentuk', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kemasanbentuk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasanbentuk->Param, "CustomMsg");
        $this->Fields['kemasanbentuk'] = &$this->kemasanbentuk;

        // kemasantutup
        $this->kemasantutup = new DbField('npd', 'npd', 'x_kemasantutup', 'kemasantutup', '`kemasantutup`', '`kemasantutup`', 200, 255, -1, false, '`kemasantutup`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->kemasantutup->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kemasantutup->Lookup = new Lookup('kemasantutup', 'npd_master_kemasan', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kemasantutup->Lookup = new Lookup('kemasantutup', 'npd_master_kemasan', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kemasantutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasantutup->Param, "CustomMsg");
        $this->Fields['kemasantutup'] = &$this->kemasantutup;

        // kemasancatatan
        $this->kemasancatatan = new DbField('npd', 'npd', 'x_kemasancatatan', 'kemasancatatan', '`kemasancatatan`', '`kemasancatatan`', 201, 65535, -1, false, '`kemasancatatan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->kemasancatatan->Sortable = true; // Allow sort
        $this->kemasancatatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasancatatan->Param, "CustomMsg");
        $this->Fields['kemasancatatan'] = &$this->kemasancatatan;

        // labelukuran
        $this->labelukuran = new DbField('npd', 'npd', 'x_labelukuran', 'labelukuran', '`labelukuran`', '`labelukuran`', 200, 255, -1, false, '`labelukuran`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->labelukuran->Sortable = true; // Allow sort
        $this->labelukuran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelukuran->Param, "CustomMsg");
        $this->Fields['labelukuran'] = &$this->labelukuran;

        // labelbahan
        $this->labelbahan = new DbField('npd', 'npd', 'x_labelbahan', 'labelbahan', '`labelbahan`', '`labelbahan`', 200, 255, -1, false, '`labelbahan`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->labelbahan->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->labelbahan->Lookup = new Lookup('labelbahan', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->labelbahan->Lookup = new Lookup('labelbahan', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->labelbahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelbahan->Param, "CustomMsg");
        $this->Fields['labelbahan'] = &$this->labelbahan;

        // labelkualitas
        $this->labelkualitas = new DbField('npd', 'npd', 'x_labelkualitas', 'labelkualitas', '`labelkualitas`', '`labelkualitas`', 200, 255, -1, false, '`labelkualitas`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->labelkualitas->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->labelkualitas->Lookup = new Lookup('labelkualitas', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->labelkualitas->Lookup = new Lookup('labelkualitas', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->labelkualitas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelkualitas->Param, "CustomMsg");
        $this->Fields['labelkualitas'] = &$this->labelkualitas;

        // labelposisi
        $this->labelposisi = new DbField('npd', 'npd', 'x_labelposisi', 'labelposisi', '`labelposisi`', '`labelposisi`', 200, 255, -1, false, '`labelposisi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->labelposisi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->labelposisi->Lookup = new Lookup('labelposisi', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->labelposisi->Lookup = new Lookup('labelposisi', 'npd_master_kemasan', true, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->labelposisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelposisi->Param, "CustomMsg");
        $this->Fields['labelposisi'] = &$this->labelposisi;

        // labelcatatan
        $this->labelcatatan = new DbField('npd', 'npd', 'x_labelcatatan', 'labelcatatan', '`labelcatatan`', '`labelcatatan`', 201, 65535, -1, false, '`labelcatatan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->labelcatatan->Sortable = true; // Allow sort
        $this->labelcatatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelcatatan->Param, "CustomMsg");
        $this->Fields['labelcatatan'] = &$this->labelcatatan;

        // ukuran_utama
        $this->ukuran_utama = new DbField('npd', 'npd', 'x_ukuran_utama', 'ukuran_utama', '`ukuran_utama`', '`ukuran_utama`', 200, 50, -1, false, '`ukuran_utama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran_utama->Sortable = true; // Allow sort
        $this->ukuran_utama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran_utama->Param, "CustomMsg");
        $this->Fields['ukuran_utama'] = &$this->ukuran_utama;

        // utama_harga_isi
        $this->utama_harga_isi = new DbField('npd', 'npd', 'x_utama_harga_isi', 'utama_harga_isi', '`utama_harga_isi`', '`utama_harga_isi`', 20, 20, -1, false, '`utama_harga_isi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_isi->Sortable = true; // Allow sort
        $this->utama_harga_isi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_isi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_isi->Param, "CustomMsg");
        $this->Fields['utama_harga_isi'] = &$this->utama_harga_isi;

        // utama_harga_isi_proyeksi
        $this->utama_harga_isi_proyeksi = new DbField('npd', 'npd', 'x_utama_harga_isi_proyeksi', 'utama_harga_isi_proyeksi', '`utama_harga_isi_proyeksi`', '`utama_harga_isi_proyeksi`', 20, 20, -1, false, '`utama_harga_isi_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_isi_proyeksi->Sortable = true; // Allow sort
        $this->utama_harga_isi_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_isi_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_isi_proyeksi->Param, "CustomMsg");
        $this->Fields['utama_harga_isi_proyeksi'] = &$this->utama_harga_isi_proyeksi;

        // utama_harga_primer
        $this->utama_harga_primer = new DbField('npd', 'npd', 'x_utama_harga_primer', 'utama_harga_primer', '`utama_harga_primer`', '`utama_harga_primer`', 20, 20, -1, false, '`utama_harga_primer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_primer->Sortable = true; // Allow sort
        $this->utama_harga_primer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_primer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_primer->Param, "CustomMsg");
        $this->Fields['utama_harga_primer'] = &$this->utama_harga_primer;

        // utama_harga_primer_proyeksi
        $this->utama_harga_primer_proyeksi = new DbField('npd', 'npd', 'x_utama_harga_primer_proyeksi', 'utama_harga_primer_proyeksi', '`utama_harga_primer_proyeksi`', '`utama_harga_primer_proyeksi`', 20, 20, -1, false, '`utama_harga_primer_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_primer_proyeksi->Sortable = true; // Allow sort
        $this->utama_harga_primer_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_primer_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_primer_proyeksi->Param, "CustomMsg");
        $this->Fields['utama_harga_primer_proyeksi'] = &$this->utama_harga_primer_proyeksi;

        // utama_harga_sekunder
        $this->utama_harga_sekunder = new DbField('npd', 'npd', 'x_utama_harga_sekunder', 'utama_harga_sekunder', '`utama_harga_sekunder`', '`utama_harga_sekunder`', 20, 20, -1, false, '`utama_harga_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_sekunder->Sortable = true; // Allow sort
        $this->utama_harga_sekunder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_sekunder->Param, "CustomMsg");
        $this->Fields['utama_harga_sekunder'] = &$this->utama_harga_sekunder;

        // utama_harga_sekunder_proyeksi
        $this->utama_harga_sekunder_proyeksi = new DbField('npd', 'npd', 'x_utama_harga_sekunder_proyeksi', 'utama_harga_sekunder_proyeksi', '`utama_harga_sekunder_proyeksi`', '`utama_harga_sekunder_proyeksi`', 20, 20, -1, false, '`utama_harga_sekunder_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_sekunder_proyeksi->Sortable = true; // Allow sort
        $this->utama_harga_sekunder_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_sekunder_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_sekunder_proyeksi->Param, "CustomMsg");
        $this->Fields['utama_harga_sekunder_proyeksi'] = &$this->utama_harga_sekunder_proyeksi;

        // utama_harga_label
        $this->utama_harga_label = new DbField('npd', 'npd', 'x_utama_harga_label', 'utama_harga_label', '`utama_harga_label`', '`utama_harga_label`', 20, 20, -1, false, '`utama_harga_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_label->Sortable = true; // Allow sort
        $this->utama_harga_label->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_label->Param, "CustomMsg");
        $this->Fields['utama_harga_label'] = &$this->utama_harga_label;

        // utama_harga_label_proyeksi
        $this->utama_harga_label_proyeksi = new DbField('npd', 'npd', 'x_utama_harga_label_proyeksi', 'utama_harga_label_proyeksi', '`utama_harga_label_proyeksi`', '`utama_harga_label_proyeksi`', 20, 20, -1, false, '`utama_harga_label_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_label_proyeksi->Sortable = true; // Allow sort
        $this->utama_harga_label_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_label_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_label_proyeksi->Param, "CustomMsg");
        $this->Fields['utama_harga_label_proyeksi'] = &$this->utama_harga_label_proyeksi;

        // utama_harga_total
        $this->utama_harga_total = new DbField('npd', 'npd', 'x_utama_harga_total', 'utama_harga_total', '`utama_harga_total`', '`utama_harga_total`', 20, 20, -1, false, '`utama_harga_total`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_total->Sortable = true; // Allow sort
        $this->utama_harga_total->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_total->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_total->Param, "CustomMsg");
        $this->Fields['utama_harga_total'] = &$this->utama_harga_total;

        // utama_harga_total_proyeksi
        $this->utama_harga_total_proyeksi = new DbField('npd', 'npd', 'x_utama_harga_total_proyeksi', 'utama_harga_total_proyeksi', '`utama_harga_total_proyeksi`', '`utama_harga_total_proyeksi`', 20, 20, -1, false, '`utama_harga_total_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_total_proyeksi->Sortable = true; // Allow sort
        $this->utama_harga_total_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_total_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_total_proyeksi->Param, "CustomMsg");
        $this->Fields['utama_harga_total_proyeksi'] = &$this->utama_harga_total_proyeksi;

        // ukuran_lain
        $this->ukuran_lain = new DbField('npd', 'npd', 'x_ukuran_lain', 'ukuran_lain', '`ukuran_lain`', '`ukuran_lain`', 200, 50, -1, false, '`ukuran_lain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran_lain->Sortable = true; // Allow sort
        $this->ukuran_lain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran_lain->Param, "CustomMsg");
        $this->Fields['ukuran_lain'] = &$this->ukuran_lain;

        // lain_harga_isi
        $this->lain_harga_isi = new DbField('npd', 'npd', 'x_lain_harga_isi', 'lain_harga_isi', '`lain_harga_isi`', '`lain_harga_isi`', 20, 20, -1, false, '`lain_harga_isi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_isi->Sortable = true; // Allow sort
        $this->lain_harga_isi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_isi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_isi->Param, "CustomMsg");
        $this->Fields['lain_harga_isi'] = &$this->lain_harga_isi;

        // lain_harga_isi_proyeksi
        $this->lain_harga_isi_proyeksi = new DbField('npd', 'npd', 'x_lain_harga_isi_proyeksi', 'lain_harga_isi_proyeksi', '`lain_harga_isi_proyeksi`', '`lain_harga_isi_proyeksi`', 20, 20, -1, false, '`lain_harga_isi_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_isi_proyeksi->Sortable = true; // Allow sort
        $this->lain_harga_isi_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_isi_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_isi_proyeksi->Param, "CustomMsg");
        $this->Fields['lain_harga_isi_proyeksi'] = &$this->lain_harga_isi_proyeksi;

        // lain_harga_primer
        $this->lain_harga_primer = new DbField('npd', 'npd', 'x_lain_harga_primer', 'lain_harga_primer', '`lain_harga_primer`', '`lain_harga_primer`', 20, 20, -1, false, '`lain_harga_primer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_primer->Sortable = true; // Allow sort
        $this->lain_harga_primer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_primer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_primer->Param, "CustomMsg");
        $this->Fields['lain_harga_primer'] = &$this->lain_harga_primer;

        // lain_harga_primer_proyeksi
        $this->lain_harga_primer_proyeksi = new DbField('npd', 'npd', 'x_lain_harga_primer_proyeksi', 'lain_harga_primer_proyeksi', '`lain_harga_primer_proyeksi`', '`lain_harga_primer_proyeksi`', 20, 20, -1, false, '`lain_harga_primer_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_primer_proyeksi->Sortable = true; // Allow sort
        $this->lain_harga_primer_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_primer_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_primer_proyeksi->Param, "CustomMsg");
        $this->Fields['lain_harga_primer_proyeksi'] = &$this->lain_harga_primer_proyeksi;

        // lain_harga_sekunder
        $this->lain_harga_sekunder = new DbField('npd', 'npd', 'x_lain_harga_sekunder', 'lain_harga_sekunder', '`lain_harga_sekunder`', '`lain_harga_sekunder`', 20, 20, -1, false, '`lain_harga_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_sekunder->Sortable = true; // Allow sort
        $this->lain_harga_sekunder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_sekunder->Param, "CustomMsg");
        $this->Fields['lain_harga_sekunder'] = &$this->lain_harga_sekunder;

        // lain_harga_sekunder_proyeksi
        $this->lain_harga_sekunder_proyeksi = new DbField('npd', 'npd', 'x_lain_harga_sekunder_proyeksi', 'lain_harga_sekunder_proyeksi', '`lain_harga_sekunder_proyeksi`', '`lain_harga_sekunder_proyeksi`', 20, 20, -1, false, '`lain_harga_sekunder_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_sekunder_proyeksi->Sortable = true; // Allow sort
        $this->lain_harga_sekunder_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_sekunder_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_sekunder_proyeksi->Param, "CustomMsg");
        $this->Fields['lain_harga_sekunder_proyeksi'] = &$this->lain_harga_sekunder_proyeksi;

        // lain_harga_label
        $this->lain_harga_label = new DbField('npd', 'npd', 'x_lain_harga_label', 'lain_harga_label', '`lain_harga_label`', '`lain_harga_label`', 20, 20, -1, false, '`lain_harga_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_label->Sortable = true; // Allow sort
        $this->lain_harga_label->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_label->Param, "CustomMsg");
        $this->Fields['lain_harga_label'] = &$this->lain_harga_label;

        // lain_harga_label_proyeksi
        $this->lain_harga_label_proyeksi = new DbField('npd', 'npd', 'x_lain_harga_label_proyeksi', 'lain_harga_label_proyeksi', '`lain_harga_label_proyeksi`', '`lain_harga_label_proyeksi`', 20, 20, -1, false, '`lain_harga_label_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_label_proyeksi->Sortable = true; // Allow sort
        $this->lain_harga_label_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_label_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_label_proyeksi->Param, "CustomMsg");
        $this->Fields['lain_harga_label_proyeksi'] = &$this->lain_harga_label_proyeksi;

        // lain_harga_total
        $this->lain_harga_total = new DbField('npd', 'npd', 'x_lain_harga_total', 'lain_harga_total', '`lain_harga_total`', '`lain_harga_total`', 20, 20, -1, false, '`lain_harga_total`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_total->Sortable = true; // Allow sort
        $this->lain_harga_total->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_total->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_total->Param, "CustomMsg");
        $this->Fields['lain_harga_total'] = &$this->lain_harga_total;

        // lain_harga_total_proyeksi
        $this->lain_harga_total_proyeksi = new DbField('npd', 'npd', 'x_lain_harga_total_proyeksi', 'lain_harga_total_proyeksi', '`lain_harga_total_proyeksi`', '`lain_harga_total_proyeksi`', 20, 20, -1, false, '`lain_harga_total_proyeksi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_total_proyeksi->Sortable = true; // Allow sort
        $this->lain_harga_total_proyeksi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_total_proyeksi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_total_proyeksi->Param, "CustomMsg");
        $this->Fields['lain_harga_total_proyeksi'] = &$this->lain_harga_total_proyeksi;

        // delivery_pickup
        $this->delivery_pickup = new DbField('npd', 'npd', 'x_delivery_pickup', 'delivery_pickup', '`delivery_pickup`', '`delivery_pickup`', 200, 255, -1, false, '`delivery_pickup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_pickup->Sortable = true; // Allow sort
        $this->delivery_pickup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_pickup->Param, "CustomMsg");
        $this->Fields['delivery_pickup'] = &$this->delivery_pickup;

        // delivery_singlepoint
        $this->delivery_singlepoint = new DbField('npd', 'npd', 'x_delivery_singlepoint', 'delivery_singlepoint', '`delivery_singlepoint`', '`delivery_singlepoint`', 200, 255, -1, false, '`delivery_singlepoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_singlepoint->Sortable = true; // Allow sort
        $this->delivery_singlepoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_singlepoint->Param, "CustomMsg");
        $this->Fields['delivery_singlepoint'] = &$this->delivery_singlepoint;

        // delivery_multipoint
        $this->delivery_multipoint = new DbField('npd', 'npd', 'x_delivery_multipoint', 'delivery_multipoint', '`delivery_multipoint`', '`delivery_multipoint`', 200, 255, -1, false, '`delivery_multipoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_multipoint->Sortable = true; // Allow sort
        $this->delivery_multipoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_multipoint->Param, "CustomMsg");
        $this->Fields['delivery_multipoint'] = &$this->delivery_multipoint;

        // delivery_termlain
        $this->delivery_termlain = new DbField('npd', 'npd', 'x_delivery_termlain', 'delivery_termlain', '`delivery_termlain`', '`delivery_termlain`', 200, 255, -1, false, '`delivery_termlain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_termlain->Sortable = true; // Allow sort
        $this->delivery_termlain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_termlain->Param, "CustomMsg");
        $this->Fields['delivery_termlain'] = &$this->delivery_termlain;

        // status
        $this->status = new DbField('npd', 'npd', 'x_status', 'status', '`status`', '`status`', 200, 50, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        $this->status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->status->Lookup = new Lookup('status', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->status->OptionCount = 2;
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // readonly
        $this->readonly = new DbField('npd', 'npd', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->readonly->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->readonly->Lookup = new Lookup('readonly', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->readonly->Lookup = new Lookup('readonly', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->readonly->OptionCount = 2;
        $this->readonly->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->readonly->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->readonly->Param, "CustomMsg");
        $this->Fields['readonly'] = &$this->readonly;

        // created_at
        $this->created_at = new DbField('npd', 'npd', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 11, "DB"), 135, 19, 11, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('npd', 'npd', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 17, "DB"), 135, 19, 17, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Nullable = false; // NOT NULL field
        $this->updated_at->Required = true; // Required field
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectShortDateDMY"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;

        // receipt_by
        $this->receipt_by = new DbField('npd', 'npd', 'x_receipt_by', 'receipt_by', '`receipt_by`', '`receipt_by`', 3, 11, -1, false, '`receipt_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->receipt_by->Sortable = true; // Allow sort
        $this->receipt_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->receipt_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->receipt_by->Param, "CustomMsg");
        $this->Fields['receipt_by'] = &$this->receipt_by;

        // approve_by
        $this->approve_by = new DbField('npd', 'npd', 'x_approve_by', 'approve_by', '`approve_by`', '`approve_by`', 3, 11, -1, false, '`approve_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->approve_by->Sortable = true; // Allow sort
        $this->approve_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->approve_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->approve_by->Param, "CustomMsg");
        $this->Fields['approve_by'] = &$this->approve_by;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "npd_sample") {
            $detailUrl = Container("npd_sample")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "npd_review") {
            $detailUrl = Container("npd_review")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "npd_confirm") {
            $detailUrl = Container("npd_confirm")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "npd_harga") {
            $detailUrl = Container("npd_harga")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "npd_desain") {
            $detailUrl = Container("npd_desain")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "NpdList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // Cascade Update detail table 'npd_sample'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'idnpd'
            $cascadeUpdate = true;
            $rscascade['idnpd'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("npd_sample")->loadRs("`idnpd` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("npd_sample")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("npd_sample")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("npd_sample")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'npd_review'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'idnpd'
            $cascadeUpdate = true;
            $rscascade['idnpd'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("npd_review")->loadRs("`idnpd` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("npd_review")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("npd_review")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("npd_review")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'npd_confirm'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'idnpd'
            $cascadeUpdate = true;
            $rscascade['idnpd'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("npd_confirm")->loadRs("`idnpd` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("npd_confirm")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("npd_confirm")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("npd_confirm")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'npd_harga'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'idnpd'
            $cascadeUpdate = true;
            $rscascade['idnpd'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("npd_harga")->loadRs("`idnpd` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("npd_harga")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("npd_harga")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("npd_harga")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'npd_desain'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'idnpd'
            $cascadeUpdate = true;
            $rscascade['idnpd'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("npd_desain")->loadRs("`idnpd` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("npd_desain")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("npd_desain")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("npd_desain")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;

        // Cascade delete detail table 'npd_sample'
        $dtlrows = Container("npd_sample")->loadRs("`idnpd` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("npd_sample")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("npd_sample")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("npd_sample")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'npd_review'
        $dtlrows = Container("npd_review")->loadRs("`idnpd` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("npd_review")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("npd_review")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("npd_review")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'npd_confirm'
        $dtlrows = Container("npd_confirm")->loadRs("`idnpd` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("npd_confirm")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("npd_confirm")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("npd_confirm")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'npd_harga'
        $dtlrows = Container("npd_harga")->loadRs("`idnpd` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("npd_harga")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("npd_harga")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("npd_harga")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'npd_desain'
        $dtlrows = Container("npd_desain")->loadRs("`idnpd` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("npd_desain")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("npd_desain")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("npd_desain")->rowDeleted($dtlrow);
            }
        }
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->idbrand->DbValue = $row['idbrand'];
        $this->tanggal_order->DbValue = $row['tanggal_order'];
        $this->target_selesai->DbValue = $row['target_selesai'];
        $this->sifatorder->DbValue = $row['sifatorder'];
        $this->kodeorder->DbValue = $row['kodeorder'];
        $this->nomororder->DbValue = $row['nomororder'];
        $this->idproduct_acuan->DbValue = $row['idproduct_acuan'];
        $this->kategoriproduk->DbValue = $row['kategoriproduk'];
        $this->jenisproduk->DbValue = $row['jenisproduk'];
        $this->fungsiproduk->DbValue = $row['fungsiproduk'];
        $this->kualitasproduk->DbValue = $row['kualitasproduk'];
        $this->bahan_campaign->DbValue = $row['bahan_campaign'];
        $this->ukuransediaan->DbValue = $row['ukuransediaan'];
        $this->satuansediaan->DbValue = $row['satuansediaan'];
        $this->bentuk->DbValue = $row['bentuk'];
        $this->viskositas->DbValue = $row['viskositas'];
        $this->warna->DbValue = $row['warna'];
        $this->parfum->DbValue = $row['parfum'];
        $this->aroma->DbValue = $row['aroma'];
        $this->aplikasi->DbValue = $row['aplikasi'];
        $this->aksesoris->DbValue = $row['aksesoris'];
        $this->tambahan->DbValue = $row['tambahan'];
        $this->ukurankemasan->DbValue = $row['ukurankemasan'];
        $this->satuankemasan->DbValue = $row['satuankemasan'];
        $this->kemasanbentuk->DbValue = $row['kemasanbentuk'];
        $this->kemasantutup->DbValue = $row['kemasantutup'];
        $this->kemasancatatan->DbValue = $row['kemasancatatan'];
        $this->labelukuran->DbValue = $row['labelukuran'];
        $this->labelbahan->DbValue = $row['labelbahan'];
        $this->labelkualitas->DbValue = $row['labelkualitas'];
        $this->labelposisi->DbValue = $row['labelposisi'];
        $this->labelcatatan->DbValue = $row['labelcatatan'];
        $this->ukuran_utama->DbValue = $row['ukuran_utama'];
        $this->utama_harga_isi->DbValue = $row['utama_harga_isi'];
        $this->utama_harga_isi_proyeksi->DbValue = $row['utama_harga_isi_proyeksi'];
        $this->utama_harga_primer->DbValue = $row['utama_harga_primer'];
        $this->utama_harga_primer_proyeksi->DbValue = $row['utama_harga_primer_proyeksi'];
        $this->utama_harga_sekunder->DbValue = $row['utama_harga_sekunder'];
        $this->utama_harga_sekunder_proyeksi->DbValue = $row['utama_harga_sekunder_proyeksi'];
        $this->utama_harga_label->DbValue = $row['utama_harga_label'];
        $this->utama_harga_label_proyeksi->DbValue = $row['utama_harga_label_proyeksi'];
        $this->utama_harga_total->DbValue = $row['utama_harga_total'];
        $this->utama_harga_total_proyeksi->DbValue = $row['utama_harga_total_proyeksi'];
        $this->ukuran_lain->DbValue = $row['ukuran_lain'];
        $this->lain_harga_isi->DbValue = $row['lain_harga_isi'];
        $this->lain_harga_isi_proyeksi->DbValue = $row['lain_harga_isi_proyeksi'];
        $this->lain_harga_primer->DbValue = $row['lain_harga_primer'];
        $this->lain_harga_primer_proyeksi->DbValue = $row['lain_harga_primer_proyeksi'];
        $this->lain_harga_sekunder->DbValue = $row['lain_harga_sekunder'];
        $this->lain_harga_sekunder_proyeksi->DbValue = $row['lain_harga_sekunder_proyeksi'];
        $this->lain_harga_label->DbValue = $row['lain_harga_label'];
        $this->lain_harga_label_proyeksi->DbValue = $row['lain_harga_label_proyeksi'];
        $this->lain_harga_total->DbValue = $row['lain_harga_total'];
        $this->lain_harga_total_proyeksi->DbValue = $row['lain_harga_total_proyeksi'];
        $this->delivery_pickup->DbValue = $row['delivery_pickup'];
        $this->delivery_singlepoint->DbValue = $row['delivery_singlepoint'];
        $this->delivery_multipoint->DbValue = $row['delivery_multipoint'];
        $this->delivery_termlain->DbValue = $row['delivery_termlain'];
        $this->status->DbValue = $row['status'];
        $this->readonly->DbValue = $row['readonly'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
        $this->receipt_by->DbValue = $row['receipt_by'];
        $this->approve_by->DbValue = $row['approve_by'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("NpdList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "NpdView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "NpdView";
            case Config("API_ADD_ACTION"):
                return "NpdAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdDelete";
            case Config("API_LIST_ACTION"):
                return "NpdList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("NpdDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
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
        $this->aksesoris->setDbValue($row['aksesoris']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->satuankemasan->setDbValue($row['satuankemasan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->labelukuran->setDbValue($row['labelukuran']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
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
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->receipt_by->setDbValue($row['receipt_by']);
        $this->approve_by->setDbValue($row['approve_by']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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
        $this->idproduct_acuan->CellCssStyle = "white-space: nowrap;";

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

        // aksesoris

        // tambahan

        // ukurankemasan

        // satuankemasan

        // kemasanbentuk

        // kemasantutup

        // kemasancatatan

        // labelukuran

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

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

        // created_at

        // updated_at

        // receipt_by

        // approve_by

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
                $filterWrk = "`grup`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
                $filterWrk = "`kategori`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
        $this->kualitasproduk->ViewValue = $this->kualitasproduk->CurrentValue;
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
                $filterWrk = "`sediaan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
        $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
        $this->viskositas->ViewCustomAttributes = "";

        // warna
        $this->warna->ViewValue = $this->warna->CurrentValue;
        $this->warna->ViewCustomAttributes = "";

        // parfum
        $curVal = trim(strval($this->parfum->CurrentValue));
        if ($curVal != "") {
            $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
            if ($this->parfum->ViewValue === null) { // Lookup from database
                $filterWrk = "`fragrance`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
                $filterWrk = "`aplikasi_sediaan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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

        // aksesoris
        $this->aksesoris->ViewValue = $this->aksesoris->CurrentValue;
        $this->aksesoris->ViewCustomAttributes = "";

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

        // kemasanbentuk
        $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
        if ($curVal != "") {
            $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
            if ($this->kemasanbentuk->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kemasanbentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->kemasanbentuk->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->kemasanbentuk->Lookup->renderViewRow($row);
                        $this->kemasanbentuk->ViewValue->add($this->kemasanbentuk->displayValue($arwrk));
                    }
                } else {
                    $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->CurrentValue;
                }
            }
        } else {
            $this->kemasanbentuk->ViewValue = null;
        }
        $this->kemasanbentuk->ViewCustomAttributes = "";

        // kemasantutup
        $curVal = trim(strval($this->kemasantutup->CurrentValue));
        if ($curVal != "") {
            $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
            if ($this->kemasantutup->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kemasantutup->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->kemasantutup->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->kemasantutup->Lookup->renderViewRow($row);
                        $this->kemasantutup->ViewValue->add($this->kemasantutup->displayValue($arwrk));
                    }
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

        // labelukuran
        $this->labelukuran->ViewValue = $this->labelukuran->CurrentValue;
        $this->labelukuran->ViewCustomAttributes = "";

        // labelbahan
        $curVal = trim(strval($this->labelbahan->CurrentValue));
        if ($curVal != "") {
            $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
            if ($this->labelbahan->ViewValue === null) { // Lookup from database
                $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
                $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
                $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 11);
        $this->created_at->ViewCustomAttributes = "";

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 17);
        $this->updated_at->ViewCustomAttributes = "";

        // receipt_by
        $this->receipt_by->ViewValue = $this->receipt_by->CurrentValue;
        $this->receipt_by->ViewValue = FormatNumber($this->receipt_by->ViewValue, 0, -2, -2, -2);
        $this->receipt_by->ViewCustomAttributes = "";

        // approve_by
        $this->approve_by->ViewValue = $this->approve_by->CurrentValue;
        $this->approve_by->ViewValue = FormatNumber($this->approve_by->ViewValue, 0, -2, -2, -2);
        $this->approve_by->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // aksesoris
        $this->aksesoris->LinkCustomAttributes = "";
        $this->aksesoris->HrefValue = "";
        $this->aksesoris->TooltipValue = "";

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

        // kemasanbentuk
        $this->kemasanbentuk->LinkCustomAttributes = "";
        $this->kemasanbentuk->HrefValue = "";
        $this->kemasanbentuk->TooltipValue = "";

        // kemasantutup
        $this->kemasantutup->LinkCustomAttributes = "";
        $this->kemasantutup->HrefValue = "";
        $this->kemasantutup->TooltipValue = "";

        // kemasancatatan
        $this->kemasancatatan->LinkCustomAttributes = "";
        $this->kemasancatatan->HrefValue = "";
        $this->kemasancatatan->TooltipValue = "";

        // labelukuran
        $this->labelukuran->LinkCustomAttributes = "";
        $this->labelukuran->HrefValue = "";
        $this->labelukuran->TooltipValue = "";

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

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

        // receipt_by
        $this->receipt_by->LinkCustomAttributes = "";
        $this->receipt_by->HrefValue = "";
        $this->receipt_by->TooltipValue = "";

        // approve_by
        $this->approve_by->LinkCustomAttributes = "";
        $this->approve_by->HrefValue = "";
        $this->approve_by->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->EditAttrs["class"] = "form-control";
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idpegawai
        $this->idpegawai->EditAttrs["class"] = "form-control";
        $this->idpegawai->EditCustomAttributes = "";
        $curVal = trim(strval($this->idpegawai->CurrentValue));
        if ($curVal != "") {
            $this->idpegawai->EditValue = $this->idpegawai->lookupCacheOption($curVal);
            if ($this->idpegawai->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idpegawai->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idpegawai->Lookup->renderViewRow($rswrk[0]);
                    $this->idpegawai->EditValue = $this->idpegawai->displayValue($arwrk);
                } else {
                    $this->idpegawai->EditValue = $this->idpegawai->CurrentValue;
                }
            }
        } else {
            $this->idpegawai->EditValue = null;
        }
        $this->idpegawai->ViewCustomAttributes = "";

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        $curVal = trim(strval($this->idcustomer->CurrentValue));
        if ($curVal != "") {
            $this->idcustomer->EditValue = $this->idcustomer->lookupCacheOption($curVal);
            if ($this->idcustomer->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                    $this->idcustomer->EditValue = $this->idcustomer->displayValue($arwrk);
                } else {
                    $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
                }
            }
        } else {
            $this->idcustomer->EditValue = null;
        }
        $this->idcustomer->ViewCustomAttributes = "";

        // idbrand
        $this->idbrand->EditAttrs["class"] = "form-control";
        $this->idbrand->EditCustomAttributes = "";
        $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());

        // tanggal_order
        $this->tanggal_order->EditAttrs["class"] = "form-control";
        $this->tanggal_order->EditCustomAttributes = "";
        $this->tanggal_order->EditValue = FormatDateTime($this->tanggal_order->CurrentValue, 8);
        $this->tanggal_order->PlaceHolder = RemoveHtml($this->tanggal_order->caption());

        // target_selesai
        $this->target_selesai->EditAttrs["class"] = "form-control";
        $this->target_selesai->EditCustomAttributes = "";
        $this->target_selesai->EditValue = FormatDateTime($this->target_selesai->CurrentValue, 8);
        $this->target_selesai->PlaceHolder = RemoveHtml($this->target_selesai->caption());

        // sifatorder
        $this->sifatorder->EditCustomAttributes = "";
        $this->sifatorder->EditValue = $this->sifatorder->options(false);
        $this->sifatorder->PlaceHolder = RemoveHtml($this->sifatorder->caption());

        // kodeorder
        $this->kodeorder->EditAttrs["class"] = "form-control";
        $this->kodeorder->EditCustomAttributes = "";
        $this->kodeorder->EditValue = $this->kodeorder->CurrentValue;
        $this->kodeorder->ViewCustomAttributes = "";

        // nomororder
        $this->nomororder->EditAttrs["class"] = "form-control";
        $this->nomororder->EditCustomAttributes = "";
        if (!$this->nomororder->Raw) {
            $this->nomororder->CurrentValue = HtmlDecode($this->nomororder->CurrentValue);
        }
        $this->nomororder->EditValue = $this->nomororder->CurrentValue;
        $this->nomororder->PlaceHolder = RemoveHtml($this->nomororder->caption());

        // idproduct_acuan
        $this->idproduct_acuan->EditAttrs["class"] = "form-control";
        $this->idproduct_acuan->EditCustomAttributes = "";
        $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

        // kategoriproduk
        $this->kategoriproduk->EditAttrs["class"] = "form-control";
        $this->kategoriproduk->EditCustomAttributes = "";
        $this->kategoriproduk->PlaceHolder = RemoveHtml($this->kategoriproduk->caption());

        // jenisproduk
        $this->jenisproduk->EditAttrs["class"] = "form-control";
        $this->jenisproduk->EditCustomAttributes = "";
        $this->jenisproduk->PlaceHolder = RemoveHtml($this->jenisproduk->caption());

        // fungsiproduk
        $this->fungsiproduk->EditAttrs["class"] = "form-control";
        $this->fungsiproduk->EditCustomAttributes = "";
        if (!$this->fungsiproduk->Raw) {
            $this->fungsiproduk->CurrentValue = HtmlDecode($this->fungsiproduk->CurrentValue);
        }
        $this->fungsiproduk->EditValue = $this->fungsiproduk->CurrentValue;
        $this->fungsiproduk->PlaceHolder = RemoveHtml($this->fungsiproduk->caption());

        // kualitasproduk
        $this->kualitasproduk->EditAttrs["class"] = "form-control";
        $this->kualitasproduk->EditCustomAttributes = "";
        if (!$this->kualitasproduk->Raw) {
            $this->kualitasproduk->CurrentValue = HtmlDecode($this->kualitasproduk->CurrentValue);
        }
        $this->kualitasproduk->EditValue = $this->kualitasproduk->CurrentValue;
        $this->kualitasproduk->PlaceHolder = RemoveHtml($this->kualitasproduk->caption());

        // bahan_campaign
        $this->bahan_campaign->EditAttrs["class"] = "form-control";
        $this->bahan_campaign->EditCustomAttributes = "";
        $this->bahan_campaign->EditValue = $this->bahan_campaign->CurrentValue;
        $this->bahan_campaign->PlaceHolder = RemoveHtml($this->bahan_campaign->caption());

        // ukuransediaan
        $this->ukuransediaan->EditAttrs["class"] = "form-control";
        $this->ukuransediaan->EditCustomAttributes = "";
        if (!$this->ukuransediaan->Raw) {
            $this->ukuransediaan->CurrentValue = HtmlDecode($this->ukuransediaan->CurrentValue);
        }
        $this->ukuransediaan->EditValue = $this->ukuransediaan->CurrentValue;
        $this->ukuransediaan->PlaceHolder = RemoveHtml($this->ukuransediaan->caption());

        // satuansediaan
        $this->satuansediaan->EditAttrs["class"] = "form-control";
        $this->satuansediaan->EditCustomAttributes = "";
        $this->satuansediaan->PlaceHolder = RemoveHtml($this->satuansediaan->caption());

        // bentuk
        $this->bentuk->EditCustomAttributes = "";
        $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

        // viskositas
        $this->viskositas->EditAttrs["class"] = "form-control";
        $this->viskositas->EditCustomAttributes = "";
        if (!$this->viskositas->Raw) {
            $this->viskositas->CurrentValue = HtmlDecode($this->viskositas->CurrentValue);
        }
        $this->viskositas->EditValue = $this->viskositas->CurrentValue;
        $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

        // warna
        $this->warna->EditAttrs["class"] = "form-control";
        $this->warna->EditCustomAttributes = "";
        if (!$this->warna->Raw) {
            $this->warna->CurrentValue = HtmlDecode($this->warna->CurrentValue);
        }
        $this->warna->EditValue = $this->warna->CurrentValue;
        $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

        // parfum
        $this->parfum->EditAttrs["class"] = "form-control";
        $this->parfum->EditCustomAttributes = "";
        $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

        // aroma
        $this->aroma->EditAttrs["class"] = "form-control";
        $this->aroma->EditCustomAttributes = "";
        if (!$this->aroma->Raw) {
            $this->aroma->CurrentValue = HtmlDecode($this->aroma->CurrentValue);
        }
        $this->aroma->EditValue = $this->aroma->CurrentValue;
        $this->aroma->PlaceHolder = RemoveHtml($this->aroma->caption());

        // aplikasi
        $this->aplikasi->EditAttrs["class"] = "form-control";
        $this->aplikasi->EditCustomAttributes = "";
        $this->aplikasi->PlaceHolder = RemoveHtml($this->aplikasi->caption());

        // aksesoris
        $this->aksesoris->EditAttrs["class"] = "form-control";
        $this->aksesoris->EditCustomAttributes = "";
        if (!$this->aksesoris->Raw) {
            $this->aksesoris->CurrentValue = HtmlDecode($this->aksesoris->CurrentValue);
        }
        $this->aksesoris->EditValue = $this->aksesoris->CurrentValue;
        $this->aksesoris->PlaceHolder = RemoveHtml($this->aksesoris->caption());

        // tambahan
        $this->tambahan->EditAttrs["class"] = "form-control";
        $this->tambahan->EditCustomAttributes = "";
        $this->tambahan->EditValue = $this->tambahan->CurrentValue;
        $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

        // ukurankemasan
        $this->ukurankemasan->EditAttrs["class"] = "form-control";
        $this->ukurankemasan->EditCustomAttributes = "";
        if (!$this->ukurankemasan->Raw) {
            $this->ukurankemasan->CurrentValue = HtmlDecode($this->ukurankemasan->CurrentValue);
        }
        $this->ukurankemasan->EditValue = $this->ukurankemasan->CurrentValue;
        $this->ukurankemasan->PlaceHolder = RemoveHtml($this->ukurankemasan->caption());

        // satuankemasan
        $this->satuankemasan->EditAttrs["class"] = "form-control";
        $this->satuankemasan->EditCustomAttributes = "";
        $this->satuankemasan->PlaceHolder = RemoveHtml($this->satuankemasan->caption());

        // kemasanbentuk
        $this->kemasanbentuk->EditCustomAttributes = "";
        $this->kemasanbentuk->PlaceHolder = RemoveHtml($this->kemasanbentuk->caption());

        // kemasantutup
        $this->kemasantutup->EditCustomAttributes = "";
        $this->kemasantutup->PlaceHolder = RemoveHtml($this->kemasantutup->caption());

        // kemasancatatan
        $this->kemasancatatan->EditAttrs["class"] = "form-control";
        $this->kemasancatatan->EditCustomAttributes = "";
        $this->kemasancatatan->EditValue = $this->kemasancatatan->CurrentValue;
        $this->kemasancatatan->PlaceHolder = RemoveHtml($this->kemasancatatan->caption());

        // labelukuran
        $this->labelukuran->EditAttrs["class"] = "form-control";
        $this->labelukuran->EditCustomAttributes = "";
        if (!$this->labelukuran->Raw) {
            $this->labelukuran->CurrentValue = HtmlDecode($this->labelukuran->CurrentValue);
        }
        $this->labelukuran->EditValue = $this->labelukuran->CurrentValue;
        $this->labelukuran->PlaceHolder = RemoveHtml($this->labelukuran->caption());

        // labelbahan
        $this->labelbahan->EditCustomAttributes = "";
        $this->labelbahan->PlaceHolder = RemoveHtml($this->labelbahan->caption());

        // labelkualitas
        $this->labelkualitas->EditCustomAttributes = "";
        $this->labelkualitas->PlaceHolder = RemoveHtml($this->labelkualitas->caption());

        // labelposisi
        $this->labelposisi->EditCustomAttributes = "";
        $this->labelposisi->PlaceHolder = RemoveHtml($this->labelposisi->caption());

        // labelcatatan
        $this->labelcatatan->EditAttrs["class"] = "form-control";
        $this->labelcatatan->EditCustomAttributes = "";
        $this->labelcatatan->EditValue = $this->labelcatatan->CurrentValue;
        $this->labelcatatan->PlaceHolder = RemoveHtml($this->labelcatatan->caption());

        // ukuran_utama
        $this->ukuran_utama->EditAttrs["class"] = "form-control";
        $this->ukuran_utama->EditCustomAttributes = "";
        if (!$this->ukuran_utama->Raw) {
            $this->ukuran_utama->CurrentValue = HtmlDecode($this->ukuran_utama->CurrentValue);
        }
        $this->ukuran_utama->EditValue = $this->ukuran_utama->CurrentValue;
        $this->ukuran_utama->PlaceHolder = RemoveHtml($this->ukuran_utama->caption());

        // utama_harga_isi
        $this->utama_harga_isi->EditAttrs["class"] = "form-control";
        $this->utama_harga_isi->EditCustomAttributes = "";
        $this->utama_harga_isi->EditValue = $this->utama_harga_isi->CurrentValue;
        $this->utama_harga_isi->PlaceHolder = RemoveHtml($this->utama_harga_isi->caption());

        // utama_harga_isi_proyeksi
        $this->utama_harga_isi_proyeksi->EditAttrs["class"] = "form-control";
        $this->utama_harga_isi_proyeksi->EditCustomAttributes = "";
        $this->utama_harga_isi_proyeksi->EditValue = $this->utama_harga_isi_proyeksi->CurrentValue;
        $this->utama_harga_isi_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_isi_proyeksi->caption());

        // utama_harga_primer
        $this->utama_harga_primer->EditAttrs["class"] = "form-control";
        $this->utama_harga_primer->EditCustomAttributes = "";
        $this->utama_harga_primer->EditValue = $this->utama_harga_primer->CurrentValue;
        $this->utama_harga_primer->PlaceHolder = RemoveHtml($this->utama_harga_primer->caption());

        // utama_harga_primer_proyeksi
        $this->utama_harga_primer_proyeksi->EditAttrs["class"] = "form-control";
        $this->utama_harga_primer_proyeksi->EditCustomAttributes = "";
        $this->utama_harga_primer_proyeksi->EditValue = $this->utama_harga_primer_proyeksi->CurrentValue;
        $this->utama_harga_primer_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_primer_proyeksi->caption());

        // utama_harga_sekunder
        $this->utama_harga_sekunder->EditAttrs["class"] = "form-control";
        $this->utama_harga_sekunder->EditCustomAttributes = "";
        $this->utama_harga_sekunder->EditValue = $this->utama_harga_sekunder->CurrentValue;
        $this->utama_harga_sekunder->PlaceHolder = RemoveHtml($this->utama_harga_sekunder->caption());

        // utama_harga_sekunder_proyeksi
        $this->utama_harga_sekunder_proyeksi->EditAttrs["class"] = "form-control";
        $this->utama_harga_sekunder_proyeksi->EditCustomAttributes = "";
        $this->utama_harga_sekunder_proyeksi->EditValue = $this->utama_harga_sekunder_proyeksi->CurrentValue;
        $this->utama_harga_sekunder_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_sekunder_proyeksi->caption());

        // utama_harga_label
        $this->utama_harga_label->EditAttrs["class"] = "form-control";
        $this->utama_harga_label->EditCustomAttributes = "";
        $this->utama_harga_label->EditValue = $this->utama_harga_label->CurrentValue;
        $this->utama_harga_label->PlaceHolder = RemoveHtml($this->utama_harga_label->caption());

        // utama_harga_label_proyeksi
        $this->utama_harga_label_proyeksi->EditAttrs["class"] = "form-control";
        $this->utama_harga_label_proyeksi->EditCustomAttributes = "";
        $this->utama_harga_label_proyeksi->EditValue = $this->utama_harga_label_proyeksi->CurrentValue;
        $this->utama_harga_label_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_label_proyeksi->caption());

        // utama_harga_total
        $this->utama_harga_total->EditAttrs["class"] = "form-control";
        $this->utama_harga_total->EditCustomAttributes = "";
        $this->utama_harga_total->EditValue = $this->utama_harga_total->CurrentValue;
        $this->utama_harga_total->PlaceHolder = RemoveHtml($this->utama_harga_total->caption());

        // utama_harga_total_proyeksi
        $this->utama_harga_total_proyeksi->EditAttrs["class"] = "form-control";
        $this->utama_harga_total_proyeksi->EditCustomAttributes = "";
        $this->utama_harga_total_proyeksi->EditValue = $this->utama_harga_total_proyeksi->CurrentValue;
        $this->utama_harga_total_proyeksi->PlaceHolder = RemoveHtml($this->utama_harga_total_proyeksi->caption());

        // ukuran_lain
        $this->ukuran_lain->EditAttrs["class"] = "form-control";
        $this->ukuran_lain->EditCustomAttributes = "";
        if (!$this->ukuran_lain->Raw) {
            $this->ukuran_lain->CurrentValue = HtmlDecode($this->ukuran_lain->CurrentValue);
        }
        $this->ukuran_lain->EditValue = $this->ukuran_lain->CurrentValue;
        $this->ukuran_lain->PlaceHolder = RemoveHtml($this->ukuran_lain->caption());

        // lain_harga_isi
        $this->lain_harga_isi->EditAttrs["class"] = "form-control";
        $this->lain_harga_isi->EditCustomAttributes = "";
        $this->lain_harga_isi->EditValue = $this->lain_harga_isi->CurrentValue;
        $this->lain_harga_isi->PlaceHolder = RemoveHtml($this->lain_harga_isi->caption());

        // lain_harga_isi_proyeksi
        $this->lain_harga_isi_proyeksi->EditAttrs["class"] = "form-control";
        $this->lain_harga_isi_proyeksi->EditCustomAttributes = "";
        $this->lain_harga_isi_proyeksi->EditValue = $this->lain_harga_isi_proyeksi->CurrentValue;
        $this->lain_harga_isi_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_isi_proyeksi->caption());

        // lain_harga_primer
        $this->lain_harga_primer->EditAttrs["class"] = "form-control";
        $this->lain_harga_primer->EditCustomAttributes = "";
        $this->lain_harga_primer->EditValue = $this->lain_harga_primer->CurrentValue;
        $this->lain_harga_primer->PlaceHolder = RemoveHtml($this->lain_harga_primer->caption());

        // lain_harga_primer_proyeksi
        $this->lain_harga_primer_proyeksi->EditAttrs["class"] = "form-control";
        $this->lain_harga_primer_proyeksi->EditCustomAttributes = "";
        $this->lain_harga_primer_proyeksi->EditValue = $this->lain_harga_primer_proyeksi->CurrentValue;
        $this->lain_harga_primer_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_primer_proyeksi->caption());

        // lain_harga_sekunder
        $this->lain_harga_sekunder->EditAttrs["class"] = "form-control";
        $this->lain_harga_sekunder->EditCustomAttributes = "";
        $this->lain_harga_sekunder->EditValue = $this->lain_harga_sekunder->CurrentValue;
        $this->lain_harga_sekunder->PlaceHolder = RemoveHtml($this->lain_harga_sekunder->caption());

        // lain_harga_sekunder_proyeksi
        $this->lain_harga_sekunder_proyeksi->EditAttrs["class"] = "form-control";
        $this->lain_harga_sekunder_proyeksi->EditCustomAttributes = "";
        $this->lain_harga_sekunder_proyeksi->EditValue = $this->lain_harga_sekunder_proyeksi->CurrentValue;
        $this->lain_harga_sekunder_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_sekunder_proyeksi->caption());

        // lain_harga_label
        $this->lain_harga_label->EditAttrs["class"] = "form-control";
        $this->lain_harga_label->EditCustomAttributes = "";
        $this->lain_harga_label->EditValue = $this->lain_harga_label->CurrentValue;
        $this->lain_harga_label->PlaceHolder = RemoveHtml($this->lain_harga_label->caption());

        // lain_harga_label_proyeksi
        $this->lain_harga_label_proyeksi->EditAttrs["class"] = "form-control";
        $this->lain_harga_label_proyeksi->EditCustomAttributes = "";
        $this->lain_harga_label_proyeksi->EditValue = $this->lain_harga_label_proyeksi->CurrentValue;
        $this->lain_harga_label_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_label_proyeksi->caption());

        // lain_harga_total
        $this->lain_harga_total->EditAttrs["class"] = "form-control";
        $this->lain_harga_total->EditCustomAttributes = "";
        $this->lain_harga_total->EditValue = $this->lain_harga_total->CurrentValue;
        $this->lain_harga_total->PlaceHolder = RemoveHtml($this->lain_harga_total->caption());

        // lain_harga_total_proyeksi
        $this->lain_harga_total_proyeksi->EditAttrs["class"] = "form-control";
        $this->lain_harga_total_proyeksi->EditCustomAttributes = "";
        $this->lain_harga_total_proyeksi->EditValue = $this->lain_harga_total_proyeksi->CurrentValue;
        $this->lain_harga_total_proyeksi->PlaceHolder = RemoveHtml($this->lain_harga_total_proyeksi->caption());

        // delivery_pickup
        $this->delivery_pickup->EditAttrs["class"] = "form-control";
        $this->delivery_pickup->EditCustomAttributes = "";
        if (!$this->delivery_pickup->Raw) {
            $this->delivery_pickup->CurrentValue = HtmlDecode($this->delivery_pickup->CurrentValue);
        }
        $this->delivery_pickup->EditValue = $this->delivery_pickup->CurrentValue;
        $this->delivery_pickup->PlaceHolder = RemoveHtml($this->delivery_pickup->caption());

        // delivery_singlepoint
        $this->delivery_singlepoint->EditAttrs["class"] = "form-control";
        $this->delivery_singlepoint->EditCustomAttributes = "";
        if (!$this->delivery_singlepoint->Raw) {
            $this->delivery_singlepoint->CurrentValue = HtmlDecode($this->delivery_singlepoint->CurrentValue);
        }
        $this->delivery_singlepoint->EditValue = $this->delivery_singlepoint->CurrentValue;
        $this->delivery_singlepoint->PlaceHolder = RemoveHtml($this->delivery_singlepoint->caption());

        // delivery_multipoint
        $this->delivery_multipoint->EditAttrs["class"] = "form-control";
        $this->delivery_multipoint->EditCustomAttributes = "";
        if (!$this->delivery_multipoint->Raw) {
            $this->delivery_multipoint->CurrentValue = HtmlDecode($this->delivery_multipoint->CurrentValue);
        }
        $this->delivery_multipoint->EditValue = $this->delivery_multipoint->CurrentValue;
        $this->delivery_multipoint->PlaceHolder = RemoveHtml($this->delivery_multipoint->caption());

        // delivery_termlain
        $this->delivery_termlain->EditAttrs["class"] = "form-control";
        $this->delivery_termlain->EditCustomAttributes = "";
        if (!$this->delivery_termlain->Raw) {
            $this->delivery_termlain->CurrentValue = HtmlDecode($this->delivery_termlain->CurrentValue);
        }
        $this->delivery_termlain->EditValue = $this->delivery_termlain->CurrentValue;
        $this->delivery_termlain->PlaceHolder = RemoveHtml($this->delivery_termlain->caption());

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(true);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 11);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 17);
        $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

        // receipt_by
        $this->receipt_by->EditAttrs["class"] = "form-control";
        $this->receipt_by->EditCustomAttributes = "";
        $this->receipt_by->EditValue = $this->receipt_by->CurrentValue;
        $this->receipt_by->PlaceHolder = RemoveHtml($this->receipt_by->caption());

        // approve_by
        $this->approve_by->EditAttrs["class"] = "form-control";
        $this->approve_by->EditCustomAttributes = "";
        $this->approve_by->EditValue = $this->approve_by->CurrentValue;
        $this->approve_by->PlaceHolder = RemoveHtml($this->approve_by->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->tanggal_order);
                    $doc->exportCaption($this->target_selesai);
                    $doc->exportCaption($this->sifatorder);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->nomororder);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->kategoriproduk);
                    $doc->exportCaption($this->jenisproduk);
                    $doc->exportCaption($this->fungsiproduk);
                    $doc->exportCaption($this->kualitasproduk);
                    $doc->exportCaption($this->bahan_campaign);
                    $doc->exportCaption($this->ukuransediaan);
                    $doc->exportCaption($this->satuansediaan);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->aroma);
                    $doc->exportCaption($this->aplikasi);
                    $doc->exportCaption($this->aksesoris);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->ukurankemasan);
                    $doc->exportCaption($this->satuankemasan);
                    $doc->exportCaption($this->kemasanbentuk);
                    $doc->exportCaption($this->kemasantutup);
                    $doc->exportCaption($this->kemasancatatan);
                    $doc->exportCaption($this->labelukuran);
                    $doc->exportCaption($this->labelbahan);
                    $doc->exportCaption($this->labelkualitas);
                    $doc->exportCaption($this->labelposisi);
                    $doc->exportCaption($this->labelcatatan);
                    $doc->exportCaption($this->ukuran_utama);
                    $doc->exportCaption($this->utama_harga_isi);
                    $doc->exportCaption($this->utama_harga_isi_proyeksi);
                    $doc->exportCaption($this->utama_harga_primer);
                    $doc->exportCaption($this->utama_harga_primer_proyeksi);
                    $doc->exportCaption($this->utama_harga_sekunder);
                    $doc->exportCaption($this->utama_harga_sekunder_proyeksi);
                    $doc->exportCaption($this->utama_harga_label);
                    $doc->exportCaption($this->utama_harga_label_proyeksi);
                    $doc->exportCaption($this->utama_harga_total);
                    $doc->exportCaption($this->utama_harga_total_proyeksi);
                    $doc->exportCaption($this->ukuran_lain);
                    $doc->exportCaption($this->lain_harga_isi);
                    $doc->exportCaption($this->lain_harga_isi_proyeksi);
                    $doc->exportCaption($this->lain_harga_primer);
                    $doc->exportCaption($this->lain_harga_primer_proyeksi);
                    $doc->exportCaption($this->lain_harga_sekunder);
                    $doc->exportCaption($this->lain_harga_sekunder_proyeksi);
                    $doc->exportCaption($this->lain_harga_label);
                    $doc->exportCaption($this->lain_harga_label_proyeksi);
                    $doc->exportCaption($this->lain_harga_total);
                    $doc->exportCaption($this->lain_harga_total_proyeksi);
                    $doc->exportCaption($this->delivery_pickup);
                    $doc->exportCaption($this->delivery_singlepoint);
                    $doc->exportCaption($this->delivery_multipoint);
                    $doc->exportCaption($this->delivery_termlain);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->receipt_by);
                    $doc->exportCaption($this->approve_by);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->tanggal_order);
                    $doc->exportCaption($this->target_selesai);
                    $doc->exportCaption($this->sifatorder);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->nomororder);
                    $doc->exportCaption($this->kategoriproduk);
                    $doc->exportCaption($this->jenisproduk);
                    $doc->exportCaption($this->fungsiproduk);
                    $doc->exportCaption($this->kualitasproduk);
                    $doc->exportCaption($this->bahan_campaign);
                    $doc->exportCaption($this->ukuransediaan);
                    $doc->exportCaption($this->satuansediaan);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->aroma);
                    $doc->exportCaption($this->aplikasi);
                    $doc->exportCaption($this->aksesoris);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->ukurankemasan);
                    $doc->exportCaption($this->satuankemasan);
                    $doc->exportCaption($this->kemasanbentuk);
                    $doc->exportCaption($this->kemasantutup);
                    $doc->exportCaption($this->labelukuran);
                    $doc->exportCaption($this->labelbahan);
                    $doc->exportCaption($this->labelkualitas);
                    $doc->exportCaption($this->labelposisi);
                    $doc->exportCaption($this->ukuran_utama);
                    $doc->exportCaption($this->utama_harga_isi);
                    $doc->exportCaption($this->utama_harga_isi_proyeksi);
                    $doc->exportCaption($this->utama_harga_primer);
                    $doc->exportCaption($this->utama_harga_primer_proyeksi);
                    $doc->exportCaption($this->utama_harga_sekunder);
                    $doc->exportCaption($this->utama_harga_sekunder_proyeksi);
                    $doc->exportCaption($this->utama_harga_label);
                    $doc->exportCaption($this->utama_harga_label_proyeksi);
                    $doc->exportCaption($this->utama_harga_total);
                    $doc->exportCaption($this->utama_harga_total_proyeksi);
                    $doc->exportCaption($this->ukuran_lain);
                    $doc->exportCaption($this->lain_harga_isi);
                    $doc->exportCaption($this->lain_harga_isi_proyeksi);
                    $doc->exportCaption($this->lain_harga_primer);
                    $doc->exportCaption($this->lain_harga_primer_proyeksi);
                    $doc->exportCaption($this->lain_harga_sekunder);
                    $doc->exportCaption($this->lain_harga_sekunder_proyeksi);
                    $doc->exportCaption($this->lain_harga_label);
                    $doc->exportCaption($this->lain_harga_label_proyeksi);
                    $doc->exportCaption($this->lain_harga_total);
                    $doc->exportCaption($this->lain_harga_total_proyeksi);
                    $doc->exportCaption($this->delivery_pickup);
                    $doc->exportCaption($this->delivery_singlepoint);
                    $doc->exportCaption($this->delivery_multipoint);
                    $doc->exportCaption($this->delivery_termlain);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->receipt_by);
                    $doc->exportCaption($this->approve_by);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->tanggal_order);
                        $doc->exportField($this->target_selesai);
                        $doc->exportField($this->sifatorder);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->nomororder);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->kategoriproduk);
                        $doc->exportField($this->jenisproduk);
                        $doc->exportField($this->fungsiproduk);
                        $doc->exportField($this->kualitasproduk);
                        $doc->exportField($this->bahan_campaign);
                        $doc->exportField($this->ukuransediaan);
                        $doc->exportField($this->satuansediaan);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->aroma);
                        $doc->exportField($this->aplikasi);
                        $doc->exportField($this->aksesoris);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->ukurankemasan);
                        $doc->exportField($this->satuankemasan);
                        $doc->exportField($this->kemasanbentuk);
                        $doc->exportField($this->kemasantutup);
                        $doc->exportField($this->kemasancatatan);
                        $doc->exportField($this->labelukuran);
                        $doc->exportField($this->labelbahan);
                        $doc->exportField($this->labelkualitas);
                        $doc->exportField($this->labelposisi);
                        $doc->exportField($this->labelcatatan);
                        $doc->exportField($this->ukuran_utama);
                        $doc->exportField($this->utama_harga_isi);
                        $doc->exportField($this->utama_harga_isi_proyeksi);
                        $doc->exportField($this->utama_harga_primer);
                        $doc->exportField($this->utama_harga_primer_proyeksi);
                        $doc->exportField($this->utama_harga_sekunder);
                        $doc->exportField($this->utama_harga_sekunder_proyeksi);
                        $doc->exportField($this->utama_harga_label);
                        $doc->exportField($this->utama_harga_label_proyeksi);
                        $doc->exportField($this->utama_harga_total);
                        $doc->exportField($this->utama_harga_total_proyeksi);
                        $doc->exportField($this->ukuran_lain);
                        $doc->exportField($this->lain_harga_isi);
                        $doc->exportField($this->lain_harga_isi_proyeksi);
                        $doc->exportField($this->lain_harga_primer);
                        $doc->exportField($this->lain_harga_primer_proyeksi);
                        $doc->exportField($this->lain_harga_sekunder);
                        $doc->exportField($this->lain_harga_sekunder_proyeksi);
                        $doc->exportField($this->lain_harga_label);
                        $doc->exportField($this->lain_harga_label_proyeksi);
                        $doc->exportField($this->lain_harga_total);
                        $doc->exportField($this->lain_harga_total_proyeksi);
                        $doc->exportField($this->delivery_pickup);
                        $doc->exportField($this->delivery_singlepoint);
                        $doc->exportField($this->delivery_multipoint);
                        $doc->exportField($this->delivery_termlain);
                        $doc->exportField($this->status);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->receipt_by);
                        $doc->exportField($this->approve_by);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->tanggal_order);
                        $doc->exportField($this->target_selesai);
                        $doc->exportField($this->sifatorder);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->nomororder);
                        $doc->exportField($this->kategoriproduk);
                        $doc->exportField($this->jenisproduk);
                        $doc->exportField($this->fungsiproduk);
                        $doc->exportField($this->kualitasproduk);
                        $doc->exportField($this->bahan_campaign);
                        $doc->exportField($this->ukuransediaan);
                        $doc->exportField($this->satuansediaan);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->aroma);
                        $doc->exportField($this->aplikasi);
                        $doc->exportField($this->aksesoris);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->ukurankemasan);
                        $doc->exportField($this->satuankemasan);
                        $doc->exportField($this->kemasanbentuk);
                        $doc->exportField($this->kemasantutup);
                        $doc->exportField($this->labelukuran);
                        $doc->exportField($this->labelbahan);
                        $doc->exportField($this->labelkualitas);
                        $doc->exportField($this->labelposisi);
                        $doc->exportField($this->ukuran_utama);
                        $doc->exportField($this->utama_harga_isi);
                        $doc->exportField($this->utama_harga_isi_proyeksi);
                        $doc->exportField($this->utama_harga_primer);
                        $doc->exportField($this->utama_harga_primer_proyeksi);
                        $doc->exportField($this->utama_harga_sekunder);
                        $doc->exportField($this->utama_harga_sekunder_proyeksi);
                        $doc->exportField($this->utama_harga_label);
                        $doc->exportField($this->utama_harga_label_proyeksi);
                        $doc->exportField($this->utama_harga_total);
                        $doc->exportField($this->utama_harga_total_proyeksi);
                        $doc->exportField($this->ukuran_lain);
                        $doc->exportField($this->lain_harga_isi);
                        $doc->exportField($this->lain_harga_isi_proyeksi);
                        $doc->exportField($this->lain_harga_primer);
                        $doc->exportField($this->lain_harga_primer_proyeksi);
                        $doc->exportField($this->lain_harga_sekunder);
                        $doc->exportField($this->lain_harga_sekunder_proyeksi);
                        $doc->exportField($this->lain_harga_label);
                        $doc->exportField($this->lain_harga_label_proyeksi);
                        $doc->exportField($this->lain_harga_total);
                        $doc->exportField($this->lain_harga_total_proyeksi);
                        $doc->exportField($this->delivery_pickup);
                        $doc->exportField($this->delivery_singlepoint);
                        $doc->exportField($this->delivery_multipoint);
                        $doc->exportField($this->delivery_termlain);
                        $doc->exportField($this->status);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->receipt_by);
                        $doc->exportField($this->approve_by);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        //$rsnew['kodeorder'] = getNextKodeNpd($rsnew['idcustomer']);
        $rsnew['created_at'] = date('Y-m-d H:i:s');
        $rsnew['updated_at'] = date('Y-m-d H:i:s');
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        $rsnew['updated_at'] = date('Y-m-d H:i:s');
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        if ($rs['selesai']) {
        	$this->setFailureMessage("NPD yang sudah selesai tidak bisa dihapus");
        	return false;
        }
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
        $user_level = CurrentUserLevel();
    	if($user_level != -1){
    		$this->idpegawai->CurrentValue = CurrentUserID();
    		$this->idpegawai->ReadOnly = TRUE; 
    	}
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
