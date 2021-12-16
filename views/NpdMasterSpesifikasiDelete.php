<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdMasterSpesifikasiDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_master_spesifikasidelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_master_spesifikasidelete = currentForm = new ew.Form("fnpd_master_spesifikasidelete", "delete");
    loadjs.done("fnpd_master_spesifikasidelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_master_spesifikasi) ew.vars.tables.npd_master_spesifikasi = <?= JsonEncode(GetClientVar("tables", "npd_master_spesifikasi")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_master_spesifikasidelete" id="fnpd_master_spesifikasidelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_master_spesifikasi">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_id" class="npd_master_spesifikasi_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
        <th class="<?= $Page->grup->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_grup" class="npd_master_spesifikasi_grup"><?= $Page->grup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <th class="<?= $Page->kategori->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_kategori" class="npd_master_spesifikasi_kategori"><?= $Page->kategori->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <th class="<?= $Page->sediaan->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_sediaan" class="npd_master_spesifikasi_sediaan"><?= $Page->sediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
        <th class="<?= $Page->bentukan->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_bentukan" class="npd_master_spesifikasi_bentukan"><?= $Page->bentukan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
        <th class="<?= $Page->konsep->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_konsep" class="npd_master_spesifikasi_konsep"><?= $Page->konsep->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <th class="<?= $Page->bahanaktif->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_bahanaktif" class="npd_master_spesifikasi_bahanaktif"><?= $Page->bahanaktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <th class="<?= $Page->fragrance->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_fragrance" class="npd_master_spesifikasi_fragrance"><?= $Page->fragrance->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <th class="<?= $Page->aroma->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_aroma" class="npd_master_spesifikasi_aroma"><?= $Page->aroma->caption() ?></span></th>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <th class="<?= $Page->warna->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_warna" class="npd_master_spesifikasi_warna"><?= $Page->warna->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <th class="<?= $Page->aplikasi_sediaan->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_aplikasi_sediaan" class="npd_master_spesifikasi_aplikasi_sediaan"><?= $Page->aplikasi_sediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <th class="<?= $Page->aksesoris->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_aksesoris" class="npd_master_spesifikasi_aksesoris"><?= $Page->aksesoris->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
        <th class="<?= $Page->nour->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_nour" class="npd_master_spesifikasi_nour"><?= $Page->nour->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_updated_at" class="npd_master_spesifikasi_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
        <th class="<?= $Page->updated_user->headerCellClass() ?>"><span id="elh_npd_master_spesifikasi_updated_user" class="npd_master_spesifikasi_updated_user"><?= $Page->updated_user->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_id" class="npd_master_spesifikasi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
        <td <?= $Page->grup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_grup" class="npd_master_spesifikasi_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <td <?= $Page->kategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_kategori" class="npd_master_spesifikasi_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sediaan->Visible) { // sediaan ?>
        <td <?= $Page->sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_sediaan" class="npd_master_spesifikasi_sediaan">
<span<?= $Page->sediaan->viewAttributes() ?>>
<?= $Page->sediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bentukan->Visible) { // bentukan ?>
        <td <?= $Page->bentukan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_bentukan" class="npd_master_spesifikasi_bentukan">
<span<?= $Page->bentukan->viewAttributes() ?>>
<?= $Page->bentukan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->konsep->Visible) { // konsep ?>
        <td <?= $Page->konsep->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_konsep" class="npd_master_spesifikasi_konsep">
<span<?= $Page->konsep->viewAttributes() ?>>
<?= $Page->konsep->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
        <td <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_bahanaktif" class="npd_master_spesifikasi_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
        <td <?= $Page->fragrance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_fragrance" class="npd_master_spesifikasi_fragrance">
<span<?= $Page->fragrance->viewAttributes() ?>>
<?= $Page->fragrance->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
        <td <?= $Page->aroma->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_aroma" class="npd_master_spesifikasi_aroma">
<span<?= $Page->aroma->viewAttributes() ?>>
<?= $Page->aroma->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
        <td <?= $Page->warna->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_warna" class="npd_master_spesifikasi_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
        <td <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_aplikasi_sediaan" class="npd_master_spesifikasi_aplikasi_sediaan">
<span<?= $Page->aplikasi_sediaan->viewAttributes() ?>>
<?= $Page->aplikasi_sediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
        <td <?= $Page->aksesoris->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_aksesoris" class="npd_master_spesifikasi_aksesoris">
<span<?= $Page->aksesoris->viewAttributes() ?>>
<?= $Page->aksesoris->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nour->Visible) { // nour ?>
        <td <?= $Page->nour->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_nour" class="npd_master_spesifikasi_nour">
<span<?= $Page->nour->viewAttributes() ?>>
<?= $Page->nour->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_updated_at" class="npd_master_spesifikasi_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_user->Visible) { // updated_user ?>
        <td <?= $Page->updated_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_master_spesifikasi_updated_user" class="npd_master_spesifikasi_updated_user">
<span<?= $Page->updated_user->viewAttributes() ?>>
<?= $Page->updated_user->getViewValue() ?></span>
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
