<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for v_penagihan
 */
class VPenagihan extends DbTable
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
    public $tgl_order;
    public $tgl_reminder;
    public $tgl_normalbilling;
    public $tgl_jatuhtempo;
    public $tgl_intensbilling;
    public $tgl_actionplan;
    public $kodeorder;
    public $nama_customer;
    public $nominal;
    public $nilai_po;
    public $pembayaran;
    public $nilai_faktur;
    public $piutang;
    public $nomor_handphone;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'v_penagihan';
        $this->TableName = 'v_penagihan';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`v_penagihan`";
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

        // tgl_order
        $this->tgl_order = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_order', 'tgl_order', '`tgl_order`', CastDateFieldForLike("`tgl_order`", 0, "DB"), 135, 19, 0, false, '`tgl_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_order->Nullable = false; // NOT NULL field
        $this->tgl_order->Required = true; // Required field
        $this->tgl_order->Sortable = true; // Allow sort
        $this->tgl_order->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_order->Param, "CustomMsg");
        $this->Fields['tgl_order'] = &$this->tgl_order;

        // tgl_reminder
        $this->tgl_reminder = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_reminder', 'tgl_reminder', '`tgl_reminder`', CastDateFieldForLike("`tgl_reminder`", 0, "DB"), 135, 19, 0, false, '`tgl_reminder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_reminder->Sortable = true; // Allow sort
        $this->tgl_reminder->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_reminder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_reminder->Param, "CustomMsg");
        $this->Fields['tgl_reminder'] = &$this->tgl_reminder;

        // tgl_normalbilling
        $this->tgl_normalbilling = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_normalbilling', 'tgl_normalbilling', '`tgl_normalbilling`', CastDateFieldForLike("`tgl_normalbilling`", 0, "DB"), 135, 19, 0, false, '`tgl_normalbilling`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_normalbilling->Sortable = true; // Allow sort
        $this->tgl_normalbilling->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_normalbilling->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_normalbilling->Param, "CustomMsg");
        $this->Fields['tgl_normalbilling'] = &$this->tgl_normalbilling;

        // tgl_jatuhtempo
        $this->tgl_jatuhtempo = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_jatuhtempo', 'tgl_jatuhtempo', '`tgl_jatuhtempo`', CastDateFieldForLike("`tgl_jatuhtempo`", 0, "DB"), 135, 19, 0, false, '`tgl_jatuhtempo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_jatuhtempo->Sortable = true; // Allow sort
        $this->tgl_jatuhtempo->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_jatuhtempo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_jatuhtempo->Param, "CustomMsg");
        $this->Fields['tgl_jatuhtempo'] = &$this->tgl_jatuhtempo;

        // tgl_intensbilling
        $this->tgl_intensbilling = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_intensbilling', 'tgl_intensbilling', '`tgl_intensbilling`', CastDateFieldForLike("`tgl_intensbilling`", 0, "DB"), 135, 19, 0, false, '`tgl_intensbilling`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_intensbilling->Sortable = true; // Allow sort
        $this->tgl_intensbilling->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_intensbilling->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_intensbilling->Param, "CustomMsg");
        $this->Fields['tgl_intensbilling'] = &$this->tgl_intensbilling;

        // tgl_actionplan
        $this->tgl_actionplan = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_actionplan', 'tgl_actionplan', '`tgl_actionplan`', CastDateFieldForLike("`tgl_actionplan`", 0, "DB"), 135, 19, 0, false, '`tgl_actionplan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_actionplan->Sortable = true; // Allow sort
        $this->tgl_actionplan->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgl_actionplan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_actionplan->Param, "CustomMsg");
        $this->Fields['tgl_actionplan'] = &$this->tgl_actionplan;

        // kodeorder
        $this->kodeorder = new DbField('v_penagihan', 'v_penagihan', 'x_kodeorder', 'kodeorder', '`kodeorder`', '`kodeorder`', 200, 50, -1, false, '`kodeorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeorder->Nullable = false; // NOT NULL field
        $this->kodeorder->Required = true; // Required field
        $this->kodeorder->Sortable = true; // Allow sort
        $this->kodeorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeorder->Param, "CustomMsg");
        $this->Fields['kodeorder'] = &$this->kodeorder;

        // nama_customer
        $this->nama_customer = new DbField('v_penagihan', 'v_penagihan', 'x_nama_customer', 'nama_customer', '`nama_customer`', '`nama_customer`', 200, 100, -1, false, '`nama_customer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_customer->Nullable = false; // NOT NULL field
        $this->nama_customer->Required = true; // Required field
        $this->nama_customer->Sortable = true; // Allow sort
        $this->nama_customer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_customer->Param, "CustomMsg");
        $this->Fields['nama_customer'] = &$this->nama_customer;

        // nominal
        $this->nominal = new DbField('v_penagihan', 'v_penagihan', 'x_nominal', 'nominal', '`nominal`', '`nominal`', 131, 41, -1, false, '`nominal`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nominal->Sortable = true; // Allow sort
        $this->nominal->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->nominal->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->nominal->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nominal->Param, "CustomMsg");
        $this->Fields['nominal'] = &$this->nominal;

        // nilai_po
        $this->nilai_po = new DbField('v_penagihan', 'v_penagihan', 'x_nilai_po', 'nilai_po', '`nilai_po`', '`nilai_po`', 131, 41, -1, false, '`nilai_po`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nilai_po->Sortable = true; // Allow sort
        $this->nilai_po->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->nilai_po->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->nilai_po->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nilai_po->Param, "CustomMsg");
        $this->Fields['nilai_po'] = &$this->nilai_po;

        // pembayaran
        $this->pembayaran = new DbField('v_penagihan', 'v_penagihan', 'x_pembayaran', 'pembayaran', '`pembayaran`', '`pembayaran`', 131, 41, -1, false, '`pembayaran`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pembayaran->Nullable = false; // NOT NULL field
        $this->pembayaran->Sortable = true; // Allow sort
        $this->pembayaran->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->pembayaran->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->pembayaran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pembayaran->Param, "CustomMsg");
        $this->Fields['pembayaran'] = &$this->pembayaran;

        // nilai_faktur
        $this->nilai_faktur = new DbField('v_penagihan', 'v_penagihan', 'x_nilai_faktur', 'nilai_faktur', '`nilai_faktur`', '`nilai_faktur`', 131, 41, -1, false, '`nilai_faktur`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nilai_faktur->Sortable = true; // Allow sort
        $this->nilai_faktur->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->nilai_faktur->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->nilai_faktur->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nilai_faktur->Param, "CustomMsg");
        $this->Fields['nilai_faktur'] = &$this->nilai_faktur;

        // piutang
        $this->piutang = new DbField('v_penagihan', 'v_penagihan', 'x_piutang', 'piutang', '`piutang`', '`piutang`', 131, 41, -1, false, '`piutang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->piutang->Sortable = true; // Allow sort
        $this->piutang->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->piutang->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->piutang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->piutang->Param, "CustomMsg");
        $this->Fields['piutang'] = &$this->piutang;

        // nomor_handphone
        $this->nomor_handphone = new DbField('v_penagihan', 'v_penagihan', 'x_nomor_handphone', 'nomor_handphone', '`nomor_handphone`', '`nomor_handphone`', 200, 20, -1, false, '`nomor_handphone`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nomor_handphone->Nullable = false; // NOT NULL field
        $this->nomor_handphone->Required = true; // Required field
        $this->nomor_handphone->Sortable = true; // Allow sort
        $this->nomor_handphone->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nomor_handphone->Param, "CustomMsg");
        $this->Fields['nomor_handphone'] = &$this->nomor_handphone;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`v_penagihan`";
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
        $this->tgl_order->DbValue = $row['tgl_order'];
        $this->tgl_reminder->DbValue = $row['tgl_reminder'];
        $this->tgl_normalbilling->DbValue = $row['tgl_normalbilling'];
        $this->tgl_jatuhtempo->DbValue = $row['tgl_jatuhtempo'];
        $this->tgl_intensbilling->DbValue = $row['tgl_intensbilling'];
        $this->tgl_actionplan->DbValue = $row['tgl_actionplan'];
        $this->kodeorder->DbValue = $row['kodeorder'];
        $this->nama_customer->DbValue = $row['nama_customer'];
        $this->nominal->DbValue = $row['nominal'];
        $this->nilai_po->DbValue = $row['nilai_po'];
        $this->pembayaran->DbValue = $row['pembayaran'];
        $this->nilai_faktur->DbValue = $row['nilai_faktur'];
        $this->piutang->DbValue = $row['piutang'];
        $this->nomor_handphone->DbValue = $row['nomor_handphone'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 0) {
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
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
        return $_SESSION[$name] ?? GetUrl("VPenagihanList");
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
        if ($pageName == "VPenagihanView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VPenagihanEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VPenagihanAdd") {
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
                return "VPenagihanView";
            case Config("API_ADD_ACTION"):
                return "VPenagihanAdd";
            case Config("API_EDIT_ACTION"):
                return "VPenagihanEdit";
            case Config("API_DELETE_ACTION"):
                return "VPenagihanDelete";
            case Config("API_LIST_ACTION"):
                return "VPenagihanList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VPenagihanList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VPenagihanView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VPenagihanView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VPenagihanAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VPenagihanAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VPenagihanEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("VPenagihanAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("VPenagihanDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
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
            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
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
        $this->tgl_order->setDbValue($row['tgl_order']);
        $this->tgl_reminder->setDbValue($row['tgl_reminder']);
        $this->tgl_normalbilling->setDbValue($row['tgl_normalbilling']);
        $this->tgl_jatuhtempo->setDbValue($row['tgl_jatuhtempo']);
        $this->tgl_intensbilling->setDbValue($row['tgl_intensbilling']);
        $this->tgl_actionplan->setDbValue($row['tgl_actionplan']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nama_customer->setDbValue($row['nama_customer']);
        $this->nominal->setDbValue($row['nominal']);
        $this->nilai_po->setDbValue($row['nilai_po']);
        $this->pembayaran->setDbValue($row['pembayaran']);
        $this->nilai_faktur->setDbValue($row['nilai_faktur']);
        $this->piutang->setDbValue($row['piutang']);
        $this->nomor_handphone->setDbValue($row['nomor_handphone']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // tgl_order

        // tgl_reminder

        // tgl_normalbilling

        // tgl_jatuhtempo

        // tgl_intensbilling

        // tgl_actionplan

        // kodeorder

        // nama_customer

        // nominal

        // nilai_po

        // pembayaran

        // nilai_faktur

        // piutang

        // nomor_handphone

        // tgl_order
        $this->tgl_order->ViewValue = $this->tgl_order->CurrentValue;
        $this->tgl_order->ViewValue = FormatDateTime($this->tgl_order->ViewValue, 0);
        $this->tgl_order->ViewCustomAttributes = "";

        // tgl_reminder
        $this->tgl_reminder->ViewValue = $this->tgl_reminder->CurrentValue;
        $this->tgl_reminder->ViewValue = FormatDateTime($this->tgl_reminder->ViewValue, 0);
        $this->tgl_reminder->ViewCustomAttributes = "";

        // tgl_normalbilling
        $this->tgl_normalbilling->ViewValue = $this->tgl_normalbilling->CurrentValue;
        $this->tgl_normalbilling->ViewValue = FormatDateTime($this->tgl_normalbilling->ViewValue, 0);
        $this->tgl_normalbilling->ViewCustomAttributes = "";

        // tgl_jatuhtempo
        $this->tgl_jatuhtempo->ViewValue = $this->tgl_jatuhtempo->CurrentValue;
        $this->tgl_jatuhtempo->ViewValue = FormatDateTime($this->tgl_jatuhtempo->ViewValue, 0);
        $this->tgl_jatuhtempo->ViewCustomAttributes = "";

        // tgl_intensbilling
        $this->tgl_intensbilling->ViewValue = $this->tgl_intensbilling->CurrentValue;
        $this->tgl_intensbilling->ViewValue = FormatDateTime($this->tgl_intensbilling->ViewValue, 0);
        $this->tgl_intensbilling->ViewCustomAttributes = "";

        // tgl_actionplan
        $this->tgl_actionplan->ViewValue = $this->tgl_actionplan->CurrentValue;
        $this->tgl_actionplan->ViewValue = FormatDateTime($this->tgl_actionplan->ViewValue, 0);
        $this->tgl_actionplan->ViewCustomAttributes = "";

        // kodeorder
        $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
        $this->kodeorder->ViewCustomAttributes = "";

        // nama_customer
        $this->nama_customer->ViewValue = $this->nama_customer->CurrentValue;
        $this->nama_customer->ViewCustomAttributes = "";

        // nominal
        $this->nominal->ViewValue = $this->nominal->CurrentValue;
        $this->nominal->ViewValue = FormatNumber($this->nominal->ViewValue, 2, -2, -2, -2);
        $this->nominal->ViewCustomAttributes = "";

        // nilai_po
        $this->nilai_po->ViewValue = $this->nilai_po->CurrentValue;
        $this->nilai_po->ViewValue = FormatNumber($this->nilai_po->ViewValue, 2, -2, -2, -2);
        $this->nilai_po->ViewCustomAttributes = "";

        // pembayaran
        $this->pembayaran->ViewValue = $this->pembayaran->CurrentValue;
        $this->pembayaran->ViewValue = FormatNumber($this->pembayaran->ViewValue, 2, -2, -2, -2);
        $this->pembayaran->ViewCustomAttributes = "";

        // nilai_faktur
        $this->nilai_faktur->ViewValue = $this->nilai_faktur->CurrentValue;
        $this->nilai_faktur->ViewValue = FormatNumber($this->nilai_faktur->ViewValue, 2, -2, -2, -2);
        $this->nilai_faktur->ViewCustomAttributes = "";

        // piutang
        $this->piutang->ViewValue = $this->piutang->CurrentValue;
        $this->piutang->ViewValue = FormatNumber($this->piutang->ViewValue, 2, -2, -2, -2);
        $this->piutang->ViewCustomAttributes = "";

        // nomor_handphone
        $this->nomor_handphone->ViewValue = $this->nomor_handphone->CurrentValue;
        $this->nomor_handphone->ViewCustomAttributes = "";

        // tgl_order
        $this->tgl_order->LinkCustomAttributes = "";
        $this->tgl_order->HrefValue = "";
        $this->tgl_order->TooltipValue = "";

        // tgl_reminder
        $this->tgl_reminder->LinkCustomAttributes = "";
        $this->tgl_reminder->HrefValue = "";
        $this->tgl_reminder->TooltipValue = "";

        // tgl_normalbilling
        $this->tgl_normalbilling->LinkCustomAttributes = "";
        $this->tgl_normalbilling->HrefValue = "";
        $this->tgl_normalbilling->TooltipValue = "";

        // tgl_jatuhtempo
        $this->tgl_jatuhtempo->LinkCustomAttributes = "";
        $this->tgl_jatuhtempo->HrefValue = "";
        $this->tgl_jatuhtempo->TooltipValue = "";

        // tgl_intensbilling
        $this->tgl_intensbilling->LinkCustomAttributes = "";
        $this->tgl_intensbilling->HrefValue = "";
        $this->tgl_intensbilling->TooltipValue = "";

        // tgl_actionplan
        $this->tgl_actionplan->LinkCustomAttributes = "";
        $this->tgl_actionplan->HrefValue = "";
        $this->tgl_actionplan->TooltipValue = "";

        // kodeorder
        $this->kodeorder->LinkCustomAttributes = "";
        $this->kodeorder->HrefValue = "";
        $this->kodeorder->TooltipValue = "";

        // nama_customer
        $this->nama_customer->LinkCustomAttributes = "";
        $this->nama_customer->HrefValue = "";
        $this->nama_customer->TooltipValue = "";

        // nominal
        $this->nominal->LinkCustomAttributes = "";
        $this->nominal->HrefValue = "";
        $this->nominal->TooltipValue = "";

        // nilai_po
        $this->nilai_po->LinkCustomAttributes = "";
        $this->nilai_po->HrefValue = "";
        $this->nilai_po->TooltipValue = "";

        // pembayaran
        $this->pembayaran->LinkCustomAttributes = "";
        $this->pembayaran->HrefValue = "";
        $this->pembayaran->TooltipValue = "";

        // nilai_faktur
        $this->nilai_faktur->LinkCustomAttributes = "";
        $this->nilai_faktur->HrefValue = "";
        $this->nilai_faktur->TooltipValue = "";

        // piutang
        $this->piutang->LinkCustomAttributes = "";
        $this->piutang->HrefValue = "";
        $this->piutang->TooltipValue = "";

        // nomor_handphone
        $this->nomor_handphone->LinkCustomAttributes = "";
        $this->nomor_handphone->HrefValue = "";
        $this->nomor_handphone->TooltipValue = "";

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

        // tgl_order
        $this->tgl_order->EditAttrs["class"] = "form-control";
        $this->tgl_order->EditCustomAttributes = "";
        $this->tgl_order->EditValue = FormatDateTime($this->tgl_order->CurrentValue, 8);
        $this->tgl_order->PlaceHolder = RemoveHtml($this->tgl_order->caption());

        // tgl_reminder
        $this->tgl_reminder->EditAttrs["class"] = "form-control";
        $this->tgl_reminder->EditCustomAttributes = "";
        $this->tgl_reminder->EditValue = FormatDateTime($this->tgl_reminder->CurrentValue, 8);
        $this->tgl_reminder->PlaceHolder = RemoveHtml($this->tgl_reminder->caption());

        // tgl_normalbilling
        $this->tgl_normalbilling->EditAttrs["class"] = "form-control";
        $this->tgl_normalbilling->EditCustomAttributes = "";
        $this->tgl_normalbilling->EditValue = FormatDateTime($this->tgl_normalbilling->CurrentValue, 8);
        $this->tgl_normalbilling->PlaceHolder = RemoveHtml($this->tgl_normalbilling->caption());

        // tgl_jatuhtempo
        $this->tgl_jatuhtempo->EditAttrs["class"] = "form-control";
        $this->tgl_jatuhtempo->EditCustomAttributes = "";
        $this->tgl_jatuhtempo->EditValue = FormatDateTime($this->tgl_jatuhtempo->CurrentValue, 8);
        $this->tgl_jatuhtempo->PlaceHolder = RemoveHtml($this->tgl_jatuhtempo->caption());

        // tgl_intensbilling
        $this->tgl_intensbilling->EditAttrs["class"] = "form-control";
        $this->tgl_intensbilling->EditCustomAttributes = "";
        $this->tgl_intensbilling->EditValue = FormatDateTime($this->tgl_intensbilling->CurrentValue, 8);
        $this->tgl_intensbilling->PlaceHolder = RemoveHtml($this->tgl_intensbilling->caption());

        // tgl_actionplan
        $this->tgl_actionplan->EditAttrs["class"] = "form-control";
        $this->tgl_actionplan->EditCustomAttributes = "";
        $this->tgl_actionplan->EditValue = FormatDateTime($this->tgl_actionplan->CurrentValue, 8);
        $this->tgl_actionplan->PlaceHolder = RemoveHtml($this->tgl_actionplan->caption());

        // kodeorder
        $this->kodeorder->EditAttrs["class"] = "form-control";
        $this->kodeorder->EditCustomAttributes = "";
        if (!$this->kodeorder->Raw) {
            $this->kodeorder->CurrentValue = HtmlDecode($this->kodeorder->CurrentValue);
        }
        $this->kodeorder->EditValue = $this->kodeorder->CurrentValue;
        $this->kodeorder->PlaceHolder = RemoveHtml($this->kodeorder->caption());

        // nama_customer
        $this->nama_customer->EditAttrs["class"] = "form-control";
        $this->nama_customer->EditCustomAttributes = "";
        if (!$this->nama_customer->Raw) {
            $this->nama_customer->CurrentValue = HtmlDecode($this->nama_customer->CurrentValue);
        }
        $this->nama_customer->EditValue = $this->nama_customer->CurrentValue;
        $this->nama_customer->PlaceHolder = RemoveHtml($this->nama_customer->caption());

        // nominal
        $this->nominal->EditAttrs["class"] = "form-control";
        $this->nominal->EditCustomAttributes = "";
        $this->nominal->EditValue = $this->nominal->CurrentValue;
        $this->nominal->PlaceHolder = RemoveHtml($this->nominal->caption());
        if (strval($this->nominal->EditValue) != "" && is_numeric($this->nominal->EditValue)) {
            $this->nominal->EditValue = FormatNumber($this->nominal->EditValue, -2, -2, -2, -2);
        }

        // nilai_po
        $this->nilai_po->EditAttrs["class"] = "form-control";
        $this->nilai_po->EditCustomAttributes = "";
        $this->nilai_po->EditValue = $this->nilai_po->CurrentValue;
        $this->nilai_po->PlaceHolder = RemoveHtml($this->nilai_po->caption());
        if (strval($this->nilai_po->EditValue) != "" && is_numeric($this->nilai_po->EditValue)) {
            $this->nilai_po->EditValue = FormatNumber($this->nilai_po->EditValue, -2, -2, -2, -2);
        }

        // pembayaran
        $this->pembayaran->EditAttrs["class"] = "form-control";
        $this->pembayaran->EditCustomAttributes = "";
        $this->pembayaran->EditValue = $this->pembayaran->CurrentValue;
        $this->pembayaran->PlaceHolder = RemoveHtml($this->pembayaran->caption());
        if (strval($this->pembayaran->EditValue) != "" && is_numeric($this->pembayaran->EditValue)) {
            $this->pembayaran->EditValue = FormatNumber($this->pembayaran->EditValue, -2, -2, -2, -2);
        }

        // nilai_faktur
        $this->nilai_faktur->EditAttrs["class"] = "form-control";
        $this->nilai_faktur->EditCustomAttributes = "";
        $this->nilai_faktur->EditValue = $this->nilai_faktur->CurrentValue;
        $this->nilai_faktur->PlaceHolder = RemoveHtml($this->nilai_faktur->caption());
        if (strval($this->nilai_faktur->EditValue) != "" && is_numeric($this->nilai_faktur->EditValue)) {
            $this->nilai_faktur->EditValue = FormatNumber($this->nilai_faktur->EditValue, -2, -2, -2, -2);
        }

        // piutang
        $this->piutang->EditAttrs["class"] = "form-control";
        $this->piutang->EditCustomAttributes = "";
        $this->piutang->EditValue = $this->piutang->CurrentValue;
        $this->piutang->PlaceHolder = RemoveHtml($this->piutang->caption());
        if (strval($this->piutang->EditValue) != "" && is_numeric($this->piutang->EditValue)) {
            $this->piutang->EditValue = FormatNumber($this->piutang->EditValue, -2, -2, -2, -2);
        }

        // nomor_handphone
        $this->nomor_handphone->EditAttrs["class"] = "form-control";
        $this->nomor_handphone->EditCustomAttributes = "";
        if (!$this->nomor_handphone->Raw) {
            $this->nomor_handphone->CurrentValue = HtmlDecode($this->nomor_handphone->CurrentValue);
        }
        $this->nomor_handphone->EditValue = $this->nomor_handphone->CurrentValue;
        $this->nomor_handphone->PlaceHolder = RemoveHtml($this->nomor_handphone->caption());

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
                    $doc->exportCaption($this->tgl_order);
                    $doc->exportCaption($this->tgl_reminder);
                    $doc->exportCaption($this->tgl_normalbilling);
                    $doc->exportCaption($this->tgl_jatuhtempo);
                    $doc->exportCaption($this->tgl_intensbilling);
                    $doc->exportCaption($this->tgl_actionplan);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->nama_customer);
                    $doc->exportCaption($this->nominal);
                    $doc->exportCaption($this->nilai_po);
                    $doc->exportCaption($this->pembayaran);
                    $doc->exportCaption($this->nilai_faktur);
                    $doc->exportCaption($this->piutang);
                    $doc->exportCaption($this->nomor_handphone);
                } else {
                    $doc->exportCaption($this->tgl_order);
                    $doc->exportCaption($this->tgl_reminder);
                    $doc->exportCaption($this->tgl_normalbilling);
                    $doc->exportCaption($this->tgl_jatuhtempo);
                    $doc->exportCaption($this->tgl_intensbilling);
                    $doc->exportCaption($this->tgl_actionplan);
                    $doc->exportCaption($this->kodeorder);
                    $doc->exportCaption($this->nama_customer);
                    $doc->exportCaption($this->nominal);
                    $doc->exportCaption($this->nilai_po);
                    $doc->exportCaption($this->pembayaran);
                    $doc->exportCaption($this->nilai_faktur);
                    $doc->exportCaption($this->piutang);
                    $doc->exportCaption($this->nomor_handphone);
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
                        $doc->exportField($this->tgl_order);
                        $doc->exportField($this->tgl_reminder);
                        $doc->exportField($this->tgl_normalbilling);
                        $doc->exportField($this->tgl_jatuhtempo);
                        $doc->exportField($this->tgl_intensbilling);
                        $doc->exportField($this->tgl_actionplan);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->nama_customer);
                        $doc->exportField($this->nominal);
                        $doc->exportField($this->nilai_po);
                        $doc->exportField($this->pembayaran);
                        $doc->exportField($this->nilai_faktur);
                        $doc->exportField($this->piutang);
                        $doc->exportField($this->nomor_handphone);
                    } else {
                        $doc->exportField($this->tgl_order);
                        $doc->exportField($this->tgl_reminder);
                        $doc->exportField($this->tgl_normalbilling);
                        $doc->exportField($this->tgl_jatuhtempo);
                        $doc->exportField($this->tgl_intensbilling);
                        $doc->exportField($this->tgl_actionplan);
                        $doc->exportField($this->kodeorder);
                        $doc->exportField($this->nama_customer);
                        $doc->exportField($this->nominal);
                        $doc->exportField($this->nilai_po);
                        $doc->exportField($this->pembayaran);
                        $doc->exportField($this->nilai_faktur);
                        $doc->exportField($this->piutang);
                        $doc->exportField($this->nomor_handphone);
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
