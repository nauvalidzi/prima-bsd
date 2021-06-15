<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("VBonuscustomerDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_bonuscustomer_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fv_bonuscustomer_detailgrid = new ew.Form("fv_bonuscustomer_detailgrid", "grid");
    fv_bonuscustomer_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_bonuscustomer_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_bonuscustomer_detail)
        ew.vars.tables.v_bonuscustomer_detail = currentTable;
    fv_bonuscustomer_detailgrid.addFields([
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null, ew.Validators.integer], fields.idcustomer.isInvalid],
        ["idinvoice", [fields.idinvoice.visible && fields.idinvoice.required ? ew.Validators.required(fields.idinvoice.caption) : null, ew.Validators.integer], fields.idinvoice.isInvalid],
        ["blackbonus", [fields.blackbonus.visible && fields.blackbonus.required ? ew.Validators.required(fields.blackbonus.caption) : null, ew.Validators.float], fields.blackbonus.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_bonuscustomer_detailgrid,
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
    fv_bonuscustomer_detailgrid.validate = function () {
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
    fv_bonuscustomer_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "blackbonus", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fv_bonuscustomer_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_bonuscustomer_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fv_bonuscustomer_detailgrid.lists.idcustomer = <?= $Grid->idcustomer->toClientList($Grid) ?>;
    fv_bonuscustomer_detailgrid.lists.idinvoice = <?= $Grid->idinvoice->toClientList($Grid) ?>;
    loadjs.done("fv_bonuscustomer_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_bonuscustomer_detail">
<div id="fv_bonuscustomer_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_v_bonuscustomer_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_v_bonuscustomer_detailgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Grid->idcustomer->headerCellClass() ?>"><div id="elh_v_bonuscustomer_detail_idcustomer" class="v_bonuscustomer_detail_idcustomer"><?= $Grid->renderSort($Grid->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->idinvoice->Visible) { // idinvoice ?>
        <th data-name="idinvoice" class="<?= $Grid->idinvoice->headerCellClass() ?>"><div id="elh_v_bonuscustomer_detail_idinvoice" class="v_bonuscustomer_detail_idinvoice"><?= $Grid->renderSort($Grid->idinvoice) ?></div></th>
<?php } ?>
<?php if ($Grid->blackbonus->Visible) { // blackbonus ?>
        <th data-name="blackbonus" class="<?= $Grid->blackbonus->headerCellClass() ?>"><div id="elh_v_bonuscustomer_detail_blackbonus" class="v_bonuscustomer_detail_blackbonus"><?= $Grid->renderSort($Grid->blackbonus) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_v_bonuscustomer_detail", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Grid->idcustomer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_idcustomer" class="form-group"></span>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_idcustomer" class="form-group">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_idcustomer" class="form-group">
<?php
$onchange = $Grid->idcustomer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->idcustomer->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_idcustomer" class="ew-auto-suggest">
    <input type="<?= $Grid->idcustomer->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_idcustomer" id="sv_x<?= $Grid->RowIndex ?>_idcustomer" value="<?= RemoveHtml($Grid->idcustomer->EditValue) ?>" placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>"<?= $Grid->idcustomer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="v_bonuscustomer_detail" data-field="x_idcustomer" data-input="sv_x<?= $Grid->RowIndex ?>_idcustomer" data-value-separator="<?= $Grid->idcustomer->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->idcustomer->getErrorMessage() ?></div>
<script>
loadjs.ready(["fv_bonuscustomer_detailgrid"], function() {
    fv_bonuscustomer_detailgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_idcustomer","forceSelect":false}, ew.vars.tables.v_bonuscustomer_detail.fields.idcustomer.autoSuggestOptions));
});
</script>
<?= $Grid->idcustomer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idcustomer") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<?= $Grid->idcustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idcustomer" data-hidden="1" name="fv_bonuscustomer_detailgrid$x<?= $Grid->RowIndex ?>_idcustomer" id="fv_bonuscustomer_detailgrid$x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idcustomer" data-hidden="1" name="fv_bonuscustomer_detailgrid$o<?= $Grid->RowIndex ?>_idcustomer" id="fv_bonuscustomer_detailgrid$o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idinvoice->Visible) { // idinvoice ?>
        <td data-name="idinvoice" <?= $Grid->idinvoice->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_idinvoice" class="form-group"></span>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idinvoice" id="o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_idinvoice" class="form-group">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idinvoice->getDisplayValue($Grid->idinvoice->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idinvoice" id="x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_idinvoice">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<?= $Grid->idinvoice->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idinvoice" data-hidden="1" name="fv_bonuscustomer_detailgrid$x<?= $Grid->RowIndex ?>_idinvoice" id="fv_bonuscustomer_detailgrid$x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->FormValue) ?>">
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idinvoice" data-hidden="1" name="fv_bonuscustomer_detailgrid$o<?= $Grid->RowIndex ?>_idinvoice" id="fv_bonuscustomer_detailgrid$o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idinvoice" id="x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->blackbonus->Visible) { // blackbonus ?>
        <td data-name="blackbonus" <?= $Grid->blackbonus->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_blackbonus" class="form-group">
<input type="<?= $Grid->blackbonus->getInputTextType() ?>" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" size="30" placeholder="<?= HtmlEncode($Grid->blackbonus->getPlaceHolder()) ?>" value="<?= $Grid->blackbonus->EditValue ?>"<?= $Grid->blackbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->blackbonus->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_blackbonus" id="o<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_blackbonus" class="form-group">
<input type="<?= $Grid->blackbonus->getInputTextType() ?>" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" size="30" placeholder="<?= HtmlEncode($Grid->blackbonus->getPlaceHolder()) ?>" value="<?= $Grid->blackbonus->EditValue ?>"<?= $Grid->blackbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->blackbonus->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_bonuscustomer_detail_blackbonus">
<span<?= $Grid->blackbonus->viewAttributes() ?>>
<?= $Grid->blackbonus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" data-hidden="1" name="fv_bonuscustomer_detailgrid$x<?= $Grid->RowIndex ?>_blackbonus" id="fv_bonuscustomer_detailgrid$x<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->FormValue) ?>">
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" data-hidden="1" name="fv_bonuscustomer_detailgrid$o<?= $Grid->RowIndex ?>_blackbonus" id="fv_bonuscustomer_detailgrid$o<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->OldValue) ?>">
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
loadjs.ready(["fv_bonuscustomer_detailgrid","load"], function () {
    fv_bonuscustomer_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_v_bonuscustomer_detail", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_bonuscustomer_detail_idcustomer" class="form-group v_bonuscustomer_detail_idcustomer"></span>
<?php } else { ?>
<span id="el$rowindex$_v_bonuscustomer_detail_idcustomer" class="form-group v_bonuscustomer_detail_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idinvoice->Visible) { // idinvoice ?>
        <td data-name="idinvoice">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_bonuscustomer_detail_idinvoice" class="form-group v_bonuscustomer_detail_idinvoice"></span>
<?php } else { ?>
<span id="el$rowindex$_v_bonuscustomer_detail_idinvoice" class="form-group v_bonuscustomer_detail_idinvoice">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idinvoice->getDisplayValue($Grid->idinvoice->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idinvoice" id="x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_idinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idinvoice" id="o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->blackbonus->Visible) { // blackbonus ?>
        <td data-name="blackbonus">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_bonuscustomer_detail_blackbonus" class="form-group v_bonuscustomer_detail_blackbonus">
<input type="<?= $Grid->blackbonus->getInputTextType() ?>" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" size="30" placeholder="<?= HtmlEncode($Grid->blackbonus->getPlaceHolder()) ?>" value="<?= $Grid->blackbonus->EditValue ?>"<?= $Grid->blackbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->blackbonus->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_bonuscustomer_detail_blackbonus" class="form-group v_bonuscustomer_detail_blackbonus">
<span<?= $Grid->blackbonus->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->blackbonus->getDisplayValue($Grid->blackbonus->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" data-hidden="1" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bonuscustomer_detail" data-field="x_blackbonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_blackbonus" id="o<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fv_bonuscustomer_detailgrid","load"], function() {
    fv_bonuscustomer_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fv_bonuscustomer_detailgrid">
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
    ew.addEventHandlers("v_bonuscustomer_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
