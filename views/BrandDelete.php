<?php

namespace PHPMaker2021\production2;

// Page object
$BrandDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fbranddelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fbranddelete = currentForm = new ew.Form("fbranddelete", "delete");
    loadjs.done("fbranddelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.brand) ew.vars.tables.brand = <?= JsonEncode(GetClientVar("tables", "brand")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fbranddelete" id="fbranddelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="brand">
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
<?php if ($Page->kode->Visible) { // kode ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_brand_kode" class="brand_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <th class="<?= $Page->title->headerCellClass() ?>"><span id="elh_brand_title" class="brand_title"><?= $Page->title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->titipmerk->Visible) { // titipmerk ?>
        <th class="<?= $Page->titipmerk->headerCellClass() ?>"><span id="elh_brand_titipmerk" class="brand_titipmerk"><?= $Page->titipmerk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ijinhaki->Visible) { // ijinhaki ?>
        <th class="<?= $Page->ijinhaki->headerCellClass() ?>"><span id="elh_brand_ijinhaki" class="brand_ijinhaki"><?= $Page->ijinhaki->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
        <th class="<?= $Page->ijinbpom->headerCellClass() ?>"><span id="elh_brand_ijinbpom" class="brand_ijinbpom"><?= $Page->ijinbpom->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <th class="<?= $Page->aktif->headerCellClass() ?>"><span id="elh_brand_aktif" class="brand_aktif"><?= $Page->aktif->caption() ?></span></th>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <td <?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_kode" class="brand_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <td <?= $Page->title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_title" class="brand_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->titipmerk->Visible) { // titipmerk ?>
        <td <?= $Page->titipmerk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_titipmerk" class="brand_titipmerk">
<span<?= $Page->titipmerk->viewAttributes() ?>>
<?= $Page->titipmerk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ijinhaki->Visible) { // ijinhaki ?>
        <td <?= $Page->ijinhaki->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_ijinhaki" class="brand_ijinhaki">
<span<?= $Page->ijinhaki->viewAttributes() ?>>
<?= $Page->ijinhaki->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
        <td <?= $Page->ijinbpom->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_ijinbpom" class="brand_ijinbpom">
<span<?= $Page->ijinbpom->viewAttributes() ?>>
<?= $Page->ijinbpom->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <td <?= $Page->aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_brand_aktif" class="brand_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
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
