<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for ijinhaki
 */
class Ijinhaki extends DbTable
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
    public $tglterima;
    public $tglsubmit;
    public $ktp;
    public $npwp;
    public $nib;
    public $akta_pendirian;
    public $sk_umk;
    public $ttd_pemohon;
    public $nama_brand;
    public $label_brand;
    public $deskripsi_brand;
    public $unsur_brand;
    public $submitted_by;
    public $checked1_by;
    public $checked2_by;
    public $approved_by;
    public $status;
    public $selesai;
    public $created_at;
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
        $this->TableVar = 'ijinhaki';
        $this->TableName = 'ijinhaki';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`ijinhaki`";
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
        $this->id = new DbField('ijinhaki', 'ijinhaki', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('ijinhaki', 'ijinhaki', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 20, 20, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd->Nullable = false; // NOT NULL field
        $this->idnpd->Required = true; // Required field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idnpd->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // tglterima
        $this->tglterima = new DbField('ijinhaki', 'ijinhaki', 'x_tglterima', 'tglterima', '`tglterima`', CastDateFieldForLike("`tglterima`", 0, "DB"), 133, 10, 0, false, '`tglterima`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglterima->Sortable = true; // Allow sort
        $this->tglterima->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglterima->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglterima->Param, "CustomMsg");
        $this->Fields['tglterima'] = &$this->tglterima;

        // tglsubmit
        $this->tglsubmit = new DbField('ijinhaki', 'ijinhaki', 'x_tglsubmit', 'tglsubmit', '`tglsubmit`', CastDateFieldForLike("`tglsubmit`", 0, "DB"), 133, 10, 0, false, '`tglsubmit`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglsubmit->Sortable = true; // Allow sort
        $this->tglsubmit->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglsubmit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglsubmit->Param, "CustomMsg");
        $this->Fields['tglsubmit'] = &$this->tglsubmit;

        // ktp
        $this->ktp = new DbField('ijinhaki', 'ijinhaki', 'x_ktp', 'ktp', '`ktp`', '`ktp`', 200, 50, -1, false, '`ktp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ktp->Sortable = true; // Allow sort
        $this->ktp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ktp->Param, "CustomMsg");
        $this->Fields['ktp'] = &$this->ktp;

        // npwp
        $this->npwp = new DbField('ijinhaki', 'ijinhaki', 'x_npwp', 'npwp', '`npwp`', '`npwp`', 200, 50, -1, false, '`npwp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->npwp->Sortable = true; // Allow sort
        $this->npwp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->npwp->Param, "CustomMsg");
        $this->Fields['npwp'] = &$this->npwp;

        // nib
        $this->nib = new DbField('ijinhaki', 'ijinhaki', 'x_nib', 'nib', '`nib`', '`nib`', 200, 50, -1, false, '`nib`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nib->Sortable = true; // Allow sort
        $this->nib->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nib->Param, "CustomMsg");
        $this->Fields['nib'] = &$this->nib;

        // akta_pendirian
        $this->akta_pendirian = new DbField('ijinhaki', 'ijinhaki', 'x_akta_pendirian', 'akta_pendirian', '`akta_pendirian`', '`akta_pendirian`', 200, 50, -1, true, '`akta_pendirian`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->akta_pendirian->Sortable = true; // Allow sort
        $this->akta_pendirian->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->akta_pendirian->Param, "CustomMsg");
        $this->Fields['akta_pendirian'] = &$this->akta_pendirian;

        // sk_umk
        $this->sk_umk = new DbField('ijinhaki', 'ijinhaki', 'x_sk_umk', 'sk_umk', '`sk_umk`', '`sk_umk`', 200, 50, -1, false, '`sk_umk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sk_umk->Sortable = true; // Allow sort
        $this->sk_umk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sk_umk->Param, "CustomMsg");
        $this->Fields['sk_umk'] = &$this->sk_umk;

        // ttd_pemohon
        $this->ttd_pemohon = new DbField('ijinhaki', 'ijinhaki', 'x_ttd_pemohon', 'ttd_pemohon', '`ttd_pemohon`', '`ttd_pemohon`', 200, 255, -1, true, '`ttd_pemohon`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->ttd_pemohon->Sortable = true; // Allow sort
        $this->ttd_pemohon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ttd_pemohon->Param, "CustomMsg");
        $this->Fields['ttd_pemohon'] = &$this->ttd_pemohon;

        // nama_brand
        $this->nama_brand = new DbField('ijinhaki', 'ijinhaki', 'x_nama_brand', 'nama_brand', '`nama_brand`', '`nama_brand`', 200, 255, -1, false, '`nama_brand`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_brand->Nullable = false; // NOT NULL field
        $this->nama_brand->Required = true; // Required field
        $this->nama_brand->Sortable = true; // Allow sort
        $this->nama_brand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_brand->Param, "CustomMsg");
        $this->Fields['nama_brand'] = &$this->nama_brand;

        // label_brand
        $this->label_brand = new DbField('ijinhaki', 'ijinhaki', 'x_label_brand', 'label_brand', '`label_brand`', '`label_brand`', 201, 65535, -1, true, '`label_brand`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->label_brand->Sortable = true; // Allow sort
        $this->label_brand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label_brand->Param, "CustomMsg");
        $this->Fields['label_brand'] = &$this->label_brand;

        // deskripsi_brand
        $this->deskripsi_brand = new DbField('ijinhaki', 'ijinhaki', 'x_deskripsi_brand', 'deskripsi_brand', '`deskripsi_brand`', '`deskripsi_brand`', 201, 65535, -1, false, '`deskripsi_brand`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->deskripsi_brand->Sortable = true; // Allow sort
        $this->deskripsi_brand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->deskripsi_brand->Param, "CustomMsg");
        $this->Fields['deskripsi_brand'] = &$this->deskripsi_brand;

        // unsur_brand
        $this->unsur_brand = new DbField('ijinhaki', 'ijinhaki', 'x_unsur_brand', 'unsur_brand', '`unsur_brand`', '`unsur_brand`', 200, 255, -1, false, '`unsur_brand`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->unsur_brand->Sortable = true; // Allow sort
        $this->unsur_brand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->unsur_brand->Param, "CustomMsg");
        $this->Fields['unsur_brand'] = &$this->unsur_brand;

        // submitted_by
        $this->submitted_by = new DbField('ijinhaki', 'ijinhaki', 'x_submitted_by', 'submitted_by', '`submitted_by`', '`submitted_by`', 3, 11, -1, false, '`submitted_by`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->submitted_by->Sortable = true; // Allow sort
        $this->submitted_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->submitted_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->submitted_by->Lookup = new Lookup('submitted_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->submitted_by->Lookup = new Lookup('submitted_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->submitted_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->submitted_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->submitted_by->Param, "CustomMsg");
        $this->Fields['submitted_by'] = &$this->submitted_by;

        // checked1_by
        $this->checked1_by = new DbField('ijinhaki', 'ijinhaki', 'x_checked1_by', 'checked1_by', '`checked1_by`', '`checked1_by`', 3, 11, -1, false, '`checked1_by`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->checked1_by->Sortable = true; // Allow sort
        $this->checked1_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->checked1_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->checked1_by->Lookup = new Lookup('checked1_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->checked1_by->Lookup = new Lookup('checked1_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->checked1_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->checked1_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->checked1_by->Param, "CustomMsg");
        $this->Fields['checked1_by'] = &$this->checked1_by;

        // checked2_by
        $this->checked2_by = new DbField('ijinhaki', 'ijinhaki', 'x_checked2_by', 'checked2_by', '`checked2_by`', '`checked2_by`', 3, 11, -1, false, '`checked2_by`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->checked2_by->Sortable = true; // Allow sort
        $this->checked2_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->checked2_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->checked2_by->Lookup = new Lookup('checked2_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->checked2_by->Lookup = new Lookup('checked2_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->checked2_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->checked2_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->checked2_by->Param, "CustomMsg");
        $this->Fields['checked2_by'] = &$this->checked2_by;

        // approved_by
        $this->approved_by = new DbField('ijinhaki', 'ijinhaki', 'x_approved_by', 'approved_by', '`approved_by`', '`approved_by`', 3, 11, -1, false, '`approved_by`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->approved_by->Sortable = true; // Allow sort
        $this->approved_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->approved_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->approved_by->Lookup = new Lookup('approved_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->approved_by->Lookup = new Lookup('approved_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->approved_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->approved_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->approved_by->Param, "CustomMsg");
        $this->Fields['approved_by'] = &$this->approved_by;

        // status
        $this->status = new DbField('ijinhaki', 'ijinhaki', 'x_status', 'status', '`status`', '`status`', 200, 50, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        $this->status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->status->Lookup = new Lookup('status', 'ijinhaki', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'ijinhaki', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->status->OptionCount = 3;
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // selesai
        $this->selesai = new DbField('ijinhaki', 'ijinhaki', 'x_selesai', 'selesai', '`selesai`', '`selesai`', 16, 1, -1, false, '`selesai`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->selesai->Nullable = false; // NOT NULL field
        $this->selesai->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->selesai->Lookup = new Lookup('selesai', 'ijinhaki', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->selesai->Lookup = new Lookup('selesai', 'ijinhaki', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->selesai->OptionCount = 2;
        $this->selesai->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->selesai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->selesai->Param, "CustomMsg");
        $this->Fields['selesai'] = &$this->selesai;

        // created_at
        $this->created_at = new DbField('ijinhaki', 'ijinhaki', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // readonly
        $this->readonly = new DbField('ijinhaki', 'ijinhaki', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = true; // Allow sort
        $this->readonly->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->readonly->Lookup = new Lookup('readonly', 'ijinhaki', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->readonly->Lookup = new Lookup('readonly', 'ijinhaki', false, '', ["","","",""], [], [], [], [], [], [], '', '');
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
        if ($this->getCurrentDetailTable() == "ijinhaki_status") {
            $detailUrl = Container("ijinhaki_status")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "IjinhakiList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`ijinhaki`";
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
        // Cascade Update detail table 'ijinhaki_status'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'idijinhaki'
            $cascadeUpdate = true;
            $rscascade['idijinhaki'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("ijinhaki_status")->loadRs("`idijinhaki` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("ijinhaki_status")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("ijinhaki_status")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("ijinhaki_status")->rowUpdated($rsdtlold, $rsdtlnew);
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

        // Cascade delete detail table 'ijinhaki_status'
        $dtlrows = Container("ijinhaki_status")->loadRs("`idijinhaki` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("ijinhaki_status")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("ijinhaki_status")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("ijinhaki_status")->rowDeleted($dtlrow);
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
        $this->idnpd->DbValue = $row['idnpd'];
        $this->tglterima->DbValue = $row['tglterima'];
        $this->tglsubmit->DbValue = $row['tglsubmit'];
        $this->ktp->DbValue = $row['ktp'];
        $this->npwp->DbValue = $row['npwp'];
        $this->nib->DbValue = $row['nib'];
        $this->akta_pendirian->Upload->DbValue = $row['akta_pendirian'];
        $this->sk_umk->DbValue = $row['sk_umk'];
        $this->ttd_pemohon->Upload->DbValue = $row['ttd_pemohon'];
        $this->nama_brand->DbValue = $row['nama_brand'];
        $this->label_brand->Upload->DbValue = $row['label_brand'];
        $this->deskripsi_brand->DbValue = $row['deskripsi_brand'];
        $this->unsur_brand->DbValue = $row['unsur_brand'];
        $this->submitted_by->DbValue = $row['submitted_by'];
        $this->checked1_by->DbValue = $row['checked1_by'];
        $this->checked2_by->DbValue = $row['checked2_by'];
        $this->approved_by->DbValue = $row['approved_by'];
        $this->status->DbValue = $row['status'];
        $this->selesai->DbValue = $row['selesai'];
        $this->created_at->DbValue = $row['created_at'];
        $this->readonly->DbValue = $row['readonly'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['akta_pendirian']) ? [] : [$row['akta_pendirian']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->akta_pendirian->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->akta_pendirian->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['ttd_pemohon']) ? [] : [$row['ttd_pemohon']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->ttd_pemohon->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->ttd_pemohon->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['label_brand']) ? [] : [$row['label_brand']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->label_brand->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->label_brand->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("IjinhakiList");
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
        if ($pageName == "IjinhakiView") {
            return $Language->phrase("View");
        } elseif ($pageName == "IjinhakiEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "IjinhakiAdd") {
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
                return "IjinhakiView";
            case Config("API_ADD_ACTION"):
                return "IjinhakiAdd";
            case Config("API_EDIT_ACTION"):
                return "IjinhakiEdit";
            case Config("API_DELETE_ACTION"):
                return "IjinhakiDelete";
            case Config("API_LIST_ACTION"):
                return "IjinhakiList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "IjinhakiList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("IjinhakiView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("IjinhakiView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "IjinhakiAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "IjinhakiAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("IjinhakiEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("IjinhakiEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("IjinhakiAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("IjinhakiAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("IjinhakiDelete", $this->getUrlParm());
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->tglterima->setDbValue($row['tglterima']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->ktp->setDbValue($row['ktp']);
        $this->npwp->setDbValue($row['npwp']);
        $this->nib->setDbValue($row['nib']);
        $this->akta_pendirian->Upload->DbValue = $row['akta_pendirian'];
        $this->akta_pendirian->setDbValue($this->akta_pendirian->Upload->DbValue);
        $this->sk_umk->setDbValue($row['sk_umk']);
        $this->ttd_pemohon->Upload->DbValue = $row['ttd_pemohon'];
        $this->ttd_pemohon->setDbValue($this->ttd_pemohon->Upload->DbValue);
        $this->nama_brand->setDbValue($row['nama_brand']);
        $this->label_brand->Upload->DbValue = $row['label_brand'];
        $this->label_brand->setDbValue($this->label_brand->Upload->DbValue);
        $this->deskripsi_brand->setDbValue($row['deskripsi_brand']);
        $this->unsur_brand->setDbValue($row['unsur_brand']);
        $this->submitted_by->setDbValue($row['submitted_by']);
        $this->checked1_by->setDbValue($row['checked1_by']);
        $this->checked2_by->setDbValue($row['checked2_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->status->setDbValue($row['status']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
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

        // tglterima

        // tglsubmit

        // ktp

        // npwp

        // nib

        // akta_pendirian

        // sk_umk

        // ttd_pemohon

        // nama_brand

        // label_brand

        // deskripsi_brand

        // unsur_brand

        // submitted_by

        // checked1_by

        // checked2_by

        // approved_by

        // status

        // selesai

        // created_at

        // readonly

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
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

        // tglterima
        $this->tglterima->ViewValue = $this->tglterima->CurrentValue;
        $this->tglterima->ViewValue = FormatDateTime($this->tglterima->ViewValue, 0);
        $this->tglterima->ViewCustomAttributes = "";

        // tglsubmit
        $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
        $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
        $this->tglsubmit->ViewCustomAttributes = "";

        // ktp
        $this->ktp->ViewValue = $this->ktp->CurrentValue;
        $this->ktp->ViewCustomAttributes = "";

        // npwp
        $this->npwp->ViewValue = $this->npwp->CurrentValue;
        $this->npwp->ViewCustomAttributes = "";

        // nib
        $this->nib->ViewValue = $this->nib->CurrentValue;
        $this->nib->ViewCustomAttributes = "";

        // akta_pendirian
        if (!EmptyValue($this->akta_pendirian->Upload->DbValue)) {
            $this->akta_pendirian->ViewValue = $this->akta_pendirian->Upload->DbValue;
        } else {
            $this->akta_pendirian->ViewValue = "";
        }
        $this->akta_pendirian->ViewCustomAttributes = "";

        // sk_umk
        $this->sk_umk->ViewValue = $this->sk_umk->CurrentValue;
        $this->sk_umk->ViewCustomAttributes = "";

        // ttd_pemohon
        if (!EmptyValue($this->ttd_pemohon->Upload->DbValue)) {
            $this->ttd_pemohon->ViewValue = $this->ttd_pemohon->Upload->DbValue;
        } else {
            $this->ttd_pemohon->ViewValue = "";
        }
        $this->ttd_pemohon->ViewCustomAttributes = "";

        // nama_brand
        $this->nama_brand->ViewValue = $this->nama_brand->CurrentValue;
        $this->nama_brand->ViewCustomAttributes = "";

        // label_brand
        if (!EmptyValue($this->label_brand->Upload->DbValue)) {
            $this->label_brand->ViewValue = $this->label_brand->Upload->DbValue;
        } else {
            $this->label_brand->ViewValue = "";
        }
        $this->label_brand->ViewCustomAttributes = "";

        // deskripsi_brand
        $this->deskripsi_brand->ViewValue = $this->deskripsi_brand->CurrentValue;
        $this->deskripsi_brand->ViewCustomAttributes = "";

        // unsur_brand
        $this->unsur_brand->ViewValue = $this->unsur_brand->CurrentValue;
        $this->unsur_brand->ViewCustomAttributes = "";

        // submitted_by
        $curVal = trim(strval($this->submitted_by->CurrentValue));
        if ($curVal != "") {
            $this->submitted_by->ViewValue = $this->submitted_by->lookupCacheOption($curVal);
            if ($this->submitted_by->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->submitted_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->submitted_by->Lookup->renderViewRow($rswrk[0]);
                    $this->submitted_by->ViewValue = $this->submitted_by->displayValue($arwrk);
                } else {
                    $this->submitted_by->ViewValue = $this->submitted_by->CurrentValue;
                }
            }
        } else {
            $this->submitted_by->ViewValue = null;
        }
        $this->submitted_by->ViewCustomAttributes = "";

        // checked1_by
        $curVal = trim(strval($this->checked1_by->CurrentValue));
        if ($curVal != "") {
            $this->checked1_by->ViewValue = $this->checked1_by->lookupCacheOption($curVal);
            if ($this->checked1_by->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->checked1_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->checked1_by->Lookup->renderViewRow($rswrk[0]);
                    $this->checked1_by->ViewValue = $this->checked1_by->displayValue($arwrk);
                } else {
                    $this->checked1_by->ViewValue = $this->checked1_by->CurrentValue;
                }
            }
        } else {
            $this->checked1_by->ViewValue = null;
        }
        $this->checked1_by->ViewCustomAttributes = "";

        // checked2_by
        $curVal = trim(strval($this->checked2_by->CurrentValue));
        if ($curVal != "") {
            $this->checked2_by->ViewValue = $this->checked2_by->lookupCacheOption($curVal);
            if ($this->checked2_by->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->checked2_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->checked2_by->Lookup->renderViewRow($rswrk[0]);
                    $this->checked2_by->ViewValue = $this->checked2_by->displayValue($arwrk);
                } else {
                    $this->checked2_by->ViewValue = $this->checked2_by->CurrentValue;
                }
            }
        } else {
            $this->checked2_by->ViewValue = null;
        }
        $this->checked2_by->ViewCustomAttributes = "";

        // approved_by
        $curVal = trim(strval($this->approved_by->CurrentValue));
        if ($curVal != "") {
            $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
            if ($this->approved_by->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->approved_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->approved_by->Lookup->renderViewRow($rswrk[0]);
                    $this->approved_by->ViewValue = $this->approved_by->displayValue($arwrk);
                } else {
                    $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
                }
            }
        } else {
            $this->approved_by->ViewValue = null;
        }
        $this->approved_by->ViewCustomAttributes = "";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // selesai
        if (strval($this->selesai->CurrentValue) != "") {
            $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
        } else {
            $this->selesai->ViewValue = null;
        }
        $this->selesai->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // readonly
        if (ConvertToBool($this->readonly->CurrentValue)) {
            $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
        } else {
            $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
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

        // tglterima
        $this->tglterima->LinkCustomAttributes = "";
        $this->tglterima->HrefValue = "";
        $this->tglterima->TooltipValue = "";

        // tglsubmit
        $this->tglsubmit->LinkCustomAttributes = "";
        $this->tglsubmit->HrefValue = "";
        $this->tglsubmit->TooltipValue = "";

        // ktp
        $this->ktp->LinkCustomAttributes = "";
        $this->ktp->HrefValue = "";
        $this->ktp->TooltipValue = "";

        // npwp
        $this->npwp->LinkCustomAttributes = "";
        $this->npwp->HrefValue = "";
        $this->npwp->TooltipValue = "";

        // nib
        $this->nib->LinkCustomAttributes = "";
        $this->nib->HrefValue = "";
        $this->nib->TooltipValue = "";

        // akta_pendirian
        $this->akta_pendirian->LinkCustomAttributes = "";
        $this->akta_pendirian->HrefValue = "";
        $this->akta_pendirian->ExportHrefValue = $this->akta_pendirian->UploadPath . $this->akta_pendirian->Upload->DbValue;
        $this->akta_pendirian->TooltipValue = "";

        // sk_umk
        $this->sk_umk->LinkCustomAttributes = "";
        $this->sk_umk->HrefValue = "";
        $this->sk_umk->TooltipValue = "";

        // ttd_pemohon
        $this->ttd_pemohon->LinkCustomAttributes = "";
        $this->ttd_pemohon->HrefValue = "";
        $this->ttd_pemohon->ExportHrefValue = $this->ttd_pemohon->UploadPath . $this->ttd_pemohon->Upload->DbValue;
        $this->ttd_pemohon->TooltipValue = "";

        // nama_brand
        $this->nama_brand->LinkCustomAttributes = "";
        $this->nama_brand->HrefValue = "";
        $this->nama_brand->TooltipValue = "";

        // label_brand
        $this->label_brand->LinkCustomAttributes = "";
        $this->label_brand->HrefValue = "";
        $this->label_brand->ExportHrefValue = $this->label_brand->UploadPath . $this->label_brand->Upload->DbValue;
        $this->label_brand->TooltipValue = "";

        // deskripsi_brand
        $this->deskripsi_brand->LinkCustomAttributes = "";
        $this->deskripsi_brand->HrefValue = "";
        $this->deskripsi_brand->TooltipValue = "";

        // unsur_brand
        $this->unsur_brand->LinkCustomAttributes = "";
        $this->unsur_brand->HrefValue = "";
        $this->unsur_brand->TooltipValue = "";

        // submitted_by
        $this->submitted_by->LinkCustomAttributes = "";
        $this->submitted_by->HrefValue = "";
        $this->submitted_by->TooltipValue = "";

        // checked1_by
        $this->checked1_by->LinkCustomAttributes = "";
        $this->checked1_by->HrefValue = "";
        $this->checked1_by->TooltipValue = "";

        // checked2_by
        $this->checked2_by->LinkCustomAttributes = "";
        $this->checked2_by->HrefValue = "";
        $this->checked2_by->TooltipValue = "";

        // approved_by
        $this->approved_by->LinkCustomAttributes = "";
        $this->approved_by->HrefValue = "";
        $this->approved_by->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // selesai
        $this->selesai->LinkCustomAttributes = "";
        $this->selesai->HrefValue = "";
        $this->selesai->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

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
        $this->id->EditValue = FormatNumber($this->id->EditValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // idnpd
        $this->idnpd->EditAttrs["class"] = "form-control";
        $this->idnpd->EditCustomAttributes = "";
        $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());

        // tglterima
        $this->tglterima->EditAttrs["class"] = "form-control";
        $this->tglterima->EditCustomAttributes = "";
        $this->tglterima->EditValue = FormatDateTime($this->tglterima->CurrentValue, 8);
        $this->tglterima->PlaceHolder = RemoveHtml($this->tglterima->caption());

        // tglsubmit
        $this->tglsubmit->EditAttrs["class"] = "form-control";
        $this->tglsubmit->EditCustomAttributes = "";
        $this->tglsubmit->EditValue = FormatDateTime($this->tglsubmit->CurrentValue, 8);
        $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

        // ktp
        $this->ktp->EditAttrs["class"] = "form-control";
        $this->ktp->EditCustomAttributes = "";
        if (!$this->ktp->Raw) {
            $this->ktp->CurrentValue = HtmlDecode($this->ktp->CurrentValue);
        }
        $this->ktp->EditValue = $this->ktp->CurrentValue;
        $this->ktp->PlaceHolder = RemoveHtml($this->ktp->caption());

        // npwp
        $this->npwp->EditAttrs["class"] = "form-control";
        $this->npwp->EditCustomAttributes = "";
        if (!$this->npwp->Raw) {
            $this->npwp->CurrentValue = HtmlDecode($this->npwp->CurrentValue);
        }
        $this->npwp->EditValue = $this->npwp->CurrentValue;
        $this->npwp->PlaceHolder = RemoveHtml($this->npwp->caption());

        // nib
        $this->nib->EditAttrs["class"] = "form-control";
        $this->nib->EditCustomAttributes = "";
        if (!$this->nib->Raw) {
            $this->nib->CurrentValue = HtmlDecode($this->nib->CurrentValue);
        }
        $this->nib->EditValue = $this->nib->CurrentValue;
        $this->nib->PlaceHolder = RemoveHtml($this->nib->caption());

        // akta_pendirian
        $this->akta_pendirian->EditAttrs["class"] = "form-control";
        $this->akta_pendirian->EditCustomAttributes = "";
        if (!EmptyValue($this->akta_pendirian->Upload->DbValue)) {
            $this->akta_pendirian->EditValue = $this->akta_pendirian->Upload->DbValue;
        } else {
            $this->akta_pendirian->EditValue = "";
        }
        if (!EmptyValue($this->akta_pendirian->CurrentValue)) {
            $this->akta_pendirian->Upload->FileName = $this->akta_pendirian->CurrentValue;
        }

        // sk_umk
        $this->sk_umk->EditAttrs["class"] = "form-control";
        $this->sk_umk->EditCustomAttributes = "";
        if (!$this->sk_umk->Raw) {
            $this->sk_umk->CurrentValue = HtmlDecode($this->sk_umk->CurrentValue);
        }
        $this->sk_umk->EditValue = $this->sk_umk->CurrentValue;
        $this->sk_umk->PlaceHolder = RemoveHtml($this->sk_umk->caption());

        // ttd_pemohon
        $this->ttd_pemohon->EditAttrs["class"] = "form-control";
        $this->ttd_pemohon->EditCustomAttributes = "";
        if (!EmptyValue($this->ttd_pemohon->Upload->DbValue)) {
            $this->ttd_pemohon->EditValue = $this->ttd_pemohon->Upload->DbValue;
        } else {
            $this->ttd_pemohon->EditValue = "";
        }
        if (!EmptyValue($this->ttd_pemohon->CurrentValue)) {
            $this->ttd_pemohon->Upload->FileName = $this->ttd_pemohon->CurrentValue;
        }

        // nama_brand
        $this->nama_brand->EditAttrs["class"] = "form-control";
        $this->nama_brand->EditCustomAttributes = "";
        if (!$this->nama_brand->Raw) {
            $this->nama_brand->CurrentValue = HtmlDecode($this->nama_brand->CurrentValue);
        }
        $this->nama_brand->EditValue = $this->nama_brand->CurrentValue;
        $this->nama_brand->PlaceHolder = RemoveHtml($this->nama_brand->caption());

        // label_brand
        $this->label_brand->EditAttrs["class"] = "form-control";
        $this->label_brand->EditCustomAttributes = "";
        if (!EmptyValue($this->label_brand->Upload->DbValue)) {
            $this->label_brand->EditValue = $this->label_brand->Upload->DbValue;
        } else {
            $this->label_brand->EditValue = "";
        }
        if (!EmptyValue($this->label_brand->CurrentValue)) {
            $this->label_brand->Upload->FileName = $this->label_brand->CurrentValue;
        }

        // deskripsi_brand
        $this->deskripsi_brand->EditAttrs["class"] = "form-control";
        $this->deskripsi_brand->EditCustomAttributes = "";
        $this->deskripsi_brand->EditValue = $this->deskripsi_brand->CurrentValue;
        $this->deskripsi_brand->PlaceHolder = RemoveHtml($this->deskripsi_brand->caption());

        // unsur_brand
        $this->unsur_brand->EditAttrs["class"] = "form-control";
        $this->unsur_brand->EditCustomAttributes = "";
        if (!$this->unsur_brand->Raw) {
            $this->unsur_brand->CurrentValue = HtmlDecode($this->unsur_brand->CurrentValue);
        }
        $this->unsur_brand->EditValue = $this->unsur_brand->CurrentValue;
        $this->unsur_brand->PlaceHolder = RemoveHtml($this->unsur_brand->caption());

        // submitted_by
        $this->submitted_by->EditAttrs["class"] = "form-control";
        $this->submitted_by->EditCustomAttributes = "";
        $this->submitted_by->PlaceHolder = RemoveHtml($this->submitted_by->caption());

        // checked1_by
        $this->checked1_by->EditAttrs["class"] = "form-control";
        $this->checked1_by->EditCustomAttributes = "";
        $this->checked1_by->PlaceHolder = RemoveHtml($this->checked1_by->caption());

        // checked2_by
        $this->checked2_by->EditAttrs["class"] = "form-control";
        $this->checked2_by->EditCustomAttributes = "";
        $this->checked2_by->PlaceHolder = RemoveHtml($this->checked2_by->caption());

        // approved_by
        $this->approved_by->EditAttrs["class"] = "form-control";
        $this->approved_by->EditCustomAttributes = "";
        $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(true);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // selesai
        $this->selesai->EditCustomAttributes = "";
        $this->selesai->EditValue = $this->selesai->options(false);
        $this->selesai->PlaceHolder = RemoveHtml($this->selesai->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

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
                    $doc->exportCaption($this->tglterima);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->ktp);
                    $doc->exportCaption($this->npwp);
                    $doc->exportCaption($this->nib);
                    $doc->exportCaption($this->akta_pendirian);
                    $doc->exportCaption($this->sk_umk);
                    $doc->exportCaption($this->ttd_pemohon);
                    $doc->exportCaption($this->nama_brand);
                    $doc->exportCaption($this->label_brand);
                    $doc->exportCaption($this->deskripsi_brand);
                    $doc->exportCaption($this->unsur_brand);
                    $doc->exportCaption($this->submitted_by);
                    $doc->exportCaption($this->checked1_by);
                    $doc->exportCaption($this->checked2_by);
                    $doc->exportCaption($this->approved_by);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->selesai);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->tglterima);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->ktp);
                    $doc->exportCaption($this->npwp);
                    $doc->exportCaption($this->nib);
                    $doc->exportCaption($this->akta_pendirian);
                    $doc->exportCaption($this->sk_umk);
                    $doc->exportCaption($this->ttd_pemohon);
                    $doc->exportCaption($this->nama_brand);
                    $doc->exportCaption($this->unsur_brand);
                    $doc->exportCaption($this->submitted_by);
                    $doc->exportCaption($this->checked1_by);
                    $doc->exportCaption($this->checked2_by);
                    $doc->exportCaption($this->approved_by);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->selesai);
                    $doc->exportCaption($this->created_at);
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
                        $doc->exportField($this->tglterima);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->ktp);
                        $doc->exportField($this->npwp);
                        $doc->exportField($this->nib);
                        $doc->exportField($this->akta_pendirian);
                        $doc->exportField($this->sk_umk);
                        $doc->exportField($this->ttd_pemohon);
                        $doc->exportField($this->nama_brand);
                        $doc->exportField($this->label_brand);
                        $doc->exportField($this->deskripsi_brand);
                        $doc->exportField($this->unsur_brand);
                        $doc->exportField($this->submitted_by);
                        $doc->exportField($this->checked1_by);
                        $doc->exportField($this->checked2_by);
                        $doc->exportField($this->approved_by);
                        $doc->exportField($this->status);
                        $doc->exportField($this->selesai);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->tglterima);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->ktp);
                        $doc->exportField($this->npwp);
                        $doc->exportField($this->nib);
                        $doc->exportField($this->akta_pendirian);
                        $doc->exportField($this->sk_umk);
                        $doc->exportField($this->ttd_pemohon);
                        $doc->exportField($this->nama_brand);
                        $doc->exportField($this->unsur_brand);
                        $doc->exportField($this->submitted_by);
                        $doc->exportField($this->checked1_by);
                        $doc->exportField($this->checked2_by);
                        $doc->exportField($this->approved_by);
                        $doc->exportField($this->status);
                        $doc->exportField($this->selesai);
                        $doc->exportField($this->created_at);
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
        if ($fldparm == 'akta_pendirian') {
            $fldName = "akta_pendirian";
            $fileNameFld = "akta_pendirian";
        } elseif ($fldparm == 'ttd_pemohon') {
            $fldName = "ttd_pemohon";
            $fileNameFld = "ttd_pemohon";
        } elseif ($fldparm == 'label_brand') {
            $fldName = "label_brand";
            $fileNameFld = "label_brand";
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
        $myResult = ExecuteUpdate("UPDATE brand SET ijinhaki=-1 WHERE id=".$rsnew['idbrand']);
        $rsnew['created_at'] = date('Y-m-d H:i:s');
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
        $idbrand = $rsold['idbrand'];
        $myResult = ExecuteUpdate("UPDATE brand SET ijinhaki=".($rsnew['selesai'] == 1 ? 1 : -1)." WHERE id=".$idbrand);
        if ($rsnew['selesai']) {
        	$rsnew['status'] = "Selesai";
        	$myResult = ExecuteUpdate("UPDATE ijinhaki SET readonly=1 WHERE id=".$rsold['id']);
        } else {
        	updateStatus("ijinhaki", $rsold['id']);
        }
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
        	$this->setFailureMessage("Ijin HKI yang sudah selesai tidak bisa dihapus");
        	return false;
        }
        $myResult = ExecuteUpdate("UPDATE brand SET ijinhaki=0 WHERE id=".$rs['idbrand']);
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
