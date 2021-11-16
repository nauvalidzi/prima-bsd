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
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <tr id="r_idproduct_acuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?></span></td>
        <td data-name="idproduct_acuan" <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el_npd_idproduct_acuan">
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idjenisbarang->Visible) { // idjenisbarang ?>
    <tr id="r_idjenisbarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idjenisbarang"><?= $Page->idjenisbarang->caption() ?></span></td>
        <td data-name="idjenisbarang" <?= $Page->idjenisbarang->cellAttributes() ?>>
<span id="el_npd_idjenisbarang">
<span<?= $Page->idjenisbarang->viewAttributes() ?>>
<?= $Page->idjenisbarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
    <tr id="r_idkategoribarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_idkategoribarang"><?= $Page->idkategoribarang->caption() ?></span></td>
        <td data-name="idkategoribarang" <?= $Page->idkategoribarang->cellAttributes() ?>>
<span id="el_npd_idkategoribarang">
<span<?= $Page->idkategoribarang->viewAttributes() ?>>
<?= $Page->idkategoribarang->getViewValue() ?></span>
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
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
    <tr id="r_kemasanbarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kemasanbarang"><?= $Page->kemasanbarang->caption() ?></span></td>
        <td data-name="kemasanbarang" <?= $Page->kemasanbarang->cellAttributes() ?>>
<span id="el_npd_kemasanbarang">
<span<?= $Page->kemasanbarang->viewAttributes() ?>>
<?= $Page->kemasanbarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label->Visible) { // label ?>
    <tr id="r_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_label"><?= $Page->label->caption() ?></span></td>
        <td data-name="label" <?= $Page->label->cellAttributes() ?>>
<span id="el_npd_label">
<span<?= $Page->label->viewAttributes() ?>>
<?= $Page->label->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
    <tr id="r_orderperdana">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_orderperdana"><?= $Page->orderperdana->caption() ?></span></td>
        <td data-name="orderperdana" <?= $Page->orderperdana->cellAttributes() ?>>
<span id="el_npd_orderperdana">
<span<?= $Page->orderperdana->viewAttributes() ?>>
<?= $Page->orderperdana->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderreguler->Visible) { // orderreguler ?>
    <tr id="r_orderreguler">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_orderreguler"><?= $Page->orderreguler->caption() ?></span></td>
        <td data-name="orderreguler" <?= $Page->orderreguler->cellAttributes() ?>>
<span id="el_npd_orderreguler">
<span<?= $Page->orderreguler->viewAttributes() ?>>
<?= $Page->orderreguler->getViewValue() ?></span>
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
<?php if ($Page->kategori->Visible) { // kategori ?>
    <tr id="r_kategori">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kategori"><?= $Page->kategori->caption() ?></span></td>
        <td data-name="kategori" <?= $Page->kategori->cellAttributes() ?>>
<span id="el_npd_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fungsi_produk->Visible) { // fungsi_produk ?>
    <tr id="r_fungsi_produk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_fungsi_produk"><?= $Page->fungsi_produk->caption() ?></span></td>
        <td data-name="fungsi_produk" <?= $Page->fungsi_produk->cellAttributes() ?>>
<span id="el_npd_fungsi_produk">
<span<?= $Page->fungsi_produk->viewAttributes() ?>>
<?= $Page->fungsi_produk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kualitasbarang->Visible) { // kualitasbarang ?>
    <tr id="r_kualitasbarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_kualitasbarang"><?= $Page->kualitasbarang->caption() ?></span></td>
        <td data-name="kualitasbarang" <?= $Page->kualitasbarang->cellAttributes() ?>>
<span id="el_npd_kualitasbarang">
<span<?= $Page->kualitasbarang->viewAttributes() ?>>
<?= $Page->kualitasbarang->getViewValue() ?></span>
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
