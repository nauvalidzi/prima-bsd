<?php

namespace PHPMaker2021\production2;

// Page object
$NpdBentukSediaanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_bentuk_sediaanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_bentuk_sediaanadd = currentForm = new ew.Form("fnpd_bentuk_sediaanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_bentuk_sediaan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_bentuk_sediaan)
        ew.vars.tables.npd_bentuk_sediaan = currentTable;
    fnpd_bentuk_sediaanadd.addFields([
        ["parent", [fields.parent.visible && fields.parent.required ? ew.Validators.required(fields.parent.caption) : null], fields.parent.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null], fields.value.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_bentuk_sediaanadd,
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
    fnpd_bentuk_sediaanadd.validate = function () {
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
    fnpd_bentuk_sediaanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_bentuk_sediaanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnpd_bentuk_sediaanadd");
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
<form name="fnpd_bentuk_sediaanadd" id="fnpd_bentuk_sediaanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_bentuk_sediaan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->parent->Visible) { // parent ?>
    <div id="r_parent" class="form-group row">
        <label id="elh_npd_bentuk_sediaan_parent" for="x_parent" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parent->caption() ?><?= $Page->parent->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parent->cellAttributes() ?>>
<span id="el_npd_bentuk_sediaan_parent">
<input type="<?= $Page->parent->getInputTextType() ?>" data-table="npd_bentuk_sediaan" data-field="x_parent" name="x_parent" id="x_parent" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->parent->getPlaceHolder()) ?>" value="<?= $Page->parent->EditValue ?>"<?= $Page->parent->editAttributes() ?> aria-describedby="x_parent_help">
<?= $Page->parent->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parent->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value" class="form-group row">
        <label id="elh_npd_bentuk_sediaan_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->value->cellAttributes() ?>>
<span id="el_npd_bentuk_sediaan_value">
<input type="<?= $Page->value->getInputTextType() ?>" data-table="npd_bentuk_sediaan" data-field="x_value" name="x_value" id="x_value" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>" value="<?= $Page->value->EditValue ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help">
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
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
    ew.addEventHandlers("npd_bentuk_sediaan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
