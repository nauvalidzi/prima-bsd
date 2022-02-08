<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_confirmadd = currentForm = new ew.Form("fnpd_confirmadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirm")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirm)
        ew.vars.tables.npd_confirm = currentTable;
    fnpd_confirmadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglkonfirmasi", [fields.tglkonfirmasi.visible && fields.tglkonfirmasi.required ? ew.Validators.required(fields.tglkonfirmasi.caption) : null, ew.Validators.datetime(0)], fields.tglkonfirmasi.isInvalid],
        ["idnpd_sample", [fields.idnpd_sample.visible && fields.idnpd_sample.required ? ew.Validators.required(fields.idnpd_sample.caption) : null], fields.idnpd_sample.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["namapemesan", [fields.namapemesan.visible && fields.namapemesan.required ? ew.Validators.required(fields.namapemesan.caption) : null], fields.namapemesan.isInvalid],
        ["alamatpemesan", [fields.alamatpemesan.visible && fields.alamatpemesan.required ? ew.Validators.required(fields.alamatpemesan.caption) : null], fields.alamatpemesan.isInvalid],
        ["personincharge", [fields.personincharge.visible && fields.personincharge.required ? ew.Validators.required(fields.personincharge.caption) : null], fields.personincharge.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["notelp", [fields.notelp.visible && fields.notelp.required ? ew.Validators.required(fields.notelp.caption) : null], fields.notelp.isInvalid],
        ["confirm_by", [fields.confirm_by.visible && fields.confirm_by.required ? ew.Validators.required(fields.confirm_by.caption) : null], fields.confirm_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmadd,
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
    fnpd_confirmadd.validate = function () {
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
    fnpd_confirmadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_confirmadd.lists.idnpd_sample = <?= $Page->idnpd_sample->toClientList($Page) ?>;
    loadjs.done("fnpd_confirmadd");
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
<form name="fnpd_confirmadd" id="fnpd_confirmadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirm">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "npd") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_confirm_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<?php if ($Page->idnpd->getSessionValue() != "") { ?>
<span id="el_npd_confirm_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnpd->getDisplayValue($Page->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idnpd" name="x_idnpd" value="<?= HtmlEncode($Page->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_npd_confirm_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_confirm" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
    <div id="r_tglkonfirmasi" class="form-group row">
        <label id="elh_npd_confirm_tglkonfirmasi" for="x_tglkonfirmasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglkonfirmasi->caption() ?><?= $Page->tglkonfirmasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglkonfirmasi->cellAttributes() ?>>
<span id="el_npd_confirm_tglkonfirmasi">
<input type="<?= $Page->tglkonfirmasi->getInputTextType() ?>" data-table="npd_confirm" data-field="x_tglkonfirmasi" name="x_tglkonfirmasi" id="x_tglkonfirmasi" placeholder="<?= HtmlEncode($Page->tglkonfirmasi->getPlaceHolder()) ?>" value="<?= $Page->tglkonfirmasi->EditValue ?>"<?= $Page->tglkonfirmasi->editAttributes() ?> aria-describedby="x_tglkonfirmasi_help">
<?= $Page->tglkonfirmasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglkonfirmasi->getErrorMessage() ?></div>
<?php if (!$Page->tglkonfirmasi->ReadOnly && !$Page->tglkonfirmasi->Disabled && !isset($Page->tglkonfirmasi->EditAttrs["readonly"]) && !isset($Page->tglkonfirmasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmadd", "x_tglkonfirmasi", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <div id="r_idnpd_sample" class="form-group row">
        <label id="elh_npd_confirm_idnpd_sample" for="x_idnpd_sample" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd_sample->caption() ?><?= $Page->idnpd_sample->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el_npd_confirm_idnpd_sample">
    <select
        id="x_idnpd_sample"
        name="x_idnpd_sample"
        class="form-control ew-select<?= $Page->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_confirm_x_idnpd_sample"
        data-table="npd_confirm"
        data-field="x_idnpd_sample"
        data-value-separator="<?= $Page->idnpd_sample->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idnpd_sample->getPlaceHolder()) ?>"
        <?= $Page->idnpd_sample->editAttributes() ?>>
        <?= $Page->idnpd_sample->selectOptionListHtml("x_idnpd_sample") ?>
    </select>
    <?= $Page->idnpd_sample->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idnpd_sample->getErrorMessage() ?></div>
<?= $Page->idnpd_sample->Lookup->getParamTag($Page, "p_x_idnpd_sample") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirm_x_idnpd_sample']"),
        options = { name: "x_idnpd_sample", selectId: "npd_confirm_x_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirm.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_npd_confirm_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_npd_confirm_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="npd_confirm" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>"<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
        <label class="custom-file-label ew-file-label" for="x_foto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="0">
<input type="hidden" name="fs_x_foto" id= "fs_x_foto" value="255">
<input type="hidden" name="fx_x_foto" id= "fx_x_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto" id= "fm_x_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
    <div id="r_namapemesan" class="form-group row">
        <label id="elh_npd_confirm_namapemesan" for="x_namapemesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namapemesan->caption() ?><?= $Page->namapemesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namapemesan->cellAttributes() ?>>
<span id="el_npd_confirm_namapemesan">
<input type="<?= $Page->namapemesan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_namapemesan" name="x_namapemesan" id="x_namapemesan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->namapemesan->getPlaceHolder()) ?>" value="<?= $Page->namapemesan->EditValue ?>"<?= $Page->namapemesan->editAttributes() ?> aria-describedby="x_namapemesan_help">
<?= $Page->namapemesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namapemesan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamatpemesan->Visible) { // alamatpemesan ?>
    <div id="r_alamatpemesan" class="form-group row">
        <label id="elh_npd_confirm_alamatpemesan" for="x_alamatpemesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamatpemesan->caption() ?><?= $Page->alamatpemesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamatpemesan->cellAttributes() ?>>
<span id="el_npd_confirm_alamatpemesan">
<input type="<?= $Page->alamatpemesan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_alamatpemesan" name="x_alamatpemesan" id="x_alamatpemesan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamatpemesan->getPlaceHolder()) ?>" value="<?= $Page->alamatpemesan->EditValue ?>"<?= $Page->alamatpemesan->editAttributes() ?> aria-describedby="x_alamatpemesan_help">
<?= $Page->alamatpemesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamatpemesan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
    <div id="r_personincharge" class="form-group row">
        <label id="elh_npd_confirm_personincharge" for="x_personincharge" class="<?= $Page->LeftColumnClass ?>"><?= $Page->personincharge->caption() ?><?= $Page->personincharge->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->personincharge->cellAttributes() ?>>
<span id="el_npd_confirm_personincharge">
<input type="<?= $Page->personincharge->getInputTextType() ?>" data-table="npd_confirm" data-field="x_personincharge" name="x_personincharge" id="x_personincharge" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->personincharge->getPlaceHolder()) ?>" value="<?= $Page->personincharge->EditValue ?>"<?= $Page->personincharge->editAttributes() ?> aria-describedby="x_personincharge_help">
<?= $Page->personincharge->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->personincharge->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_npd_confirm_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_npd_confirm_jabatan">
<input type="<?= $Page->jabatan->getInputTextType() ?>" data-table="npd_confirm" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jabatan->getPlaceHolder()) ?>" value="<?= $Page->jabatan->EditValue ?>"<?= $Page->jabatan->editAttributes() ?> aria-describedby="x_jabatan_help">
<?= $Page->jabatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
    <div id="r_notelp" class="form-group row">
        <label id="elh_npd_confirm_notelp" for="x_notelp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->notelp->caption() ?><?= $Page->notelp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->notelp->cellAttributes() ?>>
<span id="el_npd_confirm_notelp">
<input type="<?= $Page->notelp->getInputTextType() ?>" data-table="npd_confirm" data-field="x_notelp" name="x_notelp" id="x_notelp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->notelp->getPlaceHolder()) ?>" value="<?= $Page->notelp->EditValue ?>"<?= $Page->notelp->editAttributes() ?> aria-describedby="x_notelp_help">
<?= $Page->notelp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->notelp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_npd_confirm_confirm_by">
    <input type="hidden" data-table="npd_confirm" data-field="x_confirm_by" data-hidden="1" name="x_confirm_by" id="x_confirm_by" value="<?= HtmlEncode($Page->confirm_by->CurrentValue) ?>">
    </span>
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
    ew.addEventHandlers("npd_confirm");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){$("#r_namapemesan").before('<h5 class="form-group">Data Pemesan</h5>')}));
});
</script>
