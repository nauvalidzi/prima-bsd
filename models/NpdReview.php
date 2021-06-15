<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_review
 */
class NpdReview extends DbTable
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
    public $idnpd_sample;
    public $tglreview;
    public $tglsubmit;
    public $wadah;
    public $bentukok;
    public $bentukrevisi;
    public $viskositasok;
    public $viskositasrevisi;
    public $jeniswarnaok;
    public $jeniswarnarevisi;
    public $tonewarnaok;
    public $tonewarnarevisi;
    public $gradasiwarnaok;
    public $gradasiwarnarevisi;
    public $bauok;
    public $baurevisi;
    public $estetikaok;
    public $estetikarevisi;
    public $aplikasiawalok;
    public $aplikasiawalrevisi;
    public $aplikasilamaok;
    public $aplikasilamarevisi;
    public $efekpositifok;
    public $efekpositifrevisi;
    public $efeknegatifok;
    public $efeknegatifrevisi;
    public $kesimpulan;
    public $status;
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
        $this->TableVar = 'npd_review';
        $this->TableName = 'npd_review';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_review`";
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
        $this->id = new DbField('npd_review', 'npd_review', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('npd_review', 'npd_review', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 3, 11, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd->IsForeignKey = true; // Foreign key field
        $this->idnpd->Nullable = false; // NOT NULL field
        $this->idnpd->Required = true; // Required field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idnpd->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","nama","",""], [], ["x_idnpd_sample"], [], [], [], [], '', '');
                break;
            default:
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","nama","",""], [], ["x_idnpd_sample"], [], [], [], [], '', '');
                break;
        }
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // idnpd_sample
        $this->idnpd_sample = new DbField('npd_review', 'npd_review', 'x_idnpd_sample', 'idnpd_sample', '`idnpd_sample`', '`idnpd_sample`', 3, 11, -1, false, '`idnpd_sample`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd_sample->Nullable = false; // NOT NULL field
        $this->idnpd_sample->Required = true; // Required field
        $this->idnpd_sample->Sortable = true; // Allow sort
        $this->idnpd_sample->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idnpd_sample->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idnpd_sample->Lookup = new Lookup('idnpd_sample', 'npd_sample', false, 'id', ["kode","nama","",""], ["x_idnpd"], [], ["idnpd"], ["x_idnpd"], [], [], '', '');
                break;
            default:
                $this->idnpd_sample->Lookup = new Lookup('idnpd_sample', 'npd_sample', false, 'id', ["kode","nama","",""], ["x_idnpd"], [], ["idnpd"], ["x_idnpd"], [], [], '', '');
                break;
        }
        $this->idnpd_sample->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd_sample->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd_sample->Param, "CustomMsg");
        $this->Fields['idnpd_sample'] = &$this->idnpd_sample;

        // tglreview
        $this->tglreview = new DbField('npd_review', 'npd_review', 'x_tglreview', 'tglreview', '`tglreview`', CastDateFieldForLike("`tglreview`", 0, "DB"), 135, 19, 0, false, '`tglreview`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglreview->Nullable = false; // NOT NULL field
        $this->tglreview->Required = true; // Required field
        $this->tglreview->Sortable = true; // Allow sort
        $this->tglreview->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglreview->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglreview->Param, "CustomMsg");
        $this->Fields['tglreview'] = &$this->tglreview;

        // tglsubmit
        $this->tglsubmit = new DbField('npd_review', 'npd_review', 'x_tglsubmit', 'tglsubmit', '`tglsubmit`', CastDateFieldForLike("`tglsubmit`", 0, "DB"), 135, 19, 0, false, '`tglsubmit`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglsubmit->Nullable = false; // NOT NULL field
        $this->tglsubmit->Required = true; // Required field
        $this->tglsubmit->Sortable = true; // Allow sort
        $this->tglsubmit->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglsubmit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglsubmit->Param, "CustomMsg");
        $this->Fields['tglsubmit'] = &$this->tglsubmit;

        // wadah
        $this->wadah = new DbField('npd_review', 'npd_review', 'x_wadah', 'wadah', '`wadah`', '`wadah`', 200, 50, -1, false, '`wadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->wadah->Sortable = true; // Allow sort
        $this->wadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->wadah->Param, "CustomMsg");
        $this->Fields['wadah'] = &$this->wadah;

        // bentukok
        $this->bentukok = new DbField('npd_review', 'npd_review', 'x_bentukok', 'bentukok', '`bentukok`', '`bentukok`', 16, 1, -1, false, '`bentukok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->bentukok->Nullable = false; // NOT NULL field
        $this->bentukok->Required = true; // Required field
        $this->bentukok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->bentukok->Lookup = new Lookup('bentukok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->bentukok->Lookup = new Lookup('bentukok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->bentukok->OptionCount = 3;
        $this->bentukok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->bentukok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentukok->Param, "CustomMsg");
        $this->Fields['bentukok'] = &$this->bentukok;

        // bentukrevisi
        $this->bentukrevisi = new DbField('npd_review', 'npd_review', 'x_bentukrevisi', 'bentukrevisi', '`bentukrevisi`', '`bentukrevisi`', 200, 255, -1, false, '`bentukrevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bentukrevisi->Sortable = true; // Allow sort
        $this->bentukrevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentukrevisi->Param, "CustomMsg");
        $this->Fields['bentukrevisi'] = &$this->bentukrevisi;

        // viskositasok
        $this->viskositasok = new DbField('npd_review', 'npd_review', 'x_viskositasok', 'viskositasok', '`viskositasok`', '`viskositasok`', 16, 1, -1, false, '`viskositasok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->viskositasok->Nullable = false; // NOT NULL field
        $this->viskositasok->Required = true; // Required field
        $this->viskositasok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->viskositasok->Lookup = new Lookup('viskositasok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->viskositasok->Lookup = new Lookup('viskositasok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->viskositasok->OptionCount = 3;
        $this->viskositasok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->viskositasok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->viskositasok->Param, "CustomMsg");
        $this->Fields['viskositasok'] = &$this->viskositasok;

        // viskositasrevisi
        $this->viskositasrevisi = new DbField('npd_review', 'npd_review', 'x_viskositasrevisi', 'viskositasrevisi', '`viskositasrevisi`', '`viskositasrevisi`', 200, 255, -1, false, '`viskositasrevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->viskositasrevisi->Sortable = true; // Allow sort
        $this->viskositasrevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->viskositasrevisi->Param, "CustomMsg");
        $this->Fields['viskositasrevisi'] = &$this->viskositasrevisi;

        // jeniswarnaok
        $this->jeniswarnaok = new DbField('npd_review', 'npd_review', 'x_jeniswarnaok', 'jeniswarnaok', '`jeniswarnaok`', '`jeniswarnaok`', 16, 1, -1, false, '`jeniswarnaok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->jeniswarnaok->Nullable = false; // NOT NULL field
        $this->jeniswarnaok->Required = true; // Required field
        $this->jeniswarnaok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->jeniswarnaok->Lookup = new Lookup('jeniswarnaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->jeniswarnaok->Lookup = new Lookup('jeniswarnaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->jeniswarnaok->OptionCount = 3;
        $this->jeniswarnaok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->jeniswarnaok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jeniswarnaok->Param, "CustomMsg");
        $this->Fields['jeniswarnaok'] = &$this->jeniswarnaok;

        // jeniswarnarevisi
        $this->jeniswarnarevisi = new DbField('npd_review', 'npd_review', 'x_jeniswarnarevisi', 'jeniswarnarevisi', '`jeniswarnarevisi`', '`jeniswarnarevisi`', 200, 255, -1, false, '`jeniswarnarevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jeniswarnarevisi->Sortable = true; // Allow sort
        $this->jeniswarnarevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jeniswarnarevisi->Param, "CustomMsg");
        $this->Fields['jeniswarnarevisi'] = &$this->jeniswarnarevisi;

        // tonewarnaok
        $this->tonewarnaok = new DbField('npd_review', 'npd_review', 'x_tonewarnaok', 'tonewarnaok', '`tonewarnaok`', '`tonewarnaok`', 16, 1, -1, false, '`tonewarnaok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->tonewarnaok->Nullable = false; // NOT NULL field
        $this->tonewarnaok->Required = true; // Required field
        $this->tonewarnaok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->tonewarnaok->Lookup = new Lookup('tonewarnaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->tonewarnaok->Lookup = new Lookup('tonewarnaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->tonewarnaok->OptionCount = 3;
        $this->tonewarnaok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->tonewarnaok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tonewarnaok->Param, "CustomMsg");
        $this->Fields['tonewarnaok'] = &$this->tonewarnaok;

        // tonewarnarevisi
        $this->tonewarnarevisi = new DbField('npd_review', 'npd_review', 'x_tonewarnarevisi', 'tonewarnarevisi', '`tonewarnarevisi`', '`tonewarnarevisi`', 200, 255, -1, false, '`tonewarnarevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tonewarnarevisi->Sortable = true; // Allow sort
        $this->tonewarnarevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tonewarnarevisi->Param, "CustomMsg");
        $this->Fields['tonewarnarevisi'] = &$this->tonewarnarevisi;

        // gradasiwarnaok
        $this->gradasiwarnaok = new DbField('npd_review', 'npd_review', 'x_gradasiwarnaok', 'gradasiwarnaok', '`gradasiwarnaok`', '`gradasiwarnaok`', 16, 1, -1, false, '`gradasiwarnaok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->gradasiwarnaok->Nullable = false; // NOT NULL field
        $this->gradasiwarnaok->Required = true; // Required field
        $this->gradasiwarnaok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->gradasiwarnaok->Lookup = new Lookup('gradasiwarnaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->gradasiwarnaok->Lookup = new Lookup('gradasiwarnaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->gradasiwarnaok->OptionCount = 3;
        $this->gradasiwarnaok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->gradasiwarnaok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gradasiwarnaok->Param, "CustomMsg");
        $this->Fields['gradasiwarnaok'] = &$this->gradasiwarnaok;

        // gradasiwarnarevisi
        $this->gradasiwarnarevisi = new DbField('npd_review', 'npd_review', 'x_gradasiwarnarevisi', 'gradasiwarnarevisi', '`gradasiwarnarevisi`', '`gradasiwarnarevisi`', 200, 255, -1, false, '`gradasiwarnarevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->gradasiwarnarevisi->Sortable = true; // Allow sort
        $this->gradasiwarnarevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gradasiwarnarevisi->Param, "CustomMsg");
        $this->Fields['gradasiwarnarevisi'] = &$this->gradasiwarnarevisi;

        // bauok
        $this->bauok = new DbField('npd_review', 'npd_review', 'x_bauok', 'bauok', '`bauok`', '`bauok`', 16, 1, -1, false, '`bauok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->bauok->Nullable = false; // NOT NULL field
        $this->bauok->Required = true; // Required field
        $this->bauok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->bauok->Lookup = new Lookup('bauok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->bauok->Lookup = new Lookup('bauok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->bauok->OptionCount = 3;
        $this->bauok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->bauok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bauok->Param, "CustomMsg");
        $this->Fields['bauok'] = &$this->bauok;

        // baurevisi
        $this->baurevisi = new DbField('npd_review', 'npd_review', 'x_baurevisi', 'baurevisi', '`baurevisi`', '`baurevisi`', 200, 255, -1, false, '`baurevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->baurevisi->Sortable = true; // Allow sort
        $this->baurevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->baurevisi->Param, "CustomMsg");
        $this->Fields['baurevisi'] = &$this->baurevisi;

        // estetikaok
        $this->estetikaok = new DbField('npd_review', 'npd_review', 'x_estetikaok', 'estetikaok', '`estetikaok`', '`estetikaok`', 16, 1, -1, false, '`estetikaok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->estetikaok->Nullable = false; // NOT NULL field
        $this->estetikaok->Required = true; // Required field
        $this->estetikaok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->estetikaok->Lookup = new Lookup('estetikaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->estetikaok->Lookup = new Lookup('estetikaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->estetikaok->OptionCount = 3;
        $this->estetikaok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->estetikaok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->estetikaok->Param, "CustomMsg");
        $this->Fields['estetikaok'] = &$this->estetikaok;

        // estetikarevisi
        $this->estetikarevisi = new DbField('npd_review', 'npd_review', 'x_estetikarevisi', 'estetikarevisi', '`estetikarevisi`', '`estetikarevisi`', 200, 255, -1, false, '`estetikarevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->estetikarevisi->Sortable = true; // Allow sort
        $this->estetikarevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->estetikarevisi->Param, "CustomMsg");
        $this->Fields['estetikarevisi'] = &$this->estetikarevisi;

        // aplikasiawalok
        $this->aplikasiawalok = new DbField('npd_review', 'npd_review', 'x_aplikasiawalok', 'aplikasiawalok', '`aplikasiawalok`', '`aplikasiawalok`', 16, 1, -1, false, '`aplikasiawalok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aplikasiawalok->Nullable = false; // NOT NULL field
        $this->aplikasiawalok->Required = true; // Required field
        $this->aplikasiawalok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasiawalok->Lookup = new Lookup('aplikasiawalok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasiawalok->Lookup = new Lookup('aplikasiawalok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasiawalok->OptionCount = 3;
        $this->aplikasiawalok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->aplikasiawalok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasiawalok->Param, "CustomMsg");
        $this->Fields['aplikasiawalok'] = &$this->aplikasiawalok;

        // aplikasiawalrevisi
        $this->aplikasiawalrevisi = new DbField('npd_review', 'npd_review', 'x_aplikasiawalrevisi', 'aplikasiawalrevisi', '`aplikasiawalrevisi`', '`aplikasiawalrevisi`', 200, 255, -1, false, '`aplikasiawalrevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasiawalrevisi->Sortable = true; // Allow sort
        $this->aplikasiawalrevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasiawalrevisi->Param, "CustomMsg");
        $this->Fields['aplikasiawalrevisi'] = &$this->aplikasiawalrevisi;

        // aplikasilamaok
        $this->aplikasilamaok = new DbField('npd_review', 'npd_review', 'x_aplikasilamaok', 'aplikasilamaok', '`aplikasilamaok`', '`aplikasilamaok`', 16, 1, -1, false, '`aplikasilamaok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aplikasilamaok->Nullable = false; // NOT NULL field
        $this->aplikasilamaok->Required = true; // Required field
        $this->aplikasilamaok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasilamaok->Lookup = new Lookup('aplikasilamaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasilamaok->Lookup = new Lookup('aplikasilamaok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasilamaok->OptionCount = 3;
        $this->aplikasilamaok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->aplikasilamaok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasilamaok->Param, "CustomMsg");
        $this->Fields['aplikasilamaok'] = &$this->aplikasilamaok;

        // aplikasilamarevisi
        $this->aplikasilamarevisi = new DbField('npd_review', 'npd_review', 'x_aplikasilamarevisi', 'aplikasilamarevisi', '`aplikasilamarevisi`', '`aplikasilamarevisi`', 200, 255, -1, false, '`aplikasilamarevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasilamarevisi->Sortable = true; // Allow sort
        $this->aplikasilamarevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasilamarevisi->Param, "CustomMsg");
        $this->Fields['aplikasilamarevisi'] = &$this->aplikasilamarevisi;

        // efekpositifok
        $this->efekpositifok = new DbField('npd_review', 'npd_review', 'x_efekpositifok', 'efekpositifok', '`efekpositifok`', '`efekpositifok`', 16, 1, -1, false, '`efekpositifok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->efekpositifok->Nullable = false; // NOT NULL field
        $this->efekpositifok->Required = true; // Required field
        $this->efekpositifok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->efekpositifok->Lookup = new Lookup('efekpositifok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->efekpositifok->Lookup = new Lookup('efekpositifok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->efekpositifok->OptionCount = 3;
        $this->efekpositifok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->efekpositifok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efekpositifok->Param, "CustomMsg");
        $this->Fields['efekpositifok'] = &$this->efekpositifok;

        // efekpositifrevisi
        $this->efekpositifrevisi = new DbField('npd_review', 'npd_review', 'x_efekpositifrevisi', 'efekpositifrevisi', '`efekpositifrevisi`', '`efekpositifrevisi`', 200, 255, -1, false, '`efekpositifrevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->efekpositifrevisi->Sortable = true; // Allow sort
        $this->efekpositifrevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efekpositifrevisi->Param, "CustomMsg");
        $this->Fields['efekpositifrevisi'] = &$this->efekpositifrevisi;

        // efeknegatifok
        $this->efeknegatifok = new DbField('npd_review', 'npd_review', 'x_efeknegatifok', 'efeknegatifok', '`efeknegatifok`', '`efeknegatifok`', 16, 1, -1, false, '`efeknegatifok`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->efeknegatifok->Nullable = false; // NOT NULL field
        $this->efeknegatifok->Required = true; // Required field
        $this->efeknegatifok->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->efeknegatifok->Lookup = new Lookup('efeknegatifok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->efeknegatifok->Lookup = new Lookup('efeknegatifok', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->efeknegatifok->OptionCount = 3;
        $this->efeknegatifok->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->efeknegatifok->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efeknegatifok->Param, "CustomMsg");
        $this->Fields['efeknegatifok'] = &$this->efeknegatifok;

        // efeknegatifrevisi
        $this->efeknegatifrevisi = new DbField('npd_review', 'npd_review', 'x_efeknegatifrevisi', 'efeknegatifrevisi', '`efeknegatifrevisi`', '`efeknegatifrevisi`', 200, 255, -1, false, '`efeknegatifrevisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->efeknegatifrevisi->Sortable = true; // Allow sort
        $this->efeknegatifrevisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efeknegatifrevisi->Param, "CustomMsg");
        $this->Fields['efeknegatifrevisi'] = &$this->efeknegatifrevisi;

        // kesimpulan
        $this->kesimpulan = new DbField('npd_review', 'npd_review', 'x_kesimpulan', 'kesimpulan', '`kesimpulan`', '`kesimpulan`', 200, 255, -1, false, '`kesimpulan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->kesimpulan->Nullable = false; // NOT NULL field
        $this->kesimpulan->Required = true; // Required field
        $this->kesimpulan->Sortable = true; // Allow sort
        $this->kesimpulan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kesimpulan->Param, "CustomMsg");
        $this->Fields['kesimpulan'] = &$this->kesimpulan;

        // status
        $this->status = new DbField('npd_review', 'npd_review', 'x_status', 'status', '`status`', '`status`', 16, 1, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->status->Lookup = new Lookup('status', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // created_at
        $this->created_at = new DbField('npd_review', 'npd_review', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // created_by
        $this->created_by = new DbField('npd_review', 'npd_review', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'HIDDEN');
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_by->Param, "CustomMsg");
        $this->Fields['created_by'] = &$this->created_by;

        // readonly
        $this->readonly = new DbField('npd_review', 'npd_review', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = true; // Allow sort
        $this->readonly->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->readonly->Lookup = new Lookup('readonly', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->readonly->Lookup = new Lookup('readonly', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->readonly->OptionCount = 2;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_review`";
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
        $this->idnpd->DbValue = $row['idnpd'];
        $this->idnpd_sample->DbValue = $row['idnpd_sample'];
        $this->tglreview->DbValue = $row['tglreview'];
        $this->tglsubmit->DbValue = $row['tglsubmit'];
        $this->wadah->DbValue = $row['wadah'];
        $this->bentukok->DbValue = $row['bentukok'];
        $this->bentukrevisi->DbValue = $row['bentukrevisi'];
        $this->viskositasok->DbValue = $row['viskositasok'];
        $this->viskositasrevisi->DbValue = $row['viskositasrevisi'];
        $this->jeniswarnaok->DbValue = $row['jeniswarnaok'];
        $this->jeniswarnarevisi->DbValue = $row['jeniswarnarevisi'];
        $this->tonewarnaok->DbValue = $row['tonewarnaok'];
        $this->tonewarnarevisi->DbValue = $row['tonewarnarevisi'];
        $this->gradasiwarnaok->DbValue = $row['gradasiwarnaok'];
        $this->gradasiwarnarevisi->DbValue = $row['gradasiwarnarevisi'];
        $this->bauok->DbValue = $row['bauok'];
        $this->baurevisi->DbValue = $row['baurevisi'];
        $this->estetikaok->DbValue = $row['estetikaok'];
        $this->estetikarevisi->DbValue = $row['estetikarevisi'];
        $this->aplikasiawalok->DbValue = $row['aplikasiawalok'];
        $this->aplikasiawalrevisi->DbValue = $row['aplikasiawalrevisi'];
        $this->aplikasilamaok->DbValue = $row['aplikasilamaok'];
        $this->aplikasilamarevisi->DbValue = $row['aplikasilamarevisi'];
        $this->efekpositifok->DbValue = $row['efekpositifok'];
        $this->efekpositifrevisi->DbValue = $row['efekpositifrevisi'];
        $this->efeknegatifok->DbValue = $row['efeknegatifok'];
        $this->efeknegatifrevisi->DbValue = $row['efeknegatifrevisi'];
        $this->kesimpulan->DbValue = $row['kesimpulan'];
        $this->status->DbValue = $row['status'];
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
        return $_SESSION[$name] ?? GetUrl("NpdReviewList");
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
        if ($pageName == "NpdReviewView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdReviewEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdReviewAdd") {
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
                return "NpdReviewView";
            case Config("API_ADD_ACTION"):
                return "NpdReviewAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdReviewEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdReviewDelete";
            case Config("API_LIST_ACTION"):
                return "NpdReviewList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdReviewList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdReviewView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdReviewView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdReviewAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdReviewAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdReviewEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdReviewAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdReviewDelete", $this->getUrlParm());
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
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->tglreview->setDbValue($row['tglreview']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->wadah->setDbValue($row['wadah']);
        $this->bentukok->setDbValue($row['bentukok']);
        $this->bentukrevisi->setDbValue($row['bentukrevisi']);
        $this->viskositasok->setDbValue($row['viskositasok']);
        $this->viskositasrevisi->setDbValue($row['viskositasrevisi']);
        $this->jeniswarnaok->setDbValue($row['jeniswarnaok']);
        $this->jeniswarnarevisi->setDbValue($row['jeniswarnarevisi']);
        $this->tonewarnaok->setDbValue($row['tonewarnaok']);
        $this->tonewarnarevisi->setDbValue($row['tonewarnarevisi']);
        $this->gradasiwarnaok->setDbValue($row['gradasiwarnaok']);
        $this->gradasiwarnarevisi->setDbValue($row['gradasiwarnarevisi']);
        $this->bauok->setDbValue($row['bauok']);
        $this->baurevisi->setDbValue($row['baurevisi']);
        $this->estetikaok->setDbValue($row['estetikaok']);
        $this->estetikarevisi->setDbValue($row['estetikarevisi']);
        $this->aplikasiawalok->setDbValue($row['aplikasiawalok']);
        $this->aplikasiawalrevisi->setDbValue($row['aplikasiawalrevisi']);
        $this->aplikasilamaok->setDbValue($row['aplikasilamaok']);
        $this->aplikasilamarevisi->setDbValue($row['aplikasilamarevisi']);
        $this->efekpositifok->setDbValue($row['efekpositifok']);
        $this->efekpositifrevisi->setDbValue($row['efekpositifrevisi']);
        $this->efeknegatifok->setDbValue($row['efeknegatifok']);
        $this->efeknegatifrevisi->setDbValue($row['efeknegatifrevisi']);
        $this->kesimpulan->setDbValue($row['kesimpulan']);
        $this->status->setDbValue($row['status']);
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

        // idnpd

        // idnpd_sample

        // tglreview

        // tglsubmit

        // wadah

        // bentukok

        // bentukrevisi

        // viskositasok

        // viskositasrevisi

        // jeniswarnaok

        // jeniswarnarevisi

        // tonewarnaok

        // tonewarnarevisi

        // gradasiwarnaok

        // gradasiwarnarevisi

        // bauok

        // baurevisi

        // estetikaok

        // estetikarevisi

        // aplikasiawalok

        // aplikasiawalrevisi

        // aplikasilamaok

        // aplikasilamarevisi

        // efekpositifok

        // efekpositifrevisi

        // efeknegatifok

        // efeknegatifrevisi

        // kesimpulan

        // status

        // created_at

        // created_by

        // readonly

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idnpd
        $curVal = trim(strval($this->idnpd->CurrentValue));
        if ($curVal != "") {
            $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
            if ($this->idnpd->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                    $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                } else {
                    $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                }
            }
        } else {
            $this->idnpd->ViewValue = null;
        }
        $this->idnpd->ViewCustomAttributes = "";

        // idnpd_sample
        $curVal = trim(strval($this->idnpd_sample->CurrentValue));
        if ($curVal != "") {
            $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "`status`=0" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idnpd_sample->Lookup->renderViewRow($rswrk[0]);
                    $this->idnpd_sample->ViewValue = $this->idnpd_sample->displayValue($arwrk);
                } else {
                    $this->idnpd_sample->ViewValue = $this->idnpd_sample->CurrentValue;
                }
            }
        } else {
            $this->idnpd_sample->ViewValue = null;
        }
        $this->idnpd_sample->ViewCustomAttributes = "";

        // tglreview
        $this->tglreview->ViewValue = $this->tglreview->CurrentValue;
        $this->tglreview->ViewValue = FormatDateTime($this->tglreview->ViewValue, 0);
        $this->tglreview->ViewCustomAttributes = "";

        // tglsubmit
        $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
        $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
        $this->tglsubmit->ViewCustomAttributes = "";

        // wadah
        $this->wadah->ViewValue = $this->wadah->CurrentValue;
        $this->wadah->ViewCustomAttributes = "";

        // bentukok
        if (strval($this->bentukok->CurrentValue) != "") {
            $this->bentukok->ViewValue = $this->bentukok->optionCaption($this->bentukok->CurrentValue);
        } else {
            $this->bentukok->ViewValue = null;
        }
        $this->bentukok->ViewCustomAttributes = "";

        // bentukrevisi
        $this->bentukrevisi->ViewValue = $this->bentukrevisi->CurrentValue;
        $this->bentukrevisi->ViewCustomAttributes = "";

        // viskositasok
        if (strval($this->viskositasok->CurrentValue) != "") {
            $this->viskositasok->ViewValue = $this->viskositasok->optionCaption($this->viskositasok->CurrentValue);
        } else {
            $this->viskositasok->ViewValue = null;
        }
        $this->viskositasok->ViewCustomAttributes = "";

        // viskositasrevisi
        $this->viskositasrevisi->ViewValue = $this->viskositasrevisi->CurrentValue;
        $this->viskositasrevisi->ViewCustomAttributes = "";

        // jeniswarnaok
        if (strval($this->jeniswarnaok->CurrentValue) != "") {
            $this->jeniswarnaok->ViewValue = $this->jeniswarnaok->optionCaption($this->jeniswarnaok->CurrentValue);
        } else {
            $this->jeniswarnaok->ViewValue = null;
        }
        $this->jeniswarnaok->ViewCustomAttributes = "";

        // jeniswarnarevisi
        $this->jeniswarnarevisi->ViewValue = $this->jeniswarnarevisi->CurrentValue;
        $this->jeniswarnarevisi->ViewCustomAttributes = "";

        // tonewarnaok
        if (strval($this->tonewarnaok->CurrentValue) != "") {
            $this->tonewarnaok->ViewValue = $this->tonewarnaok->optionCaption($this->tonewarnaok->CurrentValue);
        } else {
            $this->tonewarnaok->ViewValue = null;
        }
        $this->tonewarnaok->ViewCustomAttributes = "";

        // tonewarnarevisi
        $this->tonewarnarevisi->ViewValue = $this->tonewarnarevisi->CurrentValue;
        $this->tonewarnarevisi->ViewCustomAttributes = "";

        // gradasiwarnaok
        if (strval($this->gradasiwarnaok->CurrentValue) != "") {
            $this->gradasiwarnaok->ViewValue = $this->gradasiwarnaok->optionCaption($this->gradasiwarnaok->CurrentValue);
        } else {
            $this->gradasiwarnaok->ViewValue = null;
        }
        $this->gradasiwarnaok->ViewCustomAttributes = "";

        // gradasiwarnarevisi
        $this->gradasiwarnarevisi->ViewValue = $this->gradasiwarnarevisi->CurrentValue;
        $this->gradasiwarnarevisi->ViewCustomAttributes = "";

        // bauok
        if (strval($this->bauok->CurrentValue) != "") {
            $this->bauok->ViewValue = $this->bauok->optionCaption($this->bauok->CurrentValue);
        } else {
            $this->bauok->ViewValue = null;
        }
        $this->bauok->ViewCustomAttributes = "";

        // baurevisi
        $this->baurevisi->ViewValue = $this->baurevisi->CurrentValue;
        $this->baurevisi->ViewCustomAttributes = "";

        // estetikaok
        if (strval($this->estetikaok->CurrentValue) != "") {
            $this->estetikaok->ViewValue = $this->estetikaok->optionCaption($this->estetikaok->CurrentValue);
        } else {
            $this->estetikaok->ViewValue = null;
        }
        $this->estetikaok->ViewCustomAttributes = "";

        // estetikarevisi
        $this->estetikarevisi->ViewValue = $this->estetikarevisi->CurrentValue;
        $this->estetikarevisi->ViewCustomAttributes = "";

        // aplikasiawalok
        if (strval($this->aplikasiawalok->CurrentValue) != "") {
            $this->aplikasiawalok->ViewValue = $this->aplikasiawalok->optionCaption($this->aplikasiawalok->CurrentValue);
        } else {
            $this->aplikasiawalok->ViewValue = null;
        }
        $this->aplikasiawalok->ViewCustomAttributes = "";

        // aplikasiawalrevisi
        $this->aplikasiawalrevisi->ViewValue = $this->aplikasiawalrevisi->CurrentValue;
        $this->aplikasiawalrevisi->ViewCustomAttributes = "";

        // aplikasilamaok
        if (strval($this->aplikasilamaok->CurrentValue) != "") {
            $this->aplikasilamaok->ViewValue = $this->aplikasilamaok->optionCaption($this->aplikasilamaok->CurrentValue);
        } else {
            $this->aplikasilamaok->ViewValue = null;
        }
        $this->aplikasilamaok->ViewCustomAttributes = "";

        // aplikasilamarevisi
        $this->aplikasilamarevisi->ViewValue = $this->aplikasilamarevisi->CurrentValue;
        $this->aplikasilamarevisi->ViewCustomAttributes = "";

        // efekpositifok
        if (strval($this->efekpositifok->CurrentValue) != "") {
            $this->efekpositifok->ViewValue = $this->efekpositifok->optionCaption($this->efekpositifok->CurrentValue);
        } else {
            $this->efekpositifok->ViewValue = null;
        }
        $this->efekpositifok->ViewCustomAttributes = "";

        // efekpositifrevisi
        $this->efekpositifrevisi->ViewValue = $this->efekpositifrevisi->CurrentValue;
        $this->efekpositifrevisi->ViewCustomAttributes = "";

        // efeknegatifok
        if (strval($this->efeknegatifok->CurrentValue) != "") {
            $this->efeknegatifok->ViewValue = $this->efeknegatifok->optionCaption($this->efeknegatifok->CurrentValue);
        } else {
            $this->efeknegatifok->ViewValue = null;
        }
        $this->efeknegatifok->ViewCustomAttributes = "";

        // efeknegatifrevisi
        $this->efeknegatifrevisi->ViewValue = $this->efeknegatifrevisi->CurrentValue;
        $this->efeknegatifrevisi->ViewCustomAttributes = "";

        // kesimpulan
        $this->kesimpulan->ViewValue = $this->kesimpulan->CurrentValue;
        $this->kesimpulan->ViewCustomAttributes = "";

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // created_by
        $this->created_by->ViewValue = $this->created_by->CurrentValue;
        $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
        $this->created_by->ViewCustomAttributes = "";

        // readonly
        if (ConvertToBool($this->readonly->CurrentValue)) {
            $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
        } else {
            $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
        }
        $this->readonly->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idnpd
        $this->idnpd->LinkCustomAttributes = "";
        $this->idnpd->HrefValue = "";
        $this->idnpd->TooltipValue = "";

        // idnpd_sample
        $this->idnpd_sample->LinkCustomAttributes = "";
        $this->idnpd_sample->HrefValue = "";
        $this->idnpd_sample->TooltipValue = "";

        // tglreview
        $this->tglreview->LinkCustomAttributes = "";
        $this->tglreview->HrefValue = "";
        $this->tglreview->TooltipValue = "";

        // tglsubmit
        $this->tglsubmit->LinkCustomAttributes = "";
        $this->tglsubmit->HrefValue = "";
        $this->tglsubmit->TooltipValue = "";

        // wadah
        $this->wadah->LinkCustomAttributes = "";
        $this->wadah->HrefValue = "";
        $this->wadah->TooltipValue = "";

        // bentukok
        $this->bentukok->LinkCustomAttributes = "";
        $this->bentukok->HrefValue = "";
        $this->bentukok->TooltipValue = "";

        // bentukrevisi
        $this->bentukrevisi->LinkCustomAttributes = "";
        $this->bentukrevisi->HrefValue = "";
        $this->bentukrevisi->TooltipValue = "";

        // viskositasok
        $this->viskositasok->LinkCustomAttributes = "";
        $this->viskositasok->HrefValue = "";
        $this->viskositasok->TooltipValue = "";

        // viskositasrevisi
        $this->viskositasrevisi->LinkCustomAttributes = "";
        $this->viskositasrevisi->HrefValue = "";
        $this->viskositasrevisi->TooltipValue = "";

        // jeniswarnaok
        $this->jeniswarnaok->LinkCustomAttributes = "";
        $this->jeniswarnaok->HrefValue = "";
        $this->jeniswarnaok->TooltipValue = "";

        // jeniswarnarevisi
        $this->jeniswarnarevisi->LinkCustomAttributes = "";
        $this->jeniswarnarevisi->HrefValue = "";
        $this->jeniswarnarevisi->TooltipValue = "";

        // tonewarnaok
        $this->tonewarnaok->LinkCustomAttributes = "";
        $this->tonewarnaok->HrefValue = "";
        $this->tonewarnaok->TooltipValue = "";

        // tonewarnarevisi
        $this->tonewarnarevisi->LinkCustomAttributes = "";
        $this->tonewarnarevisi->HrefValue = "";
        $this->tonewarnarevisi->TooltipValue = "";

        // gradasiwarnaok
        $this->gradasiwarnaok->LinkCustomAttributes = "";
        $this->gradasiwarnaok->HrefValue = "";
        $this->gradasiwarnaok->TooltipValue = "";

        // gradasiwarnarevisi
        $this->gradasiwarnarevisi->LinkCustomAttributes = "";
        $this->gradasiwarnarevisi->HrefValue = "";
        $this->gradasiwarnarevisi->TooltipValue = "";

        // bauok
        $this->bauok->LinkCustomAttributes = "";
        $this->bauok->HrefValue = "";
        $this->bauok->TooltipValue = "";

        // baurevisi
        $this->baurevisi->LinkCustomAttributes = "";
        $this->baurevisi->HrefValue = "";
        $this->baurevisi->TooltipValue = "";

        // estetikaok
        $this->estetikaok->LinkCustomAttributes = "";
        $this->estetikaok->HrefValue = "";
        $this->estetikaok->TooltipValue = "";

        // estetikarevisi
        $this->estetikarevisi->LinkCustomAttributes = "";
        $this->estetikarevisi->HrefValue = "";
        $this->estetikarevisi->TooltipValue = "";

        // aplikasiawalok
        $this->aplikasiawalok->LinkCustomAttributes = "";
        $this->aplikasiawalok->HrefValue = "";
        $this->aplikasiawalok->TooltipValue = "";

        // aplikasiawalrevisi
        $this->aplikasiawalrevisi->LinkCustomAttributes = "";
        $this->aplikasiawalrevisi->HrefValue = "";
        $this->aplikasiawalrevisi->TooltipValue = "";

        // aplikasilamaok
        $this->aplikasilamaok->LinkCustomAttributes = "";
        $this->aplikasilamaok->HrefValue = "";
        $this->aplikasilamaok->TooltipValue = "";

        // aplikasilamarevisi
        $this->aplikasilamarevisi->LinkCustomAttributes = "";
        $this->aplikasilamarevisi->HrefValue = "";
        $this->aplikasilamarevisi->TooltipValue = "";

        // efekpositifok
        $this->efekpositifok->LinkCustomAttributes = "";
        $this->efekpositifok->HrefValue = "";
        $this->efekpositifok->TooltipValue = "";

        // efekpositifrevisi
        $this->efekpositifrevisi->LinkCustomAttributes = "";
        $this->efekpositifrevisi->HrefValue = "";
        $this->efekpositifrevisi->TooltipValue = "";

        // efeknegatifok
        $this->efeknegatifok->LinkCustomAttributes = "";
        $this->efeknegatifok->HrefValue = "";
        $this->efeknegatifok->TooltipValue = "";

        // efeknegatifrevisi
        $this->efeknegatifrevisi->LinkCustomAttributes = "";
        $this->efeknegatifrevisi->HrefValue = "";
        $this->efeknegatifrevisi->TooltipValue = "";

        // kesimpulan
        $this->kesimpulan->LinkCustomAttributes = "";
        $this->kesimpulan->HrefValue = "";
        $this->kesimpulan->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

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

        // idnpd
        $this->idnpd->EditAttrs["class"] = "form-control";
        $this->idnpd->EditCustomAttributes = "";
        if ($this->idnpd->getSessionValue() != "") {
            $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
            $curVal = trim(strval($this->idnpd->CurrentValue));
            if ($curVal != "") {
                $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                if ($this->idnpd->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                    } else {
                        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                    }
                }
            } else {
                $this->idnpd->ViewValue = null;
            }
            $this->idnpd->ViewCustomAttributes = "";
        } else {
            $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
        }

        // idnpd_sample
        $this->idnpd_sample->EditAttrs["class"] = "form-control";
        $this->idnpd_sample->EditCustomAttributes = "";
        $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

        // tglreview
        $this->tglreview->EditAttrs["class"] = "form-control";
        $this->tglreview->EditCustomAttributes = "";
        $this->tglreview->EditValue = FormatDateTime($this->tglreview->CurrentValue, 8);
        $this->tglreview->PlaceHolder = RemoveHtml($this->tglreview->caption());

        // tglsubmit
        $this->tglsubmit->EditAttrs["class"] = "form-control";
        $this->tglsubmit->EditCustomAttributes = "";
        $this->tglsubmit->EditValue = FormatDateTime($this->tglsubmit->CurrentValue, 8);
        $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

        // wadah
        $this->wadah->EditAttrs["class"] = "form-control";
        $this->wadah->EditCustomAttributes = "";
        if (!$this->wadah->Raw) {
            $this->wadah->CurrentValue = HtmlDecode($this->wadah->CurrentValue);
        }
        $this->wadah->EditValue = $this->wadah->CurrentValue;
        $this->wadah->PlaceHolder = RemoveHtml($this->wadah->caption());

        // bentukok
        $this->bentukok->EditCustomAttributes = "";
        $this->bentukok->EditValue = $this->bentukok->options(false);
        $this->bentukok->PlaceHolder = RemoveHtml($this->bentukok->caption());

        // bentukrevisi
        $this->bentukrevisi->EditAttrs["class"] = "form-control";
        $this->bentukrevisi->EditCustomAttributes = "";
        if (!$this->bentukrevisi->Raw) {
            $this->bentukrevisi->CurrentValue = HtmlDecode($this->bentukrevisi->CurrentValue);
        }
        $this->bentukrevisi->EditValue = $this->bentukrevisi->CurrentValue;
        $this->bentukrevisi->PlaceHolder = RemoveHtml($this->bentukrevisi->caption());

        // viskositasok
        $this->viskositasok->EditCustomAttributes = "";
        $this->viskositasok->EditValue = $this->viskositasok->options(false);
        $this->viskositasok->PlaceHolder = RemoveHtml($this->viskositasok->caption());

        // viskositasrevisi
        $this->viskositasrevisi->EditAttrs["class"] = "form-control";
        $this->viskositasrevisi->EditCustomAttributes = "";
        if (!$this->viskositasrevisi->Raw) {
            $this->viskositasrevisi->CurrentValue = HtmlDecode($this->viskositasrevisi->CurrentValue);
        }
        $this->viskositasrevisi->EditValue = $this->viskositasrevisi->CurrentValue;
        $this->viskositasrevisi->PlaceHolder = RemoveHtml($this->viskositasrevisi->caption());

        // jeniswarnaok
        $this->jeniswarnaok->EditCustomAttributes = "";
        $this->jeniswarnaok->EditValue = $this->jeniswarnaok->options(false);
        $this->jeniswarnaok->PlaceHolder = RemoveHtml($this->jeniswarnaok->caption());

        // jeniswarnarevisi
        $this->jeniswarnarevisi->EditAttrs["class"] = "form-control";
        $this->jeniswarnarevisi->EditCustomAttributes = "";
        if (!$this->jeniswarnarevisi->Raw) {
            $this->jeniswarnarevisi->CurrentValue = HtmlDecode($this->jeniswarnarevisi->CurrentValue);
        }
        $this->jeniswarnarevisi->EditValue = $this->jeniswarnarevisi->CurrentValue;
        $this->jeniswarnarevisi->PlaceHolder = RemoveHtml($this->jeniswarnarevisi->caption());

        // tonewarnaok
        $this->tonewarnaok->EditCustomAttributes = "";
        $this->tonewarnaok->EditValue = $this->tonewarnaok->options(false);
        $this->tonewarnaok->PlaceHolder = RemoveHtml($this->tonewarnaok->caption());

        // tonewarnarevisi
        $this->tonewarnarevisi->EditAttrs["class"] = "form-control";
        $this->tonewarnarevisi->EditCustomAttributes = "";
        if (!$this->tonewarnarevisi->Raw) {
            $this->tonewarnarevisi->CurrentValue = HtmlDecode($this->tonewarnarevisi->CurrentValue);
        }
        $this->tonewarnarevisi->EditValue = $this->tonewarnarevisi->CurrentValue;
        $this->tonewarnarevisi->PlaceHolder = RemoveHtml($this->tonewarnarevisi->caption());

        // gradasiwarnaok
        $this->gradasiwarnaok->EditCustomAttributes = "";
        $this->gradasiwarnaok->EditValue = $this->gradasiwarnaok->options(false);
        $this->gradasiwarnaok->PlaceHolder = RemoveHtml($this->gradasiwarnaok->caption());

        // gradasiwarnarevisi
        $this->gradasiwarnarevisi->EditAttrs["class"] = "form-control";
        $this->gradasiwarnarevisi->EditCustomAttributes = "";
        if (!$this->gradasiwarnarevisi->Raw) {
            $this->gradasiwarnarevisi->CurrentValue = HtmlDecode($this->gradasiwarnarevisi->CurrentValue);
        }
        $this->gradasiwarnarevisi->EditValue = $this->gradasiwarnarevisi->CurrentValue;
        $this->gradasiwarnarevisi->PlaceHolder = RemoveHtml($this->gradasiwarnarevisi->caption());

        // bauok
        $this->bauok->EditCustomAttributes = "";
        $this->bauok->EditValue = $this->bauok->options(false);
        $this->bauok->PlaceHolder = RemoveHtml($this->bauok->caption());

        // baurevisi
        $this->baurevisi->EditAttrs["class"] = "form-control";
        $this->baurevisi->EditCustomAttributes = "";
        if (!$this->baurevisi->Raw) {
            $this->baurevisi->CurrentValue = HtmlDecode($this->baurevisi->CurrentValue);
        }
        $this->baurevisi->EditValue = $this->baurevisi->CurrentValue;
        $this->baurevisi->PlaceHolder = RemoveHtml($this->baurevisi->caption());

        // estetikaok
        $this->estetikaok->EditCustomAttributes = "";
        $this->estetikaok->EditValue = $this->estetikaok->options(false);
        $this->estetikaok->PlaceHolder = RemoveHtml($this->estetikaok->caption());

        // estetikarevisi
        $this->estetikarevisi->EditAttrs["class"] = "form-control";
        $this->estetikarevisi->EditCustomAttributes = "";
        if (!$this->estetikarevisi->Raw) {
            $this->estetikarevisi->CurrentValue = HtmlDecode($this->estetikarevisi->CurrentValue);
        }
        $this->estetikarevisi->EditValue = $this->estetikarevisi->CurrentValue;
        $this->estetikarevisi->PlaceHolder = RemoveHtml($this->estetikarevisi->caption());

        // aplikasiawalok
        $this->aplikasiawalok->EditCustomAttributes = "";
        $this->aplikasiawalok->EditValue = $this->aplikasiawalok->options(false);
        $this->aplikasiawalok->PlaceHolder = RemoveHtml($this->aplikasiawalok->caption());

        // aplikasiawalrevisi
        $this->aplikasiawalrevisi->EditAttrs["class"] = "form-control";
        $this->aplikasiawalrevisi->EditCustomAttributes = "";
        if (!$this->aplikasiawalrevisi->Raw) {
            $this->aplikasiawalrevisi->CurrentValue = HtmlDecode($this->aplikasiawalrevisi->CurrentValue);
        }
        $this->aplikasiawalrevisi->EditValue = $this->aplikasiawalrevisi->CurrentValue;
        $this->aplikasiawalrevisi->PlaceHolder = RemoveHtml($this->aplikasiawalrevisi->caption());

        // aplikasilamaok
        $this->aplikasilamaok->EditCustomAttributes = "";
        $this->aplikasilamaok->EditValue = $this->aplikasilamaok->options(false);
        $this->aplikasilamaok->PlaceHolder = RemoveHtml($this->aplikasilamaok->caption());

        // aplikasilamarevisi
        $this->aplikasilamarevisi->EditAttrs["class"] = "form-control";
        $this->aplikasilamarevisi->EditCustomAttributes = "";
        if (!$this->aplikasilamarevisi->Raw) {
            $this->aplikasilamarevisi->CurrentValue = HtmlDecode($this->aplikasilamarevisi->CurrentValue);
        }
        $this->aplikasilamarevisi->EditValue = $this->aplikasilamarevisi->CurrentValue;
        $this->aplikasilamarevisi->PlaceHolder = RemoveHtml($this->aplikasilamarevisi->caption());

        // efekpositifok
        $this->efekpositifok->EditCustomAttributes = "";
        $this->efekpositifok->EditValue = $this->efekpositifok->options(false);
        $this->efekpositifok->PlaceHolder = RemoveHtml($this->efekpositifok->caption());

        // efekpositifrevisi
        $this->efekpositifrevisi->EditAttrs["class"] = "form-control";
        $this->efekpositifrevisi->EditCustomAttributes = "";
        if (!$this->efekpositifrevisi->Raw) {
            $this->efekpositifrevisi->CurrentValue = HtmlDecode($this->efekpositifrevisi->CurrentValue);
        }
        $this->efekpositifrevisi->EditValue = $this->efekpositifrevisi->CurrentValue;
        $this->efekpositifrevisi->PlaceHolder = RemoveHtml($this->efekpositifrevisi->caption());

        // efeknegatifok
        $this->efeknegatifok->EditCustomAttributes = "";
        $this->efeknegatifok->EditValue = $this->efeknegatifok->options(false);
        $this->efeknegatifok->PlaceHolder = RemoveHtml($this->efeknegatifok->caption());

        // efeknegatifrevisi
        $this->efeknegatifrevisi->EditAttrs["class"] = "form-control";
        $this->efeknegatifrevisi->EditCustomAttributes = "";
        if (!$this->efeknegatifrevisi->Raw) {
            $this->efeknegatifrevisi->CurrentValue = HtmlDecode($this->efeknegatifrevisi->CurrentValue);
        }
        $this->efeknegatifrevisi->EditValue = $this->efeknegatifrevisi->CurrentValue;
        $this->efeknegatifrevisi->PlaceHolder = RemoveHtml($this->efeknegatifrevisi->caption());

        // kesimpulan
        $this->kesimpulan->EditAttrs["class"] = "form-control";
        $this->kesimpulan->EditCustomAttributes = "";
        $this->kesimpulan->EditValue = $this->kesimpulan->CurrentValue;
        $this->kesimpulan->PlaceHolder = RemoveHtml($this->kesimpulan->caption());

        // status
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(false);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

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
                    $doc->exportCaption($this->idnpd_sample);
                    $doc->exportCaption($this->tglreview);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->wadah);
                    $doc->exportCaption($this->bentukok);
                    $doc->exportCaption($this->bentukrevisi);
                    $doc->exportCaption($this->viskositasok);
                    $doc->exportCaption($this->viskositasrevisi);
                    $doc->exportCaption($this->jeniswarnaok);
                    $doc->exportCaption($this->jeniswarnarevisi);
                    $doc->exportCaption($this->tonewarnaok);
                    $doc->exportCaption($this->tonewarnarevisi);
                    $doc->exportCaption($this->gradasiwarnaok);
                    $doc->exportCaption($this->gradasiwarnarevisi);
                    $doc->exportCaption($this->bauok);
                    $doc->exportCaption($this->baurevisi);
                    $doc->exportCaption($this->estetikaok);
                    $doc->exportCaption($this->estetikarevisi);
                    $doc->exportCaption($this->aplikasiawalok);
                    $doc->exportCaption($this->aplikasiawalrevisi);
                    $doc->exportCaption($this->aplikasilamaok);
                    $doc->exportCaption($this->aplikasilamarevisi);
                    $doc->exportCaption($this->efekpositifok);
                    $doc->exportCaption($this->efekpositifrevisi);
                    $doc->exportCaption($this->efeknegatifok);
                    $doc->exportCaption($this->efeknegatifrevisi);
                    $doc->exportCaption($this->kesimpulan);
                    $doc->exportCaption($this->status);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->idnpd_sample);
                    $doc->exportCaption($this->tglreview);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->wadah);
                    $doc->exportCaption($this->bentukok);
                    $doc->exportCaption($this->bentukrevisi);
                    $doc->exportCaption($this->viskositasok);
                    $doc->exportCaption($this->viskositasrevisi);
                    $doc->exportCaption($this->jeniswarnaok);
                    $doc->exportCaption($this->jeniswarnarevisi);
                    $doc->exportCaption($this->tonewarnaok);
                    $doc->exportCaption($this->tonewarnarevisi);
                    $doc->exportCaption($this->gradasiwarnaok);
                    $doc->exportCaption($this->gradasiwarnarevisi);
                    $doc->exportCaption($this->bauok);
                    $doc->exportCaption($this->baurevisi);
                    $doc->exportCaption($this->estetikaok);
                    $doc->exportCaption($this->estetikarevisi);
                    $doc->exportCaption($this->aplikasiawalok);
                    $doc->exportCaption($this->aplikasiawalrevisi);
                    $doc->exportCaption($this->aplikasilamaok);
                    $doc->exportCaption($this->aplikasilamarevisi);
                    $doc->exportCaption($this->efekpositifok);
                    $doc->exportCaption($this->efekpositifrevisi);
                    $doc->exportCaption($this->efeknegatifok);
                    $doc->exportCaption($this->efeknegatifrevisi);
                    $doc->exportCaption($this->kesimpulan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->created_by);
                    $doc->exportCaption($this->readonly);
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
                        $doc->exportField($this->idnpd_sample);
                        $doc->exportField($this->tglreview);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->wadah);
                        $doc->exportField($this->bentukok);
                        $doc->exportField($this->bentukrevisi);
                        $doc->exportField($this->viskositasok);
                        $doc->exportField($this->viskositasrevisi);
                        $doc->exportField($this->jeniswarnaok);
                        $doc->exportField($this->jeniswarnarevisi);
                        $doc->exportField($this->tonewarnaok);
                        $doc->exportField($this->tonewarnarevisi);
                        $doc->exportField($this->gradasiwarnaok);
                        $doc->exportField($this->gradasiwarnarevisi);
                        $doc->exportField($this->bauok);
                        $doc->exportField($this->baurevisi);
                        $doc->exportField($this->estetikaok);
                        $doc->exportField($this->estetikarevisi);
                        $doc->exportField($this->aplikasiawalok);
                        $doc->exportField($this->aplikasiawalrevisi);
                        $doc->exportField($this->aplikasilamaok);
                        $doc->exportField($this->aplikasilamarevisi);
                        $doc->exportField($this->efekpositifok);
                        $doc->exportField($this->efekpositifrevisi);
                        $doc->exportField($this->efeknegatifok);
                        $doc->exportField($this->efeknegatifrevisi);
                        $doc->exportField($this->kesimpulan);
                        $doc->exportField($this->status);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->idnpd_sample);
                        $doc->exportField($this->tglreview);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->wadah);
                        $doc->exportField($this->bentukok);
                        $doc->exportField($this->bentukrevisi);
                        $doc->exportField($this->viskositasok);
                        $doc->exportField($this->viskositasrevisi);
                        $doc->exportField($this->jeniswarnaok);
                        $doc->exportField($this->jeniswarnarevisi);
                        $doc->exportField($this->tonewarnaok);
                        $doc->exportField($this->tonewarnarevisi);
                        $doc->exportField($this->gradasiwarnaok);
                        $doc->exportField($this->gradasiwarnarevisi);
                        $doc->exportField($this->bauok);
                        $doc->exportField($this->baurevisi);
                        $doc->exportField($this->estetikaok);
                        $doc->exportField($this->estetikarevisi);
                        $doc->exportField($this->aplikasiawalok);
                        $doc->exportField($this->aplikasiawalrevisi);
                        $doc->exportField($this->aplikasilamaok);
                        $doc->exportField($this->aplikasilamarevisi);
                        $doc->exportField($this->efekpositifok);
                        $doc->exportField($this->efekpositifrevisi);
                        $doc->exportField($this->efeknegatifok);
                        $doc->exportField($this->efeknegatifrevisi);
                        $doc->exportField($this->kesimpulan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->created_by);
                        $doc->exportField($this->readonly);
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
        $sql = "SELECT " . $masterfld->Expression . " FROM `npd_review`";
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
        if ($currentMasterTable == "npd") {
            $filterWrk = Container("npd")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "npd") {
            $mastertable = Container("npd");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->idnpd, $mastertable->id);
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
        $status = ($rsnew['status'] == 1) ? 1 : -1;
        $myResult = ExecuteUpdate("UPDATE npd_sample SET `status`=".$status.", readonly=1 WHERE id=".$rsnew['idnpd_sample']);
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
        $idst = ExecuteScalar("SELECT idserahterima FROM npd_sample WHERE id=".$rsnew['idnpd_sample']);
        $updatest = ExecuteUpdate("UPDATE serahterima SET readonly=1 WHERE id=".$idst);
        updateStatus("npd", $rsnew['idnpd']);
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        $status = ($rsnew['status'] == 1) ? 1 : -1;
        $myResult = ExecuteUpdate("UPDATE npd_sample SET `status`=".$status." WHERE id=".$rsold['idnpd_sample']);
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
        updateStatus("npd", $rsold['idnpd']);
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
        $myResult = ExecuteUpdate("UPDATE npd_sample SET `status`=0, readonly=0 WHERE id=".$rs['idnpd_sample']);
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    	$idst = ExecuteScalar("SELECT idserahterima FROM npd_sample WHERE id=".$rs['idnpd_sample']);
    	$count = ExecuteScalar("SELECT COUNT(*) FROM npd_sample WHERE readonly=1 AND idserahterima=".$idst);
        $updatest = ExecuteUpdate("UPDATE serahterima SET readonly=".($count > 1 ? 1 : 0)." WHERE id=".$idst);
        updateStatus("npd", $rs['idnpd']);
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
