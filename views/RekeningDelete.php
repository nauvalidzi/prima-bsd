<?php

namespace PHPMaker2021\distributor;

// Page object
$RekeningDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var frekeningdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    frekeningdelete = currentForm = new ew.Form("frekeningdelete", "delete");
    loadjs.done("frekeningdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.rekening) ew.vars.tables.rekening = <?= JsonEncode(GetClientVar("tables", "rekening")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="frekeningdelete" id="frekeningdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="rekening">
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
<?php if ($Page->nama_bank->Visible) { // nama_bank ?>
        <th class="<?= $Page->nama_bank->headerCellClass() ?>"><span id="elh_rekening_nama_bank" class="rekening_nama_bank"><?= $Page->nama_bank->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_account->Visible) { // nama_account ?>
        <th class="<?= $Page->nama_account->headerCellClass() ?>"><span id="elh_rekening_nama_account" class="rekening_nama_account"><?= $Page->nama_account->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_rek->Visible) { // no_rek ?>
        <th class="<?= $Page->no_rek->headerCellClass() ?>"><span id="elh_rekening_no_rek" class="rekening_no_rek"><?= $Page->no_rek->caption() ?></span></th>
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
<?php if ($Page->nama_bank->Visible) { // nama_bank ?>
        <td <?= $Page->nama_bank->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_rekening_nama_bank" class="rekening_nama_bank">
<span<?= $Page->nama_bank->viewAttributes() ?>>
<?= $Page->nama_bank->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_account->Visible) { // nama_account ?>
        <td <?= $Page->nama_account->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_rekening_nama_account" class="rekening_nama_account">
<span<?= $Page->nama_account->viewAttributes() ?>>
<?= $Page->nama_account->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_rek->Visible) { // no_rek ?>
        <td <?= $Page->no_rek->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_rekening_no_rek" class="rekening_no_rek">
<span<?= $Page->no_rek->viewAttributes() ?>>
<?= $Page->no_rek->getViewValue() ?></span>
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
