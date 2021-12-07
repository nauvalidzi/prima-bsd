<?php

namespace PHPMaker2021\distributor;

// Page object
$AlamatCustomerEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var falamat_customeredit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    falamat_customeredit = currentForm = new ew.Form("falamat_customeredit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "alamat_customer")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.alamat_customer)
        ew.vars.tables.alamat_customer = currentTable;
    falamat_customeredit.addFields([
        ["alias", [fields.alias.visible && fields.alias.required ? ew.Validators.required(fields.alias.caption) : null], fields.alias.isInvalid],
        ["penerima", [fields.penerima.visible && fields.penerima.required ? ew.Validators.required(fields.penerima.caption) : null], fields.penerima.isInvalid],
        ["telepon", [fields.telepon.visible && fields.telepon.required ? ew.Validators.required(fields.telepon.caption) : null], fields.telepon.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["idprovinsi", [fields.idprovinsi.visible && fields.idprovinsi.required ? ew.Validators.required(fields.idprovinsi.caption) : null], fields.idprovinsi.isInvalid],
        ["idkabupaten", [fields.idkabupaten.visible && fields.idkabupaten.required ? ew.Validators.required(fields.idkabupaten.caption) : null], fields.idkabupaten.isInvalid],
        ["idkecamatan", [fields.idkecamatan.visible && fields.idkecamatan.required ? ew.Validators.required(fields.idkecamatan.caption) : null], fields.idkecamatan.isInvalid],
        ["idkelurahan", [fields.idkelurahan.visible && fields.idkelurahan.required ? ew.Validators.required(fields.idkelurahan.caption) : null, ew.Validators.integer], fields.idkelurahan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = falamat_customeredit,
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
    falamat_customeredit.validate = function () {
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
    falamat_customeredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    falamat_customeredit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    falamat_customeredit.lists.idprovinsi = <?= $Page->idprovinsi->toClientList($Page) ?>;
    falamat_customeredit.lists.idkabupaten = <?= $Page->idkabupaten->toClientList($Page) ?>;
    falamat_customeredit.lists.idkecamatan = <?= $Page->idkecamatan->toClientList($Page) ?>;
    falamat_customeredit.lists.idkelurahan = <?= $Page->idkelurahan->toClientList($Page) ?>;
    loadjs.done("falamat_customeredit");
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
<form name="falamat_customeredit" id="falamat_customeredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="alamat_customer">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "customer") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="customer">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idcustomer->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->alias->Visible) { // alias ?>
    <div id="r_alias" class="form-group row">
        <label id="elh_alamat_customer_alias" for="x_alias" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alias->caption() ?><?= $Page->alias->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alias->cellAttributes() ?>>
<span id="el_alamat_customer_alias">
<input type="<?= $Page->alias->getInputTextType() ?>" data-table="alamat_customer" data-field="x_alias" name="x_alias" id="x_alias" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alias->getPlaceHolder()) ?>" value="<?= $Page->alias->EditValue ?>"<?= $Page->alias->editAttributes() ?> aria-describedby="x_alias_help">
<?= $Page->alias->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alias->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
    <div id="r_penerima" class="form-group row">
        <label id="elh_alamat_customer_penerima" for="x_penerima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->penerima->caption() ?><?= $Page->penerima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->penerima->cellAttributes() ?>>
<span id="el_alamat_customer_penerima">
<input type="<?= $Page->penerima->getInputTextType() ?>" data-table="alamat_customer" data-field="x_penerima" name="x_penerima" id="x_penerima" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->penerima->getPlaceHolder()) ?>" value="<?= $Page->penerima->EditValue ?>"<?= $Page->penerima->editAttributes() ?> aria-describedby="x_penerima_help">
<?= $Page->penerima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->penerima->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telepon->Visible) { // telepon ?>
    <div id="r_telepon" class="form-group row">
        <label id="elh_alamat_customer_telepon" for="x_telepon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telepon->caption() ?><?= $Page->telepon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->telepon->cellAttributes() ?>>
<span id="el_alamat_customer_telepon">
<input type="<?= $Page->telepon->getInputTextType() ?>" data-table="alamat_customer" data-field="x_telepon" name="x_telepon" id="x_telepon" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->telepon->getPlaceHolder()) ?>" value="<?= $Page->telepon->EditValue ?>"<?= $Page->telepon->editAttributes() ?> aria-describedby="x_telepon_help">
<?= $Page->telepon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telepon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_alamat_customer_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<span id="el_alamat_customer_alamat">
<textarea data-table="alamat_customer" data-field="x_alamat" name="x_alamat" id="x_alamat" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help"><?= $Page->alamat->EditValue ?></textarea>
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idprovinsi->Visible) { // idprovinsi ?>
    <div id="r_idprovinsi" class="form-group row">
        <label id="elh_alamat_customer_idprovinsi" for="x_idprovinsi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idprovinsi->caption() ?><?= $Page->idprovinsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idprovinsi->cellAttributes() ?>>
<span id="el_alamat_customer_idprovinsi">
<?php $Page->idprovinsi->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idprovinsi"
        name="x_idprovinsi"
        class="form-control ew-select<?= $Page->idprovinsi->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x_idprovinsi"
        data-table="alamat_customer"
        data-field="x_idprovinsi"
        data-value-separator="<?= $Page->idprovinsi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idprovinsi->getPlaceHolder()) ?>"
        <?= $Page->idprovinsi->editAttributes() ?>>
        <?= $Page->idprovinsi->selectOptionListHtml("x_idprovinsi") ?>
    </select>
    <?= $Page->idprovinsi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idprovinsi->getErrorMessage() ?></div>
<?= $Page->idprovinsi->Lookup->getParamTag($Page, "p_x_idprovinsi") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x_idprovinsi']"),
        options = { name: "x_idprovinsi", selectId: "alamat_customer_x_idprovinsi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idprovinsi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkabupaten->Visible) { // idkabupaten ?>
    <div id="r_idkabupaten" class="form-group row">
        <label id="elh_alamat_customer_idkabupaten" for="x_idkabupaten" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkabupaten->caption() ?><?= $Page->idkabupaten->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkabupaten->cellAttributes() ?>>
<span id="el_alamat_customer_idkabupaten">
<?php $Page->idkabupaten->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idkabupaten"
        name="x_idkabupaten"
        class="form-control ew-select<?= $Page->idkabupaten->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x_idkabupaten"
        data-table="alamat_customer"
        data-field="x_idkabupaten"
        data-value-separator="<?= $Page->idkabupaten->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkabupaten->getPlaceHolder()) ?>"
        <?= $Page->idkabupaten->editAttributes() ?>>
        <?= $Page->idkabupaten->selectOptionListHtml("x_idkabupaten") ?>
    </select>
    <?= $Page->idkabupaten->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkabupaten->getErrorMessage() ?></div>
<?= $Page->idkabupaten->Lookup->getParamTag($Page, "p_x_idkabupaten") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x_idkabupaten']"),
        options = { name: "x_idkabupaten", selectId: "alamat_customer_x_idkabupaten", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkabupaten.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkecamatan->Visible) { // idkecamatan ?>
    <div id="r_idkecamatan" class="form-group row">
        <label id="elh_alamat_customer_idkecamatan" for="x_idkecamatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkecamatan->caption() ?><?= $Page->idkecamatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkecamatan->cellAttributes() ?>>
<span id="el_alamat_customer_idkecamatan">
<?php $Page->idkecamatan->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idkecamatan"
        name="x_idkecamatan"
        class="form-control ew-select<?= $Page->idkecamatan->isInvalidClass() ?>"
        data-select2-id="alamat_customer_x_idkecamatan"
        data-table="alamat_customer"
        data-field="x_idkecamatan"
        data-value-separator="<?= $Page->idkecamatan->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idkecamatan->getPlaceHolder()) ?>"
        <?= $Page->idkecamatan->editAttributes() ?>>
        <?= $Page->idkecamatan->selectOptionListHtml("x_idkecamatan") ?>
    </select>
    <?= $Page->idkecamatan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkecamatan->getErrorMessage() ?></div>
<?= $Page->idkecamatan->Lookup->getParamTag($Page, "p_x_idkecamatan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='alamat_customer_x_idkecamatan']"),
        options = { name: "x_idkecamatan", selectId: "alamat_customer_x_idkecamatan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.alamat_customer.fields.idkecamatan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkelurahan->Visible) { // idkelurahan ?>
    <div id="r_idkelurahan" class="form-group row">
        <label id="elh_alamat_customer_idkelurahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkelurahan->caption() ?><?= $Page->idkelurahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkelurahan->cellAttributes() ?>>
<span id="el_alamat_customer_idkelurahan">
<?php
$onchange = $Page->idkelurahan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idkelurahan->EditAttrs["onchange"] = "";
?>
<span id="as_x_idkelurahan" class="ew-auto-suggest">
    <input type="<?= $Page->idkelurahan->getInputTextType() ?>" class="form-control" name="sv_x_idkelurahan" id="sv_x_idkelurahan" value="<?= RemoveHtml($Page->idkelurahan->EditValue) ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->idkelurahan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idkelurahan->getPlaceHolder()) ?>"<?= $Page->idkelurahan->editAttributes() ?> aria-describedby="x_idkelurahan_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="alamat_customer" data-field="x_idkelurahan" data-input="sv_x_idkelurahan" data-value-separator="<?= $Page->idkelurahan->displayValueSeparatorAttribute() ?>" name="x_idkelurahan" id="x_idkelurahan" value="<?= HtmlEncode($Page->idkelurahan->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->idkelurahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idkelurahan->getErrorMessage() ?></div>
<script>
loadjs.ready(["falamat_customeredit"], function() {
    falamat_customeredit.createAutoSuggest(Object.assign({"id":"x_idkelurahan","forceSelect":false}, ew.vars.tables.alamat_customer.fields.idkelurahan.autoSuggestOptions));
});
</script>
<?= $Page->idkelurahan->Lookup->getParamTag($Page, "p_x_idkelurahan") ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="alamat_customer" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("alamat_customer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("input[data-field=x_alias]").attr("placeholder","(Cth: Klinik/Apartemen/Rumah)");
});
</script>
