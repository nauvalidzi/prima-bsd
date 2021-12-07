<?php

namespace PHPMaker2021\distributor;

// Page object
$StockOrderDetailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstock_order_detaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fstock_order_detaildelete = currentForm = new ew.Form("fstock_order_detaildelete", "delete");
    loadjs.done("fstock_order_detaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.stock_order_detail) ew.vars.tables.stock_order_detail = <?= JsonEncode(GetClientVar("tables", "stock_order_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fstock_order_detaildelete" id="fstock_order_detaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock_order_detail">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_stock_order_detail_id" class="stock_order_detail_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_stock_order_detail_pid" class="stock_order_detail_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><span id="elh_stock_order_detail_idbrand" class="stock_order_detail_idbrand"><?= $Page->idbrand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <th class="<?= $Page->idproduct->headerCellClass() ?>"><span id="elh_stock_order_detail_idproduct" class="stock_order_detail_idproduct"><?= $Page->idproduct->caption() ?></span></th>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
        <th class="<?= $Page->stok_akhir->headerCellClass() ?>"><span id="elh_stock_order_detail_stok_akhir" class="stock_order_detail_stok_akhir"><?= $Page->stok_akhir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><span id="elh_stock_order_detail_jumlah" class="stock_order_detail_jumlah"><?= $Page->jumlah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th class="<?= $Page->sisa->headerCellClass() ?>"><span id="elh_stock_order_detail_sisa" class="stock_order_detail_sisa"><?= $Page->sisa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <th class="<?= $Page->aktif->headerCellClass() ?>"><span id="elh_stock_order_detail_aktif" class="stock_order_detail_aktif"><?= $Page->aktif->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_stock_order_detail_id" class="stock_order_detail_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_order_detail_pid" class="stock_order_detail_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <td <?= $Page->idbrand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_order_detail_idbrand" class="stock_order_detail_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <td <?= $Page->idproduct->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_order_detail_idproduct" class="stock_order_detail_idproduct">
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
        <td <?= $Page->stok_akhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_order_detail_stok_akhir" class="stock_order_detail_stok_akhir">
<span<?= $Page->stok_akhir->viewAttributes() ?>>
<?= $Page->stok_akhir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <td <?= $Page->jumlah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_order_detail_jumlah" class="stock_order_detail_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <td <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_order_detail_sisa" class="stock_order_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <td <?= $Page->aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_order_detail_aktif" class="stock_order_detail_aktif">
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
