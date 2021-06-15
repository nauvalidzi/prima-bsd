<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdConfirmDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_confirmdelete = currentForm = new ew.Form("fnpd_confirmdelete", "delete");
    loadjs.done("fnpd_confirmdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_confirm) ew.vars.tables.npd_confirm = <?= JsonEncode(GetClientVar("tables", "npd_confirm")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_confirmdelete" id="fnpd_confirmdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirm">
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
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_confirm_idnpd" class="npd_confirm_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
        <th class="<?= $Page->tglkonfirmasi->headerCellClass() ?>"><span id="elh_npd_confirm_tglkonfirmasi" class="npd_confirm_tglkonfirmasi"><?= $Page->tglkonfirmasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><span id="elh_npd_confirm_idnpd_sample" class="npd_confirm_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></span></th>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
        <th class="<?= $Page->namapemesan->headerCellClass() ?>"><span id="elh_npd_confirm_namapemesan" class="npd_confirm_namapemesan"><?= $Page->namapemesan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
        <th class="<?= $Page->personincharge->headerCellClass() ?>"><span id="elh_npd_confirm_personincharge" class="npd_confirm_personincharge"><?= $Page->personincharge->caption() ?></span></th>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
        <th class="<?= $Page->notelp->headerCellClass() ?>"><span id="elh_npd_confirm_notelp" class="npd_confirm_notelp"><?= $Page->notelp->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_confirm_idnpd" class="npd_confirm_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
        <td <?= $Page->tglkonfirmasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirm_tglkonfirmasi" class="npd_confirm_tglkonfirmasi">
<span<?= $Page->tglkonfirmasi->viewAttributes() ?>>
<?= $Page->tglkonfirmasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <td <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirm_idnpd_sample" class="npd_confirm_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
        <td <?= $Page->namapemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirm_namapemesan" class="npd_confirm_namapemesan">
<span<?= $Page->namapemesan->viewAttributes() ?>>
<?= $Page->namapemesan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
        <td <?= $Page->personincharge->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirm_personincharge" class="npd_confirm_personincharge">
<span<?= $Page->personincharge->viewAttributes() ?>>
<?= $Page->personincharge->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
        <td <?= $Page->notelp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirm_notelp" class="npd_confirm_notelp">
<span<?= $Page->notelp->viewAttributes() ?>>
<?= $Page->notelp->getViewValue() ?></span>
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
