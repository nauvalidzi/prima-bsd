<?php

namespace PHPMaker2021\production2;

// Page object
$NpdSerahterimaEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_serahterimaedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_serahterimaedit = currentForm = new ew.Form("fnpd_serahterimaedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_serahterima")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_serahterima)
        ew.vars.tables.npd_serahterima = currentTable;
    fnpd_serahterimaedit.addFields([
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["tgl_request", [fields.tgl_request.visible && fields.tgl_request.required ? ew.Validators.required(fields.tgl_request.caption) : null, ew.Validators.datetime(0)], fields.tgl_request.isInvalid],
        ["tgl_serahterima", [fields.tgl_serahterima.visible && fields.tgl_serahterima.required ? ew.Validators.required(fields.tgl_serahterima.caption) : null, ew.Validators.datetime(0)], fields.tgl_serahterima.isInvalid],
        ["receipt_by", [fields.receipt_by.visible && fields.receipt_by.required ? ew.Validators.required(fields.receipt_by.caption) : null], fields.receipt_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_serahterimaedit,
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
    fnpd_serahterimaedit.validate = function () {
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
    fnpd_serahterimaedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_serahterimaedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_serahterimaedit.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    fnpd_serahterimaedit.lists.receipt_by = <?= $Page->receipt_by->toClientList($Page) ?>;
    loadjs.done("fnpd_serahterimaedit");
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
<form name="fnpd_serahterimaedit" id="fnpd_serahterimaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_serahterima">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_npd_serahterima_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_npd_serahterima_idcustomer">
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="npd_serahterima_x_idcustomer"
        data-table="npd_serahterima"
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
    var el = document.querySelector("select[data-select2-id='npd_serahterima_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "npd_serahterima_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_serahterima.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_request->Visible) { // tgl_request ?>
    <div id="r_tgl_request" class="form-group row">
        <label id="elh_npd_serahterima_tgl_request" for="x_tgl_request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_request->caption() ?><?= $Page->tgl_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_request->cellAttributes() ?>>
<span id="el_npd_serahterima_tgl_request">
<input type="<?= $Page->tgl_request->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_tgl_request" name="x_tgl_request" id="x_tgl_request" placeholder="<?= HtmlEncode($Page->tgl_request->getPlaceHolder()) ?>" value="<?= $Page->tgl_request->EditValue ?>"<?= $Page->tgl_request->editAttributes() ?> aria-describedby="x_tgl_request_help">
<?= $Page->tgl_request->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_request->getErrorMessage() ?></div>
<?php if (!$Page->tgl_request->ReadOnly && !$Page->tgl_request->Disabled && !isset($Page->tgl_request->EditAttrs["readonly"]) && !isset($Page->tgl_request->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_serahterimaedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_serahterimaedit", "x_tgl_request", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_serahterima->Visible) { // tgl_serahterima ?>
    <div id="r_tgl_serahterima" class="form-group row">
        <label id="elh_npd_serahterima_tgl_serahterima" for="x_tgl_serahterima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_serahterima->caption() ?><?= $Page->tgl_serahterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_serahterima->cellAttributes() ?>>
<span id="el_npd_serahterima_tgl_serahterima">
<input type="<?= $Page->tgl_serahterima->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_tgl_serahterima" name="x_tgl_serahterima" id="x_tgl_serahterima" placeholder="<?= HtmlEncode($Page->tgl_serahterima->getPlaceHolder()) ?>" value="<?= $Page->tgl_serahterima->EditValue ?>"<?= $Page->tgl_serahterima->editAttributes() ?> aria-describedby="x_tgl_serahterima_help">
<?= $Page->tgl_serahterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_serahterima->getErrorMessage() ?></div>
<?php if (!$Page->tgl_serahterima->ReadOnly && !$Page->tgl_serahterima->Disabled && !isset($Page->tgl_serahterima->EditAttrs["readonly"]) && !isset($Page->tgl_serahterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_serahterimaedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_serahterimaedit", "x_tgl_serahterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
    <div id="r_receipt_by" class="form-group row">
        <label id="elh_npd_serahterima_receipt_by" for="x_receipt_by" class="<?= $Page->LeftColumnClass ?>"><?= $Page->receipt_by->caption() ?><?= $Page->receipt_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->receipt_by->cellAttributes() ?>>
<span id="el_npd_serahterima_receipt_by">
    <select
        id="x_receipt_by"
        name="x_receipt_by"
        class="form-control ew-select<?= $Page->receipt_by->isInvalidClass() ?>"
        data-select2-id="npd_serahterima_x_receipt_by"
        data-table="npd_serahterima"
        data-field="x_receipt_by"
        data-value-separator="<?= $Page->receipt_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->receipt_by->getPlaceHolder()) ?>"
        <?= $Page->receipt_by->editAttributes() ?>>
        <?= $Page->receipt_by->selectOptionListHtml("x_receipt_by") ?>
    </select>
    <?= $Page->receipt_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->receipt_by->getErrorMessage() ?></div>
<?= $Page->receipt_by->Lookup->getParamTag($Page, "p_x_receipt_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_serahterima_x_receipt_by']"),
        options = { name: "x_receipt_by", selectId: "npd_serahterima_x_receipt_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_serahterima.fields.receipt_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="npd_serahterima" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("npd_sample", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "NpdSampleGrid.php" ?>
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
    ew.addEventHandlers("npd_serahterima");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
