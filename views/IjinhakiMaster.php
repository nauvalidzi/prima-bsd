<?php

namespace PHPMaker2021\production2;

// Table
$ijinhaki = Container("ijinhaki");
?>
<?php if ($ijinhaki->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_ijinhakimaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($ijinhaki->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->idpegawai->caption() ?></td>
            <td <?= $ijinhaki->idpegawai->cellAttributes() ?>>
<span id="el_ijinhaki_idpegawai">
<span<?= $ijinhaki->idpegawai->viewAttributes() ?>>
<?= $ijinhaki->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->idcustomer->caption() ?></td>
            <td <?= $ijinhaki->idcustomer->cellAttributes() ?>>
<span id="el_ijinhaki_idcustomer">
<span<?= $ijinhaki->idcustomer->viewAttributes() ?>>
<?= $ijinhaki->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->idbrand->Visible) { // idbrand ?>
        <tr id="r_idbrand">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->idbrand->caption() ?></td>
            <td <?= $ijinhaki->idbrand->cellAttributes() ?>>
<span id="el_ijinhaki_idbrand">
<span<?= $ijinhaki->idbrand->viewAttributes() ?>>
<?= $ijinhaki->idbrand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->status->Visible) { // status ?>
        <tr id="r_status">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->status->caption() ?></td>
            <td <?= $ijinhaki->status->cellAttributes() ?>>
<span id="el_ijinhaki_status">
<span<?= $ijinhaki->status->viewAttributes() ?>>
<?= $ijinhaki->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
