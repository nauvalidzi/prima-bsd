<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("RedeembonusGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fredeembonusgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fredeembonusgrid = new ew.Form("fredeembonusgrid", "grid");
    fredeembonusgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "redeembonus")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.redeembonus)
        ew.vars.tables.redeembonus = currentTable;
    fredeembonusgrid.addFields([
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid],
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.datetime(0)], fields.tanggal.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fredeembonusgrid,
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
    fredeembonusgrid.validate = function () {
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
    fredeembonusgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idcustomer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlah", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tanggal", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fredeembonusgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fredeembonusgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fredeembonusgrid.lists.idcustomer = <?= $Grid->idcustomer->toClientList($Grid) ?>;
    loadjs.done("fredeembonusgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> redeembonus">
<div id="fredeembonusgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_redeembonus" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_redeembonusgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idcustomer" class="<?= $Grid->idcustomer->headerCellClass() ?>"><div id="elh_redeembonus_idcustomer" class="redeembonus_idcustomer"><?= $Grid->renderSort($Grid->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <th data-name="jumlah" class="<?= $Grid->jumlah->headerCellClass() ?>"><div id="elh_redeembonus_jumlah" class="redeembonus_jumlah"><?= $Grid->renderSort($Grid->jumlah) ?></div></th>
<?php } ?>
<?php if ($Grid->tanggal->Visible) { // tanggal ?>
        <th data-name="tanggal" class="<?= $Grid->tanggal->headerCellClass() ?>"><div id="elh_redeembonus_tanggal" class="redeembonus_tanggal"><?= $Grid->renderSort($Grid->tanggal) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_redeembonus", "data-rowtype" => $Grid->RowType]);

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
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_idcustomer" class="form-group">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_idcustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="redeembonus_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="redeembonus"
        data-field="x_idcustomer"
        data-value-separator="<?= $Grid->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>"
        <?= $Grid->idcustomer->editAttributes() ?>>
        <?= $Grid->idcustomer->selectOptionListHtml("x{$Grid->RowIndex}_idcustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idcustomer->getErrorMessage() ?></div>
<?= $Grid->idcustomer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='redeembonus_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "redeembonus_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.redeembonus.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="redeembonus" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_idcustomer" class="form-group">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_idcustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="redeembonus_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="redeembonus"
        data-field="x_idcustomer"
        data-value-separator="<?= $Grid->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>"
        <?= $Grid->idcustomer->editAttributes() ?>>
        <?= $Grid->idcustomer->selectOptionListHtml("x{$Grid->RowIndex}_idcustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idcustomer->getErrorMessage() ?></div>
<?= $Grid->idcustomer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='redeembonus_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "redeembonus_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.redeembonus.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<?= $Grid->idcustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="redeembonus" data-field="x_idcustomer" data-hidden="1" name="fredeembonusgrid$x<?= $Grid->RowIndex ?>_idcustomer" id="fredeembonusgrid$x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<input type="hidden" data-table="redeembonus" data-field="x_idcustomer" data-hidden="1" name="fredeembonusgrid$o<?= $Grid->RowIndex ?>_idcustomer" id="fredeembonusgrid$o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah" <?= $Grid->jumlah->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="redeembonus" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="redeembonus" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="redeembonus" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<?= $Grid->jumlah->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="redeembonus" data-field="x_jumlah" data-hidden="1" name="fredeembonusgrid$x<?= $Grid->RowIndex ?>_jumlah" id="fredeembonusgrid$x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<input type="hidden" data-table="redeembonus" data-field="x_jumlah" data-hidden="1" name="fredeembonusgrid$o<?= $Grid->RowIndex ?>_jumlah" id="fredeembonusgrid$o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tanggal->Visible) { // tanggal ?>
        <td data-name="tanggal" <?= $Grid->tanggal->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_tanggal" class="form-group">
<input type="<?= $Grid->tanggal->getInputTextType() ?>" data-table="redeembonus" data-field="x_tanggal" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" placeholder="<?= HtmlEncode($Grid->tanggal->getPlaceHolder()) ?>" value="<?= $Grid->tanggal->EditValue ?>"<?= $Grid->tanggal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal->ReadOnly && !$Grid->tanggal->Disabled && !isset($Grid->tanggal->EditAttrs["readonly"]) && !isset($Grid->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fredeembonusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fredeembonusgrid", "x<?= $Grid->RowIndex ?>_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="redeembonus" data-field="x_tanggal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal" id="o<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_tanggal" class="form-group">
<input type="<?= $Grid->tanggal->getInputTextType() ?>" data-table="redeembonus" data-field="x_tanggal" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" placeholder="<?= HtmlEncode($Grid->tanggal->getPlaceHolder()) ?>" value="<?= $Grid->tanggal->EditValue ?>"<?= $Grid->tanggal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal->ReadOnly && !$Grid->tanggal->Disabled && !isset($Grid->tanggal->EditAttrs["readonly"]) && !isset($Grid->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fredeembonusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fredeembonusgrid", "x<?= $Grid->RowIndex ?>_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_redeembonus_tanggal">
<span<?= $Grid->tanggal->viewAttributes() ?>>
<?= $Grid->tanggal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="redeembonus" data-field="x_tanggal" data-hidden="1" name="fredeembonusgrid$x<?= $Grid->RowIndex ?>_tanggal" id="fredeembonusgrid$x<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->FormValue) ?>">
<input type="hidden" data-table="redeembonus" data-field="x_tanggal" data-hidden="1" name="fredeembonusgrid$o<?= $Grid->RowIndex ?>_tanggal" id="fredeembonusgrid$o<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->OldValue) ?>">
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
loadjs.ready(["fredeembonusgrid","load"], function () {
    fredeembonusgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_redeembonus", "data-rowtype" => ROWTYPE_ADD]);
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
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el$rowindex$_redeembonus_idcustomer" class="form-group redeembonus_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_redeembonus_idcustomer" class="form-group redeembonus_idcustomer">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="redeembonus_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="redeembonus"
        data-field="x_idcustomer"
        data-value-separator="<?= $Grid->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idcustomer->getPlaceHolder()) ?>"
        <?= $Grid->idcustomer->editAttributes() ?>>
        <?= $Grid->idcustomer->selectOptionListHtml("x{$Grid->RowIndex}_idcustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idcustomer->getErrorMessage() ?></div>
<?= $Grid->idcustomer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='redeembonus_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "redeembonus_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.redeembonus.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_redeembonus_idcustomer" class="form-group redeembonus_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="redeembonus" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="redeembonus" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_redeembonus_jumlah" class="form-group redeembonus_jumlah">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="redeembonus" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_redeembonus_jumlah" class="form-group redeembonus_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlah->getDisplayValue($Grid->jumlah->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="redeembonus" data-field="x_jumlah" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="redeembonus" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tanggal->Visible) { // tanggal ?>
        <td data-name="tanggal">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_redeembonus_tanggal" class="form-group redeembonus_tanggal">
<input type="<?= $Grid->tanggal->getInputTextType() ?>" data-table="redeembonus" data-field="x_tanggal" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" placeholder="<?= HtmlEncode($Grid->tanggal->getPlaceHolder()) ?>" value="<?= $Grid->tanggal->EditValue ?>"<?= $Grid->tanggal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal->getErrorMessage() ?></div>
<?php if (!$Grid->tanggal->ReadOnly && !$Grid->tanggal->Disabled && !isset($Grid->tanggal->EditAttrs["readonly"]) && !isset($Grid->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fredeembonusgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fredeembonusgrid", "x<?= $Grid->RowIndex ?>_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_redeembonus_tanggal" class="form-group redeembonus_tanggal">
<span<?= $Grid->tanggal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal->getDisplayValue($Grid->tanggal->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="redeembonus" data-field="x_tanggal" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="redeembonus" data-field="x_tanggal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal" id="o<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fredeembonusgrid","load"], function() {
    fredeembonusgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fredeembonusgrid">
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
    ew.addEventHandlers("redeembonus");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
