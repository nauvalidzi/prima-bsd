<?php

namespace PHPMaker2021\distributor;

// Page object
$StocksAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstocksadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fstocksadd = currentForm = new ew.Form("fstocksadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "stocks")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.stocks)
        ew.vars.tables.stocks = currentTable;
    fstocksadd.addFields([
        ["prop_id", [fields.prop_id.visible && fields.prop_id.required ? ew.Validators.required(fields.prop_id.caption) : null, ew.Validators.integer], fields.prop_id.isInvalid],
        ["prop_code", [fields.prop_code.visible && fields.prop_code.required ? ew.Validators.required(fields.prop_code.caption) : null], fields.prop_code.isInvalid],
        ["idproduct", [fields.idproduct.visible && fields.idproduct.required ? ew.Validators.required(fields.idproduct.caption) : null, ew.Validators.integer], fields.idproduct.isInvalid],
        ["stok_masuk", [fields.stok_masuk.visible && fields.stok_masuk.required ? ew.Validators.required(fields.stok_masuk.caption) : null, ew.Validators.integer], fields.stok_masuk.isInvalid],
        ["stok_keluar", [fields.stok_keluar.visible && fields.stok_keluar.required ? ew.Validators.required(fields.stok_keluar.caption) : null, ew.Validators.integer], fields.stok_keluar.isInvalid],
        ["stok_akhir", [fields.stok_akhir.visible && fields.stok_akhir.required ? ew.Validators.required(fields.stok_akhir.caption) : null, ew.Validators.integer], fields.stok_akhir.isInvalid],
        ["aktif", [fields.aktif.visible && fields.aktif.required ? ew.Validators.required(fields.aktif.caption) : null], fields.aktif.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstocksadd,
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
    fstocksadd.validate = function () {
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
    fstocksadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstocksadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fstocksadd.lists.aktif = <?= $Page->aktif->toClientList($Page) ?>;
    loadjs.done("fstocksadd");
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
<form name="fstocksadd" id="fstocksadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stocks">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->prop_id->Visible) { // prop_id ?>
    <div id="r_prop_id" class="form-group row">
        <label id="elh_stocks_prop_id" for="x_prop_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->prop_id->caption() ?><?= $Page->prop_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->prop_id->cellAttributes() ?>>
<span id="el_stocks_prop_id">
<input type="<?= $Page->prop_id->getInputTextType() ?>" data-table="stocks" data-field="x_prop_id" name="x_prop_id" id="x_prop_id" size="30" placeholder="<?= HtmlEncode($Page->prop_id->getPlaceHolder()) ?>" value="<?= $Page->prop_id->EditValue ?>"<?= $Page->prop_id->editAttributes() ?> aria-describedby="x_prop_id_help">
<?= $Page->prop_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->prop_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->prop_code->Visible) { // prop_code ?>
    <div id="r_prop_code" class="form-group row">
        <label id="elh_stocks_prop_code" for="x_prop_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->prop_code->caption() ?><?= $Page->prop_code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->prop_code->cellAttributes() ?>>
<span id="el_stocks_prop_code">
<input type="<?= $Page->prop_code->getInputTextType() ?>" data-table="stocks" data-field="x_prop_code" name="x_prop_code" id="x_prop_code" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->prop_code->getPlaceHolder()) ?>" value="<?= $Page->prop_code->EditValue ?>"<?= $Page->prop_code->editAttributes() ?> aria-describedby="x_prop_code_help">
<?= $Page->prop_code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->prop_code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
    <div id="r_idproduct" class="form-group row">
        <label id="elh_stocks_idproduct" for="x_idproduct" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct->caption() ?><?= $Page->idproduct->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct->cellAttributes() ?>>
<span id="el_stocks_idproduct">
<input type="<?= $Page->idproduct->getInputTextType() ?>" data-table="stocks" data-field="x_idproduct" name="x_idproduct" id="x_idproduct" size="30" placeholder="<?= HtmlEncode($Page->idproduct->getPlaceHolder()) ?>" value="<?= $Page->idproduct->EditValue ?>"<?= $Page->idproduct->editAttributes() ?> aria-describedby="x_idproduct_help">
<?= $Page->idproduct->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idproduct->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->stok_masuk->Visible) { // stok_masuk ?>
    <div id="r_stok_masuk" class="form-group row">
        <label id="elh_stocks_stok_masuk" for="x_stok_masuk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->stok_masuk->caption() ?><?= $Page->stok_masuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->stok_masuk->cellAttributes() ?>>
<span id="el_stocks_stok_masuk">
<input type="<?= $Page->stok_masuk->getInputTextType() ?>" data-table="stocks" data-field="x_stok_masuk" name="x_stok_masuk" id="x_stok_masuk" size="30" placeholder="<?= HtmlEncode($Page->stok_masuk->getPlaceHolder()) ?>" value="<?= $Page->stok_masuk->EditValue ?>"<?= $Page->stok_masuk->editAttributes() ?> aria-describedby="x_stok_masuk_help">
<?= $Page->stok_masuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->stok_masuk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->stok_keluar->Visible) { // stok_keluar ?>
    <div id="r_stok_keluar" class="form-group row">
        <label id="elh_stocks_stok_keluar" for="x_stok_keluar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->stok_keluar->caption() ?><?= $Page->stok_keluar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->stok_keluar->cellAttributes() ?>>
<span id="el_stocks_stok_keluar">
<input type="<?= $Page->stok_keluar->getInputTextType() ?>" data-table="stocks" data-field="x_stok_keluar" name="x_stok_keluar" id="x_stok_keluar" size="30" placeholder="<?= HtmlEncode($Page->stok_keluar->getPlaceHolder()) ?>" value="<?= $Page->stok_keluar->EditValue ?>"<?= $Page->stok_keluar->editAttributes() ?> aria-describedby="x_stok_keluar_help">
<?= $Page->stok_keluar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->stok_keluar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
    <div id="r_stok_akhir" class="form-group row">
        <label id="elh_stocks_stok_akhir" for="x_stok_akhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->stok_akhir->caption() ?><?= $Page->stok_akhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->stok_akhir->cellAttributes() ?>>
<span id="el_stocks_stok_akhir">
<input type="<?= $Page->stok_akhir->getInputTextType() ?>" data-table="stocks" data-field="x_stok_akhir" name="x_stok_akhir" id="x_stok_akhir" size="30" placeholder="<?= HtmlEncode($Page->stok_akhir->getPlaceHolder()) ?>" value="<?= $Page->stok_akhir->EditValue ?>"<?= $Page->stok_akhir->editAttributes() ?> aria-describedby="x_stok_akhir_help">
<?= $Page->stok_akhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->stok_akhir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif" class="form-group row">
        <label id="elh_stocks_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktif->caption() ?><?= $Page->aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktif->cellAttributes() ?>>
<span id="el_stocks_aktif">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->aktif->isInvalidClass() ?>" data-table="stocks" data-field="x_aktif" name="x_aktif[]" id="x_aktif_621421" value="1"<?= ConvertToBool($Page->aktif->CurrentValue) ? " checked" : "" ?><?= $Page->aktif->editAttributes() ?> aria-describedby="x_aktif_help">
    <label class="custom-control-label" for="x_aktif_621421"></label>
</div>
<?= $Page->aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aktif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_stocks_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_stocks_keterangan">
<textarea data-table="stocks" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_stocks_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_stocks_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="stocks" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fstocksadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fstocksadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
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
    ew.addEventHandlers("stocks");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
