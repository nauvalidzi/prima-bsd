<?php

namespace PHPMaker2021\distributor;

// Table
$pegawai = Container("pegawai");
?>
<?php if ($pegawai->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_pegawaimaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($pegawai->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $pegawai->TableLeftColumnClass ?>"><?= $pegawai->kode->caption() ?></td>
            <td <?= $pegawai->kode->cellAttributes() ?>>
<span id="el_pegawai_kode">
<span<?= $pegawai->kode->viewAttributes() ?>>
<?= $pegawai->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pegawai->nama->Visible) { // nama ?>
        <tr id="r_nama">
            <td class="<?= $pegawai->TableLeftColumnClass ?>"><?= $pegawai->nama->caption() ?></td>
            <td <?= $pegawai->nama->cellAttributes() ?>>
<span id="el_pegawai_nama">
<span<?= $pegawai->nama->viewAttributes() ?>>
<?= $pegawai->nama->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pegawai->wa->Visible) { // wa ?>
        <tr id="r_wa">
            <td class="<?= $pegawai->TableLeftColumnClass ?>"><?= $pegawai->wa->caption() ?></td>
            <td <?= $pegawai->wa->cellAttributes() ?>>
<span id="el_pegawai_wa">
<span<?= $pegawai->wa->viewAttributes() ?>>
<?= $pegawai->wa->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pegawai->hp->Visible) { // hp ?>
        <tr id="r_hp">
            <td class="<?= $pegawai->TableLeftColumnClass ?>"><?= $pegawai->hp->caption() ?></td>
            <td <?= $pegawai->hp->cellAttributes() ?>>
<span id="el_pegawai_hp">
<span<?= $pegawai->hp->viewAttributes() ?>>
<?= $pegawai->hp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pegawai->rekbank->Visible) { // rekbank ?>
        <tr id="r_rekbank">
            <td class="<?= $pegawai->TableLeftColumnClass ?>"><?= $pegawai->rekbank->caption() ?></td>
            <td <?= $pegawai->rekbank->cellAttributes() ?>>
<span id="el_pegawai_rekbank">
<span<?= $pegawai->rekbank->viewAttributes() ?>>
<?= $pegawai->rekbank->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
