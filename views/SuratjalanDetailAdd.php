<?php

namespace PHPMaker2021\distributor;

// Page object
$SuratjalanDetailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsuratjalan_detailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsuratjalan_detailadd = currentForm = new ew.Form("fsuratjalan_detailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "suratjalan_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.suratjalan_detail)
        ew.vars.tables.suratjalan_detail = currentTable;
    fsuratjalan_detailadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["idinvoice", [fields.idinvoice.visible && fields.idinvoice.required ? ew.Validators.required(fields.idinvoice.caption) : null], fields.idinvoice.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsuratjalan_detailadd,
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
    fsuratjalan_detailadd.validate = function () {
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
    fsuratjalan_detailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsuratjalan_detailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsuratjalan_detailadd.lists.idinvoice = <?= $Page->idinvoice->toClientList($Page) ?>;
    loadjs.done("fsuratjalan_detailadd");
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
<form name="fsuratjalan_detailadd" id="fsuratjalan_detailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="suratjalan_detail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "suratjalan") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="suratjalan">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idsuratjalan->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_suratjalan_detail_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_suratjalan_detail_id">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="suratjalan_detail" data-field="x_id" name="x_id" id="x_id" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { // idinvoice ?>
    <div id="r_idinvoice" class="form-group row">
        <label id="elh_suratjalan_detail_idinvoice" for="x_idinvoice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idinvoice->caption() ?><?= $Page->idinvoice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idinvoice->cellAttributes() ?>>
<span id="el_suratjalan_detail_idinvoice">
    <select
        id="x_idinvoice"
        name="x_idinvoice"
        class="form-control ew-select<?= $Page->idinvoice->isInvalidClass() ?>"
        data-select2-id="suratjalan_detail_x_idinvoice"
        data-table="suratjalan_detail"
        data-field="x_idinvoice"
        data-value-separator="<?= $Page->idinvoice->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idinvoice->getPlaceHolder()) ?>"
        <?= $Page->idinvoice->editAttributes() ?>>
        <?= $Page->idinvoice->selectOptionListHtml("x_idinvoice") ?>
    </select>
    <?= $Page->idinvoice->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idinvoice->getErrorMessage() ?></div>
<?= $Page->idinvoice->Lookup->getParamTag($Page, "p_x_idinvoice") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='suratjalan_detail_x_idinvoice']"),
        options = { name: "x_idinvoice", selectId: "suratjalan_detail_x_idinvoice", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.suratjalan_detail.fields.idinvoice.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_suratjalan_detail_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_suratjalan_detail_keterangan">
<input type="<?= $Page->keterangan->getInputTextType() ?>" data-table="suratjalan_detail" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>" value="<?= $Page->keterangan->EditValue ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help">
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_suratjalan_detail_created_by">
    <input type="hidden" data-table="suratjalan_detail" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
    <?php if (strval($Page->idsuratjalan->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_idsuratjalan" id="x_idsuratjalan" value="<?= HtmlEncode(strval($Page->idsuratjalan->getSessionValue())) ?>">
    <?php } ?>
<?php
    if (in_array("invoice", explode(",", $Page->getCurrentDetailTable())) && $invoice->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("invoice", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "InvoiceGrid.php" ?>
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
    ew.addEventHandlers("suratjalan_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
