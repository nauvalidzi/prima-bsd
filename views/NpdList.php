<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpdlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnpdlist = currentForm = new ew.Form("fnpdlist", "list");
    fnpdlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fnpdlist");
});
var fnpdlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnpdlistsrch = currentSearchForm = new ew.Form("fnpdlistsrch");

    // Dynamic selection lists

    // Filters
    fnpdlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnpdlistsrch");
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
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fnpdlistsrch" id="fnpdlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnpdlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="npd">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd">
<form name="fnpdlist" id="fnpdlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
<div id="gmp_npd" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_npdlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_npd_status" class="npd_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Page->idpegawai->headerCellClass() ?>"><div id="elh_npd_idpegawai" class="npd_idpegawai"><?= $Page->renderSort($Page->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Page->idcustomer->headerCellClass() ?>"><div id="elh_npd_idcustomer" class="npd_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <th data-name="kodeorder" class="<?= $Page->kodeorder->headerCellClass() ?>"><div id="elh_npd_kodeorder" class="npd_kodeorder"><?= $Page->renderSort($Page->kodeorder) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>"><div id="elh_npd_nama" class="npd_nama"><?= $Page->renderSort($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
        <th data-name="tanggal_order" class="<?= $Page->tanggal_order->headerCellClass() ?>"><div id="elh_npd_tanggal_order" class="npd_tanggal_order"><?= $Page->renderSort($Page->tanggal_order) ?></div></th>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
        <th data-name="target_selesai" class="<?= $Page->target_selesai->headerCellClass() ?>"><div id="elh_npd_target_selesai" class="npd_target_selesai"><?= $Page->renderSort($Page->target_selesai) ?></div></th>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <th data-name="kategori" class="<?= $Page->kategori->headerCellClass() ?>"><div id="elh_npd_kategori" class="npd_kategori"><?= $Page->renderSort($Page->kategori) ?></div></th>
<?php } ?>
<?php if ($Page->fungsi_produk->Visible) { // fungsi_produk ?>
        <th data-name="fungsi_produk" class="<?= $Page->fungsi_produk->headerCellClass() ?>"><div id="elh_npd_fungsi_produk" class="npd_fungsi_produk"><?= $Page->renderSort($Page->fungsi_produk) ?></div></th>
<?php } ?>
<?php if ($Page->kualitasbarang->Visible) { // kualitasbarang ?>
        <th data-name="kualitasbarang" class="<?= $Page->kualitasbarang->headerCellClass() ?>"><div id="elh_npd_kualitasbarang" class="npd_kualitasbarang"><?= $Page->renderSort($Page->kualitasbarang) ?></div></th>
<?php } ?>
<?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
        <th data-name="bahan_campaign" class="<?= $Page->bahan_campaign->headerCellClass() ?>"><div id="elh_npd_bahan_campaign" class="npd_bahan_campaign"><?= $Page->renderSort($Page->bahan_campaign) ?></div></th>
<?php } ?>
<?php if ($Page->ukuran_sediaan->Visible) { // ukuran_sediaan ?>
        <th data-name="ukuran_sediaan" class="<?= $Page->ukuran_sediaan->headerCellClass() ?>"><div id="elh_npd_ukuran_sediaan" class="npd_ukuran_sediaan"><?= $Page->renderSort($Page->ukuran_sediaan) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_npd", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <td data-name="kodeorder" <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
        <td data-name="tanggal_order" <?= $Page->tanggal_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_tanggal_order">
<span<?= $Page->tanggal_order->viewAttributes() ?>>
<?= $Page->tanggal_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->target_selesai->Visible) { // target_selesai ?>
        <td data-name="target_selesai" <?= $Page->target_selesai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_target_selesai">
<span<?= $Page->target_selesai->viewAttributes() ?>>
<?= $Page->target_selesai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kategori->Visible) { // kategori ?>
        <td data-name="kategori" <?= $Page->kategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fungsi_produk->Visible) { // fungsi_produk ?>
        <td data-name="fungsi_produk" <?= $Page->fungsi_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_fungsi_produk">
<span<?= $Page->fungsi_produk->viewAttributes() ?>>
<?= $Page->fungsi_produk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kualitasbarang->Visible) { // kualitasbarang ?>
        <td data-name="kualitasbarang" <?= $Page->kualitasbarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kualitasbarang">
<span<?= $Page->kualitasbarang->viewAttributes() ?>>
<?= $Page->kualitasbarang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
        <td data-name="bahan_campaign" <?= $Page->bahan_campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_bahan_campaign">
<span<?= $Page->bahan_campaign->viewAttributes() ?>>
<?= $Page->bahan_campaign->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ukuran_sediaan->Visible) { // ukuran_sediaan ?>
        <td data-name="ukuran_sediaan" <?= $Page->ukuran_sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_ukuran_sediaan">
<span<?= $Page->ukuran_sediaan->viewAttributes() ?>>
<?= $Page->ukuran_sediaan->getViewValue() ?></span>
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
    ew.addEventHandlers("npd");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
