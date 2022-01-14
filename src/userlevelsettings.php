<?php
/**
 * PHPMaker 2021 user level settings
 */
namespace PHPMaker2021\distributor;

// User level info
$USER_LEVELS = [["-2","Anonymous"],
    ["0","Default"],
    ["1","Marketing"]];
// User level priv info
$USER_LEVEL_PRIVS = [["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pegawai","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pegawai","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pegawai","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevels","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevels","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevels","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevelpermissions","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevelpermissions","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}userlevelpermissions","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}provinsi","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}provinsi","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}provinsi","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kabupaten","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kabupaten","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kabupaten","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kecamatan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kecamatan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kecamatan","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kelurahan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kelurahan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kelurahan","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ekspedisi","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ekspedisi","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ekspedisi","1","301"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}customer","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}alamat_customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}alamat_customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}alamat_customer","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipecustomer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipecustomer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipecustomer","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}product","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}product","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}product","1","365"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand_customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand_customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand_customer","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_sample","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_sample","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_sample","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_review","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_review","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_review","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_confirm","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_confirm","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_confirm","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_harga","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_harga","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_harga","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}serahterima","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}serahterima","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}serahterima","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki_status","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki_status","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinhaki_status","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom_status","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom_status","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}ijinbpom_status","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}titipmerk_validasi","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}titipmerk_validasi","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}titipmerk_validasi","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_orderdetail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_orderdetail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_orderdetail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}print_invoice.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}print_invoice.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}print_invoice.php","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}print_suratjalan.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}print_suratjalan.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}print_suratjalan.php","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}suratjalan_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pembayaran","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pembayaran","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pembayaran","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}redeembonus","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}redeembonus","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}redeembonus","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}Jatuh Tempo","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}Jatuh Tempo","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}Jatuh Tempo","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}Crosstab1","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}Crosstab1","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}Crosstab1","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer_detail","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporansales.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporansales.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporansales.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_npd_customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_npd_customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_npd_customer","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_order_customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_order_customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_order_customer","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_delivery_order.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_delivery_order.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_delivery_order.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_invoice.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_invoice.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_invoice.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_surat_jalan.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_surat_jalan.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_surat_jalan.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_pembayaran.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_pembayaran.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_pembayaran.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_do_stock","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_do_stock","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_do_stock","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}po_limit_approval_detail","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing_detail.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing_detail.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_kpi_marketing_detail.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kpi_marketing","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kpi_marketing","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kpi_marketing","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}d_jatuhtempo","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}d_jatuhtempo","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}d_jatuhtempo","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang_detail","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}level_customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}level_customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}level_customer","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_penagihan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_penagihan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_penagihan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}bot_history","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}bot_history","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}bot_history","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_order_customer.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_order_customer.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}laporan_order_customer.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan_customer.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan_customer.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan_customer.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}penagihan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_desain","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_desain","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_desain","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_brand_customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_brand_customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_brand_customer","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_serahterima","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_serahterima","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_serahterima","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_terms","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_terms","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_terms","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_masterdata","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_masterdata","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_masterdata","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_status","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_status","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_status","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stocks","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stocks","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stocks","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stockorder_detail","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock_produk","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock_produk","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock_produk","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_aplikasi_sediaan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_aplikasi_sediaan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_aplikasi_sediaan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_bentuk_sediaan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_bentuk_sediaan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_bentuk_sediaan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_estetika_sediaan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_estetika_sediaan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_estetika_sediaan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_tutup","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_tutup","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_tutup","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_wadah","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_wadah","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_kemasan_wadah","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_bahan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_bahan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_bahan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_posisi","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_posisi","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_posisi","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_parfum_sediaan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_parfum_sediaan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_parfum_sediaan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_order_detail","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock_deliveryorder_detail","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_kualitas","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_kualitas","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_label_kualitas","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_viskositas_sediaan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_viskositas_sediaan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_viskositas_sediaan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_warna_sediaan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_warna_sediaan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_warna_sediaan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pengembangan_produk.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pengembangan_produk.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}pengembangan_produk.php","1","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_master_spesifikasi","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_master_spesifikasi","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_master_spesifikasi","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_master_kemasan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_master_kemasan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_master_kemasan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipe_sla","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipe_sla","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipe_sla","1","288"]];
// User level table info
$USER_LEVEL_TABLES = [["pegawai","pegawai","Pegawai",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PegawaiList"],
    ["userlevels","userlevels","Manajemen User",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","UserlevelsList"],
    ["userlevelpermissions","userlevelpermissions","userlevelpermissions",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","UserlevelpermissionsList"],
    ["provinsi","provinsi","Provinsi",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","ProvinsiList"],
    ["kabupaten","kabupaten","Kabupaten",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KabupatenList"],
    ["kecamatan","kecamatan","Kecamatan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KecamatanList"],
    ["kelurahan","kelurahan","Kelurahan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KelurahanList"],
    ["ekspedisi","ekspedisi","Ekspedisi",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","EkspedisiList"],
    ["customer","customer","Pelanggan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","CustomerList"],
    ["alamat_customer","alamat_customer","Alamat Pengiriman",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","AlamatCustomerList"],
    ["tipecustomer","tipecustomer","Tipe Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TipecustomerList"],
    ["brand","brand","Brand",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","BrandList"],
    ["product","product","Produk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","ProductList"],
    ["brand_customer","brand_customer","Customer Brand",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","BrandCustomerList"],
    ["satuan","satuan","Satuan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SatuanList"],
    ["tipepayment","tipepayment","Metode Pembayaran",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TipepaymentList"],
    ["npd","npd","Pengembangan Produk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdList"],
    ["npd_sample","npd_sample","Sample",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdSampleList"],
    ["npd_review","npd_review","Review Sample",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdReviewList"],
    ["npd_confirm","npd_confirm","Confirm",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdConfirmList"],
    ["npd_harga","npd_harga","Permintaan Harga",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdHargaList"],
    ["serahterima","serahterima","Serah Terima Sample",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SerahterimaList"],
    ["ijinhaki","ijinhaki","Perizinan HAKI",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinhakiList"],
    ["ijinhaki_status","ijinhaki_status","Detail Status",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinhakiStatusList"],
    ["ijinbpom","ijinbpom","Perizinan BPOM",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinbpomList"],
    ["ijinbpom_detail","ijinbpom_detail","Detail Titip Merk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinbpomDetailList"],
    ["ijinbpom_status","ijinbpom_status","Detail Status",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinbpomStatusList"],
    ["titipmerk_validasi","titipmerk_validasi","Validasi Titip Merk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TitipmerkValidasiList"],
    ["order","order","Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","OrderList"],
    ["v_orderdetail","v_orderdetail","v orderdetail",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VOrderdetailList"],
    ["v_stock","v_stock","Stok",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VStockList"],
    ["print_invoice.php","print_invoice","Print Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PrintInvoice"],
    ["v_piutang","v_piutang","Piutang Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VPiutangList"],
    ["order_detail","order_detail","Detail Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","OrderDetailList"],
    ["v_bonuscustomer","v_bonuscustomer","Bonus Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VBonuscustomerList"],
    ["deliveryorder","deliveryorder","Delivery Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","DeliveryorderList"],
    ["deliveryorder_detail","deliveryorder_detail","Detail Delivery Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","DeliveryorderDetailList"],
    ["print_suratjalan.php","print_suratjalan","Print Surat Jalan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PrintSuratjalan"],
    ["invoice","invoice","Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","InvoiceList"],
    ["invoice_detail","invoice_detail","Detail Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","InvoiceDetailList"],
    ["suratjalan","suratjalan","Surat Jalan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SuratjalanList"],
    ["suratjalan_detail","suratjalan_detail","Detail Surat Jalan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SuratjalanDetailList"],
    ["pembayaran","pembayaran","Pembayaran",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PembayaranList"],
    ["redeembonus","redeembonus","Redeem Bonus",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","RedeembonusList"],
    ["dashboard.php","dashboard2","Dashboard",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","Dashboard2"],
    ["Jatuh Tempo","Jatuh_Tempo","Jatuh Tempo",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","JatuhTempo"],
    ["Crosstab1","Crosstab1","Crosstab 1",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","Crosstab1"],
    ["v_bonuscustomer_detail","v_bonuscustomer_detail","List Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VBonuscustomerDetailList"],
    ["laporansales.php","laporansales","Laporan Sales",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","Laporansales"],
    ["v_npd_customer","v_npd_customer","v npd customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}",""],
    ["v_order_customer","v_order_customer","v order customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}",""],
    ["laporan_delivery_order.php","laporan_delivery_order","Laporan Delivery Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LaporanDeliveryOrder"],
    ["laporan_invoice.php","laporan_invoice","Laporan Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LaporanInvoice"],
    ["laporan_surat_jalan.php","laporan_surat_jalan","Laporan Surat Jalan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LaporanSuratJalan"],
    ["laporan_pembayaran.php","laporan_pembayaran","Laporan Pembayaran",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LaporanPembayaran"],
    ["stock","stock","Stock",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","StockList"],
    ["v_do_stock","v_do_stock","v do stock",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VDoStockList"],
    ["po_limit_approval","po_limit_approval","P.O. Limit Approval",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PoLimitApprovalList"],
    ["po_limit_approval_detail","po_limit_approval_detail","P.O. Limit Approval Detail",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PoLimitApprovalDetailList"],
    ["laporan_kpi_marketing.php","laporan_kpi_marketing","Laporan KPI Marketing",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LaporanKpiMarketing"],
    ["laporan_kpi_marketing_detail.php","laporan_kpi_marketing_detail","Laporan KPI Marketing Detail",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LaporanKpiMarketingDetail"],
    ["kpi_marketing","kpi_marketing","KPI Marketing",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KpiMarketingList"],
    ["d_jatuhtempo","d_jatuhtempo","d jatuhtempo",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","DJatuhtempoList"],
    ["v_piutang_detail","v_piutang_detail","Detail Piutang",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VPiutangDetailList"],
    ["level_customer","level_customer","Level Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LevelCustomerList"],
    ["v_penagihan","v_penagihan","Penagihan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VPenagihanList"],
    ["bot_history","bot_history","Bot History",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","BotHistoryList"],
    ["laporan_order_customer.php","laporan_order_customer","Laporan Order Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","LaporanOrderCustomer"],
    ["penagihan_customer.php","penagihan_customer","Penagihan Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PenagihanCustomer"],
    ["termpayment","termpayment","Term Payment",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TermpaymentList"],
    ["penagihan","penagihan","penagihan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PenagihanList"],
    ["npd_desain","npd_desain","Pembuatan Desain",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdDesainList"],
    ["v_brand_customer","v_brand_customer","v brand customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VBrandCustomerList"],
    ["npd_serahterima","npd_serahterima","Serah Terima",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdSerahterimaList"],
    ["npd_terms","npd_terms","TERMS",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdTermsList"],
    ["npd_masterdata","npd_masterdata","npd masterdata",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdMasterdataList"],
    ["npd_status","npd_status","npd status",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdStatusList"],
    ["stocks","stocks","Stocks",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","StocksList"],
    ["v_stockorder","v_stockorder","v stockorder",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VStockorderList"],
    ["v_stockorder_detail","v_stockorder_detail","v stockorder detail",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VStockorderDetailList"],
    ["v_stock_produk","v_stock_produk","v stock produk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VStockProdukList"],
    ["npd_aplikasi_sediaan","npd_aplikasi_sediaan","Aplikasi Sediaan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdAplikasiSediaanList"],
    ["npd_bentuk_sediaan","npd_bentuk_sediaan","Bentuk Sediaan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdBentukSediaanList"],
    ["npd_estetika_sediaan","npd_estetika_sediaan","Estetika Sediaan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdEstetikaSediaanList"],
    ["npd_kemasan_tutup","npd_kemasan_tutup","Kemasan Tutup",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdKemasanTutupList"],
    ["stock_order","stock_order","Stock Purchase",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","StockOrderList"],
    ["npd_kemasan_wadah","npd_kemasan_wadah","Kemasan Wadah",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdKemasanWadahList"],
    ["npd_label_bahan","npd_label_bahan","Label Bahan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdLabelBahanList"],
    ["npd_label_posisi","npd_label_posisi","Label Posisi",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdLabelPosisiList"],
    ["npd_parfum_sediaan","npd_parfum_sediaan","Parfum Sediaan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdParfumSediaanList"],
    ["stock_order_detail","stock_order_detail","Stock Order Detail",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","StockOrderDetailList"],
    ["stock_deliveryorder","stock_deliveryorder","Stock Delivery",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","StockDeliveryorderList"],
    ["stock_deliveryorder_detail","stock_deliveryorder_detail","Stock Delivery Order Detail",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","StockDeliveryorderDetailList"],
    ["npd_label_kualitas","npd_label_kualitas","Label Kualitas",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdLabelKualitasList"],
    ["npd_viskositas_sediaan","npd_viskositas_sediaan","Viskositas Sediaan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdViskositasSediaanList"],
    ["npd_warna_sediaan","npd_warna_sediaan","Warna Sediaan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdWarnaSediaanList"],
    ["pengembangan_produk.php","pengembangan_produk","Pengembangan Produk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PengembanganProduk"],
    ["npd_master_spesifikasi","npd_master_spesifikasi","npd produk master",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdMasterSpesifikasiList"],
    ["npd_master_kemasan","npd_master_kemasan","npd master kemasan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdMasterKemasanList"],
    ["aplikasibarang","aplikasibarang","Aplikasi Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","AplikasibarangList"],
    ["jenisbarang","jenisbarang","Jenis Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","JenisbarangList"],
    ["kategoribarang","kategoribarang","Kategori Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KategoribarangList"],
    ["kemasanbarang","kemasanbarang","Kemasan Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KemasanbarangList"],
    ["kualitasbarang","kualitasbarang","Kualitas Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KualitasbarangList"],
    ["viskositasbarang","viskositasbarang","Viskositas Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","ViskositasbarangList"],
    ["tipe_sla","tipe_sla","Tipe SLA",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TipeSlaList"]];
