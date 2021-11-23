<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for Jatuh Tempo
 */
class JatuhTempo extends ReportTable
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
    public $ShowGroupHeaderAsRow = false;
    public $ShowCompactSummaryFooter = false;

    // Export
    public $ExportDoc;

    // Fields
    public $idpegawai;
    public $namapegawai;
    public $idcustomer;
    public $namacustomer;
    public $idinvoice;
    public $sisabayar;
    public $jatuhtempo;
    public $sisahari;
    public $kodeinvoice;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'Jatuh_Tempo';
        $this->TableName = 'Jatuh Tempo';
        $this->TableType = 'REPORT';

        // Update Table
        $this->UpdateTable = "`d_jatuhtempo`";
        $this->ReportSourceTable = 'd_jatuhtempo'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)

        // idpegawai
        $this->idpegawai = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idpegawai->GroupingFieldId = 1;
        $this->idpegawai->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->idpegawai->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->idpegawai->GroupByType = "";
        $this->idpegawai->GroupInterval = "0";
        $this->idpegawai->GroupSql = "";
        $this->idpegawai->IsAutoIncrement = true; // Autoincrement field
        $this->idpegawai->IsPrimaryKey = true; // Primary key field
        $this->idpegawai->Sortable = true; // Allow sort
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
        $this->idpegawai->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['idpegawai'] = &$this->idpegawai;

        // namapegawai
        $this->namapegawai = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_namapegawai', 'namapegawai', '`namapegawai`', '`namapegawai`', 200, 123, -1, false, '`namapegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namapegawai->Sortable = true; // Allow sort
        $this->namapegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namapegawai->Param, "CustomMsg");
        $this->namapegawai->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['namapegawai'] = &$this->namapegawai;

        // idcustomer
        $this->idcustomer = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idcustomer->GroupingFieldId = 2;
        $this->idcustomer->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->idcustomer->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->idcustomer->GroupByType = "";
        $this->idcustomer->GroupInterval = "0";
        $this->idcustomer->GroupSql = "";
        $this->idcustomer->IsAutoIncrement = true; // Autoincrement field
        $this->idcustomer->IsPrimaryKey = true; // Primary key field
        $this->idcustomer->Sortable = true; // Allow sort
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
        $this->idcustomer->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // namacustomer
        $this->namacustomer = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_namacustomer', 'namacustomer', '`namacustomer`', '`namacustomer`', 201, 308, -1, false, '`namacustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namacustomer->Sortable = true; // Allow sort
        $this->namacustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namacustomer->Param, "CustomMsg");
        $this->namacustomer->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['namacustomer'] = &$this->namacustomer;

        // idinvoice
        $this->idinvoice = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_idinvoice', 'idinvoice', '`idinvoice`', '`idinvoice`', 3, 11, -1, false, '`idinvoice`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idinvoice->IsAutoIncrement = true; // Autoincrement field
        $this->idinvoice->IsPrimaryKey = true; // Primary key field
        $this->idinvoice->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->idinvoice->Lookup = new Lookup('idinvoice', 'invoice', false, 'id', ["kode","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idinvoice->Lookup = new Lookup('idinvoice', 'invoice', false, 'id', ["kode","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idinvoice->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idinvoice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idinvoice->Param, "CustomMsg");
        $this->idinvoice->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['idinvoice'] = &$this->idinvoice;

        // sisabayar
        $this->sisabayar = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_sisabayar', 'sisabayar', '`sisabayar`', '`sisabayar`', 20, 20, -1, false, '`sisabayar`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisabayar->Nullable = false; // NOT NULL field
        $this->sisabayar->Sortable = true; // Allow sort
        $this->sisabayar->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisabayar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisabayar->Param, "CustomMsg");
        $this->sisabayar->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['sisabayar'] = &$this->sisabayar;

        // jatuhtempo
        $this->jatuhtempo = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_jatuhtempo', 'jatuhtempo', '`jatuhtempo`', CastDateFieldForLike("`jatuhtempo`", 0, "DB"), 135, 19, 0, false, '`jatuhtempo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jatuhtempo->Sortable = true; // Allow sort
        $this->jatuhtempo->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->jatuhtempo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jatuhtempo->Param, "CustomMsg");
        $this->jatuhtempo->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['jatuhtempo'] = &$this->jatuhtempo;

        // sisahari
        $this->sisahari = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_sisahari', 'sisahari', '`sisahari`', '`sisahari`', 20, 7, -1, false, '`sisahari`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisahari->Sortable = true; // Allow sort
        $this->sisahari->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisahari->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisahari->Param, "CustomMsg");
        $this->sisahari->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['sisahari'] = &$this->sisahari;

        // kodeinvoice
        $this->kodeinvoice = new ReportField('Jatuh_Tempo', 'Jatuh Tempo', 'x_kodeinvoice', 'kodeinvoice', '`kodeinvoice`', '`kodeinvoice`', 200, 50, -1, false, '`kodeinvoice`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeinvoice->Nullable = false; // NOT NULL field
        $this->kodeinvoice->Required = true; // Required field
        $this->kodeinvoice->Sortable = true; // Allow sort
        $this->kodeinvoice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeinvoice->Param, "CustomMsg");
        $this->kodeinvoice->SourceTableVar = 'd_jatuhtempo';
        $this->Fields['kodeinvoice'] = &$this->kodeinvoice;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Single column sort
    protected function updateSort(&$fld)
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
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                $this->setDetailOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if ($fld->GroupingFieldId == 0) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $argrps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = "";
        foreach ($argrps as $grp) {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $grp;
        }
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Table Level Group SQL
    private $sqlFirstGroupField = "";
    private $sqlSelectGroup = null;
    private $sqlOrderByGroup = "";

    // First Group Field
    public function getSqlFirstGroupField($alias = false)
    {
        if ($this->sqlFirstGroupField != "") {
            return $this->sqlFirstGroupField;
        }
        $firstGroupField = &$this->idpegawai;
        $expr = $firstGroupField->Expression;
        if ($firstGroupField->GroupSql != "") {
            $expr = str_replace("%s", $firstGroupField->Expression, $firstGroupField->GroupSql);
            if ($alias) {
                $expr .= " AS " . QuotedName($firstGroupField->getGroupName(), $this->Dbid);
            }
        }
        return $expr;
    }

    public function setSqlFirstGroupField($v)
    {
        $this->sqlFirstGroupField = $v;
    }

    // Select Group
    public function getSqlSelectGroup()
    {
        return $this->sqlSelectGroup ?? $this->getQueryBuilder()->select($this->getSqlFirstGroupField(true))->distinct();
    }

    public function setSqlSelectGroup($v)
    {
        $this->sqlSelectGroup = $v;
    }

    // Order By Group
    public function getSqlOrderByGroup()
    {
        if ($this->sqlOrderByGroup != "") {
            return $this->sqlOrderByGroup;
        }
        return $this->getSqlFirstGroupField() . " ASC";
    }

    public function setSqlOrderByGroup($v)
    {
        $this->sqlOrderByGroup = $v;
    }

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("SUM(`sisabayar`) AS `sum_sisabayar`");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Aggregate Prefix
    public function getSqlAggregatePrefix()
    {
        return ($this->sqlAggregatePrefix != "") ? $this->sqlAggregatePrefix : "";
    }

    public function setSqlAggregatePrefix($v)
    {
        $this->sqlAggregatePrefix = $v;
    }

    // Aggregate Suffix
    public function getSqlAggregateSuffix()
    {
        return ($this->sqlAggregateSuffix != "") ? $this->sqlAggregateSuffix : "";
    }

    public function setSqlAggregateSuffix($v)
    {
        $this->sqlAggregateSuffix = $v;
    }

    // Select Count
    public function getSqlSelectCount()
    {
        return $this->sqlSelectCount ?? $this->getQueryBuilder()->select("COUNT(*)");
    }

    public function setSqlSelectCount($v)
    {
        $this->sqlSelectCount = $v;
    }

    // Render for lookup
    public function renderLookup()
    {
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`d_jatuhtempo`";
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
        if ($this->SqlSelect) {
            return $this->SqlSelect;
        }
        $select = $this->getQueryBuilder()->select("*");
        $groupField = &$this->idpegawai;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        $groupField = &$this->idcustomer;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        return $select;
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

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idpegawai` = @idpegawai@ AND `idcustomer` = @idcustomer@ AND `idinvoice` = @idinvoice@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->idpegawai->CurrentValue : $this->idpegawai->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->idcustomer->CurrentValue : $this->idcustomer->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->idinvoice->CurrentValue : $this->idinvoice->OldValue;
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
        if (count($keys) == 3) {
            if ($current) {
                $this->idpegawai->CurrentValue = $keys[0];
            } else {
                $this->idpegawai->OldValue = $keys[0];
            }
            if ($current) {
                $this->idcustomer->CurrentValue = $keys[1];
            } else {
                $this->idcustomer->OldValue = $keys[1];
            }
            if ($current) {
                $this->idinvoice->CurrentValue = $keys[2];
            } else {
                $this->idinvoice->OldValue = $keys[2];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idpegawai', $row) ? $row['idpegawai'] : null;
        } else {
            $val = $this->idpegawai->OldValue !== null ? $this->idpegawai->OldValue : $this->idpegawai->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idpegawai@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('idcustomer', $row) ? $row['idcustomer'] : null;
        } else {
            $val = $this->idcustomer->OldValue !== null ? $this->idcustomer->OldValue : $this->idcustomer->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idcustomer@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('idinvoice', $row) ? $row['idinvoice'] : null;
        } else {
            $val = $this->idinvoice->OldValue !== null ? $this->idinvoice->OldValue : $this->idinvoice->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idinvoice@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("");
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
        if ($pageName == "") {
            return $Language->phrase("View");
        } elseif ($pageName == "") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "") {
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
                return "";
            case Config("API_ADD_ACTION"):
                return "";
            case Config("API_EDIT_ACTION"):
                return "";
            case Config("API_DELETE_ACTION"):
                return "";
            case Config("API_LIST_ACTION"):
                return "";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $this->getUrlParm($parm);
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("", $this->getUrlParm($parm));
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
        return $this->keyUrl("", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "idpegawai:" . JsonEncode($this->idpegawai->CurrentValue, "number");
        $json .= ",idcustomer:" . JsonEncode($this->idcustomer->CurrentValue, "number");
        $json .= ",idinvoice:" . JsonEncode($this->idinvoice->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idpegawai->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idpegawai->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->idcustomer->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idcustomer->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->idinvoice->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idinvoice->CurrentValue);
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
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            $this->DrillDown || $DashboardReport ||
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
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            if (($keyValue = Param("idpegawai") ?? Route("idpegawai")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("idcustomer") ?? Route("idcustomer")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(1) ?? Route(3)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("idinvoice") ?? Route("idinvoice")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(2) ?? Route(4)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (is_array($arKeys)) {
                $arKeys[] = $arKey;
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 3) {
                    continue; // Just skip so other keys will still work
                }
                if (!is_numeric($key[0])) { // idpegawai
                    continue;
                }
                if (!is_numeric($key[1])) { // idcustomer
                    continue;
                }
                if (!is_numeric($key[2])) { // idinvoice
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
                $this->idpegawai->CurrentValue = $key[0];
            } else {
                $this->idpegawai->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->idcustomer->CurrentValue = $key[1];
            } else {
                $this->idcustomer->OldValue = $key[1];
            }
            if ($setCurrent) {
                $this->idinvoice->CurrentValue = $key[2];
            } else {
                $this->idinvoice->OldValue = $key[2];
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `d_jatuhtempo`";
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
