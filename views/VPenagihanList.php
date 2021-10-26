<?php

namespace PHPMaker2021\distributor;

// Page object
$VPenagihanList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_penagihanlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fv_penagihanlist = currentForm = new ew.Form("fv_penagihanlist", "list");
    fv_penagihanlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fv_penagihanlist");
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
    // Client script
    function checkSelected(){var e=$("input#check-all")[0],t=$("input#check-row").length,n=$("input#check-row:checked:checked").length;e.checked=n===t}$(".ew-list-other-options").append('<div class="ew-list-other-options"><span class="ew-add-edit-option ew-list-option-separator text-nowrap" data-name="button"><div class="btn-group btn-group-sm ew-btn-group"><button class="btn btn-default ew-add-edit ew-add send-reminder" title="" data-caption="Send" data-original-title="Send">Send</button></div></span></div>'),$(".send-reminder").on("click",(function(){var e=[];if($("input#check-row:checked:checked").each((function(t,n){e[t]=n.value})),e.length<1)return Swal.fire({icon:"error",title:"Oops...",text:"Pilih data terlebih dahulu!"}),!1;$.get("api/mass-send-reminder?items="+encodeURIComponent(e),(function(e){!1!==e.status?Swal.fire({icon:"success",title:"Success",text:"Data berhasil diproses!"}).then((function(){location.reload()})):Swal.fire({icon:"error",title:"Oops...",text:"Something went wrong!"}).then((function(){location.reload()}))}))})),$(document).on("click","input#check-all",(function(){var e=this.checked;$("input#check-row").each((function(t,n){n.checked=e}))})),$(document).on("click","#check-row",(function(){this.value;checkSelected()}));
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
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_penagihan">
<form name="fv_penagihanlist" id="fv_penagihanlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_penagihan">
<div id="gmp_v_penagihan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_v_penagihanlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="tgl_order" class="<?= $Page->tgl_order->headerCellClass() ?>"><div id="elh_v_penagihan_tgl_order" class="v_penagihan_tgl_order"><?= $Page->renderSort($Page->tgl_order) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_reminder->Visible) { // tgl_reminder ?>
        <th data-name="tgl_reminder" class="<?= $Page->tgl_reminder->headerCellClass() ?>"><div id="elh_v_penagihan_tgl_reminder" class="v_penagihan_tgl_reminder"><?= $Page->renderSort($Page->tgl_reminder) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_normalbilling->Visible) { // tgl_normalbilling ?>
        <th data-name="tgl_normalbilling" class="<?= $Page->tgl_normalbilling->headerCellClass() ?>"><div id="elh_v_penagihan_tgl_normalbilling" class="v_penagihan_tgl_normalbilling"><?= $Page->renderSort($Page->tgl_normalbilling) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_jatuhtempo->Visible) { // tgl_jatuhtempo ?>
        <th data-name="tgl_jatuhtempo" class="<?= $Page->tgl_jatuhtempo->headerCellClass() ?>"><div id="elh_v_penagihan_tgl_jatuhtempo" class="v_penagihan_tgl_jatuhtempo"><?= $Page->renderSort($Page->tgl_jatuhtempo) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_intensbilling->Visible) { // tgl_intensbilling ?>
        <th data-name="tgl_intensbilling" class="<?= $Page->tgl_intensbilling->headerCellClass() ?>"><div id="elh_v_penagihan_tgl_intensbilling" class="v_penagihan_tgl_intensbilling"><?= $Page->renderSort($Page->tgl_intensbilling) ?></div></th>
<?php } ?>
<?php if ($Page->tgl_actionplan->Visible) { // tgl_actionplan ?>
        <th data-name="tgl_actionplan" class="<?= $Page->tgl_actionplan->headerCellClass() ?>"><div id="elh_v_penagihan_tgl_actionplan" class="v_penagihan_tgl_actionplan"><?= $Page->renderSort($Page->tgl_actionplan) ?></div></th>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <th data-name="kodeorder" class="<?= $Page->kodeorder->headerCellClass() ?>"><div id="elh_v_penagihan_kodeorder" class="v_penagihan_kodeorder"><?= $Page->renderSort($Page->kodeorder) ?></div></th>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <th data-name="nama_customer" class="<?= $Page->nama_customer->headerCellClass() ?>"><div id="elh_v_penagihan_nama_customer" class="v_penagihan_nama_customer"><?= $Page->renderSort($Page->nama_customer) ?></div></th>
<?php } ?>
<?php if ($Page->nominal->Visible) { // nominal ?>
        <th data-name="nominal" class="<?= $Page->nominal->headerCellClass() ?>"><div id="elh_v_penagihan_nominal" class="v_penagihan_nominal"><?= $Page->renderSort($Page->nominal) ?></div></th>
<?php } ?>
<?php if ($Page->nilai_po->Visible) { // nilai_po ?>
        <th data-name="nilai_po" class="<?= $Page->nilai_po->headerCellClass() ?>"><div id="elh_v_penagihan_nilai_po" class="v_penagihan_nilai_po"><?= $Page->renderSort($Page->nilai_po) ?></div></th>
<?php } ?>
<?php if ($Page->pembayaran->Visible) { // pembayaran ?>
        <th data-name="pembayaran" class="<?= $Page->pembayaran->headerCellClass() ?>"><div id="elh_v_penagihan_pembayaran" class="v_penagihan_pembayaran"><?= $Page->renderSort($Page->pembayaran) ?></div></th>
<?php } ?>
<?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
        <th data-name="nilai_faktur" class="<?= $Page->nilai_faktur->headerCellClass() ?>"><div id="elh_v_penagihan_nilai_faktur" class="v_penagihan_nilai_faktur"><?= $Page->renderSort($Page->nilai_faktur) ?></div></th>
<?php } ?>
<?php if ($Page->piutang->Visible) { // piutang ?>
        <th data-name="piutang" class="<?= $Page->piutang->headerCellClass() ?>"><div id="elh_v_penagihan_piutang" class="v_penagihan_piutang"><?= $Page->renderSort($Page->piutang) ?></div></th>
<?php } ?>
<?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
        <th data-name="nomor_handphone" class="<?= $Page->nomor_handphone->headerCellClass() ?>"><div id="elh_v_penagihan_nomor_handphone" class="v_penagihan_nomor_handphone"><?= $Page->renderSort($Page->nomor_handphone) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_v_penagihan", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_v_penagihan_tgl_order">
<span<?= $Page->tgl_order->viewAttributes() ?>>
<?= $Page->tgl_order->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_reminder->Visible) { // tgl_reminder ?>
        <td data-name="tgl_reminder" <?= $Page->tgl_reminder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_tgl_reminder">
<span<?= $Page->tgl_reminder->viewAttributes() ?>>
<?= $Page->tgl_reminder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_normalbilling->Visible) { // tgl_normalbilling ?>
        <td data-name="tgl_normalbilling" <?= $Page->tgl_normalbilling->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_tgl_normalbilling">
<span<?= $Page->tgl_normalbilling->viewAttributes() ?>>
<?= $Page->tgl_normalbilling->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_jatuhtempo->Visible) { // tgl_jatuhtempo ?>
        <td data-name="tgl_jatuhtempo" <?= $Page->tgl_jatuhtempo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_tgl_jatuhtempo">
<span<?= $Page->tgl_jatuhtempo->viewAttributes() ?>>
<?= $Page->tgl_jatuhtempo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_intensbilling->Visible) { // tgl_intensbilling ?>
        <td data-name="tgl_intensbilling" <?= $Page->tgl_intensbilling->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_tgl_intensbilling">
<span<?= $Page->tgl_intensbilling->viewAttributes() ?>>
<?= $Page->tgl_intensbilling->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tgl_actionplan->Visible) { // tgl_actionplan ?>
        <td data-name="tgl_actionplan" <?= $Page->tgl_actionplan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_tgl_actionplan">
<span<?= $Page->tgl_actionplan->viewAttributes() ?>>
<?= $Page->tgl_actionplan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <td data-name="kodeorder" <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <td data-name="nama_customer" <?= $Page->nama_customer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_nama_customer">
<span<?= $Page->nama_customer->viewAttributes() ?>>
<?= $Page->nama_customer->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nominal->Visible) { // nominal ?>
        <td data-name="nominal" <?= $Page->nominal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_nominal">
<span<?= $Page->nominal->viewAttributes() ?>>
<?= $Page->nominal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nilai_po->Visible) { // nilai_po ?>
        <td data-name="nilai_po" <?= $Page->nilai_po->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_nilai_po">
<span<?= $Page->nilai_po->viewAttributes() ?>>
<?= $Page->nilai_po->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pembayaran->Visible) { // pembayaran ?>
        <td data-name="pembayaran" <?= $Page->pembayaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_pembayaran">
<span<?= $Page->pembayaran->viewAttributes() ?>>
<?= $Page->pembayaran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
        <td data-name="nilai_faktur" <?= $Page->nilai_faktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_nilai_faktur">
<span<?= $Page->nilai_faktur->viewAttributes() ?>>
<?= $Page->nilai_faktur->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->piutang->Visible) { // piutang ?>
        <td data-name="piutang" <?= $Page->piutang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_piutang">
<span<?= $Page->piutang->viewAttributes() ?>>
<?= $Page->piutang->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
        <td data-name="nomor_handphone" <?= $Page->nomor_handphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_v_penagihan_nomor_handphone">
<span<?= $Page->nomor_handphone->viewAttributes() ?>>
<?= $Page->nomor_handphone->getViewValue() ?></span>
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
    ew.addEventHandlers("v_penagihan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
