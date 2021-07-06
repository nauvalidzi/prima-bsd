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
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}jenisbarang","1","296"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kategoribarang","1","296"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kualitasbarang","1","296"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}kemasanbarang","1","296"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}aplikasibarang","1","296"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}viskositasbarang","1","296"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}satuan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}rekening","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}rekening","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}rekening","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}tipepayment","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}termpayment","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_status","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_status","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}npd_status","1","367"],
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
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_orderdetail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_orderdetail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_orderdetail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_stock","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}p_invoice.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}p_invoice.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}p_invoice.php","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_bonuscustomer","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_piutang_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder_detail","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder_detail","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}deliveryorder_detail","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}invoice","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}p_suratjalan.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}p_suratjalan.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}p_suratjalan.php","1","367"],
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
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}stock","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}dashboard.php","1","367"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}d_jatuhtempo","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}d_jatuhtempo","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}d_jatuhtempo","1","367"],
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
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_pengembangan","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_pengembangan","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}order_pengembangan","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand_link","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand_link","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}brand_link","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_brand_link","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_brand_link","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_brand_link","1","288"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_order_customer","-2","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_order_customer","0","0"],
    ["{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}v_order_customer","1","288"]];
// User level table info
$USER_LEVEL_TABLES = [["pegawai","pegawai","Pegawai",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PegawaiList"],
    ["userlevels","userlevels","Setting Users",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","UserlevelsList"],
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
    ["jenisbarang","jenisbarang","Jenis Barang",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","JenisbarangList"],
    ["kategoribarang","kategoribarang","Kategori Barang",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KategoribarangList"],
    ["kualitasbarang","kualitasbarang","Kualitas Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KualitasbarangList"],
    ["kemasanbarang","kemasanbarang","Kemasan Product",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","KemasanbarangList"],
    ["aplikasibarang","aplikasibarang","Aplikasi Barang",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","AplikasibarangList"],
    ["viskositasbarang","viskositasbarang","viskositasbarang",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","ViskositasbarangList"],
    ["satuan","satuan","Satuan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SatuanList"],
    ["rekening","rekening","Data Rekening",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","RekeningList"],
    ["tipepayment","tipepayment","Metode Payment",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TipepaymentList"],
    ["termpayment","termpayment","Term of Payment",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TermpaymentList"],
    ["npd","npd","Pengembangan Produk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdList"],
    ["npd_status","npd_status","Detail Status",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdStatusList"],
    ["npd_sample","npd_sample","Sample",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdSampleList"],
    ["npd_review","npd_review","Development Review",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdReviewList"],
    ["npd_confirm","npd_confirm","Confirm",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdConfirmList"],
    ["npd_harga","npd_harga","Permintaan Harga",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","NpdHargaList"],
    ["serahterima","serahterima","Serah Terima Sample",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SerahterimaList"],
    ["ijinhaki","ijinhaki","Ijin HKI",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinhakiList"],
    ["ijinhaki_status","ijinhaki_status","Detail Status",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinhakiStatusList"],
    ["ijinbpom","ijinbpom","Titip Merk BPOM",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinbpomList"],
    ["ijinbpom_detail","ijinbpom_detail","Detail Titip Merk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinbpomDetailList"],
    ["ijinbpom_status","ijinbpom_status","Detail Status",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","IjinbpomStatusList"],
    ["titipmerk_validasi","titipmerk_validasi","Validasi Titip Merk",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","TitipmerkValidasiList"],
    ["order","order","Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","OrderList"],
    ["order_detail","order_detail","Detail Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","OrderDetailList"],
    ["v_orderdetail","v_orderdetail","v orderdetail",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VOrderdetailList"],
    ["v_stock","v_stock","Stock",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VStockList"],
    ["p_invoice.php","p_invoice","Print Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PInvoice"],
    ["v_piutang","v_piutang","Piutang Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VPiutangList"],
    ["deliveryorder","deliveryorder","Delivery Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","DeliveryorderList"],
    ["v_bonuscustomer","v_bonuscustomer","Bonus Customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VBonuscustomerList"],
    ["v_piutang_detail","v_piutang_detail","Detail Piutang",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VPiutangDetailList"],
    ["deliveryorder_detail","deliveryorder_detail","Detail Delivery Order",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","DeliveryorderDetailList"],
    ["invoice","invoice","Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","InvoiceList"],
    ["p_suratjalan.php","p_suratjalan","Print Surat Jalan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PSuratjalan"],
    ["invoice_detail","invoice_detail","Detail Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","InvoiceDetailList"],
    ["suratjalan","suratjalan","Surat Jalan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SuratjalanList"],
    ["suratjalan_detail","suratjalan_detail","Detail Surat Jalan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","SuratjalanDetailList"],
    ["pembayaran","pembayaran","Pembayaran",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","PembayaranList"],
    ["redeembonus","redeembonus","Redeem Bonus",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","RedeembonusList"],
    ["stock","stock","Stock",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","StockList"],
    ["dashboard.php","dashboard2","Dashboard",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","Dashboard2"],
    ["d_jatuhtempo","d_jatuhtempo","d jatuhtempo",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","DJatuhtempoList"],
    ["Jatuh Tempo","Jatuh_Tempo","Jatuh Tempo",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","JatuhTempo"],
    ["Crosstab1","Crosstab1","Crosstab 1",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","Crosstab1"],
    ["v_bonuscustomer_detail","v_bonuscustomer_detail","List Invoice",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VBonuscustomerDetailList"],
    ["laporansales.php","laporansales","Laporan Sales",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","Laporansales"],
    ["v_npd_customer","v_npd_customer","v npd customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VNpdCustomerList"],
    ["order_pengembangan","order_pengembangan","order pengembangan",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","OrderPengembanganList"],
    ["brand_link","brand_link","brand link",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","BrandLinkList"],
    ["v_brand_link","v_brand_link","v brand link",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VBrandLinkList"],
    ["v_order_customer","v_order_customer","v order customer",true,"{4FA0DF52-C852-4B9E-ABFE-6BF1F23D959B}","VOrderCustomerList"]];
