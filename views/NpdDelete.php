<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpddelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpddelete = currentForm = new ew.Form("fnpddelete", "delete");
    loadjs.done("fnpddelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd) ew.vars.tables.npd = <?= JsonEncode(GetClientVar("tables", "npd")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpddelete" id="fnpddelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd">
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
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_npd_status" class="npd_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_npd_idpegawai" class="npd_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_npd_idcustomer" class="npd_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <th class="<?= $Page->kodeorder->headerCellClass() ?>"><span id="elh_npd_kodeorder" class="npd_kodeorder"><?= $Page->kodeorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_npd_nama" class="npd_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
        <th class="<?= $Page->tanggal_order->headerCellClass() ?>"><span id="elh_npd_tanggal_order" class="npd_tanggal_order"><?= $Page->tanggal_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
        <th class="<?= $Page->target_selesai->headerCellClass() ?>"><span id="elh_npd_target_selesai" class="npd_target_selesai"><?= $Page->target_selesai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <th class="<?= $Page->kategori->headerCellClass() ?>"><span id="elh_npd_kategori" class="npd_kategori"><?= $Page->kategori->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fungsi_produk->Visible) { // fungsi_produk ?>
        <th class="<?= $Page->fungsi_produk->headerCellClass() ?>"><span id="elh_npd_fungsi_produk" class="npd_fungsi_produk"><?= $Page->fungsi_produk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kualitasbarang->Visible) { // kualitasbarang ?>
        <th class="<?= $Page->kualitasbarang->headerCellClass() ?>"><span id="elh_npd_kualitasbarang" class="npd_kualitasbarang"><?= $Page->kualitasbarang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
        <th class="<?= $Page->bahan_campaign->headerCellClass() ?>"><span id="elh_npd_bahan_campaign" class="npd_bahan_campaign"><?= $Page->bahan_campaign->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ukuran_sediaan->Visible) { // ukuran_sediaan ?>
        <th class="<?= $Page->ukuran_sediaan->headerCellClass() ?>"><span id="elh_npd_ukuran_sediaan" class="npd_ukuran_sediaan"><?= $Page->ukuran_sediaan->caption() ?></span></th>
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
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_status" class="npd_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idpegawai" class="npd_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_idcustomer" class="npd_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kodeorder->Visible) { // kodeorder ?>
        <td <?= $Page->kodeorder->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kodeorder" class="npd_kodeorder">
<span<?= $Page->kodeorder->viewAttributes() ?>>
<?= $Page->kodeorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_nama" class="npd_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_order->Visible) { // tanggal_order ?>
        <td <?= $Page->tanggal_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_tanggal_order" class="npd_tanggal_order">
<span<?= $Page->tanggal_order->viewAttributes() ?>>
<?= $Page->tanggal_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->target_selesai->Visible) { // target_selesai ?>
        <td <?= $Page->target_selesai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_target_selesai" class="npd_target_selesai">
<span<?= $Page->target_selesai->viewAttributes() ?>>
<?= $Page->target_selesai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kategori->Visible) { // kategori ?>
        <td <?= $Page->kategori->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kategori" class="npd_kategori">
<span<?= $Page->kategori->viewAttributes() ?>>
<?= $Page->kategori->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fungsi_produk->Visible) { // fungsi_produk ?>
        <td <?= $Page->fungsi_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_fungsi_produk" class="npd_fungsi_produk">
<span<?= $Page->fungsi_produk->viewAttributes() ?>>
<?= $Page->fungsi_produk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kualitasbarang->Visible) { // kualitasbarang ?>
        <td <?= $Page->kualitasbarang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_kualitasbarang" class="npd_kualitasbarang">
<span<?= $Page->kualitasbarang->viewAttributes() ?>>
<?= $Page->kualitasbarang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bahan_campaign->Visible) { // bahan_campaign ?>
        <td <?= $Page->bahan_campaign->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_bahan_campaign" class="npd_bahan_campaign">
<span<?= $Page->bahan_campaign->viewAttributes() ?>>
<?= $Page->bahan_campaign->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ukuran_sediaan->Visible) { // ukuran_sediaan ?>
        <td <?= $Page->ukuran_sediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_ukuran_sediaan" class="npd_ukuran_sediaan">
<span<?= $Page->ukuran_sediaan->viewAttributes() ?>>
<?= $Page->ukuran_sediaan->getViewValue() ?></span>
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
