<?php

namespace PHPMaker2021\distributor;

// Page object
$IjinbpomAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinbpomadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fijinbpomadd = currentForm = new ew.Form("fijinbpomadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinbpom")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinbpom)
        ew.vars.tables.ijinbpom = currentTable;
    fijinbpomadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null], fields.idbrand.isInvalid],
        ["kontrakkerjasama", [fields.kontrakkerjasama.visible && fields.kontrakkerjasama.required ? ew.Validators.fileRequired(fields.kontrakkerjasama.caption) : null], fields.kontrakkerjasama.isInvalid],
        ["suratkuasa", [fields.suratkuasa.visible && fields.suratkuasa.required ? ew.Validators.fileRequired(fields.suratkuasa.caption) : null], fields.suratkuasa.isInvalid],
        ["suratpembagian", [fields.suratpembagian.visible && fields.suratpembagian.required ? ew.Validators.fileRequired(fields.suratpembagian.caption) : null], fields.suratpembagian.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinbpomadd,
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
    fijinbpomadd.validate = function () {
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
    fijinbpomadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinbpomadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinbpomadd.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    fijinbpomadd.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    fijinbpomadd.lists.idbrand = <?= $Page->idbrand->toClientList($Page) ?>;
    loadjs.done("fijinbpomadd");
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
<form name="fijinbpomadd" id="fijinbpomadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinbpom">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_ijinbpom_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_ijinbpom_id">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="ijinbpom" data-field="x_id" name="x_id" id="x_id" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <div id="r_tglterima" class="form-group row">
        <label id="elh_ijinbpom_tglterima" for="x_tglterima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglterima->caption() ?><?= $Page->tglterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglterima->cellAttributes() ?>>
<span id="el_ijinbpom_tglterima">
<input type="<?= $Page->tglterima->getInputTextType() ?>" data-table="ijinbpom" data-field="x_tglterima" name="x_tglterima" id="x_tglterima" placeholder="<?= HtmlEncode($Page->tglterima->getPlaceHolder()) ?>" value="<?= $Page->tglterima->EditValue ?>"<?= $Page->tglterima->editAttributes() ?> aria-describedby="x_tglterima_help">
<?= $Page->tglterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglterima->getErrorMessage() ?></div>
<?php if (!$Page->tglterima->ReadOnly && !$Page->tglterima->Disabled && !isset($Page->tglterima->EditAttrs["readonly"]) && !isset($Page->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinbpomadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinbpomadd", "x_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_ijinbpom_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_ijinbpom_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="ijinbpom" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinbpomadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinbpomadd", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_ijinbpom_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_ijinbpom_idpegawai">
<?php $Page->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="ijinbpom_x_idpegawai"
        data-table="ijinbpom"
        data-field="x_idpegawai"
        data-value-separator="<?= $Page->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idpegawai->getPlaceHolder()) ?>"
        <?= $Page->idpegawai->editAttributes() ?>>
        <?= $Page->idpegawai->selectOptionListHtml("x_idpegawai") ?>
    </select>
    <?= $Page->idpegawai->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idpegawai->getErrorMessage() ?></div>
<?= $Page->idpegawai->Lookup->getParamTag($Page, "p_x_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinbpom_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "ijinbpom_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_ijinbpom_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_ijinbpom_idcustomer">
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="ijinbpom_x_idcustomer"
        data-table="ijinbpom"
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
    var el = document.querySelector("select[data-select2-id='ijinbpom_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "ijinbpom_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <div id="r_idbrand" class="form-group row">
        <label id="elh_ijinbpom_idbrand" for="x_idbrand" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idbrand->caption() ?><?= $Page->idbrand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idbrand->cellAttributes() ?>>
<span id="el_ijinbpom_idbrand">
    <select
        id="x_idbrand"
        name="x_idbrand"
        class="form-control ew-select<?= $Page->idbrand->isInvalidClass() ?>"
        data-select2-id="ijinbpom_x_idbrand"
        data-table="ijinbpom"
        data-field="x_idbrand"
        data-value-separator="<?= $Page->idbrand->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idbrand->getPlaceHolder()) ?>"
        <?= $Page->idbrand->editAttributes() ?>>
        <?= $Page->idbrand->selectOptionListHtml("x_idbrand") ?>
    </select>
    <?= $Page->idbrand->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idbrand->getErrorMessage() ?></div>
<?= $Page->idbrand->Lookup->getParamTag($Page, "p_x_idbrand") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinbpom_x_idbrand']"),
        options = { name: "x_idbrand", selectId: "ijinbpom_x_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kontrakkerjasama->Visible) { // kontrakkerjasama ?>
    <div id="r_kontrakkerjasama" class="form-group row">
        <label id="elh_ijinbpom_kontrakkerjasama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kontrakkerjasama->caption() ?><?= $Page->kontrakkerjasama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kontrakkerjasama->cellAttributes() ?>>
<span id="el_ijinbpom_kontrakkerjasama">
<div id="fd_x_kontrakkerjasama">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->kontrakkerjasama->title() ?>" data-table="ijinbpom" data-field="x_kontrakkerjasama" name="x_kontrakkerjasama" id="x_kontrakkerjasama" lang="<?= CurrentLanguageID() ?>"<?= $Page->kontrakkerjasama->editAttributes() ?><?= ($Page->kontrakkerjasama->ReadOnly || $Page->kontrakkerjasama->Disabled) ? " disabled" : "" ?> aria-describedby="x_kontrakkerjasama_help">
        <label class="custom-file-label ew-file-label" for="x_kontrakkerjasama"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->kontrakkerjasama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kontrakkerjasama->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_kontrakkerjasama" id= "fn_x_kontrakkerjasama" value="<?= $Page->kontrakkerjasama->Upload->FileName ?>">
<input type="hidden" name="fa_x_kontrakkerjasama" id= "fa_x_kontrakkerjasama" value="0">
<input type="hidden" name="fs_x_kontrakkerjasama" id= "fs_x_kontrakkerjasama" value="255">
<input type="hidden" name="fx_x_kontrakkerjasama" id= "fx_x_kontrakkerjasama" value="<?= $Page->kontrakkerjasama->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_kontrakkerjasama" id= "fm_x_kontrakkerjasama" value="<?= $Page->kontrakkerjasama->UploadMaxFileSize ?>">
</div>
<table id="ft_x_kontrakkerjasama" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->suratkuasa->Visible) { // suratkuasa ?>
    <div id="r_suratkuasa" class="form-group row">
        <label id="elh_ijinbpom_suratkuasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->suratkuasa->caption() ?><?= $Page->suratkuasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->suratkuasa->cellAttributes() ?>>
<span id="el_ijinbpom_suratkuasa">
<div id="fd_x_suratkuasa">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->suratkuasa->title() ?>" data-table="ijinbpom" data-field="x_suratkuasa" name="x_suratkuasa" id="x_suratkuasa" lang="<?= CurrentLanguageID() ?>"<?= $Page->suratkuasa->editAttributes() ?><?= ($Page->suratkuasa->ReadOnly || $Page->suratkuasa->Disabled) ? " disabled" : "" ?> aria-describedby="x_suratkuasa_help">
        <label class="custom-file-label ew-file-label" for="x_suratkuasa"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->suratkuasa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->suratkuasa->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_suratkuasa" id= "fn_x_suratkuasa" value="<?= $Page->suratkuasa->Upload->FileName ?>">
<input type="hidden" name="fa_x_suratkuasa" id= "fa_x_suratkuasa" value="0">
<input type="hidden" name="fs_x_suratkuasa" id= "fs_x_suratkuasa" value="255">
<input type="hidden" name="fx_x_suratkuasa" id= "fx_x_suratkuasa" value="<?= $Page->suratkuasa->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_suratkuasa" id= "fm_x_suratkuasa" value="<?= $Page->suratkuasa->UploadMaxFileSize ?>">
</div>
<table id="ft_x_suratkuasa" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->suratpembagian->Visible) { // suratpembagian ?>
    <div id="r_suratpembagian" class="form-group row">
        <label id="elh_ijinbpom_suratpembagian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->suratpembagian->caption() ?><?= $Page->suratpembagian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->suratpembagian->cellAttributes() ?>>
<span id="el_ijinbpom_suratpembagian">
<div id="fd_x_suratpembagian">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->suratpembagian->title() ?>" data-table="ijinbpom" data-field="x_suratpembagian" name="x_suratpembagian" id="x_suratpembagian" lang="<?= CurrentLanguageID() ?>"<?= $Page->suratpembagian->editAttributes() ?><?= ($Page->suratpembagian->ReadOnly || $Page->suratpembagian->Disabled) ? " disabled" : "" ?> aria-describedby="x_suratpembagian_help">
        <label class="custom-file-label ew-file-label" for="x_suratpembagian"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->suratpembagian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->suratpembagian->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_suratpembagian" id= "fn_x_suratpembagian" value="<?= $Page->suratpembagian->Upload->FileName ?>">
<input type="hidden" name="fa_x_suratpembagian" id= "fa_x_suratpembagian" value="0">
<input type="hidden" name="fs_x_suratpembagian" id= "fs_x_suratpembagian" value="255">
<input type="hidden" name="fx_x_suratpembagian" id= "fx_x_suratpembagian" value="<?= $Page->suratpembagian->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_suratpembagian" id= "fm_x_suratpembagian" value="<?= $Page->suratpembagian->UploadMaxFileSize ?>">
</div>
<table id="ft_x_suratpembagian" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_ijinbpom_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_ijinbpom_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="ijinbpom" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_ijinbpom_created_by">
    <input type="hidden" data-table="ijinbpom" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("ijinbpom_detail", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_detail->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_detail") {
            $firstActiveDetailTable = "ijinbpom_detail";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("ijinbpom_detail") ?>" href="#tab_ijinbpom_detail" data-toggle="tab"><?= $Language->tablePhrase("ijinbpom_detail", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("ijinbpom_status", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_status->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_status") {
            $firstActiveDetailTable = "ijinbpom_status";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("ijinbpom_status") ?>" href="#tab_ijinbpom_status" data-toggle="tab"><?= $Language->tablePhrase("ijinbpom_status", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("ijinbpom_detail", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_detail->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_detail") {
            $firstActiveDetailTable = "ijinbpom_detail";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("ijinbpom_detail") ?>" id="tab_ijinbpom_detail"><!-- page* -->
<?php include_once "IjinbpomDetailGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("ijinbpom_status", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_status->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_status") {
            $firstActiveDetailTable = "ijinbpom_status";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("ijinbpom_status") ?>" id="tab_ijinbpom_status"><!-- page* -->
<?php include_once "IjinbpomStatusGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
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
    ew.addEventHandlers("ijinbpom");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){$("[data-field='x_idnpd']").change((function(){var a=this.id.split("_")[0],d=$(this).val();$.get("/bsd/api/get/finalKodeSample/"+d,(function(d){$("#"+a+"_kodesample").val(d.kode)}))}))}));
});
</script>
