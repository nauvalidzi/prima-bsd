<?php

namespace PHPMaker2021\distributor;

// Page object
$PegawaiDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpegawaidelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpegawaidelete = currentForm = new ew.Form("fpegawaidelete", "delete");
    loadjs.done("fpegawaidelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pegawai) ew.vars.tables.pegawai = <?= JsonEncode(GetClientVar("tables", "pegawai")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpegawaidelete" id="fpegawaidelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pegawai">
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
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_pegawai_kode" class="pegawai_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pegawai_nama" class="pegawai_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->wa->Visible) { // wa ?>
        <th class="<?= $Page->wa->headerCellClass() ?>"><span id="elh_pegawai_wa" class="pegawai_wa"><?= $Page->wa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><span id="elh_pegawai_hp" class="pegawai_hp"><?= $Page->hp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rekbank->Visible) { // rekbank ?>
        <th class="<?= $Page->rekbank->headerCellClass() ?>"><span id="elh_pegawai_rekbank" class="pegawai_rekbank"><?= $Page->rekbank->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_pegawai_kode" class="pegawai_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pegawai_nama" class="pegawai_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->wa->Visible) { // wa ?>
        <td <?= $Page->wa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pegawai_wa" class="pegawai_wa">
<span<?= $Page->wa->viewAttributes() ?>>
<?= $Page->wa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <td <?= $Page->hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pegawai_hp" class="pegawai_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rekbank->Visible) { // rekbank ?>
        <td <?= $Page->rekbank->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pegawai_rekbank" class="pegawai_rekbank">
<span<?= $Page->rekbank->viewAttributes() ?>>
<?= $Page->rekbank->getViewValue() ?></span>
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
