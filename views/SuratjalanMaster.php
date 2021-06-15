<?php

namespace PHPMaker2021\distributor;

// Table
$suratjalan = Container("suratjalan");
?>
<?php if ($suratjalan->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_suratjalanmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($suratjalan->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $suratjalan->TableLeftColumnClass ?>"><?= $suratjalan->kode->caption() ?></td>
            <td <?= $suratjalan->kode->cellAttributes() ?>>
<span id="el_suratjalan_kode">
<span<?= $suratjalan->kode->viewAttributes() ?>>
<?= $suratjalan->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suratjalan->tglsurat->Visible) { // tglsurat ?>
        <tr id="r_tglsurat">
            <td class="<?= $suratjalan->TableLeftColumnClass ?>"><?= $suratjalan->tglsurat->caption() ?></td>
            <td <?= $suratjalan->tglsurat->cellAttributes() ?>>
<span id="el_suratjalan_tglsurat">
<span<?= $suratjalan->tglsurat->viewAttributes() ?>>
<?= $suratjalan->tglsurat->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suratjalan->tglkirim->Visible) { // tglkirim ?>
        <tr id="r_tglkirim">
            <td class="<?= $suratjalan->TableLeftColumnClass ?>"><?= $suratjalan->tglkirim->caption() ?></td>
            <td <?= $suratjalan->tglkirim->cellAttributes() ?>>
<span id="el_suratjalan_tglkirim">
<span<?= $suratjalan->tglkirim->viewAttributes() ?>>
<?= $suratjalan->tglkirim->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suratjalan->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $suratjalan->TableLeftColumnClass ?>"><?= $suratjalan->idcustomer->caption() ?></td>
            <td <?= $suratjalan->idcustomer->cellAttributes() ?>>
<span id="el_suratjalan_idcustomer">
<span<?= $suratjalan->idcustomer->viewAttributes() ?>>
<?= $suratjalan->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suratjalan->idalamat_customer->Visible) { // idalamat_customer ?>
        <tr id="r_idalamat_customer">
            <td class="<?= $suratjalan->TableLeftColumnClass ?>"><?= $suratjalan->idalamat_customer->caption() ?></td>
            <td <?= $suratjalan->idalamat_customer->cellAttributes() ?>>
<span id="el_suratjalan_idalamat_customer">
<span<?= $suratjalan->idalamat_customer->viewAttributes() ?>>
<?= $suratjalan->idalamat_customer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
