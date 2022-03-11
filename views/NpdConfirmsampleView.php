<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmsampleView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmsampleview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmsampleview = currentForm = new ew.Form("fnpd_confirmsampleview", "view");
    loadjs.done("fnpd_confirmsampleview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirmsample) ew.vars.tables.npd_confirmsample = <?= JsonEncode(GetClientVar("tables", "npd_confirmsample")) ?>;
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
<form name="fnpd_confirmsampleview" id="fnpd_confirmsampleview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmsample">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_idnpd"><template id="tpc_npd_confirmsample_idnpd"><?= $Page->idnpd->caption() ?></template></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_idnpd"><span id="el_npd_confirmsample_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
    <tr id="r_tglkonfirmasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_tglkonfirmasi"><template id="tpc_npd_confirmsample_tglkonfirmasi"><?= $Page->tglkonfirmasi->caption() ?></template></span></td>
        <td data-name="tglkonfirmasi" <?= $Page->tglkonfirmasi->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_tglkonfirmasi"><span id="el_npd_confirmsample_tglkonfirmasi">
<span<?= $Page->tglkonfirmasi->viewAttributes() ?>>
<?= $Page->tglkonfirmasi->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <tr id="r_idnpd_sample">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_idnpd_sample"><template id="tpc_npd_confirmsample_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></template></span></td>
        <td data-name="idnpd_sample" <?= $Page->idnpd_sample->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_idnpd_sample"><span id="el_npd_confirmsample_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_nama"><template id="tpc_npd_confirmsample_nama"><?= $Page->nama->caption() ?></template></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_nama"><span id="el_npd_confirmsample_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <tr id="r_bentuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_bentuk"><template id="tpc_npd_confirmsample_bentuk"><?= $Page->bentuk->caption() ?></template></span></td>
        <td data-name="bentuk" <?= $Page->bentuk->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_bentuk"><span id="el_npd_confirmsample_bentuk">
<span<?= $Page->bentuk->viewAttributes() ?>>
<?= $Page->bentuk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <tr id="r_viskositas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_viskositas"><template id="tpc_npd_confirmsample_viskositas"><?= $Page->viskositas->caption() ?></template></span></td>
        <td data-name="viskositas" <?= $Page->viskositas->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_viskositas"><span id="el_npd_confirmsample_viskositas">
<span<?= $Page->viskositas->viewAttributes() ?>>
<?= $Page->viskositas->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_warna"><template id="tpc_npd_confirmsample_warna"><?= $Page->warna->caption() ?></template></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_warna"><span id="el_npd_confirmsample_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bauparfum->Visible) { // bauparfum ?>
    <tr id="r_bauparfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_bauparfum"><template id="tpc_npd_confirmsample_bauparfum"><?= $Page->bauparfum->caption() ?></template></span></td>
        <td data-name="bauparfum" <?= $Page->bauparfum->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_bauparfum"><span id="el_npd_confirmsample_bauparfum">
<span<?= $Page->bauparfum->viewAttributes() ?>>
<?= $Page->bauparfum->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasisediaan->Visible) { // aplikasisediaan ?>
    <tr id="r_aplikasisediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_aplikasisediaan"><template id="tpc_npd_confirmsample_aplikasisediaan"><?= $Page->aplikasisediaan->caption() ?></template></span></td>
        <td data-name="aplikasisediaan" <?= $Page->aplikasisediaan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_aplikasisediaan"><span id="el_npd_confirmsample_aplikasisediaan">
<span<?= $Page->aplikasisediaan->viewAttributes() ?>>
<?= $Page->aplikasisediaan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <tr id="r_volume">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_volume"><template id="tpc_npd_confirmsample_volume"><?= $Page->volume->caption() ?></template></span></td>
        <td data-name="volume" <?= $Page->volume->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_volume"><span id="el_npd_confirmsample_volume">
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->campaign->Visible) { // campaign ?>
    <tr id="r_campaign">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_campaign"><template id="tpc_npd_confirmsample_campaign"><?= $Page->campaign->caption() ?></template></span></td>
        <td data-name="campaign" <?= $Page->campaign->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_campaign"><span id="el_npd_confirmsample_campaign">
<span<?= $Page->campaign->viewAttributes() ?>>
<?= $Page->campaign->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alasansetuju->Visible) { // alasansetuju ?>
    <tr id="r_alasansetuju">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_alasansetuju"><template id="tpc_npd_confirmsample_alasansetuju"><?= $Page->alasansetuju->caption() ?></template></span></td>
        <td data-name="alasansetuju" <?= $Page->alasansetuju->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_alasansetuju"><span id="el_npd_confirmsample_alasansetuju">
<span<?= $Page->alasansetuju->viewAttributes() ?>>
<?= $Page->alasansetuju->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_foto"><template id="tpc_npd_confirmsample_foto"><?= $Page->foto->caption() ?></template></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_foto"><span id="el_npd_confirmsample_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
    <tr id="r_namapemesan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_namapemesan"><template id="tpc_npd_confirmsample_namapemesan"><?= $Page->namapemesan->caption() ?></template></span></td>
        <td data-name="namapemesan" <?= $Page->namapemesan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_namapemesan"><span id="el_npd_confirmsample_namapemesan">
<span<?= $Page->namapemesan->viewAttributes() ?>>
<?= $Page->namapemesan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamatpemesan->Visible) { // alamatpemesan ?>
    <tr id="r_alamatpemesan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_alamatpemesan"><template id="tpc_npd_confirmsample_alamatpemesan"><?= $Page->alamatpemesan->caption() ?></template></span></td>
        <td data-name="alamatpemesan" <?= $Page->alamatpemesan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_alamatpemesan"><span id="el_npd_confirmsample_alamatpemesan">
<span<?= $Page->alamatpemesan->viewAttributes() ?>>
<?= $Page->alamatpemesan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
    <tr id="r_personincharge">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_personincharge"><template id="tpc_npd_confirmsample_personincharge"><?= $Page->personincharge->caption() ?></template></span></td>
        <td data-name="personincharge" <?= $Page->personincharge->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_personincharge"><span id="el_npd_confirmsample_personincharge">
<span<?= $Page->personincharge->viewAttributes() ?>>
<?= $Page->personincharge->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <tr id="r_jabatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_jabatan"><template id="tpc_npd_confirmsample_jabatan"><?= $Page->jabatan->caption() ?></template></span></td>
        <td data-name="jabatan" <?= $Page->jabatan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_jabatan"><span id="el_npd_confirmsample_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
    <tr id="r_notelp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmsample_notelp"><template id="tpc_npd_confirmsample_notelp"><?= $Page->notelp->caption() ?></template></span></td>
        <td data-name="notelp" <?= $Page->notelp->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_notelp"><span id="el_npd_confirmsample_notelp">
<span<?= $Page->notelp->viewAttributes() ?>>
<?= $Page->notelp->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_npd_confirmsampleview" class="ew-custom-template"></div>
<template id="tpm_npd_confirmsampleview">
<div id="ct_NpdConfirmsampleView"><div class="card">
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idnpd->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_confirmsample_idnpd"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3">Customer</th>
                    <?php $custom = ExecuteRow("SELECT npd.id as idnpd, npd.kodeorder, npd.nomororder, npd.bahan_campaign, c.kode as kodecustomer, c.nama as namacustomer, c.alamat as alamatcustomer, c.jabatan as jabatancustomer, c.telpon as telponcustomer, jp.nama as jenisproduk FROM npd JOIN customer c ON c.id = npd.idcustomer JOIN jenisproduk jp ON jp.id = npd.jenisproduk WHERE npd.id = {$Page->idnpd->CurrentValue}") ?>
                    <td><?php echo $custom['kodecustomer'] . ', ' . $custom['namacustomer'] ?></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tglkonfirmasi->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_confirmsample_tglkonfirmasi"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->receipt_by->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_confirmsample_receipt_by"></slot></td>
                </tr>
            </table>
        </div>
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
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_idnpd_sample"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->nama->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_nama"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3">Jenis Produk</th>
                <td><?php echo $custom['jenisproduk'] ?></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bentuk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_bentuk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->viskositas->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_viskositas"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->warna->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_warna"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->bauparfum->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_bauparfum"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasisediaan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_aplikasisediaan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->volume->caption() ?></label>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_volume"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->campaign->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_campaign"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->alasansetuju->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_alasansetuju"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">SAMPEL PROTOTYPE</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->foto->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_foto"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">PEMESAN</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->namapemesan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_namapemesan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->alamatpemesan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_alamatpemesan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->personincharge->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_personincharge"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->jabatan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_jabatan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->notelp->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmsample_notelp"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KONFIRMASI FINAL SAMPEL</div>
    </div>
    <div class="card-body">
        <div class="callout callout-warning">Bersama formulir ini saya yang bertanda tangan dibawah ini mengkonfirmasi setuju untuk menggunakan <br>sampel prototype sesuai detail diatas ini untuk dijadikan acuan dalam produksi skala besar sesuai ketentuan <br>yang disepakati bersama dengan produsen (pabrik).</div>
    </div>
</div>
</div>
</template>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npd_confirmsampleview", "tpm_npd_confirmsampleview", "npd_confirmsampleview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    // Startup script
    loadjs.ready("jquery",(function(){$("#r_namapemesan").before('<h5 class="form-group">Data Pemesan</h5>')}));
});
</script>
<?php } ?>
