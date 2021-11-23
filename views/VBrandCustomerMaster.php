<?php

namespace PHPMaker2021\distributor;

// Table
$v_brand_customer = Container("v_brand_customer");
?>
<?php if ($v_brand_customer->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_v_brand_customermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($v_brand_customer->idbrand->Visible) { // idbrand ?>
        <tr id="r_idbrand">
            <td class="<?= $v_brand_customer->TableLeftColumnClass ?>"><?= $v_brand_customer->idbrand->caption() ?></td>
            <td <?= $v_brand_customer->idbrand->cellAttributes() ?>>
<span id="el_v_brand_customer_idbrand">
<span<?= $v_brand_customer->idbrand->viewAttributes() ?>>
<?= $v_brand_customer->idbrand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_brand_customer->brand->Visible) { // brand ?>
        <tr id="r_brand">
            <td class="<?= $v_brand_customer->TableLeftColumnClass ?>"><?= $v_brand_customer->brand->caption() ?></td>
            <td <?= $v_brand_customer->brand->cellAttributes() ?>>
<span id="el_v_brand_customer_brand">
<span<?= $v_brand_customer->brand->viewAttributes() ?>>
<?= $v_brand_customer->brand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_brand_customer->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $v_brand_customer->TableLeftColumnClass ?>"><?= $v_brand_customer->idcustomer->caption() ?></td>
            <td <?= $v_brand_customer->idcustomer->cellAttributes() ?>>
<span id="el_v_brand_customer_idcustomer">
<span<?= $v_brand_customer->idcustomer->viewAttributes() ?>>
<?= $v_brand_customer->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
