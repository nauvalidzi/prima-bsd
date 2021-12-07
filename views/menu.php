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
$sideMenu->addMenuItem(8, "mi_customer", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "CustomerList?cmd=resetall", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}customer'), false, false, "fa-users", "", false);
$sideMenu->addMenuItem(100, "mi_brand", $MenuLanguage->MenuPhrase("100", "MenuText"), $MenuRelativePath . "BrandList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand'), false, false, "fa-bookmark", "", false);
$sideMenu->addMenuItem(9, "mi_product", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "ProductList?cmd=resetall", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}product'), false, false, "fa-cubes", "", false);
$sideMenu->addMenuItem(347, "mi_npd", $MenuLanguage->MenuPhrase("347", "MenuText"), $MenuRelativePath . "NpdList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd'), false, false, "fa-dice", "", false);
$sideMenu->addMenuItem(304, "mci_Perizinan_Produk", $MenuLanguage->MenuPhrase("304", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-copyright", "", false);
$sideMenu->addMenuItem(307, "mi_titipmerk_validasi", $MenuLanguage->MenuPhrase("307", "MenuText"), $MenuRelativePath . "TitipmerkValidasiList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}titipmerk_validasi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(283, "mi_ijinhaki", $MenuLanguage->MenuPhrase("283", "MenuText"), $MenuRelativePath . "IjinhakiList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(306, "mi_ijinbpom", $MenuLanguage->MenuPhrase("306", "MenuText"), $MenuRelativePath . "IjinbpomList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(50, "mci_Penjualan", $MenuLanguage->MenuPhrase("50", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-shopping-cart", "", false);
$sideMenu->addMenuItem(318, "mi_order", $MenuLanguage->MenuPhrase("318", "MenuText"), $MenuRelativePath . "OrderList?cmd=resetall", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order'), false, false, "fa-cart-arrow-down", "", false);
$sideMenu->addMenuItem(588, "mi_po_limit_approval", $MenuLanguage->MenuPhrase("588", "MenuText"), $MenuRelativePath . "PoLimitApprovalList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval'), false, false, "fas fa-key", "", false);
$sideMenu->addMenuItem(321, "mi_deliveryorder", $MenuLanguage->MenuPhrase("321", "MenuText"), $MenuRelativePath . "DeliveryorderList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder'), false, false, "fas fa-dolly", "", false);
$sideMenu->addMenuItem(326, "mi_invoice", $MenuLanguage->MenuPhrase("326", "MenuText"), $MenuRelativePath . "InvoiceList?cmd=resetall", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice'), false, false, "fa-file-invoice", "", false);
$sideMenu->addMenuItem(330, "mi_suratjalan", $MenuLanguage->MenuPhrase("330", "MenuText"), $MenuRelativePath . "SuratjalanList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan'), false, false, "fa-truck-moving", "", false);
$sideMenu->addMenuItem(334, "mi_pembayaran", $MenuLanguage->MenuPhrase("334", "MenuText"), $MenuRelativePath . "PembayaranList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pembayaran'), false, false, "fa-receipt", "", false);
$sideMenu->addMenuItem(49, "mci_Akuntansi", $MenuLanguage->MenuPhrase("49", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-calculator", "", false);
$sideMenu->addMenuItem(348, "mi_v_bonuscustomer", $MenuLanguage->MenuPhrase("348", "MenuText"), $MenuRelativePath . "VBonuscustomerList", 49, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(346, "mi_v_piutang", $MenuLanguage->MenuPhrase("346", "MenuText"), $MenuRelativePath . "VPiutangList", 49, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(547, "mci_Laporan", $MenuLanguage->MenuPhrase("547", "MenuText"), "", -1, "", true, false, true, "fa-file-archive", "", false);
$sideMenu->addMenuItem(478, "mi_laporansales", $MenuLanguage->MenuPhrase("478", "MenuText"), $MenuRelativePath . "Laporansales", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporansales.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(601, "mi_laporan_order_customer", $MenuLanguage->MenuPhrase("601", "MenuText"), $MenuRelativePath . "LaporanOrderCustomer", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_order_customer.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(584, "mi_laporan_delivery_order", $MenuLanguage->MenuPhrase("584", "MenuText"), $MenuRelativePath . "LaporanDeliveryOrder", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_delivery_order.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(585, "mi_laporan_invoice", $MenuLanguage->MenuPhrase("585", "MenuText"), $MenuRelativePath . "LaporanInvoice", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_invoice.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(586, "mi_laporan_surat_jalan", $MenuLanguage->MenuPhrase("586", "MenuText"), $MenuRelativePath . "LaporanSuratJalan", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_surat_jalan.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(587, "mi_laporan_pembayaran", $MenuLanguage->MenuPhrase("587", "MenuText"), $MenuRelativePath . "LaporanPembayaran", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_pembayaran.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(592, "mi_laporan_kpi_marketing", $MenuLanguage->MenuPhrase("592", "MenuText"), $MenuRelativePath . "LaporanKpiMarketing", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(918, "mci_Stocks", $MenuLanguage->MenuPhrase("918", "MenuText"), "", -1, "", true, false, true, "fa-database", "", false);
$sideMenu->addMenuItem(808, "mi_stocks", $MenuLanguage->MenuPhrase("808", "MenuText"), $MenuRelativePath . "StocksList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stocks'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(809, "mi_stock_order", $MenuLanguage->MenuPhrase("809", "MenuText"), $MenuRelativePath . "StockOrderList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(920, "mi_v_stockorder", $MenuLanguage->MenuPhrase("920", "MenuText"), $MenuRelativePath . "VStockorderList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder'), false, false, "", "", false);
$sideMenu->addMenuItem(921, "mi_v_stockorder_detail", $MenuLanguage->MenuPhrase("921", "MenuText"), $MenuRelativePath . "VStockorderDetailList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder_detail'), false, false, "", "", false);
$sideMenu->addMenuItem(811, "mi_stock_deliveryorder", $MenuLanguage->MenuPhrase("811", "MenuText"), $MenuRelativePath . "StockDeliveryorderList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(342, "mi_stock", $MenuLanguage->MenuPhrase("342", "MenuText"), $MenuRelativePath . "StockList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(344, "mi_v_stock", $MenuLanguage->MenuPhrase("344", "MenuText"), $MenuRelativePath . "VStockList", 918, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(602, "mi_penagihan_customer", $MenuLanguage->MenuPhrase("602", "MenuText"), $MenuRelativePath . "PenagihanCustomer", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan_customer.php'), false, false, "fas fa-file-invoice-dollar", "", false);
$sideMenu->addMenuItem(570, "mci_Pengaturan", $MenuLanguage->MenuPhrase("570", "MenuText"), "", -1, "", true, false, true, "fa-users-cog", "", false);
$sideMenu->addMenuItem(598, "mi_bot_history", $MenuLanguage->MenuPhrase("598", "MenuText"), $MenuRelativePath . "BotHistoryList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}bot_history'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(591, "mi_kpi_marketing", $MenuLanguage->MenuPhrase("591", "MenuText"), $MenuRelativePath . "KpiMarketingList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kpi_marketing'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(31, "mi_userlevels", $MenuLanguage->MenuPhrase("31", "MenuText"), $MenuRelativePath . "UserlevelsList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevels'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(600, "mi_termpayment", $MenuLanguage->MenuPhrase("600", "MenuText"), $MenuRelativePath . "TermpaymentList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(594, "mi_level_customer", $MenuLanguage->MenuPhrase("594", "MenuText"), $MenuRelativePath . "LevelCustomerList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}level_customer'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(403, "mci_Referensi", $MenuLanguage->MenuPhrase("403", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-book-open", "", false);
$sideMenu->addMenuItem(325, "mi_ekspedisi", $MenuLanguage->MenuPhrase("325", "MenuText"), $MenuRelativePath . "EkspedisiList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ekspedisi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(101, "mi_tipepayment", $MenuLanguage->MenuPhrase("101", "MenuText"), $MenuRelativePath . "TipepaymentList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(10, "mi_jenisbarang", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "JenisbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(11, "mi_kategoribarang", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "KategoribarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(113, "mi_kualitasbarang", $MenuLanguage->MenuPhrase("113", "MenuText"), $MenuRelativePath . "KualitasbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(314, "mi_kemasanbarang", $MenuLanguage->MenuPhrase("314", "MenuText"), $MenuRelativePath . "KemasanbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(472, "mi_viskositasbarang", $MenuLanguage->MenuPhrase("472", "MenuText"), $MenuRelativePath . "ViskositasbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(471, "mi_aplikasibarang", $MenuLanguage->MenuPhrase("471", "MenuText"), $MenuRelativePath . "AplikasibarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(32, "mi_tipecustomer", $MenuLanguage->MenuPhrase("32", "MenuText"), $MenuRelativePath . "TipecustomerList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipecustomer'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(12, "mi_satuan", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "SatuanList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(193, "mi_rekening", $MenuLanguage->MenuPhrase("193", "MenuText"), $MenuRelativePath . "RekeningList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}rekening'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(803, "mci_NPD_Master_Data", $MenuLanguage->MenuPhrase("803", "MenuText"), "", -1, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(701, "mi_npd_aplikasi_sediaan", $MenuLanguage->MenuPhrase("701", "MenuText"), $MenuRelativePath . "NpdAplikasiSediaanList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_aplikasi_sediaan'), false, false, "", "", false);
$sideMenu->addMenuItem(702, "mi_npd_bentuk_sediaan", $MenuLanguage->MenuPhrase("702", "MenuText"), $MenuRelativePath . "NpdBentukSediaanList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_bentuk_sediaan'), false, false, "", "", false);
$sideMenu->addMenuItem(703, "mi_npd_estetika_sediaan", $MenuLanguage->MenuPhrase("703", "MenuText"), $MenuRelativePath . "NpdEstetikaSediaanList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_estetika_sediaan'), false, false, "", "", false);
$sideMenu->addMenuItem(704, "mi_npd_kemasan_tutup", $MenuLanguage->MenuPhrase("704", "MenuText"), $MenuRelativePath . "NpdKemasanTutupList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_tutup'), false, false, "", "", false);
$sideMenu->addMenuItem(705, "mi_npd_kemasan_wadah", $MenuLanguage->MenuPhrase("705", "MenuText"), $MenuRelativePath . "NpdKemasanWadahList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_wadah'), false, false, "", "", false);
$sideMenu->addMenuItem(706, "mi_npd_label_bahan", $MenuLanguage->MenuPhrase("706", "MenuText"), $MenuRelativePath . "NpdLabelBahanList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_bahan'), false, false, "", "", false);
$sideMenu->addMenuItem(707, "mi_npd_parfum_sediaan", $MenuLanguage->MenuPhrase("707", "MenuText"), $MenuRelativePath . "NpdParfumSediaanList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_parfum_sediaan'), false, false, "", "", false);
$sideMenu->addMenuItem(708, "mi_npd_warna_sediaan", $MenuLanguage->MenuPhrase("708", "MenuText"), $MenuRelativePath . "NpdWarnaSediaanList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_warna_sediaan'), false, false, "", "", false);
$sideMenu->addMenuItem(709, "mi_npd_viskositas_sediaan", $MenuLanguage->MenuPhrase("709", "MenuText"), $MenuRelativePath . "NpdViskositasSediaanList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_viskositas_sediaan'), false, false, "", "", false);
$sideMenu->addMenuItem(710, "mi_npd_label_posisi", $MenuLanguage->MenuPhrase("710", "MenuText"), $MenuRelativePath . "NpdLabelPosisiList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_posisi'), false, false, "", "", false);
$sideMenu->addMenuItem(711, "mi_npd_label_kualitas", $MenuLanguage->MenuPhrase("711", "MenuText"), $MenuRelativePath . "NpdLabelKualitasList", 803, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_kualitas'), false, false, "", "", false);
$sideMenu->addMenuItem(923, "mi_pengembangan_produk", $MenuLanguage->MenuPhrase("923", "MenuText"), $MenuRelativePath . "PengembanganProduk", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pengembangan_produk.php'), false, false, "", "", false);
echo $sideMenu->toScript();
