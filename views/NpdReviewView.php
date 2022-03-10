<?php

namespace PHPMaker2021\production2;

// Page object
$NpdReviewView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_reviewview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_reviewview = currentForm = new ew.Form("fnpd_reviewview", "view");
    loadjs.done("fnpd_reviewview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_review) ew.vars.tables.npd_review = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>;
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
<form name="fnpd_reviewview" id="fnpd_reviewview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_review">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_idnpd"><template id="tpc_npd_review_idnpd"><?= $Page->idnpd->caption() ?></template></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_review_idnpd"><span id="el_npd_review_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <tr id="r_idnpd_sample">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_idnpd_sample"><template id="tpc_npd_review_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></template></span></td>
        <td data-name="idnpd_sample" <?= $Page->idnpd_sample->cellAttributes() ?>>
<template id="tpx_npd_review_idnpd_sample"><span id="el_npd_review_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_review->Visible) { // tanggal_review ?>
    <tr id="r_tanggal_review">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tanggal_review"><template id="tpc_npd_review_tanggal_review"><?= $Page->tanggal_review->caption() ?></template></span></td>
        <td data-name="tanggal_review" <?= $Page->tanggal_review->cellAttributes() ?>>
<template id="tpx_npd_review_tanggal_review"><span id="el_npd_review_tanggal_review">
<span<?= $Page->tanggal_review->viewAttributes() ?>>
<?= $Page->tanggal_review->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
    <tr id="r_tanggal_submit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tanggal_submit"><template id="tpc_npd_review_tanggal_submit"><?= $Page->tanggal_submit->caption() ?></template></span></td>
        <td data-name="tanggal_submit" <?= $Page->tanggal_submit->cellAttributes() ?>>
<template id="tpx_npd_review_tanggal_submit"><span id="el_npd_review_tanggal_submit">
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->wadah->Visible) { // wadah ?>
    <tr id="r_wadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_wadah"><template id="tpc_npd_review_wadah"><?= $Page->wadah->caption() ?></template></span></td>
        <td data-name="wadah" <?= $Page->wadah->cellAttributes() ?>>
<template id="tpx_npd_review_wadah"><span id="el_npd_review_wadah">
<span<?= $Page->wadah->viewAttributes() ?>>
<?= $Page->wadah->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk_opsi->Visible) { // bentuk_opsi ?>
    <tr id="r_bentuk_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bentuk_opsi"><template id="tpc_npd_review_bentuk_opsi"><?= $Page->bentuk_opsi->caption() ?></template></span></td>
        <td data-name="bentuk_opsi" <?= $Page->bentuk_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_bentuk_opsi"><span id="el_npd_review_bentuk_opsi">
<span<?= $Page->bentuk_opsi->viewAttributes() ?>>
<?= $Page->bentuk_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk_revisi->Visible) { // bentuk_revisi ?>
    <tr id="r_bentuk_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bentuk_revisi"><template id="tpc_npd_review_bentuk_revisi"><?= $Page->bentuk_revisi->caption() ?></template></span></td>
        <td data-name="bentuk_revisi" <?= $Page->bentuk_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_bentuk_revisi"><span id="el_npd_review_bentuk_revisi">
<span<?= $Page->bentuk_revisi->viewAttributes() ?>>
<?= $Page->bentuk_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas_opsi->Visible) { // viskositas_opsi ?>
    <tr id="r_viskositas_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_viskositas_opsi"><template id="tpc_npd_review_viskositas_opsi"><?= $Page->viskositas_opsi->caption() ?></template></span></td>
        <td data-name="viskositas_opsi" <?= $Page->viskositas_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_viskositas_opsi"><span id="el_npd_review_viskositas_opsi">
<span<?= $Page->viskositas_opsi->viewAttributes() ?>>
<?= $Page->viskositas_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas_revisi->Visible) { // viskositas_revisi ?>
    <tr id="r_viskositas_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_viskositas_revisi"><template id="tpc_npd_review_viskositas_revisi"><?= $Page->viskositas_revisi->caption() ?></template></span></td>
        <td data-name="viskositas_revisi" <?= $Page->viskositas_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_viskositas_revisi"><span id="el_npd_review_viskositas_revisi">
<span<?= $Page->viskositas_revisi->viewAttributes() ?>>
<?= $Page->viskositas_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jeniswarna_opsi->Visible) { // jeniswarna_opsi ?>
    <tr id="r_jeniswarna_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_jeniswarna_opsi"><template id="tpc_npd_review_jeniswarna_opsi"><?= $Page->jeniswarna_opsi->caption() ?></template></span></td>
        <td data-name="jeniswarna_opsi" <?= $Page->jeniswarna_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_jeniswarna_opsi"><span id="el_npd_review_jeniswarna_opsi">
<span<?= $Page->jeniswarna_opsi->viewAttributes() ?>>
<?= $Page->jeniswarna_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jeniswarna_revisi->Visible) { // jeniswarna_revisi ?>
    <tr id="r_jeniswarna_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_jeniswarna_revisi"><template id="tpc_npd_review_jeniswarna_revisi"><?= $Page->jeniswarna_revisi->caption() ?></template></span></td>
        <td data-name="jeniswarna_revisi" <?= $Page->jeniswarna_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_jeniswarna_revisi"><span id="el_npd_review_jeniswarna_revisi">
<span<?= $Page->jeniswarna_revisi->viewAttributes() ?>>
<?= $Page->jeniswarna_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tonewarna_opsi->Visible) { // tonewarna_opsi ?>
    <tr id="r_tonewarna_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tonewarna_opsi"><template id="tpc_npd_review_tonewarna_opsi"><?= $Page->tonewarna_opsi->caption() ?></template></span></td>
        <td data-name="tonewarna_opsi" <?= $Page->tonewarna_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_tonewarna_opsi"><span id="el_npd_review_tonewarna_opsi">
<span<?= $Page->tonewarna_opsi->viewAttributes() ?>>
<?= $Page->tonewarna_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tonewarna_revisi->Visible) { // tonewarna_revisi ?>
    <tr id="r_tonewarna_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tonewarna_revisi"><template id="tpc_npd_review_tonewarna_revisi"><?= $Page->tonewarna_revisi->caption() ?></template></span></td>
        <td data-name="tonewarna_revisi" <?= $Page->tonewarna_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_tonewarna_revisi"><span id="el_npd_review_tonewarna_revisi">
<span<?= $Page->tonewarna_revisi->viewAttributes() ?>>
<?= $Page->tonewarna_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gradasiwarna_opsi->Visible) { // gradasiwarna_opsi ?>
    <tr id="r_gradasiwarna_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_gradasiwarna_opsi"><template id="tpc_npd_review_gradasiwarna_opsi"><?= $Page->gradasiwarna_opsi->caption() ?></template></span></td>
        <td data-name="gradasiwarna_opsi" <?= $Page->gradasiwarna_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_gradasiwarna_opsi"><span id="el_npd_review_gradasiwarna_opsi">
<span<?= $Page->gradasiwarna_opsi->viewAttributes() ?>>
<?= $Page->gradasiwarna_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gradasiwarna_revisi->Visible) { // gradasiwarna_revisi ?>
    <tr id="r_gradasiwarna_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_gradasiwarna_revisi"><template id="tpc_npd_review_gradasiwarna_revisi"><?= $Page->gradasiwarna_revisi->caption() ?></template></span></td>
        <td data-name="gradasiwarna_revisi" <?= $Page->gradasiwarna_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_gradasiwarna_revisi"><span id="el_npd_review_gradasiwarna_revisi">
<span<?= $Page->gradasiwarna_revisi->viewAttributes() ?>>
<?= $Page->gradasiwarna_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bauparfum_opsi->Visible) { // bauparfum_opsi ?>
    <tr id="r_bauparfum_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bauparfum_opsi"><template id="tpc_npd_review_bauparfum_opsi"><?= $Page->bauparfum_opsi->caption() ?></template></span></td>
        <td data-name="bauparfum_opsi" <?= $Page->bauparfum_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_bauparfum_opsi"><span id="el_npd_review_bauparfum_opsi">
<span<?= $Page->bauparfum_opsi->viewAttributes() ?>>
<?= $Page->bauparfum_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bauparfum_revisi->Visible) { // bauparfum_revisi ?>
    <tr id="r_bauparfum_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bauparfum_revisi"><template id="tpc_npd_review_bauparfum_revisi"><?= $Page->bauparfum_revisi->caption() ?></template></span></td>
        <td data-name="bauparfum_revisi" <?= $Page->bauparfum_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_bauparfum_revisi"><span id="el_npd_review_bauparfum_revisi">
<span<?= $Page->bauparfum_revisi->viewAttributes() ?>>
<?= $Page->bauparfum_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetika_opsi->Visible) { // estetika_opsi ?>
    <tr id="r_estetika_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_estetika_opsi"><template id="tpc_npd_review_estetika_opsi"><?= $Page->estetika_opsi->caption() ?></template></span></td>
        <td data-name="estetika_opsi" <?= $Page->estetika_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_estetika_opsi"><span id="el_npd_review_estetika_opsi">
<span<?= $Page->estetika_opsi->viewAttributes() ?>>
<?= $Page->estetika_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetika_revisi->Visible) { // estetika_revisi ?>
    <tr id="r_estetika_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_estetika_revisi"><template id="tpc_npd_review_estetika_revisi"><?= $Page->estetika_revisi->caption() ?></template></span></td>
        <td data-name="estetika_revisi" <?= $Page->estetika_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_estetika_revisi"><span id="el_npd_review_estetika_revisi">
<span<?= $Page->estetika_revisi->viewAttributes() ?>>
<?= $Page->estetika_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiawal_opsi->Visible) { // aplikasiawal_opsi ?>
    <tr id="r_aplikasiawal_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasiawal_opsi"><template id="tpc_npd_review_aplikasiawal_opsi"><?= $Page->aplikasiawal_opsi->caption() ?></template></span></td>
        <td data-name="aplikasiawal_opsi" <?= $Page->aplikasiawal_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasiawal_opsi"><span id="el_npd_review_aplikasiawal_opsi">
<span<?= $Page->aplikasiawal_opsi->viewAttributes() ?>>
<?= $Page->aplikasiawal_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiawal_revisi->Visible) { // aplikasiawal_revisi ?>
    <tr id="r_aplikasiawal_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasiawal_revisi"><template id="tpc_npd_review_aplikasiawal_revisi"><?= $Page->aplikasiawal_revisi->caption() ?></template></span></td>
        <td data-name="aplikasiawal_revisi" <?= $Page->aplikasiawal_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasiawal_revisi"><span id="el_npd_review_aplikasiawal_revisi">
<span<?= $Page->aplikasiawal_revisi->viewAttributes() ?>>
<?= $Page->aplikasiawal_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasilama_opsi->Visible) { // aplikasilama_opsi ?>
    <tr id="r_aplikasilama_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasilama_opsi"><template id="tpc_npd_review_aplikasilama_opsi"><?= $Page->aplikasilama_opsi->caption() ?></template></span></td>
        <td data-name="aplikasilama_opsi" <?= $Page->aplikasilama_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasilama_opsi"><span id="el_npd_review_aplikasilama_opsi">
<span<?= $Page->aplikasilama_opsi->viewAttributes() ?>>
<?= $Page->aplikasilama_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasilama_revisi->Visible) { // aplikasilama_revisi ?>
    <tr id="r_aplikasilama_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasilama_revisi"><template id="tpc_npd_review_aplikasilama_revisi"><?= $Page->aplikasilama_revisi->caption() ?></template></span></td>
        <td data-name="aplikasilama_revisi" <?= $Page->aplikasilama_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasilama_revisi"><span id="el_npd_review_aplikasilama_revisi">
<span<?= $Page->aplikasilama_revisi->viewAttributes() ?>>
<?= $Page->aplikasilama_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efekpositif_opsi->Visible) { // efekpositif_opsi ?>
    <tr id="r_efekpositif_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efekpositif_opsi"><template id="tpc_npd_review_efekpositif_opsi"><?= $Page->efekpositif_opsi->caption() ?></template></span></td>
        <td data-name="efekpositif_opsi" <?= $Page->efekpositif_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_efekpositif_opsi"><span id="el_npd_review_efekpositif_opsi">
<span<?= $Page->efekpositif_opsi->viewAttributes() ?>>
<?= $Page->efekpositif_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efekpositif_revisi->Visible) { // efekpositif_revisi ?>
    <tr id="r_efekpositif_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efekpositif_revisi"><template id="tpc_npd_review_efekpositif_revisi"><?= $Page->efekpositif_revisi->caption() ?></template></span></td>
        <td data-name="efekpositif_revisi" <?= $Page->efekpositif_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_efekpositif_revisi"><span id="el_npd_review_efekpositif_revisi">
<span<?= $Page->efekpositif_revisi->viewAttributes() ?>>
<?= $Page->efekpositif_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeknegatif_opsi->Visible) { // efeknegatif_opsi ?>
    <tr id="r_efeknegatif_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efeknegatif_opsi"><template id="tpc_npd_review_efeknegatif_opsi"><?= $Page->efeknegatif_opsi->caption() ?></template></span></td>
        <td data-name="efeknegatif_opsi" <?= $Page->efeknegatif_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_efeknegatif_opsi"><span id="el_npd_review_efeknegatif_opsi">
<span<?= $Page->efeknegatif_opsi->viewAttributes() ?>>
<?= $Page->efeknegatif_opsi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeknegatif_revisi->Visible) { // efeknegatif_revisi ?>
    <tr id="r_efeknegatif_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efeknegatif_revisi"><template id="tpc_npd_review_efeknegatif_revisi"><?= $Page->efeknegatif_revisi->caption() ?></template></span></td>
        <td data-name="efeknegatif_revisi" <?= $Page->efeknegatif_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_efeknegatif_revisi"><span id="el_npd_review_efeknegatif_revisi">
<span<?= $Page->efeknegatif_revisi->viewAttributes() ?>>
<?= $Page->efeknegatif_revisi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kesimpulan->Visible) { // kesimpulan ?>
    <tr id="r_kesimpulan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_kesimpulan"><template id="tpc_npd_review_kesimpulan"><?= $Page->kesimpulan->caption() ?></template></span></td>
        <td data-name="kesimpulan" <?= $Page->kesimpulan->cellAttributes() ?>>
<template id="tpx_npd_review_kesimpulan"><span id="el_npd_review_kesimpulan">
<span<?= $Page->kesimpulan->viewAttributes() ?>>
<?= $Page->kesimpulan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_status"><template id="tpc_npd_review_status"><?= $Page->status->caption() ?></template></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<template id="tpx_npd_review_status"><span id="el_npd_review_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->review_by->Visible) { // review_by ?>
    <tr id="r_review_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_review_by"><template id="tpc_npd_review_review_by"><?= $Page->review_by->caption() ?></template></span></td>
        <td data-name="review_by" <?= $Page->review_by->cellAttributes() ?>>
<template id="tpx_npd_review_review_by"><span id="el_npd_review_review_by">
<span<?= $Page->review_by->viewAttributes() ?>>
<?= $Page->review_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
    <tr id="r_receipt_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_receipt_by"><template id="tpc_npd_review_receipt_by"><?= $Page->receipt_by->caption() ?></template></span></td>
        <td data-name="receipt_by" <?= $Page->receipt_by->cellAttributes() ?>>
<template id="tpx_npd_review_receipt_by"><span id="el_npd_review_receipt_by">
<span<?= $Page->receipt_by->viewAttributes() ?>>
<?= $Page->receipt_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <tr id="r_checked_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_checked_by"><template id="tpc_npd_review_checked_by"><?= $Page->checked_by->caption() ?></template></span></td>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<template id="tpx_npd_review_checked_by"><span id="el_npd_review_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_npd_reviewview" class="ew-custom-template"></div>
<template id="tpm_npd_reviewview">
<div id="ct_NpdReviewView"><div class="card">
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idnpd->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_idnpd"></slot></td>
                </tr>
                <tr>
                    <th class="text-right">Nomor Order</th>
                    <td><?php echo ExecuteScalar("SELECT nomororder FROM npd WHERE id = {$Page->idnpd->CurrentValue}") ?></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->status->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_status"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->review_by->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_review_by"></slot></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tanggal_review->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_tanggal_review"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tanggal_submit->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_tanggal_submit"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->receipt_by->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_receipt_by"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->checked_by->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_checked_by"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">DATA SAMPEL</div>
    </div>
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idnpd_sample->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_idnpd_sample"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3">Nama Produk</th>
                    <td><?php echo ExecuteScalar("SELECT nama FROM npd_sample WHERE id = {$Page->idnpd_sample->CurrentValue}") ?></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3">Volume</th>
                    <td><?php echo ExecuteScalar("SELECT volume FROM npd_sample WHERE id = {$Page->idnpd_sample->CurrentValue}") ?></td>
                </div>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->wadah->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_review_wadah"></slot></td>
                </div>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">REVIEW SEDIAAN</div>
    </div>
    <div class="card-body row">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->bentuk_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_bentuk_opsi"></slot></td>
            </tr>
            <?php if ($Page->bentuk_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bentuk_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_bentuk_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->viskositas_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_viskositas_opsi"></slot></td>
            </tr>
            <?php if ($Page->viskositas_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->viskositas_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_viskositas_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->jeniswarna_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_jeniswarna_opsi"></slot></td>
            </tr>
            <?php if ($Page->jeniswarna_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->jeniswarna_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_jeniswarna_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->tonewarna_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_tonewarna_opsi"></slot></td>
            </tr>
            <?php if ($Page->tonewarna_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->tonewarna_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_tonewarna_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->gradasiwarna_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_gradasiwarna_opsi"></slot></td>
            </tr>
            <?php if ($Page->gradasiwarna_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->gradasiwarna_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_gradasiwarna_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bauparfum_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_bauparfum_opsi"></slot></td>
            </tr>
            <?php if ($Page->bauparfum_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bauparfum_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_bauparfum_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->estetika_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_estetika_opsi"></slot></td>
            </tr>
            <?php if ($Page->estetika_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->estetika_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_estetika_revisi"></slot></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">REVIEW KUALITAS</div>
    </div>
    <div class="card-body row">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasiawal_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_aplikasiawal_opsi"></slot></td>
            </tr>
            <?php if ($Page->aplikasiawal_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasiawal_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_aplikasiawal_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasilama_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_aplikasilama_opsi"></slot></td>
            </tr>
            <?php if ($Page->aplikasilama_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasilama_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_aplikasilama_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->efekpositif_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_efekpositif_opsi"></slot></td>
            </tr>
            <?php if ($Page->efekpositif_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->efekpositif_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_efekpositif_revisi"></slot></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->efeknegatif_opsi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_efeknegatif_opsi"></slot></td>
            </tr>
            <?php if ($Page->efeknegatif_opsi->CurrentValue < 1): ?>
            <tr>
                <th class="text-right w-col-3"><?= $Page->efeknegatif_revisi->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_efeknegatif_revisi"></slot></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KESIMPULAN &amp; Saran</div>
    </div>
    <div class="card-body row">
        <table class="table table-sm table-striped ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->kesimpulan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_review_kesimpulan"></slot></td>
            </tr>
        </table>
    </div>
</div>
</div>
</template>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npd_reviewview", "tpm_npd_reviewview", "npd_reviewview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
