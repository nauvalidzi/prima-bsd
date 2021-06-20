<?php

namespace PHPMaker2021\distributor;

// Page object
$OrderPengembanganView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forder_pengembanganview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    forder_pengembanganview = currentForm = new ew.Form("forder_pengembanganview", "view");
    loadjs.done("forder_pengembanganview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.order_pengembangan) ew.vars.tables.order_pengembangan = <?= JsonEncode(GetClientVar("tables", "order_pengembangan")) ?>;
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
<form name="forder_pengembanganview" id="forder_pengembanganview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_pengembangan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_order_pengembangan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cpo_jenis->Visible) { // cpo_jenis ?>
    <tr id="r_cpo_jenis">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_cpo_jenis"><?= $Page->cpo_jenis->caption() ?></span></td>
        <td data-name="cpo_jenis" <?= $Page->cpo_jenis->cellAttributes() ?>>
<span id="el_order_pengembangan_cpo_jenis">
<span<?= $Page->cpo_jenis->viewAttributes() ?>>
<?= $Page->cpo_jenis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ordernum->Visible) { // ordernum ?>
    <tr id="r_ordernum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_ordernum"><?= $Page->ordernum->caption() ?></span></td>
        <td data-name="ordernum" <?= $Page->ordernum->cellAttributes() ?>>
<span id="el_order_pengembangan_ordernum">
<span<?= $Page->ordernum->viewAttributes() ?>>
<?= $Page->ordernum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->order_kode->Visible) { // order_kode ?>
    <tr id="r_order_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_order_kode"><?= $Page->order_kode->caption() ?></span></td>
        <td data-name="order_kode" <?= $Page->order_kode->cellAttributes() ?>>
<span id="el_order_pengembangan_order_kode">
<span<?= $Page->order_kode->viewAttributes() ?>>
<?= $Page->order_kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderterimatgl->Visible) { // orderterimatgl ?>
    <tr id="r_orderterimatgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_orderterimatgl"><?= $Page->orderterimatgl->caption() ?></span></td>
        <td data-name="orderterimatgl" <?= $Page->orderterimatgl->cellAttributes() ?>>
<span id="el_order_pengembangan_orderterimatgl">
<span<?= $Page->orderterimatgl->viewAttributes() ?>>
<?= $Page->orderterimatgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk_fungsi->Visible) { // produk_fungsi ?>
    <tr id="r_produk_fungsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_produk_fungsi"><?= $Page->produk_fungsi->caption() ?></span></td>
        <td data-name="produk_fungsi" <?= $Page->produk_fungsi->cellAttributes() ?>>
<span id="el_order_pengembangan_produk_fungsi">
<span<?= $Page->produk_fungsi->viewAttributes() ?>>
<?= $Page->produk_fungsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk_kualitas->Visible) { // produk_kualitas ?>
    <tr id="r_produk_kualitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_produk_kualitas"><?= $Page->produk_kualitas->caption() ?></span></td>
        <td data-name="produk_kualitas" <?= $Page->produk_kualitas->cellAttributes() ?>>
<span id="el_order_pengembangan_produk_kualitas">
<span<?= $Page->produk_kualitas->viewAttributes() ?>>
<?= $Page->produk_kualitas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk_campaign->Visible) { // produk_campaign ?>
    <tr id="r_produk_campaign">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_produk_campaign"><?= $Page->produk_campaign->caption() ?></span></td>
        <td data-name="produk_campaign" <?= $Page->produk_campaign->cellAttributes() ?>>
<span id="el_order_pengembangan_produk_campaign">
<span<?= $Page->produk_campaign->viewAttributes() ?>>
<?= $Page->produk_campaign->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasan_satuan->Visible) { // kemasan_satuan ?>
    <tr id="r_kemasan_satuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_kemasan_satuan"><?= $Page->kemasan_satuan->caption() ?></span></td>
        <td data-name="kemasan_satuan" <?= $Page->kemasan_satuan->cellAttributes() ?>>
<span id="el_order_pengembangan_kemasan_satuan">
<span<?= $Page->kemasan_satuan->viewAttributes() ?>>
<?= $Page->kemasan_satuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ordertgl->Visible) { // ordertgl ?>
    <tr id="r_ordertgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_ordertgl"><?= $Page->ordertgl->caption() ?></span></td>
        <td data-name="ordertgl" <?= $Page->ordertgl->cellAttributes() ?>>
<span id="el_order_pengembangan_ordertgl">
<span<?= $Page->ordertgl->viewAttributes() ?>>
<?= $Page->ordertgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->custcode->Visible) { // custcode ?>
    <tr id="r_custcode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_custcode"><?= $Page->custcode->caption() ?></span></td>
        <td data-name="custcode" <?= $Page->custcode->cellAttributes() ?>>
<span id="el_order_pengembangan_custcode">
<span<?= $Page->custcode->viewAttributes() ?>>
<?= $Page->custcode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perushnama->Visible) { // perushnama ?>
    <tr id="r_perushnama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_perushnama"><?= $Page->perushnama->caption() ?></span></td>
        <td data-name="perushnama" <?= $Page->perushnama->cellAttributes() ?>>
<span id="el_order_pengembangan_perushnama">
<span<?= $Page->perushnama->viewAttributes() ?>>
<?= $Page->perushnama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perushalamat->Visible) { // perushalamat ?>
    <tr id="r_perushalamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_perushalamat"><?= $Page->perushalamat->caption() ?></span></td>
        <td data-name="perushalamat" <?= $Page->perushalamat->cellAttributes() ?>>
<span id="el_order_pengembangan_perushalamat">
<span<?= $Page->perushalamat->viewAttributes() ?>>
<?= $Page->perushalamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perushcp->Visible) { // perushcp ?>
    <tr id="r_perushcp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_perushcp"><?= $Page->perushcp->caption() ?></span></td>
        <td data-name="perushcp" <?= $Page->perushcp->cellAttributes() ?>>
<span id="el_order_pengembangan_perushcp">
<span<?= $Page->perushcp->viewAttributes() ?>>
<?= $Page->perushcp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perushjabatan->Visible) { // perushjabatan ?>
    <tr id="r_perushjabatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_perushjabatan"><?= $Page->perushjabatan->caption() ?></span></td>
        <td data-name="perushjabatan" <?= $Page->perushjabatan->cellAttributes() ?>>
<span id="el_order_pengembangan_perushjabatan">
<span<?= $Page->perushjabatan->viewAttributes() ?>>
<?= $Page->perushjabatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perushphone->Visible) { // perushphone ?>
    <tr id="r_perushphone">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_perushphone"><?= $Page->perushphone->caption() ?></span></td>
        <td data-name="perushphone" <?= $Page->perushphone->cellAttributes() ?>>
<span id="el_order_pengembangan_perushphone">
<span<?= $Page->perushphone->viewAttributes() ?>>
<?= $Page->perushphone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->perushmobile->Visible) { // perushmobile ?>
    <tr id="r_perushmobile">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_perushmobile"><?= $Page->perushmobile->caption() ?></span></td>
        <td data-name="perushmobile" <?= $Page->perushmobile->cellAttributes() ?>>
<span id="el_order_pengembangan_perushmobile">
<span<?= $Page->perushmobile->viewAttributes() ?>>
<?= $Page->perushmobile->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bencmark->Visible) { // bencmark ?>
    <tr id="r_bencmark">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bencmark"><?= $Page->bencmark->caption() ?></span></td>
        <td data-name="bencmark" <?= $Page->bencmark->cellAttributes() ?>>
<span id="el_order_pengembangan_bencmark">
<span<?= $Page->bencmark->viewAttributes() ?>>
<?= $Page->bencmark->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
    <tr id="r_kategoriproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_kategoriproduk"><?= $Page->kategoriproduk->caption() ?></span></td>
        <td data-name="kategoriproduk" <?= $Page->kategoriproduk->cellAttributes() ?>>
<span id="el_order_pengembangan_kategoriproduk">
<span<?= $Page->kategoriproduk->viewAttributes() ?>>
<?= $Page->kategoriproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
    <tr id="r_jenisproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_jenisproduk"><?= $Page->jenisproduk->caption() ?></span></td>
        <td data-name="jenisproduk" <?= $Page->jenisproduk->cellAttributes() ?>>
<span id="el_order_pengembangan_jenisproduk">
<span<?= $Page->jenisproduk->viewAttributes() ?>>
<?= $Page->jenisproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuksediaan->Visible) { // bentuksediaan ?>
    <tr id="r_bentuksediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bentuksediaan"><?= $Page->bentuksediaan->caption() ?></span></td>
        <td data-name="bentuksediaan" <?= $Page->bentuksediaan->cellAttributes() ?>>
<span id="el_order_pengembangan_bentuksediaan">
<span<?= $Page->bentuksediaan->viewAttributes() ?>>
<?= $Page->bentuksediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sediaan_ukuran->Visible) { // sediaan_ukuran ?>
    <tr id="r_sediaan_ukuran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_sediaan_ukuran"><?= $Page->sediaan_ukuran->caption() ?></span></td>
        <td data-name="sediaan_ukuran" <?= $Page->sediaan_ukuran->cellAttributes() ?>>
<span id="el_order_pengembangan_sediaan_ukuran">
<span<?= $Page->sediaan_ukuran->viewAttributes() ?>>
<?= $Page->sediaan_ukuran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sediaan_ukuran_satuan->Visible) { // sediaan_ukuran_satuan ?>
    <tr id="r_sediaan_ukuran_satuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_sediaan_ukuran_satuan"><?= $Page->sediaan_ukuran_satuan->caption() ?></span></td>
        <td data-name="sediaan_ukuran_satuan" <?= $Page->sediaan_ukuran_satuan->cellAttributes() ?>>
<span id="el_order_pengembangan_sediaan_ukuran_satuan">
<span<?= $Page->sediaan_ukuran_satuan->viewAttributes() ?>>
<?= $Page->sediaan_ukuran_satuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk_viskositas->Visible) { // produk_viskositas ?>
    <tr id="r_produk_viskositas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_produk_viskositas"><?= $Page->produk_viskositas->caption() ?></span></td>
        <td data-name="produk_viskositas" <?= $Page->produk_viskositas->cellAttributes() ?>>
<span id="el_order_pengembangan_produk_viskositas">
<span<?= $Page->produk_viskositas->viewAttributes() ?>>
<?= $Page->produk_viskositas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->konsepproduk->Visible) { // konsepproduk ?>
    <tr id="r_konsepproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_konsepproduk"><?= $Page->konsepproduk->caption() ?></span></td>
        <td data-name="konsepproduk" <?= $Page->konsepproduk->cellAttributes() ?>>
<span id="el_order_pengembangan_konsepproduk">
<span<?= $Page->konsepproduk->viewAttributes() ?>>
<?= $Page->konsepproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
    <tr id="r_fragrance">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_fragrance"><?= $Page->fragrance->caption() ?></span></td>
        <td data-name="fragrance" <?= $Page->fragrance->cellAttributes() ?>>
<span id="el_order_pengembangan_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
    <tr id="r_aroma">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_aroma"><?= $Page->aroma->caption() ?></span></td>
        <td data-name="aroma" <?= $Page->aroma->cellAttributes() ?>>
<span id="el_order_pengembangan_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <tr id="r_bahanaktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bahanaktif"><?= $Page->bahanaktif->caption() ?></span></td>
        <td data-name="bahanaktif" <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el_order_pengembangan_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_warna"><?= $Page->warna->caption() ?></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el_order_pengembangan_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk_warna_jenis->Visible) { // produk_warna_jenis ?>
    <tr id="r_produk_warna_jenis">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_produk_warna_jenis"><?= $Page->produk_warna_jenis->caption() ?></span></td>
        <td data-name="produk_warna_jenis" <?= $Page->produk_warna_jenis->cellAttributes() ?>>
<span id="el_order_pengembangan_produk_warna_jenis">
<span<?= $Page->produk_warna_jenis->viewAttributes() ?>>
<?= $Page->produk_warna_jenis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
    <tr id="r_aksesoris">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_aksesoris"><?= $Page->aksesoris->caption() ?></span></td>
        <td data-name="aksesoris" <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el_order_pengembangan_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk_lainlain->Visible) { // produk_lainlain ?>
    <tr id="r_produk_lainlain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_produk_lainlain"><?= $Page->produk_lainlain->caption() ?></span></td>
        <td data-name="produk_lainlain" <?= $Page->produk_lainlain->cellAttributes() ?>>
<span id="el_order_pengembangan_produk_lainlain">
<span<?= $Page->produk_lainlain->viewAttributes() ?>>
<?= $Page->produk_lainlain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->statusproduk->Visible) { // statusproduk ?>
    <tr id="r_statusproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_statusproduk"><?= $Page->statusproduk->caption() ?></span></td>
        <td data-name="statusproduk" <?= $Page->statusproduk->cellAttributes() ?>>
<span id="el_order_pengembangan_statusproduk">
<span<?= $Page->statusproduk->viewAttributes() ?>>
<?= $Page->statusproduk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <tr id="r_parfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_parfum"><?= $Page->parfum->caption() ?></span></td>
        <td data-name="parfum" <?= $Page->parfum->cellAttributes() ?>>
<span id="el_order_pengembangan_parfum">
<span<?= $Page->parfum->viewAttributes() ?>>
<?= $Page->parfum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <tr id="r_catatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_catatan"><?= $Page->catatan->caption() ?></span></td>
        <td data-name="catatan" <?= $Page->catatan->cellAttributes() ?>>
<span id="el_order_pengembangan_catatan">
<span<?= $Page->catatan->viewAttributes() ?>>
<?= $Page->catatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rencanakemasan->Visible) { // rencanakemasan ?>
    <tr id="r_rencanakemasan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_rencanakemasan"><?= $Page->rencanakemasan->caption() ?></span></td>
        <td data-name="rencanakemasan" <?= $Page->rencanakemasan->cellAttributes() ?>>
<span id="el_order_pengembangan_rencanakemasan">
<span<?= $Page->rencanakemasan->viewAttributes() ?>>
<?= $Page->rencanakemasan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_order_pengembangan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ekspetasiharga->Visible) { // ekspetasiharga ?>
    <tr id="r_ekspetasiharga">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_ekspetasiharga"><?= $Page->ekspetasiharga->caption() ?></span></td>
        <td data-name="ekspetasiharga" <?= $Page->ekspetasiharga->cellAttributes() ?>>
<span id="el_order_pengembangan_ekspetasiharga">
<span<?= $Page->ekspetasiharga->viewAttributes() ?>>
<?= $Page->ekspetasiharga->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasan->Visible) { // kemasan ?>
    <tr id="r_kemasan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_kemasan"><?= $Page->kemasan->caption() ?></span></td>
        <td data-name="kemasan" <?= $Page->kemasan->cellAttributes() ?>>
<span id="el_order_pengembangan_kemasan">
<span<?= $Page->kemasan->viewAttributes() ?>>
<?= $Page->kemasan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <tr id="r_volume">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_volume"><?= $Page->volume->caption() ?></span></td>
        <td data-name="volume" <?= $Page->volume->cellAttributes() ?>>
<span id="el_order_pengembangan_volume">
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
    <tr id="r_jenistutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_jenistutup"><?= $Page->jenistutup->caption() ?></span></td>
        <td data-name="jenistutup" <?= $Page->jenistutup->cellAttributes() ?>>
<span id="el_order_pengembangan_jenistutup">
<span<?= $Page->jenistutup->viewAttributes() ?>>
<?= $Page->jenistutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatanpackaging->Visible) { // catatanpackaging ?>
    <tr id="r_catatanpackaging">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_catatanpackaging"><?= $Page->catatanpackaging->caption() ?></span></td>
        <td data-name="catatanpackaging" <?= $Page->catatanpackaging->cellAttributes() ?>>
<span id="el_order_pengembangan_catatanpackaging">
<span<?= $Page->catatanpackaging->viewAttributes() ?>>
<?= $Page->catatanpackaging->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->infopackaging->Visible) { // infopackaging ?>
    <tr id="r_infopackaging">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_infopackaging"><?= $Page->infopackaging->caption() ?></span></td>
        <td data-name="infopackaging" <?= $Page->infopackaging->cellAttributes() ?>>
<span id="el_order_pengembangan_infopackaging">
<span<?= $Page->infopackaging->viewAttributes() ?>>
<?= $Page->infopackaging->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <tr id="r_ukuran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_ukuran"><?= $Page->ukuran->caption() ?></span></td>
        <td data-name="ukuran" <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_order_pengembangan_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desainprodukkemasan->Visible) { // desainprodukkemasan ?>
    <tr id="r_desainprodukkemasan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_desainprodukkemasan"><?= $Page->desainprodukkemasan->caption() ?></span></td>
        <td data-name="desainprodukkemasan" <?= $Page->desainprodukkemasan->cellAttributes() ?>>
<span id="el_order_pengembangan_desainprodukkemasan">
<span<?= $Page->desainprodukkemasan->viewAttributes() ?>>
<?= $Page->desainprodukkemasan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desaindiinginkan->Visible) { // desaindiinginkan ?>
    <tr id="r_desaindiinginkan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_desaindiinginkan"><?= $Page->desaindiinginkan->caption() ?></span></td>
        <td data-name="desaindiinginkan" <?= $Page->desaindiinginkan->cellAttributes() ?>>
<span id="el_order_pengembangan_desaindiinginkan">
<span<?= $Page->desaindiinginkan->viewAttributes() ?>>
<?= $Page->desaindiinginkan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mereknotifikasi->Visible) { // mereknotifikasi ?>
    <tr id="r_mereknotifikasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_mereknotifikasi"><?= $Page->mereknotifikasi->caption() ?></span></td>
        <td data-name="mereknotifikasi" <?= $Page->mereknotifikasi->cellAttributes() ?>>
<span id="el_order_pengembangan_mereknotifikasi">
<span<?= $Page->mereknotifikasi->viewAttributes() ?>>
<?= $Page->mereknotifikasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategoristatus->Visible) { // kategoristatus ?>
    <tr id="r_kategoristatus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_kategoristatus"><?= $Page->kategoristatus->caption() ?></span></td>
        <td data-name="kategoristatus" <?= $Page->kategoristatus->cellAttributes() ?>>
<span id="el_order_pengembangan_kategoristatus">
<span<?= $Page->kategoristatus->viewAttributes() ?>>
<?= $Page->kategoristatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasan_ukuran_satuan->Visible) { // kemasan_ukuran_satuan ?>
    <tr id="r_kemasan_ukuran_satuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_kemasan_ukuran_satuan"><?= $Page->kemasan_ukuran_satuan->caption() ?></span></td>
        <td data-name="kemasan_ukuran_satuan" <?= $Page->kemasan_ukuran_satuan->cellAttributes() ?>>
<span id="el_order_pengembangan_kemasan_ukuran_satuan">
<span<?= $Page->kemasan_ukuran_satuan->viewAttributes() ?>>
<?= $Page->kemasan_ukuran_satuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->notifikasicatatan->Visible) { // notifikasicatatan ?>
    <tr id="r_notifikasicatatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_notifikasicatatan"><?= $Page->notifikasicatatan->caption() ?></span></td>
        <td data-name="notifikasicatatan" <?= $Page->notifikasicatatan->cellAttributes() ?>>
<span id="el_order_pengembangan_notifikasicatatan">
<span<?= $Page->notifikasicatatan->viewAttributes() ?>>
<?= $Page->notifikasicatatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label_ukuran->Visible) { // label_ukuran ?>
    <tr id="r_label_ukuran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_label_ukuran"><?= $Page->label_ukuran->caption() ?></span></td>
        <td data-name="label_ukuran" <?= $Page->label_ukuran->cellAttributes() ?>>
<span id="el_order_pengembangan_label_ukuran">
<span<?= $Page->label_ukuran->viewAttributes() ?>>
<?= $Page->label_ukuran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->infolabel->Visible) { // infolabel ?>
    <tr id="r_infolabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_infolabel"><?= $Page->infolabel->caption() ?></span></td>
        <td data-name="infolabel" <?= $Page->infolabel->cellAttributes() ?>>
<span id="el_order_pengembangan_infolabel">
<span<?= $Page->infolabel->viewAttributes() ?>>
<?= $Page->infolabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
    <tr id="r_labelkualitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_labelkualitas"><?= $Page->labelkualitas->caption() ?></span></td>
        <td data-name="labelkualitas" <?= $Page->labelkualitas->cellAttributes() ?>>
<span id="el_order_pengembangan_labelkualitas">
<span<?= $Page->labelkualitas->viewAttributes() ?>>
<?= $Page->labelkualitas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
    <tr id="r_labelposisi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_labelposisi"><?= $Page->labelposisi->caption() ?></span></td>
        <td data-name="labelposisi" <?= $Page->labelposisi->cellAttributes() ?>>
<span id="el_order_pengembangan_labelposisi">
<span<?= $Page->labelposisi->viewAttributes() ?>>
<?= $Page->labelposisi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->labelcatatan->Visible) { // labelcatatan ?>
    <tr id="r_labelcatatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_labelcatatan"><?= $Page->labelcatatan->caption() ?></span></td>
        <td data-name="labelcatatan" <?= $Page->labelcatatan->cellAttributes() ?>>
<span id="el_order_pengembangan_labelcatatan">
<span<?= $Page->labelcatatan->viewAttributes() ?>>
<?= $Page->labelcatatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
    <tr id="r_dibuatdi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_dibuatdi"><?= $Page->dibuatdi->caption() ?></span></td>
        <td data-name="dibuatdi" <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el_order_pengembangan_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal" <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_order_pengembangan_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
    <tr id="r_penerima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_penerima"><?= $Page->penerima->caption() ?></span></td>
        <td data-name="penerima" <?= $Page->penerima->cellAttributes() ?>>
<span id="el_order_pengembangan_penerima">
<span<?= $Page->penerima->viewAttributes() ?>>
<?= $Page->penerima->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createat->Visible) { // createat ?>
    <tr id="r_createat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_createat"><?= $Page->createat->caption() ?></span></td>
        <td data-name="createat" <?= $Page->createat->cellAttributes() ?>>
<span id="el_order_pengembangan_createat">
<span<?= $Page->createat->viewAttributes() ?>>
<?= $Page->createat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createby->Visible) { // createby ?>
    <tr id="r_createby">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_createby"><?= $Page->createby->caption() ?></span></td>
        <td data-name="createby" <?= $Page->createby->cellAttributes() ?>>
<span id="el_order_pengembangan_createby">
<span<?= $Page->createby->viewAttributes() ?>>
<?= $Page->createby->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->statusdokumen->Visible) { // statusdokumen ?>
    <tr id="r_statusdokumen">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_statusdokumen"><?= $Page->statusdokumen->caption() ?></span></td>
        <td data-name="statusdokumen" <?= $Page->statusdokumen->cellAttributes() ?>>
<span id="el_order_pengembangan_statusdokumen">
<span<?= $Page->statusdokumen->viewAttributes() ?>>
<?= $Page->statusdokumen->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->update_at->Visible) { // update_at ?>
    <tr id="r_update_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_update_at"><?= $Page->update_at->caption() ?></span></td>
        <td data-name="update_at" <?= $Page->update_at->cellAttributes() ?>>
<span id="el_order_pengembangan_update_at">
<span<?= $Page->update_at->viewAttributes() ?>>
<?= $Page->update_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status_data->Visible) { // status_data ?>
    <tr id="r_status_data">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_status_data"><?= $Page->status_data->caption() ?></span></td>
        <td data-name="status_data" <?= $Page->status_data->cellAttributes() ?>>
<span id="el_order_pengembangan_status_data">
<span<?= $Page->status_data->viewAttributes() ?>>
<?= $Page->status_data->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->harga_rnd->Visible) { // harga_rnd ?>
    <tr id="r_harga_rnd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_harga_rnd"><?= $Page->harga_rnd->caption() ?></span></td>
        <td data-name="harga_rnd" <?= $Page->harga_rnd->cellAttributes() ?>>
<span id="el_order_pengembangan_harga_rnd">
<span<?= $Page->harga_rnd->viewAttributes() ?>>
<?= $Page->harga_rnd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
    <tr id="r_aplikasi_sediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_aplikasi_sediaan"><?= $Page->aplikasi_sediaan->caption() ?></span></td>
        <td data-name="aplikasi_sediaan" <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el_order_pengembangan_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_isi->Visible) { // hu_hrg_isi ?>
    <tr id="r_hu_hrg_isi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_isi"><?= $Page->hu_hrg_isi->caption() ?></span></td>
        <td data-name="hu_hrg_isi" <?= $Page->hu_hrg_isi->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_isi">
<span<?= $Page->hu_hrg_isi->viewAttributes() ?>>
<?= $Page->hu_hrg_isi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_isi_pro->Visible) { // hu_hrg_isi_pro ?>
    <tr id="r_hu_hrg_isi_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_isi_pro"><?= $Page->hu_hrg_isi_pro->caption() ?></span></td>
        <td data-name="hu_hrg_isi_pro" <?= $Page->hu_hrg_isi_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_isi_pro">
<span<?= $Page->hu_hrg_isi_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_isi_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer->Visible) { // hu_hrg_kms_primer ?>
    <tr id="r_hu_hrg_kms_primer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_kms_primer"><?= $Page->hu_hrg_kms_primer->caption() ?></span></td>
        <td data-name="hu_hrg_kms_primer" <?= $Page->hu_hrg_kms_primer->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_kms_primer">
<span<?= $Page->hu_hrg_kms_primer->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_primer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer_pro->Visible) { // hu_hrg_kms_primer_pro ?>
    <tr id="r_hu_hrg_kms_primer_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_kms_primer_pro"><?= $Page->hu_hrg_kms_primer_pro->caption() ?></span></td>
        <td data-name="hu_hrg_kms_primer_pro" <?= $Page->hu_hrg_kms_primer_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_kms_primer_pro">
<span<?= $Page->hu_hrg_kms_primer_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_primer_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder->Visible) { // hu_hrg_kms_sekunder ?>
    <tr id="r_hu_hrg_kms_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_kms_sekunder"><?= $Page->hu_hrg_kms_sekunder->caption() ?></span></td>
        <td data-name="hu_hrg_kms_sekunder" <?= $Page->hu_hrg_kms_sekunder->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_kms_sekunder">
<span<?= $Page->hu_hrg_kms_sekunder->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_sekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder_pro->Visible) { // hu_hrg_kms_sekunder_pro ?>
    <tr id="r_hu_hrg_kms_sekunder_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_kms_sekunder_pro"><?= $Page->hu_hrg_kms_sekunder_pro->caption() ?></span></td>
        <td data-name="hu_hrg_kms_sekunder_pro" <?= $Page->hu_hrg_kms_sekunder_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_kms_sekunder_pro">
<span<?= $Page->hu_hrg_kms_sekunder_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_sekunder_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_label->Visible) { // hu_hrg_label ?>
    <tr id="r_hu_hrg_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_label"><?= $Page->hu_hrg_label->caption() ?></span></td>
        <td data-name="hu_hrg_label" <?= $Page->hu_hrg_label->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_label">
<span<?= $Page->hu_hrg_label->viewAttributes() ?>>
<?= $Page->hu_hrg_label->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_label_pro->Visible) { // hu_hrg_label_pro ?>
    <tr id="r_hu_hrg_label_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_label_pro"><?= $Page->hu_hrg_label_pro->caption() ?></span></td>
        <td data-name="hu_hrg_label_pro" <?= $Page->hu_hrg_label_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_label_pro">
<span<?= $Page->hu_hrg_label_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_label_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_total->Visible) { // hu_hrg_total ?>
    <tr id="r_hu_hrg_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_total"><?= $Page->hu_hrg_total->caption() ?></span></td>
        <td data-name="hu_hrg_total" <?= $Page->hu_hrg_total->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_total">
<span<?= $Page->hu_hrg_total->viewAttributes() ?>>
<?= $Page->hu_hrg_total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hu_hrg_total_pro->Visible) { // hu_hrg_total_pro ?>
    <tr id="r_hu_hrg_total_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hu_hrg_total_pro"><?= $Page->hu_hrg_total_pro->caption() ?></span></td>
        <td data-name="hu_hrg_total_pro" <?= $Page->hu_hrg_total_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hu_hrg_total_pro">
<span<?= $Page->hu_hrg_total_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_total_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_isi->Visible) { // hl_hrg_isi ?>
    <tr id="r_hl_hrg_isi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_isi"><?= $Page->hl_hrg_isi->caption() ?></span></td>
        <td data-name="hl_hrg_isi" <?= $Page->hl_hrg_isi->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_isi">
<span<?= $Page->hl_hrg_isi->viewAttributes() ?>>
<?= $Page->hl_hrg_isi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_isi_pro->Visible) { // hl_hrg_isi_pro ?>
    <tr id="r_hl_hrg_isi_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_isi_pro"><?= $Page->hl_hrg_isi_pro->caption() ?></span></td>
        <td data-name="hl_hrg_isi_pro" <?= $Page->hl_hrg_isi_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_isi_pro">
<span<?= $Page->hl_hrg_isi_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_isi_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer->Visible) { // hl_hrg_kms_primer ?>
    <tr id="r_hl_hrg_kms_primer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_kms_primer"><?= $Page->hl_hrg_kms_primer->caption() ?></span></td>
        <td data-name="hl_hrg_kms_primer" <?= $Page->hl_hrg_kms_primer->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_kms_primer">
<span<?= $Page->hl_hrg_kms_primer->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_primer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer_pro->Visible) { // hl_hrg_kms_primer_pro ?>
    <tr id="r_hl_hrg_kms_primer_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_kms_primer_pro"><?= $Page->hl_hrg_kms_primer_pro->caption() ?></span></td>
        <td data-name="hl_hrg_kms_primer_pro" <?= $Page->hl_hrg_kms_primer_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_kms_primer_pro">
<span<?= $Page->hl_hrg_kms_primer_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_primer_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder->Visible) { // hl_hrg_kms_sekunder ?>
    <tr id="r_hl_hrg_kms_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_kms_sekunder"><?= $Page->hl_hrg_kms_sekunder->caption() ?></span></td>
        <td data-name="hl_hrg_kms_sekunder" <?= $Page->hl_hrg_kms_sekunder->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_kms_sekunder">
<span<?= $Page->hl_hrg_kms_sekunder->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_sekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder_pro->Visible) { // hl_hrg_kms_sekunder_pro ?>
    <tr id="r_hl_hrg_kms_sekunder_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_kms_sekunder_pro"><?= $Page->hl_hrg_kms_sekunder_pro->caption() ?></span></td>
        <td data-name="hl_hrg_kms_sekunder_pro" <?= $Page->hl_hrg_kms_sekunder_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_kms_sekunder_pro">
<span<?= $Page->hl_hrg_kms_sekunder_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_sekunder_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_label->Visible) { // hl_hrg_label ?>
    <tr id="r_hl_hrg_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_label"><?= $Page->hl_hrg_label->caption() ?></span></td>
        <td data-name="hl_hrg_label" <?= $Page->hl_hrg_label->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_label">
<span<?= $Page->hl_hrg_label->viewAttributes() ?>>
<?= $Page->hl_hrg_label->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_label_pro->Visible) { // hl_hrg_label_pro ?>
    <tr id="r_hl_hrg_label_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_label_pro"><?= $Page->hl_hrg_label_pro->caption() ?></span></td>
        <td data-name="hl_hrg_label_pro" <?= $Page->hl_hrg_label_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_label_pro">
<span<?= $Page->hl_hrg_label_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_label_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_total->Visible) { // hl_hrg_total ?>
    <tr id="r_hl_hrg_total">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_total"><?= $Page->hl_hrg_total->caption() ?></span></td>
        <td data-name="hl_hrg_total" <?= $Page->hl_hrg_total->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_total">
<span<?= $Page->hl_hrg_total->viewAttributes() ?>>
<?= $Page->hl_hrg_total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hl_hrg_total_pro->Visible) { // hl_hrg_total_pro ?>
    <tr id="r_hl_hrg_total_pro">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_hl_hrg_total_pro"><?= $Page->hl_hrg_total_pro->caption() ?></span></td>
        <td data-name="hl_hrg_total_pro" <?= $Page->hl_hrg_total_pro->cellAttributes() ?>>
<span id="el_order_pengembangan_hl_hrg_total_pro">
<span<?= $Page->hl_hrg_total_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_total_pro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_bahan_aktif_tick->Visible) { // bs_bahan_aktif_tick ?>
    <tr id="r_bs_bahan_aktif_tick">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_bahan_aktif_tick"><?= $Page->bs_bahan_aktif_tick->caption() ?></span></td>
        <td data-name="bs_bahan_aktif_tick" <?= $Page->bs_bahan_aktif_tick->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_bahan_aktif_tick">
<span<?= $Page->bs_bahan_aktif_tick->viewAttributes() ?>>
<?= $Page->bs_bahan_aktif_tick->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_bahan_aktif->Visible) { // bs_bahan_aktif ?>
    <tr id="r_bs_bahan_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_bahan_aktif"><?= $Page->bs_bahan_aktif->caption() ?></span></td>
        <td data-name="bs_bahan_aktif" <?= $Page->bs_bahan_aktif->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_bahan_aktif">
<span<?= $Page->bs_bahan_aktif->viewAttributes() ?>>
<?= $Page->bs_bahan_aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_bahan_lain->Visible) { // bs_bahan_lain ?>
    <tr id="r_bs_bahan_lain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_bahan_lain"><?= $Page->bs_bahan_lain->caption() ?></span></td>
        <td data-name="bs_bahan_lain" <?= $Page->bs_bahan_lain->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_bahan_lain">
<span<?= $Page->bs_bahan_lain->viewAttributes() ?>>
<?= $Page->bs_bahan_lain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_parfum->Visible) { // bs_parfum ?>
    <tr id="r_bs_parfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_parfum"><?= $Page->bs_parfum->caption() ?></span></td>
        <td data-name="bs_parfum" <?= $Page->bs_parfum->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_parfum">
<span<?= $Page->bs_parfum->viewAttributes() ?>>
<?= $Page->bs_parfum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_estetika->Visible) { // bs_estetika ?>
    <tr id="r_bs_estetika">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_estetika"><?= $Page->bs_estetika->caption() ?></span></td>
        <td data-name="bs_estetika" <?= $Page->bs_estetika->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_estetika">
<span<?= $Page->bs_estetika->viewAttributes() ?>>
<?= $Page->bs_estetika->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_kms_wadah->Visible) { // bs_kms_wadah ?>
    <tr id="r_bs_kms_wadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_kms_wadah"><?= $Page->bs_kms_wadah->caption() ?></span></td>
        <td data-name="bs_kms_wadah" <?= $Page->bs_kms_wadah->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_kms_wadah">
<span<?= $Page->bs_kms_wadah->viewAttributes() ?>>
<?= $Page->bs_kms_wadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_kms_tutup->Visible) { // bs_kms_tutup ?>
    <tr id="r_bs_kms_tutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_kms_tutup"><?= $Page->bs_kms_tutup->caption() ?></span></td>
        <td data-name="bs_kms_tutup" <?= $Page->bs_kms_tutup->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_kms_tutup">
<span<?= $Page->bs_kms_tutup->viewAttributes() ?>>
<?= $Page->bs_kms_tutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_kms_sekunder->Visible) { // bs_kms_sekunder ?>
    <tr id="r_bs_kms_sekunder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_kms_sekunder"><?= $Page->bs_kms_sekunder->caption() ?></span></td>
        <td data-name="bs_kms_sekunder" <?= $Page->bs_kms_sekunder->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_kms_sekunder">
<span<?= $Page->bs_kms_sekunder->viewAttributes() ?>>
<?= $Page->bs_kms_sekunder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_label_desain->Visible) { // bs_label_desain ?>
    <tr id="r_bs_label_desain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_label_desain"><?= $Page->bs_label_desain->caption() ?></span></td>
        <td data-name="bs_label_desain" <?= $Page->bs_label_desain->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_label_desain">
<span<?= $Page->bs_label_desain->viewAttributes() ?>>
<?= $Page->bs_label_desain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_label_cetak->Visible) { // bs_label_cetak ?>
    <tr id="r_bs_label_cetak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_label_cetak"><?= $Page->bs_label_cetak->caption() ?></span></td>
        <td data-name="bs_label_cetak" <?= $Page->bs_label_cetak->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_label_cetak">
<span<?= $Page->bs_label_cetak->viewAttributes() ?>>
<?= $Page->bs_label_cetak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bs_label_lain->Visible) { // bs_label_lain ?>
    <tr id="r_bs_label_lain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_bs_label_lain"><?= $Page->bs_label_lain->caption() ?></span></td>
        <td data-name="bs_label_lain" <?= $Page->bs_label_lain->cellAttributes() ?>>
<span id="el_order_pengembangan_bs_label_lain">
<span<?= $Page->bs_label_lain->viewAttributes() ?>>
<?= $Page->bs_label_lain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dlv_pickup->Visible) { // dlv_pickup ?>
    <tr id="r_dlv_pickup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_dlv_pickup"><?= $Page->dlv_pickup->caption() ?></span></td>
        <td data-name="dlv_pickup" <?= $Page->dlv_pickup->cellAttributes() ?>>
<span id="el_order_pengembangan_dlv_pickup">
<span<?= $Page->dlv_pickup->viewAttributes() ?>>
<?= $Page->dlv_pickup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dlv_singlepoint->Visible) { // dlv_singlepoint ?>
    <tr id="r_dlv_singlepoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_dlv_singlepoint"><?= $Page->dlv_singlepoint->caption() ?></span></td>
        <td data-name="dlv_singlepoint" <?= $Page->dlv_singlepoint->cellAttributes() ?>>
<span id="el_order_pengembangan_dlv_singlepoint">
<span<?= $Page->dlv_singlepoint->viewAttributes() ?>>
<?= $Page->dlv_singlepoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dlv_multipoint->Visible) { // dlv_multipoint ?>
    <tr id="r_dlv_multipoint">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_dlv_multipoint"><?= $Page->dlv_multipoint->caption() ?></span></td>
        <td data-name="dlv_multipoint" <?= $Page->dlv_multipoint->cellAttributes() ?>>
<span id="el_order_pengembangan_dlv_multipoint">
<span<?= $Page->dlv_multipoint->viewAttributes() ?>>
<?= $Page->dlv_multipoint->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dlv_multipoint_jml->Visible) { // dlv_multipoint_jml ?>
    <tr id="r_dlv_multipoint_jml">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_dlv_multipoint_jml"><?= $Page->dlv_multipoint_jml->caption() ?></span></td>
        <td data-name="dlv_multipoint_jml" <?= $Page->dlv_multipoint_jml->cellAttributes() ?>>
<span id="el_order_pengembangan_dlv_multipoint_jml">
<span<?= $Page->dlv_multipoint_jml->viewAttributes() ?>>
<?= $Page->dlv_multipoint_jml->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dlv_term_lain->Visible) { // dlv_term_lain ?>
    <tr id="r_dlv_term_lain">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_dlv_term_lain"><?= $Page->dlv_term_lain->caption() ?></span></td>
        <td data-name="dlv_term_lain" <?= $Page->dlv_term_lain->cellAttributes() ?>>
<span id="el_order_pengembangan_dlv_term_lain">
<span<?= $Page->dlv_term_lain->viewAttributes() ?>>
<?= $Page->dlv_term_lain->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatan_khusus->Visible) { // catatan_khusus ?>
    <tr id="r_catatan_khusus">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_catatan_khusus"><?= $Page->catatan_khusus->caption() ?></span></td>
        <td data-name="catatan_khusus" <?= $Page->catatan_khusus->cellAttributes() ?>>
<span id="el_order_pengembangan_catatan_khusus">
<span<?= $Page->catatan_khusus->viewAttributes() ?>>
<?= $Page->catatan_khusus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aju_tgl->Visible) { // aju_tgl ?>
    <tr id="r_aju_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_aju_tgl"><?= $Page->aju_tgl->caption() ?></span></td>
        <td data-name="aju_tgl" <?= $Page->aju_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_aju_tgl">
<span<?= $Page->aju_tgl->viewAttributes() ?>>
<?= $Page->aju_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aju_oleh->Visible) { // aju_oleh ?>
    <tr id="r_aju_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_aju_oleh"><?= $Page->aju_oleh->caption() ?></span></td>
        <td data-name="aju_oleh" <?= $Page->aju_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_aju_oleh">
<span<?= $Page->aju_oleh->viewAttributes() ?>>
<?= $Page->aju_oleh->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proses_tgl->Visible) { // proses_tgl ?>
    <tr id="r_proses_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_proses_tgl"><?= $Page->proses_tgl->caption() ?></span></td>
        <td data-name="proses_tgl" <?= $Page->proses_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_proses_tgl">
<span<?= $Page->proses_tgl->viewAttributes() ?>>
<?= $Page->proses_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proses_oleh->Visible) { // proses_oleh ?>
    <tr id="r_proses_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_proses_oleh"><?= $Page->proses_oleh->caption() ?></span></td>
        <td data-name="proses_oleh" <?= $Page->proses_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_proses_oleh">
<span<?= $Page->proses_oleh->viewAttributes() ?>>
<?= $Page->proses_oleh->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisi_tgl->Visible) { // revisi_tgl ?>
    <tr id="r_revisi_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_revisi_tgl"><?= $Page->revisi_tgl->caption() ?></span></td>
        <td data-name="revisi_tgl" <?= $Page->revisi_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_revisi_tgl">
<span<?= $Page->revisi_tgl->viewAttributes() ?>>
<?= $Page->revisi_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisi_oleh->Visible) { // revisi_oleh ?>
    <tr id="r_revisi_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_revisi_oleh"><?= $Page->revisi_oleh->caption() ?></span></td>
        <td data-name="revisi_oleh" <?= $Page->revisi_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_revisi_oleh">
<span<?= $Page->revisi_oleh->viewAttributes() ?>>
<?= $Page->revisi_oleh->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisi_akun_tgl->Visible) { // revisi_akun_tgl ?>
    <tr id="r_revisi_akun_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_revisi_akun_tgl"><?= $Page->revisi_akun_tgl->caption() ?></span></td>
        <td data-name="revisi_akun_tgl" <?= $Page->revisi_akun_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_revisi_akun_tgl">
<span<?= $Page->revisi_akun_tgl->viewAttributes() ?>>
<?= $Page->revisi_akun_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisi_akun_oleh->Visible) { // revisi_akun_oleh ?>
    <tr id="r_revisi_akun_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_revisi_akun_oleh"><?= $Page->revisi_akun_oleh->caption() ?></span></td>
        <td data-name="revisi_akun_oleh" <?= $Page->revisi_akun_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_revisi_akun_oleh">
<span<?= $Page->revisi_akun_oleh->viewAttributes() ?>>
<?= $Page->revisi_akun_oleh->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisi_rnd_tgl->Visible) { // revisi_rnd_tgl ?>
    <tr id="r_revisi_rnd_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_revisi_rnd_tgl"><?= $Page->revisi_rnd_tgl->caption() ?></span></td>
        <td data-name="revisi_rnd_tgl" <?= $Page->revisi_rnd_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_revisi_rnd_tgl">
<span<?= $Page->revisi_rnd_tgl->viewAttributes() ?>>
<?= $Page->revisi_rnd_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->revisi_rnd_oleh->Visible) { // revisi_rnd_oleh ?>
    <tr id="r_revisi_rnd_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_revisi_rnd_oleh"><?= $Page->revisi_rnd_oleh->caption() ?></span></td>
        <td data-name="revisi_rnd_oleh" <?= $Page->revisi_rnd_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_revisi_rnd_oleh">
<span<?= $Page->revisi_rnd_oleh->viewAttributes() ?>>
<?= $Page->revisi_rnd_oleh->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rnd_tgl->Visible) { // rnd_tgl ?>
    <tr id="r_rnd_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_rnd_tgl"><?= $Page->rnd_tgl->caption() ?></span></td>
        <td data-name="rnd_tgl" <?= $Page->rnd_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_rnd_tgl">
<span<?= $Page->rnd_tgl->viewAttributes() ?>>
<?= $Page->rnd_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rnd_oleh->Visible) { // rnd_oleh ?>
    <tr id="r_rnd_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_rnd_oleh"><?= $Page->rnd_oleh->caption() ?></span></td>
        <td data-name="rnd_oleh" <?= $Page->rnd_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_rnd_oleh">
<span<?= $Page->rnd_oleh->viewAttributes() ?>>
<?= $Page->rnd_oleh->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ap_tgl->Visible) { // ap_tgl ?>
    <tr id="r_ap_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_ap_tgl"><?= $Page->ap_tgl->caption() ?></span></td>
        <td data-name="ap_tgl" <?= $Page->ap_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_ap_tgl">
<span<?= $Page->ap_tgl->viewAttributes() ?>>
<?= $Page->ap_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ap_oleh->Visible) { // ap_oleh ?>
    <tr id="r_ap_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_ap_oleh"><?= $Page->ap_oleh->caption() ?></span></td>
        <td data-name="ap_oleh" <?= $Page->ap_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_ap_oleh">
<span<?= $Page->ap_oleh->viewAttributes() ?>>
<?= $Page->ap_oleh->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->batal_tgl->Visible) { // batal_tgl ?>
    <tr id="r_batal_tgl">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_batal_tgl"><?= $Page->batal_tgl->caption() ?></span></td>
        <td data-name="batal_tgl" <?= $Page->batal_tgl->cellAttributes() ?>>
<span id="el_order_pengembangan_batal_tgl">
<span<?= $Page->batal_tgl->viewAttributes() ?>>
<?= $Page->batal_tgl->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->batal_oleh->Visible) { // batal_oleh ?>
    <tr id="r_batal_oleh">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_order_pengembangan_batal_oleh"><?= $Page->batal_oleh->caption() ?></span></td>
        <td data-name="batal_oleh" <?= $Page->batal_oleh->cellAttributes() ?>>
<span id="el_order_pengembangan_batal_oleh">
<span<?= $Page->batal_oleh->viewAttributes() ?>>
<?= $Page->batal_oleh->getViewValue() ?></span>
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
