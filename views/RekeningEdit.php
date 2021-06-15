<?php

namespace PHPMaker2021\distributor;

// Page object
$RekeningEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var frekeningedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    frekeningedit = currentForm = new ew.Form("frekeningedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "rekening")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.rekening)
        ew.vars.tables.rekening = currentTable;
    frekeningedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["nama_bank", [fields.nama_bank.visible && fields.nama_bank.required ? ew.Validators.required(fields.nama_bank.caption) : null], fields.nama_bank.isInvalid],
        ["nama_account", [fields.nama_account.visible && fields.nama_account.required ? ew.Validators.required(fields.nama_account.caption) : null], fields.nama_account.isInvalid],
        ["no_rek", [fields.no_rek.visible && fields.no_rek.required ? ew.Validators.required(fields.no_rek.caption) : null], fields.no_rek.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = frekeningedit,
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
    frekeningedit.validate = function () {
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
    frekeningedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    frekeningedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("frekeningedit");
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
<form name="frekeningedit" id="frekeningedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="rekening">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_rekening_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_rekening_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="rekening" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_bank->Visible) { // nama_bank ?>
    <div id="r_nama_bank" class="form-group row">
        <label id="elh_rekening_nama_bank" for="x_nama_bank" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_bank->caption() ?><?= $Page->nama_bank->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_bank->cellAttributes() ?>>
<span id="el_rekening_nama_bank">
<input type="<?= $Page->nama_bank->getInputTextType() ?>" data-table="rekening" data-field="x_nama_bank" name="x_nama_bank" id="x_nama_bank" size="30" maxlength="225" placeholder="<?= HtmlEncode($Page->nama_bank->getPlaceHolder()) ?>" value="<?= $Page->nama_bank->EditValue ?>"<?= $Page->nama_bank->editAttributes() ?> aria-describedby="x_nama_bank_help">
<?= $Page->nama_bank->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_bank->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_account->Visible) { // nama_account ?>
    <div id="r_nama_account" class="form-group row">
        <label id="elh_rekening_nama_account" for="x_nama_account" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_account->caption() ?><?= $Page->nama_account->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_account->cellAttributes() ?>>
<span id="el_rekening_nama_account">
<input type="<?= $Page->nama_account->getInputTextType() ?>" data-table="rekening" data-field="x_nama_account" name="x_nama_account" id="x_nama_account" size="30" maxlength="225" placeholder="<?= HtmlEncode($Page->nama_account->getPlaceHolder()) ?>" value="<?= $Page->nama_account->EditValue ?>"<?= $Page->nama_account->editAttributes() ?> aria-describedby="x_nama_account_help">
<?= $Page->nama_account->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_account->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_rek->Visible) { // no_rek ?>
    <div id="r_no_rek" class="form-group row">
        <label id="elh_rekening_no_rek" for="x_no_rek" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_rek->caption() ?><?= $Page->no_rek->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_rek->cellAttributes() ?>>
<span id="el_rekening_no_rek">
<input type="<?= $Page->no_rek->getInputTextType() ?>" data-table="rekening" data-field="x_no_rek" name="x_no_rek" id="x_no_rek" size="30" maxlength="225" placeholder="<?= HtmlEncode($Page->no_rek->getPlaceHolder()) ?>" value="<?= $Page->no_rek->EditValue ?>"<?= $Page->no_rek->editAttributes() ?> aria-describedby="x_no_rek_help">
<?= $Page->no_rek->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_rek->getErrorMessage() ?></div>
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
    ew.addEventHandlers("rekening");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
