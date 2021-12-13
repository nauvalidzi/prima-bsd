<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdStatusDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_statusdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_statusdelete = currentForm = new ew.Form("fnpd_statusdelete", "delete");
    loadjs.done("fnpd_statusdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_status) ew.vars.tables.npd_status = <?= JsonEncode(GetClientVar("tables", "npd_status")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_statusdelete" id="fnpd_statusdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_status">
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
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><span id="elh_npd_status_idnpd" class="npd_status_idnpd"><?= $Page->idnpd->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_npd_status_idpegawai" class="npd_status_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_status_status" class="npd_status_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->targetmulai->Visible) { // targetmulai ?>
        <th class="<?= $Page->targetmulai->headerCellClass() ?>"><span id="elh_npd_status_targetmulai" class="npd_status_targetmulai"><?= $Page->targetmulai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglmulai->Visible) { // tglmulai ?>
        <th class="<?= $Page->tglmulai->headerCellClass() ?>"><span id="elh_npd_status_tglmulai" class="npd_status_tglmulai"><?= $Page->tglmulai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->targetselesai->Visible) { // targetselesai ?>
        <th class="<?= $Page->targetselesai->headerCellClass() ?>"><span id="elh_npd_status_targetselesai" class="npd_status_targetselesai"><?= $Page->targetselesai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglselesai->Visible) { // tglselesai ?>
        <th class="<?= $Page->tglselesai->headerCellClass() ?>"><span id="elh_npd_status_tglselesai" class="npd_status_tglselesai"><?= $Page->tglselesai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_npd_status_keterangan" class="npd_status_keterangan"><?= $Page->keterangan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
        <th class="<?= $Page->lampiran->headerCellClass() ?>"><span id="elh_npd_status_lampiran" class="npd_status_lampiran"><?= $Page->lampiran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_npd_status_created_at" class="npd_status_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <th class="<?= $Page->created_by->headerCellClass() ?>"><span id="elh_npd_status_created_by" class="npd_status_created_by"><?= $Page->created_by->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_status_idnpd" class="npd_status_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_idpegawai" class="npd_status_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_status" class="npd_status_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->targetmulai->Visible) { // targetmulai ?>
        <td <?= $Page->targetmulai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_targetmulai" class="npd_status_targetmulai">
<span<?= $Page->targetmulai->viewAttributes() ?>>
<?= $Page->targetmulai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglmulai->Visible) { // tglmulai ?>
        <td <?= $Page->tglmulai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_tglmulai" class="npd_status_tglmulai">
<span<?= $Page->tglmulai->viewAttributes() ?>>
<?= $Page->tglmulai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->targetselesai->Visible) { // targetselesai ?>
        <td <?= $Page->targetselesai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_targetselesai" class="npd_status_targetselesai">
<span<?= $Page->targetselesai->viewAttributes() ?>>
<?= $Page->targetselesai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglselesai->Visible) { // tglselesai ?>
        <td <?= $Page->tglselesai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_tglselesai" class="npd_status_tglselesai">
<span<?= $Page->tglselesai->viewAttributes() ?>>
<?= $Page->tglselesai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_keterangan" class="npd_status_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
        <td <?= $Page->lampiran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_lampiran" class="npd_status_lampiran">
<span<?= $Page->lampiran->viewAttributes() ?>>
<?= $Page->lampiran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_created_at" class="npd_status_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_by->Visible) { // created_by ?>
        <td <?= $Page->created_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status_created_by" class="npd_status_created_by">
<span<?= $Page->created_by->viewAttributes() ?>>
<?= $Page->created_by->getViewValue() ?></span>
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
