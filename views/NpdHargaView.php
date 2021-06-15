<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdHargaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_hargaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_hargaview = currentForm = new ew.Form("fnpd_hargaview", "view");
    loadjs.done("fnpd_hargaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_harga) ew.vars.tables.npd_harga = <?= JsonEncode(GetClientVar("tables", "npd_harga")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_hargaview" id="fnpd_hargaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_harga">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <tr id="r_idnpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_idnpd"><?= $Page->idnpd->caption() ?></span></td>
        <td data-name="idnpd" <?= $Page->idnpd->cellAttributes() ?>>
<span id="el_npd_harga_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglpengajuan->Visible) { // tglpengajuan ?>
    <tr id="r_tglpengajuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_tglpengajuan"><?= $Page->tglpengajuan->caption() ?></span></td>
        <td data-name="tglpengajuan" <?= $Page->tglpengajuan->cellAttributes() ?>>
<span id="el_npd_harga_tglpengajuan">
<span<?= $Page->tglpengajuan->viewAttributes() ?>>
<?= $Page->tglpengajuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <tr id="r_idnpd_sample">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_idnpd_sample"><?= $Page->idnpd_sample->caption() ?></span></td>
        <td data-name="idnpd_sample" <?= $Page->idnpd_sample->cellAttributes() ?>>
<span id="el_npd_harga_idnpd_sample">
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuk->Visible) { // bentuk ?>
    <tr id="r_bentuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bentuk"><?= $Page->bentuk->caption() ?></span></td>
        <td data-name="bentuk" <?= $Page->bentuk->cellAttributes() ?>>
<span id="el_npd_harga_bentuk">
<span<?= $Page->bentuk->viewAttributes() ?>>
<?= $Page->bentuk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->viskositasbarang->Visible) { // viskositasbarang ?>
    <tr id="r_viskositasbarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_viskositasbarang"><?= $Page->viskositasbarang->caption() ?></span></td>
        <td data-name="viskositasbarang" <?= $Page->viskositasbarang->cellAttributes() ?>>
<span id="el_npd_harga_viskositasbarang">
<span<?= $Page->viskositasbarang->viewAttributes() ?>>
<?= $Page->viskositasbarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idaplikasibarang->Visible) { // idaplikasibarang ?>
    <tr id="r_idaplikasibarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_idaplikasibarang"><?= $Page->idaplikasibarang->caption() ?></span></td>
        <td data-name="idaplikasibarang" <?= $Page->idaplikasibarang->cellAttributes() ?>>
<span id="el_npd_harga_idaplikasibarang">
<span<?= $Page->idaplikasibarang->viewAttributes() ?>>
<?= $Page->idaplikasibarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuranwadah->Visible) { // ukuranwadah ?>
    <tr id="r_ukuranwadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_ukuranwadah"><?= $Page->ukuranwadah->caption() ?></span></td>
        <td data-name="ukuranwadah" <?= $Page->ukuranwadah->cellAttributes() ?>>
<span id="el_npd_harga_ukuranwadah">
<span<?= $Page->ukuranwadah->viewAttributes() ?>>
<?= $Page->ukuranwadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahanwadah->Visible) { // bahanwadah ?>
    <tr id="r_bahanwadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bahanwadah"><?= $Page->bahanwadah->caption() ?></span></td>
        <td data-name="bahanwadah" <?= $Page->bahanwadah->cellAttributes() ?>>
<span id="el_npd_harga_bahanwadah">
<span<?= $Page->bahanwadah->viewAttributes() ?>>
<?= $Page->bahanwadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warnawadah->Visible) { // warnawadah ?>
    <tr id="r_warnawadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_warnawadah"><?= $Page->warnawadah->caption() ?></span></td>
        <td data-name="warnawadah" <?= $Page->warnawadah->cellAttributes() ?>>
<span id="el_npd_harga_warnawadah">
<span<?= $Page->warnawadah->viewAttributes() ?>>
<?= $Page->warnawadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentukwadah->Visible) { // bentukwadah ?>
    <tr id="r_bentukwadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bentukwadah"><?= $Page->bentukwadah->caption() ?></span></td>
        <td data-name="bentukwadah" <?= $Page->bentukwadah->cellAttributes() ?>>
<span id="el_npd_harga_bentukwadah">
<span<?= $Page->bentukwadah->viewAttributes() ?>>
<?= $Page->bentukwadah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
    <tr id="r_jenistutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_jenistutup"><?= $Page->jenistutup->caption() ?></span></td>
        <td data-name="jenistutup" <?= $Page->jenistutup->cellAttributes() ?>>
<span id="el_npd_harga_jenistutup">
<span<?= $Page->jenistutup->viewAttributes() ?>>
<?= $Page->jenistutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahantutup->Visible) { // bahantutup ?>
    <tr id="r_bahantutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bahantutup"><?= $Page->bahantutup->caption() ?></span></td>
        <td data-name="bahantutup" <?= $Page->bahantutup->cellAttributes() ?>>
<span id="el_npd_harga_bahantutup">
<span<?= $Page->bahantutup->viewAttributes() ?>>
<?= $Page->bahantutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warnatutup->Visible) { // warnatutup ?>
    <tr id="r_warnatutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_warnatutup"><?= $Page->warnatutup->caption() ?></span></td>
        <td data-name="warnatutup" <?= $Page->warnatutup->cellAttributes() ?>>
<span id="el_npd_harga_warnatutup">
<span<?= $Page->warnatutup->viewAttributes() ?>>
<?= $Page->warnatutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bentuktutup->Visible) { // bentuktutup ?>
    <tr id="r_bentuktutup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bentuktutup"><?= $Page->bentuktutup->caption() ?></span></td>
        <td data-name="bentuktutup" <?= $Page->bentuktutup->cellAttributes() ?>>
<span id="el_npd_harga_bentuktutup">
<span<?= $Page->bentuktutup->viewAttributes() ?>>
<?= $Page->bentuktutup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->segel->Visible) { // segel ?>
    <tr id="r_segel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_segel"><?= $Page->segel->caption() ?></span></td>
        <td data-name="segel" <?= $Page->segel->cellAttributes() ?>>
<span id="el_npd_harga_segel">
<span<?= $Page->segel->viewAttributes() ?>>
<?= $Page->segel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->catatanprimer->Visible) { // catatanprimer ?>
    <tr id="r_catatanprimer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_catatanprimer"><?= $Page->catatanprimer->caption() ?></span></td>
        <td data-name="catatanprimer" <?= $Page->catatanprimer->cellAttributes() ?>>
<span id="el_npd_harga_catatanprimer">
<span<?= $Page->catatanprimer->viewAttributes() ?>>
<?= $Page->catatanprimer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->packingkarton->Visible) { // packingkarton ?>
    <tr id="r_packingkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_packingkarton"><?= $Page->packingkarton->caption() ?></span></td>
        <td data-name="packingkarton" <?= $Page->packingkarton->cellAttributes() ?>>
<span id="el_npd_harga_packingkarton">
<span<?= $Page->packingkarton->viewAttributes() ?>>
<?= $Page->packingkarton->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganpacking->Visible) { // keteranganpacking ?>
    <tr id="r_keteranganpacking">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganpacking"><?= $Page->keteranganpacking->caption() ?></span></td>
        <td data-name="keteranganpacking" <?= $Page->keteranganpacking->cellAttributes() ?>>
<span id="el_npd_harga_keteranganpacking">
<span<?= $Page->keteranganpacking->viewAttributes() ?>>
<?= $Page->keteranganpacking->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->beltkarton->Visible) { // beltkarton ?>
    <tr id="r_beltkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_beltkarton"><?= $Page->beltkarton->caption() ?></span></td>
        <td data-name="beltkarton" <?= $Page->beltkarton->cellAttributes() ?>>
<span id="el_npd_harga_beltkarton">
<span<?= $Page->beltkarton->viewAttributes() ?>>
<?= $Page->beltkarton->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganbelt->Visible) { // keteranganbelt ?>
    <tr id="r_keteranganbelt">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganbelt"><?= $Page->keteranganbelt->caption() ?></span></td>
        <td data-name="keteranganbelt" <?= $Page->keteranganbelt->cellAttributes() ?>>
<span id="el_npd_harga_keteranganbelt">
<span<?= $Page->keteranganbelt->viewAttributes() ?>>
<?= $Page->keteranganbelt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bariskarton->Visible) { // bariskarton ?>
    <tr id="r_bariskarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bariskarton"><?= $Page->bariskarton->caption() ?></span></td>
        <td data-name="bariskarton" <?= $Page->bariskarton->cellAttributes() ?>>
<span id="el_npd_harga_bariskarton">
<span<?= $Page->bariskarton->viewAttributes() ?>>
<?= $Page->bariskarton->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kolomkarton->Visible) { // kolomkarton ?>
    <tr id="r_kolomkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kolomkarton"><?= $Page->kolomkarton->caption() ?></span></td>
        <td data-name="kolomkarton" <?= $Page->kolomkarton->cellAttributes() ?>>
<span id="el_npd_harga_kolomkarton">
<span<?= $Page->kolomkarton->viewAttributes() ?>>
<?= $Page->kolomkarton->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->stackkarton->Visible) { // stackkarton ?>
    <tr id="r_stackkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_stackkarton"><?= $Page->stackkarton->caption() ?></span></td>
        <td data-name="stackkarton" <?= $Page->stackkarton->cellAttributes() ?>>
<span id="el_npd_harga_stackkarton">
<span<?= $Page->stackkarton->viewAttributes() ?>>
<?= $Page->stackkarton->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isikarton->Visible) { // isikarton ?>
    <tr id="r_isikarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_isikarton"><?= $Page->isikarton->caption() ?></span></td>
        <td data-name="isikarton" <?= $Page->isikarton->cellAttributes() ?>>
<span id="el_npd_harga_isikarton">
<span<?= $Page->isikarton->viewAttributes() ?>>
<?= $Page->isikarton->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenislabel->Visible) { // jenislabel ?>
    <tr id="r_jenislabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_jenislabel"><?= $Page->jenislabel->caption() ?></span></td>
        <td data-name="jenislabel" <?= $Page->jenislabel->cellAttributes() ?>>
<span id="el_npd_harga_jenislabel">
<span<?= $Page->jenislabel->viewAttributes() ?>>
<?= $Page->jenislabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganjenislabel->Visible) { // keteranganjenislabel ?>
    <tr id="r_keteranganjenislabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganjenislabel"><?= $Page->keteranganjenislabel->caption() ?></span></td>
        <td data-name="keteranganjenislabel" <?= $Page->keteranganjenislabel->cellAttributes() ?>>
<span id="el_npd_harga_keteranganjenislabel">
<span<?= $Page->keteranganjenislabel->viewAttributes() ?>>
<?= $Page->keteranganjenislabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kualitaslabel->Visible) { // kualitaslabel ?>
    <tr id="r_kualitaslabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kualitaslabel"><?= $Page->kualitaslabel->caption() ?></span></td>
        <td data-name="kualitaslabel" <?= $Page->kualitaslabel->cellAttributes() ?>>
<span id="el_npd_harga_kualitaslabel">
<span<?= $Page->kualitaslabel->viewAttributes() ?>>
<?= $Page->kualitaslabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahwarnalabel->Visible) { // jumlahwarnalabel ?>
    <tr id="r_jumlahwarnalabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_jumlahwarnalabel"><?= $Page->jumlahwarnalabel->caption() ?></span></td>
        <td data-name="jumlahwarnalabel" <?= $Page->jumlahwarnalabel->cellAttributes() ?>>
<span id="el_npd_harga_jumlahwarnalabel">
<span<?= $Page->jumlahwarnalabel->viewAttributes() ?>>
<?= $Page->jumlahwarnalabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->etiketlabel->Visible) { // etiketlabel ?>
    <tr id="r_etiketlabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_etiketlabel"><?= $Page->etiketlabel->caption() ?></span></td>
        <td data-name="etiketlabel" <?= $Page->etiketlabel->cellAttributes() ?>>
<span id="el_npd_harga_etiketlabel">
<span<?= $Page->etiketlabel->viewAttributes() ?>>
<?= $Page->etiketlabel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keteranganetiket->Visible) { // keteranganetiket ?>
    <tr id="r_keteranganetiket">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganetiket"><?= $Page->keteranganetiket->caption() ?></span></td>
        <td data-name="keteranganetiket" <?= $Page->keteranganetiket->cellAttributes() ?>>
<span id="el_npd_harga_keteranganetiket">
<span<?= $Page->keteranganetiket->viewAttributes() ?>>
<?= $Page->keteranganetiket->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kategoridelivery->Visible) { // kategoridelivery ?>
    <tr id="r_kategoridelivery">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kategoridelivery"><?= $Page->kategoridelivery->caption() ?></span></td>
        <td data-name="kategoridelivery" <?= $Page->kategoridelivery->cellAttributes() ?>>
<span id="el_npd_harga_kategoridelivery">
<span<?= $Page->kategoridelivery->viewAttributes() ?>>
<?= $Page->kategoridelivery->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamatpengiriman->Visible) { // alamatpengiriman ?>
    <tr id="r_alamatpengiriman">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_alamatpengiriman"><?= $Page->alamatpengiriman->caption() ?></span></td>
        <td data-name="alamatpengiriman" <?= $Page->alamatpengiriman->cellAttributes() ?>>
<span id="el_npd_harga_alamatpengiriman">
<span<?= $Page->alamatpengiriman->viewAttributes() ?>>
<?= $Page->alamatpengiriman->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderperdana->Visible) { // orderperdana ?>
    <tr id="r_orderperdana">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_orderperdana"><?= $Page->orderperdana->caption() ?></span></td>
        <td data-name="orderperdana" <?= $Page->orderperdana->cellAttributes() ?>>
<span id="el_npd_harga_orderperdana">
<span<?= $Page->orderperdana->viewAttributes() ?>>
<?= $Page->orderperdana->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderkontrak->Visible) { // orderkontrak ?>
    <tr id="r_orderkontrak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_orderkontrak"><?= $Page->orderkontrak->caption() ?></span></td>
        <td data-name="orderkontrak" <?= $Page->orderkontrak->cellAttributes() ?>>
<span id="el_npd_harga_orderkontrak">
<span<?= $Page->orderkontrak->viewAttributes() ?>>
<?= $Page->orderkontrak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hargapcs->Visible) { // hargapcs ?>
    <tr id="r_hargapcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_hargapcs"><?= $Page->hargapcs->caption() ?></span></td>
        <td data-name="hargapcs" <?= $Page->hargapcs->cellAttributes() ?>>
<span id="el_npd_harga_hargapcs">
<span<?= $Page->hargapcs->viewAttributes() ?>>
<?= $Page->hargapcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lampiran->Visible) { // lampiran ?>
    <tr id="r_lampiran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_lampiran"><?= $Page->lampiran->caption() ?></span></td>
        <td data-name="lampiran" <?= $Page->lampiran->cellAttributes() ?>>
<span id="el_npd_harga_lampiran">
<span<?= $Page->lampiran->viewAttributes() ?>>
<?= GetFileViewTag($Page->lampiran, $Page->lampiran->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->disetujui->Visible) { // disetujui ?>
    <tr id="r_disetujui">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_disetujui"><?= $Page->disetujui->caption() ?></span></td>
        <td data-name="disetujui" <?= $Page->disetujui->cellAttributes() ?>>
<span id="el_npd_harga_disetujui">
<span<?= $Page->disetujui->viewAttributes() ?>>
<?= $Page->disetujui->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#r_namapemesan").before('<h5 class="form-group">A. Pemesan</h5>'),$("#r_kodesample").before('<h5 class="form-group">B. Konten (Isi Sediaan)</h5>'),$("#r_ukuranwadah").before('<h5 class="form-group">C. Kemasan Primer (Wadah)</h5>'),$("#r_jenistutup").before('<h5 class="form-group">Kemasan Primer (Tutup)</h5>'),$("#r_packingkarton").before('<h5 class="form-group">D. Kemasan Sekunder</h5>'),$("#r_bariskarton").before('<h5 class="form-group">D. Kemasan Sekunder (Karton Luar)</h5>'),$("#r_jenislabel").before('<h5 class="form-group">E. Label</h5>'),$("#r_kategoridelivery").before('<h5 class="form-group">F. Delivery</h5>'),$("#r_orderperdana").before('<h5 class="form-group">G. Jumlah Order (Produksi)</h5>'),$("#r_hargapcs").before('<h5 class="form-group">H. Harga Penawaran</h5>');
});
</script>
<?php } ?>
