<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("NpdDesainGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_desaingrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnpd_desaingrid = new ew.Form("fnpd_desaingrid", "grid");
    fnpd_desaingrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_desain")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_desain)
        ew.vars.tables.npd_desain = currentTable;
    fnpd_desaingrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null, ew.Validators.integer], fields.idcustomer.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["tanggal_terima", [fields.tanggal_terima.visible && fields.tanggal_terima.required ? ew.Validators.required(fields.tanggal_terima.caption) : null, ew.Validators.datetime(0)], fields.tanggal_terima.isInvalid],
        ["tanggal_submit", [fields.tanggal_submit.visible && fields.tanggal_submit.required ? ew.Validators.required(fields.tanggal_submit.caption) : null, ew.Validators.datetime(0)], fields.tanggal_submit.isInvalid],
        ["nama_produk", [fields.nama_produk.visible && fields.nama_produk.required ? ew.Validators.required(fields.nama_produk.caption) : null], fields.nama_produk.isInvalid],
        ["klaim_bahan", [fields.klaim_bahan.visible && fields.klaim_bahan.required ? ew.Validators.required(fields.klaim_bahan.caption) : null], fields.klaim_bahan.isInvalid],
        ["campaign_produk", [fields.campaign_produk.visible && fields.campaign_produk.required ? ew.Validators.required(fields.campaign_produk.caption) : null], fields.campaign_produk.isInvalid],
        ["konsep", [fields.konsep.visible && fields.konsep.required ? ew.Validators.required(fields.konsep.caption) : null], fields.konsep.isInvalid],
        ["tema_warna", [fields.tema_warna.visible && fields.tema_warna.required ? ew.Validators.required(fields.tema_warna.caption) : null], fields.tema_warna.isInvalid],
        ["no_notifikasi", [fields.no_notifikasi.visible && fields.no_notifikasi.required ? ew.Validators.required(fields.no_notifikasi.caption) : null], fields.no_notifikasi.isInvalid],
        ["jenis_kemasan", [fields.jenis_kemasan.visible && fields.jenis_kemasan.required ? ew.Validators.required(fields.jenis_kemasan.caption) : null], fields.jenis_kemasan.isInvalid],
        ["posisi_label", [fields.posisi_label.visible && fields.posisi_label.required ? ew.Validators.required(fields.posisi_label.caption) : null], fields.posisi_label.isInvalid],
        ["bahan_label", [fields.bahan_label.visible && fields.bahan_label.required ? ew.Validators.required(fields.bahan_label.caption) : null], fields.bahan_label.isInvalid],
        ["draft_layout", [fields.draft_layout.visible && fields.draft_layout.required ? ew.Validators.required(fields.draft_layout.caption) : null], fields.draft_layout.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_desaingrid,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fnpd_desaingrid.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fnpd_desaingrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idcustomer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tanggal_terima", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tanggal_submit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama_produk", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "klaim_bahan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "campaign_produk", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "konsep", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tema_warna", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "no_notifikasi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jenis_kemasan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "posisi_label", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bahan_label", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "draft_layout", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_at", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnpd_desaingrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_desaingrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnpd_desaingrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_desain">
<div id="fnpd_desaingrid" class="ew-form ew-list-form form-inline">
<div id="gmp_npd_desain" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_npd_desaingrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_npd_desain_idnpd" class="npd_desain_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Grid->idcustomer->headerCellClass() ?>"><div id="elh_npd_desain_idcustomer" class="npd_desain_idcustomer"><?= $Grid->renderSort($Grid->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_npd_desain_status" class="npd_desain_status"><?= $Grid->renderSort($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->tanggal_terima->Visible) { // tanggal_terima ?>
        <th data-name="tanggal_terima" class="<?= $Grid->tanggal_terima->headerCellClass() ?>"><div id="elh_npd_desain_tanggal_terima" class="npd_desain_tanggal_terima"><?= $Grid->renderSort($Grid->tanggal_terima) ?></div></th>
<?php } ?>
<?php if ($Grid->tanggal_submit->Visible) { // tanggal_submit ?>
        <th data-name="tanggal_submit" class="<?= $Grid->tanggal_submit->headerCellClass() ?>"><div id="elh_npd_desain_tanggal_submit" class="npd_desain_tanggal_submit"><?= $Grid->renderSort($Grid->tanggal_submit) ?></div></th>
<?php } ?>
<?php if ($Grid->nama_produk->Visible) { // nama_produk ?>
        <th data-name="nama_produk" class="<?= $Grid->nama_produk->headerCellClass() ?>"><div id="elh_npd_desain_nama_produk" class="npd_desain_nama_produk"><?= $Grid->renderSort($Grid->nama_produk) ?></div></th>
<?php } ?>
<?php if ($Grid->klaim_bahan->Visible) { // klaim_bahan ?>
        <th data-name="klaim_bahan" class="<?= $Grid->klaim_bahan->headerCellClass() ?>"><div id="elh_npd_desain_klaim_bahan" class="npd_desain_klaim_bahan"><?= $Grid->renderSort($Grid->klaim_bahan) ?></div></th>
<?php } ?>
<?php if ($Grid->campaign_produk->Visible) { // campaign_produk ?>
        <th data-name="campaign_produk" class="<?= $Grid->campaign_produk->headerCellClass() ?>"><div id="elh_npd_desain_campaign_produk" class="npd_desain_campaign_produk"><?= $Grid->renderSort($Grid->campaign_produk) ?></div></th>
<?php } ?>
<?php if ($Grid->konsep->Visible) { // konsep ?>
        <th data-name="konsep" class="<?= $Grid->konsep->headerCellClass() ?>"><div id="elh_npd_desain_konsep" class="npd_desain_konsep"><?= $Grid->renderSort($Grid->konsep) ?></div></th>
<?php } ?>
<?php if ($Grid->tema_warna->Visible) { // tema_warna ?>
        <th data-name="tema_warna" class="<?= $Grid->tema_warna->headerCellClass() ?>"><div id="elh_npd_desain_tema_warna" class="npd_desain_tema_warna"><?= $Grid->renderSort($Grid->tema_warna) ?></div></th>
<?php } ?>
<?php if ($Grid->no_notifikasi->Visible) { // no_notifikasi ?>
        <th data-name="no_notifikasi" class="<?= $Grid->no_notifikasi->headerCellClass() ?>"><div id="elh_npd_desain_no_notifikasi" class="npd_desain_no_notifikasi"><?= $Grid->renderSort($Grid->no_notifikasi) ?></div></th>
<?php } ?>
<?php if ($Grid->jenis_kemasan->Visible) { // jenis_kemasan ?>
        <th data-name="jenis_kemasan" class="<?= $Grid->jenis_kemasan->headerCellClass() ?>"><div id="elh_npd_desain_jenis_kemasan" class="npd_desain_jenis_kemasan"><?= $Grid->renderSort($Grid->jenis_kemasan) ?></div></th>
<?php } ?>
<?php if ($Grid->posisi_label->Visible) { // posisi_label ?>
        <th data-name="posisi_label" class="<?= $Grid->posisi_label->headerCellClass() ?>"><div id="elh_npd_desain_posisi_label" class="npd_desain_posisi_label"><?= $Grid->renderSort($Grid->posisi_label) ?></div></th>
<?php } ?>
<?php if ($Grid->bahan_label->Visible) { // bahan_label ?>
        <th data-name="bahan_label" class="<?= $Grid->bahan_label->headerCellClass() ?>"><div id="elh_npd_desain_bahan_label" class="npd_desain_bahan_label"><?= $Grid->renderSort($Grid->bahan_label) ?></div></th>
<?php } ?>
<?php if ($Grid->draft_layout->Visible) { // draft_layout ?>
        <th data-name="draft_layout" class="<?= $Grid->draft_layout->headerCellClass() ?>"><div id="elh_npd_desain_draft_layout" class="npd_desain_draft_layout"><?= $Grid->renderSort($Grid->draft_layout) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_npd_desain_created_at" class="npd_desain_created_at"><?= $Grid->renderSort($Grid->created_at) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_npd_desain", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Grid->idnpd->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_desain" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_desain" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_idnpd" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_idnpd" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Grid->idcustomer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idcustomer" class="form-group">
<input type="<?= $Grid->idcustomer->getInputTextType() ?>" data-table="npd_desain" data-field="x_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" size="30" placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>" value="<?= $Grid->idcustomer->EditValue ?>"<?= $Grid->idcustomer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idcustomer->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idcustomer" class="form-group">
<input type="<?= $Grid->idcustomer->getInputTextType() ?>" data-table="npd_desain" data-field="x_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" size="30" placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>" value="<?= $Grid->idcustomer->EditValue ?>"<?= $Grid->idcustomer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idcustomer->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<?= $Grid->idcustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_idcustomer" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_idcustomer" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_idcustomer" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_idcustomer" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status" <?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="npd_desain" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="npd_desain" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_status" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_status" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_status" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_status" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_terima->Visible) { // tanggal_terima ?>
        <td data-name="tanggal_terima" <?= $Grid->tanggal_terima->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tanggal_terima" class="form-group">
<input type="<?= $Grid->tanggal_terima->getInputTextType() ?>" data-table="npd_desain" data-field="x_tanggal_terima" name="x<?= $Grid->RowIndex ?>_tanggal_terima" id="x<?= $Grid->RowIndex ?>_tanggal_terima" placeholder="<?= HtmlEncode($Grid->tanggal_terima->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_terima->EditValue ?>"<?= $Grid->tanggal_terima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_terima->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_terima->ReadOnly && !$Grid->tanggal_terima->Disabled && !isset($Grid->tanggal_terima->EditAttrs["readonly"]) && !isset($Grid->tanggal_terima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tanggal_terima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_terima" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_terima" id="o<?= $Grid->RowIndex ?>_tanggal_terima" value="<?= HtmlEncode($Grid->tanggal_terima->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tanggal_terima" class="form-group">
<input type="<?= $Grid->tanggal_terima->getInputTextType() ?>" data-table="npd_desain" data-field="x_tanggal_terima" name="x<?= $Grid->RowIndex ?>_tanggal_terima" id="x<?= $Grid->RowIndex ?>_tanggal_terima" placeholder="<?= HtmlEncode($Grid->tanggal_terima->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_terima->EditValue ?>"<?= $Grid->tanggal_terima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_terima->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_terima->ReadOnly && !$Grid->tanggal_terima->Disabled && !isset($Grid->tanggal_terima->EditAttrs["readonly"]) && !isset($Grid->tanggal_terima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tanggal_terima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tanggal_terima">
<span<?= $Grid->tanggal_terima->viewAttributes() ?>>
<?= $Grid->tanggal_terima->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_terima" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tanggal_terima" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tanggal_terima" value="<?= HtmlEncode($Grid->tanggal_terima->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_terima" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tanggal_terima" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tanggal_terima" value="<?= HtmlEncode($Grid->tanggal_terima->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_submit->Visible) { // tanggal_submit ?>
        <td data-name="tanggal_submit" <?= $Grid->tanggal_submit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tanggal_submit" class="form-group">
<input type="<?= $Grid->tanggal_submit->getInputTextType() ?>" data-table="npd_desain" data-field="x_tanggal_submit" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" placeholder="<?= HtmlEncode($Grid->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_submit->EditValue ?>"<?= $Grid->tanggal_submit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_submit->ReadOnly && !$Grid->tanggal_submit->Disabled && !isset($Grid->tanggal_submit->EditAttrs["readonly"]) && !isset($Grid->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_submit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_submit" id="o<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tanggal_submit" class="form-group">
<input type="<?= $Grid->tanggal_submit->getInputTextType() ?>" data-table="npd_desain" data-field="x_tanggal_submit" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" placeholder="<?= HtmlEncode($Grid->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_submit->EditValue ?>"<?= $Grid->tanggal_submit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_submit->ReadOnly && !$Grid->tanggal_submit->Disabled && !isset($Grid->tanggal_submit->EditAttrs["readonly"]) && !isset($Grid->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tanggal_submit">
<span<?= $Grid->tanggal_submit->viewAttributes() ?>>
<?= $Grid->tanggal_submit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_submit" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tanggal_submit" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_submit" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tanggal_submit" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama_produk->Visible) { // nama_produk ?>
        <td data-name="nama_produk" <?= $Grid->nama_produk->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_nama_produk" class="form-group">
<input type="<?= $Grid->nama_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_nama_produk" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_produk->getPlaceHolder()) ?>" value="<?= $Grid->nama_produk->EditValue ?>"<?= $Grid->nama_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_produk->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_produk" id="o<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_nama_produk" class="form-group">
<input type="<?= $Grid->nama_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_nama_produk" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_produk->getPlaceHolder()) ?>" value="<?= $Grid->nama_produk->EditValue ?>"<?= $Grid->nama_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_produk->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_nama_produk">
<span<?= $Grid->nama_produk->viewAttributes() ?>>
<?= $Grid->nama_produk->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_nama_produk" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_nama_produk" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->klaim_bahan->Visible) { // klaim_bahan ?>
        <td data-name="klaim_bahan" <?= $Grid->klaim_bahan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_klaim_bahan" class="form-group">
<input type="<?= $Grid->klaim_bahan->getInputTextType() ?>" data-table="npd_desain" data-field="x_klaim_bahan" name="x<?= $Grid->RowIndex ?>_klaim_bahan" id="x<?= $Grid->RowIndex ?>_klaim_bahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->klaim_bahan->getPlaceHolder()) ?>" value="<?= $Grid->klaim_bahan->EditValue ?>"<?= $Grid->klaim_bahan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->klaim_bahan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_klaim_bahan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_klaim_bahan" id="o<?= $Grid->RowIndex ?>_klaim_bahan" value="<?= HtmlEncode($Grid->klaim_bahan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_klaim_bahan" class="form-group">
<input type="<?= $Grid->klaim_bahan->getInputTextType() ?>" data-table="npd_desain" data-field="x_klaim_bahan" name="x<?= $Grid->RowIndex ?>_klaim_bahan" id="x<?= $Grid->RowIndex ?>_klaim_bahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->klaim_bahan->getPlaceHolder()) ?>" value="<?= $Grid->klaim_bahan->EditValue ?>"<?= $Grid->klaim_bahan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->klaim_bahan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_klaim_bahan">
<span<?= $Grid->klaim_bahan->viewAttributes() ?>>
<?= $Grid->klaim_bahan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_klaim_bahan" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_klaim_bahan" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_klaim_bahan" value="<?= HtmlEncode($Grid->klaim_bahan->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_klaim_bahan" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_klaim_bahan" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_klaim_bahan" value="<?= HtmlEncode($Grid->klaim_bahan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->campaign_produk->Visible) { // campaign_produk ?>
        <td data-name="campaign_produk" <?= $Grid->campaign_produk->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_campaign_produk" class="form-group">
<input type="<?= $Grid->campaign_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_campaign_produk" name="x<?= $Grid->RowIndex ?>_campaign_produk" id="x<?= $Grid->RowIndex ?>_campaign_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->campaign_produk->getPlaceHolder()) ?>" value="<?= $Grid->campaign_produk->EditValue ?>"<?= $Grid->campaign_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->campaign_produk->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_campaign_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_campaign_produk" id="o<?= $Grid->RowIndex ?>_campaign_produk" value="<?= HtmlEncode($Grid->campaign_produk->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_campaign_produk" class="form-group">
<input type="<?= $Grid->campaign_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_campaign_produk" name="x<?= $Grid->RowIndex ?>_campaign_produk" id="x<?= $Grid->RowIndex ?>_campaign_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->campaign_produk->getPlaceHolder()) ?>" value="<?= $Grid->campaign_produk->EditValue ?>"<?= $Grid->campaign_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->campaign_produk->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_campaign_produk">
<span<?= $Grid->campaign_produk->viewAttributes() ?>>
<?= $Grid->campaign_produk->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_campaign_produk" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_campaign_produk" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_campaign_produk" value="<?= HtmlEncode($Grid->campaign_produk->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_campaign_produk" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_campaign_produk" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_campaign_produk" value="<?= HtmlEncode($Grid->campaign_produk->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->konsep->Visible) { // konsep ?>
        <td data-name="konsep" <?= $Grid->konsep->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_konsep" class="form-group">
<input type="<?= $Grid->konsep->getInputTextType() ?>" data-table="npd_desain" data-field="x_konsep" name="x<?= $Grid->RowIndex ?>_konsep" id="x<?= $Grid->RowIndex ?>_konsep" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->konsep->getPlaceHolder()) ?>" value="<?= $Grid->konsep->EditValue ?>"<?= $Grid->konsep->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->konsep->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_konsep" data-hidden="1" name="o<?= $Grid->RowIndex ?>_konsep" id="o<?= $Grid->RowIndex ?>_konsep" value="<?= HtmlEncode($Grid->konsep->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_konsep" class="form-group">
<input type="<?= $Grid->konsep->getInputTextType() ?>" data-table="npd_desain" data-field="x_konsep" name="x<?= $Grid->RowIndex ?>_konsep" id="x<?= $Grid->RowIndex ?>_konsep" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->konsep->getPlaceHolder()) ?>" value="<?= $Grid->konsep->EditValue ?>"<?= $Grid->konsep->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->konsep->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_konsep">
<span<?= $Grid->konsep->viewAttributes() ?>>
<?= $Grid->konsep->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_konsep" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_konsep" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_konsep" value="<?= HtmlEncode($Grid->konsep->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_konsep" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_konsep" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_konsep" value="<?= HtmlEncode($Grid->konsep->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tema_warna->Visible) { // tema_warna ?>
        <td data-name="tema_warna" <?= $Grid->tema_warna->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tema_warna" class="form-group">
<input type="<?= $Grid->tema_warna->getInputTextType() ?>" data-table="npd_desain" data-field="x_tema_warna" name="x<?= $Grid->RowIndex ?>_tema_warna" id="x<?= $Grid->RowIndex ?>_tema_warna" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->tema_warna->getPlaceHolder()) ?>" value="<?= $Grid->tema_warna->EditValue ?>"<?= $Grid->tema_warna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tema_warna->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tema_warna" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tema_warna" id="o<?= $Grid->RowIndex ?>_tema_warna" value="<?= HtmlEncode($Grid->tema_warna->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tema_warna" class="form-group">
<input type="<?= $Grid->tema_warna->getInputTextType() ?>" data-table="npd_desain" data-field="x_tema_warna" name="x<?= $Grid->RowIndex ?>_tema_warna" id="x<?= $Grid->RowIndex ?>_tema_warna" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->tema_warna->getPlaceHolder()) ?>" value="<?= $Grid->tema_warna->EditValue ?>"<?= $Grid->tema_warna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tema_warna->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tema_warna">
<span<?= $Grid->tema_warna->viewAttributes() ?>>
<?= $Grid->tema_warna->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_tema_warna" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tema_warna" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tema_warna" value="<?= HtmlEncode($Grid->tema_warna->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_tema_warna" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tema_warna" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tema_warna" value="<?= HtmlEncode($Grid->tema_warna->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->no_notifikasi->Visible) { // no_notifikasi ?>
        <td data-name="no_notifikasi" <?= $Grid->no_notifikasi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_no_notifikasi" class="form-group">
<input type="<?= $Grid->no_notifikasi->getInputTextType() ?>" data-table="npd_desain" data-field="x_no_notifikasi" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->no_notifikasi->getPlaceHolder()) ?>" value="<?= $Grid->no_notifikasi->EditValue ?>"<?= $Grid->no_notifikasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->no_notifikasi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_no_notifikasi" id="o<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_no_notifikasi" class="form-group">
<input type="<?= $Grid->no_notifikasi->getInputTextType() ?>" data-table="npd_desain" data-field="x_no_notifikasi" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->no_notifikasi->getPlaceHolder()) ?>" value="<?= $Grid->no_notifikasi->EditValue ?>"<?= $Grid->no_notifikasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->no_notifikasi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_no_notifikasi">
<span<?= $Grid->no_notifikasi->viewAttributes() ?>>
<?= $Grid->no_notifikasi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_no_notifikasi" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_no_notifikasi" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jenis_kemasan->Visible) { // jenis_kemasan ?>
        <td data-name="jenis_kemasan" <?= $Grid->jenis_kemasan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_jenis_kemasan" class="form-group">
<input type="<?= $Grid->jenis_kemasan->getInputTextType() ?>" data-table="npd_desain" data-field="x_jenis_kemasan" name="x<?= $Grid->RowIndex ?>_jenis_kemasan" id="x<?= $Grid->RowIndex ?>_jenis_kemasan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->jenis_kemasan->getPlaceHolder()) ?>" value="<?= $Grid->jenis_kemasan->EditValue ?>"<?= $Grid->jenis_kemasan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_kemasan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_jenis_kemasan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jenis_kemasan" id="o<?= $Grid->RowIndex ?>_jenis_kemasan" value="<?= HtmlEncode($Grid->jenis_kemasan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_jenis_kemasan" class="form-group">
<input type="<?= $Grid->jenis_kemasan->getInputTextType() ?>" data-table="npd_desain" data-field="x_jenis_kemasan" name="x<?= $Grid->RowIndex ?>_jenis_kemasan" id="x<?= $Grid->RowIndex ?>_jenis_kemasan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->jenis_kemasan->getPlaceHolder()) ?>" value="<?= $Grid->jenis_kemasan->EditValue ?>"<?= $Grid->jenis_kemasan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_kemasan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_jenis_kemasan">
<span<?= $Grid->jenis_kemasan->viewAttributes() ?>>
<?= $Grid->jenis_kemasan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_jenis_kemasan" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_jenis_kemasan" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_jenis_kemasan" value="<?= HtmlEncode($Grid->jenis_kemasan->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_jenis_kemasan" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_jenis_kemasan" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_jenis_kemasan" value="<?= HtmlEncode($Grid->jenis_kemasan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->posisi_label->Visible) { // posisi_label ?>
        <td data-name="posisi_label" <?= $Grid->posisi_label->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_posisi_label" class="form-group">
<input type="<?= $Grid->posisi_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_posisi_label" name="x<?= $Grid->RowIndex ?>_posisi_label" id="x<?= $Grid->RowIndex ?>_posisi_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->posisi_label->getPlaceHolder()) ?>" value="<?= $Grid->posisi_label->EditValue ?>"<?= $Grid->posisi_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->posisi_label->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_posisi_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_posisi_label" id="o<?= $Grid->RowIndex ?>_posisi_label" value="<?= HtmlEncode($Grid->posisi_label->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_posisi_label" class="form-group">
<input type="<?= $Grid->posisi_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_posisi_label" name="x<?= $Grid->RowIndex ?>_posisi_label" id="x<?= $Grid->RowIndex ?>_posisi_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->posisi_label->getPlaceHolder()) ?>" value="<?= $Grid->posisi_label->EditValue ?>"<?= $Grid->posisi_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->posisi_label->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_posisi_label">
<span<?= $Grid->posisi_label->viewAttributes() ?>>
<?= $Grid->posisi_label->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_posisi_label" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_posisi_label" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_posisi_label" value="<?= HtmlEncode($Grid->posisi_label->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_posisi_label" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_posisi_label" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_posisi_label" value="<?= HtmlEncode($Grid->posisi_label->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bahan_label->Visible) { // bahan_label ?>
        <td data-name="bahan_label" <?= $Grid->bahan_label->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_bahan_label" class="form-group">
<input type="<?= $Grid->bahan_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_bahan_label" name="x<?= $Grid->RowIndex ?>_bahan_label" id="x<?= $Grid->RowIndex ?>_bahan_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->bahan_label->getPlaceHolder()) ?>" value="<?= $Grid->bahan_label->EditValue ?>"<?= $Grid->bahan_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bahan_label->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_bahan_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bahan_label" id="o<?= $Grid->RowIndex ?>_bahan_label" value="<?= HtmlEncode($Grid->bahan_label->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_bahan_label" class="form-group">
<input type="<?= $Grid->bahan_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_bahan_label" name="x<?= $Grid->RowIndex ?>_bahan_label" id="x<?= $Grid->RowIndex ?>_bahan_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->bahan_label->getPlaceHolder()) ?>" value="<?= $Grid->bahan_label->EditValue ?>"<?= $Grid->bahan_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bahan_label->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_bahan_label">
<span<?= $Grid->bahan_label->viewAttributes() ?>>
<?= $Grid->bahan_label->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_bahan_label" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_bahan_label" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_bahan_label" value="<?= HtmlEncode($Grid->bahan_label->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_bahan_label" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_bahan_label" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_bahan_label" value="<?= HtmlEncode($Grid->bahan_label->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->draft_layout->Visible) { // draft_layout ?>
        <td data-name="draft_layout" <?= $Grid->draft_layout->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_draft_layout" class="form-group">
<input type="<?= $Grid->draft_layout->getInputTextType() ?>" data-table="npd_desain" data-field="x_draft_layout" name="x<?= $Grid->RowIndex ?>_draft_layout" id="x<?= $Grid->RowIndex ?>_draft_layout" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->draft_layout->getPlaceHolder()) ?>" value="<?= $Grid->draft_layout->EditValue ?>"<?= $Grid->draft_layout->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->draft_layout->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_draft_layout" data-hidden="1" name="o<?= $Grid->RowIndex ?>_draft_layout" id="o<?= $Grid->RowIndex ?>_draft_layout" value="<?= HtmlEncode($Grid->draft_layout->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_draft_layout" class="form-group">
<input type="<?= $Grid->draft_layout->getInputTextType() ?>" data-table="npd_desain" data-field="x_draft_layout" name="x<?= $Grid->RowIndex ?>_draft_layout" id="x<?= $Grid->RowIndex ?>_draft_layout" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->draft_layout->getPlaceHolder()) ?>" value="<?= $Grid->draft_layout->EditValue ?>"<?= $Grid->draft_layout->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->draft_layout->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_draft_layout">
<span<?= $Grid->draft_layout->viewAttributes() ?>>
<?= $Grid->draft_layout->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_draft_layout" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_draft_layout" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_draft_layout" value="<?= HtmlEncode($Grid->draft_layout->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_draft_layout" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_draft_layout" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_draft_layout" value="<?= HtmlEncode($Grid->draft_layout->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="npd_desain" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="npd_desain" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_created_at" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_created_at" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_created_at" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_created_at" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fnpd_desaingrid","load"], function () {
    fnpd_desaingrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_npd_desain", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el$rowindex$_npd_desain_idnpd" class="form-group npd_desain_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_npd_desain_idnpd" class="form-group npd_desain_idnpd">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_desain" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_idnpd" class="form-group npd_desain_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_idcustomer" class="form-group npd_desain_idcustomer">
<input type="<?= $Grid->idcustomer->getInputTextType() ?>" data-table="npd_desain" data-field="x_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" size="30" placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>" value="<?= $Grid->idcustomer->EditValue ?>"<?= $Grid->idcustomer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idcustomer->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_idcustomer" class="form-group npd_desain_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_status" class="form-group npd_desain_status">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="npd_desain" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_status" class="form-group npd_desain_status">
<span<?= $Grid->status->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status->getDisplayValue($Grid->status->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_terima->Visible) { // tanggal_terima ?>
        <td data-name="tanggal_terima">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_tanggal_terima" class="form-group npd_desain_tanggal_terima">
<input type="<?= $Grid->tanggal_terima->getInputTextType() ?>" data-table="npd_desain" data-field="x_tanggal_terima" name="x<?= $Grid->RowIndex ?>_tanggal_terima" id="x<?= $Grid->RowIndex ?>_tanggal_terima" placeholder="<?= HtmlEncode($Grid->tanggal_terima->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_terima->EditValue ?>"<?= $Grid->tanggal_terima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_terima->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_terima->ReadOnly && !$Grid->tanggal_terima->Disabled && !isset($Grid->tanggal_terima->EditAttrs["readonly"]) && !isset($Grid->tanggal_terima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tanggal_terima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_tanggal_terima" class="form-group npd_desain_tanggal_terima">
<span<?= $Grid->tanggal_terima->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal_terima->getDisplayValue($Grid->tanggal_terima->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_terima" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal_terima" id="x<?= $Grid->RowIndex ?>_tanggal_terima" value="<?= HtmlEncode($Grid->tanggal_terima->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_terima" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_terima" id="o<?= $Grid->RowIndex ?>_tanggal_terima" value="<?= HtmlEncode($Grid->tanggal_terima->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_submit->Visible) { // tanggal_submit ?>
        <td data-name="tanggal_submit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_tanggal_submit" class="form-group npd_desain_tanggal_submit">
<input type="<?= $Grid->tanggal_submit->getInputTextType() ?>" data-table="npd_desain" data-field="x_tanggal_submit" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" placeholder="<?= HtmlEncode($Grid->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_submit->EditValue ?>"<?= $Grid->tanggal_submit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_submit->ReadOnly && !$Grid->tanggal_submit->Disabled && !isset($Grid->tanggal_submit->EditAttrs["readonly"]) && !isset($Grid->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_tanggal_submit" class="form-group npd_desain_tanggal_submit">
<span<?= $Grid->tanggal_submit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal_submit->getDisplayValue($Grid->tanggal_submit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_submit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_tanggal_submit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_submit" id="o<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama_produk->Visible) { // nama_produk ?>
        <td data-name="nama_produk">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_nama_produk" class="form-group npd_desain_nama_produk">
<input type="<?= $Grid->nama_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_nama_produk" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_produk->getPlaceHolder()) ?>" value="<?= $Grid->nama_produk->EditValue ?>"<?= $Grid->nama_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_produk->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_nama_produk" class="form-group npd_desain_nama_produk">
<span<?= $Grid->nama_produk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama_produk->getDisplayValue($Grid->nama_produk->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_produk" id="o<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->klaim_bahan->Visible) { // klaim_bahan ?>
        <td data-name="klaim_bahan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_klaim_bahan" class="form-group npd_desain_klaim_bahan">
<input type="<?= $Grid->klaim_bahan->getInputTextType() ?>" data-table="npd_desain" data-field="x_klaim_bahan" name="x<?= $Grid->RowIndex ?>_klaim_bahan" id="x<?= $Grid->RowIndex ?>_klaim_bahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->klaim_bahan->getPlaceHolder()) ?>" value="<?= $Grid->klaim_bahan->EditValue ?>"<?= $Grid->klaim_bahan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->klaim_bahan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_klaim_bahan" class="form-group npd_desain_klaim_bahan">
<span<?= $Grid->klaim_bahan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->klaim_bahan->getDisplayValue($Grid->klaim_bahan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_klaim_bahan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_klaim_bahan" id="x<?= $Grid->RowIndex ?>_klaim_bahan" value="<?= HtmlEncode($Grid->klaim_bahan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_klaim_bahan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_klaim_bahan" id="o<?= $Grid->RowIndex ?>_klaim_bahan" value="<?= HtmlEncode($Grid->klaim_bahan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->campaign_produk->Visible) { // campaign_produk ?>
        <td data-name="campaign_produk">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_campaign_produk" class="form-group npd_desain_campaign_produk">
<input type="<?= $Grid->campaign_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_campaign_produk" name="x<?= $Grid->RowIndex ?>_campaign_produk" id="x<?= $Grid->RowIndex ?>_campaign_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->campaign_produk->getPlaceHolder()) ?>" value="<?= $Grid->campaign_produk->EditValue ?>"<?= $Grid->campaign_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->campaign_produk->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_campaign_produk" class="form-group npd_desain_campaign_produk">
<span<?= $Grid->campaign_produk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->campaign_produk->getDisplayValue($Grid->campaign_produk->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_campaign_produk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_campaign_produk" id="x<?= $Grid->RowIndex ?>_campaign_produk" value="<?= HtmlEncode($Grid->campaign_produk->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_campaign_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_campaign_produk" id="o<?= $Grid->RowIndex ?>_campaign_produk" value="<?= HtmlEncode($Grid->campaign_produk->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->konsep->Visible) { // konsep ?>
        <td data-name="konsep">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_konsep" class="form-group npd_desain_konsep">
<input type="<?= $Grid->konsep->getInputTextType() ?>" data-table="npd_desain" data-field="x_konsep" name="x<?= $Grid->RowIndex ?>_konsep" id="x<?= $Grid->RowIndex ?>_konsep" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->konsep->getPlaceHolder()) ?>" value="<?= $Grid->konsep->EditValue ?>"<?= $Grid->konsep->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->konsep->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_konsep" class="form-group npd_desain_konsep">
<span<?= $Grid->konsep->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->konsep->getDisplayValue($Grid->konsep->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_konsep" data-hidden="1" name="x<?= $Grid->RowIndex ?>_konsep" id="x<?= $Grid->RowIndex ?>_konsep" value="<?= HtmlEncode($Grid->konsep->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_konsep" data-hidden="1" name="o<?= $Grid->RowIndex ?>_konsep" id="o<?= $Grid->RowIndex ?>_konsep" value="<?= HtmlEncode($Grid->konsep->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tema_warna->Visible) { // tema_warna ?>
        <td data-name="tema_warna">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_tema_warna" class="form-group npd_desain_tema_warna">
<input type="<?= $Grid->tema_warna->getInputTextType() ?>" data-table="npd_desain" data-field="x_tema_warna" name="x<?= $Grid->RowIndex ?>_tema_warna" id="x<?= $Grid->RowIndex ?>_tema_warna" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->tema_warna->getPlaceHolder()) ?>" value="<?= $Grid->tema_warna->EditValue ?>"<?= $Grid->tema_warna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tema_warna->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_tema_warna" class="form-group npd_desain_tema_warna">
<span<?= $Grid->tema_warna->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tema_warna->getDisplayValue($Grid->tema_warna->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tema_warna" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tema_warna" id="x<?= $Grid->RowIndex ?>_tema_warna" value="<?= HtmlEncode($Grid->tema_warna->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_tema_warna" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tema_warna" id="o<?= $Grid->RowIndex ?>_tema_warna" value="<?= HtmlEncode($Grid->tema_warna->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->no_notifikasi->Visible) { // no_notifikasi ?>
        <td data-name="no_notifikasi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_no_notifikasi" class="form-group npd_desain_no_notifikasi">
<input type="<?= $Grid->no_notifikasi->getInputTextType() ?>" data-table="npd_desain" data-field="x_no_notifikasi" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->no_notifikasi->getPlaceHolder()) ?>" value="<?= $Grid->no_notifikasi->EditValue ?>"<?= $Grid->no_notifikasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->no_notifikasi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_no_notifikasi" class="form-group npd_desain_no_notifikasi">
<span<?= $Grid->no_notifikasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->no_notifikasi->getDisplayValue($Grid->no_notifikasi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_no_notifikasi" id="o<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jenis_kemasan->Visible) { // jenis_kemasan ?>
        <td data-name="jenis_kemasan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_jenis_kemasan" class="form-group npd_desain_jenis_kemasan">
<input type="<?= $Grid->jenis_kemasan->getInputTextType() ?>" data-table="npd_desain" data-field="x_jenis_kemasan" name="x<?= $Grid->RowIndex ?>_jenis_kemasan" id="x<?= $Grid->RowIndex ?>_jenis_kemasan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->jenis_kemasan->getPlaceHolder()) ?>" value="<?= $Grid->jenis_kemasan->EditValue ?>"<?= $Grid->jenis_kemasan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_kemasan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_jenis_kemasan" class="form-group npd_desain_jenis_kemasan">
<span<?= $Grid->jenis_kemasan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jenis_kemasan->getDisplayValue($Grid->jenis_kemasan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_jenis_kemasan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jenis_kemasan" id="x<?= $Grid->RowIndex ?>_jenis_kemasan" value="<?= HtmlEncode($Grid->jenis_kemasan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_jenis_kemasan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jenis_kemasan" id="o<?= $Grid->RowIndex ?>_jenis_kemasan" value="<?= HtmlEncode($Grid->jenis_kemasan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->posisi_label->Visible) { // posisi_label ?>
        <td data-name="posisi_label">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_posisi_label" class="form-group npd_desain_posisi_label">
<input type="<?= $Grid->posisi_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_posisi_label" name="x<?= $Grid->RowIndex ?>_posisi_label" id="x<?= $Grid->RowIndex ?>_posisi_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->posisi_label->getPlaceHolder()) ?>" value="<?= $Grid->posisi_label->EditValue ?>"<?= $Grid->posisi_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->posisi_label->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_posisi_label" class="form-group npd_desain_posisi_label">
<span<?= $Grid->posisi_label->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->posisi_label->getDisplayValue($Grid->posisi_label->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_posisi_label" data-hidden="1" name="x<?= $Grid->RowIndex ?>_posisi_label" id="x<?= $Grid->RowIndex ?>_posisi_label" value="<?= HtmlEncode($Grid->posisi_label->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_posisi_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_posisi_label" id="o<?= $Grid->RowIndex ?>_posisi_label" value="<?= HtmlEncode($Grid->posisi_label->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bahan_label->Visible) { // bahan_label ?>
        <td data-name="bahan_label">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_bahan_label" class="form-group npd_desain_bahan_label">
<input type="<?= $Grid->bahan_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_bahan_label" name="x<?= $Grid->RowIndex ?>_bahan_label" id="x<?= $Grid->RowIndex ?>_bahan_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->bahan_label->getPlaceHolder()) ?>" value="<?= $Grid->bahan_label->EditValue ?>"<?= $Grid->bahan_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bahan_label->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_bahan_label" class="form-group npd_desain_bahan_label">
<span<?= $Grid->bahan_label->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bahan_label->getDisplayValue($Grid->bahan_label->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_bahan_label" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bahan_label" id="x<?= $Grid->RowIndex ?>_bahan_label" value="<?= HtmlEncode($Grid->bahan_label->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_bahan_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bahan_label" id="o<?= $Grid->RowIndex ?>_bahan_label" value="<?= HtmlEncode($Grid->bahan_label->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->draft_layout->Visible) { // draft_layout ?>
        <td data-name="draft_layout">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_draft_layout" class="form-group npd_desain_draft_layout">
<input type="<?= $Grid->draft_layout->getInputTextType() ?>" data-table="npd_desain" data-field="x_draft_layout" name="x<?= $Grid->RowIndex ?>_draft_layout" id="x<?= $Grid->RowIndex ?>_draft_layout" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->draft_layout->getPlaceHolder()) ?>" value="<?= $Grid->draft_layout->EditValue ?>"<?= $Grid->draft_layout->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->draft_layout->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_draft_layout" class="form-group npd_desain_draft_layout">
<span<?= $Grid->draft_layout->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->draft_layout->getDisplayValue($Grid->draft_layout->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_draft_layout" data-hidden="1" name="x<?= $Grid->RowIndex ?>_draft_layout" id="x<?= $Grid->RowIndex ?>_draft_layout" value="<?= HtmlEncode($Grid->draft_layout->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_draft_layout" data-hidden="1" name="o<?= $Grid->RowIndex ?>_draft_layout" id="o<?= $Grid->RowIndex ?>_draft_layout" value="<?= HtmlEncode($Grid->draft_layout->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_created_at" class="form-group npd_desain_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="npd_desain" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_created_at" class="form-group npd_desain_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_at->getDisplayValue($Grid->created_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_created_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnpd_desaingrid","load"], function() {
    fnpd_desaingrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fnpd_desaingrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
