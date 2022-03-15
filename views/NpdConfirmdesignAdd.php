<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdesignAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdesignadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_confirmdesignadd = currentForm = new ew.Form("fnpd_confirmdesignadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirmdesign")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirmdesign)
        ew.vars.tables.npd_confirmdesign = currentTable;
    fnpd_confirmdesignadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["desaindepan", [fields.desaindepan.visible && fields.desaindepan.required ? ew.Validators.required(fields.desaindepan.caption) : null], fields.desaindepan.isInvalid],
        ["desainbelakang", [fields.desainbelakang.visible && fields.desainbelakang.required ? ew.Validators.required(fields.desainbelakang.caption) : null], fields.desainbelakang.isInvalid],
        ["catatan", [fields.catatan.visible && fields.catatan.required ? ew.Validators.required(fields.catatan.caption) : null], fields.catatan.isInvalid],
        ["tglprimer", [fields.tglprimer.visible && fields.tglprimer.required ? ew.Validators.required(fields.tglprimer.caption) : null, ew.Validators.datetime(0)], fields.tglprimer.isInvalid],
        ["desainsekunder", [fields.desainsekunder.visible && fields.desainsekunder.required ? ew.Validators.required(fields.desainsekunder.caption) : null], fields.desainsekunder.isInvalid],
        ["catatansekunder", [fields.catatansekunder.visible && fields.catatansekunder.required ? ew.Validators.required(fields.catatansekunder.caption) : null], fields.catatansekunder.isInvalid],
        ["tglsekunder", [fields.tglsekunder.visible && fields.tglsekunder.required ? ew.Validators.required(fields.tglsekunder.caption) : null, ew.Validators.datetime(0)], fields.tglsekunder.isInvalid],
        ["submitted_by", [fields.submitted_by.visible && fields.submitted_by.required ? ew.Validators.required(fields.submitted_by.caption) : null, ew.Validators.integer], fields.submitted_by.isInvalid],
        ["checked1_by", [fields.checked1_by.visible && fields.checked1_by.required ? ew.Validators.required(fields.checked1_by.caption) : null, ew.Validators.integer], fields.checked1_by.isInvalid],
        ["checked2_by", [fields.checked2_by.visible && fields.checked2_by.required ? ew.Validators.required(fields.checked2_by.caption) : null, ew.Validators.integer], fields.checked2_by.isInvalid],
        ["approved_by", [fields.approved_by.visible && fields.approved_by.required ? ew.Validators.required(fields.approved_by.caption) : null], fields.approved_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmdesignadd,
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
    fnpd_confirmdesignadd.validate = function () {
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
    fnpd_confirmdesignadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmdesignadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_confirmdesignadd.lists.approved_by = <?= $Page->approved_by->toClientList($Page) ?>;
    loadjs.done("fnpd_confirmdesignadd");
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
<form name="fnpd_confirmdesignadd" id="fnpd_confirmdesignadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdesign">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_confirmdesign_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_idnpd"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_idnpd"><span id="el_npd_confirmdesign_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <div id="r_tglterima" class="form-group row">
        <label id="elh_npd_confirmdesign_tglterima" for="x_tglterima" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_tglterima"><?= $Page->tglterima->caption() ?><?= $Page->tglterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglterima"><span id="el_npd_confirmdesign_tglterima">
<input type="<?= $Page->tglterima->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_tglterima" name="x_tglterima" id="x_tglterima" placeholder="<?= HtmlEncode($Page->tglterima->getPlaceHolder()) ?>" value="<?= $Page->tglterima->EditValue ?>"<?= $Page->tglterima->editAttributes() ?> aria-describedby="x_tglterima_help">
<?= $Page->tglterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglterima->getErrorMessage() ?></div>
<?php if (!$Page->tglterima->ReadOnly && !$Page->tglterima->Disabled && !isset($Page->tglterima->EditAttrs["readonly"]) && !isset($Page->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdesignadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdesignadd", "x_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_npd_confirmdesign_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_tglsubmit"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglsubmit"><span id="el_npd_confirmdesign_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdesignadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdesignadd", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desaindepan->Visible) { // desaindepan ?>
    <div id="r_desaindepan" class="form-group row">
        <label id="elh_npd_confirmdesign_desaindepan" for="x_desaindepan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_desaindepan"><?= $Page->desaindepan->caption() ?><?= $Page->desaindepan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desaindepan->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_desaindepan"><span id="el_npd_confirmdesign_desaindepan">
<input type="<?= $Page->desaindepan->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_desaindepan" name="x_desaindepan" id="x_desaindepan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desaindepan->getPlaceHolder()) ?>" value="<?= $Page->desaindepan->EditValue ?>"<?= $Page->desaindepan->editAttributes() ?> aria-describedby="x_desaindepan_help">
<?= $Page->desaindepan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desaindepan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainbelakang->Visible) { // desainbelakang ?>
    <div id="r_desainbelakang" class="form-group row">
        <label id="elh_npd_confirmdesign_desainbelakang" for="x_desainbelakang" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_desainbelakang"><?= $Page->desainbelakang->caption() ?><?= $Page->desainbelakang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainbelakang->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_desainbelakang"><span id="el_npd_confirmdesign_desainbelakang">
<input type="<?= $Page->desainbelakang->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_desainbelakang" name="x_desainbelakang" id="x_desainbelakang" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desainbelakang->getPlaceHolder()) ?>" value="<?= $Page->desainbelakang->EditValue ?>"<?= $Page->desainbelakang->editAttributes() ?> aria-describedby="x_desainbelakang_help">
<?= $Page->desainbelakang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainbelakang->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <div id="r_catatan" class="form-group row">
        <label id="elh_npd_confirmdesign_catatan" for="x_catatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_catatan"><?= $Page->catatan->caption() ?><?= $Page->catatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_catatan"><span id="el_npd_confirmdesign_catatan">
<textarea data-table="npd_confirmdesign" data-field="x_catatan" name="x_catatan" id="x_catatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatan->getPlaceHolder()) ?>"<?= $Page->catatan->editAttributes() ?> aria-describedby="x_catatan_help"><?= $Page->catatan->EditValue ?></textarea>
<?= $Page->catatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglprimer->Visible) { // tglprimer ?>
    <div id="r_tglprimer" class="form-group row">
        <label id="elh_npd_confirmdesign_tglprimer" for="x_tglprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_tglprimer"><?= $Page->tglprimer->caption() ?><?= $Page->tglprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglprimer"><span id="el_npd_confirmdesign_tglprimer">
<input type="<?= $Page->tglprimer->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_tglprimer" name="x_tglprimer" id="x_tglprimer" placeholder="<?= HtmlEncode($Page->tglprimer->getPlaceHolder()) ?>" value="<?= $Page->tglprimer->EditValue ?>"<?= $Page->tglprimer->editAttributes() ?> aria-describedby="x_tglprimer_help">
<?= $Page->tglprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglprimer->getErrorMessage() ?></div>
<?php if (!$Page->tglprimer->ReadOnly && !$Page->tglprimer->Disabled && !isset($Page->tglprimer->EditAttrs["readonly"]) && !isset($Page->tglprimer->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdesignadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdesignadd", "x_tglprimer", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
    <div id="r_desainsekunder" class="form-group row">
        <label id="elh_npd_confirmdesign_desainsekunder" for="x_desainsekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_desainsekunder"><?= $Page->desainsekunder->caption() ?><?= $Page->desainsekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_desainsekunder"><span id="el_npd_confirmdesign_desainsekunder">
<input type="<?= $Page->desainsekunder->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_desainsekunder" name="x_desainsekunder" id="x_desainsekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desainsekunder->getPlaceHolder()) ?>" value="<?= $Page->desainsekunder->EditValue ?>"<?= $Page->desainsekunder->editAttributes() ?> aria-describedby="x_desainsekunder_help">
<?= $Page->desainsekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainsekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatansekunder->Visible) { // catatansekunder ?>
    <div id="r_catatansekunder" class="form-group row">
        <label id="elh_npd_confirmdesign_catatansekunder" for="x_catatansekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_catatansekunder"><?= $Page->catatansekunder->caption() ?><?= $Page->catatansekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatansekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_catatansekunder"><span id="el_npd_confirmdesign_catatansekunder">
<input type="<?= $Page->catatansekunder->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_catatansekunder" name="x_catatansekunder" id="x_catatansekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->catatansekunder->getPlaceHolder()) ?>" value="<?= $Page->catatansekunder->EditValue ?>"<?= $Page->catatansekunder->editAttributes() ?> aria-describedby="x_catatansekunder_help">
<?= $Page->catatansekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatansekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsekunder->Visible) { // tglsekunder ?>
    <div id="r_tglsekunder" class="form-group row">
        <label id="elh_npd_confirmdesign_tglsekunder" for="x_tglsekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_tglsekunder"><?= $Page->tglsekunder->caption() ?><?= $Page->tglsekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_tglsekunder"><span id="el_npd_confirmdesign_tglsekunder">
<input type="<?= $Page->tglsekunder->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_tglsekunder" name="x_tglsekunder" id="x_tglsekunder" placeholder="<?= HtmlEncode($Page->tglsekunder->getPlaceHolder()) ?>" value="<?= $Page->tglsekunder->EditValue ?>"<?= $Page->tglsekunder->editAttributes() ?> aria-describedby="x_tglsekunder_help">
<?= $Page->tglsekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsekunder->getErrorMessage() ?></div>
<?php if (!$Page->tglsekunder->ReadOnly && !$Page->tglsekunder->Disabled && !isset($Page->tglsekunder->EditAttrs["readonly"]) && !isset($Page->tglsekunder->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdesignadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdesignadd", "x_tglsekunder", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <div id="r_submitted_by" class="form-group row">
        <label id="elh_npd_confirmdesign_submitted_by" for="x_submitted_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_submitted_by"><?= $Page->submitted_by->caption() ?><?= $Page->submitted_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_submitted_by"><span id="el_npd_confirmdesign_submitted_by">
<input type="<?= $Page->submitted_by->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_submitted_by" name="x_submitted_by" id="x_submitted_by" size="30" placeholder="<?= HtmlEncode($Page->submitted_by->getPlaceHolder()) ?>" value="<?= $Page->submitted_by->EditValue ?>"<?= $Page->submitted_by->editAttributes() ?> aria-describedby="x_submitted_by_help">
<?= $Page->submitted_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->submitted_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
    <div id="r_checked1_by" class="form-group row">
        <label id="elh_npd_confirmdesign_checked1_by" for="x_checked1_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_checked1_by"><?= $Page->checked1_by->caption() ?><?= $Page->checked1_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked1_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_checked1_by"><span id="el_npd_confirmdesign_checked1_by">
<input type="<?= $Page->checked1_by->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_checked1_by" name="x_checked1_by" id="x_checked1_by" size="30" placeholder="<?= HtmlEncode($Page->checked1_by->getPlaceHolder()) ?>" value="<?= $Page->checked1_by->EditValue ?>"<?= $Page->checked1_by->editAttributes() ?> aria-describedby="x_checked1_by_help">
<?= $Page->checked1_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->checked1_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
    <div id="r_checked2_by" class="form-group row">
        <label id="elh_npd_confirmdesign_checked2_by" for="x_checked2_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_checked2_by"><?= $Page->checked2_by->caption() ?><?= $Page->checked2_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked2_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_checked2_by"><span id="el_npd_confirmdesign_checked2_by">
<input type="<?= $Page->checked2_by->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_checked2_by" name="x_checked2_by" id="x_checked2_by" size="30" placeholder="<?= HtmlEncode($Page->checked2_by->getPlaceHolder()) ?>" value="<?= $Page->checked2_by->EditValue ?>"<?= $Page->checked2_by->editAttributes() ?> aria-describedby="x_checked2_by_help">
<?= $Page->checked2_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->checked2_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_npd_confirmdesign_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmdesign_approved_by"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_confirmdesign_approved_by"><span id="el_npd_confirmdesign_approved_by">
    <select
        id="x_approved_by"
        name="x_approved_by"
        class="form-control ew-select<?= $Page->approved_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmdesign_x_approved_by"
        data-table="npd_confirmdesign"
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
    var el = document.querySelector("select[data-select2-id='npd_confirmdesign_x_approved_by']"),
        options = { name: "x_approved_by", selectId: "npd_confirmdesign_x_approved_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmdesign.fields.approved_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_npd_confirmdesignadd" class="ew-custom-template"></div>
<template id="tpm_npd_confirmdesignadd">
<div id="ct_NpdConfirmdesignAdd"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_confirmdesign_idnpd"></slot></div>
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
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_tglterima"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglsubmit->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_tglsubmit"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">DESAIN LABEL KEMASAN PRIMER/LOGO</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->desaindepan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_desaindepan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->desainbelakang->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_desainbelakang"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tglprimer->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_tglprimer"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->catatan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_catatan"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">DESAIN LABEL KEMASAN SEKUNDER</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->desainsekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_desainsekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tglsekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_tglsekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->catatansekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_catatansekunder"></slot></div>
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
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_submitted_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked1_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_checked1_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked2_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_checked2_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->approved_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmdesign_approved_by"></slot></div>
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
    ew.applyTemplate("tpd_npd_confirmdesignadd", "tpm_npd_confirmdesignadd", "npd_confirmdesignadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("npd_confirmdesign");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("select[name=x_idnpd]").change((function(){$.ajax({url:"api/npd_customer/"+$(this).val(),type:"GET",success:function(a){!1!==a.success&&($("#c_customer").val(a.data.kodecustomer+", "+a.data.namacustomer),$("#c_status").val(a.data.status))}})}));
});
</script>
