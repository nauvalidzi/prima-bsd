<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdTermsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_termslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnpd_termslist = currentForm = new ew.Form("fnpd_termslist", "list");
    fnpd_termslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fnpd_termslist");
});
var fnpd_termslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnpd_termslistsrch = currentSearchForm = new ew.Form("fnpd_termslistsrch");

    // Dynamic selection lists

    // Filters
    fnpd_termslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnpd_termslistsrch");
});
</script>
<style>
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "npd") {
    if ($Page->MasterRecordExists) {
        include_once "views/NpdMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fnpd_termslistsrch" id="fnpd_termslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnpd_termslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="npd_terms">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_terms">
<form name="fnpd_termslist" id="fnpd_termslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
<?php if ($Page->getCurrentMasterTable() == "npd" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_npd_terms" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_npd_termslist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_npd_terms_id" class="npd_terms_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Page->idnpd->headerCellClass() ?>"><div id="elh_npd_terms_idnpd" class="npd_terms_idnpd"><?= $Page->renderSort($Page->idnpd) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_npd_terms_status" class="npd_terms_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <th data-name="tglsubmit" class="<?= $Page->tglsubmit->headerCellClass() ?>"><div id="elh_npd_terms_tglsubmit" class="npd_terms_tglsubmit"><?= $Page->renderSort($Page->tglsubmit) ?></div></th>
<?php } ?>
<?php if ($Page->sifat_order->Visible) { // sifat_order ?>
        <th data-name="sifat_order" class="<?= $Page->sifat_order->headerCellClass() ?>"><div id="elh_npd_terms_sifat_order" class="npd_terms_sifat_order"><?= $Page->renderSort($Page->sifat_order) ?></div></th>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
        <th data-name="ukuran_utama" class="<?= $Page->ukuran_utama->headerCellClass() ?>"><div id="elh_npd_terms_ukuran_utama" class="npd_terms_ukuran_utama"><?= $Page->renderSort($Page->ukuran_utama) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <th data-name="utama_harga_isi" class="<?= $Page->utama_harga_isi->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_isi" class="npd_terms_utama_harga_isi"><?= $Page->renderSort($Page->utama_harga_isi) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <th data-name="utama_harga_isi_order" class="<?= $Page->utama_harga_isi_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_isi_order" class="npd_terms_utama_harga_isi_order"><?= $Page->renderSort($Page->utama_harga_isi_order) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <th data-name="utama_harga_primer" class="<?= $Page->utama_harga_primer->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_primer" class="npd_terms_utama_harga_primer"><?= $Page->renderSort($Page->utama_harga_primer) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <th data-name="utama_harga_primer_order" class="<?= $Page->utama_harga_primer_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_primer_order" class="npd_terms_utama_harga_primer_order"><?= $Page->renderSort($Page->utama_harga_primer_order) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <th data-name="utama_harga_sekunder" class="<?= $Page->utama_harga_sekunder->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_sekunder" class="npd_terms_utama_harga_sekunder"><?= $Page->renderSort($Page->utama_harga_sekunder) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <th data-name="utama_harga_sekunder_order" class="<?= $Page->utama_harga_sekunder_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_sekunder_order" class="npd_terms_utama_harga_sekunder_order"><?= $Page->renderSort($Page->utama_harga_sekunder_order) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
        <th data-name="utama_harga_label" class="<?= $Page->utama_harga_label->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_label" class="npd_terms_utama_harga_label"><?= $Page->renderSort($Page->utama_harga_label) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <th data-name="utama_harga_label_order" class="<?= $Page->utama_harga_label_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_label_order" class="npd_terms_utama_harga_label_order"><?= $Page->renderSort($Page->utama_harga_label_order) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
        <th data-name="utama_harga_total" class="<?= $Page->utama_harga_total->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_total" class="npd_terms_utama_harga_total"><?= $Page->renderSort($Page->utama_harga_total) ?></div></th>
<?php } ?>
<?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <th data-name="utama_harga_total_order" class="<?= $Page->utama_harga_total_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_total_order" class="npd_terms_utama_harga_total_order"><?= $Page->renderSort($Page->utama_harga_total_order) ?></div></th>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
        <th data-name="ukuran_lain" class="<?= $Page->ukuran_lain->headerCellClass() ?>"><div id="elh_npd_terms_ukuran_lain" class="npd_terms_ukuran_lain"><?= $Page->renderSort($Page->ukuran_lain) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <th data-name="lain_harga_isi" class="<?= $Page->lain_harga_isi->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_isi" class="npd_terms_lain_harga_isi"><?= $Page->renderSort($Page->lain_harga_isi) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <th data-name="lain_harga_isi_order" class="<?= $Page->lain_harga_isi_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_isi_order" class="npd_terms_lain_harga_isi_order"><?= $Page->renderSort($Page->lain_harga_isi_order) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <th data-name="lain_harga_primer" class="<?= $Page->lain_harga_primer->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_primer" class="npd_terms_lain_harga_primer"><?= $Page->renderSort($Page->lain_harga_primer) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <th data-name="lain_harga_primer_order" class="<?= $Page->lain_harga_primer_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_primer_order" class="npd_terms_lain_harga_primer_order"><?= $Page->renderSort($Page->lain_harga_primer_order) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <th data-name="lain_harga_sekunder" class="<?= $Page->lain_harga_sekunder->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_sekunder" class="npd_terms_lain_harga_sekunder"><?= $Page->renderSort($Page->lain_harga_sekunder) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <th data-name="lain_harga_sekunder_order" class="<?= $Page->lain_harga_sekunder_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_sekunder_order" class="npd_terms_lain_harga_sekunder_order"><?= $Page->renderSort($Page->lain_harga_sekunder_order) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
        <th data-name="lain_harga_label" class="<?= $Page->lain_harga_label->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_label" class="npd_terms_lain_harga_label"><?= $Page->renderSort($Page->lain_harga_label) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <th data-name="lain_harga_label_order" class="<?= $Page->lain_harga_label_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_label_order" class="npd_terms_lain_harga_label_order"><?= $Page->renderSort($Page->lain_harga_label_order) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
        <th data-name="lain_harga_total" class="<?= $Page->lain_harga_total->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_total" class="npd_terms_lain_harga_total"><?= $Page->renderSort($Page->lain_harga_total) ?></div></th>
<?php } ?>
<?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <th data-name="lain_harga_total_order" class="<?= $Page->lain_harga_total_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_total_order" class="npd_terms_lain_harga_total_order"><?= $Page->renderSort($Page->lain_harga_total_order) ?></div></th>
<?php } ?>
<?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <th data-name="isi_bahan_aktif" class="<?= $Page->isi_bahan_aktif->headerCellClass() ?>"><div id="elh_npd_terms_isi_bahan_aktif" class="npd_terms_isi_bahan_aktif"><?= $Page->renderSort($Page->isi_bahan_aktif) ?></div></th>
<?php } ?>
<?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <th data-name="isi_bahan_lain" class="<?= $Page->isi_bahan_lain->headerCellClass() ?>"><div id="elh_npd_terms_isi_bahan_lain" class="npd_terms_isi_bahan_lain"><?= $Page->renderSort($Page->isi_bahan_lain) ?></div></th>
<?php } ?>
<?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
        <th data-name="isi_parfum" class="<?= $Page->isi_parfum->headerCellClass() ?>"><div id="elh_npd_terms_isi_parfum" class="npd_terms_isi_parfum"><?= $Page->renderSort($Page->isi_parfum) ?></div></th>
<?php } ?>
<?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
        <th data-name="isi_estetika" class="<?= $Page->isi_estetika->headerCellClass() ?>"><div id="elh_npd_terms_isi_estetika" class="npd_terms_isi_estetika"><?= $Page->renderSort($Page->isi_estetika) ?></div></th>
<?php } ?>
<?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <th data-name="kemasan_wadah" class="<?= $Page->kemasan_wadah->headerCellClass() ?>"><div id="elh_npd_terms_kemasan_wadah" class="npd_terms_kemasan_wadah"><?= $Page->renderSort($Page->kemasan_wadah) ?></div></th>
<?php } ?>
<?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <th data-name="kemasan_tutup" class="<?= $Page->kemasan_tutup->headerCellClass() ?>"><div id="elh_npd_terms_kemasan_tutup" class="npd_terms_kemasan_tutup"><?= $Page->renderSort($Page->kemasan_tutup) ?></div></th>
<?php } ?>
<?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <th data-name="kemasan_sekunder" class="<?= $Page->kemasan_sekunder->headerCellClass() ?>"><div id="elh_npd_terms_kemasan_sekunder" class="npd_terms_kemasan_sekunder"><?= $Page->renderSort($Page->kemasan_sekunder) ?></div></th>
<?php } ?>
<?php if ($Page->label_desain->Visible) { // label_desain ?>
        <th data-name="label_desain" class="<?= $Page->label_desain->headerCellClass() ?>"><div id="elh_npd_terms_label_desain" class="npd_terms_label_desain"><?= $Page->renderSort($Page->label_desain) ?></div></th>
<?php } ?>
<?php if ($Page->label_cetak->Visible) { // label_cetak ?>
        <th data-name="label_cetak" class="<?= $Page->label_cetak->headerCellClass() ?>"><div id="elh_npd_terms_label_cetak" class="npd_terms_label_cetak"><?= $Page->renderSort($Page->label_cetak) ?></div></th>
<?php } ?>
<?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
        <th data-name="label_lainlain" class="<?= $Page->label_lainlain->headerCellClass() ?>"><div id="elh_npd_terms_label_lainlain" class="npd_terms_label_lainlain"><?= $Page->renderSort($Page->label_lainlain) ?></div></th>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
        <th data-name="delivery_pickup" class="<?= $Page->delivery_pickup->headerCellClass() ?>"><div id="elh_npd_terms_delivery_pickup" class="npd_terms_delivery_pickup"><?= $Page->renderSort($Page->delivery_pickup) ?></div></th>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <th data-name="delivery_singlepoint" class="<?= $Page->delivery_singlepoint->headerCellClass() ?>"><div id="elh_npd_terms_delivery_singlepoint" class="npd_terms_delivery_singlepoint"><?= $Page->renderSort($Page->delivery_singlepoint) ?></div></th>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <th data-name="delivery_multipoint" class="<?= $Page->delivery_multipoint->headerCellClass() ?>"><div id="elh_npd_terms_delivery_multipoint" class="npd_terms_delivery_multipoint"><?= $Page->renderSort($Page->delivery_multipoint) ?></div></th>
<?php } ?>
<?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <th data-name="delivery_jumlahpoint" class="<?= $Page->delivery_jumlahpoint->headerCellClass() ?>"><div id="elh_npd_terms_delivery_jumlahpoint" class="npd_terms_delivery_jumlahpoint"><?= $Page->renderSort($Page->delivery_jumlahpoint) ?></div></th>
<?php } ?>
<?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
        <th data-name="delivery_termslain" class="<?= $Page->delivery_termslain->headerCellClass() ?>"><div id="elh_npd_terms_delivery_termslain" class="npd_terms_delivery_termslain"><?= $Page->renderSort($Page->delivery_termslain) ?></div></th>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <th data-name="dibuatdi" class="<?= $Page->dibuatdi->headerCellClass() ?>"><div id="elh_npd_terms_dibuatdi" class="npd_terms_dibuatdi"><?= $Page->renderSort($Page->dibuatdi) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_npd_terms_created_at" class="npd_terms_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_npd_terms", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_npd_terms_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sifat_order->Visible) { // sifat_order ?>
        <td data-name="sifat_order" <?= $Page->sifat_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_sifat_order">
<span<?= $Page->sifat_order->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifat_order_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->sifat_order->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->sifat_order->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifat_order_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
        <td data-name="ukuran_utama" <?= $Page->ukuran_utama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuran_utama">
<span<?= $Page->ukuran_utama->viewAttributes() ?>>
<?= $Page->ukuran_utama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <td data-name="utama_harga_isi" <?= $Page->utama_harga_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_isi">
<span<?= $Page->utama_harga_isi->viewAttributes() ?>>
<?= $Page->utama_harga_isi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <td data-name="utama_harga_isi_order" <?= $Page->utama_harga_isi_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_isi_order">
<span<?= $Page->utama_harga_isi_order->viewAttributes() ?>>
<?= $Page->utama_harga_isi_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <td data-name="utama_harga_primer" <?= $Page->utama_harga_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_primer">
<span<?= $Page->utama_harga_primer->viewAttributes() ?>>
<?= $Page->utama_harga_primer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <td data-name="utama_harga_primer_order" <?= $Page->utama_harga_primer_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_primer_order">
<span<?= $Page->utama_harga_primer_order->viewAttributes() ?>>
<?= $Page->utama_harga_primer_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <td data-name="utama_harga_sekunder" <?= $Page->utama_harga_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_sekunder">
<span<?= $Page->utama_harga_sekunder->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <td data-name="utama_harga_sekunder_order" <?= $Page->utama_harga_sekunder_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_sekunder_order">
<span<?= $Page->utama_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->utama_harga_sekunder_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
        <td data-name="utama_harga_label" <?= $Page->utama_harga_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_label">
<span<?= $Page->utama_harga_label->viewAttributes() ?>>
<?= $Page->utama_harga_label->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <td data-name="utama_harga_label_order" <?= $Page->utama_harga_label_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_label_order">
<span<?= $Page->utama_harga_label_order->viewAttributes() ?>>
<?= $Page->utama_harga_label_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
        <td data-name="utama_harga_total" <?= $Page->utama_harga_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_total">
<span<?= $Page->utama_harga_total->viewAttributes() ?>>
<?= $Page->utama_harga_total->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <td data-name="utama_harga_total_order" <?= $Page->utama_harga_total_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_utama_harga_total_order">
<span<?= $Page->utama_harga_total_order->viewAttributes() ?>>
<?= $Page->utama_harga_total_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
        <td data-name="ukuran_lain" <?= $Page->ukuran_lain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_ukuran_lain">
<span<?= $Page->ukuran_lain->viewAttributes() ?>>
<?= $Page->ukuran_lain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <td data-name="lain_harga_isi" <?= $Page->lain_harga_isi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_isi">
<span<?= $Page->lain_harga_isi->viewAttributes() ?>>
<?= $Page->lain_harga_isi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <td data-name="lain_harga_isi_order" <?= $Page->lain_harga_isi_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_isi_order">
<span<?= $Page->lain_harga_isi_order->viewAttributes() ?>>
<?= $Page->lain_harga_isi_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <td data-name="lain_harga_primer" <?= $Page->lain_harga_primer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_primer">
<span<?= $Page->lain_harga_primer->viewAttributes() ?>>
<?= $Page->lain_harga_primer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <td data-name="lain_harga_primer_order" <?= $Page->lain_harga_primer_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_primer_order">
<span<?= $Page->lain_harga_primer_order->viewAttributes() ?>>
<?= $Page->lain_harga_primer_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <td data-name="lain_harga_sekunder" <?= $Page->lain_harga_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_sekunder">
<span<?= $Page->lain_harga_sekunder->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <td data-name="lain_harga_sekunder_order" <?= $Page->lain_harga_sekunder_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_sekunder_order">
<span<?= $Page->lain_harga_sekunder_order->viewAttributes() ?>>
<?= $Page->lain_harga_sekunder_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
        <td data-name="lain_harga_label" <?= $Page->lain_harga_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_label">
<span<?= $Page->lain_harga_label->viewAttributes() ?>>
<?= $Page->lain_harga_label->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <td data-name="lain_harga_label_order" <?= $Page->lain_harga_label_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_label_order">
<span<?= $Page->lain_harga_label_order->viewAttributes() ?>>
<?= $Page->lain_harga_label_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
        <td data-name="lain_harga_total" <?= $Page->lain_harga_total->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_total">
<span<?= $Page->lain_harga_total->viewAttributes() ?>>
<?= $Page->lain_harga_total->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <td data-name="lain_harga_total_order" <?= $Page->lain_harga_total_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_lain_harga_total_order">
<span<?= $Page->lain_harga_total_order->viewAttributes() ?>>
<?= $Page->lain_harga_total_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <td data-name="isi_bahan_aktif" <?= $Page->isi_bahan_aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_bahan_aktif">
<span<?= $Page->isi_bahan_aktif->viewAttributes() ?>>
<?= $Page->isi_bahan_aktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <td data-name="isi_bahan_lain" <?= $Page->isi_bahan_lain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_bahan_lain">
<span<?= $Page->isi_bahan_lain->viewAttributes() ?>>
<?= $Page->isi_bahan_lain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
        <td data-name="isi_parfum" <?= $Page->isi_parfum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_parfum">
<span<?= $Page->isi_parfum->viewAttributes() ?>>
<?= $Page->isi_parfum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
        <td data-name="isi_estetika" <?= $Page->isi_estetika->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_isi_estetika">
<span<?= $Page->isi_estetika->viewAttributes() ?>>
<?= $Page->isi_estetika->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <td data-name="kemasan_wadah" <?= $Page->kemasan_wadah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasan_wadah">
<span<?= $Page->kemasan_wadah->viewAttributes() ?>>
<?= $Page->kemasan_wadah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <td data-name="kemasan_tutup" <?= $Page->kemasan_tutup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasan_tutup">
<span<?= $Page->kemasan_tutup->viewAttributes() ?>>
<?= $Page->kemasan_tutup->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <td data-name="kemasan_sekunder" <?= $Page->kemasan_sekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_kemasan_sekunder">
<span<?= $Page->kemasan_sekunder->viewAttributes() ?>>
<?= $Page->kemasan_sekunder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->label_desain->Visible) { // label_desain ?>
        <td data-name="label_desain" <?= $Page->label_desain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_label_desain">
<span<?= $Page->label_desain->viewAttributes() ?>>
<?= $Page->label_desain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->label_cetak->Visible) { // label_cetak ?>
        <td data-name="label_cetak" <?= $Page->label_cetak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_label_cetak">
<span<?= $Page->label_cetak->viewAttributes() ?>>
<?= $Page->label_cetak->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
        <td data-name="label_lainlain" <?= $Page->label_lainlain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_label_lainlain">
<span<?= $Page->label_lainlain->viewAttributes() ?>>
<?= $Page->label_lainlain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
        <td data-name="delivery_pickup" <?= $Page->delivery_pickup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_pickup">
<span<?= $Page->delivery_pickup->viewAttributes() ?>>
<?= $Page->delivery_pickup->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <td data-name="delivery_singlepoint" <?= $Page->delivery_singlepoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_singlepoint">
<span<?= $Page->delivery_singlepoint->viewAttributes() ?>>
<?= $Page->delivery_singlepoint->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <td data-name="delivery_multipoint" <?= $Page->delivery_multipoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_multipoint">
<span<?= $Page->delivery_multipoint->viewAttributes() ?>>
<?= $Page->delivery_multipoint->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <td data-name="delivery_jumlahpoint" <?= $Page->delivery_jumlahpoint->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_jumlahpoint">
<span<?= $Page->delivery_jumlahpoint->viewAttributes() ?>>
<?= $Page->delivery_jumlahpoint->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
        <td data-name="delivery_termslain" <?= $Page->delivery_termslain->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_delivery_termslain">
<span<?= $Page->delivery_termslain->viewAttributes() ?>>
<?= $Page->delivery_termslain->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
        <td data-name="dibuatdi" <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_dibuatdi">
<span<?= $Page->dibuatdi->viewAttributes() ?>>
<?= $Page->dibuatdi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_terms_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
    ew.addEventHandlers("npd_terms");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
