<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("OrderGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fordergrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fordergrid = new ew.Form("fordergrid", "grid");
    fordergrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "order")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.order)
        ew.vars.tables.order = currentTable;
    fordergrid.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null], fields.tanggal.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null], fields.idbrand.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fordergrid,
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
    fordergrid.validate = function () {
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
    fordergrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "kode", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tanggal", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idpegawai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idcustomer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idbrand", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fordergrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fordergrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fordergrid.lists.idpegawai = <?= $Grid->idpegawai->toClientList($Grid) ?>;
    fordergrid.lists.idcustomer = <?= $Grid->idcustomer->toClientList($Grid) ?>;
    fordergrid.lists.idbrand = <?= $Grid->idbrand->toClientList($Grid) ?>;
    loadjs.done("fordergrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> order">
<div id="fordergrid" class="ew-form ew-list-form form-inline">
<div id="gmp_order" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_ordergrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->kode->Visible) { // kode ?>
        <th data-name="kode" class="<?= $Grid->kode->headerCellClass() ?>"><div id="elh_order_kode" class="order_kode"><?= $Grid->renderSort($Grid->kode) ?></div></th>
<?php } ?>
<?php if ($Grid->tanggal->Visible) { // tanggal ?>
        <th data-name="tanggal" class="<?= $Grid->tanggal->headerCellClass() ?>"><div id="elh_order_tanggal" class="order_tanggal"><?= $Grid->renderSort($Grid->tanggal) ?></div></th>
<?php } ?>
<?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Grid->idpegawai->headerCellClass() ?>"><div id="elh_order_idpegawai" class="order_idpegawai"><?= $Grid->renderSort($Grid->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Grid->idcustomer->headerCellClass() ?>"><div id="elh_order_idcustomer" class="order_idcustomer"><?= $Grid->renderSort($Grid->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->idbrand->Visible) { // idbrand ?>
        <th data-name="idbrand" class="<?= $Grid->idbrand->headerCellClass() ?>"><div id="elh_order_idbrand" class="order_idbrand"><?= $Grid->renderSort($Grid->idbrand) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_order_status" class="order_status"><?= $Grid->renderSort($Grid->status) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_order", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode" <?= $Grid->kode->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="order" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_kode" class="form-group">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<?= $Grid->kode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order" data-field="x_kode" data-hidden="1" name="fordergrid$x<?= $Grid->RowIndex ?>_kode" id="fordergrid$x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<input type="hidden" data-table="order" data-field="x_kode" data-hidden="1" name="fordergrid$o<?= $Grid->RowIndex ?>_kode" id="fordergrid$o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tanggal->Visible) { // tanggal ?>
        <td data-name="tanggal" <?= $Grid->tanggal->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_tanggal" class="form-group">
<input type="<?= $Grid->tanggal->getInputTextType() ?>" data-table="order" data-field="x_tanggal" data-format="7" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" placeholder="<?= HtmlEncode($Grid->tanggal->getPlaceHolder()) ?>" value="<?= $Grid->tanggal->EditValue ?>"<?= $Grid->tanggal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order" data-field="x_tanggal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal" id="o<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_tanggal" class="form-group">
<span<?= $Grid->tanggal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal->getDisplayValue($Grid->tanggal->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_tanggal" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_tanggal">
<span<?= $Grid->tanggal->viewAttributes() ?>>
<?= $Grid->tanggal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order" data-field="x_tanggal" data-hidden="1" name="fordergrid$x<?= $Grid->RowIndex ?>_tanggal" id="fordergrid$x<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->FormValue) ?>">
<input type="hidden" data-table="order" data-field="x_tanggal" data-hidden="1" name="fordergrid$o<?= $Grid->RowIndex ?>_tanggal" id="fordergrid$o<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Grid->idpegawai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_idpegawai" class="form-group">
<?php $Grid->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="order_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="order"
        data-field="x_idpegawai"
        data-value-separator="<?= $Grid->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idpegawai->getPlaceHolder()) ?>"
        <?= $Grid->idpegawai->editAttributes() ?>>
        <?= $Grid->idpegawai->selectOptionListHtml("x{$Grid->RowIndex}_idpegawai") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idpegawai->getErrorMessage() ?></div>
<?= $Grid->idpegawai->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "order_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="order" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_idpegawai" class="form-group">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_idpegawai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idpegawai" id="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<?= $Grid->idpegawai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order" data-field="x_idpegawai" data-hidden="1" name="fordergrid$x<?= $Grid->RowIndex ?>_idpegawai" id="fordergrid$x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<input type="hidden" data-table="order" data-field="x_idpegawai" data-hidden="1" name="fordergrid$o<?= $Grid->RowIndex ?>_idpegawai" id="fordergrid$o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Grid->idcustomer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_order_idcustomer" class="form-group">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_order_idcustomer" class="form-group">
<?php $Grid->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="order_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="order"
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
    var el = document.querySelector("select[data-select2-id='order_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "order_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="order" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_idcustomer" class="form-group">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<?= $Grid->idcustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order" data-field="x_idcustomer" data-hidden="1" name="fordergrid$x<?= $Grid->RowIndex ?>_idcustomer" id="fordergrid$x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<input type="hidden" data-table="order" data-field="x_idcustomer" data-hidden="1" name="fordergrid$o<?= $Grid->RowIndex ?>_idcustomer" id="fordergrid$o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idbrand->Visible) { // idbrand ?>
        <td data-name="idbrand" <?= $Grid->idbrand->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_idbrand" class="form-group">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="order_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="order"
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
    var el = document.querySelector("select[data-select2-id='order_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "order_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="order" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_idbrand" class="form-group">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_idbrand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idbrand" id="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<?= $Grid->idbrand->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order" data-field="x_idbrand" data-hidden="1" name="fordergrid$x<?= $Grid->RowIndex ?>_idbrand" id="fordergrid$x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<input type="hidden" data-table="order" data-field="x_idbrand" data-hidden="1" name="fordergrid$o<?= $Grid->RowIndex ?>_idbrand" id="fordergrid$o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status" <?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_order_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="order" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="order" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_order_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="order" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_order_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="order" data-field="x_status" data-hidden="1" name="fordergrid$x<?= $Grid->RowIndex ?>_status" id="fordergrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="order" data-field="x_status" data-hidden="1" name="fordergrid$o<?= $Grid->RowIndex ?>_status" id="fordergrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
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
loadjs.ready(["fordergrid","load"], function () {
    fordergrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_order", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_kode" class="form-group order_kode">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="order" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_kode" class="form-group order_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tanggal->Visible) { // tanggal ?>
        <td data-name="tanggal">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_tanggal" class="form-group order_tanggal">
<input type="<?= $Grid->tanggal->getInputTextType() ?>" data-table="order" data-field="x_tanggal" data-format="7" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" placeholder="<?= HtmlEncode($Grid->tanggal->getPlaceHolder()) ?>" value="<?= $Grid->tanggal->EditValue ?>"<?= $Grid->tanggal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tanggal->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_tanggal" class="form-group order_tanggal">
<span<?= $Grid->tanggal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tanggal->getDisplayValue($Grid->tanggal->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_tanggal" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tanggal" id="x<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order" data-field="x_tanggal" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tanggal" id="o<?= $Grid->RowIndex ?>_tanggal" value="<?= HtmlEncode($Grid->tanggal->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_idpegawai" class="form-group order_idpegawai">
<?php $Grid->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="order_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="order"
        data-field="x_idpegawai"
        data-value-separator="<?= $Grid->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idpegawai->getPlaceHolder()) ?>"
        <?= $Grid->idpegawai->editAttributes() ?>>
        <?= $Grid->idpegawai->selectOptionListHtml("x{$Grid->RowIndex}_idpegawai") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idpegawai->getErrorMessage() ?></div>
<?= $Grid->idpegawai->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "order_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_idpegawai" class="form-group order_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_idpegawai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idpegawai" id="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el$rowindex$_order_idcustomer" class="form-group order_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_order_idcustomer" class="form-group order_idcustomer">
<?php $Grid->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="order_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="order"
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
    var el = document.querySelector("select[data-select2-id='order_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "order_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_order_idcustomer" class="form-group order_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idbrand->Visible) { // idbrand ?>
        <td data-name="idbrand">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_idbrand" class="form-group order_idbrand">
<?php $Grid->idbrand->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idbrand"
        name="x<?= $Grid->RowIndex ?>_idbrand"
        class="form-control ew-select<?= $Grid->idbrand->isInvalidClass() ?>"
        data-select2-id="order_x<?= $Grid->RowIndex ?>_idbrand"
        data-table="order"
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
    var el = document.querySelector("select[data-select2-id='order_x<?= $Grid->RowIndex ?>_idbrand']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idbrand", selectId: "order_x<?= $Grid->RowIndex ?>_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_idbrand" class="form-group order_idbrand">
<span<?= $Grid->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idbrand->getDisplayValue($Grid->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_idbrand" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idbrand" id="x<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order" data-field="x_idbrand" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idbrand" id="o<?= $Grid->RowIndex ?>_idbrand" value="<?= HtmlEncode($Grid->idbrand->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_order_status" class="form-group order_status">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="order" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_status" class="form-group order_status">
<span<?= $Grid->status->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status->getDisplayValue($Grid->status->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="order" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fordergrid","load"], function() {
    fordergrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fordergrid">
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
    ew.addEventHandlers("order");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    //loadjs.ready('jquery', function() {
    //	$('.ew-add-edit-option').hide();
    //});
    $('.ew-detail-add-group').html('Add Purchase Order');
    $('ul.pagination').addClass('pagination-sm');
    $(".ew-detail-option").append(`<div class="btn-group btn-group-sm ew-btn-group ml-1"><button type="button" class="btn btn-default btn-sm sync-orders" title="Synchronize Data Orders" data-toggle="modal" data-target="#modal-default" data-backdrop="static" data-keyboard="false"><i class="fas fa-sync-alt"></i></button></div>`);
        $('#modal-default .modal-header').hide();
        $('#modal-default .modal-dialog').addClass('modal-dialog-centered');
        $('#modal-default .modal-body').addClass('my-4');
        $('#modal-default .modal-body').html('<center><i class="fas fa-3x fa-sync fa-spin"></i></center>');
        $('#modal-default .modal-footer').hide();

        // setTimeout(
            $.get("api/sync-order-sip",(function(e){
                $('#modal-default').modal('hide');
                if (e.status !== false) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data has been synchronized!',
                    }).then(function() { 
                       location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error synchronizing from S.I.P!'
                    });
                }
            }))
        // , 1000);
    });
});
</script>
<?php if (!$Grid->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_order",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
