<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdummyList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdummylist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnpd_confirmdummylist = currentForm = new ew.Form("fnpd_confirmdummylist", "list");
    fnpd_confirmdummylist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fnpd_confirmdummylist");
});
var fnpd_confirmdummylistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnpd_confirmdummylistsrch = currentSearchForm = new ew.Form("fnpd_confirmdummylistsrch");

    // Dynamic selection lists

    // Filters
    fnpd_confirmdummylistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnpd_confirmdummylistsrch");
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
<form name="fnpd_confirmdummylistsrch" id="fnpd_confirmdummylistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnpd_confirmdummylistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="npd_confirmdummy">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_confirmdummy">
<form name="fnpd_confirmdummylist" id="fnpd_confirmdummylist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdummy">
<div id="gmp_npd_confirmdummy" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_npd_confirmdummylist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_npd_confirmdummy_id" class="npd_confirmdummy_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Page->idnpd->headerCellClass() ?>"><div id="elh_npd_confirmdummy_idnpd" class="npd_confirmdummy_idnpd"><?= $Page->renderSort($Page->idnpd) ?></div></th>
<?php } ?>
<?php if ($Page->dummydepan->Visible) { // dummydepan ?>
        <th data-name="dummydepan" class="<?= $Page->dummydepan->headerCellClass() ?>"><div id="elh_npd_confirmdummy_dummydepan" class="npd_confirmdummy_dummydepan"><?= $Page->renderSort($Page->dummydepan) ?></div></th>
<?php } ?>
<?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
        <th data-name="dummybelakang" class="<?= $Page->dummybelakang->headerCellClass() ?>"><div id="elh_npd_confirmdummy_dummybelakang" class="npd_confirmdummy_dummybelakang"><?= $Page->renderSort($Page->dummybelakang) ?></div></th>
<?php } ?>
<?php if ($Page->dummyatas->Visible) { // dummyatas ?>
        <th data-name="dummyatas" class="<?= $Page->dummyatas->headerCellClass() ?>"><div id="elh_npd_confirmdummy_dummyatas" class="npd_confirmdummy_dummyatas"><?= $Page->renderSort($Page->dummyatas) ?></div></th>
<?php } ?>
<?php if ($Page->dummysamping->Visible) { // dummysamping ?>
        <th data-name="dummysamping" class="<?= $Page->dummysamping->headerCellClass() ?>"><div id="elh_npd_confirmdummy_dummysamping" class="npd_confirmdummy_dummysamping"><?= $Page->renderSort($Page->dummysamping) ?></div></th>
<?php } ?>
<?php if ($Page->ttd->Visible) { // ttd ?>
        <th data-name="ttd" class="<?= $Page->ttd->headerCellClass() ?>"><div id="elh_npd_confirmdummy_ttd" class="npd_confirmdummy_ttd"><?= $Page->renderSort($Page->ttd) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_npd_confirmdummy", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dummydepan->Visible) { // dummydepan ?>
        <td data-name="dummydepan" <?= $Page->dummydepan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummydepan">
<span<?= $Page->dummydepan->viewAttributes() ?>>
<?= $Page->dummydepan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
        <td data-name="dummybelakang" <?= $Page->dummybelakang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummybelakang">
<span<?= $Page->dummybelakang->viewAttributes() ?>>
<?= $Page->dummybelakang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dummyatas->Visible) { // dummyatas ?>
        <td data-name="dummyatas" <?= $Page->dummyatas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummyatas">
<span<?= $Page->dummyatas->viewAttributes() ?>>
<?= $Page->dummyatas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dummysamping->Visible) { // dummysamping ?>
        <td data-name="dummysamping" <?= $Page->dummysamping->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummysamping">
<span<?= $Page->dummysamping->viewAttributes() ?>>
<?= $Page->dummysamping->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ttd->Visible) { // ttd ?>
        <td data-name="ttd" <?= $Page->ttd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_ttd">
<span<?= $Page->ttd->viewAttributes() ?>>
<?= $Page->ttd->getViewValue() ?></span>
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
    ew.addEventHandlers("npd_confirmdummy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
