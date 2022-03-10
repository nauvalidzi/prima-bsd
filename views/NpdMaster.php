<?php

namespace PHPMaker2021\production2;

// Table
$npd = Container("npd");
?>
<?php if ($npd->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_npdmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($npd->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->idcustomer->caption() ?></td>
            <td <?= $npd->idcustomer->cellAttributes() ?>>
<span id="el_npd_idcustomer">
<span<?= $npd->idcustomer->viewAttributes() ?>>
<?= $npd->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->tanggal_order->Visible) { // tanggal_order ?>
        <tr id="r_tanggal_order">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->tanggal_order->caption() ?></td>
            <td <?= $npd->tanggal_order->cellAttributes() ?>>
<span id="el_npd_tanggal_order">
<span<?= $npd->tanggal_order->viewAttributes() ?>>
<?= $npd->tanggal_order->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->sifatorder->Visible) { // sifatorder ?>
        <tr id="r_sifatorder">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->sifatorder->caption() ?></td>
            <td <?= $npd->sifatorder->cellAttributes() ?>>
<span id="el_npd_sifatorder">
<span<?= $npd->sifatorder->viewAttributes() ?>>
<?= $npd->sifatorder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->kodeorder->Visible) { // kodeorder ?>
        <tr id="r_kodeorder">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kodeorder->caption() ?></td>
            <td <?= $npd->kodeorder->cellAttributes() ?>>
<span id="el_npd_kodeorder">
<span<?= $npd->kodeorder->viewAttributes() ?>>
<?= $npd->kodeorder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <tr id="r_idproduct_acuan">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->idproduct_acuan->caption() ?></td>
            <td <?= $npd->idproduct_acuan->cellAttributes() ?>>
<span id="el_npd_idproduct_acuan">
<span<?= $npd->idproduct_acuan->viewAttributes() ?>>
<?= $npd->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->kategoriproduk->Visible) { // kategoriproduk ?>
        <tr id="r_kategoriproduk">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kategoriproduk->caption() ?></td>
            <td <?= $npd->kategoriproduk->cellAttributes() ?>>
<span id="el_npd_kategoriproduk">
<span<?= $npd->kategoriproduk->viewAttributes() ?>>
<?= $npd->kategoriproduk->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->jenisproduk->Visible) { // jenisproduk ?>
        <tr id="r_jenisproduk">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->jenisproduk->caption() ?></td>
            <td <?= $npd->jenisproduk->cellAttributes() ?>>
<span id="el_npd_jenisproduk">
<span<?= $npd->jenisproduk->viewAttributes() ?>>
<?= $npd->jenisproduk->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
