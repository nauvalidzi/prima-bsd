<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("SuratjalanDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsuratjalan_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsuratjalan_detailgrid = new ew.Form("fsuratjalan_detailgrid", "grid");
    fsuratjalan_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "suratjalan_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.suratjalan_detail)
        ew.vars.tables.suratjalan_detail = currentTable;
    fsuratjalan_detailgrid.addFields([
        ["idinvoice", [fields.idinvoice.visible && fields.idinvoice.required ? ew.Validators.required(fields.idinvoice.caption) : null], fields.idinvoice.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsuratjalan_detailgrid,
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
    fsuratjalan_detailgrid.validate = function () {
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
    fsuratjalan_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idinvoice", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "keterangan", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsuratjalan_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsuratjalan_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsuratjalan_detailgrid.lists.idinvoice = <?= $Grid->idinvoice->toClientList($Grid) ?>;
    loadjs.done("fsuratjalan_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> suratjalan_detail">
<div id="fsuratjalan_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_suratjalan_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_suratjalan_detailgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idinvoice" class="<?= $Grid->idinvoice->headerCellClass() ?>"><div id="elh_suratjalan_detail_idinvoice" class="suratjalan_detail_idinvoice"><?= $Grid->renderSort($Grid->idinvoice) ?></div></th>
<?php } ?>
<?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Grid->keterangan->headerCellClass() ?>"><div id="elh_suratjalan_detail_keterangan" class="suratjalan_detail_keterangan"><?= $Grid->renderSort($Grid->keterangan) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_suratjalan_detail", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_suratjalan_detail_idinvoice" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idinvoice"
        name="x<?= $Grid->RowIndex ?>_idinvoice"
        class="form-control ew-select<?= $Grid->idinvoice->isInvalidClass() ?>"
        data-select2-id="suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice"
        data-table="suratjalan_detail"
        data-field="x_idinvoice"
        data-value-separator="<?= $Grid->idinvoice->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idinvoice->getPlaceHolder()) ?>"
        <?= $Grid->idinvoice->editAttributes() ?>>
        <?= $Grid->idinvoice->selectOptionListHtml("x{$Grid->RowIndex}_idinvoice") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idinvoice->getErrorMessage() ?></div>
<?= $Grid->idinvoice->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idinvoice") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idinvoice", selectId: "suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.suratjalan_detail.fields.idinvoice.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="suratjalan_detail" data-field="x_idinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idinvoice" id="o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_suratjalan_detail_idinvoice" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idinvoice"
        name="x<?= $Grid->RowIndex ?>_idinvoice"
        class="form-control ew-select<?= $Grid->idinvoice->isInvalidClass() ?>"
        data-select2-id="suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice"
        data-table="suratjalan_detail"
        data-field="x_idinvoice"
        data-value-separator="<?= $Grid->idinvoice->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idinvoice->getPlaceHolder()) ?>"
        <?= $Grid->idinvoice->editAttributes() ?>>
        <?= $Grid->idinvoice->selectOptionListHtml("x{$Grid->RowIndex}_idinvoice") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idinvoice->getErrorMessage() ?></div>
<?= $Grid->idinvoice->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idinvoice") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idinvoice", selectId: "suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.suratjalan_detail.fields.idinvoice.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_suratjalan_detail_idinvoice">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<?= $Grid->idinvoice->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="suratjalan_detail" data-field="x_idinvoice" data-hidden="1" name="fsuratjalan_detailgrid$x<?= $Grid->RowIndex ?>_idinvoice" id="fsuratjalan_detailgrid$x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->FormValue) ?>">
<input type="hidden" data-table="suratjalan_detail" data-field="x_idinvoice" data-hidden="1" name="fsuratjalan_detailgrid$o<?= $Grid->RowIndex ?>_idinvoice" id="fsuratjalan_detailgrid$o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Grid->keterangan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_suratjalan_detail_keterangan" class="form-group">
<input type="<?= $Grid->keterangan->getInputTextType() ?>" data-table="suratjalan_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>" value="<?= $Grid->keterangan->EditValue ?>"<?= $Grid->keterangan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="suratjalan_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_suratjalan_detail_keterangan" class="form-group">
<input type="<?= $Grid->keterangan->getInputTextType() ?>" data-table="suratjalan_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>" value="<?= $Grid->keterangan->EditValue ?>"<?= $Grid->keterangan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_suratjalan_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="suratjalan_detail" data-field="x_keterangan" data-hidden="1" name="fsuratjalan_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" id="fsuratjalan_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<input type="hidden" data-table="suratjalan_detail" data-field="x_keterangan" data-hidden="1" name="fsuratjalan_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" id="fsuratjalan_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
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
loadjs.ready(["fsuratjalan_detailgrid","load"], function () {
    fsuratjalan_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_suratjalan_detail", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_suratjalan_detail_idinvoice" class="form-group suratjalan_detail_idinvoice">
    <select
        id="x<?= $Grid->RowIndex ?>_idinvoice"
        name="x<?= $Grid->RowIndex ?>_idinvoice"
        class="form-control ew-select<?= $Grid->idinvoice->isInvalidClass() ?>"
        data-select2-id="suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice"
        data-table="suratjalan_detail"
        data-field="x_idinvoice"
        data-value-separator="<?= $Grid->idinvoice->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idinvoice->getPlaceHolder()) ?>"
        <?= $Grid->idinvoice->editAttributes() ?>>
        <?= $Grid->idinvoice->selectOptionListHtml("x{$Grid->RowIndex}_idinvoice") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idinvoice->getErrorMessage() ?></div>
<?= $Grid->idinvoice->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idinvoice") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idinvoice", selectId: "suratjalan_detail_x<?= $Grid->RowIndex ?>_idinvoice", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.suratjalan_detail.fields.idinvoice.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_suratjalan_detail_idinvoice" class="form-group suratjalan_detail_idinvoice">
<span<?= $Grid->idinvoice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idinvoice->getDisplayValue($Grid->idinvoice->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="suratjalan_detail" data-field="x_idinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idinvoice" id="x<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="suratjalan_detail" data-field="x_idinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idinvoice" id="o<?= $Grid->RowIndex ?>_idinvoice" value="<?= HtmlEncode($Grid->idinvoice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_suratjalan_detail_keterangan" class="form-group suratjalan_detail_keterangan">
<input type="<?= $Grid->keterangan->getInputTextType() ?>" data-table="suratjalan_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>" value="<?= $Grid->keterangan->EditValue ?>"<?= $Grid->keterangan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_suratjalan_detail_keterangan" class="form-group suratjalan_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->keterangan->getDisplayValue($Grid->keterangan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="suratjalan_detail" data-field="x_keterangan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="suratjalan_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsuratjalan_detailgrid","load"], function() {
    fsuratjalan_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fsuratjalan_detailgrid">
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
    ew.addEventHandlers("suratjalan_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Grid->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_suratjalan_detail",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
