<?php

namespace PHPMaker2021\distributor;

// Page object
$InvoiceDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var finvoicedelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    finvoicedelete = currentForm = new ew.Form("finvoicedelete", "delete");
    loadjs.done("finvoicedelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.invoice) ew.vars.tables.invoice = <?= JsonEncode(GetClientVar("tables", "invoice")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="finvoicedelete" id="finvoicedelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice">
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
<?php if ($Page->kode->Visible) { // kode ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_invoice_kode" class="invoice_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
        <th class="<?= $Page->tglinvoice->headerCellClass() ?>"><span id="elh_invoice_tglinvoice" class="invoice_tglinvoice"><?= $Page->tglinvoice->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_invoice_idcustomer" class="invoice_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><span id="elh_invoice_idorder" class="invoice_idorder"><?= $Page->idorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <th class="<?= $Page->totaltagihan->headerCellClass() ?>"><span id="elh_invoice_totaltagihan" class="invoice_totaltagihan"><?= $Page->totaltagihan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <th class="<?= $Page->sisabayar->headerCellClass() ?>"><span id="elh_invoice_sisabayar" class="invoice_sisabayar"><?= $Page->sisabayar->caption() ?></span></th>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <td <?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_kode" class="invoice_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
        <td <?= $Page->tglinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_tglinvoice" class="invoice_tglinvoice">
<span<?= $Page->tglinvoice->viewAttributes() ?>>
<?= $Page->tglinvoice->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_idcustomer" class="invoice_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
        <td <?= $Page->idorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_idorder" class="invoice_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?php if (!EmptyString($Page->idorder->getViewValue()) && $Page->idorder->linkAttributes() != "") { ?>
<a<?= $Page->idorder->linkAttributes() ?>><?= $Page->idorder->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->idorder->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <td <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_totaltagihan" class="invoice_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <td <?= $Page->sisabayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_sisabayar" class="invoice_sisabayar">
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->getViewValue() ?></span>
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
