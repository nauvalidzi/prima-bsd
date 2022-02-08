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
        ["bentuk", [fields.bentuk.visible && fields.bentuk.required ? ew.Validators.required(fields.bentuk.caption) : null], fields.bentuk.isInvalid],
        ["viskositasbarang", [fields.viskositasbarang.visible && fields.viskositasbarang.required ? ew.Validators.required(fields.viskositasbarang.caption) : null], fields.viskositasbarang.isInvalid],
        ["idaplikasibarang", [fields.idaplikasibarang.visible && fields.idaplikasibarang.required ? ew.Validators.required(fields.idaplikasibarang.caption) : null, ew.Validators.integer], fields.idaplikasibarang.isInvalid],
        ["ukuranwadah", [fields.ukuranwadah.visible && fields.ukuranwadah.required ? ew.Validators.required(fields.ukuranwadah.caption) : null], fields.ukuranwadah.isInvalid],
        ["bahanwadah", [fields.bahanwadah.visible && fields.bahanwadah.required ? ew.Validators.required(fields.bahanwadah.caption) : null], fields.bahanwadah.isInvalid],
        ["warnawadah", [fields.warnawadah.visible && fields.warnawadah.required ? ew.Validators.required(fields.warnawadah.caption) : null], fields.warnawadah.isInvalid],
        ["bentukwadah", [fields.bentukwadah.visible && fields.bentukwadah.required ? ew.Validators.required(fields.bentukwadah.caption) : null], fields.bentukwadah.isInvalid],
        ["jenistutup", [fields.jenistutup.visible && fields.jenistutup.required ? ew.Validators.required(fields.jenistutup.caption) : null], fields.jenistutup.isInvalid],
        ["bahantutup", [fields.bahantutup.visible && fields.bahantutup.required ? ew.Validators.required(fields.bahantutup.caption) : null], fields.bahantutup.isInvalid],
        ["warnatutup", [fields.warnatutup.visible && fields.warnatutup.required ? ew.Validators.required(fields.warnatutup.caption) : null], fields.warnatutup.isInvalid],
        ["bentuktutup", [fields.bentuktutup.visible && fields.bentuktutup.required ? ew.Validators.required(fields.bentuktutup.caption) : null], fields.bentuktutup.isInvalid],
        ["segel", [fields.segel.visible && fields.segel.required ? ew.Validators.required(fields.segel.caption) : null], fields.segel.isInvalid],
        ["catatanprimer", [fields.catatanprimer.visible && fields.catatanprimer.required ? ew.Validators.required(fields.catatanprimer.caption) : null], fields.catatanprimer.isInvalid],
        ["packingkarton", [fields.packingkarton.visible && fields.packingkarton.required ? ew.Validators.required(fields.packingkarton.caption) : null], fields.packingkarton.isInvalid],
        ["keteranganpacking", [fields.keteranganpacking.visible && fields.keteranganpacking.required ? ew.Validators.required(fields.keteranganpacking.caption) : null], fields.keteranganpacking.isInvalid],
        ["beltkarton", [fields.beltkarton.visible && fields.beltkarton.required ? ew.Validators.required(fields.beltkarton.caption) : null], fields.beltkarton.isInvalid],
        ["keteranganbelt", [fields.keteranganbelt.visible && fields.keteranganbelt.required ? ew.Validators.required(fields.keteranganbelt.caption) : null], fields.keteranganbelt.isInvalid],
        ["bariskarton", [fields.bariskarton.visible && fields.bariskarton.required ? ew.Validators.required(fields.bariskarton.caption) : null, ew.Validators.integer], fields.bariskarton.isInvalid],
        ["kolomkarton", [fields.kolomkarton.visible && fields.kolomkarton.required ? ew.Validators.required(fields.kolomkarton.caption) : null, ew.Validators.integer], fields.kolomkarton.isInvalid],
        ["stackkarton", [fields.stackkarton.visible && fields.stackkarton.required ? ew.Validators.required(fields.stackkarton.caption) : null, ew.Validators.integer], fields.stackkarton.isInvalid],
        ["isikarton", [fields.isikarton.visible && fields.isikarton.required ? ew.Validators.required(fields.isikarton.caption) : null, ew.Validators.integer], fields.isikarton.isInvalid],
        ["jenislabel", [fields.jenislabel.visible && fields.jenislabel.required ? ew.Validators.required(fields.jenislabel.caption) : null], fields.jenislabel.isInvalid],
        ["keteranganjenislabel", [fields.keteranganjenislabel.visible && fields.keteranganjenislabel.required ? ew.Validators.required(fields.keteranganjenislabel.caption) : null], fields.keteranganjenislabel.isInvalid],
        ["kualitaslabel", [fields.kualitaslabel.visible && fields.kualitaslabel.required ? ew.Validators.required(fields.kualitaslabel.caption) : null], fields.kualitaslabel.isInvalid],
        ["jumlahwarnalabel", [fields.jumlahwarnalabel.visible && fields.jumlahwarnalabel.required ? ew.Validators.required(fields.jumlahwarnalabel.caption) : null], fields.jumlahwarnalabel.isInvalid],
        ["etiketlabel", [fields.etiketlabel.visible && fields.etiketlabel.required ? ew.Validators.required(fields.etiketlabel.caption) : null], fields.etiketlabel.isInvalid],
        ["keteranganetiket", [fields.keteranganetiket.visible && fields.keteranganetiket.required ? ew.Validators.required(fields.keteranganetiket.caption) : null], fields.keteranganetiket.isInvalid],
        ["kategoridelivery", [fields.kategoridelivery.visible && fields.kategoridelivery.required ? ew.Validators.required(fields.kategoridelivery.caption) : null], fields.kategoridelivery.isInvalid],
        ["alamatpengiriman", [fields.alamatpengiriman.visible && fields.alamatpengiriman.required ? ew.Validators.required(fields.alamatpengiriman.caption) : null], fields.alamatpengiriman.isInvalid],
        ["orderperdana", [fields.orderperdana.visible && fields.orderperdana.required ? ew.Validators.required(fields.orderperdana.caption) : null, ew.Validators.integer], fields.orderperdana.isInvalid],
        ["orderkontrak", [fields.orderkontrak.visible && fields.orderkontrak.required ? ew.Validators.required(fields.orderkontrak.caption) : null, ew.Validators.integer], fields.orderkontrak.isInvalid],
        ["hargapcs", [fields.hargapcs.visible && fields.hargapcs.required ? ew.Validators.required(fields.hargapcs.caption) : null, ew.Validators.integer], fields.hargapcs.isInvalid],
        ["lampiran", [fields.lampiran.visible && fields.lampiran.required ? ew.Validators.fileRequired(fields.lampiran.caption) : null], fields.lampiran.isInvalid],
        ["disetujui", [fields.disetujui.visible && fields.disetujui.required ? ew.Validators.required(fields.disetujui.caption) : null], fields.disetujui.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
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
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_harga_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<?php if ($Page->idnpd->getSessionValue() != "") { ?>
<span id="el_npd_harga_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnpd->getDisplayValue($Page->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idnpd" name="x_idnpd" value="<?= HtmlEncode($Page->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_npd_harga_idnpd">
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
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
    <div id="r_tglpengajuan" class="form-group row">
        <label id="elh_npd_harga_tglpengajuan" for="x_tglpengajuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglpengajuan->caption() ?><?= $Page->tglpengajuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglpengajuan->cellAttributes() ?>>
<span id="el_npd_harga_tglpengajuan">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <div id="r_idnpd_sample" class="form-group row">
        <label id="elh_npd_harga_idnpd_sample" for="x_idnpd_sample" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd_sample->caption() ?><?= $Page->idnpd_sample->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el_npd_harga_idnpd_sample">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <div id="r_bentuk" class="form-group row">
        <label id="elh_npd_harga_bentuk" for="x_bentuk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bentuk->caption() ?><?= $Page->bentuk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuk->cellAttributes() ?>>
<span id="el_npd_harga_bentuk">
<input type="<?= $Page->bentuk->getInputTextType() ?>" data-table="npd_harga" data-field="x_bentuk" name="x_bentuk" id="x_bentuk" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bentuk->getPlaceHolder()) ?>" value="<?= $Page->bentuk->EditValue ?>"<?= $Page->bentuk->editAttributes() ?> aria-describedby="x_bentuk_help">
<?= $Page->bentuk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositasbarang->Visible) { // viskositasbarang ?>
    <div id="r_viskositasbarang" class="form-group row">
        <label id="elh_npd_harga_viskositasbarang" for="x_viskositasbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->viskositasbarang->caption() ?><?= $Page->viskositasbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositasbarang->cellAttributes() ?>>
<span id="el_npd_harga_viskositasbarang">
<input type="<?= $Page->viskositasbarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_viskositasbarang" name="x_viskositasbarang" id="x_viskositasbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->viskositasbarang->getPlaceHolder()) ?>" value="<?= $Page->viskositasbarang->EditValue ?>"<?= $Page->viskositasbarang->editAttributes() ?> aria-describedby="x_viskositasbarang_help">
<?= $Page->viskositasbarang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositasbarang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idaplikasibarang->Visible) { // idaplikasibarang ?>
    <div id="r_idaplikasibarang" class="form-group row">
        <label id="elh_npd_harga_idaplikasibarang" for="x_idaplikasibarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idaplikasibarang->caption() ?><?= $Page->idaplikasibarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idaplikasibarang->cellAttributes() ?>>
<span id="el_npd_harga_idaplikasibarang">
<input type="<?= $Page->idaplikasibarang->getInputTextType() ?>" data-table="npd_harga" data-field="x_idaplikasibarang" name="x_idaplikasibarang" id="x_idaplikasibarang" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->idaplikasibarang->getPlaceHolder()) ?>" value="<?= $Page->idaplikasibarang->EditValue ?>"<?= $Page->idaplikasibarang->editAttributes() ?> aria-describedby="x_idaplikasibarang_help">
<?= $Page->idaplikasibarang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idaplikasibarang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuranwadah->Visible) { // ukuranwadah ?>
    <div id="r_ukuranwadah" class="form-group row">
        <label id="elh_npd_harga_ukuranwadah" for="x_ukuranwadah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuranwadah->caption() ?><?= $Page->ukuranwadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuranwadah->cellAttributes() ?>>
<span id="el_npd_harga_ukuranwadah">
<input type="<?= $Page->ukuranwadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_ukuranwadah" name="x_ukuranwadah" id="x_ukuranwadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ukuranwadah->getPlaceHolder()) ?>" value="<?= $Page->ukuranwadah->EditValue ?>"<?= $Page->ukuranwadah->editAttributes() ?> aria-describedby="x_ukuranwadah_help">
<?= $Page->ukuranwadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuranwadah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahanwadah->Visible) { // bahanwadah ?>
    <div id="r_bahanwadah" class="form-group row">
        <label id="elh_npd_harga_bahanwadah" for="x_bahanwadah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bahanwadah->caption() ?><?= $Page->bahanwadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahanwadah->cellAttributes() ?>>
<span id="el_npd_harga_bahanwadah">
<input type="<?= $Page->bahanwadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_bahanwadah" name="x_bahanwadah" id="x_bahanwadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahanwadah->getPlaceHolder()) ?>" value="<?= $Page->bahanwadah->EditValue ?>"<?= $Page->bahanwadah->editAttributes() ?> aria-describedby="x_bahanwadah_help">
<?= $Page->bahanwadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahanwadah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warnawadah->Visible) { // warnawadah ?>
    <div id="r_warnawadah" class="form-group row">
        <label id="elh_npd_harga_warnawadah" for="x_warnawadah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warnawadah->caption() ?><?= $Page->warnawadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warnawadah->cellAttributes() ?>>
<span id="el_npd_harga_warnawadah">
<input type="<?= $Page->warnawadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_warnawadah" name="x_warnawadah" id="x_warnawadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warnawadah->getPlaceHolder()) ?>" value="<?= $Page->warnawadah->EditValue ?>"<?= $Page->warnawadah->editAttributes() ?> aria-describedby="x_warnawadah_help">
<?= $Page->warnawadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warnawadah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentukwadah->Visible) { // bentukwadah ?>
    <div id="r_bentukwadah" class="form-group row">
        <label id="elh_npd_harga_bentukwadah" for="x_bentukwadah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bentukwadah->caption() ?><?= $Page->bentukwadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentukwadah->cellAttributes() ?>>
<span id="el_npd_harga_bentukwadah">
<input type="<?= $Page->bentukwadah->getInputTextType() ?>" data-table="npd_harga" data-field="x_bentukwadah" name="x_bentukwadah" id="x_bentukwadah" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bentukwadah->getPlaceHolder()) ?>" value="<?= $Page->bentukwadah->EditValue ?>"<?= $Page->bentukwadah->editAttributes() ?> aria-describedby="x_bentukwadah_help">
<?= $Page->bentukwadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentukwadah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
    <div id="r_jenistutup" class="form-group row">
        <label id="elh_npd_harga_jenistutup" for="x_jenistutup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenistutup->caption() ?><?= $Page->jenistutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenistutup->cellAttributes() ?>>
<span id="el_npd_harga_jenistutup">
<input type="<?= $Page->jenistutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_jenistutup" name="x_jenistutup" id="x_jenistutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->jenistutup->getPlaceHolder()) ?>" value="<?= $Page->jenistutup->EditValue ?>"<?= $Page->jenistutup->editAttributes() ?> aria-describedby="x_jenistutup_help">
<?= $Page->jenistutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenistutup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahantutup->Visible) { // bahantutup ?>
    <div id="r_bahantutup" class="form-group row">
        <label id="elh_npd_harga_bahantutup" for="x_bahantutup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bahantutup->caption() ?><?= $Page->bahantutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahantutup->cellAttributes() ?>>
<span id="el_npd_harga_bahantutup">
<input type="<?= $Page->bahantutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_bahantutup" name="x_bahantutup" id="x_bahantutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahantutup->getPlaceHolder()) ?>" value="<?= $Page->bahantutup->EditValue ?>"<?= $Page->bahantutup->editAttributes() ?> aria-describedby="x_bahantutup_help">
<?= $Page->bahantutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahantutup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warnatutup->Visible) { // warnatutup ?>
    <div id="r_warnatutup" class="form-group row">
        <label id="elh_npd_harga_warnatutup" for="x_warnatutup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warnatutup->caption() ?><?= $Page->warnatutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warnatutup->cellAttributes() ?>>
<span id="el_npd_harga_warnatutup">
<input type="<?= $Page->warnatutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_warnatutup" name="x_warnatutup" id="x_warnatutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warnatutup->getPlaceHolder()) ?>" value="<?= $Page->warnatutup->EditValue ?>"<?= $Page->warnatutup->editAttributes() ?> aria-describedby="x_warnatutup_help">
<?= $Page->warnatutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warnatutup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuktutup->Visible) { // bentuktutup ?>
    <div id="r_bentuktutup" class="form-group row">
        <label id="elh_npd_harga_bentuktutup" for="x_bentuktutup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bentuktutup->caption() ?><?= $Page->bentuktutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuktutup->cellAttributes() ?>>
<span id="el_npd_harga_bentuktutup">
<input type="<?= $Page->bentuktutup->getInputTextType() ?>" data-table="npd_harga" data-field="x_bentuktutup" name="x_bentuktutup" id="x_bentuktutup" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bentuktutup->getPlaceHolder()) ?>" value="<?= $Page->bentuktutup->EditValue ?>"<?= $Page->bentuktutup->editAttributes() ?> aria-describedby="x_bentuktutup_help">
<?= $Page->bentuktutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuktutup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->segel->Visible) { // segel ?>
    <div id="r_segel" class="form-group row">
        <label id="elh_npd_harga_segel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->segel->caption() ?><?= $Page->segel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->segel->cellAttributes() ?>>
<span id="el_npd_harga_segel">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatanprimer->Visible) { // catatanprimer ?>
    <div id="r_catatanprimer" class="form-group row">
        <label id="elh_npd_harga_catatanprimer" for="x_catatanprimer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->catatanprimer->caption() ?><?= $Page->catatanprimer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatanprimer->cellAttributes() ?>>
<span id="el_npd_harga_catatanprimer">
<textarea data-table="npd_harga" data-field="x_catatanprimer" name="x_catatanprimer" id="x_catatanprimer" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatanprimer->getPlaceHolder()) ?>"<?= $Page->catatanprimer->editAttributes() ?> aria-describedby="x_catatanprimer_help"><?= $Page->catatanprimer->EditValue ?></textarea>
<?= $Page->catatanprimer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatanprimer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->packingkarton->Visible) { // packingkarton ?>
    <div id="r_packingkarton" class="form-group row">
        <label id="elh_npd_harga_packingkarton" for="x_packingkarton" class="<?= $Page->LeftColumnClass ?>"><?= $Page->packingkarton->caption() ?><?= $Page->packingkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->packingkarton->cellAttributes() ?>>
<span id="el_npd_harga_packingkarton">
<input type="<?= $Page->packingkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_packingkarton" name="x_packingkarton" id="x_packingkarton" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->packingkarton->getPlaceHolder()) ?>" value="<?= $Page->packingkarton->EditValue ?>"<?= $Page->packingkarton->editAttributes() ?> aria-describedby="x_packingkarton_help">
<?= $Page->packingkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->packingkarton->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganpacking->Visible) { // keteranganpacking ?>
    <div id="r_keteranganpacking" class="form-group row">
        <label id="elh_npd_harga_keteranganpacking" for="x_keteranganpacking" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keteranganpacking->caption() ?><?= $Page->keteranganpacking->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganpacking->cellAttributes() ?>>
<span id="el_npd_harga_keteranganpacking">
<textarea data-table="npd_harga" data-field="x_keteranganpacking" name="x_keteranganpacking" id="x_keteranganpacking" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganpacking->getPlaceHolder()) ?>"<?= $Page->keteranganpacking->editAttributes() ?> aria-describedby="x_keteranganpacking_help"><?= $Page->keteranganpacking->EditValue ?></textarea>
<?= $Page->keteranganpacking->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganpacking->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->beltkarton->Visible) { // beltkarton ?>
    <div id="r_beltkarton" class="form-group row">
        <label id="elh_npd_harga_beltkarton" for="x_beltkarton" class="<?= $Page->LeftColumnClass ?>"><?= $Page->beltkarton->caption() ?><?= $Page->beltkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->beltkarton->cellAttributes() ?>>
<span id="el_npd_harga_beltkarton">
<input type="<?= $Page->beltkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_beltkarton" name="x_beltkarton" id="x_beltkarton" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->beltkarton->getPlaceHolder()) ?>" value="<?= $Page->beltkarton->EditValue ?>"<?= $Page->beltkarton->editAttributes() ?> aria-describedby="x_beltkarton_help">
<?= $Page->beltkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->beltkarton->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganbelt->Visible) { // keteranganbelt ?>
    <div id="r_keteranganbelt" class="form-group row">
        <label id="elh_npd_harga_keteranganbelt" for="x_keteranganbelt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keteranganbelt->caption() ?><?= $Page->keteranganbelt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganbelt->cellAttributes() ?>>
<span id="el_npd_harga_keteranganbelt">
<textarea data-table="npd_harga" data-field="x_keteranganbelt" name="x_keteranganbelt" id="x_keteranganbelt" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganbelt->getPlaceHolder()) ?>"<?= $Page->keteranganbelt->editAttributes() ?> aria-describedby="x_keteranganbelt_help"><?= $Page->keteranganbelt->EditValue ?></textarea>
<?= $Page->keteranganbelt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganbelt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bariskarton->Visible) { // bariskarton ?>
    <div id="r_bariskarton" class="form-group row">
        <label id="elh_npd_harga_bariskarton" for="x_bariskarton" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bariskarton->caption() ?><?= $Page->bariskarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bariskarton->cellAttributes() ?>>
<span id="el_npd_harga_bariskarton">
<input type="<?= $Page->bariskarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_bariskarton" name="x_bariskarton" id="x_bariskarton" size="30" placeholder="<?= HtmlEncode($Page->bariskarton->getPlaceHolder()) ?>" value="<?= $Page->bariskarton->EditValue ?>"<?= $Page->bariskarton->editAttributes() ?> aria-describedby="x_bariskarton_help">
<?= $Page->bariskarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bariskarton->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kolomkarton->Visible) { // kolomkarton ?>
    <div id="r_kolomkarton" class="form-group row">
        <label id="elh_npd_harga_kolomkarton" for="x_kolomkarton" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kolomkarton->caption() ?><?= $Page->kolomkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kolomkarton->cellAttributes() ?>>
<span id="el_npd_harga_kolomkarton">
<input type="<?= $Page->kolomkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_kolomkarton" name="x_kolomkarton" id="x_kolomkarton" size="30" placeholder="<?= HtmlEncode($Page->kolomkarton->getPlaceHolder()) ?>" value="<?= $Page->kolomkarton->EditValue ?>"<?= $Page->kolomkarton->editAttributes() ?> aria-describedby="x_kolomkarton_help">
<?= $Page->kolomkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kolomkarton->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->stackkarton->Visible) { // stackkarton ?>
    <div id="r_stackkarton" class="form-group row">
        <label id="elh_npd_harga_stackkarton" for="x_stackkarton" class="<?= $Page->LeftColumnClass ?>"><?= $Page->stackkarton->caption() ?><?= $Page->stackkarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->stackkarton->cellAttributes() ?>>
<span id="el_npd_harga_stackkarton">
<input type="<?= $Page->stackkarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_stackkarton" name="x_stackkarton" id="x_stackkarton" size="30" placeholder="<?= HtmlEncode($Page->stackkarton->getPlaceHolder()) ?>" value="<?= $Page->stackkarton->EditValue ?>"<?= $Page->stackkarton->editAttributes() ?> aria-describedby="x_stackkarton_help">
<?= $Page->stackkarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->stackkarton->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isikarton->Visible) { // isikarton ?>
    <div id="r_isikarton" class="form-group row">
        <label id="elh_npd_harga_isikarton" for="x_isikarton" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isikarton->caption() ?><?= $Page->isikarton->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isikarton->cellAttributes() ?>>
<span id="el_npd_harga_isikarton">
<input type="<?= $Page->isikarton->getInputTextType() ?>" data-table="npd_harga" data-field="x_isikarton" name="x_isikarton" id="x_isikarton" size="30" placeholder="<?= HtmlEncode($Page->isikarton->getPlaceHolder()) ?>" value="<?= $Page->isikarton->EditValue ?>"<?= $Page->isikarton->editAttributes() ?> aria-describedby="x_isikarton_help">
<?= $Page->isikarton->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isikarton->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenislabel->Visible) { // jenislabel ?>
    <div id="r_jenislabel" class="form-group row">
        <label id="elh_npd_harga_jenislabel" for="x_jenislabel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenislabel->caption() ?><?= $Page->jenislabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenislabel->cellAttributes() ?>>
<span id="el_npd_harga_jenislabel">
<input type="<?= $Page->jenislabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_jenislabel" name="x_jenislabel" id="x_jenislabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jenislabel->getPlaceHolder()) ?>" value="<?= $Page->jenislabel->EditValue ?>"<?= $Page->jenislabel->editAttributes() ?> aria-describedby="x_jenislabel_help">
<?= $Page->jenislabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenislabel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganjenislabel->Visible) { // keteranganjenislabel ?>
    <div id="r_keteranganjenislabel" class="form-group row">
        <label id="elh_npd_harga_keteranganjenislabel" for="x_keteranganjenislabel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keteranganjenislabel->caption() ?><?= $Page->keteranganjenislabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganjenislabel->cellAttributes() ?>>
<span id="el_npd_harga_keteranganjenislabel">
<textarea data-table="npd_harga" data-field="x_keteranganjenislabel" name="x_keteranganjenislabel" id="x_keteranganjenislabel" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganjenislabel->getPlaceHolder()) ?>"<?= $Page->keteranganjenislabel->editAttributes() ?> aria-describedby="x_keteranganjenislabel_help"><?= $Page->keteranganjenislabel->EditValue ?></textarea>
<?= $Page->keteranganjenislabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganjenislabel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kualitaslabel->Visible) { // kualitaslabel ?>
    <div id="r_kualitaslabel" class="form-group row">
        <label id="elh_npd_harga_kualitaslabel" for="x_kualitaslabel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kualitaslabel->caption() ?><?= $Page->kualitaslabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kualitaslabel->cellAttributes() ?>>
<span id="el_npd_harga_kualitaslabel">
<input type="<?= $Page->kualitaslabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_kualitaslabel" name="x_kualitaslabel" id="x_kualitaslabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kualitaslabel->getPlaceHolder()) ?>" value="<?= $Page->kualitaslabel->EditValue ?>"<?= $Page->kualitaslabel->editAttributes() ?> aria-describedby="x_kualitaslabel_help">
<?= $Page->kualitaslabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kualitaslabel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahwarnalabel->Visible) { // jumlahwarnalabel ?>
    <div id="r_jumlahwarnalabel" class="form-group row">
        <label id="elh_npd_harga_jumlahwarnalabel" for="x_jumlahwarnalabel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahwarnalabel->caption() ?><?= $Page->jumlahwarnalabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahwarnalabel->cellAttributes() ?>>
<span id="el_npd_harga_jumlahwarnalabel">
<input type="<?= $Page->jumlahwarnalabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_jumlahwarnalabel" name="x_jumlahwarnalabel" id="x_jumlahwarnalabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jumlahwarnalabel->getPlaceHolder()) ?>" value="<?= $Page->jumlahwarnalabel->EditValue ?>"<?= $Page->jumlahwarnalabel->editAttributes() ?> aria-describedby="x_jumlahwarnalabel_help">
<?= $Page->jumlahwarnalabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahwarnalabel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->etiketlabel->Visible) { // etiketlabel ?>
    <div id="r_etiketlabel" class="form-group row">
        <label id="elh_npd_harga_etiketlabel" for="x_etiketlabel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->etiketlabel->caption() ?><?= $Page->etiketlabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->etiketlabel->cellAttributes() ?>>
<span id="el_npd_harga_etiketlabel">
<input type="<?= $Page->etiketlabel->getInputTextType() ?>" data-table="npd_harga" data-field="x_etiketlabel" name="x_etiketlabel" id="x_etiketlabel" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->etiketlabel->getPlaceHolder()) ?>" value="<?= $Page->etiketlabel->EditValue ?>"<?= $Page->etiketlabel->editAttributes() ?> aria-describedby="x_etiketlabel_help">
<?= $Page->etiketlabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->etiketlabel->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keteranganetiket->Visible) { // keteranganetiket ?>
    <div id="r_keteranganetiket" class="form-group row">
        <label id="elh_npd_harga_keteranganetiket" for="x_keteranganetiket" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keteranganetiket->caption() ?><?= $Page->keteranganetiket->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keteranganetiket->cellAttributes() ?>>
<span id="el_npd_harga_keteranganetiket">
<textarea data-table="npd_harga" data-field="x_keteranganetiket" name="x_keteranganetiket" id="x_keteranganetiket" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keteranganetiket->getPlaceHolder()) ?>"<?= $Page->keteranganetiket->editAttributes() ?> aria-describedby="x_keteranganetiket_help"><?= $Page->keteranganetiket->EditValue ?></textarea>
<?= $Page->keteranganetiket->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keteranganetiket->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategoridelivery->Visible) { // kategoridelivery ?>
    <div id="r_kategoridelivery" class="form-group row">
        <label id="elh_npd_harga_kategoridelivery" for="x_kategoridelivery" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kategoridelivery->caption() ?><?= $Page->kategoridelivery->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategoridelivery->cellAttributes() ?>>
<span id="el_npd_harga_kategoridelivery">
<input type="<?= $Page->kategoridelivery->getInputTextType() ?>" data-table="npd_harga" data-field="x_kategoridelivery" name="x_kategoridelivery" id="x_kategoridelivery" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kategoridelivery->getPlaceHolder()) ?>" value="<?= $Page->kategoridelivery->EditValue ?>"<?= $Page->kategoridelivery->editAttributes() ?> aria-describedby="x_kategoridelivery_help">
<?= $Page->kategoridelivery->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategoridelivery->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamatpengiriman->Visible) { // alamatpengiriman ?>
    <div id="r_alamatpengiriman" class="form-group row">
        <label id="elh_npd_harga_alamatpengiriman" for="x_alamatpengiriman" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamatpengiriman->caption() ?><?= $Page->alamatpengiriman->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamatpengiriman->cellAttributes() ?>>
<span id="el_npd_harga_alamatpengiriman">
<input type="<?= $Page->alamatpengiriman->getInputTextType() ?>" data-table="npd_harga" data-field="x_alamatpengiriman" name="x_alamatpengiriman" id="x_alamatpengiriman" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->alamatpengiriman->getPlaceHolder()) ?>" value="<?= $Page->alamatpengiriman->EditValue ?>"<?= $Page->alamatpengiriman->editAttributes() ?> aria-describedby="x_alamatpengiriman_help">
<?= $Page->alamatpengiriman->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamatpengiriman->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
    <div id="r_orderperdana" class="form-group row">
        <label id="elh_npd_harga_orderperdana" for="x_orderperdana" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderperdana->caption() ?><?= $Page->orderperdana->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderperdana->cellAttributes() ?>>
<span id="el_npd_harga_orderperdana">
<input type="<?= $Page->orderperdana->getInputTextType() ?>" data-table="npd_harga" data-field="x_orderperdana" name="x_orderperdana" id="x_orderperdana" size="30" placeholder="<?= HtmlEncode($Page->orderperdana->getPlaceHolder()) ?>" value="<?= $Page->orderperdana->EditValue ?>"<?= $Page->orderperdana->editAttributes() ?> aria-describedby="x_orderperdana_help">
<?= $Page->orderperdana->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderperdana->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderkontrak->Visible) { // orderkontrak ?>
    <div id="r_orderkontrak" class="form-group row">
        <label id="elh_npd_harga_orderkontrak" for="x_orderkontrak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orderkontrak->caption() ?><?= $Page->orderkontrak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderkontrak->cellAttributes() ?>>
<span id="el_npd_harga_orderkontrak">
<input type="<?= $Page->orderkontrak->getInputTextType() ?>" data-table="npd_harga" data-field="x_orderkontrak" name="x_orderkontrak" id="x_orderkontrak" size="30" placeholder="<?= HtmlEncode($Page->orderkontrak->getPlaceHolder()) ?>" value="<?= $Page->orderkontrak->EditValue ?>"<?= $Page->orderkontrak->editAttributes() ?> aria-describedby="x_orderkontrak_help">
<?= $Page->orderkontrak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderkontrak->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hargapcs->Visible) { // hargapcs ?>
    <div id="r_hargapcs" class="form-group row">
        <label id="elh_npd_harga_hargapcs" for="x_hargapcs" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hargapcs->caption() ?><?= $Page->hargapcs->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hargapcs->cellAttributes() ?>>
<span id="el_npd_harga_hargapcs">
<input type="<?= $Page->hargapcs->getInputTextType() ?>" data-table="npd_harga" data-field="x_hargapcs" name="x_hargapcs" id="x_hargapcs" size="30" placeholder="<?= HtmlEncode($Page->hargapcs->getPlaceHolder()) ?>" value="<?= $Page->hargapcs->EditValue ?>"<?= $Page->hargapcs->editAttributes() ?> aria-describedby="x_hargapcs_help">
<?= $Page->hargapcs->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hargapcs->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <div id="r_lampiran" class="form-group row">
        <label id="elh_npd_harga_lampiran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lampiran->caption() ?><?= $Page->lampiran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lampiran->cellAttributes() ?>>
<span id="el_npd_harga_lampiran">
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
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
    <div id="r_disetujui" class="form-group row">
        <label id="elh_npd_harga_disetujui" class="<?= $Page->LeftColumnClass ?>"><?= $Page->disetujui->caption() ?><?= $Page->disetujui->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->disetujui->cellAttributes() ?>>
<span id="el_npd_harga_disetujui">
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
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_npd_harga_created_by">
    <input type="hidden" data-table="npd_harga" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
    </span>
</div><!-- /page* -->
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
    ew.addEventHandlers("npd_harga");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#r_idnpd_sample").before('<h5 class="form-group">Data Sample (Isi Sediaan)</h5>'),$("#r_ukuranwadah").before('<h5 class="form-group">Kemasan Primer (Wadah)</h5>'),$("#r_jenistutup").before('<h5 class="form-group">Kemasan Primer (Tutup)</h5>'),$("#r_packingkarton").before('<h5 class="form-group">Kemasan Sekunder</h5>'),$("#r_bariskarton").before('<h5 class="form-group">Kemasan Karton Luar</h5>'),$("#r_jenislabel").before('<h5 class="form-group">Label</h5>'),$("#r_kategoridelivery").before('<h5 class="form-group">Delivery</h5>'),$("#r_orderperdana").before('<h5 class="form-group">Jumlah Order (Produksi)</h5>'),$("#r_hargapcs").before('<h5 class="form-group">Harga Penawaran</h5>');
});
</script>
