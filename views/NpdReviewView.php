<?php

namespace PHPMaker2021\distributor;

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
<?php if ($Page->tglreview->Visible) { // tglreview ?>
    <tr id="r_tglreview">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tglreview"><?= $Page->tglreview->caption() ?></span></td>
        <td data-name="tglreview" <?= $Page->tglreview->cellAttributes() ?>>
<span id="el_npd_review_tglreview">
<span<?= $Page->tglreview->viewAttributes() ?>>
<?= $Page->tglreview->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_npd_review_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
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
<?php if ($Page->bentukok->Visible) { // bentukok ?>
    <tr id="r_bentukok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bentukok"><?= $Page->bentukok->caption() ?></span></td>
        <td data-name="bentukok" <?= $Page->bentukok->cellAttributes() ?>>
<span id="el_npd_review_bentukok">
<span<?= $Page->bentukok->viewAttributes() ?>>
<?= $Page->bentukok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentukrevisi->Visible) { // bentukrevisi ?>
    <tr id="r_bentukrevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bentukrevisi"><?= $Page->bentukrevisi->caption() ?></span></td>
        <td data-name="bentukrevisi" <?= $Page->bentukrevisi->cellAttributes() ?>>
<span id="el_npd_review_bentukrevisi">
<span<?= $Page->bentukrevisi->viewAttributes() ?>>
<?= $Page->bentukrevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositasok->Visible) { // viskositasok ?>
    <tr id="r_viskositasok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_viskositasok"><?= $Page->viskositasok->caption() ?></span></td>
        <td data-name="viskositasok" <?= $Page->viskositasok->cellAttributes() ?>>
<span id="el_npd_review_viskositasok">
<span<?= $Page->viskositasok->viewAttributes() ?>>
<?= $Page->viskositasok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositasrevisi->Visible) { // viskositasrevisi ?>
    <tr id="r_viskositasrevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_viskositasrevisi"><?= $Page->viskositasrevisi->caption() ?></span></td>
        <td data-name="viskositasrevisi" <?= $Page->viskositasrevisi->cellAttributes() ?>>
<span id="el_npd_review_viskositasrevisi">
<span<?= $Page->viskositasrevisi->viewAttributes() ?>>
<?= $Page->viskositasrevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jeniswarnaok->Visible) { // jeniswarnaok ?>
    <tr id="r_jeniswarnaok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_jeniswarnaok"><?= $Page->jeniswarnaok->caption() ?></span></td>
        <td data-name="jeniswarnaok" <?= $Page->jeniswarnaok->cellAttributes() ?>>
<span id="el_npd_review_jeniswarnaok">
<span<?= $Page->jeniswarnaok->viewAttributes() ?>>
<?= $Page->jeniswarnaok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jeniswarnarevisi->Visible) { // jeniswarnarevisi ?>
    <tr id="r_jeniswarnarevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_jeniswarnarevisi"><?= $Page->jeniswarnarevisi->caption() ?></span></td>
        <td data-name="jeniswarnarevisi" <?= $Page->jeniswarnarevisi->cellAttributes() ?>>
<span id="el_npd_review_jeniswarnarevisi">
<span<?= $Page->jeniswarnarevisi->viewAttributes() ?>>
<?= $Page->jeniswarnarevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tonewarnaok->Visible) { // tonewarnaok ?>
    <tr id="r_tonewarnaok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tonewarnaok"><?= $Page->tonewarnaok->caption() ?></span></td>
        <td data-name="tonewarnaok" <?= $Page->tonewarnaok->cellAttributes() ?>>
<span id="el_npd_review_tonewarnaok">
<span<?= $Page->tonewarnaok->viewAttributes() ?>>
<?= $Page->tonewarnaok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tonewarnarevisi->Visible) { // tonewarnarevisi ?>
    <tr id="r_tonewarnarevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_tonewarnarevisi"><?= $Page->tonewarnarevisi->caption() ?></span></td>
        <td data-name="tonewarnarevisi" <?= $Page->tonewarnarevisi->cellAttributes() ?>>
<span id="el_npd_review_tonewarnarevisi">
<span<?= $Page->tonewarnarevisi->viewAttributes() ?>>
<?= $Page->tonewarnarevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gradasiwarnaok->Visible) { // gradasiwarnaok ?>
    <tr id="r_gradasiwarnaok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_gradasiwarnaok"><?= $Page->gradasiwarnaok->caption() ?></span></td>
        <td data-name="gradasiwarnaok" <?= $Page->gradasiwarnaok->cellAttributes() ?>>
<span id="el_npd_review_gradasiwarnaok">
<span<?= $Page->gradasiwarnaok->viewAttributes() ?>>
<?= $Page->gradasiwarnaok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gradasiwarnarevisi->Visible) { // gradasiwarnarevisi ?>
    <tr id="r_gradasiwarnarevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_gradasiwarnarevisi"><?= $Page->gradasiwarnarevisi->caption() ?></span></td>
        <td data-name="gradasiwarnarevisi" <?= $Page->gradasiwarnarevisi->cellAttributes() ?>>
<span id="el_npd_review_gradasiwarnarevisi">
<span<?= $Page->gradasiwarnarevisi->viewAttributes() ?>>
<?= $Page->gradasiwarnarevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bauok->Visible) { // bauok ?>
    <tr id="r_bauok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_bauok"><?= $Page->bauok->caption() ?></span></td>
        <td data-name="bauok" <?= $Page->bauok->cellAttributes() ?>>
<span id="el_npd_review_bauok">
<span<?= $Page->bauok->viewAttributes() ?>>
<?= $Page->bauok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->baurevisi->Visible) { // baurevisi ?>
    <tr id="r_baurevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_baurevisi"><?= $Page->baurevisi->caption() ?></span></td>
        <td data-name="baurevisi" <?= $Page->baurevisi->cellAttributes() ?>>
<span id="el_npd_review_baurevisi">
<span<?= $Page->baurevisi->viewAttributes() ?>>
<?= $Page->baurevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetikaok->Visible) { // estetikaok ?>
    <tr id="r_estetikaok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_estetikaok"><?= $Page->estetikaok->caption() ?></span></td>
        <td data-name="estetikaok" <?= $Page->estetikaok->cellAttributes() ?>>
<span id="el_npd_review_estetikaok">
<span<?= $Page->estetikaok->viewAttributes() ?>>
<?= $Page->estetikaok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetikarevisi->Visible) { // estetikarevisi ?>
    <tr id="r_estetikarevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_estetikarevisi"><?= $Page->estetikarevisi->caption() ?></span></td>
        <td data-name="estetikarevisi" <?= $Page->estetikarevisi->cellAttributes() ?>>
<span id="el_npd_review_estetikarevisi">
<span<?= $Page->estetikarevisi->viewAttributes() ?>>
<?= $Page->estetikarevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiawalok->Visible) { // aplikasiawalok ?>
    <tr id="r_aplikasiawalok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasiawalok"><?= $Page->aplikasiawalok->caption() ?></span></td>
        <td data-name="aplikasiawalok" <?= $Page->aplikasiawalok->cellAttributes() ?>>
<span id="el_npd_review_aplikasiawalok">
<span<?= $Page->aplikasiawalok->viewAttributes() ?>>
<?= $Page->aplikasiawalok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasiawalrevisi->Visible) { // aplikasiawalrevisi ?>
    <tr id="r_aplikasiawalrevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasiawalrevisi"><?= $Page->aplikasiawalrevisi->caption() ?></span></td>
        <td data-name="aplikasiawalrevisi" <?= $Page->aplikasiawalrevisi->cellAttributes() ?>>
<span id="el_npd_review_aplikasiawalrevisi">
<span<?= $Page->aplikasiawalrevisi->viewAttributes() ?>>
<?= $Page->aplikasiawalrevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasilamaok->Visible) { // aplikasilamaok ?>
    <tr id="r_aplikasilamaok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasilamaok"><?= $Page->aplikasilamaok->caption() ?></span></td>
        <td data-name="aplikasilamaok" <?= $Page->aplikasilamaok->cellAttributes() ?>>
<span id="el_npd_review_aplikasilamaok">
<span<?= $Page->aplikasilamaok->viewAttributes() ?>>
<?= $Page->aplikasilamaok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasilamarevisi->Visible) { // aplikasilamarevisi ?>
    <tr id="r_aplikasilamarevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_aplikasilamarevisi"><?= $Page->aplikasilamarevisi->caption() ?></span></td>
        <td data-name="aplikasilamarevisi" <?= $Page->aplikasilamarevisi->cellAttributes() ?>>
<span id="el_npd_review_aplikasilamarevisi">
<span<?= $Page->aplikasilamarevisi->viewAttributes() ?>>
<?= $Page->aplikasilamarevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efekpositifok->Visible) { // efekpositifok ?>
    <tr id="r_efekpositifok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efekpositifok"><?= $Page->efekpositifok->caption() ?></span></td>
        <td data-name="efekpositifok" <?= $Page->efekpositifok->cellAttributes() ?>>
<span id="el_npd_review_efekpositifok">
<span<?= $Page->efekpositifok->viewAttributes() ?>>
<?= $Page->efekpositifok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efekpositifrevisi->Visible) { // efekpositifrevisi ?>
    <tr id="r_efekpositifrevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efekpositifrevisi"><?= $Page->efekpositifrevisi->caption() ?></span></td>
        <td data-name="efekpositifrevisi" <?= $Page->efekpositifrevisi->cellAttributes() ?>>
<span id="el_npd_review_efekpositifrevisi">
<span<?= $Page->efekpositifrevisi->viewAttributes() ?>>
<?= $Page->efekpositifrevisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeknegatifok->Visible) { // efeknegatifok ?>
    <tr id="r_efeknegatifok">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efeknegatifok"><?= $Page->efeknegatifok->caption() ?></span></td>
        <td data-name="efeknegatifok" <?= $Page->efeknegatifok->cellAttributes() ?>>
<span id="el_npd_review_efeknegatifok">
<span<?= $Page->efeknegatifok->viewAttributes() ?>>
<?= $Page->efeknegatifok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->efeknegatifrevisi->Visible) { // efeknegatifrevisi ?>
    <tr id="r_efeknegatifrevisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_review_efeknegatifrevisi"><?= $Page->efeknegatifrevisi->caption() ?></span></td>
        <td data-name="efeknegatifrevisi" <?= $Page->efeknegatifrevisi->cellAttributes() ?>>
<span id="el_npd_review_efeknegatifrevisi">
<span<?= $Page->efeknegatifrevisi->viewAttributes() ?>>
<?= $Page->efeknegatifrevisi->getViewValue() ?></span>
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
