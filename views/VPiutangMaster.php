<?php

namespace PHPMaker2021\distributor;

// Table
$v_piutang = Container("v_piutang");
?>
<?php if ($v_piutang->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_v_piutangmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($v_piutang->pegawai->Visible) { // pegawai ?>
        <tr id="r_pegawai">
            <td class="<?= $v_piutang->TableLeftColumnClass ?>"><?= $v_piutang->pegawai->caption() ?></td>
            <td <?= $v_piutang->pegawai->cellAttributes() ?>>
<span id="el_v_piutang_pegawai">
<span<?= $v_piutang->pegawai->viewAttributes() ?>>
<?= $v_piutang->pegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_piutang->customer->Visible) { // customer ?>
        <tr id="r_customer">
            <td class="<?= $v_piutang->TableLeftColumnClass ?>"><?= $v_piutang->customer->caption() ?></td>
            <td <?= $v_piutang->customer->cellAttributes() ?>>
<span id="el_v_piutang_customer">
<span<?= $v_piutang->customer->viewAttributes() ?>>
<?= $v_piutang->customer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_piutang->totaltagihan->Visible) { // totaltagihan ?>
        <tr id="r_totaltagihan">
            <td class="<?= $v_piutang->TableLeftColumnClass ?>"><?= $v_piutang->totaltagihan->caption() ?></td>
            <td <?= $v_piutang->totaltagihan->cellAttributes() ?>>
<span id="el_v_piutang_totaltagihan">
<span<?= $v_piutang->totaltagihan->viewAttributes() ?>>
<?= $v_piutang->totaltagihan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($v_piutang->totalpiutang->Visible) { // totalpiutang ?>
        <tr id="r_totalpiutang">
            <td class="<?= $v_piutang->TableLeftColumnClass ?>"><?= $v_piutang->totalpiutang->caption() ?></td>
            <td <?= $v_piutang->totalpiutang->cellAttributes() ?>>
<span id="el_v_piutang_totalpiutang">
<span<?= $v_piutang->totalpiutang->viewAttributes() ?>>
<?= $v_piutang->totalpiutang->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
