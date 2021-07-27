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
$sideMenu->addMenuItem(473, "mi_dashboard2", $MenuLanguage->MenuPhrase("473", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php'), false, false, "fa-tachometer-alt", "", false);
$sideMenu->addMenuItem(15, "mi_pegawai", $MenuLanguage->MenuPhrase("15", "MenuText"), $MenuRelativePath . "PegawaiList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pegawai'), false, false, "fa-id-card-alt", "", false);
$sideMenu->addMenuItem(8, "mi_customer", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "CustomerList?cmd=resetall", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}customer'), false, false, "fa-users", "", false);
$sideMenu->addMenuItem(100, "mi_brand", $MenuLanguage->MenuPhrase("100", "MenuText"), $MenuRelativePath . "BrandList?cmd=resetall", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand'), false, false, "fa-bookmark", "", false);
$sideMenu->addMenuItem(9, "mi_product", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "ProductList?cmd=resetall", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}product'), false, false, "fa-cubes", "", false);
$sideMenu->addMenuItem(347, "mi_npd", $MenuLanguage->MenuPhrase("347", "MenuText"), $MenuRelativePath . "NpdList", -1, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd'), false, false, "fa-dice", "", false);
$sideMenu->addMenuItem(304, "mci_Perizinan_Produk", $MenuLanguage->MenuPhrase("304", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-copyright", "", false);
$sideMenu->addMenuItem(307, "mi_titipmerk_validasi", $MenuLanguage->MenuPhrase("307", "MenuText"), $MenuRelativePath . "TitipmerkValidasiList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}titipmerk_validasi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(283, "mi_ijinhaki", $MenuLanguage->MenuPhrase("283", "MenuText"), $MenuRelativePath . "IjinhakiList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(306, "mi_ijinbpom", $MenuLanguage->MenuPhrase("306", "MenuText"), $MenuRelativePath . "IjinbpomList", 304, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(50, "mci_Penjualan", $MenuLanguage->MenuPhrase("50", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-shopping-cart", "", false);
$sideMenu->addMenuItem(318, "mi_order", $MenuLanguage->MenuPhrase("318", "MenuText"), $MenuRelativePath . "OrderList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order'), false, false, "fa-cart-arrow-down", "", false);
$sideMenu->addMenuItem(321, "mi_deliveryorder", $MenuLanguage->MenuPhrase("321", "MenuText"), $MenuRelativePath . "DeliveryorderList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder'), false, false, "fa-truck-loading", "", false);
$sideMenu->addMenuItem(326, "mi_invoice", $MenuLanguage->MenuPhrase("326", "MenuText"), $MenuRelativePath . "InvoiceList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice'), false, false, "fa-file-invoice", "", false);
$sideMenu->addMenuItem(330, "mi_suratjalan", $MenuLanguage->MenuPhrase("330", "MenuText"), $MenuRelativePath . "SuratjalanList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan'), false, false, "fa-truck-moving", "", false);
$sideMenu->addMenuItem(334, "mi_pembayaran", $MenuLanguage->MenuPhrase("334", "MenuText"), $MenuRelativePath . "PembayaranList", 50, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pembayaran'), false, false, "fa-receipt", "", false);
$sideMenu->addMenuItem(49, "mci_Akuntansi", $MenuLanguage->MenuPhrase("49", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-calculator", "", false);
$sideMenu->addMenuItem(348, "mi_v_bonuscustomer", $MenuLanguage->MenuPhrase("348", "MenuText"), $MenuRelativePath . "VBonuscustomerList", 49, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer'), false, false, "fa-circle", "", false);
$sideMenu->addMenuItem(346, "mi_v_piutang", $MenuLanguage->MenuPhrase("346", "MenuText"), $MenuRelativePath . "VPiutangList", 49, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang'), false, false, "fa-circle", "", false);
$sideMenu->addMenuItem(547, "mci_Laporan", $MenuLanguage->MenuPhrase("547", "MenuText"), "", -1, "", true, false, true, "fa-file-archive", "", false);
$sideMenu->addMenuItem(478, "mi_laporansales", $MenuLanguage->MenuPhrase("478", "MenuText"), $MenuRelativePath . "Laporansales", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporansales.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(583, "mi_laporan_purchase_order", $MenuLanguage->MenuPhrase("583", "MenuText"), $MenuRelativePath . "LaporanPurchaseOrder", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_purchase_order.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(584, "mi_laporan_delivery_order", $MenuLanguage->MenuPhrase("584", "MenuText"), $MenuRelativePath . "LaporanDeliveryOrder", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_delivery_order.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(585, "mi_laporan_invoice", $MenuLanguage->MenuPhrase("585", "MenuText"), $MenuRelativePath . "LaporanInvoice", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_invoice.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(586, "mi_laporan_surat_jalan", $MenuLanguage->MenuPhrase("586", "MenuText"), $MenuRelativePath . "LaporanSuratJalan", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_surat_jalan.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(587, "mi_laporan_pembayaran", $MenuLanguage->MenuPhrase("587", "MenuText"), $MenuRelativePath . "LaporanPembayaran", 547, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_pembayaran.php'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(567, "mci_Stok", $MenuLanguage->MenuPhrase("567", "MenuText"), "", -1, "", true, false, true, "fa-database", "", false);
$sideMenu->addMenuItem(342, "mi_stock", $MenuLanguage->MenuPhrase("342", "MenuText"), $MenuRelativePath . "StockList", 567, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(344, "mi_v_stock", $MenuLanguage->MenuPhrase("344", "MenuText"), $MenuRelativePath . "VStockList", 567, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(570, "mci_Pengaturan", $MenuLanguage->MenuPhrase("570", "MenuText"), "", -1, "", true, false, true, "fa-users-cog", "", false);
$sideMenu->addMenuItem(31, "mi_userlevels", $MenuLanguage->MenuPhrase("31", "MenuText"), $MenuRelativePath . "UserlevelsList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevels'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(588, "mi_approval_po", $MenuLanguage->MenuPhrase("588", "MenuText"), $MenuRelativePath . "ApprovalPoList", 570, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}approval_po'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(403, "mci_Referensi", $MenuLanguage->MenuPhrase("403", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-book-open", "", false);
$sideMenu->addMenuItem(325, "mi_ekspedisi", $MenuLanguage->MenuPhrase("325", "MenuText"), $MenuRelativePath . "EkspedisiList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ekspedisi'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(101, "mi_tipepayment", $MenuLanguage->MenuPhrase("101", "MenuText"), $MenuRelativePath . "TipepaymentList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(102, "mi_termpayment", $MenuLanguage->MenuPhrase("102", "MenuText"), $MenuRelativePath . "TermpaymentList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(10, "mi_jenisbarang", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "JenisbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(11, "mi_kategoribarang", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "KategoribarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang'), false, false, "ffar a-circle", "", false);
$sideMenu->addMenuItem(113, "mi_kualitasbarang", $MenuLanguage->MenuPhrase("113", "MenuText"), $MenuRelativePath . "KualitasbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(314, "mi_kemasanbarang", $MenuLanguage->MenuPhrase("314", "MenuText"), $MenuRelativePath . "KemasanbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(472, "mi_viskositasbarang", $MenuLanguage->MenuPhrase("472", "MenuText"), $MenuRelativePath . "ViskositasbarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(471, "mi_aplikasibarang", $MenuLanguage->MenuPhrase("471", "MenuText"), $MenuRelativePath . "AplikasibarangList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(32, "mi_tipecustomer", $MenuLanguage->MenuPhrase("32", "MenuText"), $MenuRelativePath . "TipecustomerList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipecustomer'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(12, "mi_satuan", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "SatuanList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan'), false, false, "far fa-circle", "", false);
$sideMenu->addMenuItem(193, "mi_rekening", $MenuLanguage->MenuPhrase("193", "MenuText"), $MenuRelativePath . "RekeningList", 403, "", AllowListMenu('{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}rekening'), false, false, "far fa-circle", "", false);
echo $sideMenu->toScript();
