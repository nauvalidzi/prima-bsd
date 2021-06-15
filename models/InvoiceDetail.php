<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for invoice_detail
 */
class InvoiceDetail extends DbTable
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
    public $idinvoice;
    public $idorder_detail;
    public $jumlahorder;
    public $bonus;
    public $stockdo;
    public $jumlahkirim;
    public $jumlahbonus;
    public $harga;
    public $totalnondiskon;
    public $diskonpayment;
    public $bbpersen;
    public $totaltagihan;
    public $blackbonus;
    public $created_at;
    public $created_by;
    public $readonly;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'invoice_detail';
        $this->TableName = 'invoice_detail';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`invoice_detail`";
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
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('invoice_detail', 'invoice_detail', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idinvoice
        $this->idinvoice = new DbField('invoice_detail', 'invoice_detail', 'x_idinvoice', 'idinvoice', '`idinvoice`', '`idinvoice`', 3, 11, -1, false, '`idinvoice`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idinvoice->IsForeignKey = true; // Foreign key field
        $this->idinvoice->Nullable = false; // NOT NULL field
        $this->idinvoice->Required = true; // Required field
        $this->idinvoice->Sortable = true; // Allow sort
        $this->idinvoice->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idinvoice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idinvoice->Param, "CustomMsg");
        $this->Fields['idinvoice'] = &$this->idinvoice;

        // idorder_detail
        $this->idorder_detail = new DbField('invoice_detail', 'invoice_detail', 'x_idorder_detail', 'idorder_detail', '`idorder_detail`', '`idorder_detail`', 3, 11, -1, false, '`idorder_detail`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idorder_detail->Nullable = false; // NOT NULL field
        $this->idorder_detail->Required = true; // Required field
        $this->idorder_detail->Sortable = true; // Allow sort
        $this->idorder_detail->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idorder_detail->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idorder_detail->Lookup = new Lookup('idorder_detail', 'v_stock', false, 'idorder_detail', ["nama","","",""], ["invoice x_idorder"], [], ["idorder"], ["x_idorder"], ["jumlahorder","bonus","jumlah","jumlah","harga"], ["x_jumlahorder","x_bonus","x_stockdo","x_jumlahkirim","x_harga"], '', '');
                break;
            default:
                $this->idorder_detail->Lookup = new Lookup('idorder_detail', 'v_stock', false, 'idorder_detail', ["nama","","",""], ["invoice x_idorder"], [], ["idorder"], ["x_idorder"], ["jumlahorder","bonus","jumlah","jumlah","harga"], ["x_jumlahorder","x_bonus","x_stockdo","x_jumlahkirim","x_harga"], '', '');
                break;
        }
        $this->idorder_detail->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idorder_detail->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idorder_detail->Param, "CustomMsg");
        $this->Fields['idorder_detail'] = &$this->idorder_detail;

        // jumlahorder
        $this->jumlahorder = new DbField('invoice_detail', 'invoice_detail', 'x_jumlahorder', 'jumlahorder', '`jumlahorder`', '`jumlahorder`', 3, 11, -1, false, '`jumlahorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahorder->Nullable = false; // NOT NULL field
        $this->jumlahorder->Required = true; // Required field
        $this->jumlahorder->Sortable = true; // Allow sort
        $this->jumlahorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlahorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahorder->Param, "CustomMsg");
        $this->Fields['jumlahorder'] = &$this->jumlahorder;

        // bonus
        $this->bonus = new DbField('invoice_detail', 'invoice_detail', 'x_bonus', 'bonus', '`bonus`', '`bonus`', 3, 11, -1, false, '`bonus`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bonus->Nullable = false; // NOT NULL field
        $this->bonus->Sortable = true; // Allow sort
        $this->bonus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->bonus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bonus->Param, "CustomMsg");
        $this->Fields['bonus'] = &$this->bonus;

        // stockdo
        $this->stockdo = new DbField('invoice_detail', 'invoice_detail', 'x_stockdo', 'stockdo', '`stockdo`', '`stockdo`', 3, 11, -1, false, '`stockdo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->stockdo->Nullable = false; // NOT NULL field
        $this->stockdo->Sortable = true; // Allow sort
        $this->stockdo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->stockdo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->stockdo->Param, "CustomMsg");
        $this->Fields['stockdo'] = &$this->stockdo;

        // jumlahkirim
        $this->jumlahkirim = new DbField('invoice_detail', 'invoice_detail', 'x_jumlahkirim', 'jumlahkirim', '`jumlahkirim`', '`jumlahkirim`', 3, 11, -1, false, '`jumlahkirim`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahkirim->Nullable = false; // NOT NULL field
        $this->jumlahkirim->Required = true; // Required field
        $this->jumlahkirim->Sortable = true; // Allow sort
        $this->jumlahkirim->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlahkirim->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahkirim->Param, "CustomMsg");
        $this->Fields['jumlahkirim'] = &$this->jumlahkirim;

        // jumlahbonus
        $this->jumlahbonus = new DbField('invoice_detail', 'invoice_detail', 'x_jumlahbonus', 'jumlahbonus', '`jumlahbonus`', '`jumlahbonus`', 3, 11, -1, false, '`jumlahbonus`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahbonus->Nullable = false; // NOT NULL field
        $this->jumlahbonus->Sortable = true; // Allow sort
        $this->jumlahbonus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jumlahbonus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahbonus->Param, "CustomMsg");
        $this->Fields['jumlahbonus'] = &$this->jumlahbonus;

        // harga
        $this->harga = new DbField('invoice_detail', 'invoice_detail', 'x_harga', 'harga', '`harga`', '`harga`', 20, 20, -1, false, '`harga`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->harga->Nullable = false; // NOT NULL field
        $this->harga->Required = true; // Required field
        $this->harga->Sortable = true; // Allow sort
        $this->harga->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->harga->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->harga->Param, "CustomMsg");
        $this->Fields['harga'] = &$this->harga;

        // totalnondiskon
        $this->totalnondiskon = new DbField('invoice_detail', 'invoice_detail', 'x_totalnondiskon', 'totalnondiskon', '`totalnondiskon`', '`totalnondiskon`', 20, 20, -1, false, '`totalnondiskon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totalnondiskon->Nullable = false; // NOT NULL field
        $this->totalnondiskon->Sortable = true; // Allow sort
        $this->totalnondiskon->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->totalnondiskon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totalnondiskon->Param, "CustomMsg");
        $this->Fields['totalnondiskon'] = &$this->totalnondiskon;

        // diskonpayment
        $this->diskonpayment = new DbField('invoice_detail', 'invoice_detail', 'x_diskonpayment', 'diskonpayment', '`diskonpayment`', '`diskonpayment`', 5, 22, -1, false, '`diskonpayment`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->diskonpayment->Nullable = false; // NOT NULL field
        $this->diskonpayment->Sortable = true; // Allow sort
        $this->diskonpayment->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->diskonpayment->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->diskonpayment->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->diskonpayment->Param, "CustomMsg");
        $this->Fields['diskonpayment'] = &$this->diskonpayment;

        // bbpersen
        $this->bbpersen = new DbField('invoice_detail', 'invoice_detail', 'x_bbpersen', 'bbpersen', '`bbpersen`', '`bbpersen`', 5, 22, -1, false, '`bbpersen`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bbpersen->Nullable = false; // NOT NULL field
        $this->bbpersen->Sortable = true; // Allow sort
        $this->bbpersen->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->bbpersen->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->bbpersen->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bbpersen->Param, "CustomMsg");
        $this->Fields['bbpersen'] = &$this->bbpersen;

        // totaltagihan
        $this->totaltagihan = new DbField('invoice_detail', 'invoice_detail', 'x_totaltagihan', 'totaltagihan', '`totaltagihan`', '`totaltagihan`', 20, 20, -1, false, '`totaltagihan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totaltagihan->Nullable = false; // NOT NULL field
        $this->totaltagihan->Sortable = true; // Allow sort
        $this->totaltagihan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->totaltagihan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totaltagihan->Param, "CustomMsg");
        $this->Fields['totaltagihan'] = &$this->totaltagihan;

        // blackbonus
        $this->blackbonus = new DbField('invoice_detail', 'invoice_detail', 'x_blackbonus', 'blackbonus', '`blackbonus`', '`blackbonus`', 20, 20, -1, false, '`blackbonus`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->blackbonus->Nullable = false; // NOT NULL field
        $this->blackbonus->Sortable = true; // Allow sort
        $this->blackbonus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->blackbonus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->blackbonus->Param, "CustomMsg");
        $this->Fields['blackbonus'] = &$this->blackbonus;

        // created_at
        $this->created_at = new DbField('invoice_detail', 'invoice_detail', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // created_by
        $this->created_by = new DbField('invoice_detail', 'invoice_detail', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_by->Param, "CustomMsg");
        $this->Fields['created_by'] = &$this->created_by;

        // readonly
        $this->readonly = new DbField('invoice_detail', 'invoice_detail', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = false; // Allow sort
        $this->readonly->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->readonly->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->readonly->Param, "CustomMsg");
        $this->Fields['readonly'] = &$this->readonly;
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
        if ($this->getCurrentMasterTable() == "invoice") {
            if ($this->idinvoice->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->idinvoice->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "invoice") {
            if ($this->idinvoice->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`idinvoice`", $this->idinvoice->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_invoice()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_invoice()
    {
        return "`idinvoice`=@idinvoice@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`invoice_detail`";
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
        $this->idinvoice->DbValue = $row['idinvoice'];
        $this->idorder_detail->DbValue = $row['idorder_detail'];
        $this->jumlahorder->DbValue = $row['jumlahorder'];
        $this->bonus->DbValue = $row['bonus'];
        $this->stockdo->DbValue = $row['stockdo'];
        $this->jumlahkirim->DbValue = $row['jumlahkirim'];
        $this->jumlahbonus->DbValue = $row['jumlahbonus'];
        $this->harga->DbValue = $row['harga'];
        $this->totalnondiskon->DbValue = $row['totalnondiskon'];
        $this->diskonpayment->DbValue = $row['diskonpayment'];
        $this->bbpersen->DbValue = $row['bbpersen'];
        $this->totaltagihan->DbValue = $row['totaltagihan'];
        $this->blackbonus->DbValue = $row['blackbonus'];
        $this->created_at->DbValue = $row['created_at'];
        $this->created_by->DbValue = $row['created_by'];
        $this->readonly->DbValue = $row['readonly'];
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
        return $_SESSION[$name] ?? GetUrl("InvoiceDetailList");
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
        if ($pageName == "InvoiceDetailView") {
            return $Language->phrase("View");
        } elseif ($pageName == "InvoiceDetailEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "InvoiceDetailAdd") {
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
                return "InvoiceDetailView";
            case Config("API_ADD_ACTION"):
                return "InvoiceDetailAdd";
            case Config("API_EDIT_ACTION"):
                return "InvoiceDetailEdit";
            case Config("API_DELETE_ACTION"):
                return "InvoiceDetailDelete";
            case Config("API_LIST_ACTION"):
                return "InvoiceDetailList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "InvoiceDetailList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("InvoiceDetailView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("InvoiceDetailView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "InvoiceDetailAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "InvoiceDetailAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("InvoiceDetailEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("InvoiceDetailAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("InvoiceDetailDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "invoice" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->idinvoice->CurrentValue ?? $this->idinvoice->getSessionValue());
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
        $this->idinvoice->setDbValue($row['idinvoice']);
        $this->idorder_detail->setDbValue($row['idorder_detail']);
        $this->jumlahorder->setDbValue($row['jumlahorder']);
        $this->bonus->setDbValue($row['bonus']);
        $this->stockdo->setDbValue($row['stockdo']);
        $this->jumlahkirim->setDbValue($row['jumlahkirim']);
        $this->jumlahbonus->setDbValue($row['jumlahbonus']);
        $this->harga->setDbValue($row['harga']);
        $this->totalnondiskon->setDbValue($row['totalnondiskon']);
        $this->diskonpayment->setDbValue($row['diskonpayment']);
        $this->bbpersen->setDbValue($row['bbpersen']);
        $this->totaltagihan->setDbValue($row['totaltagihan']);
        $this->blackbonus->setDbValue($row['blackbonus']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // idinvoice

        // idorder_detail

        // jumlahorder

        // bonus

        // stockdo

        // jumlahkirim

        // jumlahbonus

        // harga

        // totalnondiskon

        // diskonpayment

        // bbpersen

        // totaltagihan

        // blackbonus

        // created_at

        // created_by

        // readonly
        $this->readonly->CellCssStyle = "white-space: nowrap;";

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idinvoice
        $this->idinvoice->ViewValue = $this->idinvoice->CurrentValue;
        $this->idinvoice->ViewValue = FormatNumber($this->idinvoice->ViewValue, 0, -2, -2, -2);
        $this->idinvoice->ViewCustomAttributes = "";

        // idorder_detail
        $curVal = trim(strval($this->idorder_detail->CurrentValue));
        if ($curVal != "") {
            $this->idorder_detail->ViewValue = $this->idorder_detail->lookupCacheOption($curVal);
            if ($this->idorder_detail->ViewValue === null) { // Lookup from database
                $filterWrk = "`idorder_detail`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "jumlah > 0" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idorder_detail->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idorder_detail->Lookup->renderViewRow($rswrk[0]);
                    $this->idorder_detail->ViewValue = $this->idorder_detail->displayValue($arwrk);
                } else {
                    $this->idorder_detail->ViewValue = $this->idorder_detail->CurrentValue;
                }
            }
        } else {
            $this->idorder_detail->ViewValue = null;
        }
        $this->idorder_detail->ViewCustomAttributes = "";

        // jumlahorder
        $this->jumlahorder->ViewValue = $this->jumlahorder->CurrentValue;
        $this->jumlahorder->ViewValue = FormatNumber($this->jumlahorder->ViewValue, 0, -2, -2, -2);
        $this->jumlahorder->ViewCustomAttributes = "";

        // bonus
        $this->bonus->ViewValue = $this->bonus->CurrentValue;
        $this->bonus->ViewValue = FormatNumber($this->bonus->ViewValue, 0, -2, -2, -2);
        $this->bonus->ViewCustomAttributes = "";

        // stockdo
        $this->stockdo->ViewValue = $this->stockdo->CurrentValue;
        $this->stockdo->ViewValue = FormatNumber($this->stockdo->ViewValue, 0, -2, -2, -2);
        $this->stockdo->ViewCustomAttributes = "";

        // jumlahkirim
        $this->jumlahkirim->ViewValue = $this->jumlahkirim->CurrentValue;
        $this->jumlahkirim->ViewValue = FormatNumber($this->jumlahkirim->ViewValue, 0, -2, -2, -2);
        $this->jumlahkirim->ViewCustomAttributes = "";

        // jumlahbonus
        $this->jumlahbonus->ViewValue = $this->jumlahbonus->CurrentValue;
        $this->jumlahbonus->ViewValue = FormatNumber($this->jumlahbonus->ViewValue, 0, -2, -2, -2);
        $this->jumlahbonus->ViewCustomAttributes = "";

        // harga
        $this->harga->ViewValue = $this->harga->CurrentValue;
        $this->harga->ViewValue = FormatCurrency($this->harga->ViewValue, 2, -2, -2, -2);
        $this->harga->ViewCustomAttributes = "";

        // totalnondiskon
        $this->totalnondiskon->ViewValue = $this->totalnondiskon->CurrentValue;
        $this->totalnondiskon->ViewValue = FormatCurrency($this->totalnondiskon->ViewValue, 2, -2, -2, -2);
        $this->totalnondiskon->ViewCustomAttributes = "";

        // diskonpayment
        $this->diskonpayment->ViewValue = $this->diskonpayment->CurrentValue;
        $this->diskonpayment->ViewValue = FormatNumber($this->diskonpayment->ViewValue, 2, -2, -2, -2);
        $this->diskonpayment->ViewCustomAttributes = "";

        // bbpersen
        $this->bbpersen->ViewValue = $this->bbpersen->CurrentValue;
        $this->bbpersen->ViewValue = FormatNumber($this->bbpersen->ViewValue, 2, -2, -2, -2);
        $this->bbpersen->ViewCustomAttributes = "";

        // totaltagihan
        $this->totaltagihan->ViewValue = $this->totaltagihan->CurrentValue;
        $this->totaltagihan->ViewValue = FormatCurrency($this->totaltagihan->ViewValue, 2, -2, -2, -2);
        $this->totaltagihan->ViewCustomAttributes = "";

        // blackbonus
        $this->blackbonus->ViewValue = $this->blackbonus->CurrentValue;
        $this->blackbonus->ViewValue = FormatCurrency($this->blackbonus->ViewValue, 2, -2, -2, -2);
        $this->blackbonus->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // created_by
        $this->created_by->ViewValue = $this->created_by->CurrentValue;
        $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
        $this->created_by->ViewCustomAttributes = "";

        // readonly
        $this->readonly->ViewValue = $this->readonly->CurrentValue;
        $this->readonly->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idinvoice
        $this->idinvoice->LinkCustomAttributes = "";
        $this->idinvoice->HrefValue = "";
        $this->idinvoice->TooltipValue = "";

        // idorder_detail
        $this->idorder_detail->LinkCustomAttributes = "";
        $this->idorder_detail->HrefValue = "";
        $this->idorder_detail->TooltipValue = "";

        // jumlahorder
        $this->jumlahorder->LinkCustomAttributes = "";
        $this->jumlahorder->HrefValue = "";
        $this->jumlahorder->TooltipValue = "";

        // bonus
        $this->bonus->LinkCustomAttributes = "";
        $this->bonus->HrefValue = "";
        $this->bonus->TooltipValue = "";

        // stockdo
        $this->stockdo->LinkCustomAttributes = "";
        $this->stockdo->HrefValue = "";
        $this->stockdo->TooltipValue = "";

        // jumlahkirim
        $this->jumlahkirim->LinkCustomAttributes = "";
        $this->jumlahkirim->HrefValue = "";
        $this->jumlahkirim->TooltipValue = "";

        // jumlahbonus
        $this->jumlahbonus->LinkCustomAttributes = "";
        $this->jumlahbonus->HrefValue = "";
        $this->jumlahbonus->TooltipValue = "";

        // harga
        $this->harga->LinkCustomAttributes = "";
        $this->harga->HrefValue = "";
        $this->harga->TooltipValue = "";

        // totalnondiskon
        $this->totalnondiskon->LinkCustomAttributes = "";
        $this->totalnondiskon->HrefValue = "";
        $this->totalnondiskon->TooltipValue = "";

        // diskonpayment
        $this->diskonpayment->LinkCustomAttributes = "";
        $this->diskonpayment->HrefValue = "";
        $this->diskonpayment->TooltipValue = "";

        // bbpersen
        $this->bbpersen->LinkCustomAttributes = "";
        $this->bbpersen->HrefValue = "";
        $this->bbpersen->TooltipValue = "";

        // totaltagihan
        $this->totaltagihan->LinkCustomAttributes = "";
        $this->totaltagihan->HrefValue = "";
        $this->totaltagihan->TooltipValue = "";

        // blackbonus
        $this->blackbonus->LinkCustomAttributes = "";
        $this->blackbonus->HrefValue = "";
        $this->blackbonus->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // created_by
        $this->created_by->LinkCustomAttributes = "";
        $this->created_by->HrefValue = "";
        $this->created_by->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

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

        // idinvoice
        $this->idinvoice->EditAttrs["class"] = "form-control";
        $this->idinvoice->EditCustomAttributes = "";
        if ($this->idinvoice->getSessionValue() != "") {
            $this->idinvoice->CurrentValue = GetForeignKeyValue($this->idinvoice->getSessionValue());
            $this->idinvoice->ViewValue = $this->idinvoice->CurrentValue;
            $this->idinvoice->ViewValue = FormatNumber($this->idinvoice->ViewValue, 0, -2, -2, -2);
            $this->idinvoice->ViewCustomAttributes = "";
        } else {
            $this->idinvoice->EditValue = $this->idinvoice->CurrentValue;
            $this->idinvoice->PlaceHolder = RemoveHtml($this->idinvoice->caption());
        }

        // idorder_detail
        $this->idorder_detail->EditAttrs["class"] = "form-control";
        $this->idorder_detail->EditCustomAttributes = "";
        $this->idorder_detail->PlaceHolder = RemoveHtml($this->idorder_detail->caption());

        // jumlahorder
        $this->jumlahorder->EditAttrs["class"] = "form-control";
        $this->jumlahorder->EditCustomAttributes = "readonly";
        $this->jumlahorder->EditValue = $this->jumlahorder->CurrentValue;
        $this->jumlahorder->PlaceHolder = RemoveHtml($this->jumlahorder->caption());

        // bonus
        $this->bonus->EditAttrs["class"] = "form-control";
        $this->bonus->EditCustomAttributes = "readonly";
        $this->bonus->EditValue = $this->bonus->CurrentValue;
        $this->bonus->PlaceHolder = RemoveHtml($this->bonus->caption());

        // stockdo
        $this->stockdo->EditAttrs["class"] = "form-control";
        $this->stockdo->EditCustomAttributes = "readonly";
        $this->stockdo->EditValue = $this->stockdo->CurrentValue;
        $this->stockdo->PlaceHolder = RemoveHtml($this->stockdo->caption());

        // jumlahkirim
        $this->jumlahkirim->EditAttrs["class"] = "form-control";
        $this->jumlahkirim->EditCustomAttributes = "";
        $this->jumlahkirim->EditValue = $this->jumlahkirim->CurrentValue;
        $this->jumlahkirim->PlaceHolder = RemoveHtml($this->jumlahkirim->caption());

        // jumlahbonus
        $this->jumlahbonus->EditAttrs["class"] = "form-control";
        $this->jumlahbonus->EditCustomAttributes = "readonly";
        $this->jumlahbonus->EditValue = $this->jumlahbonus->CurrentValue;
        $this->jumlahbonus->PlaceHolder = RemoveHtml($this->jumlahbonus->caption());

        // harga
        $this->harga->EditAttrs["class"] = "form-control";
        $this->harga->EditCustomAttributes = "readonly";
        $this->harga->EditValue = $this->harga->CurrentValue;
        $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());

        // totalnondiskon
        $this->totalnondiskon->EditAttrs["class"] = "form-control";
        $this->totalnondiskon->EditCustomAttributes = "readonly";
        $this->totalnondiskon->EditValue = $this->totalnondiskon->CurrentValue;
        $this->totalnondiskon->PlaceHolder = RemoveHtml($this->totalnondiskon->caption());

        // diskonpayment
        $this->diskonpayment->EditAttrs["class"] = "form-control";
        $this->diskonpayment->EditCustomAttributes = "";
        $this->diskonpayment->EditValue = $this->diskonpayment->CurrentValue;
        $this->diskonpayment->PlaceHolder = RemoveHtml($this->diskonpayment->caption());
        if (strval($this->diskonpayment->EditValue) != "" && is_numeric($this->diskonpayment->EditValue)) {
            $this->diskonpayment->EditValue = FormatNumber($this->diskonpayment->EditValue, -2, -2, -2, -2);
        }

        // bbpersen
        $this->bbpersen->EditAttrs["class"] = "form-control";
        $this->bbpersen->EditCustomAttributes = "";
        $this->bbpersen->EditValue = $this->bbpersen->CurrentValue;
        $this->bbpersen->PlaceHolder = RemoveHtml($this->bbpersen->caption());
        if (strval($this->bbpersen->EditValue) != "" && is_numeric($this->bbpersen->EditValue)) {
            $this->bbpersen->EditValue = FormatNumber($this->bbpersen->EditValue, -2, -2, -2, -2);
        }

        // totaltagihan
        $this->totaltagihan->EditAttrs["class"] = "form-control";
        $this->totaltagihan->EditCustomAttributes = "readonly";
        $this->totaltagihan->EditValue = $this->totaltagihan->CurrentValue;
        $this->totaltagihan->PlaceHolder = RemoveHtml($this->totaltagihan->caption());

        // blackbonus
        $this->blackbonus->EditAttrs["class"] = "form-control";
        $this->blackbonus->EditCustomAttributes = "readonly";
        $this->blackbonus->EditValue = $this->blackbonus->CurrentValue;
        $this->blackbonus->PlaceHolder = RemoveHtml($this->blackbonus->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";

        // readonly
        $this->readonly->EditAttrs["class"] = "form-control";
        $this->readonly->EditCustomAttributes = "";

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
                    $doc->exportCaption($this->idorder_detail);
                    $doc->exportCaption($this->jumlahorder);
                    $doc->exportCaption($this->bonus);
                    $doc->exportCaption($this->stockdo);
                    $doc->exportCaption($this->jumlahkirim);
                    $doc->exportCaption($this->jumlahbonus);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->totalnondiskon);
                    $doc->exportCaption($this->diskonpayment);
                    $doc->exportCaption($this->bbpersen);
                    $doc->exportCaption($this->totaltagihan);
                    $doc->exportCaption($this->blackbonus);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idinvoice);
                    $doc->exportCaption($this->idorder_detail);
                    $doc->exportCaption($this->jumlahorder);
                    $doc->exportCaption($this->bonus);
                    $doc->exportCaption($this->stockdo);
                    $doc->exportCaption($this->jumlahkirim);
                    $doc->exportCaption($this->jumlahbonus);
                    $doc->exportCaption($this->harga);
                    $doc->exportCaption($this->totalnondiskon);
                    $doc->exportCaption($this->diskonpayment);
                    $doc->exportCaption($this->bbpersen);
                    $doc->exportCaption($this->totaltagihan);
                    $doc->exportCaption($this->blackbonus);
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
                        $doc->exportField($this->idorder_detail);
                        $doc->exportField($this->jumlahorder);
                        $doc->exportField($this->bonus);
                        $doc->exportField($this->stockdo);
                        $doc->exportField($this->jumlahkirim);
                        $doc->exportField($this->jumlahbonus);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->totalnondiskon);
                        $doc->exportField($this->diskonpayment);
                        $doc->exportField($this->bbpersen);
                        $doc->exportField($this->totaltagihan);
                        $doc->exportField($this->blackbonus);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idinvoice);
                        $doc->exportField($this->idorder_detail);
                        $doc->exportField($this->jumlahorder);
                        $doc->exportField($this->bonus);
                        $doc->exportField($this->stockdo);
                        $doc->exportField($this->jumlahkirim);
                        $doc->exportField($this->jumlahbonus);
                        $doc->exportField($this->harga);
                        $doc->exportField($this->totalnondiskon);
                        $doc->exportField($this->diskonpayment);
                        $doc->exportField($this->bbpersen);
                        $doc->exportField($this->totaltagihan);
                        $doc->exportField($this->blackbonus);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `invoice_detail`";
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

    // Add master User ID filter
    public function addMasterUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "invoice") {
            $filterWrk = Container("invoice")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "invoice") {
            $mastertable = Container("invoice");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->idinvoice, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        return $filterWrk;
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

        // kurangi stock
        addStock($rsnew['idorder_detail'], -$rsnew['stockdo']);

        // update read only deliveryorder_detail dan deliveryorder
        $update = ExecuteUpdate("UPDATE deliveryorder_detail SET readonly=1 WHERE idorder_detail=".$rsnew['idorder_detail']);
        // yang deliveryorder:
        $query = ExecuteQuery("SELECT d.id, dd.idorder_detail FROM deliveryorder d, deliveryorder_detail dd WHERE d.id = dd.iddeliveryorder AND dd.idorder_detail=".$rsnew['idorder_detail']);
        $results = $query->fetchAll();
        foreach ($results as $res) {
        	$update = ExecuteUpdate("UPDATE deliveryorder SET readonly=1 WHERE id=".$res['id']);
        }
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        // update perhitungan invoice
        updateInvoice($rsnew['idinvoice']);
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        $rsnew['idorder'] = $rsold['idorder'];
        $rsnew['idorder_detail'] = $rsold['idorder_detail'];
        addStock($rsnew['idorder_detail'], $rsold['stockdo']-$rsnew['stockdo']);
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        // update perhitungan invoice
        updateInvoice($rsold['idinvoice']);
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

        // update stock
        addStock($rs['idorder_detail'], $rs['stockdo']);

        // update read only deliveryorder_detail dan deliveryorder
        $update = ExecuteUpdate("UPDATE deliveryorder_detail SET readonly=0 WHERE idorder_detail=".$rsnew['idorder_detail']);
        // yang deliveryorder:
        $query = ExecuteQuery("SELECT d.id, dd.idorder_detail FROM deliveryorder d, deliveryorder_detail dd WHERE d.id = dd.iddeliveryorder AND dd.idorder_detail=".$rsnew['idorder_detail']);
        $results = $query->fetchAll();
        foreach ($results as $res) {
        	$hasReadOnly = ExecuteScalar("SELECT COUNT(id) FROM deliveryorder_detail where readonly=1 AND iddeliveryorder=".$res['id']);
        	if ($hasReadOnly == 0) {
        		$update = ExecuteUpdate("UPDATE deliveryorder SET readonly=0 WHERE id=".$res['id']);
        	}
        }
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        // update perhitungan invoice
        updateInvoice($rs['idinvoice']);
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
