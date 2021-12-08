<?php

namespace PHPMaker2021\distributor;

// Page object
$KpiMarketingAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkpi_marketingadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fkpi_marketingadd = currentForm = new ew.Form("fkpi_marketingadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kpi_marketing")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kpi_marketing)
        ew.vars.tables.kpi_marketing = currentTable;
    fkpi_marketingadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["bulan", [fields.bulan.visible && fields.bulan.required ? ew.Validators.required(fields.bulan.caption) : null], fields.bulan.isInvalid],
        ["target", [fields.target.visible && fields.target.required ? ew.Validators.required(fields.target.caption) : null, ew.Validators.integer], fields.target.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkpi_marketingadd,
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
    fkpi_marketingadd.validate = function () {
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
    fkpi_marketingadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkpi_marketingadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fkpi_marketingadd.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    loadjs.done("fkpi_marketingadd");
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
<form name="fkpi_marketingadd" id="fkpi_marketingadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kpi_marketing">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_kpi_marketing_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_kpi_marketing_id">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="kpi_marketing" data-field="x_id" name="x_id" id="x_id" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <div id="r_idpegawai" class="form-group row">
        <label id="elh_kpi_marketing_idpegawai" for="x_idpegawai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idpegawai->caption() ?><?= $Page->idpegawai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_kpi_marketing_idpegawai">
    <select
        id="x_idpegawai"
        name="x_idpegawai"
        class="form-control ew-select<?= $Page->idpegawai->isInvalidClass() ?>"
        data-select2-id="kpi_marketing_x_idpegawai"
        data-table="kpi_marketing"
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
    var el = document.querySelector("select[data-select2-id='kpi_marketing_x_idpegawai']"),
        options = { name: "x_idpegawai", selectId: "kpi_marketing_x_idpegawai", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kpi_marketing.fields.idpegawai.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bulan->Visible) { // bulan ?>
    <div id="r_bulan" class="form-group row">
        <label id="elh_kpi_marketing_bulan" for="x_bulan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bulan->caption() ?><?= $Page->bulan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bulan->cellAttributes() ?>>
<span id="el_kpi_marketing_bulan">
<input type="<?= $Page->bulan->getInputTextType() ?>" data-table="kpi_marketing" data-field="x_bulan" data-format="7" name="x_bulan" id="x_bulan" placeholder="<?= HtmlEncode($Page->bulan->getPlaceHolder()) ?>" value="<?= $Page->bulan->EditValue ?>"<?= $Page->bulan->editAttributes() ?> aria-describedby="x_bulan_help">
<?= $Page->bulan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bulan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
    <div id="r_target" class="form-group row">
        <label id="elh_kpi_marketing_target" for="x_target" class="<?= $Page->LeftColumnClass ?>"><?= $Page->target->caption() ?><?= $Page->target->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->target->cellAttributes() ?>>
<span id="el_kpi_marketing_target">
<input type="<?= $Page->target->getInputTextType() ?>" data-table="kpi_marketing" data-field="x_target" name="x_target" id="x_target" size="30" placeholder="<?= HtmlEncode($Page->target->getPlaceHolder()) ?>" value="<?= $Page->target->EditValue ?>"<?= $Page->target->editAttributes() ?> aria-describedby="x_target_help">
<?= $Page->target->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->target->getErrorMessage() ?></div>
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
    ew.addEventHandlers("kpi_marketing");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#fkpi_marketingadd").find("input[name=x_bulan]").prop({type:"month"});
});
</script>
