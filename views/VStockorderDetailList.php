<?php

namespace PHPMaker2021\production2;

// Page object
$VStockorderDetailList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_stockorder_detaillist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fv_stockorder_detaillist = currentForm = new ew.Form("fv_stockorder_detaillist", "list");
    fv_stockorder_detaillist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fv_stockorder_detaillist");
});
var fv_stockorder_detaillistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fv_stockorder_detaillistsrch = currentSearchForm = new ew.Form("fv_stockorder_detaillistsrch");

    // Dynamic selection lists

    // Filters
    fv_stockorder_detaillistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fv_stockorder_detaillistsrch");
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
<form name="fv_stockorder_detaillistsrch" id="fv_stockorder_detaillistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fv_stockorder_detaillistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_stockorder_detail">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_stockorder_detail">
<form name="fv_stockorder_detaillist" id="fv_stockorder_detaillist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_stockorder_detail">
<div id="gmp_v_stockorder_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_v_stockorder_detaillist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->idstockorder->Visible) { // idstockorder ?>
        <th data-name="idstockorder" class="<?= $Page->idstockorder->headerCellClass() ?>"><div id="elh_v_stockorder_detail_idstockorder" class="v_stockorder_detail_idstockorder"><?= $Page->renderSort($Page->idstockorder) ?></div></th>
<?php } ?>
<?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <th data-name="idstockorder_detail" class="<?= $Page->idstockorder_detail->headerCellClass() ?>"><div id="elh_v_stockorder_detail_idstockorder_detail" class="v_stockorder_detail_idstockorder_detail"><?= $Page->renderSort($Page->idstockorder_detail) ?></div></th>
<?php } ?>
<?php if ($Page->kode_produk->Visible) { // kode_produk ?>
        <th data-name="kode_produk" class="<?= $Page->kode_produk->headerCellClass() ?>"><div id="elh_v_stockorder_detail_kode_produk" class="v_stockorder_detail_kode_produk"><?= $Page->renderSort($Page->kode_produk) ?></div></th>
<?php } ?>
<?php if ($Page->nama_produk->Visible) { // nama_produk ?>
        <th data-name="nama_produk" class="<?= $Page->nama_produk->headerCellClass() ?>"><div id="elh_v_stockorder_detail_nama_produk" class="v_stockorder_detail_nama_produk"><?= $Page->renderSort($Page->nama_produk) ?></div></th>
<?php } ?>
<?php if ($Page->jumlah_order->Visible) { // jumlah_order ?>
        <th data-name="jumlah_order" class="<?= $Page->jumlah_order->headerCellClass() ?>"><div id="elh_v_stockorder_detail_jumlah_order" class="v_stockorder_detail_jumlah_order"><?= $Page->renderSort($Page->jumlah_order) ?></div></th>
<?php } ?>
<?php if ($Page->sisa_order->Visible) { // sisa_order ?>
        <th data-name="sisa_order" class="<?= $Page->sisa_order->headerCellClass() ?>"><div id="elh_v_stockorder_detail_sisa_order" class="v_stockorder_detail_sisa_order"><?= $Page->renderSort($Page->sisa_order) ?></div></th>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
        <th data-name="stok_akhir" class="<?= $Page->stok_akhir->headerCellClass() ?>"><div id="elh_v_stockorder_detail_stok_akhir" class="v_stockorder_detail_stok_akhir"><?= $Page->renderSort($Page->stok_akhir) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_v_stockorder_detail", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->idstockorder->Visible) { // idstockorder ?>
        <td data-name="idstockorder" <?= $Page->idstockorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_stockorder_detail_idstockorder">
<span<?= $Page->idstockorder->viewAttributes() ?>>
<?= $Page->idstockorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <td data-name="idstockorder_detail" <?= $Page->idstockorder_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_stockorder_detail_idstockorder_detail">
<span<?= $Page->idstockorder_detail->viewAttributes() ?>>
<?= $Page->idstockorder_detail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kode_produk->Visible) { // kode_produk ?>
        <td data-name="kode_produk" <?= $Page->kode_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_stockorder_detail_kode_produk">
<span<?= $Page->kode_produk->viewAttributes() ?>>
<?= $Page->kode_produk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_produk->Visible) { // nama_produk ?>
        <td data-name="nama_produk" <?= $Page->nama_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_stockorder_detail_nama_produk">
<span<?= $Page->nama_produk->viewAttributes() ?>>
<?= $Page->nama_produk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlah_order->Visible) { // jumlah_order ?>
        <td data-name="jumlah_order" <?= $Page->jumlah_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_stockorder_detail_jumlah_order">
<span<?= $Page->jumlah_order->viewAttributes() ?>>
<?= $Page->jumlah_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisa_order->Visible) { // sisa_order ?>
        <td data-name="sisa_order" <?= $Page->sisa_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_stockorder_detail_sisa_order">
<span<?= $Page->sisa_order->viewAttributes() ?>>
<?= $Page->sisa_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
        <td data-name="stok_akhir" <?= $Page->stok_akhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_stockorder_detail_stok_akhir">
<span<?= $Page->stok_akhir->viewAttributes() ?>>
<?= $Page->stok_akhir->getViewValue() ?></span>
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
    ew.addEventHandlers("v_stockorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
