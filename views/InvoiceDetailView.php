<?php

namespace PHPMaker2021\distributor;

// Page object
$InvoiceDetailView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var finvoice_detailview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    finvoice_detailview = currentForm = new ew.Form("finvoice_detailview", "view");
    loadjs.done("finvoice_detailview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.invoice_detail) ew.vars.tables.invoice_detail = <?= JsonEncode(GetClientVar("tables", "invoice_detail")) ?>;
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
<form name="finvoice_detailview" id="finvoice_detailview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice_detail">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
    <tr id="r_idorder_detail">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_idorder_detail"><?= $Page->idorder_detail->caption() ?></span></td>
        <td data-name="idorder_detail" <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el_invoice_detail_idorder_detail">
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
    <tr id="r_jumlahorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_jumlahorder"><?= $Page->jumlahorder->caption() ?></span></td>
        <td data-name="jumlahorder" <?= $Page->jumlahorder->cellAttributes() ?>>
<span id="el_invoice_detail_jumlahorder">
<span<?= $Page->jumlahorder->viewAttributes() ?>>
<?= $Page->jumlahorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
    <tr id="r_bonus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_bonus"><?= $Page->bonus->caption() ?></span></td>
        <td data-name="bonus" <?= $Page->bonus->cellAttributes() ?>>
<span id="el_invoice_detail_bonus">
<span<?= $Page->bonus->viewAttributes() ?>>
<?= $Page->bonus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->stockdo->Visible) { // stockdo ?>
    <tr id="r_stockdo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_stockdo"><?= $Page->stockdo->caption() ?></span></td>
        <td data-name="stockdo" <?= $Page->stockdo->cellAttributes() ?>>
<span id="el_invoice_detail_stockdo">
<span<?= $Page->stockdo->viewAttributes() ?>>
<?= $Page->stockdo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
    <tr id="r_jumlahkirim">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_jumlahkirim"><?= $Page->jumlahkirim->caption() ?></span></td>
        <td data-name="jumlahkirim" <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el_invoice_detail_jumlahkirim">
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
    <tr id="r_jumlahbonus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_jumlahbonus"><?= $Page->jumlahbonus->caption() ?></span></td>
        <td data-name="jumlahbonus" <?= $Page->jumlahbonus->cellAttributes() ?>>
<span id="el_invoice_detail_jumlahbonus">
<span<?= $Page->jumlahbonus->viewAttributes() ?>>
<?= $Page->jumlahbonus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <tr id="r_harga">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_harga"><?= $Page->harga->caption() ?></span></td>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el_invoice_detail_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
    <tr id="r_totalnondiskon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_totalnondiskon"><?= $Page->totalnondiskon->caption() ?></span></td>
        <td data-name="totalnondiskon" <?= $Page->totalnondiskon->cellAttributes() ?>>
<span id="el_invoice_detail_totalnondiskon">
<span<?= $Page->totalnondiskon->viewAttributes() ?>>
<?= $Page->totalnondiskon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
    <tr id="r_diskonpayment">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_diskonpayment"><?= $Page->diskonpayment->caption() ?></span></td>
        <td data-name="diskonpayment" <?= $Page->diskonpayment->cellAttributes() ?>>
<span id="el_invoice_detail_diskonpayment">
<span<?= $Page->diskonpayment->viewAttributes() ?>>
<?= $Page->diskonpayment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bbpersen->Visible) { // bbpersen ?>
    <tr id="r_bbpersen">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_bbpersen"><?= $Page->bbpersen->caption() ?></span></td>
        <td data-name="bbpersen" <?= $Page->bbpersen->cellAttributes() ?>>
<span id="el_invoice_detail_bbpersen">
<span<?= $Page->bbpersen->viewAttributes() ?>>
<?= $Page->bbpersen->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <tr id="r_totaltagihan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_totaltagihan"><?= $Page->totaltagihan->caption() ?></span></td>
        <td data-name="totaltagihan" <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el_invoice_detail_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
    <tr id="r_blackbonus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_detail_blackbonus"><?= $Page->blackbonus->caption() ?></span></td>
        <td data-name="blackbonus" <?= $Page->blackbonus->cellAttributes() ?>>
<span id="el_invoice_detail_blackbonus">
<span<?= $Page->blackbonus->viewAttributes() ?>>
<?= $Page->blackbonus->getViewValue() ?></span>
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
