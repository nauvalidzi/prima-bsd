<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdDesainList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_desainlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fnpd_desainlist = currentForm = new ew.Form("fnpd_desainlist", "list");
    fnpd_desainlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fnpd_desainlist");
});
var fnpd_desainlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fnpd_desainlistsrch = currentSearchForm = new ew.Form("fnpd_desainlistsrch");

    // Dynamic selection lists

    // Filters
    fnpd_desainlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fnpd_desainlistsrch");
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
<form name="fnpd_desainlistsrch" id="fnpd_desainlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fnpd_desainlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="npd_desain">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_desain">
<form name="fnpd_desainlist" id="fnpd_desainlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_desain">
<?php if ($Page->getCurrentMasterTable() == "npd" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_npd_desain" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_npd_desainlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_npd_desain_id" class="npd_desain_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Page->idnpd->headerCellClass() ?>"><div id="elh_npd_desain_idnpd" class="npd_desain_idnpd"><?= $Page->renderSort($Page->idnpd) ?></div></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Page->idcustomer->headerCellClass() ?>"><div id="elh_npd_desain_idcustomer" class="npd_desain_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_npd_desain_status" class="npd_desain_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
        <th data-name="tanggal_terima" class="<?= $Page->tanggal_terima->headerCellClass() ?>"><div id="elh_npd_desain_tanggal_terima" class="npd_desain_tanggal_terima"><?= $Page->renderSort($Page->tanggal_terima) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <th data-name="tanggal_submit" class="<?= $Page->tanggal_submit->headerCellClass() ?>"><div id="elh_npd_desain_tanggal_submit" class="npd_desain_tanggal_submit"><?= $Page->renderSort($Page->tanggal_submit) ?></div></th>
<?php } ?>
<?php if ($Page->nama_produk->Visible) { // nama_produk ?>
        <th data-name="nama_produk" class="<?= $Page->nama_produk->headerCellClass() ?>"><div id="elh_npd_desain_nama_produk" class="npd_desain_nama_produk"><?= $Page->renderSort($Page->nama_produk) ?></div></th>
<?php } ?>
<?php if ($Page->klaim_bahan->Visible) { // klaim_bahan ?>
        <th data-name="klaim_bahan" class="<?= $Page->klaim_bahan->headerCellClass() ?>"><div id="elh_npd_desain_klaim_bahan" class="npd_desain_klaim_bahan"><?= $Page->renderSort($Page->klaim_bahan) ?></div></th>
<?php } ?>
<?php if ($Page->campaign_produk->Visible) { // campaign_produk ?>
        <th data-name="campaign_produk" class="<?= $Page->campaign_produk->headerCellClass() ?>"><div id="elh_npd_desain_campaign_produk" class="npd_desain_campaign_produk"><?= $Page->renderSort($Page->campaign_produk) ?></div></th>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
        <th data-name="konsep" class="<?= $Page->konsep->headerCellClass() ?>"><div id="elh_npd_desain_konsep" class="npd_desain_konsep"><?= $Page->renderSort($Page->konsep) ?></div></th>
<?php } ?>
<?php if ($Page->tema_warna->Visible) { // tema_warna ?>
        <th data-name="tema_warna" class="<?= $Page->tema_warna->headerCellClass() ?>"><div id="elh_npd_desain_tema_warna" class="npd_desain_tema_warna"><?= $Page->renderSort($Page->tema_warna) ?></div></th>
<?php } ?>
<?php if ($Page->no_notifikasi->Visible) { // no_notifikasi ?>
        <th data-name="no_notifikasi" class="<?= $Page->no_notifikasi->headerCellClass() ?>"><div id="elh_npd_desain_no_notifikasi" class="npd_desain_no_notifikasi"><?= $Page->renderSort($Page->no_notifikasi) ?></div></th>
<?php } ?>
<?php if ($Page->jenis_kemasan->Visible) { // jenis_kemasan ?>
        <th data-name="jenis_kemasan" class="<?= $Page->jenis_kemasan->headerCellClass() ?>"><div id="elh_npd_desain_jenis_kemasan" class="npd_desain_jenis_kemasan"><?= $Page->renderSort($Page->jenis_kemasan) ?></div></th>
<?php } ?>
<?php if ($Page->posisi_label->Visible) { // posisi_label ?>
        <th data-name="posisi_label" class="<?= $Page->posisi_label->headerCellClass() ?>"><div id="elh_npd_desain_posisi_label" class="npd_desain_posisi_label"><?= $Page->renderSort($Page->posisi_label) ?></div></th>
<?php } ?>
<?php if ($Page->bahan_label->Visible) { // bahan_label ?>
        <th data-name="bahan_label" class="<?= $Page->bahan_label->headerCellClass() ?>"><div id="elh_npd_desain_bahan_label" class="npd_desain_bahan_label"><?= $Page->renderSort($Page->bahan_label) ?></div></th>
<?php } ?>
<?php if ($Page->draft_layout->Visible) { // draft_layout ?>
        <th data-name="draft_layout" class="<?= $Page->draft_layout->headerCellClass() ?>"><div id="elh_npd_desain_draft_layout" class="npd_desain_draft_layout"><?= $Page->renderSort($Page->draft_layout) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_npd_desain_created_at" class="npd_desain_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_npd_desain", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_npd_desain_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_terima->Visible) { // tanggal_terima ?>
        <td data-name="tanggal_terima" <?= $Page->tanggal_terima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_tanggal_terima">
<span<?= $Page->tanggal_terima->viewAttributes() ?>>
<?= $Page->tanggal_terima->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <td data-name="tanggal_submit" <?= $Page->tanggal_submit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_tanggal_submit">
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_produk->Visible) { // nama_produk ?>
        <td data-name="nama_produk" <?= $Page->nama_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_nama_produk">
<span<?= $Page->nama_produk->viewAttributes() ?>>
<?= $Page->nama_produk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->klaim_bahan->Visible) { // klaim_bahan ?>
        <td data-name="klaim_bahan" <?= $Page->klaim_bahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_klaim_bahan">
<span<?= $Page->klaim_bahan->viewAttributes() ?>>
<?= $Page->klaim_bahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->campaign_produk->Visible) { // campaign_produk ?>
        <td data-name="campaign_produk" <?= $Page->campaign_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_campaign_produk">
<span<?= $Page->campaign_produk->viewAttributes() ?>>
<?= $Page->campaign_produk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->konsep->Visible) { // konsep ?>
        <td data-name="konsep" <?= $Page->konsep->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_konsep">
<span<?= $Page->konsep->viewAttributes() ?>>
<?= $Page->konsep->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tema_warna->Visible) { // tema_warna ?>
        <td data-name="tema_warna" <?= $Page->tema_warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_tema_warna">
<span<?= $Page->tema_warna->viewAttributes() ?>>
<?= $Page->tema_warna->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->no_notifikasi->Visible) { // no_notifikasi ?>
        <td data-name="no_notifikasi" <?= $Page->no_notifikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_no_notifikasi">
<span<?= $Page->no_notifikasi->viewAttributes() ?>>
<?= $Page->no_notifikasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jenis_kemasan->Visible) { // jenis_kemasan ?>
        <td data-name="jenis_kemasan" <?= $Page->jenis_kemasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_jenis_kemasan">
<span<?= $Page->jenis_kemasan->viewAttributes() ?>>
<?= $Page->jenis_kemasan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->posisi_label->Visible) { // posisi_label ?>
        <td data-name="posisi_label" <?= $Page->posisi_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_posisi_label">
<span<?= $Page->posisi_label->viewAttributes() ?>>
<?= $Page->posisi_label->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bahan_label->Visible) { // bahan_label ?>
        <td data-name="bahan_label" <?= $Page->bahan_label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_bahan_label">
<span<?= $Page->bahan_label->viewAttributes() ?>>
<?= $Page->bahan_label->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->draft_layout->Visible) { // draft_layout ?>
        <td data-name="draft_layout" <?= $Page->draft_layout->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_draft_layout">
<span<?= $Page->draft_layout->viewAttributes() ?>>
<?= $Page->draft_layout->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_desain_created_at">
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
    ew.addEventHandlers("npd_desain");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
