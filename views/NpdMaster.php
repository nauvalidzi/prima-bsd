<?php

namespace PHPMaker2021\production2;

// Table
$npd = Container("npd");
?>
<?php if ($npd->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_npdmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
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
<?php if ($npd->kategoriproduk->Visible) { // kategoriproduk ?>
        <tr id="r_kategoriproduk">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kategoriproduk->caption() ?></td>
            <td <?= $npd->kategoriproduk->cellAttributes() ?>>
<span id="el_npd_kategoriproduk">
<span<?= $npd->kategoriproduk->viewAttributes() ?>>
<?= $npd->kategoriproduk->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->jenisproduk->Visible) { // jenisproduk ?>
        <tr id="r_jenisproduk">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->jenisproduk->caption() ?></td>
            <td <?= $npd->jenisproduk->cellAttributes() ?>>
<span id="el_npd_jenisproduk">
<span<?= $npd->jenisproduk->viewAttributes() ?>>
<?= $npd->jenisproduk->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->kemasanwadah->Visible) { // kemasanwadah ?>
        <tr id="r_kemasanwadah">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kemasanwadah->caption() ?></td>
            <td <?= $npd->kemasanwadah->cellAttributes() ?>>
<span id="el_npd_kemasanwadah">
<span<?= $npd->kemasanwadah->viewAttributes() ?>>
<?= $npd->kemasanwadah->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->ukurankemasansekunder->Visible) { // ukurankemasansekunder ?>
        <tr id="r_ukurankemasansekunder">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->ukurankemasansekunder->caption() ?></td>
            <td <?= $npd->ukurankemasansekunder->cellAttributes() ?>>
<span id="el_npd_ukurankemasansekunder">
<span<?= $npd->ukurankemasansekunder->viewAttributes() ?>>
<?= $npd->ukurankemasansekunder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->satuankemasansekunder->Visible) { // satuankemasansekunder ?>
        <tr id="r_satuankemasansekunder">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->satuankemasansekunder->caption() ?></td>
            <td <?= $npd->satuankemasansekunder->cellAttributes() ?>>
<span id="el_npd_satuankemasansekunder">
<span<?= $npd->satuankemasansekunder->viewAttributes() ?>>
<?= $npd->satuankemasansekunder->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->kemasanbahan->Visible) { // kemasanbahan ?>
        <tr id="r_kemasanbahan">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kemasanbahan->caption() ?></td>
            <td <?= $npd->kemasanbahan->cellAttributes() ?>>
<span id="el_npd_kemasanbahan">
<span<?= $npd->kemasanbahan->viewAttributes() ?>>
<?= $npd->kemasanbahan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->kemasankomposisi->Visible) { // kemasankomposisi ?>
        <tr id="r_kemasankomposisi">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kemasankomposisi->caption() ?></td>
            <td <?= $npd->kemasankomposisi->cellAttributes() ?>>
<span id="el_npd_kemasankomposisi">
<span<?= $npd->kemasankomposisi->viewAttributes() ?>>
<?= $npd->kemasankomposisi->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->labeltekstur->Visible) { // labeltekstur ?>
        <tr id="r_labeltekstur">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->labeltekstur->caption() ?></td>
            <td <?= $npd->labeltekstur->cellAttributes() ?>>
<span id="el_npd_labeltekstur">
<span<?= $npd->labeltekstur->viewAttributes() ?>>
<?= $npd->labeltekstur->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->labelprint->Visible) { // labelprint ?>
        <tr id="r_labelprint">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->labelprint->caption() ?></td>
            <td <?= $npd->labelprint->cellAttributes() ?>>
<span id="el_npd_labelprint">
<span<?= $npd->labelprint->viewAttributes() ?>>
<?= $npd->labelprint->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->labeljmlwarna->Visible) { // labeljmlwarna ?>
        <tr id="r_labeljmlwarna">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->labeljmlwarna->caption() ?></td>
            <td <?= $npd->labeljmlwarna->cellAttributes() ?>>
<span id="el_npd_labeljmlwarna">
<span<?= $npd->labeljmlwarna->viewAttributes() ?>>
<?= $npd->labeljmlwarna->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->receipt_by->Visible) { // receipt_by ?>
        <tr id="r_receipt_by">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->receipt_by->caption() ?></td>
            <td <?= $npd->receipt_by->cellAttributes() ?>>
<span id="el_npd_receipt_by">
<span<?= $npd->receipt_by->viewAttributes() ?>>
<?= $npd->receipt_by->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->approve_by->Visible) { // approve_by ?>
        <tr id="r_approve_by">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->approve_by->caption() ?></td>
            <td <?= $npd->approve_by->cellAttributes() ?>>
<span id="el_npd_approve_by">
<span<?= $npd->approve_by->viewAttributes() ?>>
<?= $npd->approve_by->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
