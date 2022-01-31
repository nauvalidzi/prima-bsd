<?php

namespace PHPMaker2021\distributor;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(473, "mi_dashboard2", $MenuLanguage->MenuPhrase("473", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php'), false, false, "fas fa-home", "", false);
$sideMenu->addMenuItem(15, "mi_pegawai", $MenuLanguage->MenuPhrase("15", "MenuText"), $MenuRelativePath . "PegawaiList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pegawai'), false, false, "fa-id-card-alt", "", false);
$sideMenu->addMenuItem(8, "mi_customer", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "CustomerList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}customer'), false, false, "fa-users", "", false);
$sideMenu->addMenuItem(100, "mi_brand", $MenuLanguage->MenuPhrase("100", "MenuText"), $MenuRelativePath . "BrandList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand'), false, false, "fa-bookmark", "", false);
$sideMenu->addMenuItem(9, "mi_product", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "ProductList?cmd=resetall", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}product'), false, false, "fa-cubes", "", false);
$sideMenu->addMenuItem(469, "mci_Pengembangan_Produk", $MenuLanguage->MenuPhrase("469", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(347, "mi_npd", $MenuLanguage->MenuPhrase("347", "MenuText"), $MenuRelativePath . "NpdList", 469, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd'), false, false, "fa-dice", "", false);
$sideMenu->addMenuItem(805, "mi_npd_serahterima", $MenuLanguage->MenuPhrase("805", "MenuText"), $MenuRelativePath . "NpdSerahterimaList", 469, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_serahterima'), false, false, "", "", false);
$sideMenu->addMenuItem(408, "mi_npd_sample", $MenuLanguage->MenuPhrase("408", "MenuText"), $MenuRelativePath . "NpdSampleList?cmd=resetall", 469, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_sample'), false, false, "", "", false);
$sideMenu->addMenuItem(404, "mi_npd_review", $MenuLanguage->MenuPhrase("404", "MenuText"), $MenuRelativePath . "NpdReviewList?cmd=resetall", 469, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_review'), false, false, "", "", false);
$sideMenu->addMenuItem(470, "mi_npd_confirm", $MenuLanguage->MenuPhrase("470", "MenuText"), $MenuRelativePath . "NpdConfirmList?cmd=resetall", 469, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_confirm'), false, false, "", "", false);
$sideMenu->addMenuItem(409, "mi_serahterima", $MenuLanguage->MenuPhrase("409", "MenuText"), $MenuRelativePath . "SerahterimaList", 469, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}serahterima'), false, false, "", "", false);
$sideMenu->addMenuItem(923, "mi_pengembangan_produk", $MenuLanguage->MenuPhrase("923", "MenuText"), $MenuRelativePath . "PengembanganProduk", 469, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pengembangan_produk.php'), false, false, "fa-dice", "", false);
$sideMenu->addMenuItem(304, "mci_Perizinan_Produk", $MenuLanguage->MenuPhrase("304", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-copyright", "", false);
$sideMenu->addMenuItem(283, "mi_ijinhaki", $MenuLanguage->MenuPhrase("283", "MenuText"), $MenuRelativePath . "IjinhakiList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(306, "mi_ijinbpom", $MenuLanguage->MenuPhrase("306", "MenuText"), $MenuRelativePath . "IjinbpomList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(50, "mci_Penjualan", $MenuLanguage->MenuPhrase("50", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-shopping-cart", "", false);
$sideMenu->addMenuItem(318, "mi_order", $MenuLanguage->MenuPhrase("318", "MenuText"), $MenuRelativePath . "OrderList?cmd=resetall", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order'), false, false, "fa-cart-arrow-down", "", false);
$sideMenu->addMenuItem(588, "mi_po_limit_approval", $MenuLanguage->MenuPhrase("588", "MenuText"), $MenuRelativePath . "PoLimitApprovalList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval'), false, false, "fas fa-key", "", false);
$sideMenu->addMenuItem(321, "mi_deliveryorder", $MenuLanguage->MenuPhrase("321", "MenuText"), $MenuRelativePath . "DeliveryorderList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder'), false, false, "fas fa-dolly", "", false);
$sideMenu->addMenuItem(326, "mi_invoice", $MenuLanguage->MenuPhrase("326", "MenuText"), $MenuRelativePath . "InvoiceList?cmd=resetall", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice'), false, false, "fa-file-invoice", "", false);
$sideMenu->addMenuItem(330, "mi_suratjalan", $MenuLanguage->MenuPhrase("330", "MenuText"), $MenuRelativePath . "SuratjalanList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan'), false, false, "fa-truck-moving", "", false);
$sideMenu->addMenuItem(1057, "mi_pembayaran", $MenuLanguage->MenuPhrase("1057", "MenuText"), $MenuRelativePath . "PembayaranList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pembayaran'), false, false, "fas fa-receipt", "", false);
$sideMenu->addMenuItem(49, "mci_Bonus_&_Piutang", $MenuLanguage->MenuPhrase("49", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-calculator", "", false);
$sideMenu->addMenuItem(348, "mi_v_bonuscustomer", $MenuLanguage->MenuPhrase("348", "MenuText"), $MenuRelativePath . "VBonuscustomerList", 49, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(346, "mi_v_piutang", $MenuLanguage->MenuPhrase("346", "MenuText"), $MenuRelativePath . "VPiutangList", 49, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(547, "mci_Laporan", $MenuLanguage->MenuPhrase("547", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-file-archive", "", false);
$sideMenu->addMenuItem(478, "mi_laporansales", $MenuLanguage->MenuPhrase("478", "MenuText"), $MenuRelativePath . "Laporansales", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporansales.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(601, "mi_laporan_order_customer", $MenuLanguage->MenuPhrase("601", "MenuText"), $MenuRelativePath . "LaporanOrderCustomer", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_order_customer.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(584, "mi_laporan_delivery_order", $MenuLanguage->MenuPhrase("584", "MenuText"), $MenuRelativePath . "LaporanDeliveryOrder", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_delivery_order.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(585, "mi_laporan_invoice", $MenuLanguage->MenuPhrase("585", "MenuText"), $MenuRelativePath . "LaporanInvoice", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_invoice.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(586, "mi_laporan_surat_jalan", $MenuLanguage->MenuPhrase("586", "MenuText"), $MenuRelativePath . "LaporanSuratJalan", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_surat_jalan.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(587, "mi_laporan_pembayaran", $MenuLanguage->MenuPhrase("587", "MenuText"), $MenuRelativePath . "LaporanPembayaran", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_pembayaran.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(592, "mi_laporan_kpi_marketing", $MenuLanguage->MenuPhrase("592", "MenuText"), $MenuRelativePath . "LaporanKpiMarketing", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(918, "mci_Pembelian", $MenuLanguage->MenuPhrase("918", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fas fa-shopping-bag", "", false);
$sideMenu->addMenuItem(809, "mi_stock_order", $MenuLanguage->MenuPhrase("809", "MenuText"), $MenuRelativePath . "StockOrderList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(811, "mi_stock_deliveryorder", $MenuLanguage->MenuPhrase("811", "MenuText"), $MenuRelativePath . "StockDeliveryorderList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(344, "mi_v_stock", $MenuLanguage->MenuPhrase("344", "MenuText"), $MenuRelativePath . "VStockList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock'), false, false, "fa-database", "", false);
$sideMenu->addMenuItem(602, "mi_penagihan_customer", $MenuLanguage->MenuPhrase("602", "MenuText"), $MenuRelativePath . "PenagihanCustomer", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan_customer.php'), false, false, "fas fa-file-invoice-dollar", "", false);
$sideMenu->addMenuItem(570, "mci_Pengaturan", $MenuLanguage->MenuPhrase("570", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-users-cog", "", false);
$sideMenu->addMenuItem(1054, "mi_antrian_bot", $MenuLanguage->MenuPhrase("1054", "MenuText"), $MenuRelativePath . "AntrianBot", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}antrian_bot.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(591, "mi_kpi_marketing", $MenuLanguage->MenuPhrase("591", "MenuText"), $MenuRelativePath . "KpiMarketingList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kpi_marketing'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(31, "mi_userlevels", $MenuLanguage->MenuPhrase("31", "MenuText"), $MenuRelativePath . "UserlevelsList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevels'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(600, "mi_termpayment", $MenuLanguage->MenuPhrase("600", "MenuText"), $MenuRelativePath . "TermpaymentList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(594, "mi_level_customer", $MenuLanguage->MenuPhrase("594", "MenuText"), $MenuRelativePath . "LevelCustomerList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}level_customer'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(403, "mci_Referensi", $MenuLanguage->MenuPhrase("403", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-book-open", "", false);
$sideMenu->addMenuItem(927, "mi_kategoribarang", $MenuLanguage->MenuPhrase("927", "MenuText"), $MenuRelativePath . "KategoribarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(931, "mi_jenisbarang", $MenuLanguage->MenuPhrase("931", "MenuText"), $MenuRelativePath . "JenisbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(926, "mi_aplikasibarang", $MenuLanguage->MenuPhrase("926", "MenuText"), $MenuRelativePath . "AplikasibarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(930, "mi_kemasanbarang", $MenuLanguage->MenuPhrase("930", "MenuText"), $MenuRelativePath . "KemasanbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(928, "mi_kualitasbarang", $MenuLanguage->MenuPhrase("928", "MenuText"), $MenuRelativePath . "KualitasbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(929, "mi_viskositasbarang", $MenuLanguage->MenuPhrase("929", "MenuText"), $MenuRelativePath . "ViskositasbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(32, "mi_tipecustomer", $MenuLanguage->MenuPhrase("32", "MenuText"), $MenuRelativePath . "TipecustomerList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipecustomer'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(101, "mi_tipepayment", $MenuLanguage->MenuPhrase("101", "MenuText"), $MenuRelativePath . "TipepaymentList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(12, "mi_satuan", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "SatuanList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(1053, "mi_tipe_sla", $MenuLanguage->MenuPhrase("1053", "MenuText"), $MenuRelativePath . "TipeSlaList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipe_sla'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(325, "mi_ekspedisi", $MenuLanguage->MenuPhrase("325", "MenuText"), $MenuRelativePath . "EkspedisiList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ekspedisi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(1052, "mci_NPD_Master_Spesifikasi", $MenuLanguage->MenuPhrase("1052", "MenuText"), "", 403, "", IsLoggedIn(), false, true, "far fa-check-square", "", false);
echo $sideMenu->toScript();
