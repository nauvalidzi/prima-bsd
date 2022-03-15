<?php

namespace PHPMaker2021\production2;

// Page object
$IjinhakiDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinhakidelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fijinhakidelete = currentForm = new ew.Form("fijinhakidelete", "delete");
    loadjs.done("fijinhakidelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.ijinhaki) ew.vars.tables.ijinhaki = <?= JsonEncode(GetClientVar("tables", "ijinhaki")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fijinhakidelete" id="fijinhakidelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinhaki">
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
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_ijinhaki_idnpd" class="ijinhaki_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
        <th class="<?= $Page->tglterima->headerCellClass() ?>"><span id="elh_ijinhaki_tglterima" class="ijinhaki_tglterima"><?= $Page->tglterima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><span id="elh_ijinhaki_tglsubmit" class="ijinhaki_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
        <th class="<?= $Page->nama_brand->headerCellClass() ?>"><span id="elh_ijinhaki_nama_brand" class="ijinhaki_nama_brand"><?= $Page->nama_brand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->label_brand->Visible) { // label_brand ?>
        <th class="<?= $Page->label_brand->headerCellClass() ?>"><span id="elh_ijinhaki_label_brand" class="ijinhaki_label_brand"><?= $Page->label_brand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <th class="<?= $Page->submitted_by->headerCellClass() ?>"><span id="elh_ijinhaki_submitted_by" class="ijinhaki_submitted_by"><?= $Page->submitted_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_ijinhaki_status" class="ijinhaki_status"><?= $Page->status->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_ijinhaki_idnpd" class="ijinhaki_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
        <td <?= $Page->tglterima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinhaki_tglterima" class="ijinhaki_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <td <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinhaki_tglsubmit" class="ijinhaki_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_brand->Visible) { // nama_brand ?>
        <td <?= $Page->nama_brand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinhaki_nama_brand" class="ijinhaki_nama_brand">
<span<?= $Page->nama_brand->viewAttributes() ?>>
<?= $Page->nama_brand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->label_brand->Visible) { // label_brand ?>
        <td <?= $Page->label_brand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinhaki_label_brand" class="ijinhaki_label_brand">
<span<?= $Page->label_brand->viewAttributes() ?>>
<?= GetFileViewTag($Page->label_brand, $Page->label_brand->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <td <?= $Page->submitted_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinhaki_submitted_by" class="ijinhaki_submitted_by">
<span<?= $Page->submitted_by->viewAttributes() ?>>
<?= $Page->submitted_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinhaki_status" class="ijinhaki_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
