<?php

namespace PHPMaker2021\distributor;

// Page object
$ProductSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fproductsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fproductsearch = currentAdvancedSearchForm = new ew.Form("fproductsearch", "search");
    <?php } else { ?>
    fproductsearch = currentForm = new ew.Form("fproductsearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "product")) ?>,
        fields = currentTable.fields;
    fproductsearch.addFields([
        ["id", [ew.Validators.integer], fields.id.isInvalid],
        ["idbrand", [], fields.idbrand.isInvalid],
        ["kode", [], fields.kode.isInvalid],
        ["nama", [], fields.nama.isInvalid],
        ["idkategoribarang", [], fields.idkategoribarang.isInvalid],
        ["idjenisbarang", [ew.Validators.integer], fields.idjenisbarang.isInvalid],
        ["idkualitasbarang", [ew.Validators.integer], fields.idkualitasbarang.isInvalid],
        ["idproduct_acuan", [], fields.idproduct_acuan.isInvalid],
        ["ukuran", [], fields.ukuran.isInvalid],
        ["netto", [], fields.netto.isInvalid],
        ["kemasanbarang", [], fields.kemasanbarang.isInvalid],
        ["satuan", [], fields.satuan.isInvalid],
        ["harga", [ew.Validators.integer], fields.harga.isInvalid],
        ["bahan", [], fields.bahan.isInvalid],
        ["warna", [], fields.warna.isInvalid],
        ["parfum", [], fields.parfum.isInvalid],
        ["label", [], fields.label.isInvalid],
        ["foto", [], fields.foto.isInvalid],
        ["tambahan", [], fields.tambahan.isInvalid],
        ["ijinbpom", [], fields.ijinbpom.isInvalid],
        ["aktif", [], fields.aktif.isInvalid],
        ["created_at", [ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [ew.Validators.datetime(11)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fproductsearch.setInvalid();
    });

    // Validate form
    fproductsearch.validate = function () {
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
    fproductsearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fproductsearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fproductsearch.lists.idbrand = <?= $Page->idbrand->toClientList($Page) ?>;
    fproductsearch.lists.idproduct_acuan = <?= $Page->idproduct_acuan->toClientList($Page) ?>;
    fproductsearch.lists.ijinbpom = <?= $Page->ijinbpom->toClientList($Page) ?>;
    fproductsearch.lists.aktif = <?= $Page->aktif->toClientList($Page) ?>;
    loadjs.done("fproductsearch");
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
<form name="fproductsearch" id="fproductsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="product">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label for="x_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_id"><?= $Page->id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
            <span id="el_product_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="product" data-field="x_id" name="x_id" id="x_id" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <div id="r_idbrand" class="form-group row">
        <label for="x_idbrand" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_idbrand"><?= $Page->idbrand->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idbrand" id="z_idbrand" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idbrand->cellAttributes() ?>>
            <span id="el_product_idbrand" class="ew-search-field ew-search-field-single">
    <select
        id="x_idbrand"
        name="x_idbrand"
        class="form-control ew-select<?= $Page->idbrand->isInvalidClass() ?>"
        data-select2-id="product_x_idbrand"
        data-table="product"
        data-field="x_idbrand"
        data-value-separator="<?= $Page->idbrand->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idbrand->getPlaceHolder()) ?>"
        <?= $Page->idbrand->editAttributes() ?>>
        <?= $Page->idbrand->selectOptionListHtml("x_idbrand") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idbrand->getErrorMessage(false) ?></div>
<?= $Page->idbrand->Lookup->getParamTag($Page, "p_x_idbrand") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='product_x_idbrand']"),
        options = { name: "x_idbrand", selectId: "product_x_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label for="x_kode" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_kode"><?= $Page->kode->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_kode" id="z_kode" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
            <span id="el_product_kode" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="product" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label for="x_nama" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_nama"><?= $Page->nama->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_nama" id="z_nama" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
            <span id="el_product_nama" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="product" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
    <div id="r_idkategoribarang" class="form-group row">
        <label for="x_idkategoribarang" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_idkategoribarang"><?= $Page->idkategoribarang->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idkategoribarang" id="z_idkategoribarang" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkategoribarang->cellAttributes() ?>>
            <span id="el_product_idkategoribarang" class="ew-search-field ew-search-field-single">
    <select
        id="x_idkategoribarang"
        name="x_idkategoribarang"
        class="form-control ew-select<?= $Page->idkategoribarang->isInvalidClass() ?>"
        data-select2-id="product_x_idkategoribarang"
        data-table="product"
        data-field="x_idkategoribarang"
        data-value-separator="<?= $Page->idkategoribarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkategoribarang->getPlaceHolder()) ?>"
        <?= $Page->idkategoribarang->editAttributes() ?>>
        <?= $Page->idkategoribarang->selectOptionListHtml("x_idkategoribarang") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idkategoribarang->getErrorMessage(false) ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='product_x_idkategoribarang']"),
        options = { name: "x_idkategoribarang", selectId: "product_x_idkategoribarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idkategoribarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idjenisbarang->Visible) { // idjenisbarang ?>
    <div id="r_idjenisbarang" class="form-group row">
        <label for="x_idjenisbarang" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_idjenisbarang"><?= $Page->idjenisbarang->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idjenisbarang" id="z_idjenisbarang" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idjenisbarang->cellAttributes() ?>>
            <span id="el_product_idjenisbarang" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idjenisbarang->getInputTextType() ?>" data-table="product" data-field="x_idjenisbarang" name="x_idjenisbarang" id="x_idjenisbarang" size="30" placeholder="<?= HtmlEncode($Page->idjenisbarang->getPlaceHolder()) ?>" value="<?= $Page->idjenisbarang->EditValue ?>"<?= $Page->idjenisbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idjenisbarang->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idkualitasbarang->Visible) { // idkualitasbarang ?>
    <div id="r_idkualitasbarang" class="form-group row">
        <label for="x_idkualitasbarang" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_idkualitasbarang"><?= $Page->idkualitasbarang->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idkualitasbarang" id="z_idkualitasbarang" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkualitasbarang->cellAttributes() ?>>
            <span id="el_product_idkualitasbarang" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->idkualitasbarang->getInputTextType() ?>" data-table="product" data-field="x_idkualitasbarang" name="x_idkualitasbarang" id="x_idkualitasbarang" size="30" placeholder="<?= HtmlEncode($Page->idkualitasbarang->getPlaceHolder()) ?>" value="<?= $Page->idkualitasbarang->EditValue ?>"<?= $Page->idkualitasbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->idkualitasbarang->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <div id="r_idproduct_acuan" class="form-group row">
        <label for="x_idproduct_acuan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idproduct_acuan" id="z_idproduct_acuan" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct_acuan->cellAttributes() ?>>
            <span id="el_product_idproduct_acuan" class="ew-search-field ew-search-field-single">
    <select
        id="x_idproduct_acuan"
        name="x_idproduct_acuan"
        class="form-control ew-select<?= $Page->idproduct_acuan->isInvalidClass() ?>"
        data-select2-id="product_x_idproduct_acuan"
        data-table="product"
        data-field="x_idproduct_acuan"
        data-value-separator="<?= $Page->idproduct_acuan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idproduct_acuan->getPlaceHolder()) ?>"
        <?= $Page->idproduct_acuan->editAttributes() ?>>
        <?= $Page->idproduct_acuan->selectOptionListHtml("x_idproduct_acuan") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idproduct_acuan->getErrorMessage(false) ?></div>
<?= $Page->idproduct_acuan->Lookup->getParamTag($Page, "p_x_idproduct_acuan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='product_x_idproduct_acuan']"),
        options = { name: "x_idproduct_acuan", selectId: "product_x_idproduct_acuan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idproduct_acuan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <div id="r_ukuran" class="form-group row">
        <label for="x_ukuran" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_ukuran"><?= $Page->ukuran->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ukuran" id="z_ukuran" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran->cellAttributes() ?>>
            <span id="el_product_ukuran" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ukuran->getInputTextType() ?>" data-table="product" data-field="x_ukuran" name="x_ukuran" id="x_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran->getPlaceHolder()) ?>" value="<?= $Page->ukuran->EditValue ?>"<?= $Page->ukuran->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ukuran->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->netto->Visible) { // netto ?>
    <div id="r_netto" class="form-group row">
        <label for="x_netto" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_netto"><?= $Page->netto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_netto" id="z_netto" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->netto->cellAttributes() ?>>
            <span id="el_product_netto" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->netto->getInputTextType() ?>" data-table="product" data-field="x_netto" name="x_netto" id="x_netto" size="30" maxlength="225" placeholder="<?= HtmlEncode($Page->netto->getPlaceHolder()) ?>" value="<?= $Page->netto->EditValue ?>"<?= $Page->netto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->netto->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
    <div id="r_kemasanbarang" class="form-group row">
        <label for="x_kemasanbarang" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_kemasanbarang"><?= $Page->kemasanbarang->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_kemasanbarang" id="z_kemasanbarang" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanbarang->cellAttributes() ?>>
            <span id="el_product_kemasanbarang" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->kemasanbarang->getInputTextType() ?>" data-table="product" data-field="x_kemasanbarang" name="x_kemasanbarang" id="x_kemasanbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->kemasanbarang->getPlaceHolder()) ?>" value="<?= $Page->kemasanbarang->EditValue ?>"<?= $Page->kemasanbarang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kemasanbarang->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->satuan->Visible) { // satuan ?>
    <div id="r_satuan" class="form-group row">
        <label for="x_satuan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_satuan"><?= $Page->satuan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_satuan" id="z_satuan" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->satuan->cellAttributes() ?>>
            <span id="el_product_satuan" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->satuan->getInputTextType() ?>" data-table="product" data-field="x_satuan" name="x_satuan" id="x_satuan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->satuan->getPlaceHolder()) ?>" value="<?= $Page->satuan->EditValue ?>"<?= $Page->satuan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->satuan->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <div id="r_harga" class="form-group row">
        <label for="x_harga" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_harga"><?= $Page->harga->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_harga" id="z_harga" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga->cellAttributes() ?>>
            <span id="el_product_harga" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->harga->getInputTextType() ?>" data-table="product" data-field="x_harga" name="x_harga" id="x_harga" size="30" placeholder="<?= HtmlEncode($Page->harga->getPlaceHolder()) ?>" value="<?= $Page->harga->EditValue ?>"<?= $Page->harga->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->harga->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->bahan->Visible) { // bahan ?>
    <div id="r_bahan" class="form-group row">
        <label for="x_bahan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_bahan"><?= $Page->bahan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_bahan" id="z_bahan" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahan->cellAttributes() ?>>
            <span id="el_product_bahan" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->bahan->getInputTextType() ?>" data-table="product" data-field="x_bahan" name="x_bahan" id="x_bahan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahan->getPlaceHolder()) ?>" value="<?= $Page->bahan->EditValue ?>"<?= $Page->bahan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bahan->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label for="x_warna" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_warna"><?= $Page->warna->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_warna" id="z_warna" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
            <span id="el_product_warna" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->warna->getInputTextType() ?>" data-table="product" data-field="x_warna" name="x_warna" id="x_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warna->getPlaceHolder()) ?>" value="<?= $Page->warna->EditValue ?>"<?= $Page->warna->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <div id="r_parfum" class="form-group row">
        <label for="x_parfum" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_parfum"><?= $Page->parfum->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_parfum" id="z_parfum" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parfum->cellAttributes() ?>>
            <span id="el_product_parfum" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->parfum->getInputTextType() ?>" data-table="product" data-field="x_parfum" name="x_parfum" id="x_parfum" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->parfum->getPlaceHolder()) ?>" value="<?= $Page->parfum->EditValue ?>"<?= $Page->parfum->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->parfum->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->label->Visible) { // label ?>
    <div id="r_label" class="form-group row">
        <label for="x_label" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_label"><?= $Page->label->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_label" id="z_label" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label->cellAttributes() ?>>
            <span id="el_product_label" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->label->getInputTextType() ?>" data-table="product" data-field="x_label" name="x_label" id="x_label" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->label->getPlaceHolder()) ?>" value="<?= $Page->label->EditValue ?>"<?= $Page->label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->label->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_foto"><?= $Page->foto->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_foto" id="z_foto" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
            <span id="el_product_foto" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->foto->getInputTextType() ?>" data-table="product" data-field="x_foto" name="x_foto" id="x_foto" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->foto->getPlaceHolder()) ?>" value="<?= $Page->foto->EditValue ?>"<?= $Page->foto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <div id="r_tambahan" class="form-group row">
        <label for="x_tambahan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_tambahan"><?= $Page->tambahan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_tambahan" id="z_tambahan" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tambahan->cellAttributes() ?>>
            <span id="el_product_tambahan" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->tambahan->getInputTextType() ?>" data-table="product" data-field="x_tambahan" name="x_tambahan" id="x_tambahan" maxlength="100" placeholder="<?= HtmlEncode($Page->tambahan->getPlaceHolder()) ?>" value="<?= $Page->tambahan->EditValue ?>"<?= $Page->tambahan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tambahan->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
    <div id="r_ijinbpom" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_ijinbpom"><?= $Page->ijinbpom->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ijinbpom" id="z_ijinbpom" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijinbpom->cellAttributes() ?>>
            <span id="el_product_ijinbpom" class="ew-search-field ew-search-field-single">
<template id="tp_x_ijinbpom">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="product" data-field="x_ijinbpom" name="x_ijinbpom" id="x_ijinbpom"<?= $Page->ijinbpom->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_ijinbpom" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_ijinbpom"
    name="x_ijinbpom"
    value="<?= HtmlEncode($Page->ijinbpom->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_ijinbpom"
    data-target="dsl_x_ijinbpom"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ijinbpom->isInvalidClass() ?>"
    data-table="product"
    data-field="x_ijinbpom"
    data-value-separator="<?= $Page->ijinbpom->displayValueSeparatorAttribute() ?>"
    <?= $Page->ijinbpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ijinbpom->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_aktif"><?= $Page->aktif->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_aktif" id="z_aktif" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktif->cellAttributes() ?>>
            <span id="el_product_aktif" class="ew-search-field ew-search-field-single">
<template id="tp_x_aktif">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="product" data-field="x_aktif" name="x_aktif" id="x_aktif"<?= $Page->aktif->editAttributes() ?>>
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
    data-table="product"
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
        <label for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_created_at"><?= $Page->created_at->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_created_at" id="z_created_at" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
            <span id="el_product_created_at" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="product" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage(false) ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fproductsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fproductsearch", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><span id="elh_product_updated_at"><?= $Page->updated_at->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_updated_at" id="z_updated_at" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
            <span id="el_product_updated_at" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="product" data-field="x_updated_at" data-format="11" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage(false) ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fproductsearch", "datetimepicker"], function() {
    ew.createDateTimePicker("fproductsearch", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":11});
});
</script>
<?php } ?>
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
    ew.addEventHandlers("product");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
