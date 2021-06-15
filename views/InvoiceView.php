<?php

namespace PHPMaker2021\distributor;

// Page object
$InvoiceView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var finvoiceview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    finvoiceview = currentForm = new ew.Form("finvoiceview", "view");
    loadjs.done("finvoiceview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.invoice) ew.vars.tables.invoice = <?= JsonEncode(GetClientVar("tables", "invoice")) ?>;
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
<form name="finvoiceview" id="finvoiceview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_invoice_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
    <tr id="r_tglinvoice">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_tglinvoice"><?= $Page->tglinvoice->caption() ?></span></td>
        <td data-name="tglinvoice" <?= $Page->tglinvoice->cellAttributes() ?>>
<span id="el_invoice_tglinvoice">
<span<?= $Page->tglinvoice->viewAttributes() ?>>
<?= $Page->tglinvoice->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_invoice_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
    <tr id="r_idorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_idorder"><?= $Page->idorder->caption() ?></span></td>
        <td data-name="idorder" <?= $Page->idorder->cellAttributes() ?>>
<span id="el_invoice_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totalnonpajak->Visible) { // totalnonpajak ?>
    <tr id="r_totalnonpajak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_totalnonpajak"><?= $Page->totalnonpajak->caption() ?></span></td>
        <td data-name="totalnonpajak" <?= $Page->totalnonpajak->cellAttributes() ?>>
<span id="el_invoice_totalnonpajak">
<span<?= $Page->totalnonpajak->viewAttributes() ?>>
<?= $Page->totalnonpajak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pajak->Visible) { // pajak ?>
    <tr id="r_pajak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_pajak"><?= $Page->pajak->caption() ?></span></td>
        <td data-name="pajak" <?= $Page->pajak->cellAttributes() ?>>
<span id="el_invoice_pajak">
<span<?= $Page->pajak->viewAttributes() ?>>
<?= $Page->pajak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <tr id="r_totaltagihan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_totaltagihan"><?= $Page->totaltagihan->caption() ?></span></td>
        <td data-name="totaltagihan" <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el_invoice_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
    <tr id="r_sisabayar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_sisabayar"><?= $Page->sisabayar->caption() ?></span></td>
        <td data-name="sisabayar" <?= $Page->sisabayar->cellAttributes() ?>>
<span id="el_invoice_sisabayar">
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idtermpayment->Visible) { // idtermpayment ?>
    <tr id="r_idtermpayment">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_idtermpayment"><?= $Page->idtermpayment->caption() ?></span></td>
        <td data-name="idtermpayment" <?= $Page->idtermpayment->cellAttributes() ?>>
<span id="el_invoice_idtermpayment">
<span<?= $Page->idtermpayment->viewAttributes() ?>>
<?= $Page->idtermpayment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idtipepayment->Visible) { // idtipepayment ?>
    <tr id="r_idtipepayment">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_idtipepayment"><?= $Page->idtipepayment->caption() ?></span></td>
        <td data-name="idtipepayment" <?= $Page->idtipepayment->cellAttributes() ?>>
<span id="el_invoice_idtipepayment">
<span<?= $Page->idtipepayment->viewAttributes() ?>>
<?= $Page->idtipepayment->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_invoice_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_invoice_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("invoice_detail", explode(",", $Page->getCurrentDetailTable())) && $invoice_detail->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("invoice_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "InvoiceDetailGrid.php" ?>
<?php } ?>
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
