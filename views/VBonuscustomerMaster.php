<?php

namespace PHPMaker2021\production2;

// Table
$v_bonuscustomer = Container("v_bonuscustomer");
?>
<?php if ($v_bonuscustomer->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_v_bonuscustomermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($v_bonuscustomer->pegawai->Visible) { // pegawai ?>
        <tr id="r_pegawai">
            <td class="<?= $v_bonuscustomer->TableLeftColumnClass ?>"><?= $v_bonuscustomer->pegawai->caption() ?></td>
            <td <?= $v_bonuscustomer->pegawai->cellAttributes() ?>>
<span id="el_v_bonuscustomer_pegawai">
<span<?= $v_bonuscustomer->pegawai->viewAttributes() ?>>
<?= $v_bonuscustomer->pegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_bonuscustomer->customer->Visible) { // customer ?>
        <tr id="r_customer">
            <td class="<?= $v_bonuscustomer->TableLeftColumnClass ?>"><?= $v_bonuscustomer->customer->caption() ?></td>
            <td <?= $v_bonuscustomer->customer->cellAttributes() ?>>
<span id="el_v_bonuscustomer_customer">
<span<?= $v_bonuscustomer->customer->viewAttributes() ?>>
<?= $v_bonuscustomer->customer->getViewValue() ?></span>
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
