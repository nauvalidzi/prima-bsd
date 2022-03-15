<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdummyView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdummyview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmdummyview = currentForm = new ew.Form("fnpd_confirmdummyview", "view");
    loadjs.done("fnpd_confirmdummyview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirmdummy) ew.vars.tables.npd_confirmdummy = <?= JsonEncode(GetClientVar("tables", "npd_confirmdummy")) ?>;
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
<form name="fnpd_confirmdummyview" id="fnpd_confirmdummyview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdummy">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_idnpd"><template id="tpc_npd_confirmdummy_idnpd"><?= $Page->idnpd->caption() ?></template></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_idnpd"><span id="el_npd_confirmdummy_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <tr id="r_tglterima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_tglterima"><template id="tpc_npd_confirmdummy_tglterima"><?= $Page->tglterima->caption() ?></template></span></td>
        <td data-name="tglterima" <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_tglterima"><span id="el_npd_confirmdummy_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_tglsubmit"><template id="tpc_npd_confirmdummy_tglsubmit"><?= $Page->tglsubmit->caption() ?></template></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_tglsubmit"><span id="el_npd_confirmdummy_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummydepan->Visible) { // dummydepan ?>
    <tr id="r_dummydepan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummydepan"><template id="tpc_npd_confirmdummy_dummydepan"><?= $Page->dummydepan->caption() ?></template></span></td>
        <td data-name="dummydepan" <?= $Page->dummydepan->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummydepan"><span id="el_npd_confirmdummy_dummydepan">
<span<?= $Page->dummydepan->viewAttributes() ?>>
<?= $Page->dummydepan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
    <tr id="r_dummybelakang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummybelakang"><template id="tpc_npd_confirmdummy_dummybelakang"><?= $Page->dummybelakang->caption() ?></template></span></td>
        <td data-name="dummybelakang" <?= $Page->dummybelakang->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummybelakang"><span id="el_npd_confirmdummy_dummybelakang">
<span<?= $Page->dummybelakang->viewAttributes() ?>>
<?= $Page->dummybelakang->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummyatas->Visible) { // dummyatas ?>
    <tr id="r_dummyatas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummyatas"><template id="tpc_npd_confirmdummy_dummyatas"><?= $Page->dummyatas->caption() ?></template></span></td>
        <td data-name="dummyatas" <?= $Page->dummyatas->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummyatas"><span id="el_npd_confirmdummy_dummyatas">
<span<?= $Page->dummyatas->viewAttributes() ?>>
<?= $Page->dummyatas->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dummysamping->Visible) { // dummysamping ?>
    <tr id="r_dummysamping">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_dummysamping"><template id="tpc_npd_confirmdummy_dummysamping"><?= $Page->dummysamping->caption() ?></template></span></td>
        <td data-name="dummysamping" <?= $Page->dummysamping->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummysamping"><span id="el_npd_confirmdummy_dummysamping">
<span<?= $Page->dummysamping->viewAttributes() ?>>
<?= $Page->dummysamping->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <tr id="r_catatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_catatan"><template id="tpc_npd_confirmdummy_catatan"><?= $Page->catatan->caption() ?></template></span></td>
        <td data-name="catatan" <?= $Page->catatan->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_catatan"><span id="el_npd_confirmdummy_catatan">
<span<?= $Page->catatan->viewAttributes() ?>>
<?= $Page->catatan->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ttd->Visible) { // ttd ?>
    <tr id="r_ttd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_ttd"><template id="tpc_npd_confirmdummy_ttd"><?= $Page->ttd->caption() ?></template></span></td>
        <td data-name="ttd" <?= $Page->ttd->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_ttd"><span id="el_npd_confirmdummy_ttd">
<span<?= $Page->ttd->viewAttributes() ?>>
<?= $Page->ttd->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <tr id="r_submitted_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_submitted_by"><template id="tpc_npd_confirmdummy_submitted_by"><?= $Page->submitted_by->caption() ?></template></span></td>
        <td data-name="submitted_by" <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_submitted_by"><span id="el_npd_confirmdummy_submitted_by">
<span<?= $Page->submitted_by->viewAttributes() ?>>
<?= $Page->submitted_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
    <tr id="r_checked1_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_checked1_by"><template id="tpc_npd_confirmdummy_checked1_by"><?= $Page->checked1_by->caption() ?></template></span></td>
        <td data-name="checked1_by" <?= $Page->checked1_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_checked1_by"><span id="el_npd_confirmdummy_checked1_by">
<span<?= $Page->checked1_by->viewAttributes() ?>>
<?= $Page->checked1_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
    <tr id="r_checked2_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_checked2_by"><template id="tpc_npd_confirmdummy_checked2_by"><?= $Page->checked2_by->caption() ?></template></span></td>
        <td data-name="checked2_by" <?= $Page->checked2_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_checked2_by"><span id="el_npd_confirmdummy_checked2_by">
<span<?= $Page->checked2_by->viewAttributes() ?>>
<?= $Page->checked2_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_approved_by"><template id="tpc_npd_confirmdummy_approved_by"><?= $Page->approved_by->caption() ?></template></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_approved_by"><span id="el_npd_confirmdummy_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_created_at"><template id="tpc_npd_confirmdummy_created_at"><?= $Page->created_at->caption() ?></template></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_created_at"><span id="el_npd_confirmdummy_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmdummy_updated_at"><template id="tpc_npd_confirmdummy_updated_at"><?= $Page->updated_at->caption() ?></template></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_updated_at"><span id="el_npd_confirmdummy_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_npd_confirmdummyview" class="ew-custom-template"></div>
<template id="tpm_npd_confirmdummyview">
<div id="ct_NpdConfirmdummyView"><div class="card">
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">
                <tr>
                    <th class="text-right w-col-3"><?= $Page->idnpd->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_confirmdummy_idnpd"></slot></td>
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
                    <td><slot class="ew-slot" name="tpx_npd_confirmdummy_tglterima"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><?= $Page->tglsubmit->caption() ?></th>
                    <td><slot class="ew-slot" name="tpx_npd_confirmdummy_tglsubmit"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">FOTO DUMMY PROTOTYPE</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->dummydepan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_dummydepan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->dummybelakang->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_dummybelakang"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->dummyatas->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_dummyatas"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->dummysamping->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_dummysamping"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->catatan->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_catatan"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->ttd->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_ttd"></slot></td>
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
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_submitted_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->checked1_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_checked1_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->checked2_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_checked2_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->approved_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmdummy_approved_by"></slot></td>
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
    ew.applyTemplate("tpd_npd_confirmdummyview", "tpm_npd_confirmdummyview", "npd_confirmdummyview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
