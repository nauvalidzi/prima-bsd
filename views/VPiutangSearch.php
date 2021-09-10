<?php

namespace PHPMaker2021\distributor;

// Page object
$VPiutangSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fv_piutangsearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fv_piutangsearch = currentAdvancedSearchForm = new ew.Form("fv_piutangsearch", "search");
    <?php } else { ?>
    fv_piutangsearch = currentForm = new ew.Form("fv_piutangsearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "v_piutang")) ?>,
        fields = currentTable.fields;
    fv_piutangsearch.addFields([
        ["idpegawai", [ew.Validators.integer], fields.idpegawai.isInvalid],
        ["idcustomer", [ew.Validators.integer], fields.idcustomer.isInvalid],
        ["totaltagihan", [ew.Validators.float], fields.totaltagihan.isInvalid],
        ["totalpiutang", [ew.Validators.float], fields.totalpiutang.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fv_piutangsearch.setInvalid();
    });

    // Validate form
    fv_piutangsearch.validate = function () {
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
    fv_piutangsearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fv_piutangsearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fv_piutangsearch.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    fv_piutangsearch.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    loadjs.done("fv_piutangsearch");
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
<form name="fv_piutangsearch" id="fv_piutangsearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_piutang">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_v_piutang_idpegawai"><?= $Page->idpegawai->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idpegawai" id="z_idpegawai" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
            <span id="el_v_piutang_idpegawai" class="ew-search-field ew-search-field-single">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$Page->userIDAllow("search")) { // Non system admin ?>
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="v_piutang_x_idpegawai"
        data-table="v_piutang"
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
    var el = document.querySelector("select[data-select2-id='v_piutang_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "v_piutang_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.v_piutang.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } else { ?>
<?php
$onchange = $Page->idpegawai->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idpegawai->EditAttrs["onchange"] = "";
?>
<span id="as_x_idpegawai" class="ew-auto-suggest">
    <input type="<?= $Page->idpegawai->getInputTextType() ?>" class="form-control" name="sv_x_idpegawai" id="sv_x_idpegawai" value="<?= RemoveHtml($Page->idpegawai->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->idpegawai->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idpegawai->getPlaceHolder()) ?>"<?= $Page->idpegawai->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="v_piutang" data-field="x_idpegawai" data-input="sv_x_idpegawai" data-value-separator="<?= $Page->idpegawai->displayValueSeparatorAttribute() ?>" name="x_idpegawai" id="x_idpegawai" value="<?= HtmlEncode($Page->idpegawai->AdvancedSearch->SearchValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->idpegawai->getErrorMessage(false) ?></div>
<script>
loadjs.ready(["fv_piutangsearch"], function() {
    fv_piutangsearch.createAutoSuggest(Object.assign({"id":"x_idpegawai","forceSelect":false}, ew.vars.tables.v_piutang.fields.idpegawai.autoSuggestOptions));
});
</script>
<?= $Page->idpegawai->Lookup->getParamTag($Page, "p_x_idpegawai") ?>
<?php } ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_v_piutang_idcustomer"><?= $Page->idcustomer->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idcustomer" id="z_idcustomer" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
            <span id="el_v_piutang_idcustomer" class="ew-search-field ew-search-field-single">
<?php
$onchange = $Page->idcustomer->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->idcustomer->EditAttrs["onchange"] = "";
?>
<span id="as_x_idcustomer" class="ew-auto-suggest">
    <input type="<?= $Page->idcustomer->getInputTextType() ?>" class="form-control" name="sv_x_idcustomer" id="sv_x_idcustomer" value="<?= RemoveHtml($Page->idcustomer->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>"<?= $Page->idcustomer->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="v_piutang" data-field="x_idcustomer" data-input="sv_x_idcustomer" data-value-separator="<?= $Page->idcustomer->displayValueSeparatorAttribute() ?>" name="x_idcustomer" id="x_idcustomer" value="<?= HtmlEncode($Page->idcustomer->AdvancedSearch->SearchValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage(false) ?></div>
<script>
loadjs.ready(["fv_piutangsearch"], function() {
    fv_piutangsearch.createAutoSuggest(Object.assign({"id":"x_idcustomer","forceSelect":false}, ew.vars.tables.v_piutang.fields.idcustomer.autoSuggestOptions));
});
</script>
<?= $Page->idcustomer->Lookup->getParamTag($Page, "p_x_idcustomer") ?>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <div id="r_totaltagihan" class="form-group row">
        <label for="x_totaltagihan" class="<?= $Page->LeftColumnClass ?>"><span id="elh_v_piutang_totaltagihan"><?= $Page->totaltagihan->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_totaltagihan" id="z_totaltagihan" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totaltagihan->cellAttributes() ?>>
            <span id="el_v_piutang_totaltagihan" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->totaltagihan->getInputTextType() ?>" data-table="v_piutang" data-field="x_totaltagihan" name="x_totaltagihan" id="x_totaltagihan" size="30" placeholder="<?= HtmlEncode($Page->totaltagihan->getPlaceHolder()) ?>" value="<?= $Page->totaltagihan->EditValue ?>"<?= $Page->totaltagihan->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->totaltagihan->getErrorMessage(false) ?></div>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->totalpiutang->Visible) { // totalpiutang ?>
    <div id="r_totalpiutang" class="form-group row">
        <label for="x_totalpiutang" class="<?= $Page->LeftColumnClass ?>"><span id="elh_v_piutang_totalpiutang"><?= $Page->totalpiutang->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_totalpiutang" id="z_totalpiutang" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->totalpiutang->cellAttributes() ?>>
            <span id="el_v_piutang_totalpiutang" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->totalpiutang->getInputTextType() ?>" data-table="v_piutang" data-field="x_totalpiutang" name="x_totalpiutang" id="x_totalpiutang" size="30" placeholder="<?= HtmlEncode($Page->totalpiutang->getPlaceHolder()) ?>" value="<?= $Page->totalpiutang->EditValue ?>"<?= $Page->totalpiutang->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->totalpiutang->getErrorMessage(false) ?></div>
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
    ew.addEventHandlers("v_piutang");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
