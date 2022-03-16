<?php

namespace PHPMaker2021\production2;

// Page object
$NpdView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpdview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpdview = currentForm = new ew.Form("fnpdview", "view");
    loadjs.done("fnpdview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd) ew.vars.tables.npd = <?= JsonEncode(GetClientVar("tables", "npd")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpdview" id="fnpdview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idpegawai"><template id="tpc_npd_idpegawai"><?= $Page->idpegawai->caption() ?></template></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<template id="tpx_npd_idpegawai"><span id="el_npd_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idcustomer"><template id="tpc_npd_idcustomer"><?= $Page->idcustomer->caption() ?></template></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<template id="tpx_npd_idcustomer"><span id="el_npd_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <tr id="r_idbrand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idbrand"><template id="tpc_npd_idbrand"><?= $Page->idbrand->caption() ?></template></span></td>
        <td data-name="idbrand" <?= $Page->idbrand->cellAttributes() ?>>
<template id="tpx_npd_idbrand"><span id="el_npd_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
    <tr id="r_tanggal_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_tanggal_order"><template id="tpc_npd_tanggal_order"><?= $Page->tanggal_order->caption() ?></template></span></td>
        <td data-name="tanggal_order" <?= $Page->tanggal_order->cellAttributes() ?>>
<template id="tpx_npd_tanggal_order"><span id="el_npd_tanggal_order">
<span<?= $Page->tanggal_order->viewAttributes() ?>>
<?= $Page->tanggal_order->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
    <tr id="r_target_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_target_selesai"><template id="tpc_npd_target_selesai"><?= $Page->target_selesai->caption() ?></template></span></td>
        <td data-name="target_selesai" <?= $Page->target_selesai->cellAttributes() ?>>
<template id="tpx_npd_target_selesai"><span id="el_npd_target_selesai">
<span<?= $Page->target_selesai->viewAttributes() ?>>
<?= $Page->target_selesai->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
    <tr id="r_sifatorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sifatorder"><template id="tpc_npd_sifatorder"><?= $Page->sifatorder->caption() ?></template></span></td>
        <td data-name="sifatorder" <?= $Page->sifatorder->cellAttributes() ?>>
<template id="tpx_npd_sifatorder"><span id="el_npd_sifatorder">
<span<?= $Page->sifatorder->viewAttributes() ?>>
<?= $Page->sifatorder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
    <tr id="r_kodeorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kodeorder"><template id="tpc_npd_kodeorder"><?= $Page->kodeorder->caption() ?></template></span></td>
        <td data-name="kodeorder" <?= $Page->kodeorder->cellAttributes() ?>>
<template id="tpx_npd_kodeorder"><span id="el_npd_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nomororder->Visible) { // nomororder ?>
    <tr id="r_nomororder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_nomororder"><template id="tpc_npd_nomororder"><?= $Page->nomororder->caption() ?></template></span></td>
        <td data-name="nomororder" <?= $Page->nomororder->cellAttributes() ?>>
<template id="tpx_npd_nomororder"><span id="el_npd_nomororder">
<span<?= $Page->nomororder->viewAttributes() ?>>
<?= $Page->nomororder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <tr id="r_idproduct_acuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idproduct_acuan"><template id="tpc_npd_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?></template></span></td>
        <td data-name="idproduct_acuan" <?= $Page->idproduct_acuan->cellAttributes() ?>>
<template id="tpx_npd_idproduct_acuan"><span id="el_npd_idproduct_acuan">
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
    <tr id="r_kategoriproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kategoriproduk"><template id="tpc_npd_kategoriproduk"><?= $Page->kategoriproduk->caption() ?></template></span></td>
        <td data-name="kategoriproduk" <?= $Page->kategoriproduk->cellAttributes() ?>>
<template id="tpx_npd_kategoriproduk"><span id="el_npd_kategoriproduk">
<span<?= $Page->kategoriproduk->viewAttributes() ?>>
<?= $Page->kategoriproduk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
    <tr id="r_jenisproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_jenisproduk"><template id="tpc_npd_jenisproduk"><?= $Page->jenisproduk->caption() ?></template></span></td>
        <td data-name="jenisproduk" <?= $Page->jenisproduk->cellAttributes() ?>>
<template id="tpx_npd_jenisproduk"><span id="el_npd_jenisproduk">
<span<?= $Page->jenisproduk->viewAttributes() ?>>
<?= $Page->jenisproduk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fungsiproduk->Visible) { // fungsiproduk ?>
    <tr id="r_fungsiproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_fungsiproduk"><template id="tpc_npd_fungsiproduk"><?= $Page->fungsiproduk->caption() ?></template></span></td>
        <td data-name="fungsiproduk" <?= $Page->fungsiproduk->cellAttributes() ?>>
<template id="tpx_npd_fungsiproduk"><span id="el_npd_fungsiproduk">
<span<?= $Page->fungsiproduk->viewAttributes() ?>>
<?= $Page->fungsiproduk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kualitasproduk->Visible) { // kualitasproduk ?>
    <tr id="r_kualitasproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kualitasproduk"><template id="tpc_npd_kualitasproduk"><?= $Page->kualitasproduk->caption() ?></template></span></td>
        <td data-name="kualitasproduk" <?= $Page->kualitasproduk->cellAttributes() ?>>
<template id="tpx_npd_kualitasproduk"><span id="el_npd_kualitasproduk">
<span<?= $Page->kualitasproduk->viewAttributes() ?>>
<?= $Page->kualitasproduk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
    <tr id="r_bahan_campaign">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_bahan_campaign"><template id="tpc_npd_bahan_campaign"><?= $Page->bahan_campaign->caption() ?></template></span></td>
        <td data-name="bahan_campaign" <?= $Page->bahan_campaign->cellAttributes() ?>>
<template id="tpx_npd_bahan_campaign"><span id="el_npd_bahan_campaign">
<span<?= $Page->bahan_campaign->viewAttributes() ?>>
<?= $Page->bahan_campaign->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuransediaan->Visible) { // ukuransediaan ?>
    <tr id="r_ukuransediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_ukuransediaan"><template id="tpc_npd_ukuransediaan"><?= $Page->ukuransediaan->caption() ?></template></span></td>
        <td data-name="ukuransediaan" <?= $Page->ukuransediaan->cellAttributes() ?>>
<template id="tpx_npd_ukuransediaan"><span id="el_npd_ukuransediaan">
<span<?= $Page->ukuransediaan->viewAttributes() ?>>
<?= $Page->ukuransediaan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuansediaan->Visible) { // satuansediaan ?>
    <tr id="r_satuansediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_satuansediaan"><template id="tpc_npd_satuansediaan"><?= $Page->satuansediaan->caption() ?></template></span></td>
        <td data-name="satuansediaan" <?= $Page->satuansediaan->cellAttributes() ?>>
<template id="tpx_npd_satuansediaan"><span id="el_npd_satuansediaan">
<span<?= $Page->satuansediaan->viewAttributes() ?>>
<?= $Page->satuansediaan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <tr id="r_bentuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_bentuk"><template id="tpc_npd_bentuk"><?= $Page->bentuk->caption() ?></template></span></td>
        <td data-name="bentuk" <?= $Page->bentuk->cellAttributes() ?>>
<template id="tpx_npd_bentuk"><span id="el_npd_bentuk">
<span<?= $Page->bentuk->viewAttributes() ?>>
<?= $Page->bentuk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <tr id="r_viskositas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_viskositas"><template id="tpc_npd_viskositas"><?= $Page->viskositas->caption() ?></template></span></td>
        <td data-name="viskositas" <?= $Page->viskositas->cellAttributes() ?>>
<template id="tpx_npd_viskositas"><span id="el_npd_viskositas">
<span<?= $Page->viskositas->viewAttributes() ?>>
<?= $Page->viskositas->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_warna"><template id="tpc_npd_warna"><?= $Page->warna->caption() ?></template></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<template id="tpx_npd_warna"><span id="el_npd_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <tr id="r_parfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_parfum"><template id="tpc_npd_parfum"><?= $Page->parfum->caption() ?></template></span></td>
        <td data-name="parfum" <?= $Page->parfum->cellAttributes() ?>>
<template id="tpx_npd_parfum"><span id="el_npd_parfum">
<span<?= $Page->parfum->viewAttributes() ?>>
<?= $Page->parfum->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasi->Visible) { // aplikasi ?>
    <tr id="r_aplikasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_aplikasi"><template id="tpc_npd_aplikasi"><?= $Page->aplikasi->caption() ?></template></span></td>
        <td data-name="aplikasi" <?= $Page->aplikasi->cellAttributes() ?>>
<template id="tpx_npd_aplikasi"><span id="el_npd_aplikasi">
<span<?= $Page->aplikasi->viewAttributes() ?>>
<?= $Page->aplikasi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetika->Visible) { // estetika ?>
    <tr id="r_estetika">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_estetika"><template id="tpc_npd_estetika"><?= $Page->estetika->caption() ?></template></span></td>
        <td data-name="estetika" <?= $Page->estetika->cellAttributes() ?>>
<template id="tpx_npd_estetika"><span id="el_npd_estetika">
<span<?= $Page->estetika->viewAttributes() ?>>
<?= $Page->estetika->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <tr id="r_tambahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_tambahan"><template id="tpc_npd_tambahan"><?= $Page->tambahan->caption() ?></template></span></td>
        <td data-name="tambahan" <?= $Page->tambahan->cellAttributes() ?>>
<template id="tpx_npd_tambahan"><span id="el_npd_tambahan">
<span<?= $Page->tambahan->viewAttributes() ?>>
<?= $Page->tambahan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukurankemasan->Visible) { // ukurankemasan ?>
    <tr id="r_ukurankemasan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_ukurankemasan"><template id="tpc_npd_ukurankemasan"><?= $Page->ukurankemasan->caption() ?></template></span></td>
        <td data-name="ukurankemasan" <?= $Page->ukurankemasan->cellAttributes() ?>>
<template id="tpx_npd_ukurankemasan"><span id="el_npd_ukurankemasan">
<span<?= $Page->ukurankemasan->viewAttributes() ?>>
<?= $Page->ukurankemasan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuankemasan->Visible) { // satuankemasan ?>
    <tr id="r_satuankemasan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_satuankemasan"><template id="tpc_npd_satuankemasan"><?= $Page->satuankemasan->caption() ?></template></span></td>
        <td data-name="satuankemasan" <?= $Page->satuankemasan->cellAttributes() ?>>
<template id="tpx_npd_satuankemasan"><span id="el_npd_satuankemasan">
<span<?= $Page->satuankemasan->viewAttributes() ?>>
<?= $Page->satuankemasan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
    <tr id="r_kemasanwadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasanwadah"><template id="tpc_npd_kemasanwadah"><?= $Page->kemasanwadah->caption() ?></template></span></td>
        <td data-name="kemasanwadah" <?= $Page->kemasanwadah->cellAttributes() ?>>
<template id="tpx_npd_kemasanwadah"><span id="el_npd_kemasanwadah">
<span<?= $Page->kemasanwadah->viewAttributes() ?>>
<?= $Page->kemasanwadah->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
    <tr id="r_kemasantutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasantutup"><template id="tpc_npd_kemasantutup"><?= $Page->kemasantutup->caption() ?></template></span></td>
        <td data-name="kemasantutup" <?= $Page->kemasantutup->cellAttributes() ?>>
<template id="tpx_npd_kemasantutup"><span id="el_npd_kemasantutup">
<span<?= $Page->kemasantutup->viewAttributes() ?>>
<?= $Page->kemasantutup->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasancatatan->Visible) { // kemasancatatan ?>
    <tr id="r_kemasancatatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasancatatan"><template id="tpc_npd_kemasancatatan"><?= $Page->kemasancatatan->caption() ?></template></span></td>
        <td data-name="kemasancatatan" <?= $Page->kemasancatatan->cellAttributes() ?>>
<template id="tpx_npd_kemasancatatan"><span id="el_npd_kemasancatatan">
<span<?= $Page->kemasancatatan->viewAttributes() ?>>
<?= $Page->kemasancatatan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukurankemasansekunder->Visible) { // ukurankemasansekunder ?>
    <tr id="r_ukurankemasansekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_ukurankemasansekunder"><template id="tpc_npd_ukurankemasansekunder"><?= $Page->ukurankemasansekunder->caption() ?></template></span></td>
        <td data-name="ukurankemasansekunder" <?= $Page->ukurankemasansekunder->cellAttributes() ?>>
<template id="tpx_npd_ukurankemasansekunder"><span id="el_npd_ukurankemasansekunder">
<span<?= $Page->ukurankemasansekunder->viewAttributes() ?>>
<?= $Page->ukurankemasansekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuankemasansekunder->Visible) { // satuankemasansekunder ?>
    <tr id="r_satuankemasansekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_satuankemasansekunder"><template id="tpc_npd_satuankemasansekunder"><?= $Page->satuankemasansekunder->caption() ?></template></span></td>
        <td data-name="satuankemasansekunder" <?= $Page->satuankemasansekunder->cellAttributes() ?>>
<template id="tpx_npd_satuankemasansekunder"><span id="el_npd_satuankemasansekunder">
<span<?= $Page->satuankemasansekunder->viewAttributes() ?>>
<?= $Page->satuankemasansekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasanbahan->Visible) { // kemasanbahan ?>
    <tr id="r_kemasanbahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasanbahan"><template id="tpc_npd_kemasanbahan"><?= $Page->kemasanbahan->caption() ?></template></span></td>
        <td data-name="kemasanbahan" <?= $Page->kemasanbahan->cellAttributes() ?>>
<template id="tpx_npd_kemasanbahan"><span id="el_npd_kemasanbahan">
<span<?= $Page->kemasanbahan->viewAttributes() ?>>
<?= $Page->kemasanbahan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasanbentuk->Visible) { // kemasanbentuk ?>
    <tr id="r_kemasanbentuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasanbentuk"><template id="tpc_npd_kemasanbentuk"><?= $Page->kemasanbentuk->caption() ?></template></span></td>
        <td data-name="kemasanbentuk" <?= $Page->kemasanbentuk->cellAttributes() ?>>
<template id="tpx_npd_kemasanbentuk"><span id="el_npd_kemasanbentuk">
<span<?= $Page->kemasanbentuk->viewAttributes() ?>>
<?= $Page->kemasanbentuk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasankomposisi->Visible) { // kemasankomposisi ?>
    <tr id="r_kemasankomposisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasankomposisi"><template id="tpc_npd_kemasankomposisi"><?= $Page->kemasankomposisi->caption() ?></template></span></td>
        <td data-name="kemasankomposisi" <?= $Page->kemasankomposisi->cellAttributes() ?>>
<template id="tpx_npd_kemasankomposisi"><span id="el_npd_kemasankomposisi">
<span<?= $Page->kemasankomposisi->viewAttributes() ?>>
<?= $Page->kemasankomposisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasancatatansekunder->Visible) { // kemasancatatansekunder ?>
    <tr id="r_kemasancatatansekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasancatatansekunder"><template id="tpc_npd_kemasancatatansekunder"><?= $Page->kemasancatatansekunder->caption() ?></template></span></td>
        <td data-name="kemasancatatansekunder" <?= $Page->kemasancatatansekunder->cellAttributes() ?>>
<template id="tpx_npd_kemasancatatansekunder"><span id="el_npd_kemasancatatansekunder">
<span<?= $Page->kemasancatatansekunder->viewAttributes() ?>>
<?= $Page->kemasancatatansekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelbahan->Visible) { // labelbahan ?>
    <tr id="r_labelbahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelbahan"><template id="tpc_npd_labelbahan"><?= $Page->labelbahan->caption() ?></template></span></td>
        <td data-name="labelbahan" <?= $Page->labelbahan->cellAttributes() ?>>
<template id="tpx_npd_labelbahan"><span id="el_npd_labelbahan">
<span<?= $Page->labelbahan->viewAttributes() ?>>
<?= $Page->labelbahan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
    <tr id="r_labelkualitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelkualitas"><template id="tpc_npd_labelkualitas"><?= $Page->labelkualitas->caption() ?></template></span></td>
        <td data-name="labelkualitas" <?= $Page->labelkualitas->cellAttributes() ?>>
<template id="tpx_npd_labelkualitas"><span id="el_npd_labelkualitas">
<span<?= $Page->labelkualitas->viewAttributes() ?>>
<?= $Page->labelkualitas->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
    <tr id="r_labelposisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelposisi"><template id="tpc_npd_labelposisi"><?= $Page->labelposisi->caption() ?></template></span></td>
        <td data-name="labelposisi" <?= $Page->labelposisi->cellAttributes() ?>>
<template id="tpx_npd_labelposisi"><span id="el_npd_labelposisi">
<span<?= $Page->labelposisi->viewAttributes() ?>>
<?= $Page->labelposisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelcatatan->Visible) { // labelcatatan ?>
    <tr id="r_labelcatatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelcatatan"><template id="tpc_npd_labelcatatan"><?= $Page->labelcatatan->caption() ?></template></span></td>
        <td data-name="labelcatatan" <?= $Page->labelcatatan->cellAttributes() ?>>
<template id="tpx_npd_labelcatatan"><span id="el_npd_labelcatatan">
<span<?= $Page->labelcatatan->viewAttributes() ?>>
<?= $Page->labelcatatan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labeltekstur->Visible) { // labeltekstur ?>
    <tr id="r_labeltekstur">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labeltekstur"><template id="tpc_npd_labeltekstur"><?= $Page->labeltekstur->caption() ?></template></span></td>
        <td data-name="labeltekstur" <?= $Page->labeltekstur->cellAttributes() ?>>
<template id="tpx_npd_labeltekstur"><span id="el_npd_labeltekstur">
<span<?= $Page->labeltekstur->viewAttributes() ?>>
<?= $Page->labeltekstur->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelprint->Visible) { // labelprint ?>
    <tr id="r_labelprint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelprint"><template id="tpc_npd_labelprint"><?= $Page->labelprint->caption() ?></template></span></td>
        <td data-name="labelprint" <?= $Page->labelprint->cellAttributes() ?>>
<template id="tpx_npd_labelprint"><span id="el_npd_labelprint">
<span<?= $Page->labelprint->viewAttributes() ?>>
<?= $Page->labelprint->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labeljmlwarna->Visible) { // labeljmlwarna ?>
    <tr id="r_labeljmlwarna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labeljmlwarna"><template id="tpc_npd_labeljmlwarna"><?= $Page->labeljmlwarna->caption() ?></template></span></td>
        <td data-name="labeljmlwarna" <?= $Page->labeljmlwarna->cellAttributes() ?>>
<template id="tpx_npd_labeljmlwarna"><span id="el_npd_labeljmlwarna">
<span<?= $Page->labeljmlwarna->viewAttributes() ?>>
<?= $Page->labeljmlwarna->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelcatatanhotprint->Visible) { // labelcatatanhotprint ?>
    <tr id="r_labelcatatanhotprint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelcatatanhotprint"><template id="tpc_npd_labelcatatanhotprint"><?= $Page->labelcatatanhotprint->caption() ?></template></span></td>
        <td data-name="labelcatatanhotprint" <?= $Page->labelcatatanhotprint->cellAttributes() ?>>
<template id="tpx_npd_labelcatatanhotprint"><span id="el_npd_labelcatatanhotprint">
<span<?= $Page->labelcatatanhotprint->viewAttributes() ?>>
<?= $Page->labelcatatanhotprint->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
    <tr id="r_ukuran_utama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_ukuran_utama"><template id="tpc_npd_ukuran_utama"><?= $Page->ukuran_utama->caption() ?></template></span></td>
        <td data-name="ukuran_utama" <?= $Page->ukuran_utama->cellAttributes() ?>>
<template id="tpx_npd_ukuran_utama"><span id="el_npd_ukuran_utama">
<span<?= $Page->ukuran_utama->viewAttributes() ?>>
<?= $Page->ukuran_utama->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
    <tr id="r_utama_harga_isi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_isi"><template id="tpc_npd_utama_harga_isi"><?= $Page->utama_harga_isi->caption() ?></template></span></td>
        <td data-name="utama_harga_isi" <?= $Page->utama_harga_isi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_isi"><span id="el_npd_utama_harga_isi">
<span<?= $Page->utama_harga_isi->viewAttributes() ?>>
<?= $Page->utama_harga_isi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_isi_proyeksi->Visible) { // utama_harga_isi_proyeksi ?>
    <tr id="r_utama_harga_isi_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_isi_proyeksi"><template id="tpc_npd_utama_harga_isi_proyeksi"><?= $Page->utama_harga_isi_proyeksi->caption() ?></template></span></td>
        <td data-name="utama_harga_isi_proyeksi" <?= $Page->utama_harga_isi_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_isi_proyeksi"><span id="el_npd_utama_harga_isi_proyeksi">
<span<?= $Page->utama_harga_isi_proyeksi->viewAttributes() ?>>
<?= $Page->utama_harga_isi_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
    <tr id="r_utama_harga_primer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_primer"><template id="tpc_npd_utama_harga_primer"><?= $Page->utama_harga_primer->caption() ?></template></span></td>
        <td data-name="utama_harga_primer" <?= $Page->utama_harga_primer->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_primer"><span id="el_npd_utama_harga_primer">
<span<?= $Page->utama_harga_primer->viewAttributes() ?>>
<?= $Page->utama_harga_primer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_primer_proyeksi->Visible) { // utama_harga_primer_proyeksi ?>
    <tr id="r_utama_harga_primer_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_primer_proyeksi"><template id="tpc_npd_utama_harga_primer_proyeksi"><?= $Page->utama_harga_primer_proyeksi->caption() ?></template></span></td>
        <td data-name="utama_harga_primer_proyeksi" <?= $Page->utama_harga_primer_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_primer_proyeksi"><span id="el_npd_utama_harga_primer_proyeksi">
<span<?= $Page->utama_harga_primer_proyeksi->viewAttributes() ?>>
<?= $Page->utama_harga_primer_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
    <tr id="r_utama_harga_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_sekunder"><template id="tpc_npd_utama_harga_sekunder"><?= $Page->utama_harga_sekunder->caption() ?></template></span></td>
        <td data-name="utama_harga_sekunder" <?= $Page->utama_harga_sekunder->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_sekunder"><span id="el_npd_utama_harga_sekunder">
<span<?= $Page->utama_harga_sekunder->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_proyeksi->Visible) { // utama_harga_sekunder_proyeksi ?>
    <tr id="r_utama_harga_sekunder_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_sekunder_proyeksi"><template id="tpc_npd_utama_harga_sekunder_proyeksi"><?= $Page->utama_harga_sekunder_proyeksi->caption() ?></template></span></td>
        <td data-name="utama_harga_sekunder_proyeksi" <?= $Page->utama_harga_sekunder_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_sekunder_proyeksi"><span id="el_npd_utama_harga_sekunder_proyeksi">
<span<?= $Page->utama_harga_sekunder_proyeksi->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
    <tr id="r_utama_harga_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_label"><template id="tpc_npd_utama_harga_label"><?= $Page->utama_harga_label->caption() ?></template></span></td>
        <td data-name="utama_harga_label" <?= $Page->utama_harga_label->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_label"><span id="el_npd_utama_harga_label">
<span<?= $Page->utama_harga_label->viewAttributes() ?>>
<?= $Page->utama_harga_label->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_label_proyeksi->Visible) { // utama_harga_label_proyeksi ?>
    <tr id="r_utama_harga_label_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_label_proyeksi"><template id="tpc_npd_utama_harga_label_proyeksi"><?= $Page->utama_harga_label_proyeksi->caption() ?></template></span></td>
        <td data-name="utama_harga_label_proyeksi" <?= $Page->utama_harga_label_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_label_proyeksi"><span id="el_npd_utama_harga_label_proyeksi">
<span<?= $Page->utama_harga_label_proyeksi->viewAttributes() ?>>
<?= $Page->utama_harga_label_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
    <tr id="r_utama_harga_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_total"><template id="tpc_npd_utama_harga_total"><?= $Page->utama_harga_total->caption() ?></template></span></td>
        <td data-name="utama_harga_total" <?= $Page->utama_harga_total->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_total"><span id="el_npd_utama_harga_total">
<span<?= $Page->utama_harga_total->viewAttributes() ?>>
<?= $Page->utama_harga_total->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->utama_harga_total_proyeksi->Visible) { // utama_harga_total_proyeksi ?>
    <tr id="r_utama_harga_total_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_utama_harga_total_proyeksi"><template id="tpc_npd_utama_harga_total_proyeksi"><?= $Page->utama_harga_total_proyeksi->caption() ?></template></span></td>
        <td data-name="utama_harga_total_proyeksi" <?= $Page->utama_harga_total_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_total_proyeksi"><span id="el_npd_utama_harga_total_proyeksi">
<span<?= $Page->utama_harga_total_proyeksi->viewAttributes() ?>>
<?= $Page->utama_harga_total_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
    <tr id="r_ukuran_lain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_ukuran_lain"><template id="tpc_npd_ukuran_lain"><?= $Page->ukuran_lain->caption() ?></template></span></td>
        <td data-name="ukuran_lain" <?= $Page->ukuran_lain->cellAttributes() ?>>
<template id="tpx_npd_ukuran_lain"><span id="el_npd_ukuran_lain">
<span<?= $Page->ukuran_lain->viewAttributes() ?>>
<?= $Page->ukuran_lain->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
    <tr id="r_lain_harga_isi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_isi"><template id="tpc_npd_lain_harga_isi"><?= $Page->lain_harga_isi->caption() ?></template></span></td>
        <td data-name="lain_harga_isi" <?= $Page->lain_harga_isi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_isi"><span id="el_npd_lain_harga_isi">
<span<?= $Page->lain_harga_isi->viewAttributes() ?>>
<?= $Page->lain_harga_isi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_isi_proyeksi->Visible) { // lain_harga_isi_proyeksi ?>
    <tr id="r_lain_harga_isi_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_isi_proyeksi"><template id="tpc_npd_lain_harga_isi_proyeksi"><?= $Page->lain_harga_isi_proyeksi->caption() ?></template></span></td>
        <td data-name="lain_harga_isi_proyeksi" <?= $Page->lain_harga_isi_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_isi_proyeksi"><span id="el_npd_lain_harga_isi_proyeksi">
<span<?= $Page->lain_harga_isi_proyeksi->viewAttributes() ?>>
<?= $Page->lain_harga_isi_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
    <tr id="r_lain_harga_primer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_primer"><template id="tpc_npd_lain_harga_primer"><?= $Page->lain_harga_primer->caption() ?></template></span></td>
        <td data-name="lain_harga_primer" <?= $Page->lain_harga_primer->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_primer"><span id="el_npd_lain_harga_primer">
<span<?= $Page->lain_harga_primer->viewAttributes() ?>>
<?= $Page->lain_harga_primer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_primer_proyeksi->Visible) { // lain_harga_primer_proyeksi ?>
    <tr id="r_lain_harga_primer_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_primer_proyeksi"><template id="tpc_npd_lain_harga_primer_proyeksi"><?= $Page->lain_harga_primer_proyeksi->caption() ?></template></span></td>
        <td data-name="lain_harga_primer_proyeksi" <?= $Page->lain_harga_primer_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_primer_proyeksi"><span id="el_npd_lain_harga_primer_proyeksi">
<span<?= $Page->lain_harga_primer_proyeksi->viewAttributes() ?>>
<?= $Page->lain_harga_primer_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
    <tr id="r_lain_harga_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_sekunder"><template id="tpc_npd_lain_harga_sekunder"><?= $Page->lain_harga_sekunder->caption() ?></template></span></td>
        <td data-name="lain_harga_sekunder" <?= $Page->lain_harga_sekunder->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_sekunder"><span id="el_npd_lain_harga_sekunder">
<span<?= $Page->lain_harga_sekunder->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_proyeksi->Visible) { // lain_harga_sekunder_proyeksi ?>
    <tr id="r_lain_harga_sekunder_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_sekunder_proyeksi"><template id="tpc_npd_lain_harga_sekunder_proyeksi"><?= $Page->lain_harga_sekunder_proyeksi->caption() ?></template></span></td>
        <td data-name="lain_harga_sekunder_proyeksi" <?= $Page->lain_harga_sekunder_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_sekunder_proyeksi"><span id="el_npd_lain_harga_sekunder_proyeksi">
<span<?= $Page->lain_harga_sekunder_proyeksi->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
    <tr id="r_lain_harga_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_label"><template id="tpc_npd_lain_harga_label"><?= $Page->lain_harga_label->caption() ?></template></span></td>
        <td data-name="lain_harga_label" <?= $Page->lain_harga_label->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_label"><span id="el_npd_lain_harga_label">
<span<?= $Page->lain_harga_label->viewAttributes() ?>>
<?= $Page->lain_harga_label->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_label_proyeksi->Visible) { // lain_harga_label_proyeksi ?>
    <tr id="r_lain_harga_label_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_label_proyeksi"><template id="tpc_npd_lain_harga_label_proyeksi"><?= $Page->lain_harga_label_proyeksi->caption() ?></template></span></td>
        <td data-name="lain_harga_label_proyeksi" <?= $Page->lain_harga_label_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_label_proyeksi"><span id="el_npd_lain_harga_label_proyeksi">
<span<?= $Page->lain_harga_label_proyeksi->viewAttributes() ?>>
<?= $Page->lain_harga_label_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
    <tr id="r_lain_harga_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_total"><template id="tpc_npd_lain_harga_total"><?= $Page->lain_harga_total->caption() ?></template></span></td>
        <td data-name="lain_harga_total" <?= $Page->lain_harga_total->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_total"><span id="el_npd_lain_harga_total">
<span<?= $Page->lain_harga_total->viewAttributes() ?>>
<?= $Page->lain_harga_total->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lain_harga_total_proyeksi->Visible) { // lain_harga_total_proyeksi ?>
    <tr id="r_lain_harga_total_proyeksi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_lain_harga_total_proyeksi"><template id="tpc_npd_lain_harga_total_proyeksi"><?= $Page->lain_harga_total_proyeksi->caption() ?></template></span></td>
        <td data-name="lain_harga_total_proyeksi" <?= $Page->lain_harga_total_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_total_proyeksi"><span id="el_npd_lain_harga_total_proyeksi">
<span<?= $Page->lain_harga_total_proyeksi->viewAttributes() ?>>
<?= $Page->lain_harga_total_proyeksi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
    <tr id="r_delivery_pickup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_delivery_pickup"><template id="tpc_npd_delivery_pickup"><?= $Page->delivery_pickup->caption() ?></template></span></td>
        <td data-name="delivery_pickup" <?= $Page->delivery_pickup->cellAttributes() ?>>
<template id="tpx_npd_delivery_pickup"><span id="el_npd_delivery_pickup">
<span<?= $Page->delivery_pickup->viewAttributes() ?>>
<?= $Page->delivery_pickup->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
    <tr id="r_delivery_singlepoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_delivery_singlepoint"><template id="tpc_npd_delivery_singlepoint"><?= $Page->delivery_singlepoint->caption() ?></template></span></td>
        <td data-name="delivery_singlepoint" <?= $Page->delivery_singlepoint->cellAttributes() ?>>
<template id="tpx_npd_delivery_singlepoint"><span id="el_npd_delivery_singlepoint">
<span<?= $Page->delivery_singlepoint->viewAttributes() ?>>
<?= $Page->delivery_singlepoint->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
    <tr id="r_delivery_multipoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_delivery_multipoint"><template id="tpc_npd_delivery_multipoint"><?= $Page->delivery_multipoint->caption() ?></template></span></td>
        <td data-name="delivery_multipoint" <?= $Page->delivery_multipoint->cellAttributes() ?>>
<template id="tpx_npd_delivery_multipoint"><span id="el_npd_delivery_multipoint">
<span<?= $Page->delivery_multipoint->viewAttributes() ?>>
<?= $Page->delivery_multipoint->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->delivery_termlain->Visible) { // delivery_termlain ?>
    <tr id="r_delivery_termlain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_delivery_termlain"><template id="tpc_npd_delivery_termlain"><?= $Page->delivery_termlain->caption() ?></template></span></td>
        <td data-name="delivery_termlain" <?= $Page->delivery_termlain->cellAttributes() ?>>
<template id="tpx_npd_delivery_termlain"><span id="el_npd_delivery_termlain">
<span<?= $Page->delivery_termlain->viewAttributes() ?>>
<?= $Page->delivery_termlain->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_status"><template id="tpc_npd_status"><?= $Page->status->caption() ?></template></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<template id="tpx_npd_status"><span id="el_npd_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
    <tr id="r_receipt_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_receipt_by"><template id="tpc_npd_receipt_by"><?= $Page->receipt_by->caption() ?></template></span></td>
        <td data-name="receipt_by" <?= $Page->receipt_by->cellAttributes() ?>>
<template id="tpx_npd_receipt_by"><span id="el_npd_receipt_by">
<span<?= $Page->receipt_by->viewAttributes() ?>>
<?= $Page->receipt_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approve_by->Visible) { // approve_by ?>
    <tr id="r_approve_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_approve_by"><template id="tpc_npd_approve_by"><?= $Page->approve_by->caption() ?></template></span></td>
        <td data-name="approve_by" <?= $Page->approve_by->cellAttributes() ?>>
<template id="tpx_npd_approve_by"><span id="el_npd_approve_by">
<span<?= $Page->approve_by->viewAttributes() ?>>
<?= $Page->approve_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_created_at"><template id="tpc_npd_created_at"><?= $Page->created_at->caption() ?></template></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<template id="tpx_npd_created_at"><span id="el_npd_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_updated_at"><template id="tpc_npd_updated_at"><?= $Page->updated_at->caption() ?></template></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_updated_at"><span id="el_npd_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <tr id="r_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_selesai"><template id="tpc_npd_selesai"><?= $Page->selesai->caption() ?></template></span></td>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<template id="tpx_npd_selesai"><span id="el_npd_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<?= $Page->selesai->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_npdview" class="ew-custom-template"></div>
<template id="tpm_npdview">
<div id="ct_NpdView"><div class="card">
    <div class="card-body row">
        <div class="col-4">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-4"><?= $Page->kodeorder->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_kodeorder"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-4"><?= $Page->nomororder->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_nomororder"></slot></td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-4"><?= $Page->sifatorder->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_sifatorder"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-4"><?= $Page->status->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_status"></slot></td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-4"><?= $Page->tanggal_order->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_tanggal_order"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-4"><?= $Page->target_selesai->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_target_selesai"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->idpegawai->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_idpegawai"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->idcustomer->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_idcustomer"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->idbrand->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_idbrand"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KONSEP PRODUK</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->kategoriproduk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kategoriproduk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->jenisproduk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_jenisproduk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->fungsiproduk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_fungsiproduk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kualitasproduk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kualitasproduk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bahan_campaign->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_bahan_campaign"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">BENTUK SEDIAAN</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->ukuransediaan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_ukuransediaan"></slot> <slot class="ew-slot" name="tpx_npd_satuansediaan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bentuk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_bentuk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->viskositas->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_viskositas"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->warna->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_warna"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->parfum->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_parfum"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_aplikasi"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->estetika->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_estetika"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->tambahan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_tambahan"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KEMASAN PRIMER</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->ukurankemasan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_ukurankemasan"></slot> <slot class="ew-slot" name="tpx_npd_satuankemasan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kemasanwadah->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kemasanwadah"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kemasantutup->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kemasantutup"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kemasancatatan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kemasancatatan"></slot></td>
            </tr>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KEMASAN SEKUNDER</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
        	<tr>
                <th class="text-right w-col-3"><?= $Page->ukurankemasansekunder->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_ukurankemasansekunder"></slot> <slot class="ew-slot" name="tpx_npd_satuankemasansekunder"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kemasanbahan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kemasanbahan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kemasanbentuk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kemasanbentuk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kemasankomposisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kemasankomposisi"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kemasancatatansekunder->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_kemasancatatansekunder"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">LABEL STIKER</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->labelbahan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labelbahan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->labelkualitas->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labelkualitas"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->labelposisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labelposisi"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->labelcatatan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labelcatatan"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">LABEL HOT PRINT</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->labeltekstur->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labeltekstur"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->labelprint->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labelprint"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->labeljmlwarna->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labeljmlwarna"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->labelcatatanhotprint->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_labelcatatanhotprint"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">TARGET HARGA & PROYEKSI</div>
    </div>
    <div class="card-body row">
        <div class="col-6">
            <h5><?= $Page->ukuran_utama->caption() ?>: <slot class="ew-slot" name="tpx_npd_ukuran_utama"></slot></h5>
            <table class="table table-striped table-sm ew-view-table">
                <thead>
                    <tr>
                        <th class="text-center w-col-3">Target</th>
                        <th class="text-center w-col-3">Harga/Pcs</th>
                        <th class="text-center w-col-3">Proyeksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-right w-col-3">Harga Isi</th>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_isi"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_isi_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Kemasan Primer</th>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_primer"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_primer_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Kemasan Sekunder</th>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_sekunder"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_sekunder_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Label</th>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_label"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_label_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Total</th>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_total"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_utama_harga_total_proyeksi"></slot></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h5><?= $Page->ukuran_lain->caption() ?>: <slot class="ew-slot" name="tpx_npd_ukuran_lain"></slot></h5>
            <table class="table table-striped table-sm ew-view-table">
                <thead>
                    <tr>
                        <th class="text-center w-col-3">Target</th>
                        <th class="text-center w-col-3">Harga/Pcs</th>
                        <th class="text-center w-col-3">Proyeksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-right w-col-3">Harga Isi</th>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_isi"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_isi_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Kemasan Primer</th>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_primer"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_primer_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Kemasan Sekunder</th>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_sekunder"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_sekunder_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Label</th>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_label"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_label_proyeksi"></slot></td>
                    </tr>
                    <tr>
                        <th class="text-right w-col-3">Harga Total</th>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_total"></slot></td>
                        <td><slot class="ew-slot" name="tpx_npd_lain_harga_total_proyeksi"></slot></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">DELIVERY</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->delivery_pickup->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_delivery_pickup"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->delivery_singlepoint->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_delivery_singlepoint"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->delivery_multipoint->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_delivery_multipoint"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->delivery_termlain->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_delivery_termlain"></slot></td>
            </tr>
        </table>
    </div>
</div>
</div>
</template>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_sample") ?>" href="#tab_npd_sample" data-toggle="tab"><?= $Language->tablePhrase("npd_sample", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_sample")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_review") ?>" href="#tab_npd_review" data-toggle="tab"><?= $Language->tablePhrase("npd_review", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_review")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_confirmsample", explode(",", $Page->getCurrentDetailTable())) && $npd_confirmsample->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirmsample") {
            $firstActiveDetailTable = "npd_confirmsample";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_confirmsample") ?>" href="#tab_npd_confirmsample" data-toggle="tab"><?= $Language->tablePhrase("npd_confirmsample", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_confirmsample")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_harga") ?>" href="#tab_npd_harga" data-toggle="tab"><?= $Language->tablePhrase("npd_harga", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_harga")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_sample") ?>" id="tab_npd_sample"><!-- page* -->
<?php include_once "NpdSampleGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_review") ?>" id="tab_npd_review"><!-- page* -->
<?php include_once "NpdReviewGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_confirmsample", explode(",", $Page->getCurrentDetailTable())) && $npd_confirmsample->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirmsample") {
            $firstActiveDetailTable = "npd_confirmsample";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_confirmsample") ?>" id="tab_npd_confirmsample"><!-- page* -->
<?php include_once "NpdConfirmsampleGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_harga") ?>" id="tab_npd_harga"><!-- page* -->
<?php include_once "NpdHargaGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npdview", "tpm_npdview", "npdview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
