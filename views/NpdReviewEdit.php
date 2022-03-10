<?php

namespace PHPMaker2021\production2;

// Page object
$NpdReviewEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_reviewedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fnpd_reviewedit = currentForm = new ew.Form("fnpd_reviewedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_review)
        ew.vars.tables.npd_review = currentTable;
    fnpd_reviewedit.addFields([
        ["tanggal_review", [fields.tanggal_review.visible && fields.tanggal_review.required ? ew.Validators.required(fields.tanggal_review.caption) : null, ew.Validators.datetime(0)], fields.tanggal_review.isInvalid],
        ["tanggal_submit", [fields.tanggal_submit.visible && fields.tanggal_submit.required ? ew.Validators.required(fields.tanggal_submit.caption) : null, ew.Validators.datetime(0)], fields.tanggal_submit.isInvalid],
        ["wadah", [fields.wadah.visible && fields.wadah.required ? ew.Validators.required(fields.wadah.caption) : null], fields.wadah.isInvalid],
        ["bentuk_opsi", [fields.bentuk_opsi.visible && fields.bentuk_opsi.required ? ew.Validators.required(fields.bentuk_opsi.caption) : null], fields.bentuk_opsi.isInvalid],
        ["bentuk_revisi", [fields.bentuk_revisi.visible && fields.bentuk_revisi.required ? ew.Validators.required(fields.bentuk_revisi.caption) : null], fields.bentuk_revisi.isInvalid],
        ["viskositas_opsi", [fields.viskositas_opsi.visible && fields.viskositas_opsi.required ? ew.Validators.required(fields.viskositas_opsi.caption) : null], fields.viskositas_opsi.isInvalid],
        ["viskositas_revisi", [fields.viskositas_revisi.visible && fields.viskositas_revisi.required ? ew.Validators.required(fields.viskositas_revisi.caption) : null], fields.viskositas_revisi.isInvalid],
        ["jeniswarna_opsi", [fields.jeniswarna_opsi.visible && fields.jeniswarna_opsi.required ? ew.Validators.required(fields.jeniswarna_opsi.caption) : null], fields.jeniswarna_opsi.isInvalid],
        ["jeniswarna_revisi", [fields.jeniswarna_revisi.visible && fields.jeniswarna_revisi.required ? ew.Validators.required(fields.jeniswarna_revisi.caption) : null], fields.jeniswarna_revisi.isInvalid],
        ["tonewarna_opsi", [fields.tonewarna_opsi.visible && fields.tonewarna_opsi.required ? ew.Validators.required(fields.tonewarna_opsi.caption) : null], fields.tonewarna_opsi.isInvalid],
        ["tonewarna_revisi", [fields.tonewarna_revisi.visible && fields.tonewarna_revisi.required ? ew.Validators.required(fields.tonewarna_revisi.caption) : null], fields.tonewarna_revisi.isInvalid],
        ["gradasiwarna_opsi", [fields.gradasiwarna_opsi.visible && fields.gradasiwarna_opsi.required ? ew.Validators.required(fields.gradasiwarna_opsi.caption) : null], fields.gradasiwarna_opsi.isInvalid],
        ["gradasiwarna_revisi", [fields.gradasiwarna_revisi.visible && fields.gradasiwarna_revisi.required ? ew.Validators.required(fields.gradasiwarna_revisi.caption) : null], fields.gradasiwarna_revisi.isInvalid],
        ["bauparfum_opsi", [fields.bauparfum_opsi.visible && fields.bauparfum_opsi.required ? ew.Validators.required(fields.bauparfum_opsi.caption) : null], fields.bauparfum_opsi.isInvalid],
        ["bauparfum_revisi", [fields.bauparfum_revisi.visible && fields.bauparfum_revisi.required ? ew.Validators.required(fields.bauparfum_revisi.caption) : null], fields.bauparfum_revisi.isInvalid],
        ["estetika_opsi", [fields.estetika_opsi.visible && fields.estetika_opsi.required ? ew.Validators.required(fields.estetika_opsi.caption) : null], fields.estetika_opsi.isInvalid],
        ["estetika_revisi", [fields.estetika_revisi.visible && fields.estetika_revisi.required ? ew.Validators.required(fields.estetika_revisi.caption) : null], fields.estetika_revisi.isInvalid],
        ["aplikasiawal_opsi", [fields.aplikasiawal_opsi.visible && fields.aplikasiawal_opsi.required ? ew.Validators.required(fields.aplikasiawal_opsi.caption) : null], fields.aplikasiawal_opsi.isInvalid],
        ["aplikasiawal_revisi", [fields.aplikasiawal_revisi.visible && fields.aplikasiawal_revisi.required ? ew.Validators.required(fields.aplikasiawal_revisi.caption) : null], fields.aplikasiawal_revisi.isInvalid],
        ["aplikasilama_opsi", [fields.aplikasilama_opsi.visible && fields.aplikasilama_opsi.required ? ew.Validators.required(fields.aplikasilama_opsi.caption) : null], fields.aplikasilama_opsi.isInvalid],
        ["aplikasilama_revisi", [fields.aplikasilama_revisi.visible && fields.aplikasilama_revisi.required ? ew.Validators.required(fields.aplikasilama_revisi.caption) : null], fields.aplikasilama_revisi.isInvalid],
        ["efekpositif_opsi", [fields.efekpositif_opsi.visible && fields.efekpositif_opsi.required ? ew.Validators.required(fields.efekpositif_opsi.caption) : null], fields.efekpositif_opsi.isInvalid],
        ["efekpositif_revisi", [fields.efekpositif_revisi.visible && fields.efekpositif_revisi.required ? ew.Validators.required(fields.efekpositif_revisi.caption) : null], fields.efekpositif_revisi.isInvalid],
        ["efeknegatif_opsi", [fields.efeknegatif_opsi.visible && fields.efeknegatif_opsi.required ? ew.Validators.required(fields.efeknegatif_opsi.caption) : null], fields.efeknegatif_opsi.isInvalid],
        ["efeknegatif_revisi", [fields.efeknegatif_revisi.visible && fields.efeknegatif_revisi.required ? ew.Validators.required(fields.efeknegatif_revisi.caption) : null], fields.efeknegatif_revisi.isInvalid],
        ["kesimpulan", [fields.kesimpulan.visible && fields.kesimpulan.required ? ew.Validators.required(fields.kesimpulan.caption) : null], fields.kesimpulan.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["review_by", [fields.review_by.visible && fields.review_by.required ? ew.Validators.required(fields.review_by.caption) : null], fields.review_by.isInvalid],
        ["receipt_by", [fields.receipt_by.visible && fields.receipt_by.required ? ew.Validators.required(fields.receipt_by.caption) : null], fields.receipt_by.isInvalid],
        ["checked_by", [fields.checked_by.visible && fields.checked_by.required ? ew.Validators.required(fields.checked_by.caption) : null], fields.checked_by.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_reviewedit,
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
    fnpd_reviewedit.validate = function () {
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
    fnpd_reviewedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_reviewedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_reviewedit.lists.bentuk_opsi = <?= $Page->bentuk_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.viskositas_opsi = <?= $Page->viskositas_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.jeniswarna_opsi = <?= $Page->jeniswarna_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.tonewarna_opsi = <?= $Page->tonewarna_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.gradasiwarna_opsi = <?= $Page->gradasiwarna_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.bauparfum_opsi = <?= $Page->bauparfum_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.estetika_opsi = <?= $Page->estetika_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.aplikasiawal_opsi = <?= $Page->aplikasiawal_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.aplikasilama_opsi = <?= $Page->aplikasilama_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.efekpositif_opsi = <?= $Page->efekpositif_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.efeknegatif_opsi = <?= $Page->efeknegatif_opsi->toClientList($Page) ?>;
    fnpd_reviewedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    fnpd_reviewedit.lists.review_by = <?= $Page->review_by->toClientList($Page) ?>;
    fnpd_reviewedit.lists.receipt_by = <?= $Page->receipt_by->toClientList($Page) ?>;
    fnpd_reviewedit.lists.checked_by = <?= $Page->checked_by->toClientList($Page) ?>;
    loadjs.done("fnpd_reviewedit");
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
<form name="fnpd_reviewedit" id="fnpd_reviewedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_review">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "npd") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div d-none"><!-- page* -->
<?php if ($Page->tanggal_review->Visible) { // tanggal_review ?>
    <div id="r_tanggal_review" class="form-group row">
        <label id="elh_npd_review_tanggal_review" for="x_tanggal_review" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_tanggal_review"><?= $Page->tanggal_review->caption() ?><?= $Page->tanggal_review->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_review->cellAttributes() ?>>
<template id="tpx_npd_review_tanggal_review"><span id="el_npd_review_tanggal_review">
<input type="<?= $Page->tanggal_review->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_review" name="x_tanggal_review" id="x_tanggal_review" placeholder="<?= HtmlEncode($Page->tanggal_review->getPlaceHolder()) ?>" value="<?= $Page->tanggal_review->EditValue ?>"<?= $Page->tanggal_review->editAttributes() ?> aria-describedby="x_tanggal_review_help">
<?= $Page->tanggal_review->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_review->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_review->ReadOnly && !$Page->tanggal_review->Disabled && !isset($Page->tanggal_review->EditAttrs["readonly"]) && !isset($Page->tanggal_review->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewedit", "x_tanggal_review", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
    <div id="r_tanggal_submit" class="form-group row">
        <label id="elh_npd_review_tanggal_submit" for="x_tanggal_submit" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_tanggal_submit"><?= $Page->tanggal_submit->caption() ?><?= $Page->tanggal_submit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_submit->cellAttributes() ?>>
<template id="tpx_npd_review_tanggal_submit"><span id="el_npd_review_tanggal_submit">
<input type="<?= $Page->tanggal_submit->getInputTextType() ?>" data-table="npd_review" data-field="x_tanggal_submit" name="x_tanggal_submit" id="x_tanggal_submit" placeholder="<?= HtmlEncode($Page->tanggal_submit->getPlaceHolder()) ?>" value="<?= $Page->tanggal_submit->EditValue ?>"<?= $Page->tanggal_submit->editAttributes() ?> aria-describedby="x_tanggal_submit_help">
<?= $Page->tanggal_submit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_submit->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_submit->ReadOnly && !$Page->tanggal_submit->Disabled && !isset($Page->tanggal_submit->EditAttrs["readonly"]) && !isset($Page->tanggal_submit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_reviewedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_reviewedit", "x_tanggal_submit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->wadah->Visible) { // wadah ?>
    <div id="r_wadah" class="form-group row">
        <label id="elh_npd_review_wadah" for="x_wadah" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_wadah"><?= $Page->wadah->caption() ?><?= $Page->wadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->wadah->cellAttributes() ?>>
<template id="tpx_npd_review_wadah"><span id="el_npd_review_wadah">
<input type="<?= $Page->wadah->getInputTextType() ?>" data-table="npd_review" data-field="x_wadah" name="x_wadah" id="x_wadah" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->wadah->getPlaceHolder()) ?>" value="<?= $Page->wadah->EditValue ?>"<?= $Page->wadah->editAttributes() ?> aria-describedby="x_wadah_help">
<?= $Page->wadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->wadah->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuk_opsi->Visible) { // bentuk_opsi ?>
    <div id="r_bentuk_opsi" class="form-group row">
        <label id="elh_npd_review_bentuk_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_bentuk_opsi"><?= $Page->bentuk_opsi->caption() ?><?= $Page->bentuk_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuk_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_bentuk_opsi"><span id="el_npd_review_bentuk_opsi">
<template id="tp_x_bentuk_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_bentuk_opsi" name="x_bentuk_opsi" id="x_bentuk_opsi"<?= $Page->bentuk_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_bentuk_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_bentuk_opsi"
    name="x_bentuk_opsi"
    value="<?= HtmlEncode($Page->bentuk_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_bentuk_opsi"
    data-target="dsl_x_bentuk_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->bentuk_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_bentuk_opsi"
    data-value-separator="<?= $Page->bentuk_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->bentuk_opsi->editAttributes() ?>>
<?= $Page->bentuk_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuk_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuk_revisi->Visible) { // bentuk_revisi ?>
    <div id="r_bentuk_revisi" class="form-group row">
        <label id="elh_npd_review_bentuk_revisi" for="x_bentuk_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_bentuk_revisi"><?= $Page->bentuk_revisi->caption() ?><?= $Page->bentuk_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuk_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_bentuk_revisi"><span id="el_npd_review_bentuk_revisi">
<input type="<?= $Page->bentuk_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_bentuk_revisi" name="x_bentuk_revisi" id="x_bentuk_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bentuk_revisi->getPlaceHolder()) ?>" value="<?= $Page->bentuk_revisi->EditValue ?>"<?= $Page->bentuk_revisi->editAttributes() ?> aria-describedby="x_bentuk_revisi_help">
<?= $Page->bentuk_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuk_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositas_opsi->Visible) { // viskositas_opsi ?>
    <div id="r_viskositas_opsi" class="form-group row">
        <label id="elh_npd_review_viskositas_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_viskositas_opsi"><?= $Page->viskositas_opsi->caption() ?><?= $Page->viskositas_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositas_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_viskositas_opsi"><span id="el_npd_review_viskositas_opsi">
<template id="tp_x_viskositas_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_viskositas_opsi" name="x_viskositas_opsi" id="x_viskositas_opsi"<?= $Page->viskositas_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_viskositas_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_viskositas_opsi"
    name="x_viskositas_opsi"
    value="<?= HtmlEncode($Page->viskositas_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_viskositas_opsi"
    data-target="dsl_x_viskositas_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->viskositas_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_viskositas_opsi"
    data-value-separator="<?= $Page->viskositas_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->viskositas_opsi->editAttributes() ?>>
<?= $Page->viskositas_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositas_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->viskositas_revisi->Visible) { // viskositas_revisi ?>
    <div id="r_viskositas_revisi" class="form-group row">
        <label id="elh_npd_review_viskositas_revisi" for="x_viskositas_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_viskositas_revisi"><?= $Page->viskositas_revisi->caption() ?><?= $Page->viskositas_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->viskositas_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_viskositas_revisi"><span id="el_npd_review_viskositas_revisi">
<input type="<?= $Page->viskositas_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_viskositas_revisi" name="x_viskositas_revisi" id="x_viskositas_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->viskositas_revisi->getPlaceHolder()) ?>" value="<?= $Page->viskositas_revisi->EditValue ?>"<?= $Page->viskositas_revisi->editAttributes() ?> aria-describedby="x_viskositas_revisi_help">
<?= $Page->viskositas_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->viskositas_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jeniswarna_opsi->Visible) { // jeniswarna_opsi ?>
    <div id="r_jeniswarna_opsi" class="form-group row">
        <label id="elh_npd_review_jeniswarna_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_jeniswarna_opsi"><?= $Page->jeniswarna_opsi->caption() ?><?= $Page->jeniswarna_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jeniswarna_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_jeniswarna_opsi"><span id="el_npd_review_jeniswarna_opsi">
<template id="tp_x_jeniswarna_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_jeniswarna_opsi" name="x_jeniswarna_opsi" id="x_jeniswarna_opsi"<?= $Page->jeniswarna_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_jeniswarna_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_jeniswarna_opsi"
    name="x_jeniswarna_opsi"
    value="<?= HtmlEncode($Page->jeniswarna_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_jeniswarna_opsi"
    data-target="dsl_x_jeniswarna_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->jeniswarna_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_jeniswarna_opsi"
    data-value-separator="<?= $Page->jeniswarna_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->jeniswarna_opsi->editAttributes() ?>>
<?= $Page->jeniswarna_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jeniswarna_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jeniswarna_revisi->Visible) { // jeniswarna_revisi ?>
    <div id="r_jeniswarna_revisi" class="form-group row">
        <label id="elh_npd_review_jeniswarna_revisi" for="x_jeniswarna_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_jeniswarna_revisi"><?= $Page->jeniswarna_revisi->caption() ?><?= $Page->jeniswarna_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jeniswarna_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_jeniswarna_revisi"><span id="el_npd_review_jeniswarna_revisi">
<input type="<?= $Page->jeniswarna_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_jeniswarna_revisi" name="x_jeniswarna_revisi" id="x_jeniswarna_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jeniswarna_revisi->getPlaceHolder()) ?>" value="<?= $Page->jeniswarna_revisi->EditValue ?>"<?= $Page->jeniswarna_revisi->editAttributes() ?> aria-describedby="x_jeniswarna_revisi_help">
<?= $Page->jeniswarna_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jeniswarna_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tonewarna_opsi->Visible) { // tonewarna_opsi ?>
    <div id="r_tonewarna_opsi" class="form-group row">
        <label id="elh_npd_review_tonewarna_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_tonewarna_opsi"><?= $Page->tonewarna_opsi->caption() ?><?= $Page->tonewarna_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tonewarna_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_tonewarna_opsi"><span id="el_npd_review_tonewarna_opsi">
<template id="tp_x_tonewarna_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_tonewarna_opsi" name="x_tonewarna_opsi" id="x_tonewarna_opsi"<?= $Page->tonewarna_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_tonewarna_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_tonewarna_opsi"
    name="x_tonewarna_opsi"
    value="<?= HtmlEncode($Page->tonewarna_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tonewarna_opsi"
    data-target="dsl_x_tonewarna_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tonewarna_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_tonewarna_opsi"
    data-value-separator="<?= $Page->tonewarna_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->tonewarna_opsi->editAttributes() ?>>
<?= $Page->tonewarna_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tonewarna_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tonewarna_revisi->Visible) { // tonewarna_revisi ?>
    <div id="r_tonewarna_revisi" class="form-group row">
        <label id="elh_npd_review_tonewarna_revisi" for="x_tonewarna_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_tonewarna_revisi"><?= $Page->tonewarna_revisi->caption() ?><?= $Page->tonewarna_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tonewarna_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_tonewarna_revisi"><span id="el_npd_review_tonewarna_revisi">
<input type="<?= $Page->tonewarna_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_tonewarna_revisi" name="x_tonewarna_revisi" id="x_tonewarna_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tonewarna_revisi->getPlaceHolder()) ?>" value="<?= $Page->tonewarna_revisi->EditValue ?>"<?= $Page->tonewarna_revisi->editAttributes() ?> aria-describedby="x_tonewarna_revisi_help">
<?= $Page->tonewarna_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tonewarna_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gradasiwarna_opsi->Visible) { // gradasiwarna_opsi ?>
    <div id="r_gradasiwarna_opsi" class="form-group row">
        <label id="elh_npd_review_gradasiwarna_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_gradasiwarna_opsi"><?= $Page->gradasiwarna_opsi->caption() ?><?= $Page->gradasiwarna_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gradasiwarna_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_gradasiwarna_opsi"><span id="el_npd_review_gradasiwarna_opsi">
<template id="tp_x_gradasiwarna_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_gradasiwarna_opsi" name="x_gradasiwarna_opsi" id="x_gradasiwarna_opsi"<?= $Page->gradasiwarna_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_gradasiwarna_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_gradasiwarna_opsi"
    name="x_gradasiwarna_opsi"
    value="<?= HtmlEncode($Page->gradasiwarna_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_gradasiwarna_opsi"
    data-target="dsl_x_gradasiwarna_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->gradasiwarna_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_gradasiwarna_opsi"
    data-value-separator="<?= $Page->gradasiwarna_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->gradasiwarna_opsi->editAttributes() ?>>
<?= $Page->gradasiwarna_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gradasiwarna_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gradasiwarna_revisi->Visible) { // gradasiwarna_revisi ?>
    <div id="r_gradasiwarna_revisi" class="form-group row">
        <label id="elh_npd_review_gradasiwarna_revisi" for="x_gradasiwarna_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_gradasiwarna_revisi"><?= $Page->gradasiwarna_revisi->caption() ?><?= $Page->gradasiwarna_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gradasiwarna_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_gradasiwarna_revisi"><span id="el_npd_review_gradasiwarna_revisi">
<input type="<?= $Page->gradasiwarna_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_gradasiwarna_revisi" name="x_gradasiwarna_revisi" id="x_gradasiwarna_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->gradasiwarna_revisi->getPlaceHolder()) ?>" value="<?= $Page->gradasiwarna_revisi->EditValue ?>"<?= $Page->gradasiwarna_revisi->editAttributes() ?> aria-describedby="x_gradasiwarna_revisi_help">
<?= $Page->gradasiwarna_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gradasiwarna_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bauparfum_opsi->Visible) { // bauparfum_opsi ?>
    <div id="r_bauparfum_opsi" class="form-group row">
        <label id="elh_npd_review_bauparfum_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_bauparfum_opsi"><?= $Page->bauparfum_opsi->caption() ?><?= $Page->bauparfum_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bauparfum_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_bauparfum_opsi"><span id="el_npd_review_bauparfum_opsi">
<template id="tp_x_bauparfum_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_bauparfum_opsi" name="x_bauparfum_opsi" id="x_bauparfum_opsi"<?= $Page->bauparfum_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_bauparfum_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_bauparfum_opsi"
    name="x_bauparfum_opsi"
    value="<?= HtmlEncode($Page->bauparfum_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_bauparfum_opsi"
    data-target="dsl_x_bauparfum_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->bauparfum_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_bauparfum_opsi"
    data-value-separator="<?= $Page->bauparfum_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->bauparfum_opsi->editAttributes() ?>>
<?= $Page->bauparfum_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bauparfum_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bauparfum_revisi->Visible) { // bauparfum_revisi ?>
    <div id="r_bauparfum_revisi" class="form-group row">
        <label id="elh_npd_review_bauparfum_revisi" for="x_bauparfum_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_bauparfum_revisi"><?= $Page->bauparfum_revisi->caption() ?><?= $Page->bauparfum_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bauparfum_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_bauparfum_revisi"><span id="el_npd_review_bauparfum_revisi">
<input type="<?= $Page->bauparfum_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_bauparfum_revisi" name="x_bauparfum_revisi" id="x_bauparfum_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bauparfum_revisi->getPlaceHolder()) ?>" value="<?= $Page->bauparfum_revisi->EditValue ?>"<?= $Page->bauparfum_revisi->editAttributes() ?> aria-describedby="x_bauparfum_revisi_help">
<?= $Page->bauparfum_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bauparfum_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estetika_opsi->Visible) { // estetika_opsi ?>
    <div id="r_estetika_opsi" class="form-group row">
        <label id="elh_npd_review_estetika_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_estetika_opsi"><?= $Page->estetika_opsi->caption() ?><?= $Page->estetika_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estetika_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_estetika_opsi"><span id="el_npd_review_estetika_opsi">
<template id="tp_x_estetika_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_estetika_opsi" name="x_estetika_opsi" id="x_estetika_opsi"<?= $Page->estetika_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_estetika_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_estetika_opsi"
    name="x_estetika_opsi"
    value="<?= HtmlEncode($Page->estetika_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_estetika_opsi"
    data-target="dsl_x_estetika_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->estetika_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_estetika_opsi"
    data-value-separator="<?= $Page->estetika_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->estetika_opsi->editAttributes() ?>>
<?= $Page->estetika_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estetika_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estetika_revisi->Visible) { // estetika_revisi ?>
    <div id="r_estetika_revisi" class="form-group row">
        <label id="elh_npd_review_estetika_revisi" for="x_estetika_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_estetika_revisi"><?= $Page->estetika_revisi->caption() ?><?= $Page->estetika_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estetika_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_estetika_revisi"><span id="el_npd_review_estetika_revisi">
<input type="<?= $Page->estetika_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_estetika_revisi" name="x_estetika_revisi" id="x_estetika_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->estetika_revisi->getPlaceHolder()) ?>" value="<?= $Page->estetika_revisi->EditValue ?>"<?= $Page->estetika_revisi->editAttributes() ?> aria-describedby="x_estetika_revisi_help">
<?= $Page->estetika_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estetika_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasiawal_opsi->Visible) { // aplikasiawal_opsi ?>
    <div id="r_aplikasiawal_opsi" class="form-group row">
        <label id="elh_npd_review_aplikasiawal_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_aplikasiawal_opsi"><?= $Page->aplikasiawal_opsi->caption() ?><?= $Page->aplikasiawal_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasiawal_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasiawal_opsi"><span id="el_npd_review_aplikasiawal_opsi">
<template id="tp_x_aplikasiawal_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_aplikasiawal_opsi" name="x_aplikasiawal_opsi" id="x_aplikasiawal_opsi"<?= $Page->aplikasiawal_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aplikasiawal_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aplikasiawal_opsi"
    name="x_aplikasiawal_opsi"
    value="<?= HtmlEncode($Page->aplikasiawal_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_aplikasiawal_opsi"
    data-target="dsl_x_aplikasiawal_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->aplikasiawal_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_aplikasiawal_opsi"
    data-value-separator="<?= $Page->aplikasiawal_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->aplikasiawal_opsi->editAttributes() ?>>
<?= $Page->aplikasiawal_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasiawal_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasiawal_revisi->Visible) { // aplikasiawal_revisi ?>
    <div id="r_aplikasiawal_revisi" class="form-group row">
        <label id="elh_npd_review_aplikasiawal_revisi" for="x_aplikasiawal_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_aplikasiawal_revisi"><?= $Page->aplikasiawal_revisi->caption() ?><?= $Page->aplikasiawal_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasiawal_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasiawal_revisi"><span id="el_npd_review_aplikasiawal_revisi">
<input type="<?= $Page->aplikasiawal_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_aplikasiawal_revisi" name="x_aplikasiawal_revisi" id="x_aplikasiawal_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->aplikasiawal_revisi->getPlaceHolder()) ?>" value="<?= $Page->aplikasiawal_revisi->EditValue ?>"<?= $Page->aplikasiawal_revisi->editAttributes() ?> aria-describedby="x_aplikasiawal_revisi_help">
<?= $Page->aplikasiawal_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasiawal_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasilama_opsi->Visible) { // aplikasilama_opsi ?>
    <div id="r_aplikasilama_opsi" class="form-group row">
        <label id="elh_npd_review_aplikasilama_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_aplikasilama_opsi"><?= $Page->aplikasilama_opsi->caption() ?><?= $Page->aplikasilama_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasilama_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasilama_opsi"><span id="el_npd_review_aplikasilama_opsi">
<template id="tp_x_aplikasilama_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_aplikasilama_opsi" name="x_aplikasilama_opsi" id="x_aplikasilama_opsi"<?= $Page->aplikasilama_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_aplikasilama_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_aplikasilama_opsi"
    name="x_aplikasilama_opsi"
    value="<?= HtmlEncode($Page->aplikasilama_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_aplikasilama_opsi"
    data-target="dsl_x_aplikasilama_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->aplikasilama_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_aplikasilama_opsi"
    data-value-separator="<?= $Page->aplikasilama_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->aplikasilama_opsi->editAttributes() ?>>
<?= $Page->aplikasilama_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasilama_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasilama_revisi->Visible) { // aplikasilama_revisi ?>
    <div id="r_aplikasilama_revisi" class="form-group row">
        <label id="elh_npd_review_aplikasilama_revisi" for="x_aplikasilama_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_aplikasilama_revisi"><?= $Page->aplikasilama_revisi->caption() ?><?= $Page->aplikasilama_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasilama_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_aplikasilama_revisi"><span id="el_npd_review_aplikasilama_revisi">
<input type="<?= $Page->aplikasilama_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_aplikasilama_revisi" name="x_aplikasilama_revisi" id="x_aplikasilama_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->aplikasilama_revisi->getPlaceHolder()) ?>" value="<?= $Page->aplikasilama_revisi->EditValue ?>"<?= $Page->aplikasilama_revisi->editAttributes() ?> aria-describedby="x_aplikasilama_revisi_help">
<?= $Page->aplikasilama_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasilama_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efekpositif_opsi->Visible) { // efekpositif_opsi ?>
    <div id="r_efekpositif_opsi" class="form-group row">
        <label id="elh_npd_review_efekpositif_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_efekpositif_opsi"><?= $Page->efekpositif_opsi->caption() ?><?= $Page->efekpositif_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efekpositif_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_efekpositif_opsi"><span id="el_npd_review_efekpositif_opsi">
<template id="tp_x_efekpositif_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_efekpositif_opsi" name="x_efekpositif_opsi" id="x_efekpositif_opsi"<?= $Page->efekpositif_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_efekpositif_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_efekpositif_opsi"
    name="x_efekpositif_opsi"
    value="<?= HtmlEncode($Page->efekpositif_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_efekpositif_opsi"
    data-target="dsl_x_efekpositif_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->efekpositif_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_efekpositif_opsi"
    data-value-separator="<?= $Page->efekpositif_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->efekpositif_opsi->editAttributes() ?>>
<?= $Page->efekpositif_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efekpositif_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efekpositif_revisi->Visible) { // efekpositif_revisi ?>
    <div id="r_efekpositif_revisi" class="form-group row">
        <label id="elh_npd_review_efekpositif_revisi" for="x_efekpositif_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_efekpositif_revisi"><?= $Page->efekpositif_revisi->caption() ?><?= $Page->efekpositif_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efekpositif_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_efekpositif_revisi"><span id="el_npd_review_efekpositif_revisi">
<input type="<?= $Page->efekpositif_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_efekpositif_revisi" name="x_efekpositif_revisi" id="x_efekpositif_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->efekpositif_revisi->getPlaceHolder()) ?>" value="<?= $Page->efekpositif_revisi->EditValue ?>"<?= $Page->efekpositif_revisi->editAttributes() ?> aria-describedby="x_efekpositif_revisi_help">
<?= $Page->efekpositif_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efekpositif_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efeknegatif_opsi->Visible) { // efeknegatif_opsi ?>
    <div id="r_efeknegatif_opsi" class="form-group row">
        <label id="elh_npd_review_efeknegatif_opsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_efeknegatif_opsi"><?= $Page->efeknegatif_opsi->caption() ?><?= $Page->efeknegatif_opsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efeknegatif_opsi->cellAttributes() ?>>
<template id="tpx_npd_review_efeknegatif_opsi"><span id="el_npd_review_efeknegatif_opsi">
<template id="tp_x_efeknegatif_opsi">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="npd_review" data-field="x_efeknegatif_opsi" name="x_efeknegatif_opsi" id="x_efeknegatif_opsi"<?= $Page->efeknegatif_opsi->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_efeknegatif_opsi" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_efeknegatif_opsi"
    name="x_efeknegatif_opsi"
    value="<?= HtmlEncode($Page->efeknegatif_opsi->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_efeknegatif_opsi"
    data-target="dsl_x_efeknegatif_opsi"
    data-repeatcolumn="5"
    class="form-control<?= $Page->efeknegatif_opsi->isInvalidClass() ?>"
    data-table="npd_review"
    data-field="x_efeknegatif_opsi"
    data-value-separator="<?= $Page->efeknegatif_opsi->displayValueSeparatorAttribute() ?>"
    <?= $Page->efeknegatif_opsi->editAttributes() ?>>
<?= $Page->efeknegatif_opsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efeknegatif_opsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->efeknegatif_revisi->Visible) { // efeknegatif_revisi ?>
    <div id="r_efeknegatif_revisi" class="form-group row">
        <label id="elh_npd_review_efeknegatif_revisi" for="x_efeknegatif_revisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_efeknegatif_revisi"><?= $Page->efeknegatif_revisi->caption() ?><?= $Page->efeknegatif_revisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->efeknegatif_revisi->cellAttributes() ?>>
<template id="tpx_npd_review_efeknegatif_revisi"><span id="el_npd_review_efeknegatif_revisi">
<input type="<?= $Page->efeknegatif_revisi->getInputTextType() ?>" data-table="npd_review" data-field="x_efeknegatif_revisi" name="x_efeknegatif_revisi" id="x_efeknegatif_revisi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->efeknegatif_revisi->getPlaceHolder()) ?>" value="<?= $Page->efeknegatif_revisi->EditValue ?>"<?= $Page->efeknegatif_revisi->editAttributes() ?> aria-describedby="x_efeknegatif_revisi_help">
<?= $Page->efeknegatif_revisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->efeknegatif_revisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kesimpulan->Visible) { // kesimpulan ?>
    <div id="r_kesimpulan" class="form-group row">
        <label id="elh_npd_review_kesimpulan" for="x_kesimpulan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_kesimpulan"><?= $Page->kesimpulan->caption() ?><?= $Page->kesimpulan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kesimpulan->cellAttributes() ?>>
<template id="tpx_npd_review_kesimpulan"><span id="el_npd_review_kesimpulan">
<textarea data-table="npd_review" data-field="x_kesimpulan" name="x_kesimpulan" id="x_kesimpulan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->kesimpulan->getPlaceHolder()) ?>"<?= $Page->kesimpulan->editAttributes() ?> aria-describedby="x_kesimpulan_help"><?= $Page->kesimpulan->EditValue ?></textarea>
<?= $Page->kesimpulan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kesimpulan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_npd_review_status" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_status"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<template id="tpx_npd_review_status"><span id="el_npd_review_status">
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
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->review_by->Visible) { // review_by ?>
    <div id="r_review_by" class="form-group row">
        <label id="elh_npd_review_review_by" for="x_review_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_review_by"><?= $Page->review_by->caption() ?><?= $Page->review_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->review_by->cellAttributes() ?>>
<template id="tpx_npd_review_review_by"><span id="el_npd_review_review_by">
    <select
        id="x_review_by"
        name="x_review_by"
        class="form-control ew-select<?= $Page->review_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x_review_by"
        data-table="npd_review"
        data-field="x_review_by"
        data-value-separator="<?= $Page->review_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->review_by->getPlaceHolder()) ?>"
        <?= $Page->review_by->editAttributes() ?>>
        <?= $Page->review_by->selectOptionListHtml("x_review_by") ?>
    </select>
    <?= $Page->review_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->review_by->getErrorMessage() ?></div>
<?= $Page->review_by->Lookup->getParamTag($Page, "p_x_review_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x_review_by']"),
        options = { name: "x_review_by", selectId: "npd_review_x_review_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.review_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
    <div id="r_receipt_by" class="form-group row">
        <label id="elh_npd_review_receipt_by" for="x_receipt_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_receipt_by"><?= $Page->receipt_by->caption() ?><?= $Page->receipt_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->receipt_by->cellAttributes() ?>>
<template id="tpx_npd_review_receipt_by"><span id="el_npd_review_receipt_by">
    <select
        id="x_receipt_by"
        name="x_receipt_by"
        class="form-control ew-select<?= $Page->receipt_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x_receipt_by"
        data-table="npd_review"
        data-field="x_receipt_by"
        data-value-separator="<?= $Page->receipt_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->receipt_by->getPlaceHolder()) ?>"
        <?= $Page->receipt_by->editAttributes() ?>>
        <?= $Page->receipt_by->selectOptionListHtml("x_receipt_by") ?>
    </select>
    <?= $Page->receipt_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->receipt_by->getErrorMessage() ?></div>
<?= $Page->receipt_by->Lookup->getParamTag($Page, "p_x_receipt_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x_receipt_by']"),
        options = { name: "x_receipt_by", selectId: "npd_review_x_receipt_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.receipt_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <div id="r_checked_by" class="form-group row">
        <label id="elh_npd_review_checked_by" for="x_checked_by" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_npd_review_checked_by"><?= $Page->checked_by->caption() ?><?= $Page->checked_by->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->checked_by->cellAttributes() ?>>
<template id="tpx_npd_review_checked_by"><span id="el_npd_review_checked_by">
    <select
        id="x_checked_by"
        name="x_checked_by"
        class="form-control ew-select<?= $Page->checked_by->isInvalidClass() ?>"
        data-select2-id="npd_review_x_checked_by"
        data-table="npd_review"
        data-field="x_checked_by"
        data-value-separator="<?= $Page->checked_by->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->checked_by->getPlaceHolder()) ?>"
        <?= $Page->checked_by->editAttributes() ?>>
        <?= $Page->checked_by->selectOptionListHtml("x_checked_by") ?>
    </select>
    <?= $Page->checked_by->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->checked_by->getErrorMessage() ?></div>
<?= $Page->checked_by->Lookup->getParamTag($Page, "p_x_checked_by") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='npd_review_x_checked_by']"),
        options = { name: "x_checked_by", selectId: "npd_review_x_checked_by", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.npd_review.fields.checked_by.selectOptions);
    ew.createSelect(options);
});
</script>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="npd_review" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<div id="tpd_npd_reviewedit" class="ew-custom-template"></div>
<template id="tpm_npd_reviewedit">
<div id="ct_NpdReviewEdit"><div class="form-horizontal">
    <div class="card">
        <div class="card-body row">
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->idnpd->caption() ?></label>
                    <div class="col-5"><slot class="ew-slot" name="tpx_npd_review_idnpd"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right">Nomor Order</label>
                    <div class="col-7"><input type="text" name="x_nomororder" id="x_nomororder" class="form-control" placeholder="Nomor Order" disabled></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right">Status</label>
                    <div class="col-8"><input type="text" name="c_status" id="c_status" class="form-control" placeholder="Status" disabled></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tanggal_review->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_tanggal_review"></slot></div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label text-right"><?= $Page->tanggal_submit->caption() ?></label>
                    <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_tanggal_submit"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">DATA SAMPEL</div>
        </div>
        <div class="card-body row">
            <div class="col-6">
            	<div class="form-group row">
                	<label class="col-4 col-form-label text-right"><?= $Page->idnpd_sample->caption() ?></label>
                	<div class="col-8"><slot class="ew-slot" name="tpx_npd_review_idnpd_sample"></slot></div>
                </div>
            	<div class="form-group row">
                	<label class="col-4 col-form-label text-right">Nama Produk</label>
                	<div class="col-8"><input type="text" name="x_namaproduk" id="x_namaproduk" class="form-control" placeholder="Nama Produk" disabled></div>
                </div>
            </div>
            <div class="col-6">
            	<div class="form-group row">
                	<label class="col-2 col-form-label text-right">Volume</label>
                	<div class="col-8"><input type="text" name="x_volume" id="x_volume" class="form-control" placeholder="Volume" disabled></div>
                </div>
                <div class="form-group row">
                	<label class="col-2 col-form-label text-right"><?= $Page->wadah->caption() ?></label>
                	<div class="col-8"><slot class="ew-slot" name="tpx_npd_review_wadah"></slot></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">REVIEW SEDIAAN</div>
        </div>
        <div class="card-body">
            <div id="c_bentuk_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bentuk_opsi->caption() ?><br><small>(Gel/Krim/Cair/dll)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_bentuk_opsi"></slot></div>
            </div>
            <div id="c_bentuk_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bentuk_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_bentuk_revisi"></slot></div>
            </div>
            <div id="c_viskositas_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->viskositas_opsi->caption() ?><br><small>(Encer/Sedang/Kental)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_viskositas_opsi"></slot></div>
            </div>
            <div id="c_viskositas_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->viskositas_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_viskositas_revisi"></slot></div>
            </div>
            <div id="c_jeniswarna_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jeniswarna_opsi->caption() ?><br><small>(Bening/Biru/Kuning/dll)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_jeniswarna_opsi"></slot></div>
            </div>
            <div id="c_jeniswarna_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->jeniswarna_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_jeniswarna_revisi"></slot></div>
            </div>
            <div id="c_tonewarna_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tonewarna_opsi->caption() ?><br><small>(Gelap/Terang)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_tonewarna_opsi"></slot></div>
            </div>
            <div id="c_tonewarna_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->tonewarna_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_tonewarna_revisi"></slot></div>
            </div>
            <div id="c_gradasiwarna_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->gradasiwarna_opsi->caption() ?><br><small>(Transparan/Opaq)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_gradasiwarna_opsi"></slot></div>
            </div>
            <div id="c_gradasiwarna_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->gradasiwarna_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_gradasiwarna_revisi"></slot></div>
            </div>
            <div id="c_bauparfum_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bauparfum_opsi->caption() ?><br><small>(Jenis/Kadar)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_bauparfum_opsi"></slot></div>
            </div>
            <div id="c_bauparfum_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->bauparfum_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_bauparfum_revisi"></slot></div>
            </div>
            <div id="c_estetika_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->estetika_opsi->caption() ?><br><small>(Bubble/Petal/Glitter/dll)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_estetika_opsi"></slot></div>
            </div>
            <div id="c_estetika_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->estetika_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_estetika_revisi"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">REVIEW KUALITAS</div>
        </div>
        <div class="card-body">
            <div id="c_aplikasiawal_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasiawal_opsi->caption() ?><br><small>(Berat/Ringan/Lengket/Kering)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_aplikasiawal_opsi"></slot></div>
            </div>
            <div id="c_aplikasiawal_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasiawal_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_aplikasiawal_revisi"></slot></div>
            </div>
            <div id="c_aplikasilama_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasilama_opsi->caption() ?><br><small>(Berat/Ringan/Lengket/Kering)</small></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_aplikasilama_opsi"></slot></div>
            </div>
            <div id="c_aplikasilama_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->aplikasilama_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_aplikasilama_revisi"></slot></div>
            </div>
            <div id="c_efekpositif_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->efekpositif_opsi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_efekpositif_opsi"></slot></div>
            </div>
            <div id="c_efekpositif_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->efekpositif_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_efekpositif_revisi"></slot></div>
            </div>
            <div id="c_efeknegatif_opsi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->efeknegatif_opsi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_efeknegatif_opsi"></slot></div>
            </div>
            <div id="c_efeknegatif_revisi" class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->efeknegatif_revisi->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_efeknegatif_revisi"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">KESIMPULAN &amp; Saran</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->kesimpulan->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_kesimpulan"></slot></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->review_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_review_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->receipt_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_receipt_by"></slot></div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->checked_by->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_checked_by"></slot></div>
            </div>
        	<div class="form-group row">
                <label class="col-2 col-form-label text-right"><?= $Page->status->caption() ?></label>
                <div class="col-8"><slot class="ew-slot" name="tpx_npd_review_status"></slot></div>
            </div>
        </div>
    </div>
</div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_npd_reviewedit", "tpm_npd_reviewedit", "npd_reviewedit", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
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
    $("#c_bentuk_revisi, #c_viskositas_revisi, #c_jeniswarna_revisi, #c_tonewarna_revisi, #c_gradasiwarna_revisi, #c_bauparfum_revisi, #c_estetika_revisi, #c_aplikasiawal_revisi, #c_aplikasilama_revisi, #c_efekpositif_revisi, #c_efeknegatif_revisi").hide(),$("#c_bentuk_opsi, #c_viskositas_opsi, #c_jeniswarna_opsi, #c_tonewarna_opsi, #c_gradasiwarna_opsi, #c_bauparfum_opsi, #c_estetika_opsi, #c_aplikasiawal_opsi, #c_aplikasilama_opsi, #c_efekpositif_opsi, #c_efeknegatif_opsi").change((function(){var i=$('input[data-field="x_'+this.id.slice(2)+'"]:checked').val(),a="#c_"+this.id.slice(2,-4)+"revisi";i<1?$(a).show():$(a).hide()})),$("select[name=x_idnpd]").change((function(){$.ajax({url:"api/view/npd/"+$(this).val(),type:"GET",success:function(i){!1!==i.success&&($("#x_nomororder").val(i.npd.nomororder),$("#c_status").val(i.npd.status))}})})),$("select[name=x_idnpd_sample]").change((function(){$.ajax({url:"api/view/npd_sample/"+$(this).val(),type:"GET",success:function(i){!1!==i.success&&($("#x_namaproduk").val(i.npd_sample.nama),$("#x_volume").val(i.npd_sample.volume))}})}));
});
</script>
