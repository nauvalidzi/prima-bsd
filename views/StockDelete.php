<?php

namespace PHPMaker2021\distributor;

// Page object
$StockDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstockdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fstockdelete = currentForm = new ew.Form("fstockdelete", "delete");
    loadjs.done("fstockdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.stock) ew.vars.tables.stock = <?= JsonEncode(GetClientVar("tables", "stock")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fstockdelete" id="fstockdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock">
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
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <th class="<?= $Page->idproduct->headerCellClass() ?>"><span id="elh_stock_idproduct" class="stock_idproduct"><?= $Page->idproduct->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <th class="<?= $Page->idorder_detail->headerCellClass() ?>"><span id="elh_stock_idorder_detail" class="stock_idorder_detail"><?= $Page->idorder_detail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><span id="elh_stock_jumlah" class="stock_jumlah"><?= $Page->jumlah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <th class="<?= $Page->aktif->headerCellClass() ?>"><span id="elh_stock_aktif" class="stock_aktif"><?= $Page->aktif->caption() ?></span></th>
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
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <td <?= $Page->idproduct->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_idproduct" class="stock_idproduct">
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <td <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_idorder_detail" class="stock_idorder_detail">
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <td <?= $Page->jumlah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_jumlah" class="stock_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <td <?= $Page->aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_aktif" class="stock_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_aktif_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->aktif->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->aktif->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_aktif_<?= $Page->RowCount ?>"></label>
</div></span>
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
