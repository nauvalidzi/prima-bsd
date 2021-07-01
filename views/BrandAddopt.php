<?php

namespace PHPMaker2021\distributor;

// Page object
$BrandAddopt = &$Page;
?>
<script>
var currentForm, currentPageID;
var fbrandaddopt;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "addopt";
    fbrandaddopt = currentForm = new ew.Form("fbrandaddopt", "addopt");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "brand")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.brand)
        ew.vars.tables.brand = currentTable;
    fbrandaddopt.addFields([
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["logo", [fields.logo.visible && fields.logo.required ? ew.Validators.fileRequired(fields.logo.caption) : null], fields.logo.isInvalid],
        ["titipmerk", [fields.titipmerk.visible && fields.titipmerk.required ? ew.Validators.required(fields.titipmerk.caption) : null], fields.titipmerk.isInvalid],
        ["ijinhaki", [fields.ijinhaki.visible && fields.ijinhaki.required ? ew.Validators.required(fields.ijinhaki.caption) : null], fields.ijinhaki.isInvalid],
        ["ijinbpom", [fields.ijinbpom.visible && fields.ijinbpom.required ? ew.Validators.required(fields.ijinbpom.caption) : null], fields.ijinbpom.isInvalid],
        ["aktaperusahaan", [fields.aktaperusahaan.visible && fields.aktaperusahaan.required ? ew.Validators.fileRequired(fields.aktaperusahaan.caption) : null], fields.aktaperusahaan.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fbrandaddopt,
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
    fbrandaddopt.validate = function () {
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
        return true;
    }

    // Form_CustomValidate
    fbrandaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbrandaddopt.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fbrandaddopt.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    fbrandaddopt.lists.titipmerk = <?= $Page->titipmerk->toClientList($Page) ?>;
    fbrandaddopt.lists.ijinhaki = <?= $Page->ijinhaki->toClientList($Page) ?>;
    fbrandaddopt.lists.ijinbpom = <?= $Page->ijinbpom->toClientList($Page) ?>;
    loadjs.done("fbrandaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="fbrandaddopt" id="fbrandaddopt" class="ew-form ew-horizontal" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="brand">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_idcustomer"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="brand_x_idcustomer"
        data-table="brand"
        data-field="x_idcustomer"
        data-value-separator="<?= $Page->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>"
        <?= $Page->idcustomer->editAttributes() ?>>
        <?= $Page->idcustomer->selectOptionListHtml("x_idcustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage() ?></div>
<?= $Page->idcustomer->Lookup->getParamTag($Page, "p_x_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='brand_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "brand_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.brand.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
    </div>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_title"><?= $Page->title->caption() ?><?= $Page->title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="brand" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_kode"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="brand" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->logo->caption() ?><?= $Page->logo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<div id="fd_x_logo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->logo->title() ?>" data-table="brand" data-field="x_logo" name="x_logo" id="x_logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->logo->editAttributes() ?><?= ($Page->logo->ReadOnly || $Page->logo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x_logo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_logo" id= "fn_x_logo" value="<?= $Page->logo->Upload->FileName ?>">
<input type="hidden" name="fa_x_logo" id= "fa_x_logo" value="0">
<input type="hidden" name="fs_x_logo" id= "fs_x_logo" value="255">
<input type="hidden" name="fx_x_logo" id= "fx_x_logo" value="<?= $Page->logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_logo" id= "fm_x_logo" value="<?= $Page->logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_logo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</div>
    </div>
<?php } ?>
<?php if ($Page->titipmerk->Visible) { // titipmerk ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->titipmerk->caption() ?><?= $Page->titipmerk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<template id="tp_x_titipmerk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_titipmerk" name="x_titipmerk" id="x_titipmerk"<?= $Page->titipmerk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_titipmerk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_titipmerk"
    name="x_titipmerk"
    value="<?= HtmlEncode($Page->titipmerk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_titipmerk"
    data-target="dsl_x_titipmerk"
    data-repeatcolumn="5"
    class="form-control<?= $Page->titipmerk->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_titipmerk"
    data-value-separator="<?= $Page->titipmerk->displayValueSeparatorAttribute() ?>"
    <?= $Page->titipmerk->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->titipmerk->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
<?php if ($Page->ijinhaki->Visible) { // ijinhaki ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->ijinhaki->caption() ?><?= $Page->ijinhaki->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<template id="tp_x_ijinhaki">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinhaki" name="x_ijinhaki" id="x_ijinhaki"<?= $Page->ijinhaki->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_ijinhaki" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_ijinhaki"
    name="x_ijinhaki"
    value="<?= HtmlEncode($Page->ijinhaki->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ijinhaki"
    data-target="dsl_x_ijinhaki"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ijinhaki->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinhaki"
    data-value-separator="<?= $Page->ijinhaki->displayValueSeparatorAttribute() ?>"
    <?= $Page->ijinhaki->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ijinhaki->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->ijinbpom->caption() ?><?= $Page->ijinbpom->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->ijinbpom->isInvalidClass() ?>" data-table="brand" data-field="x_ijinbpom" name="x_ijinbpom[]" id="x_ijinbpom_849284" value="1"<?= ConvertToBool($Page->ijinbpom->CurrentValue) ? " checked" : "" ?><?= $Page->ijinbpom->editAttributes() ?>>
    <label class="custom-control-label" for="x_ijinbpom_849284"></label>
</div>
<div class="invalid-feedback"><?= $Page->ijinbpom->getErrorMessage() ?></div>
</div>
    </div>
<?php } ?>
<?php if ($Page->aktaperusahaan->Visible) { // aktaperusahaan ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label"><?= $Page->aktaperusahaan->caption() ?><?= $Page->aktaperusahaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<div id="fd_x_aktaperusahaan">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->aktaperusahaan->title() ?>" data-table="brand" data-field="x_aktaperusahaan" name="x_aktaperusahaan" id="x_aktaperusahaan" lang="<?= CurrentLanguageID() ?>"<?= $Page->aktaperusahaan->editAttributes() ?><?= ($Page->aktaperusahaan->ReadOnly || $Page->aktaperusahaan->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x_aktaperusahaan"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->aktaperusahaan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_aktaperusahaan" id= "fn_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->Upload->FileName ?>">
<input type="hidden" name="fa_x_aktaperusahaan" id= "fa_x_aktaperusahaan" value="0">
<input type="hidden" name="fs_x_aktaperusahaan" id= "fs_x_aktaperusahaan" value="255">
<input type="hidden" name="fx_x_aktaperusahaan" id= "fx_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_aktaperusahaan" id= "fm_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->UploadMaxFileSize ?>">
</div>
<table id="ft_x_aktaperusahaan" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_created_at"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="brand" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbrandaddopt", "datetimepicker"], function() {
    ew.createDateTimePicker("fbrandaddopt", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <input type="hidden" data-table="brand" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("brand");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
