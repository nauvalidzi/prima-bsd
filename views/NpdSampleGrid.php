<?php

namespace PHPMaker2021\production2;

// Set up and run Grid object
$Grid = Container("NpdSampleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_samplegrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnpd_samplegrid = new ew.Form("fnpd_samplegrid", "grid");
    fnpd_samplegrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_sample")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_sample)
        ew.vars.tables.npd_sample = currentTable;
    fnpd_samplegrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["sediaan", [fields.sediaan.visible && fields.sediaan.required ? ew.Validators.required(fields.sediaan.caption) : null], fields.sediaan.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null], fields.ukuran.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["bau", [fields.bau.visible && fields.bau.required ? ew.Validators.required(fields.bau.caption) : null], fields.bau.isInvalid],
        ["fungsi", [fields.fungsi.visible && fields.fungsi.required ? ew.Validators.required(fields.fungsi.caption) : null], fields.fungsi.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_samplegrid,
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
    fnpd_samplegrid.validate = function () {
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
    fnpd_samplegrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kode", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sediaan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ukuran", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "warna", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bau", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fungsi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlah", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnpd_samplegrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_samplegrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_samplegrid.lists.idnpd = <?= $Grid->idnpd->toClientList($Grid) ?>;
    loadjs.done("fnpd_samplegrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_sample">
<div id="fnpd_samplegrid" class="ew-form ew-list-form form-inline">
<div id="gmp_npd_sample" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_npd_samplegrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_npd_sample_idnpd" class="npd_sample_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->kode->Visible) { // kode ?>
        <th data-name="kode" class="<?= $Grid->kode->headerCellClass() ?>"><div id="elh_npd_sample_kode" class="npd_sample_kode"><?= $Grid->renderSort($Grid->kode) ?></div></th>
<?php } ?>
<?php if ($Grid->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Grid->nama->headerCellClass() ?>"><div id="elh_npd_sample_nama" class="npd_sample_nama"><?= $Grid->renderSort($Grid->nama) ?></div></th>
<?php } ?>
<?php if ($Grid->sediaan->Visible) { // sediaan ?>
        <th data-name="sediaan" class="<?= $Grid->sediaan->headerCellClass() ?>"><div id="elh_npd_sample_sediaan" class="npd_sample_sediaan"><?= $Grid->renderSort($Grid->sediaan) ?></div></th>
<?php } ?>
<?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <th data-name="ukuran" class="<?= $Grid->ukuran->headerCellClass() ?>"><div id="elh_npd_sample_ukuran" class="npd_sample_ukuran"><?= $Grid->renderSort($Grid->ukuran) ?></div></th>
<?php } ?>
<?php if ($Grid->warna->Visible) { // warna ?>
        <th data-name="warna" class="<?= $Grid->warna->headerCellClass() ?>"><div id="elh_npd_sample_warna" class="npd_sample_warna"><?= $Grid->renderSort($Grid->warna) ?></div></th>
<?php } ?>
<?php if ($Grid->bau->Visible) { // bau ?>
        <th data-name="bau" class="<?= $Grid->bau->headerCellClass() ?>"><div id="elh_npd_sample_bau" class="npd_sample_bau"><?= $Grid->renderSort($Grid->bau) ?></div></th>
<?php } ?>
<?php if ($Grid->fungsi->Visible) { // fungsi ?>
        <th data-name="fungsi" class="<?= $Grid->fungsi->headerCellClass() ?>"><div id="elh_npd_sample_fungsi" class="npd_sample_fungsi"><?= $Grid->renderSort($Grid->fungsi) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <th data-name="jumlah" class="<?= $Grid->jumlah->headerCellClass() ?>"><div id="elh_npd_sample_jumlah" class="npd_sample_jumlah"><?= $Grid->renderSort($Grid->jumlah) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_npd_sample", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_npd_sample_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_sample_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_sample"
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
    var el = document.querySelector("select[data-select2-id='npd_sample_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_sample_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_sample.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_idnpd" class="form-group">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_sample_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_sample"
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
    var el = document.querySelector("select[data-select2-id='npd_sample_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_sample_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_sample.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_idnpd" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_idnpd" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_idnpd" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_idnpd" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode" <?= $Grid->kode->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="npd_sample" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_kode" class="form-group">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="npd_sample" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<?= $Grid->kode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_kode" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_kode" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_kode" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_kode" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Grid->nama->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="npd_sample" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="npd_sample" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<?= $Grid->nama->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_nama" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_nama" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_nama" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_nama" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sediaan->Visible) { // sediaan ?>
        <td data-name="sediaan" <?= $Grid->sediaan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_sediaan" class="form-group">
<input type="<?= $Grid->sediaan->getInputTextType() ?>" data-table="npd_sample" data-field="x_sediaan" name="x<?= $Grid->RowIndex ?>_sediaan" id="x<?= $Grid->RowIndex ?>_sediaan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->sediaan->getPlaceHolder()) ?>" value="<?= $Grid->sediaan->EditValue ?>"<?= $Grid->sediaan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sediaan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_sediaan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sediaan" id="o<?= $Grid->RowIndex ?>_sediaan" value="<?= HtmlEncode($Grid->sediaan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_sediaan" class="form-group">
<input type="<?= $Grid->sediaan->getInputTextType() ?>" data-table="npd_sample" data-field="x_sediaan" name="x<?= $Grid->RowIndex ?>_sediaan" id="x<?= $Grid->RowIndex ?>_sediaan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->sediaan->getPlaceHolder()) ?>" value="<?= $Grid->sediaan->EditValue ?>"<?= $Grid->sediaan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sediaan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_sediaan">
<span<?= $Grid->sediaan->viewAttributes() ?>>
<?= $Grid->sediaan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_sediaan" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_sediaan" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_sediaan" value="<?= HtmlEncode($Grid->sediaan->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_sediaan" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_sediaan" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_sediaan" value="<?= HtmlEncode($Grid->sediaan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran" <?= $Grid->ukuran->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_ukuran" class="form-group">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="npd_sample" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_ukuran" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran" id="o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_ukuran" class="form-group">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="npd_sample" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_ukuran">
<span<?= $Grid->ukuran->viewAttributes() ?>>
<?= $Grid->ukuran->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_ukuran" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_ukuran" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_ukuran" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_ukuran" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->warna->Visible) { // warna ?>
        <td data-name="warna" <?= $Grid->warna->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_warna" class="form-group">
<input type="<?= $Grid->warna->getInputTextType() ?>" data-table="npd_sample" data-field="x_warna" name="x<?= $Grid->RowIndex ?>_warna" id="x<?= $Grid->RowIndex ?>_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->warna->getPlaceHolder()) ?>" value="<?= $Grid->warna->EditValue ?>"<?= $Grid->warna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->warna->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_warna" data-hidden="1" name="o<?= $Grid->RowIndex ?>_warna" id="o<?= $Grid->RowIndex ?>_warna" value="<?= HtmlEncode($Grid->warna->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_warna" class="form-group">
<input type="<?= $Grid->warna->getInputTextType() ?>" data-table="npd_sample" data-field="x_warna" name="x<?= $Grid->RowIndex ?>_warna" id="x<?= $Grid->RowIndex ?>_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->warna->getPlaceHolder()) ?>" value="<?= $Grid->warna->EditValue ?>"<?= $Grid->warna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->warna->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_warna">
<span<?= $Grid->warna->viewAttributes() ?>>
<?= $Grid->warna->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_warna" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_warna" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_warna" value="<?= HtmlEncode($Grid->warna->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_warna" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_warna" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_warna" value="<?= HtmlEncode($Grid->warna->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bau->Visible) { // bau ?>
        <td data-name="bau" <?= $Grid->bau->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_bau" class="form-group">
<input type="<?= $Grid->bau->getInputTextType() ?>" data-table="npd_sample" data-field="x_bau" name="x<?= $Grid->RowIndex ?>_bau" id="x<?= $Grid->RowIndex ?>_bau" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->bau->getPlaceHolder()) ?>" value="<?= $Grid->bau->EditValue ?>"<?= $Grid->bau->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bau->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_bau" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bau" id="o<?= $Grid->RowIndex ?>_bau" value="<?= HtmlEncode($Grid->bau->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_bau" class="form-group">
<input type="<?= $Grid->bau->getInputTextType() ?>" data-table="npd_sample" data-field="x_bau" name="x<?= $Grid->RowIndex ?>_bau" id="x<?= $Grid->RowIndex ?>_bau" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->bau->getPlaceHolder()) ?>" value="<?= $Grid->bau->EditValue ?>"<?= $Grid->bau->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bau->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_bau">
<span<?= $Grid->bau->viewAttributes() ?>>
<?= $Grid->bau->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_bau" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_bau" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_bau" value="<?= HtmlEncode($Grid->bau->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_bau" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_bau" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_bau" value="<?= HtmlEncode($Grid->bau->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fungsi->Visible) { // fungsi ?>
        <td data-name="fungsi" <?= $Grid->fungsi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_fungsi" class="form-group">
<input type="<?= $Grid->fungsi->getInputTextType() ?>" data-table="npd_sample" data-field="x_fungsi" name="x<?= $Grid->RowIndex ?>_fungsi" id="x<?= $Grid->RowIndex ?>_fungsi" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->fungsi->getPlaceHolder()) ?>" value="<?= $Grid->fungsi->EditValue ?>"<?= $Grid->fungsi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fungsi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_fungsi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fungsi" id="o<?= $Grid->RowIndex ?>_fungsi" value="<?= HtmlEncode($Grid->fungsi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_fungsi" class="form-group">
<input type="<?= $Grid->fungsi->getInputTextType() ?>" data-table="npd_sample" data-field="x_fungsi" name="x<?= $Grid->RowIndex ?>_fungsi" id="x<?= $Grid->RowIndex ?>_fungsi" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->fungsi->getPlaceHolder()) ?>" value="<?= $Grid->fungsi->EditValue ?>"<?= $Grid->fungsi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fungsi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_fungsi">
<span<?= $Grid->fungsi->viewAttributes() ?>>
<?= $Grid->fungsi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_fungsi" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_fungsi" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_fungsi" value="<?= HtmlEncode($Grid->fungsi->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_fungsi" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_fungsi" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_fungsi" value="<?= HtmlEncode($Grid->fungsi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah" <?= $Grid->jumlah->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="npd_sample" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_jumlah" class="form-group">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="npd_sample" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_sample_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<?= $Grid->jumlah->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_sample" data-field="x_jumlah" data-hidden="1" name="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_jumlah" id="fnpd_samplegrid$x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<input type="hidden" data-table="npd_sample" data-field="x_jumlah" data-hidden="1" name="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_jumlah" id="fnpd_samplegrid$o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
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
loadjs.ready(["fnpd_samplegrid","load"], function () {
    fnpd_samplegrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_npd_sample", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_npd_sample_idnpd" class="form-group npd_sample_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_npd_sample_idnpd" class="form-group npd_sample_idnpd">
<?php $Grid->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idnpd"
        name="x<?= $Grid->RowIndex ?>_idnpd"
        class="form-control ew-select<?= $Grid->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_sample_x<?= $Grid->RowIndex ?>_idnpd"
        data-table="npd_sample"
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
    var el = document.querySelector("select[data-select2-id='npd_sample_x<?= $Grid->RowIndex ?>_idnpd']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idnpd", selectId: "npd_sample_x<?= $Grid->RowIndex ?>_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_sample.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_idnpd" class="form-group npd_sample_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kode->Visible) { // kode ?>
        <td data-name="kode">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_kode" class="form-group npd_sample_kode">
<input type="<?= $Grid->kode->getInputTextType() ?>" data-table="npd_sample" data-field="x_kode" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->kode->getPlaceHolder()) ?>" value="<?= $Grid->kode->EditValue ?>"<?= $Grid->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kode->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_kode" class="form-group npd_sample_kode">
<span<?= $Grid->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kode->getDisplayValue($Grid->kode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_kode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kode" id="x<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_kode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kode" id="o<?= $Grid->RowIndex ?>_kode" value="<?= HtmlEncode($Grid->kode->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_nama" class="form-group npd_sample_nama">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="npd_sample" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->nama->getPlaceHolder()) ?>" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_nama" class="form-group npd_sample_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama->getDisplayValue($Grid->nama->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_nama" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sediaan->Visible) { // sediaan ?>
        <td data-name="sediaan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_sediaan" class="form-group npd_sample_sediaan">
<input type="<?= $Grid->sediaan->getInputTextType() ?>" data-table="npd_sample" data-field="x_sediaan" name="x<?= $Grid->RowIndex ?>_sediaan" id="x<?= $Grid->RowIndex ?>_sediaan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->sediaan->getPlaceHolder()) ?>" value="<?= $Grid->sediaan->EditValue ?>"<?= $Grid->sediaan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sediaan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_sediaan" class="form-group npd_sample_sediaan">
<span<?= $Grid->sediaan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sediaan->getDisplayValue($Grid->sediaan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_sediaan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sediaan" id="x<?= $Grid->RowIndex ?>_sediaan" value="<?= HtmlEncode($Grid->sediaan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_sediaan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sediaan" id="o<?= $Grid->RowIndex ?>_sediaan" value="<?= HtmlEncode($Grid->sediaan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ukuran->Visible) { // ukuran ?>
        <td data-name="ukuran">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_ukuran" class="form-group npd_sample_ukuran">
<input type="<?= $Grid->ukuran->getInputTextType() ?>" data-table="npd_sample" data-field="x_ukuran" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->ukuran->getPlaceHolder()) ?>" value="<?= $Grid->ukuran->EditValue ?>"<?= $Grid->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_ukuran" class="form-group npd_sample_ukuran">
<span<?= $Grid->ukuran->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ukuran->getDisplayValue($Grid->ukuran->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_ukuran" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ukuran" id="x<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_ukuran" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran" id="o<?= $Grid->RowIndex ?>_ukuran" value="<?= HtmlEncode($Grid->ukuran->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->warna->Visible) { // warna ?>
        <td data-name="warna">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_warna" class="form-group npd_sample_warna">
<input type="<?= $Grid->warna->getInputTextType() ?>" data-table="npd_sample" data-field="x_warna" name="x<?= $Grid->RowIndex ?>_warna" id="x<?= $Grid->RowIndex ?>_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->warna->getPlaceHolder()) ?>" value="<?= $Grid->warna->EditValue ?>"<?= $Grid->warna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->warna->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_warna" class="form-group npd_sample_warna">
<span<?= $Grid->warna->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->warna->getDisplayValue($Grid->warna->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_warna" data-hidden="1" name="x<?= $Grid->RowIndex ?>_warna" id="x<?= $Grid->RowIndex ?>_warna" value="<?= HtmlEncode($Grid->warna->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_warna" data-hidden="1" name="o<?= $Grid->RowIndex ?>_warna" id="o<?= $Grid->RowIndex ?>_warna" value="<?= HtmlEncode($Grid->warna->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bau->Visible) { // bau ?>
        <td data-name="bau">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_bau" class="form-group npd_sample_bau">
<input type="<?= $Grid->bau->getInputTextType() ?>" data-table="npd_sample" data-field="x_bau" name="x<?= $Grid->RowIndex ?>_bau" id="x<?= $Grid->RowIndex ?>_bau" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->bau->getPlaceHolder()) ?>" value="<?= $Grid->bau->EditValue ?>"<?= $Grid->bau->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bau->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_bau" class="form-group npd_sample_bau">
<span<?= $Grid->bau->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bau->getDisplayValue($Grid->bau->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_bau" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bau" id="x<?= $Grid->RowIndex ?>_bau" value="<?= HtmlEncode($Grid->bau->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_bau" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bau" id="o<?= $Grid->RowIndex ?>_bau" value="<?= HtmlEncode($Grid->bau->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fungsi->Visible) { // fungsi ?>
        <td data-name="fungsi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_fungsi" class="form-group npd_sample_fungsi">
<input type="<?= $Grid->fungsi->getInputTextType() ?>" data-table="npd_sample" data-field="x_fungsi" name="x<?= $Grid->RowIndex ?>_fungsi" id="x<?= $Grid->RowIndex ?>_fungsi" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->fungsi->getPlaceHolder()) ?>" value="<?= $Grid->fungsi->EditValue ?>"<?= $Grid->fungsi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fungsi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_fungsi" class="form-group npd_sample_fungsi">
<span<?= $Grid->fungsi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fungsi->getDisplayValue($Grid->fungsi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_fungsi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fungsi" id="x<?= $Grid->RowIndex ?>_fungsi" value="<?= HtmlEncode($Grid->fungsi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_fungsi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fungsi" id="o<?= $Grid->RowIndex ?>_fungsi" value="<?= HtmlEncode($Grid->fungsi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_sample_jumlah" class="form-group npd_sample_jumlah">
<input type="<?= $Grid->jumlah->getInputTextType() ?>" data-table="npd_sample" data-field="x_jumlah" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" size="30" placeholder="<?= HtmlEncode($Grid->jumlah->getPlaceHolder()) ?>" value="<?= $Grid->jumlah->EditValue ?>"<?= $Grid->jumlah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlah->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_sample_jumlah" class="form-group npd_sample_jumlah">
<span<?= $Grid->jumlah->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlah->getDisplayValue($Grid->jumlah->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_sample" data-field="x_jumlah" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlah" id="x<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_sample" data-field="x_jumlah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlah" id="o<?= $Grid->RowIndex ?>_jumlah" value="<?= HtmlEncode($Grid->jumlah->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnpd_samplegrid","load"], function() {
    fnpd_samplegrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fnpd_samplegrid">
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
    ew.addEventHandlers("npd_sample");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
