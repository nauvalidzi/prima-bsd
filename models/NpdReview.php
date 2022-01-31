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
    public $tanggal_review;
    public $tanggal_submit;
    public $ukuran;
    public $wadah;
    public $bentuk_opsi;
    public $bentuk_revisi;
    public $viskositas_opsi;
    public $viskositas_revisi;
    public $jeniswarna_opsi;
    public $jeniswarna_revisi;
    public $tonewarna_opsi;
    public $tonewarna_revisi;
    public $gradasiwarna_opsi;
    public $gradasiwarna_revisi;
    public $bauparfum_opsi;
    public $bauparfum_revisi;
    public $estetika_opsi;
    public $estetika_revisi;
    public $aplikasiawal_opsi;
    public $aplikasiawal_revisi;
    public $aplikasilama_opsi;
    public $aplikasilama_revisi;
    public $efekpositif_opsi;
    public $efekpositif_revisi;
    public $efeknegatif_opsi;
    public $efeknegatif_revisi;
    public $kesimpulan;
    public $status;
    public $created_at;
    public $readonly;
    public $review_by;

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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('npd_review', 'npd_review', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('npd_review', 'npd_review', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 20, 20, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd->IsForeignKey = true; // Foreign key field
        $this->idnpd->Nullable = false; // NOT NULL field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idnpd->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","","",""], [], ["x_idnpd_sample"], [], [], [], [], '', '');
                break;
            default:
                $this->idnpd->Lookup = new Lookup('idnpd', 'npd', false, 'id', ["kodeorder","","",""], [], ["x_idnpd_sample"], [], [], [], [], '', '');
                break;
        }
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // idnpd_sample
        $this->idnpd_sample = new DbField('npd_review', 'npd_review', 'x_idnpd_sample', 'idnpd_sample', '`idnpd_sample`', '`idnpd_sample`', 20, 20, -1, false, '`idnpd_sample`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd_sample->Nullable = false; // NOT NULL field
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

        // tanggal_review
        $this->tanggal_review = new DbField('npd_review', 'npd_review', 'x_tanggal_review', 'tanggal_review', '`tanggal_review`', CastDateFieldForLike("`tanggal_review`", 0, "DB"), 135, 19, 0, false, '`tanggal_review`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_review->Nullable = false; // NOT NULL field
        $this->tanggal_review->Required = true; // Required field
        $this->tanggal_review->Sortable = true; // Allow sort
        $this->tanggal_review->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_review->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_review->Param, "CustomMsg");
        $this->Fields['tanggal_review'] = &$this->tanggal_review;

        // tanggal_submit
        $this->tanggal_submit = new DbField('npd_review', 'npd_review', 'x_tanggal_submit', 'tanggal_submit', '`tanggal_submit`', CastDateFieldForLike("`tanggal_submit`", 0, "DB"), 135, 19, 0, false, '`tanggal_submit`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_submit->Nullable = false; // NOT NULL field
        $this->tanggal_submit->Required = true; // Required field
        $this->tanggal_submit->Sortable = true; // Allow sort
        $this->tanggal_submit->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_submit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_submit->Param, "CustomMsg");
        $this->Fields['tanggal_submit'] = &$this->tanggal_submit;

        // ukuran
        $this->ukuran = new DbField('npd_review', 'npd_review', 'x_ukuran', 'ukuran', '`ukuran`', '`ukuran`', 200, 50, -1, false, '`ukuran`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran->Sortable = true; // Allow sort
        $this->ukuran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran->Param, "CustomMsg");
        $this->Fields['ukuran'] = &$this->ukuran;

        // wadah
        $this->wadah = new DbField('npd_review', 'npd_review', 'x_wadah', 'wadah', '`wadah`', '`wadah`', 200, 50, -1, false, '`wadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->wadah->Sortable = true; // Allow sort
        $this->wadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->wadah->Param, "CustomMsg");
        $this->Fields['wadah'] = &$this->wadah;

        // bentuk_opsi
        $this->bentuk_opsi = new DbField('npd_review', 'npd_review', 'x_bentuk_opsi', 'bentuk_opsi', '`bentuk_opsi`', '`bentuk_opsi`', 16, 1, -1, false, '`bentuk_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->bentuk_opsi->Nullable = false; // NOT NULL field
        $this->bentuk_opsi->Required = true; // Required field
        $this->bentuk_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->bentuk_opsi->Lookup = new Lookup('bentuk_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->bentuk_opsi->Lookup = new Lookup('bentuk_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->bentuk_opsi->OptionCount = 3;
        $this->bentuk_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->bentuk_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentuk_opsi->Param, "CustomMsg");
        $this->Fields['bentuk_opsi'] = &$this->bentuk_opsi;

        // bentuk_revisi
        $this->bentuk_revisi = new DbField('npd_review', 'npd_review', 'x_bentuk_revisi', 'bentuk_revisi', '`bentuk_revisi`', '`bentuk_revisi`', 200, 255, -1, false, '`bentuk_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bentuk_revisi->Sortable = true; // Allow sort
        $this->bentuk_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentuk_revisi->Param, "CustomMsg");
        $this->Fields['bentuk_revisi'] = &$this->bentuk_revisi;

        // viskositas_opsi
        $this->viskositas_opsi = new DbField('npd_review', 'npd_review', 'x_viskositas_opsi', 'viskositas_opsi', '`viskositas_opsi`', '`viskositas_opsi`', 16, 1, -1, false, '`viskositas_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->viskositas_opsi->Nullable = false; // NOT NULL field
        $this->viskositas_opsi->Required = true; // Required field
        $this->viskositas_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->viskositas_opsi->Lookup = new Lookup('viskositas_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->viskositas_opsi->Lookup = new Lookup('viskositas_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->viskositas_opsi->OptionCount = 3;
        $this->viskositas_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->viskositas_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->viskositas_opsi->Param, "CustomMsg");
        $this->Fields['viskositas_opsi'] = &$this->viskositas_opsi;

        // viskositas_revisi
        $this->viskositas_revisi = new DbField('npd_review', 'npd_review', 'x_viskositas_revisi', 'viskositas_revisi', '`viskositas_revisi`', '`viskositas_revisi`', 200, 255, -1, false, '`viskositas_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->viskositas_revisi->Sortable = true; // Allow sort
        $this->viskositas_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->viskositas_revisi->Param, "CustomMsg");
        $this->Fields['viskositas_revisi'] = &$this->viskositas_revisi;

        // jeniswarna_opsi
        $this->jeniswarna_opsi = new DbField('npd_review', 'npd_review', 'x_jeniswarna_opsi', 'jeniswarna_opsi', '`jeniswarna_opsi`', '`jeniswarna_opsi`', 16, 1, -1, false, '`jeniswarna_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->jeniswarna_opsi->Nullable = false; // NOT NULL field
        $this->jeniswarna_opsi->Required = true; // Required field
        $this->jeniswarna_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->jeniswarna_opsi->Lookup = new Lookup('jeniswarna_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->jeniswarna_opsi->Lookup = new Lookup('jeniswarna_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->jeniswarna_opsi->OptionCount = 3;
        $this->jeniswarna_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->jeniswarna_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jeniswarna_opsi->Param, "CustomMsg");
        $this->Fields['jeniswarna_opsi'] = &$this->jeniswarna_opsi;

        // jeniswarna_revisi
        $this->jeniswarna_revisi = new DbField('npd_review', 'npd_review', 'x_jeniswarna_revisi', 'jeniswarna_revisi', '`jeniswarna_revisi`', '`jeniswarna_revisi`', 200, 255, -1, false, '`jeniswarna_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jeniswarna_revisi->Sortable = true; // Allow sort
        $this->jeniswarna_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jeniswarna_revisi->Param, "CustomMsg");
        $this->Fields['jeniswarna_revisi'] = &$this->jeniswarna_revisi;

        // tonewarna_opsi
        $this->tonewarna_opsi = new DbField('npd_review', 'npd_review', 'x_tonewarna_opsi', 'tonewarna_opsi', '`tonewarna_opsi`', '`tonewarna_opsi`', 16, 1, -1, false, '`tonewarna_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->tonewarna_opsi->Nullable = false; // NOT NULL field
        $this->tonewarna_opsi->Required = true; // Required field
        $this->tonewarna_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->tonewarna_opsi->Lookup = new Lookup('tonewarna_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->tonewarna_opsi->Lookup = new Lookup('tonewarna_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->tonewarna_opsi->OptionCount = 3;
        $this->tonewarna_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->tonewarna_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tonewarna_opsi->Param, "CustomMsg");
        $this->Fields['tonewarna_opsi'] = &$this->tonewarna_opsi;

        // tonewarna_revisi
        $this->tonewarna_revisi = new DbField('npd_review', 'npd_review', 'x_tonewarna_revisi', 'tonewarna_revisi', '`tonewarna_revisi`', '`tonewarna_revisi`', 200, 255, -1, false, '`tonewarna_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tonewarna_revisi->Sortable = true; // Allow sort
        $this->tonewarna_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tonewarna_revisi->Param, "CustomMsg");
        $this->Fields['tonewarna_revisi'] = &$this->tonewarna_revisi;

        // gradasiwarna_opsi
        $this->gradasiwarna_opsi = new DbField('npd_review', 'npd_review', 'x_gradasiwarna_opsi', 'gradasiwarna_opsi', '`gradasiwarna_opsi`', '`gradasiwarna_opsi`', 16, 1, -1, false, '`gradasiwarna_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->gradasiwarna_opsi->Nullable = false; // NOT NULL field
        $this->gradasiwarna_opsi->Required = true; // Required field
        $this->gradasiwarna_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->gradasiwarna_opsi->Lookup = new Lookup('gradasiwarna_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->gradasiwarna_opsi->Lookup = new Lookup('gradasiwarna_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->gradasiwarna_opsi->OptionCount = 3;
        $this->gradasiwarna_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->gradasiwarna_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gradasiwarna_opsi->Param, "CustomMsg");
        $this->Fields['gradasiwarna_opsi'] = &$this->gradasiwarna_opsi;

        // gradasiwarna_revisi
        $this->gradasiwarna_revisi = new DbField('npd_review', 'npd_review', 'x_gradasiwarna_revisi', 'gradasiwarna_revisi', '`gradasiwarna_revisi`', '`gradasiwarna_revisi`', 200, 255, -1, false, '`gradasiwarna_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->gradasiwarna_revisi->Sortable = true; // Allow sort
        $this->gradasiwarna_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gradasiwarna_revisi->Param, "CustomMsg");
        $this->Fields['gradasiwarna_revisi'] = &$this->gradasiwarna_revisi;

        // bauparfum_opsi
        $this->bauparfum_opsi = new DbField('npd_review', 'npd_review', 'x_bauparfum_opsi', 'bauparfum_opsi', '`bauparfum_opsi`', '`bauparfum_opsi`', 16, 1, -1, false, '`bauparfum_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->bauparfum_opsi->Nullable = false; // NOT NULL field
        $this->bauparfum_opsi->Required = true; // Required field
        $this->bauparfum_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->bauparfum_opsi->Lookup = new Lookup('bauparfum_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->bauparfum_opsi->Lookup = new Lookup('bauparfum_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->bauparfum_opsi->OptionCount = 3;
        $this->bauparfum_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->bauparfum_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bauparfum_opsi->Param, "CustomMsg");
        $this->Fields['bauparfum_opsi'] = &$this->bauparfum_opsi;

        // bauparfum_revisi
        $this->bauparfum_revisi = new DbField('npd_review', 'npd_review', 'x_bauparfum_revisi', 'bauparfum_revisi', '`bauparfum_revisi`', '`bauparfum_revisi`', 200, 255, -1, false, '`bauparfum_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bauparfum_revisi->Sortable = true; // Allow sort
        $this->bauparfum_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bauparfum_revisi->Param, "CustomMsg");
        $this->Fields['bauparfum_revisi'] = &$this->bauparfum_revisi;

        // estetika_opsi
        $this->estetika_opsi = new DbField('npd_review', 'npd_review', 'x_estetika_opsi', 'estetika_opsi', '`estetika_opsi`', '`estetika_opsi`', 16, 1, -1, false, '`estetika_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->estetika_opsi->Nullable = false; // NOT NULL field
        $this->estetika_opsi->Required = true; // Required field
        $this->estetika_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->estetika_opsi->Lookup = new Lookup('estetika_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->estetika_opsi->Lookup = new Lookup('estetika_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->estetika_opsi->OptionCount = 3;
        $this->estetika_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->estetika_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->estetika_opsi->Param, "CustomMsg");
        $this->Fields['estetika_opsi'] = &$this->estetika_opsi;

        // estetika_revisi
        $this->estetika_revisi = new DbField('npd_review', 'npd_review', 'x_estetika_revisi', 'estetika_revisi', '`estetika_revisi`', '`estetika_revisi`', 200, 255, -1, false, '`estetika_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->estetika_revisi->Sortable = true; // Allow sort
        $this->estetika_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->estetika_revisi->Param, "CustomMsg");
        $this->Fields['estetika_revisi'] = &$this->estetika_revisi;

        // aplikasiawal_opsi
        $this->aplikasiawal_opsi = new DbField('npd_review', 'npd_review', 'x_aplikasiawal_opsi', 'aplikasiawal_opsi', '`aplikasiawal_opsi`', '`aplikasiawal_opsi`', 16, 1, -1, false, '`aplikasiawal_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aplikasiawal_opsi->Nullable = false; // NOT NULL field
        $this->aplikasiawal_opsi->Required = true; // Required field
        $this->aplikasiawal_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasiawal_opsi->Lookup = new Lookup('aplikasiawal_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasiawal_opsi->Lookup = new Lookup('aplikasiawal_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasiawal_opsi->OptionCount = 3;
        $this->aplikasiawal_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->aplikasiawal_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasiawal_opsi->Param, "CustomMsg");
        $this->Fields['aplikasiawal_opsi'] = &$this->aplikasiawal_opsi;

        // aplikasiawal_revisi
        $this->aplikasiawal_revisi = new DbField('npd_review', 'npd_review', 'x_aplikasiawal_revisi', 'aplikasiawal_revisi', '`aplikasiawal_revisi`', '`aplikasiawal_revisi`', 200, 255, -1, false, '`aplikasiawal_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasiawal_revisi->Sortable = true; // Allow sort
        $this->aplikasiawal_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasiawal_revisi->Param, "CustomMsg");
        $this->Fields['aplikasiawal_revisi'] = &$this->aplikasiawal_revisi;

        // aplikasilama_opsi
        $this->aplikasilama_opsi = new DbField('npd_review', 'npd_review', 'x_aplikasilama_opsi', 'aplikasilama_opsi', '`aplikasilama_opsi`', '`aplikasilama_opsi`', 16, 1, -1, false, '`aplikasilama_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aplikasilama_opsi->Nullable = false; // NOT NULL field
        $this->aplikasilama_opsi->Required = true; // Required field
        $this->aplikasilama_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasilama_opsi->Lookup = new Lookup('aplikasilama_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasilama_opsi->Lookup = new Lookup('aplikasilama_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasilama_opsi->OptionCount = 3;
        $this->aplikasilama_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->aplikasilama_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasilama_opsi->Param, "CustomMsg");
        $this->Fields['aplikasilama_opsi'] = &$this->aplikasilama_opsi;

        // aplikasilama_revisi
        $this->aplikasilama_revisi = new DbField('npd_review', 'npd_review', 'x_aplikasilama_revisi', 'aplikasilama_revisi', '`aplikasilama_revisi`', '`aplikasilama_revisi`', 200, 255, -1, false, '`aplikasilama_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasilama_revisi->Sortable = true; // Allow sort
        $this->aplikasilama_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasilama_revisi->Param, "CustomMsg");
        $this->Fields['aplikasilama_revisi'] = &$this->aplikasilama_revisi;

        // efekpositif_opsi
        $this->efekpositif_opsi = new DbField('npd_review', 'npd_review', 'x_efekpositif_opsi', 'efekpositif_opsi', '`efekpositif_opsi`', '`efekpositif_opsi`', 16, 1, -1, false, '`efekpositif_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->efekpositif_opsi->Nullable = false; // NOT NULL field
        $this->efekpositif_opsi->Required = true; // Required field
        $this->efekpositif_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->efekpositif_opsi->Lookup = new Lookup('efekpositif_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->efekpositif_opsi->Lookup = new Lookup('efekpositif_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->efekpositif_opsi->OptionCount = 3;
        $this->efekpositif_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->efekpositif_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efekpositif_opsi->Param, "CustomMsg");
        $this->Fields['efekpositif_opsi'] = &$this->efekpositif_opsi;

        // efekpositif_revisi
        $this->efekpositif_revisi = new DbField('npd_review', 'npd_review', 'x_efekpositif_revisi', 'efekpositif_revisi', '`efekpositif_revisi`', '`efekpositif_revisi`', 200, 255, -1, false, '`efekpositif_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->efekpositif_revisi->Sortable = true; // Allow sort
        $this->efekpositif_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efekpositif_revisi->Param, "CustomMsg");
        $this->Fields['efekpositif_revisi'] = &$this->efekpositif_revisi;

        // efeknegatif_opsi
        $this->efeknegatif_opsi = new DbField('npd_review', 'npd_review', 'x_efeknegatif_opsi', 'efeknegatif_opsi', '`efeknegatif_opsi`', '`efeknegatif_opsi`', 16, 1, -1, false, '`efeknegatif_opsi`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->efeknegatif_opsi->Nullable = false; // NOT NULL field
        $this->efeknegatif_opsi->Required = true; // Required field
        $this->efeknegatif_opsi->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->efeknegatif_opsi->Lookup = new Lookup('efeknegatif_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->efeknegatif_opsi->Lookup = new Lookup('efeknegatif_opsi', 'npd_review', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->efeknegatif_opsi->OptionCount = 3;
        $this->efeknegatif_opsi->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->efeknegatif_opsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efeknegatif_opsi->Param, "CustomMsg");
        $this->Fields['efeknegatif_opsi'] = &$this->efeknegatif_opsi;

        // efeknegatif_revisi
        $this->efeknegatif_revisi = new DbField('npd_review', 'npd_review', 'x_efeknegatif_revisi', 'efeknegatif_revisi', '`efeknegatif_revisi`', '`efeknegatif_revisi`', 200, 255, -1, false, '`efeknegatif_revisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->efeknegatif_revisi->Sortable = true; // Allow sort
        $this->efeknegatif_revisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->efeknegatif_revisi->Param, "CustomMsg");
        $this->Fields['efeknegatif_revisi'] = &$this->efeknegatif_revisi;

        // kesimpulan
        $this->kesimpulan = new DbField('npd_review', 'npd_review', 'x_kesimpulan', 'kesimpulan', '`kesimpulan`', '`kesimpulan`', 201, 65535, -1, false, '`kesimpulan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
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

        // readonly
        $this->readonly = new DbField('npd_review', 'npd_review', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
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

        // review_by
        $this->review_by = new DbField('npd_review', 'npd_review', 'x_review_by', 'review_by', '`review_by`', '`review_by`', 3, 11, -1, false, '`review_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->review_by->Sortable = true; // Allow sort
        $this->review_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->review_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->review_by->Param, "CustomMsg");
        $this->Fields['review_by'] = &$this->review_by;
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
        $this->tanggal_review->DbValue = $row['tanggal_review'];
        $this->tanggal_submit->DbValue = $row['tanggal_submit'];
        $this->ukuran->DbValue = $row['ukuran'];
        $this->wadah->DbValue = $row['wadah'];
        $this->bentuk_opsi->DbValue = $row['bentuk_opsi'];
        $this->bentuk_revisi->DbValue = $row['bentuk_revisi'];
        $this->viskositas_opsi->DbValue = $row['viskositas_opsi'];
        $this->viskositas_revisi->DbValue = $row['viskositas_revisi'];
        $this->jeniswarna_opsi->DbValue = $row['jeniswarna_opsi'];
        $this->jeniswarna_revisi->DbValue = $row['jeniswarna_revisi'];
        $this->tonewarna_opsi->DbValue = $row['tonewarna_opsi'];
        $this->tonewarna_revisi->DbValue = $row['tonewarna_revisi'];
        $this->gradasiwarna_opsi->DbValue = $row['gradasiwarna_opsi'];
        $this->gradasiwarna_revisi->DbValue = $row['gradasiwarna_revisi'];
        $this->bauparfum_opsi->DbValue = $row['bauparfum_opsi'];
        $this->bauparfum_revisi->DbValue = $row['bauparfum_revisi'];
        $this->estetika_opsi->DbValue = $row['estetika_opsi'];
        $this->estetika_revisi->DbValue = $row['estetika_revisi'];
        $this->aplikasiawal_opsi->DbValue = $row['aplikasiawal_opsi'];
        $this->aplikasiawal_revisi->DbValue = $row['aplikasiawal_revisi'];
        $this->aplikasilama_opsi->DbValue = $row['aplikasilama_opsi'];
        $this->aplikasilama_revisi->DbValue = $row['aplikasilama_revisi'];
        $this->efekpositif_opsi->DbValue = $row['efekpositif_opsi'];
        $this->efekpositif_revisi->DbValue = $row['efekpositif_revisi'];
        $this->efeknegatif_opsi->DbValue = $row['efeknegatif_opsi'];
        $this->efeknegatif_revisi->DbValue = $row['efeknegatif_revisi'];
        $this->kesimpulan->DbValue = $row['kesimpulan'];
        $this->status->DbValue = $row['status'];
        $this->created_at->DbValue = $row['created_at'];
        $this->readonly->DbValue = $row['readonly'];
        $this->review_by->DbValue = $row['review_by'];
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
        $this->tanggal_review->setDbValue($row['tanggal_review']);
        $this->tanggal_submit->setDbValue($row['tanggal_submit']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->wadah->setDbValue($row['wadah']);
        $this->bentuk_opsi->setDbValue($row['bentuk_opsi']);
        $this->bentuk_revisi->setDbValue($row['bentuk_revisi']);
        $this->viskositas_opsi->setDbValue($row['viskositas_opsi']);
        $this->viskositas_revisi->setDbValue($row['viskositas_revisi']);
        $this->jeniswarna_opsi->setDbValue($row['jeniswarna_opsi']);
        $this->jeniswarna_revisi->setDbValue($row['jeniswarna_revisi']);
        $this->tonewarna_opsi->setDbValue($row['tonewarna_opsi']);
        $this->tonewarna_revisi->setDbValue($row['tonewarna_revisi']);
        $this->gradasiwarna_opsi->setDbValue($row['gradasiwarna_opsi']);
        $this->gradasiwarna_revisi->setDbValue($row['gradasiwarna_revisi']);
        $this->bauparfum_opsi->setDbValue($row['bauparfum_opsi']);
        $this->bauparfum_revisi->setDbValue($row['bauparfum_revisi']);
        $this->estetika_opsi->setDbValue($row['estetika_opsi']);
        $this->estetika_revisi->setDbValue($row['estetika_revisi']);
        $this->aplikasiawal_opsi->setDbValue($row['aplikasiawal_opsi']);
        $this->aplikasiawal_revisi->setDbValue($row['aplikasiawal_revisi']);
        $this->aplikasilama_opsi->setDbValue($row['aplikasilama_opsi']);
        $this->aplikasilama_revisi->setDbValue($row['aplikasilama_revisi']);
        $this->efekpositif_opsi->setDbValue($row['efekpositif_opsi']);
        $this->efekpositif_revisi->setDbValue($row['efekpositif_revisi']);
        $this->efeknegatif_opsi->setDbValue($row['efeknegatif_opsi']);
        $this->efeknegatif_revisi->setDbValue($row['efeknegatif_revisi']);
        $this->kesimpulan->setDbValue($row['kesimpulan']);
        $this->status->setDbValue($row['status']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->review_by->setDbValue($row['review_by']);
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

        // tanggal_review

        // tanggal_submit

        // ukuran

        // wadah

        // bentuk_opsi

        // bentuk_revisi

        // viskositas_opsi

        // viskositas_revisi

        // jeniswarna_opsi

        // jeniswarna_revisi

        // tonewarna_opsi

        // tonewarna_revisi

        // gradasiwarna_opsi

        // gradasiwarna_revisi

        // bauparfum_opsi

        // bauparfum_revisi

        // estetika_opsi

        // estetika_revisi

        // aplikasiawal_opsi

        // aplikasiawal_revisi

        // aplikasilama_opsi

        // aplikasilama_revisi

        // efekpositif_opsi

        // efekpositif_revisi

        // efeknegatif_opsi

        // efeknegatif_revisi

        // kesimpulan

        // status

        // created_at

        // readonly

        // review_by

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

        // tanggal_review
        $this->tanggal_review->ViewValue = $this->tanggal_review->CurrentValue;
        $this->tanggal_review->ViewValue = FormatDateTime($this->tanggal_review->ViewValue, 0);
        $this->tanggal_review->ViewCustomAttributes = "";

        // tanggal_submit
        $this->tanggal_submit->ViewValue = $this->tanggal_submit->CurrentValue;
        $this->tanggal_submit->ViewValue = FormatDateTime($this->tanggal_submit->ViewValue, 0);
        $this->tanggal_submit->ViewCustomAttributes = "";

        // ukuran
        $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
        $this->ukuran->ViewCustomAttributes = "";

        // wadah
        $this->wadah->ViewValue = $this->wadah->CurrentValue;
        $this->wadah->ViewCustomAttributes = "";

        // bentuk_opsi
        if (strval($this->bentuk_opsi->CurrentValue) != "") {
            $this->bentuk_opsi->ViewValue = $this->bentuk_opsi->optionCaption($this->bentuk_opsi->CurrentValue);
        } else {
            $this->bentuk_opsi->ViewValue = null;
        }
        $this->bentuk_opsi->ViewCustomAttributes = "";

        // bentuk_revisi
        $this->bentuk_revisi->ViewValue = $this->bentuk_revisi->CurrentValue;
        $this->bentuk_revisi->ViewCustomAttributes = "";

        // viskositas_opsi
        if (strval($this->viskositas_opsi->CurrentValue) != "") {
            $this->viskositas_opsi->ViewValue = $this->viskositas_opsi->optionCaption($this->viskositas_opsi->CurrentValue);
        } else {
            $this->viskositas_opsi->ViewValue = null;
        }
        $this->viskositas_opsi->ViewCustomAttributes = "";

        // viskositas_revisi
        $this->viskositas_revisi->ViewValue = $this->viskositas_revisi->CurrentValue;
        $this->viskositas_revisi->ViewCustomAttributes = "";

        // jeniswarna_opsi
        if (strval($this->jeniswarna_opsi->CurrentValue) != "") {
            $this->jeniswarna_opsi->ViewValue = $this->jeniswarna_opsi->optionCaption($this->jeniswarna_opsi->CurrentValue);
        } else {
            $this->jeniswarna_opsi->ViewValue = null;
        }
        $this->jeniswarna_opsi->ViewCustomAttributes = "";

        // jeniswarna_revisi
        $this->jeniswarna_revisi->ViewValue = $this->jeniswarna_revisi->CurrentValue;
        $this->jeniswarna_revisi->ViewCustomAttributes = "";

        // tonewarna_opsi
        if (strval($this->tonewarna_opsi->CurrentValue) != "") {
            $this->tonewarna_opsi->ViewValue = $this->tonewarna_opsi->optionCaption($this->tonewarna_opsi->CurrentValue);
        } else {
            $this->tonewarna_opsi->ViewValue = null;
        }
        $this->tonewarna_opsi->ViewCustomAttributes = "";

        // tonewarna_revisi
        $this->tonewarna_revisi->ViewValue = $this->tonewarna_revisi->CurrentValue;
        $this->tonewarna_revisi->ViewCustomAttributes = "";

        // gradasiwarna_opsi
        if (strval($this->gradasiwarna_opsi->CurrentValue) != "") {
            $this->gradasiwarna_opsi->ViewValue = $this->gradasiwarna_opsi->optionCaption($this->gradasiwarna_opsi->CurrentValue);
        } else {
            $this->gradasiwarna_opsi->ViewValue = null;
        }
        $this->gradasiwarna_opsi->ViewCustomAttributes = "";

        // gradasiwarna_revisi
        $this->gradasiwarna_revisi->ViewValue = $this->gradasiwarna_revisi->CurrentValue;
        $this->gradasiwarna_revisi->ViewCustomAttributes = "";

        // bauparfum_opsi
        if (strval($this->bauparfum_opsi->CurrentValue) != "") {
            $this->bauparfum_opsi->ViewValue = $this->bauparfum_opsi->optionCaption($this->bauparfum_opsi->CurrentValue);
        } else {
            $this->bauparfum_opsi->ViewValue = null;
        }
        $this->bauparfum_opsi->ViewCustomAttributes = "";

        // bauparfum_revisi
        $this->bauparfum_revisi->ViewValue = $this->bauparfum_revisi->CurrentValue;
        $this->bauparfum_revisi->ViewCustomAttributes = "";

        // estetika_opsi
        if (strval($this->estetika_opsi->CurrentValue) != "") {
            $this->estetika_opsi->ViewValue = $this->estetika_opsi->optionCaption($this->estetika_opsi->CurrentValue);
        } else {
            $this->estetika_opsi->ViewValue = null;
        }
        $this->estetika_opsi->ViewCustomAttributes = "";

        // estetika_revisi
        $this->estetika_revisi->ViewValue = $this->estetika_revisi->CurrentValue;
        $this->estetika_revisi->ViewCustomAttributes = "";

        // aplikasiawal_opsi
        if (strval($this->aplikasiawal_opsi->CurrentValue) != "") {
            $this->aplikasiawal_opsi->ViewValue = $this->aplikasiawal_opsi->optionCaption($this->aplikasiawal_opsi->CurrentValue);
        } else {
            $this->aplikasiawal_opsi->ViewValue = null;
        }
        $this->aplikasiawal_opsi->ViewCustomAttributes = "";

        // aplikasiawal_revisi
        $this->aplikasiawal_revisi->ViewValue = $this->aplikasiawal_revisi->CurrentValue;
        $this->aplikasiawal_revisi->ViewCustomAttributes = "";

        // aplikasilama_opsi
        if (strval($this->aplikasilama_opsi->CurrentValue) != "") {
            $this->aplikasilama_opsi->ViewValue = $this->aplikasilama_opsi->optionCaption($this->aplikasilama_opsi->CurrentValue);
        } else {
            $this->aplikasilama_opsi->ViewValue = null;
        }
        $this->aplikasilama_opsi->ViewCustomAttributes = "";

        // aplikasilama_revisi
        $this->aplikasilama_revisi->ViewValue = $this->aplikasilama_revisi->CurrentValue;
        $this->aplikasilama_revisi->ViewCustomAttributes = "";

        // efekpositif_opsi
        if (strval($this->efekpositif_opsi->CurrentValue) != "") {
            $this->efekpositif_opsi->ViewValue = $this->efekpositif_opsi->optionCaption($this->efekpositif_opsi->CurrentValue);
        } else {
            $this->efekpositif_opsi->ViewValue = null;
        }
        $this->efekpositif_opsi->ViewCustomAttributes = "";

        // efekpositif_revisi
        $this->efekpositif_revisi->ViewValue = $this->efekpositif_revisi->CurrentValue;
        $this->efekpositif_revisi->ViewCustomAttributes = "";

        // efeknegatif_opsi
        if (strval($this->efeknegatif_opsi->CurrentValue) != "") {
            $this->efeknegatif_opsi->ViewValue = $this->efeknegatif_opsi->optionCaption($this->efeknegatif_opsi->CurrentValue);
        } else {
            $this->efeknegatif_opsi->ViewValue = null;
        }
        $this->efeknegatif_opsi->ViewCustomAttributes = "";

        // efeknegatif_revisi
        $this->efeknegatif_revisi->ViewValue = $this->efeknegatif_revisi->CurrentValue;
        $this->efeknegatif_revisi->ViewCustomAttributes = "";

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

        // readonly
        if (ConvertToBool($this->readonly->CurrentValue)) {
            $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
        } else {
            $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
        }
        $this->readonly->ViewCustomAttributes = "";

        // review_by
        $this->review_by->ViewValue = $this->review_by->CurrentValue;
        $this->review_by->ViewValue = FormatNumber($this->review_by->ViewValue, 0, -2, -2, -2);
        $this->review_by->ViewCustomAttributes = "";

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

        // tanggal_review
        $this->tanggal_review->LinkCustomAttributes = "";
        $this->tanggal_review->HrefValue = "";
        $this->tanggal_review->TooltipValue = "";

        // tanggal_submit
        $this->tanggal_submit->LinkCustomAttributes = "";
        $this->tanggal_submit->HrefValue = "";
        $this->tanggal_submit->TooltipValue = "";

        // ukuran
        $this->ukuran->LinkCustomAttributes = "";
        $this->ukuran->HrefValue = "";
        $this->ukuran->TooltipValue = "";

        // wadah
        $this->wadah->LinkCustomAttributes = "";
        $this->wadah->HrefValue = "";
        $this->wadah->TooltipValue = "";

        // bentuk_opsi
        $this->bentuk_opsi->LinkCustomAttributes = "";
        $this->bentuk_opsi->HrefValue = "";
        $this->bentuk_opsi->TooltipValue = "";

        // bentuk_revisi
        $this->bentuk_revisi->LinkCustomAttributes = "";
        $this->bentuk_revisi->HrefValue = "";
        $this->bentuk_revisi->TooltipValue = "";

        // viskositas_opsi
        $this->viskositas_opsi->LinkCustomAttributes = "";
        $this->viskositas_opsi->HrefValue = "";
        $this->viskositas_opsi->TooltipValue = "";

        // viskositas_revisi
        $this->viskositas_revisi->LinkCustomAttributes = "";
        $this->viskositas_revisi->HrefValue = "";
        $this->viskositas_revisi->TooltipValue = "";

        // jeniswarna_opsi
        $this->jeniswarna_opsi->LinkCustomAttributes = "";
        $this->jeniswarna_opsi->HrefValue = "";
        $this->jeniswarna_opsi->TooltipValue = "";

        // jeniswarna_revisi
        $this->jeniswarna_revisi->LinkCustomAttributes = "";
        $this->jeniswarna_revisi->HrefValue = "";
        $this->jeniswarna_revisi->TooltipValue = "";

        // tonewarna_opsi
        $this->tonewarna_opsi->LinkCustomAttributes = "";
        $this->tonewarna_opsi->HrefValue = "";
        $this->tonewarna_opsi->TooltipValue = "";

        // tonewarna_revisi
        $this->tonewarna_revisi->LinkCustomAttributes = "";
        $this->tonewarna_revisi->HrefValue = "";
        $this->tonewarna_revisi->TooltipValue = "";

        // gradasiwarna_opsi
        $this->gradasiwarna_opsi->LinkCustomAttributes = "";
        $this->gradasiwarna_opsi->HrefValue = "";
        $this->gradasiwarna_opsi->TooltipValue = "";

        // gradasiwarna_revisi
        $this->gradasiwarna_revisi->LinkCustomAttributes = "";
        $this->gradasiwarna_revisi->HrefValue = "";
        $this->gradasiwarna_revisi->TooltipValue = "";

        // bauparfum_opsi
        $this->bauparfum_opsi->LinkCustomAttributes = "";
        $this->bauparfum_opsi->HrefValue = "";
        $this->bauparfum_opsi->TooltipValue = "";

        // bauparfum_revisi
        $this->bauparfum_revisi->LinkCustomAttributes = "";
        $this->bauparfum_revisi->HrefValue = "";
        $this->bauparfum_revisi->TooltipValue = "";

        // estetika_opsi
        $this->estetika_opsi->LinkCustomAttributes = "";
        $this->estetika_opsi->HrefValue = "";
        $this->estetika_opsi->TooltipValue = "";

        // estetika_revisi
        $this->estetika_revisi->LinkCustomAttributes = "";
        $this->estetika_revisi->HrefValue = "";
        $this->estetika_revisi->TooltipValue = "";

        // aplikasiawal_opsi
        $this->aplikasiawal_opsi->LinkCustomAttributes = "";
        $this->aplikasiawal_opsi->HrefValue = "";
        $this->aplikasiawal_opsi->TooltipValue = "";

        // aplikasiawal_revisi
        $this->aplikasiawal_revisi->LinkCustomAttributes = "";
        $this->aplikasiawal_revisi->HrefValue = "";
        $this->aplikasiawal_revisi->TooltipValue = "";

        // aplikasilama_opsi
        $this->aplikasilama_opsi->LinkCustomAttributes = "";
        $this->aplikasilama_opsi->HrefValue = "";
        $this->aplikasilama_opsi->TooltipValue = "";

        // aplikasilama_revisi
        $this->aplikasilama_revisi->LinkCustomAttributes = "";
        $this->aplikasilama_revisi->HrefValue = "";
        $this->aplikasilama_revisi->TooltipValue = "";

        // efekpositif_opsi
        $this->efekpositif_opsi->LinkCustomAttributes = "";
        $this->efekpositif_opsi->HrefValue = "";
        $this->efekpositif_opsi->TooltipValue = "";

        // efekpositif_revisi
        $this->efekpositif_revisi->LinkCustomAttributes = "";
        $this->efekpositif_revisi->HrefValue = "";
        $this->efekpositif_revisi->TooltipValue = "";

        // efeknegatif_opsi
        $this->efeknegatif_opsi->LinkCustomAttributes = "";
        $this->efeknegatif_opsi->HrefValue = "";
        $this->efeknegatif_opsi->TooltipValue = "";

        // efeknegatif_revisi
        $this->efeknegatif_revisi->LinkCustomAttributes = "";
        $this->efeknegatif_revisi->HrefValue = "";
        $this->efeknegatif_revisi->TooltipValue = "";

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

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

        // review_by
        $this->review_by->LinkCustomAttributes = "";
        $this->review_by->HrefValue = "";
        $this->review_by->TooltipValue = "";

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

        // tanggal_review
        $this->tanggal_review->EditAttrs["class"] = "form-control";
        $this->tanggal_review->EditCustomAttributes = "";
        $this->tanggal_review->EditValue = FormatDateTime($this->tanggal_review->CurrentValue, 8);
        $this->tanggal_review->PlaceHolder = RemoveHtml($this->tanggal_review->caption());

        // tanggal_submit
        $this->tanggal_submit->EditAttrs["class"] = "form-control";
        $this->tanggal_submit->EditCustomAttributes = "";
        $this->tanggal_submit->EditValue = FormatDateTime($this->tanggal_submit->CurrentValue, 8);
        $this->tanggal_submit->PlaceHolder = RemoveHtml($this->tanggal_submit->caption());

        // ukuran
        $this->ukuran->EditAttrs["class"] = "form-control";
        $this->ukuran->EditCustomAttributes = "";
        if (!$this->ukuran->Raw) {
            $this->ukuran->CurrentValue = HtmlDecode($this->ukuran->CurrentValue);
        }
        $this->ukuran->EditValue = $this->ukuran->CurrentValue;
        $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

        // wadah
        $this->wadah->EditAttrs["class"] = "form-control";
        $this->wadah->EditCustomAttributes = "";
        if (!$this->wadah->Raw) {
            $this->wadah->CurrentValue = HtmlDecode($this->wadah->CurrentValue);
        }
        $this->wadah->EditValue = $this->wadah->CurrentValue;
        $this->wadah->PlaceHolder = RemoveHtml($this->wadah->caption());

        // bentuk_opsi
        $this->bentuk_opsi->EditCustomAttributes = "";
        $this->bentuk_opsi->EditValue = $this->bentuk_opsi->options(false);
        $this->bentuk_opsi->PlaceHolder = RemoveHtml($this->bentuk_opsi->caption());

        // bentuk_revisi
        $this->bentuk_revisi->EditAttrs["class"] = "form-control";
        $this->bentuk_revisi->EditCustomAttributes = "";
        if (!$this->bentuk_revisi->Raw) {
            $this->bentuk_revisi->CurrentValue = HtmlDecode($this->bentuk_revisi->CurrentValue);
        }
        $this->bentuk_revisi->EditValue = $this->bentuk_revisi->CurrentValue;
        $this->bentuk_revisi->PlaceHolder = RemoveHtml($this->bentuk_revisi->caption());

        // viskositas_opsi
        $this->viskositas_opsi->EditCustomAttributes = "";
        $this->viskositas_opsi->EditValue = $this->viskositas_opsi->options(false);
        $this->viskositas_opsi->PlaceHolder = RemoveHtml($this->viskositas_opsi->caption());

        // viskositas_revisi
        $this->viskositas_revisi->EditAttrs["class"] = "form-control";
        $this->viskositas_revisi->EditCustomAttributes = "";
        if (!$this->viskositas_revisi->Raw) {
            $this->viskositas_revisi->CurrentValue = HtmlDecode($this->viskositas_revisi->CurrentValue);
        }
        $this->viskositas_revisi->EditValue = $this->viskositas_revisi->CurrentValue;
        $this->viskositas_revisi->PlaceHolder = RemoveHtml($this->viskositas_revisi->caption());

        // jeniswarna_opsi
        $this->jeniswarna_opsi->EditCustomAttributes = "";
        $this->jeniswarna_opsi->EditValue = $this->jeniswarna_opsi->options(false);
        $this->jeniswarna_opsi->PlaceHolder = RemoveHtml($this->jeniswarna_opsi->caption());

        // jeniswarna_revisi
        $this->jeniswarna_revisi->EditAttrs["class"] = "form-control";
        $this->jeniswarna_revisi->EditCustomAttributes = "";
        if (!$this->jeniswarna_revisi->Raw) {
            $this->jeniswarna_revisi->CurrentValue = HtmlDecode($this->jeniswarna_revisi->CurrentValue);
        }
        $this->jeniswarna_revisi->EditValue = $this->jeniswarna_revisi->CurrentValue;
        $this->jeniswarna_revisi->PlaceHolder = RemoveHtml($this->jeniswarna_revisi->caption());

        // tonewarna_opsi
        $this->tonewarna_opsi->EditCustomAttributes = "";
        $this->tonewarna_opsi->EditValue = $this->tonewarna_opsi->options(false);
        $this->tonewarna_opsi->PlaceHolder = RemoveHtml($this->tonewarna_opsi->caption());

        // tonewarna_revisi
        $this->tonewarna_revisi->EditAttrs["class"] = "form-control";
        $this->tonewarna_revisi->EditCustomAttributes = "";
        if (!$this->tonewarna_revisi->Raw) {
            $this->tonewarna_revisi->CurrentValue = HtmlDecode($this->tonewarna_revisi->CurrentValue);
        }
        $this->tonewarna_revisi->EditValue = $this->tonewarna_revisi->CurrentValue;
        $this->tonewarna_revisi->PlaceHolder = RemoveHtml($this->tonewarna_revisi->caption());

        // gradasiwarna_opsi
        $this->gradasiwarna_opsi->EditCustomAttributes = "";
        $this->gradasiwarna_opsi->EditValue = $this->gradasiwarna_opsi->options(false);
        $this->gradasiwarna_opsi->PlaceHolder = RemoveHtml($this->gradasiwarna_opsi->caption());

        // gradasiwarna_revisi
        $this->gradasiwarna_revisi->EditAttrs["class"] = "form-control";
        $this->gradasiwarna_revisi->EditCustomAttributes = "";
        if (!$this->gradasiwarna_revisi->Raw) {
            $this->gradasiwarna_revisi->CurrentValue = HtmlDecode($this->gradasiwarna_revisi->CurrentValue);
        }
        $this->gradasiwarna_revisi->EditValue = $this->gradasiwarna_revisi->CurrentValue;
        $this->gradasiwarna_revisi->PlaceHolder = RemoveHtml($this->gradasiwarna_revisi->caption());

        // bauparfum_opsi
        $this->bauparfum_opsi->EditCustomAttributes = "";
        $this->bauparfum_opsi->EditValue = $this->bauparfum_opsi->options(false);
        $this->bauparfum_opsi->PlaceHolder = RemoveHtml($this->bauparfum_opsi->caption());

        // bauparfum_revisi
        $this->bauparfum_revisi->EditAttrs["class"] = "form-control";
        $this->bauparfum_revisi->EditCustomAttributes = "";
        if (!$this->bauparfum_revisi->Raw) {
            $this->bauparfum_revisi->CurrentValue = HtmlDecode($this->bauparfum_revisi->CurrentValue);
        }
        $this->bauparfum_revisi->EditValue = $this->bauparfum_revisi->CurrentValue;
        $this->bauparfum_revisi->PlaceHolder = RemoveHtml($this->bauparfum_revisi->caption());

        // estetika_opsi
        $this->estetika_opsi->EditCustomAttributes = "";
        $this->estetika_opsi->EditValue = $this->estetika_opsi->options(false);
        $this->estetika_opsi->PlaceHolder = RemoveHtml($this->estetika_opsi->caption());

        // estetika_revisi
        $this->estetika_revisi->EditAttrs["class"] = "form-control";
        $this->estetika_revisi->EditCustomAttributes = "";
        if (!$this->estetika_revisi->Raw) {
            $this->estetika_revisi->CurrentValue = HtmlDecode($this->estetika_revisi->CurrentValue);
        }
        $this->estetika_revisi->EditValue = $this->estetika_revisi->CurrentValue;
        $this->estetika_revisi->PlaceHolder = RemoveHtml($this->estetika_revisi->caption());

        // aplikasiawal_opsi
        $this->aplikasiawal_opsi->EditCustomAttributes = "";
        $this->aplikasiawal_opsi->EditValue = $this->aplikasiawal_opsi->options(false);
        $this->aplikasiawal_opsi->PlaceHolder = RemoveHtml($this->aplikasiawal_opsi->caption());

        // aplikasiawal_revisi
        $this->aplikasiawal_revisi->EditAttrs["class"] = "form-control";
        $this->aplikasiawal_revisi->EditCustomAttributes = "";
        if (!$this->aplikasiawal_revisi->Raw) {
            $this->aplikasiawal_revisi->CurrentValue = HtmlDecode($this->aplikasiawal_revisi->CurrentValue);
        }
        $this->aplikasiawal_revisi->EditValue = $this->aplikasiawal_revisi->CurrentValue;
        $this->aplikasiawal_revisi->PlaceHolder = RemoveHtml($this->aplikasiawal_revisi->caption());

        // aplikasilama_opsi
        $this->aplikasilama_opsi->EditCustomAttributes = "";
        $this->aplikasilama_opsi->EditValue = $this->aplikasilama_opsi->options(false);
        $this->aplikasilama_opsi->PlaceHolder = RemoveHtml($this->aplikasilama_opsi->caption());

        // aplikasilama_revisi
        $this->aplikasilama_revisi->EditAttrs["class"] = "form-control";
        $this->aplikasilama_revisi->EditCustomAttributes = "";
        if (!$this->aplikasilama_revisi->Raw) {
            $this->aplikasilama_revisi->CurrentValue = HtmlDecode($this->aplikasilama_revisi->CurrentValue);
        }
        $this->aplikasilama_revisi->EditValue = $this->aplikasilama_revisi->CurrentValue;
        $this->aplikasilama_revisi->PlaceHolder = RemoveHtml($this->aplikasilama_revisi->caption());

        // efekpositif_opsi
        $this->efekpositif_opsi->EditCustomAttributes = "";
        $this->efekpositif_opsi->EditValue = $this->efekpositif_opsi->options(false);
        $this->efekpositif_opsi->PlaceHolder = RemoveHtml($this->efekpositif_opsi->caption());

        // efekpositif_revisi
        $this->efekpositif_revisi->EditAttrs["class"] = "form-control";
        $this->efekpositif_revisi->EditCustomAttributes = "";
        if (!$this->efekpositif_revisi->Raw) {
            $this->efekpositif_revisi->CurrentValue = HtmlDecode($this->efekpositif_revisi->CurrentValue);
        }
        $this->efekpositif_revisi->EditValue = $this->efekpositif_revisi->CurrentValue;
        $this->efekpositif_revisi->PlaceHolder = RemoveHtml($this->efekpositif_revisi->caption());

        // efeknegatif_opsi
        $this->efeknegatif_opsi->EditCustomAttributes = "";
        $this->efeknegatif_opsi->EditValue = $this->efeknegatif_opsi->options(false);
        $this->efeknegatif_opsi->PlaceHolder = RemoveHtml($this->efeknegatif_opsi->caption());

        // efeknegatif_revisi
        $this->efeknegatif_revisi->EditAttrs["class"] = "form-control";
        $this->efeknegatif_revisi->EditCustomAttributes = "";
        if (!$this->efeknegatif_revisi->Raw) {
            $this->efeknegatif_revisi->CurrentValue = HtmlDecode($this->efeknegatif_revisi->CurrentValue);
        }
        $this->efeknegatif_revisi->EditValue = $this->efeknegatif_revisi->CurrentValue;
        $this->efeknegatif_revisi->PlaceHolder = RemoveHtml($this->efeknegatif_revisi->caption());

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

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

        // review_by
        $this->review_by->EditAttrs["class"] = "form-control";
        $this->review_by->EditCustomAttributes = "";
        $this->review_by->EditValue = $this->review_by->CurrentValue;
        $this->review_by->PlaceHolder = RemoveHtml($this->review_by->caption());

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
                    $doc->exportCaption($this->tanggal_review);
                    $doc->exportCaption($this->tanggal_submit);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->wadah);
                    $doc->exportCaption($this->bentuk_opsi);
                    $doc->exportCaption($this->bentuk_revisi);
                    $doc->exportCaption($this->viskositas_opsi);
                    $doc->exportCaption($this->viskositas_revisi);
                    $doc->exportCaption($this->jeniswarna_opsi);
                    $doc->exportCaption($this->jeniswarna_revisi);
                    $doc->exportCaption($this->tonewarna_opsi);
                    $doc->exportCaption($this->tonewarna_revisi);
                    $doc->exportCaption($this->gradasiwarna_opsi);
                    $doc->exportCaption($this->gradasiwarna_revisi);
                    $doc->exportCaption($this->bauparfum_opsi);
                    $doc->exportCaption($this->bauparfum_revisi);
                    $doc->exportCaption($this->estetika_opsi);
                    $doc->exportCaption($this->estetika_revisi);
                    $doc->exportCaption($this->aplikasiawal_opsi);
                    $doc->exportCaption($this->aplikasiawal_revisi);
                    $doc->exportCaption($this->aplikasilama_opsi);
                    $doc->exportCaption($this->aplikasilama_revisi);
                    $doc->exportCaption($this->efekpositif_opsi);
                    $doc->exportCaption($this->efekpositif_revisi);
                    $doc->exportCaption($this->efeknegatif_opsi);
                    $doc->exportCaption($this->efeknegatif_revisi);
                    $doc->exportCaption($this->kesimpulan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->review_by);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->idnpd_sample);
                    $doc->exportCaption($this->tanggal_review);
                    $doc->exportCaption($this->tanggal_submit);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->wadah);
                    $doc->exportCaption($this->bentuk_opsi);
                    $doc->exportCaption($this->bentuk_revisi);
                    $doc->exportCaption($this->viskositas_opsi);
                    $doc->exportCaption($this->viskositas_revisi);
                    $doc->exportCaption($this->jeniswarna_opsi);
                    $doc->exportCaption($this->jeniswarna_revisi);
                    $doc->exportCaption($this->tonewarna_opsi);
                    $doc->exportCaption($this->tonewarna_revisi);
                    $doc->exportCaption($this->gradasiwarna_opsi);
                    $doc->exportCaption($this->gradasiwarna_revisi);
                    $doc->exportCaption($this->bauparfum_opsi);
                    $doc->exportCaption($this->bauparfum_revisi);
                    $doc->exportCaption($this->estetika_opsi);
                    $doc->exportCaption($this->estetika_revisi);
                    $doc->exportCaption($this->aplikasiawal_opsi);
                    $doc->exportCaption($this->aplikasiawal_revisi);
                    $doc->exportCaption($this->aplikasilama_opsi);
                    $doc->exportCaption($this->aplikasilama_revisi);
                    $doc->exportCaption($this->efekpositif_opsi);
                    $doc->exportCaption($this->efekpositif_revisi);
                    $doc->exportCaption($this->efeknegatif_opsi);
                    $doc->exportCaption($this->efeknegatif_revisi);
                    $doc->exportCaption($this->kesimpulan);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->review_by);
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
                        $doc->exportField($this->tanggal_review);
                        $doc->exportField($this->tanggal_submit);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->wadah);
                        $doc->exportField($this->bentuk_opsi);
                        $doc->exportField($this->bentuk_revisi);
                        $doc->exportField($this->viskositas_opsi);
                        $doc->exportField($this->viskositas_revisi);
                        $doc->exportField($this->jeniswarna_opsi);
                        $doc->exportField($this->jeniswarna_revisi);
                        $doc->exportField($this->tonewarna_opsi);
                        $doc->exportField($this->tonewarna_revisi);
                        $doc->exportField($this->gradasiwarna_opsi);
                        $doc->exportField($this->gradasiwarna_revisi);
                        $doc->exportField($this->bauparfum_opsi);
                        $doc->exportField($this->bauparfum_revisi);
                        $doc->exportField($this->estetika_opsi);
                        $doc->exportField($this->estetika_revisi);
                        $doc->exportField($this->aplikasiawal_opsi);
                        $doc->exportField($this->aplikasiawal_revisi);
                        $doc->exportField($this->aplikasilama_opsi);
                        $doc->exportField($this->aplikasilama_revisi);
                        $doc->exportField($this->efekpositif_opsi);
                        $doc->exportField($this->efekpositif_revisi);
                        $doc->exportField($this->efeknegatif_opsi);
                        $doc->exportField($this->efeknegatif_revisi);
                        $doc->exportField($this->kesimpulan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->review_by);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->idnpd_sample);
                        $doc->exportField($this->tanggal_review);
                        $doc->exportField($this->tanggal_submit);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->wadah);
                        $doc->exportField($this->bentuk_opsi);
                        $doc->exportField($this->bentuk_revisi);
                        $doc->exportField($this->viskositas_opsi);
                        $doc->exportField($this->viskositas_revisi);
                        $doc->exportField($this->jeniswarna_opsi);
                        $doc->exportField($this->jeniswarna_revisi);
                        $doc->exportField($this->tonewarna_opsi);
                        $doc->exportField($this->tonewarna_revisi);
                        $doc->exportField($this->gradasiwarna_opsi);
                        $doc->exportField($this->gradasiwarna_revisi);
                        $doc->exportField($this->bauparfum_opsi);
                        $doc->exportField($this->bauparfum_revisi);
                        $doc->exportField($this->estetika_opsi);
                        $doc->exportField($this->estetika_revisi);
                        $doc->exportField($this->aplikasiawal_opsi);
                        $doc->exportField($this->aplikasiawal_revisi);
                        $doc->exportField($this->aplikasilama_opsi);
                        $doc->exportField($this->aplikasilama_revisi);
                        $doc->exportField($this->efekpositif_opsi);
                        $doc->exportField($this->efekpositif_revisi);
                        $doc->exportField($this->efeknegatif_opsi);
                        $doc->exportField($this->efeknegatif_revisi);
                        $doc->exportField($this->kesimpulan);
                        $doc->exportField($this->status);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->review_by);
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
