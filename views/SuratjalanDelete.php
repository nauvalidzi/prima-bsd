<?php

namespace PHPMaker2021\distributor;

// Page object
$SuratjalanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsuratjalandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsuratjalandelete = currentForm = new ew.Form("fsuratjalandelete", "delete");
    loadjs.done("fsuratjalandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.suratjalan) ew.vars.tables.suratjalan = <?= JsonEncode(GetClientVar("tables", "suratjalan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsuratjalandelete" id="fsuratjalandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="suratjalan">
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
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_suratjalan_kode" class="suratjalan_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglsurat->Visible) { // tglsurat ?>
        <th class="<?= $Page->tglsurat->headerCellClass() ?>"><span id="elh_suratjalan_tglsurat" class="suratjalan_tglsurat"><?= $Page->tglsurat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
        <th class="<?= $Page->tglkirim->headerCellClass() ?>"><span id="elh_suratjalan_tglkirim" class="suratjalan_tglkirim"><?= $Page->tglkirim->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_suratjalan_idcustomer" class="suratjalan_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idalamat_customer->Visible) { // idalamat_customer ?>
        <th class="<?= $Page->idalamat_customer->headerCellClass() ?>"><span id="elh_suratjalan_idalamat_customer" class="suratjalan_idalamat_customer"><?= $Page->idalamat_customer->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_suratjalan_kode" class="suratjalan_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglsurat->Visible) { // tglsurat ?>
        <td <?= $Page->tglsurat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suratjalan_tglsurat" class="suratjalan_tglsurat">
<span<?= $Page->tglsurat->viewAttributes() ?>>
<?= $Page->tglsurat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
        <td <?= $Page->tglkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suratjalan_tglkirim" class="suratjalan_tglkirim">
<span<?= $Page->tglkirim->viewAttributes() ?>>
<?= $Page->tglkirim->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suratjalan_idcustomer" class="suratjalan_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idalamat_customer->Visible) { // idalamat_customer ?>
        <td <?= $Page->idalamat_customer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_suratjalan_idalamat_customer" class="suratjalan_idalamat_customer">
<span<?= $Page->idalamat_customer->viewAttributes() ?>>
<?= $Page->idalamat_customer->getViewValue() ?></span>
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
