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
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null, ew.Validators.integer], fields.idcustomer.isInvalid],
        ["kodeorder", [fields.kodeorder.visible && fields.kodeorder.required ? ew.Validators.required(fields.kodeorder.caption) : null], fields.kodeorder.isInvalid],
        ["idproduct_acuan", [fields.idproduct_acuan.visible && fields.idproduct_acuan.required ? ew.Validators.required(fields.idproduct_acuan.caption) : null], fields.idproduct_acuan.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["idjenisbarang", [fields.idjenisbarang.visible && fields.idjenisbarang.required ? ew.Validators.required(fields.idjenisbarang.caption) : null], fields.idjenisbarang.isInvalid],
        ["idkategoribarang", [fields.idkategoribarang.visible && fields.idkategoribarang.required ? ew.Validators.required(fields.idkategoribarang.caption) : null], fields.idkategoribarang.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["parfum", [fields.parfum.visible && fields.parfum.required ? ew.Validators.required(fields.parfum.caption) : null], fields.parfum.isInvalid],
        ["tambahan", [fields.tambahan.visible && fields.tambahan.required ? ew.Validators.required(fields.tambahan.caption) : null], fields.tambahan.isInvalid],
        ["kemasanbarang", [fields.kemasanbarang.visible && fields.kemasanbarang.required ? ew.Validators.required(fields.kemasanbarang.caption) : null], fields.kemasanbarang.isInvalid],
        ["label", [fields.label.visible && fields.label.required ? ew.Validators.required(fields.label.caption) : null], fields.label.isInvalid],
        ["orderperdana", [fields.orderperdana.visible && fields.orderperdana.required ? ew.Validators.required(fields.orderperdana.caption) : null, ew.Validators.integer], fields.orderperdana.isInvalid],
        ["orderreguler", [fields.orderreguler.visible && fields.orderreguler.required ? ew.Validators.required(fields.orderreguler.caption) : null, ew.Validators.integer], fields.orderreguler.isInvalid],
        ["tanggal_order", [fields.tanggal_order.visible && fields.tanggal_order.required ? ew.Validators.required(fields.tanggal_order.caption) : null, ew.Validators.datetime(0)], fields.tanggal_order.isInvalid],
        ["target_selesai", [fields.target_selesai.visible && fields.target_selesai.required ? ew.Validators.required(fields.target_selesai.caption) : null, ew.Validators.datetime(0)], fields.target_selesai.isInvalid],
        ["kategori", [fields.kategori.visible && fields.kategori.required ? ew.Validators.required(fields.kategori.caption) : null], fields.kategori.isInvalid],
        ["fungsi_produk", [fields.fungsi_produk.visible && fields.fungsi_produk.required ? ew.Validators.required(fields.fungsi_produk.caption) : null], fields.fungsi_produk.isInvalid],
        ["kualitasbarang", [fields.kualitasbarang.visible && fields.kualitasbarang.required ? ew.Validators.required(fields.kualitasbarang.caption) : null], fields.kualitasbarang.isInvalid],
        ["bahan_campaign", [fields.bahan_campaign.visible && fields.bahan_campaign.required ? ew.Validators.required(fields.bahan_campaign.caption) : null], fields.bahan_campaign.isInvalid],
        ["ukuran_sediaan", [fields.ukuran_sediaan.visible && fields.ukuran_sediaan.required ? ew.Validators.required(fields.ukuran_sediaan.caption) : null], fields.ukuran_sediaan.isInvalid]
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
    fnpdadd.lists.idjenisbarang = <?= $Page->idjenisbarang->toClientList($Page) ?>;
    fnpdadd.lists.idkategoribarang = <?= $Page->idkategoribarang->toClientList($Page) ?>;
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
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_npd_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="npd" data-field="x_nama" data-page="1" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idjenisbarang->Visible) { // idjenisbarang ?>
    <div id="r_idjenisbarang" class="form-group row">
        <label id="elh_npd_idjenisbarang" for="x_idjenisbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idjenisbarang->caption() ?><?= $Page->idjenisbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idjenisbarang->cellAttributes() ?>>
<span id="el_npd_idjenisbarang">
    <select
        id="x_idjenisbarang"
        name="x_idjenisbarang"
        class="form-control ew-select<?= $Page->idjenisbarang->isInvalidClass() ?>"
        data-select2-id="npd_x_idjenisbarang"
        data-table="npd"
        data-field="x_idjenisbarang"
        data-page="1"
        data-value-separator="<?= $Page->idjenisbarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idjenisbarang->getPlaceHolder()) ?>"
        <?= $Page->idjenisbarang->editAttributes() ?>>
        <?= $Page->idjenisbarang->selectOptionListHtml("x_idjenisbarang") ?>
    </select>
    <?= $Page->idjenisbarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idjenisbarang->getErrorMessage() ?></div>
<?= $Page->idjenisbarang->Lookup->getParamTag($Page, "p_x_idjenisbarang") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idjenisbarang']"),
        options = { name: "x_idjenisbarang", selectId: "npd_x_idjenisbarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idjenisbarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
    <div id="r_idkategoribarang" class="form-group row">
        <label id="elh_npd_idkategoribarang" for="x_idkategoribarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkategoribarang->caption() ?><?= $Page->idkategoribarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkategoribarang->cellAttributes() ?>>
<span id="el_npd_idkategoribarang">
<?php $Page->idkategoribarang->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idkategoribarang"
        name="x_idkategoribarang"
        class="form-control ew-select<?= $Page->idkategoribarang->isInvalidClass() ?>"
        data-select2-id="npd_x_idkategoribarang"
        data-table="npd"
        data-field="x_idkategoribarang"
        data-page="1"
        data-value-separator="<?= $Page->idkategoribarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkategoribarang->getPlaceHolder()) ?>"
        <?= $Page->idkategoribarang->editAttributes() ?>>
        <?= $Page->idkategoribarang->selectOptionListHtml("x_idkategoribarang") ?>
    </select>
    <?= $Page->idkategoribarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkategoribarang->getErrorMessage() ?></div>
<?= $Page->idkategoribarang->Lookup->getParamTag($Page, "p_x_idkategoribarang") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_x_idkategoribarang']"),
        options = { name: "x_idkategoribarang", selectId: "npd_x_idkategoribarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd.fields.idkategoribarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_npd_warna" for="x_warna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_warna">
<input type="<?= $Page->warna->getInputTextType() ?>" data-table="npd" data-field="x_warna" data-page="1" name="x_warna" id="x_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warna->getPlaceHolder()) ?>" value="<?= $Page->warna->EditValue ?>"<?= $Page->warna->editAttributes() ?> aria-describedby="x_warna_help">
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <div id="r_parfum" class="form-group row">
        <label id="elh_npd_parfum" for="x_parfum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parfum->caption() ?><?= $Page->parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parfum->cellAttributes() ?>>
<span id="el_npd_parfum">
<input type="<?= $Page->parfum->getInputTextType() ?>" data-table="npd" data-field="x_parfum" data-page="1" name="x_parfum" id="x_parfum" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->parfum->getPlaceHolder()) ?>" value="<?= $Page->parfum->EditValue ?>"<?= $Page->parfum->editAttributes() ?> aria-describedby="x_parfum_help">
<?= $Page->parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parfum->getErrorMessage() ?></div>
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
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
    <div id="r_kemasanbarang" class="form-group row">
        <label id="elh_npd_kemasanbarang" for="x_kemasanbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasanbarang->caption() ?><?= $Page->kemasanbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanbarang->cellAttributes() ?>>
<span id="el_npd_kemasanbarang">
<textarea data-table="npd" data-field="x_kemasanbarang" data-page="1" name="x_kemasanbarang" id="x_kemasanbarang" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->kemasanbarang->getPlaceHolder()) ?>"<?= $Page->kemasanbarang->editAttributes() ?> aria-describedby="x_kemasanbarang_help"><?= $Page->kemasanbarang->EditValue ?></textarea>
<?= $Page->kemasanbarang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasanbarang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label->Visible) { // label ?>
    <div id="r_label" class="form-group row">
        <label id="elh_npd_label" for="x_label" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label->caption() ?><?= $Page->label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label->cellAttributes() ?>>
<span id="el_npd_label">
<textarea data-table="npd" data-field="x_label" data-page="1" name="x_label" id="x_label" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->label->getPlaceHolder()) ?>"<?= $Page->label->editAttributes() ?> aria-describedby="x_label_help"><?= $Page->label->EditValue ?></textarea>
<?= $Page->label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
    <div id="r_orderperdana" class="form-group row">
        <label id="elh_npd_orderperdana" for="x_orderperdana" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderperdana->caption() ?><?= $Page->orderperdana->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderperdana->cellAttributes() ?>>
<span id="el_npd_orderperdana">
<input type="<?= $Page->orderperdana->getInputTextType() ?>" data-table="npd" data-field="x_orderperdana" data-page="1" name="x_orderperdana" id="x_orderperdana" size="30" placeholder="<?= HtmlEncode($Page->orderperdana->getPlaceHolder()) ?>" value="<?= $Page->orderperdana->EditValue ?>"<?= $Page->orderperdana->editAttributes() ?> aria-describedby="x_orderperdana_help">
<?= $Page->orderperdana->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderperdana->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderreguler->Visible) { // orderreguler ?>
    <div id="r_orderreguler" class="form-group row">
        <label id="elh_npd_orderreguler" for="x_orderreguler" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderreguler->caption() ?><?= $Page->orderreguler->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderreguler->cellAttributes() ?>>
<span id="el_npd_orderreguler">
<input type="<?= $Page->orderreguler->getInputTextType() ?>" data-table="npd" data-field="x_orderreguler" data-page="1" name="x_orderreguler" id="x_orderreguler" size="30" placeholder="<?= HtmlEncode($Page->orderreguler->getPlaceHolder()) ?>" value="<?= $Page->orderreguler->EditValue ?>"<?= $Page->orderreguler->editAttributes() ?> aria-describedby="x_orderreguler_help">
<?= $Page->orderreguler->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderreguler->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
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
<?php if ($Page->kategori->Visible) { // kategori ?>
    <div id="r_kategori" class="form-group row">
        <label id="elh_npd_kategori" for="x_kategori" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kategori->caption() ?><?= $Page->kategori->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategori->cellAttributes() ?>>
<span id="el_npd_kategori">
<input type="<?= $Page->kategori->getInputTextType() ?>" data-table="npd" data-field="x_kategori" data-page="1" name="x_kategori" id="x_kategori" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kategori->getPlaceHolder()) ?>" value="<?= $Page->kategori->EditValue ?>"<?= $Page->kategori->editAttributes() ?> aria-describedby="x_kategori_help">
<?= $Page->kategori->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategori->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fungsi_produk->Visible) { // fungsi_produk ?>
    <div id="r_fungsi_produk" class="form-group row">
        <label id="elh_npd_fungsi_produk" for="x_fungsi_produk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fungsi_produk->caption() ?><?= $Page->fungsi_produk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fungsi_produk->cellAttributes() ?>>
<span id="el_npd_fungsi_produk">
<input type="<?= $Page->fungsi_produk->getInputTextType() ?>" data-table="npd" data-field="x_fungsi_produk" data-page="1" name="x_fungsi_produk" id="x_fungsi_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fungsi_produk->getPlaceHolder()) ?>" value="<?= $Page->fungsi_produk->EditValue ?>"<?= $Page->fungsi_produk->editAttributes() ?> aria-describedby="x_fungsi_produk_help">
<?= $Page->fungsi_produk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fungsi_produk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kualitasbarang->Visible) { // kualitasbarang ?>
    <div id="r_kualitasbarang" class="form-group row">
        <label id="elh_npd_kualitasbarang" for="x_kualitasbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kualitasbarang->caption() ?><?= $Page->kualitasbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kualitasbarang->cellAttributes() ?>>
<span id="el_npd_kualitasbarang">
<input type="<?= $Page->kualitasbarang->getInputTextType() ?>" data-table="npd" data-field="x_kualitasbarang" data-page="1" name="x_kualitasbarang" id="x_kualitasbarang" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kualitasbarang->getPlaceHolder()) ?>" value="<?= $Page->kualitasbarang->EditValue ?>"<?= $Page->kualitasbarang->editAttributes() ?> aria-describedby="x_kualitasbarang_help">
<?= $Page->kualitasbarang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kualitasbarang->getErrorMessage() ?></div>
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
