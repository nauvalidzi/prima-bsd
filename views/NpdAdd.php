<?php

namespace PHPMaker2021\production2;

// Page object
$NpdAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpdadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpdadd = currentForm = new ew.Form("fnpdadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd)
        ew.vars.tables.npd = currentTable;
    fnpdadd.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null], fields.idbrand.isInvalid],
        ["tanggal_order", [fields.tanggal_order.visible && fields.tanggal_order.required ? ew.Validators.required(fields.tanggal_order.caption) : null, ew.Validators.datetime(0)], fields.tanggal_order.isInvalid],
        ["target_selesai", [fields.target_selesai.visible && fields.target_selesai.required ? ew.Validators.required(fields.target_selesai.caption) : null, ew.Validators.datetime(0)], fields.target_selesai.isInvalid],
        ["sifatorder", [fields.sifatorder.visible && fields.sifatorder.required ? ew.Validators.required(fields.sifatorder.caption) : null], fields.sifatorder.isInvalid],
        ["kodeorder", [fields.kodeorder.visible && fields.kodeorder.required ? ew.Validators.required(fields.kodeorder.caption) : null], fields.kodeorder.isInvalid],
        ["nomororder", [fields.nomororder.visible && fields.nomororder.required ? ew.Validators.required(fields.nomororder.caption) : null], fields.nomororder.isInvalid],
        ["idproduct_acuan", [fields.idproduct_acuan.visible && fields.idproduct_acuan.required ? ew.Validators.required(fields.idproduct_acuan.caption) : null], fields.idproduct_acuan.isInvalid],
        ["kategoriproduk", [fields.kategoriproduk.visible && fields.kategoriproduk.required ? ew.Validators.required(fields.kategoriproduk.caption) : null], fields.kategoriproduk.isInvalid],
        ["jenisproduk", [fields.jenisproduk.visible && fields.jenisproduk.required ? ew.Validators.required(fields.jenisproduk.caption) : null], fields.jenisproduk.isInvalid],
        ["fungsiproduk", [fields.fungsiproduk.visible && fields.fungsiproduk.required ? ew.Validators.required(fields.fungsiproduk.caption) : null], fields.fungsiproduk.isInvalid],
        ["kualitasproduk", [fields.kualitasproduk.visible && fields.kualitasproduk.required ? ew.Validators.required(fields.kualitasproduk.caption) : null], fields.kualitasproduk.isInvalid],
        ["bahan_campaign", [fields.bahan_campaign.visible && fields.bahan_campaign.required ? ew.Validators.required(fields.bahan_campaign.caption) : null], fields.bahan_campaign.isInvalid],
        ["ukuransediaan", [fields.ukuransediaan.visible && fields.ukuransediaan.required ? ew.Validators.required(fields.ukuransediaan.caption) : null], fields.ukuransediaan.isInvalid],
        ["satuansediaan", [fields.satuansediaan.visible && fields.satuansediaan.required ? ew.Validators.required(fields.satuansediaan.caption) : null], fields.satuansediaan.isInvalid],
        ["bentuk", [fields.bentuk.visible && fields.bentuk.required ? ew.Validators.required(fields.bentuk.caption) : null], fields.bentuk.isInvalid],
        ["viskositas", [fields.viskositas.visible && fields.viskositas.required ? ew.Validators.required(fields.viskositas.caption) : null], fields.viskositas.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["parfum", [fields.parfum.visible && fields.parfum.required ? ew.Validators.required(fields.parfum.caption) : null], fields.parfum.isInvalid],
        ["aplikasi", [fields.aplikasi.visible && fields.aplikasi.required ? ew.Validators.required(fields.aplikasi.caption) : null], fields.aplikasi.isInvalid],
        ["estetika", [fields.estetika.visible && fields.estetika.required ? ew.Validators.required(fields.estetika.caption) : null], fields.estetika.isInvalid],
        ["tambahan", [fields.tambahan.visible && fields.tambahan.required ? ew.Validators.required(fields.tambahan.caption) : null], fields.tambahan.isInvalid],
        ["ukurankemasan", [fields.ukurankemasan.visible && fields.ukurankemasan.required ? ew.Validators.required(fields.ukurankemasan.caption) : null], fields.ukurankemasan.isInvalid],
        ["satuankemasan", [fields.satuankemasan.visible && fields.satuankemasan.required ? ew.Validators.required(fields.satuankemasan.caption) : null], fields.satuankemasan.isInvalid],
        ["kemasanwadah", [fields.kemasanwadah.visible && fields.kemasanwadah.required ? ew.Validators.required(fields.kemasanwadah.caption) : null], fields.kemasanwadah.isInvalid],
        ["kemasantutup", [fields.kemasantutup.visible && fields.kemasantutup.required ? ew.Validators.required(fields.kemasantutup.caption) : null], fields.kemasantutup.isInvalid],
        ["kemasancatatan", [fields.kemasancatatan.visible && fields.kemasancatatan.required ? ew.Validators.required(fields.kemasancatatan.caption) : null], fields.kemasancatatan.isInvalid],
        ["ukurankemasansekunder", [fields.ukurankemasansekunder.visible && fields.ukurankemasansekunder.required ? ew.Validators.required(fields.ukurankemasansekunder.caption) : null], fields.ukurankemasansekunder.isInvalid],
        ["satuankemasansekunder", [fields.satuankemasansekunder.visible && fields.satuankemasansekunder.required ? ew.Validators.required(fields.satuankemasansekunder.caption) : null], fields.satuankemasansekunder.isInvalid],
        ["kemasanbahan", [fields.kemasanbahan.visible && fields.kemasanbahan.required ? ew.Validators.required(fields.kemasanbahan.caption) : null], fields.kemasanbahan.isInvalid],
        ["kemasanbentuk", [fields.kemasanbentuk.visible && fields.kemasanbentuk.required ? ew.Validators.required(fields.kemasanbentuk.caption) : null], fields.kemasanbentuk.isInvalid],
        ["kemasankomposisi", [fields.kemasankomposisi.visible && fields.kemasankomposisi.required ? ew.Validators.required(fields.kemasankomposisi.caption) : null], fields.kemasankomposisi.isInvalid],
        ["kemasancatatansekunder", [fields.kemasancatatansekunder.visible && fields.kemasancatatansekunder.required ? ew.Validators.required(fields.kemasancatatansekunder.caption) : null], fields.kemasancatatansekunder.isInvalid],
        ["labelbahan", [fields.labelbahan.visible && fields.labelbahan.required ? ew.Validators.required(fields.labelbahan.caption) : null], fields.labelbahan.isInvalid],
        ["labelkualitas", [fields.labelkualitas.visible && fields.labelkualitas.required ? ew.Validators.required(fields.labelkualitas.caption) : null], fields.labelkualitas.isInvalid],
        ["labelposisi", [fields.labelposisi.visible && fields.labelposisi.required ? ew.Validators.required(fields.labelposisi.caption) : null], fields.labelposisi.isInvalid],
        ["labelcatatan", [fields.labelcatatan.visible && fields.labelcatatan.required ? ew.Validators.required(fields.labelcatatan.caption) : null], fields.labelcatatan.isInvalid],
        ["labeltekstur", [fields.labeltekstur.visible && fields.labeltekstur.required ? ew.Validators.required(fields.labeltekstur.caption) : null], fields.labeltekstur.isInvalid],
        ["labelprint", [fields.labelprint.visible && fields.labelprint.required ? ew.Validators.required(fields.labelprint.caption) : null], fields.labelprint.isInvalid],
        ["labeljmlwarna", [fields.labeljmlwarna.visible && fields.labeljmlwarna.required ? ew.Validators.required(fields.labeljmlwarna.caption) : null, ew.Validators.integer], fields.labeljmlwarna.isInvalid],
        ["labelcatatanhotprint", [fields.labelcatatanhotprint.visible && fields.labelcatatanhotprint.required ? ew.Validators.required(fields.labelcatatanhotprint.caption) : null], fields.labelcatatanhotprint.isInvalid],
        ["ukuran_utama", [fields.ukuran_utama.visible && fields.ukuran_utama.required ? ew.Validators.required(fields.ukuran_utama.caption) : null], fields.ukuran_utama.isInvalid],
        ["utama_harga_isi", [fields.utama_harga_isi.visible && fields.utama_harga_isi.required ? ew.Validators.required(fields.utama_harga_isi.caption) : null, ew.Validators.integer], fields.utama_harga_isi.isInvalid],
        ["utama_harga_isi_proyeksi", [fields.utama_harga_isi_proyeksi.visible && fields.utama_harga_isi_proyeksi.required ? ew.Validators.required(fields.utama_harga_isi_proyeksi.caption) : null, ew.Validators.integer], fields.utama_harga_isi_proyeksi.isInvalid],
        ["utama_harga_primer", [fields.utama_harga_primer.visible && fields.utama_harga_primer.required ? ew.Validators.required(fields.utama_harga_primer.caption) : null, ew.Validators.integer], fields.utama_harga_primer.isInvalid],
        ["utama_harga_primer_proyeksi", [fields.utama_harga_primer_proyeksi.visible && fields.utama_harga_primer_proyeksi.required ? ew.Validators.required(fields.utama_harga_primer_proyeksi.caption) : null, ew.Validators.integer], fields.utama_harga_primer_proyeksi.isInvalid],
        ["utama_harga_sekunder", [fields.utama_harga_sekunder.visible && fields.utama_harga_sekunder.required ? ew.Validators.required(fields.utama_harga_sekunder.caption) : null, ew.Validators.integer], fields.utama_harga_sekunder.isInvalid],
        ["utama_harga_sekunder_proyeksi", [fields.utama_harga_sekunder_proyeksi.visible && fields.utama_harga_sekunder_proyeksi.required ? ew.Validators.required(fields.utama_harga_sekunder_proyeksi.caption) : null, ew.Validators.integer], fields.utama_harga_sekunder_proyeksi.isInvalid],
        ["utama_harga_label", [fields.utama_harga_label.visible && fields.utama_harga_label.required ? ew.Validators.required(fields.utama_harga_label.caption) : null, ew.Validators.integer], fields.utama_harga_label.isInvalid],
        ["utama_harga_label_proyeksi", [fields.utama_harga_label_proyeksi.visible && fields.utama_harga_label_proyeksi.required ? ew.Validators.required(fields.utama_harga_label_proyeksi.caption) : null, ew.Validators.integer], fields.utama_harga_label_proyeksi.isInvalid],
        ["utama_harga_total", [fields.utama_harga_total.visible && fields.utama_harga_total.required ? ew.Validators.required(fields.utama_harga_total.caption) : null, ew.Validators.integer], fields.utama_harga_total.isInvalid],
        ["utama_harga_total_proyeksi", [fields.utama_harga_total_proyeksi.visible && fields.utama_harga_total_proyeksi.required ? ew.Validators.required(fields.utama_harga_total_proyeksi.caption) : null, ew.Validators.integer], fields.utama_harga_total_proyeksi.isInvalid],
        ["ukuran_lain", [fields.ukuran_lain.visible && fields.ukuran_lain.required ? ew.Validators.required(fields.ukuran_lain.caption) : null], fields.ukuran_lain.isInvalid],
        ["lain_harga_isi", [fields.lain_harga_isi.visible && fields.lain_harga_isi.required ? ew.Validators.required(fields.lain_harga_isi.caption) : null, ew.Validators.integer], fields.lain_harga_isi.isInvalid],
        ["lain_harga_isi_proyeksi", [fields.lain_harga_isi_proyeksi.visible && fields.lain_harga_isi_proyeksi.required ? ew.Validators.required(fields.lain_harga_isi_proyeksi.caption) : null, ew.Validators.integer], fields.lain_harga_isi_proyeksi.isInvalid],
        ["lain_harga_primer", [fields.lain_harga_primer.visible && fields.lain_harga_primer.required ? ew.Validators.required(fields.lain_harga_primer.caption) : null, ew.Validators.integer], fields.lain_harga_primer.isInvalid],
        ["lain_harga_primer_proyeksi", [fields.lain_harga_primer_proyeksi.visible && fields.lain_harga_primer_proyeksi.required ? ew.Validators.required(fields.lain_harga_primer_proyeksi.caption) : null, ew.Validators.integer], fields.lain_harga_primer_proyeksi.isInvalid],
        ["lain_harga_sekunder", [fields.lain_harga_sekunder.visible && fields.lain_harga_sekunder.required ? ew.Validators.required(fields.lain_harga_sekunder.caption) : null, ew.Validators.integer], fields.lain_harga_sekunder.isInvalid],
        ["lain_harga_sekunder_proyeksi", [fields.lain_harga_sekunder_proyeksi.visible && fields.lain_harga_sekunder_proyeksi.required ? ew.Validators.required(fields.lain_harga_sekunder_proyeksi.caption) : null, ew.Validators.integer], fields.lain_harga_sekunder_proyeksi.isInvalid],
        ["lain_harga_label", [fields.lain_harga_label.visible && fields.lain_harga_label.required ? ew.Validators.required(fields.lain_harga_label.caption) : null, ew.Validators.integer], fields.lain_harga_label.isInvalid],
        ["lain_harga_label_proyeksi", [fields.lain_harga_label_proyeksi.visible && fields.lain_harga_label_proyeksi.required ? ew.Validators.required(fields.lain_harga_label_proyeksi.caption) : null, ew.Validators.integer], fields.lain_harga_label_proyeksi.isInvalid],
        ["lain_harga_total", [fields.lain_harga_total.visible && fields.lain_harga_total.required ? ew.Validators.required(fields.lain_harga_total.caption) : null, ew.Validators.integer], fields.lain_harga_total.isInvalid],
        ["lain_harga_total_proyeksi", [fields.lain_harga_total_proyeksi.visible && fields.lain_harga_total_proyeksi.required ? ew.Validators.required(fields.lain_harga_total_proyeksi.caption) : null, ew.Validators.integer], fields.lain_harga_total_proyeksi.isInvalid],
        ["delivery_pickup", [fields.delivery_pickup.visible && fields.delivery_pickup.required ? ew.Validators.required(fields.delivery_pickup.caption) : null], fields.delivery_pickup.isInvalid],
        ["delivery_singlepoint", [fields.delivery_singlepoint.visible && fields.delivery_singlepoint.required ? ew.Validators.required(fields.delivery_singlepoint.caption) : null], fields.delivery_singlepoint.isInvalid],
        ["delivery_multipoint", [fields.delivery_multipoint.visible && fields.delivery_multipoint.required ? ew.Validators.required(fields.delivery_multipoint.caption) : null], fields.delivery_multipoint.isInvalid],
        ["delivery_termlain", [fields.delivery_termlain.visible && fields.delivery_termlain.required ? ew.Validators.required(fields.delivery_termlain.caption) : null], fields.delivery_termlain.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["receipt_by", [fields.receipt_by.visible && fields.receipt_by.required ? ew.Validators.required(fields.receipt_by.caption) : null, ew.Validators.integer], fields.receipt_by.isInvalid],
        ["approve_by", [fields.approve_by.visible && fields.approve_by.required ? ew.Validators.required(fields.approve_by.caption) : null], fields.approve_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpdadd,
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
    fnpdadd.validate = function () {
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
    fnpdadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpdadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpdadd.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    fnpdadd.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    fnpdadd.lists.idbrand = <?= $Page->idbrand->toClientList($Page) ?>;
    fnpdadd.lists.sifatorder = <?= $Page->sifatorder->toClientList($Page) ?>;
    fnpdadd.lists.idproduct_acuan = <?= $Page->idproduct_acuan->toClientList($Page) ?>;
    fnpdadd.lists.kategoriproduk = <?= $Page->kategoriproduk->toClientList($Page) ?>;
    fnpdadd.lists.jenisproduk = <?= $Page->jenisproduk->toClientList($Page) ?>;
    fnpdadd.lists.kualitasproduk = <?= $Page->kualitasproduk->toClientList($Page) ?>;
    fnpdadd.lists.satuansediaan = <?= $Page->satuansediaan->toClientList($Page) ?>;
    fnpdadd.lists.bentuk = <?= $Page->bentuk->toClientList($Page) ?>;
    fnpdadd.lists.viskositas = <?= $Page->viskositas->toClientList($Page) ?>;
    fnpdadd.lists.warna = <?= $Page->warna->toClientList($Page) ?>;
    fnpdadd.lists.parfum = <?= $Page->parfum->toClientList($Page) ?>;
    fnpdadd.lists.aplikasi = <?= $Page->aplikasi->toClientList($Page) ?>;
    fnpdadd.lists.estetika = <?= $Page->estetika->toClientList($Page) ?>;
    fnpdadd.lists.satuankemasan = <?= $Page->satuankemasan->toClientList($Page) ?>;
    fnpdadd.lists.kemasanwadah = <?= $Page->kemasanwadah->toClientList($Page) ?>;
    fnpdadd.lists.kemasantutup = <?= $Page->kemasantutup->toClientList($Page) ?>;
    fnpdadd.lists.satuankemasansekunder = <?= $Page->satuankemasansekunder->toClientList($Page) ?>;
    fnpdadd.lists.kemasanbahan = <?= $Page->kemasanbahan->toClientList($Page) ?>;
    fnpdadd.lists.kemasanbentuk = <?= $Page->kemasanbentuk->toClientList($Page) ?>;
    fnpdadd.lists.kemasankomposisi = <?= $Page->kemasankomposisi->toClientList($Page) ?>;
    fnpdadd.lists.labelbahan = <?= $Page->labelbahan->toClientList($Page) ?>;
    fnpdadd.lists.labelkualitas = <?= $Page->labelkualitas->toClientList($Page) ?>;
    fnpdadd.lists.labelposisi = <?= $Page->labelposisi->toClientList($Page) ?>;
    fnpdadd.lists.labeltekstur = <?= $Page->labeltekstur->toClientList($Page) ?>;
    fnpdadd.lists.labelprint = <?= $Page->labelprint->toClientList($Page) ?>;
    fnpdadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    fnpdadd.lists.approve_by = <?= $Page->approve_by->toClientList($Page) ?>;
    loadjs.done("fnpdadd");
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
<form name="fnpdadd" id="fnpdadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_npd_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_idpegawai"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<template id="tpx_npd_idpegawai"><span id="el_npd_idpegawai">
<?php $Page->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="npd_x_idpegawai"
        data-table="npd"
        data-field="x_idpegawai"
        data-page="1"
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
    var el = document.querySelector("select[data-select2-id='npd_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "npd_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_npd_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_idcustomer"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<template id="tpx_npd_idcustomer"><span id="el_npd_idcustomer">
<?php $Page->idcustomer->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="npd_x_idcustomer"
        data-table="npd"
        data-field="x_idcustomer"
        data-page="1"
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
    var el = document.querySelector("select[data-select2-id='npd_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "npd_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <div id="r_idbrand" class="form-group row">
        <label id="elh_npd_idbrand" for="x_idbrand" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_idbrand"><?= $Page->idbrand->caption() ?><?= $Page->idbrand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idbrand->cellAttributes() ?>>
<template id="tpx_npd_idbrand"><span id="el_npd_idbrand">
    <select
        id="x_idbrand"
        name="x_idbrand"
        class="form-control ew-select<?= $Page->idbrand->isInvalidClass() ?>"
        data-select2-id="npd_x_idbrand"
        data-table="npd"
        data-field="x_idbrand"
        data-page="1"
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
    var el = document.querySelector("select[data-select2-id='npd_x_idbrand']"),
        options = { name: "x_idbrand", selectId: "npd_x_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
    <div id="r_tanggal_order" class="form-group row">
        <label id="elh_npd_tanggal_order" for="x_tanggal_order" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_tanggal_order"><?= $Page->tanggal_order->caption() ?><?= $Page->tanggal_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_order->cellAttributes() ?>>
<template id="tpx_npd_tanggal_order"><span id="el_npd_tanggal_order">
<input type="<?= $Page->tanggal_order->getInputTextType() ?>" data-table="npd" data-field="x_tanggal_order" data-page="1" name="x_tanggal_order" id="x_tanggal_order" placeholder="<?= HtmlEncode($Page->tanggal_order->getPlaceHolder()) ?>" value="<?= $Page->tanggal_order->EditValue ?>"<?= $Page->tanggal_order->editAttributes() ?> aria-describedby="x_tanggal_order_help">
<?= $Page->tanggal_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_order->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_order->ReadOnly && !$Page->tanggal_order->Disabled && !isset($Page->tanggal_order->EditAttrs["readonly"]) && !isset($Page->tanggal_order->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpdadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpdadd", "x_tanggal_order", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
    <div id="r_target_selesai" class="form-group row">
        <label id="elh_npd_target_selesai" for="x_target_selesai" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_target_selesai"><?= $Page->target_selesai->caption() ?><?= $Page->target_selesai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->target_selesai->cellAttributes() ?>>
<template id="tpx_npd_target_selesai"><span id="el_npd_target_selesai">
<input type="<?= $Page->target_selesai->getInputTextType() ?>" data-table="npd" data-field="x_target_selesai" data-page="1" name="x_target_selesai" id="x_target_selesai" placeholder="<?= HtmlEncode($Page->target_selesai->getPlaceHolder()) ?>" value="<?= $Page->target_selesai->EditValue ?>"<?= $Page->target_selesai->editAttributes() ?> aria-describedby="x_target_selesai_help">
<?= $Page->target_selesai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->target_selesai->getErrorMessage() ?></div>
<?php if (!$Page->target_selesai->ReadOnly && !$Page->target_selesai->Disabled && !isset($Page->target_selesai->EditAttrs["readonly"]) && !isset($Page->target_selesai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpdadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpdadd", "x_target_selesai", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sifatorder->Visible) { // sifatorder ?>
    <div id="r_sifatorder" class="form-group row">
        <label id="elh_npd_sifatorder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_sifatorder"><?= $Page->sifatorder->caption() ?><?= $Page->sifatorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sifatorder->cellAttributes() ?>>
<template id="tpx_npd_sifatorder"><span id="el_npd_sifatorder">
<template id="tp_x_sifatorder">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_sifatorder" name="x_sifatorder" id="x_sifatorder"<?= $Page->sifatorder->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_sifatorder" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_sifatorder"
    name="x_sifatorder"
    value="<?= HtmlEncode($Page->sifatorder->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_sifatorder"
    data-target="dsl_x_sifatorder"
    data-repeatcolumn="2"
    class="form-control<?= $Page->sifatorder->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_sifatorder"
    data-page="1"
    data-value-separator="<?= $Page->sifatorder->displayValueSeparatorAttribute() ?>"
    <?= $Page->sifatorder->editAttributes() ?>>
<?= $Page->sifatorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sifatorder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
    <div id="r_kodeorder" class="form-group row">
        <label id="elh_npd_kodeorder" for="x_kodeorder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kodeorder"><?= $Page->kodeorder->caption() ?><?= $Page->kodeorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodeorder->cellAttributes() ?>>
<template id="tpx_npd_kodeorder"><span id="el_npd_kodeorder">
<input type="<?= $Page->kodeorder->getInputTextType() ?>" data-table="npd" data-field="x_kodeorder" data-page="1" name="x_kodeorder" id="x_kodeorder" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->kodeorder->getPlaceHolder()) ?>" value="<?= $Page->kodeorder->EditValue ?>"<?= $Page->kodeorder->editAttributes() ?> aria-describedby="x_kodeorder_help">
<?= $Page->kodeorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kodeorder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomororder->Visible) { // nomororder ?>
    <div id="r_nomororder" class="form-group row">
        <label id="elh_npd_nomororder" for="x_nomororder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_nomororder"><?= $Page->nomororder->caption() ?><?= $Page->nomororder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nomororder->cellAttributes() ?>>
<template id="tpx_npd_nomororder"><span id="el_npd_nomororder">
<input type="<?= $Page->nomororder->getInputTextType() ?>" data-table="npd" data-field="x_nomororder" data-page="1" name="x_nomororder" id="x_nomororder" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nomororder->getPlaceHolder()) ?>" value="<?= $Page->nomororder->EditValue ?>"<?= $Page->nomororder->editAttributes() ?> aria-describedby="x_nomororder_help">
<?= $Page->nomororder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomororder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <div id="r_idproduct_acuan" class="form-group row">
        <label id="elh_npd_idproduct_acuan" for="x_idproduct_acuan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?><?= $Page->idproduct_acuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct_acuan->cellAttributes() ?>>
<template id="tpx_npd_idproduct_acuan"><span id="el_npd_idproduct_acuan">
    <select
        id="x_idproduct_acuan"
        name="x_idproduct_acuan"
        class="form-control ew-select<?= $Page->idproduct_acuan->isInvalidClass() ?>"
        data-select2-id="npd_x_idproduct_acuan"
        data-table="npd"
        data-field="x_idproduct_acuan"
        data-page="1"
        data-value-separator="<?= $Page->idproduct_acuan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idproduct_acuan->getPlaceHolder()) ?>"
        <?= $Page->idproduct_acuan->editAttributes() ?>>
        <?= $Page->idproduct_acuan->selectOptionListHtml("x_idproduct_acuan") ?>
    </select>
    <?= $Page->idproduct_acuan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idproduct_acuan->getErrorMessage() ?></div>
<?= $Page->idproduct_acuan->Lookup->getParamTag($Page, "p_x_idproduct_acuan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idproduct_acuan']"),
        options = { name: "x_idproduct_acuan", selectId: "npd_x_idproduct_acuan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idproduct_acuan.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
    <div id="r_kategoriproduk" class="form-group row">
        <label id="elh_npd_kategoriproduk" for="x_kategoriproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kategoriproduk"><?= $Page->kategoriproduk->caption() ?><?= $Page->kategoriproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategoriproduk->cellAttributes() ?>>
<template id="tpx_npd_kategoriproduk"><span id="el_npd_kategoriproduk">
<?php $Page->kategoriproduk->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_kategoriproduk"
        name="x_kategoriproduk"
        class="form-control ew-select<?= $Page->kategoriproduk->isInvalidClass() ?>"
        data-select2-id="npd_x_kategoriproduk"
        data-table="npd"
        data-field="x_kategoriproduk"
        data-page="1"
        data-value-separator="<?= $Page->kategoriproduk->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->kategoriproduk->getPlaceHolder()) ?>"
        <?= $Page->kategoriproduk->editAttributes() ?>>
        <?= $Page->kategoriproduk->selectOptionListHtml("x_kategoriproduk") ?>
    </select>
    <?= $Page->kategoriproduk->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->kategoriproduk->getErrorMessage() ?></div>
<?= $Page->kategoriproduk->Lookup->getParamTag($Page, "p_x_kategoriproduk") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_kategoriproduk']"),
        options = { name: "x_kategoriproduk", selectId: "npd_x_kategoriproduk", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.kategoriproduk.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
    <div id="r_jenisproduk" class="form-group row">
        <label id="elh_npd_jenisproduk" for="x_jenisproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_jenisproduk"><?= $Page->jenisproduk->caption() ?><?= $Page->jenisproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenisproduk->cellAttributes() ?>>
<template id="tpx_npd_jenisproduk"><span id="el_npd_jenisproduk">
    <select
        id="x_jenisproduk"
        name="x_jenisproduk"
        class="form-control ew-select<?= $Page->jenisproduk->isInvalidClass() ?>"
        data-select2-id="npd_x_jenisproduk"
        data-table="npd"
        data-field="x_jenisproduk"
        data-page="1"
        data-value-separator="<?= $Page->jenisproduk->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->jenisproduk->getPlaceHolder()) ?>"
        <?= $Page->jenisproduk->editAttributes() ?>>
        <?= $Page->jenisproduk->selectOptionListHtml("x_jenisproduk") ?>
    </select>
    <?= $Page->jenisproduk->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->jenisproduk->getErrorMessage() ?></div>
<?= $Page->jenisproduk->Lookup->getParamTag($Page, "p_x_jenisproduk") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_jenisproduk']"),
        options = { name: "x_jenisproduk", selectId: "npd_x_jenisproduk", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.jenisproduk.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fungsiproduk->Visible) { // fungsiproduk ?>
    <div id="r_fungsiproduk" class="form-group row">
        <label id="elh_npd_fungsiproduk" for="x_fungsiproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_fungsiproduk"><?= $Page->fungsiproduk->caption() ?><?= $Page->fungsiproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fungsiproduk->cellAttributes() ?>>
<template id="tpx_npd_fungsiproduk"><span id="el_npd_fungsiproduk">
<input type="<?= $Page->fungsiproduk->getInputTextType() ?>" data-table="npd" data-field="x_fungsiproduk" data-page="1" name="x_fungsiproduk" id="x_fungsiproduk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fungsiproduk->getPlaceHolder()) ?>" value="<?= $Page->fungsiproduk->EditValue ?>"<?= $Page->fungsiproduk->editAttributes() ?> aria-describedby="x_fungsiproduk_help">
<?= $Page->fungsiproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fungsiproduk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kualitasproduk->Visible) { // kualitasproduk ?>
    <div id="r_kualitasproduk" class="form-group row">
        <label id="elh_npd_kualitasproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kualitasproduk"><?= $Page->kualitasproduk->caption() ?><?= $Page->kualitasproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kualitasproduk->cellAttributes() ?>>
<template id="tpx_npd_kualitasproduk"><span id="el_npd_kualitasproduk">
<template id="tp_x_kualitasproduk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_kualitasproduk" name="x_kualitasproduk" id="x_kualitasproduk"<?= $Page->kualitasproduk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kualitasproduk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kualitasproduk"
    name="x_kualitasproduk"
    value="<?= HtmlEncode($Page->kualitasproduk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_kualitasproduk"
    data-target="dsl_x_kualitasproduk"
    data-repeatcolumn="5"
    class="form-control<?= $Page->kualitasproduk->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kualitasproduk"
    data-page="1"
    data-value-separator="<?= $Page->kualitasproduk->displayValueSeparatorAttribute() ?>"
    <?= $Page->kualitasproduk->editAttributes() ?>>
<?= $Page->kualitasproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kualitasproduk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
    <div id="r_bahan_campaign" class="form-group row">
        <label id="elh_npd_bahan_campaign" for="x_bahan_campaign" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_bahan_campaign"><?= $Page->bahan_campaign->caption() ?><?= $Page->bahan_campaign->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahan_campaign->cellAttributes() ?>>
<template id="tpx_npd_bahan_campaign"><span id="el_npd_bahan_campaign">
<textarea data-table="npd" data-field="x_bahan_campaign" data-page="1" name="x_bahan_campaign" id="x_bahan_campaign" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bahan_campaign->getPlaceHolder()) ?>"<?= $Page->bahan_campaign->editAttributes() ?> aria-describedby="x_bahan_campaign_help"><?= $Page->bahan_campaign->EditValue ?></textarea>
<?= $Page->bahan_campaign->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahan_campaign->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuransediaan->Visible) { // ukuransediaan ?>
    <div id="r_ukuransediaan" class="form-group row">
        <label id="elh_npd_ukuransediaan" for="x_ukuransediaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_ukuransediaan"><?= $Page->ukuransediaan->caption() ?><?= $Page->ukuransediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuransediaan->cellAttributes() ?>>
<template id="tpx_npd_ukuransediaan"><span id="el_npd_ukuransediaan">
<input type="<?= $Page->ukuransediaan->getInputTextType() ?>" data-table="npd" data-field="x_ukuransediaan" data-page="1" name="x_ukuransediaan" id="x_ukuransediaan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ukuransediaan->getPlaceHolder()) ?>" value="<?= $Page->ukuransediaan->EditValue ?>"<?= $Page->ukuransediaan->editAttributes() ?> aria-describedby="x_ukuransediaan_help">
<?= $Page->ukuransediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuransediaan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuansediaan->Visible) { // satuansediaan ?>
    <div id="r_satuansediaan" class="form-group row">
        <label id="elh_npd_satuansediaan" for="x_satuansediaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_satuansediaan"><?= $Page->satuansediaan->caption() ?><?= $Page->satuansediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->satuansediaan->cellAttributes() ?>>
<template id="tpx_npd_satuansediaan"><span id="el_npd_satuansediaan">
    <select
        id="x_satuansediaan"
        name="x_satuansediaan"
        class="form-control ew-select<?= $Page->satuansediaan->isInvalidClass() ?>"
        data-select2-id="npd_x_satuansediaan"
        data-table="npd"
        data-field="x_satuansediaan"
        data-page="1"
        data-value-separator="<?= $Page->satuansediaan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->satuansediaan->getPlaceHolder()) ?>"
        <?= $Page->satuansediaan->editAttributes() ?>>
        <?= $Page->satuansediaan->selectOptionListHtml("x_satuansediaan") ?>
    </select>
    <?= $Page->satuansediaan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->satuansediaan->getErrorMessage() ?></div>
<?= $Page->satuansediaan->Lookup->getParamTag($Page, "p_x_satuansediaan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_satuansediaan']"),
        options = { name: "x_satuansediaan", selectId: "npd_x_satuansediaan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.satuansediaan.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <div id="r_bentuk" class="form-group row">
        <label id="elh_npd_bentuk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_bentuk"><?= $Page->bentuk->caption() ?><?= $Page->bentuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuk->cellAttributes() ?>>
<template id="tpx_npd_bentuk"><span id="el_npd_bentuk">
<template id="tp_x_bentuk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_bentuk" name="x_bentuk" id="x_bentuk"<?= $Page->bentuk->editAttributes() ?>>
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
    data-table="npd"
    data-field="x_bentuk"
    data-page="1"
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
        <label id="elh_npd_viskositas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_viskositas"><?= $Page->viskositas->caption() ?><?= $Page->viskositas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositas->cellAttributes() ?>>
<template id="tpx_npd_viskositas"><span id="el_npd_viskositas">
<template id="tp_x_viskositas">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_viskositas" name="x_viskositas" id="x_viskositas"<?= $Page->viskositas->editAttributes() ?>>
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
    data-table="npd"
    data-field="x_viskositas"
    data-page="1"
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
        <label id="elh_npd_warna" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_warna"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<template id="tpx_npd_warna"><span id="el_npd_warna">
<template id="tp_x_warna">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_warna" name="x_warna" id="x_warna"<?= $Page->warna->editAttributes() ?>>
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
    data-table="npd"
    data-field="x_warna"
    data-page="1"
    data-value-separator="<?= $Page->warna->displayValueSeparatorAttribute() ?>"
    <?= $Page->warna->editAttributes() ?>>
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
<?= $Page->warna->Lookup->getParamTag($Page, "p_x_warna") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <div id="r_parfum" class="form-group row">
        <label id="elh_npd_parfum" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_parfum"><?= $Page->parfum->caption() ?><?= $Page->parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parfum->cellAttributes() ?>>
<template id="tpx_npd_parfum"><span id="el_npd_parfum">
<template id="tp_x_parfum">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_parfum" name="x_parfum" id="x_parfum"<?= $Page->parfum->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_parfum" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_parfum"
    name="x_parfum"
    value="<?= HtmlEncode($Page->parfum->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_parfum"
    data-target="dsl_x_parfum"
    data-repeatcolumn="4"
    class="form-control<?= $Page->parfum->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_parfum"
    data-page="1"
    data-value-separator="<?= $Page->parfum->displayValueSeparatorAttribute() ?>"
    <?= $Page->parfum->editAttributes() ?>>
<?= $Page->parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parfum->getErrorMessage() ?></div>
<?= $Page->parfum->Lookup->getParamTag($Page, "p_x_parfum") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasi->Visible) { // aplikasi ?>
    <div id="r_aplikasi" class="form-group row">
        <label id="elh_npd_aplikasi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_aplikasi"><?= $Page->aplikasi->caption() ?><?= $Page->aplikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasi->cellAttributes() ?>>
<template id="tpx_npd_aplikasi"><span id="el_npd_aplikasi">
<template id="tp_x_aplikasi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_aplikasi" name="x_aplikasi" id="x_aplikasi"<?= $Page->aplikasi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aplikasi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aplikasi"
    name="x_aplikasi"
    value="<?= HtmlEncode($Page->aplikasi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_aplikasi"
    data-target="dsl_x_aplikasi"
    data-repeatcolumn="4"
    class="form-control<?= $Page->aplikasi->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_aplikasi"
    data-page="1"
    data-value-separator="<?= $Page->aplikasi->displayValueSeparatorAttribute() ?>"
    <?= $Page->aplikasi->editAttributes() ?>>
<?= $Page->aplikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasi->getErrorMessage() ?></div>
<?= $Page->aplikasi->Lookup->getParamTag($Page, "p_x_aplikasi") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estetika->Visible) { // estetika ?>
    <div id="r_estetika" class="form-group row">
        <label id="elh_npd_estetika" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_estetika"><?= $Page->estetika->caption() ?><?= $Page->estetika->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estetika->cellAttributes() ?>>
<template id="tpx_npd_estetika"><span id="el_npd_estetika">
<template id="tp_x_estetika">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_estetika" name="x_estetika" id="x_estetika"<?= $Page->estetika->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_estetika" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_estetika"
    name="x_estetika"
    value="<?= HtmlEncode($Page->estetika->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_estetika"
    data-target="dsl_x_estetika"
    data-repeatcolumn="4"
    class="form-control<?= $Page->estetika->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_estetika"
    data-page="1"
    data-value-separator="<?= $Page->estetika->displayValueSeparatorAttribute() ?>"
    <?= $Page->estetika->editAttributes() ?>>
<?= $Page->estetika->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estetika->getErrorMessage() ?></div>
<?= $Page->estetika->Lookup->getParamTag($Page, "p_x_estetika") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <div id="r_tambahan" class="form-group row">
        <label id="elh_npd_tambahan" for="x_tambahan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_tambahan"><?= $Page->tambahan->caption() ?><?= $Page->tambahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tambahan->cellAttributes() ?>>
<template id="tpx_npd_tambahan"><span id="el_npd_tambahan">
<textarea data-table="npd" data-field="x_tambahan" data-page="1" name="x_tambahan" id="x_tambahan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->tambahan->getPlaceHolder()) ?>"<?= $Page->tambahan->editAttributes() ?> aria-describedby="x_tambahan_help"><?= $Page->tambahan->EditValue ?></textarea>
<?= $Page->tambahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tambahan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukurankemasan->Visible) { // ukurankemasan ?>
    <div id="r_ukurankemasan" class="form-group row">
        <label id="elh_npd_ukurankemasan" for="x_ukurankemasan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_ukurankemasan"><?= $Page->ukurankemasan->caption() ?><?= $Page->ukurankemasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukurankemasan->cellAttributes() ?>>
<template id="tpx_npd_ukurankemasan"><span id="el_npd_ukurankemasan">
<input type="<?= $Page->ukurankemasan->getInputTextType() ?>" data-table="npd" data-field="x_ukurankemasan" data-page="1" name="x_ukurankemasan" id="x_ukurankemasan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ukurankemasan->getPlaceHolder()) ?>" value="<?= $Page->ukurankemasan->EditValue ?>"<?= $Page->ukurankemasan->editAttributes() ?> aria-describedby="x_ukurankemasan_help">
<?= $Page->ukurankemasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukurankemasan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuankemasan->Visible) { // satuankemasan ?>
    <div id="r_satuankemasan" class="form-group row">
        <label id="elh_npd_satuankemasan" for="x_satuankemasan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_satuankemasan"><?= $Page->satuankemasan->caption() ?><?= $Page->satuankemasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->satuankemasan->cellAttributes() ?>>
<template id="tpx_npd_satuankemasan"><span id="el_npd_satuankemasan">
    <select
        id="x_satuankemasan"
        name="x_satuankemasan"
        class="form-control ew-select<?= $Page->satuankemasan->isInvalidClass() ?>"
        data-select2-id="npd_x_satuankemasan"
        data-table="npd"
        data-field="x_satuankemasan"
        data-page="1"
        data-value-separator="<?= $Page->satuankemasan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->satuankemasan->getPlaceHolder()) ?>"
        <?= $Page->satuankemasan->editAttributes() ?>>
        <?= $Page->satuankemasan->selectOptionListHtml("x_satuankemasan") ?>
    </select>
    <?= $Page->satuankemasan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->satuankemasan->getErrorMessage() ?></div>
<?= $Page->satuankemasan->Lookup->getParamTag($Page, "p_x_satuankemasan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_satuankemasan']"),
        options = { name: "x_satuankemasan", selectId: "npd_x_satuankemasan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.satuankemasan.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasanwadah->Visible) { // kemasanwadah ?>
    <div id="r_kemasanwadah" class="form-group row">
        <label id="elh_npd_kemasanwadah" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kemasanwadah"><?= $Page->kemasanwadah->caption() ?><?= $Page->kemasanwadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanwadah->cellAttributes() ?>>
<template id="tpx_npd_kemasanwadah"><span id="el_npd_kemasanwadah">
<template id="tp_x_kemasanwadah">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_kemasanwadah" name="x_kemasanwadah" id="x_kemasanwadah"<?= $Page->kemasanwadah->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kemasanwadah" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kemasanwadah"
    name="x_kemasanwadah"
    value="<?= HtmlEncode($Page->kemasanwadah->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_kemasanwadah"
    data-target="dsl_x_kemasanwadah"
    data-repeatcolumn="4"
    class="form-control<?= $Page->kemasanwadah->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kemasanwadah"
    data-page="1"
    data-value-separator="<?= $Page->kemasanwadah->displayValueSeparatorAttribute() ?>"
    <?= $Page->kemasanwadah->editAttributes() ?>>
<?= $Page->kemasanwadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasanwadah->getErrorMessage() ?></div>
<?= $Page->kemasanwadah->Lookup->getParamTag($Page, "p_x_kemasanwadah") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
    <div id="r_kemasantutup" class="form-group row">
        <label id="elh_npd_kemasantutup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kemasantutup"><?= $Page->kemasantutup->caption() ?><?= $Page->kemasantutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasantutup->cellAttributes() ?>>
<template id="tpx_npd_kemasantutup"><span id="el_npd_kemasantutup">
<template id="tp_x_kemasantutup">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_kemasantutup" name="x_kemasantutup" id="x_kemasantutup"<?= $Page->kemasantutup->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kemasantutup" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kemasantutup"
    name="x_kemasantutup"
    value="<?= HtmlEncode($Page->kemasantutup->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_kemasantutup"
    data-target="dsl_x_kemasantutup"
    data-repeatcolumn="4"
    class="form-control<?= $Page->kemasantutup->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kemasantutup"
    data-page="1"
    data-value-separator="<?= $Page->kemasantutup->displayValueSeparatorAttribute() ?>"
    <?= $Page->kemasantutup->editAttributes() ?>>
<?= $Page->kemasantutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasantutup->getErrorMessage() ?></div>
<?= $Page->kemasantutup->Lookup->getParamTag($Page, "p_x_kemasantutup") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasancatatan->Visible) { // kemasancatatan ?>
    <div id="r_kemasancatatan" class="form-group row">
        <label id="elh_npd_kemasancatatan" for="x_kemasancatatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kemasancatatan"><?= $Page->kemasancatatan->caption() ?><?= $Page->kemasancatatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasancatatan->cellAttributes() ?>>
<template id="tpx_npd_kemasancatatan"><span id="el_npd_kemasancatatan">
<textarea data-table="npd" data-field="x_kemasancatatan" data-page="1" name="x_kemasancatatan" id="x_kemasancatatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->kemasancatatan->getPlaceHolder()) ?>"<?= $Page->kemasancatatan->editAttributes() ?> aria-describedby="x_kemasancatatan_help"><?= $Page->kemasancatatan->EditValue ?></textarea>
<?= $Page->kemasancatatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasancatatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukurankemasansekunder->Visible) { // ukurankemasansekunder ?>
    <div id="r_ukurankemasansekunder" class="form-group row">
        <label id="elh_npd_ukurankemasansekunder" for="x_ukurankemasansekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_ukurankemasansekunder"><?= $Page->ukurankemasansekunder->caption() ?><?= $Page->ukurankemasansekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukurankemasansekunder->cellAttributes() ?>>
<template id="tpx_npd_ukurankemasansekunder"><span id="el_npd_ukurankemasansekunder">
<input type="<?= $Page->ukurankemasansekunder->getInputTextType() ?>" data-table="npd" data-field="x_ukurankemasansekunder" data-page="1" name="x_ukurankemasansekunder" id="x_ukurankemasansekunder" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukurankemasansekunder->getPlaceHolder()) ?>" value="<?= $Page->ukurankemasansekunder->EditValue ?>"<?= $Page->ukurankemasansekunder->editAttributes() ?> aria-describedby="x_ukurankemasansekunder_help">
<?= $Page->ukurankemasansekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukurankemasansekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuankemasansekunder->Visible) { // satuankemasansekunder ?>
    <div id="r_satuankemasansekunder" class="form-group row">
        <label id="elh_npd_satuankemasansekunder" for="x_satuankemasansekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_satuankemasansekunder"><?= $Page->satuankemasansekunder->caption() ?><?= $Page->satuankemasansekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->satuankemasansekunder->cellAttributes() ?>>
<template id="tpx_npd_satuankemasansekunder"><span id="el_npd_satuankemasansekunder">
    <select
        id="x_satuankemasansekunder"
        name="x_satuankemasansekunder"
        class="form-control ew-select<?= $Page->satuankemasansekunder->isInvalidClass() ?>"
        data-select2-id="npd_x_satuankemasansekunder"
        data-table="npd"
        data-field="x_satuankemasansekunder"
        data-page="1"
        data-value-separator="<?= $Page->satuankemasansekunder->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->satuankemasansekunder->getPlaceHolder()) ?>"
        <?= $Page->satuankemasansekunder->editAttributes() ?>>
        <?= $Page->satuankemasansekunder->selectOptionListHtml("x_satuankemasansekunder") ?>
    </select>
    <?= $Page->satuankemasansekunder->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->satuankemasansekunder->getErrorMessage() ?></div>
<?= $Page->satuankemasansekunder->Lookup->getParamTag($Page, "p_x_satuankemasansekunder") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_satuankemasansekunder']"),
        options = { name: "x_satuankemasansekunder", selectId: "npd_x_satuankemasansekunder", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.satuankemasansekunder.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasanbahan->Visible) { // kemasanbahan ?>
    <div id="r_kemasanbahan" class="form-group row">
        <label id="elh_npd_kemasanbahan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kemasanbahan"><?= $Page->kemasanbahan->caption() ?><?= $Page->kemasanbahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanbahan->cellAttributes() ?>>
<template id="tpx_npd_kemasanbahan"><span id="el_npd_kemasanbahan">
<template id="tp_x_kemasanbahan">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_kemasanbahan" name="x_kemasanbahan" id="x_kemasanbahan"<?= $Page->kemasanbahan->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kemasanbahan" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kemasanbahan"
    name="x_kemasanbahan"
    value="<?= HtmlEncode($Page->kemasanbahan->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_kemasanbahan"
    data-target="dsl_x_kemasanbahan"
    data-repeatcolumn="4"
    class="form-control<?= $Page->kemasanbahan->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kemasanbahan"
    data-page="1"
    data-value-separator="<?= $Page->kemasanbahan->displayValueSeparatorAttribute() ?>"
    <?= $Page->kemasanbahan->editAttributes() ?>>
<?= $Page->kemasanbahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasanbahan->getErrorMessage() ?></div>
<?= $Page->kemasanbahan->Lookup->getParamTag($Page, "p_x_kemasanbahan") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasanbentuk->Visible) { // kemasanbentuk ?>
    <div id="r_kemasanbentuk" class="form-group row">
        <label id="elh_npd_kemasanbentuk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kemasanbentuk"><?= $Page->kemasanbentuk->caption() ?><?= $Page->kemasanbentuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanbentuk->cellAttributes() ?>>
<template id="tpx_npd_kemasanbentuk"><span id="el_npd_kemasanbentuk">
<template id="tp_x_kemasanbentuk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_kemasanbentuk" name="x_kemasanbentuk" id="x_kemasanbentuk"<?= $Page->kemasanbentuk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kemasanbentuk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kemasanbentuk"
    name="x_kemasanbentuk"
    value="<?= HtmlEncode($Page->kemasanbentuk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_kemasanbentuk"
    data-target="dsl_x_kemasanbentuk"
    data-repeatcolumn="4"
    class="form-control<?= $Page->kemasanbentuk->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kemasanbentuk"
    data-page="1"
    data-value-separator="<?= $Page->kemasanbentuk->displayValueSeparatorAttribute() ?>"
    <?= $Page->kemasanbentuk->editAttributes() ?>>
<?= $Page->kemasanbentuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasanbentuk->getErrorMessage() ?></div>
<?= $Page->kemasanbentuk->Lookup->getParamTag($Page, "p_x_kemasanbentuk") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasankomposisi->Visible) { // kemasankomposisi ?>
    <div id="r_kemasankomposisi" class="form-group row">
        <label id="elh_npd_kemasankomposisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kemasankomposisi"><?= $Page->kemasankomposisi->caption() ?><?= $Page->kemasankomposisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasankomposisi->cellAttributes() ?>>
<template id="tpx_npd_kemasankomposisi"><span id="el_npd_kemasankomposisi">
<template id="tp_x_kemasankomposisi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_kemasankomposisi" name="x_kemasankomposisi" id="x_kemasankomposisi"<?= $Page->kemasankomposisi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kemasankomposisi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kemasankomposisi"
    name="x_kemasankomposisi"
    value="<?= HtmlEncode($Page->kemasankomposisi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_kemasankomposisi"
    data-target="dsl_x_kemasankomposisi"
    data-repeatcolumn="4"
    class="form-control<?= $Page->kemasankomposisi->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kemasankomposisi"
    data-page="1"
    data-value-separator="<?= $Page->kemasankomposisi->displayValueSeparatorAttribute() ?>"
    <?= $Page->kemasankomposisi->editAttributes() ?>>
<?= $Page->kemasankomposisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasankomposisi->getErrorMessage() ?></div>
<?= $Page->kemasankomposisi->Lookup->getParamTag($Page, "p_x_kemasankomposisi") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasancatatansekunder->Visible) { // kemasancatatansekunder ?>
    <div id="r_kemasancatatansekunder" class="form-group row">
        <label id="elh_npd_kemasancatatansekunder" for="x_kemasancatatansekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_kemasancatatansekunder"><?= $Page->kemasancatatansekunder->caption() ?><?= $Page->kemasancatatansekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasancatatansekunder->cellAttributes() ?>>
<template id="tpx_npd_kemasancatatansekunder"><span id="el_npd_kemasancatatansekunder">
<textarea data-table="npd" data-field="x_kemasancatatansekunder" data-page="1" name="x_kemasancatatansekunder" id="x_kemasancatatansekunder" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->kemasancatatansekunder->getPlaceHolder()) ?>"<?= $Page->kemasancatatansekunder->editAttributes() ?> aria-describedby="x_kemasancatatansekunder_help"><?= $Page->kemasancatatansekunder->EditValue ?></textarea>
<?= $Page->kemasancatatansekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasancatatansekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelbahan->Visible) { // labelbahan ?>
    <div id="r_labelbahan" class="form-group row">
        <label id="elh_npd_labelbahan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labelbahan"><?= $Page->labelbahan->caption() ?><?= $Page->labelbahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelbahan->cellAttributes() ?>>
<template id="tpx_npd_labelbahan"><span id="el_npd_labelbahan">
<template id="tp_x_labelbahan">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_labelbahan" name="x_labelbahan" id="x_labelbahan"<?= $Page->labelbahan->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labelbahan" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labelbahan"
    name="x_labelbahan"
    value="<?= HtmlEncode($Page->labelbahan->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_labelbahan"
    data-target="dsl_x_labelbahan"
    data-repeatcolumn="4"
    class="form-control<?= $Page->labelbahan->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labelbahan"
    data-page="1"
    data-value-separator="<?= $Page->labelbahan->displayValueSeparatorAttribute() ?>"
    <?= $Page->labelbahan->editAttributes() ?>>
<?= $Page->labelbahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelbahan->getErrorMessage() ?></div>
<?= $Page->labelbahan->Lookup->getParamTag($Page, "p_x_labelbahan") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
    <div id="r_labelkualitas" class="form-group row">
        <label id="elh_npd_labelkualitas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labelkualitas"><?= $Page->labelkualitas->caption() ?><?= $Page->labelkualitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelkualitas->cellAttributes() ?>>
<template id="tpx_npd_labelkualitas"><span id="el_npd_labelkualitas">
<template id="tp_x_labelkualitas">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_labelkualitas" name="x_labelkualitas" id="x_labelkualitas"<?= $Page->labelkualitas->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labelkualitas" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labelkualitas"
    name="x_labelkualitas"
    value="<?= HtmlEncode($Page->labelkualitas->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_labelkualitas"
    data-target="dsl_x_labelkualitas"
    data-repeatcolumn="4"
    class="form-control<?= $Page->labelkualitas->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labelkualitas"
    data-page="1"
    data-value-separator="<?= $Page->labelkualitas->displayValueSeparatorAttribute() ?>"
    <?= $Page->labelkualitas->editAttributes() ?>>
<?= $Page->labelkualitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelkualitas->getErrorMessage() ?></div>
<?= $Page->labelkualitas->Lookup->getParamTag($Page, "p_x_labelkualitas") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
    <div id="r_labelposisi" class="form-group row">
        <label id="elh_npd_labelposisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labelposisi"><?= $Page->labelposisi->caption() ?><?= $Page->labelposisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelposisi->cellAttributes() ?>>
<template id="tpx_npd_labelposisi"><span id="el_npd_labelposisi">
<template id="tp_x_labelposisi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_labelposisi" name="x_labelposisi" id="x_labelposisi"<?= $Page->labelposisi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labelposisi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labelposisi"
    name="x_labelposisi"
    value="<?= HtmlEncode($Page->labelposisi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_labelposisi"
    data-target="dsl_x_labelposisi"
    data-repeatcolumn="4"
    class="form-control<?= $Page->labelposisi->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labelposisi"
    data-page="1"
    data-value-separator="<?= $Page->labelposisi->displayValueSeparatorAttribute() ?>"
    <?= $Page->labelposisi->editAttributes() ?>>
<?= $Page->labelposisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelposisi->getErrorMessage() ?></div>
<?= $Page->labelposisi->Lookup->getParamTag($Page, "p_x_labelposisi") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelcatatan->Visible) { // labelcatatan ?>
    <div id="r_labelcatatan" class="form-group row">
        <label id="elh_npd_labelcatatan" for="x_labelcatatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labelcatatan"><?= $Page->labelcatatan->caption() ?><?= $Page->labelcatatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelcatatan->cellAttributes() ?>>
<template id="tpx_npd_labelcatatan"><span id="el_npd_labelcatatan">
<textarea data-table="npd" data-field="x_labelcatatan" data-page="1" name="x_labelcatatan" id="x_labelcatatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->labelcatatan->getPlaceHolder()) ?>"<?= $Page->labelcatatan->editAttributes() ?> aria-describedby="x_labelcatatan_help"><?= $Page->labelcatatan->EditValue ?></textarea>
<?= $Page->labelcatatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelcatatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labeltekstur->Visible) { // labeltekstur ?>
    <div id="r_labeltekstur" class="form-group row">
        <label id="elh_npd_labeltekstur" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labeltekstur"><?= $Page->labeltekstur->caption() ?><?= $Page->labeltekstur->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labeltekstur->cellAttributes() ?>>
<template id="tpx_npd_labeltekstur"><span id="el_npd_labeltekstur">
<template id="tp_x_labeltekstur">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_labeltekstur" name="x_labeltekstur" id="x_labeltekstur"<?= $Page->labeltekstur->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labeltekstur" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labeltekstur"
    name="x_labeltekstur"
    value="<?= HtmlEncode($Page->labeltekstur->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_labeltekstur"
    data-target="dsl_x_labeltekstur"
    data-repeatcolumn="4"
    class="form-control<?= $Page->labeltekstur->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labeltekstur"
    data-page="1"
    data-value-separator="<?= $Page->labeltekstur->displayValueSeparatorAttribute() ?>"
    <?= $Page->labeltekstur->editAttributes() ?>>
<?= $Page->labeltekstur->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labeltekstur->getErrorMessage() ?></div>
<?= $Page->labeltekstur->Lookup->getParamTag($Page, "p_x_labeltekstur") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelprint->Visible) { // labelprint ?>
    <div id="r_labelprint" class="form-group row">
        <label id="elh_npd_labelprint" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labelprint"><?= $Page->labelprint->caption() ?><?= $Page->labelprint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelprint->cellAttributes() ?>>
<template id="tpx_npd_labelprint"><span id="el_npd_labelprint">
<template id="tp_x_labelprint">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd" data-field="x_labelprint" name="x_labelprint" id="x_labelprint"<?= $Page->labelprint->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labelprint" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labelprint"
    name="x_labelprint"
    value="<?= HtmlEncode($Page->labelprint->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_labelprint"
    data-target="dsl_x_labelprint"
    data-repeatcolumn="4"
    class="form-control<?= $Page->labelprint->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labelprint"
    data-page="1"
    data-value-separator="<?= $Page->labelprint->displayValueSeparatorAttribute() ?>"
    <?= $Page->labelprint->editAttributes() ?>>
<?= $Page->labelprint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelprint->getErrorMessage() ?></div>
<?= $Page->labelprint->Lookup->getParamTag($Page, "p_x_labelprint") ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labeljmlwarna->Visible) { // labeljmlwarna ?>
    <div id="r_labeljmlwarna" class="form-group row">
        <label id="elh_npd_labeljmlwarna" for="x_labeljmlwarna" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labeljmlwarna"><?= $Page->labeljmlwarna->caption() ?><?= $Page->labeljmlwarna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labeljmlwarna->cellAttributes() ?>>
<template id="tpx_npd_labeljmlwarna"><span id="el_npd_labeljmlwarna">
<input type="<?= $Page->labeljmlwarna->getInputTextType() ?>" data-table="npd" data-field="x_labeljmlwarna" data-page="1" name="x_labeljmlwarna" id="x_labeljmlwarna" placeholder="<?= HtmlEncode($Page->labeljmlwarna->getPlaceHolder()) ?>" value="<?= $Page->labeljmlwarna->EditValue ?>"<?= $Page->labeljmlwarna->editAttributes() ?> aria-describedby="x_labeljmlwarna_help">
<?= $Page->labeljmlwarna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labeljmlwarna->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelcatatanhotprint->Visible) { // labelcatatanhotprint ?>
    <div id="r_labelcatatanhotprint" class="form-group row">
        <label id="elh_npd_labelcatatanhotprint" for="x_labelcatatanhotprint" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_labelcatatanhotprint"><?= $Page->labelcatatanhotprint->caption() ?><?= $Page->labelcatatanhotprint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelcatatanhotprint->cellAttributes() ?>>
<template id="tpx_npd_labelcatatanhotprint"><span id="el_npd_labelcatatanhotprint">
<textarea data-table="npd" data-field="x_labelcatatanhotprint" data-page="1" name="x_labelcatatanhotprint" id="x_labelcatatanhotprint" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->labelcatatanhotprint->getPlaceHolder()) ?>"<?= $Page->labelcatatanhotprint->editAttributes() ?> aria-describedby="x_labelcatatanhotprint_help"><?= $Page->labelcatatanhotprint->EditValue ?></textarea>
<?= $Page->labelcatatanhotprint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelcatatanhotprint->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
    <div id="r_ukuran_utama" class="form-group row">
        <label id="elh_npd_ukuran_utama" for="x_ukuran_utama" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_ukuran_utama"><?= $Page->ukuran_utama->caption() ?><?= $Page->ukuran_utama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran_utama->cellAttributes() ?>>
<template id="tpx_npd_ukuran_utama"><span id="el_npd_ukuran_utama">
<input type="<?= $Page->ukuran_utama->getInputTextType() ?>" data-table="npd" data-field="x_ukuran_utama" data-page="1" name="x_ukuran_utama" id="x_ukuran_utama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran_utama->getPlaceHolder()) ?>" value="<?= $Page->ukuran_utama->EditValue ?>"<?= $Page->ukuran_utama->editAttributes() ?> aria-describedby="x_ukuran_utama_help">
<?= $Page->ukuran_utama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran_utama->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
    <div id="r_utama_harga_isi" class="form-group row">
        <label id="elh_npd_utama_harga_isi" for="x_utama_harga_isi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_isi"><?= $Page->utama_harga_isi->caption() ?><?= $Page->utama_harga_isi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_isi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_isi"><span id="el_npd_utama_harga_isi">
<input type="<?= $Page->utama_harga_isi->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_isi" data-page="1" name="x_utama_harga_isi" id="x_utama_harga_isi" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_isi->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_isi->EditValue ?>"<?= $Page->utama_harga_isi->editAttributes() ?> aria-describedby="x_utama_harga_isi_help">
<?= $Page->utama_harga_isi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_isi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_isi_proyeksi->Visible) { // utama_harga_isi_proyeksi ?>
    <div id="r_utama_harga_isi_proyeksi" class="form-group row">
        <label id="elh_npd_utama_harga_isi_proyeksi" for="x_utama_harga_isi_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_isi_proyeksi"><?= $Page->utama_harga_isi_proyeksi->caption() ?><?= $Page->utama_harga_isi_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_isi_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_isi_proyeksi"><span id="el_npd_utama_harga_isi_proyeksi">
<input type="<?= $Page->utama_harga_isi_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_isi_proyeksi" data-page="1" name="x_utama_harga_isi_proyeksi" id="x_utama_harga_isi_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_isi_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_isi_proyeksi->EditValue ?>"<?= $Page->utama_harga_isi_proyeksi->editAttributes() ?> aria-describedby="x_utama_harga_isi_proyeksi_help">
<?= $Page->utama_harga_isi_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_isi_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
    <div id="r_utama_harga_primer" class="form-group row">
        <label id="elh_npd_utama_harga_primer" for="x_utama_harga_primer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_primer"><?= $Page->utama_harga_primer->caption() ?><?= $Page->utama_harga_primer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_primer->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_primer"><span id="el_npd_utama_harga_primer">
<input type="<?= $Page->utama_harga_primer->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_primer" data-page="1" name="x_utama_harga_primer" id="x_utama_harga_primer" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_primer->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_primer->EditValue ?>"<?= $Page->utama_harga_primer->editAttributes() ?> aria-describedby="x_utama_harga_primer_help">
<?= $Page->utama_harga_primer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_primer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_primer_proyeksi->Visible) { // utama_harga_primer_proyeksi ?>
    <div id="r_utama_harga_primer_proyeksi" class="form-group row">
        <label id="elh_npd_utama_harga_primer_proyeksi" for="x_utama_harga_primer_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_primer_proyeksi"><?= $Page->utama_harga_primer_proyeksi->caption() ?><?= $Page->utama_harga_primer_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_primer_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_primer_proyeksi"><span id="el_npd_utama_harga_primer_proyeksi">
<input type="<?= $Page->utama_harga_primer_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_primer_proyeksi" data-page="1" name="x_utama_harga_primer_proyeksi" id="x_utama_harga_primer_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_primer_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_primer_proyeksi->EditValue ?>"<?= $Page->utama_harga_primer_proyeksi->editAttributes() ?> aria-describedby="x_utama_harga_primer_proyeksi_help">
<?= $Page->utama_harga_primer_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_primer_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
    <div id="r_utama_harga_sekunder" class="form-group row">
        <label id="elh_npd_utama_harga_sekunder" for="x_utama_harga_sekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_sekunder"><?= $Page->utama_harga_sekunder->caption() ?><?= $Page->utama_harga_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_sekunder->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_sekunder"><span id="el_npd_utama_harga_sekunder">
<input type="<?= $Page->utama_harga_sekunder->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_sekunder" data-page="1" name="x_utama_harga_sekunder" id="x_utama_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_sekunder->EditValue ?>"<?= $Page->utama_harga_sekunder->editAttributes() ?> aria-describedby="x_utama_harga_sekunder_help">
<?= $Page->utama_harga_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_sekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_proyeksi->Visible) { // utama_harga_sekunder_proyeksi ?>
    <div id="r_utama_harga_sekunder_proyeksi" class="form-group row">
        <label id="elh_npd_utama_harga_sekunder_proyeksi" for="x_utama_harga_sekunder_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_sekunder_proyeksi"><?= $Page->utama_harga_sekunder_proyeksi->caption() ?><?= $Page->utama_harga_sekunder_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_sekunder_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_sekunder_proyeksi"><span id="el_npd_utama_harga_sekunder_proyeksi">
<input type="<?= $Page->utama_harga_sekunder_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_sekunder_proyeksi" data-page="1" name="x_utama_harga_sekunder_proyeksi" id="x_utama_harga_sekunder_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_sekunder_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_sekunder_proyeksi->EditValue ?>"<?= $Page->utama_harga_sekunder_proyeksi->editAttributes() ?> aria-describedby="x_utama_harga_sekunder_proyeksi_help">
<?= $Page->utama_harga_sekunder_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_sekunder_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
    <div id="r_utama_harga_label" class="form-group row">
        <label id="elh_npd_utama_harga_label" for="x_utama_harga_label" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_label"><?= $Page->utama_harga_label->caption() ?><?= $Page->utama_harga_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_label->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_label"><span id="el_npd_utama_harga_label">
<input type="<?= $Page->utama_harga_label->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_label" data-page="1" name="x_utama_harga_label" id="x_utama_harga_label" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_label->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_label->EditValue ?>"<?= $Page->utama_harga_label->editAttributes() ?> aria-describedby="x_utama_harga_label_help">
<?= $Page->utama_harga_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_label->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_label_proyeksi->Visible) { // utama_harga_label_proyeksi ?>
    <div id="r_utama_harga_label_proyeksi" class="form-group row">
        <label id="elh_npd_utama_harga_label_proyeksi" for="x_utama_harga_label_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_label_proyeksi"><?= $Page->utama_harga_label_proyeksi->caption() ?><?= $Page->utama_harga_label_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_label_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_label_proyeksi"><span id="el_npd_utama_harga_label_proyeksi">
<input type="<?= $Page->utama_harga_label_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_label_proyeksi" data-page="1" name="x_utama_harga_label_proyeksi" id="x_utama_harga_label_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_label_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_label_proyeksi->EditValue ?>"<?= $Page->utama_harga_label_proyeksi->editAttributes() ?> aria-describedby="x_utama_harga_label_proyeksi_help">
<?= $Page->utama_harga_label_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_label_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
    <div id="r_utama_harga_total" class="form-group row">
        <label id="elh_npd_utama_harga_total" for="x_utama_harga_total" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_total"><?= $Page->utama_harga_total->caption() ?><?= $Page->utama_harga_total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_total->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_total"><span id="el_npd_utama_harga_total">
<input type="<?= $Page->utama_harga_total->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_total" data-page="1" name="x_utama_harga_total" id="x_utama_harga_total" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_total->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_total->EditValue ?>"<?= $Page->utama_harga_total->editAttributes() ?> aria-describedby="x_utama_harga_total_help">
<?= $Page->utama_harga_total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_total->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_total_proyeksi->Visible) { // utama_harga_total_proyeksi ?>
    <div id="r_utama_harga_total_proyeksi" class="form-group row">
        <label id="elh_npd_utama_harga_total_proyeksi" for="x_utama_harga_total_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_utama_harga_total_proyeksi"><?= $Page->utama_harga_total_proyeksi->caption() ?><?= $Page->utama_harga_total_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_total_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_utama_harga_total_proyeksi"><span id="el_npd_utama_harga_total_proyeksi">
<input type="<?= $Page->utama_harga_total_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_utama_harga_total_proyeksi" data-page="1" name="x_utama_harga_total_proyeksi" id="x_utama_harga_total_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_total_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_total_proyeksi->EditValue ?>"<?= $Page->utama_harga_total_proyeksi->editAttributes() ?> aria-describedby="x_utama_harga_total_proyeksi_help">
<?= $Page->utama_harga_total_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_total_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
    <div id="r_ukuran_lain" class="form-group row">
        <label id="elh_npd_ukuran_lain" for="x_ukuran_lain" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_ukuran_lain"><?= $Page->ukuran_lain->caption() ?><?= $Page->ukuran_lain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran_lain->cellAttributes() ?>>
<template id="tpx_npd_ukuran_lain"><span id="el_npd_ukuran_lain">
<input type="<?= $Page->ukuran_lain->getInputTextType() ?>" data-table="npd" data-field="x_ukuran_lain" data-page="1" name="x_ukuran_lain" id="x_ukuran_lain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran_lain->getPlaceHolder()) ?>" value="<?= $Page->ukuran_lain->EditValue ?>"<?= $Page->ukuran_lain->editAttributes() ?> aria-describedby="x_ukuran_lain_help">
<?= $Page->ukuran_lain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran_lain->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
    <div id="r_lain_harga_isi" class="form-group row">
        <label id="elh_npd_lain_harga_isi" for="x_lain_harga_isi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_isi"><?= $Page->lain_harga_isi->caption() ?><?= $Page->lain_harga_isi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_isi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_isi"><span id="el_npd_lain_harga_isi">
<input type="<?= $Page->lain_harga_isi->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_isi" data-page="1" name="x_lain_harga_isi" id="x_lain_harga_isi" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_isi->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_isi->EditValue ?>"<?= $Page->lain_harga_isi->editAttributes() ?> aria-describedby="x_lain_harga_isi_help">
<?= $Page->lain_harga_isi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_isi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_isi_proyeksi->Visible) { // lain_harga_isi_proyeksi ?>
    <div id="r_lain_harga_isi_proyeksi" class="form-group row">
        <label id="elh_npd_lain_harga_isi_proyeksi" for="x_lain_harga_isi_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_isi_proyeksi"><?= $Page->lain_harga_isi_proyeksi->caption() ?><?= $Page->lain_harga_isi_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_isi_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_isi_proyeksi"><span id="el_npd_lain_harga_isi_proyeksi">
<input type="<?= $Page->lain_harga_isi_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_isi_proyeksi" data-page="1" name="x_lain_harga_isi_proyeksi" id="x_lain_harga_isi_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_isi_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_isi_proyeksi->EditValue ?>"<?= $Page->lain_harga_isi_proyeksi->editAttributes() ?> aria-describedby="x_lain_harga_isi_proyeksi_help">
<?= $Page->lain_harga_isi_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_isi_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
    <div id="r_lain_harga_primer" class="form-group row">
        <label id="elh_npd_lain_harga_primer" for="x_lain_harga_primer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_primer"><?= $Page->lain_harga_primer->caption() ?><?= $Page->lain_harga_primer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_primer->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_primer"><span id="el_npd_lain_harga_primer">
<input type="<?= $Page->lain_harga_primer->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_primer" data-page="1" name="x_lain_harga_primer" id="x_lain_harga_primer" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_primer->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_primer->EditValue ?>"<?= $Page->lain_harga_primer->editAttributes() ?> aria-describedby="x_lain_harga_primer_help">
<?= $Page->lain_harga_primer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_primer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_primer_proyeksi->Visible) { // lain_harga_primer_proyeksi ?>
    <div id="r_lain_harga_primer_proyeksi" class="form-group row">
        <label id="elh_npd_lain_harga_primer_proyeksi" for="x_lain_harga_primer_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_primer_proyeksi"><?= $Page->lain_harga_primer_proyeksi->caption() ?><?= $Page->lain_harga_primer_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_primer_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_primer_proyeksi"><span id="el_npd_lain_harga_primer_proyeksi">
<input type="<?= $Page->lain_harga_primer_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_primer_proyeksi" data-page="1" name="x_lain_harga_primer_proyeksi" id="x_lain_harga_primer_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_primer_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_primer_proyeksi->EditValue ?>"<?= $Page->lain_harga_primer_proyeksi->editAttributes() ?> aria-describedby="x_lain_harga_primer_proyeksi_help">
<?= $Page->lain_harga_primer_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_primer_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
    <div id="r_lain_harga_sekunder" class="form-group row">
        <label id="elh_npd_lain_harga_sekunder" for="x_lain_harga_sekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_sekunder"><?= $Page->lain_harga_sekunder->caption() ?><?= $Page->lain_harga_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_sekunder->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_sekunder"><span id="el_npd_lain_harga_sekunder">
<input type="<?= $Page->lain_harga_sekunder->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_sekunder" data-page="1" name="x_lain_harga_sekunder" id="x_lain_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_sekunder->EditValue ?>"<?= $Page->lain_harga_sekunder->editAttributes() ?> aria-describedby="x_lain_harga_sekunder_help">
<?= $Page->lain_harga_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_sekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_proyeksi->Visible) { // lain_harga_sekunder_proyeksi ?>
    <div id="r_lain_harga_sekunder_proyeksi" class="form-group row">
        <label id="elh_npd_lain_harga_sekunder_proyeksi" for="x_lain_harga_sekunder_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_sekunder_proyeksi"><?= $Page->lain_harga_sekunder_proyeksi->caption() ?><?= $Page->lain_harga_sekunder_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_sekunder_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_sekunder_proyeksi"><span id="el_npd_lain_harga_sekunder_proyeksi">
<input type="<?= $Page->lain_harga_sekunder_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_sekunder_proyeksi" data-page="1" name="x_lain_harga_sekunder_proyeksi" id="x_lain_harga_sekunder_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_sekunder_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_sekunder_proyeksi->EditValue ?>"<?= $Page->lain_harga_sekunder_proyeksi->editAttributes() ?> aria-describedby="x_lain_harga_sekunder_proyeksi_help">
<?= $Page->lain_harga_sekunder_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_sekunder_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
    <div id="r_lain_harga_label" class="form-group row">
        <label id="elh_npd_lain_harga_label" for="x_lain_harga_label" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_label"><?= $Page->lain_harga_label->caption() ?><?= $Page->lain_harga_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_label->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_label"><span id="el_npd_lain_harga_label">
<input type="<?= $Page->lain_harga_label->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_label" data-page="1" name="x_lain_harga_label" id="x_lain_harga_label" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_label->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_label->EditValue ?>"<?= $Page->lain_harga_label->editAttributes() ?> aria-describedby="x_lain_harga_label_help">
<?= $Page->lain_harga_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_label->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_label_proyeksi->Visible) { // lain_harga_label_proyeksi ?>
    <div id="r_lain_harga_label_proyeksi" class="form-group row">
        <label id="elh_npd_lain_harga_label_proyeksi" for="x_lain_harga_label_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_label_proyeksi"><?= $Page->lain_harga_label_proyeksi->caption() ?><?= $Page->lain_harga_label_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_label_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_label_proyeksi"><span id="el_npd_lain_harga_label_proyeksi">
<input type="<?= $Page->lain_harga_label_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_label_proyeksi" data-page="1" name="x_lain_harga_label_proyeksi" id="x_lain_harga_label_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_label_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_label_proyeksi->EditValue ?>"<?= $Page->lain_harga_label_proyeksi->editAttributes() ?> aria-describedby="x_lain_harga_label_proyeksi_help">
<?= $Page->lain_harga_label_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_label_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
    <div id="r_lain_harga_total" class="form-group row">
        <label id="elh_npd_lain_harga_total" for="x_lain_harga_total" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_total"><?= $Page->lain_harga_total->caption() ?><?= $Page->lain_harga_total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_total->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_total"><span id="el_npd_lain_harga_total">
<input type="<?= $Page->lain_harga_total->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_total" data-page="1" name="x_lain_harga_total" id="x_lain_harga_total" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_total->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_total->EditValue ?>"<?= $Page->lain_harga_total->editAttributes() ?> aria-describedby="x_lain_harga_total_help">
<?= $Page->lain_harga_total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_total->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_total_proyeksi->Visible) { // lain_harga_total_proyeksi ?>
    <div id="r_lain_harga_total_proyeksi" class="form-group row">
        <label id="elh_npd_lain_harga_total_proyeksi" for="x_lain_harga_total_proyeksi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_lain_harga_total_proyeksi"><?= $Page->lain_harga_total_proyeksi->caption() ?><?= $Page->lain_harga_total_proyeksi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_total_proyeksi->cellAttributes() ?>>
<template id="tpx_npd_lain_harga_total_proyeksi"><span id="el_npd_lain_harga_total_proyeksi">
<input type="<?= $Page->lain_harga_total_proyeksi->getInputTextType() ?>" data-table="npd" data-field="x_lain_harga_total_proyeksi" data-page="1" name="x_lain_harga_total_proyeksi" id="x_lain_harga_total_proyeksi" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_total_proyeksi->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_total_proyeksi->EditValue ?>"<?= $Page->lain_harga_total_proyeksi->editAttributes() ?> aria-describedby="x_lain_harga_total_proyeksi_help">
<?= $Page->lain_harga_total_proyeksi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_total_proyeksi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
    <div id="r_delivery_pickup" class="form-group row">
        <label id="elh_npd_delivery_pickup" for="x_delivery_pickup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_delivery_pickup"><?= $Page->delivery_pickup->caption() ?><?= $Page->delivery_pickup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_pickup->cellAttributes() ?>>
<template id="tpx_npd_delivery_pickup"><span id="el_npd_delivery_pickup">
<input type="<?= $Page->delivery_pickup->getInputTextType() ?>" data-table="npd" data-field="x_delivery_pickup" data-page="1" name="x_delivery_pickup" id="x_delivery_pickup" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_pickup->getPlaceHolder()) ?>" value="<?= $Page->delivery_pickup->EditValue ?>"<?= $Page->delivery_pickup->editAttributes() ?> aria-describedby="x_delivery_pickup_help">
<?= $Page->delivery_pickup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_pickup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
    <div id="r_delivery_singlepoint" class="form-group row">
        <label id="elh_npd_delivery_singlepoint" for="x_delivery_singlepoint" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_delivery_singlepoint"><?= $Page->delivery_singlepoint->caption() ?><?= $Page->delivery_singlepoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_singlepoint->cellAttributes() ?>>
<template id="tpx_npd_delivery_singlepoint"><span id="el_npd_delivery_singlepoint">
<input type="<?= $Page->delivery_singlepoint->getInputTextType() ?>" data-table="npd" data-field="x_delivery_singlepoint" data-page="1" name="x_delivery_singlepoint" id="x_delivery_singlepoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_singlepoint->getPlaceHolder()) ?>" value="<?= $Page->delivery_singlepoint->EditValue ?>"<?= $Page->delivery_singlepoint->editAttributes() ?> aria-describedby="x_delivery_singlepoint_help">
<?= $Page->delivery_singlepoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_singlepoint->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
    <div id="r_delivery_multipoint" class="form-group row">
        <label id="elh_npd_delivery_multipoint" for="x_delivery_multipoint" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_delivery_multipoint"><?= $Page->delivery_multipoint->caption() ?><?= $Page->delivery_multipoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_multipoint->cellAttributes() ?>>
<template id="tpx_npd_delivery_multipoint"><span id="el_npd_delivery_multipoint">
<input type="<?= $Page->delivery_multipoint->getInputTextType() ?>" data-table="npd" data-field="x_delivery_multipoint" data-page="1" name="x_delivery_multipoint" id="x_delivery_multipoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_multipoint->getPlaceHolder()) ?>" value="<?= $Page->delivery_multipoint->EditValue ?>"<?= $Page->delivery_multipoint->editAttributes() ?> aria-describedby="x_delivery_multipoint_help">
<?= $Page->delivery_multipoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_multipoint->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_termlain->Visible) { // delivery_termlain ?>
    <div id="r_delivery_termlain" class="form-group row">
        <label id="elh_npd_delivery_termlain" for="x_delivery_termlain" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_delivery_termlain"><?= $Page->delivery_termlain->caption() ?><?= $Page->delivery_termlain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_termlain->cellAttributes() ?>>
<template id="tpx_npd_delivery_termlain"><span id="el_npd_delivery_termlain">
<input type="<?= $Page->delivery_termlain->getInputTextType() ?>" data-table="npd" data-field="x_delivery_termlain" data-page="1" name="x_delivery_termlain" id="x_delivery_termlain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_termlain->getPlaceHolder()) ?>" value="<?= $Page->delivery_termlain->EditValue ?>"<?= $Page->delivery_termlain->editAttributes() ?> aria-describedby="x_delivery_termlain_help">
<?= $Page->delivery_termlain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_termlain->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_npd_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_status"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<template id="tpx_npd_status"><span id="el_npd_status">
    <select
        id="x_status"
        name="x_status"
        class="form-control ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="npd_x_status"
        data-table="npd"
        data-field="x_status"
        data-page="1"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_status']"),
        options = { name: "x_status", selectId: "npd_x_status", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.npd.fields.status.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
    <div id="r_receipt_by" class="form-group row">
        <label id="elh_npd_receipt_by" for="x_receipt_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_receipt_by"><?= $Page->receipt_by->caption() ?><?= $Page->receipt_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->receipt_by->cellAttributes() ?>>
<template id="tpx_npd_receipt_by"><span id="el_npd_receipt_by">
<input type="<?= $Page->receipt_by->getInputTextType() ?>" data-table="npd" data-field="x_receipt_by" data-page="1" name="x_receipt_by" id="x_receipt_by" size="30" placeholder="<?= HtmlEncode($Page->receipt_by->getPlaceHolder()) ?>" value="<?= $Page->receipt_by->EditValue ?>"<?= $Page->receipt_by->editAttributes() ?> aria-describedby="x_receipt_by_help">
<?= $Page->receipt_by->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->receipt_by->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->approve_by->Visible) { // approve_by ?>
    <div id="r_approve_by" class="form-group row">
        <label id="elh_npd_approve_by" for="x_approve_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_approve_by"><?= $Page->approve_by->caption() ?><?= $Page->approve_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->approve_by->cellAttributes() ?>>
<template id="tpx_npd_approve_by"><span id="el_npd_approve_by">
    <select
        id="x_approve_by"
        name="x_approve_by"
        class="form-control ew-select<?= $Page->approve_by->isInvalidClass() ?>"
        data-select2-id="npd_x_approve_by"
        data-table="npd"
        data-field="x_approve_by"
        data-page="1"
        data-value-separator="<?= $Page->approve_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->approve_by->getPlaceHolder()) ?>"
        <?= $Page->approve_by->editAttributes() ?>>
        <?= $Page->approve_by->selectOptionListHtml("x_approve_by") ?>
    </select>
    <?= $Page->approve_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->approve_by->getErrorMessage() ?></div>
<?= $Page->approve_by->Lookup->getParamTag($Page, "p_x_approve_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_approve_by']"),
        options = { name: "x_approve_by", selectId: "npd_x_approve_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.approve_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_npdadd" class="ew-custom-template"></div>
<template id="tpm_npdadd">
<div id="ct_NpdAdd"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-4">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->kodeorder->caption() ?> <i data-phrase="FieldRequiredIndicator" class="fas fa-asterisk ew-required" data-caption=""></i></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_kodeorder"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->nomororder->caption() ?></label>
                    <div class="col-7"><slot class="ew-slot" name="tpx_npd_nomororder"></slot></div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->sifatorder->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_sifatorder"></slot></div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tanggal_order->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_tanggal_order"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->target_selesai->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_target_selesai"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row mb-3">
                    <label class="col-4 col-form-label text-right"><?= $Page->idpegawai->caption() ?></label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_idpegawai"></slot></div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-4 col-form-label text-right"><?= $Page->idcustomer->caption() ?> <i data-phrase="FieldRequiredIndicator" class="fas fa-asterisk ew-required" data-caption=""></i></label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_idcustomer"></slot></div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-4 col-form-label text-right"><?= $Page->idbrand->caption() ?></label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_idbrand"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KONSEP PRODUK</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kategoriproduk->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kategoriproduk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jenisproduk->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_jenisproduk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->fungsiproduk->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_fungsiproduk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kualitasproduk->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kualitasproduk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bahan_campaign->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_bahan_campaign"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">BENTUK SEDIAAN</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->ukuransediaan->caption() ?></label>
                <div class="col-3"><slot class="ew-slot" name="tpx_npd_ukuransediaan"></slot></div>
                <div class="col-1"><slot class="ew-slot" name="tpx_npd_satuansediaan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bentuk->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_bentuk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->viskositas->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_viskositas"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->warna->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_warna"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->parfum->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_parfum"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_aplikasi"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->estetika->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_estetika"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tambahan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_tambahan"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KEMASAN PRIMER</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->ukurankemasan->caption() ?></label>
                <div class="col-3"><slot class="ew-slot" name="tpx_npd_ukurankemasan"></slot></div>
                <div class="col-1"><slot class="ew-slot" name="tpx_npd_satuankemasan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kemasanwadah->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kemasanwadah"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kemasantutup->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kemasantutup"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kemasancatatan->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kemasancatatan"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KEMASAN SEKUNDER</div>
        </div>
        <div class="card-body">
        	<div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->ukurankemasansekunder->caption() ?></label>
                <div class="col-3"><slot class="ew-slot" name="tpx_npd_ukurankemasansekunder"></slot></div>
                <div class="col-1"><slot class="ew-slot" name="tpx_npd_satuankemasansekunder"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kemasanbahan->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kemasanbahan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kemasanbentuk->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kemasanbentuk"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kemasankomposisi->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kemasankomposisi"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kemasancatatansekunder->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_kemasancatatansekunder"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">LABEL STIKER</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labelbahan->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labelbahan"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labelkualitas->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labelkualitas"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labelposisi->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labelposisi"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labelcatatan->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labelcatatan"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">LABEL HOT PRINT</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labeltekstur->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labeltekstur"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labelprint->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labelprint"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labeljmlwarna->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labeljmlwarna"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->labelcatatanhotprint->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_labelcatatanhotprint"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">TARGET HARGA & PROYEKSI</div>
        </div>
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row mb-3">
                    <label class="col-4 col-form-label text-right"><?= $Page->ukuran_utama->caption() ?></label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_ukuran_utama"></slot></div>
                </div>
                <div style="border: 1px solid rgba(0,0,0,.125); padding: 10px 1em 1em; border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-center">Target</label>
                    <label class="col-4 col-form-label text-center">Harga/Pcs</label>
                    <label class="col-4 col-form-label text-center">Proyeksi</label>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Isi</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_isi"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_isi_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Kemasan Primer</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_primer"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_primer_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Kemasan Sekunder</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_sekunder"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_sekunder_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Label</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_label"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_label_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Total</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_total"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_utama_harga_total_proyeksi"></slot></div>
                </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row mb-3">
                    <label class="col-4 col-form-label text-right"><?= $Page->ukuran_lain->caption() ?></label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_ukuran_lain"></slot></div>
                </div>
                <div style="border: 1px solid rgba(0,0,0,.125); padding: 10px 1em 1em; border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-center">Target</label>
                    <label class="col-4 col-form-label text-center">Harga/Pcs</label>
                    <label class="col-4 col-form-label text-center">Proyeksi</label>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Isi</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_isi"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_isi_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Kemasan Primer</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_primer"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_primer_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Kemasan Sekunder</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_sekunder"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_sekunder_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Label</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_label"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_label_proyeksi"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label target-caption">Harga Total</label>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_total"></slot></div>
                    <div class="col-4"><slot class="ew-slot" name="tpx_npd_lain_harga_total_proyeksi"></slot></div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">DELIVERY</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->delivery_pickup->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_delivery_pickup"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->delivery_singlepoint->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_delivery_singlepoint"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->delivery_multipoint->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_delivery_multipoint"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->delivery_termlain->caption() ?></label>
                <div class="col-10"><slot class="ew-slot" name="tpx_npd_delivery_termlain"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Status Dokumen <i data-phrase="FieldRequiredIndicator" class="fas fa-asterisk ew-required" data-caption=""></i></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_status"></slot></div>
            </div>
        </div>
    </div>
</div>
</div>
</template>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_sample") ?>" href="#tab_npd_sample" data-toggle="tab"><?= $Language->tablePhrase("npd_sample", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_review") ?>" href="#tab_npd_review" data-toggle="tab"><?= $Language->tablePhrase("npd_review", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_confirmsample", explode(",", $Page->getCurrentDetailTable())) && $npd_confirmsample->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirmsample") {
            $firstActiveDetailTable = "npd_confirmsample";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_confirmsample") ?>" href="#tab_npd_confirmsample" data-toggle="tab"><?= $Language->tablePhrase("npd_confirmsample", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_harga") ?>" href="#tab_npd_harga" data-toggle="tab"><?= $Language->tablePhrase("npd_harga", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("npd_sample", explode(",", $Page->getCurrentDetailTable())) && $npd_sample->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_sample") {
            $firstActiveDetailTable = "npd_sample";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_sample") ?>" id="tab_npd_sample"><!-- page* -->
<?php include_once "NpdSampleGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_review", explode(",", $Page->getCurrentDetailTable())) && $npd_review->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_review") {
            $firstActiveDetailTable = "npd_review";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_review") ?>" id="tab_npd_review"><!-- page* -->
<?php include_once "NpdReviewGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_confirmsample", explode(",", $Page->getCurrentDetailTable())) && $npd_confirmsample->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirmsample") {
            $firstActiveDetailTable = "npd_confirmsample";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_confirmsample") ?>" id="tab_npd_confirmsample"><!-- page* -->
<?php include_once "NpdConfirmsampleGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_harga", explode(",", $Page->getCurrentDetailTable())) && $npd_harga->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_harga") {
            $firstActiveDetailTable = "npd_harga";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_harga") ?>" id="tab_npd_harga"><!-- page* -->
<?php include_once "NpdHargaGrid.php" ?>
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
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npdadd", "tpm_npdadd", "npdadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("npd");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#x_idcustomer").change((function(){$.get("api/nextKodeNpd/"+$(this).val(),(function(a){$("#x_kodeorder").val(a)}))})),$("input[name=x_kodeorder], input[name=x_nomororder]").css({"min-width":"",width:"100%"}),$("#x_tanggal_order, #x_target_selesai").css({"min-width":"100px",width:"70%"}),$("#x_utama_harga_isi, #x_utama_harga_isi_proyeksi, #x_utama_harga_primer, #x_utama_harga_primer_proyeksi, #x_utama_harga_sekunder, #x_utama_harga_sekunder_proyeksi, #x_utama_harga_label, #x_utama_harga_label_proyeksi, #x_utama_harga_total, #x_utama_harga_total_proyeksi").css({"min-width":"100px",width:"100%"}),$("#x_utama_harga_isi, #x_utama_harga_isi_proyeksi, #x_utama_harga_primer, #x_utama_harga_primer_proyeksi, #x_utama_harga_sekunder, #x_utama_harga_sekunder_proyeksi, #x_utama_harga_label, #x_utama_harga_label_proyeksi, #x_utama_harga_total, #x_utama_harga_total_proyeksi").attr("placeholder",""),$("#x_lain_harga_isi, #x_lain_harga_isi_proyeksi, #x_lain_harga_primer, #x_lain_harga_primer_proyeksi, #x_lain_harga_sekunder, #x_lain_harga_sekunder_proyeksi, #x_lain_harga_label, #x_lain_harga_label_proyeksi, #x_lain_harga_total, #x_lain_harga_total_proyeksi").css({"min-width":"100px",width:"100%"}),$("#x_lain_harga_isi, #x_lain_harga_isi_proyeksi, #x_lain_harga_primer, #x_lain_harga_primer_proyeksi, #x_lain_harga_sekunder, #x_lain_harga_sekunder_proyeksi, #x_lain_harga_label, #x_lain_harga_label_proyeksi, #x_lain_harga_total, #x_lain_harga_total_proyeksi").attr("placeholder",""),$("#x_ukuransediaan, #x_ukurankemasan, #x_ukurankemasansekunder").css("width","250px");
});
</script>
