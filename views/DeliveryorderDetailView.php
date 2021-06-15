<?php

namespace PHPMaker2021\distributor;

// Page object
$DeliveryorderDetailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fdeliveryorder_detailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fdeliveryorder_detailview = currentForm = new ew.Form("fdeliveryorder_detailview", "view");
    loadjs.done("fdeliveryorder_detailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.deliveryorder_detail) ew.vars.tables.deliveryorder_detail = <?= JsonEncode(GetClientVar("tables", "deliveryorder_detail")) ?>;
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
<form name="fdeliveryorder_detailview" id="fdeliveryorder_detailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="deliveryorder_detail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idorder->Visible) { // idorder ?>
    <tr id="r_idorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_deliveryorder_detail_idorder"><?= $Page->idorder->caption() ?></span></td>
        <td data-name="idorder" <?= $Page->idorder->cellAttributes() ?>>
<span id="el_deliveryorder_detail_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
    <tr id="r_idorder_detail">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_deliveryorder_detail_idorder_detail"><?= $Page->idorder_detail->caption() ?></span></td>
        <td data-name="idorder_detail" <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el_deliveryorder_detail_idorder_detail">
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <tr id="r_sisa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_deliveryorder_detail_sisa"><?= $Page->sisa->caption() ?></span></td>
        <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
<span id="el_deliveryorder_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
    <tr id="r_jumlahkirim">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_deliveryorder_detail_jumlahkirim"><?= $Page->jumlahkirim->caption() ?></span></td>
        <td data-name="jumlahkirim" <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el_deliveryorder_detail_jumlahkirim">
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
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
