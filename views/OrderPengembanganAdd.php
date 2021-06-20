<?php

namespace PHPMaker2021\distributor;

// Page object
$OrderPengembanganAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var forder_pengembanganadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    forder_pengembanganadd = currentForm = new ew.Form("forder_pengembanganadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "order_pengembangan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.order_pengembangan)
        ew.vars.tables.order_pengembangan = currentTable;
    forder_pengembanganadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["cpo_jenis", [fields.cpo_jenis.visible && fields.cpo_jenis.required ? ew.Validators.required(fields.cpo_jenis.caption) : null], fields.cpo_jenis.isInvalid],
        ["ordernum", [fields.ordernum.visible && fields.ordernum.required ? ew.Validators.required(fields.ordernum.caption) : null], fields.ordernum.isInvalid],
        ["order_kode", [fields.order_kode.visible && fields.order_kode.required ? ew.Validators.required(fields.order_kode.caption) : null], fields.order_kode.isInvalid],
        ["orderterimatgl", [fields.orderterimatgl.visible && fields.orderterimatgl.required ? ew.Validators.required(fields.orderterimatgl.caption) : null, ew.Validators.datetime(0)], fields.orderterimatgl.isInvalid],
        ["produk_fungsi", [fields.produk_fungsi.visible && fields.produk_fungsi.required ? ew.Validators.required(fields.produk_fungsi.caption) : null], fields.produk_fungsi.isInvalid],
        ["produk_kualitas", [fields.produk_kualitas.visible && fields.produk_kualitas.required ? ew.Validators.required(fields.produk_kualitas.caption) : null], fields.produk_kualitas.isInvalid],
        ["produk_campaign", [fields.produk_campaign.visible && fields.produk_campaign.required ? ew.Validators.required(fields.produk_campaign.caption) : null], fields.produk_campaign.isInvalid],
        ["kemasan_satuan", [fields.kemasan_satuan.visible && fields.kemasan_satuan.required ? ew.Validators.required(fields.kemasan_satuan.caption) : null], fields.kemasan_satuan.isInvalid],
        ["ordertgl", [fields.ordertgl.visible && fields.ordertgl.required ? ew.Validators.required(fields.ordertgl.caption) : null, ew.Validators.datetime(0)], fields.ordertgl.isInvalid],
        ["custcode", [fields.custcode.visible && fields.custcode.required ? ew.Validators.required(fields.custcode.caption) : null, ew.Validators.integer], fields.custcode.isInvalid],
        ["perushnama", [fields.perushnama.visible && fields.perushnama.required ? ew.Validators.required(fields.perushnama.caption) : null], fields.perushnama.isInvalid],
        ["perushalamat", [fields.perushalamat.visible && fields.perushalamat.required ? ew.Validators.required(fields.perushalamat.caption) : null], fields.perushalamat.isInvalid],
        ["perushcp", [fields.perushcp.visible && fields.perushcp.required ? ew.Validators.required(fields.perushcp.caption) : null], fields.perushcp.isInvalid],
        ["perushjabatan", [fields.perushjabatan.visible && fields.perushjabatan.required ? ew.Validators.required(fields.perushjabatan.caption) : null], fields.perushjabatan.isInvalid],
        ["perushphone", [fields.perushphone.visible && fields.perushphone.required ? ew.Validators.required(fields.perushphone.caption) : null], fields.perushphone.isInvalid],
        ["perushmobile", [fields.perushmobile.visible && fields.perushmobile.required ? ew.Validators.required(fields.perushmobile.caption) : null], fields.perushmobile.isInvalid],
        ["bencmark", [fields.bencmark.visible && fields.bencmark.required ? ew.Validators.required(fields.bencmark.caption) : null], fields.bencmark.isInvalid],
        ["kategoriproduk", [fields.kategoriproduk.visible && fields.kategoriproduk.required ? ew.Validators.required(fields.kategoriproduk.caption) : null], fields.kategoriproduk.isInvalid],
        ["jenisproduk", [fields.jenisproduk.visible && fields.jenisproduk.required ? ew.Validators.required(fields.jenisproduk.caption) : null], fields.jenisproduk.isInvalid],
        ["bentuksediaan", [fields.bentuksediaan.visible && fields.bentuksediaan.required ? ew.Validators.required(fields.bentuksediaan.caption) : null], fields.bentuksediaan.isInvalid],
        ["sediaan_ukuran", [fields.sediaan_ukuran.visible && fields.sediaan_ukuran.required ? ew.Validators.required(fields.sediaan_ukuran.caption) : null, ew.Validators.float], fields.sediaan_ukuran.isInvalid],
        ["sediaan_ukuran_satuan", [fields.sediaan_ukuran_satuan.visible && fields.sediaan_ukuran_satuan.required ? ew.Validators.required(fields.sediaan_ukuran_satuan.caption) : null], fields.sediaan_ukuran_satuan.isInvalid],
        ["produk_viskositas", [fields.produk_viskositas.visible && fields.produk_viskositas.required ? ew.Validators.required(fields.produk_viskositas.caption) : null], fields.produk_viskositas.isInvalid],
        ["konsepproduk", [fields.konsepproduk.visible && fields.konsepproduk.required ? ew.Validators.required(fields.konsepproduk.caption) : null], fields.konsepproduk.isInvalid],
        ["fragrance", [fields.fragrance.visible && fields.fragrance.required ? ew.Validators.required(fields.fragrance.caption) : null], fields.fragrance.isInvalid],
        ["aroma", [fields.aroma.visible && fields.aroma.required ? ew.Validators.required(fields.aroma.caption) : null], fields.aroma.isInvalid],
        ["bahanaktif", [fields.bahanaktif.visible && fields.bahanaktif.required ? ew.Validators.required(fields.bahanaktif.caption) : null], fields.bahanaktif.isInvalid],
        ["warna", [fields.warna.visible && fields.warna.required ? ew.Validators.required(fields.warna.caption) : null], fields.warna.isInvalid],
        ["produk_warna_jenis", [fields.produk_warna_jenis.visible && fields.produk_warna_jenis.required ? ew.Validators.required(fields.produk_warna_jenis.caption) : null], fields.produk_warna_jenis.isInvalid],
        ["aksesoris", [fields.aksesoris.visible && fields.aksesoris.required ? ew.Validators.required(fields.aksesoris.caption) : null], fields.aksesoris.isInvalid],
        ["produk_lainlain", [fields.produk_lainlain.visible && fields.produk_lainlain.required ? ew.Validators.required(fields.produk_lainlain.caption) : null], fields.produk_lainlain.isInvalid],
        ["statusproduk", [fields.statusproduk.visible && fields.statusproduk.required ? ew.Validators.required(fields.statusproduk.caption) : null], fields.statusproduk.isInvalid],
        ["parfum", [fields.parfum.visible && fields.parfum.required ? ew.Validators.required(fields.parfum.caption) : null], fields.parfum.isInvalid],
        ["catatan", [fields.catatan.visible && fields.catatan.required ? ew.Validators.required(fields.catatan.caption) : null], fields.catatan.isInvalid],
        ["rencanakemasan", [fields.rencanakemasan.visible && fields.rencanakemasan.required ? ew.Validators.required(fields.rencanakemasan.caption) : null], fields.rencanakemasan.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["ekspetasiharga", [fields.ekspetasiharga.visible && fields.ekspetasiharga.required ? ew.Validators.required(fields.ekspetasiharga.caption) : null, ew.Validators.float], fields.ekspetasiharga.isInvalid],
        ["kemasan", [fields.kemasan.visible && fields.kemasan.required ? ew.Validators.required(fields.kemasan.caption) : null], fields.kemasan.isInvalid],
        ["volume", [fields.volume.visible && fields.volume.required ? ew.Validators.required(fields.volume.caption) : null, ew.Validators.float], fields.volume.isInvalid],
        ["jenistutup", [fields.jenistutup.visible && fields.jenistutup.required ? ew.Validators.required(fields.jenistutup.caption) : null], fields.jenistutup.isInvalid],
        ["catatanpackaging", [fields.catatanpackaging.visible && fields.catatanpackaging.required ? ew.Validators.required(fields.catatanpackaging.caption) : null], fields.catatanpackaging.isInvalid],
        ["infopackaging", [fields.infopackaging.visible && fields.infopackaging.required ? ew.Validators.required(fields.infopackaging.caption) : null], fields.infopackaging.isInvalid],
        ["ukuran", [fields.ukuran.visible && fields.ukuran.required ? ew.Validators.required(fields.ukuran.caption) : null, ew.Validators.integer], fields.ukuran.isInvalid],
        ["desainprodukkemasan", [fields.desainprodukkemasan.visible && fields.desainprodukkemasan.required ? ew.Validators.required(fields.desainprodukkemasan.caption) : null], fields.desainprodukkemasan.isInvalid],
        ["desaindiinginkan", [fields.desaindiinginkan.visible && fields.desaindiinginkan.required ? ew.Validators.required(fields.desaindiinginkan.caption) : null], fields.desaindiinginkan.isInvalid],
        ["mereknotifikasi", [fields.mereknotifikasi.visible && fields.mereknotifikasi.required ? ew.Validators.required(fields.mereknotifikasi.caption) : null], fields.mereknotifikasi.isInvalid],
        ["kategoristatus", [fields.kategoristatus.visible && fields.kategoristatus.required ? ew.Validators.required(fields.kategoristatus.caption) : null], fields.kategoristatus.isInvalid],
        ["kemasan_ukuran_satuan", [fields.kemasan_ukuran_satuan.visible && fields.kemasan_ukuran_satuan.required ? ew.Validators.required(fields.kemasan_ukuran_satuan.caption) : null], fields.kemasan_ukuran_satuan.isInvalid],
        ["notifikasicatatan", [fields.notifikasicatatan.visible && fields.notifikasicatatan.required ? ew.Validators.required(fields.notifikasicatatan.caption) : null], fields.notifikasicatatan.isInvalid],
        ["label_ukuran", [fields.label_ukuran.visible && fields.label_ukuran.required ? ew.Validators.required(fields.label_ukuran.caption) : null], fields.label_ukuran.isInvalid],
        ["infolabel", [fields.infolabel.visible && fields.infolabel.required ? ew.Validators.required(fields.infolabel.caption) : null], fields.infolabel.isInvalid],
        ["labelkualitas", [fields.labelkualitas.visible && fields.labelkualitas.required ? ew.Validators.required(fields.labelkualitas.caption) : null], fields.labelkualitas.isInvalid],
        ["labelposisi", [fields.labelposisi.visible && fields.labelposisi.required ? ew.Validators.required(fields.labelposisi.caption) : null], fields.labelposisi.isInvalid],
        ["labelcatatan", [fields.labelcatatan.visible && fields.labelcatatan.required ? ew.Validators.required(fields.labelcatatan.caption) : null], fields.labelcatatan.isInvalid],
        ["dibuatdi", [fields.dibuatdi.visible && fields.dibuatdi.required ? ew.Validators.required(fields.dibuatdi.caption) : null], fields.dibuatdi.isInvalid],
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.datetime(0)], fields.tanggal.isInvalid],
        ["penerima", [fields.penerima.visible && fields.penerima.required ? ew.Validators.required(fields.penerima.caption) : null, ew.Validators.integer], fields.penerima.isInvalid],
        ["createat", [fields.createat.visible && fields.createat.required ? ew.Validators.required(fields.createat.caption) : null, ew.Validators.datetime(0)], fields.createat.isInvalid],
        ["createby", [fields.createby.visible && fields.createby.required ? ew.Validators.required(fields.createby.caption) : null, ew.Validators.integer], fields.createby.isInvalid],
        ["statusdokumen", [fields.statusdokumen.visible && fields.statusdokumen.required ? ew.Validators.required(fields.statusdokumen.caption) : null], fields.statusdokumen.isInvalid],
        ["update_at", [fields.update_at.visible && fields.update_at.required ? ew.Validators.required(fields.update_at.caption) : null, ew.Validators.datetime(0)], fields.update_at.isInvalid],
        ["status_data", [fields.status_data.visible && fields.status_data.required ? ew.Validators.required(fields.status_data.caption) : null], fields.status_data.isInvalid],
        ["harga_rnd", [fields.harga_rnd.visible && fields.harga_rnd.required ? ew.Validators.required(fields.harga_rnd.caption) : null, ew.Validators.float], fields.harga_rnd.isInvalid],
        ["aplikasi_sediaan", [fields.aplikasi_sediaan.visible && fields.aplikasi_sediaan.required ? ew.Validators.required(fields.aplikasi_sediaan.caption) : null], fields.aplikasi_sediaan.isInvalid],
        ["hu_hrg_isi", [fields.hu_hrg_isi.visible && fields.hu_hrg_isi.required ? ew.Validators.required(fields.hu_hrg_isi.caption) : null, ew.Validators.float], fields.hu_hrg_isi.isInvalid],
        ["hu_hrg_isi_pro", [fields.hu_hrg_isi_pro.visible && fields.hu_hrg_isi_pro.required ? ew.Validators.required(fields.hu_hrg_isi_pro.caption) : null, ew.Validators.float], fields.hu_hrg_isi_pro.isInvalid],
        ["hu_hrg_kms_primer", [fields.hu_hrg_kms_primer.visible && fields.hu_hrg_kms_primer.required ? ew.Validators.required(fields.hu_hrg_kms_primer.caption) : null, ew.Validators.float], fields.hu_hrg_kms_primer.isInvalid],
        ["hu_hrg_kms_primer_pro", [fields.hu_hrg_kms_primer_pro.visible && fields.hu_hrg_kms_primer_pro.required ? ew.Validators.required(fields.hu_hrg_kms_primer_pro.caption) : null, ew.Validators.float], fields.hu_hrg_kms_primer_pro.isInvalid],
        ["hu_hrg_kms_sekunder", [fields.hu_hrg_kms_sekunder.visible && fields.hu_hrg_kms_sekunder.required ? ew.Validators.required(fields.hu_hrg_kms_sekunder.caption) : null, ew.Validators.float], fields.hu_hrg_kms_sekunder.isInvalid],
        ["hu_hrg_kms_sekunder_pro", [fields.hu_hrg_kms_sekunder_pro.visible && fields.hu_hrg_kms_sekunder_pro.required ? ew.Validators.required(fields.hu_hrg_kms_sekunder_pro.caption) : null, ew.Validators.float], fields.hu_hrg_kms_sekunder_pro.isInvalid],
        ["hu_hrg_label", [fields.hu_hrg_label.visible && fields.hu_hrg_label.required ? ew.Validators.required(fields.hu_hrg_label.caption) : null, ew.Validators.float], fields.hu_hrg_label.isInvalid],
        ["hu_hrg_label_pro", [fields.hu_hrg_label_pro.visible && fields.hu_hrg_label_pro.required ? ew.Validators.required(fields.hu_hrg_label_pro.caption) : null, ew.Validators.float], fields.hu_hrg_label_pro.isInvalid],
        ["hu_hrg_total", [fields.hu_hrg_total.visible && fields.hu_hrg_total.required ? ew.Validators.required(fields.hu_hrg_total.caption) : null, ew.Validators.float], fields.hu_hrg_total.isInvalid],
        ["hu_hrg_total_pro", [fields.hu_hrg_total_pro.visible && fields.hu_hrg_total_pro.required ? ew.Validators.required(fields.hu_hrg_total_pro.caption) : null, ew.Validators.float], fields.hu_hrg_total_pro.isInvalid],
        ["hl_hrg_isi", [fields.hl_hrg_isi.visible && fields.hl_hrg_isi.required ? ew.Validators.required(fields.hl_hrg_isi.caption) : null, ew.Validators.float], fields.hl_hrg_isi.isInvalid],
        ["hl_hrg_isi_pro", [fields.hl_hrg_isi_pro.visible && fields.hl_hrg_isi_pro.required ? ew.Validators.required(fields.hl_hrg_isi_pro.caption) : null, ew.Validators.float], fields.hl_hrg_isi_pro.isInvalid],
        ["hl_hrg_kms_primer", [fields.hl_hrg_kms_primer.visible && fields.hl_hrg_kms_primer.required ? ew.Validators.required(fields.hl_hrg_kms_primer.caption) : null, ew.Validators.float], fields.hl_hrg_kms_primer.isInvalid],
        ["hl_hrg_kms_primer_pro", [fields.hl_hrg_kms_primer_pro.visible && fields.hl_hrg_kms_primer_pro.required ? ew.Validators.required(fields.hl_hrg_kms_primer_pro.caption) : null, ew.Validators.float], fields.hl_hrg_kms_primer_pro.isInvalid],
        ["hl_hrg_kms_sekunder", [fields.hl_hrg_kms_sekunder.visible && fields.hl_hrg_kms_sekunder.required ? ew.Validators.required(fields.hl_hrg_kms_sekunder.caption) : null, ew.Validators.float], fields.hl_hrg_kms_sekunder.isInvalid],
        ["hl_hrg_kms_sekunder_pro", [fields.hl_hrg_kms_sekunder_pro.visible && fields.hl_hrg_kms_sekunder_pro.required ? ew.Validators.required(fields.hl_hrg_kms_sekunder_pro.caption) : null, ew.Validators.float], fields.hl_hrg_kms_sekunder_pro.isInvalid],
        ["hl_hrg_label", [fields.hl_hrg_label.visible && fields.hl_hrg_label.required ? ew.Validators.required(fields.hl_hrg_label.caption) : null, ew.Validators.float], fields.hl_hrg_label.isInvalid],
        ["hl_hrg_label_pro", [fields.hl_hrg_label_pro.visible && fields.hl_hrg_label_pro.required ? ew.Validators.required(fields.hl_hrg_label_pro.caption) : null, ew.Validators.float], fields.hl_hrg_label_pro.isInvalid],
        ["hl_hrg_total", [fields.hl_hrg_total.visible && fields.hl_hrg_total.required ? ew.Validators.required(fields.hl_hrg_total.caption) : null, ew.Validators.float], fields.hl_hrg_total.isInvalid],
        ["hl_hrg_total_pro", [fields.hl_hrg_total_pro.visible && fields.hl_hrg_total_pro.required ? ew.Validators.required(fields.hl_hrg_total_pro.caption) : null, ew.Validators.float], fields.hl_hrg_total_pro.isInvalid],
        ["bs_bahan_aktif_tick", [fields.bs_bahan_aktif_tick.visible && fields.bs_bahan_aktif_tick.required ? ew.Validators.required(fields.bs_bahan_aktif_tick.caption) : null], fields.bs_bahan_aktif_tick.isInvalid],
        ["bs_bahan_aktif", [fields.bs_bahan_aktif.visible && fields.bs_bahan_aktif.required ? ew.Validators.required(fields.bs_bahan_aktif.caption) : null], fields.bs_bahan_aktif.isInvalid],
        ["bs_bahan_lain", [fields.bs_bahan_lain.visible && fields.bs_bahan_lain.required ? ew.Validators.required(fields.bs_bahan_lain.caption) : null], fields.bs_bahan_lain.isInvalid],
        ["bs_parfum", [fields.bs_parfum.visible && fields.bs_parfum.required ? ew.Validators.required(fields.bs_parfum.caption) : null], fields.bs_parfum.isInvalid],
        ["bs_estetika", [fields.bs_estetika.visible && fields.bs_estetika.required ? ew.Validators.required(fields.bs_estetika.caption) : null], fields.bs_estetika.isInvalid],
        ["bs_kms_wadah", [fields.bs_kms_wadah.visible && fields.bs_kms_wadah.required ? ew.Validators.required(fields.bs_kms_wadah.caption) : null], fields.bs_kms_wadah.isInvalid],
        ["bs_kms_tutup", [fields.bs_kms_tutup.visible && fields.bs_kms_tutup.required ? ew.Validators.required(fields.bs_kms_tutup.caption) : null], fields.bs_kms_tutup.isInvalid],
        ["bs_kms_sekunder", [fields.bs_kms_sekunder.visible && fields.bs_kms_sekunder.required ? ew.Validators.required(fields.bs_kms_sekunder.caption) : null], fields.bs_kms_sekunder.isInvalid],
        ["bs_label_desain", [fields.bs_label_desain.visible && fields.bs_label_desain.required ? ew.Validators.required(fields.bs_label_desain.caption) : null], fields.bs_label_desain.isInvalid],
        ["bs_label_cetak", [fields.bs_label_cetak.visible && fields.bs_label_cetak.required ? ew.Validators.required(fields.bs_label_cetak.caption) : null], fields.bs_label_cetak.isInvalid],
        ["bs_label_lain", [fields.bs_label_lain.visible && fields.bs_label_lain.required ? ew.Validators.required(fields.bs_label_lain.caption) : null], fields.bs_label_lain.isInvalid],
        ["dlv_pickup", [fields.dlv_pickup.visible && fields.dlv_pickup.required ? ew.Validators.required(fields.dlv_pickup.caption) : null], fields.dlv_pickup.isInvalid],
        ["dlv_singlepoint", [fields.dlv_singlepoint.visible && fields.dlv_singlepoint.required ? ew.Validators.required(fields.dlv_singlepoint.caption) : null], fields.dlv_singlepoint.isInvalid],
        ["dlv_multipoint", [fields.dlv_multipoint.visible && fields.dlv_multipoint.required ? ew.Validators.required(fields.dlv_multipoint.caption) : null], fields.dlv_multipoint.isInvalid],
        ["dlv_multipoint_jml", [fields.dlv_multipoint_jml.visible && fields.dlv_multipoint_jml.required ? ew.Validators.required(fields.dlv_multipoint_jml.caption) : null], fields.dlv_multipoint_jml.isInvalid],
        ["dlv_term_lain", [fields.dlv_term_lain.visible && fields.dlv_term_lain.required ? ew.Validators.required(fields.dlv_term_lain.caption) : null], fields.dlv_term_lain.isInvalid],
        ["catatan_khusus", [fields.catatan_khusus.visible && fields.catatan_khusus.required ? ew.Validators.required(fields.catatan_khusus.caption) : null], fields.catatan_khusus.isInvalid],
        ["aju_tgl", [fields.aju_tgl.visible && fields.aju_tgl.required ? ew.Validators.required(fields.aju_tgl.caption) : null, ew.Validators.datetime(0)], fields.aju_tgl.isInvalid],
        ["aju_oleh", [fields.aju_oleh.visible && fields.aju_oleh.required ? ew.Validators.required(fields.aju_oleh.caption) : null, ew.Validators.integer], fields.aju_oleh.isInvalid],
        ["proses_tgl", [fields.proses_tgl.visible && fields.proses_tgl.required ? ew.Validators.required(fields.proses_tgl.caption) : null, ew.Validators.datetime(0)], fields.proses_tgl.isInvalid],
        ["proses_oleh", [fields.proses_oleh.visible && fields.proses_oleh.required ? ew.Validators.required(fields.proses_oleh.caption) : null, ew.Validators.integer], fields.proses_oleh.isInvalid],
        ["revisi_tgl", [fields.revisi_tgl.visible && fields.revisi_tgl.required ? ew.Validators.required(fields.revisi_tgl.caption) : null, ew.Validators.datetime(0)], fields.revisi_tgl.isInvalid],
        ["revisi_oleh", [fields.revisi_oleh.visible && fields.revisi_oleh.required ? ew.Validators.required(fields.revisi_oleh.caption) : null, ew.Validators.integer], fields.revisi_oleh.isInvalid],
        ["revisi_akun_tgl", [fields.revisi_akun_tgl.visible && fields.revisi_akun_tgl.required ? ew.Validators.required(fields.revisi_akun_tgl.caption) : null, ew.Validators.datetime(0)], fields.revisi_akun_tgl.isInvalid],
        ["revisi_akun_oleh", [fields.revisi_akun_oleh.visible && fields.revisi_akun_oleh.required ? ew.Validators.required(fields.revisi_akun_oleh.caption) : null, ew.Validators.integer], fields.revisi_akun_oleh.isInvalid],
        ["revisi_rnd_tgl", [fields.revisi_rnd_tgl.visible && fields.revisi_rnd_tgl.required ? ew.Validators.required(fields.revisi_rnd_tgl.caption) : null, ew.Validators.datetime(0)], fields.revisi_rnd_tgl.isInvalid],
        ["revisi_rnd_oleh", [fields.revisi_rnd_oleh.visible && fields.revisi_rnd_oleh.required ? ew.Validators.required(fields.revisi_rnd_oleh.caption) : null, ew.Validators.integer], fields.revisi_rnd_oleh.isInvalid],
        ["rnd_tgl", [fields.rnd_tgl.visible && fields.rnd_tgl.required ? ew.Validators.required(fields.rnd_tgl.caption) : null, ew.Validators.datetime(0)], fields.rnd_tgl.isInvalid],
        ["rnd_oleh", [fields.rnd_oleh.visible && fields.rnd_oleh.required ? ew.Validators.required(fields.rnd_oleh.caption) : null, ew.Validators.integer], fields.rnd_oleh.isInvalid],
        ["ap_tgl", [fields.ap_tgl.visible && fields.ap_tgl.required ? ew.Validators.required(fields.ap_tgl.caption) : null, ew.Validators.datetime(0)], fields.ap_tgl.isInvalid],
        ["ap_oleh", [fields.ap_oleh.visible && fields.ap_oleh.required ? ew.Validators.required(fields.ap_oleh.caption) : null, ew.Validators.integer], fields.ap_oleh.isInvalid],
        ["batal_tgl", [fields.batal_tgl.visible && fields.batal_tgl.required ? ew.Validators.required(fields.batal_tgl.caption) : null, ew.Validators.datetime(0)], fields.batal_tgl.isInvalid],
        ["batal_oleh", [fields.batal_oleh.visible && fields.batal_oleh.required ? ew.Validators.required(fields.batal_oleh.caption) : null, ew.Validators.integer], fields.batal_oleh.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = forder_pengembanganadd,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    forder_pengembanganadd.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    forder_pengembanganadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    forder_pengembanganadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("forder_pengembanganadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="forder_pengembanganadd" id="forder_pengembanganadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="order_pengembangan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_order_pengembangan_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_id"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<template id="tpx_order_pengembangan_id"><span id="el_order_pengembangan_id">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_id" name="x_id" id="x_id" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cpo_jenis->Visible) { // cpo_jenis ?>
    <div id="r_cpo_jenis" class="form-group row">
        <label id="elh_order_pengembangan_cpo_jenis" for="x_cpo_jenis" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_cpo_jenis"><?= $Page->cpo_jenis->caption() ?><?= $Page->cpo_jenis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->cpo_jenis->cellAttributes() ?>>
<template id="tpx_order_pengembangan_cpo_jenis"><span id="el_order_pengembangan_cpo_jenis">
<input type="<?= $Page->cpo_jenis->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_cpo_jenis" name="x_cpo_jenis" id="x_cpo_jenis" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->cpo_jenis->getPlaceHolder()) ?>" value="<?= $Page->cpo_jenis->EditValue ?>"<?= $Page->cpo_jenis->editAttributes() ?> aria-describedby="x_cpo_jenis_help">
<?= $Page->cpo_jenis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cpo_jenis->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ordernum->Visible) { // ordernum ?>
    <div id="r_ordernum" class="form-group row">
        <label id="elh_order_pengembangan_ordernum" for="x_ordernum" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_ordernum"><?= $Page->ordernum->caption() ?><?= $Page->ordernum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ordernum->cellAttributes() ?>>
<template id="tpx_order_pengembangan_ordernum"><span id="el_order_pengembangan_ordernum">
<input type="<?= $Page->ordernum->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_ordernum" name="x_ordernum" id="x_ordernum" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ordernum->getPlaceHolder()) ?>" value="<?= $Page->ordernum->EditValue ?>"<?= $Page->ordernum->editAttributes() ?> aria-describedby="x_ordernum_help">
<?= $Page->ordernum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ordernum->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->order_kode->Visible) { // order_kode ?>
    <div id="r_order_kode" class="form-group row">
        <label id="elh_order_pengembangan_order_kode" for="x_order_kode" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_order_kode"><?= $Page->order_kode->caption() ?><?= $Page->order_kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->order_kode->cellAttributes() ?>>
<template id="tpx_order_pengembangan_order_kode"><span id="el_order_pengembangan_order_kode">
<input type="<?= $Page->order_kode->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_order_kode" name="x_order_kode" id="x_order_kode" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->order_kode->getPlaceHolder()) ?>" value="<?= $Page->order_kode->EditValue ?>"<?= $Page->order_kode->editAttributes() ?> aria-describedby="x_order_kode_help">
<?= $Page->order_kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->order_kode->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orderterimatgl->Visible) { // orderterimatgl ?>
    <div id="r_orderterimatgl" class="form-group row">
        <label id="elh_order_pengembangan_orderterimatgl" for="x_orderterimatgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_orderterimatgl"><?= $Page->orderterimatgl->caption() ?><?= $Page->orderterimatgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->orderterimatgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_orderterimatgl"><span id="el_order_pengembangan_orderterimatgl">
<input type="<?= $Page->orderterimatgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_orderterimatgl" name="x_orderterimatgl" id="x_orderterimatgl" placeholder="<?= HtmlEncode($Page->orderterimatgl->getPlaceHolder()) ?>" value="<?= $Page->orderterimatgl->EditValue ?>"<?= $Page->orderterimatgl->editAttributes() ?> aria-describedby="x_orderterimatgl_help">
<?= $Page->orderterimatgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orderterimatgl->getErrorMessage() ?></div>
<?php if (!$Page->orderterimatgl->ReadOnly && !$Page->orderterimatgl->Disabled && !isset($Page->orderterimatgl->EditAttrs["readonly"]) && !isset($Page->orderterimatgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_orderterimatgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk_fungsi->Visible) { // produk_fungsi ?>
    <div id="r_produk_fungsi" class="form-group row">
        <label id="elh_order_pengembangan_produk_fungsi" for="x_produk_fungsi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_produk_fungsi"><?= $Page->produk_fungsi->caption() ?><?= $Page->produk_fungsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk_fungsi->cellAttributes() ?>>
<template id="tpx_order_pengembangan_produk_fungsi"><span id="el_order_pengembangan_produk_fungsi">
<input type="<?= $Page->produk_fungsi->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_produk_fungsi" name="x_produk_fungsi" id="x_produk_fungsi" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->produk_fungsi->getPlaceHolder()) ?>" value="<?= $Page->produk_fungsi->EditValue ?>"<?= $Page->produk_fungsi->editAttributes() ?> aria-describedby="x_produk_fungsi_help">
<?= $Page->produk_fungsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk_fungsi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk_kualitas->Visible) { // produk_kualitas ?>
    <div id="r_produk_kualitas" class="form-group row">
        <label id="elh_order_pengembangan_produk_kualitas" for="x_produk_kualitas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_produk_kualitas"><?= $Page->produk_kualitas->caption() ?><?= $Page->produk_kualitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk_kualitas->cellAttributes() ?>>
<template id="tpx_order_pengembangan_produk_kualitas"><span id="el_order_pengembangan_produk_kualitas">
<input type="<?= $Page->produk_kualitas->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_produk_kualitas" name="x_produk_kualitas" id="x_produk_kualitas" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->produk_kualitas->getPlaceHolder()) ?>" value="<?= $Page->produk_kualitas->EditValue ?>"<?= $Page->produk_kualitas->editAttributes() ?> aria-describedby="x_produk_kualitas_help">
<?= $Page->produk_kualitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk_kualitas->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk_campaign->Visible) { // produk_campaign ?>
    <div id="r_produk_campaign" class="form-group row">
        <label id="elh_order_pengembangan_produk_campaign" for="x_produk_campaign" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_produk_campaign"><?= $Page->produk_campaign->caption() ?><?= $Page->produk_campaign->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk_campaign->cellAttributes() ?>>
<template id="tpx_order_pengembangan_produk_campaign"><span id="el_order_pengembangan_produk_campaign">
<input type="<?= $Page->produk_campaign->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_produk_campaign" name="x_produk_campaign" id="x_produk_campaign" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->produk_campaign->getPlaceHolder()) ?>" value="<?= $Page->produk_campaign->EditValue ?>"<?= $Page->produk_campaign->editAttributes() ?> aria-describedby="x_produk_campaign_help">
<?= $Page->produk_campaign->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk_campaign->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasan_satuan->Visible) { // kemasan_satuan ?>
    <div id="r_kemasan_satuan" class="form-group row">
        <label id="elh_order_pengembangan_kemasan_satuan" for="x_kemasan_satuan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_kemasan_satuan"><?= $Page->kemasan_satuan->caption() ?><?= $Page->kemasan_satuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasan_satuan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_kemasan_satuan"><span id="el_order_pengembangan_kemasan_satuan">
<input type="<?= $Page->kemasan_satuan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_kemasan_satuan" name="x_kemasan_satuan" id="x_kemasan_satuan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kemasan_satuan->getPlaceHolder()) ?>" value="<?= $Page->kemasan_satuan->EditValue ?>"<?= $Page->kemasan_satuan->editAttributes() ?> aria-describedby="x_kemasan_satuan_help">
<?= $Page->kemasan_satuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasan_satuan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ordertgl->Visible) { // ordertgl ?>
    <div id="r_ordertgl" class="form-group row">
        <label id="elh_order_pengembangan_ordertgl" for="x_ordertgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_ordertgl"><?= $Page->ordertgl->caption() ?><?= $Page->ordertgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ordertgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_ordertgl"><span id="el_order_pengembangan_ordertgl">
<input type="<?= $Page->ordertgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_ordertgl" name="x_ordertgl" id="x_ordertgl" placeholder="<?= HtmlEncode($Page->ordertgl->getPlaceHolder()) ?>" value="<?= $Page->ordertgl->EditValue ?>"<?= $Page->ordertgl->editAttributes() ?> aria-describedby="x_ordertgl_help">
<?= $Page->ordertgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ordertgl->getErrorMessage() ?></div>
<?php if (!$Page->ordertgl->ReadOnly && !$Page->ordertgl->Disabled && !isset($Page->ordertgl->EditAttrs["readonly"]) && !isset($Page->ordertgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_ordertgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->custcode->Visible) { // custcode ?>
    <div id="r_custcode" class="form-group row">
        <label id="elh_order_pengembangan_custcode" for="x_custcode" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_custcode"><?= $Page->custcode->caption() ?><?= $Page->custcode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->custcode->cellAttributes() ?>>
<template id="tpx_order_pengembangan_custcode"><span id="el_order_pengembangan_custcode">
<input type="<?= $Page->custcode->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_custcode" name="x_custcode" id="x_custcode" size="30" placeholder="<?= HtmlEncode($Page->custcode->getPlaceHolder()) ?>" value="<?= $Page->custcode->EditValue ?>"<?= $Page->custcode->editAttributes() ?> aria-describedby="x_custcode_help">
<?= $Page->custcode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->custcode->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perushnama->Visible) { // perushnama ?>
    <div id="r_perushnama" class="form-group row">
        <label id="elh_order_pengembangan_perushnama" for="x_perushnama" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_perushnama"><?= $Page->perushnama->caption() ?><?= $Page->perushnama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perushnama->cellAttributes() ?>>
<template id="tpx_order_pengembangan_perushnama"><span id="el_order_pengembangan_perushnama">
<input type="<?= $Page->perushnama->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_perushnama" name="x_perushnama" id="x_perushnama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->perushnama->getPlaceHolder()) ?>" value="<?= $Page->perushnama->EditValue ?>"<?= $Page->perushnama->editAttributes() ?> aria-describedby="x_perushnama_help">
<?= $Page->perushnama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->perushnama->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perushalamat->Visible) { // perushalamat ?>
    <div id="r_perushalamat" class="form-group row">
        <label id="elh_order_pengembangan_perushalamat" for="x_perushalamat" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_perushalamat"><?= $Page->perushalamat->caption() ?><?= $Page->perushalamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perushalamat->cellAttributes() ?>>
<template id="tpx_order_pengembangan_perushalamat"><span id="el_order_pengembangan_perushalamat">
<input type="<?= $Page->perushalamat->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_perushalamat" name="x_perushalamat" id="x_perushalamat" size="30" maxlength="250" placeholder="<?= HtmlEncode($Page->perushalamat->getPlaceHolder()) ?>" value="<?= $Page->perushalamat->EditValue ?>"<?= $Page->perushalamat->editAttributes() ?> aria-describedby="x_perushalamat_help">
<?= $Page->perushalamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->perushalamat->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perushcp->Visible) { // perushcp ?>
    <div id="r_perushcp" class="form-group row">
        <label id="elh_order_pengembangan_perushcp" for="x_perushcp" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_perushcp"><?= $Page->perushcp->caption() ?><?= $Page->perushcp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perushcp->cellAttributes() ?>>
<template id="tpx_order_pengembangan_perushcp"><span id="el_order_pengembangan_perushcp">
<input type="<?= $Page->perushcp->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_perushcp" name="x_perushcp" id="x_perushcp" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->perushcp->getPlaceHolder()) ?>" value="<?= $Page->perushcp->EditValue ?>"<?= $Page->perushcp->editAttributes() ?> aria-describedby="x_perushcp_help">
<?= $Page->perushcp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->perushcp->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perushjabatan->Visible) { // perushjabatan ?>
    <div id="r_perushjabatan" class="form-group row">
        <label id="elh_order_pengembangan_perushjabatan" for="x_perushjabatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_perushjabatan"><?= $Page->perushjabatan->caption() ?><?= $Page->perushjabatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perushjabatan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_perushjabatan"><span id="el_order_pengembangan_perushjabatan">
<input type="<?= $Page->perushjabatan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_perushjabatan" name="x_perushjabatan" id="x_perushjabatan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->perushjabatan->getPlaceHolder()) ?>" value="<?= $Page->perushjabatan->EditValue ?>"<?= $Page->perushjabatan->editAttributes() ?> aria-describedby="x_perushjabatan_help">
<?= $Page->perushjabatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->perushjabatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perushphone->Visible) { // perushphone ?>
    <div id="r_perushphone" class="form-group row">
        <label id="elh_order_pengembangan_perushphone" for="x_perushphone" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_perushphone"><?= $Page->perushphone->caption() ?><?= $Page->perushphone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perushphone->cellAttributes() ?>>
<template id="tpx_order_pengembangan_perushphone"><span id="el_order_pengembangan_perushphone">
<input type="<?= $Page->perushphone->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_perushphone" name="x_perushphone" id="x_perushphone" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->perushphone->getPlaceHolder()) ?>" value="<?= $Page->perushphone->EditValue ?>"<?= $Page->perushphone->editAttributes() ?> aria-describedby="x_perushphone_help">
<?= $Page->perushphone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->perushphone->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perushmobile->Visible) { // perushmobile ?>
    <div id="r_perushmobile" class="form-group row">
        <label id="elh_order_pengembangan_perushmobile" for="x_perushmobile" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_perushmobile"><?= $Page->perushmobile->caption() ?><?= $Page->perushmobile->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perushmobile->cellAttributes() ?>>
<template id="tpx_order_pengembangan_perushmobile"><span id="el_order_pengembangan_perushmobile">
<input type="<?= $Page->perushmobile->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_perushmobile" name="x_perushmobile" id="x_perushmobile" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->perushmobile->getPlaceHolder()) ?>" value="<?= $Page->perushmobile->EditValue ?>"<?= $Page->perushmobile->editAttributes() ?> aria-describedby="x_perushmobile_help">
<?= $Page->perushmobile->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->perushmobile->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bencmark->Visible) { // bencmark ?>
    <div id="r_bencmark" class="form-group row">
        <label id="elh_order_pengembangan_bencmark" for="x_bencmark" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bencmark"><?= $Page->bencmark->caption() ?><?= $Page->bencmark->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bencmark->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bencmark"><span id="el_order_pengembangan_bencmark">
<input type="<?= $Page->bencmark->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_bencmark" name="x_bencmark" id="x_bencmark" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->bencmark->getPlaceHolder()) ?>" value="<?= $Page->bencmark->EditValue ?>"<?= $Page->bencmark->editAttributes() ?> aria-describedby="x_bencmark_help">
<?= $Page->bencmark->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bencmark->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategoriproduk->Visible) { // kategoriproduk ?>
    <div id="r_kategoriproduk" class="form-group row">
        <label id="elh_order_pengembangan_kategoriproduk" for="x_kategoriproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_kategoriproduk"><?= $Page->kategoriproduk->caption() ?><?= $Page->kategoriproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategoriproduk->cellAttributes() ?>>
<template id="tpx_order_pengembangan_kategoriproduk"><span id="el_order_pengembangan_kategoriproduk">
<input type="<?= $Page->kategoriproduk->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_kategoriproduk" name="x_kategoriproduk" id="x_kategoriproduk" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->kategoriproduk->getPlaceHolder()) ?>" value="<?= $Page->kategoriproduk->EditValue ?>"<?= $Page->kategoriproduk->editAttributes() ?> aria-describedby="x_kategoriproduk_help">
<?= $Page->kategoriproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategoriproduk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenisproduk->Visible) { // jenisproduk ?>
    <div id="r_jenisproduk" class="form-group row">
        <label id="elh_order_pengembangan_jenisproduk" for="x_jenisproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_jenisproduk"><?= $Page->jenisproduk->caption() ?><?= $Page->jenisproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenisproduk->cellAttributes() ?>>
<template id="tpx_order_pengembangan_jenisproduk"><span id="el_order_pengembangan_jenisproduk">
<input type="<?= $Page->jenisproduk->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_jenisproduk" name="x_jenisproduk" id="x_jenisproduk" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->jenisproduk->getPlaceHolder()) ?>" value="<?= $Page->jenisproduk->EditValue ?>"<?= $Page->jenisproduk->editAttributes() ?> aria-describedby="x_jenisproduk_help">
<?= $Page->jenisproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenisproduk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bentuksediaan->Visible) { // bentuksediaan ?>
    <div id="r_bentuksediaan" class="form-group row">
        <label id="elh_order_pengembangan_bentuksediaan" for="x_bentuksediaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bentuksediaan"><?= $Page->bentuksediaan->caption() ?><?= $Page->bentuksediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bentuksediaan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bentuksediaan"><span id="el_order_pengembangan_bentuksediaan">
<input type="<?= $Page->bentuksediaan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_bentuksediaan" name="x_bentuksediaan" id="x_bentuksediaan" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->bentuksediaan->getPlaceHolder()) ?>" value="<?= $Page->bentuksediaan->EditValue ?>"<?= $Page->bentuksediaan->editAttributes() ?> aria-describedby="x_bentuksediaan_help">
<?= $Page->bentuksediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bentuksediaan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sediaan_ukuran->Visible) { // sediaan_ukuran ?>
    <div id="r_sediaan_ukuran" class="form-group row">
        <label id="elh_order_pengembangan_sediaan_ukuran" for="x_sediaan_ukuran" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_sediaan_ukuran"><?= $Page->sediaan_ukuran->caption() ?><?= $Page->sediaan_ukuran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sediaan_ukuran->cellAttributes() ?>>
<template id="tpx_order_pengembangan_sediaan_ukuran"><span id="el_order_pengembangan_sediaan_ukuran">
<input type="<?= $Page->sediaan_ukuran->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_sediaan_ukuran" name="x_sediaan_ukuran" id="x_sediaan_ukuran" size="30" placeholder="<?= HtmlEncode($Page->sediaan_ukuran->getPlaceHolder()) ?>" value="<?= $Page->sediaan_ukuran->EditValue ?>"<?= $Page->sediaan_ukuran->editAttributes() ?> aria-describedby="x_sediaan_ukuran_help">
<?= $Page->sediaan_ukuran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sediaan_ukuran->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sediaan_ukuran_satuan->Visible) { // sediaan_ukuran_satuan ?>
    <div id="r_sediaan_ukuran_satuan" class="form-group row">
        <label id="elh_order_pengembangan_sediaan_ukuran_satuan" for="x_sediaan_ukuran_satuan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_sediaan_ukuran_satuan"><?= $Page->sediaan_ukuran_satuan->caption() ?><?= $Page->sediaan_ukuran_satuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sediaan_ukuran_satuan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_sediaan_ukuran_satuan"><span id="el_order_pengembangan_sediaan_ukuran_satuan">
<input type="<?= $Page->sediaan_ukuran_satuan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_sediaan_ukuran_satuan" name="x_sediaan_ukuran_satuan" id="x_sediaan_ukuran_satuan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->sediaan_ukuran_satuan->getPlaceHolder()) ?>" value="<?= $Page->sediaan_ukuran_satuan->EditValue ?>"<?= $Page->sediaan_ukuran_satuan->editAttributes() ?> aria-describedby="x_sediaan_ukuran_satuan_help">
<?= $Page->sediaan_ukuran_satuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sediaan_ukuran_satuan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk_viskositas->Visible) { // produk_viskositas ?>
    <div id="r_produk_viskositas" class="form-group row">
        <label id="elh_order_pengembangan_produk_viskositas" for="x_produk_viskositas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_produk_viskositas"><?= $Page->produk_viskositas->caption() ?><?= $Page->produk_viskositas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk_viskositas->cellAttributes() ?>>
<template id="tpx_order_pengembangan_produk_viskositas"><span id="el_order_pengembangan_produk_viskositas">
<input type="<?= $Page->produk_viskositas->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_produk_viskositas" name="x_produk_viskositas" id="x_produk_viskositas" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->produk_viskositas->getPlaceHolder()) ?>" value="<?= $Page->produk_viskositas->EditValue ?>"<?= $Page->produk_viskositas->editAttributes() ?> aria-describedby="x_produk_viskositas_help">
<?= $Page->produk_viskositas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk_viskositas->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->konsepproduk->Visible) { // konsepproduk ?>
    <div id="r_konsepproduk" class="form-group row">
        <label id="elh_order_pengembangan_konsepproduk" for="x_konsepproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_konsepproduk"><?= $Page->konsepproduk->caption() ?><?= $Page->konsepproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->konsepproduk->cellAttributes() ?>>
<template id="tpx_order_pengembangan_konsepproduk"><span id="el_order_pengembangan_konsepproduk">
<input type="<?= $Page->konsepproduk->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_konsepproduk" name="x_konsepproduk" id="x_konsepproduk" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->konsepproduk->getPlaceHolder()) ?>" value="<?= $Page->konsepproduk->EditValue ?>"<?= $Page->konsepproduk->editAttributes() ?> aria-describedby="x_konsepproduk_help">
<?= $Page->konsepproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->konsepproduk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fragrance->Visible) { // fragrance ?>
    <div id="r_fragrance" class="form-group row">
        <label id="elh_order_pengembangan_fragrance" for="x_fragrance" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_fragrance"><?= $Page->fragrance->caption() ?><?= $Page->fragrance->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fragrance->cellAttributes() ?>>
<template id="tpx_order_pengembangan_fragrance"><span id="el_order_pengembangan_fragrance">
<input type="<?= $Page->fragrance->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_fragrance" name="x_fragrance" id="x_fragrance" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->fragrance->getPlaceHolder()) ?>" value="<?= $Page->fragrance->EditValue ?>"<?= $Page->fragrance->editAttributes() ?> aria-describedby="x_fragrance_help">
<?= $Page->fragrance->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fragrance->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aroma->Visible) { // aroma ?>
    <div id="r_aroma" class="form-group row">
        <label id="elh_order_pengembangan_aroma" for="x_aroma" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_aroma"><?= $Page->aroma->caption() ?><?= $Page->aroma->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aroma->cellAttributes() ?>>
<template id="tpx_order_pengembangan_aroma"><span id="el_order_pengembangan_aroma">
<input type="<?= $Page->aroma->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_aroma" name="x_aroma" id="x_aroma" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->aroma->getPlaceHolder()) ?>" value="<?= $Page->aroma->EditValue ?>"<?= $Page->aroma->editAttributes() ?> aria-describedby="x_aroma_help">
<?= $Page->aroma->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aroma->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bahanaktif->Visible) { // bahanaktif ?>
    <div id="r_bahanaktif" class="form-group row">
        <label id="elh_order_pengembangan_bahanaktif" for="x_bahanaktif" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bahanaktif"><?= $Page->bahanaktif->caption() ?><?= $Page->bahanaktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bahanaktif->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bahanaktif"><span id="el_order_pengembangan_bahanaktif">
<input type="<?= $Page->bahanaktif->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_bahanaktif" name="x_bahanaktif" id="x_bahanaktif" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->bahanaktif->getPlaceHolder()) ?>" value="<?= $Page->bahanaktif->EditValue ?>"<?= $Page->bahanaktif->editAttributes() ?> aria-describedby="x_bahanaktif_help">
<?= $Page->bahanaktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bahanaktif->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <div id="r_warna" class="form-group row">
        <label id="elh_order_pengembangan_warna" for="x_warna" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_warna"><?= $Page->warna->caption() ?><?= $Page->warna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->warna->cellAttributes() ?>>
<template id="tpx_order_pengembangan_warna"><span id="el_order_pengembangan_warna">
<input type="<?= $Page->warna->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_warna" name="x_warna" id="x_warna" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->warna->getPlaceHolder()) ?>" value="<?= $Page->warna->EditValue ?>"<?= $Page->warna->editAttributes() ?> aria-describedby="x_warna_help">
<?= $Page->warna->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->warna->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk_warna_jenis->Visible) { // produk_warna_jenis ?>
    <div id="r_produk_warna_jenis" class="form-group row">
        <label id="elh_order_pengembangan_produk_warna_jenis" for="x_produk_warna_jenis" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_produk_warna_jenis"><?= $Page->produk_warna_jenis->caption() ?><?= $Page->produk_warna_jenis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk_warna_jenis->cellAttributes() ?>>
<template id="tpx_order_pengembangan_produk_warna_jenis"><span id="el_order_pengembangan_produk_warna_jenis">
<input type="<?= $Page->produk_warna_jenis->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_produk_warna_jenis" name="x_produk_warna_jenis" id="x_produk_warna_jenis" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->produk_warna_jenis->getPlaceHolder()) ?>" value="<?= $Page->produk_warna_jenis->EditValue ?>"<?= $Page->produk_warna_jenis->editAttributes() ?> aria-describedby="x_produk_warna_jenis_help">
<?= $Page->produk_warna_jenis->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk_warna_jenis->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aksesoris->Visible) { // aksesoris ?>
    <div id="r_aksesoris" class="form-group row">
        <label id="elh_order_pengembangan_aksesoris" for="x_aksesoris" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_aksesoris"><?= $Page->aksesoris->caption() ?><?= $Page->aksesoris->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aksesoris->cellAttributes() ?>>
<template id="tpx_order_pengembangan_aksesoris"><span id="el_order_pengembangan_aksesoris">
<input type="<?= $Page->aksesoris->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_aksesoris" name="x_aksesoris" id="x_aksesoris" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->aksesoris->getPlaceHolder()) ?>" value="<?= $Page->aksesoris->EditValue ?>"<?= $Page->aksesoris->editAttributes() ?> aria-describedby="x_aksesoris_help">
<?= $Page->aksesoris->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aksesoris->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk_lainlain->Visible) { // produk_lainlain ?>
    <div id="r_produk_lainlain" class="form-group row">
        <label id="elh_order_pengembangan_produk_lainlain" for="x_produk_lainlain" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_produk_lainlain"><?= $Page->produk_lainlain->caption() ?><?= $Page->produk_lainlain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk_lainlain->cellAttributes() ?>>
<template id="tpx_order_pengembangan_produk_lainlain"><span id="el_order_pengembangan_produk_lainlain">
<textarea data-table="order_pengembangan" data-field="x_produk_lainlain" name="x_produk_lainlain" id="x_produk_lainlain" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->produk_lainlain->getPlaceHolder()) ?>"<?= $Page->produk_lainlain->editAttributes() ?> aria-describedby="x_produk_lainlain_help"><?= $Page->produk_lainlain->EditValue ?></textarea>
<?= $Page->produk_lainlain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk_lainlain->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusproduk->Visible) { // statusproduk ?>
    <div id="r_statusproduk" class="form-group row">
        <label id="elh_order_pengembangan_statusproduk" for="x_statusproduk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_statusproduk"><?= $Page->statusproduk->caption() ?><?= $Page->statusproduk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statusproduk->cellAttributes() ?>>
<template id="tpx_order_pengembangan_statusproduk"><span id="el_order_pengembangan_statusproduk">
<input type="<?= $Page->statusproduk->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_statusproduk" name="x_statusproduk" id="x_statusproduk" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->statusproduk->getPlaceHolder()) ?>" value="<?= $Page->statusproduk->EditValue ?>"<?= $Page->statusproduk->editAttributes() ?> aria-describedby="x_statusproduk_help">
<?= $Page->statusproduk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusproduk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <div id="r_parfum" class="form-group row">
        <label id="elh_order_pengembangan_parfum" for="x_parfum" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_parfum"><?= $Page->parfum->caption() ?><?= $Page->parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->parfum->cellAttributes() ?>>
<template id="tpx_order_pengembangan_parfum"><span id="el_order_pengembangan_parfum">
<input type="<?= $Page->parfum->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_parfum" name="x_parfum" id="x_parfum" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->parfum->getPlaceHolder()) ?>" value="<?= $Page->parfum->EditValue ?>"<?= $Page->parfum->editAttributes() ?> aria-describedby="x_parfum_help">
<?= $Page->parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parfum->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan->Visible) { // catatan ?>
    <div id="r_catatan" class="form-group row">
        <label id="elh_order_pengembangan_catatan" for="x_catatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_catatan"><?= $Page->catatan->caption() ?><?= $Page->catatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_catatan"><span id="el_order_pengembangan_catatan">
<input type="<?= $Page->catatan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_catatan" name="x_catatan" id="x_catatan" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->catatan->getPlaceHolder()) ?>" value="<?= $Page->catatan->EditValue ?>"<?= $Page->catatan->editAttributes() ?> aria-describedby="x_catatan_help">
<?= $Page->catatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rencanakemasan->Visible) { // rencanakemasan ?>
    <div id="r_rencanakemasan" class="form-group row">
        <label id="elh_order_pengembangan_rencanakemasan" for="x_rencanakemasan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_rencanakemasan"><?= $Page->rencanakemasan->caption() ?><?= $Page->rencanakemasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->rencanakemasan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_rencanakemasan"><span id="el_order_pengembangan_rencanakemasan">
<input type="<?= $Page->rencanakemasan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_rencanakemasan" name="x_rencanakemasan" id="x_rencanakemasan" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->rencanakemasan->getPlaceHolder()) ?>" value="<?= $Page->rencanakemasan->EditValue ?>"<?= $Page->rencanakemasan->editAttributes() ?> aria-describedby="x_rencanakemasan_help">
<?= $Page->rencanakemasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rencanakemasan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_order_pengembangan_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_keterangan"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_keterangan"><span id="el_order_pengembangan_keterangan">
<textarea data-table="order_pengembangan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ekspetasiharga->Visible) { // ekspetasiharga ?>
    <div id="r_ekspetasiharga" class="form-group row">
        <label id="elh_order_pengembangan_ekspetasiharga" for="x_ekspetasiharga" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_ekspetasiharga"><?= $Page->ekspetasiharga->caption() ?><?= $Page->ekspetasiharga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ekspetasiharga->cellAttributes() ?>>
<template id="tpx_order_pengembangan_ekspetasiharga"><span id="el_order_pengembangan_ekspetasiharga">
<input type="<?= $Page->ekspetasiharga->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_ekspetasiharga" name="x_ekspetasiharga" id="x_ekspetasiharga" size="30" placeholder="<?= HtmlEncode($Page->ekspetasiharga->getPlaceHolder()) ?>" value="<?= $Page->ekspetasiharga->EditValue ?>"<?= $Page->ekspetasiharga->editAttributes() ?> aria-describedby="x_ekspetasiharga_help">
<?= $Page->ekspetasiharga->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ekspetasiharga->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasan->Visible) { // kemasan ?>
    <div id="r_kemasan" class="form-group row">
        <label id="elh_order_pengembangan_kemasan" for="x_kemasan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_kemasan"><?= $Page->kemasan->caption() ?><?= $Page->kemasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_kemasan"><span id="el_order_pengembangan_kemasan">
<input type="<?= $Page->kemasan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_kemasan" name="x_kemasan" id="x_kemasan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kemasan->getPlaceHolder()) ?>" value="<?= $Page->kemasan->EditValue ?>"<?= $Page->kemasan->editAttributes() ?> aria-describedby="x_kemasan_help">
<?= $Page->kemasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->volume->Visible) { // volume ?>
    <div id="r_volume" class="form-group row">
        <label id="elh_order_pengembangan_volume" for="x_volume" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_volume"><?= $Page->volume->caption() ?><?= $Page->volume->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->volume->cellAttributes() ?>>
<template id="tpx_order_pengembangan_volume"><span id="el_order_pengembangan_volume">
<input type="<?= $Page->volume->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_volume" name="x_volume" id="x_volume" size="30" placeholder="<?= HtmlEncode($Page->volume->getPlaceHolder()) ?>" value="<?= $Page->volume->EditValue ?>"<?= $Page->volume->editAttributes() ?> aria-describedby="x_volume_help">
<?= $Page->volume->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->volume->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenistutup->Visible) { // jenistutup ?>
    <div id="r_jenistutup" class="form-group row">
        <label id="elh_order_pengembangan_jenistutup" for="x_jenistutup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_jenistutup"><?= $Page->jenistutup->caption() ?><?= $Page->jenistutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenistutup->cellAttributes() ?>>
<template id="tpx_order_pengembangan_jenistutup"><span id="el_order_pengembangan_jenistutup">
<input type="<?= $Page->jenistutup->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_jenistutup" name="x_jenistutup" id="x_jenistutup" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jenistutup->getPlaceHolder()) ?>" value="<?= $Page->jenistutup->EditValue ?>"<?= $Page->jenistutup->editAttributes() ?> aria-describedby="x_jenistutup_help">
<?= $Page->jenistutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jenistutup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatanpackaging->Visible) { // catatanpackaging ?>
    <div id="r_catatanpackaging" class="form-group row">
        <label id="elh_order_pengembangan_catatanpackaging" for="x_catatanpackaging" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_catatanpackaging"><?= $Page->catatanpackaging->caption() ?><?= $Page->catatanpackaging->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatanpackaging->cellAttributes() ?>>
<template id="tpx_order_pengembangan_catatanpackaging"><span id="el_order_pengembangan_catatanpackaging">
<textarea data-table="order_pengembangan" data-field="x_catatanpackaging" name="x_catatanpackaging" id="x_catatanpackaging" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatanpackaging->getPlaceHolder()) ?>"<?= $Page->catatanpackaging->editAttributes() ?> aria-describedby="x_catatanpackaging_help"><?= $Page->catatanpackaging->EditValue ?></textarea>
<?= $Page->catatanpackaging->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatanpackaging->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->infopackaging->Visible) { // infopackaging ?>
    <div id="r_infopackaging" class="form-group row">
        <label id="elh_order_pengembangan_infopackaging" for="x_infopackaging" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_infopackaging"><?= $Page->infopackaging->caption() ?><?= $Page->infopackaging->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->infopackaging->cellAttributes() ?>>
<template id="tpx_order_pengembangan_infopackaging"><span id="el_order_pengembangan_infopackaging">
<input type="<?= $Page->infopackaging->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_infopackaging" name="x_infopackaging" id="x_infopackaging" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->infopackaging->getPlaceHolder()) ?>" value="<?= $Page->infopackaging->EditValue ?>"<?= $Page->infopackaging->editAttributes() ?> aria-describedby="x_infopackaging_help">
<?= $Page->infopackaging->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->infopackaging->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <div id="r_ukuran" class="form-group row">
        <label id="elh_order_pengembangan_ukuran" for="x_ukuran" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_ukuran"><?= $Page->ukuran->caption() ?><?= $Page->ukuran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran->cellAttributes() ?>>
<template id="tpx_order_pengembangan_ukuran"><span id="el_order_pengembangan_ukuran">
<input type="<?= $Page->ukuran->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_ukuran" name="x_ukuran" id="x_ukuran" size="30" placeholder="<?= HtmlEncode($Page->ukuran->getPlaceHolder()) ?>" value="<?= $Page->ukuran->EditValue ?>"<?= $Page->ukuran->editAttributes() ?> aria-describedby="x_ukuran_help">
<?= $Page->ukuran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desainprodukkemasan->Visible) { // desainprodukkemasan ?>
    <div id="r_desainprodukkemasan" class="form-group row">
        <label id="elh_order_pengembangan_desainprodukkemasan" for="x_desainprodukkemasan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_desainprodukkemasan"><?= $Page->desainprodukkemasan->caption() ?><?= $Page->desainprodukkemasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desainprodukkemasan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_desainprodukkemasan"><span id="el_order_pengembangan_desainprodukkemasan">
<input type="<?= $Page->desainprodukkemasan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_desainprodukkemasan" name="x_desainprodukkemasan" id="x_desainprodukkemasan" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->desainprodukkemasan->getPlaceHolder()) ?>" value="<?= $Page->desainprodukkemasan->EditValue ?>"<?= $Page->desainprodukkemasan->editAttributes() ?> aria-describedby="x_desainprodukkemasan_help">
<?= $Page->desainprodukkemasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desainprodukkemasan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desaindiinginkan->Visible) { // desaindiinginkan ?>
    <div id="r_desaindiinginkan" class="form-group row">
        <label id="elh_order_pengembangan_desaindiinginkan" for="x_desaindiinginkan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_desaindiinginkan"><?= $Page->desaindiinginkan->caption() ?><?= $Page->desaindiinginkan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desaindiinginkan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_desaindiinginkan"><span id="el_order_pengembangan_desaindiinginkan">
<input type="<?= $Page->desaindiinginkan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_desaindiinginkan" name="x_desaindiinginkan" id="x_desaindiinginkan" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->desaindiinginkan->getPlaceHolder()) ?>" value="<?= $Page->desaindiinginkan->EditValue ?>"<?= $Page->desaindiinginkan->editAttributes() ?> aria-describedby="x_desaindiinginkan_help">
<?= $Page->desaindiinginkan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->desaindiinginkan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mereknotifikasi->Visible) { // mereknotifikasi ?>
    <div id="r_mereknotifikasi" class="form-group row">
        <label id="elh_order_pengembangan_mereknotifikasi" for="x_mereknotifikasi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_mereknotifikasi"><?= $Page->mereknotifikasi->caption() ?><?= $Page->mereknotifikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mereknotifikasi->cellAttributes() ?>>
<template id="tpx_order_pengembangan_mereknotifikasi"><span id="el_order_pengembangan_mereknotifikasi">
<input type="<?= $Page->mereknotifikasi->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_mereknotifikasi" name="x_mereknotifikasi" id="x_mereknotifikasi" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->mereknotifikasi->getPlaceHolder()) ?>" value="<?= $Page->mereknotifikasi->EditValue ?>"<?= $Page->mereknotifikasi->editAttributes() ?> aria-describedby="x_mereknotifikasi_help">
<?= $Page->mereknotifikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mereknotifikasi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kategoristatus->Visible) { // kategoristatus ?>
    <div id="r_kategoristatus" class="form-group row">
        <label id="elh_order_pengembangan_kategoristatus" for="x_kategoristatus" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_kategoristatus"><?= $Page->kategoristatus->caption() ?><?= $Page->kategoristatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kategoristatus->cellAttributes() ?>>
<template id="tpx_order_pengembangan_kategoristatus"><span id="el_order_pengembangan_kategoristatus">
<input type="<?= $Page->kategoristatus->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_kategoristatus" name="x_kategoristatus" id="x_kategoristatus" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->kategoristatus->getPlaceHolder()) ?>" value="<?= $Page->kategoristatus->EditValue ?>"<?= $Page->kategoristatus->editAttributes() ?> aria-describedby="x_kategoristatus_help">
<?= $Page->kategoristatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kategoristatus->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasan_ukuran_satuan->Visible) { // kemasan_ukuran_satuan ?>
    <div id="r_kemasan_ukuran_satuan" class="form-group row">
        <label id="elh_order_pengembangan_kemasan_ukuran_satuan" for="x_kemasan_ukuran_satuan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_kemasan_ukuran_satuan"><?= $Page->kemasan_ukuran_satuan->caption() ?><?= $Page->kemasan_ukuran_satuan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasan_ukuran_satuan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_kemasan_ukuran_satuan"><span id="el_order_pengembangan_kemasan_ukuran_satuan">
<input type="<?= $Page->kemasan_ukuran_satuan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_kemasan_ukuran_satuan" name="x_kemasan_ukuran_satuan" id="x_kemasan_ukuran_satuan" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->kemasan_ukuran_satuan->getPlaceHolder()) ?>" value="<?= $Page->kemasan_ukuran_satuan->EditValue ?>"<?= $Page->kemasan_ukuran_satuan->editAttributes() ?> aria-describedby="x_kemasan_ukuran_satuan_help">
<?= $Page->kemasan_ukuran_satuan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasan_ukuran_satuan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->notifikasicatatan->Visible) { // notifikasicatatan ?>
    <div id="r_notifikasicatatan" class="form-group row">
        <label id="elh_order_pengembangan_notifikasicatatan" for="x_notifikasicatatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_notifikasicatatan"><?= $Page->notifikasicatatan->caption() ?><?= $Page->notifikasicatatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->notifikasicatatan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_notifikasicatatan"><span id="el_order_pengembangan_notifikasicatatan">
<textarea data-table="order_pengembangan" data-field="x_notifikasicatatan" name="x_notifikasicatatan" id="x_notifikasicatatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->notifikasicatatan->getPlaceHolder()) ?>"<?= $Page->notifikasicatatan->editAttributes() ?> aria-describedby="x_notifikasicatatan_help"><?= $Page->notifikasicatatan->EditValue ?></textarea>
<?= $Page->notifikasicatatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->notifikasicatatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label_ukuran->Visible) { // label_ukuran ?>
    <div id="r_label_ukuran" class="form-group row">
        <label id="elh_order_pengembangan_label_ukuran" for="x_label_ukuran" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_label_ukuran"><?= $Page->label_ukuran->caption() ?><?= $Page->label_ukuran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label_ukuran->cellAttributes() ?>>
<template id="tpx_order_pengembangan_label_ukuran"><span id="el_order_pengembangan_label_ukuran">
<textarea data-table="order_pengembangan" data-field="x_label_ukuran" name="x_label_ukuran" id="x_label_ukuran" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->label_ukuran->getPlaceHolder()) ?>"<?= $Page->label_ukuran->editAttributes() ?> aria-describedby="x_label_ukuran_help"><?= $Page->label_ukuran->EditValue ?></textarea>
<?= $Page->label_ukuran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label_ukuran->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->infolabel->Visible) { // infolabel ?>
    <div id="r_infolabel" class="form-group row">
        <label id="elh_order_pengembangan_infolabel" for="x_infolabel" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_infolabel"><?= $Page->infolabel->caption() ?><?= $Page->infolabel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->infolabel->cellAttributes() ?>>
<template id="tpx_order_pengembangan_infolabel"><span id="el_order_pengembangan_infolabel">
<input type="<?= $Page->infolabel->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_infolabel" name="x_infolabel" id="x_infolabel" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->infolabel->getPlaceHolder()) ?>" value="<?= $Page->infolabel->EditValue ?>"<?= $Page->infolabel->editAttributes() ?> aria-describedby="x_infolabel_help">
<?= $Page->infolabel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->infolabel->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelkualitas->Visible) { // labelkualitas ?>
    <div id="r_labelkualitas" class="form-group row">
        <label id="elh_order_pengembangan_labelkualitas" for="x_labelkualitas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_labelkualitas"><?= $Page->labelkualitas->caption() ?><?= $Page->labelkualitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelkualitas->cellAttributes() ?>>
<template id="tpx_order_pengembangan_labelkualitas"><span id="el_order_pengembangan_labelkualitas">
<input type="<?= $Page->labelkualitas->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_labelkualitas" name="x_labelkualitas" id="x_labelkualitas" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->labelkualitas->getPlaceHolder()) ?>" value="<?= $Page->labelkualitas->EditValue ?>"<?= $Page->labelkualitas->editAttributes() ?> aria-describedby="x_labelkualitas_help">
<?= $Page->labelkualitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelkualitas->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelposisi->Visible) { // labelposisi ?>
    <div id="r_labelposisi" class="form-group row">
        <label id="elh_order_pengembangan_labelposisi" for="x_labelposisi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_labelposisi"><?= $Page->labelposisi->caption() ?><?= $Page->labelposisi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelposisi->cellAttributes() ?>>
<template id="tpx_order_pengembangan_labelposisi"><span id="el_order_pengembangan_labelposisi">
<input type="<?= $Page->labelposisi->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_labelposisi" name="x_labelposisi" id="x_labelposisi" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->labelposisi->getPlaceHolder()) ?>" value="<?= $Page->labelposisi->EditValue ?>"<?= $Page->labelposisi->editAttributes() ?> aria-describedby="x_labelposisi_help">
<?= $Page->labelposisi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelposisi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->labelcatatan->Visible) { // labelcatatan ?>
    <div id="r_labelcatatan" class="form-group row">
        <label id="elh_order_pengembangan_labelcatatan" for="x_labelcatatan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_labelcatatan"><?= $Page->labelcatatan->caption() ?><?= $Page->labelcatatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->labelcatatan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_labelcatatan"><span id="el_order_pengembangan_labelcatatan">
<textarea data-table="order_pengembangan" data-field="x_labelcatatan" name="x_labelcatatan" id="x_labelcatatan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->labelcatatan->getPlaceHolder()) ?>"<?= $Page->labelcatatan->editAttributes() ?> aria-describedby="x_labelcatatan_help"><?= $Page->labelcatatan->EditValue ?></textarea>
<?= $Page->labelcatatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->labelcatatan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
    <div id="r_dibuatdi" class="form-group row">
        <label id="elh_order_pengembangan_dibuatdi" for="x_dibuatdi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_dibuatdi"><?= $Page->dibuatdi->caption() ?><?= $Page->dibuatdi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dibuatdi->cellAttributes() ?>>
<template id="tpx_order_pengembangan_dibuatdi"><span id="el_order_pengembangan_dibuatdi">
<input type="<?= $Page->dibuatdi->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_dibuatdi" name="x_dibuatdi" id="x_dibuatdi" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->dibuatdi->getPlaceHolder()) ?>" value="<?= $Page->dibuatdi->EditValue ?>"<?= $Page->dibuatdi->editAttributes() ?> aria-describedby="x_dibuatdi_help">
<?= $Page->dibuatdi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dibuatdi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <div id="r_tanggal" class="form-group row">
        <label id="elh_order_pengembangan_tanggal" for="x_tanggal" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_tanggal"><?= $Page->tanggal->caption() ?><?= $Page->tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal->cellAttributes() ?>>
<template id="tpx_order_pengembangan_tanggal"><span id="el_order_pengembangan_tanggal">
<input type="<?= $Page->tanggal->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_tanggal" name="x_tanggal" id="x_tanggal" placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>" value="<?= $Page->tanggal->EditValue ?>"<?= $Page->tanggal->editAttributes() ?> aria-describedby="x_tanggal_help">
<?= $Page->tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
<?php if (!$Page->tanggal->ReadOnly && !$Page->tanggal->Disabled && !isset($Page->tanggal->EditAttrs["readonly"]) && !isset($Page->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
    <div id="r_penerima" class="form-group row">
        <label id="elh_order_pengembangan_penerima" for="x_penerima" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_penerima"><?= $Page->penerima->caption() ?><?= $Page->penerima->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->penerima->cellAttributes() ?>>
<template id="tpx_order_pengembangan_penerima"><span id="el_order_pengembangan_penerima">
<input type="<?= $Page->penerima->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_penerima" name="x_penerima" id="x_penerima" size="30" placeholder="<?= HtmlEncode($Page->penerima->getPlaceHolder()) ?>" value="<?= $Page->penerima->EditValue ?>"<?= $Page->penerima->editAttributes() ?> aria-describedby="x_penerima_help">
<?= $Page->penerima->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->penerima->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createat->Visible) { // createat ?>
    <div id="r_createat" class="form-group row">
        <label id="elh_order_pengembangan_createat" for="x_createat" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_createat"><?= $Page->createat->caption() ?><?= $Page->createat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->createat->cellAttributes() ?>>
<template id="tpx_order_pengembangan_createat"><span id="el_order_pengembangan_createat">
<input type="<?= $Page->createat->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_createat" name="x_createat" id="x_createat" placeholder="<?= HtmlEncode($Page->createat->getPlaceHolder()) ?>" value="<?= $Page->createat->EditValue ?>"<?= $Page->createat->editAttributes() ?> aria-describedby="x_createat_help">
<?= $Page->createat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createat->getErrorMessage() ?></div>
<?php if (!$Page->createat->ReadOnly && !$Page->createat->Disabled && !isset($Page->createat->EditAttrs["readonly"]) && !isset($Page->createat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_createat", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createby->Visible) { // createby ?>
    <div id="r_createby" class="form-group row">
        <label id="elh_order_pengembangan_createby" for="x_createby" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_createby"><?= $Page->createby->caption() ?><?= $Page->createby->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->createby->cellAttributes() ?>>
<template id="tpx_order_pengembangan_createby"><span id="el_order_pengembangan_createby">
<input type="<?= $Page->createby->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_createby" name="x_createby" id="x_createby" size="30" placeholder="<?= HtmlEncode($Page->createby->getPlaceHolder()) ?>" value="<?= $Page->createby->EditValue ?>"<?= $Page->createby->editAttributes() ?> aria-describedby="x_createby_help">
<?= $Page->createby->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createby->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusdokumen->Visible) { // statusdokumen ?>
    <div id="r_statusdokumen" class="form-group row">
        <label id="elh_order_pengembangan_statusdokumen" for="x_statusdokumen" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_statusdokumen"><?= $Page->statusdokumen->caption() ?><?= $Page->statusdokumen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statusdokumen->cellAttributes() ?>>
<template id="tpx_order_pengembangan_statusdokumen"><span id="el_order_pengembangan_statusdokumen">
<input type="<?= $Page->statusdokumen->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_statusdokumen" name="x_statusdokumen" id="x_statusdokumen" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->statusdokumen->getPlaceHolder()) ?>" value="<?= $Page->statusdokumen->EditValue ?>"<?= $Page->statusdokumen->editAttributes() ?> aria-describedby="x_statusdokumen_help">
<?= $Page->statusdokumen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusdokumen->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->update_at->Visible) { // update_at ?>
    <div id="r_update_at" class="form-group row">
        <label id="elh_order_pengembangan_update_at" for="x_update_at" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_update_at"><?= $Page->update_at->caption() ?><?= $Page->update_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->update_at->cellAttributes() ?>>
<template id="tpx_order_pengembangan_update_at"><span id="el_order_pengembangan_update_at">
<input type="<?= $Page->update_at->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_update_at" name="x_update_at" id="x_update_at" placeholder="<?= HtmlEncode($Page->update_at->getPlaceHolder()) ?>" value="<?= $Page->update_at->EditValue ?>"<?= $Page->update_at->editAttributes() ?> aria-describedby="x_update_at_help">
<?= $Page->update_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->update_at->getErrorMessage() ?></div>
<?php if (!$Page->update_at->ReadOnly && !$Page->update_at->Disabled && !isset($Page->update_at->EditAttrs["readonly"]) && !isset($Page->update_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_update_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status_data->Visible) { // status_data ?>
    <div id="r_status_data" class="form-group row">
        <label id="elh_order_pengembangan_status_data" for="x_status_data" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_status_data"><?= $Page->status_data->caption() ?><?= $Page->status_data->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status_data->cellAttributes() ?>>
<template id="tpx_order_pengembangan_status_data"><span id="el_order_pengembangan_status_data">
<input type="<?= $Page->status_data->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_status_data" name="x_status_data" id="x_status_data" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->status_data->getPlaceHolder()) ?>" value="<?= $Page->status_data->EditValue ?>"<?= $Page->status_data->editAttributes() ?> aria-describedby="x_status_data_help">
<?= $Page->status_data->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status_data->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->harga_rnd->Visible) { // harga_rnd ?>
    <div id="r_harga_rnd" class="form-group row">
        <label id="elh_order_pengembangan_harga_rnd" for="x_harga_rnd" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_harga_rnd"><?= $Page->harga_rnd->caption() ?><?= $Page->harga_rnd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->harga_rnd->cellAttributes() ?>>
<template id="tpx_order_pengembangan_harga_rnd"><span id="el_order_pengembangan_harga_rnd">
<input type="<?= $Page->harga_rnd->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_harga_rnd" name="x_harga_rnd" id="x_harga_rnd" size="30" placeholder="<?= HtmlEncode($Page->harga_rnd->getPlaceHolder()) ?>" value="<?= $Page->harga_rnd->EditValue ?>"<?= $Page->harga_rnd->editAttributes() ?> aria-describedby="x_harga_rnd_help">
<?= $Page->harga_rnd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->harga_rnd->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aplikasi_sediaan->Visible) { // aplikasi_sediaan ?>
    <div id="r_aplikasi_sediaan" class="form-group row">
        <label id="elh_order_pengembangan_aplikasi_sediaan" for="x_aplikasi_sediaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_aplikasi_sediaan"><?= $Page->aplikasi_sediaan->caption() ?><?= $Page->aplikasi_sediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aplikasi_sediaan->cellAttributes() ?>>
<template id="tpx_order_pengembangan_aplikasi_sediaan"><span id="el_order_pengembangan_aplikasi_sediaan">
<input type="<?= $Page->aplikasi_sediaan->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_aplikasi_sediaan" name="x_aplikasi_sediaan" id="x_aplikasi_sediaan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->aplikasi_sediaan->getPlaceHolder()) ?>" value="<?= $Page->aplikasi_sediaan->EditValue ?>"<?= $Page->aplikasi_sediaan->editAttributes() ?> aria-describedby="x_aplikasi_sediaan_help">
<?= $Page->aplikasi_sediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aplikasi_sediaan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_isi->Visible) { // hu_hrg_isi ?>
    <div id="r_hu_hrg_isi" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_isi" for="x_hu_hrg_isi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_isi"><?= $Page->hu_hrg_isi->caption() ?><?= $Page->hu_hrg_isi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_isi->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_isi"><span id="el_order_pengembangan_hu_hrg_isi">
<input type="<?= $Page->hu_hrg_isi->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_isi" name="x_hu_hrg_isi" id="x_hu_hrg_isi" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_isi->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_isi->EditValue ?>"<?= $Page->hu_hrg_isi->editAttributes() ?> aria-describedby="x_hu_hrg_isi_help">
<?= $Page->hu_hrg_isi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_isi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_isi_pro->Visible) { // hu_hrg_isi_pro ?>
    <div id="r_hu_hrg_isi_pro" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_isi_pro" for="x_hu_hrg_isi_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_isi_pro"><?= $Page->hu_hrg_isi_pro->caption() ?><?= $Page->hu_hrg_isi_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_isi_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_isi_pro"><span id="el_order_pengembangan_hu_hrg_isi_pro">
<input type="<?= $Page->hu_hrg_isi_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_isi_pro" name="x_hu_hrg_isi_pro" id="x_hu_hrg_isi_pro" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_isi_pro->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_isi_pro->EditValue ?>"<?= $Page->hu_hrg_isi_pro->editAttributes() ?> aria-describedby="x_hu_hrg_isi_pro_help">
<?= $Page->hu_hrg_isi_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_isi_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer->Visible) { // hu_hrg_kms_primer ?>
    <div id="r_hu_hrg_kms_primer" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_kms_primer" for="x_hu_hrg_kms_primer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_kms_primer"><?= $Page->hu_hrg_kms_primer->caption() ?><?= $Page->hu_hrg_kms_primer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_kms_primer->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_kms_primer"><span id="el_order_pengembangan_hu_hrg_kms_primer">
<input type="<?= $Page->hu_hrg_kms_primer->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_kms_primer" name="x_hu_hrg_kms_primer" id="x_hu_hrg_kms_primer" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_kms_primer->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_kms_primer->EditValue ?>"<?= $Page->hu_hrg_kms_primer->editAttributes() ?> aria-describedby="x_hu_hrg_kms_primer_help">
<?= $Page->hu_hrg_kms_primer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_kms_primer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_kms_primer_pro->Visible) { // hu_hrg_kms_primer_pro ?>
    <div id="r_hu_hrg_kms_primer_pro" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_kms_primer_pro" for="x_hu_hrg_kms_primer_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_kms_primer_pro"><?= $Page->hu_hrg_kms_primer_pro->caption() ?><?= $Page->hu_hrg_kms_primer_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_kms_primer_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_kms_primer_pro"><span id="el_order_pengembangan_hu_hrg_kms_primer_pro">
<input type="<?= $Page->hu_hrg_kms_primer_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_kms_primer_pro" name="x_hu_hrg_kms_primer_pro" id="x_hu_hrg_kms_primer_pro" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_kms_primer_pro->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_kms_primer_pro->EditValue ?>"<?= $Page->hu_hrg_kms_primer_pro->editAttributes() ?> aria-describedby="x_hu_hrg_kms_primer_pro_help">
<?= $Page->hu_hrg_kms_primer_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_kms_primer_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder->Visible) { // hu_hrg_kms_sekunder ?>
    <div id="r_hu_hrg_kms_sekunder" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_kms_sekunder" for="x_hu_hrg_kms_sekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_kms_sekunder"><?= $Page->hu_hrg_kms_sekunder->caption() ?><?= $Page->hu_hrg_kms_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_kms_sekunder->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_kms_sekunder"><span id="el_order_pengembangan_hu_hrg_kms_sekunder">
<input type="<?= $Page->hu_hrg_kms_sekunder->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_kms_sekunder" name="x_hu_hrg_kms_sekunder" id="x_hu_hrg_kms_sekunder" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_kms_sekunder->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_kms_sekunder->EditValue ?>"<?= $Page->hu_hrg_kms_sekunder->editAttributes() ?> aria-describedby="x_hu_hrg_kms_sekunder_help">
<?= $Page->hu_hrg_kms_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_kms_sekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_kms_sekunder_pro->Visible) { // hu_hrg_kms_sekunder_pro ?>
    <div id="r_hu_hrg_kms_sekunder_pro" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_kms_sekunder_pro" for="x_hu_hrg_kms_sekunder_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_kms_sekunder_pro"><?= $Page->hu_hrg_kms_sekunder_pro->caption() ?><?= $Page->hu_hrg_kms_sekunder_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_kms_sekunder_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_kms_sekunder_pro"><span id="el_order_pengembangan_hu_hrg_kms_sekunder_pro">
<input type="<?= $Page->hu_hrg_kms_sekunder_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_kms_sekunder_pro" name="x_hu_hrg_kms_sekunder_pro" id="x_hu_hrg_kms_sekunder_pro" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_kms_sekunder_pro->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_kms_sekunder_pro->EditValue ?>"<?= $Page->hu_hrg_kms_sekunder_pro->editAttributes() ?> aria-describedby="x_hu_hrg_kms_sekunder_pro_help">
<?= $Page->hu_hrg_kms_sekunder_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_kms_sekunder_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_label->Visible) { // hu_hrg_label ?>
    <div id="r_hu_hrg_label" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_label" for="x_hu_hrg_label" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_label"><?= $Page->hu_hrg_label->caption() ?><?= $Page->hu_hrg_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_label->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_label"><span id="el_order_pengembangan_hu_hrg_label">
<input type="<?= $Page->hu_hrg_label->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_label" name="x_hu_hrg_label" id="x_hu_hrg_label" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_label->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_label->EditValue ?>"<?= $Page->hu_hrg_label->editAttributes() ?> aria-describedby="x_hu_hrg_label_help">
<?= $Page->hu_hrg_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_label->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_label_pro->Visible) { // hu_hrg_label_pro ?>
    <div id="r_hu_hrg_label_pro" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_label_pro" for="x_hu_hrg_label_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_label_pro"><?= $Page->hu_hrg_label_pro->caption() ?><?= $Page->hu_hrg_label_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_label_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_label_pro"><span id="el_order_pengembangan_hu_hrg_label_pro">
<input type="<?= $Page->hu_hrg_label_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_label_pro" name="x_hu_hrg_label_pro" id="x_hu_hrg_label_pro" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_label_pro->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_label_pro->EditValue ?>"<?= $Page->hu_hrg_label_pro->editAttributes() ?> aria-describedby="x_hu_hrg_label_pro_help">
<?= $Page->hu_hrg_label_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_label_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_total->Visible) { // hu_hrg_total ?>
    <div id="r_hu_hrg_total" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_total" for="x_hu_hrg_total" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_total"><?= $Page->hu_hrg_total->caption() ?><?= $Page->hu_hrg_total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_total->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_total"><span id="el_order_pengembangan_hu_hrg_total">
<input type="<?= $Page->hu_hrg_total->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_total" name="x_hu_hrg_total" id="x_hu_hrg_total" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_total->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_total->EditValue ?>"<?= $Page->hu_hrg_total->editAttributes() ?> aria-describedby="x_hu_hrg_total_help">
<?= $Page->hu_hrg_total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_total->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hu_hrg_total_pro->Visible) { // hu_hrg_total_pro ?>
    <div id="r_hu_hrg_total_pro" class="form-group row">
        <label id="elh_order_pengembangan_hu_hrg_total_pro" for="x_hu_hrg_total_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hu_hrg_total_pro"><?= $Page->hu_hrg_total_pro->caption() ?><?= $Page->hu_hrg_total_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hu_hrg_total_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hu_hrg_total_pro"><span id="el_order_pengembangan_hu_hrg_total_pro">
<input type="<?= $Page->hu_hrg_total_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hu_hrg_total_pro" name="x_hu_hrg_total_pro" id="x_hu_hrg_total_pro" size="30" placeholder="<?= HtmlEncode($Page->hu_hrg_total_pro->getPlaceHolder()) ?>" value="<?= $Page->hu_hrg_total_pro->EditValue ?>"<?= $Page->hu_hrg_total_pro->editAttributes() ?> aria-describedby="x_hu_hrg_total_pro_help">
<?= $Page->hu_hrg_total_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hu_hrg_total_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_isi->Visible) { // hl_hrg_isi ?>
    <div id="r_hl_hrg_isi" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_isi" for="x_hl_hrg_isi" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_isi"><?= $Page->hl_hrg_isi->caption() ?><?= $Page->hl_hrg_isi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_isi->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_isi"><span id="el_order_pengembangan_hl_hrg_isi">
<input type="<?= $Page->hl_hrg_isi->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_isi" name="x_hl_hrg_isi" id="x_hl_hrg_isi" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_isi->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_isi->EditValue ?>"<?= $Page->hl_hrg_isi->editAttributes() ?> aria-describedby="x_hl_hrg_isi_help">
<?= $Page->hl_hrg_isi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_isi->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_isi_pro->Visible) { // hl_hrg_isi_pro ?>
    <div id="r_hl_hrg_isi_pro" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_isi_pro" for="x_hl_hrg_isi_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_isi_pro"><?= $Page->hl_hrg_isi_pro->caption() ?><?= $Page->hl_hrg_isi_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_isi_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_isi_pro"><span id="el_order_pengembangan_hl_hrg_isi_pro">
<input type="<?= $Page->hl_hrg_isi_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_isi_pro" name="x_hl_hrg_isi_pro" id="x_hl_hrg_isi_pro" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_isi_pro->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_isi_pro->EditValue ?>"<?= $Page->hl_hrg_isi_pro->editAttributes() ?> aria-describedby="x_hl_hrg_isi_pro_help">
<?= $Page->hl_hrg_isi_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_isi_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer->Visible) { // hl_hrg_kms_primer ?>
    <div id="r_hl_hrg_kms_primer" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_kms_primer" for="x_hl_hrg_kms_primer" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_kms_primer"><?= $Page->hl_hrg_kms_primer->caption() ?><?= $Page->hl_hrg_kms_primer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_kms_primer->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_kms_primer"><span id="el_order_pengembangan_hl_hrg_kms_primer">
<input type="<?= $Page->hl_hrg_kms_primer->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_kms_primer" name="x_hl_hrg_kms_primer" id="x_hl_hrg_kms_primer" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_kms_primer->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_kms_primer->EditValue ?>"<?= $Page->hl_hrg_kms_primer->editAttributes() ?> aria-describedby="x_hl_hrg_kms_primer_help">
<?= $Page->hl_hrg_kms_primer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_kms_primer->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_kms_primer_pro->Visible) { // hl_hrg_kms_primer_pro ?>
    <div id="r_hl_hrg_kms_primer_pro" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_kms_primer_pro" for="x_hl_hrg_kms_primer_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_kms_primer_pro"><?= $Page->hl_hrg_kms_primer_pro->caption() ?><?= $Page->hl_hrg_kms_primer_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_kms_primer_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_kms_primer_pro"><span id="el_order_pengembangan_hl_hrg_kms_primer_pro">
<input type="<?= $Page->hl_hrg_kms_primer_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_kms_primer_pro" name="x_hl_hrg_kms_primer_pro" id="x_hl_hrg_kms_primer_pro" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_kms_primer_pro->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_kms_primer_pro->EditValue ?>"<?= $Page->hl_hrg_kms_primer_pro->editAttributes() ?> aria-describedby="x_hl_hrg_kms_primer_pro_help">
<?= $Page->hl_hrg_kms_primer_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_kms_primer_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder->Visible) { // hl_hrg_kms_sekunder ?>
    <div id="r_hl_hrg_kms_sekunder" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_kms_sekunder" for="x_hl_hrg_kms_sekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_kms_sekunder"><?= $Page->hl_hrg_kms_sekunder->caption() ?><?= $Page->hl_hrg_kms_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_kms_sekunder->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_kms_sekunder"><span id="el_order_pengembangan_hl_hrg_kms_sekunder">
<input type="<?= $Page->hl_hrg_kms_sekunder->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_kms_sekunder" name="x_hl_hrg_kms_sekunder" id="x_hl_hrg_kms_sekunder" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_kms_sekunder->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_kms_sekunder->EditValue ?>"<?= $Page->hl_hrg_kms_sekunder->editAttributes() ?> aria-describedby="x_hl_hrg_kms_sekunder_help">
<?= $Page->hl_hrg_kms_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_kms_sekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_kms_sekunder_pro->Visible) { // hl_hrg_kms_sekunder_pro ?>
    <div id="r_hl_hrg_kms_sekunder_pro" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_kms_sekunder_pro" for="x_hl_hrg_kms_sekunder_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_kms_sekunder_pro"><?= $Page->hl_hrg_kms_sekunder_pro->caption() ?><?= $Page->hl_hrg_kms_sekunder_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_kms_sekunder_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_kms_sekunder_pro"><span id="el_order_pengembangan_hl_hrg_kms_sekunder_pro">
<input type="<?= $Page->hl_hrg_kms_sekunder_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_kms_sekunder_pro" name="x_hl_hrg_kms_sekunder_pro" id="x_hl_hrg_kms_sekunder_pro" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_kms_sekunder_pro->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_kms_sekunder_pro->EditValue ?>"<?= $Page->hl_hrg_kms_sekunder_pro->editAttributes() ?> aria-describedby="x_hl_hrg_kms_sekunder_pro_help">
<?= $Page->hl_hrg_kms_sekunder_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_kms_sekunder_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_label->Visible) { // hl_hrg_label ?>
    <div id="r_hl_hrg_label" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_label" for="x_hl_hrg_label" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_label"><?= $Page->hl_hrg_label->caption() ?><?= $Page->hl_hrg_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_label->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_label"><span id="el_order_pengembangan_hl_hrg_label">
<input type="<?= $Page->hl_hrg_label->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_label" name="x_hl_hrg_label" id="x_hl_hrg_label" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_label->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_label->EditValue ?>"<?= $Page->hl_hrg_label->editAttributes() ?> aria-describedby="x_hl_hrg_label_help">
<?= $Page->hl_hrg_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_label->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_label_pro->Visible) { // hl_hrg_label_pro ?>
    <div id="r_hl_hrg_label_pro" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_label_pro" for="x_hl_hrg_label_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_label_pro"><?= $Page->hl_hrg_label_pro->caption() ?><?= $Page->hl_hrg_label_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_label_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_label_pro"><span id="el_order_pengembangan_hl_hrg_label_pro">
<input type="<?= $Page->hl_hrg_label_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_label_pro" name="x_hl_hrg_label_pro" id="x_hl_hrg_label_pro" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_label_pro->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_label_pro->EditValue ?>"<?= $Page->hl_hrg_label_pro->editAttributes() ?> aria-describedby="x_hl_hrg_label_pro_help">
<?= $Page->hl_hrg_label_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_label_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_total->Visible) { // hl_hrg_total ?>
    <div id="r_hl_hrg_total" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_total" for="x_hl_hrg_total" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_total"><?= $Page->hl_hrg_total->caption() ?><?= $Page->hl_hrg_total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_total->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_total"><span id="el_order_pengembangan_hl_hrg_total">
<input type="<?= $Page->hl_hrg_total->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_total" name="x_hl_hrg_total" id="x_hl_hrg_total" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_total->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_total->EditValue ?>"<?= $Page->hl_hrg_total->editAttributes() ?> aria-describedby="x_hl_hrg_total_help">
<?= $Page->hl_hrg_total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_total->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hl_hrg_total_pro->Visible) { // hl_hrg_total_pro ?>
    <div id="r_hl_hrg_total_pro" class="form-group row">
        <label id="elh_order_pengembangan_hl_hrg_total_pro" for="x_hl_hrg_total_pro" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_hl_hrg_total_pro"><?= $Page->hl_hrg_total_pro->caption() ?><?= $Page->hl_hrg_total_pro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hl_hrg_total_pro->cellAttributes() ?>>
<template id="tpx_order_pengembangan_hl_hrg_total_pro"><span id="el_order_pengembangan_hl_hrg_total_pro">
<input type="<?= $Page->hl_hrg_total_pro->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_hl_hrg_total_pro" name="x_hl_hrg_total_pro" id="x_hl_hrg_total_pro" size="30" placeholder="<?= HtmlEncode($Page->hl_hrg_total_pro->getPlaceHolder()) ?>" value="<?= $Page->hl_hrg_total_pro->EditValue ?>"<?= $Page->hl_hrg_total_pro->editAttributes() ?> aria-describedby="x_hl_hrg_total_pro_help">
<?= $Page->hl_hrg_total_pro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hl_hrg_total_pro->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_bahan_aktif_tick->Visible) { // bs_bahan_aktif_tick ?>
    <div id="r_bs_bahan_aktif_tick" class="form-group row">
        <label id="elh_order_pengembangan_bs_bahan_aktif_tick" for="x_bs_bahan_aktif_tick" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_bahan_aktif_tick"><?= $Page->bs_bahan_aktif_tick->caption() ?><?= $Page->bs_bahan_aktif_tick->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_bahan_aktif_tick->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_bahan_aktif_tick"><span id="el_order_pengembangan_bs_bahan_aktif_tick">
<input type="<?= $Page->bs_bahan_aktif_tick->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_bs_bahan_aktif_tick" name="x_bs_bahan_aktif_tick" id="x_bs_bahan_aktif_tick" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->bs_bahan_aktif_tick->getPlaceHolder()) ?>" value="<?= $Page->bs_bahan_aktif_tick->EditValue ?>"<?= $Page->bs_bahan_aktif_tick->editAttributes() ?> aria-describedby="x_bs_bahan_aktif_tick_help">
<?= $Page->bs_bahan_aktif_tick->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_bahan_aktif_tick->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_bahan_aktif->Visible) { // bs_bahan_aktif ?>
    <div id="r_bs_bahan_aktif" class="form-group row">
        <label id="elh_order_pengembangan_bs_bahan_aktif" for="x_bs_bahan_aktif" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_bahan_aktif"><?= $Page->bs_bahan_aktif->caption() ?><?= $Page->bs_bahan_aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_bahan_aktif->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_bahan_aktif"><span id="el_order_pengembangan_bs_bahan_aktif">
<textarea data-table="order_pengembangan" data-field="x_bs_bahan_aktif" name="x_bs_bahan_aktif" id="x_bs_bahan_aktif" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_bahan_aktif->getPlaceHolder()) ?>"<?= $Page->bs_bahan_aktif->editAttributes() ?> aria-describedby="x_bs_bahan_aktif_help"><?= $Page->bs_bahan_aktif->EditValue ?></textarea>
<?= $Page->bs_bahan_aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_bahan_aktif->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_bahan_lain->Visible) { // bs_bahan_lain ?>
    <div id="r_bs_bahan_lain" class="form-group row">
        <label id="elh_order_pengembangan_bs_bahan_lain" for="x_bs_bahan_lain" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_bahan_lain"><?= $Page->bs_bahan_lain->caption() ?><?= $Page->bs_bahan_lain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_bahan_lain->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_bahan_lain"><span id="el_order_pengembangan_bs_bahan_lain">
<textarea data-table="order_pengembangan" data-field="x_bs_bahan_lain" name="x_bs_bahan_lain" id="x_bs_bahan_lain" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_bahan_lain->getPlaceHolder()) ?>"<?= $Page->bs_bahan_lain->editAttributes() ?> aria-describedby="x_bs_bahan_lain_help"><?= $Page->bs_bahan_lain->EditValue ?></textarea>
<?= $Page->bs_bahan_lain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_bahan_lain->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_parfum->Visible) { // bs_parfum ?>
    <div id="r_bs_parfum" class="form-group row">
        <label id="elh_order_pengembangan_bs_parfum" for="x_bs_parfum" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_parfum"><?= $Page->bs_parfum->caption() ?><?= $Page->bs_parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_parfum->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_parfum"><span id="el_order_pengembangan_bs_parfum">
<textarea data-table="order_pengembangan" data-field="x_bs_parfum" name="x_bs_parfum" id="x_bs_parfum" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_parfum->getPlaceHolder()) ?>"<?= $Page->bs_parfum->editAttributes() ?> aria-describedby="x_bs_parfum_help"><?= $Page->bs_parfum->EditValue ?></textarea>
<?= $Page->bs_parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_parfum->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_estetika->Visible) { // bs_estetika ?>
    <div id="r_bs_estetika" class="form-group row">
        <label id="elh_order_pengembangan_bs_estetika" for="x_bs_estetika" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_estetika"><?= $Page->bs_estetika->caption() ?><?= $Page->bs_estetika->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_estetika->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_estetika"><span id="el_order_pengembangan_bs_estetika">
<textarea data-table="order_pengembangan" data-field="x_bs_estetika" name="x_bs_estetika" id="x_bs_estetika" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_estetika->getPlaceHolder()) ?>"<?= $Page->bs_estetika->editAttributes() ?> aria-describedby="x_bs_estetika_help"><?= $Page->bs_estetika->EditValue ?></textarea>
<?= $Page->bs_estetika->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_estetika->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_kms_wadah->Visible) { // bs_kms_wadah ?>
    <div id="r_bs_kms_wadah" class="form-group row">
        <label id="elh_order_pengembangan_bs_kms_wadah" for="x_bs_kms_wadah" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_kms_wadah"><?= $Page->bs_kms_wadah->caption() ?><?= $Page->bs_kms_wadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_kms_wadah->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_kms_wadah"><span id="el_order_pengembangan_bs_kms_wadah">
<textarea data-table="order_pengembangan" data-field="x_bs_kms_wadah" name="x_bs_kms_wadah" id="x_bs_kms_wadah" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_kms_wadah->getPlaceHolder()) ?>"<?= $Page->bs_kms_wadah->editAttributes() ?> aria-describedby="x_bs_kms_wadah_help"><?= $Page->bs_kms_wadah->EditValue ?></textarea>
<?= $Page->bs_kms_wadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_kms_wadah->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_kms_tutup->Visible) { // bs_kms_tutup ?>
    <div id="r_bs_kms_tutup" class="form-group row">
        <label id="elh_order_pengembangan_bs_kms_tutup" for="x_bs_kms_tutup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_kms_tutup"><?= $Page->bs_kms_tutup->caption() ?><?= $Page->bs_kms_tutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_kms_tutup->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_kms_tutup"><span id="el_order_pengembangan_bs_kms_tutup">
<textarea data-table="order_pengembangan" data-field="x_bs_kms_tutup" name="x_bs_kms_tutup" id="x_bs_kms_tutup" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_kms_tutup->getPlaceHolder()) ?>"<?= $Page->bs_kms_tutup->editAttributes() ?> aria-describedby="x_bs_kms_tutup_help"><?= $Page->bs_kms_tutup->EditValue ?></textarea>
<?= $Page->bs_kms_tutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_kms_tutup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_kms_sekunder->Visible) { // bs_kms_sekunder ?>
    <div id="r_bs_kms_sekunder" class="form-group row">
        <label id="elh_order_pengembangan_bs_kms_sekunder" for="x_bs_kms_sekunder" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_kms_sekunder"><?= $Page->bs_kms_sekunder->caption() ?><?= $Page->bs_kms_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_kms_sekunder->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_kms_sekunder"><span id="el_order_pengembangan_bs_kms_sekunder">
<textarea data-table="order_pengembangan" data-field="x_bs_kms_sekunder" name="x_bs_kms_sekunder" id="x_bs_kms_sekunder" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_kms_sekunder->getPlaceHolder()) ?>"<?= $Page->bs_kms_sekunder->editAttributes() ?> aria-describedby="x_bs_kms_sekunder_help"><?= $Page->bs_kms_sekunder->EditValue ?></textarea>
<?= $Page->bs_kms_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_kms_sekunder->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_label_desain->Visible) { // bs_label_desain ?>
    <div id="r_bs_label_desain" class="form-group row">
        <label id="elh_order_pengembangan_bs_label_desain" for="x_bs_label_desain" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_label_desain"><?= $Page->bs_label_desain->caption() ?><?= $Page->bs_label_desain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_label_desain->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_label_desain"><span id="el_order_pengembangan_bs_label_desain">
<textarea data-table="order_pengembangan" data-field="x_bs_label_desain" name="x_bs_label_desain" id="x_bs_label_desain" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_label_desain->getPlaceHolder()) ?>"<?= $Page->bs_label_desain->editAttributes() ?> aria-describedby="x_bs_label_desain_help"><?= $Page->bs_label_desain->EditValue ?></textarea>
<?= $Page->bs_label_desain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_label_desain->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_label_cetak->Visible) { // bs_label_cetak ?>
    <div id="r_bs_label_cetak" class="form-group row">
        <label id="elh_order_pengembangan_bs_label_cetak" for="x_bs_label_cetak" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_label_cetak"><?= $Page->bs_label_cetak->caption() ?><?= $Page->bs_label_cetak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_label_cetak->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_label_cetak"><span id="el_order_pengembangan_bs_label_cetak">
<textarea data-table="order_pengembangan" data-field="x_bs_label_cetak" name="x_bs_label_cetak" id="x_bs_label_cetak" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_label_cetak->getPlaceHolder()) ?>"<?= $Page->bs_label_cetak->editAttributes() ?> aria-describedby="x_bs_label_cetak_help"><?= $Page->bs_label_cetak->EditValue ?></textarea>
<?= $Page->bs_label_cetak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_label_cetak->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bs_label_lain->Visible) { // bs_label_lain ?>
    <div id="r_bs_label_lain" class="form-group row">
        <label id="elh_order_pengembangan_bs_label_lain" for="x_bs_label_lain" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_bs_label_lain"><?= $Page->bs_label_lain->caption() ?><?= $Page->bs_label_lain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bs_label_lain->cellAttributes() ?>>
<template id="tpx_order_pengembangan_bs_label_lain"><span id="el_order_pengembangan_bs_label_lain">
<textarea data-table="order_pengembangan" data-field="x_bs_label_lain" name="x_bs_label_lain" id="x_bs_label_lain" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->bs_label_lain->getPlaceHolder()) ?>"<?= $Page->bs_label_lain->editAttributes() ?> aria-describedby="x_bs_label_lain_help"><?= $Page->bs_label_lain->EditValue ?></textarea>
<?= $Page->bs_label_lain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bs_label_lain->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dlv_pickup->Visible) { // dlv_pickup ?>
    <div id="r_dlv_pickup" class="form-group row">
        <label id="elh_order_pengembangan_dlv_pickup" for="x_dlv_pickup" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_dlv_pickup"><?= $Page->dlv_pickup->caption() ?><?= $Page->dlv_pickup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dlv_pickup->cellAttributes() ?>>
<template id="tpx_order_pengembangan_dlv_pickup"><span id="el_order_pengembangan_dlv_pickup">
<textarea data-table="order_pengembangan" data-field="x_dlv_pickup" name="x_dlv_pickup" id="x_dlv_pickup" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->dlv_pickup->getPlaceHolder()) ?>"<?= $Page->dlv_pickup->editAttributes() ?> aria-describedby="x_dlv_pickup_help"><?= $Page->dlv_pickup->EditValue ?></textarea>
<?= $Page->dlv_pickup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dlv_pickup->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dlv_singlepoint->Visible) { // dlv_singlepoint ?>
    <div id="r_dlv_singlepoint" class="form-group row">
        <label id="elh_order_pengembangan_dlv_singlepoint" for="x_dlv_singlepoint" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_dlv_singlepoint"><?= $Page->dlv_singlepoint->caption() ?><?= $Page->dlv_singlepoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dlv_singlepoint->cellAttributes() ?>>
<template id="tpx_order_pengembangan_dlv_singlepoint"><span id="el_order_pengembangan_dlv_singlepoint">
<textarea data-table="order_pengembangan" data-field="x_dlv_singlepoint" name="x_dlv_singlepoint" id="x_dlv_singlepoint" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->dlv_singlepoint->getPlaceHolder()) ?>"<?= $Page->dlv_singlepoint->editAttributes() ?> aria-describedby="x_dlv_singlepoint_help"><?= $Page->dlv_singlepoint->EditValue ?></textarea>
<?= $Page->dlv_singlepoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dlv_singlepoint->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dlv_multipoint->Visible) { // dlv_multipoint ?>
    <div id="r_dlv_multipoint" class="form-group row">
        <label id="elh_order_pengembangan_dlv_multipoint" for="x_dlv_multipoint" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_dlv_multipoint"><?= $Page->dlv_multipoint->caption() ?><?= $Page->dlv_multipoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dlv_multipoint->cellAttributes() ?>>
<template id="tpx_order_pengembangan_dlv_multipoint"><span id="el_order_pengembangan_dlv_multipoint">
<textarea data-table="order_pengembangan" data-field="x_dlv_multipoint" name="x_dlv_multipoint" id="x_dlv_multipoint" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->dlv_multipoint->getPlaceHolder()) ?>"<?= $Page->dlv_multipoint->editAttributes() ?> aria-describedby="x_dlv_multipoint_help"><?= $Page->dlv_multipoint->EditValue ?></textarea>
<?= $Page->dlv_multipoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dlv_multipoint->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dlv_multipoint_jml->Visible) { // dlv_multipoint_jml ?>
    <div id="r_dlv_multipoint_jml" class="form-group row">
        <label id="elh_order_pengembangan_dlv_multipoint_jml" for="x_dlv_multipoint_jml" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_dlv_multipoint_jml"><?= $Page->dlv_multipoint_jml->caption() ?><?= $Page->dlv_multipoint_jml->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dlv_multipoint_jml->cellAttributes() ?>>
<template id="tpx_order_pengembangan_dlv_multipoint_jml"><span id="el_order_pengembangan_dlv_multipoint_jml">
<textarea data-table="order_pengembangan" data-field="x_dlv_multipoint_jml" name="x_dlv_multipoint_jml" id="x_dlv_multipoint_jml" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->dlv_multipoint_jml->getPlaceHolder()) ?>"<?= $Page->dlv_multipoint_jml->editAttributes() ?> aria-describedby="x_dlv_multipoint_jml_help"><?= $Page->dlv_multipoint_jml->EditValue ?></textarea>
<?= $Page->dlv_multipoint_jml->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dlv_multipoint_jml->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dlv_term_lain->Visible) { // dlv_term_lain ?>
    <div id="r_dlv_term_lain" class="form-group row">
        <label id="elh_order_pengembangan_dlv_term_lain" for="x_dlv_term_lain" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_dlv_term_lain"><?= $Page->dlv_term_lain->caption() ?><?= $Page->dlv_term_lain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dlv_term_lain->cellAttributes() ?>>
<template id="tpx_order_pengembangan_dlv_term_lain"><span id="el_order_pengembangan_dlv_term_lain">
<textarea data-table="order_pengembangan" data-field="x_dlv_term_lain" name="x_dlv_term_lain" id="x_dlv_term_lain" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->dlv_term_lain->getPlaceHolder()) ?>"<?= $Page->dlv_term_lain->editAttributes() ?> aria-describedby="x_dlv_term_lain_help"><?= $Page->dlv_term_lain->EditValue ?></textarea>
<?= $Page->dlv_term_lain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dlv_term_lain->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan_khusus->Visible) { // catatan_khusus ?>
    <div id="r_catatan_khusus" class="form-group row">
        <label id="elh_order_pengembangan_catatan_khusus" for="x_catatan_khusus" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_catatan_khusus"><?= $Page->catatan_khusus->caption() ?><?= $Page->catatan_khusus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan_khusus->cellAttributes() ?>>
<template id="tpx_order_pengembangan_catatan_khusus"><span id="el_order_pengembangan_catatan_khusus">
<textarea data-table="order_pengembangan" data-field="x_catatan_khusus" name="x_catatan_khusus" id="x_catatan_khusus" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatan_khusus->getPlaceHolder()) ?>"<?= $Page->catatan_khusus->editAttributes() ?> aria-describedby="x_catatan_khusus_help"><?= $Page->catatan_khusus->EditValue ?></textarea>
<?= $Page->catatan_khusus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan_khusus->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aju_tgl->Visible) { // aju_tgl ?>
    <div id="r_aju_tgl" class="form-group row">
        <label id="elh_order_pengembangan_aju_tgl" for="x_aju_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_aju_tgl"><?= $Page->aju_tgl->caption() ?><?= $Page->aju_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aju_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_aju_tgl"><span id="el_order_pengembangan_aju_tgl">
<input type="<?= $Page->aju_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_aju_tgl" name="x_aju_tgl" id="x_aju_tgl" placeholder="<?= HtmlEncode($Page->aju_tgl->getPlaceHolder()) ?>" value="<?= $Page->aju_tgl->EditValue ?>"<?= $Page->aju_tgl->editAttributes() ?> aria-describedby="x_aju_tgl_help">
<?= $Page->aju_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aju_tgl->getErrorMessage() ?></div>
<?php if (!$Page->aju_tgl->ReadOnly && !$Page->aju_tgl->Disabled && !isset($Page->aju_tgl->EditAttrs["readonly"]) && !isset($Page->aju_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_aju_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aju_oleh->Visible) { // aju_oleh ?>
    <div id="r_aju_oleh" class="form-group row">
        <label id="elh_order_pengembangan_aju_oleh" for="x_aju_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_aju_oleh"><?= $Page->aju_oleh->caption() ?><?= $Page->aju_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aju_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_aju_oleh"><span id="el_order_pengembangan_aju_oleh">
<input type="<?= $Page->aju_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_aju_oleh" name="x_aju_oleh" id="x_aju_oleh" size="30" placeholder="<?= HtmlEncode($Page->aju_oleh->getPlaceHolder()) ?>" value="<?= $Page->aju_oleh->EditValue ?>"<?= $Page->aju_oleh->editAttributes() ?> aria-describedby="x_aju_oleh_help">
<?= $Page->aju_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aju_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proses_tgl->Visible) { // proses_tgl ?>
    <div id="r_proses_tgl" class="form-group row">
        <label id="elh_order_pengembangan_proses_tgl" for="x_proses_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_proses_tgl"><?= $Page->proses_tgl->caption() ?><?= $Page->proses_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->proses_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_proses_tgl"><span id="el_order_pengembangan_proses_tgl">
<input type="<?= $Page->proses_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_proses_tgl" name="x_proses_tgl" id="x_proses_tgl" placeholder="<?= HtmlEncode($Page->proses_tgl->getPlaceHolder()) ?>" value="<?= $Page->proses_tgl->EditValue ?>"<?= $Page->proses_tgl->editAttributes() ?> aria-describedby="x_proses_tgl_help">
<?= $Page->proses_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->proses_tgl->getErrorMessage() ?></div>
<?php if (!$Page->proses_tgl->ReadOnly && !$Page->proses_tgl->Disabled && !isset($Page->proses_tgl->EditAttrs["readonly"]) && !isset($Page->proses_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_proses_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proses_oleh->Visible) { // proses_oleh ?>
    <div id="r_proses_oleh" class="form-group row">
        <label id="elh_order_pengembangan_proses_oleh" for="x_proses_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_proses_oleh"><?= $Page->proses_oleh->caption() ?><?= $Page->proses_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->proses_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_proses_oleh"><span id="el_order_pengembangan_proses_oleh">
<input type="<?= $Page->proses_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_proses_oleh" name="x_proses_oleh" id="x_proses_oleh" size="30" placeholder="<?= HtmlEncode($Page->proses_oleh->getPlaceHolder()) ?>" value="<?= $Page->proses_oleh->EditValue ?>"<?= $Page->proses_oleh->editAttributes() ?> aria-describedby="x_proses_oleh_help">
<?= $Page->proses_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->proses_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisi_tgl->Visible) { // revisi_tgl ?>
    <div id="r_revisi_tgl" class="form-group row">
        <label id="elh_order_pengembangan_revisi_tgl" for="x_revisi_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_revisi_tgl"><?= $Page->revisi_tgl->caption() ?><?= $Page->revisi_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->revisi_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_revisi_tgl"><span id="el_order_pengembangan_revisi_tgl">
<input type="<?= $Page->revisi_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_revisi_tgl" name="x_revisi_tgl" id="x_revisi_tgl" placeholder="<?= HtmlEncode($Page->revisi_tgl->getPlaceHolder()) ?>" value="<?= $Page->revisi_tgl->EditValue ?>"<?= $Page->revisi_tgl->editAttributes() ?> aria-describedby="x_revisi_tgl_help">
<?= $Page->revisi_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisi_tgl->getErrorMessage() ?></div>
<?php if (!$Page->revisi_tgl->ReadOnly && !$Page->revisi_tgl->Disabled && !isset($Page->revisi_tgl->EditAttrs["readonly"]) && !isset($Page->revisi_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_revisi_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisi_oleh->Visible) { // revisi_oleh ?>
    <div id="r_revisi_oleh" class="form-group row">
        <label id="elh_order_pengembangan_revisi_oleh" for="x_revisi_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_revisi_oleh"><?= $Page->revisi_oleh->caption() ?><?= $Page->revisi_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->revisi_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_revisi_oleh"><span id="el_order_pengembangan_revisi_oleh">
<input type="<?= $Page->revisi_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_revisi_oleh" name="x_revisi_oleh" id="x_revisi_oleh" size="30" placeholder="<?= HtmlEncode($Page->revisi_oleh->getPlaceHolder()) ?>" value="<?= $Page->revisi_oleh->EditValue ?>"<?= $Page->revisi_oleh->editAttributes() ?> aria-describedby="x_revisi_oleh_help">
<?= $Page->revisi_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisi_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisi_akun_tgl->Visible) { // revisi_akun_tgl ?>
    <div id="r_revisi_akun_tgl" class="form-group row">
        <label id="elh_order_pengembangan_revisi_akun_tgl" for="x_revisi_akun_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_revisi_akun_tgl"><?= $Page->revisi_akun_tgl->caption() ?><?= $Page->revisi_akun_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->revisi_akun_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_revisi_akun_tgl"><span id="el_order_pengembangan_revisi_akun_tgl">
<input type="<?= $Page->revisi_akun_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_revisi_akun_tgl" name="x_revisi_akun_tgl" id="x_revisi_akun_tgl" placeholder="<?= HtmlEncode($Page->revisi_akun_tgl->getPlaceHolder()) ?>" value="<?= $Page->revisi_akun_tgl->EditValue ?>"<?= $Page->revisi_akun_tgl->editAttributes() ?> aria-describedby="x_revisi_akun_tgl_help">
<?= $Page->revisi_akun_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisi_akun_tgl->getErrorMessage() ?></div>
<?php if (!$Page->revisi_akun_tgl->ReadOnly && !$Page->revisi_akun_tgl->Disabled && !isset($Page->revisi_akun_tgl->EditAttrs["readonly"]) && !isset($Page->revisi_akun_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_revisi_akun_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisi_akun_oleh->Visible) { // revisi_akun_oleh ?>
    <div id="r_revisi_akun_oleh" class="form-group row">
        <label id="elh_order_pengembangan_revisi_akun_oleh" for="x_revisi_akun_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_revisi_akun_oleh"><?= $Page->revisi_akun_oleh->caption() ?><?= $Page->revisi_akun_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->revisi_akun_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_revisi_akun_oleh"><span id="el_order_pengembangan_revisi_akun_oleh">
<input type="<?= $Page->revisi_akun_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_revisi_akun_oleh" name="x_revisi_akun_oleh" id="x_revisi_akun_oleh" size="30" placeholder="<?= HtmlEncode($Page->revisi_akun_oleh->getPlaceHolder()) ?>" value="<?= $Page->revisi_akun_oleh->EditValue ?>"<?= $Page->revisi_akun_oleh->editAttributes() ?> aria-describedby="x_revisi_akun_oleh_help">
<?= $Page->revisi_akun_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisi_akun_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisi_rnd_tgl->Visible) { // revisi_rnd_tgl ?>
    <div id="r_revisi_rnd_tgl" class="form-group row">
        <label id="elh_order_pengembangan_revisi_rnd_tgl" for="x_revisi_rnd_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_revisi_rnd_tgl"><?= $Page->revisi_rnd_tgl->caption() ?><?= $Page->revisi_rnd_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->revisi_rnd_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_revisi_rnd_tgl"><span id="el_order_pengembangan_revisi_rnd_tgl">
<input type="<?= $Page->revisi_rnd_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_revisi_rnd_tgl" name="x_revisi_rnd_tgl" id="x_revisi_rnd_tgl" placeholder="<?= HtmlEncode($Page->revisi_rnd_tgl->getPlaceHolder()) ?>" value="<?= $Page->revisi_rnd_tgl->EditValue ?>"<?= $Page->revisi_rnd_tgl->editAttributes() ?> aria-describedby="x_revisi_rnd_tgl_help">
<?= $Page->revisi_rnd_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisi_rnd_tgl->getErrorMessage() ?></div>
<?php if (!$Page->revisi_rnd_tgl->ReadOnly && !$Page->revisi_rnd_tgl->Disabled && !isset($Page->revisi_rnd_tgl->EditAttrs["readonly"]) && !isset($Page->revisi_rnd_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_revisi_rnd_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->revisi_rnd_oleh->Visible) { // revisi_rnd_oleh ?>
    <div id="r_revisi_rnd_oleh" class="form-group row">
        <label id="elh_order_pengembangan_revisi_rnd_oleh" for="x_revisi_rnd_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_revisi_rnd_oleh"><?= $Page->revisi_rnd_oleh->caption() ?><?= $Page->revisi_rnd_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->revisi_rnd_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_revisi_rnd_oleh"><span id="el_order_pengembangan_revisi_rnd_oleh">
<input type="<?= $Page->revisi_rnd_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_revisi_rnd_oleh" name="x_revisi_rnd_oleh" id="x_revisi_rnd_oleh" size="30" placeholder="<?= HtmlEncode($Page->revisi_rnd_oleh->getPlaceHolder()) ?>" value="<?= $Page->revisi_rnd_oleh->EditValue ?>"<?= $Page->revisi_rnd_oleh->editAttributes() ?> aria-describedby="x_revisi_rnd_oleh_help">
<?= $Page->revisi_rnd_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->revisi_rnd_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rnd_tgl->Visible) { // rnd_tgl ?>
    <div id="r_rnd_tgl" class="form-group row">
        <label id="elh_order_pengembangan_rnd_tgl" for="x_rnd_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_rnd_tgl"><?= $Page->rnd_tgl->caption() ?><?= $Page->rnd_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->rnd_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_rnd_tgl"><span id="el_order_pengembangan_rnd_tgl">
<input type="<?= $Page->rnd_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_rnd_tgl" name="x_rnd_tgl" id="x_rnd_tgl" placeholder="<?= HtmlEncode($Page->rnd_tgl->getPlaceHolder()) ?>" value="<?= $Page->rnd_tgl->EditValue ?>"<?= $Page->rnd_tgl->editAttributes() ?> aria-describedby="x_rnd_tgl_help">
<?= $Page->rnd_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rnd_tgl->getErrorMessage() ?></div>
<?php if (!$Page->rnd_tgl->ReadOnly && !$Page->rnd_tgl->Disabled && !isset($Page->rnd_tgl->EditAttrs["readonly"]) && !isset($Page->rnd_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_rnd_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rnd_oleh->Visible) { // rnd_oleh ?>
    <div id="r_rnd_oleh" class="form-group row">
        <label id="elh_order_pengembangan_rnd_oleh" for="x_rnd_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_rnd_oleh"><?= $Page->rnd_oleh->caption() ?><?= $Page->rnd_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->rnd_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_rnd_oleh"><span id="el_order_pengembangan_rnd_oleh">
<input type="<?= $Page->rnd_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_rnd_oleh" name="x_rnd_oleh" id="x_rnd_oleh" size="30" placeholder="<?= HtmlEncode($Page->rnd_oleh->getPlaceHolder()) ?>" value="<?= $Page->rnd_oleh->EditValue ?>"<?= $Page->rnd_oleh->editAttributes() ?> aria-describedby="x_rnd_oleh_help">
<?= $Page->rnd_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rnd_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ap_tgl->Visible) { // ap_tgl ?>
    <div id="r_ap_tgl" class="form-group row">
        <label id="elh_order_pengembangan_ap_tgl" for="x_ap_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_ap_tgl"><?= $Page->ap_tgl->caption() ?><?= $Page->ap_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ap_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_ap_tgl"><span id="el_order_pengembangan_ap_tgl">
<input type="<?= $Page->ap_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_ap_tgl" name="x_ap_tgl" id="x_ap_tgl" placeholder="<?= HtmlEncode($Page->ap_tgl->getPlaceHolder()) ?>" value="<?= $Page->ap_tgl->EditValue ?>"<?= $Page->ap_tgl->editAttributes() ?> aria-describedby="x_ap_tgl_help">
<?= $Page->ap_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ap_tgl->getErrorMessage() ?></div>
<?php if (!$Page->ap_tgl->ReadOnly && !$Page->ap_tgl->Disabled && !isset($Page->ap_tgl->EditAttrs["readonly"]) && !isset($Page->ap_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_ap_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ap_oleh->Visible) { // ap_oleh ?>
    <div id="r_ap_oleh" class="form-group row">
        <label id="elh_order_pengembangan_ap_oleh" for="x_ap_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_ap_oleh"><?= $Page->ap_oleh->caption() ?><?= $Page->ap_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ap_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_ap_oleh"><span id="el_order_pengembangan_ap_oleh">
<input type="<?= $Page->ap_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_ap_oleh" name="x_ap_oleh" id="x_ap_oleh" size="30" placeholder="<?= HtmlEncode($Page->ap_oleh->getPlaceHolder()) ?>" value="<?= $Page->ap_oleh->EditValue ?>"<?= $Page->ap_oleh->editAttributes() ?> aria-describedby="x_ap_oleh_help">
<?= $Page->ap_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ap_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->batal_tgl->Visible) { // batal_tgl ?>
    <div id="r_batal_tgl" class="form-group row">
        <label id="elh_order_pengembangan_batal_tgl" for="x_batal_tgl" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_batal_tgl"><?= $Page->batal_tgl->caption() ?><?= $Page->batal_tgl->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->batal_tgl->cellAttributes() ?>>
<template id="tpx_order_pengembangan_batal_tgl"><span id="el_order_pengembangan_batal_tgl">
<input type="<?= $Page->batal_tgl->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_batal_tgl" name="x_batal_tgl" id="x_batal_tgl" placeholder="<?= HtmlEncode($Page->batal_tgl->getPlaceHolder()) ?>" value="<?= $Page->batal_tgl->EditValue ?>"<?= $Page->batal_tgl->editAttributes() ?> aria-describedby="x_batal_tgl_help">
<?= $Page->batal_tgl->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->batal_tgl->getErrorMessage() ?></div>
<?php if (!$Page->batal_tgl->ReadOnly && !$Page->batal_tgl->Disabled && !isset($Page->batal_tgl->EditAttrs["readonly"]) && !isset($Page->batal_tgl->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["forder_pengembanganadd", "datetimepicker"], function() {
    ew.createDateTimePicker("forder_pengembanganadd", "x_batal_tgl", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->batal_oleh->Visible) { // batal_oleh ?>
    <div id="r_batal_oleh" class="form-group row">
        <label id="elh_order_pengembangan_batal_oleh" for="x_batal_oleh" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_order_pengembangan_batal_oleh"><?= $Page->batal_oleh->caption() ?><?= $Page->batal_oleh->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->batal_oleh->cellAttributes() ?>>
<template id="tpx_order_pengembangan_batal_oleh"><span id="el_order_pengembangan_batal_oleh">
<input type="<?= $Page->batal_oleh->getInputTextType() ?>" data-table="order_pengembangan" data-field="x_batal_oleh" name="x_batal_oleh" id="x_batal_oleh" size="30" placeholder="<?= HtmlEncode($Page->batal_oleh->getPlaceHolder()) ?>" value="<?= $Page->batal_oleh->EditValue ?>"<?= $Page->batal_oleh->editAttributes() ?> aria-describedby="x_batal_oleh_help">
<?= $Page->batal_oleh->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->batal_oleh->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_order_pengembanganadd" class="ew-custom-template"></div>
<template id="tpm_order_pengembanganadd">
<div id="ct_OrderPengembanganAdd"><?php include_once "custom_views/order_sampel.php" ?>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_order_pengembanganadd", "tpm_order_pengembanganadd", "order_pengembanganadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("order_pengembangan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
