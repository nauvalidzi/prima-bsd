<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("VPiutangDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_piutang_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fv_piutang_detailgrid = new ew.Form("fv_piutang_detailgrid", "grid");
    fv_piutang_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_piutang_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_piutang_detail)
        ew.vars.tables.v_piutang_detail = currentTable;
    fv_piutang_detailgrid.addFields([
        ["idinvoice", [fields.idinvoice.visible && fields.idinvoice.required ? ew.Validators.required(fields.idinvoice.caption) : null, ew.Validators.integer], fields.idinvoice.isInvalid],
        ["totaltagihan", [fields.totaltagihan.visible && fields.totaltagihan.required ? ew.Validators.required(fields.totaltagihan.caption) : null, ew.Validators.integer], fields.totaltagihan.isInvalid],
        ["sisabayar", [fields.sisabayar.visible && fields.sisabayar.required ? ew.Validators.required(fields.sisabayar.caption) : null, ew.Validators.integer], fields.sisabayar.isInvalid],
        ["jatuhtempo", [fields.jatuhtempo.visible && fields.jatuhtempo.required ? ew.Validators.required(fields.jatuhtempo.caption) : null, ew.Validators.datetime(0)], fields.jatuhtempo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_piutang_detailgrid,
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
    fv_piutang_detailgrid.validate = function () {
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
    fv_piutang_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "totaltagihan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisabayar", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jatuhtempo", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fv_piutang_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_piutang_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fv_piutang_detailgrid.lists.idinvoice = <?= $Grid->idinvoice->toClientList($Grid) ?>;
    loadjs.done("fv_piutang_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_piutang_detail">
<div id="fv_piutang_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_v_piutang_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_v_piutang_detailgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idinvoice->Visible) { // idinvoice ?>
        <th data-name="idinvoice" class="<?= $Grid->idinvoice->headerCellClass() ?>"><div id="elh_v_piutang_detail_idinvoice" class="v_piutang_detail_idinvoice"><?= $Grid->renderSort($Grid->idinvoice) ?></div></th>
<?php } ?>
<?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <th data-name="totaltagihan" class="<?= $Grid->totaltagihan->headerCellClass() ?>"><div id="elh_v_piutang_detail_totaltagihan" class="v_piutang_detail_totaltagihan"><?= $Grid->renderSort($Grid->totaltagihan) ?></div></th>
<?php } ?>
<?php if ($Grid->sisabayar->Visible) { // sisabayar ?>
        <th data-name="sisabayar" class="<?= $Grid->sisabayar->headerCellClass() ?>"><div id="elh_v_piutang_detail_sisabayar" class="v_piutang_detail_sisabayar"><?= $Grid->renderSort($Grid->sisabayar) ?></div></th>
<?php } ?>
<?php if ($Grid->jatuhtempo->Visible) { // jatuhtempo ?>
        <th data-name="jatuhtempo" class="<?= $Grid->jatuhtempo->headerCellClass() ?>"><div id="elh_v_piutang_detail_jatuhtempo" class="v_piutang_detail_jatuhtempo"><?= $Grid->renderSort($Grid->jatuhtempo) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_v_piutang_detail", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idinvoice->Visible) { // idinvoice ?>
        <td data-name="idinvoice" <?= $Grid->idinvoice->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_idinvoice" class="form-group"></span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_idinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idinvoice" id="o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_idinvoice" class="form-group">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idinvoice->getDisplayValue($Grid->idinvoice->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_idinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idinvoice" id="x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_idinvoice">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<?= $Grid->idinvoice->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_idinvoice" data-hidden="1" name="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_idinvoice" id="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->FormValue) ?>">
<input type="hidden" data-table="v_piutang_detail" data-field="x_idinvoice" data-hidden="1" name="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_idinvoice" id="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="v_piutang_detail" data-field="x_idinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idinvoice" id="x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan" <?= $Grid->totaltagihan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_totaltagihan" class="form-group">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_totaltagihan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totaltagihan" id="o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_totaltagihan" class="form-group">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_totaltagihan">
<span<?= $Grid->totaltagihan->viewAttributes() ?>>
<?= $Grid->totaltagihan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_totaltagihan" data-hidden="1" name="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_totaltagihan" id="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->FormValue) ?>">
<input type="hidden" data-table="v_piutang_detail" data-field="x_totaltagihan" data-hidden="1" name="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_totaltagihan" id="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisabayar->Visible) { // sisabayar ?>
        <td data-name="sisabayar" <?= $Grid->sisabayar->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_sisabayar" class="form-group">
<input type="<?= $Grid->sisabayar->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_sisabayar" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" size="30" placeholder="<?= HtmlEncode($Grid->sisabayar->getPlaceHolder()) ?>" value="<?= $Grid->sisabayar->EditValue ?>"<?= $Grid->sisabayar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisabayar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_sisabayar" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisabayar" id="o<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_sisabayar" class="form-group">
<input type="<?= $Grid->sisabayar->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_sisabayar" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" size="30" placeholder="<?= HtmlEncode($Grid->sisabayar->getPlaceHolder()) ?>" value="<?= $Grid->sisabayar->EditValue ?>"<?= $Grid->sisabayar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisabayar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_sisabayar">
<span<?= $Grid->sisabayar->viewAttributes() ?>>
<?= $Grid->sisabayar->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_sisabayar" data-hidden="1" name="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_sisabayar" id="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->FormValue) ?>">
<input type="hidden" data-table="v_piutang_detail" data-field="x_sisabayar" data-hidden="1" name="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_sisabayar" id="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jatuhtempo->Visible) { // jatuhtempo ?>
        <td data-name="jatuhtempo" <?= $Grid->jatuhtempo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_jatuhtempo" class="form-group">
<input type="<?= $Grid->jatuhtempo->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_jatuhtempo" name="x<?= $Grid->RowIndex ?>_jatuhtempo" id="x<?= $Grid->RowIndex ?>_jatuhtempo" placeholder="<?= HtmlEncode($Grid->jatuhtempo->getPlaceHolder()) ?>" value="<?= $Grid->jatuhtempo->EditValue ?>"<?= $Grid->jatuhtempo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jatuhtempo->getErrorMessage() ?></div>
<?php if (!$Grid->jatuhtempo->ReadOnly && !$Grid->jatuhtempo->Disabled && !isset($Grid->jatuhtempo->EditAttrs["readonly"]) && !isset($Grid->jatuhtempo->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fv_piutang_detailgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fv_piutang_detailgrid", "x<?= $Grid->RowIndex ?>_jatuhtempo", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_jatuhtempo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jatuhtempo" id="o<?= $Grid->RowIndex ?>_jatuhtempo" value="<?= HtmlEncode($Grid->jatuhtempo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_jatuhtempo" class="form-group">
<input type="<?= $Grid->jatuhtempo->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_jatuhtempo" name="x<?= $Grid->RowIndex ?>_jatuhtempo" id="x<?= $Grid->RowIndex ?>_jatuhtempo" placeholder="<?= HtmlEncode($Grid->jatuhtempo->getPlaceHolder()) ?>" value="<?= $Grid->jatuhtempo->EditValue ?>"<?= $Grid->jatuhtempo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jatuhtempo->getErrorMessage() ?></div>
<?php if (!$Grid->jatuhtempo->ReadOnly && !$Grid->jatuhtempo->Disabled && !isset($Grid->jatuhtempo->EditAttrs["readonly"]) && !isset($Grid->jatuhtempo->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fv_piutang_detailgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fv_piutang_detailgrid", "x<?= $Grid->RowIndex ?>_jatuhtempo", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_piutang_detail_jatuhtempo">
<span<?= $Grid->jatuhtempo->viewAttributes() ?>>
<?= $Grid->jatuhtempo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_jatuhtempo" data-hidden="1" name="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_jatuhtempo" id="fv_piutang_detailgrid$x<?= $Grid->RowIndex ?>_jatuhtempo" value="<?= HtmlEncode($Grid->jatuhtempo->FormValue) ?>">
<input type="hidden" data-table="v_piutang_detail" data-field="x_jatuhtempo" data-hidden="1" name="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_jatuhtempo" id="fv_piutang_detailgrid$o<?= $Grid->RowIndex ?>_jatuhtempo" value="<?= HtmlEncode($Grid->jatuhtempo->OldValue) ?>">
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
loadjs.ready(["fv_piutang_detailgrid","load"], function () {
    fv_piutang_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_v_piutang_detail", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idinvoice->Visible) { // idinvoice ?>
        <td data-name="idinvoice">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_piutang_detail_idinvoice" class="form-group v_piutang_detail_idinvoice"></span>
<?php } else { ?>
<span id="el$rowindex$_v_piutang_detail_idinvoice" class="form-group v_piutang_detail_idinvoice">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idinvoice->getDisplayValue($Grid->idinvoice->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_idinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idinvoice" id="x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_idinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idinvoice" id="o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_piutang_detail_totaltagihan" class="form-group v_piutang_detail_totaltagihan">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_piutang_detail_totaltagihan" class="form-group v_piutang_detail_totaltagihan">
<span<?= $Grid->totaltagihan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->totaltagihan->getDisplayValue($Grid->totaltagihan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_totaltagihan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_totaltagihan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totaltagihan" id="o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisabayar->Visible) { // sisabayar ?>
        <td data-name="sisabayar">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_piutang_detail_sisabayar" class="form-group v_piutang_detail_sisabayar">
<input type="<?= $Grid->sisabayar->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_sisabayar" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" size="30" placeholder="<?= HtmlEncode($Grid->sisabayar->getPlaceHolder()) ?>" value="<?= $Grid->sisabayar->EditValue ?>"<?= $Grid->sisabayar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisabayar->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_piutang_detail_sisabayar" class="form-group v_piutang_detail_sisabayar">
<span<?= $Grid->sisabayar->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisabayar->getDisplayValue($Grid->sisabayar->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_sisabayar" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_sisabayar" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisabayar" id="o<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jatuhtempo->Visible) { // jatuhtempo ?>
        <td data-name="jatuhtempo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_piutang_detail_jatuhtempo" class="form-group v_piutang_detail_jatuhtempo">
<input type="<?= $Grid->jatuhtempo->getInputTextType() ?>" data-table="v_piutang_detail" data-field="x_jatuhtempo" name="x<?= $Grid->RowIndex ?>_jatuhtempo" id="x<?= $Grid->RowIndex ?>_jatuhtempo" placeholder="<?= HtmlEncode($Grid->jatuhtempo->getPlaceHolder()) ?>" value="<?= $Grid->jatuhtempo->EditValue ?>"<?= $Grid->jatuhtempo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jatuhtempo->getErrorMessage() ?></div>
<?php if (!$Grid->jatuhtempo->ReadOnly && !$Grid->jatuhtempo->Disabled && !isset($Grid->jatuhtempo->EditAttrs["readonly"]) && !isset($Grid->jatuhtempo->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fv_piutang_detailgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fv_piutang_detailgrid", "x<?= $Grid->RowIndex ?>_jatuhtempo", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_piutang_detail_jatuhtempo" class="form-group v_piutang_detail_jatuhtempo">
<span<?= $Grid->jatuhtempo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jatuhtempo->getDisplayValue($Grid->jatuhtempo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_piutang_detail" data-field="x_jatuhtempo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jatuhtempo" id="x<?= $Grid->RowIndex ?>_jatuhtempo" value="<?= HtmlEncode($Grid->jatuhtempo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_piutang_detail" data-field="x_jatuhtempo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jatuhtempo" id="o<?= $Grid->RowIndex ?>_jatuhtempo" value="<?= HtmlEncode($Grid->jatuhtempo->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fv_piutang_detailgrid","load"], function() {
    fv_piutang_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fv_piutang_detailgrid">
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
    ew.addEventHandlers("v_piutang_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
