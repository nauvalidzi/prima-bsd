<?php

namespace PHPMaker2021\production2;

// Page object
$NpdHargaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_hargadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_hargadelete = currentForm = new ew.Form("fnpd_hargadelete", "delete");
    loadjs.done("fnpd_hargadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_harga) ew.vars.tables.npd_harga = <?= JsonEncode(GetClientVar("tables", "npd_harga")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_hargadelete" id="fnpd_hargadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_harga">
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_harga_idnpd" class="npd_harga_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
        <th class="<?= $Page->tglpengajuan->headerCellClass() ?>"><span id="elh_npd_harga_tglpengajuan" class="npd_harga_tglpengajuan"><?= $Page->tglpengajuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><span id="elh_npd_harga_idnpd_sample" class="npd_harga_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></span></th>
<?php } ?>
<?php if ($Page->viskositasbarang->Visible) { // viskositasbarang ?>
        <th class="<?= $Page->viskositasbarang->headerCellClass() ?>"><span id="elh_npd_harga_viskositasbarang" class="npd_harga_viskositasbarang"><?= $Page->viskositasbarang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idaplikasibarang->Visible) { // idaplikasibarang ?>
        <th class="<?= $Page->idaplikasibarang->headerCellClass() ?>"><span id="elh_npd_harga_idaplikasibarang" class="npd_harga_idaplikasibarang"><?= $Page->idaplikasibarang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hargapcs->Visible) { // hargapcs ?>
        <th class="<?= $Page->hargapcs->headerCellClass() ?>"><span id="elh_npd_harga_hargapcs" class="npd_harga_hargapcs"><?= $Page->hargapcs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
        <th class="<?= $Page->disetujui->headerCellClass() ?>"><span id="elh_npd_harga_disetujui" class="npd_harga_disetujui"><?= $Page->disetujui->caption() ?></span></th>
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_harga_idnpd" class="npd_harga_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
        <td <?= $Page->tglpengajuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_harga_tglpengajuan" class="npd_harga_tglpengajuan">
<span<?= $Page->tglpengajuan->viewAttributes() ?>>
<?= $Page->tglpengajuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <td <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_harga_idnpd_sample" class="npd_harga_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->viskositasbarang->Visible) { // viskositasbarang ?>
        <td <?= $Page->viskositasbarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_harga_viskositasbarang" class="npd_harga_viskositasbarang">
<span<?= $Page->viskositasbarang->viewAttributes() ?>>
<?= $Page->viskositasbarang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idaplikasibarang->Visible) { // idaplikasibarang ?>
        <td <?= $Page->idaplikasibarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_harga_idaplikasibarang" class="npd_harga_idaplikasibarang">
<span<?= $Page->idaplikasibarang->viewAttributes() ?>>
<?= $Page->idaplikasibarang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hargapcs->Visible) { // hargapcs ?>
        <td <?= $Page->hargapcs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_harga_hargapcs" class="npd_harga_hargapcs">
<span<?= $Page->hargapcs->viewAttributes() ?>>
<?= $Page->hargapcs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
        <td <?= $Page->disetujui->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_harga_disetujui" class="npd_harga_disetujui">
<span<?= $Page->disetujui->viewAttributes() ?>>
<?= $Page->disetujui->getViewValue() ?></span>
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
