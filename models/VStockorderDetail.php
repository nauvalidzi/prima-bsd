<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for v_stockorder_detail
 */
class VStockorderDetail extends DbTable
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
    public $idstockorder;
    public $idstockorder_detail;
    public $kode_produk;
    public $nama_produk;
    public $jumlah_order;
    public $sisa_order;
    public $stok_akhir;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'v_stockorder_detail';
        $this->TableName = 'v_stockorder_detail';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`v_stockorder_detail`";
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

        // idstockorder
        $this->idstockorder = new DbField('v_stockorder_detail', 'v_stockorder_detail', 'x_idstockorder', 'idstockorder', '`idstockorder`', '`idstockorder`', 3, 11, -1, false, '`idstockorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idstockorder->Nullable = false; // NOT NULL field
        $this->idstockorder->Required = true; // Required field
        $this->idstockorder->Sortable = true; // Allow sort
        $this->idstockorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idstockorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idstockorder->Param, "CustomMsg");
        $this->Fields['idstockorder'] = &$this->idstockorder;

        // idstockorder_detail
        $this->idstockorder_detail = new DbField('v_stockorder_detail', 'v_stockorder_detail', 'x_idstockorder_detail', 'idstockorder_detail', '`idstockorder_detail`', '`idstockorder_detail`', 3, 11, -1, false, '`idstockorder_detail`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->idstockorder_detail->IsAutoIncrement = true; // Autoincrement field
        $this->idstockorder_detail->IsPrimaryKey = true; // Primary key field
        $this->idstockorder_detail->Sortable = true; // Allow sort
        $this->idstockorder_detail->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idstockorder_detail->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idstockorder_detail->Param, "CustomMsg");
        $this->Fields['idstockorder_detail'] = &$this->idstockorder_detail;

        // kode_produk
        $this->kode_produk = new DbField('v_stockorder_detail', 'v_stockorder_detail', 'x_kode_produk', 'kode_produk', '`kode_produk`', '`kode_produk`', 200, 50, -1, false, '`kode_produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode_produk->Nullable = false; // NOT NULL field
        $this->kode_produk->Required = true; // Required field
        $this->kode_produk->Sortable = true; // Allow sort
        $this->kode_produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode_produk->Param, "CustomMsg");
        $this->Fields['kode_produk'] = &$this->kode_produk;

        // nama_produk
        $this->nama_produk = new DbField('v_stockorder_detail', 'v_stockorder_detail', 'x_nama_produk', 'nama_produk', '`nama_produk`', '`nama_produk`', 200, 255, -1, false, '`nama_produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_produk->Nullable = false; // NOT NULL field
        $this->nama_produk->Required = true; // Required field
        $this->nama_produk->Sortable = true; // Allow sort
        $this->nama_produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_produk->Param, "CustomMsg");
        $this->Fields['nama_produk'] = &$this->nama_produk;

        // jumlah_order
        $this->jumlah_order = new DbField('v_stockorder_detail', 'v_stockorder_detail', 'x_jumlah_order', 'jumlah_order', '`jumlah_order`', '`jumlah_order`', 3, 11, -1, false, '`jumlah_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlah_order->Nullable = false; // NOT NULL field
        $this->jumlah_order->Required = true; // Required field
        $this->jumlah_order->Sortable = true; // Allow sort
        $this->jumlah_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlah_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlah_order->Param, "CustomMsg");
        $this->Fields['jumlah_order'] = &$this->jumlah_order;

        // sisa_order
        $this->sisa_order = new DbField('v_stockorder_detail', 'v_stockorder_detail', 'x_sisa_order', 'sisa_order', '`sisa_order`', '`sisa_order`', 3, 11, -1, false, '`sisa_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisa_order->Nullable = false; // NOT NULL field
        $this->sisa_order->Required = true; // Required field
        $this->sisa_order->Sortable = true; // Allow sort
        $this->sisa_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisa_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisa_order->Param, "CustomMsg");
        $this->Fields['sisa_order'] = &$this->sisa_order;

        // stok_akhir
        $this->stok_akhir = new DbField('v_stockorder_detail', 'v_stockorder_detail', 'x_stok_akhir', 'stok_akhir', '`stok_akhir`', '`stok_akhir`', 3, 11, -1, false, '`stok_akhir`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->stok_akhir->Nullable = false; // NOT NULL field
        $this->stok_akhir->Required = true; // Required field
        $this->stok_akhir->Sortable = true; // Allow sort
        $this->stok_akhir->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->stok_akhir->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->stok_akhir->Param, "CustomMsg");
        $this->Fields['stok_akhir'] = &$this->stok_akhir;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`v_stockorder_detail`";
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
            $this->idstockorder_detail->setDbValue($conn->lastInsertId());
            $rs['idstockorder_detail'] = $this->idstockorder_detail->DbValue;
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
            if (array_key_exists('idstockorder_detail', $rs)) {
                AddFilter($where, QuotedName('idstockorder_detail', $this->Dbid) . '=' . QuotedValue($rs['idstockorder_detail'], $this->idstockorder_detail->DataType, $this->Dbid));
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
        $this->idstockorder->DbValue = $row['idstockorder'];
        $this->idstockorder_detail->DbValue = $row['idstockorder_detail'];
        $this->kode_produk->DbValue = $row['kode_produk'];
        $this->nama_produk->DbValue = $row['nama_produk'];
        $this->jumlah_order->DbValue = $row['jumlah_order'];
        $this->sisa_order->DbValue = $row['sisa_order'];
        $this->stok_akhir->DbValue = $row['stok_akhir'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idstockorder_detail` = @idstockorder_detail@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->idstockorder_detail->CurrentValue : $this->idstockorder_detail->OldValue;
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
                $this->idstockorder_detail->CurrentValue = $keys[0];
            } else {
                $this->idstockorder_detail->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idstockorder_detail', $row) ? $row['idstockorder_detail'] : null;
        } else {
            $val = $this->idstockorder_detail->OldValue !== null ? $this->idstockorder_detail->OldValue : $this->idstockorder_detail->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idstockorder_detail@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("VStockorderDetailList");
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
        if ($pageName == "VStockorderDetailView") {
            return $Language->phrase("View");
        } elseif ($pageName == "VStockorderDetailEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "VStockorderDetailAdd") {
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
                return "VStockorderDetailView";
            case Config("API_ADD_ACTION"):
                return "VStockorderDetailAdd";
            case Config("API_EDIT_ACTION"):
                return "VStockorderDetailEdit";
            case Config("API_DELETE_ACTION"):
                return "VStockorderDetailDelete";
            case Config("API_LIST_ACTION"):
                return "VStockorderDetailList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "VStockorderDetailList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("VStockorderDetailView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("VStockorderDetailView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "VStockorderDetailAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "VStockorderDetailAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("VStockorderDetailEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("VStockorderDetailAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("VStockorderDetailDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "idstockorder_detail:" . JsonEncode($this->idstockorder_detail->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idstockorder_detail->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idstockorder_detail->CurrentValue);
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
            if (($keyValue = Param("idstockorder_detail") ?? Route("idstockorder_detail")) !== null) {
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
                $this->idstockorder_detail->CurrentValue = $key;
            } else {
                $this->idstockorder_detail->OldValue = $key;
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
        $this->idstockorder->setDbValue($row['idstockorder']);
        $this->idstockorder_detail->setDbValue($row['idstockorder_detail']);
        $this->kode_produk->setDbValue($row['kode_produk']);
        $this->nama_produk->setDbValue($row['nama_produk']);
        $this->jumlah_order->setDbValue($row['jumlah_order']);
        $this->sisa_order->setDbValue($row['sisa_order']);
        $this->stok_akhir->setDbValue($row['stok_akhir']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // idstockorder

        // idstockorder_detail

        // kode_produk

        // nama_produk

        // jumlah_order

        // sisa_order

        // stok_akhir

        // idstockorder
        $this->idstockorder->ViewValue = $this->idstockorder->CurrentValue;
        $this->idstockorder->ViewValue = FormatNumber($this->idstockorder->ViewValue, 0, -2, -2, -2);
        $this->idstockorder->ViewCustomAttributes = "";

        // idstockorder_detail
        $this->idstockorder_detail->ViewValue = $this->idstockorder_detail->CurrentValue;
        $this->idstockorder_detail->ViewCustomAttributes = "";

        // kode_produk
        $this->kode_produk->ViewValue = $this->kode_produk->CurrentValue;
        $this->kode_produk->ViewCustomAttributes = "";

        // nama_produk
        $this->nama_produk->ViewValue = $this->nama_produk->CurrentValue;
        $this->nama_produk->ViewCustomAttributes = "";

        // jumlah_order
        $this->jumlah_order->ViewValue = $this->jumlah_order->CurrentValue;
        $this->jumlah_order->ViewValue = FormatNumber($this->jumlah_order->ViewValue, 0, -2, -2, -2);
        $this->jumlah_order->ViewCustomAttributes = "";

        // sisa_order
        $this->sisa_order->ViewValue = $this->sisa_order->CurrentValue;
        $this->sisa_order->ViewValue = FormatNumber($this->sisa_order->ViewValue, 0, -2, -2, -2);
        $this->sisa_order->ViewCustomAttributes = "";

        // stok_akhir
        $this->stok_akhir->ViewValue = $this->stok_akhir->CurrentValue;
        $this->stok_akhir->ViewValue = FormatNumber($this->stok_akhir->ViewValue, 0, -2, -2, -2);
        $this->stok_akhir->ViewCustomAttributes = "";

        // idstockorder
        $this->idstockorder->LinkCustomAttributes = "";
        $this->idstockorder->HrefValue = "";
        $this->idstockorder->TooltipValue = "";

        // idstockorder_detail
        $this->idstockorder_detail->LinkCustomAttributes = "";
        $this->idstockorder_detail->HrefValue = "";
        $this->idstockorder_detail->TooltipValue = "";

        // kode_produk
        $this->kode_produk->LinkCustomAttributes = "";
        $this->kode_produk->HrefValue = "";
        $this->kode_produk->TooltipValue = "";

        // nama_produk
        $this->nama_produk->LinkCustomAttributes = "";
        $this->nama_produk->HrefValue = "";
        $this->nama_produk->TooltipValue = "";

        // jumlah_order
        $this->jumlah_order->LinkCustomAttributes = "";
        $this->jumlah_order->HrefValue = "";
        $this->jumlah_order->TooltipValue = "";

        // sisa_order
        $this->sisa_order->LinkCustomAttributes = "";
        $this->sisa_order->HrefValue = "";
        $this->sisa_order->TooltipValue = "";

        // stok_akhir
        $this->stok_akhir->LinkCustomAttributes = "";
        $this->stok_akhir->HrefValue = "";
        $this->stok_akhir->TooltipValue = "";

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

        // idstockorder
        $this->idstockorder->EditAttrs["class"] = "form-control";
        $this->idstockorder->EditCustomAttributes = "";
        $this->idstockorder->EditValue = $this->idstockorder->CurrentValue;
        $this->idstockorder->PlaceHolder = RemoveHtml($this->idstockorder->caption());

        // idstockorder_detail
        $this->idstockorder_detail->EditAttrs["class"] = "form-control";
        $this->idstockorder_detail->EditCustomAttributes = "";
        $this->idstockorder_detail->EditValue = $this->idstockorder_detail->CurrentValue;
        $this->idstockorder_detail->ViewCustomAttributes = "";

        // kode_produk
        $this->kode_produk->EditAttrs["class"] = "form-control";
        $this->kode_produk->EditCustomAttributes = "";
        if (!$this->kode_produk->Raw) {
            $this->kode_produk->CurrentValue = HtmlDecode($this->kode_produk->CurrentValue);
        }
        $this->kode_produk->EditValue = $this->kode_produk->CurrentValue;
        $this->kode_produk->PlaceHolder = RemoveHtml($this->kode_produk->caption());

        // nama_produk
        $this->nama_produk->EditAttrs["class"] = "form-control";
        $this->nama_produk->EditCustomAttributes = "";
        if (!$this->nama_produk->Raw) {
            $this->nama_produk->CurrentValue = HtmlDecode($this->nama_produk->CurrentValue);
        }
        $this->nama_produk->EditValue = $this->nama_produk->CurrentValue;
        $this->nama_produk->PlaceHolder = RemoveHtml($this->nama_produk->caption());

        // jumlah_order
        $this->jumlah_order->EditAttrs["class"] = "form-control";
        $this->jumlah_order->EditCustomAttributes = "";
        $this->jumlah_order->EditValue = $this->jumlah_order->CurrentValue;
        $this->jumlah_order->PlaceHolder = RemoveHtml($this->jumlah_order->caption());

        // sisa_order
        $this->sisa_order->EditAttrs["class"] = "form-control";
        $this->sisa_order->EditCustomAttributes = "";
        $this->sisa_order->EditValue = $this->sisa_order->CurrentValue;
        $this->sisa_order->PlaceHolder = RemoveHtml($this->sisa_order->caption());

        // stok_akhir
        $this->stok_akhir->EditAttrs["class"] = "form-control";
        $this->stok_akhir->EditCustomAttributes = "";
        $this->stok_akhir->EditValue = $this->stok_akhir->CurrentValue;
        $this->stok_akhir->PlaceHolder = RemoveHtml($this->stok_akhir->caption());

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
                    $doc->exportCaption($this->kode_produk);
                    $doc->exportCaption($this->nama_produk);
                    $doc->exportCaption($this->jumlah_order);
                    $doc->exportCaption($this->sisa_order);
                    $doc->exportCaption($this->stok_akhir);
                } else {
                    $doc->exportCaption($this->idstockorder);
                    $doc->exportCaption($this->idstockorder_detail);
                    $doc->exportCaption($this->kode_produk);
                    $doc->exportCaption($this->nama_produk);
                    $doc->exportCaption($this->jumlah_order);
                    $doc->exportCaption($this->sisa_order);
                    $doc->exportCaption($this->stok_akhir);
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
                        $doc->exportField($this->kode_produk);
                        $doc->exportField($this->nama_produk);
                        $doc->exportField($this->jumlah_order);
                        $doc->exportField($this->sisa_order);
                        $doc->exportField($this->stok_akhir);
                    } else {
                        $doc->exportField($this->idstockorder);
                        $doc->exportField($this->idstockorder_detail);
                        $doc->exportField($this->kode_produk);
                        $doc->exportField($this->nama_produk);
                        $doc->exportField($this->jumlah_order);
                        $doc->exportField($this->sisa_order);
                        $doc->exportField($this->stok_akhir);
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
