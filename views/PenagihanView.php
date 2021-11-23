<?php

namespace PHPMaker2021\distributor;

// Page object
$PenagihanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpenagihanview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpenagihanview = currentForm = new ew.Form("fpenagihanview", "view");
    loadjs.done("fpenagihanview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.penagihan) ew.vars.tables.penagihan = <?= JsonEncode(GetClientVar("tables", "penagihan")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpenagihanview" id="fpenagihanview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penagihan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_penagihan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->messages->Visible) { // messages ?>
    <tr id="r_messages">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_messages"><?= $Page->messages->caption() ?></span></td>
        <td data-name="messages" <?= $Page->messages->cellAttributes() ?>>
<span id="el_penagihan_messages">
<span<?= $Page->messages->viewAttributes() ?>>
<?= $Page->messages->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_order->Visible) { // tgl_order ?>
    <tr id="r_tgl_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_tgl_order"><?= $Page->tgl_order->caption() ?></span></td>
        <td data-name="tgl_order" <?= $Page->tgl_order->cellAttributes() ?>>
<span id="el_penagihan_tgl_order">
<span<?= $Page->tgl_order->viewAttributes() ?>>
<?= $Page->tgl_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kode_order->Visible) { // kode_order ?>
    <tr id="r_kode_order">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_kode_order"><?= $Page->kode_order->caption() ?></span></td>
        <td data-name="kode_order" <?= $Page->kode_order->cellAttributes() ?>>
<span id="el_penagihan_kode_order">
<span<?= $Page->kode_order->viewAttributes() ?>>
<?= $Page->kode_order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
    <tr id="r_nama_customer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_nama_customer"><?= $Page->nama_customer->caption() ?></span></td>
        <td data-name="nama_customer" <?= $Page->nama_customer->cellAttributes() ?>>
<span id="el_penagihan_nama_customer">
<span<?= $Page->nama_customer->viewAttributes() ?>>
<?= $Page->nama_customer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
    <tr id="r_nomor_handphone">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_nomor_handphone"><?= $Page->nomor_handphone->caption() ?></span></td>
        <td data-name="nomor_handphone" <?= $Page->nomor_handphone->cellAttributes() ?>>
<span id="el_penagihan_nomor_handphone">
<span<?= $Page->nomor_handphone->viewAttributes() ?>>
<?= $Page->nomor_handphone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nilai_po->Visible) { // nilai_po ?>
    <tr id="r_nilai_po">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_nilai_po"><?= $Page->nilai_po->caption() ?></span></td>
        <td data-name="nilai_po" <?= $Page->nilai_po->cellAttributes() ?>>
<span id="el_penagihan_nilai_po">
<span<?= $Page->nilai_po->viewAttributes() ?>>
<?= $Page->nilai_po->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_faktur->Visible) { // tgl_faktur ?>
    <tr id="r_tgl_faktur">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_tgl_faktur"><?= $Page->tgl_faktur->caption() ?></span></td>
        <td data-name="tgl_faktur" <?= $Page->tgl_faktur->cellAttributes() ?>>
<span id="el_penagihan_tgl_faktur">
<span<?= $Page->tgl_faktur->viewAttributes() ?>>
<?= $Page->tgl_faktur->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
    <tr id="r_nilai_faktur">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_nilai_faktur"><?= $Page->nilai_faktur->caption() ?></span></td>
        <td data-name="nilai_faktur" <?= $Page->nilai_faktur->cellAttributes() ?>>
<span id="el_penagihan_nilai_faktur">
<span<?= $Page->nilai_faktur->viewAttributes() ?>>
<?= $Page->nilai_faktur->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->piutang->Visible) { // piutang ?>
    <tr id="r_piutang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_piutang"><?= $Page->piutang->caption() ?></span></td>
        <td data-name="piutang" <?= $Page->piutang->cellAttributes() ?>>
<span id="el_penagihan_piutang">
<span<?= $Page->piutang->viewAttributes() ?>>
<?= $Page->piutang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->umur_faktur->Visible) { // umur_faktur ?>
    <tr id="r_umur_faktur">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_umur_faktur"><?= $Page->umur_faktur->caption() ?></span></td>
        <td data-name="umur_faktur" <?= $Page->umur_faktur->cellAttributes() ?>>
<span id="el_penagihan_umur_faktur">
<span<?= $Page->umur_faktur->viewAttributes() ?>>
<?= $Page->umur_faktur->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_antrian->Visible) { // tgl_antrian ?>
    <tr id="r_tgl_antrian">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_tgl_antrian"><?= $Page->tgl_antrian->caption() ?></span></td>
        <td data-name="tgl_antrian" <?= $Page->tgl_antrian->cellAttributes() ?>>
<span id="el_penagihan_tgl_antrian">
<span<?= $Page->tgl_antrian->viewAttributes() ?>>
<?= $Page->tgl_antrian->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_penagihan_status">
<span<?= $Page->status->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_status_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->status->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->status->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_status_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_penagihan->Visible) { // tgl_penagihan ?>
    <tr id="r_tgl_penagihan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_tgl_penagihan"><?= $Page->tgl_penagihan->caption() ?></span></td>
        <td data-name="tgl_penagihan" <?= $Page->tgl_penagihan->cellAttributes() ?>>
<span id="el_penagihan_tgl_penagihan">
<span<?= $Page->tgl_penagihan->viewAttributes() ?>>
<?= $Page->tgl_penagihan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_return->Visible) { // tgl_return ?>
    <tr id="r_tgl_return">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_tgl_return"><?= $Page->tgl_return->caption() ?></span></td>
        <td data-name="tgl_return" <?= $Page->tgl_return->cellAttributes() ?>>
<span id="el_penagihan_tgl_return">
<span<?= $Page->tgl_return->viewAttributes() ?>>
<?= $Page->tgl_return->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_cancel->Visible) { // tgl_cancel ?>
    <tr id="r_tgl_cancel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penagihan_tgl_cancel"><?= $Page->tgl_cancel->caption() ?></span></td>
        <td data-name="tgl_cancel" <?= $Page->tgl_cancel->cellAttributes() ?>>
<span id="el_penagihan_tgl_cancel">
<span<?= $Page->tgl_cancel->viewAttributes() ?>>
<?= $Page->tgl_cancel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
