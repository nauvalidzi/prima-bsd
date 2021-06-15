<?php

namespace PHPMaker2021\distributor;

// Table
$v_bonuscustomer = Container("v_bonuscustomer");
?>
<?php if ($v_bonuscustomer->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_v_bonuscustomermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($v_bonuscustomer->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $v_bonuscustomer->TableLeftColumnClass ?>"><?= $v_bonuscustomer->idcustomer->caption() ?></td>
            <td <?= $v_bonuscustomer->idcustomer->cellAttributes() ?>>
<span id="el_v_bonuscustomer_idcustomer">
<span<?= $v_bonuscustomer->idcustomer->viewAttributes() ?>>
<?= $v_bonuscustomer->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_bonuscustomer->blackbonus->Visible) { // blackbonus ?>
        <tr id="r_blackbonus">
            <td class="<?= $v_bonuscustomer->TableLeftColumnClass ?>"><?= $v_bonuscustomer->blackbonus->caption() ?></td>
            <td <?= $v_bonuscustomer->blackbonus->cellAttributes() ?>>
<span id="el_v_bonuscustomer_blackbonus">
<span<?= $v_bonuscustomer->blackbonus->viewAttributes() ?>>
<?= $v_bonuscustomer->blackbonus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
