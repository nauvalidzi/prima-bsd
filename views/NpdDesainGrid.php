<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("NpdDesainGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_desaingrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnpd_desaingrid = new ew.Form("fnpd_desaingrid", "grid");
    fnpd_desaingrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_desain")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_desain)
        ew.vars.tables.npd_desain = currentTable;
    fnpd_desaingrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["nama_produk", [fields.nama_produk.visible && fields.nama_produk.required ? ew.Validators.required(fields.nama_produk.caption) : null], fields.nama_produk.isInvalid],
        ["konsepwarna", [fields.konsepwarna.visible && fields.konsepwarna.required ? ew.Validators.required(fields.konsepwarna.caption) : null], fields.konsepwarna.isInvalid],
        ["no_notifikasi", [fields.no_notifikasi.visible && fields.no_notifikasi.required ? ew.Validators.required(fields.no_notifikasi.caption) : null], fields.no_notifikasi.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_desaingrid,
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
    fnpd_desaingrid.validate = function () {
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
    fnpd_desaingrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglterima", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglsubmit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama_produk", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "konsepwarna", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "no_notifikasi", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnpd_desaingrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_desaingrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnpd_desaingrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_desain">
<div id="fnpd_desaingrid" class="ew-form ew-list-form form-inline">
<div id="gmp_npd_desain" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_npd_desaingrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_npd_desain_idnpd" class="npd_desain_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->tglterima->Visible) { // tglterima ?>
        <th data-name="tglterima" class="<?= $Grid->tglterima->headerCellClass() ?>"><div id="elh_npd_desain_tglterima" class="npd_desain_tglterima"><?= $Grid->renderSort($Grid->tglterima) ?></div></th>
<?php } ?>
<?php if ($Grid->tglsubmit->Visible) { // tglsubmit ?>
        <th data-name="tglsubmit" class="<?= $Grid->tglsubmit->headerCellClass() ?>"><div id="elh_npd_desain_tglsubmit" class="npd_desain_tglsubmit"><?= $Grid->renderSort($Grid->tglsubmit) ?></div></th>
<?php } ?>
<?php if ($Grid->nama_produk->Visible) { // nama_produk ?>
        <th data-name="nama_produk" class="<?= $Grid->nama_produk->headerCellClass() ?>"><div id="elh_npd_desain_nama_produk" class="npd_desain_nama_produk"><?= $Grid->renderSort($Grid->nama_produk) ?></div></th>
<?php } ?>
<?php if ($Grid->konsepwarna->Visible) { // konsepwarna ?>
        <th data-name="konsepwarna" class="<?= $Grid->konsepwarna->headerCellClass() ?>"><div id="elh_npd_desain_konsepwarna" class="npd_desain_konsepwarna"><?= $Grid->renderSort($Grid->konsepwarna) ?></div></th>
<?php } ?>
<?php if ($Grid->no_notifikasi->Visible) { // no_notifikasi ?>
        <th data-name="no_notifikasi" class="<?= $Grid->no_notifikasi->headerCellClass() ?>"><div id="elh_npd_desain_no_notifikasi" class="npd_desain_no_notifikasi"><?= $Grid->renderSort($Grid->no_notifikasi) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_npd_desain", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_desain" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_desain" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_idnpd" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_idnpd" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglterima->Visible) { // tglterima ?>
        <td data-name="tglterima" <?= $Grid->tglterima->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tglterima" class="form-group">
<input type="<?= $Grid->tglterima->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglterima" name="x<?= $Grid->RowIndex ?>_tglterima" id="x<?= $Grid->RowIndex ?>_tglterima" placeholder="<?= HtmlEncode($Grid->tglterima->getPlaceHolder()) ?>" value="<?= $Grid->tglterima->EditValue ?>"<?= $Grid->tglterima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglterima->getErrorMessage() ?></div>
<?php if (!$Grid->tglterima->ReadOnly && !$Grid->tglterima->Disabled && !isset($Grid->tglterima->EditAttrs["readonly"]) && !isset($Grid->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tglterima" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglterima" id="o<?= $Grid->RowIndex ?>_tglterima" value="<?= HtmlEncode($Grid->tglterima->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tglterima" class="form-group">
<input type="<?= $Grid->tglterima->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglterima" name="x<?= $Grid->RowIndex ?>_tglterima" id="x<?= $Grid->RowIndex ?>_tglterima" placeholder="<?= HtmlEncode($Grid->tglterima->getPlaceHolder()) ?>" value="<?= $Grid->tglterima->EditValue ?>"<?= $Grid->tglterima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglterima->getErrorMessage() ?></div>
<?php if (!$Grid->tglterima->ReadOnly && !$Grid->tglterima->Disabled && !isset($Grid->tglterima->EditAttrs["readonly"]) && !isset($Grid->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tglterima">
<span<?= $Grid->tglterima->viewAttributes() ?>>
<?= $Grid->tglterima->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_tglterima" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tglterima" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tglterima" value="<?= HtmlEncode($Grid->tglterima->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_tglterima" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tglterima" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tglterima" value="<?= HtmlEncode($Grid->tglterima->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglsubmit->Visible) { // tglsubmit ?>
        <td data-name="tglsubmit" <?= $Grid->tglsubmit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tglsubmit" class="form-group">
<input type="<?= $Grid->tglsubmit->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglsubmit" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" placeholder="<?= HtmlEncode($Grid->tglsubmit->getPlaceHolder()) ?>" value="<?= $Grid->tglsubmit->EditValue ?>"<?= $Grid->tglsubmit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Grid->tglsubmit->ReadOnly && !$Grid->tglsubmit->Disabled && !isset($Grid->tglsubmit->EditAttrs["readonly"]) && !isset($Grid->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tglsubmit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglsubmit" id="o<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tglsubmit" class="form-group">
<input type="<?= $Grid->tglsubmit->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglsubmit" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" placeholder="<?= HtmlEncode($Grid->tglsubmit->getPlaceHolder()) ?>" value="<?= $Grid->tglsubmit->EditValue ?>"<?= $Grid->tglsubmit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Grid->tglsubmit->ReadOnly && !$Grid->tglsubmit->Disabled && !isset($Grid->tglsubmit->EditAttrs["readonly"]) && !isset($Grid->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_tglsubmit">
<span<?= $Grid->tglsubmit->viewAttributes() ?>>
<?= $Grid->tglsubmit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_tglsubmit" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tglsubmit" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_tglsubmit" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tglsubmit" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama_produk->Visible) { // nama_produk ?>
        <td data-name="nama_produk" <?= $Grid->nama_produk->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_nama_produk" class="form-group">
<input type="<?= $Grid->nama_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_nama_produk" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_produk->getPlaceHolder()) ?>" value="<?= $Grid->nama_produk->EditValue ?>"<?= $Grid->nama_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_produk->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_produk" id="o<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_nama_produk" class="form-group">
<input type="<?= $Grid->nama_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_nama_produk" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_produk->getPlaceHolder()) ?>" value="<?= $Grid->nama_produk->EditValue ?>"<?= $Grid->nama_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_produk->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_nama_produk">
<span<?= $Grid->nama_produk->viewAttributes() ?>>
<?= $Grid->nama_produk->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_nama_produk" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_nama_produk" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->konsepwarna->Visible) { // konsepwarna ?>
        <td data-name="konsepwarna" <?= $Grid->konsepwarna->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_konsepwarna" class="form-group">
<input type="<?= $Grid->konsepwarna->getInputTextType() ?>" data-table="npd_desain" data-field="x_konsepwarna" name="x<?= $Grid->RowIndex ?>_konsepwarna" id="x<?= $Grid->RowIndex ?>_konsepwarna" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->konsepwarna->getPlaceHolder()) ?>" value="<?= $Grid->konsepwarna->EditValue ?>"<?= $Grid->konsepwarna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->konsepwarna->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_konsepwarna" data-hidden="1" name="o<?= $Grid->RowIndex ?>_konsepwarna" id="o<?= $Grid->RowIndex ?>_konsepwarna" value="<?= HtmlEncode($Grid->konsepwarna->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_konsepwarna" class="form-group">
<input type="<?= $Grid->konsepwarna->getInputTextType() ?>" data-table="npd_desain" data-field="x_konsepwarna" name="x<?= $Grid->RowIndex ?>_konsepwarna" id="x<?= $Grid->RowIndex ?>_konsepwarna" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->konsepwarna->getPlaceHolder()) ?>" value="<?= $Grid->konsepwarna->EditValue ?>"<?= $Grid->konsepwarna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->konsepwarna->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_konsepwarna">
<span<?= $Grid->konsepwarna->viewAttributes() ?>>
<?= $Grid->konsepwarna->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_konsepwarna" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_konsepwarna" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_konsepwarna" value="<?= HtmlEncode($Grid->konsepwarna->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_konsepwarna" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_konsepwarna" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_konsepwarna" value="<?= HtmlEncode($Grid->konsepwarna->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->no_notifikasi->Visible) { // no_notifikasi ?>
        <td data-name="no_notifikasi" <?= $Grid->no_notifikasi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_no_notifikasi" class="form-group">
<input type="<?= $Grid->no_notifikasi->getInputTextType() ?>" data-table="npd_desain" data-field="x_no_notifikasi" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->no_notifikasi->getPlaceHolder()) ?>" value="<?= $Grid->no_notifikasi->EditValue ?>"<?= $Grid->no_notifikasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->no_notifikasi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_no_notifikasi" id="o<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_no_notifikasi" class="form-group">
<input type="<?= $Grid->no_notifikasi->getInputTextType() ?>" data-table="npd_desain" data-field="x_no_notifikasi" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->no_notifikasi->getPlaceHolder()) ?>" value="<?= $Grid->no_notifikasi->EditValue ?>"<?= $Grid->no_notifikasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->no_notifikasi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_desain_no_notifikasi">
<span<?= $Grid->no_notifikasi->viewAttributes() ?>>
<?= $Grid->no_notifikasi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_no_notifikasi" id="fnpd_desaingrid$x<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->FormValue) ?>">
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_no_notifikasi" id="fnpd_desaingrid$o<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->OldValue) ?>">
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
loadjs.ready(["fnpd_desaingrid","load"], function () {
    fnpd_desaingrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_npd_desain", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_npd_desain_idnpd" class="form-group npd_desain_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_npd_desain_idnpd" class="form-group npd_desain_idnpd">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_desain" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_idnpd" class="form-group npd_desain_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglterima->Visible) { // tglterima ?>
        <td data-name="tglterima">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_tglterima" class="form-group npd_desain_tglterima">
<input type="<?= $Grid->tglterima->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglterima" name="x<?= $Grid->RowIndex ?>_tglterima" id="x<?= $Grid->RowIndex ?>_tglterima" placeholder="<?= HtmlEncode($Grid->tglterima->getPlaceHolder()) ?>" value="<?= $Grid->tglterima->EditValue ?>"<?= $Grid->tglterima->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglterima->getErrorMessage() ?></div>
<?php if (!$Grid->tglterima->ReadOnly && !$Grid->tglterima->Disabled && !isset($Grid->tglterima->EditAttrs["readonly"]) && !isset($Grid->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_tglterima" class="form-group npd_desain_tglterima">
<span<?= $Grid->tglterima->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglterima->getDisplayValue($Grid->tglterima->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tglterima" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglterima" id="x<?= $Grid->RowIndex ?>_tglterima" value="<?= HtmlEncode($Grid->tglterima->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_tglterima" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglterima" id="o<?= $Grid->RowIndex ?>_tglterima" value="<?= HtmlEncode($Grid->tglterima->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglsubmit->Visible) { // tglsubmit ?>
        <td data-name="tglsubmit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_tglsubmit" class="form-group npd_desain_tglsubmit">
<input type="<?= $Grid->tglsubmit->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglsubmit" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" placeholder="<?= HtmlEncode($Grid->tglsubmit->getPlaceHolder()) ?>" value="<?= $Grid->tglsubmit->EditValue ?>"<?= $Grid->tglsubmit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Grid->tglsubmit->ReadOnly && !$Grid->tglsubmit->Disabled && !isset($Grid->tglsubmit->EditAttrs["readonly"]) && !isset($Grid->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desaingrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desaingrid", "x<?= $Grid->RowIndex ?>_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_tglsubmit" class="form-group npd_desain_tglsubmit">
<span<?= $Grid->tglsubmit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglsubmit->getDisplayValue($Grid->tglsubmit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_tglsubmit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_tglsubmit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglsubmit" id="o<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama_produk->Visible) { // nama_produk ?>
        <td data-name="nama_produk">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_nama_produk" class="form-group npd_desain_nama_produk">
<input type="<?= $Grid->nama_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_nama_produk" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->nama_produk->getPlaceHolder()) ?>" value="<?= $Grid->nama_produk->EditValue ?>"<?= $Grid->nama_produk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama_produk->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_nama_produk" class="form-group npd_desain_nama_produk">
<span<?= $Grid->nama_produk->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama_produk->getDisplayValue($Grid->nama_produk->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama_produk" id="x<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_nama_produk" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama_produk" id="o<?= $Grid->RowIndex ?>_nama_produk" value="<?= HtmlEncode($Grid->nama_produk->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->konsepwarna->Visible) { // konsepwarna ?>
        <td data-name="konsepwarna">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_konsepwarna" class="form-group npd_desain_konsepwarna">
<input type="<?= $Grid->konsepwarna->getInputTextType() ?>" data-table="npd_desain" data-field="x_konsepwarna" name="x<?= $Grid->RowIndex ?>_konsepwarna" id="x<?= $Grid->RowIndex ?>_konsepwarna" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->konsepwarna->getPlaceHolder()) ?>" value="<?= $Grid->konsepwarna->EditValue ?>"<?= $Grid->konsepwarna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->konsepwarna->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_konsepwarna" class="form-group npd_desain_konsepwarna">
<span<?= $Grid->konsepwarna->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->konsepwarna->getDisplayValue($Grid->konsepwarna->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_konsepwarna" data-hidden="1" name="x<?= $Grid->RowIndex ?>_konsepwarna" id="x<?= $Grid->RowIndex ?>_konsepwarna" value="<?= HtmlEncode($Grid->konsepwarna->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_konsepwarna" data-hidden="1" name="o<?= $Grid->RowIndex ?>_konsepwarna" id="o<?= $Grid->RowIndex ?>_konsepwarna" value="<?= HtmlEncode($Grid->konsepwarna->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->no_notifikasi->Visible) { // no_notifikasi ?>
        <td data-name="no_notifikasi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_desain_no_notifikasi" class="form-group npd_desain_no_notifikasi">
<input type="<?= $Grid->no_notifikasi->getInputTextType() ?>" data-table="npd_desain" data-field="x_no_notifikasi" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->no_notifikasi->getPlaceHolder()) ?>" value="<?= $Grid->no_notifikasi->EditValue ?>"<?= $Grid->no_notifikasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->no_notifikasi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_desain_no_notifikasi" class="form-group npd_desain_no_notifikasi">
<span<?= $Grid->no_notifikasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->no_notifikasi->getDisplayValue($Grid->no_notifikasi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_no_notifikasi" id="x<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_desain" data-field="x_no_notifikasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_no_notifikasi" id="o<?= $Grid->RowIndex ?>_no_notifikasi" value="<?= HtmlEncode($Grid->no_notifikasi->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnpd_desaingrid","load"], function() {
    fnpd_desaingrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fnpd_desaingrid">
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
    ew.addEventHandlers("npd_desain");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
