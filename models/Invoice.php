<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for invoice
 */
class Invoice extends DbTable
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
    public $kode;
    public $tglinvoice;
    public $idcustomer;
    public $idorder;
    public $totalnonpajak;
    public $pajak;
    public $totaltagihan;
    public $sisabayar;
    public $idtermpayment;
    public $idtipepayment;
    public $keterangan;
    public $created_at;
    public $created_by;
    public $aktif;
    public $readonly;
    public $sent;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'invoice';
        $this->TableName = 'invoice';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`invoice`";
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
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 1;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('invoice', 'invoice', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // kode
        $this->kode = new DbField('invoice', 'invoice', 'x_kode', 'kode', '`kode`', '`kode`', 200, 50, -1, false, '`kode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode->Nullable = false; // NOT NULL field
        $this->kode->Required = true; // Required field
        $this->kode->Sortable = true; // Allow sort
        $this->kode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode->Param, "CustomMsg");
        $this->Fields['kode'] = &$this->kode;

        // tglinvoice
        $this->tglinvoice = new DbField('invoice', 'invoice', 'x_tglinvoice', 'tglinvoice', '`tglinvoice`', CastDateFieldForLike("`tglinvoice`", 0, "DB"), 135, 19, 0, false, '`tglinvoice`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglinvoice->Nullable = false; // NOT NULL field
        $this->tglinvoice->Required = true; // Required field
        $this->tglinvoice->Sortable = true; // Allow sort
        $this->tglinvoice->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglinvoice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglinvoice->Param, "CustomMsg");
        $this->Fields['tglinvoice'] = &$this->tglinvoice;

        // idcustomer
        $this->idcustomer = new DbField('invoice', 'invoice', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idcustomer->IsForeignKey = true; // Foreign key field
        $this->idcustomer->Nullable = false; // NOT NULL field
        $this->idcustomer->Required = true; // Required field
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idcustomer->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'v_do_stock', false, 'idcustomer', ["kodecustomer","namacustomer","",""], [], ["x_idorder"], [], [], [], [], '', '');
                break;
            default:
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'v_do_stock', false, 'idcustomer', ["kodecustomer","namacustomer","",""], [], ["x_idorder"], [], [], [], [], '', '');
                break;
        }
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // idorder
        $this->idorder = new DbField('invoice', 'invoice', 'x_idorder', 'idorder', '`idorder`', '`idorder`', 3, 11, -1, false, '`idorder`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idorder->Nullable = false; // NOT NULL field
        $this->idorder->Required = true; // Required field
        $this->idorder->Sortable = true; // Allow sort
        $this->idorder->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idorder->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idorder->Lookup = new Lookup('idorder', 'v_stock', true, 'idorder', ["kodepo","tanggalpo","",""], ["x_idcustomer"], ["invoice_detail x_idorder_detail"], ["idcustomer"], ["x_idcustomer"], [], [], '', '');
                break;
            default:
                $this->idorder->Lookup = new Lookup('idorder', 'v_stock', true, 'idorder', ["kodepo","tanggalpo","",""], ["x_idcustomer"], ["invoice_detail x_idorder_detail"], ["idcustomer"], ["x_idcustomer"], [], [], '', '');
                break;
        }
        $this->idorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idorder->Param, "CustomMsg");
        $this->Fields['idorder'] = &$this->idorder;

        // totalnonpajak
        $this->totalnonpajak = new DbField('invoice', 'invoice', 'x_totalnonpajak', 'totalnonpajak', '`totalnonpajak`', '`totalnonpajak`', 20, 20, -1, false, '`totalnonpajak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totalnonpajak->Nullable = false; // NOT NULL field
        $this->totalnonpajak->Sortable = true; // Allow sort
        $this->totalnonpajak->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->totalnonpajak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totalnonpajak->Param, "CustomMsg");
        $this->Fields['totalnonpajak'] = &$this->totalnonpajak;

        // pajak
        $this->pajak = new DbField('invoice', 'invoice', 'x_pajak', 'pajak', '`pajak`', '`pajak`', 5, 22, -1, false, '`pajak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pajak->Nullable = false; // NOT NULL field
        $this->pajak->Sortable = true; // Allow sort
        $this->pajak->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->pajak->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->pajak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pajak->Param, "CustomMsg");
        $this->Fields['pajak'] = &$this->pajak;

        // totaltagihan
        $this->totaltagihan = new DbField('invoice', 'invoice', 'x_totaltagihan', 'totaltagihan', '`totaltagihan`', '`totaltagihan`', 20, 20, -1, false, '`totaltagihan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->totaltagihan->Nullable = false; // NOT NULL field
        $this->totaltagihan->Sortable = true; // Allow sort
        $this->totaltagihan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->totaltagihan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->totaltagihan->Param, "CustomMsg");
        $this->Fields['totaltagihan'] = &$this->totaltagihan;

        // sisabayar
        $this->sisabayar = new DbField('invoice', 'invoice', 'x_sisabayar', 'sisabayar', '`sisabayar`', '`sisabayar`', 20, 20, -1, false, '`sisabayar`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisabayar->Nullable = false; // NOT NULL field
        $this->sisabayar->Sortable = true; // Allow sort
        $this->sisabayar->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisabayar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisabayar->Param, "CustomMsg");
        $this->Fields['sisabayar'] = &$this->sisabayar;

        // idtermpayment
        $this->idtermpayment = new DbField('invoice', 'invoice', 'x_idtermpayment', 'idtermpayment', '`idtermpayment`', '`idtermpayment`', 3, 11, -1, false, '`idtermpayment`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idtermpayment->Nullable = false; // NOT NULL field
        $this->idtermpayment->Required = true; // Required field
        $this->idtermpayment->Sortable = true; // Allow sort
        $this->idtermpayment->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idtermpayment->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idtermpayment->Lookup = new Lookup('idtermpayment', 'termpayment', false, 'id', ["title","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idtermpayment->Lookup = new Lookup('idtermpayment', 'termpayment', false, 'id', ["title","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idtermpayment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idtermpayment->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idtermpayment->Param, "CustomMsg");
        $this->Fields['idtermpayment'] = &$this->idtermpayment;

        // idtipepayment
        $this->idtipepayment = new DbField('invoice', 'invoice', 'x_idtipepayment', 'idtipepayment', '`idtipepayment`', '`idtipepayment`', 3, 11, -1, false, '`idtipepayment`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idtipepayment->Sortable = true; // Allow sort
        $this->idtipepayment->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idtipepayment->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idtipepayment->Lookup = new Lookup('idtipepayment', 'tipepayment', false, 'id', ["payment","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->idtipepayment->Lookup = new Lookup('idtipepayment', 'tipepayment', false, 'id', ["payment","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->idtipepayment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idtipepayment->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idtipepayment->Param, "CustomMsg");
        $this->Fields['idtipepayment'] = &$this->idtipepayment;

        // keterangan
        $this->keterangan = new DbField('invoice', 'invoice', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, 255, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // created_at
        $this->created_at = new DbField('invoice', 'invoice', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // created_by
        $this->created_by = new DbField('invoice', 'invoice', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_by->Param, "CustomMsg");
        $this->Fields['created_by'] = &$this->created_by;

        // aktif
        $this->aktif = new DbField('invoice', 'invoice', 'x_aktif', 'aktif', '`aktif`', '`aktif`', 16, 1, -1, false, '`aktif`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->aktif->Nullable = false; // NOT NULL field
        $this->aktif->Sortable = true; // Allow sort
        $this->aktif->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->aktif->Lookup = new Lookup('aktif', 'invoice', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aktif->Lookup = new Lookup('aktif', 'invoice', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aktif->OptionCount = 2;
        $this->aktif->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->aktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aktif->Param, "CustomMsg");
        $this->Fields['aktif'] = &$this->aktif;

        // readonly
        $this->readonly = new DbField('invoice', 'invoice', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = false; // Allow sort
        $this->readonly->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->readonly->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->readonly->Param, "CustomMsg");
        $this->Fields['readonly'] = &$this->readonly;

        // sent
        $this->sent = new DbField('invoice', 'invoice', 'x_sent', 'sent', '`sent`', '`sent`', 16, 1, -1, false, '`sent`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->sent->Nullable = false; // NOT NULL field
        $this->sent->Sortable = false; // Allow sort
        $this->sent->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->sent->Lookup = new Lookup('sent', 'invoice', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->sent->Lookup = new Lookup('sent', 'invoice', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->sent->OptionCount = 2;
        $this->sent->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->sent->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sent->Param, "CustomMsg");
        $this->Fields['sent'] = &$this->sent;
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
        if ($this->getCurrentMasterTable() == "suratjalan_detail") {
            if ($this->id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`idinvoice`", $this->id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "pembayaran") {
            if ($this->id->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`idinvoice`", $this->id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
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
        if ($this->getCurrentMasterTable() == "suratjalan_detail") {
            if ($this->id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`id`", $this->id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        if ($this->getCurrentMasterTable() == "pembayaran") {
            if ($this->id->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`id`", $this->id->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
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
    public function sqlMasterFilter_suratjalan_detail()
    {
        return "`idinvoice`=@idinvoice@";
    }
    // Detail filter
    public function sqlDetailFilter_suratjalan_detail()
    {
        return "`id`=@id@";
    }

    // Master filter
    public function sqlMasterFilter_pembayaran()
    {
        return "`idinvoice`=@idinvoice@";
    }
    // Detail filter
    public function sqlDetailFilter_pembayaran()
    {
        return "`id`=@id@";
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
        if ($this->getCurrentDetailTable() == "invoice_detail") {
            $detailUrl = Container("invoice_detail")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "InvoiceList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`invoice`";
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
        $this->kode->DbValue = $row['kode'];
        $this->tglinvoice->DbValue = $row['tglinvoice'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->idorder->DbValue = $row['idorder'];
        $this->totalnonpajak->DbValue = $row['totalnonpajak'];
        $this->pajak->DbValue = $row['pajak'];
        $this->totaltagihan->DbValue = $row['totaltagihan'];
        $this->sisabayar->DbValue = $row['sisabayar'];
        $this->idtermpayment->DbValue = $row['idtermpayment'];
        $this->idtipepayment->DbValue = $row['idtipepayment'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->created_at->DbValue = $row['created_at'];
        $this->created_by->DbValue = $row['created_by'];
        $this->aktif->DbValue = $row['aktif'];
        $this->readonly->DbValue = $row['readonly'];
        $this->sent->DbValue = $row['sent'];
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
        return $_SESSION[$name] ?? GetUrl("InvoiceList");
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
        if ($pageName == "InvoiceView") {
            return $Language->phrase("View");
        } elseif ($pageName == "InvoiceEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "InvoiceAdd") {
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
                return "InvoiceView";
            case Config("API_ADD_ACTION"):
                return "InvoiceAdd";
            case Config("API_EDIT_ACTION"):
                return "InvoiceEdit";
            case Config("API_DELETE_ACTION"):
                return "InvoiceDelete";
            case Config("API_LIST_ACTION"):
                return "InvoiceList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "InvoiceList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("InvoiceView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("InvoiceView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "InvoiceAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "InvoiceAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("InvoiceEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("InvoiceEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("InvoiceAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("InvoiceAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("InvoiceDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "suratjalan_detail" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idinvoice", $this->id->CurrentValue ?? $this->id->getSessionValue());
        }
        if ($this->getCurrentMasterTable() == "pembayaran" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_idinvoice", $this->id->CurrentValue ?? $this->id->getSessionValue());
        }
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
        $this->kode->setDbValue($row['kode']);
        $this->tglinvoice->setDbValue($row['tglinvoice']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idorder->setDbValue($row['idorder']);
        $this->totalnonpajak->setDbValue($row['totalnonpajak']);
        $this->pajak->setDbValue($row['pajak']);
        $this->totaltagihan->setDbValue($row['totaltagihan']);
        $this->sisabayar->setDbValue($row['sisabayar']);
        $this->idtermpayment->setDbValue($row['idtermpayment']);
        $this->idtipepayment->setDbValue($row['idtipepayment']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->aktif->setDbValue($row['aktif']);
        $this->readonly->setDbValue($row['readonly']);
        $this->sent->setDbValue($row['sent']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // kode

        // tglinvoice

        // idcustomer

        // idorder

        // totalnonpajak

        // pajak

        // totaltagihan

        // sisabayar

        // idtermpayment

        // idtipepayment

        // keterangan

        // created_at

        // created_by

        // aktif

        // readonly
        $this->readonly->CellCssStyle = "white-space: nowrap;";

        // sent

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // kode
        $this->kode->ViewValue = $this->kode->CurrentValue;
        $this->kode->ViewCustomAttributes = "";

        // tglinvoice
        $this->tglinvoice->ViewValue = $this->tglinvoice->CurrentValue;
        $this->tglinvoice->ViewValue = FormatDateTime($this->tglinvoice->ViewValue, 0);
        $this->tglinvoice->ViewCustomAttributes = "";

        // idcustomer
        $curVal = trim(strval($this->idcustomer->CurrentValue));
        if ($curVal != "") {
            $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
            if ($this->idcustomer->ViewValue === null) { // Lookup from database
                $filterWrk = "`idcustomer`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add") ? "jumlah > 0" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

        // idorder
        $curVal = trim(strval($this->idorder->CurrentValue));
        if ($curVal != "") {
            $this->idorder->ViewValue = $this->idorder->lookupCacheOption($curVal);
            if ($this->idorder->ViewValue === null) { // Lookup from database
                $filterWrk = "`idorder`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "jumlah > 0" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idorder->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idorder->Lookup->renderViewRow($rswrk[0]);
                    $this->idorder->ViewValue = $this->idorder->displayValue($arwrk);
                } else {
                    $this->idorder->ViewValue = $this->idorder->CurrentValue;
                }
            }
        } else {
            $this->idorder->ViewValue = null;
        }
        $this->idorder->ViewCustomAttributes = "";

        // totalnonpajak
        $this->totalnonpajak->ViewValue = $this->totalnonpajak->CurrentValue;
        $this->totalnonpajak->ViewValue = FormatCurrency($this->totalnonpajak->ViewValue, 2, -2, -2, -2);
        $this->totalnonpajak->ViewCustomAttributes = "";

        // pajak
        $this->pajak->ViewValue = $this->pajak->CurrentValue;
        $this->pajak->ViewValue = FormatNumber($this->pajak->ViewValue, 2, -2, -2, -2);
        $this->pajak->ViewCustomAttributes = "";

        // totaltagihan
        $this->totaltagihan->ViewValue = $this->totaltagihan->CurrentValue;
        $this->totaltagihan->ViewValue = FormatCurrency($this->totaltagihan->ViewValue, 2, -2, -2, -2);
        $this->totaltagihan->ViewCustomAttributes = "";

        // sisabayar
        $this->sisabayar->ViewValue = $this->sisabayar->CurrentValue;
        $this->sisabayar->ViewValue = FormatCurrency($this->sisabayar->ViewValue, 2, -2, -2, -2);
        $this->sisabayar->ViewCustomAttributes = "";

        // idtermpayment
        $curVal = trim(strval($this->idtermpayment->CurrentValue));
        if ($curVal != "") {
            $this->idtermpayment->ViewValue = $this->idtermpayment->lookupCacheOption($curVal);
            if ($this->idtermpayment->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idtermpayment->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idtermpayment->Lookup->renderViewRow($rswrk[0]);
                    $this->idtermpayment->ViewValue = $this->idtermpayment->displayValue($arwrk);
                } else {
                    $this->idtermpayment->ViewValue = $this->idtermpayment->CurrentValue;
                }
            }
        } else {
            $this->idtermpayment->ViewValue = null;
        }
        $this->idtermpayment->ViewCustomAttributes = "";

        // idtipepayment
        $curVal = trim(strval($this->idtipepayment->CurrentValue));
        if ($curVal != "") {
            $this->idtipepayment->ViewValue = $this->idtipepayment->lookupCacheOption($curVal);
            if ($this->idtipepayment->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idtipepayment->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idtipepayment->Lookup->renderViewRow($rswrk[0]);
                    $this->idtipepayment->ViewValue = $this->idtipepayment->displayValue($arwrk);
                } else {
                    $this->idtipepayment->ViewValue = $this->idtipepayment->CurrentValue;
                }
            }
        } else {
            $this->idtipepayment->ViewValue = null;
        }
        $this->idtipepayment->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // created_by
        $this->created_by->ViewValue = $this->created_by->CurrentValue;
        $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
        $this->created_by->ViewCustomAttributes = "";

        // aktif
        if (ConvertToBool($this->aktif->CurrentValue)) {
            $this->aktif->ViewValue = $this->aktif->tagCaption(1) != "" ? $this->aktif->tagCaption(1) : "Yes";
        } else {
            $this->aktif->ViewValue = $this->aktif->tagCaption(2) != "" ? $this->aktif->tagCaption(2) : "No";
        }
        $this->aktif->ViewCustomAttributes = "";

        // readonly
        $this->readonly->ViewValue = $this->readonly->CurrentValue;
        $this->readonly->ViewCustomAttributes = "";

        // sent
        if (ConvertToBool($this->sent->CurrentValue)) {
            $this->sent->ViewValue = $this->sent->tagCaption(1) != "" ? $this->sent->tagCaption(1) : "Yes";
        } else {
            $this->sent->ViewValue = $this->sent->tagCaption(2) != "" ? $this->sent->tagCaption(2) : "No";
        }
        $this->sent->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // kode
        $this->kode->LinkCustomAttributes = "";
        $this->kode->HrefValue = "";
        $this->kode->TooltipValue = "";

        // tglinvoice
        $this->tglinvoice->LinkCustomAttributes = "";
        $this->tglinvoice->HrefValue = "";
        $this->tglinvoice->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // idorder
        $this->idorder->LinkCustomAttributes = "";
        if (!EmptyValue($this->idorder->CurrentValue)) {
            $this->idorder->HrefValue = $this->idorder->CurrentValue; // Add prefix/suffix
            $this->idorder->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->idorder->HrefValue = FullUrl($this->idorder->HrefValue, "href");
            }
        } else {
            $this->idorder->HrefValue = "";
        }
        $this->idorder->TooltipValue = "";

        // totalnonpajak
        $this->totalnonpajak->LinkCustomAttributes = "";
        $this->totalnonpajak->HrefValue = "";
        $this->totalnonpajak->TooltipValue = "";

        // pajak
        $this->pajak->LinkCustomAttributes = "";
        $this->pajak->HrefValue = "";
        $this->pajak->TooltipValue = "";

        // totaltagihan
        $this->totaltagihan->LinkCustomAttributes = "";
        $this->totaltagihan->HrefValue = "";
        $this->totaltagihan->TooltipValue = "";

        // sisabayar
        $this->sisabayar->LinkCustomAttributes = "";
        $this->sisabayar->HrefValue = "";
        $this->sisabayar->TooltipValue = "";

        // idtermpayment
        $this->idtermpayment->LinkCustomAttributes = "";
        $this->idtermpayment->HrefValue = "";
        $this->idtermpayment->TooltipValue = "";

        // idtipepayment
        $this->idtipepayment->LinkCustomAttributes = "";
        $this->idtipepayment->HrefValue = "";
        $this->idtipepayment->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // created_by
        $this->created_by->LinkCustomAttributes = "";
        $this->created_by->HrefValue = "";
        $this->created_by->TooltipValue = "";

        // aktif
        $this->aktif->LinkCustomAttributes = "";
        $this->aktif->HrefValue = "";
        $this->aktif->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

        // sent
        $this->sent->LinkCustomAttributes = "";
        $this->sent->HrefValue = "";
        $this->sent->TooltipValue = "";

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

        // kode
        $this->kode->EditAttrs["class"] = "form-control";
        $this->kode->EditCustomAttributes = "readonly";
        if (!$this->kode->Raw) {
            $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
        }
        $this->kode->EditValue = $this->kode->CurrentValue;
        $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

        // tglinvoice
        $this->tglinvoice->EditAttrs["class"] = "form-control";
        $this->tglinvoice->EditCustomAttributes = "";
        $this->tglinvoice->EditValue = FormatDateTime($this->tglinvoice->CurrentValue, 8);
        $this->tglinvoice->PlaceHolder = RemoveHtml($this->tglinvoice->caption());

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        if ($this->idcustomer->getSessionValue() != "") {
            $this->idcustomer->CurrentValue = GetForeignKeyValue($this->idcustomer->getSessionValue());
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idcustomer`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add") ? "jumlah > 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

        // idorder
        $this->idorder->EditAttrs["class"] = "form-control";
        $this->idorder->EditCustomAttributes = "";
        $this->idorder->PlaceHolder = RemoveHtml($this->idorder->caption());

        // totalnonpajak
        $this->totalnonpajak->EditAttrs["class"] = "form-control";
        $this->totalnonpajak->EditCustomAttributes = "readonly";
        $this->totalnonpajak->EditValue = $this->totalnonpajak->CurrentValue;
        $this->totalnonpajak->PlaceHolder = RemoveHtml($this->totalnonpajak->caption());

        // pajak
        $this->pajak->EditAttrs["class"] = "form-control";
        $this->pajak->EditCustomAttributes = "";
        $this->pajak->EditValue = $this->pajak->CurrentValue;
        $this->pajak->PlaceHolder = RemoveHtml($this->pajak->caption());
        if (strval($this->pajak->EditValue) != "" && is_numeric($this->pajak->EditValue)) {
            $this->pajak->EditValue = FormatNumber($this->pajak->EditValue, -2, -2, -2, -2);
        }

        // totaltagihan
        $this->totaltagihan->EditAttrs["class"] = "form-control";
        $this->totaltagihan->EditCustomAttributes = "readonly";
        $this->totaltagihan->EditValue = $this->totaltagihan->CurrentValue;
        $this->totaltagihan->PlaceHolder = RemoveHtml($this->totaltagihan->caption());

        // sisabayar
        $this->sisabayar->EditAttrs["class"] = "form-control";
        $this->sisabayar->EditCustomAttributes = "";
        $this->sisabayar->EditValue = $this->sisabayar->CurrentValue;
        $this->sisabayar->PlaceHolder = RemoveHtml($this->sisabayar->caption());

        // idtermpayment
        $this->idtermpayment->EditAttrs["class"] = "form-control";
        $this->idtermpayment->EditCustomAttributes = "";
        $this->idtermpayment->PlaceHolder = RemoveHtml($this->idtermpayment->caption());

        // idtipepayment
        $this->idtipepayment->EditAttrs["class"] = "form-control";
        $this->idtipepayment->EditCustomAttributes = "";
        $this->idtipepayment->PlaceHolder = RemoveHtml($this->idtipepayment->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";

        // aktif
        $this->aktif->EditCustomAttributes = "";
        $this->aktif->EditValue = $this->aktif->options(false);
        $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

        // readonly
        $this->readonly->EditAttrs["class"] = "form-control";
        $this->readonly->EditCustomAttributes = "";

        // sent
        $this->sent->EditCustomAttributes = "";
        $this->sent->EditValue = $this->sent->options(false);
        $this->sent->PlaceHolder = RemoveHtml($this->sent->caption());

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
                    $doc->exportCaption($this->tglinvoice);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idorder);
                    $doc->exportCaption($this->totalnonpajak);
                    $doc->exportCaption($this->pajak);
                    $doc->exportCaption($this->totaltagihan);
                    $doc->exportCaption($this->sisabayar);
                    $doc->exportCaption($this->idtermpayment);
                    $doc->exportCaption($this->idtipepayment);
                    $doc->exportCaption($this->keterangan);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->tglinvoice);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->idorder);
                    $doc->exportCaption($this->totalnonpajak);
                    $doc->exportCaption($this->pajak);
                    $doc->exportCaption($this->totaltagihan);
                    $doc->exportCaption($this->sisabayar);
                    $doc->exportCaption($this->idtermpayment);
                    $doc->exportCaption($this->idtipepayment);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->created_by);
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
                        $doc->exportField($this->tglinvoice);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idorder);
                        $doc->exportField($this->totalnonpajak);
                        $doc->exportField($this->pajak);
                        $doc->exportField($this->totaltagihan);
                        $doc->exportField($this->sisabayar);
                        $doc->exportField($this->idtermpayment);
                        $doc->exportField($this->idtipepayment);
                        $doc->exportField($this->keterangan);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->tglinvoice);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->idorder);
                        $doc->exportField($this->totalnonpajak);
                        $doc->exportField($this->pajak);
                        $doc->exportField($this->totaltagihan);
                        $doc->exportField($this->sisabayar);
                        $doc->exportField($this->idtermpayment);
                        $doc->exportField($this->idtipepayment);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->created_by);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `invoice`";
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
        if ($currentMasterTable == "suratjalan_detail") {
            $filterWrk = Container("suratjalan_detail")->addUserIDFilter($filterWrk);
        }
        if ($currentMasterTable == "pembayaran") {
            $filterWrk = Container("pembayaran")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "suratjalan_detail") {
            $mastertable = Container("suratjalan_detail");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->id, $mastertable->idinvoice);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        if ($currentMasterTable == "pembayaran") {
            $mastertable = Container("pembayaran");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->id, $mastertable->idinvoice);
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
        $rsnew['sisabayar'] = $rsnew['totaltagihan'];
        $rsnew['kode'] = getNextKode('invoice', 0);
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
        $rsnew['sisabayar'] = $rsnew['totaltagihan'];
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
        if ($rs['readonly']) {
        	$this->setFailureMessage("Data tidak dapat dihapus karena sudah memasuki proses.");
        	return false;
        }

        // replicate children delete action
        $query = ExecuteQuery("SELECT * from invoice_detail WHERE idinvoice=".$rs['id']);
        $children = $query->fetchAll();
        $deleteChild = ExecuteUpdate("DELETE FROM invoice_detail WHERE idinvoice=".$rs['id']);
        foreach ($children as $child) {
        	// update stock
        	addStock($child['idorder_detail'], $child['jumlahkirim']);

        	// update read only deliveryorder_detail dan deliveryorder
            $update = ExecuteUpdate("UPDATE deliveryorder_detail SET readonly=0 WHERE idorder_detail=".$child['idorder_detail']);
            // yang deliveryorder:
            $query = ExecuteQuery("SELECT d.id, dd.idorder_detail FROM deliveryorder d, deliveryorder_detail dd WHERE d.id = dd.iddeliveryorder AND dd.idorder_detail=".$child['idorder_detail']);
            $results = $query->fetchAll();
            foreach ($results as $res) {
        		$hasReadOnly = ExecuteScalar("SELECT COUNT(id) FROM deliveryorder_detail where readonly=1 AND iddeliveryorder=".$res['id']);
        		if ($hasReadOnly == 0) {
        			$update = ExecuteUpdate("UPDATE deliveryorder SET readonly=0 WHERE id=".$res['id']);
        		}
        	}
        }
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
        $this->idorder->ViewValue = "<a href=\"OrderDetailList?showmaster=order&fk_id={$this->idorder->CurrentValue}\" target=\"_blank\">{$this->idorder->ViewValue}</a>";
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
