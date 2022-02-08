<?php

namespace PHPMaker2021\production2;

// Page object
$IjinbpomDetailDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fijinbpom_detaildelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fijinbpom_detaildelete = currentForm = new ew.Form("fijinbpom_detaildelete", "delete");
    loadjs.done("fijinbpom_detaildelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.ijinbpom_detail) ew.vars.tables.ijinbpom_detail = <?= JsonEncode(GetClientVar("tables", "ijinbpom_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fijinbpom_detaildelete" id="fijinbpom_detaildelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinbpom_detail">
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
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_ijinbpom_detail_idnpd" class="ijinbpom_detail_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_ijinbpom_detail_nama" class="ijinbpom_detail_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->namaalt->Visible) { // namaalt ?>
        <th class="<?= $Page->namaalt->headerCellClass() ?>"><span id="elh_ijinbpom_detail_namaalt" class="ijinbpom_detail_namaalt"><?= $Page->namaalt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <th class="<?= $Page->idproduct_acuan->headerCellClass() ?>"><span id="elh_ijinbpom_detail_idproduct_acuan" class="ijinbpom_detail_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <th class="<?= $Page->ukuran->headerCellClass() ?>"><span id="elh_ijinbpom_detail_ukuran" class="ijinbpom_detail_ukuran"><?= $Page->ukuran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kodesample->Visible) { // kodesample ?>
        <th class="<?= $Page->kodesample->headerCellClass() ?>"><span id="elh_ijinbpom_detail_kodesample" class="ijinbpom_detail_kodesample"><?= $Page->kodesample->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_ijinbpom_detail_idnpd" class="ijinbpom_detail_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinbpom_detail_nama" class="ijinbpom_detail_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->namaalt->Visible) { // namaalt ?>
        <td <?= $Page->namaalt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinbpom_detail_namaalt" class="ijinbpom_detail_namaalt">
<span<?= $Page->namaalt->viewAttributes() ?>>
<?= $Page->namaalt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <td <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinbpom_detail_idproduct_acuan" class="ijinbpom_detail_idproduct_acuan">
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <td <?= $Page->ukuran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinbpom_detail_ukuran" class="ijinbpom_detail_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kodesample->Visible) { // kodesample ?>
        <td <?= $Page->kodesample->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_ijinbpom_detail_kodesample" class="ijinbpom_detail_kodesample">
<span<?= $Page->kodesample->viewAttributes() ?>>
<?= $Page->kodesample->getViewValue() ?></span>
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
