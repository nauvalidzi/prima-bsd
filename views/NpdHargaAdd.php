<?php

namespace PHPMaker2021\production2;

// Page object
$NpdHargaAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_hargaadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_hargaadd = currentForm = new ew.Form("fnpd_hargaadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_harga")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_harga)
        ew.vars.tables.npd_harga = currentTable;
    fnpd_hargaadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["tglpengajuan", [fields.tglpengajuan.visible && fields.tglpengajuan.required ? ew.Validators.required(fields.tglpengajuan.caption) : null, ew.Validators.datetime(0)], fields.tglpengajuan.isInvalid],
        ["idnpd_sample", [fields.idnpd_sample.visible && fields.idnpd_sample.required ? ew.Validators.required(fields.idnpd_sample.caption) : null], fields.idnpd_sample.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["bentuk", [fields.bentuk.visible && fields.bentuk.required ? ew.Validators.required(fields.bentuk.caption) : null], fields.bentuk.isInvalid],
        ["viskositas", [fields.viskositas.visible && fields.viskositas.required ? ew.Validators.required(fields.viskositas.caption) : null], fields.viskositas.isInvalid],
        ["aplikasisediaan", [fields.aplikasisediaan.visible && fields.aplikasisediaan.required ? ew.Validators.required(fields.aplikasisediaan.caption) : null], fields.aplikasisediaan.isInvalid],
        ["volume", [fields.volume.visible && fields.volume.required ? ew.Validators.required(fields.volume.caption) : null], fields.volume.isInvalid],
        ["bahanaktif", [fields.bahanaktif.visible && fields.bahanaktif.required ? ew.Validators.required(fields.bahanaktif.caption) : null], fields.bahanaktif.isInvalid],
        ["volumewadah", [fields.volumewadah.visible && fields.volumewadah.required ? ew.Validators.required(fields.volumewadah.caption) : null], fields.volumewadah.isInvalid],
        ["bahanwadah", [fields.bahanwadah.visible && fields.bahanwadah.required ? ew.Validators.required(fields.bahanwadah.caption) : null], fields.bahanwadah.isInvalid],
        ["warnawadah", [fields.warnawadah.visible && fields.warnawadah.required ? ew.Validators.required(fields.warnawadah.caption) : null], fields.warnawadah.isInvalid],
        ["bentukwadah", [fields.bentukwadah.visible && fields.bentukwadah.required ? ew.Validators.required(fields.bentukwadah.caption) : null], fields.bentukwadah.isInvalid],
        ["jenistutup", [fields.jenistutup.visible && fields.jenistutup.required ? ew.Validators.required(fields.jenistutup.caption) : null], fields.jenistutup.isInvalid],
        ["bahantutup", [fields.bahantutup.visible && fields.bahantutup.required ? ew.Validators.required(fields.bahantutup.caption) : null], fields.bahantutup.isInvalid],
        ["warnatutup", [fields.warnatutup.visible && fields.warnatutup.required ? ew.Validators.required(fields.warnatutup.caption) : null], fields.warnatutup.isInvalid],
        ["bentuktutup", [fields.bentuktutup.visible && fields.bentuktutup.required ? ew.Validators.required(fields.bentuktutup.caption) : null], fields.bentuktutup.isInvalid],
        ["segel", [fields.segel.visible && fields.segel.required ? ew.Validators.required(fields.segel.caption) : null], fields.segel.isInvalid],
        ["catatanprimer", [fields.catatanprimer.visible && fields.catatanprimer.required ? ew.Validators.required(fields.catatanprimer.caption) : null], fields.catatanprimer.isInvalid],
        ["packingproduk", [fields.packingproduk.visible && fields.packingproduk.required ? ew.Validators.required(fields.packingproduk.caption) : null], fields.packingproduk.isInvalid],
        ["keteranganpacking", [fields.keteranganpacking.visible && fields.keteranganpacking.required ? ew.Validators.required(fields.keteranganpacking.caption) : null], fields.keteranganpacking.isInvalid],
        ["beltkarton", [fields.beltkarton.visible && fields.beltkarton.required ? ew.Validators.required(fields.beltkarton.caption) : null], fields.beltkarton.isInvalid],
        ["keteranganbelt", [fields.keteranganbelt.visible && fields.keteranganbelt.required ? ew.Validators.required(fields.keteranganbelt.caption) : null], fields.keteranganbelt.isInvalid],
        ["kartonluar", [fields.kartonluar.visible && fields.kartonluar.required ? ew.Validators.required(fields.kartonluar.caption) : null], fields.kartonluar.isInvalid],
        ["bariskarton", [fields.bariskarton.visible && fields.bariskarton.required ? ew.Validators.required(fields.bariskarton.caption) : null], fields.bariskarton.isInvalid],
        ["kolomkarton", [fields.kolomkarton.visible && fields.kolomkarton.required ? ew.Validators.required(fields.kolomkarton.caption) : null], fields.kolomkarton.isInvalid],
        ["stackkarton", [fields.stackkarton.visible && fields.stackkarton.required ? ew.Validators.required(fields.stackkarton.caption) : null], fields.stackkarton.isInvalid],
        ["isikarton", [fields.isikarton.visible && fields.isikarton.required ? ew.Validators.required(fields.isikarton.caption) : null], fields.isikarton.isInvalid],
        ["jenislabel", [fields.jenislabel.visible && fields.jenislabel.required ? ew.Validators.required(fields.jenislabel.caption) : null], fields.jenislabel.isInvalid],
        ["keteranganjenislabel", [fields.keteranganjenislabel.visible && fields.keteranganjenislabel.required ? ew.Validators.required(fields.keteranganjenislabel.caption) : null], fields.keteranganjenislabel.isInvalid],
        ["kualitaslabel", [fields.kualitaslabel.visible && fields.kualitaslabel.required ? ew.Validators.required(fields.kualitaslabel.caption) : null], fields.kualitaslabel.isInvalid],
        ["jumlahwarnalabel", [fields.jumlahwarnalabel.visible && fields.jumlahwarnalabel.required ? ew.Validators.required(fields.jumlahwarnalabel.caption) : null], fields.jumlahwarnalabel.isInvalid],
        ["metaliklabel", [fields.metaliklabel.visible && fields.metaliklabel.required ? ew.Validators.required(fields.metaliklabel.caption) : null], fields.metaliklabel.isInvalid],
        ["etiketlabel", [fields.etiketlabel.visible && fields.etiketlabel.required ? ew.Validators.required(fields.etiketlabel.caption) : null], fields.etiketlabel.isInvalid],
        ["keteranganlabel", [fields.keteranganlabel.visible && fields.keteranganlabel.required ? ew.Validators.required(fields.keteranganlabel.caption) : null], fields.keteranganlabel.isInvalid],
        ["kategoridelivery", [fields.kategoridelivery.visible && fields.kategoridelivery.required ? ew.Validators.required(fields.kategoridelivery.caption) : null], fields.kategoridelivery.isInvalid],
        ["alamatpengiriman", [fields.alamatpengiriman.visible && fields.alamatpengiriman.required ? ew.Validators.required(fields.alamatpengiriman.caption) : null], fields.alamatpengiriman.isInvalid],
        ["orderperdana", [fields.orderperdana.visible && fields.orderperdana.required ? ew.Validators.required(fields.orderperdana.caption) : null, ew.Validators.integer], fields.orderperdana.isInvalid],
        ["orderkontrak", [fields.orderkontrak.visible && fields.orderkontrak.required ? ew.Validators.required(fields.orderkontrak.caption) : null, ew.Validators.integer], fields.orderkontrak.isInvalid],
        ["hargaperpcs", [fields.hargaperpcs.visible && fields.hargaperpcs.required ? ew.Validators.required(fields.hargaperpcs.caption) : null, ew.Validators.integer], fields.hargaperpcs.isInvalid],
        ["hargaperkarton", [fields.hargaperkarton.visible && fields.hargaperkarton.required ? ew.Validators.required(fields.hargaperkarton.caption) : null, ew.Validators.integer], fields.hargaperkarton.isInvalid],
        ["lampiran", [fields.lampiran.visible && fields.lampiran.required ? ew.Validators.fileRequired(fields.lampiran.caption) : null], fields.lampiran.isInvalid],
        ["prepared_by", [fields.prepared_by.visible && fields.prepared_by.required ? ew.Validators.required(fields.prepared_by.caption) : null, ew.Validators.integer], fields.prepared_by.isInvalid],
        ["checked_by", [fields.checked_by.visible && fields.checked_by.required ? ew.Validators.required(fields.checked_by.caption) : null, ew.Validators.integer], fields.checked_by.isInvalid],
        ["approved_by", [fields.approved_by.visible && fields.approved_by.required ? ew.Validators.required(fields.approved_by.caption) : null, ew.Validators.integer], fields.approved_by.isInvalid],
        ["disetujui", [fields.disetujui.visible && fields.disetujui.required ? ew.Validators.required(fields.disetujui.caption) : null], fields.disetujui.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_hargaadd,
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
    fnpd_hargaadd.validate = function () {
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
    fnpd_hargaadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_hargaadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_hargaadd.lists.idnpd = <?= $Page->idnpd->toClientList($Page) ?>;
    fnpd_hargaadd.lists.idnpd_sample = <?= $Page->idnpd_sample->toClientList($Page) ?>;
    fnpd_hargaadd.lists.segel = <?= $Page->segel->toClientList($Page) ?>;
    fnpd_hargaadd.lists.disetujui = <?= $Page->disetujui->toClientList($Page) ?>;
    loadjs.done("fnpd_hargaadd");
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
<form name="fnpd_hargaadd" id="fnpd_hargaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_harga">
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
        <label id="elh_npd_harga_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_idnpd"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<?php if ($Page->idnpd->getSessionValue() != "") { ?>
<template id="tpx_npd_harga_idnpd"><span id="el_npd_harga_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnpd->getDisplayValue($Page->idnpd->ViewValue))) ?>"></span>
</span></template>
<input type="hidden" id="x_idnpd" name="x_idnpd" value="<?= HtmlEncode($Page->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<template id="tpx_npd_harga_idnpd"><span id="el_npd_harga_idnpd">
<?php $Page->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idnpd"
        name="x_idnpd"
        class="form-control ew-select<?= $Page->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_harga_x_idnpd"
        data-table="npd_harga"
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
    var el = document.querySelector("select[data-select2-id='npd_harga_x_idnpd']"),
        options = { name: "x_idnpd", selectId: "npd_harga_x_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
    <div id="r_tglpengajuan" class="form-group row">
        <label id="elh_npd_harga_tglpengajuan" for="x_tglpengajuan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_tglpengajuan"><?= $Page->tglpengajuan->caption() ?><?= $Page->tglpengajuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglpengajuan->cellAttributes() ?>>
<template id="tpx_npd_harga_tglpengajuan"><span id="el_npd_harga_tglpengajuan">
<input type="<?= $Page->tglpengajuan->getInputTextType() ?>" data-table="npd_harga" data-field="x_tglpengajuan" name="x_tglpengajuan" id="x_tglpengajuan" placeholder="<?= HtmlEncode($Page->tglpengajuan->getPlaceHolder()) ?>" value="<?= $Page->tglpengajuan->EditValue ?>"<?= $Page->tglpengajuan->editAttributes() ?> aria-describedby="x_tglpengajuan_help">
<?= $Page->tglpengajuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglpengajuan->getErrorMessage() ?></div>
<?php if (!$Page->tglpengajuan->ReadOnly && !$Page->tglpengajuan->Disabled && !isset($Page->tglpengajuan->EditAttrs["readonly"]) && !isset($Page->tglpengajuan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_hargaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_hargaadd", "x_tglpengajuan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <div id="r_idnpd_sample" class="form-group row">
        <label id="elh_npd_harga_idnpd_sample" for="x_idnpd_sample" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_idnpd_sample"><?= $Page->idnpd_sample->caption() ?><?= $Page->idnpd_sample->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd_sample->cellAttributes() ?>>
<template id="tpx_npd_harga_idnpd_sample"><span id="el_npd_harga_idnpd_sample">
<?php $Page->idnpd_sample->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_idnpd_sample"
        name="x_idnpd_sample"
        class="form-control ew-select<?= $Page->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_harga_x_idnpd_sample"
        data-table="npd_harga"
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
    var el = document.querySelector("select[data-select2-id='npd_harga_x_idnpd_sample']"),
        options = { name: "x_idnpd_sample", selectId: "npd_harga_x_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_harga.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_npd_harga_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_nama"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<template id="tpx_npd_harga_nama"><span id="el_npd_harga_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="npd_harga" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <div id="r_bentuk" class="form-group row">
        <label id="elh_npd_harga_bentuk" for="x_bentuk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_bentuk"><?= $Page->bentuk->caption() ?><?= $Page->bentuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuk->cellAttributes() ?>>
<template id="tpx_npd_harga_bentuk"><span id="el_npd_harga_bentuk">
<input type="<?= $Page->bentuk->getInputTextType() ?>" data-table="npd_harga" data-field="x_bentuk" name="x_bentuk" id="x_bentuk" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bentuk->getPlaceHolder()) ?>" value="<?= $Page->bentuk->EditValue ?>"<?= $Page->bentuk->editAttributes() ?> aria-describedby="x_bentuk_help">
<?= $Page->bentuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <div id="r_viskositas" class="form-group row">
        <label id="elh_npd_harga_viskositas" for="x_viskositas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_viskositas"><?= $Page->viskositas->caption() ?><?= $Page->viskositas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositas->cellAttributes() ?>>
<template id="tpx_npd_harga_viskositas"><span id="el_npd_harga_viskositas">
<input type="<?= $Page->viskositas->getInputTextType() ?>" data-table="npd_harga" data-field="x_viskositas" name="x_viskositas" id="x_viskositas" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->viskositas->getPlaceHolder()) ?>" value="<?= $Page->viskositas->EditValue ?>"<?= $Page->viskositas->editAttributes() ?> aria-describedby="x_viskositas_help">
<?= $Page->viskositas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositas->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasisediaan->Visible) { // aplikasisediaan ?>
    <div id="r_aplikasisediaan" class="form-group row">
        <label id="elh_npd_harga_aplikasisediaan" for="x_aplikasisediaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_aplikasisediaan"><?= $Page->aplikasisediaan->caption() ?><?= $Page->aplikasisediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasisediaan->cellAttributes() ?>>
<template id="tpx_npd_harga_aplikasisediaan"><span id="el_npd_harga_aplikasisediaan">
<input type="<?= $Page->aplikasisediaan->getInputTextType() ?>" data-table="npd_harga" data-field="x_aplikasisediaan" name="x_aplikasisediaan" id="x_aplikasisediaan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->aplikasisediaan->getPlaceHolder()) ?>" value="<?= $Page->aplikasisediaan->EditValue ?>"<?= $Page->aplikasisediaan->editAttributes() ?> aria-describedby="x_aplikasisediaan_help">
<?= $Page->aplikasisediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasisediaan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <div id="r_volume" class="form-group row">
        <label id="elh_npd_harga_volume" for="x_volume" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_volume"><?= $Page->volume->caption() ?><?= $Page->volume->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->volume->cellAttributes() ?>>
<template id="tpx_npd_harga_volume"><span id="el_npd_harga_volume">
<input type="<?= $Page->volume->getInputTextType() ?>" data-table="npd_harga" data-field="x_volume" name="x_volume" id="x_volume" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->volume->getPlaceHolder()) ?>" value="<?= $Page->volume->EditValue ?>"<?= $Page->volume->editAttributes() ?> aria-describedby="x_volume_help">
<?= $Page->volume->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->volume->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <div id="r_bahanaktif" class="form-group row">
        <label id="elh_npd_harga_bahanaktif" for="x_bahanaktif" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_bahanaktif"><?= $Page->bahanaktif->caption() ?><?= $Page->bahanaktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahanaktif->cellAttributes() ?>>
<template id="tpx_npd_harga_bahanaktif"><span id="el_npd_harga_bahanaktif">
<textarea data-table="npd_harga" data-field="x_bahanaktif" name="x_bahanaktif" id="x_bahanaktif" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bahanaktif->getPlaceHolder()) ?>"<?= $Page->bahanaktif->editAttributes() ?> aria-describedby="x_bahanaktif_help"><?= $Page->bahanaktif->EditValue ?></textarea>
<?= $Page->bahanaktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahanaktif->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->volumewadah->Visible) { // volumewadah ?>
    <div id="r_volumewadah" class="form-group row">
        <label id="elh_npd_harga_volumewadah" for="x_volumewadah" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_volumewadah"><?= $Page->volumewadah->caption() ?><?= $Page->volumewadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->volumewadah->cellAttributes() ?>>
<template id="tpx_npd_harga_volumewadah"><span id="el_npd_harga_volumewadah">
<input type="<?= $Page->volumewadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_volumewadah" name="x_volumewadah" id="x_volumewadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->volumewadah->getPlaceHolder()) ?>" value="<?= $Page->volumewadah->EditValue ?>"<?= $Page->volumewadah->editAttributes() ?> aria-describedby="x_volumewadah_help">
<?= $Page->volumewadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->volumewadah->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahanwadah->Visible) { // bahanwadah ?>
    <div id="r_bahanwadah" class="form-group row">
        <label id="elh_npd_harga_bahanwadah" for="x_bahanwadah" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_bahanwadah"><?= $Page->bahanwadah->caption() ?><?= $Page->bahanwadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahanwadah->cellAttributes() ?>>
<template id="tpx_npd_harga_bahanwadah"><span id="el_npd_harga_bahanwadah">
<input type="<?= $Page->bahanwadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_bahanwadah" name="x_bahanwadah" id="x_bahanwadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahanwadah->getPlaceHolder()) ?>" value="<?= $Page->bahanwadah->EditValue ?>"<?= $Page->bahanwadah->editAttributes() ?> aria-describedby="x_bahanwadah_help">
<?= $Page->bahanwadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahanwadah->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warnawadah->Visible) { // warnawadah ?>
    <div id="r_warnawadah" class="form-group row">
        <label id="elh_npd_harga_warnawadah" for="x_warnawadah" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_warnawadah"><?= $Page->warnawadah->caption() ?><?= $Page->warnawadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warnawadah->cellAttributes() ?>>
<template id="tpx_npd_harga_warnawadah"><span id="el_npd_harga_warnawadah">
<input type="<?= $Page->warnawadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_warnawadah" name="x_warnawadah" id="x_warnawadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warnawadah->getPlaceHolder()) ?>" value="<?= $Page->warnawadah->EditValue ?>"<?= $Page->warnawadah->editAttributes() ?> aria-describedby="x_warnawadah_help">
<?= $Page->warnawadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warnawadah->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentukwadah->Visible) { // bentukwadah ?>
    <div id="r_bentukwadah" class="form-group row">
        <label id="elh_npd_harga_bentukwadah" for="x_bentukwadah" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_bentukwadah"><?= $Page->bentukwadah->caption() ?><?= $Page->bentukwadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentukwadah->cellAttributes() ?>>
<template id="tpx_npd_harga_bentukwadah"><span id="el_npd_harga_bentukwadah">
<input type="<?= $Page->bentukwadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_bentukwadah" name="x_bentukwadah" id="x_bentukwadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bentukwadah->getPlaceHolder()) ?>" value="<?= $Page->bentukwadah->EditValue ?>"<?= $Page->bentukwadah->editAttributes() ?> aria-describedby="x_bentukwadah_help">
<?= $Page->bentukwadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentukwadah->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
    <div id="r_jenistutup" class="form-group row">
        <label id="elh_npd_harga_jenistutup" for="x_jenistutup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_jenistutup"><?= $Page->jenistutup->caption() ?><?= $Page->jenistutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenistutup->cellAttributes() ?>>
<template id="tpx_npd_harga_jenistutup"><span id="el_npd_harga_jenistutup">
<input type="<?= $Page->jenistutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_jenistutup" name="x_jenistutup" id="x_jenistutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->jenistutup->getPlaceHolder()) ?>" value="<?= $Page->jenistutup->EditValue ?>"<?= $Page->jenistutup->editAttributes() ?> aria-describedby="x_jenistutup_help">
<?= $Page->jenistutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenistutup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahantutup->Visible) { // bahantutup ?>
    <div id="r_bahantutup" class="form-group row">
        <label id="elh_npd_harga_bahantutup" for="x_bahantutup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_bahantutup"><?= $Page->bahantutup->caption() ?><?= $Page->bahantutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahantutup->cellAttributes() ?>>
<template id="tpx_npd_harga_bahantutup"><span id="el_npd_harga_bahantutup">
<input type="<?= $Page->bahantutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_bahantutup" name="x_bahantutup" id="x_bahantutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahantutup->getPlaceHolder()) ?>" value="<?= $Page->bahantutup->EditValue ?>"<?= $Page->bahantutup->editAttributes() ?> aria-describedby="x_bahantutup_help">
<?= $Page->bahantutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahantutup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warnatutup->Visible) { // warnatutup ?>
    <div id="r_warnatutup" class="form-group row">
        <label id="elh_npd_harga_warnatutup" for="x_warnatutup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_warnatutup"><?= $Page->warnatutup->caption() ?><?= $Page->warnatutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warnatutup->cellAttributes() ?>>
<template id="tpx_npd_harga_warnatutup"><span id="el_npd_harga_warnatutup">
<input type="<?= $Page->warnatutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_warnatutup" name="x_warnatutup" id="x_warnatutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warnatutup->getPlaceHolder()) ?>" value="<?= $Page->warnatutup->EditValue ?>"<?= $Page->warnatutup->editAttributes() ?> aria-describedby="x_warnatutup_help">
<?= $Page->warnatutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warnatutup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuktutup->Visible) { // bentuktutup ?>
    <div id="r_bentuktutup" class="form-group row">
        <label id="elh_npd_harga_bentuktutup" for="x_bentuktutup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_bentuktutup"><?= $Page->bentuktutup->caption() ?><?= $Page->bentuktutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuktutup->cellAttributes() ?>>
<template id="tpx_npd_harga_bentuktutup"><span id="el_npd_harga_bentuktutup">
<input type="<?= $Page->bentuktutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_bentuktutup" name="x_bentuktutup" id="x_bentuktutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bentuktutup->getPlaceHolder()) ?>" value="<?= $Page->bentuktutup->EditValue ?>"<?= $Page->bentuktutup->editAttributes() ?> aria-describedby="x_bentuktutup_help">
<?= $Page->bentuktutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuktutup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->segel->Visible) { // segel ?>
    <div id="r_segel" class="form-group row">
        <label id="elh_npd_harga_segel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_segel"><?= $Page->segel->caption() ?><?= $Page->segel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->segel->cellAttributes() ?>>
<template id="tpx_npd_harga_segel"><span id="el_npd_harga_segel">
<template id="tp_x_segel">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_harga" data-field="x_segel" name="x_segel" id="x_segel"<?= $Page->segel->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_segel" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_segel"
    name="x_segel"
    value="<?= HtmlEncode($Page->segel->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_segel"
    data-target="dsl_x_segel"
    data-repeatcolumn="5"
    class="form-control<?= $Page->segel->isInvalidClass() ?>"
    data-table="npd_harga"
    data-field="x_segel"
    data-value-separator="<?= $Page->segel->displayValueSeparatorAttribute() ?>"
    <?= $Page->segel->editAttributes() ?>>
<?= $Page->segel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->segel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatanprimer->Visible) { // catatanprimer ?>
    <div id="r_catatanprimer" class="form-group row">
        <label id="elh_npd_harga_catatanprimer" for="x_catatanprimer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_catatanprimer"><?= $Page->catatanprimer->caption() ?><?= $Page->catatanprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatanprimer->cellAttributes() ?>>
<template id="tpx_npd_harga_catatanprimer"><span id="el_npd_harga_catatanprimer">
<textarea data-table="npd_harga" data-field="x_catatanprimer" name="x_catatanprimer" id="x_catatanprimer" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatanprimer->getPlaceHolder()) ?>"<?= $Page->catatanprimer->editAttributes() ?> aria-describedby="x_catatanprimer_help"><?= $Page->catatanprimer->EditValue ?></textarea>
<?= $Page->catatanprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatanprimer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->packingproduk->Visible) { // packingproduk ?>
    <div id="r_packingproduk" class="form-group row">
        <label id="elh_npd_harga_packingproduk" for="x_packingproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_packingproduk"><?= $Page->packingproduk->caption() ?><?= $Page->packingproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->packingproduk->cellAttributes() ?>>
<template id="tpx_npd_harga_packingproduk"><span id="el_npd_harga_packingproduk">
<input type="<?= $Page->packingproduk->getInputTextType() ?>" data-table="npd_harga" data-field="x_packingproduk" name="x_packingproduk" id="x_packingproduk" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->packingproduk->getPlaceHolder()) ?>" value="<?= $Page->packingproduk->EditValue ?>"<?= $Page->packingproduk->editAttributes() ?> aria-describedby="x_packingproduk_help">
<?= $Page->packingproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->packingproduk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganpacking->Visible) { // keteranganpacking ?>
    <div id="r_keteranganpacking" class="form-group row">
        <label id="elh_npd_harga_keteranganpacking" for="x_keteranganpacking" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_keteranganpacking"><?= $Page->keteranganpacking->caption() ?><?= $Page->keteranganpacking->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganpacking->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganpacking"><span id="el_npd_harga_keteranganpacking">
<textarea data-table="npd_harga" data-field="x_keteranganpacking" name="x_keteranganpacking" id="x_keteranganpacking" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganpacking->getPlaceHolder()) ?>"<?= $Page->keteranganpacking->editAttributes() ?> aria-describedby="x_keteranganpacking_help"><?= $Page->keteranganpacking->EditValue ?></textarea>
<?= $Page->keteranganpacking->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganpacking->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->beltkarton->Visible) { // beltkarton ?>
    <div id="r_beltkarton" class="form-group row">
        <label id="elh_npd_harga_beltkarton" for="x_beltkarton" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_beltkarton"><?= $Page->beltkarton->caption() ?><?= $Page->beltkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->beltkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_beltkarton"><span id="el_npd_harga_beltkarton">
<input type="<?= $Page->beltkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_beltkarton" name="x_beltkarton" id="x_beltkarton" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->beltkarton->getPlaceHolder()) ?>" value="<?= $Page->beltkarton->EditValue ?>"<?= $Page->beltkarton->editAttributes() ?> aria-describedby="x_beltkarton_help">
<?= $Page->beltkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->beltkarton->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganbelt->Visible) { // keteranganbelt ?>
    <div id="r_keteranganbelt" class="form-group row">
        <label id="elh_npd_harga_keteranganbelt" for="x_keteranganbelt" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_keteranganbelt"><?= $Page->keteranganbelt->caption() ?><?= $Page->keteranganbelt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganbelt->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganbelt"><span id="el_npd_harga_keteranganbelt">
<textarea data-table="npd_harga" data-field="x_keteranganbelt" name="x_keteranganbelt" id="x_keteranganbelt" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganbelt->getPlaceHolder()) ?>"<?= $Page->keteranganbelt->editAttributes() ?> aria-describedby="x_keteranganbelt_help"><?= $Page->keteranganbelt->EditValue ?></textarea>
<?= $Page->keteranganbelt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganbelt->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kartonluar->Visible) { // kartonluar ?>
    <div id="r_kartonluar" class="form-group row">
        <label id="elh_npd_harga_kartonluar" for="x_kartonluar" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_kartonluar"><?= $Page->kartonluar->caption() ?><?= $Page->kartonluar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kartonluar->cellAttributes() ?>>
<template id="tpx_npd_harga_kartonluar"><span id="el_npd_harga_kartonluar">
<input type="<?= $Page->kartonluar->getInputTextType() ?>" data-table="npd_harga" data-field="x_kartonluar" name="x_kartonluar" id="x_kartonluar" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kartonluar->getPlaceHolder()) ?>" value="<?= $Page->kartonluar->EditValue ?>"<?= $Page->kartonluar->editAttributes() ?> aria-describedby="x_kartonluar_help">
<?= $Page->kartonluar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kartonluar->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bariskarton->Visible) { // bariskarton ?>
    <div id="r_bariskarton" class="form-group row">
        <label id="elh_npd_harga_bariskarton" for="x_bariskarton" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_bariskarton"><?= $Page->bariskarton->caption() ?><?= $Page->bariskarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bariskarton->cellAttributes() ?>>
<template id="tpx_npd_harga_bariskarton"><span id="el_npd_harga_bariskarton">
<input type="<?= $Page->bariskarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_bariskarton" name="x_bariskarton" id="x_bariskarton" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->bariskarton->getPlaceHolder()) ?>" value="<?= $Page->bariskarton->EditValue ?>"<?= $Page->bariskarton->editAttributes() ?> aria-describedby="x_bariskarton_help">
<?= $Page->bariskarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bariskarton->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kolomkarton->Visible) { // kolomkarton ?>
    <div id="r_kolomkarton" class="form-group row">
        <label id="elh_npd_harga_kolomkarton" for="x_kolomkarton" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_kolomkarton"><?= $Page->kolomkarton->caption() ?><?= $Page->kolomkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kolomkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_kolomkarton"><span id="el_npd_harga_kolomkarton">
<input type="<?= $Page->kolomkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_kolomkarton" name="x_kolomkarton" id="x_kolomkarton" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kolomkarton->getPlaceHolder()) ?>" value="<?= $Page->kolomkarton->EditValue ?>"<?= $Page->kolomkarton->editAttributes() ?> aria-describedby="x_kolomkarton_help">
<?= $Page->kolomkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kolomkarton->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->stackkarton->Visible) { // stackkarton ?>
    <div id="r_stackkarton" class="form-group row">
        <label id="elh_npd_harga_stackkarton" for="x_stackkarton" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_stackkarton"><?= $Page->stackkarton->caption() ?><?= $Page->stackkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->stackkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_stackkarton"><span id="el_npd_harga_stackkarton">
<input type="<?= $Page->stackkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_stackkarton" name="x_stackkarton" id="x_stackkarton" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->stackkarton->getPlaceHolder()) ?>" value="<?= $Page->stackkarton->EditValue ?>"<?= $Page->stackkarton->editAttributes() ?> aria-describedby="x_stackkarton_help">
<?= $Page->stackkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->stackkarton->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isikarton->Visible) { // isikarton ?>
    <div id="r_isikarton" class="form-group row">
        <label id="elh_npd_harga_isikarton" for="x_isikarton" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_isikarton"><?= $Page->isikarton->caption() ?><?= $Page->isikarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isikarton->cellAttributes() ?>>
<template id="tpx_npd_harga_isikarton"><span id="el_npd_harga_isikarton">
<input type="<?= $Page->isikarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_isikarton" name="x_isikarton" id="x_isikarton" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->isikarton->getPlaceHolder()) ?>" value="<?= $Page->isikarton->EditValue ?>"<?= $Page->isikarton->editAttributes() ?> aria-describedby="x_isikarton_help">
<?= $Page->isikarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isikarton->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenislabel->Visible) { // jenislabel ?>
    <div id="r_jenislabel" class="form-group row">
        <label id="elh_npd_harga_jenislabel" for="x_jenislabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_jenislabel"><?= $Page->jenislabel->caption() ?><?= $Page->jenislabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenislabel->cellAttributes() ?>>
<template id="tpx_npd_harga_jenislabel"><span id="el_npd_harga_jenislabel">
<input type="<?= $Page->jenislabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_jenislabel" name="x_jenislabel" id="x_jenislabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jenislabel->getPlaceHolder()) ?>" value="<?= $Page->jenislabel->EditValue ?>"<?= $Page->jenislabel->editAttributes() ?> aria-describedby="x_jenislabel_help">
<?= $Page->jenislabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenislabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganjenislabel->Visible) { // keteranganjenislabel ?>
    <div id="r_keteranganjenislabel" class="form-group row">
        <label id="elh_npd_harga_keteranganjenislabel" for="x_keteranganjenislabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_keteranganjenislabel"><?= $Page->keteranganjenislabel->caption() ?><?= $Page->keteranganjenislabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganjenislabel->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganjenislabel"><span id="el_npd_harga_keteranganjenislabel">
<textarea data-table="npd_harga" data-field="x_keteranganjenislabel" name="x_keteranganjenislabel" id="x_keteranganjenislabel" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganjenislabel->getPlaceHolder()) ?>"<?= $Page->keteranganjenislabel->editAttributes() ?> aria-describedby="x_keteranganjenislabel_help"><?= $Page->keteranganjenislabel->EditValue ?></textarea>
<?= $Page->keteranganjenislabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganjenislabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kualitaslabel->Visible) { // kualitaslabel ?>
    <div id="r_kualitaslabel" class="form-group row">
        <label id="elh_npd_harga_kualitaslabel" for="x_kualitaslabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_kualitaslabel"><?= $Page->kualitaslabel->caption() ?><?= $Page->kualitaslabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kualitaslabel->cellAttributes() ?>>
<template id="tpx_npd_harga_kualitaslabel"><span id="el_npd_harga_kualitaslabel">
<input type="<?= $Page->kualitaslabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_kualitaslabel" name="x_kualitaslabel" id="x_kualitaslabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kualitaslabel->getPlaceHolder()) ?>" value="<?= $Page->kualitaslabel->EditValue ?>"<?= $Page->kualitaslabel->editAttributes() ?> aria-describedby="x_kualitaslabel_help">
<?= $Page->kualitaslabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kualitaslabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahwarnalabel->Visible) { // jumlahwarnalabel ?>
    <div id="r_jumlahwarnalabel" class="form-group row">
        <label id="elh_npd_harga_jumlahwarnalabel" for="x_jumlahwarnalabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_jumlahwarnalabel"><?= $Page->jumlahwarnalabel->caption() ?><?= $Page->jumlahwarnalabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahwarnalabel->cellAttributes() ?>>
<template id="tpx_npd_harga_jumlahwarnalabel"><span id="el_npd_harga_jumlahwarnalabel">
<input type="<?= $Page->jumlahwarnalabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_jumlahwarnalabel" name="x_jumlahwarnalabel" id="x_jumlahwarnalabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jumlahwarnalabel->getPlaceHolder()) ?>" value="<?= $Page->jumlahwarnalabel->EditValue ?>"<?= $Page->jumlahwarnalabel->editAttributes() ?> aria-describedby="x_jumlahwarnalabel_help">
<?= $Page->jumlahwarnalabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahwarnalabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->metaliklabel->Visible) { // metaliklabel ?>
    <div id="r_metaliklabel" class="form-group row">
        <label id="elh_npd_harga_metaliklabel" for="x_metaliklabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_metaliklabel"><?= $Page->metaliklabel->caption() ?><?= $Page->metaliklabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->metaliklabel->cellAttributes() ?>>
<template id="tpx_npd_harga_metaliklabel"><span id="el_npd_harga_metaliklabel">
<input type="<?= $Page->metaliklabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_metaliklabel" name="x_metaliklabel" id="x_metaliklabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->metaliklabel->getPlaceHolder()) ?>" value="<?= $Page->metaliklabel->EditValue ?>"<?= $Page->metaliklabel->editAttributes() ?> aria-describedby="x_metaliklabel_help">
<?= $Page->metaliklabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->metaliklabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->etiketlabel->Visible) { // etiketlabel ?>
    <div id="r_etiketlabel" class="form-group row">
        <label id="elh_npd_harga_etiketlabel" for="x_etiketlabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_etiketlabel"><?= $Page->etiketlabel->caption() ?><?= $Page->etiketlabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->etiketlabel->cellAttributes() ?>>
<template id="tpx_npd_harga_etiketlabel"><span id="el_npd_harga_etiketlabel">
<input type="<?= $Page->etiketlabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_etiketlabel" name="x_etiketlabel" id="x_etiketlabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->etiketlabel->getPlaceHolder()) ?>" value="<?= $Page->etiketlabel->EditValue ?>"<?= $Page->etiketlabel->editAttributes() ?> aria-describedby="x_etiketlabel_help">
<?= $Page->etiketlabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->etiketlabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganlabel->Visible) { // keteranganlabel ?>
    <div id="r_keteranganlabel" class="form-group row">
        <label id="elh_npd_harga_keteranganlabel" for="x_keteranganlabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_keteranganlabel"><?= $Page->keteranganlabel->caption() ?><?= $Page->keteranganlabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganlabel->cellAttributes() ?>>
<template id="tpx_npd_harga_keteranganlabel"><span id="el_npd_harga_keteranganlabel">
<textarea data-table="npd_harga" data-field="x_keteranganlabel" name="x_keteranganlabel" id="x_keteranganlabel" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganlabel->getPlaceHolder()) ?>"<?= $Page->keteranganlabel->editAttributes() ?> aria-describedby="x_keteranganlabel_help"><?= $Page->keteranganlabel->EditValue ?></textarea>
<?= $Page->keteranganlabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganlabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategoridelivery->Visible) { // kategoridelivery ?>
    <div id="r_kategoridelivery" class="form-group row">
        <label id="elh_npd_harga_kategoridelivery" for="x_kategoridelivery" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_kategoridelivery"><?= $Page->kategoridelivery->caption() ?><?= $Page->kategoridelivery->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategoridelivery->cellAttributes() ?>>
<template id="tpx_npd_harga_kategoridelivery"><span id="el_npd_harga_kategoridelivery">
<input type="<?= $Page->kategoridelivery->getInputTextType() ?>" data-table="npd_harga" data-field="x_kategoridelivery" name="x_kategoridelivery" id="x_kategoridelivery" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kategoridelivery->getPlaceHolder()) ?>" value="<?= $Page->kategoridelivery->EditValue ?>"<?= $Page->kategoridelivery->editAttributes() ?> aria-describedby="x_kategoridelivery_help">
<?= $Page->kategoridelivery->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategoridelivery->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamatpengiriman->Visible) { // alamatpengiriman ?>
    <div id="r_alamatpengiriman" class="form-group row">
        <label id="elh_npd_harga_alamatpengiriman" for="x_alamatpengiriman" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_alamatpengiriman"><?= $Page->alamatpengiriman->caption() ?><?= $Page->alamatpengiriman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamatpengiriman->cellAttributes() ?>>
<template id="tpx_npd_harga_alamatpengiriman"><span id="el_npd_harga_alamatpengiriman">
<input type="<?= $Page->alamatpengiriman->getInputTextType() ?>" data-table="npd_harga" data-field="x_alamatpengiriman" name="x_alamatpengiriman" id="x_alamatpengiriman" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->alamatpengiriman->getPlaceHolder()) ?>" value="<?= $Page->alamatpengiriman->EditValue ?>"<?= $Page->alamatpengiriman->editAttributes() ?> aria-describedby="x_alamatpengiriman_help">
<?= $Page->alamatpengiriman->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamatpengiriman->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
    <div id="r_orderperdana" class="form-group row">
        <label id="elh_npd_harga_orderperdana" for="x_orderperdana" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_orderperdana"><?= $Page->orderperdana->caption() ?><?= $Page->orderperdana->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderperdana->cellAttributes() ?>>
<template id="tpx_npd_harga_orderperdana"><span id="el_npd_harga_orderperdana">
<input type="<?= $Page->orderperdana->getInputTextType() ?>" data-table="npd_harga" data-field="x_orderperdana" name="x_orderperdana" id="x_orderperdana" size="30" placeholder="<?= HtmlEncode($Page->orderperdana->getPlaceHolder()) ?>" value="<?= $Page->orderperdana->EditValue ?>"<?= $Page->orderperdana->editAttributes() ?> aria-describedby="x_orderperdana_help">
<?= $Page->orderperdana->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderperdana->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderkontrak->Visible) { // orderkontrak ?>
    <div id="r_orderkontrak" class="form-group row">
        <label id="elh_npd_harga_orderkontrak" for="x_orderkontrak" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_orderkontrak"><?= $Page->orderkontrak->caption() ?><?= $Page->orderkontrak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderkontrak->cellAttributes() ?>>
<template id="tpx_npd_harga_orderkontrak"><span id="el_npd_harga_orderkontrak">
<input type="<?= $Page->orderkontrak->getInputTextType() ?>" data-table="npd_harga" data-field="x_orderkontrak" name="x_orderkontrak" id="x_orderkontrak" size="30" placeholder="<?= HtmlEncode($Page->orderkontrak->getPlaceHolder()) ?>" value="<?= $Page->orderkontrak->EditValue ?>"<?= $Page->orderkontrak->editAttributes() ?> aria-describedby="x_orderkontrak_help">
<?= $Page->orderkontrak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderkontrak->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hargaperpcs->Visible) { // hargaperpcs ?>
    <div id="r_hargaperpcs" class="form-group row">
        <label id="elh_npd_harga_hargaperpcs" for="x_hargaperpcs" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_hargaperpcs"><?= $Page->hargaperpcs->caption() ?><?= $Page->hargaperpcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hargaperpcs->cellAttributes() ?>>
<template id="tpx_npd_harga_hargaperpcs"><span id="el_npd_harga_hargaperpcs">
<input type="<?= $Page->hargaperpcs->getInputTextType() ?>" data-table="npd_harga" data-field="x_hargaperpcs" name="x_hargaperpcs" id="x_hargaperpcs" size="30" placeholder="<?= HtmlEncode($Page->hargaperpcs->getPlaceHolder()) ?>" value="<?= $Page->hargaperpcs->EditValue ?>"<?= $Page->hargaperpcs->editAttributes() ?> aria-describedby="x_hargaperpcs_help">
<?= $Page->hargaperpcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hargaperpcs->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hargaperkarton->Visible) { // hargaperkarton ?>
    <div id="r_hargaperkarton" class="form-group row">
        <label id="elh_npd_harga_hargaperkarton" for="x_hargaperkarton" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_hargaperkarton"><?= $Page->hargaperkarton->caption() ?><?= $Page->hargaperkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hargaperkarton->cellAttributes() ?>>
<template id="tpx_npd_harga_hargaperkarton"><span id="el_npd_harga_hargaperkarton">
<input type="<?= $Page->hargaperkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_hargaperkarton" name="x_hargaperkarton" id="x_hargaperkarton" size="30" placeholder="<?= HtmlEncode($Page->hargaperkarton->getPlaceHolder()) ?>" value="<?= $Page->hargaperkarton->EditValue ?>"<?= $Page->hargaperkarton->editAttributes() ?> aria-describedby="x_hargaperkarton_help">
<?= $Page->hargaperkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hargaperkarton->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <div id="r_lampiran" class="form-group row">
        <label id="elh_npd_harga_lampiran" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_lampiran"><?= $Page->lampiran->caption() ?><?= $Page->lampiran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lampiran->cellAttributes() ?>>
<template id="tpx_npd_harga_lampiran"><span id="el_npd_harga_lampiran">
<div id="fd_x_lampiran">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->lampiran->title() ?>" data-table="npd_harga" data-field="x_lampiran" name="x_lampiran" id="x_lampiran" lang="<?= CurrentLanguageID() ?>"<?= $Page->lampiran->editAttributes() ?><?= ($Page->lampiran->ReadOnly || $Page->lampiran->Disabled) ? " disabled" : "" ?> aria-describedby="x_lampiran_help">
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
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->prepared_by->Visible) { // prepared_by ?>
    <div id="r_prepared_by" class="form-group row">
        <label id="elh_npd_harga_prepared_by" for="x_prepared_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_prepared_by"><?= $Page->prepared_by->caption() ?><?= $Page->prepared_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->prepared_by->cellAttributes() ?>>
<template id="tpx_npd_harga_prepared_by"><span id="el_npd_harga_prepared_by">
<input type="<?= $Page->prepared_by->getInputTextType() ?>" data-table="npd_harga" data-field="x_prepared_by" name="x_prepared_by" id="x_prepared_by" size="30" placeholder="<?= HtmlEncode($Page->prepared_by->getPlaceHolder()) ?>" value="<?= $Page->prepared_by->EditValue ?>"<?= $Page->prepared_by->editAttributes() ?> aria-describedby="x_prepared_by_help">
<?= $Page->prepared_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->prepared_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <div id="r_checked_by" class="form-group row">
        <label id="elh_npd_harga_checked_by" for="x_checked_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_checked_by"><?= $Page->checked_by->caption() ?><?= $Page->checked_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked_by->cellAttributes() ?>>
<template id="tpx_npd_harga_checked_by"><span id="el_npd_harga_checked_by">
<input type="<?= $Page->checked_by->getInputTextType() ?>" data-table="npd_harga" data-field="x_checked_by" name="x_checked_by" id="x_checked_by" size="30" placeholder="<?= HtmlEncode($Page->checked_by->getPlaceHolder()) ?>" value="<?= $Page->checked_by->EditValue ?>"<?= $Page->checked_by->editAttributes() ?> aria-describedby="x_checked_by_help">
<?= $Page->checked_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->checked_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <div id="r_approved_by" class="form-group row">
        <label id="elh_npd_harga_approved_by" for="x_approved_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_approved_by"><?= $Page->approved_by->caption() ?><?= $Page->approved_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approved_by->cellAttributes() ?>>
<template id="tpx_npd_harga_approved_by"><span id="el_npd_harga_approved_by">
<input type="<?= $Page->approved_by->getInputTextType() ?>" data-table="npd_harga" data-field="x_approved_by" name="x_approved_by" id="x_approved_by" size="30" placeholder="<?= HtmlEncode($Page->approved_by->getPlaceHolder()) ?>" value="<?= $Page->approved_by->EditValue ?>"<?= $Page->approved_by->editAttributes() ?> aria-describedby="x_approved_by_help">
<?= $Page->approved_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->approved_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
    <div id="r_disetujui" class="form-group row">
        <label id="elh_npd_harga_disetujui" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_disetujui"><?= $Page->disetujui->caption() ?><?= $Page->disetujui->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->disetujui->cellAttributes() ?>>
<template id="tpx_npd_harga_disetujui"><span id="el_npd_harga_disetujui">
<template id="tp_x_disetujui">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_harga" data-field="x_disetujui" name="x_disetujui" id="x_disetujui"<?= $Page->disetujui->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_disetujui" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_disetujui"
    name="x_disetujui"
    value="<?= HtmlEncode($Page->disetujui->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_disetujui"
    data-target="dsl_x_disetujui"
    data-repeatcolumn="5"
    class="form-control<?= $Page->disetujui->isInvalidClass() ?>"
    data-table="npd_harga"
    data-field="x_disetujui"
    data-value-separator="<?= $Page->disetujui->displayValueSeparatorAttribute() ?>"
    <?= $Page->disetujui->editAttributes() ?>>
<?= $Page->disetujui->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->disetujui->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_npd_harga_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_harga_updated_at"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<template id="tpx_npd_harga_updated_at"><span id="el_npd_harga_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="npd_harga" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_hargaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_hargaadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_npd_hargaadd" class="ew-custom-template"></div>
<template id="tpm_npd_hargaadd">
<div id="ct_NpdHargaAdd"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
            	<div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_harga_idnpd"></slot></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tglpengajuan->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_tglpengajuan"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">PEMESAN</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Nama Pemesan</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="c_namapemesan" placeholder="Nama Pemesan" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Alamat</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="c_alamat" placeholder="Alamat" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Contact Person</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="c_contactperson" placeholder="Contact Person" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Jabatan</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="c_jabatan" placeholder="Jabatan" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Telepon</label>
                <div class="col-8">
                    <input type="text" class="form-control" id="c_telepon" placeholder="Telepon" disabled>
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
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_idnpd_sample"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->nama->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_nama"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Jenis Produk</label>
                <div class="col-8"><input type="text" name="c_jenisproduk" id="c_jenisproduk" class="form-control" placeholder="Jenis Produk" disabled></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bentuk->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_bentuk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->viskositas->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_viskositas"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><slot class="ew-slot" name="tpcaption_warna"></slot></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_warna"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><slot class="ew-slot" name="tpcaption_bauparfum"></slot></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_bauparfum"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasisediaan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_aplikasisediaan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->volume->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_volume"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bahanaktif->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_bahanaktif"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KEMASAN PRIMER</div>
        </div>
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->volumewadah->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_volumewadah"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->bahanwadah->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_bahanwadah"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->warnawadah->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_warnawadah"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->bentukwadah->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_bentukwadah"></slot></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->jenistutup->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_jenistutup"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->bahantutup->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_bahantutup"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->warnatutup->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_warnatutup"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->bentuktutup->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_bentuktutup"></slot></div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right"><?= $Page->segel->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_segel"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right"><?= $Page->catatanprimer->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_catatanprimer"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KEMASAN SEKUNDER</div>
        </div>
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->packingproduk->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_packingproduk"></slot></div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-4 col-form-label text-right"><?= $Page->keteranganpacking->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_keteranganpacking"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->beltkarton->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_beltkarton"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->keteranganbelt->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_keteranganbelt"></slot></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->kartonluar->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_kartonluar"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->bariskarton->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_bariskarton"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->kolomkarton->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_kolomkarton"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->stackkarton->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_stackkarton"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->isikarton->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_isikarton"></slot></div>
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
                <label class="col-2 col-form-label text-right"><?= $Page->jenislabel->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_jenislabel"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->keteranganjenislabel->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_keteranganjenislabel"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kualitaslabel->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_kualitaslabel"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jumlahwarnalabel->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_jumlahwarnalabel"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->metaliklabel->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_metaliklabel"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->etiketlabel->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_etiketlabel"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->keteranganlabel->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_keteranganlabel"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">DELIVERY</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kategoridelivery->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_kategoridelivery"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->alamatpengiriman->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_alamatpengiriman"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">JUMLAH ORDER (PRODUKSI)</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->orderperdana->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_orderperdana"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->orderkontrak->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_orderkontrak"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">HARGA PENAWARAN</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->hargaperpcs->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_hargaperpcs"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->hargaperkarton->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_hargaperkarton"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->lampiran->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_lampiran"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->prepared_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_prepared_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_checked_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->approved_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_harga_approved_by"></slot></div>
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
    ew.applyTemplate("tpd_npd_hargaadd", "tpm_npd_hargaadd", "npd_hargaadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("npd_harga");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("select[name=x_idnpd]").change((function(){$.ajax({url:"api/npd_customer/"+$(this).val(),type:"GET",success:function(a){!1!==a.success&&($("#c_jenisproduk").val(a.data.jenisproduk),$("#c_namapemesan").val(a.data.namacustomer),$("#c_alamat").val(a.data.alamatcustomer),$("#c_jabatan").val(a.data.jabatancustomer),$("#c_contactperson").val(a.data.namacustomer),$("#c_telepon").val(a.data.telponcustomer))}})}));
});
</script>
