<?php

namespace PHPMaker2021\distributor;

// Page object
$CustomerAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcustomeradd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fcustomeradd = currentForm = new ew.Form("fcustomeradd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "customer")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.customer)
        ew.vars.tables.customer = currentTable;
    fcustomeradd.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["idtipecustomer", [fields.idtipecustomer.visible && fields.idtipecustomer.required ? ew.Validators.required(fields.idtipecustomer.caption) : null], fields.idtipecustomer.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["jenis_usaha", [fields.jenis_usaha.visible && fields.jenis_usaha.required ? ew.Validators.required(fields.jenis_usaha.caption) : null], fields.jenis_usaha.isInvalid],
        ["jabatan", [fields.jabatan.visible && fields.jabatan.required ? ew.Validators.required(fields.jabatan.caption) : null], fields.jabatan.isInvalid],
        ["idprov", [fields.idprov.visible && fields.idprov.required ? ew.Validators.required(fields.idprov.caption) : null], fields.idprov.isInvalid],
        ["idkab", [fields.idkab.visible && fields.idkab.required ? ew.Validators.required(fields.idkab.caption) : null], fields.idkab.isInvalid],
        ["idkec", [fields.idkec.visible && fields.idkec.required ? ew.Validators.required(fields.idkec.caption) : null], fields.idkec.isInvalid],
        ["idkel", [fields.idkel.visible && fields.idkel.required ? ew.Validators.required(fields.idkel.caption) : null], fields.idkel.isInvalid],
        ["kodepos", [fields.kodepos.visible && fields.kodepos.required ? ew.Validators.required(fields.kodepos.caption) : null], fields.kodepos.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["telpon", [fields.telpon.visible && fields.telpon.required ? ew.Validators.required(fields.telpon.caption) : null], fields.telpon.isInvalid],
        ["hp", [fields.hp.visible && fields.hp.required ? ew.Validators.required(fields.hp.caption) : null, ew.Validators.regex("^(62)8[1-9][0-9]{7,11}$")], fields.hp.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["website", [fields.website.visible && fields.website.required ? ew.Validators.required(fields.website.caption) : null], fields.website.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["ktp", [fields.ktp.visible && fields.ktp.required ? ew.Validators.required(fields.ktp.caption) : null], fields.ktp.isInvalid],
        ["npwp", [fields.npwp.visible && fields.npwp.required ? ew.Validators.required(fields.npwp.caption) : null], fields.npwp.isInvalid],
        ["limit_kredit_order", [fields.limit_kredit_order.visible && fields.limit_kredit_order.required ? ew.Validators.required(fields.limit_kredit_order.caption) : null, ew.Validators.integer], fields.limit_kredit_order.isInvalid],
        ["jatuh_tempo_invoice", [fields.jatuh_tempo_invoice.visible && fields.jatuh_tempo_invoice.required ? ew.Validators.required(fields.jatuh_tempo_invoice.caption) : null], fields.jatuh_tempo_invoice.isInvalid],
        ["kodenpd", [fields.kodenpd.visible && fields.kodenpd.required ? ew.Validators.required(fields.kodenpd.caption) : null], fields.kodenpd.isInvalid],
        ["klinik", [fields.klinik.visible && fields.klinik.required ? ew.Validators.required(fields.klinik.caption) : null], fields.klinik.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fcustomeradd,
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
    fcustomeradd.validate = function () {
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
    fcustomeradd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcustomeradd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fcustomeradd.lists.idtipecustomer = <?= $Page->idtipecustomer->toClientList($Page) ?>;
    fcustomeradd.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    fcustomeradd.lists.idprov = <?= $Page->idprov->toClientList($Page) ?>;
    fcustomeradd.lists.idkab = <?= $Page->idkab->toClientList($Page) ?>;
    fcustomeradd.lists.idkec = <?= $Page->idkec->toClientList($Page) ?>;
    fcustomeradd.lists.idkel = <?= $Page->idkel->toClientList($Page) ?>;
    fcustomeradd.lists.jatuh_tempo_invoice = <?= $Page->jatuh_tempo_invoice->toClientList($Page) ?>;
    loadjs.done("fcustomeradd");
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
<form name="fcustomeradd" id="fcustomeradd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="customer">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "pegawai") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pegawai">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idpegawai->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_customer_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_customer_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="customer" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idtipecustomer->Visible) { // idtipecustomer ?>
    <div id="r_idtipecustomer" class="form-group row">
        <label id="elh_customer_idtipecustomer" for="x_idtipecustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idtipecustomer->caption() ?><?= $Page->idtipecustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idtipecustomer->cellAttributes() ?>>
<span id="el_customer_idtipecustomer">
    <select
        id="x_idtipecustomer"
        name="x_idtipecustomer"
        class="form-control ew-select<?= $Page->idtipecustomer->isInvalidClass() ?>"
        data-select2-id="customer_x_idtipecustomer"
        data-table="customer"
        data-field="x_idtipecustomer"
        data-value-separator="<?= $Page->idtipecustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idtipecustomer->getPlaceHolder()) ?>"
        <?= $Page->idtipecustomer->editAttributes() ?>>
        <?= $Page->idtipecustomer->selectOptionListHtml("x_idtipecustomer") ?>
    </select>
    <?= $Page->idtipecustomer->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idtipecustomer->getErrorMessage() ?></div>
<?= $Page->idtipecustomer->Lookup->getParamTag($Page, "p_x_idtipecustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x_idtipecustomer']"),
        options = { name: "x_idtipecustomer", selectId: "customer_x_idtipecustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idtipecustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_customer_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<?php if ($Page->idpegawai->getSessionValue() != "") { ?>
<span id="el_customer_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idpegawai->getDisplayValue($Page->idpegawai->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idpegawai" name="x_idpegawai" value="<?= HtmlEncode($Page->idpegawai->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_customer_idpegawai">
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="customer_x_idpegawai"
        data-table="customer"
        data-field="x_idpegawai"
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
    var el = document.querySelector("select[data-select2-id='customer_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "customer_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_customer_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_customer_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="customer" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenis_usaha->Visible) { // jenis_usaha ?>
    <div id="r_jenis_usaha" class="form-group row">
        <label id="elh_customer_jenis_usaha" for="x_jenis_usaha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenis_usaha->caption() ?><?= $Page->jenis_usaha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis_usaha->cellAttributes() ?>>
<span id="el_customer_jenis_usaha">
<input type="<?= $Page->jenis_usaha->getInputTextType() ?>" data-table="customer" data-field="x_jenis_usaha" name="x_jenis_usaha" id="x_jenis_usaha" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->jenis_usaha->getPlaceHolder()) ?>" value="<?= $Page->jenis_usaha->EditValue ?>"<?= $Page->jenis_usaha->editAttributes() ?> aria-describedby="x_jenis_usaha_help">
<?= $Page->jenis_usaha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenis_usaha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label id="elh_customer_jabatan" for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan->caption() ?><?= $Page->jabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_customer_jabatan">
<input type="<?= $Page->jabatan->getInputTextType() ?>" data-table="customer" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jabatan->getPlaceHolder()) ?>" value="<?= $Page->jabatan->EditValue ?>"<?= $Page->jabatan->editAttributes() ?> aria-describedby="x_jabatan_help">
<?= $Page->jabatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idprov->Visible) { // idprov ?>
    <div id="r_idprov" class="form-group row">
        <label id="elh_customer_idprov" for="x_idprov" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idprov->caption() ?><?= $Page->idprov->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idprov->cellAttributes() ?>>
<span id="el_customer_idprov">
<?php $Page->idprov->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idprov"
        name="x_idprov"
        class="form-control ew-select<?= $Page->idprov->isInvalidClass() ?>"
        data-select2-id="customer_x_idprov"
        data-table="customer"
        data-field="x_idprov"
        data-value-separator="<?= $Page->idprov->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idprov->getPlaceHolder()) ?>"
        <?= $Page->idprov->editAttributes() ?>>
        <?= $Page->idprov->selectOptionListHtml("x_idprov") ?>
    </select>
    <?= $Page->idprov->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idprov->getErrorMessage() ?></div>
<?= $Page->idprov->Lookup->getParamTag($Page, "p_x_idprov") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x_idprov']"),
        options = { name: "x_idprov", selectId: "customer_x_idprov", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idprov.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkab->Visible) { // idkab ?>
    <div id="r_idkab" class="form-group row">
        <label id="elh_customer_idkab" for="x_idkab" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkab->caption() ?><?= $Page->idkab->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkab->cellAttributes() ?>>
<span id="el_customer_idkab">
<?php $Page->idkab->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idkab"
        name="x_idkab"
        class="form-control ew-select<?= $Page->idkab->isInvalidClass() ?>"
        data-select2-id="customer_x_idkab"
        data-table="customer"
        data-field="x_idkab"
        data-value-separator="<?= $Page->idkab->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkab->getPlaceHolder()) ?>"
        <?= $Page->idkab->editAttributes() ?>>
        <?= $Page->idkab->selectOptionListHtml("x_idkab") ?>
    </select>
    <?= $Page->idkab->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkab->getErrorMessage() ?></div>
<?= $Page->idkab->Lookup->getParamTag($Page, "p_x_idkab") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x_idkab']"),
        options = { name: "x_idkab", selectId: "customer_x_idkab", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idkab.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkec->Visible) { // idkec ?>
    <div id="r_idkec" class="form-group row">
        <label id="elh_customer_idkec" for="x_idkec" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkec->caption() ?><?= $Page->idkec->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkec->cellAttributes() ?>>
<span id="el_customer_idkec">
<?php $Page->idkec->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idkec"
        name="x_idkec"
        class="form-control ew-select<?= $Page->idkec->isInvalidClass() ?>"
        data-select2-id="customer_x_idkec"
        data-table="customer"
        data-field="x_idkec"
        data-value-separator="<?= $Page->idkec->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkec->getPlaceHolder()) ?>"
        <?= $Page->idkec->editAttributes() ?>>
        <?= $Page->idkec->selectOptionListHtml("x_idkec") ?>
    </select>
    <?= $Page->idkec->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkec->getErrorMessage() ?></div>
<?= $Page->idkec->Lookup->getParamTag($Page, "p_x_idkec") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x_idkec']"),
        options = { name: "x_idkec", selectId: "customer_x_idkec", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idkec.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkel->Visible) { // idkel ?>
    <div id="r_idkel" class="form-group row">
        <label id="elh_customer_idkel" for="x_idkel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkel->caption() ?><?= $Page->idkel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkel->cellAttributes() ?>>
<span id="el_customer_idkel">
    <select
        id="x_idkel"
        name="x_idkel"
        class="form-control ew-select<?= $Page->idkel->isInvalidClass() ?>"
        data-select2-id="customer_x_idkel"
        data-table="customer"
        data-field="x_idkel"
        data-value-separator="<?= $Page->idkel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkel->getPlaceHolder()) ?>"
        <?= $Page->idkel->editAttributes() ?>>
        <?= $Page->idkel->selectOptionListHtml("x_idkel") ?>
    </select>
    <?= $Page->idkel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkel->getErrorMessage() ?></div>
<?= $Page->idkel->Lookup->getParamTag($Page, "p_x_idkel") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x_idkel']"),
        options = { name: "x_idkel", selectId: "customer_x_idkel", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.idkel.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
    <div id="r_kodepos" class="form-group row">
        <label id="elh_customer_kodepos" for="x_kodepos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kodepos->caption() ?><?= $Page->kodepos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodepos->cellAttributes() ?>>
<span id="el_customer_kodepos">
<input type="<?= $Page->kodepos->getInputTextType() ?>" data-table="customer" data-field="x_kodepos" name="x_kodepos" id="x_kodepos" size="7" maxlength="50" placeholder="<?= HtmlEncode($Page->kodepos->getPlaceHolder()) ?>" value="<?= $Page->kodepos->EditValue ?>"<?= $Page->kodepos->editAttributes() ?> aria-describedby="x_kodepos_help">
<?= $Page->kodepos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kodepos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_customer_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<span id="el_customer_alamat">
<textarea data-table="customer" data-field="x_alamat" name="x_alamat" id="x_alamat" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help"><?= $Page->alamat->EditValue ?></textarea>
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
    <div id="r_telpon" class="form-group row">
        <label id="elh_customer_telpon" for="x_telpon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telpon->caption() ?><?= $Page->telpon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->telpon->cellAttributes() ?>>
<span id="el_customer_telpon">
<input type="<?= $Page->telpon->getInputTextType() ?>" data-table="customer" data-field="x_telpon" name="x_telpon" id="x_telpon" size="15" maxlength="255" placeholder="<?= HtmlEncode($Page->telpon->getPlaceHolder()) ?>" value="<?= $Page->telpon->EditValue ?>"<?= $Page->telpon->editAttributes() ?> aria-describedby="x_telpon_help">
<?= $Page->telpon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telpon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <div id="r_hp" class="form-group row">
        <label id="elh_customer_hp" for="x_hp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hp->caption() ?><?= $Page->hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hp->cellAttributes() ?>>
<span id="el_customer_hp">
<input type="<?= $Page->hp->getInputTextType() ?>" data-table="customer" data-field="x_hp" name="x_hp" id="x_hp" size="15" maxlength="255" placeholder="<?= HtmlEncode($Page->hp->getPlaceHolder()) ?>" value="<?= $Page->hp->EditValue ?>"<?= $Page->hp->editAttributes() ?> aria-describedby="x_hp_help">
<?= $Page->hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_customer__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<span id="el_customer__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="customer" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div id="r_website" class="form-group row">
        <label id="elh_customer_website" for="x_website" class="<?= $Page->LeftColumnClass ?>"><?= $Page->website->caption() ?><?= $Page->website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->website->cellAttributes() ?>>
<span id="el_customer_website">
<input type="<?= $Page->website->getInputTextType() ?>" data-table="customer" data-field="x_website" name="x_website" id="x_website" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>" value="<?= $Page->website->EditValue ?>"<?= $Page->website->editAttributes() ?> aria-describedby="x_website_help">
<?= $Page->website->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_customer_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_customer_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="customer" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
        <label class="custom-file-label ew-file-label" for="x_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="0">
<input type="hidden" name="fs_x_foto" id= "fs_x_foto" value="255">
<input type="hidden" name="fx_x_foto" id= "fx_x_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto" id= "fm_x_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_foto" id= "fc_x_foto" value="<?= $Page->foto->UploadMaxFileCount ?>">
</div>
<table id="ft_x_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
    <div id="r_ktp" class="form-group row">
        <label id="elh_customer_ktp" for="x_ktp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ktp->caption() ?><?= $Page->ktp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ktp->cellAttributes() ?>>
<span id="el_customer_ktp">
<input type="<?= $Page->ktp->getInputTextType() ?>" data-table="customer" data-field="x_ktp" name="x_ktp" id="x_ktp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ktp->getPlaceHolder()) ?>" value="<?= $Page->ktp->EditValue ?>"<?= $Page->ktp->editAttributes() ?> aria-describedby="x_ktp_help">
<?= $Page->ktp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ktp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
    <div id="r_npwp" class="form-group row">
        <label id="elh_customer_npwp" for="x_npwp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->npwp->caption() ?><?= $Page->npwp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->npwp->cellAttributes() ?>>
<span id="el_customer_npwp">
<input type="<?= $Page->npwp->getInputTextType() ?>" data-table="customer" data-field="x_npwp" name="x_npwp" id="x_npwp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->npwp->getPlaceHolder()) ?>" value="<?= $Page->npwp->EditValue ?>"<?= $Page->npwp->editAttributes() ?> aria-describedby="x_npwp_help">
<?= $Page->npwp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->npwp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limit_kredit_order->Visible) { // limit_kredit_order ?>
    <div id="r_limit_kredit_order" class="form-group row">
        <label id="elh_customer_limit_kredit_order" for="x_limit_kredit_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limit_kredit_order->caption() ?><?= $Page->limit_kredit_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->limit_kredit_order->cellAttributes() ?>>
<span id="el_customer_limit_kredit_order">
<input type="<?= $Page->limit_kredit_order->getInputTextType() ?>" data-table="customer" data-field="x_limit_kredit_order" name="x_limit_kredit_order" id="x_limit_kredit_order" size="30" placeholder="<?= HtmlEncode($Page->limit_kredit_order->getPlaceHolder()) ?>" value="<?= $Page->limit_kredit_order->EditValue ?>"<?= $Page->limit_kredit_order->editAttributes() ?> aria-describedby="x_limit_kredit_order_help">
<?= $Page->limit_kredit_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limit_kredit_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jatuh_tempo_invoice->Visible) { // jatuh_tempo_invoice ?>
    <div id="r_jatuh_tempo_invoice" class="form-group row">
        <label id="elh_customer_jatuh_tempo_invoice" for="x_jatuh_tempo_invoice" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jatuh_tempo_invoice->caption() ?><?= $Page->jatuh_tempo_invoice->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jatuh_tempo_invoice->cellAttributes() ?>>
<span id="el_customer_jatuh_tempo_invoice">
    <select
        id="x_jatuh_tempo_invoice"
        name="x_jatuh_tempo_invoice"
        class="form-control ew-select<?= $Page->jatuh_tempo_invoice->isInvalidClass() ?>"
        data-select2-id="customer_x_jatuh_tempo_invoice"
        data-table="customer"
        data-field="x_jatuh_tempo_invoice"
        data-value-separator="<?= $Page->jatuh_tempo_invoice->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->jatuh_tempo_invoice->getPlaceHolder()) ?>"
        <?= $Page->jatuh_tempo_invoice->editAttributes() ?>>
        <?= $Page->jatuh_tempo_invoice->selectOptionListHtml("x_jatuh_tempo_invoice") ?>
    </select>
    <?= $Page->jatuh_tempo_invoice->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->jatuh_tempo_invoice->getErrorMessage() ?></div>
<?= $Page->jatuh_tempo_invoice->Lookup->getParamTag($Page, "p_x_jatuh_tempo_invoice") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x_jatuh_tempo_invoice']"),
        options = { name: "x_jatuh_tempo_invoice", selectId: "customer_x_jatuh_tempo_invoice", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.jatuh_tempo_invoice.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kodenpd->Visible) { // kodenpd ?>
    <div id="r_kodenpd" class="form-group row">
        <label id="elh_customer_kodenpd" for="x_kodenpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kodenpd->caption() ?><?= $Page->kodenpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodenpd->cellAttributes() ?>>
<span id="el_customer_kodenpd">
<input type="<?= $Page->kodenpd->getInputTextType() ?>" data-table="customer" data-field="x_kodenpd" name="x_kodenpd" id="x_kodenpd" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->kodenpd->getPlaceHolder()) ?>" value="<?= $Page->kodenpd->EditValue ?>"<?= $Page->kodenpd->editAttributes() ?> aria-describedby="x_kodenpd_help">
<?= $Page->kodenpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kodenpd->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->klinik->Visible) { // klinik ?>
    <div id="r_klinik" class="form-group row">
        <label id="elh_customer_klinik" for="x_klinik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->klinik->caption() ?><?= $Page->klinik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->klinik->cellAttributes() ?>>
<span id="el_customer_klinik">
<input type="<?= $Page->klinik->getInputTextType() ?>" data-table="customer" data-field="x_klinik" name="x_klinik" id="x_klinik" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->klinik->getPlaceHolder()) ?>" value="<?= $Page->klinik->EditValue ?>"<?= $Page->klinik->editAttributes() ?> aria-describedby="x_klinik_help">
<?= $Page->klinik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->klinik->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_customer_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_customer_keterangan">
<textarea data-table="customer" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
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
    if (in_array("alamat_customer", explode(",", $Page->getCurrentDetailTable())) && $alamat_customer->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "alamat_customer") {
            $firstActiveDetailTable = "alamat_customer";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("alamat_customer") ?>" href="#tab_alamat_customer" data-toggle="tab"><?= $Language->tablePhrase("alamat_customer", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("brand_customer", explode(",", $Page->getCurrentDetailTable())) && $brand_customer->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "brand_customer") {
            $firstActiveDetailTable = "brand_customer";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("brand_customer") ?>" href="#tab_brand_customer" data-toggle="tab"><?= $Language->tablePhrase("brand_customer", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("order", explode(",", $Page->getCurrentDetailTable())) && $order->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "order") {
            $firstActiveDetailTable = "order";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("order") ?>" href="#tab_order" data-toggle="tab"><?= $Language->tablePhrase("order", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("invoice", explode(",", $Page->getCurrentDetailTable())) && $invoice->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "invoice") {
            $firstActiveDetailTable = "invoice";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("invoice") ?>" href="#tab_invoice" data-toggle="tab"><?= $Language->tablePhrase("invoice", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("alamat_customer", explode(",", $Page->getCurrentDetailTable())) && $alamat_customer->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "alamat_customer") {
            $firstActiveDetailTable = "alamat_customer";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("alamat_customer") ?>" id="tab_alamat_customer"><!-- page* -->
<?php include_once "AlamatCustomerGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("brand_customer", explode(",", $Page->getCurrentDetailTable())) && $brand_customer->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "brand_customer") {
            $firstActiveDetailTable = "brand_customer";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("brand_customer") ?>" id="tab_brand_customer"><!-- page* -->
<?php include_once "BrandCustomerGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("order", explode(",", $Page->getCurrentDetailTable())) && $order->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "order") {
            $firstActiveDetailTable = "order";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("order") ?>" id="tab_order"><!-- page* -->
<?php include_once "OrderGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("invoice", explode(",", $Page->getCurrentDetailTable())) && $invoice->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "invoice") {
            $firstActiveDetailTable = "invoice";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("invoice") ?>" id="tab_invoice"><!-- page* -->
<?php include_once "InvoiceGrid.php" ?>
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
    ew.addEventHandlers("customer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){$.get("api/nextKode/customer/0",(function(a){$("#x_kode").val(a)}))})),$("input[data-field=x_alias]").attr("placeholder","(Cth: Klinik/Apartemen/Rumah)");
});
</script>
