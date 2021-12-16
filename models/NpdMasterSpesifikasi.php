<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_master_spesifikasi
 */
class NpdMasterSpesifikasi extends DbTable
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
    public $grup;
    public $kategori;
    public $sediaan;
    public $bentukan;
    public $konsep;
    public $bahanaktif;
    public $fragrance;
    public $aroma;
    public $warna;
    public $aplikasi_sediaan;
    public $aksesoris;
    public $nour;
    public $updated_at;
    public $updated_user;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'npd_master_spesifikasi';
        $this->TableName = 'npd_master_spesifikasi';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_master_spesifikasi`";
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

        // id
        $this->id = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // grup
        $this->grup = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_grup', 'grup', '`grup`', '`grup`', 200, 150, -1, false, '`grup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->grup->Sortable = true; // Allow sort
        $this->grup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->grup->Param, "CustomMsg");
        $this->Fields['grup'] = &$this->grup;

        // kategori
        $this->kategori = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_kategori', 'kategori', '`kategori`', '`kategori`', 200, 150, -1, false, '`kategori`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kategori->Sortable = true; // Allow sort
        $this->kategori->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategori->Param, "CustomMsg");
        $this->Fields['kategori'] = &$this->kategori;

        // sediaan
        $this->sediaan = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_sediaan', 'sediaan', '`sediaan`', '`sediaan`', 200, 150, -1, false, '`sediaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sediaan->Sortable = true; // Allow sort
        $this->sediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sediaan->Param, "CustomMsg");
        $this->Fields['sediaan'] = &$this->sediaan;

        // bentukan
        $this->bentukan = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_bentukan', 'bentukan', '`bentukan`', '`bentukan`', 200, 150, -1, false, '`bentukan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bentukan->Sortable = true; // Allow sort
        $this->bentukan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentukan->Param, "CustomMsg");
        $this->Fields['bentukan'] = &$this->bentukan;

        // konsep
        $this->konsep = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_konsep', 'konsep', '`konsep`', '`konsep`', 200, 150, -1, false, '`konsep`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->konsep->Sortable = true; // Allow sort
        $this->konsep->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->konsep->Param, "CustomMsg");
        $this->Fields['konsep'] = &$this->konsep;

        // bahanaktif
        $this->bahanaktif = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_bahanaktif', 'bahanaktif', '`bahanaktif`', '`bahanaktif`', 200, 150, -1, false, '`bahanaktif`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahanaktif->Sortable = true; // Allow sort
        $this->bahanaktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahanaktif->Param, "CustomMsg");
        $this->Fields['bahanaktif'] = &$this->bahanaktif;

        // fragrance
        $this->fragrance = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_fragrance', 'fragrance', '`fragrance`', '`fragrance`', 200, 150, -1, false, '`fragrance`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fragrance->Sortable = true; // Allow sort
        $this->fragrance->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fragrance->Param, "CustomMsg");
        $this->Fields['fragrance'] = &$this->fragrance;

        // aroma
        $this->aroma = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_aroma', 'aroma', '`aroma`', '`aroma`', 200, 150, -1, false, '`aroma`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aroma->Sortable = true; // Allow sort
        $this->aroma->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aroma->Param, "CustomMsg");
        $this->Fields['aroma'] = &$this->aroma;

        // warna
        $this->warna = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_warna', 'warna', '`warna`', '`warna`', 200, 150, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warna->Sortable = true; // Allow sort
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // aplikasi_sediaan
        $this->aplikasi_sediaan = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_aplikasi_sediaan', 'aplikasi_sediaan', '`aplikasi_sediaan`', '`aplikasi_sediaan`', 200, 150, -1, false, '`aplikasi_sediaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasi_sediaan->Sortable = true; // Allow sort
        $this->aplikasi_sediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasi_sediaan->Param, "CustomMsg");
        $this->Fields['aplikasi_sediaan'] = &$this->aplikasi_sediaan;

        // aksesoris
        $this->aksesoris = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_aksesoris', 'aksesoris', '`aksesoris`', '`aksesoris`', 200, 50, -1, false, '`aksesoris`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aksesoris->Sortable = true; // Allow sort
        $this->aksesoris->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aksesoris->Param, "CustomMsg");
        $this->Fields['aksesoris'] = &$this->aksesoris;

        // nour
        $this->nour = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_nour', 'nour', '`nour`', '`nour`', 3, 11, -1, false, '`nour`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nour->Sortable = true; // Allow sort
        $this->nour->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->nour->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nour->Param, "CustomMsg");
        $this->Fields['nour'] = &$this->nour;

        // updated_at
        $this->updated_at = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;

        // updated_user
        $this->updated_user = new DbField('npd_master_spesifikasi', 'npd_master_spesifikasi', 'x_updated_user', 'updated_user', '`updated_user`', '`updated_user`', 19, 10, -1, false, '`updated_user`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_user->Sortable = true; // Allow sort
        $this->updated_user->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->updated_user->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_user->Param, "CustomMsg");
        $this->Fields['updated_user'] = &$this->updated_user;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_master_spesifikasi`";
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
        $this->grup->DbValue = $row['grup'];
        $this->kategori->DbValue = $row['kategori'];
        $this->sediaan->DbValue = $row['sediaan'];
        $this->bentukan->DbValue = $row['bentukan'];
        $this->konsep->DbValue = $row['konsep'];
        $this->bahanaktif->DbValue = $row['bahanaktif'];
        $this->fragrance->DbValue = $row['fragrance'];
        $this->aroma->DbValue = $row['aroma'];
        $this->warna->DbValue = $row['warna'];
        $this->aplikasi_sediaan->DbValue = $row['aplikasi_sediaan'];
        $this->aksesoris->DbValue = $row['aksesoris'];
        $this->nour->DbValue = $row['nour'];
        $this->updated_at->DbValue = $row['updated_at'];
        $this->updated_user->DbValue = $row['updated_user'];
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
        return $_SESSION[$name] ?? GetUrl("NpdMasterSpesifikasiList");
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
        if ($pageName == "NpdMasterSpesifikasiView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdMasterSpesifikasiEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdMasterSpesifikasiAdd") {
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
                return "NpdMasterSpesifikasiView";
            case Config("API_ADD_ACTION"):
                return "NpdMasterSpesifikasiAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdMasterSpesifikasiEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdMasterSpesifikasiDelete";
            case Config("API_LIST_ACTION"):
                return "NpdMasterSpesifikasiList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdMasterSpesifikasiList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdMasterSpesifikasiView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdMasterSpesifikasiView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdMasterSpesifikasiAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdMasterSpesifikasiAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdMasterSpesifikasiEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdMasterSpesifikasiAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdMasterSpesifikasiDelete", $this->getUrlParm());
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
        $this->grup->setDbValue($row['grup']);
        $this->kategori->setDbValue($row['kategori']);
        $this->sediaan->setDbValue($row['sediaan']);
        $this->bentukan->setDbValue($row['bentukan']);
        $this->konsep->setDbValue($row['konsep']);
        $this->bahanaktif->setDbValue($row['bahanaktif']);
        $this->fragrance->setDbValue($row['fragrance']);
        $this->aroma->setDbValue($row['aroma']);
        $this->warna->setDbValue($row['warna']);
        $this->aplikasi_sediaan->setDbValue($row['aplikasi_sediaan']);
        $this->aksesoris->setDbValue($row['aksesoris']);
        $this->nour->setDbValue($row['nour']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->updated_user->setDbValue($row['updated_user']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // grup

        // kategori

        // sediaan

        // bentukan

        // konsep

        // bahanaktif

        // fragrance

        // aroma

        // warna

        // aplikasi_sediaan

        // aksesoris

        // nour

        // updated_at

        // updated_user

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // grup
        $this->grup->ViewValue = $this->grup->CurrentValue;
        $this->grup->ViewCustomAttributes = "";

        // kategori
        $this->kategori->ViewValue = $this->kategori->CurrentValue;
        $this->kategori->ViewCustomAttributes = "";

        // sediaan
        $this->sediaan->ViewValue = $this->sediaan->CurrentValue;
        $this->sediaan->ViewCustomAttributes = "";

        // bentukan
        $this->bentukan->ViewValue = $this->bentukan->CurrentValue;
        $this->bentukan->ViewCustomAttributes = "";

        // konsep
        $this->konsep->ViewValue = $this->konsep->CurrentValue;
        $this->konsep->ViewCustomAttributes = "";

        // bahanaktif
        $this->bahanaktif->ViewValue = $this->bahanaktif->CurrentValue;
        $this->bahanaktif->ViewCustomAttributes = "";

        // fragrance
        $this->fragrance->ViewValue = $this->fragrance->CurrentValue;
        $this->fragrance->ViewCustomAttributes = "";

        // aroma
        $this->aroma->ViewValue = $this->aroma->CurrentValue;
        $this->aroma->ViewCustomAttributes = "";

        // warna
        $this->warna->ViewValue = $this->warna->CurrentValue;
        $this->warna->ViewCustomAttributes = "";

        // aplikasi_sediaan
        $this->aplikasi_sediaan->ViewValue = $this->aplikasi_sediaan->CurrentValue;
        $this->aplikasi_sediaan->ViewCustomAttributes = "";

        // aksesoris
        $this->aksesoris->ViewValue = $this->aksesoris->CurrentValue;
        $this->aksesoris->ViewCustomAttributes = "";

        // nour
        $this->nour->ViewValue = $this->nour->CurrentValue;
        $this->nour->ViewValue = FormatNumber($this->nour->ViewValue, 0, -2, -2, -2);
        $this->nour->ViewCustomAttributes = "";

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
        $this->updated_at->ViewCustomAttributes = "";

        // updated_user
        $this->updated_user->ViewValue = $this->updated_user->CurrentValue;
        $this->updated_user->ViewValue = FormatNumber($this->updated_user->ViewValue, 0, -2, -2, -2);
        $this->updated_user->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // grup
        $this->grup->LinkCustomAttributes = "";
        $this->grup->HrefValue = "";
        $this->grup->TooltipValue = "";

        // kategori
        $this->kategori->LinkCustomAttributes = "";
        $this->kategori->HrefValue = "";
        $this->kategori->TooltipValue = "";

        // sediaan
        $this->sediaan->LinkCustomAttributes = "";
        $this->sediaan->HrefValue = "";
        $this->sediaan->TooltipValue = "";

        // bentukan
        $this->bentukan->LinkCustomAttributes = "";
        $this->bentukan->HrefValue = "";
        $this->bentukan->TooltipValue = "";

        // konsep
        $this->konsep->LinkCustomAttributes = "";
        $this->konsep->HrefValue = "";
        $this->konsep->TooltipValue = "";

        // bahanaktif
        $this->bahanaktif->LinkCustomAttributes = "";
        $this->bahanaktif->HrefValue = "";
        $this->bahanaktif->TooltipValue = "";

        // fragrance
        $this->fragrance->LinkCustomAttributes = "";
        $this->fragrance->HrefValue = "";
        $this->fragrance->TooltipValue = "";

        // aroma
        $this->aroma->LinkCustomAttributes = "";
        $this->aroma->HrefValue = "";
        $this->aroma->TooltipValue = "";

        // warna
        $this->warna->LinkCustomAttributes = "";
        $this->warna->HrefValue = "";
        $this->warna->TooltipValue = "";

        // aplikasi_sediaan
        $this->aplikasi_sediaan->LinkCustomAttributes = "";
        $this->aplikasi_sediaan->HrefValue = "";
        $this->aplikasi_sediaan->TooltipValue = "";

        // aksesoris
        $this->aksesoris->LinkCustomAttributes = "";
        $this->aksesoris->HrefValue = "";
        $this->aksesoris->TooltipValue = "";

        // nour
        $this->nour->LinkCustomAttributes = "";
        $this->nour->HrefValue = "";
        $this->nour->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

        // updated_user
        $this->updated_user->LinkCustomAttributes = "";
        $this->updated_user->HrefValue = "";
        $this->updated_user->TooltipValue = "";

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

        // grup
        $this->grup->EditAttrs["class"] = "form-control";
        $this->grup->EditCustomAttributes = "";
        if (!$this->grup->Raw) {
            $this->grup->CurrentValue = HtmlDecode($this->grup->CurrentValue);
        }
        $this->grup->EditValue = $this->grup->CurrentValue;
        $this->grup->PlaceHolder = RemoveHtml($this->grup->caption());

        // kategori
        $this->kategori->EditAttrs["class"] = "form-control";
        $this->kategori->EditCustomAttributes = "";
        if (!$this->kategori->Raw) {
            $this->kategori->CurrentValue = HtmlDecode($this->kategori->CurrentValue);
        }
        $this->kategori->EditValue = $this->kategori->CurrentValue;
        $this->kategori->PlaceHolder = RemoveHtml($this->kategori->caption());

        // sediaan
        $this->sediaan->EditAttrs["class"] = "form-control";
        $this->sediaan->EditCustomAttributes = "";
        if (!$this->sediaan->Raw) {
            $this->sediaan->CurrentValue = HtmlDecode($this->sediaan->CurrentValue);
        }
        $this->sediaan->EditValue = $this->sediaan->CurrentValue;
        $this->sediaan->PlaceHolder = RemoveHtml($this->sediaan->caption());

        // bentukan
        $this->bentukan->EditAttrs["class"] = "form-control";
        $this->bentukan->EditCustomAttributes = "";
        if (!$this->bentukan->Raw) {
            $this->bentukan->CurrentValue = HtmlDecode($this->bentukan->CurrentValue);
        }
        $this->bentukan->EditValue = $this->bentukan->CurrentValue;
        $this->bentukan->PlaceHolder = RemoveHtml($this->bentukan->caption());

        // konsep
        $this->konsep->EditAttrs["class"] = "form-control";
        $this->konsep->EditCustomAttributes = "";
        if (!$this->konsep->Raw) {
            $this->konsep->CurrentValue = HtmlDecode($this->konsep->CurrentValue);
        }
        $this->konsep->EditValue = $this->konsep->CurrentValue;
        $this->konsep->PlaceHolder = RemoveHtml($this->konsep->caption());

        // bahanaktif
        $this->bahanaktif->EditAttrs["class"] = "form-control";
        $this->bahanaktif->EditCustomAttributes = "";
        if (!$this->bahanaktif->Raw) {
            $this->bahanaktif->CurrentValue = HtmlDecode($this->bahanaktif->CurrentValue);
        }
        $this->bahanaktif->EditValue = $this->bahanaktif->CurrentValue;
        $this->bahanaktif->PlaceHolder = RemoveHtml($this->bahanaktif->caption());

        // fragrance
        $this->fragrance->EditAttrs["class"] = "form-control";
        $this->fragrance->EditCustomAttributes = "";
        if (!$this->fragrance->Raw) {
            $this->fragrance->CurrentValue = HtmlDecode($this->fragrance->CurrentValue);
        }
        $this->fragrance->EditValue = $this->fragrance->CurrentValue;
        $this->fragrance->PlaceHolder = RemoveHtml($this->fragrance->caption());

        // aroma
        $this->aroma->EditAttrs["class"] = "form-control";
        $this->aroma->EditCustomAttributes = "";
        if (!$this->aroma->Raw) {
            $this->aroma->CurrentValue = HtmlDecode($this->aroma->CurrentValue);
        }
        $this->aroma->EditValue = $this->aroma->CurrentValue;
        $this->aroma->PlaceHolder = RemoveHtml($this->aroma->caption());

        // warna
        $this->warna->EditAttrs["class"] = "form-control";
        $this->warna->EditCustomAttributes = "";
        if (!$this->warna->Raw) {
            $this->warna->CurrentValue = HtmlDecode($this->warna->CurrentValue);
        }
        $this->warna->EditValue = $this->warna->CurrentValue;
        $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

        // aplikasi_sediaan
        $this->aplikasi_sediaan->EditAttrs["class"] = "form-control";
        $this->aplikasi_sediaan->EditCustomAttributes = "";
        if (!$this->aplikasi_sediaan->Raw) {
            $this->aplikasi_sediaan->CurrentValue = HtmlDecode($this->aplikasi_sediaan->CurrentValue);
        }
        $this->aplikasi_sediaan->EditValue = $this->aplikasi_sediaan->CurrentValue;
        $this->aplikasi_sediaan->PlaceHolder = RemoveHtml($this->aplikasi_sediaan->caption());

        // aksesoris
        $this->aksesoris->EditAttrs["class"] = "form-control";
        $this->aksesoris->EditCustomAttributes = "";
        if (!$this->aksesoris->Raw) {
            $this->aksesoris->CurrentValue = HtmlDecode($this->aksesoris->CurrentValue);
        }
        $this->aksesoris->EditValue = $this->aksesoris->CurrentValue;
        $this->aksesoris->PlaceHolder = RemoveHtml($this->aksesoris->caption());

        // nour
        $this->nour->EditAttrs["class"] = "form-control";
        $this->nour->EditCustomAttributes = "";
        $this->nour->EditValue = $this->nour->CurrentValue;
        $this->nour->PlaceHolder = RemoveHtml($this->nour->caption());

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 8);
        $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

        // updated_user
        $this->updated_user->EditAttrs["class"] = "form-control";
        $this->updated_user->EditCustomAttributes = "";
        $this->updated_user->EditValue = $this->updated_user->CurrentValue;
        $this->updated_user->PlaceHolder = RemoveHtml($this->updated_user->caption());

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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->grup);
                    $doc->exportCaption($this->kategori);
                    $doc->exportCaption($this->sediaan);
                    $doc->exportCaption($this->bentukan);
                    $doc->exportCaption($this->konsep);
                    $doc->exportCaption($this->bahanaktif);
                    $doc->exportCaption($this->fragrance);
                    $doc->exportCaption($this->aroma);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->aplikasi_sediaan);
                    $doc->exportCaption($this->aksesoris);
                    $doc->exportCaption($this->nour);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->updated_user);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->grup);
                    $doc->exportCaption($this->kategori);
                    $doc->exportCaption($this->sediaan);
                    $doc->exportCaption($this->bentukan);
                    $doc->exportCaption($this->konsep);
                    $doc->exportCaption($this->bahanaktif);
                    $doc->exportCaption($this->fragrance);
                    $doc->exportCaption($this->aroma);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->aplikasi_sediaan);
                    $doc->exportCaption($this->aksesoris);
                    $doc->exportCaption($this->nour);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->updated_user);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->grup);
                        $doc->exportField($this->kategori);
                        $doc->exportField($this->sediaan);
                        $doc->exportField($this->bentukan);
                        $doc->exportField($this->konsep);
                        $doc->exportField($this->bahanaktif);
                        $doc->exportField($this->fragrance);
                        $doc->exportField($this->aroma);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->aplikasi_sediaan);
                        $doc->exportField($this->aksesoris);
                        $doc->exportField($this->nour);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->updated_user);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->grup);
                        $doc->exportField($this->kategori);
                        $doc->exportField($this->sediaan);
                        $doc->exportField($this->bentukan);
                        $doc->exportField($this->konsep);
                        $doc->exportField($this->bahanaktif);
                        $doc->exportField($this->fragrance);
                        $doc->exportField($this->aroma);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->aplikasi_sediaan);
                        $doc->exportField($this->aksesoris);
                        $doc->exportField($this->nour);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->updated_user);
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
