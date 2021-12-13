<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for deliveryorder_detail
 */
class DeliveryorderDetail extends DbTable
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
    public $iddeliveryorder;
    public $idorder;
    public $idorder_detail;
    public $totalorder;
    public $sisa;
    public $jumlahkirim;
    public $created_at;
    public $created_by;
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
        $this->TableVar = 'deliveryorder_detail';
        $this->TableName = 'deliveryorder_detail';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`deliveryorder_detail`";
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
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // iddeliveryorder
        $this->iddeliveryorder = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_iddeliveryorder', 'iddeliveryorder', '`iddeliveryorder`', '`iddeliveryorder`', 21, 20, -1, false, '`iddeliveryorder`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->iddeliveryorder->IsForeignKey = true; // Foreign key field
        $this->iddeliveryorder->Nullable = false; // NOT NULL field
        $this->iddeliveryorder->Required = true; // Required field
        $this->iddeliveryorder->Sortable = true; // Allow sort
        $this->iddeliveryorder->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->iddeliveryorder->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->iddeliveryorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->iddeliveryorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->iddeliveryorder->Param, "CustomMsg");
        $this->Fields['iddeliveryorder'] = &$this->iddeliveryorder;

        // idorder
        $this->idorder = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_idorder', 'idorder', '`idorder`', '`idorder`', 21, 20, -1, false, '`idorder`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idorder->Nullable = false; // NOT NULL field
        $this->idorder->Required = true; // Required field
        $this->idorder->Sortable = true; // Allow sort
        $this->idorder->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idorder->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idorder->Lookup = new Lookup('idorder', 'v_order_customer', false, 'idorder', ["kodeorder","namacustomer","",""], [], ["deliveryorder_detail x_idorder_detail"], [], [], [], [], '', '');
                break;
            default:
                $this->idorder->Lookup = new Lookup('idorder', 'v_order_customer', false, 'idorder', ["kodeorder","namacustomer","",""], [], ["deliveryorder_detail x_idorder_detail"], [], [], [], [], '', '');
                break;
        }
        $this->idorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idorder->Param, "CustomMsg");
        $this->Fields['idorder'] = &$this->idorder;

        // idorder_detail
        $this->idorder_detail = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_idorder_detail', 'idorder_detail', '`idorder_detail`', '`idorder_detail`', 21, 20, -1, false, '`idorder_detail`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idorder_detail->Nullable = false; // NOT NULL field
        $this->idorder_detail->Required = true; // Required field
        $this->idorder_detail->Sortable = true; // Allow sort
        $this->idorder_detail->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idorder_detail->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idorder_detail->Lookup = new Lookup('idorder_detail', 'v_orderdetail', false, 'id', ["nama","","",""], ["x_idorder"], [], ["idorder"], ["x_idorder"], ["totalorder","sisa"], ["x_totalorder","x_sisa"], '', '');
                break;
            default:
                $this->idorder_detail->Lookup = new Lookup('idorder_detail', 'v_orderdetail', false, 'id', ["nama","","",""], ["x_idorder"], [], ["idorder"], ["x_idorder"], ["totalorder","sisa"], ["x_totalorder","x_sisa"], '', '');
                break;
        }
        $this->idorder_detail->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idorder_detail->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idorder_detail->Param, "CustomMsg");
        $this->Fields['idorder_detail'] = &$this->idorder_detail;

        // totalorder
        $this->totalorder = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_totalorder', 'totalorder', '`totalorder`', '`totalorder`', 3, 11, -1, false, '`totalorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totalorder->Nullable = false; // NOT NULL field
        $this->totalorder->Required = true; // Required field
        $this->totalorder->Sortable = true; // Allow sort
        $this->totalorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->totalorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totalorder->Param, "CustomMsg");
        $this->Fields['totalorder'] = &$this->totalorder;

        // sisa
        $this->sisa = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_sisa', 'sisa', '`sisa`', '`sisa`', 3, 11, -1, false, '`sisa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisa->Nullable = false; // NOT NULL field
        $this->sisa->Required = true; // Required field
        $this->sisa->Sortable = true; // Allow sort
        $this->sisa->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisa->Param, "CustomMsg");
        $this->Fields['sisa'] = &$this->sisa;

        // jumlahkirim
        $this->jumlahkirim = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_jumlahkirim', 'jumlahkirim', '`jumlahkirim`', '`jumlahkirim`', 19, 11, -1, false, '`jumlahkirim`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahkirim->Nullable = false; // NOT NULL field
        $this->jumlahkirim->Required = true; // Required field
        $this->jumlahkirim->Sortable = true; // Allow sort
        $this->jumlahkirim->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlahkirim->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahkirim->Param, "CustomMsg");
        $this->Fields['jumlahkirim'] = &$this->jumlahkirim;

        // created_at
        $this->created_at = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // created_by
        $this->created_by = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_by->Param, "CustomMsg");
        $this->Fields['created_by'] = &$this->created_by;

        // readonly
        $this->readonly = new DbField('deliveryorder_detail', 'deliveryorder_detail', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = false; // Allow sort
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
        if ($this->getCurrentMasterTable() == "deliveryorder") {
            if ($this->iddeliveryorder->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->iddeliveryorder->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "deliveryorder") {
            if ($this->iddeliveryorder->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`iddeliveryorder`", $this->iddeliveryorder->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_deliveryorder()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_deliveryorder()
    {
        return "`iddeliveryorder`=@iddeliveryorder@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`deliveryorder_detail`";
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
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $filter = $this->addUserIDFilter($filter);
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
        $this->iddeliveryorder->DbValue = $row['iddeliveryorder'];
        $this->idorder->DbValue = $row['idorder'];
        $this->idorder_detail->DbValue = $row['idorder_detail'];
        $this->totalorder->DbValue = $row['totalorder'];
        $this->sisa->DbValue = $row['sisa'];
        $this->jumlahkirim->DbValue = $row['jumlahkirim'];
        $this->created_at->DbValue = $row['created_at'];
        $this->created_by->DbValue = $row['created_by'];
        $this->readonly->DbValue = $row['readonly'];
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
        return $_SESSION[$name] ?? GetUrl("DeliveryorderDetailList");
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
        if ($pageName == "DeliveryorderDetailView") {
            return $Language->phrase("View");
        } elseif ($pageName == "DeliveryorderDetailEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "DeliveryorderDetailAdd") {
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
                return "DeliveryorderDetailView";
            case Config("API_ADD_ACTION"):
                return "DeliveryorderDetailAdd";
            case Config("API_EDIT_ACTION"):
                return "DeliveryorderDetailEdit";
            case Config("API_DELETE_ACTION"):
                return "DeliveryorderDetailDelete";
            case Config("API_LIST_ACTION"):
                return "DeliveryorderDetailList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "DeliveryorderDetailList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("DeliveryorderDetailView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("DeliveryorderDetailView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "DeliveryorderDetailAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "DeliveryorderDetailAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("DeliveryorderDetailEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("DeliveryorderDetailAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("DeliveryorderDetailDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "deliveryorder" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->iddeliveryorder->CurrentValue ?? $this->iddeliveryorder->getSessionValue());
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
        $this->iddeliveryorder->setDbValue($row['iddeliveryorder']);
        $this->idorder->setDbValue($row['idorder']);
        $this->idorder_detail->setDbValue($row['idorder_detail']);
        $this->totalorder->setDbValue($row['totalorder']);
        $this->sisa->setDbValue($row['sisa']);
        $this->jumlahkirim->setDbValue($row['jumlahkirim']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
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

        // iddeliveryorder

        // idorder

        // idorder_detail

        // totalorder

        // sisa

        // jumlahkirim

        // created_at

        // created_by

        // readonly
        $this->readonly->CellCssStyle = "white-space: nowrap;";

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // iddeliveryorder
        $this->iddeliveryorder->ViewValue = FormatNumber($this->iddeliveryorder->ViewValue, 0, -2, -2, -2);
        $this->iddeliveryorder->ViewCustomAttributes = "";

        // idorder
        $curVal = trim(strval($this->idorder->CurrentValue));
        if ($curVal != "") {
            $this->idorder->ViewValue = $this->idorder->lookupCacheOption($curVal);
            if ($this->idorder->ViewValue === null) { // Lookup from database
                $filterWrk = "`idorder`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" ) ? "aktif = 1" : "";;
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idorder->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idorder->Lookup->renderViewRow($rswrk[0]);
                    $this->idorder->ViewValue = $this->idorder->displayValue($arwrk);
                } else {
                    $this->idorder->ViewValue = $this->idorder->CurrentValue;
                }
            }
        } else {
            $this->idorder->ViewValue = null;
        }
        $this->idorder->ViewCustomAttributes = "";

        // idorder_detail
        $curVal = trim(strval($this->idorder_detail->CurrentValue));
        if ($curVal != "") {
            $this->idorder_detail->ViewValue = $this->idorder_detail->lookupCacheOption($curVal);
            if ($this->idorder_detail->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" ) ? "aktif = 1" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idorder_detail->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idorder_detail->Lookup->renderViewRow($rswrk[0]);
                    $this->idorder_detail->ViewValue = $this->idorder_detail->displayValue($arwrk);
                } else {
                    $this->idorder_detail->ViewValue = $this->idorder_detail->CurrentValue;
                }
            }
        } else {
            $this->idorder_detail->ViewValue = null;
        }
        $this->idorder_detail->ViewCustomAttributes = "";

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

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // created_by
        $this->created_by->ViewValue = $this->created_by->CurrentValue;
        $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
        $this->created_by->ViewCustomAttributes = "";

        // readonly
        $this->readonly->ViewValue = $this->readonly->CurrentValue;
        $this->readonly->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // iddeliveryorder
        $this->iddeliveryorder->LinkCustomAttributes = "";
        $this->iddeliveryorder->HrefValue = "";
        $this->iddeliveryorder->TooltipValue = "";

        // idorder
        $this->idorder->LinkCustomAttributes = "";
        $this->idorder->HrefValue = "";
        $this->idorder->TooltipValue = "";

        // idorder_detail
        $this->idorder_detail->LinkCustomAttributes = "";
        $this->idorder_detail->HrefValue = "";
        $this->idorder_detail->TooltipValue = "";

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

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // created_by
        $this->created_by->LinkCustomAttributes = "";
        $this->created_by->HrefValue = "";
        $this->created_by->TooltipValue = "";

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

        // iddeliveryorder
        $this->iddeliveryorder->EditAttrs["class"] = "form-control";
        $this->iddeliveryorder->EditCustomAttributes = "";
        if ($this->iddeliveryorder->getSessionValue() != "") {
            $this->iddeliveryorder->CurrentValue = GetForeignKeyValue($this->iddeliveryorder->getSessionValue());
            $this->iddeliveryorder->ViewValue = FormatNumber($this->iddeliveryorder->ViewValue, 0, -2, -2, -2);
            $this->iddeliveryorder->ViewCustomAttributes = "";
        } else {
            $this->iddeliveryorder->PlaceHolder = RemoveHtml($this->iddeliveryorder->caption());
        }

        // idorder
        $this->idorder->EditAttrs["class"] = "form-control";
        $this->idorder->EditCustomAttributes = "";
        $this->idorder->PlaceHolder = RemoveHtml($this->idorder->caption());

        // idorder_detail
        $this->idorder_detail->EditAttrs["class"] = "form-control";
        $this->idorder_detail->EditCustomAttributes = "";
        $this->idorder_detail->PlaceHolder = RemoveHtml($this->idorder_detail->caption());

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

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";

        // readonly
        $this->readonly->EditAttrs["class"] = "form-control";
        $this->readonly->EditCustomAttributes = "";

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
                    $doc->exportCaption($this->idorder);
                    $doc->exportCaption($this->idorder_detail);
                    $doc->exportCaption($this->totalorder);
                    $doc->exportCaption($this->sisa);
                    $doc->exportCaption($this->jumlahkirim);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->iddeliveryorder);
                    $doc->exportCaption($this->idorder);
                    $doc->exportCaption($this->idorder_detail);
                    $doc->exportCaption($this->totalorder);
                    $doc->exportCaption($this->sisa);
                    $doc->exportCaption($this->jumlahkirim);
                    $doc->exportCaption($this->created_at);
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
                        $doc->exportField($this->idorder);
                        $doc->exportField($this->idorder_detail);
                        $doc->exportField($this->totalorder);
                        $doc->exportField($this->sisa);
                        $doc->exportField($this->jumlahkirim);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->iddeliveryorder);
                        $doc->exportField($this->idorder);
                        $doc->exportField($this->idorder_detail);
                        $doc->exportField($this->totalorder);
                        $doc->exportField($this->sisa);
                        $doc->exportField($this->jumlahkirim);
                        $doc->exportField($this->created_at);
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

    // Add User ID filter
    public function addUserIDFilter($filter = "")
    {
        global $Security;
        $filterWrk = "";
        $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '`created_by` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM `deliveryorder_detail`";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        if ($rs = Conn($UserTable->Dbid)->executeQuery($sql)->fetchAll(\PDO::FETCH_NUM)) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
    }

    // Add master User ID filter
    public function addMasterUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "deliveryorder") {
            $filterWrk = Container("deliveryorder")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "deliveryorder") {
            $mastertable = Container("deliveryorder");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->iddeliveryorder, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        return $filterWrk;
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

        // update sisa order detail
        $myResult = ExecuteUpdate("UPDATE order_detail SET sisa=sisa-(".$rsnew['jumlahkirim'].") WHERE id=".$rsnew['idorder_detail']);

        // tambah stock
        addStock($rsnew['idorder_detail'], $rsnew['jumlahkirim']);

        // check untuk close order
        checkCloseOrder($rsnew['idorder_detail']);
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        // jadikan order & order detail readonly
        checkReadOnly("order_detail", $rsnew['idorder_detail']);
        checkReadOnly("order", $rsnew['idorder']);
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false

        // update sisa order detail
        $myResult = ExecuteUpdate("UPDATE order_detail SET sisa=sisa+(".($rsold['jumlahkirim']-$rsnew['jumlahkirim']).") WHERE id=".$rsold['idorder_detail']);

        // update stock
        addStock($rsold['idorder_detail'], ($rsnew['jumlahkirim']-$rsold['jumlahkirim']));

        // check close order
        checkCloseOrder($rsold['idorder_detail']);
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

        // update sisa order detail
        $myResult = ExecuteUpdate("UPDATE order_detail SET sisa=sisa+(".$rs['jumlahkirim'].") WHERE id=".$rs['idorder_detail']);

        // update stock
        addStock($rs['idorder_detail'], -($rs['jumlahkirim']));

        // check untuk close order
        checkCloseOrder($rs['idorder_detail']);
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        // check readOnly order detail dan order
        checkReadOnly("order_detail", $rs['idorder_detail']);
        checkReadOnly("order", $rs['idorder']);
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
