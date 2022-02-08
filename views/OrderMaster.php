<?php

namespace PHPMaker2021\production2;

// Table
$order = Container("order");
?>
<?php if ($order->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_ordermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($order->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->kode->caption() ?></td>
            <td <?= $order->kode->cellAttributes() ?>>
<span id="el_order_kode">
<span<?= $order->kode->viewAttributes() ?>>
<?= $order->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($order->tanggal->Visible) { // tanggal ?>
        <tr id="r_tanggal">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->tanggal->caption() ?></td>
            <td <?= $order->tanggal->cellAttributes() ?>>
<span id="el_order_tanggal">
<span<?= $order->tanggal->viewAttributes() ?>>
<?= $order->tanggal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($order->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->idpegawai->caption() ?></td>
            <td <?= $order->idpegawai->cellAttributes() ?>>
<span id="el_order_idpegawai">
<span<?= $order->idpegawai->viewAttributes() ?>>
<?= $order->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($order->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->idcustomer->caption() ?></td>
            <td <?= $order->idcustomer->cellAttributes() ?>>
<span id="el_order_idcustomer">
<span<?= $order->idcustomer->viewAttributes() ?>>
<?= $order->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($order->idbrand->Visible) { // idbrand ?>
        <tr id="r_idbrand">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->idbrand->caption() ?></td>
            <td <?= $order->idbrand->cellAttributes() ?>>
<span id="el_order_idbrand">
<span<?= $order->idbrand->viewAttributes() ?>>
<?= $order->idbrand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($order->dokumen->Visible) { // dokumen ?>
        <tr id="r_dokumen">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->dokumen->caption() ?></td>
            <td <?= $order->dokumen->cellAttributes() ?>>
<span id="el_order_dokumen">
<span<?= $order->dokumen->viewAttributes() ?>>
<?= GetFileViewTag($order->dokumen, $order->dokumen->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($order->catatan->Visible) { // catatan ?>
        <tr id="r_catatan">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->catatan->caption() ?></td>
            <td <?= $order->catatan->cellAttributes() ?>>
<span id="el_order_catatan">
<span<?= $order->catatan->viewAttributes() ?>>
<?= $order->catatan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($order->status->Visible) { // status ?>
        <tr id="r_status">
            <td class="<?= $order->TableLeftColumnClass ?>"><?= $order->status->caption() ?></td>
            <td <?= $order->status->cellAttributes() ?>>
<span id="el_order_status">
<span<?= $order->status->viewAttributes() ?>>
<?= $order->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
