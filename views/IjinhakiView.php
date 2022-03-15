<?php

namespace PHPMaker2021\production2;

// Page object
$IjinhakiView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinhakiview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fijinhakiview = currentForm = new ew.Form("fijinhakiview", "view");
    loadjs.done("fijinhakiview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ijinhaki) ew.vars.tables.ijinhaki = <?= JsonEncode(GetClientVar("tables", "ijinhaki")) ?>;
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
<form name="fijinhakiview" id="fijinhakiview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_idnpd"><template id="tpc_ijinhaki_idnpd"><?= $Page->idnpd->caption() ?></template></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_ijinhaki_idnpd"><span id="el_ijinhaki_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <tr id="r_tglterima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_tglterima"><template id="tpc_ijinhaki_tglterima"><?= $Page->tglterima->caption() ?></template></span></td>
        <td data-name="tglterima" <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_ijinhaki_tglterima"><span id="el_ijinhaki_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_tglsubmit"><template id="tpc_ijinhaki_tglsubmit"><?= $Page->tglsubmit->caption() ?></template></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_ijinhaki_tglsubmit"><span id="el_ijinhaki_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
    <tr id="r_ktp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_ktp"><template id="tpc_ijinhaki_ktp"><?= $Page->ktp->caption() ?></template></span></td>
        <td data-name="ktp" <?= $Page->ktp->cellAttributes() ?>>
<template id="tpx_ijinhaki_ktp"><span id="el_ijinhaki_ktp">
<span<?= $Page->ktp->viewAttributes() ?>>
<?= $Page->ktp->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
    <tr id="r_npwp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_npwp"><template id="tpc_ijinhaki_npwp"><?= $Page->npwp->caption() ?></template></span></td>
        <td data-name="npwp" <?= $Page->npwp->cellAttributes() ?>>
<template id="tpx_ijinhaki_npwp"><span id="el_ijinhaki_npwp">
<span<?= $Page->npwp->viewAttributes() ?>>
<?= $Page->npwp->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nib->Visible) { // nib ?>
    <tr id="r_nib">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_nib"><template id="tpc_ijinhaki_nib"><?= $Page->nib->caption() ?></template></span></td>
        <td data-name="nib" <?= $Page->nib->cellAttributes() ?>>
<template id="tpx_ijinhaki_nib"><span id="el_ijinhaki_nib">
<span<?= $Page->nib->viewAttributes() ?>>
<?= $Page->nib->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
    <tr id="r_akta_pendirian">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_akta_pendirian"><template id="tpc_ijinhaki_akta_pendirian"><?= $Page->akta_pendirian->caption() ?></template></span></td>
        <td data-name="akta_pendirian" <?= $Page->akta_pendirian->cellAttributes() ?>>
<template id="tpx_ijinhaki_akta_pendirian"><span id="el_ijinhaki_akta_pendirian">
<span<?= $Page->akta_pendirian->viewAttributes() ?>>
<?= GetFileViewTag($Page->akta_pendirian, $Page->akta_pendirian->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sk_umk->Visible) { // sk_umk ?>
    <tr id="r_sk_umk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_sk_umk"><template id="tpc_ijinhaki_sk_umk"><?= $Page->sk_umk->caption() ?></template></span></td>
        <td data-name="sk_umk" <?= $Page->sk_umk->cellAttributes() ?>>
<template id="tpx_ijinhaki_sk_umk"><span id="el_ijinhaki_sk_umk">
<span<?= $Page->sk_umk->viewAttributes() ?>>
<?= $Page->sk_umk->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
    <tr id="r_ttd_pemohon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_ttd_pemohon"><template id="tpc_ijinhaki_ttd_pemohon"><?= $Page->ttd_pemohon->caption() ?></template></span></td>
        <td data-name="ttd_pemohon" <?= $Page->ttd_pemohon->cellAttributes() ?>>
<template id="tpx_ijinhaki_ttd_pemohon"><span id="el_ijinhaki_ttd_pemohon">
<span<?= $Page->ttd_pemohon->viewAttributes() ?>>
<?= GetFileViewTag($Page->ttd_pemohon, $Page->ttd_pemohon->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
    <tr id="r_nama_brand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_nama_brand"><template id="tpc_ijinhaki_nama_brand"><?= $Page->nama_brand->caption() ?></template></span></td>
        <td data-name="nama_brand" <?= $Page->nama_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_nama_brand"><span id="el_ijinhaki_nama_brand">
<span<?= $Page->nama_brand->viewAttributes() ?>>
<?= $Page->nama_brand->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label_brand->Visible) { // label_brand ?>
    <tr id="r_label_brand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_label_brand"><template id="tpc_ijinhaki_label_brand"><?= $Page->label_brand->caption() ?></template></span></td>
        <td data-name="label_brand" <?= $Page->label_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_label_brand"><span id="el_ijinhaki_label_brand">
<span<?= $Page->label_brand->viewAttributes() ?>>
<?= GetFileViewTag($Page->label_brand, $Page->label_brand->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deskripsi_brand->Visible) { // deskripsi_brand ?>
    <tr id="r_deskripsi_brand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_deskripsi_brand"><template id="tpc_ijinhaki_deskripsi_brand"><?= $Page->deskripsi_brand->caption() ?></template></span></td>
        <td data-name="deskripsi_brand" <?= $Page->deskripsi_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_deskripsi_brand"><span id="el_ijinhaki_deskripsi_brand">
<span<?= $Page->deskripsi_brand->viewAttributes() ?>>
<?= $Page->deskripsi_brand->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unsur_brand->Visible) { // unsur_brand ?>
    <tr id="r_unsur_brand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_unsur_brand"><template id="tpc_ijinhaki_unsur_brand"><?= $Page->unsur_brand->caption() ?></template></span></td>
        <td data-name="unsur_brand" <?= $Page->unsur_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_unsur_brand"><span id="el_ijinhaki_unsur_brand">
<span<?= $Page->unsur_brand->viewAttributes() ?>>
<?= $Page->unsur_brand->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <tr id="r_submitted_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_submitted_by"><template id="tpc_ijinhaki_submitted_by"><?= $Page->submitted_by->caption() ?></template></span></td>
        <td data-name="submitted_by" <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_submitted_by"><span id="el_ijinhaki_submitted_by">
<span<?= $Page->submitted_by->viewAttributes() ?>>
<?= $Page->submitted_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
    <tr id="r_checked1_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_checked1_by"><template id="tpc_ijinhaki_checked1_by"><?= $Page->checked1_by->caption() ?></template></span></td>
        <td data-name="checked1_by" <?= $Page->checked1_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_checked1_by"><span id="el_ijinhaki_checked1_by">
<span<?= $Page->checked1_by->viewAttributes() ?>>
<?= $Page->checked1_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
    <tr id="r_checked2_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_checked2_by"><template id="tpc_ijinhaki_checked2_by"><?= $Page->checked2_by->caption() ?></template></span></td>
        <td data-name="checked2_by" <?= $Page->checked2_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_checked2_by"><span id="el_ijinhaki_checked2_by">
<span<?= $Page->checked2_by->viewAttributes() ?>>
<?= $Page->checked2_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_approved_by"><template id="tpc_ijinhaki_approved_by"><?= $Page->approved_by->caption() ?></template></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_approved_by"><span id="el_ijinhaki_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status"><template id="tpc_ijinhaki_status"><?= $Page->status->caption() ?></template></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<template id="tpx_ijinhaki_status"><span id="el_ijinhaki_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <tr id="r_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_selesai"><template id="tpc_ijinhaki_selesai"><?= $Page->selesai->caption() ?></template></span></td>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<template id="tpx_ijinhaki_selesai"><span id="el_ijinhaki_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<?= $Page->selesai->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_ijinhakiview" class="ew-custom-template"></div>
<template id="tpm_ijinhakiview">
<div id="ct_IjinhakiView"><div class="card">
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <?php $custom = ExecuteRow("SELECT c.kode, as kodecustomer, c.nama as namacustomer, npd.status FROM npd JOIN customer c ON c.id = npd.idcustomer WHERE npd.id = {$Page->idnpd->CurrentValue}") ?>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idnpd->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinhaki_idnpd"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3">Kode Customer</th>
                    <td><?php echo $custom['kodecustomer'] . ', ' . $custom['namacustomer'] ?></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3">Status</th>
                    <td><?php echo $custom['status'] ?></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tglterima->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinhaki_tglterima"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tglsubmit->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinhaki_tglsubmit"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">KELENGKAPAN</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->ktp->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_ktp"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->npwp->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_npwp"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->nib->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_nib"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->akta_pendirian->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_akta_pendirian"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->sk_umk->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_sk_umk"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->ttd_pemohon->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_ttd_pemohon"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">PENGAJUAN</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->nama_brand->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_nama_brand"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->label_brand->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_label_brand"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->deskripsi_brand->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_deskripsi_brand"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3">Unsur Warna<br>dalam Label</th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_unsur_brand"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">VALIDASI</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->submitted_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_submitted_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->checked1_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_checked1_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->checked2_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_checked2_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->approved_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_ijinhaki_approved_by"></slot></td>
            </tr>
        </table>
    </div>
</div>
</div>
</template>
<?php
    if (in_array("ijinhaki_status", explode(",", $Page->getCurrentDetailTable())) && $ijinhaki_status->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("ijinhaki_status", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("ijinhaki_status")->Count, $Language->phrase("DetailCount")) ?></h4>
<?php } ?>
<?php include_once "IjinhakiStatusGrid.php" ?>
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_ijinhakiview", "tpm_ijinhakiview", "ijinhakiview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
