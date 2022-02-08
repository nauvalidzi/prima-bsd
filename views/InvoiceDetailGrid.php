<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("InvoiceDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var finvoice_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    finvoice_detailgrid = new ew.Form("finvoice_detailgrid", "grid");
    finvoice_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "invoice_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.invoice_detail)
        ew.vars.tables.invoice_detail = currentTable;
    finvoice_detailgrid.addFields([
        ["idorder_detail", [fields.idorder_detail.visible && fields.idorder_detail.required ? ew.Validators.required(fields.idorder_detail.caption) : null], fields.idorder_detail.isInvalid],
        ["jumlahorder", [fields.jumlahorder.visible && fields.jumlahorder.required ? ew.Validators.required(fields.jumlahorder.caption) : null, ew.Validators.integer], fields.jumlahorder.isInvalid],
        ["bonus", [fields.bonus.visible && fields.bonus.required ? ew.Validators.required(fields.bonus.caption) : null, ew.Validators.integer], fields.bonus.isInvalid],
        ["stockdo", [fields.stockdo.visible && fields.stockdo.required ? ew.Validators.required(fields.stockdo.caption) : null, ew.Validators.integer], fields.stockdo.isInvalid],
        ["jumlahkirim", [fields.jumlahkirim.visible && fields.jumlahkirim.required ? ew.Validators.required(fields.jumlahkirim.caption) : null, ew.Validators.integer], fields.jumlahkirim.isInvalid],
        ["jumlahbonus", [fields.jumlahbonus.visible && fields.jumlahbonus.required ? ew.Validators.required(fields.jumlahbonus.caption) : null, ew.Validators.integer], fields.jumlahbonus.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["totalnondiskon", [fields.totalnondiskon.visible && fields.totalnondiskon.required ? ew.Validators.required(fields.totalnondiskon.caption) : null, ew.Validators.integer], fields.totalnondiskon.isInvalid],
        ["diskonpayment", [fields.diskonpayment.visible && fields.diskonpayment.required ? ew.Validators.required(fields.diskonpayment.caption) : null, ew.Validators.float], fields.diskonpayment.isInvalid],
        ["bbpersen", [fields.bbpersen.visible && fields.bbpersen.required ? ew.Validators.required(fields.bbpersen.caption) : null, ew.Validators.float], fields.bbpersen.isInvalid],
        ["totaltagihan", [fields.totaltagihan.visible && fields.totaltagihan.required ? ew.Validators.required(fields.totaltagihan.caption) : null, ew.Validators.integer], fields.totaltagihan.isInvalid],
        ["blackbonus", [fields.blackbonus.visible && fields.blackbonus.required ? ew.Validators.required(fields.blackbonus.caption) : null, ew.Validators.integer], fields.blackbonus.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = finvoice_detailgrid,
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
    finvoice_detailgrid.validate = function () {
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
    finvoice_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idorder_detail", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlahorder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bonus", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "stockdo", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlahkirim", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlahbonus", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "harga", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "totalnondiskon", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "diskonpayment", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bbpersen", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "totaltagihan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "blackbonus", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    finvoice_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvoice_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    finvoice_detailgrid.lists.idorder_detail = <?= $Grid->idorder_detail->toClientList($Grid) ?>;
    loadjs.done("finvoice_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> invoice_detail">
<div id="finvoice_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_invoice_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_invoice_detailgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idorder_detail->Visible) { // idorder_detail ?>
        <th data-name="idorder_detail" class="<?= $Grid->idorder_detail->headerCellClass() ?>"><div id="elh_invoice_detail_idorder_detail" class="invoice_detail_idorder_detail"><?= $Grid->renderSort($Grid->idorder_detail) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlahorder->Visible) { // jumlahorder ?>
        <th data-name="jumlahorder" class="<?= $Grid->jumlahorder->headerCellClass() ?>"><div id="elh_invoice_detail_jumlahorder" class="invoice_detail_jumlahorder"><?= $Grid->renderSort($Grid->jumlahorder) ?></div></th>
<?php } ?>
<?php if ($Grid->bonus->Visible) { // bonus ?>
        <th data-name="bonus" class="<?= $Grid->bonus->headerCellClass() ?>"><div id="elh_invoice_detail_bonus" class="invoice_detail_bonus"><?= $Grid->renderSort($Grid->bonus) ?></div></th>
<?php } ?>
<?php if ($Grid->stockdo->Visible) { // stockdo ?>
        <th data-name="stockdo" class="<?= $Grid->stockdo->headerCellClass() ?>"><div id="elh_invoice_detail_stockdo" class="invoice_detail_stockdo"><?= $Grid->renderSort($Grid->stockdo) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <th data-name="jumlahkirim" class="<?= $Grid->jumlahkirim->headerCellClass() ?>"><div id="elh_invoice_detail_jumlahkirim" class="invoice_detail_jumlahkirim"><?= $Grid->renderSort($Grid->jumlahkirim) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlahbonus->Visible) { // jumlahbonus ?>
        <th data-name="jumlahbonus" class="<?= $Grid->jumlahbonus->headerCellClass() ?>"><div id="elh_invoice_detail_jumlahbonus" class="invoice_detail_jumlahbonus"><?= $Grid->renderSort($Grid->jumlahbonus) ?></div></th>
<?php } ?>
<?php if ($Grid->harga->Visible) { // harga ?>
        <th data-name="harga" class="<?= $Grid->harga->headerCellClass() ?>"><div id="elh_invoice_detail_harga" class="invoice_detail_harga"><?= $Grid->renderSort($Grid->harga) ?></div></th>
<?php } ?>
<?php if ($Grid->totalnondiskon->Visible) { // totalnondiskon ?>
        <th data-name="totalnondiskon" class="<?= $Grid->totalnondiskon->headerCellClass() ?>"><div id="elh_invoice_detail_totalnondiskon" class="invoice_detail_totalnondiskon"><?= $Grid->renderSort($Grid->totalnondiskon) ?></div></th>
<?php } ?>
<?php if ($Grid->diskonpayment->Visible) { // diskonpayment ?>
        <th data-name="diskonpayment" class="<?= $Grid->diskonpayment->headerCellClass() ?>"><div id="elh_invoice_detail_diskonpayment" class="invoice_detail_diskonpayment"><?= $Grid->renderSort($Grid->diskonpayment) ?></div></th>
<?php } ?>
<?php if ($Grid->bbpersen->Visible) { // bbpersen ?>
        <th data-name="bbpersen" class="<?= $Grid->bbpersen->headerCellClass() ?>"><div id="elh_invoice_detail_bbpersen" class="invoice_detail_bbpersen"><?= $Grid->renderSort($Grid->bbpersen) ?></div></th>
<?php } ?>
<?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <th data-name="totaltagihan" class="<?= $Grid->totaltagihan->headerCellClass() ?>"><div id="elh_invoice_detail_totaltagihan" class="invoice_detail_totaltagihan"><?= $Grid->renderSort($Grid->totaltagihan) ?></div></th>
<?php } ?>
<?php if ($Grid->blackbonus->Visible) { // blackbonus ?>
        <th data-name="blackbonus" class="<?= $Grid->blackbonus->headerCellClass() ?>"><div id="elh_invoice_detail_blackbonus" class="invoice_detail_blackbonus"><?= $Grid->renderSort($Grid->blackbonus) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_invoice_detail", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idorder_detail->Visible) { // idorder_detail ?>
        <td data-name="idorder_detail" <?= $Grid->idorder_detail->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_idorder_detail" class="form-group">
<?php $Grid->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder_detail"
        name="x<?= $Grid->RowIndex ?>_idorder_detail"
        class="form-control ew-select<?= $Grid->idorder_detail->isInvalidClass() ?>"
        data-select2-id="invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail"
        data-table="invoice_detail"
        data-field="x_idorder_detail"
        data-value-separator="<?= $Grid->idorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idorder_detail->editAttributes() ?>>
        <?= $Grid->idorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder_detail->getErrorMessage() ?></div>
<?= $Grid->idorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder_detail", selectId: "invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_idorder_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder_detail" id="o<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_idorder_detail" class="form-group">
<?php $Grid->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder_detail"
        name="x<?= $Grid->RowIndex ?>_idorder_detail"
        class="form-control ew-select<?= $Grid->idorder_detail->isInvalidClass() ?>"
        data-select2-id="invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail"
        data-table="invoice_detail"
        data-field="x_idorder_detail"
        data-value-separator="<?= $Grid->idorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idorder_detail->editAttributes() ?>>
        <?= $Grid->idorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder_detail->getErrorMessage() ?></div>
<?= $Grid->idorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder_detail", selectId: "invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_idorder_detail">
<span<?= $Grid->idorder_detail->viewAttributes() ?>>
<?= $Grid->idorder_detail->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_idorder_detail" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_idorder_detail" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_idorder_detail" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_idorder_detail" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlahorder->Visible) { // jumlahorder ?>
        <td data-name="jumlahorder" <?= $Grid->jumlahorder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahorder" class="form-group">
<input type="<?= $Grid->jumlahorder->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahorder" name="x<?= $Grid->RowIndex ?>_jumlahorder" id="x<?= $Grid->RowIndex ?>_jumlahorder" size="30" placeholder="<?= HtmlEncode($Grid->jumlahorder->getPlaceHolder()) ?>" value="<?= $Grid->jumlahorder->EditValue ?>"<?= $Grid->jumlahorder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahorder->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahorder" id="o<?= $Grid->RowIndex ?>_jumlahorder" value="<?= HtmlEncode($Grid->jumlahorder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahorder" class="form-group">
<input type="<?= $Grid->jumlahorder->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahorder" name="x<?= $Grid->RowIndex ?>_jumlahorder" id="x<?= $Grid->RowIndex ?>_jumlahorder" size="30" placeholder="<?= HtmlEncode($Grid->jumlahorder->getPlaceHolder()) ?>" value="<?= $Grid->jumlahorder->EditValue ?>"<?= $Grid->jumlahorder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahorder->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahorder">
<span<?= $Grid->jumlahorder->viewAttributes() ?>>
<?= $Grid->jumlahorder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahorder" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_jumlahorder" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_jumlahorder" value="<?= HtmlEncode($Grid->jumlahorder->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahorder" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_jumlahorder" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_jumlahorder" value="<?= HtmlEncode($Grid->jumlahorder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bonus->Visible) { // bonus ?>
        <td data-name="bonus" <?= $Grid->bonus->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_bonus" class="form-group">
<input type="<?= $Grid->bonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bonus" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" size="30" placeholder="<?= HtmlEncode($Grid->bonus->getPlaceHolder()) ?>" value="<?= $Grid->bonus->EditValue ?>"<?= $Grid->bonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bonus->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_bonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bonus" id="o<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_bonus" class="form-group">
<input type="<?= $Grid->bonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bonus" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" size="30" placeholder="<?= HtmlEncode($Grid->bonus->getPlaceHolder()) ?>" value="<?= $Grid->bonus->EditValue ?>"<?= $Grid->bonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bonus->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_bonus">
<span<?= $Grid->bonus->viewAttributes() ?>>
<?= $Grid->bonus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_bonus" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_bonus" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_bonus" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_bonus" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->stockdo->Visible) { // stockdo ?>
        <td data-name="stockdo" <?= $Grid->stockdo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_stockdo" class="form-group">
<input type="<?= $Grid->stockdo->getInputTextType() ?>" data-table="invoice_detail" data-field="x_stockdo" name="x<?= $Grid->RowIndex ?>_stockdo" id="x<?= $Grid->RowIndex ?>_stockdo" size="30" placeholder="<?= HtmlEncode($Grid->stockdo->getPlaceHolder()) ?>" value="<?= $Grid->stockdo->EditValue ?>"<?= $Grid->stockdo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->stockdo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_stockdo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_stockdo" id="o<?= $Grid->RowIndex ?>_stockdo" value="<?= HtmlEncode($Grid->stockdo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_stockdo" class="form-group">
<input type="<?= $Grid->stockdo->getInputTextType() ?>" data-table="invoice_detail" data-field="x_stockdo" name="x<?= $Grid->RowIndex ?>_stockdo" id="x<?= $Grid->RowIndex ?>_stockdo" size="30" placeholder="<?= HtmlEncode($Grid->stockdo->getPlaceHolder()) ?>" value="<?= $Grid->stockdo->EditValue ?>"<?= $Grid->stockdo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->stockdo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_stockdo">
<span<?= $Grid->stockdo->viewAttributes() ?>>
<?= $Grid->stockdo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_stockdo" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_stockdo" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_stockdo" value="<?= HtmlEncode($Grid->stockdo->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_stockdo" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_stockdo" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_stockdo" value="<?= HtmlEncode($Grid->stockdo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim" <?= $Grid->jumlahkirim->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahkirim" class="form-group">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahkirim" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahkirim" id="o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahkirim" class="form-group">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahkirim">
<span<?= $Grid->jumlahkirim->viewAttributes() ?>>
<?= $Grid->jumlahkirim->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahkirim" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_jumlahkirim" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahkirim" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_jumlahkirim" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlahbonus->Visible) { // jumlahbonus ?>
        <td data-name="jumlahbonus" <?= $Grid->jumlahbonus->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahbonus" class="form-group">
<input type="<?= $Grid->jumlahbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahbonus" name="x<?= $Grid->RowIndex ?>_jumlahbonus" id="x<?= $Grid->RowIndex ?>_jumlahbonus" size="30" placeholder="<?= HtmlEncode($Grid->jumlahbonus->getPlaceHolder()) ?>" value="<?= $Grid->jumlahbonus->EditValue ?>"<?= $Grid->jumlahbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahbonus->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahbonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahbonus" id="o<?= $Grid->RowIndex ?>_jumlahbonus" value="<?= HtmlEncode($Grid->jumlahbonus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahbonus" class="form-group">
<input type="<?= $Grid->jumlahbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahbonus" name="x<?= $Grid->RowIndex ?>_jumlahbonus" id="x<?= $Grid->RowIndex ?>_jumlahbonus" size="30" placeholder="<?= HtmlEncode($Grid->jumlahbonus->getPlaceHolder()) ?>" value="<?= $Grid->jumlahbonus->EditValue ?>"<?= $Grid->jumlahbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahbonus->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_jumlahbonus">
<span<?= $Grid->jumlahbonus->viewAttributes() ?>>
<?= $Grid->jumlahbonus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahbonus" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_jumlahbonus" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_jumlahbonus" value="<?= HtmlEncode($Grid->jumlahbonus->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahbonus" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_jumlahbonus" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_jumlahbonus" value="<?= HtmlEncode($Grid->jumlahbonus->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->harga->Visible) { // harga ?>
        <td data-name="harga" <?= $Grid->harga->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_harga" class="form-group">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="invoice_detail" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_harga" data-hidden="1" name="o<?= $Grid->RowIndex ?>_harga" id="o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_harga" class="form-group">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="invoice_detail" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_harga">
<span<?= $Grid->harga->viewAttributes() ?>>
<?= $Grid->harga->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_harga" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_harga" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_harga" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_harga" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->totalnondiskon->Visible) { // totalnondiskon ?>
        <td data-name="totalnondiskon" <?= $Grid->totalnondiskon->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_totalnondiskon" class="form-group">
<input type="<?= $Grid->totalnondiskon->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totalnondiskon" name="x<?= $Grid->RowIndex ?>_totalnondiskon" id="x<?= $Grid->RowIndex ?>_totalnondiskon" size="30" placeholder="<?= HtmlEncode($Grid->totalnondiskon->getPlaceHolder()) ?>" value="<?= $Grid->totalnondiskon->EditValue ?>"<?= $Grid->totalnondiskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totalnondiskon->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_totalnondiskon" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totalnondiskon" id="o<?= $Grid->RowIndex ?>_totalnondiskon" value="<?= HtmlEncode($Grid->totalnondiskon->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_totalnondiskon" class="form-group">
<input type="<?= $Grid->totalnondiskon->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totalnondiskon" name="x<?= $Grid->RowIndex ?>_totalnondiskon" id="x<?= $Grid->RowIndex ?>_totalnondiskon" size="30" placeholder="<?= HtmlEncode($Grid->totalnondiskon->getPlaceHolder()) ?>" value="<?= $Grid->totalnondiskon->EditValue ?>"<?= $Grid->totalnondiskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totalnondiskon->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_totalnondiskon">
<span<?= $Grid->totalnondiskon->viewAttributes() ?>>
<?= $Grid->totalnondiskon->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_totalnondiskon" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_totalnondiskon" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_totalnondiskon" value="<?= HtmlEncode($Grid->totalnondiskon->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_totalnondiskon" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_totalnondiskon" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_totalnondiskon" value="<?= HtmlEncode($Grid->totalnondiskon->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->diskonpayment->Visible) { // diskonpayment ?>
        <td data-name="diskonpayment" <?= $Grid->diskonpayment->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_diskonpayment" class="form-group">
<input type="<?= $Grid->diskonpayment->getInputTextType() ?>" data-table="invoice_detail" data-field="x_diskonpayment" name="x<?= $Grid->RowIndex ?>_diskonpayment" id="x<?= $Grid->RowIndex ?>_diskonpayment" size="30" placeholder="<?= HtmlEncode($Grid->diskonpayment->getPlaceHolder()) ?>" value="<?= $Grid->diskonpayment->EditValue ?>"<?= $Grid->diskonpayment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->diskonpayment->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_diskonpayment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_diskonpayment" id="o<?= $Grid->RowIndex ?>_diskonpayment" value="<?= HtmlEncode($Grid->diskonpayment->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_diskonpayment" class="form-group">
<input type="<?= $Grid->diskonpayment->getInputTextType() ?>" data-table="invoice_detail" data-field="x_diskonpayment" name="x<?= $Grid->RowIndex ?>_diskonpayment" id="x<?= $Grid->RowIndex ?>_diskonpayment" size="30" placeholder="<?= HtmlEncode($Grid->diskonpayment->getPlaceHolder()) ?>" value="<?= $Grid->diskonpayment->EditValue ?>"<?= $Grid->diskonpayment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->diskonpayment->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_diskonpayment">
<span<?= $Grid->diskonpayment->viewAttributes() ?>>
<?= $Grid->diskonpayment->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_diskonpayment" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_diskonpayment" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_diskonpayment" value="<?= HtmlEncode($Grid->diskonpayment->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_diskonpayment" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_diskonpayment" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_diskonpayment" value="<?= HtmlEncode($Grid->diskonpayment->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bbpersen->Visible) { // bbpersen ?>
        <td data-name="bbpersen" <?= $Grid->bbpersen->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_bbpersen" class="form-group">
<input type="<?= $Grid->bbpersen->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bbpersen" name="x<?= $Grid->RowIndex ?>_bbpersen" id="x<?= $Grid->RowIndex ?>_bbpersen" size="30" placeholder="<?= HtmlEncode($Grid->bbpersen->getPlaceHolder()) ?>" value="<?= $Grid->bbpersen->EditValue ?>"<?= $Grid->bbpersen->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bbpersen->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_bbpersen" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bbpersen" id="o<?= $Grid->RowIndex ?>_bbpersen" value="<?= HtmlEncode($Grid->bbpersen->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_bbpersen" class="form-group">
<input type="<?= $Grid->bbpersen->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bbpersen" name="x<?= $Grid->RowIndex ?>_bbpersen" id="x<?= $Grid->RowIndex ?>_bbpersen" size="30" placeholder="<?= HtmlEncode($Grid->bbpersen->getPlaceHolder()) ?>" value="<?= $Grid->bbpersen->EditValue ?>"<?= $Grid->bbpersen->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bbpersen->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_bbpersen">
<span<?= $Grid->bbpersen->viewAttributes() ?>>
<?= $Grid->bbpersen->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_bbpersen" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_bbpersen" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_bbpersen" value="<?= HtmlEncode($Grid->bbpersen->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_bbpersen" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_bbpersen" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_bbpersen" value="<?= HtmlEncode($Grid->bbpersen->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan" <?= $Grid->totaltagihan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_totaltagihan" class="form-group">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_totaltagihan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totaltagihan" id="o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_totaltagihan" class="form-group">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_totaltagihan">
<span<?= $Grid->totaltagihan->viewAttributes() ?>>
<?= $Grid->totaltagihan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_totaltagihan" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_totaltagihan" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_totaltagihan" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_totaltagihan" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->blackbonus->Visible) { // blackbonus ?>
        <td data-name="blackbonus" <?= $Grid->blackbonus->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_blackbonus" class="form-group">
<input type="<?= $Grid->blackbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_blackbonus" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" size="30" placeholder="<?= HtmlEncode($Grid->blackbonus->getPlaceHolder()) ?>" value="<?= $Grid->blackbonus->EditValue ?>"<?= $Grid->blackbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->blackbonus->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_blackbonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_blackbonus" id="o<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_blackbonus" class="form-group">
<input type="<?= $Grid->blackbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_blackbonus" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" size="30" placeholder="<?= HtmlEncode($Grid->blackbonus->getPlaceHolder()) ?>" value="<?= $Grid->blackbonus->EditValue ?>"<?= $Grid->blackbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->blackbonus->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_invoice_detail_blackbonus">
<span<?= $Grid->blackbonus->viewAttributes() ?>>
<?= $Grid->blackbonus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="invoice_detail" data-field="x_blackbonus" data-hidden="1" name="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_blackbonus" id="finvoice_detailgrid$x<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->FormValue) ?>">
<input type="hidden" data-table="invoice_detail" data-field="x_blackbonus" data-hidden="1" name="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_blackbonus" id="finvoice_detailgrid$o<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->OldValue) ?>">
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
loadjs.ready(["finvoice_detailgrid","load"], function () {
    finvoice_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_invoice_detail", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idorder_detail->Visible) { // idorder_detail ?>
        <td data-name="idorder_detail">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_idorder_detail" class="form-group invoice_detail_idorder_detail">
<?php $Grid->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idorder_detail"
        name="x<?= $Grid->RowIndex ?>_idorder_detail"
        class="form-control ew-select<?= $Grid->idorder_detail->isInvalidClass() ?>"
        data-select2-id="invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail"
        data-table="invoice_detail"
        data-field="x_idorder_detail"
        data-value-separator="<?= $Grid->idorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idorder_detail->getPlaceHolder()) ?>"
        <?= $Grid->idorder_detail->editAttributes() ?>>
        <?= $Grid->idorder_detail->selectOptionListHtml("x{$Grid->RowIndex}_idorder_detail") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idorder_detail->getErrorMessage() ?></div>
<?= $Grid->idorder_detail->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idorder_detail", selectId: "invoice_detail_x<?= $Grid->RowIndex ?>_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_idorder_detail" class="form-group invoice_detail_idorder_detail">
<span<?= $Grid->idorder_detail->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idorder_detail->getDisplayValue($Grid->idorder_detail->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_idorder_detail" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idorder_detail" id="x<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_idorder_detail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idorder_detail" id="o<?= $Grid->RowIndex ?>_idorder_detail" value="<?= HtmlEncode($Grid->idorder_detail->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlahorder->Visible) { // jumlahorder ?>
        <td data-name="jumlahorder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_jumlahorder" class="form-group invoice_detail_jumlahorder">
<input type="<?= $Grid->jumlahorder->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahorder" name="x<?= $Grid->RowIndex ?>_jumlahorder" id="x<?= $Grid->RowIndex ?>_jumlahorder" size="30" placeholder="<?= HtmlEncode($Grid->jumlahorder->getPlaceHolder()) ?>" value="<?= $Grid->jumlahorder->EditValue ?>"<?= $Grid->jumlahorder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahorder->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_jumlahorder" class="form-group invoice_detail_jumlahorder">
<span<?= $Grid->jumlahorder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlahorder->getDisplayValue($Grid->jumlahorder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahorder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlahorder" id="x<?= $Grid->RowIndex ?>_jumlahorder" value="<?= HtmlEncode($Grid->jumlahorder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahorder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahorder" id="o<?= $Grid->RowIndex ?>_jumlahorder" value="<?= HtmlEncode($Grid->jumlahorder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bonus->Visible) { // bonus ?>
        <td data-name="bonus">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_bonus" class="form-group invoice_detail_bonus">
<input type="<?= $Grid->bonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bonus" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" size="30" placeholder="<?= HtmlEncode($Grid->bonus->getPlaceHolder()) ?>" value="<?= $Grid->bonus->EditValue ?>"<?= $Grid->bonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bonus->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_bonus" class="form-group invoice_detail_bonus">
<span<?= $Grid->bonus->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bonus->getDisplayValue($Grid->bonus->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_bonus" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bonus" id="x<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_bonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bonus" id="o<?= $Grid->RowIndex ?>_bonus" value="<?= HtmlEncode($Grid->bonus->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->stockdo->Visible) { // stockdo ?>
        <td data-name="stockdo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_stockdo" class="form-group invoice_detail_stockdo">
<input type="<?= $Grid->stockdo->getInputTextType() ?>" data-table="invoice_detail" data-field="x_stockdo" name="x<?= $Grid->RowIndex ?>_stockdo" id="x<?= $Grid->RowIndex ?>_stockdo" size="30" placeholder="<?= HtmlEncode($Grid->stockdo->getPlaceHolder()) ?>" value="<?= $Grid->stockdo->EditValue ?>"<?= $Grid->stockdo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->stockdo->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_stockdo" class="form-group invoice_detail_stockdo">
<span<?= $Grid->stockdo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->stockdo->getDisplayValue($Grid->stockdo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_stockdo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_stockdo" id="x<?= $Grid->RowIndex ?>_stockdo" value="<?= HtmlEncode($Grid->stockdo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_stockdo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_stockdo" id="o<?= $Grid->RowIndex ?>_stockdo" value="<?= HtmlEncode($Grid->stockdo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlahkirim->Visible) { // jumlahkirim ?>
        <td data-name="jumlahkirim">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_jumlahkirim" class="form-group invoice_detail_jumlahkirim">
<input type="<?= $Grid->jumlahkirim->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahkirim" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Grid->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Grid->jumlahkirim->EditValue ?>"<?= $Grid->jumlahkirim->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahkirim->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_jumlahkirim" class="form-group invoice_detail_jumlahkirim">
<span<?= $Grid->jumlahkirim->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlahkirim->getDisplayValue($Grid->jumlahkirim->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahkirim" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlahkirim" id="x<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahkirim" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahkirim" id="o<?= $Grid->RowIndex ?>_jumlahkirim" value="<?= HtmlEncode($Grid->jumlahkirim->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlahbonus->Visible) { // jumlahbonus ?>
        <td data-name="jumlahbonus">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_jumlahbonus" class="form-group invoice_detail_jumlahbonus">
<input type="<?= $Grid->jumlahbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahbonus" name="x<?= $Grid->RowIndex ?>_jumlahbonus" id="x<?= $Grid->RowIndex ?>_jumlahbonus" size="30" placeholder="<?= HtmlEncode($Grid->jumlahbonus->getPlaceHolder()) ?>" value="<?= $Grid->jumlahbonus->EditValue ?>"<?= $Grid->jumlahbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahbonus->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_jumlahbonus" class="form-group invoice_detail_jumlahbonus">
<span<?= $Grid->jumlahbonus->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlahbonus->getDisplayValue($Grid->jumlahbonus->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahbonus" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlahbonus" id="x<?= $Grid->RowIndex ?>_jumlahbonus" value="<?= HtmlEncode($Grid->jumlahbonus->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_jumlahbonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahbonus" id="o<?= $Grid->RowIndex ?>_jumlahbonus" value="<?= HtmlEncode($Grid->jumlahbonus->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->harga->Visible) { // harga ?>
        <td data-name="harga">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_harga" class="form-group invoice_detail_harga">
<input type="<?= $Grid->harga->getInputTextType() ?>" data-table="invoice_detail" data-field="x_harga" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" size="30" placeholder="<?= HtmlEncode($Grid->harga->getPlaceHolder()) ?>" value="<?= $Grid->harga->EditValue ?>"<?= $Grid->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->harga->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_harga" class="form-group invoice_detail_harga">
<span<?= $Grid->harga->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->harga->getDisplayValue($Grid->harga->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_harga" data-hidden="1" name="x<?= $Grid->RowIndex ?>_harga" id="x<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_harga" data-hidden="1" name="o<?= $Grid->RowIndex ?>_harga" id="o<?= $Grid->RowIndex ?>_harga" value="<?= HtmlEncode($Grid->harga->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->totalnondiskon->Visible) { // totalnondiskon ?>
        <td data-name="totalnondiskon">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_totalnondiskon" class="form-group invoice_detail_totalnondiskon">
<input type="<?= $Grid->totalnondiskon->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totalnondiskon" name="x<?= $Grid->RowIndex ?>_totalnondiskon" id="x<?= $Grid->RowIndex ?>_totalnondiskon" size="30" placeholder="<?= HtmlEncode($Grid->totalnondiskon->getPlaceHolder()) ?>" value="<?= $Grid->totalnondiskon->EditValue ?>"<?= $Grid->totalnondiskon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totalnondiskon->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_totalnondiskon" class="form-group invoice_detail_totalnondiskon">
<span<?= $Grid->totalnondiskon->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->totalnondiskon->getDisplayValue($Grid->totalnondiskon->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_totalnondiskon" data-hidden="1" name="x<?= $Grid->RowIndex ?>_totalnondiskon" id="x<?= $Grid->RowIndex ?>_totalnondiskon" value="<?= HtmlEncode($Grid->totalnondiskon->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_totalnondiskon" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totalnondiskon" id="o<?= $Grid->RowIndex ?>_totalnondiskon" value="<?= HtmlEncode($Grid->totalnondiskon->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->diskonpayment->Visible) { // diskonpayment ?>
        <td data-name="diskonpayment">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_diskonpayment" class="form-group invoice_detail_diskonpayment">
<input type="<?= $Grid->diskonpayment->getInputTextType() ?>" data-table="invoice_detail" data-field="x_diskonpayment" name="x<?= $Grid->RowIndex ?>_diskonpayment" id="x<?= $Grid->RowIndex ?>_diskonpayment" size="30" placeholder="<?= HtmlEncode($Grid->diskonpayment->getPlaceHolder()) ?>" value="<?= $Grid->diskonpayment->EditValue ?>"<?= $Grid->diskonpayment->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->diskonpayment->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_diskonpayment" class="form-group invoice_detail_diskonpayment">
<span<?= $Grid->diskonpayment->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->diskonpayment->getDisplayValue($Grid->diskonpayment->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_diskonpayment" data-hidden="1" name="x<?= $Grid->RowIndex ?>_diskonpayment" id="x<?= $Grid->RowIndex ?>_diskonpayment" value="<?= HtmlEncode($Grid->diskonpayment->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_diskonpayment" data-hidden="1" name="o<?= $Grid->RowIndex ?>_diskonpayment" id="o<?= $Grid->RowIndex ?>_diskonpayment" value="<?= HtmlEncode($Grid->diskonpayment->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bbpersen->Visible) { // bbpersen ?>
        <td data-name="bbpersen">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_bbpersen" class="form-group invoice_detail_bbpersen">
<input type="<?= $Grid->bbpersen->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bbpersen" name="x<?= $Grid->RowIndex ?>_bbpersen" id="x<?= $Grid->RowIndex ?>_bbpersen" size="30" placeholder="<?= HtmlEncode($Grid->bbpersen->getPlaceHolder()) ?>" value="<?= $Grid->bbpersen->EditValue ?>"<?= $Grid->bbpersen->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bbpersen->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_bbpersen" class="form-group invoice_detail_bbpersen">
<span<?= $Grid->bbpersen->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bbpersen->getDisplayValue($Grid->bbpersen->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_bbpersen" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bbpersen" id="x<?= $Grid->RowIndex ?>_bbpersen" value="<?= HtmlEncode($Grid->bbpersen->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_bbpersen" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bbpersen" id="o<?= $Grid->RowIndex ?>_bbpersen" value="<?= HtmlEncode($Grid->bbpersen->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->totaltagihan->Visible) { // totaltagihan ?>
        <td data-name="totaltagihan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_totaltagihan" class="form-group invoice_detail_totaltagihan">
<input type="<?= $Grid->totaltagihan->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totaltagihan" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" size="30" placeholder="<?= HtmlEncode($Grid->totaltagihan->getPlaceHolder()) ?>" value="<?= $Grid->totaltagihan->EditValue ?>"<?= $Grid->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->totaltagihan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_totaltagihan" class="form-group invoice_detail_totaltagihan">
<span<?= $Grid->totaltagihan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->totaltagihan->getDisplayValue($Grid->totaltagihan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_totaltagihan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_totaltagihan" id="x<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_totaltagihan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_totaltagihan" id="o<?= $Grid->RowIndex ?>_totaltagihan" value="<?= HtmlEncode($Grid->totaltagihan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->blackbonus->Visible) { // blackbonus ?>
        <td data-name="blackbonus">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_invoice_detail_blackbonus" class="form-group invoice_detail_blackbonus">
<input type="<?= $Grid->blackbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_blackbonus" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" size="30" placeholder="<?= HtmlEncode($Grid->blackbonus->getPlaceHolder()) ?>" value="<?= $Grid->blackbonus->EditValue ?>"<?= $Grid->blackbonus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->blackbonus->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_invoice_detail_blackbonus" class="form-group invoice_detail_blackbonus">
<span<?= $Grid->blackbonus->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->blackbonus->getDisplayValue($Grid->blackbonus->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice_detail" data-field="x_blackbonus" data-hidden="1" name="x<?= $Grid->RowIndex ?>_blackbonus" id="x<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="invoice_detail" data-field="x_blackbonus" data-hidden="1" name="o<?= $Grid->RowIndex ?>_blackbonus" id="o<?= $Grid->RowIndex ?>_blackbonus" value="<?= HtmlEncode($Grid->blackbonus->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["finvoice_detailgrid","load"], function() {
    finvoice_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="finvoice_detailgrid">
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
    ew.addEventHandlers("invoice_detail");
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
        container: "gmp_invoice_detail",
        width: "",
        height: ""
    });
});
</script>
<?php } ?>
<?php } ?>
