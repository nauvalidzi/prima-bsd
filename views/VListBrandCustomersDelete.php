<?php

namespace PHPMaker2021\distributor;

// Page object
$VListBrandCustomersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_list_brand_customersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fv_list_brand_customersdelete = currentForm = new ew.Form("fv_list_brand_customersdelete", "delete");
    loadjs.done("fv_list_brand_customersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.v_list_brand_customers) ew.vars.tables.v_list_brand_customers = <?= JsonEncode(GetClientVar("tables", "v_list_brand_customers")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fv_list_brand_customersdelete" id="fv_list_brand_customersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_list_brand_customers">
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
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><span id="elh_v_list_brand_customers_idbrand" class="v_list_brand_customers_idbrand"><?= $Page->idbrand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_v_list_brand_customers_idcustomer" class="v_list_brand_customers_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kode_customer->Visible) { // kode_customer ?>
        <th class="<?= $Page->kode_customer->headerCellClass() ?>"><span id="elh_v_list_brand_customers_kode_customer" class="v_list_brand_customers_kode_customer"><?= $Page->kode_customer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <th class="<?= $Page->nama_customer->headerCellClass() ?>"><span id="elh_v_list_brand_customers_nama_customer" class="v_list_brand_customers_nama_customer"><?= $Page->nama_customer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah_produk->Visible) { // jumlah_produk ?>
        <th class="<?= $Page->jumlah_produk->headerCellClass() ?>"><span id="elh_v_list_brand_customers_jumlah_produk" class="v_list_brand_customers_jumlah_produk"><?= $Page->jumlah_produk->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_v_list_brand_customers_idbrand" class="v_list_brand_customers_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_brand_customers_idcustomer" class="v_list_brand_customers_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kode_customer->Visible) { // kode_customer ?>
        <td <?= $Page->kode_customer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_brand_customers_kode_customer" class="v_list_brand_customers_kode_customer">
<span<?= $Page->kode_customer->viewAttributes() ?>>
<?= $Page->kode_customer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <td <?= $Page->nama_customer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_brand_customers_nama_customer" class="v_list_brand_customers_nama_customer">
<span<?= $Page->nama_customer->viewAttributes() ?>>
<?= $Page->nama_customer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah_produk->Visible) { // jumlah_produk ?>
        <td <?= $Page->jumlah_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_brand_customers_jumlah_produk" class="v_list_brand_customers_jumlah_produk">
<span<?= $Page->jumlah_produk->viewAttributes() ?>>
<?= $Page->jumlah_produk->getViewValue() ?></span>
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
