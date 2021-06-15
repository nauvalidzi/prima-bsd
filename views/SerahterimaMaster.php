<?php

namespace PHPMaker2021\distributor;

// Table
$serahterima = Container("serahterima");
?>
<?php if ($serahterima->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_serahterimamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($serahterima->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $serahterima->TableLeftColumnClass ?>"><?= $serahterima->idpegawai->caption() ?></td>
            <td <?= $serahterima->idpegawai->cellAttributes() ?>>
<span id="el_serahterima_idpegawai">
<span<?= $serahterima->idpegawai->viewAttributes() ?>>
<?= $serahterima->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($serahterima->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $serahterima->TableLeftColumnClass ?>"><?= $serahterima->idcustomer->caption() ?></td>
            <td <?= $serahterima->idcustomer->cellAttributes() ?>>
<span id="el_serahterima_idcustomer">
<span<?= $serahterima->idcustomer->viewAttributes() ?>>
<?= $serahterima->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($serahterima->tanggalrequest->Visible) { // tanggalrequest ?>
        <tr id="r_tanggalrequest">
            <td class="<?= $serahterima->TableLeftColumnClass ?>"><?= $serahterima->tanggalrequest->caption() ?></td>
            <td <?= $serahterima->tanggalrequest->cellAttributes() ?>>
<span id="el_serahterima_tanggalrequest">
<span<?= $serahterima->tanggalrequest->viewAttributes() ?>>
<?= $serahterima->tanggalrequest->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($serahterima->tanggalst->Visible) { // tanggalst ?>
        <tr id="r_tanggalst">
            <td class="<?= $serahterima->TableLeftColumnClass ?>"><?= $serahterima->tanggalst->caption() ?></td>
            <td <?= $serahterima->tanggalst->cellAttributes() ?>>
<span id="el_serahterima_tanggalst">
<span<?= $serahterima->tanggalst->viewAttributes() ?>>
<?= $serahterima->tanggalst->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
