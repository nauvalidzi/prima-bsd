<?php

namespace PHPMaker2021\distributor;

// Page object
$KecamatanEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkecamatanedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fkecamatanedit = currentForm = new ew.Form("fkecamatanedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kecamatan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kecamatan)
        ew.vars.tables.kecamatan = currentTable;
    fkecamatanedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["idkabupaten", [fields.idkabupaten.visible && fields.idkabupaten.required ? ew.Validators.required(fields.idkabupaten.caption) : null], fields.idkabupaten.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkecamatanedit,
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
    fkecamatanedit.validate = function () {
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
    fkecamatanedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkecamatanedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fkecamatanedit.lists.idkabupaten = <?= $Page->idkabupaten->toClientList($Page) ?>;
    loadjs.done("fkecamatanedit");
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
<form name="fkecamatanedit" id="fkecamatanedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kecamatan">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_kecamatan_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<input type="<?= $Page->id->getInputTextType() ?>" data-table="kecamatan" data-field="x_id" name="x_id" id="x_id" size="30" maxlength="7" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
<input type="hidden" data-table="kecamatan" data-field="x_id" data-hidden="1" name="o_id" id="o_id" value="<?= HtmlEncode($Page->id->OldValue ?? $Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkabupaten->Visible) { // idkabupaten ?>
    <div id="r_idkabupaten" class="form-group row">
        <label id="elh_kecamatan_idkabupaten" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkabupaten->caption() ?><?= $Page->idkabupaten->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkabupaten->cellAttributes() ?>>
<span id="el_kecamatan_idkabupaten">
<?php
$onchange = $Page->idkabupaten->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idkabupaten->EditAttrs["onchange"] = "";
?>
<span id="as_x_idkabupaten" class="ew-auto-suggest">
    <input type="<?= $Page->idkabupaten->getInputTextType() ?>" class="form-control" name="sv_x_idkabupaten" id="sv_x_idkabupaten" value="<?= RemoveHtml($Page->idkabupaten->EditValue) ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->idkabupaten->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idkabupaten->getPlaceHolder()) ?>"<?= $Page->idkabupaten->editAttributes() ?> aria-describedby="x_idkabupaten_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="kecamatan" data-field="x_idkabupaten" data-input="sv_x_idkabupaten" data-value-separator="<?= $Page->idkabupaten->displayValueSeparatorAttribute() ?>" name="x_idkabupaten" id="x_idkabupaten" value="<?= HtmlEncode($Page->idkabupaten->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->idkabupaten->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idkabupaten->getErrorMessage() ?></div>
<script>
loadjs.ready(["fkecamatanedit"], function() {
    fkecamatanedit.createAutoSuggest(Object.assign({"id":"x_idkabupaten","forceSelect":false}, ew.vars.tables.kecamatan.fields.idkabupaten.autoSuggestOptions));
});
</script>
<?= $Page->idkabupaten->Lookup->getParamTag($Page, "p_x_idkabupaten") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_kecamatan_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_kecamatan_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="kecamatan" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
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
    ew.addEventHandlers("kecamatan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
