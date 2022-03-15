<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdummyAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdummyadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_confirmdummyadd = currentForm = new ew.Form("fnpd_confirmdummyadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirmdummy")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirmdummy)
        ew.vars.tables.npd_confirmdummy = currentTable;
    fnpd_confirmdummyadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["dummydepan", [fields.dummydepan.visible && fields.dummydepan.required ? ew.Validators.required(fields.dummydepan.caption) : null], fields.dummydepan.isInvalid],
        ["dummybelakang", [fields.dummybelakang.visible && fields.dummybelakang.required ? ew.Validators.required(fields.dummybelakang.caption) : null], fields.dummybelakang.isInvalid],
        ["dummyatas", [fields.dummyatas.visible && fields.dummyatas.required ? ew.Validators.required(fields.dummyatas.caption) : null], fields.dummyatas.isInvalid],
        ["dummysamping", [fields.dummysamping.visible && fields.dummysamping.required ? ew.Validators.required(fields.dummysamping.caption) : null], fields.dummysamping.isInvalid],
        ["catatan", [fields.catatan.visible && fields.catatan.required ? ew.Validators.required(fields.catatan.caption) : null], fields.catatan.isInvalid],
        ["ttd", [fields.ttd.visible && fields.ttd.required ? ew.Validators.required(fields.ttd.caption) : null, ew.Validators.datetime(0)], fields.ttd.isInvalid],
        ["submitted_by", [fields.submitted_by.visible && fields.submitted_by.required ? ew.Validators.required(fields.submitted_by.caption) : null, ew.Validators.integer], fields.submitted_by.isInvalid],
        ["checked1_by", [fields.checked1_by.visible && fields.checked1_by.required ? ew.Validators.required(fields.checked1_by.caption) : null], fields.checked1_by.isInvalid],
        ["checked2_by", [fields.checked2_by.visible && fields.checked2_by.required ? ew.Validators.required(fields.checked2_by.caption) : null, ew.Validators.integer], fields.checked2_by.isInvalid],
        ["approved_by", [fields.approved_by.visible && fields.approved_by.required ? ew.Validators.required(fields.approved_by.caption) : null], fields.approved_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmdummyadd,
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
    fnpd_confirmdummyadd.validate = function () {
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

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fnpd_confirmdummyadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmdummyadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_confirmdummyadd.lists.checked1_by = <?= $Page->checked1_by->toClientList($Page) ?>;
    fnpd_confirmdummyadd.lists.approved_by = <?= $Page->approved_by->toClientList($Page) ?>;
    loadjs.done("fnpd_confirmdummyadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_confirmdummyadd" id="fnpd_confirmdummyadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdummy">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_confirmdummy_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_idnpd"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_idnpd"><span id="el_npd_confirmdummy_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <div id="r_tglterima" class="form-group row">
        <label id="elh_npd_confirmdummy_tglterima" for="x_tglterima" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_tglterima"><?= $Page->tglterima->caption() ?><?= $Page->tglterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_tglterima"><span id="el_npd_confirmdummy_tglterima">
<input type="<?= $Page->tglterima->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_tglterima" name="x_tglterima" id="x_tglterima" placeholder="<?= HtmlEncode($Page->tglterima->getPlaceHolder()) ?>" value="<?= $Page->tglterima->EditValue ?>"<?= $Page->tglterima->editAttributes() ?> aria-describedby="x_tglterima_help">
<?= $Page->tglterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglterima->getErrorMessage() ?></div>
<?php if (!$Page->tglterima->ReadOnly && !$Page->tglterima->Disabled && !isset($Page->tglterima->EditAttrs["readonly"]) && !isset($Page->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdummyadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdummyadd", "x_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_npd_confirmdummy_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_tglsubmit"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_tglsubmit"><span id="el_npd_confirmdummy_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdummyadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdummyadd", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummydepan->Visible) { // dummydepan ?>
    <div id="r_dummydepan" class="form-group row">
        <label id="elh_npd_confirmdummy_dummydepan" for="x_dummydepan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_dummydepan"><?= $Page->dummydepan->caption() ?><?= $Page->dummydepan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummydepan->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummydepan"><span id="el_npd_confirmdummy_dummydepan">
<input type="<?= $Page->dummydepan->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummydepan" name="x_dummydepan" id="x_dummydepan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummydepan->getPlaceHolder()) ?>" value="<?= $Page->dummydepan->EditValue ?>"<?= $Page->dummydepan->editAttributes() ?> aria-describedby="x_dummydepan_help">
<?= $Page->dummydepan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummydepan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
    <div id="r_dummybelakang" class="form-group row">
        <label id="elh_npd_confirmdummy_dummybelakang" for="x_dummybelakang" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_dummybelakang"><?= $Page->dummybelakang->caption() ?><?= $Page->dummybelakang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummybelakang->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummybelakang"><span id="el_npd_confirmdummy_dummybelakang">
<input type="<?= $Page->dummybelakang->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummybelakang" name="x_dummybelakang" id="x_dummybelakang" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummybelakang->getPlaceHolder()) ?>" value="<?= $Page->dummybelakang->EditValue ?>"<?= $Page->dummybelakang->editAttributes() ?> aria-describedby="x_dummybelakang_help">
<?= $Page->dummybelakang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummybelakang->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummyatas->Visible) { // dummyatas ?>
    <div id="r_dummyatas" class="form-group row">
        <label id="elh_npd_confirmdummy_dummyatas" for="x_dummyatas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_dummyatas"><?= $Page->dummyatas->caption() ?><?= $Page->dummyatas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummyatas->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummyatas"><span id="el_npd_confirmdummy_dummyatas">
<input type="<?= $Page->dummyatas->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummyatas" name="x_dummyatas" id="x_dummyatas" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummyatas->getPlaceHolder()) ?>" value="<?= $Page->dummyatas->EditValue ?>"<?= $Page->dummyatas->editAttributes() ?> aria-describedby="x_dummyatas_help">
<?= $Page->dummyatas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummyatas->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummysamping->Visible) { // dummysamping ?>
    <div id="r_dummysamping" class="form-group row">
        <label id="elh_npd_confirmdummy_dummysamping" for="x_dummysamping" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_dummysamping"><?= $Page->dummysamping->caption() ?><?= $Page->dummysamping->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummysamping->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_dummysamping"><span id="el_npd_confirmdummy_dummysamping">
<input type="<?= $Page->dummysamping->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummysamping" name="x_dummysamping" id="x_dummysamping" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummysamping->getPlaceHolder()) ?>" value="<?= $Page->dummysamping->EditValue ?>"<?= $Page->dummysamping->editAttributes() ?> aria-describedby="x_dummysamping_help">
<?= $Page->dummysamping->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummysamping->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <div id="r_catatan" class="form-group row">
        <label id="elh_npd_confirmdummy_catatan" for="x_catatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_catatan"><?= $Page->catatan->caption() ?><?= $Page->catatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_catatan"><span id="el_npd_confirmdummy_catatan">
<textarea data-table="npd_confirmdummy" data-field="x_catatan" name="x_catatan" id="x_catatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatan->getPlaceHolder()) ?>"<?= $Page->catatan->editAttributes() ?> aria-describedby="x_catatan_help"><?= $Page->catatan->EditValue ?></textarea>
<?= $Page->catatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ttd->Visible) { // ttd ?>
    <div id="r_ttd" class="form-group row">
        <label id="elh_npd_confirmdummy_ttd" for="x_ttd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_ttd"><?= $Page->ttd->caption() ?><?= $Page->ttd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ttd->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_ttd"><span id="el_npd_confirmdummy_ttd">
<input type="<?= $Page->ttd->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_ttd" name="x_ttd" id="x_ttd" placeholder="<?= HtmlEncode($Page->ttd->getPlaceHolder()) ?>" value="<?= $Page->ttd->EditValue ?>"<?= $Page->ttd->editAttributes() ?> aria-describedby="x_ttd_help">
<?= $Page->ttd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ttd->getErrorMessage() ?></div>
<?php if (!$Page->ttd->ReadOnly && !$Page->ttd->Disabled && !isset($Page->ttd->EditAttrs["readonly"]) && !isset($Page->ttd->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdummyadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdummyadd", "x_ttd", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <div id="r_submitted_by" class="form-group row">
        <label id="elh_npd_confirmdummy_submitted_by" for="x_submitted_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_submitted_by"><?= $Page->submitted_by->caption() ?><?= $Page->submitted_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_submitted_by"><span id="el_npd_confirmdummy_submitted_by">
<input type="<?= $Page->submitted_by->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_submitted_by" name="x_submitted_by" id="x_submitted_by" size="30" placeholder="<?= HtmlEncode($Page->submitted_by->getPlaceHolder()) ?>" value="<?= $Page->submitted_by->EditValue ?>"<?= $Page->submitted_by->editAttributes() ?> aria-describedby="x_submitted_by_help">
<?= $Page->submitted_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->submitted_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
    <div id="r_checked1_by" class="form-group row">
        <label id="elh_npd_confirmdummy_checked1_by" for="x_checked1_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_checked1_by"><?= $Page->checked1_by->caption() ?><?= $Page->checked1_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked1_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_checked1_by"><span id="el_npd_confirmdummy_checked1_by">
    <select
        id="x_checked1_by"
        name="x_checked1_by"
        class="form-control ew-select<?= $Page->checked1_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmdummy_x_checked1_by"
        data-table="npd_confirmdummy"
        data-field="x_checked1_by"
        data-value-separator="<?= $Page->checked1_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->checked1_by->getPlaceHolder()) ?>"
        <?= $Page->checked1_by->editAttributes() ?>>
        <?= $Page->checked1_by->selectOptionListHtml("x_checked1_by") ?>
    </select>
    <?= $Page->checked1_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->checked1_by->getErrorMessage() ?></div>
<?= $Page->checked1_by->Lookup->getParamTag($Page, "p_x_checked1_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirmdummy_x_checked1_by']"),
        options = { name: "x_checked1_by", selectId: "npd_confirmdummy_x_checked1_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmdummy.fields.checked1_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
    <div id="r_checked2_by" class="form-group row">
        <label id="elh_npd_confirmdummy_checked2_by" for="x_checked2_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_checked2_by"><?= $Page->checked2_by->caption() ?><?= $Page->checked2_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked2_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_checked2_by"><span id="el_npd_confirmdummy_checked2_by">
<input type="<?= $Page->checked2_by->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_checked2_by" name="x_checked2_by" id="x_checked2_by" size="30" placeholder="<?= HtmlEncode($Page->checked2_by->getPlaceHolder()) ?>" value="<?= $Page->checked2_by->EditValue ?>"<?= $Page->checked2_by->editAttributes() ?> aria-describedby="x_checked2_by_help">
<?= $Page->checked2_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->checked2_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_npd_confirmdummy_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdummy_approved_by"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdummy_approved_by"><span id="el_npd_confirmdummy_approved_by">
    <select
        id="x_approved_by"
        name="x_approved_by"
        class="form-control ew-select<?= $Page->approved_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmdummy_x_approved_by"
        data-table="npd_confirmdummy"
        data-field="x_approved_by"
        data-value-separator="<?= $Page->approved_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->approved_by->getPlaceHolder()) ?>"
        <?= $Page->approved_by->editAttributes() ?>>
        <?= $Page->approved_by->selectOptionListHtml("x_approved_by") ?>
    </select>
    <?= $Page->approved_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->approved_by->getErrorMessage() ?></div>
<?= $Page->approved_by->Lookup->getParamTag($Page, "p_x_approved_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirmdummy_x_approved_by']"),
        options = { name: "x_approved_by", selectId: "npd_confirmdummy_x_approved_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmdummy.fields.approved_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_npd_confirmdummyadd" class="ew-custom-template"></div>
<template id="tpm_npd_confirmdummyadd">
<div id="ct_NpdConfirmdummyAdd"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_confirmdummy_idnpd"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right">Kode Customer</label>
                    <div class="col-8"><input type="text" id="c_customer" class="form-control" placeholder="Kode Customer" disabled></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right">Status</label>
                    <div class="col-8"><input type="text" id="c_status" class="form-control" placeholder="Status" disabled></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglterima->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_tglterima"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglsubmit->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_tglsubmit"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">FOTO DUMMY PROTOTYPE</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->dummydepan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_dummydepan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->dummybelakang->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_dummybelakang"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->dummyatas->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_dummyatas"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->dummysamping->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_dummysamping"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->catatan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_catatan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->ttd->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_ttd"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">VALIDASI</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->submitted_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_submitted_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked1_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_checked1_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked2_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_checked2_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->approved_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdummy_approved_by"></slot></div>
            </div>
        </div>
    </div>
</div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npd_confirmdummyadd", "tpm_npd_confirmdummyadd", "npd_confirmdummyadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("npd_confirmdummy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("select[name=x_idnpd]").change((function(){$.ajax({url:"api/npd_customer/"+$(this).val(),type:"GET",success:function(a){!1!==a.success&&($("#c_customer").val(a.data.kodecustomer+", "+a.data.namacustomer),$("#c_status").val(a.data.status))}})}));
});
</script>
