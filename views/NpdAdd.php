<?php

namespace PHPMaker2021\distributor;

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
        ["tanggal_order", [fields.tanggal_order.visible && fields.tanggal_order.required ? ew.Validators.required(fields.tanggal_order.caption) : null, ew.Validators.datetime(0)], fields.tanggal_order.isInvalid],
        ["target_selesai", [fields.target_selesai.visible && fields.target_selesai.required ? ew.Validators.required(fields.target_selesai.caption) : null, ew.Validators.datetime(0)], fields.target_selesai.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["kodeorder", [fields.kodeorder.visible && fields.kodeorder.required ? ew.Validators.required(fields.kodeorder.caption) : null], fields.kodeorder.isInvalid],
        ["nomororder", [fields.nomororder.visible && fields.nomororder.required ? ew.Validators.required(fields.nomororder.caption) : null], fields.nomororder.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null, ew.Validators.integer], fields.idcustomer.isInvalid],
        ["idproduct_acuan", [fields.idproduct_acuan.visible && fields.idproduct_acuan.required ? ew.Validators.required(fields.idproduct_acuan.caption) : null], fields.idproduct_acuan.isInvalid],
        ["idjenisproduk", [fields.idjenisproduk.visible && fields.idjenisproduk.required ? ew.Validators.required(fields.idjenisproduk.caption) : null], fields.idjenisproduk.isInvalid],
        ["idkategoriproduk", [fields.idkategoriproduk.visible && fields.idkategoriproduk.required ? ew.Validators.required(fields.idkategoriproduk.caption) : null], fields.idkategoriproduk.isInvalid],
        ["fungsiproduk", [fields.fungsiproduk.visible && fields.fungsiproduk.required ? ew.Validators.required(fields.fungsiproduk.caption) : null], fields.fungsiproduk.isInvalid],
        ["kualitasproduk", [fields.kualitasproduk.visible && fields.kualitasproduk.required ? ew.Validators.required(fields.kualitasproduk.caption) : null], fields.kualitasproduk.isInvalid],
        ["bahan_campaign", [fields.bahan_campaign.visible && fields.bahan_campaign.required ? ew.Validators.required(fields.bahan_campaign.caption) : null], fields.bahan_campaign.isInvalid],
        ["ukuran_sediaan", [fields.ukuran_sediaan.visible && fields.ukuran_sediaan.required ? ew.Validators.required(fields.ukuran_sediaan.caption) : null], fields.ukuran_sediaan.isInvalid],
        ["bentuk", [fields.bentuk.visible && fields.bentuk.required ? ew.Validators.required(fields.bentuk.caption) : null], fields.bentuk.isInvalid],
        ["viskositas", [fields.viskositas.visible && fields.viskositas.required ? ew.Validators.required(fields.viskositas.caption) : null], fields.viskositas.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["parfum", [fields.parfum.visible && fields.parfum.required ? ew.Validators.required(fields.parfum.caption) : null], fields.parfum.isInvalid],
        ["aplikasi", [fields.aplikasi.visible && fields.aplikasi.required ? ew.Validators.required(fields.aplikasi.caption) : null], fields.aplikasi.isInvalid],
        ["estetika", [fields.estetika.visible && fields.estetika.required ? ew.Validators.required(fields.estetika.caption) : null], fields.estetika.isInvalid],
        ["tambahan", [fields.tambahan.visible && fields.tambahan.required ? ew.Validators.required(fields.tambahan.caption) : null], fields.tambahan.isInvalid],
        ["ukurankemasan", [fields.ukurankemasan.visible && fields.ukurankemasan.required ? ew.Validators.required(fields.ukurankemasan.caption) : null], fields.ukurankemasan.isInvalid],
        ["kemasanbentuk", [fields.kemasanbentuk.visible && fields.kemasanbentuk.required ? ew.Validators.required(fields.kemasanbentuk.caption) : null], fields.kemasanbentuk.isInvalid],
        ["kemasantutup", [fields.kemasantutup.visible && fields.kemasantutup.required ? ew.Validators.required(fields.kemasantutup.caption) : null], fields.kemasantutup.isInvalid],
        ["kemasancatatan", [fields.kemasancatatan.visible && fields.kemasancatatan.required ? ew.Validators.required(fields.kemasancatatan.caption) : null], fields.kemasancatatan.isInvalid],
        ["labelbahan", [fields.labelbahan.visible && fields.labelbahan.required ? ew.Validators.required(fields.labelbahan.caption) : null], fields.labelbahan.isInvalid],
        ["labelkualitas", [fields.labelkualitas.visible && fields.labelkualitas.required ? ew.Validators.required(fields.labelkualitas.caption) : null], fields.labelkualitas.isInvalid],
        ["labelposisi", [fields.labelposisi.visible && fields.labelposisi.required ? ew.Validators.required(fields.labelposisi.caption) : null], fields.labelposisi.isInvalid],
        ["labelcatatan", [fields.labelcatatan.visible && fields.labelcatatan.required ? ew.Validators.required(fields.labelcatatan.caption) : null], fields.labelcatatan.isInvalid],
        ["statusdokumen", [fields.statusdokumen.visible && fields.statusdokumen.required ? ew.Validators.required(fields.statusdokumen.caption) : null], fields.statusdokumen.isInvalid]
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
    fnpdadd.lists.idproduct_acuan = <?= $Page->idproduct_acuan->toClientList($Page) ?>;
    fnpdadd.lists.idjenisproduk = <?= $Page->idjenisproduk->toClientList($Page) ?>;
    fnpdadd.lists.idkategoriproduk = <?= $Page->idkategoriproduk->toClientList($Page) ?>;
    fnpdadd.lists.bentuk = <?= $Page->bentuk->toClientList($Page) ?>;
    fnpdadd.lists.viskositas = <?= $Page->viskositas->toClientList($Page) ?>;
    fnpdadd.lists.warna = <?= $Page->warna->toClientList($Page) ?>;
    fnpdadd.lists.parfum = <?= $Page->parfum->toClientList($Page) ?>;
    fnpdadd.lists.aplikasi = <?= $Page->aplikasi->toClientList($Page) ?>;
    fnpdadd.lists.estetika = <?= $Page->estetika->toClientList($Page) ?>;
    fnpdadd.lists.kemasanbentuk = <?= $Page->kemasanbentuk->toClientList($Page) ?>;
    fnpdadd.lists.kemasantutup = <?= $Page->kemasantutup->toClientList($Page) ?>;
    fnpdadd.lists.labelbahan = <?= $Page->labelbahan->toClientList($Page) ?>;
    fnpdadd.lists.labelkualitas = <?= $Page->labelkualitas->toClientList($Page) ?>;
    fnpdadd.lists.labelposisi = <?= $Page->labelposisi->toClientList($Page) ?>;
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
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
    <div id="r_tanggal_order" class="form-group row">
        <label id="elh_npd_tanggal_order" for="x_tanggal_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_order->caption() ?><?= $Page->tanggal_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_order->cellAttributes() ?>>
<span id="el_npd_tanggal_order">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
    <div id="r_target_selesai" class="form-group row">
        <label id="elh_npd_target_selesai" for="x_target_selesai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->target_selesai->caption() ?><?= $Page->target_selesai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->target_selesai->cellAttributes() ?>>
<span id="el_npd_target_selesai">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_npd_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="npd" data-field="x_status" data-page="1" name="x_status" id="x_status" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
    <div id="r_kodeorder" class="form-group row">
        <label id="elh_npd_kodeorder" for="x_kodeorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kodeorder->caption() ?><?= $Page->kodeorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el_npd_kodeorder">
<input type="<?= $Page->kodeorder->getInputTextType() ?>" data-table="npd" data-field="x_kodeorder" data-page="1" name="x_kodeorder" id="x_kodeorder" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->kodeorder->getPlaceHolder()) ?>" value="<?= $Page->kodeorder->EditValue ?>"<?= $Page->kodeorder->editAttributes() ?> aria-describedby="x_kodeorder_help">
<?= $Page->kodeorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kodeorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomororder->Visible) { // nomororder ?>
    <div id="r_nomororder" class="form-group row">
        <label id="elh_npd_nomororder" for="x_nomororder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nomororder->caption() ?><?= $Page->nomororder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nomororder->cellAttributes() ?>>
<span id="el_npd_nomororder">
<input type="<?= $Page->nomororder->getInputTextType() ?>" data-table="npd" data-field="x_nomororder" data-page="1" name="x_nomororder" id="x_nomororder" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nomororder->getPlaceHolder()) ?>" value="<?= $Page->nomororder->EditValue ?>"<?= $Page->nomororder->editAttributes() ?> aria-describedby="x_nomororder_help">
<?= $Page->nomororder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomororder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_npd_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_npd_idpegawai">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_npd_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_npd_idcustomer">
<?php
$onchange = $Page->idcustomer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idcustomer->EditAttrs["onchange"] = "";
?>
<span id="as_x_idcustomer" class="ew-auto-suggest">
    <input type="<?= $Page->idcustomer->getInputTextType() ?>" class="form-control" name="sv_x_idcustomer" id="sv_x_idcustomer" value="<?= RemoveHtml($Page->idcustomer->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>"<?= $Page->idcustomer->editAttributes() ?> aria-describedby="x_idcustomer_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="npd" data-field="x_idcustomer" data-input="sv_x_idcustomer" data-page="1" data-value-separator="<?= $Page->idcustomer->displayValueSeparatorAttribute() ?>" name="x_idcustomer" id="x_idcustomer" value="<?= HtmlEncode($Page->idcustomer->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->idcustomer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage() ?></div>
<script>
loadjs.ready(["fnpdadd"], function() {
    fnpdadd.createAutoSuggest(Object.assign({"id":"x_idcustomer","forceSelect":false}, ew.vars.tables.npd.fields.idcustomer.autoSuggestOptions));
});
</script>
<?= $Page->idcustomer->Lookup->getParamTag($Page, "p_x_idcustomer") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <div id="r_idproduct_acuan" class="form-group row">
        <label id="elh_npd_idproduct_acuan" for="x_idproduct_acuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct_acuan->caption() ?><?= $Page->idproduct_acuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el_npd_idproduct_acuan">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idjenisproduk->Visible) { // idjenisproduk ?>
    <div id="r_idjenisproduk" class="form-group row">
        <label id="elh_npd_idjenisproduk" for="x_idjenisproduk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idjenisproduk->caption() ?><?= $Page->idjenisproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idjenisproduk->cellAttributes() ?>>
<span id="el_npd_idjenisproduk">
    <select
        id="x_idjenisproduk"
        name="x_idjenisproduk"
        class="form-control ew-select<?= $Page->idjenisproduk->isInvalidClass() ?>"
        data-select2-id="npd_x_idjenisproduk"
        data-table="npd"
        data-field="x_idjenisproduk"
        data-page="1"
        data-value-separator="<?= $Page->idjenisproduk->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idjenisproduk->getPlaceHolder()) ?>"
        <?= $Page->idjenisproduk->editAttributes() ?>>
        <?= $Page->idjenisproduk->selectOptionListHtml("x_idjenisproduk") ?>
    </select>
    <?= $Page->idjenisproduk->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idjenisproduk->getErrorMessage() ?></div>
<?= $Page->idjenisproduk->Lookup->getParamTag($Page, "p_x_idjenisproduk") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idjenisproduk']"),
        options = { name: "x_idjenisproduk", selectId: "npd_x_idjenisproduk", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idjenisproduk.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkategoriproduk->Visible) { // idkategoriproduk ?>
    <div id="r_idkategoriproduk" class="form-group row">
        <label id="elh_npd_idkategoriproduk" for="x_idkategoriproduk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkategoriproduk->caption() ?><?= $Page->idkategoriproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkategoriproduk->cellAttributes() ?>>
<span id="el_npd_idkategoriproduk">
    <select
        id="x_idkategoriproduk"
        name="x_idkategoriproduk"
        class="form-control ew-select<?= $Page->idkategoriproduk->isInvalidClass() ?>"
        data-select2-id="npd_x_idkategoriproduk"
        data-table="npd"
        data-field="x_idkategoriproduk"
        data-page="1"
        data-value-separator="<?= $Page->idkategoriproduk->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkategoriproduk->getPlaceHolder()) ?>"
        <?= $Page->idkategoriproduk->editAttributes() ?>>
        <?= $Page->idkategoriproduk->selectOptionListHtml("x_idkategoriproduk") ?>
    </select>
    <?= $Page->idkategoriproduk->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkategoriproduk->getErrorMessage() ?></div>
<?= $Page->idkategoriproduk->Lookup->getParamTag($Page, "p_x_idkategoriproduk") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idkategoriproduk']"),
        options = { name: "x_idkategoriproduk", selectId: "npd_x_idkategoriproduk", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idkategoriproduk.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fungsiproduk->Visible) { // fungsiproduk ?>
    <div id="r_fungsiproduk" class="form-group row">
        <label id="elh_npd_fungsiproduk" for="x_fungsiproduk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fungsiproduk->caption() ?><?= $Page->fungsiproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fungsiproduk->cellAttributes() ?>>
<span id="el_npd_fungsiproduk">
<input type="<?= $Page->fungsiproduk->getInputTextType() ?>" data-table="npd" data-field="x_fungsiproduk" data-page="1" name="x_fungsiproduk" id="x_fungsiproduk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fungsiproduk->getPlaceHolder()) ?>" value="<?= $Page->fungsiproduk->EditValue ?>"<?= $Page->fungsiproduk->editAttributes() ?> aria-describedby="x_fungsiproduk_help">
<?= $Page->fungsiproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fungsiproduk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kualitasproduk->Visible) { // kualitasproduk ?>
    <div id="r_kualitasproduk" class="form-group row">
        <label id="elh_npd_kualitasproduk" for="x_kualitasproduk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kualitasproduk->caption() ?><?= $Page->kualitasproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kualitasproduk->cellAttributes() ?>>
<span id="el_npd_kualitasproduk">
<input type="<?= $Page->kualitasproduk->getInputTextType() ?>" data-table="npd" data-field="x_kualitasproduk" data-page="1" name="x_kualitasproduk" id="x_kualitasproduk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kualitasproduk->getPlaceHolder()) ?>" value="<?= $Page->kualitasproduk->EditValue ?>"<?= $Page->kualitasproduk->editAttributes() ?> aria-describedby="x_kualitasproduk_help">
<?= $Page->kualitasproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kualitasproduk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
    <div id="r_bahan_campaign" class="form-group row">
        <label id="elh_npd_bahan_campaign" for="x_bahan_campaign" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bahan_campaign->caption() ?><?= $Page->bahan_campaign->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahan_campaign->cellAttributes() ?>>
<span id="el_npd_bahan_campaign">
<input type="<?= $Page->bahan_campaign->getInputTextType() ?>" data-table="npd" data-field="x_bahan_campaign" data-page="1" name="x_bahan_campaign" id="x_bahan_campaign" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahan_campaign->getPlaceHolder()) ?>" value="<?= $Page->bahan_campaign->EditValue ?>"<?= $Page->bahan_campaign->editAttributes() ?> aria-describedby="x_bahan_campaign_help">
<?= $Page->bahan_campaign->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahan_campaign->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran_sediaan->Visible) { // ukuran_sediaan ?>
    <div id="r_ukuran_sediaan" class="form-group row">
        <label id="elh_npd_ukuran_sediaan" for="x_ukuran_sediaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuran_sediaan->caption() ?><?= $Page->ukuran_sediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran_sediaan->cellAttributes() ?>>
<span id="el_npd_ukuran_sediaan">
<input type="<?= $Page->ukuran_sediaan->getInputTextType() ?>" data-table="npd" data-field="x_ukuran_sediaan" data-page="1" name="x_ukuran_sediaan" id="x_ukuran_sediaan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ukuran_sediaan->getPlaceHolder()) ?>" value="<?= $Page->ukuran_sediaan->EditValue ?>"<?= $Page->ukuran_sediaan->editAttributes() ?> aria-describedby="x_ukuran_sediaan_help">
<?= $Page->ukuran_sediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran_sediaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <div id="r_bentuk" class="form-group row">
        <label id="elh_npd_bentuk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bentuk->caption() ?><?= $Page->bentuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuk->cellAttributes() ?>>
<span id="el_npd_bentuk">
<template id="tp_x_bentuk">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_bentuk" name="x_bentuk" id="x_bentuk"<?= $Page->bentuk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_bentuk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_bentuk[]"
    name="x_bentuk[]"
    value="<?= HtmlEncode($Page->bentuk->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_bentuk"
    data-target="dsl_x_bentuk"
    data-repeatcolumn="5"
    class="form-control<?= $Page->bentuk->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_bentuk"
    data-page="1"
    data-value-separator="<?= $Page->bentuk->displayValueSeparatorAttribute() ?>"
    <?= $Page->bentuk->editAttributes() ?>>
<?= $Page->bentuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuk->getErrorMessage() ?></div>
<?= $Page->bentuk->Lookup->getParamTag($Page, "p_x_bentuk") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <div id="r_viskositas" class="form-group row">
        <label id="elh_npd_viskositas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->viskositas->caption() ?><?= $Page->viskositas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositas->cellAttributes() ?>>
<span id="el_npd_viskositas">
<template id="tp_x_viskositas">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_viskositas" name="x_viskositas" id="x_viskositas"<?= $Page->viskositas->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_viskositas" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_viskositas[]"
    name="x_viskositas[]"
    value="<?= HtmlEncode($Page->viskositas->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_viskositas"
    data-target="dsl_x_viskositas"
    data-repeatcolumn="5"
    class="form-control<?= $Page->viskositas->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_viskositas"
    data-page="1"
    data-value-separator="<?= $Page->viskositas->displayValueSeparatorAttribute() ?>"
    <?= $Page->viskositas->editAttributes() ?>>
<?= $Page->viskositas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositas->getErrorMessage() ?></div>
<?= $Page->viskositas->Lookup->getParamTag($Page, "p_x_viskositas") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_npd_warna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_warna">
<template id="tp_x_warna">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_warna" name="x_warna" id="x_warna"<?= $Page->warna->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_warna" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_warna[]"
    name="x_warna[]"
    value="<?= HtmlEncode($Page->warna->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_warna"
    data-target="dsl_x_warna"
    data-repeatcolumn="5"
    class="form-control<?= $Page->warna->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_warna"
    data-page="1"
    data-value-separator="<?= $Page->warna->displayValueSeparatorAttribute() ?>"
    <?= $Page->warna->editAttributes() ?>>
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
<?= $Page->warna->Lookup->getParamTag($Page, "p_x_warna") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <div id="r_parfum" class="form-group row">
        <label id="elh_npd_parfum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parfum->caption() ?><?= $Page->parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parfum->cellAttributes() ?>>
<span id="el_npd_parfum">
<template id="tp_x_parfum">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_parfum" name="x_parfum" id="x_parfum"<?= $Page->parfum->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_parfum" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_parfum[]"
    name="x_parfum[]"
    value="<?= HtmlEncode($Page->parfum->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_parfum"
    data-target="dsl_x_parfum"
    data-repeatcolumn="5"
    class="form-control<?= $Page->parfum->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_parfum"
    data-page="1"
    data-value-separator="<?= $Page->parfum->displayValueSeparatorAttribute() ?>"
    <?= $Page->parfum->editAttributes() ?>>
<?= $Page->parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parfum->getErrorMessage() ?></div>
<?= $Page->parfum->Lookup->getParamTag($Page, "p_x_parfum") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasi->Visible) { // aplikasi ?>
    <div id="r_aplikasi" class="form-group row">
        <label id="elh_npd_aplikasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aplikasi->caption() ?><?= $Page->aplikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasi->cellAttributes() ?>>
<span id="el_npd_aplikasi">
<template id="tp_x_aplikasi">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_aplikasi" name="x_aplikasi" id="x_aplikasi"<?= $Page->aplikasi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aplikasi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aplikasi[]"
    name="x_aplikasi[]"
    value="<?= HtmlEncode($Page->aplikasi->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_aplikasi"
    data-target="dsl_x_aplikasi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->aplikasi->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_aplikasi"
    data-page="1"
    data-value-separator="<?= $Page->aplikasi->displayValueSeparatorAttribute() ?>"
    <?= $Page->aplikasi->editAttributes() ?>>
<?= $Page->aplikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasi->getErrorMessage() ?></div>
<?= $Page->aplikasi->Lookup->getParamTag($Page, "p_x_aplikasi") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estetika->Visible) { // estetika ?>
    <div id="r_estetika" class="form-group row">
        <label id="elh_npd_estetika" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estetika->caption() ?><?= $Page->estetika->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estetika->cellAttributes() ?>>
<span id="el_npd_estetika">
<template id="tp_x_estetika">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_estetika" name="x_estetika" id="x_estetika"<?= $Page->estetika->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_estetika" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_estetika[]"
    name="x_estetika[]"
    value="<?= HtmlEncode($Page->estetika->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_estetika"
    data-target="dsl_x_estetika"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estetika->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_estetika"
    data-page="1"
    data-value-separator="<?= $Page->estetika->displayValueSeparatorAttribute() ?>"
    <?= $Page->estetika->editAttributes() ?>>
<?= $Page->estetika->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estetika->getErrorMessage() ?></div>
<?= $Page->estetika->Lookup->getParamTag($Page, "p_x_estetika") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <div id="r_tambahan" class="form-group row">
        <label id="elh_npd_tambahan" for="x_tambahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tambahan->caption() ?><?= $Page->tambahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tambahan->cellAttributes() ?>>
<span id="el_npd_tambahan">
<textarea data-table="npd" data-field="x_tambahan" data-page="1" name="x_tambahan" id="x_tambahan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->tambahan->getPlaceHolder()) ?>"<?= $Page->tambahan->editAttributes() ?> aria-describedby="x_tambahan_help"><?= $Page->tambahan->EditValue ?></textarea>
<?= $Page->tambahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tambahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukurankemasan->Visible) { // ukurankemasan ?>
    <div id="r_ukurankemasan" class="form-group row">
        <label id="elh_npd_ukurankemasan" for="x_ukurankemasan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukurankemasan->caption() ?><?= $Page->ukurankemasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukurankemasan->cellAttributes() ?>>
<span id="el_npd_ukurankemasan">
<input type="<?= $Page->ukurankemasan->getInputTextType() ?>" data-table="npd" data-field="x_ukurankemasan" data-page="1" name="x_ukurankemasan" id="x_ukurankemasan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->ukurankemasan->getPlaceHolder()) ?>" value="<?= $Page->ukurankemasan->EditValue ?>"<?= $Page->ukurankemasan->editAttributes() ?> aria-describedby="x_ukurankemasan_help">
<?= $Page->ukurankemasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukurankemasan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasanbentuk->Visible) { // kemasanbentuk ?>
    <div id="r_kemasanbentuk" class="form-group row">
        <label id="elh_npd_kemasanbentuk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasanbentuk->caption() ?><?= $Page->kemasanbentuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanbentuk->cellAttributes() ?>>
<span id="el_npd_kemasanbentuk">
<template id="tp_x_kemasanbentuk">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_kemasanbentuk" name="x_kemasanbentuk" id="x_kemasanbentuk"<?= $Page->kemasanbentuk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kemasanbentuk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kemasanbentuk[]"
    name="x_kemasanbentuk[]"
    value="<?= HtmlEncode($Page->kemasanbentuk->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_kemasanbentuk"
    data-target="dsl_x_kemasanbentuk"
    data-repeatcolumn="5"
    class="form-control<?= $Page->kemasanbentuk->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kemasanbentuk"
    data-page="1"
    data-value-separator="<?= $Page->kemasanbentuk->displayValueSeparatorAttribute() ?>"
    <?= $Page->kemasanbentuk->editAttributes() ?>>
<?= $Page->kemasanbentuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasanbentuk->getErrorMessage() ?></div>
<?= $Page->kemasanbentuk->Lookup->getParamTag($Page, "p_x_kemasanbentuk") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasantutup->Visible) { // kemasantutup ?>
    <div id="r_kemasantutup" class="form-group row">
        <label id="elh_npd_kemasantutup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasantutup->caption() ?><?= $Page->kemasantutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasantutup->cellAttributes() ?>>
<span id="el_npd_kemasantutup">
<template id="tp_x_kemasantutup">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_kemasantutup" name="x_kemasantutup" id="x_kemasantutup"<?= $Page->kemasantutup->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_kemasantutup" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_kemasantutup[]"
    name="x_kemasantutup[]"
    value="<?= HtmlEncode($Page->kemasantutup->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_kemasantutup"
    data-target="dsl_x_kemasantutup"
    data-repeatcolumn="5"
    class="form-control<?= $Page->kemasantutup->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_kemasantutup"
    data-page="1"
    data-value-separator="<?= $Page->kemasantutup->displayValueSeparatorAttribute() ?>"
    <?= $Page->kemasantutup->editAttributes() ?>>
<?= $Page->kemasantutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasantutup->getErrorMessage() ?></div>
<?= $Page->kemasantutup->Lookup->getParamTag($Page, "p_x_kemasantutup") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasancatatan->Visible) { // kemasancatatan ?>
    <div id="r_kemasancatatan" class="form-group row">
        <label id="elh_npd_kemasancatatan" for="x_kemasancatatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasancatatan->caption() ?><?= $Page->kemasancatatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasancatatan->cellAttributes() ?>>
<span id="el_npd_kemasancatatan">
<textarea data-table="npd" data-field="x_kemasancatatan" data-page="1" name="x_kemasancatatan" id="x_kemasancatatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->kemasancatatan->getPlaceHolder()) ?>"<?= $Page->kemasancatatan->editAttributes() ?> aria-describedby="x_kemasancatatan_help"><?= $Page->kemasancatatan->EditValue ?></textarea>
<?= $Page->kemasancatatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasancatatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelbahan->Visible) { // labelbahan ?>
    <div id="r_labelbahan" class="form-group row">
        <label id="elh_npd_labelbahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->labelbahan->caption() ?><?= $Page->labelbahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelbahan->cellAttributes() ?>>
<span id="el_npd_labelbahan">
<template id="tp_x_labelbahan">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_labelbahan" name="x_labelbahan" id="x_labelbahan"<?= $Page->labelbahan->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labelbahan" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labelbahan[]"
    name="x_labelbahan[]"
    value="<?= HtmlEncode($Page->labelbahan->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_labelbahan"
    data-target="dsl_x_labelbahan"
    data-repeatcolumn="5"
    class="form-control<?= $Page->labelbahan->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labelbahan"
    data-page="1"
    data-value-separator="<?= $Page->labelbahan->displayValueSeparatorAttribute() ?>"
    <?= $Page->labelbahan->editAttributes() ?>>
<?= $Page->labelbahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelbahan->getErrorMessage() ?></div>
<?= $Page->labelbahan->Lookup->getParamTag($Page, "p_x_labelbahan") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
    <div id="r_labelkualitas" class="form-group row">
        <label id="elh_npd_labelkualitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->labelkualitas->caption() ?><?= $Page->labelkualitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelkualitas->cellAttributes() ?>>
<span id="el_npd_labelkualitas">
<template id="tp_x_labelkualitas">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_labelkualitas" name="x_labelkualitas" id="x_labelkualitas"<?= $Page->labelkualitas->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labelkualitas" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labelkualitas[]"
    name="x_labelkualitas[]"
    value="<?= HtmlEncode($Page->labelkualitas->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_labelkualitas"
    data-target="dsl_x_labelkualitas"
    data-repeatcolumn="5"
    class="form-control<?= $Page->labelkualitas->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labelkualitas"
    data-page="1"
    data-value-separator="<?= $Page->labelkualitas->displayValueSeparatorAttribute() ?>"
    <?= $Page->labelkualitas->editAttributes() ?>>
<?= $Page->labelkualitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelkualitas->getErrorMessage() ?></div>
<?= $Page->labelkualitas->Lookup->getParamTag($Page, "p_x_labelkualitas") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
    <div id="r_labelposisi" class="form-group row">
        <label id="elh_npd_labelposisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->labelposisi->caption() ?><?= $Page->labelposisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelposisi->cellAttributes() ?>>
<span id="el_npd_labelposisi">
<template id="tp_x_labelposisi">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" data-table="npd" data-field="x_labelposisi" name="x_labelposisi" id="x_labelposisi"<?= $Page->labelposisi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_labelposisi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_labelposisi[]"
    name="x_labelposisi[]"
    value="<?= HtmlEncode($Page->labelposisi->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_labelposisi"
    data-target="dsl_x_labelposisi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->labelposisi->isInvalidClass() ?>"
    data-table="npd"
    data-field="x_labelposisi"
    data-page="1"
    data-value-separator="<?= $Page->labelposisi->displayValueSeparatorAttribute() ?>"
    <?= $Page->labelposisi->editAttributes() ?>>
<?= $Page->labelposisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelposisi->getErrorMessage() ?></div>
<?= $Page->labelposisi->Lookup->getParamTag($Page, "p_x_labelposisi") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelcatatan->Visible) { // labelcatatan ?>
    <div id="r_labelcatatan" class="form-group row">
        <label id="elh_npd_labelcatatan" for="x_labelcatatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->labelcatatan->caption() ?><?= $Page->labelcatatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelcatatan->cellAttributes() ?>>
<span id="el_npd_labelcatatan">
<textarea data-table="npd" data-field="x_labelcatatan" data-page="1" name="x_labelcatatan" id="x_labelcatatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->labelcatatan->getPlaceHolder()) ?>"<?= $Page->labelcatatan->editAttributes() ?> aria-describedby="x_labelcatatan_help"><?= $Page->labelcatatan->EditValue ?></textarea>
<?= $Page->labelcatatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelcatatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusdokumen->Visible) { // statusdokumen ?>
    <div id="r_statusdokumen" class="form-group row">
        <label id="elh_npd_statusdokumen" for="x_statusdokumen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statusdokumen->caption() ?><?= $Page->statusdokumen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statusdokumen->cellAttributes() ?>>
<span id="el_npd_statusdokumen">
<input type="<?= $Page->statusdokumen->getInputTextType() ?>" data-table="npd" data-field="x_statusdokumen" data-page="1" name="x_statusdokumen" id="x_statusdokumen" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->statusdokumen->getPlaceHolder()) ?>" value="<?= $Page->statusdokumen->EditValue ?>"<?= $Page->statusdokumen->editAttributes() ?> aria-describedby="x_statusdokumen_help">
<?= $Page->statusdokumen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusdokumen->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
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
    if (in_array("npd_confirm", explode(",", $Page->getCurrentDetailTable())) && $npd_confirm->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirm") {
            $firstActiveDetailTable = "npd_confirm";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_confirm") ?>" href="#tab_npd_confirm" data-toggle="tab"><?= $Language->tablePhrase("npd_confirm", "TblCaption") ?></a></li>
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
<?php
    if (in_array("npd_desain", explode(",", $Page->getCurrentDetailTable())) && $npd_desain->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_desain") {
            $firstActiveDetailTable = "npd_desain";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_desain") ?>" href="#tab_npd_desain" data-toggle="tab"><?= $Language->tablePhrase("npd_desain", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("npd_terms", explode(",", $Page->getCurrentDetailTable())) && $npd_terms->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_terms") {
            $firstActiveDetailTable = "npd_terms";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("npd_terms") ?>" href="#tab_npd_terms" data-toggle="tab"><?= $Language->tablePhrase("npd_terms", "TblCaption") ?></a></li>
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
    if (in_array("npd_confirm", explode(",", $Page->getCurrentDetailTable())) && $npd_confirm->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_confirm") {
            $firstActiveDetailTable = "npd_confirm";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_confirm") ?>" id="tab_npd_confirm"><!-- page* -->
<?php include_once "NpdConfirmGrid.php" ?>
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
<?php
    if (in_array("npd_desain", explode(",", $Page->getCurrentDetailTable())) && $npd_desain->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_desain") {
            $firstActiveDetailTable = "npd_desain";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_desain") ?>" id="tab_npd_desain"><!-- page* -->
<?php include_once "NpdDesainGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("npd_terms", explode(",", $Page->getCurrentDetailTable())) && $npd_terms->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "npd_terms") {
            $firstActiveDetailTable = "npd_terms";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("npd_terms") ?>" id="tab_npd_terms"><!-- page* -->
<?php include_once "NpdTermsGrid.php" ?>
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
    ew.addEventHandlers("npd");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){$("#x_idcustomer").change((function(){$.get("api/nextKodeNpd/"+$(this).val(),(function(e){$("#x_kodeorder").val(e)}))}))}));
});
</script>
