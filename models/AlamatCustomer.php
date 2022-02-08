<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for alamat_customer
 */
class AlamatCustomer extends DbTable
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
    public $idcustomer;
    public $alias;
    public $penerima;
    public $telepon;
    public $alamat;
    public $idprovinsi;
    public $idkabupaten;
    public $idkecamatan;
    public $idkelurahan;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'alamat_customer';
        $this->TableName = 'alamat_customer';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`alamat_customer`";
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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('alamat_customer', 'alamat_customer', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idcustomer
        $this->idcustomer = new DbField('alamat_customer', 'alamat_customer', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 21, 20, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idcustomer->IsForeignKey = true; // Foreign key field
        $this->idcustomer->Nullable = false; // NOT NULL field
        $this->idcustomer->Required = true; // Required field
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idcustomer->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
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

        // alias
        $this->alias = new DbField('alamat_customer', 'alamat_customer', 'x_alias', 'alias', '`alias`', '`alias`', 200, 255, -1, false, '`alias`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alias->Nullable = false; // NOT NULL field
        $this->alias->Required = true; // Required field
        $this->alias->Sortable = true; // Allow sort
        $this->alias->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alias->Param, "CustomMsg");
        $this->Fields['alias'] = &$this->alias;

        // penerima
        $this->penerima = new DbField('alamat_customer', 'alamat_customer', 'x_penerima', 'penerima', '`penerima`', '`penerima`', 200, 255, -1, false, '`penerima`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->penerima->Nullable = false; // NOT NULL field
        $this->penerima->Required = true; // Required field
        $this->penerima->Sortable = true; // Allow sort
        $this->penerima->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->penerima->Param, "CustomMsg");
        $this->Fields['penerima'] = &$this->penerima;

        // telepon
        $this->telepon = new DbField('alamat_customer', 'alamat_customer', 'x_telepon', 'telepon', '`telepon`', '`telepon`', 200, 15, -1, false, '`telepon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->telepon->Nullable = false; // NOT NULL field
        $this->telepon->Required = true; // Required field
        $this->telepon->Sortable = true; // Allow sort
        $this->telepon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->telepon->Param, "CustomMsg");
        $this->Fields['telepon'] = &$this->telepon;

        // alamat
        $this->alamat = new DbField('alamat_customer', 'alamat_customer', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 201, 65535, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // idprovinsi
        $this->idprovinsi = new DbField('alamat_customer', 'alamat_customer', 'x_idprovinsi', 'idprovinsi', '`idprovinsi`', '`idprovinsi`', 21, 20, -1, false, '`idprovinsi`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idprovinsi->Sortable = true; // Allow sort
        $this->idprovinsi->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idprovinsi->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idprovinsi->Lookup = new Lookup('idprovinsi', 'provinsi', false, 'id', ["name","","",""], [], ["x_idkabupaten"], [], [], [], [], '', '');
                break;
            default:
                $this->idprovinsi->Lookup = new Lookup('idprovinsi', 'provinsi', false, 'id', ["name","","",""], [], ["x_idkabupaten"], [], [], [], [], '', '');
                break;
        }
        $this->idprovinsi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idprovinsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idprovinsi->Param, "CustomMsg");
        $this->Fields['idprovinsi'] = &$this->idprovinsi;

        // idkabupaten
        $this->idkabupaten = new DbField('alamat_customer', 'alamat_customer', 'x_idkabupaten', 'idkabupaten', '`idkabupaten`', '`idkabupaten`', 21, 20, -1, false, '`idkabupaten`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkabupaten->Sortable = true; // Allow sort
        $this->idkabupaten->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkabupaten->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkabupaten->Lookup = new Lookup('idkabupaten', 'kabupaten', false, 'id', ["nama","","",""], ["x_idprovinsi"], ["x_idkecamatan"], ["idprovinsi"], ["x_idprovinsi"], [], [], '', '');
                break;
            default:
                $this->idkabupaten->Lookup = new Lookup('idkabupaten', 'kabupaten', false, 'id', ["nama","","",""], ["x_idprovinsi"], ["x_idkecamatan"], ["idprovinsi"], ["x_idprovinsi"], [], [], '', '');
                break;
        }
        $this->idkabupaten->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkabupaten->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkabupaten->Param, "CustomMsg");
        $this->Fields['idkabupaten'] = &$this->idkabupaten;

        // idkecamatan
        $this->idkecamatan = new DbField('alamat_customer', 'alamat_customer', 'x_idkecamatan', 'idkecamatan', '`idkecamatan`', '`idkecamatan`', 21, 20, -1, false, '`idkecamatan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkecamatan->Sortable = true; // Allow sort
        $this->idkecamatan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkecamatan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkecamatan->Lookup = new Lookup('idkecamatan', 'kecamatan', false, 'id', ["nama","","",""], ["x_idkabupaten"], ["x_idkelurahan"], ["idkabupaten"], ["x_idkabupaten"], [], [], '', '');
                break;
            default:
                $this->idkecamatan->Lookup = new Lookup('idkecamatan', 'kecamatan', false, 'id', ["nama","","",""], ["x_idkabupaten"], ["x_idkelurahan"], ["idkabupaten"], ["x_idkabupaten"], [], [], '', '');
                break;
        }
        $this->idkecamatan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkecamatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkecamatan->Param, "CustomMsg");
        $this->Fields['idkecamatan'] = &$this->idkecamatan;

        // idkelurahan
        $this->idkelurahan = new DbField('alamat_customer', 'alamat_customer', 'x_idkelurahan', 'idkelurahan', '`idkelurahan`', '`idkelurahan`', 21, 20, -1, false, '`idkelurahan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idkelurahan->Sortable = true; // Allow sort
        $this->idkelurahan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idkelurahan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idkelurahan->Lookup = new Lookup('idkelurahan', 'kelurahan', false, 'id', ["nama","","",""], ["x_idkecamatan"], [], ["idkecamatan"], ["x_idkecamatan"], [], [], '', '');
                break;
            default:
                $this->idkelurahan->Lookup = new Lookup('idkelurahan', 'kelurahan', false, 'id', ["nama","","",""], ["x_idkecamatan"], [], ["idkecamatan"], ["x_idkecamatan"], [], [], '', '');
                break;
        }
        $this->idkelurahan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idkelurahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idkelurahan->Param, "CustomMsg");
        $this->Fields['idkelurahan'] = &$this->idkelurahan;
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
        if ($this->getCurrentMasterTable() == "customer") {
            if ($this->idcustomer->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->idcustomer->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "customer") {
            if ($this->idcustomer->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`idcustomer`", $this->idcustomer->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_customer()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_customer()
    {
        return "`idcustomer`=@idcustomer@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`alamat_customer`";
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
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->alias->DbValue = $row['alias'];
        $this->penerima->DbValue = $row['penerima'];
        $this->telepon->DbValue = $row['telepon'];
        $this->alamat->DbValue = $row['alamat'];
        $this->idprovinsi->DbValue = $row['idprovinsi'];
        $this->idkabupaten->DbValue = $row['idkabupaten'];
        $this->idkecamatan->DbValue = $row['idkecamatan'];
        $this->idkelurahan->DbValue = $row['idkelurahan'];
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
        return $_SESSION[$name] ?? GetUrl("AlamatCustomerList");
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
        if ($pageName == "AlamatCustomerView") {
            return $Language->phrase("View");
        } elseif ($pageName == "AlamatCustomerEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "AlamatCustomerAdd") {
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
                return "AlamatCustomerView";
            case Config("API_ADD_ACTION"):
                return "AlamatCustomerAdd";
            case Config("API_EDIT_ACTION"):
                return "AlamatCustomerEdit";
            case Config("API_DELETE_ACTION"):
                return "AlamatCustomerDelete";
            case Config("API_LIST_ACTION"):
                return "AlamatCustomerList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "AlamatCustomerList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("AlamatCustomerView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("AlamatCustomerView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "AlamatCustomerAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "AlamatCustomerAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("AlamatCustomerEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("AlamatCustomerAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("AlamatCustomerDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "customer" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->idcustomer->CurrentValue ?? $this->idcustomer->getSessionValue());
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
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->alias->setDbValue($row['alias']);
        $this->penerima->setDbValue($row['penerima']);
        $this->telepon->setDbValue($row['telepon']);
        $this->alamat->setDbValue($row['alamat']);
        $this->idprovinsi->setDbValue($row['idprovinsi']);
        $this->idkabupaten->setDbValue($row['idkabupaten']);
        $this->idkecamatan->setDbValue($row['idkecamatan']);
        $this->idkelurahan->setDbValue($row['idkelurahan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // idcustomer

        // alias

        // penerima

        // telepon

        // alamat

        // idprovinsi

        // idkabupaten

        // idkecamatan

        // idkelurahan

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idcustomer
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

        // alias
        $this->alias->ViewValue = $this->alias->CurrentValue;
        $this->alias->ViewCustomAttributes = "";

        // penerima
        $this->penerima->ViewValue = $this->penerima->CurrentValue;
        $this->penerima->ViewCustomAttributes = "";

        // telepon
        $this->telepon->ViewValue = $this->telepon->CurrentValue;
        $this->telepon->ViewCustomAttributes = "";

        // alamat
        $this->alamat->ViewValue = $this->alamat->CurrentValue;
        $this->alamat->ViewCustomAttributes = "";

        // idprovinsi
        $curVal = trim(strval($this->idprovinsi->CurrentValue));
        if ($curVal != "") {
            $this->idprovinsi->ViewValue = $this->idprovinsi->lookupCacheOption($curVal);
            if ($this->idprovinsi->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idprovinsi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idprovinsi->Lookup->renderViewRow($rswrk[0]);
                    $this->idprovinsi->ViewValue = $this->idprovinsi->displayValue($arwrk);
                } else {
                    $this->idprovinsi->ViewValue = $this->idprovinsi->CurrentValue;
                }
            }
        } else {
            $this->idprovinsi->ViewValue = null;
        }
        $this->idprovinsi->ViewCustomAttributes = "";

        // idkabupaten
        $curVal = trim(strval($this->idkabupaten->CurrentValue));
        if ($curVal != "") {
            $this->idkabupaten->ViewValue = $this->idkabupaten->lookupCacheOption($curVal);
            if ($this->idkabupaten->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idkabupaten->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idkabupaten->Lookup->renderViewRow($rswrk[0]);
                    $this->idkabupaten->ViewValue = $this->idkabupaten->displayValue($arwrk);
                } else {
                    $this->idkabupaten->ViewValue = $this->idkabupaten->CurrentValue;
                }
            }
        } else {
            $this->idkabupaten->ViewValue = null;
        }
        $this->idkabupaten->ViewCustomAttributes = "";

        // idkecamatan
        $curVal = trim(strval($this->idkecamatan->CurrentValue));
        if ($curVal != "") {
            $this->idkecamatan->ViewValue = $this->idkecamatan->lookupCacheOption($curVal);
            if ($this->idkecamatan->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idkecamatan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idkecamatan->Lookup->renderViewRow($rswrk[0]);
                    $this->idkecamatan->ViewValue = $this->idkecamatan->displayValue($arwrk);
                } else {
                    $this->idkecamatan->ViewValue = $this->idkecamatan->CurrentValue;
                }
            }
        } else {
            $this->idkecamatan->ViewValue = null;
        }
        $this->idkecamatan->ViewCustomAttributes = "";

        // idkelurahan
        $curVal = trim(strval($this->idkelurahan->CurrentValue));
        if ($curVal != "") {
            $this->idkelurahan->ViewValue = $this->idkelurahan->lookupCacheOption($curVal);
            if ($this->idkelurahan->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idkelurahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idkelurahan->Lookup->renderViewRow($rswrk[0]);
                    $this->idkelurahan->ViewValue = $this->idkelurahan->displayValue($arwrk);
                } else {
                    $this->idkelurahan->ViewValue = $this->idkelurahan->CurrentValue;
                }
            }
        } else {
            $this->idkelurahan->ViewValue = null;
        }
        $this->idkelurahan->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // alias
        $this->alias->LinkCustomAttributes = "";
        $this->alias->HrefValue = "";
        $this->alias->TooltipValue = "";

        // penerima
        $this->penerima->LinkCustomAttributes = "";
        $this->penerima->HrefValue = "";
        $this->penerima->TooltipValue = "";

        // telepon
        $this->telepon->LinkCustomAttributes = "";
        $this->telepon->HrefValue = "";
        $this->telepon->TooltipValue = "";

        // alamat
        $this->alamat->LinkCustomAttributes = "";
        $this->alamat->HrefValue = "";
        $this->alamat->TooltipValue = "";

        // idprovinsi
        $this->idprovinsi->LinkCustomAttributes = "";
        $this->idprovinsi->HrefValue = "";
        $this->idprovinsi->TooltipValue = "";

        // idkabupaten
        $this->idkabupaten->LinkCustomAttributes = "";
        $this->idkabupaten->HrefValue = "";
        $this->idkabupaten->TooltipValue = "";

        // idkecamatan
        $this->idkecamatan->LinkCustomAttributes = "";
        $this->idkecamatan->HrefValue = "";
        $this->idkecamatan->TooltipValue = "";

        // idkelurahan
        $this->idkelurahan->LinkCustomAttributes = "";
        $this->idkelurahan->HrefValue = "";
        $this->idkelurahan->TooltipValue = "";

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

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        if ($this->idcustomer->getSessionValue() != "") {
            $this->idcustomer->CurrentValue = GetForeignKeyValue($this->idcustomer->getSessionValue());
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
        } else {
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());
        }

        // alias
        $this->alias->EditAttrs["class"] = "form-control";
        $this->alias->EditCustomAttributes = "";
        if (!$this->alias->Raw) {
            $this->alias->CurrentValue = HtmlDecode($this->alias->CurrentValue);
        }
        $this->alias->EditValue = $this->alias->CurrentValue;
        $this->alias->PlaceHolder = RemoveHtml($this->alias->caption());

        // penerima
        $this->penerima->EditAttrs["class"] = "form-control";
        $this->penerima->EditCustomAttributes = "";
        if (!$this->penerima->Raw) {
            $this->penerima->CurrentValue = HtmlDecode($this->penerima->CurrentValue);
        }
        $this->penerima->EditValue = $this->penerima->CurrentValue;
        $this->penerima->PlaceHolder = RemoveHtml($this->penerima->caption());

        // telepon
        $this->telepon->EditAttrs["class"] = "form-control";
        $this->telepon->EditCustomAttributes = "";
        if (!$this->telepon->Raw) {
            $this->telepon->CurrentValue = HtmlDecode($this->telepon->CurrentValue);
        }
        $this->telepon->EditValue = $this->telepon->CurrentValue;
        $this->telepon->PlaceHolder = RemoveHtml($this->telepon->caption());

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        $this->alamat->EditValue = $this->alamat->CurrentValue;
        $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

        // idprovinsi
        $this->idprovinsi->EditAttrs["class"] = "form-control";
        $this->idprovinsi->EditCustomAttributes = "";
        $this->idprovinsi->PlaceHolder = RemoveHtml($this->idprovinsi->caption());

        // idkabupaten
        $this->idkabupaten->EditAttrs["class"] = "form-control";
        $this->idkabupaten->EditCustomAttributes = "";
        $this->idkabupaten->PlaceHolder = RemoveHtml($this->idkabupaten->caption());

        // idkecamatan
        $this->idkecamatan->EditAttrs["class"] = "form-control";
        $this->idkecamatan->EditCustomAttributes = "";
        $this->idkecamatan->PlaceHolder = RemoveHtml($this->idkecamatan->caption());

        // idkelurahan
        $this->idkelurahan->EditAttrs["class"] = "form-control";
        $this->idkelurahan->EditCustomAttributes = "";
        $this->idkelurahan->PlaceHolder = RemoveHtml($this->idkelurahan->caption());

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
                    $doc->exportCaption($this->alias);
                    $doc->exportCaption($this->penerima);
                    $doc->exportCaption($this->telepon);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->idprovinsi);
                    $doc->exportCaption($this->idkabupaten);
                    $doc->exportCaption($this->idkecamatan);
                    $doc->exportCaption($this->idkelurahan);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->alias);
                    $doc->exportCaption($this->penerima);
                    $doc->exportCaption($this->telepon);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->idprovinsi);
                    $doc->exportCaption($this->idkabupaten);
                    $doc->exportCaption($this->idkecamatan);
                    $doc->exportCaption($this->idkelurahan);
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
                        $doc->exportField($this->alias);
                        $doc->exportField($this->penerima);
                        $doc->exportField($this->telepon);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->idprovinsi);
                        $doc->exportField($this->idkabupaten);
                        $doc->exportField($this->idkecamatan);
                        $doc->exportField($this->idkelurahan);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->alias);
                        $doc->exportField($this->penerima);
                        $doc->exportField($this->telepon);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->idprovinsi);
                        $doc->exportField($this->idkabupaten);
                        $doc->exportField($this->idkecamatan);
                        $doc->exportField($this->idkelurahan);
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
