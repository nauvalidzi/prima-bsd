<?php

namespace PHPMaker2021\production2;

// Page object
$KabupatenEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkabupatenedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fkabupatenedit = currentForm = new ew.Form("fkabupatenedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kabupaten")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kabupaten)
        ew.vars.tables.kabupaten = currentTable;
    fkabupatenedit.addFields([
        ["idprovinsi", [fields.idprovinsi.visible && fields.idprovinsi.required ? ew.Validators.required(fields.idprovinsi.caption) : null, ew.Validators.integer], fields.idprovinsi.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkabupatenedit,
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
    fkabupatenedit.validate = function () {
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
    fkabupatenedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkabupatenedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fkabupatenedit.lists.idprovinsi = <?= $Page->idprovinsi->toClientList($Page) ?>;
    loadjs.done("fkabupatenedit");
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
<form name="fkabupatenedit" id="fkabupatenedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kabupaten">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idprovinsi->Visible) { // idprovinsi ?>
    <div id="r_idprovinsi" class="form-group row">
        <label id="elh_kabupaten_idprovinsi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idprovinsi->caption() ?><?= $Page->idprovinsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idprovinsi->cellAttributes() ?>>
<span id="el_kabupaten_idprovinsi">
<?php
$onchange = $Page->idprovinsi->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idprovinsi->EditAttrs["onchange"] = "";
?>
<span id="as_x_idprovinsi" class="ew-auto-suggest">
    <input type="<?= $Page->idprovinsi->getInputTextType() ?>" class="form-control" name="sv_x_idprovinsi" id="sv_x_idprovinsi" value="<?= RemoveHtml($Page->idprovinsi->EditValue) ?>" size="30" maxlength="2" placeholder="<?= HtmlEncode($Page->idprovinsi->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idprovinsi->getPlaceHolder()) ?>"<?= $Page->idprovinsi->editAttributes() ?> aria-describedby="x_idprovinsi_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="kabupaten" data-field="x_idprovinsi" data-input="sv_x_idprovinsi" data-value-separator="<?= $Page->idprovinsi->displayValueSeparatorAttribute() ?>" name="x_idprovinsi" id="x_idprovinsi" value="<?= HtmlEncode($Page->idprovinsi->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->idprovinsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idprovinsi->getErrorMessage() ?></div>
<script>
loadjs.ready(["fkabupatenedit"], function() {
    fkabupatenedit.createAutoSuggest(Object.assign({"id":"x_idprovinsi","forceSelect":false}, ew.vars.tables.kabupaten.fields.idprovinsi.autoSuggestOptions));
});
</script>
<?= $Page->idprovinsi->Lookup->getParamTag($Page, "p_x_idprovinsi") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_kabupaten_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_kabupaten_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="kabupaten" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="kabupaten" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("kabupaten");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
