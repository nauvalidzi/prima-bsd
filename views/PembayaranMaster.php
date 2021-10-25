<?php

namespace PHPMaker2021\distributor;

// Table
$pembayaran = Container("pembayaran");
?>
<?php if ($pembayaran->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_pembayaranmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($pembayaran->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $pembayaran->TableLeftColumnClass ?>"><?= $pembayaran->kode->caption() ?></td>
            <td <?= $pembayaran->kode->cellAttributes() ?>>
<span id="el_pembayaran_kode">
<span<?= $pembayaran->kode->viewAttributes() ?>>
<?= $pembayaran->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pembayaran->tanggal->Visible) { // tanggal ?>
        <tr id="r_tanggal">
            <td class="<?= $pembayaran->TableLeftColumnClass ?>"><?= $pembayaran->tanggal->caption() ?></td>
            <td <?= $pembayaran->tanggal->cellAttributes() ?>>
<span id="el_pembayaran_tanggal">
<span<?= $pembayaran->tanggal->viewAttributes() ?>>
<?= $pembayaran->tanggal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pembayaran->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $pembayaran->TableLeftColumnClass ?>"><?= $pembayaran->idcustomer->caption() ?></td>
            <td <?= $pembayaran->idcustomer->cellAttributes() ?>>
<span id="el_pembayaran_idcustomer">
<span<?= $pembayaran->idcustomer->viewAttributes() ?>>
<?= $pembayaran->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pembayaran->idinvoice->Visible) { // idinvoice ?>
        <tr id="r_idinvoice">
            <td class="<?= $pembayaran->TableLeftColumnClass ?>"><?= $pembayaran->idinvoice->caption() ?></td>
            <td <?= $pembayaran->idinvoice->cellAttributes() ?>>
<span id="el_pembayaran_idinvoice">
<span<?= $pembayaran->idinvoice->viewAttributes() ?>>
<?= $pembayaran->idinvoice->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pembayaran->jumlahbayar->Visible) { // jumlahbayar ?>
        <tr id="r_jumlahbayar">
            <td class="<?= $pembayaran->TableLeftColumnClass ?>"><?= $pembayaran->jumlahbayar->caption() ?></td>
            <td <?= $pembayaran->jumlahbayar->cellAttributes() ?>>
<span id="el_pembayaran_jumlahbayar">
<span<?= $pembayaran->jumlahbayar->viewAttributes() ?>>
<?= $pembayaran->jumlahbayar->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
