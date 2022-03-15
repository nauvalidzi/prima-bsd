<?php

namespace PHPMaker2021\production2;

// Page object
$IjinbpomView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinbpomview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fijinbpomview = currentForm = new ew.Form("fijinbpomview", "view");
    loadjs.done("fijinbpomview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ijinbpom) ew.vars.tables.ijinbpom = <?= JsonEncode(GetClientVar("tables", "ijinbpom")) ?>;
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
<form name="fijinbpomview" id="fijinbpomview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinbpom">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <tr id="r_tglterima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_tglterima"><template id="tpc_ijinbpom_tglterima"><?= $Page->tglterima->caption() ?></template></span></td>
        <td data-name="tglterima" <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_ijinbpom_tglterima"><span id="el_ijinbpom_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_tglsubmit"><template id="tpc_ijinbpom_tglsubmit"><?= $Page->tglsubmit->caption() ?></template></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_ijinbpom_tglsubmit"><span id="el_ijinbpom_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_idpegawai"><template id="tpc_ijinbpom_idpegawai"><?= $Page->idpegawai->caption() ?></template></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<template id="tpx_ijinbpom_idpegawai"><span id="el_ijinbpom_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_idcustomer"><template id="tpc_ijinbpom_idcustomer"><?= $Page->idcustomer->caption() ?></template></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<template id="tpx_ijinbpom_idcustomer"><span id="el_ijinbpom_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <tr id="r_idbrand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_idbrand"><template id="tpc_ijinbpom_idbrand"><?= $Page->idbrand->caption() ?></template></span></td>
        <td data-name="idbrand" <?= $Page->idbrand->cellAttributes() ?>>
<template id="tpx_ijinbpom_idbrand"><span id="el_ijinbpom_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kontrakkerjasama->Visible) { // kontrakkerjasama ?>
    <tr id="r_kontrakkerjasama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_kontrakkerjasama"><template id="tpc_ijinbpom_kontrakkerjasama"><?= $Page->kontrakkerjasama->caption() ?></template></span></td>
        <td data-name="kontrakkerjasama" <?= $Page->kontrakkerjasama->cellAttributes() ?>>
<template id="tpx_ijinbpom_kontrakkerjasama"><span id="el_ijinbpom_kontrakkerjasama">
<span<?= $Page->kontrakkerjasama->viewAttributes() ?>>
<?= GetFileViewTag($Page->kontrakkerjasama, $Page->kontrakkerjasama->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->suratkuasa->Visible) { // suratkuasa ?>
    <tr id="r_suratkuasa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_suratkuasa"><template id="tpc_ijinbpom_suratkuasa"><?= $Page->suratkuasa->caption() ?></template></span></td>
        <td data-name="suratkuasa" <?= $Page->suratkuasa->cellAttributes() ?>>
<template id="tpx_ijinbpom_suratkuasa"><span id="el_ijinbpom_suratkuasa">
<span<?= $Page->suratkuasa->viewAttributes() ?>>
<?= GetFileViewTag($Page->suratkuasa, $Page->suratkuasa->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->suratpembagian->Visible) { // suratpembagian ?>
    <tr id="r_suratpembagian">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_suratpembagian"><template id="tpc_ijinbpom_suratpembagian"><?= $Page->suratpembagian->caption() ?></template></span></td>
        <td data-name="suratpembagian" <?= $Page->suratpembagian->cellAttributes() ?>>
<template id="tpx_ijinbpom_suratpembagian"><span id="el_ijinbpom_suratpembagian">
<span<?= $Page->suratpembagian->viewAttributes() ?>>
<?= GetFileViewTag($Page->suratpembagian, $Page->suratpembagian->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_status"><template id="tpc_ijinbpom_status"><?= $Page->status->caption() ?></template></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<template id="tpx_ijinbpom_status"><span id="el_ijinbpom_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <tr id="r_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_selesai"><template id="tpc_ijinbpom_selesai"><?= $Page->selesai->caption() ?></template></span></td>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<template id="tpx_ijinbpom_selesai"><span id="el_ijinbpom_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<?= $Page->selesai->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_ijinbpomview" class="ew-custom-template"></div>
<template id="tpm_ijinbpomview">
<div id="ct_IjinbpomView"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <table class="table table-striped table-sm ew-view-table">
                    <tr>
                        <th class="text-right w-col-3"><?= $Page->tglterima->caption() ?></th>
                        <td><slot class="ew-slot" name="tpx_ijinbpom_tglterima"></slot></td>
                    </tr>                    
                </table>
            </div>
            <div class="col-6">
                <table class="table table-striped table-sm ew-view-table">
                    <tr>
                        <th class="text-right w-col-3"><?= $Page->tglsubmit->caption() ?></th>
                        <td><slot class="ew-slot" name="tpx_ijinbpom_tglsubmit"></slot></td>
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
                    <th class="text-right w-col-3"><?= $Page->idpegawai->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinbpom_idpegawai"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idcustomer->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinbpom_idcustomer"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idbrand->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinbpom_idbrand"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->kontrakkerjasama->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinbpom_kontrakkerjasama"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->suratkuasa->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinbpom_suratkuasa"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->suratpembagian->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_ijinbpom_suratpembagian"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
</template>
<?php
    if (in_array("ijinbpom_detail", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_detail->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("ijinbpom_detail", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("ijinbpom_detail")->Count, $Language->phrase("DetailCount")) ?></h4>
<?php } ?>
<?php include_once "IjinbpomDetailGrid.php" ?>
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_ijinbpomview", "tpm_ijinbpomview", "ijinbpomview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
