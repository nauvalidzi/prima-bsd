<?php

namespace PHPMaker2021\production2;

// Page object
$SatuanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsatuandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsatuandelete = currentForm = new ew.Form("fsatuandelete", "delete");
    loadjs.done("fsatuandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.satuan) ew.vars.tables.satuan = <?= JsonEncode(GetClientVar("tables", "satuan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsatuandelete" id="fsatuandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="satuan">
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
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_satuan_nama" class="satuan_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->konversi->Visible) { // konversi ?>
        <th class="<?= $Page->konversi->headerCellClass() ?>"><span id="elh_satuan_konversi" class="satuan_konversi"><?= $Page->konversi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unit_konversi->Visible) { // unit_konversi ?>
        <th class="<?= $Page->unit_konversi->headerCellClass() ?>"><span id="elh_satuan_unit_konversi" class="satuan_unit_konversi"><?= $Page->unit_konversi->caption() ?></span></th>
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
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_satuan_nama" class="satuan_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->konversi->Visible) { // konversi ?>
        <td <?= $Page->konversi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_satuan_konversi" class="satuan_konversi">
<span<?= $Page->konversi->viewAttributes() ?>>
<?= $Page->konversi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unit_konversi->Visible) { // unit_konversi ?>
        <td <?= $Page->unit_konversi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_satuan_unit_konversi" class="satuan_unit_konversi">
<span<?= $Page->unit_konversi->viewAttributes() ?>>
<?= $Page->unit_konversi->getViewValue() ?></span>
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
