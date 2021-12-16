<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_terms
 */
class NpdTerms extends DbTable
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
    public $idnpd;
    public $status;
    public $tglsubmit;
    public $sifat_order;
    public $ukuran_utama;
    public $utama_harga_isi;
    public $utama_harga_isi_order;
    public $utama_harga_primer;
    public $utama_harga_primer_order;
    public $utama_harga_sekunder;
    public $utama_harga_sekunder_order;
    public $utama_harga_label;
    public $utama_harga_label_order;
    public $utama_harga_total;
    public $utama_harga_total_order;
    public $ukuran_lain;
    public $lain_harga_isi;
    public $lain_harga_isi_order;
    public $lain_harga_primer;
    public $lain_harga_primer_order;
    public $lain_harga_sekunder;
    public $lain_harga_sekunder_order;
    public $lain_harga_label;
    public $lain_harga_label_order;
    public $lain_harga_total;
    public $lain_harga_total_order;
    public $isi_bahan_aktif;
    public $isi_bahan_lain;
    public $isi_parfum;
    public $isi_estetika;
    public $kemasan_wadah;
    public $kemasan_tutup;
    public $kemasan_sekunder;
    public $label_desain;
    public $label_cetak;
    public $label_lainlain;
    public $delivery_pickup;
    public $delivery_singlepoint;
    public $delivery_multipoint;
    public $delivery_jumlahpoint;
    public $delivery_termslain;
    public $catatan_khusus;
    public $dibuatdi;
    public $created_at;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'npd_terms';
        $this->TableName = 'npd_terms';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_terms`";
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
        $this->id = new DbField('npd_terms', 'npd_terms', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = false; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('npd_terms', 'npd_terms', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 20, 20, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idnpd->IsForeignKey = true; // Foreign key field
        $this->idnpd->Nullable = false; // NOT NULL field
        $this->idnpd->Required = true; // Required field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // status
        $this->status = new DbField('npd_terms', 'npd_terms', 'x_status', 'status', '`status`', '`status`', 200, 50, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // tglsubmit
        $this->tglsubmit = new DbField('npd_terms', 'npd_terms', 'x_tglsubmit', 'tglsubmit', '`tglsubmit`', CastDateFieldForLike("`tglsubmit`", 0, "DB"), 135, 19, 0, false, '`tglsubmit`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglsubmit->Sortable = true; // Allow sort
        $this->tglsubmit->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglsubmit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglsubmit->Param, "CustomMsg");
        $this->Fields['tglsubmit'] = &$this->tglsubmit;

        // sifat_order
        $this->sifat_order = new DbField('npd_terms', 'npd_terms', 'x_sifat_order', 'sifat_order', '`sifat_order`', '`sifat_order`', 16, 1, -1, false, '`sifat_order`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->sifat_order->Nullable = false; // NOT NULL field
        $this->sifat_order->Required = true; // Required field
        $this->sifat_order->Sortable = true; // Allow sort
        $this->sifat_order->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->sifat_order->Lookup = new Lookup('sifat_order', 'npd_terms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->sifat_order->Lookup = new Lookup('sifat_order', 'npd_terms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->sifat_order->OptionCount = 2;
        $this->sifat_order->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->sifat_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sifat_order->Param, "CustomMsg");
        $this->Fields['sifat_order'] = &$this->sifat_order;

        // ukuran_utama
        $this->ukuran_utama = new DbField('npd_terms', 'npd_terms', 'x_ukuran_utama', 'ukuran_utama', '`ukuran_utama`', '`ukuran_utama`', 200, 50, -1, false, '`ukuran_utama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran_utama->Sortable = true; // Allow sort
        $this->ukuran_utama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran_utama->Param, "CustomMsg");
        $this->Fields['ukuran_utama'] = &$this->ukuran_utama;

        // utama_harga_isi
        $this->utama_harga_isi = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_isi', 'utama_harga_isi', '`utama_harga_isi`', '`utama_harga_isi`', 20, 20, -1, false, '`utama_harga_isi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_isi->Sortable = true; // Allow sort
        $this->utama_harga_isi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_isi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_isi->Param, "CustomMsg");
        $this->Fields['utama_harga_isi'] = &$this->utama_harga_isi;

        // utama_harga_isi_order
        $this->utama_harga_isi_order = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_isi_order', 'utama_harga_isi_order', '`utama_harga_isi_order`', '`utama_harga_isi_order`', 20, 20, -1, false, '`utama_harga_isi_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_isi_order->Sortable = true; // Allow sort
        $this->utama_harga_isi_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_isi_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_isi_order->Param, "CustomMsg");
        $this->Fields['utama_harga_isi_order'] = &$this->utama_harga_isi_order;

        // utama_harga_primer
        $this->utama_harga_primer = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_primer', 'utama_harga_primer', '`utama_harga_primer`', '`utama_harga_primer`', 20, 20, -1, false, '`utama_harga_primer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_primer->Sortable = true; // Allow sort
        $this->utama_harga_primer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_primer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_primer->Param, "CustomMsg");
        $this->Fields['utama_harga_primer'] = &$this->utama_harga_primer;

        // utama_harga_primer_order
        $this->utama_harga_primer_order = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_primer_order', 'utama_harga_primer_order', '`utama_harga_primer_order`', '`utama_harga_primer_order`', 20, 20, -1, false, '`utama_harga_primer_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_primer_order->Sortable = true; // Allow sort
        $this->utama_harga_primer_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_primer_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_primer_order->Param, "CustomMsg");
        $this->Fields['utama_harga_primer_order'] = &$this->utama_harga_primer_order;

        // utama_harga_sekunder
        $this->utama_harga_sekunder = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_sekunder', 'utama_harga_sekunder', '`utama_harga_sekunder`', '`utama_harga_sekunder`', 20, 20, -1, false, '`utama_harga_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_sekunder->Sortable = true; // Allow sort
        $this->utama_harga_sekunder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_sekunder->Param, "CustomMsg");
        $this->Fields['utama_harga_sekunder'] = &$this->utama_harga_sekunder;

        // utama_harga_sekunder_order
        $this->utama_harga_sekunder_order = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_sekunder_order', 'utama_harga_sekunder_order', '`utama_harga_sekunder_order`', '`utama_harga_sekunder_order`', 20, 20, -1, false, '`utama_harga_sekunder_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_sekunder_order->Sortable = true; // Allow sort
        $this->utama_harga_sekunder_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_sekunder_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_sekunder_order->Param, "CustomMsg");
        $this->Fields['utama_harga_sekunder_order'] = &$this->utama_harga_sekunder_order;

        // utama_harga_label
        $this->utama_harga_label = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_label', 'utama_harga_label', '`utama_harga_label`', '`utama_harga_label`', 20, 20, -1, false, '`utama_harga_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_label->Sortable = true; // Allow sort
        $this->utama_harga_label->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_label->Param, "CustomMsg");
        $this->Fields['utama_harga_label'] = &$this->utama_harga_label;

        // utama_harga_label_order
        $this->utama_harga_label_order = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_label_order', 'utama_harga_label_order', '`utama_harga_label_order`', '`utama_harga_label_order`', 20, 20, -1, false, '`utama_harga_label_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_label_order->Sortable = true; // Allow sort
        $this->utama_harga_label_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_label_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_label_order->Param, "CustomMsg");
        $this->Fields['utama_harga_label_order'] = &$this->utama_harga_label_order;

        // utama_harga_total
        $this->utama_harga_total = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_total', 'utama_harga_total', '`utama_harga_total`', '`utama_harga_total`', 20, 20, -1, false, '`utama_harga_total`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_total->Sortable = true; // Allow sort
        $this->utama_harga_total->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_total->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_total->Param, "CustomMsg");
        $this->Fields['utama_harga_total'] = &$this->utama_harga_total;

        // utama_harga_total_order
        $this->utama_harga_total_order = new DbField('npd_terms', 'npd_terms', 'x_utama_harga_total_order', 'utama_harga_total_order', '`utama_harga_total_order`', '`utama_harga_total_order`', 20, 20, -1, false, '`utama_harga_total_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utama_harga_total_order->Sortable = true; // Allow sort
        $this->utama_harga_total_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utama_harga_total_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utama_harga_total_order->Param, "CustomMsg");
        $this->Fields['utama_harga_total_order'] = &$this->utama_harga_total_order;

        // ukuran_lain
        $this->ukuran_lain = new DbField('npd_terms', 'npd_terms', 'x_ukuran_lain', 'ukuran_lain', '`ukuran_lain`', '`ukuran_lain`', 200, 50, -1, false, '`ukuran_lain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran_lain->Sortable = true; // Allow sort
        $this->ukuran_lain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran_lain->Param, "CustomMsg");
        $this->Fields['ukuran_lain'] = &$this->ukuran_lain;

        // lain_harga_isi
        $this->lain_harga_isi = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_isi', 'lain_harga_isi', '`lain_harga_isi`', '`lain_harga_isi`', 20, 20, -1, false, '`lain_harga_isi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_isi->Sortable = true; // Allow sort
        $this->lain_harga_isi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_isi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_isi->Param, "CustomMsg");
        $this->Fields['lain_harga_isi'] = &$this->lain_harga_isi;

        // lain_harga_isi_order
        $this->lain_harga_isi_order = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_isi_order', 'lain_harga_isi_order', '`lain_harga_isi_order`', '`lain_harga_isi_order`', 20, 20, -1, false, '`lain_harga_isi_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_isi_order->Sortable = true; // Allow sort
        $this->lain_harga_isi_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_isi_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_isi_order->Param, "CustomMsg");
        $this->Fields['lain_harga_isi_order'] = &$this->lain_harga_isi_order;

        // lain_harga_primer
        $this->lain_harga_primer = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_primer', 'lain_harga_primer', '`lain_harga_primer`', '`lain_harga_primer`', 20, 20, -1, false, '`lain_harga_primer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_primer->Sortable = true; // Allow sort
        $this->lain_harga_primer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_primer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_primer->Param, "CustomMsg");
        $this->Fields['lain_harga_primer'] = &$this->lain_harga_primer;

        // lain_harga_primer_order
        $this->lain_harga_primer_order = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_primer_order', 'lain_harga_primer_order', '`lain_harga_primer_order`', '`lain_harga_primer_order`', 20, 20, -1, false, '`lain_harga_primer_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_primer_order->Sortable = true; // Allow sort
        $this->lain_harga_primer_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_primer_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_primer_order->Param, "CustomMsg");
        $this->Fields['lain_harga_primer_order'] = &$this->lain_harga_primer_order;

        // lain_harga_sekunder
        $this->lain_harga_sekunder = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_sekunder', 'lain_harga_sekunder', '`lain_harga_sekunder`', '`lain_harga_sekunder`', 20, 20, -1, false, '`lain_harga_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_sekunder->Sortable = true; // Allow sort
        $this->lain_harga_sekunder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_sekunder->Param, "CustomMsg");
        $this->Fields['lain_harga_sekunder'] = &$this->lain_harga_sekunder;

        // lain_harga_sekunder_order
        $this->lain_harga_sekunder_order = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_sekunder_order', 'lain_harga_sekunder_order', '`lain_harga_sekunder_order`', '`lain_harga_sekunder_order`', 20, 20, -1, false, '`lain_harga_sekunder_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_sekunder_order->Sortable = true; // Allow sort
        $this->lain_harga_sekunder_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_sekunder_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_sekunder_order->Param, "CustomMsg");
        $this->Fields['lain_harga_sekunder_order'] = &$this->lain_harga_sekunder_order;

        // lain_harga_label
        $this->lain_harga_label = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_label', 'lain_harga_label', '`lain_harga_label`', '`lain_harga_label`', 20, 20, -1, false, '`lain_harga_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_label->Sortable = true; // Allow sort
        $this->lain_harga_label->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_label->Param, "CustomMsg");
        $this->Fields['lain_harga_label'] = &$this->lain_harga_label;

        // lain_harga_label_order
        $this->lain_harga_label_order = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_label_order', 'lain_harga_label_order', '`lain_harga_label_order`', '`lain_harga_label_order`', 20, 20, -1, false, '`lain_harga_label_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_label_order->Sortable = true; // Allow sort
        $this->lain_harga_label_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_label_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_label_order->Param, "CustomMsg");
        $this->Fields['lain_harga_label_order'] = &$this->lain_harga_label_order;

        // lain_harga_total
        $this->lain_harga_total = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_total', 'lain_harga_total', '`lain_harga_total`', '`lain_harga_total`', 20, 20, -1, false, '`lain_harga_total`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_total->Sortable = true; // Allow sort
        $this->lain_harga_total->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_total->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_total->Param, "CustomMsg");
        $this->Fields['lain_harga_total'] = &$this->lain_harga_total;

        // lain_harga_total_order
        $this->lain_harga_total_order = new DbField('npd_terms', 'npd_terms', 'x_lain_harga_total_order', 'lain_harga_total_order', '`lain_harga_total_order`', '`lain_harga_total_order`', 20, 20, -1, false, '`lain_harga_total_order`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lain_harga_total_order->Sortable = true; // Allow sort
        $this->lain_harga_total_order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lain_harga_total_order->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lain_harga_total_order->Param, "CustomMsg");
        $this->Fields['lain_harga_total_order'] = &$this->lain_harga_total_order;

        // isi_bahan_aktif
        $this->isi_bahan_aktif = new DbField('npd_terms', 'npd_terms', 'x_isi_bahan_aktif', 'isi_bahan_aktif', '`isi_bahan_aktif`', '`isi_bahan_aktif`', 200, 255, -1, false, '`isi_bahan_aktif`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isi_bahan_aktif->Sortable = true; // Allow sort
        $this->isi_bahan_aktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isi_bahan_aktif->Param, "CustomMsg");
        $this->Fields['isi_bahan_aktif'] = &$this->isi_bahan_aktif;

        // isi_bahan_lain
        $this->isi_bahan_lain = new DbField('npd_terms', 'npd_terms', 'x_isi_bahan_lain', 'isi_bahan_lain', '`isi_bahan_lain`', '`isi_bahan_lain`', 200, 255, -1, false, '`isi_bahan_lain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isi_bahan_lain->Sortable = true; // Allow sort
        $this->isi_bahan_lain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isi_bahan_lain->Param, "CustomMsg");
        $this->Fields['isi_bahan_lain'] = &$this->isi_bahan_lain;

        // isi_parfum
        $this->isi_parfum = new DbField('npd_terms', 'npd_terms', 'x_isi_parfum', 'isi_parfum', '`isi_parfum`', '`isi_parfum`', 200, 255, -1, false, '`isi_parfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isi_parfum->Sortable = true; // Allow sort
        $this->isi_parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isi_parfum->Param, "CustomMsg");
        $this->Fields['isi_parfum'] = &$this->isi_parfum;

        // isi_estetika
        $this->isi_estetika = new DbField('npd_terms', 'npd_terms', 'x_isi_estetika', 'isi_estetika', '`isi_estetika`', '`isi_estetika`', 200, 255, -1, false, '`isi_estetika`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isi_estetika->Sortable = true; // Allow sort
        $this->isi_estetika->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isi_estetika->Param, "CustomMsg");
        $this->Fields['isi_estetika'] = &$this->isi_estetika;

        // kemasan_wadah
        $this->kemasan_wadah = new DbField('npd_terms', 'npd_terms', 'x_kemasan_wadah', 'kemasan_wadah', '`kemasan_wadah`', '`kemasan_wadah`', 3, 11, -1, false, '`kemasan_wadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasan_wadah->Sortable = true; // Allow sort
        $this->kemasan_wadah->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->kemasan_wadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasan_wadah->Param, "CustomMsg");
        $this->Fields['kemasan_wadah'] = &$this->kemasan_wadah;

        // kemasan_tutup
        $this->kemasan_tutup = new DbField('npd_terms', 'npd_terms', 'x_kemasan_tutup', 'kemasan_tutup', '`kemasan_tutup`', '`kemasan_tutup`', 3, 11, -1, false, '`kemasan_tutup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasan_tutup->Sortable = true; // Allow sort
        $this->kemasan_tutup->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->kemasan_tutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasan_tutup->Param, "CustomMsg");
        $this->Fields['kemasan_tutup'] = &$this->kemasan_tutup;

        // kemasan_sekunder
        $this->kemasan_sekunder = new DbField('npd_terms', 'npd_terms', 'x_kemasan_sekunder', 'kemasan_sekunder', '`kemasan_sekunder`', '`kemasan_sekunder`', 200, 255, -1, false, '`kemasan_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasan_sekunder->Sortable = true; // Allow sort
        $this->kemasan_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasan_sekunder->Param, "CustomMsg");
        $this->Fields['kemasan_sekunder'] = &$this->kemasan_sekunder;

        // label_desain
        $this->label_desain = new DbField('npd_terms', 'npd_terms', 'x_label_desain', 'label_desain', '`label_desain`', '`label_desain`', 200, 255, -1, false, '`label_desain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->label_desain->Sortable = true; // Allow sort
        $this->label_desain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label_desain->Param, "CustomMsg");
        $this->Fields['label_desain'] = &$this->label_desain;

        // label_cetak
        $this->label_cetak = new DbField('npd_terms', 'npd_terms', 'x_label_cetak', 'label_cetak', '`label_cetak`', '`label_cetak`', 200, 255, -1, false, '`label_cetak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->label_cetak->Sortable = true; // Allow sort
        $this->label_cetak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label_cetak->Param, "CustomMsg");
        $this->Fields['label_cetak'] = &$this->label_cetak;

        // label_lainlain
        $this->label_lainlain = new DbField('npd_terms', 'npd_terms', 'x_label_lainlain', 'label_lainlain', '`label_lainlain`', '`label_lainlain`', 200, 255, -1, false, '`label_lainlain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->label_lainlain->Sortable = true; // Allow sort
        $this->label_lainlain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label_lainlain->Param, "CustomMsg");
        $this->Fields['label_lainlain'] = &$this->label_lainlain;

        // delivery_pickup
        $this->delivery_pickup = new DbField('npd_terms', 'npd_terms', 'x_delivery_pickup', 'delivery_pickup', '`delivery_pickup`', '`delivery_pickup`', 200, 255, -1, false, '`delivery_pickup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_pickup->Sortable = true; // Allow sort
        $this->delivery_pickup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_pickup->Param, "CustomMsg");
        $this->Fields['delivery_pickup'] = &$this->delivery_pickup;

        // delivery_singlepoint
        $this->delivery_singlepoint = new DbField('npd_terms', 'npd_terms', 'x_delivery_singlepoint', 'delivery_singlepoint', '`delivery_singlepoint`', '`delivery_singlepoint`', 200, 255, -1, false, '`delivery_singlepoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_singlepoint->Sortable = true; // Allow sort
        $this->delivery_singlepoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_singlepoint->Param, "CustomMsg");
        $this->Fields['delivery_singlepoint'] = &$this->delivery_singlepoint;

        // delivery_multipoint
        $this->delivery_multipoint = new DbField('npd_terms', 'npd_terms', 'x_delivery_multipoint', 'delivery_multipoint', '`delivery_multipoint`', '`delivery_multipoint`', 200, 255, -1, false, '`delivery_multipoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_multipoint->Sortable = true; // Allow sort
        $this->delivery_multipoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_multipoint->Param, "CustomMsg");
        $this->Fields['delivery_multipoint'] = &$this->delivery_multipoint;

        // delivery_jumlahpoint
        $this->delivery_jumlahpoint = new DbField('npd_terms', 'npd_terms', 'x_delivery_jumlahpoint', 'delivery_jumlahpoint', '`delivery_jumlahpoint`', '`delivery_jumlahpoint`', 200, 255, -1, false, '`delivery_jumlahpoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_jumlahpoint->Sortable = true; // Allow sort
        $this->delivery_jumlahpoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_jumlahpoint->Param, "CustomMsg");
        $this->Fields['delivery_jumlahpoint'] = &$this->delivery_jumlahpoint;

        // delivery_termslain
        $this->delivery_termslain = new DbField('npd_terms', 'npd_terms', 'x_delivery_termslain', 'delivery_termslain', '`delivery_termslain`', '`delivery_termslain`', 200, 255, -1, false, '`delivery_termslain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->delivery_termslain->Sortable = true; // Allow sort
        $this->delivery_termslain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->delivery_termslain->Param, "CustomMsg");
        $this->Fields['delivery_termslain'] = &$this->delivery_termslain;

        // catatan_khusus
        $this->catatan_khusus = new DbField('npd_terms', 'npd_terms', 'x_catatan_khusus', 'catatan_khusus', '`catatan_khusus`', '`catatan_khusus`', 201, 65535, -1, false, '`catatan_khusus`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->catatan_khusus->Sortable = true; // Allow sort
        $this->catatan_khusus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->catatan_khusus->Param, "CustomMsg");
        $this->Fields['catatan_khusus'] = &$this->catatan_khusus;

        // dibuatdi
        $this->dibuatdi = new DbField('npd_terms', 'npd_terms', 'x_dibuatdi', 'dibuatdi', '`dibuatdi`', '`dibuatdi`', 200, 255, -1, false, '`dibuatdi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->dibuatdi->Sortable = true; // Allow sort
        $this->dibuatdi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dibuatdi->Param, "CustomMsg");
        $this->Fields['dibuatdi'] = &$this->dibuatdi;

        // created_at
        $this->created_at = new DbField('npd_terms', 'npd_terms', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;
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
        if ($this->getCurrentMasterTable() == "npd") {
            if ($this->idnpd->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->idnpd->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "npd") {
            if ($this->idnpd->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`idnpd`", $this->idnpd->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_npd()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_npd()
    {
        return "`idnpd`=@idnpd@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_terms`";
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
        $this->idnpd->DbValue = $row['idnpd'];
        $this->status->DbValue = $row['status'];
        $this->tglsubmit->DbValue = $row['tglsubmit'];
        $this->sifat_order->DbValue = $row['sifat_order'];
        $this->ukuran_utama->DbValue = $row['ukuran_utama'];
        $this->utama_harga_isi->DbValue = $row['utama_harga_isi'];
        $this->utama_harga_isi_order->DbValue = $row['utama_harga_isi_order'];
        $this->utama_harga_primer->DbValue = $row['utama_harga_primer'];
        $this->utama_harga_primer_order->DbValue = $row['utama_harga_primer_order'];
        $this->utama_harga_sekunder->DbValue = $row['utama_harga_sekunder'];
        $this->utama_harga_sekunder_order->DbValue = $row['utama_harga_sekunder_order'];
        $this->utama_harga_label->DbValue = $row['utama_harga_label'];
        $this->utama_harga_label_order->DbValue = $row['utama_harga_label_order'];
        $this->utama_harga_total->DbValue = $row['utama_harga_total'];
        $this->utama_harga_total_order->DbValue = $row['utama_harga_total_order'];
        $this->ukuran_lain->DbValue = $row['ukuran_lain'];
        $this->lain_harga_isi->DbValue = $row['lain_harga_isi'];
        $this->lain_harga_isi_order->DbValue = $row['lain_harga_isi_order'];
        $this->lain_harga_primer->DbValue = $row['lain_harga_primer'];
        $this->lain_harga_primer_order->DbValue = $row['lain_harga_primer_order'];
        $this->lain_harga_sekunder->DbValue = $row['lain_harga_sekunder'];
        $this->lain_harga_sekunder_order->DbValue = $row['lain_harga_sekunder_order'];
        $this->lain_harga_label->DbValue = $row['lain_harga_label'];
        $this->lain_harga_label_order->DbValue = $row['lain_harga_label_order'];
        $this->lain_harga_total->DbValue = $row['lain_harga_total'];
        $this->lain_harga_total_order->DbValue = $row['lain_harga_total_order'];
        $this->isi_bahan_aktif->DbValue = $row['isi_bahan_aktif'];
        $this->isi_bahan_lain->DbValue = $row['isi_bahan_lain'];
        $this->isi_parfum->DbValue = $row['isi_parfum'];
        $this->isi_estetika->DbValue = $row['isi_estetika'];
        $this->kemasan_wadah->DbValue = $row['kemasan_wadah'];
        $this->kemasan_tutup->DbValue = $row['kemasan_tutup'];
        $this->kemasan_sekunder->DbValue = $row['kemasan_sekunder'];
        $this->label_desain->DbValue = $row['label_desain'];
        $this->label_cetak->DbValue = $row['label_cetak'];
        $this->label_lainlain->DbValue = $row['label_lainlain'];
        $this->delivery_pickup->DbValue = $row['delivery_pickup'];
        $this->delivery_singlepoint->DbValue = $row['delivery_singlepoint'];
        $this->delivery_multipoint->DbValue = $row['delivery_multipoint'];
        $this->delivery_jumlahpoint->DbValue = $row['delivery_jumlahpoint'];
        $this->delivery_termslain->DbValue = $row['delivery_termslain'];
        $this->catatan_khusus->DbValue = $row['catatan_khusus'];
        $this->dibuatdi->DbValue = $row['dibuatdi'];
        $this->created_at->DbValue = $row['created_at'];
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
        return $_SESSION[$name] ?? GetUrl("NpdTermsList");
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
        if ($pageName == "NpdTermsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdTermsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdTermsAdd") {
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
                return "NpdTermsView";
            case Config("API_ADD_ACTION"):
                return "NpdTermsAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdTermsEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdTermsDelete";
            case Config("API_LIST_ACTION"):
                return "NpdTermsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdTermsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdTermsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdTermsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdTermsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdTermsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdTermsEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdTermsAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdTermsDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "npd" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->idnpd->CurrentValue ?? $this->idnpd->getSessionValue());
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->status->setDbValue($row['status']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->sifat_order->setDbValue($row['sifat_order']);
        $this->ukuran_utama->setDbValue($row['ukuran_utama']);
        $this->utama_harga_isi->setDbValue($row['utama_harga_isi']);
        $this->utama_harga_isi_order->setDbValue($row['utama_harga_isi_order']);
        $this->utama_harga_primer->setDbValue($row['utama_harga_primer']);
        $this->utama_harga_primer_order->setDbValue($row['utama_harga_primer_order']);
        $this->utama_harga_sekunder->setDbValue($row['utama_harga_sekunder']);
        $this->utama_harga_sekunder_order->setDbValue($row['utama_harga_sekunder_order']);
        $this->utama_harga_label->setDbValue($row['utama_harga_label']);
        $this->utama_harga_label_order->setDbValue($row['utama_harga_label_order']);
        $this->utama_harga_total->setDbValue($row['utama_harga_total']);
        $this->utama_harga_total_order->setDbValue($row['utama_harga_total_order']);
        $this->ukuran_lain->setDbValue($row['ukuran_lain']);
        $this->lain_harga_isi->setDbValue($row['lain_harga_isi']);
        $this->lain_harga_isi_order->setDbValue($row['lain_harga_isi_order']);
        $this->lain_harga_primer->setDbValue($row['lain_harga_primer']);
        $this->lain_harga_primer_order->setDbValue($row['lain_harga_primer_order']);
        $this->lain_harga_sekunder->setDbValue($row['lain_harga_sekunder']);
        $this->lain_harga_sekunder_order->setDbValue($row['lain_harga_sekunder_order']);
        $this->lain_harga_label->setDbValue($row['lain_harga_label']);
        $this->lain_harga_label_order->setDbValue($row['lain_harga_label_order']);
        $this->lain_harga_total->setDbValue($row['lain_harga_total']);
        $this->lain_harga_total_order->setDbValue($row['lain_harga_total_order']);
        $this->isi_bahan_aktif->setDbValue($row['isi_bahan_aktif']);
        $this->isi_bahan_lain->setDbValue($row['isi_bahan_lain']);
        $this->isi_parfum->setDbValue($row['isi_parfum']);
        $this->isi_estetika->setDbValue($row['isi_estetika']);
        $this->kemasan_wadah->setDbValue($row['kemasan_wadah']);
        $this->kemasan_tutup->setDbValue($row['kemasan_tutup']);
        $this->kemasan_sekunder->setDbValue($row['kemasan_sekunder']);
        $this->label_desain->setDbValue($row['label_desain']);
        $this->label_cetak->setDbValue($row['label_cetak']);
        $this->label_lainlain->setDbValue($row['label_lainlain']);
        $this->delivery_pickup->setDbValue($row['delivery_pickup']);
        $this->delivery_singlepoint->setDbValue($row['delivery_singlepoint']);
        $this->delivery_multipoint->setDbValue($row['delivery_multipoint']);
        $this->delivery_jumlahpoint->setDbValue($row['delivery_jumlahpoint']);
        $this->delivery_termslain->setDbValue($row['delivery_termslain']);
        $this->catatan_khusus->setDbValue($row['catatan_khusus']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // idnpd

        // status

        // tglsubmit

        // sifat_order

        // ukuran_utama

        // utama_harga_isi

        // utama_harga_isi_order

        // utama_harga_primer

        // utama_harga_primer_order

        // utama_harga_sekunder

        // utama_harga_sekunder_order

        // utama_harga_label

        // utama_harga_label_order

        // utama_harga_total

        // utama_harga_total_order

        // ukuran_lain

        // lain_harga_isi

        // lain_harga_isi_order

        // lain_harga_primer

        // lain_harga_primer_order

        // lain_harga_sekunder

        // lain_harga_sekunder_order

        // lain_harga_label

        // lain_harga_label_order

        // lain_harga_total

        // lain_harga_total_order

        // isi_bahan_aktif

        // isi_bahan_lain

        // isi_parfum

        // isi_estetika

        // kemasan_wadah

        // kemasan_tutup

        // kemasan_sekunder

        // label_desain

        // label_cetak

        // label_lainlain

        // delivery_pickup

        // delivery_singlepoint

        // delivery_multipoint

        // delivery_jumlahpoint

        // delivery_termslain

        // catatan_khusus

        // dibuatdi

        // created_at

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idnpd
        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
        $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
        $this->idnpd->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

        // tglsubmit
        $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
        $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
        $this->tglsubmit->ViewCustomAttributes = "";

        // sifat_order
        if (ConvertToBool($this->sifat_order->CurrentValue)) {
            $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(1) != "" ? $this->sifat_order->tagCaption(1) : "Yes";
        } else {
            $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(2) != "" ? $this->sifat_order->tagCaption(2) : "No";
        }
        $this->sifat_order->ViewCustomAttributes = "";

        // ukuran_utama
        $this->ukuran_utama->ViewValue = $this->ukuran_utama->CurrentValue;
        $this->ukuran_utama->ViewCustomAttributes = "";

        // utama_harga_isi
        $this->utama_harga_isi->ViewValue = $this->utama_harga_isi->CurrentValue;
        $this->utama_harga_isi->ViewValue = FormatNumber($this->utama_harga_isi->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_isi->ViewCustomAttributes = "";

        // utama_harga_isi_order
        $this->utama_harga_isi_order->ViewValue = $this->utama_harga_isi_order->CurrentValue;
        $this->utama_harga_isi_order->ViewValue = FormatNumber($this->utama_harga_isi_order->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_isi_order->ViewCustomAttributes = "";

        // utama_harga_primer
        $this->utama_harga_primer->ViewValue = $this->utama_harga_primer->CurrentValue;
        $this->utama_harga_primer->ViewValue = FormatNumber($this->utama_harga_primer->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_primer->ViewCustomAttributes = "";

        // utama_harga_primer_order
        $this->utama_harga_primer_order->ViewValue = $this->utama_harga_primer_order->CurrentValue;
        $this->utama_harga_primer_order->ViewValue = FormatNumber($this->utama_harga_primer_order->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_primer_order->ViewCustomAttributes = "";

        // utama_harga_sekunder
        $this->utama_harga_sekunder->ViewValue = $this->utama_harga_sekunder->CurrentValue;
        $this->utama_harga_sekunder->ViewValue = FormatNumber($this->utama_harga_sekunder->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_sekunder->ViewCustomAttributes = "";

        // utama_harga_sekunder_order
        $this->utama_harga_sekunder_order->ViewValue = $this->utama_harga_sekunder_order->CurrentValue;
        $this->utama_harga_sekunder_order->ViewValue = FormatNumber($this->utama_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_sekunder_order->ViewCustomAttributes = "";

        // utama_harga_label
        $this->utama_harga_label->ViewValue = $this->utama_harga_label->CurrentValue;
        $this->utama_harga_label->ViewValue = FormatNumber($this->utama_harga_label->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_label->ViewCustomAttributes = "";

        // utama_harga_label_order
        $this->utama_harga_label_order->ViewValue = $this->utama_harga_label_order->CurrentValue;
        $this->utama_harga_label_order->ViewValue = FormatNumber($this->utama_harga_label_order->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_label_order->ViewCustomAttributes = "";

        // utama_harga_total
        $this->utama_harga_total->ViewValue = $this->utama_harga_total->CurrentValue;
        $this->utama_harga_total->ViewValue = FormatNumber($this->utama_harga_total->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_total->ViewCustomAttributes = "";

        // utama_harga_total_order
        $this->utama_harga_total_order->ViewValue = $this->utama_harga_total_order->CurrentValue;
        $this->utama_harga_total_order->ViewValue = FormatNumber($this->utama_harga_total_order->ViewValue, 0, -2, -2, -2);
        $this->utama_harga_total_order->ViewCustomAttributes = "";

        // ukuran_lain
        $this->ukuran_lain->ViewValue = $this->ukuran_lain->CurrentValue;
        $this->ukuran_lain->ViewCustomAttributes = "";

        // lain_harga_isi
        $this->lain_harga_isi->ViewValue = $this->lain_harga_isi->CurrentValue;
        $this->lain_harga_isi->ViewValue = FormatNumber($this->lain_harga_isi->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_isi->ViewCustomAttributes = "";

        // lain_harga_isi_order
        $this->lain_harga_isi_order->ViewValue = $this->lain_harga_isi_order->CurrentValue;
        $this->lain_harga_isi_order->ViewValue = FormatNumber($this->lain_harga_isi_order->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_isi_order->ViewCustomAttributes = "";

        // lain_harga_primer
        $this->lain_harga_primer->ViewValue = $this->lain_harga_primer->CurrentValue;
        $this->lain_harga_primer->ViewValue = FormatNumber($this->lain_harga_primer->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_primer->ViewCustomAttributes = "";

        // lain_harga_primer_order
        $this->lain_harga_primer_order->ViewValue = $this->lain_harga_primer_order->CurrentValue;
        $this->lain_harga_primer_order->ViewValue = FormatNumber($this->lain_harga_primer_order->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_primer_order->ViewCustomAttributes = "";

        // lain_harga_sekunder
        $this->lain_harga_sekunder->ViewValue = $this->lain_harga_sekunder->CurrentValue;
        $this->lain_harga_sekunder->ViewValue = FormatNumber($this->lain_harga_sekunder->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_sekunder->ViewCustomAttributes = "";

        // lain_harga_sekunder_order
        $this->lain_harga_sekunder_order->ViewValue = $this->lain_harga_sekunder_order->CurrentValue;
        $this->lain_harga_sekunder_order->ViewValue = FormatNumber($this->lain_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_sekunder_order->ViewCustomAttributes = "";

        // lain_harga_label
        $this->lain_harga_label->ViewValue = $this->lain_harga_label->CurrentValue;
        $this->lain_harga_label->ViewValue = FormatNumber($this->lain_harga_label->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_label->ViewCustomAttributes = "";

        // lain_harga_label_order
        $this->lain_harga_label_order->ViewValue = $this->lain_harga_label_order->CurrentValue;
        $this->lain_harga_label_order->ViewValue = FormatNumber($this->lain_harga_label_order->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_label_order->ViewCustomAttributes = "";

        // lain_harga_total
        $this->lain_harga_total->ViewValue = $this->lain_harga_total->CurrentValue;
        $this->lain_harga_total->ViewValue = FormatNumber($this->lain_harga_total->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_total->ViewCustomAttributes = "";

        // lain_harga_total_order
        $this->lain_harga_total_order->ViewValue = $this->lain_harga_total_order->CurrentValue;
        $this->lain_harga_total_order->ViewValue = FormatNumber($this->lain_harga_total_order->ViewValue, 0, -2, -2, -2);
        $this->lain_harga_total_order->ViewCustomAttributes = "";

        // isi_bahan_aktif
        $this->isi_bahan_aktif->ViewValue = $this->isi_bahan_aktif->CurrentValue;
        $this->isi_bahan_aktif->ViewCustomAttributes = "";

        // isi_bahan_lain
        $this->isi_bahan_lain->ViewValue = $this->isi_bahan_lain->CurrentValue;
        $this->isi_bahan_lain->ViewCustomAttributes = "";

        // isi_parfum
        $this->isi_parfum->ViewValue = $this->isi_parfum->CurrentValue;
        $this->isi_parfum->ViewCustomAttributes = "";

        // isi_estetika
        $this->isi_estetika->ViewValue = $this->isi_estetika->CurrentValue;
        $this->isi_estetika->ViewCustomAttributes = "";

        // kemasan_wadah
        $this->kemasan_wadah->ViewValue = $this->kemasan_wadah->CurrentValue;
        $this->kemasan_wadah->ViewValue = FormatNumber($this->kemasan_wadah->ViewValue, 0, -2, -2, -2);
        $this->kemasan_wadah->ViewCustomAttributes = "";

        // kemasan_tutup
        $this->kemasan_tutup->ViewValue = $this->kemasan_tutup->CurrentValue;
        $this->kemasan_tutup->ViewValue = FormatNumber($this->kemasan_tutup->ViewValue, 0, -2, -2, -2);
        $this->kemasan_tutup->ViewCustomAttributes = "";

        // kemasan_sekunder
        $this->kemasan_sekunder->ViewValue = $this->kemasan_sekunder->CurrentValue;
        $this->kemasan_sekunder->ViewCustomAttributes = "";

        // label_desain
        $this->label_desain->ViewValue = $this->label_desain->CurrentValue;
        $this->label_desain->ViewCustomAttributes = "";

        // label_cetak
        $this->label_cetak->ViewValue = $this->label_cetak->CurrentValue;
        $this->label_cetak->ViewCustomAttributes = "";

        // label_lainlain
        $this->label_lainlain->ViewValue = $this->label_lainlain->CurrentValue;
        $this->label_lainlain->ViewCustomAttributes = "";

        // delivery_pickup
        $this->delivery_pickup->ViewValue = $this->delivery_pickup->CurrentValue;
        $this->delivery_pickup->ViewCustomAttributes = "";

        // delivery_singlepoint
        $this->delivery_singlepoint->ViewValue = $this->delivery_singlepoint->CurrentValue;
        $this->delivery_singlepoint->ViewCustomAttributes = "";

        // delivery_multipoint
        $this->delivery_multipoint->ViewValue = $this->delivery_multipoint->CurrentValue;
        $this->delivery_multipoint->ViewCustomAttributes = "";

        // delivery_jumlahpoint
        $this->delivery_jumlahpoint->ViewValue = $this->delivery_jumlahpoint->CurrentValue;
        $this->delivery_jumlahpoint->ViewCustomAttributes = "";

        // delivery_termslain
        $this->delivery_termslain->ViewValue = $this->delivery_termslain->CurrentValue;
        $this->delivery_termslain->ViewCustomAttributes = "";

        // catatan_khusus
        $this->catatan_khusus->ViewValue = $this->catatan_khusus->CurrentValue;
        $this->catatan_khusus->ViewCustomAttributes = "";

        // dibuatdi
        $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
        $this->dibuatdi->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idnpd
        $this->idnpd->LinkCustomAttributes = "";
        $this->idnpd->HrefValue = "";
        $this->idnpd->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // tglsubmit
        $this->tglsubmit->LinkCustomAttributes = "";
        $this->tglsubmit->HrefValue = "";
        $this->tglsubmit->TooltipValue = "";

        // sifat_order
        $this->sifat_order->LinkCustomAttributes = "";
        $this->sifat_order->HrefValue = "";
        $this->sifat_order->TooltipValue = "";

        // ukuran_utama
        $this->ukuran_utama->LinkCustomAttributes = "";
        $this->ukuran_utama->HrefValue = "";
        $this->ukuran_utama->TooltipValue = "";

        // utama_harga_isi
        $this->utama_harga_isi->LinkCustomAttributes = "";
        $this->utama_harga_isi->HrefValue = "";
        $this->utama_harga_isi->TooltipValue = "";

        // utama_harga_isi_order
        $this->utama_harga_isi_order->LinkCustomAttributes = "";
        $this->utama_harga_isi_order->HrefValue = "";
        $this->utama_harga_isi_order->TooltipValue = "";

        // utama_harga_primer
        $this->utama_harga_primer->LinkCustomAttributes = "";
        $this->utama_harga_primer->HrefValue = "";
        $this->utama_harga_primer->TooltipValue = "";

        // utama_harga_primer_order
        $this->utama_harga_primer_order->LinkCustomAttributes = "";
        $this->utama_harga_primer_order->HrefValue = "";
        $this->utama_harga_primer_order->TooltipValue = "";

        // utama_harga_sekunder
        $this->utama_harga_sekunder->LinkCustomAttributes = "";
        $this->utama_harga_sekunder->HrefValue = "";
        $this->utama_harga_sekunder->TooltipValue = "";

        // utama_harga_sekunder_order
        $this->utama_harga_sekunder_order->LinkCustomAttributes = "";
        $this->utama_harga_sekunder_order->HrefValue = "";
        $this->utama_harga_sekunder_order->TooltipValue = "";

        // utama_harga_label
        $this->utama_harga_label->LinkCustomAttributes = "";
        $this->utama_harga_label->HrefValue = "";
        $this->utama_harga_label->TooltipValue = "";

        // utama_harga_label_order
        $this->utama_harga_label_order->LinkCustomAttributes = "";
        $this->utama_harga_label_order->HrefValue = "";
        $this->utama_harga_label_order->TooltipValue = "";

        // utama_harga_total
        $this->utama_harga_total->LinkCustomAttributes = "";
        $this->utama_harga_total->HrefValue = "";
        $this->utama_harga_total->TooltipValue = "";

        // utama_harga_total_order
        $this->utama_harga_total_order->LinkCustomAttributes = "";
        $this->utama_harga_total_order->HrefValue = "";
        $this->utama_harga_total_order->TooltipValue = "";

        // ukuran_lain
        $this->ukuran_lain->LinkCustomAttributes = "";
        $this->ukuran_lain->HrefValue = "";
        $this->ukuran_lain->TooltipValue = "";

        // lain_harga_isi
        $this->lain_harga_isi->LinkCustomAttributes = "";
        $this->lain_harga_isi->HrefValue = "";
        $this->lain_harga_isi->TooltipValue = "";

        // lain_harga_isi_order
        $this->lain_harga_isi_order->LinkCustomAttributes = "";
        $this->lain_harga_isi_order->HrefValue = "";
        $this->lain_harga_isi_order->TooltipValue = "";

        // lain_harga_primer
        $this->lain_harga_primer->LinkCustomAttributes = "";
        $this->lain_harga_primer->HrefValue = "";
        $this->lain_harga_primer->TooltipValue = "";

        // lain_harga_primer_order
        $this->lain_harga_primer_order->LinkCustomAttributes = "";
        $this->lain_harga_primer_order->HrefValue = "";
        $this->lain_harga_primer_order->TooltipValue = "";

        // lain_harga_sekunder
        $this->lain_harga_sekunder->LinkCustomAttributes = "";
        $this->lain_harga_sekunder->HrefValue = "";
        $this->lain_harga_sekunder->TooltipValue = "";

        // lain_harga_sekunder_order
        $this->lain_harga_sekunder_order->LinkCustomAttributes = "";
        $this->lain_harga_sekunder_order->HrefValue = "";
        $this->lain_harga_sekunder_order->TooltipValue = "";

        // lain_harga_label
        $this->lain_harga_label->LinkCustomAttributes = "";
        $this->lain_harga_label->HrefValue = "";
        $this->lain_harga_label->TooltipValue = "";

        // lain_harga_label_order
        $this->lain_harga_label_order->LinkCustomAttributes = "";
        $this->lain_harga_label_order->HrefValue = "";
        $this->lain_harga_label_order->TooltipValue = "";

        // lain_harga_total
        $this->lain_harga_total->LinkCustomAttributes = "";
        $this->lain_harga_total->HrefValue = "";
        $this->lain_harga_total->TooltipValue = "";

        // lain_harga_total_order
        $this->lain_harga_total_order->LinkCustomAttributes = "";
        $this->lain_harga_total_order->HrefValue = "";
        $this->lain_harga_total_order->TooltipValue = "";

        // isi_bahan_aktif
        $this->isi_bahan_aktif->LinkCustomAttributes = "";
        $this->isi_bahan_aktif->HrefValue = "";
        $this->isi_bahan_aktif->TooltipValue = "";

        // isi_bahan_lain
        $this->isi_bahan_lain->LinkCustomAttributes = "";
        $this->isi_bahan_lain->HrefValue = "";
        $this->isi_bahan_lain->TooltipValue = "";

        // isi_parfum
        $this->isi_parfum->LinkCustomAttributes = "";
        $this->isi_parfum->HrefValue = "";
        $this->isi_parfum->TooltipValue = "";

        // isi_estetika
        $this->isi_estetika->LinkCustomAttributes = "";
        $this->isi_estetika->HrefValue = "";
        $this->isi_estetika->TooltipValue = "";

        // kemasan_wadah
        $this->kemasan_wadah->LinkCustomAttributes = "";
        $this->kemasan_wadah->HrefValue = "";
        $this->kemasan_wadah->TooltipValue = "";

        // kemasan_tutup
        $this->kemasan_tutup->LinkCustomAttributes = "";
        $this->kemasan_tutup->HrefValue = "";
        $this->kemasan_tutup->TooltipValue = "";

        // kemasan_sekunder
        $this->kemasan_sekunder->LinkCustomAttributes = "";
        $this->kemasan_sekunder->HrefValue = "";
        $this->kemasan_sekunder->TooltipValue = "";

        // label_desain
        $this->label_desain->LinkCustomAttributes = "";
        $this->label_desain->HrefValue = "";
        $this->label_desain->TooltipValue = "";

        // label_cetak
        $this->label_cetak->LinkCustomAttributes = "";
        $this->label_cetak->HrefValue = "";
        $this->label_cetak->TooltipValue = "";

        // label_lainlain
        $this->label_lainlain->LinkCustomAttributes = "";
        $this->label_lainlain->HrefValue = "";
        $this->label_lainlain->TooltipValue = "";

        // delivery_pickup
        $this->delivery_pickup->LinkCustomAttributes = "";
        $this->delivery_pickup->HrefValue = "";
        $this->delivery_pickup->TooltipValue = "";

        // delivery_singlepoint
        $this->delivery_singlepoint->LinkCustomAttributes = "";
        $this->delivery_singlepoint->HrefValue = "";
        $this->delivery_singlepoint->TooltipValue = "";

        // delivery_multipoint
        $this->delivery_multipoint->LinkCustomAttributes = "";
        $this->delivery_multipoint->HrefValue = "";
        $this->delivery_multipoint->TooltipValue = "";

        // delivery_jumlahpoint
        $this->delivery_jumlahpoint->LinkCustomAttributes = "";
        $this->delivery_jumlahpoint->HrefValue = "";
        $this->delivery_jumlahpoint->TooltipValue = "";

        // delivery_termslain
        $this->delivery_termslain->LinkCustomAttributes = "";
        $this->delivery_termslain->HrefValue = "";
        $this->delivery_termslain->TooltipValue = "";

        // catatan_khusus
        $this->catatan_khusus->LinkCustomAttributes = "";
        $this->catatan_khusus->HrefValue = "";
        $this->catatan_khusus->TooltipValue = "";

        // dibuatdi
        $this->dibuatdi->LinkCustomAttributes = "";
        $this->dibuatdi->HrefValue = "";
        $this->dibuatdi->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

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

        // idnpd
        $this->idnpd->EditAttrs["class"] = "form-control";
        $this->idnpd->EditCustomAttributes = "";
        if ($this->idnpd->getSessionValue() != "") {
            $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";
        } else {
            $this->idnpd->EditValue = $this->idnpd->CurrentValue;
            $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
        }

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // tglsubmit
        $this->tglsubmit->EditAttrs["class"] = "form-control";
        $this->tglsubmit->EditCustomAttributes = "";
        $this->tglsubmit->EditValue = FormatDateTime($this->tglsubmit->CurrentValue, 8);
        $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

        // sifat_order
        $this->sifat_order->EditCustomAttributes = "";
        $this->sifat_order->EditValue = $this->sifat_order->options(false);
        $this->sifat_order->PlaceHolder = RemoveHtml($this->sifat_order->caption());

        // ukuran_utama
        $this->ukuran_utama->EditAttrs["class"] = "form-control";
        $this->ukuran_utama->EditCustomAttributes = "";
        if (!$this->ukuran_utama->Raw) {
            $this->ukuran_utama->CurrentValue = HtmlDecode($this->ukuran_utama->CurrentValue);
        }
        $this->ukuran_utama->EditValue = $this->ukuran_utama->CurrentValue;
        $this->ukuran_utama->PlaceHolder = RemoveHtml($this->ukuran_utama->caption());

        // utama_harga_isi
        $this->utama_harga_isi->EditAttrs["class"] = "form-control";
        $this->utama_harga_isi->EditCustomAttributes = "";
        $this->utama_harga_isi->EditValue = $this->utama_harga_isi->CurrentValue;
        $this->utama_harga_isi->PlaceHolder = RemoveHtml($this->utama_harga_isi->caption());

        // utama_harga_isi_order
        $this->utama_harga_isi_order->EditAttrs["class"] = "form-control";
        $this->utama_harga_isi_order->EditCustomAttributes = "";
        $this->utama_harga_isi_order->EditValue = $this->utama_harga_isi_order->CurrentValue;
        $this->utama_harga_isi_order->PlaceHolder = RemoveHtml($this->utama_harga_isi_order->caption());

        // utama_harga_primer
        $this->utama_harga_primer->EditAttrs["class"] = "form-control";
        $this->utama_harga_primer->EditCustomAttributes = "";
        $this->utama_harga_primer->EditValue = $this->utama_harga_primer->CurrentValue;
        $this->utama_harga_primer->PlaceHolder = RemoveHtml($this->utama_harga_primer->caption());

        // utama_harga_primer_order
        $this->utama_harga_primer_order->EditAttrs["class"] = "form-control";
        $this->utama_harga_primer_order->EditCustomAttributes = "";
        $this->utama_harga_primer_order->EditValue = $this->utama_harga_primer_order->CurrentValue;
        $this->utama_harga_primer_order->PlaceHolder = RemoveHtml($this->utama_harga_primer_order->caption());

        // utama_harga_sekunder
        $this->utama_harga_sekunder->EditAttrs["class"] = "form-control";
        $this->utama_harga_sekunder->EditCustomAttributes = "";
        $this->utama_harga_sekunder->EditValue = $this->utama_harga_sekunder->CurrentValue;
        $this->utama_harga_sekunder->PlaceHolder = RemoveHtml($this->utama_harga_sekunder->caption());

        // utama_harga_sekunder_order
        $this->utama_harga_sekunder_order->EditAttrs["class"] = "form-control";
        $this->utama_harga_sekunder_order->EditCustomAttributes = "";
        $this->utama_harga_sekunder_order->EditValue = $this->utama_harga_sekunder_order->CurrentValue;
        $this->utama_harga_sekunder_order->PlaceHolder = RemoveHtml($this->utama_harga_sekunder_order->caption());

        // utama_harga_label
        $this->utama_harga_label->EditAttrs["class"] = "form-control";
        $this->utama_harga_label->EditCustomAttributes = "";
        $this->utama_harga_label->EditValue = $this->utama_harga_label->CurrentValue;
        $this->utama_harga_label->PlaceHolder = RemoveHtml($this->utama_harga_label->caption());

        // utama_harga_label_order
        $this->utama_harga_label_order->EditAttrs["class"] = "form-control";
        $this->utama_harga_label_order->EditCustomAttributes = "";
        $this->utama_harga_label_order->EditValue = $this->utama_harga_label_order->CurrentValue;
        $this->utama_harga_label_order->PlaceHolder = RemoveHtml($this->utama_harga_label_order->caption());

        // utama_harga_total
        $this->utama_harga_total->EditAttrs["class"] = "form-control";
        $this->utama_harga_total->EditCustomAttributes = "";
        $this->utama_harga_total->EditValue = $this->utama_harga_total->CurrentValue;
        $this->utama_harga_total->PlaceHolder = RemoveHtml($this->utama_harga_total->caption());

        // utama_harga_total_order
        $this->utama_harga_total_order->EditAttrs["class"] = "form-control";
        $this->utama_harga_total_order->EditCustomAttributes = "";
        $this->utama_harga_total_order->EditValue = $this->utama_harga_total_order->CurrentValue;
        $this->utama_harga_total_order->PlaceHolder = RemoveHtml($this->utama_harga_total_order->caption());

        // ukuran_lain
        $this->ukuran_lain->EditAttrs["class"] = "form-control";
        $this->ukuran_lain->EditCustomAttributes = "";
        if (!$this->ukuran_lain->Raw) {
            $this->ukuran_lain->CurrentValue = HtmlDecode($this->ukuran_lain->CurrentValue);
        }
        $this->ukuran_lain->EditValue = $this->ukuran_lain->CurrentValue;
        $this->ukuran_lain->PlaceHolder = RemoveHtml($this->ukuran_lain->caption());

        // lain_harga_isi
        $this->lain_harga_isi->EditAttrs["class"] = "form-control";
        $this->lain_harga_isi->EditCustomAttributes = "";
        $this->lain_harga_isi->EditValue = $this->lain_harga_isi->CurrentValue;
        $this->lain_harga_isi->PlaceHolder = RemoveHtml($this->lain_harga_isi->caption());

        // lain_harga_isi_order
        $this->lain_harga_isi_order->EditAttrs["class"] = "form-control";
        $this->lain_harga_isi_order->EditCustomAttributes = "";
        $this->lain_harga_isi_order->EditValue = $this->lain_harga_isi_order->CurrentValue;
        $this->lain_harga_isi_order->PlaceHolder = RemoveHtml($this->lain_harga_isi_order->caption());

        // lain_harga_primer
        $this->lain_harga_primer->EditAttrs["class"] = "form-control";
        $this->lain_harga_primer->EditCustomAttributes = "";
        $this->lain_harga_primer->EditValue = $this->lain_harga_primer->CurrentValue;
        $this->lain_harga_primer->PlaceHolder = RemoveHtml($this->lain_harga_primer->caption());

        // lain_harga_primer_order
        $this->lain_harga_primer_order->EditAttrs["class"] = "form-control";
        $this->lain_harga_primer_order->EditCustomAttributes = "";
        $this->lain_harga_primer_order->EditValue = $this->lain_harga_primer_order->CurrentValue;
        $this->lain_harga_primer_order->PlaceHolder = RemoveHtml($this->lain_harga_primer_order->caption());

        // lain_harga_sekunder
        $this->lain_harga_sekunder->EditAttrs["class"] = "form-control";
        $this->lain_harga_sekunder->EditCustomAttributes = "";
        $this->lain_harga_sekunder->EditValue = $this->lain_harga_sekunder->CurrentValue;
        $this->lain_harga_sekunder->PlaceHolder = RemoveHtml($this->lain_harga_sekunder->caption());

        // lain_harga_sekunder_order
        $this->lain_harga_sekunder_order->EditAttrs["class"] = "form-control";
        $this->lain_harga_sekunder_order->EditCustomAttributes = "";
        $this->lain_harga_sekunder_order->EditValue = $this->lain_harga_sekunder_order->CurrentValue;
        $this->lain_harga_sekunder_order->PlaceHolder = RemoveHtml($this->lain_harga_sekunder_order->caption());

        // lain_harga_label
        $this->lain_harga_label->EditAttrs["class"] = "form-control";
        $this->lain_harga_label->EditCustomAttributes = "";
        $this->lain_harga_label->EditValue = $this->lain_harga_label->CurrentValue;
        $this->lain_harga_label->PlaceHolder = RemoveHtml($this->lain_harga_label->caption());

        // lain_harga_label_order
        $this->lain_harga_label_order->EditAttrs["class"] = "form-control";
        $this->lain_harga_label_order->EditCustomAttributes = "";
        $this->lain_harga_label_order->EditValue = $this->lain_harga_label_order->CurrentValue;
        $this->lain_harga_label_order->PlaceHolder = RemoveHtml($this->lain_harga_label_order->caption());

        // lain_harga_total
        $this->lain_harga_total->EditAttrs["class"] = "form-control";
        $this->lain_harga_total->EditCustomAttributes = "";
        $this->lain_harga_total->EditValue = $this->lain_harga_total->CurrentValue;
        $this->lain_harga_total->PlaceHolder = RemoveHtml($this->lain_harga_total->caption());

        // lain_harga_total_order
        $this->lain_harga_total_order->EditAttrs["class"] = "form-control";
        $this->lain_harga_total_order->EditCustomAttributes = "";
        $this->lain_harga_total_order->EditValue = $this->lain_harga_total_order->CurrentValue;
        $this->lain_harga_total_order->PlaceHolder = RemoveHtml($this->lain_harga_total_order->caption());

        // isi_bahan_aktif
        $this->isi_bahan_aktif->EditAttrs["class"] = "form-control";
        $this->isi_bahan_aktif->EditCustomAttributes = "";
        if (!$this->isi_bahan_aktif->Raw) {
            $this->isi_bahan_aktif->CurrentValue = HtmlDecode($this->isi_bahan_aktif->CurrentValue);
        }
        $this->isi_bahan_aktif->EditValue = $this->isi_bahan_aktif->CurrentValue;
        $this->isi_bahan_aktif->PlaceHolder = RemoveHtml($this->isi_bahan_aktif->caption());

        // isi_bahan_lain
        $this->isi_bahan_lain->EditAttrs["class"] = "form-control";
        $this->isi_bahan_lain->EditCustomAttributes = "";
        if (!$this->isi_bahan_lain->Raw) {
            $this->isi_bahan_lain->CurrentValue = HtmlDecode($this->isi_bahan_lain->CurrentValue);
        }
        $this->isi_bahan_lain->EditValue = $this->isi_bahan_lain->CurrentValue;
        $this->isi_bahan_lain->PlaceHolder = RemoveHtml($this->isi_bahan_lain->caption());

        // isi_parfum
        $this->isi_parfum->EditAttrs["class"] = "form-control";
        $this->isi_parfum->EditCustomAttributes = "";
        if (!$this->isi_parfum->Raw) {
            $this->isi_parfum->CurrentValue = HtmlDecode($this->isi_parfum->CurrentValue);
        }
        $this->isi_parfum->EditValue = $this->isi_parfum->CurrentValue;
        $this->isi_parfum->PlaceHolder = RemoveHtml($this->isi_parfum->caption());

        // isi_estetika
        $this->isi_estetika->EditAttrs["class"] = "form-control";
        $this->isi_estetika->EditCustomAttributes = "";
        if (!$this->isi_estetika->Raw) {
            $this->isi_estetika->CurrentValue = HtmlDecode($this->isi_estetika->CurrentValue);
        }
        $this->isi_estetika->EditValue = $this->isi_estetika->CurrentValue;
        $this->isi_estetika->PlaceHolder = RemoveHtml($this->isi_estetika->caption());

        // kemasan_wadah
        $this->kemasan_wadah->EditAttrs["class"] = "form-control";
        $this->kemasan_wadah->EditCustomAttributes = "";
        $this->kemasan_wadah->EditValue = $this->kemasan_wadah->CurrentValue;
        $this->kemasan_wadah->PlaceHolder = RemoveHtml($this->kemasan_wadah->caption());

        // kemasan_tutup
        $this->kemasan_tutup->EditAttrs["class"] = "form-control";
        $this->kemasan_tutup->EditCustomAttributes = "";
        $this->kemasan_tutup->EditValue = $this->kemasan_tutup->CurrentValue;
        $this->kemasan_tutup->PlaceHolder = RemoveHtml($this->kemasan_tutup->caption());

        // kemasan_sekunder
        $this->kemasan_sekunder->EditAttrs["class"] = "form-control";
        $this->kemasan_sekunder->EditCustomAttributes = "";
        if (!$this->kemasan_sekunder->Raw) {
            $this->kemasan_sekunder->CurrentValue = HtmlDecode($this->kemasan_sekunder->CurrentValue);
        }
        $this->kemasan_sekunder->EditValue = $this->kemasan_sekunder->CurrentValue;
        $this->kemasan_sekunder->PlaceHolder = RemoveHtml($this->kemasan_sekunder->caption());

        // label_desain
        $this->label_desain->EditAttrs["class"] = "form-control";
        $this->label_desain->EditCustomAttributes = "";
        if (!$this->label_desain->Raw) {
            $this->label_desain->CurrentValue = HtmlDecode($this->label_desain->CurrentValue);
        }
        $this->label_desain->EditValue = $this->label_desain->CurrentValue;
        $this->label_desain->PlaceHolder = RemoveHtml($this->label_desain->caption());

        // label_cetak
        $this->label_cetak->EditAttrs["class"] = "form-control";
        $this->label_cetak->EditCustomAttributes = "";
        if (!$this->label_cetak->Raw) {
            $this->label_cetak->CurrentValue = HtmlDecode($this->label_cetak->CurrentValue);
        }
        $this->label_cetak->EditValue = $this->label_cetak->CurrentValue;
        $this->label_cetak->PlaceHolder = RemoveHtml($this->label_cetak->caption());

        // label_lainlain
        $this->label_lainlain->EditAttrs["class"] = "form-control";
        $this->label_lainlain->EditCustomAttributes = "";
        if (!$this->label_lainlain->Raw) {
            $this->label_lainlain->CurrentValue = HtmlDecode($this->label_lainlain->CurrentValue);
        }
        $this->label_lainlain->EditValue = $this->label_lainlain->CurrentValue;
        $this->label_lainlain->PlaceHolder = RemoveHtml($this->label_lainlain->caption());

        // delivery_pickup
        $this->delivery_pickup->EditAttrs["class"] = "form-control";
        $this->delivery_pickup->EditCustomAttributes = "";
        if (!$this->delivery_pickup->Raw) {
            $this->delivery_pickup->CurrentValue = HtmlDecode($this->delivery_pickup->CurrentValue);
        }
        $this->delivery_pickup->EditValue = $this->delivery_pickup->CurrentValue;
        $this->delivery_pickup->PlaceHolder = RemoveHtml($this->delivery_pickup->caption());

        // delivery_singlepoint
        $this->delivery_singlepoint->EditAttrs["class"] = "form-control";
        $this->delivery_singlepoint->EditCustomAttributes = "";
        if (!$this->delivery_singlepoint->Raw) {
            $this->delivery_singlepoint->CurrentValue = HtmlDecode($this->delivery_singlepoint->CurrentValue);
        }
        $this->delivery_singlepoint->EditValue = $this->delivery_singlepoint->CurrentValue;
        $this->delivery_singlepoint->PlaceHolder = RemoveHtml($this->delivery_singlepoint->caption());

        // delivery_multipoint
        $this->delivery_multipoint->EditAttrs["class"] = "form-control";
        $this->delivery_multipoint->EditCustomAttributes = "";
        if (!$this->delivery_multipoint->Raw) {
            $this->delivery_multipoint->CurrentValue = HtmlDecode($this->delivery_multipoint->CurrentValue);
        }
        $this->delivery_multipoint->EditValue = $this->delivery_multipoint->CurrentValue;
        $this->delivery_multipoint->PlaceHolder = RemoveHtml($this->delivery_multipoint->caption());

        // delivery_jumlahpoint
        $this->delivery_jumlahpoint->EditAttrs["class"] = "form-control";
        $this->delivery_jumlahpoint->EditCustomAttributes = "";
        if (!$this->delivery_jumlahpoint->Raw) {
            $this->delivery_jumlahpoint->CurrentValue = HtmlDecode($this->delivery_jumlahpoint->CurrentValue);
        }
        $this->delivery_jumlahpoint->EditValue = $this->delivery_jumlahpoint->CurrentValue;
        $this->delivery_jumlahpoint->PlaceHolder = RemoveHtml($this->delivery_jumlahpoint->caption());

        // delivery_termslain
        $this->delivery_termslain->EditAttrs["class"] = "form-control";
        $this->delivery_termslain->EditCustomAttributes = "";
        if (!$this->delivery_termslain->Raw) {
            $this->delivery_termslain->CurrentValue = HtmlDecode($this->delivery_termslain->CurrentValue);
        }
        $this->delivery_termslain->EditValue = $this->delivery_termslain->CurrentValue;
        $this->delivery_termslain->PlaceHolder = RemoveHtml($this->delivery_termslain->caption());

        // catatan_khusus
        $this->catatan_khusus->EditAttrs["class"] = "form-control";
        $this->catatan_khusus->EditCustomAttributes = "";
        $this->catatan_khusus->EditValue = $this->catatan_khusus->CurrentValue;
        $this->catatan_khusus->PlaceHolder = RemoveHtml($this->catatan_khusus->caption());

        // dibuatdi
        $this->dibuatdi->EditAttrs["class"] = "form-control";
        $this->dibuatdi->EditCustomAttributes = "";
        if (!$this->dibuatdi->Raw) {
            $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
        }
        $this->dibuatdi->EditValue = $this->dibuatdi->CurrentValue;
        $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

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
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->sifat_order);
                    $doc->exportCaption($this->ukuran_utama);
                    $doc->exportCaption($this->utama_harga_isi);
                    $doc->exportCaption($this->utama_harga_isi_order);
                    $doc->exportCaption($this->utama_harga_primer);
                    $doc->exportCaption($this->utama_harga_primer_order);
                    $doc->exportCaption($this->utama_harga_sekunder);
                    $doc->exportCaption($this->utama_harga_sekunder_order);
                    $doc->exportCaption($this->utama_harga_label);
                    $doc->exportCaption($this->utama_harga_label_order);
                    $doc->exportCaption($this->utama_harga_total);
                    $doc->exportCaption($this->utama_harga_total_order);
                    $doc->exportCaption($this->ukuran_lain);
                    $doc->exportCaption($this->lain_harga_isi);
                    $doc->exportCaption($this->lain_harga_isi_order);
                    $doc->exportCaption($this->lain_harga_primer);
                    $doc->exportCaption($this->lain_harga_primer_order);
                    $doc->exportCaption($this->lain_harga_sekunder);
                    $doc->exportCaption($this->lain_harga_sekunder_order);
                    $doc->exportCaption($this->lain_harga_label);
                    $doc->exportCaption($this->lain_harga_label_order);
                    $doc->exportCaption($this->lain_harga_total);
                    $doc->exportCaption($this->lain_harga_total_order);
                    $doc->exportCaption($this->isi_bahan_aktif);
                    $doc->exportCaption($this->isi_bahan_lain);
                    $doc->exportCaption($this->isi_parfum);
                    $doc->exportCaption($this->isi_estetika);
                    $doc->exportCaption($this->kemasan_wadah);
                    $doc->exportCaption($this->kemasan_tutup);
                    $doc->exportCaption($this->kemasan_sekunder);
                    $doc->exportCaption($this->label_desain);
                    $doc->exportCaption($this->label_cetak);
                    $doc->exportCaption($this->label_lainlain);
                    $doc->exportCaption($this->delivery_pickup);
                    $doc->exportCaption($this->delivery_singlepoint);
                    $doc->exportCaption($this->delivery_multipoint);
                    $doc->exportCaption($this->delivery_jumlahpoint);
                    $doc->exportCaption($this->delivery_termslain);
                    $doc->exportCaption($this->catatan_khusus);
                    $doc->exportCaption($this->dibuatdi);
                    $doc->exportCaption($this->created_at);
                } else {
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->sifat_order);
                    $doc->exportCaption($this->ukuran_utama);
                    $doc->exportCaption($this->utama_harga_isi);
                    $doc->exportCaption($this->utama_harga_isi_order);
                    $doc->exportCaption($this->utama_harga_primer);
                    $doc->exportCaption($this->utama_harga_primer_order);
                    $doc->exportCaption($this->utama_harga_sekunder);
                    $doc->exportCaption($this->utama_harga_sekunder_order);
                    $doc->exportCaption($this->utama_harga_label);
                    $doc->exportCaption($this->utama_harga_label_order);
                    $doc->exportCaption($this->utama_harga_total);
                    $doc->exportCaption($this->utama_harga_total_order);
                    $doc->exportCaption($this->ukuran_lain);
                    $doc->exportCaption($this->lain_harga_isi);
                    $doc->exportCaption($this->lain_harga_isi_order);
                    $doc->exportCaption($this->lain_harga_primer);
                    $doc->exportCaption($this->lain_harga_primer_order);
                    $doc->exportCaption($this->lain_harga_sekunder);
                    $doc->exportCaption($this->lain_harga_sekunder_order);
                    $doc->exportCaption($this->lain_harga_label);
                    $doc->exportCaption($this->lain_harga_label_order);
                    $doc->exportCaption($this->lain_harga_total);
                    $doc->exportCaption($this->lain_harga_total_order);
                    $doc->exportCaption($this->isi_bahan_aktif);
                    $doc->exportCaption($this->isi_bahan_lain);
                    $doc->exportCaption($this->isi_parfum);
                    $doc->exportCaption($this->isi_estetika);
                    $doc->exportCaption($this->kemasan_wadah);
                    $doc->exportCaption($this->kemasan_tutup);
                    $doc->exportCaption($this->kemasan_sekunder);
                    $doc->exportCaption($this->label_desain);
                    $doc->exportCaption($this->label_cetak);
                    $doc->exportCaption($this->label_lainlain);
                    $doc->exportCaption($this->delivery_pickup);
                    $doc->exportCaption($this->delivery_singlepoint);
                    $doc->exportCaption($this->delivery_multipoint);
                    $doc->exportCaption($this->delivery_jumlahpoint);
                    $doc->exportCaption($this->delivery_termslain);
                    $doc->exportCaption($this->dibuatdi);
                    $doc->exportCaption($this->created_at);
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
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->status);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->sifat_order);
                        $doc->exportField($this->ukuran_utama);
                        $doc->exportField($this->utama_harga_isi);
                        $doc->exportField($this->utama_harga_isi_order);
                        $doc->exportField($this->utama_harga_primer);
                        $doc->exportField($this->utama_harga_primer_order);
                        $doc->exportField($this->utama_harga_sekunder);
                        $doc->exportField($this->utama_harga_sekunder_order);
                        $doc->exportField($this->utama_harga_label);
                        $doc->exportField($this->utama_harga_label_order);
                        $doc->exportField($this->utama_harga_total);
                        $doc->exportField($this->utama_harga_total_order);
                        $doc->exportField($this->ukuran_lain);
                        $doc->exportField($this->lain_harga_isi);
                        $doc->exportField($this->lain_harga_isi_order);
                        $doc->exportField($this->lain_harga_primer);
                        $doc->exportField($this->lain_harga_primer_order);
                        $doc->exportField($this->lain_harga_sekunder);
                        $doc->exportField($this->lain_harga_sekunder_order);
                        $doc->exportField($this->lain_harga_label);
                        $doc->exportField($this->lain_harga_label_order);
                        $doc->exportField($this->lain_harga_total);
                        $doc->exportField($this->lain_harga_total_order);
                        $doc->exportField($this->isi_bahan_aktif);
                        $doc->exportField($this->isi_bahan_lain);
                        $doc->exportField($this->isi_parfum);
                        $doc->exportField($this->isi_estetika);
                        $doc->exportField($this->kemasan_wadah);
                        $doc->exportField($this->kemasan_tutup);
                        $doc->exportField($this->kemasan_sekunder);
                        $doc->exportField($this->label_desain);
                        $doc->exportField($this->label_cetak);
                        $doc->exportField($this->label_lainlain);
                        $doc->exportField($this->delivery_pickup);
                        $doc->exportField($this->delivery_singlepoint);
                        $doc->exportField($this->delivery_multipoint);
                        $doc->exportField($this->delivery_jumlahpoint);
                        $doc->exportField($this->delivery_termslain);
                        $doc->exportField($this->catatan_khusus);
                        $doc->exportField($this->dibuatdi);
                        $doc->exportField($this->created_at);
                    } else {
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->status);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->sifat_order);
                        $doc->exportField($this->ukuran_utama);
                        $doc->exportField($this->utama_harga_isi);
                        $doc->exportField($this->utama_harga_isi_order);
                        $doc->exportField($this->utama_harga_primer);
                        $doc->exportField($this->utama_harga_primer_order);
                        $doc->exportField($this->utama_harga_sekunder);
                        $doc->exportField($this->utama_harga_sekunder_order);
                        $doc->exportField($this->utama_harga_label);
                        $doc->exportField($this->utama_harga_label_order);
                        $doc->exportField($this->utama_harga_total);
                        $doc->exportField($this->utama_harga_total_order);
                        $doc->exportField($this->ukuran_lain);
                        $doc->exportField($this->lain_harga_isi);
                        $doc->exportField($this->lain_harga_isi_order);
                        $doc->exportField($this->lain_harga_primer);
                        $doc->exportField($this->lain_harga_primer_order);
                        $doc->exportField($this->lain_harga_sekunder);
                        $doc->exportField($this->lain_harga_sekunder_order);
                        $doc->exportField($this->lain_harga_label);
                        $doc->exportField($this->lain_harga_label_order);
                        $doc->exportField($this->lain_harga_total);
                        $doc->exportField($this->lain_harga_total_order);
                        $doc->exportField($this->isi_bahan_aktif);
                        $doc->exportField($this->isi_bahan_lain);
                        $doc->exportField($this->isi_parfum);
                        $doc->exportField($this->isi_estetika);
                        $doc->exportField($this->kemasan_wadah);
                        $doc->exportField($this->kemasan_tutup);
                        $doc->exportField($this->kemasan_sekunder);
                        $doc->exportField($this->label_desain);
                        $doc->exportField($this->label_cetak);
                        $doc->exportField($this->label_lainlain);
                        $doc->exportField($this->delivery_pickup);
                        $doc->exportField($this->delivery_singlepoint);
                        $doc->exportField($this->delivery_multipoint);
                        $doc->exportField($this->delivery_jumlahpoint);
                        $doc->exportField($this->delivery_termslain);
                        $doc->exportField($this->dibuatdi);
                        $doc->exportField($this->created_at);
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
