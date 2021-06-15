<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("OrderDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var forder_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    forder_detailgrid = new ew.Form("forder_detailgrid", "grid");
    forder_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "order_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.order_detail)
        ew.vars.tables.order_detail = currentTable;
    forder_detailgrid.addFields([
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null], fields.idbrand.isInvalid],
        ["idproduct", [fields.idproduct.visible && fields.idproduct.required ? ew.Validators.required(fields.idproduct.caption) : null], fields.idproduct.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid],
        ["bonus", [fields.bonus.visible && fields.bonus.required ? ew.Validators.required(fields.bonus.caption) : null, ew.Validators.integer], fields.bonus.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.integer], fields.total.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = forder_detailgrid,
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
    forder_detailgrid.validate = function () {
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
    forder_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idbrand", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idproduct", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlah", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bonus", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisa", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "harga", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "total", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    forder_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    forder_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    forder_detailgrid.lists.idbrand = <?= $Grid->idbrand->toClientList($Grid) ?>;
    forder_detailgrid.lists.idproduct = <?= $Grid->idproduct->toClientList($Grid) ?>;
    loadjs.done("forder_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> order_detail">
<div id="forder_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_order_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_order_detailgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idbrand" class="<?= $Grid->idbrand->headerCellClass() ?>"><div id="elh_order_detail_idbrand" class="order_detail_idbrand"><?= $Grid->renderSort($Grid->idbrand) ?></div></th>
<?php } ?>
<?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <th data-name="idproduct" class="<?= $Grid->idproduct->headerCellClass() ?>"><div id="elh_order_detail_idproduct" class="order_detail_idproduct"><?= $Grid->renderSort($Grid->idproduct) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <th data-name="jumlah" class="<?= $Grid->jumlah->headerCellClass() ?>"><div id="elh_order_detail_jumlah" class="order_detail_jumlah"><?= $Grid->renderSort($Grid->jumlah) ?></div></th>
<?php } ?>
<?php if ($Grid->bonus->Visible) { // bonus ?>
        <th data-name="bonus" class="<?= $Grid->bonus->headerCellClass() ?>"><div id="elh_order_detail_bonus" class="order_detail_bonus"><?= $Grid->renderSort($Grid->bonus) ?></div></th>
<?php } ?>
<?php if ($Grid->sisa->Visible) { // sisa ?>
        <th data-name="sisa" class="<?= $Grid->sisa->headerCellClass() ?>"><div id="elh_order_detail_sisa" class="order_detail_sisa"><?= $Grid->renderSort($Grid->sisa) ?></div></th>
<?php } ?>
<?php if ($Grid->harga->Visible) { // harga ?>
        <th data-name="harga" class="<?= $Grid->harga->headerCellClass() ?>"><div id="elh_order_detail_harga" class="order_detail_harga"><?= $Grid->renderSort($Grid->harga) ?></div></th>
<?php } ?>
<?php if ($Grid->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Grid->total->headerCellClass() ?>"><div id="elh_order_detail_total" class="order_detail_total"><?= $Grid->renderSort($Grid->total) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_order_detail", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_order_detail_idbrand" class="form-group">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idbrand" name="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idbrand" class="form-group">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="order_detail"
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
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "order_detail_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idbrand->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idbrand" class="form-group">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idbrand" name="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idbrand" class="form-group">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="order_detail"
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
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "order_detail_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<?= $Grid->idbrand->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_idbrand" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_idbrand" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_idbrand" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_idbrand" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <td data-name="idproduct" <?= $Grid->idproduct->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idproduct->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idproduct" class="form-group">
<span<?= $Grid->idproduct->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idproduct->getDisplayValue($Grid->idproduct->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idproduct" name="x<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idproduct" class="form-group">
<?php $Grid->idproduct->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idproduct"
        name="x<?= $Grid->RowIndex ?>_idproduct"
        class="form-control ew-select<?= $Grid->idproduct->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_idproduct"
        data-table="order_detail"
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
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_idproduct']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idproduct", selectId: "order_detail_x<?= $Grid->RowIndex ?>_idproduct", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.idproduct.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_idproduct" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idproduct" id="o<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idproduct->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idproduct" class="form-group">
<span<?= $Grid->idproduct->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idproduct->getDisplayValue($Grid->idproduct->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idproduct" name="x<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idproduct" class="form-group">
<?php $Grid->idproduct->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idproduct"
        name="x<?= $Grid->RowIndex ?>_idproduct"
        class="form-control ew-select<?= $Grid->idproduct->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_idproduct"
        data-table="order_detail"
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
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_idproduct']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idproduct", selectId: "order_detail_x<?= $Grid->RowIndex ?>_idproduct", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.idproduct.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_idproduct">
<span<?= $Grid->idproduct->viewAttributes() ?>>
<?= $Grid->idproduct->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_idproduct" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_idproduct" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_idproduct" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_idproduct" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah" <?= $Grid->jumlah->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="order_detail" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_detail" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="order_detail" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<?= $Grid->jumlah->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_jumlah" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_jumlah" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_jumlah" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_jumlah" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bonus->Visible) { // bonus ?>
        <td data-name="bonus" <?= $Grid->bonus->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_bonus" class="form-group">
<input type="<?= $Grid->bonus->getInputTextType() ?>" data-table="order_detail" data-field="x_bonus" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" size="30" placeholder="<?= HtmlEncode($Grid->bonus->getPlaceHolder()) ?>" value="<?= $Grid->bonus->EditValue ?>"<?= $Grid->bonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bonus->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_detail" data-field="x_bonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bonus" id="o<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_bonus" class="form-group">
<input type="<?= $Grid->bonus->getInputTextType() ?>" data-table="order_detail" data-field="x_bonus" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" size="30" placeholder="<?= HtmlEncode($Grid->bonus->getPlaceHolder()) ?>" value="<?= $Grid->bonus->EditValue ?>"<?= $Grid->bonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bonus->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_bonus">
<span<?= $Grid->bonus->viewAttributes() ?>>
<?= $Grid->bonus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_bonus" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_bonus" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_bonus" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_bonus" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa" <?= $Grid->sisa->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="order_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_sisa" class="form-group">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="order_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<?= $Grid->sisa->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_sisa" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_sisa" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_sisa" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_sisa" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->harga->Visible) { // harga ?>
        <td data-name="harga" <?= $Grid->harga->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_harga" class="form-group">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="order_detail" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_detail" data-field="x_harga" data-hidden="1" name="o<?= $Grid->RowIndex ?>_harga" id="o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_harga" class="form-group">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="order_detail" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_harga">
<span<?= $Grid->harga->viewAttributes() ?>>
<?= $Grid->harga->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_harga" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_harga" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_harga" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_harga" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total" <?= $Grid->total->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_total" class="form-group">
<input type="<?= $Grid->total->getInputTextType() ?>" data-table="order_detail" data-field="x_total" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" value="<?= $Grid->total->EditValue ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_detail" data-field="x_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total" id="o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_total" class="form-group">
<input type="<?= $Grid->total->getInputTextType() ?>" data-table="order_detail" data-field="x_total" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" value="<?= $Grid->total->EditValue ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_total">
<span<?= $Grid->total->viewAttributes() ?>>
<?= $Grid->total->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_total" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_total" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_total" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_total" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
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
loadjs.ready(["forder_detailgrid","load"], function () {
    forder_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_order_detail", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_order_detail_idbrand" class="form-group order_detail_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idbrand" name="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_order_detail_idbrand" class="form-group order_detail_idbrand">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="order_detail"
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
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "order_detail_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_order_detail_idbrand" class="form-group order_detail_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_idbrand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idbrand" id="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <td data-name="idproduct">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idproduct->getSessionValue() != "") { ?>
<span id="el$rowindex$_order_detail_idproduct" class="form-group order_detail_idproduct">
<span<?= $Grid->idproduct->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idproduct->getDisplayValue($Grid->idproduct->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idproduct" name="x<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_order_detail_idproduct" class="form-group order_detail_idproduct">
<?php $Grid->idproduct->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idproduct"
        name="x<?= $Grid->RowIndex ?>_idproduct"
        class="form-control ew-select<?= $Grid->idproduct->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_idproduct"
        data-table="order_detail"
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
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_idproduct']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idproduct", selectId: "order_detail_x<?= $Grid->RowIndex ?>_idproduct", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.idproduct.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_order_detail_idproduct" class="form-group order_detail_idproduct">
<span<?= $Grid->idproduct->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idproduct->getDisplayValue($Grid->idproduct->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_idproduct" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idproduct" id="x<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_idproduct" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idproduct" id="o<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_jumlah" class="form-group order_detail_jumlah">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="order_detail" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_jumlah" class="form-group order_detail_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlah->getDisplayValue($Grid->jumlah->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_jumlah" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bonus->Visible) { // bonus ?>
        <td data-name="bonus">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_bonus" class="form-group order_detail_bonus">
<input type="<?= $Grid->bonus->getInputTextType() ?>" data-table="order_detail" data-field="x_bonus" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" size="30" placeholder="<?= HtmlEncode($Grid->bonus->getPlaceHolder()) ?>" value="<?= $Grid->bonus->EditValue ?>"<?= $Grid->bonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bonus->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_bonus" class="form-group order_detail_bonus">
<span<?= $Grid->bonus->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bonus->getDisplayValue($Grid->bonus->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_bonus" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_bonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bonus" id="o<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisa->Visible) { // sisa ?>
        <td data-name="sisa">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_sisa" class="form-group order_detail_sisa">
<input type="<?= $Grid->sisa->getInputTextType() ?>" data-table="order_detail" data-field="x_sisa" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" size="30" placeholder="<?= HtmlEncode($Grid->sisa->getPlaceHolder()) ?>" value="<?= $Grid->sisa->EditValue ?>"<?= $Grid->sisa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisa->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_sisa" class="form-group order_detail_sisa">
<span<?= $Grid->sisa->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisa->getDisplayValue($Grid->sisa->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_sisa" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisa" id="x<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_sisa" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisa" id="o<?= $Grid->RowIndex ?>_sisa" value="<?= HtmlEncode($Grid->sisa->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->harga->Visible) { // harga ?>
        <td data-name="harga">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_harga" class="form-group order_detail_harga">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="order_detail" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_harga" class="form-group order_detail_harga">
<span<?= $Grid->harga->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->harga->getDisplayValue($Grid->harga->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_harga" data-hidden="1" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_harga" data-hidden="1" name="o<?= $Grid->RowIndex ?>_harga" id="o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_total" class="form-group order_detail_total">
<input type="<?= $Grid->total->getInputTextType() ?>" data-table="order_detail" data-field="x_total" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" size="30" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" value="<?= $Grid->total->EditValue ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_total" class="form-group order_detail_total">
<span<?= $Grid->total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->total->getDisplayValue($Grid->total->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_total" data-hidden="1" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_total" id="o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["forder_detailgrid","load"], function() {
    forder_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="forder_detailgrid">
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
    ew.addEventHandlers("order_detail");
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
        container: "gmp_order_detail",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
