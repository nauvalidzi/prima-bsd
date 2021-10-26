<?php

namespace PHPMaker2021\distributor;

// Page object
$PenomoranAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpenomoranadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpenomoranadd = currentForm = new ew.Form("fpenomoranadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "penomoran")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.penomoran)
        ew.vars.tables.penomoran = currentTable;
    fpenomoranadd.addFields([
        ["_menu", [fields._menu.visible && fields._menu.required ? ew.Validators.required(fields._menu.caption) : null], fields._menu.isInvalid],
        ["jumlah_digit", [fields.jumlah_digit.visible && fields.jumlah_digit.required ? ew.Validators.required(fields.jumlah_digit.caption) : null, ew.Validators.integer], fields.jumlah_digit.isInvalid],
        ["format", [fields.format.visible && fields.format.required ? ew.Validators.required(fields.format.caption) : null], fields.format.isInvalid],
        ["display", [fields.display.visible && fields.display.required ? ew.Validators.required(fields.display.caption) : null], fields.display.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpenomoranadd,
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
    fpenomoranadd.validate = function () {
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
    fpenomoranadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpenomoranadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpenomoranadd");
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
<form name="fpenomoranadd" id="fpenomoranadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penomoran">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->_menu->Visible) { // menu ?>
    <div id="r__menu" class="form-group row">
        <label id="elh_penomoran__menu" for="x__menu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_menu->caption() ?><?= $Page->_menu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_menu->cellAttributes() ?>>
<span id="el_penomoran__menu">
<input type="<?= $Page->_menu->getInputTextType() ?>" data-table="penomoran" data-field="x__menu" name="x__menu" id="x__menu" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->_menu->getPlaceHolder()) ?>" value="<?= $Page->_menu->EditValue ?>"<?= $Page->_menu->editAttributes() ?> aria-describedby="x__menu_help">
<?= $Page->_menu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_menu->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah_digit->Visible) { // jumlah_digit ?>
    <div id="r_jumlah_digit" class="form-group row">
        <label id="elh_penomoran_jumlah_digit" for="x_jumlah_digit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah_digit->caption() ?><?= $Page->jumlah_digit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah_digit->cellAttributes() ?>>
<span id="el_penomoran_jumlah_digit">
<input type="<?= $Page->jumlah_digit->getInputTextType() ?>" data-table="penomoran" data-field="x_jumlah_digit" name="x_jumlah_digit" id="x_jumlah_digit" size="30" placeholder="<?= HtmlEncode($Page->jumlah_digit->getPlaceHolder()) ?>" value="<?= $Page->jumlah_digit->EditValue ?>"<?= $Page->jumlah_digit->editAttributes() ?> aria-describedby="x_jumlah_digit_help">
<?= $Page->jumlah_digit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah_digit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->format->Visible) { // format ?>
    <div id="r_format" class="form-group row">
        <label id="elh_penomoran_format" for="x_format" class="<?= $Page->LeftColumnClass ?>"><?= $Page->format->caption() ?><?= $Page->format->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->format->cellAttributes() ?>>
<span id="el_penomoran_format">
<input type="<?= $Page->format->getInputTextType() ?>" data-table="penomoran" data-field="x_format" name="x_format" id="x_format" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->format->getPlaceHolder()) ?>" value="<?= $Page->format->EditValue ?>"<?= $Page->format->editAttributes() ?> aria-describedby="x_format_help">
<?= $Page->format->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->format->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->display->Visible) { // display ?>
    <div id="r_display" class="form-group row">
        <label id="elh_penomoran_display" for="x_display" class="<?= $Page->LeftColumnClass ?>"><?= $Page->display->caption() ?><?= $Page->display->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->display->cellAttributes() ?>>
<span id="el_penomoran_display">
<input type="<?= $Page->display->getInputTextType() ?>" data-table="penomoran" data-field="x_display" name="x_display" id="x_display" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->display->getPlaceHolder()) ?>" value="<?= $Page->display->EditValue ?>"<?= $Page->display->editAttributes() ?> aria-describedby="x_display_help">
<?= $Page->display->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->display->getErrorMessage() ?></div>
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
    ew.addEventHandlers("penomoran");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
