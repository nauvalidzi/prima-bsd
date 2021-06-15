<?php

namespace PHPMaker2021\distributor;

// Page object
$PembayaranEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpembayaranedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fpembayaranedit = currentForm = new ew.Form("fpembayaranedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pembayaran")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pembayaran)
        ew.vars.tables.pembayaran = currentTable;
    fpembayaranedit.addFields([
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.datetime(0)], fields.tanggal.isInvalid],
        ["totaltagihan", [fields.totaltagihan.visible && fields.totaltagihan.required ? ew.Validators.required(fields.totaltagihan.caption) : null, ew.Validators.integer], fields.totaltagihan.isInvalid],
        ["sisatagihan", [fields.sisatagihan.visible && fields.sisatagihan.required ? ew.Validators.required(fields.sisatagihan.caption) : null, ew.Validators.integer], fields.sisatagihan.isInvalid],
        ["jumlahbayar", [fields.jumlahbayar.visible && fields.jumlahbayar.required ? ew.Validators.required(fields.jumlahbayar.caption) : null, ew.Validators.integer], fields.jumlahbayar.isInvalid],
        ["idtipepayment", [fields.idtipepayment.visible && fields.idtipepayment.required ? ew.Validators.required(fields.idtipepayment.caption) : null], fields.idtipepayment.isInvalid],
        ["bukti", [fields.bukti.visible && fields.bukti.required ? ew.Validators.fileRequired(fields.bukti.caption) : null], fields.bukti.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpembayaranedit,
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
    fpembayaranedit.validate = function () {
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
    fpembayaranedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpembayaranedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpembayaranedit.lists.idtipepayment = <?= $Page->idtipepayment->toClientList($Page) ?>;
    loadjs.done("fpembayaranedit");
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
<form name="fpembayaranedit" id="fpembayaranedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembayaran">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <div id="r_tanggal" class="form-group row">
        <label id="elh_pembayaran_tanggal" for="x_tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal->caption() ?><?= $Page->tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal->cellAttributes() ?>>
<span id="el_pembayaran_tanggal">
<input type="<?= $Page->tanggal->getInputTextType() ?>" data-table="pembayaran" data-field="x_tanggal" name="x_tanggal" id="x_tanggal" placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>" value="<?= $Page->tanggal->EditValue ?>"<?= $Page->tanggal->editAttributes() ?> aria-describedby="x_tanggal_help">
<?= $Page->tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
<?php if (!$Page->tanggal->ReadOnly && !$Page->tanggal->Disabled && !isset($Page->tanggal->EditAttrs["readonly"]) && !isset($Page->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpembayaranedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpembayaranedit", "x_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <div id="r_totaltagihan" class="form-group row">
        <label id="elh_pembayaran_totaltagihan" for="x_totaltagihan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->totaltagihan->caption() ?><?= $Page->totaltagihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totaltagihan->cellAttributes() ?>>
<span id="el_pembayaran_totaltagihan">
<input type="<?= $Page->totaltagihan->getInputTextType() ?>" data-table="pembayaran" data-field="x_totaltagihan" name="x_totaltagihan" id="x_totaltagihan" size="30" placeholder="<?= HtmlEncode($Page->totaltagihan->getPlaceHolder()) ?>" value="<?= $Page->totaltagihan->EditValue ?>"<?= $Page->totaltagihan->editAttributes() ?> aria-describedby="x_totaltagihan_help">
<?= $Page->totaltagihan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->totaltagihan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sisatagihan->Visible) { // sisatagihan ?>
    <div id="r_sisatagihan" class="form-group row">
        <label id="elh_pembayaran_sisatagihan" for="x_sisatagihan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sisatagihan->caption() ?><?= $Page->sisatagihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sisatagihan->cellAttributes() ?>>
<span id="el_pembayaran_sisatagihan">
<input type="<?= $Page->sisatagihan->getInputTextType() ?>" data-table="pembayaran" data-field="x_sisatagihan" name="x_sisatagihan" id="x_sisatagihan" size="30" placeholder="<?= HtmlEncode($Page->sisatagihan->getPlaceHolder()) ?>" value="<?= $Page->sisatagihan->EditValue ?>"<?= $Page->sisatagihan->editAttributes() ?> aria-describedby="x_sisatagihan_help">
<?= $Page->sisatagihan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sisatagihan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahbayar->Visible) { // jumlahbayar ?>
    <div id="r_jumlahbayar" class="form-group row">
        <label id="elh_pembayaran_jumlahbayar" for="x_jumlahbayar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahbayar->caption() ?><?= $Page->jumlahbayar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahbayar->cellAttributes() ?>>
<span id="el_pembayaran_jumlahbayar">
<input type="<?= $Page->jumlahbayar->getInputTextType() ?>" data-table="pembayaran" data-field="x_jumlahbayar" name="x_jumlahbayar" id="x_jumlahbayar" size="30" placeholder="<?= HtmlEncode($Page->jumlahbayar->getPlaceHolder()) ?>" value="<?= $Page->jumlahbayar->EditValue ?>"<?= $Page->jumlahbayar->editAttributes() ?> aria-describedby="x_jumlahbayar_help">
<?= $Page->jumlahbayar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahbayar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idtipepayment->Visible) { // idtipepayment ?>
    <div id="r_idtipepayment" class="form-group row">
        <label id="elh_pembayaran_idtipepayment" for="x_idtipepayment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtipepayment->caption() ?><?= $Page->idtipepayment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idtipepayment->cellAttributes() ?>>
<span id="el_pembayaran_idtipepayment">
    <select
        id="x_idtipepayment"
        name="x_idtipepayment"
        class="form-control ew-select<?= $Page->idtipepayment->isInvalidClass() ?>"
        data-select2-id="pembayaran_x_idtipepayment"
        data-table="pembayaran"
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
    var el = document.querySelector("select[data-select2-id='pembayaran_x_idtipepayment']"),
        options = { name: "x_idtipepayment", selectId: "pembayaran_x_idtipepayment", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pembayaran.fields.idtipepayment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bukti->Visible) { // bukti ?>
    <div id="r_bukti" class="form-group row">
        <label id="elh_pembayaran_bukti" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bukti->caption() ?><?= $Page->bukti->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bukti->cellAttributes() ?>>
<span id="el_pembayaran_bukti">
<div id="fd_x_bukti">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->bukti->title() ?>" data-table="pembayaran" data-field="x_bukti" name="x_bukti" id="x_bukti" lang="<?= CurrentLanguageID() ?>"<?= $Page->bukti->editAttributes() ?><?= ($Page->bukti->ReadOnly || $Page->bukti->Disabled) ? " disabled" : "" ?> aria-describedby="x_bukti_help">
        <label class="custom-file-label ew-file-label" for="x_bukti"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->bukti->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bukti->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_bukti" id= "fn_x_bukti" value="<?= $Page->bukti->Upload->FileName ?>">
<input type="hidden" name="fa_x_bukti" id= "fa_x_bukti" value="<?= (Post("fa_x_bukti") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_bukti" id= "fs_x_bukti" value="255">
<input type="hidden" name="fx_x_bukti" id= "fx_x_bukti" value="<?= $Page->bukti->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_bukti" id= "fm_x_bukti" value="<?= $Page->bukti->UploadMaxFileSize ?>">
</div>
<table id="ft_x_bukti" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="pembayaran" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("pembayaran");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
