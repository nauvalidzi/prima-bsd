<?php

namespace PHPMaker2021\distributor;

// Page object
$StockDeliveryorderDetailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstock_deliveryorder_detaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fstock_deliveryorder_detaildelete = currentForm = new ew.Form("fstock_deliveryorder_detaildelete", "delete");
    loadjs.done("fstock_deliveryorder_detaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.stock_deliveryorder_detail) ew.vars.tables.stock_deliveryorder_detail = <?= JsonEncode(GetClientVar("tables", "stock_deliveryorder_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fstock_deliveryorder_detaildelete" id="fstock_deliveryorder_detaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock_deliveryorder_detail">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_stock_deliveryorder_detail_id" class="stock_deliveryorder_detail_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_stock_deliveryorder_detail_pid" class="stock_deliveryorder_detail_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idstock_order_detail->Visible) { // idstock_order_detail ?>
        <th class="<?= $Page->idstock_order_detail->headerCellClass() ?>"><span id="elh_stock_deliveryorder_detail_idstock_order_detail" class="stock_deliveryorder_detail_idstock_order_detail"><?= $Page->idstock_order_detail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
        <th class="<?= $Page->totalorder->headerCellClass() ?>"><span id="elh_stock_deliveryorder_detail_totalorder" class="stock_deliveryorder_detail_totalorder"><?= $Page->totalorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah_kirim->Visible) { // jumlah_kirim ?>
        <th class="<?= $Page->jumlah_kirim->headerCellClass() ?>"><span id="elh_stock_deliveryorder_detail_jumlah_kirim" class="stock_deliveryorder_detail_jumlah_kirim"><?= $Page->jumlah_kirim->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th class="<?= $Page->sisa->headerCellClass() ?>"><span id="elh_stock_deliveryorder_detail_sisa" class="stock_deliveryorder_detail_sisa"><?= $Page->sisa->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_id" class="stock_deliveryorder_detail_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_pid" class="stock_deliveryorder_detail_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idstock_order_detail->Visible) { // idstock_order_detail ?>
        <td <?= $Page->idstock_order_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_idstock_order_detail" class="stock_deliveryorder_detail_idstock_order_detail">
<span<?= $Page->idstock_order_detail->viewAttributes() ?>>
<?= $Page->idstock_order_detail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
        <td <?= $Page->totalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_totalorder" class="stock_deliveryorder_detail_totalorder">
<span<?= $Page->totalorder->viewAttributes() ?>>
<?= $Page->totalorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah_kirim->Visible) { // jumlah_kirim ?>
        <td <?= $Page->jumlah_kirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_jumlah_kirim" class="stock_deliveryorder_detail_jumlah_kirim">
<span<?= $Page->jumlah_kirim->viewAttributes() ?>>
<?= $Page->jumlah_kirim->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <td <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_sisa" class="stock_deliveryorder_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
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
