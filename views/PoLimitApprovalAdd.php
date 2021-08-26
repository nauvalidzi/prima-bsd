<?php

namespace PHPMaker2021\distributor;

// Page object
$PoLimitApprovalAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpo_limit_approvaladd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpo_limit_approvaladd = currentForm = new ew.Form("fpo_limit_approvaladd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "po_limit_approval")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.po_limit_approval)
        ew.vars.tables.po_limit_approval = currentTable;
    fpo_limit_approvaladd.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["idcustomer", [fields.idcustomer.visible && fields.idcustomer.required ? ew.Validators.required(fields.idcustomer.caption) : null], fields.idcustomer.isInvalid],
        ["limit_kredit", [fields.limit_kredit.visible && fields.limit_kredit.required ? ew.Validators.required(fields.limit_kredit.caption) : null, ew.Validators.integer], fields.limit_kredit.isInvalid],
        ["limit_po_aktif", [fields.limit_po_aktif.visible && fields.limit_po_aktif.required ? ew.Validators.required(fields.limit_po_aktif.caption) : null, ew.Validators.integer], fields.limit_po_aktif.isInvalid],
        ["lampiran", [fields.lampiran.visible && fields.lampiran.required ? ew.Validators.fileRequired(fields.lampiran.caption) : null], fields.lampiran.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpo_limit_approvaladd,
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
    fpo_limit_approvaladd.validate = function () {
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
    fpo_limit_approvaladd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpo_limit_approvaladd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpo_limit_approvaladd.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    fpo_limit_approvaladd.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    loadjs.done("fpo_limit_approvaladd");
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
<form name="fpo_limit_approvaladd" id="fpo_limit_approvaladd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="po_limit_approval">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_po_limit_approval_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_po_limit_approval_idpegawai">
<?php $Page->idpegawai->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x_idpegawai"
        data-table="po_limit_approval"
        data-field="x_idpegawai"
        data-value-separator="<?= $Page->idpegawai->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idpegawai->getPlaceHolder()) ?>"
        <?= $Page->idpegawai->editAttributes() ?>>
        <?= $Page->idpegawai->selectOptionListHtml("x_idpegawai") ?>
    </select>
    <?= $Page->idpegawai->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idpegawai->getErrorMessage() ?></div>
<?= $Page->idpegawai->Lookup->getParamTag($Page, "p_x_idpegawai") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "po_limit_approval_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label id="elh_po_limit_approval_idcustomer" for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idcustomer->caption() ?><?= $Page->idcustomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_po_limit_approval_idcustomer">
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="po_limit_approval_x_idcustomer"
        data-table="po_limit_approval"
        data-field="x_idcustomer"
        data-value-separator="<?= $Page->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>"
        <?= $Page->idcustomer->editAttributes() ?>>
        <?= $Page->idcustomer->selectOptionListHtml("x_idcustomer") ?>
    </select>
    <?= $Page->idcustomer->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage() ?></div>
<?= $Page->idcustomer->Lookup->getParamTag($Page, "p_x_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='po_limit_approval_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "po_limit_approval_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.po_limit_approval.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limit_kredit->Visible) { // limit_kredit ?>
    <div id="r_limit_kredit" class="form-group row">
        <label id="elh_po_limit_approval_limit_kredit" for="x_limit_kredit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limit_kredit->caption() ?><?= $Page->limit_kredit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->limit_kredit->cellAttributes() ?>>
<span id="el_po_limit_approval_limit_kredit">
<input type="<?= $Page->limit_kredit->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_kredit" name="x_limit_kredit" id="x_limit_kredit" size="30" placeholder="<?= HtmlEncode($Page->limit_kredit->getPlaceHolder()) ?>" value="<?= $Page->limit_kredit->EditValue ?>"<?= $Page->limit_kredit->editAttributes() ?> aria-describedby="x_limit_kredit_help">
<?= $Page->limit_kredit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limit_kredit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limit_po_aktif->Visible) { // limit_po_aktif ?>
    <div id="r_limit_po_aktif" class="form-group row">
        <label id="elh_po_limit_approval_limit_po_aktif" for="x_limit_po_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limit_po_aktif->caption() ?><?= $Page->limit_po_aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->limit_po_aktif->cellAttributes() ?>>
<span id="el_po_limit_approval_limit_po_aktif">
<input type="<?= $Page->limit_po_aktif->getInputTextType() ?>" data-table="po_limit_approval" data-field="x_limit_po_aktif" name="x_limit_po_aktif" id="x_limit_po_aktif" size="30" placeholder="<?= HtmlEncode($Page->limit_po_aktif->getPlaceHolder()) ?>" value="<?= $Page->limit_po_aktif->EditValue ?>"<?= $Page->limit_po_aktif->editAttributes() ?> aria-describedby="x_limit_po_aktif_help">
<?= $Page->limit_po_aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limit_po_aktif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <div id="r_lampiran" class="form-group row">
        <label id="elh_po_limit_approval_lampiran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lampiran->caption() ?><?= $Page->lampiran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lampiran->cellAttributes() ?>>
<span id="el_po_limit_approval_lampiran">
<div id="fd_x_lampiran">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->lampiran->title() ?>" data-table="po_limit_approval" data-field="x_lampiran" name="x_lampiran" id="x_lampiran" lang="<?= CurrentLanguageID() ?>"<?= $Page->lampiran->editAttributes() ?><?= ($Page->lampiran->ReadOnly || $Page->lampiran->Disabled) ? " disabled" : "" ?> aria-describedby="x_lampiran_help">
        <label class="custom-file-label ew-file-label" for="x_lampiran"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->lampiran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lampiran->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_lampiran" id= "fn_x_lampiran" value="<?= $Page->lampiran->Upload->FileName ?>">
<input type="hidden" name="fa_x_lampiran" id= "fa_x_lampiran" value="0">
<input type="hidden" name="fs_x_lampiran" id= "fs_x_lampiran" value="255">
<input type="hidden" name="fx_x_lampiran" id= "fx_x_lampiran" value="<?= $Page->lampiran->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_lampiran" id= "fm_x_lampiran" value="<?= $Page->lampiran->UploadMaxFileSize ?>">
</div>
<table id="ft_x_lampiran" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("po_limit_approval_detail", explode(",", $Page->getCurrentDetailTable())) && $po_limit_approval_detail->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("po_limit_approval_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PoLimitApprovalDetailGrid.php" ?>
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
    ew.addEventHandlers("po_limit_approval");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
