<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdMasterSpesifikasiView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_master_spesifikasiview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_master_spesifikasiview = currentForm = new ew.Form("fnpd_master_spesifikasiview", "view");
    loadjs.done("fnpd_master_spesifikasiview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_master_spesifikasi) ew.vars.tables.npd_master_spesifikasi = <?= JsonEncode(GetClientVar("tables", "npd_master_spesifikasi")) ?>;
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
<form name="fnpd_master_spesifikasiview" id="fnpd_master_spesifikasiview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_master_spesifikasi">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
    <tr id="r_grup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_grup"><?= $Page->grup->caption() ?></span></td>
        <td data-name="grup" <?= $Page->grup->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
    <tr id="r_kategori">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_kategori"><?= $Page->kategori->caption() ?></span></td>
        <td data-name="kategori" <?= $Page->kategori->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
    <tr id="r_sediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_sediaan"><?= $Page->sediaan->caption() ?></span></td>
        <td data-name="sediaan" <?= $Page->sediaan->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_sediaan">
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
    <tr id="r_bentukan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_bentukan"><?= $Page->bentukan->caption() ?></span></td>
        <td data-name="bentukan" <?= $Page->bentukan->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_bentukan">
<span<?= $Page->bentukan->viewAttributes() ?>>
<?= $Page->bentukan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
    <tr id="r_konsep">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_konsep"><?= $Page->konsep->caption() ?></span></td>
        <td data-name="konsep" <?= $Page->konsep->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_konsep">
<span<?= $Page->konsep->viewAttributes() ?>>
<?= $Page->konsep->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <tr id="r_bahanaktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_bahanaktif"><?= $Page->bahanaktif->caption() ?></span></td>
        <td data-name="bahanaktif" <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
    <tr id="r_fragrance">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_fragrance"><?= $Page->fragrance->caption() ?></span></td>
        <td data-name="fragrance" <?= $Page->fragrance->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
    <tr id="r_aroma">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_aroma"><?= $Page->aroma->caption() ?></span></td>
        <td data-name="aroma" <?= $Page->aroma->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_warna"><?= $Page->warna->caption() ?></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
    <tr id="r_aplikasi_sediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_aplikasi_sediaan"><?= $Page->aplikasi_sediaan->caption() ?></span></td>
        <td data-name="aplikasi_sediaan" <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
    <tr id="r_aksesoris">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_aksesoris"><?= $Page->aksesoris->caption() ?></span></td>
        <td data-name="aksesoris" <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
    <tr id="r_nour">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_nour"><?= $Page->nour->caption() ?></span></td>
        <td data-name="nour" <?= $Page->nour->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_nour">
<span<?= $Page->nour->viewAttributes() ?>>
<?= $Page->nour->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
    <tr id="r_updated_user">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_master_spesifikasi_updated_user"><?= $Page->updated_user->caption() ?></span></td>
        <td data-name="updated_user" <?= $Page->updated_user->cellAttributes() ?>>
<span id="el_npd_master_spesifikasi_updated_user">
<span<?= $Page->updated_user->viewAttributes() ?>>
<?= $Page->updated_user->getViewValue() ?></span>
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
