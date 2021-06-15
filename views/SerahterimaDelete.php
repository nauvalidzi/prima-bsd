<?php

namespace PHPMaker2021\distributor;

// Page object
$SerahterimaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fserahterimadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fserahterimadelete = currentForm = new ew.Form("fserahterimadelete", "delete");
    loadjs.done("fserahterimadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.serahterima) ew.vars.tables.serahterima = <?= JsonEncode(GetClientVar("tables", "serahterima")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fserahterimadelete" id="fserahterimadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="serahterima">
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_serahterima_idpegawai" class="serahterima_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_serahterima_idcustomer" class="serahterima_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggalrequest->Visible) { // tanggalrequest ?>
        <th class="<?= $Page->tanggalrequest->headerCellClass() ?>"><span id="elh_serahterima_tanggalrequest" class="serahterima_tanggalrequest"><?= $Page->tanggalrequest->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggalst->Visible) { // tanggalst ?>
        <th class="<?= $Page->tanggalst->headerCellClass() ?>"><span id="elh_serahterima_tanggalst" class="serahterima_tanggalst"><?= $Page->tanggalst->caption() ?></span></th>
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_serahterima_idpegawai" class="serahterima_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_serahterima_idcustomer" class="serahterima_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggalrequest->Visible) { // tanggalrequest ?>
        <td <?= $Page->tanggalrequest->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_serahterima_tanggalrequest" class="serahterima_tanggalrequest">
<span<?= $Page->tanggalrequest->viewAttributes() ?>>
<?= $Page->tanggalrequest->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggalst->Visible) { // tanggalst ?>
        <td <?= $Page->tanggalst->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_serahterima_tanggalst" class="serahterima_tanggalst">
<span<?= $Page->tanggalst->viewAttributes() ?>>
<?= $Page->tanggalst->getViewValue() ?></span>
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
