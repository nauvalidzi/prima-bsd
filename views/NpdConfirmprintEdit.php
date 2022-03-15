<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmprintEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmprintedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_confirmprintedit = currentForm = new ew.Form("fnpd_confirmprintedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirmprint")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirmprint)
        ew.vars.tables.npd_confirmprint = currentTable;
    fnpd_confirmprintedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["brand", [fields.brand.visible && fields.brand.required ? ew.Validators.required(fields.brand.caption) : null], fields.brand.isInvalid],
        ["tglkirim", [fields.tglkirim.visible && fields.tglkirim.required ? ew.Validators.required(fields.tglkirim.caption) : null, ew.Validators.datetime(0)], fields.tglkirim.isInvalid],
        ["tgldisetujui", [fields.tgldisetujui.visible && fields.tgldisetujui.required ? ew.Validators.required(fields.tgldisetujui.caption) : null, ew.Validators.datetime(0)], fields.tgldisetujui.isInvalid],
        ["desainprimer", [fields.desainprimer.visible && fields.desainprimer.required ? ew.Validators.required(fields.desainprimer.caption) : null], fields.desainprimer.isInvalid],
        ["materialprimer", [fields.materialprimer.visible && fields.materialprimer.required ? ew.Validators.required(fields.materialprimer.caption) : null], fields.materialprimer.isInvalid],
        ["aplikasiprimer", [fields.aplikasiprimer.visible && fields.aplikasiprimer.required ? ew.Validators.required(fields.aplikasiprimer.caption) : null], fields.aplikasiprimer.isInvalid],
        ["jumlahcetakprimer", [fields.jumlahcetakprimer.visible && fields.jumlahcetakprimer.required ? ew.Validators.required(fields.jumlahcetakprimer.caption) : null, ew.Validators.integer], fields.jumlahcetakprimer.isInvalid],
        ["desainsekunder", [fields.desainsekunder.visible && fields.desainsekunder.required ? ew.Validators.required(fields.desainsekunder.caption) : null], fields.desainsekunder.isInvalid],
        ["materialinnerbox", [fields.materialinnerbox.visible && fields.materialinnerbox.required ? ew.Validators.required(fields.materialinnerbox.caption) : null], fields.materialinnerbox.isInvalid],
        ["aplikasiinnerbox", [fields.aplikasiinnerbox.visible && fields.aplikasiinnerbox.required ? ew.Validators.required(fields.aplikasiinnerbox.caption) : null], fields.aplikasiinnerbox.isInvalid],
        ["jumlahcetak", [fields.jumlahcetak.visible && fields.jumlahcetak.required ? ew.Validators.required(fields.jumlahcetak.caption) : null, ew.Validators.integer], fields.jumlahcetak.isInvalid],
        ["checked_by", [fields.checked_by.visible && fields.checked_by.required ? ew.Validators.required(fields.checked_by.caption) : null], fields.checked_by.isInvalid],
        ["approved_by", [fields.approved_by.visible && fields.approved_by.required ? ew.Validators.required(fields.approved_by.caption) : null], fields.approved_by.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmprintedit,
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
    fnpd_confirmprintedit.validate = function () {
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
    fnpd_confirmprintedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmprintedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_confirmprintedit.lists.checked_by = <?= $Page->checked_by->toClientList($Page) ?>;
    fnpd_confirmprintedit.lists.approved_by = <?= $Page->approved_by->toClientList($Page) ?>;
    loadjs.done("fnpd_confirmprintedit");
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
<form name="fnpd_confirmprintedit" id="fnpd_confirmprintedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmprint">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div d-none"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_npd_confirmprint_id" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_id"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_id"><span id="el_npd_confirmprint_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span></template>
<input type="hidden" data-table="npd_confirmprint" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
    <div id="r_brand" class="form-group row">
        <label id="elh_npd_confirmprint_brand" for="x_brand" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_brand"><?= $Page->brand->caption() ?><?= $Page->brand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->brand->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_brand"><span id="el_npd_confirmprint_brand">
<input type="<?= $Page->brand->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_brand" name="x_brand" id="x_brand" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->brand->getPlaceHolder()) ?>" value="<?= $Page->brand->EditValue ?>"<?= $Page->brand->editAttributes() ?> aria-describedby="x_brand_help">
<?= $Page->brand->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->brand->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
    <div id="r_tglkirim" class="form-group row">
        <label id="elh_npd_confirmprint_tglkirim" for="x_tglkirim" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tglkirim"><?= $Page->tglkirim->caption() ?><?= $Page->tglkirim->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglkirim->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tglkirim"><span id="el_npd_confirmprint_tglkirim">
<input type="<?= $Page->tglkirim->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tglkirim" name="x_tglkirim" id="x_tglkirim" placeholder="<?= HtmlEncode($Page->tglkirim->getPlaceHolder()) ?>" value="<?= $Page->tglkirim->EditValue ?>"<?= $Page->tglkirim->editAttributes() ?> aria-describedby="x_tglkirim_help">
<?= $Page->tglkirim->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglkirim->getErrorMessage() ?></div>
<?php if (!$Page->tglkirim->ReadOnly && !$Page->tglkirim->Disabled && !isset($Page->tglkirim->EditAttrs["readonly"]) && !isset($Page->tglkirim->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tglkirim", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgldisetujui->Visible) { // tgldisetujui ?>
    <div id="r_tgldisetujui" class="form-group row">
        <label id="elh_npd_confirmprint_tgldisetujui" for="x_tgldisetujui" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tgldisetujui"><?= $Page->tgldisetujui->caption() ?><?= $Page->tgldisetujui->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgldisetujui->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tgldisetujui"><span id="el_npd_confirmprint_tgldisetujui">
<input type="<?= $Page->tgldisetujui->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tgldisetujui" name="x_tgldisetujui" id="x_tgldisetujui" placeholder="<?= HtmlEncode($Page->tgldisetujui->getPlaceHolder()) ?>" value="<?= $Page->tgldisetujui->EditValue ?>"<?= $Page->tgldisetujui->editAttributes() ?> aria-describedby="x_tgldisetujui_help">
<?= $Page->tgldisetujui->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgldisetujui->getErrorMessage() ?></div>
<?php if (!$Page->tgldisetujui->ReadOnly && !$Page->tgldisetujui->Disabled && !isset($Page->tgldisetujui->EditAttrs["readonly"]) && !isset($Page->tgldisetujui->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tgldisetujui", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainprimer->Visible) { // desainprimer ?>
    <div id="r_desainprimer" class="form-group row">
        <label id="elh_npd_confirmprint_desainprimer" for="x_desainprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_desainprimer"><?= $Page->desainprimer->caption() ?><?= $Page->desainprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_desainprimer"><span id="el_npd_confirmprint_desainprimer">
<input type="<?= $Page->desainprimer->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_desainprimer" name="x_desainprimer" id="x_desainprimer" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desainprimer->getPlaceHolder()) ?>" value="<?= $Page->desainprimer->EditValue ?>"<?= $Page->desainprimer->editAttributes() ?> aria-describedby="x_desainprimer_help">
<?= $Page->desainprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainprimer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->materialprimer->Visible) { // materialprimer ?>
    <div id="r_materialprimer" class="form-group row">
        <label id="elh_npd_confirmprint_materialprimer" for="x_materialprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_materialprimer"><?= $Page->materialprimer->caption() ?><?= $Page->materialprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->materialprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_materialprimer"><span id="el_npd_confirmprint_materialprimer">
<input type="<?= $Page->materialprimer->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_materialprimer" name="x_materialprimer" id="x_materialprimer" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->materialprimer->getPlaceHolder()) ?>" value="<?= $Page->materialprimer->EditValue ?>"<?= $Page->materialprimer->editAttributes() ?> aria-describedby="x_materialprimer_help">
<?= $Page->materialprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->materialprimer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasiprimer->Visible) { // aplikasiprimer ?>
    <div id="r_aplikasiprimer" class="form-group row">
        <label id="elh_npd_confirmprint_aplikasiprimer" for="x_aplikasiprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_aplikasiprimer"><?= $Page->aplikasiprimer->caption() ?><?= $Page->aplikasiprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasiprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_aplikasiprimer"><span id="el_npd_confirmprint_aplikasiprimer">
<input type="<?= $Page->aplikasiprimer->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_aplikasiprimer" name="x_aplikasiprimer" id="x_aplikasiprimer" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->aplikasiprimer->getPlaceHolder()) ?>" value="<?= $Page->aplikasiprimer->EditValue ?>"<?= $Page->aplikasiprimer->editAttributes() ?> aria-describedby="x_aplikasiprimer_help">
<?= $Page->aplikasiprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasiprimer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahcetakprimer->Visible) { // jumlahcetakprimer ?>
    <div id="r_jumlahcetakprimer" class="form-group row">
        <label id="elh_npd_confirmprint_jumlahcetakprimer" for="x_jumlahcetakprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_jumlahcetakprimer"><?= $Page->jumlahcetakprimer->caption() ?><?= $Page->jumlahcetakprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahcetakprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_jumlahcetakprimer"><span id="el_npd_confirmprint_jumlahcetakprimer">
<input type="<?= $Page->jumlahcetakprimer->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_jumlahcetakprimer" name="x_jumlahcetakprimer" id="x_jumlahcetakprimer" size="30" placeholder="<?= HtmlEncode($Page->jumlahcetakprimer->getPlaceHolder()) ?>" value="<?= $Page->jumlahcetakprimer->EditValue ?>"<?= $Page->jumlahcetakprimer->editAttributes() ?> aria-describedby="x_jumlahcetakprimer_help">
<?= $Page->jumlahcetakprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahcetakprimer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
    <div id="r_desainsekunder" class="form-group row">
        <label id="elh_npd_confirmprint_desainsekunder" for="x_desainsekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_desainsekunder"><?= $Page->desainsekunder->caption() ?><?= $Page->desainsekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_desainsekunder"><span id="el_npd_confirmprint_desainsekunder">
<input type="<?= $Page->desainsekunder->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_desainsekunder" name="x_desainsekunder" id="x_desainsekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desainsekunder->getPlaceHolder()) ?>" value="<?= $Page->desainsekunder->EditValue ?>"<?= $Page->desainsekunder->editAttributes() ?> aria-describedby="x_desainsekunder_help">
<?= $Page->desainsekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainsekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->materialinnerbox->Visible) { // materialinnerbox ?>
    <div id="r_materialinnerbox" class="form-group row">
        <label id="elh_npd_confirmprint_materialinnerbox" for="x_materialinnerbox" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_materialinnerbox"><?= $Page->materialinnerbox->caption() ?><?= $Page->materialinnerbox->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->materialinnerbox->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_materialinnerbox"><span id="el_npd_confirmprint_materialinnerbox">
<input type="<?= $Page->materialinnerbox->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_materialinnerbox" name="x_materialinnerbox" id="x_materialinnerbox" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->materialinnerbox->getPlaceHolder()) ?>" value="<?= $Page->materialinnerbox->EditValue ?>"<?= $Page->materialinnerbox->editAttributes() ?> aria-describedby="x_materialinnerbox_help">
<?= $Page->materialinnerbox->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->materialinnerbox->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasiinnerbox->Visible) { // aplikasiinnerbox ?>
    <div id="r_aplikasiinnerbox" class="form-group row">
        <label id="elh_npd_confirmprint_aplikasiinnerbox" for="x_aplikasiinnerbox" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_aplikasiinnerbox"><?= $Page->aplikasiinnerbox->caption() ?><?= $Page->aplikasiinnerbox->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasiinnerbox->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_aplikasiinnerbox"><span id="el_npd_confirmprint_aplikasiinnerbox">
<input type="<?= $Page->aplikasiinnerbox->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_aplikasiinnerbox" name="x_aplikasiinnerbox" id="x_aplikasiinnerbox" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->aplikasiinnerbox->getPlaceHolder()) ?>" value="<?= $Page->aplikasiinnerbox->EditValue ?>"<?= $Page->aplikasiinnerbox->editAttributes() ?> aria-describedby="x_aplikasiinnerbox_help">
<?= $Page->aplikasiinnerbox->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasiinnerbox->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahcetak->Visible) { // jumlahcetak ?>
    <div id="r_jumlahcetak" class="form-group row">
        <label id="elh_npd_confirmprint_jumlahcetak" for="x_jumlahcetak" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_jumlahcetak"><?= $Page->jumlahcetak->caption() ?><?= $Page->jumlahcetak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahcetak->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_jumlahcetak"><span id="el_npd_confirmprint_jumlahcetak">
<input type="<?= $Page->jumlahcetak->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_jumlahcetak" name="x_jumlahcetak" id="x_jumlahcetak" size="30" placeholder="<?= HtmlEncode($Page->jumlahcetak->getPlaceHolder()) ?>" value="<?= $Page->jumlahcetak->EditValue ?>"<?= $Page->jumlahcetak->editAttributes() ?> aria-describedby="x_jumlahcetak_help">
<?= $Page->jumlahcetak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahcetak->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <div id="r_checked_by" class="form-group row">
        <label id="elh_npd_confirmprint_checked_by" for="x_checked_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_checked_by"><?= $Page->checked_by->caption() ?><?= $Page->checked_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked_by->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_checked_by"><span id="el_npd_confirmprint_checked_by">
    <select
        id="x_checked_by"
        name="x_checked_by"
        class="form-control ew-select<?= $Page->checked_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmprint_x_checked_by"
        data-table="npd_confirmprint"
        data-field="x_checked_by"
        data-value-separator="<?= $Page->checked_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->checked_by->getPlaceHolder()) ?>"
        <?= $Page->checked_by->editAttributes() ?>>
        <?= $Page->checked_by->selectOptionListHtml("x_checked_by") ?>
    </select>
    <?= $Page->checked_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->checked_by->getErrorMessage() ?></div>
<?= $Page->checked_by->Lookup->getParamTag($Page, "p_x_checked_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirmprint_x_checked_by']"),
        options = { name: "x_checked_by", selectId: "npd_confirmprint_x_checked_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmprint.fields.checked_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_npd_confirmprint_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_approved_by"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_approved_by"><span id="el_npd_confirmprint_approved_by">
    <select
        id="x_approved_by"
        name="x_approved_by"
        class="form-control ew-select<?= $Page->approved_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmprint_x_approved_by"
        data-table="npd_confirmprint"
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
    var el = document.querySelector("select[data-select2-id='npd_confirmprint_x_approved_by']"),
        options = { name: "x_approved_by", selectId: "npd_confirmprint_x_approved_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmprint.fields.approved_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_npd_confirmprint_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_created_at"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_created_at"><span id="el_npd_confirmprint_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_npd_confirmprint_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_updated_at"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_updated_at"><span id="el_npd_confirmprint_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_npd_confirmprintedit" class="ew-custom-template"></div>
<template id="tpm_npd_confirmprintedit">
<div id="ct_NpdConfirmprintEdit"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><slot class="ew-slot" name="tpcaption_idnpd"></slot></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_idnpd"></slot></div>
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
                    <label class="col-4 col-form-label text-right"><slot class="ew-slot" name="tpcaption_tglterima"></slot></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_tglterima"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><slot class="ew-slot" name="tpcaption_tglsubmit"></slot></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_tglsubmit"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">MERK</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->brand->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_brand"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">DESAIN LABEL KEMASAN PRIMER</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tglkirim->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tglkirim"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tgldisetujui->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tgldisetujui"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->desainprimer->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_desainprimer"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->materialprimer->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_materialprimer"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasiprimer->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_aplikasiprimer"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jumlahcetakprimer->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_jumlahcetakprimer"></slot></div>
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
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_desainsekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->materialinnerbox->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_materialinnerbox"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasiinnerbox->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_aplikasiinnerbox"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jumlahcetak->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_jumlahcetak"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">VALIDASI</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><slot class="ew-slot" name="tpcaption_submitted_by"></slot></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_submitted_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_checked_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->approved_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_approved_by"></slot></div>
            </div>
        </div>
    </div>
</div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npd_confirmprintedit", "tpm_npd_confirmprintedit", "npd_confirmprintedit", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("npd_confirmprint");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
