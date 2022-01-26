<?php

namespace PHPMaker2021\distributor;

// Page object
$VListCustomerBrandsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_list_customer_brandsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fv_list_customer_brandsdelete = currentForm = new ew.Form("fv_list_customer_brandsdelete", "delete");
    loadjs.done("fv_list_customer_brandsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.v_list_customer_brands) ew.vars.tables.v_list_customer_brands = <?= JsonEncode(GetClientVar("tables", "v_list_customer_brands")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fv_list_customer_brandsdelete" id="fv_list_customer_brandsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_list_customer_brands">
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
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_v_list_customer_brands_idcustomer" class="v_list_customer_brands_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><span id="elh_v_list_customer_brands_idbrand" class="v_list_customer_brands_idbrand"><?= $Page->idbrand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kode_brand->Visible) { // kode_brand ?>
        <th class="<?= $Page->kode_brand->headerCellClass() ?>"><span id="elh_v_list_customer_brands_kode_brand" class="v_list_customer_brands_kode_brand"><?= $Page->kode_brand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
        <th class="<?= $Page->nama_brand->headerCellClass() ?>"><span id="elh_v_list_customer_brands_nama_brand" class="v_list_customer_brands_nama_brand"><?= $Page->nama_brand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah_produk->Visible) { // jumlah_produk ?>
        <th class="<?= $Page->jumlah_produk->headerCellClass() ?>"><span id="elh_v_list_customer_brands_jumlah_produk" class="v_list_customer_brands_jumlah_produk"><?= $Page->jumlah_produk->caption() ?></span></th>
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
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_customer_brands_idcustomer" class="v_list_customer_brands_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <td <?= $Page->idbrand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_customer_brands_idbrand" class="v_list_customer_brands_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kode_brand->Visible) { // kode_brand ?>
        <td <?= $Page->kode_brand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_customer_brands_kode_brand" class="v_list_customer_brands_kode_brand">
<span<?= $Page->kode_brand->viewAttributes() ?>>
<?= $Page->kode_brand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
        <td <?= $Page->nama_brand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_customer_brands_nama_brand" class="v_list_customer_brands_nama_brand">
<span<?= $Page->nama_brand->viewAttributes() ?>>
<?= $Page->nama_brand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah_produk->Visible) { // jumlah_produk ?>
        <td <?= $Page->jumlah_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_list_customer_brands_jumlah_produk" class="v_list_customer_brands_jumlah_produk">
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
