<?php

namespace PHPMaker2021\distributor;

// Table
$npd = Container("npd");
?>
<?php if ($npd->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_npdmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($npd->tanggal_order->Visible) { // tanggal_order ?>
        <tr id="r_tanggal_order">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->tanggal_order->caption() ?></td>
            <td <?= $npd->tanggal_order->cellAttributes() ?>>
<span id="el_npd_tanggal_order">
<span<?= $npd->tanggal_order->viewAttributes() ?>>
<?= $npd->tanggal_order->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->target_selesai->Visible) { // target_selesai ?>
        <tr id="r_target_selesai">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->target_selesai->caption() ?></td>
            <td <?= $npd->target_selesai->cellAttributes() ?>>
<span id="el_npd_target_selesai">
<span<?= $npd->target_selesai->viewAttributes() ?>>
<?= $npd->target_selesai->getViewValue() ?></span>
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
<?php if ($npd->sifatorder->Visible) { // sifatorder ?>
        <tr id="r_sifatorder">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->sifatorder->caption() ?></td>
            <td <?= $npd->sifatorder->cellAttributes() ?>>
<span id="el_npd_sifatorder">
<span<?= $npd->sifatorder->viewAttributes() ?>>
<?= $npd->sifatorder->getViewValue() ?></span>
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
<?php if ($npd->nomororder->Visible) { // nomororder ?>
        <tr id="r_nomororder">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->nomororder->caption() ?></td>
            <td <?= $npd->nomororder->cellAttributes() ?>>
<span id="el_npd_nomororder">
<span<?= $npd->nomororder->viewAttributes() ?>>
<?= $npd->nomororder->getViewValue() ?></span>
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
<?php if ($npd->updated_at->Visible) { // updated_at ?>
        <tr id="r_updated_at">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->updated_at->caption() ?></td>
            <td <?= $npd->updated_at->cellAttributes() ?>>
<span id="el_npd_updated_at">
<span<?= $npd->updated_at->viewAttributes() ?>>
<?= $npd->updated_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
