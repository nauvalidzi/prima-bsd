<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdSampleAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_sampleadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_sampleadd = currentForm = new ew.Form("fnpd_sampleadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_sample")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_sample)
        ew.vars.tables.npd_sample = currentTable;
    fnpd_sampleadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["idserahterima", [fields.idserahterima.visible && fields.idserahterima.required ? ew.Validators.required(fields.idserahterima.caption) : null, ew.Validators.integer], fields.idserahterima.isInvalid],
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["sediaan", [fields.sediaan.visible && fields.sediaan.required ? ew.Validators.required(fields.sediaan.caption) : null], fields.sediaan.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null], fields.ukuran.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["bau", [fields.bau.visible && fields.bau.required ? ew.Validators.required(fields.bau.caption) : null], fields.bau.isInvalid],
        ["fungsi", [fields.fungsi.visible && fields.fungsi.required ? ew.Validators.required(fields.fungsi.caption) : null], fields.fungsi.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null, ew.Validators.integer], fields.jumlah.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_sampleadd,
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
    fnpd_sampleadd.validate = function () {
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
    fnpd_sampleadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_sampleadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_sampleadd.lists.idnpd = <?= $Page->idnpd->toClientList($Page) ?>;
    loadjs.done("fnpd_sampleadd");
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
<form name="fnpd_sampleadd" id="fnpd_sampleadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_sample">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "serahterima") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="serahterima">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idserahterima->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "npd") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "npd_serahterima") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd_serahterima">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idserahterima->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_sample_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<?php if ($Page->idnpd->getSessionValue() != "") { ?>
<span id="el_npd_sample_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnpd->getDisplayValue($Page->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idnpd" name="x_idnpd" value="<?= HtmlEncode($Page->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_npd_sample_idnpd">
<?php $Page->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_idnpd"
        name="x_idnpd"
        class="form-control ew-select<?= $Page->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_sample_x_idnpd"
        data-table="npd_sample"
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
    var el = document.querySelector("select[data-select2-id='npd_sample_x_idnpd']"),
        options = { name: "x_idnpd", selectId: "npd_sample_x_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_sample.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idserahterima->Visible) { // idserahterima ?>
    <div id="r_idserahterima" class="form-group row">
        <label id="elh_npd_sample_idserahterima" for="x_idserahterima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idserahterima->caption() ?><?= $Page->idserahterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idserahterima->cellAttributes() ?>>
<?php if ($Page->idserahterima->getSessionValue() != "") { ?>
<span id="el_npd_sample_idserahterima">
<span<?= $Page->idserahterima->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idserahterima->getDisplayValue($Page->idserahterima->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idserahterima" name="x_idserahterima" value="<?= HtmlEncode($Page->idserahterima->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_npd_sample_idserahterima">
<input type="<?= $Page->idserahterima->getInputTextType() ?>" data-table="npd_sample" data-field="x_idserahterima" name="x_idserahterima" id="x_idserahterima" size="30" placeholder="<?= HtmlEncode($Page->idserahterima->getPlaceHolder()) ?>" value="<?= $Page->idserahterima->EditValue ?>"<?= $Page->idserahterima->editAttributes() ?> aria-describedby="x_idserahterima_help">
<?= $Page->idserahterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idserahterima->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_npd_sample_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_npd_sample_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="npd_sample" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_npd_sample_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_sample_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="npd_sample" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
    <div id="r_sediaan" class="form-group row">
        <label id="elh_npd_sample_sediaan" for="x_sediaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sediaan->caption() ?><?= $Page->sediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sediaan->cellAttributes() ?>>
<span id="el_npd_sample_sediaan">
<input type="<?= $Page->sediaan->getInputTextType() ?>" data-table="npd_sample" data-field="x_sediaan" name="x_sediaan" id="x_sediaan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->sediaan->getPlaceHolder()) ?>" value="<?= $Page->sediaan->EditValue ?>"<?= $Page->sediaan->editAttributes() ?> aria-describedby="x_sediaan_help">
<?= $Page->sediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sediaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <div id="r_ukuran" class="form-group row">
        <label id="elh_npd_sample_ukuran" for="x_ukuran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuran->caption() ?><?= $Page->ukuran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_npd_sample_ukuran">
<input type="<?= $Page->ukuran->getInputTextType() ?>" data-table="npd_sample" data-field="x_ukuran" name="x_ukuran" id="x_ukuran" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->ukuran->getPlaceHolder()) ?>" value="<?= $Page->ukuran->EditValue ?>"<?= $Page->ukuran->editAttributes() ?> aria-describedby="x_ukuran_help">
<?= $Page->ukuran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_npd_sample_warna" for="x_warna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<span id="el_npd_sample_warna">
<input type="<?= $Page->warna->getInputTextType() ?>" data-table="npd_sample" data-field="x_warna" name="x_warna" id="x_warna" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->warna->getPlaceHolder()) ?>" value="<?= $Page->warna->EditValue ?>"<?= $Page->warna->editAttributes() ?> aria-describedby="x_warna_help">
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bau->Visible) { // bau ?>
    <div id="r_bau" class="form-group row">
        <label id="elh_npd_sample_bau" for="x_bau" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bau->caption() ?><?= $Page->bau->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bau->cellAttributes() ?>>
<span id="el_npd_sample_bau">
<input type="<?= $Page->bau->getInputTextType() ?>" data-table="npd_sample" data-field="x_bau" name="x_bau" id="x_bau" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->bau->getPlaceHolder()) ?>" value="<?= $Page->bau->EditValue ?>"<?= $Page->bau->editAttributes() ?> aria-describedby="x_bau_help">
<?= $Page->bau->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bau->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fungsi->Visible) { // fungsi ?>
    <div id="r_fungsi" class="form-group row">
        <label id="elh_npd_sample_fungsi" for="x_fungsi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fungsi->caption() ?><?= $Page->fungsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fungsi->cellAttributes() ?>>
<span id="el_npd_sample_fungsi">
<input type="<?= $Page->fungsi->getInputTextType() ?>" data-table="npd_sample" data-field="x_fungsi" name="x_fungsi" id="x_fungsi" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->fungsi->getPlaceHolder()) ?>" value="<?= $Page->fungsi->EditValue ?>"<?= $Page->fungsi->editAttributes() ?> aria-describedby="x_fungsi_help">
<?= $Page->fungsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fungsi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <div id="r_jumlah" class="form-group row">
        <label id="elh_npd_sample_jumlah" for="x_jumlah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah->caption() ?><?= $Page->jumlah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_npd_sample_jumlah">
<input type="<?= $Page->jumlah->getInputTextType() ?>" data-table="npd_sample" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?= HtmlEncode($Page->jumlah->getPlaceHolder()) ?>" value="<?= $Page->jumlah->EditValue ?>"<?= $Page->jumlah->editAttributes() ?> aria-describedby="x_jumlah_help">
<?= $Page->jumlah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
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
    ew.addEventHandlers("npd_sample");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
