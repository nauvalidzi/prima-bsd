<?php

namespace PHPMaker2021\distributor;

// Page object
$KpiMarketingUpdate = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkpi_marketingupdate;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "update";
    fkpi_marketingupdate = currentForm = new ew.Form("fkpi_marketingupdate", "update");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kpi_marketing")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kpi_marketing)
        ew.vars.tables.kpi_marketing = currentTable;
    fkpi_marketingupdate.addFields([
        ["idpegawai", [fields.idpegawai.visible && fields.idpegawai.required ? ew.Validators.required(fields.idpegawai.caption) : null], fields.idpegawai.isInvalid],
        ["bulan", [fields.bulan.visible && fields.bulan.required ? ew.Validators.required(fields.bulan.caption) : null], fields.bulan.isInvalid],
        ["target", [fields.target.visible && fields.target.required ? ew.Validators.required(fields.target.caption) : null, ew.Validators.integer, ew.Validators.selected], fields.target.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(111), ew.Validators.selected], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkpi_marketingupdate,
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
    fkpi_marketingupdate.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        if (!ew.updateSelected(fobj)) {
            ew.alert(ew.language.phrase("NoFieldSelected"));
            return false;
        }
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
        return true;
    }

    // Form_CustomValidate
    fkpi_marketingupdate.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkpi_marketingupdate.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fkpi_marketingupdate.lists.idpegawai = <?= $Page->idpegawai->toClientList($Page) ?>;
    loadjs.done("fkpi_marketingupdate");
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
<form name="fkpi_marketingupdate" id="fkpi_marketingupdate" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kpi_marketing">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_kpi_marketingupdate" class="ew-update-div"><!-- page -->
    <?php if (!$Page->isConfirm()) { // Confirm page ?>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" name="u" id="u" onclick="ew.selectAll(this);"><label class="custom-control-label" for="u"><?= $Language->phrase("UpdateSelectAll") ?></label>
    </div>
    <?php } ?>
<?php if ($Page->bulan->Visible && (!$Page->isConfirm() || $Page->bulan->multiUpdateSelected())) { // bulan ?>
    <div id="r_bulan" class="form-group row">
        <label for="x_bulan" class="<?= $Page->LeftColumnClass ?>">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_bulan" id="u_bulan" class="custom-control-input ew-multi-select" value="1"<?= $Page->bulan->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_bulan"><?= $Page->bulan->caption() ?></label>
            </div>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->bulan->cellAttributes() ?>>
                <span id="el_kpi_marketing_bulan">
                <input type="<?= $Page->bulan->getInputTextType() ?>" data-table="kpi_marketing" data-field="x_bulan" data-format="7" name="x_bulan" id="x_bulan" placeholder="<?= HtmlEncode($Page->bulan->getPlaceHolder()) ?>" value="<?= $Page->bulan->EditValue ?>"<?= $Page->bulan->editAttributes() ?> aria-describedby="x_bulan_help">
                <?= $Page->bulan->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->bulan->getErrorMessage() ?></div>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->target->Visible && (!$Page->isConfirm() || $Page->target->multiUpdateSelected())) { // target ?>
    <div id="r_target" class="form-group row">
        <label for="x_target" class="<?= $Page->LeftColumnClass ?>">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_target" id="u_target" class="custom-control-input ew-multi-select" value="1"<?= $Page->target->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_target"><?= $Page->target->caption() ?></label>
            </div>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->target->cellAttributes() ?>>
                <span id="el_kpi_marketing_target">
                <input type="<?= $Page->target->getInputTextType() ?>" data-table="kpi_marketing" data-field="x_target" name="x_target" id="x_target" size="30" placeholder="<?= HtmlEncode($Page->target->getPlaceHolder()) ?>" value="<?= $Page->target->EditValue ?>"<?= $Page->target->editAttributes() ?> aria-describedby="x_target_help">
                <?= $Page->target->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->target->getErrorMessage() ?></div>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible && (!$Page->isConfirm() || $Page->created_at->multiUpdateSelected())) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label for="x_created_at" class="<?= $Page->LeftColumnClass ?>">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="u_created_at" id="u_created_at" class="custom-control-input ew-multi-select" value="1"<?= $Page->created_at->multiUpdateSelected() ? " checked" : "" ?>>
                <label class="custom-control-label" for="u_created_at"><?= $Page->created_at->caption() ?></label>
            </div>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div <?= $Page->created_at->cellAttributes() ?>>
                <span id="el_kpi_marketing_created_at">
                <input type="<?= $Page->created_at->getInputTextType() ?>" data-table="kpi_marketing" data-field="x_created_at" data-format="111" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
                <?= $Page->created_at->getCustomMessage() ?>
                <div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
                <?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
                <script>
                loadjs.ready(["fkpi_marketingupdate", "datetimepicker"], function() {
                    ew.createDateTimePicker("fkpi_marketingupdate", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":111});
                });
                </script>
                <?php } ?>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page -->
<?php if (!$Page->IsModal) { ?>
    <div class="form-group row"><!-- buttons .form-group -->
        <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("UpdateBtn") ?></button>
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
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
