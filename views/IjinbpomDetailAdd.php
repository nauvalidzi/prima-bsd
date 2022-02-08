<?php

namespace PHPMaker2021\production2;

// Page object
$IjinbpomDetailAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinbpom_detailadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fijinbpom_detailadd = currentForm = new ew.Form("fijinbpom_detailadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinbpom_detail")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinbpom_detail)
        ew.vars.tables.ijinbpom_detail = currentTable;
    fijinbpom_detailadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["namaalt", [fields.namaalt.visible && fields.namaalt.required ? ew.Validators.required(fields.namaalt.caption) : null], fields.namaalt.isInvalid],
        ["idproduct_acuan", [fields.idproduct_acuan.visible && fields.idproduct_acuan.required ? ew.Validators.required(fields.idproduct_acuan.caption) : null, ew.Validators.integer], fields.idproduct_acuan.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null], fields.ukuran.isInvalid],
        ["kodesample", [fields.kodesample.visible && fields.kodesample.required ? ew.Validators.required(fields.kodesample.caption) : null], fields.kodesample.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinbpom_detailadd,
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
    fijinbpom_detailadd.validate = function () {
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
    fijinbpom_detailadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinbpom_detailadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinbpom_detailadd.lists.idnpd = <?= $Page->idnpd->toClientList($Page) ?>;
    fijinbpom_detailadd.lists.idproduct_acuan = <?= $Page->idproduct_acuan->toClientList($Page) ?>;
    loadjs.done("fijinbpom_detailadd");
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
<form name="fijinbpom_detailadd" id="fijinbpom_detailadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinbpom_detail">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "ijinbpom") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="ijinbpom">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idijinbpom->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_ijinbpom_detail_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_ijinbpom_detail_idnpd">
<?php $Page->idnpd->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x_idnpd"
        name="x_idnpd"
        class="form-control ew-select<?= $Page->idnpd->isInvalidClass() ?>"
        data-select2-id="ijinbpom_detail_x_idnpd"
        data-table="ijinbpom_detail"
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
    var el = document.querySelector("select[data-select2-id='ijinbpom_detail_x_idnpd']"),
        options = { name: "x_idnpd", selectId: "ijinbpom_detail_x_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom_detail.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_ijinbpom_detail_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_ijinbpom_detail_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->namaalt->Visible) { // namaalt ?>
    <div id="r_namaalt" class="form-group row">
        <label id="elh_ijinbpom_detail_namaalt" for="x_namaalt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namaalt->caption() ?><?= $Page->namaalt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namaalt->cellAttributes() ?>>
<span id="el_ijinbpom_detail_namaalt">
<input type="<?= $Page->namaalt->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_namaalt" name="x_namaalt" id="x_namaalt" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->namaalt->getPlaceHolder()) ?>" value="<?= $Page->namaalt->EditValue ?>"<?= $Page->namaalt->editAttributes() ?> aria-describedby="x_namaalt_help">
<?= $Page->namaalt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namaalt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <div id="r_idproduct_acuan" class="form-group row">
        <label id="elh_ijinbpom_detail_idproduct_acuan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idproduct_acuan->caption() ?><?= $Page->idproduct_acuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el_ijinbpom_detail_idproduct_acuan">
<?php
$onchange = $Page->idproduct_acuan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idproduct_acuan->EditAttrs["onchange"] = "";
?>
<span id="as_x_idproduct_acuan" class="ew-auto-suggest">
    <input type="<?= $Page->idproduct_acuan->getInputTextType() ?>" class="form-control" name="sv_x_idproduct_acuan" id="sv_x_idproduct_acuan" value="<?= RemoveHtml($Page->idproduct_acuan->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->idproduct_acuan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idproduct_acuan->getPlaceHolder()) ?>"<?= $Page->idproduct_acuan->editAttributes() ?> aria-describedby="x_idproduct_acuan_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="ijinbpom_detail" data-field="x_idproduct_acuan" data-input="sv_x_idproduct_acuan" data-value-separator="<?= $Page->idproduct_acuan->displayValueSeparatorAttribute() ?>" name="x_idproduct_acuan" id="x_idproduct_acuan" value="<?= HtmlEncode($Page->idproduct_acuan->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->idproduct_acuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idproduct_acuan->getErrorMessage() ?></div>
<script>
loadjs.ready(["fijinbpom_detailadd"], function() {
    fijinbpom_detailadd.createAutoSuggest(Object.assign({"id":"x_idproduct_acuan","forceSelect":false}, ew.vars.tables.ijinbpom_detail.fields.idproduct_acuan.autoSuggestOptions));
});
</script>
<?= $Page->idproduct_acuan->Lookup->getParamTag($Page, "p_x_idproduct_acuan") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <div id="r_ukuran" class="form-group row">
        <label id="elh_ijinbpom_detail_ukuran" for="x_ukuran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuran->caption() ?><?= $Page->ukuran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_ijinbpom_detail_ukuran">
<input type="<?= $Page->ukuran->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_ukuran" name="x_ukuran" id="x_ukuran" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran->getPlaceHolder()) ?>" value="<?= $Page->ukuran->EditValue ?>"<?= $Page->ukuran->editAttributes() ?> aria-describedby="x_ukuran_help">
<?= $Page->ukuran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kodesample->Visible) { // kodesample ?>
    <div id="r_kodesample" class="form-group row">
        <label id="elh_ijinbpom_detail_kodesample" for="x_kodesample" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kodesample->caption() ?><?= $Page->kodesample->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodesample->cellAttributes() ?>>
<span id="el_ijinbpom_detail_kodesample">
<input type="<?= $Page->kodesample->getInputTextType() ?>" data-table="ijinbpom_detail" data-field="x_kodesample" name="x_kodesample" id="x_kodesample" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kodesample->getPlaceHolder()) ?>" value="<?= $Page->kodesample->EditValue ?>"<?= $Page->kodesample->editAttributes() ?> aria-describedby="x_kodesample_help">
<?= $Page->kodesample->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kodesample->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <?php if (strval($Page->idijinbpom->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_idijinbpom" id="x_idijinbpom" value="<?= HtmlEncode(strval($Page->idijinbpom->getSessionValue())) ?>">
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
    ew.addEventHandlers("ijinbpom_detail");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
