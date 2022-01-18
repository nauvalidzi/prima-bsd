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
    public $nama_customer;
    public $nilai_po;
    public $nilai_faktur;
    public $piutang;
    public $nomor_handphone;
    public $kode_order;
    public $tgl_faktur;
    public $umur_faktur;
    public $idorder;
    public $kode_faktur;
    public $jatuhtempo;
    public $term_payment;
    public $tgl_penagihan;

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
        $this->tgl_order = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_order', 'tgl_order', '`tgl_order`', '`tgl_order`', 200, 10, -1, false, '`tgl_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_order->Sortable = true; // Allow sort
        $this->tgl_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_order->Param, "CustomMsg");
        $this->Fields['tgl_order'] = &$this->tgl_order;

        // nama_customer
        $this->nama_customer = new DbField('v_penagihan', 'v_penagihan', 'x_nama_customer', 'nama_customer', '`nama_customer`', '`nama_customer`', 200, 255, -1, false, '`nama_customer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_customer->Nullable = false; // NOT NULL field
        $this->nama_customer->Required = true; // Required field
        $this->nama_customer->Sortable = true; // Allow sort
        $this->nama_customer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_customer->Param, "CustomMsg");
        $this->Fields['nama_customer'] = &$this->nama_customer;

        // nilai_po
        $this->nilai_po = new DbField('v_penagihan', 'v_penagihan', 'x_nilai_po', 'nilai_po', '`nilai_po`', '`nilai_po`', 131, 41, -1, false, '`nilai_po`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nilai_po->Sortable = true; // Allow sort
        $this->nilai_po->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->nilai_po->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->nilai_po->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nilai_po->Param, "CustomMsg");
        $this->Fields['nilai_po'] = &$this->nilai_po;

        // nilai_faktur
        $this->nilai_faktur = new DbField('v_penagihan', 'v_penagihan', 'x_nilai_faktur', 'nilai_faktur', '`nilai_faktur`', '`nilai_faktur`', 20, 20, -1, false, '`nilai_faktur`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nilai_faktur->Sortable = true; // Allow sort
        $this->nilai_faktur->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->nilai_faktur->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nilai_faktur->Param, "CustomMsg");
        $this->Fields['nilai_faktur'] = &$this->nilai_faktur;

        // piutang
        $this->piutang = new DbField('v_penagihan', 'v_penagihan', 'x_piutang', 'piutang', '`piutang`', '`piutang`', 20, 20, -1, false, '`piutang`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->piutang->Sortable = true; // Allow sort
        $this->piutang->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->piutang->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->piutang->Param, "CustomMsg");
        $this->Fields['piutang'] = &$this->piutang;

        // nomor_handphone
        $this->nomor_handphone = new DbField('v_penagihan', 'v_penagihan', 'x_nomor_handphone', 'nomor_handphone', '`nomor_handphone`', '`nomor_handphone`', 200, 20, -1, false, '`nomor_handphone`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nomor_handphone->Sortable = true; // Allow sort
        $this->nomor_handphone->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nomor_handphone->Param, "CustomMsg");
        $this->Fields['nomor_handphone'] = &$this->nomor_handphone;

        // kode_order
        $this->kode_order = new DbField('v_penagihan', 'v_penagihan', 'x_kode_order', 'kode_order', '`kode_order`', '`kode_order`', 200, 50, -1, false, '`kode_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode_order->Sortable = true; // Allow sort
        $this->kode_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode_order->Param, "CustomMsg");
        $this->Fields['kode_order'] = &$this->kode_order;

        // tgl_faktur
        $this->tgl_faktur = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_faktur', 'tgl_faktur', '`tgl_faktur`', '`tgl_faktur`', 200, 10, -1, false, '`tgl_faktur`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_faktur->Sortable = true; // Allow sort
        $this->tgl_faktur->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_faktur->Param, "CustomMsg");
        $this->Fields['tgl_faktur'] = &$this->tgl_faktur;

        // umur_faktur
        $this->umur_faktur = new DbField('v_penagihan', 'v_penagihan', 'x_umur_faktur', 'umur_faktur', '`umur_faktur`', '`umur_faktur`', 20, 21, -1, false, '`umur_faktur`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->umur_faktur->Sortable = true; // Allow sort
        $this->umur_faktur->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->umur_faktur->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->umur_faktur->Param, "CustomMsg");
        $this->Fields['umur_faktur'] = &$this->umur_faktur;

        // idorder
        $this->idorder = new DbField('v_penagihan', 'v_penagihan', 'x_idorder', 'idorder', '`idorder`', '`idorder`', 20, 20, -1, false, '`idorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idorder->Nullable = false; // NOT NULL field
        $this->idorder->Sortable = true; // Allow sort
        $this->idorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idorder->Param, "CustomMsg");
        $this->Fields['idorder'] = &$this->idorder;

        // kode_faktur
        $this->kode_faktur = new DbField('v_penagihan', 'v_penagihan', 'x_kode_faktur', 'kode_faktur', '`kode_faktur`', '`kode_faktur`', 200, 50, -1, false, '`kode_faktur`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode_faktur->Sortable = true; // Allow sort
        $this->kode_faktur->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode_faktur->Param, "CustomMsg");
        $this->Fields['kode_faktur'] = &$this->kode_faktur;

        // jatuhtempo
        $this->jatuhtempo = new DbField('v_penagihan', 'v_penagihan', 'x_jatuhtempo', 'jatuhtempo', '`jatuhtempo`', '`jatuhtempo`', 200, 10, -1, false, '`jatuhtempo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jatuhtempo->Sortable = true; // Allow sort
        $this->jatuhtempo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jatuhtempo->Param, "CustomMsg");
        $this->Fields['jatuhtempo'] = &$this->jatuhtempo;

        // term_payment
        $this->term_payment = new DbField('v_penagihan', 'v_penagihan', 'x_term_payment', 'term_payment', '`term_payment`', '`term_payment`', 3, 11, -1, false, '`term_payment`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->term_payment->Sortable = true; // Allow sort
        $this->term_payment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->term_payment->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->term_payment->Param, "CustomMsg");
        $this->Fields['term_payment'] = &$this->term_payment;

        // tgl_penagihan
        $this->tgl_penagihan = new DbField('v_penagihan', 'v_penagihan', 'x_tgl_penagihan', 'tgl_penagihan', '`tgl_penagihan`', '`tgl_penagihan`', 200, 24, -1, false, '`tgl_penagihan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgl_penagihan->Nullable = false; // NOT NULL field
        $this->tgl_penagihan->Required = true; // Required field
        $this->tgl_penagihan->Sortable = true; // Allow sort
        $this->tgl_penagihan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgl_penagihan->Param, "CustomMsg");
        $this->Fields['tgl_penagihan'] = &$this->tgl_penagihan;
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
        $this->nama_customer->DbValue = $row['nama_customer'];
        $this->nilai_po->DbValue = $row['nilai_po'];
        $this->nilai_faktur->DbValue = $row['nilai_faktur'];
        $this->piutang->DbValue = $row['piutang'];
        $this->nomor_handphone->DbValue = $row['nomor_handphone'];
        $this->kode_order->DbValue = $row['kode_order'];
        $this->tgl_faktur->DbValue = $row['tgl_faktur'];
        $this->umur_faktur->DbValue = $row['umur_faktur'];
        $this->idorder->DbValue = $row['idorder'];
        $this->kode_faktur->DbValue = $row['kode_faktur'];
        $this->jatuhtempo->DbValue = $row['jatuhtempo'];
        $this->term_payment->DbValue = $row['term_payment'];
        $this->tgl_penagihan->DbValue = $row['tgl_penagihan'];
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
        $this->nama_customer->setDbValue($row['nama_customer']);
        $this->nilai_po->setDbValue($row['nilai_po']);
        $this->nilai_faktur->setDbValue($row['nilai_faktur']);
        $this->piutang->setDbValue($row['piutang']);
        $this->nomor_handphone->setDbValue($row['nomor_handphone']);
        $this->kode_order->setDbValue($row['kode_order']);
        $this->tgl_faktur->setDbValue($row['tgl_faktur']);
        $this->umur_faktur->setDbValue($row['umur_faktur']);
        $this->idorder->setDbValue($row['idorder']);
        $this->kode_faktur->setDbValue($row['kode_faktur']);
        $this->jatuhtempo->setDbValue($row['jatuhtempo']);
        $this->term_payment->setDbValue($row['term_payment']);
        $this->tgl_penagihan->setDbValue($row['tgl_penagihan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // tgl_order

        // nama_customer

        // nilai_po

        // nilai_faktur

        // piutang

        // nomor_handphone

        // kode_order

        // tgl_faktur

        // umur_faktur

        // idorder

        // kode_faktur

        // jatuhtempo

        // term_payment

        // tgl_penagihan

        // tgl_order
        $this->tgl_order->ViewValue = $this->tgl_order->CurrentValue;
        $this->tgl_order->ViewCustomAttributes = "";

        // nama_customer
        $this->nama_customer->ViewValue = $this->nama_customer->CurrentValue;
        $this->nama_customer->ViewCustomAttributes = "";

        // nilai_po
        $this->nilai_po->ViewValue = $this->nilai_po->CurrentValue;
        $this->nilai_po->ViewValue = FormatNumber($this->nilai_po->ViewValue, 2, -2, -2, -2);
        $this->nilai_po->ViewCustomAttributes = "";

        // nilai_faktur
        $this->nilai_faktur->ViewValue = $this->nilai_faktur->CurrentValue;
        $this->nilai_faktur->ViewValue = FormatNumber($this->nilai_faktur->ViewValue, 0, -2, -2, -2);
        $this->nilai_faktur->ViewCustomAttributes = "";

        // piutang
        $this->piutang->ViewValue = $this->piutang->CurrentValue;
        $this->piutang->ViewValue = FormatNumber($this->piutang->ViewValue, 0, -2, -2, -2);
        $this->piutang->ViewCustomAttributes = "";

        // nomor_handphone
        $this->nomor_handphone->ViewValue = $this->nomor_handphone->CurrentValue;
        $this->nomor_handphone->ViewCustomAttributes = "";

        // kode_order
        $this->kode_order->ViewValue = $this->kode_order->CurrentValue;
        $this->kode_order->ViewCustomAttributes = "";

        // tgl_faktur
        $this->tgl_faktur->ViewValue = $this->tgl_faktur->CurrentValue;
        $this->tgl_faktur->ViewCustomAttributes = "";

        // umur_faktur
        $this->umur_faktur->ViewValue = $this->umur_faktur->CurrentValue;
        $this->umur_faktur->ViewValue = FormatNumber($this->umur_faktur->ViewValue, 0, -2, -2, -2);
        $this->umur_faktur->ViewCustomAttributes = "";

        // idorder
        $this->idorder->ViewValue = $this->idorder->CurrentValue;
        $this->idorder->ViewValue = FormatNumber($this->idorder->ViewValue, 0, -2, -2, -2);
        $this->idorder->ViewCustomAttributes = "";

        // kode_faktur
        $this->kode_faktur->ViewValue = $this->kode_faktur->CurrentValue;
        $this->kode_faktur->ViewCustomAttributes = "";

        // jatuhtempo
        $this->jatuhtempo->ViewValue = $this->jatuhtempo->CurrentValue;
        $this->jatuhtempo->ViewCustomAttributes = "";

        // term_payment
        $this->term_payment->ViewValue = $this->term_payment->CurrentValue;
        $this->term_payment->ViewValue = FormatNumber($this->term_payment->ViewValue, 0, -2, -2, -2);
        $this->term_payment->ViewCustomAttributes = "";

        // tgl_penagihan
        $this->tgl_penagihan->ViewValue = $this->tgl_penagihan->CurrentValue;
        $this->tgl_penagihan->ViewCustomAttributes = "";

        // tgl_order
        $this->tgl_order->LinkCustomAttributes = "";
        $this->tgl_order->HrefValue = "";
        $this->tgl_order->TooltipValue = "";

        // nama_customer
        $this->nama_customer->LinkCustomAttributes = "";
        $this->nama_customer->HrefValue = "";
        $this->nama_customer->TooltipValue = "";

        // nilai_po
        $this->nilai_po->LinkCustomAttributes = "";
        $this->nilai_po->HrefValue = "";
        $this->nilai_po->TooltipValue = "";

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

        // kode_order
        $this->kode_order->LinkCustomAttributes = "";
        $this->kode_order->HrefValue = "";
        $this->kode_order->TooltipValue = "";

        // tgl_faktur
        $this->tgl_faktur->LinkCustomAttributes = "";
        $this->tgl_faktur->HrefValue = "";
        $this->tgl_faktur->TooltipValue = "";

        // umur_faktur
        $this->umur_faktur->LinkCustomAttributes = "";
        $this->umur_faktur->HrefValue = "";
        $this->umur_faktur->TooltipValue = "";

        // idorder
        $this->idorder->LinkCustomAttributes = "";
        $this->idorder->HrefValue = "";
        $this->idorder->TooltipValue = "";

        // kode_faktur
        $this->kode_faktur->LinkCustomAttributes = "";
        $this->kode_faktur->HrefValue = "";
        $this->kode_faktur->TooltipValue = "";

        // jatuhtempo
        $this->jatuhtempo->LinkCustomAttributes = "";
        $this->jatuhtempo->HrefValue = "";
        $this->jatuhtempo->TooltipValue = "";

        // term_payment
        $this->term_payment->LinkCustomAttributes = "";
        $this->term_payment->HrefValue = "";
        $this->term_payment->TooltipValue = "";

        // tgl_penagihan
        $this->tgl_penagihan->LinkCustomAttributes = "";
        $this->tgl_penagihan->HrefValue = "";
        $this->tgl_penagihan->TooltipValue = "";

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
        if (!$this->tgl_order->Raw) {
            $this->tgl_order->CurrentValue = HtmlDecode($this->tgl_order->CurrentValue);
        }
        $this->tgl_order->EditValue = $this->tgl_order->CurrentValue;
        $this->tgl_order->PlaceHolder = RemoveHtml($this->tgl_order->caption());

        // nama_customer
        $this->nama_customer->EditAttrs["class"] = "form-control";
        $this->nama_customer->EditCustomAttributes = "";
        if (!$this->nama_customer->Raw) {
            $this->nama_customer->CurrentValue = HtmlDecode($this->nama_customer->CurrentValue);
        }
        $this->nama_customer->EditValue = $this->nama_customer->CurrentValue;
        $this->nama_customer->PlaceHolder = RemoveHtml($this->nama_customer->caption());

        // nilai_po
        $this->nilai_po->EditAttrs["class"] = "form-control";
        $this->nilai_po->EditCustomAttributes = "";
        $this->nilai_po->EditValue = $this->nilai_po->CurrentValue;
        $this->nilai_po->PlaceHolder = RemoveHtml($this->nilai_po->caption());
        if (strval($this->nilai_po->EditValue) != "" && is_numeric($this->nilai_po->EditValue)) {
            $this->nilai_po->EditValue = FormatNumber($this->nilai_po->EditValue, -2, -2, -2, -2);
        }

        // nilai_faktur
        $this->nilai_faktur->EditAttrs["class"] = "form-control";
        $this->nilai_faktur->EditCustomAttributes = "";
        $this->nilai_faktur->EditValue = $this->nilai_faktur->CurrentValue;
        $this->nilai_faktur->PlaceHolder = RemoveHtml($this->nilai_faktur->caption());

        // piutang
        $this->piutang->EditAttrs["class"] = "form-control";
        $this->piutang->EditCustomAttributes = "";
        $this->piutang->EditValue = $this->piutang->CurrentValue;
        $this->piutang->PlaceHolder = RemoveHtml($this->piutang->caption());

        // nomor_handphone
        $this->nomor_handphone->EditAttrs["class"] = "form-control";
        $this->nomor_handphone->EditCustomAttributes = "";
        if (!$this->nomor_handphone->Raw) {
            $this->nomor_handphone->CurrentValue = HtmlDecode($this->nomor_handphone->CurrentValue);
        }
        $this->nomor_handphone->EditValue = $this->nomor_handphone->CurrentValue;
        $this->nomor_handphone->PlaceHolder = RemoveHtml($this->nomor_handphone->caption());

        // kode_order
        $this->kode_order->EditAttrs["class"] = "form-control";
        $this->kode_order->EditCustomAttributes = "";
        if (!$this->kode_order->Raw) {
            $this->kode_order->CurrentValue = HtmlDecode($this->kode_order->CurrentValue);
        }
        $this->kode_order->EditValue = $this->kode_order->CurrentValue;
        $this->kode_order->PlaceHolder = RemoveHtml($this->kode_order->caption());

        // tgl_faktur
        $this->tgl_faktur->EditAttrs["class"] = "form-control";
        $this->tgl_faktur->EditCustomAttributes = "";
        if (!$this->tgl_faktur->Raw) {
            $this->tgl_faktur->CurrentValue = HtmlDecode($this->tgl_faktur->CurrentValue);
        }
        $this->tgl_faktur->EditValue = $this->tgl_faktur->CurrentValue;
        $this->tgl_faktur->PlaceHolder = RemoveHtml($this->tgl_faktur->caption());

        // umur_faktur
        $this->umur_faktur->EditAttrs["class"] = "form-control";
        $this->umur_faktur->EditCustomAttributes = "";
        $this->umur_faktur->EditValue = $this->umur_faktur->CurrentValue;
        $this->umur_faktur->PlaceHolder = RemoveHtml($this->umur_faktur->caption());

        // idorder
        $this->idorder->EditAttrs["class"] = "form-control";
        $this->idorder->EditCustomAttributes = "";
        $this->idorder->EditValue = $this->idorder->CurrentValue;
        $this->idorder->PlaceHolder = RemoveHtml($this->idorder->caption());

        // kode_faktur
        $this->kode_faktur->EditAttrs["class"] = "form-control";
        $this->kode_faktur->EditCustomAttributes = "";
        if (!$this->kode_faktur->Raw) {
            $this->kode_faktur->CurrentValue = HtmlDecode($this->kode_faktur->CurrentValue);
        }
        $this->kode_faktur->EditValue = $this->kode_faktur->CurrentValue;
        $this->kode_faktur->PlaceHolder = RemoveHtml($this->kode_faktur->caption());

        // jatuhtempo
        $this->jatuhtempo->EditAttrs["class"] = "form-control";
        $this->jatuhtempo->EditCustomAttributes = "";
        if (!$this->jatuhtempo->Raw) {
            $this->jatuhtempo->CurrentValue = HtmlDecode($this->jatuhtempo->CurrentValue);
        }
        $this->jatuhtempo->EditValue = $this->jatuhtempo->CurrentValue;
        $this->jatuhtempo->PlaceHolder = RemoveHtml($this->jatuhtempo->caption());

        // term_payment
        $this->term_payment->EditAttrs["class"] = "form-control";
        $this->term_payment->EditCustomAttributes = "";
        $this->term_payment->EditValue = $this->term_payment->CurrentValue;
        $this->term_payment->PlaceHolder = RemoveHtml($this->term_payment->caption());

        // tgl_penagihan
        $this->tgl_penagihan->EditAttrs["class"] = "form-control";
        $this->tgl_penagihan->EditCustomAttributes = "";
        if (!$this->tgl_penagihan->Raw) {
            $this->tgl_penagihan->CurrentValue = HtmlDecode($this->tgl_penagihan->CurrentValue);
        }
        $this->tgl_penagihan->EditValue = $this->tgl_penagihan->CurrentValue;
        $this->tgl_penagihan->PlaceHolder = RemoveHtml($this->tgl_penagihan->caption());

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
                    $doc->exportCaption($this->nama_customer);
                    $doc->exportCaption($this->nilai_po);
                    $doc->exportCaption($this->nilai_faktur);
                    $doc->exportCaption($this->piutang);
                    $doc->exportCaption($this->nomor_handphone);
                    $doc->exportCaption($this->kode_order);
                    $doc->exportCaption($this->tgl_faktur);
                    $doc->exportCaption($this->umur_faktur);
                    $doc->exportCaption($this->idorder);
                    $doc->exportCaption($this->kode_faktur);
                    $doc->exportCaption($this->jatuhtempo);
                    $doc->exportCaption($this->term_payment);
                    $doc->exportCaption($this->tgl_penagihan);
                } else {
                    $doc->exportCaption($this->tgl_order);
                    $doc->exportCaption($this->nama_customer);
                    $doc->exportCaption($this->nilai_po);
                    $doc->exportCaption($this->nilai_faktur);
                    $doc->exportCaption($this->piutang);
                    $doc->exportCaption($this->nomor_handphone);
                    $doc->exportCaption($this->kode_order);
                    $doc->exportCaption($this->tgl_faktur);
                    $doc->exportCaption($this->umur_faktur);
                    $doc->exportCaption($this->idorder);
                    $doc->exportCaption($this->kode_faktur);
                    $doc->exportCaption($this->jatuhtempo);
                    $doc->exportCaption($this->term_payment);
                    $doc->exportCaption($this->tgl_penagihan);
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
                        $doc->exportField($this->nama_customer);
                        $doc->exportField($this->nilai_po);
                        $doc->exportField($this->nilai_faktur);
                        $doc->exportField($this->piutang);
                        $doc->exportField($this->nomor_handphone);
                        $doc->exportField($this->kode_order);
                        $doc->exportField($this->tgl_faktur);
                        $doc->exportField($this->umur_faktur);
                        $doc->exportField($this->idorder);
                        $doc->exportField($this->kode_faktur);
                        $doc->exportField($this->jatuhtempo);
                        $doc->exportField($this->term_payment);
                        $doc->exportField($this->tgl_penagihan);
                    } else {
                        $doc->exportField($this->tgl_order);
                        $doc->exportField($this->nama_customer);
                        $doc->exportField($this->nilai_po);
                        $doc->exportField($this->nilai_faktur);
                        $doc->exportField($this->piutang);
                        $doc->exportField($this->nomor_handphone);
                        $doc->exportField($this->kode_order);
                        $doc->exportField($this->tgl_faktur);
                        $doc->exportField($this->umur_faktur);
                        $doc->exportField($this->idorder);
                        $doc->exportField($this->kode_faktur);
                        $doc->exportField($this->jatuhtempo);
                        $doc->exportField($this->term_payment);
                        $doc->exportField($this->tgl_penagihan);
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
