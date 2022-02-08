<?php

namespace PHPMaker2021\production2;

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
        ["idproduct", [fields.idproduct.visible && fields.idproduct.required ? ew.Validators.required(fields.idproduct.caption) : null], fields.idproduct.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid],
        ["bonus", [fields.bonus.visible && fields.bonus.required ? ew.Validators.required(fields.bonus.caption) : null, ew.Validators.integer], fields.bonus.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.integer], fields.total.isInvalid],
        ["tipe_sla", [fields.tipe_sla.visible && fields.tipe_sla.required ? ew.Validators.required(fields.tipe_sla.caption) : null], fields.tipe_sla.isInvalid],
        ["sla", [fields.sla.visible && fields.sla.required ? ew.Validators.required(fields.sla.caption) : null], fields.sla.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
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
        if (ew.valueChanged(fobj, rowIndex, "tipe_sla", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sla", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "keterangan", false))
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
    forder_detailgrid.lists.idproduct = <?= $Grid->idproduct->toClientList($Grid) ?>;
    forder_detailgrid.lists.tipe_sla = <?= $Grid->tipe_sla->toClientList($Grid) ?>;
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
<?php if ($Grid->tipe_sla->Visible) { // tipe_sla ?>
        <th data-name="tipe_sla" class="<?= $Grid->tipe_sla->headerCellClass() ?>"><div id="elh_order_detail_tipe_sla" class="order_detail_tipe_sla"><?= $Grid->renderSort($Grid->tipe_sla) ?></div></th>
<?php } ?>
<?php if ($Grid->sla->Visible) { // sla ?>
        <th data-name="sla" class="<?= $Grid->sla->headerCellClass() ?>"><div id="elh_order_detail_sla" class="order_detail_sla"><?= $Grid->renderSort($Grid->sla) ?></div></th>
<?php } ?>
<?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Grid->keterangan->headerCellClass() ?>"><div id="elh_order_detail_keterangan" class="order_detail_keterangan"><?= $Grid->renderSort($Grid->keterangan) ?></div></th>
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
    <?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <td data-name="idproduct" <?= $Grid->idproduct->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
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
<input type="hidden" data-table="order_detail" data-field="x_idproduct" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idproduct" id="o<?= $Grid->RowIndex ?>_idproduct" value="<?= HtmlEncode($Grid->idproduct->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
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
    <?php if ($Grid->tipe_sla->Visible) { // tipe_sla ?>
        <td data-name="tipe_sla" <?= $Grid->tipe_sla->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_tipe_sla" class="form-group">
<?php $Grid->tipe_sla->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_tipe_sla"
        name="x<?= $Grid->RowIndex ?>_tipe_sla"
        class="form-control ew-select<?= $Grid->tipe_sla->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_tipe_sla"
        data-table="order_detail"
        data-field="x_tipe_sla"
        data-value-separator="<?= $Grid->tipe_sla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipe_sla->getPlaceHolder()) ?>"
        <?= $Grid->tipe_sla->editAttributes() ?>>
        <?= $Grid->tipe_sla->selectOptionListHtml("x{$Grid->RowIndex}_tipe_sla") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipe_sla->getErrorMessage() ?></div>
<?= $Grid->tipe_sla->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipe_sla") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_tipe_sla']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tipe_sla", selectId: "order_detail_x<?= $Grid->RowIndex ?>_tipe_sla", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.tipe_sla.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="order_detail" data-field="x_tipe_sla" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tipe_sla" id="o<?= $Grid->RowIndex ?>_tipe_sla" value="<?= HtmlEncode($Grid->tipe_sla->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_tipe_sla" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_tipe_sla"
        name="x<?= $Grid->RowIndex ?>_tipe_sla"
        class="form-control ew-select<?= $Grid->tipe_sla->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_tipe_sla"
        data-table="order_detail"
        data-field="x_tipe_sla"
        data-value-separator="<?= $Grid->tipe_sla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipe_sla->getPlaceHolder()) ?>"
        <?= $Grid->tipe_sla->editAttributes() ?>>
        <?= $Grid->tipe_sla->selectOptionListHtml("x{$Grid->RowIndex}_tipe_sla") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipe_sla->getErrorMessage() ?></div>
<?= $Grid->tipe_sla->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipe_sla") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_tipe_sla']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tipe_sla", selectId: "order_detail_x<?= $Grid->RowIndex ?>_tipe_sla", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.tipe_sla.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_tipe_sla">
<span<?= $Grid->tipe_sla->viewAttributes() ?>>
<?= $Grid->tipe_sla->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_tipe_sla" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_tipe_sla" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_tipe_sla" value="<?= HtmlEncode($Grid->tipe_sla->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_tipe_sla" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_tipe_sla" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_tipe_sla" value="<?= HtmlEncode($Grid->tipe_sla->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sla->Visible) { // sla ?>
        <td data-name="sla" <?= $Grid->sla->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_sla" class="form-group">
<input type="<?= $Grid->sla->getInputTextType() ?>" data-table="order_detail" data-field="x_sla" name="x<?= $Grid->RowIndex ?>_sla" id="x<?= $Grid->RowIndex ?>_sla" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->sla->getPlaceHolder()) ?>" value="<?= $Grid->sla->EditValue ?>"<?= $Grid->sla->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sla->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_detail" data-field="x_sla" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sla" id="o<?= $Grid->RowIndex ?>_sla" value="<?= HtmlEncode($Grid->sla->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_sla" class="form-group">
<span<?= $Grid->sla->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sla->getDisplayValue($Grid->sla->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_sla" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sla" id="x<?= $Grid->RowIndex ?>_sla" value="<?= HtmlEncode($Grid->sla->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_sla">
<span<?= $Grid->sla->viewAttributes() ?>>
<?= $Grid->sla->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_sla" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_sla" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_sla" value="<?= HtmlEncode($Grid->sla->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_sla" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_sla" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_sla" value="<?= HtmlEncode($Grid->sla->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Grid->keterangan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_keterangan" class="form-group">
<textarea data-table="order_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_keterangan" class="form-group">
<textarea data-table="order_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order_detail" data-field="x_keterangan" data-hidden="1" name="forder_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" id="forder_detailgrid$x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<input type="hidden" data-table="order_detail" data-field="x_keterangan" data-hidden="1" name="forder_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" id="forder_detailgrid$o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
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
    <?php if ($Grid->idproduct->Visible) { // idproduct ?>
        <td data-name="idproduct">
<?php if (!$Grid->isConfirm()) { ?>
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
    <?php if ($Grid->tipe_sla->Visible) { // tipe_sla ?>
        <td data-name="tipe_sla">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_tipe_sla" class="form-group order_detail_tipe_sla">
<?php $Grid->tipe_sla->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_tipe_sla"
        name="x<?= $Grid->RowIndex ?>_tipe_sla"
        class="form-control ew-select<?= $Grid->tipe_sla->isInvalidClass() ?>"
        data-select2-id="order_detail_x<?= $Grid->RowIndex ?>_tipe_sla"
        data-table="order_detail"
        data-field="x_tipe_sla"
        data-value-separator="<?= $Grid->tipe_sla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipe_sla->getPlaceHolder()) ?>"
        <?= $Grid->tipe_sla->editAttributes() ?>>
        <?= $Grid->tipe_sla->selectOptionListHtml("x{$Grid->RowIndex}_tipe_sla") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipe_sla->getErrorMessage() ?></div>
<?= $Grid->tipe_sla->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipe_sla") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_detail_x<?= $Grid->RowIndex ?>_tipe_sla']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tipe_sla", selectId: "order_detail_x<?= $Grid->RowIndex ?>_tipe_sla", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.tipe_sla.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_tipe_sla" class="form-group order_detail_tipe_sla">
<span<?= $Grid->tipe_sla->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tipe_sla->getDisplayValue($Grid->tipe_sla->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_tipe_sla" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tipe_sla" id="x<?= $Grid->RowIndex ?>_tipe_sla" value="<?= HtmlEncode($Grid->tipe_sla->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_tipe_sla" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tipe_sla" id="o<?= $Grid->RowIndex ?>_tipe_sla" value="<?= HtmlEncode($Grid->tipe_sla->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sla->Visible) { // sla ?>
        <td data-name="sla">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_sla" class="form-group order_detail_sla">
<input type="<?= $Grid->sla->getInputTextType() ?>" data-table="order_detail" data-field="x_sla" name="x<?= $Grid->RowIndex ?>_sla" id="x<?= $Grid->RowIndex ?>_sla" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->sla->getPlaceHolder()) ?>" value="<?= $Grid->sla->EditValue ?>"<?= $Grid->sla->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sla->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_sla" class="form-group order_detail_sla">
<span<?= $Grid->sla->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sla->getDisplayValue($Grid->sla->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_sla" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sla" id="x<?= $Grid->RowIndex ?>_sla" value="<?= HtmlEncode($Grid->sla->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_sla" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sla" id="o<?= $Grid->RowIndex ?>_sla" value="<?= HtmlEncode($Grid->sla->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_detail_keterangan" class="form-group order_detail_keterangan">
<textarea data-table="order_detail" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->keterangan->getPlaceHolder()) ?>"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_detail_keterangan" class="form-group order_detail_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->ViewValue ?></span>
</span>
<input type="hidden" data-table="order_detail" data-field="x_keterangan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_detail" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
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
