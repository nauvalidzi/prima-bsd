<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdMasterSpesifikasiList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_master_spesifikasilist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnpd_master_spesifikasilist = currentForm = new ew.Form("fnpd_master_spesifikasilist", "list");
    fnpd_master_spesifikasilist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fnpd_master_spesifikasilist");
});
var fnpd_master_spesifikasilistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnpd_master_spesifikasilistsrch = currentSearchForm = new ew.Form("fnpd_master_spesifikasilistsrch");

    // Dynamic selection lists

    // Filters
    fnpd_master_spesifikasilistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnpd_master_spesifikasilistsrch");
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
<form name="fnpd_master_spesifikasilistsrch" id="fnpd_master_spesifikasilistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnpd_master_spesifikasilistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="npd_master_spesifikasi">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_master_spesifikasi">
<form name="fnpd_master_spesifikasilist" id="fnpd_master_spesifikasilist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_master_spesifikasi">
<div id="gmp_npd_master_spesifikasi" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_npd_master_spesifikasilist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_id" class="npd_master_spesifikasi_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
        <th data-name="grup" class="<?= $Page->grup->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_grup" class="npd_master_spesifikasi_grup"><?= $Page->renderSort($Page->grup) ?></div></th>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <th data-name="kategori" class="<?= $Page->kategori->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_kategori" class="npd_master_spesifikasi_kategori"><?= $Page->renderSort($Page->kategori) ?></div></th>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <th data-name="sediaan" class="<?= $Page->sediaan->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_sediaan" class="npd_master_spesifikasi_sediaan"><?= $Page->renderSort($Page->sediaan) ?></div></th>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
        <th data-name="bentukan" class="<?= $Page->bentukan->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_bentukan" class="npd_master_spesifikasi_bentukan"><?= $Page->renderSort($Page->bentukan) ?></div></th>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
        <th data-name="konsep" class="<?= $Page->konsep->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_konsep" class="npd_master_spesifikasi_konsep"><?= $Page->renderSort($Page->konsep) ?></div></th>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <th data-name="bahanaktif" class="<?= $Page->bahanaktif->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_bahanaktif" class="npd_master_spesifikasi_bahanaktif"><?= $Page->renderSort($Page->bahanaktif) ?></div></th>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <th data-name="fragrance" class="<?= $Page->fragrance->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_fragrance" class="npd_master_spesifikasi_fragrance"><?= $Page->renderSort($Page->fragrance) ?></div></th>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <th data-name="aroma" class="<?= $Page->aroma->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_aroma" class="npd_master_spesifikasi_aroma"><?= $Page->renderSort($Page->aroma) ?></div></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th data-name="warna" class="<?= $Page->warna->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_warna" class="npd_master_spesifikasi_warna"><?= $Page->renderSort($Page->warna) ?></div></th>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <th data-name="aplikasi_sediaan" class="<?= $Page->aplikasi_sediaan->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_aplikasi_sediaan" class="npd_master_spesifikasi_aplikasi_sediaan"><?= $Page->renderSort($Page->aplikasi_sediaan) ?></div></th>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <th data-name="aksesoris" class="<?= $Page->aksesoris->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_aksesoris" class="npd_master_spesifikasi_aksesoris"><?= $Page->renderSort($Page->aksesoris) ?></div></th>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
        <th data-name="nour" class="<?= $Page->nour->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_nour" class="npd_master_spesifikasi_nour"><?= $Page->renderSort($Page->nour) ?></div></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Page->updated_at->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_updated_at" class="npd_master_spesifikasi_updated_at"><?= $Page->renderSort($Page->updated_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
        <th data-name="updated_user" class="<?= $Page->updated_user->headerCellClass() ?>"><div id="elh_npd_master_spesifikasi_updated_user" class="npd_master_spesifikasi_updated_user"><?= $Page->renderSort($Page->updated_user) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_npd_master_spesifikasi", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->grup->Visible) { // grup ?>
        <td data-name="grup" <?= $Page->grup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kategori->Visible) { // kategori ?>
        <td data-name="kategori" <?= $Page->kategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sediaan->Visible) { // sediaan ?>
        <td data-name="sediaan" <?= $Page->sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_sediaan">
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bentukan->Visible) { // bentukan ?>
        <td data-name="bentukan" <?= $Page->bentukan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_bentukan">
<span<?= $Page->bentukan->viewAttributes() ?>>
<?= $Page->bentukan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->konsep->Visible) { // konsep ?>
        <td data-name="konsep" <?= $Page->konsep->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_konsep">
<span<?= $Page->konsep->viewAttributes() ?>>
<?= $Page->konsep->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <td data-name="bahanaktif" <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fragrance->Visible) { // fragrance ?>
        <td data-name="fragrance" <?= $Page->fragrance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aroma->Visible) { // aroma ?>
        <td data-name="aroma" <?= $Page->aroma->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->warna->Visible) { // warna ?>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <td data-name="aplikasi_sediaan" <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <td data-name="aksesoris" <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nour->Visible) { // nour ?>
        <td data-name="nour" <?= $Page->nour->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_nour">
<span<?= $Page->nour->viewAttributes() ?>>
<?= $Page->nour->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_user->Visible) { // updated_user ?>
        <td data-name="updated_user" <?= $Page->updated_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_updated_user">
<span<?= $Page->updated_user->viewAttributes() ?>>
<?= $Page->updated_user->getViewValue() ?></span>
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
    ew.addEventHandlers("npd_master_spesifikasi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
