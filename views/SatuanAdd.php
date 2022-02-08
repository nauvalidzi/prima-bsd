<?php

namespace PHPMaker2021\production2;

// Page object
$SatuanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsatuanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsatuanadd = currentForm = new ew.Form("fsatuanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "satuan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.satuan)
        ew.vars.tables.satuan = currentTable;
    fsatuanadd.addFields([
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["konversi", [fields.konversi.visible && fields.konversi.required ? ew.Validators.required(fields.konversi.caption) : null, ew.Validators.integer], fields.konversi.isInvalid],
        ["unit_konversi", [fields.unit_konversi.visible && fields.unit_konversi.required ? ew.Validators.required(fields.unit_konversi.caption) : null], fields.unit_konversi.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsatuanadd,
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
    fsatuanadd.validate = function () {
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
    fsatuanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsatuanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsatuanadd");
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
<form name="fsatuanadd" id="fsatuanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="satuan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_satuan_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_satuan_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="satuan" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->konversi->Visible) { // konversi ?>
    <div id="r_konversi" class="form-group row">
        <label id="elh_satuan_konversi" for="x_konversi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->konversi->caption() ?><?= $Page->konversi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->konversi->cellAttributes() ?>>
<span id="el_satuan_konversi">
<input type="<?= $Page->konversi->getInputTextType() ?>" data-table="satuan" data-field="x_konversi" name="x_konversi" id="x_konversi" size="30" placeholder="<?= HtmlEncode($Page->konversi->getPlaceHolder()) ?>" value="<?= $Page->konversi->EditValue ?>"<?= $Page->konversi->editAttributes() ?> aria-describedby="x_konversi_help">
<?= $Page->konversi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->konversi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unit_konversi->Visible) { // unit_konversi ?>
    <div id="r_unit_konversi" class="form-group row">
        <label id="elh_satuan_unit_konversi" for="x_unit_konversi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unit_konversi->caption() ?><?= $Page->unit_konversi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unit_konversi->cellAttributes() ?>>
<span id="el_satuan_unit_konversi">
<input type="<?= $Page->unit_konversi->getInputTextType() ?>" data-table="satuan" data-field="x_unit_konversi" name="x_unit_konversi" id="x_unit_konversi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->unit_konversi->getPlaceHolder()) ?>" value="<?= $Page->unit_konversi->EditValue ?>"<?= $Page->unit_konversi->editAttributes() ?> aria-describedby="x_unit_konversi_help">
<?= $Page->unit_konversi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->unit_konversi->getErrorMessage() ?></div>
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
    ew.addEventHandlers("satuan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
