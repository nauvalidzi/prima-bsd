<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdProdukMasterEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_produk_masteredit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_produk_masteredit = currentForm = new ew.Form("fnpd_produk_masteredit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_produk_master")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_produk_master)
        ew.vars.tables.npd_produk_master = currentTable;
    fnpd_produk_masteredit.addFields([
        ["grup", [fields.grup.visible && fields.grup.required ? ew.Validators.required(fields.grup.caption) : null], fields.grup.isInvalid],
        ["kategori", [fields.kategori.visible && fields.kategori.required ? ew.Validators.required(fields.kategori.caption) : null], fields.kategori.isInvalid],
        ["sediaan", [fields.sediaan.visible && fields.sediaan.required ? ew.Validators.required(fields.sediaan.caption) : null], fields.sediaan.isInvalid],
        ["bentukan", [fields.bentukan.visible && fields.bentukan.required ? ew.Validators.required(fields.bentukan.caption) : null], fields.bentukan.isInvalid],
        ["konsep", [fields.konsep.visible && fields.konsep.required ? ew.Validators.required(fields.konsep.caption) : null], fields.konsep.isInvalid],
        ["bahanaktif", [fields.bahanaktif.visible && fields.bahanaktif.required ? ew.Validators.required(fields.bahanaktif.caption) : null], fields.bahanaktif.isInvalid],
        ["fragrance", [fields.fragrance.visible && fields.fragrance.required ? ew.Validators.required(fields.fragrance.caption) : null], fields.fragrance.isInvalid],
        ["aroma", [fields.aroma.visible && fields.aroma.required ? ew.Validators.required(fields.aroma.caption) : null], fields.aroma.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["aplikasi_sediaan", [fields.aplikasi_sediaan.visible && fields.aplikasi_sediaan.required ? ew.Validators.required(fields.aplikasi_sediaan.caption) : null], fields.aplikasi_sediaan.isInvalid],
        ["aksesoris", [fields.aksesoris.visible && fields.aksesoris.required ? ew.Validators.required(fields.aksesoris.caption) : null], fields.aksesoris.isInvalid],
        ["nour", [fields.nour.visible && fields.nour.required ? ew.Validators.required(fields.nour.caption) : null, ew.Validators.integer], fields.nour.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_produk_masteredit,
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
    fnpd_produk_masteredit.validate = function () {
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
    fnpd_produk_masteredit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_produk_masteredit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fnpd_produk_masteredit");
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
<form name="fnpd_produk_masteredit" id="fnpd_produk_masteredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_produk_master">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->grup->Visible) { // grup ?>
    <div id="r_grup" class="form-group row">
        <label id="elh_npd_produk_master_grup" for="x_grup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grup->caption() ?><?= $Page->grup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->grup->cellAttributes() ?>>
<span id="el_npd_produk_master_grup">
<input type="<?= $Page->grup->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_grup" name="x_grup" id="x_grup" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->grup->getPlaceHolder()) ?>" value="<?= $Page->grup->EditValue ?>"<?= $Page->grup->editAttributes() ?> aria-describedby="x_grup_help">
<?= $Page->grup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->grup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
    <div id="r_kategori" class="form-group row">
        <label id="elh_npd_produk_master_kategori" for="x_kategori" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kategori->caption() ?><?= $Page->kategori->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategori->cellAttributes() ?>>
<span id="el_npd_produk_master_kategori">
<input type="<?= $Page->kategori->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_kategori" name="x_kategori" id="x_kategori" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kategori->getPlaceHolder()) ?>" value="<?= $Page->kategori->EditValue ?>"<?= $Page->kategori->editAttributes() ?> aria-describedby="x_kategori_help">
<?= $Page->kategori->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategori->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
    <div id="r_sediaan" class="form-group row">
        <label id="elh_npd_produk_master_sediaan" for="x_sediaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sediaan->caption() ?><?= $Page->sediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sediaan->cellAttributes() ?>>
<span id="el_npd_produk_master_sediaan">
<input type="<?= $Page->sediaan->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_sediaan" name="x_sediaan" id="x_sediaan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->sediaan->getPlaceHolder()) ?>" value="<?= $Page->sediaan->EditValue ?>"<?= $Page->sediaan->editAttributes() ?> aria-describedby="x_sediaan_help">
<?= $Page->sediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sediaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
    <div id="r_bentukan" class="form-group row">
        <label id="elh_npd_produk_master_bentukan" for="x_bentukan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bentukan->caption() ?><?= $Page->bentukan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentukan->cellAttributes() ?>>
<span id="el_npd_produk_master_bentukan">
<input type="<?= $Page->bentukan->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_bentukan" name="x_bentukan" id="x_bentukan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->bentukan->getPlaceHolder()) ?>" value="<?= $Page->bentukan->EditValue ?>"<?= $Page->bentukan->editAttributes() ?> aria-describedby="x_bentukan_help">
<?= $Page->bentukan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentukan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
    <div id="r_konsep" class="form-group row">
        <label id="elh_npd_produk_master_konsep" for="x_konsep" class="<?= $Page->LeftColumnClass ?>"><?= $Page->konsep->caption() ?><?= $Page->konsep->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->konsep->cellAttributes() ?>>
<span id="el_npd_produk_master_konsep">
<input type="<?= $Page->konsep->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_konsep" name="x_konsep" id="x_konsep" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->konsep->getPlaceHolder()) ?>" value="<?= $Page->konsep->EditValue ?>"<?= $Page->konsep->editAttributes() ?> aria-describedby="x_konsep_help">
<?= $Page->konsep->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->konsep->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <div id="r_bahanaktif" class="form-group row">
        <label id="elh_npd_produk_master_bahanaktif" for="x_bahanaktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bahanaktif->caption() ?><?= $Page->bahanaktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el_npd_produk_master_bahanaktif">
<input type="<?= $Page->bahanaktif->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_bahanaktif" name="x_bahanaktif" id="x_bahanaktif" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->bahanaktif->getPlaceHolder()) ?>" value="<?= $Page->bahanaktif->EditValue ?>"<?= $Page->bahanaktif->editAttributes() ?> aria-describedby="x_bahanaktif_help">
<?= $Page->bahanaktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahanaktif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
    <div id="r_fragrance" class="form-group row">
        <label id="elh_npd_produk_master_fragrance" for="x_fragrance" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fragrance->caption() ?><?= $Page->fragrance->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fragrance->cellAttributes() ?>>
<span id="el_npd_produk_master_fragrance">
<input type="<?= $Page->fragrance->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_fragrance" name="x_fragrance" id="x_fragrance" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->fragrance->getPlaceHolder()) ?>" value="<?= $Page->fragrance->EditValue ?>"<?= $Page->fragrance->editAttributes() ?> aria-describedby="x_fragrance_help">
<?= $Page->fragrance->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fragrance->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
    <div id="r_aroma" class="form-group row">
        <label id="elh_npd_produk_master_aroma" for="x_aroma" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aroma->caption() ?><?= $Page->aroma->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aroma->cellAttributes() ?>>
<span id="el_npd_produk_master_aroma">
<input type="<?= $Page->aroma->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_aroma" name="x_aroma" id="x_aroma" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->aroma->getPlaceHolder()) ?>" value="<?= $Page->aroma->EditValue ?>"<?= $Page->aroma->editAttributes() ?> aria-describedby="x_aroma_help">
<?= $Page->aroma->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aroma->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_npd_produk_master_warna" for="x_warna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_produk_master_warna">
<input type="<?= $Page->warna->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_warna" name="x_warna" id="x_warna" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->warna->getPlaceHolder()) ?>" value="<?= $Page->warna->EditValue ?>"<?= $Page->warna->editAttributes() ?> aria-describedby="x_warna_help">
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
    <div id="r_aplikasi_sediaan" class="form-group row">
        <label id="elh_npd_produk_master_aplikasi_sediaan" for="x_aplikasi_sediaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aplikasi_sediaan->caption() ?><?= $Page->aplikasi_sediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el_npd_produk_master_aplikasi_sediaan">
<input type="<?= $Page->aplikasi_sediaan->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_aplikasi_sediaan" name="x_aplikasi_sediaan" id="x_aplikasi_sediaan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->aplikasi_sediaan->getPlaceHolder()) ?>" value="<?= $Page->aplikasi_sediaan->EditValue ?>"<?= $Page->aplikasi_sediaan->editAttributes() ?> aria-describedby="x_aplikasi_sediaan_help">
<?= $Page->aplikasi_sediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasi_sediaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
    <div id="r_aksesoris" class="form-group row">
        <label id="elh_npd_produk_master_aksesoris" for="x_aksesoris" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aksesoris->caption() ?><?= $Page->aksesoris->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el_npd_produk_master_aksesoris">
<input type="<?= $Page->aksesoris->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_aksesoris" name="x_aksesoris" id="x_aksesoris" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->aksesoris->getPlaceHolder()) ?>" value="<?= $Page->aksesoris->EditValue ?>"<?= $Page->aksesoris->editAttributes() ?> aria-describedby="x_aksesoris_help">
<?= $Page->aksesoris->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aksesoris->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
    <div id="r_nour" class="form-group row">
        <label id="elh_npd_produk_master_nour" for="x_nour" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nour->caption() ?><?= $Page->nour->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nour->cellAttributes() ?>>
<span id="el_npd_produk_master_nour">
<input type="<?= $Page->nour->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_nour" name="x_nour" id="x_nour" size="30" placeholder="<?= HtmlEncode($Page->nour->getPlaceHolder()) ?>" value="<?= $Page->nour->EditValue ?>"<?= $Page->nour->editAttributes() ?> aria-describedby="x_nour_help">
<?= $Page->nour->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nour->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_npd_produk_master_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_produk_master_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="npd_produk_master" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_produk_masteredit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_produk_masteredit", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="npd_produk_master" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("npd_produk_master");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
