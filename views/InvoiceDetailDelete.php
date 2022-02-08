<?php

namespace PHPMaker2021\production2;

// Page object
$InvoiceDetailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var finvoice_detaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    finvoice_detaildelete = currentForm = new ew.Form("finvoice_detaildelete", "delete");
    loadjs.done("finvoice_detaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.invoice_detail) ew.vars.tables.invoice_detail = <?= JsonEncode(GetClientVar("tables", "invoice_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="finvoice_detaildelete" id="finvoice_detaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice_detail">
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
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <th class="<?= $Page->idorder_detail->headerCellClass() ?>"><span id="elh_invoice_detail_idorder_detail" class="invoice_detail_idorder_detail"><?= $Page->idorder_detail->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
        <th class="<?= $Page->jumlahorder->headerCellClass() ?>"><span id="elh_invoice_detail_jumlahorder" class="invoice_detail_jumlahorder"><?= $Page->jumlahorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
        <th class="<?= $Page->bonus->headerCellClass() ?>"><span id="elh_invoice_detail_bonus" class="invoice_detail_bonus"><?= $Page->bonus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->stockdo->Visible) { // stockdo ?>
        <th class="<?= $Page->stockdo->headerCellClass() ?>"><span id="elh_invoice_detail_stockdo" class="invoice_detail_stockdo"><?= $Page->stockdo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <th class="<?= $Page->jumlahkirim->headerCellClass() ?>"><span id="elh_invoice_detail_jumlahkirim" class="invoice_detail_jumlahkirim"><?= $Page->jumlahkirim->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
        <th class="<?= $Page->jumlahbonus->headerCellClass() ?>"><span id="elh_invoice_detail_jumlahbonus" class="invoice_detail_jumlahbonus"><?= $Page->jumlahbonus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <th class="<?= $Page->harga->headerCellClass() ?>"><span id="elh_invoice_detail_harga" class="invoice_detail_harga"><?= $Page->harga->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
        <th class="<?= $Page->totalnondiskon->headerCellClass() ?>"><span id="elh_invoice_detail_totalnondiskon" class="invoice_detail_totalnondiskon"><?= $Page->totalnondiskon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
        <th class="<?= $Page->diskonpayment->headerCellClass() ?>"><span id="elh_invoice_detail_diskonpayment" class="invoice_detail_diskonpayment"><?= $Page->diskonpayment->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bbpersen->Visible) { // bbpersen ?>
        <th class="<?= $Page->bbpersen->headerCellClass() ?>"><span id="elh_invoice_detail_bbpersen" class="invoice_detail_bbpersen"><?= $Page->bbpersen->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <th class="<?= $Page->totaltagihan->headerCellClass() ?>"><span id="elh_invoice_detail_totaltagihan" class="invoice_detail_totaltagihan"><?= $Page->totaltagihan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
        <th class="<?= $Page->blackbonus->headerCellClass() ?>"><span id="elh_invoice_detail_blackbonus" class="invoice_detail_blackbonus"><?= $Page->blackbonus->caption() ?></span></th>
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
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <td <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_idorder_detail" class="invoice_detail_idorder_detail">
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
        <td <?= $Page->jumlahorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_jumlahorder" class="invoice_detail_jumlahorder">
<span<?= $Page->jumlahorder->viewAttributes() ?>>
<?= $Page->jumlahorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
        <td <?= $Page->bonus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_bonus" class="invoice_detail_bonus">
<span<?= $Page->bonus->viewAttributes() ?>>
<?= $Page->bonus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->stockdo->Visible) { // stockdo ?>
        <td <?= $Page->stockdo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_stockdo" class="invoice_detail_stockdo">
<span<?= $Page->stockdo->viewAttributes() ?>>
<?= $Page->stockdo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <td <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_jumlahkirim" class="invoice_detail_jumlahkirim">
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
        <td <?= $Page->jumlahbonus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_jumlahbonus" class="invoice_detail_jumlahbonus">
<span<?= $Page->jumlahbonus->viewAttributes() ?>>
<?= $Page->jumlahbonus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <td <?= $Page->harga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_harga" class="invoice_detail_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
        <td <?= $Page->totalnondiskon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_totalnondiskon" class="invoice_detail_totalnondiskon">
<span<?= $Page->totalnondiskon->viewAttributes() ?>>
<?= $Page->totalnondiskon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
        <td <?= $Page->diskonpayment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_diskonpayment" class="invoice_detail_diskonpayment">
<span<?= $Page->diskonpayment->viewAttributes() ?>>
<?= $Page->diskonpayment->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bbpersen->Visible) { // bbpersen ?>
        <td <?= $Page->bbpersen->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_bbpersen" class="invoice_detail_bbpersen">
<span<?= $Page->bbpersen->viewAttributes() ?>>
<?= $Page->bbpersen->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <td <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_totaltagihan" class="invoice_detail_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
        <td <?= $Page->blackbonus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_blackbonus" class="invoice_detail_blackbonus">
<span<?= $Page->blackbonus->viewAttributes() ?>>
<?= $Page->blackbonus->getViewValue() ?></span>
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
