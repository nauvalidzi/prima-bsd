<?php

namespace PHPMaker2021\distributor;

// Page object
$InvoiceDetailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var finvoice_detailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    finvoice_detailadd = currentForm = new ew.Form("finvoice_detailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "invoice_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.invoice_detail)
        ew.vars.tables.invoice_detail = currentTable;
    finvoice_detailadd.addFields([
        ["idorder_detail", [fields.idorder_detail.visible && fields.idorder_detail.required ? ew.Validators.required(fields.idorder_detail.caption) : null], fields.idorder_detail.isInvalid],
        ["jumlahorder", [fields.jumlahorder.visible && fields.jumlahorder.required ? ew.Validators.required(fields.jumlahorder.caption) : null, ew.Validators.integer], fields.jumlahorder.isInvalid],
        ["bonus", [fields.bonus.visible && fields.bonus.required ? ew.Validators.required(fields.bonus.caption) : null, ew.Validators.integer], fields.bonus.isInvalid],
        ["stockdo", [fields.stockdo.visible && fields.stockdo.required ? ew.Validators.required(fields.stockdo.caption) : null, ew.Validators.integer], fields.stockdo.isInvalid],
        ["jumlahkirim", [fields.jumlahkirim.visible && fields.jumlahkirim.required ? ew.Validators.required(fields.jumlahkirim.caption) : null, ew.Validators.integer], fields.jumlahkirim.isInvalid],
        ["jumlahbonus", [fields.jumlahbonus.visible && fields.jumlahbonus.required ? ew.Validators.required(fields.jumlahbonus.caption) : null, ew.Validators.integer], fields.jumlahbonus.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["totalnondiskon", [fields.totalnondiskon.visible && fields.totalnondiskon.required ? ew.Validators.required(fields.totalnondiskon.caption) : null, ew.Validators.integer], fields.totalnondiskon.isInvalid],
        ["diskonpayment", [fields.diskonpayment.visible && fields.diskonpayment.required ? ew.Validators.required(fields.diskonpayment.caption) : null, ew.Validators.float], fields.diskonpayment.isInvalid],
        ["bbpersen", [fields.bbpersen.visible && fields.bbpersen.required ? ew.Validators.required(fields.bbpersen.caption) : null, ew.Validators.float], fields.bbpersen.isInvalid],
        ["totaltagihan", [fields.totaltagihan.visible && fields.totaltagihan.required ? ew.Validators.required(fields.totaltagihan.caption) : null, ew.Validators.integer], fields.totaltagihan.isInvalid],
        ["blackbonus", [fields.blackbonus.visible && fields.blackbonus.required ? ew.Validators.required(fields.blackbonus.caption) : null, ew.Validators.integer], fields.blackbonus.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid],
        ["readonly", [fields.readonly.visible && fields.readonly.required ? ew.Validators.required(fields.readonly.caption) : null], fields.readonly.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = finvoice_detailadd,
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
    finvoice_detailadd.validate = function () {
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
    finvoice_detailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvoice_detailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    finvoice_detailadd.lists.idorder_detail = <?= $Page->idorder_detail->toClientList($Page) ?>;
    loadjs.done("finvoice_detailadd");
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
<form name="finvoice_detailadd" id="finvoice_detailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice_detail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "invoice") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="invoice">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idinvoice->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
    <div id="r_idorder_detail" class="form-group row">
        <label id="elh_invoice_detail_idorder_detail" for="x_idorder_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idorder_detail->caption() ?><?= $Page->idorder_detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el_invoice_detail_idorder_detail">
<?php $Page->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_idorder_detail"
        name="x_idorder_detail"
        class="form-control ew-select<?= $Page->idorder_detail->isInvalidClass() ?>"
        data-select2-id="invoice_detail_x_idorder_detail"
        data-table="invoice_detail"
        data-field="x_idorder_detail"
        data-value-separator="<?= $Page->idorder_detail->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idorder_detail->getPlaceHolder()) ?>"
        <?= $Page->idorder_detail->editAttributes() ?>>
        <?= $Page->idorder_detail->selectOptionListHtml("x_idorder_detail") ?>
    </select>
    <?= $Page->idorder_detail->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idorder_detail->getErrorMessage() ?></div>
<?= $Page->idorder_detail->Lookup->getParamTag($Page, "p_x_idorder_detail") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_detail_x_idorder_detail']"),
        options = { name: "x_idorder_detail", selectId: "invoice_detail_x_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahorder->Visible) { // jumlahorder ?>
    <div id="r_jumlahorder" class="form-group row">
        <label id="elh_invoice_detail_jumlahorder" for="x_jumlahorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahorder->caption() ?><?= $Page->jumlahorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahorder->cellAttributes() ?>>
<span id="el_invoice_detail_jumlahorder">
<input type="<?= $Page->jumlahorder->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahorder" name="x_jumlahorder" id="x_jumlahorder" size="30" placeholder="<?= HtmlEncode($Page->jumlahorder->getPlaceHolder()) ?>" value="<?= $Page->jumlahorder->EditValue ?>"<?= $Page->jumlahorder->editAttributes() ?> aria-describedby="x_jumlahorder_help">
<?= $Page->jumlahorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bonus->Visible) { // bonus ?>
    <div id="r_bonus" class="form-group row">
        <label id="elh_invoice_detail_bonus" for="x_bonus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bonus->caption() ?><?= $Page->bonus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bonus->cellAttributes() ?>>
<span id="el_invoice_detail_bonus">
<input type="<?= $Page->bonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bonus" name="x_bonus" id="x_bonus" size="30" placeholder="<?= HtmlEncode($Page->bonus->getPlaceHolder()) ?>" value="<?= $Page->bonus->EditValue ?>"<?= $Page->bonus->editAttributes() ?> aria-describedby="x_bonus_help">
<?= $Page->bonus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bonus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->stockdo->Visible) { // stockdo ?>
    <div id="r_stockdo" class="form-group row">
        <label id="elh_invoice_detail_stockdo" for="x_stockdo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->stockdo->caption() ?><?= $Page->stockdo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->stockdo->cellAttributes() ?>>
<span id="el_invoice_detail_stockdo">
<input type="<?= $Page->stockdo->getInputTextType() ?>" data-table="invoice_detail" data-field="x_stockdo" name="x_stockdo" id="x_stockdo" size="30" placeholder="<?= HtmlEncode($Page->stockdo->getPlaceHolder()) ?>" value="<?= $Page->stockdo->EditValue ?>"<?= $Page->stockdo->editAttributes() ?> aria-describedby="x_stockdo_help">
<?= $Page->stockdo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->stockdo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
    <div id="r_jumlahkirim" class="form-group row">
        <label id="elh_invoice_detail_jumlahkirim" for="x_jumlahkirim" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahkirim->caption() ?><?= $Page->jumlahkirim->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el_invoice_detail_jumlahkirim">
<input type="<?= $Page->jumlahkirim->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahkirim" name="x_jumlahkirim" id="x_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Page->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Page->jumlahkirim->EditValue ?>"<?= $Page->jumlahkirim->editAttributes() ?> aria-describedby="x_jumlahkirim_help">
<?= $Page->jumlahkirim->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahkirim->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahbonus->Visible) { // jumlahbonus ?>
    <div id="r_jumlahbonus" class="form-group row">
        <label id="elh_invoice_detail_jumlahbonus" for="x_jumlahbonus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahbonus->caption() ?><?= $Page->jumlahbonus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahbonus->cellAttributes() ?>>
<span id="el_invoice_detail_jumlahbonus">
<input type="<?= $Page->jumlahbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_jumlahbonus" name="x_jumlahbonus" id="x_jumlahbonus" size="30" placeholder="<?= HtmlEncode($Page->jumlahbonus->getPlaceHolder()) ?>" value="<?= $Page->jumlahbonus->EditValue ?>"<?= $Page->jumlahbonus->editAttributes() ?> aria-describedby="x_jumlahbonus_help">
<?= $Page->jumlahbonus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahbonus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <div id="r_harga" class="form-group row">
        <label id="elh_invoice_detail_harga" for="x_harga" class="<?= $Page->LeftColumnClass ?>"><?= $Page->harga->caption() ?><?= $Page->harga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga->cellAttributes() ?>>
<span id="el_invoice_detail_harga">
<input type="<?= $Page->harga->getInputTextType() ?>" data-table="invoice_detail" data-field="x_harga" name="x_harga" id="x_harga" size="30" placeholder="<?= HtmlEncode($Page->harga->getPlaceHolder()) ?>" value="<?= $Page->harga->EditValue ?>"<?= $Page->harga->editAttributes() ?> aria-describedby="x_harga_help">
<?= $Page->harga->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->harga->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totalnondiskon->Visible) { // totalnondiskon ?>
    <div id="r_totalnondiskon" class="form-group row">
        <label id="elh_invoice_detail_totalnondiskon" for="x_totalnondiskon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totalnondiskon->caption() ?><?= $Page->totalnondiskon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totalnondiskon->cellAttributes() ?>>
<span id="el_invoice_detail_totalnondiskon">
<input type="<?= $Page->totalnondiskon->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totalnondiskon" name="x_totalnondiskon" id="x_totalnondiskon" size="30" placeholder="<?= HtmlEncode($Page->totalnondiskon->getPlaceHolder()) ?>" value="<?= $Page->totalnondiskon->EditValue ?>"<?= $Page->totalnondiskon->editAttributes() ?> aria-describedby="x_totalnondiskon_help">
<?= $Page->totalnondiskon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totalnondiskon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->diskonpayment->Visible) { // diskonpayment ?>
    <div id="r_diskonpayment" class="form-group row">
        <label id="elh_invoice_detail_diskonpayment" for="x_diskonpayment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->diskonpayment->caption() ?><?= $Page->diskonpayment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->diskonpayment->cellAttributes() ?>>
<span id="el_invoice_detail_diskonpayment">
<input type="<?= $Page->diskonpayment->getInputTextType() ?>" data-table="invoice_detail" data-field="x_diskonpayment" name="x_diskonpayment" id="x_diskonpayment" size="30" placeholder="<?= HtmlEncode($Page->diskonpayment->getPlaceHolder()) ?>" value="<?= $Page->diskonpayment->EditValue ?>"<?= $Page->diskonpayment->editAttributes() ?> aria-describedby="x_diskonpayment_help">
<?= $Page->diskonpayment->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->diskonpayment->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bbpersen->Visible) { // bbpersen ?>
    <div id="r_bbpersen" class="form-group row">
        <label id="elh_invoice_detail_bbpersen" for="x_bbpersen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bbpersen->caption() ?><?= $Page->bbpersen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bbpersen->cellAttributes() ?>>
<span id="el_invoice_detail_bbpersen">
<input type="<?= $Page->bbpersen->getInputTextType() ?>" data-table="invoice_detail" data-field="x_bbpersen" name="x_bbpersen" id="x_bbpersen" size="30" placeholder="<?= HtmlEncode($Page->bbpersen->getPlaceHolder()) ?>" value="<?= $Page->bbpersen->EditValue ?>"<?= $Page->bbpersen->editAttributes() ?> aria-describedby="x_bbpersen_help">
<?= $Page->bbpersen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bbpersen->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <div id="r_totaltagihan" class="form-group row">
        <label id="elh_invoice_detail_totaltagihan" for="x_totaltagihan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totaltagihan->caption() ?><?= $Page->totaltagihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el_invoice_detail_totaltagihan">
<input type="<?= $Page->totaltagihan->getInputTextType() ?>" data-table="invoice_detail" data-field="x_totaltagihan" name="x_totaltagihan" id="x_totaltagihan" size="30" placeholder="<?= HtmlEncode($Page->totaltagihan->getPlaceHolder()) ?>" value="<?= $Page->totaltagihan->EditValue ?>"<?= $Page->totaltagihan->editAttributes() ?> aria-describedby="x_totaltagihan_help">
<?= $Page->totaltagihan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totaltagihan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
    <div id="r_blackbonus" class="form-group row">
        <label id="elh_invoice_detail_blackbonus" for="x_blackbonus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->blackbonus->caption() ?><?= $Page->blackbonus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->blackbonus->cellAttributes() ?>>
<span id="el_invoice_detail_blackbonus">
<input type="<?= $Page->blackbonus->getInputTextType() ?>" data-table="invoice_detail" data-field="x_blackbonus" name="x_blackbonus" id="x_blackbonus" size="30" placeholder="<?= HtmlEncode($Page->blackbonus->getPlaceHolder()) ?>" value="<?= $Page->blackbonus->EditValue ?>"<?= $Page->blackbonus->editAttributes() ?> aria-describedby="x_blackbonus_help">
<?= $Page->blackbonus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->blackbonus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_invoice_detail_created_by">
    <input type="hidden" data-table="invoice_detail" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
    <span id="el_invoice_detail_readonly">
    <input type="hidden" data-table="invoice_detail" data-field="x_readonly" data-hidden="1" name="x_readonly" id="x_readonly" value="<?= HtmlEncode($Page->readonly->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
    <?php if (strval($Page->idinvoice->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_idinvoice" id="x_idinvoice" value="<?= HtmlEncode(strval($Page->idinvoice->getSessionValue())) ?>">
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
    ew.addEventHandlers("invoice_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
