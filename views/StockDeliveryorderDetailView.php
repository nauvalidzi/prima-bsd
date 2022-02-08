<?php

namespace PHPMaker2021\production2;

// Page object
$StockDeliveryorderDetailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fstock_deliveryorder_detailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fstock_deliveryorder_detailview = currentForm = new ew.Form("fstock_deliveryorder_detailview", "view");
    loadjs.done("fstock_deliveryorder_detailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.stock_deliveryorder_detail) ew.vars.tables.stock_deliveryorder_detail = <?= JsonEncode(GetClientVar("tables", "stock_deliveryorder_detail")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fstock_deliveryorder_detailview" id="fstock_deliveryorder_detailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock_deliveryorder_detail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idstockorder->Visible) { // idstockorder ?>
    <tr id="r_idstockorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stock_deliveryorder_detail_idstockorder"><?= $Page->idstockorder->caption() ?></span></td>
        <td data-name="idstockorder" <?= $Page->idstockorder->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_idstockorder">
<span<?= $Page->idstockorder->viewAttributes() ?>>
<?= $Page->idstockorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
    <tr id="r_idstockorder_detail">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stock_deliveryorder_detail_idstockorder_detail"><?= $Page->idstockorder_detail->caption() ?></span></td>
        <td data-name="idstockorder_detail" <?= $Page->idstockorder_detail->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_idstockorder_detail">
<span<?= $Page->idstockorder_detail->viewAttributes() ?>>
<?= $Page->idstockorder_detail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
    <tr id="r_totalorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stock_deliveryorder_detail_totalorder"><?= $Page->totalorder->caption() ?></span></td>
        <td data-name="totalorder" <?= $Page->totalorder->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_totalorder">
<span<?= $Page->totalorder->viewAttributes() ?>>
<?= $Page->totalorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <tr id="r_sisa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stock_deliveryorder_detail_sisa"><?= $Page->sisa->caption() ?></span></td>
        <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlah_kirim->Visible) { // jumlah_kirim ?>
    <tr id="r_jumlah_kirim">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stock_deliveryorder_detail_jumlah_kirim"><?= $Page->jumlah_kirim->caption() ?></span></td>
        <td data-name="jumlah_kirim" <?= $Page->jumlah_kirim->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_jumlah_kirim">
<span<?= $Page->jumlah_kirim->viewAttributes() ?>>
<?= $Page->jumlah_kirim->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stock_deliveryorder_detail_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
