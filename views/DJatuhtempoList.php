<?php

namespace PHPMaker2021\distributor;

// Page object
$DJatuhtempoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fd_jatuhtempolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fd_jatuhtempolist = currentForm = new ew.Form("fd_jatuhtempolist", "list");
    fd_jatuhtempolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fd_jatuhtempolist");
});
var fd_jatuhtempolistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fd_jatuhtempolistsrch = currentSearchForm = new ew.Form("fd_jatuhtempolistsrch");

    // Dynamic selection lists

    // Filters
    fd_jatuhtempolistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fd_jatuhtempolistsrch");
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
<form name="fd_jatuhtempolistsrch" id="fd_jatuhtempolistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fd_jatuhtempolistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="d_jatuhtempo">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> d_jatuhtempo">
<form name="fd_jatuhtempolist" id="fd_jatuhtempolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="d_jatuhtempo">
<div id="gmp_d_jatuhtempo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_d_jatuhtempolist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Page->idpegawai->headerCellClass() ?>"><div id="elh_d_jatuhtempo_idpegawai" class="d_jatuhtempo_idpegawai"><?= $Page->renderSort($Page->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Page->namapegawai->Visible) { // namapegawai ?>
        <th data-name="namapegawai" class="<?= $Page->namapegawai->headerCellClass() ?>"><div id="elh_d_jatuhtempo_namapegawai" class="d_jatuhtempo_namapegawai"><?= $Page->renderSort($Page->namapegawai) ?></div></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Page->idcustomer->headerCellClass() ?>"><div id="elh_d_jatuhtempo_idcustomer" class="d_jatuhtempo_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Page->namacustomer->Visible) { // namacustomer ?>
        <th data-name="namacustomer" class="<?= $Page->namacustomer->headerCellClass() ?>"><div id="elh_d_jatuhtempo_namacustomer" class="d_jatuhtempo_namacustomer"><?= $Page->renderSort($Page->namacustomer) ?></div></th>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { // idinvoice ?>
        <th data-name="idinvoice" class="<?= $Page->idinvoice->headerCellClass() ?>"><div id="elh_d_jatuhtempo_idinvoice" class="d_jatuhtempo_idinvoice"><?= $Page->renderSort($Page->idinvoice) ?></div></th>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <th data-name="sisabayar" class="<?= $Page->sisabayar->headerCellClass() ?>"><div id="elh_d_jatuhtempo_sisabayar" class="d_jatuhtempo_sisabayar"><?= $Page->renderSort($Page->sisabayar) ?></div></th>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { // jatuhtempo ?>
        <th data-name="jatuhtempo" class="<?= $Page->jatuhtempo->headerCellClass() ?>"><div id="elh_d_jatuhtempo_jatuhtempo" class="d_jatuhtempo_jatuhtempo"><?= $Page->renderSort($Page->jatuhtempo) ?></div></th>
<?php } ?>
<?php if ($Page->sisahari->Visible) { // sisahari ?>
        <th data-name="sisahari" class="<?= $Page->sisahari->headerCellClass() ?>"><div id="elh_d_jatuhtempo_sisahari" class="d_jatuhtempo_sisahari"><?= $Page->renderSort($Page->sisahari) ?></div></th>
<?php } ?>
<?php if ($Page->kodeinvoice->Visible) { // kodeinvoice ?>
        <th data-name="kodeinvoice" class="<?= $Page->kodeinvoice->headerCellClass() ?>"><div id="elh_d_jatuhtempo_kodeinvoice" class="d_jatuhtempo_kodeinvoice"><?= $Page->renderSort($Page->kodeinvoice) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_d_jatuhtempo", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->namapegawai->Visible) { // namapegawai ?>
        <td data-name="namapegawai" <?= $Page->namapegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_namapegawai">
<span<?= $Page->namapegawai->viewAttributes() ?>>
<?= $Page->namapegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->namacustomer->Visible) { // namacustomer ?>
        <td data-name="namacustomer" <?= $Page->namacustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_namacustomer">
<span<?= $Page->namacustomer->viewAttributes() ?>>
<?= $Page->namacustomer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idinvoice->Visible) { // idinvoice ?>
        <td data-name="idinvoice" <?= $Page->idinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_idinvoice">
<span<?= $Page->idinvoice->viewAttributes() ?>>
<?= $Page->idinvoice->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <td data-name="sisabayar" <?= $Page->sisabayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_sisabayar">
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jatuhtempo->Visible) { // jatuhtempo ?>
        <td data-name="jatuhtempo" <?= $Page->jatuhtempo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_jatuhtempo">
<span<?= $Page->jatuhtempo->viewAttributes() ?>>
<?= $Page->jatuhtempo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisahari->Visible) { // sisahari ?>
        <td data-name="sisahari" <?= $Page->sisahari->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_sisahari">
<span<?= $Page->sisahari->viewAttributes() ?>>
<?= $Page->sisahari->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kodeinvoice->Visible) { // kodeinvoice ?>
        <td data-name="kodeinvoice" <?= $Page->kodeinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_d_jatuhtempo_kodeinvoice">
<span<?= $Page->kodeinvoice->viewAttributes() ?>>
<?= $Page->kodeinvoice->getViewValue() ?></span>
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
    ew.addEventHandlers("d_jatuhtempo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
