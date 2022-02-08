<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("IjinbpomDetailGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinbpom_detailgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fijinbpom_detailgrid = new ew.Form("fijinbpom_detailgrid", "grid");
    fijinbpom_detailgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinbpom_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinbpom_detail)
        ew.vars.tables.ijinbpom_detail = currentTable;
    fijinbpom_detailgrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["namaalt", [fields.namaalt.visible && fields.namaalt.required ? ew.Validators.required(fields.namaalt.caption) : null], fields.namaalt.isInvalid],
        ["idproduct_acuan", [fields.idproduct_acuan.visible && fields.idproduct_acuan.required ? ew.Validators.required(fields.idproduct_acuan.caption) : null, ew.Validators.integer], fields.idproduct_acuan.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null], fields.ukuran.isInvalid],
        ["kodesample", [fields.kodesample.visible && fields.kodesample.required ? ew.Validators.required(fields.kodesample.caption) : null], fields.kodesample.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinbpom_detailgrid,
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
    fijinbpom_detailgrid.validate = function () {
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
    fijinbpom_detailgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "namaalt", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idproduct_acuan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ukuran", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kodesample", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fijinbpom_detailgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinbpom_detailgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinbpom_detailgrid.lists.idnpd = <?= $Grid->idnpd->toClientList($Grid) ?>;
    fijinbpom_detailgrid.lists.idproduct_acuan = <?= $Grid->idproduct_acuan->toClientList($Grid) ?>;
    loadjs.done("fijinbpom_detailgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> ijinbpom_detail">
<div id="fijinbpom_detailgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_ijinbpom_detail" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_ijinbpom_detailgrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_ijinbpom_detail_idnpd" class="ijinbpom_detail_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Grid->nama->headerCellClass() ?>"><div id="elh_ijinbpom_detail_nama" class="ijinbpom_detail_nama"><?= $Grid->renderSort($Grid->nama) ?></div></th>
<?php } ?>
<?php if ($Grid->namaalt->Visible) { // namaalt ?>
        <th data-name="namaalt" class="<?= $Grid->namaalt->headerCellClass() ?>"><div id="elh_ijinbpom_detail_namaalt" class="ijinbpom_detail_namaalt"><?= $Grid->renderSort($Grid->namaalt) ?></div></th>
<?php } ?>
<?php if ($Grid->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <th data-name="idproduct_acuan" class="<?= $Grid->idproduct_acuan->headerCellClass() ?>"><div id="elh_ijinbpom_detail_idproduct_acuan" class="ijinbpom_detail_idproduct_acuan"><?= $Grid->renderSort($Grid->idproduct_acuan) ?></div></th>
<?php } ?>
<?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <th data-name="ukuran" class="<?= $Grid->ukuran->headerCellClass() ?>"><div id="elh_ijinbpom_detail_ukuran" class="ijinbpom_detail_ukuran"><?= $Grid->renderSort($Grid->ukuran) ?></div></th>
<?php } ?>
<?php if ($Grid->kodesample->Visible) { // kodesample ?>
        <th data-name="kodesample" class="<?= $Grid->kodesample->headerCellClass() ?>"><div id="elh_ijinbpom_detail_kodesample" class="ijinbpom_detail_kodesample"><?= $Grid->renderSort($Grid->kodesample) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_ijinbpom_detail", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="ijinbpom_detail"
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
    var el = document.querySelector("select[data-select2-id='ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom_detail.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="ijinbpom_detail"
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
    var el = document.querySelector("select[data-select2-id='ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom_detail.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idnpd" data-hidden="1" name="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_idnpd" id="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idnpd" data-hidden="1" name="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_idnpd" id="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Grid->nama->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<?= $Grid->nama->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_nama" data-hidden="1" name="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_nama" id="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<input type="hidden" data-table="ijinbpom_detail" data-field="x_nama" data-hidden="1" name="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_nama" id="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->namaalt->Visible) { // namaalt ?>
        <td data-name="namaalt" <?= $Grid->namaalt->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_namaalt" class="form-group">
<input type="<?= $Grid->namaalt->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_namaalt" name="x<?= $Grid->RowIndex ?>_namaalt" id="x<?= $Grid->RowIndex ?>_namaalt" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->namaalt->getPlaceHolder()) ?>" value="<?= $Grid->namaalt->EditValue ?>"<?= $Grid->namaalt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namaalt->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_namaalt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namaalt" id="o<?= $Grid->RowIndex ?>_namaalt" value="<?= HtmlEncode($Grid->namaalt->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_namaalt" class="form-group">
<input type="<?= $Grid->namaalt->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_namaalt" name="x<?= $Grid->RowIndex ?>_namaalt" id="x<?= $Grid->RowIndex ?>_namaalt" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->namaalt->getPlaceHolder()) ?>" value="<?= $Grid->namaalt->EditValue ?>"<?= $Grid->namaalt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namaalt->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_namaalt">
<span<?= $Grid->namaalt->viewAttributes() ?>>
<?= $Grid->namaalt->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_namaalt" data-hidden="1" name="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_namaalt" id="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_namaalt" value="<?= HtmlEncode($Grid->namaalt->FormValue) ?>">
<input type="hidden" data-table="ijinbpom_detail" data-field="x_namaalt" data-hidden="1" name="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_namaalt" id="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_namaalt" value="<?= HtmlEncode($Grid->namaalt->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <td data-name="idproduct_acuan" <?= $Grid->idproduct_acuan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_idproduct_acuan" class="form-group">
<?php
$onchange = $Grid->idproduct_acuan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->idproduct_acuan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_idproduct_acuan" class="ew-auto-suggest">
    <input type="<?= $Grid->idproduct_acuan->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" id="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= RemoveHtml($Grid->idproduct_acuan->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->idproduct_acuan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->idproduct_acuan->getPlaceHolder()) ?>"<?= $Grid->idproduct_acuan->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-input="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" data-value-separator="<?= $Grid->idproduct_acuan->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_idproduct_acuan" id="x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->idproduct_acuan->getErrorMessage() ?></div>
<script>
loadjs.ready(["fijinbpom_detailgrid"], function() {
    fijinbpom_detailgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_idproduct_acuan","forceSelect":false}, ew.vars.tables.ijinbpom_detail.fields.idproduct_acuan.autoSuggestOptions));
});
</script>
<?= $Grid->idproduct_acuan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idproduct_acuan") ?>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idproduct_acuan" id="o<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_idproduct_acuan" class="form-group">
<?php
$onchange = $Grid->idproduct_acuan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->idproduct_acuan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_idproduct_acuan" class="ew-auto-suggest">
    <input type="<?= $Grid->idproduct_acuan->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" id="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= RemoveHtml($Grid->idproduct_acuan->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->idproduct_acuan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->idproduct_acuan->getPlaceHolder()) ?>"<?= $Grid->idproduct_acuan->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-input="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" data-value-separator="<?= $Grid->idproduct_acuan->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_idproduct_acuan" id="x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->idproduct_acuan->getErrorMessage() ?></div>
<script>
loadjs.ready(["fijinbpom_detailgrid"], function() {
    fijinbpom_detailgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_idproduct_acuan","forceSelect":false}, ew.vars.tables.ijinbpom_detail.fields.idproduct_acuan.autoSuggestOptions));
});
</script>
<?= $Grid->idproduct_acuan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idproduct_acuan") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_idproduct_acuan">
<span<?= $Grid->idproduct_acuan->viewAttributes() ?>>
<?= $Grid->idproduct_acuan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-hidden="1" name="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_idproduct_acuan" id="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->FormValue) ?>">
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-hidden="1" name="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_idproduct_acuan" id="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran" <?= $Grid->ukuran->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_ukuran" class="form-group">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_ukuran" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran" id="o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_ukuran" class="form-group">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_ukuran">
<span<?= $Grid->ukuran->viewAttributes() ?>>
<?= $Grid->ukuran->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_ukuran" data-hidden="1" name="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_ukuran" id="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->FormValue) ?>">
<input type="hidden" data-table="ijinbpom_detail" data-field="x_ukuran" data-hidden="1" name="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_ukuran" id="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kodesample->Visible) { // kodesample ?>
        <td data-name="kodesample" <?= $Grid->kodesample->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_kodesample" class="form-group">
<input type="<?= $Grid->kodesample->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_kodesample" name="x<?= $Grid->RowIndex ?>_kodesample" id="x<?= $Grid->RowIndex ?>_kodesample" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kodesample->getPlaceHolder()) ?>" value="<?= $Grid->kodesample->EditValue ?>"<?= $Grid->kodesample->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kodesample->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_kodesample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kodesample" id="o<?= $Grid->RowIndex ?>_kodesample" value="<?= HtmlEncode($Grid->kodesample->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_kodesample" class="form-group">
<input type="<?= $Grid->kodesample->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_kodesample" name="x<?= $Grid->RowIndex ?>_kodesample" id="x<?= $Grid->RowIndex ?>_kodesample" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kodesample->getPlaceHolder()) ?>" value="<?= $Grid->kodesample->EditValue ?>"<?= $Grid->kodesample->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kodesample->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_ijinbpom_detail_kodesample">
<span<?= $Grid->kodesample->viewAttributes() ?>>
<?= $Grid->kodesample->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_kodesample" data-hidden="1" name="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_kodesample" id="fijinbpom_detailgrid$x<?= $Grid->RowIndex ?>_kodesample" value="<?= HtmlEncode($Grid->kodesample->FormValue) ?>">
<input type="hidden" data-table="ijinbpom_detail" data-field="x_kodesample" data-hidden="1" name="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_kodesample" id="fijinbpom_detailgrid$o<?= $Grid->RowIndex ?>_kodesample" value="<?= HtmlEncode($Grid->kodesample->OldValue) ?>">
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
loadjs.ready(["fijinbpom_detailgrid","load"], function () {
    fijinbpom_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_ijinbpom_detail", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_ijinbpom_detail_idnpd" class="form-group ijinbpom_detail_idnpd">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="ijinbpom_detail"
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
    var el = document.querySelector("select[data-select2-id='ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "ijinbpom_detail_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom_detail.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinbpom_detail_idnpd" class="form-group ijinbpom_detail_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinbpom_detail_nama" class="form-group ijinbpom_detail_nama">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinbpom_detail_nama" class="form-group ijinbpom_detail_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama->getDisplayValue($Grid->nama->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_nama" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->namaalt->Visible) { // namaalt ?>
        <td data-name="namaalt">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinbpom_detail_namaalt" class="form-group ijinbpom_detail_namaalt">
<input type="<?= $Grid->namaalt->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_namaalt" name="x<?= $Grid->RowIndex ?>_namaalt" id="x<?= $Grid->RowIndex ?>_namaalt" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->namaalt->getPlaceHolder()) ?>" value="<?= $Grid->namaalt->EditValue ?>"<?= $Grid->namaalt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namaalt->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinbpom_detail_namaalt" class="form-group ijinbpom_detail_namaalt">
<span<?= $Grid->namaalt->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->namaalt->getDisplayValue($Grid->namaalt->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_namaalt" data-hidden="1" name="x<?= $Grid->RowIndex ?>_namaalt" id="x<?= $Grid->RowIndex ?>_namaalt" value="<?= HtmlEncode($Grid->namaalt->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_namaalt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namaalt" id="o<?= $Grid->RowIndex ?>_namaalt" value="<?= HtmlEncode($Grid->namaalt->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <td data-name="idproduct_acuan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinbpom_detail_idproduct_acuan" class="form-group ijinbpom_detail_idproduct_acuan">
<?php
$onchange = $Grid->idproduct_acuan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->idproduct_acuan->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_idproduct_acuan" class="ew-auto-suggest">
    <input type="<?= $Grid->idproduct_acuan->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" id="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= RemoveHtml($Grid->idproduct_acuan->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->idproduct_acuan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->idproduct_acuan->getPlaceHolder()) ?>"<?= $Grid->idproduct_acuan->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-input="sv_x<?= $Grid->RowIndex ?>_idproduct_acuan" data-value-separator="<?= $Grid->idproduct_acuan->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_idproduct_acuan" id="x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->idproduct_acuan->getErrorMessage() ?></div>
<script>
loadjs.ready(["fijinbpom_detailgrid"], function() {
    fijinbpom_detailgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_idproduct_acuan","forceSelect":false}, ew.vars.tables.ijinbpom_detail.fields.idproduct_acuan.autoSuggestOptions));
});
</script>
<?= $Grid->idproduct_acuan->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idproduct_acuan") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinbpom_detail_idproduct_acuan" class="form-group ijinbpom_detail_idproduct_acuan">
<span<?= $Grid->idproduct_acuan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idproduct_acuan->getDisplayValue($Grid->idproduct_acuan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idproduct_acuan" id="x<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idproduct_acuan" id="o<?= $Grid->RowIndex ?>_idproduct_acuan" value="<?= HtmlEncode($Grid->idproduct_acuan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinbpom_detail_ukuran" class="form-group ijinbpom_detail_ukuran">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinbpom_detail_ukuran" class="form-group ijinbpom_detail_ukuran">
<span<?= $Grid->ukuran->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ukuran->getDisplayValue($Grid->ukuran->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_ukuran" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_ukuran" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran" id="o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kodesample->Visible) { // kodesample ?>
        <td data-name="kodesample">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_ijinbpom_detail_kodesample" class="form-group ijinbpom_detail_kodesample">
<input type="<?= $Grid->kodesample->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_kodesample" name="x<?= $Grid->RowIndex ?>_kodesample" id="x<?= $Grid->RowIndex ?>_kodesample" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->kodesample->getPlaceHolder()) ?>" value="<?= $Grid->kodesample->EditValue ?>"<?= $Grid->kodesample->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kodesample->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_ijinbpom_detail_kodesample" class="form-group ijinbpom_detail_kodesample">
<span<?= $Grid->kodesample->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kodesample->getDisplayValue($Grid->kodesample->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_kodesample" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kodesample" id="x<?= $Grid->RowIndex ?>_kodesample" value="<?= HtmlEncode($Grid->kodesample->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="ijinbpom_detail" data-field="x_kodesample" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kodesample" id="o<?= $Grid->RowIndex ?>_kodesample" value="<?= HtmlEncode($Grid->kodesample->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fijinbpom_detailgrid","load"], function() {
    fijinbpom_detailgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fijinbpom_detailgrid">
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
    ew.addEventHandlers("ijinbpom_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
