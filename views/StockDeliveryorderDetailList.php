<?php

namespace PHPMaker2021\production2;

// Page object
$StockDeliveryorderDetailList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fstock_deliveryorder_detaillist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fstock_deliveryorder_detaillist = currentForm = new ew.Form("fstock_deliveryorder_detaillist", "list");
    fstock_deliveryorder_detaillist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fstock_deliveryorder_detaillist");
});
var fstock_deliveryorder_detaillistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fstock_deliveryorder_detaillistsrch = currentSearchForm = new ew.Form("fstock_deliveryorder_detaillistsrch");

    // Dynamic selection lists

    // Filters
    fstock_deliveryorder_detaillistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fstock_deliveryorder_detaillistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "stock_deliveryorder") {
    if ($Page->MasterRecordExists) {
        include_once "views/StockDeliveryorderMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fstock_deliveryorder_detaillistsrch" id="fstock_deliveryorder_detaillistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fstock_deliveryorder_detaillistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="stock_deliveryorder_detail">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> stock_deliveryorder_detail">
<form name="fstock_deliveryorder_detaillist" id="fstock_deliveryorder_detaillist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock_deliveryorder_detail">
<?php if ($Page->getCurrentMasterTable() == "stock_deliveryorder" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="stock_deliveryorder">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_stock_deliveryorder_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_stock_deliveryorder_detaillist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idstockorder" class="<?= $Page->idstockorder->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_idstockorder" class="stock_deliveryorder_detail_idstockorder"><?= $Page->renderSort($Page->idstockorder) ?></div></th>
<?php } ?>
<?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <th data-name="idstockorder_detail" class="<?= $Page->idstockorder_detail->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_idstockorder_detail" class="stock_deliveryorder_detail_idstockorder_detail"><?= $Page->renderSort($Page->idstockorder_detail) ?></div></th>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
        <th data-name="totalorder" class="<?= $Page->totalorder->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_totalorder" class="stock_deliveryorder_detail_totalorder"><?= $Page->renderSort($Page->totalorder) ?></div></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th data-name="sisa" class="<?= $Page->sisa->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_sisa" class="stock_deliveryorder_detail_sisa"><?= $Page->renderSort($Page->sisa) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <th data-name="jumlahkirim" class="<?= $Page->jumlahkirim->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_jumlahkirim" class="stock_deliveryorder_detail_jumlahkirim"><?= $Page->renderSort($Page->jumlahkirim) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_keterangan" class="stock_deliveryorder_detail_keterangan"><?= $Page->renderSort($Page->keterangan) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_stock_deliveryorder_detail", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_idstockorder">
<span<?= $Page->idstockorder->viewAttributes() ?>>
<?= $Page->idstockorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <td data-name="idstockorder_detail" <?= $Page->idstockorder_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_idstockorder_detail">
<span<?= $Page->idstockorder_detail->viewAttributes() ?>>
<?= $Page->idstockorder_detail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totalorder->Visible) { // totalorder ?>
        <td data-name="totalorder" <?= $Page->totalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_totalorder">
<span<?= $Page->totalorder->viewAttributes() ?>>
<?= $Page->totalorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisa->Visible) { // sisa ?>
        <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim" <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_jumlahkirim">
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_stock_deliveryorder_detail_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
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
    ew.addEventHandlers("stock_deliveryorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
