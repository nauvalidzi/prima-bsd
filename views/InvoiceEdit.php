<?php

namespace PHPMaker2021\production2;

// Page object
$InvoiceEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var finvoiceedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    finvoiceedit = currentForm = new ew.Form("finvoiceedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "invoice")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.invoice)
        ew.vars.tables.invoice = currentTable;
    finvoiceedit.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["tglinvoice", [fields.tglinvoice.visible && fields.tglinvoice.required ? ew.Validators.required(fields.tglinvoice.caption) : null, ew.Validators.datetime(0)], fields.tglinvoice.isInvalid],
        ["totalnonpajak", [fields.totalnonpajak.visible && fields.totalnonpajak.required ? ew.Validators.required(fields.totalnonpajak.caption) : null, ew.Validators.integer], fields.totalnonpajak.isInvalid],
        ["pajak", [fields.pajak.visible && fields.pajak.required ? ew.Validators.required(fields.pajak.caption) : null, ew.Validators.float], fields.pajak.isInvalid],
        ["totaltagihan", [fields.totaltagihan.visible && fields.totaltagihan.required ? ew.Validators.required(fields.totaltagihan.caption) : null, ew.Validators.integer], fields.totaltagihan.isInvalid],
        ["idtermpayment", [fields.idtermpayment.visible && fields.idtermpayment.required ? ew.Validators.required(fields.idtermpayment.caption) : null], fields.idtermpayment.isInvalid],
        ["idtipepayment", [fields.idtipepayment.visible && fields.idtipepayment.required ? ew.Validators.required(fields.idtipepayment.caption) : null], fields.idtipepayment.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["readonly", [fields.readonly.visible && fields.readonly.required ? ew.Validators.required(fields.readonly.caption) : null], fields.readonly.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = finvoiceedit,
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
    finvoiceedit.validate = function () {
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
    finvoiceedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    finvoiceedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    finvoiceedit.lists.idtermpayment = <?= $Page->idtermpayment->toClientList($Page) ?>;
    finvoiceedit.lists.idtipepayment = <?= $Page->idtipepayment->toClientList($Page) ?>;
    loadjs.done("finvoiceedit");
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
<form name="finvoiceedit" id="finvoiceedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="invoice">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "suratjalan_detail") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="suratjalan_detail">
<input type="hidden" name="fk_idinvoice" value="<?= HtmlEncode($Page->id->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "customer") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="customer">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idcustomer->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_invoice_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_invoice_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->kode->getDisplayValue($Page->kode->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="invoice" data-field="x_kode" data-hidden="1" name="x_kode" id="x_kode" value="<?= HtmlEncode($Page->kode->CurrentValue) ?>">
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
loadjs.ready(["finvoiceedit", "datetimepicker"], function() {
    ew.createDateTimePicker("finvoiceedit", "x_tglinvoice", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
<input type="<?= $Page->pajak->getInputTextType() ?>" data-table="invoice" data-field="x_pajak" name="x_pajak" id="x_pajak" size="30" placeholder="<?= HtmlEncode($Page->pajak->getPlaceHolder()) ?>" value="<?= $Page->pajak->EditValue ?>"<?= $Page->pajak->editAttributes() ?> aria-describedby="x_pajak_help">
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
</div><!-- /page* -->
<span id="el_invoice_readonly">
<input type="hidden" data-table="invoice" data-field="x_readonly" data-hidden="1" name="x_readonly" id="x_readonly" value="<?= HtmlEncode($Page->readonly->CurrentValue) ?>">
</span>
    <input type="hidden" data-table="invoice" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php
    if (in_array("invoice_detail", explode(",", $Page->getCurrentDetailTable())) && $invoice_detail->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("invoice_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "InvoiceDetailGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("invoice");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){$("#x_pajak").change((function(){var a=parseInt($("#x_totalnonpajak").val())||0,n=a+(parseFloat($("#x_pajak").val())||0)/100*a;$("#x_totaltagihan").val(n).change()}))})),$("#el_invoice_pajak").addClass("input-group"),$("#el_invoice_pajak").append('<div class="input-group-append"><span class="input-group-text">&#37;</span></div>');
});
</script>
