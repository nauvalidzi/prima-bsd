<?php

namespace PHPMaker2021\distributor;

// Page object
$PenagihanList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpenagihanlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpenagihanlist = currentForm = new ew.Form("fpenagihanlist", "list");
    fpenagihanlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpenagihanlist");
});
var fpenagihanlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fpenagihanlistsrch = currentSearchForm = new ew.Form("fpenagihanlistsrch");

    // Dynamic selection lists

    // Filters
    fpenagihanlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpenagihanlistsrch");
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
<form name="fpenagihanlistsrch" id="fpenagihanlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpenagihanlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="penagihan">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> penagihan">
<form name="fpenagihanlist" id="fpenagihanlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penagihan">
<div id="gmp_penagihan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_penagihanlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->tgl_order->Visible) { // tgl_order ?>
        <th data-name="tgl_order" class="<?= $Page->tgl_order->headerCellClass() ?>"><div id="elh_penagihan_tgl_order" class="penagihan_tgl_order"><?= $Page->renderSort($Page->tgl_order) ?></div></th>
<?php } ?>
<?php if ($Page->kode_order->Visible) { // kode_order ?>
        <th data-name="kode_order" class="<?= $Page->kode_order->headerCellClass() ?>"><div id="elh_penagihan_kode_order" class="penagihan_kode_order"><?= $Page->renderSort($Page->kode_order) ?></div></th>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <th data-name="nama_customer" class="<?= $Page->nama_customer->headerCellClass() ?>"><div id="elh_penagihan_nama_customer" class="penagihan_nama_customer"><?= $Page->renderSort($Page->nama_customer) ?></div></th>
<?php } ?>
<?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
        <th data-name="nomor_handphone" class="<?= $Page->nomor_handphone->headerCellClass() ?>"><div id="elh_penagihan_nomor_handphone" class="penagihan_nomor_handphone"><?= $Page->renderSort($Page->nomor_handphone) ?></div></th>
<?php } ?>
<?php if ($Page->nilai_po->Visible) { // nilai_po ?>
        <th data-name="nilai_po" class="<?= $Page->nilai_po->headerCellClass() ?>"><div id="elh_penagihan_nilai_po" class="penagihan_nilai_po"><?= $Page->renderSort($Page->nilai_po) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_faktur->Visible) { // tgl_faktur ?>
        <th data-name="tgl_faktur" class="<?= $Page->tgl_faktur->headerCellClass() ?>"><div id="elh_penagihan_tgl_faktur" class="penagihan_tgl_faktur"><?= $Page->renderSort($Page->tgl_faktur) ?></div></th>
<?php } ?>
<?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
        <th data-name="nilai_faktur" class="<?= $Page->nilai_faktur->headerCellClass() ?>"><div id="elh_penagihan_nilai_faktur" class="penagihan_nilai_faktur"><?= $Page->renderSort($Page->nilai_faktur) ?></div></th>
<?php } ?>
<?php if ($Page->piutang->Visible) { // piutang ?>
        <th data-name="piutang" class="<?= $Page->piutang->headerCellClass() ?>"><div id="elh_penagihan_piutang" class="penagihan_piutang"><?= $Page->renderSort($Page->piutang) ?></div></th>
<?php } ?>
<?php if ($Page->umur_faktur->Visible) { // umur_faktur ?>
        <th data-name="umur_faktur" class="<?= $Page->umur_faktur->headerCellClass() ?>"><div id="elh_penagihan_umur_faktur" class="penagihan_umur_faktur"><?= $Page->renderSort($Page->umur_faktur) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_antrian->Visible) { // tgl_antrian ?>
        <th data-name="tgl_antrian" class="<?= $Page->tgl_antrian->headerCellClass() ?>"><div id="elh_penagihan_tgl_antrian" class="penagihan_tgl_antrian"><?= $Page->renderSort($Page->tgl_antrian) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_penagihan_status" class="penagihan_status"><?= $Page->renderSort($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_penagihan->Visible) { // tgl_penagihan ?>
        <th data-name="tgl_penagihan" class="<?= $Page->tgl_penagihan->headerCellClass() ?>"><div id="elh_penagihan_tgl_penagihan" class="penagihan_tgl_penagihan"><?= $Page->renderSort($Page->tgl_penagihan) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_return->Visible) { // tgl_return ?>
        <th data-name="tgl_return" class="<?= $Page->tgl_return->headerCellClass() ?>"><div id="elh_penagihan_tgl_return" class="penagihan_tgl_return"><?= $Page->renderSort($Page->tgl_return) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_cancel->Visible) { // tgl_cancel ?>
        <th data-name="tgl_cancel" class="<?= $Page->tgl_cancel->headerCellClass() ?>"><div id="elh_penagihan_tgl_cancel" class="penagihan_tgl_cancel"><?= $Page->renderSort($Page->tgl_cancel) ?></div></th>
<?php } ?>
<?php if ($Page->statusts->Visible) { // statusts ?>
        <th data-name="statusts" class="<?= $Page->statusts->headerCellClass() ?>"><div id="elh_penagihan_statusts" class="penagihan_statusts"><?= $Page->renderSort($Page->statusts) ?></div></th>
<?php } ?>
<?php if ($Page->statusbayar->Visible) { // statusbayar ?>
        <th data-name="statusbayar" class="<?= $Page->statusbayar->headerCellClass() ?>"><div id="elh_penagihan_statusbayar" class="penagihan_statusbayar"><?= $Page->renderSort($Page->statusbayar) ?></div></th>
<?php } ?>
<?php if ($Page->nomorfaktur->Visible) { // nomorfaktur ?>
        <th data-name="nomorfaktur" class="<?= $Page->nomorfaktur->headerCellClass() ?>"><div id="elh_penagihan_nomorfaktur" class="penagihan_nomorfaktur"><?= $Page->renderSort($Page->nomorfaktur) ?></div></th>
<?php } ?>
<?php if ($Page->pembayaran->Visible) { // pembayaran ?>
        <th data-name="pembayaran" class="<?= $Page->pembayaran->headerCellClass() ?>"><div id="elh_penagihan_pembayaran" class="penagihan_pembayaran"><?= $Page->renderSort($Page->pembayaran) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_penagihan_keterangan" class="penagihan_keterangan"><?= $Page->renderSort($Page->keterangan) ?></div></th>
<?php } ?>
<?php if ($Page->saldo->Visible) { // saldo ?>
        <th data-name="saldo" class="<?= $Page->saldo->headerCellClass() ?>"><div id="elh_penagihan_saldo" class="penagihan_saldo"><?= $Page->renderSort($Page->saldo) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_penagihan", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->tgl_order->Visible) { // tgl_order ?>
        <td data-name="tgl_order" <?= $Page->tgl_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_order">
<span<?= $Page->tgl_order->viewAttributes() ?>>
<?= $Page->tgl_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kode_order->Visible) { // kode_order ?>
        <td data-name="kode_order" <?= $Page->kode_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_kode_order">
<span<?= $Page->kode_order->viewAttributes() ?>>
<?= $Page->kode_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <td data-name="nama_customer" <?= $Page->nama_customer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nama_customer">
<span<?= $Page->nama_customer->viewAttributes() ?>>
<?= $Page->nama_customer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
        <td data-name="nomor_handphone" <?= $Page->nomor_handphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nomor_handphone">
<span<?= $Page->nomor_handphone->viewAttributes() ?>>
<?= $Page->nomor_handphone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nilai_po->Visible) { // nilai_po ?>
        <td data-name="nilai_po" <?= $Page->nilai_po->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nilai_po">
<span<?= $Page->nilai_po->viewAttributes() ?>>
<?= $Page->nilai_po->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_faktur->Visible) { // tgl_faktur ?>
        <td data-name="tgl_faktur" <?= $Page->tgl_faktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_faktur">
<span<?= $Page->tgl_faktur->viewAttributes() ?>>
<?= $Page->tgl_faktur->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
        <td data-name="nilai_faktur" <?= $Page->nilai_faktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nilai_faktur">
<span<?= $Page->nilai_faktur->viewAttributes() ?>>
<?= $Page->nilai_faktur->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->piutang->Visible) { // piutang ?>
        <td data-name="piutang" <?= $Page->piutang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_piutang">
<span<?= $Page->piutang->viewAttributes() ?>>
<?= $Page->piutang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->umur_faktur->Visible) { // umur_faktur ?>
        <td data-name="umur_faktur" <?= $Page->umur_faktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_umur_faktur">
<span<?= $Page->umur_faktur->viewAttributes() ?>>
<?= $Page->umur_faktur->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_antrian->Visible) { // tgl_antrian ?>
        <td data-name="tgl_antrian" <?= $Page->tgl_antrian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_antrian">
<span<?= $Page->tgl_antrian->viewAttributes() ?>>
<?= $Page->tgl_antrian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_status">
<span<?= $Page->status->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_status_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_penagihan->Visible) { // tgl_penagihan ?>
        <td data-name="tgl_penagihan" <?= $Page->tgl_penagihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_penagihan">
<span<?= $Page->tgl_penagihan->viewAttributes() ?>>
<?= $Page->tgl_penagihan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_return->Visible) { // tgl_return ?>
        <td data-name="tgl_return" <?= $Page->tgl_return->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_return">
<span<?= $Page->tgl_return->viewAttributes() ?>>
<?= $Page->tgl_return->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_cancel->Visible) { // tgl_cancel ?>
        <td data-name="tgl_cancel" <?= $Page->tgl_cancel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_cancel">
<span<?= $Page->tgl_cancel->viewAttributes() ?>>
<?= $Page->tgl_cancel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->statusts->Visible) { // statusts ?>
        <td data-name="statusts" <?= $Page->statusts->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_statusts">
<span<?= $Page->statusts->viewAttributes() ?>>
<?= $Page->statusts->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->statusbayar->Visible) { // statusbayar ?>
        <td data-name="statusbayar" <?= $Page->statusbayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_statusbayar">
<span<?= $Page->statusbayar->viewAttributes() ?>>
<?= $Page->statusbayar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nomorfaktur->Visible) { // nomorfaktur ?>
        <td data-name="nomorfaktur" <?= $Page->nomorfaktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nomorfaktur">
<span<?= $Page->nomorfaktur->viewAttributes() ?>>
<?= $Page->nomorfaktur->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pembayaran->Visible) { // pembayaran ?>
        <td data-name="pembayaran" <?= $Page->pembayaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_pembayaran">
<span<?= $Page->pembayaran->viewAttributes() ?>>
<?= $Page->pembayaran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->saldo->Visible) { // saldo ?>
        <td data-name="saldo" <?= $Page->saldo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_saldo">
<span<?= $Page->saldo->viewAttributes() ?>>
<?= $Page->saldo->getViewValue() ?></span>
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
    ew.addEventHandlers("penagihan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
