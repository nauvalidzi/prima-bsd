<?php

namespace PHPMaker2021\production2;

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
    public $idnpd;
    public $idpegawai;
    public $idcustomer;
    public $kodeorder;
    public $kategoriproduk;
    public $jenisproduk;
    public $idproduct_acuan;
    public $kualitasproduk;
    public $bahan_campaign;
    public $warna;
    public $parfum;
    public $tambahan;
    public $status;
    public $created_at;
    public $readonly;
    public $nama_pemesan;
    public $alamat_pemesan;
    public $jabatan_pemesan;
    public $hp_pemesan;
    public $kodeproduk;
    public $namaproduk;
    public $kode_pemesan;

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

        // idnpd
        $this->idnpd = new DbField('v_npd_customer', 'v_npd_customer', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 20, 20, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->idnpd->IsAutoIncrement = true; // Autoincrement field
        $this->idnpd->IsPrimaryKey = true; // Primary key field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // idpegawai
        $this->idpegawai = new DbField('v_npd_customer', 'v_npd_customer', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idpegawai->Sortable = true; // Allow sort
        $this->idpegawai->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idpegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idpegawai->Param, "CustomMsg");
        $this->Fields['idpegawai'] = &$this->idpegawai;

        // idcustomer
        $this->idcustomer = new DbField('v_npd_customer', 'v_npd_customer', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 20, 20, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // kodeorder
        $this->kodeorder = new DbField('v_npd_customer', 'v_npd_customer', 'x_kodeorder', 'kodeorder', '`kodeorder`', '`kodeorder`', 200, 50, -1, false, '`kodeorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeorder->Sortable = true; // Allow sort
        $this->kodeorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeorder->Param, "CustomMsg");
        $this->Fields['kodeorder'] = &$this->kodeorder;

        // kategoriproduk
        $this->kategoriproduk = new DbField('v_npd_customer', 'v_npd_customer', 'x_kategoriproduk', 'kategoriproduk', '`kategoriproduk`', '`kategoriproduk`', 200, 50, -1, false, '`kategoriproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kategoriproduk->Sortable = true; // Allow sort
        $this->kategoriproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategoriproduk->Param, "CustomMsg");
        $this->Fields['kategoriproduk'] = &$this->kategoriproduk;

        // jenisproduk
        $this->jenisproduk = new DbField('v_npd_customer', 'v_npd_customer', 'x_jenisproduk', 'jenisproduk', '`jenisproduk`', '`jenisproduk`', 200, 50, -1, false, '`jenisproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jenisproduk->Sortable = true; // Allow sort
        $this->jenisproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenisproduk->Param, "CustomMsg");
        $this->Fields['jenisproduk'] = &$this->jenisproduk;

        // idproduct_acuan
        $this->idproduct_acuan = new DbField('v_npd_customer', 'v_npd_customer', 'x_idproduct_acuan', 'idproduct_acuan', '`idproduct_acuan`', '`idproduct_acuan`', 20, 20, -1, false, '`idproduct_acuan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idproduct_acuan->Sortable = true; // Allow sort
        $this->idproduct_acuan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idproduct_acuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idproduct_acuan->Param, "CustomMsg");
        $this->Fields['idproduct_acuan'] = &$this->idproduct_acuan;

        // kualitasproduk
        $this->kualitasproduk = new DbField('v_npd_customer', 'v_npd_customer', 'x_kualitasproduk', 'kualitasproduk', '`kualitasproduk`', '`kualitasproduk`', 200, 50, -1, false, '`kualitasproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kualitasproduk->Sortable = true; // Allow sort
        $this->kualitasproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kualitasproduk->Param, "CustomMsg");
        $this->Fields['kualitasproduk'] = &$this->kualitasproduk;

        // bahan_campaign
        $this->bahan_campaign = new DbField('v_npd_customer', 'v_npd_customer', 'x_bahan_campaign', 'bahan_campaign', '`bahan_campaign`', '`bahan_campaign`', 201, 65535, -1, false, '`bahan_campaign`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bahan_campaign->Sortable = true; // Allow sort
        $this->bahan_campaign->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahan_campaign->Param, "CustomMsg");
        $this->Fields['bahan_campaign'] = &$this->bahan_campaign;

        // warna
        $this->warna = new DbField('v_npd_customer', 'v_npd_customer', 'x_warna', 'warna', '`warna`', '`warna`', 200, 50, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warna->Sortable = true; // Allow sort
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // parfum
        $this->parfum = new DbField('v_npd_customer', 'v_npd_customer', 'x_parfum', 'parfum', '`parfum`', '`parfum`', 200, 50, -1, false, '`parfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->parfum->Sortable = true; // Allow sort
        $this->parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->parfum->Param, "CustomMsg");
        $this->Fields['parfum'] = &$this->parfum;

        // tambahan
        $this->tambahan = new DbField('v_npd_customer', 'v_npd_customer', 'x_tambahan', 'tambahan', '`tambahan`', '`tambahan`', 201, 65535, -1, false, '`tambahan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->tambahan->Sortable = true; // Allow sort
        $this->tambahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tambahan->Param, "CustomMsg");
        $this->Fields['tambahan'] = &$this->tambahan;

        // status
        $this->status = new DbField('v_npd_customer', 'v_npd_customer', 'x_status', 'status', '`status`', '`status`', 200, 50, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // created_at
        $this->created_at = new DbField('v_npd_customer', 'v_npd_customer', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // readonly
        $this->readonly = new DbField('v_npd_customer', 'v_npd_customer', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
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
        $this->nama_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_nama_pemesan', 'nama_pemesan', '`nama_pemesan`', '`nama_pemesan`', 200, 255, -1, false, '`nama_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_pemesan->Nullable = false; // NOT NULL field
        $this->nama_pemesan->Required = true; // Required field
        $this->nama_pemesan->Sortable = true; // Allow sort
        $this->nama_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_pemesan->Param, "CustomMsg");
        $this->Fields['nama_pemesan'] = &$this->nama_pemesan;

        // alamat_pemesan
        $this->alamat_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_alamat_pemesan', 'alamat_pemesan', '`alamat_pemesan`', '`alamat_pemesan`', 201, 65535, -1, false, '`alamat_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->alamat_pemesan->Sortable = true; // Allow sort
        $this->alamat_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat_pemesan->Param, "CustomMsg");
        $this->Fields['alamat_pemesan'] = &$this->alamat_pemesan;

        // jabatan_pemesan
        $this->jabatan_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_jabatan_pemesan', 'jabatan_pemesan', '`jabatan_pemesan`', '`jabatan_pemesan`', 200, 255, -1, false, '`jabatan_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jabatan_pemesan->Sortable = true; // Allow sort
        $this->jabatan_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatan_pemesan->Param, "CustomMsg");
        $this->Fields['jabatan_pemesan'] = &$this->jabatan_pemesan;

        // hp_pemesan
        $this->hp_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_hp_pemesan', 'hp_pemesan', '`hp_pemesan`', '`hp_pemesan`', 200, 20, -1, false, '`hp_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hp_pemesan->Sortable = true; // Allow sort
        $this->hp_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hp_pemesan->Param, "CustomMsg");
        $this->Fields['hp_pemesan'] = &$this->hp_pemesan;

        // kodeproduk
        $this->kodeproduk = new DbField('v_npd_customer', 'v_npd_customer', 'x_kodeproduk', 'kodeproduk', '`kodeproduk`', '`kodeproduk`', 200, 50, -1, false, '`kodeproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeproduk->Sortable = true; // Allow sort
        $this->kodeproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeproduk->Param, "CustomMsg");
        $this->Fields['kodeproduk'] = &$this->kodeproduk;

        // namaproduk
        $this->namaproduk = new DbField('v_npd_customer', 'v_npd_customer', 'x_namaproduk', 'namaproduk', '`namaproduk`', '`namaproduk`', 200, 255, -1, false, '`namaproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namaproduk->Sortable = true; // Allow sort
        $this->namaproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namaproduk->Param, "CustomMsg");
        $this->Fields['namaproduk'] = &$this->namaproduk;

        // kode_pemesan
        $this->kode_pemesan = new DbField('v_npd_customer', 'v_npd_customer', 'x_kode_pemesan', 'kode_pemesan', '`kode_pemesan`', '`kode_pemesan`', 200, 50, -1, false, '`kode_pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode_pemesan->Nullable = false; // NOT NULL field
        $this->kode_pemesan->Required = true; // Required field
        $this->kode_pemesan->Sortable = true; // Allow sort
        $this->kode_pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode_pemesan->Param, "CustomMsg");
        $this->Fields['kode_pemesan'] = &$this->kode_pemesan;
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
            $this->idnpd->setDbValue($conn->lastInsertId());
            $rs['idnpd'] = $this->idnpd->DbValue;
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
            if (array_key_exists('idnpd', $rs)) {
                AddFilter($where, QuotedName('idnpd', $this->Dbid) . '=' . QuotedValue($rs['idnpd'], $this->idnpd->DataType, $this->Dbid));
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
        $this->idnpd->DbValue = $row['idnpd'];
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->kodeorder->DbValue = $row['kodeorder'];
        $this->kategoriproduk->DbValue = $row['kategoriproduk'];
        $this->jenisproduk->DbValue = $row['jenisproduk'];
        $this->idproduct_acuan->DbValue = $row['idproduct_acuan'];
        $this->kualitasproduk->DbValue = $row['kualitasproduk'];
        $this->bahan_campaign->DbValue = $row['bahan_campaign'];
        $this->warna->DbValue = $row['warna'];
        $this->parfum->DbValue = $row['parfum'];
        $this->tambahan->DbValue = $row['tambahan'];
        $this->status->DbValue = $row['status'];
        $this->created_at->DbValue = $row['created_at'];
        $this->readonly->DbValue = $row['readonly'];
        $this->nama_pemesan->DbValue = $row['nama_pemesan'];
        $this->alamat_pemesan->DbValue = $row['alamat_pemesan'];
        $this->jabatan_pemesan->DbValue = $row['jabatan_pemesan'];
        $this->hp_pemesan->DbValue = $row['hp_pemesan'];
        $this->kodeproduk->DbValue = $row['kodeproduk'];
        $this->namaproduk->DbValue = $row['namaproduk'];
        $this->kode_pemesan->DbValue = $row['kode_pemesan'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idnpd` = @idnpd@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->idnpd->CurrentValue : $this->idnpd->OldValue;
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
                $this->idnpd->CurrentValue = $keys[0];
            } else {
                $this->idnpd->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idnpd', $row) ? $row['idnpd'] : null;
        } else {
            $val = $this->idnpd->OldValue !== null ? $this->idnpd->OldValue : $this->idnpd->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idnpd@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        $json .= "idnpd:" . JsonEncode($this->idnpd->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idnpd->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idnpd->CurrentValue);
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
            if (($keyValue = Param("idnpd") ?? Route("idnpd")) !== null) {
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
                $this->idnpd->CurrentValue = $key;
            } else {
                $this->idnpd->OldValue = $key;
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->status->setDbValue($row['status']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->nama_pemesan->setDbValue($row['nama_pemesan']);
        $this->alamat_pemesan->setDbValue($row['alamat_pemesan']);
        $this->jabatan_pemesan->setDbValue($row['jabatan_pemesan']);
        $this->hp_pemesan->setDbValue($row['hp_pemesan']);
        $this->kodeproduk->setDbValue($row['kodeproduk']);
        $this->namaproduk->setDbValue($row['namaproduk']);
        $this->kode_pemesan->setDbValue($row['kode_pemesan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // idnpd

        // idpegawai

        // idcustomer

        // kodeorder

        // kategoriproduk

        // jenisproduk

        // idproduct_acuan

        // kualitasproduk

        // bahan_campaign

        // warna

        // parfum

        // tambahan

        // status

        // created_at

        // readonly

        // nama_pemesan

        // alamat_pemesan

        // jabatan_pemesan

        // hp_pemesan

        // kodeproduk

        // namaproduk

        // kode_pemesan

        // idnpd
        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
        $this->idnpd->ViewCustomAttributes = "";

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

        // kategoriproduk
        $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
        $this->kategoriproduk->ViewCustomAttributes = "";

        // jenisproduk
        $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
        $this->jenisproduk->ViewCustomAttributes = "";

        // idproduct_acuan
        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->CurrentValue;
        $this->idproduct_acuan->ViewValue = FormatNumber($this->idproduct_acuan->ViewValue, 0, -2, -2, -2);
        $this->idproduct_acuan->ViewCustomAttributes = "";

        // kualitasproduk
        $this->kualitasproduk->ViewValue = $this->kualitasproduk->CurrentValue;
        $this->kualitasproduk->ViewCustomAttributes = "";

        // bahan_campaign
        $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
        $this->bahan_campaign->ViewCustomAttributes = "";

        // warna
        $this->warna->ViewValue = $this->warna->CurrentValue;
        $this->warna->ViewCustomAttributes = "";

        // parfum
        $this->parfum->ViewValue = $this->parfum->CurrentValue;
        $this->parfum->ViewCustomAttributes = "";

        // tambahan
        $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
        $this->tambahan->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

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

        // kodeproduk
        $this->kodeproduk->ViewValue = $this->kodeproduk->CurrentValue;
        $this->kodeproduk->ViewCustomAttributes = "";

        // namaproduk
        $this->namaproduk->ViewValue = $this->namaproduk->CurrentValue;
        $this->namaproduk->ViewCustomAttributes = "";

        // kode_pemesan
        $this->kode_pemesan->ViewValue = $this->kode_pemesan->CurrentValue;
        $this->kode_pemesan->ViewCustomAttributes = "";

        // idnpd
        $this->idnpd->LinkCustomAttributes = "";
        $this->idnpd->HrefValue = "";
        $this->idnpd->TooltipValue = "";

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

        // kategoriproduk
        $this->kategoriproduk->LinkCustomAttributes = "";
        $this->kategoriproduk->HrefValue = "";
        $this->kategoriproduk->TooltipValue = "";

        // jenisproduk
        $this->jenisproduk->LinkCustomAttributes = "";
        $this->jenisproduk->HrefValue = "";
        $this->jenisproduk->TooltipValue = "";

        // idproduct_acuan
        $this->idproduct_acuan->LinkCustomAttributes = "";
        $this->idproduct_acuan->HrefValue = "";
        $this->idproduct_acuan->TooltipValue = "";

        // kualitasproduk
        $this->kualitasproduk->LinkCustomAttributes = "";
        $this->kualitasproduk->HrefValue = "";
        $this->kualitasproduk->TooltipValue = "";

        // bahan_campaign
        $this->bahan_campaign->LinkCustomAttributes = "";
        $this->bahan_campaign->HrefValue = "";
        $this->bahan_campaign->TooltipValue = "";

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

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

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

        // kodeproduk
        $this->kodeproduk->LinkCustomAttributes = "";
        $this->kodeproduk->HrefValue = "";
        $this->kodeproduk->TooltipValue = "";

        // namaproduk
        $this->namaproduk->LinkCustomAttributes = "";
        $this->namaproduk->HrefValue = "";
        $this->namaproduk->TooltipValue = "";

        // kode_pemesan
        $this->kode_pemesan->LinkCustomAttributes = "";
        $this->kode_pemesan->HrefValue = "";
        $this->kode_pemesan->TooltipValue = "";

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

        // idnpd
        $this->idnpd->EditAttrs["class"] = "form-control";
        $this->idnpd->EditCustomAttributes = "";
        $this->idnpd->EditValue = $this->idnpd->CurrentValue;
        $this->idnpd->ViewCustomAttributes = "";

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

        // kategoriproduk
        $this->kategoriproduk->EditAttrs["class"] = "form-control";
        $this->kategoriproduk->EditCustomAttributes = "";
        if (!$this->kategoriproduk->Raw) {
            $this->kategoriproduk->CurrentValue = HtmlDecode($this->kategoriproduk->CurrentValue);
        }
        $this->kategoriproduk->EditValue = $this->kategoriproduk->CurrentValue;
        $this->kategoriproduk->PlaceHolder = RemoveHtml($this->kategoriproduk->caption());

        // jenisproduk
        $this->jenisproduk->EditAttrs["class"] = "form-control";
        $this->jenisproduk->EditCustomAttributes = "";
        if (!$this->jenisproduk->Raw) {
            $this->jenisproduk->CurrentValue = HtmlDecode($this->jenisproduk->CurrentValue);
        }
        $this->jenisproduk->EditValue = $this->jenisproduk->CurrentValue;
        $this->jenisproduk->PlaceHolder = RemoveHtml($this->jenisproduk->caption());

        // idproduct_acuan
        $this->idproduct_acuan->EditAttrs["class"] = "form-control";
        $this->idproduct_acuan->EditCustomAttributes = "";
        $this->idproduct_acuan->EditValue = $this->idproduct_acuan->CurrentValue;
        $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

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

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

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

        // kodeproduk
        $this->kodeproduk->EditAttrs["class"] = "form-control";
        $this->kodeproduk->EditCustomAttributes = "";
        if (!$this->kodeproduk->Raw) {
            $this->kodeproduk->CurrentValue = HtmlDecode($this->kodeproduk->CurrentValue);
        }
        $this->kodeproduk->EditValue = $this->kodeproduk->CurrentValue;
        $this->kodeproduk->PlaceHolder = RemoveHtml($this->kodeproduk->caption());

        // namaproduk
        $this->namaproduk->EditAttrs["class"] = "form-control";
        $this->namaproduk->EditCustomAttributes = "";
        if (!$this->namaproduk->Raw) {
            $this->namaproduk->CurrentValue = HtmlDecode($this->namaproduk->CurrentValue);
        }
        $this->namaproduk->EditValue = $this->namaproduk->CurrentValue;
        $this->namaproduk->PlaceHolder = RemoveHtml($this->namaproduk->caption());

        // kode_pemesan
        $this->kode_pemesan->EditAttrs["class"] = "form-control";
        $this->kode_pemesan->EditCustomAttributes = "";
        if (!$this->kode_pemesan->Raw) {
            $this->kode_pemesan->CurrentValue = HtmlDecode($this->kode_pemesan->CurrentValue);
        }
        $this->kode_pemesan->EditValue = $this->kode_pemesan->CurrentValue;
        $this->kode_pemesan->PlaceHolder = RemoveHtml($this->kode_pemesan->caption());

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
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->kategoriproduk);
                    $doc->exportCaption($this->jenisproduk);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->kualitasproduk);
                    $doc->exportCaption($this->bahan_campaign);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->tambahan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->nama_pemesan);
                    $doc->exportCaption($this->alamat_pemesan);
                    $doc->exportCaption($this->jabatan_pemesan);
                    $doc->exportCaption($this->hp_pemesan);
                    $doc->exportCaption($this->kodeproduk);
                    $doc->exportCaption($this->namaproduk);
                    $doc->exportCaption($this->kode_pemesan);
                } else {
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->kategoriproduk);
                    $doc->exportCaption($this->jenisproduk);
                    $doc->exportCaption($this->idproduct_acuan);
                    $doc->exportCaption($this->kualitasproduk);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->nama_pemesan);
                    $doc->exportCaption($this->jabatan_pemesan);
                    $doc->exportCaption($this->hp_pemesan);
                    $doc->exportCaption($this->kodeproduk);
                    $doc->exportCaption($this->namaproduk);
                    $doc->exportCaption($this->kode_pemesan);
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
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->kategoriproduk);
                        $doc->exportField($this->jenisproduk);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->kualitasproduk);
                        $doc->exportField($this->bahan_campaign);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->tambahan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->nama_pemesan);
                        $doc->exportField($this->alamat_pemesan);
                        $doc->exportField($this->jabatan_pemesan);
                        $doc->exportField($this->hp_pemesan);
                        $doc->exportField($this->kodeproduk);
                        $doc->exportField($this->namaproduk);
                        $doc->exportField($this->kode_pemesan);
                    } else {
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->kategoriproduk);
                        $doc->exportField($this->jenisproduk);
                        $doc->exportField($this->idproduct_acuan);
                        $doc->exportField($this->kualitasproduk);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->status);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->nama_pemesan);
                        $doc->exportField($this->jabatan_pemesan);
                        $doc->exportField($this->hp_pemesan);
                        $doc->exportField($this->kodeproduk);
                        $doc->exportField($this->namaproduk);
                        $doc->exportField($this->kode_pemesan);
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
