<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdSerahterimaAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_serahterimaadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_serahterimaadd = currentForm = new ew.Form("fnpd_serahterimaadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_serahterima")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_serahterima)
        ew.vars.tables.npd_serahterima = currentTable;
    fnpd_serahterimaadd.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null, ew.Validators.integer], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null, ew.Validators.integer], fields.idcustomer.isInvalid],
        ["tanggal_request", [fields.tanggal_request.visible && fields.tanggal_request.required ? ew.Validators.required(fields.tanggal_request.caption) : null, ew.Validators.datetime(0)], fields.tanggal_request.isInvalid],
        ["tanggal_serahterima", [fields.tanggal_serahterima.visible && fields.tanggal_serahterima.required ? ew.Validators.required(fields.tanggal_serahterima.caption) : null, ew.Validators.datetime(0)], fields.tanggal_serahterima.isInvalid],
        ["jenis_produk", [fields.jenis_produk.visible && fields.jenis_produk.required ? ew.Validators.required(fields.jenis_produk.caption) : null], fields.jenis_produk.isInvalid],
        ["readonly", [fields.readonly.visible && fields.readonly.required ? ew.Validators.required(fields.readonly.caption) : null], fields.readonly.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_serahterimaadd,
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
    fnpd_serahterimaadd.validate = function () {
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
    fnpd_serahterimaadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_serahterimaadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_serahterimaadd.lists.readonly = <?= $Page->readonly->toClientList($Page) ?>;
    loadjs.done("fnpd_serahterimaadd");
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
<form name="fnpd_serahterimaadd" id="fnpd_serahterimaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_serahterima">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_npd_serahterima_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_npd_serahterima_idpegawai">
<input type="<?= $Page->idpegawai->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_idpegawai" name="x_idpegawai" id="x_idpegawai" size="30" placeholder="<?= HtmlEncode($Page->idpegawai->getPlaceHolder()) ?>" value="<?= $Page->idpegawai->EditValue ?>"<?= $Page->idpegawai->editAttributes() ?> aria-describedby="x_idpegawai_help">
<?= $Page->idpegawai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idpegawai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_npd_serahterima_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_npd_serahterima_idcustomer">
<input type="<?= $Page->idcustomer->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_idcustomer" name="x_idcustomer" id="x_idcustomer" size="30" placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>" value="<?= $Page->idcustomer->EditValue ?>"<?= $Page->idcustomer->editAttributes() ?> aria-describedby="x_idcustomer_help">
<?= $Page->idcustomer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
    <div id="r_tanggal_request" class="form-group row">
        <label id="elh_npd_serahterima_tanggal_request" for="x_tanggal_request" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_request->caption() ?><?= $Page->tanggal_request->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el_npd_serahterima_tanggal_request">
<input type="<?= $Page->tanggal_request->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_tanggal_request" name="x_tanggal_request" id="x_tanggal_request" placeholder="<?= HtmlEncode($Page->tanggal_request->getPlaceHolder()) ?>" value="<?= $Page->tanggal_request->EditValue ?>"<?= $Page->tanggal_request->editAttributes() ?> aria-describedby="x_tanggal_request_help">
<?= $Page->tanggal_request->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_request->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_request->ReadOnly && !$Page->tanggal_request->Disabled && !isset($Page->tanggal_request->EditAttrs["readonly"]) && !isset($Page->tanggal_request->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_serahterimaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_serahterimaadd", "x_tanggal_request", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_serahterima->Visible) { // tanggal_serahterima ?>
    <div id="r_tanggal_serahterima" class="form-group row">
        <label id="elh_npd_serahterima_tanggal_serahterima" for="x_tanggal_serahterima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_serahterima->caption() ?><?= $Page->tanggal_serahterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_serahterima->cellAttributes() ?>>
<span id="el_npd_serahterima_tanggal_serahterima">
<input type="<?= $Page->tanggal_serahterima->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_tanggal_serahterima" name="x_tanggal_serahterima" id="x_tanggal_serahterima" placeholder="<?= HtmlEncode($Page->tanggal_serahterima->getPlaceHolder()) ?>" value="<?= $Page->tanggal_serahterima->EditValue ?>"<?= $Page->tanggal_serahterima->editAttributes() ?> aria-describedby="x_tanggal_serahterima_help">
<?= $Page->tanggal_serahterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_serahterima->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_serahterima->ReadOnly && !$Page->tanggal_serahterima->Disabled && !isset($Page->tanggal_serahterima->EditAttrs["readonly"]) && !isset($Page->tanggal_serahterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_serahterimaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_serahterimaadd", "x_tanggal_serahterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenis_produk->Visible) { // jenis_produk ?>
    <div id="r_jenis_produk" class="form-group row">
        <label id="elh_npd_serahterima_jenis_produk" for="x_jenis_produk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenis_produk->caption() ?><?= $Page->jenis_produk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis_produk->cellAttributes() ?>>
<span id="el_npd_serahterima_jenis_produk">
<input type="<?= $Page->jenis_produk->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_jenis_produk" name="x_jenis_produk" id="x_jenis_produk" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jenis_produk->getPlaceHolder()) ?>" value="<?= $Page->jenis_produk->EditValue ?>"<?= $Page->jenis_produk->editAttributes() ?> aria-describedby="x_jenis_produk_help">
<?= $Page->jenis_produk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenis_produk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
    <div id="r_readonly" class="form-group row">
        <label id="elh_npd_serahterima_readonly" class="<?= $Page->LeftColumnClass ?>"><?= $Page->readonly->caption() ?><?= $Page->readonly->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->readonly->cellAttributes() ?>>
<span id="el_npd_serahterima_readonly">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->readonly->isInvalidClass() ?>" data-table="npd_serahterima" data-field="x_readonly" name="x_readonly[]" id="x_readonly_147630" value="1"<?= ConvertToBool($Page->readonly->CurrentValue) ? " checked" : "" ?><?= $Page->readonly->editAttributes() ?> aria-describedby="x_readonly_help">
    <label class="custom-control-label" for="x_readonly_147630"></label>
</div>
<?= $Page->readonly->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->readonly->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_npd_serahterima_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_serahterima_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="npd_serahterima" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_serahterimaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_serahterimaadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("npd_serahterima");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
