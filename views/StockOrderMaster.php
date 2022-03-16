<?php

namespace PHPMaker2021\production2;

// Table
$stock_order = Container("stock_order");
?>
<?php if ($stock_order->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_stock_ordermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($stock_order->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $stock_order->TableLeftColumnClass ?>"><?= $stock_order->kode->caption() ?></td>
            <td <?= $stock_order->kode->cellAttributes() ?>>
<span id="el_stock_order_kode">
<span<?= $stock_order->kode->viewAttributes() ?>>
<?= $stock_order->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_order->tanggal->Visible) { // tanggal ?>
        <tr id="r_tanggal">
            <td class="<?= $stock_order->TableLeftColumnClass ?>"><?= $stock_order->tanggal->caption() ?></td>
            <td <?= $stock_order->tanggal->cellAttributes() ?>>
<span id="el_stock_order_tanggal">
<span<?= $stock_order->tanggal->viewAttributes() ?>>
<?= $stock_order->tanggal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_order->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $stock_order->TableLeftColumnClass ?>"><?= $stock_order->idpegawai->caption() ?></td>
            <td <?= $stock_order->idpegawai->cellAttributes() ?>>
<span id="el_stock_order_idpegawai">
<span<?= $stock_order->idpegawai->viewAttributes() ?>>
<?= $stock_order->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_order->keterangan->Visible) { // keterangan ?>
        <tr id="r_keterangan">
            <td class="<?= $stock_order->TableLeftColumnClass ?>"><?= $stock_order->keterangan->caption() ?></td>
            <td <?= $stock_order->keterangan->cellAttributes() ?>>
<span id="el_stock_order_keterangan">
<span<?= $stock_order->keterangan->viewAttributes() ?>>
<?= $stock_order->keterangan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_order->readonly->Visible) { // readonly ?>
        <tr id="r_readonly">
            <td class="<?= $stock_order->TableLeftColumnClass ?>"><?= $stock_order->readonly->caption() ?></td>
            <td <?= $stock_order->readonly->cellAttributes() ?>>
<span id="el_stock_order_readonly">
<span<?= $stock_order->readonly->viewAttributes() ?>>
<?= $stock_order->readonly->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($stock_order->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $stock_order->TableLeftColumnClass ?>"><?= $stock_order->created_at->caption() ?></td>
            <td <?= $stock_order->created_at->cellAttributes() ?>>
<span id="el_stock_order_created_at">
<span<?= $stock_order->created_at->viewAttributes() ?>>
<?= $stock_order->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
