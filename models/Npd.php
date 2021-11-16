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
    public $status;
    public $idpegawai;
    public $idcustomer;
    public $kodeorder;
    public $idproduct_acuan;
    public $nama;
    public $idjenisbarang;
    public $idkategoribarang;
    public $warna;
    public $parfum;
    public $tambahan;
    public $kemasanbarang;
    public $label;
    public $orderperdana;
    public $orderreguler;
    public $selesai;
    public $readonly;
    public $created_at;
    public $tanggal_order;
    public $target_selesai;
    public $kategori;
    public $fungsi_produk;
    public $kualitasbarang;
    public $bahan_campaign;
    public $ukuran_sediaan;

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
        $this->id = new DbField('npd', 'npd', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // status
        $this->status = new DbField('npd', 'npd', 'x_status', 'status', '`status`', '`status`', 200, 100, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

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
        $this->idcustomer = new DbField('npd', 'npd', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
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

        // kodeorder
        $this->kodeorder = new DbField('npd', 'npd', 'x_kodeorder', 'kodeorder', '`kodeorder`', '`kodeorder`', 200, 20, -1, false, '`kodeorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeorder->Nullable = false; // NOT NULL field
        $this->kodeorder->Required = true; // Required field
        $this->kodeorder->Sortable = true; // Allow sort
        $this->kodeorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeorder->Param, "CustomMsg");
        $this->Fields['kodeorder'] = &$this->kodeorder;

        // idproduct_acuan
        $this->idproduct_acuan = new DbField('npd', 'npd', 'x_idproduct_acuan', 'idproduct_acuan', '`idproduct_acuan`', '`idproduct_acuan`', 3, 11, -1, false, '`idproduct_acuan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idproduct_acuan->Nullable = false; // NOT NULL field
        $this->idproduct_acuan->Required = true; // Required field
        $this->idproduct_acuan->Sortable = true; // Allow sort
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

        // nama
        $this->nama = new DbField('npd', 'npd', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // idjenisbarang
        $this->idjenisbarang = new DbField('npd', 'npd', 'x_idjenisbarang', 'idjenisbarang', '`idjenisbarang`', '`idjenisbarang`', 3, 11, -1, false, '`idjenisbarang`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idjenisbarang->Nullable = false; // NOT NULL field
        $this->idjenisbarang->Required = true; // Required field
        $this->idjenisbarang->Sortable = true; // Allow sort
        $this->idjenisbarang->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idjenisbarang->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idjenisbarang->Lookup = new Lookup('idjenisbarang', 'jenisbarang', false, 'id', ["nama","","",""], ["x_idkategoribarang"], [], ["idkategoribarang"], ["x_idkategoribarang"], [], [], '', '');
                break;
            default:
                $this->idjenisbarang->Lookup = new Lookup('idjenisbarang', 'jenisbarang', false, 'id', ["nama","","",""], ["x_idkategoribarang"], [], ["idkategoribarang"], ["x_idkategoribarang"], [], [], '', '');
                break;
        }
        $this->idjenisbarang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idjenisbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idjenisbarang->Param, "CustomMsg");
        $this->Fields['idjenisbarang'] = &$this->idjenisbarang;

        // idkategoribarang
        $this->idkategoribarang = new DbField('npd', 'npd', 'x_idkategoribarang', 'idkategoribarang', '`idkategoribarang`', '`idkategoribarang`', 3, 11, -1, false, '`idkategoribarang`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkategoribarang->Nullable = false; // NOT NULL field
        $this->idkategoribarang->Required = true; // Required field
        $this->idkategoribarang->Sortable = true; // Allow sort
        $this->idkategoribarang->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkategoribarang->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkategoribarang->Lookup = new Lookup('idkategoribarang', 'kategoribarang', false, 'id', ["nama","","",""], [], ["x_idjenisbarang"], [], [], [], [], '', '');
                break;
            default:
                $this->idkategoribarang->Lookup = new Lookup('idkategoribarang', 'kategoribarang', false, 'id', ["nama","","",""], [], ["x_idjenisbarang"], [], [], [], [], '', '');
                break;
        }
        $this->idkategoribarang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkategoribarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkategoribarang->Param, "CustomMsg");
        $this->Fields['idkategoribarang'] = &$this->idkategoribarang;

        // warna
        $this->warna = new DbField('npd', 'npd', 'x_warna', 'warna', '`warna`', '`warna`', 200, 100, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warna->Nullable = false; // NOT NULL field
        $this->warna->Required = true; // Required field
        $this->warna->Sortable = true; // Allow sort
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // parfum
        $this->parfum = new DbField('npd', 'npd', 'x_parfum', 'parfum', '`parfum`', '`parfum`', 200, 100, -1, false, '`parfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->parfum->Nullable = false; // NOT NULL field
        $this->parfum->Required = true; // Required field
        $this->parfum->Sortable = true; // Allow sort
        $this->parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->parfum->Param, "CustomMsg");
        $this->Fields['parfum'] = &$this->parfum;

        // tambahan
        $this->tambahan = new DbField('npd', 'npd', 'x_tambahan', 'tambahan', '`tambahan`', '`tambahan`', 200, 255, -1, false, '`tambahan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->tambahan->Sortable = true; // Allow sort
        $this->tambahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tambahan->Param, "CustomMsg");
        $this->Fields['tambahan'] = &$this->tambahan;

        // kemasanbarang
        $this->kemasanbarang = new DbField('npd', 'npd', 'x_kemasanbarang', 'kemasanbarang', '`kemasanbarang`', '`kemasanbarang`', 200, 100, -1, false, '`kemasanbarang`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->kemasanbarang->Nullable = false; // NOT NULL field
        $this->kemasanbarang->Required = true; // Required field
        $this->kemasanbarang->Sortable = true; // Allow sort
        $this->kemasanbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasanbarang->Param, "CustomMsg");
        $this->Fields['kemasanbarang'] = &$this->kemasanbarang;

        // label
        $this->label = new DbField('npd', 'npd', 'x_label', 'label', '`label`', '`label`', 200, 100, -1, false, '`label`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->label->Nullable = false; // NOT NULL field
        $this->label->Required = true; // Required field
        $this->label->Sortable = true; // Allow sort
        $this->label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label->Param, "CustomMsg");
        $this->Fields['label'] = &$this->label;

        // orderperdana
        $this->orderperdana = new DbField('npd', 'npd', 'x_orderperdana', 'orderperdana', '`orderperdana`', '`orderperdana`', 3, 11, -1, false, '`orderperdana`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->orderperdana->Sortable = true; // Allow sort
        $this->orderperdana->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->orderperdana->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->orderperdana->Param, "CustomMsg");
        $this->Fields['orderperdana'] = &$this->orderperdana;

        // orderreguler
        $this->orderreguler = new DbField('npd', 'npd', 'x_orderreguler', 'orderreguler', '`orderreguler`', '`orderreguler`', 3, 11, -1, false, '`orderreguler`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->orderreguler->Sortable = true; // Allow sort
        $this->orderreguler->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->orderreguler->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->orderreguler->Param, "CustomMsg");
        $this->Fields['orderreguler'] = &$this->orderreguler;

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

        // created_at
        $this->created_at = new DbField('npd', 'npd', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

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

        // kategori
        $this->kategori = new DbField('npd', 'npd', 'x_kategori', 'kategori', '`kategori`', '`kategori`', 200, 50, -1, false, '`kategori`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kategori->Nullable = false; // NOT NULL field
        $this->kategori->Sortable = true; // Allow sort
        $this->kategori->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategori->Param, "CustomMsg");
        $this->Fields['kategori'] = &$this->kategori;

        // fungsi_produk
        $this->fungsi_produk = new DbField('npd', 'npd', 'x_fungsi_produk', 'fungsi_produk', '`fungsi_produk`', '`fungsi_produk`', 200, 255, -1, false, '`fungsi_produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fungsi_produk->Nullable = false; // NOT NULL field
        $this->fungsi_produk->Required = true; // Required field
        $this->fungsi_produk->Sortable = true; // Allow sort
        $this->fungsi_produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fungsi_produk->Param, "CustomMsg");
        $this->Fields['fungsi_produk'] = &$this->fungsi_produk;

        // kualitasbarang
        $this->kualitasbarang = new DbField('npd', 'npd', 'x_kualitasbarang', 'kualitasbarang', '`kualitasbarang`', '`kualitasbarang`', 200, 255, -1, false, '`kualitasbarang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kualitasbarang->Nullable = false; // NOT NULL field
        $this->kualitasbarang->Required = true; // Required field
        $this->kualitasbarang->Sortable = true; // Allow sort
        $this->kualitasbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kualitasbarang->Param, "CustomMsg");
        $this->Fields['kualitasbarang'] = &$this->kualitasbarang;

        // bahan_campaign
        $this->bahan_campaign = new DbField('npd', 'npd', 'x_bahan_campaign', 'bahan_campaign', '`bahan_campaign`', '`bahan_campaign`', 200, 100, -1, false, '`bahan_campaign`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahan_campaign->Nullable = false; // NOT NULL field
        $this->bahan_campaign->Required = true; // Required field
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
        $this->status->DbValue = $row['status'];
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->kodeorder->DbValue = $row['kodeorder'];
        $this->idproduct_acuan->DbValue = $row['idproduct_acuan'];
        $this->nama->DbValue = $row['nama'];
        $this->idjenisbarang->DbValue = $row['idjenisbarang'];
        $this->idkategoribarang->DbValue = $row['idkategoribarang'];
        $this->warna->DbValue = $row['warna'];
        $this->parfum->DbValue = $row['parfum'];
        $this->tambahan->DbValue = $row['tambahan'];
        $this->kemasanbarang->DbValue = $row['kemasanbarang'];
        $this->label->DbValue = $row['label'];
        $this->orderperdana->DbValue = $row['orderperdana'];
        $this->orderreguler->DbValue = $row['orderreguler'];
        $this->selesai->DbValue = $row['selesai'];
        $this->readonly->DbValue = $row['readonly'];
        $this->created_at->DbValue = $row['created_at'];
        $this->tanggal_order->DbValue = $row['tanggal_order'];
        $this->target_selesai->DbValue = $row['target_selesai'];
        $this->kategori->DbValue = $row['kategori'];
        $this->fungsi_produk->DbValue = $row['fungsi_produk'];
        $this->kualitasbarang->DbValue = $row['kualitasbarang'];
        $this->bahan_campaign->DbValue = $row['bahan_campaign'];
        $this->ukuran_sediaan->DbValue = $row['ukuran_sediaan'];
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
        $this->status->setDbValue($row['status']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->nama->setDbValue($row['nama']);
        $this->idjenisbarang->setDbValue($row['idjenisbarang']);
        $this->idkategoribarang->setDbValue($row['idkategoribarang']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->kemasanbarang->setDbValue($row['kemasanbarang']);
        $this->label->setDbValue($row['label']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderreguler->setDbValue($row['orderreguler']);
        $this->selesai->setDbValue($row['selesai']);
        $this->readonly->setDbValue($row['readonly']);
        $this->created_at->setDbValue($row['created_at']);
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->kategori->setDbValue($row['kategori']);
        $this->fungsi_produk->setDbValue($row['fungsi_produk']);
        $this->kualitasbarang->setDbValue($row['kualitasbarang']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // status

        // idpegawai

        // idcustomer

        // kodeorder

        // idproduct_acuan

        // nama

        // idjenisbarang

        // idkategoribarang

        // warna

        // parfum

        // tambahan

        // kemasanbarang

        // label

        // orderperdana

        // orderreguler

        // selesai

        // readonly

        // created_at

        // tanggal_order

        // target_selesai

        // kategori

        // fungsi_produk

        // kualitasbarang

        // bahan_campaign

        // ukuran_sediaan

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

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

        // kodeorder
        $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
        $this->kodeorder->ViewCustomAttributes = "";

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

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

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

        // warna
        $this->warna->ViewValue = $this->warna->CurrentValue;
        $this->warna->ViewCustomAttributes = "";

        // parfum
        $this->parfum->ViewValue = $this->parfum->CurrentValue;
        $this->parfum->ViewCustomAttributes = "";

        // tambahan
        $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
        $this->tambahan->ViewCustomAttributes = "";

        // kemasanbarang
        $this->kemasanbarang->ViewValue = $this->kemasanbarang->CurrentValue;
        $this->kemasanbarang->ViewCustomAttributes = "";

        // label
        $this->label->ViewValue = $this->label->CurrentValue;
        $this->label->ViewCustomAttributes = "";

        // orderperdana
        $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
        $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
        $this->orderperdana->ViewCustomAttributes = "";

        // orderreguler
        $this->orderreguler->ViewValue = $this->orderreguler->CurrentValue;
        $this->orderreguler->ViewValue = FormatNumber($this->orderreguler->ViewValue, 0, -2, -2, -2);
        $this->orderreguler->ViewCustomAttributes = "";

        // selesai
        if (strval($this->selesai->CurrentValue) != "") {
            $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
        } else {
            $this->selesai->ViewValue = null;
        }
        $this->selesai->ViewCustomAttributes = "";

        // readonly
        if (strval($this->readonly->CurrentValue) != "") {
            $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
        } else {
            $this->readonly->ViewValue = null;
        }
        $this->readonly->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // tanggal_order
        $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
        $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
        $this->tanggal_order->ViewCustomAttributes = "";

        // target_selesai
        $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
        $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
        $this->target_selesai->ViewCustomAttributes = "";

        // kategori
        $this->kategori->ViewValue = $this->kategori->CurrentValue;
        $this->kategori->ViewCustomAttributes = "";

        // fungsi_produk
        $this->fungsi_produk->ViewValue = $this->fungsi_produk->CurrentValue;
        $this->fungsi_produk->ViewCustomAttributes = "";

        // kualitasbarang
        $this->kualitasbarang->ViewValue = $this->kualitasbarang->CurrentValue;
        $this->kualitasbarang->ViewCustomAttributes = "";

        // bahan_campaign
        $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
        $this->bahan_campaign->ViewCustomAttributes = "";

        // ukuran_sediaan
        $this->ukuran_sediaan->ViewValue = $this->ukuran_sediaan->CurrentValue;
        $this->ukuran_sediaan->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

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

        // idproduct_acuan
        $this->idproduct_acuan->LinkCustomAttributes = "";
        $this->idproduct_acuan->HrefValue = "";
        $this->idproduct_acuan->TooltipValue = "";

        // nama
        $this->nama->LinkCustomAttributes = "";
        $this->nama->HrefValue = "";
        $this->nama->TooltipValue = "";

        // idjenisbarang
        $this->idjenisbarang->LinkCustomAttributes = "";
        $this->idjenisbarang->HrefValue = "";
        $this->idjenisbarang->TooltipValue = "";

        // idkategoribarang
        $this->idkategoribarang->LinkCustomAttributes = "";
        $this->idkategoribarang->HrefValue = "";
        $this->idkategoribarang->TooltipValue = "";

        // warna
        $this->warna->LinkCustomAttributes = "";
        $this->warna->HrefValue = "";
        $this->warna->TooltipValue = "";

        // parfum
        $this->parfum->LinkCustomAttributes = "";
        $this->parfum->HrefValue = "";
        $this->parfum->TooltipValue = "";

        // tambahan
        $this->tambahan->LinkCustomAttributes = "";
        $this->tambahan->HrefValue = "";
        $this->tambahan->TooltipValue = "";

        // kemasanbarang
        $this->kemasanbarang->LinkCustomAttributes = "";
        $this->kemasanbarang->HrefValue = "";
        $this->kemasanbarang->TooltipValue = "";

        // label
        $this->label->LinkCustomAttributes = "";
        $this->label->HrefValue = "";
        $this->label->TooltipValue = "";

        // orderperdana
        $this->orderperdana->LinkCustomAttributes = "";
        $this->orderperdana->HrefValue = "";
        $this->orderperdana->TooltipValue = "";

        // orderreguler
        $this->orderreguler->LinkCustomAttributes = "";
        $this->orderreguler->HrefValue = "";
        $this->orderreguler->TooltipValue = "";

        // selesai
        $this->selesai->LinkCustomAttributes = "";
        $this->selesai->HrefValue = "";
        $this->selesai->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // tanggal_order
        $this->tanggal_order->LinkCustomAttributes = "";
        $this->tanggal_order->HrefValue = "";
        $this->tanggal_order->TooltipValue = "";

        // target_selesai
        $this->target_selesai->LinkCustomAttributes = "";
        $this->target_selesai->HrefValue = "";
        $this->target_selesai->TooltipValue = "";

        // kategori
        $this->kategori->LinkCustomAttributes = "";
        $this->kategori->HrefValue = "";
        $this->kategori->TooltipValue = "";

        // fungsi_produk
        $this->fungsi_produk->LinkCustomAttributes = "";
        $this->fungsi_produk->HrefValue = "";
        $this->fungsi_produk->TooltipValue = "";

        // kualitasbarang
        $this->kualitasbarang->LinkCustomAttributes = "";
        $this->kualitasbarang->HrefValue = "";
        $this->kualitasbarang->TooltipValue = "";

        // bahan_campaign
        $this->bahan_campaign->LinkCustomAttributes = "";
        $this->bahan_campaign->HrefValue = "";
        $this->bahan_campaign->TooltipValue = "";

        // ukuran_sediaan
        $this->ukuran_sediaan->LinkCustomAttributes = "";
        $this->ukuran_sediaan->HrefValue = "";
        $this->ukuran_sediaan->TooltipValue = "";

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

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

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

        // kodeorder
        $this->kodeorder->EditAttrs["class"] = "form-control";
        $this->kodeorder->EditCustomAttributes = "";
        $this->kodeorder->EditValue = $this->kodeorder->CurrentValue;
        $this->kodeorder->ViewCustomAttributes = "";

        // idproduct_acuan
        $this->idproduct_acuan->EditAttrs["class"] = "form-control";
        $this->idproduct_acuan->EditCustomAttributes = "";
        $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // idjenisbarang
        $this->idjenisbarang->EditAttrs["class"] = "form-control";
        $this->idjenisbarang->EditCustomAttributes = "";
        $this->idjenisbarang->PlaceHolder = RemoveHtml($this->idjenisbarang->caption());

        // idkategoribarang
        $this->idkategoribarang->EditAttrs["class"] = "form-control";
        $this->idkategoribarang->EditCustomAttributes = "";
        $this->idkategoribarang->PlaceHolder = RemoveHtml($this->idkategoribarang->caption());

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
        if (!$this->parfum->Raw) {
            $this->parfum->CurrentValue = HtmlDecode($this->parfum->CurrentValue);
        }
        $this->parfum->EditValue = $this->parfum->CurrentValue;
        $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

        // tambahan
        $this->tambahan->EditAttrs["class"] = "form-control";
        $this->tambahan->EditCustomAttributes = "";
        $this->tambahan->EditValue = $this->tambahan->CurrentValue;
        $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

        // kemasanbarang
        $this->kemasanbarang->EditAttrs["class"] = "form-control";
        $this->kemasanbarang->EditCustomAttributes = "";
        $this->kemasanbarang->EditValue = $this->kemasanbarang->CurrentValue;
        $this->kemasanbarang->PlaceHolder = RemoveHtml($this->kemasanbarang->caption());

        // label
        $this->label->EditAttrs["class"] = "form-control";
        $this->label->EditCustomAttributes = "";
        $this->label->EditValue = $this->label->CurrentValue;
        $this->label->PlaceHolder = RemoveHtml($this->label->caption());

        // orderperdana
        $this->orderperdana->EditAttrs["class"] = "form-control";
        $this->orderperdana->EditCustomAttributes = "";
        $this->orderperdana->EditValue = $this->orderperdana->CurrentValue;
        $this->orderperdana->PlaceHolder = RemoveHtml($this->orderperdana->caption());

        // orderreguler
        $this->orderreguler->EditAttrs["class"] = "form-control";
        $this->orderreguler->EditCustomAttributes = "";
        $this->orderreguler->EditValue = $this->orderreguler->CurrentValue;
        $this->orderreguler->PlaceHolder = RemoveHtml($this->orderreguler->caption());

        // selesai
        $this->selesai->EditCustomAttributes = "";
        $this->selesai->EditValue = $this->selesai->options(false);
        $this->selesai->PlaceHolder = RemoveHtml($this->selesai->caption());

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

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

        // kategori
        $this->kategori->EditAttrs["class"] = "form-control";
        $this->kategori->EditCustomAttributes = "";
        if (!$this->kategori->Raw) {
            $this->kategori->CurrentValue = HtmlDecode($this->kategori->CurrentValue);
        }
        $this->kategori->EditValue = $this->kategori->CurrentValue;
        $this->kategori->PlaceHolder = RemoveHtml($this->kategori->caption());

        // fungsi_produk
        $this->fungsi_produk->EditAttrs["class"] = "form-control";
        $this->fungsi_produk->EditCustomAttributes = "";
        if (!$this->fungsi_produk->Raw) {
            $this->fungsi_produk->CurrentValue = HtmlDecode($this->fungsi_produk->CurrentValue);
        }
        $this->fungsi_produk->EditValue = $this->fungsi_produk->CurrentValue;
        $this->fungsi_produk->PlaceHolder = RemoveHtml($this->fungsi_produk->caption());

        // kualitasbarang
        $this->kualitasbarang->EditAttrs["class"] = "form-control";
        $this->kualitasbarang->EditCustomAttributes = "";
        if (!$this->kualitasbarang->Raw) {
            $this->kualitasbarang->CurrentValue = HtmlDecode($this->kualitasbarang->CurrentValue);
        }
        $this->kualitasbarang->EditValue = $this->kualitasbarang->CurrentValue;
        $this->kualitasbarang->PlaceHolder = RemoveHtml($this->kualitasbarang->caption());

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
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->idjenisbarang);
                    $doc->exportCaption($this->idkategoribarang);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->kemasanbarang);
                    $doc->exportCaption($this->label);
                    $doc->exportCaption($this->orderperdana);
                    $doc->exportCaption($this->orderreguler);
                    $doc->exportCaption($this->selesai);
                    $doc->exportCaption($this->tanggal_order);
                    $doc->exportCaption($this->target_selesai);
                    $doc->exportCaption($this->kategori);
                    $doc->exportCaption($this->fungsi_produk);
                    $doc->exportCaption($this->kualitasbarang);
                    $doc->exportCaption($this->bahan_campaign);
                    $doc->exportCaption($this->ukuran_sediaan);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->idjenisbarang);
                    $doc->exportCaption($this->idkategoribarang);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->kemasanbarang);
                    $doc->exportCaption($this->label);
                    $doc->exportCaption($this->orderperdana);
                    $doc->exportCaption($this->orderreguler);
                    $doc->exportCaption($this->selesai);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->tanggal_order);
                    $doc->exportCaption($this->target_selesai);
                    $doc->exportCaption($this->kategori);
                    $doc->exportCaption($this->fungsi_produk);
                    $doc->exportCaption($this->kualitasbarang);
                    $doc->exportCaption($this->bahan_campaign);
                    $doc->exportCaption($this->ukuran_sediaan);
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
                        $doc->exportField($this->status);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->idjenisbarang);
                        $doc->exportField($this->idkategoribarang);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->kemasanbarang);
                        $doc->exportField($this->label);
                        $doc->exportField($this->orderperdana);
                        $doc->exportField($this->orderreguler);
                        $doc->exportField($this->selesai);
                        $doc->exportField($this->tanggal_order);
                        $doc->exportField($this->target_selesai);
                        $doc->exportField($this->kategori);
                        $doc->exportField($this->fungsi_produk);
                        $doc->exportField($this->kualitasbarang);
                        $doc->exportField($this->bahan_campaign);
                        $doc->exportField($this->ukuran_sediaan);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->status);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->idjenisbarang);
                        $doc->exportField($this->idkategoribarang);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->kemasanbarang);
                        $doc->exportField($this->label);
                        $doc->exportField($this->orderperdana);
                        $doc->exportField($this->orderreguler);
                        $doc->exportField($this->selesai);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->tanggal_order);
                        $doc->exportField($this->target_selesai);
                        $doc->exportField($this->kategori);
                        $doc->exportField($this->fungsi_produk);
                        $doc->exportField($this->kualitasbarang);
                        $doc->exportField($this->bahan_campaign);
                        $doc->exportField($this->ukuran_sediaan);
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
        //$idcustomer = $rsnew['idcustomer'];
        //$rsnew['kodeorder'] = getNextKodeNpd($idcustomer);
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
