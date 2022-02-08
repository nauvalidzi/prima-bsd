<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("IjinhakiStatusGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinhaki_statusgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fijinhaki_statusgrid = new ew.Form("fijinhaki_statusgrid", "grid");
    fijinhaki_statusgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinhaki_status")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinhaki_status)
        ew.vars.tables.ijinhaki_status = currentTable;
    fijinhaki_statusgrid.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["targetmulai", [fields.targetmulai.visible && fields.targetmulai.required ? ew.Validators.required(fields.targetmulai.caption) : null, ew.Validators.datetime(0)], fields.targetmulai.isInvalid],
        ["tglmulai", [fields.tglmulai.visible && fields.tglmulai.required ? ew.Validators.required(fields.tglmulai.caption) : null, ew.Validators.datetime(0)], fields.tglmulai.isInvalid],
        ["targetselesai", [fields.targetselesai.visible && fields.targetselesai.required ? ew.Validators.required(fields.targetselesai.caption) : null, ew.Validators.datetime(0)], fields.targetselesai.isInvalid],
        ["tglselesai", [fields.tglselesai.visible && fields.tglselesai.required ? ew.Validators.required(fields.tglselesai.caption) : null, ew.Validators.datetime(0)], fields.tglselesai.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinhaki_statusgrid,
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
    fijinhaki_statusgrid.validate = function () {
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
    fijinhaki_statusgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idpegawai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "targetmulai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglmulai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "targetselesai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglselesai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "keterangan", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fijinhaki_statusgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinhaki_statusgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinhaki_statusgrid.lists.idpegawai = <?= $Grid->idpegawai->toClientList($Grid) ?>;
    loadjs.done("fijinhaki_statusgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> ijinhaki_status">
<div id="fijinhaki_statusgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_ijinhaki_status" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_ijinhaki_statusgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Grid->idpegawai->headerCellClass() ?>"><div id="elh_ijinhaki_status_idpegawai" class="ijinhaki_status_idpegawai"><?= $Grid->renderSort($Grid->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_ijinhaki_status_status" class="ijinhaki_status_status"><?= $Grid->renderSort($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->targetmulai->Visible) { // targetmulai ?>
        <th data-name="targetmulai" class="<?= $Grid->targetmulai->headerCellClass() ?>"><div id="elh_ijinhaki_status_targetmulai" class="ijinhaki_status_targetmulai"><?= $Grid->renderSort($Grid->targetmulai) ?></div></th>
<?php } ?>
<?php if ($Grid->tglmulai->Visible) { // tglmulai ?>
        <th data-name="tglmulai" class="<?= $Grid->tglmulai->headerCellClass() ?>"><div id="elh_ijinhaki_status_tglmulai" class="ijinhaki_status_tglmulai"><?= $Grid->renderSort($Grid->tglmulai) ?></div></th>
<?php } ?>
<?php if ($Grid->targetselesai->Visible) { // targetselesai ?>
        <th data-name="targetselesai" class="<?= $Grid->targetselesai->headerCellClass() ?>"><div id="elh_ijinhaki_status_targetselesai" class="ijinhaki_status_targetselesai"><?= $Grid->renderSort($Grid->targetselesai) ?></div></th>
<?php } ?>
<?php if ($Grid->tglselesai->Visible) { // tglselesai ?>
        <th data-name="tglselesai" class="<?= $Grid->tglselesai->headerCellClass() ?>"><div id="elh_ijinhaki_status_tglselesai" class="ijinhaki_status_tglselesai"><?= $Grid->renderSort($Grid->tglselesai) ?></div></th>
<?php } ?>
<?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Grid->keterangan->headerCellClass() ?>"><div id="elh_ijinhaki_status_keterangan" class="ijinhaki_status_keterangan"><?= $Grid->renderSort($Grid->keterangan) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_ijinhaki_status", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Grid->idpegawai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_idpegawai" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="ijinhaki_status"
        data-field="x_idpegawai"
        data-value-separator="<?= $Grid->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idpegawai->getPlaceHolder()) ?>"
        <?= $Grid->idpegawai->editAttributes() ?>>
        <?= $Grid->idpegawai->selectOptionListHtml("x{$Grid->RowIndex}_idpegawai") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idpegawai->getErrorMessage() ?></div>
<?= $Grid->idpegawai->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki_status.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_idpegawai" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="ijinhaki_status"
        data-field="x_idpegawai"
        data-value-separator="<?= $Grid->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idpegawai->getPlaceHolder()) ?>"
        <?= $Grid->idpegawai->editAttributes() ?>>
        <?= $Grid->idpegawai->selectOptionListHtml("x{$Grid->RowIndex}_idpegawai") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idpegawai->getErrorMessage() ?></div>
<?= $Grid->idpegawai->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki_status.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<?= $Grid->idpegawai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_idpegawai" data-hidden="1" name="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_idpegawai" id="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<input type="hidden" data-table="ijinhaki_status" data-field="x_idpegawai" data-hidden="1" name="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_idpegawai" id="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status" <?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_status" data-hidden="1" name="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_status" id="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="ijinhaki_status" data-field="x_status" data-hidden="1" name="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_status" id="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->targetmulai->Visible) { // targetmulai ?>
        <td data-name="targetmulai" <?= $Grid->targetmulai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_targetmulai" class="form-group">
<input type="<?= $Grid->targetmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetmulai" name="x<?= $Grid->RowIndex ?>_targetmulai" id="x<?= $Grid->RowIndex ?>_targetmulai" placeholder="<?= HtmlEncode($Grid->targetmulai->getPlaceHolder()) ?>" value="<?= $Grid->targetmulai->EditValue ?>"<?= $Grid->targetmulai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->targetmulai->getErrorMessage() ?></div>
<?php if (!$Grid->targetmulai->ReadOnly && !$Grid->targetmulai->Disabled && !isset($Grid->targetmulai->EditAttrs["readonly"]) && !isset($Grid->targetmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_targetmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetmulai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_targetmulai" id="o<?= $Grid->RowIndex ?>_targetmulai" value="<?= HtmlEncode($Grid->targetmulai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_targetmulai" class="form-group">
<input type="<?= $Grid->targetmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetmulai" name="x<?= $Grid->RowIndex ?>_targetmulai" id="x<?= $Grid->RowIndex ?>_targetmulai" placeholder="<?= HtmlEncode($Grid->targetmulai->getPlaceHolder()) ?>" value="<?= $Grid->targetmulai->EditValue ?>"<?= $Grid->targetmulai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->targetmulai->getErrorMessage() ?></div>
<?php if (!$Grid->targetmulai->ReadOnly && !$Grid->targetmulai->Disabled && !isset($Grid->targetmulai->EditAttrs["readonly"]) && !isset($Grid->targetmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_targetmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_targetmulai">
<span<?= $Grid->targetmulai->viewAttributes() ?>>
<?= $Grid->targetmulai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetmulai" data-hidden="1" name="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_targetmulai" id="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_targetmulai" value="<?= HtmlEncode($Grid->targetmulai->FormValue) ?>">
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetmulai" data-hidden="1" name="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_targetmulai" id="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_targetmulai" value="<?= HtmlEncode($Grid->targetmulai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglmulai->Visible) { // tglmulai ?>
        <td data-name="tglmulai" <?= $Grid->tglmulai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_tglmulai" class="form-group">
<input type="<?= $Grid->tglmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglmulai" name="x<?= $Grid->RowIndex ?>_tglmulai" id="x<?= $Grid->RowIndex ?>_tglmulai" placeholder="<?= HtmlEncode($Grid->tglmulai->getPlaceHolder()) ?>" value="<?= $Grid->tglmulai->EditValue ?>"<?= $Grid->tglmulai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglmulai->getErrorMessage() ?></div>
<?php if (!$Grid->tglmulai->ReadOnly && !$Grid->tglmulai->Disabled && !isset($Grid->tglmulai->EditAttrs["readonly"]) && !isset($Grid->tglmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_tglmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglmulai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglmulai" id="o<?= $Grid->RowIndex ?>_tglmulai" value="<?= HtmlEncode($Grid->tglmulai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_tglmulai" class="form-group">
<input type="<?= $Grid->tglmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglmulai" name="x<?= $Grid->RowIndex ?>_tglmulai" id="x<?= $Grid->RowIndex ?>_tglmulai" placeholder="<?= HtmlEncode($Grid->tglmulai->getPlaceHolder()) ?>" value="<?= $Grid->tglmulai->EditValue ?>"<?= $Grid->tglmulai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglmulai->getErrorMessage() ?></div>
<?php if (!$Grid->tglmulai->ReadOnly && !$Grid->tglmulai->Disabled && !isset($Grid->tglmulai->EditAttrs["readonly"]) && !isset($Grid->tglmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_tglmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_tglmulai">
<span<?= $Grid->tglmulai->viewAttributes() ?>>
<?= $Grid->tglmulai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglmulai" data-hidden="1" name="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_tglmulai" id="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_tglmulai" value="<?= HtmlEncode($Grid->tglmulai->FormValue) ?>">
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglmulai" data-hidden="1" name="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_tglmulai" id="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_tglmulai" value="<?= HtmlEncode($Grid->tglmulai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->targetselesai->Visible) { // targetselesai ?>
        <td data-name="targetselesai" <?= $Grid->targetselesai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_targetselesai" class="form-group">
<input type="<?= $Grid->targetselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetselesai" name="x<?= $Grid->RowIndex ?>_targetselesai" id="x<?= $Grid->RowIndex ?>_targetselesai" placeholder="<?= HtmlEncode($Grid->targetselesai->getPlaceHolder()) ?>" value="<?= $Grid->targetselesai->EditValue ?>"<?= $Grid->targetselesai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->targetselesai->getErrorMessage() ?></div>
<?php if (!$Grid->targetselesai->ReadOnly && !$Grid->targetselesai->Disabled && !isset($Grid->targetselesai->EditAttrs["readonly"]) && !isset($Grid->targetselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_targetselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetselesai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_targetselesai" id="o<?= $Grid->RowIndex ?>_targetselesai" value="<?= HtmlEncode($Grid->targetselesai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_targetselesai" class="form-group">
<input type="<?= $Grid->targetselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetselesai" name="x<?= $Grid->RowIndex ?>_targetselesai" id="x<?= $Grid->RowIndex ?>_targetselesai" placeholder="<?= HtmlEncode($Grid->targetselesai->getPlaceHolder()) ?>" value="<?= $Grid->targetselesai->EditValue ?>"<?= $Grid->targetselesai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->targetselesai->getErrorMessage() ?></div>
<?php if (!$Grid->targetselesai->ReadOnly && !$Grid->targetselesai->Disabled && !isset($Grid->targetselesai->EditAttrs["readonly"]) && !isset($Grid->targetselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_targetselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_targetselesai">
<span<?= $Grid->targetselesai->viewAttributes() ?>>
<?= $Grid->targetselesai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetselesai" data-hidden="1" name="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_targetselesai" id="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_targetselesai" value="<?= HtmlEncode($Grid->targetselesai->FormValue) ?>">
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetselesai" data-hidden="1" name="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_targetselesai" id="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_targetselesai" value="<?= HtmlEncode($Grid->targetselesai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglselesai->Visible) { // tglselesai ?>
        <td data-name="tglselesai" <?= $Grid->tglselesai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_tglselesai" class="form-group">
<input type="<?= $Grid->tglselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglselesai" name="x<?= $Grid->RowIndex ?>_tglselesai" id="x<?= $Grid->RowIndex ?>_tglselesai" placeholder="<?= HtmlEncode($Grid->tglselesai->getPlaceHolder()) ?>" value="<?= $Grid->tglselesai->EditValue ?>"<?= $Grid->tglselesai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglselesai->getErrorMessage() ?></div>
<?php if (!$Grid->tglselesai->ReadOnly && !$Grid->tglselesai->Disabled && !isset($Grid->tglselesai->EditAttrs["readonly"]) && !isset($Grid->tglselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_tglselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglselesai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglselesai" id="o<?= $Grid->RowIndex ?>_tglselesai" value="<?= HtmlEncode($Grid->tglselesai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_tglselesai" class="form-group">
<input type="<?= $Grid->tglselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglselesai" name="x<?= $Grid->RowIndex ?>_tglselesai" id="x<?= $Grid->RowIndex ?>_tglselesai" placeholder="<?= HtmlEncode($Grid->tglselesai->getPlaceHolder()) ?>" value="<?= $Grid->tglselesai->EditValue ?>"<?= $Grid->tglselesai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglselesai->getErrorMessage() ?></div>
<?php if (!$Grid->tglselesai->ReadOnly && !$Grid->tglselesai->Disabled && !isset($Grid->tglselesai->EditAttrs["readonly"]) && !isset($Grid->tglselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_tglselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_tglselesai">
<span<?= $Grid->tglselesai->viewAttributes() ?>>
<?= $Grid->tglselesai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglselesai" data-hidden="1" name="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_tglselesai" id="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_tglselesai" value="<?= HtmlEncode($Grid->tglselesai->FormValue) ?>">
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglselesai" data-hidden="1" name="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_tglselesai" id="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_tglselesai" value="<?= HtmlEncode($Grid->tglselesai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Grid->keterangan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_keterangan" class="form-group">
<input type="<?= $Grid->keterangan->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>" value="<?= $Grid->keterangan->EditValue ?>"<?= $Grid->keterangan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_keterangan" class="form-group">
<input type="<?= $Grid->keterangan->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>" value="<?= $Grid->keterangan->EditValue ?>"<?= $Grid->keterangan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinhaki_status_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_keterangan" data-hidden="1" name="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_keterangan" id="fijinhaki_statusgrid$x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<input type="hidden" data-table="ijinhaki_status" data-field="x_keterangan" data-hidden="1" name="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_keterangan" id="fijinhaki_statusgrid$o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
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
loadjs.ready(["fijinhaki_statusgrid","load"], function () {
    fijinhaki_statusgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_ijinhaki_status", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinhaki_status_idpegawai" class="form-group ijinhaki_status_idpegawai">
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="ijinhaki_status"
        data-field="x_idpegawai"
        data-value-separator="<?= $Grid->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idpegawai->getPlaceHolder()) ?>"
        <?= $Grid->idpegawai->editAttributes() ?>>
        <?= $Grid->idpegawai->selectOptionListHtml("x{$Grid->RowIndex}_idpegawai") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idpegawai->getErrorMessage() ?></div>
<?= $Grid->idpegawai->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "ijinhaki_status_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki_status.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinhaki_status_idpegawai" class="form-group ijinhaki_status_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_idpegawai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idpegawai" id="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinhaki_status_status" class="form-group ijinhaki_status_status">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinhaki_status_status" class="form-group ijinhaki_status_status">
<span<?= $Grid->status->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status->getDisplayValue($Grid->status->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->targetmulai->Visible) { // targetmulai ?>
        <td data-name="targetmulai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinhaki_status_targetmulai" class="form-group ijinhaki_status_targetmulai">
<input type="<?= $Grid->targetmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetmulai" name="x<?= $Grid->RowIndex ?>_targetmulai" id="x<?= $Grid->RowIndex ?>_targetmulai" placeholder="<?= HtmlEncode($Grid->targetmulai->getPlaceHolder()) ?>" value="<?= $Grid->targetmulai->EditValue ?>"<?= $Grid->targetmulai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->targetmulai->getErrorMessage() ?></div>
<?php if (!$Grid->targetmulai->ReadOnly && !$Grid->targetmulai->Disabled && !isset($Grid->targetmulai->EditAttrs["readonly"]) && !isset($Grid->targetmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_targetmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinhaki_status_targetmulai" class="form-group ijinhaki_status_targetmulai">
<span<?= $Grid->targetmulai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->targetmulai->getDisplayValue($Grid->targetmulai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetmulai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_targetmulai" id="x<?= $Grid->RowIndex ?>_targetmulai" value="<?= HtmlEncode($Grid->targetmulai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetmulai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_targetmulai" id="o<?= $Grid->RowIndex ?>_targetmulai" value="<?= HtmlEncode($Grid->targetmulai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglmulai->Visible) { // tglmulai ?>
        <td data-name="tglmulai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinhaki_status_tglmulai" class="form-group ijinhaki_status_tglmulai">
<input type="<?= $Grid->tglmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglmulai" name="x<?= $Grid->RowIndex ?>_tglmulai" id="x<?= $Grid->RowIndex ?>_tglmulai" placeholder="<?= HtmlEncode($Grid->tglmulai->getPlaceHolder()) ?>" value="<?= $Grid->tglmulai->EditValue ?>"<?= $Grid->tglmulai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglmulai->getErrorMessage() ?></div>
<?php if (!$Grid->tglmulai->ReadOnly && !$Grid->tglmulai->Disabled && !isset($Grid->tglmulai->EditAttrs["readonly"]) && !isset($Grid->tglmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_tglmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinhaki_status_tglmulai" class="form-group ijinhaki_status_tglmulai">
<span<?= $Grid->tglmulai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglmulai->getDisplayValue($Grid->tglmulai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglmulai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglmulai" id="x<?= $Grid->RowIndex ?>_tglmulai" value="<?= HtmlEncode($Grid->tglmulai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglmulai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglmulai" id="o<?= $Grid->RowIndex ?>_tglmulai" value="<?= HtmlEncode($Grid->tglmulai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->targetselesai->Visible) { // targetselesai ?>
        <td data-name="targetselesai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinhaki_status_targetselesai" class="form-group ijinhaki_status_targetselesai">
<input type="<?= $Grid->targetselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetselesai" name="x<?= $Grid->RowIndex ?>_targetselesai" id="x<?= $Grid->RowIndex ?>_targetselesai" placeholder="<?= HtmlEncode($Grid->targetselesai->getPlaceHolder()) ?>" value="<?= $Grid->targetselesai->EditValue ?>"<?= $Grid->targetselesai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->targetselesai->getErrorMessage() ?></div>
<?php if (!$Grid->targetselesai->ReadOnly && !$Grid->targetselesai->Disabled && !isset($Grid->targetselesai->EditAttrs["readonly"]) && !isset($Grid->targetselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_targetselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinhaki_status_targetselesai" class="form-group ijinhaki_status_targetselesai">
<span<?= $Grid->targetselesai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->targetselesai->getDisplayValue($Grid->targetselesai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetselesai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_targetselesai" id="x<?= $Grid->RowIndex ?>_targetselesai" value="<?= HtmlEncode($Grid->targetselesai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_targetselesai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_targetselesai" id="o<?= $Grid->RowIndex ?>_targetselesai" value="<?= HtmlEncode($Grid->targetselesai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglselesai->Visible) { // tglselesai ?>
        <td data-name="tglselesai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinhaki_status_tglselesai" class="form-group ijinhaki_status_tglselesai">
<input type="<?= $Grid->tglselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglselesai" name="x<?= $Grid->RowIndex ?>_tglselesai" id="x<?= $Grid->RowIndex ?>_tglselesai" placeholder="<?= HtmlEncode($Grid->tglselesai->getPlaceHolder()) ?>" value="<?= $Grid->tglselesai->EditValue ?>"<?= $Grid->tglselesai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglselesai->getErrorMessage() ?></div>
<?php if (!$Grid->tglselesai->ReadOnly && !$Grid->tglselesai->Disabled && !isset($Grid->tglselesai->EditAttrs["readonly"]) && !isset($Grid->tglselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusgrid", "x<?= $Grid->RowIndex ?>_tglselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinhaki_status_tglselesai" class="form-group ijinhaki_status_tglselesai">
<span<?= $Grid->tglselesai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglselesai->getDisplayValue($Grid->tglselesai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglselesai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglselesai" id="x<?= $Grid->RowIndex ?>_tglselesai" value="<?= HtmlEncode($Grid->tglselesai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_tglselesai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglselesai" id="o<?= $Grid->RowIndex ?>_tglselesai" value="<?= HtmlEncode($Grid->tglselesai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinhaki_status_keterangan" class="form-group ijinhaki_status_keterangan">
<input type="<?= $Grid->keterangan->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>" value="<?= $Grid->keterangan->EditValue ?>"<?= $Grid->keterangan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinhaki_status_keterangan" class="form-group ijinhaki_status_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->keterangan->getDisplayValue($Grid->keterangan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinhaki_status" data-field="x_keterangan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinhaki_status" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fijinhaki_statusgrid","load"], function() {
    fijinhaki_statusgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fijinhaki_statusgrid">
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
    ew.addEventHandlers("ijinhaki_status");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
