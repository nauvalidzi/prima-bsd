<?php

namespace PHPMaker2021\distributor;

// Page object
$LevelCustomerView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var flevel_customerview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    flevel_customerview = currentForm = new ew.Form("flevel_customerview", "view");
    loadjs.done("flevel_customerview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.level_customer) ew.vars.tables.level_customer = <?= JsonEncode(GetClientVar("tables", "level_customer")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="flevel_customerview" id="flevel_customerview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="level_customer">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->level->Visible) { // level ?>
    <tr id="r_level">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_level_customer_level"><?= $Page->level->caption() ?></span></td>
        <td data-name="level" <?= $Page->level->cellAttributes() ?>>
<span id="el_level_customer_level">
<span<?= $Page->level->viewAttributes() ?>>
<?= $Page->level->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->limit_kredit->Visible) { // limit_kredit ?>
    <tr id="r_limit_kredit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_level_customer_limit_kredit"><?= $Page->limit_kredit->caption() ?></span></td>
        <td data-name="limit_kredit" <?= $Page->limit_kredit->cellAttributes() ?>>
<span id="el_level_customer_limit_kredit">
<span<?= $Page->limit_kredit->viewAttributes() ?>>
<?= $Page->limit_kredit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->diskon->Visible) { // diskon ?>
    <tr id="r_diskon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_level_customer_diskon"><?= $Page->diskon->caption() ?></span></td>
        <td data-name="diskon" <?= $Page->diskon->cellAttributes() ?>>
<span id="el_level_customer_diskon">
<span<?= $Page->diskon->viewAttributes() ?>>
<?= $Page->diskon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
