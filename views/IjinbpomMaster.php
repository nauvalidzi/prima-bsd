<?php

namespace PHPMaker2021\production2;

// Table
$ijinbpom = Container("ijinbpom");
?>
<?php if ($ijinbpom->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_ijinbpommaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($ijinbpom->tglterima->Visible) { // tglterima ?>
        <tr id="r_tglterima">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->tglterima->caption() ?></td>
            <td <?= $ijinbpom->tglterima->cellAttributes() ?>>
<span id="el_ijinbpom_tglterima">
<span<?= $ijinbpom->tglterima->viewAttributes() ?>>
<?= $ijinbpom->tglterima->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->tglsubmit->Visible) { // tglsubmit ?>
        <tr id="r_tglsubmit">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->tglsubmit->caption() ?></td>
            <td <?= $ijinbpom->tglsubmit->cellAttributes() ?>>
<span id="el_ijinbpom_tglsubmit">
<span<?= $ijinbpom->tglsubmit->viewAttributes() ?>>
<?= $ijinbpom->tglsubmit->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->idcustomer->caption() ?></td>
            <td <?= $ijinbpom->idcustomer->cellAttributes() ?>>
<span id="el_ijinbpom_idcustomer">
<span<?= $ijinbpom->idcustomer->viewAttributes() ?>>
<?= $ijinbpom->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->idbrand->Visible) { // idbrand ?>
        <tr id="r_idbrand">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->idbrand->caption() ?></td>
            <td <?= $ijinbpom->idbrand->cellAttributes() ?>>
<span id="el_ijinbpom_idbrand">
<span<?= $ijinbpom->idbrand->viewAttributes() ?>>
<?= $ijinbpom->idbrand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinbpom->status->Visible) { // status ?>
        <tr id="r_status">
            <td class="<?= $ijinbpom->TableLeftColumnClass ?>"><?= $ijinbpom->status->caption() ?></td>
            <td <?= $ijinbpom->status->cellAttributes() ?>>
<span id="el_ijinbpom_status">
<span<?= $ijinbpom->status->viewAttributes() ?>>
<?= $ijinbpom->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
