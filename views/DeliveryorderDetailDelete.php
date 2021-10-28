<?php

namespace PHPMaker2021\distributor;

// Page object
$DeliveryorderDetailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdeliveryorder_detaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fdeliveryorder_detaildelete = currentForm = new ew.Form("fdeliveryorder_detaildelete", "delete");
    loadjs.done("fdeliveryorder_detaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.deliveryorder_detail) ew.vars.tables.deliveryorder_detail = <?= JsonEncode(GetClientVar("tables", "deliveryorder_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fdeliveryorder_detaildelete" id="fdeliveryorder_detaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="deliveryorder_detail">
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
<?php if ($Page->idorder->Visible) { // idorder ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><span id="elh_deliveryorder_detail_idorder" class="deliveryorder_detail_idorder"><?= $Page->idorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <th class="<?= $Page->idorder_detail->headerCellClass() ?>"><span id="elh_deliveryorder_detail_idorder_detail" class="deliveryorder_detail_idorder_detail"><?= $Page->idorder_detail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
        <th class="<?= $Page->totalorder->headerCellClass() ?>"><span id="elh_deliveryorder_detail_totalorder" class="deliveryorder_detail_totalorder"><?= $Page->totalorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th class="<?= $Page->sisa->headerCellClass() ?>"><span id="elh_deliveryorder_detail_sisa" class="deliveryorder_detail_sisa"><?= $Page->sisa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <th class="<?= $Page->jumlahkirim->headerCellClass() ?>"><span id="elh_deliveryorder_detail_jumlahkirim" class="deliveryorder_detail_jumlahkirim"><?= $Page->jumlahkirim->caption() ?></span></th>
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
<?php if ($Page->idorder->Visible) { // idorder ?>
        <td <?= $Page->idorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_idorder" class="deliveryorder_detail_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <td <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_idorder_detail" class="deliveryorder_detail_idorder_detail">
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
        <td <?= $Page->totalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_totalorder" class="deliveryorder_detail_totalorder">
<span<?= $Page->totalorder->viewAttributes() ?>>
<?= $Page->totalorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <td <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_sisa" class="deliveryorder_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <td <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_jumlahkirim" class="deliveryorder_detail_jumlahkirim">
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
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
