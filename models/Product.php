<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for product
 */
class Product extends DbTable
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
    public $idbrand;
    public $kode;
    public $nama;
    public $idkategoribarang;
    public $idjenisbarang;
    public $idkualitasbarang;
    public $idproduct_acuan;
    public $idkemasanbarang;
    public $kemasanbarang;
    public $harga;
    public $ukuran;
    public $netto;
    public $satuan;
    public $bahan;
    public $warna;
    public $parfum;
    public $label;
    public $foto;
    public $tambahan;
    public $ijinbpom;
    public $aktif;
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
        $this->TableVar = 'product';
        $this->TableName = 'product';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`product`";
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
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('product', 'product', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idbrand
        $this->idbrand = new DbField('product', 'product', 'x_idbrand', 'idbrand', '`idbrand`', '`idbrand`', 3, 11, -1, false, '`idbrand`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idbrand->IsForeignKey = true; // Foreign key field
        $this->idbrand->Nullable = false; // NOT NULL field
        $this->idbrand->Required = true; // Required field
        $this->idbrand->Sortable = true; // Allow sort
        $this->idbrand->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idbrand->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idbrand->Lookup = new Lookup('idbrand', 'brand', false, 'id', ["title","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idbrand->Lookup = new Lookup('idbrand', 'brand', false, 'id', ["title","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idbrand->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idbrand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idbrand->Param, "CustomMsg");
        $this->Fields['idbrand'] = &$this->idbrand;

        // kode
        $this->kode = new DbField('product', 'product', 'x_kode', 'kode', '`kode`', '`kode`', 200, 50, -1, false, '`kode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode->Nullable = false; // NOT NULL field
        $this->kode->Required = true; // Required field
        $this->kode->Sortable = true; // Allow sort
        $this->kode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode->Param, "CustomMsg");
        $this->Fields['kode'] = &$this->kode;

        // nama
        $this->nama = new DbField('product', 'product', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // idkategoribarang
        $this->idkategoribarang = new DbField('product', 'product', 'x_idkategoribarang', 'idkategoribarang', '`idkategoribarang`', '`idkategoribarang`', 3, 11, -1, false, '`idkategoribarang`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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

        // idjenisbarang
        $this->idjenisbarang = new DbField('product', 'product', 'x_idjenisbarang', 'idjenisbarang', '`idjenisbarang`', '`idjenisbarang`', 3, 11, -1, false, '`idjenisbarang`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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

        // idkualitasbarang
        $this->idkualitasbarang = new DbField('product', 'product', 'x_idkualitasbarang', 'idkualitasbarang', '`idkualitasbarang`', '`idkualitasbarang`', 3, 11, -1, false, '`idkualitasbarang`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkualitasbarang->Sortable = true; // Allow sort
        $this->idkualitasbarang->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkualitasbarang->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkualitasbarang->Lookup = new Lookup('idkualitasbarang', 'kualitasbarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idkualitasbarang->Lookup = new Lookup('idkualitasbarang', 'kualitasbarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idkualitasbarang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkualitasbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkualitasbarang->Param, "CustomMsg");
        $this->Fields['idkualitasbarang'] = &$this->idkualitasbarang;

        // idproduct_acuan
        $this->idproduct_acuan = new DbField('product', 'product', 'x_idproduct_acuan', 'idproduct_acuan', '`idproduct_acuan`', '`idproduct_acuan`', 3, 11, -1, false, '`idproduct_acuan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idproduct_acuan->Sortable = true; // Allow sort
        $this->idproduct_acuan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idproduct_acuan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idproduct_acuan->Lookup = new Lookup('idproduct_acuan', 'product', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idproduct_acuan->Lookup = new Lookup('idproduct_acuan', 'product', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idproduct_acuan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idproduct_acuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idproduct_acuan->Param, "CustomMsg");
        $this->Fields['idproduct_acuan'] = &$this->idproduct_acuan;

        // idkemasanbarang
        $this->idkemasanbarang = new DbField('product', 'product', 'x_idkemasanbarang', 'idkemasanbarang', '`idkemasanbarang`', '`idkemasanbarang`', 3, 11, -1, false, '`idkemasanbarang`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkemasanbarang->Sortable = false; // Allow sort
        $this->idkemasanbarang->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkemasanbarang->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkemasanbarang->Lookup = new Lookup('idkemasanbarang', 'kemasanbarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idkemasanbarang->Lookup = new Lookup('idkemasanbarang', 'kemasanbarang', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idkemasanbarang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkemasanbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkemasanbarang->Param, "CustomMsg");
        $this->Fields['idkemasanbarang'] = &$this->idkemasanbarang;

        // kemasanbarang
        $this->kemasanbarang = new DbField('product', 'product', 'x_kemasanbarang', 'kemasanbarang', '`kemasanbarang`', '`kemasanbarang`', 200, 50, -1, false, '`kemasanbarang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasanbarang->Sortable = true; // Allow sort
        $this->kemasanbarang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasanbarang->Param, "CustomMsg");
        $this->Fields['kemasanbarang'] = &$this->kemasanbarang;

        // harga
        $this->harga = new DbField('product', 'product', 'x_harga', 'harga', '`harga`', '`harga`', 20, 20, -1, false, '`harga`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->harga->Nullable = false; // NOT NULL field
        $this->harga->Required = true; // Required field
        $this->harga->Sortable = true; // Allow sort
        $this->harga->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->harga->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->harga->Param, "CustomMsg");
        $this->Fields['harga'] = &$this->harga;

        // ukuran
        $this->ukuran = new DbField('product', 'product', 'x_ukuran', 'ukuran', '`ukuran`', '`ukuran`', 200, 50, -1, false, '`ukuran`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran->Sortable = true; // Allow sort
        $this->ukuran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran->Param, "CustomMsg");
        $this->Fields['ukuran'] = &$this->ukuran;

        // netto
        $this->netto = new DbField('product', 'product', 'x_netto', 'netto', '`netto`', '`netto`', 200, 50, -1, false, '`netto`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->netto->Sortable = false; // Allow sort
        $this->netto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->netto->Param, "CustomMsg");
        $this->Fields['netto'] = &$this->netto;

        // satuan
        $this->satuan = new DbField('product', 'product', 'x_satuan', 'satuan', '`satuan`', '`satuan`', 200, 50, -1, false, '`satuan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->satuan->Sortable = false; // Allow sort
        $this->satuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->satuan->Param, "CustomMsg");
        $this->Fields['satuan'] = &$this->satuan;

        // bahan
        $this->bahan = new DbField('product', 'product', 'x_bahan', 'bahan', '`bahan`', '`bahan`', 201, 65535, -1, false, '`bahan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahan->Sortable = true; // Allow sort
        $this->bahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahan->Param, "CustomMsg");
        $this->Fields['bahan'] = &$this->bahan;

        // warna
        $this->warna = new DbField('product', 'product', 'x_warna', 'warna', '`warna`', '`warna`', 200, 50, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warna->Sortable = true; // Allow sort
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // parfum
        $this->parfum = new DbField('product', 'product', 'x_parfum', 'parfum', '`parfum`', '`parfum`', 200, 50, -1, false, '`parfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->parfum->Sortable = true; // Allow sort
        $this->parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->parfum->Param, "CustomMsg");
        $this->Fields['parfum'] = &$this->parfum;

        // label
        $this->label = new DbField('product', 'product', 'x_label', 'label', '`label`', '`label`', 200, 50, -1, false, '`label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->label->Sortable = true; // Allow sort
        $this->label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label->Param, "CustomMsg");
        $this->Fields['label'] = &$this->label;

        // foto
        $this->foto = new DbField('product', 'product', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, true, '`foto`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // tambahan
        $this->tambahan = new DbField('product', 'product', 'x_tambahan', 'tambahan', '`tambahan`', '`tambahan`', 201, 65535, -1, false, '`tambahan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->tambahan->Sortable = true; // Allow sort
        $this->tambahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tambahan->Param, "CustomMsg");
        $this->Fields['tambahan'] = &$this->tambahan;

        // ijinbpom
        $this->ijinbpom = new DbField('product', 'product', 'x_ijinbpom', 'ijinbpom', '`ijinbpom`', '`ijinbpom`', 16, 1, -1, false, '`ijinbpom`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->ijinbpom->Nullable = false; // NOT NULL field
        $this->ijinbpom->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->ijinbpom->Lookup = new Lookup('ijinbpom', 'product', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->ijinbpom->Lookup = new Lookup('ijinbpom', 'product', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->ijinbpom->OptionCount = 3;
        $this->ijinbpom->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->ijinbpom->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ijinbpom->Param, "CustomMsg");
        $this->Fields['ijinbpom'] = &$this->ijinbpom;

        // aktif
        $this->aktif = new DbField('product', 'product', 'x_aktif', 'aktif', '`aktif`', '`aktif`', 16, 1, -1, false, '`aktif`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aktif->Nullable = false; // NOT NULL field
        $this->aktif->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aktif->Lookup = new Lookup('aktif', 'product', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aktif->Lookup = new Lookup('aktif', 'product', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aktif->OptionCount = 2;
        $this->aktif->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->aktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aktif->Param, "CustomMsg");
        $this->Fields['aktif'] = &$this->aktif;

        // created_at
        $this->created_at = new DbField('product', 'product', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('product', 'product', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Nullable = false; // NOT NULL field
        $this->updated_at->Required = true; // Required field
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "brand") {
            if ($this->idbrand->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->idbrand->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "brand") {
            if ($this->idbrand->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`idbrand`", $this->idbrand->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_brand()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_brand()
    {
        return "`idbrand`=@idbrand@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`product`";
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
        $this->DefaultFilter = "`idbrand` = '1' OR `created_by` = '".CurrentUserID()."'";
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
        $this->idbrand->DbValue = $row['idbrand'];
        $this->kode->DbValue = $row['kode'];
        $this->nama->DbValue = $row['nama'];
        $this->idkategoribarang->DbValue = $row['idkategoribarang'];
        $this->idjenisbarang->DbValue = $row['idjenisbarang'];
        $this->idkualitasbarang->DbValue = $row['idkualitasbarang'];
        $this->idproduct_acuan->DbValue = $row['idproduct_acuan'];
        $this->idkemasanbarang->DbValue = $row['idkemasanbarang'];
        $this->kemasanbarang->DbValue = $row['kemasanbarang'];
        $this->harga->DbValue = $row['harga'];
        $this->ukuran->DbValue = $row['ukuran'];
        $this->netto->DbValue = $row['netto'];
        $this->satuan->DbValue = $row['satuan'];
        $this->bahan->DbValue = $row['bahan'];
        $this->warna->DbValue = $row['warna'];
        $this->parfum->DbValue = $row['parfum'];
        $this->label->DbValue = $row['label'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->tambahan->DbValue = $row['tambahan'];
        $this->ijinbpom->DbValue = $row['ijinbpom'];
        $this->aktif->DbValue = $row['aktif'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['foto']) ? [] : [$row['foto']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->foto->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
            }
        }
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
        return $_SESSION[$name] ?? GetUrl("ProductList");
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
        if ($pageName == "ProductView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ProductEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ProductAdd") {
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
                return "ProductView";
            case Config("API_ADD_ACTION"):
                return "ProductAdd";
            case Config("API_EDIT_ACTION"):
                return "ProductEdit";
            case Config("API_DELETE_ACTION"):
                return "ProductDelete";
            case Config("API_LIST_ACTION"):
                return "ProductList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ProductList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ProductView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ProductView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ProductAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ProductAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ProductEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ProductAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ProductDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "brand" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->idbrand->CurrentValue ?? $this->idbrand->getSessionValue());
        }
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
        $this->idbrand->setDbValue($row['idbrand']);
        $this->kode->setDbValue($row['kode']);
        $this->nama->setDbValue($row['nama']);
        $this->idkategoribarang->setDbValue($row['idkategoribarang']);
        $this->idjenisbarang->setDbValue($row['idjenisbarang']);
        $this->idkualitasbarang->setDbValue($row['idkualitasbarang']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->idkemasanbarang->setDbValue($row['idkemasanbarang']);
        $this->kemasanbarang->setDbValue($row['kemasanbarang']);
        $this->harga->setDbValue($row['harga']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->netto->setDbValue($row['netto']);
        $this->satuan->setDbValue($row['satuan']);
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // idbrand

        // kode

        // nama

        // idkategoribarang

        // idjenisbarang

        // idkualitasbarang

        // idproduct_acuan

        // idkemasanbarang
        $this->idkemasanbarang->CellCssStyle = "white-space: nowrap;";

        // kemasanbarang

        // harga

        // ukuran

        // netto
        $this->netto->CellCssStyle = "white-space: nowrap;";

        // satuan
        $this->satuan->CellCssStyle = "white-space: nowrap;";

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

        // idproduct_acuan
        $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
        if ($curVal != "") {
            $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
            if ($this->idproduct_acuan->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add") ? "idbrand = 1" : "";
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

        // idkemasanbarang
        $curVal = trim(strval($this->idkemasanbarang->CurrentValue));
        if ($curVal != "") {
            $this->idkemasanbarang->ViewValue = $this->idkemasanbarang->lookupCacheOption($curVal);
            if ($this->idkemasanbarang->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idkemasanbarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idkemasanbarang->Lookup->renderViewRow($rswrk[0]);
                    $this->idkemasanbarang->ViewValue = $this->idkemasanbarang->displayValue($arwrk);
                } else {
                    $this->idkemasanbarang->ViewValue = $this->idkemasanbarang->CurrentValue;
                }
            }
        } else {
            $this->idkemasanbarang->ViewValue = null;
        }
        $this->idkemasanbarang->ViewCustomAttributes = "";

        // kemasanbarang
        $this->kemasanbarang->ViewValue = $this->kemasanbarang->CurrentValue;
        $this->kemasanbarang->ViewCustomAttributes = "";

        // harga
        $this->harga->ViewValue = $this->harga->CurrentValue;
        $this->harga->ViewValue = FormatCurrency($this->harga->ViewValue, 2, -2, -2, -2);
        $this->harga->ViewCustomAttributes = "";

        // ukuran
        $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
        $this->ukuran->ViewCustomAttributes = "";

        // netto
        $this->netto->ViewValue = $this->netto->CurrentValue;
        $this->netto->ViewCustomAttributes = "";

        // satuan
        $this->satuan->ViewValue = $this->satuan->CurrentValue;
        $this->satuan->ViewCustomAttributes = "";

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
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
        $this->updated_at->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // idkemasanbarang
        $this->idkemasanbarang->LinkCustomAttributes = "";
        $this->idkemasanbarang->HrefValue = "";
        $this->idkemasanbarang->TooltipValue = "";

        // kemasanbarang
        $this->kemasanbarang->LinkCustomAttributes = "";
        $this->kemasanbarang->HrefValue = "";
        $this->kemasanbarang->TooltipValue = "";

        // harga
        $this->harga->LinkCustomAttributes = "";
        $this->harga->HrefValue = "";
        $this->harga->TooltipValue = "";

        // ukuran
        $this->ukuran->LinkCustomAttributes = "";
        $this->ukuran->HrefValue = "";
        $this->ukuran->TooltipValue = "";

        // netto
        $this->netto->LinkCustomAttributes = "";
        $this->netto->HrefValue = "";
        $this->netto->TooltipValue = "";

        // satuan
        $this->satuan->LinkCustomAttributes = "";
        $this->satuan->HrefValue = "";
        $this->satuan->TooltipValue = "";

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
            $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());
        }

        // kode
        $this->kode->EditAttrs["class"] = "form-control";
        $this->kode->EditCustomAttributes = "";
        if (!$this->kode->Raw) {
            $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
        }
        $this->kode->EditValue = $this->kode->CurrentValue;
        $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

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
        $this->idkategoribarang->PlaceHolder = RemoveHtml($this->idkategoribarang->caption());

        // idjenisbarang
        $this->idjenisbarang->EditAttrs["class"] = "form-control";
        $this->idjenisbarang->EditCustomAttributes = "";
        $this->idjenisbarang->PlaceHolder = RemoveHtml($this->idjenisbarang->caption());

        // idkualitasbarang
        $this->idkualitasbarang->EditAttrs["class"] = "form-control";
        $this->idkualitasbarang->EditCustomAttributes = "";
        $this->idkualitasbarang->PlaceHolder = RemoveHtml($this->idkualitasbarang->caption());

        // idproduct_acuan
        $this->idproduct_acuan->EditAttrs["class"] = "form-control";
        $this->idproduct_acuan->EditCustomAttributes = "";
        $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

        // idkemasanbarang
        $this->idkemasanbarang->EditAttrs["class"] = "form-control";
        $this->idkemasanbarang->EditCustomAttributes = "";
        $this->idkemasanbarang->PlaceHolder = RemoveHtml($this->idkemasanbarang->caption());

        // kemasanbarang
        $this->kemasanbarang->EditAttrs["class"] = "form-control";
        $this->kemasanbarang->EditCustomAttributes = "";
        if (!$this->kemasanbarang->Raw) {
            $this->kemasanbarang->CurrentValue = HtmlDecode($this->kemasanbarang->CurrentValue);
        }
        $this->kemasanbarang->EditValue = $this->kemasanbarang->CurrentValue;
        $this->kemasanbarang->PlaceHolder = RemoveHtml($this->kemasanbarang->caption());

        // harga
        $this->harga->EditAttrs["class"] = "form-control";
        $this->harga->EditCustomAttributes = "";
        $this->harga->EditValue = $this->harga->CurrentValue;
        $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());

        // ukuran
        $this->ukuran->EditAttrs["class"] = "form-control";
        $this->ukuran->EditCustomAttributes = "";
        if (!$this->ukuran->Raw) {
            $this->ukuran->CurrentValue = HtmlDecode($this->ukuran->CurrentValue);
        }
        $this->ukuran->EditValue = $this->ukuran->CurrentValue;
        $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

        // netto
        $this->netto->EditAttrs["class"] = "form-control";
        $this->netto->EditCustomAttributes = "";
        if (!$this->netto->Raw) {
            $this->netto->CurrentValue = HtmlDecode($this->netto->CurrentValue);
        }
        $this->netto->EditValue = $this->netto->CurrentValue;
        $this->netto->PlaceHolder = RemoveHtml($this->netto->caption());

        // satuan
        $this->satuan->EditAttrs["class"] = "form-control";
        $this->satuan->EditCustomAttributes = "";
        if (!$this->satuan->Raw) {
            $this->satuan->CurrentValue = HtmlDecode($this->satuan->CurrentValue);
        }
        $this->satuan->EditValue = $this->satuan->CurrentValue;
        $this->satuan->PlaceHolder = RemoveHtml($this->satuan->caption());

        // bahan
        $this->bahan->EditAttrs["class"] = "form-control";
        $this->bahan->EditCustomAttributes = "";
        if (!$this->bahan->Raw) {
            $this->bahan->CurrentValue = HtmlDecode($this->bahan->CurrentValue);
        }
        $this->bahan->EditValue = $this->bahan->CurrentValue;
        $this->bahan->PlaceHolder = RemoveHtml($this->bahan->caption());

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

        // label
        $this->label->EditAttrs["class"] = "form-control";
        $this->label->EditCustomAttributes = "";
        if (!$this->label->Raw) {
            $this->label->CurrentValue = HtmlDecode($this->label->CurrentValue);
        }
        $this->label->EditValue = $this->label->CurrentValue;
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

        // tambahan
        $this->tambahan->EditAttrs["class"] = "form-control";
        $this->tambahan->EditCustomAttributes = "";
        $this->tambahan->EditValue = $this->tambahan->CurrentValue;
        $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

        // ijinbpom
        $this->ijinbpom->EditCustomAttributes = "";
        $this->ijinbpom->EditValue = $this->ijinbpom->options(false);
        $this->ijinbpom->PlaceHolder = RemoveHtml($this->ijinbpom->caption());

        // aktif
        $this->aktif->EditCustomAttributes = "";
        $this->aktif->EditValue = $this->aktif->options(false);
        $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 8);
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
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->idkategoribarang);
                    $doc->exportCaption($this->idjenisbarang);
                    $doc->exportCaption($this->idkualitasbarang);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->kemasanbarang);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->bahan);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->label);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->ijinbpom);
                    $doc->exportCaption($this->aktif);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idbrand);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->idkategoribarang);
                    $doc->exportCaption($this->idjenisbarang);
                    $doc->exportCaption($this->idkualitasbarang);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->kemasanbarang);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->bahan);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->label);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->ijinbpom);
                    $doc->exportCaption($this->aktif);
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
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->idkategoribarang);
                        $doc->exportField($this->idjenisbarang);
                        $doc->exportField($this->idkualitasbarang);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->kemasanbarang);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->bahan);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->label);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->ijinbpom);
                        $doc->exportField($this->aktif);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idbrand);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->idkategoribarang);
                        $doc->exportField($this->idjenisbarang);
                        $doc->exportField($this->idkualitasbarang);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->kemasanbarang);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->bahan);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->label);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->ijinbpom);
                        $doc->exportField($this->aktif);
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
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'foto') {
            $fldName = "foto";
            $fileNameFld = "foto";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
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
