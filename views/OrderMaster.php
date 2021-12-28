<?php

namespace PHPMaker2021\distributor;

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
    </tbody>
</table>
</div>
<?php } ?>
