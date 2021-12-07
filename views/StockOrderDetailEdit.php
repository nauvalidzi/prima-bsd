<?php

namespace PHPMaker2021\distributor;

// Page object
$StockOrderDetailEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstock_order_detailedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fstock_order_detailedit = currentForm = new ew.Form("fstock_order_detailedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "stock_order_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.stock_order_detail)
        ew.vars.tables.stock_order_detail = currentTable;
    fstock_order_detailedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null, ew.Validators.integer], fields.idbrand.isInvalid],
        ["idproduct", [fields.idproduct.visible && fields.idproduct.required ? ew.Validators.required(fields.idproduct.caption) : null, ew.Validators.integer], fields.idproduct.isInvalid],
        ["stok_akhir", [fields.stok_akhir.visible && fields.stok_akhir.required ? ew.Validators.required(fields.stok_akhir.caption) : null, ew.Validators.integer], fields.stok_akhir.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["aktif", [fields.aktif.visible && fields.aktif.required ? ew.Validators.required(fields.aktif.caption) : null], fields.aktif.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstock_order_detailedit,
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
    fstock_order_detailedit.validate = function () {
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
    fstock_order_detailedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstock_order_detailedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fstock_order_detailedit.lists.aktif = <?= $Page->aktif->toClientList($Page) ?>;
    loadjs.done("fstock_order_detailedit");
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
<form name="fstock_order_detailedit" id="fstock_order_detailedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock_order_detail">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "stock_order") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="stock_order">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_stock_order_detail_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_stock_order_detail_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_order_detail" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <div id="r_pid" class="form-group row">
        <label id="elh_stock_order_detail_pid" for="x_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el_stock_order_detail_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid" name="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_stock_order_detail_pid">
<input type="<?= $Page->pid->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_pid" name="x_pid" id="x_pid" size="30" placeholder="<?= HtmlEncode($Page->pid->getPlaceHolder()) ?>" value="<?= $Page->pid->EditValue ?>"<?= $Page->pid->editAttributes() ?> aria-describedby="x_pid_help">
<?= $Page->pid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <div id="r_idbrand" class="form-group row">
        <label id="elh_stock_order_detail_idbrand" for="x_idbrand" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idbrand->caption() ?><?= $Page->idbrand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idbrand->cellAttributes() ?>>
<span id="el_stock_order_detail_idbrand">
<input type="<?= $Page->idbrand->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_idbrand" name="x_idbrand" id="x_idbrand" size="30" placeholder="<?= HtmlEncode($Page->idbrand->getPlaceHolder()) ?>" value="<?= $Page->idbrand->EditValue ?>"<?= $Page->idbrand->editAttributes() ?> aria-describedby="x_idbrand_help">
<?= $Page->idbrand->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idbrand->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
    <div id="r_idproduct" class="form-group row">
        <label id="elh_stock_order_detail_idproduct" for="x_idproduct" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct->caption() ?><?= $Page->idproduct->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct->cellAttributes() ?>>
<span id="el_stock_order_detail_idproduct">
<input type="<?= $Page->idproduct->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_idproduct" name="x_idproduct" id="x_idproduct" size="30" placeholder="<?= HtmlEncode($Page->idproduct->getPlaceHolder()) ?>" value="<?= $Page->idproduct->EditValue ?>"<?= $Page->idproduct->editAttributes() ?> aria-describedby="x_idproduct_help">
<?= $Page->idproduct->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idproduct->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
    <div id="r_stok_akhir" class="form-group row">
        <label id="elh_stock_order_detail_stok_akhir" for="x_stok_akhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->stok_akhir->caption() ?><?= $Page->stok_akhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->stok_akhir->cellAttributes() ?>>
<span id="el_stock_order_detail_stok_akhir">
<input type="<?= $Page->stok_akhir->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_stok_akhir" name="x_stok_akhir" id="x_stok_akhir" size="30" placeholder="<?= HtmlEncode($Page->stok_akhir->getPlaceHolder()) ?>" value="<?= $Page->stok_akhir->EditValue ?>"<?= $Page->stok_akhir->editAttributes() ?> aria-describedby="x_stok_akhir_help">
<?= $Page->stok_akhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->stok_akhir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <div id="r_jumlah" class="form-group row">
        <label id="elh_stock_order_detail_jumlah" for="x_jumlah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah->caption() ?><?= $Page->jumlah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_stock_order_detail_jumlah">
<input type="<?= $Page->jumlah->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?= HtmlEncode($Page->jumlah->getPlaceHolder()) ?>" value="<?= $Page->jumlah->EditValue ?>"<?= $Page->jumlah->editAttributes() ?> aria-describedby="x_jumlah_help">
<?= $Page->jumlah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <div id="r_sisa" class="form-group row">
        <label id="elh_stock_order_detail_sisa" for="x_sisa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sisa->caption() ?><?= $Page->sisa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sisa->cellAttributes() ?>>
<span id="el_stock_order_detail_sisa">
<input type="<?= $Page->sisa->getInputTextType() ?>" data-table="stock_order_detail" data-field="x_sisa" name="x_sisa" id="x_sisa" size="30" placeholder="<?= HtmlEncode($Page->sisa->getPlaceHolder()) ?>" value="<?= $Page->sisa->EditValue ?>"<?= $Page->sisa->editAttributes() ?> aria-describedby="x_sisa_help">
<?= $Page->sisa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sisa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_stock_order_detail_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_stock_order_detail_keterangan">
<textarea data-table="stock_order_detail" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif" class="form-group row">
        <label id="elh_stock_order_detail_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktif->caption() ?><?= $Page->aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktif->cellAttributes() ?>>
<span id="el_stock_order_detail_aktif">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->aktif->isInvalidClass() ?>" data-table="stock_order_detail" data-field="x_aktif" name="x_aktif[]" id="x_aktif_706182" value="1"<?= ConvertToBool($Page->aktif->CurrentValue) ? " checked" : "" ?><?= $Page->aktif->editAttributes() ?> aria-describedby="x_aktif_help">
    <label class="custom-control-label" for="x_aktif_706182"></label>
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
    ew.addEventHandlers("stock_order_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
