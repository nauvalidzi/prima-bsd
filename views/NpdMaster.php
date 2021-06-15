<?php

namespace PHPMaker2021\distributor;

// Table
$npd = Container("npd");
?>
<?php if ($npd->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_npdmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($npd->statuskategori->Visible) { // statuskategori ?>
        <tr id="r_statuskategori">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->statuskategori->caption() ?></td>
            <td <?= $npd->statuskategori->cellAttributes() ?>>
<span id="el_npd_statuskategori">
<span<?= $npd->statuskategori->viewAttributes() ?>>
<?= $npd->statuskategori->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->idpegawai->caption() ?></td>
            <td <?= $npd->idpegawai->cellAttributes() ?>>
<span id="el_npd_idpegawai">
<span<?= $npd->idpegawai->viewAttributes() ?>>
<?= $npd->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->idcustomer->caption() ?></td>
            <td <?= $npd->idcustomer->cellAttributes() ?>>
<span id="el_npd_idcustomer">
<span<?= $npd->idcustomer->viewAttributes() ?>>
<?= $npd->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->kodeorder->Visible) { // kodeorder ?>
        <tr id="r_kodeorder">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kodeorder->caption() ?></td>
            <td <?= $npd->kodeorder->cellAttributes() ?>>
<span id="el_npd_kodeorder">
<span<?= $npd->kodeorder->viewAttributes() ?>>
<?= $npd->kodeorder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->idbrand->Visible) { // idbrand ?>
        <tr id="r_idbrand">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->idbrand->caption() ?></td>
            <td <?= $npd->idbrand->cellAttributes() ?>>
<span id="el_npd_idbrand">
<span<?= $npd->idbrand->viewAttributes() ?>>
<?= $npd->idbrand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->nama->Visible) { // nama ?>
        <tr id="r_nama">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->nama->caption() ?></td>
            <td <?= $npd->nama->cellAttributes() ?>>
<span id="el_npd_nama">
<span<?= $npd->nama->viewAttributes() ?>>
<?= $npd->nama->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <tr id="r_idproduct_acuan">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->idproduct_acuan->caption() ?></td>
            <td <?= $npd->idproduct_acuan->cellAttributes() ?>>
<span id="el_npd_idproduct_acuan">
<span<?= $npd->idproduct_acuan->viewAttributes() ?>>
<?= $npd->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->status->Visible) { // status ?>
        <tr id="r_status">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->status->caption() ?></td>
            <td <?= $npd->status->cellAttributes() ?>>
<span id="el_npd_status">
<span<?= $npd->status->viewAttributes() ?>>
<?= $npd->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
