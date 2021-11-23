<?php

namespace PHPMaker2021\distributor;

// Page object
$BrandCustomerSearch = &$Page;
?>
<script>
var currentForm, currentPageID;
var fbrand_customersearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    <?php if ($Page->IsModal) { ?>
    fbrand_customersearch = currentAdvancedSearchForm = new ew.Form("fbrand_customersearch", "search");
    <?php } else { ?>
    fbrand_customersearch = currentForm = new ew.Form("fbrand_customersearch", "search");
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "brand_customer")) ?>,
        fields = currentTable.fields;
    fbrand_customersearch.addFields([
        ["idbrand", [], fields.idbrand.isInvalid],
        ["idcustomer", [], fields.idcustomer.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        fbrand_customersearch.setInvalid();
    });

    // Validate form
    fbrand_customersearch.validate = function () {
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
    fbrand_customersearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbrand_customersearch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fbrand_customersearch.lists.idbrand = <?= $Page->idbrand->toClientList($Page) ?>;
    fbrand_customersearch.lists.idcustomer = <?= $Page->idcustomer->toClientList($Page) ?>;
    loadjs.done("fbrand_customersearch");
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
<form name="fbrand_customersearch" id="fbrand_customersearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="brand_customer">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <div id="r_idbrand" class="form-group row">
        <label for="x_idbrand" class="<?= $Page->LeftColumnClass ?>"><span id="elh_brand_customer_idbrand"><?= $Page->idbrand->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idbrand" id="z_idbrand" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idbrand->cellAttributes() ?>>
            <span id="el_brand_customer_idbrand" class="ew-search-field ew-search-field-single">
    <select
        id="x_idbrand"
        name="x_idbrand"
        class="form-control ew-select<?= $Page->idbrand->isInvalidClass() ?>"
        data-select2-id="brand_customer_x_idbrand"
        data-table="brand_customer"
        data-field="x_idbrand"
        data-value-separator="<?= $Page->idbrand->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idbrand->getPlaceHolder()) ?>"
        <?= $Page->idbrand->editAttributes() ?>>
        <?= $Page->idbrand->selectOptionListHtml("x_idbrand") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idbrand->getErrorMessage(false) ?></div>
<?= $Page->idbrand->Lookup->getParamTag($Page, "p_x_idbrand") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='brand_customer_x_idbrand']"),
        options = { name: "x_idbrand", selectId: "brand_customer_x_idbrand", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.brand_customer.fields.idbrand.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
        </div></div>
    </div>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <div id="r_idcustomer" class="form-group row">
        <label for="x_idcustomer" class="<?= $Page->LeftColumnClass ?>"><span id="elh_brand_customer_idcustomer"><?= $Page->idcustomer->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_idcustomer" id="z_idcustomer" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idcustomer->cellAttributes() ?>>
            <span id="el_brand_customer_idcustomer" class="ew-search-field ew-search-field-single">
    <select
        id="x_idcustomer"
        name="x_idcustomer"
        class="form-control ew-select<?= $Page->idcustomer->isInvalidClass() ?>"
        data-select2-id="brand_customer_x_idcustomer"
        data-table="brand_customer"
        data-field="x_idcustomer"
        data-value-separator="<?= $Page->idcustomer->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->idcustomer->getPlaceHolder()) ?>"
        <?= $Page->idcustomer->editAttributes() ?>>
        <?= $Page->idcustomer->selectOptionListHtml("x_idcustomer") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->idcustomer->getErrorMessage(false) ?></div>
<?= $Page->idcustomer->Lookup->getParamTag($Page, "p_x_idcustomer") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='brand_customer_x_idcustomer']"),
        options = { name: "x_idcustomer", selectId: "brand_customer_x_idcustomer", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.brand_customer.fields.idcustomer.selectOptions);
    ew.createSelect(options);
});
</script>
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
    ew.addEventHandlers("brand_customer");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
