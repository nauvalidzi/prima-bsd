<?php

namespace PHPMaker2021\distributor;

// Page object
$StockDeliveryorderDetailEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstock_deliveryorder_detailedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fstock_deliveryorder_detailedit = currentForm = new ew.Form("fstock_deliveryorder_detailedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "stock_deliveryorder_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.stock_deliveryorder_detail)
        ew.vars.tables.stock_deliveryorder_detail = currentTable;
    fstock_deliveryorder_detailedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["idstock_order_detail", [fields.idstock_order_detail.visible && fields.idstock_order_detail.required ? ew.Validators.required(fields.idstock_order_detail.caption) : null, ew.Validators.integer], fields.idstock_order_detail.isInvalid],
        ["totalorder", [fields.totalorder.visible && fields.totalorder.required ? ew.Validators.required(fields.totalorder.caption) : null, ew.Validators.integer], fields.totalorder.isInvalid],
        ["jumlah_kirim", [fields.jumlah_kirim.visible && fields.jumlah_kirim.required ? ew.Validators.required(fields.jumlah_kirim.caption) : null, ew.Validators.integer], fields.jumlah_kirim.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstock_deliveryorder_detailedit,
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
    fstock_deliveryorder_detailedit.validate = function () {
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
    fstock_deliveryorder_detailedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstock_deliveryorder_detailedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fstock_deliveryorder_detailedit");
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
<form name="fstock_deliveryorder_detailedit" id="fstock_deliveryorder_detailedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock_deliveryorder_detail">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "stock_deliveryorder") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="stock_deliveryorder">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="stock_deliveryorder_detail" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <div id="r_pid" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_pid" for="x_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el_stock_deliveryorder_detail_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid" name="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_stock_deliveryorder_detail_pid">
<input type="<?= $Page->pid->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_pid" name="x_pid" id="x_pid" size="30" placeholder="<?= HtmlEncode($Page->pid->getPlaceHolder()) ?>" value="<?= $Page->pid->EditValue ?>"<?= $Page->pid->editAttributes() ?> aria-describedby="x_pid_help">
<?= $Page->pid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idstock_order_detail->Visible) { // idstock_order_detail ?>
    <div id="r_idstock_order_detail" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_idstock_order_detail" for="x_idstock_order_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idstock_order_detail->caption() ?><?= $Page->idstock_order_detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idstock_order_detail->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_idstock_order_detail">
<input type="<?= $Page->idstock_order_detail->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_idstock_order_detail" name="x_idstock_order_detail" id="x_idstock_order_detail" size="30" placeholder="<?= HtmlEncode($Page->idstock_order_detail->getPlaceHolder()) ?>" value="<?= $Page->idstock_order_detail->EditValue ?>"<?= $Page->idstock_order_detail->editAttributes() ?> aria-describedby="x_idstock_order_detail_help">
<?= $Page->idstock_order_detail->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idstock_order_detail->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
    <div id="r_totalorder" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_totalorder" for="x_totalorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totalorder->caption() ?><?= $Page->totalorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totalorder->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_totalorder">
<input type="<?= $Page->totalorder->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_totalorder" name="x_totalorder" id="x_totalorder" size="30" placeholder="<?= HtmlEncode($Page->totalorder->getPlaceHolder()) ?>" value="<?= $Page->totalorder->EditValue ?>"<?= $Page->totalorder->editAttributes() ?> aria-describedby="x_totalorder_help">
<?= $Page->totalorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totalorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah_kirim->Visible) { // jumlah_kirim ?>
    <div id="r_jumlah_kirim" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_jumlah_kirim" for="x_jumlah_kirim" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah_kirim->caption() ?><?= $Page->jumlah_kirim->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah_kirim->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_jumlah_kirim">
<input type="<?= $Page->jumlah_kirim->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_jumlah_kirim" name="x_jumlah_kirim" id="x_jumlah_kirim" size="30" placeholder="<?= HtmlEncode($Page->jumlah_kirim->getPlaceHolder()) ?>" value="<?= $Page->jumlah_kirim->EditValue ?>"<?= $Page->jumlah_kirim->editAttributes() ?> aria-describedby="x_jumlah_kirim_help">
<?= $Page->jumlah_kirim->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah_kirim->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <div id="r_sisa" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_sisa" for="x_sisa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sisa->caption() ?><?= $Page->sisa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sisa->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_sisa">
<input type="<?= $Page->sisa->getInputTextType() ?>" data-table="stock_deliveryorder_detail" data-field="x_sisa" name="x_sisa" id="x_sisa" size="30" placeholder="<?= HtmlEncode($Page->sisa->getPlaceHolder()) ?>" value="<?= $Page->sisa->EditValue ?>"<?= $Page->sisa->editAttributes() ?> aria-describedby="x_sisa_help">
<?= $Page->sisa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sisa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_keterangan">
<textarea data-table="stock_deliveryorder_detail" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
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
    ew.addEventHandlers("stock_deliveryorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
