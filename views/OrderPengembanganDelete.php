<?php

namespace PHPMaker2021\distributor;

// Page object
$OrderPengembanganDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var forder_pengembangandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    forder_pengembangandelete = currentForm = new ew.Form("forder_pengembangandelete", "delete");
    loadjs.done("forder_pengembangandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.order_pengembangan) ew.vars.tables.order_pengembangan = <?= JsonEncode(GetClientVar("tables", "order_pengembangan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="forder_pengembangandelete" id="forder_pengembangandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_pengembangan">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_order_pengembangan_id" class="order_pengembangan_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cpo_jenis->Visible) { // cpo_jenis ?>
        <th class="<?= $Page->cpo_jenis->headerCellClass() ?>"><span id="elh_order_pengembangan_cpo_jenis" class="order_pengembangan_cpo_jenis"><?= $Page->cpo_jenis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ordernum->Visible) { // ordernum ?>
        <th class="<?= $Page->ordernum->headerCellClass() ?>"><span id="elh_order_pengembangan_ordernum" class="order_pengembangan_ordernum"><?= $Page->ordernum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->order_kode->Visible) { // order_kode ?>
        <th class="<?= $Page->order_kode->headerCellClass() ?>"><span id="elh_order_pengembangan_order_kode" class="order_pengembangan_order_kode"><?= $Page->order_kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->orderterimatgl->Visible) { // orderterimatgl ?>
        <th class="<?= $Page->orderterimatgl->headerCellClass() ?>"><span id="elh_order_pengembangan_orderterimatgl" class="order_pengembangan_orderterimatgl"><?= $Page->orderterimatgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->produk_fungsi->Visible) { // produk_fungsi ?>
        <th class="<?= $Page->produk_fungsi->headerCellClass() ?>"><span id="elh_order_pengembangan_produk_fungsi" class="order_pengembangan_produk_fungsi"><?= $Page->produk_fungsi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->produk_kualitas->Visible) { // produk_kualitas ?>
        <th class="<?= $Page->produk_kualitas->headerCellClass() ?>"><span id="elh_order_pengembangan_produk_kualitas" class="order_pengembangan_produk_kualitas"><?= $Page->produk_kualitas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->produk_campaign->Visible) { // produk_campaign ?>
        <th class="<?= $Page->produk_campaign->headerCellClass() ?>"><span id="elh_order_pengembangan_produk_campaign" class="order_pengembangan_produk_campaign"><?= $Page->produk_campaign->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasan_satuan->Visible) { // kemasan_satuan ?>
        <th class="<?= $Page->kemasan_satuan->headerCellClass() ?>"><span id="elh_order_pengembangan_kemasan_satuan" class="order_pengembangan_kemasan_satuan"><?= $Page->kemasan_satuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ordertgl->Visible) { // ordertgl ?>
        <th class="<?= $Page->ordertgl->headerCellClass() ?>"><span id="elh_order_pengembangan_ordertgl" class="order_pengembangan_ordertgl"><?= $Page->ordertgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->custcode->Visible) { // custcode ?>
        <th class="<?= $Page->custcode->headerCellClass() ?>"><span id="elh_order_pengembangan_custcode" class="order_pengembangan_custcode"><?= $Page->custcode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->perushnama->Visible) { // perushnama ?>
        <th class="<?= $Page->perushnama->headerCellClass() ?>"><span id="elh_order_pengembangan_perushnama" class="order_pengembangan_perushnama"><?= $Page->perushnama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->perushalamat->Visible) { // perushalamat ?>
        <th class="<?= $Page->perushalamat->headerCellClass() ?>"><span id="elh_order_pengembangan_perushalamat" class="order_pengembangan_perushalamat"><?= $Page->perushalamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->perushcp->Visible) { // perushcp ?>
        <th class="<?= $Page->perushcp->headerCellClass() ?>"><span id="elh_order_pengembangan_perushcp" class="order_pengembangan_perushcp"><?= $Page->perushcp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->perushjabatan->Visible) { // perushjabatan ?>
        <th class="<?= $Page->perushjabatan->headerCellClass() ?>"><span id="elh_order_pengembangan_perushjabatan" class="order_pengembangan_perushjabatan"><?= $Page->perushjabatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->perushphone->Visible) { // perushphone ?>
        <th class="<?= $Page->perushphone->headerCellClass() ?>"><span id="elh_order_pengembangan_perushphone" class="order_pengembangan_perushphone"><?= $Page->perushphone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->perushmobile->Visible) { // perushmobile ?>
        <th class="<?= $Page->perushmobile->headerCellClass() ?>"><span id="elh_order_pengembangan_perushmobile" class="order_pengembangan_perushmobile"><?= $Page->perushmobile->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bencmark->Visible) { // bencmark ?>
        <th class="<?= $Page->bencmark->headerCellClass() ?>"><span id="elh_order_pengembangan_bencmark" class="order_pengembangan_bencmark"><?= $Page->bencmark->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
        <th class="<?= $Page->kategoriproduk->headerCellClass() ?>"><span id="elh_order_pengembangan_kategoriproduk" class="order_pengembangan_kategoriproduk"><?= $Page->kategoriproduk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
        <th class="<?= $Page->jenisproduk->headerCellClass() ?>"><span id="elh_order_pengembangan_jenisproduk" class="order_pengembangan_jenisproduk"><?= $Page->jenisproduk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bentuksediaan->Visible) { // bentuksediaan ?>
        <th class="<?= $Page->bentuksediaan->headerCellClass() ?>"><span id="elh_order_pengembangan_bentuksediaan" class="order_pengembangan_bentuksediaan"><?= $Page->bentuksediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sediaan_ukuran->Visible) { // sediaan_ukuran ?>
        <th class="<?= $Page->sediaan_ukuran->headerCellClass() ?>"><span id="elh_order_pengembangan_sediaan_ukuran" class="order_pengembangan_sediaan_ukuran"><?= $Page->sediaan_ukuran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sediaan_ukuran_satuan->Visible) { // sediaan_ukuran_satuan ?>
        <th class="<?= $Page->sediaan_ukuran_satuan->headerCellClass() ?>"><span id="elh_order_pengembangan_sediaan_ukuran_satuan" class="order_pengembangan_sediaan_ukuran_satuan"><?= $Page->sediaan_ukuran_satuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->produk_viskositas->Visible) { // produk_viskositas ?>
        <th class="<?= $Page->produk_viskositas->headerCellClass() ?>"><span id="elh_order_pengembangan_produk_viskositas" class="order_pengembangan_produk_viskositas"><?= $Page->produk_viskositas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->konsepproduk->Visible) { // konsepproduk ?>
        <th class="<?= $Page->konsepproduk->headerCellClass() ?>"><span id="elh_order_pengembangan_konsepproduk" class="order_pengembangan_konsepproduk"><?= $Page->konsepproduk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <th class="<?= $Page->fragrance->headerCellClass() ?>"><span id="elh_order_pengembangan_fragrance" class="order_pengembangan_fragrance"><?= $Page->fragrance->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <th class="<?= $Page->aroma->headerCellClass() ?>"><span id="elh_order_pengembangan_aroma" class="order_pengembangan_aroma"><?= $Page->aroma->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <th class="<?= $Page->bahanaktif->headerCellClass() ?>"><span id="elh_order_pengembangan_bahanaktif" class="order_pengembangan_bahanaktif"><?= $Page->bahanaktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th class="<?= $Page->warna->headerCellClass() ?>"><span id="elh_order_pengembangan_warna" class="order_pengembangan_warna"><?= $Page->warna->caption() ?></span></th>
<?php } ?>
<?php if ($Page->produk_warna_jenis->Visible) { // produk_warna_jenis ?>
        <th class="<?= $Page->produk_warna_jenis->headerCellClass() ?>"><span id="elh_order_pengembangan_produk_warna_jenis" class="order_pengembangan_produk_warna_jenis"><?= $Page->produk_warna_jenis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <th class="<?= $Page->aksesoris->headerCellClass() ?>"><span id="elh_order_pengembangan_aksesoris" class="order_pengembangan_aksesoris"><?= $Page->aksesoris->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statusproduk->Visible) { // statusproduk ?>
        <th class="<?= $Page->statusproduk->headerCellClass() ?>"><span id="elh_order_pengembangan_statusproduk" class="order_pengembangan_statusproduk"><?= $Page->statusproduk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
        <th class="<?= $Page->parfum->headerCellClass() ?>"><span id="elh_order_pengembangan_parfum" class="order_pengembangan_parfum"><?= $Page->parfum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
        <th class="<?= $Page->catatan->headerCellClass() ?>"><span id="elh_order_pengembangan_catatan" class="order_pengembangan_catatan"><?= $Page->catatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rencanakemasan->Visible) { // rencanakemasan ?>
        <th class="<?= $Page->rencanakemasan->headerCellClass() ?>"><span id="elh_order_pengembangan_rencanakemasan" class="order_pengembangan_rencanakemasan"><?= $Page->rencanakemasan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ekspetasiharga->Visible) { // ekspetasiharga ?>
        <th class="<?= $Page->ekspetasiharga->headerCellClass() ?>"><span id="elh_order_pengembangan_ekspetasiharga" class="order_pengembangan_ekspetasiharga"><?= $Page->ekspetasiharga->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasan->Visible) { // kemasan ?>
        <th class="<?= $Page->kemasan->headerCellClass() ?>"><span id="elh_order_pengembangan_kemasan" class="order_pengembangan_kemasan"><?= $Page->kemasan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
        <th class="<?= $Page->volume->headerCellClass() ?>"><span id="elh_order_pengembangan_volume" class="order_pengembangan_volume"><?= $Page->volume->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
        <th class="<?= $Page->jenistutup->headerCellClass() ?>"><span id="elh_order_pengembangan_jenistutup" class="order_pengembangan_jenistutup"><?= $Page->jenistutup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->infopackaging->Visible) { // infopackaging ?>
        <th class="<?= $Page->infopackaging->headerCellClass() ?>"><span id="elh_order_pengembangan_infopackaging" class="order_pengembangan_infopackaging"><?= $Page->infopackaging->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <th class="<?= $Page->ukuran->headerCellClass() ?>"><span id="elh_order_pengembangan_ukuran" class="order_pengembangan_ukuran"><?= $Page->ukuran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desainprodukkemasan->Visible) { // desainprodukkemasan ?>
        <th class="<?= $Page->desainprodukkemasan->headerCellClass() ?>"><span id="elh_order_pengembangan_desainprodukkemasan" class="order_pengembangan_desainprodukkemasan"><?= $Page->desainprodukkemasan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desaindiinginkan->Visible) { // desaindiinginkan ?>
        <th class="<?= $Page->desaindiinginkan->headerCellClass() ?>"><span id="elh_order_pengembangan_desaindiinginkan" class="order_pengembangan_desaindiinginkan"><?= $Page->desaindiinginkan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mereknotifikasi->Visible) { // mereknotifikasi ?>
        <th class="<?= $Page->mereknotifikasi->headerCellClass() ?>"><span id="elh_order_pengembangan_mereknotifikasi" class="order_pengembangan_mereknotifikasi"><?= $Page->mereknotifikasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kategoristatus->Visible) { // kategoristatus ?>
        <th class="<?= $Page->kategoristatus->headerCellClass() ?>"><span id="elh_order_pengembangan_kategoristatus" class="order_pengembangan_kategoristatus"><?= $Page->kategoristatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kemasan_ukuran_satuan->Visible) { // kemasan_ukuran_satuan ?>
        <th class="<?= $Page->kemasan_ukuran_satuan->headerCellClass() ?>"><span id="elh_order_pengembangan_kemasan_ukuran_satuan" class="order_pengembangan_kemasan_ukuran_satuan"><?= $Page->kemasan_ukuran_satuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->infolabel->Visible) { // infolabel ?>
        <th class="<?= $Page->infolabel->headerCellClass() ?>"><span id="elh_order_pengembangan_infolabel" class="order_pengembangan_infolabel"><?= $Page->infolabel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
        <th class="<?= $Page->labelkualitas->headerCellClass() ?>"><span id="elh_order_pengembangan_labelkualitas" class="order_pengembangan_labelkualitas"><?= $Page->labelkualitas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
        <th class="<?= $Page->labelposisi->headerCellClass() ?>"><span id="elh_order_pengembangan_labelposisi" class="order_pengembangan_labelposisi"><?= $Page->labelposisi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <th class="<?= $Page->dibuatdi->headerCellClass() ?>"><span id="elh_order_pengembangan_dibuatdi" class="order_pengembangan_dibuatdi"><?= $Page->dibuatdi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <th class="<?= $Page->tanggal->headerCellClass() ?>"><span id="elh_order_pengembangan_tanggal" class="order_pengembangan_tanggal"><?= $Page->tanggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
        <th class="<?= $Page->penerima->headerCellClass() ?>"><span id="elh_order_pengembangan_penerima" class="order_pengembangan_penerima"><?= $Page->penerima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createat->Visible) { // createat ?>
        <th class="<?= $Page->createat->headerCellClass() ?>"><span id="elh_order_pengembangan_createat" class="order_pengembangan_createat"><?= $Page->createat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createby->Visible) { // createby ?>
        <th class="<?= $Page->createby->headerCellClass() ?>"><span id="elh_order_pengembangan_createby" class="order_pengembangan_createby"><?= $Page->createby->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statusdokumen->Visible) { // statusdokumen ?>
        <th class="<?= $Page->statusdokumen->headerCellClass() ?>"><span id="elh_order_pengembangan_statusdokumen" class="order_pengembangan_statusdokumen"><?= $Page->statusdokumen->caption() ?></span></th>
<?php } ?>
<?php if ($Page->update_at->Visible) { // update_at ?>
        <th class="<?= $Page->update_at->headerCellClass() ?>"><span id="elh_order_pengembangan_update_at" class="order_pengembangan_update_at"><?= $Page->update_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status_data->Visible) { // status_data ?>
        <th class="<?= $Page->status_data->headerCellClass() ?>"><span id="elh_order_pengembangan_status_data" class="order_pengembangan_status_data"><?= $Page->status_data->caption() ?></span></th>
<?php } ?>
<?php if ($Page->harga_rnd->Visible) { // harga_rnd ?>
        <th class="<?= $Page->harga_rnd->headerCellClass() ?>"><span id="elh_order_pengembangan_harga_rnd" class="order_pengembangan_harga_rnd"><?= $Page->harga_rnd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <th class="<?= $Page->aplikasi_sediaan->headerCellClass() ?>"><span id="elh_order_pengembangan_aplikasi_sediaan" class="order_pengembangan_aplikasi_sediaan"><?= $Page->aplikasi_sediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_isi->Visible) { // hu_hrg_isi ?>
        <th class="<?= $Page->hu_hrg_isi->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_isi" class="order_pengembangan_hu_hrg_isi"><?= $Page->hu_hrg_isi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_isi_pro->Visible) { // hu_hrg_isi_pro ?>
        <th class="<?= $Page->hu_hrg_isi_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_isi_pro" class="order_pengembangan_hu_hrg_isi_pro"><?= $Page->hu_hrg_isi_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer->Visible) { // hu_hrg_kms_primer ?>
        <th class="<?= $Page->hu_hrg_kms_primer->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_kms_primer" class="order_pengembangan_hu_hrg_kms_primer"><?= $Page->hu_hrg_kms_primer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer_pro->Visible) { // hu_hrg_kms_primer_pro ?>
        <th class="<?= $Page->hu_hrg_kms_primer_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_kms_primer_pro" class="order_pengembangan_hu_hrg_kms_primer_pro"><?= $Page->hu_hrg_kms_primer_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder->Visible) { // hu_hrg_kms_sekunder ?>
        <th class="<?= $Page->hu_hrg_kms_sekunder->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_kms_sekunder" class="order_pengembangan_hu_hrg_kms_sekunder"><?= $Page->hu_hrg_kms_sekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder_pro->Visible) { // hu_hrg_kms_sekunder_pro ?>
        <th class="<?= $Page->hu_hrg_kms_sekunder_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_kms_sekunder_pro" class="order_pengembangan_hu_hrg_kms_sekunder_pro"><?= $Page->hu_hrg_kms_sekunder_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_label->Visible) { // hu_hrg_label ?>
        <th class="<?= $Page->hu_hrg_label->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_label" class="order_pengembangan_hu_hrg_label"><?= $Page->hu_hrg_label->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_label_pro->Visible) { // hu_hrg_label_pro ?>
        <th class="<?= $Page->hu_hrg_label_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_label_pro" class="order_pengembangan_hu_hrg_label_pro"><?= $Page->hu_hrg_label_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_total->Visible) { // hu_hrg_total ?>
        <th class="<?= $Page->hu_hrg_total->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_total" class="order_pengembangan_hu_hrg_total"><?= $Page->hu_hrg_total->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hu_hrg_total_pro->Visible) { // hu_hrg_total_pro ?>
        <th class="<?= $Page->hu_hrg_total_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hu_hrg_total_pro" class="order_pengembangan_hu_hrg_total_pro"><?= $Page->hu_hrg_total_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_isi->Visible) { // hl_hrg_isi ?>
        <th class="<?= $Page->hl_hrg_isi->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_isi" class="order_pengembangan_hl_hrg_isi"><?= $Page->hl_hrg_isi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_isi_pro->Visible) { // hl_hrg_isi_pro ?>
        <th class="<?= $Page->hl_hrg_isi_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_isi_pro" class="order_pengembangan_hl_hrg_isi_pro"><?= $Page->hl_hrg_isi_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer->Visible) { // hl_hrg_kms_primer ?>
        <th class="<?= $Page->hl_hrg_kms_primer->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_kms_primer" class="order_pengembangan_hl_hrg_kms_primer"><?= $Page->hl_hrg_kms_primer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer_pro->Visible) { // hl_hrg_kms_primer_pro ?>
        <th class="<?= $Page->hl_hrg_kms_primer_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_kms_primer_pro" class="order_pengembangan_hl_hrg_kms_primer_pro"><?= $Page->hl_hrg_kms_primer_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder->Visible) { // hl_hrg_kms_sekunder ?>
        <th class="<?= $Page->hl_hrg_kms_sekunder->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_kms_sekunder" class="order_pengembangan_hl_hrg_kms_sekunder"><?= $Page->hl_hrg_kms_sekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder_pro->Visible) { // hl_hrg_kms_sekunder_pro ?>
        <th class="<?= $Page->hl_hrg_kms_sekunder_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_kms_sekunder_pro" class="order_pengembangan_hl_hrg_kms_sekunder_pro"><?= $Page->hl_hrg_kms_sekunder_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_label->Visible) { // hl_hrg_label ?>
        <th class="<?= $Page->hl_hrg_label->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_label" class="order_pengembangan_hl_hrg_label"><?= $Page->hl_hrg_label->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_label_pro->Visible) { // hl_hrg_label_pro ?>
        <th class="<?= $Page->hl_hrg_label_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_label_pro" class="order_pengembangan_hl_hrg_label_pro"><?= $Page->hl_hrg_label_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_total->Visible) { // hl_hrg_total ?>
        <th class="<?= $Page->hl_hrg_total->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_total" class="order_pengembangan_hl_hrg_total"><?= $Page->hl_hrg_total->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hl_hrg_total_pro->Visible) { // hl_hrg_total_pro ?>
        <th class="<?= $Page->hl_hrg_total_pro->headerCellClass() ?>"><span id="elh_order_pengembangan_hl_hrg_total_pro" class="order_pengembangan_hl_hrg_total_pro"><?= $Page->hl_hrg_total_pro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bs_bahan_aktif_tick->Visible) { // bs_bahan_aktif_tick ?>
        <th class="<?= $Page->bs_bahan_aktif_tick->headerCellClass() ?>"><span id="elh_order_pengembangan_bs_bahan_aktif_tick" class="order_pengembangan_bs_bahan_aktif_tick"><?= $Page->bs_bahan_aktif_tick->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aju_tgl->Visible) { // aju_tgl ?>
        <th class="<?= $Page->aju_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_aju_tgl" class="order_pengembangan_aju_tgl"><?= $Page->aju_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aju_oleh->Visible) { // aju_oleh ?>
        <th class="<?= $Page->aju_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_aju_oleh" class="order_pengembangan_aju_oleh"><?= $Page->aju_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->proses_tgl->Visible) { // proses_tgl ?>
        <th class="<?= $Page->proses_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_proses_tgl" class="order_pengembangan_proses_tgl"><?= $Page->proses_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->proses_oleh->Visible) { // proses_oleh ?>
        <th class="<?= $Page->proses_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_proses_oleh" class="order_pengembangan_proses_oleh"><?= $Page->proses_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisi_tgl->Visible) { // revisi_tgl ?>
        <th class="<?= $Page->revisi_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_revisi_tgl" class="order_pengembangan_revisi_tgl"><?= $Page->revisi_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisi_oleh->Visible) { // revisi_oleh ?>
        <th class="<?= $Page->revisi_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_revisi_oleh" class="order_pengembangan_revisi_oleh"><?= $Page->revisi_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisi_akun_tgl->Visible) { // revisi_akun_tgl ?>
        <th class="<?= $Page->revisi_akun_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_revisi_akun_tgl" class="order_pengembangan_revisi_akun_tgl"><?= $Page->revisi_akun_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisi_akun_oleh->Visible) { // revisi_akun_oleh ?>
        <th class="<?= $Page->revisi_akun_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_revisi_akun_oleh" class="order_pengembangan_revisi_akun_oleh"><?= $Page->revisi_akun_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisi_rnd_tgl->Visible) { // revisi_rnd_tgl ?>
        <th class="<?= $Page->revisi_rnd_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_revisi_rnd_tgl" class="order_pengembangan_revisi_rnd_tgl"><?= $Page->revisi_rnd_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->revisi_rnd_oleh->Visible) { // revisi_rnd_oleh ?>
        <th class="<?= $Page->revisi_rnd_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_revisi_rnd_oleh" class="order_pengembangan_revisi_rnd_oleh"><?= $Page->revisi_rnd_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rnd_tgl->Visible) { // rnd_tgl ?>
        <th class="<?= $Page->rnd_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_rnd_tgl" class="order_pengembangan_rnd_tgl"><?= $Page->rnd_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rnd_oleh->Visible) { // rnd_oleh ?>
        <th class="<?= $Page->rnd_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_rnd_oleh" class="order_pengembangan_rnd_oleh"><?= $Page->rnd_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ap_tgl->Visible) { // ap_tgl ?>
        <th class="<?= $Page->ap_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_ap_tgl" class="order_pengembangan_ap_tgl"><?= $Page->ap_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ap_oleh->Visible) { // ap_oleh ?>
        <th class="<?= $Page->ap_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_ap_oleh" class="order_pengembangan_ap_oleh"><?= $Page->ap_oleh->caption() ?></span></th>
<?php } ?>
<?php if ($Page->batal_tgl->Visible) { // batal_tgl ?>
        <th class="<?= $Page->batal_tgl->headerCellClass() ?>"><span id="elh_order_pengembangan_batal_tgl" class="order_pengembangan_batal_tgl"><?= $Page->batal_tgl->caption() ?></span></th>
<?php } ?>
<?php if ($Page->batal_oleh->Visible) { // batal_oleh ?>
        <th class="<?= $Page->batal_oleh->headerCellClass() ?>"><span id="elh_order_pengembangan_batal_oleh" class="order_pengembangan_batal_oleh"><?= $Page->batal_oleh->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_id" class="order_pengembangan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cpo_jenis->Visible) { // cpo_jenis ?>
        <td <?= $Page->cpo_jenis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_cpo_jenis" class="order_pengembangan_cpo_jenis">
<span<?= $Page->cpo_jenis->viewAttributes() ?>>
<?= $Page->cpo_jenis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ordernum->Visible) { // ordernum ?>
        <td <?= $Page->ordernum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ordernum" class="order_pengembangan_ordernum">
<span<?= $Page->ordernum->viewAttributes() ?>>
<?= $Page->ordernum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->order_kode->Visible) { // order_kode ?>
        <td <?= $Page->order_kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_order_kode" class="order_pengembangan_order_kode">
<span<?= $Page->order_kode->viewAttributes() ?>>
<?= $Page->order_kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->orderterimatgl->Visible) { // orderterimatgl ?>
        <td <?= $Page->orderterimatgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_orderterimatgl" class="order_pengembangan_orderterimatgl">
<span<?= $Page->orderterimatgl->viewAttributes() ?>>
<?= $Page->orderterimatgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->produk_fungsi->Visible) { // produk_fungsi ?>
        <td <?= $Page->produk_fungsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_fungsi" class="order_pengembangan_produk_fungsi">
<span<?= $Page->produk_fungsi->viewAttributes() ?>>
<?= $Page->produk_fungsi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->produk_kualitas->Visible) { // produk_kualitas ?>
        <td <?= $Page->produk_kualitas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_kualitas" class="order_pengembangan_produk_kualitas">
<span<?= $Page->produk_kualitas->viewAttributes() ?>>
<?= $Page->produk_kualitas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->produk_campaign->Visible) { // produk_campaign ?>
        <td <?= $Page->produk_campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_campaign" class="order_pengembangan_produk_campaign">
<span<?= $Page->produk_campaign->viewAttributes() ?>>
<?= $Page->produk_campaign->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasan_satuan->Visible) { // kemasan_satuan ?>
        <td <?= $Page->kemasan_satuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kemasan_satuan" class="order_pengembangan_kemasan_satuan">
<span<?= $Page->kemasan_satuan->viewAttributes() ?>>
<?= $Page->kemasan_satuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ordertgl->Visible) { // ordertgl ?>
        <td <?= $Page->ordertgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ordertgl" class="order_pengembangan_ordertgl">
<span<?= $Page->ordertgl->viewAttributes() ?>>
<?= $Page->ordertgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->custcode->Visible) { // custcode ?>
        <td <?= $Page->custcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_custcode" class="order_pengembangan_custcode">
<span<?= $Page->custcode->viewAttributes() ?>>
<?= $Page->custcode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->perushnama->Visible) { // perushnama ?>
        <td <?= $Page->perushnama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushnama" class="order_pengembangan_perushnama">
<span<?= $Page->perushnama->viewAttributes() ?>>
<?= $Page->perushnama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->perushalamat->Visible) { // perushalamat ?>
        <td <?= $Page->perushalamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushalamat" class="order_pengembangan_perushalamat">
<span<?= $Page->perushalamat->viewAttributes() ?>>
<?= $Page->perushalamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->perushcp->Visible) { // perushcp ?>
        <td <?= $Page->perushcp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushcp" class="order_pengembangan_perushcp">
<span<?= $Page->perushcp->viewAttributes() ?>>
<?= $Page->perushcp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->perushjabatan->Visible) { // perushjabatan ?>
        <td <?= $Page->perushjabatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushjabatan" class="order_pengembangan_perushjabatan">
<span<?= $Page->perushjabatan->viewAttributes() ?>>
<?= $Page->perushjabatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->perushphone->Visible) { // perushphone ?>
        <td <?= $Page->perushphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushphone" class="order_pengembangan_perushphone">
<span<?= $Page->perushphone->viewAttributes() ?>>
<?= $Page->perushphone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->perushmobile->Visible) { // perushmobile ?>
        <td <?= $Page->perushmobile->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushmobile" class="order_pengembangan_perushmobile">
<span<?= $Page->perushmobile->viewAttributes() ?>>
<?= $Page->perushmobile->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bencmark->Visible) { // bencmark ?>
        <td <?= $Page->bencmark->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bencmark" class="order_pengembangan_bencmark">
<span<?= $Page->bencmark->viewAttributes() ?>>
<?= $Page->bencmark->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
        <td <?= $Page->kategoriproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kategoriproduk" class="order_pengembangan_kategoriproduk">
<span<?= $Page->kategoriproduk->viewAttributes() ?>>
<?= $Page->kategoriproduk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
        <td <?= $Page->jenisproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_jenisproduk" class="order_pengembangan_jenisproduk">
<span<?= $Page->jenisproduk->viewAttributes() ?>>
<?= $Page->jenisproduk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bentuksediaan->Visible) { // bentuksediaan ?>
        <td <?= $Page->bentuksediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bentuksediaan" class="order_pengembangan_bentuksediaan">
<span<?= $Page->bentuksediaan->viewAttributes() ?>>
<?= $Page->bentuksediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sediaan_ukuran->Visible) { // sediaan_ukuran ?>
        <td <?= $Page->sediaan_ukuran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_sediaan_ukuran" class="order_pengembangan_sediaan_ukuran">
<span<?= $Page->sediaan_ukuran->viewAttributes() ?>>
<?= $Page->sediaan_ukuran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sediaan_ukuran_satuan->Visible) { // sediaan_ukuran_satuan ?>
        <td <?= $Page->sediaan_ukuran_satuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_sediaan_ukuran_satuan" class="order_pengembangan_sediaan_ukuran_satuan">
<span<?= $Page->sediaan_ukuran_satuan->viewAttributes() ?>>
<?= $Page->sediaan_ukuran_satuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->produk_viskositas->Visible) { // produk_viskositas ?>
        <td <?= $Page->produk_viskositas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_viskositas" class="order_pengembangan_produk_viskositas">
<span<?= $Page->produk_viskositas->viewAttributes() ?>>
<?= $Page->produk_viskositas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->konsepproduk->Visible) { // konsepproduk ?>
        <td <?= $Page->konsepproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_konsepproduk" class="order_pengembangan_konsepproduk">
<span<?= $Page->konsepproduk->viewAttributes() ?>>
<?= $Page->konsepproduk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <td <?= $Page->fragrance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_fragrance" class="order_pengembangan_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <td <?= $Page->aroma->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aroma" class="order_pengembangan_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <td <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bahanaktif" class="order_pengembangan_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <td <?= $Page->warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_warna" class="order_pengembangan_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->produk_warna_jenis->Visible) { // produk_warna_jenis ?>
        <td <?= $Page->produk_warna_jenis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_warna_jenis" class="order_pengembangan_produk_warna_jenis">
<span<?= $Page->produk_warna_jenis->viewAttributes() ?>>
<?= $Page->produk_warna_jenis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <td <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aksesoris" class="order_pengembangan_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statusproduk->Visible) { // statusproduk ?>
        <td <?= $Page->statusproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_statusproduk" class="order_pengembangan_statusproduk">
<span<?= $Page->statusproduk->viewAttributes() ?>>
<?= $Page->statusproduk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
        <td <?= $Page->parfum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_parfum" class="order_pengembangan_parfum">
<span<?= $Page->parfum->viewAttributes() ?>>
<?= $Page->parfum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
        <td <?= $Page->catatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_catatan" class="order_pengembangan_catatan">
<span<?= $Page->catatan->viewAttributes() ?>>
<?= $Page->catatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rencanakemasan->Visible) { // rencanakemasan ?>
        <td <?= $Page->rencanakemasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_rencanakemasan" class="order_pengembangan_rencanakemasan">
<span<?= $Page->rencanakemasan->viewAttributes() ?>>
<?= $Page->rencanakemasan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ekspetasiharga->Visible) { // ekspetasiharga ?>
        <td <?= $Page->ekspetasiharga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ekspetasiharga" class="order_pengembangan_ekspetasiharga">
<span<?= $Page->ekspetasiharga->viewAttributes() ?>>
<?= $Page->ekspetasiharga->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasan->Visible) { // kemasan ?>
        <td <?= $Page->kemasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kemasan" class="order_pengembangan_kemasan">
<span<?= $Page->kemasan->viewAttributes() ?>>
<?= $Page->kemasan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
        <td <?= $Page->volume->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_volume" class="order_pengembangan_volume">
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
        <td <?= $Page->jenistutup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_jenistutup" class="order_pengembangan_jenistutup">
<span<?= $Page->jenistutup->viewAttributes() ?>>
<?= $Page->jenistutup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->infopackaging->Visible) { // infopackaging ?>
        <td <?= $Page->infopackaging->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_infopackaging" class="order_pengembangan_infopackaging">
<span<?= $Page->infopackaging->viewAttributes() ?>>
<?= $Page->infopackaging->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <td <?= $Page->ukuran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ukuran" class="order_pengembangan_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desainprodukkemasan->Visible) { // desainprodukkemasan ?>
        <td <?= $Page->desainprodukkemasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_desainprodukkemasan" class="order_pengembangan_desainprodukkemasan">
<span<?= $Page->desainprodukkemasan->viewAttributes() ?>>
<?= $Page->desainprodukkemasan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desaindiinginkan->Visible) { // desaindiinginkan ?>
        <td <?= $Page->desaindiinginkan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_desaindiinginkan" class="order_pengembangan_desaindiinginkan">
<span<?= $Page->desaindiinginkan->viewAttributes() ?>>
<?= $Page->desaindiinginkan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mereknotifikasi->Visible) { // mereknotifikasi ?>
        <td <?= $Page->mereknotifikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_mereknotifikasi" class="order_pengembangan_mereknotifikasi">
<span<?= $Page->mereknotifikasi->viewAttributes() ?>>
<?= $Page->mereknotifikasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kategoristatus->Visible) { // kategoristatus ?>
        <td <?= $Page->kategoristatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kategoristatus" class="order_pengembangan_kategoristatus">
<span<?= $Page->kategoristatus->viewAttributes() ?>>
<?= $Page->kategoristatus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kemasan_ukuran_satuan->Visible) { // kemasan_ukuran_satuan ?>
        <td <?= $Page->kemasan_ukuran_satuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kemasan_ukuran_satuan" class="order_pengembangan_kemasan_ukuran_satuan">
<span<?= $Page->kemasan_ukuran_satuan->viewAttributes() ?>>
<?= $Page->kemasan_ukuran_satuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->infolabel->Visible) { // infolabel ?>
        <td <?= $Page->infolabel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_infolabel" class="order_pengembangan_infolabel">
<span<?= $Page->infolabel->viewAttributes() ?>>
<?= $Page->infolabel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
        <td <?= $Page->labelkualitas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_labelkualitas" class="order_pengembangan_labelkualitas">
<span<?= $Page->labelkualitas->viewAttributes() ?>>
<?= $Page->labelkualitas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
        <td <?= $Page->labelposisi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_labelposisi" class="order_pengembangan_labelposisi">
<span<?= $Page->labelposisi->viewAttributes() ?>>
<?= $Page->labelposisi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <td <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_dibuatdi" class="order_pengembangan_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <td <?= $Page->tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_tanggal" class="order_pengembangan_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
        <td <?= $Page->penerima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_penerima" class="order_pengembangan_penerima">
<span<?= $Page->penerima->viewAttributes() ?>>
<?= $Page->penerima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createat->Visible) { // createat ?>
        <td <?= $Page->createat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_createat" class="order_pengembangan_createat">
<span<?= $Page->createat->viewAttributes() ?>>
<?= $Page->createat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createby->Visible) { // createby ?>
        <td <?= $Page->createby->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_createby" class="order_pengembangan_createby">
<span<?= $Page->createby->viewAttributes() ?>>
<?= $Page->createby->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statusdokumen->Visible) { // statusdokumen ?>
        <td <?= $Page->statusdokumen->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_statusdokumen" class="order_pengembangan_statusdokumen">
<span<?= $Page->statusdokumen->viewAttributes() ?>>
<?= $Page->statusdokumen->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->update_at->Visible) { // update_at ?>
        <td <?= $Page->update_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_update_at" class="order_pengembangan_update_at">
<span<?= $Page->update_at->viewAttributes() ?>>
<?= $Page->update_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status_data->Visible) { // status_data ?>
        <td <?= $Page->status_data->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_status_data" class="order_pengembangan_status_data">
<span<?= $Page->status_data->viewAttributes() ?>>
<?= $Page->status_data->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->harga_rnd->Visible) { // harga_rnd ?>
        <td <?= $Page->harga_rnd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_harga_rnd" class="order_pengembangan_harga_rnd">
<span<?= $Page->harga_rnd->viewAttributes() ?>>
<?= $Page->harga_rnd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <td <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aplikasi_sediaan" class="order_pengembangan_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_isi->Visible) { // hu_hrg_isi ?>
        <td <?= $Page->hu_hrg_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_isi" class="order_pengembangan_hu_hrg_isi">
<span<?= $Page->hu_hrg_isi->viewAttributes() ?>>
<?= $Page->hu_hrg_isi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_isi_pro->Visible) { // hu_hrg_isi_pro ?>
        <td <?= $Page->hu_hrg_isi_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_isi_pro" class="order_pengembangan_hu_hrg_isi_pro">
<span<?= $Page->hu_hrg_isi_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_isi_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer->Visible) { // hu_hrg_kms_primer ?>
        <td <?= $Page->hu_hrg_kms_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_primer" class="order_pengembangan_hu_hrg_kms_primer">
<span<?= $Page->hu_hrg_kms_primer->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_primer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer_pro->Visible) { // hu_hrg_kms_primer_pro ?>
        <td <?= $Page->hu_hrg_kms_primer_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_primer_pro" class="order_pengembangan_hu_hrg_kms_primer_pro">
<span<?= $Page->hu_hrg_kms_primer_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_primer_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder->Visible) { // hu_hrg_kms_sekunder ?>
        <td <?= $Page->hu_hrg_kms_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_sekunder" class="order_pengembangan_hu_hrg_kms_sekunder">
<span<?= $Page->hu_hrg_kms_sekunder->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_sekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder_pro->Visible) { // hu_hrg_kms_sekunder_pro ?>
        <td <?= $Page->hu_hrg_kms_sekunder_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_sekunder_pro" class="order_pengembangan_hu_hrg_kms_sekunder_pro">
<span<?= $Page->hu_hrg_kms_sekunder_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_sekunder_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_label->Visible) { // hu_hrg_label ?>
        <td <?= $Page->hu_hrg_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_label" class="order_pengembangan_hu_hrg_label">
<span<?= $Page->hu_hrg_label->viewAttributes() ?>>
<?= $Page->hu_hrg_label->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_label_pro->Visible) { // hu_hrg_label_pro ?>
        <td <?= $Page->hu_hrg_label_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_label_pro" class="order_pengembangan_hu_hrg_label_pro">
<span<?= $Page->hu_hrg_label_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_label_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_total->Visible) { // hu_hrg_total ?>
        <td <?= $Page->hu_hrg_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_total" class="order_pengembangan_hu_hrg_total">
<span<?= $Page->hu_hrg_total->viewAttributes() ?>>
<?= $Page->hu_hrg_total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hu_hrg_total_pro->Visible) { // hu_hrg_total_pro ?>
        <td <?= $Page->hu_hrg_total_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_total_pro" class="order_pengembangan_hu_hrg_total_pro">
<span<?= $Page->hu_hrg_total_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_total_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_isi->Visible) { // hl_hrg_isi ?>
        <td <?= $Page->hl_hrg_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_isi" class="order_pengembangan_hl_hrg_isi">
<span<?= $Page->hl_hrg_isi->viewAttributes() ?>>
<?= $Page->hl_hrg_isi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_isi_pro->Visible) { // hl_hrg_isi_pro ?>
        <td <?= $Page->hl_hrg_isi_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_isi_pro" class="order_pengembangan_hl_hrg_isi_pro">
<span<?= $Page->hl_hrg_isi_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_isi_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer->Visible) { // hl_hrg_kms_primer ?>
        <td <?= $Page->hl_hrg_kms_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_primer" class="order_pengembangan_hl_hrg_kms_primer">
<span<?= $Page->hl_hrg_kms_primer->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_primer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer_pro->Visible) { // hl_hrg_kms_primer_pro ?>
        <td <?= $Page->hl_hrg_kms_primer_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_primer_pro" class="order_pengembangan_hl_hrg_kms_primer_pro">
<span<?= $Page->hl_hrg_kms_primer_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_primer_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder->Visible) { // hl_hrg_kms_sekunder ?>
        <td <?= $Page->hl_hrg_kms_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_sekunder" class="order_pengembangan_hl_hrg_kms_sekunder">
<span<?= $Page->hl_hrg_kms_sekunder->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_sekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder_pro->Visible) { // hl_hrg_kms_sekunder_pro ?>
        <td <?= $Page->hl_hrg_kms_sekunder_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_sekunder_pro" class="order_pengembangan_hl_hrg_kms_sekunder_pro">
<span<?= $Page->hl_hrg_kms_sekunder_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_sekunder_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_label->Visible) { // hl_hrg_label ?>
        <td <?= $Page->hl_hrg_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_label" class="order_pengembangan_hl_hrg_label">
<span<?= $Page->hl_hrg_label->viewAttributes() ?>>
<?= $Page->hl_hrg_label->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_label_pro->Visible) { // hl_hrg_label_pro ?>
        <td <?= $Page->hl_hrg_label_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_label_pro" class="order_pengembangan_hl_hrg_label_pro">
<span<?= $Page->hl_hrg_label_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_label_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_total->Visible) { // hl_hrg_total ?>
        <td <?= $Page->hl_hrg_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_total" class="order_pengembangan_hl_hrg_total">
<span<?= $Page->hl_hrg_total->viewAttributes() ?>>
<?= $Page->hl_hrg_total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hl_hrg_total_pro->Visible) { // hl_hrg_total_pro ?>
        <td <?= $Page->hl_hrg_total_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_total_pro" class="order_pengembangan_hl_hrg_total_pro">
<span<?= $Page->hl_hrg_total_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_total_pro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bs_bahan_aktif_tick->Visible) { // bs_bahan_aktif_tick ?>
        <td <?= $Page->bs_bahan_aktif_tick->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bs_bahan_aktif_tick" class="order_pengembangan_bs_bahan_aktif_tick">
<span<?= $Page->bs_bahan_aktif_tick->viewAttributes() ?>>
<?= $Page->bs_bahan_aktif_tick->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aju_tgl->Visible) { // aju_tgl ?>
        <td <?= $Page->aju_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aju_tgl" class="order_pengembangan_aju_tgl">
<span<?= $Page->aju_tgl->viewAttributes() ?>>
<?= $Page->aju_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aju_oleh->Visible) { // aju_oleh ?>
        <td <?= $Page->aju_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aju_oleh" class="order_pengembangan_aju_oleh">
<span<?= $Page->aju_oleh->viewAttributes() ?>>
<?= $Page->aju_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->proses_tgl->Visible) { // proses_tgl ?>
        <td <?= $Page->proses_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_proses_tgl" class="order_pengembangan_proses_tgl">
<span<?= $Page->proses_tgl->viewAttributes() ?>>
<?= $Page->proses_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->proses_oleh->Visible) { // proses_oleh ?>
        <td <?= $Page->proses_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_proses_oleh" class="order_pengembangan_proses_oleh">
<span<?= $Page->proses_oleh->viewAttributes() ?>>
<?= $Page->proses_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisi_tgl->Visible) { // revisi_tgl ?>
        <td <?= $Page->revisi_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_tgl" class="order_pengembangan_revisi_tgl">
<span<?= $Page->revisi_tgl->viewAttributes() ?>>
<?= $Page->revisi_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisi_oleh->Visible) { // revisi_oleh ?>
        <td <?= $Page->revisi_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_oleh" class="order_pengembangan_revisi_oleh">
<span<?= $Page->revisi_oleh->viewAttributes() ?>>
<?= $Page->revisi_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisi_akun_tgl->Visible) { // revisi_akun_tgl ?>
        <td <?= $Page->revisi_akun_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_akun_tgl" class="order_pengembangan_revisi_akun_tgl">
<span<?= $Page->revisi_akun_tgl->viewAttributes() ?>>
<?= $Page->revisi_akun_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisi_akun_oleh->Visible) { // revisi_akun_oleh ?>
        <td <?= $Page->revisi_akun_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_akun_oleh" class="order_pengembangan_revisi_akun_oleh">
<span<?= $Page->revisi_akun_oleh->viewAttributes() ?>>
<?= $Page->revisi_akun_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisi_rnd_tgl->Visible) { // revisi_rnd_tgl ?>
        <td <?= $Page->revisi_rnd_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_rnd_tgl" class="order_pengembangan_revisi_rnd_tgl">
<span<?= $Page->revisi_rnd_tgl->viewAttributes() ?>>
<?= $Page->revisi_rnd_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->revisi_rnd_oleh->Visible) { // revisi_rnd_oleh ?>
        <td <?= $Page->revisi_rnd_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_rnd_oleh" class="order_pengembangan_revisi_rnd_oleh">
<span<?= $Page->revisi_rnd_oleh->viewAttributes() ?>>
<?= $Page->revisi_rnd_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rnd_tgl->Visible) { // rnd_tgl ?>
        <td <?= $Page->rnd_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_rnd_tgl" class="order_pengembangan_rnd_tgl">
<span<?= $Page->rnd_tgl->viewAttributes() ?>>
<?= $Page->rnd_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rnd_oleh->Visible) { // rnd_oleh ?>
        <td <?= $Page->rnd_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_rnd_oleh" class="order_pengembangan_rnd_oleh">
<span<?= $Page->rnd_oleh->viewAttributes() ?>>
<?= $Page->rnd_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ap_tgl->Visible) { // ap_tgl ?>
        <td <?= $Page->ap_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ap_tgl" class="order_pengembangan_ap_tgl">
<span<?= $Page->ap_tgl->viewAttributes() ?>>
<?= $Page->ap_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ap_oleh->Visible) { // ap_oleh ?>
        <td <?= $Page->ap_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ap_oleh" class="order_pengembangan_ap_oleh">
<span<?= $Page->ap_oleh->viewAttributes() ?>>
<?= $Page->ap_oleh->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->batal_tgl->Visible) { // batal_tgl ?>
        <td <?= $Page->batal_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_batal_tgl" class="order_pengembangan_batal_tgl">
<span<?= $Page->batal_tgl->viewAttributes() ?>>
<?= $Page->batal_tgl->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->batal_oleh->Visible) { // batal_oleh ?>
        <td <?= $Page->batal_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_batal_oleh" class="order_pengembangan_batal_oleh">
<span<?= $Page->batal_oleh->viewAttributes() ?>>
<?= $Page->batal_oleh->getViewValue() ?></span>
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
