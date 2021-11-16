<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for suratjalan
 */
class Suratjalan extends DbTable
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
    public $tglsurat;
    public $tglkirim;
    public $idcustomer;
    public $idalamat_customer;
    public $keterangan;
    public $created_at;
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
        $this->TableVar = 'suratjalan';
        $this->TableName = 'suratjalan';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`suratjalan`";
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
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('suratjalan', 'suratjalan', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // kode
        $this->kode = new DbField('suratjalan', 'suratjalan', 'x_kode', 'kode', '`kode`', '`kode`', 200, 50, -1, false, '`kode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode->Nullable = false; // NOT NULL field
        $this->kode->Required = true; // Required field
        $this->kode->Sortable = true; // Allow sort
        $this->kode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode->Param, "CustomMsg");
        $this->Fields['kode'] = &$this->kode;

        // tglsurat
        $this->tglsurat = new DbField('suratjalan', 'suratjalan', 'x_tglsurat', 'tglsurat', '`tglsurat`', CastDateFieldForLike("`tglsurat`", 0, "DB"), 135, 19, 0, false, '`tglsurat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglsurat->Nullable = false; // NOT NULL field
        $this->tglsurat->Required = true; // Required field
        $this->tglsurat->Sortable = true; // Allow sort
        $this->tglsurat->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglsurat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglsurat->Param, "CustomMsg");
        $this->Fields['tglsurat'] = &$this->tglsurat;

        // tglkirim
        $this->tglkirim = new DbField('suratjalan', 'suratjalan', 'x_tglkirim', 'tglkirim', '`tglkirim`', CastDateFieldForLike("`tglkirim`", 0, "DB"), 135, 19, 0, false, '`tglkirim`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglkirim->Nullable = false; // NOT NULL field
        $this->tglkirim->Required = true; // Required field
        $this->tglkirim->Sortable = true; // Allow sort
        $this->tglkirim->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglkirim->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglkirim->Param, "CustomMsg");
        $this->Fields['tglkirim'] = &$this->tglkirim;

        // idcustomer
        $this->idcustomer = new DbField('suratjalan', 'suratjalan', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idcustomer->Nullable = false; // NOT NULL field
        $this->idcustomer->Required = true; // Required field
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idcustomer->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], [], ["x_idalamat_customer","suratjalan_detail x_idinvoice"], [], [], [], [], '', '');
                break;
            default:
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], [], ["x_idalamat_customer","suratjalan_detail x_idinvoice"], [], [], [], [], '', '');
                break;
        }
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // idalamat_customer
        $this->idalamat_customer = new DbField('suratjalan', 'suratjalan', 'x_idalamat_customer', 'idalamat_customer', '`idalamat_customer`', '`idalamat_customer`', 3, 11, -1, false, '`idalamat_customer`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idalamat_customer->Nullable = false; // NOT NULL field
        $this->idalamat_customer->Required = true; // Required field
        $this->idalamat_customer->Sortable = true; // Allow sort
        $this->idalamat_customer->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idalamat_customer->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idalamat_customer->Lookup = new Lookup('idalamat_customer', 'alamat_customer', false, 'id', ["alias","","",""], ["x_idcustomer"], [], ["idcustomer"], ["x_idcustomer"], [], [], '', '');
                break;
            default:
                $this->idalamat_customer->Lookup = new Lookup('idalamat_customer', 'alamat_customer', false, 'id', ["alias","","",""], ["x_idcustomer"], [], ["idcustomer"], ["x_idcustomer"], [], [], '', '');
                break;
        }
        $this->idalamat_customer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idalamat_customer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idalamat_customer->Param, "CustomMsg");
        $this->Fields['idalamat_customer'] = &$this->idalamat_customer;

        // keterangan
        $this->keterangan = new DbField('suratjalan', 'suratjalan', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, 255, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // created_at
        $this->created_at = new DbField('suratjalan', 'suratjalan', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // created_by
        $this->created_by = new DbField('suratjalan', 'suratjalan', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
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
        if ($this->getCurrentDetailTable() == "suratjalan_detail") {
            $detailUrl = Container("suratjalan_detail")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "SuratjalanList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`suratjalan`";
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
        $this->kode->DbValue = $row['kode'];
        $this->tglsurat->DbValue = $row['tglsurat'];
        $this->tglkirim->DbValue = $row['tglkirim'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->idalamat_customer->DbValue = $row['idalamat_customer'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->created_at->DbValue = $row['created_at'];
        $this->created_by->DbValue = $row['created_by'];
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
        return $_SESSION[$name] ?? GetUrl("SuratjalanList");
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
        if ($pageName == "SuratjalanView") {
            return $Language->phrase("View");
        } elseif ($pageName == "SuratjalanEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "SuratjalanAdd") {
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
                return "SuratjalanView";
            case Config("API_ADD_ACTION"):
                return "SuratjalanAdd";
            case Config("API_EDIT_ACTION"):
                return "SuratjalanEdit";
            case Config("API_DELETE_ACTION"):
                return "SuratjalanDelete";
            case Config("API_LIST_ACTION"):
                return "SuratjalanList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "SuratjalanList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SuratjalanView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SuratjalanView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "SuratjalanAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "SuratjalanAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SuratjalanEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SuratjalanEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("SuratjalanAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SuratjalanAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("SuratjalanDelete", $this->getUrlParm());
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
        $this->kode->setDbValue($row['kode']);
        $this->tglsurat->setDbValue($row['tglsurat']);
        $this->tglkirim->setDbValue($row['tglkirim']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idalamat_customer->setDbValue($row['idalamat_customer']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->created_at->setDbValue($row['created_at']);
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

        // tglsurat

        // tglkirim

        // idcustomer

        // idalamat_customer

        // keterangan

        // created_at

        // created_by

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // kode
        $this->kode->ViewValue = $this->kode->CurrentValue;
        $this->kode->ViewCustomAttributes = "";

        // tglsurat
        $this->tglsurat->ViewValue = $this->tglsurat->CurrentValue;
        $this->tglsurat->ViewValue = FormatDateTime($this->tglsurat->ViewValue, 0);
        $this->tglsurat->ViewCustomAttributes = "";

        // tglkirim
        $this->tglkirim->ViewValue = $this->tglkirim->CurrentValue;
        $this->tglkirim->ViewValue = FormatDateTime($this->tglkirim->ViewValue, 0);
        $this->tglkirim->ViewCustomAttributes = "";

        // idcustomer
        $curVal = trim(strval($this->idcustomer->CurrentValue));
        if ($curVal != "") {
            $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
            if ($this->idcustomer->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add") ? "id IN (SELECT idcustomer FROM invoice WHERE sent = 0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                    $this->idcustomer->ViewValue = $this->idcustomer->displayValue($arwrk);
                } else {
                    $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
                }
            }
        } else {
            $this->idcustomer->ViewValue = null;
        }
        $this->idcustomer->ViewCustomAttributes = "";

        // idalamat_customer
        $curVal = trim(strval($this->idalamat_customer->CurrentValue));
        if ($curVal != "") {
            $this->idalamat_customer->ViewValue = $this->idalamat_customer->lookupCacheOption($curVal);
            if ($this->idalamat_customer->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idalamat_customer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idalamat_customer->Lookup->renderViewRow($rswrk[0]);
                    $this->idalamat_customer->ViewValue = $this->idalamat_customer->displayValue($arwrk);
                } else {
                    $this->idalamat_customer->ViewValue = $this->idalamat_customer->CurrentValue;
                }
            }
        } else {
            $this->idalamat_customer->ViewValue = null;
        }
        $this->idalamat_customer->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

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

        // tglsurat
        $this->tglsurat->LinkCustomAttributes = "";
        $this->tglsurat->HrefValue = "";
        $this->tglsurat->TooltipValue = "";

        // tglkirim
        $this->tglkirim->LinkCustomAttributes = "";
        $this->tglkirim->HrefValue = "";
        $this->tglkirim->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // idalamat_customer
        $this->idalamat_customer->LinkCustomAttributes = "";
        $this->idalamat_customer->HrefValue = "";
        $this->idalamat_customer->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

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
        $this->kode->EditValue = $this->kode->CurrentValue;
        $this->kode->ViewCustomAttributes = "";

        // tglsurat
        $this->tglsurat->EditAttrs["class"] = "form-control";
        $this->tglsurat->EditCustomAttributes = "";
        $this->tglsurat->EditValue = FormatDateTime($this->tglsurat->CurrentValue, 8);
        $this->tglsurat->PlaceHolder = RemoveHtml($this->tglsurat->caption());

        // tglkirim
        $this->tglkirim->EditAttrs["class"] = "form-control";
        $this->tglkirim->EditCustomAttributes = "";
        $this->tglkirim->EditValue = FormatDateTime($this->tglkirim->CurrentValue, 8);
        $this->tglkirim->PlaceHolder = RemoveHtml($this->tglkirim->caption());

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        $curVal = trim(strval($this->idcustomer->CurrentValue));
        if ($curVal != "") {
            $this->idcustomer->EditValue = $this->idcustomer->lookupCacheOption($curVal);
            if ($this->idcustomer->EditValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add") ? "id IN (SELECT idcustomer FROM invoice WHERE sent = 0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                    $this->idcustomer->EditValue = $this->idcustomer->displayValue($arwrk);
                } else {
                    $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
                }
            }
        } else {
            $this->idcustomer->EditValue = null;
        }
        $this->idcustomer->ViewCustomAttributes = "";

        // idalamat_customer
        $this->idalamat_customer->EditAttrs["class"] = "form-control";
        $this->idalamat_customer->EditCustomAttributes = "";
        $this->idalamat_customer->PlaceHolder = RemoveHtml($this->idalamat_customer->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

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
                    $doc->exportCaption($this->tglsurat);
                    $doc->exportCaption($this->tglkirim);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idalamat_customer);
                    $doc->exportCaption($this->keterangan);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->tglsurat);
                    $doc->exportCaption($this->tglkirim);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idalamat_customer);
                    $doc->exportCaption($this->keterangan);
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
                        $doc->exportField($this->kode);
                        $doc->exportField($this->tglsurat);
                        $doc->exportField($this->tglkirim);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idalamat_customer);
                        $doc->exportField($this->keterangan);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->tglsurat);
                        $doc->exportField($this->tglkirim);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idalamat_customer);
                        $doc->exportField($this->keterangan);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `suratjalan`";
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
        $rsnew['kode'] = getNextKode('suratjalan', 0);
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
        $query = ExecuteQuery("select * from suratjalan_detail where idsuratjalan=".$rs['id']);
        $children = $query->fetchAll();
        foreach ($children as $item) {
        	$update = ExecuteUpdate("UPDATE invoice SET sent=0 WHERE id=".$item['idinvoice']);
        }
        $delete = ExecuteUpdate("DELETE FROM suratjalan_detail WHERE idsuratjalan=".$rs['id']);
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
