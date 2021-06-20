<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for order_pengembangan
 */
class OrderPengembangan extends DbTable
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
    public $cpo_jenis;
    public $ordernum;
    public $order_kode;
    public $orderterimatgl;
    public $produk_fungsi;
    public $produk_kualitas;
    public $produk_campaign;
    public $kemasan_satuan;
    public $ordertgl;
    public $custcode;
    public $perushnama;
    public $perushalamat;
    public $perushcp;
    public $perushjabatan;
    public $perushphone;
    public $perushmobile;
    public $bencmark;
    public $kategoriproduk;
    public $jenisproduk;
    public $bentuksediaan;
    public $sediaan_ukuran;
    public $sediaan_ukuran_satuan;
    public $produk_viskositas;
    public $konsepproduk;
    public $fragrance;
    public $aroma;
    public $bahanaktif;
    public $warna;
    public $produk_warna_jenis;
    public $aksesoris;
    public $produk_lainlain;
    public $statusproduk;
    public $parfum;
    public $catatan;
    public $rencanakemasan;
    public $keterangan;
    public $ekspetasiharga;
    public $kemasan;
    public $volume;
    public $jenistutup;
    public $catatanpackaging;
    public $infopackaging;
    public $ukuran;
    public $desainprodukkemasan;
    public $desaindiinginkan;
    public $mereknotifikasi;
    public $kategoristatus;
    public $kemasan_ukuran_satuan;
    public $notifikasicatatan;
    public $label_ukuran;
    public $infolabel;
    public $labelkualitas;
    public $labelposisi;
    public $labelcatatan;
    public $dibuatdi;
    public $tanggal;
    public $penerima;
    public $createat;
    public $createby;
    public $statusdokumen;
    public $update_at;
    public $status_data;
    public $harga_rnd;
    public $aplikasi_sediaan;
    public $hu_hrg_isi;
    public $hu_hrg_isi_pro;
    public $hu_hrg_kms_primer;
    public $hu_hrg_kms_primer_pro;
    public $hu_hrg_kms_sekunder;
    public $hu_hrg_kms_sekunder_pro;
    public $hu_hrg_label;
    public $hu_hrg_label_pro;
    public $hu_hrg_total;
    public $hu_hrg_total_pro;
    public $hl_hrg_isi;
    public $hl_hrg_isi_pro;
    public $hl_hrg_kms_primer;
    public $hl_hrg_kms_primer_pro;
    public $hl_hrg_kms_sekunder;
    public $hl_hrg_kms_sekunder_pro;
    public $hl_hrg_label;
    public $hl_hrg_label_pro;
    public $hl_hrg_total;
    public $hl_hrg_total_pro;
    public $bs_bahan_aktif_tick;
    public $bs_bahan_aktif;
    public $bs_bahan_lain;
    public $bs_parfum;
    public $bs_estetika;
    public $bs_kms_wadah;
    public $bs_kms_tutup;
    public $bs_kms_sekunder;
    public $bs_label_desain;
    public $bs_label_cetak;
    public $bs_label_lain;
    public $dlv_pickup;
    public $dlv_singlepoint;
    public $dlv_multipoint;
    public $dlv_multipoint_jml;
    public $dlv_term_lain;
    public $catatan_khusus;
    public $aju_tgl;
    public $aju_oleh;
    public $proses_tgl;
    public $proses_oleh;
    public $revisi_tgl;
    public $revisi_oleh;
    public $revisi_akun_tgl;
    public $revisi_akun_oleh;
    public $revisi_rnd_tgl;
    public $revisi_rnd_oleh;
    public $rnd_tgl;
    public $rnd_oleh;
    public $ap_tgl;
    public $ap_oleh;
    public $batal_tgl;
    public $batal_oleh;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'order_pengembangan';
        $this->TableName = 'order_pengembangan';
        $this->TableType = 'LINKTABLE';

        // Update Table
        $this->UpdateTable = "`order_pengembangan`";
        $this->Dbid = 'dbpabrik';
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
        $this->id = new DbField('order_pengembangan', 'order_pengembangan', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->Required = true; // Required field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // cpo_jenis
        $this->cpo_jenis = new DbField('order_pengembangan', 'order_pengembangan', 'x_cpo_jenis', 'cpo_jenis', '`cpo_jenis`', '`cpo_jenis`', 200, 50, -1, false, '`cpo_jenis`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->cpo_jenis->Nullable = false; // NOT NULL field
        $this->cpo_jenis->Required = true; // Required field
        $this->cpo_jenis->Sortable = true; // Allow sort
        $this->cpo_jenis->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->cpo_jenis->Param, "CustomMsg");
        $this->Fields['cpo_jenis'] = &$this->cpo_jenis;

        // ordernum
        $this->ordernum = new DbField('order_pengembangan', 'order_pengembangan', 'x_ordernum', 'ordernum', '`ordernum`', '`ordernum`', 200, 50, -1, false, '`ordernum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ordernum->Sortable = true; // Allow sort
        $this->ordernum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ordernum->Param, "CustomMsg");
        $this->Fields['ordernum'] = &$this->ordernum;

        // order_kode
        $this->order_kode = new DbField('order_pengembangan', 'order_pengembangan', 'x_order_kode', 'order_kode', '`order_kode`', '`order_kode`', 200, 50, -1, false, '`order_kode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->order_kode->Sortable = true; // Allow sort
        $this->order_kode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->order_kode->Param, "CustomMsg");
        $this->Fields['order_kode'] = &$this->order_kode;

        // orderterimatgl
        $this->orderterimatgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_orderterimatgl', 'orderterimatgl', '`orderterimatgl`', CastDateFieldForLike("`orderterimatgl`", 0, "dbpabrik"), 133, 10, 0, false, '`orderterimatgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->orderterimatgl->Sortable = true; // Allow sort
        $this->orderterimatgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->orderterimatgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->orderterimatgl->Param, "CustomMsg");
        $this->Fields['orderterimatgl'] = &$this->orderterimatgl;

        // produk_fungsi
        $this->produk_fungsi = new DbField('order_pengembangan', 'order_pengembangan', 'x_produk_fungsi', 'produk_fungsi', '`produk_fungsi`', '`produk_fungsi`', 200, 100, -1, false, '`produk_fungsi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->produk_fungsi->Sortable = true; // Allow sort
        $this->produk_fungsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk_fungsi->Param, "CustomMsg");
        $this->Fields['produk_fungsi'] = &$this->produk_fungsi;

        // produk_kualitas
        $this->produk_kualitas = new DbField('order_pengembangan', 'order_pengembangan', 'x_produk_kualitas', 'produk_kualitas', '`produk_kualitas`', '`produk_kualitas`', 200, 100, -1, false, '`produk_kualitas`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->produk_kualitas->Sortable = true; // Allow sort
        $this->produk_kualitas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk_kualitas->Param, "CustomMsg");
        $this->Fields['produk_kualitas'] = &$this->produk_kualitas;

        // produk_campaign
        $this->produk_campaign = new DbField('order_pengembangan', 'order_pengembangan', 'x_produk_campaign', 'produk_campaign', '`produk_campaign`', '`produk_campaign`', 200, 100, -1, false, '`produk_campaign`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->produk_campaign->Sortable = true; // Allow sort
        $this->produk_campaign->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk_campaign->Param, "CustomMsg");
        $this->Fields['produk_campaign'] = &$this->produk_campaign;

        // kemasan_satuan
        $this->kemasan_satuan = new DbField('order_pengembangan', 'order_pengembangan', 'x_kemasan_satuan', 'kemasan_satuan', '`kemasan_satuan`', '`kemasan_satuan`', 200, 50, -1, false, '`kemasan_satuan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasan_satuan->Sortable = true; // Allow sort
        $this->kemasan_satuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasan_satuan->Param, "CustomMsg");
        $this->Fields['kemasan_satuan'] = &$this->kemasan_satuan;

        // ordertgl
        $this->ordertgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_ordertgl', 'ordertgl', '`ordertgl`', CastDateFieldForLike("`ordertgl`", 0, "dbpabrik"), 133, 10, 0, false, '`ordertgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ordertgl->Sortable = true; // Allow sort
        $this->ordertgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->ordertgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ordertgl->Param, "CustomMsg");
        $this->Fields['ordertgl'] = &$this->ordertgl;

        // custcode
        $this->custcode = new DbField('order_pengembangan', 'order_pengembangan', 'x_custcode', 'custcode', '`custcode`', '`custcode`', 3, 11, -1, false, '`custcode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->custcode->Sortable = true; // Allow sort
        $this->custcode->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->custcode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->custcode->Param, "CustomMsg");
        $this->Fields['custcode'] = &$this->custcode;

        // perushnama
        $this->perushnama = new DbField('order_pengembangan', 'order_pengembangan', 'x_perushnama', 'perushnama', '`perushnama`', '`perushnama`', 200, 50, -1, false, '`perushnama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->perushnama->Sortable = true; // Allow sort
        $this->perushnama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perushnama->Param, "CustomMsg");
        $this->Fields['perushnama'] = &$this->perushnama;

        // perushalamat
        $this->perushalamat = new DbField('order_pengembangan', 'order_pengembangan', 'x_perushalamat', 'perushalamat', '`perushalamat`', '`perushalamat`', 200, 250, -1, false, '`perushalamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->perushalamat->Sortable = true; // Allow sort
        $this->perushalamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perushalamat->Param, "CustomMsg");
        $this->Fields['perushalamat'] = &$this->perushalamat;

        // perushcp
        $this->perushcp = new DbField('order_pengembangan', 'order_pengembangan', 'x_perushcp', 'perushcp', '`perushcp`', '`perushcp`', 200, 50, -1, false, '`perushcp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->perushcp->Sortable = true; // Allow sort
        $this->perushcp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perushcp->Param, "CustomMsg");
        $this->Fields['perushcp'] = &$this->perushcp;

        // perushjabatan
        $this->perushjabatan = new DbField('order_pengembangan', 'order_pengembangan', 'x_perushjabatan', 'perushjabatan', '`perushjabatan`', '`perushjabatan`', 200, 50, -1, false, '`perushjabatan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->perushjabatan->Sortable = true; // Allow sort
        $this->perushjabatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perushjabatan->Param, "CustomMsg");
        $this->Fields['perushjabatan'] = &$this->perushjabatan;

        // perushphone
        $this->perushphone = new DbField('order_pengembangan', 'order_pengembangan', 'x_perushphone', 'perushphone', '`perushphone`', '`perushphone`', 200, 50, -1, false, '`perushphone`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->perushphone->Sortable = true; // Allow sort
        $this->perushphone->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perushphone->Param, "CustomMsg");
        $this->Fields['perushphone'] = &$this->perushphone;

        // perushmobile
        $this->perushmobile = new DbField('order_pengembangan', 'order_pengembangan', 'x_perushmobile', 'perushmobile', '`perushmobile`', '`perushmobile`', 200, 50, -1, false, '`perushmobile`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->perushmobile->Sortable = true; // Allow sort
        $this->perushmobile->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perushmobile->Param, "CustomMsg");
        $this->Fields['perushmobile'] = &$this->perushmobile;

        // bencmark
        $this->bencmark = new DbField('order_pengembangan', 'order_pengembangan', 'x_bencmark', 'bencmark', '`bencmark`', '`bencmark`', 200, 150, -1, false, '`bencmark`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bencmark->Sortable = true; // Allow sort
        $this->bencmark->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bencmark->Param, "CustomMsg");
        $this->Fields['bencmark'] = &$this->bencmark;

        // kategoriproduk
        $this->kategoriproduk = new DbField('order_pengembangan', 'order_pengembangan', 'x_kategoriproduk', 'kategoriproduk', '`kategoriproduk`', '`kategoriproduk`', 200, 150, -1, false, '`kategoriproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kategoriproduk->Sortable = true; // Allow sort
        $this->kategoriproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategoriproduk->Param, "CustomMsg");
        $this->Fields['kategoriproduk'] = &$this->kategoriproduk;

        // jenisproduk
        $this->jenisproduk = new DbField('order_pengembangan', 'order_pengembangan', 'x_jenisproduk', 'jenisproduk', '`jenisproduk`', '`jenisproduk`', 200, 150, -1, false, '`jenisproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jenisproduk->Sortable = true; // Allow sort
        $this->jenisproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenisproduk->Param, "CustomMsg");
        $this->Fields['jenisproduk'] = &$this->jenisproduk;

        // bentuksediaan
        $this->bentuksediaan = new DbField('order_pengembangan', 'order_pengembangan', 'x_bentuksediaan', 'bentuksediaan', '`bentuksediaan`', '`bentuksediaan`', 200, 150, -1, false, '`bentuksediaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bentuksediaan->Sortable = true; // Allow sort
        $this->bentuksediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bentuksediaan->Param, "CustomMsg");
        $this->Fields['bentuksediaan'] = &$this->bentuksediaan;

        // sediaan_ukuran
        $this->sediaan_ukuran = new DbField('order_pengembangan', 'order_pengembangan', 'x_sediaan_ukuran', 'sediaan_ukuran', '`sediaan_ukuran`', '`sediaan_ukuran`', 131, 10, -1, false, '`sediaan_ukuran`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sediaan_ukuran->Sortable = true; // Allow sort
        $this->sediaan_ukuran->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->sediaan_ukuran->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->sediaan_ukuran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sediaan_ukuran->Param, "CustomMsg");
        $this->Fields['sediaan_ukuran'] = &$this->sediaan_ukuran;

        // sediaan_ukuran_satuan
        $this->sediaan_ukuran_satuan = new DbField('order_pengembangan', 'order_pengembangan', 'x_sediaan_ukuran_satuan', 'sediaan_ukuran_satuan', '`sediaan_ukuran_satuan`', '`sediaan_ukuran_satuan`', 200, 50, -1, false, '`sediaan_ukuran_satuan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sediaan_ukuran_satuan->Sortable = true; // Allow sort
        $this->sediaan_ukuran_satuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sediaan_ukuran_satuan->Param, "CustomMsg");
        $this->Fields['sediaan_ukuran_satuan'] = &$this->sediaan_ukuran_satuan;

        // produk_viskositas
        $this->produk_viskositas = new DbField('order_pengembangan', 'order_pengembangan', 'x_produk_viskositas', 'produk_viskositas', '`produk_viskositas`', '`produk_viskositas`', 200, 150, -1, false, '`produk_viskositas`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->produk_viskositas->Sortable = true; // Allow sort
        $this->produk_viskositas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk_viskositas->Param, "CustomMsg");
        $this->Fields['produk_viskositas'] = &$this->produk_viskositas;

        // konsepproduk
        $this->konsepproduk = new DbField('order_pengembangan', 'order_pengembangan', 'x_konsepproduk', 'konsepproduk', '`konsepproduk`', '`konsepproduk`', 200, 150, -1, false, '`konsepproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->konsepproduk->Sortable = true; // Allow sort
        $this->konsepproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->konsepproduk->Param, "CustomMsg");
        $this->Fields['konsepproduk'] = &$this->konsepproduk;

        // fragrance
        $this->fragrance = new DbField('order_pengembangan', 'order_pengembangan', 'x_fragrance', 'fragrance', '`fragrance`', '`fragrance`', 200, 150, -1, false, '`fragrance`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fragrance->Sortable = true; // Allow sort
        $this->fragrance->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fragrance->Param, "CustomMsg");
        $this->Fields['fragrance'] = &$this->fragrance;

        // aroma
        $this->aroma = new DbField('order_pengembangan', 'order_pengembangan', 'x_aroma', 'aroma', '`aroma`', '`aroma`', 200, 150, -1, false, '`aroma`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aroma->Sortable = true; // Allow sort
        $this->aroma->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aroma->Param, "CustomMsg");
        $this->Fields['aroma'] = &$this->aroma;

        // bahanaktif
        $this->bahanaktif = new DbField('order_pengembangan', 'order_pengembangan', 'x_bahanaktif', 'bahanaktif', '`bahanaktif`', '`bahanaktif`', 200, 150, -1, false, '`bahanaktif`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bahanaktif->Sortable = true; // Allow sort
        $this->bahanaktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bahanaktif->Param, "CustomMsg");
        $this->Fields['bahanaktif'] = &$this->bahanaktif;

        // warna
        $this->warna = new DbField('order_pengembangan', 'order_pengembangan', 'x_warna', 'warna', '`warna`', '`warna`', 200, 150, -1, false, '`warna`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->warna->Sortable = true; // Allow sort
        $this->warna->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->warna->Param, "CustomMsg");
        $this->Fields['warna'] = &$this->warna;

        // produk_warna_jenis
        $this->produk_warna_jenis = new DbField('order_pengembangan', 'order_pengembangan', 'x_produk_warna_jenis', 'produk_warna_jenis', '`produk_warna_jenis`', '`produk_warna_jenis`', 200, 150, -1, false, '`produk_warna_jenis`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->produk_warna_jenis->Sortable = true; // Allow sort
        $this->produk_warna_jenis->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk_warna_jenis->Param, "CustomMsg");
        $this->Fields['produk_warna_jenis'] = &$this->produk_warna_jenis;

        // aksesoris
        $this->aksesoris = new DbField('order_pengembangan', 'order_pengembangan', 'x_aksesoris', 'aksesoris', '`aksesoris`', '`aksesoris`', 200, 150, -1, false, '`aksesoris`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aksesoris->Sortable = true; // Allow sort
        $this->aksesoris->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aksesoris->Param, "CustomMsg");
        $this->Fields['aksesoris'] = &$this->aksesoris;

        // produk_lainlain
        $this->produk_lainlain = new DbField('order_pengembangan', 'order_pengembangan', 'x_produk_lainlain', 'produk_lainlain', '`produk_lainlain`', '`produk_lainlain`', 201, 500, -1, false, '`produk_lainlain`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->produk_lainlain->Sortable = true; // Allow sort
        $this->produk_lainlain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk_lainlain->Param, "CustomMsg");
        $this->Fields['produk_lainlain'] = &$this->produk_lainlain;

        // statusproduk
        $this->statusproduk = new DbField('order_pengembangan', 'order_pengembangan', 'x_statusproduk', 'statusproduk', '`statusproduk`', '`statusproduk`', 200, 20, -1, false, '`statusproduk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->statusproduk->Sortable = true; // Allow sort
        $this->statusproduk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->statusproduk->Param, "CustomMsg");
        $this->Fields['statusproduk'] = &$this->statusproduk;

        // parfum
        $this->parfum = new DbField('order_pengembangan', 'order_pengembangan', 'x_parfum', 'parfum', '`parfum`', '`parfum`', 200, 150, -1, false, '`parfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->parfum->Sortable = true; // Allow sort
        $this->parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->parfum->Param, "CustomMsg");
        $this->Fields['parfum'] = &$this->parfum;

        // catatan
        $this->catatan = new DbField('order_pengembangan', 'order_pengembangan', 'x_catatan', 'catatan', '`catatan`', '`catatan`', 200, 150, -1, false, '`catatan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->catatan->Sortable = true; // Allow sort
        $this->catatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->catatan->Param, "CustomMsg");
        $this->Fields['catatan'] = &$this->catatan;

        // rencanakemasan
        $this->rencanakemasan = new DbField('order_pengembangan', 'order_pengembangan', 'x_rencanakemasan', 'rencanakemasan', '`rencanakemasan`', '`rencanakemasan`', 200, 150, -1, false, '`rencanakemasan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->rencanakemasan->Sortable = true; // Allow sort
        $this->rencanakemasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->rencanakemasan->Param, "CustomMsg");
        $this->Fields['rencanakemasan'] = &$this->rencanakemasan;

        // keterangan
        $this->keterangan = new DbField('order_pengembangan', 'order_pengembangan', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, 500, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;

        // ekspetasiharga
        $this->ekspetasiharga = new DbField('order_pengembangan', 'order_pengembangan', 'x_ekspetasiharga', 'ekspetasiharga', '`ekspetasiharga`', '`ekspetasiharga`', 131, 12, -1, false, '`ekspetasiharga`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ekspetasiharga->Sortable = true; // Allow sort
        $this->ekspetasiharga->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->ekspetasiharga->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->ekspetasiharga->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ekspetasiharga->Param, "CustomMsg");
        $this->Fields['ekspetasiharga'] = &$this->ekspetasiharga;

        // kemasan
        $this->kemasan = new DbField('order_pengembangan', 'order_pengembangan', 'x_kemasan', 'kemasan', '`kemasan`', '`kemasan`', 200, 50, -1, false, '`kemasan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasan->Sortable = true; // Allow sort
        $this->kemasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasan->Param, "CustomMsg");
        $this->Fields['kemasan'] = &$this->kemasan;

        // volume
        $this->volume = new DbField('order_pengembangan', 'order_pengembangan', 'x_volume', 'volume', '`volume`', '`volume`', 131, 12, -1, false, '`volume`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->volume->Sortable = true; // Allow sort
        $this->volume->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->volume->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->volume->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->volume->Param, "CustomMsg");
        $this->Fields['volume'] = &$this->volume;

        // jenistutup
        $this->jenistutup = new DbField('order_pengembangan', 'order_pengembangan', 'x_jenistutup', 'jenistutup', '`jenistutup`', '`jenistutup`', 200, 50, -1, false, '`jenistutup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jenistutup->Sortable = true; // Allow sort
        $this->jenistutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenistutup->Param, "CustomMsg");
        $this->Fields['jenistutup'] = &$this->jenistutup;

        // catatanpackaging
        $this->catatanpackaging = new DbField('order_pengembangan', 'order_pengembangan', 'x_catatanpackaging', 'catatanpackaging', '`catatanpackaging`', '`catatanpackaging`', 201, 500, -1, false, '`catatanpackaging`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->catatanpackaging->Sortable = true; // Allow sort
        $this->catatanpackaging->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->catatanpackaging->Param, "CustomMsg");
        $this->Fields['catatanpackaging'] = &$this->catatanpackaging;

        // infopackaging
        $this->infopackaging = new DbField('order_pengembangan', 'order_pengembangan', 'x_infopackaging', 'infopackaging', '`infopackaging`', '`infopackaging`', 200, 150, -1, false, '`infopackaging`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->infopackaging->Sortable = true; // Allow sort
        $this->infopackaging->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->infopackaging->Param, "CustomMsg");
        $this->Fields['infopackaging'] = &$this->infopackaging;

        // ukuran
        $this->ukuran = new DbField('order_pengembangan', 'order_pengembangan', 'x_ukuran', 'ukuran', '`ukuran`', '`ukuran`', 3, 11, -1, false, '`ukuran`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuran->Sortable = true; // Allow sort
        $this->ukuran->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ukuran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuran->Param, "CustomMsg");
        $this->Fields['ukuran'] = &$this->ukuran;

        // desainprodukkemasan
        $this->desainprodukkemasan = new DbField('order_pengembangan', 'order_pengembangan', 'x_desainprodukkemasan', 'desainprodukkemasan', '`desainprodukkemasan`', '`desainprodukkemasan`', 200, 50, -1, false, '`desainprodukkemasan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->desainprodukkemasan->Sortable = true; // Allow sort
        $this->desainprodukkemasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->desainprodukkemasan->Param, "CustomMsg");
        $this->Fields['desainprodukkemasan'] = &$this->desainprodukkemasan;

        // desaindiinginkan
        $this->desaindiinginkan = new DbField('order_pengembangan', 'order_pengembangan', 'x_desaindiinginkan', 'desaindiinginkan', '`desaindiinginkan`', '`desaindiinginkan`', 200, 150, -1, false, '`desaindiinginkan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->desaindiinginkan->Sortable = true; // Allow sort
        $this->desaindiinginkan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->desaindiinginkan->Param, "CustomMsg");
        $this->Fields['desaindiinginkan'] = &$this->desaindiinginkan;

        // mereknotifikasi
        $this->mereknotifikasi = new DbField('order_pengembangan', 'order_pengembangan', 'x_mereknotifikasi', 'mereknotifikasi', '`mereknotifikasi`', '`mereknotifikasi`', 200, 150, -1, false, '`mereknotifikasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->mereknotifikasi->Sortable = true; // Allow sort
        $this->mereknotifikasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->mereknotifikasi->Param, "CustomMsg");
        $this->Fields['mereknotifikasi'] = &$this->mereknotifikasi;

        // kategoristatus
        $this->kategoristatus = new DbField('order_pengembangan', 'order_pengembangan', 'x_kategoristatus', 'kategoristatus', '`kategoristatus`', '`kategoristatus`', 200, 150, -1, false, '`kategoristatus`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kategoristatus->Sortable = true; // Allow sort
        $this->kategoristatus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kategoristatus->Param, "CustomMsg");
        $this->Fields['kategoristatus'] = &$this->kategoristatus;

        // kemasan_ukuran_satuan
        $this->kemasan_ukuran_satuan = new DbField('order_pengembangan', 'order_pengembangan', 'x_kemasan_ukuran_satuan', 'kemasan_ukuran_satuan', '`kemasan_ukuran_satuan`', '`kemasan_ukuran_satuan`', 200, 150, -1, false, '`kemasan_ukuran_satuan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasan_ukuran_satuan->Sortable = true; // Allow sort
        $this->kemasan_ukuran_satuan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasan_ukuran_satuan->Param, "CustomMsg");
        $this->Fields['kemasan_ukuran_satuan'] = &$this->kemasan_ukuran_satuan;

        // notifikasicatatan
        $this->notifikasicatatan = new DbField('order_pengembangan', 'order_pengembangan', 'x_notifikasicatatan', 'notifikasicatatan', '`notifikasicatatan`', '`notifikasicatatan`', 201, 500, -1, false, '`notifikasicatatan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->notifikasicatatan->Sortable = true; // Allow sort
        $this->notifikasicatatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->notifikasicatatan->Param, "CustomMsg");
        $this->Fields['notifikasicatatan'] = &$this->notifikasicatatan;

        // label_ukuran
        $this->label_ukuran = new DbField('order_pengembangan', 'order_pengembangan', 'x_label_ukuran', 'label_ukuran', '`label_ukuran`', '`label_ukuran`', 201, 500, -1, false, '`label_ukuran`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->label_ukuran->Sortable = true; // Allow sort
        $this->label_ukuran->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->label_ukuran->Param, "CustomMsg");
        $this->Fields['label_ukuran'] = &$this->label_ukuran;

        // infolabel
        $this->infolabel = new DbField('order_pengembangan', 'order_pengembangan', 'x_infolabel', 'infolabel', '`infolabel`', '`infolabel`', 200, 150, -1, false, '`infolabel`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->infolabel->Sortable = true; // Allow sort
        $this->infolabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->infolabel->Param, "CustomMsg");
        $this->Fields['infolabel'] = &$this->infolabel;

        // labelkualitas
        $this->labelkualitas = new DbField('order_pengembangan', 'order_pengembangan', 'x_labelkualitas', 'labelkualitas', '`labelkualitas`', '`labelkualitas`', 200, 150, -1, false, '`labelkualitas`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->labelkualitas->Sortable = true; // Allow sort
        $this->labelkualitas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelkualitas->Param, "CustomMsg");
        $this->Fields['labelkualitas'] = &$this->labelkualitas;

        // labelposisi
        $this->labelposisi = new DbField('order_pengembangan', 'order_pengembangan', 'x_labelposisi', 'labelposisi', '`labelposisi`', '`labelposisi`', 200, 150, -1, false, '`labelposisi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->labelposisi->Sortable = true; // Allow sort
        $this->labelposisi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelposisi->Param, "CustomMsg");
        $this->Fields['labelposisi'] = &$this->labelposisi;

        // labelcatatan
        $this->labelcatatan = new DbField('order_pengembangan', 'order_pengembangan', 'x_labelcatatan', 'labelcatatan', '`labelcatatan`', '`labelcatatan`', 201, 500, -1, false, '`labelcatatan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->labelcatatan->Sortable = true; // Allow sort
        $this->labelcatatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->labelcatatan->Param, "CustomMsg");
        $this->Fields['labelcatatan'] = &$this->labelcatatan;

        // dibuatdi
        $this->dibuatdi = new DbField('order_pengembangan', 'order_pengembangan', 'x_dibuatdi', 'dibuatdi', '`dibuatdi`', '`dibuatdi`', 200, 150, -1, false, '`dibuatdi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->dibuatdi->Sortable = true; // Allow sort
        $this->dibuatdi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dibuatdi->Param, "CustomMsg");
        $this->Fields['dibuatdi'] = &$this->dibuatdi;

        // tanggal
        $this->tanggal = new DbField('order_pengembangan', 'order_pengembangan', 'x_tanggal', 'tanggal', '`tanggal`', CastDateFieldForLike("`tanggal`", 0, "dbpabrik"), 133, 10, 0, false, '`tanggal`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal->Sortable = true; // Allow sort
        $this->tanggal->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal->Param, "CustomMsg");
        $this->Fields['tanggal'] = &$this->tanggal;

        // penerima
        $this->penerima = new DbField('order_pengembangan', 'order_pengembangan', 'x_penerima', 'penerima', '`penerima`', '`penerima`', 3, 11, -1, false, '`penerima`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->penerima->Sortable = true; // Allow sort
        $this->penerima->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->penerima->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->penerima->Param, "CustomMsg");
        $this->Fields['penerima'] = &$this->penerima;

        // createat
        $this->createat = new DbField('order_pengembangan', 'order_pengembangan', 'x_createat', 'createat', '`createat`', CastDateFieldForLike("`createat`", 0, "dbpabrik"), 133, 10, 0, false, '`createat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->createat->Sortable = true; // Allow sort
        $this->createat->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->createat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->createat->Param, "CustomMsg");
        $this->Fields['createat'] = &$this->createat;

        // createby
        $this->createby = new DbField('order_pengembangan', 'order_pengembangan', 'x_createby', 'createby', '`createby`', '`createby`', 3, 11, -1, false, '`createby`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->createby->Sortable = true; // Allow sort
        $this->createby->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->createby->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->createby->Param, "CustomMsg");
        $this->Fields['createby'] = &$this->createby;

        // statusdokumen
        $this->statusdokumen = new DbField('order_pengembangan', 'order_pengembangan', 'x_statusdokumen', 'statusdokumen', '`statusdokumen`', '`statusdokumen`', 200, 50, -1, false, '`statusdokumen`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->statusdokumen->Sortable = true; // Allow sort
        $this->statusdokumen->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->statusdokumen->Param, "CustomMsg");
        $this->Fields['statusdokumen'] = &$this->statusdokumen;

        // update_at
        $this->update_at = new DbField('order_pengembangan', 'order_pengembangan', 'x_update_at', 'update_at', '`update_at`', CastDateFieldForLike("`update_at`", 0, "dbpabrik"), 135, 19, 0, false, '`update_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->update_at->Sortable = true; // Allow sort
        $this->update_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->update_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->update_at->Param, "CustomMsg");
        $this->Fields['update_at'] = &$this->update_at;

        // status_data
        $this->status_data = new DbField('order_pengembangan', 'order_pengembangan', 'x_status_data', 'status_data', '`status_data`', '`status_data`', 200, 50, -1, false, '`status_data`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status_data->Sortable = true; // Allow sort
        $this->status_data->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status_data->Param, "CustomMsg");
        $this->Fields['status_data'] = &$this->status_data;

        // harga_rnd
        $this->harga_rnd = new DbField('order_pengembangan', 'order_pengembangan', 'x_harga_rnd', 'harga_rnd', '`harga_rnd`', '`harga_rnd`', 131, 14, -1, false, '`harga_rnd`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->harga_rnd->Sortable = true; // Allow sort
        $this->harga_rnd->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->harga_rnd->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->harga_rnd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->harga_rnd->Param, "CustomMsg");
        $this->Fields['harga_rnd'] = &$this->harga_rnd;

        // aplikasi_sediaan
        $this->aplikasi_sediaan = new DbField('order_pengembangan', 'order_pengembangan', 'x_aplikasi_sediaan', 'aplikasi_sediaan', '`aplikasi_sediaan`', '`aplikasi_sediaan`', 200, 100, -1, false, '`aplikasi_sediaan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aplikasi_sediaan->Sortable = true; // Allow sort
        $this->aplikasi_sediaan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aplikasi_sediaan->Param, "CustomMsg");
        $this->Fields['aplikasi_sediaan'] = &$this->aplikasi_sediaan;

        // hu_hrg_isi
        $this->hu_hrg_isi = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_isi', 'hu_hrg_isi', '`hu_hrg_isi`', '`hu_hrg_isi`', 131, 10, -1, false, '`hu_hrg_isi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_isi->Sortable = true; // Allow sort
        $this->hu_hrg_isi->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_isi->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_isi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_isi->Param, "CustomMsg");
        $this->Fields['hu_hrg_isi'] = &$this->hu_hrg_isi;

        // hu_hrg_isi_pro
        $this->hu_hrg_isi_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_isi_pro', 'hu_hrg_isi_pro', '`hu_hrg_isi_pro`', '`hu_hrg_isi_pro`', 131, 10, -1, false, '`hu_hrg_isi_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_isi_pro->Sortable = true; // Allow sort
        $this->hu_hrg_isi_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_isi_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_isi_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_isi_pro->Param, "CustomMsg");
        $this->Fields['hu_hrg_isi_pro'] = &$this->hu_hrg_isi_pro;

        // hu_hrg_kms_primer
        $this->hu_hrg_kms_primer = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_kms_primer', 'hu_hrg_kms_primer', '`hu_hrg_kms_primer`', '`hu_hrg_kms_primer`', 131, 10, -1, false, '`hu_hrg_kms_primer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_kms_primer->Sortable = true; // Allow sort
        $this->hu_hrg_kms_primer->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_kms_primer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_kms_primer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_kms_primer->Param, "CustomMsg");
        $this->Fields['hu_hrg_kms_primer'] = &$this->hu_hrg_kms_primer;

        // hu_hrg_kms_primer_pro
        $this->hu_hrg_kms_primer_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_kms_primer_pro', 'hu_hrg_kms_primer_pro', '`hu_hrg_kms_primer_pro`', '`hu_hrg_kms_primer_pro`', 131, 10, -1, false, '`hu_hrg_kms_primer_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_kms_primer_pro->Sortable = true; // Allow sort
        $this->hu_hrg_kms_primer_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_kms_primer_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_kms_primer_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_kms_primer_pro->Param, "CustomMsg");
        $this->Fields['hu_hrg_kms_primer_pro'] = &$this->hu_hrg_kms_primer_pro;

        // hu_hrg_kms_sekunder
        $this->hu_hrg_kms_sekunder = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_kms_sekunder', 'hu_hrg_kms_sekunder', '`hu_hrg_kms_sekunder`', '`hu_hrg_kms_sekunder`', 131, 10, -1, false, '`hu_hrg_kms_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_kms_sekunder->Sortable = true; // Allow sort
        $this->hu_hrg_kms_sekunder->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_kms_sekunder->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_kms_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_kms_sekunder->Param, "CustomMsg");
        $this->Fields['hu_hrg_kms_sekunder'] = &$this->hu_hrg_kms_sekunder;

        // hu_hrg_kms_sekunder_pro
        $this->hu_hrg_kms_sekunder_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_kms_sekunder_pro', 'hu_hrg_kms_sekunder_pro', '`hu_hrg_kms_sekunder_pro`', '`hu_hrg_kms_sekunder_pro`', 131, 10, -1, false, '`hu_hrg_kms_sekunder_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_kms_sekunder_pro->Sortable = true; // Allow sort
        $this->hu_hrg_kms_sekunder_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_kms_sekunder_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_kms_sekunder_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_kms_sekunder_pro->Param, "CustomMsg");
        $this->Fields['hu_hrg_kms_sekunder_pro'] = &$this->hu_hrg_kms_sekunder_pro;

        // hu_hrg_label
        $this->hu_hrg_label = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_label', 'hu_hrg_label', '`hu_hrg_label`', '`hu_hrg_label`', 131, 10, -1, false, '`hu_hrg_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_label->Sortable = true; // Allow sort
        $this->hu_hrg_label->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_label->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_label->Param, "CustomMsg");
        $this->Fields['hu_hrg_label'] = &$this->hu_hrg_label;

        // hu_hrg_label_pro
        $this->hu_hrg_label_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_label_pro', 'hu_hrg_label_pro', '`hu_hrg_label_pro`', '`hu_hrg_label_pro`', 131, 10, -1, false, '`hu_hrg_label_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_label_pro->Sortable = true; // Allow sort
        $this->hu_hrg_label_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_label_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_label_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_label_pro->Param, "CustomMsg");
        $this->Fields['hu_hrg_label_pro'] = &$this->hu_hrg_label_pro;

        // hu_hrg_total
        $this->hu_hrg_total = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_total', 'hu_hrg_total', '`hu_hrg_total`', '`hu_hrg_total`', 131, 10, -1, false, '`hu_hrg_total`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_total->Sortable = true; // Allow sort
        $this->hu_hrg_total->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_total->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_total->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_total->Param, "CustomMsg");
        $this->Fields['hu_hrg_total'] = &$this->hu_hrg_total;

        // hu_hrg_total_pro
        $this->hu_hrg_total_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hu_hrg_total_pro', 'hu_hrg_total_pro', '`hu_hrg_total_pro`', '`hu_hrg_total_pro`', 131, 10, -1, false, '`hu_hrg_total_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hu_hrg_total_pro->Sortable = true; // Allow sort
        $this->hu_hrg_total_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hu_hrg_total_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hu_hrg_total_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hu_hrg_total_pro->Param, "CustomMsg");
        $this->Fields['hu_hrg_total_pro'] = &$this->hu_hrg_total_pro;

        // hl_hrg_isi
        $this->hl_hrg_isi = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_isi', 'hl_hrg_isi', '`hl_hrg_isi`', '`hl_hrg_isi`', 131, 10, -1, false, '`hl_hrg_isi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_isi->Sortable = true; // Allow sort
        $this->hl_hrg_isi->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_isi->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_isi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_isi->Param, "CustomMsg");
        $this->Fields['hl_hrg_isi'] = &$this->hl_hrg_isi;

        // hl_hrg_isi_pro
        $this->hl_hrg_isi_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_isi_pro', 'hl_hrg_isi_pro', '`hl_hrg_isi_pro`', '`hl_hrg_isi_pro`', 131, 10, -1, false, '`hl_hrg_isi_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_isi_pro->Sortable = true; // Allow sort
        $this->hl_hrg_isi_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_isi_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_isi_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_isi_pro->Param, "CustomMsg");
        $this->Fields['hl_hrg_isi_pro'] = &$this->hl_hrg_isi_pro;

        // hl_hrg_kms_primer
        $this->hl_hrg_kms_primer = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_kms_primer', 'hl_hrg_kms_primer', '`hl_hrg_kms_primer`', '`hl_hrg_kms_primer`', 131, 10, -1, false, '`hl_hrg_kms_primer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_kms_primer->Sortable = true; // Allow sort
        $this->hl_hrg_kms_primer->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_kms_primer->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_kms_primer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_kms_primer->Param, "CustomMsg");
        $this->Fields['hl_hrg_kms_primer'] = &$this->hl_hrg_kms_primer;

        // hl_hrg_kms_primer_pro
        $this->hl_hrg_kms_primer_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_kms_primer_pro', 'hl_hrg_kms_primer_pro', '`hl_hrg_kms_primer_pro`', '`hl_hrg_kms_primer_pro`', 131, 10, -1, false, '`hl_hrg_kms_primer_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_kms_primer_pro->Sortable = true; // Allow sort
        $this->hl_hrg_kms_primer_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_kms_primer_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_kms_primer_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_kms_primer_pro->Param, "CustomMsg");
        $this->Fields['hl_hrg_kms_primer_pro'] = &$this->hl_hrg_kms_primer_pro;

        // hl_hrg_kms_sekunder
        $this->hl_hrg_kms_sekunder = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_kms_sekunder', 'hl_hrg_kms_sekunder', '`hl_hrg_kms_sekunder`', '`hl_hrg_kms_sekunder`', 131, 10, -1, false, '`hl_hrg_kms_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_kms_sekunder->Sortable = true; // Allow sort
        $this->hl_hrg_kms_sekunder->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_kms_sekunder->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_kms_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_kms_sekunder->Param, "CustomMsg");
        $this->Fields['hl_hrg_kms_sekunder'] = &$this->hl_hrg_kms_sekunder;

        // hl_hrg_kms_sekunder_pro
        $this->hl_hrg_kms_sekunder_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_kms_sekunder_pro', 'hl_hrg_kms_sekunder_pro', '`hl_hrg_kms_sekunder_pro`', '`hl_hrg_kms_sekunder_pro`', 131, 10, -1, false, '`hl_hrg_kms_sekunder_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_kms_sekunder_pro->Sortable = true; // Allow sort
        $this->hl_hrg_kms_sekunder_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_kms_sekunder_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_kms_sekunder_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_kms_sekunder_pro->Param, "CustomMsg");
        $this->Fields['hl_hrg_kms_sekunder_pro'] = &$this->hl_hrg_kms_sekunder_pro;

        // hl_hrg_label
        $this->hl_hrg_label = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_label', 'hl_hrg_label', '`hl_hrg_label`', '`hl_hrg_label`', 131, 10, -1, false, '`hl_hrg_label`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_label->Sortable = true; // Allow sort
        $this->hl_hrg_label->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_label->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_label->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_label->Param, "CustomMsg");
        $this->Fields['hl_hrg_label'] = &$this->hl_hrg_label;

        // hl_hrg_label_pro
        $this->hl_hrg_label_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_label_pro', 'hl_hrg_label_pro', '`hl_hrg_label_pro`', '`hl_hrg_label_pro`', 131, 10, -1, false, '`hl_hrg_label_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_label_pro->Sortable = true; // Allow sort
        $this->hl_hrg_label_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_label_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_label_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_label_pro->Param, "CustomMsg");
        $this->Fields['hl_hrg_label_pro'] = &$this->hl_hrg_label_pro;

        // hl_hrg_total
        $this->hl_hrg_total = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_total', 'hl_hrg_total', '`hl_hrg_total`', '`hl_hrg_total`', 131, 10, -1, false, '`hl_hrg_total`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_total->Sortable = true; // Allow sort
        $this->hl_hrg_total->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_total->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_total->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_total->Param, "CustomMsg");
        $this->Fields['hl_hrg_total'] = &$this->hl_hrg_total;

        // hl_hrg_total_pro
        $this->hl_hrg_total_pro = new DbField('order_pengembangan', 'order_pengembangan', 'x_hl_hrg_total_pro', 'hl_hrg_total_pro', '`hl_hrg_total_pro`', '`hl_hrg_total_pro`', 131, 10, -1, false, '`hl_hrg_total_pro`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hl_hrg_total_pro->Sortable = true; // Allow sort
        $this->hl_hrg_total_pro->DefaultDecimalPrecision = 2; // Default decimal precision
        $this->hl_hrg_total_pro->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hl_hrg_total_pro->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hl_hrg_total_pro->Param, "CustomMsg");
        $this->Fields['hl_hrg_total_pro'] = &$this->hl_hrg_total_pro;

        // bs_bahan_aktif_tick
        $this->bs_bahan_aktif_tick = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_bahan_aktif_tick', 'bs_bahan_aktif_tick', '`bs_bahan_aktif_tick`', '`bs_bahan_aktif_tick`', 200, 1, -1, false, '`bs_bahan_aktif_tick`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bs_bahan_aktif_tick->Sortable = true; // Allow sort
        $this->bs_bahan_aktif_tick->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_bahan_aktif_tick->Param, "CustomMsg");
        $this->Fields['bs_bahan_aktif_tick'] = &$this->bs_bahan_aktif_tick;

        // bs_bahan_aktif
        $this->bs_bahan_aktif = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_bahan_aktif', 'bs_bahan_aktif', '`bs_bahan_aktif`', '`bs_bahan_aktif`', 201, 500, -1, false, '`bs_bahan_aktif`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_bahan_aktif->Sortable = true; // Allow sort
        $this->bs_bahan_aktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_bahan_aktif->Param, "CustomMsg");
        $this->Fields['bs_bahan_aktif'] = &$this->bs_bahan_aktif;

        // bs_bahan_lain
        $this->bs_bahan_lain = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_bahan_lain', 'bs_bahan_lain', '`bs_bahan_lain`', '`bs_bahan_lain`', 201, 500, -1, false, '`bs_bahan_lain`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_bahan_lain->Sortable = true; // Allow sort
        $this->bs_bahan_lain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_bahan_lain->Param, "CustomMsg");
        $this->Fields['bs_bahan_lain'] = &$this->bs_bahan_lain;

        // bs_parfum
        $this->bs_parfum = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_parfum', 'bs_parfum', '`bs_parfum`', '`bs_parfum`', 201, 500, -1, false, '`bs_parfum`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_parfum->Sortable = true; // Allow sort
        $this->bs_parfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_parfum->Param, "CustomMsg");
        $this->Fields['bs_parfum'] = &$this->bs_parfum;

        // bs_estetika
        $this->bs_estetika = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_estetika', 'bs_estetika', '`bs_estetika`', '`bs_estetika`', 201, 500, -1, false, '`bs_estetika`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_estetika->Sortable = true; // Allow sort
        $this->bs_estetika->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_estetika->Param, "CustomMsg");
        $this->Fields['bs_estetika'] = &$this->bs_estetika;

        // bs_kms_wadah
        $this->bs_kms_wadah = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_kms_wadah', 'bs_kms_wadah', '`bs_kms_wadah`', '`bs_kms_wadah`', 201, 500, -1, false, '`bs_kms_wadah`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_kms_wadah->Sortable = true; // Allow sort
        $this->bs_kms_wadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_kms_wadah->Param, "CustomMsg");
        $this->Fields['bs_kms_wadah'] = &$this->bs_kms_wadah;

        // bs_kms_tutup
        $this->bs_kms_tutup = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_kms_tutup', 'bs_kms_tutup', '`bs_kms_tutup`', '`bs_kms_tutup`', 201, 500, -1, false, '`bs_kms_tutup`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_kms_tutup->Sortable = true; // Allow sort
        $this->bs_kms_tutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_kms_tutup->Param, "CustomMsg");
        $this->Fields['bs_kms_tutup'] = &$this->bs_kms_tutup;

        // bs_kms_sekunder
        $this->bs_kms_sekunder = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_kms_sekunder', 'bs_kms_sekunder', '`bs_kms_sekunder`', '`bs_kms_sekunder`', 201, 500, -1, false, '`bs_kms_sekunder`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_kms_sekunder->Sortable = true; // Allow sort
        $this->bs_kms_sekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_kms_sekunder->Param, "CustomMsg");
        $this->Fields['bs_kms_sekunder'] = &$this->bs_kms_sekunder;

        // bs_label_desain
        $this->bs_label_desain = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_label_desain', 'bs_label_desain', '`bs_label_desain`', '`bs_label_desain`', 201, 500, -1, false, '`bs_label_desain`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_label_desain->Sortable = true; // Allow sort
        $this->bs_label_desain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_label_desain->Param, "CustomMsg");
        $this->Fields['bs_label_desain'] = &$this->bs_label_desain;

        // bs_label_cetak
        $this->bs_label_cetak = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_label_cetak', 'bs_label_cetak', '`bs_label_cetak`', '`bs_label_cetak`', 201, 500, -1, false, '`bs_label_cetak`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_label_cetak->Sortable = true; // Allow sort
        $this->bs_label_cetak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_label_cetak->Param, "CustomMsg");
        $this->Fields['bs_label_cetak'] = &$this->bs_label_cetak;

        // bs_label_lain
        $this->bs_label_lain = new DbField('order_pengembangan', 'order_pengembangan', 'x_bs_label_lain', 'bs_label_lain', '`bs_label_lain`', '`bs_label_lain`', 201, 500, -1, false, '`bs_label_lain`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->bs_label_lain->Sortable = true; // Allow sort
        $this->bs_label_lain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bs_label_lain->Param, "CustomMsg");
        $this->Fields['bs_label_lain'] = &$this->bs_label_lain;

        // dlv_pickup
        $this->dlv_pickup = new DbField('order_pengembangan', 'order_pengembangan', 'x_dlv_pickup', 'dlv_pickup', '`dlv_pickup`', '`dlv_pickup`', 201, 500, -1, false, '`dlv_pickup`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->dlv_pickup->Sortable = true; // Allow sort
        $this->dlv_pickup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dlv_pickup->Param, "CustomMsg");
        $this->Fields['dlv_pickup'] = &$this->dlv_pickup;

        // dlv_singlepoint
        $this->dlv_singlepoint = new DbField('order_pengembangan', 'order_pengembangan', 'x_dlv_singlepoint', 'dlv_singlepoint', '`dlv_singlepoint`', '`dlv_singlepoint`', 201, 500, -1, false, '`dlv_singlepoint`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->dlv_singlepoint->Sortable = true; // Allow sort
        $this->dlv_singlepoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dlv_singlepoint->Param, "CustomMsg");
        $this->Fields['dlv_singlepoint'] = &$this->dlv_singlepoint;

        // dlv_multipoint
        $this->dlv_multipoint = new DbField('order_pengembangan', 'order_pengembangan', 'x_dlv_multipoint', 'dlv_multipoint', '`dlv_multipoint`', '`dlv_multipoint`', 201, 500, -1, false, '`dlv_multipoint`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->dlv_multipoint->Sortable = true; // Allow sort
        $this->dlv_multipoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dlv_multipoint->Param, "CustomMsg");
        $this->Fields['dlv_multipoint'] = &$this->dlv_multipoint;

        // dlv_multipoint_jml
        $this->dlv_multipoint_jml = new DbField('order_pengembangan', 'order_pengembangan', 'x_dlv_multipoint_jml', 'dlv_multipoint_jml', '`dlv_multipoint_jml`', '`dlv_multipoint_jml`', 201, 500, -1, false, '`dlv_multipoint_jml`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->dlv_multipoint_jml->Sortable = true; // Allow sort
        $this->dlv_multipoint_jml->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dlv_multipoint_jml->Param, "CustomMsg");
        $this->Fields['dlv_multipoint_jml'] = &$this->dlv_multipoint_jml;

        // dlv_term_lain
        $this->dlv_term_lain = new DbField('order_pengembangan', 'order_pengembangan', 'x_dlv_term_lain', 'dlv_term_lain', '`dlv_term_lain`', '`dlv_term_lain`', 201, 500, -1, false, '`dlv_term_lain`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->dlv_term_lain->Sortable = true; // Allow sort
        $this->dlv_term_lain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dlv_term_lain->Param, "CustomMsg");
        $this->Fields['dlv_term_lain'] = &$this->dlv_term_lain;

        // catatan_khusus
        $this->catatan_khusus = new DbField('order_pengembangan', 'order_pengembangan', 'x_catatan_khusus', 'catatan_khusus', '`catatan_khusus`', '`catatan_khusus`', 201, 500, -1, false, '`catatan_khusus`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->catatan_khusus->Sortable = true; // Allow sort
        $this->catatan_khusus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->catatan_khusus->Param, "CustomMsg");
        $this->Fields['catatan_khusus'] = &$this->catatan_khusus;

        // aju_tgl
        $this->aju_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_aju_tgl', 'aju_tgl', '`aju_tgl`', CastDateFieldForLike("`aju_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`aju_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aju_tgl->Sortable = true; // Allow sort
        $this->aju_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->aju_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aju_tgl->Param, "CustomMsg");
        $this->Fields['aju_tgl'] = &$this->aju_tgl;

        // aju_oleh
        $this->aju_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_aju_oleh', 'aju_oleh', '`aju_oleh`', '`aju_oleh`', 3, 11, -1, false, '`aju_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aju_oleh->Sortable = true; // Allow sort
        $this->aju_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->aju_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aju_oleh->Param, "CustomMsg");
        $this->Fields['aju_oleh'] = &$this->aju_oleh;

        // proses_tgl
        $this->proses_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_proses_tgl', 'proses_tgl', '`proses_tgl`', CastDateFieldForLike("`proses_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`proses_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->proses_tgl->Sortable = true; // Allow sort
        $this->proses_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->proses_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->proses_tgl->Param, "CustomMsg");
        $this->Fields['proses_tgl'] = &$this->proses_tgl;

        // proses_oleh
        $this->proses_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_proses_oleh', 'proses_oleh', '`proses_oleh`', '`proses_oleh`', 3, 11, -1, false, '`proses_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->proses_oleh->Sortable = true; // Allow sort
        $this->proses_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proses_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->proses_oleh->Param, "CustomMsg");
        $this->Fields['proses_oleh'] = &$this->proses_oleh;

        // revisi_tgl
        $this->revisi_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_revisi_tgl', 'revisi_tgl', '`revisi_tgl`', CastDateFieldForLike("`revisi_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`revisi_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->revisi_tgl->Sortable = true; // Allow sort
        $this->revisi_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->revisi_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->revisi_tgl->Param, "CustomMsg");
        $this->Fields['revisi_tgl'] = &$this->revisi_tgl;

        // revisi_oleh
        $this->revisi_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_revisi_oleh', 'revisi_oleh', '`revisi_oleh`', '`revisi_oleh`', 3, 11, -1, false, '`revisi_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->revisi_oleh->Sortable = true; // Allow sort
        $this->revisi_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->revisi_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->revisi_oleh->Param, "CustomMsg");
        $this->Fields['revisi_oleh'] = &$this->revisi_oleh;

        // revisi_akun_tgl
        $this->revisi_akun_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_revisi_akun_tgl', 'revisi_akun_tgl', '`revisi_akun_tgl`', CastDateFieldForLike("`revisi_akun_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`revisi_akun_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->revisi_akun_tgl->Sortable = true; // Allow sort
        $this->revisi_akun_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->revisi_akun_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->revisi_akun_tgl->Param, "CustomMsg");
        $this->Fields['revisi_akun_tgl'] = &$this->revisi_akun_tgl;

        // revisi_akun_oleh
        $this->revisi_akun_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_revisi_akun_oleh', 'revisi_akun_oleh', '`revisi_akun_oleh`', '`revisi_akun_oleh`', 3, 11, -1, false, '`revisi_akun_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->revisi_akun_oleh->Sortable = true; // Allow sort
        $this->revisi_akun_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->revisi_akun_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->revisi_akun_oleh->Param, "CustomMsg");
        $this->Fields['revisi_akun_oleh'] = &$this->revisi_akun_oleh;

        // revisi_rnd_tgl
        $this->revisi_rnd_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_revisi_rnd_tgl', 'revisi_rnd_tgl', '`revisi_rnd_tgl`', CastDateFieldForLike("`revisi_rnd_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`revisi_rnd_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->revisi_rnd_tgl->Sortable = true; // Allow sort
        $this->revisi_rnd_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->revisi_rnd_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->revisi_rnd_tgl->Param, "CustomMsg");
        $this->Fields['revisi_rnd_tgl'] = &$this->revisi_rnd_tgl;

        // revisi_rnd_oleh
        $this->revisi_rnd_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_revisi_rnd_oleh', 'revisi_rnd_oleh', '`revisi_rnd_oleh`', '`revisi_rnd_oleh`', 3, 11, -1, false, '`revisi_rnd_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->revisi_rnd_oleh->Sortable = true; // Allow sort
        $this->revisi_rnd_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->revisi_rnd_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->revisi_rnd_oleh->Param, "CustomMsg");
        $this->Fields['revisi_rnd_oleh'] = &$this->revisi_rnd_oleh;

        // rnd_tgl
        $this->rnd_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_rnd_tgl', 'rnd_tgl', '`rnd_tgl`', CastDateFieldForLike("`rnd_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`rnd_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->rnd_tgl->Sortable = true; // Allow sort
        $this->rnd_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->rnd_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->rnd_tgl->Param, "CustomMsg");
        $this->Fields['rnd_tgl'] = &$this->rnd_tgl;

        // rnd_oleh
        $this->rnd_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_rnd_oleh', 'rnd_oleh', '`rnd_oleh`', '`rnd_oleh`', 3, 11, -1, false, '`rnd_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->rnd_oleh->Sortable = true; // Allow sort
        $this->rnd_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->rnd_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->rnd_oleh->Param, "CustomMsg");
        $this->Fields['rnd_oleh'] = &$this->rnd_oleh;

        // ap_tgl
        $this->ap_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_ap_tgl', 'ap_tgl', '`ap_tgl`', CastDateFieldForLike("`ap_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`ap_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ap_tgl->Sortable = true; // Allow sort
        $this->ap_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->ap_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ap_tgl->Param, "CustomMsg");
        $this->Fields['ap_tgl'] = &$this->ap_tgl;

        // ap_oleh
        $this->ap_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_ap_oleh', 'ap_oleh', '`ap_oleh`', '`ap_oleh`', 3, 11, -1, false, '`ap_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ap_oleh->Sortable = true; // Allow sort
        $this->ap_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->ap_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ap_oleh->Param, "CustomMsg");
        $this->Fields['ap_oleh'] = &$this->ap_oleh;

        // batal_tgl
        $this->batal_tgl = new DbField('order_pengembangan', 'order_pengembangan', 'x_batal_tgl', 'batal_tgl', '`batal_tgl`', CastDateFieldForLike("`batal_tgl`", 0, "dbpabrik"), 135, 19, 0, false, '`batal_tgl`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->batal_tgl->Sortable = true; // Allow sort
        $this->batal_tgl->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->batal_tgl->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->batal_tgl->Param, "CustomMsg");
        $this->Fields['batal_tgl'] = &$this->batal_tgl;

        // batal_oleh
        $this->batal_oleh = new DbField('order_pengembangan', 'order_pengembangan', 'x_batal_oleh', 'batal_oleh', '`batal_oleh`', '`batal_oleh`', 3, 11, -1, false, '`batal_oleh`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->batal_oleh->Sortable = true; // Allow sort
        $this->batal_oleh->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->batal_oleh->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->batal_oleh->Param, "CustomMsg");
        $this->Fields['batal_oleh'] = &$this->batal_oleh;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`order_pengembangan`";
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
        $this->cpo_jenis->DbValue = $row['cpo_jenis'];
        $this->ordernum->DbValue = $row['ordernum'];
        $this->order_kode->DbValue = $row['order_kode'];
        $this->orderterimatgl->DbValue = $row['orderterimatgl'];
        $this->produk_fungsi->DbValue = $row['produk_fungsi'];
        $this->produk_kualitas->DbValue = $row['produk_kualitas'];
        $this->produk_campaign->DbValue = $row['produk_campaign'];
        $this->kemasan_satuan->DbValue = $row['kemasan_satuan'];
        $this->ordertgl->DbValue = $row['ordertgl'];
        $this->custcode->DbValue = $row['custcode'];
        $this->perushnama->DbValue = $row['perushnama'];
        $this->perushalamat->DbValue = $row['perushalamat'];
        $this->perushcp->DbValue = $row['perushcp'];
        $this->perushjabatan->DbValue = $row['perushjabatan'];
        $this->perushphone->DbValue = $row['perushphone'];
        $this->perushmobile->DbValue = $row['perushmobile'];
        $this->bencmark->DbValue = $row['bencmark'];
        $this->kategoriproduk->DbValue = $row['kategoriproduk'];
        $this->jenisproduk->DbValue = $row['jenisproduk'];
        $this->bentuksediaan->DbValue = $row['bentuksediaan'];
        $this->sediaan_ukuran->DbValue = $row['sediaan_ukuran'];
        $this->sediaan_ukuran_satuan->DbValue = $row['sediaan_ukuran_satuan'];
        $this->produk_viskositas->DbValue = $row['produk_viskositas'];
        $this->konsepproduk->DbValue = $row['konsepproduk'];
        $this->fragrance->DbValue = $row['fragrance'];
        $this->aroma->DbValue = $row['aroma'];
        $this->bahanaktif->DbValue = $row['bahanaktif'];
        $this->warna->DbValue = $row['warna'];
        $this->produk_warna_jenis->DbValue = $row['produk_warna_jenis'];
        $this->aksesoris->DbValue = $row['aksesoris'];
        $this->produk_lainlain->DbValue = $row['produk_lainlain'];
        $this->statusproduk->DbValue = $row['statusproduk'];
        $this->parfum->DbValue = $row['parfum'];
        $this->catatan->DbValue = $row['catatan'];
        $this->rencanakemasan->DbValue = $row['rencanakemasan'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->ekspetasiharga->DbValue = $row['ekspetasiharga'];
        $this->kemasan->DbValue = $row['kemasan'];
        $this->volume->DbValue = $row['volume'];
        $this->jenistutup->DbValue = $row['jenistutup'];
        $this->catatanpackaging->DbValue = $row['catatanpackaging'];
        $this->infopackaging->DbValue = $row['infopackaging'];
        $this->ukuran->DbValue = $row['ukuran'];
        $this->desainprodukkemasan->DbValue = $row['desainprodukkemasan'];
        $this->desaindiinginkan->DbValue = $row['desaindiinginkan'];
        $this->mereknotifikasi->DbValue = $row['mereknotifikasi'];
        $this->kategoristatus->DbValue = $row['kategoristatus'];
        $this->kemasan_ukuran_satuan->DbValue = $row['kemasan_ukuran_satuan'];
        $this->notifikasicatatan->DbValue = $row['notifikasicatatan'];
        $this->label_ukuran->DbValue = $row['label_ukuran'];
        $this->infolabel->DbValue = $row['infolabel'];
        $this->labelkualitas->DbValue = $row['labelkualitas'];
        $this->labelposisi->DbValue = $row['labelposisi'];
        $this->labelcatatan->DbValue = $row['labelcatatan'];
        $this->dibuatdi->DbValue = $row['dibuatdi'];
        $this->tanggal->DbValue = $row['tanggal'];
        $this->penerima->DbValue = $row['penerima'];
        $this->createat->DbValue = $row['createat'];
        $this->createby->DbValue = $row['createby'];
        $this->statusdokumen->DbValue = $row['statusdokumen'];
        $this->update_at->DbValue = $row['update_at'];
        $this->status_data->DbValue = $row['status_data'];
        $this->harga_rnd->DbValue = $row['harga_rnd'];
        $this->aplikasi_sediaan->DbValue = $row['aplikasi_sediaan'];
        $this->hu_hrg_isi->DbValue = $row['hu_hrg_isi'];
        $this->hu_hrg_isi_pro->DbValue = $row['hu_hrg_isi_pro'];
        $this->hu_hrg_kms_primer->DbValue = $row['hu_hrg_kms_primer'];
        $this->hu_hrg_kms_primer_pro->DbValue = $row['hu_hrg_kms_primer_pro'];
        $this->hu_hrg_kms_sekunder->DbValue = $row['hu_hrg_kms_sekunder'];
        $this->hu_hrg_kms_sekunder_pro->DbValue = $row['hu_hrg_kms_sekunder_pro'];
        $this->hu_hrg_label->DbValue = $row['hu_hrg_label'];
        $this->hu_hrg_label_pro->DbValue = $row['hu_hrg_label_pro'];
        $this->hu_hrg_total->DbValue = $row['hu_hrg_total'];
        $this->hu_hrg_total_pro->DbValue = $row['hu_hrg_total_pro'];
        $this->hl_hrg_isi->DbValue = $row['hl_hrg_isi'];
        $this->hl_hrg_isi_pro->DbValue = $row['hl_hrg_isi_pro'];
        $this->hl_hrg_kms_primer->DbValue = $row['hl_hrg_kms_primer'];
        $this->hl_hrg_kms_primer_pro->DbValue = $row['hl_hrg_kms_primer_pro'];
        $this->hl_hrg_kms_sekunder->DbValue = $row['hl_hrg_kms_sekunder'];
        $this->hl_hrg_kms_sekunder_pro->DbValue = $row['hl_hrg_kms_sekunder_pro'];
        $this->hl_hrg_label->DbValue = $row['hl_hrg_label'];
        $this->hl_hrg_label_pro->DbValue = $row['hl_hrg_label_pro'];
        $this->hl_hrg_total->DbValue = $row['hl_hrg_total'];
        $this->hl_hrg_total_pro->DbValue = $row['hl_hrg_total_pro'];
        $this->bs_bahan_aktif_tick->DbValue = $row['bs_bahan_aktif_tick'];
        $this->bs_bahan_aktif->DbValue = $row['bs_bahan_aktif'];
        $this->bs_bahan_lain->DbValue = $row['bs_bahan_lain'];
        $this->bs_parfum->DbValue = $row['bs_parfum'];
        $this->bs_estetika->DbValue = $row['bs_estetika'];
        $this->bs_kms_wadah->DbValue = $row['bs_kms_wadah'];
        $this->bs_kms_tutup->DbValue = $row['bs_kms_tutup'];
        $this->bs_kms_sekunder->DbValue = $row['bs_kms_sekunder'];
        $this->bs_label_desain->DbValue = $row['bs_label_desain'];
        $this->bs_label_cetak->DbValue = $row['bs_label_cetak'];
        $this->bs_label_lain->DbValue = $row['bs_label_lain'];
        $this->dlv_pickup->DbValue = $row['dlv_pickup'];
        $this->dlv_singlepoint->DbValue = $row['dlv_singlepoint'];
        $this->dlv_multipoint->DbValue = $row['dlv_multipoint'];
        $this->dlv_multipoint_jml->DbValue = $row['dlv_multipoint_jml'];
        $this->dlv_term_lain->DbValue = $row['dlv_term_lain'];
        $this->catatan_khusus->DbValue = $row['catatan_khusus'];
        $this->aju_tgl->DbValue = $row['aju_tgl'];
        $this->aju_oleh->DbValue = $row['aju_oleh'];
        $this->proses_tgl->DbValue = $row['proses_tgl'];
        $this->proses_oleh->DbValue = $row['proses_oleh'];
        $this->revisi_tgl->DbValue = $row['revisi_tgl'];
        $this->revisi_oleh->DbValue = $row['revisi_oleh'];
        $this->revisi_akun_tgl->DbValue = $row['revisi_akun_tgl'];
        $this->revisi_akun_oleh->DbValue = $row['revisi_akun_oleh'];
        $this->revisi_rnd_tgl->DbValue = $row['revisi_rnd_tgl'];
        $this->revisi_rnd_oleh->DbValue = $row['revisi_rnd_oleh'];
        $this->rnd_tgl->DbValue = $row['rnd_tgl'];
        $this->rnd_oleh->DbValue = $row['rnd_oleh'];
        $this->ap_tgl->DbValue = $row['ap_tgl'];
        $this->ap_oleh->DbValue = $row['ap_oleh'];
        $this->batal_tgl->DbValue = $row['batal_tgl'];
        $this->batal_oleh->DbValue = $row['batal_oleh'];
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
        return $_SESSION[$name] ?? GetUrl("OrderPengembanganList");
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
        if ($pageName == "OrderPengembanganView") {
            return $Language->phrase("View");
        } elseif ($pageName == "OrderPengembanganEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "OrderPengembanganAdd") {
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
                return "OrderPengembanganView";
            case Config("API_ADD_ACTION"):
                return "OrderPengembanganAdd";
            case Config("API_EDIT_ACTION"):
                return "OrderPengembanganEdit";
            case Config("API_DELETE_ACTION"):
                return "OrderPengembanganDelete";
            case Config("API_LIST_ACTION"):
                return "OrderPengembanganList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "OrderPengembanganList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("OrderPengembanganView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("OrderPengembanganView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "OrderPengembanganAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "OrderPengembanganAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("OrderPengembanganEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("OrderPengembanganAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("OrderPengembanganDelete", $this->getUrlParm());
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
        $this->cpo_jenis->setDbValue($row['cpo_jenis']);
        $this->ordernum->setDbValue($row['ordernum']);
        $this->order_kode->setDbValue($row['order_kode']);
        $this->orderterimatgl->setDbValue($row['orderterimatgl']);
        $this->produk_fungsi->setDbValue($row['produk_fungsi']);
        $this->produk_kualitas->setDbValue($row['produk_kualitas']);
        $this->produk_campaign->setDbValue($row['produk_campaign']);
        $this->kemasan_satuan->setDbValue($row['kemasan_satuan']);
        $this->ordertgl->setDbValue($row['ordertgl']);
        $this->custcode->setDbValue($row['custcode']);
        $this->perushnama->setDbValue($row['perushnama']);
        $this->perushalamat->setDbValue($row['perushalamat']);
        $this->perushcp->setDbValue($row['perushcp']);
        $this->perushjabatan->setDbValue($row['perushjabatan']);
        $this->perushphone->setDbValue($row['perushphone']);
        $this->perushmobile->setDbValue($row['perushmobile']);
        $this->bencmark->setDbValue($row['bencmark']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->bentuksediaan->setDbValue($row['bentuksediaan']);
        $this->sediaan_ukuran->setDbValue($row['sediaan_ukuran']);
        $this->sediaan_ukuran_satuan->setDbValue($row['sediaan_ukuran_satuan']);
        $this->produk_viskositas->setDbValue($row['produk_viskositas']);
        $this->konsepproduk->setDbValue($row['konsepproduk']);
        $this->fragrance->setDbValue($row['fragrance']);
        $this->aroma->setDbValue($row['aroma']);
        $this->bahanaktif->setDbValue($row['bahanaktif']);
        $this->warna->setDbValue($row['warna']);
        $this->produk_warna_jenis->setDbValue($row['produk_warna_jenis']);
        $this->aksesoris->setDbValue($row['aksesoris']);
        $this->produk_lainlain->setDbValue($row['produk_lainlain']);
        $this->statusproduk->setDbValue($row['statusproduk']);
        $this->parfum->setDbValue($row['parfum']);
        $this->catatan->setDbValue($row['catatan']);
        $this->rencanakemasan->setDbValue($row['rencanakemasan']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->ekspetasiharga->setDbValue($row['ekspetasiharga']);
        $this->kemasan->setDbValue($row['kemasan']);
        $this->volume->setDbValue($row['volume']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->catatanpackaging->setDbValue($row['catatanpackaging']);
        $this->infopackaging->setDbValue($row['infopackaging']);
        $this->ukuran->setDbValue($row['ukuran']);
        $this->desainprodukkemasan->setDbValue($row['desainprodukkemasan']);
        $this->desaindiinginkan->setDbValue($row['desaindiinginkan']);
        $this->mereknotifikasi->setDbValue($row['mereknotifikasi']);
        $this->kategoristatus->setDbValue($row['kategoristatus']);
        $this->kemasan_ukuran_satuan->setDbValue($row['kemasan_ukuran_satuan']);
        $this->notifikasicatatan->setDbValue($row['notifikasicatatan']);
        $this->label_ukuran->setDbValue($row['label_ukuran']);
        $this->infolabel->setDbValue($row['infolabel']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->tanggal->setDbValue($row['tanggal']);
        $this->penerima->setDbValue($row['penerima']);
        $this->createat->setDbValue($row['createat']);
        $this->createby->setDbValue($row['createby']);
        $this->statusdokumen->setDbValue($row['statusdokumen']);
        $this->update_at->setDbValue($row['update_at']);
        $this->status_data->setDbValue($row['status_data']);
        $this->harga_rnd->setDbValue($row['harga_rnd']);
        $this->aplikasi_sediaan->setDbValue($row['aplikasi_sediaan']);
        $this->hu_hrg_isi->setDbValue($row['hu_hrg_isi']);
        $this->hu_hrg_isi_pro->setDbValue($row['hu_hrg_isi_pro']);
        $this->hu_hrg_kms_primer->setDbValue($row['hu_hrg_kms_primer']);
        $this->hu_hrg_kms_primer_pro->setDbValue($row['hu_hrg_kms_primer_pro']);
        $this->hu_hrg_kms_sekunder->setDbValue($row['hu_hrg_kms_sekunder']);
        $this->hu_hrg_kms_sekunder_pro->setDbValue($row['hu_hrg_kms_sekunder_pro']);
        $this->hu_hrg_label->setDbValue($row['hu_hrg_label']);
        $this->hu_hrg_label_pro->setDbValue($row['hu_hrg_label_pro']);
        $this->hu_hrg_total->setDbValue($row['hu_hrg_total']);
        $this->hu_hrg_total_pro->setDbValue($row['hu_hrg_total_pro']);
        $this->hl_hrg_isi->setDbValue($row['hl_hrg_isi']);
        $this->hl_hrg_isi_pro->setDbValue($row['hl_hrg_isi_pro']);
        $this->hl_hrg_kms_primer->setDbValue($row['hl_hrg_kms_primer']);
        $this->hl_hrg_kms_primer_pro->setDbValue($row['hl_hrg_kms_primer_pro']);
        $this->hl_hrg_kms_sekunder->setDbValue($row['hl_hrg_kms_sekunder']);
        $this->hl_hrg_kms_sekunder_pro->setDbValue($row['hl_hrg_kms_sekunder_pro']);
        $this->hl_hrg_label->setDbValue($row['hl_hrg_label']);
        $this->hl_hrg_label_pro->setDbValue($row['hl_hrg_label_pro']);
        $this->hl_hrg_total->setDbValue($row['hl_hrg_total']);
        $this->hl_hrg_total_pro->setDbValue($row['hl_hrg_total_pro']);
        $this->bs_bahan_aktif_tick->setDbValue($row['bs_bahan_aktif_tick']);
        $this->bs_bahan_aktif->setDbValue($row['bs_bahan_aktif']);
        $this->bs_bahan_lain->setDbValue($row['bs_bahan_lain']);
        $this->bs_parfum->setDbValue($row['bs_parfum']);
        $this->bs_estetika->setDbValue($row['bs_estetika']);
        $this->bs_kms_wadah->setDbValue($row['bs_kms_wadah']);
        $this->bs_kms_tutup->setDbValue($row['bs_kms_tutup']);
        $this->bs_kms_sekunder->setDbValue($row['bs_kms_sekunder']);
        $this->bs_label_desain->setDbValue($row['bs_label_desain']);
        $this->bs_label_cetak->setDbValue($row['bs_label_cetak']);
        $this->bs_label_lain->setDbValue($row['bs_label_lain']);
        $this->dlv_pickup->setDbValue($row['dlv_pickup']);
        $this->dlv_singlepoint->setDbValue($row['dlv_singlepoint']);
        $this->dlv_multipoint->setDbValue($row['dlv_multipoint']);
        $this->dlv_multipoint_jml->setDbValue($row['dlv_multipoint_jml']);
        $this->dlv_term_lain->setDbValue($row['dlv_term_lain']);
        $this->catatan_khusus->setDbValue($row['catatan_khusus']);
        $this->aju_tgl->setDbValue($row['aju_tgl']);
        $this->aju_oleh->setDbValue($row['aju_oleh']);
        $this->proses_tgl->setDbValue($row['proses_tgl']);
        $this->proses_oleh->setDbValue($row['proses_oleh']);
        $this->revisi_tgl->setDbValue($row['revisi_tgl']);
        $this->revisi_oleh->setDbValue($row['revisi_oleh']);
        $this->revisi_akun_tgl->setDbValue($row['revisi_akun_tgl']);
        $this->revisi_akun_oleh->setDbValue($row['revisi_akun_oleh']);
        $this->revisi_rnd_tgl->setDbValue($row['revisi_rnd_tgl']);
        $this->revisi_rnd_oleh->setDbValue($row['revisi_rnd_oleh']);
        $this->rnd_tgl->setDbValue($row['rnd_tgl']);
        $this->rnd_oleh->setDbValue($row['rnd_oleh']);
        $this->ap_tgl->setDbValue($row['ap_tgl']);
        $this->ap_oleh->setDbValue($row['ap_oleh']);
        $this->batal_tgl->setDbValue($row['batal_tgl']);
        $this->batal_oleh->setDbValue($row['batal_oleh']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // cpo_jenis

        // ordernum

        // order_kode

        // orderterimatgl

        // produk_fungsi

        // produk_kualitas

        // produk_campaign

        // kemasan_satuan

        // ordertgl

        // custcode

        // perushnama

        // perushalamat

        // perushcp

        // perushjabatan

        // perushphone

        // perushmobile

        // bencmark

        // kategoriproduk

        // jenisproduk

        // bentuksediaan

        // sediaan_ukuran

        // sediaan_ukuran_satuan

        // produk_viskositas

        // konsepproduk

        // fragrance

        // aroma

        // bahanaktif

        // warna

        // produk_warna_jenis

        // aksesoris

        // produk_lainlain

        // statusproduk

        // parfum

        // catatan

        // rencanakemasan

        // keterangan

        // ekspetasiharga

        // kemasan

        // volume

        // jenistutup

        // catatanpackaging

        // infopackaging

        // ukuran

        // desainprodukkemasan

        // desaindiinginkan

        // mereknotifikasi

        // kategoristatus

        // kemasan_ukuran_satuan

        // notifikasicatatan

        // label_ukuran

        // infolabel

        // labelkualitas

        // labelposisi

        // labelcatatan

        // dibuatdi

        // tanggal

        // penerima

        // createat

        // createby

        // statusdokumen

        // update_at

        // status_data

        // harga_rnd

        // aplikasi_sediaan

        // hu_hrg_isi

        // hu_hrg_isi_pro

        // hu_hrg_kms_primer

        // hu_hrg_kms_primer_pro

        // hu_hrg_kms_sekunder

        // hu_hrg_kms_sekunder_pro

        // hu_hrg_label

        // hu_hrg_label_pro

        // hu_hrg_total

        // hu_hrg_total_pro

        // hl_hrg_isi

        // hl_hrg_isi_pro

        // hl_hrg_kms_primer

        // hl_hrg_kms_primer_pro

        // hl_hrg_kms_sekunder

        // hl_hrg_kms_sekunder_pro

        // hl_hrg_label

        // hl_hrg_label_pro

        // hl_hrg_total

        // hl_hrg_total_pro

        // bs_bahan_aktif_tick

        // bs_bahan_aktif

        // bs_bahan_lain

        // bs_parfum

        // bs_estetika

        // bs_kms_wadah

        // bs_kms_tutup

        // bs_kms_sekunder

        // bs_label_desain

        // bs_label_cetak

        // bs_label_lain

        // dlv_pickup

        // dlv_singlepoint

        // dlv_multipoint

        // dlv_multipoint_jml

        // dlv_term_lain

        // catatan_khusus

        // aju_tgl

        // aju_oleh

        // proses_tgl

        // proses_oleh

        // revisi_tgl

        // revisi_oleh

        // revisi_akun_tgl

        // revisi_akun_oleh

        // revisi_rnd_tgl

        // revisi_rnd_oleh

        // rnd_tgl

        // rnd_oleh

        // ap_tgl

        // ap_oleh

        // batal_tgl

        // batal_oleh

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
        $this->id->ViewCustomAttributes = "";

        // cpo_jenis
        $this->cpo_jenis->ViewValue = $this->cpo_jenis->CurrentValue;
        $this->cpo_jenis->ViewCustomAttributes = "";

        // ordernum
        $this->ordernum->ViewValue = $this->ordernum->CurrentValue;
        $this->ordernum->ViewCustomAttributes = "";

        // order_kode
        $this->order_kode->ViewValue = $this->order_kode->CurrentValue;
        $this->order_kode->ViewCustomAttributes = "";

        // orderterimatgl
        $this->orderterimatgl->ViewValue = $this->orderterimatgl->CurrentValue;
        $this->orderterimatgl->ViewValue = FormatDateTime($this->orderterimatgl->ViewValue, 0);
        $this->orderterimatgl->ViewCustomAttributes = "";

        // produk_fungsi
        $this->produk_fungsi->ViewValue = $this->produk_fungsi->CurrentValue;
        $this->produk_fungsi->ViewCustomAttributes = "";

        // produk_kualitas
        $this->produk_kualitas->ViewValue = $this->produk_kualitas->CurrentValue;
        $this->produk_kualitas->ViewCustomAttributes = "";

        // produk_campaign
        $this->produk_campaign->ViewValue = $this->produk_campaign->CurrentValue;
        $this->produk_campaign->ViewCustomAttributes = "";

        // kemasan_satuan
        $this->kemasan_satuan->ViewValue = $this->kemasan_satuan->CurrentValue;
        $this->kemasan_satuan->ViewCustomAttributes = "";

        // ordertgl
        $this->ordertgl->ViewValue = $this->ordertgl->CurrentValue;
        $this->ordertgl->ViewValue = FormatDateTime($this->ordertgl->ViewValue, 0);
        $this->ordertgl->ViewCustomAttributes = "";

        // custcode
        $this->custcode->ViewValue = $this->custcode->CurrentValue;
        $this->custcode->ViewValue = FormatNumber($this->custcode->ViewValue, 0, -2, -2, -2);
        $this->custcode->ViewCustomAttributes = "";

        // perushnama
        $this->perushnama->ViewValue = $this->perushnama->CurrentValue;
        $this->perushnama->ViewCustomAttributes = "";

        // perushalamat
        $this->perushalamat->ViewValue = $this->perushalamat->CurrentValue;
        $this->perushalamat->ViewCustomAttributes = "";

        // perushcp
        $this->perushcp->ViewValue = $this->perushcp->CurrentValue;
        $this->perushcp->ViewCustomAttributes = "";

        // perushjabatan
        $this->perushjabatan->ViewValue = $this->perushjabatan->CurrentValue;
        $this->perushjabatan->ViewCustomAttributes = "";

        // perushphone
        $this->perushphone->ViewValue = $this->perushphone->CurrentValue;
        $this->perushphone->ViewCustomAttributes = "";

        // perushmobile
        $this->perushmobile->ViewValue = $this->perushmobile->CurrentValue;
        $this->perushmobile->ViewCustomAttributes = "";

        // bencmark
        $this->bencmark->ViewValue = $this->bencmark->CurrentValue;
        $this->bencmark->ViewCustomAttributes = "";

        // kategoriproduk
        $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
        $this->kategoriproduk->ViewCustomAttributes = "";

        // jenisproduk
        $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
        $this->jenisproduk->ViewCustomAttributes = "";

        // bentuksediaan
        $this->bentuksediaan->ViewValue = $this->bentuksediaan->CurrentValue;
        $this->bentuksediaan->ViewCustomAttributes = "";

        // sediaan_ukuran
        $this->sediaan_ukuran->ViewValue = $this->sediaan_ukuran->CurrentValue;
        $this->sediaan_ukuran->ViewValue = FormatNumber($this->sediaan_ukuran->ViewValue, 2, -2, -2, -2);
        $this->sediaan_ukuran->ViewCustomAttributes = "";

        // sediaan_ukuran_satuan
        $this->sediaan_ukuran_satuan->ViewValue = $this->sediaan_ukuran_satuan->CurrentValue;
        $this->sediaan_ukuran_satuan->ViewCustomAttributes = "";

        // produk_viskositas
        $this->produk_viskositas->ViewValue = $this->produk_viskositas->CurrentValue;
        $this->produk_viskositas->ViewCustomAttributes = "";

        // konsepproduk
        $this->konsepproduk->ViewValue = $this->konsepproduk->CurrentValue;
        $this->konsepproduk->ViewCustomAttributes = "";

        // fragrance
        $this->fragrance->ViewValue = $this->fragrance->CurrentValue;
        $this->fragrance->ViewCustomAttributes = "";

        // aroma
        $this->aroma->ViewValue = $this->aroma->CurrentValue;
        $this->aroma->ViewCustomAttributes = "";

        // bahanaktif
        $this->bahanaktif->ViewValue = $this->bahanaktif->CurrentValue;
        $this->bahanaktif->ViewCustomAttributes = "";

        // warna
        $this->warna->ViewValue = $this->warna->CurrentValue;
        $this->warna->ViewCustomAttributes = "";

        // produk_warna_jenis
        $this->produk_warna_jenis->ViewValue = $this->produk_warna_jenis->CurrentValue;
        $this->produk_warna_jenis->ViewCustomAttributes = "";

        // aksesoris
        $this->aksesoris->ViewValue = $this->aksesoris->CurrentValue;
        $this->aksesoris->ViewCustomAttributes = "";

        // produk_lainlain
        $this->produk_lainlain->ViewValue = $this->produk_lainlain->CurrentValue;
        $this->produk_lainlain->ViewCustomAttributes = "";

        // statusproduk
        $this->statusproduk->ViewValue = $this->statusproduk->CurrentValue;
        $this->statusproduk->ViewCustomAttributes = "";

        // parfum
        $this->parfum->ViewValue = $this->parfum->CurrentValue;
        $this->parfum->ViewCustomAttributes = "";

        // catatan
        $this->catatan->ViewValue = $this->catatan->CurrentValue;
        $this->catatan->ViewCustomAttributes = "";

        // rencanakemasan
        $this->rencanakemasan->ViewValue = $this->rencanakemasan->CurrentValue;
        $this->rencanakemasan->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // ekspetasiharga
        $this->ekspetasiharga->ViewValue = $this->ekspetasiharga->CurrentValue;
        $this->ekspetasiharga->ViewValue = FormatNumber($this->ekspetasiharga->ViewValue, 2, -2, -2, -2);
        $this->ekspetasiharga->ViewCustomAttributes = "";

        // kemasan
        $this->kemasan->ViewValue = $this->kemasan->CurrentValue;
        $this->kemasan->ViewCustomAttributes = "";

        // volume
        $this->volume->ViewValue = $this->volume->CurrentValue;
        $this->volume->ViewValue = FormatNumber($this->volume->ViewValue, 2, -2, -2, -2);
        $this->volume->ViewCustomAttributes = "";

        // jenistutup
        $this->jenistutup->ViewValue = $this->jenistutup->CurrentValue;
        $this->jenistutup->ViewCustomAttributes = "";

        // catatanpackaging
        $this->catatanpackaging->ViewValue = $this->catatanpackaging->CurrentValue;
        $this->catatanpackaging->ViewCustomAttributes = "";

        // infopackaging
        $this->infopackaging->ViewValue = $this->infopackaging->CurrentValue;
        $this->infopackaging->ViewCustomAttributes = "";

        // ukuran
        $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
        $this->ukuran->ViewValue = FormatNumber($this->ukuran->ViewValue, 0, -2, -2, -2);
        $this->ukuran->ViewCustomAttributes = "";

        // desainprodukkemasan
        $this->desainprodukkemasan->ViewValue = $this->desainprodukkemasan->CurrentValue;
        $this->desainprodukkemasan->ViewCustomAttributes = "";

        // desaindiinginkan
        $this->desaindiinginkan->ViewValue = $this->desaindiinginkan->CurrentValue;
        $this->desaindiinginkan->ViewCustomAttributes = "";

        // mereknotifikasi
        $this->mereknotifikasi->ViewValue = $this->mereknotifikasi->CurrentValue;
        $this->mereknotifikasi->ViewCustomAttributes = "";

        // kategoristatus
        $this->kategoristatus->ViewValue = $this->kategoristatus->CurrentValue;
        $this->kategoristatus->ViewCustomAttributes = "";

        // kemasan_ukuran_satuan
        $this->kemasan_ukuran_satuan->ViewValue = $this->kemasan_ukuran_satuan->CurrentValue;
        $this->kemasan_ukuran_satuan->ViewCustomAttributes = "";

        // notifikasicatatan
        $this->notifikasicatatan->ViewValue = $this->notifikasicatatan->CurrentValue;
        $this->notifikasicatatan->ViewCustomAttributes = "";

        // label_ukuran
        $this->label_ukuran->ViewValue = $this->label_ukuran->CurrentValue;
        $this->label_ukuran->ViewCustomAttributes = "";

        // infolabel
        $this->infolabel->ViewValue = $this->infolabel->CurrentValue;
        $this->infolabel->ViewCustomAttributes = "";

        // labelkualitas
        $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
        $this->labelkualitas->ViewCustomAttributes = "";

        // labelposisi
        $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
        $this->labelposisi->ViewCustomAttributes = "";

        // labelcatatan
        $this->labelcatatan->ViewValue = $this->labelcatatan->CurrentValue;
        $this->labelcatatan->ViewCustomAttributes = "";

        // dibuatdi
        $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
        $this->dibuatdi->ViewCustomAttributes = "";

        // tanggal
        $this->tanggal->ViewValue = $this->tanggal->CurrentValue;
        $this->tanggal->ViewValue = FormatDateTime($this->tanggal->ViewValue, 0);
        $this->tanggal->ViewCustomAttributes = "";

        // penerima
        $this->penerima->ViewValue = $this->penerima->CurrentValue;
        $this->penerima->ViewValue = FormatNumber($this->penerima->ViewValue, 0, -2, -2, -2);
        $this->penerima->ViewCustomAttributes = "";

        // createat
        $this->createat->ViewValue = $this->createat->CurrentValue;
        $this->createat->ViewValue = FormatDateTime($this->createat->ViewValue, 0);
        $this->createat->ViewCustomAttributes = "";

        // createby
        $this->createby->ViewValue = $this->createby->CurrentValue;
        $this->createby->ViewValue = FormatNumber($this->createby->ViewValue, 0, -2, -2, -2);
        $this->createby->ViewCustomAttributes = "";

        // statusdokumen
        $this->statusdokumen->ViewValue = $this->statusdokumen->CurrentValue;
        $this->statusdokumen->ViewCustomAttributes = "";

        // update_at
        $this->update_at->ViewValue = $this->update_at->CurrentValue;
        $this->update_at->ViewValue = FormatDateTime($this->update_at->ViewValue, 0);
        $this->update_at->ViewCustomAttributes = "";

        // status_data
        $this->status_data->ViewValue = $this->status_data->CurrentValue;
        $this->status_data->ViewCustomAttributes = "";

        // harga_rnd
        $this->harga_rnd->ViewValue = $this->harga_rnd->CurrentValue;
        $this->harga_rnd->ViewValue = FormatNumber($this->harga_rnd->ViewValue, 2, -2, -2, -2);
        $this->harga_rnd->ViewCustomAttributes = "";

        // aplikasi_sediaan
        $this->aplikasi_sediaan->ViewValue = $this->aplikasi_sediaan->CurrentValue;
        $this->aplikasi_sediaan->ViewCustomAttributes = "";

        // hu_hrg_isi
        $this->hu_hrg_isi->ViewValue = $this->hu_hrg_isi->CurrentValue;
        $this->hu_hrg_isi->ViewValue = FormatNumber($this->hu_hrg_isi->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_isi->ViewCustomAttributes = "";

        // hu_hrg_isi_pro
        $this->hu_hrg_isi_pro->ViewValue = $this->hu_hrg_isi_pro->CurrentValue;
        $this->hu_hrg_isi_pro->ViewValue = FormatNumber($this->hu_hrg_isi_pro->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_isi_pro->ViewCustomAttributes = "";

        // hu_hrg_kms_primer
        $this->hu_hrg_kms_primer->ViewValue = $this->hu_hrg_kms_primer->CurrentValue;
        $this->hu_hrg_kms_primer->ViewValue = FormatNumber($this->hu_hrg_kms_primer->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_kms_primer->ViewCustomAttributes = "";

        // hu_hrg_kms_primer_pro
        $this->hu_hrg_kms_primer_pro->ViewValue = $this->hu_hrg_kms_primer_pro->CurrentValue;
        $this->hu_hrg_kms_primer_pro->ViewValue = FormatNumber($this->hu_hrg_kms_primer_pro->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_kms_primer_pro->ViewCustomAttributes = "";

        // hu_hrg_kms_sekunder
        $this->hu_hrg_kms_sekunder->ViewValue = $this->hu_hrg_kms_sekunder->CurrentValue;
        $this->hu_hrg_kms_sekunder->ViewValue = FormatNumber($this->hu_hrg_kms_sekunder->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_kms_sekunder->ViewCustomAttributes = "";

        // hu_hrg_kms_sekunder_pro
        $this->hu_hrg_kms_sekunder_pro->ViewValue = $this->hu_hrg_kms_sekunder_pro->CurrentValue;
        $this->hu_hrg_kms_sekunder_pro->ViewValue = FormatNumber($this->hu_hrg_kms_sekunder_pro->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_kms_sekunder_pro->ViewCustomAttributes = "";

        // hu_hrg_label
        $this->hu_hrg_label->ViewValue = $this->hu_hrg_label->CurrentValue;
        $this->hu_hrg_label->ViewValue = FormatNumber($this->hu_hrg_label->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_label->ViewCustomAttributes = "";

        // hu_hrg_label_pro
        $this->hu_hrg_label_pro->ViewValue = $this->hu_hrg_label_pro->CurrentValue;
        $this->hu_hrg_label_pro->ViewValue = FormatNumber($this->hu_hrg_label_pro->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_label_pro->ViewCustomAttributes = "";

        // hu_hrg_total
        $this->hu_hrg_total->ViewValue = $this->hu_hrg_total->CurrentValue;
        $this->hu_hrg_total->ViewValue = FormatNumber($this->hu_hrg_total->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_total->ViewCustomAttributes = "";

        // hu_hrg_total_pro
        $this->hu_hrg_total_pro->ViewValue = $this->hu_hrg_total_pro->CurrentValue;
        $this->hu_hrg_total_pro->ViewValue = FormatNumber($this->hu_hrg_total_pro->ViewValue, 2, -2, -2, -2);
        $this->hu_hrg_total_pro->ViewCustomAttributes = "";

        // hl_hrg_isi
        $this->hl_hrg_isi->ViewValue = $this->hl_hrg_isi->CurrentValue;
        $this->hl_hrg_isi->ViewValue = FormatNumber($this->hl_hrg_isi->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_isi->ViewCustomAttributes = "";

        // hl_hrg_isi_pro
        $this->hl_hrg_isi_pro->ViewValue = $this->hl_hrg_isi_pro->CurrentValue;
        $this->hl_hrg_isi_pro->ViewValue = FormatNumber($this->hl_hrg_isi_pro->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_isi_pro->ViewCustomAttributes = "";

        // hl_hrg_kms_primer
        $this->hl_hrg_kms_primer->ViewValue = $this->hl_hrg_kms_primer->CurrentValue;
        $this->hl_hrg_kms_primer->ViewValue = FormatNumber($this->hl_hrg_kms_primer->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_kms_primer->ViewCustomAttributes = "";

        // hl_hrg_kms_primer_pro
        $this->hl_hrg_kms_primer_pro->ViewValue = $this->hl_hrg_kms_primer_pro->CurrentValue;
        $this->hl_hrg_kms_primer_pro->ViewValue = FormatNumber($this->hl_hrg_kms_primer_pro->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_kms_primer_pro->ViewCustomAttributes = "";

        // hl_hrg_kms_sekunder
        $this->hl_hrg_kms_sekunder->ViewValue = $this->hl_hrg_kms_sekunder->CurrentValue;
        $this->hl_hrg_kms_sekunder->ViewValue = FormatNumber($this->hl_hrg_kms_sekunder->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_kms_sekunder->ViewCustomAttributes = "";

        // hl_hrg_kms_sekunder_pro
        $this->hl_hrg_kms_sekunder_pro->ViewValue = $this->hl_hrg_kms_sekunder_pro->CurrentValue;
        $this->hl_hrg_kms_sekunder_pro->ViewValue = FormatNumber($this->hl_hrg_kms_sekunder_pro->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_kms_sekunder_pro->ViewCustomAttributes = "";

        // hl_hrg_label
        $this->hl_hrg_label->ViewValue = $this->hl_hrg_label->CurrentValue;
        $this->hl_hrg_label->ViewValue = FormatNumber($this->hl_hrg_label->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_label->ViewCustomAttributes = "";

        // hl_hrg_label_pro
        $this->hl_hrg_label_pro->ViewValue = $this->hl_hrg_label_pro->CurrentValue;
        $this->hl_hrg_label_pro->ViewValue = FormatNumber($this->hl_hrg_label_pro->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_label_pro->ViewCustomAttributes = "";

        // hl_hrg_total
        $this->hl_hrg_total->ViewValue = $this->hl_hrg_total->CurrentValue;
        $this->hl_hrg_total->ViewValue = FormatNumber($this->hl_hrg_total->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_total->ViewCustomAttributes = "";

        // hl_hrg_total_pro
        $this->hl_hrg_total_pro->ViewValue = $this->hl_hrg_total_pro->CurrentValue;
        $this->hl_hrg_total_pro->ViewValue = FormatNumber($this->hl_hrg_total_pro->ViewValue, 2, -2, -2, -2);
        $this->hl_hrg_total_pro->ViewCustomAttributes = "";

        // bs_bahan_aktif_tick
        $this->bs_bahan_aktif_tick->ViewValue = $this->bs_bahan_aktif_tick->CurrentValue;
        $this->bs_bahan_aktif_tick->ViewCustomAttributes = "";

        // bs_bahan_aktif
        $this->bs_bahan_aktif->ViewValue = $this->bs_bahan_aktif->CurrentValue;
        $this->bs_bahan_aktif->ViewCustomAttributes = "";

        // bs_bahan_lain
        $this->bs_bahan_lain->ViewValue = $this->bs_bahan_lain->CurrentValue;
        $this->bs_bahan_lain->ViewCustomAttributes = "";

        // bs_parfum
        $this->bs_parfum->ViewValue = $this->bs_parfum->CurrentValue;
        $this->bs_parfum->ViewCustomAttributes = "";

        // bs_estetika
        $this->bs_estetika->ViewValue = $this->bs_estetika->CurrentValue;
        $this->bs_estetika->ViewCustomAttributes = "";

        // bs_kms_wadah
        $this->bs_kms_wadah->ViewValue = $this->bs_kms_wadah->CurrentValue;
        $this->bs_kms_wadah->ViewCustomAttributes = "";

        // bs_kms_tutup
        $this->bs_kms_tutup->ViewValue = $this->bs_kms_tutup->CurrentValue;
        $this->bs_kms_tutup->ViewCustomAttributes = "";

        // bs_kms_sekunder
        $this->bs_kms_sekunder->ViewValue = $this->bs_kms_sekunder->CurrentValue;
        $this->bs_kms_sekunder->ViewCustomAttributes = "";

        // bs_label_desain
        $this->bs_label_desain->ViewValue = $this->bs_label_desain->CurrentValue;
        $this->bs_label_desain->ViewCustomAttributes = "";

        // bs_label_cetak
        $this->bs_label_cetak->ViewValue = $this->bs_label_cetak->CurrentValue;
        $this->bs_label_cetak->ViewCustomAttributes = "";

        // bs_label_lain
        $this->bs_label_lain->ViewValue = $this->bs_label_lain->CurrentValue;
        $this->bs_label_lain->ViewCustomAttributes = "";

        // dlv_pickup
        $this->dlv_pickup->ViewValue = $this->dlv_pickup->CurrentValue;
        $this->dlv_pickup->ViewCustomAttributes = "";

        // dlv_singlepoint
        $this->dlv_singlepoint->ViewValue = $this->dlv_singlepoint->CurrentValue;
        $this->dlv_singlepoint->ViewCustomAttributes = "";

        // dlv_multipoint
        $this->dlv_multipoint->ViewValue = $this->dlv_multipoint->CurrentValue;
        $this->dlv_multipoint->ViewCustomAttributes = "";

        // dlv_multipoint_jml
        $this->dlv_multipoint_jml->ViewValue = $this->dlv_multipoint_jml->CurrentValue;
        $this->dlv_multipoint_jml->ViewCustomAttributes = "";

        // dlv_term_lain
        $this->dlv_term_lain->ViewValue = $this->dlv_term_lain->CurrentValue;
        $this->dlv_term_lain->ViewCustomAttributes = "";

        // catatan_khusus
        $this->catatan_khusus->ViewValue = $this->catatan_khusus->CurrentValue;
        $this->catatan_khusus->ViewCustomAttributes = "";

        // aju_tgl
        $this->aju_tgl->ViewValue = $this->aju_tgl->CurrentValue;
        $this->aju_tgl->ViewValue = FormatDateTime($this->aju_tgl->ViewValue, 0);
        $this->aju_tgl->ViewCustomAttributes = "";

        // aju_oleh
        $this->aju_oleh->ViewValue = $this->aju_oleh->CurrentValue;
        $this->aju_oleh->ViewValue = FormatNumber($this->aju_oleh->ViewValue, 0, -2, -2, -2);
        $this->aju_oleh->ViewCustomAttributes = "";

        // proses_tgl
        $this->proses_tgl->ViewValue = $this->proses_tgl->CurrentValue;
        $this->proses_tgl->ViewValue = FormatDateTime($this->proses_tgl->ViewValue, 0);
        $this->proses_tgl->ViewCustomAttributes = "";

        // proses_oleh
        $this->proses_oleh->ViewValue = $this->proses_oleh->CurrentValue;
        $this->proses_oleh->ViewValue = FormatNumber($this->proses_oleh->ViewValue, 0, -2, -2, -2);
        $this->proses_oleh->ViewCustomAttributes = "";

        // revisi_tgl
        $this->revisi_tgl->ViewValue = $this->revisi_tgl->CurrentValue;
        $this->revisi_tgl->ViewValue = FormatDateTime($this->revisi_tgl->ViewValue, 0);
        $this->revisi_tgl->ViewCustomAttributes = "";

        // revisi_oleh
        $this->revisi_oleh->ViewValue = $this->revisi_oleh->CurrentValue;
        $this->revisi_oleh->ViewValue = FormatNumber($this->revisi_oleh->ViewValue, 0, -2, -2, -2);
        $this->revisi_oleh->ViewCustomAttributes = "";

        // revisi_akun_tgl
        $this->revisi_akun_tgl->ViewValue = $this->revisi_akun_tgl->CurrentValue;
        $this->revisi_akun_tgl->ViewValue = FormatDateTime($this->revisi_akun_tgl->ViewValue, 0);
        $this->revisi_akun_tgl->ViewCustomAttributes = "";

        // revisi_akun_oleh
        $this->revisi_akun_oleh->ViewValue = $this->revisi_akun_oleh->CurrentValue;
        $this->revisi_akun_oleh->ViewValue = FormatNumber($this->revisi_akun_oleh->ViewValue, 0, -2, -2, -2);
        $this->revisi_akun_oleh->ViewCustomAttributes = "";

        // revisi_rnd_tgl
        $this->revisi_rnd_tgl->ViewValue = $this->revisi_rnd_tgl->CurrentValue;
        $this->revisi_rnd_tgl->ViewValue = FormatDateTime($this->revisi_rnd_tgl->ViewValue, 0);
        $this->revisi_rnd_tgl->ViewCustomAttributes = "";

        // revisi_rnd_oleh
        $this->revisi_rnd_oleh->ViewValue = $this->revisi_rnd_oleh->CurrentValue;
        $this->revisi_rnd_oleh->ViewValue = FormatNumber($this->revisi_rnd_oleh->ViewValue, 0, -2, -2, -2);
        $this->revisi_rnd_oleh->ViewCustomAttributes = "";

        // rnd_tgl
        $this->rnd_tgl->ViewValue = $this->rnd_tgl->CurrentValue;
        $this->rnd_tgl->ViewValue = FormatDateTime($this->rnd_tgl->ViewValue, 0);
        $this->rnd_tgl->ViewCustomAttributes = "";

        // rnd_oleh
        $this->rnd_oleh->ViewValue = $this->rnd_oleh->CurrentValue;
        $this->rnd_oleh->ViewValue = FormatNumber($this->rnd_oleh->ViewValue, 0, -2, -2, -2);
        $this->rnd_oleh->ViewCustomAttributes = "";

        // ap_tgl
        $this->ap_tgl->ViewValue = $this->ap_tgl->CurrentValue;
        $this->ap_tgl->ViewValue = FormatDateTime($this->ap_tgl->ViewValue, 0);
        $this->ap_tgl->ViewCustomAttributes = "";

        // ap_oleh
        $this->ap_oleh->ViewValue = $this->ap_oleh->CurrentValue;
        $this->ap_oleh->ViewValue = FormatNumber($this->ap_oleh->ViewValue, 0, -2, -2, -2);
        $this->ap_oleh->ViewCustomAttributes = "";

        // batal_tgl
        $this->batal_tgl->ViewValue = $this->batal_tgl->CurrentValue;
        $this->batal_tgl->ViewValue = FormatDateTime($this->batal_tgl->ViewValue, 0);
        $this->batal_tgl->ViewCustomAttributes = "";

        // batal_oleh
        $this->batal_oleh->ViewValue = $this->batal_oleh->CurrentValue;
        $this->batal_oleh->ViewValue = FormatNumber($this->batal_oleh->ViewValue, 0, -2, -2, -2);
        $this->batal_oleh->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // cpo_jenis
        $this->cpo_jenis->LinkCustomAttributes = "";
        $this->cpo_jenis->HrefValue = "";
        $this->cpo_jenis->TooltipValue = "";

        // ordernum
        $this->ordernum->LinkCustomAttributes = "";
        $this->ordernum->HrefValue = "";
        $this->ordernum->TooltipValue = "";

        // order_kode
        $this->order_kode->LinkCustomAttributes = "";
        $this->order_kode->HrefValue = "";
        $this->order_kode->TooltipValue = "";

        // orderterimatgl
        $this->orderterimatgl->LinkCustomAttributes = "";
        $this->orderterimatgl->HrefValue = "";
        $this->orderterimatgl->TooltipValue = "";

        // produk_fungsi
        $this->produk_fungsi->LinkCustomAttributes = "";
        $this->produk_fungsi->HrefValue = "";
        $this->produk_fungsi->TooltipValue = "";

        // produk_kualitas
        $this->produk_kualitas->LinkCustomAttributes = "";
        $this->produk_kualitas->HrefValue = "";
        $this->produk_kualitas->TooltipValue = "";

        // produk_campaign
        $this->produk_campaign->LinkCustomAttributes = "";
        $this->produk_campaign->HrefValue = "";
        $this->produk_campaign->TooltipValue = "";

        // kemasan_satuan
        $this->kemasan_satuan->LinkCustomAttributes = "";
        $this->kemasan_satuan->HrefValue = "";
        $this->kemasan_satuan->TooltipValue = "";

        // ordertgl
        $this->ordertgl->LinkCustomAttributes = "";
        $this->ordertgl->HrefValue = "";
        $this->ordertgl->TooltipValue = "";

        // custcode
        $this->custcode->LinkCustomAttributes = "";
        $this->custcode->HrefValue = "";
        $this->custcode->TooltipValue = "";

        // perushnama
        $this->perushnama->LinkCustomAttributes = "";
        $this->perushnama->HrefValue = "";
        $this->perushnama->TooltipValue = "";

        // perushalamat
        $this->perushalamat->LinkCustomAttributes = "";
        $this->perushalamat->HrefValue = "";
        $this->perushalamat->TooltipValue = "";

        // perushcp
        $this->perushcp->LinkCustomAttributes = "";
        $this->perushcp->HrefValue = "";
        $this->perushcp->TooltipValue = "";

        // perushjabatan
        $this->perushjabatan->LinkCustomAttributes = "";
        $this->perushjabatan->HrefValue = "";
        $this->perushjabatan->TooltipValue = "";

        // perushphone
        $this->perushphone->LinkCustomAttributes = "";
        $this->perushphone->HrefValue = "";
        $this->perushphone->TooltipValue = "";

        // perushmobile
        $this->perushmobile->LinkCustomAttributes = "";
        $this->perushmobile->HrefValue = "";
        $this->perushmobile->TooltipValue = "";

        // bencmark
        $this->bencmark->LinkCustomAttributes = "";
        $this->bencmark->HrefValue = "";
        $this->bencmark->TooltipValue = "";

        // kategoriproduk
        $this->kategoriproduk->LinkCustomAttributes = "";
        $this->kategoriproduk->HrefValue = "";
        $this->kategoriproduk->TooltipValue = "";

        // jenisproduk
        $this->jenisproduk->LinkCustomAttributes = "";
        $this->jenisproduk->HrefValue = "";
        $this->jenisproduk->TooltipValue = "";

        // bentuksediaan
        $this->bentuksediaan->LinkCustomAttributes = "";
        $this->bentuksediaan->HrefValue = "";
        $this->bentuksediaan->TooltipValue = "";

        // sediaan_ukuran
        $this->sediaan_ukuran->LinkCustomAttributes = "";
        $this->sediaan_ukuran->HrefValue = "";
        $this->sediaan_ukuran->TooltipValue = "";

        // sediaan_ukuran_satuan
        $this->sediaan_ukuran_satuan->LinkCustomAttributes = "";
        $this->sediaan_ukuran_satuan->HrefValue = "";
        $this->sediaan_ukuran_satuan->TooltipValue = "";

        // produk_viskositas
        $this->produk_viskositas->LinkCustomAttributes = "";
        $this->produk_viskositas->HrefValue = "";
        $this->produk_viskositas->TooltipValue = "";

        // konsepproduk
        $this->konsepproduk->LinkCustomAttributes = "";
        $this->konsepproduk->HrefValue = "";
        $this->konsepproduk->TooltipValue = "";

        // fragrance
        $this->fragrance->LinkCustomAttributes = "";
        $this->fragrance->HrefValue = "";
        $this->fragrance->TooltipValue = "";

        // aroma
        $this->aroma->LinkCustomAttributes = "";
        $this->aroma->HrefValue = "";
        $this->aroma->TooltipValue = "";

        // bahanaktif
        $this->bahanaktif->LinkCustomAttributes = "";
        $this->bahanaktif->HrefValue = "";
        $this->bahanaktif->TooltipValue = "";

        // warna
        $this->warna->LinkCustomAttributes = "";
        $this->warna->HrefValue = "";
        $this->warna->TooltipValue = "";

        // produk_warna_jenis
        $this->produk_warna_jenis->LinkCustomAttributes = "";
        $this->produk_warna_jenis->HrefValue = "";
        $this->produk_warna_jenis->TooltipValue = "";

        // aksesoris
        $this->aksesoris->LinkCustomAttributes = "";
        $this->aksesoris->HrefValue = "";
        $this->aksesoris->TooltipValue = "";

        // produk_lainlain
        $this->produk_lainlain->LinkCustomAttributes = "";
        $this->produk_lainlain->HrefValue = "";
        $this->produk_lainlain->TooltipValue = "";

        // statusproduk
        $this->statusproduk->LinkCustomAttributes = "";
        $this->statusproduk->HrefValue = "";
        $this->statusproduk->TooltipValue = "";

        // parfum
        $this->parfum->LinkCustomAttributes = "";
        $this->parfum->HrefValue = "";
        $this->parfum->TooltipValue = "";

        // catatan
        $this->catatan->LinkCustomAttributes = "";
        $this->catatan->HrefValue = "";
        $this->catatan->TooltipValue = "";

        // rencanakemasan
        $this->rencanakemasan->LinkCustomAttributes = "";
        $this->rencanakemasan->HrefValue = "";
        $this->rencanakemasan->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // ekspetasiharga
        $this->ekspetasiharga->LinkCustomAttributes = "";
        $this->ekspetasiharga->HrefValue = "";
        $this->ekspetasiharga->TooltipValue = "";

        // kemasan
        $this->kemasan->LinkCustomAttributes = "";
        $this->kemasan->HrefValue = "";
        $this->kemasan->TooltipValue = "";

        // volume
        $this->volume->LinkCustomAttributes = "";
        $this->volume->HrefValue = "";
        $this->volume->TooltipValue = "";

        // jenistutup
        $this->jenistutup->LinkCustomAttributes = "";
        $this->jenistutup->HrefValue = "";
        $this->jenistutup->TooltipValue = "";

        // catatanpackaging
        $this->catatanpackaging->LinkCustomAttributes = "";
        $this->catatanpackaging->HrefValue = "";
        $this->catatanpackaging->TooltipValue = "";

        // infopackaging
        $this->infopackaging->LinkCustomAttributes = "";
        $this->infopackaging->HrefValue = "";
        $this->infopackaging->TooltipValue = "";

        // ukuran
        $this->ukuran->LinkCustomAttributes = "";
        $this->ukuran->HrefValue = "";
        $this->ukuran->TooltipValue = "";

        // desainprodukkemasan
        $this->desainprodukkemasan->LinkCustomAttributes = "";
        $this->desainprodukkemasan->HrefValue = "";
        $this->desainprodukkemasan->TooltipValue = "";

        // desaindiinginkan
        $this->desaindiinginkan->LinkCustomAttributes = "";
        $this->desaindiinginkan->HrefValue = "";
        $this->desaindiinginkan->TooltipValue = "";

        // mereknotifikasi
        $this->mereknotifikasi->LinkCustomAttributes = "";
        $this->mereknotifikasi->HrefValue = "";
        $this->mereknotifikasi->TooltipValue = "";

        // kategoristatus
        $this->kategoristatus->LinkCustomAttributes = "";
        $this->kategoristatus->HrefValue = "";
        $this->kategoristatus->TooltipValue = "";

        // kemasan_ukuran_satuan
        $this->kemasan_ukuran_satuan->LinkCustomAttributes = "";
        $this->kemasan_ukuran_satuan->HrefValue = "";
        $this->kemasan_ukuran_satuan->TooltipValue = "";

        // notifikasicatatan
        $this->notifikasicatatan->LinkCustomAttributes = "";
        $this->notifikasicatatan->HrefValue = "";
        $this->notifikasicatatan->TooltipValue = "";

        // label_ukuran
        $this->label_ukuran->LinkCustomAttributes = "";
        $this->label_ukuran->HrefValue = "";
        $this->label_ukuran->TooltipValue = "";

        // infolabel
        $this->infolabel->LinkCustomAttributes = "";
        $this->infolabel->HrefValue = "";
        $this->infolabel->TooltipValue = "";

        // labelkualitas
        $this->labelkualitas->LinkCustomAttributes = "";
        $this->labelkualitas->HrefValue = "";
        $this->labelkualitas->TooltipValue = "";

        // labelposisi
        $this->labelposisi->LinkCustomAttributes = "";
        $this->labelposisi->HrefValue = "";
        $this->labelposisi->TooltipValue = "";

        // labelcatatan
        $this->labelcatatan->LinkCustomAttributes = "";
        $this->labelcatatan->HrefValue = "";
        $this->labelcatatan->TooltipValue = "";

        // dibuatdi
        $this->dibuatdi->LinkCustomAttributes = "";
        $this->dibuatdi->HrefValue = "";
        $this->dibuatdi->TooltipValue = "";

        // tanggal
        $this->tanggal->LinkCustomAttributes = "";
        $this->tanggal->HrefValue = "";
        $this->tanggal->TooltipValue = "";

        // penerima
        $this->penerima->LinkCustomAttributes = "";
        $this->penerima->HrefValue = "";
        $this->penerima->TooltipValue = "";

        // createat
        $this->createat->LinkCustomAttributes = "";
        $this->createat->HrefValue = "";
        $this->createat->TooltipValue = "";

        // createby
        $this->createby->LinkCustomAttributes = "";
        $this->createby->HrefValue = "";
        $this->createby->TooltipValue = "";

        // statusdokumen
        $this->statusdokumen->LinkCustomAttributes = "";
        $this->statusdokumen->HrefValue = "";
        $this->statusdokumen->TooltipValue = "";

        // update_at
        $this->update_at->LinkCustomAttributes = "";
        $this->update_at->HrefValue = "";
        $this->update_at->TooltipValue = "";

        // status_data
        $this->status_data->LinkCustomAttributes = "";
        $this->status_data->HrefValue = "";
        $this->status_data->TooltipValue = "";

        // harga_rnd
        $this->harga_rnd->LinkCustomAttributes = "";
        $this->harga_rnd->HrefValue = "";
        $this->harga_rnd->TooltipValue = "";

        // aplikasi_sediaan
        $this->aplikasi_sediaan->LinkCustomAttributes = "";
        $this->aplikasi_sediaan->HrefValue = "";
        $this->aplikasi_sediaan->TooltipValue = "";

        // hu_hrg_isi
        $this->hu_hrg_isi->LinkCustomAttributes = "";
        $this->hu_hrg_isi->HrefValue = "";
        $this->hu_hrg_isi->TooltipValue = "";

        // hu_hrg_isi_pro
        $this->hu_hrg_isi_pro->LinkCustomAttributes = "";
        $this->hu_hrg_isi_pro->HrefValue = "";
        $this->hu_hrg_isi_pro->TooltipValue = "";

        // hu_hrg_kms_primer
        $this->hu_hrg_kms_primer->LinkCustomAttributes = "";
        $this->hu_hrg_kms_primer->HrefValue = "";
        $this->hu_hrg_kms_primer->TooltipValue = "";

        // hu_hrg_kms_primer_pro
        $this->hu_hrg_kms_primer_pro->LinkCustomAttributes = "";
        $this->hu_hrg_kms_primer_pro->HrefValue = "";
        $this->hu_hrg_kms_primer_pro->TooltipValue = "";

        // hu_hrg_kms_sekunder
        $this->hu_hrg_kms_sekunder->LinkCustomAttributes = "";
        $this->hu_hrg_kms_sekunder->HrefValue = "";
        $this->hu_hrg_kms_sekunder->TooltipValue = "";

        // hu_hrg_kms_sekunder_pro
        $this->hu_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
        $this->hu_hrg_kms_sekunder_pro->HrefValue = "";
        $this->hu_hrg_kms_sekunder_pro->TooltipValue = "";

        // hu_hrg_label
        $this->hu_hrg_label->LinkCustomAttributes = "";
        $this->hu_hrg_label->HrefValue = "";
        $this->hu_hrg_label->TooltipValue = "";

        // hu_hrg_label_pro
        $this->hu_hrg_label_pro->LinkCustomAttributes = "";
        $this->hu_hrg_label_pro->HrefValue = "";
        $this->hu_hrg_label_pro->TooltipValue = "";

        // hu_hrg_total
        $this->hu_hrg_total->LinkCustomAttributes = "";
        $this->hu_hrg_total->HrefValue = "";
        $this->hu_hrg_total->TooltipValue = "";

        // hu_hrg_total_pro
        $this->hu_hrg_total_pro->LinkCustomAttributes = "";
        $this->hu_hrg_total_pro->HrefValue = "";
        $this->hu_hrg_total_pro->TooltipValue = "";

        // hl_hrg_isi
        $this->hl_hrg_isi->LinkCustomAttributes = "";
        $this->hl_hrg_isi->HrefValue = "";
        $this->hl_hrg_isi->TooltipValue = "";

        // hl_hrg_isi_pro
        $this->hl_hrg_isi_pro->LinkCustomAttributes = "";
        $this->hl_hrg_isi_pro->HrefValue = "";
        $this->hl_hrg_isi_pro->TooltipValue = "";

        // hl_hrg_kms_primer
        $this->hl_hrg_kms_primer->LinkCustomAttributes = "";
        $this->hl_hrg_kms_primer->HrefValue = "";
        $this->hl_hrg_kms_primer->TooltipValue = "";

        // hl_hrg_kms_primer_pro
        $this->hl_hrg_kms_primer_pro->LinkCustomAttributes = "";
        $this->hl_hrg_kms_primer_pro->HrefValue = "";
        $this->hl_hrg_kms_primer_pro->TooltipValue = "";

        // hl_hrg_kms_sekunder
        $this->hl_hrg_kms_sekunder->LinkCustomAttributes = "";
        $this->hl_hrg_kms_sekunder->HrefValue = "";
        $this->hl_hrg_kms_sekunder->TooltipValue = "";

        // hl_hrg_kms_sekunder_pro
        $this->hl_hrg_kms_sekunder_pro->LinkCustomAttributes = "";
        $this->hl_hrg_kms_sekunder_pro->HrefValue = "";
        $this->hl_hrg_kms_sekunder_pro->TooltipValue = "";

        // hl_hrg_label
        $this->hl_hrg_label->LinkCustomAttributes = "";
        $this->hl_hrg_label->HrefValue = "";
        $this->hl_hrg_label->TooltipValue = "";

        // hl_hrg_label_pro
        $this->hl_hrg_label_pro->LinkCustomAttributes = "";
        $this->hl_hrg_label_pro->HrefValue = "";
        $this->hl_hrg_label_pro->TooltipValue = "";

        // hl_hrg_total
        $this->hl_hrg_total->LinkCustomAttributes = "";
        $this->hl_hrg_total->HrefValue = "";
        $this->hl_hrg_total->TooltipValue = "";

        // hl_hrg_total_pro
        $this->hl_hrg_total_pro->LinkCustomAttributes = "";
        $this->hl_hrg_total_pro->HrefValue = "";
        $this->hl_hrg_total_pro->TooltipValue = "";

        // bs_bahan_aktif_tick
        $this->bs_bahan_aktif_tick->LinkCustomAttributes = "";
        $this->bs_bahan_aktif_tick->HrefValue = "";
        $this->bs_bahan_aktif_tick->TooltipValue = "";

        // bs_bahan_aktif
        $this->bs_bahan_aktif->LinkCustomAttributes = "";
        $this->bs_bahan_aktif->HrefValue = "";
        $this->bs_bahan_aktif->TooltipValue = "";

        // bs_bahan_lain
        $this->bs_bahan_lain->LinkCustomAttributes = "";
        $this->bs_bahan_lain->HrefValue = "";
        $this->bs_bahan_lain->TooltipValue = "";

        // bs_parfum
        $this->bs_parfum->LinkCustomAttributes = "";
        $this->bs_parfum->HrefValue = "";
        $this->bs_parfum->TooltipValue = "";

        // bs_estetika
        $this->bs_estetika->LinkCustomAttributes = "";
        $this->bs_estetika->HrefValue = "";
        $this->bs_estetika->TooltipValue = "";

        // bs_kms_wadah
        $this->bs_kms_wadah->LinkCustomAttributes = "";
        $this->bs_kms_wadah->HrefValue = "";
        $this->bs_kms_wadah->TooltipValue = "";

        // bs_kms_tutup
        $this->bs_kms_tutup->LinkCustomAttributes = "";
        $this->bs_kms_tutup->HrefValue = "";
        $this->bs_kms_tutup->TooltipValue = "";

        // bs_kms_sekunder
        $this->bs_kms_sekunder->LinkCustomAttributes = "";
        $this->bs_kms_sekunder->HrefValue = "";
        $this->bs_kms_sekunder->TooltipValue = "";

        // bs_label_desain
        $this->bs_label_desain->LinkCustomAttributes = "";
        $this->bs_label_desain->HrefValue = "";
        $this->bs_label_desain->TooltipValue = "";

        // bs_label_cetak
        $this->bs_label_cetak->LinkCustomAttributes = "";
        $this->bs_label_cetak->HrefValue = "";
        $this->bs_label_cetak->TooltipValue = "";

        // bs_label_lain
        $this->bs_label_lain->LinkCustomAttributes = "";
        $this->bs_label_lain->HrefValue = "";
        $this->bs_label_lain->TooltipValue = "";

        // dlv_pickup
        $this->dlv_pickup->LinkCustomAttributes = "";
        $this->dlv_pickup->HrefValue = "";
        $this->dlv_pickup->TooltipValue = "";

        // dlv_singlepoint
        $this->dlv_singlepoint->LinkCustomAttributes = "";
        $this->dlv_singlepoint->HrefValue = "";
        $this->dlv_singlepoint->TooltipValue = "";

        // dlv_multipoint
        $this->dlv_multipoint->LinkCustomAttributes = "";
        $this->dlv_multipoint->HrefValue = "";
        $this->dlv_multipoint->TooltipValue = "";

        // dlv_multipoint_jml
        $this->dlv_multipoint_jml->LinkCustomAttributes = "";
        $this->dlv_multipoint_jml->HrefValue = "";
        $this->dlv_multipoint_jml->TooltipValue = "";

        // dlv_term_lain
        $this->dlv_term_lain->LinkCustomAttributes = "";
        $this->dlv_term_lain->HrefValue = "";
        $this->dlv_term_lain->TooltipValue = "";

        // catatan_khusus
        $this->catatan_khusus->LinkCustomAttributes = "";
        $this->catatan_khusus->HrefValue = "";
        $this->catatan_khusus->TooltipValue = "";

        // aju_tgl
        $this->aju_tgl->LinkCustomAttributes = "";
        $this->aju_tgl->HrefValue = "";
        $this->aju_tgl->TooltipValue = "";

        // aju_oleh
        $this->aju_oleh->LinkCustomAttributes = "";
        $this->aju_oleh->HrefValue = "";
        $this->aju_oleh->TooltipValue = "";

        // proses_tgl
        $this->proses_tgl->LinkCustomAttributes = "";
        $this->proses_tgl->HrefValue = "";
        $this->proses_tgl->TooltipValue = "";

        // proses_oleh
        $this->proses_oleh->LinkCustomAttributes = "";
        $this->proses_oleh->HrefValue = "";
        $this->proses_oleh->TooltipValue = "";

        // revisi_tgl
        $this->revisi_tgl->LinkCustomAttributes = "";
        $this->revisi_tgl->HrefValue = "";
        $this->revisi_tgl->TooltipValue = "";

        // revisi_oleh
        $this->revisi_oleh->LinkCustomAttributes = "";
        $this->revisi_oleh->HrefValue = "";
        $this->revisi_oleh->TooltipValue = "";

        // revisi_akun_tgl
        $this->revisi_akun_tgl->LinkCustomAttributes = "";
        $this->revisi_akun_tgl->HrefValue = "";
        $this->revisi_akun_tgl->TooltipValue = "";

        // revisi_akun_oleh
        $this->revisi_akun_oleh->LinkCustomAttributes = "";
        $this->revisi_akun_oleh->HrefValue = "";
        $this->revisi_akun_oleh->TooltipValue = "";

        // revisi_rnd_tgl
        $this->revisi_rnd_tgl->LinkCustomAttributes = "";
        $this->revisi_rnd_tgl->HrefValue = "";
        $this->revisi_rnd_tgl->TooltipValue = "";

        // revisi_rnd_oleh
        $this->revisi_rnd_oleh->LinkCustomAttributes = "";
        $this->revisi_rnd_oleh->HrefValue = "";
        $this->revisi_rnd_oleh->TooltipValue = "";

        // rnd_tgl
        $this->rnd_tgl->LinkCustomAttributes = "";
        $this->rnd_tgl->HrefValue = "";
        $this->rnd_tgl->TooltipValue = "";

        // rnd_oleh
        $this->rnd_oleh->LinkCustomAttributes = "";
        $this->rnd_oleh->HrefValue = "";
        $this->rnd_oleh->TooltipValue = "";

        // ap_tgl
        $this->ap_tgl->LinkCustomAttributes = "";
        $this->ap_tgl->HrefValue = "";
        $this->ap_tgl->TooltipValue = "";

        // ap_oleh
        $this->ap_oleh->LinkCustomAttributes = "";
        $this->ap_oleh->HrefValue = "";
        $this->ap_oleh->TooltipValue = "";

        // batal_tgl
        $this->batal_tgl->LinkCustomAttributes = "";
        $this->batal_tgl->HrefValue = "";
        $this->batal_tgl->TooltipValue = "";

        // batal_oleh
        $this->batal_oleh->LinkCustomAttributes = "";
        $this->batal_oleh->HrefValue = "";
        $this->batal_oleh->TooltipValue = "";

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
        $this->id->PlaceHolder = RemoveHtml($this->id->caption());

        // cpo_jenis
        $this->cpo_jenis->EditAttrs["class"] = "form-control";
        $this->cpo_jenis->EditCustomAttributes = "";
        if (!$this->cpo_jenis->Raw) {
            $this->cpo_jenis->CurrentValue = HtmlDecode($this->cpo_jenis->CurrentValue);
        }
        $this->cpo_jenis->EditValue = $this->cpo_jenis->CurrentValue;
        $this->cpo_jenis->PlaceHolder = RemoveHtml($this->cpo_jenis->caption());

        // ordernum
        $this->ordernum->EditAttrs["class"] = "form-control";
        $this->ordernum->EditCustomAttributes = "";
        if (!$this->ordernum->Raw) {
            $this->ordernum->CurrentValue = HtmlDecode($this->ordernum->CurrentValue);
        }
        $this->ordernum->EditValue = $this->ordernum->CurrentValue;
        $this->ordernum->PlaceHolder = RemoveHtml($this->ordernum->caption());

        // order_kode
        $this->order_kode->EditAttrs["class"] = "form-control";
        $this->order_kode->EditCustomAttributes = "";
        if (!$this->order_kode->Raw) {
            $this->order_kode->CurrentValue = HtmlDecode($this->order_kode->CurrentValue);
        }
        $this->order_kode->EditValue = $this->order_kode->CurrentValue;
        $this->order_kode->PlaceHolder = RemoveHtml($this->order_kode->caption());

        // orderterimatgl
        $this->orderterimatgl->EditAttrs["class"] = "form-control";
        $this->orderterimatgl->EditCustomAttributes = "";
        $this->orderterimatgl->EditValue = FormatDateTime($this->orderterimatgl->CurrentValue, 8);
        $this->orderterimatgl->PlaceHolder = RemoveHtml($this->orderterimatgl->caption());

        // produk_fungsi
        $this->produk_fungsi->EditAttrs["class"] = "form-control";
        $this->produk_fungsi->EditCustomAttributes = "";
        if (!$this->produk_fungsi->Raw) {
            $this->produk_fungsi->CurrentValue = HtmlDecode($this->produk_fungsi->CurrentValue);
        }
        $this->produk_fungsi->EditValue = $this->produk_fungsi->CurrentValue;
        $this->produk_fungsi->PlaceHolder = RemoveHtml($this->produk_fungsi->caption());

        // produk_kualitas
        $this->produk_kualitas->EditAttrs["class"] = "form-control";
        $this->produk_kualitas->EditCustomAttributes = "";
        if (!$this->produk_kualitas->Raw) {
            $this->produk_kualitas->CurrentValue = HtmlDecode($this->produk_kualitas->CurrentValue);
        }
        $this->produk_kualitas->EditValue = $this->produk_kualitas->CurrentValue;
        $this->produk_kualitas->PlaceHolder = RemoveHtml($this->produk_kualitas->caption());

        // produk_campaign
        $this->produk_campaign->EditAttrs["class"] = "form-control";
        $this->produk_campaign->EditCustomAttributes = "";
        if (!$this->produk_campaign->Raw) {
            $this->produk_campaign->CurrentValue = HtmlDecode($this->produk_campaign->CurrentValue);
        }
        $this->produk_campaign->EditValue = $this->produk_campaign->CurrentValue;
        $this->produk_campaign->PlaceHolder = RemoveHtml($this->produk_campaign->caption());

        // kemasan_satuan
        $this->kemasan_satuan->EditAttrs["class"] = "form-control";
        $this->kemasan_satuan->EditCustomAttributes = "";
        if (!$this->kemasan_satuan->Raw) {
            $this->kemasan_satuan->CurrentValue = HtmlDecode($this->kemasan_satuan->CurrentValue);
        }
        $this->kemasan_satuan->EditValue = $this->kemasan_satuan->CurrentValue;
        $this->kemasan_satuan->PlaceHolder = RemoveHtml($this->kemasan_satuan->caption());

        // ordertgl
        $this->ordertgl->EditAttrs["class"] = "form-control";
        $this->ordertgl->EditCustomAttributes = "";
        $this->ordertgl->EditValue = FormatDateTime($this->ordertgl->CurrentValue, 8);
        $this->ordertgl->PlaceHolder = RemoveHtml($this->ordertgl->caption());

        // custcode
        $this->custcode->EditAttrs["class"] = "form-control";
        $this->custcode->EditCustomAttributes = "";
        $this->custcode->EditValue = $this->custcode->CurrentValue;
        $this->custcode->PlaceHolder = RemoveHtml($this->custcode->caption());

        // perushnama
        $this->perushnama->EditAttrs["class"] = "form-control";
        $this->perushnama->EditCustomAttributes = "";
        if (!$this->perushnama->Raw) {
            $this->perushnama->CurrentValue = HtmlDecode($this->perushnama->CurrentValue);
        }
        $this->perushnama->EditValue = $this->perushnama->CurrentValue;
        $this->perushnama->PlaceHolder = RemoveHtml($this->perushnama->caption());

        // perushalamat
        $this->perushalamat->EditAttrs["class"] = "form-control";
        $this->perushalamat->EditCustomAttributes = "";
        if (!$this->perushalamat->Raw) {
            $this->perushalamat->CurrentValue = HtmlDecode($this->perushalamat->CurrentValue);
        }
        $this->perushalamat->EditValue = $this->perushalamat->CurrentValue;
        $this->perushalamat->PlaceHolder = RemoveHtml($this->perushalamat->caption());

        // perushcp
        $this->perushcp->EditAttrs["class"] = "form-control";
        $this->perushcp->EditCustomAttributes = "";
        if (!$this->perushcp->Raw) {
            $this->perushcp->CurrentValue = HtmlDecode($this->perushcp->CurrentValue);
        }
        $this->perushcp->EditValue = $this->perushcp->CurrentValue;
        $this->perushcp->PlaceHolder = RemoveHtml($this->perushcp->caption());

        // perushjabatan
        $this->perushjabatan->EditAttrs["class"] = "form-control";
        $this->perushjabatan->EditCustomAttributes = "";
        if (!$this->perushjabatan->Raw) {
            $this->perushjabatan->CurrentValue = HtmlDecode($this->perushjabatan->CurrentValue);
        }
        $this->perushjabatan->EditValue = $this->perushjabatan->CurrentValue;
        $this->perushjabatan->PlaceHolder = RemoveHtml($this->perushjabatan->caption());

        // perushphone
        $this->perushphone->EditAttrs["class"] = "form-control";
        $this->perushphone->EditCustomAttributes = "";
        if (!$this->perushphone->Raw) {
            $this->perushphone->CurrentValue = HtmlDecode($this->perushphone->CurrentValue);
        }
        $this->perushphone->EditValue = $this->perushphone->CurrentValue;
        $this->perushphone->PlaceHolder = RemoveHtml($this->perushphone->caption());

        // perushmobile
        $this->perushmobile->EditAttrs["class"] = "form-control";
        $this->perushmobile->EditCustomAttributes = "";
        if (!$this->perushmobile->Raw) {
            $this->perushmobile->CurrentValue = HtmlDecode($this->perushmobile->CurrentValue);
        }
        $this->perushmobile->EditValue = $this->perushmobile->CurrentValue;
        $this->perushmobile->PlaceHolder = RemoveHtml($this->perushmobile->caption());

        // bencmark
        $this->bencmark->EditAttrs["class"] = "form-control";
        $this->bencmark->EditCustomAttributes = "";
        if (!$this->bencmark->Raw) {
            $this->bencmark->CurrentValue = HtmlDecode($this->bencmark->CurrentValue);
        }
        $this->bencmark->EditValue = $this->bencmark->CurrentValue;
        $this->bencmark->PlaceHolder = RemoveHtml($this->bencmark->caption());

        // kategoriproduk
        $this->kategoriproduk->EditAttrs["class"] = "form-control";
        $this->kategoriproduk->EditCustomAttributes = "";
        if (!$this->kategoriproduk->Raw) {
            $this->kategoriproduk->CurrentValue = HtmlDecode($this->kategoriproduk->CurrentValue);
        }
        $this->kategoriproduk->EditValue = $this->kategoriproduk->CurrentValue;
        $this->kategoriproduk->PlaceHolder = RemoveHtml($this->kategoriproduk->caption());

        // jenisproduk
        $this->jenisproduk->EditAttrs["class"] = "form-control";
        $this->jenisproduk->EditCustomAttributes = "";
        if (!$this->jenisproduk->Raw) {
            $this->jenisproduk->CurrentValue = HtmlDecode($this->jenisproduk->CurrentValue);
        }
        $this->jenisproduk->EditValue = $this->jenisproduk->CurrentValue;
        $this->jenisproduk->PlaceHolder = RemoveHtml($this->jenisproduk->caption());

        // bentuksediaan
        $this->bentuksediaan->EditAttrs["class"] = "form-control";
        $this->bentuksediaan->EditCustomAttributes = "";
        if (!$this->bentuksediaan->Raw) {
            $this->bentuksediaan->CurrentValue = HtmlDecode($this->bentuksediaan->CurrentValue);
        }
        $this->bentuksediaan->EditValue = $this->bentuksediaan->CurrentValue;
        $this->bentuksediaan->PlaceHolder = RemoveHtml($this->bentuksediaan->caption());

        // sediaan_ukuran
        $this->sediaan_ukuran->EditAttrs["class"] = "form-control";
        $this->sediaan_ukuran->EditCustomAttributes = "";
        $this->sediaan_ukuran->EditValue = $this->sediaan_ukuran->CurrentValue;
        $this->sediaan_ukuran->PlaceHolder = RemoveHtml($this->sediaan_ukuran->caption());
        if (strval($this->sediaan_ukuran->EditValue) != "" && is_numeric($this->sediaan_ukuran->EditValue)) {
            $this->sediaan_ukuran->EditValue = FormatNumber($this->sediaan_ukuran->EditValue, -2, -2, -2, -2);
        }

        // sediaan_ukuran_satuan
        $this->sediaan_ukuran_satuan->EditAttrs["class"] = "form-control";
        $this->sediaan_ukuran_satuan->EditCustomAttributes = "";
        if (!$this->sediaan_ukuran_satuan->Raw) {
            $this->sediaan_ukuran_satuan->CurrentValue = HtmlDecode($this->sediaan_ukuran_satuan->CurrentValue);
        }
        $this->sediaan_ukuran_satuan->EditValue = $this->sediaan_ukuran_satuan->CurrentValue;
        $this->sediaan_ukuran_satuan->PlaceHolder = RemoveHtml($this->sediaan_ukuran_satuan->caption());

        // produk_viskositas
        $this->produk_viskositas->EditAttrs["class"] = "form-control";
        $this->produk_viskositas->EditCustomAttributes = "";
        if (!$this->produk_viskositas->Raw) {
            $this->produk_viskositas->CurrentValue = HtmlDecode($this->produk_viskositas->CurrentValue);
        }
        $this->produk_viskositas->EditValue = $this->produk_viskositas->CurrentValue;
        $this->produk_viskositas->PlaceHolder = RemoveHtml($this->produk_viskositas->caption());

        // konsepproduk
        $this->konsepproduk->EditAttrs["class"] = "form-control";
        $this->konsepproduk->EditCustomAttributes = "";
        if (!$this->konsepproduk->Raw) {
            $this->konsepproduk->CurrentValue = HtmlDecode($this->konsepproduk->CurrentValue);
        }
        $this->konsepproduk->EditValue = $this->konsepproduk->CurrentValue;
        $this->konsepproduk->PlaceHolder = RemoveHtml($this->konsepproduk->caption());

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

        // bahanaktif
        $this->bahanaktif->EditAttrs["class"] = "form-control";
        $this->bahanaktif->EditCustomAttributes = "";
        if (!$this->bahanaktif->Raw) {
            $this->bahanaktif->CurrentValue = HtmlDecode($this->bahanaktif->CurrentValue);
        }
        $this->bahanaktif->EditValue = $this->bahanaktif->CurrentValue;
        $this->bahanaktif->PlaceHolder = RemoveHtml($this->bahanaktif->caption());

        // warna
        $this->warna->EditAttrs["class"] = "form-control";
        $this->warna->EditCustomAttributes = "";
        if (!$this->warna->Raw) {
            $this->warna->CurrentValue = HtmlDecode($this->warna->CurrentValue);
        }
        $this->warna->EditValue = $this->warna->CurrentValue;
        $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

        // produk_warna_jenis
        $this->produk_warna_jenis->EditAttrs["class"] = "form-control";
        $this->produk_warna_jenis->EditCustomAttributes = "";
        if (!$this->produk_warna_jenis->Raw) {
            $this->produk_warna_jenis->CurrentValue = HtmlDecode($this->produk_warna_jenis->CurrentValue);
        }
        $this->produk_warna_jenis->EditValue = $this->produk_warna_jenis->CurrentValue;
        $this->produk_warna_jenis->PlaceHolder = RemoveHtml($this->produk_warna_jenis->caption());

        // aksesoris
        $this->aksesoris->EditAttrs["class"] = "form-control";
        $this->aksesoris->EditCustomAttributes = "";
        if (!$this->aksesoris->Raw) {
            $this->aksesoris->CurrentValue = HtmlDecode($this->aksesoris->CurrentValue);
        }
        $this->aksesoris->EditValue = $this->aksesoris->CurrentValue;
        $this->aksesoris->PlaceHolder = RemoveHtml($this->aksesoris->caption());

        // produk_lainlain
        $this->produk_lainlain->EditAttrs["class"] = "form-control";
        $this->produk_lainlain->EditCustomAttributes = "";
        $this->produk_lainlain->EditValue = $this->produk_lainlain->CurrentValue;
        $this->produk_lainlain->PlaceHolder = RemoveHtml($this->produk_lainlain->caption());

        // statusproduk
        $this->statusproduk->EditAttrs["class"] = "form-control";
        $this->statusproduk->EditCustomAttributes = "";
        if (!$this->statusproduk->Raw) {
            $this->statusproduk->CurrentValue = HtmlDecode($this->statusproduk->CurrentValue);
        }
        $this->statusproduk->EditValue = $this->statusproduk->CurrentValue;
        $this->statusproduk->PlaceHolder = RemoveHtml($this->statusproduk->caption());

        // parfum
        $this->parfum->EditAttrs["class"] = "form-control";
        $this->parfum->EditCustomAttributes = "";
        if (!$this->parfum->Raw) {
            $this->parfum->CurrentValue = HtmlDecode($this->parfum->CurrentValue);
        }
        $this->parfum->EditValue = $this->parfum->CurrentValue;
        $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

        // catatan
        $this->catatan->EditAttrs["class"] = "form-control";
        $this->catatan->EditCustomAttributes = "";
        if (!$this->catatan->Raw) {
            $this->catatan->CurrentValue = HtmlDecode($this->catatan->CurrentValue);
        }
        $this->catatan->EditValue = $this->catatan->CurrentValue;
        $this->catatan->PlaceHolder = RemoveHtml($this->catatan->caption());

        // rencanakemasan
        $this->rencanakemasan->EditAttrs["class"] = "form-control";
        $this->rencanakemasan->EditCustomAttributes = "";
        if (!$this->rencanakemasan->Raw) {
            $this->rencanakemasan->CurrentValue = HtmlDecode($this->rencanakemasan->CurrentValue);
        }
        $this->rencanakemasan->EditValue = $this->rencanakemasan->CurrentValue;
        $this->rencanakemasan->PlaceHolder = RemoveHtml($this->rencanakemasan->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // ekspetasiharga
        $this->ekspetasiharga->EditAttrs["class"] = "form-control";
        $this->ekspetasiharga->EditCustomAttributes = "";
        $this->ekspetasiharga->EditValue = $this->ekspetasiharga->CurrentValue;
        $this->ekspetasiharga->PlaceHolder = RemoveHtml($this->ekspetasiharga->caption());
        if (strval($this->ekspetasiharga->EditValue) != "" && is_numeric($this->ekspetasiharga->EditValue)) {
            $this->ekspetasiharga->EditValue = FormatNumber($this->ekspetasiharga->EditValue, -2, -2, -2, -2);
        }

        // kemasan
        $this->kemasan->EditAttrs["class"] = "form-control";
        $this->kemasan->EditCustomAttributes = "";
        if (!$this->kemasan->Raw) {
            $this->kemasan->CurrentValue = HtmlDecode($this->kemasan->CurrentValue);
        }
        $this->kemasan->EditValue = $this->kemasan->CurrentValue;
        $this->kemasan->PlaceHolder = RemoveHtml($this->kemasan->caption());

        // volume
        $this->volume->EditAttrs["class"] = "form-control";
        $this->volume->EditCustomAttributes = "";
        $this->volume->EditValue = $this->volume->CurrentValue;
        $this->volume->PlaceHolder = RemoveHtml($this->volume->caption());
        if (strval($this->volume->EditValue) != "" && is_numeric($this->volume->EditValue)) {
            $this->volume->EditValue = FormatNumber($this->volume->EditValue, -2, -2, -2, -2);
        }

        // jenistutup
        $this->jenistutup->EditAttrs["class"] = "form-control";
        $this->jenistutup->EditCustomAttributes = "";
        if (!$this->jenistutup->Raw) {
            $this->jenistutup->CurrentValue = HtmlDecode($this->jenistutup->CurrentValue);
        }
        $this->jenistutup->EditValue = $this->jenistutup->CurrentValue;
        $this->jenistutup->PlaceHolder = RemoveHtml($this->jenistutup->caption());

        // catatanpackaging
        $this->catatanpackaging->EditAttrs["class"] = "form-control";
        $this->catatanpackaging->EditCustomAttributes = "";
        $this->catatanpackaging->EditValue = $this->catatanpackaging->CurrentValue;
        $this->catatanpackaging->PlaceHolder = RemoveHtml($this->catatanpackaging->caption());

        // infopackaging
        $this->infopackaging->EditAttrs["class"] = "form-control";
        $this->infopackaging->EditCustomAttributes = "";
        if (!$this->infopackaging->Raw) {
            $this->infopackaging->CurrentValue = HtmlDecode($this->infopackaging->CurrentValue);
        }
        $this->infopackaging->EditValue = $this->infopackaging->CurrentValue;
        $this->infopackaging->PlaceHolder = RemoveHtml($this->infopackaging->caption());

        // ukuran
        $this->ukuran->EditAttrs["class"] = "form-control";
        $this->ukuran->EditCustomAttributes = "";
        $this->ukuran->EditValue = $this->ukuran->CurrentValue;
        $this->ukuran->PlaceHolder = RemoveHtml($this->ukuran->caption());

        // desainprodukkemasan
        $this->desainprodukkemasan->EditAttrs["class"] = "form-control";
        $this->desainprodukkemasan->EditCustomAttributes = "";
        if (!$this->desainprodukkemasan->Raw) {
            $this->desainprodukkemasan->CurrentValue = HtmlDecode($this->desainprodukkemasan->CurrentValue);
        }
        $this->desainprodukkemasan->EditValue = $this->desainprodukkemasan->CurrentValue;
        $this->desainprodukkemasan->PlaceHolder = RemoveHtml($this->desainprodukkemasan->caption());

        // desaindiinginkan
        $this->desaindiinginkan->EditAttrs["class"] = "form-control";
        $this->desaindiinginkan->EditCustomAttributes = "";
        if (!$this->desaindiinginkan->Raw) {
            $this->desaindiinginkan->CurrentValue = HtmlDecode($this->desaindiinginkan->CurrentValue);
        }
        $this->desaindiinginkan->EditValue = $this->desaindiinginkan->CurrentValue;
        $this->desaindiinginkan->PlaceHolder = RemoveHtml($this->desaindiinginkan->caption());

        // mereknotifikasi
        $this->mereknotifikasi->EditAttrs["class"] = "form-control";
        $this->mereknotifikasi->EditCustomAttributes = "";
        if (!$this->mereknotifikasi->Raw) {
            $this->mereknotifikasi->CurrentValue = HtmlDecode($this->mereknotifikasi->CurrentValue);
        }
        $this->mereknotifikasi->EditValue = $this->mereknotifikasi->CurrentValue;
        $this->mereknotifikasi->PlaceHolder = RemoveHtml($this->mereknotifikasi->caption());

        // kategoristatus
        $this->kategoristatus->EditAttrs["class"] = "form-control";
        $this->kategoristatus->EditCustomAttributes = "";
        if (!$this->kategoristatus->Raw) {
            $this->kategoristatus->CurrentValue = HtmlDecode($this->kategoristatus->CurrentValue);
        }
        $this->kategoristatus->EditValue = $this->kategoristatus->CurrentValue;
        $this->kategoristatus->PlaceHolder = RemoveHtml($this->kategoristatus->caption());

        // kemasan_ukuran_satuan
        $this->kemasan_ukuran_satuan->EditAttrs["class"] = "form-control";
        $this->kemasan_ukuran_satuan->EditCustomAttributes = "";
        if (!$this->kemasan_ukuran_satuan->Raw) {
            $this->kemasan_ukuran_satuan->CurrentValue = HtmlDecode($this->kemasan_ukuran_satuan->CurrentValue);
        }
        $this->kemasan_ukuran_satuan->EditValue = $this->kemasan_ukuran_satuan->CurrentValue;
        $this->kemasan_ukuran_satuan->PlaceHolder = RemoveHtml($this->kemasan_ukuran_satuan->caption());

        // notifikasicatatan
        $this->notifikasicatatan->EditAttrs["class"] = "form-control";
        $this->notifikasicatatan->EditCustomAttributes = "";
        $this->notifikasicatatan->EditValue = $this->notifikasicatatan->CurrentValue;
        $this->notifikasicatatan->PlaceHolder = RemoveHtml($this->notifikasicatatan->caption());

        // label_ukuran
        $this->label_ukuran->EditAttrs["class"] = "form-control";
        $this->label_ukuran->EditCustomAttributes = "";
        $this->label_ukuran->EditValue = $this->label_ukuran->CurrentValue;
        $this->label_ukuran->PlaceHolder = RemoveHtml($this->label_ukuran->caption());

        // infolabel
        $this->infolabel->EditAttrs["class"] = "form-control";
        $this->infolabel->EditCustomAttributes = "";
        if (!$this->infolabel->Raw) {
            $this->infolabel->CurrentValue = HtmlDecode($this->infolabel->CurrentValue);
        }
        $this->infolabel->EditValue = $this->infolabel->CurrentValue;
        $this->infolabel->PlaceHolder = RemoveHtml($this->infolabel->caption());

        // labelkualitas
        $this->labelkualitas->EditAttrs["class"] = "form-control";
        $this->labelkualitas->EditCustomAttributes = "";
        if (!$this->labelkualitas->Raw) {
            $this->labelkualitas->CurrentValue = HtmlDecode($this->labelkualitas->CurrentValue);
        }
        $this->labelkualitas->EditValue = $this->labelkualitas->CurrentValue;
        $this->labelkualitas->PlaceHolder = RemoveHtml($this->labelkualitas->caption());

        // labelposisi
        $this->labelposisi->EditAttrs["class"] = "form-control";
        $this->labelposisi->EditCustomAttributes = "";
        if (!$this->labelposisi->Raw) {
            $this->labelposisi->CurrentValue = HtmlDecode($this->labelposisi->CurrentValue);
        }
        $this->labelposisi->EditValue = $this->labelposisi->CurrentValue;
        $this->labelposisi->PlaceHolder = RemoveHtml($this->labelposisi->caption());

        // labelcatatan
        $this->labelcatatan->EditAttrs["class"] = "form-control";
        $this->labelcatatan->EditCustomAttributes = "";
        $this->labelcatatan->EditValue = $this->labelcatatan->CurrentValue;
        $this->labelcatatan->PlaceHolder = RemoveHtml($this->labelcatatan->caption());

        // dibuatdi
        $this->dibuatdi->EditAttrs["class"] = "form-control";
        $this->dibuatdi->EditCustomAttributes = "";
        if (!$this->dibuatdi->Raw) {
            $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
        }
        $this->dibuatdi->EditValue = $this->dibuatdi->CurrentValue;
        $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

        // tanggal
        $this->tanggal->EditAttrs["class"] = "form-control";
        $this->tanggal->EditCustomAttributes = "";
        $this->tanggal->EditValue = FormatDateTime($this->tanggal->CurrentValue, 8);
        $this->tanggal->PlaceHolder = RemoveHtml($this->tanggal->caption());

        // penerima
        $this->penerima->EditAttrs["class"] = "form-control";
        $this->penerima->EditCustomAttributes = "";
        $this->penerima->EditValue = $this->penerima->CurrentValue;
        $this->penerima->PlaceHolder = RemoveHtml($this->penerima->caption());

        // createat
        $this->createat->EditAttrs["class"] = "form-control";
        $this->createat->EditCustomAttributes = "";
        $this->createat->EditValue = FormatDateTime($this->createat->CurrentValue, 8);
        $this->createat->PlaceHolder = RemoveHtml($this->createat->caption());

        // createby
        $this->createby->EditAttrs["class"] = "form-control";
        $this->createby->EditCustomAttributes = "";
        $this->createby->EditValue = $this->createby->CurrentValue;
        $this->createby->PlaceHolder = RemoveHtml($this->createby->caption());

        // statusdokumen
        $this->statusdokumen->EditAttrs["class"] = "form-control";
        $this->statusdokumen->EditCustomAttributes = "";
        if (!$this->statusdokumen->Raw) {
            $this->statusdokumen->CurrentValue = HtmlDecode($this->statusdokumen->CurrentValue);
        }
        $this->statusdokumen->EditValue = $this->statusdokumen->CurrentValue;
        $this->statusdokumen->PlaceHolder = RemoveHtml($this->statusdokumen->caption());

        // update_at
        $this->update_at->EditAttrs["class"] = "form-control";
        $this->update_at->EditCustomAttributes = "";
        $this->update_at->EditValue = FormatDateTime($this->update_at->CurrentValue, 8);
        $this->update_at->PlaceHolder = RemoveHtml($this->update_at->caption());

        // status_data
        $this->status_data->EditAttrs["class"] = "form-control";
        $this->status_data->EditCustomAttributes = "";
        if (!$this->status_data->Raw) {
            $this->status_data->CurrentValue = HtmlDecode($this->status_data->CurrentValue);
        }
        $this->status_data->EditValue = $this->status_data->CurrentValue;
        $this->status_data->PlaceHolder = RemoveHtml($this->status_data->caption());

        // harga_rnd
        $this->harga_rnd->EditAttrs["class"] = "form-control";
        $this->harga_rnd->EditCustomAttributes = "";
        $this->harga_rnd->EditValue = $this->harga_rnd->CurrentValue;
        $this->harga_rnd->PlaceHolder = RemoveHtml($this->harga_rnd->caption());
        if (strval($this->harga_rnd->EditValue) != "" && is_numeric($this->harga_rnd->EditValue)) {
            $this->harga_rnd->EditValue = FormatNumber($this->harga_rnd->EditValue, -2, -2, -2, -2);
        }

        // aplikasi_sediaan
        $this->aplikasi_sediaan->EditAttrs["class"] = "form-control";
        $this->aplikasi_sediaan->EditCustomAttributes = "";
        if (!$this->aplikasi_sediaan->Raw) {
            $this->aplikasi_sediaan->CurrentValue = HtmlDecode($this->aplikasi_sediaan->CurrentValue);
        }
        $this->aplikasi_sediaan->EditValue = $this->aplikasi_sediaan->CurrentValue;
        $this->aplikasi_sediaan->PlaceHolder = RemoveHtml($this->aplikasi_sediaan->caption());

        // hu_hrg_isi
        $this->hu_hrg_isi->EditAttrs["class"] = "form-control";
        $this->hu_hrg_isi->EditCustomAttributes = "";
        $this->hu_hrg_isi->EditValue = $this->hu_hrg_isi->CurrentValue;
        $this->hu_hrg_isi->PlaceHolder = RemoveHtml($this->hu_hrg_isi->caption());
        if (strval($this->hu_hrg_isi->EditValue) != "" && is_numeric($this->hu_hrg_isi->EditValue)) {
            $this->hu_hrg_isi->EditValue = FormatNumber($this->hu_hrg_isi->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_isi_pro
        $this->hu_hrg_isi_pro->EditAttrs["class"] = "form-control";
        $this->hu_hrg_isi_pro->EditCustomAttributes = "";
        $this->hu_hrg_isi_pro->EditValue = $this->hu_hrg_isi_pro->CurrentValue;
        $this->hu_hrg_isi_pro->PlaceHolder = RemoveHtml($this->hu_hrg_isi_pro->caption());
        if (strval($this->hu_hrg_isi_pro->EditValue) != "" && is_numeric($this->hu_hrg_isi_pro->EditValue)) {
            $this->hu_hrg_isi_pro->EditValue = FormatNumber($this->hu_hrg_isi_pro->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_kms_primer
        $this->hu_hrg_kms_primer->EditAttrs["class"] = "form-control";
        $this->hu_hrg_kms_primer->EditCustomAttributes = "";
        $this->hu_hrg_kms_primer->EditValue = $this->hu_hrg_kms_primer->CurrentValue;
        $this->hu_hrg_kms_primer->PlaceHolder = RemoveHtml($this->hu_hrg_kms_primer->caption());
        if (strval($this->hu_hrg_kms_primer->EditValue) != "" && is_numeric($this->hu_hrg_kms_primer->EditValue)) {
            $this->hu_hrg_kms_primer->EditValue = FormatNumber($this->hu_hrg_kms_primer->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_kms_primer_pro
        $this->hu_hrg_kms_primer_pro->EditAttrs["class"] = "form-control";
        $this->hu_hrg_kms_primer_pro->EditCustomAttributes = "";
        $this->hu_hrg_kms_primer_pro->EditValue = $this->hu_hrg_kms_primer_pro->CurrentValue;
        $this->hu_hrg_kms_primer_pro->PlaceHolder = RemoveHtml($this->hu_hrg_kms_primer_pro->caption());
        if (strval($this->hu_hrg_kms_primer_pro->EditValue) != "" && is_numeric($this->hu_hrg_kms_primer_pro->EditValue)) {
            $this->hu_hrg_kms_primer_pro->EditValue = FormatNumber($this->hu_hrg_kms_primer_pro->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_kms_sekunder
        $this->hu_hrg_kms_sekunder->EditAttrs["class"] = "form-control";
        $this->hu_hrg_kms_sekunder->EditCustomAttributes = "";
        $this->hu_hrg_kms_sekunder->EditValue = $this->hu_hrg_kms_sekunder->CurrentValue;
        $this->hu_hrg_kms_sekunder->PlaceHolder = RemoveHtml($this->hu_hrg_kms_sekunder->caption());
        if (strval($this->hu_hrg_kms_sekunder->EditValue) != "" && is_numeric($this->hu_hrg_kms_sekunder->EditValue)) {
            $this->hu_hrg_kms_sekunder->EditValue = FormatNumber($this->hu_hrg_kms_sekunder->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_kms_sekunder_pro
        $this->hu_hrg_kms_sekunder_pro->EditAttrs["class"] = "form-control";
        $this->hu_hrg_kms_sekunder_pro->EditCustomAttributes = "";
        $this->hu_hrg_kms_sekunder_pro->EditValue = $this->hu_hrg_kms_sekunder_pro->CurrentValue;
        $this->hu_hrg_kms_sekunder_pro->PlaceHolder = RemoveHtml($this->hu_hrg_kms_sekunder_pro->caption());
        if (strval($this->hu_hrg_kms_sekunder_pro->EditValue) != "" && is_numeric($this->hu_hrg_kms_sekunder_pro->EditValue)) {
            $this->hu_hrg_kms_sekunder_pro->EditValue = FormatNumber($this->hu_hrg_kms_sekunder_pro->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_label
        $this->hu_hrg_label->EditAttrs["class"] = "form-control";
        $this->hu_hrg_label->EditCustomAttributes = "";
        $this->hu_hrg_label->EditValue = $this->hu_hrg_label->CurrentValue;
        $this->hu_hrg_label->PlaceHolder = RemoveHtml($this->hu_hrg_label->caption());
        if (strval($this->hu_hrg_label->EditValue) != "" && is_numeric($this->hu_hrg_label->EditValue)) {
            $this->hu_hrg_label->EditValue = FormatNumber($this->hu_hrg_label->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_label_pro
        $this->hu_hrg_label_pro->EditAttrs["class"] = "form-control";
        $this->hu_hrg_label_pro->EditCustomAttributes = "";
        $this->hu_hrg_label_pro->EditValue = $this->hu_hrg_label_pro->CurrentValue;
        $this->hu_hrg_label_pro->PlaceHolder = RemoveHtml($this->hu_hrg_label_pro->caption());
        if (strval($this->hu_hrg_label_pro->EditValue) != "" && is_numeric($this->hu_hrg_label_pro->EditValue)) {
            $this->hu_hrg_label_pro->EditValue = FormatNumber($this->hu_hrg_label_pro->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_total
        $this->hu_hrg_total->EditAttrs["class"] = "form-control";
        $this->hu_hrg_total->EditCustomAttributes = "";
        $this->hu_hrg_total->EditValue = $this->hu_hrg_total->CurrentValue;
        $this->hu_hrg_total->PlaceHolder = RemoveHtml($this->hu_hrg_total->caption());
        if (strval($this->hu_hrg_total->EditValue) != "" && is_numeric($this->hu_hrg_total->EditValue)) {
            $this->hu_hrg_total->EditValue = FormatNumber($this->hu_hrg_total->EditValue, -2, -2, -2, -2);
        }

        // hu_hrg_total_pro
        $this->hu_hrg_total_pro->EditAttrs["class"] = "form-control";
        $this->hu_hrg_total_pro->EditCustomAttributes = "";
        $this->hu_hrg_total_pro->EditValue = $this->hu_hrg_total_pro->CurrentValue;
        $this->hu_hrg_total_pro->PlaceHolder = RemoveHtml($this->hu_hrg_total_pro->caption());
        if (strval($this->hu_hrg_total_pro->EditValue) != "" && is_numeric($this->hu_hrg_total_pro->EditValue)) {
            $this->hu_hrg_total_pro->EditValue = FormatNumber($this->hu_hrg_total_pro->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_isi
        $this->hl_hrg_isi->EditAttrs["class"] = "form-control";
        $this->hl_hrg_isi->EditCustomAttributes = "";
        $this->hl_hrg_isi->EditValue = $this->hl_hrg_isi->CurrentValue;
        $this->hl_hrg_isi->PlaceHolder = RemoveHtml($this->hl_hrg_isi->caption());
        if (strval($this->hl_hrg_isi->EditValue) != "" && is_numeric($this->hl_hrg_isi->EditValue)) {
            $this->hl_hrg_isi->EditValue = FormatNumber($this->hl_hrg_isi->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_isi_pro
        $this->hl_hrg_isi_pro->EditAttrs["class"] = "form-control";
        $this->hl_hrg_isi_pro->EditCustomAttributes = "";
        $this->hl_hrg_isi_pro->EditValue = $this->hl_hrg_isi_pro->CurrentValue;
        $this->hl_hrg_isi_pro->PlaceHolder = RemoveHtml($this->hl_hrg_isi_pro->caption());
        if (strval($this->hl_hrg_isi_pro->EditValue) != "" && is_numeric($this->hl_hrg_isi_pro->EditValue)) {
            $this->hl_hrg_isi_pro->EditValue = FormatNumber($this->hl_hrg_isi_pro->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_kms_primer
        $this->hl_hrg_kms_primer->EditAttrs["class"] = "form-control";
        $this->hl_hrg_kms_primer->EditCustomAttributes = "";
        $this->hl_hrg_kms_primer->EditValue = $this->hl_hrg_kms_primer->CurrentValue;
        $this->hl_hrg_kms_primer->PlaceHolder = RemoveHtml($this->hl_hrg_kms_primer->caption());
        if (strval($this->hl_hrg_kms_primer->EditValue) != "" && is_numeric($this->hl_hrg_kms_primer->EditValue)) {
            $this->hl_hrg_kms_primer->EditValue = FormatNumber($this->hl_hrg_kms_primer->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_kms_primer_pro
        $this->hl_hrg_kms_primer_pro->EditAttrs["class"] = "form-control";
        $this->hl_hrg_kms_primer_pro->EditCustomAttributes = "";
        $this->hl_hrg_kms_primer_pro->EditValue = $this->hl_hrg_kms_primer_pro->CurrentValue;
        $this->hl_hrg_kms_primer_pro->PlaceHolder = RemoveHtml($this->hl_hrg_kms_primer_pro->caption());
        if (strval($this->hl_hrg_kms_primer_pro->EditValue) != "" && is_numeric($this->hl_hrg_kms_primer_pro->EditValue)) {
            $this->hl_hrg_kms_primer_pro->EditValue = FormatNumber($this->hl_hrg_kms_primer_pro->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_kms_sekunder
        $this->hl_hrg_kms_sekunder->EditAttrs["class"] = "form-control";
        $this->hl_hrg_kms_sekunder->EditCustomAttributes = "";
        $this->hl_hrg_kms_sekunder->EditValue = $this->hl_hrg_kms_sekunder->CurrentValue;
        $this->hl_hrg_kms_sekunder->PlaceHolder = RemoveHtml($this->hl_hrg_kms_sekunder->caption());
        if (strval($this->hl_hrg_kms_sekunder->EditValue) != "" && is_numeric($this->hl_hrg_kms_sekunder->EditValue)) {
            $this->hl_hrg_kms_sekunder->EditValue = FormatNumber($this->hl_hrg_kms_sekunder->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_kms_sekunder_pro
        $this->hl_hrg_kms_sekunder_pro->EditAttrs["class"] = "form-control";
        $this->hl_hrg_kms_sekunder_pro->EditCustomAttributes = "";
        $this->hl_hrg_kms_sekunder_pro->EditValue = $this->hl_hrg_kms_sekunder_pro->CurrentValue;
        $this->hl_hrg_kms_sekunder_pro->PlaceHolder = RemoveHtml($this->hl_hrg_kms_sekunder_pro->caption());
        if (strval($this->hl_hrg_kms_sekunder_pro->EditValue) != "" && is_numeric($this->hl_hrg_kms_sekunder_pro->EditValue)) {
            $this->hl_hrg_kms_sekunder_pro->EditValue = FormatNumber($this->hl_hrg_kms_sekunder_pro->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_label
        $this->hl_hrg_label->EditAttrs["class"] = "form-control";
        $this->hl_hrg_label->EditCustomAttributes = "";
        $this->hl_hrg_label->EditValue = $this->hl_hrg_label->CurrentValue;
        $this->hl_hrg_label->PlaceHolder = RemoveHtml($this->hl_hrg_label->caption());
        if (strval($this->hl_hrg_label->EditValue) != "" && is_numeric($this->hl_hrg_label->EditValue)) {
            $this->hl_hrg_label->EditValue = FormatNumber($this->hl_hrg_label->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_label_pro
        $this->hl_hrg_label_pro->EditAttrs["class"] = "form-control";
        $this->hl_hrg_label_pro->EditCustomAttributes = "";
        $this->hl_hrg_label_pro->EditValue = $this->hl_hrg_label_pro->CurrentValue;
        $this->hl_hrg_label_pro->PlaceHolder = RemoveHtml($this->hl_hrg_label_pro->caption());
        if (strval($this->hl_hrg_label_pro->EditValue) != "" && is_numeric($this->hl_hrg_label_pro->EditValue)) {
            $this->hl_hrg_label_pro->EditValue = FormatNumber($this->hl_hrg_label_pro->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_total
        $this->hl_hrg_total->EditAttrs["class"] = "form-control";
        $this->hl_hrg_total->EditCustomAttributes = "";
        $this->hl_hrg_total->EditValue = $this->hl_hrg_total->CurrentValue;
        $this->hl_hrg_total->PlaceHolder = RemoveHtml($this->hl_hrg_total->caption());
        if (strval($this->hl_hrg_total->EditValue) != "" && is_numeric($this->hl_hrg_total->EditValue)) {
            $this->hl_hrg_total->EditValue = FormatNumber($this->hl_hrg_total->EditValue, -2, -2, -2, -2);
        }

        // hl_hrg_total_pro
        $this->hl_hrg_total_pro->EditAttrs["class"] = "form-control";
        $this->hl_hrg_total_pro->EditCustomAttributes = "";
        $this->hl_hrg_total_pro->EditValue = $this->hl_hrg_total_pro->CurrentValue;
        $this->hl_hrg_total_pro->PlaceHolder = RemoveHtml($this->hl_hrg_total_pro->caption());
        if (strval($this->hl_hrg_total_pro->EditValue) != "" && is_numeric($this->hl_hrg_total_pro->EditValue)) {
            $this->hl_hrg_total_pro->EditValue = FormatNumber($this->hl_hrg_total_pro->EditValue, -2, -2, -2, -2);
        }

        // bs_bahan_aktif_tick
        $this->bs_bahan_aktif_tick->EditAttrs["class"] = "form-control";
        $this->bs_bahan_aktif_tick->EditCustomAttributes = "";
        if (!$this->bs_bahan_aktif_tick->Raw) {
            $this->bs_bahan_aktif_tick->CurrentValue = HtmlDecode($this->bs_bahan_aktif_tick->CurrentValue);
        }
        $this->bs_bahan_aktif_tick->EditValue = $this->bs_bahan_aktif_tick->CurrentValue;
        $this->bs_bahan_aktif_tick->PlaceHolder = RemoveHtml($this->bs_bahan_aktif_tick->caption());

        // bs_bahan_aktif
        $this->bs_bahan_aktif->EditAttrs["class"] = "form-control";
        $this->bs_bahan_aktif->EditCustomAttributes = "";
        $this->bs_bahan_aktif->EditValue = $this->bs_bahan_aktif->CurrentValue;
        $this->bs_bahan_aktif->PlaceHolder = RemoveHtml($this->bs_bahan_aktif->caption());

        // bs_bahan_lain
        $this->bs_bahan_lain->EditAttrs["class"] = "form-control";
        $this->bs_bahan_lain->EditCustomAttributes = "";
        $this->bs_bahan_lain->EditValue = $this->bs_bahan_lain->CurrentValue;
        $this->bs_bahan_lain->PlaceHolder = RemoveHtml($this->bs_bahan_lain->caption());

        // bs_parfum
        $this->bs_parfum->EditAttrs["class"] = "form-control";
        $this->bs_parfum->EditCustomAttributes = "";
        $this->bs_parfum->EditValue = $this->bs_parfum->CurrentValue;
        $this->bs_parfum->PlaceHolder = RemoveHtml($this->bs_parfum->caption());

        // bs_estetika
        $this->bs_estetika->EditAttrs["class"] = "form-control";
        $this->bs_estetika->EditCustomAttributes = "";
        $this->bs_estetika->EditValue = $this->bs_estetika->CurrentValue;
        $this->bs_estetika->PlaceHolder = RemoveHtml($this->bs_estetika->caption());

        // bs_kms_wadah
        $this->bs_kms_wadah->EditAttrs["class"] = "form-control";
        $this->bs_kms_wadah->EditCustomAttributes = "";
        $this->bs_kms_wadah->EditValue = $this->bs_kms_wadah->CurrentValue;
        $this->bs_kms_wadah->PlaceHolder = RemoveHtml($this->bs_kms_wadah->caption());

        // bs_kms_tutup
        $this->bs_kms_tutup->EditAttrs["class"] = "form-control";
        $this->bs_kms_tutup->EditCustomAttributes = "";
        $this->bs_kms_tutup->EditValue = $this->bs_kms_tutup->CurrentValue;
        $this->bs_kms_tutup->PlaceHolder = RemoveHtml($this->bs_kms_tutup->caption());

        // bs_kms_sekunder
        $this->bs_kms_sekunder->EditAttrs["class"] = "form-control";
        $this->bs_kms_sekunder->EditCustomAttributes = "";
        $this->bs_kms_sekunder->EditValue = $this->bs_kms_sekunder->CurrentValue;
        $this->bs_kms_sekunder->PlaceHolder = RemoveHtml($this->bs_kms_sekunder->caption());

        // bs_label_desain
        $this->bs_label_desain->EditAttrs["class"] = "form-control";
        $this->bs_label_desain->EditCustomAttributes = "";
        $this->bs_label_desain->EditValue = $this->bs_label_desain->CurrentValue;
        $this->bs_label_desain->PlaceHolder = RemoveHtml($this->bs_label_desain->caption());

        // bs_label_cetak
        $this->bs_label_cetak->EditAttrs["class"] = "form-control";
        $this->bs_label_cetak->EditCustomAttributes = "";
        $this->bs_label_cetak->EditValue = $this->bs_label_cetak->CurrentValue;
        $this->bs_label_cetak->PlaceHolder = RemoveHtml($this->bs_label_cetak->caption());

        // bs_label_lain
        $this->bs_label_lain->EditAttrs["class"] = "form-control";
        $this->bs_label_lain->EditCustomAttributes = "";
        $this->bs_label_lain->EditValue = $this->bs_label_lain->CurrentValue;
        $this->bs_label_lain->PlaceHolder = RemoveHtml($this->bs_label_lain->caption());

        // dlv_pickup
        $this->dlv_pickup->EditAttrs["class"] = "form-control";
        $this->dlv_pickup->EditCustomAttributes = "";
        $this->dlv_pickup->EditValue = $this->dlv_pickup->CurrentValue;
        $this->dlv_pickup->PlaceHolder = RemoveHtml($this->dlv_pickup->caption());

        // dlv_singlepoint
        $this->dlv_singlepoint->EditAttrs["class"] = "form-control";
        $this->dlv_singlepoint->EditCustomAttributes = "";
        $this->dlv_singlepoint->EditValue = $this->dlv_singlepoint->CurrentValue;
        $this->dlv_singlepoint->PlaceHolder = RemoveHtml($this->dlv_singlepoint->caption());

        // dlv_multipoint
        $this->dlv_multipoint->EditAttrs["class"] = "form-control";
        $this->dlv_multipoint->EditCustomAttributes = "";
        $this->dlv_multipoint->EditValue = $this->dlv_multipoint->CurrentValue;
        $this->dlv_multipoint->PlaceHolder = RemoveHtml($this->dlv_multipoint->caption());

        // dlv_multipoint_jml
        $this->dlv_multipoint_jml->EditAttrs["class"] = "form-control";
        $this->dlv_multipoint_jml->EditCustomAttributes = "";
        $this->dlv_multipoint_jml->EditValue = $this->dlv_multipoint_jml->CurrentValue;
        $this->dlv_multipoint_jml->PlaceHolder = RemoveHtml($this->dlv_multipoint_jml->caption());

        // dlv_term_lain
        $this->dlv_term_lain->EditAttrs["class"] = "form-control";
        $this->dlv_term_lain->EditCustomAttributes = "";
        $this->dlv_term_lain->EditValue = $this->dlv_term_lain->CurrentValue;
        $this->dlv_term_lain->PlaceHolder = RemoveHtml($this->dlv_term_lain->caption());

        // catatan_khusus
        $this->catatan_khusus->EditAttrs["class"] = "form-control";
        $this->catatan_khusus->EditCustomAttributes = "";
        $this->catatan_khusus->EditValue = $this->catatan_khusus->CurrentValue;
        $this->catatan_khusus->PlaceHolder = RemoveHtml($this->catatan_khusus->caption());

        // aju_tgl
        $this->aju_tgl->EditAttrs["class"] = "form-control";
        $this->aju_tgl->EditCustomAttributes = "";
        $this->aju_tgl->EditValue = FormatDateTime($this->aju_tgl->CurrentValue, 8);
        $this->aju_tgl->PlaceHolder = RemoveHtml($this->aju_tgl->caption());

        // aju_oleh
        $this->aju_oleh->EditAttrs["class"] = "form-control";
        $this->aju_oleh->EditCustomAttributes = "";
        $this->aju_oleh->EditValue = $this->aju_oleh->CurrentValue;
        $this->aju_oleh->PlaceHolder = RemoveHtml($this->aju_oleh->caption());

        // proses_tgl
        $this->proses_tgl->EditAttrs["class"] = "form-control";
        $this->proses_tgl->EditCustomAttributes = "";
        $this->proses_tgl->EditValue = FormatDateTime($this->proses_tgl->CurrentValue, 8);
        $this->proses_tgl->PlaceHolder = RemoveHtml($this->proses_tgl->caption());

        // proses_oleh
        $this->proses_oleh->EditAttrs["class"] = "form-control";
        $this->proses_oleh->EditCustomAttributes = "";
        $this->proses_oleh->EditValue = $this->proses_oleh->CurrentValue;
        $this->proses_oleh->PlaceHolder = RemoveHtml($this->proses_oleh->caption());

        // revisi_tgl
        $this->revisi_tgl->EditAttrs["class"] = "form-control";
        $this->revisi_tgl->EditCustomAttributes = "";
        $this->revisi_tgl->EditValue = FormatDateTime($this->revisi_tgl->CurrentValue, 8);
        $this->revisi_tgl->PlaceHolder = RemoveHtml($this->revisi_tgl->caption());

        // revisi_oleh
        $this->revisi_oleh->EditAttrs["class"] = "form-control";
        $this->revisi_oleh->EditCustomAttributes = "";
        $this->revisi_oleh->EditValue = $this->revisi_oleh->CurrentValue;
        $this->revisi_oleh->PlaceHolder = RemoveHtml($this->revisi_oleh->caption());

        // revisi_akun_tgl
        $this->revisi_akun_tgl->EditAttrs["class"] = "form-control";
        $this->revisi_akun_tgl->EditCustomAttributes = "";
        $this->revisi_akun_tgl->EditValue = FormatDateTime($this->revisi_akun_tgl->CurrentValue, 8);
        $this->revisi_akun_tgl->PlaceHolder = RemoveHtml($this->revisi_akun_tgl->caption());

        // revisi_akun_oleh
        $this->revisi_akun_oleh->EditAttrs["class"] = "form-control";
        $this->revisi_akun_oleh->EditCustomAttributes = "";
        $this->revisi_akun_oleh->EditValue = $this->revisi_akun_oleh->CurrentValue;
        $this->revisi_akun_oleh->PlaceHolder = RemoveHtml($this->revisi_akun_oleh->caption());

        // revisi_rnd_tgl
        $this->revisi_rnd_tgl->EditAttrs["class"] = "form-control";
        $this->revisi_rnd_tgl->EditCustomAttributes = "";
        $this->revisi_rnd_tgl->EditValue = FormatDateTime($this->revisi_rnd_tgl->CurrentValue, 8);
        $this->revisi_rnd_tgl->PlaceHolder = RemoveHtml($this->revisi_rnd_tgl->caption());

        // revisi_rnd_oleh
        $this->revisi_rnd_oleh->EditAttrs["class"] = "form-control";
        $this->revisi_rnd_oleh->EditCustomAttributes = "";
        $this->revisi_rnd_oleh->EditValue = $this->revisi_rnd_oleh->CurrentValue;
        $this->revisi_rnd_oleh->PlaceHolder = RemoveHtml($this->revisi_rnd_oleh->caption());

        // rnd_tgl
        $this->rnd_tgl->EditAttrs["class"] = "form-control";
        $this->rnd_tgl->EditCustomAttributes = "";
        $this->rnd_tgl->EditValue = FormatDateTime($this->rnd_tgl->CurrentValue, 8);
        $this->rnd_tgl->PlaceHolder = RemoveHtml($this->rnd_tgl->caption());

        // rnd_oleh
        $this->rnd_oleh->EditAttrs["class"] = "form-control";
        $this->rnd_oleh->EditCustomAttributes = "";
        $this->rnd_oleh->EditValue = $this->rnd_oleh->CurrentValue;
        $this->rnd_oleh->PlaceHolder = RemoveHtml($this->rnd_oleh->caption());

        // ap_tgl
        $this->ap_tgl->EditAttrs["class"] = "form-control";
        $this->ap_tgl->EditCustomAttributes = "";
        $this->ap_tgl->EditValue = FormatDateTime($this->ap_tgl->CurrentValue, 8);
        $this->ap_tgl->PlaceHolder = RemoveHtml($this->ap_tgl->caption());

        // ap_oleh
        $this->ap_oleh->EditAttrs["class"] = "form-control";
        $this->ap_oleh->EditCustomAttributes = "";
        $this->ap_oleh->EditValue = $this->ap_oleh->CurrentValue;
        $this->ap_oleh->PlaceHolder = RemoveHtml($this->ap_oleh->caption());

        // batal_tgl
        $this->batal_tgl->EditAttrs["class"] = "form-control";
        $this->batal_tgl->EditCustomAttributes = "";
        $this->batal_tgl->EditValue = FormatDateTime($this->batal_tgl->CurrentValue, 8);
        $this->batal_tgl->PlaceHolder = RemoveHtml($this->batal_tgl->caption());

        // batal_oleh
        $this->batal_oleh->EditAttrs["class"] = "form-control";
        $this->batal_oleh->EditCustomAttributes = "";
        $this->batal_oleh->EditValue = $this->batal_oleh->CurrentValue;
        $this->batal_oleh->PlaceHolder = RemoveHtml($this->batal_oleh->caption());

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
                    $doc->exportCaption($this->cpo_jenis);
                    $doc->exportCaption($this->ordernum);
                    $doc->exportCaption($this->order_kode);
                    $doc->exportCaption($this->orderterimatgl);
                    $doc->exportCaption($this->produk_fungsi);
                    $doc->exportCaption($this->produk_kualitas);
                    $doc->exportCaption($this->produk_campaign);
                    $doc->exportCaption($this->kemasan_satuan);
                    $doc->exportCaption($this->ordertgl);
                    $doc->exportCaption($this->custcode);
                    $doc->exportCaption($this->perushnama);
                    $doc->exportCaption($this->perushalamat);
                    $doc->exportCaption($this->perushcp);
                    $doc->exportCaption($this->perushjabatan);
                    $doc->exportCaption($this->perushphone);
                    $doc->exportCaption($this->perushmobile);
                    $doc->exportCaption($this->bencmark);
                    $doc->exportCaption($this->kategoriproduk);
                    $doc->exportCaption($this->jenisproduk);
                    $doc->exportCaption($this->bentuksediaan);
                    $doc->exportCaption($this->sediaan_ukuran);
                    $doc->exportCaption($this->sediaan_ukuran_satuan);
                    $doc->exportCaption($this->produk_viskositas);
                    $doc->exportCaption($this->konsepproduk);
                    $doc->exportCaption($this->fragrance);
                    $doc->exportCaption($this->aroma);
                    $doc->exportCaption($this->bahanaktif);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->produk_warna_jenis);
                    $doc->exportCaption($this->aksesoris);
                    $doc->exportCaption($this->produk_lainlain);
                    $doc->exportCaption($this->statusproduk);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->catatan);
                    $doc->exportCaption($this->rencanakemasan);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->ekspetasiharga);
                    $doc->exportCaption($this->kemasan);
                    $doc->exportCaption($this->volume);
                    $doc->exportCaption($this->jenistutup);
                    $doc->exportCaption($this->catatanpackaging);
                    $doc->exportCaption($this->infopackaging);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->desainprodukkemasan);
                    $doc->exportCaption($this->desaindiinginkan);
                    $doc->exportCaption($this->mereknotifikasi);
                    $doc->exportCaption($this->kategoristatus);
                    $doc->exportCaption($this->kemasan_ukuran_satuan);
                    $doc->exportCaption($this->notifikasicatatan);
                    $doc->exportCaption($this->label_ukuran);
                    $doc->exportCaption($this->infolabel);
                    $doc->exportCaption($this->labelkualitas);
                    $doc->exportCaption($this->labelposisi);
                    $doc->exportCaption($this->labelcatatan);
                    $doc->exportCaption($this->dibuatdi);
                    $doc->exportCaption($this->tanggal);
                    $doc->exportCaption($this->penerima);
                    $doc->exportCaption($this->createat);
                    $doc->exportCaption($this->createby);
                    $doc->exportCaption($this->statusdokumen);
                    $doc->exportCaption($this->update_at);
                    $doc->exportCaption($this->status_data);
                    $doc->exportCaption($this->harga_rnd);
                    $doc->exportCaption($this->aplikasi_sediaan);
                    $doc->exportCaption($this->hu_hrg_isi);
                    $doc->exportCaption($this->hu_hrg_isi_pro);
                    $doc->exportCaption($this->hu_hrg_kms_primer);
                    $doc->exportCaption($this->hu_hrg_kms_primer_pro);
                    $doc->exportCaption($this->hu_hrg_kms_sekunder);
                    $doc->exportCaption($this->hu_hrg_kms_sekunder_pro);
                    $doc->exportCaption($this->hu_hrg_label);
                    $doc->exportCaption($this->hu_hrg_label_pro);
                    $doc->exportCaption($this->hu_hrg_total);
                    $doc->exportCaption($this->hu_hrg_total_pro);
                    $doc->exportCaption($this->hl_hrg_isi);
                    $doc->exportCaption($this->hl_hrg_isi_pro);
                    $doc->exportCaption($this->hl_hrg_kms_primer);
                    $doc->exportCaption($this->hl_hrg_kms_primer_pro);
                    $doc->exportCaption($this->hl_hrg_kms_sekunder);
                    $doc->exportCaption($this->hl_hrg_kms_sekunder_pro);
                    $doc->exportCaption($this->hl_hrg_label);
                    $doc->exportCaption($this->hl_hrg_label_pro);
                    $doc->exportCaption($this->hl_hrg_total);
                    $doc->exportCaption($this->hl_hrg_total_pro);
                    $doc->exportCaption($this->bs_bahan_aktif_tick);
                    $doc->exportCaption($this->bs_bahan_aktif);
                    $doc->exportCaption($this->bs_bahan_lain);
                    $doc->exportCaption($this->bs_parfum);
                    $doc->exportCaption($this->bs_estetika);
                    $doc->exportCaption($this->bs_kms_wadah);
                    $doc->exportCaption($this->bs_kms_tutup);
                    $doc->exportCaption($this->bs_kms_sekunder);
                    $doc->exportCaption($this->bs_label_desain);
                    $doc->exportCaption($this->bs_label_cetak);
                    $doc->exportCaption($this->bs_label_lain);
                    $doc->exportCaption($this->dlv_pickup);
                    $doc->exportCaption($this->dlv_singlepoint);
                    $doc->exportCaption($this->dlv_multipoint);
                    $doc->exportCaption($this->dlv_multipoint_jml);
                    $doc->exportCaption($this->dlv_term_lain);
                    $doc->exportCaption($this->catatan_khusus);
                    $doc->exportCaption($this->aju_tgl);
                    $doc->exportCaption($this->aju_oleh);
                    $doc->exportCaption($this->proses_tgl);
                    $doc->exportCaption($this->proses_oleh);
                    $doc->exportCaption($this->revisi_tgl);
                    $doc->exportCaption($this->revisi_oleh);
                    $doc->exportCaption($this->revisi_akun_tgl);
                    $doc->exportCaption($this->revisi_akun_oleh);
                    $doc->exportCaption($this->revisi_rnd_tgl);
                    $doc->exportCaption($this->revisi_rnd_oleh);
                    $doc->exportCaption($this->rnd_tgl);
                    $doc->exportCaption($this->rnd_oleh);
                    $doc->exportCaption($this->ap_tgl);
                    $doc->exportCaption($this->ap_oleh);
                    $doc->exportCaption($this->batal_tgl);
                    $doc->exportCaption($this->batal_oleh);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->cpo_jenis);
                    $doc->exportCaption($this->ordernum);
                    $doc->exportCaption($this->order_kode);
                    $doc->exportCaption($this->orderterimatgl);
                    $doc->exportCaption($this->produk_fungsi);
                    $doc->exportCaption($this->produk_kualitas);
                    $doc->exportCaption($this->produk_campaign);
                    $doc->exportCaption($this->kemasan_satuan);
                    $doc->exportCaption($this->ordertgl);
                    $doc->exportCaption($this->custcode);
                    $doc->exportCaption($this->perushnama);
                    $doc->exportCaption($this->perushalamat);
                    $doc->exportCaption($this->perushcp);
                    $doc->exportCaption($this->perushjabatan);
                    $doc->exportCaption($this->perushphone);
                    $doc->exportCaption($this->perushmobile);
                    $doc->exportCaption($this->bencmark);
                    $doc->exportCaption($this->kategoriproduk);
                    $doc->exportCaption($this->jenisproduk);
                    $doc->exportCaption($this->bentuksediaan);
                    $doc->exportCaption($this->sediaan_ukuran);
                    $doc->exportCaption($this->sediaan_ukuran_satuan);
                    $doc->exportCaption($this->produk_viskositas);
                    $doc->exportCaption($this->konsepproduk);
                    $doc->exportCaption($this->fragrance);
                    $doc->exportCaption($this->aroma);
                    $doc->exportCaption($this->bahanaktif);
                    $doc->exportCaption($this->warna);
                    $doc->exportCaption($this->produk_warna_jenis);
                    $doc->exportCaption($this->aksesoris);
                    $doc->exportCaption($this->statusproduk);
                    $doc->exportCaption($this->parfum);
                    $doc->exportCaption($this->catatan);
                    $doc->exportCaption($this->rencanakemasan);
                    $doc->exportCaption($this->ekspetasiharga);
                    $doc->exportCaption($this->kemasan);
                    $doc->exportCaption($this->volume);
                    $doc->exportCaption($this->jenistutup);
                    $doc->exportCaption($this->infopackaging);
                    $doc->exportCaption($this->ukuran);
                    $doc->exportCaption($this->desainprodukkemasan);
                    $doc->exportCaption($this->desaindiinginkan);
                    $doc->exportCaption($this->mereknotifikasi);
                    $doc->exportCaption($this->kategoristatus);
                    $doc->exportCaption($this->kemasan_ukuran_satuan);
                    $doc->exportCaption($this->infolabel);
                    $doc->exportCaption($this->labelkualitas);
                    $doc->exportCaption($this->labelposisi);
                    $doc->exportCaption($this->dibuatdi);
                    $doc->exportCaption($this->tanggal);
                    $doc->exportCaption($this->penerima);
                    $doc->exportCaption($this->createat);
                    $doc->exportCaption($this->createby);
                    $doc->exportCaption($this->statusdokumen);
                    $doc->exportCaption($this->update_at);
                    $doc->exportCaption($this->status_data);
                    $doc->exportCaption($this->harga_rnd);
                    $doc->exportCaption($this->aplikasi_sediaan);
                    $doc->exportCaption($this->hu_hrg_isi);
                    $doc->exportCaption($this->hu_hrg_isi_pro);
                    $doc->exportCaption($this->hu_hrg_kms_primer);
                    $doc->exportCaption($this->hu_hrg_kms_primer_pro);
                    $doc->exportCaption($this->hu_hrg_kms_sekunder);
                    $doc->exportCaption($this->hu_hrg_kms_sekunder_pro);
                    $doc->exportCaption($this->hu_hrg_label);
                    $doc->exportCaption($this->hu_hrg_label_pro);
                    $doc->exportCaption($this->hu_hrg_total);
                    $doc->exportCaption($this->hu_hrg_total_pro);
                    $doc->exportCaption($this->hl_hrg_isi);
                    $doc->exportCaption($this->hl_hrg_isi_pro);
                    $doc->exportCaption($this->hl_hrg_kms_primer);
                    $doc->exportCaption($this->hl_hrg_kms_primer_pro);
                    $doc->exportCaption($this->hl_hrg_kms_sekunder);
                    $doc->exportCaption($this->hl_hrg_kms_sekunder_pro);
                    $doc->exportCaption($this->hl_hrg_label);
                    $doc->exportCaption($this->hl_hrg_label_pro);
                    $doc->exportCaption($this->hl_hrg_total);
                    $doc->exportCaption($this->hl_hrg_total_pro);
                    $doc->exportCaption($this->bs_bahan_aktif_tick);
                    $doc->exportCaption($this->aju_tgl);
                    $doc->exportCaption($this->aju_oleh);
                    $doc->exportCaption($this->proses_tgl);
                    $doc->exportCaption($this->proses_oleh);
                    $doc->exportCaption($this->revisi_tgl);
                    $doc->exportCaption($this->revisi_oleh);
                    $doc->exportCaption($this->revisi_akun_tgl);
                    $doc->exportCaption($this->revisi_akun_oleh);
                    $doc->exportCaption($this->revisi_rnd_tgl);
                    $doc->exportCaption($this->revisi_rnd_oleh);
                    $doc->exportCaption($this->rnd_tgl);
                    $doc->exportCaption($this->rnd_oleh);
                    $doc->exportCaption($this->ap_tgl);
                    $doc->exportCaption($this->ap_oleh);
                    $doc->exportCaption($this->batal_tgl);
                    $doc->exportCaption($this->batal_oleh);
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
                        $doc->exportField($this->cpo_jenis);
                        $doc->exportField($this->ordernum);
                        $doc->exportField($this->order_kode);
                        $doc->exportField($this->orderterimatgl);
                        $doc->exportField($this->produk_fungsi);
                        $doc->exportField($this->produk_kualitas);
                        $doc->exportField($this->produk_campaign);
                        $doc->exportField($this->kemasan_satuan);
                        $doc->exportField($this->ordertgl);
                        $doc->exportField($this->custcode);
                        $doc->exportField($this->perushnama);
                        $doc->exportField($this->perushalamat);
                        $doc->exportField($this->perushcp);
                        $doc->exportField($this->perushjabatan);
                        $doc->exportField($this->perushphone);
                        $doc->exportField($this->perushmobile);
                        $doc->exportField($this->bencmark);
                        $doc->exportField($this->kategoriproduk);
                        $doc->exportField($this->jenisproduk);
                        $doc->exportField($this->bentuksediaan);
                        $doc->exportField($this->sediaan_ukuran);
                        $doc->exportField($this->sediaan_ukuran_satuan);
                        $doc->exportField($this->produk_viskositas);
                        $doc->exportField($this->konsepproduk);
                        $doc->exportField($this->fragrance);
                        $doc->exportField($this->aroma);
                        $doc->exportField($this->bahanaktif);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->produk_warna_jenis);
                        $doc->exportField($this->aksesoris);
                        $doc->exportField($this->produk_lainlain);
                        $doc->exportField($this->statusproduk);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->catatan);
                        $doc->exportField($this->rencanakemasan);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->ekspetasiharga);
                        $doc->exportField($this->kemasan);
                        $doc->exportField($this->volume);
                        $doc->exportField($this->jenistutup);
                        $doc->exportField($this->catatanpackaging);
                        $doc->exportField($this->infopackaging);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->desainprodukkemasan);
                        $doc->exportField($this->desaindiinginkan);
                        $doc->exportField($this->mereknotifikasi);
                        $doc->exportField($this->kategoristatus);
                        $doc->exportField($this->kemasan_ukuran_satuan);
                        $doc->exportField($this->notifikasicatatan);
                        $doc->exportField($this->label_ukuran);
                        $doc->exportField($this->infolabel);
                        $doc->exportField($this->labelkualitas);
                        $doc->exportField($this->labelposisi);
                        $doc->exportField($this->labelcatatan);
                        $doc->exportField($this->dibuatdi);
                        $doc->exportField($this->tanggal);
                        $doc->exportField($this->penerima);
                        $doc->exportField($this->createat);
                        $doc->exportField($this->createby);
                        $doc->exportField($this->statusdokumen);
                        $doc->exportField($this->update_at);
                        $doc->exportField($this->status_data);
                        $doc->exportField($this->harga_rnd);
                        $doc->exportField($this->aplikasi_sediaan);
                        $doc->exportField($this->hu_hrg_isi);
                        $doc->exportField($this->hu_hrg_isi_pro);
                        $doc->exportField($this->hu_hrg_kms_primer);
                        $doc->exportField($this->hu_hrg_kms_primer_pro);
                        $doc->exportField($this->hu_hrg_kms_sekunder);
                        $doc->exportField($this->hu_hrg_kms_sekunder_pro);
                        $doc->exportField($this->hu_hrg_label);
                        $doc->exportField($this->hu_hrg_label_pro);
                        $doc->exportField($this->hu_hrg_total);
                        $doc->exportField($this->hu_hrg_total_pro);
                        $doc->exportField($this->hl_hrg_isi);
                        $doc->exportField($this->hl_hrg_isi_pro);
                        $doc->exportField($this->hl_hrg_kms_primer);
                        $doc->exportField($this->hl_hrg_kms_primer_pro);
                        $doc->exportField($this->hl_hrg_kms_sekunder);
                        $doc->exportField($this->hl_hrg_kms_sekunder_pro);
                        $doc->exportField($this->hl_hrg_label);
                        $doc->exportField($this->hl_hrg_label_pro);
                        $doc->exportField($this->hl_hrg_total);
                        $doc->exportField($this->hl_hrg_total_pro);
                        $doc->exportField($this->bs_bahan_aktif_tick);
                        $doc->exportField($this->bs_bahan_aktif);
                        $doc->exportField($this->bs_bahan_lain);
                        $doc->exportField($this->bs_parfum);
                        $doc->exportField($this->bs_estetika);
                        $doc->exportField($this->bs_kms_wadah);
                        $doc->exportField($this->bs_kms_tutup);
                        $doc->exportField($this->bs_kms_sekunder);
                        $doc->exportField($this->bs_label_desain);
                        $doc->exportField($this->bs_label_cetak);
                        $doc->exportField($this->bs_label_lain);
                        $doc->exportField($this->dlv_pickup);
                        $doc->exportField($this->dlv_singlepoint);
                        $doc->exportField($this->dlv_multipoint);
                        $doc->exportField($this->dlv_multipoint_jml);
                        $doc->exportField($this->dlv_term_lain);
                        $doc->exportField($this->catatan_khusus);
                        $doc->exportField($this->aju_tgl);
                        $doc->exportField($this->aju_oleh);
                        $doc->exportField($this->proses_tgl);
                        $doc->exportField($this->proses_oleh);
                        $doc->exportField($this->revisi_tgl);
                        $doc->exportField($this->revisi_oleh);
                        $doc->exportField($this->revisi_akun_tgl);
                        $doc->exportField($this->revisi_akun_oleh);
                        $doc->exportField($this->revisi_rnd_tgl);
                        $doc->exportField($this->revisi_rnd_oleh);
                        $doc->exportField($this->rnd_tgl);
                        $doc->exportField($this->rnd_oleh);
                        $doc->exportField($this->ap_tgl);
                        $doc->exportField($this->ap_oleh);
                        $doc->exportField($this->batal_tgl);
                        $doc->exportField($this->batal_oleh);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->cpo_jenis);
                        $doc->exportField($this->ordernum);
                        $doc->exportField($this->order_kode);
                        $doc->exportField($this->orderterimatgl);
                        $doc->exportField($this->produk_fungsi);
                        $doc->exportField($this->produk_kualitas);
                        $doc->exportField($this->produk_campaign);
                        $doc->exportField($this->kemasan_satuan);
                        $doc->exportField($this->ordertgl);
                        $doc->exportField($this->custcode);
                        $doc->exportField($this->perushnama);
                        $doc->exportField($this->perushalamat);
                        $doc->exportField($this->perushcp);
                        $doc->exportField($this->perushjabatan);
                        $doc->exportField($this->perushphone);
                        $doc->exportField($this->perushmobile);
                        $doc->exportField($this->bencmark);
                        $doc->exportField($this->kategoriproduk);
                        $doc->exportField($this->jenisproduk);
                        $doc->exportField($this->bentuksediaan);
                        $doc->exportField($this->sediaan_ukuran);
                        $doc->exportField($this->sediaan_ukuran_satuan);
                        $doc->exportField($this->produk_viskositas);
                        $doc->exportField($this->konsepproduk);
                        $doc->exportField($this->fragrance);
                        $doc->exportField($this->aroma);
                        $doc->exportField($this->bahanaktif);
                        $doc->exportField($this->warna);
                        $doc->exportField($this->produk_warna_jenis);
                        $doc->exportField($this->aksesoris);
                        $doc->exportField($this->statusproduk);
                        $doc->exportField($this->parfum);
                        $doc->exportField($this->catatan);
                        $doc->exportField($this->rencanakemasan);
                        $doc->exportField($this->ekspetasiharga);
                        $doc->exportField($this->kemasan);
                        $doc->exportField($this->volume);
                        $doc->exportField($this->jenistutup);
                        $doc->exportField($this->infopackaging);
                        $doc->exportField($this->ukuran);
                        $doc->exportField($this->desainprodukkemasan);
                        $doc->exportField($this->desaindiinginkan);
                        $doc->exportField($this->mereknotifikasi);
                        $doc->exportField($this->kategoristatus);
                        $doc->exportField($this->kemasan_ukuran_satuan);
                        $doc->exportField($this->infolabel);
                        $doc->exportField($this->labelkualitas);
                        $doc->exportField($this->labelposisi);
                        $doc->exportField($this->dibuatdi);
                        $doc->exportField($this->tanggal);
                        $doc->exportField($this->penerima);
                        $doc->exportField($this->createat);
                        $doc->exportField($this->createby);
                        $doc->exportField($this->statusdokumen);
                        $doc->exportField($this->update_at);
                        $doc->exportField($this->status_data);
                        $doc->exportField($this->harga_rnd);
                        $doc->exportField($this->aplikasi_sediaan);
                        $doc->exportField($this->hu_hrg_isi);
                        $doc->exportField($this->hu_hrg_isi_pro);
                        $doc->exportField($this->hu_hrg_kms_primer);
                        $doc->exportField($this->hu_hrg_kms_primer_pro);
                        $doc->exportField($this->hu_hrg_kms_sekunder);
                        $doc->exportField($this->hu_hrg_kms_sekunder_pro);
                        $doc->exportField($this->hu_hrg_label);
                        $doc->exportField($this->hu_hrg_label_pro);
                        $doc->exportField($this->hu_hrg_total);
                        $doc->exportField($this->hu_hrg_total_pro);
                        $doc->exportField($this->hl_hrg_isi);
                        $doc->exportField($this->hl_hrg_isi_pro);
                        $doc->exportField($this->hl_hrg_kms_primer);
                        $doc->exportField($this->hl_hrg_kms_primer_pro);
                        $doc->exportField($this->hl_hrg_kms_sekunder);
                        $doc->exportField($this->hl_hrg_kms_sekunder_pro);
                        $doc->exportField($this->hl_hrg_label);
                        $doc->exportField($this->hl_hrg_label_pro);
                        $doc->exportField($this->hl_hrg_total);
                        $doc->exportField($this->hl_hrg_total_pro);
                        $doc->exportField($this->bs_bahan_aktif_tick);
                        $doc->exportField($this->aju_tgl);
                        $doc->exportField($this->aju_oleh);
                        $doc->exportField($this->proses_tgl);
                        $doc->exportField($this->proses_oleh);
                        $doc->exportField($this->revisi_tgl);
                        $doc->exportField($this->revisi_oleh);
                        $doc->exportField($this->revisi_akun_tgl);
                        $doc->exportField($this->revisi_akun_oleh);
                        $doc->exportField($this->revisi_rnd_tgl);
                        $doc->exportField($this->revisi_rnd_oleh);
                        $doc->exportField($this->rnd_tgl);
                        $doc->exportField($this->rnd_oleh);
                        $doc->exportField($this->ap_tgl);
                        $doc->exportField($this->ap_oleh);
                        $doc->exportField($this->batal_tgl);
                        $doc->exportField($this->batal_oleh);
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
