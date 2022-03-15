<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_desain
 */
class NpdDesain extends DbTable
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
    public $nama_produk;
    public $klaim_bahan;
    public $campaign_produk;
    public $konsepwarna;
    public $no_notifikasi;
    public $jenis_kemasan;
    public $posisi_label;
    public $bahan_label;
    public $draft_layout;
    public $keterangan;
    public $submitted_by;
    public $checked1_by;
    public $checked2_by;
    public $approved_by;
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
        $this->TableVar = 'npd_desain';
        $this->TableName = 'npd_desain';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_desain`";
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
        $this->id = new DbField('npd_desain', 'npd_desain', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = false; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('npd_desain', 'npd_desain', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 20, 20, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idnpd->IsForeignKey = true; // Foreign key field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // tglterima
        $this->tglterima = new DbField('npd_desain', 'npd_desain', 'x_tglterima', 'tglterima', '`tglterima`', CastDateFieldForLike("`tglterima`", 0, "DB"), 133, 10, 0, false, '`tglterima`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglterima->Sortable = true; // Allow sort
        $this->tglterima->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglterima->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglterima->Param, "CustomMsg");
        $this->Fields['tglterima'] = &$this->tglterima;

        // tglsubmit
        $this->tglsubmit = new DbField('npd_desain', 'npd_desain', 'x_tglsubmit', 'tglsubmit', '`tglsubmit`', CastDateFieldForLike("`tglsubmit`", 0, "DB"), 133, 10, 0, false, '`tglsubmit`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglsubmit->Sortable = true; // Allow sort
        $this->tglsubmit->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglsubmit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglsubmit->Param, "CustomMsg");
        $this->Fields['tglsubmit'] = &$this->tglsubmit;

        // nama_produk
        $this->nama_produk = new DbField('npd_desain', 'npd_desain', 'x_nama_produk', 'nama_produk', '`nama_produk`', '`nama_produk`', 200, 255, -1, false, '`nama_produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_produk->Sortable = true; // Allow sort
        $this->nama_produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_produk->Param, "CustomMsg");
        $this->Fields['nama_produk'] = &$this->nama_produk;

        // klaim_bahan
        $this->klaim_bahan = new DbField('npd_desain', 'npd_desain', 'x_klaim_bahan', 'klaim_bahan', '`klaim_bahan`', '`klaim_bahan`', 200, 255, -1, false, '`klaim_bahan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->klaim_bahan->Sortable = true; // Allow sort
        $this->klaim_bahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->klaim_bahan->Param, "CustomMsg");
        $this->Fields['klaim_bahan'] = &$this->klaim_bahan;

        // campaign_produk
        $this->campaign_produk = new DbField('npd_desain', 'npd_desain', 'x_campaign_produk', 'campaign_produk', '`campaign_produk`', '`campaign_produk`', 200, 255, -1, false, '`campaign_produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->campaign_produk->Sortable = true; // Allow sort
        $this->campaign_produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->campaign_produk->Param, "CustomMsg");
        $this->Fields['campaign_produk'] = &$this->campaign_produk;

        // konsepwarna
        $this->konsepwarna = new DbField('npd_desain', 'npd_desain', 'x_konsepwarna', 'konsepwarna', '`konsepwarna`', '`konsepwarna`', 200, 255, -1, false, '`konsepwarna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->konsepwarna->Sortable = true; // Allow sort
        $this->konsepwarna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->konsepwarna->Param, "CustomMsg");
        $this->Fields['konsepwarna'] = &$this->konsepwarna;

        // no_notifikasi
        $this->no_notifikasi = new DbField('npd_desain', 'npd_desain', 'x_no_notifikasi', 'no_notifikasi', '`no_notifikasi`', '`no_notifikasi`', 200, 255, -1, false, '`no_notifikasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->no_notifikasi->Sortable = true; // Allow sort
        $this->no_notifikasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->no_notifikasi->Param, "CustomMsg");
        $this->Fields['no_notifikasi'] = &$this->no_notifikasi;

        // jenis_kemasan
        $this->jenis_kemasan = new DbField('npd_desain', 'npd_desain', 'x_jenis_kemasan', 'jenis_kemasan', '`jenis_kemasan`', '`jenis_kemasan`', 200, 255, -1, false, '`jenis_kemasan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jenis_kemasan->Sortable = true; // Allow sort
        $this->jenis_kemasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenis_kemasan->Param, "CustomMsg");
        $this->Fields['jenis_kemasan'] = &$this->jenis_kemasan;

        // posisi_label
        $this->posisi_label = new DbField('npd_desain', 'npd_desain', 'x_posisi_label', 'posisi_label', '`posisi_label`', '`posisi_label`', 200, 255, -1, false, '`posisi_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->posisi_label->Sortable = true; // Allow sort
        $this->posisi_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->posisi_label->Param, "CustomMsg");
        $this->Fields['posisi_label'] = &$this->posisi_label;

        // bahan_label
        $this->bahan_label = new DbField('npd_desain', 'npd_desain', 'x_bahan_label', 'bahan_label', '`bahan_label`', '`bahan_label`', 200, 255, -1, false, '`bahan_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahan_label->Sortable = true; // Allow sort
        $this->bahan_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahan_label->Param, "CustomMsg");
        $this->Fields['bahan_label'] = &$this->bahan_label;

        // draft_layout
        $this->draft_layout = new DbField('npd_desain', 'npd_desain', 'x_draft_layout', 'draft_layout', '`draft_layout`', '`draft_layout`', 200, 255, -1, false, '`draft_layout`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->draft_layout->Sortable = true; // Allow sort
        $this->draft_layout->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->draft_layout->Param, "CustomMsg");
        $this->Fields['draft_layout'] = &$this->draft_layout;

        // keterangan
        $this->keterangan = new DbField('npd_desain', 'npd_desain', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, 65535, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // submitted_by
        $this->submitted_by = new DbField('npd_desain', 'npd_desain', 'x_submitted_by', 'submitted_by', '`submitted_by`', '`submitted_by`', 3, 11, -1, false, '`submitted_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->submitted_by->Sortable = true; // Allow sort
        $this->submitted_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->submitted_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->submitted_by->Param, "CustomMsg");
        $this->Fields['submitted_by'] = &$this->submitted_by;

        // checked1_by
        $this->checked1_by = new DbField('npd_desain', 'npd_desain', 'x_checked1_by', 'checked1_by', '`checked1_by`', '`checked1_by`', 3, 11, -1, false, '`checked1_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->checked1_by->Sortable = true; // Allow sort
        $this->checked1_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->checked1_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->checked1_by->Param, "CustomMsg");
        $this->Fields['checked1_by'] = &$this->checked1_by;

        // checked2_by
        $this->checked2_by = new DbField('npd_desain', 'npd_desain', 'x_checked2_by', 'checked2_by', '`checked2_by`', '`checked2_by`', 3, 11, -1, false, '`checked2_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->checked2_by->Sortable = true; // Allow sort
        $this->checked2_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->checked2_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->checked2_by->Param, "CustomMsg");
        $this->Fields['checked2_by'] = &$this->checked2_by;

        // approved_by
        $this->approved_by = new DbField('npd_desain', 'npd_desain', 'x_approved_by', 'approved_by', '`approved_by`', '`approved_by`', 3, 11, -1, false, '`approved_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->approved_by->Sortable = true; // Allow sort
        $this->approved_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->approved_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->approved_by->Param, "CustomMsg");
        $this->Fields['approved_by'] = &$this->approved_by;

        // created_at
        $this->created_at = new DbField('npd_desain', 'npd_desain', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('npd_desain', 'npd_desain', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_desain`";
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
        $this->tglterima->DbValue = $row['tglterima'];
        $this->tglsubmit->DbValue = $row['tglsubmit'];
        $this->nama_produk->DbValue = $row['nama_produk'];
        $this->klaim_bahan->DbValue = $row['klaim_bahan'];
        $this->campaign_produk->DbValue = $row['campaign_produk'];
        $this->konsepwarna->DbValue = $row['konsepwarna'];
        $this->no_notifikasi->DbValue = $row['no_notifikasi'];
        $this->jenis_kemasan->DbValue = $row['jenis_kemasan'];
        $this->posisi_label->DbValue = $row['posisi_label'];
        $this->bahan_label->DbValue = $row['bahan_label'];
        $this->draft_layout->DbValue = $row['draft_layout'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->submitted_by->DbValue = $row['submitted_by'];
        $this->checked1_by->DbValue = $row['checked1_by'];
        $this->checked2_by->DbValue = $row['checked2_by'];
        $this->approved_by->DbValue = $row['approved_by'];
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
        return $_SESSION[$name] ?? GetUrl("NpdDesainList");
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
        if ($pageName == "NpdDesainView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdDesainEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdDesainAdd") {
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
                return "NpdDesainView";
            case Config("API_ADD_ACTION"):
                return "NpdDesainAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdDesainEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdDesainDelete";
            case Config("API_LIST_ACTION"):
                return "NpdDesainList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdDesainList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdDesainView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdDesainView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdDesainAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdDesainAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdDesainEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdDesainAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdDesainDelete", $this->getUrlParm());
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
        $this->tglterima->setDbValue($row['tglterima']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->nama_produk->setDbValue($row['nama_produk']);
        $this->klaim_bahan->setDbValue($row['klaim_bahan']);
        $this->campaign_produk->setDbValue($row['campaign_produk']);
        $this->konsepwarna->setDbValue($row['konsepwarna']);
        $this->no_notifikasi->setDbValue($row['no_notifikasi']);
        $this->jenis_kemasan->setDbValue($row['jenis_kemasan']);
        $this->posisi_label->setDbValue($row['posisi_label']);
        $this->bahan_label->setDbValue($row['bahan_label']);
        $this->draft_layout->setDbValue($row['draft_layout']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->submitted_by->setDbValue($row['submitted_by']);
        $this->checked1_by->setDbValue($row['checked1_by']);
        $this->checked2_by->setDbValue($row['checked2_by']);
        $this->approved_by->setDbValue($row['approved_by']);
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

        // idnpd

        // tglterima

        // tglsubmit

        // nama_produk

        // klaim_bahan

        // campaign_produk

        // konsepwarna

        // no_notifikasi

        // jenis_kemasan

        // posisi_label

        // bahan_label

        // draft_layout

        // keterangan

        // submitted_by

        // checked1_by

        // checked2_by

        // approved_by

        // created_at

        // updated_at

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // idnpd
        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
        $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
        $this->idnpd->ViewCustomAttributes = "";

        // tglterima
        $this->tglterima->ViewValue = $this->tglterima->CurrentValue;
        $this->tglterima->ViewValue = FormatDateTime($this->tglterima->ViewValue, 0);
        $this->tglterima->ViewCustomAttributes = "";

        // tglsubmit
        $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
        $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
        $this->tglsubmit->ViewCustomAttributes = "";

        // nama_produk
        $this->nama_produk->ViewValue = $this->nama_produk->CurrentValue;
        $this->nama_produk->ViewCustomAttributes = "";

        // klaim_bahan
        $this->klaim_bahan->ViewValue = $this->klaim_bahan->CurrentValue;
        $this->klaim_bahan->ViewCustomAttributes = "";

        // campaign_produk
        $this->campaign_produk->ViewValue = $this->campaign_produk->CurrentValue;
        $this->campaign_produk->ViewCustomAttributes = "";

        // konsepwarna
        $this->konsepwarna->ViewValue = $this->konsepwarna->CurrentValue;
        $this->konsepwarna->ViewCustomAttributes = "";

        // no_notifikasi
        $this->no_notifikasi->ViewValue = $this->no_notifikasi->CurrentValue;
        $this->no_notifikasi->ViewCustomAttributes = "";

        // jenis_kemasan
        $this->jenis_kemasan->ViewValue = $this->jenis_kemasan->CurrentValue;
        $this->jenis_kemasan->ViewCustomAttributes = "";

        // posisi_label
        $this->posisi_label->ViewValue = $this->posisi_label->CurrentValue;
        $this->posisi_label->ViewCustomAttributes = "";

        // bahan_label
        $this->bahan_label->ViewValue = $this->bahan_label->CurrentValue;
        $this->bahan_label->ViewCustomAttributes = "";

        // draft_layout
        $this->draft_layout->ViewValue = $this->draft_layout->CurrentValue;
        $this->draft_layout->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // submitted_by
        $this->submitted_by->ViewValue = $this->submitted_by->CurrentValue;
        $this->submitted_by->ViewValue = FormatNumber($this->submitted_by->ViewValue, 0, -2, -2, -2);
        $this->submitted_by->ViewCustomAttributes = "";

        // checked1_by
        $this->checked1_by->ViewValue = $this->checked1_by->CurrentValue;
        $this->checked1_by->ViewValue = FormatNumber($this->checked1_by->ViewValue, 0, -2, -2, -2);
        $this->checked1_by->ViewCustomAttributes = "";

        // checked2_by
        $this->checked2_by->ViewValue = $this->checked2_by->CurrentValue;
        $this->checked2_by->ViewValue = FormatNumber($this->checked2_by->ViewValue, 0, -2, -2, -2);
        $this->checked2_by->ViewCustomAttributes = "";

        // approved_by
        $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
        $this->approved_by->ViewValue = FormatNumber($this->approved_by->ViewValue, 0, -2, -2, -2);
        $this->approved_by->ViewCustomAttributes = "";

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

        // nama_produk
        $this->nama_produk->LinkCustomAttributes = "";
        $this->nama_produk->HrefValue = "";
        $this->nama_produk->TooltipValue = "";

        // klaim_bahan
        $this->klaim_bahan->LinkCustomAttributes = "";
        $this->klaim_bahan->HrefValue = "";
        $this->klaim_bahan->TooltipValue = "";

        // campaign_produk
        $this->campaign_produk->LinkCustomAttributes = "";
        $this->campaign_produk->HrefValue = "";
        $this->campaign_produk->TooltipValue = "";

        // konsepwarna
        $this->konsepwarna->LinkCustomAttributes = "";
        $this->konsepwarna->HrefValue = "";
        $this->konsepwarna->TooltipValue = "";

        // no_notifikasi
        $this->no_notifikasi->LinkCustomAttributes = "";
        $this->no_notifikasi->HrefValue = "";
        $this->no_notifikasi->TooltipValue = "";

        // jenis_kemasan
        $this->jenis_kemasan->LinkCustomAttributes = "";
        $this->jenis_kemasan->HrefValue = "";
        $this->jenis_kemasan->TooltipValue = "";

        // posisi_label
        $this->posisi_label->LinkCustomAttributes = "";
        $this->posisi_label->HrefValue = "";
        $this->posisi_label->TooltipValue = "";

        // bahan_label
        $this->bahan_label->LinkCustomAttributes = "";
        $this->bahan_label->HrefValue = "";
        $this->bahan_label->TooltipValue = "";

        // draft_layout
        $this->draft_layout->LinkCustomAttributes = "";
        $this->draft_layout->HrefValue = "";
        $this->draft_layout->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

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
        $this->id->EditValue = FormatNumber($this->id->EditValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // idnpd
        $this->idnpd->EditAttrs["class"] = "form-control";
        $this->idnpd->EditCustomAttributes = "";
        if ($this->idnpd->getSessionValue() != "") {
            $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";
        } else {
            $this->idnpd->EditValue = $this->idnpd->CurrentValue;
            $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
        }

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

        // nama_produk
        $this->nama_produk->EditAttrs["class"] = "form-control";
        $this->nama_produk->EditCustomAttributes = "";
        if (!$this->nama_produk->Raw) {
            $this->nama_produk->CurrentValue = HtmlDecode($this->nama_produk->CurrentValue);
        }
        $this->nama_produk->EditValue = $this->nama_produk->CurrentValue;
        $this->nama_produk->PlaceHolder = RemoveHtml($this->nama_produk->caption());

        // klaim_bahan
        $this->klaim_bahan->EditAttrs["class"] = "form-control";
        $this->klaim_bahan->EditCustomAttributes = "";
        if (!$this->klaim_bahan->Raw) {
            $this->klaim_bahan->CurrentValue = HtmlDecode($this->klaim_bahan->CurrentValue);
        }
        $this->klaim_bahan->EditValue = $this->klaim_bahan->CurrentValue;
        $this->klaim_bahan->PlaceHolder = RemoveHtml($this->klaim_bahan->caption());

        // campaign_produk
        $this->campaign_produk->EditAttrs["class"] = "form-control";
        $this->campaign_produk->EditCustomAttributes = "";
        if (!$this->campaign_produk->Raw) {
            $this->campaign_produk->CurrentValue = HtmlDecode($this->campaign_produk->CurrentValue);
        }
        $this->campaign_produk->EditValue = $this->campaign_produk->CurrentValue;
        $this->campaign_produk->PlaceHolder = RemoveHtml($this->campaign_produk->caption());

        // konsepwarna
        $this->konsepwarna->EditAttrs["class"] = "form-control";
        $this->konsepwarna->EditCustomAttributes = "";
        if (!$this->konsepwarna->Raw) {
            $this->konsepwarna->CurrentValue = HtmlDecode($this->konsepwarna->CurrentValue);
        }
        $this->konsepwarna->EditValue = $this->konsepwarna->CurrentValue;
        $this->konsepwarna->PlaceHolder = RemoveHtml($this->konsepwarna->caption());

        // no_notifikasi
        $this->no_notifikasi->EditAttrs["class"] = "form-control";
        $this->no_notifikasi->EditCustomAttributes = "";
        if (!$this->no_notifikasi->Raw) {
            $this->no_notifikasi->CurrentValue = HtmlDecode($this->no_notifikasi->CurrentValue);
        }
        $this->no_notifikasi->EditValue = $this->no_notifikasi->CurrentValue;
        $this->no_notifikasi->PlaceHolder = RemoveHtml($this->no_notifikasi->caption());

        // jenis_kemasan
        $this->jenis_kemasan->EditAttrs["class"] = "form-control";
        $this->jenis_kemasan->EditCustomAttributes = "";
        if (!$this->jenis_kemasan->Raw) {
            $this->jenis_kemasan->CurrentValue = HtmlDecode($this->jenis_kemasan->CurrentValue);
        }
        $this->jenis_kemasan->EditValue = $this->jenis_kemasan->CurrentValue;
        $this->jenis_kemasan->PlaceHolder = RemoveHtml($this->jenis_kemasan->caption());

        // posisi_label
        $this->posisi_label->EditAttrs["class"] = "form-control";
        $this->posisi_label->EditCustomAttributes = "";
        if (!$this->posisi_label->Raw) {
            $this->posisi_label->CurrentValue = HtmlDecode($this->posisi_label->CurrentValue);
        }
        $this->posisi_label->EditValue = $this->posisi_label->CurrentValue;
        $this->posisi_label->PlaceHolder = RemoveHtml($this->posisi_label->caption());

        // bahan_label
        $this->bahan_label->EditAttrs["class"] = "form-control";
        $this->bahan_label->EditCustomAttributes = "";
        if (!$this->bahan_label->Raw) {
            $this->bahan_label->CurrentValue = HtmlDecode($this->bahan_label->CurrentValue);
        }
        $this->bahan_label->EditValue = $this->bahan_label->CurrentValue;
        $this->bahan_label->PlaceHolder = RemoveHtml($this->bahan_label->caption());

        // draft_layout
        $this->draft_layout->EditAttrs["class"] = "form-control";
        $this->draft_layout->EditCustomAttributes = "";
        if (!$this->draft_layout->Raw) {
            $this->draft_layout->CurrentValue = HtmlDecode($this->draft_layout->CurrentValue);
        }
        $this->draft_layout->EditValue = $this->draft_layout->CurrentValue;
        $this->draft_layout->PlaceHolder = RemoveHtml($this->draft_layout->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // submitted_by
        $this->submitted_by->EditAttrs["class"] = "form-control";
        $this->submitted_by->EditCustomAttributes = "";
        $this->submitted_by->EditValue = $this->submitted_by->CurrentValue;
        $this->submitted_by->PlaceHolder = RemoveHtml($this->submitted_by->caption());

        // checked1_by
        $this->checked1_by->EditAttrs["class"] = "form-control";
        $this->checked1_by->EditCustomAttributes = "";
        $this->checked1_by->EditValue = $this->checked1_by->CurrentValue;
        $this->checked1_by->PlaceHolder = RemoveHtml($this->checked1_by->caption());

        // checked2_by
        $this->checked2_by->EditAttrs["class"] = "form-control";
        $this->checked2_by->EditCustomAttributes = "";
        $this->checked2_by->EditValue = $this->checked2_by->CurrentValue;
        $this->checked2_by->PlaceHolder = RemoveHtml($this->checked2_by->caption());

        // approved_by
        $this->approved_by->EditAttrs["class"] = "form-control";
        $this->approved_by->EditCustomAttributes = "";
        $this->approved_by->EditValue = $this->approved_by->CurrentValue;
        $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

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
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->tglterima);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->klaim_bahan);
                    $doc->exportCaption($this->campaign_produk);
                    $doc->exportCaption($this->konsepwarna);
                    $doc->exportCaption($this->no_notifikasi);
                    $doc->exportCaption($this->jenis_kemasan);
                    $doc->exportCaption($this->posisi_label);
                    $doc->exportCaption($this->bahan_label);
                    $doc->exportCaption($this->draft_layout);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->submitted_by);
                    $doc->exportCaption($this->checked1_by);
                    $doc->exportCaption($this->checked2_by);
                    $doc->exportCaption($this->approved_by);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->tglterima);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->nama_produk);
                    $doc->exportCaption($this->klaim_bahan);
                    $doc->exportCaption($this->campaign_produk);
                    $doc->exportCaption($this->konsepwarna);
                    $doc->exportCaption($this->no_notifikasi);
                    $doc->exportCaption($this->jenis_kemasan);
                    $doc->exportCaption($this->posisi_label);
                    $doc->exportCaption($this->bahan_label);
                    $doc->exportCaption($this->draft_layout);
                    $doc->exportCaption($this->submitted_by);
                    $doc->exportCaption($this->checked1_by);
                    $doc->exportCaption($this->checked2_by);
                    $doc->exportCaption($this->approved_by);
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
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->tglterima);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->klaim_bahan);
                        $doc->exportField($this->campaign_produk);
                        $doc->exportField($this->konsepwarna);
                        $doc->exportField($this->no_notifikasi);
                        $doc->exportField($this->jenis_kemasan);
                        $doc->exportField($this->posisi_label);
                        $doc->exportField($this->bahan_label);
                        $doc->exportField($this->draft_layout);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->submitted_by);
                        $doc->exportField($this->checked1_by);
                        $doc->exportField($this->checked2_by);
                        $doc->exportField($this->approved_by);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->tglterima);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->nama_produk);
                        $doc->exportField($this->klaim_bahan);
                        $doc->exportField($this->campaign_produk);
                        $doc->exportField($this->konsepwarna);
                        $doc->exportField($this->no_notifikasi);
                        $doc->exportField($this->jenis_kemasan);
                        $doc->exportField($this->posisi_label);
                        $doc->exportField($this->bahan_label);
                        $doc->exportField($this->draft_layout);
                        $doc->exportField($this->submitted_by);
                        $doc->exportField($this->checked1_by);
                        $doc->exportField($this->checked2_by);
                        $doc->exportField($this->approved_by);
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
