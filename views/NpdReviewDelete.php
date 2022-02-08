<?php

namespace PHPMaker2021\production2;

// Page object
$NpdReviewDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_reviewdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_reviewdelete = currentForm = new ew.Form("fnpd_reviewdelete", "delete");
    loadjs.done("fnpd_reviewdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_review) ew.vars.tables.npd_review = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_reviewdelete" id="fnpd_reviewdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_review">
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
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_review_idnpd" class="npd_review_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><span id="elh_npd_review_idnpd_sample" class="npd_review_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_review->Visible) { // tanggal_review ?>
        <th class="<?= $Page->tanggal_review->headerCellClass() ?>"><span id="elh_npd_review_tanggal_review" class="npd_review_tanggal_review"><?= $Page->tanggal_review->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <th class="<?= $Page->tanggal_submit->headerCellClass() ?>"><span id="elh_npd_review_tanggal_submit" class="npd_review_tanggal_submit"><?= $Page->tanggal_submit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <th class="<?= $Page->ukuran->headerCellClass() ?>"><span id="elh_npd_review_ukuran" class="npd_review_ukuran"><?= $Page->ukuran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_review_status" class="npd_review_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->review_by->Visible) { // review_by ?>
        <th class="<?= $Page->review_by->headerCellClass() ?>"><span id="elh_npd_review_review_by" class="npd_review_review_by"><?= $Page->review_by->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_review_idnpd" class="npd_review_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <td <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_idnpd_sample" class="npd_review_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_review->Visible) { // tanggal_review ?>
        <td <?= $Page->tanggal_review->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_tanggal_review" class="npd_review_tanggal_review">
<span<?= $Page->tanggal_review->viewAttributes() ?>>
<?= $Page->tanggal_review->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <td <?= $Page->tanggal_submit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_tanggal_submit" class="npd_review_tanggal_submit">
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <td <?= $Page->ukuran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_ukuran" class="npd_review_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_status" class="npd_review_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->review_by->Visible) { // review_by ?>
        <td <?= $Page->review_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_review_review_by" class="npd_review_review_by">
<span<?= $Page->review_by->viewAttributes() ?>>
<?= $Page->review_by->getViewValue() ?></span>
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
