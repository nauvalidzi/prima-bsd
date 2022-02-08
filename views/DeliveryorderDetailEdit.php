<?php

namespace PHPMaker2021\production2;

// Page object
$DeliveryorderDetailEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fdeliveryorder_detailedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fdeliveryorder_detailedit = currentForm = new ew.Form("fdeliveryorder_detailedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "deliveryorder_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.deliveryorder_detail)
        ew.vars.tables.deliveryorder_detail = currentTable;
    fdeliveryorder_detailedit.addFields([
        ["totalorder", [fields.totalorder.visible && fields.totalorder.required ? ew.Validators.required(fields.totalorder.caption) : null], fields.totalorder.isInvalid],
        ["sisa", [fields.sisa.visible && fields.sisa.required ? ew.Validators.required(fields.sisa.caption) : null, ew.Validators.integer], fields.sisa.isInvalid],
        ["jumlahkirim", [fields.jumlahkirim.visible && fields.jumlahkirim.required ? ew.Validators.required(fields.jumlahkirim.caption) : null, ew.Validators.integer], fields.jumlahkirim.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fdeliveryorder_detailedit,
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
    fdeliveryorder_detailedit.validate = function () {
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
    fdeliveryorder_detailedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fdeliveryorder_detailedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fdeliveryorder_detailedit");
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
<form name="fdeliveryorder_detailedit" id="fdeliveryorder_detailedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="deliveryorder_detail">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "deliveryorder") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="deliveryorder">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->iddeliveryorder->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->totalorder->Visible) { // totalorder ?>
    <div id="r_totalorder" class="form-group row">
        <label id="elh_deliveryorder_detail_totalorder" for="x_totalorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totalorder->caption() ?><?= $Page->totalorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totalorder->cellAttributes() ?>>
<span id="el_deliveryorder_detail_totalorder">
<span<?= $Page->totalorder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->totalorder->getDisplayValue($Page->totalorder->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="deliveryorder_detail" data-field="x_totalorder" data-hidden="1" name="x_totalorder" id="x_totalorder" value="<?= HtmlEncode($Page->totalorder->CurrentValue) ?>">
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
</div><!-- /page* -->
    <input type="hidden" data-table="deliveryorder_detail" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("deliveryorder_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
