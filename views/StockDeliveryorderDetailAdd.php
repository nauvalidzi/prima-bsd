<?php

namespace PHPMaker2021\distributor;

// Page object
$StockDeliveryorderDetailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstock_deliveryorder_detailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fstock_deliveryorder_detailadd = currentForm = new ew.Form("fstock_deliveryorder_detailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "stock_deliveryorder_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.stock_deliveryorder_detail)
        ew.vars.tables.stock_deliveryorder_detail = currentTable;
    fstock_deliveryorder_detailadd.addFields([
        ["idstockorder", [fields.idstockorder.visible && fields.idstockorder.required ? ew.Validators.required(fields.idstockorder.caption) : null], fields.idstockorder.isInvalid],
        ["idstockorder_detail", [fields.idstockorder_detail.visible && fields.idstockorder_detail.required ? ew.Validators.required(fields.idstockorder_detail.caption) : null], fields.idstockorder_detail.isInvalid],
        ["totalorder", [fields.totalorder.visible && fields.totalorder.required ? ew.Validators.required(fields.totalorder.caption) : null, ew.Validators.integer], fields.totalorder.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["jumlah_kirim", [fields.jumlah_kirim.visible && fields.jumlah_kirim.required ? ew.Validators.required(fields.jumlah_kirim.caption) : null, ew.Validators.integer], fields.jumlah_kirim.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstock_deliveryorder_detailadd,
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
    fstock_deliveryorder_detailadd.validate = function () {
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
    fstock_deliveryorder_detailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstock_deliveryorder_detailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fstock_deliveryorder_detailadd.lists.idstockorder = <?= $Page->idstockorder->toClientList($Page) ?>;
    fstock_deliveryorder_detailadd.lists.idstockorder_detail = <?= $Page->idstockorder_detail->toClientList($Page) ?>;
    loadjs.done("fstock_deliveryorder_detailadd");
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
<form name="fstock_deliveryorder_detailadd" id="fstock_deliveryorder_detailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stock_deliveryorder_detail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "stock_deliveryorder") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="stock_deliveryorder">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idstockorder->Visible) { // idstockorder ?>
    <div id="r_idstockorder" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_idstockorder" for="x_idstockorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idstockorder->caption() ?><?= $Page->idstockorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idstockorder->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_idstockorder">
<?php $Page->idstockorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idstockorder"
        name="x_idstockorder"
        class="form-control ew-select<?= $Page->idstockorder->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x_idstockorder"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder"
        data-value-separator="<?= $Page->idstockorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idstockorder->getPlaceHolder()) ?>"
        <?= $Page->idstockorder->editAttributes() ?>>
        <?= $Page->idstockorder->selectOptionListHtml("x_idstockorder") ?>
    </select>
    <?= $Page->idstockorder->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idstockorder->getErrorMessage() ?></div>
<?= $Page->idstockorder->Lookup->getParamTag($Page, "p_x_idstockorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x_idstockorder']"),
        options = { name: "x_idstockorder", selectId: "stock_deliveryorder_detail_x_idstockorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
    <div id="r_idstockorder_detail" class="form-group row">
        <label id="elh_stock_deliveryorder_detail_idstockorder_detail" for="x_idstockorder_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idstockorder_detail->caption() ?><?= $Page->idstockorder_detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idstockorder_detail->cellAttributes() ?>>
<span id="el_stock_deliveryorder_detail_idstockorder_detail">
<?php $Page->idstockorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_idstockorder_detail"
        name="x_idstockorder_detail"
        class="form-control ew-select<?= $Page->idstockorder_detail->isInvalidClass() ?>"
        data-select2-id="stock_deliveryorder_detail_x_idstockorder_detail"
        data-table="stock_deliveryorder_detail"
        data-field="x_idstockorder_detail"
        data-value-separator="<?= $Page->idstockorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idstockorder_detail->getPlaceHolder()) ?>"
        <?= $Page->idstockorder_detail->editAttributes() ?>>
        <?= $Page->idstockorder_detail->selectOptionListHtml("x_idstockorder_detail") ?>
    </select>
    <?= $Page->idstockorder_detail->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idstockorder_detail->getErrorMessage() ?></div>
<?= $Page->idstockorder_detail->Lookup->getParamTag($Page, "p_x_idstockorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='stock_deliveryorder_detail_x_idstockorder_detail']"),
        options = { name: "x_idstockorder_detail", selectId: "stock_deliveryorder_detail_x_idstockorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.stock_deliveryorder_detail.fields.idstockorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
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
    <?php if (strval($Page->pid->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_pid" id="x_pid" value="<?= HtmlEncode(strval($Page->pid->getSessionValue())) ?>">
    <?php } ?>
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
    ew.addEventHandlers("stock_deliveryorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
