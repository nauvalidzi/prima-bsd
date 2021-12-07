<?php

namespace PHPMaker2021\distributor;

// Page object
$StocksDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstocksdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fstocksdelete = currentForm = new ew.Form("fstocksdelete", "delete");
    loadjs.done("fstocksdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.stocks) ew.vars.tables.stocks = <?= JsonEncode(GetClientVar("tables", "stocks")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fstocksdelete" id="fstocksdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stocks">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_stocks_id" class="stocks_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->prop_id->Visible) { // prop_id ?>
        <th class="<?= $Page->prop_id->headerCellClass() ?>"><span id="elh_stocks_prop_id" class="stocks_prop_id"><?= $Page->prop_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->prop_code->Visible) { // prop_code ?>
        <th class="<?= $Page->prop_code->headerCellClass() ?>"><span id="elh_stocks_prop_code" class="stocks_prop_code"><?= $Page->prop_code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <th class="<?= $Page->idproduct->headerCellClass() ?>"><span id="elh_stocks_idproduct" class="stocks_idproduct"><?= $Page->idproduct->caption() ?></span></th>
<?php } ?>
<?php if ($Page->stok_masuk->Visible) { // stok_masuk ?>
        <th class="<?= $Page->stok_masuk->headerCellClass() ?>"><span id="elh_stocks_stok_masuk" class="stocks_stok_masuk"><?= $Page->stok_masuk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->stok_keluar->Visible) { // stok_keluar ?>
        <th class="<?= $Page->stok_keluar->headerCellClass() ?>"><span id="elh_stocks_stok_keluar" class="stocks_stok_keluar"><?= $Page->stok_keluar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
        <th class="<?= $Page->stok_akhir->headerCellClass() ?>"><span id="elh_stocks_stok_akhir" class="stocks_stok_akhir"><?= $Page->stok_akhir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <th class="<?= $Page->aktif->headerCellClass() ?>"><span id="elh_stocks_aktif" class="stocks_aktif"><?= $Page->aktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_stocks_created_at" class="stocks_created_at"><?= $Page->created_at->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_id" class="stocks_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->prop_id->Visible) { // prop_id ?>
        <td <?= $Page->prop_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_prop_id" class="stocks_prop_id">
<span<?= $Page->prop_id->viewAttributes() ?>>
<?= $Page->prop_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->prop_code->Visible) { // prop_code ?>
        <td <?= $Page->prop_code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_prop_code" class="stocks_prop_code">
<span<?= $Page->prop_code->viewAttributes() ?>>
<?= $Page->prop_code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <td <?= $Page->idproduct->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_idproduct" class="stocks_idproduct">
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->stok_masuk->Visible) { // stok_masuk ?>
        <td <?= $Page->stok_masuk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_stok_masuk" class="stocks_stok_masuk">
<span<?= $Page->stok_masuk->viewAttributes() ?>>
<?= $Page->stok_masuk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->stok_keluar->Visible) { // stok_keluar ?>
        <td <?= $Page->stok_keluar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_stok_keluar" class="stocks_stok_keluar">
<span<?= $Page->stok_keluar->viewAttributes() ?>>
<?= $Page->stok_keluar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
        <td <?= $Page->stok_akhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_stok_akhir" class="stocks_stok_akhir">
<span<?= $Page->stok_akhir->viewAttributes() ?>>
<?= $Page->stok_akhir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <td <?= $Page->aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_aktif" class="stocks_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_aktif_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->aktif->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->aktif->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_aktif_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stocks_created_at" class="stocks_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
