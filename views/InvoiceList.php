<?php

namespace PHPMaker2021\production2;

// Page object
$InvoiceList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var finvoicelist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    finvoicelist = currentForm = new ew.Form("finvoicelist", "list");
    finvoicelist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("finvoicelist");
});
var finvoicelistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    finvoicelistsrch = currentSearchForm = new ew.Form("finvoicelistsrch");

    // Dynamic selection lists

    // Filters
    finvoicelistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("finvoicelistsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "suratjalan_detail") {
    if ($Page->MasterRecordExists) {
        include_once "views/SuratjalanDetailMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "customer") {
    if ($Page->MasterRecordExists) {
        include_once "views/CustomerMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="finvoicelistsrch" id="finvoicelistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="finvoicelistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="invoice">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> invoice">
<form name="finvoicelist" id="finvoicelist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice">
<?php if ($Page->getCurrentMasterTable() == "suratjalan_detail" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="suratjalan_detail">
<input type="hidden" name="fk_idinvoice" value="<?= HtmlEncode($Page->id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "customer" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="customer">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idcustomer->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_invoice" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_invoicelist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->kode->Visible) { // kode ?>
        <th data-name="kode" class="<?= $Page->kode->headerCellClass() ?>"><div id="elh_invoice_kode" class="invoice_kode"><?= $Page->renderSort($Page->kode) ?></div></th>
<?php } ?>
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
        <th data-name="tglinvoice" class="<?= $Page->tglinvoice->headerCellClass() ?>"><div id="elh_invoice_tglinvoice" class="invoice_tglinvoice"><?= $Page->renderSort($Page->tglinvoice) ?></div></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Page->idcustomer->headerCellClass() ?>"><div id="elh_invoice_idcustomer" class="invoice_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
        <th data-name="idorder" class="<?= $Page->idorder->headerCellClass() ?>"><div id="elh_invoice_idorder" class="invoice_idorder"><?= $Page->renderSort($Page->idorder) ?></div></th>
<?php } ?>
<?php if ($Page->totalnonpajak->Visible) { // totalnonpajak ?>
        <th data-name="totalnonpajak" class="<?= $Page->totalnonpajak->headerCellClass() ?>"><div id="elh_invoice_totalnonpajak" class="invoice_totalnonpajak"><?= $Page->renderSort($Page->totalnonpajak) ?></div></th>
<?php } ?>
<?php if ($Page->pajak->Visible) { // pajak ?>
        <th data-name="pajak" class="<?= $Page->pajak->headerCellClass() ?>"><div id="elh_invoice_pajak" class="invoice_pajak"><?= $Page->renderSort($Page->pajak) ?></div></th>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <th data-name="totaltagihan" class="<?= $Page->totaltagihan->headerCellClass() ?>"><div id="elh_invoice_totaltagihan" class="invoice_totaltagihan"><?= $Page->renderSort($Page->totaltagihan) ?></div></th>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <th data-name="sisabayar" class="<?= $Page->sisabayar->headerCellClass() ?>"><div id="elh_invoice_sisabayar" class="invoice_sisabayar"><?= $Page->renderSort($Page->sisabayar) ?></div></th>
<?php } ?>
<?php if ($Page->idtermpayment->Visible) { // idtermpayment ?>
        <th data-name="idtermpayment" class="<?= $Page->idtermpayment->headerCellClass() ?>"><div id="elh_invoice_idtermpayment" class="invoice_idtermpayment"><?= $Page->renderSort($Page->idtermpayment) ?></div></th>
<?php } ?>
<?php if ($Page->idtipepayment->Visible) { // idtipepayment ?>
        <th data-name="idtipepayment" class="<?= $Page->idtipepayment->headerCellClass() ?>"><div id="elh_invoice_idtipepayment" class="invoice_idtipepayment"><?= $Page->renderSort($Page->idtipepayment) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_invoice_keterangan" class="invoice_keterangan"><?= $Page->renderSort($Page->keterangan) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_invoice", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->kode->Visible) { // kode ?>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
        <td data-name="tglinvoice" <?= $Page->tglinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_tglinvoice">
<span<?= $Page->tglinvoice->viewAttributes() ?>>
<?= $Page->tglinvoice->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idorder->Visible) { // idorder ?>
        <td data-name="idorder" <?= $Page->idorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?php if (!EmptyString($Page->idorder->getViewValue()) && $Page->idorder->linkAttributes() != "") { ?>
<a<?= $Page->idorder->linkAttributes() ?>><?= $Page->idorder->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->idorder->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totalnonpajak->Visible) { // totalnonpajak ?>
        <td data-name="totalnonpajak" <?= $Page->totalnonpajak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_totalnonpajak">
<span<?= $Page->totalnonpajak->viewAttributes() ?>>
<?= $Page->totalnonpajak->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pajak->Visible) { // pajak ?>
        <td data-name="pajak" <?= $Page->pajak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_pajak">
<span<?= $Page->pajak->viewAttributes() ?>>
<?= $Page->pajak->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan" <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <td data-name="sisabayar" <?= $Page->sisabayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_sisabayar">
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idtermpayment->Visible) { // idtermpayment ?>
        <td data-name="idtermpayment" <?= $Page->idtermpayment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_idtermpayment">
<span<?= $Page->idtermpayment->viewAttributes() ?>>
<?= $Page->idtermpayment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idtipepayment->Visible) { // idtipepayment ?>
        <td data-name="idtipepayment" <?= $Page->idtipepayment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_idtipepayment">
<span<?= $Page->idtipepayment->viewAttributes() ?>>
<?= $Page->idtipepayment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_keterangan">
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
    ew.addEventHandlers("invoice");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $(".ew-detail-add-group").html("Add Invoice");
});
</script>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_invoice",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
