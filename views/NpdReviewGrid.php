<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("NpdReviewGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_reviewgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnpd_reviewgrid = new ew.Form("fnpd_reviewgrid", "grid");
    fnpd_reviewgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_review)
        ew.vars.tables.npd_review = currentTable;
    fnpd_reviewgrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["idnpd_sample", [fields.idnpd_sample.visible && fields.idnpd_sample.required ? ew.Validators.required(fields.idnpd_sample.caption) : null], fields.idnpd_sample.isInvalid],
        ["tanggal_review", [fields.tanggal_review.visible && fields.tanggal_review.required ? ew.Validators.required(fields.tanggal_review.caption) : null, ew.Validators.datetime(0)], fields.tanggal_review.isInvalid],
        ["tanggal_submit", [fields.tanggal_submit.visible && fields.tanggal_submit.required ? ew.Validators.required(fields.tanggal_submit.caption) : null, ew.Validators.datetime(0)], fields.tanggal_submit.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["review_by", [fields.review_by.visible && fields.review_by.required ? ew.Validators.required(fields.review_by.caption) : null], fields.review_by.isInvalid],
        ["receipt_by", [fields.receipt_by.visible && fields.receipt_by.required ? ew.Validators.required(fields.receipt_by.caption) : null], fields.receipt_by.isInvalid],
        ["checked_by", [fields.checked_by.visible && fields.checked_by.required ? ew.Validators.required(fields.checked_by.caption) : null], fields.checked_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_reviewgrid,
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
    fnpd_reviewgrid.validate = function () {
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
    fnpd_reviewgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idnpd_sample", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tanggal_review", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tanggal_submit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "review_by", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "receipt_by", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "checked_by", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnpd_reviewgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_reviewgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_reviewgrid.lists.idnpd = <?= $Grid->idnpd->toClientList($Grid) ?>;
    fnpd_reviewgrid.lists.idnpd_sample = <?= $Grid->idnpd_sample->toClientList($Grid) ?>;
    fnpd_reviewgrid.lists.status = <?= $Grid->status->toClientList($Grid) ?>;
    fnpd_reviewgrid.lists.review_by = <?= $Grid->review_by->toClientList($Grid) ?>;
    fnpd_reviewgrid.lists.receipt_by = <?= $Grid->receipt_by->toClientList($Grid) ?>;
    fnpd_reviewgrid.lists.checked_by = <?= $Grid->checked_by->toClientList($Grid) ?>;
    loadjs.done("fnpd_reviewgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_review">
<div id="fnpd_reviewgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_npd_review" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_npd_reviewgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_npd_review_idnpd" class="npd_review_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <th data-name="idnpd_sample" class="<?= $Grid->idnpd_sample->headerCellClass() ?>"><div id="elh_npd_review_idnpd_sample" class="npd_review_idnpd_sample"><?= $Grid->renderSort($Grid->idnpd_sample) ?></div></th>
<?php } ?>
<?php if ($Grid->tanggal_review->Visible) { // tanggal_review ?>
        <th data-name="tanggal_review" class="<?= $Grid->tanggal_review->headerCellClass() ?>"><div id="elh_npd_review_tanggal_review" class="npd_review_tanggal_review"><?= $Grid->renderSort($Grid->tanggal_review) ?></div></th>
<?php } ?>
<?php if ($Grid->tanggal_submit->Visible) { // tanggal_submit ?>
        <th data-name="tanggal_submit" class="<?= $Grid->tanggal_submit->headerCellClass() ?>"><div id="elh_npd_review_tanggal_submit" class="npd_review_tanggal_submit"><?= $Grid->renderSort($Grid->tanggal_submit) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_npd_review_status" class="npd_review_status"><?= $Grid->renderSort($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->review_by->Visible) { // review_by ?>
        <th data-name="review_by" class="<?= $Grid->review_by->headerCellClass() ?>"><div id="elh_npd_review_review_by" class="npd_review_review_by"><?= $Grid->renderSort($Grid->review_by) ?></div></th>
<?php } ?>
<?php if ($Grid->receipt_by->Visible) { // receipt_by ?>
        <th data-name="receipt_by" class="<?= $Grid->receipt_by->headerCellClass() ?>"><div id="elh_npd_review_receipt_by" class="npd_review_receipt_by"><?= $Grid->renderSort($Grid->receipt_by) ?></div></th>
<?php } ?>
<?php if ($Grid->checked_by->Visible) { // checked_by ?>
        <th data-name="checked_by" class="<?= $Grid->checked_by->headerCellClass() ?>"><div id="elh_npd_review_checked_by" class="npd_review_checked_by"><?= $Grid->renderSort($Grid->checked_by) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_npd_review", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_review"
        data-field="x_idnpd"
        data-value-separator="<?= $Grid->idnpd->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>"
        <?= $Grid->idnpd->editAttributes() ?>>
        <?= $Grid->idnpd->selectOptionListHtml("x{$Grid->RowIndex}_idnpd") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
<?= $Grid->idnpd->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_review_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_review"
        data-field="x_idnpd"
        data-value-separator="<?= $Grid->idnpd->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>"
        <?= $Grid->idnpd->editAttributes() ?>>
        <?= $Grid->idnpd->selectOptionListHtml("x{$Grid->RowIndex}_idnpd") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
<?= $Grid->idnpd->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_review_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_idnpd" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_idnpd" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_idnpd" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_idnpd" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <td data-name="idnpd_sample" <?= $Grid->idnpd_sample->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd_sample" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_review"
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
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="npd_review" data-field="x_idnpd_sample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd_sample" id="o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd_sample" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_review"
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
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_idnpd_sample">
<span<?= $Grid->idnpd_sample->viewAttributes() ?>>
<?= $Grid->idnpd_sample->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_idnpd_sample" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_idnpd_sample" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_idnpd_sample" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_idnpd_sample" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_review->Visible) { // tanggal_review ?>
        <td data-name="tanggal_review" <?= $Grid->tanggal_review->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_tanggal_review" class="form-group">
<input type="<?= $Grid->tanggal_review->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_review" name="x<?= $Grid->RowIndex ?>_tanggal_review" id="x<?= $Grid->RowIndex ?>_tanggal_review" placeholder="<?= HtmlEncode($Grid->tanggal_review->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_review->EditValue ?>"<?= $Grid->tanggal_review->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_review->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_review->ReadOnly && !$Grid->tanggal_review->Disabled && !isset($Grid->tanggal_review->EditAttrs["readonly"]) && !isset($Grid->tanggal_review->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewgrid", "x<?= $Grid->RowIndex ?>_tanggal_review", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_review" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_review" id="o<?= $Grid->RowIndex ?>_tanggal_review" value="<?= HtmlEncode($Grid->tanggal_review->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_tanggal_review" class="form-group">
<input type="<?= $Grid->tanggal_review->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_review" name="x<?= $Grid->RowIndex ?>_tanggal_review" id="x<?= $Grid->RowIndex ?>_tanggal_review" placeholder="<?= HtmlEncode($Grid->tanggal_review->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_review->EditValue ?>"<?= $Grid->tanggal_review->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_review->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_review->ReadOnly && !$Grid->tanggal_review->Disabled && !isset($Grid->tanggal_review->EditAttrs["readonly"]) && !isset($Grid->tanggal_review->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewgrid", "x<?= $Grid->RowIndex ?>_tanggal_review", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_tanggal_review">
<span<?= $Grid->tanggal_review->viewAttributes() ?>>
<?= $Grid->tanggal_review->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_review" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_tanggal_review" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_tanggal_review" value="<?= HtmlEncode($Grid->tanggal_review->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_tanggal_review" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_tanggal_review" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_tanggal_review" value="<?= HtmlEncode($Grid->tanggal_review->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_submit->Visible) { // tanggal_submit ?>
        <td data-name="tanggal_submit" <?= $Grid->tanggal_submit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_tanggal_submit" class="form-group">
<input type="<?= $Grid->tanggal_submit->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_submit" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" placeholder="<?= HtmlEncode($Grid->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_submit->EditValue ?>"<?= $Grid->tanggal_submit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_submit->ReadOnly && !$Grid->tanggal_submit->Disabled && !isset($Grid->tanggal_submit->EditAttrs["readonly"]) && !isset($Grid->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewgrid", "x<?= $Grid->RowIndex ?>_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_submit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_submit" id="o<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_tanggal_submit" class="form-group">
<input type="<?= $Grid->tanggal_submit->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_submit" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" placeholder="<?= HtmlEncode($Grid->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_submit->EditValue ?>"<?= $Grid->tanggal_submit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_submit->ReadOnly && !$Grid->tanggal_submit->Disabled && !isset($Grid->tanggal_submit->EditAttrs["readonly"]) && !isset($Grid->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewgrid", "x<?= $Grid->RowIndex ?>_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_tanggal_submit">
<span<?= $Grid->tanggal_submit->viewAttributes() ?>>
<?= $Grid->tanggal_submit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_submit" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_tanggal_submit" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_tanggal_submit" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_tanggal_submit" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status" <?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_status" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status"<?= $Grid->status->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status"
    name="x<?= $Grid->RowIndex ?>_status"
    value="<?= HtmlEncode($Grid->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_status"
    data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_review" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_status" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status"<?= $Grid->status->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status"
    name="x<?= $Grid->RowIndex ?>_status"
    value="<?= HtmlEncode($Grid->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_status"
    data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_status" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_status" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_status" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_status" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->review_by->Visible) { // review_by ?>
        <td data-name="review_by" <?= $Grid->review_by->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_review_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_review_by"
        name="x<?= $Grid->RowIndex ?>_review_by"
        class="form-control ew-select<?= $Grid->review_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_review_by"
        data-table="npd_review"
        data-field="x_review_by"
        data-value-separator="<?= $Grid->review_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->review_by->getPlaceHolder()) ?>"
        <?= $Grid->review_by->editAttributes() ?>>
        <?= $Grid->review_by->selectOptionListHtml("x{$Grid->RowIndex}_review_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->review_by->getErrorMessage() ?></div>
<?= $Grid->review_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_review_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_review_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_review_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_review_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.review_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="npd_review" data-field="x_review_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_review_by" id="o<?= $Grid->RowIndex ?>_review_by" value="<?= HtmlEncode($Grid->review_by->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_review_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_review_by"
        name="x<?= $Grid->RowIndex ?>_review_by"
        class="form-control ew-select<?= $Grid->review_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_review_by"
        data-table="npd_review"
        data-field="x_review_by"
        data-value-separator="<?= $Grid->review_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->review_by->getPlaceHolder()) ?>"
        <?= $Grid->review_by->editAttributes() ?>>
        <?= $Grid->review_by->selectOptionListHtml("x{$Grid->RowIndex}_review_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->review_by->getErrorMessage() ?></div>
<?= $Grid->review_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_review_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_review_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_review_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_review_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.review_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_review_by">
<span<?= $Grid->review_by->viewAttributes() ?>>
<?= $Grid->review_by->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_review_by" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_review_by" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_review_by" value="<?= HtmlEncode($Grid->review_by->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_review_by" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_review_by" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_review_by" value="<?= HtmlEncode($Grid->review_by->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->receipt_by->Visible) { // receipt_by ?>
        <td data-name="receipt_by" <?= $Grid->receipt_by->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_receipt_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_receipt_by"
        name="x<?= $Grid->RowIndex ?>_receipt_by"
        class="form-control ew-select<?= $Grid->receipt_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_receipt_by"
        data-table="npd_review"
        data-field="x_receipt_by"
        data-value-separator="<?= $Grid->receipt_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->receipt_by->getPlaceHolder()) ?>"
        <?= $Grid->receipt_by->editAttributes() ?>>
        <?= $Grid->receipt_by->selectOptionListHtml("x{$Grid->RowIndex}_receipt_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->receipt_by->getErrorMessage() ?></div>
<?= $Grid->receipt_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_receipt_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_receipt_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_receipt_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_receipt_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.receipt_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="npd_review" data-field="x_receipt_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receipt_by" id="o<?= $Grid->RowIndex ?>_receipt_by" value="<?= HtmlEncode($Grid->receipt_by->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_receipt_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_receipt_by"
        name="x<?= $Grid->RowIndex ?>_receipt_by"
        class="form-control ew-select<?= $Grid->receipt_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_receipt_by"
        data-table="npd_review"
        data-field="x_receipt_by"
        data-value-separator="<?= $Grid->receipt_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->receipt_by->getPlaceHolder()) ?>"
        <?= $Grid->receipt_by->editAttributes() ?>>
        <?= $Grid->receipt_by->selectOptionListHtml("x{$Grid->RowIndex}_receipt_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->receipt_by->getErrorMessage() ?></div>
<?= $Grid->receipt_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_receipt_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_receipt_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_receipt_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_receipt_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.receipt_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_receipt_by">
<span<?= $Grid->receipt_by->viewAttributes() ?>>
<?= $Grid->receipt_by->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_receipt_by" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_receipt_by" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_receipt_by" value="<?= HtmlEncode($Grid->receipt_by->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_receipt_by" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_receipt_by" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_receipt_by" value="<?= HtmlEncode($Grid->receipt_by->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->checked_by->Visible) { // checked_by ?>
        <td data-name="checked_by" <?= $Grid->checked_by->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_checked_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_checked_by"
        name="x<?= $Grid->RowIndex ?>_checked_by"
        class="form-control ew-select<?= $Grid->checked_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_checked_by"
        data-table="npd_review"
        data-field="x_checked_by"
        data-value-separator="<?= $Grid->checked_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->checked_by->getPlaceHolder()) ?>"
        <?= $Grid->checked_by->editAttributes() ?>>
        <?= $Grid->checked_by->selectOptionListHtml("x{$Grid->RowIndex}_checked_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->checked_by->getErrorMessage() ?></div>
<?= $Grid->checked_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_checked_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_checked_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_checked_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_checked_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.checked_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="npd_review" data-field="x_checked_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_checked_by" id="o<?= $Grid->RowIndex ?>_checked_by" value="<?= HtmlEncode($Grid->checked_by->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_checked_by" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_checked_by"
        name="x<?= $Grid->RowIndex ?>_checked_by"
        class="form-control ew-select<?= $Grid->checked_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_checked_by"
        data-table="npd_review"
        data-field="x_checked_by"
        data-value-separator="<?= $Grid->checked_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->checked_by->getPlaceHolder()) ?>"
        <?= $Grid->checked_by->editAttributes() ?>>
        <?= $Grid->checked_by->selectOptionListHtml("x{$Grid->RowIndex}_checked_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->checked_by->getErrorMessage() ?></div>
<?= $Grid->checked_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_checked_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_checked_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_checked_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_checked_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.checked_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_review_checked_by">
<span<?= $Grid->checked_by->viewAttributes() ?>>
<?= $Grid->checked_by->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_review" data-field="x_checked_by" data-hidden="1" name="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_checked_by" id="fnpd_reviewgrid$x<?= $Grid->RowIndex ?>_checked_by" value="<?= HtmlEncode($Grid->checked_by->FormValue) ?>">
<input type="hidden" data-table="npd_review" data-field="x_checked_by" data-hidden="1" name="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_checked_by" id="fnpd_reviewgrid$o<?= $Grid->RowIndex ?>_checked_by" value="<?= HtmlEncode($Grid->checked_by->OldValue) ?>">
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
loadjs.ready(["fnpd_reviewgrid","load"], function () {
    fnpd_reviewgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_npd_review", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_npd_review_idnpd" class="form-group npd_review_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_npd_review_idnpd" class="form-group npd_review_idnpd">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_review"
        data-field="x_idnpd"
        data-value-separator="<?= $Grid->idnpd->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>"
        <?= $Grid->idnpd->editAttributes() ?>>
        <?= $Grid->idnpd->selectOptionListHtml("x{$Grid->RowIndex}_idnpd") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
<?= $Grid->idnpd->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_review_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_npd_review_idnpd" class="form-group npd_review_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <td data-name="idnpd_sample">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_review_idnpd_sample" class="form-group npd_review_idnpd_sample">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_review"
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
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_review_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_review_idnpd_sample" class="form-group npd_review_idnpd_sample">
<span<?= $Grid->idnpd_sample->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd_sample->getDisplayValue($Grid->idnpd_sample->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_idnpd_sample" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd_sample" id="x<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_idnpd_sample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd_sample" id="o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_review->Visible) { // tanggal_review ?>
        <td data-name="tanggal_review">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_review_tanggal_review" class="form-group npd_review_tanggal_review">
<input type="<?= $Grid->tanggal_review->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_review" name="x<?= $Grid->RowIndex ?>_tanggal_review" id="x<?= $Grid->RowIndex ?>_tanggal_review" placeholder="<?= HtmlEncode($Grid->tanggal_review->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_review->EditValue ?>"<?= $Grid->tanggal_review->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_review->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_review->ReadOnly && !$Grid->tanggal_review->Disabled && !isset($Grid->tanggal_review->EditAttrs["readonly"]) && !isset($Grid->tanggal_review->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewgrid", "x<?= $Grid->RowIndex ?>_tanggal_review", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_review_tanggal_review" class="form-group npd_review_tanggal_review">
<span<?= $Grid->tanggal_review->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal_review->getDisplayValue($Grid->tanggal_review->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_review" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal_review" id="x<?= $Grid->RowIndex ?>_tanggal_review" value="<?= HtmlEncode($Grid->tanggal_review->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_review" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_review" id="o<?= $Grid->RowIndex ?>_tanggal_review" value="<?= HtmlEncode($Grid->tanggal_review->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tanggal_submit->Visible) { // tanggal_submit ?>
        <td data-name="tanggal_submit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_review_tanggal_submit" class="form-group npd_review_tanggal_submit">
<input type="<?= $Grid->tanggal_submit->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_submit" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" placeholder="<?= HtmlEncode($Grid->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Grid->tanggal_submit->EditValue ?>"<?= $Grid->tanggal_submit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal_submit->ReadOnly && !$Grid->tanggal_submit->Disabled && !isset($Grid->tanggal_submit->EditAttrs["readonly"]) && !isset($Grid->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewgrid", "x<?= $Grid->RowIndex ?>_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_review_tanggal_submit" class="form-group npd_review_tanggal_submit">
<span<?= $Grid->tanggal_submit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal_submit->getDisplayValue($Grid->tanggal_submit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_submit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal_submit" id="x<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_tanggal_submit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal_submit" id="o<?= $Grid->RowIndex ?>_tanggal_submit" value="<?= HtmlEncode($Grid->tanggal_submit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_review_status" class="form-group npd_review_status">
<template id="tp_x<?= $Grid->RowIndex ?>_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status"<?= $Grid->status->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_status" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_status"
    name="x<?= $Grid->RowIndex ?>_status"
    value="<?= HtmlEncode($Grid->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_status"
    data-target="dsl_x<?= $Grid->RowIndex ?>_status"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->status->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_status"
    data-value-separator="<?= $Grid->status->displayValueSeparatorAttribute() ?>"
    <?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_review_status" class="form-group npd_review_status">
<span<?= $Grid->status->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status->getDisplayValue($Grid->status->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->review_by->Visible) { // review_by ?>
        <td data-name="review_by">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_review_review_by" class="form-group npd_review_review_by">
    <select
        id="x<?= $Grid->RowIndex ?>_review_by"
        name="x<?= $Grid->RowIndex ?>_review_by"
        class="form-control ew-select<?= $Grid->review_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_review_by"
        data-table="npd_review"
        data-field="x_review_by"
        data-value-separator="<?= $Grid->review_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->review_by->getPlaceHolder()) ?>"
        <?= $Grid->review_by->editAttributes() ?>>
        <?= $Grid->review_by->selectOptionListHtml("x{$Grid->RowIndex}_review_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->review_by->getErrorMessage() ?></div>
<?= $Grid->review_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_review_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_review_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_review_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_review_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.review_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_review_review_by" class="form-group npd_review_review_by">
<span<?= $Grid->review_by->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->review_by->getDisplayValue($Grid->review_by->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_review_by" data-hidden="1" name="x<?= $Grid->RowIndex ?>_review_by" id="x<?= $Grid->RowIndex ?>_review_by" value="<?= HtmlEncode($Grid->review_by->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_review_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_review_by" id="o<?= $Grid->RowIndex ?>_review_by" value="<?= HtmlEncode($Grid->review_by->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->receipt_by->Visible) { // receipt_by ?>
        <td data-name="receipt_by">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_review_receipt_by" class="form-group npd_review_receipt_by">
    <select
        id="x<?= $Grid->RowIndex ?>_receipt_by"
        name="x<?= $Grid->RowIndex ?>_receipt_by"
        class="form-control ew-select<?= $Grid->receipt_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_receipt_by"
        data-table="npd_review"
        data-field="x_receipt_by"
        data-value-separator="<?= $Grid->receipt_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->receipt_by->getPlaceHolder()) ?>"
        <?= $Grid->receipt_by->editAttributes() ?>>
        <?= $Grid->receipt_by->selectOptionListHtml("x{$Grid->RowIndex}_receipt_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->receipt_by->getErrorMessage() ?></div>
<?= $Grid->receipt_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_receipt_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_receipt_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_receipt_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_receipt_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.receipt_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_review_receipt_by" class="form-group npd_review_receipt_by">
<span<?= $Grid->receipt_by->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->receipt_by->getDisplayValue($Grid->receipt_by->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_receipt_by" data-hidden="1" name="x<?= $Grid->RowIndex ?>_receipt_by" id="x<?= $Grid->RowIndex ?>_receipt_by" value="<?= HtmlEncode($Grid->receipt_by->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_receipt_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_receipt_by" id="o<?= $Grid->RowIndex ?>_receipt_by" value="<?= HtmlEncode($Grid->receipt_by->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->checked_by->Visible) { // checked_by ?>
        <td data-name="checked_by">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_review_checked_by" class="form-group npd_review_checked_by">
    <select
        id="x<?= $Grid->RowIndex ?>_checked_by"
        name="x<?= $Grid->RowIndex ?>_checked_by"
        class="form-control ew-select<?= $Grid->checked_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x<?= $Grid->RowIndex ?>_checked_by"
        data-table="npd_review"
        data-field="x_checked_by"
        data-value-separator="<?= $Grid->checked_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->checked_by->getPlaceHolder()) ?>"
        <?= $Grid->checked_by->editAttributes() ?>>
        <?= $Grid->checked_by->selectOptionListHtml("x{$Grid->RowIndex}_checked_by") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->checked_by->getErrorMessage() ?></div>
<?= $Grid->checked_by->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_checked_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x<?= $Grid->RowIndex ?>_checked_by']"),
        options = { name: "x<?= $Grid->RowIndex ?>_checked_by", selectId: "npd_review_x<?= $Grid->RowIndex ?>_checked_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.checked_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_review_checked_by" class="form-group npd_review_checked_by">
<span<?= $Grid->checked_by->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->checked_by->getDisplayValue($Grid->checked_by->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_review" data-field="x_checked_by" data-hidden="1" name="x<?= $Grid->RowIndex ?>_checked_by" id="x<?= $Grid->RowIndex ?>_checked_by" value="<?= HtmlEncode($Grid->checked_by->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_review" data-field="x_checked_by" data-hidden="1" name="o<?= $Grid->RowIndex ?>_checked_by" id="o<?= $Grid->RowIndex ?>_checked_by" value="<?= HtmlEncode($Grid->checked_by->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnpd_reviewgrid","load"], function() {
    fnpd_reviewgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fnpd_reviewgrid">
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
    ew.addEventHandlers("npd_review");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
