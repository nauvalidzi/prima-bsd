<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_confirmsample
 */
class NpdConfirmsample extends DbTable
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
    public $idnpd;
    public $tglkonfirmasi;
    public $idnpd_sample;
    public $nama;
    public $bentuk;
    public $viskositas;
    public $warna;
    public $bauparfum;
    public $aplikasisediaan;
    public $volume;
    public $campaign;
    public $alasansetuju;
    public $foto;
    public $namapemesan;
    public $alamatpemesan;
    public $personincharge;
    public $jabatan;
    public $notelp;
    public $created_at;
    public $receipt_by;
    public $readonly;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'npd_confirmsample';
        $this->TableName = 'npd_confirmsample';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_confirmsample`";
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
        $this->id = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 20, 20, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd->IsForeignKey = true; // Foreign key field
        $this->idnpd->Nullable = false; // NOT NULL field
        $this->idnpd->Required = true; // Required field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idnpd->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","tanggal_order","",""], [], ["x_idnpd_sample"], [], [], [], [], '', '');
                break;
            default:
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","tanggal_order","",""], [], ["x_idnpd_sample"], [], [], [], [], '', '');
                break;
        }
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // tglkonfirmasi
        $this->tglkonfirmasi = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_tglkonfirmasi', 'tglkonfirmasi', '`tglkonfirmasi`', CastDateFieldForLike("`tglkonfirmasi`", 0, "DB"), 135, 19, 0, false, '`tglkonfirmasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglkonfirmasi->Nullable = false; // NOT NULL field
        $this->tglkonfirmasi->Required = true; // Required field
        $this->tglkonfirmasi->Sortable = true; // Allow sort
        $this->tglkonfirmasi->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglkonfirmasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglkonfirmasi->Param, "CustomMsg");
        $this->Fields['tglkonfirmasi'] = &$this->tglkonfirmasi;

        // idnpd_sample
        $this->idnpd_sample = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_idnpd_sample', 'idnpd_sample', '`idnpd_sample`', '`idnpd_sample`', 20, 20, -1, false, '`idnpd_sample`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd_sample->Nullable = false; // NOT NULL field
        $this->idnpd_sample->Required = true; // Required field
        $this->idnpd_sample->Sortable = true; // Allow sort
        $this->idnpd_sample->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idnpd_sample->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idnpd_sample->Lookup = new Lookup('idnpd_sample', 'npd_sample', false, 'id', ["kode","nama","",""], ["x_idnpd"], [], ["idnpd"], ["x_idnpd"], [], [], '', '');
                break;
            default:
                $this->idnpd_sample->Lookup = new Lookup('idnpd_sample', 'npd_sample', false, 'id', ["kode","nama","",""], ["x_idnpd"], [], ["idnpd"], ["x_idnpd"], [], [], '', '');
                break;
        }
        $this->idnpd_sample->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd_sample->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd_sample->Param, "CustomMsg");
        $this->Fields['idnpd_sample'] = &$this->idnpd_sample;

        // nama
        $this->nama = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_nama', 'nama', '`nama`', '`nama`', 200, 50, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // bentuk
        $this->bentuk = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_bentuk', 'bentuk', '`bentuk`', '`bentuk`', 200, 255, -1, false, '`bentuk`', false, false, false, 'FORMATTED TEXT', 'RADIO');
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
        $this->viskositas = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_viskositas', 'viskositas', '`viskositas`', '`viskositas`', 200, 50, -1, false, '`viskositas`', false, false, false, 'FORMATTED TEXT', 'RADIO');
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
        $this->warna = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_warna', 'warna', '`warna`', '`warna`', 200, 50, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'RADIO');
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

        // bauparfum
        $this->bauparfum = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_bauparfum', 'bauparfum', '`bauparfum`', '`bauparfum`', 200, 50, -1, false, '`bauparfum`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->bauparfum->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->bauparfum->Lookup = new Lookup('bauparfum', 'npd_parfum_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->bauparfum->Lookup = new Lookup('bauparfum', 'npd_parfum_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->bauparfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bauparfum->Param, "CustomMsg");
        $this->Fields['bauparfum'] = &$this->bauparfum;

        // aplikasisediaan
        $this->aplikasisediaan = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_aplikasisediaan', 'aplikasisediaan', '`aplikasisediaan`', '`aplikasisediaan`', 200, 50, -1, false, '`aplikasisediaan`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aplikasisediaan->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasisediaan->Lookup = new Lookup('aplikasisediaan', 'npd_aplikasi_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasisediaan->Lookup = new Lookup('aplikasisediaan', 'npd_aplikasi_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasisediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasisediaan->Param, "CustomMsg");
        $this->Fields['aplikasisediaan'] = &$this->aplikasisediaan;

        // volume
        $this->volume = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_volume', 'volume', '`volume`', '`volume`', 200, 50, -1, false, '`volume`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->volume->Sortable = true; // Allow sort
        $this->volume->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->volume->Param, "CustomMsg");
        $this->Fields['volume'] = &$this->volume;

        // campaign
        $this->campaign = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_campaign', 'campaign', '`campaign`', '`campaign`', 200, 50, -1, false, '`campaign`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->campaign->Sortable = true; // Allow sort
        $this->campaign->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->campaign->Param, "CustomMsg");
        $this->Fields['campaign'] = &$this->campaign;

        // alasansetuju
        $this->alasansetuju = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_alasansetuju', 'alasansetuju', '`alasansetuju`', '`alasansetuju`', 201, 65535, -1, false, '`alasansetuju`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->alasansetuju->Sortable = true; // Allow sort
        $this->alasansetuju->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alasansetuju->Param, "CustomMsg");
        $this->Fields['alasansetuju'] = &$this->alasansetuju;

        // foto
        $this->foto = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, true, '`foto`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // namapemesan
        $this->namapemesan = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_namapemesan', 'namapemesan', '`namapemesan`', '`namapemesan`', 200, 50, -1, false, '`namapemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namapemesan->Nullable = false; // NOT NULL field
        $this->namapemesan->Required = true; // Required field
        $this->namapemesan->Sortable = true; // Allow sort
        $this->namapemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namapemesan->Param, "CustomMsg");
        $this->Fields['namapemesan'] = &$this->namapemesan;

        // alamatpemesan
        $this->alamatpemesan = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_alamatpemesan', 'alamatpemesan', '`alamatpemesan`', '`alamatpemesan`', 201, 65535, -1, false, '`alamatpemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamatpemesan->Sortable = true; // Allow sort
        $this->alamatpemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamatpemesan->Param, "CustomMsg");
        $this->Fields['alamatpemesan'] = &$this->alamatpemesan;

        // personincharge
        $this->personincharge = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_personincharge', 'personincharge', '`personincharge`', '`personincharge`', 200, 50, -1, false, '`personincharge`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->personincharge->Sortable = true; // Allow sort
        $this->personincharge->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->personincharge->Param, "CustomMsg");
        $this->Fields['personincharge'] = &$this->personincharge;

        // jabatan
        $this->jabatan = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_jabatan', 'jabatan', '`jabatan`', '`jabatan`', 200, 50, -1, false, '`jabatan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jabatan->Sortable = true; // Allow sort
        $this->jabatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatan->Param, "CustomMsg");
        $this->Fields['jabatan'] = &$this->jabatan;

        // notelp
        $this->notelp = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_notelp', 'notelp', '`notelp`', '`notelp`', 200, 16, -1, false, '`notelp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->notelp->Sortable = true; // Allow sort
        $this->notelp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->notelp->Param, "CustomMsg");
        $this->Fields['notelp'] = &$this->notelp;

        // created_at
        $this->created_at = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // receipt_by
        $this->receipt_by = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_receipt_by', 'receipt_by', '`receipt_by`', '`receipt_by`', 3, 11, -1, false, '`receipt_by`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->receipt_by->Sortable = true; // Allow sort
        $this->receipt_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->receipt_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->receipt_by->Lookup = new Lookup('receipt_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->receipt_by->Lookup = new Lookup('receipt_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->receipt_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->receipt_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->receipt_by->Param, "CustomMsg");
        $this->Fields['receipt_by'] = &$this->receipt_by;

        // readonly
        $this->readonly = new DbField('npd_confirmsample', 'npd_confirmsample', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->readonly->Lookup = new Lookup('readonly', 'npd_confirmsample', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->readonly->Lookup = new Lookup('readonly', 'npd_confirmsample', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->readonly->OptionCount = 2;
        $this->readonly->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->readonly->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->readonly->Param, "CustomMsg");
        $this->Fields['readonly'] = &$this->readonly;
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
        if ($this->getCurrentMasterTable() == "npd") {
            if ($this->idnpd->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->idnpd->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "npd") {
            if ($this->idnpd->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`idnpd`", $this->idnpd->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_npd()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_npd()
    {
        return "`idnpd`=@idnpd@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_confirmsample`";
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
        $this->idnpd->DbValue = $row['idnpd'];
        $this->tglkonfirmasi->DbValue = $row['tglkonfirmasi'];
        $this->idnpd_sample->DbValue = $row['idnpd_sample'];
        $this->nama->DbValue = $row['nama'];
        $this->bentuk->DbValue = $row['bentuk'];
        $this->viskositas->DbValue = $row['viskositas'];
        $this->warna->DbValue = $row['warna'];
        $this->bauparfum->DbValue = $row['bauparfum'];
        $this->aplikasisediaan->DbValue = $row['aplikasisediaan'];
        $this->volume->DbValue = $row['volume'];
        $this->campaign->DbValue = $row['campaign'];
        $this->alasansetuju->DbValue = $row['alasansetuju'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->namapemesan->DbValue = $row['namapemesan'];
        $this->alamatpemesan->DbValue = $row['alamatpemesan'];
        $this->personincharge->DbValue = $row['personincharge'];
        $this->jabatan->DbValue = $row['jabatan'];
        $this->notelp->DbValue = $row['notelp'];
        $this->created_at->DbValue = $row['created_at'];
        $this->receipt_by->DbValue = $row['receipt_by'];
        $this->readonly->DbValue = $row['readonly'];
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
        return $_SESSION[$name] ?? GetUrl("NpdConfirmsampleList");
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
        if ($pageName == "NpdConfirmsampleView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdConfirmsampleEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdConfirmsampleAdd") {
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
                return "NpdConfirmsampleView";
            case Config("API_ADD_ACTION"):
                return "NpdConfirmsampleAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdConfirmsampleEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdConfirmsampleDelete";
            case Config("API_LIST_ACTION"):
                return "NpdConfirmsampleList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdConfirmsampleList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdConfirmsampleView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdConfirmsampleView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdConfirmsampleAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdConfirmsampleAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdConfirmsampleEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdConfirmsampleAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdConfirmsampleDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "npd" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->idnpd->CurrentValue ?? $this->idnpd->getSessionValue());
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->tglkonfirmasi->setDbValue($row['tglkonfirmasi']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->nama->setDbValue($row['nama']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->bauparfum->setDbValue($row['bauparfum']);
        $this->aplikasisediaan->setDbValue($row['aplikasisediaan']);
        $this->volume->setDbValue($row['volume']);
        $this->campaign->setDbValue($row['campaign']);
        $this->alasansetuju->setDbValue($row['alasansetuju']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->namapemesan->setDbValue($row['namapemesan']);
        $this->alamatpemesan->setDbValue($row['alamatpemesan']);
        $this->personincharge->setDbValue($row['personincharge']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->notelp->setDbValue($row['notelp']);
        $this->created_at->setDbValue($row['created_at']);
        $this->receipt_by->setDbValue($row['receipt_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // idnpd

        // tglkonfirmasi

        // idnpd_sample

        // nama

        // bentuk

        // viskositas

        // warna

        // bauparfum

        // aplikasisediaan

        // volume

        // campaign

        // alasansetuju

        // foto

        // namapemesan

        // alamatpemesan

        // personincharge

        // jabatan

        // notelp

        // created_at

        // receipt_by

        // readonly

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idnpd
        $curVal = trim(strval($this->idnpd->CurrentValue));
        if ($curVal != "") {
            $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
            if ($this->idnpd->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                    $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                } else {
                    $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                }
            }
        } else {
            $this->idnpd->ViewValue = null;
        }
        $this->idnpd->ViewCustomAttributes = "";

        // tglkonfirmasi
        $this->tglkonfirmasi->ViewValue = $this->tglkonfirmasi->CurrentValue;
        $this->tglkonfirmasi->ViewValue = FormatDateTime($this->tglkonfirmasi->ViewValue, 0);
        $this->tglkonfirmasi->ViewCustomAttributes = "";

        // idnpd_sample
        $curVal = trim(strval($this->idnpd_sample->CurrentValue));
        if ($curVal != "") {
            $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_review WHERE `status`=1 AND readonly=0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idnpd_sample->Lookup->renderViewRow($rswrk[0]);
                    $this->idnpd_sample->ViewValue = $this->idnpd_sample->displayValue($arwrk);
                } else {
                    $this->idnpd_sample->ViewValue = $this->idnpd_sample->CurrentValue;
                }
            }
        } else {
            $this->idnpd_sample->ViewValue = null;
        }
        $this->idnpd_sample->ViewCustomAttributes = "";

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

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

        // bauparfum
        $curVal = trim(strval($this->bauparfum->CurrentValue));
        if ($curVal != "") {
            $this->bauparfum->ViewValue = $this->bauparfum->lookupCacheOption($curVal);
            if ($this->bauparfum->ViewValue === null) { // Lookup from database
                $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->bauparfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->bauparfum->Lookup->renderViewRow($rswrk[0]);
                    $this->bauparfum->ViewValue = $this->bauparfum->displayValue($arwrk);
                } else {
                    $this->bauparfum->ViewValue = $this->bauparfum->CurrentValue;
                }
            }
        } else {
            $this->bauparfum->ViewValue = null;
        }
        $this->bauparfum->ViewCustomAttributes = "";

        // aplikasisediaan
        $curVal = trim(strval($this->aplikasisediaan->CurrentValue));
        if ($curVal != "") {
            $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->lookupCacheOption($curVal);
            if ($this->aplikasisediaan->ViewValue === null) { // Lookup from database
                $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->aplikasisediaan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->aplikasisediaan->Lookup->renderViewRow($rswrk[0]);
                    $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->displayValue($arwrk);
                } else {
                    $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->CurrentValue;
                }
            }
        } else {
            $this->aplikasisediaan->ViewValue = null;
        }
        $this->aplikasisediaan->ViewCustomAttributes = "";

        // volume
        $this->volume->ViewValue = $this->volume->CurrentValue;
        $this->volume->ViewCustomAttributes = "";

        // campaign
        $this->campaign->ViewValue = $this->campaign->CurrentValue;
        $this->campaign->ViewCustomAttributes = "";

        // alasansetuju
        $this->alasansetuju->ViewValue = $this->alasansetuju->CurrentValue;
        $this->alasansetuju->ViewCustomAttributes = "";

        // foto
        if (!EmptyValue($this->foto->Upload->DbValue)) {
            $this->foto->ViewValue = $this->foto->Upload->DbValue;
        } else {
            $this->foto->ViewValue = "";
        }
        $this->foto->ViewCustomAttributes = "";

        // namapemesan
        $this->namapemesan->ViewValue = $this->namapemesan->CurrentValue;
        $this->namapemesan->ViewCustomAttributes = "";

        // alamatpemesan
        $this->alamatpemesan->ViewValue = $this->alamatpemesan->CurrentValue;
        $this->alamatpemesan->ViewCustomAttributes = "";

        // personincharge
        $this->personincharge->ViewValue = $this->personincharge->CurrentValue;
        $this->personincharge->ViewCustomAttributes = "";

        // jabatan
        $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
        $this->jabatan->ViewCustomAttributes = "";

        // notelp
        $this->notelp->ViewValue = $this->notelp->CurrentValue;
        $this->notelp->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // receipt_by
        $curVal = trim(strval($this->receipt_by->CurrentValue));
        if ($curVal != "") {
            $this->receipt_by->ViewValue = $this->receipt_by->lookupCacheOption($curVal);
            if ($this->receipt_by->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->receipt_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->receipt_by->Lookup->renderViewRow($rswrk[0]);
                    $this->receipt_by->ViewValue = $this->receipt_by->displayValue($arwrk);
                } else {
                    $this->receipt_by->ViewValue = $this->receipt_by->CurrentValue;
                }
            }
        } else {
            $this->receipt_by->ViewValue = null;
        }
        $this->receipt_by->ViewCustomAttributes = "";

        // readonly
        if (strval($this->readonly->CurrentValue) != "") {
            $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
        } else {
            $this->readonly->ViewValue = null;
        }
        $this->readonly->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idnpd
        $this->idnpd->LinkCustomAttributes = "";
        $this->idnpd->HrefValue = "";
        $this->idnpd->TooltipValue = "";

        // tglkonfirmasi
        $this->tglkonfirmasi->LinkCustomAttributes = "";
        $this->tglkonfirmasi->HrefValue = "";
        $this->tglkonfirmasi->TooltipValue = "";

        // idnpd_sample
        $this->idnpd_sample->LinkCustomAttributes = "";
        $this->idnpd_sample->HrefValue = "";
        $this->idnpd_sample->TooltipValue = "";

        // nama
        $this->nama->LinkCustomAttributes = "";
        $this->nama->HrefValue = "";
        $this->nama->TooltipValue = "";

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

        // bauparfum
        $this->bauparfum->LinkCustomAttributes = "";
        $this->bauparfum->HrefValue = "";
        $this->bauparfum->TooltipValue = "";

        // aplikasisediaan
        $this->aplikasisediaan->LinkCustomAttributes = "";
        $this->aplikasisediaan->HrefValue = "";
        $this->aplikasisediaan->TooltipValue = "";

        // volume
        $this->volume->LinkCustomAttributes = "";
        $this->volume->HrefValue = "";
        $this->volume->TooltipValue = "";

        // campaign
        $this->campaign->LinkCustomAttributes = "";
        $this->campaign->HrefValue = "";
        $this->campaign->TooltipValue = "";

        // alasansetuju
        $this->alasansetuju->LinkCustomAttributes = "";
        $this->alasansetuju->HrefValue = "";
        $this->alasansetuju->TooltipValue = "";

        // foto
        $this->foto->LinkCustomAttributes = "";
        $this->foto->HrefValue = "";
        $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
        $this->foto->TooltipValue = "";

        // namapemesan
        $this->namapemesan->LinkCustomAttributes = "";
        $this->namapemesan->HrefValue = "";
        $this->namapemesan->TooltipValue = "";

        // alamatpemesan
        $this->alamatpemesan->LinkCustomAttributes = "";
        $this->alamatpemesan->HrefValue = "";
        $this->alamatpemesan->TooltipValue = "";

        // personincharge
        $this->personincharge->LinkCustomAttributes = "";
        $this->personincharge->HrefValue = "";
        $this->personincharge->TooltipValue = "";

        // jabatan
        $this->jabatan->LinkCustomAttributes = "";
        $this->jabatan->HrefValue = "";
        $this->jabatan->TooltipValue = "";

        // notelp
        $this->notelp->LinkCustomAttributes = "";
        $this->notelp->HrefValue = "";
        $this->notelp->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // receipt_by
        $this->receipt_by->LinkCustomAttributes = "";
        $this->receipt_by->HrefValue = "";
        $this->receipt_by->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

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

        // idnpd
        $this->idnpd->EditAttrs["class"] = "form-control";
        $this->idnpd->EditCustomAttributes = "";
        $curVal = trim(strval($this->idnpd->CurrentValue));
        if ($curVal != "") {
            $this->idnpd->EditValue = $this->idnpd->lookupCacheOption($curVal);
            if ($this->idnpd->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                    $this->idnpd->EditValue = $this->idnpd->displayValue($arwrk);
                } else {
                    $this->idnpd->EditValue = $this->idnpd->CurrentValue;
                }
            }
        } else {
            $this->idnpd->EditValue = null;
        }
        $this->idnpd->ViewCustomAttributes = "";

        // tglkonfirmasi
        $this->tglkonfirmasi->EditAttrs["class"] = "form-control";
        $this->tglkonfirmasi->EditCustomAttributes = "";
        $this->tglkonfirmasi->EditValue = FormatDateTime($this->tglkonfirmasi->CurrentValue, 8);
        $this->tglkonfirmasi->PlaceHolder = RemoveHtml($this->tglkonfirmasi->caption());

        // idnpd_sample
        $this->idnpd_sample->EditAttrs["class"] = "form-control";
        $this->idnpd_sample->EditCustomAttributes = "";
        $curVal = trim(strval($this->idnpd_sample->CurrentValue));
        if ($curVal != "") {
            $this->idnpd_sample->EditValue = $this->idnpd_sample->lookupCacheOption($curVal);
            if ($this->idnpd_sample->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_review WHERE `status`=1 AND readonly=0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idnpd_sample->Lookup->renderViewRow($rswrk[0]);
                    $this->idnpd_sample->EditValue = $this->idnpd_sample->displayValue($arwrk);
                } else {
                    $this->idnpd_sample->EditValue = $this->idnpd_sample->CurrentValue;
                }
            }
        } else {
            $this->idnpd_sample->EditValue = null;
        }
        $this->idnpd_sample->ViewCustomAttributes = "";

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // bentuk
        $this->bentuk->EditCustomAttributes = "";
        $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

        // viskositas
        $this->viskositas->EditCustomAttributes = "";
        $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

        // warna
        $this->warna->EditCustomAttributes = "";
        $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

        // bauparfum
        $this->bauparfum->EditCustomAttributes = "";
        $this->bauparfum->PlaceHolder = RemoveHtml($this->bauparfum->caption());

        // aplikasisediaan
        $this->aplikasisediaan->EditCustomAttributes = "";
        $this->aplikasisediaan->PlaceHolder = RemoveHtml($this->aplikasisediaan->caption());

        // volume
        $this->volume->EditAttrs["class"] = "form-control";
        $this->volume->EditCustomAttributes = "";
        if (!$this->volume->Raw) {
            $this->volume->CurrentValue = HtmlDecode($this->volume->CurrentValue);
        }
        $this->volume->EditValue = $this->volume->CurrentValue;
        $this->volume->PlaceHolder = RemoveHtml($this->volume->caption());

        // campaign
        $this->campaign->EditAttrs["class"] = "form-control";
        $this->campaign->EditCustomAttributes = "";
        if (!$this->campaign->Raw) {
            $this->campaign->CurrentValue = HtmlDecode($this->campaign->CurrentValue);
        }
        $this->campaign->EditValue = $this->campaign->CurrentValue;
        $this->campaign->PlaceHolder = RemoveHtml($this->campaign->caption());

        // alasansetuju
        $this->alasansetuju->EditAttrs["class"] = "form-control";
        $this->alasansetuju->EditCustomAttributes = "";
        $this->alasansetuju->EditValue = $this->alasansetuju->CurrentValue;
        $this->alasansetuju->PlaceHolder = RemoveHtml($this->alasansetuju->caption());

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

        // namapemesan
        $this->namapemesan->EditAttrs["class"] = "form-control";
        $this->namapemesan->EditCustomAttributes = "";
        if (!$this->namapemesan->Raw) {
            $this->namapemesan->CurrentValue = HtmlDecode($this->namapemesan->CurrentValue);
        }
        $this->namapemesan->EditValue = $this->namapemesan->CurrentValue;
        $this->namapemesan->PlaceHolder = RemoveHtml($this->namapemesan->caption());

        // alamatpemesan
        $this->alamatpemesan->EditAttrs["class"] = "form-control";
        $this->alamatpemesan->EditCustomAttributes = "";
        if (!$this->alamatpemesan->Raw) {
            $this->alamatpemesan->CurrentValue = HtmlDecode($this->alamatpemesan->CurrentValue);
        }
        $this->alamatpemesan->EditValue = $this->alamatpemesan->CurrentValue;
        $this->alamatpemesan->PlaceHolder = RemoveHtml($this->alamatpemesan->caption());

        // personincharge
        $this->personincharge->EditAttrs["class"] = "form-control";
        $this->personincharge->EditCustomAttributes = "";
        if (!$this->personincharge->Raw) {
            $this->personincharge->CurrentValue = HtmlDecode($this->personincharge->CurrentValue);
        }
        $this->personincharge->EditValue = $this->personincharge->CurrentValue;
        $this->personincharge->PlaceHolder = RemoveHtml($this->personincharge->caption());

        // jabatan
        $this->jabatan->EditAttrs["class"] = "form-control";
        $this->jabatan->EditCustomAttributes = "";
        if (!$this->jabatan->Raw) {
            $this->jabatan->CurrentValue = HtmlDecode($this->jabatan->CurrentValue);
        }
        $this->jabatan->EditValue = $this->jabatan->CurrentValue;
        $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

        // notelp
        $this->notelp->EditAttrs["class"] = "form-control";
        $this->notelp->EditCustomAttributes = "";
        if (!$this->notelp->Raw) {
            $this->notelp->CurrentValue = HtmlDecode($this->notelp->CurrentValue);
        }
        $this->notelp->EditValue = $this->notelp->CurrentValue;
        $this->notelp->PlaceHolder = RemoveHtml($this->notelp->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // receipt_by
        $this->receipt_by->EditAttrs["class"] = "form-control";
        $this->receipt_by->EditCustomAttributes = "";
        $this->receipt_by->PlaceHolder = RemoveHtml($this->receipt_by->caption());

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

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
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->tglkonfirmasi);
                    $doc->exportCaption($this->idnpd_sample);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->bauparfum);
                    $doc->exportCaption($this->aplikasisediaan);
                    $doc->exportCaption($this->volume);
                    $doc->exportCaption($this->campaign);
                    $doc->exportCaption($this->alasansetuju);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->namapemesan);
                    $doc->exportCaption($this->alamatpemesan);
                    $doc->exportCaption($this->personincharge);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->notelp);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->tglkonfirmasi);
                    $doc->exportCaption($this->idnpd_sample);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->bauparfum);
                    $doc->exportCaption($this->aplikasisediaan);
                    $doc->exportCaption($this->volume);
                    $doc->exportCaption($this->campaign);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->namapemesan);
                    $doc->exportCaption($this->alamatpemesan);
                    $doc->exportCaption($this->personincharge);
                    $doc->exportCaption($this->jabatan);
                    $doc->exportCaption($this->notelp);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->receipt_by);
                    $doc->exportCaption($this->readonly);
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
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->tglkonfirmasi);
                        $doc->exportField($this->idnpd_sample);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->bauparfum);
                        $doc->exportField($this->aplikasisediaan);
                        $doc->exportField($this->volume);
                        $doc->exportField($this->campaign);
                        $doc->exportField($this->alasansetuju);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->namapemesan);
                        $doc->exportField($this->alamatpemesan);
                        $doc->exportField($this->personincharge);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->notelp);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->tglkonfirmasi);
                        $doc->exportField($this->idnpd_sample);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->bauparfum);
                        $doc->exportField($this->aplikasisediaan);
                        $doc->exportField($this->volume);
                        $doc->exportField($this->campaign);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->namapemesan);
                        $doc->exportField($this->alamatpemesan);
                        $doc->exportField($this->personincharge);
                        $doc->exportField($this->jabatan);
                        $doc->exportField($this->notelp);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->receipt_by);
                        $doc->exportField($this->readonly);
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
        ExecuteUpdate("UPDATE npd_review SET readonly=1 WHERE idnpd_sample=".$rsnew['idnpd_sample']);
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
        //updateStatus("npd", $rsnew['idnpd']);
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        $rsnew['idnpd'] = $rsold['idnpd'];
        $rsnew['idnpd_sample'] = $rsold['idnpd_sample'];
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
        //updateStatus("npd", $rsold['idnpd']);
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
        ExecuteUpdate("UPDATE npd_review SET readonly=0 WHERE idnpd_sample=".$rs['idnpd_sample']);
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
        //updateStatus("npd", $rs['idnpd']);
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
