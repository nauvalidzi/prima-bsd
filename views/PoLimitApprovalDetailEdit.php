<?php

namespace PHPMaker2021\distributor;

// Page object
$PoLimitApprovalDetailEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpo_limit_approval_detailedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fpo_limit_approval_detailedit = currentForm = new ew.Form("fpo_limit_approval_detailedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "po_limit_approval_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.po_limit_approval_detail)
        ew.vars.tables.po_limit_approval_detail = currentTable;
    fpo_limit_approval_detailedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["idapproval", [fields.idapproval.visible && fields.idapproval.required ? ew.Validators.required(fields.idapproval.caption) : null, ew.Validators.integer], fields.idapproval.isInvalid],
        ["idorder", [fields.idorder.visible && fields.idorder.required ? ew.Validators.required(fields.idorder.caption) : null, ew.Validators.integer], fields.idorder.isInvalid],
        ["kredit_terpakai", [fields.kredit_terpakai.visible && fields.kredit_terpakai.required ? ew.Validators.required(fields.kredit_terpakai.caption) : null, ew.Validators.integer], fields.kredit_terpakai.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpo_limit_approval_detailedit,
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
    fpo_limit_approval_detailedit.validate = function () {
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
    fpo_limit_approval_detailedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpo_limit_approval_detailedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpo_limit_approval_detailedit");
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
<form name="fpo_limit_approval_detailedit" id="fpo_limit_approval_detailedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="po_limit_approval_detail">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_po_limit_approval_detail_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<input type="<?= $Page->id->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_id" name="x_id" id="x_id" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
<input type="hidden" data-table="po_limit_approval_detail" data-field="x_id" data-hidden="1" name="o_id" id="o_id" value="<?= HtmlEncode($Page->id->OldValue ?? $Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idapproval->Visible) { // idapproval ?>
    <div id="r_idapproval" class="form-group row">
        <label id="elh_po_limit_approval_detail_idapproval" for="x_idapproval" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idapproval->caption() ?><?= $Page->idapproval->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idapproval->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_idapproval">
<input type="<?= $Page->idapproval->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_idapproval" name="x_idapproval" id="x_idapproval" size="30" placeholder="<?= HtmlEncode($Page->idapproval->getPlaceHolder()) ?>" value="<?= $Page->idapproval->EditValue ?>"<?= $Page->idapproval->editAttributes() ?> aria-describedby="x_idapproval_help">
<?= $Page->idapproval->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idapproval->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
    <div id="r_idorder" class="form-group row">
        <label id="elh_po_limit_approval_detail_idorder" for="x_idorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idorder->caption() ?><?= $Page->idorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idorder->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_idorder">
<input type="<?= $Page->idorder->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_idorder" name="x_idorder" id="x_idorder" size="30" placeholder="<?= HtmlEncode($Page->idorder->getPlaceHolder()) ?>" value="<?= $Page->idorder->EditValue ?>"<?= $Page->idorder->editAttributes() ?> aria-describedby="x_idorder_help">
<?= $Page->idorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kredit_terpakai->Visible) { // kredit_terpakai ?>
    <div id="r_kredit_terpakai" class="form-group row">
        <label id="elh_po_limit_approval_detail_kredit_terpakai" for="x_kredit_terpakai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kredit_terpakai->caption() ?><?= $Page->kredit_terpakai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kredit_terpakai->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_kredit_terpakai">
<input type="<?= $Page->kredit_terpakai->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_kredit_terpakai" name="x_kredit_terpakai" id="x_kredit_terpakai" size="30" placeholder="<?= HtmlEncode($Page->kredit_terpakai->getPlaceHolder()) ?>" value="<?= $Page->kredit_terpakai->EditValue ?>"<?= $Page->kredit_terpakai->editAttributes() ?> aria-describedby="x_kredit_terpakai_help">
<?= $Page->kredit_terpakai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kredit_terpakai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_po_limit_approval_detail_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_po_limit_approval_detail_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="po_limit_approval_detail" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpo_limit_approval_detailedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpo_limit_approval_detailedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
    ew.addEventHandlers("po_limit_approval_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
