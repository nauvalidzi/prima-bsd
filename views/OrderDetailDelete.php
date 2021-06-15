<?php

namespace PHPMaker2021\distributor;

// Page object
$OrderDetailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var forder_detaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    forder_detaildelete = currentForm = new ew.Form("forder_detaildelete", "delete");
    loadjs.done("forder_detaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.order_detail) ew.vars.tables.order_detail = <?= JsonEncode(GetClientVar("tables", "order_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="forder_detaildelete" id="forder_detaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_detail">
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
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><span id="elh_order_detail_idbrand" class="order_detail_idbrand"><?= $Page->idbrand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <th class="<?= $Page->idproduct->headerCellClass() ?>"><span id="elh_order_detail_idproduct" class="order_detail_idproduct"><?= $Page->idproduct->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><span id="elh_order_detail_jumlah" class="order_detail_jumlah"><?= $Page->jumlah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
        <th class="<?= $Page->bonus->headerCellClass() ?>"><span id="elh_order_detail_bonus" class="order_detail_bonus"><?= $Page->bonus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th class="<?= $Page->sisa->headerCellClass() ?>"><span id="elh_order_detail_sisa" class="order_detail_sisa"><?= $Page->sisa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <th class="<?= $Page->harga->headerCellClass() ?>"><span id="elh_order_detail_harga" class="order_detail_harga"><?= $Page->harga->caption() ?></span></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th class="<?= $Page->total->headerCellClass() ?>"><span id="elh_order_detail_total" class="order_detail_total"><?= $Page->total->caption() ?></span></th>
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
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <td <?= $Page->idbrand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_detail_idbrand" class="order_detail_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <td <?= $Page->idproduct->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_detail_idproduct" class="order_detail_idproduct">
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <td <?= $Page->jumlah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_detail_jumlah" class="order_detail_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
        <td <?= $Page->bonus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_detail_bonus" class="order_detail_bonus">
<span<?= $Page->bonus->viewAttributes() ?>>
<?= $Page->bonus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <td <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_detail_sisa" class="order_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <td <?= $Page->harga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_detail_harga" class="order_detail_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <td <?= $Page->total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_detail_total" class="order_detail_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
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
