<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for pegawai
 */
class Pegawai extends DbTable
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
    public $kode;
    public $nama;
    public $alamat;
    public $_email;
    public $wa;
    public $hp;
    public $tgllahir;
    public $rekbank;
    public $foto;
    public $_username;
    public $_password;
    public $level;
    public $aktif;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'pegawai';
        $this->TableName = 'pegawai';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`pegawai`";
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
        $this->id = new DbField('pegawai', 'pegawai', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // pid
        $this->pid = new DbField('pegawai', 'pegawai', 'x_pid', 'pid', '`pid`', '`pid`', 3, 11, -1, false, '`pid`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->pid->Sortable = true; // Allow sort
        $this->pid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pid->Param, "CustomMsg");
        $this->pid->AdvancedSearch->SearchValueDefault = CurrentUserID();
        $this->pid->AdvancedSearch->SearchOperatorDefault = "=";
        $this->pid->AdvancedSearch->SearchOperatorDefault2 = "";
        $this->pid->AdvancedSearch->SearchConditionDefault = "AND";
        $this->Fields['pid'] = &$this->pid;

        // kode
        $this->kode = new DbField('pegawai', 'pegawai', 'x_kode', 'kode', '`kode`', '`kode`', 200, 20, -1, false, '`kode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode->Nullable = false; // NOT NULL field
        $this->kode->Required = true; // Required field
        $this->kode->Sortable = true; // Allow sort
        $this->kode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode->Param, "CustomMsg");
        $this->Fields['kode'] = &$this->kode;

        // nama
        $this->nama = new DbField('pegawai', 'pegawai', 'x_nama', 'nama', '`nama`', '`nama`', 200, 100, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // alamat
        $this->alamat = new DbField('pegawai', 'pegawai', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, 255, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // email
        $this->_email = new DbField('pegawai', 'pegawai', 'x__email', 'email', '`email`', '`email`', 200, 100, -1, false, '`email`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_email->Required = true; // Required field
        $this->_email->Sortable = true; // Allow sort
        $this->_email->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_email->Param, "CustomMsg");
        $this->Fields['email'] = &$this->_email;

        // wa
        $this->wa = new DbField('pegawai', 'pegawai', 'x_wa', 'wa', '`wa`', '`wa`', 200, 20, -1, false, '`wa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->wa->Required = true; // Required field
        $this->wa->Sortable = true; // Allow sort
        $this->wa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->wa->Param, "CustomMsg");
        $this->Fields['wa'] = &$this->wa;

        // hp
        $this->hp = new DbField('pegawai', 'pegawai', 'x_hp', 'hp', '`hp`', '`hp`', 200, 15, -1, false, '`hp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hp->Sortable = true; // Allow sort
        $this->hp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hp->Param, "CustomMsg");
        $this->Fields['hp'] = &$this->hp;

        // tgllahir
        $this->tgllahir = new DbField('pegawai', 'pegawai', 'x_tgllahir', 'tgllahir', '`tgllahir`', CastDateFieldForLike("`tgllahir`", 0, "DB"), 133, 10, 0, false, '`tgllahir`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgllahir->Sortable = true; // Allow sort
        $this->tgllahir->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgllahir->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgllahir->Param, "CustomMsg");
        $this->Fields['tgllahir'] = &$this->tgllahir;

        // rekbank
        $this->rekbank = new DbField('pegawai', 'pegawai', 'x_rekbank', 'rekbank', '`rekbank`', '`rekbank`', 200, 255, -1, false, '`rekbank`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->rekbank->Sortable = true; // Allow sort
        $this->rekbank->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->rekbank->Param, "CustomMsg");
        $this->Fields['rekbank'] = &$this->rekbank;

        // foto
        $this->foto = new DbField('pegawai', 'pegawai', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, true, '`foto`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // username
        $this->_username = new DbField('pegawai', 'pegawai', 'x__username', 'username', '`username`', '`username`', 200, 255, -1, false, '`username`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_username->Nullable = false; // NOT NULL field
        $this->_username->Required = true; // Required field
        $this->_username->Sortable = true; // Allow sort
        $this->_username->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_username->Param, "CustomMsg");
        $this->Fields['username'] = &$this->_username;

        // password
        $this->_password = new DbField('pegawai', 'pegawai', 'x__password', 'password', '`password`', '`password`', 200, 255, -1, false, '`password`', false, false, false, 'FORMATTED TEXT', 'PASSWORD');
        if (Config("ENCRYPTED_PASSWORD")) {
            $this->_password->Raw = true;
        }
        $this->_password->Nullable = false; // NOT NULL field
        $this->_password->Required = true; // Required field
        $this->_password->Sortable = true; // Allow sort
        $this->_password->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_password->Param, "CustomMsg");
        $this->Fields['password'] = &$this->_password;

        // level
        $this->level = new DbField('pegawai', 'pegawai', 'x_level', 'level', '`level`', '`level`', 3, 11, -1, false, '`level`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->level->Nullable = false; // NOT NULL field
        $this->level->Required = true; // Required field
        $this->level->Sortable = true; // Allow sort
        $this->level->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->level->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->level->Lookup = new Lookup('level', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->level->Lookup = new Lookup('level', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->level->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->level->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->level->Param, "CustomMsg");
        $this->Fields['level'] = &$this->level;

        // aktif
        $this->aktif = new DbField('pegawai', 'pegawai', 'x_aktif', 'aktif', '`aktif`', '`aktif`', 16, 1, -1, false, '`aktif`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aktif->Nullable = false; // NOT NULL field
        $this->aktif->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aktif->Lookup = new Lookup('aktif', 'pegawai', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aktif->Lookup = new Lookup('aktif', 'pegawai', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aktif->OptionCount = 2;
        $this->aktif->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->aktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aktif->Param, "CustomMsg");
        $this->Fields['aktif'] = &$this->aktif;
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
        if ($this->getCurrentDetailTable() == "customer") {
            $detailUrl = Container("customer")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "PegawaiList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`pegawai`";
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                if ($value == $this->Fields[$name]->OldValue) { // No need to update hashed password if not changed
                    continue;
                }
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
        $this->kode->DbValue = $row['kode'];
        $this->nama->DbValue = $row['nama'];
        $this->alamat->DbValue = $row['alamat'];
        $this->_email->DbValue = $row['email'];
        $this->wa->DbValue = $row['wa'];
        $this->hp->DbValue = $row['hp'];
        $this->tgllahir->DbValue = $row['tgllahir'];
        $this->rekbank->DbValue = $row['rekbank'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->_username->DbValue = $row['username'];
        $this->_password->DbValue = $row['password'];
        $this->level->DbValue = $row['level'];
        $this->aktif->DbValue = $row['aktif'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['foto']) ? [] : [$row['foto']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->foto->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
            }
        }
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
        return $_SESSION[$name] ?? GetUrl("PegawaiList");
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
        if ($pageName == "PegawaiView") {
            return $Language->phrase("View");
        } elseif ($pageName == "PegawaiEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "PegawaiAdd") {
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
                return "PegawaiView";
            case Config("API_ADD_ACTION"):
                return "PegawaiAdd";
            case Config("API_EDIT_ACTION"):
                return "PegawaiEdit";
            case Config("API_DELETE_ACTION"):
                return "PegawaiDelete";
            case Config("API_LIST_ACTION"):
                return "PegawaiList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "PegawaiList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PegawaiView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PegawaiView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PegawaiAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "PegawaiAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PegawaiEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PegawaiEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("PegawaiAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PegawaiAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("PegawaiDelete", $this->getUrlParm());
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
        $this->pid->setDbValue($row['pid']);
        $this->kode->setDbValue($row['kode']);
        $this->nama->setDbValue($row['nama']);
        $this->alamat->setDbValue($row['alamat']);
        $this->_email->setDbValue($row['email']);
        $this->wa->setDbValue($row['wa']);
        $this->hp->setDbValue($row['hp']);
        $this->tgllahir->setDbValue($row['tgllahir']);
        $this->rekbank->setDbValue($row['rekbank']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->_username->setDbValue($row['username']);
        $this->_password->setDbValue($row['password']);
        $this->level->setDbValue($row['level']);
        $this->aktif->setDbValue($row['aktif']);
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

        // kode

        // nama

        // alamat

        // email

        // wa

        // hp

        // tgllahir

        // rekbank

        // foto

        // username

        // password

        // level

        // aktif

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // pid
        $this->pid->ViewValue = $this->pid->CurrentValue;
        $this->pid->ViewValue = FormatNumber($this->pid->ViewValue, 0, -2, -2, -2);
        $this->pid->ViewCustomAttributes = "";

        // kode
        $this->kode->ViewValue = $this->kode->CurrentValue;
        $this->kode->ViewCustomAttributes = "";

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

        // alamat
        $this->alamat->ViewValue = $this->alamat->CurrentValue;
        $this->alamat->ViewCustomAttributes = "";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->ViewCustomAttributes = "";

        // wa
        $this->wa->ViewValue = $this->wa->CurrentValue;
        $this->wa->ViewCustomAttributes = "";

        // hp
        $this->hp->ViewValue = $this->hp->CurrentValue;
        $this->hp->ViewCustomAttributes = "";

        // tgllahir
        $this->tgllahir->ViewValue = $this->tgllahir->CurrentValue;
        $this->tgllahir->ViewValue = FormatDateTime($this->tgllahir->ViewValue, 0);
        $this->tgllahir->ViewCustomAttributes = "";

        // rekbank
        $this->rekbank->ViewValue = $this->rekbank->CurrentValue;
        $this->rekbank->ViewCustomAttributes = "";

        // foto
        if (!EmptyValue($this->foto->Upload->DbValue)) {
            $this->foto->ViewValue = $this->foto->Upload->DbValue;
        } else {
            $this->foto->ViewValue = "";
        }
        $this->foto->ViewCustomAttributes = "";

        // username
        $this->_username->ViewValue = $this->_username->CurrentValue;
        $this->_username->ViewCustomAttributes = "";

        // password
        $this->_password->ViewValue = $Language->phrase("PasswordMask");
        $this->_password->ViewCustomAttributes = "";

        // level
        if ($Security->canAdmin()) { // System admin
            $curVal = trim(strval($this->level->CurrentValue));
            if ($curVal != "") {
                $this->level->ViewValue = $this->level->lookupCacheOption($curVal);
                if ($this->level->ViewValue === null) { // Lookup from database
                    $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->level->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->level->Lookup->renderViewRow($rswrk[0]);
                        $this->level->ViewValue = $this->level->displayValue($arwrk);
                    } else {
                        $this->level->ViewValue = $this->level->CurrentValue;
                    }
                }
            } else {
                $this->level->ViewValue = null;
            }
        } else {
            $this->level->ViewValue = $Language->phrase("PasswordMask");
        }
        $this->level->ViewCustomAttributes = "";

        // aktif
        if (strval($this->aktif->CurrentValue) != "") {
            $this->aktif->ViewValue = $this->aktif->optionCaption($this->aktif->CurrentValue);
        } else {
            $this->aktif->ViewValue = null;
        }
        $this->aktif->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // pid
        $this->pid->LinkCustomAttributes = "";
        $this->pid->HrefValue = "";
        $this->pid->TooltipValue = "";

        // kode
        $this->kode->LinkCustomAttributes = "";
        $this->kode->HrefValue = "";
        $this->kode->TooltipValue = "";

        // nama
        $this->nama->LinkCustomAttributes = "";
        $this->nama->HrefValue = "";
        $this->nama->TooltipValue = "";

        // alamat
        $this->alamat->LinkCustomAttributes = "";
        $this->alamat->HrefValue = "";
        $this->alamat->TooltipValue = "";

        // email
        $this->_email->LinkCustomAttributes = "";
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // wa
        $this->wa->LinkCustomAttributes = "";
        $this->wa->HrefValue = "";
        $this->wa->TooltipValue = "";

        // hp
        $this->hp->LinkCustomAttributes = "";
        $this->hp->HrefValue = "";
        $this->hp->TooltipValue = "";

        // tgllahir
        $this->tgllahir->LinkCustomAttributes = "";
        $this->tgllahir->HrefValue = "";
        $this->tgllahir->TooltipValue = "";

        // rekbank
        $this->rekbank->LinkCustomAttributes = "";
        $this->rekbank->HrefValue = "";
        $this->rekbank->TooltipValue = "";

        // foto
        $this->foto->LinkCustomAttributes = "";
        $this->foto->HrefValue = "";
        $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
        $this->foto->TooltipValue = "";

        // username
        $this->_username->LinkCustomAttributes = "";
        $this->_username->HrefValue = "";
        $this->_username->TooltipValue = "";

        // password
        $this->_password->LinkCustomAttributes = "";
        $this->_password->HrefValue = "";
        $this->_password->TooltipValue = "";

        // level
        $this->level->LinkCustomAttributes = "";
        $this->level->HrefValue = "";
        $this->level->TooltipValue = "";

        // aktif
        $this->aktif->LinkCustomAttributes = "";
        $this->aktif->HrefValue = "";
        $this->aktif->TooltipValue = "";

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
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            $this->pid->CurrentValue = CurrentUserID();
            $this->pid->EditValue = $this->pid->CurrentValue;
            $this->pid->EditValue = FormatNumber($this->pid->EditValue, 0, -2, -2, -2);
            $this->pid->ViewCustomAttributes = "";
        } else {
        }

        // kode
        $this->kode->EditAttrs["class"] = "form-control";
        $this->kode->EditCustomAttributes = "readonly";
        $this->kode->EditValue = $this->kode->CurrentValue;
        $this->kode->ViewCustomAttributes = "";

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        if (!$this->alamat->Raw) {
            $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
        }
        $this->alamat->EditValue = $this->alamat->CurrentValue;
        $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

        // email
        $this->_email->EditAttrs["class"] = "form-control";
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // wa
        $this->wa->EditAttrs["class"] = "form-control";
        $this->wa->EditCustomAttributes = "";
        if (!$this->wa->Raw) {
            $this->wa->CurrentValue = HtmlDecode($this->wa->CurrentValue);
        }
        $this->wa->EditValue = $this->wa->CurrentValue;
        $this->wa->PlaceHolder = RemoveHtml($this->wa->caption());

        // hp
        $this->hp->EditAttrs["class"] = "form-control";
        $this->hp->EditCustomAttributes = "";
        if (!$this->hp->Raw) {
            $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
        }
        $this->hp->EditValue = $this->hp->CurrentValue;
        $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

        // tgllahir
        $this->tgllahir->EditAttrs["class"] = "form-control";
        $this->tgllahir->EditCustomAttributes = "";
        $this->tgllahir->EditValue = FormatDateTime($this->tgllahir->CurrentValue, 8);
        $this->tgllahir->PlaceHolder = RemoveHtml($this->tgllahir->caption());

        // rekbank
        $this->rekbank->EditAttrs["class"] = "form-control";
        $this->rekbank->EditCustomAttributes = "";
        if (!$this->rekbank->Raw) {
            $this->rekbank->CurrentValue = HtmlDecode($this->rekbank->CurrentValue);
        }
        $this->rekbank->EditValue = $this->rekbank->CurrentValue;
        $this->rekbank->PlaceHolder = RemoveHtml($this->rekbank->caption());

        // foto
        $this->foto->EditAttrs["class"] = "form-control";
        $this->foto->EditCustomAttributes = "";
        if (!EmptyValue($this->foto->Upload->DbValue)) {
            $this->foto->EditValue = $this->foto->Upload->DbValue;
        } else {
            $this->foto->EditValue = "";
        }
        if (!EmptyValue($this->foto->CurrentValue)) {
            $this->foto->Upload->FileName = $this->foto->CurrentValue;
        }

        // username
        $this->_username->EditAttrs["class"] = "form-control";
        $this->_username->EditCustomAttributes = "";
        if (!$this->_username->Raw) {
            $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
        }
        $this->_username->EditValue = $this->_username->CurrentValue;
        $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

        // password
        $this->_password->EditAttrs["class"] = "form-control";
        $this->_password->EditCustomAttributes = "";
        $this->_password->EditValue = $Language->phrase("PasswordMask"); // Show as masked password
        $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

        // level
        $this->level->EditAttrs["class"] = "form-control";
        $this->level->EditCustomAttributes = "";
        if (!$Security->canAdmin()) { // System admin
            $this->level->EditValue = $Language->phrase("PasswordMask");
        } else {
            $this->level->PlaceHolder = RemoveHtml($this->level->caption());
        }

        // aktif
        $this->aktif->EditCustomAttributes = "";
        $this->aktif->EditValue = $this->aktif->options(false);
        $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

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
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->wa);
                    $doc->exportCaption($this->hp);
                    $doc->exportCaption($this->tgllahir);
                    $doc->exportCaption($this->rekbank);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->_password);
                    $doc->exportCaption($this->level);
                    $doc->exportCaption($this->aktif);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->pid);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->wa);
                    $doc->exportCaption($this->hp);
                    $doc->exportCaption($this->tgllahir);
                    $doc->exportCaption($this->rekbank);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->_password);
                    $doc->exportCaption($this->level);
                    $doc->exportCaption($this->aktif);
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
                        $doc->exportField($this->nama);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->wa);
                        $doc->exportField($this->hp);
                        $doc->exportField($this->tgllahir);
                        $doc->exportField($this->rekbank);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->_password);
                        $doc->exportField($this->level);
                        $doc->exportField($this->aktif);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->pid);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->wa);
                        $doc->exportField($this->hp);
                        $doc->exportField($this->tgllahir);
                        $doc->exportField($this->rekbank);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->_password);
                        $doc->exportField($this->level);
                        $doc->exportField($this->aktif);
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

    // User ID filter
    public function getUserIDFilter($userId)
    {
        $userIdFilter = '`id` = ' . QuotedValue($userId, DATATYPE_NUMBER, Config("USER_TABLE_DBID"));
        $parentUserIdFilter = '`id` IN (SELECT `id` FROM ' . "`pegawai`" . ' WHERE `pid` = ' . QuotedValue($userId, DATATYPE_NUMBER, Config("USER_TABLE_DBID")) . ')';
        $userIdFilter = "($userIdFilter) OR ($parentUserIdFilter)";
        return $userIdFilter;
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
                $filterWrk = '`id` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // Add Parent User ID filter
    public function addParentUserIDFilter($userId)
    {
        global $Security;
        if (!$Security->isAdmin()) {
            $result = $Security->parentUserIDList($userId);
            if ($result != "") {
                $result = '`id` IN (' . $result . ')';
            }
            return $result;
        }
        return "";
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM `pegawai`";
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
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'foto') {
            $fldName = "foto";
            $fileNameFld = "foto";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
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
        $rsnew['kode'] = getNextKode('pegawai', 0);
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
