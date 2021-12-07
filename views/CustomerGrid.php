<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("CustomerGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcustomergrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fcustomergrid = new ew.Form("fcustomergrid", "grid");
    fcustomergrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "customer")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.customer)
        ew.vars.tables.customer = currentTable;
    fcustomergrid.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["idtipecustomer", [fields.idtipecustomer.visible && fields.idtipecustomer.required ? ew.Validators.required(fields.idtipecustomer.caption) : null], fields.idtipecustomer.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["jenis_usaha", [fields.jenis_usaha.visible && fields.jenis_usaha.required ? ew.Validators.required(fields.jenis_usaha.caption) : null], fields.jenis_usaha.isInvalid],
        ["hp", [fields.hp.visible && fields.hp.required ? ew.Validators.required(fields.hp.caption) : null, ew.Validators.regex("^(62)8[1-9][0-9]{7,11}$")], fields.hp.isInvalid],
        ["klinik", [fields.klinik.visible && fields.klinik.required ? ew.Validators.required(fields.klinik.caption) : null], fields.klinik.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcustomergrid,
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
    fcustomergrid.validate = function () {
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
    fcustomergrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "kode", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idtipecustomer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idpegawai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jenis_usaha", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "hp", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "klinik", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fcustomergrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcustomergrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fcustomergrid.lists.idtipecustomer = <?= $Grid->idtipecustomer->toClientList($Grid) ?>;
    fcustomergrid.lists.idpegawai = <?= $Grid->idpegawai->toClientList($Grid) ?>;
    loadjs.done("fcustomergrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> customer">
<div id="fcustomergrid" class="ew-form ew-list-form form-inline">
<div id="gmp_customer" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_customergrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="kode" class="<?= $Grid->kode->headerCellClass() ?>"><div id="elh_customer_kode" class="customer_kode"><?= $Grid->renderSort($Grid->kode) ?></div></th>
<?php } ?>
<?php if ($Grid->idtipecustomer->Visible) { // idtipecustomer ?>
        <th data-name="idtipecustomer" class="<?= $Grid->idtipecustomer->headerCellClass() ?>"><div id="elh_customer_idtipecustomer" class="customer_idtipecustomer"><?= $Grid->renderSort($Grid->idtipecustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Grid->idpegawai->headerCellClass() ?>"><div id="elh_customer_idpegawai" class="customer_idpegawai"><?= $Grid->renderSort($Grid->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Grid->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Grid->nama->headerCellClass() ?>"><div id="elh_customer_nama" class="customer_nama"><?= $Grid->renderSort($Grid->nama) ?></div></th>
<?php } ?>
<?php if ($Grid->jenis_usaha->Visible) { // jenis_usaha ?>
        <th data-name="jenis_usaha" class="<?= $Grid->jenis_usaha->headerCellClass() ?>"><div id="elh_customer_jenis_usaha" class="customer_jenis_usaha"><?= $Grid->renderSort($Grid->jenis_usaha) ?></div></th>
<?php } ?>
<?php if ($Grid->hp->Visible) { // hp ?>
        <th data-name="hp" class="<?= $Grid->hp->headerCellClass() ?>"><div id="elh_customer_hp" class="customer_hp"><?= $Grid->renderSort($Grid->hp) ?></div></th>
<?php } ?>
<?php if ($Grid->klinik->Visible) { // klinik ?>
        <th data-name="klinik" class="<?= $Grid->klinik->headerCellClass() ?>"><div id="elh_customer_klinik" class="customer_klinik"><?= $Grid->renderSort($Grid->klinik) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_customer", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_customer_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="customer" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="customer" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_customer_kode" class="form-group">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_customer_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<?= $Grid->kode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="customer" data-field="x_kode" data-hidden="1" name="fcustomergrid$x<?= $Grid->RowIndex ?>_kode" id="fcustomergrid$x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<input type="hidden" data-table="customer" data-field="x_kode" data-hidden="1" name="fcustomergrid$o<?= $Grid->RowIndex ?>_kode" id="fcustomergrid$o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idtipecustomer->Visible) { // idtipecustomer ?>
        <td data-name="idtipecustomer" <?= $Grid->idtipecustomer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_customer_idtipecustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idtipecustomer"
        name="x<?= $Grid->RowIndex ?>_idtipecustomer"
        class="form-control ew-select<?= $Grid->idtipecustomer->isInvalidClass() ?>"
        data-select2-id="customer_x<?= $Grid->RowIndex ?>_idtipecustomer"
        data-table="customer"
        data-field="x_idtipecustomer"
        data-value-separator="<?= $Grid->idtipecustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idtipecustomer->getPlaceHolder()) ?>"
        <?= $Grid->idtipecustomer->editAttributes() ?>>
        <?= $Grid->idtipecustomer->selectOptionListHtml("x{$Grid->RowIndex}_idtipecustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idtipecustomer->getErrorMessage() ?></div>
<?= $Grid->idtipecustomer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idtipecustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x<?= $Grid->RowIndex ?>_idtipecustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idtipecustomer", selectId: "customer_x<?= $Grid->RowIndex ?>_idtipecustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idtipecustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="customer" data-field="x_idtipecustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idtipecustomer" id="o<?= $Grid->RowIndex ?>_idtipecustomer" value="<?= HtmlEncode($Grid->idtipecustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_customer_idtipecustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idtipecustomer"
        name="x<?= $Grid->RowIndex ?>_idtipecustomer"
        class="form-control ew-select<?= $Grid->idtipecustomer->isInvalidClass() ?>"
        data-select2-id="customer_x<?= $Grid->RowIndex ?>_idtipecustomer"
        data-table="customer"
        data-field="x_idtipecustomer"
        data-value-separator="<?= $Grid->idtipecustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idtipecustomer->getPlaceHolder()) ?>"
        <?= $Grid->idtipecustomer->editAttributes() ?>>
        <?= $Grid->idtipecustomer->selectOptionListHtml("x{$Grid->RowIndex}_idtipecustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idtipecustomer->getErrorMessage() ?></div>
<?= $Grid->idtipecustomer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idtipecustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x<?= $Grid->RowIndex ?>_idtipecustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idtipecustomer", selectId: "customer_x<?= $Grid->RowIndex ?>_idtipecustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idtipecustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_customer_idtipecustomer">
<span<?= $Grid->idtipecustomer->viewAttributes() ?>>
<?= $Grid->idtipecustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="customer" data-field="x_idtipecustomer" data-hidden="1" name="fcustomergrid$x<?= $Grid->RowIndex ?>_idtipecustomer" id="fcustomergrid$x<?= $Grid->RowIndex ?>_idtipecustomer" value="<?= HtmlEncode($Grid->idtipecustomer->FormValue) ?>">
<input type="hidden" data-table="customer" data-field="x_idtipecustomer" data-hidden="1" name="fcustomergrid$o<?= $Grid->RowIndex ?>_idtipecustomer" id="fcustomergrid$o<?= $Grid->RowIndex ?>_idtipecustomer" value="<?= HtmlEncode($Grid->idtipecustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Grid->idpegawai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idpegawai->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_customer_idpegawai" class="form-group">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idpegawai" name="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_customer_idpegawai" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="customer_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="customer"
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
    var el = document.querySelector("select[data-select2-id='customer_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "customer_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idpegawai->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_customer_idpegawai" class="form-group">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idpegawai" name="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_customer_idpegawai" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="customer_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="customer"
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
    var el = document.querySelector("select[data-select2-id='customer_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "customer_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_customer_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<?= $Grid->idpegawai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="customer" data-field="x_idpegawai" data-hidden="1" name="fcustomergrid$x<?= $Grid->RowIndex ?>_idpegawai" id="fcustomergrid$x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<input type="hidden" data-table="customer" data-field="x_idpegawai" data-hidden="1" name="fcustomergrid$o<?= $Grid->RowIndex ?>_idpegawai" id="fcustomergrid$o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Grid->nama->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_customer_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="customer" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="customer" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_customer_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="customer" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_customer_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<?= $Grid->nama->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="customer" data-field="x_nama" data-hidden="1" name="fcustomergrid$x<?= $Grid->RowIndex ?>_nama" id="fcustomergrid$x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<input type="hidden" data-table="customer" data-field="x_nama" data-hidden="1" name="fcustomergrid$o<?= $Grid->RowIndex ?>_nama" id="fcustomergrid$o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jenis_usaha->Visible) { // jenis_usaha ?>
        <td data-name="jenis_usaha" <?= $Grid->jenis_usaha->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_customer_jenis_usaha" class="form-group">
<input type="<?= $Grid->jenis_usaha->getInputTextType() ?>" data-table="customer" data-field="x_jenis_usaha" name="x<?= $Grid->RowIndex ?>_jenis_usaha" id="x<?= $Grid->RowIndex ?>_jenis_usaha" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->jenis_usaha->getPlaceHolder()) ?>" value="<?= $Grid->jenis_usaha->EditValue ?>"<?= $Grid->jenis_usaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_usaha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="customer" data-field="x_jenis_usaha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jenis_usaha" id="o<?= $Grid->RowIndex ?>_jenis_usaha" value="<?= HtmlEncode($Grid->jenis_usaha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_customer_jenis_usaha" class="form-group">
<input type="<?= $Grid->jenis_usaha->getInputTextType() ?>" data-table="customer" data-field="x_jenis_usaha" name="x<?= $Grid->RowIndex ?>_jenis_usaha" id="x<?= $Grid->RowIndex ?>_jenis_usaha" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->jenis_usaha->getPlaceHolder()) ?>" value="<?= $Grid->jenis_usaha->EditValue ?>"<?= $Grid->jenis_usaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_usaha->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_customer_jenis_usaha">
<span<?= $Grid->jenis_usaha->viewAttributes() ?>>
<?= $Grid->jenis_usaha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="customer" data-field="x_jenis_usaha" data-hidden="1" name="fcustomergrid$x<?= $Grid->RowIndex ?>_jenis_usaha" id="fcustomergrid$x<?= $Grid->RowIndex ?>_jenis_usaha" value="<?= HtmlEncode($Grid->jenis_usaha->FormValue) ?>">
<input type="hidden" data-table="customer" data-field="x_jenis_usaha" data-hidden="1" name="fcustomergrid$o<?= $Grid->RowIndex ?>_jenis_usaha" id="fcustomergrid$o<?= $Grid->RowIndex ?>_jenis_usaha" value="<?= HtmlEncode($Grid->jenis_usaha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->hp->Visible) { // hp ?>
        <td data-name="hp" <?= $Grid->hp->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_customer_hp" class="form-group">
<input type="<?= $Grid->hp->getInputTextType() ?>" data-table="customer" data-field="x_hp" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" size="15" maxlength="255" placeholder="<?= HtmlEncode($Grid->hp->getPlaceHolder()) ?>" value="<?= $Grid->hp->EditValue ?>"<?= $Grid->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hp->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="customer" data-field="x_hp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hp" id="o<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_customer_hp" class="form-group">
<input type="<?= $Grid->hp->getInputTextType() ?>" data-table="customer" data-field="x_hp" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" size="15" maxlength="255" placeholder="<?= HtmlEncode($Grid->hp->getPlaceHolder()) ?>" value="<?= $Grid->hp->EditValue ?>"<?= $Grid->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_customer_hp">
<span<?= $Grid->hp->viewAttributes() ?>>
<?= $Grid->hp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="customer" data-field="x_hp" data-hidden="1" name="fcustomergrid$x<?= $Grid->RowIndex ?>_hp" id="fcustomergrid$x<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->FormValue) ?>">
<input type="hidden" data-table="customer" data-field="x_hp" data-hidden="1" name="fcustomergrid$o<?= $Grid->RowIndex ?>_hp" id="fcustomergrid$o<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->klinik->Visible) { // klinik ?>
        <td data-name="klinik" <?= $Grid->klinik->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_customer_klinik" class="form-group">
<input type="<?= $Grid->klinik->getInputTextType() ?>" data-table="customer" data-field="x_klinik" name="x<?= $Grid->RowIndex ?>_klinik" id="x<?= $Grid->RowIndex ?>_klinik" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->klinik->getPlaceHolder()) ?>" value="<?= $Grid->klinik->EditValue ?>"<?= $Grid->klinik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->klinik->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="customer" data-field="x_klinik" data-hidden="1" name="o<?= $Grid->RowIndex ?>_klinik" id="o<?= $Grid->RowIndex ?>_klinik" value="<?= HtmlEncode($Grid->klinik->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_customer_klinik" class="form-group">
<input type="<?= $Grid->klinik->getInputTextType() ?>" data-table="customer" data-field="x_klinik" name="x<?= $Grid->RowIndex ?>_klinik" id="x<?= $Grid->RowIndex ?>_klinik" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->klinik->getPlaceHolder()) ?>" value="<?= $Grid->klinik->EditValue ?>"<?= $Grid->klinik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->klinik->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_customer_klinik">
<span<?= $Grid->klinik->viewAttributes() ?>>
<?= $Grid->klinik->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="customer" data-field="x_klinik" data-hidden="1" name="fcustomergrid$x<?= $Grid->RowIndex ?>_klinik" id="fcustomergrid$x<?= $Grid->RowIndex ?>_klinik" value="<?= HtmlEncode($Grid->klinik->FormValue) ?>">
<input type="hidden" data-table="customer" data-field="x_klinik" data-hidden="1" name="fcustomergrid$o<?= $Grid->RowIndex ?>_klinik" id="fcustomergrid$o<?= $Grid->RowIndex ?>_klinik" value="<?= HtmlEncode($Grid->klinik->OldValue) ?>">
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
loadjs.ready(["fcustomergrid","load"], function () {
    fcustomergrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_customer", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_customer_kode" class="form-group customer_kode">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="customer" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_customer_kode" class="form-group customer_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idtipecustomer->Visible) { // idtipecustomer ?>
        <td data-name="idtipecustomer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_customer_idtipecustomer" class="form-group customer_idtipecustomer">
    <select
        id="x<?= $Grid->RowIndex ?>_idtipecustomer"
        name="x<?= $Grid->RowIndex ?>_idtipecustomer"
        class="form-control ew-select<?= $Grid->idtipecustomer->isInvalidClass() ?>"
        data-select2-id="customer_x<?= $Grid->RowIndex ?>_idtipecustomer"
        data-table="customer"
        data-field="x_idtipecustomer"
        data-value-separator="<?= $Grid->idtipecustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idtipecustomer->getPlaceHolder()) ?>"
        <?= $Grid->idtipecustomer->editAttributes() ?>>
        <?= $Grid->idtipecustomer->selectOptionListHtml("x{$Grid->RowIndex}_idtipecustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idtipecustomer->getErrorMessage() ?></div>
<?= $Grid->idtipecustomer->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idtipecustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x<?= $Grid->RowIndex ?>_idtipecustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idtipecustomer", selectId: "customer_x<?= $Grid->RowIndex ?>_idtipecustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idtipecustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_customer_idtipecustomer" class="form-group customer_idtipecustomer">
<span<?= $Grid->idtipecustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idtipecustomer->getDisplayValue($Grid->idtipecustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_idtipecustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idtipecustomer" id="x<?= $Grid->RowIndex ?>_idtipecustomer" value="<?= HtmlEncode($Grid->idtipecustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_idtipecustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idtipecustomer" id="o<?= $Grid->RowIndex ?>_idtipecustomer" value="<?= HtmlEncode($Grid->idtipecustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idpegawai->getSessionValue() != "") { ?>
<span id="el$rowindex$_customer_idpegawai" class="form-group customer_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idpegawai" name="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_customer_idpegawai" class="form-group customer_idpegawai">
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="customer_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="customer"
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
    var el = document.querySelector("select[data-select2-id='customer_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "customer_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_customer_idpegawai" class="form-group customer_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_idpegawai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idpegawai" id="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_customer_nama" class="form-group customer_nama">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="customer" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_customer_nama" class="form-group customer_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama->getDisplayValue($Grid->nama->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_nama" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jenis_usaha->Visible) { // jenis_usaha ?>
        <td data-name="jenis_usaha">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_customer_jenis_usaha" class="form-group customer_jenis_usaha">
<input type="<?= $Grid->jenis_usaha->getInputTextType() ?>" data-table="customer" data-field="x_jenis_usaha" name="x<?= $Grid->RowIndex ?>_jenis_usaha" id="x<?= $Grid->RowIndex ?>_jenis_usaha" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->jenis_usaha->getPlaceHolder()) ?>" value="<?= $Grid->jenis_usaha->EditValue ?>"<?= $Grid->jenis_usaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jenis_usaha->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_customer_jenis_usaha" class="form-group customer_jenis_usaha">
<span<?= $Grid->jenis_usaha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jenis_usaha->getDisplayValue($Grid->jenis_usaha->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_jenis_usaha" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jenis_usaha" id="x<?= $Grid->RowIndex ?>_jenis_usaha" value="<?= HtmlEncode($Grid->jenis_usaha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_jenis_usaha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jenis_usaha" id="o<?= $Grid->RowIndex ?>_jenis_usaha" value="<?= HtmlEncode($Grid->jenis_usaha->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->hp->Visible) { // hp ?>
        <td data-name="hp">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_customer_hp" class="form-group customer_hp">
<input type="<?= $Grid->hp->getInputTextType() ?>" data-table="customer" data-field="x_hp" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" size="15" maxlength="255" placeholder="<?= HtmlEncode($Grid->hp->getPlaceHolder()) ?>" value="<?= $Grid->hp->EditValue ?>"<?= $Grid->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hp->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_customer_hp" class="form-group customer_hp">
<span<?= $Grid->hp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->hp->getDisplayValue($Grid->hp->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_hp" data-hidden="1" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_hp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hp" id="o<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->klinik->Visible) { // klinik ?>
        <td data-name="klinik">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_customer_klinik" class="form-group customer_klinik">
<input type="<?= $Grid->klinik->getInputTextType() ?>" data-table="customer" data-field="x_klinik" name="x<?= $Grid->RowIndex ?>_klinik" id="x<?= $Grid->RowIndex ?>_klinik" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->klinik->getPlaceHolder()) ?>" value="<?= $Grid->klinik->EditValue ?>"<?= $Grid->klinik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->klinik->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_customer_klinik" class="form-group customer_klinik">
<span<?= $Grid->klinik->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->klinik->getDisplayValue($Grid->klinik->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="customer" data-field="x_klinik" data-hidden="1" name="x<?= $Grid->RowIndex ?>_klinik" id="x<?= $Grid->RowIndex ?>_klinik" value="<?= HtmlEncode($Grid->klinik->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="customer" data-field="x_klinik" data-hidden="1" name="o<?= $Grid->RowIndex ?>_klinik" id="o<?= $Grid->RowIndex ?>_klinik" value="<?= HtmlEncode($Grid->klinik->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fcustomergrid","load"], function() {
    fcustomergrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fcustomergrid">
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
    ew.addEventHandlers("customer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $(".ew-detail-add-group").html("Add Customer").attr("href","CustomerAdd?showdetail=alamat_customer"),$("a[data-table=brand_customer]").html("Brand");
});
</script>
<?php } ?>
