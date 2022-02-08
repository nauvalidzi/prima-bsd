<?php

namespace PHPMaker2021\production2;

// Page object
$DeliveryorderDetailList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fdeliveryorder_detaillist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fdeliveryorder_detaillist = currentForm = new ew.Form("fdeliveryorder_detaillist", "list");
    fdeliveryorder_detaillist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fdeliveryorder_detaillist");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "deliveryorder") {
    if ($Page->MasterRecordExists) {
        include_once "views/DeliveryorderMaster.php";
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> deliveryorder_detail">
<form name="fdeliveryorder_detaillist" id="fdeliveryorder_detaillist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="deliveryorder_detail">
<?php if ($Page->getCurrentMasterTable() == "deliveryorder" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="deliveryorder">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->iddeliveryorder->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_deliveryorder_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_deliveryorder_detaillist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->idorder->Visible) { // idorder ?>
        <th data-name="idorder" class="<?= $Page->idorder->headerCellClass() ?>"><div id="elh_deliveryorder_detail_idorder" class="deliveryorder_detail_idorder"><?= $Page->renderSort($Page->idorder) ?></div></th>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <th data-name="idorder_detail" class="<?= $Page->idorder_detail->headerCellClass() ?>"><div id="elh_deliveryorder_detail_idorder_detail" class="deliveryorder_detail_idorder_detail"><?= $Page->renderSort($Page->idorder_detail) ?></div></th>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
        <th data-name="totalorder" class="<?= $Page->totalorder->headerCellClass() ?>"><div id="elh_deliveryorder_detail_totalorder" class="deliveryorder_detail_totalorder"><?= $Page->renderSort($Page->totalorder) ?></div></th>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <th data-name="sisa" class="<?= $Page->sisa->headerCellClass() ?>"><div id="elh_deliveryorder_detail_sisa" class="deliveryorder_detail_sisa"><?= $Page->renderSort($Page->sisa) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <th data-name="jumlahkirim" class="<?= $Page->jumlahkirim->headerCellClass() ?>"><div id="elh_deliveryorder_detail_jumlahkirim" class="deliveryorder_detail_jumlahkirim"><?= $Page->renderSort($Page->jumlahkirim) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_deliveryorder_detail", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->idorder->Visible) { // idorder ?>
        <td data-name="idorder" <?= $Page->idorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <td data-name="idorder_detail" <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_idorder_detail">
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totalorder->Visible) { // totalorder ?>
        <td data-name="totalorder" <?= $Page->totalorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_totalorder">
<span<?= $Page->totalorder->viewAttributes() ?>>
<?= $Page->totalorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisa->Visible) { // sisa ?>
        <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim" <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_deliveryorder_detail_jumlahkirim">
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
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
    ew.addEventHandlers("deliveryorder_detail");
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
        container: "gmp_deliveryorder_detail",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
