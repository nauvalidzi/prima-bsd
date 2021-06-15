<?php

namespace PHPMaker2021\distributor;

// Page object
$TitipmerkValidasiAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftitipmerk_validasiadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ftitipmerk_validasiadd = currentForm = new ew.Form("ftitipmerk_validasiadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "titipmerk_validasi")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.titipmerk_validasi)
        ew.vars.tables.titipmerk_validasi = currentTable;
    ftitipmerk_validasiadd.addFields([
        ["validator", [fields.validator.visible && fields.validator.required ? ew.Validators.required(fields.validator.caption) : null], fields.validator.isInvalid],
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.datetime(0)], fields.tanggal.isInvalid],
        ["valid", [fields.valid.visible && fields.valid.required ? ew.Validators.required(fields.valid.caption) : null], fields.valid.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftitipmerk_validasiadd,
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
    ftitipmerk_validasiadd.validate = function () {
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
    ftitipmerk_validasiadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftitipmerk_validasiadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ftitipmerk_validasiadd.lists.valid = <?= $Page->valid->toClientList($Page) ?>;
    loadjs.done("ftitipmerk_validasiadd");
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
<form name="ftitipmerk_validasiadd" id="ftitipmerk_validasiadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="titipmerk_validasi">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->validator->Visible) { // validator ?>
    <div id="r_validator" class="form-group row">
        <label id="elh_titipmerk_validasi_validator" for="x_validator" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validator->caption() ?><?= $Page->validator->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->validator->cellAttributes() ?>>
<span id="el_titipmerk_validasi_validator">
<input type="<?= $Page->validator->getInputTextType() ?>" data-table="titipmerk_validasi" data-field="x_validator" name="x_validator" id="x_validator" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->validator->getPlaceHolder()) ?>" value="<?= $Page->validator->EditValue ?>"<?= $Page->validator->editAttributes() ?> aria-describedby="x_validator_help">
<?= $Page->validator->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->validator->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <div id="r_tanggal" class="form-group row">
        <label id="elh_titipmerk_validasi_tanggal" for="x_tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal->caption() ?><?= $Page->tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_titipmerk_validasi_tanggal">
<input type="<?= $Page->tanggal->getInputTextType() ?>" data-table="titipmerk_validasi" data-field="x_tanggal" name="x_tanggal" id="x_tanggal" placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>" value="<?= $Page->tanggal->EditValue ?>"<?= $Page->tanggal->editAttributes() ?> aria-describedby="x_tanggal_help">
<?= $Page->tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
<?php if (!$Page->tanggal->ReadOnly && !$Page->tanggal->Disabled && !isset($Page->tanggal->EditAttrs["readonly"]) && !isset($Page->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftitipmerk_validasiadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ftitipmerk_validasiadd", "x_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valid->Visible) { // valid ?>
    <div id="r_valid" class="form-group row">
        <label id="elh_titipmerk_validasi_valid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valid->caption() ?><?= $Page->valid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->valid->cellAttributes() ?>>
<span id="el_titipmerk_validasi_valid">
<template id="tp_x_valid">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="titipmerk_validasi" data-field="x_valid" name="x_valid" id="x_valid"<?= $Page->valid->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_valid" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_valid"
    name="x_valid"
    value="<?= HtmlEncode($Page->valid->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_valid"
    data-target="dsl_x_valid"
    data-repeatcolumn="5"
    class="form-control<?= $Page->valid->isInvalidClass() ?>"
    data-table="titipmerk_validasi"
    data-field="x_valid"
    data-value-separator="<?= $Page->valid->displayValueSeparatorAttribute() ?>"
    <?= $Page->valid->editAttributes() ?>>
<?= $Page->valid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_titipmerk_validasi_created_by">
    <input type="hidden" data-table="titipmerk_validasi" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
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
    ew.addEventHandlers("titipmerk_validasi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
