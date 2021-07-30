<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for customer
 */
class Customer extends DbTable
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
    public $kode;
    public $idtipecustomer;
    public $idpegawai;
    public $nama;
    public $kodenpd;
    public $usaha;
    public $jabatan;
    public $ktp;
    public $npwp;
    public $idprov;
    public $idkab;
    public $idkec;
    public $idkel;
    public $kodepos;
    public $alamat;
    public $telpon;
    public $hp;
    public $_email;
    public $website;
    public $foto;
    public $budget_bonus_persen;
    public $hutang_max;
    public $keterangan;
    public $aktif;
    public $created_at;
    public $updated_at;
    public $created_by;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'customer';
        $this->TableName = 'customer';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`customer`";
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
        $this->id = new DbField('customer', 'customer', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // kode
        $this->kode = new DbField('customer', 'customer', 'x_kode', 'kode', '`kode`', '`kode`', 200, 20, -1, false, '`kode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode->Nullable = false; // NOT NULL field
        $this->kode->Required = true; // Required field
        $this->kode->Sortable = true; // Allow sort
        $this->kode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode->Param, "CustomMsg");
        $this->Fields['kode'] = &$this->kode;

        // idtipecustomer
        $this->idtipecustomer = new DbField('customer', 'customer', 'x_idtipecustomer', 'idtipecustomer', '`idtipecustomer`', '`idtipecustomer`', 3, 11, -1, false, '`idtipecustomer`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idtipecustomer->Nullable = false; // NOT NULL field
        $this->idtipecustomer->Required = true; // Required field
        $this->idtipecustomer->Sortable = true; // Allow sort
        $this->idtipecustomer->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idtipecustomer->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idtipecustomer->Lookup = new Lookup('idtipecustomer', 'tipecustomer', false, 'id', ["tipe","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idtipecustomer->Lookup = new Lookup('idtipecustomer', 'tipecustomer', false, 'id', ["tipe","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idtipecustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idtipecustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idtipecustomer->Param, "CustomMsg");
        $this->Fields['idtipecustomer'] = &$this->idtipecustomer;

        // idpegawai
        $this->idpegawai = new DbField('customer', 'customer', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idpegawai->IsForeignKey = true; // Foreign key field
        $this->idpegawai->Nullable = false; // NOT NULL field
        $this->idpegawai->Required = true; // Required field
        $this->idpegawai->Sortable = true; // Allow sort
        $this->idpegawai->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idpegawai->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idpegawai->Lookup = new Lookup('idpegawai', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idpegawai->Lookup = new Lookup('idpegawai', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idpegawai->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idpegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idpegawai->Param, "CustomMsg");
        $this->Fields['idpegawai'] = &$this->idpegawai;

        // nama
        $this->nama = new DbField('customer', 'customer', 'x_nama', 'nama', '`nama`', '`nama`', 200, 100, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // kodenpd
        $this->kodenpd = new DbField('customer', 'customer', 'x_kodenpd', 'kodenpd', '`kodenpd`', '`kodenpd`', 200, 20, -1, false, '`kodenpd`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodenpd->Sortable = true; // Allow sort
        $this->kodenpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodenpd->Param, "CustomMsg");
        $this->Fields['kodenpd'] = &$this->kodenpd;

        // usaha
        $this->usaha = new DbField('customer', 'customer', 'x_usaha', 'usaha', '`usaha`', '`usaha`', 200, 100, -1, false, '`usaha`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->usaha->Sortable = true; // Allow sort
        $this->usaha->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->usaha->Param, "CustomMsg");
        $this->Fields['usaha'] = &$this->usaha;

        // jabatan
        $this->jabatan = new DbField('customer', 'customer', 'x_jabatan', 'jabatan', '`jabatan`', '`jabatan`', 200, 50, -1, false, '`jabatan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jabatan->Sortable = true; // Allow sort
        $this->jabatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatan->Param, "CustomMsg");
        $this->Fields['jabatan'] = &$this->jabatan;

        // ktp
        $this->ktp = new DbField('customer', 'customer', 'x_ktp', 'ktp', '`ktp`', '`ktp`', 205, 0, -1, true, '`ktp`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->ktp->Sortable = true; // Allow sort
        $this->ktp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ktp->Param, "CustomMsg");
        $this->Fields['ktp'] = &$this->ktp;

        // npwp
        $this->npwp = new DbField('customer', 'customer', 'x_npwp', 'npwp', '`npwp`', '`npwp`', 205, 0, -1, true, '`npwp`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->npwp->Sortable = true; // Allow sort
        $this->npwp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->npwp->Param, "CustomMsg");
        $this->Fields['npwp'] = &$this->npwp;

        // idprov
        $this->idprov = new DbField('customer', 'customer', 'x_idprov', 'idprov', '`idprov`', '`idprov`', 200, 50, -1, false, '`idprov`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idprov->Sortable = true; // Allow sort
        $this->idprov->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idprov->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idprov->Lookup = new Lookup('idprov', 'provinsi', false, 'id', ["name","","",""], [], ["x_idkab"], [], [], [], [], '', '');
                break;
            default:
                $this->idprov->Lookup = new Lookup('idprov', 'provinsi', false, 'id', ["name","","",""], [], ["x_idkab"], [], [], [], [], '', '');
                break;
        }
        $this->idprov->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idprov->Param, "CustomMsg");
        $this->Fields['idprov'] = &$this->idprov;

        // idkab
        $this->idkab = new DbField('customer', 'customer', 'x_idkab', 'idkab', '`idkab`', '`idkab`', 200, 50, -1, false, '`idkab`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkab->Sortable = true; // Allow sort
        $this->idkab->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkab->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkab->Lookup = new Lookup('idkab', 'kabupaten', false, 'id', ["nama","","",""], ["x_idprov"], ["x_idkec"], ["idprovinsi"], ["x_idprovinsi"], [], [], '', '');
                break;
            default:
                $this->idkab->Lookup = new Lookup('idkab', 'kabupaten', false, 'id', ["nama","","",""], ["x_idprov"], ["x_idkec"], ["idprovinsi"], ["x_idprovinsi"], [], [], '', '');
                break;
        }
        $this->idkab->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkab->Param, "CustomMsg");
        $this->Fields['idkab'] = &$this->idkab;

        // idkec
        $this->idkec = new DbField('customer', 'customer', 'x_idkec', 'idkec', '`idkec`', '`idkec`', 200, 50, -1, false, '`idkec`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkec->Sortable = true; // Allow sort
        $this->idkec->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkec->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkec->Lookup = new Lookup('idkec', 'kecamatan', false, 'id', ["nama","","",""], ["x_idkab"], ["x_idkel"], ["idkabupaten"], ["x_idkabupaten"], [], [], '', '');
                break;
            default:
                $this->idkec->Lookup = new Lookup('idkec', 'kecamatan', false, 'id', ["nama","","",""], ["x_idkab"], ["x_idkel"], ["idkabupaten"], ["x_idkabupaten"], [], [], '', '');
                break;
        }
        $this->idkec->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkec->Param, "CustomMsg");
        $this->Fields['idkec'] = &$this->idkec;

        // idkel
        $this->idkel = new DbField('customer', 'customer', 'x_idkel', 'idkel', '`idkel`', '`idkel`', 200, 50, -1, false, '`idkel`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkel->Sortable = true; // Allow sort
        $this->idkel->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkel->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkel->Lookup = new Lookup('idkel', 'kelurahan', false, 'id', ["nama","","",""], ["x_idkec"], [], ["idkecamatan"], ["x_idkecamatan"], [], [], '', '');
                break;
            default:
                $this->idkel->Lookup = new Lookup('idkel', 'kelurahan', false, 'id', ["nama","","",""], ["x_idkec"], [], ["idkecamatan"], ["x_idkecamatan"], [], [], '', '');
                break;
        }
        $this->idkel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkel->Param, "CustomMsg");
        $this->Fields['idkel'] = &$this->idkel;

        // kodepos
        $this->kodepos = new DbField('customer', 'customer', 'x_kodepos', 'kodepos', '`kodepos`', '`kodepos`', 200, 50, -1, false, '`kodepos`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodepos->Sortable = true; // Allow sort
        $this->kodepos->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodepos->Param, "CustomMsg");
        $this->Fields['kodepos'] = &$this->kodepos;

        // alamat
        $this->alamat = new DbField('customer', 'customer', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, 255, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // telpon
        $this->telpon = new DbField('customer', 'customer', 'x_telpon', 'telpon', '`telpon`', '`telpon`', 200, 20, -1, false, '`telpon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->telpon->Sortable = true; // Allow sort
        $this->telpon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->telpon->Param, "CustomMsg");
        $this->Fields['telpon'] = &$this->telpon;

        // hp
        $this->hp = new DbField('customer', 'customer', 'x_hp', 'hp', '`hp`', '`hp`', 200, 20, -1, false, '`hp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hp->Nullable = false; // NOT NULL field
        $this->hp->Required = true; // Required field
        $this->hp->Sortable = true; // Allow sort
        $this->hp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hp->Param, "CustomMsg");
        $this->Fields['hp'] = &$this->hp;

        // email
        $this->_email = new DbField('customer', 'customer', 'x__email', 'email', '`email`', '`email`', 200, 100, -1, false, '`email`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_email->Sortable = true; // Allow sort
        $this->_email->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_email->Param, "CustomMsg");
        $this->Fields['email'] = &$this->_email;

        // website
        $this->website = new DbField('customer', 'customer', 'x_website', 'website', '`website`', '`website`', 200, 100, -1, false, '`website`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->website->Sortable = true; // Allow sort
        $this->website->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->website->Param, "CustomMsg");
        $this->Fields['website'] = &$this->website;

        // foto
        $this->foto = new DbField('customer', 'customer', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, true, '`foto`', false, false, false, 'IMAGE', 'FILE');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->UploadMultiple = true;
        $this->foto->Upload->UploadMultiple = true;
        $this->foto->UploadMaxFileCount = 0;
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // budget_bonus_persen
        $this->budget_bonus_persen = new DbField('customer', 'customer', 'x_budget_bonus_persen', 'budget_bonus_persen', '`budget_bonus_persen`', '`budget_bonus_persen`', 5, 22, -1, false, '`budget_bonus_persen`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->budget_bonus_persen->Sortable = true; // Allow sort
        $this->budget_bonus_persen->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->budget_bonus_persen->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->budget_bonus_persen->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->budget_bonus_persen->Param, "CustomMsg");
        $this->Fields['budget_bonus_persen'] = &$this->budget_bonus_persen;

        // hutang_max
        $this->hutang_max = new DbField('customer', 'customer', 'x_hutang_max', 'hutang_max', '`hutang_max`', '`hutang_max`', 20, 20, -1, false, '`hutang_max`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hutang_max->Sortable = true; // Allow sort
        $this->hutang_max->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->hutang_max->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hutang_max->Param, "CustomMsg");
        $this->Fields['hutang_max'] = &$this->hutang_max;

        // keterangan
        $this->keterangan = new DbField('customer', 'customer', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, 255, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // aktif
        $this->aktif = new DbField('customer', 'customer', 'x_aktif', 'aktif', '`aktif`', '`aktif`', 16, 1, -1, false, '`aktif`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aktif->Nullable = false; // NOT NULL field
        $this->aktif->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aktif->Lookup = new Lookup('aktif', 'customer', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aktif->Lookup = new Lookup('aktif', 'customer', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aktif->OptionCount = 2;
        $this->aktif->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->aktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aktif->Param, "CustomMsg");
        $this->Fields['aktif'] = &$this->aktif;

        // created_at
        $this->created_at = new DbField('customer', 'customer', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('customer', 'customer', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->updated_at->Nullable = false; // NOT NULL field
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;

        // created_by
        $this->created_by = new DbField('customer', 'customer', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_by->Param, "CustomMsg");
        $this->Fields['created_by'] = &$this->created_by;
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
        if ($this->getCurrentMasterTable() == "pegawai") {
            if ($this->idpegawai->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->idpegawai->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "pegawai") {
            if ($this->idpegawai->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`idpegawai`", $this->idpegawai->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_pegawai()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_pegawai()
    {
        return "`idpegawai`=@idpegawai@";
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
        if ($this->getCurrentDetailTable() == "alamat_customer") {
            $detailUrl = Container("alamat_customer")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "brand") {
            $detailUrl = Container("brand")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "CustomerList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`customer`";
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
        $this->DefaultFilter = "`id` > -1";
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
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            if ($this->getCurrentMasterTable() == "pegawai" || $this->getCurrentMasterTable() == "") {
                $filter = $this->addDetailUserIDFilter($filter, "pegawai"); // Add detail User ID filter
            }
        }
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
        $this->kode->DbValue = $row['kode'];
        $this->idtipecustomer->DbValue = $row['idtipecustomer'];
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->nama->DbValue = $row['nama'];
        $this->kodenpd->DbValue = $row['kodenpd'];
        $this->usaha->DbValue = $row['usaha'];
        $this->jabatan->DbValue = $row['jabatan'];
        $this->ktp->Upload->DbValue = $row['ktp'];
        $this->npwp->Upload->DbValue = $row['npwp'];
        $this->idprov->DbValue = $row['idprov'];
        $this->idkab->DbValue = $row['idkab'];
        $this->idkec->DbValue = $row['idkec'];
        $this->idkel->DbValue = $row['idkel'];
        $this->kodepos->DbValue = $row['kodepos'];
        $this->alamat->DbValue = $row['alamat'];
        $this->telpon->DbValue = $row['telpon'];
        $this->hp->DbValue = $row['hp'];
        $this->_email->DbValue = $row['email'];
        $this->website->DbValue = $row['website'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->budget_bonus_persen->DbValue = $row['budget_bonus_persen'];
        $this->hutang_max->DbValue = $row['hutang_max'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->aktif->DbValue = $row['aktif'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
        $this->created_by->DbValue = $row['created_by'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['foto']) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $row['foto']);
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
        return $_SESSION[$name] ?? GetUrl("CustomerList");
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
        if ($pageName == "CustomerView") {
            return $Language->phrase("View");
        } elseif ($pageName == "CustomerEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "CustomerAdd") {
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
                return "CustomerView";
            case Config("API_ADD_ACTION"):
                return "CustomerAdd";
            case Config("API_EDIT_ACTION"):
                return "CustomerEdit";
            case Config("API_DELETE_ACTION"):
                return "CustomerDelete";
            case Config("API_LIST_ACTION"):
                return "CustomerList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "CustomerList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CustomerView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("CustomerView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "CustomerAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "CustomerAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("CustomerEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("CustomerEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("CustomerAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("CustomerAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("CustomerDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "pegawai" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->idpegawai->CurrentValue ?? $this->idpegawai->getSessionValue());
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
        $this->kode->setDbValue($row['kode']);
        $this->idtipecustomer->setDbValue($row['idtipecustomer']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->nama->setDbValue($row['nama']);
        $this->kodenpd->setDbValue($row['kodenpd']);
        $this->usaha->setDbValue($row['usaha']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->ktp->Upload->DbValue = $row['ktp'];
        if (is_resource($this->ktp->Upload->DbValue) && get_resource_type($this->ktp->Upload->DbValue) == "stream") { // Byte array
            $this->ktp->Upload->DbValue = stream_get_contents($this->ktp->Upload->DbValue);
        }
        $this->npwp->Upload->DbValue = $row['npwp'];
        if (is_resource($this->npwp->Upload->DbValue) && get_resource_type($this->npwp->Upload->DbValue) == "stream") { // Byte array
            $this->npwp->Upload->DbValue = stream_get_contents($this->npwp->Upload->DbValue);
        }
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
        $this->budget_bonus_persen->setDbValue($row['budget_bonus_persen']);
        $this->hutang_max->setDbValue($row['hutang_max']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->aktif->setDbValue($row['aktif']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->created_by->setDbValue($row['created_by']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // kode

        // idtipecustomer

        // idpegawai

        // nama

        // kodenpd

        // usaha

        // jabatan

        // ktp

        // npwp

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

        // budget_bonus_persen

        // hutang_max

        // keterangan

        // aktif

        // created_at

        // updated_at

        // created_by

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

        // kodenpd
        $this->kodenpd->ViewValue = $this->kodenpd->CurrentValue;
        $this->kodenpd->ViewCustomAttributes = "";

        // usaha
        $this->usaha->ViewValue = $this->usaha->CurrentValue;
        $this->usaha->ViewCustomAttributes = "";

        // jabatan
        $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
        $this->jabatan->ViewCustomAttributes = "";

        // ktp
        if (!EmptyValue($this->ktp->Upload->DbValue)) {
            $this->ktp->ViewValue = $this->id->CurrentValue;
            $this->ktp->IsBlobImage = IsImageFile(ContentExtension($this->ktp->Upload->DbValue));
            $this->ktp->Upload->FileName = $this->ktp->CurrentValue;
        } else {
            $this->ktp->ViewValue = "";
        }
        $this->ktp->ViewCustomAttributes = "";

        // npwp
        if (!EmptyValue($this->npwp->Upload->DbValue)) {
            $this->npwp->ViewValue = $this->id->CurrentValue;
            $this->npwp->IsBlobImage = IsImageFile(ContentExtension($this->npwp->Upload->DbValue));
            $this->npwp->Upload->FileName = $this->npwp->CurrentValue;
        } else {
            $this->npwp->ViewValue = "";
        }
        $this->npwp->ViewCustomAttributes = "";

        // idprov
        $curVal = trim(strval($this->idprov->CurrentValue));
        if ($curVal != "") {
            $this->idprov->ViewValue = $this->idprov->lookupCacheOption($curVal);
            if ($this->idprov->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
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

        // budget_bonus_persen
        $this->budget_bonus_persen->ViewValue = $this->budget_bonus_persen->CurrentValue;
        $this->budget_bonus_persen->ViewValue = FormatNumber($this->budget_bonus_persen->ViewValue, 2, -2, -2, -2);
        $this->budget_bonus_persen->ViewCustomAttributes = "";

        // hutang_max
        $this->hutang_max->ViewValue = $this->hutang_max->CurrentValue;
        $this->hutang_max->ViewValue = FormatCurrency($this->hutang_max->ViewValue, 2, -2, -2, -2);
        $this->hutang_max->ViewCustomAttributes = "";

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

        // created_by
        $this->created_by->ViewValue = $this->created_by->CurrentValue;
        $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
        $this->created_by->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // kodenpd
        $this->kodenpd->LinkCustomAttributes = "";
        $this->kodenpd->HrefValue = "";
        $this->kodenpd->TooltipValue = "";

        // usaha
        $this->usaha->LinkCustomAttributes = "";
        $this->usaha->HrefValue = "";
        $this->usaha->TooltipValue = "";

        // jabatan
        $this->jabatan->LinkCustomAttributes = "";
        $this->jabatan->HrefValue = "";
        $this->jabatan->TooltipValue = "";

        // ktp
        $this->ktp->LinkCustomAttributes = "";
        if (!empty($this->ktp->Upload->DbValue)) {
            $this->ktp->HrefValue = GetFileUploadUrl($this->ktp, $this->id->CurrentValue);
            $this->ktp->LinkAttrs["target"] = "";
            if ($this->ktp->IsBlobImage && empty($this->ktp->LinkAttrs["target"])) {
                $this->ktp->LinkAttrs["target"] = "_blank";
            }
            if ($this->isExport()) {
                $this->ktp->HrefValue = FullUrl($this->ktp->HrefValue, "href");
            }
        } else {
            $this->ktp->HrefValue = "";
        }
        $this->ktp->ExportHrefValue = GetFileUploadUrl($this->ktp, $this->id->CurrentValue);
        $this->ktp->TooltipValue = "";

        // npwp
        $this->npwp->LinkCustomAttributes = "";
        if (!empty($this->npwp->Upload->DbValue)) {
            $this->npwp->HrefValue = GetFileUploadUrl($this->npwp, $this->id->CurrentValue);
            $this->npwp->LinkAttrs["target"] = "";
            if ($this->npwp->IsBlobImage && empty($this->npwp->LinkAttrs["target"])) {
                $this->npwp->LinkAttrs["target"] = "_blank";
            }
            if ($this->isExport()) {
                $this->npwp->HrefValue = FullUrl($this->npwp->HrefValue, "href");
            }
        } else {
            $this->npwp->HrefValue = "";
        }
        $this->npwp->ExportHrefValue = GetFileUploadUrl($this->npwp, $this->id->CurrentValue);
        $this->npwp->TooltipValue = "";

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

        // budget_bonus_persen
        $this->budget_bonus_persen->LinkCustomAttributes = "";
        $this->budget_bonus_persen->HrefValue = "";
        $this->budget_bonus_persen->TooltipValue = "";

        // hutang_max
        $this->hutang_max->LinkCustomAttributes = "";
        $this->hutang_max->HrefValue = "";
        $this->hutang_max->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

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

        // created_by
        $this->created_by->LinkCustomAttributes = "";
        $this->created_by->HrefValue = "";
        $this->created_by->TooltipValue = "";

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

        // kode
        $this->kode->EditAttrs["class"] = "form-control";
        $this->kode->EditCustomAttributes = "readonly";
        if (!$this->kode->Raw) {
            $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
        }
        $this->kode->EditValue = $this->kode->CurrentValue;
        $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

        // idtipecustomer
        $this->idtipecustomer->EditAttrs["class"] = "form-control";
        $this->idtipecustomer->EditCustomAttributes = "";
        $this->idtipecustomer->PlaceHolder = RemoveHtml($this->idtipecustomer->caption());

        // idpegawai
        $this->idpegawai->EditAttrs["class"] = "form-control";
        $this->idpegawai->EditCustomAttributes = "";
        if ($this->idpegawai->getSessionValue() != "") {
            $this->idpegawai->CurrentValue = GetForeignKeyValue($this->idpegawai->getSessionValue());
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
        } else {
            $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());
        }

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // kodenpd
        $this->kodenpd->EditAttrs["class"] = "form-control";
        $this->kodenpd->EditCustomAttributes = "";
        if (!$this->kodenpd->Raw) {
            $this->kodenpd->CurrentValue = HtmlDecode($this->kodenpd->CurrentValue);
        }
        $this->kodenpd->EditValue = $this->kodenpd->CurrentValue;
        $this->kodenpd->PlaceHolder = RemoveHtml($this->kodenpd->caption());

        // usaha
        $this->usaha->EditAttrs["class"] = "form-control";
        $this->usaha->EditCustomAttributes = "";
        if (!$this->usaha->Raw) {
            $this->usaha->CurrentValue = HtmlDecode($this->usaha->CurrentValue);
        }
        $this->usaha->EditValue = $this->usaha->CurrentValue;
        $this->usaha->PlaceHolder = RemoveHtml($this->usaha->caption());

        // jabatan
        $this->jabatan->EditAttrs["class"] = "form-control";
        $this->jabatan->EditCustomAttributes = "";
        if (!$this->jabatan->Raw) {
            $this->jabatan->CurrentValue = HtmlDecode($this->jabatan->CurrentValue);
        }
        $this->jabatan->EditValue = $this->jabatan->CurrentValue;
        $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

        // ktp
        $this->ktp->EditAttrs["class"] = "form-control";
        $this->ktp->EditCustomAttributes = "";
        if (!EmptyValue($this->ktp->Upload->DbValue)) {
            $this->ktp->EditValue = $this->id->CurrentValue;
            $this->ktp->IsBlobImage = IsImageFile(ContentExtension($this->ktp->Upload->DbValue));
            $this->ktp->Upload->FileName = $this->ktp->CurrentValue;
        } else {
            $this->ktp->EditValue = "";
        }
        if (!EmptyValue($this->ktp->CurrentValue)) {
            $this->ktp->Upload->FileName = $this->ktp->CurrentValue;
        }

        // npwp
        $this->npwp->EditAttrs["class"] = "form-control";
        $this->npwp->EditCustomAttributes = "";
        if (!EmptyValue($this->npwp->Upload->DbValue)) {
            $this->npwp->EditValue = $this->id->CurrentValue;
            $this->npwp->IsBlobImage = IsImageFile(ContentExtension($this->npwp->Upload->DbValue));
            $this->npwp->Upload->FileName = $this->npwp->CurrentValue;
        } else {
            $this->npwp->EditValue = "";
        }
        if (!EmptyValue($this->npwp->CurrentValue)) {
            $this->npwp->Upload->FileName = $this->npwp->CurrentValue;
        }

        // idprov
        $this->idprov->EditAttrs["class"] = "form-control";
        $this->idprov->EditCustomAttributes = "";
        $this->idprov->PlaceHolder = RemoveHtml($this->idprov->caption());

        // idkab
        $this->idkab->EditAttrs["class"] = "form-control";
        $this->idkab->EditCustomAttributes = "";
        $this->idkab->PlaceHolder = RemoveHtml($this->idkab->caption());

        // idkec
        $this->idkec->EditAttrs["class"] = "form-control";
        $this->idkec->EditCustomAttributes = "";
        $this->idkec->PlaceHolder = RemoveHtml($this->idkec->caption());

        // idkel
        $this->idkel->EditAttrs["class"] = "form-control";
        $this->idkel->EditCustomAttributes = "";
        $this->idkel->PlaceHolder = RemoveHtml($this->idkel->caption());

        // kodepos
        $this->kodepos->EditAttrs["class"] = "form-control";
        $this->kodepos->EditCustomAttributes = "";
        if (!$this->kodepos->Raw) {
            $this->kodepos->CurrentValue = HtmlDecode($this->kodepos->CurrentValue);
        }
        $this->kodepos->EditValue = $this->kodepos->CurrentValue;
        $this->kodepos->PlaceHolder = RemoveHtml($this->kodepos->caption());

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        if (!$this->alamat->Raw) {
            $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
        }
        $this->alamat->EditValue = $this->alamat->CurrentValue;
        $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

        // telpon
        $this->telpon->EditAttrs["class"] = "form-control";
        $this->telpon->EditCustomAttributes = "";
        if (!$this->telpon->Raw) {
            $this->telpon->CurrentValue = HtmlDecode($this->telpon->CurrentValue);
        }
        $this->telpon->EditValue = $this->telpon->CurrentValue;
        $this->telpon->PlaceHolder = RemoveHtml($this->telpon->caption());

        // hp
        $this->hp->EditAttrs["class"] = "form-control";
        $this->hp->EditCustomAttributes = "";
        if (!$this->hp->Raw) {
            $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
        }
        $this->hp->EditValue = $this->hp->CurrentValue;
        $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

        // email
        $this->_email->EditAttrs["class"] = "form-control";
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // website
        $this->website->EditAttrs["class"] = "form-control";
        $this->website->EditCustomAttributes = "";
        if (!$this->website->Raw) {
            $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
        }
        $this->website->EditValue = $this->website->CurrentValue;
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

        // budget_bonus_persen
        $this->budget_bonus_persen->EditAttrs["class"] = "form-control";
        $this->budget_bonus_persen->EditCustomAttributes = "";
        $this->budget_bonus_persen->EditValue = $this->budget_bonus_persen->CurrentValue;
        $this->budget_bonus_persen->PlaceHolder = RemoveHtml($this->budget_bonus_persen->caption());
        if (strval($this->budget_bonus_persen->EditValue) != "" && is_numeric($this->budget_bonus_persen->EditValue)) {
            $this->budget_bonus_persen->EditValue = FormatNumber($this->budget_bonus_persen->EditValue, -2, -2, -2, -2);
        }

        // hutang_max
        $this->hutang_max->EditAttrs["class"] = "form-control";
        $this->hutang_max->EditCustomAttributes = "";
        $this->hutang_max->EditValue = $this->hutang_max->CurrentValue;
        $this->hutang_max->PlaceHolder = RemoveHtml($this->hutang_max->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // aktif
        $this->aktif->EditCustomAttributes = "";
        $this->aktif->EditValue = $this->aktif->options(false);
        $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->CurrentValue = FormatDateTime($this->created_at->CurrentValue, 8);

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->CurrentValue = FormatDateTime($this->updated_at->CurrentValue, 8);

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";

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
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->idtipecustomer);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->kodenpd);
                    $doc->exportCaption($this->usaha);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->ktp);
                    $doc->exportCaption($this->npwp);
                    $doc->exportCaption($this->idprov);
                    $doc->exportCaption($this->idkab);
                    $doc->exportCaption($this->idkec);
                    $doc->exportCaption($this->idkel);
                    $doc->exportCaption($this->kodepos);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->telpon);
                    $doc->exportCaption($this->hp);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->website);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->budget_bonus_persen);
                    $doc->exportCaption($this->hutang_max);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->aktif);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->idtipecustomer);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->kodenpd);
                    $doc->exportCaption($this->usaha);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->ktp);
                    $doc->exportCaption($this->npwp);
                    $doc->exportCaption($this->idprov);
                    $doc->exportCaption($this->idkab);
                    $doc->exportCaption($this->idkec);
                    $doc->exportCaption($this->idkel);
                    $doc->exportCaption($this->kodepos);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->telpon);
                    $doc->exportCaption($this->hp);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->website);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->budget_bonus_persen);
                    $doc->exportCaption($this->hutang_max);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->aktif);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->created_by);
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
                        $doc->exportField($this->kode);
                        $doc->exportField($this->idtipecustomer);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->kodenpd);
                        $doc->exportField($this->usaha);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->ktp);
                        $doc->exportField($this->npwp);
                        $doc->exportField($this->idprov);
                        $doc->exportField($this->idkab);
                        $doc->exportField($this->idkec);
                        $doc->exportField($this->idkel);
                        $doc->exportField($this->kodepos);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->telpon);
                        $doc->exportField($this->hp);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->website);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->budget_bonus_persen);
                        $doc->exportField($this->hutang_max);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->aktif);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->idtipecustomer);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->kodenpd);
                        $doc->exportField($this->usaha);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->ktp);
                        $doc->exportField($this->npwp);
                        $doc->exportField($this->idprov);
                        $doc->exportField($this->idkab);
                        $doc->exportField($this->idkec);
                        $doc->exportField($this->idkel);
                        $doc->exportField($this->kodepos);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->telpon);
                        $doc->exportField($this->hp);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->website);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->budget_bonus_persen);
                        $doc->exportField($this->hutang_max);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->aktif);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->created_by);
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

    // Add master User ID filter
    public function addMasterUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "pegawai") {
            $filterWrk = Container("pegawai")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "pegawai") {
            $mastertable = Container("pegawai");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->idpegawai, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        return $filterWrk;
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
        if ($fldparm == 'ktp') {
            $fldName = "ktp";
            $fileNameFld = "ktp";
        } elseif ($fldparm == 'npwp') {
            $fldName = "npwp";
            $fileNameFld = "npwp";
        } elseif ($fldparm == 'foto') {
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
        $rsnew['kode'] = getNextKode('customer', 0);
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
        $new_idcustomer = $rsnew['id'];
        Execute("INSERT INTO brand_link (idcustomer, idcustomer_brand) VALUES ({$new_idcustomer}, -1)");
        Execute("INSERT INTO approval_po (idcustomer, jumlah_limit) VALUES ({$new_idcustomer}, 3)");    
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
