<?php

namespace PHPMaker2021\production2;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "pegawai" => \DI\create(Pegawai::class),
    "userlevels" => \DI\create(Userlevels::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "provinsi" => \DI\create(Provinsi::class),
    "kabupaten" => \DI\create(Kabupaten::class),
    "kecamatan" => \DI\create(Kecamatan::class),
    "kelurahan" => \DI\create(Kelurahan::class),
    "ekspedisi" => \DI\create(Ekspedisi::class),
    "customer" => \DI\create(Customer::class),
    "alamat_customer" => \DI\create(AlamatCustomer::class),
    "tipecustomer" => \DI\create(Tipecustomer::class),
    "brand" => \DI\create(Brand::class),
    "brand_customer" => \DI\create(BrandCustomer::class),
    "product" => \DI\create(Product::class),
    "kategoriproduk" => \DI\create(Kategoriproduk::class),
    "jenisproduk" => \DI\create(Jenisproduk::class),
    "satuan" => \DI\create(Satuan::class),
    "tipepayment" => \DI\create(Tipepayment::class),
    "npd" => \DI\create(Npd::class),
    "npd_serahterima" => \DI\create(NpdSerahterima::class),
    "npd_sample" => \DI\create(NpdSample::class),
    "npd_review" => \DI\create(NpdReview::class),
    "npd_confirmsample" => \DI\create(NpdConfirmsample::class),
    "npd_harga" => \DI\create(NpdHarga::class),
    "ijinhaki" => \DI\create(Ijinhaki::class),
    "v_orderdetail" => \DI\create(VOrderdetail::class),
    "v_stock" => \DI\create(VStock::class),
    "print_invoice" => \DI\create(PrintInvoice::class),
    "v_piutang" => \DI\create(VPiutang::class),
    "ijinhaki_status" => \DI\create(IjinhakiStatus::class),
    "v_bonuscustomer" => \DI\create(VBonuscustomer::class),
    "ijinbpom" => \DI\create(Ijinbpom::class),
    "ijinbpom_detail" => \DI\create(IjinbpomDetail::class),
    "print_suratjalan" => \DI\create(PrintSuratjalan::class),
    "ijinbpom_status" => \DI\create(IjinbpomStatus::class),
    "npd_desain" => \DI\create(NpdDesain::class),
    "npd_confirmdesign" => \DI\create(NpdConfirmdesign::class),
    "npd_confirmdummy" => \DI\create(NpdConfirmdummy::class),
    "npd_confirmprint" => \DI\create(NpdConfirmprint::class),
    "dashboard2" => \DI\create(Dashboard2::class),
    "Jatuh_Tempo" => \DI\create(JatuhTempo::class),
    "Crosstab1" => \DI\create(Crosstab1::class),
    "v_bonuscustomer_detail" => \DI\create(VBonuscustomerDetail::class),
    "laporansales" => \DI\create(Laporansales::class),
    "v_npd_customer" => \DI\create(VNpdCustomer::class),
    "v_order_customer" => \DI\create(VOrderCustomer::class),
    "laporan_delivery_order" => \DI\create(LaporanDeliveryOrder::class),
    "laporan_invoice" => \DI\create(LaporanInvoice::class),
    "laporan_surat_jalan" => \DI\create(LaporanSuratJalan::class),
    "laporan_pembayaran" => \DI\create(LaporanPembayaran::class),
    "npd_masterdata" => \DI\create(NpdMasterdata::class),
    "v_do_stock" => \DI\create(VDoStock::class),
    "npd_status" => \DI\create(NpdStatus::class),
    "titipmerk_validasi" => \DI\create(TitipmerkValidasi::class),
    "laporan_kpi_marketing" => \DI\create(LaporanKpiMarketing::class),
    "laporan_kpi_marketing_detail" => \DI\create(LaporanKpiMarketingDetail::class),
    "order" => \DI\create(Order::class),
    "d_jatuhtempo" => \DI\create(DJatuhtempo::class),
    "v_piutang_detail" => \DI\create(VPiutangDetail::class),
    "order_detail" => \DI\create(OrderDetail::class),
    "deliveryorder" => \DI\create(Deliveryorder::class),
    "laporan_order_customer" => \DI\create(LaporanOrderCustomer::class),
    "penagihan_customer" => \DI\create(PenagihanCustomer::class),
    "deliveryorder_detail" => \DI\create(DeliveryorderDetail::class),
    "invoice" => \DI\create(Invoice::class),
    "invoice_detail" => \DI\create(InvoiceDetail::class),
    "v_brand_customer" => \DI\create(VBrandCustomer::class),
    "suratjalan" => \DI\create(Suratjalan::class),
    "suratjalan_detail" => \DI\create(SuratjalanDetail::class),
    "pembayaran" => \DI\create(Pembayaran::class),
    "redeembonus" => \DI\create(Redeembonus::class),
    "stock" => \DI\create(Stock::class),
    "v_kartu_stok" => \DI\create(VKartuStok::class),
    "v_stockorder_detail" => \DI\create(VStockorderDetail::class),
    "npd_aplikasi_sediaan" => \DI\create(NpdAplikasiSediaan::class),
    "npd_bentuk_sediaan" => \DI\create(NpdBentukSediaan::class),
    "npd_estetika_sediaan" => \DI\create(NpdEstetikaSediaan::class),
    "po_limit_approval" => \DI\create(PoLimitApproval::class),
    "npd_kemasan_tutup" => \DI\create(NpdKemasanTutup::class),
    "npd_kemasan_wadah" => \DI\create(NpdKemasanWadah::class),
    "npd_labelsticker_bahan" => \DI\create(NpdLabelstickerBahan::class),
    "npd_labelsticker_posisi" => \DI\create(NpdLabelstickerPosisi::class),
    "po_limit_approval_detail" => \DI\create(PoLimitApprovalDetail::class),
    "kpi_marketing" => \DI\create(KpiMarketing::class),
    "level_customer" => \DI\create(LevelCustomer::class),
    "npd_labelsticker_kualitas" => \DI\create(NpdLabelstickerKualitas::class),
    "npd_parfum_sediaan" => \DI\create(NpdParfumSediaan::class),
    "npd_viskositas_sediaan" => \DI\create(NpdViskositasSediaan::class),
    "pengembangan_produk" => \DI\create(PengembanganProduk::class),
    "bot_history" => \DI\create(BotHistory::class),
    "termpayment" => \DI\create(Termpayment::class),
    "penagihan" => \DI\create(Penagihan::class),
    "stocks" => \DI\create(Stocks::class),
    "stock_order" => \DI\create(StockOrder::class),
    "antrian_bot" => \DI\create(AntrianBot::class),
    "stock_order_detail" => \DI\create(StockOrderDetail::class),
    "brandcustomer_edit2" => \DI\create(BrandcustomerEdit2::class),
    "brandcustomer_delete2" => \DI\create(BrandcustomerDelete2::class),
    "npd_warna_sediaan" => \DI\create(NpdWarnaSediaan::class),
    "npd_kemasan_bahan" => \DI\create(NpdKemasanBahan::class),
    "npd_kemasan_bentuk" => \DI\create(NpdKemasanBentuk::class),
    "npd_kemasan_komposisi" => \DI\create(NpdKemasanKomposisi::class),
    "npd_labelhot_sisiprint" => \DI\create(NpdLabelhotSisiprint::class),
    "npd_labelhot_tekstur" => \DI\create(NpdLabelhotTekstur::class),
    "product_history" => \DI\create(ProductHistory::class),
    "stock_deliveryorder" => \DI\create(StockDeliveryorder::class),
    "stock_deliveryorder_detail" => \DI\create(StockDeliveryorderDetail::class),
    "tipe_sla" => \DI\create(TipeSla::class),
    "npd_resume" => \DI\create(NpdResume::class),
    "npd_label_jenis" => \DI\create(NpdLabelJenis::class),
    "npd_label_kualitas" => \DI\create(NpdLabelKualitas::class),
    "v_stockorder" => \DI\create(VStockorder::class),

    // User table
    "usertable" => \DI\get("pegawai"),
];
