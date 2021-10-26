<?php

namespace PHPMaker2021\distributor;

// Page object
$LevelCustomerDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var flevel_customerdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    flevel_customerdelete = currentForm = new ew.Form("flevel_customerdelete", "delete");
    loadjs.done("flevel_customerdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.level_customer) ew.vars.tables.level_customer = <?= JsonEncode(GetClientVar("tables", "level_customer")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="flevel_customerdelete" id="flevel_customerdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="level_customer">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->level->Visible) { // level ?>
        <th class="<?= $Page->level->headerCellClass() ?>"><span id="elh_level_customer_level" class="level_customer_level"><?= $Page->level->caption() ?></span></th>
<?php } ?>
<?php if ($Page->limit_kredit_value->Visible) { // limit_kredit_value ?>
        <th class="<?= $Page->limit_kredit_value->headerCellClass() ?>"><span id="elh_level_customer_limit_kredit_value" class="level_customer_limit_kredit_value"><?= $Page->limit_kredit_value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->diskon_value->Visible) { // diskon_value ?>
        <th class="<?= $Page->diskon_value->headerCellClass() ?>"><span id="elh_level_customer_diskon_value" class="level_customer_diskon_value"><?= $Page->diskon_value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_level_customer_updated_at" class="level_customer_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->level->Visible) { // level ?>
        <td <?= $Page->level->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_level_customer_level" class="level_customer_level">
<span<?= $Page->level->viewAttributes() ?>>
<?= $Page->level->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->limit_kredit_value->Visible) { // limit_kredit_value ?>
        <td <?= $Page->limit_kredit_value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_level_customer_limit_kredit_value" class="level_customer_limit_kredit_value">
<span<?= $Page->limit_kredit_value->viewAttributes() ?>>
<?= $Page->limit_kredit_value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->diskon_value->Visible) { // diskon_value ?>
        <td <?= $Page->diskon_value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_level_customer_diskon_value" class="level_customer_diskon_value">
<span<?= $Page->diskon_value->viewAttributes() ?>>
<?= $Page->diskon_value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_level_customer_updated_at" class="level_customer_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
