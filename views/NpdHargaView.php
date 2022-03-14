<?php

namespace PHPMaker2021\production2;

// Page object
$NpdHargaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_hargaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_hargaview = currentForm = new ew.Form("fnpd_hargaview", "view");
    loadjs.done("fnpd_hargaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_harga) ew.vars.tables.npd_harga = <?= JsonEncode(GetClientVar("tables", "npd_harga")) ?>;
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
<form name="fnpd_hargaview" id="fnpd_hargaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_harga">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_idnpd"><template id="tpc_npd_harga_idnpd"><?= $Page->idnpd->caption() ?></template></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_harga_idnpd"><span id="el_npd_harga_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
    <tr id="r_tglpengajuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_tglpengajuan"><template id="tpc_npd_harga_tglpengajuan"><?= $Page->tglpengajuan->caption() ?></template></span></td>
        <td data-name="tglpengajuan" <?= $Page->tglpengajuan->cellAttributes() ?>>
<template id="tpx_npd_harga_tglpengajuan"><span id="el_npd_harga_tglpengajuan">
<span<?= $Page->tglpengajuan->viewAttributes() ?>>
<?= $Page->tglpengajuan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <tr id="r_idnpd_sample">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_idnpd_sample"><template id="tpc_npd_harga_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></template></span></td>
        <td data-name="idnpd_sample" <?= $Page->idnpd_sample->cellAttributes() ?>>
<template id="tpx_npd_harga_idnpd_sample"><span id="el_npd_harga_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_nama"><template id="tpc_npd_harga_nama"><?= $Page->nama->caption() ?></template></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<template id="tpx_npd_harga_nama"><span id="el_npd_harga_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <tr id="r_bentuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bentuk"><template id="tpc_npd_harga_bentuk"><?= $Page->bentuk->caption() ?></template></span></td>
        <td data-name="bentuk" <?= $Page->bentuk->cellAttributes() ?>>
<template id="tpx_npd_harga_bentuk"><span id="el_npd_harga_bentuk">
<span<?= $Page->bentuk->viewAttributes() ?>>
<?= $Page->bentuk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <tr id="r_viskositas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_viskositas"><template id="tpc_npd_harga_viskositas"><?= $Page->viskositas->caption() ?></template></span></td>
        <td data-name="viskositas" <?= $Page->viskositas->cellAttributes() ?>>
<template id="tpx_npd_harga_viskositas"><span id="el_npd_harga_viskositas">
<span<?= $Page->viskositas->viewAttributes() ?>>
<?= $Page->viskositas->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasisediaan->Visible) { // aplikasisediaan ?>
    <tr id="r_aplikasisediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_aplikasisediaan"><template id="tpc_npd_harga_aplikasisediaan"><?= $Page->aplikasisediaan->caption() ?></template></span></td>
        <td data-name="aplikasisediaan" <?= $Page->aplikasisediaan->cellAttributes() ?>>
<template id="tpx_npd_harga_aplikasisediaan"><span id="el_npd_harga_aplikasisediaan">
<span<?= $Page->aplikasisediaan->viewAttributes() ?>>
<?= $Page->aplikasisediaan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <tr id="r_volume">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_volume"><template id="tpc_npd_harga_volume"><?= $Page->volume->caption() ?></template></span></td>
        <td data-name="volume" <?= $Page->volume->cellAttributes() ?>>
<template id="tpx_npd_harga_volume"><span id="el_npd_harga_volume">
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <tr id="r_bahanaktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bahanaktif"><template id="tpc_npd_harga_bahanaktif"><?= $Page->bahanaktif->caption() ?></template></span></td>
        <td data-name="bahanaktif" <?= $Page->bahanaktif->cellAttributes() ?>>
<template id="tpx_npd_harga_bahanaktif"><span id="el_npd_harga_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->volumewadah->Visible) { // volumewadah ?>
    <tr id="r_volumewadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_volumewadah"><template id="tpc_npd_harga_volumewadah"><?= $Page->volumewadah->caption() ?></template></span></td>
        <td data-name="volumewadah" <?= $Page->volumewadah->cellAttributes() ?>>
<template id="tpx_npd_harga_volumewadah"><span id="el_npd_harga_volumewadah">
<span<?= $Page->volumewadah->viewAttributes() ?>>
<?= $Page->volumewadah->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahanwadah->Visible) { // bahanwadah ?>
    <tr id="r_bahanwadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bahanwadah"><template id="tpc_npd_harga_bahanwadah"><?= $Page->bahanwadah->caption() ?></template></span></td>
        <td data-name="bahanwadah" <?= $Page->bahanwadah->cellAttributes() ?>>
<template id="tpx_npd_harga_bahanwadah"><span id="el_npd_harga_bahanwadah">
<span<?= $Page->bahanwadah->viewAttributes() ?>>
<?= $Page->bahanwadah->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warnawadah->Visible) { // warnawadah ?>
    <tr id="r_warnawadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_warnawadah"><template id="tpc_npd_harga_warnawadah"><?= $Page->warnawadah->caption() ?></template></span></td>
        <td data-name="warnawadah" <?= $Page->warnawadah->cellAttributes() ?>>
<template id="tpx_npd_harga_warnawadah"><span id="el_npd_harga_warnawadah">
<span<?= $Page->warnawadah->viewAttributes() ?>>
<?= $Page->warnawadah->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentukwadah->Visible) { // bentukwadah ?>
    <tr id="r_bentukwadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bentukwadah"><template id="tpc_npd_harga_bentukwadah"><?= $Page->bentukwadah->caption() ?></template></span></td>
        <td data-name="bentukwadah" <?= $Page->bentukwadah->cellAttributes() ?>>
<template id="tpx_npd_harga_bentukwadah"><span id="el_npd_harga_bentukwadah">
<span<?= $Page->bentukwadah->viewAttributes() ?>>
<?= $Page->bentukwadah->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
    <tr id="r_jenistutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_jenistutup"><template id="tpc_npd_harga_jenistutup"><?= $Page->jenistutup->caption() ?></template></span></td>
        <td data-name="jenistutup" <?= $Page->jenistutup->cellAttributes() ?>>
<template id="tpx_npd_harga_jenistutup"><span id="el_npd_harga_jenistutup">
<span<?= $Page->jenistutup->viewAttributes() ?>>
<?= $Page->jenistutup->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahantutup->Visible) { // bahantutup ?>
    <tr id="r_bahantutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bahantutup"><template id="tpc_npd_harga_bahantutup"><?= $Page->bahantutup->caption() ?></template></span></td>
        <td data-name="bahantutup" <?= $Page->bahantutup->cellAttributes() ?>>
<template id="tpx_npd_harga_bahantutup"><span id="el_npd_harga_bahantutup">
<span<?= $Page->bahantutup->viewAttributes() ?>>
<?= $Page->bahantutup->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warnatutup->Visible) { // warnatutup ?>
    <tr id="r_warnatutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_warnatutup"><template id="tpc_npd_harga_warnatutup"><?= $Page->warnatutup->caption() ?></template></span></td>
        <td data-name="warnatutup" <?= $Page->warnatutup->cellAttributes() ?>>
<template id="tpx_npd_harga_warnatutup"><span id="el_npd_harga_warnatutup">
<span<?= $Page->warnatutup->viewAttributes() ?>>
<?= $Page->warnatutup->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuktutup->Visible) { // bentuktutup ?>
    <tr id="r_bentuktutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bentuktutup"><template id="tpc_npd_harga_bentuktutup"><?= $Page->bentuktutup->caption() ?></template></span></td>
        <td data-name="bentuktutup" <?= $Page->bentuktutup->cellAttributes() ?>>
<template id="tpx_npd_harga_bentuktutup"><span id="el_npd_harga_bentuktutup">
<span<?= $Page->bentuktutup->viewAttributes() ?>>
<?= $Page->bentuktutup->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->segel->Visible) { // segel ?>
    <tr id="r_segel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_segel"><template id="tpc_npd_harga_segel"><?= $Page->segel->caption() ?></template></span></td>
        <td data-name="segel" <?= $Page->segel->cellAttributes() ?>>
<template id="tpx_npd_harga_segel"><span id="el_npd_harga_segel">
<span<?= $Page->segel->viewAttributes() ?>>
<?= $Page->segel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatanprimer->Visible) { // catatanprimer ?>
    <tr id="r_catatanprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_catatanprimer"><template id="tpc_npd_harga_catatanprimer"><?= $Page->catatanprimer->caption() ?></template></span></td>
        <td data-name="catatanprimer" <?= $Page->catatanprimer->cellAttributes() ?>>
<template id="tpx_npd_harga_catatanprimer"><span id="el_npd_harga_catatanprimer">
<span<?= $Page->catatanprimer->viewAttributes() ?>>
<?= $Page->catatanprimer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->packingproduk->Visible) { // packingproduk ?>
    <tr id="r_packingproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_packingproduk"><template id="tpc_npd_harga_packingproduk"><?= $Page->packingproduk->caption() ?></template></span></td>
        <td data-name="packingproduk" <?= $Page->packingproduk->cellAttributes() ?>>
<template id="tpx_npd_harga_packingproduk"><span id="el_npd_harga_packingproduk">
<span<?= $Page->packingproduk->viewAttributes() ?>>
<?= $Page->packingproduk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganpacking->Visible) { // keteranganpacking ?>
    <tr id="r_keteranganpacking">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganpacking"><template id="tpc_npd_harga_keteranganpacking"><?= $Page->keteranganpacking->caption() ?></template></span></td>
        <td data-name="keteranganpacking" <?= $Page->keteranganpacking->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganpacking"><span id="el_npd_harga_keteranganpacking">
<span<?= $Page->keteranganpacking->viewAttributes() ?>>
<?= $Page->keteranganpacking->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->beltkarton->Visible) { // beltkarton ?>
    <tr id="r_beltkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_beltkarton"><template id="tpc_npd_harga_beltkarton"><?= $Page->beltkarton->caption() ?></template></span></td>
        <td data-name="beltkarton" <?= $Page->beltkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_beltkarton"><span id="el_npd_harga_beltkarton">
<span<?= $Page->beltkarton->viewAttributes() ?>>
<?= $Page->beltkarton->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganbelt->Visible) { // keteranganbelt ?>
    <tr id="r_keteranganbelt">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganbelt"><template id="tpc_npd_harga_keteranganbelt"><?= $Page->keteranganbelt->caption() ?></template></span></td>
        <td data-name="keteranganbelt" <?= $Page->keteranganbelt->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganbelt"><span id="el_npd_harga_keteranganbelt">
<span<?= $Page->keteranganbelt->viewAttributes() ?>>
<?= $Page->keteranganbelt->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kartonluar->Visible) { // kartonluar ?>
    <tr id="r_kartonluar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kartonluar"><template id="tpc_npd_harga_kartonluar"><?= $Page->kartonluar->caption() ?></template></span></td>
        <td data-name="kartonluar" <?= $Page->kartonluar->cellAttributes() ?>>
<template id="tpx_npd_harga_kartonluar"><span id="el_npd_harga_kartonluar">
<span<?= $Page->kartonluar->viewAttributes() ?>>
<?= $Page->kartonluar->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bariskarton->Visible) { // bariskarton ?>
    <tr id="r_bariskarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bariskarton"><template id="tpc_npd_harga_bariskarton"><?= $Page->bariskarton->caption() ?></template></span></td>
        <td data-name="bariskarton" <?= $Page->bariskarton->cellAttributes() ?>>
<template id="tpx_npd_harga_bariskarton"><span id="el_npd_harga_bariskarton">
<span<?= $Page->bariskarton->viewAttributes() ?>>
<?= $Page->bariskarton->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kolomkarton->Visible) { // kolomkarton ?>
    <tr id="r_kolomkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kolomkarton"><template id="tpc_npd_harga_kolomkarton"><?= $Page->kolomkarton->caption() ?></template></span></td>
        <td data-name="kolomkarton" <?= $Page->kolomkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_kolomkarton"><span id="el_npd_harga_kolomkarton">
<span<?= $Page->kolomkarton->viewAttributes() ?>>
<?= $Page->kolomkarton->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->stackkarton->Visible) { // stackkarton ?>
    <tr id="r_stackkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_stackkarton"><template id="tpc_npd_harga_stackkarton"><?= $Page->stackkarton->caption() ?></template></span></td>
        <td data-name="stackkarton" <?= $Page->stackkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_stackkarton"><span id="el_npd_harga_stackkarton">
<span<?= $Page->stackkarton->viewAttributes() ?>>
<?= $Page->stackkarton->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isikarton->Visible) { // isikarton ?>
    <tr id="r_isikarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_isikarton"><template id="tpc_npd_harga_isikarton"><?= $Page->isikarton->caption() ?></template></span></td>
        <td data-name="isikarton" <?= $Page->isikarton->cellAttributes() ?>>
<template id="tpx_npd_harga_isikarton"><span id="el_npd_harga_isikarton">
<span<?= $Page->isikarton->viewAttributes() ?>>
<?= $Page->isikarton->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenislabel->Visible) { // jenislabel ?>
    <tr id="r_jenislabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_jenislabel"><template id="tpc_npd_harga_jenislabel"><?= $Page->jenislabel->caption() ?></template></span></td>
        <td data-name="jenislabel" <?= $Page->jenislabel->cellAttributes() ?>>
<template id="tpx_npd_harga_jenislabel"><span id="el_npd_harga_jenislabel">
<span<?= $Page->jenislabel->viewAttributes() ?>>
<?= $Page->jenislabel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganjenislabel->Visible) { // keteranganjenislabel ?>
    <tr id="r_keteranganjenislabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganjenislabel"><template id="tpc_npd_harga_keteranganjenislabel"><?= $Page->keteranganjenislabel->caption() ?></template></span></td>
        <td data-name="keteranganjenislabel" <?= $Page->keteranganjenislabel->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganjenislabel"><span id="el_npd_harga_keteranganjenislabel">
<span<?= $Page->keteranganjenislabel->viewAttributes() ?>>
<?= $Page->keteranganjenislabel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kualitaslabel->Visible) { // kualitaslabel ?>
    <tr id="r_kualitaslabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kualitaslabel"><template id="tpc_npd_harga_kualitaslabel"><?= $Page->kualitaslabel->caption() ?></template></span></td>
        <td data-name="kualitaslabel" <?= $Page->kualitaslabel->cellAttributes() ?>>
<template id="tpx_npd_harga_kualitaslabel"><span id="el_npd_harga_kualitaslabel">
<span<?= $Page->kualitaslabel->viewAttributes() ?>>
<?= $Page->kualitaslabel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahwarnalabel->Visible) { // jumlahwarnalabel ?>
    <tr id="r_jumlahwarnalabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_jumlahwarnalabel"><template id="tpc_npd_harga_jumlahwarnalabel"><?= $Page->jumlahwarnalabel->caption() ?></template></span></td>
        <td data-name="jumlahwarnalabel" <?= $Page->jumlahwarnalabel->cellAttributes() ?>>
<template id="tpx_npd_harga_jumlahwarnalabel"><span id="el_npd_harga_jumlahwarnalabel">
<span<?= $Page->jumlahwarnalabel->viewAttributes() ?>>
<?= $Page->jumlahwarnalabel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->metaliklabel->Visible) { // metaliklabel ?>
    <tr id="r_metaliklabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_metaliklabel"><template id="tpc_npd_harga_metaliklabel"><?= $Page->metaliklabel->caption() ?></template></span></td>
        <td data-name="metaliklabel" <?= $Page->metaliklabel->cellAttributes() ?>>
<template id="tpx_npd_harga_metaliklabel"><span id="el_npd_harga_metaliklabel">
<span<?= $Page->metaliklabel->viewAttributes() ?>>
<?= $Page->metaliklabel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->etiketlabel->Visible) { // etiketlabel ?>
    <tr id="r_etiketlabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_etiketlabel"><template id="tpc_npd_harga_etiketlabel"><?= $Page->etiketlabel->caption() ?></template></span></td>
        <td data-name="etiketlabel" <?= $Page->etiketlabel->cellAttributes() ?>>
<template id="tpx_npd_harga_etiketlabel"><span id="el_npd_harga_etiketlabel">
<span<?= $Page->etiketlabel->viewAttributes() ?>>
<?= $Page->etiketlabel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganlabel->Visible) { // keteranganlabel ?>
    <tr id="r_keteranganlabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganlabel"><template id="tpc_npd_harga_keteranganlabel"><?= $Page->keteranganlabel->caption() ?></template></span></td>
        <td data-name="keteranganlabel" <?= $Page->keteranganlabel->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganlabel"><span id="el_npd_harga_keteranganlabel">
<span<?= $Page->keteranganlabel->viewAttributes() ?>>
<?= $Page->keteranganlabel->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategoridelivery->Visible) { // kategoridelivery ?>
    <tr id="r_kategoridelivery">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kategoridelivery"><template id="tpc_npd_harga_kategoridelivery"><?= $Page->kategoridelivery->caption() ?></template></span></td>
        <td data-name="kategoridelivery" <?= $Page->kategoridelivery->cellAttributes() ?>>
<template id="tpx_npd_harga_kategoridelivery"><span id="el_npd_harga_kategoridelivery">
<span<?= $Page->kategoridelivery->viewAttributes() ?>>
<?= $Page->kategoridelivery->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamatpengiriman->Visible) { // alamatpengiriman ?>
    <tr id="r_alamatpengiriman">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_alamatpengiriman"><template id="tpc_npd_harga_alamatpengiriman"><?= $Page->alamatpengiriman->caption() ?></template></span></td>
        <td data-name="alamatpengiriman" <?= $Page->alamatpengiriman->cellAttributes() ?>>
<template id="tpx_npd_harga_alamatpengiriman"><span id="el_npd_harga_alamatpengiriman">
<span<?= $Page->alamatpengiriman->viewAttributes() ?>>
<?= $Page->alamatpengiriman->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
    <tr id="r_orderperdana">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_orderperdana"><template id="tpc_npd_harga_orderperdana"><?= $Page->orderperdana->caption() ?></template></span></td>
        <td data-name="orderperdana" <?= $Page->orderperdana->cellAttributes() ?>>
<template id="tpx_npd_harga_orderperdana"><span id="el_npd_harga_orderperdana">
<span<?= $Page->orderperdana->viewAttributes() ?>>
<?= $Page->orderperdana->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderkontrak->Visible) { // orderkontrak ?>
    <tr id="r_orderkontrak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_orderkontrak"><template id="tpc_npd_harga_orderkontrak"><?= $Page->orderkontrak->caption() ?></template></span></td>
        <td data-name="orderkontrak" <?= $Page->orderkontrak->cellAttributes() ?>>
<template id="tpx_npd_harga_orderkontrak"><span id="el_npd_harga_orderkontrak">
<span<?= $Page->orderkontrak->viewAttributes() ?>>
<?= $Page->orderkontrak->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hargaperpcs->Visible) { // hargaperpcs ?>
    <tr id="r_hargaperpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_hargaperpcs"><template id="tpc_npd_harga_hargaperpcs"><?= $Page->hargaperpcs->caption() ?></template></span></td>
        <td data-name="hargaperpcs" <?= $Page->hargaperpcs->cellAttributes() ?>>
<template id="tpx_npd_harga_hargaperpcs"><span id="el_npd_harga_hargaperpcs">
<span<?= $Page->hargaperpcs->viewAttributes() ?>>
<?= $Page->hargaperpcs->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hargaperkarton->Visible) { // hargaperkarton ?>
    <tr id="r_hargaperkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_hargaperkarton"><template id="tpc_npd_harga_hargaperkarton"><?= $Page->hargaperkarton->caption() ?></template></span></td>
        <td data-name="hargaperkarton" <?= $Page->hargaperkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_hargaperkarton"><span id="el_npd_harga_hargaperkarton">
<span<?= $Page->hargaperkarton->viewAttributes() ?>>
<?= $Page->hargaperkarton->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <tr id="r_lampiran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_lampiran"><template id="tpc_npd_harga_lampiran"><?= $Page->lampiran->caption() ?></template></span></td>
        <td data-name="lampiran" <?= $Page->lampiran->cellAttributes() ?>>
<template id="tpx_npd_harga_lampiran"><span id="el_npd_harga_lampiran">
<span<?= $Page->lampiran->viewAttributes() ?>>
<?= GetFileViewTag($Page->lampiran, $Page->lampiran->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->prepared_by->Visible) { // prepared_by ?>
    <tr id="r_prepared_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_prepared_by"><template id="tpc_npd_harga_prepared_by"><?= $Page->prepared_by->caption() ?></template></span></td>
        <td data-name="prepared_by" <?= $Page->prepared_by->cellAttributes() ?>>
<template id="tpx_npd_harga_prepared_by"><span id="el_npd_harga_prepared_by">
<span<?= $Page->prepared_by->viewAttributes() ?>>
<?= $Page->prepared_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <tr id="r_checked_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_checked_by"><template id="tpc_npd_harga_checked_by"><?= $Page->checked_by->caption() ?></template></span></td>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<template id="tpx_npd_harga_checked_by"><span id="el_npd_harga_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_approved_by"><template id="tpc_npd_harga_approved_by"><?= $Page->approved_by->caption() ?></template></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_harga_approved_by"><span id="el_npd_harga_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_date->Visible) { // approved_date ?>
    <tr id="r_approved_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_approved_date"><template id="tpc_npd_harga_approved_date"><?= $Page->approved_date->caption() ?></template></span></td>
        <td data-name="approved_date" <?= $Page->approved_date->cellAttributes() ?>>
<template id="tpx_npd_harga_approved_date"><span id="el_npd_harga_approved_date">
<span<?= $Page->approved_date->viewAttributes() ?>>
<?= $Page->approved_date->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
    <tr id="r_disetujui">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_disetujui"><template id="tpc_npd_harga_disetujui"><?= $Page->disetujui->caption() ?></template></span></td>
        <td data-name="disetujui" <?= $Page->disetujui->cellAttributes() ?>>
<template id="tpx_npd_harga_disetujui"><span id="el_npd_harga_disetujui">
<span<?= $Page->disetujui->viewAttributes() ?>>
<?= $Page->disetujui->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_updated_at"><template id="tpc_npd_harga_updated_at"><?= $Page->updated_at->caption() ?></template></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_harga_updated_at"><span id="el_npd_harga_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_npd_hargaview" class="ew-custom-template"></div>
<template id="tpm_npd_hargaview">
<div id="ct_NpdHargaView"><div class="card">
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
            	<tr>
                    <th class="text-right w-col-3"><?= $Page->idnpd->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_idnpd"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tglpengajuan->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_tglpengajuan"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->lampiran->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_lampiran"></slot></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->prepared_by->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_prepared_by"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->checked_by->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_checked_by"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->approved_by->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_approved_by"></slot></td>
                </tr>
            </table>
        </div>  
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">PEMESAN</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <?php $custom = ExecuteRow("SELECT c.nama as namacustomer, c.alamat as alamatcustomer, c.jabatan as jabatancustomer, c.telpon as telponcustomer, jp.nama as jenisproduk FROM npd JOIN customer c ON c.id = npd.idcustomer JOIN jenisproduk jp ON jp.id = npd.jenisproduk WHERE npd.id = {$Page->idnpd->CurrentValue}") ?>
            <tr>
                <th class="text-right w-col-3">Nama Pemesan</th>
                <td><?php echo $custom['namacustomer'] ?></td>
            </tr>
            <tr>
                <th class="text-right w-col-3">Alamat</th>
                <td><?php echo $custom['alamat'] ?></td>
            </tr>
            <tr>
                <th class="text-right w-col-3">Contact Person</th>
                <td><?php echo $custom['namacustomer'] ?></td>
            </tr>
            <tr>
                <th class="text-right w-col-3">Jabatan</th>
                <td><?php echo $custom['jabatan'] ?></td>
            </tr>
            <tr>
                <th class="text-right w-col-3">Telepon</th>
                <td><?php echo $custom['telponcustomer'] ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KONTEN (ISI SEDIAAN)</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->idnpd_sample->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_idnpd_sample"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->nama->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_nama"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3">Jenis Produk</th>
                <td><?php echo $custom['jenisproduk'] ?></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bentuk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_bentuk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->viskositas->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_viskositas"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><slot class="ew-slot" name="tpcaption_warna"></slot></th>
                <td><slot class="ew-slot" name="tpx_warna"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><slot class="ew-slot" name="tpcaption_bauparfum"></slot></th>
                <td><slot class="ew-slot" name="tpx_bauparfum"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasisediaan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_aplikasisediaan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->volume->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_volume"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bahanaktif->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_bahanaktif"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KEMASAN PRIMER</div>
    </div>
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->volumewadah->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_volumewadah"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->bahanwadah->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_bahanwadah"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->warnawadah->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_warnawadah"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->bentukwadah->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_bentukwadah"></slot></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->jenistutup->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_jenistutup"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->bahantutup->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_bahantutup"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->warnatutup->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_warnatutup"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->bentuktutup->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_bentuktutup"></slot></td>
                </tr>
            </table>
        </div>
        <div class="col-12">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->segel->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_segel"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->catatanprimer->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_catatanprimer"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KEMASAN SEKUNDER</div>
    </div>
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->packingproduk->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_packingproduk"></slot></td>
                </tr>
                <div class="form-group row mb-2">
                    <label class="col-4 col-form-label text-right"><?= $Page->keteranganpacking->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_keteranganpacking"></slot></div>
                </div>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->beltkarton->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_beltkarton"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->keteranganbelt->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_keteranganbelt"></slot></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->kartonluar->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_kartonluar"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->bariskarton->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_bariskarton"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->kolomkarton->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_kolomkarton"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->stackkarton->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_stackkarton"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->isikarton->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_harga_isikarton"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KONTEN (ISI SEDIAAN)</div>
    </div>
    <div class="card-body row">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->jenislabel->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_jenislabel"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->keteranganjenislabel->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_keteranganjenislabel"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->kualitaslabel->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_kualitaslabel"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->jumlahwarnalabel->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_jumlahwarnalabel"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->metaliklabel->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_metaliklabel"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->etiketlabel->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_etiketlabel"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->keteranganlabel->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_keteranganlabel"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">DELIVERY</div>
    </div>
    <div class="card-body row">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->kategoridelivery->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_kategoridelivery"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->alamatpengiriman->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_alamatpengiriman"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">JUMLAH ORDER (PRODUKSI)</div>
    </div>
    <div class="card-body row">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->orderperdana->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_orderperdana"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->orderkontrak->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_orderkontrak"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">HARGA PENAWARAN</div>
    </div>
    <div class="card-body row">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->hargaperpcs->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_hargaperpcs"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->hargaperkarton->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_harga_hargaperkarton"></slot></td>
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
    ew.applyTemplate("tpd_npd_hargaview", "tpm_npd_hargaview", "npd_hargaview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
