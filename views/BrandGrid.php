<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("BrandGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fbrandgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fbrandgrid = new ew.Form("fbrandgrid", "grid");
    fbrandgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "brand")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.brand)
        ew.vars.tables.brand = currentTable;
    fbrandgrid.addFields([
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["titipmerk", [fields.titipmerk.visible && fields.titipmerk.required ? ew.Validators.required(fields.titipmerk.caption) : null], fields.titipmerk.isInvalid],
        ["ijinhaki", [fields.ijinhaki.visible && fields.ijinhaki.required ? ew.Validators.required(fields.ijinhaki.caption) : null], fields.ijinhaki.isInvalid],
        ["ijinbpom", [fields.ijinbpom.visible && fields.ijinbpom.required ? ew.Validators.required(fields.ijinbpom.caption) : null], fields.ijinbpom.isInvalid],
        ["aktif", [fields.aktif.visible && fields.aktif.required ? ew.Validators.required(fields.aktif.caption) : null], fields.aktif.isInvalid],
        ["kode_sip", [fields.kode_sip.visible && fields.kode_sip.required ? ew.Validators.required(fields.kode_sip.caption) : null], fields.kode_sip.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fbrandgrid,
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
    fbrandgrid.validate = function () {
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
    fbrandgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idcustomer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kode", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "title", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "titipmerk", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ijinhaki", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ijinbpom", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "aktif", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kode_sip", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fbrandgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbrandgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fbrandgrid.lists.idcustomer = <?= $Grid->idcustomer->toClientList($Grid) ?>;
    fbrandgrid.lists.titipmerk = <?= $Grid->titipmerk->toClientList($Grid) ?>;
    fbrandgrid.lists.ijinhaki = <?= $Grid->ijinhaki->toClientList($Grid) ?>;
    fbrandgrid.lists.ijinbpom = <?= $Grid->ijinbpom->toClientList($Grid) ?>;
    fbrandgrid.lists.aktif = <?= $Grid->aktif->toClientList($Grid) ?>;
    loadjs.done("fbrandgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> brand">
<div id="fbrandgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_brand" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_brandgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idcustomer" class="<?= $Grid->idcustomer->headerCellClass() ?>"><div id="elh_brand_idcustomer" class="brand_idcustomer"><?= $Grid->renderSort($Grid->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->kode->Visible) { // kode ?>
        <th data-name="kode" class="<?= $Grid->kode->headerCellClass() ?>"><div id="elh_brand_kode" class="brand_kode"><?= $Grid->renderSort($Grid->kode) ?></div></th>
<?php } ?>
<?php if ($Grid->title->Visible) { // title ?>
        <th data-name="title" class="<?= $Grid->title->headerCellClass() ?>" style="min-width: 30px;"><div id="elh_brand_title" class="brand_title"><?= $Grid->renderSort($Grid->title) ?></div></th>
<?php } ?>
<?php if ($Grid->titipmerk->Visible) { // titipmerk ?>
        <th data-name="titipmerk" class="<?= $Grid->titipmerk->headerCellClass() ?>"><div id="elh_brand_titipmerk" class="brand_titipmerk"><?= $Grid->renderSort($Grid->titipmerk) ?></div></th>
<?php } ?>
<?php if ($Grid->ijinhaki->Visible) { // ijinhaki ?>
        <th data-name="ijinhaki" class="<?= $Grid->ijinhaki->headerCellClass() ?>"><div id="elh_brand_ijinhaki" class="brand_ijinhaki"><?= $Grid->renderSort($Grid->ijinhaki) ?></div></th>
<?php } ?>
<?php if ($Grid->ijinbpom->Visible) { // ijinbpom ?>
        <th data-name="ijinbpom" class="<?= $Grid->ijinbpom->headerCellClass() ?>"><div id="elh_brand_ijinbpom" class="brand_ijinbpom"><?= $Grid->renderSort($Grid->ijinbpom) ?></div></th>
<?php } ?>
<?php if ($Grid->aktif->Visible) { // aktif ?>
        <th data-name="aktif" class="<?= $Grid->aktif->headerCellClass() ?>"><div id="elh_brand_aktif" class="brand_aktif"><?= $Grid->renderSort($Grid->aktif) ?></div></th>
<?php } ?>
<?php if ($Grid->kode_sip->Visible) { // kode_sip ?>
        <th data-name="kode_sip" class="<?= $Grid->kode_sip->headerCellClass() ?>"><div id="elh_brand_kode_sip" class="brand_kode_sip"><?= $Grid->renderSort($Grid->kode_sip) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_brand", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_brand_idcustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="brand_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="brand"
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
    var el = document.querySelector("select[data-select2-id='brand_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "brand_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.brand.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="brand" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_idcustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="brand_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="brand"
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
    var el = document.querySelector("select[data-select2-id='brand_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "brand_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.brand.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<?= $Grid->idcustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_idcustomer" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_idcustomer" id="fbrandgrid$x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_idcustomer" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_idcustomer" id="fbrandgrid$o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode" <?= $Grid->kode->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_brand_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="brand" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="brand" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="brand" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<?= $Grid->kode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_kode" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_kode" id="fbrandgrid$x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_kode" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_kode" id="fbrandgrid$o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->title->Visible) { // title ?>
        <td data-name="title" <?= $Grid->title->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_brand_title" class="form-group">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="brand" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="brand" data-field="x_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_title" id="o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_title" class="form-group">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="brand" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_title">
<span<?= $Grid->title->viewAttributes() ?>>
<?= $Grid->title->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_title" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_title" id="fbrandgrid$x<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_title" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_title" id="fbrandgrid$o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->titipmerk->Visible) { // titipmerk ?>
        <td data-name="titipmerk" <?= $Grid->titipmerk->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_brand_titipmerk" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_titipmerk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_titipmerk" name="x<?= $Grid->RowIndex ?>_titipmerk" id="x<?= $Grid->RowIndex ?>_titipmerk"<?= $Grid->titipmerk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_titipmerk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_titipmerk"
    name="x<?= $Grid->RowIndex ?>_titipmerk"
    value="<?= HtmlEncode($Grid->titipmerk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_titipmerk"
    data-target="dsl_x<?= $Grid->RowIndex ?>_titipmerk"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->titipmerk->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_titipmerk"
    data-value-separator="<?= $Grid->titipmerk->displayValueSeparatorAttribute() ?>"
    <?= $Grid->titipmerk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titipmerk->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="brand" data-field="x_titipmerk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_titipmerk" id="o<?= $Grid->RowIndex ?>_titipmerk" value="<?= HtmlEncode($Grid->titipmerk->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_titipmerk" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_titipmerk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_titipmerk" name="x<?= $Grid->RowIndex ?>_titipmerk" id="x<?= $Grid->RowIndex ?>_titipmerk"<?= $Grid->titipmerk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_titipmerk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_titipmerk"
    name="x<?= $Grid->RowIndex ?>_titipmerk"
    value="<?= HtmlEncode($Grid->titipmerk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_titipmerk"
    data-target="dsl_x<?= $Grid->RowIndex ?>_titipmerk"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->titipmerk->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_titipmerk"
    data-value-separator="<?= $Grid->titipmerk->displayValueSeparatorAttribute() ?>"
    <?= $Grid->titipmerk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titipmerk->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_titipmerk">
<span<?= $Grid->titipmerk->viewAttributes() ?>>
<?= $Grid->titipmerk->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_titipmerk" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_titipmerk" id="fbrandgrid$x<?= $Grid->RowIndex ?>_titipmerk" value="<?= HtmlEncode($Grid->titipmerk->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_titipmerk" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_titipmerk" id="fbrandgrid$o<?= $Grid->RowIndex ?>_titipmerk" value="<?= HtmlEncode($Grid->titipmerk->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ijinhaki->Visible) { // ijinhaki ?>
        <td data-name="ijinhaki" <?= $Grid->ijinhaki->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_brand_ijinhaki" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_ijinhaki">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinhaki" name="x<?= $Grid->RowIndex ?>_ijinhaki" id="x<?= $Grid->RowIndex ?>_ijinhaki"<?= $Grid->ijinhaki->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ijinhaki" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ijinhaki"
    name="x<?= $Grid->RowIndex ?>_ijinhaki"
    value="<?= HtmlEncode($Grid->ijinhaki->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ijinhaki"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ijinhaki"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ijinhaki->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinhaki"
    data-value-separator="<?= $Grid->ijinhaki->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ijinhaki->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinhaki->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="brand" data-field="x_ijinhaki" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijinhaki" id="o<?= $Grid->RowIndex ?>_ijinhaki" value="<?= HtmlEncode($Grid->ijinhaki->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_ijinhaki" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_ijinhaki">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinhaki" name="x<?= $Grid->RowIndex ?>_ijinhaki" id="x<?= $Grid->RowIndex ?>_ijinhaki"<?= $Grid->ijinhaki->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ijinhaki" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ijinhaki"
    name="x<?= $Grid->RowIndex ?>_ijinhaki"
    value="<?= HtmlEncode($Grid->ijinhaki->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ijinhaki"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ijinhaki"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ijinhaki->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinhaki"
    data-value-separator="<?= $Grid->ijinhaki->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ijinhaki->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinhaki->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_ijinhaki">
<span<?= $Grid->ijinhaki->viewAttributes() ?>>
<?= $Grid->ijinhaki->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_ijinhaki" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_ijinhaki" id="fbrandgrid$x<?= $Grid->RowIndex ?>_ijinhaki" value="<?= HtmlEncode($Grid->ijinhaki->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_ijinhaki" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_ijinhaki" id="fbrandgrid$o<?= $Grid->RowIndex ?>_ijinhaki" value="<?= HtmlEncode($Grid->ijinhaki->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ijinbpom->Visible) { // ijinbpom ?>
        <td data-name="ijinbpom" <?= $Grid->ijinbpom->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_brand_ijinbpom" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_ijinbpom">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinbpom" name="x<?= $Grid->RowIndex ?>_ijinbpom" id="x<?= $Grid->RowIndex ?>_ijinbpom"<?= $Grid->ijinbpom->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ijinbpom" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ijinbpom"
    name="x<?= $Grid->RowIndex ?>_ijinbpom"
    value="<?= HtmlEncode($Grid->ijinbpom->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ijinbpom"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ijinbpom"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ijinbpom->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinbpom"
    data-value-separator="<?= $Grid->ijinbpom->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ijinbpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinbpom->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="brand" data-field="x_ijinbpom" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijinbpom" id="o<?= $Grid->RowIndex ?>_ijinbpom" value="<?= HtmlEncode($Grid->ijinbpom->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_ijinbpom" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_ijinbpom">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinbpom" name="x<?= $Grid->RowIndex ?>_ijinbpom" id="x<?= $Grid->RowIndex ?>_ijinbpom"<?= $Grid->ijinbpom->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ijinbpom" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ijinbpom"
    name="x<?= $Grid->RowIndex ?>_ijinbpom"
    value="<?= HtmlEncode($Grid->ijinbpom->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ijinbpom"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ijinbpom"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ijinbpom->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinbpom"
    data-value-separator="<?= $Grid->ijinbpom->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ijinbpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinbpom->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_ijinbpom">
<span<?= $Grid->ijinbpom->viewAttributes() ?>>
<?= $Grid->ijinbpom->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_ijinbpom" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_ijinbpom" id="fbrandgrid$x<?= $Grid->RowIndex ?>_ijinbpom" value="<?= HtmlEncode($Grid->ijinbpom->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_ijinbpom" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_ijinbpom" id="fbrandgrid$o<?= $Grid->RowIndex ?>_ijinbpom" value="<?= HtmlEncode($Grid->ijinbpom->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->aktif->Visible) { // aktif ?>
        <td data-name="aktif" <?= $Grid->aktif->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_brand_aktif" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_aktif">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_aktif" name="x<?= $Grid->RowIndex ?>_aktif" id="x<?= $Grid->RowIndex ?>_aktif"<?= $Grid->aktif->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_aktif" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_aktif"
    name="x<?= $Grid->RowIndex ?>_aktif"
    value="<?= HtmlEncode($Grid->aktif->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_aktif"
    data-target="dsl_x<?= $Grid->RowIndex ?>_aktif"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->aktif->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_aktif"
    data-value-separator="<?= $Grid->aktif->displayValueSeparatorAttribute() ?>"
    <?= $Grid->aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->aktif->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="brand" data-field="x_aktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_aktif" id="o<?= $Grid->RowIndex ?>_aktif" value="<?= HtmlEncode($Grid->aktif->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_aktif" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_aktif">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_aktif" name="x<?= $Grid->RowIndex ?>_aktif" id="x<?= $Grid->RowIndex ?>_aktif"<?= $Grid->aktif->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_aktif" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_aktif"
    name="x<?= $Grid->RowIndex ?>_aktif"
    value="<?= HtmlEncode($Grid->aktif->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_aktif"
    data-target="dsl_x<?= $Grid->RowIndex ?>_aktif"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->aktif->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_aktif"
    data-value-separator="<?= $Grid->aktif->displayValueSeparatorAttribute() ?>"
    <?= $Grid->aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->aktif->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_aktif">
<span<?= $Grid->aktif->viewAttributes() ?>>
<?= $Grid->aktif->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_aktif" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_aktif" id="fbrandgrid$x<?= $Grid->RowIndex ?>_aktif" value="<?= HtmlEncode($Grid->aktif->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_aktif" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_aktif" id="fbrandgrid$o<?= $Grid->RowIndex ?>_aktif" value="<?= HtmlEncode($Grid->aktif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kode_sip->Visible) { // kode_sip ?>
        <td data-name="kode_sip" <?= $Grid->kode_sip->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_brand_kode_sip" class="form-group">
<input type="<?= $Grid->kode_sip->getInputTextType() ?>" data-table="brand" data-field="x_kode_sip" name="x<?= $Grid->RowIndex ?>_kode_sip" id="x<?= $Grid->RowIndex ?>_kode_sip" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode_sip->getPlaceHolder()) ?>" value="<?= $Grid->kode_sip->EditValue ?>"<?= $Grid->kode_sip->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode_sip->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="brand" data-field="x_kode_sip" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode_sip" id="o<?= $Grid->RowIndex ?>_kode_sip" value="<?= HtmlEncode($Grid->kode_sip->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_brand_kode_sip" class="form-group">
<input type="<?= $Grid->kode_sip->getInputTextType() ?>" data-table="brand" data-field="x_kode_sip" name="x<?= $Grid->RowIndex ?>_kode_sip" id="x<?= $Grid->RowIndex ?>_kode_sip" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode_sip->getPlaceHolder()) ?>" value="<?= $Grid->kode_sip->EditValue ?>"<?= $Grid->kode_sip->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode_sip->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_brand_kode_sip">
<span<?= $Grid->kode_sip->viewAttributes() ?>>
<?= $Grid->kode_sip->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="brand" data-field="x_kode_sip" data-hidden="1" name="fbrandgrid$x<?= $Grid->RowIndex ?>_kode_sip" id="fbrandgrid$x<?= $Grid->RowIndex ?>_kode_sip" value="<?= HtmlEncode($Grid->kode_sip->FormValue) ?>">
<input type="hidden" data-table="brand" data-field="x_kode_sip" data-hidden="1" name="fbrandgrid$o<?= $Grid->RowIndex ?>_kode_sip" id="fbrandgrid$o<?= $Grid->RowIndex ?>_kode_sip" value="<?= HtmlEncode($Grid->kode_sip->OldValue) ?>">
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
loadjs.ready(["fbrandgrid","load"], function () {
    fbrandgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_brand", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_brand_idcustomer" class="form-group brand_idcustomer">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="brand_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="brand"
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
    var el = document.querySelector("select[data-select2-id='brand_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "brand_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.brand.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_idcustomer" class="form-group brand_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_brand_kode" class="form-group brand_kode">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="brand" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_kode" class="form-group brand_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->title->Visible) { // title ?>
        <td data-name="title">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_brand_title" class="form-group brand_title">
<input type="<?= $Grid->title->getInputTextType() ?>" data-table="brand" data-field="x_title" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->title->getPlaceHolder()) ?>" value="<?= $Grid->title->EditValue ?>"<?= $Grid->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_title" class="form-group brand_title">
<span<?= $Grid->title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->title->getDisplayValue($Grid->title->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_title" data-hidden="1" name="x<?= $Grid->RowIndex ?>_title" id="x<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_title" data-hidden="1" name="o<?= $Grid->RowIndex ?>_title" id="o<?= $Grid->RowIndex ?>_title" value="<?= HtmlEncode($Grid->title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->titipmerk->Visible) { // titipmerk ?>
        <td data-name="titipmerk">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_brand_titipmerk" class="form-group brand_titipmerk">
<template id="tp_x<?= $Grid->RowIndex ?>_titipmerk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_titipmerk" name="x<?= $Grid->RowIndex ?>_titipmerk" id="x<?= $Grid->RowIndex ?>_titipmerk"<?= $Grid->titipmerk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_titipmerk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_titipmerk"
    name="x<?= $Grid->RowIndex ?>_titipmerk"
    value="<?= HtmlEncode($Grid->titipmerk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_titipmerk"
    data-target="dsl_x<?= $Grid->RowIndex ?>_titipmerk"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->titipmerk->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_titipmerk"
    data-value-separator="<?= $Grid->titipmerk->displayValueSeparatorAttribute() ?>"
    <?= $Grid->titipmerk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titipmerk->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_titipmerk" class="form-group brand_titipmerk">
<span<?= $Grid->titipmerk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->titipmerk->getDisplayValue($Grid->titipmerk->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_titipmerk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_titipmerk" id="x<?= $Grid->RowIndex ?>_titipmerk" value="<?= HtmlEncode($Grid->titipmerk->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_titipmerk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_titipmerk" id="o<?= $Grid->RowIndex ?>_titipmerk" value="<?= HtmlEncode($Grid->titipmerk->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ijinhaki->Visible) { // ijinhaki ?>
        <td data-name="ijinhaki">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_brand_ijinhaki" class="form-group brand_ijinhaki">
<template id="tp_x<?= $Grid->RowIndex ?>_ijinhaki">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinhaki" name="x<?= $Grid->RowIndex ?>_ijinhaki" id="x<?= $Grid->RowIndex ?>_ijinhaki"<?= $Grid->ijinhaki->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ijinhaki" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ijinhaki"
    name="x<?= $Grid->RowIndex ?>_ijinhaki"
    value="<?= HtmlEncode($Grid->ijinhaki->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ijinhaki"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ijinhaki"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ijinhaki->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinhaki"
    data-value-separator="<?= $Grid->ijinhaki->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ijinhaki->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinhaki->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_ijinhaki" class="form-group brand_ijinhaki">
<span<?= $Grid->ijinhaki->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ijinhaki->getDisplayValue($Grid->ijinhaki->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_ijinhaki" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ijinhaki" id="x<?= $Grid->RowIndex ?>_ijinhaki" value="<?= HtmlEncode($Grid->ijinhaki->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_ijinhaki" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijinhaki" id="o<?= $Grid->RowIndex ?>_ijinhaki" value="<?= HtmlEncode($Grid->ijinhaki->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ijinbpom->Visible) { // ijinbpom ?>
        <td data-name="ijinbpom">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_brand_ijinbpom" class="form-group brand_ijinbpom">
<template id="tp_x<?= $Grid->RowIndex ?>_ijinbpom">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinbpom" name="x<?= $Grid->RowIndex ?>_ijinbpom" id="x<?= $Grid->RowIndex ?>_ijinbpom"<?= $Grid->ijinbpom->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_ijinbpom" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_ijinbpom"
    name="x<?= $Grid->RowIndex ?>_ijinbpom"
    value="<?= HtmlEncode($Grid->ijinbpom->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_ijinbpom"
    data-target="dsl_x<?= $Grid->RowIndex ?>_ijinbpom"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->ijinbpom->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinbpom"
    data-value-separator="<?= $Grid->ijinbpom->displayValueSeparatorAttribute() ?>"
    <?= $Grid->ijinbpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinbpom->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_ijinbpom" class="form-group brand_ijinbpom">
<span<?= $Grid->ijinbpom->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ijinbpom->getDisplayValue($Grid->ijinbpom->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_ijinbpom" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ijinbpom" id="x<?= $Grid->RowIndex ?>_ijinbpom" value="<?= HtmlEncode($Grid->ijinbpom->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_ijinbpom" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijinbpom" id="o<?= $Grid->RowIndex ?>_ijinbpom" value="<?= HtmlEncode($Grid->ijinbpom->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->aktif->Visible) { // aktif ?>
        <td data-name="aktif">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_brand_aktif" class="form-group brand_aktif">
<template id="tp_x<?= $Grid->RowIndex ?>_aktif">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_aktif" name="x<?= $Grid->RowIndex ?>_aktif" id="x<?= $Grid->RowIndex ?>_aktif"<?= $Grid->aktif->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_aktif" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_aktif"
    name="x<?= $Grid->RowIndex ?>_aktif"
    value="<?= HtmlEncode($Grid->aktif->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_aktif"
    data-target="dsl_x<?= $Grid->RowIndex ?>_aktif"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->aktif->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_aktif"
    data-value-separator="<?= $Grid->aktif->displayValueSeparatorAttribute() ?>"
    <?= $Grid->aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->aktif->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_aktif" class="form-group brand_aktif">
<span<?= $Grid->aktif->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->aktif->getDisplayValue($Grid->aktif->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_aktif" data-hidden="1" name="x<?= $Grid->RowIndex ?>_aktif" id="x<?= $Grid->RowIndex ?>_aktif" value="<?= HtmlEncode($Grid->aktif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_aktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_aktif" id="o<?= $Grid->RowIndex ?>_aktif" value="<?= HtmlEncode($Grid->aktif->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kode_sip->Visible) { // kode_sip ?>
        <td data-name="kode_sip">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_brand_kode_sip" class="form-group brand_kode_sip">
<input type="<?= $Grid->kode_sip->getInputTextType() ?>" data-table="brand" data-field="x_kode_sip" name="x<?= $Grid->RowIndex ?>_kode_sip" id="x<?= $Grid->RowIndex ?>_kode_sip" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode_sip->getPlaceHolder()) ?>" value="<?= $Grid->kode_sip->EditValue ?>"<?= $Grid->kode_sip->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode_sip->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_brand_kode_sip" class="form-group brand_kode_sip">
<span<?= $Grid->kode_sip->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode_sip->getDisplayValue($Grid->kode_sip->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="brand" data-field="x_kode_sip" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode_sip" id="x<?= $Grid->RowIndex ?>_kode_sip" value="<?= HtmlEncode($Grid->kode_sip->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="brand" data-field="x_kode_sip" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode_sip" id="o<?= $Grid->RowIndex ?>_kode_sip" value="<?= HtmlEncode($Grid->kode_sip->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fbrandgrid","load"], function() {
    fbrandgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fbrandgrid">
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
    ew.addEventHandlers("brand");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
