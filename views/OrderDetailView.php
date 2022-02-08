<?php

namespace PHPMaker2021\production2;

// Page object
$OrderDetailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forder_detailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    forder_detailview = currentForm = new ew.Form("forder_detailview", "view");
    loadjs.done("forder_detailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.order_detail) ew.vars.tables.order_detail = <?= JsonEncode(GetClientVar("tables", "order_detail")) ?>;
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
<form name="forder_detailview" id="forder_detailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_detail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idproduct->Visible) { // idproduct ?>
    <tr id="r_idproduct">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_idproduct"><?= $Page->idproduct->caption() ?></span></td>
        <td data-name="idproduct" <?= $Page->idproduct->cellAttributes() ?>>
<span id="el_order_detail_idproduct">
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <tr id="r_jumlah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_jumlah"><?= $Page->jumlah->caption() ?></span></td>
        <td data-name="jumlah" <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_order_detail_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
    <tr id="r_bonus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_bonus"><?= $Page->bonus->caption() ?></span></td>
        <td data-name="bonus" <?= $Page->bonus->cellAttributes() ?>>
<span id="el_order_detail_bonus">
<span<?= $Page->bonus->viewAttributes() ?>>
<?= $Page->bonus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <tr id="r_sisa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_sisa"><?= $Page->sisa->caption() ?></span></td>
        <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
<span id="el_order_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <tr id="r_harga">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_harga"><?= $Page->harga->caption() ?></span></td>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el_order_detail_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <tr id="r_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_total"><?= $Page->total->caption() ?></span></td>
        <td data-name="total" <?= $Page->total->cellAttributes() ?>>
<span id="el_order_detail_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipe_sla->Visible) { // tipe_sla ?>
    <tr id="r_tipe_sla">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_tipe_sla"><?= $Page->tipe_sla->caption() ?></span></td>
        <td data-name="tipe_sla" <?= $Page->tipe_sla->cellAttributes() ?>>
<span id="el_order_detail_tipe_sla">
<span<?= $Page->tipe_sla->viewAttributes() ?>>
<?= $Page->tipe_sla->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sla->Visible) { // sla ?>
    <tr id="r_sla">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_sla"><?= $Page->sla->caption() ?></span></td>
        <td data-name="sla" <?= $Page->sla->cellAttributes() ?>>
<span id="el_order_detail_sla">
<span<?= $Page->sla->viewAttributes() ?>>
<?= $Page->sla->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_detail_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_order_detail_keterangan">
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
