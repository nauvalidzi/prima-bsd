<?php

namespace PHPMaker2021\distributor;

// Page object
$IjinhakiEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinhakiedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fijinhakiedit = currentForm = new ew.Form("fijinhakiedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinhaki")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinhaki)
        ew.vars.tables.ijinhaki = currentTable;
    fijinhakiedit.addFields([
        ["aktaperusahaan", [fields.aktaperusahaan.visible && fields.aktaperusahaan.required ? ew.Validators.fileRequired(fields.aktaperusahaan.caption) : null], fields.aktaperusahaan.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["selesai", [fields.selesai.visible && fields.selesai.required ? ew.Validators.required(fields.selesai.caption) : null], fields.selesai.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinhakiedit,
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
    fijinhakiedit.validate = function () {
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
    fijinhakiedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinhakiedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinhakiedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    fijinhakiedit.lists.selesai = <?= $Page->selesai->toClientList($Page) ?>;
    loadjs.done("fijinhakiedit");
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
<form name="fijinhakiedit" id="fijinhakiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->aktaperusahaan->Visible) { // aktaperusahaan ?>
    <div id="r_aktaperusahaan" class="form-group row">
        <label id="elh_ijinhaki_aktaperusahaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktaperusahaan->caption() ?><?= $Page->aktaperusahaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktaperusahaan->cellAttributes() ?>>
<span id="el_ijinhaki_aktaperusahaan">
<div id="fd_x_aktaperusahaan">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->aktaperusahaan->title() ?>" data-table="ijinhaki" data-field="x_aktaperusahaan" name="x_aktaperusahaan" id="x_aktaperusahaan" lang="<?= CurrentLanguageID() ?>"<?= $Page->aktaperusahaan->editAttributes() ?><?= ($Page->aktaperusahaan->ReadOnly || $Page->aktaperusahaan->Disabled) ? " disabled" : "" ?> aria-describedby="x_aktaperusahaan_help">
        <label class="custom-file-label ew-file-label" for="x_aktaperusahaan"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->aktaperusahaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aktaperusahaan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_aktaperusahaan" id= "fn_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->Upload->FileName ?>">
<input type="hidden" name="fa_x_aktaperusahaan" id= "fa_x_aktaperusahaan" value="<?= (Post("fa_x_aktaperusahaan") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_aktaperusahaan" id= "fs_x_aktaperusahaan" value="255">
<input type="hidden" name="fx_x_aktaperusahaan" id= "fx_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_aktaperusahaan" id= "fm_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->UploadMaxFileSize ?>">
</div>
<table id="ft_x_aktaperusahaan" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_ijinhaki_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_ijinhaki_status">
    <select
        id="x_status"
        name="x_status"
        class="form-control ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="ijinhaki_x_status"
        data-table="ijinhaki"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_x_status']"),
        options = { name: "x_status", selectId: "ijinhaki_x_status", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.ijinhaki.fields.status.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <div id="r_selesai" class="form-group row">
        <label id="elh_ijinhaki_selesai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->selesai->caption() ?><?= $Page->selesai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->selesai->cellAttributes() ?>>
<span id="el_ijinhaki_selesai">
<template id="tp_x_selesai">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="ijinhaki" data-field="x_selesai" name="x_selesai" id="x_selesai"<?= $Page->selesai->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_selesai" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_selesai"
    name="x_selesai"
    value="<?= HtmlEncode($Page->selesai->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_selesai"
    data-target="dsl_x_selesai"
    data-repeatcolumn="5"
    class="form-control<?= $Page->selesai->isInvalidClass() ?>"
    data-table="ijinhaki"
    data-field="x_selesai"
    data-value-separator="<?= $Page->selesai->displayValueSeparatorAttribute() ?>"
    <?= $Page->selesai->editAttributes() ?>>
<?= $Page->selesai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->selesai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="ijinhaki" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php
    if (in_array("ijinhaki_status", explode(",", $Page->getCurrentDetailTable())) && $ijinhaki_status->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("ijinhaki_status", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "IjinhakiStatusGrid.php" ?>
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
    ew.addEventHandlers("ijinhaki");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
