<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for stock_deliveryorder_detail
 */
class StockDeliveryorderDetail extends DbTable
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
    public $pid;
    public $idstockorder;
    public $idstockorder_detail;
    public $totalorder;
    public $sisa;
    public $jumlahkirim;
    public $keterangan;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'stock_deliveryorder_detail';
        $this->TableName = 'stock_deliveryorder_detail';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`stock_deliveryorder_detail`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = false; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // pid
        $this->pid = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_pid', 'pid', '`pid`', '`pid`', 20, 20, -1, false, '`pid`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pid->IsForeignKey = true; // Foreign key field
        $this->pid->Nullable = false; // NOT NULL field
        $this->pid->Required = true; // Required field
        $this->pid->Sortable = false; // Allow sort
        $this->pid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pid->Param, "CustomMsg");
        $this->Fields['pid'] = &$this->pid;

        // idstockorder
        $this->idstockorder = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_idstockorder', 'idstockorder', '`idstockorder`', '`idstockorder`', 20, 20, -1, false, '`idstockorder`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idstockorder->Nullable = false; // NOT NULL field
        $this->idstockorder->Required = true; // Required field
        $this->idstockorder->Sortable = true; // Allow sort
        $this->idstockorder->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idstockorder->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idstockorder->Lookup = new Lookup('idstockorder', 'v_stockorder', false, 'id', ["kode","tanggal","",""], [], ["x_idstockorder_detail"], [], [], [], [], '', '');
                break;
            default:
                $this->idstockorder->Lookup = new Lookup('idstockorder', 'v_stockorder', false, 'id', ["kode","tanggal","",""], [], ["x_idstockorder_detail"], [], [], [], [], '', '');
                break;
        }
        $this->idstockorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idstockorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idstockorder->Param, "CustomMsg");
        $this->Fields['idstockorder'] = &$this->idstockorder;

        // idstockorder_detail
        $this->idstockorder_detail = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_idstockorder_detail', 'idstockorder_detail', '`idstockorder_detail`', '`idstockorder_detail`', 20, 20, -1, false, '`idstockorder_detail`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idstockorder_detail->Nullable = false; // NOT NULL field
        $this->idstockorder_detail->Required = true; // Required field
        $this->idstockorder_detail->Sortable = true; // Allow sort
        $this->idstockorder_detail->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idstockorder_detail->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idstockorder_detail->Lookup = new Lookup('idstockorder_detail', 'v_stockorder_detail', false, 'idstockorder_detail', ["kode_produk","nama_produk","",""], ["x_idstockorder"], [], ["idstockorder"], ["x_idstockorder"], ["jumlah_order","sisa_order"], ["x_totalorder","x_sisa"], '', '');
                break;
            default:
                $this->idstockorder_detail->Lookup = new Lookup('idstockorder_detail', 'v_stockorder_detail', false, 'idstockorder_detail', ["kode_produk","nama_produk","",""], ["x_idstockorder"], [], ["idstockorder"], ["x_idstockorder"], ["jumlah_order","sisa_order"], ["x_totalorder","x_sisa"], '', '');
                break;
        }
        $this->idstockorder_detail->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idstockorder_detail->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idstockorder_detail->Param, "CustomMsg");
        $this->Fields['idstockorder_detail'] = &$this->idstockorder_detail;

        // totalorder
        $this->totalorder = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_totalorder', 'totalorder', '`totalorder`', '`totalorder`', 3, 11, -1, false, '`totalorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totalorder->Nullable = false; // NOT NULL field
        $this->totalorder->Required = true; // Required field
        $this->totalorder->Sortable = true; // Allow sort
        $this->totalorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->totalorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totalorder->Param, "CustomMsg");
        $this->Fields['totalorder'] = &$this->totalorder;

        // sisa
        $this->sisa = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_sisa', 'sisa', '`sisa`', '`sisa`', 3, 11, -1, false, '`sisa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisa->Nullable = false; // NOT NULL field
        $this->sisa->Required = true; // Required field
        $this->sisa->Sortable = true; // Allow sort
        $this->sisa->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisa->Param, "CustomMsg");
        $this->Fields['sisa'] = &$this->sisa;

        // jumlahkirim
        $this->jumlahkirim = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_jumlahkirim', 'jumlahkirim', '`jumlahkirim`', '`jumlahkirim`', 3, 11, -1, false, '`jumlahkirim`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahkirim->Nullable = false; // NOT NULL field
        $this->jumlahkirim->Required = true; // Required field
        $this->jumlahkirim->Sortable = true; // Allow sort
        $this->jumlahkirim->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlahkirim->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahkirim->Param, "CustomMsg");
        $this->Fields['jumlahkirim'] = &$this->jumlahkirim;

        // keterangan
        $this->keterangan = new DbField('stock_deliveryorder_detail', 'stock_deliveryorder_detail', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, 65535, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;
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
        if ($this->getCurrentMasterTable() == "stock_deliveryorder") {
            if ($this->pid->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->pid->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "stock_deliveryorder") {
            if ($this->pid->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`pid`", $this->pid->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_stock_deliveryorder()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_stock_deliveryorder()
    {
        return "`pid`=@pid@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`stock_deliveryorder_detail`";
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
        $this->pid->DbValue = $row['pid'];
        $this->idstockorder->DbValue = $row['idstockorder'];
        $this->idstockorder_detail->DbValue = $row['idstockorder_detail'];
        $this->totalorder->DbValue = $row['totalorder'];
        $this->sisa->DbValue = $row['sisa'];
        $this->jumlahkirim->DbValue = $row['jumlahkirim'];
        $this->keterangan->DbValue = $row['keterangan'];
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
        return $_SESSION[$name] ?? GetUrl("StockDeliveryorderDetailList");
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
        if ($pageName == "StockDeliveryorderDetailView") {
            return $Language->phrase("View");
        } elseif ($pageName == "StockDeliveryorderDetailEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "StockDeliveryorderDetailAdd") {
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
                return "StockDeliveryorderDetailView";
            case Config("API_ADD_ACTION"):
                return "StockDeliveryorderDetailAdd";
            case Config("API_EDIT_ACTION"):
                return "StockDeliveryorderDetailEdit";
            case Config("API_DELETE_ACTION"):
                return "StockDeliveryorderDetailDelete";
            case Config("API_LIST_ACTION"):
                return "StockDeliveryorderDetailList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "StockDeliveryorderDetailList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("StockDeliveryorderDetailView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("StockDeliveryorderDetailView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "StockDeliveryorderDetailAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "StockDeliveryorderDetailAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("StockDeliveryorderDetailEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("StockDeliveryorderDetailAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("StockDeliveryorderDetailDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "stock_deliveryorder" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->pid->CurrentValue ?? $this->pid->getSessionValue());
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
        $this->pid->setDbValue($row['pid']);
        $this->idstockorder->setDbValue($row['idstockorder']);
        $this->idstockorder_detail->setDbValue($row['idstockorder_detail']);
        $this->totalorder->setDbValue($row['totalorder']);
        $this->sisa->setDbValue($row['sisa']);
        $this->jumlahkirim->setDbValue($row['jumlahkirim']);
        $this->keterangan->setDbValue($row['keterangan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // pid

        // idstockorder

        // idstockorder_detail

        // totalorder

        // sisa

        // jumlahkirim

        // keterangan

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // pid
        $this->pid->ViewValue = $this->pid->CurrentValue;
        $this->pid->ViewValue = FormatNumber($this->pid->ViewValue, 0, -2, -2, -2);
        $this->pid->ViewCustomAttributes = "";

        // idstockorder
        $curVal = trim(strval($this->idstockorder->CurrentValue));
        if ($curVal != "") {
            $this->idstockorder->ViewValue = $this->idstockorder->lookupCacheOption($curVal);
            if ($this->idstockorder->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" ) ? "totalsisa > 0" : "";;
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idstockorder->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idstockorder->Lookup->renderViewRow($rswrk[0]);
                    $this->idstockorder->ViewValue = $this->idstockorder->displayValue($arwrk);
                } else {
                    $this->idstockorder->ViewValue = $this->idstockorder->CurrentValue;
                }
            }
        } else {
            $this->idstockorder->ViewValue = null;
        }
        $this->idstockorder->ViewCustomAttributes = "";

        // idstockorder_detail
        $curVal = trim(strval($this->idstockorder_detail->CurrentValue));
        if ($curVal != "") {
            $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->lookupCacheOption($curVal);
            if ($this->idstockorder_detail->ViewValue === null) { // Lookup from database
                $filterWrk = "`idstockorder_detail`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" ) ? "sisa_order > 0" : "";;
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idstockorder_detail->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idstockorder_detail->Lookup->renderViewRow($rswrk[0]);
                    $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->displayValue($arwrk);
                } else {
                    $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->CurrentValue;
                }
            }
        } else {
            $this->idstockorder_detail->ViewValue = null;
        }
        $this->idstockorder_detail->ViewCustomAttributes = "";

        // totalorder
        $this->totalorder->ViewValue = $this->totalorder->CurrentValue;
        $this->totalorder->ViewValue = FormatNumber($this->totalorder->ViewValue, 0, -2, -2, -2);
        $this->totalorder->ViewCustomAttributes = "";

        // sisa
        $this->sisa->ViewValue = $this->sisa->CurrentValue;
        $this->sisa->ViewValue = FormatNumber($this->sisa->ViewValue, 0, -2, -2, -2);
        $this->sisa->ViewCustomAttributes = "";

        // jumlahkirim
        $this->jumlahkirim->ViewValue = $this->jumlahkirim->CurrentValue;
        $this->jumlahkirim->ViewValue = FormatNumber($this->jumlahkirim->ViewValue, 0, -2, -2, -2);
        $this->jumlahkirim->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // pid
        $this->pid->LinkCustomAttributes = "";
        $this->pid->HrefValue = "";
        $this->pid->TooltipValue = "";

        // idstockorder
        $this->idstockorder->LinkCustomAttributes = "";
        $this->idstockorder->HrefValue = "";
        $this->idstockorder->TooltipValue = "";

        // idstockorder_detail
        $this->idstockorder_detail->LinkCustomAttributes = "";
        $this->idstockorder_detail->HrefValue = "";
        $this->idstockorder_detail->TooltipValue = "";

        // totalorder
        $this->totalorder->LinkCustomAttributes = "";
        $this->totalorder->HrefValue = "";
        $this->totalorder->TooltipValue = "";

        // sisa
        $this->sisa->LinkCustomAttributes = "";
        $this->sisa->HrefValue = "";
        $this->sisa->TooltipValue = "";

        // jumlahkirim
        $this->jumlahkirim->LinkCustomAttributes = "";
        $this->jumlahkirim->HrefValue = "";
        $this->jumlahkirim->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

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

        // pid
        $this->pid->EditAttrs["class"] = "form-control";
        $this->pid->EditCustomAttributes = "";
        if ($this->pid->getSessionValue() != "") {
            $this->pid->CurrentValue = GetForeignKeyValue($this->pid->getSessionValue());
            $this->pid->ViewValue = $this->pid->CurrentValue;
            $this->pid->ViewValue = FormatNumber($this->pid->ViewValue, 0, -2, -2, -2);
            $this->pid->ViewCustomAttributes = "";
        } else {
            $this->pid->EditValue = $this->pid->CurrentValue;
            $this->pid->PlaceHolder = RemoveHtml($this->pid->caption());
        }

        // idstockorder
        $this->idstockorder->EditAttrs["class"] = "form-control";
        $this->idstockorder->EditCustomAttributes = "";
        $this->idstockorder->PlaceHolder = RemoveHtml($this->idstockorder->caption());

        // idstockorder_detail
        $this->idstockorder_detail->EditAttrs["class"] = "form-control";
        $this->idstockorder_detail->EditCustomAttributes = "";
        $this->idstockorder_detail->PlaceHolder = RemoveHtml($this->idstockorder_detail->caption());

        // totalorder
        $this->totalorder->EditAttrs["class"] = "form-control";
        $this->totalorder->EditCustomAttributes = "readonly";
        $this->totalorder->EditValue = $this->totalorder->CurrentValue;
        $this->totalorder->EditValue = FormatNumber($this->totalorder->EditValue, 0, -2, -2, -2);
        $this->totalorder->ViewCustomAttributes = "";

        // sisa
        $this->sisa->EditAttrs["class"] = "form-control";
        $this->sisa->EditCustomAttributes = "readonly";
        $this->sisa->EditValue = $this->sisa->CurrentValue;
        $this->sisa->PlaceHolder = RemoveHtml($this->sisa->caption());

        // jumlahkirim
        $this->jumlahkirim->EditAttrs["class"] = "form-control";
        $this->jumlahkirim->EditCustomAttributes = "";
        $this->jumlahkirim->EditValue = $this->jumlahkirim->CurrentValue;
        $this->jumlahkirim->PlaceHolder = RemoveHtml($this->jumlahkirim->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

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
                    $doc->exportCaption($this->idstockorder);
                    $doc->exportCaption($this->idstockorder_detail);
                    $doc->exportCaption($this->totalorder);
                    $doc->exportCaption($this->sisa);
                    $doc->exportCaption($this->jumlahkirim);
                    $doc->exportCaption($this->keterangan);
                } else {
                    $doc->exportCaption($this->idstockorder);
                    $doc->exportCaption($this->idstockorder_detail);
                    $doc->exportCaption($this->totalorder);
                    $doc->exportCaption($this->sisa);
                    $doc->exportCaption($this->jumlahkirim);
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
                        $doc->exportField($this->idstockorder);
                        $doc->exportField($this->idstockorder_detail);
                        $doc->exportField($this->totalorder);
                        $doc->exportField($this->sisa);
                        $doc->exportField($this->jumlahkirim);
                        $doc->exportField($this->keterangan);
                    } else {
                        $doc->exportField($this->idstockorder);
                        $doc->exportField($this->idstockorder_detail);
                        $doc->exportField($this->totalorder);
                        $doc->exportField($this->sisa);
                        $doc->exportField($this->jumlahkirim);
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
        // update sisa stock_order_detail
        ExecuteUpdate("UPDATE stock_order_detail SET sisa = sisa - {$rsnew['jumlahkirim']} WHERE id = {$rsnew['idstockorder_detail']}");

        // set stock_order processed
        ExecuteUpdate("UPDATE stock_order SET readonly = 1 WHERE id = {$rsnew['idstockorder']}");

        // insert to stok
        $idproduct = ExecuteScalar("SELECT idproduct FROM stock_order_detail WHERE id = {$rsnew['idstockorder_detail']}");
        stok_trx($rsnew['id'], 'stockdelivery-in', $idproduct, $rsnew['jumlahkirim'], 'masuk');
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
        //$idproduct = ExecuteScalar("SELECT idproduct FROM stock_order_detail WHERE id = {$rsnew['idstockorder_detail']}");
        //stok_trx($rsnew['id'], 'stockdelivery-in', $idproduct, $rsnew['jumlahkirim'], 'masuk');
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
        ExecuteUpdate("UPDATE stocks SET aktif = 0 WHERE prop_id = {$rs['id']} AND prop_code like '%stockdelivery-in%'");
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
