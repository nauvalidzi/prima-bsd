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
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["brand", [fields.brand.visible && fields.brand.required ? ew.Validators.required(fields.brand.caption) : null], fields.brand.isInvalid],
        ["tglkirimprimer", [fields.tglkirimprimer.visible && fields.tglkirimprimer.required ? ew.Validators.required(fields.tglkirimprimer.caption) : null, ew.Validators.datetime(0)], fields.tglkirimprimer.isInvalid],
        ["tgldisetujuiprimer", [fields.tgldisetujuiprimer.visible && fields.tgldisetujuiprimer.required ? ew.Validators.required(fields.tgldisetujuiprimer.caption) : null, ew.Validators.datetime(0)], fields.tgldisetujuiprimer.isInvalid],
        ["desainprimer", [fields.desainprimer.visible && fields.desainprimer.required ? ew.Validators.required(fields.desainprimer.caption) : null], fields.desainprimer.isInvalid],
        ["materialprimer", [fields.materialprimer.visible && fields.materialprimer.required ? ew.Validators.required(fields.materialprimer.caption) : null], fields.materialprimer.isInvalid],
        ["aplikasiprimer", [fields.aplikasiprimer.visible && fields.aplikasiprimer.required ? ew.Validators.required(fields.aplikasiprimer.caption) : null], fields.aplikasiprimer.isInvalid],
        ["jumlahcetakprimer", [fields.jumlahcetakprimer.visible && fields.jumlahcetakprimer.required ? ew.Validators.required(fields.jumlahcetakprimer.caption) : null, ew.Validators.integer], fields.jumlahcetakprimer.isInvalid],
        ["tglkirimsekunder", [fields.tglkirimsekunder.visible && fields.tglkirimsekunder.required ? ew.Validators.required(fields.tglkirimsekunder.caption) : null, ew.Validators.datetime(0)], fields.tglkirimsekunder.isInvalid],
        ["tgldisetujuisekunder", [fields.tgldisetujuisekunder.visible && fields.tgldisetujuisekunder.required ? ew.Validators.required(fields.tgldisetujuisekunder.caption) : null, ew.Validators.datetime(0)], fields.tgldisetujuisekunder.isInvalid],
        ["desainsekunder", [fields.desainsekunder.visible && fields.desainsekunder.required ? ew.Validators.required(fields.desainsekunder.caption) : null], fields.desainsekunder.isInvalid],
        ["materialsekunder", [fields.materialsekunder.visible && fields.materialsekunder.required ? ew.Validators.required(fields.materialsekunder.caption) : null], fields.materialsekunder.isInvalid],
        ["aplikasisekunder", [fields.aplikasisekunder.visible && fields.aplikasisekunder.required ? ew.Validators.required(fields.aplikasisekunder.caption) : null], fields.aplikasisekunder.isInvalid],
        ["jumlahcetaksekunder", [fields.jumlahcetaksekunder.visible && fields.jumlahcetaksekunder.required ? ew.Validators.required(fields.jumlahcetaksekunder.caption) : null, ew.Validators.integer], fields.jumlahcetaksekunder.isInvalid],
        ["submitted_by", [fields.submitted_by.visible && fields.submitted_by.required ? ew.Validators.required(fields.submitted_by.caption) : null, ew.Validators.integer], fields.submitted_by.isInvalid],
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_confirmprint_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_idnpd"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_idnpd"><span id="el_npd_confirmprint_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <div id="r_tglterima" class="form-group row">
        <label id="elh_npd_confirmprint_tglterima" for="x_tglterima" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tglterima"><?= $Page->tglterima->caption() ?><?= $Page->tglterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tglterima"><span id="el_npd_confirmprint_tglterima">
<input type="<?= $Page->tglterima->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tglterima" name="x_tglterima" id="x_tglterima" placeholder="<?= HtmlEncode($Page->tglterima->getPlaceHolder()) ?>" value="<?= $Page->tglterima->EditValue ?>"<?= $Page->tglterima->editAttributes() ?> aria-describedby="x_tglterima_help">
<?= $Page->tglterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglterima->getErrorMessage() ?></div>
<?php if (!$Page->tglterima->ReadOnly && !$Page->tglterima->Disabled && !isset($Page->tglterima->EditAttrs["readonly"]) && !isset($Page->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_npd_confirmprint_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tglsubmit"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tglsubmit"><span id="el_npd_confirmprint_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
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
<?php if ($Page->tglkirimprimer->Visible) { // tglkirimprimer ?>
    <div id="r_tglkirimprimer" class="form-group row">
        <label id="elh_npd_confirmprint_tglkirimprimer" for="x_tglkirimprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tglkirimprimer"><?= $Page->tglkirimprimer->caption() ?><?= $Page->tglkirimprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglkirimprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tglkirimprimer"><span id="el_npd_confirmprint_tglkirimprimer">
<input type="<?= $Page->tglkirimprimer->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tglkirimprimer" name="x_tglkirimprimer" id="x_tglkirimprimer" placeholder="<?= HtmlEncode($Page->tglkirimprimer->getPlaceHolder()) ?>" value="<?= $Page->tglkirimprimer->EditValue ?>"<?= $Page->tglkirimprimer->editAttributes() ?> aria-describedby="x_tglkirimprimer_help">
<?= $Page->tglkirimprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglkirimprimer->getErrorMessage() ?></div>
<?php if (!$Page->tglkirimprimer->ReadOnly && !$Page->tglkirimprimer->Disabled && !isset($Page->tglkirimprimer->EditAttrs["readonly"]) && !isset($Page->tglkirimprimer->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tglkirimprimer", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgldisetujuiprimer->Visible) { // tgldisetujuiprimer ?>
    <div id="r_tgldisetujuiprimer" class="form-group row">
        <label id="elh_npd_confirmprint_tgldisetujuiprimer" for="x_tgldisetujuiprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tgldisetujuiprimer"><?= $Page->tgldisetujuiprimer->caption() ?><?= $Page->tgldisetujuiprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgldisetujuiprimer->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tgldisetujuiprimer"><span id="el_npd_confirmprint_tgldisetujuiprimer">
<input type="<?= $Page->tgldisetujuiprimer->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tgldisetujuiprimer" name="x_tgldisetujuiprimer" id="x_tgldisetujuiprimer" placeholder="<?= HtmlEncode($Page->tgldisetujuiprimer->getPlaceHolder()) ?>" value="<?= $Page->tgldisetujuiprimer->EditValue ?>"<?= $Page->tgldisetujuiprimer->editAttributes() ?> aria-describedby="x_tgldisetujuiprimer_help">
<?= $Page->tgldisetujuiprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgldisetujuiprimer->getErrorMessage() ?></div>
<?php if (!$Page->tgldisetujuiprimer->ReadOnly && !$Page->tgldisetujuiprimer->Disabled && !isset($Page->tgldisetujuiprimer->EditAttrs["readonly"]) && !isset($Page->tgldisetujuiprimer->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tgldisetujuiprimer", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
<?php if ($Page->tglkirimsekunder->Visible) { // tglkirimsekunder ?>
    <div id="r_tglkirimsekunder" class="form-group row">
        <label id="elh_npd_confirmprint_tglkirimsekunder" for="x_tglkirimsekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tglkirimsekunder"><?= $Page->tglkirimsekunder->caption() ?><?= $Page->tglkirimsekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglkirimsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tglkirimsekunder"><span id="el_npd_confirmprint_tglkirimsekunder">
<input type="<?= $Page->tglkirimsekunder->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tglkirimsekunder" name="x_tglkirimsekunder" id="x_tglkirimsekunder" placeholder="<?= HtmlEncode($Page->tglkirimsekunder->getPlaceHolder()) ?>" value="<?= $Page->tglkirimsekunder->EditValue ?>"<?= $Page->tglkirimsekunder->editAttributes() ?> aria-describedby="x_tglkirimsekunder_help">
<?= $Page->tglkirimsekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglkirimsekunder->getErrorMessage() ?></div>
<?php if (!$Page->tglkirimsekunder->ReadOnly && !$Page->tglkirimsekunder->Disabled && !isset($Page->tglkirimsekunder->EditAttrs["readonly"]) && !isset($Page->tglkirimsekunder->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tglkirimsekunder", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgldisetujuisekunder->Visible) { // tgldisetujuisekunder ?>
    <div id="r_tgldisetujuisekunder" class="form-group row">
        <label id="elh_npd_confirmprint_tgldisetujuisekunder" for="x_tgldisetujuisekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_tgldisetujuisekunder"><?= $Page->tgldisetujuisekunder->caption() ?><?= $Page->tgldisetujuisekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgldisetujuisekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_tgldisetujuisekunder"><span id="el_npd_confirmprint_tgldisetujuisekunder">
<input type="<?= $Page->tgldisetujuisekunder->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_tgldisetujuisekunder" name="x_tgldisetujuisekunder" id="x_tgldisetujuisekunder" placeholder="<?= HtmlEncode($Page->tgldisetujuisekunder->getPlaceHolder()) ?>" value="<?= $Page->tgldisetujuisekunder->EditValue ?>"<?= $Page->tgldisetujuisekunder->editAttributes() ?> aria-describedby="x_tgldisetujuisekunder_help">
<?= $Page->tgldisetujuisekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgldisetujuisekunder->getErrorMessage() ?></div>
<?php if (!$Page->tgldisetujuisekunder->ReadOnly && !$Page->tgldisetujuisekunder->Disabled && !isset($Page->tgldisetujuisekunder->EditAttrs["readonly"]) && !isset($Page->tgldisetujuisekunder->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmprintedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmprintedit", "x_tgldisetujuisekunder", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
<?php if ($Page->materialsekunder->Visible) { // materialsekunder ?>
    <div id="r_materialsekunder" class="form-group row">
        <label id="elh_npd_confirmprint_materialsekunder" for="x_materialsekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_materialsekunder"><?= $Page->materialsekunder->caption() ?><?= $Page->materialsekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->materialsekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_materialsekunder"><span id="el_npd_confirmprint_materialsekunder">
<input type="<?= $Page->materialsekunder->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_materialsekunder" name="x_materialsekunder" id="x_materialsekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->materialsekunder->getPlaceHolder()) ?>" value="<?= $Page->materialsekunder->EditValue ?>"<?= $Page->materialsekunder->editAttributes() ?> aria-describedby="x_materialsekunder_help">
<?= $Page->materialsekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->materialsekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasisekunder->Visible) { // aplikasisekunder ?>
    <div id="r_aplikasisekunder" class="form-group row">
        <label id="elh_npd_confirmprint_aplikasisekunder" for="x_aplikasisekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_aplikasisekunder"><?= $Page->aplikasisekunder->caption() ?><?= $Page->aplikasisekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasisekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_aplikasisekunder"><span id="el_npd_confirmprint_aplikasisekunder">
<input type="<?= $Page->aplikasisekunder->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_aplikasisekunder" name="x_aplikasisekunder" id="x_aplikasisekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->aplikasisekunder->getPlaceHolder()) ?>" value="<?= $Page->aplikasisekunder->EditValue ?>"<?= $Page->aplikasisekunder->editAttributes() ?> aria-describedby="x_aplikasisekunder_help">
<?= $Page->aplikasisekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasisekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahcetaksekunder->Visible) { // jumlahcetaksekunder ?>
    <div id="r_jumlahcetaksekunder" class="form-group row">
        <label id="elh_npd_confirmprint_jumlahcetaksekunder" for="x_jumlahcetaksekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_jumlahcetaksekunder"><?= $Page->jumlahcetaksekunder->caption() ?><?= $Page->jumlahcetaksekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahcetaksekunder->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_jumlahcetaksekunder"><span id="el_npd_confirmprint_jumlahcetaksekunder">
<input type="<?= $Page->jumlahcetaksekunder->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_jumlahcetaksekunder" name="x_jumlahcetaksekunder" id="x_jumlahcetaksekunder" size="30" placeholder="<?= HtmlEncode($Page->jumlahcetaksekunder->getPlaceHolder()) ?>" value="<?= $Page->jumlahcetaksekunder->EditValue ?>"<?= $Page->jumlahcetaksekunder->editAttributes() ?> aria-describedby="x_jumlahcetaksekunder_help">
<?= $Page->jumlahcetaksekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahcetaksekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <div id="r_submitted_by" class="form-group row">
        <label id="elh_npd_confirmprint_submitted_by" for="x_submitted_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmprint_submitted_by"><?= $Page->submitted_by->caption() ?><?= $Page->submitted_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_npd_confirmprint_submitted_by"><span id="el_npd_confirmprint_submitted_by">
<input type="<?= $Page->submitted_by->getInputTextType() ?>" data-table="npd_confirmprint" data-field="x_submitted_by" name="x_submitted_by" id="x_submitted_by" size="30" placeholder="<?= HtmlEncode($Page->submitted_by->getPlaceHolder()) ?>" value="<?= $Page->submitted_by->EditValue ?>"<?= $Page->submitted_by->editAttributes() ?> aria-describedby="x_submitted_by_help">
<?= $Page->submitted_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->submitted_by->getErrorMessage() ?></div>
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
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_confirmprint_idnpd"></slot></div>
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
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tglterima"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglsubmit->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tglsubmit"></slot></div>
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
                <label class="col-2 col-form-label text-right"><?= $Page->tglkirimprimer->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tglkirimprimer"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tgldisetujuiprimer->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tgldisetujuiprimer"></slot></div>
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
                <label class="col-2 col-form-label text-right"><?= $Page->tglkirimsekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tglkirimsekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tgldisetujuisekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_tgldisetujuisekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->desainsekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_desainsekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->materialsekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_materialsekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasisekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_aplikasisekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jumlahcetaksekunder->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_jumlahcetaksekunder"></slot></div>
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
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmprint_submitted_by"></slot></div>
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
