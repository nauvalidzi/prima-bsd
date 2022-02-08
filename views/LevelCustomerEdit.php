<?php

namespace PHPMaker2021\production2;

// Page object
$LevelCustomerEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var flevel_customeredit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    flevel_customeredit = currentForm = new ew.Form("flevel_customeredit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "level_customer")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.level_customer)
        ew.vars.tables.level_customer = currentTable;
    flevel_customeredit.addFields([
        ["level", [fields.level.visible && fields.level.required ? ew.Validators.required(fields.level.caption) : null], fields.level.isInvalid],
        ["limit_kredit_value", [fields.limit_kredit_value.visible && fields.limit_kredit_value.required ? ew.Validators.required(fields.limit_kredit_value.caption) : null, ew.Validators.integer], fields.limit_kredit_value.isInvalid],
        ["diskon_value", [fields.diskon_value.visible && fields.diskon_value.required ? ew.Validators.required(fields.diskon_value.caption) : null, ew.Validators.float], fields.diskon_value.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = flevel_customeredit,
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
    flevel_customeredit.validate = function () {
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
    flevel_customeredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flevel_customeredit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("flevel_customeredit");
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
<form name="flevel_customeredit" id="flevel_customeredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="level_customer">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->level->Visible) { // level ?>
    <div id="r_level" class="form-group row">
        <label id="elh_level_customer_level" for="x_level" class="<?= $Page->LeftColumnClass ?>"><?= $Page->level->caption() ?><?= $Page->level->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->level->cellAttributes() ?>>
<span id="el_level_customer_level">
<input type="<?= $Page->level->getInputTextType() ?>" data-table="level_customer" data-field="x_level" name="x_level" id="x_level" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->level->getPlaceHolder()) ?>" value="<?= $Page->level->EditValue ?>"<?= $Page->level->editAttributes() ?> aria-describedby="x_level_help">
<?= $Page->level->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->level->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limit_kredit_value->Visible) { // limit_kredit_value ?>
    <div id="r_limit_kredit_value" class="form-group row">
        <label id="elh_level_customer_limit_kredit_value" for="x_limit_kredit_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limit_kredit_value->caption() ?><?= $Page->limit_kredit_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->limit_kredit_value->cellAttributes() ?>>
<span id="el_level_customer_limit_kredit_value">
<input type="<?= $Page->limit_kredit_value->getInputTextType() ?>" data-table="level_customer" data-field="x_limit_kredit_value" name="x_limit_kredit_value" id="x_limit_kredit_value" size="30" placeholder="<?= HtmlEncode($Page->limit_kredit_value->getPlaceHolder()) ?>" value="<?= $Page->limit_kredit_value->EditValue ?>"<?= $Page->limit_kredit_value->editAttributes() ?> aria-describedby="x_limit_kredit_value_help">
<?= $Page->limit_kredit_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limit_kredit_value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->diskon_value->Visible) { // diskon_value ?>
    <div id="r_diskon_value" class="form-group row">
        <label id="elh_level_customer_diskon_value" for="x_diskon_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->diskon_value->caption() ?><?= $Page->diskon_value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->diskon_value->cellAttributes() ?>>
<span id="el_level_customer_diskon_value">
<input type="<?= $Page->diskon_value->getInputTextType() ?>" data-table="level_customer" data-field="x_diskon_value" name="x_diskon_value" id="x_diskon_value" size="30" placeholder="<?= HtmlEncode($Page->diskon_value->getPlaceHolder()) ?>" value="<?= $Page->diskon_value->EditValue ?>"<?= $Page->diskon_value->editAttributes() ?> aria-describedby="x_diskon_value_help">
<?= $Page->diskon_value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->diskon_value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="level_customer" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("level_customer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
