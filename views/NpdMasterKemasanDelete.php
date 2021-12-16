<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdMasterKemasanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_master_kemasandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_master_kemasandelete = currentForm = new ew.Form("fnpd_master_kemasandelete", "delete");
    loadjs.done("fnpd_master_kemasandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_master_kemasan) ew.vars.tables.npd_master_kemasan = <?= JsonEncode(GetClientVar("tables", "npd_master_kemasan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_master_kemasandelete" id="fnpd_master_kemasandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_master_kemasan">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_master_kemasan_id" class="npd_master_kemasan_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
        <th class="<?= $Page->grup->headerCellClass() ?>"><span id="elh_npd_master_kemasan_grup" class="npd_master_kemasan_grup"><?= $Page->grup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jenis->Visible) { // jenis ?>
        <th class="<?= $Page->jenis->headerCellClass() ?>"><span id="elh_npd_master_kemasan_jenis" class="npd_master_kemasan_jenis"><?= $Page->jenis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subjenis->Visible) { // subjenis ?>
        <th class="<?= $Page->subjenis->headerCellClass() ?>"><span id="elh_npd_master_kemasan_subjenis" class="npd_master_kemasan_subjenis"><?= $Page->subjenis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_npd_master_kemasan_nama" class="npd_master_kemasan_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
        <th class="<?= $Page->nour->headerCellClass() ?>"><span id="elh_npd_master_kemasan_nour" class="npd_master_kemasan_nour"><?= $Page->nour->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
        <th class="<?= $Page->updated_user->headerCellClass() ?>"><span id="elh_npd_master_kemasan_updated_user" class="npd_master_kemasan_updated_user"><?= $Page->updated_user->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_npd_master_kemasan_updated_at" class="npd_master_kemasan_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_id" class="npd_master_kemasan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
        <td <?= $Page->grup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_grup" class="npd_master_kemasan_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jenis->Visible) { // jenis ?>
        <td <?= $Page->jenis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_jenis" class="npd_master_kemasan_jenis">
<span<?= $Page->jenis->viewAttributes() ?>>
<?= $Page->jenis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subjenis->Visible) { // subjenis ?>
        <td <?= $Page->subjenis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_subjenis" class="npd_master_kemasan_subjenis">
<span<?= $Page->subjenis->viewAttributes() ?>>
<?= $Page->subjenis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_nama" class="npd_master_kemasan_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
        <td <?= $Page->nour->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_nour" class="npd_master_kemasan_nour">
<span<?= $Page->nour->viewAttributes() ?>>
<?= $Page->nour->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
        <td <?= $Page->updated_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_updated_user" class="npd_master_kemasan_updated_user">
<span<?= $Page->updated_user->viewAttributes() ?>>
<?= $Page->updated_user->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_kemasan_updated_at" class="npd_master_kemasan_updated_at">
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
