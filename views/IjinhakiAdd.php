<?php

namespace PHPMaker2021\production2;

// Page object
$IjinhakiAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinhakiadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fijinhakiadd = currentForm = new ew.Form("fijinhakiadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinhaki")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinhaki)
        ew.vars.tables.ijinhaki = currentTable;
    fijinhakiadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["ktp", [fields.ktp.visible && fields.ktp.required ? ew.Validators.required(fields.ktp.caption) : null], fields.ktp.isInvalid],
        ["npwp", [fields.npwp.visible && fields.npwp.required ? ew.Validators.required(fields.npwp.caption) : null], fields.npwp.isInvalid],
        ["nib", [fields.nib.visible && fields.nib.required ? ew.Validators.required(fields.nib.caption) : null], fields.nib.isInvalid],
        ["akta_pendirian", [fields.akta_pendirian.visible && fields.akta_pendirian.required ? ew.Validators.fileRequired(fields.akta_pendirian.caption) : null], fields.akta_pendirian.isInvalid],
        ["sk_umk", [fields.sk_umk.visible && fields.sk_umk.required ? ew.Validators.required(fields.sk_umk.caption) : null], fields.sk_umk.isInvalid],
        ["ttd_pemohon", [fields.ttd_pemohon.visible && fields.ttd_pemohon.required ? ew.Validators.fileRequired(fields.ttd_pemohon.caption) : null], fields.ttd_pemohon.isInvalid],
        ["nama_brand", [fields.nama_brand.visible && fields.nama_brand.required ? ew.Validators.required(fields.nama_brand.caption) : null], fields.nama_brand.isInvalid],
        ["label_brand", [fields.label_brand.visible && fields.label_brand.required ? ew.Validators.fileRequired(fields.label_brand.caption) : null], fields.label_brand.isInvalid],
        ["deskripsi_brand", [fields.deskripsi_brand.visible && fields.deskripsi_brand.required ? ew.Validators.required(fields.deskripsi_brand.caption) : null], fields.deskripsi_brand.isInvalid],
        ["unsur_brand", [fields.unsur_brand.visible && fields.unsur_brand.required ? ew.Validators.required(fields.unsur_brand.caption) : null], fields.unsur_brand.isInvalid],
        ["submitted_by", [fields.submitted_by.visible && fields.submitted_by.required ? ew.Validators.required(fields.submitted_by.caption) : null], fields.submitted_by.isInvalid],
        ["checked1_by", [fields.checked1_by.visible && fields.checked1_by.required ? ew.Validators.required(fields.checked1_by.caption) : null], fields.checked1_by.isInvalid],
        ["checked2_by", [fields.checked2_by.visible && fields.checked2_by.required ? ew.Validators.required(fields.checked2_by.caption) : null], fields.checked2_by.isInvalid],
        ["approved_by", [fields.approved_by.visible && fields.approved_by.required ? ew.Validators.required(fields.approved_by.caption) : null], fields.approved_by.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinhakiadd,
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
    fijinhakiadd.validate = function () {
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
    fijinhakiadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinhakiadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinhakiadd.lists.idnpd = <?= $Page->idnpd->toClientList($Page) ?>;
    fijinhakiadd.lists.submitted_by = <?= $Page->submitted_by->toClientList($Page) ?>;
    fijinhakiadd.lists.checked1_by = <?= $Page->checked1_by->toClientList($Page) ?>;
    fijinhakiadd.lists.checked2_by = <?= $Page->checked2_by->toClientList($Page) ?>;
    fijinhakiadd.lists.approved_by = <?= $Page->approved_by->toClientList($Page) ?>;
    fijinhakiadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fijinhakiadd");
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
<form name="fijinhakiadd" id="fijinhakiadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_ijinhaki_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_idnpd"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_ijinhaki_idnpd"><span id="el_ijinhaki_idnpd">
    <select
        id="x_idnpd"
        name="x_idnpd"
        class="form-control ew-select<?= $Page->idnpd->isInvalidClass() ?>"
        data-select2-id="ijinhaki_x_idnpd"
        data-table="ijinhaki"
        data-field="x_idnpd"
        data-value-separator="<?= $Page->idnpd->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>"
        <?= $Page->idnpd->editAttributes() ?>>
        <?= $Page->idnpd->selectOptionListHtml("x_idnpd") ?>
    </select>
    <?= $Page->idnpd->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
<?= $Page->idnpd->Lookup->getParamTag($Page, "p_x_idnpd") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_x_idnpd']"),
        options = { name: "x_idnpd", selectId: "ijinhaki_x_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <div id="r_tglterima" class="form-group row">
        <label id="elh_ijinhaki_tglterima" for="x_tglterima" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_tglterima"><?= $Page->tglterima->caption() ?><?= $Page->tglterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_ijinhaki_tglterima"><span id="el_ijinhaki_tglterima">
<input type="<?= $Page->tglterima->getInputTextType() ?>" data-table="ijinhaki" data-field="x_tglterima" name="x_tglterima" id="x_tglterima" placeholder="<?= HtmlEncode($Page->tglterima->getPlaceHolder()) ?>" value="<?= $Page->tglterima->EditValue ?>"<?= $Page->tglterima->editAttributes() ?> aria-describedby="x_tglterima_help">
<?= $Page->tglterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglterima->getErrorMessage() ?></div>
<?php if (!$Page->tglterima->ReadOnly && !$Page->tglterima->Disabled && !isset($Page->tglterima->EditAttrs["readonly"]) && !isset($Page->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhakiadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhakiadd", "x_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_ijinhaki_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_tglsubmit"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_ijinhaki_tglsubmit"><span id="el_ijinhaki_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="ijinhaki" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinhakiadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinhakiadd", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
    <div id="r_ktp" class="form-group row">
        <label id="elh_ijinhaki_ktp" for="x_ktp" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_ktp"><?= $Page->ktp->caption() ?><?= $Page->ktp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ktp->cellAttributes() ?>>
<template id="tpx_ijinhaki_ktp"><span id="el_ijinhaki_ktp">
<input type="<?= $Page->ktp->getInputTextType() ?>" data-table="ijinhaki" data-field="x_ktp" name="x_ktp" id="x_ktp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ktp->getPlaceHolder()) ?>" value="<?= $Page->ktp->EditValue ?>"<?= $Page->ktp->editAttributes() ?> aria-describedby="x_ktp_help">
<?= $Page->ktp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ktp->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
    <div id="r_npwp" class="form-group row">
        <label id="elh_ijinhaki_npwp" for="x_npwp" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_npwp"><?= $Page->npwp->caption() ?><?= $Page->npwp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->npwp->cellAttributes() ?>>
<template id="tpx_ijinhaki_npwp"><span id="el_ijinhaki_npwp">
<input type="<?= $Page->npwp->getInputTextType() ?>" data-table="ijinhaki" data-field="x_npwp" name="x_npwp" id="x_npwp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->npwp->getPlaceHolder()) ?>" value="<?= $Page->npwp->EditValue ?>"<?= $Page->npwp->editAttributes() ?> aria-describedby="x_npwp_help">
<?= $Page->npwp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->npwp->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nib->Visible) { // nib ?>
    <div id="r_nib" class="form-group row">
        <label id="elh_ijinhaki_nib" for="x_nib" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_nib"><?= $Page->nib->caption() ?><?= $Page->nib->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nib->cellAttributes() ?>>
<template id="tpx_ijinhaki_nib"><span id="el_ijinhaki_nib">
<input type="<?= $Page->nib->getInputTextType() ?>" data-table="ijinhaki" data-field="x_nib" name="x_nib" id="x_nib" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nib->getPlaceHolder()) ?>" value="<?= $Page->nib->EditValue ?>"<?= $Page->nib->editAttributes() ?> aria-describedby="x_nib_help">
<?= $Page->nib->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nib->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akta_pendirian->Visible) { // akta_pendirian ?>
    <div id="r_akta_pendirian" class="form-group row">
        <label id="elh_ijinhaki_akta_pendirian" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_akta_pendirian"><?= $Page->akta_pendirian->caption() ?><?= $Page->akta_pendirian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->akta_pendirian->cellAttributes() ?>>
<template id="tpx_ijinhaki_akta_pendirian"><span id="el_ijinhaki_akta_pendirian">
<div id="fd_x_akta_pendirian">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->akta_pendirian->title() ?>" data-table="ijinhaki" data-field="x_akta_pendirian" name="x_akta_pendirian" id="x_akta_pendirian" lang="<?= CurrentLanguageID() ?>"<?= $Page->akta_pendirian->editAttributes() ?><?= ($Page->akta_pendirian->ReadOnly || $Page->akta_pendirian->Disabled) ? " disabled" : "" ?> aria-describedby="x_akta_pendirian_help">
        <label class="custom-file-label ew-file-label" for="x_akta_pendirian"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->akta_pendirian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akta_pendirian->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_akta_pendirian" id= "fn_x_akta_pendirian" value="<?= $Page->akta_pendirian->Upload->FileName ?>">
<input type="hidden" name="fa_x_akta_pendirian" id= "fa_x_akta_pendirian" value="0">
<input type="hidden" name="fs_x_akta_pendirian" id= "fs_x_akta_pendirian" value="50">
<input type="hidden" name="fx_x_akta_pendirian" id= "fx_x_akta_pendirian" value="<?= $Page->akta_pendirian->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_akta_pendirian" id= "fm_x_akta_pendirian" value="<?= $Page->akta_pendirian->UploadMaxFileSize ?>">
</div>
<table id="ft_x_akta_pendirian" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sk_umk->Visible) { // sk_umk ?>
    <div id="r_sk_umk" class="form-group row">
        <label id="elh_ijinhaki_sk_umk" for="x_sk_umk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_sk_umk"><?= $Page->sk_umk->caption() ?><?= $Page->sk_umk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sk_umk->cellAttributes() ?>>
<template id="tpx_ijinhaki_sk_umk"><span id="el_ijinhaki_sk_umk">
<input type="<?= $Page->sk_umk->getInputTextType() ?>" data-table="ijinhaki" data-field="x_sk_umk" name="x_sk_umk" id="x_sk_umk" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->sk_umk->getPlaceHolder()) ?>" value="<?= $Page->sk_umk->EditValue ?>"<?= $Page->sk_umk->editAttributes() ?> aria-describedby="x_sk_umk_help">
<?= $Page->sk_umk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sk_umk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ttd_pemohon->Visible) { // ttd_pemohon ?>
    <div id="r_ttd_pemohon" class="form-group row">
        <label id="elh_ijinhaki_ttd_pemohon" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_ttd_pemohon"><?= $Page->ttd_pemohon->caption() ?><?= $Page->ttd_pemohon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ttd_pemohon->cellAttributes() ?>>
<template id="tpx_ijinhaki_ttd_pemohon"><span id="el_ijinhaki_ttd_pemohon">
<div id="fd_x_ttd_pemohon">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->ttd_pemohon->title() ?>" data-table="ijinhaki" data-field="x_ttd_pemohon" name="x_ttd_pemohon" id="x_ttd_pemohon" lang="<?= CurrentLanguageID() ?>"<?= $Page->ttd_pemohon->editAttributes() ?><?= ($Page->ttd_pemohon->ReadOnly || $Page->ttd_pemohon->Disabled) ? " disabled" : "" ?> aria-describedby="x_ttd_pemohon_help">
        <label class="custom-file-label ew-file-label" for="x_ttd_pemohon"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->ttd_pemohon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ttd_pemohon->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_ttd_pemohon" id= "fn_x_ttd_pemohon" value="<?= $Page->ttd_pemohon->Upload->FileName ?>">
<input type="hidden" name="fa_x_ttd_pemohon" id= "fa_x_ttd_pemohon" value="0">
<input type="hidden" name="fs_x_ttd_pemohon" id= "fs_x_ttd_pemohon" value="255">
<input type="hidden" name="fx_x_ttd_pemohon" id= "fx_x_ttd_pemohon" value="<?= $Page->ttd_pemohon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_ttd_pemohon" id= "fm_x_ttd_pemohon" value="<?= $Page->ttd_pemohon->UploadMaxFileSize ?>">
</div>
<table id="ft_x_ttd_pemohon" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
    <div id="r_nama_brand" class="form-group row">
        <label id="elh_ijinhaki_nama_brand" for="x_nama_brand" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_nama_brand"><?= $Page->nama_brand->caption() ?><?= $Page->nama_brand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_nama_brand"><span id="el_ijinhaki_nama_brand">
<input type="<?= $Page->nama_brand->getInputTextType() ?>" data-table="ijinhaki" data-field="x_nama_brand" name="x_nama_brand" id="x_nama_brand" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_brand->getPlaceHolder()) ?>" value="<?= $Page->nama_brand->EditValue ?>"<?= $Page->nama_brand->editAttributes() ?> aria-describedby="x_nama_brand_help">
<?= $Page->nama_brand->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_brand->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label_brand->Visible) { // label_brand ?>
    <div id="r_label_brand" class="form-group row">
        <label id="elh_ijinhaki_label_brand" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_label_brand"><?= $Page->label_brand->caption() ?><?= $Page->label_brand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_label_brand"><span id="el_ijinhaki_label_brand">
<div id="fd_x_label_brand">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->label_brand->title() ?>" data-table="ijinhaki" data-field="x_label_brand" name="x_label_brand" id="x_label_brand" lang="<?= CurrentLanguageID() ?>"<?= $Page->label_brand->editAttributes() ?><?= ($Page->label_brand->ReadOnly || $Page->label_brand->Disabled) ? " disabled" : "" ?> aria-describedby="x_label_brand_help">
        <label class="custom-file-label ew-file-label" for="x_label_brand"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->label_brand->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label_brand->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_label_brand" id= "fn_x_label_brand" value="<?= $Page->label_brand->Upload->FileName ?>">
<input type="hidden" name="fa_x_label_brand" id= "fa_x_label_brand" value="0">
<input type="hidden" name="fs_x_label_brand" id= "fs_x_label_brand" value="65535">
<input type="hidden" name="fx_x_label_brand" id= "fx_x_label_brand" value="<?= $Page->label_brand->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_label_brand" id= "fm_x_label_brand" value="<?= $Page->label_brand->UploadMaxFileSize ?>">
</div>
<table id="ft_x_label_brand" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deskripsi_brand->Visible) { // deskripsi_brand ?>
    <div id="r_deskripsi_brand" class="form-group row">
        <label id="elh_ijinhaki_deskripsi_brand" for="x_deskripsi_brand" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_deskripsi_brand"><?= $Page->deskripsi_brand->caption() ?><?= $Page->deskripsi_brand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deskripsi_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_deskripsi_brand"><span id="el_ijinhaki_deskripsi_brand">
<textarea data-table="ijinhaki" data-field="x_deskripsi_brand" name="x_deskripsi_brand" id="x_deskripsi_brand" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->deskripsi_brand->getPlaceHolder()) ?>"<?= $Page->deskripsi_brand->editAttributes() ?> aria-describedby="x_deskripsi_brand_help"><?= $Page->deskripsi_brand->EditValue ?></textarea>
<?= $Page->deskripsi_brand->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deskripsi_brand->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unsur_brand->Visible) { // unsur_brand ?>
    <div id="r_unsur_brand" class="form-group row">
        <label id="elh_ijinhaki_unsur_brand" for="x_unsur_brand" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_unsur_brand"><?= $Page->unsur_brand->caption() ?><?= $Page->unsur_brand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->unsur_brand->cellAttributes() ?>>
<template id="tpx_ijinhaki_unsur_brand"><span id="el_ijinhaki_unsur_brand">
<input type="<?= $Page->unsur_brand->getInputTextType() ?>" data-table="ijinhaki" data-field="x_unsur_brand" name="x_unsur_brand" id="x_unsur_brand" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->unsur_brand->getPlaceHolder()) ?>" value="<?= $Page->unsur_brand->EditValue ?>"<?= $Page->unsur_brand->editAttributes() ?> aria-describedby="x_unsur_brand_help">
<?= $Page->unsur_brand->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->unsur_brand->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <div id="r_submitted_by" class="form-group row">
        <label id="elh_ijinhaki_submitted_by" for="x_submitted_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_submitted_by"><?= $Page->submitted_by->caption() ?><?= $Page->submitted_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_submitted_by"><span id="el_ijinhaki_submitted_by">
    <select
        id="x_submitted_by"
        name="x_submitted_by"
        class="form-control ew-select<?= $Page->submitted_by->isInvalidClass() ?>"
        data-select2-id="ijinhaki_x_submitted_by"
        data-table="ijinhaki"
        data-field="x_submitted_by"
        data-value-separator="<?= $Page->submitted_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->submitted_by->getPlaceHolder()) ?>"
        <?= $Page->submitted_by->editAttributes() ?>>
        <?= $Page->submitted_by->selectOptionListHtml("x_submitted_by") ?>
    </select>
    <?= $Page->submitted_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->submitted_by->getErrorMessage() ?></div>
<?= $Page->submitted_by->Lookup->getParamTag($Page, "p_x_submitted_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_x_submitted_by']"),
        options = { name: "x_submitted_by", selectId: "ijinhaki_x_submitted_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki.fields.submitted_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
    <div id="r_checked1_by" class="form-group row">
        <label id="elh_ijinhaki_checked1_by" for="x_checked1_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_checked1_by"><?= $Page->checked1_by->caption() ?><?= $Page->checked1_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked1_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_checked1_by"><span id="el_ijinhaki_checked1_by">
    <select
        id="x_checked1_by"
        name="x_checked1_by"
        class="form-control ew-select<?= $Page->checked1_by->isInvalidClass() ?>"
        data-select2-id="ijinhaki_x_checked1_by"
        data-table="ijinhaki"
        data-field="x_checked1_by"
        data-value-separator="<?= $Page->checked1_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->checked1_by->getPlaceHolder()) ?>"
        <?= $Page->checked1_by->editAttributes() ?>>
        <?= $Page->checked1_by->selectOptionListHtml("x_checked1_by") ?>
    </select>
    <?= $Page->checked1_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->checked1_by->getErrorMessage() ?></div>
<?= $Page->checked1_by->Lookup->getParamTag($Page, "p_x_checked1_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_x_checked1_by']"),
        options = { name: "x_checked1_by", selectId: "ijinhaki_x_checked1_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki.fields.checked1_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
    <div id="r_checked2_by" class="form-group row">
        <label id="elh_ijinhaki_checked2_by" for="x_checked2_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_checked2_by"><?= $Page->checked2_by->caption() ?><?= $Page->checked2_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked2_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_checked2_by"><span id="el_ijinhaki_checked2_by">
    <select
        id="x_checked2_by"
        name="x_checked2_by"
        class="form-control ew-select<?= $Page->checked2_by->isInvalidClass() ?>"
        data-select2-id="ijinhaki_x_checked2_by"
        data-table="ijinhaki"
        data-field="x_checked2_by"
        data-value-separator="<?= $Page->checked2_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->checked2_by->getPlaceHolder()) ?>"
        <?= $Page->checked2_by->editAttributes() ?>>
        <?= $Page->checked2_by->selectOptionListHtml("x_checked2_by") ?>
    </select>
    <?= $Page->checked2_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->checked2_by->getErrorMessage() ?></div>
<?= $Page->checked2_by->Lookup->getParamTag($Page, "p_x_checked2_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_x_checked2_by']"),
        options = { name: "x_checked2_by", selectId: "ijinhaki_x_checked2_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki.fields.checked2_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_ijinhaki_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_approved_by"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_ijinhaki_approved_by"><span id="el_ijinhaki_approved_by">
    <select
        id="x_approved_by"
        name="x_approved_by"
        class="form-control ew-select<?= $Page->approved_by->isInvalidClass() ?>"
        data-select2-id="ijinhaki_x_approved_by"
        data-table="ijinhaki"
        data-field="x_approved_by"
        data-value-separator="<?= $Page->approved_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->approved_by->getPlaceHolder()) ?>"
        <?= $Page->approved_by->editAttributes() ?>>
        <?= $Page->approved_by->selectOptionListHtml("x_approved_by") ?>
    </select>
    <?= $Page->approved_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->approved_by->getErrorMessage() ?></div>
<?= $Page->approved_by->Lookup->getParamTag($Page, "p_x_approved_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinhaki_x_approved_by']"),
        options = { name: "x_approved_by", selectId: "ijinhaki_x_approved_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinhaki.fields.approved_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_ijinhaki_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_ijinhaki_status"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<template id="tpx_ijinhaki_status"><span id="el_ijinhaki_status">
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
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_ijinhakiadd" class="ew-custom-template"></div>
<template id="tpm_ijinhakiadd">
<div id="ct_IjinhakiAdd"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_ijinhaki_idnpd"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right">Kode Customer</label>
                    <div class="col-8"><input type="text" id="c_customer" class="form-control" placeholder="Kode Customer" disabled></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right">Status</label>
                    <div class="col-8"><input type="text" id="c_status" class="form-control" placeholder="Status" disabled></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglterima->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_tglterima"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglsubmit->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_tglsubmit"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KELENGKAPAN</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->ktp->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_ktp"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->npwp->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_npwp"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->nib->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_nib"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->akta_pendirian->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_akta_pendirian"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->sk_umk->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_sk_umk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->ttd_pemohon->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_ttd_pemohon"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">PENGAJUAN</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->nama_brand->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_nama_brand"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->label_brand->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_label_brand"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->deskripsi_brand->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_deskripsi_brand"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Unsur Warna<br>dalam Label</label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_unsur_brand"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">VALIDASI</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->submitted_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_submitted_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked1_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_checked1_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked2_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_checked2_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->approved_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_ijinhaki_approved_by"></slot></div>
            </div>
        </div>
    </div>
</div>
</div>
</template>
<?php
    if (in_array("ijinhaki_status", explode(",", $Page->getCurrentDetailTable())) && $ijinhaki_status->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("ijinhaki_status", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "IjinhakiStatusGrid.php" ?>
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
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_ijinhakiadd", "tpm_ijinhakiadd", "ijinhakiadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
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
    // Startup script
    $("select[name=x_idnpd]").change((function(){$.ajax({url:"api/npd_customer/"+$(this).val(),type:"GET",success:function(a){!1!==a.success&&($("#c_customer").val(a.data.kodecustomer+", "+a.data.namacustomer),$("#c_status").val(a.data.status))}})}));
});
</script>
