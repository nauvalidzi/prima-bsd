<?php

namespace PHPMaker2021\distributor;

// Page object
$CustomerSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcustomersearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fcustomersearch = currentAdvancedSearchForm = new ew.Form("fcustomersearch", "search");
    <?php } else { ?>
    fcustomersearch = currentForm = new ew.Form("fcustomersearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "customer")) ?>,
        fields = currentTable.fields;
    fcustomersearch.addFields([
        ["kode", [], fields.kode.isInvalid],
        ["idtipecustomer", [], fields.idtipecustomer.isInvalid],
        ["idpegawai", [], fields.idpegawai.isInvalid],
        ["nama", [], fields.nama.isInvalid],
        ["kodenpd", [], fields.kodenpd.isInvalid],
        ["usaha", [], fields.usaha.isInvalid],
        ["jabatan", [], fields.jabatan.isInvalid],
        ["ktp", [], fields.ktp.isInvalid],
        ["npwp", [], fields.npwp.isInvalid],
        ["idprov", [], fields.idprov.isInvalid],
        ["idkab", [], fields.idkab.isInvalid],
        ["idkec", [], fields.idkec.isInvalid],
        ["idkel", [], fields.idkel.isInvalid],
        ["kodepos", [], fields.kodepos.isInvalid],
        ["alamat", [], fields.alamat.isInvalid],
        ["telpon", [], fields.telpon.isInvalid],
        ["hp", [ew.Validators.regex('^(62)8[1-9][0-9]{7,11}$')], fields.hp.isInvalid],
        ["_email", [], fields._email.isInvalid],
        ["website", [], fields.website.isInvalid],
        ["foto", [], fields.foto.isInvalid],
        ["level_customer_id", [], fields.level_customer_id.isInvalid],
        ["jatuh_tempo_invoice", [], fields.jatuh_tempo_invoice.isInvalid],
        ["keterangan", [], fields.keterangan.isInvalid],
        ["aktif", [], fields.aktif.isInvalid],
        ["created_at", [], fields.created_at.isInvalid],
        ["updated_at", [], fields.updated_at.isInvalid],
        ["created_by", [], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fcustomersearch.setInvalid();
    });

    // Validate form
    fcustomersearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fcustomersearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcustomersearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fcustomersearch.lists.idtipecustomer = <?= $Page->idtipecustomer->toClientList($Page) ?>;
    fcustomersearch.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    fcustomersearch.lists.idprov = <?= $Page->idprov->toClientList($Page) ?>;
    fcustomersearch.lists.idkab = <?= $Page->idkab->toClientList($Page) ?>;
    fcustomersearch.lists.idkec = <?= $Page->idkec->toClientList($Page) ?>;
    fcustomersearch.lists.idkel = <?= $Page->idkel->toClientList($Page) ?>;
    fcustomersearch.lists.level_customer_id = <?= $Page->level_customer_id->toClientList($Page) ?>;
    fcustomersearch.lists.jatuh_tempo_invoice = <?= $Page->jatuh_tempo_invoice->toClientList($Page) ?>;
    fcustomersearch.lists.aktif = <?= $Page->aktif->toClientList($Page) ?>;
    loadjs.done("fcustomersearch");
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
<form name="fcustomersearch" id="fcustomersearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="customer">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label for="x_kode" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_kode"><?= $Page->kode->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_kode" id="z_kode" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
            <span id="el_customer_kode" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="customer" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idtipecustomer->Visible) { // idtipecustomer ?>
    <div id="r_idtipecustomer" class="form-group row">
        <label for="x_idtipecustomer" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_idtipecustomer"><?= $Page->idtipecustomer->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idtipecustomer" id="z_idtipecustomer" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idtipecustomer->cellAttributes() ?>>
            <span id="el_customer_idtipecustomer" class="ew-search-field ew-search-field-single">
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
    <div class="invalid-feedback"><?= $Page->idtipecustomer->getErrorMessage(false) ?></div>
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
        <label for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_idpegawai"><?= $Page->idpegawai->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idpegawai" id="z_idpegawai" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
            <span id="el_customer_idpegawai" class="ew-search-field ew-search-field-single">
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
    <div class="invalid-feedback"><?= $Page->idpegawai->getErrorMessage(false) ?></div>
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
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label for="x_nama" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_nama"><?= $Page->nama->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_nama" id="z_nama" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
            <span id="el_customer_nama" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="customer" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->kodenpd->Visible) { // kodenpd ?>
    <div id="r_kodenpd" class="form-group row">
        <label for="x_kodenpd" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_kodenpd"><?= $Page->kodenpd->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_kodenpd" id="z_kodenpd" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodenpd->cellAttributes() ?>>
            <span id="el_customer_kodenpd" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->kodenpd->getInputTextType() ?>" data-table="customer" data-field="x_kodenpd" name="x_kodenpd" id="x_kodenpd" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->kodenpd->getPlaceHolder()) ?>" value="<?= $Page->kodenpd->EditValue ?>"<?= $Page->kodenpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kodenpd->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->usaha->Visible) { // usaha ?>
    <div id="r_usaha" class="form-group row">
        <label for="x_usaha" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_usaha"><?= $Page->usaha->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_usaha" id="z_usaha" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->usaha->cellAttributes() ?>>
            <span id="el_customer_usaha" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->usaha->getInputTextType() ?>" data-table="customer" data-field="x_usaha" name="x_usaha" id="x_usaha" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->usaha->getPlaceHolder()) ?>" value="<?= $Page->usaha->EditValue ?>"<?= $Page->usaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->usaha->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <div id="r_jabatan" class="form-group row">
        <label for="x_jabatan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_jabatan"><?= $Page->jabatan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_jabatan" id="z_jabatan" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatan->cellAttributes() ?>>
            <span id="el_customer_jabatan" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->jabatan->getInputTextType() ?>" data-table="customer" data-field="x_jabatan" name="x_jabatan" id="x_jabatan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jabatan->getPlaceHolder()) ?>" value="<?= $Page->jabatan->EditValue ?>"<?= $Page->jabatan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->jabatan->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idprov->Visible) { // idprov ?>
    <div id="r_idprov" class="form-group row">
        <label for="x_idprov" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_idprov"><?= $Page->idprov->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_idprov" id="z_idprov" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idprov->cellAttributes() ?>>
            <span id="el_customer_idprov" class="ew-search-field ew-search-field-single">
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
    <div class="invalid-feedback"><?= $Page->idprov->getErrorMessage(false) ?></div>
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
        <label for="x_idkab" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_idkab"><?= $Page->idkab->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_idkab" id="z_idkab" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkab->cellAttributes() ?>>
            <span id="el_customer_idkab" class="ew-search-field ew-search-field-single">
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
    <div class="invalid-feedback"><?= $Page->idkab->getErrorMessage(false) ?></div>
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
        <label for="x_idkec" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_idkec"><?= $Page->idkec->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_idkec" id="z_idkec" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkec->cellAttributes() ?>>
            <span id="el_customer_idkec" class="ew-search-field ew-search-field-single">
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
    <div class="invalid-feedback"><?= $Page->idkec->getErrorMessage(false) ?></div>
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
        <label for="x_idkel" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_idkel"><?= $Page->idkel->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_idkel" id="z_idkel" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkel->cellAttributes() ?>>
            <span id="el_customer_idkel" class="ew-search-field ew-search-field-single">
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
    <div class="invalid-feedback"><?= $Page->idkel->getErrorMessage(false) ?></div>
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
        <label for="x_kodepos" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_kodepos"><?= $Page->kodepos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_kodepos" id="z_kodepos" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodepos->cellAttributes() ?>>
            <span id="el_customer_kodepos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->kodepos->getInputTextType() ?>" data-table="customer" data-field="x_kodepos" name="x_kodepos" id="x_kodepos" size="7" maxlength="50" placeholder="<?= HtmlEncode($Page->kodepos->getPlaceHolder()) ?>" value="<?= $Page->kodepos->EditValue ?>"<?= $Page->kodepos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kodepos->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_alamat"><?= $Page->alamat->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_alamat" id="z_alamat" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
            <span id="el_customer_alamat" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="customer" data-field="x_alamat" name="x_alamat" id="x_alamat" size="60" maxlength="255" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
    <div id="r_telpon" class="form-group row">
        <label for="x_telpon" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_telpon"><?= $Page->telpon->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_telpon" id="z_telpon" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->telpon->cellAttributes() ?>>
            <span id="el_customer_telpon" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->telpon->getInputTextType() ?>" data-table="customer" data-field="x_telpon" name="x_telpon" id="x_telpon" size="15" maxlength="255" placeholder="<?= HtmlEncode($Page->telpon->getPlaceHolder()) ?>" value="<?= $Page->telpon->EditValue ?>"<?= $Page->telpon->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telpon->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <div id="r_hp" class="form-group row">
        <label for="x_hp" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_hp"><?= $Page->hp->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_hp" id="z_hp" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hp->cellAttributes() ?>>
            <span id="el_customer_hp" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->hp->getInputTextType() ?>" data-table="customer" data-field="x_hp" name="x_hp" id="x_hp" size="15" maxlength="255" placeholder="<?= HtmlEncode($Page->hp->getPlaceHolder()) ?>" value="<?= $Page->hp->EditValue ?>"<?= $Page->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->hp->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label for="x__email" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer__email"><?= $Page->_email->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__email" id="z__email" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
            <span id="el_customer__email" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="customer" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div id="r_website" class="form-group row">
        <label for="x_website" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_website"><?= $Page->website->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_website" id="z_website" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->website->cellAttributes() ?>>
            <span id="el_customer_website" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->website->getInputTextType() ?>" data-table="customer" data-field="x_website" name="x_website" id="x_website" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>" value="<?= $Page->website->EditValue ?>"<?= $Page->website->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_foto"><?= $Page->foto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_foto" id="z_foto" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
            <span id="el_customer_foto" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->foto->getInputTextType() ?>" data-table="customer" data-field="x_foto" name="x_foto" id="x_foto" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->foto->getPlaceHolder()) ?>" value="<?= $Page->foto->EditValue ?>"<?= $Page->foto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->level_customer_id->Visible) { // level_customer_id ?>
    <div id="r_level_customer_id" class="form-group row">
        <label for="x_level_customer_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_level_customer_id"><?= $Page->level_customer_id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_level_customer_id" id="z_level_customer_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->level_customer_id->cellAttributes() ?>>
            <span id="el_customer_level_customer_id" class="ew-search-field ew-search-field-single">
    <select
        id="x_level_customer_id"
        name="x_level_customer_id"
        class="form-control ew-select<?= $Page->level_customer_id->isInvalidClass() ?>"
        data-select2-id="customer_x_level_customer_id"
        data-table="customer"
        data-field="x_level_customer_id"
        data-value-separator="<?= $Page->level_customer_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->level_customer_id->getPlaceHolder()) ?>"
        <?= $Page->level_customer_id->editAttributes() ?>>
        <?= $Page->level_customer_id->selectOptionListHtml("x_level_customer_id") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->level_customer_id->getErrorMessage(false) ?></div>
<?= $Page->level_customer_id->Lookup->getParamTag($Page, "p_x_level_customer_id") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='customer_x_level_customer_id']"),
        options = { name: "x_level_customer_id", selectId: "customer_x_level_customer_id", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.customer.fields.level_customer_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->jatuh_tempo_invoice->Visible) { // jatuh_tempo_invoice ?>
    <div id="r_jatuh_tempo_invoice" class="form-group row">
        <label for="x_jatuh_tempo_invoice" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_jatuh_tempo_invoice"><?= $Page->jatuh_tempo_invoice->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_jatuh_tempo_invoice" id="z_jatuh_tempo_invoice" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jatuh_tempo_invoice->cellAttributes() ?>>
            <span id="el_customer_jatuh_tempo_invoice" class="ew-search-field ew-search-field-single">
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
    <div class="invalid-feedback"><?= $Page->jatuh_tempo_invoice->getErrorMessage(false) ?></div>
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
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_keterangan"><?= $Page->keterangan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_keterangan" id="z_keterangan" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
            <span id="el_customer_keterangan" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->keterangan->getInputTextType() ?>" data-table="customer" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" maxlength="255" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>" value="<?= $Page->keterangan->EditValue ?>"<?= $Page->keterangan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_aktif"><?= $Page->aktif->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_aktif" id="z_aktif" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktif->cellAttributes() ?>>
            <span id="el_customer_aktif" class="ew-search-field ew-search-field-single">
<template id="tp_x_aktif">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="customer" data-field="x_aktif" name="x_aktif" id="x_aktif"<?= $Page->aktif->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aktif" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aktif"
    name="x_aktif"
    value="<?= HtmlEncode($Page->aktif->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_aktif"
    data-target="dsl_x_aktif"
    data-repeatcolumn="5"
    class="form-control<?= $Page->aktif->isInvalidClass() ?>"
    data-table="customer"
    data-field="x_aktif"
    data-value-separator="<?= $Page->aktif->displayValueSeparatorAttribute() ?>"
    <?= $Page->aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->aktif->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_created_at"><?= $Page->created_at->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_created_at" id="z_created_at" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
            <span id="el_customer_created_at" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="customer" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage(false) ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcustomersearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fcustomersearch", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_updated_at"><?= $Page->updated_at->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_updated_at" id="z_updated_at" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
            <span id="el_customer_updated_at" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="customer" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage(false) ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcustomersearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fcustomersearch", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
    <div id="r_created_by" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_customer_created_by"><?= $Page->created_by->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_created_by" id="z_created_by" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_by->cellAttributes() ?>>
            <span id="el_customer_created_by" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->created_by->getInputTextType() ?>" data-table="customer" data-field="x_created_by" name="x_created_by" id="x_created_by" size="30" placeholder="<?= HtmlEncode($Page->created_by->getPlaceHolder()) ?>" value="<?= $Page->created_by->EditValue ?>"<?= $Page->created_by->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_by->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="location.reload();"><?= $Language->phrase("Reset") ?></button>
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
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
