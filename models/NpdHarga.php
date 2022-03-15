<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_harga
 */
class NpdHarga extends DbTable
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
    public $tglpengajuan;
    public $idnpd_sample;
    public $nama;
    public $bentuk;
    public $viskositas;
    public $warna;
    public $bauparfum;
    public $aplikasisediaan;
    public $volume;
    public $bahanaktif;
    public $volumewadah;
    public $bahanwadah;
    public $warnawadah;
    public $bentukwadah;
    public $jenistutup;
    public $bahantutup;
    public $warnatutup;
    public $bentuktutup;
    public $segel;
    public $catatanprimer;
    public $packingproduk;
    public $keteranganpacking;
    public $beltkarton;
    public $keteranganbelt;
    public $kartonluar;
    public $bariskarton;
    public $kolomkarton;
    public $stackkarton;
    public $isikarton;
    public $jenislabel;
    public $keteranganjenislabel;
    public $kualitaslabel;
    public $jumlahwarnalabel;
    public $metaliklabel;
    public $etiketlabel;
    public $keteranganlabel;
    public $kategoridelivery;
    public $alamatpengiriman;
    public $orderperdana;
    public $orderkontrak;
    public $hargaperpcs;
    public $hargaperkarton;
    public $lampiran;
    public $prepared_by;
    public $checked_by;
    public $approved_by;
    public $approved_date;
    public $disetujui;
    public $created_at;
    public $readonly;
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
        $this->TableVar = 'npd_harga';
        $this->TableName = 'npd_harga';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_harga`";
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
        $this->id = new DbField('npd_harga', 'npd_harga', 'x_id', 'id', '`id`', '`id`', 20, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('npd_harga', 'npd_harga', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 20, 20, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd->IsForeignKey = true; // Foreign key field
        $this->idnpd->Nullable = false; // NOT NULL field
        $this->idnpd->Required = true; // Required field
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

        // tglpengajuan
        $this->tglpengajuan = new DbField('npd_harga', 'npd_harga', 'x_tglpengajuan', 'tglpengajuan', '`tglpengajuan`', CastDateFieldForLike("`tglpengajuan`", 0, "DB"), 135, 19, 0, false, '`tglpengajuan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglpengajuan->Sortable = true; // Allow sort
        $this->tglpengajuan->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglpengajuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglpengajuan->Param, "CustomMsg");
        $this->Fields['tglpengajuan'] = &$this->tglpengajuan;

        // idnpd_sample
        $this->idnpd_sample = new DbField('npd_harga', 'npd_harga', 'x_idnpd_sample', 'idnpd_sample', '`idnpd_sample`', '`idnpd_sample`', 20, 20, -1, false, '`idnpd_sample`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idnpd_sample->Nullable = false; // NOT NULL field
        $this->idnpd_sample->Required = true; // Required field
        $this->idnpd_sample->Sortable = true; // Allow sort
        $this->idnpd_sample->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idnpd_sample->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idnpd_sample->Lookup = new Lookup('idnpd_sample', 'npd_sample', false, 'id', ["kode","nama","",""], ["x_idnpd"], [], ["idnpd"], ["x_idnpd"], ["sediaan"], ["x_bentuk"], '', '');
                break;
            default:
                $this->idnpd_sample->Lookup = new Lookup('idnpd_sample', 'npd_sample', false, 'id', ["kode","nama","",""], ["x_idnpd"], [], ["idnpd"], ["x_idnpd"], ["sediaan"], ["x_bentuk"], '', '');
                break;
        }
        $this->idnpd_sample->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd_sample->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd_sample->Param, "CustomMsg");
        $this->Fields['idnpd_sample'] = &$this->idnpd_sample;

        // nama
        $this->nama = new DbField('npd_harga', 'npd_harga', 'x_nama', 'nama', '`nama`', '`nama`', 200, 50, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // bentuk
        $this->bentuk = new DbField('npd_harga', 'npd_harga', 'x_bentuk', 'bentuk', '`bentuk`', '`bentuk`', 200, 50, -1, false, '`bentuk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bentuk->Sortable = true; // Allow sort
        $this->bentuk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentuk->Param, "CustomMsg");
        $this->Fields['bentuk'] = &$this->bentuk;

        // viskositas
        $this->viskositas = new DbField('npd_harga', 'npd_harga', 'x_viskositas', 'viskositas', '`viskositas`', '`viskositas`', 200, 50, -1, false, '`viskositas`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->viskositas->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->viskositas->Lookup = new Lookup('viskositas', 'npd_viskositas_sediaan', false, 'id', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->viskositas->Lookup = new Lookup('viskositas', 'npd_viskositas_sediaan', false, 'id', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->viskositas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->viskositas->Param, "CustomMsg");
        $this->Fields['viskositas'] = &$this->viskositas;

        // warna
        $this->warna = new DbField('npd_harga', 'npd_harga', 'x_warna', 'warna', '`warna`', '`warna`', 200, 50, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->warna->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->warna->Lookup = new Lookup('warna', 'npd_warna_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->warna->Lookup = new Lookup('warna', 'npd_warna_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // bauparfum
        $this->bauparfum = new DbField('npd_harga', 'npd_harga', 'x_bauparfum', 'bauparfum', '`bauparfum`', '`bauparfum`', 200, 50, -1, false, '`bauparfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bauparfum->Sortable = true; // Allow sort
        $this->bauparfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bauparfum->Param, "CustomMsg");
        $this->Fields['bauparfum'] = &$this->bauparfum;

        // aplikasisediaan
        $this->aplikasisediaan = new DbField('npd_harga', 'npd_harga', 'x_aplikasisediaan', 'aplikasisediaan', '`aplikasisediaan`', '`aplikasisediaan`', 200, 50, -1, false, '`aplikasisediaan`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->aplikasisediaan->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->aplikasisediaan->Lookup = new Lookup('aplikasisediaan', 'npd_aplikasi_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->aplikasisediaan->Lookup = new Lookup('aplikasisediaan', 'npd_aplikasi_sediaan', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->aplikasisediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasisediaan->Param, "CustomMsg");
        $this->Fields['aplikasisediaan'] = &$this->aplikasisediaan;

        // volume
        $this->volume = new DbField('npd_harga', 'npd_harga', 'x_volume', 'volume', '`volume`', '`volume`', 200, 50, -1, false, '`volume`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->volume->Sortable = true; // Allow sort
        $this->volume->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->volume->Param, "CustomMsg");
        $this->Fields['volume'] = &$this->volume;

        // bahanaktif
        $this->bahanaktif = new DbField('npd_harga', 'npd_harga', 'x_bahanaktif', 'bahanaktif', '`bahanaktif`', '`bahanaktif`', 201, 65535, -1, false, '`bahanaktif`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bahanaktif->Sortable = true; // Allow sort
        $this->bahanaktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahanaktif->Param, "CustomMsg");
        $this->Fields['bahanaktif'] = &$this->bahanaktif;

        // volumewadah
        $this->volumewadah = new DbField('npd_harga', 'npd_harga', 'x_volumewadah', 'volumewadah', '`volumewadah`', '`volumewadah`', 200, 50, -1, false, '`volumewadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->volumewadah->Sortable = true; // Allow sort
        $this->volumewadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->volumewadah->Param, "CustomMsg");
        $this->Fields['volumewadah'] = &$this->volumewadah;

        // bahanwadah
        $this->bahanwadah = new DbField('npd_harga', 'npd_harga', 'x_bahanwadah', 'bahanwadah', '`bahanwadah`', '`bahanwadah`', 200, 50, -1, false, '`bahanwadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahanwadah->Sortable = true; // Allow sort
        $this->bahanwadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahanwadah->Param, "CustomMsg");
        $this->Fields['bahanwadah'] = &$this->bahanwadah;

        // warnawadah
        $this->warnawadah = new DbField('npd_harga', 'npd_harga', 'x_warnawadah', 'warnawadah', '`warnawadah`', '`warnawadah`', 200, 50, -1, false, '`warnawadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warnawadah->Sortable = true; // Allow sort
        $this->warnawadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warnawadah->Param, "CustomMsg");
        $this->Fields['warnawadah'] = &$this->warnawadah;

        // bentukwadah
        $this->bentukwadah = new DbField('npd_harga', 'npd_harga', 'x_bentukwadah', 'bentukwadah', '`bentukwadah`', '`bentukwadah`', 200, 50, -1, false, '`bentukwadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bentukwadah->Sortable = true; // Allow sort
        $this->bentukwadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentukwadah->Param, "CustomMsg");
        $this->Fields['bentukwadah'] = &$this->bentukwadah;

        // jenistutup
        $this->jenistutup = new DbField('npd_harga', 'npd_harga', 'x_jenistutup', 'jenistutup', '`jenistutup`', '`jenistutup`', 200, 50, -1, false, '`jenistutup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jenistutup->Sortable = true; // Allow sort
        $this->jenistutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenistutup->Param, "CustomMsg");
        $this->Fields['jenistutup'] = &$this->jenistutup;

        // bahantutup
        $this->bahantutup = new DbField('npd_harga', 'npd_harga', 'x_bahantutup', 'bahantutup', '`bahantutup`', '`bahantutup`', 200, 50, -1, false, '`bahantutup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahantutup->Sortable = true; // Allow sort
        $this->bahantutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahantutup->Param, "CustomMsg");
        $this->Fields['bahantutup'] = &$this->bahantutup;

        // warnatutup
        $this->warnatutup = new DbField('npd_harga', 'npd_harga', 'x_warnatutup', 'warnatutup', '`warnatutup`', '`warnatutup`', 200, 50, -1, false, '`warnatutup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warnatutup->Sortable = true; // Allow sort
        $this->warnatutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warnatutup->Param, "CustomMsg");
        $this->Fields['warnatutup'] = &$this->warnatutup;

        // bentuktutup
        $this->bentuktutup = new DbField('npd_harga', 'npd_harga', 'x_bentuktutup', 'bentuktutup', '`bentuktutup`', '`bentuktutup`', 200, 50, -1, false, '`bentuktutup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bentuktutup->Sortable = true; // Allow sort
        $this->bentuktutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentuktutup->Param, "CustomMsg");
        $this->Fields['bentuktutup'] = &$this->bentuktutup;

        // segel
        $this->segel = new DbField('npd_harga', 'npd_harga', 'x_segel', 'segel', '`segel`', '`segel`', 16, 1, -1, false, '`segel`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->segel->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->segel->Lookup = new Lookup('segel', 'npd_harga', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->segel->Lookup = new Lookup('segel', 'npd_harga', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->segel->OptionCount = 2;
        $this->segel->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->segel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->segel->Param, "CustomMsg");
        $this->Fields['segel'] = &$this->segel;

        // catatanprimer
        $this->catatanprimer = new DbField('npd_harga', 'npd_harga', 'x_catatanprimer', 'catatanprimer', '`catatanprimer`', '`catatanprimer`', 201, 65535, -1, false, '`catatanprimer`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->catatanprimer->Sortable = true; // Allow sort
        $this->catatanprimer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->catatanprimer->Param, "CustomMsg");
        $this->Fields['catatanprimer'] = &$this->catatanprimer;

        // packingproduk
        $this->packingproduk = new DbField('npd_harga', 'npd_harga', 'x_packingproduk', 'packingproduk', '`packingproduk`', '`packingproduk`', 200, 50, -1, false, '`packingproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->packingproduk->Sortable = true; // Allow sort
        $this->packingproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->packingproduk->Param, "CustomMsg");
        $this->Fields['packingproduk'] = &$this->packingproduk;

        // keteranganpacking
        $this->keteranganpacking = new DbField('npd_harga', 'npd_harga', 'x_keteranganpacking', 'keteranganpacking', '`keteranganpacking`', '`keteranganpacking`', 201, 65535, -1, false, '`keteranganpacking`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keteranganpacking->Sortable = true; // Allow sort
        $this->keteranganpacking->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keteranganpacking->Param, "CustomMsg");
        $this->Fields['keteranganpacking'] = &$this->keteranganpacking;

        // beltkarton
        $this->beltkarton = new DbField('npd_harga', 'npd_harga', 'x_beltkarton', 'beltkarton', '`beltkarton`', '`beltkarton`', 200, 50, -1, false, '`beltkarton`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->beltkarton->Sortable = true; // Allow sort
        $this->beltkarton->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->beltkarton->Param, "CustomMsg");
        $this->Fields['beltkarton'] = &$this->beltkarton;

        // keteranganbelt
        $this->keteranganbelt = new DbField('npd_harga', 'npd_harga', 'x_keteranganbelt', 'keteranganbelt', '`keteranganbelt`', '`keteranganbelt`', 201, 65535, -1, false, '`keteranganbelt`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keteranganbelt->Sortable = true; // Allow sort
        $this->keteranganbelt->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keteranganbelt->Param, "CustomMsg");
        $this->Fields['keteranganbelt'] = &$this->keteranganbelt;

        // kartonluar
        $this->kartonluar = new DbField('npd_harga', 'npd_harga', 'x_kartonluar', 'kartonluar', '`kartonluar`', '`kartonluar`', 200, 50, -1, false, '`kartonluar`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kartonluar->Sortable = true; // Allow sort
        $this->kartonluar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kartonluar->Param, "CustomMsg");
        $this->Fields['kartonluar'] = &$this->kartonluar;

        // bariskarton
        $this->bariskarton = new DbField('npd_harga', 'npd_harga', 'x_bariskarton', 'bariskarton', '`bariskarton`', '`bariskarton`', 200, 50, -1, false, '`bariskarton`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bariskarton->Sortable = true; // Allow sort
        $this->bariskarton->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bariskarton->Param, "CustomMsg");
        $this->Fields['bariskarton'] = &$this->bariskarton;

        // kolomkarton
        $this->kolomkarton = new DbField('npd_harga', 'npd_harga', 'x_kolomkarton', 'kolomkarton', '`kolomkarton`', '`kolomkarton`', 200, 50, -1, false, '`kolomkarton`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kolomkarton->Sortable = true; // Allow sort
        $this->kolomkarton->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kolomkarton->Param, "CustomMsg");
        $this->Fields['kolomkarton'] = &$this->kolomkarton;

        // stackkarton
        $this->stackkarton = new DbField('npd_harga', 'npd_harga', 'x_stackkarton', 'stackkarton', '`stackkarton`', '`stackkarton`', 200, 50, -1, false, '`stackkarton`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->stackkarton->Sortable = true; // Allow sort
        $this->stackkarton->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->stackkarton->Param, "CustomMsg");
        $this->Fields['stackkarton'] = &$this->stackkarton;

        // isikarton
        $this->isikarton = new DbField('npd_harga', 'npd_harga', 'x_isikarton', 'isikarton', '`isikarton`', '`isikarton`', 200, 50, -1, false, '`isikarton`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isikarton->Sortable = true; // Allow sort
        $this->isikarton->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isikarton->Param, "CustomMsg");
        $this->Fields['isikarton'] = &$this->isikarton;

        // jenislabel
        $this->jenislabel = new DbField('npd_harga', 'npd_harga', 'x_jenislabel', 'jenislabel', '`jenislabel`', '`jenislabel`', 200, 50, -1, false, '`jenislabel`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->jenislabel->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->jenislabel->Lookup = new Lookup('jenislabel', 'npd_label_jenis', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->jenislabel->Lookup = new Lookup('jenislabel', 'npd_label_jenis', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->jenislabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenislabel->Param, "CustomMsg");
        $this->Fields['jenislabel'] = &$this->jenislabel;

        // keteranganjenislabel
        $this->keteranganjenislabel = new DbField('npd_harga', 'npd_harga', 'x_keteranganjenislabel', 'keteranganjenislabel', '`keteranganjenislabel`', '`keteranganjenislabel`', 201, 65535, -1, false, '`keteranganjenislabel`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keteranganjenislabel->Sortable = true; // Allow sort
        $this->keteranganjenislabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keteranganjenislabel->Param, "CustomMsg");
        $this->Fields['keteranganjenislabel'] = &$this->keteranganjenislabel;

        // kualitaslabel
        $this->kualitaslabel = new DbField('npd_harga', 'npd_harga', 'x_kualitaslabel', 'kualitaslabel', '`kualitaslabel`', '`kualitaslabel`', 200, 50, -1, false, '`kualitaslabel`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->kualitaslabel->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kualitaslabel->Lookup = new Lookup('kualitaslabel', 'npd_label_kualitas', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kualitaslabel->Lookup = new Lookup('kualitaslabel', 'npd_label_kualitas', false, 'value', ["value","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kualitaslabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kualitaslabel->Param, "CustomMsg");
        $this->Fields['kualitaslabel'] = &$this->kualitaslabel;

        // jumlahwarnalabel
        $this->jumlahwarnalabel = new DbField('npd_harga', 'npd_harga', 'x_jumlahwarnalabel', 'jumlahwarnalabel', '`jumlahwarnalabel`', '`jumlahwarnalabel`', 200, 50, -1, false, '`jumlahwarnalabel`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlahwarnalabel->Sortable = true; // Allow sort
        $this->jumlahwarnalabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlahwarnalabel->Param, "CustomMsg");
        $this->Fields['jumlahwarnalabel'] = &$this->jumlahwarnalabel;

        // metaliklabel
        $this->metaliklabel = new DbField('npd_harga', 'npd_harga', 'x_metaliklabel', 'metaliklabel', '`metaliklabel`', '`metaliklabel`', 200, 50, -1, false, '`metaliklabel`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->metaliklabel->Sortable = true; // Allow sort
        $this->metaliklabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->metaliklabel->Param, "CustomMsg");
        $this->Fields['metaliklabel'] = &$this->metaliklabel;

        // etiketlabel
        $this->etiketlabel = new DbField('npd_harga', 'npd_harga', 'x_etiketlabel', 'etiketlabel', '`etiketlabel`', '`etiketlabel`', 200, 50, -1, false, '`etiketlabel`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->etiketlabel->Sortable = true; // Allow sort
        $this->etiketlabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->etiketlabel->Param, "CustomMsg");
        $this->Fields['etiketlabel'] = &$this->etiketlabel;

        // keteranganlabel
        $this->keteranganlabel = new DbField('npd_harga', 'npd_harga', 'x_keteranganlabel', 'keteranganlabel', '`keteranganlabel`', '`keteranganlabel`', 201, 65535, -1, false, '`keteranganlabel`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keteranganlabel->Sortable = true; // Allow sort
        $this->keteranganlabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keteranganlabel->Param, "CustomMsg");
        $this->Fields['keteranganlabel'] = &$this->keteranganlabel;

        // kategoridelivery
        $this->kategoridelivery = new DbField('npd_harga', 'npd_harga', 'x_kategoridelivery', 'kategoridelivery', '`kategoridelivery`', '`kategoridelivery`', 200, 50, -1, false, '`kategoridelivery`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->kategoridelivery->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->kategoridelivery->Lookup = new Lookup('kategoridelivery', 'ekspedisi', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kategoridelivery->Lookup = new Lookup('kategoridelivery', 'ekspedisi', false, 'nama', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kategoridelivery->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategoridelivery->Param, "CustomMsg");
        $this->Fields['kategoridelivery'] = &$this->kategoridelivery;

        // alamatpengiriman
        $this->alamatpengiriman = new DbField('npd_harga', 'npd_harga', 'x_alamatpengiriman', 'alamatpengiriman', '`alamatpengiriman`', '`alamatpengiriman`', 201, 65535, -1, false, '`alamatpengiriman`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamatpengiriman->Sortable = true; // Allow sort
        $this->alamatpengiriman->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamatpengiriman->Param, "CustomMsg");
        $this->Fields['alamatpengiriman'] = &$this->alamatpengiriman;

        // orderperdana
        $this->orderperdana = new DbField('npd_harga', 'npd_harga', 'x_orderperdana', 'orderperdana', '`orderperdana`', '`orderperdana`', 3, 11, -1, false, '`orderperdana`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->orderperdana->Sortable = true; // Allow sort
        $this->orderperdana->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->orderperdana->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->orderperdana->Param, "CustomMsg");
        $this->Fields['orderperdana'] = &$this->orderperdana;

        // orderkontrak
        $this->orderkontrak = new DbField('npd_harga', 'npd_harga', 'x_orderkontrak', 'orderkontrak', '`orderkontrak`', '`orderkontrak`', 3, 11, -1, false, '`orderkontrak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->orderkontrak->Sortable = true; // Allow sort
        $this->orderkontrak->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->orderkontrak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->orderkontrak->Param, "CustomMsg");
        $this->Fields['orderkontrak'] = &$this->orderkontrak;

        // hargaperpcs
        $this->hargaperpcs = new DbField('npd_harga', 'npd_harga', 'x_hargaperpcs', 'hargaperpcs', '`hargaperpcs`', '`hargaperpcs`', 20, 20, -1, false, '`hargaperpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hargaperpcs->Sortable = true; // Allow sort
        $this->hargaperpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->hargaperpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hargaperpcs->Param, "CustomMsg");
        $this->Fields['hargaperpcs'] = &$this->hargaperpcs;

        // hargaperkarton
        $this->hargaperkarton = new DbField('npd_harga', 'npd_harga', 'x_hargaperkarton', 'hargaperkarton', '`hargaperkarton`', '`hargaperkarton`', 20, 20, -1, false, '`hargaperkarton`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hargaperkarton->Sortable = true; // Allow sort
        $this->hargaperkarton->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->hargaperkarton->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hargaperkarton->Param, "CustomMsg");
        $this->Fields['hargaperkarton'] = &$this->hargaperkarton;

        // lampiran
        $this->lampiran = new DbField('npd_harga', 'npd_harga', 'x_lampiran', 'lampiran', '`lampiran`', '`lampiran`', 200, 255, -1, true, '`lampiran`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->lampiran->Sortable = true; // Allow sort
        $this->lampiran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lampiran->Param, "CustomMsg");
        $this->Fields['lampiran'] = &$this->lampiran;

        // prepared_by
        $this->prepared_by = new DbField('npd_harga', 'npd_harga', 'x_prepared_by', 'prepared_by', '`prepared_by`', '`prepared_by`', 20, 20, -1, false, '`prepared_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->prepared_by->Sortable = true; // Allow sort
        $this->prepared_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->prepared_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->prepared_by->Param, "CustomMsg");
        $this->Fields['prepared_by'] = &$this->prepared_by;

        // checked_by
        $this->checked_by = new DbField('npd_harga', 'npd_harga', 'x_checked_by', 'checked_by', '`checked_by`', '`checked_by`', 20, 20, -1, false, '`checked_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->checked_by->Sortable = true; // Allow sort
        $this->checked_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->checked_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->checked_by->Param, "CustomMsg");
        $this->Fields['checked_by'] = &$this->checked_by;

        // approved_by
        $this->approved_by = new DbField('npd_harga', 'npd_harga', 'x_approved_by', 'approved_by', '`approved_by`', '`approved_by`', 20, 20, -1, false, '`approved_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->approved_by->Sortable = true; // Allow sort
        $this->approved_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->approved_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->approved_by->Param, "CustomMsg");
        $this->Fields['approved_by'] = &$this->approved_by;

        // approved_date
        $this->approved_date = new DbField('npd_harga', 'npd_harga', 'x_approved_date', 'approved_date', '`approved_date`', '`approved_date`', 20, 20, -1, false, '`approved_date`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->approved_date->Sortable = true; // Allow sort
        $this->approved_date->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->approved_date->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->approved_date->Param, "CustomMsg");
        $this->Fields['approved_date'] = &$this->approved_date;

        // disetujui
        $this->disetujui = new DbField('npd_harga', 'npd_harga', 'x_disetujui', 'disetujui', '`disetujui`', '`disetujui`', 16, 1, -1, false, '`disetujui`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->disetujui->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->disetujui->Lookup = new Lookup('disetujui', 'npd_harga', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->disetujui->Lookup = new Lookup('disetujui', 'npd_harga', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->disetujui->OptionCount = 2;
        $this->disetujui->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->disetujui->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->disetujui->Param, "CustomMsg");
        $this->Fields['disetujui'] = &$this->disetujui;

        // created_at
        $this->created_at = new DbField('npd_harga', 'npd_harga', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // readonly
        $this->readonly = new DbField('npd_harga', 'npd_harga', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = true; // Allow sort
        $this->readonly->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->readonly->Lookup = new Lookup('readonly', 'npd_harga', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->readonly->Lookup = new Lookup('readonly', 'npd_harga', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->readonly->OptionCount = 2;
        $this->readonly->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->readonly->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->readonly->Param, "CustomMsg");
        $this->Fields['readonly'] = &$this->readonly;

        // updated_at
        $this->updated_at = new DbField('npd_harga', 'npd_harga', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Nullable = false; // NOT NULL field
        $this->updated_at->Required = true; // Required field
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_harga`";
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
        $this->tglpengajuan->DbValue = $row['tglpengajuan'];
        $this->idnpd_sample->DbValue = $row['idnpd_sample'];
        $this->nama->DbValue = $row['nama'];
        $this->bentuk->DbValue = $row['bentuk'];
        $this->viskositas->DbValue = $row['viskositas'];
        $this->warna->DbValue = $row['warna'];
        $this->bauparfum->DbValue = $row['bauparfum'];
        $this->aplikasisediaan->DbValue = $row['aplikasisediaan'];
        $this->volume->DbValue = $row['volume'];
        $this->bahanaktif->DbValue = $row['bahanaktif'];
        $this->volumewadah->DbValue = $row['volumewadah'];
        $this->bahanwadah->DbValue = $row['bahanwadah'];
        $this->warnawadah->DbValue = $row['warnawadah'];
        $this->bentukwadah->DbValue = $row['bentukwadah'];
        $this->jenistutup->DbValue = $row['jenistutup'];
        $this->bahantutup->DbValue = $row['bahantutup'];
        $this->warnatutup->DbValue = $row['warnatutup'];
        $this->bentuktutup->DbValue = $row['bentuktutup'];
        $this->segel->DbValue = $row['segel'];
        $this->catatanprimer->DbValue = $row['catatanprimer'];
        $this->packingproduk->DbValue = $row['packingproduk'];
        $this->keteranganpacking->DbValue = $row['keteranganpacking'];
        $this->beltkarton->DbValue = $row['beltkarton'];
        $this->keteranganbelt->DbValue = $row['keteranganbelt'];
        $this->kartonluar->DbValue = $row['kartonluar'];
        $this->bariskarton->DbValue = $row['bariskarton'];
        $this->kolomkarton->DbValue = $row['kolomkarton'];
        $this->stackkarton->DbValue = $row['stackkarton'];
        $this->isikarton->DbValue = $row['isikarton'];
        $this->jenislabel->DbValue = $row['jenislabel'];
        $this->keteranganjenislabel->DbValue = $row['keteranganjenislabel'];
        $this->kualitaslabel->DbValue = $row['kualitaslabel'];
        $this->jumlahwarnalabel->DbValue = $row['jumlahwarnalabel'];
        $this->metaliklabel->DbValue = $row['metaliklabel'];
        $this->etiketlabel->DbValue = $row['etiketlabel'];
        $this->keteranganlabel->DbValue = $row['keteranganlabel'];
        $this->kategoridelivery->DbValue = $row['kategoridelivery'];
        $this->alamatpengiriman->DbValue = $row['alamatpengiriman'];
        $this->orderperdana->DbValue = $row['orderperdana'];
        $this->orderkontrak->DbValue = $row['orderkontrak'];
        $this->hargaperpcs->DbValue = $row['hargaperpcs'];
        $this->hargaperkarton->DbValue = $row['hargaperkarton'];
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->prepared_by->DbValue = $row['prepared_by'];
        $this->checked_by->DbValue = $row['checked_by'];
        $this->approved_by->DbValue = $row['approved_by'];
        $this->approved_date->DbValue = $row['approved_date'];
        $this->disetujui->DbValue = $row['disetujui'];
        $this->created_at->DbValue = $row['created_at'];
        $this->readonly->DbValue = $row['readonly'];
        $this->updated_at->DbValue = $row['updated_at'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['lampiran']) ? [] : [$row['lampiran']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->lampiran->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->lampiran->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("NpdHargaList");
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
        if ($pageName == "NpdHargaView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdHargaEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdHargaAdd") {
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
                return "NpdHargaView";
            case Config("API_ADD_ACTION"):
                return "NpdHargaAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdHargaEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdHargaDelete";
            case Config("API_LIST_ACTION"):
                return "NpdHargaList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdHargaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdHargaView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdHargaView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdHargaAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdHargaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdHargaEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdHargaAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdHargaDelete", $this->getUrlParm());
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
        $this->tglpengajuan->setDbValue($row['tglpengajuan']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->nama->setDbValue($row['nama']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->bauparfum->setDbValue($row['bauparfum']);
        $this->aplikasisediaan->setDbValue($row['aplikasisediaan']);
        $this->volume->setDbValue($row['volume']);
        $this->bahanaktif->setDbValue($row['bahanaktif']);
        $this->volumewadah->setDbValue($row['volumewadah']);
        $this->bahanwadah->setDbValue($row['bahanwadah']);
        $this->warnawadah->setDbValue($row['warnawadah']);
        $this->bentukwadah->setDbValue($row['bentukwadah']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->bahantutup->setDbValue($row['bahantutup']);
        $this->warnatutup->setDbValue($row['warnatutup']);
        $this->bentuktutup->setDbValue($row['bentuktutup']);
        $this->segel->setDbValue($row['segel']);
        $this->catatanprimer->setDbValue($row['catatanprimer']);
        $this->packingproduk->setDbValue($row['packingproduk']);
        $this->keteranganpacking->setDbValue($row['keteranganpacking']);
        $this->beltkarton->setDbValue($row['beltkarton']);
        $this->keteranganbelt->setDbValue($row['keteranganbelt']);
        $this->kartonluar->setDbValue($row['kartonluar']);
        $this->bariskarton->setDbValue($row['bariskarton']);
        $this->kolomkarton->setDbValue($row['kolomkarton']);
        $this->stackkarton->setDbValue($row['stackkarton']);
        $this->isikarton->setDbValue($row['isikarton']);
        $this->jenislabel->setDbValue($row['jenislabel']);
        $this->keteranganjenislabel->setDbValue($row['keteranganjenislabel']);
        $this->kualitaslabel->setDbValue($row['kualitaslabel']);
        $this->jumlahwarnalabel->setDbValue($row['jumlahwarnalabel']);
        $this->metaliklabel->setDbValue($row['metaliklabel']);
        $this->etiketlabel->setDbValue($row['etiketlabel']);
        $this->keteranganlabel->setDbValue($row['keteranganlabel']);
        $this->kategoridelivery->setDbValue($row['kategoridelivery']);
        $this->alamatpengiriman->setDbValue($row['alamatpengiriman']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderkontrak->setDbValue($row['orderkontrak']);
        $this->hargaperpcs->setDbValue($row['hargaperpcs']);
        $this->hargaperkarton->setDbValue($row['hargaperkarton']);
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->lampiran->setDbValue($this->lampiran->Upload->DbValue);
        $this->prepared_by->setDbValue($row['prepared_by']);
        $this->checked_by->setDbValue($row['checked_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->approved_date->setDbValue($row['approved_date']);
        $this->disetujui->setDbValue($row['disetujui']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
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

        // idnpd

        // tglpengajuan

        // idnpd_sample

        // nama

        // bentuk

        // viskositas

        // warna

        // bauparfum

        // aplikasisediaan

        // volume

        // bahanaktif

        // volumewadah

        // bahanwadah

        // warnawadah

        // bentukwadah

        // jenistutup

        // bahantutup

        // warnatutup

        // bentuktutup

        // segel

        // catatanprimer

        // packingproduk

        // keteranganpacking

        // beltkarton

        // keteranganbelt

        // kartonluar

        // bariskarton

        // kolomkarton

        // stackkarton

        // isikarton

        // jenislabel

        // keteranganjenislabel

        // kualitaslabel

        // jumlahwarnalabel

        // metaliklabel

        // etiketlabel

        // keteranganlabel

        // kategoridelivery

        // alamatpengiriman

        // orderperdana

        // orderkontrak

        // hargaperpcs

        // hargaperkarton

        // lampiran

        // prepared_by

        // checked_by

        // approved_by

        // approved_date

        // disetujui

        // created_at

        // readonly

        // updated_at

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
                    return "`id` IN (SELECT `idnpd` FROM `npd_confirmsample`)";
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

        // tglpengajuan
        $this->tglpengajuan->ViewValue = $this->tglpengajuan->CurrentValue;
        $this->tglpengajuan->ViewValue = FormatDateTime($this->tglpengajuan->ViewValue, 0);
        $this->tglpengajuan->ViewCustomAttributes = "";

        // idnpd_sample
        $curVal = trim(strval($this->idnpd_sample->CurrentValue));
        if ($curVal != "") {
            $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirmsample WHERE readonly=0)" : "";
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

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;
        $this->nama->ViewCustomAttributes = "";

        // bentuk
        $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
        $this->bentuk->ViewCustomAttributes = "";

        // viskositas
        $curVal = trim(strval($this->viskositas->CurrentValue));
        if ($curVal != "") {
            $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
            if ($this->viskositas->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->viskositas->Lookup->renderViewRow($rswrk[0]);
                    $this->viskositas->ViewValue = $this->viskositas->displayValue($arwrk);
                } else {
                    $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
                }
            }
        } else {
            $this->viskositas->ViewValue = null;
        }
        $this->viskositas->ViewCustomAttributes = "";

        // warna
        $curVal = trim(strval($this->warna->CurrentValue));
        if ($curVal != "") {
            $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
            if ($this->warna->ViewValue === null) { // Lookup from database
                $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->warna->Lookup->renderViewRow($rswrk[0]);
                    $this->warna->ViewValue = $this->warna->displayValue($arwrk);
                } else {
                    $this->warna->ViewValue = $this->warna->CurrentValue;
                }
            }
        } else {
            $this->warna->ViewValue = null;
        }
        $this->warna->ViewCustomAttributes = "";

        // bauparfum
        $this->bauparfum->ViewValue = $this->bauparfum->CurrentValue;
        $this->bauparfum->ViewCustomAttributes = "";

        // aplikasisediaan
        $curVal = trim(strval($this->aplikasisediaan->CurrentValue));
        if ($curVal != "") {
            $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->lookupCacheOption($curVal);
            if ($this->aplikasisediaan->ViewValue === null) { // Lookup from database
                $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->aplikasisediaan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->aplikasisediaan->Lookup->renderViewRow($rswrk[0]);
                    $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->displayValue($arwrk);
                } else {
                    $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->CurrentValue;
                }
            }
        } else {
            $this->aplikasisediaan->ViewValue = null;
        }
        $this->aplikasisediaan->ViewCustomAttributes = "";

        // volume
        $this->volume->ViewValue = $this->volume->CurrentValue;
        $this->volume->ViewCustomAttributes = "";

        // bahanaktif
        $this->bahanaktif->ViewValue = $this->bahanaktif->CurrentValue;
        $this->bahanaktif->ViewCustomAttributes = "";

        // volumewadah
        $this->volumewadah->ViewValue = $this->volumewadah->CurrentValue;
        $this->volumewadah->ViewCustomAttributes = "";

        // bahanwadah
        $this->bahanwadah->ViewValue = $this->bahanwadah->CurrentValue;
        $this->bahanwadah->ViewCustomAttributes = "";

        // warnawadah
        $this->warnawadah->ViewValue = $this->warnawadah->CurrentValue;
        $this->warnawadah->ViewCustomAttributes = "";

        // bentukwadah
        $this->bentukwadah->ViewValue = $this->bentukwadah->CurrentValue;
        $this->bentukwadah->ViewCustomAttributes = "";

        // jenistutup
        $this->jenistutup->ViewValue = $this->jenistutup->CurrentValue;
        $this->jenistutup->ViewCustomAttributes = "";

        // bahantutup
        $this->bahantutup->ViewValue = $this->bahantutup->CurrentValue;
        $this->bahantutup->ViewCustomAttributes = "";

        // warnatutup
        $this->warnatutup->ViewValue = $this->warnatutup->CurrentValue;
        $this->warnatutup->ViewCustomAttributes = "";

        // bentuktutup
        $this->bentuktutup->ViewValue = $this->bentuktutup->CurrentValue;
        $this->bentuktutup->ViewCustomAttributes = "";

        // segel
        if (strval($this->segel->CurrentValue) != "") {
            $this->segel->ViewValue = $this->segel->optionCaption($this->segel->CurrentValue);
        } else {
            $this->segel->ViewValue = null;
        }
        $this->segel->ViewCustomAttributes = "";

        // catatanprimer
        $this->catatanprimer->ViewValue = $this->catatanprimer->CurrentValue;
        $this->catatanprimer->ViewCustomAttributes = "";

        // packingproduk
        $this->packingproduk->ViewValue = $this->packingproduk->CurrentValue;
        $this->packingproduk->ViewCustomAttributes = "";

        // keteranganpacking
        $this->keteranganpacking->ViewValue = $this->keteranganpacking->CurrentValue;
        $this->keteranganpacking->ViewCustomAttributes = "";

        // beltkarton
        $this->beltkarton->ViewValue = $this->beltkarton->CurrentValue;
        $this->beltkarton->ViewCustomAttributes = "";

        // keteranganbelt
        $this->keteranganbelt->ViewValue = $this->keteranganbelt->CurrentValue;
        $this->keteranganbelt->ViewCustomAttributes = "";

        // kartonluar
        $this->kartonluar->ViewValue = $this->kartonluar->CurrentValue;
        $this->kartonluar->ViewCustomAttributes = "";

        // bariskarton
        $this->bariskarton->ViewValue = $this->bariskarton->CurrentValue;
        $this->bariskarton->ViewCustomAttributes = "";

        // kolomkarton
        $this->kolomkarton->ViewValue = $this->kolomkarton->CurrentValue;
        $this->kolomkarton->ViewCustomAttributes = "";

        // stackkarton
        $this->stackkarton->ViewValue = $this->stackkarton->CurrentValue;
        $this->stackkarton->ViewCustomAttributes = "";

        // isikarton
        $this->isikarton->ViewValue = $this->isikarton->CurrentValue;
        $this->isikarton->ViewCustomAttributes = "";

        // jenislabel
        $curVal = trim(strval($this->jenislabel->CurrentValue));
        if ($curVal != "") {
            $this->jenislabel->ViewValue = $this->jenislabel->lookupCacheOption($curVal);
            if ($this->jenislabel->ViewValue === null) { // Lookup from database
                $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->jenislabel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->jenislabel->Lookup->renderViewRow($rswrk[0]);
                    $this->jenislabel->ViewValue = $this->jenislabel->displayValue($arwrk);
                } else {
                    $this->jenislabel->ViewValue = $this->jenislabel->CurrentValue;
                }
            }
        } else {
            $this->jenislabel->ViewValue = null;
        }
        $this->jenislabel->ViewCustomAttributes = "";

        // keteranganjenislabel
        $this->keteranganjenislabel->ViewValue = $this->keteranganjenislabel->CurrentValue;
        $this->keteranganjenislabel->ViewCustomAttributes = "";

        // kualitaslabel
        $curVal = trim(strval($this->kualitaslabel->CurrentValue));
        if ($curVal != "") {
            $this->kualitaslabel->ViewValue = $this->kualitaslabel->lookupCacheOption($curVal);
            if ($this->kualitaslabel->ViewValue === null) { // Lookup from database
                $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->kualitaslabel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->kualitaslabel->Lookup->renderViewRow($rswrk[0]);
                    $this->kualitaslabel->ViewValue = $this->kualitaslabel->displayValue($arwrk);
                } else {
                    $this->kualitaslabel->ViewValue = $this->kualitaslabel->CurrentValue;
                }
            }
        } else {
            $this->kualitaslabel->ViewValue = null;
        }
        $this->kualitaslabel->ViewCustomAttributes = "";

        // jumlahwarnalabel
        $this->jumlahwarnalabel->ViewValue = $this->jumlahwarnalabel->CurrentValue;
        $this->jumlahwarnalabel->ViewCustomAttributes = "";

        // metaliklabel
        $this->metaliklabel->ViewValue = $this->metaliklabel->CurrentValue;
        $this->metaliklabel->ViewCustomAttributes = "";

        // etiketlabel
        $this->etiketlabel->ViewValue = $this->etiketlabel->CurrentValue;
        $this->etiketlabel->ViewCustomAttributes = "";

        // keteranganlabel
        $this->keteranganlabel->ViewValue = $this->keteranganlabel->CurrentValue;
        $this->keteranganlabel->ViewCustomAttributes = "";

        // kategoridelivery
        $curVal = trim(strval($this->kategoridelivery->CurrentValue));
        if ($curVal != "") {
            $this->kategoridelivery->ViewValue = $this->kategoridelivery->lookupCacheOption($curVal);
            if ($this->kategoridelivery->ViewValue === null) { // Lookup from database
                $arwrk = explode(",", $curVal);
                $filterWrk = "";
                foreach ($arwrk as $wrk) {
                    if ($filterWrk != "") {
                        $filterWrk .= " OR ";
                    }
                    $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kategoridelivery->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->kategoridelivery->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->kategoridelivery->Lookup->renderViewRow($row);
                        $this->kategoridelivery->ViewValue->add($this->kategoridelivery->displayValue($arwrk));
                    }
                } else {
                    $this->kategoridelivery->ViewValue = $this->kategoridelivery->CurrentValue;
                }
            }
        } else {
            $this->kategoridelivery->ViewValue = null;
        }
        $this->kategoridelivery->ViewCustomAttributes = "";

        // alamatpengiriman
        $this->alamatpengiriman->ViewValue = $this->alamatpengiriman->CurrentValue;
        $this->alamatpengiriman->ViewCustomAttributes = "";

        // orderperdana
        $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
        $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
        $this->orderperdana->ViewCustomAttributes = "";

        // orderkontrak
        $this->orderkontrak->ViewValue = $this->orderkontrak->CurrentValue;
        $this->orderkontrak->ViewValue = FormatNumber($this->orderkontrak->ViewValue, 0, -2, -2, -2);
        $this->orderkontrak->ViewCustomAttributes = "";

        // hargaperpcs
        $this->hargaperpcs->ViewValue = $this->hargaperpcs->CurrentValue;
        $this->hargaperpcs->ViewValue = FormatCurrency($this->hargaperpcs->ViewValue, 2, -2, -2, -2);
        $this->hargaperpcs->ViewCustomAttributes = "";

        // hargaperkarton
        $this->hargaperkarton->ViewValue = $this->hargaperkarton->CurrentValue;
        $this->hargaperkarton->ViewValue = FormatNumber($this->hargaperkarton->ViewValue, 0, -2, -2, -2);
        $this->hargaperkarton->ViewCustomAttributes = "";

        // lampiran
        if (!EmptyValue($this->lampiran->Upload->DbValue)) {
            $this->lampiran->ViewValue = $this->lampiran->Upload->DbValue;
        } else {
            $this->lampiran->ViewValue = "";
        }
        $this->lampiran->ViewCustomAttributes = "";

        // prepared_by
        $this->prepared_by->ViewValue = $this->prepared_by->CurrentValue;
        $this->prepared_by->ViewValue = FormatNumber($this->prepared_by->ViewValue, 0, -2, -2, -2);
        $this->prepared_by->ViewCustomAttributes = "";

        // checked_by
        $this->checked_by->ViewValue = $this->checked_by->CurrentValue;
        $this->checked_by->ViewValue = FormatNumber($this->checked_by->ViewValue, 0, -2, -2, -2);
        $this->checked_by->ViewCustomAttributes = "";

        // approved_by
        $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
        $this->approved_by->ViewValue = FormatNumber($this->approved_by->ViewValue, 0, -2, -2, -2);
        $this->approved_by->ViewCustomAttributes = "";

        // approved_date
        $this->approved_date->ViewValue = $this->approved_date->CurrentValue;
        $this->approved_date->ViewValue = FormatNumber($this->approved_date->ViewValue, 0, -2, -2, -2);
        $this->approved_date->ViewCustomAttributes = "";

        // disetujui
        if (strval($this->disetujui->CurrentValue) != "") {
            $this->disetujui->ViewValue = $this->disetujui->optionCaption($this->disetujui->CurrentValue);
        } else {
            $this->disetujui->ViewValue = null;
        }
        $this->disetujui->ViewCustomAttributes = "";

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

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
        $this->updated_at->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idnpd
        $this->idnpd->LinkCustomAttributes = "";
        $this->idnpd->HrefValue = "";
        $this->idnpd->TooltipValue = "";

        // tglpengajuan
        $this->tglpengajuan->LinkCustomAttributes = "";
        $this->tglpengajuan->HrefValue = "";
        $this->tglpengajuan->TooltipValue = "";

        // idnpd_sample
        $this->idnpd_sample->LinkCustomAttributes = "";
        $this->idnpd_sample->HrefValue = "";
        $this->idnpd_sample->TooltipValue = "";

        // nama
        $this->nama->LinkCustomAttributes = "";
        $this->nama->HrefValue = "";
        $this->nama->TooltipValue = "";

        // bentuk
        $this->bentuk->LinkCustomAttributes = "";
        $this->bentuk->HrefValue = "";
        $this->bentuk->TooltipValue = "";

        // viskositas
        $this->viskositas->LinkCustomAttributes = "";
        $this->viskositas->HrefValue = "";
        $this->viskositas->TooltipValue = "";

        // warna
        $this->warna->LinkCustomAttributes = "";
        $this->warna->HrefValue = "";
        $this->warna->TooltipValue = "";

        // bauparfum
        $this->bauparfum->LinkCustomAttributes = "";
        $this->bauparfum->HrefValue = "";
        $this->bauparfum->TooltipValue = "";

        // aplikasisediaan
        $this->aplikasisediaan->LinkCustomAttributes = "";
        $this->aplikasisediaan->HrefValue = "";
        $this->aplikasisediaan->TooltipValue = "";

        // volume
        $this->volume->LinkCustomAttributes = "";
        $this->volume->HrefValue = "";
        $this->volume->TooltipValue = "";

        // bahanaktif
        $this->bahanaktif->LinkCustomAttributes = "";
        $this->bahanaktif->HrefValue = "";
        $this->bahanaktif->TooltipValue = "";

        // volumewadah
        $this->volumewadah->LinkCustomAttributes = "";
        $this->volumewadah->HrefValue = "";
        $this->volumewadah->TooltipValue = "";

        // bahanwadah
        $this->bahanwadah->LinkCustomAttributes = "";
        $this->bahanwadah->HrefValue = "";
        $this->bahanwadah->TooltipValue = "";

        // warnawadah
        $this->warnawadah->LinkCustomAttributes = "";
        $this->warnawadah->HrefValue = "";
        $this->warnawadah->TooltipValue = "";

        // bentukwadah
        $this->bentukwadah->LinkCustomAttributes = "";
        $this->bentukwadah->HrefValue = "";
        $this->bentukwadah->TooltipValue = "";

        // jenistutup
        $this->jenistutup->LinkCustomAttributes = "";
        $this->jenistutup->HrefValue = "";
        $this->jenistutup->TooltipValue = "";

        // bahantutup
        $this->bahantutup->LinkCustomAttributes = "";
        $this->bahantutup->HrefValue = "";
        $this->bahantutup->TooltipValue = "";

        // warnatutup
        $this->warnatutup->LinkCustomAttributes = "";
        $this->warnatutup->HrefValue = "";
        $this->warnatutup->TooltipValue = "";

        // bentuktutup
        $this->bentuktutup->LinkCustomAttributes = "";
        $this->bentuktutup->HrefValue = "";
        $this->bentuktutup->TooltipValue = "";

        // segel
        $this->segel->LinkCustomAttributes = "";
        $this->segel->HrefValue = "";
        $this->segel->TooltipValue = "";

        // catatanprimer
        $this->catatanprimer->LinkCustomAttributes = "";
        $this->catatanprimer->HrefValue = "";
        $this->catatanprimer->TooltipValue = "";

        // packingproduk
        $this->packingproduk->LinkCustomAttributes = "";
        $this->packingproduk->HrefValue = "";
        $this->packingproduk->TooltipValue = "";

        // keteranganpacking
        $this->keteranganpacking->LinkCustomAttributes = "";
        $this->keteranganpacking->HrefValue = "";
        $this->keteranganpacking->TooltipValue = "";

        // beltkarton
        $this->beltkarton->LinkCustomAttributes = "";
        $this->beltkarton->HrefValue = "";
        $this->beltkarton->TooltipValue = "";

        // keteranganbelt
        $this->keteranganbelt->LinkCustomAttributes = "";
        $this->keteranganbelt->HrefValue = "";
        $this->keteranganbelt->TooltipValue = "";

        // kartonluar
        $this->kartonluar->LinkCustomAttributes = "";
        $this->kartonluar->HrefValue = "";
        $this->kartonluar->TooltipValue = "";

        // bariskarton
        $this->bariskarton->LinkCustomAttributes = "";
        $this->bariskarton->HrefValue = "";
        $this->bariskarton->TooltipValue = "";

        // kolomkarton
        $this->kolomkarton->LinkCustomAttributes = "";
        $this->kolomkarton->HrefValue = "";
        $this->kolomkarton->TooltipValue = "";

        // stackkarton
        $this->stackkarton->LinkCustomAttributes = "";
        $this->stackkarton->HrefValue = "";
        $this->stackkarton->TooltipValue = "";

        // isikarton
        $this->isikarton->LinkCustomAttributes = "";
        $this->isikarton->HrefValue = "";
        $this->isikarton->TooltipValue = "";

        // jenislabel
        $this->jenislabel->LinkCustomAttributes = "";
        $this->jenislabel->HrefValue = "";
        $this->jenislabel->TooltipValue = "";

        // keteranganjenislabel
        $this->keteranganjenislabel->LinkCustomAttributes = "";
        $this->keteranganjenislabel->HrefValue = "";
        $this->keteranganjenislabel->TooltipValue = "";

        // kualitaslabel
        $this->kualitaslabel->LinkCustomAttributes = "";
        $this->kualitaslabel->HrefValue = "";
        $this->kualitaslabel->TooltipValue = "";

        // jumlahwarnalabel
        $this->jumlahwarnalabel->LinkCustomAttributes = "";
        $this->jumlahwarnalabel->HrefValue = "";
        $this->jumlahwarnalabel->TooltipValue = "";

        // metaliklabel
        $this->metaliklabel->LinkCustomAttributes = "";
        $this->metaliklabel->HrefValue = "";
        $this->metaliklabel->TooltipValue = "";

        // etiketlabel
        $this->etiketlabel->LinkCustomAttributes = "";
        $this->etiketlabel->HrefValue = "";
        $this->etiketlabel->TooltipValue = "";

        // keteranganlabel
        $this->keteranganlabel->LinkCustomAttributes = "";
        $this->keteranganlabel->HrefValue = "";
        $this->keteranganlabel->TooltipValue = "";

        // kategoridelivery
        $this->kategoridelivery->LinkCustomAttributes = "";
        $this->kategoridelivery->HrefValue = "";
        $this->kategoridelivery->TooltipValue = "";

        // alamatpengiriman
        $this->alamatpengiriman->LinkCustomAttributes = "";
        $this->alamatpengiriman->HrefValue = "";
        $this->alamatpengiriman->TooltipValue = "";

        // orderperdana
        $this->orderperdana->LinkCustomAttributes = "";
        $this->orderperdana->HrefValue = "";
        $this->orderperdana->TooltipValue = "";

        // orderkontrak
        $this->orderkontrak->LinkCustomAttributes = "";
        $this->orderkontrak->HrefValue = "";
        $this->orderkontrak->TooltipValue = "";

        // hargaperpcs
        $this->hargaperpcs->LinkCustomAttributes = "";
        $this->hargaperpcs->HrefValue = "";
        $this->hargaperpcs->TooltipValue = "";

        // hargaperkarton
        $this->hargaperkarton->LinkCustomAttributes = "";
        $this->hargaperkarton->HrefValue = "";
        $this->hargaperkarton->TooltipValue = "";

        // lampiran
        $this->lampiran->LinkCustomAttributes = "";
        $this->lampiran->HrefValue = "";
        $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;
        $this->lampiran->TooltipValue = "";

        // prepared_by
        $this->prepared_by->LinkCustomAttributes = "";
        $this->prepared_by->HrefValue = "";
        $this->prepared_by->TooltipValue = "";

        // checked_by
        $this->checked_by->LinkCustomAttributes = "";
        $this->checked_by->HrefValue = "";
        $this->checked_by->TooltipValue = "";

        // approved_by
        $this->approved_by->LinkCustomAttributes = "";
        $this->approved_by->HrefValue = "";
        $this->approved_by->TooltipValue = "";

        // approved_date
        $this->approved_date->LinkCustomAttributes = "";
        $this->approved_date->HrefValue = "";
        $this->approved_date->TooltipValue = "";

        // disetujui
        $this->disetujui->LinkCustomAttributes = "";
        $this->disetujui->HrefValue = "";
        $this->disetujui->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

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
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirmsample`)";
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

        // tglpengajuan
        $this->tglpengajuan->EditAttrs["class"] = "form-control";
        $this->tglpengajuan->EditCustomAttributes = "";
        $this->tglpengajuan->EditValue = FormatDateTime($this->tglpengajuan->CurrentValue, 8);
        $this->tglpengajuan->PlaceHolder = RemoveHtml($this->tglpengajuan->caption());

        // idnpd_sample
        $this->idnpd_sample->EditAttrs["class"] = "form-control";
        $this->idnpd_sample->EditCustomAttributes = "";
        $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // bentuk
        $this->bentuk->EditAttrs["class"] = "form-control";
        $this->bentuk->EditCustomAttributes = "";
        if (!$this->bentuk->Raw) {
            $this->bentuk->CurrentValue = HtmlDecode($this->bentuk->CurrentValue);
        }
        $this->bentuk->EditValue = $this->bentuk->CurrentValue;
        $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

        // viskositas
        $this->viskositas->EditCustomAttributes = "";
        $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

        // warna
        $this->warna->EditCustomAttributes = "";
        $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

        // bauparfum
        $this->bauparfum->EditAttrs["class"] = "form-control";
        $this->bauparfum->EditCustomAttributes = "";
        if (!$this->bauparfum->Raw) {
            $this->bauparfum->CurrentValue = HtmlDecode($this->bauparfum->CurrentValue);
        }
        $this->bauparfum->EditValue = $this->bauparfum->CurrentValue;
        $this->bauparfum->PlaceHolder = RemoveHtml($this->bauparfum->caption());

        // aplikasisediaan
        $this->aplikasisediaan->EditCustomAttributes = "";
        $this->aplikasisediaan->PlaceHolder = RemoveHtml($this->aplikasisediaan->caption());

        // volume
        $this->volume->EditAttrs["class"] = "form-control";
        $this->volume->EditCustomAttributes = "";
        if (!$this->volume->Raw) {
            $this->volume->CurrentValue = HtmlDecode($this->volume->CurrentValue);
        }
        $this->volume->EditValue = $this->volume->CurrentValue;
        $this->volume->PlaceHolder = RemoveHtml($this->volume->caption());

        // bahanaktif
        $this->bahanaktif->EditAttrs["class"] = "form-control";
        $this->bahanaktif->EditCustomAttributes = "";
        $this->bahanaktif->EditValue = $this->bahanaktif->CurrentValue;
        $this->bahanaktif->PlaceHolder = RemoveHtml($this->bahanaktif->caption());

        // volumewadah
        $this->volumewadah->EditAttrs["class"] = "form-control";
        $this->volumewadah->EditCustomAttributes = "";
        if (!$this->volumewadah->Raw) {
            $this->volumewadah->CurrentValue = HtmlDecode($this->volumewadah->CurrentValue);
        }
        $this->volumewadah->EditValue = $this->volumewadah->CurrentValue;
        $this->volumewadah->PlaceHolder = RemoveHtml($this->volumewadah->caption());

        // bahanwadah
        $this->bahanwadah->EditAttrs["class"] = "form-control";
        $this->bahanwadah->EditCustomAttributes = "";
        if (!$this->bahanwadah->Raw) {
            $this->bahanwadah->CurrentValue = HtmlDecode($this->bahanwadah->CurrentValue);
        }
        $this->bahanwadah->EditValue = $this->bahanwadah->CurrentValue;
        $this->bahanwadah->PlaceHolder = RemoveHtml($this->bahanwadah->caption());

        // warnawadah
        $this->warnawadah->EditAttrs["class"] = "form-control";
        $this->warnawadah->EditCustomAttributes = "";
        if (!$this->warnawadah->Raw) {
            $this->warnawadah->CurrentValue = HtmlDecode($this->warnawadah->CurrentValue);
        }
        $this->warnawadah->EditValue = $this->warnawadah->CurrentValue;
        $this->warnawadah->PlaceHolder = RemoveHtml($this->warnawadah->caption());

        // bentukwadah
        $this->bentukwadah->EditAttrs["class"] = "form-control";
        $this->bentukwadah->EditCustomAttributes = "";
        if (!$this->bentukwadah->Raw) {
            $this->bentukwadah->CurrentValue = HtmlDecode($this->bentukwadah->CurrentValue);
        }
        $this->bentukwadah->EditValue = $this->bentukwadah->CurrentValue;
        $this->bentukwadah->PlaceHolder = RemoveHtml($this->bentukwadah->caption());

        // jenistutup
        $this->jenistutup->EditAttrs["class"] = "form-control";
        $this->jenistutup->EditCustomAttributes = "";
        if (!$this->jenistutup->Raw) {
            $this->jenistutup->CurrentValue = HtmlDecode($this->jenistutup->CurrentValue);
        }
        $this->jenistutup->EditValue = $this->jenistutup->CurrentValue;
        $this->jenistutup->PlaceHolder = RemoveHtml($this->jenistutup->caption());

        // bahantutup
        $this->bahantutup->EditAttrs["class"] = "form-control";
        $this->bahantutup->EditCustomAttributes = "";
        if (!$this->bahantutup->Raw) {
            $this->bahantutup->CurrentValue = HtmlDecode($this->bahantutup->CurrentValue);
        }
        $this->bahantutup->EditValue = $this->bahantutup->CurrentValue;
        $this->bahantutup->PlaceHolder = RemoveHtml($this->bahantutup->caption());

        // warnatutup
        $this->warnatutup->EditAttrs["class"] = "form-control";
        $this->warnatutup->EditCustomAttributes = "";
        if (!$this->warnatutup->Raw) {
            $this->warnatutup->CurrentValue = HtmlDecode($this->warnatutup->CurrentValue);
        }
        $this->warnatutup->EditValue = $this->warnatutup->CurrentValue;
        $this->warnatutup->PlaceHolder = RemoveHtml($this->warnatutup->caption());

        // bentuktutup
        $this->bentuktutup->EditAttrs["class"] = "form-control";
        $this->bentuktutup->EditCustomAttributes = "";
        if (!$this->bentuktutup->Raw) {
            $this->bentuktutup->CurrentValue = HtmlDecode($this->bentuktutup->CurrentValue);
        }
        $this->bentuktutup->EditValue = $this->bentuktutup->CurrentValue;
        $this->bentuktutup->PlaceHolder = RemoveHtml($this->bentuktutup->caption());

        // segel
        $this->segel->EditCustomAttributes = "";
        $this->segel->EditValue = $this->segel->options(false);
        $this->segel->PlaceHolder = RemoveHtml($this->segel->caption());

        // catatanprimer
        $this->catatanprimer->EditAttrs["class"] = "form-control";
        $this->catatanprimer->EditCustomAttributes = "";
        $this->catatanprimer->EditValue = $this->catatanprimer->CurrentValue;
        $this->catatanprimer->PlaceHolder = RemoveHtml($this->catatanprimer->caption());

        // packingproduk
        $this->packingproduk->EditAttrs["class"] = "form-control";
        $this->packingproduk->EditCustomAttributes = "";
        if (!$this->packingproduk->Raw) {
            $this->packingproduk->CurrentValue = HtmlDecode($this->packingproduk->CurrentValue);
        }
        $this->packingproduk->EditValue = $this->packingproduk->CurrentValue;
        $this->packingproduk->PlaceHolder = RemoveHtml($this->packingproduk->caption());

        // keteranganpacking
        $this->keteranganpacking->EditAttrs["class"] = "form-control";
        $this->keteranganpacking->EditCustomAttributes = "";
        $this->keteranganpacking->EditValue = $this->keteranganpacking->CurrentValue;
        $this->keteranganpacking->PlaceHolder = RemoveHtml($this->keteranganpacking->caption());

        // beltkarton
        $this->beltkarton->EditAttrs["class"] = "form-control";
        $this->beltkarton->EditCustomAttributes = "";
        if (!$this->beltkarton->Raw) {
            $this->beltkarton->CurrentValue = HtmlDecode($this->beltkarton->CurrentValue);
        }
        $this->beltkarton->EditValue = $this->beltkarton->CurrentValue;
        $this->beltkarton->PlaceHolder = RemoveHtml($this->beltkarton->caption());

        // keteranganbelt
        $this->keteranganbelt->EditAttrs["class"] = "form-control";
        $this->keteranganbelt->EditCustomAttributes = "";
        $this->keteranganbelt->EditValue = $this->keteranganbelt->CurrentValue;
        $this->keteranganbelt->PlaceHolder = RemoveHtml($this->keteranganbelt->caption());

        // kartonluar
        $this->kartonluar->EditAttrs["class"] = "form-control";
        $this->kartonluar->EditCustomAttributes = "";
        if (!$this->kartonluar->Raw) {
            $this->kartonluar->CurrentValue = HtmlDecode($this->kartonluar->CurrentValue);
        }
        $this->kartonluar->EditValue = $this->kartonluar->CurrentValue;
        $this->kartonluar->PlaceHolder = RemoveHtml($this->kartonluar->caption());

        // bariskarton
        $this->bariskarton->EditAttrs["class"] = "form-control";
        $this->bariskarton->EditCustomAttributes = "";
        if (!$this->bariskarton->Raw) {
            $this->bariskarton->CurrentValue = HtmlDecode($this->bariskarton->CurrentValue);
        }
        $this->bariskarton->EditValue = $this->bariskarton->CurrentValue;
        $this->bariskarton->PlaceHolder = RemoveHtml($this->bariskarton->caption());

        // kolomkarton
        $this->kolomkarton->EditAttrs["class"] = "form-control";
        $this->kolomkarton->EditCustomAttributes = "";
        if (!$this->kolomkarton->Raw) {
            $this->kolomkarton->CurrentValue = HtmlDecode($this->kolomkarton->CurrentValue);
        }
        $this->kolomkarton->EditValue = $this->kolomkarton->CurrentValue;
        $this->kolomkarton->PlaceHolder = RemoveHtml($this->kolomkarton->caption());

        // stackkarton
        $this->stackkarton->EditAttrs["class"] = "form-control";
        $this->stackkarton->EditCustomAttributes = "";
        if (!$this->stackkarton->Raw) {
            $this->stackkarton->CurrentValue = HtmlDecode($this->stackkarton->CurrentValue);
        }
        $this->stackkarton->EditValue = $this->stackkarton->CurrentValue;
        $this->stackkarton->PlaceHolder = RemoveHtml($this->stackkarton->caption());

        // isikarton
        $this->isikarton->EditAttrs["class"] = "form-control";
        $this->isikarton->EditCustomAttributes = "";
        if (!$this->isikarton->Raw) {
            $this->isikarton->CurrentValue = HtmlDecode($this->isikarton->CurrentValue);
        }
        $this->isikarton->EditValue = $this->isikarton->CurrentValue;
        $this->isikarton->PlaceHolder = RemoveHtml($this->isikarton->caption());

        // jenislabel
        $this->jenislabel->EditCustomAttributes = "";
        $this->jenislabel->PlaceHolder = RemoveHtml($this->jenislabel->caption());

        // keteranganjenislabel
        $this->keteranganjenislabel->EditAttrs["class"] = "form-control";
        $this->keteranganjenislabel->EditCustomAttributes = "";
        $this->keteranganjenislabel->EditValue = $this->keteranganjenislabel->CurrentValue;
        $this->keteranganjenislabel->PlaceHolder = RemoveHtml($this->keteranganjenislabel->caption());

        // kualitaslabel
        $this->kualitaslabel->EditCustomAttributes = "";
        $this->kualitaslabel->PlaceHolder = RemoveHtml($this->kualitaslabel->caption());

        // jumlahwarnalabel
        $this->jumlahwarnalabel->EditAttrs["class"] = "form-control";
        $this->jumlahwarnalabel->EditCustomAttributes = "";
        if (!$this->jumlahwarnalabel->Raw) {
            $this->jumlahwarnalabel->CurrentValue = HtmlDecode($this->jumlahwarnalabel->CurrentValue);
        }
        $this->jumlahwarnalabel->EditValue = $this->jumlahwarnalabel->CurrentValue;
        $this->jumlahwarnalabel->PlaceHolder = RemoveHtml($this->jumlahwarnalabel->caption());

        // metaliklabel
        $this->metaliklabel->EditAttrs["class"] = "form-control";
        $this->metaliklabel->EditCustomAttributes = "";
        if (!$this->metaliklabel->Raw) {
            $this->metaliklabel->CurrentValue = HtmlDecode($this->metaliklabel->CurrentValue);
        }
        $this->metaliklabel->EditValue = $this->metaliklabel->CurrentValue;
        $this->metaliklabel->PlaceHolder = RemoveHtml($this->metaliklabel->caption());

        // etiketlabel
        $this->etiketlabel->EditAttrs["class"] = "form-control";
        $this->etiketlabel->EditCustomAttributes = "";
        if (!$this->etiketlabel->Raw) {
            $this->etiketlabel->CurrentValue = HtmlDecode($this->etiketlabel->CurrentValue);
        }
        $this->etiketlabel->EditValue = $this->etiketlabel->CurrentValue;
        $this->etiketlabel->PlaceHolder = RemoveHtml($this->etiketlabel->caption());

        // keteranganlabel
        $this->keteranganlabel->EditAttrs["class"] = "form-control";
        $this->keteranganlabel->EditCustomAttributes = "";
        $this->keteranganlabel->EditValue = $this->keteranganlabel->CurrentValue;
        $this->keteranganlabel->PlaceHolder = RemoveHtml($this->keteranganlabel->caption());

        // kategoridelivery
        $this->kategoridelivery->EditCustomAttributes = "";
        $this->kategoridelivery->PlaceHolder = RemoveHtml($this->kategoridelivery->caption());

        // alamatpengiriman
        $this->alamatpengiriman->EditAttrs["class"] = "form-control";
        $this->alamatpengiriman->EditCustomAttributes = "";
        if (!$this->alamatpengiriman->Raw) {
            $this->alamatpengiriman->CurrentValue = HtmlDecode($this->alamatpengiriman->CurrentValue);
        }
        $this->alamatpengiriman->EditValue = $this->alamatpengiriman->CurrentValue;
        $this->alamatpengiriman->PlaceHolder = RemoveHtml($this->alamatpengiriman->caption());

        // orderperdana
        $this->orderperdana->EditAttrs["class"] = "form-control";
        $this->orderperdana->EditCustomAttributes = "";
        $this->orderperdana->EditValue = $this->orderperdana->CurrentValue;
        $this->orderperdana->PlaceHolder = RemoveHtml($this->orderperdana->caption());

        // orderkontrak
        $this->orderkontrak->EditAttrs["class"] = "form-control";
        $this->orderkontrak->EditCustomAttributes = "";
        $this->orderkontrak->EditValue = $this->orderkontrak->CurrentValue;
        $this->orderkontrak->PlaceHolder = RemoveHtml($this->orderkontrak->caption());

        // hargaperpcs
        $this->hargaperpcs->EditAttrs["class"] = "form-control";
        $this->hargaperpcs->EditCustomAttributes = "";
        $this->hargaperpcs->EditValue = $this->hargaperpcs->CurrentValue;
        $this->hargaperpcs->PlaceHolder = RemoveHtml($this->hargaperpcs->caption());

        // hargaperkarton
        $this->hargaperkarton->EditAttrs["class"] = "form-control";
        $this->hargaperkarton->EditCustomAttributes = "";
        $this->hargaperkarton->EditValue = $this->hargaperkarton->CurrentValue;
        $this->hargaperkarton->PlaceHolder = RemoveHtml($this->hargaperkarton->caption());

        // lampiran
        $this->lampiran->EditAttrs["class"] = "form-control";
        $this->lampiran->EditCustomAttributes = "";
        if (!EmptyValue($this->lampiran->Upload->DbValue)) {
            $this->lampiran->EditValue = $this->lampiran->Upload->DbValue;
        } else {
            $this->lampiran->EditValue = "";
        }
        if (!EmptyValue($this->lampiran->CurrentValue)) {
            $this->lampiran->Upload->FileName = $this->lampiran->CurrentValue;
        }

        // prepared_by
        $this->prepared_by->EditAttrs["class"] = "form-control";
        $this->prepared_by->EditCustomAttributes = "";
        $this->prepared_by->EditValue = $this->prepared_by->CurrentValue;
        $this->prepared_by->PlaceHolder = RemoveHtml($this->prepared_by->caption());

        // checked_by
        $this->checked_by->EditAttrs["class"] = "form-control";
        $this->checked_by->EditCustomAttributes = "";
        $this->checked_by->EditValue = $this->checked_by->CurrentValue;
        $this->checked_by->PlaceHolder = RemoveHtml($this->checked_by->caption());

        // approved_by
        $this->approved_by->EditAttrs["class"] = "form-control";
        $this->approved_by->EditCustomAttributes = "";
        $this->approved_by->EditValue = $this->approved_by->CurrentValue;
        $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

        // approved_date
        $this->approved_date->EditAttrs["class"] = "form-control";
        $this->approved_date->EditCustomAttributes = "";
        $this->approved_date->EditValue = $this->approved_date->CurrentValue;
        $this->approved_date->PlaceHolder = RemoveHtml($this->approved_date->caption());

        // disetujui
        $this->disetujui->EditCustomAttributes = "";
        $this->disetujui->EditValue = $this->disetujui->options(false);
        $this->disetujui->PlaceHolder = RemoveHtml($this->disetujui->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

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
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->tglpengajuan);
                    $doc->exportCaption($this->idnpd_sample);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->bauparfum);
                    $doc->exportCaption($this->aplikasisediaan);
                    $doc->exportCaption($this->volume);
                    $doc->exportCaption($this->bahanaktif);
                    $doc->exportCaption($this->volumewadah);
                    $doc->exportCaption($this->bahanwadah);
                    $doc->exportCaption($this->warnawadah);
                    $doc->exportCaption($this->bentukwadah);
                    $doc->exportCaption($this->jenistutup);
                    $doc->exportCaption($this->bahantutup);
                    $doc->exportCaption($this->warnatutup);
                    $doc->exportCaption($this->bentuktutup);
                    $doc->exportCaption($this->segel);
                    $doc->exportCaption($this->catatanprimer);
                    $doc->exportCaption($this->packingproduk);
                    $doc->exportCaption($this->keteranganpacking);
                    $doc->exportCaption($this->beltkarton);
                    $doc->exportCaption($this->keteranganbelt);
                    $doc->exportCaption($this->kartonluar);
                    $doc->exportCaption($this->bariskarton);
                    $doc->exportCaption($this->kolomkarton);
                    $doc->exportCaption($this->stackkarton);
                    $doc->exportCaption($this->isikarton);
                    $doc->exportCaption($this->jenislabel);
                    $doc->exportCaption($this->keteranganjenislabel);
                    $doc->exportCaption($this->kualitaslabel);
                    $doc->exportCaption($this->jumlahwarnalabel);
                    $doc->exportCaption($this->metaliklabel);
                    $doc->exportCaption($this->etiketlabel);
                    $doc->exportCaption($this->keteranganlabel);
                    $doc->exportCaption($this->kategoridelivery);
                    $doc->exportCaption($this->alamatpengiriman);
                    $doc->exportCaption($this->orderperdana);
                    $doc->exportCaption($this->orderkontrak);
                    $doc->exportCaption($this->hargaperpcs);
                    $doc->exportCaption($this->hargaperkarton);
                    $doc->exportCaption($this->lampiran);
                    $doc->exportCaption($this->prepared_by);
                    $doc->exportCaption($this->checked_by);
                    $doc->exportCaption($this->approved_by);
                    $doc->exportCaption($this->approved_date);
                    $doc->exportCaption($this->disetujui);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->tglpengajuan);
                    $doc->exportCaption($this->idnpd_sample);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->bentuk);
                    $doc->exportCaption($this->viskositas);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->bauparfum);
                    $doc->exportCaption($this->aplikasisediaan);
                    $doc->exportCaption($this->volume);
                    $doc->exportCaption($this->volumewadah);
                    $doc->exportCaption($this->bahanwadah);
                    $doc->exportCaption($this->warnawadah);
                    $doc->exportCaption($this->bentukwadah);
                    $doc->exportCaption($this->jenistutup);
                    $doc->exportCaption($this->bahantutup);
                    $doc->exportCaption($this->warnatutup);
                    $doc->exportCaption($this->bentuktutup);
                    $doc->exportCaption($this->segel);
                    $doc->exportCaption($this->catatanprimer);
                    $doc->exportCaption($this->packingproduk);
                    $doc->exportCaption($this->keteranganpacking);
                    $doc->exportCaption($this->beltkarton);
                    $doc->exportCaption($this->keteranganbelt);
                    $doc->exportCaption($this->kartonluar);
                    $doc->exportCaption($this->bariskarton);
                    $doc->exportCaption($this->kolomkarton);
                    $doc->exportCaption($this->stackkarton);
                    $doc->exportCaption($this->isikarton);
                    $doc->exportCaption($this->jenislabel);
                    $doc->exportCaption($this->keteranganjenislabel);
                    $doc->exportCaption($this->kualitaslabel);
                    $doc->exportCaption($this->jumlahwarnalabel);
                    $doc->exportCaption($this->metaliklabel);
                    $doc->exportCaption($this->etiketlabel);
                    $doc->exportCaption($this->keteranganlabel);
                    $doc->exportCaption($this->kategoridelivery);
                    $doc->exportCaption($this->alamatpengiriman);
                    $doc->exportCaption($this->orderperdana);
                    $doc->exportCaption($this->orderkontrak);
                    $doc->exportCaption($this->hargaperpcs);
                    $doc->exportCaption($this->hargaperkarton);
                    $doc->exportCaption($this->lampiran);
                    $doc->exportCaption($this->prepared_by);
                    $doc->exportCaption($this->checked_by);
                    $doc->exportCaption($this->approved_by);
                    $doc->exportCaption($this->approved_date);
                    $doc->exportCaption($this->disetujui);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->readonly);
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
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->tglpengajuan);
                        $doc->exportField($this->idnpd_sample);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->bauparfum);
                        $doc->exportField($this->aplikasisediaan);
                        $doc->exportField($this->volume);
                        $doc->exportField($this->bahanaktif);
                        $doc->exportField($this->volumewadah);
                        $doc->exportField($this->bahanwadah);
                        $doc->exportField($this->warnawadah);
                        $doc->exportField($this->bentukwadah);
                        $doc->exportField($this->jenistutup);
                        $doc->exportField($this->bahantutup);
                        $doc->exportField($this->warnatutup);
                        $doc->exportField($this->bentuktutup);
                        $doc->exportField($this->segel);
                        $doc->exportField($this->catatanprimer);
                        $doc->exportField($this->packingproduk);
                        $doc->exportField($this->keteranganpacking);
                        $doc->exportField($this->beltkarton);
                        $doc->exportField($this->keteranganbelt);
                        $doc->exportField($this->kartonluar);
                        $doc->exportField($this->bariskarton);
                        $doc->exportField($this->kolomkarton);
                        $doc->exportField($this->stackkarton);
                        $doc->exportField($this->isikarton);
                        $doc->exportField($this->jenislabel);
                        $doc->exportField($this->keteranganjenislabel);
                        $doc->exportField($this->kualitaslabel);
                        $doc->exportField($this->jumlahwarnalabel);
                        $doc->exportField($this->metaliklabel);
                        $doc->exportField($this->etiketlabel);
                        $doc->exportField($this->keteranganlabel);
                        $doc->exportField($this->kategoridelivery);
                        $doc->exportField($this->alamatpengiriman);
                        $doc->exportField($this->orderperdana);
                        $doc->exportField($this->orderkontrak);
                        $doc->exportField($this->hargaperpcs);
                        $doc->exportField($this->hargaperkarton);
                        $doc->exportField($this->lampiran);
                        $doc->exportField($this->prepared_by);
                        $doc->exportField($this->checked_by);
                        $doc->exportField($this->approved_by);
                        $doc->exportField($this->approved_date);
                        $doc->exportField($this->disetujui);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->tglpengajuan);
                        $doc->exportField($this->idnpd_sample);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->bentuk);
                        $doc->exportField($this->viskositas);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->bauparfum);
                        $doc->exportField($this->aplikasisediaan);
                        $doc->exportField($this->volume);
                        $doc->exportField($this->volumewadah);
                        $doc->exportField($this->bahanwadah);
                        $doc->exportField($this->warnawadah);
                        $doc->exportField($this->bentukwadah);
                        $doc->exportField($this->jenistutup);
                        $doc->exportField($this->bahantutup);
                        $doc->exportField($this->warnatutup);
                        $doc->exportField($this->bentuktutup);
                        $doc->exportField($this->segel);
                        $doc->exportField($this->catatanprimer);
                        $doc->exportField($this->packingproduk);
                        $doc->exportField($this->keteranganpacking);
                        $doc->exportField($this->beltkarton);
                        $doc->exportField($this->keteranganbelt);
                        $doc->exportField($this->kartonluar);
                        $doc->exportField($this->bariskarton);
                        $doc->exportField($this->kolomkarton);
                        $doc->exportField($this->stackkarton);
                        $doc->exportField($this->isikarton);
                        $doc->exportField($this->jenislabel);
                        $doc->exportField($this->keteranganjenislabel);
                        $doc->exportField($this->kualitaslabel);
                        $doc->exportField($this->jumlahwarnalabel);
                        $doc->exportField($this->metaliklabel);
                        $doc->exportField($this->etiketlabel);
                        $doc->exportField($this->keteranganlabel);
                        $doc->exportField($this->kategoridelivery);
                        $doc->exportField($this->alamatpengiriman);
                        $doc->exportField($this->orderperdana);
                        $doc->exportField($this->orderkontrak);
                        $doc->exportField($this->hargaperpcs);
                        $doc->exportField($this->hargaperkarton);
                        $doc->exportField($this->lampiran);
                        $doc->exportField($this->prepared_by);
                        $doc->exportField($this->checked_by);
                        $doc->exportField($this->approved_by);
                        $doc->exportField($this->approved_date);
                        $doc->exportField($this->disetujui);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->readonly);
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
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'lampiran') {
            $fldName = "lampiran";
            $fileNameFld = "lampiran";
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
        ExecuteUpdate("UPDATE npd_confirmsample SET readonly=1 WHERE idnpd_sample={$rsnew['idnpd_sample']}");
        if ($rsnew['disetujui'] > 0) {
        	$rsnew['approved_date'] = date('Y-m-d H:i:s');
        }
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
        //updateStatus("npd", $rsnew['idnpd']);
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        if ($rsnew['disetujui'] > 0 && empty($rsold['approved_date'])) {
        	$rsnew['approved_date'] = date('Y-m-d H:i:s');
        }
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
        //updateStatus("npd", $rsold['idnpd']);
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
        ExecuteUpdate("UPDATE npd_confirmsample SET readonly=0 WHERE idnpd_sample={$rs['idnpd_sample']}");
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
        //updateStatus("npd", $rs['idnpd']);
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
