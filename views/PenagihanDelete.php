<?php

namespace PHPMaker2021\distributor;

// Page object
$PenagihanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpenagihandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpenagihandelete = currentForm = new ew.Form("fpenagihandelete", "delete");
    loadjs.done("fpenagihandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.penagihan) ew.vars.tables.penagihan = <?= JsonEncode(GetClientVar("tables", "penagihan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpenagihandelete" id="fpenagihandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penagihan">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_penagihan_id" class="penagihan_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_order->Visible) { // tgl_order ?>
        <th class="<?= $Page->tgl_order->headerCellClass() ?>"><span id="elh_penagihan_tgl_order" class="penagihan_tgl_order"><?= $Page->tgl_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kode_order->Visible) { // kode_order ?>
        <th class="<?= $Page->kode_order->headerCellClass() ?>"><span id="elh_penagihan_kode_order" class="penagihan_kode_order"><?= $Page->kode_order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <th class="<?= $Page->nama_customer->headerCellClass() ?>"><span id="elh_penagihan_nama_customer" class="penagihan_nama_customer"><?= $Page->nama_customer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
        <th class="<?= $Page->nomor_handphone->headerCellClass() ?>"><span id="elh_penagihan_nomor_handphone" class="penagihan_nomor_handphone"><?= $Page->nomor_handphone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nilai_po->Visible) { // nilai_po ?>
        <th class="<?= $Page->nilai_po->headerCellClass() ?>"><span id="elh_penagihan_nilai_po" class="penagihan_nilai_po"><?= $Page->nilai_po->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_faktur->Visible) { // tgl_faktur ?>
        <th class="<?= $Page->tgl_faktur->headerCellClass() ?>"><span id="elh_penagihan_tgl_faktur" class="penagihan_tgl_faktur"><?= $Page->tgl_faktur->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
        <th class="<?= $Page->nilai_faktur->headerCellClass() ?>"><span id="elh_penagihan_nilai_faktur" class="penagihan_nilai_faktur"><?= $Page->nilai_faktur->caption() ?></span></th>
<?php } ?>
<?php if ($Page->piutang->Visible) { // piutang ?>
        <th class="<?= $Page->piutang->headerCellClass() ?>"><span id="elh_penagihan_piutang" class="penagihan_piutang"><?= $Page->piutang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->umur_faktur->Visible) { // umur_faktur ?>
        <th class="<?= $Page->umur_faktur->headerCellClass() ?>"><span id="elh_penagihan_umur_faktur" class="penagihan_umur_faktur"><?= $Page->umur_faktur->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_antrian->Visible) { // tgl_antrian ?>
        <th class="<?= $Page->tgl_antrian->headerCellClass() ?>"><span id="elh_penagihan_tgl_antrian" class="penagihan_tgl_antrian"><?= $Page->tgl_antrian->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_penagihan_status" class="penagihan_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_penagihan->Visible) { // tgl_penagihan ?>
        <th class="<?= $Page->tgl_penagihan->headerCellClass() ?>"><span id="elh_penagihan_tgl_penagihan" class="penagihan_tgl_penagihan"><?= $Page->tgl_penagihan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_return->Visible) { // tgl_return ?>
        <th class="<?= $Page->tgl_return->headerCellClass() ?>"><span id="elh_penagihan_tgl_return" class="penagihan_tgl_return"><?= $Page->tgl_return->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tgl_cancel->Visible) { // tgl_cancel ?>
        <th class="<?= $Page->tgl_cancel->headerCellClass() ?>"><span id="elh_penagihan_tgl_cancel" class="penagihan_tgl_cancel"><?= $Page->tgl_cancel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statusts->Visible) { // statusts ?>
        <th class="<?= $Page->statusts->headerCellClass() ?>"><span id="elh_penagihan_statusts" class="penagihan_statusts"><?= $Page->statusts->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statusbayar->Visible) { // statusbayar ?>
        <th class="<?= $Page->statusbayar->headerCellClass() ?>"><span id="elh_penagihan_statusbayar" class="penagihan_statusbayar"><?= $Page->statusbayar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nomorfaktur->Visible) { // nomorfaktur ?>
        <th class="<?= $Page->nomorfaktur->headerCellClass() ?>"><span id="elh_penagihan_nomorfaktur" class="penagihan_nomorfaktur"><?= $Page->nomorfaktur->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pembayaran->Visible) { // pembayaran ?>
        <th class="<?= $Page->pembayaran->headerCellClass() ?>"><span id="elh_penagihan_pembayaran" class="penagihan_pembayaran"><?= $Page->pembayaran->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_penagihan_keterangan" class="penagihan_keterangan"><?= $Page->keterangan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->saldo->Visible) { // saldo ?>
        <th class="<?= $Page->saldo->headerCellClass() ?>"><span id="elh_penagihan_saldo" class="penagihan_saldo"><?= $Page->saldo->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_penagihan_id" class="penagihan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_order->Visible) { // tgl_order ?>
        <td <?= $Page->tgl_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_order" class="penagihan_tgl_order">
<span<?= $Page->tgl_order->viewAttributes() ?>>
<?= $Page->tgl_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kode_order->Visible) { // kode_order ?>
        <td <?= $Page->kode_order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_kode_order" class="penagihan_kode_order">
<span<?= $Page->kode_order->viewAttributes() ?>>
<?= $Page->kode_order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
        <td <?= $Page->nama_customer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nama_customer" class="penagihan_nama_customer">
<span<?= $Page->nama_customer->viewAttributes() ?>>
<?= $Page->nama_customer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
        <td <?= $Page->nomor_handphone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nomor_handphone" class="penagihan_nomor_handphone">
<span<?= $Page->nomor_handphone->viewAttributes() ?>>
<?= $Page->nomor_handphone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nilai_po->Visible) { // nilai_po ?>
        <td <?= $Page->nilai_po->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nilai_po" class="penagihan_nilai_po">
<span<?= $Page->nilai_po->viewAttributes() ?>>
<?= $Page->nilai_po->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_faktur->Visible) { // tgl_faktur ?>
        <td <?= $Page->tgl_faktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_faktur" class="penagihan_tgl_faktur">
<span<?= $Page->tgl_faktur->viewAttributes() ?>>
<?= $Page->tgl_faktur->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
        <td <?= $Page->nilai_faktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nilai_faktur" class="penagihan_nilai_faktur">
<span<?= $Page->nilai_faktur->viewAttributes() ?>>
<?= $Page->nilai_faktur->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->piutang->Visible) { // piutang ?>
        <td <?= $Page->piutang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_piutang" class="penagihan_piutang">
<span<?= $Page->piutang->viewAttributes() ?>>
<?= $Page->piutang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->umur_faktur->Visible) { // umur_faktur ?>
        <td <?= $Page->umur_faktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_umur_faktur" class="penagihan_umur_faktur">
<span<?= $Page->umur_faktur->viewAttributes() ?>>
<?= $Page->umur_faktur->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_antrian->Visible) { // tgl_antrian ?>
        <td <?= $Page->tgl_antrian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_antrian" class="penagihan_tgl_antrian">
<span<?= $Page->tgl_antrian->viewAttributes() ?>>
<?= $Page->tgl_antrian->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_status" class="penagihan_status">
<span<?= $Page->status->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_status_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_penagihan->Visible) { // tgl_penagihan ?>
        <td <?= $Page->tgl_penagihan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_penagihan" class="penagihan_tgl_penagihan">
<span<?= $Page->tgl_penagihan->viewAttributes() ?>>
<?= $Page->tgl_penagihan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_return->Visible) { // tgl_return ?>
        <td <?= $Page->tgl_return->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_return" class="penagihan_tgl_return">
<span<?= $Page->tgl_return->viewAttributes() ?>>
<?= $Page->tgl_return->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tgl_cancel->Visible) { // tgl_cancel ?>
        <td <?= $Page->tgl_cancel->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_tgl_cancel" class="penagihan_tgl_cancel">
<span<?= $Page->tgl_cancel->viewAttributes() ?>>
<?= $Page->tgl_cancel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statusts->Visible) { // statusts ?>
        <td <?= $Page->statusts->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_statusts" class="penagihan_statusts">
<span<?= $Page->statusts->viewAttributes() ?>>
<?= $Page->statusts->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statusbayar->Visible) { // statusbayar ?>
        <td <?= $Page->statusbayar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_statusbayar" class="penagihan_statusbayar">
<span<?= $Page->statusbayar->viewAttributes() ?>>
<?= $Page->statusbayar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nomorfaktur->Visible) { // nomorfaktur ?>
        <td <?= $Page->nomorfaktur->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_nomorfaktur" class="penagihan_nomorfaktur">
<span<?= $Page->nomorfaktur->viewAttributes() ?>>
<?= $Page->nomorfaktur->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pembayaran->Visible) { // pembayaran ?>
        <td <?= $Page->pembayaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_pembayaran" class="penagihan_pembayaran">
<span<?= $Page->pembayaran->viewAttributes() ?>>
<?= $Page->pembayaran->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_keterangan" class="penagihan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->saldo->Visible) { // saldo ?>
        <td <?= $Page->saldo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penagihan_saldo" class="penagihan_saldo">
<span<?= $Page->saldo->viewAttributes() ?>>
<?= $Page->saldo->getViewValue() ?></span>
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
