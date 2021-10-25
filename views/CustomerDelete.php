<?php

namespace PHPMaker2021\distributor;

// Page object
$CustomerDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fcustomerdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fcustomerdelete = currentForm = new ew.Form("fcustomerdelete", "delete");
    loadjs.done("fcustomerdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.customer) ew.vars.tables.customer = <?= JsonEncode(GetClientVar("tables", "customer")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcustomerdelete" id="fcustomerdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="customer">
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
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_customer_kode" class="customer_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idtipecustomer->Visible) { // idtipecustomer ?>
        <th class="<?= $Page->idtipecustomer->headerCellClass() ?>"><span id="elh_customer_idtipecustomer" class="customer_idtipecustomer"><?= $Page->idtipecustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_customer_idpegawai" class="customer_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_customer_nama" class="customer_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kodenpd->Visible) { // kodenpd ?>
        <th class="<?= $Page->kodenpd->headerCellClass() ?>"><span id="elh_customer_kodenpd" class="customer_kodenpd"><?= $Page->kodenpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><span id="elh_customer_hp" class="customer_hp"><?= $Page->hp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->level_customer_id->Visible) { // level_customer_id ?>
        <th class="<?= $Page->level_customer_id->headerCellClass() ?>"><span id="elh_customer_level_customer_id" class="customer_level_customer_id"><?= $Page->level_customer_id->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_customer_kode" class="customer_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idtipecustomer->Visible) { // idtipecustomer ?>
        <td <?= $Page->idtipecustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customer_idtipecustomer" class="customer_idtipecustomer">
<span<?= $Page->idtipecustomer->viewAttributes() ?>>
<?= $Page->idtipecustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customer_idpegawai" class="customer_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customer_nama" class="customer_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kodenpd->Visible) { // kodenpd ?>
        <td <?= $Page->kodenpd->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customer_kodenpd" class="customer_kodenpd">
<span<?= $Page->kodenpd->viewAttributes() ?>>
<?= $Page->kodenpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <td <?= $Page->hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customer_hp" class="customer_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->level_customer_id->Visible) { // level_customer_id ?>
        <td <?= $Page->level_customer_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_customer_level_customer_id" class="customer_level_customer_id">
<span<?= $Page->level_customer_id->viewAttributes() ?>>
<?= $Page->level_customer_id->getViewValue() ?></span>
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
