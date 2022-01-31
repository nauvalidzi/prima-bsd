<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("VListCustomerBrandsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_list_customer_brandsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fv_list_customer_brandsgrid = new ew.Form("fv_list_customer_brandsgrid", "grid");
    fv_list_customer_brandsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_list_customer_brands")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.v_list_customer_brands)
        ew.vars.tables.v_list_customer_brands = currentTable;
    fv_list_customer_brandsgrid.addFields([
        ["kode_brand", [fields.kode_brand.visible && fields.kode_brand.required ? ew.Validators.required(fields.kode_brand.caption) : null], fields.kode_brand.isInvalid],
        ["nama_brand", [fields.nama_brand.visible && fields.nama_brand.required ? ew.Validators.required(fields.nama_brand.caption) : null], fields.nama_brand.isInvalid],
        ["jumlah_produk", [fields.jumlah_produk.visible && fields.jumlah_produk.required ? ew.Validators.required(fields.jumlah_produk.caption) : null], fields.jumlah_produk.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fv_list_customer_brandsgrid,
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
    fv_list_customer_brandsgrid.validate = function () {
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
    fv_list_customer_brandsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "kode_brand", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama_brand", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlah_produk", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fv_list_customer_brandsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_list_customer_brandsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fv_list_customer_brandsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> v_list_customer_brands">
<div id="fv_list_customer_brandsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_v_list_customer_brands" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_v_list_customer_brandsgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->kode_brand->Visible) { // kode_brand ?>
        <th data-name="kode_brand" class="<?= $Grid->kode_brand->headerCellClass() ?>"><div id="elh_v_list_customer_brands_kode_brand" class="v_list_customer_brands_kode_brand"><?= $Grid->renderSort($Grid->kode_brand) ?></div></th>
<?php } ?>
<?php if ($Grid->nama_brand->Visible) { // nama_brand ?>
        <th data-name="nama_brand" class="<?= $Grid->nama_brand->headerCellClass() ?>"><div id="elh_v_list_customer_brands_nama_brand" class="v_list_customer_brands_nama_brand"><?= $Grid->renderSort($Grid->nama_brand) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlah_produk->Visible) { // jumlah_produk ?>
        <th data-name="jumlah_produk" class="<?= $Grid->jumlah_produk->headerCellClass() ?>"><div id="elh_v_list_customer_brands_jumlah_produk" class="v_list_customer_brands_jumlah_produk"><?= $Grid->renderSort($Grid->jumlah_produk) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_v_list_customer_brands", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->kode_brand->Visible) { // kode_brand ?>
        <td data-name="kode_brand" <?= $Grid->kode_brand->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_kode_brand" class="form-group">
<input type="<?= $Grid->kode_brand->getInputTextType() ?>" data-table="v_list_customer_brands" data-field="x_kode_brand" name="x<?= $Grid->RowIndex ?>_kode_brand" id="x<?= $Grid->RowIndex ?>_kode_brand" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode_brand->getPlaceHolder()) ?>" value="<?= $Grid->kode_brand->EditValue ?>"<?= $Grid->kode_brand->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode_brand->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_kode_brand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode_brand" id="o<?= $Grid->RowIndex ?>_kode_brand" value="<?= HtmlEncode($Grid->kode_brand->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_kode_brand" class="form-group">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_kode_brand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode_brand" id="x<?= $Grid->RowIndex ?>_kode_brand" value="<?= HtmlEncode($Grid->kode_brand->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_kode_brand">
<span<?= $Grid->kode_brand->viewAttributes() ?>>
<?= $Grid->kode_brand->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_kode_brand" data-hidden="1" name="fv_list_customer_brandsgrid$x<?= $Grid->RowIndex ?>_kode_brand" id="fv_list_customer_brandsgrid$x<?= $Grid->RowIndex ?>_kode_brand" value="<?= HtmlEncode($Grid->kode_brand->FormValue) ?>">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_kode_brand" data-hidden="1" name="fv_list_customer_brandsgrid$o<?= $Grid->RowIndex ?>_kode_brand" id="fv_list_customer_brandsgrid$o<?= $Grid->RowIndex ?>_kode_brand" value="<?= HtmlEncode($Grid->kode_brand->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama_brand->Visible) { // nama_brand ?>
        <td data-name="nama_brand" <?= $Grid->nama_brand->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_nama_brand" class="form-group">
<input type="<?= $Grid->nama_brand->getInputTextType() ?>" data-table="v_list_customer_brands" data-field="x_nama_brand" name="x<?= $Grid->RowIndex ?>_nama_brand" id="x<?= $Grid->RowIndex ?>_nama_brand" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_brand->getPlaceHolder()) ?>" value="<?= $Grid->nama_brand->EditValue ?>"<?= $Grid->nama_brand->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_brand->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_nama_brand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_brand" id="o<?= $Grid->RowIndex ?>_nama_brand" value="<?= HtmlEncode($Grid->nama_brand->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_nama_brand" class="form-group">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_nama_brand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama_brand" id="x<?= $Grid->RowIndex ?>_nama_brand" value="<?= HtmlEncode($Grid->nama_brand->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_nama_brand">
<span<?= $Grid->nama_brand->viewAttributes() ?>>
<?= $Grid->nama_brand->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_nama_brand" data-hidden="1" name="fv_list_customer_brandsgrid$x<?= $Grid->RowIndex ?>_nama_brand" id="fv_list_customer_brandsgrid$x<?= $Grid->RowIndex ?>_nama_brand" value="<?= HtmlEncode($Grid->nama_brand->FormValue) ?>">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_nama_brand" data-hidden="1" name="fv_list_customer_brandsgrid$o<?= $Grid->RowIndex ?>_nama_brand" id="fv_list_customer_brandsgrid$o<?= $Grid->RowIndex ?>_nama_brand" value="<?= HtmlEncode($Grid->nama_brand->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlah_produk->Visible) { // jumlah_produk ?>
        <td data-name="jumlah_produk" <?= $Grid->jumlah_produk->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_jumlah_produk" class="form-group">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah_produk" id="x<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->CurrentValue) ?>">
</span>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah_produk" id="o<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_jumlah_produk" class="form-group">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah_produk" id="x<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_v_list_customer_brands_jumlah_produk">
<span<?= $Grid->jumlah_produk->viewAttributes() ?>>
<?= $Grid->jumlah_produk->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="fv_list_customer_brandsgrid$x<?= $Grid->RowIndex ?>_jumlah_produk" id="fv_list_customer_brandsgrid$x<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->FormValue) ?>">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="fv_list_customer_brandsgrid$o<?= $Grid->RowIndex ?>_jumlah_produk" id="fv_list_customer_brandsgrid$o<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->OldValue) ?>">
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
loadjs.ready(["fv_list_customer_brandsgrid","load"], function () {
    fv_list_customer_brandsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_v_list_customer_brands", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->kode_brand->Visible) { // kode_brand ?>
        <td data-name="kode_brand">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_list_customer_brands_kode_brand" class="form-group v_list_customer_brands_kode_brand">
<input type="<?= $Grid->kode_brand->getInputTextType() ?>" data-table="v_list_customer_brands" data-field="x_kode_brand" name="x<?= $Grid->RowIndex ?>_kode_brand" id="x<?= $Grid->RowIndex ?>_kode_brand" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode_brand->getPlaceHolder()) ?>" value="<?= $Grid->kode_brand->EditValue ?>"<?= $Grid->kode_brand->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode_brand->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_kode_brand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode_brand" id="x<?= $Grid->RowIndex ?>_kode_brand" value="<?= HtmlEncode($Grid->kode_brand->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_kode_brand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode_brand" id="o<?= $Grid->RowIndex ?>_kode_brand" value="<?= HtmlEncode($Grid->kode_brand->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama_brand->Visible) { // nama_brand ?>
        <td data-name="nama_brand">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_list_customer_brands_nama_brand" class="form-group v_list_customer_brands_nama_brand">
<input type="<?= $Grid->nama_brand->getInputTextType() ?>" data-table="v_list_customer_brands" data-field="x_nama_brand" name="x<?= $Grid->RowIndex ?>_nama_brand" id="x<?= $Grid->RowIndex ?>_nama_brand" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_brand->getPlaceHolder()) ?>" value="<?= $Grid->nama_brand->EditValue ?>"<?= $Grid->nama_brand->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_brand->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_nama_brand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama_brand" id="x<?= $Grid->RowIndex ?>_nama_brand" value="<?= HtmlEncode($Grid->nama_brand->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_nama_brand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_brand" id="o<?= $Grid->RowIndex ?>_nama_brand" value="<?= HtmlEncode($Grid->nama_brand->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlah_produk->Visible) { // jumlah_produk ?>
        <td data-name="jumlah_produk">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_v_list_customer_brands_jumlah_produk" class="form-group v_list_customer_brands_jumlah_produk">
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah_produk" id="x<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->CurrentValue) ?>">
</span>
<?php } else { ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah_produk" id="x<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_list_customer_brands" data-field="x_jumlah_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah_produk" id="o<?= $Grid->RowIndex ?>_jumlah_produk" value="<?= HtmlEncode($Grid->jumlah_produk->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fv_list_customer_brandsgrid","load"], function() {
    fv_list_customer_brandsgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fv_list_customer_brandsgrid">
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
    ew.addEventHandlers("v_list_customer_brands");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
