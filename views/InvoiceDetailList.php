<?php

namespace PHPMaker2021\distributor;

// Page object
$InvoiceDetailList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var finvoice_detaillist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    finvoice_detaillist = currentForm = new ew.Form("finvoice_detaillist", "list");
    finvoice_detaillist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("finvoice_detaillist");
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
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "invoice") {
    if ($Page->MasterRecordExists) {
        include_once "views/InvoiceMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> invoice_detail">
<form name="finvoice_detaillist" id="finvoice_detaillist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice_detail">
<?php if ($Page->getCurrentMasterTable() == "invoice" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="invoice">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idinvoice->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_invoice_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_invoice_detaillist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <th data-name="idorder_detail" class="<?= $Page->idorder_detail->headerCellClass() ?>"><div id="elh_invoice_detail_idorder_detail" class="invoice_detail_idorder_detail"><?= $Page->renderSort($Page->idorder_detail) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
        <th data-name="jumlahorder" class="<?= $Page->jumlahorder->headerCellClass() ?>"><div id="elh_invoice_detail_jumlahorder" class="invoice_detail_jumlahorder"><?= $Page->renderSort($Page->jumlahorder) ?></div></th>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
        <th data-name="bonus" class="<?= $Page->bonus->headerCellClass() ?>"><div id="elh_invoice_detail_bonus" class="invoice_detail_bonus"><?= $Page->renderSort($Page->bonus) ?></div></th>
<?php } ?>
<?php if ($Page->stockdo->Visible) { // stockdo ?>
        <th data-name="stockdo" class="<?= $Page->stockdo->headerCellClass() ?>"><div id="elh_invoice_detail_stockdo" class="invoice_detail_stockdo"><?= $Page->renderSort($Page->stockdo) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <th data-name="jumlahkirim" class="<?= $Page->jumlahkirim->headerCellClass() ?>"><div id="elh_invoice_detail_jumlahkirim" class="invoice_detail_jumlahkirim"><?= $Page->renderSort($Page->jumlahkirim) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
        <th data-name="jumlahbonus" class="<?= $Page->jumlahbonus->headerCellClass() ?>"><div id="elh_invoice_detail_jumlahbonus" class="invoice_detail_jumlahbonus"><?= $Page->renderSort($Page->jumlahbonus) ?></div></th>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
        <th data-name="harga" class="<?= $Page->harga->headerCellClass() ?>"><div id="elh_invoice_detail_harga" class="invoice_detail_harga"><?= $Page->renderSort($Page->harga) ?></div></th>
<?php } ?>
<?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
        <th data-name="totalnondiskon" class="<?= $Page->totalnondiskon->headerCellClass() ?>"><div id="elh_invoice_detail_totalnondiskon" class="invoice_detail_totalnondiskon"><?= $Page->renderSort($Page->totalnondiskon) ?></div></th>
<?php } ?>
<?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
        <th data-name="diskonpayment" class="<?= $Page->diskonpayment->headerCellClass() ?>"><div id="elh_invoice_detail_diskonpayment" class="invoice_detail_diskonpayment"><?= $Page->renderSort($Page->diskonpayment) ?></div></th>
<?php } ?>
<?php if ($Page->bbpersen->Visible) { // bbpersen ?>
        <th data-name="bbpersen" class="<?= $Page->bbpersen->headerCellClass() ?>"><div id="elh_invoice_detail_bbpersen" class="invoice_detail_bbpersen"><?= $Page->renderSort($Page->bbpersen) ?></div></th>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <th data-name="totaltagihan" class="<?= $Page->totaltagihan->headerCellClass() ?>"><div id="elh_invoice_detail_totaltagihan" class="invoice_detail_totaltagihan"><?= $Page->renderSort($Page->totaltagihan) ?></div></th>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
        <th data-name="blackbonus" class="<?= $Page->blackbonus->headerCellClass() ?>"><div id="elh_invoice_detail_blackbonus" class="invoice_detail_blackbonus"><?= $Page->renderSort($Page->blackbonus) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_invoice_detail", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <td data-name="idorder_detail" <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_idorder_detail">
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
        <td data-name="jumlahorder" <?= $Page->jumlahorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_jumlahorder">
<span<?= $Page->jumlahorder->viewAttributes() ?>>
<?= $Page->jumlahorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bonus->Visible) { // bonus ?>
        <td data-name="bonus" <?= $Page->bonus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_bonus">
<span<?= $Page->bonus->viewAttributes() ?>>
<?= $Page->bonus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->stockdo->Visible) { // stockdo ?>
        <td data-name="stockdo" <?= $Page->stockdo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_stockdo">
<span<?= $Page->stockdo->viewAttributes() ?>>
<?= $Page->stockdo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim" <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_jumlahkirim">
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
        <td data-name="jumlahbonus" <?= $Page->jumlahbonus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_jumlahbonus">
<span<?= $Page->jumlahbonus->viewAttributes() ?>>
<?= $Page->jumlahbonus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->harga->Visible) { // harga ?>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
        <td data-name="totalnondiskon" <?= $Page->totalnondiskon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_totalnondiskon">
<span<?= $Page->totalnondiskon->viewAttributes() ?>>
<?= $Page->totalnondiskon->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
        <td data-name="diskonpayment" <?= $Page->diskonpayment->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_diskonpayment">
<span<?= $Page->diskonpayment->viewAttributes() ?>>
<?= $Page->diskonpayment->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->bbpersen->Visible) { // bbpersen ?>
        <td data-name="bbpersen" <?= $Page->bbpersen->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_bbpersen">
<span<?= $Page->bbpersen->viewAttributes() ?>>
<?= $Page->bbpersen->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan" <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->blackbonus->Visible) { // blackbonus ?>
        <td data-name="blackbonus" <?= $Page->blackbonus->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_invoice_detail_blackbonus">
<span<?= $Page->blackbonus->viewAttributes() ?>>
<?= $Page->blackbonus->getViewValue() ?></span>
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
    ew.addEventHandlers("invoice_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_invoice_detail",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
