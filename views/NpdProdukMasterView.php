<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdProdukMasterView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_produk_masterview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_produk_masterview = currentForm = new ew.Form("fnpd_produk_masterview", "view");
    loadjs.done("fnpd_produk_masterview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_produk_master) ew.vars.tables.npd_produk_master = <?= JsonEncode(GetClientVar("tables", "npd_produk_master")) ?>;
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
<form name="fnpd_produk_masterview" id="fnpd_produk_masterview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_produk_master">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->grup->Visible) { // grup ?>
    <tr id="r_grup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_grup"><?= $Page->grup->caption() ?></span></td>
        <td data-name="grup" <?= $Page->grup->cellAttributes() ?>>
<span id="el_npd_produk_master_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
    <tr id="r_kategori">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_kategori"><?= $Page->kategori->caption() ?></span></td>
        <td data-name="kategori" <?= $Page->kategori->cellAttributes() ?>>
<span id="el_npd_produk_master_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
    <tr id="r_sediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_sediaan"><?= $Page->sediaan->caption() ?></span></td>
        <td data-name="sediaan" <?= $Page->sediaan->cellAttributes() ?>>
<span id="el_npd_produk_master_sediaan">
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
    <tr id="r_bentukan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_bentukan"><?= $Page->bentukan->caption() ?></span></td>
        <td data-name="bentukan" <?= $Page->bentukan->cellAttributes() ?>>
<span id="el_npd_produk_master_bentukan">
<span<?= $Page->bentukan->viewAttributes() ?>>
<?= $Page->bentukan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
    <tr id="r_konsep">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_konsep"><?= $Page->konsep->caption() ?></span></td>
        <td data-name="konsep" <?= $Page->konsep->cellAttributes() ?>>
<span id="el_npd_produk_master_konsep">
<span<?= $Page->konsep->viewAttributes() ?>>
<?= $Page->konsep->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <tr id="r_bahanaktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_bahanaktif"><?= $Page->bahanaktif->caption() ?></span></td>
        <td data-name="bahanaktif" <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el_npd_produk_master_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
    <tr id="r_fragrance">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_fragrance"><?= $Page->fragrance->caption() ?></span></td>
        <td data-name="fragrance" <?= $Page->fragrance->cellAttributes() ?>>
<span id="el_npd_produk_master_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
    <tr id="r_aroma">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_aroma"><?= $Page->aroma->caption() ?></span></td>
        <td data-name="aroma" <?= $Page->aroma->cellAttributes() ?>>
<span id="el_npd_produk_master_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_warna"><?= $Page->warna->caption() ?></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_produk_master_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
    <tr id="r_aplikasi_sediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_aplikasi_sediaan"><?= $Page->aplikasi_sediaan->caption() ?></span></td>
        <td data-name="aplikasi_sediaan" <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el_npd_produk_master_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
    <tr id="r_aksesoris">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_aksesoris"><?= $Page->aksesoris->caption() ?></span></td>
        <td data-name="aksesoris" <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el_npd_produk_master_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
    <tr id="r_nour">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_nour"><?= $Page->nour->caption() ?></span></td>
        <td data-name="nour" <?= $Page->nour->cellAttributes() ?>>
<span id="el_npd_produk_master_nour">
<span<?= $Page->nour->viewAttributes() ?>>
<?= $Page->nour->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_produk_master_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_produk_master_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
