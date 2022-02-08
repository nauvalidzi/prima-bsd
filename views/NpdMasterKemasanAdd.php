<?php

namespace PHPMaker2021\production2;

// Page object
$NpdMasterKemasanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_master_kemasanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_master_kemasanadd = currentForm = new ew.Form("fnpd_master_kemasanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_master_kemasan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_master_kemasan)
        ew.vars.tables.npd_master_kemasan = currentTable;
    fnpd_master_kemasanadd.addFields([
        ["grup", [fields.grup.visible && fields.grup.required ? ew.Validators.required(fields.grup.caption) : null], fields.grup.isInvalid],
        ["jenis", [fields.jenis.visible && fields.jenis.required ? ew.Validators.required(fields.jenis.caption) : null], fields.jenis.isInvalid],
        ["subjenis", [fields.subjenis.visible && fields.subjenis.required ? ew.Validators.required(fields.subjenis.caption) : null], fields.subjenis.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["nour", [fields.nour.visible && fields.nour.required ? ew.Validators.required(fields.nour.caption) : null, ew.Validators.integer], fields.nour.isInvalid],
        ["updated_user", [fields.updated_user.visible && fields.updated_user.required ? ew.Validators.required(fields.updated_user.caption) : null, ew.Validators.integer], fields.updated_user.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_master_kemasanadd,
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
    fnpd_master_kemasanadd.validate = function () {
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
    fnpd_master_kemasanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_master_kemasanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnpd_master_kemasanadd");
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
<form name="fnpd_master_kemasanadd" id="fnpd_master_kemasanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_master_kemasan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->grup->Visible) { // grup ?>
    <div id="r_grup" class="form-group row">
        <label id="elh_npd_master_kemasan_grup" for="x_grup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grup->caption() ?><?= $Page->grup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->grup->cellAttributes() ?>>
<span id="el_npd_master_kemasan_grup">
<input type="<?= $Page->grup->getInputTextType() ?>" data-table="npd_master_kemasan" data-field="x_grup" name="x_grup" id="x_grup" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->grup->getPlaceHolder()) ?>" value="<?= $Page->grup->EditValue ?>"<?= $Page->grup->editAttributes() ?> aria-describedby="x_grup_help">
<?= $Page->grup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->grup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenis->Visible) { // jenis ?>
    <div id="r_jenis" class="form-group row">
        <label id="elh_npd_master_kemasan_jenis" for="x_jenis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenis->caption() ?><?= $Page->jenis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis->cellAttributes() ?>>
<span id="el_npd_master_kemasan_jenis">
<input type="<?= $Page->jenis->getInputTextType() ?>" data-table="npd_master_kemasan" data-field="x_jenis" name="x_jenis" id="x_jenis" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jenis->getPlaceHolder()) ?>" value="<?= $Page->jenis->EditValue ?>"<?= $Page->jenis->editAttributes() ?> aria-describedby="x_jenis_help">
<?= $Page->jenis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenis->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subjenis->Visible) { // subjenis ?>
    <div id="r_subjenis" class="form-group row">
        <label id="elh_npd_master_kemasan_subjenis" for="x_subjenis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subjenis->caption() ?><?= $Page->subjenis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->subjenis->cellAttributes() ?>>
<span id="el_npd_master_kemasan_subjenis">
<input type="<?= $Page->subjenis->getInputTextType() ?>" data-table="npd_master_kemasan" data-field="x_subjenis" name="x_subjenis" id="x_subjenis" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->subjenis->getPlaceHolder()) ?>" value="<?= $Page->subjenis->EditValue ?>"<?= $Page->subjenis->editAttributes() ?> aria-describedby="x_subjenis_help">
<?= $Page->subjenis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subjenis->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_npd_master_kemasan_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_master_kemasan_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="npd_master_kemasan" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
    <div id="r_nour" class="form-group row">
        <label id="elh_npd_master_kemasan_nour" for="x_nour" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nour->caption() ?><?= $Page->nour->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nour->cellAttributes() ?>>
<span id="el_npd_master_kemasan_nour">
<input type="<?= $Page->nour->getInputTextType() ?>" data-table="npd_master_kemasan" data-field="x_nour" name="x_nour" id="x_nour" size="30" placeholder="<?= HtmlEncode($Page->nour->getPlaceHolder()) ?>" value="<?= $Page->nour->EditValue ?>"<?= $Page->nour->editAttributes() ?> aria-describedby="x_nour_help">
<?= $Page->nour->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nour->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
    <div id="r_updated_user" class="form-group row">
        <label id="elh_npd_master_kemasan_updated_user" for="x_updated_user" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_user->caption() ?><?= $Page->updated_user->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_user->cellAttributes() ?>>
<span id="el_npd_master_kemasan_updated_user">
<input type="<?= $Page->updated_user->getInputTextType() ?>" data-table="npd_master_kemasan" data-field="x_updated_user" name="x_updated_user" id="x_updated_user" size="30" placeholder="<?= HtmlEncode($Page->updated_user->getPlaceHolder()) ?>" value="<?= $Page->updated_user->EditValue ?>"<?= $Page->updated_user->editAttributes() ?> aria-describedby="x_updated_user_help">
<?= $Page->updated_user->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_user->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_npd_master_kemasan_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_master_kemasan_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="npd_master_kemasan" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_master_kemasanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_master_kemasanadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
    ew.addEventHandlers("npd_master_kemasan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
