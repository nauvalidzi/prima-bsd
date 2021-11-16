<?php

namespace PHPMaker2021\distributor;

// Table
$npd = Container("npd");
?>
<?php if ($npd->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_npdmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
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
<?php if ($npd->kategori->Visible) { // kategori ?>
        <tr id="r_kategori">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kategori->caption() ?></td>
            <td <?= $npd->kategori->cellAttributes() ?>>
<span id="el_npd_kategori">
<span<?= $npd->kategori->viewAttributes() ?>>
<?= $npd->kategori->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->fungsi_produk->Visible) { // fungsi_produk ?>
        <tr id="r_fungsi_produk">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->fungsi_produk->caption() ?></td>
            <td <?= $npd->fungsi_produk->cellAttributes() ?>>
<span id="el_npd_fungsi_produk">
<span<?= $npd->fungsi_produk->viewAttributes() ?>>
<?= $npd->fungsi_produk->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->kualitasbarang->Visible) { // kualitasbarang ?>
        <tr id="r_kualitasbarang">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->kualitasbarang->caption() ?></td>
            <td <?= $npd->kualitasbarang->cellAttributes() ?>>
<span id="el_npd_kualitasbarang">
<span<?= $npd->kualitasbarang->viewAttributes() ?>>
<?= $npd->kualitasbarang->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->bahan_campaign->Visible) { // bahan_campaign ?>
        <tr id="r_bahan_campaign">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->bahan_campaign->caption() ?></td>
            <td <?= $npd->bahan_campaign->cellAttributes() ?>>
<span id="el_npd_bahan_campaign">
<span<?= $npd->bahan_campaign->viewAttributes() ?>>
<?= $npd->bahan_campaign->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd->ukuran_sediaan->Visible) { // ukuran_sediaan ?>
        <tr id="r_ukuran_sediaan">
            <td class="<?= $npd->TableLeftColumnClass ?>"><?= $npd->ukuran_sediaan->caption() ?></td>
            <td <?= $npd->ukuran_sediaan->cellAttributes() ?>>
<span id="el_npd_ukuran_sediaan">
<span<?= $npd->ukuran_sediaan->viewAttributes() ?>>
<?= $npd->ukuran_sediaan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
