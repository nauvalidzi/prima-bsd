<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpdview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpdview = currentForm = new ew.Form("fnpdview", "view");
    loadjs.done("fnpdview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd) ew.vars.tables.npd = <?= JsonEncode(GetClientVar("tables", "npd")) ?>;
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
<form name="fnpdview" id="fnpdview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_npd_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_npd_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <tr id="r_idbrand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idbrand"><?= $Page->idbrand->caption() ?></span></td>
        <td data-name="idbrand" <?= $Page->idbrand->cellAttributes() ?>>
<span id="el_npd_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
    <tr id="r_tanggal_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_tanggal_order"><?= $Page->tanggal_order->caption() ?></span></td>
        <td data-name="tanggal_order" <?= $Page->tanggal_order->cellAttributes() ?>>
<span id="el_npd_tanggal_order">
<span<?= $Page->tanggal_order->viewAttributes() ?>>
<?= $Page->tanggal_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
    <tr id="r_target_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_target_selesai"><?= $Page->target_selesai->caption() ?></span></td>
        <td data-name="target_selesai" <?= $Page->target_selesai->cellAttributes() ?>>
<span id="el_npd_target_selesai">
<span<?= $Page->target_selesai->viewAttributes() ?>>
<?= $Page->target_selesai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
    <tr id="r_sifatorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_sifatorder"><?= $Page->sifatorder->caption() ?></span></td>
        <td data-name="sifatorder" <?= $Page->sifatorder->cellAttributes() ?>>
<span id="el_npd_sifatorder">
<span<?= $Page->sifatorder->viewAttributes() ?>>
<?= $Page->sifatorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
    <tr id="r_kodeorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kodeorder"><?= $Page->kodeorder->caption() ?></span></td>
        <td data-name="kodeorder" <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el_npd_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nomororder->Visible) { // nomororder ?>
    <tr id="r_nomororder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_nomororder"><?= $Page->nomororder->caption() ?></span></td>
        <td data-name="nomororder" <?= $Page->nomororder->cellAttributes() ?>>
<span id="el_npd_nomororder">
<span<?= $Page->nomororder->viewAttributes() ?>>
<?= $Page->nomororder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
    <tr id="r_kategoriproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kategoriproduk"><?= $Page->kategoriproduk->caption() ?></span></td>
        <td data-name="kategoriproduk" <?= $Page->kategoriproduk->cellAttributes() ?>>
<span id="el_npd_kategoriproduk">
<span<?= $Page->kategoriproduk->viewAttributes() ?>>
<?= $Page->kategoriproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
    <tr id="r_jenisproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_jenisproduk"><?= $Page->jenisproduk->caption() ?></span></td>
        <td data-name="jenisproduk" <?= $Page->jenisproduk->cellAttributes() ?>>
<span id="el_npd_jenisproduk">
<span<?= $Page->jenisproduk->viewAttributes() ?>>
<?= $Page->jenisproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fungsiproduk->Visible) { // fungsiproduk ?>
    <tr id="r_fungsiproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_fungsiproduk"><?= $Page->fungsiproduk->caption() ?></span></td>
        <td data-name="fungsiproduk" <?= $Page->fungsiproduk->cellAttributes() ?>>
<span id="el_npd_fungsiproduk">
<span<?= $Page->fungsiproduk->viewAttributes() ?>>
<?= $Page->fungsiproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kualitasproduk->Visible) { // kualitasproduk ?>
    <tr id="r_kualitasproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kualitasproduk"><?= $Page->kualitasproduk->caption() ?></span></td>
        <td data-name="kualitasproduk" <?= $Page->kualitasproduk->cellAttributes() ?>>
<span id="el_npd_kualitasproduk">
<span<?= $Page->kualitasproduk->viewAttributes() ?>>
<?= $Page->kualitasproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
    <tr id="r_bahan_campaign">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_bahan_campaign"><?= $Page->bahan_campaign->caption() ?></span></td>
        <td data-name="bahan_campaign" <?= $Page->bahan_campaign->cellAttributes() ?>>
<span id="el_npd_bahan_campaign">
<span<?= $Page->bahan_campaign->viewAttributes() ?>>
<?= $Page->bahan_campaign->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran_sediaan->Visible) { // ukuran_sediaan ?>
    <tr id="r_ukuran_sediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_ukuran_sediaan"><?= $Page->ukuran_sediaan->caption() ?></span></td>
        <td data-name="ukuran_sediaan" <?= $Page->ukuran_sediaan->cellAttributes() ?>>
<span id="el_npd_ukuran_sediaan">
<span<?= $Page->ukuran_sediaan->viewAttributes() ?>>
<?= $Page->ukuran_sediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <tr id="r_bentuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_bentuk"><?= $Page->bentuk->caption() ?></span></td>
        <td data-name="bentuk" <?= $Page->bentuk->cellAttributes() ?>>
<span id="el_npd_bentuk">
<span<?= $Page->bentuk->viewAttributes() ?>>
<?= $Page->bentuk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <tr id="r_viskositas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_viskositas"><?= $Page->viskositas->caption() ?></span></td>
        <td data-name="viskositas" <?= $Page->viskositas->cellAttributes() ?>>
<span id="el_npd_viskositas">
<span<?= $Page->viskositas->viewAttributes() ?>>
<?= $Page->viskositas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_warna"><?= $Page->warna->caption() ?></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <tr id="r_parfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_parfum"><?= $Page->parfum->caption() ?></span></td>
        <td data-name="parfum" <?= $Page->parfum->cellAttributes() ?>>
<span id="el_npd_parfum">
<span<?= $Page->parfum->viewAttributes() ?>>
<?= $Page->parfum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasi->Visible) { // aplikasi ?>
    <tr id="r_aplikasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_aplikasi"><?= $Page->aplikasi->caption() ?></span></td>
        <td data-name="aplikasi" <?= $Page->aplikasi->cellAttributes() ?>>
<span id="el_npd_aplikasi">
<span<?= $Page->aplikasi->viewAttributes() ?>>
<?= $Page->aplikasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <tr id="r_tambahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_tambahan"><?= $Page->tambahan->caption() ?></span></td>
        <td data-name="tambahan" <?= $Page->tambahan->cellAttributes() ?>>
<span id="el_npd_tambahan">
<span<?= $Page->tambahan->viewAttributes() ?>>
<?= $Page->tambahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukurankemasan->Visible) { // ukurankemasan ?>
    <tr id="r_ukurankemasan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_ukurankemasan"><?= $Page->ukurankemasan->caption() ?></span></td>
        <td data-name="ukurankemasan" <?= $Page->ukurankemasan->cellAttributes() ?>>
<span id="el_npd_ukurankemasan">
<span<?= $Page->ukurankemasan->viewAttributes() ?>>
<?= $Page->ukurankemasan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasanbentuk->Visible) { // kemasanbentuk ?>
    <tr id="r_kemasanbentuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasanbentuk"><?= $Page->kemasanbentuk->caption() ?></span></td>
        <td data-name="kemasanbentuk" <?= $Page->kemasanbentuk->cellAttributes() ?>>
<span id="el_npd_kemasanbentuk">
<span<?= $Page->kemasanbentuk->viewAttributes() ?>>
<?= $Page->kemasanbentuk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
    <tr id="r_kemasantutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasantutup"><?= $Page->kemasantutup->caption() ?></span></td>
        <td data-name="kemasantutup" <?= $Page->kemasantutup->cellAttributes() ?>>
<span id="el_npd_kemasantutup">
<span<?= $Page->kemasantutup->viewAttributes() ?>>
<?= $Page->kemasantutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasancatatan->Visible) { // kemasancatatan ?>
    <tr id="r_kemasancatatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasancatatan"><?= $Page->kemasancatatan->caption() ?></span></td>
        <td data-name="kemasancatatan" <?= $Page->kemasancatatan->cellAttributes() ?>>
<span id="el_npd_kemasancatatan">
<span<?= $Page->kemasancatatan->viewAttributes() ?>>
<?= $Page->kemasancatatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelbahan->Visible) { // labelbahan ?>
    <tr id="r_labelbahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelbahan"><?= $Page->labelbahan->caption() ?></span></td>
        <td data-name="labelbahan" <?= $Page->labelbahan->cellAttributes() ?>>
<span id="el_npd_labelbahan">
<span<?= $Page->labelbahan->viewAttributes() ?>>
<?= $Page->labelbahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
    <tr id="r_labelkualitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelkualitas"><?= $Page->labelkualitas->caption() ?></span></td>
        <td data-name="labelkualitas" <?= $Page->labelkualitas->cellAttributes() ?>>
<span id="el_npd_labelkualitas">
<span<?= $Page->labelkualitas->viewAttributes() ?>>
<?= $Page->labelkualitas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
    <tr id="r_labelposisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelposisi"><?= $Page->labelposisi->caption() ?></span></td>
        <td data-name="labelposisi" <?= $Page->labelposisi->cellAttributes() ?>>
<span id="el_npd_labelposisi">
<span<?= $Page->labelposisi->viewAttributes() ?>>
<?= $Page->labelposisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelcatatan->Visible) { // labelcatatan ?>
    <tr id="r_labelcatatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_labelcatatan"><?= $Page->labelcatatan->caption() ?></span></td>
        <td data-name="labelcatatan" <?= $Page->labelcatatan->cellAttributes() ?>>
<span id="el_npd_labelcatatan">
<span<?= $Page->labelcatatan->viewAttributes() ?>>
<?= $Page->labelcatatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <tr id="r_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_selesai"><?= $Page->selesai->caption() ?></span></td>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<span id="el_npd_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<?= $Page->selesai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estetika->Visible) { // estetika ?>
    <tr id="r_estetika">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_estetika"><?= $Page->estetika->caption() ?></span></td>
        <td data-name="estetika" <?= $Page->estetika->cellAttributes() ?>>
<span id="el_npd_estetika">
<span<?= $Page->estetika->viewAttributes() ?>>
<?= $Page->estetika->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_sample") ?>" href="#tab_npd_sample" data-toggle="tab"><?= $Language->tablePhrase("npd_sample", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_sample")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_review") ?>" href="#tab_npd_review" data-toggle="tab"><?= $Language->tablePhrase("npd_review", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_review")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_confirm", explode(",", $Page->getCurrentDetailTable())) && $npd_confirm->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirm") {
            $firstActiveDetailTable = "npd_confirm";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_confirm") ?>" href="#tab_npd_confirm" data-toggle="tab"><?= $Language->tablePhrase("npd_confirm", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_confirm")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_harga") ?>" href="#tab_npd_harga" data-toggle="tab"><?= $Language->tablePhrase("npd_harga", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_harga")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_desain", explode(",", $Page->getCurrentDetailTable())) && $npd_desain->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_desain") {
            $firstActiveDetailTable = "npd_desain";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_desain") ?>" href="#tab_npd_desain" data-toggle="tab"><?= $Language->tablePhrase("npd_desain", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_desain")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_terms", explode(",", $Page->getCurrentDetailTable())) && $npd_terms->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_terms") {
            $firstActiveDetailTable = "npd_terms";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_terms") ?>" href="#tab_npd_terms" data-toggle="tab"><?= $Language->tablePhrase("npd_terms", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("npd_terms")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_sample") ?>" id="tab_npd_sample"><!-- page* -->
<?php include_once "NpdSampleGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_review") ?>" id="tab_npd_review"><!-- page* -->
<?php include_once "NpdReviewGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_confirm", explode(",", $Page->getCurrentDetailTable())) && $npd_confirm->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirm") {
            $firstActiveDetailTable = "npd_confirm";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_confirm") ?>" id="tab_npd_confirm"><!-- page* -->
<?php include_once "NpdConfirmGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_harga") ?>" id="tab_npd_harga"><!-- page* -->
<?php include_once "NpdHargaGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_desain", explode(",", $Page->getCurrentDetailTable())) && $npd_desain->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_desain") {
            $firstActiveDetailTable = "npd_desain";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_desain") ?>" id="tab_npd_desain"><!-- page* -->
<?php include_once "NpdDesainGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_terms", explode(",", $Page->getCurrentDetailTable())) && $npd_terms->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_terms") {
            $firstActiveDetailTable = "npd_terms";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_terms") ?>" id="tab_npd_terms"><!-- page* -->
<?php include_once "NpdTermsGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
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
