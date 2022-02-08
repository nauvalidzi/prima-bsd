<?php

namespace PHPMaker2021\production2;

// Page object
$NpdReviewView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_reviewview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_reviewview = currentForm = new ew.Form("fnpd_reviewview", "view");
    loadjs.done("fnpd_reviewview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_review) ew.vars.tables.npd_review = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>;
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
<form name="fnpd_reviewview" id="fnpd_reviewview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_review">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_review_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <tr id="r_idnpd_sample">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></span></td>
        <td data-name="idnpd_sample" <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el_npd_review_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_review->Visible) { // tanggal_review ?>
    <tr id="r_tanggal_review">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tanggal_review"><?= $Page->tanggal_review->caption() ?></span></td>
        <td data-name="tanggal_review" <?= $Page->tanggal_review->cellAttributes() ?>>
<span id="el_npd_review_tanggal_review">
<span<?= $Page->tanggal_review->viewAttributes() ?>>
<?= $Page->tanggal_review->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
    <tr id="r_tanggal_submit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tanggal_submit"><?= $Page->tanggal_submit->caption() ?></span></td>
        <td data-name="tanggal_submit" <?= $Page->tanggal_submit->cellAttributes() ?>>
<span id="el_npd_review_tanggal_submit">
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <tr id="r_ukuran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_ukuran"><?= $Page->ukuran->caption() ?></span></td>
        <td data-name="ukuran" <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_npd_review_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->wadah->Visible) { // wadah ?>
    <tr id="r_wadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_wadah"><?= $Page->wadah->caption() ?></span></td>
        <td data-name="wadah" <?= $Page->wadah->cellAttributes() ?>>
<span id="el_npd_review_wadah">
<span<?= $Page->wadah->viewAttributes() ?>>
<?= $Page->wadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk_opsi->Visible) { // bentuk_opsi ?>
    <tr id="r_bentuk_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bentuk_opsi"><?= $Page->bentuk_opsi->caption() ?></span></td>
        <td data-name="bentuk_opsi" <?= $Page->bentuk_opsi->cellAttributes() ?>>
<span id="el_npd_review_bentuk_opsi">
<span<?= $Page->bentuk_opsi->viewAttributes() ?>>
<?= $Page->bentuk_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk_revisi->Visible) { // bentuk_revisi ?>
    <tr id="r_bentuk_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bentuk_revisi"><?= $Page->bentuk_revisi->caption() ?></span></td>
        <td data-name="bentuk_revisi" <?= $Page->bentuk_revisi->cellAttributes() ?>>
<span id="el_npd_review_bentuk_revisi">
<span<?= $Page->bentuk_revisi->viewAttributes() ?>>
<?= $Page->bentuk_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas_opsi->Visible) { // viskositas_opsi ?>
    <tr id="r_viskositas_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_viskositas_opsi"><?= $Page->viskositas_opsi->caption() ?></span></td>
        <td data-name="viskositas_opsi" <?= $Page->viskositas_opsi->cellAttributes() ?>>
<span id="el_npd_review_viskositas_opsi">
<span<?= $Page->viskositas_opsi->viewAttributes() ?>>
<?= $Page->viskositas_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas_revisi->Visible) { // viskositas_revisi ?>
    <tr id="r_viskositas_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_viskositas_revisi"><?= $Page->viskositas_revisi->caption() ?></span></td>
        <td data-name="viskositas_revisi" <?= $Page->viskositas_revisi->cellAttributes() ?>>
<span id="el_npd_review_viskositas_revisi">
<span<?= $Page->viskositas_revisi->viewAttributes() ?>>
<?= $Page->viskositas_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jeniswarna_opsi->Visible) { // jeniswarna_opsi ?>
    <tr id="r_jeniswarna_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_jeniswarna_opsi"><?= $Page->jeniswarna_opsi->caption() ?></span></td>
        <td data-name="jeniswarna_opsi" <?= $Page->jeniswarna_opsi->cellAttributes() ?>>
<span id="el_npd_review_jeniswarna_opsi">
<span<?= $Page->jeniswarna_opsi->viewAttributes() ?>>
<?= $Page->jeniswarna_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jeniswarna_revisi->Visible) { // jeniswarna_revisi ?>
    <tr id="r_jeniswarna_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_jeniswarna_revisi"><?= $Page->jeniswarna_revisi->caption() ?></span></td>
        <td data-name="jeniswarna_revisi" <?= $Page->jeniswarna_revisi->cellAttributes() ?>>
<span id="el_npd_review_jeniswarna_revisi">
<span<?= $Page->jeniswarna_revisi->viewAttributes() ?>>
<?= $Page->jeniswarna_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tonewarna_opsi->Visible) { // tonewarna_opsi ?>
    <tr id="r_tonewarna_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tonewarna_opsi"><?= $Page->tonewarna_opsi->caption() ?></span></td>
        <td data-name="tonewarna_opsi" <?= $Page->tonewarna_opsi->cellAttributes() ?>>
<span id="el_npd_review_tonewarna_opsi">
<span<?= $Page->tonewarna_opsi->viewAttributes() ?>>
<?= $Page->tonewarna_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tonewarna_revisi->Visible) { // tonewarna_revisi ?>
    <tr id="r_tonewarna_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tonewarna_revisi"><?= $Page->tonewarna_revisi->caption() ?></span></td>
        <td data-name="tonewarna_revisi" <?= $Page->tonewarna_revisi->cellAttributes() ?>>
<span id="el_npd_review_tonewarna_revisi">
<span<?= $Page->tonewarna_revisi->viewAttributes() ?>>
<?= $Page->tonewarna_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gradasiwarna_opsi->Visible) { // gradasiwarna_opsi ?>
    <tr id="r_gradasiwarna_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_gradasiwarna_opsi"><?= $Page->gradasiwarna_opsi->caption() ?></span></td>
        <td data-name="gradasiwarna_opsi" <?= $Page->gradasiwarna_opsi->cellAttributes() ?>>
<span id="el_npd_review_gradasiwarna_opsi">
<span<?= $Page->gradasiwarna_opsi->viewAttributes() ?>>
<?= $Page->gradasiwarna_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gradasiwarna_revisi->Visible) { // gradasiwarna_revisi ?>
    <tr id="r_gradasiwarna_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_gradasiwarna_revisi"><?= $Page->gradasiwarna_revisi->caption() ?></span></td>
        <td data-name="gradasiwarna_revisi" <?= $Page->gradasiwarna_revisi->cellAttributes() ?>>
<span id="el_npd_review_gradasiwarna_revisi">
<span<?= $Page->gradasiwarna_revisi->viewAttributes() ?>>
<?= $Page->gradasiwarna_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bauparfum_opsi->Visible) { // bauparfum_opsi ?>
    <tr id="r_bauparfum_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bauparfum_opsi"><?= $Page->bauparfum_opsi->caption() ?></span></td>
        <td data-name="bauparfum_opsi" <?= $Page->bauparfum_opsi->cellAttributes() ?>>
<span id="el_npd_review_bauparfum_opsi">
<span<?= $Page->bauparfum_opsi->viewAttributes() ?>>
<?= $Page->bauparfum_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bauparfum_revisi->Visible) { // bauparfum_revisi ?>
    <tr id="r_bauparfum_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bauparfum_revisi"><?= $Page->bauparfum_revisi->caption() ?></span></td>
        <td data-name="bauparfum_revisi" <?= $Page->bauparfum_revisi->cellAttributes() ?>>
<span id="el_npd_review_bauparfum_revisi">
<span<?= $Page->bauparfum_revisi->viewAttributes() ?>>
<?= $Page->bauparfum_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetika_opsi->Visible) { // estetika_opsi ?>
    <tr id="r_estetika_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_estetika_opsi"><?= $Page->estetika_opsi->caption() ?></span></td>
        <td data-name="estetika_opsi" <?= $Page->estetika_opsi->cellAttributes() ?>>
<span id="el_npd_review_estetika_opsi">
<span<?= $Page->estetika_opsi->viewAttributes() ?>>
<?= $Page->estetika_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetika_revisi->Visible) { // estetika_revisi ?>
    <tr id="r_estetika_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_estetika_revisi"><?= $Page->estetika_revisi->caption() ?></span></td>
        <td data-name="estetika_revisi" <?= $Page->estetika_revisi->cellAttributes() ?>>
<span id="el_npd_review_estetika_revisi">
<span<?= $Page->estetika_revisi->viewAttributes() ?>>
<?= $Page->estetika_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiawal_opsi->Visible) { // aplikasiawal_opsi ?>
    <tr id="r_aplikasiawal_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasiawal_opsi"><?= $Page->aplikasiawal_opsi->caption() ?></span></td>
        <td data-name="aplikasiawal_opsi" <?= $Page->aplikasiawal_opsi->cellAttributes() ?>>
<span id="el_npd_review_aplikasiawal_opsi">
<span<?= $Page->aplikasiawal_opsi->viewAttributes() ?>>
<?= $Page->aplikasiawal_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiawal_revisi->Visible) { // aplikasiawal_revisi ?>
    <tr id="r_aplikasiawal_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasiawal_revisi"><?= $Page->aplikasiawal_revisi->caption() ?></span></td>
        <td data-name="aplikasiawal_revisi" <?= $Page->aplikasiawal_revisi->cellAttributes() ?>>
<span id="el_npd_review_aplikasiawal_revisi">
<span<?= $Page->aplikasiawal_revisi->viewAttributes() ?>>
<?= $Page->aplikasiawal_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasilama_opsi->Visible) { // aplikasilama_opsi ?>
    <tr id="r_aplikasilama_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasilama_opsi"><?= $Page->aplikasilama_opsi->caption() ?></span></td>
        <td data-name="aplikasilama_opsi" <?= $Page->aplikasilama_opsi->cellAttributes() ?>>
<span id="el_npd_review_aplikasilama_opsi">
<span<?= $Page->aplikasilama_opsi->viewAttributes() ?>>
<?= $Page->aplikasilama_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasilama_revisi->Visible) { // aplikasilama_revisi ?>
    <tr id="r_aplikasilama_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasilama_revisi"><?= $Page->aplikasilama_revisi->caption() ?></span></td>
        <td data-name="aplikasilama_revisi" <?= $Page->aplikasilama_revisi->cellAttributes() ?>>
<span id="el_npd_review_aplikasilama_revisi">
<span<?= $Page->aplikasilama_revisi->viewAttributes() ?>>
<?= $Page->aplikasilama_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efekpositif_opsi->Visible) { // efekpositif_opsi ?>
    <tr id="r_efekpositif_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efekpositif_opsi"><?= $Page->efekpositif_opsi->caption() ?></span></td>
        <td data-name="efekpositif_opsi" <?= $Page->efekpositif_opsi->cellAttributes() ?>>
<span id="el_npd_review_efekpositif_opsi">
<span<?= $Page->efekpositif_opsi->viewAttributes() ?>>
<?= $Page->efekpositif_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efekpositif_revisi->Visible) { // efekpositif_revisi ?>
    <tr id="r_efekpositif_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efekpositif_revisi"><?= $Page->efekpositif_revisi->caption() ?></span></td>
        <td data-name="efekpositif_revisi" <?= $Page->efekpositif_revisi->cellAttributes() ?>>
<span id="el_npd_review_efekpositif_revisi">
<span<?= $Page->efekpositif_revisi->viewAttributes() ?>>
<?= $Page->efekpositif_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeknegatif_opsi->Visible) { // efeknegatif_opsi ?>
    <tr id="r_efeknegatif_opsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efeknegatif_opsi"><?= $Page->efeknegatif_opsi->caption() ?></span></td>
        <td data-name="efeknegatif_opsi" <?= $Page->efeknegatif_opsi->cellAttributes() ?>>
<span id="el_npd_review_efeknegatif_opsi">
<span<?= $Page->efeknegatif_opsi->viewAttributes() ?>>
<?= $Page->efeknegatif_opsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeknegatif_revisi->Visible) { // efeknegatif_revisi ?>
    <tr id="r_efeknegatif_revisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efeknegatif_revisi"><?= $Page->efeknegatif_revisi->caption() ?></span></td>
        <td data-name="efeknegatif_revisi" <?= $Page->efeknegatif_revisi->cellAttributes() ?>>
<span id="el_npd_review_efeknegatif_revisi">
<span<?= $Page->efeknegatif_revisi->viewAttributes() ?>>
<?= $Page->efeknegatif_revisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kesimpulan->Visible) { // kesimpulan ?>
    <tr id="r_kesimpulan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_kesimpulan"><?= $Page->kesimpulan->caption() ?></span></td>
        <td data-name="kesimpulan" <?= $Page->kesimpulan->cellAttributes() ?>>
<span id="el_npd_review_kesimpulan">
<span<?= $Page->kesimpulan->viewAttributes() ?>>
<?= $Page->kesimpulan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_review_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->review_by->Visible) { // review_by ?>
    <tr id="r_review_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_review_by"><?= $Page->review_by->caption() ?></span></td>
        <td data-name="review_by" <?= $Page->review_by->cellAttributes() ?>>
<span id="el_npd_review_review_by">
<span<?= $Page->review_by->viewAttributes() ?>>
<?= $Page->review_by->getViewValue() ?></span>
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
    // Startup script
    loadjs.ready("jquery",(function(){$("#r_kodesample").before('<h5 class="form-group">A. Data Sample</h5>'),$("#r_bentukok").before('<h5 class="form-group">B. Review Sediaan</h5>'),$("#r_aplikasiawalok").before('<h5 class="form-group">C. Review Kualitas</h5>'),$("#r_kesimpulan").before('<h5 class="form-group">D. Kesimpulan</h5>')}));
});
</script>
<?php } ?>
