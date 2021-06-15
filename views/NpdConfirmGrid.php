<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("NpdConfirmGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_confirmgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnpd_confirmgrid = new ew.Form("fnpd_confirmgrid", "grid");
    fnpd_confirmgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirm")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirm)
        ew.vars.tables.npd_confirm = currentTable;
    fnpd_confirmgrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglkonfirmasi", [fields.tglkonfirmasi.visible && fields.tglkonfirmasi.required ? ew.Validators.required(fields.tglkonfirmasi.caption) : null, ew.Validators.datetime(0)], fields.tglkonfirmasi.isInvalid],
        ["idnpd_sample", [fields.idnpd_sample.visible && fields.idnpd_sample.required ? ew.Validators.required(fields.idnpd_sample.caption) : null], fields.idnpd_sample.isInvalid],
        ["namapemesan", [fields.namapemesan.visible && fields.namapemesan.required ? ew.Validators.required(fields.namapemesan.caption) : null], fields.namapemesan.isInvalid],
        ["personincharge", [fields.personincharge.visible && fields.personincharge.required ? ew.Validators.required(fields.personincharge.caption) : null], fields.personincharge.isInvalid],
        ["notelp", [fields.notelp.visible && fields.notelp.required ? ew.Validators.required(fields.notelp.caption) : null], fields.notelp.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmgrid,
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
    fnpd_confirmgrid.validate = function () {
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
    fnpd_confirmgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglkonfirmasi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idnpd_sample", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "namapemesan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "personincharge", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "notelp", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnpd_confirmgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_confirmgrid.lists.idnpd_sample = <?= $Grid->idnpd_sample->toClientList($Grid) ?>;
    loadjs.done("fnpd_confirmgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_confirm">
<div id="fnpd_confirmgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_npd_confirm" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_npd_confirmgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_npd_confirm_idnpd" class="npd_confirm_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
        <th data-name="tglkonfirmasi" class="<?= $Grid->tglkonfirmasi->headerCellClass() ?>"><div id="elh_npd_confirm_tglkonfirmasi" class="npd_confirm_tglkonfirmasi"><?= $Grid->renderSort($Grid->tglkonfirmasi) ?></div></th>
<?php } ?>
<?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <th data-name="idnpd_sample" class="<?= $Grid->idnpd_sample->headerCellClass() ?>"><div id="elh_npd_confirm_idnpd_sample" class="npd_confirm_idnpd_sample"><?= $Grid->renderSort($Grid->idnpd_sample) ?></div></th>
<?php } ?>
<?php if ($Grid->namapemesan->Visible) { // namapemesan ?>
        <th data-name="namapemesan" class="<?= $Grid->namapemesan->headerCellClass() ?>"><div id="elh_npd_confirm_namapemesan" class="npd_confirm_namapemesan"><?= $Grid->renderSort($Grid->namapemesan) ?></div></th>
<?php } ?>
<?php if ($Grid->personincharge->Visible) { // personincharge ?>
        <th data-name="personincharge" class="<?= $Grid->personincharge->headerCellClass() ?>"><div id="elh_npd_confirm_personincharge" class="npd_confirm_personincharge"><?= $Grid->renderSort($Grid->personincharge) ?></div></th>
<?php } ?>
<?php if ($Grid->notelp->Visible) { // notelp ?>
        <th data-name="notelp" class="<?= $Grid->notelp->headerCellClass() ?>"><div id="elh_npd_confirm_notelp" class="npd_confirm_notelp"><?= $Grid->renderSort($Grid->notelp) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_npd_confirm", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_confirm" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_confirm" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd" data-hidden="1" name="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_idnpd" id="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd" data-hidden="1" name="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_idnpd" id="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
        <td data-name="tglkonfirmasi" <?= $Grid->tglkonfirmasi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_tglkonfirmasi" class="form-group">
<input type="<?= $Grid->tglkonfirmasi->getInputTextType() ?>" data-table="npd_confirm" data-field="x_tglkonfirmasi" name="x<?= $Grid->RowIndex ?>_tglkonfirmasi" id="x<?= $Grid->RowIndex ?>_tglkonfirmasi" placeholder="<?= HtmlEncode($Grid->tglkonfirmasi->getPlaceHolder()) ?>" value="<?= $Grid->tglkonfirmasi->EditValue ?>"<?= $Grid->tglkonfirmasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglkonfirmasi->getErrorMessage() ?></div>
<?php if (!$Grid->tglkonfirmasi->ReadOnly && !$Grid->tglkonfirmasi->Disabled && !isset($Grid->tglkonfirmasi->EditAttrs["readonly"]) && !isset($Grid->tglkonfirmasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmgrid", "x<?= $Grid->RowIndex ?>_tglkonfirmasi", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_tglkonfirmasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglkonfirmasi" id="o<?= $Grid->RowIndex ?>_tglkonfirmasi" value="<?= HtmlEncode($Grid->tglkonfirmasi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_tglkonfirmasi" class="form-group">
<input type="<?= $Grid->tglkonfirmasi->getInputTextType() ?>" data-table="npd_confirm" data-field="x_tglkonfirmasi" name="x<?= $Grid->RowIndex ?>_tglkonfirmasi" id="x<?= $Grid->RowIndex ?>_tglkonfirmasi" placeholder="<?= HtmlEncode($Grid->tglkonfirmasi->getPlaceHolder()) ?>" value="<?= $Grid->tglkonfirmasi->EditValue ?>"<?= $Grid->tglkonfirmasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglkonfirmasi->getErrorMessage() ?></div>
<?php if (!$Grid->tglkonfirmasi->ReadOnly && !$Grid->tglkonfirmasi->Disabled && !isset($Grid->tglkonfirmasi->EditAttrs["readonly"]) && !isset($Grid->tglkonfirmasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmgrid", "x<?= $Grid->RowIndex ?>_tglkonfirmasi", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_tglkonfirmasi">
<span<?= $Grid->tglkonfirmasi->viewAttributes() ?>>
<?= $Grid->tglkonfirmasi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_confirm" data-field="x_tglkonfirmasi" data-hidden="1" name="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_tglkonfirmasi" id="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_tglkonfirmasi" value="<?= HtmlEncode($Grid->tglkonfirmasi->FormValue) ?>">
<input type="hidden" data-table="npd_confirm" data-field="x_tglkonfirmasi" data-hidden="1" name="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_tglkonfirmasi" id="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_tglkonfirmasi" value="<?= HtmlEncode($Grid->tglkonfirmasi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <td data-name="idnpd_sample" <?= $Grid->idnpd_sample->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd_sample" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_confirm"
        data-field="x_idnpd_sample"
        data-value-separator="<?= $Grid->idnpd_sample->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd_sample->getPlaceHolder()) ?>"
        <?= $Grid->idnpd_sample->editAttributes() ?>>
        <?= $Grid->idnpd_sample->selectOptionListHtml("x{$Grid->RowIndex}_idnpd_sample") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd_sample->getErrorMessage() ?></div>
<?= $Grid->idnpd_sample->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd_sample") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirm.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd_sample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd_sample" id="o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd_sample" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_confirm"
        data-field="x_idnpd_sample"
        data-value-separator="<?= $Grid->idnpd_sample->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd_sample->getPlaceHolder()) ?>"
        <?= $Grid->idnpd_sample->editAttributes() ?>>
        <?= $Grid->idnpd_sample->selectOptionListHtml("x{$Grid->RowIndex}_idnpd_sample") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd_sample->getErrorMessage() ?></div>
<?= $Grid->idnpd_sample->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd_sample") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirm.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_idnpd_sample">
<span<?= $Grid->idnpd_sample->viewAttributes() ?>>
<?= $Grid->idnpd_sample->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd_sample" data-hidden="1" name="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_idnpd_sample" id="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->FormValue) ?>">
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd_sample" data-hidden="1" name="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_idnpd_sample" id="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->namapemesan->Visible) { // namapemesan ?>
        <td data-name="namapemesan" <?= $Grid->namapemesan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_namapemesan" class="form-group">
<input type="<?= $Grid->namapemesan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_namapemesan" name="x<?= $Grid->RowIndex ?>_namapemesan" id="x<?= $Grid->RowIndex ?>_namapemesan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->namapemesan->getPlaceHolder()) ?>" value="<?= $Grid->namapemesan->EditValue ?>"<?= $Grid->namapemesan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namapemesan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_namapemesan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namapemesan" id="o<?= $Grid->RowIndex ?>_namapemesan" value="<?= HtmlEncode($Grid->namapemesan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_namapemesan" class="form-group">
<input type="<?= $Grid->namapemesan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_namapemesan" name="x<?= $Grid->RowIndex ?>_namapemesan" id="x<?= $Grid->RowIndex ?>_namapemesan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->namapemesan->getPlaceHolder()) ?>" value="<?= $Grid->namapemesan->EditValue ?>"<?= $Grid->namapemesan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namapemesan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_namapemesan">
<span<?= $Grid->namapemesan->viewAttributes() ?>>
<?= $Grid->namapemesan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_confirm" data-field="x_namapemesan" data-hidden="1" name="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_namapemesan" id="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_namapemesan" value="<?= HtmlEncode($Grid->namapemesan->FormValue) ?>">
<input type="hidden" data-table="npd_confirm" data-field="x_namapemesan" data-hidden="1" name="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_namapemesan" id="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_namapemesan" value="<?= HtmlEncode($Grid->namapemesan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->personincharge->Visible) { // personincharge ?>
        <td data-name="personincharge" <?= $Grid->personincharge->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_personincharge" class="form-group">
<input type="<?= $Grid->personincharge->getInputTextType() ?>" data-table="npd_confirm" data-field="x_personincharge" name="x<?= $Grid->RowIndex ?>_personincharge" id="x<?= $Grid->RowIndex ?>_personincharge" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->personincharge->getPlaceHolder()) ?>" value="<?= $Grid->personincharge->EditValue ?>"<?= $Grid->personincharge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->personincharge->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_personincharge" data-hidden="1" name="o<?= $Grid->RowIndex ?>_personincharge" id="o<?= $Grid->RowIndex ?>_personincharge" value="<?= HtmlEncode($Grid->personincharge->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_personincharge" class="form-group">
<input type="<?= $Grid->personincharge->getInputTextType() ?>" data-table="npd_confirm" data-field="x_personincharge" name="x<?= $Grid->RowIndex ?>_personincharge" id="x<?= $Grid->RowIndex ?>_personincharge" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->personincharge->getPlaceHolder()) ?>" value="<?= $Grid->personincharge->EditValue ?>"<?= $Grid->personincharge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->personincharge->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_personincharge">
<span<?= $Grid->personincharge->viewAttributes() ?>>
<?= $Grid->personincharge->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_confirm" data-field="x_personincharge" data-hidden="1" name="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_personincharge" id="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_personincharge" value="<?= HtmlEncode($Grid->personincharge->FormValue) ?>">
<input type="hidden" data-table="npd_confirm" data-field="x_personincharge" data-hidden="1" name="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_personincharge" id="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_personincharge" value="<?= HtmlEncode($Grid->personincharge->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->notelp->Visible) { // notelp ?>
        <td data-name="notelp" <?= $Grid->notelp->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_notelp" class="form-group">
<input type="<?= $Grid->notelp->getInputTextType() ?>" data-table="npd_confirm" data-field="x_notelp" name="x<?= $Grid->RowIndex ?>_notelp" id="x<?= $Grid->RowIndex ?>_notelp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->notelp->getPlaceHolder()) ?>" value="<?= $Grid->notelp->EditValue ?>"<?= $Grid->notelp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->notelp->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_notelp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_notelp" id="o<?= $Grid->RowIndex ?>_notelp" value="<?= HtmlEncode($Grid->notelp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_notelp" class="form-group">
<input type="<?= $Grid->notelp->getInputTextType() ?>" data-table="npd_confirm" data-field="x_notelp" name="x<?= $Grid->RowIndex ?>_notelp" id="x<?= $Grid->RowIndex ?>_notelp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->notelp->getPlaceHolder()) ?>" value="<?= $Grid->notelp->EditValue ?>"<?= $Grid->notelp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->notelp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_confirm_notelp">
<span<?= $Grid->notelp->viewAttributes() ?>>
<?= $Grid->notelp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_confirm" data-field="x_notelp" data-hidden="1" name="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_notelp" id="fnpd_confirmgrid$x<?= $Grid->RowIndex ?>_notelp" value="<?= HtmlEncode($Grid->notelp->FormValue) ?>">
<input type="hidden" data-table="npd_confirm" data-field="x_notelp" data-hidden="1" name="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_notelp" id="fnpd_confirmgrid$o<?= $Grid->RowIndex ?>_notelp" value="<?= HtmlEncode($Grid->notelp->OldValue) ?>">
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
loadjs.ready(["fnpd_confirmgrid","load"], function () {
    fnpd_confirmgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_npd_confirm", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_npd_confirm_idnpd" class="form-group npd_confirm_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_npd_confirm_idnpd" class="form-group npd_confirm_idnpd">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_confirm" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_npd_confirm_idnpd" class="form-group npd_confirm_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
        <td data-name="tglkonfirmasi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_confirm_tglkonfirmasi" class="form-group npd_confirm_tglkonfirmasi">
<input type="<?= $Grid->tglkonfirmasi->getInputTextType() ?>" data-table="npd_confirm" data-field="x_tglkonfirmasi" name="x<?= $Grid->RowIndex ?>_tglkonfirmasi" id="x<?= $Grid->RowIndex ?>_tglkonfirmasi" placeholder="<?= HtmlEncode($Grid->tglkonfirmasi->getPlaceHolder()) ?>" value="<?= $Grid->tglkonfirmasi->EditValue ?>"<?= $Grid->tglkonfirmasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglkonfirmasi->getErrorMessage() ?></div>
<?php if (!$Grid->tglkonfirmasi->ReadOnly && !$Grid->tglkonfirmasi->Disabled && !isset($Grid->tglkonfirmasi->EditAttrs["readonly"]) && !isset($Grid->tglkonfirmasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmgrid", "x<?= $Grid->RowIndex ?>_tglkonfirmasi", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_confirm_tglkonfirmasi" class="form-group npd_confirm_tglkonfirmasi">
<span<?= $Grid->tglkonfirmasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglkonfirmasi->getDisplayValue($Grid->tglkonfirmasi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_tglkonfirmasi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglkonfirmasi" id="x<?= $Grid->RowIndex ?>_tglkonfirmasi" value="<?= HtmlEncode($Grid->tglkonfirmasi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_confirm" data-field="x_tglkonfirmasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglkonfirmasi" id="o<?= $Grid->RowIndex ?>_tglkonfirmasi" value="<?= HtmlEncode($Grid->tglkonfirmasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <td data-name="idnpd_sample">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_confirm_idnpd_sample" class="form-group npd_confirm_idnpd_sample">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_confirm"
        data-field="x_idnpd_sample"
        data-value-separator="<?= $Grid->idnpd_sample->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd_sample->getPlaceHolder()) ?>"
        <?= $Grid->idnpd_sample->editAttributes() ?>>
        <?= $Grid->idnpd_sample->selectOptionListHtml("x{$Grid->RowIndex}_idnpd_sample") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd_sample->getErrorMessage() ?></div>
<?= $Grid->idnpd_sample->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd_sample") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_confirm_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirm.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_confirm_idnpd_sample" class="form-group npd_confirm_idnpd_sample">
<span<?= $Grid->idnpd_sample->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd_sample->getDisplayValue($Grid->idnpd_sample->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd_sample" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd_sample" id="x<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_confirm" data-field="x_idnpd_sample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd_sample" id="o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->namapemesan->Visible) { // namapemesan ?>
        <td data-name="namapemesan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_confirm_namapemesan" class="form-group npd_confirm_namapemesan">
<input type="<?= $Grid->namapemesan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_namapemesan" name="x<?= $Grid->RowIndex ?>_namapemesan" id="x<?= $Grid->RowIndex ?>_namapemesan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->namapemesan->getPlaceHolder()) ?>" value="<?= $Grid->namapemesan->EditValue ?>"<?= $Grid->namapemesan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namapemesan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_confirm_namapemesan" class="form-group npd_confirm_namapemesan">
<span<?= $Grid->namapemesan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->namapemesan->getDisplayValue($Grid->namapemesan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_namapemesan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_namapemesan" id="x<?= $Grid->RowIndex ?>_namapemesan" value="<?= HtmlEncode($Grid->namapemesan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_confirm" data-field="x_namapemesan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namapemesan" id="o<?= $Grid->RowIndex ?>_namapemesan" value="<?= HtmlEncode($Grid->namapemesan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->personincharge->Visible) { // personincharge ?>
        <td data-name="personincharge">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_confirm_personincharge" class="form-group npd_confirm_personincharge">
<input type="<?= $Grid->personincharge->getInputTextType() ?>" data-table="npd_confirm" data-field="x_personincharge" name="x<?= $Grid->RowIndex ?>_personincharge" id="x<?= $Grid->RowIndex ?>_personincharge" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->personincharge->getPlaceHolder()) ?>" value="<?= $Grid->personincharge->EditValue ?>"<?= $Grid->personincharge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->personincharge->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_confirm_personincharge" class="form-group npd_confirm_personincharge">
<span<?= $Grid->personincharge->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->personincharge->getDisplayValue($Grid->personincharge->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_personincharge" data-hidden="1" name="x<?= $Grid->RowIndex ?>_personincharge" id="x<?= $Grid->RowIndex ?>_personincharge" value="<?= HtmlEncode($Grid->personincharge->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_confirm" data-field="x_personincharge" data-hidden="1" name="o<?= $Grid->RowIndex ?>_personincharge" id="o<?= $Grid->RowIndex ?>_personincharge" value="<?= HtmlEncode($Grid->personincharge->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->notelp->Visible) { // notelp ?>
        <td data-name="notelp">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_confirm_notelp" class="form-group npd_confirm_notelp">
<input type="<?= $Grid->notelp->getInputTextType() ?>" data-table="npd_confirm" data-field="x_notelp" name="x<?= $Grid->RowIndex ?>_notelp" id="x<?= $Grid->RowIndex ?>_notelp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->notelp->getPlaceHolder()) ?>" value="<?= $Grid->notelp->EditValue ?>"<?= $Grid->notelp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->notelp->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_confirm_notelp" class="form-group npd_confirm_notelp">
<span<?= $Grid->notelp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->notelp->getDisplayValue($Grid->notelp->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_confirm" data-field="x_notelp" data-hidden="1" name="x<?= $Grid->RowIndex ?>_notelp" id="x<?= $Grid->RowIndex ?>_notelp" value="<?= HtmlEncode($Grid->notelp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_confirm" data-field="x_notelp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_notelp" id="o<?= $Grid->RowIndex ?>_notelp" value="<?= HtmlEncode($Grid->notelp->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnpd_confirmgrid","load"], function() {
    fnpd_confirmgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fnpd_confirmgrid">
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
    ew.addEventHandlers("npd_confirm");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
