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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_confirmdummy_id" class="npd_confirmdummy_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_confirmdummy_idnpd" class="npd_confirmdummy_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dummydepan->Visible) { // dummydepan ?>
        <th class="<?= $Page->dummydepan->headerCellClass() ?>"><span id="elh_npd_confirmdummy_dummydepan" class="npd_confirmdummy_dummydepan"><?= $Page->dummydepan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
        <th class="<?= $Page->dummybelakang->headerCellClass() ?>"><span id="elh_npd_confirmdummy_dummybelakang" class="npd_confirmdummy_dummybelakang"><?= $Page->dummybelakang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dummyatas->Visible) { // dummyatas ?>
        <th class="<?= $Page->dummyatas->headerCellClass() ?>"><span id="elh_npd_confirmdummy_dummyatas" class="npd_confirmdummy_dummyatas"><?= $Page->dummyatas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dummysamping->Visible) { // dummysamping ?>
        <th class="<?= $Page->dummysamping->headerCellClass() ?>"><span id="elh_npd_confirmdummy_dummysamping" class="npd_confirmdummy_dummysamping"><?= $Page->dummysamping->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ttd->Visible) { // ttd ?>
        <th class="<?= $Page->ttd->headerCellClass() ?>"><span id="elh_npd_confirmdummy_ttd" class="npd_confirmdummy_ttd"><?= $Page->ttd->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_id" class="npd_confirmdummy_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <td <?= $Page->idnpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_idnpd" class="npd_confirmdummy_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dummydepan->Visible) { // dummydepan ?>
        <td <?= $Page->dummydepan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummydepan" class="npd_confirmdummy_dummydepan">
<span<?= $Page->dummydepan->viewAttributes() ?>>
<?= $Page->dummydepan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dummybelakang->Visible) { // dummybelakang ?>
        <td <?= $Page->dummybelakang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummybelakang" class="npd_confirmdummy_dummybelakang">
<span<?= $Page->dummybelakang->viewAttributes() ?>>
<?= $Page->dummybelakang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dummyatas->Visible) { // dummyatas ?>
        <td <?= $Page->dummyatas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummyatas" class="npd_confirmdummy_dummyatas">
<span<?= $Page->dummyatas->viewAttributes() ?>>
<?= $Page->dummyatas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dummysamping->Visible) { // dummysamping ?>
        <td <?= $Page->dummysamping->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_dummysamping" class="npd_confirmdummy_dummysamping">
<span<?= $Page->dummysamping->viewAttributes() ?>>
<?= $Page->dummysamping->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ttd->Visible) { // ttd ?>
        <td <?= $Page->ttd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmdummy_ttd" class="npd_confirmdummy_ttd">
<span<?= $Page->ttd->viewAttributes() ?>>
<?= $Page->ttd->getViewValue() ?></span>
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
