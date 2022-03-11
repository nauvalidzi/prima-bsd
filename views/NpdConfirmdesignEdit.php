<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdesignEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdesignedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_confirmdesignedit = currentForm = new ew.Form("fnpd_confirmdesignedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirmdesign")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirmdesign)
        ew.vars.tables.npd_confirmdesign = currentTable;
    fnpd_confirmdesignedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["desaindepan", [fields.desaindepan.visible && fields.desaindepan.required ? ew.Validators.required(fields.desaindepan.caption) : null], fields.desaindepan.isInvalid],
        ["desainbelakang", [fields.desainbelakang.visible && fields.desainbelakang.required ? ew.Validators.required(fields.desainbelakang.caption) : null], fields.desainbelakang.isInvalid],
        ["catatan", [fields.catatan.visible && fields.catatan.required ? ew.Validators.required(fields.catatan.caption) : null], fields.catatan.isInvalid],
        ["tglprimer", [fields.tglprimer.visible && fields.tglprimer.required ? ew.Validators.required(fields.tglprimer.caption) : null, ew.Validators.datetime(0)], fields.tglprimer.isInvalid],
        ["desainsekunder", [fields.desainsekunder.visible && fields.desainsekunder.required ? ew.Validators.required(fields.desainsekunder.caption) : null], fields.desainsekunder.isInvalid],
        ["catatansekunder", [fields.catatansekunder.visible && fields.catatansekunder.required ? ew.Validators.required(fields.catatansekunder.caption) : null], fields.catatansekunder.isInvalid],
        ["tglsekunder", [fields.tglsekunder.visible && fields.tglsekunder.required ? ew.Validators.required(fields.tglsekunder.caption) : null, ew.Validators.datetime(0)], fields.tglsekunder.isInvalid],
        ["checked_by", [fields.checked_by.visible && fields.checked_by.required ? ew.Validators.required(fields.checked_by.caption) : null], fields.checked_by.isInvalid],
        ["approved_by", [fields.approved_by.visible && fields.approved_by.required ? ew.Validators.required(fields.approved_by.caption) : null], fields.approved_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmdesignedit,
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
    fnpd_confirmdesignedit.validate = function () {
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
    fnpd_confirmdesignedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmdesignedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_confirmdesignedit.lists.checked_by = <?= $Page->checked_by->toClientList($Page) ?>;
    fnpd_confirmdesignedit.lists.approved_by = <?= $Page->approved_by->toClientList($Page) ?>;
    loadjs.done("fnpd_confirmdesignedit");
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
<form name="fnpd_confirmdesignedit" id="fnpd_confirmdesignedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdesign">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_npd_confirmdesign_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_npd_confirmdesign_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_confirmdesign" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_confirmdesign_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_confirmdesign_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desaindepan->Visible) { // desaindepan ?>
    <div id="r_desaindepan" class="form-group row">
        <label id="elh_npd_confirmdesign_desaindepan" for="x_desaindepan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desaindepan->caption() ?><?= $Page->desaindepan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desaindepan->cellAttributes() ?>>
<span id="el_npd_confirmdesign_desaindepan">
<input type="<?= $Page->desaindepan->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_desaindepan" name="x_desaindepan" id="x_desaindepan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desaindepan->getPlaceHolder()) ?>" value="<?= $Page->desaindepan->EditValue ?>"<?= $Page->desaindepan->editAttributes() ?> aria-describedby="x_desaindepan_help">
<?= $Page->desaindepan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desaindepan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainbelakang->Visible) { // desainbelakang ?>
    <div id="r_desainbelakang" class="form-group row">
        <label id="elh_npd_confirmdesign_desainbelakang" for="x_desainbelakang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desainbelakang->caption() ?><?= $Page->desainbelakang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainbelakang->cellAttributes() ?>>
<span id="el_npd_confirmdesign_desainbelakang">
<input type="<?= $Page->desainbelakang->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_desainbelakang" name="x_desainbelakang" id="x_desainbelakang" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desainbelakang->getPlaceHolder()) ?>" value="<?= $Page->desainbelakang->EditValue ?>"<?= $Page->desainbelakang->editAttributes() ?> aria-describedby="x_desainbelakang_help">
<?= $Page->desainbelakang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainbelakang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <div id="r_catatan" class="form-group row">
        <label id="elh_npd_confirmdesign_catatan" for="x_catatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->catatan->caption() ?><?= $Page->catatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan->cellAttributes() ?>>
<span id="el_npd_confirmdesign_catatan">
<textarea data-table="npd_confirmdesign" data-field="x_catatan" name="x_catatan" id="x_catatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatan->getPlaceHolder()) ?>"<?= $Page->catatan->editAttributes() ?> aria-describedby="x_catatan_help"><?= $Page->catatan->EditValue ?></textarea>
<?= $Page->catatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglprimer->Visible) { // tglprimer ?>
    <div id="r_tglprimer" class="form-group row">
        <label id="elh_npd_confirmdesign_tglprimer" for="x_tglprimer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglprimer->caption() ?><?= $Page->tglprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglprimer->cellAttributes() ?>>
<span id="el_npd_confirmdesign_tglprimer">
<input type="<?= $Page->tglprimer->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_tglprimer" name="x_tglprimer" id="x_tglprimer" placeholder="<?= HtmlEncode($Page->tglprimer->getPlaceHolder()) ?>" value="<?= $Page->tglprimer->EditValue ?>"<?= $Page->tglprimer->editAttributes() ?> aria-describedby="x_tglprimer_help">
<?= $Page->tglprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglprimer->getErrorMessage() ?></div>
<?php if (!$Page->tglprimer->ReadOnly && !$Page->tglprimer->Disabled && !isset($Page->tglprimer->EditAttrs["readonly"]) && !isset($Page->tglprimer->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdesignedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdesignedit", "x_tglprimer", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
    <div id="r_desainsekunder" class="form-group row">
        <label id="elh_npd_confirmdesign_desainsekunder" for="x_desainsekunder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desainsekunder->caption() ?><?= $Page->desainsekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainsekunder->cellAttributes() ?>>
<span id="el_npd_confirmdesign_desainsekunder">
<input type="<?= $Page->desainsekunder->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_desainsekunder" name="x_desainsekunder" id="x_desainsekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->desainsekunder->getPlaceHolder()) ?>" value="<?= $Page->desainsekunder->EditValue ?>"<?= $Page->desainsekunder->editAttributes() ?> aria-describedby="x_desainsekunder_help">
<?= $Page->desainsekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainsekunder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatansekunder->Visible) { // catatansekunder ?>
    <div id="r_catatansekunder" class="form-group row">
        <label id="elh_npd_confirmdesign_catatansekunder" for="x_catatansekunder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->catatansekunder->caption() ?><?= $Page->catatansekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatansekunder->cellAttributes() ?>>
<span id="el_npd_confirmdesign_catatansekunder">
<input type="<?= $Page->catatansekunder->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_catatansekunder" name="x_catatansekunder" id="x_catatansekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->catatansekunder->getPlaceHolder()) ?>" value="<?= $Page->catatansekunder->EditValue ?>"<?= $Page->catatansekunder->editAttributes() ?> aria-describedby="x_catatansekunder_help">
<?= $Page->catatansekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatansekunder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsekunder->Visible) { // tglsekunder ?>
    <div id="r_tglsekunder" class="form-group row">
        <label id="elh_npd_confirmdesign_tglsekunder" for="x_tglsekunder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglsekunder->caption() ?><?= $Page->tglsekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsekunder->cellAttributes() ?>>
<span id="el_npd_confirmdesign_tglsekunder">
<input type="<?= $Page->tglsekunder->getInputTextType() ?>" data-table="npd_confirmdesign" data-field="x_tglsekunder" name="x_tglsekunder" id="x_tglsekunder" placeholder="<?= HtmlEncode($Page->tglsekunder->getPlaceHolder()) ?>" value="<?= $Page->tglsekunder->EditValue ?>"<?= $Page->tglsekunder->editAttributes() ?> aria-describedby="x_tglsekunder_help">
<?= $Page->tglsekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsekunder->getErrorMessage() ?></div>
<?php if (!$Page->tglsekunder->ReadOnly && !$Page->tglsekunder->Disabled && !isset($Page->tglsekunder->EditAttrs["readonly"]) && !isset($Page->tglsekunder->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmdesignedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmdesignedit", "x_tglsekunder", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <div id="r_checked_by" class="form-group row">
        <label id="elh_npd_confirmdesign_checked_by" for="x_checked_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->checked_by->caption() ?><?= $Page->checked_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked_by->cellAttributes() ?>>
<span id="el_npd_confirmdesign_checked_by">
    <select
        id="x_checked_by"
        name="x_checked_by"
        class="form-control ew-select<?= $Page->checked_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmdesign_x_checked_by"
        data-table="npd_confirmdesign"
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
    var el = document.querySelector("select[data-select2-id='npd_confirmdesign_x_checked_by']"),
        options = { name: "x_checked_by", selectId: "npd_confirmdesign_x_checked_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmdesign.fields.checked_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_npd_confirmdesign_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<span id="el_npd_confirmdesign_approved_by">
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
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
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
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
