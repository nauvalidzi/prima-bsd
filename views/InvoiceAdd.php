<?php

namespace PHPMaker2021\distributor;

// Page object
$InvoiceAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var finvoiceadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    finvoiceadd = currentForm = new ew.Form("finvoiceadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "invoice")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.invoice)
        ew.vars.tables.invoice = currentTable;
    finvoiceadd.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["tglinvoice", [fields.tglinvoice.visible && fields.tglinvoice.required ? ew.Validators.required(fields.tglinvoice.caption) : null, ew.Validators.datetime(0)], fields.tglinvoice.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["idorder", [fields.idorder.visible && fields.idorder.required ? ew.Validators.required(fields.idorder.caption) : null], fields.idorder.isInvalid],
        ["totalnonpajak", [fields.totalnonpajak.visible && fields.totalnonpajak.required ? ew.Validators.required(fields.totalnonpajak.caption) : null, ew.Validators.integer], fields.totalnonpajak.isInvalid],
        ["pajak", [fields.pajak.visible && fields.pajak.required ? ew.Validators.required(fields.pajak.caption) : null], fields.pajak.isInvalid],
        ["totaltagihan", [fields.totaltagihan.visible && fields.totaltagihan.required ? ew.Validators.required(fields.totaltagihan.caption) : null, ew.Validators.integer], fields.totaltagihan.isInvalid],
        ["idtermpayment", [fields.idtermpayment.visible && fields.idtermpayment.required ? ew.Validators.required(fields.idtermpayment.caption) : null], fields.idtermpayment.isInvalid],
        ["idtipepayment", [fields.idtipepayment.visible && fields.idtipepayment.required ? ew.Validators.required(fields.idtipepayment.caption) : null], fields.idtipepayment.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid],
        ["readonly", [fields.readonly.visible && fields.readonly.required ? ew.Validators.required(fields.readonly.caption) : null], fields.readonly.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = finvoiceadd,
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
    finvoiceadd.validate = function () {
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
    finvoiceadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
    //    hitungtotalnonpajak();
    //    hitungtotaltagihan();
        return true;
    }

    // Use JavaScript validation or not
    finvoiceadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    finvoiceadd.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    finvoiceadd.lists.idorder = <?= $Page->idorder->toClientList($Page) ?>;
    finvoiceadd.lists.idtermpayment = <?= $Page->idtermpayment->toClientList($Page) ?>;
    finvoiceadd.lists.idtipepayment = <?= $Page->idtipepayment->toClientList($Page) ?>;
    loadjs.done("finvoiceadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    var now=new Date,day=("0"+now.getDate()).slice(-2),month=("0"+(now.getMonth()+1)).slice(-2),today=day+"-"+month+"-"+now.getFullYear();$("input#x_tglinvoice").val(today);
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="finvoiceadd" id="finvoiceadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "suratjalan_detail") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="suratjalan_detail">
<input type="hidden" name="fk_idinvoice" value="<?= HtmlEncode($Page->id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "pembayaran") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pembayaran">
<input type="hidden" name="fk_idinvoice" value="<?= HtmlEncode($Page->id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "customer") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="customer">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idcustomer->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_invoice_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_invoice_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="invoice" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
    <div id="r_tglinvoice" class="form-group row">
        <label id="elh_invoice_tglinvoice" for="x_tglinvoice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglinvoice->caption() ?><?= $Page->tglinvoice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglinvoice->cellAttributes() ?>>
<span id="el_invoice_tglinvoice">
<input type="<?= $Page->tglinvoice->getInputTextType() ?>" data-table="invoice" data-field="x_tglinvoice" name="x_tglinvoice" id="x_tglinvoice" placeholder="<?= HtmlEncode($Page->tglinvoice->getPlaceHolder()) ?>" value="<?= $Page->tglinvoice->EditValue ?>"<?= $Page->tglinvoice->editAttributes() ?> aria-describedby="x_tglinvoice_help">
<?= $Page->tglinvoice->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglinvoice->getErrorMessage() ?></div>
<?php if (!$Page->tglinvoice->ReadOnly && !$Page->tglinvoice->Disabled && !isset($Page->tglinvoice->EditAttrs["readonly"]) && !isset($Page->tglinvoice->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["finvoiceadd", "datetimepicker"], function() {
    ew.createDateTimePicker("finvoiceadd", "x_tglinvoice", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_invoice_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<?php if ($Page->idcustomer->getSessionValue() != "") { ?>
<span id="el_invoice_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idcustomer->getDisplayValue($Page->idcustomer->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idcustomer" name="x_idcustomer" value="<?= HtmlEncode($Page->idcustomer->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_invoice_idcustomer">
<?php $Page->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="invoice_x_idcustomer"
        data-table="invoice"
        data-field="x_idcustomer"
        data-value-separator="<?= $Page->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>"
        <?= $Page->idcustomer->editAttributes() ?>>
        <?= $Page->idcustomer->selectOptionListHtml("x_idcustomer") ?>
    </select>
    <?= $Page->idcustomer->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage() ?></div>
<?= $Page->idcustomer->Lookup->getParamTag($Page, "p_x_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "invoice_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
    <div id="r_idorder" class="form-group row">
        <label id="elh_invoice_idorder" for="x_idorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idorder->caption() ?><?= $Page->idorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idorder->cellAttributes() ?>>
<span id="el_invoice_idorder">
<?php $Page->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idorder"
        name="x_idorder"
        class="form-control ew-select<?= $Page->idorder->isInvalidClass() ?>"
        data-select2-id="invoice_x_idorder"
        data-table="invoice"
        data-field="x_idorder"
        data-value-separator="<?= $Page->idorder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idorder->getPlaceHolder()) ?>"
        <?= $Page->idorder->editAttributes() ?>>
        <?= $Page->idorder->selectOptionListHtml("x_idorder") ?>
    </select>
    <?= $Page->idorder->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idorder->getErrorMessage() ?></div>
<?= $Page->idorder->Lookup->getParamTag($Page, "p_x_idorder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_x_idorder']"),
        options = { name: "x_idorder", selectId: "invoice_x_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totalnonpajak->Visible) { // totalnonpajak ?>
    <div id="r_totalnonpajak" class="form-group row">
        <label id="elh_invoice_totalnonpajak" for="x_totalnonpajak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totalnonpajak->caption() ?><?= $Page->totalnonpajak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totalnonpajak->cellAttributes() ?>>
<span id="el_invoice_totalnonpajak">
<input type="<?= $Page->totalnonpajak->getInputTextType() ?>" data-table="invoice" data-field="x_totalnonpajak" name="x_totalnonpajak" id="x_totalnonpajak" size="30" placeholder="<?= HtmlEncode($Page->totalnonpajak->getPlaceHolder()) ?>" value="<?= $Page->totalnonpajak->EditValue ?>"<?= $Page->totalnonpajak->editAttributes() ?> aria-describedby="x_totalnonpajak_help">
<?= $Page->totalnonpajak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totalnonpajak->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pajak->Visible) { // pajak ?>
    <div id="r_pajak" class="form-group row">
        <label id="elh_invoice_pajak" for="x_pajak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pajak->caption() ?><?= $Page->pajak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pajak->cellAttributes() ?>>
<span id="el_invoice_pajak">
<textarea data-table="invoice" data-field="x_pajak" name="x_pajak" id="x_pajak" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->pajak->getPlaceHolder()) ?>"<?= $Page->pajak->editAttributes() ?> aria-describedby="x_pajak_help"><?= $Page->pajak->EditValue ?></textarea>
<?= $Page->pajak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pajak->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <div id="r_totaltagihan" class="form-group row">
        <label id="elh_invoice_totaltagihan" for="x_totaltagihan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totaltagihan->caption() ?><?= $Page->totaltagihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el_invoice_totaltagihan">
<input type="<?= $Page->totaltagihan->getInputTextType() ?>" data-table="invoice" data-field="x_totaltagihan" name="x_totaltagihan" id="x_totaltagihan" size="30" placeholder="<?= HtmlEncode($Page->totaltagihan->getPlaceHolder()) ?>" value="<?= $Page->totaltagihan->EditValue ?>"<?= $Page->totaltagihan->editAttributes() ?> aria-describedby="x_totaltagihan_help">
<?= $Page->totaltagihan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totaltagihan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idtermpayment->Visible) { // idtermpayment ?>
    <div id="r_idtermpayment" class="form-group row">
        <label id="elh_invoice_idtermpayment" for="x_idtermpayment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtermpayment->caption() ?><?= $Page->idtermpayment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idtermpayment->cellAttributes() ?>>
<span id="el_invoice_idtermpayment">
    <select
        id="x_idtermpayment"
        name="x_idtermpayment"
        class="form-control ew-select<?= $Page->idtermpayment->isInvalidClass() ?>"
        data-select2-id="invoice_x_idtermpayment"
        data-table="invoice"
        data-field="x_idtermpayment"
        data-value-separator="<?= $Page->idtermpayment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idtermpayment->getPlaceHolder()) ?>"
        <?= $Page->idtermpayment->editAttributes() ?>>
        <?= $Page->idtermpayment->selectOptionListHtml("x_idtermpayment") ?>
    </select>
    <?= $Page->idtermpayment->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idtermpayment->getErrorMessage() ?></div>
<?= $Page->idtermpayment->Lookup->getParamTag($Page, "p_x_idtermpayment") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_x_idtermpayment']"),
        options = { name: "x_idtermpayment", selectId: "invoice_x_idtermpayment", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idtermpayment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idtipepayment->Visible) { // idtipepayment ?>
    <div id="r_idtipepayment" class="form-group row">
        <label id="elh_invoice_idtipepayment" for="x_idtipepayment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtipepayment->caption() ?><?= $Page->idtipepayment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idtipepayment->cellAttributes() ?>>
<span id="el_invoice_idtipepayment">
    <select
        id="x_idtipepayment"
        name="x_idtipepayment"
        class="form-control ew-select<?= $Page->idtipepayment->isInvalidClass() ?>"
        data-select2-id="invoice_x_idtipepayment"
        data-table="invoice"
        data-field="x_idtipepayment"
        data-value-separator="<?= $Page->idtipepayment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idtipepayment->getPlaceHolder()) ?>"
        <?= $Page->idtipepayment->editAttributes() ?>>
        <?= $Page->idtipepayment->selectOptionListHtml("x_idtipepayment") ?>
    </select>
    <?= $Page->idtipepayment->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idtipepayment->getErrorMessage() ?></div>
<?= $Page->idtipepayment->Lookup->getParamTag($Page, "p_x_idtipepayment") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='invoice_x_idtipepayment']"),
        options = { name: "x_idtipepayment", selectId: "invoice_x_idtipepayment", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.invoice.fields.idtipepayment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_invoice_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_invoice_keterangan">
<textarea data-table="invoice" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_invoice_created_by">
    <input type="hidden" data-table="invoice" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
    <span id="el_invoice_readonly">
    <input type="hidden" data-table="invoice" data-field="x_readonly" data-hidden="1" name="x_readonly" id="x_readonly" value="<?= HtmlEncode($Page->readonly->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
    <?php if (strval($Page->id->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_id" id="x_id" value="<?= HtmlEncode(strval($Page->id->getSessionValue())) ?>">
    <?php } ?>
<?php
    if (in_array("invoice_detail", explode(",", $Page->getCurrentDetailTable())) && $invoice_detail->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("invoice_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "InvoiceDetailGrid.php" ?>
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
    ew.addEventHandlers("invoice");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){function a(){var a=0;$("[data-table='invoice_detail'][data-field='x_totaltagihan']").each((function(){a+=parseInt($(this).val()||0)})),$("#x_totalnonpajak").val(a).change()}$("#x_kode").val(),$("select[data-field=x_idorder]").change((function(){var a=$(this).val();$.get("api/nextKodeInvoice/"+a,(function(a){$("#x_kode").val(a)}))})),$("[data-table='invoice_detail'][data-field='x_totaltagihan']").change((function(){a()})),$("#x_totalnonpajak, #x_pajak").change((function(){var a,t;a=parseInt($("#x_totalnonpajak").val()||0),t=a*parseFloat($("#x_pajak").val()||0)/100,$("#x_totaltagihan").val(a+t),$("#x_sisabayar").val(a+t)})),$("[data-table='invoice_detail'][data-field='x_idorder']").change((function(){a()}))}));
});
</script>
