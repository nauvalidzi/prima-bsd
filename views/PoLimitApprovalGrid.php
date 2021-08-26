<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("PoLimitApprovalGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpo_limit_approvalgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fpo_limit_approvalgrid = new ew.Form("fpo_limit_approvalgrid", "grid");
    fpo_limit_approvalgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "po_limit_approval")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.po_limit_approval)
        ew.vars.tables.po_limit_approval = currentTable;
    fpo_limit_approvalgrid.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["limit_kredit", [fields.limit_kredit.visible && fields.limit_kredit.required ? ew.Validators.required(fields.limit_kredit.caption) : null, ew.Validators.integer], fields.limit_kredit.isInvalid],
        ["limit_po_aktif", [fields.limit_po_aktif.visible && fields.limit_po_aktif.required ? ew.Validators.required(fields.limit_po_aktif.caption) : null, ew.Validators.integer], fields.limit_po_aktif.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(1)], fields.created_at.isInvalid],
        ["sisalimitkredit", [fields.sisalimitkredit.visible && fields.sisalimitkredit.required ? ew.Validators.required(fields.sisalimitkredit.caption) : null], fields.sisalimitkredit.isInvalid],
        ["sisapoaktif", [fields.sisapoaktif.visible && fields.sisapoaktif.required ? ew.Validators.required(fields.sisapoaktif.caption) : null], fields.sisapoaktif.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpo_limit_approvalgrid,
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
    fpo_limit_approvalgrid.validate = function () {
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
    fpo_limit_approvalgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idpegawai", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idcustomer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "limit_kredit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "limit_po_aktif", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_at", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisalimitkredit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sisapoaktif", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fpo_limit_approvalgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpo_limit_approvalgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpo_limit_approvalgrid.lists.idpegawai = <?= $Grid->idpegawai->toClientList($Grid) ?>;
    fpo_limit_approvalgrid.lists.idcustomer = <?= $Grid->idcustomer->toClientList($Grid) ?>;
    loadjs.done("fpo_limit_approvalgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> po_limit_approval">
<div id="fpo_limit_approvalgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_po_limit_approval" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_po_limit_approvalgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <th data-name="idpegawai" class="<?= $Grid->idpegawai->headerCellClass() ?>"><div id="elh_po_limit_approval_idpegawai" class="po_limit_approval_idpegawai"><?= $Grid->renderSort($Grid->idpegawai) ?></div></th>
<?php } ?>
<?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <th data-name="idcustomer" class="<?= $Grid->idcustomer->headerCellClass() ?>"><div id="elh_po_limit_approval_idcustomer" class="po_limit_approval_idcustomer"><?= $Grid->renderSort($Grid->idcustomer) ?></div></th>
<?php } ?>
<?php if ($Grid->limit_kredit->Visible) { // limit_kredit ?>
        <th data-name="limit_kredit" class="<?= $Grid->limit_kredit->headerCellClass() ?>"><div id="elh_po_limit_approval_limit_kredit" class="po_limit_approval_limit_kredit"><?= $Grid->renderSort($Grid->limit_kredit) ?></div></th>
<?php } ?>
<?php if ($Grid->limit_po_aktif->Visible) { // limit_po_aktif ?>
        <th data-name="limit_po_aktif" class="<?= $Grid->limit_po_aktif->headerCellClass() ?>"><div id="elh_po_limit_approval_limit_po_aktif" class="po_limit_approval_limit_po_aktif"><?= $Grid->renderSort($Grid->limit_po_aktif) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_po_limit_approval_created_at" class="po_limit_approval_created_at"><?= $Grid->renderSort($Grid->created_at) ?></div></th>
<?php } ?>
<?php if ($Grid->sisalimitkredit->Visible) { // sisalimitkredit ?>
        <th data-name="sisalimitkredit" class="<?= $Grid->sisalimitkredit->headerCellClass() ?>"><div id="elh_po_limit_approval_sisalimitkredit" class="po_limit_approval_sisalimitkredit"><?= $Grid->renderSort($Grid->sisalimitkredit) ?></div></th>
<?php } ?>
<?php if ($Grid->sisapoaktif->Visible) { // sisapoaktif ?>
        <th data-name="sisapoaktif" class="<?= $Grid->sisapoaktif->headerCellClass() ?>"><div id="elh_po_limit_approval_sisapoaktif" class="po_limit_approval_sisapoaktif"><?= $Grid->renderSort($Grid->sisapoaktif) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_po_limit_approval", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai" <?= $Grid->idpegawai->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_idpegawai" class="form-group">
<?php $Grid->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="po_limit_approval"
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
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_idpegawai" class="form-group">
<?php $Grid->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="po_limit_approval"
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
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<?= $Grid->idpegawai->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_idpegawai" data-hidden="1" name="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_idpegawai" id="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval" data-field="x_idpegawai" data-hidden="1" name="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_idpegawai" id="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer" <?= $Grid->idcustomer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_idcustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="po_limit_approval"
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
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_idcustomer" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="po_limit_approval"
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
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<?= $Grid->idcustomer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_idcustomer" data-hidden="1" name="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_idcustomer" id="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval" data-field="x_idcustomer" data-hidden="1" name="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_idcustomer" id="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->limit_kredit->Visible) { // limit_kredit ?>
        <td data-name="limit_kredit" <?= $Grid->limit_kredit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_limit_kredit" class="form-group">
<input type="<?= $Grid->limit_kredit->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_kredit" name="x<?= $Grid->RowIndex ?>_limit_kredit" id="x<?= $Grid->RowIndex ?>_limit_kredit" size="30" placeholder="<?= HtmlEncode($Grid->limit_kredit->getPlaceHolder()) ?>" value="<?= $Grid->limit_kredit->EditValue ?>"<?= $Grid->limit_kredit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->limit_kredit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_kredit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_limit_kredit" id="o<?= $Grid->RowIndex ?>_limit_kredit" value="<?= HtmlEncode($Grid->limit_kredit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_limit_kredit" class="form-group">
<input type="<?= $Grid->limit_kredit->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_kredit" name="x<?= $Grid->RowIndex ?>_limit_kredit" id="x<?= $Grid->RowIndex ?>_limit_kredit" size="30" placeholder="<?= HtmlEncode($Grid->limit_kredit->getPlaceHolder()) ?>" value="<?= $Grid->limit_kredit->EditValue ?>"<?= $Grid->limit_kredit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->limit_kredit->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_limit_kredit">
<span<?= $Grid->limit_kredit->viewAttributes() ?>>
<?= $Grid->limit_kredit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_kredit" data-hidden="1" name="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_limit_kredit" id="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_limit_kredit" value="<?= HtmlEncode($Grid->limit_kredit->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_kredit" data-hidden="1" name="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_limit_kredit" id="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_limit_kredit" value="<?= HtmlEncode($Grid->limit_kredit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->limit_po_aktif->Visible) { // limit_po_aktif ?>
        <td data-name="limit_po_aktif" <?= $Grid->limit_po_aktif->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_limit_po_aktif" class="form-group">
<input type="<?= $Grid->limit_po_aktif->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_po_aktif" name="x<?= $Grid->RowIndex ?>_limit_po_aktif" id="x<?= $Grid->RowIndex ?>_limit_po_aktif" size="30" placeholder="<?= HtmlEncode($Grid->limit_po_aktif->getPlaceHolder()) ?>" value="<?= $Grid->limit_po_aktif->EditValue ?>"<?= $Grid->limit_po_aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->limit_po_aktif->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_po_aktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_limit_po_aktif" id="o<?= $Grid->RowIndex ?>_limit_po_aktif" value="<?= HtmlEncode($Grid->limit_po_aktif->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_limit_po_aktif" class="form-group">
<input type="<?= $Grid->limit_po_aktif->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_po_aktif" name="x<?= $Grid->RowIndex ?>_limit_po_aktif" id="x<?= $Grid->RowIndex ?>_limit_po_aktif" size="30" placeholder="<?= HtmlEncode($Grid->limit_po_aktif->getPlaceHolder()) ?>" value="<?= $Grid->limit_po_aktif->EditValue ?>"<?= $Grid->limit_po_aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->limit_po_aktif->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_limit_po_aktif">
<span<?= $Grid->limit_po_aktif->viewAttributes() ?>>
<?= $Grid->limit_po_aktif->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_po_aktif" data-hidden="1" name="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_limit_po_aktif" id="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_limit_po_aktif" value="<?= HtmlEncode($Grid->limit_po_aktif->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_po_aktif" data-hidden="1" name="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_limit_po_aktif" id="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_limit_po_aktif" value="<?= HtmlEncode($Grid->limit_po_aktif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_created_at" data-format="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpo_limit_approvalgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpo_limit_approvalgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":1});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_created_at" data-format="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpo_limit_approvalgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpo_limit_approvalgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":1});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_created_at" data-hidden="1" name="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_created_at" id="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval" data-field="x_created_at" data-hidden="1" name="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_created_at" id="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisalimitkredit->Visible) { // sisalimitkredit ?>
        <td data-name="sisalimitkredit" <?= $Grid->sisalimitkredit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_sisalimitkredit" class="form-group">
<input type="<?= $Grid->sisalimitkredit->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_sisalimitkredit" name="x<?= $Grid->RowIndex ?>_sisalimitkredit" id="x<?= $Grid->RowIndex ?>_sisalimitkredit" size="30" placeholder="<?= HtmlEncode($Grid->sisalimitkredit->getPlaceHolder()) ?>" value="<?= $Grid->sisalimitkredit->EditValue ?>"<?= $Grid->sisalimitkredit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisalimitkredit->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisalimitkredit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisalimitkredit" id="o<?= $Grid->RowIndex ?>_sisalimitkredit" value="<?= HtmlEncode($Grid->sisalimitkredit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_sisalimitkredit" class="form-group">
<span<?= $Grid->sisalimitkredit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisalimitkredit->getDisplayValue($Grid->sisalimitkredit->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisalimitkredit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisalimitkredit" id="x<?= $Grid->RowIndex ?>_sisalimitkredit" value="<?= HtmlEncode($Grid->sisalimitkredit->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_sisalimitkredit">
<span<?= $Grid->sisalimitkredit->viewAttributes() ?>>
<?= $Grid->sisalimitkredit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisalimitkredit" data-hidden="1" name="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_sisalimitkredit" id="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_sisalimitkredit" value="<?= HtmlEncode($Grid->sisalimitkredit->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval" data-field="x_sisalimitkredit" data-hidden="1" name="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_sisalimitkredit" id="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_sisalimitkredit" value="<?= HtmlEncode($Grid->sisalimitkredit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sisapoaktif->Visible) { // sisapoaktif ?>
        <td data-name="sisapoaktif" <?= $Grid->sisapoaktif->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_sisapoaktif" class="form-group">
<input type="<?= $Grid->sisapoaktif->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_sisapoaktif" name="x<?= $Grid->RowIndex ?>_sisapoaktif" id="x<?= $Grid->RowIndex ?>_sisapoaktif" size="30" placeholder="<?= HtmlEncode($Grid->sisapoaktif->getPlaceHolder()) ?>" value="<?= $Grid->sisapoaktif->EditValue ?>"<?= $Grid->sisapoaktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisapoaktif->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisapoaktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisapoaktif" id="o<?= $Grid->RowIndex ?>_sisapoaktif" value="<?= HtmlEncode($Grid->sisapoaktif->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_sisapoaktif" class="form-group">
<span<?= $Grid->sisapoaktif->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisapoaktif->getDisplayValue($Grid->sisapoaktif->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisapoaktif" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisapoaktif" id="x<?= $Grid->RowIndex ?>_sisapoaktif" value="<?= HtmlEncode($Grid->sisapoaktif->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_po_limit_approval_sisapoaktif">
<span<?= $Grid->sisapoaktif->viewAttributes() ?>>
<?= $Grid->sisapoaktif->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisapoaktif" data-hidden="1" name="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_sisapoaktif" id="fpo_limit_approvalgrid$x<?= $Grid->RowIndex ?>_sisapoaktif" value="<?= HtmlEncode($Grid->sisapoaktif->FormValue) ?>">
<input type="hidden" data-table="po_limit_approval" data-field="x_sisapoaktif" data-hidden="1" name="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_sisapoaktif" id="fpo_limit_approvalgrid$o<?= $Grid->RowIndex ?>_sisapoaktif" value="<?= HtmlEncode($Grid->sisapoaktif->OldValue) ?>">
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
loadjs.ready(["fpo_limit_approvalgrid","load"], function () {
    fpo_limit_approvalgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_po_limit_approval", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->idpegawai->Visible) { // idpegawai ?>
        <td data-name="idpegawai">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_idpegawai" class="form-group po_limit_approval_idpegawai">
<?php $Grid->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idpegawai"
        name="x<?= $Grid->RowIndex ?>_idpegawai"
        class="form-control ew-select<?= $Grid->idpegawai->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai"
        data-table="po_limit_approval"
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
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idpegawai", selectId: "po_limit_approval_x<?= $Grid->RowIndex ?>_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_idpegawai" class="form-group po_limit_approval_idpegawai">
<span<?= $Grid->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idpegawai->getDisplayValue($Grid->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_idpegawai" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idpegawai" id="x<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_idpegawai" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idpegawai" id="o<?= $Grid->RowIndex ?>_idpegawai" value="<?= HtmlEncode($Grid->idpegawai->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idcustomer->Visible) { // idcustomer ?>
        <td data-name="idcustomer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_idcustomer" class="form-group po_limit_approval_idcustomer">
    <select
        id="x<?= $Grid->RowIndex ?>_idcustomer"
        name="x<?= $Grid->RowIndex ?>_idcustomer"
        class="form-control ew-select<?= $Grid->idcustomer->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer"
        data-table="po_limit_approval"
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
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idcustomer", selectId: "po_limit_approval_x<?= $Grid->RowIndex ?>_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_idcustomer" class="form-group po_limit_approval_idcustomer">
<span<?= $Grid->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idcustomer->getDisplayValue($Grid->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_idcustomer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idcustomer" id="x<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_idcustomer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idcustomer" id="o<?= $Grid->RowIndex ?>_idcustomer" value="<?= HtmlEncode($Grid->idcustomer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->limit_kredit->Visible) { // limit_kredit ?>
        <td data-name="limit_kredit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_limit_kredit" class="form-group po_limit_approval_limit_kredit">
<input type="<?= $Grid->limit_kredit->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_kredit" name="x<?= $Grid->RowIndex ?>_limit_kredit" id="x<?= $Grid->RowIndex ?>_limit_kredit" size="30" placeholder="<?= HtmlEncode($Grid->limit_kredit->getPlaceHolder()) ?>" value="<?= $Grid->limit_kredit->EditValue ?>"<?= $Grid->limit_kredit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->limit_kredit->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_limit_kredit" class="form-group po_limit_approval_limit_kredit">
<span<?= $Grid->limit_kredit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->limit_kredit->getDisplayValue($Grid->limit_kredit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_kredit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_limit_kredit" id="x<?= $Grid->RowIndex ?>_limit_kredit" value="<?= HtmlEncode($Grid->limit_kredit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_kredit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_limit_kredit" id="o<?= $Grid->RowIndex ?>_limit_kredit" value="<?= HtmlEncode($Grid->limit_kredit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->limit_po_aktif->Visible) { // limit_po_aktif ?>
        <td data-name="limit_po_aktif">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_limit_po_aktif" class="form-group po_limit_approval_limit_po_aktif">
<input type="<?= $Grid->limit_po_aktif->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_po_aktif" name="x<?= $Grid->RowIndex ?>_limit_po_aktif" id="x<?= $Grid->RowIndex ?>_limit_po_aktif" size="30" placeholder="<?= HtmlEncode($Grid->limit_po_aktif->getPlaceHolder()) ?>" value="<?= $Grid->limit_po_aktif->EditValue ?>"<?= $Grid->limit_po_aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->limit_po_aktif->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_limit_po_aktif" class="form-group po_limit_approval_limit_po_aktif">
<span<?= $Grid->limit_po_aktif->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->limit_po_aktif->getDisplayValue($Grid->limit_po_aktif->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_po_aktif" data-hidden="1" name="x<?= $Grid->RowIndex ?>_limit_po_aktif" id="x<?= $Grid->RowIndex ?>_limit_po_aktif" value="<?= HtmlEncode($Grid->limit_po_aktif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_limit_po_aktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_limit_po_aktif" id="o<?= $Grid->RowIndex ?>_limit_po_aktif" value="<?= HtmlEncode($Grid->limit_po_aktif->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_created_at" class="form-group po_limit_approval_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_created_at" data-format="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpo_limit_approvalgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpo_limit_approvalgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":1});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_created_at" class="form-group po_limit_approval_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_at->getDisplayValue($Grid->created_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_created_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisalimitkredit->Visible) { // sisalimitkredit ?>
        <td data-name="sisalimitkredit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_sisalimitkredit" class="form-group po_limit_approval_sisalimitkredit">
<input type="<?= $Grid->sisalimitkredit->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_sisalimitkredit" name="x<?= $Grid->RowIndex ?>_sisalimitkredit" id="x<?= $Grid->RowIndex ?>_sisalimitkredit" size="30" placeholder="<?= HtmlEncode($Grid->sisalimitkredit->getPlaceHolder()) ?>" value="<?= $Grid->sisalimitkredit->EditValue ?>"<?= $Grid->sisalimitkredit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisalimitkredit->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_sisalimitkredit" class="form-group po_limit_approval_sisalimitkredit">
<span<?= $Grid->sisalimitkredit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisalimitkredit->getDisplayValue($Grid->sisalimitkredit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisalimitkredit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisalimitkredit" id="x<?= $Grid->RowIndex ?>_sisalimitkredit" value="<?= HtmlEncode($Grid->sisalimitkredit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisalimitkredit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisalimitkredit" id="o<?= $Grid->RowIndex ?>_sisalimitkredit" value="<?= HtmlEncode($Grid->sisalimitkredit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sisapoaktif->Visible) { // sisapoaktif ?>
        <td data-name="sisapoaktif">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_po_limit_approval_sisapoaktif" class="form-group po_limit_approval_sisapoaktif">
<input type="<?= $Grid->sisapoaktif->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_sisapoaktif" name="x<?= $Grid->RowIndex ?>_sisapoaktif" id="x<?= $Grid->RowIndex ?>_sisapoaktif" size="30" placeholder="<?= HtmlEncode($Grid->sisapoaktif->getPlaceHolder()) ?>" value="<?= $Grid->sisapoaktif->EditValue ?>"<?= $Grid->sisapoaktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sisapoaktif->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_po_limit_approval_sisapoaktif" class="form-group po_limit_approval_sisapoaktif">
<span<?= $Grid->sisapoaktif->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->sisapoaktif->getDisplayValue($Grid->sisapoaktif->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisapoaktif" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sisapoaktif" id="x<?= $Grid->RowIndex ?>_sisapoaktif" value="<?= HtmlEncode($Grid->sisapoaktif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="po_limit_approval" data-field="x_sisapoaktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sisapoaktif" id="o<?= $Grid->RowIndex ?>_sisapoaktif" value="<?= HtmlEncode($Grid->sisapoaktif->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fpo_limit_approvalgrid","load"], function() {
    fpo_limit_approvalgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fpo_limit_approvalgrid">
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
    ew.addEventHandlers("po_limit_approval");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
