<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("AlamatCustomerGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var falamat_customergrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    falamat_customergrid = new ew.Form("falamat_customergrid", "grid");
    falamat_customergrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "alamat_customer")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.alamat_customer)
        ew.vars.tables.alamat_customer = currentTable;
    falamat_customergrid.addFields([
        ["alias", [fields.alias.visible && fields.alias.required ? ew.Validators.required(fields.alias.caption) : null], fields.alias.isInvalid],
        ["penerima", [fields.penerima.visible && fields.penerima.required ? ew.Validators.required(fields.penerima.caption) : null], fields.penerima.isInvalid],
        ["telepon", [fields.telepon.visible && fields.telepon.required ? ew.Validators.required(fields.telepon.caption) : null], fields.telepon.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["idprovinsi", [fields.idprovinsi.visible && fields.idprovinsi.required ? ew.Validators.required(fields.idprovinsi.caption) : null], fields.idprovinsi.isInvalid],
        ["idkabupaten", [fields.idkabupaten.visible && fields.idkabupaten.required ? ew.Validators.required(fields.idkabupaten.caption) : null], fields.idkabupaten.isInvalid],
        ["idkecamatan", [fields.idkecamatan.visible && fields.idkecamatan.required ? ew.Validators.required(fields.idkecamatan.caption) : null], fields.idkecamatan.isInvalid],
        ["idkelurahan", [fields.idkelurahan.visible && fields.idkelurahan.required ? ew.Validators.required(fields.idkelurahan.caption) : null, ew.Validators.integer], fields.idkelurahan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = falamat_customergrid,
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
    falamat_customergrid.validate = function () {
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
    falamat_customergrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "alias", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "penerima", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "telepon", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "alamat", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idprovinsi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idkabupaten", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idkecamatan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idkelurahan", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    falamat_customergrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    falamat_customergrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    falamat_customergrid.lists.idprovinsi = <?= $Grid->idprovinsi->toClientList($Grid) ?>;
    falamat_customergrid.lists.idkabupaten = <?= $Grid->idkabupaten->toClientList($Grid) ?>;
    falamat_customergrid.lists.idkecamatan = <?= $Grid->idkecamatan->toClientList($Grid) ?>;
    falamat_customergrid.lists.idkelurahan = <?= $Grid->idkelurahan->toClientList($Grid) ?>;
    loadjs.done("falamat_customergrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> alamat_customer">
<div id="falamat_customergrid" class="ew-form ew-list-form form-inline">
<div id="gmp_alamat_customer" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_alamat_customergrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->alias->Visible) { // alias ?>
        <th data-name="alias" class="<?= $Grid->alias->headerCellClass() ?>"><div id="elh_alamat_customer_alias" class="alamat_customer_alias"><?= $Grid->renderSort($Grid->alias) ?></div></th>
<?php } ?>
<?php if ($Grid->penerima->Visible) { // penerima ?>
        <th data-name="penerima" class="<?= $Grid->penerima->headerCellClass() ?>"><div id="elh_alamat_customer_penerima" class="alamat_customer_penerima"><?= $Grid->renderSort($Grid->penerima) ?></div></th>
<?php } ?>
<?php if ($Grid->telepon->Visible) { // telepon ?>
        <th data-name="telepon" class="<?= $Grid->telepon->headerCellClass() ?>"><div id="elh_alamat_customer_telepon" class="alamat_customer_telepon"><?= $Grid->renderSort($Grid->telepon) ?></div></th>
<?php } ?>
<?php if ($Grid->alamat->Visible) { // alamat ?>
        <th data-name="alamat" class="<?= $Grid->alamat->headerCellClass() ?>"><div id="elh_alamat_customer_alamat" class="alamat_customer_alamat"><?= $Grid->renderSort($Grid->alamat) ?></div></th>
<?php } ?>
<?php if ($Grid->idprovinsi->Visible) { // idprovinsi ?>
        <th data-name="idprovinsi" class="<?= $Grid->idprovinsi->headerCellClass() ?>"><div id="elh_alamat_customer_idprovinsi" class="alamat_customer_idprovinsi"><?= $Grid->renderSort($Grid->idprovinsi) ?></div></th>
<?php } ?>
<?php if ($Grid->idkabupaten->Visible) { // idkabupaten ?>
        <th data-name="idkabupaten" class="<?= $Grid->idkabupaten->headerCellClass() ?>"><div id="elh_alamat_customer_idkabupaten" class="alamat_customer_idkabupaten"><?= $Grid->renderSort($Grid->idkabupaten) ?></div></th>
<?php } ?>
<?php if ($Grid->idkecamatan->Visible) { // idkecamatan ?>
        <th data-name="idkecamatan" class="<?= $Grid->idkecamatan->headerCellClass() ?>"><div id="elh_alamat_customer_idkecamatan" class="alamat_customer_idkecamatan"><?= $Grid->renderSort($Grid->idkecamatan) ?></div></th>
<?php } ?>
<?php if ($Grid->idkelurahan->Visible) { // idkelurahan ?>
        <th data-name="idkelurahan" class="<?= $Grid->idkelurahan->headerCellClass() ?>"><div id="elh_alamat_customer_idkelurahan" class="alamat_customer_idkelurahan"><?= $Grid->renderSort($Grid->idkelurahan) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_alamat_customer", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->alias->Visible) { // alias ?>
        <td data-name="alias" <?= $Grid->alias->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_alias" class="form-group">
<input type="<?= $Grid->alias->getInputTextType() ?>" data-table="alamat_customer" data-field="x_alias" name="x<?= $Grid->RowIndex ?>_alias" id="x<?= $Grid->RowIndex ?>_alias" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->alias->getPlaceHolder()) ?>" value="<?= $Grid->alias->EditValue ?>"<?= $Grid->alias->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->alias->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_alias" data-hidden="1" name="o<?= $Grid->RowIndex ?>_alias" id="o<?= $Grid->RowIndex ?>_alias" value="<?= HtmlEncode($Grid->alias->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_alias" class="form-group">
<input type="<?= $Grid->alias->getInputTextType() ?>" data-table="alamat_customer" data-field="x_alias" name="x<?= $Grid->RowIndex ?>_alias" id="x<?= $Grid->RowIndex ?>_alias" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->alias->getPlaceHolder()) ?>" value="<?= $Grid->alias->EditValue ?>"<?= $Grid->alias->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->alias->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_alias">
<span<?= $Grid->alias->viewAttributes() ?>>
<?= $Grid->alias->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_alias" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_alias" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_alias" value="<?= HtmlEncode($Grid->alias->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_alias" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_alias" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_alias" value="<?= HtmlEncode($Grid->alias->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->penerima->Visible) { // penerima ?>
        <td data-name="penerima" <?= $Grid->penerima->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_penerima" class="form-group">
<input type="<?= $Grid->penerima->getInputTextType() ?>" data-table="alamat_customer" data-field="x_penerima" name="x<?= $Grid->RowIndex ?>_penerima" id="x<?= $Grid->RowIndex ?>_penerima" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->penerima->getPlaceHolder()) ?>" value="<?= $Grid->penerima->EditValue ?>"<?= $Grid->penerima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->penerima->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_penerima" data-hidden="1" name="o<?= $Grid->RowIndex ?>_penerima" id="o<?= $Grid->RowIndex ?>_penerima" value="<?= HtmlEncode($Grid->penerima->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_penerima" class="form-group">
<input type="<?= $Grid->penerima->getInputTextType() ?>" data-table="alamat_customer" data-field="x_penerima" name="x<?= $Grid->RowIndex ?>_penerima" id="x<?= $Grid->RowIndex ?>_penerima" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->penerima->getPlaceHolder()) ?>" value="<?= $Grid->penerima->EditValue ?>"<?= $Grid->penerima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->penerima->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_penerima">
<span<?= $Grid->penerima->viewAttributes() ?>>
<?= $Grid->penerima->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_penerima" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_penerima" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_penerima" value="<?= HtmlEncode($Grid->penerima->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_penerima" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_penerima" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_penerima" value="<?= HtmlEncode($Grid->penerima->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->telepon->Visible) { // telepon ?>
        <td data-name="telepon" <?= $Grid->telepon->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_telepon" class="form-group">
<input type="<?= $Grid->telepon->getInputTextType() ?>" data-table="alamat_customer" data-field="x_telepon" name="x<?= $Grid->RowIndex ?>_telepon" id="x<?= $Grid->RowIndex ?>_telepon" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->telepon->getPlaceHolder()) ?>" value="<?= $Grid->telepon->EditValue ?>"<?= $Grid->telepon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telepon->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_telepon" data-hidden="1" name="o<?= $Grid->RowIndex ?>_telepon" id="o<?= $Grid->RowIndex ?>_telepon" value="<?= HtmlEncode($Grid->telepon->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_telepon" class="form-group">
<input type="<?= $Grid->telepon->getInputTextType() ?>" data-table="alamat_customer" data-field="x_telepon" name="x<?= $Grid->RowIndex ?>_telepon" id="x<?= $Grid->RowIndex ?>_telepon" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->telepon->getPlaceHolder()) ?>" value="<?= $Grid->telepon->EditValue ?>"<?= $Grid->telepon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telepon->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_telepon">
<span<?= $Grid->telepon->viewAttributes() ?>>
<?= $Grid->telepon->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_telepon" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_telepon" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_telepon" value="<?= HtmlEncode($Grid->telepon->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_telepon" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_telepon" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_telepon" value="<?= HtmlEncode($Grid->telepon->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->alamat->Visible) { // alamat ?>
        <td data-name="alamat" <?= $Grid->alamat->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_alamat" class="form-group">
<textarea data-table="alamat_customer" data-field="x_alamat" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->alamat->getPlaceHolder()) ?>"<?= $Grid->alamat->editAttributes() ?>><?= $Grid->alamat->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->alamat->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_alamat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_alamat" id="o<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_alamat" class="form-group">
<textarea data-table="alamat_customer" data-field="x_alamat" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->alamat->getPlaceHolder()) ?>"<?= $Grid->alamat->editAttributes() ?>><?= $Grid->alamat->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->alamat->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_alamat">
<span<?= $Grid->alamat->viewAttributes() ?>>
<?= $Grid->alamat->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_alamat" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_alamat" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_alamat" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_alamat" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idprovinsi->Visible) { // idprovinsi ?>
        <td data-name="idprovinsi" <?= $Grid->idprovinsi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idprovinsi" class="form-group">
<?php $Grid->idprovinsi->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idprovinsi"
        name="x<?= $Grid->RowIndex ?>_idprovinsi"
        class="form-control ew-select<?= $Grid->idprovinsi->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi"
        data-table="alamat_customer"
        data-field="x_idprovinsi"
        data-value-separator="<?= $Grid->idprovinsi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idprovinsi->getPlaceHolder()) ?>"
        <?= $Grid->idprovinsi->editAttributes() ?>>
        <?= $Grid->idprovinsi->selectOptionListHtml("x{$Grid->RowIndex}_idprovinsi") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idprovinsi->getErrorMessage() ?></div>
<?= $Grid->idprovinsi->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idprovinsi") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idprovinsi", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idprovinsi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idprovinsi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idprovinsi" id="o<?= $Grid->RowIndex ?>_idprovinsi" value="<?= HtmlEncode($Grid->idprovinsi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idprovinsi" class="form-group">
<?php $Grid->idprovinsi->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idprovinsi"
        name="x<?= $Grid->RowIndex ?>_idprovinsi"
        class="form-control ew-select<?= $Grid->idprovinsi->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi"
        data-table="alamat_customer"
        data-field="x_idprovinsi"
        data-value-separator="<?= $Grid->idprovinsi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idprovinsi->getPlaceHolder()) ?>"
        <?= $Grid->idprovinsi->editAttributes() ?>>
        <?= $Grid->idprovinsi->selectOptionListHtml("x{$Grid->RowIndex}_idprovinsi") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idprovinsi->getErrorMessage() ?></div>
<?= $Grid->idprovinsi->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idprovinsi") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idprovinsi", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idprovinsi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idprovinsi">
<span<?= $Grid->idprovinsi->viewAttributes() ?>>
<?= $Grid->idprovinsi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idprovinsi" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_idprovinsi" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_idprovinsi" value="<?= HtmlEncode($Grid->idprovinsi->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_idprovinsi" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_idprovinsi" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_idprovinsi" value="<?= HtmlEncode($Grid->idprovinsi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idkabupaten->Visible) { // idkabupaten ?>
        <td data-name="idkabupaten" <?= $Grid->idkabupaten->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkabupaten" class="form-group">
<?php $Grid->idkabupaten->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idkabupaten"
        name="x<?= $Grid->RowIndex ?>_idkabupaten"
        class="form-control ew-select<?= $Grid->idkabupaten->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten"
        data-table="alamat_customer"
        data-field="x_idkabupaten"
        data-value-separator="<?= $Grid->idkabupaten->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idkabupaten->getPlaceHolder()) ?>"
        <?= $Grid->idkabupaten->editAttributes() ?>>
        <?= $Grid->idkabupaten->selectOptionListHtml("x{$Grid->RowIndex}_idkabupaten") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkabupaten->getErrorMessage() ?></div>
<?= $Grid->idkabupaten->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkabupaten") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkabupaten", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkabupaten.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idkabupaten" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkabupaten" id="o<?= $Grid->RowIndex ?>_idkabupaten" value="<?= HtmlEncode($Grid->idkabupaten->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkabupaten" class="form-group">
<?php $Grid->idkabupaten->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idkabupaten"
        name="x<?= $Grid->RowIndex ?>_idkabupaten"
        class="form-control ew-select<?= $Grid->idkabupaten->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten"
        data-table="alamat_customer"
        data-field="x_idkabupaten"
        data-value-separator="<?= $Grid->idkabupaten->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idkabupaten->getPlaceHolder()) ?>"
        <?= $Grid->idkabupaten->editAttributes() ?>>
        <?= $Grid->idkabupaten->selectOptionListHtml("x{$Grid->RowIndex}_idkabupaten") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkabupaten->getErrorMessage() ?></div>
<?= $Grid->idkabupaten->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkabupaten") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkabupaten", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkabupaten.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkabupaten">
<span<?= $Grid->idkabupaten->viewAttributes() ?>>
<?= $Grid->idkabupaten->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idkabupaten" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_idkabupaten" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_idkabupaten" value="<?= HtmlEncode($Grid->idkabupaten->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_idkabupaten" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_idkabupaten" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_idkabupaten" value="<?= HtmlEncode($Grid->idkabupaten->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idkecamatan->Visible) { // idkecamatan ?>
        <td data-name="idkecamatan" <?= $Grid->idkecamatan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkecamatan" class="form-group">
<?php $Grid->idkecamatan->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idkecamatan"
        name="x<?= $Grid->RowIndex ?>_idkecamatan"
        class="form-control ew-select<?= $Grid->idkecamatan->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan"
        data-table="alamat_customer"
        data-field="x_idkecamatan"
        data-value-separator="<?= $Grid->idkecamatan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idkecamatan->getPlaceHolder()) ?>"
        <?= $Grid->idkecamatan->editAttributes() ?>>
        <?= $Grid->idkecamatan->selectOptionListHtml("x{$Grid->RowIndex}_idkecamatan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkecamatan->getErrorMessage() ?></div>
<?= $Grid->idkecamatan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkecamatan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkecamatan", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkecamatan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idkecamatan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkecamatan" id="o<?= $Grid->RowIndex ?>_idkecamatan" value="<?= HtmlEncode($Grid->idkecamatan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkecamatan" class="form-group">
<?php $Grid->idkecamatan->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idkecamatan"
        name="x<?= $Grid->RowIndex ?>_idkecamatan"
        class="form-control ew-select<?= $Grid->idkecamatan->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan"
        data-table="alamat_customer"
        data-field="x_idkecamatan"
        data-value-separator="<?= $Grid->idkecamatan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idkecamatan->getPlaceHolder()) ?>"
        <?= $Grid->idkecamatan->editAttributes() ?>>
        <?= $Grid->idkecamatan->selectOptionListHtml("x{$Grid->RowIndex}_idkecamatan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkecamatan->getErrorMessage() ?></div>
<?= $Grid->idkecamatan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkecamatan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkecamatan", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkecamatan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkecamatan">
<span<?= $Grid->idkecamatan->viewAttributes() ?>>
<?= $Grid->idkecamatan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idkecamatan" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_idkecamatan" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_idkecamatan" value="<?= HtmlEncode($Grid->idkecamatan->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_idkecamatan" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_idkecamatan" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_idkecamatan" value="<?= HtmlEncode($Grid->idkecamatan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idkelurahan->Visible) { // idkelurahan ?>
        <td data-name="idkelurahan" <?= $Grid->idkelurahan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkelurahan" class="form-group">
<?php
$onchange = $Grid->idkelurahan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->idkelurahan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_idkelurahan" class="ew-auto-suggest">
    <input type="<?= $Grid->idkelurahan->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_idkelurahan" id="sv_x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= RemoveHtml($Grid->idkelurahan->EditValue) ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->idkelurahan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->idkelurahan->getPlaceHolder()) ?>"<?= $Grid->idkelurahan->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="alamat_customer" data-field="x_idkelurahan" data-input="sv_x<?= $Grid->RowIndex ?>_idkelurahan" data-value-separator="<?= $Grid->idkelurahan->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_idkelurahan" id="x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->idkelurahan->getErrorMessage() ?></div>
<script>
loadjs.ready(["falamat_customergrid"], function() {
    falamat_customergrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_idkelurahan","forceSelect":false}, ew.vars.tables.alamat_customer.fields.idkelurahan.autoSuggestOptions));
});
</script>
<?= $Grid->idkelurahan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkelurahan") ?>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idkelurahan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkelurahan" id="o<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkelurahan" class="form-group">
<?php
$onchange = $Grid->idkelurahan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->idkelurahan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_idkelurahan" class="ew-auto-suggest">
    <input type="<?= $Grid->idkelurahan->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_idkelurahan" id="sv_x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= RemoveHtml($Grid->idkelurahan->EditValue) ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->idkelurahan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->idkelurahan->getPlaceHolder()) ?>"<?= $Grid->idkelurahan->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="alamat_customer" data-field="x_idkelurahan" data-input="sv_x<?= $Grid->RowIndex ?>_idkelurahan" data-value-separator="<?= $Grid->idkelurahan->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_idkelurahan" id="x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->idkelurahan->getErrorMessage() ?></div>
<script>
loadjs.ready(["falamat_customergrid"], function() {
    falamat_customergrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_idkelurahan","forceSelect":false}, ew.vars.tables.alamat_customer.fields.idkelurahan.autoSuggestOptions));
});
</script>
<?= $Grid->idkelurahan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkelurahan") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_alamat_customer_idkelurahan">
<span<?= $Grid->idkelurahan->viewAttributes() ?>>
<?= $Grid->idkelurahan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idkelurahan" data-hidden="1" name="falamat_customergrid$x<?= $Grid->RowIndex ?>_idkelurahan" id="falamat_customergrid$x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->FormValue) ?>">
<input type="hidden" data-table="alamat_customer" data-field="x_idkelurahan" data-hidden="1" name="falamat_customergrid$o<?= $Grid->RowIndex ?>_idkelurahan" id="falamat_customergrid$o<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->OldValue) ?>">
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
loadjs.ready(["falamat_customergrid","load"], function () {
    falamat_customergrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_alamat_customer", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->alias->Visible) { // alias ?>
        <td data-name="alias">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_alias" class="form-group alamat_customer_alias">
<input type="<?= $Grid->alias->getInputTextType() ?>" data-table="alamat_customer" data-field="x_alias" name="x<?= $Grid->RowIndex ?>_alias" id="x<?= $Grid->RowIndex ?>_alias" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->alias->getPlaceHolder()) ?>" value="<?= $Grid->alias->EditValue ?>"<?= $Grid->alias->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->alias->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_alias" class="form-group alamat_customer_alias">
<span<?= $Grid->alias->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->alias->getDisplayValue($Grid->alias->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_alias" data-hidden="1" name="x<?= $Grid->RowIndex ?>_alias" id="x<?= $Grid->RowIndex ?>_alias" value="<?= HtmlEncode($Grid->alias->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_alias" data-hidden="1" name="o<?= $Grid->RowIndex ?>_alias" id="o<?= $Grid->RowIndex ?>_alias" value="<?= HtmlEncode($Grid->alias->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->penerima->Visible) { // penerima ?>
        <td data-name="penerima">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_penerima" class="form-group alamat_customer_penerima">
<input type="<?= $Grid->penerima->getInputTextType() ?>" data-table="alamat_customer" data-field="x_penerima" name="x<?= $Grid->RowIndex ?>_penerima" id="x<?= $Grid->RowIndex ?>_penerima" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->penerima->getPlaceHolder()) ?>" value="<?= $Grid->penerima->EditValue ?>"<?= $Grid->penerima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->penerima->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_penerima" class="form-group alamat_customer_penerima">
<span<?= $Grid->penerima->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->penerima->getDisplayValue($Grid->penerima->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_penerima" data-hidden="1" name="x<?= $Grid->RowIndex ?>_penerima" id="x<?= $Grid->RowIndex ?>_penerima" value="<?= HtmlEncode($Grid->penerima->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_penerima" data-hidden="1" name="o<?= $Grid->RowIndex ?>_penerima" id="o<?= $Grid->RowIndex ?>_penerima" value="<?= HtmlEncode($Grid->penerima->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->telepon->Visible) { // telepon ?>
        <td data-name="telepon">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_telepon" class="form-group alamat_customer_telepon">
<input type="<?= $Grid->telepon->getInputTextType() ?>" data-table="alamat_customer" data-field="x_telepon" name="x<?= $Grid->RowIndex ?>_telepon" id="x<?= $Grid->RowIndex ?>_telepon" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->telepon->getPlaceHolder()) ?>" value="<?= $Grid->telepon->EditValue ?>"<?= $Grid->telepon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->telepon->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_telepon" class="form-group alamat_customer_telepon">
<span<?= $Grid->telepon->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->telepon->getDisplayValue($Grid->telepon->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_telepon" data-hidden="1" name="x<?= $Grid->RowIndex ?>_telepon" id="x<?= $Grid->RowIndex ?>_telepon" value="<?= HtmlEncode($Grid->telepon->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_telepon" data-hidden="1" name="o<?= $Grid->RowIndex ?>_telepon" id="o<?= $Grid->RowIndex ?>_telepon" value="<?= HtmlEncode($Grid->telepon->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->alamat->Visible) { // alamat ?>
        <td data-name="alamat">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_alamat" class="form-group alamat_customer_alamat">
<textarea data-table="alamat_customer" data-field="x_alamat" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->alamat->getPlaceHolder()) ?>"<?= $Grid->alamat->editAttributes() ?>><?= $Grid->alamat->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->alamat->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_alamat" class="form-group alamat_customer_alamat">
<span<?= $Grid->alamat->viewAttributes() ?>>
<?= $Grid->alamat->ViewValue ?></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_alamat" data-hidden="1" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_alamat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_alamat" id="o<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idprovinsi->Visible) { // idprovinsi ?>
        <td data-name="idprovinsi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_idprovinsi" class="form-group alamat_customer_idprovinsi">
<?php $Grid->idprovinsi->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idprovinsi"
        name="x<?= $Grid->RowIndex ?>_idprovinsi"
        class="form-control ew-select<?= $Grid->idprovinsi->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi"
        data-table="alamat_customer"
        data-field="x_idprovinsi"
        data-value-separator="<?= $Grid->idprovinsi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idprovinsi->getPlaceHolder()) ?>"
        <?= $Grid->idprovinsi->editAttributes() ?>>
        <?= $Grid->idprovinsi->selectOptionListHtml("x{$Grid->RowIndex}_idprovinsi") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idprovinsi->getErrorMessage() ?></div>
<?= $Grid->idprovinsi->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idprovinsi") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idprovinsi", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idprovinsi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idprovinsi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_idprovinsi" class="form-group alamat_customer_idprovinsi">
<span<?= $Grid->idprovinsi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idprovinsi->getDisplayValue($Grid->idprovinsi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idprovinsi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idprovinsi" id="x<?= $Grid->RowIndex ?>_idprovinsi" value="<?= HtmlEncode($Grid->idprovinsi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idprovinsi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idprovinsi" id="o<?= $Grid->RowIndex ?>_idprovinsi" value="<?= HtmlEncode($Grid->idprovinsi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idkabupaten->Visible) { // idkabupaten ?>
        <td data-name="idkabupaten">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_idkabupaten" class="form-group alamat_customer_idkabupaten">
<?php $Grid->idkabupaten->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idkabupaten"
        name="x<?= $Grid->RowIndex ?>_idkabupaten"
        class="form-control ew-select<?= $Grid->idkabupaten->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten"
        data-table="alamat_customer"
        data-field="x_idkabupaten"
        data-value-separator="<?= $Grid->idkabupaten->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idkabupaten->getPlaceHolder()) ?>"
        <?= $Grid->idkabupaten->editAttributes() ?>>
        <?= $Grid->idkabupaten->selectOptionListHtml("x{$Grid->RowIndex}_idkabupaten") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkabupaten->getErrorMessage() ?></div>
<?= $Grid->idkabupaten->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkabupaten") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkabupaten", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idkabupaten", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkabupaten.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_idkabupaten" class="form-group alamat_customer_idkabupaten">
<span<?= $Grid->idkabupaten->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idkabupaten->getDisplayValue($Grid->idkabupaten->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idkabupaten" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idkabupaten" id="x<?= $Grid->RowIndex ?>_idkabupaten" value="<?= HtmlEncode($Grid->idkabupaten->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idkabupaten" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkabupaten" id="o<?= $Grid->RowIndex ?>_idkabupaten" value="<?= HtmlEncode($Grid->idkabupaten->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idkecamatan->Visible) { // idkecamatan ?>
        <td data-name="idkecamatan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_idkecamatan" class="form-group alamat_customer_idkecamatan">
<?php $Grid->idkecamatan->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idkecamatan"
        name="x<?= $Grid->RowIndex ?>_idkecamatan"
        class="form-control ew-select<?= $Grid->idkecamatan->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan"
        data-table="alamat_customer"
        data-field="x_idkecamatan"
        data-value-separator="<?= $Grid->idkecamatan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idkecamatan->getPlaceHolder()) ?>"
        <?= $Grid->idkecamatan->editAttributes() ?>>
        <?= $Grid->idkecamatan->selectOptionListHtml("x{$Grid->RowIndex}_idkecamatan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkecamatan->getErrorMessage() ?></div>
<?= $Grid->idkecamatan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkecamatan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkecamatan", selectId: "alamat_customer_x<?= $Grid->RowIndex ?>_idkecamatan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkecamatan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_idkecamatan" class="form-group alamat_customer_idkecamatan">
<span<?= $Grid->idkecamatan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idkecamatan->getDisplayValue($Grid->idkecamatan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idkecamatan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idkecamatan" id="x<?= $Grid->RowIndex ?>_idkecamatan" value="<?= HtmlEncode($Grid->idkecamatan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idkecamatan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkecamatan" id="o<?= $Grid->RowIndex ?>_idkecamatan" value="<?= HtmlEncode($Grid->idkecamatan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idkelurahan->Visible) { // idkelurahan ?>
        <td data-name="idkelurahan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_alamat_customer_idkelurahan" class="form-group alamat_customer_idkelurahan">
<?php
$onchange = $Grid->idkelurahan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->idkelurahan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_idkelurahan" class="ew-auto-suggest">
    <input type="<?= $Grid->idkelurahan->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_idkelurahan" id="sv_x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= RemoveHtml($Grid->idkelurahan->EditValue) ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->idkelurahan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->idkelurahan->getPlaceHolder()) ?>"<?= $Grid->idkelurahan->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="alamat_customer" data-field="x_idkelurahan" data-input="sv_x<?= $Grid->RowIndex ?>_idkelurahan" data-value-separator="<?= $Grid->idkelurahan->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_idkelurahan" id="x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->idkelurahan->getErrorMessage() ?></div>
<script>
loadjs.ready(["falamat_customergrid"], function() {
    falamat_customergrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_idkelurahan","forceSelect":false}, ew.vars.tables.alamat_customer.fields.idkelurahan.autoSuggestOptions));
});
</script>
<?= $Grid->idkelurahan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkelurahan") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_alamat_customer_idkelurahan" class="form-group alamat_customer_idkelurahan">
<span<?= $Grid->idkelurahan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idkelurahan->getDisplayValue($Grid->idkelurahan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="alamat_customer" data-field="x_idkelurahan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idkelurahan" id="x<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="alamat_customer" data-field="x_idkelurahan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkelurahan" id="o<?= $Grid->RowIndex ?>_idkelurahan" value="<?= HtmlEncode($Grid->idkelurahan->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["falamat_customergrid","load"], function() {
    falamat_customergrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="falamat_customergrid">
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
    ew.addEventHandlers("alamat_customer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
