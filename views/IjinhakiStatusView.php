<?php

namespace PHPMaker2021\distributor;

// Page object
$IjinhakiStatusView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinhaki_statusview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fijinhaki_statusview = currentForm = new ew.Form("fijinhaki_statusview", "view");
    loadjs.done("fijinhaki_statusview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ijinhaki_status) ew.vars.tables.ijinhaki_status = <?= JsonEncode(GetClientVar("tables", "ijinhaki_status")) ?>;
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
<form name="fijinhaki_statusview" id="fijinhaki_statusview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki_status">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_ijinhaki_status_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_ijinhaki_status_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->targetmulai->Visible) { // targetmulai ?>
    <tr id="r_targetmulai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_targetmulai"><?= $Page->targetmulai->caption() ?></span></td>
        <td data-name="targetmulai" <?= $Page->targetmulai->cellAttributes() ?>>
<span id="el_ijinhaki_status_targetmulai">
<span<?= $Page->targetmulai->viewAttributes() ?>>
<?= $Page->targetmulai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglmulai->Visible) { // tglmulai ?>
    <tr id="r_tglmulai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_tglmulai"><?= $Page->tglmulai->caption() ?></span></td>
        <td data-name="tglmulai" <?= $Page->tglmulai->cellAttributes() ?>>
<span id="el_ijinhaki_status_tglmulai">
<span<?= $Page->tglmulai->viewAttributes() ?>>
<?= $Page->tglmulai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->targetselesai->Visible) { // targetselesai ?>
    <tr id="r_targetselesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_targetselesai"><?= $Page->targetselesai->caption() ?></span></td>
        <td data-name="targetselesai" <?= $Page->targetselesai->cellAttributes() ?>>
<span id="el_ijinhaki_status_targetselesai">
<span<?= $Page->targetselesai->viewAttributes() ?>>
<?= $Page->targetselesai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglselesai->Visible) { // tglselesai ?>
    <tr id="r_tglselesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_tglselesai"><?= $Page->tglselesai->caption() ?></span></td>
        <td data-name="tglselesai" <?= $Page->tglselesai->cellAttributes() ?>>
<span id="el_ijinhaki_status_tglselesai">
<span<?= $Page->tglselesai->viewAttributes() ?>>
<?= $Page->tglselesai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_ijinhaki_status_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <tr id="r_lampiran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinhaki_status_lampiran"><?= $Page->lampiran->caption() ?></span></td>
        <td data-name="lampiran" <?= $Page->lampiran->cellAttributes() ?>>
<span id="el_ijinhaki_status_lampiran">
<span<?= $Page->lampiran->viewAttributes() ?>>
<?= GetFileViewTag($Page->lampiran, $Page->lampiran->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
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
