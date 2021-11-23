<?php

namespace PHPMaker2021\distributor;

// Table
$brand = Container("brand");
?>
<?php if ($brand->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_brandmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
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
<?php if ($brand->titipmerk->Visible) { // titipmerk ?>
        <tr id="r_titipmerk">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->titipmerk->caption() ?></td>
            <td <?= $brand->titipmerk->cellAttributes() ?>>
<span id="el_brand_titipmerk">
<span<?= $brand->titipmerk->viewAttributes() ?>>
<?= $brand->titipmerk->getViewValue() ?></span>
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
<?php if ($brand->kode_sip->Visible) { // kode_sip ?>
        <tr id="r_kode_sip">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->kode_sip->caption() ?></td>
            <td <?= $brand->kode_sip->cellAttributes() ?>>
<span id="el_brand_kode_sip">
<span<?= $brand->kode_sip->viewAttributes() ?>>
<?= $brand->kode_sip->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($brand->aktif->Visible) { // aktif ?>
        <tr id="r_aktif">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->aktif->caption() ?></td>
            <td <?= $brand->aktif->cellAttributes() ?>>
<span id="el_brand_aktif">
<span<?= $brand->aktif->viewAttributes() ?>>
<?= $brand->aktif->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($brand->updated_at->Visible) { // updated_at ?>
        <tr id="r_updated_at">
            <td class="<?= $brand->TableLeftColumnClass ?>"><?= $brand->updated_at->caption() ?></td>
            <td <?= $brand->updated_at->cellAttributes() ?>>
<span id="el_brand_updated_at">
<span<?= $brand->updated_at->viewAttributes() ?>>
<?= $brand->updated_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
