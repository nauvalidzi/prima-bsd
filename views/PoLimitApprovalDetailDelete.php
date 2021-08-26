<?php

namespace PHPMaker2021\distributor;

// Page object
$PoLimitApprovalDetailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpo_limit_approval_detaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpo_limit_approval_detaildelete = currentForm = new ew.Form("fpo_limit_approval_detaildelete", "delete");
    loadjs.done("fpo_limit_approval_detaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.po_limit_approval_detail) ew.vars.tables.po_limit_approval_detail = <?= JsonEncode(GetClientVar("tables", "po_limit_approval_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpo_limit_approval_detaildelete" id="fpo_limit_approval_detaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="po_limit_approval_detail">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_po_limit_approval_detail_id" class="po_limit_approval_detail_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idapproval->Visible) { // idapproval ?>
        <th class="<?= $Page->idapproval->headerCellClass() ?>"><span id="elh_po_limit_approval_detail_idapproval" class="po_limit_approval_detail_idapproval"><?= $Page->idapproval->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><span id="elh_po_limit_approval_detail_idorder" class="po_limit_approval_detail_idorder"><?= $Page->idorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kredit_terpakai->Visible) { // kredit_terpakai ?>
        <th class="<?= $Page->kredit_terpakai->headerCellClass() ?>"><span id="elh_po_limit_approval_detail_kredit_terpakai" class="po_limit_approval_detail_kredit_terpakai"><?= $Page->kredit_terpakai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_po_limit_approval_detail_created_at" class="po_limit_approval_detail_created_at"><?= $Page->created_at->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_detail_id" class="po_limit_approval_detail_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idapproval->Visible) { // idapproval ?>
        <td <?= $Page->idapproval->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_detail_idapproval" class="po_limit_approval_detail_idapproval">
<span<?= $Page->idapproval->viewAttributes() ?>>
<?= $Page->idapproval->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
        <td <?= $Page->idorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_detail_idorder" class="po_limit_approval_detail_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kredit_terpakai->Visible) { // kredit_terpakai ?>
        <td <?= $Page->kredit_terpakai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_detail_kredit_terpakai" class="po_limit_approval_detail_kredit_terpakai">
<span<?= $Page->kredit_terpakai->viewAttributes() ?>>
<?= $Page->kredit_terpakai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_po_limit_approval_detail_created_at" class="po_limit_approval_detail_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
