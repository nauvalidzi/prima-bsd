<?php

namespace PHPMaker2021\production2;

// Page object
$NpdSerahterimaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_serahterimadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_serahterimadelete = currentForm = new ew.Form("fnpd_serahterimadelete", "delete");
    loadjs.done("fnpd_serahterimadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_serahterima) ew.vars.tables.npd_serahterima = <?= JsonEncode(GetClientVar("tables", "npd_serahterima")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_serahterimadelete" id="fnpd_serahterimadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_serahterima">
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
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_npd_serahterima_idcustomer" class="npd_serahterima_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_request->Visible) { // tgl_request ?>
        <th class="<?= $Page->tgl_request->headerCellClass() ?>"><span id="elh_npd_serahterima_tgl_request" class="npd_serahterima_tgl_request"><?= $Page->tgl_request->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_serahterima->Visible) { // tgl_serahterima ?>
        <th class="<?= $Page->tgl_serahterima->headerCellClass() ?>"><span id="elh_npd_serahterima_tgl_serahterima" class="npd_serahterima_tgl_serahterima"><?= $Page->tgl_serahterima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <th class="<?= $Page->submitted_by->headerCellClass() ?>"><span id="elh_npd_serahterima_submitted_by" class="npd_serahterima_submitted_by"><?= $Page->submitted_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
        <th class="<?= $Page->receipt_by->headerCellClass() ?>"><span id="elh_npd_serahterima_receipt_by" class="npd_serahterima_receipt_by"><?= $Page->receipt_by->caption() ?></span></th>
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
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_idcustomer" class="npd_serahterima_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_request->Visible) { // tgl_request ?>
        <td <?= $Page->tgl_request->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_tgl_request" class="npd_serahterima_tgl_request">
<span<?= $Page->tgl_request->viewAttributes() ?>>
<?= $Page->tgl_request->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_serahterima->Visible) { // tgl_serahterima ?>
        <td <?= $Page->tgl_serahterima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_tgl_serahterima" class="npd_serahterima_tgl_serahterima">
<span<?= $Page->tgl_serahterima->viewAttributes() ?>>
<?= $Page->tgl_serahterima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->submitted_by->Visible) { // submitted_by ?>
        <td <?= $Page->submitted_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_submitted_by" class="npd_serahterima_submitted_by">
<span<?= $Page->submitted_by->viewAttributes() ?>>
<?= $Page->submitted_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->receipt_by->Visible) { // receipt_by ?>
        <td <?= $Page->receipt_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_receipt_by" class="npd_serahterima_receipt_by">
<span<?= $Page->receipt_by->viewAttributes() ?>>
<?= $Page->receipt_by->getViewValue() ?></span>
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
