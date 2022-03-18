<?php

namespace PHPMaker2021\production2;

// Page object
$VNpdCustomerList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_npd_customerlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fv_npd_customerlist = currentForm = new ew.Form("fv_npd_customerlist", "list");
    fv_npd_customerlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fv_npd_customerlist");
});
var fv_npd_customerlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fv_npd_customerlistsrch = currentSearchForm = new ew.Form("fv_npd_customerlistsrch");

    // Dynamic selection lists

    // Filters
    fv_npd_customerlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fv_npd_customerlistsrch");
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
<form name="fv_npd_customerlistsrch" id="fv_npd_customerlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fv_npd_customerlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_npd_customer">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_npd_customer">
<form name="fv_npd_customerlist" id="fv_npd_customerlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_npd_customer">
<div id="gmp_v_npd_customer" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_v_npd_customerlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Page->idnpd->headerCellClass() ?>"><div id="elh_v_npd_customer_idnpd" class="v_npd_customer_idnpd"><?= $Page->renderSort($Page->idnpd) ?></div></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Page->idpegawai->headerCellClass() ?>"><div id="elh_v_npd_customer_idpegawai" class="v_npd_customer_idpegawai"><?= $Page->renderSort($Page->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Page->idcustomer->headerCellClass() ?>"><div id="elh_v_npd_customer_idcustomer" class="v_npd_customer_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <th data-name="kodeorder" class="<?= $Page->kodeorder->headerCellClass() ?>"><div id="elh_v_npd_customer_kodeorder" class="v_npd_customer_kodeorder"><?= $Page->renderSort($Page->kodeorder) ?></div></th>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
        <th data-name="kategoriproduk" class="<?= $Page->kategoriproduk->headerCellClass() ?>"><div id="elh_v_npd_customer_kategoriproduk" class="v_npd_customer_kategoriproduk"><?= $Page->renderSort($Page->kategoriproduk) ?></div></th>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
        <th data-name="jenisproduk" class="<?= $Page->jenisproduk->headerCellClass() ?>"><div id="elh_v_npd_customer_jenisproduk" class="v_npd_customer_jenisproduk"><?= $Page->renderSort($Page->jenisproduk) ?></div></th>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <th data-name="idproduct_acuan" class="<?= $Page->idproduct_acuan->headerCellClass() ?>"><div id="elh_v_npd_customer_idproduct_acuan" class="v_npd_customer_idproduct_acuan"><?= $Page->renderSort($Page->idproduct_acuan) ?></div></th>
<?php } ?>
<?php if ($Page->kualitasproduk->Visible) { // kualitasproduk ?>
        <th data-name="kualitasproduk" class="<?= $Page->kualitasproduk->headerCellClass() ?>"><div id="elh_v_npd_customer_kualitasproduk" class="v_npd_customer_kualitasproduk"><?= $Page->renderSort($Page->kualitasproduk) ?></div></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th data-name="warna" class="<?= $Page->warna->headerCellClass() ?>"><div id="elh_v_npd_customer_warna" class="v_npd_customer_warna"><?= $Page->renderSort($Page->warna) ?></div></th>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
        <th data-name="parfum" class="<?= $Page->parfum->headerCellClass() ?>"><div id="elh_v_npd_customer_parfum" class="v_npd_customer_parfum"><?= $Page->renderSort($Page->parfum) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_v_npd_customer_status" class="v_npd_customer_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_v_npd_customer_created_at" class="v_npd_customer_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
        <th data-name="readonly" class="<?= $Page->readonly->headerCellClass() ?>"><div id="elh_v_npd_customer_readonly" class="v_npd_customer_readonly"><?= $Page->renderSort($Page->readonly) ?></div></th>
<?php } ?>
<?php if ($Page->nama_pemesan->Visible) { // nama_pemesan ?>
        <th data-name="nama_pemesan" class="<?= $Page->nama_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_nama_pemesan" class="v_npd_customer_nama_pemesan"><?= $Page->renderSort($Page->nama_pemesan) ?></div></th>
<?php } ?>
<?php if ($Page->jabatan_pemesan->Visible) { // jabatan_pemesan ?>
        <th data-name="jabatan_pemesan" class="<?= $Page->jabatan_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_jabatan_pemesan" class="v_npd_customer_jabatan_pemesan"><?= $Page->renderSort($Page->jabatan_pemesan) ?></div></th>
<?php } ?>
<?php if ($Page->hp_pemesan->Visible) { // hp_pemesan ?>
        <th data-name="hp_pemesan" class="<?= $Page->hp_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_hp_pemesan" class="v_npd_customer_hp_pemesan"><?= $Page->renderSort($Page->hp_pemesan) ?></div></th>
<?php } ?>
<?php if ($Page->kodeproduk->Visible) { // kodeproduk ?>
        <th data-name="kodeproduk" class="<?= $Page->kodeproduk->headerCellClass() ?>"><div id="elh_v_npd_customer_kodeproduk" class="v_npd_customer_kodeproduk"><?= $Page->renderSort($Page->kodeproduk) ?></div></th>
<?php } ?>
<?php if ($Page->namaproduk->Visible) { // namaproduk ?>
        <th data-name="namaproduk" class="<?= $Page->namaproduk->headerCellClass() ?>"><div id="elh_v_npd_customer_namaproduk" class="v_npd_customer_namaproduk"><?= $Page->renderSort($Page->namaproduk) ?></div></th>
<?php } ?>
<?php if ($Page->kode_pemesan->Visible) { // kode_pemesan ?>
        <th data-name="kode_pemesan" class="<?= $Page->kode_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_kode_pemesan" class="v_npd_customer_kode_pemesan"><?= $Page->renderSort($Page->kode_pemesan) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_v_npd_customer", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <td data-name="kodeorder" <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
        <td data-name="kategoriproduk" <?= $Page->kategoriproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_kategoriproduk">
<span<?= $Page->kategoriproduk->viewAttributes() ?>>
<?= $Page->kategoriproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
        <td data-name="jenisproduk" <?= $Page->jenisproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_jenisproduk">
<span<?= $Page->jenisproduk->viewAttributes() ?>>
<?= $Page->jenisproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <td data-name="idproduct_acuan" <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idproduct_acuan">
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kualitasproduk->Visible) { // kualitasproduk ?>
        <td data-name="kualitasproduk" <?= $Page->kualitasproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_kualitasproduk">
<span<?= $Page->kualitasproduk->viewAttributes() ?>>
<?= $Page->kualitasproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->warna->Visible) { // warna ?>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parfum->Visible) { // parfum ?>
        <td data-name="parfum" <?= $Page->parfum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_parfum">
<span<?= $Page->parfum->viewAttributes() ?>>
<?= $Page->parfum->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->readonly->Visible) { // readonly ?>
        <td data-name="readonly" <?= $Page->readonly->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_readonly">
<span<?= $Page->readonly->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_readonly_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->readonly->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->readonly->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_readonly_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_pemesan->Visible) { // nama_pemesan ?>
        <td data-name="nama_pemesan" <?= $Page->nama_pemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_nama_pemesan">
<span<?= $Page->nama_pemesan->viewAttributes() ?>>
<?= $Page->nama_pemesan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jabatan_pemesan->Visible) { // jabatan_pemesan ?>
        <td data-name="jabatan_pemesan" <?= $Page->jabatan_pemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_jabatan_pemesan">
<span<?= $Page->jabatan_pemesan->viewAttributes() ?>>
<?= $Page->jabatan_pemesan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hp_pemesan->Visible) { // hp_pemesan ?>
        <td data-name="hp_pemesan" <?= $Page->hp_pemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_hp_pemesan">
<span<?= $Page->hp_pemesan->viewAttributes() ?>>
<?= $Page->hp_pemesan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kodeproduk->Visible) { // kodeproduk ?>
        <td data-name="kodeproduk" <?= $Page->kodeproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_kodeproduk">
<span<?= $Page->kodeproduk->viewAttributes() ?>>
<?= $Page->kodeproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->namaproduk->Visible) { // namaproduk ?>
        <td data-name="namaproduk" <?= $Page->namaproduk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_namaproduk">
<span<?= $Page->namaproduk->viewAttributes() ?>>
<?= $Page->namaproduk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kode_pemesan->Visible) { // kode_pemesan ?>
        <td data-name="kode_pemesan" <?= $Page->kode_pemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_kode_pemesan">
<span<?= $Page->kode_pemesan->viewAttributes() ?>>
<?= $Page->kode_pemesan->getViewValue() ?></span>
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
    ew.addEventHandlers("v_npd_customer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
