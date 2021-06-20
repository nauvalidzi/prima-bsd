<?php

namespace PHPMaker2021\distributor;

// Page object
$OrderPengembanganList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forder_pengembanganlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    forder_pengembanganlist = currentForm = new ew.Form("forder_pengembanganlist", "list");
    forder_pengembanganlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("forder_pengembanganlist");
});
var forder_pengembanganlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    forder_pengembanganlistsrch = currentSearchForm = new ew.Form("forder_pengembanganlistsrch");

    // Dynamic selection lists

    // Filters
    forder_pengembanganlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("forder_pengembanganlistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="forder_pengembanganlistsrch" id="forder_pengembanganlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="forder_pengembanganlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="order_pengembangan">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> order_pengembangan">
<form name="forder_pengembanganlist" id="forder_pengembanganlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_pengembangan">
<div id="gmp_order_pengembangan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_order_pengembanganlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_order_pengembangan_id" class="order_pengembangan_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->cpo_jenis->Visible) { // cpo_jenis ?>
        <th data-name="cpo_jenis" class="<?= $Page->cpo_jenis->headerCellClass() ?>"><div id="elh_order_pengembangan_cpo_jenis" class="order_pengembangan_cpo_jenis"><?= $Page->renderSort($Page->cpo_jenis) ?></div></th>
<?php } ?>
<?php if ($Page->ordernum->Visible) { // ordernum ?>
        <th data-name="ordernum" class="<?= $Page->ordernum->headerCellClass() ?>"><div id="elh_order_pengembangan_ordernum" class="order_pengembangan_ordernum"><?= $Page->renderSort($Page->ordernum) ?></div></th>
<?php } ?>
<?php if ($Page->order_kode->Visible) { // order_kode ?>
        <th data-name="order_kode" class="<?= $Page->order_kode->headerCellClass() ?>"><div id="elh_order_pengembangan_order_kode" class="order_pengembangan_order_kode"><?= $Page->renderSort($Page->order_kode) ?></div></th>
<?php } ?>
<?php if ($Page->orderterimatgl->Visible) { // orderterimatgl ?>
        <th data-name="orderterimatgl" class="<?= $Page->orderterimatgl->headerCellClass() ?>"><div id="elh_order_pengembangan_orderterimatgl" class="order_pengembangan_orderterimatgl"><?= $Page->renderSort($Page->orderterimatgl) ?></div></th>
<?php } ?>
<?php if ($Page->produk_fungsi->Visible) { // produk_fungsi ?>
        <th data-name="produk_fungsi" class="<?= $Page->produk_fungsi->headerCellClass() ?>"><div id="elh_order_pengembangan_produk_fungsi" class="order_pengembangan_produk_fungsi"><?= $Page->renderSort($Page->produk_fungsi) ?></div></th>
<?php } ?>
<?php if ($Page->produk_kualitas->Visible) { // produk_kualitas ?>
        <th data-name="produk_kualitas" class="<?= $Page->produk_kualitas->headerCellClass() ?>"><div id="elh_order_pengembangan_produk_kualitas" class="order_pengembangan_produk_kualitas"><?= $Page->renderSort($Page->produk_kualitas) ?></div></th>
<?php } ?>
<?php if ($Page->produk_campaign->Visible) { // produk_campaign ?>
        <th data-name="produk_campaign" class="<?= $Page->produk_campaign->headerCellClass() ?>"><div id="elh_order_pengembangan_produk_campaign" class="order_pengembangan_produk_campaign"><?= $Page->renderSort($Page->produk_campaign) ?></div></th>
<?php } ?>
<?php if ($Page->kemasan_satuan->Visible) { // kemasan_satuan ?>
        <th data-name="kemasan_satuan" class="<?= $Page->kemasan_satuan->headerCellClass() ?>"><div id="elh_order_pengembangan_kemasan_satuan" class="order_pengembangan_kemasan_satuan"><?= $Page->renderSort($Page->kemasan_satuan) ?></div></th>
<?php } ?>
<?php if ($Page->ordertgl->Visible) { // ordertgl ?>
        <th data-name="ordertgl" class="<?= $Page->ordertgl->headerCellClass() ?>"><div id="elh_order_pengembangan_ordertgl" class="order_pengembangan_ordertgl"><?= $Page->renderSort($Page->ordertgl) ?></div></th>
<?php } ?>
<?php if ($Page->custcode->Visible) { // custcode ?>
        <th data-name="custcode" class="<?= $Page->custcode->headerCellClass() ?>"><div id="elh_order_pengembangan_custcode" class="order_pengembangan_custcode"><?= $Page->renderSort($Page->custcode) ?></div></th>
<?php } ?>
<?php if ($Page->perushnama->Visible) { // perushnama ?>
        <th data-name="perushnama" class="<?= $Page->perushnama->headerCellClass() ?>"><div id="elh_order_pengembangan_perushnama" class="order_pengembangan_perushnama"><?= $Page->renderSort($Page->perushnama) ?></div></th>
<?php } ?>
<?php if ($Page->perushalamat->Visible) { // perushalamat ?>
        <th data-name="perushalamat" class="<?= $Page->perushalamat->headerCellClass() ?>"><div id="elh_order_pengembangan_perushalamat" class="order_pengembangan_perushalamat"><?= $Page->renderSort($Page->perushalamat) ?></div></th>
<?php } ?>
<?php if ($Page->perushcp->Visible) { // perushcp ?>
        <th data-name="perushcp" class="<?= $Page->perushcp->headerCellClass() ?>"><div id="elh_order_pengembangan_perushcp" class="order_pengembangan_perushcp"><?= $Page->renderSort($Page->perushcp) ?></div></th>
<?php } ?>
<?php if ($Page->perushjabatan->Visible) { // perushjabatan ?>
        <th data-name="perushjabatan" class="<?= $Page->perushjabatan->headerCellClass() ?>"><div id="elh_order_pengembangan_perushjabatan" class="order_pengembangan_perushjabatan"><?= $Page->renderSort($Page->perushjabatan) ?></div></th>
<?php } ?>
<?php if ($Page->perushphone->Visible) { // perushphone ?>
        <th data-name="perushphone" class="<?= $Page->perushphone->headerCellClass() ?>"><div id="elh_order_pengembangan_perushphone" class="order_pengembangan_perushphone"><?= $Page->renderSort($Page->perushphone) ?></div></th>
<?php } ?>
<?php if ($Page->perushmobile->Visible) { // perushmobile ?>
        <th data-name="perushmobile" class="<?= $Page->perushmobile->headerCellClass() ?>"><div id="elh_order_pengembangan_perushmobile" class="order_pengembangan_perushmobile"><?= $Page->renderSort($Page->perushmobile) ?></div></th>
<?php } ?>
<?php if ($Page->bencmark->Visible) { // bencmark ?>
        <th data-name="bencmark" class="<?= $Page->bencmark->headerCellClass() ?>"><div id="elh_order_pengembangan_bencmark" class="order_pengembangan_bencmark"><?= $Page->renderSort($Page->bencmark) ?></div></th>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
        <th data-name="kategoriproduk" class="<?= $Page->kategoriproduk->headerCellClass() ?>"><div id="elh_order_pengembangan_kategoriproduk" class="order_pengembangan_kategoriproduk"><?= $Page->renderSort($Page->kategoriproduk) ?></div></th>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
        <th data-name="jenisproduk" class="<?= $Page->jenisproduk->headerCellClass() ?>"><div id="elh_order_pengembangan_jenisproduk" class="order_pengembangan_jenisproduk"><?= $Page->renderSort($Page->jenisproduk) ?></div></th>
<?php } ?>
<?php if ($Page->bentuksediaan->Visible) { // bentuksediaan ?>
        <th data-name="bentuksediaan" class="<?= $Page->bentuksediaan->headerCellClass() ?>"><div id="elh_order_pengembangan_bentuksediaan" class="order_pengembangan_bentuksediaan"><?= $Page->renderSort($Page->bentuksediaan) ?></div></th>
<?php } ?>
<?php if ($Page->sediaan_ukuran->Visible) { // sediaan_ukuran ?>
        <th data-name="sediaan_ukuran" class="<?= $Page->sediaan_ukuran->headerCellClass() ?>"><div id="elh_order_pengembangan_sediaan_ukuran" class="order_pengembangan_sediaan_ukuran"><?= $Page->renderSort($Page->sediaan_ukuran) ?></div></th>
<?php } ?>
<?php if ($Page->sediaan_ukuran_satuan->Visible) { // sediaan_ukuran_satuan ?>
        <th data-name="sediaan_ukuran_satuan" class="<?= $Page->sediaan_ukuran_satuan->headerCellClass() ?>"><div id="elh_order_pengembangan_sediaan_ukuran_satuan" class="order_pengembangan_sediaan_ukuran_satuan"><?= $Page->renderSort($Page->sediaan_ukuran_satuan) ?></div></th>
<?php } ?>
<?php if ($Page->produk_viskositas->Visible) { // produk_viskositas ?>
        <th data-name="produk_viskositas" class="<?= $Page->produk_viskositas->headerCellClass() ?>"><div id="elh_order_pengembangan_produk_viskositas" class="order_pengembangan_produk_viskositas"><?= $Page->renderSort($Page->produk_viskositas) ?></div></th>
<?php } ?>
<?php if ($Page->konsepproduk->Visible) { // konsepproduk ?>
        <th data-name="konsepproduk" class="<?= $Page->konsepproduk->headerCellClass() ?>"><div id="elh_order_pengembangan_konsepproduk" class="order_pengembangan_konsepproduk"><?= $Page->renderSort($Page->konsepproduk) ?></div></th>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <th data-name="fragrance" class="<?= $Page->fragrance->headerCellClass() ?>"><div id="elh_order_pengembangan_fragrance" class="order_pengembangan_fragrance"><?= $Page->renderSort($Page->fragrance) ?></div></th>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <th data-name="aroma" class="<?= $Page->aroma->headerCellClass() ?>"><div id="elh_order_pengembangan_aroma" class="order_pengembangan_aroma"><?= $Page->renderSort($Page->aroma) ?></div></th>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <th data-name="bahanaktif" class="<?= $Page->bahanaktif->headerCellClass() ?>"><div id="elh_order_pengembangan_bahanaktif" class="order_pengembangan_bahanaktif"><?= $Page->renderSort($Page->bahanaktif) ?></div></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th data-name="warna" class="<?= $Page->warna->headerCellClass() ?>"><div id="elh_order_pengembangan_warna" class="order_pengembangan_warna"><?= $Page->renderSort($Page->warna) ?></div></th>
<?php } ?>
<?php if ($Page->produk_warna_jenis->Visible) { // produk_warna_jenis ?>
        <th data-name="produk_warna_jenis" class="<?= $Page->produk_warna_jenis->headerCellClass() ?>"><div id="elh_order_pengembangan_produk_warna_jenis" class="order_pengembangan_produk_warna_jenis"><?= $Page->renderSort($Page->produk_warna_jenis) ?></div></th>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <th data-name="aksesoris" class="<?= $Page->aksesoris->headerCellClass() ?>"><div id="elh_order_pengembangan_aksesoris" class="order_pengembangan_aksesoris"><?= $Page->renderSort($Page->aksesoris) ?></div></th>
<?php } ?>
<?php if ($Page->statusproduk->Visible) { // statusproduk ?>
        <th data-name="statusproduk" class="<?= $Page->statusproduk->headerCellClass() ?>"><div id="elh_order_pengembangan_statusproduk" class="order_pengembangan_statusproduk"><?= $Page->renderSort($Page->statusproduk) ?></div></th>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
        <th data-name="parfum" class="<?= $Page->parfum->headerCellClass() ?>"><div id="elh_order_pengembangan_parfum" class="order_pengembangan_parfum"><?= $Page->renderSort($Page->parfum) ?></div></th>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
        <th data-name="catatan" class="<?= $Page->catatan->headerCellClass() ?>"><div id="elh_order_pengembangan_catatan" class="order_pengembangan_catatan"><?= $Page->renderSort($Page->catatan) ?></div></th>
<?php } ?>
<?php if ($Page->rencanakemasan->Visible) { // rencanakemasan ?>
        <th data-name="rencanakemasan" class="<?= $Page->rencanakemasan->headerCellClass() ?>"><div id="elh_order_pengembangan_rencanakemasan" class="order_pengembangan_rencanakemasan"><?= $Page->renderSort($Page->rencanakemasan) ?></div></th>
<?php } ?>
<?php if ($Page->ekspetasiharga->Visible) { // ekspetasiharga ?>
        <th data-name="ekspetasiharga" class="<?= $Page->ekspetasiharga->headerCellClass() ?>"><div id="elh_order_pengembangan_ekspetasiharga" class="order_pengembangan_ekspetasiharga"><?= $Page->renderSort($Page->ekspetasiharga) ?></div></th>
<?php } ?>
<?php if ($Page->kemasan->Visible) { // kemasan ?>
        <th data-name="kemasan" class="<?= $Page->kemasan->headerCellClass() ?>"><div id="elh_order_pengembangan_kemasan" class="order_pengembangan_kemasan"><?= $Page->renderSort($Page->kemasan) ?></div></th>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
        <th data-name="volume" class="<?= $Page->volume->headerCellClass() ?>"><div id="elh_order_pengembangan_volume" class="order_pengembangan_volume"><?= $Page->renderSort($Page->volume) ?></div></th>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
        <th data-name="jenistutup" class="<?= $Page->jenistutup->headerCellClass() ?>"><div id="elh_order_pengembangan_jenistutup" class="order_pengembangan_jenistutup"><?= $Page->renderSort($Page->jenistutup) ?></div></th>
<?php } ?>
<?php if ($Page->infopackaging->Visible) { // infopackaging ?>
        <th data-name="infopackaging" class="<?= $Page->infopackaging->headerCellClass() ?>"><div id="elh_order_pengembangan_infopackaging" class="order_pengembangan_infopackaging"><?= $Page->renderSort($Page->infopackaging) ?></div></th>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <th data-name="ukuran" class="<?= $Page->ukuran->headerCellClass() ?>"><div id="elh_order_pengembangan_ukuran" class="order_pengembangan_ukuran"><?= $Page->renderSort($Page->ukuran) ?></div></th>
<?php } ?>
<?php if ($Page->desainprodukkemasan->Visible) { // desainprodukkemasan ?>
        <th data-name="desainprodukkemasan" class="<?= $Page->desainprodukkemasan->headerCellClass() ?>"><div id="elh_order_pengembangan_desainprodukkemasan" class="order_pengembangan_desainprodukkemasan"><?= $Page->renderSort($Page->desainprodukkemasan) ?></div></th>
<?php } ?>
<?php if ($Page->desaindiinginkan->Visible) { // desaindiinginkan ?>
        <th data-name="desaindiinginkan" class="<?= $Page->desaindiinginkan->headerCellClass() ?>"><div id="elh_order_pengembangan_desaindiinginkan" class="order_pengembangan_desaindiinginkan"><?= $Page->renderSort($Page->desaindiinginkan) ?></div></th>
<?php } ?>
<?php if ($Page->mereknotifikasi->Visible) { // mereknotifikasi ?>
        <th data-name="mereknotifikasi" class="<?= $Page->mereknotifikasi->headerCellClass() ?>"><div id="elh_order_pengembangan_mereknotifikasi" class="order_pengembangan_mereknotifikasi"><?= $Page->renderSort($Page->mereknotifikasi) ?></div></th>
<?php } ?>
<?php if ($Page->kategoristatus->Visible) { // kategoristatus ?>
        <th data-name="kategoristatus" class="<?= $Page->kategoristatus->headerCellClass() ?>"><div id="elh_order_pengembangan_kategoristatus" class="order_pengembangan_kategoristatus"><?= $Page->renderSort($Page->kategoristatus) ?></div></th>
<?php } ?>
<?php if ($Page->kemasan_ukuran_satuan->Visible) { // kemasan_ukuran_satuan ?>
        <th data-name="kemasan_ukuran_satuan" class="<?= $Page->kemasan_ukuran_satuan->headerCellClass() ?>"><div id="elh_order_pengembangan_kemasan_ukuran_satuan" class="order_pengembangan_kemasan_ukuran_satuan"><?= $Page->renderSort($Page->kemasan_ukuran_satuan) ?></div></th>
<?php } ?>
<?php if ($Page->infolabel->Visible) { // infolabel ?>
        <th data-name="infolabel" class="<?= $Page->infolabel->headerCellClass() ?>"><div id="elh_order_pengembangan_infolabel" class="order_pengembangan_infolabel"><?= $Page->renderSort($Page->infolabel) ?></div></th>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
        <th data-name="labelkualitas" class="<?= $Page->labelkualitas->headerCellClass() ?>"><div id="elh_order_pengembangan_labelkualitas" class="order_pengembangan_labelkualitas"><?= $Page->renderSort($Page->labelkualitas) ?></div></th>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
        <th data-name="labelposisi" class="<?= $Page->labelposisi->headerCellClass() ?>"><div id="elh_order_pengembangan_labelposisi" class="order_pengembangan_labelposisi"><?= $Page->renderSort($Page->labelposisi) ?></div></th>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <th data-name="dibuatdi" class="<?= $Page->dibuatdi->headerCellClass() ?>"><div id="elh_order_pengembangan_dibuatdi" class="order_pengembangan_dibuatdi"><?= $Page->renderSort($Page->dibuatdi) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <th data-name="tanggal" class="<?= $Page->tanggal->headerCellClass() ?>"><div id="elh_order_pengembangan_tanggal" class="order_pengembangan_tanggal"><?= $Page->renderSort($Page->tanggal) ?></div></th>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
        <th data-name="penerima" class="<?= $Page->penerima->headerCellClass() ?>"><div id="elh_order_pengembangan_penerima" class="order_pengembangan_penerima"><?= $Page->renderSort($Page->penerima) ?></div></th>
<?php } ?>
<?php if ($Page->createat->Visible) { // createat ?>
        <th data-name="createat" class="<?= $Page->createat->headerCellClass() ?>"><div id="elh_order_pengembangan_createat" class="order_pengembangan_createat"><?= $Page->renderSort($Page->createat) ?></div></th>
<?php } ?>
<?php if ($Page->createby->Visible) { // createby ?>
        <th data-name="createby" class="<?= $Page->createby->headerCellClass() ?>"><div id="elh_order_pengembangan_createby" class="order_pengembangan_createby"><?= $Page->renderSort($Page->createby) ?></div></th>
<?php } ?>
<?php if ($Page->statusdokumen->Visible) { // statusdokumen ?>
        <th data-name="statusdokumen" class="<?= $Page->statusdokumen->headerCellClass() ?>"><div id="elh_order_pengembangan_statusdokumen" class="order_pengembangan_statusdokumen"><?= $Page->renderSort($Page->statusdokumen) ?></div></th>
<?php } ?>
<?php if ($Page->update_at->Visible) { // update_at ?>
        <th data-name="update_at" class="<?= $Page->update_at->headerCellClass() ?>"><div id="elh_order_pengembangan_update_at" class="order_pengembangan_update_at"><?= $Page->renderSort($Page->update_at) ?></div></th>
<?php } ?>
<?php if ($Page->status_data->Visible) { // status_data ?>
        <th data-name="status_data" class="<?= $Page->status_data->headerCellClass() ?>"><div id="elh_order_pengembangan_status_data" class="order_pengembangan_status_data"><?= $Page->renderSort($Page->status_data) ?></div></th>
<?php } ?>
<?php if ($Page->harga_rnd->Visible) { // harga_rnd ?>
        <th data-name="harga_rnd" class="<?= $Page->harga_rnd->headerCellClass() ?>"><div id="elh_order_pengembangan_harga_rnd" class="order_pengembangan_harga_rnd"><?= $Page->renderSort($Page->harga_rnd) ?></div></th>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <th data-name="aplikasi_sediaan" class="<?= $Page->aplikasi_sediaan->headerCellClass() ?>"><div id="elh_order_pengembangan_aplikasi_sediaan" class="order_pengembangan_aplikasi_sediaan"><?= $Page->renderSort($Page->aplikasi_sediaan) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_isi->Visible) { // hu_hrg_isi ?>
        <th data-name="hu_hrg_isi" class="<?= $Page->hu_hrg_isi->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_isi" class="order_pengembangan_hu_hrg_isi"><?= $Page->renderSort($Page->hu_hrg_isi) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_isi_pro->Visible) { // hu_hrg_isi_pro ?>
        <th data-name="hu_hrg_isi_pro" class="<?= $Page->hu_hrg_isi_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_isi_pro" class="order_pengembangan_hu_hrg_isi_pro"><?= $Page->renderSort($Page->hu_hrg_isi_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer->Visible) { // hu_hrg_kms_primer ?>
        <th data-name="hu_hrg_kms_primer" class="<?= $Page->hu_hrg_kms_primer->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_kms_primer" class="order_pengembangan_hu_hrg_kms_primer"><?= $Page->renderSort($Page->hu_hrg_kms_primer) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer_pro->Visible) { // hu_hrg_kms_primer_pro ?>
        <th data-name="hu_hrg_kms_primer_pro" class="<?= $Page->hu_hrg_kms_primer_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_kms_primer_pro" class="order_pengembangan_hu_hrg_kms_primer_pro"><?= $Page->renderSort($Page->hu_hrg_kms_primer_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder->Visible) { // hu_hrg_kms_sekunder ?>
        <th data-name="hu_hrg_kms_sekunder" class="<?= $Page->hu_hrg_kms_sekunder->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_kms_sekunder" class="order_pengembangan_hu_hrg_kms_sekunder"><?= $Page->renderSort($Page->hu_hrg_kms_sekunder) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder_pro->Visible) { // hu_hrg_kms_sekunder_pro ?>
        <th data-name="hu_hrg_kms_sekunder_pro" class="<?= $Page->hu_hrg_kms_sekunder_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_kms_sekunder_pro" class="order_pengembangan_hu_hrg_kms_sekunder_pro"><?= $Page->renderSort($Page->hu_hrg_kms_sekunder_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_label->Visible) { // hu_hrg_label ?>
        <th data-name="hu_hrg_label" class="<?= $Page->hu_hrg_label->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_label" class="order_pengembangan_hu_hrg_label"><?= $Page->renderSort($Page->hu_hrg_label) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_label_pro->Visible) { // hu_hrg_label_pro ?>
        <th data-name="hu_hrg_label_pro" class="<?= $Page->hu_hrg_label_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_label_pro" class="order_pengembangan_hu_hrg_label_pro"><?= $Page->renderSort($Page->hu_hrg_label_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_total->Visible) { // hu_hrg_total ?>
        <th data-name="hu_hrg_total" class="<?= $Page->hu_hrg_total->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_total" class="order_pengembangan_hu_hrg_total"><?= $Page->renderSort($Page->hu_hrg_total) ?></div></th>
<?php } ?>
<?php if ($Page->hu_hrg_total_pro->Visible) { // hu_hrg_total_pro ?>
        <th data-name="hu_hrg_total_pro" class="<?= $Page->hu_hrg_total_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hu_hrg_total_pro" class="order_pengembangan_hu_hrg_total_pro"><?= $Page->renderSort($Page->hu_hrg_total_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_isi->Visible) { // hl_hrg_isi ?>
        <th data-name="hl_hrg_isi" class="<?= $Page->hl_hrg_isi->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_isi" class="order_pengembangan_hl_hrg_isi"><?= $Page->renderSort($Page->hl_hrg_isi) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_isi_pro->Visible) { // hl_hrg_isi_pro ?>
        <th data-name="hl_hrg_isi_pro" class="<?= $Page->hl_hrg_isi_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_isi_pro" class="order_pengembangan_hl_hrg_isi_pro"><?= $Page->renderSort($Page->hl_hrg_isi_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer->Visible) { // hl_hrg_kms_primer ?>
        <th data-name="hl_hrg_kms_primer" class="<?= $Page->hl_hrg_kms_primer->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_kms_primer" class="order_pengembangan_hl_hrg_kms_primer"><?= $Page->renderSort($Page->hl_hrg_kms_primer) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer_pro->Visible) { // hl_hrg_kms_primer_pro ?>
        <th data-name="hl_hrg_kms_primer_pro" class="<?= $Page->hl_hrg_kms_primer_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_kms_primer_pro" class="order_pengembangan_hl_hrg_kms_primer_pro"><?= $Page->renderSort($Page->hl_hrg_kms_primer_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder->Visible) { // hl_hrg_kms_sekunder ?>
        <th data-name="hl_hrg_kms_sekunder" class="<?= $Page->hl_hrg_kms_sekunder->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_kms_sekunder" class="order_pengembangan_hl_hrg_kms_sekunder"><?= $Page->renderSort($Page->hl_hrg_kms_sekunder) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder_pro->Visible) { // hl_hrg_kms_sekunder_pro ?>
        <th data-name="hl_hrg_kms_sekunder_pro" class="<?= $Page->hl_hrg_kms_sekunder_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_kms_sekunder_pro" class="order_pengembangan_hl_hrg_kms_sekunder_pro"><?= $Page->renderSort($Page->hl_hrg_kms_sekunder_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_label->Visible) { // hl_hrg_label ?>
        <th data-name="hl_hrg_label" class="<?= $Page->hl_hrg_label->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_label" class="order_pengembangan_hl_hrg_label"><?= $Page->renderSort($Page->hl_hrg_label) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_label_pro->Visible) { // hl_hrg_label_pro ?>
        <th data-name="hl_hrg_label_pro" class="<?= $Page->hl_hrg_label_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_label_pro" class="order_pengembangan_hl_hrg_label_pro"><?= $Page->renderSort($Page->hl_hrg_label_pro) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_total->Visible) { // hl_hrg_total ?>
        <th data-name="hl_hrg_total" class="<?= $Page->hl_hrg_total->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_total" class="order_pengembangan_hl_hrg_total"><?= $Page->renderSort($Page->hl_hrg_total) ?></div></th>
<?php } ?>
<?php if ($Page->hl_hrg_total_pro->Visible) { // hl_hrg_total_pro ?>
        <th data-name="hl_hrg_total_pro" class="<?= $Page->hl_hrg_total_pro->headerCellClass() ?>"><div id="elh_order_pengembangan_hl_hrg_total_pro" class="order_pengembangan_hl_hrg_total_pro"><?= $Page->renderSort($Page->hl_hrg_total_pro) ?></div></th>
<?php } ?>
<?php if ($Page->bs_bahan_aktif_tick->Visible) { // bs_bahan_aktif_tick ?>
        <th data-name="bs_bahan_aktif_tick" class="<?= $Page->bs_bahan_aktif_tick->headerCellClass() ?>"><div id="elh_order_pengembangan_bs_bahan_aktif_tick" class="order_pengembangan_bs_bahan_aktif_tick"><?= $Page->renderSort($Page->bs_bahan_aktif_tick) ?></div></th>
<?php } ?>
<?php if ($Page->aju_tgl->Visible) { // aju_tgl ?>
        <th data-name="aju_tgl" class="<?= $Page->aju_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_aju_tgl" class="order_pengembangan_aju_tgl"><?= $Page->renderSort($Page->aju_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->aju_oleh->Visible) { // aju_oleh ?>
        <th data-name="aju_oleh" class="<?= $Page->aju_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_aju_oleh" class="order_pengembangan_aju_oleh"><?= $Page->renderSort($Page->aju_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->proses_tgl->Visible) { // proses_tgl ?>
        <th data-name="proses_tgl" class="<?= $Page->proses_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_proses_tgl" class="order_pengembangan_proses_tgl"><?= $Page->renderSort($Page->proses_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->proses_oleh->Visible) { // proses_oleh ?>
        <th data-name="proses_oleh" class="<?= $Page->proses_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_proses_oleh" class="order_pengembangan_proses_oleh"><?= $Page->renderSort($Page->proses_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->revisi_tgl->Visible) { // revisi_tgl ?>
        <th data-name="revisi_tgl" class="<?= $Page->revisi_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_revisi_tgl" class="order_pengembangan_revisi_tgl"><?= $Page->renderSort($Page->revisi_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->revisi_oleh->Visible) { // revisi_oleh ?>
        <th data-name="revisi_oleh" class="<?= $Page->revisi_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_revisi_oleh" class="order_pengembangan_revisi_oleh"><?= $Page->renderSort($Page->revisi_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->revisi_akun_tgl->Visible) { // revisi_akun_tgl ?>
        <th data-name="revisi_akun_tgl" class="<?= $Page->revisi_akun_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_revisi_akun_tgl" class="order_pengembangan_revisi_akun_tgl"><?= $Page->renderSort($Page->revisi_akun_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->revisi_akun_oleh->Visible) { // revisi_akun_oleh ?>
        <th data-name="revisi_akun_oleh" class="<?= $Page->revisi_akun_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_revisi_akun_oleh" class="order_pengembangan_revisi_akun_oleh"><?= $Page->renderSort($Page->revisi_akun_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->revisi_rnd_tgl->Visible) { // revisi_rnd_tgl ?>
        <th data-name="revisi_rnd_tgl" class="<?= $Page->revisi_rnd_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_revisi_rnd_tgl" class="order_pengembangan_revisi_rnd_tgl"><?= $Page->renderSort($Page->revisi_rnd_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->revisi_rnd_oleh->Visible) { // revisi_rnd_oleh ?>
        <th data-name="revisi_rnd_oleh" class="<?= $Page->revisi_rnd_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_revisi_rnd_oleh" class="order_pengembangan_revisi_rnd_oleh"><?= $Page->renderSort($Page->revisi_rnd_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->rnd_tgl->Visible) { // rnd_tgl ?>
        <th data-name="rnd_tgl" class="<?= $Page->rnd_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_rnd_tgl" class="order_pengembangan_rnd_tgl"><?= $Page->renderSort($Page->rnd_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->rnd_oleh->Visible) { // rnd_oleh ?>
        <th data-name="rnd_oleh" class="<?= $Page->rnd_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_rnd_oleh" class="order_pengembangan_rnd_oleh"><?= $Page->renderSort($Page->rnd_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->ap_tgl->Visible) { // ap_tgl ?>
        <th data-name="ap_tgl" class="<?= $Page->ap_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_ap_tgl" class="order_pengembangan_ap_tgl"><?= $Page->renderSort($Page->ap_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->ap_oleh->Visible) { // ap_oleh ?>
        <th data-name="ap_oleh" class="<?= $Page->ap_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_ap_oleh" class="order_pengembangan_ap_oleh"><?= $Page->renderSort($Page->ap_oleh) ?></div></th>
<?php } ?>
<?php if ($Page->batal_tgl->Visible) { // batal_tgl ?>
        <th data-name="batal_tgl" class="<?= $Page->batal_tgl->headerCellClass() ?>"><div id="elh_order_pengembangan_batal_tgl" class="order_pengembangan_batal_tgl"><?= $Page->renderSort($Page->batal_tgl) ?></div></th>
<?php } ?>
<?php if ($Page->batal_oleh->Visible) { // batal_oleh ?>
        <th data-name="batal_oleh" class="<?= $Page->batal_oleh->headerCellClass() ?>"><div id="elh_order_pengembangan_batal_oleh" class="order_pengembangan_batal_oleh"><?= $Page->renderSort($Page->batal_oleh) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_order_pengembangan", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cpo_jenis->Visible) { // cpo_jenis ?>
        <td data-name="cpo_jenis" <?= $Page->cpo_jenis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_cpo_jenis">
<span<?= $Page->cpo_jenis->viewAttributes() ?>>
<?= $Page->cpo_jenis->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ordernum->Visible) { // ordernum ?>
        <td data-name="ordernum" <?= $Page->ordernum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ordernum">
<span<?= $Page->ordernum->viewAttributes() ?>>
<?= $Page->ordernum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->order_kode->Visible) { // order_kode ?>
        <td data-name="order_kode" <?= $Page->order_kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_order_kode">
<span<?= $Page->order_kode->viewAttributes() ?>>
<?= $Page->order_kode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->orderterimatgl->Visible) { // orderterimatgl ?>
        <td data-name="orderterimatgl" <?= $Page->orderterimatgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_orderterimatgl">
<span<?= $Page->orderterimatgl->viewAttributes() ?>>
<?= $Page->orderterimatgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->produk_fungsi->Visible) { // produk_fungsi ?>
        <td data-name="produk_fungsi" <?= $Page->produk_fungsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_fungsi">
<span<?= $Page->produk_fungsi->viewAttributes() ?>>
<?= $Page->produk_fungsi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->produk_kualitas->Visible) { // produk_kualitas ?>
        <td data-name="produk_kualitas" <?= $Page->produk_kualitas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_kualitas">
<span<?= $Page->produk_kualitas->viewAttributes() ?>>
<?= $Page->produk_kualitas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->produk_campaign->Visible) { // produk_campaign ?>
        <td data-name="produk_campaign" <?= $Page->produk_campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_campaign">
<span<?= $Page->produk_campaign->viewAttributes() ?>>
<?= $Page->produk_campaign->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasan_satuan->Visible) { // kemasan_satuan ?>
        <td data-name="kemasan_satuan" <?= $Page->kemasan_satuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kemasan_satuan">
<span<?= $Page->kemasan_satuan->viewAttributes() ?>>
<?= $Page->kemasan_satuan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ordertgl->Visible) { // ordertgl ?>
        <td data-name="ordertgl" <?= $Page->ordertgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ordertgl">
<span<?= $Page->ordertgl->viewAttributes() ?>>
<?= $Page->ordertgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->custcode->Visible) { // custcode ?>
        <td data-name="custcode" <?= $Page->custcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_custcode">
<span<?= $Page->custcode->viewAttributes() ?>>
<?= $Page->custcode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->perushnama->Visible) { // perushnama ?>
        <td data-name="perushnama" <?= $Page->perushnama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushnama">
<span<?= $Page->perushnama->viewAttributes() ?>>
<?= $Page->perushnama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->perushalamat->Visible) { // perushalamat ?>
        <td data-name="perushalamat" <?= $Page->perushalamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushalamat">
<span<?= $Page->perushalamat->viewAttributes() ?>>
<?= $Page->perushalamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->perushcp->Visible) { // perushcp ?>
        <td data-name="perushcp" <?= $Page->perushcp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushcp">
<span<?= $Page->perushcp->viewAttributes() ?>>
<?= $Page->perushcp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->perushjabatan->Visible) { // perushjabatan ?>
        <td data-name="perushjabatan" <?= $Page->perushjabatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushjabatan">
<span<?= $Page->perushjabatan->viewAttributes() ?>>
<?= $Page->perushjabatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->perushphone->Visible) { // perushphone ?>
        <td data-name="perushphone" <?= $Page->perushphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushphone">
<span<?= $Page->perushphone->viewAttributes() ?>>
<?= $Page->perushphone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->perushmobile->Visible) { // perushmobile ?>
        <td data-name="perushmobile" <?= $Page->perushmobile->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_perushmobile">
<span<?= $Page->perushmobile->viewAttributes() ?>>
<?= $Page->perushmobile->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bencmark->Visible) { // bencmark ?>
        <td data-name="bencmark" <?= $Page->bencmark->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bencmark">
<span<?= $Page->bencmark->viewAttributes() ?>>
<?= $Page->bencmark->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
        <td data-name="kategoriproduk" <?= $Page->kategoriproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kategoriproduk">
<span<?= $Page->kategoriproduk->viewAttributes() ?>>
<?= $Page->kategoriproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
        <td data-name="jenisproduk" <?= $Page->jenisproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_jenisproduk">
<span<?= $Page->jenisproduk->viewAttributes() ?>>
<?= $Page->jenisproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bentuksediaan->Visible) { // bentuksediaan ?>
        <td data-name="bentuksediaan" <?= $Page->bentuksediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bentuksediaan">
<span<?= $Page->bentuksediaan->viewAttributes() ?>>
<?= $Page->bentuksediaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sediaan_ukuran->Visible) { // sediaan_ukuran ?>
        <td data-name="sediaan_ukuran" <?= $Page->sediaan_ukuran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_sediaan_ukuran">
<span<?= $Page->sediaan_ukuran->viewAttributes() ?>>
<?= $Page->sediaan_ukuran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sediaan_ukuran_satuan->Visible) { // sediaan_ukuran_satuan ?>
        <td data-name="sediaan_ukuran_satuan" <?= $Page->sediaan_ukuran_satuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_sediaan_ukuran_satuan">
<span<?= $Page->sediaan_ukuran_satuan->viewAttributes() ?>>
<?= $Page->sediaan_ukuran_satuan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->produk_viskositas->Visible) { // produk_viskositas ?>
        <td data-name="produk_viskositas" <?= $Page->produk_viskositas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_viskositas">
<span<?= $Page->produk_viskositas->viewAttributes() ?>>
<?= $Page->produk_viskositas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->konsepproduk->Visible) { // konsepproduk ?>
        <td data-name="konsepproduk" <?= $Page->konsepproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_konsepproduk">
<span<?= $Page->konsepproduk->viewAttributes() ?>>
<?= $Page->konsepproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fragrance->Visible) { // fragrance ?>
        <td data-name="fragrance" <?= $Page->fragrance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aroma->Visible) { // aroma ?>
        <td data-name="aroma" <?= $Page->aroma->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <td data-name="bahanaktif" <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->warna->Visible) { // warna ?>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->produk_warna_jenis->Visible) { // produk_warna_jenis ?>
        <td data-name="produk_warna_jenis" <?= $Page->produk_warna_jenis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_produk_warna_jenis">
<span<?= $Page->produk_warna_jenis->viewAttributes() ?>>
<?= $Page->produk_warna_jenis->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <td data-name="aksesoris" <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->statusproduk->Visible) { // statusproduk ?>
        <td data-name="statusproduk" <?= $Page->statusproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_statusproduk">
<span<?= $Page->statusproduk->viewAttributes() ?>>
<?= $Page->statusproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parfum->Visible) { // parfum ?>
        <td data-name="parfum" <?= $Page->parfum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_parfum">
<span<?= $Page->parfum->viewAttributes() ?>>
<?= $Page->parfum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->catatan->Visible) { // catatan ?>
        <td data-name="catatan" <?= $Page->catatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_catatan">
<span<?= $Page->catatan->viewAttributes() ?>>
<?= $Page->catatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rencanakemasan->Visible) { // rencanakemasan ?>
        <td data-name="rencanakemasan" <?= $Page->rencanakemasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_rencanakemasan">
<span<?= $Page->rencanakemasan->viewAttributes() ?>>
<?= $Page->rencanakemasan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ekspetasiharga->Visible) { // ekspetasiharga ?>
        <td data-name="ekspetasiharga" <?= $Page->ekspetasiharga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ekspetasiharga">
<span<?= $Page->ekspetasiharga->viewAttributes() ?>>
<?= $Page->ekspetasiharga->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasan->Visible) { // kemasan ?>
        <td data-name="kemasan" <?= $Page->kemasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kemasan">
<span<?= $Page->kemasan->viewAttributes() ?>>
<?= $Page->kemasan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->volume->Visible) { // volume ?>
        <td data-name="volume" <?= $Page->volume->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_volume">
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jenistutup->Visible) { // jenistutup ?>
        <td data-name="jenistutup" <?= $Page->jenistutup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_jenistutup">
<span<?= $Page->jenistutup->viewAttributes() ?>>
<?= $Page->jenistutup->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->infopackaging->Visible) { // infopackaging ?>
        <td data-name="infopackaging" <?= $Page->infopackaging->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_infopackaging">
<span<?= $Page->infopackaging->viewAttributes() ?>>
<?= $Page->infopackaging->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran" <?= $Page->ukuran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->desainprodukkemasan->Visible) { // desainprodukkemasan ?>
        <td data-name="desainprodukkemasan" <?= $Page->desainprodukkemasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_desainprodukkemasan">
<span<?= $Page->desainprodukkemasan->viewAttributes() ?>>
<?= $Page->desainprodukkemasan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->desaindiinginkan->Visible) { // desaindiinginkan ?>
        <td data-name="desaindiinginkan" <?= $Page->desaindiinginkan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_desaindiinginkan">
<span<?= $Page->desaindiinginkan->viewAttributes() ?>>
<?= $Page->desaindiinginkan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mereknotifikasi->Visible) { // mereknotifikasi ?>
        <td data-name="mereknotifikasi" <?= $Page->mereknotifikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_mereknotifikasi">
<span<?= $Page->mereknotifikasi->viewAttributes() ?>>
<?= $Page->mereknotifikasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kategoristatus->Visible) { // kategoristatus ?>
        <td data-name="kategoristatus" <?= $Page->kategoristatus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kategoristatus">
<span<?= $Page->kategoristatus->viewAttributes() ?>>
<?= $Page->kategoristatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasan_ukuran_satuan->Visible) { // kemasan_ukuran_satuan ?>
        <td data-name="kemasan_ukuran_satuan" <?= $Page->kemasan_ukuran_satuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_kemasan_ukuran_satuan">
<span<?= $Page->kemasan_ukuran_satuan->viewAttributes() ?>>
<?= $Page->kemasan_ukuran_satuan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->infolabel->Visible) { // infolabel ?>
        <td data-name="infolabel" <?= $Page->infolabel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_infolabel">
<span<?= $Page->infolabel->viewAttributes() ?>>
<?= $Page->infolabel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
        <td data-name="labelkualitas" <?= $Page->labelkualitas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_labelkualitas">
<span<?= $Page->labelkualitas->viewAttributes() ?>>
<?= $Page->labelkualitas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->labelposisi->Visible) { // labelposisi ?>
        <td data-name="labelposisi" <?= $Page->labelposisi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_labelposisi">
<span<?= $Page->labelposisi->viewAttributes() ?>>
<?= $Page->labelposisi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <td data-name="dibuatdi" <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal->Visible) { // tanggal ?>
        <td data-name="tanggal" <?= $Page->tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->penerima->Visible) { // penerima ?>
        <td data-name="penerima" <?= $Page->penerima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_penerima">
<span<?= $Page->penerima->viewAttributes() ?>>
<?= $Page->penerima->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createat->Visible) { // createat ?>
        <td data-name="createat" <?= $Page->createat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_createat">
<span<?= $Page->createat->viewAttributes() ?>>
<?= $Page->createat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createby->Visible) { // createby ?>
        <td data-name="createby" <?= $Page->createby->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_createby">
<span<?= $Page->createby->viewAttributes() ?>>
<?= $Page->createby->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->statusdokumen->Visible) { // statusdokumen ?>
        <td data-name="statusdokumen" <?= $Page->statusdokumen->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_statusdokumen">
<span<?= $Page->statusdokumen->viewAttributes() ?>>
<?= $Page->statusdokumen->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->update_at->Visible) { // update_at ?>
        <td data-name="update_at" <?= $Page->update_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_update_at">
<span<?= $Page->update_at->viewAttributes() ?>>
<?= $Page->update_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status_data->Visible) { // status_data ?>
        <td data-name="status_data" <?= $Page->status_data->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_status_data">
<span<?= $Page->status_data->viewAttributes() ?>>
<?= $Page->status_data->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->harga_rnd->Visible) { // harga_rnd ?>
        <td data-name="harga_rnd" <?= $Page->harga_rnd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_harga_rnd">
<span<?= $Page->harga_rnd->viewAttributes() ?>>
<?= $Page->harga_rnd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <td data-name="aplikasi_sediaan" <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_isi->Visible) { // hu_hrg_isi ?>
        <td data-name="hu_hrg_isi" <?= $Page->hu_hrg_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_isi">
<span<?= $Page->hu_hrg_isi->viewAttributes() ?>>
<?= $Page->hu_hrg_isi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_isi_pro->Visible) { // hu_hrg_isi_pro ?>
        <td data-name="hu_hrg_isi_pro" <?= $Page->hu_hrg_isi_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_isi_pro">
<span<?= $Page->hu_hrg_isi_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_isi_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_kms_primer->Visible) { // hu_hrg_kms_primer ?>
        <td data-name="hu_hrg_kms_primer" <?= $Page->hu_hrg_kms_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_primer">
<span<?= $Page->hu_hrg_kms_primer->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_primer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_kms_primer_pro->Visible) { // hu_hrg_kms_primer_pro ?>
        <td data-name="hu_hrg_kms_primer_pro" <?= $Page->hu_hrg_kms_primer_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_primer_pro">
<span<?= $Page->hu_hrg_kms_primer_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_primer_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_kms_sekunder->Visible) { // hu_hrg_kms_sekunder ?>
        <td data-name="hu_hrg_kms_sekunder" <?= $Page->hu_hrg_kms_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_sekunder">
<span<?= $Page->hu_hrg_kms_sekunder->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_sekunder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_kms_sekunder_pro->Visible) { // hu_hrg_kms_sekunder_pro ?>
        <td data-name="hu_hrg_kms_sekunder_pro" <?= $Page->hu_hrg_kms_sekunder_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_kms_sekunder_pro">
<span<?= $Page->hu_hrg_kms_sekunder_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_kms_sekunder_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_label->Visible) { // hu_hrg_label ?>
        <td data-name="hu_hrg_label" <?= $Page->hu_hrg_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_label">
<span<?= $Page->hu_hrg_label->viewAttributes() ?>>
<?= $Page->hu_hrg_label->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_label_pro->Visible) { // hu_hrg_label_pro ?>
        <td data-name="hu_hrg_label_pro" <?= $Page->hu_hrg_label_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_label_pro">
<span<?= $Page->hu_hrg_label_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_label_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_total->Visible) { // hu_hrg_total ?>
        <td data-name="hu_hrg_total" <?= $Page->hu_hrg_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_total">
<span<?= $Page->hu_hrg_total->viewAttributes() ?>>
<?= $Page->hu_hrg_total->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hu_hrg_total_pro->Visible) { // hu_hrg_total_pro ?>
        <td data-name="hu_hrg_total_pro" <?= $Page->hu_hrg_total_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hu_hrg_total_pro">
<span<?= $Page->hu_hrg_total_pro->viewAttributes() ?>>
<?= $Page->hu_hrg_total_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_isi->Visible) { // hl_hrg_isi ?>
        <td data-name="hl_hrg_isi" <?= $Page->hl_hrg_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_isi">
<span<?= $Page->hl_hrg_isi->viewAttributes() ?>>
<?= $Page->hl_hrg_isi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_isi_pro->Visible) { // hl_hrg_isi_pro ?>
        <td data-name="hl_hrg_isi_pro" <?= $Page->hl_hrg_isi_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_isi_pro">
<span<?= $Page->hl_hrg_isi_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_isi_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_kms_primer->Visible) { // hl_hrg_kms_primer ?>
        <td data-name="hl_hrg_kms_primer" <?= $Page->hl_hrg_kms_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_primer">
<span<?= $Page->hl_hrg_kms_primer->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_primer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_kms_primer_pro->Visible) { // hl_hrg_kms_primer_pro ?>
        <td data-name="hl_hrg_kms_primer_pro" <?= $Page->hl_hrg_kms_primer_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_primer_pro">
<span<?= $Page->hl_hrg_kms_primer_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_primer_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_kms_sekunder->Visible) { // hl_hrg_kms_sekunder ?>
        <td data-name="hl_hrg_kms_sekunder" <?= $Page->hl_hrg_kms_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_sekunder">
<span<?= $Page->hl_hrg_kms_sekunder->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_sekunder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_kms_sekunder_pro->Visible) { // hl_hrg_kms_sekunder_pro ?>
        <td data-name="hl_hrg_kms_sekunder_pro" <?= $Page->hl_hrg_kms_sekunder_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_kms_sekunder_pro">
<span<?= $Page->hl_hrg_kms_sekunder_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_kms_sekunder_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_label->Visible) { // hl_hrg_label ?>
        <td data-name="hl_hrg_label" <?= $Page->hl_hrg_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_label">
<span<?= $Page->hl_hrg_label->viewAttributes() ?>>
<?= $Page->hl_hrg_label->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_label_pro->Visible) { // hl_hrg_label_pro ?>
        <td data-name="hl_hrg_label_pro" <?= $Page->hl_hrg_label_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_label_pro">
<span<?= $Page->hl_hrg_label_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_label_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_total->Visible) { // hl_hrg_total ?>
        <td data-name="hl_hrg_total" <?= $Page->hl_hrg_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_total">
<span<?= $Page->hl_hrg_total->viewAttributes() ?>>
<?= $Page->hl_hrg_total->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hl_hrg_total_pro->Visible) { // hl_hrg_total_pro ?>
        <td data-name="hl_hrg_total_pro" <?= $Page->hl_hrg_total_pro->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_hl_hrg_total_pro">
<span<?= $Page->hl_hrg_total_pro->viewAttributes() ?>>
<?= $Page->hl_hrg_total_pro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bs_bahan_aktif_tick->Visible) { // bs_bahan_aktif_tick ?>
        <td data-name="bs_bahan_aktif_tick" <?= $Page->bs_bahan_aktif_tick->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_bs_bahan_aktif_tick">
<span<?= $Page->bs_bahan_aktif_tick->viewAttributes() ?>>
<?= $Page->bs_bahan_aktif_tick->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aju_tgl->Visible) { // aju_tgl ?>
        <td data-name="aju_tgl" <?= $Page->aju_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aju_tgl">
<span<?= $Page->aju_tgl->viewAttributes() ?>>
<?= $Page->aju_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aju_oleh->Visible) { // aju_oleh ?>
        <td data-name="aju_oleh" <?= $Page->aju_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_aju_oleh">
<span<?= $Page->aju_oleh->viewAttributes() ?>>
<?= $Page->aju_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->proses_tgl->Visible) { // proses_tgl ?>
        <td data-name="proses_tgl" <?= $Page->proses_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_proses_tgl">
<span<?= $Page->proses_tgl->viewAttributes() ?>>
<?= $Page->proses_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->proses_oleh->Visible) { // proses_oleh ?>
        <td data-name="proses_oleh" <?= $Page->proses_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_proses_oleh">
<span<?= $Page->proses_oleh->viewAttributes() ?>>
<?= $Page->proses_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisi_tgl->Visible) { // revisi_tgl ?>
        <td data-name="revisi_tgl" <?= $Page->revisi_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_tgl">
<span<?= $Page->revisi_tgl->viewAttributes() ?>>
<?= $Page->revisi_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisi_oleh->Visible) { // revisi_oleh ?>
        <td data-name="revisi_oleh" <?= $Page->revisi_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_oleh">
<span<?= $Page->revisi_oleh->viewAttributes() ?>>
<?= $Page->revisi_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisi_akun_tgl->Visible) { // revisi_akun_tgl ?>
        <td data-name="revisi_akun_tgl" <?= $Page->revisi_akun_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_akun_tgl">
<span<?= $Page->revisi_akun_tgl->viewAttributes() ?>>
<?= $Page->revisi_akun_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisi_akun_oleh->Visible) { // revisi_akun_oleh ?>
        <td data-name="revisi_akun_oleh" <?= $Page->revisi_akun_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_akun_oleh">
<span<?= $Page->revisi_akun_oleh->viewAttributes() ?>>
<?= $Page->revisi_akun_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisi_rnd_tgl->Visible) { // revisi_rnd_tgl ?>
        <td data-name="revisi_rnd_tgl" <?= $Page->revisi_rnd_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_rnd_tgl">
<span<?= $Page->revisi_rnd_tgl->viewAttributes() ?>>
<?= $Page->revisi_rnd_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->revisi_rnd_oleh->Visible) { // revisi_rnd_oleh ?>
        <td data-name="revisi_rnd_oleh" <?= $Page->revisi_rnd_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_revisi_rnd_oleh">
<span<?= $Page->revisi_rnd_oleh->viewAttributes() ?>>
<?= $Page->revisi_rnd_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rnd_tgl->Visible) { // rnd_tgl ?>
        <td data-name="rnd_tgl" <?= $Page->rnd_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_rnd_tgl">
<span<?= $Page->rnd_tgl->viewAttributes() ?>>
<?= $Page->rnd_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rnd_oleh->Visible) { // rnd_oleh ?>
        <td data-name="rnd_oleh" <?= $Page->rnd_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_rnd_oleh">
<span<?= $Page->rnd_oleh->viewAttributes() ?>>
<?= $Page->rnd_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ap_tgl->Visible) { // ap_tgl ?>
        <td data-name="ap_tgl" <?= $Page->ap_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ap_tgl">
<span<?= $Page->ap_tgl->viewAttributes() ?>>
<?= $Page->ap_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ap_oleh->Visible) { // ap_oleh ?>
        <td data-name="ap_oleh" <?= $Page->ap_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_ap_oleh">
<span<?= $Page->ap_oleh->viewAttributes() ?>>
<?= $Page->ap_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->batal_tgl->Visible) { // batal_tgl ?>
        <td data-name="batal_tgl" <?= $Page->batal_tgl->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_batal_tgl">
<span<?= $Page->batal_tgl->viewAttributes() ?>>
<?= $Page->batal_tgl->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->batal_oleh->Visible) { // batal_oleh ?>
        <td data-name="batal_oleh" <?= $Page->batal_oleh->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_order_pengembangan_batal_oleh">
<span<?= $Page->batal_oleh->viewAttributes() ?>>
<?= $Page->batal_oleh->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("order_pengembangan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
