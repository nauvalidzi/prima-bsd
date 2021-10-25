<?php

namespace PHPMaker2021\distributor;

// Page object
$VPiutangDetailList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_piutang_detaillist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fv_piutang_detaillist = currentForm = new ew.Form("fv_piutang_detaillist", "list");
    fv_piutang_detaillist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fv_piutang_detaillist");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "v_piutang") {
    if ($Page->MasterRecordExists) {
        include_once "views/VPiutangMaster.php";
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_piutang_detail">
<form name="fv_piutang_detaillist" id="fv_piutang_detaillist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_piutang_detail">
<?php if ($Page->getCurrentMasterTable() == "v_piutang" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="v_piutang">
<input type="hidden" name="fk_idcustomer" value="<?= HtmlEncode($Page->idcustomer->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_v_piutang_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_v_piutang_detaillist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
        <th data-name="tglinvoice" class="<?= $Page->tglinvoice->headerCellClass() ?>"><div id="elh_v_piutang_detail_tglinvoice" class="v_piutang_detail_tglinvoice"><?= $Page->renderSort($Page->tglinvoice) ?></div></th>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <th data-name="sisabayar" class="<?= $Page->sisabayar->headerCellClass() ?>"><div id="elh_v_piutang_detail_sisabayar" class="v_piutang_detail_sisabayar"><?= $Page->renderSort($Page->sisabayar) ?></div></th>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <th data-name="totaltagihan" class="<?= $Page->totaltagihan->headerCellClass() ?>"><div id="elh_v_piutang_detail_totaltagihan" class="v_piutang_detail_totaltagihan"><?= $Page->renderSort($Page->totaltagihan) ?></div></th>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { // jatuhtempo ?>
        <th data-name="jatuhtempo" class="<?= $Page->jatuhtempo->headerCellClass() ?>"><div id="elh_v_piutang_detail_jatuhtempo" class="v_piutang_detail_jatuhtempo"><?= $Page->renderSort($Page->jatuhtempo) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_v_piutang_detail", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
        <td data-name="tglinvoice" <?= $Page->tglinvoice->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_piutang_detail_tglinvoice">
<span<?= $Page->tglinvoice->viewAttributes() ?>>
<?= $Page->tglinvoice->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <td data-name="sisabayar" <?= $Page->sisabayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_piutang_detail_sisabayar">
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan" <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_piutang_detail_totaltagihan">
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jatuhtempo->Visible) { // jatuhtempo ?>
        <td data-name="jatuhtempo" <?= $Page->jatuhtempo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_piutang_detail_jatuhtempo">
<span<?= $Page->jatuhtempo->viewAttributes() ?>>
<?= $Page->jatuhtempo->getViewValue() ?></span>
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
    ew.addEventHandlers("v_piutang_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
