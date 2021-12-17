<?php

namespace PHPMaker2021\distributor;

// Page object
$IjinbpomEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinbpomedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fijinbpomedit = currentForm = new ew.Form("fijinbpomedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "ijinbpom")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.ijinbpom)
        ew.vars.tables.ijinbpom = currentTable;
    fijinbpomedit.addFields([
        ["tglterima", [fields.tglterima.visible && fields.tglterima.required ? ew.Validators.required(fields.tglterima.caption) : null, ew.Validators.datetime(0)], fields.tglterima.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["kontrakkerjasama", [fields.kontrakkerjasama.visible && fields.kontrakkerjasama.required ? ew.Validators.fileRequired(fields.kontrakkerjasama.caption) : null], fields.kontrakkerjasama.isInvalid],
        ["suratkuasa", [fields.suratkuasa.visible && fields.suratkuasa.required ? ew.Validators.fileRequired(fields.suratkuasa.caption) : null], fields.suratkuasa.isInvalid],
        ["suratpembagian", [fields.suratpembagian.visible && fields.suratpembagian.required ? ew.Validators.fileRequired(fields.suratpembagian.caption) : null], fields.suratpembagian.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fijinbpomedit,
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
    fijinbpomedit.validate = function () {
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
    fijinbpomedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fijinbpomedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fijinbpomedit.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fijinbpomedit");
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
<form name="fijinbpomedit" id="fijinbpomedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinbpom">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <div id="r_tglterima" class="form-group row">
        <label id="elh_ijinbpom_tglterima" for="x_tglterima" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglterima->caption() ?><?= $Page->tglterima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglterima->cellAttributes() ?>>
<span id="el_ijinbpom_tglterima">
<input type="<?= $Page->tglterima->getInputTextType() ?>" data-table="ijinbpom" data-field="x_tglterima" name="x_tglterima" id="x_tglterima" placeholder="<?= HtmlEncode($Page->tglterima->getPlaceHolder()) ?>" value="<?= $Page->tglterima->EditValue ?>"<?= $Page->tglterima->editAttributes() ?> aria-describedby="x_tglterima_help">
<?= $Page->tglterima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglterima->getErrorMessage() ?></div>
<?php if (!$Page->tglterima->ReadOnly && !$Page->tglterima->Disabled && !isset($Page->tglterima->EditAttrs["readonly"]) && !isset($Page->tglterima->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinbpomedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinbpomedit", "x_tglterima", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_ijinbpom_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_ijinbpom_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="ijinbpom" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fijinbpomedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fijinbpomedit", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kontrakkerjasama->Visible) { // kontrakkerjasama ?>
    <div id="r_kontrakkerjasama" class="form-group row">
        <label id="elh_ijinbpom_kontrakkerjasama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kontrakkerjasama->caption() ?><?= $Page->kontrakkerjasama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kontrakkerjasama->cellAttributes() ?>>
<span id="el_ijinbpom_kontrakkerjasama">
<div id="fd_x_kontrakkerjasama">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->kontrakkerjasama->title() ?>" data-table="ijinbpom" data-field="x_kontrakkerjasama" name="x_kontrakkerjasama" id="x_kontrakkerjasama" lang="<?= CurrentLanguageID() ?>"<?= $Page->kontrakkerjasama->editAttributes() ?><?= ($Page->kontrakkerjasama->ReadOnly || $Page->kontrakkerjasama->Disabled) ? " disabled" : "" ?> aria-describedby="x_kontrakkerjasama_help">
        <label class="custom-file-label ew-file-label" for="x_kontrakkerjasama"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->kontrakkerjasama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kontrakkerjasama->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_kontrakkerjasama" id= "fn_x_kontrakkerjasama" value="<?= $Page->kontrakkerjasama->Upload->FileName ?>">
<input type="hidden" name="fa_x_kontrakkerjasama" id= "fa_x_kontrakkerjasama" value="<?= (Post("fa_x_kontrakkerjasama") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_kontrakkerjasama" id= "fs_x_kontrakkerjasama" value="255">
<input type="hidden" name="fx_x_kontrakkerjasama" id= "fx_x_kontrakkerjasama" value="<?= $Page->kontrakkerjasama->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_kontrakkerjasama" id= "fm_x_kontrakkerjasama" value="<?= $Page->kontrakkerjasama->UploadMaxFileSize ?>">
</div>
<table id="ft_x_kontrakkerjasama" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->suratkuasa->Visible) { // suratkuasa ?>
    <div id="r_suratkuasa" class="form-group row">
        <label id="elh_ijinbpom_suratkuasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->suratkuasa->caption() ?><?= $Page->suratkuasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->suratkuasa->cellAttributes() ?>>
<span id="el_ijinbpom_suratkuasa">
<div id="fd_x_suratkuasa">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->suratkuasa->title() ?>" data-table="ijinbpom" data-field="x_suratkuasa" name="x_suratkuasa" id="x_suratkuasa" lang="<?= CurrentLanguageID() ?>"<?= $Page->suratkuasa->editAttributes() ?><?= ($Page->suratkuasa->ReadOnly || $Page->suratkuasa->Disabled) ? " disabled" : "" ?> aria-describedby="x_suratkuasa_help">
        <label class="custom-file-label ew-file-label" for="x_suratkuasa"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->suratkuasa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->suratkuasa->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_suratkuasa" id= "fn_x_suratkuasa" value="<?= $Page->suratkuasa->Upload->FileName ?>">
<input type="hidden" name="fa_x_suratkuasa" id= "fa_x_suratkuasa" value="<?= (Post("fa_x_suratkuasa") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_suratkuasa" id= "fs_x_suratkuasa" value="255">
<input type="hidden" name="fx_x_suratkuasa" id= "fx_x_suratkuasa" value="<?= $Page->suratkuasa->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_suratkuasa" id= "fm_x_suratkuasa" value="<?= $Page->suratkuasa->UploadMaxFileSize ?>">
</div>
<table id="ft_x_suratkuasa" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->suratpembagian->Visible) { // suratpembagian ?>
    <div id="r_suratpembagian" class="form-group row">
        <label id="elh_ijinbpom_suratpembagian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->suratpembagian->caption() ?><?= $Page->suratpembagian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->suratpembagian->cellAttributes() ?>>
<span id="el_ijinbpom_suratpembagian">
<div id="fd_x_suratpembagian">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->suratpembagian->title() ?>" data-table="ijinbpom" data-field="x_suratpembagian" name="x_suratpembagian" id="x_suratpembagian" lang="<?= CurrentLanguageID() ?>"<?= $Page->suratpembagian->editAttributes() ?><?= ($Page->suratpembagian->ReadOnly || $Page->suratpembagian->Disabled) ? " disabled" : "" ?> aria-describedby="x_suratpembagian_help">
        <label class="custom-file-label ew-file-label" for="x_suratpembagian"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->suratpembagian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->suratpembagian->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_suratpembagian" id= "fn_x_suratpembagian" value="<?= $Page->suratpembagian->Upload->FileName ?>">
<input type="hidden" name="fa_x_suratpembagian" id= "fa_x_suratpembagian" value="<?= (Post("fa_x_suratpembagian") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_suratpembagian" id= "fs_x_suratpembagian" value="255">
<input type="hidden" name="fx_x_suratpembagian" id= "fx_x_suratpembagian" value="<?= $Page->suratpembagian->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_suratpembagian" id= "fm_x_suratpembagian" value="<?= $Page->suratpembagian->UploadMaxFileSize ?>">
</div>
<table id="ft_x_suratpembagian" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_ijinbpom_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_ijinbpom_status">
    <select
        id="x_status"
        name="x_status"
        class="form-control ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="ijinbpom_x_status"
        data-table="ijinbpom"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='ijinbpom_x_status']"),
        options = { name: "x_status", selectId: "ijinbpom_x_status", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.ijinbpom.fields.status.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.ijinbpom.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="ijinbpom" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("ijinbpom_detail", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_detail->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_detail") {
            $firstActiveDetailTable = "ijinbpom_detail";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("ijinbpom_detail") ?>" href="#tab_ijinbpom_detail" data-toggle="tab"><?= $Language->tablePhrase("ijinbpom_detail", "TblCaption") ?></a></li>
<?php
    }
?>
<?php
    if (in_array("ijinbpom_status", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_status->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_status") {
            $firstActiveDetailTable = "ijinbpom_status";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("ijinbpom_status") ?>" href="#tab_ijinbpom_status" data-toggle="tab"><?= $Language->tablePhrase("ijinbpom_status", "TblCaption") ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("ijinbpom_detail", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_detail->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_detail") {
            $firstActiveDetailTable = "ijinbpom_detail";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("ijinbpom_detail") ?>" id="tab_ijinbpom_detail"><!-- page* -->
<?php include_once "IjinbpomDetailGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("ijinbpom_status", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_status->DetailEdit) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_status") {
            $firstActiveDetailTable = "ijinbpom_status";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("ijinbpom_status") ?>" id="tab_ijinbpom_status"><!-- page* -->
<?php include_once "IjinbpomStatusGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
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
    ew.addEventHandlers("ijinbpom");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
