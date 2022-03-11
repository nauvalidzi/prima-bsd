<?php

namespace PHPMaker2021\production2;

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
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_npd_harga_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
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
<?php if ($Page->viskositas->Visible) { // viskositas ?>
    <tr id="r_viskositas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_viskositas"><?= $Page->viskositas->caption() ?></span></td>
        <td data-name="viskositas" <?= $Page->viskositas->cellAttributes() ?>>
<span id="el_npd_harga_viskositas">
<span<?= $Page->viskositas->viewAttributes() ?>>
<?= $Page->viskositas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aplikasisediaan->Visible) { // aplikasisediaan ?>
    <tr id="r_aplikasisediaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_aplikasisediaan"><?= $Page->aplikasisediaan->caption() ?></span></td>
        <td data-name="aplikasisediaan" <?= $Page->aplikasisediaan->cellAttributes() ?>>
<span id="el_npd_harga_aplikasisediaan">
<span<?= $Page->aplikasisediaan->viewAttributes() ?>>
<?= $Page->aplikasisediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <tr id="r_volume">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_volume"><?= $Page->volume->caption() ?></span></td>
        <td data-name="volume" <?= $Page->volume->cellAttributes() ?>>
<span id="el_npd_harga_volume">
<span<?= $Page->volume->viewAttributes() ?>>
<?= $Page->volume->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <tr id="r_bahanaktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_bahanaktif"><?= $Page->bahanaktif->caption() ?></span></td>
        <td data-name="bahanaktif" <?= $Page->bahanaktif->cellAttributes() ?>>
<span id="el_npd_harga_bahanaktif">
<span<?= $Page->bahanaktif->viewAttributes() ?>>
<?= $Page->bahanaktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->volumewadah->Visible) { // volumewadah ?>
    <tr id="r_volumewadah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_volumewadah"><?= $Page->volumewadah->caption() ?></span></td>
        <td data-name="volumewadah" <?= $Page->volumewadah->cellAttributes() ?>>
<span id="el_npd_harga_volumewadah">
<span<?= $Page->volumewadah->viewAttributes() ?>>
<?= $Page->volumewadah->getViewValue() ?></span>
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
<?php if ($Page->packingproduk->Visible) { // packingproduk ?>
    <tr id="r_packingproduk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_packingproduk"><?= $Page->packingproduk->caption() ?></span></td>
        <td data-name="packingproduk" <?= $Page->packingproduk->cellAttributes() ?>>
<span id="el_npd_harga_packingproduk">
<span<?= $Page->packingproduk->viewAttributes() ?>>
<?= $Page->packingproduk->getViewValue() ?></span>
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
<?php if ($Page->kartonluar->Visible) { // kartonluar ?>
    <tr id="r_kartonluar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_kartonluar"><?= $Page->kartonluar->caption() ?></span></td>
        <td data-name="kartonluar" <?= $Page->kartonluar->cellAttributes() ?>>
<span id="el_npd_harga_kartonluar">
<span<?= $Page->kartonluar->viewAttributes() ?>>
<?= $Page->kartonluar->getViewValue() ?></span>
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
<?php if ($Page->metaliklabel->Visible) { // metaliklabel ?>
    <tr id="r_metaliklabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_metaliklabel"><?= $Page->metaliklabel->caption() ?></span></td>
        <td data-name="metaliklabel" <?= $Page->metaliklabel->cellAttributes() ?>>
<span id="el_npd_harga_metaliklabel">
<span<?= $Page->metaliklabel->viewAttributes() ?>>
<?= $Page->metaliklabel->getViewValue() ?></span>
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
<?php if ($Page->keteranganlabel->Visible) { // keteranganlabel ?>
    <tr id="r_keteranganlabel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_keteranganlabel"><?= $Page->keteranganlabel->caption() ?></span></td>
        <td data-name="keteranganlabel" <?= $Page->keteranganlabel->cellAttributes() ?>>
<span id="el_npd_harga_keteranganlabel">
<span<?= $Page->keteranganlabel->viewAttributes() ?>>
<?= $Page->keteranganlabel->getViewValue() ?></span>
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
<?php if ($Page->hargaperpcs->Visible) { // hargaperpcs ?>
    <tr id="r_hargaperpcs">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_hargaperpcs"><?= $Page->hargaperpcs->caption() ?></span></td>
        <td data-name="hargaperpcs" <?= $Page->hargaperpcs->cellAttributes() ?>>
<span id="el_npd_harga_hargaperpcs">
<span<?= $Page->hargaperpcs->viewAttributes() ?>>
<?= $Page->hargaperpcs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hargaperkarton->Visible) { // hargaperkarton ?>
    <tr id="r_hargaperkarton">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_hargaperkarton"><?= $Page->hargaperkarton->caption() ?></span></td>
        <td data-name="hargaperkarton" <?= $Page->hargaperkarton->cellAttributes() ?>>
<span id="el_npd_harga_hargaperkarton">
<span<?= $Page->hargaperkarton->viewAttributes() ?>>
<?= $Page->hargaperkarton->getViewValue() ?></span>
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
<?php if ($Page->prepared_by->Visible) { // prepared_by ?>
    <tr id="r_prepared_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_prepared_by"><?= $Page->prepared_by->caption() ?></span></td>
        <td data-name="prepared_by" <?= $Page->prepared_by->cellAttributes() ?>>
<span id="el_npd_harga_prepared_by">
<span<?= $Page->prepared_by->viewAttributes() ?>>
<?= $Page->prepared_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checked_by->Visible) { // checked_by ?>
    <tr id="r_checked_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_checked_by"><?= $Page->checked_by->caption() ?></span></td>
        <td data-name="checked_by" <?= $Page->checked_by->cellAttributes() ?>>
<span id="el_npd_harga_checked_by">
<span<?= $Page->checked_by->viewAttributes() ?>>
<?= $Page->checked_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_by->Visible) { // approved_by ?>
    <tr id="r_approved_by">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_approved_by"><?= $Page->approved_by->caption() ?></span></td>
        <td data-name="approved_by" <?= $Page->approved_by->cellAttributes() ?>>
<span id="el_npd_harga_approved_by">
<span<?= $Page->approved_by->viewAttributes() ?>>
<?= $Page->approved_by->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->approved_date->Visible) { // approved_date ?>
    <tr id="r_approved_date">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_approved_date"><?= $Page->approved_date->caption() ?></span></td>
        <td data-name="approved_date" <?= $Page->approved_date->cellAttributes() ?>>
<span id="el_npd_harga_approved_date">
<span<?= $Page->approved_date->viewAttributes() ?>>
<?= $Page->approved_date->getViewValue() ?></span>
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
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_harga_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_npd_harga_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
