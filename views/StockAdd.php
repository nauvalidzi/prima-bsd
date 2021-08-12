<?php

namespace PHPMaker2021\distributor;

// Page object
$StockAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstockadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fstockadd = currentForm = new ew.Form("fstockadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "stock")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.stock)
        ew.vars.tables.stock = currentTable;
    fstockadd.addFields([
        ["idproduct", [fields.idproduct.visible && fields.idproduct.required ? ew.Validators.required(fields.idproduct.caption) : null, ew.Validators.integer], fields.idproduct.isInvalid],
        ["idorder_detail", [fields.idorder_detail.visible && fields.idorder_detail.required ? ew.Validators.required(fields.idorder_detail.caption) : null, ew.Validators.integer], fields.idorder_detail.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid],
        ["aktif", [fields.aktif.visible && fields.aktif.required ? ew.Validators.required(fields.aktif.caption) : null], fields.aktif.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstockadd,
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
    fstockadd.validate = function () {
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
    fstockadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstockadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fstockadd.lists.aktif = <?= $Page->aktif->toClientList($Page) ?>;
    loadjs.done("fstockadd");
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
<form name="fstockadd" id="fstockadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idproduct->Visible) { // idproduct ?>
    <div id="r_idproduct" class="form-group row">
        <label id="elh_stock_idproduct" for="x_idproduct" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct->caption() ?><?= $Page->idproduct->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct->cellAttributes() ?>>
<span id="el_stock_idproduct">
<input type="<?= $Page->idproduct->getInputTextType() ?>" data-table="stock" data-field="x_idproduct" name="x_idproduct" id="x_idproduct" size="30" placeholder="<?= HtmlEncode($Page->idproduct->getPlaceHolder()) ?>" value="<?= $Page->idproduct->EditValue ?>"<?= $Page->idproduct->editAttributes() ?> aria-describedby="x_idproduct_help">
<?= $Page->idproduct->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idproduct->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
    <div id="r_idorder_detail" class="form-group row">
        <label id="elh_stock_idorder_detail" for="x_idorder_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idorder_detail->caption() ?><?= $Page->idorder_detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el_stock_idorder_detail">
<input type="<?= $Page->idorder_detail->getInputTextType() ?>" data-table="stock" data-field="x_idorder_detail" name="x_idorder_detail" id="x_idorder_detail" size="30" placeholder="<?= HtmlEncode($Page->idorder_detail->getPlaceHolder()) ?>" value="<?= $Page->idorder_detail->EditValue ?>"<?= $Page->idorder_detail->editAttributes() ?> aria-describedby="x_idorder_detail_help">
<?= $Page->idorder_detail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idorder_detail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <div id="r_jumlah" class="form-group row">
        <label id="elh_stock_jumlah" for="x_jumlah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah->caption() ?><?= $Page->jumlah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_stock_jumlah">
<input type="<?= $Page->jumlah->getInputTextType() ?>" data-table="stock" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?= HtmlEncode($Page->jumlah->getPlaceHolder()) ?>" value="<?= $Page->jumlah->EditValue ?>"<?= $Page->jumlah->editAttributes() ?> aria-describedby="x_jumlah_help">
<?= $Page->jumlah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif" class="form-group row">
        <label id="elh_stock_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktif->caption() ?><?= $Page->aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktif->cellAttributes() ?>>
<span id="el_stock_aktif">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->aktif->isInvalidClass() ?>" data-table="stock" data-field="x_aktif" name="x_aktif[]" id="x_aktif_971418" value="1"<?= ConvertToBool($Page->aktif->CurrentValue) ? " checked" : "" ?><?= $Page->aktif->editAttributes() ?> aria-describedby="x_aktif_help">
    <label class="custom-control-label" for="x_aktif_971418"></label>
</div>
<?= $Page->aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aktif->getErrorMessage() ?></div>
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
    ew.addEventHandlers("stock");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
