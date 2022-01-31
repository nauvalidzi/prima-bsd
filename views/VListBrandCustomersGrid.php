<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("VListBrandCustomersGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_list_brand_customersgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fv_list_brand_customersgrid = new ew.Form("fv_list_brand_customersgrid", "grid");
    fv_list_brand_customersgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_list_brand_customers")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_list_brand_customers)
        ew.vars.tables.v_list_brand_customers = currentTable;
    fv_list_brand_customersgrid.addFields([
        ["kode_customer", [fields.kode_customer.visible && fields.kode_customer.required ? ew.Validators.required(fields.kode_customer.caption) : null], fields.kode_customer.isInvalid],
        ["nama_customer", [fields.nama_customer.visible && fields.nama_customer.required ? ew.Validators.required(fields.nama_customer.caption) : null], fields.nama_customer.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_list_brand_customersgrid,
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
    fv_list_brand_customersgrid.validate = function () {
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
    fv_list_brand_customersgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "kode_customer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama_customer", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fv_list_brand_customersgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_list_brand_customersgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fv_list_brand_customersgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_list_brand_customers">
<div id="fv_list_brand_customersgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_v_list_brand_customers" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_v_list_brand_customersgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->kode_customer->Visible) { // kode_customer ?>
        <th data-name="kode_customer" class="<?= $Grid->kode_customer->headerCellClass() ?>"><div id="elh_v_list_brand_customers_kode_customer" class="v_list_brand_customers_kode_customer"><?= $Grid->renderSort($Grid->kode_customer) ?></div></th>
<?php } ?>
<?php if ($Grid->nama_customer->Visible) { // nama_customer ?>
        <th data-name="nama_customer" class="<?= $Grid->nama_customer->headerCellClass() ?>"><div id="elh_v_list_brand_customers_nama_customer" class="v_list_brand_customers_nama_customer"><?= $Grid->renderSort($Grid->nama_customer) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_v_list_brand_customers", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->kode_customer->Visible) { // kode_customer ?>
        <td data-name="kode_customer" <?= $Grid->kode_customer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_brand_customers_kode_customer" class="form-group">
<input type="<?= $Grid->kode_customer->getInputTextType() ?>" data-table="v_list_brand_customers" data-field="x_kode_customer" name="x<?= $Grid->RowIndex ?>_kode_customer" id="x<?= $Grid->RowIndex ?>_kode_customer" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode_customer->getPlaceHolder()) ?>" value="<?= $Grid->kode_customer->EditValue ?>"<?= $Grid->kode_customer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode_customer->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_kode_customer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode_customer" id="o<?= $Grid->RowIndex ?>_kode_customer" value="<?= HtmlEncode($Grid->kode_customer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_brand_customers_kode_customer" class="form-group">
<input type="hidden" data-table="v_list_brand_customers" data-field="x_kode_customer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode_customer" id="x<?= $Grid->RowIndex ?>_kode_customer" value="<?= HtmlEncode($Grid->kode_customer->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_brand_customers_kode_customer">
<span<?= $Grid->kode_customer->viewAttributes() ?>>
<?= $Grid->kode_customer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_kode_customer" data-hidden="1" name="fv_list_brand_customersgrid$x<?= $Grid->RowIndex ?>_kode_customer" id="fv_list_brand_customersgrid$x<?= $Grid->RowIndex ?>_kode_customer" value="<?= HtmlEncode($Grid->kode_customer->FormValue) ?>">
<input type="hidden" data-table="v_list_brand_customers" data-field="x_kode_customer" data-hidden="1" name="fv_list_brand_customersgrid$o<?= $Grid->RowIndex ?>_kode_customer" id="fv_list_brand_customersgrid$o<?= $Grid->RowIndex ?>_kode_customer" value="<?= HtmlEncode($Grid->kode_customer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama_customer->Visible) { // nama_customer ?>
        <td data-name="nama_customer" <?= $Grid->nama_customer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_brand_customers_nama_customer" class="form-group">
<input type="<?= $Grid->nama_customer->getInputTextType() ?>" data-table="v_list_brand_customers" data-field="x_nama_customer" name="x<?= $Grid->RowIndex ?>_nama_customer" id="x<?= $Grid->RowIndex ?>_nama_customer" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_customer->getPlaceHolder()) ?>" value="<?= $Grid->nama_customer->EditValue ?>"<?= $Grid->nama_customer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_customer->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_nama_customer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_customer" id="o<?= $Grid->RowIndex ?>_nama_customer" value="<?= HtmlEncode($Grid->nama_customer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_brand_customers_nama_customer" class="form-group">
<input type="hidden" data-table="v_list_brand_customers" data-field="x_nama_customer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama_customer" id="x<?= $Grid->RowIndex ?>_nama_customer" value="<?= HtmlEncode($Grid->nama_customer->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_brand_customers_nama_customer">
<span<?= $Grid->nama_customer->viewAttributes() ?>>
<?= $Grid->nama_customer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_nama_customer" data-hidden="1" name="fv_list_brand_customersgrid$x<?= $Grid->RowIndex ?>_nama_customer" id="fv_list_brand_customersgrid$x<?= $Grid->RowIndex ?>_nama_customer" value="<?= HtmlEncode($Grid->nama_customer->FormValue) ?>">
<input type="hidden" data-table="v_list_brand_customers" data-field="x_nama_customer" data-hidden="1" name="fv_list_brand_customersgrid$o<?= $Grid->RowIndex ?>_nama_customer" id="fv_list_brand_customersgrid$o<?= $Grid->RowIndex ?>_nama_customer" value="<?= HtmlEncode($Grid->nama_customer->OldValue) ?>">
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
loadjs.ready(["fv_list_brand_customersgrid","load"], function () {
    fv_list_brand_customersgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_v_list_brand_customers", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->kode_customer->Visible) { // kode_customer ?>
        <td data-name="kode_customer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_list_brand_customers_kode_customer" class="form-group v_list_brand_customers_kode_customer">
<input type="<?= $Grid->kode_customer->getInputTextType() ?>" data-table="v_list_brand_customers" data-field="x_kode_customer" name="x<?= $Grid->RowIndex ?>_kode_customer" id="x<?= $Grid->RowIndex ?>_kode_customer" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode_customer->getPlaceHolder()) ?>" value="<?= $Grid->kode_customer->EditValue ?>"<?= $Grid->kode_customer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode_customer->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_kode_customer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode_customer" id="x<?= $Grid->RowIndex ?>_kode_customer" value="<?= HtmlEncode($Grid->kode_customer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_kode_customer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode_customer" id="o<?= $Grid->RowIndex ?>_kode_customer" value="<?= HtmlEncode($Grid->kode_customer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama_customer->Visible) { // nama_customer ?>
        <td data-name="nama_customer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_list_brand_customers_nama_customer" class="form-group v_list_brand_customers_nama_customer">
<input type="<?= $Grid->nama_customer->getInputTextType() ?>" data-table="v_list_brand_customers" data-field="x_nama_customer" name="x<?= $Grid->RowIndex ?>_nama_customer" id="x<?= $Grid->RowIndex ?>_nama_customer" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_customer->getPlaceHolder()) ?>" value="<?= $Grid->nama_customer->EditValue ?>"<?= $Grid->nama_customer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_customer->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_nama_customer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama_customer" id="x<?= $Grid->RowIndex ?>_nama_customer" value="<?= HtmlEncode($Grid->nama_customer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_list_brand_customers" data-field="x_nama_customer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_customer" id="o<?= $Grid->RowIndex ?>_nama_customer" value="<?= HtmlEncode($Grid->nama_customer->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fv_list_brand_customersgrid","load"], function() {
    fv_list_brand_customersgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fv_list_brand_customersgrid">
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
    ew.addEventHandlers("v_list_brand_customers");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
