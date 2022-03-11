<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_confirmprint
 */
class NpdConfirmprint extends DbTable
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
    public $brand;
    public $tglkirim;
    public $tgldisetujui;
    public $desainprimer;
    public $materialprimer;
    public $aplikasiprimer;
    public $jumlahcetakprimer;
    public $desainsekunder;
    public $materialinnerbox;
    public $aplikasiinnerbox;
    public $jumlahcetak;
    public $checked_by;
    public $approved_by;
    public $created_at;
    public $updated_at;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'npd_confirmprint';
        $this->TableName = 'npd_confirmprint';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_confirmprint`";
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
        $this->id = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // brand
        $this->brand = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_brand', 'brand', '`brand`', '`brand`', 200, 255, -1, false, '`brand`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->brand->Nullable = false; // NOT NULL field
        $this->brand->Required = true; // Required field
        $this->brand->Sortable = true; // Allow sort
        $this->brand->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->brand->Param, "CustomMsg");
        $this->Fields['brand'] = &$this->brand;

        // tglkirim
        $this->tglkirim = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_tglkirim', 'tglkirim', '`tglkirim`', CastDateFieldForLike("`tglkirim`", 0, "DB"), 133, 10, 0, false, '`tglkirim`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglkirim->Sortable = true; // Allow sort
        $this->tglkirim->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglkirim->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglkirim->Param, "CustomMsg");
        $this->Fields['tglkirim'] = &$this->tglkirim;

        // tgldisetujui
        $this->tgldisetujui = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_tgldisetujui', 'tgldisetujui', '`tgldisetujui`', CastDateFieldForLike("`tgldisetujui`", 0, "DB"), 133, 10, 0, false, '`tgldisetujui`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tgldisetujui->Sortable = true; // Allow sort
        $this->tgldisetujui->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tgldisetujui->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tgldisetujui->Param, "CustomMsg");
        $this->Fields['tgldisetujui'] = &$this->tgldisetujui;

        // desainprimer
        $this->desainprimer = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_desainprimer', 'desainprimer', '`desainprimer`', '`desainprimer`', 200, 255, -1, false, '`desainprimer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->desainprimer->Sortable = true; // Allow sort
        $this->desainprimer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->desainprimer->Param, "CustomMsg");
        $this->Fields['desainprimer'] = &$this->desainprimer;

        // materialprimer
        $this->materialprimer = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_materialprimer', 'materialprimer', '`materialprimer`', '`materialprimer`', 200, 255, -1, false, '`materialprimer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->materialprimer->Sortable = true; // Allow sort
        $this->materialprimer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->materialprimer->Param, "CustomMsg");
        $this->Fields['materialprimer'] = &$this->materialprimer;

        // aplikasiprimer
        $this->aplikasiprimer = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_aplikasiprimer', 'aplikasiprimer', '`aplikasiprimer`', '`aplikasiprimer`', 200, 255, -1, false, '`aplikasiprimer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasiprimer->Sortable = true; // Allow sort
        $this->aplikasiprimer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasiprimer->Param, "CustomMsg");
        $this->Fields['aplikasiprimer'] = &$this->aplikasiprimer;

        // jumlahcetakprimer
        $this->jumlahcetakprimer = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_jumlahcetakprimer', 'jumlahcetakprimer', '`jumlahcetakprimer`', '`jumlahcetakprimer`', 3, 11, -1, false, '`jumlahcetakprimer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahcetakprimer->Sortable = true; // Allow sort
        $this->jumlahcetakprimer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlahcetakprimer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahcetakprimer->Param, "CustomMsg");
        $this->Fields['jumlahcetakprimer'] = &$this->jumlahcetakprimer;

        // desainsekunder
        $this->desainsekunder = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_desainsekunder', 'desainsekunder', '`desainsekunder`', '`desainsekunder`', 200, 255, -1, false, '`desainsekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->desainsekunder->Sortable = true; // Allow sort
        $this->desainsekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->desainsekunder->Param, "CustomMsg");
        $this->Fields['desainsekunder'] = &$this->desainsekunder;

        // materialinnerbox
        $this->materialinnerbox = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_materialinnerbox', 'materialinnerbox', '`materialinnerbox`', '`materialinnerbox`', 200, 255, -1, false, '`materialinnerbox`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->materialinnerbox->Sortable = true; // Allow sort
        $this->materialinnerbox->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->materialinnerbox->Param, "CustomMsg");
        $this->Fields['materialinnerbox'] = &$this->materialinnerbox;

        // aplikasiinnerbox
        $this->aplikasiinnerbox = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_aplikasiinnerbox', 'aplikasiinnerbox', '`aplikasiinnerbox`', '`aplikasiinnerbox`', 200, 255, -1, false, '`aplikasiinnerbox`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasiinnerbox->Sortable = true; // Allow sort
        $this->aplikasiinnerbox->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasiinnerbox->Param, "CustomMsg");
        $this->Fields['aplikasiinnerbox'] = &$this->aplikasiinnerbox;

        // jumlahcetak
        $this->jumlahcetak = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_jumlahcetak', 'jumlahcetak', '`jumlahcetak`', '`jumlahcetak`', 3, 11, -1, false, '`jumlahcetak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahcetak->Sortable = true; // Allow sort
        $this->jumlahcetak->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlahcetak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahcetak->Param, "CustomMsg");
        $this->Fields['jumlahcetak'] = &$this->jumlahcetak;

        // checked_by
        $this->checked_by = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_checked_by', 'checked_by', '`checked_by`', '`checked_by`', 3, 11, -1, false, '`checked_by`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->checked_by->Sortable = true; // Allow sort
        $this->checked_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->checked_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->checked_by->Lookup = new Lookup('checked_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->checked_by->Lookup = new Lookup('checked_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->checked_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->checked_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->checked_by->Param, "CustomMsg");
        $this->Fields['checked_by'] = &$this->checked_by;

        // approved_by
        $this->approved_by = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_approved_by', 'approved_by', '`approved_by`', '`approved_by`', 3, 11, -1, false, '`approved_by`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->approved_by->Sortable = true; // Allow sort
        $this->approved_by->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->approved_by->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->approved_by->Lookup = new Lookup('approved_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->approved_by->Lookup = new Lookup('approved_by', 'pegawai', false, 'id', ["kode","nama","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->approved_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->approved_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->approved_by->Param, "CustomMsg");
        $this->Fields['approved_by'] = &$this->approved_by;

        // created_at
        $this->created_at = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('npd_confirmprint', 'npd_confirmprint', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_confirmprint`";
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
        $this->brand->DbValue = $row['brand'];
        $this->tglkirim->DbValue = $row['tglkirim'];
        $this->tgldisetujui->DbValue = $row['tgldisetujui'];
        $this->desainprimer->DbValue = $row['desainprimer'];
        $this->materialprimer->DbValue = $row['materialprimer'];
        $this->aplikasiprimer->DbValue = $row['aplikasiprimer'];
        $this->jumlahcetakprimer->DbValue = $row['jumlahcetakprimer'];
        $this->desainsekunder->DbValue = $row['desainsekunder'];
        $this->materialinnerbox->DbValue = $row['materialinnerbox'];
        $this->aplikasiinnerbox->DbValue = $row['aplikasiinnerbox'];
        $this->jumlahcetak->DbValue = $row['jumlahcetak'];
        $this->checked_by->DbValue = $row['checked_by'];
        $this->approved_by->DbValue = $row['approved_by'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
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
        return $_SESSION[$name] ?? GetUrl("NpdConfirmprintList");
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
        if ($pageName == "NpdConfirmprintView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdConfirmprintEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdConfirmprintAdd") {
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
                return "NpdConfirmprintView";
            case Config("API_ADD_ACTION"):
                return "NpdConfirmprintAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdConfirmprintEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdConfirmprintDelete";
            case Config("API_LIST_ACTION"):
                return "NpdConfirmprintList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdConfirmprintList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdConfirmprintView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdConfirmprintView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdConfirmprintAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdConfirmprintAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdConfirmprintEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdConfirmprintAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdConfirmprintDelete", $this->getUrlParm());
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
        $this->brand->setDbValue($row['brand']);
        $this->tglkirim->setDbValue($row['tglkirim']);
        $this->tgldisetujui->setDbValue($row['tgldisetujui']);
        $this->desainprimer->setDbValue($row['desainprimer']);
        $this->materialprimer->setDbValue($row['materialprimer']);
        $this->aplikasiprimer->setDbValue($row['aplikasiprimer']);
        $this->jumlahcetakprimer->setDbValue($row['jumlahcetakprimer']);
        $this->desainsekunder->setDbValue($row['desainsekunder']);
        $this->materialinnerbox->setDbValue($row['materialinnerbox']);
        $this->aplikasiinnerbox->setDbValue($row['aplikasiinnerbox']);
        $this->jumlahcetak->setDbValue($row['jumlahcetak']);
        $this->checked_by->setDbValue($row['checked_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // brand

        // tglkirim

        // tgldisetujui

        // desainprimer

        // materialprimer

        // aplikasiprimer

        // jumlahcetakprimer

        // desainsekunder

        // materialinnerbox

        // aplikasiinnerbox

        // jumlahcetak

        // checked_by

        // approved_by

        // created_at

        // updated_at

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // brand
        $this->brand->ViewValue = $this->brand->CurrentValue;
        $this->brand->ViewCustomAttributes = "";

        // tglkirim
        $this->tglkirim->ViewValue = $this->tglkirim->CurrentValue;
        $this->tglkirim->ViewValue = FormatDateTime($this->tglkirim->ViewValue, 0);
        $this->tglkirim->ViewCustomAttributes = "";

        // tgldisetujui
        $this->tgldisetujui->ViewValue = $this->tgldisetujui->CurrentValue;
        $this->tgldisetujui->ViewValue = FormatDateTime($this->tgldisetujui->ViewValue, 0);
        $this->tgldisetujui->ViewCustomAttributes = "";

        // desainprimer
        $this->desainprimer->ViewValue = $this->desainprimer->CurrentValue;
        $this->desainprimer->ViewCustomAttributes = "";

        // materialprimer
        $this->materialprimer->ViewValue = $this->materialprimer->CurrentValue;
        $this->materialprimer->ViewCustomAttributes = "";

        // aplikasiprimer
        $this->aplikasiprimer->ViewValue = $this->aplikasiprimer->CurrentValue;
        $this->aplikasiprimer->ViewCustomAttributes = "";

        // jumlahcetakprimer
        $this->jumlahcetakprimer->ViewValue = $this->jumlahcetakprimer->CurrentValue;
        $this->jumlahcetakprimer->ViewValue = FormatNumber($this->jumlahcetakprimer->ViewValue, 0, -2, -2, -2);
        $this->jumlahcetakprimer->ViewCustomAttributes = "";

        // desainsekunder
        $this->desainsekunder->ViewValue = $this->desainsekunder->CurrentValue;
        $this->desainsekunder->ViewCustomAttributes = "";

        // materialinnerbox
        $this->materialinnerbox->ViewValue = $this->materialinnerbox->CurrentValue;
        $this->materialinnerbox->ViewCustomAttributes = "";

        // aplikasiinnerbox
        $this->aplikasiinnerbox->ViewValue = $this->aplikasiinnerbox->CurrentValue;
        $this->aplikasiinnerbox->ViewCustomAttributes = "";

        // jumlahcetak
        $this->jumlahcetak->ViewValue = $this->jumlahcetak->CurrentValue;
        $this->jumlahcetak->ViewValue = FormatNumber($this->jumlahcetak->ViewValue, 0, -2, -2, -2);
        $this->jumlahcetak->ViewCustomAttributes = "";

        // checked_by
        $curVal = trim(strval($this->checked_by->CurrentValue));
        if ($curVal != "") {
            $this->checked_by->ViewValue = $this->checked_by->lookupCacheOption($curVal);
            if ($this->checked_by->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->checked_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->checked_by->Lookup->renderViewRow($rswrk[0]);
                    $this->checked_by->ViewValue = $this->checked_by->displayValue($arwrk);
                } else {
                    $this->checked_by->ViewValue = $this->checked_by->CurrentValue;
                }
            }
        } else {
            $this->checked_by->ViewValue = null;
        }
        $this->checked_by->ViewCustomAttributes = "";

        // approved_by
        $curVal = trim(strval($this->approved_by->CurrentValue));
        if ($curVal != "") {
            $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
            if ($this->approved_by->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->approved_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->approved_by->Lookup->renderViewRow($rswrk[0]);
                    $this->approved_by->ViewValue = $this->approved_by->displayValue($arwrk);
                } else {
                    $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
                }
            }
        } else {
            $this->approved_by->ViewValue = null;
        }
        $this->approved_by->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
        $this->updated_at->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // brand
        $this->brand->LinkCustomAttributes = "";
        $this->brand->HrefValue = "";
        $this->brand->TooltipValue = "";

        // tglkirim
        $this->tglkirim->LinkCustomAttributes = "";
        $this->tglkirim->HrefValue = "";
        $this->tglkirim->TooltipValue = "";

        // tgldisetujui
        $this->tgldisetujui->LinkCustomAttributes = "";
        $this->tgldisetujui->HrefValue = "";
        $this->tgldisetujui->TooltipValue = "";

        // desainprimer
        $this->desainprimer->LinkCustomAttributes = "";
        $this->desainprimer->HrefValue = "";
        $this->desainprimer->TooltipValue = "";

        // materialprimer
        $this->materialprimer->LinkCustomAttributes = "";
        $this->materialprimer->HrefValue = "";
        $this->materialprimer->TooltipValue = "";

        // aplikasiprimer
        $this->aplikasiprimer->LinkCustomAttributes = "";
        $this->aplikasiprimer->HrefValue = "";
        $this->aplikasiprimer->TooltipValue = "";

        // jumlahcetakprimer
        $this->jumlahcetakprimer->LinkCustomAttributes = "";
        $this->jumlahcetakprimer->HrefValue = "";
        $this->jumlahcetakprimer->TooltipValue = "";

        // desainsekunder
        $this->desainsekunder->LinkCustomAttributes = "";
        $this->desainsekunder->HrefValue = "";
        $this->desainsekunder->TooltipValue = "";

        // materialinnerbox
        $this->materialinnerbox->LinkCustomAttributes = "";
        $this->materialinnerbox->HrefValue = "";
        $this->materialinnerbox->TooltipValue = "";

        // aplikasiinnerbox
        $this->aplikasiinnerbox->LinkCustomAttributes = "";
        $this->aplikasiinnerbox->HrefValue = "";
        $this->aplikasiinnerbox->TooltipValue = "";

        // jumlahcetak
        $this->jumlahcetak->LinkCustomAttributes = "";
        $this->jumlahcetak->HrefValue = "";
        $this->jumlahcetak->TooltipValue = "";

        // checked_by
        $this->checked_by->LinkCustomAttributes = "";
        $this->checked_by->HrefValue = "";
        $this->checked_by->TooltipValue = "";

        // approved_by
        $this->approved_by->LinkCustomAttributes = "";
        $this->approved_by->HrefValue = "";
        $this->approved_by->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

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

        // brand
        $this->brand->EditAttrs["class"] = "form-control";
        $this->brand->EditCustomAttributes = "";
        if (!$this->brand->Raw) {
            $this->brand->CurrentValue = HtmlDecode($this->brand->CurrentValue);
        }
        $this->brand->EditValue = $this->brand->CurrentValue;
        $this->brand->PlaceHolder = RemoveHtml($this->brand->caption());

        // tglkirim
        $this->tglkirim->EditAttrs["class"] = "form-control";
        $this->tglkirim->EditCustomAttributes = "";
        $this->tglkirim->EditValue = FormatDateTime($this->tglkirim->CurrentValue, 8);
        $this->tglkirim->PlaceHolder = RemoveHtml($this->tglkirim->caption());

        // tgldisetujui
        $this->tgldisetujui->EditAttrs["class"] = "form-control";
        $this->tgldisetujui->EditCustomAttributes = "";
        $this->tgldisetujui->EditValue = FormatDateTime($this->tgldisetujui->CurrentValue, 8);
        $this->tgldisetujui->PlaceHolder = RemoveHtml($this->tgldisetujui->caption());

        // desainprimer
        $this->desainprimer->EditAttrs["class"] = "form-control";
        $this->desainprimer->EditCustomAttributes = "";
        if (!$this->desainprimer->Raw) {
            $this->desainprimer->CurrentValue = HtmlDecode($this->desainprimer->CurrentValue);
        }
        $this->desainprimer->EditValue = $this->desainprimer->CurrentValue;
        $this->desainprimer->PlaceHolder = RemoveHtml($this->desainprimer->caption());

        // materialprimer
        $this->materialprimer->EditAttrs["class"] = "form-control";
        $this->materialprimer->EditCustomAttributes = "";
        if (!$this->materialprimer->Raw) {
            $this->materialprimer->CurrentValue = HtmlDecode($this->materialprimer->CurrentValue);
        }
        $this->materialprimer->EditValue = $this->materialprimer->CurrentValue;
        $this->materialprimer->PlaceHolder = RemoveHtml($this->materialprimer->caption());

        // aplikasiprimer
        $this->aplikasiprimer->EditAttrs["class"] = "form-control";
        $this->aplikasiprimer->EditCustomAttributes = "";
        if (!$this->aplikasiprimer->Raw) {
            $this->aplikasiprimer->CurrentValue = HtmlDecode($this->aplikasiprimer->CurrentValue);
        }
        $this->aplikasiprimer->EditValue = $this->aplikasiprimer->CurrentValue;
        $this->aplikasiprimer->PlaceHolder = RemoveHtml($this->aplikasiprimer->caption());

        // jumlahcetakprimer
        $this->jumlahcetakprimer->EditAttrs["class"] = "form-control";
        $this->jumlahcetakprimer->EditCustomAttributes = "";
        $this->jumlahcetakprimer->EditValue = $this->jumlahcetakprimer->CurrentValue;
        $this->jumlahcetakprimer->PlaceHolder = RemoveHtml($this->jumlahcetakprimer->caption());

        // desainsekunder
        $this->desainsekunder->EditAttrs["class"] = "form-control";
        $this->desainsekunder->EditCustomAttributes = "";
        if (!$this->desainsekunder->Raw) {
            $this->desainsekunder->CurrentValue = HtmlDecode($this->desainsekunder->CurrentValue);
        }
        $this->desainsekunder->EditValue = $this->desainsekunder->CurrentValue;
        $this->desainsekunder->PlaceHolder = RemoveHtml($this->desainsekunder->caption());

        // materialinnerbox
        $this->materialinnerbox->EditAttrs["class"] = "form-control";
        $this->materialinnerbox->EditCustomAttributes = "";
        if (!$this->materialinnerbox->Raw) {
            $this->materialinnerbox->CurrentValue = HtmlDecode($this->materialinnerbox->CurrentValue);
        }
        $this->materialinnerbox->EditValue = $this->materialinnerbox->CurrentValue;
        $this->materialinnerbox->PlaceHolder = RemoveHtml($this->materialinnerbox->caption());

        // aplikasiinnerbox
        $this->aplikasiinnerbox->EditAttrs["class"] = "form-control";
        $this->aplikasiinnerbox->EditCustomAttributes = "";
        if (!$this->aplikasiinnerbox->Raw) {
            $this->aplikasiinnerbox->CurrentValue = HtmlDecode($this->aplikasiinnerbox->CurrentValue);
        }
        $this->aplikasiinnerbox->EditValue = $this->aplikasiinnerbox->CurrentValue;
        $this->aplikasiinnerbox->PlaceHolder = RemoveHtml($this->aplikasiinnerbox->caption());

        // jumlahcetak
        $this->jumlahcetak->EditAttrs["class"] = "form-control";
        $this->jumlahcetak->EditCustomAttributes = "";
        $this->jumlahcetak->EditValue = $this->jumlahcetak->CurrentValue;
        $this->jumlahcetak->PlaceHolder = RemoveHtml($this->jumlahcetak->caption());

        // checked_by
        $this->checked_by->EditAttrs["class"] = "form-control";
        $this->checked_by->EditCustomAttributes = "";
        $this->checked_by->PlaceHolder = RemoveHtml($this->checked_by->caption());

        // approved_by
        $this->approved_by->EditAttrs["class"] = "form-control";
        $this->approved_by->EditCustomAttributes = "";
        $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 8);
        $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

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
                    $doc->exportCaption($this->brand);
                    $doc->exportCaption($this->tglkirim);
                    $doc->exportCaption($this->tgldisetujui);
                    $doc->exportCaption($this->desainprimer);
                    $doc->exportCaption($this->materialprimer);
                    $doc->exportCaption($this->aplikasiprimer);
                    $doc->exportCaption($this->jumlahcetakprimer);
                    $doc->exportCaption($this->desainsekunder);
                    $doc->exportCaption($this->materialinnerbox);
                    $doc->exportCaption($this->aplikasiinnerbox);
                    $doc->exportCaption($this->jumlahcetak);
                    $doc->exportCaption($this->checked_by);
                    $doc->exportCaption($this->approved_by);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->brand);
                    $doc->exportCaption($this->tglkirim);
                    $doc->exportCaption($this->tgldisetujui);
                    $doc->exportCaption($this->desainprimer);
                    $doc->exportCaption($this->materialprimer);
                    $doc->exportCaption($this->aplikasiprimer);
                    $doc->exportCaption($this->jumlahcetakprimer);
                    $doc->exportCaption($this->desainsekunder);
                    $doc->exportCaption($this->materialinnerbox);
                    $doc->exportCaption($this->aplikasiinnerbox);
                    $doc->exportCaption($this->jumlahcetak);
                    $doc->exportCaption($this->checked_by);
                    $doc->exportCaption($this->approved_by);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
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
                        $doc->exportField($this->brand);
                        $doc->exportField($this->tglkirim);
                        $doc->exportField($this->tgldisetujui);
                        $doc->exportField($this->desainprimer);
                        $doc->exportField($this->materialprimer);
                        $doc->exportField($this->aplikasiprimer);
                        $doc->exportField($this->jumlahcetakprimer);
                        $doc->exportField($this->desainsekunder);
                        $doc->exportField($this->materialinnerbox);
                        $doc->exportField($this->aplikasiinnerbox);
                        $doc->exportField($this->jumlahcetak);
                        $doc->exportField($this->checked_by);
                        $doc->exportField($this->approved_by);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->brand);
                        $doc->exportField($this->tglkirim);
                        $doc->exportField($this->tgldisetujui);
                        $doc->exportField($this->desainprimer);
                        $doc->exportField($this->materialprimer);
                        $doc->exportField($this->aplikasiprimer);
                        $doc->exportField($this->jumlahcetakprimer);
                        $doc->exportField($this->desainsekunder);
                        $doc->exportField($this->materialinnerbox);
                        $doc->exportField($this->aplikasiinnerbox);
                        $doc->exportField($this->jumlahcetak);
                        $doc->exportField($this->checked_by);
                        $doc->exportField($this->approved_by);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
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
