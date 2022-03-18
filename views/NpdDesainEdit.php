<?php

namespace PHPMaker2021\production2;

// Page object
$NpdDesainEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_desainedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_desainedit = currentForm = new ew.Form("fnpd_desainedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_desain")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_desain)
        ew.vars.tables.npd_desain = currentTable;
    fnpd_desainedit.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["klaim_bahan", [fields.klaim_bahan.visible && fields.klaim_bahan.required ? ew.Validators.required(fields.klaim_bahan.caption) : null], fields.klaim_bahan.isInvalid],
        ["campaign_produk", [fields.campaign_produk.visible && fields.campaign_produk.required ? ew.Validators.required(fields.campaign_produk.caption) : null], fields.campaign_produk.isInvalid],
        ["konsepwarna", [fields.konsepwarna.visible && fields.konsepwarna.required ? ew.Validators.required(fields.konsepwarna.caption) : null], fields.konsepwarna.isInvalid],
        ["no_notifikasi", [fields.no_notifikasi.visible && fields.no_notifikasi.required ? ew.Validators.required(fields.no_notifikasi.caption) : null], fields.no_notifikasi.isInvalid],
        ["jenis_kemasan", [fields.jenis_kemasan.visible && fields.jenis_kemasan.required ? ew.Validators.required(fields.jenis_kemasan.caption) : null], fields.jenis_kemasan.isInvalid],
        ["posisi_label", [fields.posisi_label.visible && fields.posisi_label.required ? ew.Validators.required(fields.posisi_label.caption) : null], fields.posisi_label.isInvalid],
        ["bahan_label", [fields.bahan_label.visible && fields.bahan_label.required ? ew.Validators.required(fields.bahan_label.caption) : null], fields.bahan_label.isInvalid],
        ["draft_layout", [fields.draft_layout.visible && fields.draft_layout.required ? ew.Validators.required(fields.draft_layout.caption) : null], fields.draft_layout.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["submitted_by", [fields.submitted_by.visible && fields.submitted_by.required ? ew.Validators.required(fields.submitted_by.caption) : null, ew.Validators.integer], fields.submitted_by.isInvalid],
        ["checked1_by", [fields.checked1_by.visible && fields.checked1_by.required ? ew.Validators.required(fields.checked1_by.caption) : null, ew.Validators.integer], fields.checked1_by.isInvalid],
        ["checked2_by", [fields.checked2_by.visible && fields.checked2_by.required ? ew.Validators.required(fields.checked2_by.caption) : null, ew.Validators.integer], fields.checked2_by.isInvalid],
        ["approved_by", [fields.approved_by.visible && fields.approved_by.required ? ew.Validators.required(fields.approved_by.caption) : null, ew.Validators.integer], fields.approved_by.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_desainedit,
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
    fnpd_desainedit.validate = function () {
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
    fnpd_desainedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_desainedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnpd_desainedit");
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
<form name="fnpd_desainedit" id="fnpd_desainedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_desain">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div d-none"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_desain_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_idnpd"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<template id="tpx_npd_desain_idnpd"><span id="el_npd_desain_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_desain" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <div id="r_tglterima" class="form-group row">
        <label id="elh_npd_desain_tglterima" for="x_tglterima" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_tglterima"><?= $Page->tglterima->caption() ?><?= $Page->tglterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglterima->cellAttributes() ?>>
<template id="tpx_npd_desain_tglterima"><span id="el_npd_desain_tglterima">
<input type="<?= $Page->tglterima->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglterima" name="x_tglterima" id="x_tglterima" placeholder="<?= HtmlEncode($Page->tglterima->getPlaceHolder()) ?>" value="<?= $Page->tglterima->EditValue ?>"<?= $Page->tglterima->editAttributes() ?> aria-describedby="x_tglterima_help">
<?= $Page->tglterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglterima->getErrorMessage() ?></div>
<?php if (!$Page->tglterima->ReadOnly && !$Page->tglterima->Disabled && !isset($Page->tglterima->EditAttrs["readonly"]) && !isset($Page->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desainedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desainedit", "x_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_npd_desain_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_tglsubmit"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<template id="tpx_npd_desain_tglsubmit"><span id="el_npd_desain_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="npd_desain" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desainedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desainedit", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->klaim_bahan->Visible) { // klaim_bahan ?>
    <div id="r_klaim_bahan" class="form-group row">
        <label id="elh_npd_desain_klaim_bahan" for="x_klaim_bahan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_klaim_bahan"><?= $Page->klaim_bahan->caption() ?><?= $Page->klaim_bahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->klaim_bahan->cellAttributes() ?>>
<template id="tpx_npd_desain_klaim_bahan"><span id="el_npd_desain_klaim_bahan">
<input type="<?= $Page->klaim_bahan->getInputTextType() ?>" data-table="npd_desain" data-field="x_klaim_bahan" name="x_klaim_bahan" id="x_klaim_bahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->klaim_bahan->getPlaceHolder()) ?>" value="<?= $Page->klaim_bahan->EditValue ?>"<?= $Page->klaim_bahan->editAttributes() ?> aria-describedby="x_klaim_bahan_help">
<?= $Page->klaim_bahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->klaim_bahan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->campaign_produk->Visible) { // campaign_produk ?>
    <div id="r_campaign_produk" class="form-group row">
        <label id="elh_npd_desain_campaign_produk" for="x_campaign_produk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_campaign_produk"><?= $Page->campaign_produk->caption() ?><?= $Page->campaign_produk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign_produk->cellAttributes() ?>>
<template id="tpx_npd_desain_campaign_produk"><span id="el_npd_desain_campaign_produk">
<input type="<?= $Page->campaign_produk->getInputTextType() ?>" data-table="npd_desain" data-field="x_campaign_produk" name="x_campaign_produk" id="x_campaign_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->campaign_produk->getPlaceHolder()) ?>" value="<?= $Page->campaign_produk->EditValue ?>"<?= $Page->campaign_produk->editAttributes() ?> aria-describedby="x_campaign_produk_help">
<?= $Page->campaign_produk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->campaign_produk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->konsepwarna->Visible) { // konsepwarna ?>
    <div id="r_konsepwarna" class="form-group row">
        <label id="elh_npd_desain_konsepwarna" for="x_konsepwarna" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_konsepwarna"><?= $Page->konsepwarna->caption() ?><?= $Page->konsepwarna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->konsepwarna->cellAttributes() ?>>
<template id="tpx_npd_desain_konsepwarna"><span id="el_npd_desain_konsepwarna">
<input type="<?= $Page->konsepwarna->getInputTextType() ?>" data-table="npd_desain" data-field="x_konsepwarna" name="x_konsepwarna" id="x_konsepwarna" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->konsepwarna->getPlaceHolder()) ?>" value="<?= $Page->konsepwarna->EditValue ?>"<?= $Page->konsepwarna->editAttributes() ?> aria-describedby="x_konsepwarna_help">
<?= $Page->konsepwarna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->konsepwarna->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_notifikasi->Visible) { // no_notifikasi ?>
    <div id="r_no_notifikasi" class="form-group row">
        <label id="elh_npd_desain_no_notifikasi" for="x_no_notifikasi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_no_notifikasi"><?= $Page->no_notifikasi->caption() ?><?= $Page->no_notifikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_notifikasi->cellAttributes() ?>>
<template id="tpx_npd_desain_no_notifikasi"><span id="el_npd_desain_no_notifikasi">
<input type="<?= $Page->no_notifikasi->getInputTextType() ?>" data-table="npd_desain" data-field="x_no_notifikasi" name="x_no_notifikasi" id="x_no_notifikasi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->no_notifikasi->getPlaceHolder()) ?>" value="<?= $Page->no_notifikasi->EditValue ?>"<?= $Page->no_notifikasi->editAttributes() ?> aria-describedby="x_no_notifikasi_help">
<?= $Page->no_notifikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_notifikasi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenis_kemasan->Visible) { // jenis_kemasan ?>
    <div id="r_jenis_kemasan" class="form-group row">
        <label id="elh_npd_desain_jenis_kemasan" for="x_jenis_kemasan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_jenis_kemasan"><?= $Page->jenis_kemasan->caption() ?><?= $Page->jenis_kemasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis_kemasan->cellAttributes() ?>>
<template id="tpx_npd_desain_jenis_kemasan"><span id="el_npd_desain_jenis_kemasan">
<input type="<?= $Page->jenis_kemasan->getInputTextType() ?>" data-table="npd_desain" data-field="x_jenis_kemasan" name="x_jenis_kemasan" id="x_jenis_kemasan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jenis_kemasan->getPlaceHolder()) ?>" value="<?= $Page->jenis_kemasan->EditValue ?>"<?= $Page->jenis_kemasan->editAttributes() ?> aria-describedby="x_jenis_kemasan_help">
<?= $Page->jenis_kemasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenis_kemasan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->posisi_label->Visible) { // posisi_label ?>
    <div id="r_posisi_label" class="form-group row">
        <label id="elh_npd_desain_posisi_label" for="x_posisi_label" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_posisi_label"><?= $Page->posisi_label->caption() ?><?= $Page->posisi_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->posisi_label->cellAttributes() ?>>
<template id="tpx_npd_desain_posisi_label"><span id="el_npd_desain_posisi_label">
<input type="<?= $Page->posisi_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_posisi_label" name="x_posisi_label" id="x_posisi_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->posisi_label->getPlaceHolder()) ?>" value="<?= $Page->posisi_label->EditValue ?>"<?= $Page->posisi_label->editAttributes() ?> aria-describedby="x_posisi_label_help">
<?= $Page->posisi_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->posisi_label->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahan_label->Visible) { // bahan_label ?>
    <div id="r_bahan_label" class="form-group row">
        <label id="elh_npd_desain_bahan_label" for="x_bahan_label" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_bahan_label"><?= $Page->bahan_label->caption() ?><?= $Page->bahan_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahan_label->cellAttributes() ?>>
<template id="tpx_npd_desain_bahan_label"><span id="el_npd_desain_bahan_label">
<input type="<?= $Page->bahan_label->getInputTextType() ?>" data-table="npd_desain" data-field="x_bahan_label" name="x_bahan_label" id="x_bahan_label" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bahan_label->getPlaceHolder()) ?>" value="<?= $Page->bahan_label->EditValue ?>"<?= $Page->bahan_label->editAttributes() ?> aria-describedby="x_bahan_label_help">
<?= $Page->bahan_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahan_label->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->draft_layout->Visible) { // draft_layout ?>
    <div id="r_draft_layout" class="form-group row">
        <label id="elh_npd_desain_draft_layout" for="x_draft_layout" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_draft_layout"><?= $Page->draft_layout->caption() ?><?= $Page->draft_layout->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->draft_layout->cellAttributes() ?>>
<template id="tpx_npd_desain_draft_layout"><span id="el_npd_desain_draft_layout">
<input type="<?= $Page->draft_layout->getInputTextType() ?>" data-table="npd_desain" data-field="x_draft_layout" name="x_draft_layout" id="x_draft_layout" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->draft_layout->getPlaceHolder()) ?>" value="<?= $Page->draft_layout->EditValue ?>"<?= $Page->draft_layout->editAttributes() ?> aria-describedby="x_draft_layout_help">
<?= $Page->draft_layout->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->draft_layout->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_npd_desain_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_keterangan"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<template id="tpx_npd_desain_keterangan"><span id="el_npd_desain_keterangan">
<textarea data-table="npd_desain" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
    <div id="r_submitted_by" class="form-group row">
        <label id="elh_npd_desain_submitted_by" for="x_submitted_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_submitted_by"><?= $Page->submitted_by->caption() ?><?= $Page->submitted_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->submitted_by->cellAttributes() ?>>
<template id="tpx_npd_desain_submitted_by"><span id="el_npd_desain_submitted_by">
<input type="<?= $Page->submitted_by->getInputTextType() ?>" data-table="npd_desain" data-field="x_submitted_by" name="x_submitted_by" id="x_submitted_by" size="30" placeholder="<?= HtmlEncode($Page->submitted_by->getPlaceHolder()) ?>" value="<?= $Page->submitted_by->EditValue ?>"<?= $Page->submitted_by->editAttributes() ?> aria-describedby="x_submitted_by_help">
<?= $Page->submitted_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->submitted_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
    <div id="r_checked1_by" class="form-group row">
        <label id="elh_npd_desain_checked1_by" for="x_checked1_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_checked1_by"><?= $Page->checked1_by->caption() ?><?= $Page->checked1_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked1_by->cellAttributes() ?>>
<template id="tpx_npd_desain_checked1_by"><span id="el_npd_desain_checked1_by">
<input type="<?= $Page->checked1_by->getInputTextType() ?>" data-table="npd_desain" data-field="x_checked1_by" name="x_checked1_by" id="x_checked1_by" size="30" placeholder="<?= HtmlEncode($Page->checked1_by->getPlaceHolder()) ?>" value="<?= $Page->checked1_by->EditValue ?>"<?= $Page->checked1_by->editAttributes() ?> aria-describedby="x_checked1_by_help">
<?= $Page->checked1_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->checked1_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
    <div id="r_checked2_by" class="form-group row">
        <label id="elh_npd_desain_checked2_by" for="x_checked2_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_checked2_by"><?= $Page->checked2_by->caption() ?><?= $Page->checked2_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked2_by->cellAttributes() ?>>
<template id="tpx_npd_desain_checked2_by"><span id="el_npd_desain_checked2_by">
<input type="<?= $Page->checked2_by->getInputTextType() ?>" data-table="npd_desain" data-field="x_checked2_by" name="x_checked2_by" id="x_checked2_by" size="30" placeholder="<?= HtmlEncode($Page->checked2_by->getPlaceHolder()) ?>" value="<?= $Page->checked2_by->EditValue ?>"<?= $Page->checked2_by->editAttributes() ?> aria-describedby="x_checked2_by_help">
<?= $Page->checked2_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->checked2_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_npd_desain_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_approved_by"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_desain_approved_by"><span id="el_npd_desain_approved_by">
<input type="<?= $Page->approved_by->getInputTextType() ?>" data-table="npd_desain" data-field="x_approved_by" name="x_approved_by" id="x_approved_by" size="30" placeholder="<?= HtmlEncode($Page->approved_by->getPlaceHolder()) ?>" value="<?= $Page->approved_by->EditValue ?>"<?= $Page->approved_by->editAttributes() ?> aria-describedby="x_approved_by_help">
<?= $Page->approved_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->approved_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_npd_desain_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_created_at"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<template id="tpx_npd_desain_created_at"><span id="el_npd_desain_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="npd_desain" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desainedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desainedit", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_npd_desain_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_desain_updated_at"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_desain_updated_at"><span id="el_npd_desain_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="npd_desain" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_desainedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_desainedit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="npd_desain" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<div id="tpd_npd_desainedit" class="ew-custom-template"></div>
<template id="tpm_npd_desainedit">
<div id="ct_NpdDesainEdit"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_desain_idnpd"></slot></div>
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
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_tglterima"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglsubmit->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_tglsubmit"></slot></div>
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
                <label class="col-2 col-form-label text-right"><?= $Page->nama_produk->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_nama_produk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->klaim_bahan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_klaim_bahan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->campaign_produk->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_campaign_produk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->konsepwarna->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_konsepwarna"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->no_notifikasi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_no_notifikasi"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KONSEP DESAIN LABEL KEMASAN PRIMER</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jenis_kemasan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_jenis_kemasan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->posisi_label->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_posisi_label"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bahan_label->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_bahan_label"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->draft_layout->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_draft_layout"></slot></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KONSEP DESAIN LABEL KEMASAN SEKUNDER</div>
        </div>
        <div class="card-body">
            </div><div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->keterangan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_keterangan"></slot></div>
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
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_submitted_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked1_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_checked1_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked2_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_checked2_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->approved_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_desain_approved_by"></slot></div>
            </div>
        </div>
    </div>
</div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npd_desainedit", "tpm_npd_desainedit", "npd_desainedit", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("npd_desain");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
