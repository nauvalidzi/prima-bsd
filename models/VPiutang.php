<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for v_piutang
 */
class VPiutang extends DbTable
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
    public $idpegawai;
    public $kodepegawai;
    public $namapegawai;
    public $pegawai;
    public $idcustomer;
    public $kodecustomer;
    public $namacustomer;
    public $customer;
    public $totaltagihan;
    public $totalpiutang;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'v_piutang';
        $this->TableName = 'v_piutang';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`v_piutang`";
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

        // idpegawai
        $this->idpegawai = new DbField('v_piutang', 'v_piutang', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idpegawai->Nullable = false; // NOT NULL field
        $this->idpegawai->Sortable = false; // Allow sort
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

        // kodepegawai
        $this->kodepegawai = new DbField('v_piutang', 'v_piutang', 'x_kodepegawai', 'kodepegawai', '`kodepegawai`', '`kodepegawai`', 200, 20, -1, false, '`kodepegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodepegawai->Nullable = false; // NOT NULL field
        $this->kodepegawai->Required = true; // Required field
        $this->kodepegawai->Sortable = false; // Allow sort
        $this->kodepegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodepegawai->Param, "CustomMsg");
        $this->Fields['kodepegawai'] = &$this->kodepegawai;

        // namapegawai
        $this->namapegawai = new DbField('v_piutang', 'v_piutang', 'x_namapegawai', 'namapegawai', '`namapegawai`', '`namapegawai`', 200, 100, -1, false, '`namapegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namapegawai->Nullable = false; // NOT NULL field
        $this->namapegawai->Required = true; // Required field
        $this->namapegawai->Sortable = false; // Allow sort
        $this->namapegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namapegawai->Param, "CustomMsg");
        $this->Fields['namapegawai'] = &$this->namapegawai;

        // pegawai
        $this->pegawai = new DbField('v_piutang', 'v_piutang', 'x_pegawai', 'pegawai', '`pegawai`', '`pegawai`', 200, 122, -1, false, '`pegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pegawai->Nullable = false; // NOT NULL field
        $this->pegawai->Required = true; // Required field
        $this->pegawai->Sortable = true; // Allow sort
        $this->pegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pegawai->Param, "CustomMsg");
        $this->Fields['pegawai'] = &$this->pegawai;

        // idcustomer
        $this->idcustomer = new DbField('v_piutang', 'v_piutang', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 20, 20, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idcustomer->IsForeignKey = true; // Foreign key field
        $this->idcustomer->Nullable = false; // NOT NULL field
        $this->idcustomer->Sortable = false; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // kodecustomer
        $this->kodecustomer = new DbField('v_piutang', 'v_piutang', 'x_kodecustomer', 'kodecustomer', '`kodecustomer`', '`kodecustomer`', 200, 50, -1, false, '`kodecustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodecustomer->Nullable = false; // NOT NULL field
        $this->kodecustomer->Required = true; // Required field
        $this->kodecustomer->Sortable = false; // Allow sort
        $this->kodecustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodecustomer->Param, "CustomMsg");
        $this->Fields['kodecustomer'] = &$this->kodecustomer;

        // namacustomer
        $this->namacustomer = new DbField('v_piutang', 'v_piutang', 'x_namacustomer', 'namacustomer', '`namacustomer`', '`namacustomer`', 200, 255, -1, false, '`namacustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namacustomer->Nullable = false; // NOT NULL field
        $this->namacustomer->Required = true; // Required field
        $this->namacustomer->Sortable = false; // Allow sort
        $this->namacustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namacustomer->Param, "CustomMsg");
        $this->Fields['namacustomer'] = &$this->namacustomer;

        // customer
        $this->customer = new DbField('v_piutang', 'v_piutang', 'x_customer', 'customer', '`customer`', '`customer`', 201, 307, -1, false, '`customer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->customer->Nullable = false; // NOT NULL field
        $this->customer->Required = true; // Required field
        $this->customer->Sortable = true; // Allow sort
        $this->customer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->customer->Param, "CustomMsg");
        $this->Fields['customer'] = &$this->customer;

        // totaltagihan
        $this->totaltagihan = new DbField('v_piutang', 'v_piutang', 'x_totaltagihan', 'totaltagihan', '`totaltagihan`', '`totaltagihan`', 131, 41, -1, false, '`totaltagihan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totaltagihan->Sortable = true; // Allow sort
        $this->totaltagihan->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->totaltagihan->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totaltagihan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totaltagihan->Param, "CustomMsg");
        $this->Fields['totaltagihan'] = &$this->totaltagihan;

        // totalpiutang
        $this->totalpiutang = new DbField('v_piutang', 'v_piutang', 'x_totalpiutang', 'totalpiutang', '`totalpiutang`', '`totalpiutang`', 131, 41, -1, false, '`totalpiutang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totalpiutang->Sortable = true; // Allow sort
        $this->totalpiutang->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->totalpiutang->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->totalpiutang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totalpiutang->Param, "CustomMsg");
        $this->Fields['totalpiutang'] = &$this->totalpiutang;
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
        if ($this->getCurrentDetailTable() == "v_piutang_detail") {
            $detailUrl = Container("v_piutang_detail")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idcustomer", $this->idcustomer->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "VPiutangList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`v_piutang`";
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
        $this->DefaultFilter = "idcustomer > -1";
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
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->kodepegawai->DbValue = $row['kodepegawai'];
        $this->namapegawai->DbValue = $row['namapegawai'];
        $this->pegawai->DbValue = $row['pegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->kodecustomer->DbValue = $row['kodecustomer'];
        $this->namacustomer->DbValue = $row['namacustomer'];
        $this->customer->DbValue = $row['customer'];
        $this->totaltagihan->DbValue = $row['totaltagihan'];
        $this->totalpiutang->DbValue = $row['totalpiutang'];
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
        return $_SESSION[$name] ?? GetUrl("VPiutangList");
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
        if ($pageName == "VPiutangView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VPiutangEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VPiutangAdd") {
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
                return "VPiutangView";
            case Config("API_ADD_ACTION"):
                return "VPiutangAdd";
            case Config("API_EDIT_ACTION"):
                return "VPiutangEdit";
            case Config("API_DELETE_ACTION"):
                return "VPiutangDelete";
            case Config("API_LIST_ACTION"):
                return "VPiutangList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VPiutangList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VPiutangView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VPiutangView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VPiutangAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VPiutangAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VPiutangEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("VPiutangAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("VPiutangDelete", $this->getUrlParm());
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
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->kodepegawai->setDbValue($row['kodepegawai']);
        $this->namapegawai->setDbValue($row['namapegawai']);
        $this->pegawai->setDbValue($row['pegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->kodecustomer->setDbValue($row['kodecustomer']);
        $this->namacustomer->setDbValue($row['namacustomer']);
        $this->customer->setDbValue($row['customer']);
        $this->totaltagihan->setDbValue($row['totaltagihan']);
        $this->totalpiutang->setDbValue($row['totalpiutang']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // idpegawai
        $this->idpegawai->CellCssStyle = "white-space: nowrap;";

        // kodepegawai
        $this->kodepegawai->CellCssStyle = "white-space: nowrap;";

        // namapegawai
        $this->namapegawai->CellCssStyle = "white-space: nowrap;";

        // pegawai

        // idcustomer
        $this->idcustomer->CellCssStyle = "white-space: nowrap;";

        // kodecustomer
        $this->kodecustomer->CellCssStyle = "white-space: nowrap;";

        // namacustomer
        $this->namacustomer->CellCssStyle = "white-space: nowrap;";

        // customer

        // totaltagihan

        // totalpiutang

        // idpegawai
        $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
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

        // kodepegawai
        $this->kodepegawai->ViewValue = $this->kodepegawai->CurrentValue;
        $this->kodepegawai->ViewCustomAttributes = "";

        // namapegawai
        $this->namapegawai->ViewValue = $this->namapegawai->CurrentValue;
        $this->namapegawai->ViewCustomAttributes = "";

        // pegawai
        $this->pegawai->ViewValue = $this->pegawai->CurrentValue;
        $this->pegawai->ViewCustomAttributes = "";

        // idcustomer
        $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
        $curVal = trim(strval($this->idcustomer->CurrentValue));
        if ($curVal != "") {
            $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
            if ($this->idcustomer->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

        // kodecustomer
        $this->kodecustomer->ViewValue = $this->kodecustomer->CurrentValue;
        $this->kodecustomer->ViewCustomAttributes = "";

        // namacustomer
        $this->namacustomer->ViewValue = $this->namacustomer->CurrentValue;
        $this->namacustomer->ViewCustomAttributes = "";

        // customer
        $this->customer->ViewValue = $this->customer->CurrentValue;
        $this->customer->ViewCustomAttributes = "";

        // totaltagihan
        $this->totaltagihan->ViewValue = $this->totaltagihan->CurrentValue;
        $this->totaltagihan->ViewValue = FormatCurrency($this->totaltagihan->ViewValue, 2, -2, -2, -2);
        $this->totaltagihan->ViewCustomAttributes = "";

        // totalpiutang
        $this->totalpiutang->ViewValue = $this->totalpiutang->CurrentValue;
        $this->totalpiutang->ViewValue = FormatCurrency($this->totalpiutang->ViewValue, 2, -2, -2, -2);
        $this->totalpiutang->ViewCustomAttributes = "";

        // idpegawai
        $this->idpegawai->LinkCustomAttributes = "";
        $this->idpegawai->HrefValue = "";
        $this->idpegawai->TooltipValue = "";

        // kodepegawai
        $this->kodepegawai->LinkCustomAttributes = "";
        $this->kodepegawai->HrefValue = "";
        $this->kodepegawai->TooltipValue = "";

        // namapegawai
        $this->namapegawai->LinkCustomAttributes = "";
        $this->namapegawai->HrefValue = "";
        $this->namapegawai->TooltipValue = "";

        // pegawai
        $this->pegawai->LinkCustomAttributes = "";
        $this->pegawai->HrefValue = "";
        $this->pegawai->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // kodecustomer
        $this->kodecustomer->LinkCustomAttributes = "";
        $this->kodecustomer->HrefValue = "";
        $this->kodecustomer->TooltipValue = "";

        // namacustomer
        $this->namacustomer->LinkCustomAttributes = "";
        $this->namacustomer->HrefValue = "";
        $this->namacustomer->TooltipValue = "";

        // customer
        $this->customer->LinkCustomAttributes = "";
        $this->customer->HrefValue = "";
        $this->customer->TooltipValue = "";

        // totaltagihan
        $this->totaltagihan->LinkCustomAttributes = "";
        $this->totaltagihan->HrefValue = "";
        $this->totaltagihan->TooltipValue = "";

        // totalpiutang
        $this->totalpiutang->LinkCustomAttributes = "";
        $this->totalpiutang->HrefValue = "";
        $this->totalpiutang->TooltipValue = "";

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

        // idpegawai
        $this->idpegawai->EditAttrs["class"] = "form-control";
        $this->idpegawai->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
        } else {
            $this->idpegawai->EditValue = $this->idpegawai->CurrentValue;
            $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());
        }

        // kodepegawai
        $this->kodepegawai->EditAttrs["class"] = "form-control";
        $this->kodepegawai->EditCustomAttributes = "";
        if (!$this->kodepegawai->Raw) {
            $this->kodepegawai->CurrentValue = HtmlDecode($this->kodepegawai->CurrentValue);
        }
        $this->kodepegawai->EditValue = $this->kodepegawai->CurrentValue;
        $this->kodepegawai->PlaceHolder = RemoveHtml($this->kodepegawai->caption());

        // namapegawai
        $this->namapegawai->EditAttrs["class"] = "form-control";
        $this->namapegawai->EditCustomAttributes = "";
        if (!$this->namapegawai->Raw) {
            $this->namapegawai->CurrentValue = HtmlDecode($this->namapegawai->CurrentValue);
        }
        $this->namapegawai->EditValue = $this->namapegawai->CurrentValue;
        $this->namapegawai->PlaceHolder = RemoveHtml($this->namapegawai->caption());

        // pegawai
        $this->pegawai->EditAttrs["class"] = "form-control";
        $this->pegawai->EditCustomAttributes = "";
        if (!$this->pegawai->Raw) {
            $this->pegawai->CurrentValue = HtmlDecode($this->pegawai->CurrentValue);
        }
        $this->pegawai->EditValue = $this->pegawai->CurrentValue;
        $this->pegawai->PlaceHolder = RemoveHtml($this->pegawai->caption());

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
        $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

        // kodecustomer
        $this->kodecustomer->EditAttrs["class"] = "form-control";
        $this->kodecustomer->EditCustomAttributes = "";
        if (!$this->kodecustomer->Raw) {
            $this->kodecustomer->CurrentValue = HtmlDecode($this->kodecustomer->CurrentValue);
        }
        $this->kodecustomer->EditValue = $this->kodecustomer->CurrentValue;
        $this->kodecustomer->PlaceHolder = RemoveHtml($this->kodecustomer->caption());

        // namacustomer
        $this->namacustomer->EditAttrs["class"] = "form-control";
        $this->namacustomer->EditCustomAttributes = "";
        if (!$this->namacustomer->Raw) {
            $this->namacustomer->CurrentValue = HtmlDecode($this->namacustomer->CurrentValue);
        }
        $this->namacustomer->EditValue = $this->namacustomer->CurrentValue;
        $this->namacustomer->PlaceHolder = RemoveHtml($this->namacustomer->caption());

        // customer
        $this->customer->EditAttrs["class"] = "form-control";
        $this->customer->EditCustomAttributes = "";
        if (!$this->customer->Raw) {
            $this->customer->CurrentValue = HtmlDecode($this->customer->CurrentValue);
        }
        $this->customer->EditValue = $this->customer->CurrentValue;
        $this->customer->PlaceHolder = RemoveHtml($this->customer->caption());

        // totaltagihan
        $this->totaltagihan->EditAttrs["class"] = "form-control";
        $this->totaltagihan->EditCustomAttributes = "";
        $this->totaltagihan->EditValue = $this->totaltagihan->CurrentValue;
        $this->totaltagihan->PlaceHolder = RemoveHtml($this->totaltagihan->caption());
        if (strval($this->totaltagihan->EditValue) != "" && is_numeric($this->totaltagihan->EditValue)) {
            $this->totaltagihan->EditValue = FormatNumber($this->totaltagihan->EditValue, -2, -2, -2, -2);
        }

        // totalpiutang
        $this->totalpiutang->EditAttrs["class"] = "form-control";
        $this->totalpiutang->EditCustomAttributes = "";
        $this->totalpiutang->EditValue = $this->totalpiutang->CurrentValue;
        $this->totalpiutang->PlaceHolder = RemoveHtml($this->totalpiutang->caption());
        if (strval($this->totalpiutang->EditValue) != "" && is_numeric($this->totalpiutang->EditValue)) {
            $this->totalpiutang->EditValue = FormatNumber($this->totalpiutang->EditValue, -2, -2, -2, -2);
        }

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
                    $doc->exportCaption($this->pegawai);
                    $doc->exportCaption($this->customer);
                    $doc->exportCaption($this->totaltagihan);
                    $doc->exportCaption($this->totalpiutang);
                } else {
                    $doc->exportCaption($this->pegawai);
                    $doc->exportCaption($this->customer);
                    $doc->exportCaption($this->totaltagihan);
                    $doc->exportCaption($this->totalpiutang);
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
                        $doc->exportField($this->pegawai);
                        $doc->exportField($this->customer);
                        $doc->exportField($this->totaltagihan);
                        $doc->exportField($this->totalpiutang);
                    } else {
                        $doc->exportField($this->pegawai);
                        $doc->exportField($this->customer);
                        $doc->exportField($this->totaltagihan);
                        $doc->exportField($this->totalpiutang);
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
                $filterWrk = '`idpegawai` IN (' . $filterWrk . ')';
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `v_piutang`";
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
