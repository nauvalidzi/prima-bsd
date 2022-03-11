<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmsampleAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmsampleadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_confirmsampleadd = currentForm = new ew.Form("fnpd_confirmsampleadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_confirmsample")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_confirmsample)
        ew.vars.tables.npd_confirmsample = currentTable;
    fnpd_confirmsampleadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["tglkonfirmasi", [fields.tglkonfirmasi.visible && fields.tglkonfirmasi.required ? ew.Validators.required(fields.tglkonfirmasi.caption) : null, ew.Validators.datetime(0)], fields.tglkonfirmasi.isInvalid],
        ["idnpd_sample", [fields.idnpd_sample.visible && fields.idnpd_sample.required ? ew.Validators.required(fields.idnpd_sample.caption) : null], fields.idnpd_sample.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["bentuk", [fields.bentuk.visible && fields.bentuk.required ? ew.Validators.required(fields.bentuk.caption) : null], fields.bentuk.isInvalid],
        ["viskositas", [fields.viskositas.visible && fields.viskositas.required ? ew.Validators.required(fields.viskositas.caption) : null], fields.viskositas.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["bauparfum", [fields.bauparfum.visible && fields.bauparfum.required ? ew.Validators.required(fields.bauparfum.caption) : null], fields.bauparfum.isInvalid],
        ["aplikasisediaan", [fields.aplikasisediaan.visible && fields.aplikasisediaan.required ? ew.Validators.required(fields.aplikasisediaan.caption) : null], fields.aplikasisediaan.isInvalid],
        ["volume", [fields.volume.visible && fields.volume.required ? ew.Validators.required(fields.volume.caption) : null], fields.volume.isInvalid],
        ["campaign", [fields.campaign.visible && fields.campaign.required ? ew.Validators.required(fields.campaign.caption) : null], fields.campaign.isInvalid],
        ["alasansetuju", [fields.alasansetuju.visible && fields.alasansetuju.required ? ew.Validators.required(fields.alasansetuju.caption) : null], fields.alasansetuju.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["namapemesan", [fields.namapemesan.visible && fields.namapemesan.required ? ew.Validators.required(fields.namapemesan.caption) : null], fields.namapemesan.isInvalid],
        ["alamatpemesan", [fields.alamatpemesan.visible && fields.alamatpemesan.required ? ew.Validators.required(fields.alamatpemesan.caption) : null], fields.alamatpemesan.isInvalid],
        ["personincharge", [fields.personincharge.visible && fields.personincharge.required ? ew.Validators.required(fields.personincharge.caption) : null], fields.personincharge.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["notelp", [fields.notelp.visible && fields.notelp.required ? ew.Validators.required(fields.notelp.caption) : null], fields.notelp.isInvalid],
        ["receipt_by", [fields.receipt_by.visible && fields.receipt_by.required ? ew.Validators.required(fields.receipt_by.caption) : null], fields.receipt_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_confirmsampleadd,
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
    fnpd_confirmsampleadd.validate = function () {
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
    fnpd_confirmsampleadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_confirmsampleadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_confirmsampleadd.lists.idnpd = <?= $Page->idnpd->toClientList($Page) ?>;
    fnpd_confirmsampleadd.lists.idnpd_sample = <?= $Page->idnpd_sample->toClientList($Page) ?>;
    fnpd_confirmsampleadd.lists.bentuk = <?= $Page->bentuk->toClientList($Page) ?>;
    fnpd_confirmsampleadd.lists.viskositas = <?= $Page->viskositas->toClientList($Page) ?>;
    fnpd_confirmsampleadd.lists.warna = <?= $Page->warna->toClientList($Page) ?>;
    fnpd_confirmsampleadd.lists.bauparfum = <?= $Page->bauparfum->toClientList($Page) ?>;
    fnpd_confirmsampleadd.lists.aplikasisediaan = <?= $Page->aplikasisediaan->toClientList($Page) ?>;
    fnpd_confirmsampleadd.lists.receipt_by = <?= $Page->receipt_by->toClientList($Page) ?>;
    loadjs.done("fnpd_confirmsampleadd");
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
<form name="fnpd_confirmsampleadd" id="fnpd_confirmsampleadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmsample">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "npd") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_confirmsample_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_idnpd"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<?php if ($Page->idnpd->getSessionValue() != "") { ?>
<template id="tpx_npd_confirmsample_idnpd"><span id="el_npd_confirmsample_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnpd->getDisplayValue($Page->idnpd->ViewValue))) ?>"></span>
</span></template>
<input type="hidden" id="x_idnpd" name="x_idnpd" value="<?= HtmlEncode($Page->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<template id="tpx_npd_confirmsample_idnpd"><span id="el_npd_confirmsample_idnpd">
<?php $Page->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idnpd"
        name="x_idnpd"
        class="form-control ew-select<?= $Page->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_confirmsample_x_idnpd"
        data-table="npd_confirmsample"
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
    var el = document.querySelector("select[data-select2-id='npd_confirmsample_x_idnpd']"),
        options = { name: "x_idnpd", selectId: "npd_confirmsample_x_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmsample.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
    <div id="r_tglkonfirmasi" class="form-group row">
        <label id="elh_npd_confirmsample_tglkonfirmasi" for="x_tglkonfirmasi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_tglkonfirmasi"><?= $Page->tglkonfirmasi->caption() ?><?= $Page->tglkonfirmasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglkonfirmasi->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_tglkonfirmasi"><span id="el_npd_confirmsample_tglkonfirmasi">
<input type="<?= $Page->tglkonfirmasi->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_tglkonfirmasi" name="x_tglkonfirmasi" id="x_tglkonfirmasi" placeholder="<?= HtmlEncode($Page->tglkonfirmasi->getPlaceHolder()) ?>" value="<?= $Page->tglkonfirmasi->EditValue ?>"<?= $Page->tglkonfirmasi->editAttributes() ?> aria-describedby="x_tglkonfirmasi_help">
<?= $Page->tglkonfirmasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglkonfirmasi->getErrorMessage() ?></div>
<?php if (!$Page->tglkonfirmasi->ReadOnly && !$Page->tglkonfirmasi->Disabled && !isset($Page->tglkonfirmasi->EditAttrs["readonly"]) && !isset($Page->tglkonfirmasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_confirmsampleadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_confirmsampleadd", "x_tglkonfirmasi", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <div id="r_idnpd_sample" class="form-group row">
        <label id="elh_npd_confirmsample_idnpd_sample" for="x_idnpd_sample" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_idnpd_sample"><?= $Page->idnpd_sample->caption() ?><?= $Page->idnpd_sample->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd_sample->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_idnpd_sample"><span id="el_npd_confirmsample_idnpd_sample">
    <select
        id="x_idnpd_sample"
        name="x_idnpd_sample"
        class="form-control ew-select<?= $Page->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_confirmsample_x_idnpd_sample"
        data-table="npd_confirmsample"
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
    var el = document.querySelector("select[data-select2-id='npd_confirmsample_x_idnpd_sample']"),
        options = { name: "x_idnpd_sample", selectId: "npd_confirmsample_x_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmsample.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_npd_confirmsample_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_nama"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_nama"><span id="el_npd_confirmsample_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <div id="r_bentuk" class="form-group row">
        <label id="elh_npd_confirmsample_bentuk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_bentuk"><?= $Page->bentuk->caption() ?><?= $Page->bentuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuk->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_bentuk"><span id="el_npd_confirmsample_bentuk">
<template id="tp_x_bentuk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_confirmsample" data-field="x_bentuk" name="x_bentuk" id="x_bentuk"<?= $Page->bentuk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_bentuk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_bentuk"
    name="x_bentuk"
    value="<?= HtmlEncode($Page->bentuk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_bentuk"
    data-target="dsl_x_bentuk"
    data-repeatcolumn="4"
    class="form-control<?= $Page->bentuk->isInvalidClass() ?>"
    data-table="npd_confirmsample"
    data-field="x_bentuk"
    data-value-separator="<?= $Page->bentuk->displayValueSeparatorAttribute() ?>"
    <?= $Page->bentuk->editAttributes() ?>>
<?= $Page->bentuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuk->getErrorMessage() ?></div>
<?= $Page->bentuk->Lookup->getParamTag($Page, "p_x_bentuk") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <div id="r_viskositas" class="form-group row">
        <label id="elh_npd_confirmsample_viskositas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_viskositas"><?= $Page->viskositas->caption() ?><?= $Page->viskositas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositas->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_viskositas"><span id="el_npd_confirmsample_viskositas">
<template id="tp_x_viskositas">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_confirmsample" data-field="x_viskositas" name="x_viskositas" id="x_viskositas"<?= $Page->viskositas->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_viskositas" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_viskositas"
    name="x_viskositas"
    value="<?= HtmlEncode($Page->viskositas->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_viskositas"
    data-target="dsl_x_viskositas"
    data-repeatcolumn="4"
    class="form-control<?= $Page->viskositas->isInvalidClass() ?>"
    data-table="npd_confirmsample"
    data-field="x_viskositas"
    data-value-separator="<?= $Page->viskositas->displayValueSeparatorAttribute() ?>"
    <?= $Page->viskositas->editAttributes() ?>>
<?= $Page->viskositas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositas->getErrorMessage() ?></div>
<?= $Page->viskositas->Lookup->getParamTag($Page, "p_x_viskositas") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_npd_confirmsample_warna" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_warna"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_warna"><span id="el_npd_confirmsample_warna">
<template id="tp_x_warna">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_confirmsample" data-field="x_warna" name="x_warna" id="x_warna"<?= $Page->warna->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_warna" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_warna"
    name="x_warna"
    value="<?= HtmlEncode($Page->warna->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_warna"
    data-target="dsl_x_warna"
    data-repeatcolumn="4"
    class="form-control<?= $Page->warna->isInvalidClass() ?>"
    data-table="npd_confirmsample"
    data-field="x_warna"
    data-value-separator="<?= $Page->warna->displayValueSeparatorAttribute() ?>"
    <?= $Page->warna->editAttributes() ?>>
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
<?= $Page->warna->Lookup->getParamTag($Page, "p_x_warna") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bauparfum->Visible) { // bauparfum ?>
    <div id="r_bauparfum" class="form-group row">
        <label id="elh_npd_confirmsample_bauparfum" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_bauparfum"><?= $Page->bauparfum->caption() ?><?= $Page->bauparfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bauparfum->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_bauparfum"><span id="el_npd_confirmsample_bauparfum">
<template id="tp_x_bauparfum">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_confirmsample" data-field="x_bauparfum" name="x_bauparfum" id="x_bauparfum"<?= $Page->bauparfum->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_bauparfum" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_bauparfum"
    name="x_bauparfum"
    value="<?= HtmlEncode($Page->bauparfum->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_bauparfum"
    data-target="dsl_x_bauparfum"
    data-repeatcolumn="4"
    class="form-control<?= $Page->bauparfum->isInvalidClass() ?>"
    data-table="npd_confirmsample"
    data-field="x_bauparfum"
    data-value-separator="<?= $Page->bauparfum->displayValueSeparatorAttribute() ?>"
    <?= $Page->bauparfum->editAttributes() ?>>
<?= $Page->bauparfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bauparfum->getErrorMessage() ?></div>
<?= $Page->bauparfum->Lookup->getParamTag($Page, "p_x_bauparfum") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasisediaan->Visible) { // aplikasisediaan ?>
    <div id="r_aplikasisediaan" class="form-group row">
        <label id="elh_npd_confirmsample_aplikasisediaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_aplikasisediaan"><?= $Page->aplikasisediaan->caption() ?><?= $Page->aplikasisediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasisediaan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_aplikasisediaan"><span id="el_npd_confirmsample_aplikasisediaan">
<template id="tp_x_aplikasisediaan">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_confirmsample" data-field="x_aplikasisediaan" name="x_aplikasisediaan" id="x_aplikasisediaan"<?= $Page->aplikasisediaan->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aplikasisediaan" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aplikasisediaan"
    name="x_aplikasisediaan"
    value="<?= HtmlEncode($Page->aplikasisediaan->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_aplikasisediaan"
    data-target="dsl_x_aplikasisediaan"
    data-repeatcolumn="4"
    class="form-control<?= $Page->aplikasisediaan->isInvalidClass() ?>"
    data-table="npd_confirmsample"
    data-field="x_aplikasisediaan"
    data-value-separator="<?= $Page->aplikasisediaan->displayValueSeparatorAttribute() ?>"
    <?= $Page->aplikasisediaan->editAttributes() ?>>
<?= $Page->aplikasisediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasisediaan->getErrorMessage() ?></div>
<?= $Page->aplikasisediaan->Lookup->getParamTag($Page, "p_x_aplikasisediaan") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <div id="r_volume" class="form-group row">
        <label id="elh_npd_confirmsample_volume" for="x_volume" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_volume"><?= $Page->volume->caption() ?><?= $Page->volume->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->volume->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_volume"><span id="el_npd_confirmsample_volume">
<input type="<?= $Page->volume->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_volume" name="x_volume" id="x_volume" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->volume->getPlaceHolder()) ?>" value="<?= $Page->volume->EditValue ?>"<?= $Page->volume->editAttributes() ?> aria-describedby="x_volume_help">
<?= $Page->volume->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->volume->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->campaign->Visible) { // campaign ?>
    <div id="r_campaign" class="form-group row">
        <label id="elh_npd_confirmsample_campaign" for="x_campaign" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_campaign"><?= $Page->campaign->caption() ?><?= $Page->campaign->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->campaign->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_campaign"><span id="el_npd_confirmsample_campaign">
<input type="<?= $Page->campaign->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_campaign" name="x_campaign" id="x_campaign" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->campaign->getPlaceHolder()) ?>" value="<?= $Page->campaign->EditValue ?>"<?= $Page->campaign->editAttributes() ?> aria-describedby="x_campaign_help">
<?= $Page->campaign->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->campaign->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alasansetuju->Visible) { // alasansetuju ?>
    <div id="r_alasansetuju" class="form-group row">
        <label id="elh_npd_confirmsample_alasansetuju" for="x_alasansetuju" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_alasansetuju"><?= $Page->alasansetuju->caption() ?><?= $Page->alasansetuju->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alasansetuju->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_alasansetuju"><span id="el_npd_confirmsample_alasansetuju">
<textarea data-table="npd_confirmsample" data-field="x_alasansetuju" name="x_alasansetuju" id="x_alasansetuju" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->alasansetuju->getPlaceHolder()) ?>"<?= $Page->alasansetuju->editAttributes() ?> aria-describedby="x_alasansetuju_help"><?= $Page->alasansetuju->EditValue ?></textarea>
<?= $Page->alasansetuju->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alasansetuju->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_npd_confirmsample_foto" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_foto"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_foto"><span id="el_npd_confirmsample_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="npd_confirmsample" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>"<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
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
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
    <div id="r_namapemesan" class="form-group row">
        <label id="elh_npd_confirmsample_namapemesan" for="x_namapemesan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_namapemesan"><?= $Page->namapemesan->caption() ?><?= $Page->namapemesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namapemesan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_namapemesan"><span id="el_npd_confirmsample_namapemesan">
<input type="<?= $Page->namapemesan->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_namapemesan" name="x_namapemesan" id="x_namapemesan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->namapemesan->getPlaceHolder()) ?>" value="<?= $Page->namapemesan->EditValue ?>"<?= $Page->namapemesan->editAttributes() ?> aria-describedby="x_namapemesan_help">
<?= $Page->namapemesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namapemesan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamatpemesan->Visible) { // alamatpemesan ?>
    <div id="r_alamatpemesan" class="form-group row">
        <label id="elh_npd_confirmsample_alamatpemesan" for="x_alamatpemesan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_alamatpemesan"><?= $Page->alamatpemesan->caption() ?><?= $Page->alamatpemesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamatpemesan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_alamatpemesan"><span id="el_npd_confirmsample_alamatpemesan">
<input type="<?= $Page->alamatpemesan->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_alamatpemesan" name="x_alamatpemesan" id="x_alamatpemesan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamatpemesan->getPlaceHolder()) ?>" value="<?= $Page->alamatpemesan->EditValue ?>"<?= $Page->alamatpemesan->editAttributes() ?> aria-describedby="x_alamatpemesan_help">
<?= $Page->alamatpemesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamatpemesan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
    <div id="r_personincharge" class="form-group row">
        <label id="elh_npd_confirmsample_personincharge" for="x_personincharge" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_personincharge"><?= $Page->personincharge->caption() ?><?= $Page->personincharge->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->personincharge->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_personincharge"><span id="el_npd_confirmsample_personincharge">
<input type="<?= $Page->personincharge->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_personincharge" name="x_personincharge" id="x_personincharge" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->personincharge->getPlaceHolder()) ?>" value="<?= $Page->personincharge->EditValue ?>"<?= $Page->personincharge->editAttributes() ?> aria-describedby="x_personincharge_help">
<?= $Page->personincharge->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->personincharge->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_npd_confirmsample_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_jabatan"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_jabatan"><span id="el_npd_confirmsample_jabatan">
<input type="<?= $Page->jabatan->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jabatan->getPlaceHolder()) ?>" value="<?= $Page->jabatan->EditValue ?>"<?= $Page->jabatan->editAttributes() ?> aria-describedby="x_jabatan_help">
<?= $Page->jabatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
    <div id="r_notelp" class="form-group row">
        <label id="elh_npd_confirmsample_notelp" for="x_notelp" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_notelp"><?= $Page->notelp->caption() ?><?= $Page->notelp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->notelp->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_notelp"><span id="el_npd_confirmsample_notelp">
<input type="<?= $Page->notelp->getInputTextType() ?>" data-table="npd_confirmsample" data-field="x_notelp" name="x_notelp" id="x_notelp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->notelp->getPlaceHolder()) ?>" value="<?= $Page->notelp->EditValue ?>"<?= $Page->notelp->editAttributes() ?> aria-describedby="x_notelp_help">
<?= $Page->notelp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->notelp->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
    <div id="r_receipt_by" class="form-group row">
        <label id="elh_npd_confirmsample_receipt_by" for="x_receipt_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_confirmsample_receipt_by"><?= $Page->receipt_by->caption() ?><?= $Page->receipt_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->receipt_by->cellAttributes() ?>>
<template id="tpx_npd_confirmsample_receipt_by"><span id="el_npd_confirmsample_receipt_by">
    <select
        id="x_receipt_by"
        name="x_receipt_by"
        class="form-control ew-select<?= $Page->receipt_by->isInvalidClass() ?>"
        data-select2-id="npd_confirmsample_x_receipt_by"
        data-table="npd_confirmsample"
        data-field="x_receipt_by"
        data-value-separator="<?= $Page->receipt_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->receipt_by->getPlaceHolder()) ?>"
        <?= $Page->receipt_by->editAttributes() ?>>
        <?= $Page->receipt_by->selectOptionListHtml("x_receipt_by") ?>
    </select>
    <?= $Page->receipt_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->receipt_by->getErrorMessage() ?></div>
<?= $Page->receipt_by->Lookup->getParamTag($Page, "p_x_receipt_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_confirmsample_x_receipt_by']"),
        options = { name: "x_receipt_by", selectId: "npd_confirmsample_x_receipt_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_confirmsample.fields.receipt_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_npd_confirmsampleadd" class="ew-custom-template"></div>
<template id="tpm_npd_confirmsampleadd">
<div id="ct_NpdConfirmsampleAdd"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
            	<div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_confirmsample_idnpd"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right">Customer</label>
                    <div class="col-7"><input type="text" name="c_customer" id="c_customer" class="form-control" placeholder="Customer" disabled></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglkonfirmasi->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_tglkonfirmasi"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KONTEN (ISI SEDIAAN)</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->idnpd_sample->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_idnpd_sample"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->nama->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_nama"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Jenis Produk</label>
                <div class="col-8"><input type="text" name="c_jenisproduk" id="c_jenisproduk" class="form-control" placeholder="Jenis Produk" disabled></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bentuk->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_bentuk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->viskositas->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_viskositas"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->warna->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_warna"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bauparfum->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_bauparfum"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasisediaan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_aplikasisediaan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->volume->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_volume"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->campaign->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_campaign"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->alasansetuju->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_alasansetuju"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">SAMPEL PROTOTYPE</div>
        </div>
        <div class="card-body">
            <div id="c_bentuk_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->foto->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_foto"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">PEMESAN</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->namapemesan->caption() ?> <i data-phrase="FieldRequiredIndicator" class="fas fa-asterisk ew-required" data-caption=""></i></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_namapemesan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->alamatpemesan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_alamatpemesan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->personincharge->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_personincharge"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jabatan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_jabatan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->notelp->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_notelp"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KONFIRMASI FINAL SAMPEL</div>
        </div>
        <div class="card-body">
            <div class="callout callout-warning">Bersama formulir ini saya yang bertanda tangan dibawah ini mengkonfirmasi setuju untuk menggunakan <br>sampel prototype sesuai detail diatas ini untuk dijadikan acuan dalam produksi skala besar sesuai ketentuan <br>yang disepakati bersama dengan produsen (pabrik).</div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div id="c_bentuk_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->receipt_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_confirmsample_receipt_by"></slot></div>
            </div>
        </div>
    </div>
</div>
</div>
</template>
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
    ew.applyTemplate("tpd_npd_confirmsampleadd", "tpm_npd_confirmsampleadd", "npd_confirmsampleadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("npd_confirmsample");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("select[name=x_idnpd]").change((function(){$.ajax({url:"api/npd_customer/"+$(this).val(),type:"GET",success:function(a){!1!==a.success&&($("#c_jenisproduk").val(a.data.jenisproduk),$("#x_campaign").val(a.data.bahan_campaign),$("#c_customer").val(a.data.kodecustomer+", "+a.data.namacustomer),$("#x_namapemesan").val(a.data.namacustomer),$("#x_alamatpemesan").val(a.data.alamatcustomer),$("#x_jabatan").val(a.data.jabatancustomer),$("#x_notelp").val(a.data.telponcustomer))}})})),$("select[name=x_idnpd_sample]").change((function(){$.ajax({url:"api/view/npd_sample/"+$(this).val(),type:"GET",success:function(a){!1!==a.success&&($("#x_nama").val(a.npd_sample.nama),$(`input[data-field=x_bentuk][value=${a.npd_sample.sediaan}]`).prop("checked",!0),$(`input[x_viskositas=x_viskositas][value=${a.npd_sample.viskositas}]`).prop("checked",!0),$(`input[data-field=x_warna][value=${a.npd_sample.warna}]`).prop("checked",!0),$(`input[data-field=x_bauparfum][value=${a.npd_sample.bauparfum}]`).prop("checked",!0),$(`input[data-field=x_aplikasisediaan][value=${a.npd_sample.aplikasisediaan}]`).prop("checked",!0),$("#x_volume").val(a.npd_sample.volume))}})}));
});
</script>
