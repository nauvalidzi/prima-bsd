<?php

namespace PHPMaker2021\distributor;

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
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_v_npd_customer_id" class="v_npd_customer_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->statuskategori->Visible) { // statuskategori ?>
        <th data-name="statuskategori" class="<?= $Page->statuskategori->headerCellClass() ?>"><div id="elh_v_npd_customer_statuskategori" class="v_npd_customer_statuskategori"><?= $Page->renderSort($Page->statuskategori) ?></div></th>
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
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <th data-name="idbrand" class="<?= $Page->idbrand->headerCellClass() ?>"><div id="elh_v_npd_customer_idbrand" class="v_npd_customer_idbrand"><?= $Page->renderSort($Page->idbrand) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>"><div id="elh_v_npd_customer_nama" class="v_npd_customer_nama"><?= $Page->renderSort($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
        <th data-name="idkategoribarang" class="<?= $Page->idkategoribarang->headerCellClass() ?>"><div id="elh_v_npd_customer_idkategoribarang" class="v_npd_customer_idkategoribarang"><?= $Page->renderSort($Page->idkategoribarang) ?></div></th>
<?php } ?>
<?php if ($Page->idjenisbarang->Visible) { // idjenisbarang ?>
        <th data-name="idjenisbarang" class="<?= $Page->idjenisbarang->headerCellClass() ?>"><div id="elh_v_npd_customer_idjenisbarang" class="v_npd_customer_idjenisbarang"><?= $Page->renderSort($Page->idjenisbarang) ?></div></th>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <th data-name="idproduct_acuan" class="<?= $Page->idproduct_acuan->headerCellClass() ?>"><div id="elh_v_npd_customer_idproduct_acuan" class="v_npd_customer_idproduct_acuan"><?= $Page->renderSort($Page->idproduct_acuan) ?></div></th>
<?php } ?>
<?php if ($Page->idkualitasbarang->Visible) { // idkualitasbarang ?>
        <th data-name="idkualitasbarang" class="<?= $Page->idkualitasbarang->headerCellClass() ?>"><div id="elh_v_npd_customer_idkualitasbarang" class="v_npd_customer_idkualitasbarang"><?= $Page->renderSort($Page->idkualitasbarang) ?></div></th>
<?php } ?>
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
        <th data-name="kemasanbarang" class="<?= $Page->kemasanbarang->headerCellClass() ?>"><div id="elh_v_npd_customer_kemasanbarang" class="v_npd_customer_kemasanbarang"><?= $Page->renderSort($Page->kemasanbarang) ?></div></th>
<?php } ?>
<?php if ($Page->label->Visible) { // label ?>
        <th data-name="label" class="<?= $Page->label->headerCellClass() ?>"><div id="elh_v_npd_customer_label" class="v_npd_customer_label"><?= $Page->renderSort($Page->label) ?></div></th>
<?php } ?>
<?php if ($Page->bahan->Visible) { // bahan ?>
        <th data-name="bahan" class="<?= $Page->bahan->headerCellClass() ?>"><div id="elh_v_npd_customer_bahan" class="v_npd_customer_bahan"><?= $Page->renderSort($Page->bahan) ?></div></th>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <th data-name="ukuran" class="<?= $Page->ukuran->headerCellClass() ?>"><div id="elh_v_npd_customer_ukuran" class="v_npd_customer_ukuran"><?= $Page->renderSort($Page->ukuran) ?></div></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th data-name="warna" class="<?= $Page->warna->headerCellClass() ?>"><div id="elh_v_npd_customer_warna" class="v_npd_customer_warna"><?= $Page->renderSort($Page->warna) ?></div></th>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
        <th data-name="parfum" class="<?= $Page->parfum->headerCellClass() ?>"><div id="elh_v_npd_customer_parfum" class="v_npd_customer_parfum"><?= $Page->renderSort($Page->parfum) ?></div></th>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <th data-name="harga" class="<?= $Page->harga->headerCellClass() ?>"><div id="elh_v_npd_customer_harga" class="v_npd_customer_harga"><?= $Page->renderSort($Page->harga) ?></div></th>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
        <th data-name="tambahan" class="<?= $Page->tambahan->headerCellClass() ?>"><div id="elh_v_npd_customer_tambahan" class="v_npd_customer_tambahan"><?= $Page->renderSort($Page->tambahan) ?></div></th>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
        <th data-name="orderperdana" class="<?= $Page->orderperdana->headerCellClass() ?>"><div id="elh_v_npd_customer_orderperdana" class="v_npd_customer_orderperdana"><?= $Page->renderSort($Page->orderperdana) ?></div></th>
<?php } ?>
<?php if ($Page->orderreguler->Visible) { // orderreguler ?>
        <th data-name="orderreguler" class="<?= $Page->orderreguler->headerCellClass() ?>"><div id="elh_v_npd_customer_orderreguler" class="v_npd_customer_orderreguler"><?= $Page->renderSort($Page->orderreguler) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_v_npd_customer_status" class="v_npd_customer_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <th data-name="idproduct" class="<?= $Page->idproduct->headerCellClass() ?>"><div id="elh_v_npd_customer_idproduct" class="v_npd_customer_idproduct"><?= $Page->renderSort($Page->idproduct) ?></div></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Page->created_at->headerCellClass() ?>"><div id="elh_v_npd_customer_created_at" class="v_npd_customer_created_at"><?= $Page->renderSort($Page->created_at) ?></div></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th data-name="created_by" class="<?= $Page->created_by->headerCellClass() ?>"><div id="elh_v_npd_customer_created_by" class="v_npd_customer_created_by"><?= $Page->renderSort($Page->created_by) ?></div></th>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
        <th data-name="selesai" class="<?= $Page->selesai->headerCellClass() ?>"><div id="elh_v_npd_customer_selesai" class="v_npd_customer_selesai"><?= $Page->renderSort($Page->selesai) ?></div></th>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
        <th data-name="readonly" class="<?= $Page->readonly->headerCellClass() ?>"><div id="elh_v_npd_customer_readonly" class="v_npd_customer_readonly"><?= $Page->renderSort($Page->readonly) ?></div></th>
<?php } ?>
<?php if ($Page->nama_pemesan->Visible) { // nama_pemesan ?>
        <th data-name="nama_pemesan" class="<?= $Page->nama_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_nama_pemesan" class="v_npd_customer_nama_pemesan"><?= $Page->renderSort($Page->nama_pemesan) ?></div></th>
<?php } ?>
<?php if ($Page->alamat_pemesan->Visible) { // alamat_pemesan ?>
        <th data-name="alamat_pemesan" class="<?= $Page->alamat_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_alamat_pemesan" class="v_npd_customer_alamat_pemesan"><?= $Page->renderSort($Page->alamat_pemesan) ?></div></th>
<?php } ?>
<?php if ($Page->jabatan_pemesan->Visible) { // jabatan_pemesan ?>
        <th data-name="jabatan_pemesan" class="<?= $Page->jabatan_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_jabatan_pemesan" class="v_npd_customer_jabatan_pemesan"><?= $Page->renderSort($Page->jabatan_pemesan) ?></div></th>
<?php } ?>
<?php if ($Page->hp_pemesan->Visible) { // hp_pemesan ?>
        <th data-name="hp_pemesan" class="<?= $Page->hp_pemesan->headerCellClass() ?>"><div id="elh_v_npd_customer_hp_pemesan" class="v_npd_customer_hp_pemesan"><?= $Page->renderSort($Page->hp_pemesan) ?></div></th>
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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->statuskategori->Visible) { // statuskategori ?>
        <td data-name="statuskategori" <?= $Page->statuskategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_statuskategori">
<span<?= $Page->statuskategori->viewAttributes() ?>>
<?= $Page->statuskategori->getViewValue() ?></span>
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
    <?php if ($Page->idbrand->Visible) { // idbrand ?>
        <td data-name="idbrand" <?= $Page->idbrand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
        <td data-name="idkategoribarang" <?= $Page->idkategoribarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idkategoribarang">
<span<?= $Page->idkategoribarang->viewAttributes() ?>>
<?= $Page->idkategoribarang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idjenisbarang->Visible) { // idjenisbarang ?>
        <td data-name="idjenisbarang" <?= $Page->idjenisbarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idjenisbarang">
<span<?= $Page->idjenisbarang->viewAttributes() ?>>
<?= $Page->idjenisbarang->getViewValue() ?></span>
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
    <?php if ($Page->idkualitasbarang->Visible) { // idkualitasbarang ?>
        <td data-name="idkualitasbarang" <?= $Page->idkualitasbarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idkualitasbarang">
<span<?= $Page->idkualitasbarang->viewAttributes() ?>>
<?= $Page->idkualitasbarang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
        <td data-name="kemasanbarang" <?= $Page->kemasanbarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_kemasanbarang">
<span<?= $Page->kemasanbarang->viewAttributes() ?>>
<?= $Page->kemasanbarang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->label->Visible) { // label ?>
        <td data-name="label" <?= $Page->label->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_label">
<span<?= $Page->label->viewAttributes() ?>>
<?= $Page->label->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bahan->Visible) { // bahan ?>
        <td data-name="bahan" <?= $Page->bahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_bahan">
<span<?= $Page->bahan->viewAttributes() ?>>
<?= $Page->bahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran" <?= $Page->ukuran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
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
    <?php if ($Page->harga->Visible) { // harga ?>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tambahan->Visible) { // tambahan ?>
        <td data-name="tambahan" <?= $Page->tambahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_tambahan">
<span<?= $Page->tambahan->viewAttributes() ?>>
<?= $Page->tambahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->orderperdana->Visible) { // orderperdana ?>
        <td data-name="orderperdana" <?= $Page->orderperdana->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_orderperdana">
<span<?= $Page->orderperdana->viewAttributes() ?>>
<?= $Page->orderperdana->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->orderreguler->Visible) { // orderreguler ?>
        <td data-name="orderreguler" <?= $Page->orderreguler->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_orderreguler">
<span<?= $Page->orderreguler->viewAttributes() ?>>
<?= $Page->orderreguler->getViewValue() ?></span>
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
    <?php if ($Page->idproduct->Visible) { // idproduct ?>
        <td data-name="idproduct" <?= $Page->idproduct->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_idproduct">
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
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
    <?php if ($Page->created_by->Visible) { // created_by ?>
        <td data-name="created_by" <?= $Page->created_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->selesai->Visible) { // selesai ?>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_selesai_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->selesai->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->selesai->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_selesai_<?= $Page->RowCount ?>"></label>
</div></span>
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
    <?php if ($Page->alamat_pemesan->Visible) { // alamat_pemesan ?>
        <td data-name="alamat_pemesan" <?= $Page->alamat_pemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_npd_customer_alamat_pemesan">
<span<?= $Page->alamat_pemesan->viewAttributes() ?>>
<?= $Page->alamat_pemesan->getViewValue() ?></span>
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
