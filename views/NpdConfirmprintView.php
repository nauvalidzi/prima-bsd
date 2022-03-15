<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmprintView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmprintview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_confirmprintview = currentForm = new ew.Form("fnpd_confirmprintview", "view");
    loadjs.done("fnpd_confirmprintview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_confirmprint) ew.vars.tables.npd_confirmprint = <?= JsonEncode(GetClientVar("tables", "npd_confirmprint")) ?>;
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
<form name="fnpd_confirmprintview" id="fnpd_confirmprintview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmprint">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_id"><template id="tpc_npd_confirmprint_id"><?= $Page->id->caption() ?></template></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_id"><span id="el_npd_confirmprint_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
    <tr id="r_brand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_brand"><template id="tpc_npd_confirmprint_brand"><?= $Page->brand->caption() ?></template></span></td>
        <td data-name="brand" <?= $Page->brand->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_brand"><span id="el_npd_confirmprint_brand">
<span<?= $Page->brand->viewAttributes() ?>>
<?= $Page->brand->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
    <tr id="r_tglkirim">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_tglkirim"><template id="tpc_npd_confirmprint_tglkirim"><?= $Page->tglkirim->caption() ?></template></span></td>
        <td data-name="tglkirim" <?= $Page->tglkirim->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tglkirim"><span id="el_npd_confirmprint_tglkirim">
<span<?= $Page->tglkirim->viewAttributes() ?>>
<?= $Page->tglkirim->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgldisetujui->Visible) { // tgldisetujui ?>
    <tr id="r_tgldisetujui">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_tgldisetujui"><template id="tpc_npd_confirmprint_tgldisetujui"><?= $Page->tgldisetujui->caption() ?></template></span></td>
        <td data-name="tgldisetujui" <?= $Page->tgldisetujui->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tgldisetujui"><span id="el_npd_confirmprint_tgldisetujui">
<span<?= $Page->tgldisetujui->viewAttributes() ?>>
<?= $Page->tgldisetujui->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainprimer->Visible) { // desainprimer ?>
    <tr id="r_desainprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_desainprimer"><template id="tpc_npd_confirmprint_desainprimer"><?= $Page->desainprimer->caption() ?></template></span></td>
        <td data-name="desainprimer" <?= $Page->desainprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_desainprimer"><span id="el_npd_confirmprint_desainprimer">
<span<?= $Page->desainprimer->viewAttributes() ?>>
<?= $Page->desainprimer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->materialprimer->Visible) { // materialprimer ?>
    <tr id="r_materialprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_materialprimer"><template id="tpc_npd_confirmprint_materialprimer"><?= $Page->materialprimer->caption() ?></template></span></td>
        <td data-name="materialprimer" <?= $Page->materialprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_materialprimer"><span id="el_npd_confirmprint_materialprimer">
<span<?= $Page->materialprimer->viewAttributes() ?>>
<?= $Page->materialprimer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiprimer->Visible) { // aplikasiprimer ?>
    <tr id="r_aplikasiprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_aplikasiprimer"><template id="tpc_npd_confirmprint_aplikasiprimer"><?= $Page->aplikasiprimer->caption() ?></template></span></td>
        <td data-name="aplikasiprimer" <?= $Page->aplikasiprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_aplikasiprimer"><span id="el_npd_confirmprint_aplikasiprimer">
<span<?= $Page->aplikasiprimer->viewAttributes() ?>>
<?= $Page->aplikasiprimer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahcetakprimer->Visible) { // jumlahcetakprimer ?>
    <tr id="r_jumlahcetakprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_jumlahcetakprimer"><template id="tpc_npd_confirmprint_jumlahcetakprimer"><?= $Page->jumlahcetakprimer->caption() ?></template></span></td>
        <td data-name="jumlahcetakprimer" <?= $Page->jumlahcetakprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_jumlahcetakprimer"><span id="el_npd_confirmprint_jumlahcetakprimer">
<span<?= $Page->jumlahcetakprimer->viewAttributes() ?>>
<?= $Page->jumlahcetakprimer->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
    <tr id="r_desainsekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_desainsekunder"><template id="tpc_npd_confirmprint_desainsekunder"><?= $Page->desainsekunder->caption() ?></template></span></td>
        <td data-name="desainsekunder" <?= $Page->desainsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_desainsekunder"><span id="el_npd_confirmprint_desainsekunder">
<span<?= $Page->desainsekunder->viewAttributes() ?>>
<?= $Page->desainsekunder->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->materialinnerbox->Visible) { // materialinnerbox ?>
    <tr id="r_materialinnerbox">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_materialinnerbox"><template id="tpc_npd_confirmprint_materialinnerbox"><?= $Page->materialinnerbox->caption() ?></template></span></td>
        <td data-name="materialinnerbox" <?= $Page->materialinnerbox->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_materialinnerbox"><span id="el_npd_confirmprint_materialinnerbox">
<span<?= $Page->materialinnerbox->viewAttributes() ?>>
<?= $Page->materialinnerbox->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiinnerbox->Visible) { // aplikasiinnerbox ?>
    <tr id="r_aplikasiinnerbox">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_aplikasiinnerbox"><template id="tpc_npd_confirmprint_aplikasiinnerbox"><?= $Page->aplikasiinnerbox->caption() ?></template></span></td>
        <td data-name="aplikasiinnerbox" <?= $Page->aplikasiinnerbox->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_aplikasiinnerbox"><span id="el_npd_confirmprint_aplikasiinnerbox">
<span<?= $Page->aplikasiinnerbox->viewAttributes() ?>>
<?= $Page->aplikasiinnerbox->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahcetak->Visible) { // jumlahcetak ?>
    <tr id="r_jumlahcetak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_jumlahcetak"><template id="tpc_npd_confirmprint_jumlahcetak"><?= $Page->jumlahcetak->caption() ?></template></span></td>
        <td data-name="jumlahcetak" <?= $Page->jumlahcetak->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_jumlahcetak"><span id="el_npd_confirmprint_jumlahcetak">
<span<?= $Page->jumlahcetak->viewAttributes() ?>>
<?= $Page->jumlahcetak->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <tr id="r_checked_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_checked_by"><template id="tpc_npd_confirmprint_checked_by"><?= $Page->checked_by->caption() ?></template></span></td>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_checked_by"><span id="el_npd_confirmprint_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_approved_by"><template id="tpc_npd_confirmprint_approved_by"><?= $Page->approved_by->caption() ?></template></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_approved_by"><span id="el_npd_confirmprint_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_created_at"><template id="tpc_npd_confirmprint_created_at"><?= $Page->created_at->caption() ?></template></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_created_at"><span id="el_npd_confirmprint_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_confirmprint_updated_at"><template id="tpc_npd_confirmprint_updated_at"><?= $Page->updated_at->caption() ?></template></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_updated_at"><span id="el_npd_confirmprint_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_npd_confirmprintview" class="ew-custom-template"></div>
<template id="tpm_npd_confirmprintview">
<div id="ct_NpdConfirmprintView"><div class="card">
    <div class="card-body row">
        <div class="col-6">
            <table class="table table-striped table-sm ew-view-table">            
                <tr>
                    <th class="text-right w-col-3"><slot class="ew-slot" name="tpcaption_idnpd"></slot></th>
                    <td><slot class="ew-slot" name="tpx_idnpd"></slot></td>
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
                    <th class="text-right w-col-3"><slot class="ew-slot" name="tpcaption_tglterima"></slot></th>
                    <td><slot class="ew-slot" name="tpx_tglterima"></slot></td>
                </tr>
                <tr>
                    <th class="text-right w-col-3"><slot class="ew-slot" name="tpcaption_tglsubmit"></slot></th>
                    <td><slot class="ew-slot" name="tpx_tglsubmit"></slot></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">MERK</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->brand->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_brand"></slot></td>
            </tr>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">DESAIN LABEL KEMASAN PRIMER</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm ew-view-table">
            <tr>
                <th class="text-right w-col-3"><?= $Page->tglkirim->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_tglkirim"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->tgldisetujui->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_tgldisetujui"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->desainprimer->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_desainprimer"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->materialprimer->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_materialprimer"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasiprimer->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_aplikasiprimer"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->jumlahcetakprimer->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_jumlahcetakprimer"></slot></td>
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
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_desainsekunder"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->materialinnerbox->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_materialinnerbox"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->aplikasiinnerbox->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_aplikasiinnerbox"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->jumlahcetak->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_jumlahcetak"></slot></td>
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
                <th class="text-right w-col-3"><slot class="ew-slot" name="tpcaption_submitted_by"></slot></th>
                <td><slot class="ew-slot" name="tpx_submitted_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->checked_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_checked_by"></slot></td>
            </tr>
            <tr>
                <th class="text-right w-col-3"><?= $Page->approved_by->caption() ?></th>
                <td><slot class="ew-slot" name="tpx_npd_confirmprint_approved_by"></slot></td>
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
    ew.applyTemplate("tpd_npd_confirmprintview", "tpm_npd_confirmprintview", "npd_confirmprintview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
