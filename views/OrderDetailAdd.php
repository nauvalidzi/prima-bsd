<?php

namespace PHPMaker2021\production2;

// Page object
$OrderDetailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var forder_detailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    forder_detailadd = currentForm = new ew.Form("forder_detailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "order_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.order_detail)
        ew.vars.tables.order_detail = currentTable;
    forder_detailadd.addFields([
        ["idproduct", [fields.idproduct.visible && fields.idproduct.required ? ew.Validators.required(fields.idproduct.caption) : null], fields.idproduct.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid],
        ["bonus", [fields.bonus.visible && fields.bonus.required ? ew.Validators.required(fields.bonus.caption) : null, ew.Validators.integer], fields.bonus.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.integer], fields.total.isInvalid],
        ["tipe_sla", [fields.tipe_sla.visible && fields.tipe_sla.required ? ew.Validators.required(fields.tipe_sla.caption) : null], fields.tipe_sla.isInvalid],
        ["sla", [fields.sla.visible && fields.sla.required ? ew.Validators.required(fields.sla.caption) : null], fields.sla.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = forder_detailadd,
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
    forder_detailadd.validate = function () {
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
    forder_detailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    forder_detailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    forder_detailadd.lists.idproduct = <?= $Page->idproduct->toClientList($Page) ?>;
    forder_detailadd.lists.tipe_sla = <?= $Page->tipe_sla->toClientList($Page) ?>;
    loadjs.done("forder_detailadd");
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
<form name="forder_detailadd" id="forder_detailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_detail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "order") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="order">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idorder->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idproduct->Visible) { // idproduct ?>
    <div id="r_idproduct" class="form-group row">
        <label id="elh_order_detail_idproduct" for="x_idproduct" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct->caption() ?><?= $Page->idproduct->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct->cellAttributes() ?>>
<span id="el_order_detail_idproduct">
<?php $Page->idproduct->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_idproduct"
        name="x_idproduct"
        class="form-control ew-select<?= $Page->idproduct->isInvalidClass() ?>"
        data-select2-id="order_detail_x_idproduct"
        data-table="order_detail"
        data-field="x_idproduct"
        data-value-separator="<?= $Page->idproduct->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idproduct->getPlaceHolder()) ?>"
        <?= $Page->idproduct->editAttributes() ?>>
        <?= $Page->idproduct->selectOptionListHtml("x_idproduct") ?>
    </select>
    <?= $Page->idproduct->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idproduct->getErrorMessage() ?></div>
<?= $Page->idproduct->Lookup->getParamTag($Page, "p_x_idproduct") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_detail_x_idproduct']"),
        options = { name: "x_idproduct", selectId: "order_detail_x_idproduct", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.idproduct.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <div id="r_jumlah" class="form-group row">
        <label id="elh_order_detail_jumlah" for="x_jumlah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah->caption() ?><?= $Page->jumlah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_order_detail_jumlah">
<input type="<?= $Page->jumlah->getInputTextType() ?>" data-table="order_detail" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?= HtmlEncode($Page->jumlah->getPlaceHolder()) ?>" value="<?= $Page->jumlah->EditValue ?>"<?= $Page->jumlah->editAttributes() ?> aria-describedby="x_jumlah_help">
<?= $Page->jumlah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
    <div id="r_bonus" class="form-group row">
        <label id="elh_order_detail_bonus" for="x_bonus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bonus->caption() ?><?= $Page->bonus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bonus->cellAttributes() ?>>
<span id="el_order_detail_bonus">
<input type="<?= $Page->bonus->getInputTextType() ?>" data-table="order_detail" data-field="x_bonus" name="x_bonus" id="x_bonus" size="30" placeholder="<?= HtmlEncode($Page->bonus->getPlaceHolder()) ?>" value="<?= $Page->bonus->EditValue ?>"<?= $Page->bonus->editAttributes() ?> aria-describedby="x_bonus_help">
<?= $Page->bonus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bonus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <div id="r_sisa" class="form-group row">
        <label id="elh_order_detail_sisa" for="x_sisa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sisa->caption() ?><?= $Page->sisa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sisa->cellAttributes() ?>>
<span id="el_order_detail_sisa">
<input type="<?= $Page->sisa->getInputTextType() ?>" data-table="order_detail" data-field="x_sisa" name="x_sisa" id="x_sisa" size="30" placeholder="<?= HtmlEncode($Page->sisa->getPlaceHolder()) ?>" value="<?= $Page->sisa->EditValue ?>"<?= $Page->sisa->editAttributes() ?> aria-describedby="x_sisa_help">
<?= $Page->sisa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sisa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <div id="r_harga" class="form-group row">
        <label id="elh_order_detail_harga" for="x_harga" class="<?= $Page->LeftColumnClass ?>"><?= $Page->harga->caption() ?><?= $Page->harga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga->cellAttributes() ?>>
<span id="el_order_detail_harga">
<input type="<?= $Page->harga->getInputTextType() ?>" data-table="order_detail" data-field="x_harga" name="x_harga" id="x_harga" size="30" placeholder="<?= HtmlEncode($Page->harga->getPlaceHolder()) ?>" value="<?= $Page->harga->EditValue ?>"<?= $Page->harga->editAttributes() ?> aria-describedby="x_harga_help">
<?= $Page->harga->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->harga->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total" class="form-group row">
        <label id="elh_order_detail_total" for="x_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total->caption() ?><?= $Page->total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->total->cellAttributes() ?>>
<span id="el_order_detail_total">
<input type="<?= $Page->total->getInputTextType() ?>" data-table="order_detail" data-field="x_total" name="x_total" id="x_total" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" value="<?= $Page->total->EditValue ?>"<?= $Page->total->editAttributes() ?> aria-describedby="x_total_help">
<?= $Page->total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipe_sla->Visible) { // tipe_sla ?>
    <div id="r_tipe_sla" class="form-group row">
        <label id="elh_order_detail_tipe_sla" for="x_tipe_sla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipe_sla->caption() ?><?= $Page->tipe_sla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipe_sla->cellAttributes() ?>>
<span id="el_order_detail_tipe_sla">
<?php $Page->tipe_sla->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_tipe_sla"
        name="x_tipe_sla"
        class="form-control ew-select<?= $Page->tipe_sla->isInvalidClass() ?>"
        data-select2-id="order_detail_x_tipe_sla"
        data-table="order_detail"
        data-field="x_tipe_sla"
        data-value-separator="<?= $Page->tipe_sla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipe_sla->getPlaceHolder()) ?>"
        <?= $Page->tipe_sla->editAttributes() ?>>
        <?= $Page->tipe_sla->selectOptionListHtml("x_tipe_sla") ?>
    </select>
    <?= $Page->tipe_sla->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipe_sla->getErrorMessage() ?></div>
<?= $Page->tipe_sla->Lookup->getParamTag($Page, "p_x_tipe_sla") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='order_detail_x_tipe_sla']"),
        options = { name: "x_tipe_sla", selectId: "order_detail_x_tipe_sla", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.order_detail.fields.tipe_sla.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sla->Visible) { // sla ?>
    <div id="r_sla" class="form-group row">
        <label id="elh_order_detail_sla" for="x_sla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sla->caption() ?><?= $Page->sla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sla->cellAttributes() ?>>
<span id="el_order_detail_sla">
<input type="<?= $Page->sla->getInputTextType() ?>" data-table="order_detail" data-field="x_sla" name="x_sla" id="x_sla" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->sla->getPlaceHolder()) ?>" value="<?= $Page->sla->EditValue ?>"<?= $Page->sla->editAttributes() ?> aria-describedby="x_sla_help">
<?= $Page->sla->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sla->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_order_detail_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_order_detail_keterangan">
<textarea data-table="order_detail" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_order_detail_created_by">
    <input type="hidden" data-table="order_detail" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
    <?php if (strval($Page->idorder->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_idorder" id="x_idorder" value="<?= HtmlEncode(strval($Page->idorder->getSessionValue())) ?>">
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
    ew.addEventHandlers("order_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
