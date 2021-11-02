<?php

namespace PHPMaker2021\distributor;

// Page object
$SuratjalanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsuratjalanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsuratjalanadd = currentForm = new ew.Form("fsuratjalanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "suratjalan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.suratjalan)
        ew.vars.tables.suratjalan = currentTable;
    fsuratjalanadd.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["tglsurat", [fields.tglsurat.visible && fields.tglsurat.required ? ew.Validators.required(fields.tglsurat.caption) : null, ew.Validators.datetime(0)], fields.tglsurat.isInvalid],
        ["tglkirim", [fields.tglkirim.visible && fields.tglkirim.required ? ew.Validators.required(fields.tglkirim.caption) : null, ew.Validators.datetime(0)], fields.tglkirim.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["idalamat_customer", [fields.idalamat_customer.visible && fields.idalamat_customer.required ? ew.Validators.required(fields.idalamat_customer.caption) : null], fields.idalamat_customer.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsuratjalanadd,
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
    fsuratjalanadd.validate = function () {
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
    fsuratjalanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsuratjalanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsuratjalanadd.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    fsuratjalanadd.lists.idalamat_customer = <?= $Page->idalamat_customer->toClientList($Page) ?>;
    loadjs.done("fsuratjalanadd");
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
<form name="fsuratjalanadd" id="fsuratjalanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="suratjalan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_suratjalan_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_suratjalan_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="suratjalan" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsurat->Visible) { // tglsurat ?>
    <div id="r_tglsurat" class="form-group row">
        <label id="elh_suratjalan_tglsurat" for="x_tglsurat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglsurat->caption() ?><?= $Page->tglsurat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsurat->cellAttributes() ?>>
<span id="el_suratjalan_tglsurat">
<input type="<?= $Page->tglsurat->getInputTextType() ?>" data-table="suratjalan" data-field="x_tglsurat" name="x_tglsurat" id="x_tglsurat" placeholder="<?= HtmlEncode($Page->tglsurat->getPlaceHolder()) ?>" value="<?= $Page->tglsurat->EditValue ?>"<?= $Page->tglsurat->editAttributes() ?> aria-describedby="x_tglsurat_help">
<?= $Page->tglsurat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsurat->getErrorMessage() ?></div>
<?php if (!$Page->tglsurat->ReadOnly && !$Page->tglsurat->Disabled && !isset($Page->tglsurat->EditAttrs["readonly"]) && !isset($Page->tglsurat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsuratjalanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsuratjalanadd", "x_tglsurat", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
    <div id="r_tglkirim" class="form-group row">
        <label id="elh_suratjalan_tglkirim" for="x_tglkirim" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglkirim->caption() ?><?= $Page->tglkirim->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglkirim->cellAttributes() ?>>
<span id="el_suratjalan_tglkirim">
<input type="<?= $Page->tglkirim->getInputTextType() ?>" data-table="suratjalan" data-field="x_tglkirim" name="x_tglkirim" id="x_tglkirim" placeholder="<?= HtmlEncode($Page->tglkirim->getPlaceHolder()) ?>" value="<?= $Page->tglkirim->EditValue ?>"<?= $Page->tglkirim->editAttributes() ?> aria-describedby="x_tglkirim_help">
<?= $Page->tglkirim->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglkirim->getErrorMessage() ?></div>
<?php if (!$Page->tglkirim->ReadOnly && !$Page->tglkirim->Disabled && !isset($Page->tglkirim->EditAttrs["readonly"]) && !isset($Page->tglkirim->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsuratjalanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fsuratjalanadd", "x_tglkirim", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_suratjalan_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_suratjalan_idcustomer">
<?php $Page->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="suratjalan_x_idcustomer"
        data-table="suratjalan"
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
    var el = document.querySelector("select[data-select2-id='suratjalan_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "suratjalan_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.suratjalan.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idalamat_customer->Visible) { // idalamat_customer ?>
    <div id="r_idalamat_customer" class="form-group row">
        <label id="elh_suratjalan_idalamat_customer" for="x_idalamat_customer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idalamat_customer->caption() ?><?= $Page->idalamat_customer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idalamat_customer->cellAttributes() ?>>
<span id="el_suratjalan_idalamat_customer">
    <select
        id="x_idalamat_customer"
        name="x_idalamat_customer"
        class="form-control ew-select<?= $Page->idalamat_customer->isInvalidClass() ?>"
        data-select2-id="suratjalan_x_idalamat_customer"
        data-table="suratjalan"
        data-field="x_idalamat_customer"
        data-value-separator="<?= $Page->idalamat_customer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idalamat_customer->getPlaceHolder()) ?>"
        <?= $Page->idalamat_customer->editAttributes() ?>>
        <?= $Page->idalamat_customer->selectOptionListHtml("x_idalamat_customer") ?>
    </select>
    <?= $Page->idalamat_customer->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idalamat_customer->getErrorMessage() ?></div>
<?= $Page->idalamat_customer->Lookup->getParamTag($Page, "p_x_idalamat_customer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='suratjalan_x_idalamat_customer']"),
        options = { name: "x_idalamat_customer", selectId: "suratjalan_x_idalamat_customer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.suratjalan.fields.idalamat_customer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_suratjalan_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_suratjalan_keterangan">
<textarea data-table="suratjalan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_suratjalan_created_by">
    <input type="hidden" data-table="suratjalan" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
<?php
    if (in_array("suratjalan_detail", explode(",", $Page->getCurrentDetailTable())) && $suratjalan_detail->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("suratjalan_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SuratjalanDetailGrid.php" ?>
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
    ew.addEventHandlers("suratjalan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    //loadjs.ready('jquery', function() {
    //	$.get('api/suratjalan/deliveryorder/0').then(function(data){
    //    	$("#x_kode").val(data)
    //    })
    //});
});
</script>
