<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdesignView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdesignview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmdesignview = currentForm = new ew.Form("fnpd_confirmdesignview", "view");
    loadjs.done("fnpd_confirmdesignview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirmdesign) ew.vars.tables.npd_confirmdesign = <?= JsonEncode(GetClientVar("tables", "npd_confirmdesign")) ?>;
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
<form name="fnpd_confirmdesignview" id="fnpd_confirmdesignview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdesign">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_id"><template id="tpc_npd_confirmdesign_id"><?= $Page->id->caption() ?></template></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_id"><span id="el_npd_confirmdesign_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_idnpd"><template id="tpc_npd_confirmdesign_idnpd"><?= $Page->idnpd->caption() ?></template></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_idnpd"><span id="el_npd_confirmdesign_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <tr id="r_tglterima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_tglterima"><template id="tpc_npd_confirmdesign_tglterima"><?= $Page->tglterima->caption() ?></template></span></td>
        <td data-name="tglterima" <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglterima"><span id="el_npd_confirmdesign_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_tglsubmit"><template id="tpc_npd_confirmdesign_tglsubmit"><?= $Page->tglsubmit->caption() ?></template></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglsubmit"><span id="el_npd_confirmdesign_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desaindepan->Visible) { // desaindepan ?>
    <tr id="r_desaindepan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_desaindepan"><template id="tpc_npd_confirmdesign_desaindepan"><?= $Page->desaindepan->caption() ?></template></span></td>
        <td data-name="desaindepan" <?= $Page->desaindepan->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_desaindepan"><span id="el_npd_confirmdesign_desaindepan">
<span<?= $Page->desaindepan->viewAttributes() ?>>
<?= $Page->desaindepan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainbelakang->Visible) { // desainbelakang ?>
    <tr id="r_desainbelakang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_desainbelakang"><template id="tpc_npd_confirmdesign_desainbelakang"><?= $Page->desainbelakang->caption() ?></template></span></td>
        <td data-name="desainbelakang" <?= $Page->desainbelakang->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_desainbelakang"><span id="el_npd_confirmdesign_desainbelakang">
<span<?= $Page->desainbelakang->viewAttributes() ?>>
<?= $Page->desainbelakang->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <tr id="r_catatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_catatan"><template id="tpc_npd_confirmdesign_catatan"><?= $Page->catatan->caption() ?></template></span></td>
        <td data-name="catatan" <?= $Page->catatan->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_catatan"><span id="el_npd_confirmdesign_catatan">
<span<?= $Page->catatan->viewAttributes() ?>>
<?= $Page->catatan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglprimer->Visible) { // tglprimer ?>
    <tr id="r_tglprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_tglprimer"><template id="tpc_npd_confirmdesign_tglprimer"><?= $Page->tglprimer->caption() ?></template></span></td>
        <td data-name="tglprimer" <?= $Page->tglprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglprimer"><span id="el_npd_confirmdesign_tglprimer">
<span<?= $Page->tglprimer->viewAttributes() ?>>
<?= $Page->tglprimer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
    <tr id="r_desainsekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_desainsekunder"><template id="tpc_npd_confirmdesign_desainsekunder"><?= $Page->desainsekunder->caption() ?></template></span></td>
        <td data-name="desainsekunder" <?= $Page->desainsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_desainsekunder"><span id="el_npd_confirmdesign_desainsekunder">
<span<?= $Page->desainsekunder->viewAttributes() ?>>
<?= $Page->desainsekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatansekunder->Visible) { // catatansekunder ?>
    <tr id="r_catatansekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_catatansekunder"><template id="tpc_npd_confirmdesign_catatansekunder"><?= $Page->catatansekunder->caption() ?></template></span></td>
        <td data-name="catatansekunder" <?= $Page->catatansekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_catatansekunder"><span id="el_npd_confirmdesign_catatansekunder">
<span<?= $Page->catatansekunder->viewAttributes() ?>>
<?= $Page->catatansekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsekunder->Visible) { // tglsekunder ?>
    <tr id="r_tglsekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_tglsekunder"><template id="tpc_npd_confirmdesign_tglsekunder"><?= $Page->tglsekunder->caption() ?></template></span></td>
        <td data-name="tglsekunder" <?= $Page->tglsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglsekunder"><span id="el_npd_confirmdesign_tglsekunder">
<span<?= $Page->tglsekunder->viewAttributes() ?>>
<?= $Page->tglsekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <tr id="r_submitted_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_submitted_by"><template id="tpc_npd_confirmdesign_submitted_by"><?= $Page->submitted_by->caption() ?></template></span></td>
        <td data-name="submitted_by" <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_submitted_by"><span id="el_npd_confirmdesign_submitted_by">
<span<?= $Page->submitted_by->viewAttributes() ?>>
<?= $Page->submitted_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
    <tr id="r_checked1_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_checked1_by"><template id="tpc_npd_confirmdesign_checked1_by"><?= $Page->checked1_by->caption() ?></template></span></td>
        <td data-name="checked1_by" <?= $Page->checked1_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_checked1_by"><span id="el_npd_confirmdesign_checked1_by">
<span<?= $Page->checked1_by->viewAttributes() ?>>
<?= $Page->checked1_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
    <tr id="r_checked2_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_checked2_by"><template id="tpc_npd_confirmdesign_checked2_by"><?= $Page->checked2_by->caption() ?></template></span></td>
        <td data-name="checked2_by" <?= $Page->checked2_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_checked2_by"><span id="el_npd_confirmdesign_checked2_by">
<span<?= $Page->checked2_by->viewAttributes() ?>>
<?= $Page->checked2_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_approved_by"><template id="tpc_npd_confirmdesign_approved_by"><?= $Page->approved_by->caption() ?></template></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_approved_by"><span id="el_npd_confirmdesign_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_created_at"><template id="tpc_npd_confirmdesign_created_at"><?= $Page->created_at->caption() ?></template></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_created_at"><span id="el_npd_confirmdesign_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdesign_updated_at"><template id="tpc_npd_confirmdesign_updated_at"><?= $Page->updated_at->caption() ?></template></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_updated_at"><span id="el_npd_confirmdesign_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_npd_confirmdesignview" class="ew-custom-template"></div>
<template id="tpm_npd_confirmdesignview">
<div id="ct_NpdConfirmdesignView"><div class="card">
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idnpd->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_confirmdesign_idnpd"></slot></td>
                </tr>
                <?php $custom = ExecuteRow("SELECT c.kode, as kodecustomer, c.nama as namacustomer, npd.status FROM npd JOIN customer c ON c.id = npd.idcustomer WHERE npd.id = {$Page->idnpd->CurrentValue}") ?>
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
                    <td><slot class="ew-slot" name="tpx_npd_confirmdesign_tglterima"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tglsubmit->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_confirmdesign_tglsubmit"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">DESAIN LABEL KEMASAN PRIMER/LOGO</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->desaindepan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_desaindepan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->desainbelakang->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_desainbelakang"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->tglprimer->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_tglprimer"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->catatan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_catatan"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">DESAIN LABEL KEMASAN SEKUNDER</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->desainsekunder->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_desainsekunder"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->tglsekunder->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_tglsekunder"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->catatansekunder->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_catatansekunder"></slot></td>
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
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_submitted_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->checked1_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_checked1_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->checked2_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_checked2_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->approved_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdesign_approved_by"></slot></td>
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
    ew.applyTemplate("tpd_npd_confirmdesignview", "tpm_npd_confirmdesignview", "npd_confirmdesignview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
