<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdummyDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdummydelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_confirmdummydelete = currentForm = new ew.Form("fnpd_confirmdummydelete", "delete");
    loadjs.done("fnpd_confirmdummydelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_confirmdummy) ew.vars.tables.npd_confirmdummy = <?= JsonEncode(GetClientVar("tables", "npd_confirmdummy")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_confirmdummydelete" id="fnpd_confirmdummydelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdummy">
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_confirmdummy_idnpd" class="npd_confirmdummy_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
        <th class="<?= $Page->tglterima->headerCellClass() ?>"><span id="elh_npd_confirmdummy_tglterima" class="npd_confirmdummy_tglterima"><?= $Page->tglterima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><span id="elh_npd_confirmdummy_tglsubmit" class="npd_confirmdummy_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <th class="<?= $Page->submitted_by->headerCellClass() ?>"><span id="elh_npd_confirmdummy_submitted_by" class="npd_confirmdummy_submitted_by"><?= $Page->submitted_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
        <th class="<?= $Page->checked1_by->headerCellClass() ?>"><span id="elh_npd_confirmdummy_checked1_by" class="npd_confirmdummy_checked1_by"><?= $Page->checked1_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
        <th class="<?= $Page->checked2_by->headerCellClass() ?>"><span id="elh_npd_confirmdummy_checked2_by" class="npd_confirmdummy_checked2_by"><?= $Page->checked2_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
        <th class="<?= $Page->approved_by->headerCellClass() ?>"><span id="elh_npd_confirmdummy_approved_by" class="npd_confirmdummy_approved_by"><?= $Page->approved_by->caption() ?></span></th>
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_idnpd" class="npd_confirmdummy_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
        <td <?= $Page->tglterima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_tglterima" class="npd_confirmdummy_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <td <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_tglsubmit" class="npd_confirmdummy_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <td <?= $Page->submitted_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_submitted_by" class="npd_confirmdummy_submitted_by">
<span<?= $Page->submitted_by->viewAttributes() ?>>
<?= $Page->submitted_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
        <td <?= $Page->checked1_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_checked1_by" class="npd_confirmdummy_checked1_by">
<span<?= $Page->checked1_by->viewAttributes() ?>>
<?= $Page->checked1_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
        <td <?= $Page->checked2_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_checked2_by" class="npd_confirmdummy_checked2_by">
<span<?= $Page->checked2_by->viewAttributes() ?>>
<?= $Page->checked2_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
        <td <?= $Page->approved_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_approved_by" class="npd_confirmdummy_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
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
