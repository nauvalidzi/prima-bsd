<?php

namespace PHPMaker2021\distributor;

// Page object
$KelurahanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkelurahanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fkelurahanadd = currentForm = new ew.Form("fkelurahanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kelurahan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kelurahan)
        ew.vars.tables.kelurahan = currentTable;
    fkelurahanadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["idkecamatan", [fields.idkecamatan.visible && fields.idkecamatan.required ? ew.Validators.required(fields.idkecamatan.caption) : null, ew.Validators.integer], fields.idkecamatan.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkelurahanadd,
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
    fkelurahanadd.validate = function () {
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
    fkelurahanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkelurahanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fkelurahanadd.lists.idkecamatan = <?= $Page->idkecamatan->toClientList($Page) ?>;
    loadjs.done("fkelurahanadd");
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
<form name="fkelurahanadd" id="fkelurahanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kelurahan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_kelurahan_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_kelurahan_id">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="kelurahan" data-field="x_id" name="x_id" id="x_id" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkecamatan->Visible) { // idkecamatan ?>
    <div id="r_idkecamatan" class="form-group row">
        <label id="elh_kelurahan_idkecamatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkecamatan->caption() ?><?= $Page->idkecamatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkecamatan->cellAttributes() ?>>
<span id="el_kelurahan_idkecamatan">
<?php
$onchange = $Page->idkecamatan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idkecamatan->EditAttrs["onchange"] = "";
?>
<span id="as_x_idkecamatan" class="ew-auto-suggest">
    <input type="<?= $Page->idkecamatan->getInputTextType() ?>" class="form-control" name="sv_x_idkecamatan" id="sv_x_idkecamatan" value="<?= RemoveHtml($Page->idkecamatan->EditValue) ?>" size="30" maxlength="7" placeholder="<?= HtmlEncode($Page->idkecamatan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idkecamatan->getPlaceHolder()) ?>"<?= $Page->idkecamatan->editAttributes() ?> aria-describedby="x_idkecamatan_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="kelurahan" data-field="x_idkecamatan" data-input="sv_x_idkecamatan" data-value-separator="<?= $Page->idkecamatan->displayValueSeparatorAttribute() ?>" name="x_idkecamatan" id="x_idkecamatan" value="<?= HtmlEncode($Page->idkecamatan->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->idkecamatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idkecamatan->getErrorMessage() ?></div>
<script>
loadjs.ready(["fkelurahanadd"], function() {
    fkelurahanadd.createAutoSuggest(Object.assign({"id":"x_idkecamatan","forceSelect":false}, ew.vars.tables.kelurahan.fields.idkecamatan.autoSuggestOptions));
});
</script>
<?= $Page->idkecamatan->Lookup->getParamTag($Page, "p_x_idkecamatan") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_kelurahan_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_kelurahan_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="kelurahan" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
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
    ew.addEventHandlers("kelurahan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
