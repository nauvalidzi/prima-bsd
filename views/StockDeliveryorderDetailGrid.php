<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("StockDeliveryorderDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fstock_deliveryorder_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fstock_deliveryorder_detailgrid = new ew.Form("fstock_deliveryorder_detailgrid", "grid");
    fstock_deliveryorder_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "stock_deliveryorder_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.stock_deliveryorder_detail)
        ew.vars.tables.stock_deliveryorder_detail = currentTable;
    fstock_deliveryorder_detailgrid.addFields([
        ["idstockorder", [fields.idstockorder.visible && fields.idstockorder.required ? ew.Validators.required(fields.idstockorder.caption) : null], fields.idstockorder.isInvalid],
        ["idstockorder_detail", [fields.idstockorder_detail.visible && fields.idstockorder_detail.required ? ew.Validators.required(fields.idstockorder_detail.caption) : null], fields.idstockorder_detail.isInvalid],
        ["totalorder", [fields.totalorder.visible && fields.totalorder.required ? ew.Validators.required(fields.totalorder.caption) : null], fields.totalorder.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["jumlahkirim", [fields.jumlahkirim.visible && fields.jumlahkirim.required ? ew.Validators.required(fields.jumlahkirim.caption) : null, ew.Validators.integer], fields.jumlahkirim.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstock_deliveryorder_detailgrid,
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
    fstock_deliveryorder_detailgrid.validate = function () {
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
    fstock_deliveryorder_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idstockorder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idstockorder_detail", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "totalorder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisa", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlahkirim", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "keterangan", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fstock_deliveryorder_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstock_deliveryorder_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fstock_deliveryorder_detailgrid.lists.idstockorder = <?= $Grid->idstockorder->toClientList($Grid) ?>;
    fstock_deliveryorder_detailgrid.lists.idstockorder_detail = <?= $Grid->idstockorder_detail->toClientList($Grid) ?>;
    loadjs.done("fstock_deliveryorder_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> stock_deliveryorder_detail">
<div id="fstock_deliveryorder_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_stock_deliveryorder_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_stock_deliveryorder_detailgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idstockorder->Visible) { // idstockorder ?>
        <th data-name="idstockorder" class="<?= $Grid->idstockorder->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_idstockorder" class="stock_deliveryorder_detail_idstockorder"><?= $Grid->renderSort($Grid->idstockorder) ?></div></th>
<?php } ?>
<?php if ($Grid->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <th data-name="idstockorder_detail" class="<?= $Grid->idstockorder_detail->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_idstockorder_detail" class="stock_deliveryorder_detail_idstockorder_detail"><?= $Grid->renderSort($Grid->idstockorder_detail) ?></div></th>
<?php } ?>
<?php if ($Grid->totalorder->Visible) { // totalorder ?>
        <th data-name="totalorder" class="<?= $Grid->totalorder->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_totalorder" class="stock_deliveryorder_detail_totalorder"><?= $Grid->renderSort($Grid->totalorder) ?></div></th>
<?php } ?>
<?php if ($Grid->sisa->Visible) { // sisa ?>
        <th data-name="sisa" class="<?= $Grid->sisa->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_sisa" class="stock_deliveryorder_detail_sisa"><?= $Grid->renderSort($Grid->sisa) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <th data-name="jumlahkirim" class="<?= $Grid->jumlahkirim->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_jumlahkirim" class="stock_deliveryorder_detail_jumlahkirim"><?= $Grid->renderSort($Grid->jumlahkirim) ?></div></th>
<?php } ?>
<?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Grid->keterangan->headerCellClass() ?>"><div id="elh_stock_deliveryorder_detail_keterangan" class="stock_deliveryorder_detail_keterangan"><?= $Grid->renderSort($Grid->keterangan) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_stock_deliveryorder_detail", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idstockorder->Visible) { // idstockorder ?>
        <td data-name="idstockorder" <?= $Grid->idstockorder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_idstockorder" class="form-group">
<?php $Grid->idstockorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idstockorder"
        name="x<?= $Grid->RowIndex ?>_idstockorder"
        class="form-control ew-select<?= $Grid->idstockorder->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder"
        data-value-separator="<?= $Grid->idstockorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idstockorder->getPlaceHolder()) ?>"
        <?= $Grid->idstockorder->editAttributes() ?>>
        <?= $Grid->idstockorder->selectOptionListHtml("x{$Grid->RowIndex}_idstockorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idstockorder->getErrorMessage() ?></div>
<?= $Grid->idstockorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idstockorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idstockorder", selectId: "stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idstockorder" id="o<?= $Grid->RowIndex ?>_idstockorder" value="<?= HtmlEncode($Grid->idstockorder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_idstockorder" class="form-group">
<?php $Grid->idstockorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idstockorder"
        name="x<?= $Grid->RowIndex ?>_idstockorder"
        class="form-control ew-select<?= $Grid->idstockorder->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder"
        data-value-separator="<?= $Grid->idstockorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idstockorder->getPlaceHolder()) ?>"
        <?= $Grid->idstockorder->editAttributes() ?>>
        <?= $Grid->idstockorder->selectOptionListHtml("x{$Grid->RowIndex}_idstockorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idstockorder->getErrorMessage() ?></div>
<?= $Grid->idstockorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idstockorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idstockorder", selectId: "stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_idstockorder">
<span<?= $Grid->idstockorder->viewAttributes() ?>>
<?= $Grid->idstockorder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder" data-hidden="1" name="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idstockorder" id="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idstockorder" value="<?= HtmlEncode($Grid->idstockorder->FormValue) ?>">
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder" data-hidden="1" name="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idstockorder" id="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idstockorder" value="<?= HtmlEncode($Grid->idstockorder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <td data-name="idstockorder_detail" <?= $Grid->idstockorder_detail->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_idstockorder_detail" class="form-group">
<?php $Grid->idstockorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idstockorder_detail"
        name="x<?= $Grid->RowIndex ?>_idstockorder_detail"
        class="form-control ew-select<?= $Grid->idstockorder_detail->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder_detail"
        data-value-separator="<?= $Grid->idstockorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idstockorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idstockorder_detail->editAttributes() ?>>
        <?= $Grid->idstockorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idstockorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idstockorder_detail->getErrorMessage() ?></div>
<?= $Grid->idstockorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idstockorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idstockorder_detail", selectId: "stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idstockorder_detail" id="o<?= $Grid->RowIndex ?>_idstockorder_detail" value="<?= HtmlEncode($Grid->idstockorder_detail->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_idstockorder_detail" class="form-group">
<?php $Grid->idstockorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idstockorder_detail"
        name="x<?= $Grid->RowIndex ?>_idstockorder_detail"
        class="form-control ew-select<?= $Grid->idstockorder_detail->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder_detail"
        data-value-separator="<?= $Grid->idstockorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idstockorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idstockorder_detail->editAttributes() ?>>
        <?= $Grid->idstockorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idstockorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idstockorder_detail->getErrorMessage() ?></div>
<?= $Grid->idstockorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idstockorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idstockorder_detail", selectId: "stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_idstockorder_detail">
<span<?= $Grid->idstockorder_detail->viewAttributes() ?>>
<?= $Grid->idstockorder_detail->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder_detail" data-hidden="1" name="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idstockorder_detail" id="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_idstockorder_detail" value="<?= HtmlEncode($Grid->idstockorder_detail->FormValue) ?>">
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder_detail" data-hidden="1" name="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idstockorder_detail" id="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_idstockorder_detail" value="<?= HtmlEncode($Grid->idstockorder_detail->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->totalorder->Visible) { // totalorder ?>
        <td data-name="totalorder" <?= $Grid->totalorder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_totalorder" class="form-group">
<input type="<?= $Grid->totalorder->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_totalorder" name="x<?= $Grid->RowIndex ?>_totalorder" id="x<?= $Grid->RowIndex ?>_totalorder" size="30" placeholder="<?= HtmlEncode($Grid->totalorder->getPlaceHolder()) ?>" value="<?= $Grid->totalorder->EditValue ?>"<?= $Grid->totalorder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totalorder->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_totalorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totalorder" id="o<?= $Grid->RowIndex ?>_totalorder" value="<?= HtmlEncode($Grid->totalorder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_totalorder" class="form-group">
<span<?= $Grid->totalorder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->totalorder->getDisplayValue($Grid->totalorder->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_totalorder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_totalorder" id="x<?= $Grid->RowIndex ?>_totalorder" value="<?= HtmlEncode($Grid->totalorder->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_totalorder">
<span<?= $Grid->totalorder->viewAttributes() ?>>
<?= $Grid->totalorder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_totalorder" data-hidden="1" name="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_totalorder" id="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_totalorder" value="<?= HtmlEncode($Grid->totalorder->FormValue) ?>">
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_totalorder" data-hidden="1" name="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_totalorder" id="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_totalorder" value="<?= HtmlEncode($Grid->totalorder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa" <?= $Grid->sisa->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<?= $Grid->sisa->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_sisa" id="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_sisa" id="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim" <?= $Grid->jumlahkirim->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_jumlahkirim" class="form-group">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahkirim" id="o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_jumlahkirim" class="form-group">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_jumlahkirim">
<span<?= $Grid->jumlahkirim->viewAttributes() ?>>
<?= $Grid->jumlahkirim->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_jumlahkirim" id="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->FormValue) ?>">
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_jumlahkirim" id="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Grid->keterangan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_keterangan" class="form-group">
<textarea data-table="stock_deliveryorder_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_keterangan" class="form-group">
<textarea data-table="stock_deliveryorder_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_stock_deliveryorder_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_keterangan" data-hidden="1" name="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" id="fstock_deliveryorder_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_keterangan" data-hidden="1" name="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" id="fstock_deliveryorder_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
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
loadjs.ready(["fstock_deliveryorder_detailgrid","load"], function () {
    fstock_deliveryorder_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_stock_deliveryorder_detail", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idstockorder->Visible) { // idstockorder ?>
        <td data-name="idstockorder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_idstockorder" class="form-group stock_deliveryorder_detail_idstockorder">
<?php $Grid->idstockorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idstockorder"
        name="x<?= $Grid->RowIndex ?>_idstockorder"
        class="form-control ew-select<?= $Grid->idstockorder->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder"
        data-value-separator="<?= $Grid->idstockorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idstockorder->getPlaceHolder()) ?>"
        <?= $Grid->idstockorder->editAttributes() ?>>
        <?= $Grid->idstockorder->selectOptionListHtml("x{$Grid->RowIndex}_idstockorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idstockorder->getErrorMessage() ?></div>
<?= $Grid->idstockorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idstockorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idstockorder", selectId: "stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_idstockorder" class="form-group stock_deliveryorder_detail_idstockorder">
<span<?= $Grid->idstockorder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idstockorder->getDisplayValue($Grid->idstockorder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idstockorder" id="x<?= $Grid->RowIndex ?>_idstockorder" value="<?= HtmlEncode($Grid->idstockorder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idstockorder" id="o<?= $Grid->RowIndex ?>_idstockorder" value="<?= HtmlEncode($Grid->idstockorder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <td data-name="idstockorder_detail">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_idstockorder_detail" class="form-group stock_deliveryorder_detail_idstockorder_detail">
<?php $Grid->idstockorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idstockorder_detail"
        name="x<?= $Grid->RowIndex ?>_idstockorder_detail"
        class="form-control ew-select<?= $Grid->idstockorder_detail->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder_detail"
        data-value-separator="<?= $Grid->idstockorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idstockorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idstockorder_detail->editAttributes() ?>>
        <?= $Grid->idstockorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idstockorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idstockorder_detail->getErrorMessage() ?></div>
<?= $Grid->idstockorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idstockorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idstockorder_detail", selectId: "stock_deliveryorder_detail_x<?= $Grid->RowIndex ?>_idstockorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_idstockorder_detail" class="form-group stock_deliveryorder_detail_idstockorder_detail">
<span<?= $Grid->idstockorder_detail->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idstockorder_detail->getDisplayValue($Grid->idstockorder_detail->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder_detail" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idstockorder_detail" id="x<?= $Grid->RowIndex ?>_idstockorder_detail" value="<?= HtmlEncode($Grid->idstockorder_detail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_idstockorder_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idstockorder_detail" id="o<?= $Grid->RowIndex ?>_idstockorder_detail" value="<?= HtmlEncode($Grid->idstockorder_detail->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->totalorder->Visible) { // totalorder ?>
        <td data-name="totalorder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_totalorder" class="form-group stock_deliveryorder_detail_totalorder">
<input type="<?= $Grid->totalorder->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_totalorder" name="x<?= $Grid->RowIndex ?>_totalorder" id="x<?= $Grid->RowIndex ?>_totalorder" size="30" placeholder="<?= HtmlEncode($Grid->totalorder->getPlaceHolder()) ?>" value="<?= $Grid->totalorder->EditValue ?>"<?= $Grid->totalorder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totalorder->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_totalorder" class="form-group stock_deliveryorder_detail_totalorder">
<span<?= $Grid->totalorder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->totalorder->getDisplayValue($Grid->totalorder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_totalorder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_totalorder" id="x<?= $Grid->RowIndex ?>_totalorder" value="<?= HtmlEncode($Grid->totalorder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_totalorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totalorder" id="o<?= $Grid->RowIndex ?>_totalorder" value="<?= HtmlEncode($Grid->totalorder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_sisa" class="form-group stock_deliveryorder_detail_sisa">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_sisa" class="form-group stock_deliveryorder_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisa->getDisplayValue($Grid->sisa->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_jumlahkirim" class="form-group stock_deliveryorder_detail_jumlahkirim">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_jumlahkirim" class="form-group stock_deliveryorder_detail_jumlahkirim">
<span<?= $Grid->jumlahkirim->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlahkirim->getDisplayValue($Grid->jumlahkirim->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_jumlahkirim" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahkirim" id="o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_keterangan" class="form-group stock_deliveryorder_detail_keterangan">
<textarea data-table="stock_deliveryorder_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_stock_deliveryorder_detail_keterangan" class="form-group stock_deliveryorder_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->ViewValue ?></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_keterangan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fstock_deliveryorder_detailgrid","load"], function() {
    fstock_deliveryorder_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fstock_deliveryorder_detailgrid">
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
    ew.addEventHandlers("stock_deliveryorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
