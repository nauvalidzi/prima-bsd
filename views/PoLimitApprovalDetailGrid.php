<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("PoLimitApprovalDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpo_limit_approval_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fpo_limit_approval_detailgrid = new ew.Form("fpo_limit_approval_detailgrid", "grid");
    fpo_limit_approval_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "po_limit_approval_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.po_limit_approval_detail)
        ew.vars.tables.po_limit_approval_detail = currentTable;
    fpo_limit_approval_detailgrid.addFields([
        ["idorder", [fields.idorder.visible && fields.idorder.required ? ew.Validators.required(fields.idorder.caption) : null], fields.idorder.isInvalid],
        ["kredit_terpakai", [fields.kredit_terpakai.visible && fields.kredit_terpakai.required ? ew.Validators.required(fields.kredit_terpakai.caption) : null, ew.Validators.integer], fields.kredit_terpakai.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpo_limit_approval_detailgrid,
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
    fpo_limit_approval_detailgrid.validate = function () {
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
    fpo_limit_approval_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idorder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kredit_terpakai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_at", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fpo_limit_approval_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpo_limit_approval_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpo_limit_approval_detailgrid.lists.idorder = <?= $Grid->idorder->toClientList($Grid) ?>;
    loadjs.done("fpo_limit_approval_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> po_limit_approval_detail">
<div id="fpo_limit_approval_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_po_limit_approval_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_po_limit_approval_detailgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idorder->Visible) { // idorder ?>
        <th data-name="idorder" class="<?= $Grid->idorder->headerCellClass() ?>"><div id="elh_po_limit_approval_detail_idorder" class="po_limit_approval_detail_idorder"><?= $Grid->renderSort($Grid->idorder) ?></div></th>
<?php } ?>
<?php if ($Grid->kredit_terpakai->Visible) { // kredit_terpakai ?>
        <th data-name="kredit_terpakai" class="<?= $Grid->kredit_terpakai->headerCellClass() ?>"><div id="elh_po_limit_approval_detail_kredit_terpakai" class="po_limit_approval_detail_kredit_terpakai"><?= $Grid->renderSort($Grid->kredit_terpakai) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_po_limit_approval_detail_created_at" class="po_limit_approval_detail_created_at"><?= $Grid->renderSort($Grid->created_at) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_po_limit_approval_detail", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idorder->Visible) { // idorder ?>
        <td data-name="idorder" <?= $Grid->idorder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_idorder" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder"
        data-table="po_limit_approval_detail"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval_detail.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_idorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder" id="o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_idorder" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder"
        data-table="po_limit_approval_detail"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval_detail.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_idorder">
<span<?= $Grid->idorder->viewAttributes() ?>>
<?= $Grid->idorder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_idorder" data-hidden="1" name="fpo_limit_approval_detailgrid$x<?= $Grid->RowIndex ?>_idorder" id="fpo_limit_approval_detailgrid$x<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_idorder" data-hidden="1" name="fpo_limit_approval_detailgrid$o<?= $Grid->RowIndex ?>_idorder" id="fpo_limit_approval_detailgrid$o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kredit_terpakai->Visible) { // kredit_terpakai ?>
        <td data-name="kredit_terpakai" <?= $Grid->kredit_terpakai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_kredit_terpakai" class="form-group">
<input type="<?= $Grid->kredit_terpakai->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" name="x<?= $Grid->RowIndex ?>_kredit_terpakai" id="x<?= $Grid->RowIndex ?>_kredit_terpakai" size="30" placeholder="<?= HtmlEncode($Grid->kredit_terpakai->getPlaceHolder()) ?>" value="<?= $Grid->kredit_terpakai->EditValue ?>"<?= $Grid->kredit_terpakai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kredit_terpakai->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kredit_terpakai" id="o<?= $Grid->RowIndex ?>_kredit_terpakai" value="<?= HtmlEncode($Grid->kredit_terpakai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_kredit_terpakai" class="form-group">
<input type="<?= $Grid->kredit_terpakai->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" name="x<?= $Grid->RowIndex ?>_kredit_terpakai" id="x<?= $Grid->RowIndex ?>_kredit_terpakai" size="30" placeholder="<?= HtmlEncode($Grid->kredit_terpakai->getPlaceHolder()) ?>" value="<?= $Grid->kredit_terpakai->EditValue ?>"<?= $Grid->kredit_terpakai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kredit_terpakai->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_kredit_terpakai">
<span<?= $Grid->kredit_terpakai->viewAttributes() ?>>
<?= $Grid->kredit_terpakai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" data-hidden="1" name="fpo_limit_approval_detailgrid$x<?= $Grid->RowIndex ?>_kredit_terpakai" id="fpo_limit_approval_detailgrid$x<?= $Grid->RowIndex ?>_kredit_terpakai" value="<?= HtmlEncode($Grid->kredit_terpakai->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" data-hidden="1" name="fpo_limit_approval_detailgrid$o<?= $Grid->RowIndex ?>_kredit_terpakai" id="fpo_limit_approval_detailgrid$o<?= $Grid->RowIndex ?>_kredit_terpakai" value="<?= HtmlEncode($Grid->kredit_terpakai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpo_limit_approval_detailgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpo_limit_approval_detailgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpo_limit_approval_detailgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpo_limit_approval_detailgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_detail_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_created_at" data-hidden="1" name="fpo_limit_approval_detailgrid$x<?= $Grid->RowIndex ?>_created_at" id="fpo_limit_approval_detailgrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_created_at" data-hidden="1" name="fpo_limit_approval_detailgrid$o<?= $Grid->RowIndex ?>_created_at" id="fpo_limit_approval_detailgrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
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
loadjs.ready(["fpo_limit_approval_detailgrid","load"], function () {
    fpo_limit_approval_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_po_limit_approval_detail", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idorder->Visible) { // idorder ?>
        <td data-name="idorder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_detail_idorder" class="form-group po_limit_approval_detail_idorder">
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder"
        data-table="po_limit_approval_detail"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "po_limit_approval_detail_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval_detail.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_detail_idorder" class="form-group po_limit_approval_detail_idorder">
<span<?= $Grid->idorder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idorder->getDisplayValue($Grid->idorder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_idorder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idorder" id="x<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_idorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder" id="o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kredit_terpakai->Visible) { // kredit_terpakai ?>
        <td data-name="kredit_terpakai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_detail_kredit_terpakai" class="form-group po_limit_approval_detail_kredit_terpakai">
<input type="<?= $Grid->kredit_terpakai->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" name="x<?= $Grid->RowIndex ?>_kredit_terpakai" id="x<?= $Grid->RowIndex ?>_kredit_terpakai" size="30" placeholder="<?= HtmlEncode($Grid->kredit_terpakai->getPlaceHolder()) ?>" value="<?= $Grid->kredit_terpakai->EditValue ?>"<?= $Grid->kredit_terpakai->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kredit_terpakai->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_detail_kredit_terpakai" class="form-group po_limit_approval_detail_kredit_terpakai">
<span<?= $Grid->kredit_terpakai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kredit_terpakai->getDisplayValue($Grid->kredit_terpakai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kredit_terpakai" id="x<?= $Grid->RowIndex ?>_kredit_terpakai" value="<?= HtmlEncode($Grid->kredit_terpakai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kredit_terpakai" id="o<?= $Grid->RowIndex ?>_kredit_terpakai" value="<?= HtmlEncode($Grid->kredit_terpakai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_detail_created_at" class="form-group po_limit_approval_detail_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpo_limit_approval_detailgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpo_limit_approval_detailgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_detail_created_at" class="form-group po_limit_approval_detail_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_at->getDisplayValue($Grid->created_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_created_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fpo_limit_approval_detailgrid","load"], function() {
    fpo_limit_approval_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fpo_limit_approval_detailgrid">
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
    ew.addEventHandlers("po_limit_approval_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
