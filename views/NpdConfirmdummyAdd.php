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
        ["dummydepan", [fields.dummydepan.visible && fields.dummydepan.required ? ew.Validators.required(fields.dummydepan.caption) : null], fields.dummydepan.isInvalid],
        ["dummybelakang", [fields.dummybelakang.visible && fields.dummybelakang.required ? ew.Validators.required(fields.dummybelakang.caption) : null], fields.dummybelakang.isInvalid],
        ["dummyatas", [fields.dummyatas.visible && fields.dummyatas.required ? ew.Validators.required(fields.dummyatas.caption) : null], fields.dummyatas.isInvalid],
        ["dummysamping", [fields.dummysamping.visible && fields.dummysamping.required ? ew.Validators.required(fields.dummysamping.caption) : null], fields.dummysamping.isInvalid],
        ["catatan", [fields.catatan.visible && fields.catatan.required ? ew.Validators.required(fields.catatan.caption) : null], fields.catatan.isInvalid],
        ["ttd", [fields.ttd.visible && fields.ttd.required ? ew.Validators.required(fields.ttd.caption) : null, ew.Validators.datetime(0)], fields.ttd.isInvalid],
        ["checked_by", [fields.checked_by.visible && fields.checked_by.required ? ew.Validators.required(fields.checked_by.caption) : null], fields.checked_by.isInvalid],
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
    fnpd_confirmdummyadd.lists.checked_by = <?= $Page->checked_by->toClientList($Page) ?>;
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
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_confirmdummy_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_confirmdummy_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummydepan->Visible) { // dummydepan ?>
    <div id="r_dummydepan" class="form-group row">
        <label id="elh_npd_confirmdummy_dummydepan" for="x_dummydepan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dummydepan->caption() ?><?= $Page->dummydepan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummydepan->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummydepan">
<input type="<?= $Page->dummydepan->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummydepan" name="x_dummydepan" id="x_dummydepan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummydepan->getPlaceHolder()) ?>" value="<?= $Page->dummydepan->EditValue ?>"<?= $Page->dummydepan->editAttributes() ?> aria-describedby="x_dummydepan_help">
<?= $Page->dummydepan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummydepan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
    <div id="r_dummybelakang" class="form-group row">
        <label id="elh_npd_confirmdummy_dummybelakang" for="x_dummybelakang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dummybelakang->caption() ?><?= $Page->dummybelakang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummybelakang->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummybelakang">
<input type="<?= $Page->dummybelakang->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummybelakang" name="x_dummybelakang" id="x_dummybelakang" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummybelakang->getPlaceHolder()) ?>" value="<?= $Page->dummybelakang->EditValue ?>"<?= $Page->dummybelakang->editAttributes() ?> aria-describedby="x_dummybelakang_help">
<?= $Page->dummybelakang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummybelakang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummyatas->Visible) { // dummyatas ?>
    <div id="r_dummyatas" class="form-group row">
        <label id="elh_npd_confirmdummy_dummyatas" for="x_dummyatas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dummyatas->caption() ?><?= $Page->dummyatas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummyatas->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummyatas">
<input type="<?= $Page->dummyatas->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummyatas" name="x_dummyatas" id="x_dummyatas" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummyatas->getPlaceHolder()) ?>" value="<?= $Page->dummyatas->EditValue ?>"<?= $Page->dummyatas->editAttributes() ?> aria-describedby="x_dummyatas_help">
<?= $Page->dummyatas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummyatas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dummysamping->Visible) { // dummysamping ?>
    <div id="r_dummysamping" class="form-group row">
        <label id="elh_npd_confirmdummy_dummysamping" for="x_dummysamping" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dummysamping->caption() ?><?= $Page->dummysamping->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dummysamping->cellAttributes() ?>>
<span id="el_npd_confirmdummy_dummysamping">
<input type="<?= $Page->dummysamping->getInputTextType() ?>" data-table="npd_confirmdummy" data-field="x_dummysamping" name="x_dummysamping" id="x_dummysamping" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dummysamping->getPlaceHolder()) ?>" value="<?= $Page->dummysamping->EditValue ?>"<?= $Page->dummysamping->editAttributes() ?> aria-describedby="x_dummysamping_help">
<?= $Page->dummysamping->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dummysamping->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <div id="r_catatan" class="form-group row">
        <label id="elh_npd_confirmdummy_catatan" for="x_catatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->catatan->caption() ?><?= $Page->catatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan->cellAttributes() ?>>
<span id="el_npd_confirmdummy_catatan">
<textarea data-table="npd_confirmdummy" data-field="x_catatan" name="x_catatan" id="x_catatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatan->getPlaceHolder()) ?>"<?= $Page->catatan->editAttributes() ?> aria-describedby="x_catatan_help"><?= $Page->catatan->EditValue ?></textarea>
<?= $Page->catatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ttd->Visible) { // ttd ?>
    <div id="r_ttd" class="form-group row">
        <label id="elh_npd_confirmdummy_ttd" for="x_ttd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ttd->caption() ?><?= $Page->ttd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ttd->cellAttributes() ?>>
<span id="el_npd_confirmdummy_ttd">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <div id="r_checked_by" class="form-group row">
        <label id="elh_npd_confirmdummy_checked_by" for="x_checked_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->checked_by->caption() ?><?= $Page->checked_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked_by->cellAttributes() ?>>
<span id="el_npd_confirmdummy_checked_by">
    <select
        id="x_checked_by"
        name="x_checked_by"
        class="form-control ew-select<?= $Page->checked_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmdummy_x_checked_by"
        data-table="npd_confirmdummy"
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
    var el = document.querySelector("select[data-select2-id='npd_confirmdummy_x_checked_by']"),
        options = { name: "x_checked_by", selectId: "npd_confirmdummy_x_checked_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmdummy.fields.checked_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_npd_confirmdummy_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<span id="el_npd_confirmdummy_approved_by">
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
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("npd_confirmdummy");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
