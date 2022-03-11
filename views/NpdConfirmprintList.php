<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmprintList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmprintlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnpd_confirmprintlist = currentForm = new ew.Form("fnpd_confirmprintlist", "list");
    fnpd_confirmprintlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fnpd_confirmprintlist");
});
var fnpd_confirmprintlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnpd_confirmprintlistsrch = currentSearchForm = new ew.Form("fnpd_confirmprintlistsrch");

    // Dynamic selection lists

    // Filters
    fnpd_confirmprintlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnpd_confirmprintlistsrch");
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
<form name="fnpd_confirmprintlistsrch" id="fnpd_confirmprintlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnpd_confirmprintlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="npd_confirmprint">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_confirmprint">
<form name="fnpd_confirmprintlist" id="fnpd_confirmprintlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmprint">
<div id="gmp_npd_confirmprint" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_npd_confirmprintlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_npd_confirmprint_id" class="npd_confirmprint_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
        <th data-name="brand" class="<?= $Page->brand->headerCellClass() ?>"><div id="elh_npd_confirmprint_brand" class="npd_confirmprint_brand"><?= $Page->renderSort($Page->brand) ?></div></th>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
        <th data-name="tglkirim" class="<?= $Page->tglkirim->headerCellClass() ?>"><div id="elh_npd_confirmprint_tglkirim" class="npd_confirmprint_tglkirim"><?= $Page->renderSort($Page->tglkirim) ?></div></th>
<?php } ?>
<?php if ($Page->tgldisetujui->Visible) { // tgldisetujui ?>
        <th data-name="tgldisetujui" class="<?= $Page->tgldisetujui->headerCellClass() ?>"><div id="elh_npd_confirmprint_tgldisetujui" class="npd_confirmprint_tgldisetujui"><?= $Page->renderSort($Page->tgldisetujui) ?></div></th>
<?php } ?>
<?php if ($Page->desainprimer->Visible) { // desainprimer ?>
        <th data-name="desainprimer" class="<?= $Page->desainprimer->headerCellClass() ?>"><div id="elh_npd_confirmprint_desainprimer" class="npd_confirmprint_desainprimer"><?= $Page->renderSort($Page->desainprimer) ?></div></th>
<?php } ?>
<?php if ($Page->materialprimer->Visible) { // materialprimer ?>
        <th data-name="materialprimer" class="<?= $Page->materialprimer->headerCellClass() ?>"><div id="elh_npd_confirmprint_materialprimer" class="npd_confirmprint_materialprimer"><?= $Page->renderSort($Page->materialprimer) ?></div></th>
<?php } ?>
<?php if ($Page->aplikasiprimer->Visible) { // aplikasiprimer ?>
        <th data-name="aplikasiprimer" class="<?= $Page->aplikasiprimer->headerCellClass() ?>"><div id="elh_npd_confirmprint_aplikasiprimer" class="npd_confirmprint_aplikasiprimer"><?= $Page->renderSort($Page->aplikasiprimer) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahcetakprimer->Visible) { // jumlahcetakprimer ?>
        <th data-name="jumlahcetakprimer" class="<?= $Page->jumlahcetakprimer->headerCellClass() ?>"><div id="elh_npd_confirmprint_jumlahcetakprimer" class="npd_confirmprint_jumlahcetakprimer"><?= $Page->renderSort($Page->jumlahcetakprimer) ?></div></th>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
        <th data-name="desainsekunder" class="<?= $Page->desainsekunder->headerCellClass() ?>"><div id="elh_npd_confirmprint_desainsekunder" class="npd_confirmprint_desainsekunder"><?= $Page->renderSort($Page->desainsekunder) ?></div></th>
<?php } ?>
<?php if ($Page->materialinnerbox->Visible) { // materialinnerbox ?>
        <th data-name="materialinnerbox" class="<?= $Page->materialinnerbox->headerCellClass() ?>"><div id="elh_npd_confirmprint_materialinnerbox" class="npd_confirmprint_materialinnerbox"><?= $Page->renderSort($Page->materialinnerbox) ?></div></th>
<?php } ?>
<?php if ($Page->aplikasiinnerbox->Visible) { // aplikasiinnerbox ?>
        <th data-name="aplikasiinnerbox" class="<?= $Page->aplikasiinnerbox->headerCellClass() ?>"><div id="elh_npd_confirmprint_aplikasiinnerbox" class="npd_confirmprint_aplikasiinnerbox"><?= $Page->renderSort($Page->aplikasiinnerbox) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahcetak->Visible) { // jumlahcetak ?>
        <th data-name="jumlahcetak" class="<?= $Page->jumlahcetak->headerCellClass() ?>"><div id="elh_npd_confirmprint_jumlahcetak" class="npd_confirmprint_jumlahcetak"><?= $Page->renderSort($Page->jumlahcetak) ?></div></th>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
        <th data-name="checked_by" class="<?= $Page->checked_by->headerCellClass() ?>"><div id="elh_npd_confirmprint_checked_by" class="npd_confirmprint_checked_by"><?= $Page->renderSort($Page->checked_by) ?></div></th>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
        <th data-name="approved_by" class="<?= $Page->approved_by->headerCellClass() ?>"><div id="elh_npd_confirmprint_approved_by" class="npd_confirmprint_approved_by"><?= $Page->renderSort($Page->approved_by) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_npd_confirmprint_created_at" class="npd_confirmprint_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th data-name="updated_at" class="<?= $Page->updated_at->headerCellClass() ?>"><div id="elh_npd_confirmprint_updated_at" class="npd_confirmprint_updated_at"><?= $Page->renderSort($Page->updated_at) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_npd_confirmprint", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->brand->Visible) { // brand ?>
        <td data-name="brand" <?= $Page->brand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_brand">
<span<?= $Page->brand->viewAttributes() ?>>
<?= $Page->brand->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tglkirim->Visible) { // tglkirim ?>
        <td data-name="tglkirim" <?= $Page->tglkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_tglkirim">
<span<?= $Page->tglkirim->viewAttributes() ?>>
<?= $Page->tglkirim->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgldisetujui->Visible) { // tgldisetujui ?>
        <td data-name="tgldisetujui" <?= $Page->tgldisetujui->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_tgldisetujui">
<span<?= $Page->tgldisetujui->viewAttributes() ?>>
<?= $Page->tgldisetujui->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->desainprimer->Visible) { // desainprimer ?>
        <td data-name="desainprimer" <?= $Page->desainprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_desainprimer">
<span<?= $Page->desainprimer->viewAttributes() ?>>
<?= $Page->desainprimer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->materialprimer->Visible) { // materialprimer ?>
        <td data-name="materialprimer" <?= $Page->materialprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_materialprimer">
<span<?= $Page->materialprimer->viewAttributes() ?>>
<?= $Page->materialprimer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aplikasiprimer->Visible) { // aplikasiprimer ?>
        <td data-name="aplikasiprimer" <?= $Page->aplikasiprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_aplikasiprimer">
<span<?= $Page->aplikasiprimer->viewAttributes() ?>>
<?= $Page->aplikasiprimer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahcetakprimer->Visible) { // jumlahcetakprimer ?>
        <td data-name="jumlahcetakprimer" <?= $Page->jumlahcetakprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_jumlahcetakprimer">
<span<?= $Page->jumlahcetakprimer->viewAttributes() ?>>
<?= $Page->jumlahcetakprimer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
        <td data-name="desainsekunder" <?= $Page->desainsekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_desainsekunder">
<span<?= $Page->desainsekunder->viewAttributes() ?>>
<?= $Page->desainsekunder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->materialinnerbox->Visible) { // materialinnerbox ?>
        <td data-name="materialinnerbox" <?= $Page->materialinnerbox->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_materialinnerbox">
<span<?= $Page->materialinnerbox->viewAttributes() ?>>
<?= $Page->materialinnerbox->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aplikasiinnerbox->Visible) { // aplikasiinnerbox ?>
        <td data-name="aplikasiinnerbox" <?= $Page->aplikasiinnerbox->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_aplikasiinnerbox">
<span<?= $Page->aplikasiinnerbox->viewAttributes() ?>>
<?= $Page->aplikasiinnerbox->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahcetak->Visible) { // jumlahcetak ?>
        <td data-name="jumlahcetak" <?= $Page->jumlahcetak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_jumlahcetak">
<span<?= $Page->jumlahcetak->viewAttributes() ?>>
<?= $Page->jumlahcetak->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->checked_by->Visible) { // checked_by ?>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->approved_by->Visible) { // approved_by ?>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
    ew.addEventHandlers("npd_confirmprint");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
