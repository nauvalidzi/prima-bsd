<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("ProductGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fproductgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fproductgrid = new ew.Form("fproductgrid", "grid");
    fproductgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "product")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.product)
        ew.vars.tables.product = currentTable;
    fproductgrid.addFields([
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null], fields.idbrand.isInvalid],
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["kemasanbarang", [fields.kemasanbarang.visible && fields.kemasanbarang.required ? ew.Validators.required(fields.kemasanbarang.caption) : null], fields.kemasanbarang.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null], fields.ukuran.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fproductgrid,
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
    fproductgrid.validate = function () {
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
    fproductgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idbrand", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kode", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kemasanbarang", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "harga", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ukuran", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fproductgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fproductgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fproductgrid.lists.idbrand = <?= $Grid->idbrand->toClientList($Grid) ?>;
    loadjs.done("fproductgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> product">
<div id="fproductgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_product" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_productgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idbrand->Visible) { // idbrand ?>
        <th data-name="idbrand" class="<?= $Grid->idbrand->headerCellClass() ?>"><div id="elh_product_idbrand" class="product_idbrand"><?= $Grid->renderSort($Grid->idbrand) ?></div></th>
<?php } ?>
<?php if ($Grid->kode->Visible) { // kode ?>
        <th data-name="kode" class="<?= $Grid->kode->headerCellClass() ?>"><div id="elh_product_kode" class="product_kode"><?= $Grid->renderSort($Grid->kode) ?></div></th>
<?php } ?>
<?php if ($Grid->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Grid->nama->headerCellClass() ?>"><div id="elh_product_nama" class="product_nama"><?= $Grid->renderSort($Grid->nama) ?></div></th>
<?php } ?>
<?php if ($Grid->kemasanbarang->Visible) { // kemasanbarang ?>
        <th data-name="kemasanbarang" class="<?= $Grid->kemasanbarang->headerCellClass() ?>"><div id="elh_product_kemasanbarang" class="product_kemasanbarang"><?= $Grid->renderSort($Grid->kemasanbarang) ?></div></th>
<?php } ?>
<?php if ($Grid->harga->Visible) { // harga ?>
        <th data-name="harga" class="<?= $Grid->harga->headerCellClass() ?>"><div id="elh_product_harga" class="product_harga"><?= $Grid->renderSort($Grid->harga) ?></div></th>
<?php } ?>
<?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <th data-name="ukuran" class="<?= $Grid->ukuran->headerCellClass() ?>"><div id="elh_product_ukuran" class="product_ukuran"><?= $Grid->renderSort($Grid->ukuran) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_product", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idbrand->Visible) { // idbrand ?>
        <td data-name="idbrand" <?= $Grid->idbrand->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idbrand->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_product_idbrand" class="form-group">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idbrand" name="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_product_idbrand" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="product_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="product"
        data-field="x_idbrand"
        data-value-separator="<?= $Grid->idbrand->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idbrand->getPlaceHolder()) ?>"
        <?= $Grid->idbrand->editAttributes() ?>>
        <?= $Grid->idbrand->selectOptionListHtml("x{$Grid->RowIndex}_idbrand") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idbrand->getErrorMessage() ?></div>
<?= $Grid->idbrand->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idbrand") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='product_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "product_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="product" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idbrand->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_product_idbrand" class="form-group">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idbrand" name="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_product_idbrand" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="product_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="product"
        data-field="x_idbrand"
        data-value-separator="<?= $Grid->idbrand->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idbrand->getPlaceHolder()) ?>"
        <?= $Grid->idbrand->editAttributes() ?>>
        <?= $Grid->idbrand->selectOptionListHtml("x{$Grid->RowIndex}_idbrand") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idbrand->getErrorMessage() ?></div>
<?= $Grid->idbrand->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idbrand") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='product_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "product_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_product_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<?= $Grid->idbrand->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="product" data-field="x_idbrand" data-hidden="1" name="fproductgrid$x<?= $Grid->RowIndex ?>_idbrand" id="fproductgrid$x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<input type="hidden" data-table="product" data-field="x_idbrand" data-hidden="1" name="fproductgrid$o<?= $Grid->RowIndex ?>_idbrand" id="fproductgrid$o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode" <?= $Grid->kode->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_product_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="product" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="product" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_product_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="product" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_product_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<?= $Grid->kode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="product" data-field="x_kode" data-hidden="1" name="fproductgrid$x<?= $Grid->RowIndex ?>_kode" id="fproductgrid$x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<input type="hidden" data-table="product" data-field="x_kode" data-hidden="1" name="fproductgrid$o<?= $Grid->RowIndex ?>_kode" id="fproductgrid$o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Grid->nama->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_product_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="product" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="product" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_product_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="product" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_product_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<?= $Grid->nama->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="product" data-field="x_nama" data-hidden="1" name="fproductgrid$x<?= $Grid->RowIndex ?>_nama" id="fproductgrid$x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<input type="hidden" data-table="product" data-field="x_nama" data-hidden="1" name="fproductgrid$o<?= $Grid->RowIndex ?>_nama" id="fproductgrid$o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kemasanbarang->Visible) { // kemasanbarang ?>
        <td data-name="kemasanbarang" <?= $Grid->kemasanbarang->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_product_kemasanbarang" class="form-group">
<input type="<?= $Grid->kemasanbarang->getInputTextType() ?>" data-table="product" data-field="x_kemasanbarang" name="x<?= $Grid->RowIndex ?>_kemasanbarang" id="x<?= $Grid->RowIndex ?>_kemasanbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->kemasanbarang->getPlaceHolder()) ?>" value="<?= $Grid->kemasanbarang->EditValue ?>"<?= $Grid->kemasanbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasanbarang->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="product" data-field="x_kemasanbarang" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasanbarang" id="o<?= $Grid->RowIndex ?>_kemasanbarang" value="<?= HtmlEncode($Grid->kemasanbarang->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_product_kemasanbarang" class="form-group">
<input type="<?= $Grid->kemasanbarang->getInputTextType() ?>" data-table="product" data-field="x_kemasanbarang" name="x<?= $Grid->RowIndex ?>_kemasanbarang" id="x<?= $Grid->RowIndex ?>_kemasanbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->kemasanbarang->getPlaceHolder()) ?>" value="<?= $Grid->kemasanbarang->EditValue ?>"<?= $Grid->kemasanbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasanbarang->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_product_kemasanbarang">
<span<?= $Grid->kemasanbarang->viewAttributes() ?>>
<?= $Grid->kemasanbarang->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="product" data-field="x_kemasanbarang" data-hidden="1" name="fproductgrid$x<?= $Grid->RowIndex ?>_kemasanbarang" id="fproductgrid$x<?= $Grid->RowIndex ?>_kemasanbarang" value="<?= HtmlEncode($Grid->kemasanbarang->FormValue) ?>">
<input type="hidden" data-table="product" data-field="x_kemasanbarang" data-hidden="1" name="fproductgrid$o<?= $Grid->RowIndex ?>_kemasanbarang" id="fproductgrid$o<?= $Grid->RowIndex ?>_kemasanbarang" value="<?= HtmlEncode($Grid->kemasanbarang->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->harga->Visible) { // harga ?>
        <td data-name="harga" <?= $Grid->harga->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_product_harga" class="form-group">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="product" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="product" data-field="x_harga" data-hidden="1" name="o<?= $Grid->RowIndex ?>_harga" id="o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_product_harga" class="form-group">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="product" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_product_harga">
<span<?= $Grid->harga->viewAttributes() ?>>
<?= $Grid->harga->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="product" data-field="x_harga" data-hidden="1" name="fproductgrid$x<?= $Grid->RowIndex ?>_harga" id="fproductgrid$x<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->FormValue) ?>">
<input type="hidden" data-table="product" data-field="x_harga" data-hidden="1" name="fproductgrid$o<?= $Grid->RowIndex ?>_harga" id="fproductgrid$o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran" <?= $Grid->ukuran->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_product_ukuran" class="form-group">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="product" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="product" data-field="x_ukuran" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran" id="o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_product_ukuran" class="form-group">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="product" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_product_ukuran">
<span<?= $Grid->ukuran->viewAttributes() ?>>
<?= $Grid->ukuran->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="product" data-field="x_ukuran" data-hidden="1" name="fproductgrid$x<?= $Grid->RowIndex ?>_ukuran" id="fproductgrid$x<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->FormValue) ?>">
<input type="hidden" data-table="product" data-field="x_ukuran" data-hidden="1" name="fproductgrid$o<?= $Grid->RowIndex ?>_ukuran" id="fproductgrid$o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
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
loadjs.ready(["fproductgrid","load"], function () {
    fproductgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_product", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idbrand->Visible) { // idbrand ?>
        <td data-name="idbrand">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idbrand->getSessionValue() != "") { ?>
<span id="el$rowindex$_product_idbrand" class="form-group product_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idbrand" name="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_product_idbrand" class="form-group product_idbrand">
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="product_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="product"
        data-field="x_idbrand"
        data-value-separator="<?= $Grid->idbrand->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idbrand->getPlaceHolder()) ?>"
        <?= $Grid->idbrand->editAttributes() ?>>
        <?= $Grid->idbrand->selectOptionListHtml("x{$Grid->RowIndex}_idbrand") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idbrand->getErrorMessage() ?></div>
<?= $Grid->idbrand->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idbrand") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='product_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "product_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_product_idbrand" class="form-group product_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="product" data-field="x_idbrand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idbrand" id="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_product_kode" class="form-group product_kode">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="product" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_product_kode" class="form-group product_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="product" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_product_nama" class="form-group product_nama">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="product" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_product_nama" class="form-group product_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama->getDisplayValue($Grid->nama->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="product" data-field="x_nama" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kemasanbarang->Visible) { // kemasanbarang ?>
        <td data-name="kemasanbarang">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_product_kemasanbarang" class="form-group product_kemasanbarang">
<input type="<?= $Grid->kemasanbarang->getInputTextType() ?>" data-table="product" data-field="x_kemasanbarang" name="x<?= $Grid->RowIndex ?>_kemasanbarang" id="x<?= $Grid->RowIndex ?>_kemasanbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->kemasanbarang->getPlaceHolder()) ?>" value="<?= $Grid->kemasanbarang->EditValue ?>"<?= $Grid->kemasanbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasanbarang->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_product_kemasanbarang" class="form-group product_kemasanbarang">
<span<?= $Grid->kemasanbarang->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kemasanbarang->getDisplayValue($Grid->kemasanbarang->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="product" data-field="x_kemasanbarang" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kemasanbarang" id="x<?= $Grid->RowIndex ?>_kemasanbarang" value="<?= HtmlEncode($Grid->kemasanbarang->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product" data-field="x_kemasanbarang" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasanbarang" id="o<?= $Grid->RowIndex ?>_kemasanbarang" value="<?= HtmlEncode($Grid->kemasanbarang->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->harga->Visible) { // harga ?>
        <td data-name="harga">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_product_harga" class="form-group product_harga">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="product" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_product_harga" class="form-group product_harga">
<span<?= $Grid->harga->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->harga->getDisplayValue($Grid->harga->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="product" data-field="x_harga" data-hidden="1" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product" data-field="x_harga" data-hidden="1" name="o<?= $Grid->RowIndex ?>_harga" id="o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_product_ukuran" class="form-group product_ukuran">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="product" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_product_ukuran" class="form-group product_ukuran">
<span<?= $Grid->ukuran->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ukuran->getDisplayValue($Grid->ukuran->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="product" data-field="x_ukuran" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="product" data-field="x_ukuran" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran" id="o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fproductgrid","load"], function() {
    fproductgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fproductgrid">
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
    ew.addEventHandlers("product");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
