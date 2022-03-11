<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmprintDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_confirmprintdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_confirmprintdelete = currentForm = new ew.Form("fnpd_confirmprintdelete", "delete");
    loadjs.done("fnpd_confirmprintdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_confirmprint) ew.vars.tables.npd_confirmprint = <?= JsonEncode(GetClientVar("tables", "npd_confirmprint")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_confirmprintdelete" id="fnpd_confirmprintdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_confirmprint">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_confirmprint_id" class="npd_confirmprint_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
        <th class="<?= $Page->brand->headerCellClass() ?>"><span id="elh_npd_confirmprint_brand" class="npd_confirmprint_brand"><?= $Page->brand->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
        <th class="<?= $Page->tglkirim->headerCellClass() ?>"><span id="elh_npd_confirmprint_tglkirim" class="npd_confirmprint_tglkirim"><?= $Page->tglkirim->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgldisetujui->Visible) { // tgldisetujui ?>
        <th class="<?= $Page->tgldisetujui->headerCellClass() ?>"><span id="elh_npd_confirmprint_tgldisetujui" class="npd_confirmprint_tgldisetujui"><?= $Page->tgldisetujui->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desainprimer->Visible) { // desainprimer ?>
        <th class="<?= $Page->desainprimer->headerCellClass() ?>"><span id="elh_npd_confirmprint_desainprimer" class="npd_confirmprint_desainprimer"><?= $Page->desainprimer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->materialprimer->Visible) { // materialprimer ?>
        <th class="<?= $Page->materialprimer->headerCellClass() ?>"><span id="elh_npd_confirmprint_materialprimer" class="npd_confirmprint_materialprimer"><?= $Page->materialprimer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aplikasiprimer->Visible) { // aplikasiprimer ?>
        <th class="<?= $Page->aplikasiprimer->headerCellClass() ?>"><span id="elh_npd_confirmprint_aplikasiprimer" class="npd_confirmprint_aplikasiprimer"><?= $Page->aplikasiprimer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahcetakprimer->Visible) { // jumlahcetakprimer ?>
        <th class="<?= $Page->jumlahcetakprimer->headerCellClass() ?>"><span id="elh_npd_confirmprint_jumlahcetakprimer" class="npd_confirmprint_jumlahcetakprimer"><?= $Page->jumlahcetakprimer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
        <th class="<?= $Page->desainsekunder->headerCellClass() ?>"><span id="elh_npd_confirmprint_desainsekunder" class="npd_confirmprint_desainsekunder"><?= $Page->desainsekunder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->materialinnerbox->Visible) { // materialinnerbox ?>
        <th class="<?= $Page->materialinnerbox->headerCellClass() ?>"><span id="elh_npd_confirmprint_materialinnerbox" class="npd_confirmprint_materialinnerbox"><?= $Page->materialinnerbox->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aplikasiinnerbox->Visible) { // aplikasiinnerbox ?>
        <th class="<?= $Page->aplikasiinnerbox->headerCellClass() ?>"><span id="elh_npd_confirmprint_aplikasiinnerbox" class="npd_confirmprint_aplikasiinnerbox"><?= $Page->aplikasiinnerbox->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahcetak->Visible) { // jumlahcetak ?>
        <th class="<?= $Page->jumlahcetak->headerCellClass() ?>"><span id="elh_npd_confirmprint_jumlahcetak" class="npd_confirmprint_jumlahcetak"><?= $Page->jumlahcetak->caption() ?></span></th>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
        <th class="<?= $Page->checked_by->headerCellClass() ?>"><span id="elh_npd_confirmprint_checked_by" class="npd_confirmprint_checked_by"><?= $Page->checked_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
        <th class="<?= $Page->approved_by->headerCellClass() ?>"><span id="elh_npd_confirmprint_approved_by" class="npd_confirmprint_approved_by"><?= $Page->approved_by->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_npd_confirmprint_created_at" class="npd_confirmprint_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_npd_confirmprint_updated_at" class="npd_confirmprint_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_id" class="npd_confirmprint_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
        <td <?= $Page->brand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_brand" class="npd_confirmprint_brand">
<span<?= $Page->brand->viewAttributes() ?>>
<?= $Page->brand->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglkirim->Visible) { // tglkirim ?>
        <td <?= $Page->tglkirim->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_tglkirim" class="npd_confirmprint_tglkirim">
<span<?= $Page->tglkirim->viewAttributes() ?>>
<?= $Page->tglkirim->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgldisetujui->Visible) { // tgldisetujui ?>
        <td <?= $Page->tgldisetujui->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_tgldisetujui" class="npd_confirmprint_tgldisetujui">
<span<?= $Page->tgldisetujui->viewAttributes() ?>>
<?= $Page->tgldisetujui->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desainprimer->Visible) { // desainprimer ?>
        <td <?= $Page->desainprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_desainprimer" class="npd_confirmprint_desainprimer">
<span<?= $Page->desainprimer->viewAttributes() ?>>
<?= $Page->desainprimer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->materialprimer->Visible) { // materialprimer ?>
        <td <?= $Page->materialprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_materialprimer" class="npd_confirmprint_materialprimer">
<span<?= $Page->materialprimer->viewAttributes() ?>>
<?= $Page->materialprimer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aplikasiprimer->Visible) { // aplikasiprimer ?>
        <td <?= $Page->aplikasiprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_aplikasiprimer" class="npd_confirmprint_aplikasiprimer">
<span<?= $Page->aplikasiprimer->viewAttributes() ?>>
<?= $Page->aplikasiprimer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahcetakprimer->Visible) { // jumlahcetakprimer ?>
        <td <?= $Page->jumlahcetakprimer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_jumlahcetakprimer" class="npd_confirmprint_jumlahcetakprimer">
<span<?= $Page->jumlahcetakprimer->viewAttributes() ?>>
<?= $Page->jumlahcetakprimer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->desainsekunder->Visible) { // desainsekunder ?>
        <td <?= $Page->desainsekunder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_desainsekunder" class="npd_confirmprint_desainsekunder">
<span<?= $Page->desainsekunder->viewAttributes() ?>>
<?= $Page->desainsekunder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->materialinnerbox->Visible) { // materialinnerbox ?>
        <td <?= $Page->materialinnerbox->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_materialinnerbox" class="npd_confirmprint_materialinnerbox">
<span<?= $Page->materialinnerbox->viewAttributes() ?>>
<?= $Page->materialinnerbox->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aplikasiinnerbox->Visible) { // aplikasiinnerbox ?>
        <td <?= $Page->aplikasiinnerbox->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_aplikasiinnerbox" class="npd_confirmprint_aplikasiinnerbox">
<span<?= $Page->aplikasiinnerbox->viewAttributes() ?>>
<?= $Page->aplikasiinnerbox->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahcetak->Visible) { // jumlahcetak ?>
        <td <?= $Page->jumlahcetak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_jumlahcetak" class="npd_confirmprint_jumlahcetak">
<span<?= $Page->jumlahcetak->viewAttributes() ?>>
<?= $Page->jumlahcetak->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
        <td <?= $Page->checked_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_checked_by" class="npd_confirmprint_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
        <td <?= $Page->approved_by->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_approved_by" class="npd_confirmprint_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_created_at" class="npd_confirmprint_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_confirmprint_updated_at" class="npd_confirmprint_updated_at">
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
