<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for v_bonuscustomer
 */
class VBonuscustomer extends DbTable
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
    public $kode_pegawai;
    public $pegawai;
    public $nama_pegawai;
    public $idcustomer;
    public $kode_customer;
    public $nama_customer;
    public $customer;
    public $blackbonus;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'v_bonuscustomer';
        $this->TableName = 'v_bonuscustomer';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`v_bonuscustomer`";
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
        $this->idpegawai = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
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

        // kode_pegawai
        $this->kode_pegawai = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_kode_pegawai', 'kode_pegawai', '`kode_pegawai`', '`kode_pegawai`', 200, 20, -1, false, '`kode_pegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode_pegawai->Nullable = false; // NOT NULL field
        $this->kode_pegawai->Required = true; // Required field
        $this->kode_pegawai->Sortable = false; // Allow sort
        $this->kode_pegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode_pegawai->Param, "CustomMsg");
        $this->Fields['kode_pegawai'] = &$this->kode_pegawai;

        // pegawai
        $this->pegawai = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_pegawai', 'pegawai', '`pegawai`', '`pegawai`', 200, 122, -1, false, '`pegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pegawai->Sortable = true; // Allow sort
        $this->pegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pegawai->Param, "CustomMsg");
        $this->Fields['pegawai'] = &$this->pegawai;

        // nama_pegawai
        $this->nama_pegawai = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_nama_pegawai', 'nama_pegawai', '`nama_pegawai`', '`nama_pegawai`', 200, 100, -1, false, '`nama_pegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_pegawai->Nullable = false; // NOT NULL field
        $this->nama_pegawai->Required = true; // Required field
        $this->nama_pegawai->Sortable = false; // Allow sort
        $this->nama_pegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_pegawai->Param, "CustomMsg");
        $this->Fields['nama_pegawai'] = &$this->nama_pegawai;

        // idcustomer
        $this->idcustomer = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
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

        // kode_customer
        $this->kode_customer = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_kode_customer', 'kode_customer', '`kode_customer`', '`kode_customer`', 200, 20, -1, false, '`kode_customer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode_customer->Nullable = false; // NOT NULL field
        $this->kode_customer->Required = true; // Required field
        $this->kode_customer->Sortable = false; // Allow sort
        $this->kode_customer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode_customer->Param, "CustomMsg");
        $this->Fields['kode_customer'] = &$this->kode_customer;

        // nama_customer
        $this->nama_customer = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_nama_customer', 'nama_customer', '`nama_customer`', '`nama_customer`', 200, 100, -1, false, '`nama_customer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_customer->Nullable = false; // NOT NULL field
        $this->nama_customer->Required = true; // Required field
        $this->nama_customer->Sortable = false; // Allow sort
        $this->nama_customer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_customer->Param, "CustomMsg");
        $this->Fields['nama_customer'] = &$this->nama_customer;

        // customer
        $this->customer = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_customer', 'customer', '`customer`', '`customer`', 200, 122, -1, false, '`customer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->customer->Sortable = true; // Allow sort
        $this->customer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->customer->Param, "CustomMsg");
        $this->Fields['customer'] = &$this->customer;

        // blackbonus
        $this->blackbonus = new DbField('v_bonuscustomer', 'v_bonuscustomer', 'x_blackbonus', 'blackbonus', '`blackbonus`', '`blackbonus`', 131, 42, -1, false, '`blackbonus`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->blackbonus->Nullable = false; // NOT NULL field
        $this->blackbonus->Sortable = true; // Allow sort
        $this->blackbonus->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->blackbonus->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->blackbonus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->blackbonus->Param, "CustomMsg");
        $this->Fields['blackbonus'] = &$this->blackbonus;
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
        if ($this->getCurrentDetailTable() == "redeembonus") {
            $detailUrl = Container("redeembonus")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idcustomer", $this->idcustomer->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "v_bonuscustomer_detail") {
            $detailUrl = Container("v_bonuscustomer_detail")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_idcustomer", $this->idcustomer->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "VBonuscustomerList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`v_bonuscustomer`";
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
        $this->kode_pegawai->DbValue = $row['kode_pegawai'];
        $this->pegawai->DbValue = $row['pegawai'];
        $this->nama_pegawai->DbValue = $row['nama_pegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->kode_customer->DbValue = $row['kode_customer'];
        $this->nama_customer->DbValue = $row['nama_customer'];
        $this->customer->DbValue = $row['customer'];
        $this->blackbonus->DbValue = $row['blackbonus'];
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
        return $_SESSION[$name] ?? GetUrl("VBonuscustomerList");
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
        if ($pageName == "VBonuscustomerView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VBonuscustomerEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VBonuscustomerAdd") {
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
                return "VBonuscustomerView";
            case Config("API_ADD_ACTION"):
                return "VBonuscustomerAdd";
            case Config("API_EDIT_ACTION"):
                return "VBonuscustomerEdit";
            case Config("API_DELETE_ACTION"):
                return "VBonuscustomerDelete";
            case Config("API_LIST_ACTION"):
                return "VBonuscustomerList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VBonuscustomerList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VBonuscustomerView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VBonuscustomerView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VBonuscustomerAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VBonuscustomerAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VBonuscustomerEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("VBonuscustomerAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("VBonuscustomerDelete", $this->getUrlParm());
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
        $this->kode_pegawai->setDbValue($row['kode_pegawai']);
        $this->pegawai->setDbValue($row['pegawai']);
        $this->nama_pegawai->setDbValue($row['nama_pegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->kode_customer->setDbValue($row['kode_customer']);
        $this->nama_customer->setDbValue($row['nama_customer']);
        $this->customer->setDbValue($row['customer']);
        $this->blackbonus->setDbValue($row['blackbonus']);
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

        // kode_pegawai
        $this->kode_pegawai->CellCssStyle = "white-space: nowrap;";

        // pegawai

        // nama_pegawai
        $this->nama_pegawai->CellCssStyle = "white-space: nowrap;";

        // idcustomer
        $this->idcustomer->CellCssStyle = "white-space: nowrap;";

        // kode_customer
        $this->kode_customer->CellCssStyle = "white-space: nowrap;";

        // nama_customer
        $this->nama_customer->CellCssStyle = "white-space: nowrap;";

        // customer

        // blackbonus

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

        // kode_pegawai
        $this->kode_pegawai->ViewValue = $this->kode_pegawai->CurrentValue;
        $this->kode_pegawai->ViewCustomAttributes = "";

        // pegawai
        $this->pegawai->ViewValue = $this->pegawai->CurrentValue;
        $this->pegawai->ViewCustomAttributes = "";

        // nama_pegawai
        $this->nama_pegawai->ViewValue = $this->nama_pegawai->CurrentValue;
        $this->nama_pegawai->ViewCustomAttributes = "";

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

        // kode_customer
        $this->kode_customer->ViewValue = $this->kode_customer->CurrentValue;
        $this->kode_customer->ViewCustomAttributes = "";

        // nama_customer
        $this->nama_customer->ViewValue = $this->nama_customer->CurrentValue;
        $this->nama_customer->ViewCustomAttributes = "";

        // customer
        $this->customer->ViewValue = $this->customer->CurrentValue;
        $this->customer->ViewCustomAttributes = "";

        // blackbonus
        $this->blackbonus->ViewValue = $this->blackbonus->CurrentValue;
        $this->blackbonus->ViewValue = FormatCurrency($this->blackbonus->ViewValue, 2, -2, -2, -2);
        $this->blackbonus->ViewCustomAttributes = "";

        // idpegawai
        $this->idpegawai->LinkCustomAttributes = "";
        $this->idpegawai->HrefValue = "";
        $this->idpegawai->TooltipValue = "";

        // kode_pegawai
        $this->kode_pegawai->LinkCustomAttributes = "";
        $this->kode_pegawai->HrefValue = "";
        $this->kode_pegawai->TooltipValue = "";

        // pegawai
        $this->pegawai->LinkCustomAttributes = "";
        $this->pegawai->HrefValue = "";
        $this->pegawai->TooltipValue = "";

        // nama_pegawai
        $this->nama_pegawai->LinkCustomAttributes = "";
        $this->nama_pegawai->HrefValue = "";
        $this->nama_pegawai->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // kode_customer
        $this->kode_customer->LinkCustomAttributes = "";
        $this->kode_customer->HrefValue = "";
        $this->kode_customer->TooltipValue = "";

        // nama_customer
        $this->nama_customer->LinkCustomAttributes = "";
        $this->nama_customer->HrefValue = "";
        $this->nama_customer->TooltipValue = "";

        // customer
        $this->customer->LinkCustomAttributes = "";
        $this->customer->HrefValue = "";
        $this->customer->TooltipValue = "";

        // blackbonus
        $this->blackbonus->LinkCustomAttributes = "";
        $this->blackbonus->HrefValue = "";
        $this->blackbonus->TooltipValue = "";

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

        // kode_pegawai
        $this->kode_pegawai->EditAttrs["class"] = "form-control";
        $this->kode_pegawai->EditCustomAttributes = "";
        if (!$this->kode_pegawai->Raw) {
            $this->kode_pegawai->CurrentValue = HtmlDecode($this->kode_pegawai->CurrentValue);
        }
        $this->kode_pegawai->EditValue = $this->kode_pegawai->CurrentValue;
        $this->kode_pegawai->PlaceHolder = RemoveHtml($this->kode_pegawai->caption());

        // pegawai
        $this->pegawai->EditAttrs["class"] = "form-control";
        $this->pegawai->EditCustomAttributes = "";
        if (!$this->pegawai->Raw) {
            $this->pegawai->CurrentValue = HtmlDecode($this->pegawai->CurrentValue);
        }
        $this->pegawai->EditValue = $this->pegawai->CurrentValue;
        $this->pegawai->PlaceHolder = RemoveHtml($this->pegawai->caption());

        // nama_pegawai
        $this->nama_pegawai->EditAttrs["class"] = "form-control";
        $this->nama_pegawai->EditCustomAttributes = "";
        if (!$this->nama_pegawai->Raw) {
            $this->nama_pegawai->CurrentValue = HtmlDecode($this->nama_pegawai->CurrentValue);
        }
        $this->nama_pegawai->EditValue = $this->nama_pegawai->CurrentValue;
        $this->nama_pegawai->PlaceHolder = RemoveHtml($this->nama_pegawai->caption());

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
        $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

        // kode_customer
        $this->kode_customer->EditAttrs["class"] = "form-control";
        $this->kode_customer->EditCustomAttributes = "";
        if (!$this->kode_customer->Raw) {
            $this->kode_customer->CurrentValue = HtmlDecode($this->kode_customer->CurrentValue);
        }
        $this->kode_customer->EditValue = $this->kode_customer->CurrentValue;
        $this->kode_customer->PlaceHolder = RemoveHtml($this->kode_customer->caption());

        // nama_customer
        $this->nama_customer->EditAttrs["class"] = "form-control";
        $this->nama_customer->EditCustomAttributes = "";
        if (!$this->nama_customer->Raw) {
            $this->nama_customer->CurrentValue = HtmlDecode($this->nama_customer->CurrentValue);
        }
        $this->nama_customer->EditValue = $this->nama_customer->CurrentValue;
        $this->nama_customer->PlaceHolder = RemoveHtml($this->nama_customer->caption());

        // customer
        $this->customer->EditAttrs["class"] = "form-control";
        $this->customer->EditCustomAttributes = "";
        if (!$this->customer->Raw) {
            $this->customer->CurrentValue = HtmlDecode($this->customer->CurrentValue);
        }
        $this->customer->EditValue = $this->customer->CurrentValue;
        $this->customer->PlaceHolder = RemoveHtml($this->customer->caption());

        // blackbonus
        $this->blackbonus->EditAttrs["class"] = "form-control";
        $this->blackbonus->EditCustomAttributes = "";
        $this->blackbonus->EditValue = $this->blackbonus->CurrentValue;
        $this->blackbonus->PlaceHolder = RemoveHtml($this->blackbonus->caption());
        if (strval($this->blackbonus->EditValue) != "" && is_numeric($this->blackbonus->EditValue)) {
            $this->blackbonus->EditValue = FormatNumber($this->blackbonus->EditValue, -2, -2, -2, -2);
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
                    $doc->exportCaption($this->blackbonus);
                } else {
                    $doc->exportCaption($this->pegawai);
                    $doc->exportCaption($this->customer);
                    $doc->exportCaption($this->blackbonus);
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
                        $doc->exportField($this->blackbonus);
                    } else {
                        $doc->exportField($this->pegawai);
                        $doc->exportField($this->customer);
                        $doc->exportField($this->blackbonus);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `v_bonuscustomer`";
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
