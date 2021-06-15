<?php

namespace PHPMaker2021\distributor;

// Page object
$DeliveryorderDetailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdeliveryorder_detailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fdeliveryorder_detailadd = currentForm = new ew.Form("fdeliveryorder_detailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "deliveryorder_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.deliveryorder_detail)
        ew.vars.tables.deliveryorder_detail = currentTable;
    fdeliveryorder_detailadd.addFields([
        ["idorder", [fields.idorder.visible && fields.idorder.required ? ew.Validators.required(fields.idorder.caption) : null], fields.idorder.isInvalid],
        ["idorder_detail", [fields.idorder_detail.visible && fields.idorder_detail.required ? ew.Validators.required(fields.idorder_detail.caption) : null], fields.idorder_detail.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["jumlahkirim", [fields.jumlahkirim.visible && fields.jumlahkirim.required ? ew.Validators.required(fields.jumlahkirim.caption) : null, ew.Validators.integer], fields.jumlahkirim.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fdeliveryorder_detailadd,
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
    fdeliveryorder_detailadd.validate = function () {
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
    fdeliveryorder_detailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdeliveryorder_detailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fdeliveryorder_detailadd.lists.idorder = <?= $Page->idorder->toClientList($Page) ?>;
    fdeliveryorder_detailadd.lists.idorder_detail = <?= $Page->idorder_detail->toClientList($Page) ?>;
    loadjs.done("fdeliveryorder_detailadd");
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
<form name="fdeliveryorder_detailadd" id="fdeliveryorder_detailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="deliveryorder_detail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "deliveryorder") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="deliveryorder">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->iddeliveryorder->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idorder->Visible) { // idorder ?>
    <div id="r_idorder" class="form-group row">
        <label id="elh_deliveryorder_detail_idorder" for="x_idorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idorder->caption() ?><?= $Page->idorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idorder->cellAttributes() ?>>
<span id="el_deliveryorder_detail_idorder">
<?php $Page->idorder->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idorder"
        name="x_idorder"
        class="form-control ew-select<?= $Page->idorder->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x_idorder"
        data-table="deliveryorder_detail"
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
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x_idorder']"),
        options = { name: "x_idorder", selectId: "deliveryorder_detail_x_idorder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
    <div id="r_idorder_detail" class="form-group row">
        <label id="elh_deliveryorder_detail_idorder_detail" for="x_idorder_detail" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idorder_detail->caption() ?><?= $Page->idorder_detail->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idorder_detail->cellAttributes() ?>>
<span id="el_deliveryorder_detail_idorder_detail">
<?php $Page->idorder_detail->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_idorder_detail"
        name="x_idorder_detail"
        class="form-control ew-select<?= $Page->idorder_detail->isInvalidClass() ?>"
        data-select2-id="deliveryorder_detail_x_idorder_detail"
        data-table="deliveryorder_detail"
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
    var el = document.querySelector("select[data-select2-id='deliveryorder_detail_x_idorder_detail']"),
        options = { name: "x_idorder_detail", selectId: "deliveryorder_detail_x_idorder_detail", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.deliveryorder_detail.fields.idorder_detail.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <div id="r_sisa" class="form-group row">
        <label id="elh_deliveryorder_detail_sisa" for="x_sisa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sisa->caption() ?><?= $Page->sisa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sisa->cellAttributes() ?>>
<span id="el_deliveryorder_detail_sisa">
<input type="<?= $Page->sisa->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_sisa" name="x_sisa" id="x_sisa" size="30" placeholder="<?= HtmlEncode($Page->sisa->getPlaceHolder()) ?>" value="<?= $Page->sisa->EditValue ?>"<?= $Page->sisa->editAttributes() ?> aria-describedby="x_sisa_help">
<?= $Page->sisa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sisa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
    <div id="r_jumlahkirim" class="form-group row">
        <label id="elh_deliveryorder_detail_jumlahkirim" for="x_jumlahkirim" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahkirim->caption() ?><?= $Page->jumlahkirim->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahkirim->cellAttributes() ?>>
<span id="el_deliveryorder_detail_jumlahkirim">
<input type="<?= $Page->jumlahkirim->getInputTextType() ?>" data-table="deliveryorder_detail" data-field="x_jumlahkirim" name="x_jumlahkirim" id="x_jumlahkirim" size="30" placeholder="<?= HtmlEncode($Page->jumlahkirim->getPlaceHolder()) ?>" value="<?= $Page->jumlahkirim->EditValue ?>"<?= $Page->jumlahkirim->editAttributes() ?> aria-describedby="x_jumlahkirim_help">
<?= $Page->jumlahkirim->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahkirim->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_deliveryorder_detail_created_by">
    <input type="hidden" data-table="deliveryorder_detail" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
    <?php if (strval($Page->iddeliveryorder->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_iddeliveryorder" id="x_iddeliveryorder" value="<?= HtmlEncode(strval($Page->iddeliveryorder->getSessionValue())) ?>">
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
    ew.addEventHandlers("deliveryorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
