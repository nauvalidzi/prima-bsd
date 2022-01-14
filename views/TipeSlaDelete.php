<?php

namespace PHPMaker2021\distributor;

// Page object
$TipeSlaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftipe_sladelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ftipe_sladelete = currentForm = new ew.Form("ftipe_sladelete", "delete");
    loadjs.done("ftipe_sladelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.tipe_sla) ew.vars.tables.tipe_sla = <?= JsonEncode(GetClientVar("tables", "tipe_sla")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftipe_sladelete" id="ftipe_sladelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tipe_sla">
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
<?php if ($Page->kriteria->Visible) { // kriteria ?>
        <th class="<?= $Page->kriteria->headerCellClass() ?>"><span id="elh_tipe_sla_kriteria" class="tipe_sla_kriteria"><?= $Page->kriteria->caption() ?></span></th>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
        <th class="<?= $Page->target->headerCellClass() ?>"><span id="elh_tipe_sla_target" class="tipe_sla_target"><?= $Page->target->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_tipe_sla_keterangan" class="tipe_sla_keterangan"><?= $Page->keterangan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_tipe_sla_updated_at" class="tipe_sla_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<?php if ($Page->kriteria->Visible) { // kriteria ?>
        <td <?= $Page->kriteria->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tipe_sla_kriteria" class="tipe_sla_kriteria">
<span<?= $Page->kriteria->viewAttributes() ?>>
<?= $Page->kriteria->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->target->Visible) { // target ?>
        <td <?= $Page->target->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tipe_sla_target" class="tipe_sla_target">
<span<?= $Page->target->viewAttributes() ?>>
<?= $Page->target->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tipe_sla_keterangan" class="tipe_sla_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tipe_sla_updated_at" class="tipe_sla_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
