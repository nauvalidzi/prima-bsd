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
    public $tanggal_order;
    public $target_selesai;
    public $idbrand;
    public $sifatorder;
    public $kodeorder;
    public $nomororder;
    public $idpegawai;
    public $idcustomer;
    public $idproduct_acuan;
    public $idkategoriproduk;
    public $idjenisproduk;
    public $fungsiproduk;
    public $kualitasproduk;
    public $bahan_campaign;
    public $ukuran_sediaan;
    public $bentuk;
    public $viskositas;
    public $warna;
    public $parfum;
    public $aplikasi;
    public $estetika;
    public $tambahan;
    public $ukurankemasan;
    public $kemasanbentuk;
    public $kemasantutup;
    public $kemasancatatan;
    public $labelbahan;
    public $labelkualitas;
    public $labelposisi;
    public $labelcatatan;
    public $status;
    public $readonly;
    public $selesai;
    public $created_at;
    public $updated_at;

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

        // idbrand
        $this->idbrand = new DbField('npd', 'npd', 'x_idbrand', 'idbrand', '`idbrand`', '`idbrand`', 21, 20, -1, false, '`idbrand`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idbrand->Nullable = false; // NOT NULL field
        $this->idbrand->Required = true; // Required field
        $this->idbrand->Sortable = true; // Allow sort
        $this->idbrand->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idbrand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idbrand->Param, "CustomMsg");
        $this->Fields['idbrand'] = &$this->idbrand;

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
        $this->kodeorder->Nullable = false; // NOT NULL field
        $this->kodeorder->Required = true; // Required field
        $this->kodeorder->Sortable = true; // Allow sort
        $this->kodeorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeorder->Param, "CustomMsg");
        $this->Fields['kodeorder'] = &$this->kodeorder;

        // nomororder
        $this->nomororder = new DbField('npd', 'npd', 'x_nomororder', 'nomororder', '`nomororder`', '`nomororder`', 200, 50, -1, false, '`nomororder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nomororder->Nullable = false; // NOT NULL field
        $this->nomororder->Required = true; // Required field
        $this->nomororder->Sortable = true; // Allow sort
        $this->nomororder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nomororder->Param, "CustomMsg");
        $this->Fields['nomororder'] = &$this->nomororder;

        // idpegawai
        $this->idpegawai = new DbField('npd', 'npd', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idpegawai->Nullable = false; // NOT NULL field
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
        $this->idcustomer = new DbField('npd', 'npd', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 21, 20, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idcustomer->Nullable = false; // NOT NULL field
        $this->idcustomer->Required = true; // Required field
        $this->idcustomer->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], ["x_idpegawai"], [], ["idpegawai"], ["x_idpegawai"], [], [], '', '');
                break;
            default:
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], ["x_idpegawai"], [], ["idpegawai"], ["x_idpegawai"], [], [], '', '');
                break;
        }
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // idproduct_acuan
        $this->idproduct_acuan = new DbField('npd', 'npd', 'x_idproduct_acuan', 'idproduct_acuan', '`idproduct_acuan`', '`idproduct_acuan`', 21, 20, -1, false, '`idproduct_acuan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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

        // idkategoriproduk
        $this->idkategoriproduk = new DbField('npd', 'npd', 'x_idkategoriproduk', 'idkategoriproduk', '`idkategoriproduk`', '`idkategoriproduk`', 3, 11, -1, false, '`idkategoriproduk`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkategoriproduk->Nullable = false; // NOT NULL field
        $this->idkategoriproduk->Required = true; // Required field
        $this->idkategoriproduk->Sortable = true; // Allow sort
        $this->idkategoriproduk->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkategoriproduk->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkategoriproduk->Lookup = new Lookup('idkategoriproduk', 'kategoribarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idkategoriproduk->Lookup = new Lookup('idkategoriproduk', 'kategoribarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idkategoriproduk->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkategoriproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkategoriproduk->Param, "CustomMsg");
        $this->Fields['idkategoriproduk'] = &$this->idkategoriproduk;

        // idjenisproduk
        $this->idjenisproduk = new DbField('npd', 'npd', 'x_idjenisproduk', 'idjenisproduk', '`idjenisproduk`', '`idjenisproduk`', 3, 11, -1, false, '`idjenisproduk`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idjenisproduk->Sortable = true; // Allow sort
        $this->idjenisproduk->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idjenisproduk->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idjenisproduk->Lookup = new Lookup('idjenisproduk', 'jenisbarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idjenisproduk->Lookup = new Lookup('idjenisproduk', 'jenisbarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idjenisproduk->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idjenisproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idjenisproduk->Param, "CustomMsg");
        $this->Fields['idjenisproduk'] = &$this->idjenisproduk;

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
        $this->bahan_campaign = new DbField('npd', 'npd', 'x_bahan_campaign', 'bahan_campaign', '`bahan_campaign`', '`bahan_campaign`', 201, 65535, -1, false, '`bahan_campaign`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahan_campaign->Sortable = true; // Allow sort
        $this->bahan_campaign->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahan_campaign->Param, "CustomMsg");
        $this->Fields['bahan_campaign'] = &$this->bahan_campaign;

        // ukuran_sediaan
        $this->ukuran_sediaan = new DbField('npd', 'npd', 'x_ukuran_sediaan', 'ukuran_sediaan', '`ukuran_sediaan`', '`ukuran_sediaan`', 200, 255, -1, false, '`ukuran_sediaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran_sediaan->Nullable = false; // NOT NULL field
        $this->ukuran_sediaan->Required = true; // Required field
        $this->ukuran_sediaan->Sortable = true; // Allow sort
        $this->ukuran_sediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran_sediaan->Param, "CustomMsg");
        $this->Fields['ukuran_sediaan'] = &$this->ukuran_sediaan;

        // bentuk
        $this->bentuk = new DbField('npd', 'npd', 'x_bentuk', 'bentuk', '`bentuk`', '`bentuk`', 200, 255, -1, false, '`bentuk`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->bentuk->Nullable = false; // NOT NULL field
        $this->bentuk->Required = true; // Required field
        $this->bentuk->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->bentuk->Lookup = new Lookup('bentuk', 'npd_bentuk_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->bentuk->Lookup = new Lookup('bentuk', 'npd_bentuk_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->bentuk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentuk->Param, "CustomMsg");
        $this->Fields['bentuk'] = &$this->bentuk;

        // viskositas
        $this->viskositas = new DbField('npd', 'npd', 'x_viskositas', 'viskositas', '`viskositas`', '`viskositas`', 200, 255, -1, false, '`viskositas`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->viskositas->Nullable = false; // NOT NULL field
        $this->viskositas->Required = true; // Required field
        $this->viskositas->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->viskositas->Lookup = new Lookup('viskositas', 'npd_viskositas_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->viskositas->Lookup = new Lookup('viskositas', 'npd_viskositas_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->viskositas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->viskositas->Param, "CustomMsg");
        $this->Fields['viskositas'] = &$this->viskositas;

        // warna
        $this->warna = new DbField('npd', 'npd', 'x_warna', 'warna', '`warna`', '`warna`', 200, 255, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->warna->Nullable = false; // NOT NULL field
        $this->warna->Required = true; // Required field
        $this->warna->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->warna->Lookup = new Lookup('warna', 'npd_warna_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->warna->Lookup = new Lookup('warna', 'npd_warna_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // parfum
        $this->parfum = new DbField('npd', 'npd', 'x_parfum', 'parfum', '`parfum`', '`parfum`', 200, 255, -1, false, '`parfum`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->parfum->Nullable = false; // NOT NULL field
        $this->parfum->Required = true; // Required field
        $this->parfum->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->parfum->Lookup = new Lookup('parfum', 'npd_parfum_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->parfum->Lookup = new Lookup('parfum', 'npd_parfum_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->parfum->Param, "CustomMsg");
        $this->Fields['parfum'] = &$this->parfum;

        // aplikasi
        $this->aplikasi = new DbField('npd', 'npd', 'x_aplikasi', 'aplikasi', '`aplikasi`', '`aplikasi`', 200, 255, -1, false, '`aplikasi`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->aplikasi->Nullable = false; // NOT NULL field
        $this->aplikasi->Required = true; // Required field
        $this->aplikasi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasi->Lookup = new Lookup('aplikasi', 'npd_aplikasi_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasi->Lookup = new Lookup('aplikasi', 'npd_aplikasi_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasi->Param, "CustomMsg");
        $this->Fields['aplikasi'] = &$this->aplikasi;

        // estetika
        $this->estetika = new DbField('npd', 'npd', 'x_estetika', 'estetika', '`estetika`', '`estetika`', 200, 255, -1, false, '`estetika`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->estetika->Nullable = false; // NOT NULL field
        $this->estetika->Required = true; // Required field
        $this->estetika->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->estetika->Lookup = new Lookup('estetika', 'npd_estetika_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->estetika->Lookup = new Lookup('estetika', 'npd_estetika_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->estetika->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->estetika->Param, "CustomMsg");
        $this->Fields['estetika'] = &$this->estetika;

        // tambahan
        $this->tambahan = new DbField('npd', 'npd', 'x_tambahan', 'tambahan', '`tambahan`', '`tambahan`', 201, 65535, -1, false, '`tambahan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->tambahan->Sortable = true; // Allow sort
        $this->tambahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tambahan->Param, "CustomMsg");
        $this->Fields['tambahan'] = &$this->tambahan;

        // ukurankemasan
        $this->ukurankemasan = new DbField('npd', 'npd', 'x_ukurankemasan', 'ukurankemasan', '`ukurankemasan`', '`ukurankemasan`', 200, 255, -1, false, '`ukurankemasan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukurankemasan->Nullable = false; // NOT NULL field
        $this->ukurankemasan->Required = true; // Required field
        $this->ukurankemasan->Sortable = true; // Allow sort
        $this->ukurankemasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukurankemasan->Param, "CustomMsg");
        $this->Fields['ukurankemasan'] = &$this->ukurankemasan;

        // kemasanbentuk
        $this->kemasanbentuk = new DbField('npd', 'npd', 'x_kemasanbentuk', 'kemasanbentuk', '`kemasanbentuk`', '`kemasanbentuk`', 200, 255, -1, false, '`kemasanbentuk`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->kemasanbentuk->Nullable = false; // NOT NULL field
        $this->kemasanbentuk->Required = true; // Required field
        $this->kemasanbentuk->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kemasanbentuk->Lookup = new Lookup('kemasanbentuk', 'npd_kemasan_wadah', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kemasanbentuk->Lookup = new Lookup('kemasanbentuk', 'npd_kemasan_wadah', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kemasanbentuk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasanbentuk->Param, "CustomMsg");
        $this->Fields['kemasanbentuk'] = &$this->kemasanbentuk;

        // kemasantutup
        $this->kemasantutup = new DbField('npd', 'npd', 'x_kemasantutup', 'kemasantutup', '`kemasantutup`', '`kemasantutup`', 200, 255, -1, false, '`kemasantutup`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->kemasantutup->Nullable = false; // NOT NULL field
        $this->kemasantutup->Required = true; // Required field
        $this->kemasantutup->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kemasantutup->Lookup = new Lookup('kemasantutup', 'npd_kemasan_tutup', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kemasantutup->Lookup = new Lookup('kemasantutup', 'npd_kemasan_tutup', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kemasantutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasantutup->Param, "CustomMsg");
        $this->Fields['kemasantutup'] = &$this->kemasantutup;

        // kemasancatatan
        $this->kemasancatatan = new DbField('npd', 'npd', 'x_kemasancatatan', 'kemasancatatan', '`kemasancatatan`', '`kemasancatatan`', 201, 65535, -1, false, '`kemasancatatan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->kemasancatatan->Nullable = false; // NOT NULL field
        $this->kemasancatatan->Required = true; // Required field
        $this->kemasancatatan->Sortable = true; // Allow sort
        $this->kemasancatatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasancatatan->Param, "CustomMsg");
        $this->Fields['kemasancatatan'] = &$this->kemasancatatan;

        // labelbahan
        $this->labelbahan = new DbField('npd', 'npd', 'x_labelbahan', 'labelbahan', '`labelbahan`', '`labelbahan`', 200, 255, -1, false, '`labelbahan`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->labelbahan->Nullable = false; // NOT NULL field
        $this->labelbahan->Required = true; // Required field
        $this->labelbahan->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->labelbahan->Lookup = new Lookup('labelbahan', 'npd_label_bahan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->labelbahan->Lookup = new Lookup('labelbahan', 'npd_label_bahan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->labelbahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelbahan->Param, "CustomMsg");
        $this->Fields['labelbahan'] = &$this->labelbahan;

        // labelkualitas
        $this->labelkualitas = new DbField('npd', 'npd', 'x_labelkualitas', 'labelkualitas', '`labelkualitas`', '`labelkualitas`', 200, 255, -1, false, '`labelkualitas`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->labelkualitas->Nullable = false; // NOT NULL field
        $this->labelkualitas->Required = true; // Required field
        $this->labelkualitas->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->labelkualitas->Lookup = new Lookup('labelkualitas', 'npd_label_kualitas', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->labelkualitas->Lookup = new Lookup('labelkualitas', 'npd_label_kualitas', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->labelkualitas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelkualitas->Param, "CustomMsg");
        $this->Fields['labelkualitas'] = &$this->labelkualitas;

        // labelposisi
        $this->labelposisi = new DbField('npd', 'npd', 'x_labelposisi', 'labelposisi', '`labelposisi`', '`labelposisi`', 200, 255, -1, false, '`labelposisi`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->labelposisi->Nullable = false; // NOT NULL field
        $this->labelposisi->Required = true; // Required field
        $this->labelposisi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->labelposisi->Lookup = new Lookup('labelposisi', 'npd_label_posisi', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->labelposisi->Lookup = new Lookup('labelposisi', 'npd_label_posisi', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->labelposisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelposisi->Param, "CustomMsg");
        $this->Fields['labelposisi'] = &$this->labelposisi;

        // labelcatatan
        $this->labelcatatan = new DbField('npd', 'npd', 'x_labelcatatan', 'labelcatatan', '`labelcatatan`', '`labelcatatan`', 201, 65535, -1, false, '`labelcatatan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->labelcatatan->Nullable = false; // NOT NULL field
        $this->labelcatatan->Required = true; // Required field
        $this->labelcatatan->Sortable = true; // Allow sort
        $this->labelcatatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelcatatan->Param, "CustomMsg");
        $this->Fields['labelcatatan'] = &$this->labelcatatan;

        // status
        $this->status = new DbField('npd', 'npd', 'x_status', 'status', '`status`', '`status`', 200, 50, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // readonly
        $this->readonly = new DbField('npd', 'npd', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->readonly->Nullable = false; // NOT NULL field
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

        // selesai
        $this->selesai = new DbField('npd', 'npd', 'x_selesai', 'selesai', '`selesai`', '`selesai`', 16, 1, -1, false, '`selesai`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->selesai->Nullable = false; // NOT NULL field
        $this->selesai->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->selesai->Lookup = new Lookup('selesai', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->selesai->Lookup = new Lookup('selesai', 'npd', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->selesai->OptionCount = 2;
        $this->selesai->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->selesai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->selesai->Param, "CustomMsg");
        $this->Fields['selesai'] = &$this->selesai;

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
        if ($this->getCurrentDetailTable() == "npd_terms") {
            $detailUrl = Container("npd_terms")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
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
        $this->tanggal_order->DbValue = $row['tanggal_order'];
        $this->target_selesai->DbValue = $row['target_selesai'];
        $this->idbrand->DbValue = $row['idbrand'];
        $this->sifatorder->DbValue = $row['sifatorder'];
        $this->kodeorder->DbValue = $row['kodeorder'];
        $this->nomororder->DbValue = $row['nomororder'];
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->idproduct_acuan->DbValue = $row['idproduct_acuan'];
        $this->idkategoriproduk->DbValue = $row['idkategoriproduk'];
        $this->idjenisproduk->DbValue = $row['idjenisproduk'];
        $this->fungsiproduk->DbValue = $row['fungsiproduk'];
        $this->kualitasproduk->DbValue = $row['kualitasproduk'];
        $this->bahan_campaign->DbValue = $row['bahan_campaign'];
        $this->ukuran_sediaan->DbValue = $row['ukuran_sediaan'];
        $this->bentuk->DbValue = $row['bentuk'];
        $this->viskositas->DbValue = $row['viskositas'];
        $this->warna->DbValue = $row['warna'];
        $this->parfum->DbValue = $row['parfum'];
        $this->aplikasi->DbValue = $row['aplikasi'];
        $this->estetika->DbValue = $row['estetika'];
        $this->tambahan->DbValue = $row['tambahan'];
        $this->ukurankemasan->DbValue = $row['ukurankemasan'];
        $this->kemasanbentuk->DbValue = $row['kemasanbentuk'];
        $this->kemasantutup->DbValue = $row['kemasantutup'];
        $this->kemasancatatan->DbValue = $row['kemasancatatan'];
        $this->labelbahan->DbValue = $row['labelbahan'];
        $this->labelkualitas->DbValue = $row['labelkualitas'];
        $this->labelposisi->DbValue = $row['labelposisi'];
        $this->labelcatatan->DbValue = $row['labelcatatan'];
        $this->status->DbValue = $row['status'];
        $this->readonly->DbValue = $row['readonly'];
        $this->selesai->DbValue = $row['selesai'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
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
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->sifatorder->setDbValue($row['sifatorder']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->idkategoriproduk->setDbValue($row['idkategoriproduk']);
        $this->idjenisproduk->setDbValue($row['idjenisproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->estetika->setDbValue($row['estetika']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->status->setDbValue($row['status']);
        $this->readonly->setDbValue($row['readonly']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // tanggal_order

        // target_selesai

        // idbrand

        // sifatorder

        // kodeorder

        // nomororder

        // idpegawai

        // idcustomer

        // idproduct_acuan
        $this->idproduct_acuan->CellCssStyle = "white-space: nowrap;";

        // idkategoriproduk

        // idjenisproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuran_sediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aplikasi

        // estetika

        // tambahan

        // ukurankemasan

        // kemasanbentuk

        // kemasantutup

        // kemasancatatan

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

        // status

        // readonly

        // selesai

        // created_at

        // updated_at

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // tanggal_order
        $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
        $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
        $this->tanggal_order->ViewCustomAttributes = "";

        // target_selesai
        $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
        $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
        $this->target_selesai->ViewCustomAttributes = "";

        // idbrand
        $this->idbrand->ViewValue = $this->idbrand->CurrentValue;
        $this->idbrand->ViewValue = FormatNumber($this->idbrand->ViewValue, 0, -2, -2, -2);
        $this->idbrand->ViewCustomAttributes = "";

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
        $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
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

        // idkategoriproduk
        $curVal = trim(strval($this->idkategoriproduk->CurrentValue));
        if ($curVal != "") {
            $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->lookupCacheOption($curVal);
            if ($this->idkategoriproduk->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idkategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idkategoriproduk->Lookup->renderViewRow($rswrk[0]);
                    $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->displayValue($arwrk);
                } else {
                    $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->CurrentValue;
                }
            }
        } else {
            $this->idkategoriproduk->ViewValue = null;
        }
        $this->idkategoriproduk->ViewCustomAttributes = "";

        // idjenisproduk
        $curVal = trim(strval($this->idjenisproduk->CurrentValue));
        if ($curVal != "") {
            $this->idjenisproduk->ViewValue = $this->idjenisproduk->lookupCacheOption($curVal);
            if ($this->idjenisproduk->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idjenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idjenisproduk->Lookup->renderViewRow($rswrk[0]);
                    $this->idjenisproduk->ViewValue = $this->idjenisproduk->displayValue($arwrk);
                } else {
                    $this->idjenisproduk->ViewValue = $this->idjenisproduk->CurrentValue;
                }
            }
        } else {
            $this->idjenisproduk->ViewValue = null;
        }
        $this->idjenisproduk->ViewCustomAttributes = "";

        // fungsiproduk
        $this->fungsiproduk->ViewValue = $this->fungsiproduk->CurrentValue;
        $this->fungsiproduk->ViewCustomAttributes = "";

        // kualitasproduk
        $this->kualitasproduk->ViewValue = $this->kualitasproduk->CurrentValue;
        $this->kualitasproduk->ViewCustomAttributes = "";

        // bahan_campaign
        $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
        $this->bahan_campaign->ViewCustomAttributes = "";

        // ukuran_sediaan
        $this->ukuran_sediaan->ViewValue = $this->ukuran_sediaan->CurrentValue;
        $this->ukuran_sediaan->ViewCustomAttributes = "";

        // bentuk
        $curVal = trim(strval($this->bentuk->CurrentValue));
        if ($curVal != "") {
            $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
            if ($this->bentuk->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->bentuk->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->bentuk->Lookup->renderViewRow($row);
                        $this->bentuk->ViewValue->add($this->bentuk->displayValue($arwrk));
                    }
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
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->viskositas->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->viskositas->Lookup->renderViewRow($row);
                        $this->viskositas->ViewValue->add($this->viskositas->displayValue($arwrk));
                    }
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
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->warna->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->warna->Lookup->renderViewRow($row);
                        $this->warna->ViewValue->add($this->warna->displayValue($arwrk));
                    }
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
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->parfum->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->parfum->Lookup->renderViewRow($row);
                        $this->parfum->ViewValue->add($this->parfum->displayValue($arwrk));
                    }
                } else {
                    $this->parfum->ViewValue = $this->parfum->CurrentValue;
                }
            }
        } else {
            $this->parfum->ViewValue = null;
        }
        $this->parfum->ViewCustomAttributes = "";

        // aplikasi
        $curVal = trim(strval($this->aplikasi->CurrentValue));
        if ($curVal != "") {
            $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
            if ($this->aplikasi->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->aplikasi->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->aplikasi->Lookup->renderViewRow($row);
                        $this->aplikasi->ViewValue->add($this->aplikasi->displayValue($arwrk));
                    }
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
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->estetika->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->estetika->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->estetika->Lookup->renderViewRow($row);
                        $this->estetika->ViewValue->add($this->estetika->displayValue($arwrk));
                    }
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
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
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
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
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

        // labelbahan
        $curVal = trim(strval($this->labelbahan->CurrentValue));
        if ($curVal != "") {
            $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
            if ($this->labelbahan->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->labelbahan->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->labelbahan->Lookup->renderViewRow($row);
                        $this->labelbahan->ViewValue->add($this->labelbahan->displayValue($arwrk));
                    }
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
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->labelkualitas->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->labelkualitas->Lookup->renderViewRow($row);
                        $this->labelkualitas->ViewValue->add($this->labelkualitas->displayValue($arwrk));
                    }
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
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->labelposisi->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->labelposisi->Lookup->renderViewRow($row);
                        $this->labelposisi->ViewValue->add($this->labelposisi->displayValue($arwrk));
                    }
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

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

        // readonly
        if (strval($this->readonly->CurrentValue) != "") {
            $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
        } else {
            $this->readonly->ViewValue = null;
        }
        $this->readonly->ViewCustomAttributes = "";

        // selesai
        if (strval($this->selesai->CurrentValue) != "") {
            $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
        } else {
            $this->selesai->ViewValue = null;
        }
        $this->selesai->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 11);
        $this->created_at->ViewCustomAttributes = "";

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 17);
        $this->updated_at->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // tanggal_order
        $this->tanggal_order->LinkCustomAttributes = "";
        $this->tanggal_order->HrefValue = "";
        $this->tanggal_order->TooltipValue = "";

        // target_selesai
        $this->target_selesai->LinkCustomAttributes = "";
        $this->target_selesai->HrefValue = "";
        $this->target_selesai->TooltipValue = "";

        // idbrand
        $this->idbrand->LinkCustomAttributes = "";
        $this->idbrand->HrefValue = "";
        $this->idbrand->TooltipValue = "";

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

        // idpegawai
        $this->idpegawai->LinkCustomAttributes = "";
        $this->idpegawai->HrefValue = "";
        $this->idpegawai->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // idproduct_acuan
        $this->idproduct_acuan->LinkCustomAttributes = "";
        $this->idproduct_acuan->HrefValue = "";
        $this->idproduct_acuan->TooltipValue = "";

        // idkategoriproduk
        $this->idkategoriproduk->LinkCustomAttributes = "";
        $this->idkategoriproduk->HrefValue = "";
        $this->idkategoriproduk->TooltipValue = "";

        // idjenisproduk
        $this->idjenisproduk->LinkCustomAttributes = "";
        $this->idjenisproduk->HrefValue = "";
        $this->idjenisproduk->TooltipValue = "";

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

        // ukuran_sediaan
        $this->ukuran_sediaan->LinkCustomAttributes = "";
        $this->ukuran_sediaan->HrefValue = "";
        $this->ukuran_sediaan->TooltipValue = "";

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

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

        // selesai
        $this->selesai->LinkCustomAttributes = "";
        $this->selesai->HrefValue = "";
        $this->selesai->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

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

        // idbrand
        $this->idbrand->EditAttrs["class"] = "form-control";
        $this->idbrand->EditCustomAttributes = "";
        $this->idbrand->EditValue = $this->idbrand->CurrentValue;
        $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());

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
        $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
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

        // idproduct_acuan
        $this->idproduct_acuan->EditAttrs["class"] = "form-control";
        $this->idproduct_acuan->EditCustomAttributes = "";
        $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

        // idkategoriproduk
        $this->idkategoriproduk->EditAttrs["class"] = "form-control";
        $this->idkategoriproduk->EditCustomAttributes = "";
        $this->idkategoriproduk->PlaceHolder = RemoveHtml($this->idkategoriproduk->caption());

        // idjenisproduk
        $this->idjenisproduk->EditAttrs["class"] = "form-control";
        $this->idjenisproduk->EditCustomAttributes = "";
        $this->idjenisproduk->PlaceHolder = RemoveHtml($this->idjenisproduk->caption());

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
        if (!$this->bahan_campaign->Raw) {
            $this->bahan_campaign->CurrentValue = HtmlDecode($this->bahan_campaign->CurrentValue);
        }
        $this->bahan_campaign->EditValue = $this->bahan_campaign->CurrentValue;
        $this->bahan_campaign->PlaceHolder = RemoveHtml($this->bahan_campaign->caption());

        // ukuran_sediaan
        $this->ukuran_sediaan->EditAttrs["class"] = "form-control";
        $this->ukuran_sediaan->EditCustomAttributes = "";
        if (!$this->ukuran_sediaan->Raw) {
            $this->ukuran_sediaan->CurrentValue = HtmlDecode($this->ukuran_sediaan->CurrentValue);
        }
        $this->ukuran_sediaan->EditValue = $this->ukuran_sediaan->CurrentValue;
        $this->ukuran_sediaan->PlaceHolder = RemoveHtml($this->ukuran_sediaan->caption());

        // bentuk
        $this->bentuk->EditCustomAttributes = "";
        $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

        // viskositas
        $this->viskositas->EditCustomAttributes = "";
        $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

        // warna
        $this->warna->EditCustomAttributes = "";
        $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

        // parfum
        $this->parfum->EditCustomAttributes = "";
        $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

        // aplikasi
        $this->aplikasi->EditCustomAttributes = "";
        $this->aplikasi->PlaceHolder = RemoveHtml($this->aplikasi->caption());

        // estetika
        $this->estetika->EditCustomAttributes = "";
        $this->estetika->PlaceHolder = RemoveHtml($this->estetika->caption());

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

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

        // selesai
        $this->selesai->EditCustomAttributes = "";
        $this->selesai->EditValue = $this->selesai->options(false);
        $this->selesai->PlaceHolder = RemoveHtml($this->selesai->caption());

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
                    $doc->exportCaption($this->tanggal_order);
                    $doc->exportCaption($this->target_selesai);
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->sifatorder);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->nomororder);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idkategoriproduk);
                    $doc->exportCaption($this->idjenisproduk);
                    $doc->exportCaption($this->fungsiproduk);
                    $doc->exportCaption($this->kualitasproduk);
                    $doc->exportCaption($this->bahan_campaign);
                    $doc->exportCaption($this->ukuran_sediaan);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->aplikasi);
                    $doc->exportCaption($this->estetika);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->ukurankemasan);
                    $doc->exportCaption($this->kemasanbentuk);
                    $doc->exportCaption($this->kemasantutup);
                    $doc->exportCaption($this->kemasancatatan);
                    $doc->exportCaption($this->labelbahan);
                    $doc->exportCaption($this->labelkualitas);
                    $doc->exportCaption($this->labelposisi);
                    $doc->exportCaption($this->labelcatatan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->selesai);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->tanggal_order);
                    $doc->exportCaption($this->target_selesai);
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->sifatorder);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->nomororder);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idkategoriproduk);
                    $doc->exportCaption($this->idjenisproduk);
                    $doc->exportCaption($this->fungsiproduk);
                    $doc->exportCaption($this->kualitasproduk);
                    $doc->exportCaption($this->bahan_campaign);
                    $doc->exportCaption($this->ukuran_sediaan);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->aplikasi);
                    $doc->exportCaption($this->estetika);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->ukurankemasan);
                    $doc->exportCaption($this->kemasanbentuk);
                    $doc->exportCaption($this->kemasantutup);
                    $doc->exportCaption($this->labelbahan);
                    $doc->exportCaption($this->labelkualitas);
                    $doc->exportCaption($this->labelposisi);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->selesai);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
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
                        $doc->exportField($this->tanggal_order);
                        $doc->exportField($this->target_selesai);
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->sifatorder);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->nomororder);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idkategoriproduk);
                        $doc->exportField($this->idjenisproduk);
                        $doc->exportField($this->fungsiproduk);
                        $doc->exportField($this->kualitasproduk);
                        $doc->exportField($this->bahan_campaign);
                        $doc->exportField($this->ukuran_sediaan);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->aplikasi);
                        $doc->exportField($this->estetika);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->ukurankemasan);
                        $doc->exportField($this->kemasanbentuk);
                        $doc->exportField($this->kemasantutup);
                        $doc->exportField($this->kemasancatatan);
                        $doc->exportField($this->labelbahan);
                        $doc->exportField($this->labelkualitas);
                        $doc->exportField($this->labelposisi);
                        $doc->exportField($this->labelcatatan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->selesai);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->tanggal_order);
                        $doc->exportField($this->target_selesai);
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->sifatorder);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->nomororder);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idkategoriproduk);
                        $doc->exportField($this->idjenisproduk);
                        $doc->exportField($this->fungsiproduk);
                        $doc->exportField($this->kualitasproduk);
                        $doc->exportField($this->bahan_campaign);
                        $doc->exportField($this->ukuran_sediaan);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->aplikasi);
                        $doc->exportField($this->estetika);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->ukurankemasan);
                        $doc->exportField($this->kemasanbentuk);
                        $doc->exportField($this->kemasantutup);
                        $doc->exportField($this->labelbahan);
                        $doc->exportField($this->labelkualitas);
                        $doc->exportField($this->labelposisi);
                        $doc->exportField($this->status);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->selesai);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
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
        $rsnew['kodeorder'] = getNextKodeNpd($rsnew['idcustomer']);
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
