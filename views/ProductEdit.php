<?php

namespace PHPMaker2021\distributor;

// Page object
$ProductEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fproductedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fproductedit = currentForm = new ew.Form("fproductedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "product")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.product)
        ew.vars.tables.product = currentTable;
    fproductedit.addFields([
        ["idbrand", [fields.idbrand.visible && fields.idbrand.required ? ew.Validators.required(fields.idbrand.caption) : null], fields.idbrand.isInvalid],
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["idkategoribarang", [fields.idkategoribarang.visible && fields.idkategoribarang.required ? ew.Validators.required(fields.idkategoribarang.caption) : null], fields.idkategoribarang.isInvalid],
        ["idjenisbarang", [fields.idjenisbarang.visible && fields.idjenisbarang.required ? ew.Validators.required(fields.idjenisbarang.caption) : null], fields.idjenisbarang.isInvalid],
        ["idkualitasbarang", [fields.idkualitasbarang.visible && fields.idkualitasbarang.required ? ew.Validators.required(fields.idkualitasbarang.caption) : null], fields.idkualitasbarang.isInvalid],
        ["idproduct_acuan", [fields.idproduct_acuan.visible && fields.idproduct_acuan.required ? ew.Validators.required(fields.idproduct_acuan.caption) : null], fields.idproduct_acuan.isInvalid],
        ["kemasanbarang", [fields.kemasanbarang.visible && fields.kemasanbarang.required ? ew.Validators.required(fields.kemasanbarang.caption) : null], fields.kemasanbarang.isInvalid],
        ["harga", [fields.harga.visible && fields.harga.required ? ew.Validators.required(fields.harga.caption) : null, ew.Validators.integer], fields.harga.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null], fields.ukuran.isInvalid],
        ["bahan", [fields.bahan.visible && fields.bahan.required ? ew.Validators.required(fields.bahan.caption) : null], fields.bahan.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["parfum", [fields.parfum.visible && fields.parfum.required ? ew.Validators.required(fields.parfum.caption) : null], fields.parfum.isInvalid],
        ["label", [fields.label.visible && fields.label.required ? ew.Validators.required(fields.label.caption) : null], fields.label.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["tambahan", [fields.tambahan.visible && fields.tambahan.required ? ew.Validators.required(fields.tambahan.caption) : null], fields.tambahan.isInvalid],
        ["ijinbpom", [fields.ijinbpom.visible && fields.ijinbpom.required ? ew.Validators.required(fields.ijinbpom.caption) : null], fields.ijinbpom.isInvalid],
        ["aktif", [fields.aktif.visible && fields.aktif.required ? ew.Validators.required(fields.aktif.caption) : null], fields.aktif.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fproductedit,
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
    fproductedit.validate = function () {
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
    fproductedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fproductedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fproductedit.lists.idbrand = <?= $Page->idbrand->toClientList($Page) ?>;
    fproductedit.lists.idkategoribarang = <?= $Page->idkategoribarang->toClientList($Page) ?>;
    fproductedit.lists.idjenisbarang = <?= $Page->idjenisbarang->toClientList($Page) ?>;
    fproductedit.lists.idkualitasbarang = <?= $Page->idkualitasbarang->toClientList($Page) ?>;
    fproductedit.lists.idproduct_acuan = <?= $Page->idproduct_acuan->toClientList($Page) ?>;
    fproductedit.lists.ijinbpom = <?= $Page->ijinbpom->toClientList($Page) ?>;
    fproductedit.lists.aktif = <?= $Page->aktif->toClientList($Page) ?>;
    loadjs.done("fproductedit");
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
<form name="fproductedit" id="fproductedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="product">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "brand") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="brand">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idbrand->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <div id="r_idbrand" class="form-group row">
        <label id="elh_product_idbrand" for="x_idbrand" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idbrand->caption() ?><?= $Page->idbrand->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idbrand->cellAttributes() ?>>
<?php if ($Page->idbrand->getSessionValue() != "") { ?>
<span id="el_product_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idbrand->getDisplayValue($Page->idbrand->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idbrand" name="x_idbrand" value="<?= HtmlEncode($Page->idbrand->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_product_idbrand">
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
    <?= $Page->idbrand->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idbrand->getErrorMessage() ?></div>
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
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_product_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_product_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="product" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_product_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_product_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="product" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
    <div id="r_idkategoribarang" class="form-group row">
        <label id="elh_product_idkategoribarang" for="x_idkategoribarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkategoribarang->caption() ?><?= $Page->idkategoribarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkategoribarang->cellAttributes() ?>>
<span id="el_product_idkategoribarang">
<?php $Page->idkategoribarang->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
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
    <?= $Page->idkategoribarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkategoribarang->getErrorMessage() ?></div>
<?= $Page->idkategoribarang->Lookup->getParamTag($Page, "p_x_idkategoribarang") ?>
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
        <label id="elh_product_idjenisbarang" for="x_idjenisbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idjenisbarang->caption() ?><?= $Page->idjenisbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idjenisbarang->cellAttributes() ?>>
<span id="el_product_idjenisbarang">
    <select
        id="x_idjenisbarang"
        name="x_idjenisbarang"
        class="form-control ew-select<?= $Page->idjenisbarang->isInvalidClass() ?>"
        data-select2-id="product_x_idjenisbarang"
        data-table="product"
        data-field="x_idjenisbarang"
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
    var el = document.querySelector("select[data-select2-id='product_x_idjenisbarang']"),
        options = { name: "x_idjenisbarang", selectId: "product_x_idjenisbarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idjenisbarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkualitasbarang->Visible) { // idkualitasbarang ?>
    <div id="r_idkualitasbarang" class="form-group row">
        <label id="elh_product_idkualitasbarang" for="x_idkualitasbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkualitasbarang->caption() ?><?= $Page->idkualitasbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkualitasbarang->cellAttributes() ?>>
<span id="el_product_idkualitasbarang">
    <select
        id="x_idkualitasbarang"
        name="x_idkualitasbarang"
        class="form-control ew-select<?= $Page->idkualitasbarang->isInvalidClass() ?>"
        data-select2-id="product_x_idkualitasbarang"
        data-table="product"
        data-field="x_idkualitasbarang"
        data-value-separator="<?= $Page->idkualitasbarang->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkualitasbarang->getPlaceHolder()) ?>"
        <?= $Page->idkualitasbarang->editAttributes() ?>>
        <?= $Page->idkualitasbarang->selectOptionListHtml("x_idkualitasbarang") ?>
    </select>
    <?= $Page->idkualitasbarang->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkualitasbarang->getErrorMessage() ?></div>
<?= $Page->idkualitasbarang->Lookup->getParamTag($Page, "p_x_idkualitasbarang") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='product_x_idkualitasbarang']"),
        options = { name: "x_idkualitasbarang", selectId: "product_x_idkualitasbarang", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.product.fields.idkualitasbarang.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <div id="r_idproduct_acuan" class="form-group row">
        <label id="elh_product_idproduct_acuan" for="x_idproduct_acuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct_acuan->caption() ?><?= $Page->idproduct_acuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el_product_idproduct_acuan">
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
    <?= $Page->idproduct_acuan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idproduct_acuan->getErrorMessage() ?></div>
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
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
    <div id="r_kemasanbarang" class="form-group row">
        <label id="elh_product_kemasanbarang" for="x_kemasanbarang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasanbarang->caption() ?><?= $Page->kemasanbarang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasanbarang->cellAttributes() ?>>
<span id="el_product_kemasanbarang">
<input type="<?= $Page->kemasanbarang->getInputTextType() ?>" data-table="product" data-field="x_kemasanbarang" name="x_kemasanbarang" id="x_kemasanbarang" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->kemasanbarang->getPlaceHolder()) ?>" value="<?= $Page->kemasanbarang->EditValue ?>"<?= $Page->kemasanbarang->editAttributes() ?> aria-describedby="x_kemasanbarang_help">
<?= $Page->kemasanbarang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasanbarang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <div id="r_harga" class="form-group row">
        <label id="elh_product_harga" for="x_harga" class="<?= $Page->LeftColumnClass ?>"><?= $Page->harga->caption() ?><?= $Page->harga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga->cellAttributes() ?>>
<span id="el_product_harga">
<input type="<?= $Page->harga->getInputTextType() ?>" data-table="product" data-field="x_harga" name="x_harga" id="x_harga" size="30" placeholder="<?= HtmlEncode($Page->harga->getPlaceHolder()) ?>" value="<?= $Page->harga->EditValue ?>"<?= $Page->harga->editAttributes() ?> aria-describedby="x_harga_help">
<?= $Page->harga->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->harga->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <div id="r_ukuran" class="form-group row">
        <label id="elh_product_ukuran" for="x_ukuran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuran->caption() ?><?= $Page->ukuran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_product_ukuran">
<input type="<?= $Page->ukuran->getInputTextType() ?>" data-table="product" data-field="x_ukuran" name="x_ukuran" id="x_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran->getPlaceHolder()) ?>" value="<?= $Page->ukuran->EditValue ?>"<?= $Page->ukuran->editAttributes() ?> aria-describedby="x_ukuran_help">
<?= $Page->ukuran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahan->Visible) { // bahan ?>
    <div id="r_bahan" class="form-group row">
        <label id="elh_product_bahan" for="x_bahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bahan->caption() ?><?= $Page->bahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahan->cellAttributes() ?>>
<span id="el_product_bahan">
<input type="<?= $Page->bahan->getInputTextType() ?>" data-table="product" data-field="x_bahan" name="x_bahan" id="x_bahan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bahan->getPlaceHolder()) ?>" value="<?= $Page->bahan->EditValue ?>"<?= $Page->bahan->editAttributes() ?> aria-describedby="x_bahan_help">
<?= $Page->bahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_product_warna" for="x_warna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<span id="el_product_warna">
<input type="<?= $Page->warna->getInputTextType() ?>" data-table="product" data-field="x_warna" name="x_warna" id="x_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warna->getPlaceHolder()) ?>" value="<?= $Page->warna->EditValue ?>"<?= $Page->warna->editAttributes() ?> aria-describedby="x_warna_help">
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <div id="r_parfum" class="form-group row">
        <label id="elh_product_parfum" for="x_parfum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parfum->caption() ?><?= $Page->parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parfum->cellAttributes() ?>>
<span id="el_product_parfum">
<input type="<?= $Page->parfum->getInputTextType() ?>" data-table="product" data-field="x_parfum" name="x_parfum" id="x_parfum" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->parfum->getPlaceHolder()) ?>" value="<?= $Page->parfum->EditValue ?>"<?= $Page->parfum->editAttributes() ?> aria-describedby="x_parfum_help">
<?= $Page->parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parfum->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label->Visible) { // label ?>
    <div id="r_label" class="form-group row">
        <label id="elh_product_label" for="x_label" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label->caption() ?><?= $Page->label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label->cellAttributes() ?>>
<span id="el_product_label">
<input type="<?= $Page->label->getInputTextType() ?>" data-table="product" data-field="x_label" name="x_label" id="x_label" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->label->getPlaceHolder()) ?>" value="<?= $Page->label->EditValue ?>"<?= $Page->label->editAttributes() ?> aria-describedby="x_label_help">
<?= $Page->label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_product_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_product_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="product" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>"<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
        <label class="custom-file-label ew-file-label" for="x_foto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="<?= (Post("fa_x_foto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_foto" id= "fs_x_foto" value="255">
<input type="hidden" name="fx_x_foto" id= "fx_x_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto" id= "fm_x_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <div id="r_tambahan" class="form-group row">
        <label id="elh_product_tambahan" for="x_tambahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tambahan->caption() ?><?= $Page->tambahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tambahan->cellAttributes() ?>>
<span id="el_product_tambahan">
<input type="<?= $Page->tambahan->getInputTextType() ?>" data-table="product" data-field="x_tambahan" name="x_tambahan" id="x_tambahan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->tambahan->getPlaceHolder()) ?>" value="<?= $Page->tambahan->EditValue ?>"<?= $Page->tambahan->editAttributes() ?> aria-describedby="x_tambahan_help">
<?= $Page->tambahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tambahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
    <div id="r_ijinbpom" class="form-group row">
        <label id="elh_product_ijinbpom" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijinbpom->caption() ?><?= $Page->ijinbpom->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijinbpom->cellAttributes() ?>>
<span id="el_product_ijinbpom">
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
    value="<?= HtmlEncode($Page->ijinbpom->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ijinbpom"
    data-target="dsl_x_ijinbpom"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ijinbpom->isInvalidClass() ?>"
    data-table="product"
    data-field="x_ijinbpom"
    data-value-separator="<?= $Page->ijinbpom->displayValueSeparatorAttribute() ?>"
    <?= $Page->ijinbpom->editAttributes() ?>>
<?= $Page->ijinbpom->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijinbpom->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif" class="form-group row">
        <label id="elh_product_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktif->caption() ?><?= $Page->aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktif->cellAttributes() ?>>
<span id="el_product_aktif">
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
    value="<?= HtmlEncode($Page->aktif->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_aktif"
    data-target="dsl_x_aktif"
    data-repeatcolumn="5"
    class="form-control<?= $Page->aktif->isInvalidClass() ?>"
    data-table="product"
    data-field="x_aktif"
    data-value-separator="<?= $Page->aktif->displayValueSeparatorAttribute() ?>"
    <?= $Page->aktif->editAttributes() ?>>
<?= $Page->aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aktif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="product" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php
    if (in_array("order_detail", explode(",", $Page->getCurrentDetailTable())) && $order_detail->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("order_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "OrderDetailGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("product");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
