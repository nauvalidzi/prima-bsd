<?php

namespace PHPMaker2021\distributor;

// Page object
$IjinhakiStatusAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinhaki_statusadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fijinhaki_statusadd = currentForm = new ew.Form("fijinhaki_statusadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinhaki_status")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinhaki_status)
        ew.vars.tables.ijinhaki_status = currentTable;
    fijinhaki_statusadd.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["targetmulai", [fields.targetmulai.visible && fields.targetmulai.required ? ew.Validators.required(fields.targetmulai.caption) : null, ew.Validators.datetime(0)], fields.targetmulai.isInvalid],
        ["tglmulai", [fields.tglmulai.visible && fields.tglmulai.required ? ew.Validators.required(fields.tglmulai.caption) : null, ew.Validators.datetime(0)], fields.tglmulai.isInvalid],
        ["targetselesai", [fields.targetselesai.visible && fields.targetselesai.required ? ew.Validators.required(fields.targetselesai.caption) : null, ew.Validators.datetime(0)], fields.targetselesai.isInvalid],
        ["tglselesai", [fields.tglselesai.visible && fields.tglselesai.required ? ew.Validators.required(fields.tglselesai.caption) : null, ew.Validators.datetime(0)], fields.tglselesai.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["lampiran", [fields.lampiran.visible && fields.lampiran.required ? ew.Validators.fileRequired(fields.lampiran.caption) : null], fields.lampiran.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinhaki_statusadd,
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
    fijinhaki_statusadd.validate = function () {
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
    fijinhaki_statusadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinhaki_statusadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinhaki_statusadd.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    loadjs.done("fijinhaki_statusadd");
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
<form name="fijinhaki_statusadd" id="fijinhaki_statusadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki_status">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "ijinhaki") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="ijinhaki">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idijinhaki->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_ijinhaki_status_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_ijinhaki_status_idpegawai">
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="ijinhaki_status_x_idpegawai"
        data-table="ijinhaki_status"
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
    var el = document.querySelector("select[data-select2-id='ijinhaki_status_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "ijinhaki_status_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki_status.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_ijinhaki_status_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_ijinhaki_status_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->targetmulai->Visible) { // targetmulai ?>
    <div id="r_targetmulai" class="form-group row">
        <label id="elh_ijinhaki_status_targetmulai" for="x_targetmulai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->targetmulai->caption() ?><?= $Page->targetmulai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->targetmulai->cellAttributes() ?>>
<span id="el_ijinhaki_status_targetmulai">
<input type="<?= $Page->targetmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetmulai" name="x_targetmulai" id="x_targetmulai" placeholder="<?= HtmlEncode($Page->targetmulai->getPlaceHolder()) ?>" value="<?= $Page->targetmulai->EditValue ?>"<?= $Page->targetmulai->editAttributes() ?> aria-describedby="x_targetmulai_help">
<?= $Page->targetmulai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->targetmulai->getErrorMessage() ?></div>
<?php if (!$Page->targetmulai->ReadOnly && !$Page->targetmulai->Disabled && !isset($Page->targetmulai->EditAttrs["readonly"]) && !isset($Page->targetmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusadd", "x_targetmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglmulai->Visible) { // tglmulai ?>
    <div id="r_tglmulai" class="form-group row">
        <label id="elh_ijinhaki_status_tglmulai" for="x_tglmulai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglmulai->caption() ?><?= $Page->tglmulai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglmulai->cellAttributes() ?>>
<span id="el_ijinhaki_status_tglmulai">
<input type="<?= $Page->tglmulai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglmulai" name="x_tglmulai" id="x_tglmulai" placeholder="<?= HtmlEncode($Page->tglmulai->getPlaceHolder()) ?>" value="<?= $Page->tglmulai->EditValue ?>"<?= $Page->tglmulai->editAttributes() ?> aria-describedby="x_tglmulai_help">
<?= $Page->tglmulai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglmulai->getErrorMessage() ?></div>
<?php if (!$Page->tglmulai->ReadOnly && !$Page->tglmulai->Disabled && !isset($Page->tglmulai->EditAttrs["readonly"]) && !isset($Page->tglmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusadd", "x_tglmulai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->targetselesai->Visible) { // targetselesai ?>
    <div id="r_targetselesai" class="form-group row">
        <label id="elh_ijinhaki_status_targetselesai" for="x_targetselesai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->targetselesai->caption() ?><?= $Page->targetselesai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->targetselesai->cellAttributes() ?>>
<span id="el_ijinhaki_status_targetselesai">
<input type="<?= $Page->targetselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_targetselesai" name="x_targetselesai" id="x_targetselesai" placeholder="<?= HtmlEncode($Page->targetselesai->getPlaceHolder()) ?>" value="<?= $Page->targetselesai->EditValue ?>"<?= $Page->targetselesai->editAttributes() ?> aria-describedby="x_targetselesai_help">
<?= $Page->targetselesai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->targetselesai->getErrorMessage() ?></div>
<?php if (!$Page->targetselesai->ReadOnly && !$Page->targetselesai->Disabled && !isset($Page->targetselesai->EditAttrs["readonly"]) && !isset($Page->targetselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusadd", "x_targetselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglselesai->Visible) { // tglselesai ?>
    <div id="r_tglselesai" class="form-group row">
        <label id="elh_ijinhaki_status_tglselesai" for="x_tglselesai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglselesai->caption() ?><?= $Page->tglselesai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglselesai->cellAttributes() ?>>
<span id="el_ijinhaki_status_tglselesai">
<input type="<?= $Page->tglselesai->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_tglselesai" name="x_tglselesai" id="x_tglselesai" placeholder="<?= HtmlEncode($Page->tglselesai->getPlaceHolder()) ?>" value="<?= $Page->tglselesai->EditValue ?>"<?= $Page->tglselesai->editAttributes() ?> aria-describedby="x_tglselesai_help">
<?= $Page->tglselesai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglselesai->getErrorMessage() ?></div>
<?php if (!$Page->tglselesai->ReadOnly && !$Page->tglselesai->Disabled && !isset($Page->tglselesai->EditAttrs["readonly"]) && !isset($Page->tglselesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhaki_statusadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhaki_statusadd", "x_tglselesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_ijinhaki_status_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_ijinhaki_status_keterangan">
<input type="<?= $Page->keterangan->getInputTextType() ?>" data-table="ijinhaki_status" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>" value="<?= $Page->keterangan->EditValue ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help">
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <div id="r_lampiran" class="form-group row">
        <label id="elh_ijinhaki_status_lampiran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lampiran->caption() ?><?= $Page->lampiran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lampiran->cellAttributes() ?>>
<span id="el_ijinhaki_status_lampiran">
<div id="fd_x_lampiran">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->lampiran->title() ?>" data-table="ijinhaki_status" data-field="x_lampiran" name="x_lampiran" id="x_lampiran" lang="<?= CurrentLanguageID() ?>"<?= $Page->lampiran->editAttributes() ?><?= ($Page->lampiran->ReadOnly || $Page->lampiran->Disabled) ? " disabled" : "" ?> aria-describedby="x_lampiran_help">
        <label class="custom-file-label ew-file-label" for="x_lampiran"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->lampiran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lampiran->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_lampiran" id= "fn_x_lampiran" value="<?= $Page->lampiran->Upload->FileName ?>">
<input type="hidden" name="fa_x_lampiran" id= "fa_x_lampiran" value="0">
<input type="hidden" name="fs_x_lampiran" id= "fs_x_lampiran" value="255">
<input type="hidden" name="fx_x_lampiran" id= "fx_x_lampiran" value="<?= $Page->lampiran->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_lampiran" id= "fm_x_lampiran" value="<?= $Page->lampiran->UploadMaxFileSize ?>">
</div>
<table id="ft_x_lampiran" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_ijinhaki_status_created_by">
    <input type="hidden" data-table="ijinhaki_status" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
    <?php if (strval($Page->idijinhaki->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_idijinhaki" id="x_idijinhaki" value="<?= HtmlEncode(strval($Page->idijinhaki->getSessionValue())) ?>">
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
    ew.addEventHandlers("ijinhaki_status");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
