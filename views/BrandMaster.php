<?php

namespace PHPMaker2021\distributor;

// Table
$brand = Container("brand");
?>
<?php if ($brand->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_brandmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($brand->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->idcustomer->caption() ?></td>
            <td <?= $brand->idcustomer->cellAttributes() ?>>
<span id="el_brand_idcustomer">
<span<?= $brand->idcustomer->viewAttributes() ?>>
<?= $brand->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($brand->title->Visible) { // title ?>
        <tr id="r_title">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->title->caption() ?></td>
            <td <?= $brand->title->cellAttributes() ?>>
<span id="el_brand_title">
<span<?= $brand->title->viewAttributes() ?>>
<?= $brand->title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($brand->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->kode->caption() ?></td>
            <td <?= $brand->kode->cellAttributes() ?>>
<span id="el_brand_kode">
<span<?= $brand->kode->viewAttributes() ?>>
<?= $brand->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($brand->ijinhaki->Visible) { // ijinhaki ?>
        <tr id="r_ijinhaki">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->ijinhaki->caption() ?></td>
            <td <?= $brand->ijinhaki->cellAttributes() ?>>
<span id="el_brand_ijinhaki">
<span<?= $brand->ijinhaki->viewAttributes() ?>>
<?= $brand->ijinhaki->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($brand->ijinbpom->Visible) { // ijinbpom ?>
        <tr id="r_ijinbpom">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->ijinbpom->caption() ?></td>
            <td <?= $brand->ijinbpom->cellAttributes() ?>>
<span id="el_brand_ijinbpom">
<span<?= $brand->ijinbpom->viewAttributes() ?>>
<?= $brand->ijinbpom->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
