<?php

namespace PHPMaker2021\production2;

// Page object
$NpdSampleDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_sampledelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_sampledelete = currentForm = new ew.Form("fnpd_sampledelete", "delete");
    loadjs.done("fnpd_sampledelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_sample) ew.vars.tables.npd_sample = <?= JsonEncode(GetClientVar("tables", "npd_sample")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_sampledelete" id="fnpd_sampledelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_sample">
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
<?php if ($Page->kode->Visible) { // kode ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_npd_sample_kode" class="npd_sample_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_npd_sample_nama" class="npd_sample_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <th class="<?= $Page->sediaan->headerCellClass() ?>"><span id="elh_npd_sample_sediaan" class="npd_sample_sediaan"><?= $Page->sediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th class="<?= $Page->warna->headerCellClass() ?>"><span id="elh_npd_sample_warna" class="npd_sample_warna"><?= $Page->warna->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fungsi->Visible) { // fungsi ?>
        <th class="<?= $Page->fungsi->headerCellClass() ?>"><span id="elh_npd_sample_fungsi" class="npd_sample_fungsi"><?= $Page->fungsi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><span id="elh_npd_sample_jumlah" class="npd_sample_jumlah"><?= $Page->jumlah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
        <th class="<?= $Page->volume->headerCellClass() ?>"><span id="elh_npd_sample_volume" class="npd_sample_volume"><?= $Page->volume->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bau->Visible) { // bau ?>
        <th class="<?= $Page->bau->headerCellClass() ?>"><span id="elh_npd_sample_bau" class="npd_sample_bau"><?= $Page->bau->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_sample_status" class="npd_sample_status"><?= $Page->status->caption() ?></span></th>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <td <?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_kode" class="npd_sample_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_nama" class="npd_sample_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <td <?= $Page->sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_sediaan" class="npd_sample_sediaan">
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <td <?= $Page->warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_warna" class="npd_sample_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fungsi->Visible) { // fungsi ?>
        <td <?= $Page->fungsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_fungsi" class="npd_sample_fungsi">
<span<?= $Page->fungsi->viewAttributes() ?>>
<?= $Page->fungsi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <td <?= $Page->jumlah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_jumlah" class="npd_sample_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
        <td <?= $Page->volume->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_volume" class="npd_sample_volume">
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bau->Visible) { // bau ?>
        <td <?= $Page->bau->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_bau" class="npd_sample_bau">
<span<?= $Page->bau->viewAttributes() ?>>
<?= $Page->bau->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_sample_status" class="npd_sample_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
