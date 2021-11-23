<?php

namespace PHPMaker2021\distributor;

// Table
$customer = Container("customer");
?>
<?php if ($customer->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_customermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($customer->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->kode->caption() ?></td>
            <td <?= $customer->kode->cellAttributes() ?>>
<span id="el_customer_kode">
<span<?= $customer->kode->viewAttributes() ?>>
<?= $customer->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($customer->idtipecustomer->Visible) { // idtipecustomer ?>
        <tr id="r_idtipecustomer">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->idtipecustomer->caption() ?></td>
            <td <?= $customer->idtipecustomer->cellAttributes() ?>>
<span id="el_customer_idtipecustomer">
<span<?= $customer->idtipecustomer->viewAttributes() ?>>
<?= $customer->idtipecustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($customer->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->idpegawai->caption() ?></td>
            <td <?= $customer->idpegawai->cellAttributes() ?>>
<span id="el_customer_idpegawai">
<span<?= $customer->idpegawai->viewAttributes() ?>>
<?= $customer->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($customer->nama->Visible) { // nama ?>
        <tr id="r_nama">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->nama->caption() ?></td>
            <td <?= $customer->nama->cellAttributes() ?>>
<span id="el_customer_nama">
<span<?= $customer->nama->viewAttributes() ?>>
<?= $customer->nama->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($customer->jenis_usaha->Visible) { // jenis_usaha ?>
        <tr id="r_jenis_usaha">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->jenis_usaha->caption() ?></td>
            <td <?= $customer->jenis_usaha->cellAttributes() ?>>
<span id="el_customer_jenis_usaha">
<span<?= $customer->jenis_usaha->viewAttributes() ?>>
<?= $customer->jenis_usaha->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($customer->hp->Visible) { // hp ?>
        <tr id="r_hp">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->hp->caption() ?></td>
            <td <?= $customer->hp->cellAttributes() ?>>
<span id="el_customer_hp">
<span<?= $customer->hp->viewAttributes() ?>>
<?= $customer->hp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($customer->kodenpd->Visible) { // kodenpd ?>
        <tr id="r_kodenpd">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->kodenpd->caption() ?></td>
            <td <?= $customer->kodenpd->cellAttributes() ?>>
<span id="el_customer_kodenpd">
<span<?= $customer->kodenpd->viewAttributes() ?>>
<?= $customer->kodenpd->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($customer->klinik->Visible) { // klinik ?>
        <tr id="r_klinik">
            <td class="<?= $customer->TableLeftColumnClass ?>"><?= $customer->klinik->caption() ?></td>
            <td <?= $customer->klinik->cellAttributes() ?>>
<span id="el_customer_klinik">
<span<?= $customer->klinik->viewAttributes() ?>>
<?= $customer->klinik->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
