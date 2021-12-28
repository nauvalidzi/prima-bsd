<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("NpdHargaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_hargagrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnpd_hargagrid = new ew.Form("fnpd_hargagrid", "grid");
    fnpd_hargagrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_harga")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_harga)
        ew.vars.tables.npd_harga = currentTable;
    fnpd_hargagrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["tglpengajuan", [fields.tglpengajuan.visible && fields.tglpengajuan.required ? ew.Validators.required(fields.tglpengajuan.caption) : null, ew.Validators.datetime(0)], fields.tglpengajuan.isInvalid],
        ["idnpd_sample", [fields.idnpd_sample.visible && fields.idnpd_sample.required ? ew.Validators.required(fields.idnpd_sample.caption) : null], fields.idnpd_sample.isInvalid],
        ["viskositasbarang", [fields.viskositasbarang.visible && fields.viskositasbarang.required ? ew.Validators.required(fields.viskositasbarang.caption) : null], fields.viskositasbarang.isInvalid],
        ["idaplikasibarang", [fields.idaplikasibarang.visible && fields.idaplikasibarang.required ? ew.Validators.required(fields.idaplikasibarang.caption) : null, ew.Validators.integer], fields.idaplikasibarang.isInvalid],
        ["hargapcs", [fields.hargapcs.visible && fields.hargapcs.required ? ew.Validators.required(fields.hargapcs.caption) : null, ew.Validators.integer], fields.hargapcs.isInvalid],
        ["disetujui", [fields.disetujui.visible && fields.disetujui.required ? ew.Validators.required(fields.disetujui.caption) : null], fields.disetujui.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_hargagrid,
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
    fnpd_hargagrid.validate = function () {
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
    fnpd_hargagrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglpengajuan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idnpd_sample", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "viskositasbarang", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idaplikasibarang", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "hargapcs", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "disetujui", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnpd_hargagrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_hargagrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_hargagrid.lists.idnpd = <?= $Grid->idnpd->toClientList($Grid) ?>;
    fnpd_hargagrid.lists.idnpd_sample = <?= $Grid->idnpd_sample->toClientList($Grid) ?>;
    fnpd_hargagrid.lists.disetujui = <?= $Grid->disetujui->toClientList($Grid) ?>;
    loadjs.done("fnpd_hargagrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_harga">
<div id="fnpd_hargagrid" class="ew-form ew-list-form form-inline">
<div id="gmp_npd_harga" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_npd_hargagrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_npd_harga_idnpd" class="npd_harga_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->tglpengajuan->Visible) { // tglpengajuan ?>
        <th data-name="tglpengajuan" class="<?= $Grid->tglpengajuan->headerCellClass() ?>"><div id="elh_npd_harga_tglpengajuan" class="npd_harga_tglpengajuan"><?= $Grid->renderSort($Grid->tglpengajuan) ?></div></th>
<?php } ?>
<?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <th data-name="idnpd_sample" class="<?= $Grid->idnpd_sample->headerCellClass() ?>"><div id="elh_npd_harga_idnpd_sample" class="npd_harga_idnpd_sample"><?= $Grid->renderSort($Grid->idnpd_sample) ?></div></th>
<?php } ?>
<?php if ($Grid->viskositasbarang->Visible) { // viskositasbarang ?>
        <th data-name="viskositasbarang" class="<?= $Grid->viskositasbarang->headerCellClass() ?>"><div id="elh_npd_harga_viskositasbarang" class="npd_harga_viskositasbarang"><?= $Grid->renderSort($Grid->viskositasbarang) ?></div></th>
<?php } ?>
<?php if ($Grid->idaplikasibarang->Visible) { // idaplikasibarang ?>
        <th data-name="idaplikasibarang" class="<?= $Grid->idaplikasibarang->headerCellClass() ?>"><div id="elh_npd_harga_idaplikasibarang" class="npd_harga_idaplikasibarang"><?= $Grid->renderSort($Grid->idaplikasibarang) ?></div></th>
<?php } ?>
<?php if ($Grid->hargapcs->Visible) { // hargapcs ?>
        <th data-name="hargapcs" class="<?= $Grid->hargapcs->headerCellClass() ?>"><div id="elh_npd_harga_hargapcs" class="npd_harga_hargapcs"><?= $Grid->renderSort($Grid->hargapcs) ?></div></th>
<?php } ?>
<?php if ($Grid->disetujui->Visible) { // disetujui ?>
        <th data-name="disetujui" class="<?= $Grid->disetujui->headerCellClass() ?>"><div id="elh_npd_harga_disetujui" class="npd_harga_disetujui"><?= $Grid->renderSort($Grid->disetujui) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_npd_harga", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Grid->idnpd->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_harga_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_harga"
        data-field="x_idnpd"
        data-value-separator="<?= $Grid->idnpd->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>"
        <?= $Grid->idnpd->editAttributes() ?>>
        <?= $Grid->idnpd->selectOptionListHtml("x{$Grid->RowIndex}_idnpd") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
<?= $Grid->idnpd->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_harga_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_harga_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_harga_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_harga"
        data-field="x_idnpd"
        data-value-separator="<?= $Grid->idnpd->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>"
        <?= $Grid->idnpd->editAttributes() ?>>
        <?= $Grid->idnpd->selectOptionListHtml("x{$Grid->RowIndex}_idnpd") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
<?= $Grid->idnpd->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_harga_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_harga_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd" data-hidden="1" name="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_idnpd" id="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="npd_harga" data-field="x_idnpd" data-hidden="1" name="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_idnpd" id="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglpengajuan->Visible) { // tglpengajuan ?>
        <td data-name="tglpengajuan" <?= $Grid->tglpengajuan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_tglpengajuan" class="form-group">
<input type="<?= $Grid->tglpengajuan->getInputTextType() ?>" data-table="npd_harga" data-field="x_tglpengajuan" name="x<?= $Grid->RowIndex ?>_tglpengajuan" id="x<?= $Grid->RowIndex ?>_tglpengajuan" placeholder="<?= HtmlEncode($Grid->tglpengajuan->getPlaceHolder()) ?>" value="<?= $Grid->tglpengajuan->EditValue ?>"<?= $Grid->tglpengajuan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglpengajuan->getErrorMessage() ?></div>
<?php if (!$Grid->tglpengajuan->ReadOnly && !$Grid->tglpengajuan->Disabled && !isset($Grid->tglpengajuan->EditAttrs["readonly"]) && !isset($Grid->tglpengajuan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_hargagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_hargagrid", "x<?= $Grid->RowIndex ?>_tglpengajuan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_tglpengajuan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglpengajuan" id="o<?= $Grid->RowIndex ?>_tglpengajuan" value="<?= HtmlEncode($Grid->tglpengajuan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_tglpengajuan" class="form-group">
<input type="<?= $Grid->tglpengajuan->getInputTextType() ?>" data-table="npd_harga" data-field="x_tglpengajuan" name="x<?= $Grid->RowIndex ?>_tglpengajuan" id="x<?= $Grid->RowIndex ?>_tglpengajuan" placeholder="<?= HtmlEncode($Grid->tglpengajuan->getPlaceHolder()) ?>" value="<?= $Grid->tglpengajuan->EditValue ?>"<?= $Grid->tglpengajuan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglpengajuan->getErrorMessage() ?></div>
<?php if (!$Grid->tglpengajuan->ReadOnly && !$Grid->tglpengajuan->Disabled && !isset($Grid->tglpengajuan->EditAttrs["readonly"]) && !isset($Grid->tglpengajuan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_hargagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_hargagrid", "x<?= $Grid->RowIndex ?>_tglpengajuan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_tglpengajuan">
<span<?= $Grid->tglpengajuan->viewAttributes() ?>>
<?= $Grid->tglpengajuan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_harga" data-field="x_tglpengajuan" data-hidden="1" name="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_tglpengajuan" id="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_tglpengajuan" value="<?= HtmlEncode($Grid->tglpengajuan->FormValue) ?>">
<input type="hidden" data-table="npd_harga" data-field="x_tglpengajuan" data-hidden="1" name="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_tglpengajuan" id="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_tglpengajuan" value="<?= HtmlEncode($Grid->tglpengajuan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <td data-name="idnpd_sample" <?= $Grid->idnpd_sample->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd_sample" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_harga"
        data-field="x_idnpd_sample"
        data-value-separator="<?= $Grid->idnpd_sample->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd_sample->getPlaceHolder()) ?>"
        <?= $Grid->idnpd_sample->editAttributes() ?>>
        <?= $Grid->idnpd_sample->selectOptionListHtml("x{$Grid->RowIndex}_idnpd_sample") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd_sample->getErrorMessage() ?></div>
<?= $Grid->idnpd_sample->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd_sample") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd_sample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd_sample" id="o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd_sample" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_harga"
        data-field="x_idnpd_sample"
        data-value-separator="<?= $Grid->idnpd_sample->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd_sample->getPlaceHolder()) ?>"
        <?= $Grid->idnpd_sample->editAttributes() ?>>
        <?= $Grid->idnpd_sample->selectOptionListHtml("x{$Grid->RowIndex}_idnpd_sample") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd_sample->getErrorMessage() ?></div>
<?= $Grid->idnpd_sample->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd_sample") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idnpd_sample">
<span<?= $Grid->idnpd_sample->viewAttributes() ?>>
<?= $Grid->idnpd_sample->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd_sample" data-hidden="1" name="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_idnpd_sample" id="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->FormValue) ?>">
<input type="hidden" data-table="npd_harga" data-field="x_idnpd_sample" data-hidden="1" name="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_idnpd_sample" id="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->viskositasbarang->Visible) { // viskositasbarang ?>
        <td data-name="viskositasbarang" <?= $Grid->viskositasbarang->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_viskositasbarang" class="form-group">
<input type="<?= $Grid->viskositasbarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_viskositasbarang" name="x<?= $Grid->RowIndex ?>_viskositasbarang" id="x<?= $Grid->RowIndex ?>_viskositasbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->viskositasbarang->getPlaceHolder()) ?>" value="<?= $Grid->viskositasbarang->EditValue ?>"<?= $Grid->viskositasbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->viskositasbarang->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_viskositasbarang" data-hidden="1" name="o<?= $Grid->RowIndex ?>_viskositasbarang" id="o<?= $Grid->RowIndex ?>_viskositasbarang" value="<?= HtmlEncode($Grid->viskositasbarang->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_viskositasbarang" class="form-group">
<input type="<?= $Grid->viskositasbarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_viskositasbarang" name="x<?= $Grid->RowIndex ?>_viskositasbarang" id="x<?= $Grid->RowIndex ?>_viskositasbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->viskositasbarang->getPlaceHolder()) ?>" value="<?= $Grid->viskositasbarang->EditValue ?>"<?= $Grid->viskositasbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->viskositasbarang->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_viskositasbarang">
<span<?= $Grid->viskositasbarang->viewAttributes() ?>>
<?= $Grid->viskositasbarang->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_harga" data-field="x_viskositasbarang" data-hidden="1" name="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_viskositasbarang" id="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_viskositasbarang" value="<?= HtmlEncode($Grid->viskositasbarang->FormValue) ?>">
<input type="hidden" data-table="npd_harga" data-field="x_viskositasbarang" data-hidden="1" name="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_viskositasbarang" id="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_viskositasbarang" value="<?= HtmlEncode($Grid->viskositasbarang->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idaplikasibarang->Visible) { // idaplikasibarang ?>
        <td data-name="idaplikasibarang" <?= $Grid->idaplikasibarang->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idaplikasibarang" class="form-group">
<input type="<?= $Grid->idaplikasibarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_idaplikasibarang" name="x<?= $Grid->RowIndex ?>_idaplikasibarang" id="x<?= $Grid->RowIndex ?>_idaplikasibarang" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->idaplikasibarang->getPlaceHolder()) ?>" value="<?= $Grid->idaplikasibarang->EditValue ?>"<?= $Grid->idaplikasibarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idaplikasibarang->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_idaplikasibarang" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idaplikasibarang" id="o<?= $Grid->RowIndex ?>_idaplikasibarang" value="<?= HtmlEncode($Grid->idaplikasibarang->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idaplikasibarang" class="form-group">
<input type="<?= $Grid->idaplikasibarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_idaplikasibarang" name="x<?= $Grid->RowIndex ?>_idaplikasibarang" id="x<?= $Grid->RowIndex ?>_idaplikasibarang" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->idaplikasibarang->getPlaceHolder()) ?>" value="<?= $Grid->idaplikasibarang->EditValue ?>"<?= $Grid->idaplikasibarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idaplikasibarang->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_idaplikasibarang">
<span<?= $Grid->idaplikasibarang->viewAttributes() ?>>
<?= $Grid->idaplikasibarang->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_harga" data-field="x_idaplikasibarang" data-hidden="1" name="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_idaplikasibarang" id="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_idaplikasibarang" value="<?= HtmlEncode($Grid->idaplikasibarang->FormValue) ?>">
<input type="hidden" data-table="npd_harga" data-field="x_idaplikasibarang" data-hidden="1" name="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_idaplikasibarang" id="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_idaplikasibarang" value="<?= HtmlEncode($Grid->idaplikasibarang->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->hargapcs->Visible) { // hargapcs ?>
        <td data-name="hargapcs" <?= $Grid->hargapcs->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_hargapcs" class="form-group">
<input type="<?= $Grid->hargapcs->getInputTextType() ?>" data-table="npd_harga" data-field="x_hargapcs" name="x<?= $Grid->RowIndex ?>_hargapcs" id="x<?= $Grid->RowIndex ?>_hargapcs" size="30" placeholder="<?= HtmlEncode($Grid->hargapcs->getPlaceHolder()) ?>" value="<?= $Grid->hargapcs->EditValue ?>"<?= $Grid->hargapcs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hargapcs->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_hargapcs" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hargapcs" id="o<?= $Grid->RowIndex ?>_hargapcs" value="<?= HtmlEncode($Grid->hargapcs->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_hargapcs" class="form-group">
<input type="<?= $Grid->hargapcs->getInputTextType() ?>" data-table="npd_harga" data-field="x_hargapcs" name="x<?= $Grid->RowIndex ?>_hargapcs" id="x<?= $Grid->RowIndex ?>_hargapcs" size="30" placeholder="<?= HtmlEncode($Grid->hargapcs->getPlaceHolder()) ?>" value="<?= $Grid->hargapcs->EditValue ?>"<?= $Grid->hargapcs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hargapcs->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_hargapcs">
<span<?= $Grid->hargapcs->viewAttributes() ?>>
<?= $Grid->hargapcs->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_harga" data-field="x_hargapcs" data-hidden="1" name="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_hargapcs" id="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_hargapcs" value="<?= HtmlEncode($Grid->hargapcs->FormValue) ?>">
<input type="hidden" data-table="npd_harga" data-field="x_hargapcs" data-hidden="1" name="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_hargapcs" id="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_hargapcs" value="<?= HtmlEncode($Grid->hargapcs->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->disetujui->Visible) { // disetujui ?>
        <td data-name="disetujui" <?= $Grid->disetujui->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_disetujui" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_disetujui">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_harga" data-field="x_disetujui" name="x<?= $Grid->RowIndex ?>_disetujui" id="x<?= $Grid->RowIndex ?>_disetujui"<?= $Grid->disetujui->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_disetujui" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_disetujui"
    name="x<?= $Grid->RowIndex ?>_disetujui"
    value="<?= HtmlEncode($Grid->disetujui->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_disetujui"
    data-target="dsl_x<?= $Grid->RowIndex ?>_disetujui"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->disetujui->isInvalidClass() ?>"
    data-table="npd_harga"
    data-field="x_disetujui"
    data-value-separator="<?= $Grid->disetujui->displayValueSeparatorAttribute() ?>"
    <?= $Grid->disetujui->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->disetujui->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_disetujui" data-hidden="1" name="o<?= $Grid->RowIndex ?>_disetujui" id="o<?= $Grid->RowIndex ?>_disetujui" value="<?= HtmlEncode($Grid->disetujui->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_disetujui" class="form-group">
<template id="tp_x<?= $Grid->RowIndex ?>_disetujui">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_harga" data-field="x_disetujui" name="x<?= $Grid->RowIndex ?>_disetujui" id="x<?= $Grid->RowIndex ?>_disetujui"<?= $Grid->disetujui->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_disetujui" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_disetujui"
    name="x<?= $Grid->RowIndex ?>_disetujui"
    value="<?= HtmlEncode($Grid->disetujui->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_disetujui"
    data-target="dsl_x<?= $Grid->RowIndex ?>_disetujui"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->disetujui->isInvalidClass() ?>"
    data-table="npd_harga"
    data-field="x_disetujui"
    data-value-separator="<?= $Grid->disetujui->displayValueSeparatorAttribute() ?>"
    <?= $Grid->disetujui->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->disetujui->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_harga_disetujui">
<span<?= $Grid->disetujui->viewAttributes() ?>>
<?= $Grid->disetujui->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_harga" data-field="x_disetujui" data-hidden="1" name="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_disetujui" id="fnpd_hargagrid$x<?= $Grid->RowIndex ?>_disetujui" value="<?= HtmlEncode($Grid->disetujui->FormValue) ?>">
<input type="hidden" data-table="npd_harga" data-field="x_disetujui" data-hidden="1" name="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_disetujui" id="fnpd_hargagrid$o<?= $Grid->RowIndex ?>_disetujui" value="<?= HtmlEncode($Grid->disetujui->OldValue) ?>">
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
loadjs.ready(["fnpd_hargagrid","load"], function () {
    fnpd_hargagrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_npd_harga", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el$rowindex$_npd_harga_idnpd" class="form-group npd_harga_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_npd_harga_idnpd" class="form-group npd_harga_idnpd">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_harga_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_harga"
        data-field="x_idnpd"
        data-value-separator="<?= $Grid->idnpd->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>"
        <?= $Grid->idnpd->editAttributes() ?>>
        <?= $Grid->idnpd->selectOptionListHtml("x{$Grid->RowIndex}_idnpd") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
<?= $Grid->idnpd->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_harga_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_harga_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_npd_harga_idnpd" class="form-group npd_harga_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglpengajuan->Visible) { // tglpengajuan ?>
        <td data-name="tglpengajuan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_harga_tglpengajuan" class="form-group npd_harga_tglpengajuan">
<input type="<?= $Grid->tglpengajuan->getInputTextType() ?>" data-table="npd_harga" data-field="x_tglpengajuan" name="x<?= $Grid->RowIndex ?>_tglpengajuan" id="x<?= $Grid->RowIndex ?>_tglpengajuan" placeholder="<?= HtmlEncode($Grid->tglpengajuan->getPlaceHolder()) ?>" value="<?= $Grid->tglpengajuan->EditValue ?>"<?= $Grid->tglpengajuan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglpengajuan->getErrorMessage() ?></div>
<?php if (!$Grid->tglpengajuan->ReadOnly && !$Grid->tglpengajuan->Disabled && !isset($Grid->tglpengajuan->EditAttrs["readonly"]) && !isset($Grid->tglpengajuan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_hargagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_hargagrid", "x<?= $Grid->RowIndex ?>_tglpengajuan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_harga_tglpengajuan" class="form-group npd_harga_tglpengajuan">
<span<?= $Grid->tglpengajuan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglpengajuan->getDisplayValue($Grid->tglpengajuan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_tglpengajuan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglpengajuan" id="x<?= $Grid->RowIndex ?>_tglpengajuan" value="<?= HtmlEncode($Grid->tglpengajuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_tglpengajuan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglpengajuan" id="o<?= $Grid->RowIndex ?>_tglpengajuan" value="<?= HtmlEncode($Grid->tglpengajuan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idnpd_sample->Visible) { // idnpd_sample ?>
        <td data-name="idnpd_sample">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_harga_idnpd_sample" class="form-group npd_harga_idnpd_sample">
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd_sample"
        name="x<?= $Grid->RowIndex ?>_idnpd_sample"
        class="form-control ew-select<?= $Grid->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample"
        data-table="npd_harga"
        data-field="x_idnpd_sample"
        data-value-separator="<?= $Grid->idnpd_sample->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->idnpd_sample->getPlaceHolder()) ?>"
        <?= $Grid->idnpd_sample->editAttributes() ?>>
        <?= $Grid->idnpd_sample->selectOptionListHtml("x{$Grid->RowIndex}_idnpd_sample") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idnpd_sample->getErrorMessage() ?></div>
<?= $Grid->idnpd_sample->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idnpd_sample") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd_sample", selectId: "npd_harga_x<?= $Grid->RowIndex ?>_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_harga_idnpd_sample" class="form-group npd_harga_idnpd_sample">
<span<?= $Grid->idnpd_sample->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd_sample->getDisplayValue($Grid->idnpd_sample->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd_sample" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd_sample" id="x<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_idnpd_sample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd_sample" id="o<?= $Grid->RowIndex ?>_idnpd_sample" value="<?= HtmlEncode($Grid->idnpd_sample->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->viskositasbarang->Visible) { // viskositasbarang ?>
        <td data-name="viskositasbarang">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_harga_viskositasbarang" class="form-group npd_harga_viskositasbarang">
<input type="<?= $Grid->viskositasbarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_viskositasbarang" name="x<?= $Grid->RowIndex ?>_viskositasbarang" id="x<?= $Grid->RowIndex ?>_viskositasbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->viskositasbarang->getPlaceHolder()) ?>" value="<?= $Grid->viskositasbarang->EditValue ?>"<?= $Grid->viskositasbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->viskositasbarang->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_harga_viskositasbarang" class="form-group npd_harga_viskositasbarang">
<span<?= $Grid->viskositasbarang->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->viskositasbarang->getDisplayValue($Grid->viskositasbarang->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_viskositasbarang" data-hidden="1" name="x<?= $Grid->RowIndex ?>_viskositasbarang" id="x<?= $Grid->RowIndex ?>_viskositasbarang" value="<?= HtmlEncode($Grid->viskositasbarang->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_viskositasbarang" data-hidden="1" name="o<?= $Grid->RowIndex ?>_viskositasbarang" id="o<?= $Grid->RowIndex ?>_viskositasbarang" value="<?= HtmlEncode($Grid->viskositasbarang->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idaplikasibarang->Visible) { // idaplikasibarang ?>
        <td data-name="idaplikasibarang">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_harga_idaplikasibarang" class="form-group npd_harga_idaplikasibarang">
<input type="<?= $Grid->idaplikasibarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_idaplikasibarang" name="x<?= $Grid->RowIndex ?>_idaplikasibarang" id="x<?= $Grid->RowIndex ?>_idaplikasibarang" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->idaplikasibarang->getPlaceHolder()) ?>" value="<?= $Grid->idaplikasibarang->EditValue ?>"<?= $Grid->idaplikasibarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idaplikasibarang->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_harga_idaplikasibarang" class="form-group npd_harga_idaplikasibarang">
<span<?= $Grid->idaplikasibarang->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idaplikasibarang->getDisplayValue($Grid->idaplikasibarang->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_idaplikasibarang" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idaplikasibarang" id="x<?= $Grid->RowIndex ?>_idaplikasibarang" value="<?= HtmlEncode($Grid->idaplikasibarang->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_idaplikasibarang" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idaplikasibarang" id="o<?= $Grid->RowIndex ?>_idaplikasibarang" value="<?= HtmlEncode($Grid->idaplikasibarang->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->hargapcs->Visible) { // hargapcs ?>
        <td data-name="hargapcs">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_harga_hargapcs" class="form-group npd_harga_hargapcs">
<input type="<?= $Grid->hargapcs->getInputTextType() ?>" data-table="npd_harga" data-field="x_hargapcs" name="x<?= $Grid->RowIndex ?>_hargapcs" id="x<?= $Grid->RowIndex ?>_hargapcs" size="30" placeholder="<?= HtmlEncode($Grid->hargapcs->getPlaceHolder()) ?>" value="<?= $Grid->hargapcs->EditValue ?>"<?= $Grid->hargapcs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hargapcs->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_harga_hargapcs" class="form-group npd_harga_hargapcs">
<span<?= $Grid->hargapcs->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->hargapcs->getDisplayValue($Grid->hargapcs->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_hargapcs" data-hidden="1" name="x<?= $Grid->RowIndex ?>_hargapcs" id="x<?= $Grid->RowIndex ?>_hargapcs" value="<?= HtmlEncode($Grid->hargapcs->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_hargapcs" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hargapcs" id="o<?= $Grid->RowIndex ?>_hargapcs" value="<?= HtmlEncode($Grid->hargapcs->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->disetujui->Visible) { // disetujui ?>
        <td data-name="disetujui">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_harga_disetujui" class="form-group npd_harga_disetujui">
<template id="tp_x<?= $Grid->RowIndex ?>_disetujui">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_harga" data-field="x_disetujui" name="x<?= $Grid->RowIndex ?>_disetujui" id="x<?= $Grid->RowIndex ?>_disetujui"<?= $Grid->disetujui->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_disetujui" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x<?= $Grid->RowIndex ?>_disetujui"
    name="x<?= $Grid->RowIndex ?>_disetujui"
    value="<?= HtmlEncode($Grid->disetujui->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_disetujui"
    data-target="dsl_x<?= $Grid->RowIndex ?>_disetujui"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->disetujui->isInvalidClass() ?>"
    data-table="npd_harga"
    data-field="x_disetujui"
    data-value-separator="<?= $Grid->disetujui->displayValueSeparatorAttribute() ?>"
    <?= $Grid->disetujui->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->disetujui->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_harga_disetujui" class="form-group npd_harga_disetujui">
<span<?= $Grid->disetujui->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->disetujui->getDisplayValue($Grid->disetujui->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_harga" data-field="x_disetujui" data-hidden="1" name="x<?= $Grid->RowIndex ?>_disetujui" id="x<?= $Grid->RowIndex ?>_disetujui" value="<?= HtmlEncode($Grid->disetujui->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_harga" data-field="x_disetujui" data-hidden="1" name="o<?= $Grid->RowIndex ?>_disetujui" id="o<?= $Grid->RowIndex ?>_disetujui" value="<?= HtmlEncode($Grid->disetujui->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnpd_hargagrid","load"], function() {
    fnpd_hargagrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fnpd_hargagrid">
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
    ew.addEventHandlers("npd_harga");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
