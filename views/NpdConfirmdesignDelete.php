<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmdesignDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdesigndelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_confirmdesigndelete = currentForm = new ew.Form("fnpd_confirmdesigndelete", "delete");
    loadjs.done("fnpd_confirmdesigndelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_confirmdesign) ew.vars.tables.npd_confirmdesign = <?= JsonEncode(GetClientVar("tables", "npd_confirmdesign")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_confirmdesigndelete" id="fnpd_confirmdesigndelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmdesign">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_confirmdesign_id" class="npd_confirmdesign_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_confirmdesign_idnpd" class="npd_confirmdesign_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
        <th class="<?= $Page->tglterima->headerCellClass() ?>"><span id="elh_npd_confirmdesign_tglterima" class="npd_confirmdesign_tglterima"><?= $Page->tglterima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><span id="elh_npd_confirmdesign_tglsubmit" class="npd_confirmdesign_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desaindepan->Visible) { // desaindepan ?>
        <th class="<?= $Page->desaindepan->headerCellClass() ?>"><span id="elh_npd_confirmdesign_desaindepan" class="npd_confirmdesign_desaindepan"><?= $Page->desaindepan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desainbelakang->Visible) { // desainbelakang ?>
        <th class="<?= $Page->desainbelakang->headerCellClass() ?>"><span id="elh_npd_confirmdesign_desainbelakang" class="npd_confirmdesign_desainbelakang"><?= $Page->desainbelakang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglprimer->Visible) { // tglprimer ?>
        <th class="<?= $Page->tglprimer->headerCellClass() ?>"><span id="elh_npd_confirmdesign_tglprimer" class="npd_confirmdesign_tglprimer"><?= $Page->tglprimer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
        <th class="<?= $Page->desainsekunder->headerCellClass() ?>"><span id="elh_npd_confirmdesign_desainsekunder" class="npd_confirmdesign_desainsekunder"><?= $Page->desainsekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->catatansekunder->Visible) { // catatansekunder ?>
        <th class="<?= $Page->catatansekunder->headerCellClass() ?>"><span id="elh_npd_confirmdesign_catatansekunder" class="npd_confirmdesign_catatansekunder"><?= $Page->catatansekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <th class="<?= $Page->submitted_by->headerCellClass() ?>"><span id="elh_npd_confirmdesign_submitted_by" class="npd_confirmdesign_submitted_by"><?= $Page->submitted_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
        <th class="<?= $Page->checked1_by->headerCellClass() ?>"><span id="elh_npd_confirmdesign_checked1_by" class="npd_confirmdesign_checked1_by"><?= $Page->checked1_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
        <th class="<?= $Page->checked2_by->headerCellClass() ?>"><span id="elh_npd_confirmdesign_checked2_by" class="npd_confirmdesign_checked2_by"><?= $Page->checked2_by->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_id" class="npd_confirmdesign_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_idnpd" class="npd_confirmdesign_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglterima->Visible) { // tglterima ?>
        <td <?= $Page->tglterima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_tglterima" class="npd_confirmdesign_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <td <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_tglsubmit" class="npd_confirmdesign_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desaindepan->Visible) { // desaindepan ?>
        <td <?= $Page->desaindepan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_desaindepan" class="npd_confirmdesign_desaindepan">
<span<?= $Page->desaindepan->viewAttributes() ?>>
<?= $Page->desaindepan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desainbelakang->Visible) { // desainbelakang ?>
        <td <?= $Page->desainbelakang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_desainbelakang" class="npd_confirmdesign_desainbelakang">
<span<?= $Page->desainbelakang->viewAttributes() ?>>
<?= $Page->desainbelakang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglprimer->Visible) { // tglprimer ?>
        <td <?= $Page->tglprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_tglprimer" class="npd_confirmdesign_tglprimer">
<span<?= $Page->tglprimer->viewAttributes() ?>>
<?= $Page->tglprimer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
        <td <?= $Page->desainsekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_desainsekunder" class="npd_confirmdesign_desainsekunder">
<span<?= $Page->desainsekunder->viewAttributes() ?>>
<?= $Page->desainsekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->catatansekunder->Visible) { // catatansekunder ?>
        <td <?= $Page->catatansekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_catatansekunder" class="npd_confirmdesign_catatansekunder">
<span<?= $Page->catatansekunder->viewAttributes() ?>>
<?= $Page->catatansekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <td <?= $Page->submitted_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_submitted_by" class="npd_confirmdesign_submitted_by">
<span<?= $Page->submitted_by->viewAttributes() ?>>
<?= $Page->submitted_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->checked1_by->Visible) { // checked1_by ?>
        <td <?= $Page->checked1_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_checked1_by" class="npd_confirmdesign_checked1_by">
<span<?= $Page->checked1_by->viewAttributes() ?>>
<?= $Page->checked1_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->checked2_by->Visible) { // checked2_by ?>
        <td <?= $Page->checked2_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdesign_checked2_by" class="npd_confirmdesign_checked2_by">
<span<?= $Page->checked2_by->viewAttributes() ?>>
<?= $Page->checked2_by->getViewValue() ?></span>
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
