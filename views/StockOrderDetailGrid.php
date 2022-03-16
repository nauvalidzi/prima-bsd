<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("StockOrderDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fstock_order_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fstock_order_detailgrid = new ew.Form("fstock_order_detailgrid", "grid");
    fstock_order_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "stock_order_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.stock_order_detail)
        ew.vars.tables.stock_order_detail = currentTable;
    fstock_order_detailgrid.addFields([
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null], fields.idbrand.isInvalid],
        ["idproduct", [fields.idproduct.visible && fields.idproduct.required ? ew.Validators.required(fields.idproduct.caption) : null], fields.idproduct.isInvalid],
        ["stok_akhir", [fields.stok_akhir.visible && fields.stok_akhir.required ? ew.Validators.required(fields.stok_akhir.caption) : null, ew.Validators.integer], fields.stok_akhir.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstock_order_detailgrid,
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
    fstock_order_detailgrid.validate = function () {
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
    fstock_order_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idbrand", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idproduct", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "stok_akhir", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisa", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlah", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "keterangan", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fstock_order_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstock_order_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fstock_order_detailgrid.lists.idbrand = <?= $Grid->idbrand->toClientList($Grid) ?>;
    fstock_order_detailgrid.lists.idproduct = <?= $Grid->idproduct->toClientList($Grid) ?>;
    loadjs.done("fstock_order_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> stock_order_detail">
<div id="fstock_order_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_stock_order_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_stock_order_detailgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idbrand" class="<?= $Grid->idbrand->headerCellClass() ?>"><div id="elh_stock_order_detail_idbrand" class="stock_order_detail_idbrand"><?= $Grid->renderSort($Grid->idbrand) ?></div></th>
<?php } ?>
<?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <th data-name="idproduct" class="<?= $Grid->idproduct->headerCellClass() ?>"><div id="elh_stock_order_detail_idproduct" class="stock_order_detail_idproduct"><?= $Grid->renderSort($Grid->idproduct) ?></div></th>
<?php } ?>
<?php if ($Grid->stok_akhir->Visible) { // stok_akhir ?>
        <th data-name="stok_akhir" class="<?= $Grid->stok_akhir->headerCellClass() ?>"><div id="elh_stock_order_detail_stok_akhir" class="stock_order_detail_stok_akhir"><?= $Grid->renderSort($Grid->stok_akhir) ?></div></th>
<?php } ?>
<?php if ($Grid->sisa->Visible) { // sisa ?>
        <th data-name="sisa" class="<?= $Grid->sisa->headerCellClass() ?>"><div id="elh_stock_order_detail_sisa" class="stock_order_detail_sisa"><?= $Grid->renderSort($Grid->sisa) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <th data-name="jumlah" class="<?= $Grid->jumlah->headerCellClass() ?>"><div id="elh_stock_order_detail_jumlah" class="stock_order_detail_jumlah"><?= $Grid->renderSort($Grid->jumlah) ?></div></th>
<?php } ?>
<?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Grid->keterangan->headerCellClass() ?>"><div id="elh_stock_order_detail_keterangan" class="stock_order_detail_keterangan"><?= $Grid->renderSort($Grid->keterangan) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_stock_order_detail", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_idbrand" class="form-group">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="stock_order_detail"
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
    var el = document.querySelector("select[data-select2-id='stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_order_detail.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_idbrand" class="form-group">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="stock_order_detail"
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
    var el = document.querySelector("select[data-select2-id='stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_order_detail.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<?= $Grid->idbrand->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_idbrand" data-hidden="1" name="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_idbrand" id="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<input type="hidden" data-table="stock_order_detail" data-field="x_idbrand" data-hidden="1" name="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_idbrand" id="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <td data-name="idproduct" <?= $Grid->idproduct->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_idproduct" class="form-group">
<?php $Grid->idproduct->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idproduct"
        name="x<?= $Grid->RowIndex ?>_idproduct"
        class="form-control ew-select<?= $Grid->idproduct->isInvalidClass() ?>"
        data-select2-id="stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct"
        data-table="stock_order_detail"
        data-field="x_idproduct"
        data-value-separator="<?= $Grid->idproduct->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idproduct->getPlaceHolder()) ?>"
        <?= $Grid->idproduct->editAttributes() ?>>
        <?= $Grid->idproduct->selectOptionListHtml("x{$Grid->RowIndex}_idproduct") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idproduct->getErrorMessage() ?></div>
<?= $Grid->idproduct->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idproduct") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idproduct", selectId: "stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_order_detail.fields.idproduct.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_idproduct" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idproduct" id="o<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_idproduct" class="form-group">
<?php $Grid->idproduct->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idproduct"
        name="x<?= $Grid->RowIndex ?>_idproduct"
        class="form-control ew-select<?= $Grid->idproduct->isInvalidClass() ?>"
        data-select2-id="stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct"
        data-table="stock_order_detail"
        data-field="x_idproduct"
        data-value-separator="<?= $Grid->idproduct->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idproduct->getPlaceHolder()) ?>"
        <?= $Grid->idproduct->editAttributes() ?>>
        <?= $Grid->idproduct->selectOptionListHtml("x{$Grid->RowIndex}_idproduct") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idproduct->getErrorMessage() ?></div>
<?= $Grid->idproduct->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idproduct") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idproduct", selectId: "stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_order_detail.fields.idproduct.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_idproduct">
<span<?= $Grid->idproduct->viewAttributes() ?>>
<?= $Grid->idproduct->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_idproduct" data-hidden="1" name="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_idproduct" id="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->FormValue) ?>">
<input type="hidden" data-table="stock_order_detail" data-field="x_idproduct" data-hidden="1" name="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_idproduct" id="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->stok_akhir->Visible) { // stok_akhir ?>
        <td data-name="stok_akhir" <?= $Grid->stok_akhir->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_stok_akhir" class="form-group">
<input type="<?= $Grid->stok_akhir->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_stok_akhir" name="x<?= $Grid->RowIndex ?>_stok_akhir" id="x<?= $Grid->RowIndex ?>_stok_akhir" size="30" placeholder="<?= HtmlEncode($Grid->stok_akhir->getPlaceHolder()) ?>" value="<?= $Grid->stok_akhir->EditValue ?>"<?= $Grid->stok_akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->stok_akhir->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_stok_akhir" data-hidden="1" name="o<?= $Grid->RowIndex ?>_stok_akhir" id="o<?= $Grid->RowIndex ?>_stok_akhir" value="<?= HtmlEncode($Grid->stok_akhir->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_stok_akhir" class="form-group">
<input type="<?= $Grid->stok_akhir->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_stok_akhir" name="x<?= $Grid->RowIndex ?>_stok_akhir" id="x<?= $Grid->RowIndex ?>_stok_akhir" size="30" placeholder="<?= HtmlEncode($Grid->stok_akhir->getPlaceHolder()) ?>" value="<?= $Grid->stok_akhir->EditValue ?>"<?= $Grid->stok_akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->stok_akhir->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_stok_akhir">
<span<?= $Grid->stok_akhir->viewAttributes() ?>>
<?= $Grid->stok_akhir->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_stok_akhir" data-hidden="1" name="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_stok_akhir" id="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_stok_akhir" value="<?= HtmlEncode($Grid->stok_akhir->FormValue) ?>">
<input type="hidden" data-table="stock_order_detail" data-field="x_stok_akhir" data-hidden="1" name="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_stok_akhir" id="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_stok_akhir" value="<?= HtmlEncode($Grid->stok_akhir->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa" <?= $Grid->sisa->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<?= $Grid->sisa->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_sisa" data-hidden="1" name="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_sisa" id="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<input type="hidden" data-table="stock_order_detail" data-field="x_sisa" data-hidden="1" name="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_sisa" id="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah" <?= $Grid->jumlah->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<?= $Grid->jumlah->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_jumlah" data-hidden="1" name="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_jumlah" id="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<input type="hidden" data-table="stock_order_detail" data-field="x_jumlah" data-hidden="1" name="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_jumlah" id="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Grid->keterangan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_keterangan" class="form-group">
<textarea data-table="stock_order_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_keterangan" class="form-group">
<textarea data-table="stock_order_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_order_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_keterangan" data-hidden="1" name="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" id="fstock_order_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<input type="hidden" data-table="stock_order_detail" data-field="x_keterangan" data-hidden="1" name="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" id="fstock_order_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
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
loadjs.ready(["fstock_order_detailgrid","load"], function () {
    fstock_order_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_stock_order_detail", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_stock_order_detail_idbrand" class="form-group stock_order_detail_idbrand">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="stock_order_detail"
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
    var el = document.querySelector("select[data-select2-id='stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "stock_order_detail_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_order_detail.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_order_detail_idbrand" class="form-group stock_order_detail_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_idbrand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idbrand" id="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <td data-name="idproduct">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_order_detail_idproduct" class="form-group stock_order_detail_idproduct">
<?php $Grid->idproduct->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idproduct"
        name="x<?= $Grid->RowIndex ?>_idproduct"
        class="form-control ew-select<?= $Grid->idproduct->isInvalidClass() ?>"
        data-select2-id="stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct"
        data-table="stock_order_detail"
        data-field="x_idproduct"
        data-value-separator="<?= $Grid->idproduct->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idproduct->getPlaceHolder()) ?>"
        <?= $Grid->idproduct->editAttributes() ?>>
        <?= $Grid->idproduct->selectOptionListHtml("x{$Grid->RowIndex}_idproduct") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idproduct->getErrorMessage() ?></div>
<?= $Grid->idproduct->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idproduct") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idproduct", selectId: "stock_order_detail_x<?= $Grid->RowIndex ?>_idproduct", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_order_detail.fields.idproduct.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_order_detail_idproduct" class="form-group stock_order_detail_idproduct">
<span<?= $Grid->idproduct->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idproduct->getDisplayValue($Grid->idproduct->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_idproduct" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idproduct" id="x<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_idproduct" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idproduct" id="o<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->stok_akhir->Visible) { // stok_akhir ?>
        <td data-name="stok_akhir">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_order_detail_stok_akhir" class="form-group stock_order_detail_stok_akhir">
<input type="<?= $Grid->stok_akhir->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_stok_akhir" name="x<?= $Grid->RowIndex ?>_stok_akhir" id="x<?= $Grid->RowIndex ?>_stok_akhir" size="30" placeholder="<?= HtmlEncode($Grid->stok_akhir->getPlaceHolder()) ?>" value="<?= $Grid->stok_akhir->EditValue ?>"<?= $Grid->stok_akhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->stok_akhir->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_order_detail_stok_akhir" class="form-group stock_order_detail_stok_akhir">
<span<?= $Grid->stok_akhir->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->stok_akhir->getDisplayValue($Grid->stok_akhir->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_stok_akhir" data-hidden="1" name="x<?= $Grid->RowIndex ?>_stok_akhir" id="x<?= $Grid->RowIndex ?>_stok_akhir" value="<?= HtmlEncode($Grid->stok_akhir->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_stok_akhir" data-hidden="1" name="o<?= $Grid->RowIndex ?>_stok_akhir" id="o<?= $Grid->RowIndex ?>_stok_akhir" value="<?= HtmlEncode($Grid->stok_akhir->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_order_detail_sisa" class="form-group stock_order_detail_sisa">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_order_detail_sisa" class="form-group stock_order_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisa->getDisplayValue($Grid->sisa->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_sisa" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_order_detail_jumlah" class="form-group stock_order_detail_jumlah">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_order_detail_jumlah" class="form-group stock_order_detail_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlah->getDisplayValue($Grid->jumlah->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_jumlah" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_order_detail_keterangan" class="form-group stock_order_detail_keterangan">
<textarea data-table="stock_order_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_order_detail_keterangan" class="form-group stock_order_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->ViewValue ?></span>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_keterangan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_order_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fstock_order_detailgrid","load"], function() {
    fstock_order_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fstock_order_detailgrid">
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
    ew.addEventHandlers("stock_order_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
