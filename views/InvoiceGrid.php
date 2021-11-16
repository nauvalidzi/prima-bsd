<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("InvoiceGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var finvoicegrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    finvoicegrid = new ew.Form("finvoicegrid", "grid");
    finvoicegrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "invoice")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.invoice)
        ew.vars.tables.invoice = currentTable;
    finvoicegrid.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["tglinvoice", [fields.tglinvoice.visible && fields.tglinvoice.required ? ew.Validators.required(fields.tglinvoice.caption) : null, ew.Validators.datetime(0)], fields.tglinvoice.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["idorder", [fields.idorder.visible && fields.idorder.required ? ew.Validators.required(fields.idorder.caption) : null], fields.idorder.isInvalid],
        ["totaltagihan", [fields.totaltagihan.visible && fields.totaltagihan.required ? ew.Validators.required(fields.totaltagihan.caption) : null, ew.Validators.integer], fields.totaltagihan.isInvalid],
        ["sisabayar", [fields.sisabayar.visible && fields.sisabayar.required ? ew.Validators.required(fields.sisabayar.caption) : null, ew.Validators.integer], fields.sisabayar.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = finvoicegrid,
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
    finvoicegrid.validate = function () {
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
    finvoicegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "kode", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglinvoice", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idcustomer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idorder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "totaltagihan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisabayar", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    finvoicegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvoicegrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    finvoicegrid.lists.idcustomer = <?= $Grid->idcustomer->toClientList($Grid) ?>;
    finvoicegrid.lists.idorder = <?= $Grid->idorder->toClientList($Grid) ?>;
    loadjs.done("finvoicegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> invoice">
<div id="finvoicegrid" class="ew-form ew-list-form form-inline">
<div id="gmp_invoice" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_invoicegrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="kode" class="<?= $Grid->kode->headerCellClass() ?>"><div id="elh_invoice_kode" class="invoice_kode"><?= $Grid->renderSort($Grid->kode) ?></div></th>
<?php } ?>
<?php if ($Grid->tglinvoice->Visible) { // tglinvoice ?>
        <th data-name="tglinvoice" class="<?= $Grid->tglinvoice->headerCellClass() ?>"><div id="elh_invoice_tglinvoice" class="invoice_tglinvoice"><?= $Grid->renderSort($Grid->tglinvoice) ?></div></th>
<?php } ?>
<?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Grid->idcustomer->headerCellClass() ?>"><div id="elh_invoice_idcustomer" class="invoice_idcustomer"><?= $Grid->renderSort($Grid->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->idorder->Visible) { // idorder ?>
        <th data-name="idorder" class="<?= $Grid->idorder->headerCellClass() ?>"><div id="elh_invoice_idorder" class="invoice_idorder"><?= $Grid->renderSort($Grid->idorder) ?></div></th>
<?php } ?>
<?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <th data-name="totaltagihan" class="<?= $Grid->totaltagihan->headerCellClass() ?>"><div id="elh_invoice_totaltagihan" class="invoice_totaltagihan"><?= $Grid->renderSort($Grid->totaltagihan) ?></div></th>
<?php } ?>
<?php if ($Grid->sisabayar->Visible) { // sisabayar ?>
        <th data-name="sisabayar" class="<?= $Grid->sisabayar->headerCellClass() ?>"><div id="elh_invoice_sisabayar" class="invoice_sisabayar"><?= $Grid->renderSort($Grid->sisabayar) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_invoice", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_invoice_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="invoice" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_kode" class="form-group">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<?= $Grid->kode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice" data-field="x_kode" data-hidden="1" name="finvoicegrid$x<?= $Grid->RowIndex ?>_kode" id="finvoicegrid$x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<input type="hidden" data-table="invoice" data-field="x_kode" data-hidden="1" name="finvoicegrid$o<?= $Grid->RowIndex ?>_kode" id="finvoicegrid$o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglinvoice->Visible) { // tglinvoice ?>
        <td data-name="tglinvoice" <?= $Grid->tglinvoice->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_tglinvoice" class="form-group">
<input type="<?= $Grid->tglinvoice->getInputTextType() ?>" data-table="invoice" data-field="x_tglinvoice" name="x<?= $Grid->RowIndex ?>_tglinvoice" id="x<?= $Grid->RowIndex ?>_tglinvoice" placeholder="<?= HtmlEncode($Grid->tglinvoice->getPlaceHolder()) ?>" value="<?= $Grid->tglinvoice->EditValue ?>"<?= $Grid->tglinvoice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglinvoice->getErrorMessage() ?></div>
<?php if (!$Grid->tglinvoice->ReadOnly && !$Grid->tglinvoice->Disabled && !isset($Grid->tglinvoice->EditAttrs["readonly"]) && !isset($Grid->tglinvoice->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvoicegrid", "datetimepicker"], function() {
    ew.createDateTimePicker("finvoicegrid", "x<?= $Grid->RowIndex ?>_tglinvoice", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="invoice" data-field="x_tglinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglinvoice" id="o<?= $Grid->RowIndex ?>_tglinvoice" value="<?= HtmlEncode($Grid->tglinvoice->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_tglinvoice" class="form-group">
<input type="<?= $Grid->tglinvoice->getInputTextType() ?>" data-table="invoice" data-field="x_tglinvoice" name="x<?= $Grid->RowIndex ?>_tglinvoice" id="x<?= $Grid->RowIndex ?>_tglinvoice" placeholder="<?= HtmlEncode($Grid->tglinvoice->getPlaceHolder()) ?>" value="<?= $Grid->tglinvoice->EditValue ?>"<?= $Grid->tglinvoice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglinvoice->getErrorMessage() ?></div>
<?php if (!$Grid->tglinvoice->ReadOnly && !$Grid->tglinvoice->Disabled && !isset($Grid->tglinvoice->EditAttrs["readonly"]) && !isset($Grid->tglinvoice->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvoicegrid", "datetimepicker"], function() {
    ew.createDateTimePicker("finvoicegrid", "x<?= $Grid->RowIndex ?>_tglinvoice", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_tglinvoice">
<span<?= $Grid->tglinvoice->viewAttributes() ?>>
<?= $Grid->tglinvoice->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice" data-field="x_tglinvoice" data-hidden="1" name="finvoicegrid$x<?= $Grid->RowIndex ?>_tglinvoice" id="finvoicegrid$x<?= $Grid->RowIndex ?>_tglinvoice" value="<?= HtmlEncode($Grid->tglinvoice->FormValue) ?>">
<input type="hidden" data-table="invoice" data-field="x_tglinvoice" data-hidden="1" name="finvoicegrid$o<?= $Grid->RowIndex ?>_tglinvoice" id="finvoicegrid$o<?= $Grid->RowIndex ?>_tglinvoice" value="<?= HtmlEncode($Grid->tglinvoice->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Grid->idcustomer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idcustomer" class="form-group">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idcustomer" class="form-group">
<?php $Grid->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="invoice_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="invoice"
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
    var el = document.querySelector("select[data-select2-id='invoice_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "invoice_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="invoice" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idcustomer" class="form-group">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idcustomer" class="form-group">
<?php $Grid->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="invoice_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="invoice"
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
    var el = document.querySelector("select[data-select2-id='invoice_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "invoice_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<?= $Grid->idcustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice" data-field="x_idcustomer" data-hidden="1" name="finvoicegrid$x<?= $Grid->RowIndex ?>_idcustomer" id="finvoicegrid$x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<input type="hidden" data-table="invoice" data-field="x_idcustomer" data-hidden="1" name="finvoicegrid$o<?= $Grid->RowIndex ?>_idcustomer" id="finvoicegrid$o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idorder->Visible) { // idorder ?>
        <td data-name="idorder" <?= $Grid->idorder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idorder" class="form-group">
<?php $Grid->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="invoice_x<?= $Grid->RowIndex ?>_idorder"
        data-table="invoice"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "invoice_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="invoice" data-field="x_idorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder" id="o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idorder" class="form-group">
<?php $Grid->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="invoice_x<?= $Grid->RowIndex ?>_idorder"
        data-table="invoice"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "invoice_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_idorder">
<span<?= $Grid->idorder->viewAttributes() ?>>
<?php if (!EmptyString($Grid->idorder->getViewValue()) && $Grid->idorder->linkAttributes() != "") { ?>
<a<?= $Grid->idorder->linkAttributes() ?>><?= $Grid->idorder->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->idorder->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice" data-field="x_idorder" data-hidden="1" name="finvoicegrid$x<?= $Grid->RowIndex ?>_idorder" id="finvoicegrid$x<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->FormValue) ?>">
<input type="hidden" data-table="invoice" data-field="x_idorder" data-hidden="1" name="finvoicegrid$o<?= $Grid->RowIndex ?>_idorder" id="finvoicegrid$o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan" <?= $Grid->totaltagihan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_totaltagihan" class="form-group">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="invoice" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice" data-field="x_totaltagihan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totaltagihan" id="o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_totaltagihan" class="form-group">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="invoice" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_totaltagihan">
<span<?= $Grid->totaltagihan->viewAttributes() ?>>
<?= $Grid->totaltagihan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice" data-field="x_totaltagihan" data-hidden="1" name="finvoicegrid$x<?= $Grid->RowIndex ?>_totaltagihan" id="finvoicegrid$x<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->FormValue) ?>">
<input type="hidden" data-table="invoice" data-field="x_totaltagihan" data-hidden="1" name="finvoicegrid$o<?= $Grid->RowIndex ?>_totaltagihan" id="finvoicegrid$o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisabayar->Visible) { // sisabayar ?>
        <td data-name="sisabayar" <?= $Grid->sisabayar->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_sisabayar" class="form-group">
<input type="<?= $Grid->sisabayar->getInputTextType() ?>" data-table="invoice" data-field="x_sisabayar" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" size="30" placeholder="<?= HtmlEncode($Grid->sisabayar->getPlaceHolder()) ?>" value="<?= $Grid->sisabayar->EditValue ?>"<?= $Grid->sisabayar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisabayar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice" data-field="x_sisabayar" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisabayar" id="o<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_sisabayar" class="form-group">
<input type="<?= $Grid->sisabayar->getInputTextType() ?>" data-table="invoice" data-field="x_sisabayar" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" size="30" placeholder="<?= HtmlEncode($Grid->sisabayar->getPlaceHolder()) ?>" value="<?= $Grid->sisabayar->EditValue ?>"<?= $Grid->sisabayar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisabayar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_sisabayar">
<span<?= $Grid->sisabayar->viewAttributes() ?>>
<?= $Grid->sisabayar->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice" data-field="x_sisabayar" data-hidden="1" name="finvoicegrid$x<?= $Grid->RowIndex ?>_sisabayar" id="finvoicegrid$x<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->FormValue) ?>">
<input type="hidden" data-table="invoice" data-field="x_sisabayar" data-hidden="1" name="finvoicegrid$o<?= $Grid->RowIndex ?>_sisabayar" id="finvoicegrid$o<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->OldValue) ?>">
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
loadjs.ready(["finvoicegrid","load"], function () {
    finvoicegrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_invoice", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_invoice_kode" class="form-group invoice_kode">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="invoice" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_kode" class="form-group invoice_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglinvoice->Visible) { // tglinvoice ?>
        <td data-name="tglinvoice">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_tglinvoice" class="form-group invoice_tglinvoice">
<input type="<?= $Grid->tglinvoice->getInputTextType() ?>" data-table="invoice" data-field="x_tglinvoice" name="x<?= $Grid->RowIndex ?>_tglinvoice" id="x<?= $Grid->RowIndex ?>_tglinvoice" placeholder="<?= HtmlEncode($Grid->tglinvoice->getPlaceHolder()) ?>" value="<?= $Grid->tglinvoice->EditValue ?>"<?= $Grid->tglinvoice->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglinvoice->getErrorMessage() ?></div>
<?php if (!$Grid->tglinvoice->ReadOnly && !$Grid->tglinvoice->Disabled && !isset($Grid->tglinvoice->EditAttrs["readonly"]) && !isset($Grid->tglinvoice->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvoicegrid", "datetimepicker"], function() {
    ew.createDateTimePicker("finvoicegrid", "x<?= $Grid->RowIndex ?>_tglinvoice", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_tglinvoice" class="form-group invoice_tglinvoice">
<span<?= $Grid->tglinvoice->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglinvoice->getDisplayValue($Grid->tglinvoice->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice" data-field="x_tglinvoice" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglinvoice" id="x<?= $Grid->RowIndex ?>_tglinvoice" value="<?= HtmlEncode($Grid->tglinvoice->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice" data-field="x_tglinvoice" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglinvoice" id="o<?= $Grid->RowIndex ?>_tglinvoice" value="<?= HtmlEncode($Grid->tglinvoice->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idcustomer->getSessionValue() != "") { ?>
<span id="el$rowindex$_invoice_idcustomer" class="form-group invoice_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idcustomer" name="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_invoice_idcustomer" class="form-group invoice_idcustomer">
<?php $Grid->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="invoice_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="invoice"
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
    var el = document.querySelector("select[data-select2-id='invoice_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "invoice_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_invoice_idcustomer" class="form-group invoice_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idorder->Visible) { // idorder ?>
        <td data-name="idorder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_idorder" class="form-group invoice_idorder">
<?php $Grid->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder"
        name="x<?= $Grid->RowIndex ?>_idorder"
        class="form-control ew-select<?= $Grid->idorder->isInvalidClass() ?>"
        data-select2-id="invoice_x<?= $Grid->RowIndex ?>_idorder"
        data-table="invoice"
        data-field="x_idorder"
        data-value-separator="<?= $Grid->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder->getPlaceHolder()) ?>"
        <?= $Grid->idorder->editAttributes() ?>>
        <?= $Grid->idorder->selectOptionListHtml("x{$Grid->RowIndex}_idorder") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder->getErrorMessage() ?></div>
<?= $Grid->idorder->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_x<?= $Grid->RowIndex ?>_idorder']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder", selectId: "invoice_x<?= $Grid->RowIndex ?>_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_idorder" class="form-group invoice_idorder">
<span<?= $Grid->idorder->viewAttributes() ?>>
<?php if (!EmptyString($Grid->idorder->ViewValue) && $Grid->idorder->linkAttributes() != "") { ?>
<a<?= $Grid->idorder->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idorder->getDisplayValue($Grid->idorder->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idorder->getDisplayValue($Grid->idorder->ViewValue))) ?>">
<?php } ?>
</span>
</span>
<input type="hidden" data-table="invoice" data-field="x_idorder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idorder" id="x<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice" data-field="x_idorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder" id="o<?= $Grid->RowIndex ?>_idorder" value="<?= HtmlEncode($Grid->idorder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_totaltagihan" class="form-group invoice_totaltagihan">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="invoice" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_totaltagihan" class="form-group invoice_totaltagihan">
<span<?= $Grid->totaltagihan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->totaltagihan->getDisplayValue($Grid->totaltagihan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice" data-field="x_totaltagihan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice" data-field="x_totaltagihan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totaltagihan" id="o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisabayar->Visible) { // sisabayar ?>
        <td data-name="sisabayar">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_sisabayar" class="form-group invoice_sisabayar">
<input type="<?= $Grid->sisabayar->getInputTextType() ?>" data-table="invoice" data-field="x_sisabayar" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" size="30" placeholder="<?= HtmlEncode($Grid->sisabayar->getPlaceHolder()) ?>" value="<?= $Grid->sisabayar->EditValue ?>"<?= $Grid->sisabayar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisabayar->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_sisabayar" class="form-group invoice_sisabayar">
<span<?= $Grid->sisabayar->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisabayar->getDisplayValue($Grid->sisabayar->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice" data-field="x_sisabayar" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisabayar" id="x<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice" data-field="x_sisabayar" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisabayar" id="o<?= $Grid->RowIndex ?>_sisabayar" value="<?= HtmlEncode($Grid->sisabayar->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["finvoicegrid","load"], function() {
    finvoicegrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="finvoicegrid">
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
    ew.addEventHandlers("invoice");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $(".ew-detail-add-group").html("Create Invoice");
});
</script>
<?php if (!$Grid->isExport()) { ?>
<script>
loadjs.ready("fixedheadertable", function () {
    ew.fixedHeaderTable({
        delay: 0,
        container: "gmp_invoice",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
