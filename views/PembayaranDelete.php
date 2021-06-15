<?php

namespace PHPMaker2021\distributor;

// Page object
$PembayaranDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpembayarandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpembayarandelete = currentForm = new ew.Form("fpembayarandelete", "delete");
    loadjs.done("fpembayarandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pembayaran) ew.vars.tables.pembayaran = <?= JsonEncode(GetClientVar("tables", "pembayaran")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpembayarandelete" id="fpembayarandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembayaran">
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
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_pembayaran_kode" class="pembayaran_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <th class="<?= $Page->tanggal->headerCellClass() ?>"><span id="elh_pembayaran_tanggal" class="pembayaran_tanggal"><?= $Page->tanggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_pembayaran_idcustomer" class="pembayaran_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { // idinvoice ?>
        <th class="<?= $Page->idinvoice->headerCellClass() ?>"><span id="elh_pembayaran_idinvoice" class="pembayaran_idinvoice"><?= $Page->idinvoice->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahbayar->Visible) { // jumlahbayar ?>
        <th class="<?= $Page->jumlahbayar->headerCellClass() ?>"><span id="elh_pembayaran_jumlahbayar" class="pembayaran_jumlahbayar"><?= $Page->jumlahbayar->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_pembayaran_kode" class="pembayaran_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <td <?= $Page->tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembayaran_tanggal" class="pembayaran_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembayaran_idcustomer" class="pembayaran_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { // idinvoice ?>
        <td <?= $Page->idinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembayaran_idinvoice" class="pembayaran_idinvoice">
<span<?= $Page->idinvoice->viewAttributes() ?>>
<?= $Page->idinvoice->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahbayar->Visible) { // jumlahbayar ?>
        <td <?= $Page->jumlahbayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembayaran_jumlahbayar" class="pembayaran_jumlahbayar">
<span<?= $Page->jumlahbayar->viewAttributes() ?>>
<?= $Page->jumlahbayar->getViewValue() ?></span>
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
