<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for v_npd_customer
 */
class VNpdCustomer extends DbTable
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
    public $statuskategori;
    public $idpegawai;
    public $idcustomer;
    public $kodeorder;
    public $idbrand;
    public $nama;
    public $idkategoribarang;
    public $idjenisbarang;
    public $idproduct_acuan;
    public $idkualitasbarang;
    public $kemasanbarang;
    public $label;
    public $bahan;
    public $ukuran;
    public $warna;
    public $parfum;
    public $harga;
    public $tambahan;
    public $orderperdana;
    public $orderreguler;
    public $status;
    public $idproduct;
    public $created_at;
    public $created_by;
    public $selesai;
    public $readonly;
    public $nama_pemesan;
    public $alamat_pemesan;
    public $jabatan_pemesan;
    public $hp_pemesan;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'v_npd_customer';
        $this->TableName = 'v_npd_customer';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`v_npd_customer`";
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
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('v_npd_customer', 'v_npd_customer', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // statuskategori
        $this->statuskategori = new DbField('v_npd_customer', 'v_npd_customer', 'x_statuskategori', 'statuskategori', '`statuskategori`', '`statuskategori`', 200, 50, -1, false, '`statuskategori`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->statuskategori->Nullable = false; // NOT NULL field
        $this->statuskategori->Sortable = true; // Allow sort
        $this->statuskategori->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->statuskategori->Param, "CustomMsg");
        $this->Fields['statuskategori'] = &$this->statuskategori;

        // idpegawai
        $this->idpegawai = new DbField('v_npd_customer', 'v_npd_customer', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idpegawai->Nullable = false; // NOT NULL field
        $this->idpegawai->Required = true; // Required field
        $this->idpegawai->Sortable = true; // Allow sort
        $this->idpegawai->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idpegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idpegawai->Param, "CustomMsg");
        $this->Fields['idpegawai'] = &$this->idpegawai;

        // idcustomer
        $this->idcustomer = new DbField('v_npd_customer', 'v_npd_customer', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idcustomer->Nullable = false; // NOT NULL field
        $this->idcustomer->Required = true; // Required field
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // kodeorder
        $this->kodeorder = new DbField('v_npd_customer', 'v_npd_customer', 'x_kodeorder', 'kodeorder', '`kodeorder`', '`kodeorder`', 200, 20, -1, false, '`kodeorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeorder->Nullable = false; // NOT NULL field
        $this->kodeorder->Required = true; // Required field
        $this->kodeorder->Sortable = true; // Allow sort
        $this->kodeorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeorder->Param, "CustomMsg");
        $this->Fields['kodeorder'] = &$this->kodeorder;

        // idbrand
        $this->idbrand = new DbField('v_npd_customer', 'v_npd_customer', 'x_idbrand', 'idbrand', '`idbrand`', '`idbrand`', 3, 11, -1, false, '`idbrand`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idbrand->Nullable = false; // NOT NULL field
        $this->idbrand->Required = true; // Required field
        $this->idbrand->Sortable = true; // Allow sort
        $this->idbrand->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idbrand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idbrand->Param, "CustomMsg");
        $this->Fields['idbrand'] = &$this->idbrand;

        // nama
        $this->nama = new DbField('v_npd_customer', 'v_npd_customer', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // idkategoribarang
        $this->idkategoribarang = new DbField('v_npd_customer', 'v_npd_customer', 'x_idkategoribarang', 'idkategoribarang', '`idkategoribarang`', '`idkategoribarang`', 3, 11, -1, false, '`idkategoribarang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idkategoribarang->Nullable = false; // NOT NULL field
        $this->idkategoribarang->Required = true; // Required field
        $this->idkategoribarang->Sortable = true; // Allow sort
        $this->idkategoribarang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkategoribarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkategoribarang->Param, "CustomMsg");
        $this->Fields['idkategoribarang'] = &$this->idkategoribarang;

        // idjenisbarang
        $this->idjenisbarang = new DbField('v_npd_customer', 'v_npd_customer', 'x_idjenisbarang', 'idjenisbarang', '`idjenisbarang`', '`idjenisbarang`', 3, 11, -1, false, '`idjenisbarang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idjenisbarang->Nullable = false; // NOT NULL field
        $this->idjenisbarang->Required = true; // Required field
        $this->idjenisbarang->Sortable = true; // Allow sort
        $this->idjenisbarang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idjenisbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idjenisbarang->Param, "CustomMsg");
        $this->Fields['idjenisbarang'] = &$this->idjenisbarang;

        // idproduct_acuan
        $this->idproduct_acuan = new DbField('v_npd_customer', 'v_npd_customer', 'x_idproduct_acuan', 'idproduct_acuan', '`idproduct_acuan`', '`idproduct_acuan`', 3, 11, -1, false, '`idproduct_acuan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idproduct_acuan->Nullable = false; // NOT NULL field
        $this->idproduct_acuan->Required = true; // Required field
        $this->idproduct_acuan->Sortable = true; // Allow sort
        $this->idproduct_acuan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idproduct_acuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idproduct_acuan->Param, "CustomMsg");
        $this->Fields['idproduct_acuan'] = &$this->idproduct_acuan;

        // idkualitasbarang
        $this->idkualitasbarang = new DbField('v_npd_customer', 'v_npd_customer', 'x_idkualitasbarang', 'idkualitasbarang', '`idkualitasbarang`', '`idkualitasbarang`', 3, 11, -1, false, '`idkualitasbarang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idkualitasbarang->Nullable = false; // NOT NULL field
        $this->idkualitasbarang->Required = true; // Required field
        $this->idkualitasbarang->Sortable = true; // Allow sort
        $this->idkualitasbarang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkualitasbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkualitasbarang->Param, "CustomMsg");
        $this->Fields['idkualitasbarang'] = &$this->idkualitasbarang;

        // kemasanbarang
        $this->kemasanbarang = new DbField('v_npd_customer', 'v_npd_customer', 'x_kemasanbarang', 'kemasanbarang', '`kemasanbarang`', '`kemasanbarang`', 200, 100, -1, false, '`kemasanbarang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasanbarang->Nullable = false; // NOT NULL field
        $this->kemasanbarang->Required = true; // Required field
        $this->kemasanbarang->Sortable = true; // Allow sort
        $this->kemasanbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasanbarang->Param, "CustomMsg");
        $this->Fields['kemasanbarang'] = &$this->kemasanbarang;

        // label
        $this->label = new DbField('v_npd_customer', 'v_npd_customer', 'x_label', 'label', '`label`', '`label`', 200, 100, -1, false, '`label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->label->Nullable = false; // NOT NULL field
        $this->label->Required = true; // Required field
        $this->label->Sortable = true; // Allow sort
        $this->label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label->Param, "CustomMsg");
        $this->Fields['label'] = &$this->label;

        // bahan
        $this->bahan = new DbField('v_npd_customer', 'v_npd_customer', 'x_bahan', 'bahan', '`bahan`', '`bahan`', 200, 100, -1, false, '`bahan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahan->Nullable = false; // NOT NULL field
        $this->bahan->Required = true; // Required field
        $this->bahan->Sortable = true; // Allow sort
        $this->bahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahan->Param, "CustomMsg");
        $this->Fields['bahan'] = &$this->bahan;

        // ukuran
        $this->ukuran = new DbField('v_npd_customer', 'v_npd_customer', 'x_ukuran', 'ukuran', '`ukuran`', '`ukuran`', 200, 100, -1, false, '`ukuran`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran->Nullable = false; // NOT NULL field
        $this->ukuran->Required = true; // Required field
        $this->ukuran->Sortable = true; // Allow sort
        $this->ukuran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran->Param, "CustomMsg");
        $this->Fields['ukuran'] = &$this->ukuran;

        // warna
        $this->warna = new DbField('v_npd_customer', 'v_npd_customer', 'x_warna', 'warna', '`warna`', '`warna`', 200, 100, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warna->Nullable = false; // NOT NULL field
        $this->warna->Required = true; // Required field
        $this->warna->Sortable = true; // Allow sort
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // parfum
        $this->parfum = new DbField('v_npd_customer', 'v_npd_customer', 'x_parfum', 'parfum', '`parfum`', '`parfum`', 200, 100, -1, false, '`parfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->parfum->Nullable = false; // NOT NULL field
        $this->parfum->Required = true; // Required field
        $this->parfum->Sortable = true; // Allow sort
        $this->parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->parfum->Param, "CustomMsg");
        $this->Fields['parfum'] = &$this->parfum;

        // harga
        $this->harga = new DbField('v_npd_customer', 'v_npd_customer', 'x_harga', 'harga', '`harga`', '`harga`', 20, 20, -1, false, '`harga`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->harga->Nullable = false; // NOT NULL field
        $this->harga->Required = true; // Required field
        $this->harga->Sortable = true; // Allow sort
        $this->harga->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->harga->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->harga->Param, "CustomMsg");
        $this->Fields['harga'] = &$this->harga;

        // tambahan
        $this->tambahan = new DbField('v_npd_customer', 'v_npd_customer', 'x_tambahan', 'tambahan', '`tambahan`', '`tambahan`', 200, 255, -1, false, '`tambahan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tambahan->Sortable = true; // Allow sort
        $this->tambahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tambahan->Param, "CustomMsg");
        $this->Fields['tambahan'] = &$this->tambahan;

        // orderperdana
        $this->orderperdana = new DbField('v_npd_customer', 'v_npd_customer', 'x_orderperdana', 'orderperdana', '`orderperdana`', '`orderperdana`', 3, 11, -1, false, '`orderperdana`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->orderperdana->Sortable = true; // Allow sort
        $this->orderperdana->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->orderperdana->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->orderperdana->Param, "CustomMsg");
        $this->Fields['orderperdana'] = &$this->orderperdana;

        // orderreguler
        $this->orderreguler = new DbField('v_npd_customer', 'v_npd_customer', 'x_orderreguler', 'orderreguler', '`orderreguler`', '`orderreguler`', 3, 11, -1, false, '`orderreguler`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->orderreguler->Sortable = true; // Allow sort
        $this->orderreguler->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->orderreguler->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->orderreguler->Param, "CustomMsg");
        $this->Fields['orderreguler'] = &$this->orderreguler;

        // status
        $this->status = new DbField('v_npd_customer', 'v_npd_customer', 'x_status', 'status', '`status`', '`status`', 200, 100, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // idproduct
        $this->idproduct = new DbField('v_npd_customer', 'v_npd_customer', 'x_idproduct', 'idproduct', '`idproduct`', '`idproduct`', 200, 50, -1, false, '`idproduct`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idproduct->Sortable = true; // Allow sort
        $this->idproduct->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idproduct->Param, "CustomMsg");
        $this->Fields['idproduct'] = &$this->idproduct;

        // created_at
        $this->created_at = new DbField('v_npd_customer', 'v_npd_customer', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // created_by
        $this->created_by = new DbField('v_npd_customer', 'v_npd_customer', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_by->Param, "CustomMsg");
        $this->Fields['created_by'] = &$this->created_by;

        // selesai
        $this->selesai = new DbField('v_npd_customer', 'v_npd_customer', 'x_selesai', 'selesai', '`selesai`', '`selesai`', 16, 1, -1, false, '`selesai`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->selesai->Nullable = false; // NOT NULL field
        $this->selesai->Sortable = true; // Allow sort
        $this->selesai->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->selesai->Lookup = new Lookup('selesai', 'v_npd_customer', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->selesai->Lookup = new Lookup('selesai', 'v_npd_customer', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->selesai->OptionCount = 2;
        $this->selesai->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->selesai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->selesai->Param, "CustomMsg");
        $this->Fields['selesai'] = &$this->selesai;

        // readonly
        $this->readonly = new DbField('v_npd_customer', 'v_npd_customer', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = true; // Allow sort
        $this->readonly->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->readonly->Lookup = new Lookup('readonly', 'v_npd_customer', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->readonly->Lookup = new Lookup('readonly', 'v_npd_customer', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->readonly->OptionCount = 2;
        $this->readonly->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->readonly->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->readonly->Param, "CustomMsg");
        $this->Fields['readonly'] = &$this->readonly;

        // nama_pemesan
        $this->nama_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_nama_pemesan', 'nama_pemesan', '`nama_pemesan`', '`nama_pemesan`', 200, 100, -1, false, '`nama_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_pemesan->Nullable = false; // NOT NULL field
        $this->nama_pemesan->Required = true; // Required field
        $this->nama_pemesan->Sortable = true; // Allow sort
        $this->nama_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_pemesan->Param, "CustomMsg");
        $this->Fields['nama_pemesan'] = &$this->nama_pemesan;

        // alamat_pemesan
        $this->alamat_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_alamat_pemesan', 'alamat_pemesan', '`alamat_pemesan`', '`alamat_pemesan`', 200, 255, -1, false, '`alamat_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat_pemesan->Sortable = true; // Allow sort
        $this->alamat_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat_pemesan->Param, "CustomMsg");
        $this->Fields['alamat_pemesan'] = &$this->alamat_pemesan;

        // jabatan_pemesan
        $this->jabatan_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_jabatan_pemesan', 'jabatan_pemesan', '`jabatan_pemesan`', '`jabatan_pemesan`', 200, 50, -1, false, '`jabatan_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jabatan_pemesan->Sortable = true; // Allow sort
        $this->jabatan_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatan_pemesan->Param, "CustomMsg");
        $this->Fields['jabatan_pemesan'] = &$this->jabatan_pemesan;

        // hp_pemesan
        $this->hp_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_hp_pemesan', 'hp_pemesan', '`hp_pemesan`', '`hp_pemesan`', 200, 20, -1, false, '`hp_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hp_pemesan->Nullable = false; // NOT NULL field
        $this->hp_pemesan->Required = true; // Required field
        $this->hp_pemesan->Sortable = true; // Allow sort
        $this->hp_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hp_pemesan->Param, "CustomMsg");
        $this->Fields['hp_pemesan'] = &$this->hp_pemesan;
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`v_npd_customer`";
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
        $this->statuskategori->DbValue = $row['statuskategori'];
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->kodeorder->DbValue = $row['kodeorder'];
        $this->idbrand->DbValue = $row['idbrand'];
        $this->nama->DbValue = $row['nama'];
        $this->idkategoribarang->DbValue = $row['idkategoribarang'];
        $this->idjenisbarang->DbValue = $row['idjenisbarang'];
        $this->idproduct_acuan->DbValue = $row['idproduct_acuan'];
        $this->idkualitasbarang->DbValue = $row['idkualitasbarang'];
        $this->kemasanbarang->DbValue = $row['kemasanbarang'];
        $this->label->DbValue = $row['label'];
        $this->bahan->DbValue = $row['bahan'];
        $this->ukuran->DbValue = $row['ukuran'];
        $this->warna->DbValue = $row['warna'];
        $this->parfum->DbValue = $row['parfum'];
        $this->harga->DbValue = $row['harga'];
        $this->tambahan->DbValue = $row['tambahan'];
        $this->orderperdana->DbValue = $row['orderperdana'];
        $this->orderreguler->DbValue = $row['orderreguler'];
        $this->status->DbValue = $row['status'];
        $this->idproduct->DbValue = $row['idproduct'];
        $this->created_at->DbValue = $row['created_at'];
        $this->created_by->DbValue = $row['created_by'];
        $this->selesai->DbValue = $row['selesai'];
        $this->readonly->DbValue = $row['readonly'];
        $this->nama_pemesan->DbValue = $row['nama_pemesan'];
        $this->alamat_pemesan->DbValue = $row['alamat_pemesan'];
        $this->jabatan_pemesan->DbValue = $row['jabatan_pemesan'];
        $this->hp_pemesan->DbValue = $row['hp_pemesan'];
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
        return $_SESSION[$name] ?? GetUrl("VNpdCustomerList");
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
        if ($pageName == "VNpdCustomerView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VNpdCustomerEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VNpdCustomerAdd") {
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
                return "VNpdCustomerView";
            case Config("API_ADD_ACTION"):
                return "VNpdCustomerAdd";
            case Config("API_EDIT_ACTION"):
                return "VNpdCustomerEdit";
            case Config("API_DELETE_ACTION"):
                return "VNpdCustomerDelete";
            case Config("API_LIST_ACTION"):
                return "VNpdCustomerList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VNpdCustomerList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VNpdCustomerView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VNpdCustomerView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VNpdCustomerAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VNpdCustomerAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VNpdCustomerEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("VNpdCustomerAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("VNpdCustomerDelete", $this->getUrlParm());
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
        $this->idproduct->setDbValue($row['idproduct']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->selesai->setDbValue($row['selesai']);
        $this->readonly->setDbValue($row['readonly']);
        $this->nama_pemesan->setDbValue($row['nama_pemesan']);
        $this->alamat_pemesan->setDbValue($row['alamat_pemesan']);
        $this->jabatan_pemesan->setDbValue($row['jabatan_pemesan']);
        $this->hp_pemesan->setDbValue($row['hp_pemesan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // idproduct

        // created_at

        // created_by

        // selesai

        // readonly

        // nama_pemesan

        // alamat_pemesan

        // jabatan_pemesan

        // hp_pemesan

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // statuskategori
        $this->statuskategori->ViewValue = $this->statuskategori->CurrentValue;
        $this->statuskategori->ViewCustomAttributes = "";

        // idpegawai
        $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
        $this->idpegawai->ViewValue = FormatNumber($this->idpegawai->ViewValue, 0, -2, -2, -2);
        $this->idpegawai->ViewCustomAttributes = "";

        // idcustomer
        $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
        $this->idcustomer->ViewValue = FormatNumber($this->idcustomer->ViewValue, 0, -2, -2, -2);
        $this->idcustomer->ViewCustomAttributes = "";

        // kodeorder
        $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
        $this->kodeorder->ViewCustomAttributes = "";

        // idbrand
        $this->idbrand->ViewValue = $this->idbrand->CurrentValue;
        $this->idbrand->ViewValue = FormatNumber($this->idbrand->ViewValue, 0, -2, -2, -2);
        $this->idbrand->ViewCustomAttributes = "";

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

        // idkategoribarang
        $this->idkategoribarang->ViewValue = $this->idkategoribarang->CurrentValue;
        $this->idkategoribarang->ViewValue = FormatNumber($this->idkategoribarang->ViewValue, 0, -2, -2, -2);
        $this->idkategoribarang->ViewCustomAttributes = "";

        // idjenisbarang
        $this->idjenisbarang->ViewValue = $this->idjenisbarang->CurrentValue;
        $this->idjenisbarang->ViewValue = FormatNumber($this->idjenisbarang->ViewValue, 0, -2, -2, -2);
        $this->idjenisbarang->ViewCustomAttributes = "";

        // idproduct_acuan
        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->CurrentValue;
        $this->idproduct_acuan->ViewValue = FormatNumber($this->idproduct_acuan->ViewValue, 0, -2, -2, -2);
        $this->idproduct_acuan->ViewCustomAttributes = "";

        // idkualitasbarang
        $this->idkualitasbarang->ViewValue = $this->idkualitasbarang->CurrentValue;
        $this->idkualitasbarang->ViewValue = FormatNumber($this->idkualitasbarang->ViewValue, 0, -2, -2, -2);
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
        $this->harga->ViewValue = FormatNumber($this->harga->ViewValue, 0, -2, -2, -2);
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

        // selesai
        if (ConvertToBool($this->selesai->CurrentValue)) {
            $this->selesai->ViewValue = $this->selesai->tagCaption(1) != "" ? $this->selesai->tagCaption(1) : "Yes";
        } else {
            $this->selesai->ViewValue = $this->selesai->tagCaption(2) != "" ? $this->selesai->tagCaption(2) : "No";
        }
        $this->selesai->ViewCustomAttributes = "";

        // readonly
        if (ConvertToBool($this->readonly->CurrentValue)) {
            $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
        } else {
            $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
        }
        $this->readonly->ViewCustomAttributes = "";

        // nama_pemesan
        $this->nama_pemesan->ViewValue = $this->nama_pemesan->CurrentValue;
        $this->nama_pemesan->ViewCustomAttributes = "";

        // alamat_pemesan
        $this->alamat_pemesan->ViewValue = $this->alamat_pemesan->CurrentValue;
        $this->alamat_pemesan->ViewCustomAttributes = "";

        // jabatan_pemesan
        $this->jabatan_pemesan->ViewValue = $this->jabatan_pemesan->CurrentValue;
        $this->jabatan_pemesan->ViewCustomAttributes = "";

        // hp_pemesan
        $this->hp_pemesan->ViewValue = $this->hp_pemesan->CurrentValue;
        $this->hp_pemesan->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // idproduct
        $this->idproduct->LinkCustomAttributes = "";
        $this->idproduct->HrefValue = "";
        $this->idproduct->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // created_by
        $this->created_by->LinkCustomAttributes = "";
        $this->created_by->HrefValue = "";
        $this->created_by->TooltipValue = "";

        // selesai
        $this->selesai->LinkCustomAttributes = "";
        $this->selesai->HrefValue = "";
        $this->selesai->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

        // nama_pemesan
        $this->nama_pemesan->LinkCustomAttributes = "";
        $this->nama_pemesan->HrefValue = "";
        $this->nama_pemesan->TooltipValue = "";

        // alamat_pemesan
        $this->alamat_pemesan->LinkCustomAttributes = "";
        $this->alamat_pemesan->HrefValue = "";
        $this->alamat_pemesan->TooltipValue = "";

        // jabatan_pemesan
        $this->jabatan_pemesan->LinkCustomAttributes = "";
        $this->jabatan_pemesan->HrefValue = "";
        $this->jabatan_pemesan->TooltipValue = "";

        // hp_pemesan
        $this->hp_pemesan->LinkCustomAttributes = "";
        $this->hp_pemesan->HrefValue = "";
        $this->hp_pemesan->TooltipValue = "";

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

        // statuskategori
        $this->statuskategori->EditAttrs["class"] = "form-control";
        $this->statuskategori->EditCustomAttributes = "";
        if (!$this->statuskategori->Raw) {
            $this->statuskategori->CurrentValue = HtmlDecode($this->statuskategori->CurrentValue);
        }
        $this->statuskategori->EditValue = $this->statuskategori->CurrentValue;
        $this->statuskategori->PlaceHolder = RemoveHtml($this->statuskategori->caption());

        // idpegawai
        $this->idpegawai->EditAttrs["class"] = "form-control";
        $this->idpegawai->EditCustomAttributes = "";
        $this->idpegawai->EditValue = $this->idpegawai->CurrentValue;
        $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
        $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

        // kodeorder
        $this->kodeorder->EditAttrs["class"] = "form-control";
        $this->kodeorder->EditCustomAttributes = "";
        if (!$this->kodeorder->Raw) {
            $this->kodeorder->CurrentValue = HtmlDecode($this->kodeorder->CurrentValue);
        }
        $this->kodeorder->EditValue = $this->kodeorder->CurrentValue;
        $this->kodeorder->PlaceHolder = RemoveHtml($this->kodeorder->caption());

        // idbrand
        $this->idbrand->EditAttrs["class"] = "form-control";
        $this->idbrand->EditCustomAttributes = "";
        $this->idbrand->EditValue = $this->idbrand->CurrentValue;
        $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // idkategoribarang
        $this->idkategoribarang->EditAttrs["class"] = "form-control";
        $this->idkategoribarang->EditCustomAttributes = "";
        $this->idkategoribarang->EditValue = $this->idkategoribarang->CurrentValue;
        $this->idkategoribarang->PlaceHolder = RemoveHtml($this->idkategoribarang->caption());

        // idjenisbarang
        $this->idjenisbarang->EditAttrs["class"] = "form-control";
        $this->idjenisbarang->EditCustomAttributes = "";
        $this->idjenisbarang->EditValue = $this->idjenisbarang->CurrentValue;
        $this->idjenisbarang->PlaceHolder = RemoveHtml($this->idjenisbarang->caption());

        // idproduct_acuan
        $this->idproduct_acuan->EditAttrs["class"] = "form-control";
        $this->idproduct_acuan->EditCustomAttributes = "";
        $this->idproduct_acuan->EditValue = $this->idproduct_acuan->CurrentValue;
        $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

        // idkualitasbarang
        $this->idkualitasbarang->EditAttrs["class"] = "form-control";
        $this->idkualitasbarang->EditCustomAttributes = "";
        $this->idkualitasbarang->EditValue = $this->idkualitasbarang->CurrentValue;
        $this->idkualitasbarang->PlaceHolder = RemoveHtml($this->idkualitasbarang->caption());

        // kemasanbarang
        $this->kemasanbarang->EditAttrs["class"] = "form-control";
        $this->kemasanbarang->EditCustomAttributes = "";
        if (!$this->kemasanbarang->Raw) {
            $this->kemasanbarang->CurrentValue = HtmlDecode($this->kemasanbarang->CurrentValue);
        }
        $this->kemasanbarang->EditValue = $this->kemasanbarang->CurrentValue;
        $this->kemasanbarang->PlaceHolder = RemoveHtml($this->kemasanbarang->caption());

        // label
        $this->label->EditAttrs["class"] = "form-control";
        $this->label->EditCustomAttributes = "";
        if (!$this->label->Raw) {
            $this->label->CurrentValue = HtmlDecode($this->label->CurrentValue);
        }
        $this->label->EditValue = $this->label->CurrentValue;
        $this->label->PlaceHolder = RemoveHtml($this->label->caption());

        // bahan
        $this->bahan->EditAttrs["class"] = "form-control";
        $this->bahan->EditCustomAttributes = "";
        if (!$this->bahan->Raw) {
            $this->bahan->CurrentValue = HtmlDecode($this->bahan->CurrentValue);
        }
        $this->bahan->EditValue = $this->bahan->CurrentValue;
        $this->bahan->PlaceHolder = RemoveHtml($this->bahan->caption());

        // ukuran
        $this->ukuran->EditAttrs["class"] = "form-control";
        $this->ukuran->EditCustomAttributes = "";
        if (!$this->ukuran->Raw) {
            $this->ukuran->CurrentValue = HtmlDecode($this->ukuran->CurrentValue);
        }
        $this->ukuran->EditValue = $this->ukuran->CurrentValue;
        $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

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

        // harga
        $this->harga->EditAttrs["class"] = "form-control";
        $this->harga->EditCustomAttributes = "";
        $this->harga->EditValue = $this->harga->CurrentValue;
        $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());

        // tambahan
        $this->tambahan->EditAttrs["class"] = "form-control";
        $this->tambahan->EditCustomAttributes = "";
        if (!$this->tambahan->Raw) {
            $this->tambahan->CurrentValue = HtmlDecode($this->tambahan->CurrentValue);
        }
        $this->tambahan->EditValue = $this->tambahan->CurrentValue;
        $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

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

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // idproduct
        $this->idproduct->EditAttrs["class"] = "form-control";
        $this->idproduct->EditCustomAttributes = "";
        if (!$this->idproduct->Raw) {
            $this->idproduct->CurrentValue = HtmlDecode($this->idproduct->CurrentValue);
        }
        $this->idproduct->EditValue = $this->idproduct->CurrentValue;
        $this->idproduct->PlaceHolder = RemoveHtml($this->idproduct->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";
        $this->created_by->EditValue = $this->created_by->CurrentValue;
        $this->created_by->PlaceHolder = RemoveHtml($this->created_by->caption());

        // selesai
        $this->selesai->EditCustomAttributes = "";
        $this->selesai->EditValue = $this->selesai->options(false);
        $this->selesai->PlaceHolder = RemoveHtml($this->selesai->caption());

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

        // nama_pemesan
        $this->nama_pemesan->EditAttrs["class"] = "form-control";
        $this->nama_pemesan->EditCustomAttributes = "";
        if (!$this->nama_pemesan->Raw) {
            $this->nama_pemesan->CurrentValue = HtmlDecode($this->nama_pemesan->CurrentValue);
        }
        $this->nama_pemesan->EditValue = $this->nama_pemesan->CurrentValue;
        $this->nama_pemesan->PlaceHolder = RemoveHtml($this->nama_pemesan->caption());

        // alamat_pemesan
        $this->alamat_pemesan->EditAttrs["class"] = "form-control";
        $this->alamat_pemesan->EditCustomAttributes = "";
        if (!$this->alamat_pemesan->Raw) {
            $this->alamat_pemesan->CurrentValue = HtmlDecode($this->alamat_pemesan->CurrentValue);
        }
        $this->alamat_pemesan->EditValue = $this->alamat_pemesan->CurrentValue;
        $this->alamat_pemesan->PlaceHolder = RemoveHtml($this->alamat_pemesan->caption());

        // jabatan_pemesan
        $this->jabatan_pemesan->EditAttrs["class"] = "form-control";
        $this->jabatan_pemesan->EditCustomAttributes = "";
        if (!$this->jabatan_pemesan->Raw) {
            $this->jabatan_pemesan->CurrentValue = HtmlDecode($this->jabatan_pemesan->CurrentValue);
        }
        $this->jabatan_pemesan->EditValue = $this->jabatan_pemesan->CurrentValue;
        $this->jabatan_pemesan->PlaceHolder = RemoveHtml($this->jabatan_pemesan->caption());

        // hp_pemesan
        $this->hp_pemesan->EditAttrs["class"] = "form-control";
        $this->hp_pemesan->EditCustomAttributes = "";
        if (!$this->hp_pemesan->Raw) {
            $this->hp_pemesan->CurrentValue = HtmlDecode($this->hp_pemesan->CurrentValue);
        }
        $this->hp_pemesan->EditValue = $this->hp_pemesan->CurrentValue;
        $this->hp_pemesan->PlaceHolder = RemoveHtml($this->hp_pemesan->caption());

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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->statuskategori);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->idkategoribarang);
                    $doc->exportCaption($this->idjenisbarang);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->idkualitasbarang);
                    $doc->exportCaption($this->kemasanbarang);
                    $doc->exportCaption($this->label);
                    $doc->exportCaption($this->bahan);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->orderperdana);
                    $doc->exportCaption($this->orderreguler);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->idproduct);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->created_by);
                    $doc->exportCaption($this->selesai);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->nama_pemesan);
                    $doc->exportCaption($this->alamat_pemesan);
                    $doc->exportCaption($this->jabatan_pemesan);
                    $doc->exportCaption($this->hp_pemesan);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->statuskategori);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->idkategoribarang);
                    $doc->exportCaption($this->idjenisbarang);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->idkualitasbarang);
                    $doc->exportCaption($this->kemasanbarang);
                    $doc->exportCaption($this->label);
                    $doc->exportCaption($this->bahan);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->orderperdana);
                    $doc->exportCaption($this->orderreguler);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->idproduct);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->created_by);
                    $doc->exportCaption($this->selesai);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->nama_pemesan);
                    $doc->exportCaption($this->alamat_pemesan);
                    $doc->exportCaption($this->jabatan_pemesan);
                    $doc->exportCaption($this->hp_pemesan);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->statuskategori);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->idkategoribarang);
                        $doc->exportField($this->idjenisbarang);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->idkualitasbarang);
                        $doc->exportField($this->kemasanbarang);
                        $doc->exportField($this->label);
                        $doc->exportField($this->bahan);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->orderperdana);
                        $doc->exportField($this->orderreguler);
                        $doc->exportField($this->status);
                        $doc->exportField($this->idproduct);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->created_by);
                        $doc->exportField($this->selesai);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->nama_pemesan);
                        $doc->exportField($this->alamat_pemesan);
                        $doc->exportField($this->jabatan_pemesan);
                        $doc->exportField($this->hp_pemesan);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->statuskategori);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->idkategoribarang);
                        $doc->exportField($this->idjenisbarang);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->idkualitasbarang);
                        $doc->exportField($this->kemasanbarang);
                        $doc->exportField($this->label);
                        $doc->exportField($this->bahan);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->orderperdana);
                        $doc->exportField($this->orderreguler);
                        $doc->exportField($this->status);
                        $doc->exportField($this->idproduct);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->created_by);
                        $doc->exportField($this->selesai);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->nama_pemesan);
                        $doc->exportField($this->alamat_pemesan);
                        $doc->exportField($this->jabatan_pemesan);
                        $doc->exportField($this->hp_pemesan);
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
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
