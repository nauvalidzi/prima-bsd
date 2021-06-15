<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdReviewAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_reviewadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_reviewadd = currentForm = new ew.Form("fnpd_reviewadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_review)
        ew.vars.tables.npd_review = currentTable;
    fnpd_reviewadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null], fields.idnpd.isInvalid],
        ["idnpd_sample", [fields.idnpd_sample.visible && fields.idnpd_sample.required ? ew.Validators.required(fields.idnpd_sample.caption) : null], fields.idnpd_sample.isInvalid],
        ["tglreview", [fields.tglreview.visible && fields.tglreview.required ? ew.Validators.required(fields.tglreview.caption) : null, ew.Validators.datetime(0)], fields.tglreview.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["wadah", [fields.wadah.visible && fields.wadah.required ? ew.Validators.required(fields.wadah.caption) : null], fields.wadah.isInvalid],
        ["bentukok", [fields.bentukok.visible && fields.bentukok.required ? ew.Validators.required(fields.bentukok.caption) : null], fields.bentukok.isInvalid],
        ["bentukrevisi", [fields.bentukrevisi.visible && fields.bentukrevisi.required ? ew.Validators.required(fields.bentukrevisi.caption) : null], fields.bentukrevisi.isInvalid],
        ["viskositasok", [fields.viskositasok.visible && fields.viskositasok.required ? ew.Validators.required(fields.viskositasok.caption) : null], fields.viskositasok.isInvalid],
        ["viskositasrevisi", [fields.viskositasrevisi.visible && fields.viskositasrevisi.required ? ew.Validators.required(fields.viskositasrevisi.caption) : null], fields.viskositasrevisi.isInvalid],
        ["jeniswarnaok", [fields.jeniswarnaok.visible && fields.jeniswarnaok.required ? ew.Validators.required(fields.jeniswarnaok.caption) : null], fields.jeniswarnaok.isInvalid],
        ["jeniswarnarevisi", [fields.jeniswarnarevisi.visible && fields.jeniswarnarevisi.required ? ew.Validators.required(fields.jeniswarnarevisi.caption) : null], fields.jeniswarnarevisi.isInvalid],
        ["tonewarnaok", [fields.tonewarnaok.visible && fields.tonewarnaok.required ? ew.Validators.required(fields.tonewarnaok.caption) : null], fields.tonewarnaok.isInvalid],
        ["tonewarnarevisi", [fields.tonewarnarevisi.visible && fields.tonewarnarevisi.required ? ew.Validators.required(fields.tonewarnarevisi.caption) : null], fields.tonewarnarevisi.isInvalid],
        ["gradasiwarnaok", [fields.gradasiwarnaok.visible && fields.gradasiwarnaok.required ? ew.Validators.required(fields.gradasiwarnaok.caption) : null], fields.gradasiwarnaok.isInvalid],
        ["gradasiwarnarevisi", [fields.gradasiwarnarevisi.visible && fields.gradasiwarnarevisi.required ? ew.Validators.required(fields.gradasiwarnarevisi.caption) : null], fields.gradasiwarnarevisi.isInvalid],
        ["bauok", [fields.bauok.visible && fields.bauok.required ? ew.Validators.required(fields.bauok.caption) : null], fields.bauok.isInvalid],
        ["baurevisi", [fields.baurevisi.visible && fields.baurevisi.required ? ew.Validators.required(fields.baurevisi.caption) : null], fields.baurevisi.isInvalid],
        ["estetikaok", [fields.estetikaok.visible && fields.estetikaok.required ? ew.Validators.required(fields.estetikaok.caption) : null], fields.estetikaok.isInvalid],
        ["estetikarevisi", [fields.estetikarevisi.visible && fields.estetikarevisi.required ? ew.Validators.required(fields.estetikarevisi.caption) : null], fields.estetikarevisi.isInvalid],
        ["aplikasiawalok", [fields.aplikasiawalok.visible && fields.aplikasiawalok.required ? ew.Validators.required(fields.aplikasiawalok.caption) : null], fields.aplikasiawalok.isInvalid],
        ["aplikasiawalrevisi", [fields.aplikasiawalrevisi.visible && fields.aplikasiawalrevisi.required ? ew.Validators.required(fields.aplikasiawalrevisi.caption) : null], fields.aplikasiawalrevisi.isInvalid],
        ["aplikasilamaok", [fields.aplikasilamaok.visible && fields.aplikasilamaok.required ? ew.Validators.required(fields.aplikasilamaok.caption) : null], fields.aplikasilamaok.isInvalid],
        ["aplikasilamarevisi", [fields.aplikasilamarevisi.visible && fields.aplikasilamarevisi.required ? ew.Validators.required(fields.aplikasilamarevisi.caption) : null], fields.aplikasilamarevisi.isInvalid],
        ["efekpositifok", [fields.efekpositifok.visible && fields.efekpositifok.required ? ew.Validators.required(fields.efekpositifok.caption) : null], fields.efekpositifok.isInvalid],
        ["efekpositifrevisi", [fields.efekpositifrevisi.visible && fields.efekpositifrevisi.required ? ew.Validators.required(fields.efekpositifrevisi.caption) : null], fields.efekpositifrevisi.isInvalid],
        ["efeknegatifok", [fields.efeknegatifok.visible && fields.efeknegatifok.required ? ew.Validators.required(fields.efeknegatifok.caption) : null], fields.efeknegatifok.isInvalid],
        ["efeknegatifrevisi", [fields.efeknegatifrevisi.visible && fields.efeknegatifrevisi.required ? ew.Validators.required(fields.efeknegatifrevisi.caption) : null], fields.efeknegatifrevisi.isInvalid],
        ["kesimpulan", [fields.kesimpulan.visible && fields.kesimpulan.required ? ew.Validators.required(fields.kesimpulan.caption) : null], fields.kesimpulan.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["created_by", [fields.created_by.visible && fields.created_by.required ? ew.Validators.required(fields.created_by.caption) : null], fields.created_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_reviewadd,
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
    fnpd_reviewadd.validate = function () {
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
    fnpd_reviewadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_reviewadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_reviewadd.lists.idnpd = <?= $Page->idnpd->toClientList($Page) ?>;
    fnpd_reviewadd.lists.idnpd_sample = <?= $Page->idnpd_sample->toClientList($Page) ?>;
    fnpd_reviewadd.lists.bentukok = <?= $Page->bentukok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.viskositasok = <?= $Page->viskositasok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.jeniswarnaok = <?= $Page->jeniswarnaok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.tonewarnaok = <?= $Page->tonewarnaok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.gradasiwarnaok = <?= $Page->gradasiwarnaok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.bauok = <?= $Page->bauok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.estetikaok = <?= $Page->estetikaok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.aplikasiawalok = <?= $Page->aplikasiawalok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.aplikasilamaok = <?= $Page->aplikasilamaok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.efekpositifok = <?= $Page->efekpositifok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.efeknegatifok = <?= $Page->efeknegatifok->toClientList($Page) ?>;
    fnpd_reviewadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fnpd_reviewadd");
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
<form name="fnpd_reviewadd" id="fnpd_reviewadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_review">
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
        <label id="elh_npd_review_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<?php if ($Page->idnpd->getSessionValue() != "") { ?>
<span id="el_npd_review_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnpd->getDisplayValue($Page->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idnpd" name="x_idnpd" value="<?= HtmlEncode($Page->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_npd_review_idnpd">
<?php $Page->idnpd->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idnpd"
        name="x_idnpd"
        class="form-control ew-select<?= $Page->idnpd->isInvalidClass() ?>"
        data-select2-id="npd_review_x_idnpd"
        data-table="npd_review"
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
    var el = document.querySelector("select[data-select2-id='npd_review_x_idnpd']"),
        options = { name: "x_idnpd", selectId: "npd_review_x_idnpd", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <div id="r_idnpd_sample" class="form-group row">
        <label id="elh_npd_review_idnpd_sample" for="x_idnpd_sample" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd_sample->caption() ?><?= $Page->idnpd_sample->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el_npd_review_idnpd_sample">
    <select
        id="x_idnpd_sample"
        name="x_idnpd_sample"
        class="form-control ew-select<?= $Page->idnpd_sample->isInvalidClass() ?>"
        data-select2-id="npd_review_x_idnpd_sample"
        data-table="npd_review"
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
    var el = document.querySelector("select[data-select2-id='npd_review_x_idnpd_sample']"),
        options = { name: "x_idnpd_sample", selectId: "npd_review_x_idnpd_sample", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.idnpd_sample.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglreview->Visible) { // tglreview ?>
    <div id="r_tglreview" class="form-group row">
        <label id="elh_npd_review_tglreview" for="x_tglreview" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglreview->caption() ?><?= $Page->tglreview->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglreview->cellAttributes() ?>>
<span id="el_npd_review_tglreview">
<input type="<?= $Page->tglreview->getInputTextType() ?>" data-table="npd_review" data-field="x_tglreview" name="x_tglreview" id="x_tglreview" placeholder="<?= HtmlEncode($Page->tglreview->getPlaceHolder()) ?>" value="<?= $Page->tglreview->EditValue ?>"<?= $Page->tglreview->editAttributes() ?> aria-describedby="x_tglreview_help">
<?= $Page->tglreview->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglreview->getErrorMessage() ?></div>
<?php if (!$Page->tglreview->ReadOnly && !$Page->tglreview->Disabled && !isset($Page->tglreview->EditAttrs["readonly"]) && !isset($Page->tglreview->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewadd", "x_tglreview", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_npd_review_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_npd_review_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="npd_review" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewadd", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->wadah->Visible) { // wadah ?>
    <div id="r_wadah" class="form-group row">
        <label id="elh_npd_review_wadah" for="x_wadah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->wadah->caption() ?><?= $Page->wadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->wadah->cellAttributes() ?>>
<span id="el_npd_review_wadah">
<input type="<?= $Page->wadah->getInputTextType() ?>" data-table="npd_review" data-field="x_wadah" name="x_wadah" id="x_wadah" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->wadah->getPlaceHolder()) ?>" value="<?= $Page->wadah->EditValue ?>"<?= $Page->wadah->editAttributes() ?> aria-describedby="x_wadah_help">
<?= $Page->wadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->wadah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentukok->Visible) { // bentukok ?>
    <div id="r_bentukok" class="form-group row">
        <label id="elh_npd_review_bentukok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bentukok->caption() ?><?= $Page->bentukok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentukok->cellAttributes() ?>>
<span id="el_npd_review_bentukok">
<template id="tp_x_bentukok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_bentukok" name="x_bentukok" id="x_bentukok"<?= $Page->bentukok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_bentukok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_bentukok"
    name="x_bentukok"
    value="<?= HtmlEncode($Page->bentukok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_bentukok"
    data-target="dsl_x_bentukok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->bentukok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_bentukok"
    data-value-separator="<?= $Page->bentukok->displayValueSeparatorAttribute() ?>"
    <?= $Page->bentukok->editAttributes() ?>>
<?= $Page->bentukok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentukok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentukrevisi->Visible) { // bentukrevisi ?>
    <div id="r_bentukrevisi" class="form-group row">
        <label id="elh_npd_review_bentukrevisi" for="x_bentukrevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bentukrevisi->caption() ?><?= $Page->bentukrevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentukrevisi->cellAttributes() ?>>
<span id="el_npd_review_bentukrevisi">
<input type="<?= $Page->bentukrevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_bentukrevisi" name="x_bentukrevisi" id="x_bentukrevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bentukrevisi->getPlaceHolder()) ?>" value="<?= $Page->bentukrevisi->EditValue ?>"<?= $Page->bentukrevisi->editAttributes() ?> aria-describedby="x_bentukrevisi_help">
<?= $Page->bentukrevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentukrevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositasok->Visible) { // viskositasok ?>
    <div id="r_viskositasok" class="form-group row">
        <label id="elh_npd_review_viskositasok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->viskositasok->caption() ?><?= $Page->viskositasok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositasok->cellAttributes() ?>>
<span id="el_npd_review_viskositasok">
<template id="tp_x_viskositasok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_viskositasok" name="x_viskositasok" id="x_viskositasok"<?= $Page->viskositasok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_viskositasok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_viskositasok"
    name="x_viskositasok"
    value="<?= HtmlEncode($Page->viskositasok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_viskositasok"
    data-target="dsl_x_viskositasok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->viskositasok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_viskositasok"
    data-value-separator="<?= $Page->viskositasok->displayValueSeparatorAttribute() ?>"
    <?= $Page->viskositasok->editAttributes() ?>>
<?= $Page->viskositasok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositasok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositasrevisi->Visible) { // viskositasrevisi ?>
    <div id="r_viskositasrevisi" class="form-group row">
        <label id="elh_npd_review_viskositasrevisi" for="x_viskositasrevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->viskositasrevisi->caption() ?><?= $Page->viskositasrevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositasrevisi->cellAttributes() ?>>
<span id="el_npd_review_viskositasrevisi">
<input type="<?= $Page->viskositasrevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_viskositasrevisi" name="x_viskositasrevisi" id="x_viskositasrevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->viskositasrevisi->getPlaceHolder()) ?>" value="<?= $Page->viskositasrevisi->EditValue ?>"<?= $Page->viskositasrevisi->editAttributes() ?> aria-describedby="x_viskositasrevisi_help">
<?= $Page->viskositasrevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositasrevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jeniswarnaok->Visible) { // jeniswarnaok ?>
    <div id="r_jeniswarnaok" class="form-group row">
        <label id="elh_npd_review_jeniswarnaok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jeniswarnaok->caption() ?><?= $Page->jeniswarnaok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jeniswarnaok->cellAttributes() ?>>
<span id="el_npd_review_jeniswarnaok">
<template id="tp_x_jeniswarnaok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_jeniswarnaok" name="x_jeniswarnaok" id="x_jeniswarnaok"<?= $Page->jeniswarnaok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_jeniswarnaok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_jeniswarnaok"
    name="x_jeniswarnaok"
    value="<?= HtmlEncode($Page->jeniswarnaok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_jeniswarnaok"
    data-target="dsl_x_jeniswarnaok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->jeniswarnaok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_jeniswarnaok"
    data-value-separator="<?= $Page->jeniswarnaok->displayValueSeparatorAttribute() ?>"
    <?= $Page->jeniswarnaok->editAttributes() ?>>
<?= $Page->jeniswarnaok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jeniswarnaok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jeniswarnarevisi->Visible) { // jeniswarnarevisi ?>
    <div id="r_jeniswarnarevisi" class="form-group row">
        <label id="elh_npd_review_jeniswarnarevisi" for="x_jeniswarnarevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jeniswarnarevisi->caption() ?><?= $Page->jeniswarnarevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jeniswarnarevisi->cellAttributes() ?>>
<span id="el_npd_review_jeniswarnarevisi">
<input type="<?= $Page->jeniswarnarevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_jeniswarnarevisi" name="x_jeniswarnarevisi" id="x_jeniswarnarevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jeniswarnarevisi->getPlaceHolder()) ?>" value="<?= $Page->jeniswarnarevisi->EditValue ?>"<?= $Page->jeniswarnarevisi->editAttributes() ?> aria-describedby="x_jeniswarnarevisi_help">
<?= $Page->jeniswarnarevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jeniswarnarevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tonewarnaok->Visible) { // tonewarnaok ?>
    <div id="r_tonewarnaok" class="form-group row">
        <label id="elh_npd_review_tonewarnaok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tonewarnaok->caption() ?><?= $Page->tonewarnaok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tonewarnaok->cellAttributes() ?>>
<span id="el_npd_review_tonewarnaok">
<template id="tp_x_tonewarnaok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_tonewarnaok" name="x_tonewarnaok" id="x_tonewarnaok"<?= $Page->tonewarnaok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_tonewarnaok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_tonewarnaok"
    name="x_tonewarnaok"
    value="<?= HtmlEncode($Page->tonewarnaok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tonewarnaok"
    data-target="dsl_x_tonewarnaok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tonewarnaok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_tonewarnaok"
    data-value-separator="<?= $Page->tonewarnaok->displayValueSeparatorAttribute() ?>"
    <?= $Page->tonewarnaok->editAttributes() ?>>
<?= $Page->tonewarnaok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tonewarnaok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tonewarnarevisi->Visible) { // tonewarnarevisi ?>
    <div id="r_tonewarnarevisi" class="form-group row">
        <label id="elh_npd_review_tonewarnarevisi" for="x_tonewarnarevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tonewarnarevisi->caption() ?><?= $Page->tonewarnarevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tonewarnarevisi->cellAttributes() ?>>
<span id="el_npd_review_tonewarnarevisi">
<input type="<?= $Page->tonewarnarevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_tonewarnarevisi" name="x_tonewarnarevisi" id="x_tonewarnarevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tonewarnarevisi->getPlaceHolder()) ?>" value="<?= $Page->tonewarnarevisi->EditValue ?>"<?= $Page->tonewarnarevisi->editAttributes() ?> aria-describedby="x_tonewarnarevisi_help">
<?= $Page->tonewarnarevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tonewarnarevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gradasiwarnaok->Visible) { // gradasiwarnaok ?>
    <div id="r_gradasiwarnaok" class="form-group row">
        <label id="elh_npd_review_gradasiwarnaok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gradasiwarnaok->caption() ?><?= $Page->gradasiwarnaok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gradasiwarnaok->cellAttributes() ?>>
<span id="el_npd_review_gradasiwarnaok">
<template id="tp_x_gradasiwarnaok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_gradasiwarnaok" name="x_gradasiwarnaok" id="x_gradasiwarnaok"<?= $Page->gradasiwarnaok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_gradasiwarnaok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_gradasiwarnaok"
    name="x_gradasiwarnaok"
    value="<?= HtmlEncode($Page->gradasiwarnaok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_gradasiwarnaok"
    data-target="dsl_x_gradasiwarnaok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->gradasiwarnaok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_gradasiwarnaok"
    data-value-separator="<?= $Page->gradasiwarnaok->displayValueSeparatorAttribute() ?>"
    <?= $Page->gradasiwarnaok->editAttributes() ?>>
<?= $Page->gradasiwarnaok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gradasiwarnaok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gradasiwarnarevisi->Visible) { // gradasiwarnarevisi ?>
    <div id="r_gradasiwarnarevisi" class="form-group row">
        <label id="elh_npd_review_gradasiwarnarevisi" for="x_gradasiwarnarevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gradasiwarnarevisi->caption() ?><?= $Page->gradasiwarnarevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gradasiwarnarevisi->cellAttributes() ?>>
<span id="el_npd_review_gradasiwarnarevisi">
<input type="<?= $Page->gradasiwarnarevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_gradasiwarnarevisi" name="x_gradasiwarnarevisi" id="x_gradasiwarnarevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->gradasiwarnarevisi->getPlaceHolder()) ?>" value="<?= $Page->gradasiwarnarevisi->EditValue ?>"<?= $Page->gradasiwarnarevisi->editAttributes() ?> aria-describedby="x_gradasiwarnarevisi_help">
<?= $Page->gradasiwarnarevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gradasiwarnarevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bauok->Visible) { // bauok ?>
    <div id="r_bauok" class="form-group row">
        <label id="elh_npd_review_bauok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bauok->caption() ?><?= $Page->bauok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bauok->cellAttributes() ?>>
<span id="el_npd_review_bauok">
<template id="tp_x_bauok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_bauok" name="x_bauok" id="x_bauok"<?= $Page->bauok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_bauok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_bauok"
    name="x_bauok"
    value="<?= HtmlEncode($Page->bauok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_bauok"
    data-target="dsl_x_bauok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->bauok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_bauok"
    data-value-separator="<?= $Page->bauok->displayValueSeparatorAttribute() ?>"
    <?= $Page->bauok->editAttributes() ?>>
<?= $Page->bauok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bauok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->baurevisi->Visible) { // baurevisi ?>
    <div id="r_baurevisi" class="form-group row">
        <label id="elh_npd_review_baurevisi" for="x_baurevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->baurevisi->caption() ?><?= $Page->baurevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->baurevisi->cellAttributes() ?>>
<span id="el_npd_review_baurevisi">
<input type="<?= $Page->baurevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_baurevisi" name="x_baurevisi" id="x_baurevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->baurevisi->getPlaceHolder()) ?>" value="<?= $Page->baurevisi->EditValue ?>"<?= $Page->baurevisi->editAttributes() ?> aria-describedby="x_baurevisi_help">
<?= $Page->baurevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->baurevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estetikaok->Visible) { // estetikaok ?>
    <div id="r_estetikaok" class="form-group row">
        <label id="elh_npd_review_estetikaok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estetikaok->caption() ?><?= $Page->estetikaok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estetikaok->cellAttributes() ?>>
<span id="el_npd_review_estetikaok">
<template id="tp_x_estetikaok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_estetikaok" name="x_estetikaok" id="x_estetikaok"<?= $Page->estetikaok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_estetikaok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_estetikaok"
    name="x_estetikaok"
    value="<?= HtmlEncode($Page->estetikaok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_estetikaok"
    data-target="dsl_x_estetikaok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estetikaok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_estetikaok"
    data-value-separator="<?= $Page->estetikaok->displayValueSeparatorAttribute() ?>"
    <?= $Page->estetikaok->editAttributes() ?>>
<?= $Page->estetikaok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estetikaok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estetikarevisi->Visible) { // estetikarevisi ?>
    <div id="r_estetikarevisi" class="form-group row">
        <label id="elh_npd_review_estetikarevisi" for="x_estetikarevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estetikarevisi->caption() ?><?= $Page->estetikarevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estetikarevisi->cellAttributes() ?>>
<span id="el_npd_review_estetikarevisi">
<input type="<?= $Page->estetikarevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_estetikarevisi" name="x_estetikarevisi" id="x_estetikarevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->estetikarevisi->getPlaceHolder()) ?>" value="<?= $Page->estetikarevisi->EditValue ?>"<?= $Page->estetikarevisi->editAttributes() ?> aria-describedby="x_estetikarevisi_help">
<?= $Page->estetikarevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estetikarevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasiawalok->Visible) { // aplikasiawalok ?>
    <div id="r_aplikasiawalok" class="form-group row">
        <label id="elh_npd_review_aplikasiawalok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aplikasiawalok->caption() ?><?= $Page->aplikasiawalok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasiawalok->cellAttributes() ?>>
<span id="el_npd_review_aplikasiawalok">
<template id="tp_x_aplikasiawalok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_aplikasiawalok" name="x_aplikasiawalok" id="x_aplikasiawalok"<?= $Page->aplikasiawalok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aplikasiawalok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aplikasiawalok"
    name="x_aplikasiawalok"
    value="<?= HtmlEncode($Page->aplikasiawalok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_aplikasiawalok"
    data-target="dsl_x_aplikasiawalok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->aplikasiawalok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_aplikasiawalok"
    data-value-separator="<?= $Page->aplikasiawalok->displayValueSeparatorAttribute() ?>"
    <?= $Page->aplikasiawalok->editAttributes() ?>>
<?= $Page->aplikasiawalok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasiawalok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasiawalrevisi->Visible) { // aplikasiawalrevisi ?>
    <div id="r_aplikasiawalrevisi" class="form-group row">
        <label id="elh_npd_review_aplikasiawalrevisi" for="x_aplikasiawalrevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aplikasiawalrevisi->caption() ?><?= $Page->aplikasiawalrevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasiawalrevisi->cellAttributes() ?>>
<span id="el_npd_review_aplikasiawalrevisi">
<input type="<?= $Page->aplikasiawalrevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_aplikasiawalrevisi" name="x_aplikasiawalrevisi" id="x_aplikasiawalrevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->aplikasiawalrevisi->getPlaceHolder()) ?>" value="<?= $Page->aplikasiawalrevisi->EditValue ?>"<?= $Page->aplikasiawalrevisi->editAttributes() ?> aria-describedby="x_aplikasiawalrevisi_help">
<?= $Page->aplikasiawalrevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasiawalrevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasilamaok->Visible) { // aplikasilamaok ?>
    <div id="r_aplikasilamaok" class="form-group row">
        <label id="elh_npd_review_aplikasilamaok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aplikasilamaok->caption() ?><?= $Page->aplikasilamaok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasilamaok->cellAttributes() ?>>
<span id="el_npd_review_aplikasilamaok">
<template id="tp_x_aplikasilamaok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_aplikasilamaok" name="x_aplikasilamaok" id="x_aplikasilamaok"<?= $Page->aplikasilamaok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aplikasilamaok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aplikasilamaok"
    name="x_aplikasilamaok"
    value="<?= HtmlEncode($Page->aplikasilamaok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_aplikasilamaok"
    data-target="dsl_x_aplikasilamaok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->aplikasilamaok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_aplikasilamaok"
    data-value-separator="<?= $Page->aplikasilamaok->displayValueSeparatorAttribute() ?>"
    <?= $Page->aplikasilamaok->editAttributes() ?>>
<?= $Page->aplikasilamaok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasilamaok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasilamarevisi->Visible) { // aplikasilamarevisi ?>
    <div id="r_aplikasilamarevisi" class="form-group row">
        <label id="elh_npd_review_aplikasilamarevisi" for="x_aplikasilamarevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aplikasilamarevisi->caption() ?><?= $Page->aplikasilamarevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasilamarevisi->cellAttributes() ?>>
<span id="el_npd_review_aplikasilamarevisi">
<input type="<?= $Page->aplikasilamarevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_aplikasilamarevisi" name="x_aplikasilamarevisi" id="x_aplikasilamarevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->aplikasilamarevisi->getPlaceHolder()) ?>" value="<?= $Page->aplikasilamarevisi->EditValue ?>"<?= $Page->aplikasilamarevisi->editAttributes() ?> aria-describedby="x_aplikasilamarevisi_help">
<?= $Page->aplikasilamarevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasilamarevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efekpositifok->Visible) { // efekpositifok ?>
    <div id="r_efekpositifok" class="form-group row">
        <label id="elh_npd_review_efekpositifok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->efekpositifok->caption() ?><?= $Page->efekpositifok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efekpositifok->cellAttributes() ?>>
<span id="el_npd_review_efekpositifok">
<template id="tp_x_efekpositifok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_efekpositifok" name="x_efekpositifok" id="x_efekpositifok"<?= $Page->efekpositifok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_efekpositifok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_efekpositifok"
    name="x_efekpositifok"
    value="<?= HtmlEncode($Page->efekpositifok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_efekpositifok"
    data-target="dsl_x_efekpositifok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->efekpositifok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_efekpositifok"
    data-value-separator="<?= $Page->efekpositifok->displayValueSeparatorAttribute() ?>"
    <?= $Page->efekpositifok->editAttributes() ?>>
<?= $Page->efekpositifok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efekpositifok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efekpositifrevisi->Visible) { // efekpositifrevisi ?>
    <div id="r_efekpositifrevisi" class="form-group row">
        <label id="elh_npd_review_efekpositifrevisi" for="x_efekpositifrevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->efekpositifrevisi->caption() ?><?= $Page->efekpositifrevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efekpositifrevisi->cellAttributes() ?>>
<span id="el_npd_review_efekpositifrevisi">
<input type="<?= $Page->efekpositifrevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_efekpositifrevisi" name="x_efekpositifrevisi" id="x_efekpositifrevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->efekpositifrevisi->getPlaceHolder()) ?>" value="<?= $Page->efekpositifrevisi->EditValue ?>"<?= $Page->efekpositifrevisi->editAttributes() ?> aria-describedby="x_efekpositifrevisi_help">
<?= $Page->efekpositifrevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efekpositifrevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efeknegatifok->Visible) { // efeknegatifok ?>
    <div id="r_efeknegatifok" class="form-group row">
        <label id="elh_npd_review_efeknegatifok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->efeknegatifok->caption() ?><?= $Page->efeknegatifok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efeknegatifok->cellAttributes() ?>>
<span id="el_npd_review_efeknegatifok">
<template id="tp_x_efeknegatifok">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_efeknegatifok" name="x_efeknegatifok" id="x_efeknegatifok"<?= $Page->efeknegatifok->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_efeknegatifok" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_efeknegatifok"
    name="x_efeknegatifok"
    value="<?= HtmlEncode($Page->efeknegatifok->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_efeknegatifok"
    data-target="dsl_x_efeknegatifok"
    data-repeatcolumn="5"
    class="form-control<?= $Page->efeknegatifok->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_efeknegatifok"
    data-value-separator="<?= $Page->efeknegatifok->displayValueSeparatorAttribute() ?>"
    <?= $Page->efeknegatifok->editAttributes() ?>>
<?= $Page->efeknegatifok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efeknegatifok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efeknegatifrevisi->Visible) { // efeknegatifrevisi ?>
    <div id="r_efeknegatifrevisi" class="form-group row">
        <label id="elh_npd_review_efeknegatifrevisi" for="x_efeknegatifrevisi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->efeknegatifrevisi->caption() ?><?= $Page->efeknegatifrevisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efeknegatifrevisi->cellAttributes() ?>>
<span id="el_npd_review_efeknegatifrevisi">
<input type="<?= $Page->efeknegatifrevisi->getInputTextType() ?>" data-table="npd_review" data-field="x_efeknegatifrevisi" name="x_efeknegatifrevisi" id="x_efeknegatifrevisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->efeknegatifrevisi->getPlaceHolder()) ?>" value="<?= $Page->efeknegatifrevisi->EditValue ?>"<?= $Page->efeknegatifrevisi->editAttributes() ?> aria-describedby="x_efeknegatifrevisi_help">
<?= $Page->efeknegatifrevisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efeknegatifrevisi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kesimpulan->Visible) { // kesimpulan ?>
    <div id="r_kesimpulan" class="form-group row">
        <label id="elh_npd_review_kesimpulan" for="x_kesimpulan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kesimpulan->caption() ?><?= $Page->kesimpulan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kesimpulan->cellAttributes() ?>>
<span id="el_npd_review_kesimpulan">
<textarea data-table="npd_review" data-field="x_kesimpulan" name="x_kesimpulan" id="x_kesimpulan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->kesimpulan->getPlaceHolder()) ?>"<?= $Page->kesimpulan->editAttributes() ?> aria-describedby="x_kesimpulan_help"><?= $Page->kesimpulan->EditValue ?></textarea>
<?= $Page->kesimpulan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kesimpulan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_npd_review_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_review_status">
<template id="tp_x_status">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_status" name="x_status" id="x_status"<?= $Page->status->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_status" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_status"
    name="x_status"
    value="<?= HtmlEncode($Page->status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_status"
    data-target="dsl_x_status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->status->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_status"
    data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
    <?= $Page->status->editAttributes() ?>>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <span id="el_npd_review_created_by">
    <input type="hidden" data-table="npd_review" data-field="x_created_by" data-hidden="1" name="x_created_by" id="x_created_by" value="<?= HtmlEncode($Page->created_by->CurrentValue) ?>">
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
    ew.addEventHandlers("npd_review");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    loadjs.ready("jquery",(function(){$("#r_kodesample").before('<h5 class="form-group">A. Data Sample</h5>'),$("#r_bentukok").before('<h5 class="form-group">B. Review Sediaan</h5>'),$("#r_aplikasiawalok").before('<h5 class="form-group">C. Review Kualitas</h5>'),$("#r_kesimpulan").before('<h5 class="form-group">D. Kesimpulan</h5>'),$("#r_bentukok, #r_viskositasok, #r_jeniswarnaok, #r_tonewarnaok, #r_gradasiwarnaok, #r_bauok, #r_estetikaok, #r_aplikasiawalok, #r_aplikasilamaok, #r_efekpositifok, #r_efeknegatifok").change((function(){var a=$('input[data-field="x_'+this.id.slice(2)+'"]:checked').val(),e="#r_"+this.id.slice(2,-2)+"revisi";1==a?$(e).hide():0!=a&&-1!=a||$(e).show()}))}));
});
</script>
