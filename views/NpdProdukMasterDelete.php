<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdProdukMasterDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_produk_masterdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_produk_masterdelete = currentForm = new ew.Form("fnpd_produk_masterdelete", "delete");
    loadjs.done("fnpd_produk_masterdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_produk_master) ew.vars.tables.npd_produk_master = <?= JsonEncode(GetClientVar("tables", "npd_produk_master")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_produk_masterdelete" id="fnpd_produk_masterdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_produk_master">
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
<?php if ($Page->grup->Visible) { // grup ?>
        <th class="<?= $Page->grup->headerCellClass() ?>"><span id="elh_npd_produk_master_grup" class="npd_produk_master_grup"><?= $Page->grup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <th class="<?= $Page->kategori->headerCellClass() ?>"><span id="elh_npd_produk_master_kategori" class="npd_produk_master_kategori"><?= $Page->kategori->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <th class="<?= $Page->sediaan->headerCellClass() ?>"><span id="elh_npd_produk_master_sediaan" class="npd_produk_master_sediaan"><?= $Page->sediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
        <th class="<?= $Page->bentukan->headerCellClass() ?>"><span id="elh_npd_produk_master_bentukan" class="npd_produk_master_bentukan"><?= $Page->bentukan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
        <th class="<?= $Page->konsep->headerCellClass() ?>"><span id="elh_npd_produk_master_konsep" class="npd_produk_master_konsep"><?= $Page->konsep->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <th class="<?= $Page->bahanaktif->headerCellClass() ?>"><span id="elh_npd_produk_master_bahanaktif" class="npd_produk_master_bahanaktif"><?= $Page->bahanaktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <th class="<?= $Page->fragrance->headerCellClass() ?>"><span id="elh_npd_produk_master_fragrance" class="npd_produk_master_fragrance"><?= $Page->fragrance->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <th class="<?= $Page->aroma->headerCellClass() ?>"><span id="elh_npd_produk_master_aroma" class="npd_produk_master_aroma"><?= $Page->aroma->caption() ?></span></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th class="<?= $Page->warna->headerCellClass() ?>"><span id="elh_npd_produk_master_warna" class="npd_produk_master_warna"><?= $Page->warna->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <th class="<?= $Page->aplikasi_sediaan->headerCellClass() ?>"><span id="elh_npd_produk_master_aplikasi_sediaan" class="npd_produk_master_aplikasi_sediaan"><?= $Page->aplikasi_sediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <th class="<?= $Page->aksesoris->headerCellClass() ?>"><span id="elh_npd_produk_master_aksesoris" class="npd_produk_master_aksesoris"><?= $Page->aksesoris->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
        <th class="<?= $Page->nour->headerCellClass() ?>"><span id="elh_npd_produk_master_nour" class="npd_produk_master_nour"><?= $Page->nour->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_npd_produk_master_updated_at" class="npd_produk_master_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<?php if ($Page->grup->Visible) { // grup ?>
        <td <?= $Page->grup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_grup" class="npd_produk_master_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <td <?= $Page->kategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_kategori" class="npd_produk_master_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <td <?= $Page->sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_sediaan" class="npd_produk_master_sediaan">
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
        <td <?= $Page->bentukan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_bentukan" class="npd_produk_master_bentukan">
<span<?= $Page->bentukan->viewAttributes() ?>>
<?= $Page->bentukan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
        <td <?= $Page->konsep->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_konsep" class="npd_produk_master_konsep">
<span<?= $Page->konsep->viewAttributes() ?>>
<?= $Page->konsep->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <td <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_bahanaktif" class="npd_produk_master_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <td <?= $Page->fragrance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_fragrance" class="npd_produk_master_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <td <?= $Page->aroma->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_aroma" class="npd_produk_master_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <td <?= $Page->warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_warna" class="npd_produk_master_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <td <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_aplikasi_sediaan" class="npd_produk_master_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <td <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_aksesoris" class="npd_produk_master_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
        <td <?= $Page->nour->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_nour" class="npd_produk_master_nour">
<span<?= $Page->nour->viewAttributes() ?>>
<?= $Page->nour->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_produk_master_updated_at" class="npd_produk_master_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
