<?php

namespace PHPMaker2021\distributor;

// Page object
$BrandAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fbrandadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fbrandadd = currentForm = new ew.Form("fbrandadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "brand")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.brand)
        ew.vars.tables.brand = currentTable;
    fbrandadd.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["title", [fields.title.visible && fields.title.required ? ew.Validators.required(fields.title.caption) : null], fields.title.isInvalid],
        ["logo", [fields.logo.visible && fields.logo.required ? ew.Validators.fileRequired(fields.logo.caption) : null], fields.logo.isInvalid],
        ["titipmerk", [fields.titipmerk.visible && fields.titipmerk.required ? ew.Validators.required(fields.titipmerk.caption) : null], fields.titipmerk.isInvalid],
        ["ijinhaki", [fields.ijinhaki.visible && fields.ijinhaki.required ? ew.Validators.required(fields.ijinhaki.caption) : null], fields.ijinhaki.isInvalid],
        ["ijinbpom", [fields.ijinbpom.visible && fields.ijinbpom.required ? ew.Validators.required(fields.ijinbpom.caption) : null], fields.ijinbpom.isInvalid],
        ["aktaperusahaan", [fields.aktaperusahaan.visible && fields.aktaperusahaan.required ? ew.Validators.fileRequired(fields.aktaperusahaan.caption) : null], fields.aktaperusahaan.isInvalid],
        ["kode_sip", [fields.kode_sip.visible && fields.kode_sip.required ? ew.Validators.required(fields.kode_sip.caption) : null], fields.kode_sip.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fbrandadd,
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
    fbrandadd.validate = function () {
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
    fbrandadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbrandadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fbrandadd.lists.titipmerk = <?= $Page->titipmerk->toClientList($Page) ?>;
    fbrandadd.lists.ijinhaki = <?= $Page->ijinhaki->toClientList($Page) ?>;
    fbrandadd.lists.ijinbpom = <?= $Page->ijinbpom->toClientList($Page) ?>;
    loadjs.done("fbrandadd");
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
<form name="fbrandadd" id="fbrandadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="brand">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_brand_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_brand_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" data-table="brand" data-field="x_kode" name="x_kode" id="x_kode" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" value="<?= $Page->kode->EditValue ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <div id="r_title" class="form-group row">
        <label id="elh_brand_title" for="x_title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->title->caption() ?><?= $Page->title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->title->cellAttributes() ?>>
<span id="el_brand_title">
<input type="<?= $Page->title->getInputTextType() ?>" data-table="brand" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->title->getPlaceHolder()) ?>" value="<?= $Page->title->EditValue ?>"<?= $Page->title->editAttributes() ?> aria-describedby="x_title_help">
<?= $Page->title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
    <div id="r_logo" class="form-group row">
        <label id="elh_brand_logo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->logo->caption() ?><?= $Page->logo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->logo->cellAttributes() ?>>
<span id="el_brand_logo">
<div id="fd_x_logo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->logo->title() ?>" data-table="brand" data-field="x_logo" name="x_logo" id="x_logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->logo->editAttributes() ?><?= ($Page->logo->ReadOnly || $Page->logo->Disabled) ? " disabled" : "" ?> aria-describedby="x_logo_help">
        <label class="custom-file-label ew-file-label" for="x_logo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->logo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_logo" id= "fn_x_logo" value="<?= $Page->logo->Upload->FileName ?>">
<input type="hidden" name="fa_x_logo" id= "fa_x_logo" value="0">
<input type="hidden" name="fs_x_logo" id= "fs_x_logo" value="255">
<input type="hidden" name="fx_x_logo" id= "fx_x_logo" value="<?= $Page->logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_logo" id= "fm_x_logo" value="<?= $Page->logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_logo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titipmerk->Visible) { // titipmerk ?>
    <div id="r_titipmerk" class="form-group row">
        <label id="elh_brand_titipmerk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titipmerk->caption() ?><?= $Page->titipmerk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->titipmerk->cellAttributes() ?>>
<span id="el_brand_titipmerk">
<template id="tp_x_titipmerk">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_titipmerk" name="x_titipmerk" id="x_titipmerk"<?= $Page->titipmerk->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_titipmerk" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_titipmerk"
    name="x_titipmerk"
    value="<?= HtmlEncode($Page->titipmerk->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_titipmerk"
    data-target="dsl_x_titipmerk"
    data-repeatcolumn="5"
    class="form-control<?= $Page->titipmerk->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_titipmerk"
    data-value-separator="<?= $Page->titipmerk->displayValueSeparatorAttribute() ?>"
    <?= $Page->titipmerk->editAttributes() ?>>
<?= $Page->titipmerk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titipmerk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ijinhaki->Visible) { // ijinhaki ?>
    <div id="r_ijinhaki" class="form-group row">
        <label id="elh_brand_ijinhaki" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijinhaki->caption() ?><?= $Page->ijinhaki->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijinhaki->cellAttributes() ?>>
<span id="el_brand_ijinhaki">
<template id="tp_x_ijinhaki">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinhaki" name="x_ijinhaki" id="x_ijinhaki"<?= $Page->ijinhaki->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_ijinhaki" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_ijinhaki"
    name="x_ijinhaki"
    value="<?= HtmlEncode($Page->ijinhaki->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_ijinhaki"
    data-target="dsl_x_ijinhaki"
    data-repeatcolumn="5"
    class="form-control<?= $Page->ijinhaki->isInvalidClass() ?>"
    data-table="brand"
    data-field="x_ijinhaki"
    data-value-separator="<?= $Page->ijinhaki->displayValueSeparatorAttribute() ?>"
    <?= $Page->ijinhaki->editAttributes() ?>>
<?= $Page->ijinhaki->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijinhaki->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
    <div id="r_ijinbpom" class="form-group row">
        <label id="elh_brand_ijinbpom" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijinbpom->caption() ?><?= $Page->ijinbpom->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijinbpom->cellAttributes() ?>>
<span id="el_brand_ijinbpom">
<template id="tp_x_ijinbpom">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="brand" data-field="x_ijinbpom" name="x_ijinbpom" id="x_ijinbpom"<?= $Page->ijinbpom->editAttributes() ?>>
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
    data-table="brand"
    data-field="x_ijinbpom"
    data-value-separator="<?= $Page->ijinbpom->displayValueSeparatorAttribute() ?>"
    <?= $Page->ijinbpom->editAttributes() ?>>
<?= $Page->ijinbpom->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijinbpom->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aktaperusahaan->Visible) { // aktaperusahaan ?>
    <div id="r_aktaperusahaan" class="form-group row">
        <label id="elh_brand_aktaperusahaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktaperusahaan->caption() ?><?= $Page->aktaperusahaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aktaperusahaan->cellAttributes() ?>>
<span id="el_brand_aktaperusahaan">
<div id="fd_x_aktaperusahaan">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->aktaperusahaan->title() ?>" data-table="brand" data-field="x_aktaperusahaan" name="x_aktaperusahaan" id="x_aktaperusahaan" lang="<?= CurrentLanguageID() ?>"<?= $Page->aktaperusahaan->editAttributes() ?><?= ($Page->aktaperusahaan->ReadOnly || $Page->aktaperusahaan->Disabled) ? " disabled" : "" ?> aria-describedby="x_aktaperusahaan_help">
        <label class="custom-file-label ew-file-label" for="x_aktaperusahaan"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->aktaperusahaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aktaperusahaan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_aktaperusahaan" id= "fn_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->Upload->FileName ?>">
<input type="hidden" name="fa_x_aktaperusahaan" id= "fa_x_aktaperusahaan" value="0">
<input type="hidden" name="fs_x_aktaperusahaan" id= "fs_x_aktaperusahaan" value="255">
<input type="hidden" name="fx_x_aktaperusahaan" id= "fx_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_aktaperusahaan" id= "fm_x_aktaperusahaan" value="<?= $Page->aktaperusahaan->UploadMaxFileSize ?>">
</div>
<table id="ft_x_aktaperusahaan" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kode_sip->Visible) { // kode_sip ?>
    <div id="r_kode_sip" class="form-group row">
        <label id="elh_brand_kode_sip" for="x_kode_sip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode_sip->caption() ?><?= $Page->kode_sip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode_sip->cellAttributes() ?>>
<span id="el_brand_kode_sip">
<input type="<?= $Page->kode_sip->getInputTextType() ?>" data-table="brand" data-field="x_kode_sip" name="x_kode_sip" id="x_kode_sip" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode_sip->getPlaceHolder()) ?>" value="<?= $Page->kode_sip->EditValue ?>"<?= $Page->kode_sip->editAttributes() ?> aria-describedby="x_kode_sip_help">
<?= $Page->kode_sip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode_sip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="accordion ew-accordion" id="Page_details"><!-- accordion -->
<?php
    if (in_array("product", explode(",", $Page->getCurrentDetailTable())) && $product->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "product") {
            $firstActiveDetailTable = "product";
        }
?>
    <div class="card ew-accordion-card <?= $Page->DetailPages->pageStyle("product") ?>">
        <div class="card-header">
            <h4 class="card-title">
                <a data-toggle="collapse" role="button" class="collapsed" aria-expanded="<?= JsonEncode($Page->DetailPages->isActive("product")) ?>" data-parent="#Page_details" href="#tab_product"><?= $Language->tablePhrase("product", "TblCaption") ?></a>
            </h4>
        </div>
        <div class="collapse <?= $Page->DetailPages->pageStyle("product") ?>" id="tab_product"><!-- page* -->
            <div class="card-body"><!-- .card-body -->
<?php include_once "ProductGrid.php" ?>
            </div><!-- /.card-body -->
        </div><!-- /page* -->
    </div>
<?php } ?>
<?php
    if (in_array("v_list_brand_customers", explode(",", $Page->getCurrentDetailTable())) && $v_list_brand_customers->DetailAdd) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "v_list_brand_customers") {
            $firstActiveDetailTable = "v_list_brand_customers";
        }
?>
    <div class="card ew-accordion-card <?= $Page->DetailPages->pageStyle("v_list_brand_customers") ?>">
        <div class="card-header">
            <h4 class="card-title">
                <a data-toggle="collapse" role="button" class="collapsed" aria-expanded="<?= JsonEncode($Page->DetailPages->isActive("v_list_brand_customers")) ?>" data-parent="#Page_details" href="#tab_v_list_brand_customers"><?= $Language->tablePhrase("v_list_brand_customers", "TblCaption") ?></a>
            </h4>
        </div>
        <div class="collapse <?= $Page->DetailPages->pageStyle("v_list_brand_customers") ?>" id="tab_v_list_brand_customers"><!-- page* -->
            <div class="card-body"><!-- .card-body -->
<?php include_once "VListBrandCustomersGrid.php" ?>
            </div><!-- /.card-body -->
        </div><!-- /page* -->
    </div>
<?php } ?>
</div><!-- /accordion -->
</div><!-- /detail-pages -->
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
    ew.addEventHandlers("brand");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("th[data-name=kode_customer], td[data-name=kode_customer]").remove(),$("th[data-name=nama_customer], td[data-name=nama_customer]").remove(),$("th[data-name=jumlah_produk], td[data-name=jumlah_produk]").remove();
});
</script>
