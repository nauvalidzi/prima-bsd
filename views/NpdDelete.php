<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpddelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpddelete = currentForm = new ew.Form("fnpddelete", "delete");
    loadjs.done("fnpddelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd) ew.vars.tables.npd = <?= JsonEncode(GetClientVar("tables", "npd")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpddelete" id="fnpddelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
        <th class="<?= $Page->tanggal_order->headerCellClass() ?>"><span id="elh_npd_tanggal_order" class="npd_tanggal_order"><?= $Page->tanggal_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
        <th class="<?= $Page->target_selesai->headerCellClass() ?>"><span id="elh_npd_target_selesai" class="npd_target_selesai"><?= $Page->target_selesai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><span id="elh_npd_idbrand" class="npd_idbrand"><?= $Page->idbrand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
        <th class="<?= $Page->sifatorder->headerCellClass() ?>"><span id="elh_npd_sifatorder" class="npd_sifatorder"><?= $Page->sifatorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <th class="<?= $Page->kodeorder->headerCellClass() ?>"><span id="elh_npd_kodeorder" class="npd_kodeorder"><?= $Page->kodeorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nomororder->Visible) { // nomororder ?>
        <th class="<?= $Page->nomororder->headerCellClass() ?>"><span id="elh_npd_nomororder" class="npd_nomororder"><?= $Page->nomororder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_npd_idpegawai" class="npd_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_npd_idcustomer" class="npd_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_status" class="npd_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_npd_updated_at" class="npd_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
        <td <?= $Page->tanggal_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_tanggal_order" class="npd_tanggal_order">
<span<?= $Page->tanggal_order->viewAttributes() ?>>
<?= $Page->tanggal_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
        <td <?= $Page->target_selesai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_target_selesai" class="npd_target_selesai">
<span<?= $Page->target_selesai->viewAttributes() ?>>
<?= $Page->target_selesai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <td <?= $Page->idbrand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idbrand" class="npd_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
        <td <?= $Page->sifatorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sifatorder" class="npd_sifatorder">
<span<?= $Page->sifatorder->viewAttributes() ?>>
<?= $Page->sifatorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <td <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kodeorder" class="npd_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nomororder->Visible) { // nomororder ?>
        <td <?= $Page->nomororder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_nomororder" class="npd_nomororder">
<span<?= $Page->nomororder->viewAttributes() ?>>
<?= $Page->nomororder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idpegawai" class="npd_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idcustomer" class="npd_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status" class="npd_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_updated_at" class="npd_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
