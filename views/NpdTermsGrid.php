<?php

namespace PHPMaker2021\distributor;

// Set up and run Grid object
$Grid = Container("NpdTermsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_termsgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fnpd_termsgrid = new ew.Form("fnpd_termsgrid", "grid");
    fnpd_termsgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_terms)
        ew.vars.tables.npd_terms = currentTable;
    fnpd_termsgrid.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["sifat_order", [fields.sifat_order.visible && fields.sifat_order.required ? ew.Validators.required(fields.sifat_order.caption) : null], fields.sifat_order.isInvalid],
        ["ukuran_utama", [fields.ukuran_utama.visible && fields.ukuran_utama.required ? ew.Validators.required(fields.ukuran_utama.caption) : null], fields.ukuran_utama.isInvalid],
        ["utama_harga_isi", [fields.utama_harga_isi.visible && fields.utama_harga_isi.required ? ew.Validators.required(fields.utama_harga_isi.caption) : null, ew.Validators.integer], fields.utama_harga_isi.isInvalid],
        ["utama_harga_isi_order", [fields.utama_harga_isi_order.visible && fields.utama_harga_isi_order.required ? ew.Validators.required(fields.utama_harga_isi_order.caption) : null, ew.Validators.integer], fields.utama_harga_isi_order.isInvalid],
        ["utama_harga_primer", [fields.utama_harga_primer.visible && fields.utama_harga_primer.required ? ew.Validators.required(fields.utama_harga_primer.caption) : null, ew.Validators.integer], fields.utama_harga_primer.isInvalid],
        ["utama_harga_primer_order", [fields.utama_harga_primer_order.visible && fields.utama_harga_primer_order.required ? ew.Validators.required(fields.utama_harga_primer_order.caption) : null, ew.Validators.integer], fields.utama_harga_primer_order.isInvalid],
        ["utama_harga_sekunder", [fields.utama_harga_sekunder.visible && fields.utama_harga_sekunder.required ? ew.Validators.required(fields.utama_harga_sekunder.caption) : null, ew.Validators.integer], fields.utama_harga_sekunder.isInvalid],
        ["utama_harga_sekunder_order", [fields.utama_harga_sekunder_order.visible && fields.utama_harga_sekunder_order.required ? ew.Validators.required(fields.utama_harga_sekunder_order.caption) : null, ew.Validators.integer], fields.utama_harga_sekunder_order.isInvalid],
        ["utama_harga_label", [fields.utama_harga_label.visible && fields.utama_harga_label.required ? ew.Validators.required(fields.utama_harga_label.caption) : null, ew.Validators.integer], fields.utama_harga_label.isInvalid],
        ["utama_harga_label_order", [fields.utama_harga_label_order.visible && fields.utama_harga_label_order.required ? ew.Validators.required(fields.utama_harga_label_order.caption) : null, ew.Validators.integer], fields.utama_harga_label_order.isInvalid],
        ["utama_harga_total", [fields.utama_harga_total.visible && fields.utama_harga_total.required ? ew.Validators.required(fields.utama_harga_total.caption) : null, ew.Validators.integer], fields.utama_harga_total.isInvalid],
        ["utama_harga_total_order", [fields.utama_harga_total_order.visible && fields.utama_harga_total_order.required ? ew.Validators.required(fields.utama_harga_total_order.caption) : null, ew.Validators.integer], fields.utama_harga_total_order.isInvalid],
        ["ukuran_lain", [fields.ukuran_lain.visible && fields.ukuran_lain.required ? ew.Validators.required(fields.ukuran_lain.caption) : null], fields.ukuran_lain.isInvalid],
        ["lain_harga_isi", [fields.lain_harga_isi.visible && fields.lain_harga_isi.required ? ew.Validators.required(fields.lain_harga_isi.caption) : null, ew.Validators.integer], fields.lain_harga_isi.isInvalid],
        ["lain_harga_isi_order", [fields.lain_harga_isi_order.visible && fields.lain_harga_isi_order.required ? ew.Validators.required(fields.lain_harga_isi_order.caption) : null, ew.Validators.integer], fields.lain_harga_isi_order.isInvalid],
        ["lain_harga_primer", [fields.lain_harga_primer.visible && fields.lain_harga_primer.required ? ew.Validators.required(fields.lain_harga_primer.caption) : null, ew.Validators.integer], fields.lain_harga_primer.isInvalid],
        ["lain_harga_primer_order", [fields.lain_harga_primer_order.visible && fields.lain_harga_primer_order.required ? ew.Validators.required(fields.lain_harga_primer_order.caption) : null, ew.Validators.integer], fields.lain_harga_primer_order.isInvalid],
        ["lain_harga_sekunder", [fields.lain_harga_sekunder.visible && fields.lain_harga_sekunder.required ? ew.Validators.required(fields.lain_harga_sekunder.caption) : null, ew.Validators.integer], fields.lain_harga_sekunder.isInvalid],
        ["lain_harga_sekunder_order", [fields.lain_harga_sekunder_order.visible && fields.lain_harga_sekunder_order.required ? ew.Validators.required(fields.lain_harga_sekunder_order.caption) : null, ew.Validators.integer], fields.lain_harga_sekunder_order.isInvalid],
        ["lain_harga_label", [fields.lain_harga_label.visible && fields.lain_harga_label.required ? ew.Validators.required(fields.lain_harga_label.caption) : null, ew.Validators.integer], fields.lain_harga_label.isInvalid],
        ["lain_harga_label_order", [fields.lain_harga_label_order.visible && fields.lain_harga_label_order.required ? ew.Validators.required(fields.lain_harga_label_order.caption) : null, ew.Validators.integer], fields.lain_harga_label_order.isInvalid],
        ["lain_harga_total", [fields.lain_harga_total.visible && fields.lain_harga_total.required ? ew.Validators.required(fields.lain_harga_total.caption) : null, ew.Validators.integer], fields.lain_harga_total.isInvalid],
        ["lain_harga_total_order", [fields.lain_harga_total_order.visible && fields.lain_harga_total_order.required ? ew.Validators.required(fields.lain_harga_total_order.caption) : null, ew.Validators.integer], fields.lain_harga_total_order.isInvalid],
        ["isi_bahan_aktif", [fields.isi_bahan_aktif.visible && fields.isi_bahan_aktif.required ? ew.Validators.required(fields.isi_bahan_aktif.caption) : null], fields.isi_bahan_aktif.isInvalid],
        ["isi_bahan_lain", [fields.isi_bahan_lain.visible && fields.isi_bahan_lain.required ? ew.Validators.required(fields.isi_bahan_lain.caption) : null], fields.isi_bahan_lain.isInvalid],
        ["isi_parfum", [fields.isi_parfum.visible && fields.isi_parfum.required ? ew.Validators.required(fields.isi_parfum.caption) : null], fields.isi_parfum.isInvalid],
        ["isi_estetika", [fields.isi_estetika.visible && fields.isi_estetika.required ? ew.Validators.required(fields.isi_estetika.caption) : null], fields.isi_estetika.isInvalid],
        ["kemasan_wadah", [fields.kemasan_wadah.visible && fields.kemasan_wadah.required ? ew.Validators.required(fields.kemasan_wadah.caption) : null, ew.Validators.integer], fields.kemasan_wadah.isInvalid],
        ["kemasan_tutup", [fields.kemasan_tutup.visible && fields.kemasan_tutup.required ? ew.Validators.required(fields.kemasan_tutup.caption) : null, ew.Validators.integer], fields.kemasan_tutup.isInvalid],
        ["kemasan_sekunder", [fields.kemasan_sekunder.visible && fields.kemasan_sekunder.required ? ew.Validators.required(fields.kemasan_sekunder.caption) : null], fields.kemasan_sekunder.isInvalid],
        ["label_desain", [fields.label_desain.visible && fields.label_desain.required ? ew.Validators.required(fields.label_desain.caption) : null], fields.label_desain.isInvalid],
        ["label_cetak", [fields.label_cetak.visible && fields.label_cetak.required ? ew.Validators.required(fields.label_cetak.caption) : null], fields.label_cetak.isInvalid],
        ["label_lainlain", [fields.label_lainlain.visible && fields.label_lainlain.required ? ew.Validators.required(fields.label_lainlain.caption) : null], fields.label_lainlain.isInvalid],
        ["delivery_pickup", [fields.delivery_pickup.visible && fields.delivery_pickup.required ? ew.Validators.required(fields.delivery_pickup.caption) : null], fields.delivery_pickup.isInvalid],
        ["delivery_singlepoint", [fields.delivery_singlepoint.visible && fields.delivery_singlepoint.required ? ew.Validators.required(fields.delivery_singlepoint.caption) : null], fields.delivery_singlepoint.isInvalid],
        ["delivery_multipoint", [fields.delivery_multipoint.visible && fields.delivery_multipoint.required ? ew.Validators.required(fields.delivery_multipoint.caption) : null], fields.delivery_multipoint.isInvalid],
        ["delivery_jumlahpoint", [fields.delivery_jumlahpoint.visible && fields.delivery_jumlahpoint.required ? ew.Validators.required(fields.delivery_jumlahpoint.caption) : null], fields.delivery_jumlahpoint.isInvalid],
        ["delivery_termslain", [fields.delivery_termslain.visible && fields.delivery_termslain.required ? ew.Validators.required(fields.delivery_termslain.caption) : null], fields.delivery_termslain.isInvalid],
        ["dibuatdi", [fields.dibuatdi.visible && fields.dibuatdi.required ? ew.Validators.required(fields.dibuatdi.caption) : null], fields.dibuatdi.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_termsgrid,
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
    fnpd_termsgrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fnpd_termsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "idnpd", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "status", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglsubmit", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sifat_order[]", true))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ukuran_utama", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_isi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_isi_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_primer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_primer_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_sekunder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_sekunder_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_label", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_label_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_total", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "utama_harga_total_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ukuran_lain", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_isi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_isi_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_primer", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_primer_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_sekunder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_sekunder_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_label", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_label_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_total", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "lain_harga_total_order", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "isi_bahan_aktif", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "isi_bahan_lain", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "isi_parfum", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "isi_estetika", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kemasan_wadah", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kemasan_tutup", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kemasan_sekunder", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "label_desain", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "label_cetak", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "label_lainlain", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "delivery_pickup", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "delivery_singlepoint", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "delivery_multipoint", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "delivery_jumlahpoint", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "delivery_termslain", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "dibuatdi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "created_at", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fnpd_termsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_termsgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_termsgrid.lists.sifat_order = <?= $Grid->sifat_order->toClientList($Grid) ?>;
    loadjs.done("fnpd_termsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> npd_terms">
<div id="fnpd_termsgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_npd_terms" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_npd_termsgrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <th data-name="idnpd" class="<?= $Grid->idnpd->headerCellClass() ?>"><div id="elh_npd_terms_idnpd" class="npd_terms_idnpd"><?= $Grid->renderSort($Grid->idnpd) ?></div></th>
<?php } ?>
<?php if ($Grid->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Grid->status->headerCellClass() ?>"><div id="elh_npd_terms_status" class="npd_terms_status"><?= $Grid->renderSort($Grid->status) ?></div></th>
<?php } ?>
<?php if ($Grid->tglsubmit->Visible) { // tglsubmit ?>
        <th data-name="tglsubmit" class="<?= $Grid->tglsubmit->headerCellClass() ?>"><div id="elh_npd_terms_tglsubmit" class="npd_terms_tglsubmit"><?= $Grid->renderSort($Grid->tglsubmit) ?></div></th>
<?php } ?>
<?php if ($Grid->sifat_order->Visible) { // sifat_order ?>
        <th data-name="sifat_order" class="<?= $Grid->sifat_order->headerCellClass() ?>"><div id="elh_npd_terms_sifat_order" class="npd_terms_sifat_order"><?= $Grid->renderSort($Grid->sifat_order) ?></div></th>
<?php } ?>
<?php if ($Grid->ukuran_utama->Visible) { // ukuran_utama ?>
        <th data-name="ukuran_utama" class="<?= $Grid->ukuran_utama->headerCellClass() ?>"><div id="elh_npd_terms_ukuran_utama" class="npd_terms_ukuran_utama"><?= $Grid->renderSort($Grid->ukuran_utama) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <th data-name="utama_harga_isi" class="<?= $Grid->utama_harga_isi->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_isi" class="npd_terms_utama_harga_isi"><?= $Grid->renderSort($Grid->utama_harga_isi) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <th data-name="utama_harga_isi_order" class="<?= $Grid->utama_harga_isi_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_isi_order" class="npd_terms_utama_harga_isi_order"><?= $Grid->renderSort($Grid->utama_harga_isi_order) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <th data-name="utama_harga_primer" class="<?= $Grid->utama_harga_primer->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_primer" class="npd_terms_utama_harga_primer"><?= $Grid->renderSort($Grid->utama_harga_primer) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <th data-name="utama_harga_primer_order" class="<?= $Grid->utama_harga_primer_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_primer_order" class="npd_terms_utama_harga_primer_order"><?= $Grid->renderSort($Grid->utama_harga_primer_order) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <th data-name="utama_harga_sekunder" class="<?= $Grid->utama_harga_sekunder->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_sekunder" class="npd_terms_utama_harga_sekunder"><?= $Grid->renderSort($Grid->utama_harga_sekunder) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <th data-name="utama_harga_sekunder_order" class="<?= $Grid->utama_harga_sekunder_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_sekunder_order" class="npd_terms_utama_harga_sekunder_order"><?= $Grid->renderSort($Grid->utama_harga_sekunder_order) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_label->Visible) { // utama_harga_label ?>
        <th data-name="utama_harga_label" class="<?= $Grid->utama_harga_label->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_label" class="npd_terms_utama_harga_label"><?= $Grid->renderSort($Grid->utama_harga_label) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <th data-name="utama_harga_label_order" class="<?= $Grid->utama_harga_label_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_label_order" class="npd_terms_utama_harga_label_order"><?= $Grid->renderSort($Grid->utama_harga_label_order) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_total->Visible) { // utama_harga_total ?>
        <th data-name="utama_harga_total" class="<?= $Grid->utama_harga_total->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_total" class="npd_terms_utama_harga_total"><?= $Grid->renderSort($Grid->utama_harga_total) ?></div></th>
<?php } ?>
<?php if ($Grid->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <th data-name="utama_harga_total_order" class="<?= $Grid->utama_harga_total_order->headerCellClass() ?>"><div id="elh_npd_terms_utama_harga_total_order" class="npd_terms_utama_harga_total_order"><?= $Grid->renderSort($Grid->utama_harga_total_order) ?></div></th>
<?php } ?>
<?php if ($Grid->ukuran_lain->Visible) { // ukuran_lain ?>
        <th data-name="ukuran_lain" class="<?= $Grid->ukuran_lain->headerCellClass() ?>"><div id="elh_npd_terms_ukuran_lain" class="npd_terms_ukuran_lain"><?= $Grid->renderSort($Grid->ukuran_lain) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <th data-name="lain_harga_isi" class="<?= $Grid->lain_harga_isi->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_isi" class="npd_terms_lain_harga_isi"><?= $Grid->renderSort($Grid->lain_harga_isi) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <th data-name="lain_harga_isi_order" class="<?= $Grid->lain_harga_isi_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_isi_order" class="npd_terms_lain_harga_isi_order"><?= $Grid->renderSort($Grid->lain_harga_isi_order) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <th data-name="lain_harga_primer" class="<?= $Grid->lain_harga_primer->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_primer" class="npd_terms_lain_harga_primer"><?= $Grid->renderSort($Grid->lain_harga_primer) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <th data-name="lain_harga_primer_order" class="<?= $Grid->lain_harga_primer_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_primer_order" class="npd_terms_lain_harga_primer_order"><?= $Grid->renderSort($Grid->lain_harga_primer_order) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <th data-name="lain_harga_sekunder" class="<?= $Grid->lain_harga_sekunder->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_sekunder" class="npd_terms_lain_harga_sekunder"><?= $Grid->renderSort($Grid->lain_harga_sekunder) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <th data-name="lain_harga_sekunder_order" class="<?= $Grid->lain_harga_sekunder_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_sekunder_order" class="npd_terms_lain_harga_sekunder_order"><?= $Grid->renderSort($Grid->lain_harga_sekunder_order) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_label->Visible) { // lain_harga_label ?>
        <th data-name="lain_harga_label" class="<?= $Grid->lain_harga_label->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_label" class="npd_terms_lain_harga_label"><?= $Grid->renderSort($Grid->lain_harga_label) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <th data-name="lain_harga_label_order" class="<?= $Grid->lain_harga_label_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_label_order" class="npd_terms_lain_harga_label_order"><?= $Grid->renderSort($Grid->lain_harga_label_order) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_total->Visible) { // lain_harga_total ?>
        <th data-name="lain_harga_total" class="<?= $Grid->lain_harga_total->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_total" class="npd_terms_lain_harga_total"><?= $Grid->renderSort($Grid->lain_harga_total) ?></div></th>
<?php } ?>
<?php if ($Grid->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <th data-name="lain_harga_total_order" class="<?= $Grid->lain_harga_total_order->headerCellClass() ?>"><div id="elh_npd_terms_lain_harga_total_order" class="npd_terms_lain_harga_total_order"><?= $Grid->renderSort($Grid->lain_harga_total_order) ?></div></th>
<?php } ?>
<?php if ($Grid->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <th data-name="isi_bahan_aktif" class="<?= $Grid->isi_bahan_aktif->headerCellClass() ?>"><div id="elh_npd_terms_isi_bahan_aktif" class="npd_terms_isi_bahan_aktif"><?= $Grid->renderSort($Grid->isi_bahan_aktif) ?></div></th>
<?php } ?>
<?php if ($Grid->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <th data-name="isi_bahan_lain" class="<?= $Grid->isi_bahan_lain->headerCellClass() ?>"><div id="elh_npd_terms_isi_bahan_lain" class="npd_terms_isi_bahan_lain"><?= $Grid->renderSort($Grid->isi_bahan_lain) ?></div></th>
<?php } ?>
<?php if ($Grid->isi_parfum->Visible) { // isi_parfum ?>
        <th data-name="isi_parfum" class="<?= $Grid->isi_parfum->headerCellClass() ?>"><div id="elh_npd_terms_isi_parfum" class="npd_terms_isi_parfum"><?= $Grid->renderSort($Grid->isi_parfum) ?></div></th>
<?php } ?>
<?php if ($Grid->isi_estetika->Visible) { // isi_estetika ?>
        <th data-name="isi_estetika" class="<?= $Grid->isi_estetika->headerCellClass() ?>"><div id="elh_npd_terms_isi_estetika" class="npd_terms_isi_estetika"><?= $Grid->renderSort($Grid->isi_estetika) ?></div></th>
<?php } ?>
<?php if ($Grid->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <th data-name="kemasan_wadah" class="<?= $Grid->kemasan_wadah->headerCellClass() ?>"><div id="elh_npd_terms_kemasan_wadah" class="npd_terms_kemasan_wadah"><?= $Grid->renderSort($Grid->kemasan_wadah) ?></div></th>
<?php } ?>
<?php if ($Grid->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <th data-name="kemasan_tutup" class="<?= $Grid->kemasan_tutup->headerCellClass() ?>"><div id="elh_npd_terms_kemasan_tutup" class="npd_terms_kemasan_tutup"><?= $Grid->renderSort($Grid->kemasan_tutup) ?></div></th>
<?php } ?>
<?php if ($Grid->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <th data-name="kemasan_sekunder" class="<?= $Grid->kemasan_sekunder->headerCellClass() ?>"><div id="elh_npd_terms_kemasan_sekunder" class="npd_terms_kemasan_sekunder"><?= $Grid->renderSort($Grid->kemasan_sekunder) ?></div></th>
<?php } ?>
<?php if ($Grid->label_desain->Visible) { // label_desain ?>
        <th data-name="label_desain" class="<?= $Grid->label_desain->headerCellClass() ?>"><div id="elh_npd_terms_label_desain" class="npd_terms_label_desain"><?= $Grid->renderSort($Grid->label_desain) ?></div></th>
<?php } ?>
<?php if ($Grid->label_cetak->Visible) { // label_cetak ?>
        <th data-name="label_cetak" class="<?= $Grid->label_cetak->headerCellClass() ?>"><div id="elh_npd_terms_label_cetak" class="npd_terms_label_cetak"><?= $Grid->renderSort($Grid->label_cetak) ?></div></th>
<?php } ?>
<?php if ($Grid->label_lainlain->Visible) { // label_lainlain ?>
        <th data-name="label_lainlain" class="<?= $Grid->label_lainlain->headerCellClass() ?>"><div id="elh_npd_terms_label_lainlain" class="npd_terms_label_lainlain"><?= $Grid->renderSort($Grid->label_lainlain) ?></div></th>
<?php } ?>
<?php if ($Grid->delivery_pickup->Visible) { // delivery_pickup ?>
        <th data-name="delivery_pickup" class="<?= $Grid->delivery_pickup->headerCellClass() ?>"><div id="elh_npd_terms_delivery_pickup" class="npd_terms_delivery_pickup"><?= $Grid->renderSort($Grid->delivery_pickup) ?></div></th>
<?php } ?>
<?php if ($Grid->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <th data-name="delivery_singlepoint" class="<?= $Grid->delivery_singlepoint->headerCellClass() ?>"><div id="elh_npd_terms_delivery_singlepoint" class="npd_terms_delivery_singlepoint"><?= $Grid->renderSort($Grid->delivery_singlepoint) ?></div></th>
<?php } ?>
<?php if ($Grid->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <th data-name="delivery_multipoint" class="<?= $Grid->delivery_multipoint->headerCellClass() ?>"><div id="elh_npd_terms_delivery_multipoint" class="npd_terms_delivery_multipoint"><?= $Grid->renderSort($Grid->delivery_multipoint) ?></div></th>
<?php } ?>
<?php if ($Grid->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <th data-name="delivery_jumlahpoint" class="<?= $Grid->delivery_jumlahpoint->headerCellClass() ?>"><div id="elh_npd_terms_delivery_jumlahpoint" class="npd_terms_delivery_jumlahpoint"><?= $Grid->renderSort($Grid->delivery_jumlahpoint) ?></div></th>
<?php } ?>
<?php if ($Grid->delivery_termslain->Visible) { // delivery_termslain ?>
        <th data-name="delivery_termslain" class="<?= $Grid->delivery_termslain->headerCellClass() ?>"><div id="elh_npd_terms_delivery_termslain" class="npd_terms_delivery_termslain"><?= $Grid->renderSort($Grid->delivery_termslain) ?></div></th>
<?php } ?>
<?php if ($Grid->dibuatdi->Visible) { // dibuatdi ?>
        <th data-name="dibuatdi" class="<?= $Grid->dibuatdi->headerCellClass() ?>"><div id="elh_npd_terms_dibuatdi" class="npd_terms_dibuatdi"><?= $Grid->renderSort($Grid->dibuatdi) ?></div></th>
<?php } ?>
<?php if ($Grid->created_at->Visible) { // created_at ?>
        <th data-name="created_at" class="<?= $Grid->created_at->headerCellClass() ?>"><div id="elh_npd_terms_created_at" class="npd_terms_created_at"><?= $Grid->renderSort($Grid->created_at) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_npd_terms", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd" <?= $Grid->idnpd->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_terms" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_idnpd" class="form-group">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_idnpd" class="form-group">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_terms" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<?= $Grid->idnpd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_idnpd" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_idnpd" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_idnpd" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_idnpd" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status" <?= $Grid->status->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="npd_terms" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_status" class="form-group">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="npd_terms" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_status">
<span<?= $Grid->status->viewAttributes() ?>>
<?= $Grid->status->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_status" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_status" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_status" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_status" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglsubmit->Visible) { // tglsubmit ?>
        <td data-name="tglsubmit" <?= $Grid->tglsubmit->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_tglsubmit" class="form-group">
<input type="<?= $Grid->tglsubmit->getInputTextType() ?>" data-table="npd_terms" data-field="x_tglsubmit" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" placeholder="<?= HtmlEncode($Grid->tglsubmit->getPlaceHolder()) ?>" value="<?= $Grid->tglsubmit->EditValue ?>"<?= $Grid->tglsubmit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Grid->tglsubmit->ReadOnly && !$Grid->tglsubmit->Disabled && !isset($Grid->tglsubmit->EditAttrs["readonly"]) && !isset($Grid->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsgrid", "x<?= $Grid->RowIndex ?>_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_tglsubmit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglsubmit" id="o<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_tglsubmit" class="form-group">
<input type="<?= $Grid->tglsubmit->getInputTextType() ?>" data-table="npd_terms" data-field="x_tglsubmit" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" placeholder="<?= HtmlEncode($Grid->tglsubmit->getPlaceHolder()) ?>" value="<?= $Grid->tglsubmit->EditValue ?>"<?= $Grid->tglsubmit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Grid->tglsubmit->ReadOnly && !$Grid->tglsubmit->Disabled && !isset($Grid->tglsubmit->EditAttrs["readonly"]) && !isset($Grid->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsgrid", "x<?= $Grid->RowIndex ?>_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_tglsubmit">
<span<?= $Grid->tglsubmit->viewAttributes() ?>>
<?= $Grid->tglsubmit->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_tglsubmit" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_tglsubmit" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_tglsubmit" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_tglsubmit" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sifat_order->Visible) { // sifat_order ?>
        <td data-name="sifat_order" <?= $Grid->sifat_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_sifat_order" class="form-group">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Grid->sifat_order->isInvalidClass() ?>" data-table="npd_terms" data-field="x_sifat_order" name="x<?= $Grid->RowIndex ?>_sifat_order[]" id="x<?= $Grid->RowIndex ?>_sifat_order_144232" value="1"<?= ConvertToBool($Grid->sifat_order->CurrentValue) ? " checked" : "" ?><?= $Grid->sifat_order->editAttributes() ?>>
    <label class="custom-control-label" for="x<?= $Grid->RowIndex ?>_sifat_order_144232"></label>
</div>
<div class="invalid-feedback"><?= $Grid->sifat_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_sifat_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sifat_order[]" id="o<?= $Grid->RowIndex ?>_sifat_order[]" value="<?= HtmlEncode($Grid->sifat_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_sifat_order" class="form-group">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Grid->sifat_order->isInvalidClass() ?>" data-table="npd_terms" data-field="x_sifat_order" name="x<?= $Grid->RowIndex ?>_sifat_order[]" id="x<?= $Grid->RowIndex ?>_sifat_order_745094" value="1"<?= ConvertToBool($Grid->sifat_order->CurrentValue) ? " checked" : "" ?><?= $Grid->sifat_order->editAttributes() ?>>
    <label class="custom-control-label" for="x<?= $Grid->RowIndex ?>_sifat_order_745094"></label>
</div>
<div class="invalid-feedback"><?= $Grid->sifat_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_sifat_order">
<span<?= $Grid->sifat_order->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifat_order_<?= $Grid->RowCount ?>" class="custom-control-input" value="<?= $Grid->sifat_order->getViewValue() ?>" disabled<?php if (ConvertToBool($Grid->sifat_order->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifat_order_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_sifat_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_sifat_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_sifat_order" value="<?= HtmlEncode($Grid->sifat_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_sifat_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_sifat_order[]" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_sifat_order[]" value="<?= HtmlEncode($Grid->sifat_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ukuran_utama->Visible) { // ukuran_utama ?>
        <td data-name="ukuran_utama" <?= $Grid->ukuran_utama->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_ukuran_utama" class="form-group">
<input type="<?= $Grid->ukuran_utama->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_utama" name="x<?= $Grid->RowIndex ?>_ukuran_utama" id="x<?= $Grid->RowIndex ?>_ukuran_utama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran_utama->getPlaceHolder()) ?>" value="<?= $Grid->ukuran_utama->EditValue ?>"<?= $Grid->ukuran_utama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran_utama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_utama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran_utama" id="o<?= $Grid->RowIndex ?>_ukuran_utama" value="<?= HtmlEncode($Grid->ukuran_utama->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_ukuran_utama" class="form-group">
<input type="<?= $Grid->ukuran_utama->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_utama" name="x<?= $Grid->RowIndex ?>_ukuran_utama" id="x<?= $Grid->RowIndex ?>_ukuran_utama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran_utama->getPlaceHolder()) ?>" value="<?= $Grid->ukuran_utama->EditValue ?>"<?= $Grid->ukuran_utama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran_utama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_ukuran_utama">
<span<?= $Grid->ukuran_utama->viewAttributes() ?>>
<?= $Grid->ukuran_utama->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_utama" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_ukuran_utama" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_ukuran_utama" value="<?= HtmlEncode($Grid->ukuran_utama->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_utama" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_ukuran_utama" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_ukuran_utama" value="<?= HtmlEncode($Grid->ukuran_utama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <td data-name="utama_harga_isi" <?= $Grid->utama_harga_isi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_isi" class="form-group">
<input type="<?= $Grid->utama_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi" name="x<?= $Grid->RowIndex ?>_utama_harga_isi" id="x<?= $Grid->RowIndex ?>_utama_harga_isi" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_isi->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_isi->EditValue ?>"<?= $Grid->utama_harga_isi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_isi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_isi" id="o<?= $Grid->RowIndex ?>_utama_harga_isi" value="<?= HtmlEncode($Grid->utama_harga_isi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_isi" class="form-group">
<input type="<?= $Grid->utama_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi" name="x<?= $Grid->RowIndex ?>_utama_harga_isi" id="x<?= $Grid->RowIndex ?>_utama_harga_isi" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_isi->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_isi->EditValue ?>"<?= $Grid->utama_harga_isi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_isi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_isi">
<span<?= $Grid->utama_harga_isi->viewAttributes() ?>>
<?= $Grid->utama_harga_isi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_isi" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_isi" value="<?= HtmlEncode($Grid->utama_harga_isi->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_isi" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_isi" value="<?= HtmlEncode($Grid->utama_harga_isi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <td data-name="utama_harga_isi_order" <?= $Grid->utama_harga_isi_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_isi_order" class="form-group">
<input type="<?= $Grid->utama_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi_order" name="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_isi_order->EditValue ?>"<?= $Grid->utama_harga_isi_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_isi_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="o<?= $Grid->RowIndex ?>_utama_harga_isi_order" value="<?= HtmlEncode($Grid->utama_harga_isi_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_isi_order" class="form-group">
<input type="<?= $Grid->utama_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi_order" name="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_isi_order->EditValue ?>"<?= $Grid->utama_harga_isi_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_isi_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_isi_order">
<span<?= $Grid->utama_harga_isi_order->viewAttributes() ?>>
<?= $Grid->utama_harga_isi_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_isi_order" value="<?= HtmlEncode($Grid->utama_harga_isi_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_isi_order" value="<?= HtmlEncode($Grid->utama_harga_isi_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <td data-name="utama_harga_primer" <?= $Grid->utama_harga_primer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_primer" class="form-group">
<input type="<?= $Grid->utama_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer" name="x<?= $Grid->RowIndex ?>_utama_harga_primer" id="x<?= $Grid->RowIndex ?>_utama_harga_primer" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_primer->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_primer->EditValue ?>"<?= $Grid->utama_harga_primer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_primer->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_primer" id="o<?= $Grid->RowIndex ?>_utama_harga_primer" value="<?= HtmlEncode($Grid->utama_harga_primer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_primer" class="form-group">
<input type="<?= $Grid->utama_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer" name="x<?= $Grid->RowIndex ?>_utama_harga_primer" id="x<?= $Grid->RowIndex ?>_utama_harga_primer" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_primer->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_primer->EditValue ?>"<?= $Grid->utama_harga_primer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_primer->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_primer">
<span<?= $Grid->utama_harga_primer->viewAttributes() ?>>
<?= $Grid->utama_harga_primer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_primer" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_primer" value="<?= HtmlEncode($Grid->utama_harga_primer->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_primer" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_primer" value="<?= HtmlEncode($Grid->utama_harga_primer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <td data-name="utama_harga_primer_order" <?= $Grid->utama_harga_primer_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_primer_order" class="form-group">
<input type="<?= $Grid->utama_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer_order" name="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_primer_order->EditValue ?>"<?= $Grid->utama_harga_primer_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_primer_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="o<?= $Grid->RowIndex ?>_utama_harga_primer_order" value="<?= HtmlEncode($Grid->utama_harga_primer_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_primer_order" class="form-group">
<input type="<?= $Grid->utama_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer_order" name="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_primer_order->EditValue ?>"<?= $Grid->utama_harga_primer_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_primer_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_primer_order">
<span<?= $Grid->utama_harga_primer_order->viewAttributes() ?>>
<?= $Grid->utama_harga_primer_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_primer_order" value="<?= HtmlEncode($Grid->utama_harga_primer_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_primer_order" value="<?= HtmlEncode($Grid->utama_harga_primer_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <td data-name="utama_harga_sekunder" <?= $Grid->utama_harga_sekunder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_sekunder" class="form-group">
<input type="<?= $Grid->utama_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_sekunder->EditValue ?>"<?= $Grid->utama_harga_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_sekunder->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="o<?= $Grid->RowIndex ?>_utama_harga_sekunder" value="<?= HtmlEncode($Grid->utama_harga_sekunder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_sekunder" class="form-group">
<input type="<?= $Grid->utama_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_sekunder->EditValue ?>"<?= $Grid->utama_harga_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_sekunder->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_sekunder">
<span<?= $Grid->utama_harga_sekunder->viewAttributes() ?>>
<?= $Grid->utama_harga_sekunder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_sekunder" value="<?= HtmlEncode($Grid->utama_harga_sekunder->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_sekunder" value="<?= HtmlEncode($Grid->utama_harga_sekunder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <td data-name="utama_harga_sekunder_order" <?= $Grid->utama_harga_sekunder_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_sekunder_order" class="form-group">
<input type="<?= $Grid->utama_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_sekunder_order->EditValue ?>"<?= $Grid->utama_harga_sekunder_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_sekunder_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="o<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" value="<?= HtmlEncode($Grid->utama_harga_sekunder_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_sekunder_order" class="form-group">
<input type="<?= $Grid->utama_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_sekunder_order->EditValue ?>"<?= $Grid->utama_harga_sekunder_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_sekunder_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_sekunder_order">
<span<?= $Grid->utama_harga_sekunder_order->viewAttributes() ?>>
<?= $Grid->utama_harga_sekunder_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" value="<?= HtmlEncode($Grid->utama_harga_sekunder_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" value="<?= HtmlEncode($Grid->utama_harga_sekunder_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_label->Visible) { // utama_harga_label ?>
        <td data-name="utama_harga_label" <?= $Grid->utama_harga_label->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_label" class="form-group">
<input type="<?= $Grid->utama_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label" name="x<?= $Grid->RowIndex ?>_utama_harga_label" id="x<?= $Grid->RowIndex ?>_utama_harga_label" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_label->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_label->EditValue ?>"<?= $Grid->utama_harga_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_label->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_label" id="o<?= $Grid->RowIndex ?>_utama_harga_label" value="<?= HtmlEncode($Grid->utama_harga_label->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_label" class="form-group">
<input type="<?= $Grid->utama_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label" name="x<?= $Grid->RowIndex ?>_utama_harga_label" id="x<?= $Grid->RowIndex ?>_utama_harga_label" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_label->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_label->EditValue ?>"<?= $Grid->utama_harga_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_label->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_label">
<span<?= $Grid->utama_harga_label->viewAttributes() ?>>
<?= $Grid->utama_harga_label->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_label" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_label" value="<?= HtmlEncode($Grid->utama_harga_label->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_label" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_label" value="<?= HtmlEncode($Grid->utama_harga_label->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <td data-name="utama_harga_label_order" <?= $Grid->utama_harga_label_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_label_order" class="form-group">
<input type="<?= $Grid->utama_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label_order" name="x<?= $Grid->RowIndex ?>_utama_harga_label_order" id="x<?= $Grid->RowIndex ?>_utama_harga_label_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_label_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_label_order->EditValue ?>"<?= $Grid->utama_harga_label_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_label_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_label_order" id="o<?= $Grid->RowIndex ?>_utama_harga_label_order" value="<?= HtmlEncode($Grid->utama_harga_label_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_label_order" class="form-group">
<input type="<?= $Grid->utama_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label_order" name="x<?= $Grid->RowIndex ?>_utama_harga_label_order" id="x<?= $Grid->RowIndex ?>_utama_harga_label_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_label_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_label_order->EditValue ?>"<?= $Grid->utama_harga_label_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_label_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_label_order">
<span<?= $Grid->utama_harga_label_order->viewAttributes() ?>>
<?= $Grid->utama_harga_label_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_label_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_label_order" value="<?= HtmlEncode($Grid->utama_harga_label_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_label_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_label_order" value="<?= HtmlEncode($Grid->utama_harga_label_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_total->Visible) { // utama_harga_total ?>
        <td data-name="utama_harga_total" <?= $Grid->utama_harga_total->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_total" class="form-group">
<input type="<?= $Grid->utama_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total" name="x<?= $Grid->RowIndex ?>_utama_harga_total" id="x<?= $Grid->RowIndex ?>_utama_harga_total" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_total->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_total->EditValue ?>"<?= $Grid->utama_harga_total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_total" id="o<?= $Grid->RowIndex ?>_utama_harga_total" value="<?= HtmlEncode($Grid->utama_harga_total->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_total" class="form-group">
<input type="<?= $Grid->utama_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total" name="x<?= $Grid->RowIndex ?>_utama_harga_total" id="x<?= $Grid->RowIndex ?>_utama_harga_total" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_total->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_total->EditValue ?>"<?= $Grid->utama_harga_total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_total->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_total">
<span<?= $Grid->utama_harga_total->viewAttributes() ?>>
<?= $Grid->utama_harga_total->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_total" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_total" value="<?= HtmlEncode($Grid->utama_harga_total->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_total" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_total" value="<?= HtmlEncode($Grid->utama_harga_total->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <td data-name="utama_harga_total_order" <?= $Grid->utama_harga_total_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_total_order" class="form-group">
<input type="<?= $Grid->utama_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total_order" name="x<?= $Grid->RowIndex ?>_utama_harga_total_order" id="x<?= $Grid->RowIndex ?>_utama_harga_total_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_total_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_total_order->EditValue ?>"<?= $Grid->utama_harga_total_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_total_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_total_order" id="o<?= $Grid->RowIndex ?>_utama_harga_total_order" value="<?= HtmlEncode($Grid->utama_harga_total_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_total_order" class="form-group">
<input type="<?= $Grid->utama_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total_order" name="x<?= $Grid->RowIndex ?>_utama_harga_total_order" id="x<?= $Grid->RowIndex ?>_utama_harga_total_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_total_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_total_order->EditValue ?>"<?= $Grid->utama_harga_total_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_total_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_utama_harga_total_order">
<span<?= $Grid->utama_harga_total_order->viewAttributes() ?>>
<?= $Grid->utama_harga_total_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_total_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_utama_harga_total_order" value="<?= HtmlEncode($Grid->utama_harga_total_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_total_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_utama_harga_total_order" value="<?= HtmlEncode($Grid->utama_harga_total_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ukuran_lain->Visible) { // ukuran_lain ?>
        <td data-name="ukuran_lain" <?= $Grid->ukuran_lain->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_ukuran_lain" class="form-group">
<input type="<?= $Grid->ukuran_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_lain" name="x<?= $Grid->RowIndex ?>_ukuran_lain" id="x<?= $Grid->RowIndex ?>_ukuran_lain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran_lain->getPlaceHolder()) ?>" value="<?= $Grid->ukuran_lain->EditValue ?>"<?= $Grid->ukuran_lain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran_lain->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_lain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran_lain" id="o<?= $Grid->RowIndex ?>_ukuran_lain" value="<?= HtmlEncode($Grid->ukuran_lain->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_ukuran_lain" class="form-group">
<input type="<?= $Grid->ukuran_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_lain" name="x<?= $Grid->RowIndex ?>_ukuran_lain" id="x<?= $Grid->RowIndex ?>_ukuran_lain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran_lain->getPlaceHolder()) ?>" value="<?= $Grid->ukuran_lain->EditValue ?>"<?= $Grid->ukuran_lain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran_lain->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_ukuran_lain">
<span<?= $Grid->ukuran_lain->viewAttributes() ?>>
<?= $Grid->ukuran_lain->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_lain" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_ukuran_lain" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_ukuran_lain" value="<?= HtmlEncode($Grid->ukuran_lain->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_lain" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_ukuran_lain" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_ukuran_lain" value="<?= HtmlEncode($Grid->ukuran_lain->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <td data-name="lain_harga_isi" <?= $Grid->lain_harga_isi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_isi" class="form-group">
<input type="<?= $Grid->lain_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi" name="x<?= $Grid->RowIndex ?>_lain_harga_isi" id="x<?= $Grid->RowIndex ?>_lain_harga_isi" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_isi->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_isi->EditValue ?>"<?= $Grid->lain_harga_isi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_isi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_isi" id="o<?= $Grid->RowIndex ?>_lain_harga_isi" value="<?= HtmlEncode($Grid->lain_harga_isi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_isi" class="form-group">
<input type="<?= $Grid->lain_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi" name="x<?= $Grid->RowIndex ?>_lain_harga_isi" id="x<?= $Grid->RowIndex ?>_lain_harga_isi" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_isi->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_isi->EditValue ?>"<?= $Grid->lain_harga_isi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_isi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_isi">
<span<?= $Grid->lain_harga_isi->viewAttributes() ?>>
<?= $Grid->lain_harga_isi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_isi" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_isi" value="<?= HtmlEncode($Grid->lain_harga_isi->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_isi" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_isi" value="<?= HtmlEncode($Grid->lain_harga_isi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <td data-name="lain_harga_isi_order" <?= $Grid->lain_harga_isi_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_isi_order" class="form-group">
<input type="<?= $Grid->lain_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi_order" name="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_isi_order->EditValue ?>"<?= $Grid->lain_harga_isi_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_isi_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="o<?= $Grid->RowIndex ?>_lain_harga_isi_order" value="<?= HtmlEncode($Grid->lain_harga_isi_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_isi_order" class="form-group">
<input type="<?= $Grid->lain_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi_order" name="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_isi_order->EditValue ?>"<?= $Grid->lain_harga_isi_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_isi_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_isi_order">
<span<?= $Grid->lain_harga_isi_order->viewAttributes() ?>>
<?= $Grid->lain_harga_isi_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_isi_order" value="<?= HtmlEncode($Grid->lain_harga_isi_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_isi_order" value="<?= HtmlEncode($Grid->lain_harga_isi_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <td data-name="lain_harga_primer" <?= $Grid->lain_harga_primer->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_primer" class="form-group">
<input type="<?= $Grid->lain_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer" name="x<?= $Grid->RowIndex ?>_lain_harga_primer" id="x<?= $Grid->RowIndex ?>_lain_harga_primer" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_primer->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_primer->EditValue ?>"<?= $Grid->lain_harga_primer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_primer->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_primer" id="o<?= $Grid->RowIndex ?>_lain_harga_primer" value="<?= HtmlEncode($Grid->lain_harga_primer->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_primer" class="form-group">
<input type="<?= $Grid->lain_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer" name="x<?= $Grid->RowIndex ?>_lain_harga_primer" id="x<?= $Grid->RowIndex ?>_lain_harga_primer" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_primer->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_primer->EditValue ?>"<?= $Grid->lain_harga_primer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_primer->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_primer">
<span<?= $Grid->lain_harga_primer->viewAttributes() ?>>
<?= $Grid->lain_harga_primer->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_primer" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_primer" value="<?= HtmlEncode($Grid->lain_harga_primer->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_primer" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_primer" value="<?= HtmlEncode($Grid->lain_harga_primer->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <td data-name="lain_harga_primer_order" <?= $Grid->lain_harga_primer_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_primer_order" class="form-group">
<input type="<?= $Grid->lain_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer_order" name="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_primer_order->EditValue ?>"<?= $Grid->lain_harga_primer_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_primer_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="o<?= $Grid->RowIndex ?>_lain_harga_primer_order" value="<?= HtmlEncode($Grid->lain_harga_primer_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_primer_order" class="form-group">
<input type="<?= $Grid->lain_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer_order" name="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_primer_order->EditValue ?>"<?= $Grid->lain_harga_primer_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_primer_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_primer_order">
<span<?= $Grid->lain_harga_primer_order->viewAttributes() ?>>
<?= $Grid->lain_harga_primer_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_primer_order" value="<?= HtmlEncode($Grid->lain_harga_primer_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_primer_order" value="<?= HtmlEncode($Grid->lain_harga_primer_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <td data-name="lain_harga_sekunder" <?= $Grid->lain_harga_sekunder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_sekunder" class="form-group">
<input type="<?= $Grid->lain_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_sekunder->EditValue ?>"<?= $Grid->lain_harga_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_sekunder->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="o<?= $Grid->RowIndex ?>_lain_harga_sekunder" value="<?= HtmlEncode($Grid->lain_harga_sekunder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_sekunder" class="form-group">
<input type="<?= $Grid->lain_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_sekunder->EditValue ?>"<?= $Grid->lain_harga_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_sekunder->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_sekunder">
<span<?= $Grid->lain_harga_sekunder->viewAttributes() ?>>
<?= $Grid->lain_harga_sekunder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_sekunder" value="<?= HtmlEncode($Grid->lain_harga_sekunder->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_sekunder" value="<?= HtmlEncode($Grid->lain_harga_sekunder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <td data-name="lain_harga_sekunder_order" <?= $Grid->lain_harga_sekunder_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_sekunder_order" class="form-group">
<input type="<?= $Grid->lain_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_sekunder_order->EditValue ?>"<?= $Grid->lain_harga_sekunder_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_sekunder_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="o<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" value="<?= HtmlEncode($Grid->lain_harga_sekunder_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_sekunder_order" class="form-group">
<input type="<?= $Grid->lain_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_sekunder_order->EditValue ?>"<?= $Grid->lain_harga_sekunder_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_sekunder_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_sekunder_order">
<span<?= $Grid->lain_harga_sekunder_order->viewAttributes() ?>>
<?= $Grid->lain_harga_sekunder_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" value="<?= HtmlEncode($Grid->lain_harga_sekunder_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" value="<?= HtmlEncode($Grid->lain_harga_sekunder_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_label->Visible) { // lain_harga_label ?>
        <td data-name="lain_harga_label" <?= $Grid->lain_harga_label->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_label" class="form-group">
<input type="<?= $Grid->lain_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label" name="x<?= $Grid->RowIndex ?>_lain_harga_label" id="x<?= $Grid->RowIndex ?>_lain_harga_label" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_label->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_label->EditValue ?>"<?= $Grid->lain_harga_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_label->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_label" id="o<?= $Grid->RowIndex ?>_lain_harga_label" value="<?= HtmlEncode($Grid->lain_harga_label->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_label" class="form-group">
<input type="<?= $Grid->lain_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label" name="x<?= $Grid->RowIndex ?>_lain_harga_label" id="x<?= $Grid->RowIndex ?>_lain_harga_label" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_label->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_label->EditValue ?>"<?= $Grid->lain_harga_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_label->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_label">
<span<?= $Grid->lain_harga_label->viewAttributes() ?>>
<?= $Grid->lain_harga_label->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_label" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_label" value="<?= HtmlEncode($Grid->lain_harga_label->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_label" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_label" value="<?= HtmlEncode($Grid->lain_harga_label->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <td data-name="lain_harga_label_order" <?= $Grid->lain_harga_label_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_label_order" class="form-group">
<input type="<?= $Grid->lain_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label_order" name="x<?= $Grid->RowIndex ?>_lain_harga_label_order" id="x<?= $Grid->RowIndex ?>_lain_harga_label_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_label_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_label_order->EditValue ?>"<?= $Grid->lain_harga_label_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_label_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_label_order" id="o<?= $Grid->RowIndex ?>_lain_harga_label_order" value="<?= HtmlEncode($Grid->lain_harga_label_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_label_order" class="form-group">
<input type="<?= $Grid->lain_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label_order" name="x<?= $Grid->RowIndex ?>_lain_harga_label_order" id="x<?= $Grid->RowIndex ?>_lain_harga_label_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_label_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_label_order->EditValue ?>"<?= $Grid->lain_harga_label_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_label_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_label_order">
<span<?= $Grid->lain_harga_label_order->viewAttributes() ?>>
<?= $Grid->lain_harga_label_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_label_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_label_order" value="<?= HtmlEncode($Grid->lain_harga_label_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_label_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_label_order" value="<?= HtmlEncode($Grid->lain_harga_label_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_total->Visible) { // lain_harga_total ?>
        <td data-name="lain_harga_total" <?= $Grid->lain_harga_total->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_total" class="form-group">
<input type="<?= $Grid->lain_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total" name="x<?= $Grid->RowIndex ?>_lain_harga_total" id="x<?= $Grid->RowIndex ?>_lain_harga_total" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_total->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_total->EditValue ?>"<?= $Grid->lain_harga_total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_total" id="o<?= $Grid->RowIndex ?>_lain_harga_total" value="<?= HtmlEncode($Grid->lain_harga_total->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_total" class="form-group">
<input type="<?= $Grid->lain_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total" name="x<?= $Grid->RowIndex ?>_lain_harga_total" id="x<?= $Grid->RowIndex ?>_lain_harga_total" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_total->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_total->EditValue ?>"<?= $Grid->lain_harga_total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_total->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_total">
<span<?= $Grid->lain_harga_total->viewAttributes() ?>>
<?= $Grid->lain_harga_total->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_total" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_total" value="<?= HtmlEncode($Grid->lain_harga_total->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_total" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_total" value="<?= HtmlEncode($Grid->lain_harga_total->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <td data-name="lain_harga_total_order" <?= $Grid->lain_harga_total_order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_total_order" class="form-group">
<input type="<?= $Grid->lain_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total_order" name="x<?= $Grid->RowIndex ?>_lain_harga_total_order" id="x<?= $Grid->RowIndex ?>_lain_harga_total_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_total_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_total_order->EditValue ?>"<?= $Grid->lain_harga_total_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_total_order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_total_order" id="o<?= $Grid->RowIndex ?>_lain_harga_total_order" value="<?= HtmlEncode($Grid->lain_harga_total_order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_total_order" class="form-group">
<input type="<?= $Grid->lain_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total_order" name="x<?= $Grid->RowIndex ?>_lain_harga_total_order" id="x<?= $Grid->RowIndex ?>_lain_harga_total_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_total_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_total_order->EditValue ?>"<?= $Grid->lain_harga_total_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_total_order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_lain_harga_total_order">
<span<?= $Grid->lain_harga_total_order->viewAttributes() ?>>
<?= $Grid->lain_harga_total_order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total_order" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_total_order" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_lain_harga_total_order" value="<?= HtmlEncode($Grid->lain_harga_total_order->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total_order" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_total_order" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_lain_harga_total_order" value="<?= HtmlEncode($Grid->lain_harga_total_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <td data-name="isi_bahan_aktif" <?= $Grid->isi_bahan_aktif->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_bahan_aktif" class="form-group">
<input type="<?= $Grid->isi_bahan_aktif->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_aktif" name="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_bahan_aktif->getPlaceHolder()) ?>" value="<?= $Grid->isi_bahan_aktif->EditValue ?>"<?= $Grid->isi_bahan_aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_bahan_aktif->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_aktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="o<?= $Grid->RowIndex ?>_isi_bahan_aktif" value="<?= HtmlEncode($Grid->isi_bahan_aktif->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_bahan_aktif" class="form-group">
<input type="<?= $Grid->isi_bahan_aktif->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_aktif" name="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_bahan_aktif->getPlaceHolder()) ?>" value="<?= $Grid->isi_bahan_aktif->EditValue ?>"<?= $Grid->isi_bahan_aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_bahan_aktif->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_bahan_aktif">
<span<?= $Grid->isi_bahan_aktif->viewAttributes() ?>>
<?= $Grid->isi_bahan_aktif->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_aktif" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_bahan_aktif" value="<?= HtmlEncode($Grid->isi_bahan_aktif->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_aktif" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_bahan_aktif" value="<?= HtmlEncode($Grid->isi_bahan_aktif->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <td data-name="isi_bahan_lain" <?= $Grid->isi_bahan_lain->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_bahan_lain" class="form-group">
<input type="<?= $Grid->isi_bahan_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_lain" name="x<?= $Grid->RowIndex ?>_isi_bahan_lain" id="x<?= $Grid->RowIndex ?>_isi_bahan_lain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_bahan_lain->getPlaceHolder()) ?>" value="<?= $Grid->isi_bahan_lain->EditValue ?>"<?= $Grid->isi_bahan_lain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_bahan_lain->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_lain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_bahan_lain" id="o<?= $Grid->RowIndex ?>_isi_bahan_lain" value="<?= HtmlEncode($Grid->isi_bahan_lain->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_bahan_lain" class="form-group">
<input type="<?= $Grid->isi_bahan_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_lain" name="x<?= $Grid->RowIndex ?>_isi_bahan_lain" id="x<?= $Grid->RowIndex ?>_isi_bahan_lain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_bahan_lain->getPlaceHolder()) ?>" value="<?= $Grid->isi_bahan_lain->EditValue ?>"<?= $Grid->isi_bahan_lain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_bahan_lain->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_bahan_lain">
<span<?= $Grid->isi_bahan_lain->viewAttributes() ?>>
<?= $Grid->isi_bahan_lain->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_lain" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_bahan_lain" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_bahan_lain" value="<?= HtmlEncode($Grid->isi_bahan_lain->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_lain" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_bahan_lain" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_bahan_lain" value="<?= HtmlEncode($Grid->isi_bahan_lain->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isi_parfum->Visible) { // isi_parfum ?>
        <td data-name="isi_parfum" <?= $Grid->isi_parfum->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_parfum" class="form-group">
<input type="<?= $Grid->isi_parfum->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_parfum" name="x<?= $Grid->RowIndex ?>_isi_parfum" id="x<?= $Grid->RowIndex ?>_isi_parfum" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_parfum->getPlaceHolder()) ?>" value="<?= $Grid->isi_parfum->EditValue ?>"<?= $Grid->isi_parfum->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_parfum->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_parfum" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_parfum" id="o<?= $Grid->RowIndex ?>_isi_parfum" value="<?= HtmlEncode($Grid->isi_parfum->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_parfum" class="form-group">
<input type="<?= $Grid->isi_parfum->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_parfum" name="x<?= $Grid->RowIndex ?>_isi_parfum" id="x<?= $Grid->RowIndex ?>_isi_parfum" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_parfum->getPlaceHolder()) ?>" value="<?= $Grid->isi_parfum->EditValue ?>"<?= $Grid->isi_parfum->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_parfum->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_parfum">
<span<?= $Grid->isi_parfum->viewAttributes() ?>>
<?= $Grid->isi_parfum->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_parfum" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_parfum" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_parfum" value="<?= HtmlEncode($Grid->isi_parfum->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_isi_parfum" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_parfum" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_parfum" value="<?= HtmlEncode($Grid->isi_parfum->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isi_estetika->Visible) { // isi_estetika ?>
        <td data-name="isi_estetika" <?= $Grid->isi_estetika->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_estetika" class="form-group">
<input type="<?= $Grid->isi_estetika->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_estetika" name="x<?= $Grid->RowIndex ?>_isi_estetika" id="x<?= $Grid->RowIndex ?>_isi_estetika" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_estetika->getPlaceHolder()) ?>" value="<?= $Grid->isi_estetika->EditValue ?>"<?= $Grid->isi_estetika->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_estetika->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_estetika" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_estetika" id="o<?= $Grid->RowIndex ?>_isi_estetika" value="<?= HtmlEncode($Grid->isi_estetika->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_estetika" class="form-group">
<input type="<?= $Grid->isi_estetika->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_estetika" name="x<?= $Grid->RowIndex ?>_isi_estetika" id="x<?= $Grid->RowIndex ?>_isi_estetika" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_estetika->getPlaceHolder()) ?>" value="<?= $Grid->isi_estetika->EditValue ?>"<?= $Grid->isi_estetika->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_estetika->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_isi_estetika">
<span<?= $Grid->isi_estetika->viewAttributes() ?>>
<?= $Grid->isi_estetika->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_estetika" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_estetika" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_isi_estetika" value="<?= HtmlEncode($Grid->isi_estetika->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_isi_estetika" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_estetika" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_isi_estetika" value="<?= HtmlEncode($Grid->isi_estetika->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <td data-name="kemasan_wadah" <?= $Grid->kemasan_wadah->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_wadah" class="form-group">
<input type="<?= $Grid->kemasan_wadah->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_wadah" name="x<?= $Grid->RowIndex ?>_kemasan_wadah" id="x<?= $Grid->RowIndex ?>_kemasan_wadah" size="30" placeholder="<?= HtmlEncode($Grid->kemasan_wadah->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_wadah->EditValue ?>"<?= $Grid->kemasan_wadah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_wadah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_wadah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasan_wadah" id="o<?= $Grid->RowIndex ?>_kemasan_wadah" value="<?= HtmlEncode($Grid->kemasan_wadah->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_wadah" class="form-group">
<input type="<?= $Grid->kemasan_wadah->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_wadah" name="x<?= $Grid->RowIndex ?>_kemasan_wadah" id="x<?= $Grid->RowIndex ?>_kemasan_wadah" size="30" placeholder="<?= HtmlEncode($Grid->kemasan_wadah->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_wadah->EditValue ?>"<?= $Grid->kemasan_wadah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_wadah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_wadah">
<span<?= $Grid->kemasan_wadah->viewAttributes() ?>>
<?= $Grid->kemasan_wadah->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_wadah" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_kemasan_wadah" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_kemasan_wadah" value="<?= HtmlEncode($Grid->kemasan_wadah->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_wadah" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_kemasan_wadah" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_kemasan_wadah" value="<?= HtmlEncode($Grid->kemasan_wadah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <td data-name="kemasan_tutup" <?= $Grid->kemasan_tutup->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_tutup" class="form-group">
<input type="<?= $Grid->kemasan_tutup->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_tutup" name="x<?= $Grid->RowIndex ?>_kemasan_tutup" id="x<?= $Grid->RowIndex ?>_kemasan_tutup" size="30" placeholder="<?= HtmlEncode($Grid->kemasan_tutup->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_tutup->EditValue ?>"<?= $Grid->kemasan_tutup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_tutup->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_tutup" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasan_tutup" id="o<?= $Grid->RowIndex ?>_kemasan_tutup" value="<?= HtmlEncode($Grid->kemasan_tutup->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_tutup" class="form-group">
<input type="<?= $Grid->kemasan_tutup->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_tutup" name="x<?= $Grid->RowIndex ?>_kemasan_tutup" id="x<?= $Grid->RowIndex ?>_kemasan_tutup" size="30" placeholder="<?= HtmlEncode($Grid->kemasan_tutup->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_tutup->EditValue ?>"<?= $Grid->kemasan_tutup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_tutup->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_tutup">
<span<?= $Grid->kemasan_tutup->viewAttributes() ?>>
<?= $Grid->kemasan_tutup->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_tutup" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_kemasan_tutup" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_kemasan_tutup" value="<?= HtmlEncode($Grid->kemasan_tutup->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_tutup" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_kemasan_tutup" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_kemasan_tutup" value="<?= HtmlEncode($Grid->kemasan_tutup->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <td data-name="kemasan_sekunder" <?= $Grid->kemasan_sekunder->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_sekunder" class="form-group">
<input type="<?= $Grid->kemasan_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_sekunder" name="x<?= $Grid->RowIndex ?>_kemasan_sekunder" id="x<?= $Grid->RowIndex ?>_kemasan_sekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kemasan_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_sekunder->EditValue ?>"<?= $Grid->kemasan_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_sekunder->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_sekunder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasan_sekunder" id="o<?= $Grid->RowIndex ?>_kemasan_sekunder" value="<?= HtmlEncode($Grid->kemasan_sekunder->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_sekunder" class="form-group">
<input type="<?= $Grid->kemasan_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_sekunder" name="x<?= $Grid->RowIndex ?>_kemasan_sekunder" id="x<?= $Grid->RowIndex ?>_kemasan_sekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kemasan_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_sekunder->EditValue ?>"<?= $Grid->kemasan_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_sekunder->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_kemasan_sekunder">
<span<?= $Grid->kemasan_sekunder->viewAttributes() ?>>
<?= $Grid->kemasan_sekunder->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_sekunder" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_kemasan_sekunder" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_kemasan_sekunder" value="<?= HtmlEncode($Grid->kemasan_sekunder->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_sekunder" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_kemasan_sekunder" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_kemasan_sekunder" value="<?= HtmlEncode($Grid->kemasan_sekunder->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->label_desain->Visible) { // label_desain ?>
        <td data-name="label_desain" <?= $Grid->label_desain->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_desain" class="form-group">
<input type="<?= $Grid->label_desain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_desain" name="x<?= $Grid->RowIndex ?>_label_desain" id="x<?= $Grid->RowIndex ?>_label_desain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_desain->getPlaceHolder()) ?>" value="<?= $Grid->label_desain->EditValue ?>"<?= $Grid->label_desain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_desain->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_label_desain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_label_desain" id="o<?= $Grid->RowIndex ?>_label_desain" value="<?= HtmlEncode($Grid->label_desain->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_desain" class="form-group">
<input type="<?= $Grid->label_desain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_desain" name="x<?= $Grid->RowIndex ?>_label_desain" id="x<?= $Grid->RowIndex ?>_label_desain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_desain->getPlaceHolder()) ?>" value="<?= $Grid->label_desain->EditValue ?>"<?= $Grid->label_desain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_desain->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_desain">
<span<?= $Grid->label_desain->viewAttributes() ?>>
<?= $Grid->label_desain->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_label_desain" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_label_desain" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_label_desain" value="<?= HtmlEncode($Grid->label_desain->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_label_desain" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_label_desain" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_label_desain" value="<?= HtmlEncode($Grid->label_desain->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->label_cetak->Visible) { // label_cetak ?>
        <td data-name="label_cetak" <?= $Grid->label_cetak->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_cetak" class="form-group">
<input type="<?= $Grid->label_cetak->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_cetak" name="x<?= $Grid->RowIndex ?>_label_cetak" id="x<?= $Grid->RowIndex ?>_label_cetak" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_cetak->getPlaceHolder()) ?>" value="<?= $Grid->label_cetak->EditValue ?>"<?= $Grid->label_cetak->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_cetak->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_label_cetak" data-hidden="1" name="o<?= $Grid->RowIndex ?>_label_cetak" id="o<?= $Grid->RowIndex ?>_label_cetak" value="<?= HtmlEncode($Grid->label_cetak->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_cetak" class="form-group">
<input type="<?= $Grid->label_cetak->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_cetak" name="x<?= $Grid->RowIndex ?>_label_cetak" id="x<?= $Grid->RowIndex ?>_label_cetak" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_cetak->getPlaceHolder()) ?>" value="<?= $Grid->label_cetak->EditValue ?>"<?= $Grid->label_cetak->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_cetak->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_cetak">
<span<?= $Grid->label_cetak->viewAttributes() ?>>
<?= $Grid->label_cetak->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_label_cetak" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_label_cetak" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_label_cetak" value="<?= HtmlEncode($Grid->label_cetak->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_label_cetak" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_label_cetak" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_label_cetak" value="<?= HtmlEncode($Grid->label_cetak->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->label_lainlain->Visible) { // label_lainlain ?>
        <td data-name="label_lainlain" <?= $Grid->label_lainlain->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_lainlain" class="form-group">
<input type="<?= $Grid->label_lainlain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_lainlain" name="x<?= $Grid->RowIndex ?>_label_lainlain" id="x<?= $Grid->RowIndex ?>_label_lainlain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_lainlain->getPlaceHolder()) ?>" value="<?= $Grid->label_lainlain->EditValue ?>"<?= $Grid->label_lainlain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_lainlain->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_label_lainlain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_label_lainlain" id="o<?= $Grid->RowIndex ?>_label_lainlain" value="<?= HtmlEncode($Grid->label_lainlain->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_lainlain" class="form-group">
<input type="<?= $Grid->label_lainlain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_lainlain" name="x<?= $Grid->RowIndex ?>_label_lainlain" id="x<?= $Grid->RowIndex ?>_label_lainlain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_lainlain->getPlaceHolder()) ?>" value="<?= $Grid->label_lainlain->EditValue ?>"<?= $Grid->label_lainlain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_lainlain->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_label_lainlain">
<span<?= $Grid->label_lainlain->viewAttributes() ?>>
<?= $Grid->label_lainlain->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_label_lainlain" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_label_lainlain" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_label_lainlain" value="<?= HtmlEncode($Grid->label_lainlain->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_label_lainlain" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_label_lainlain" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_label_lainlain" value="<?= HtmlEncode($Grid->label_lainlain->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->delivery_pickup->Visible) { // delivery_pickup ?>
        <td data-name="delivery_pickup" <?= $Grid->delivery_pickup->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_pickup" class="form-group">
<input type="<?= $Grid->delivery_pickup->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_pickup" name="x<?= $Grid->RowIndex ?>_delivery_pickup" id="x<?= $Grid->RowIndex ?>_delivery_pickup" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_pickup->getPlaceHolder()) ?>" value="<?= $Grid->delivery_pickup->EditValue ?>"<?= $Grid->delivery_pickup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_pickup->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_pickup" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_pickup" id="o<?= $Grid->RowIndex ?>_delivery_pickup" value="<?= HtmlEncode($Grid->delivery_pickup->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_pickup" class="form-group">
<input type="<?= $Grid->delivery_pickup->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_pickup" name="x<?= $Grid->RowIndex ?>_delivery_pickup" id="x<?= $Grid->RowIndex ?>_delivery_pickup" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_pickup->getPlaceHolder()) ?>" value="<?= $Grid->delivery_pickup->EditValue ?>"<?= $Grid->delivery_pickup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_pickup->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_pickup">
<span<?= $Grid->delivery_pickup->viewAttributes() ?>>
<?= $Grid->delivery_pickup->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_pickup" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_pickup" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_pickup" value="<?= HtmlEncode($Grid->delivery_pickup->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_delivery_pickup" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_pickup" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_pickup" value="<?= HtmlEncode($Grid->delivery_pickup->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <td data-name="delivery_singlepoint" <?= $Grid->delivery_singlepoint->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_singlepoint" class="form-group">
<input type="<?= $Grid->delivery_singlepoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_singlepoint" name="x<?= $Grid->RowIndex ?>_delivery_singlepoint" id="x<?= $Grid->RowIndex ?>_delivery_singlepoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_singlepoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_singlepoint->EditValue ?>"<?= $Grid->delivery_singlepoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_singlepoint->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_singlepoint" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_singlepoint" id="o<?= $Grid->RowIndex ?>_delivery_singlepoint" value="<?= HtmlEncode($Grid->delivery_singlepoint->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_singlepoint" class="form-group">
<input type="<?= $Grid->delivery_singlepoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_singlepoint" name="x<?= $Grid->RowIndex ?>_delivery_singlepoint" id="x<?= $Grid->RowIndex ?>_delivery_singlepoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_singlepoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_singlepoint->EditValue ?>"<?= $Grid->delivery_singlepoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_singlepoint->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_singlepoint">
<span<?= $Grid->delivery_singlepoint->viewAttributes() ?>>
<?= $Grid->delivery_singlepoint->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_singlepoint" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_singlepoint" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_singlepoint" value="<?= HtmlEncode($Grid->delivery_singlepoint->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_delivery_singlepoint" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_singlepoint" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_singlepoint" value="<?= HtmlEncode($Grid->delivery_singlepoint->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <td data-name="delivery_multipoint" <?= $Grid->delivery_multipoint->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_multipoint" class="form-group">
<input type="<?= $Grid->delivery_multipoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_multipoint" name="x<?= $Grid->RowIndex ?>_delivery_multipoint" id="x<?= $Grid->RowIndex ?>_delivery_multipoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_multipoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_multipoint->EditValue ?>"<?= $Grid->delivery_multipoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_multipoint->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_multipoint" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_multipoint" id="o<?= $Grid->RowIndex ?>_delivery_multipoint" value="<?= HtmlEncode($Grid->delivery_multipoint->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_multipoint" class="form-group">
<input type="<?= $Grid->delivery_multipoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_multipoint" name="x<?= $Grid->RowIndex ?>_delivery_multipoint" id="x<?= $Grid->RowIndex ?>_delivery_multipoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_multipoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_multipoint->EditValue ?>"<?= $Grid->delivery_multipoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_multipoint->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_multipoint">
<span<?= $Grid->delivery_multipoint->viewAttributes() ?>>
<?= $Grid->delivery_multipoint->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_multipoint" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_multipoint" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_multipoint" value="<?= HtmlEncode($Grid->delivery_multipoint->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_delivery_multipoint" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_multipoint" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_multipoint" value="<?= HtmlEncode($Grid->delivery_multipoint->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <td data-name="delivery_jumlahpoint" <?= $Grid->delivery_jumlahpoint->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_jumlahpoint" class="form-group">
<input type="<?= $Grid->delivery_jumlahpoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_jumlahpoint" name="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_jumlahpoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_jumlahpoint->EditValue ?>"<?= $Grid->delivery_jumlahpoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_jumlahpoint->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_jumlahpoint" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="o<?= $Grid->RowIndex ?>_delivery_jumlahpoint" value="<?= HtmlEncode($Grid->delivery_jumlahpoint->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_jumlahpoint" class="form-group">
<input type="<?= $Grid->delivery_jumlahpoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_jumlahpoint" name="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_jumlahpoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_jumlahpoint->EditValue ?>"<?= $Grid->delivery_jumlahpoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_jumlahpoint->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_jumlahpoint">
<span<?= $Grid->delivery_jumlahpoint->viewAttributes() ?>>
<?= $Grid->delivery_jumlahpoint->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_jumlahpoint" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" value="<?= HtmlEncode($Grid->delivery_jumlahpoint->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_delivery_jumlahpoint" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_jumlahpoint" value="<?= HtmlEncode($Grid->delivery_jumlahpoint->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->delivery_termslain->Visible) { // delivery_termslain ?>
        <td data-name="delivery_termslain" <?= $Grid->delivery_termslain->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_termslain" class="form-group">
<input type="<?= $Grid->delivery_termslain->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_termslain" name="x<?= $Grid->RowIndex ?>_delivery_termslain" id="x<?= $Grid->RowIndex ?>_delivery_termslain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_termslain->getPlaceHolder()) ?>" value="<?= $Grid->delivery_termslain->EditValue ?>"<?= $Grid->delivery_termslain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_termslain->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_termslain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_termslain" id="o<?= $Grid->RowIndex ?>_delivery_termslain" value="<?= HtmlEncode($Grid->delivery_termslain->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_termslain" class="form-group">
<input type="<?= $Grid->delivery_termslain->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_termslain" name="x<?= $Grid->RowIndex ?>_delivery_termslain" id="x<?= $Grid->RowIndex ?>_delivery_termslain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_termslain->getPlaceHolder()) ?>" value="<?= $Grid->delivery_termslain->EditValue ?>"<?= $Grid->delivery_termslain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_termslain->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_delivery_termslain">
<span<?= $Grid->delivery_termslain->viewAttributes() ?>>
<?= $Grid->delivery_termslain->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_termslain" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_termslain" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_delivery_termslain" value="<?= HtmlEncode($Grid->delivery_termslain->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_delivery_termslain" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_termslain" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_delivery_termslain" value="<?= HtmlEncode($Grid->delivery_termslain->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dibuatdi->Visible) { // dibuatdi ?>
        <td data-name="dibuatdi" <?= $Grid->dibuatdi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_dibuatdi" class="form-group">
<input type="<?= $Grid->dibuatdi->getInputTextType() ?>" data-table="npd_terms" data-field="x_dibuatdi" name="x<?= $Grid->RowIndex ?>_dibuatdi" id="x<?= $Grid->RowIndex ?>_dibuatdi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->dibuatdi->getPlaceHolder()) ?>" value="<?= $Grid->dibuatdi->EditValue ?>"<?= $Grid->dibuatdi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dibuatdi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_dibuatdi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dibuatdi" id="o<?= $Grid->RowIndex ?>_dibuatdi" value="<?= HtmlEncode($Grid->dibuatdi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_dibuatdi" class="form-group">
<input type="<?= $Grid->dibuatdi->getInputTextType() ?>" data-table="npd_terms" data-field="x_dibuatdi" name="x<?= $Grid->RowIndex ?>_dibuatdi" id="x<?= $Grid->RowIndex ?>_dibuatdi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->dibuatdi->getPlaceHolder()) ?>" value="<?= $Grid->dibuatdi->EditValue ?>"<?= $Grid->dibuatdi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dibuatdi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_dibuatdi">
<span<?= $Grid->dibuatdi->viewAttributes() ?>>
<?= $Grid->dibuatdi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_dibuatdi" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_dibuatdi" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_dibuatdi" value="<?= HtmlEncode($Grid->dibuatdi->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_dibuatdi" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_dibuatdi" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_dibuatdi" value="<?= HtmlEncode($Grid->dibuatdi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at" <?= $Grid->created_at->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="npd_terms" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_created_at" class="form-group">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="npd_terms" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_npd_terms_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<?= $Grid->created_at->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="npd_terms" data-field="x_created_at" data-hidden="1" name="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_created_at" id="fnpd_termsgrid$x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<input type="hidden" data-table="npd_terms" data-field="x_created_at" data-hidden="1" name="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_created_at" id="fnpd_termsgrid$o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fnpd_termsgrid","load"], function () {
    fnpd_termsgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_npd_terms", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->idnpd->Visible) { // idnpd ?>
        <td data-name="idnpd">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idnpd->getSessionValue() != "") { ?>
<span id="el$rowindex$_npd_terms_idnpd" class="form-group npd_terms_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_npd_terms_idnpd" class="form-group npd_terms_idnpd">
<input type="<?= $Grid->idnpd->getInputTextType() ?>" data-table="npd_terms" data-field="x_idnpd" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" size="30" placeholder="<?= HtmlEncode($Grid->idnpd->getPlaceHolder()) ?>" value="<?= $Grid->idnpd->EditValue ?>"<?= $Grid->idnpd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_idnpd" class="form-group npd_terms_idnpd">
<span<?= $Grid->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idnpd->getDisplayValue($Grid->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_idnpd" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idnpd" id="x<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_idnpd" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idnpd" id="o<?= $Grid->RowIndex ?>_idnpd" value="<?= HtmlEncode($Grid->idnpd->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->status->Visible) { // status ?>
        <td data-name="status">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_status" class="form-group npd_terms_status">
<input type="<?= $Grid->status->getInputTextType() ?>" data-table="npd_terms" data-field="x_status" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->status->getPlaceHolder()) ?>" value="<?= $Grid->status->EditValue ?>"<?= $Grid->status->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->status->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_status" class="form-group npd_terms_status">
<span<?= $Grid->status->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->status->getDisplayValue($Grid->status->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_status" data-hidden="1" name="x<?= $Grid->RowIndex ?>_status" id="x<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_status" data-hidden="1" name="o<?= $Grid->RowIndex ?>_status" id="o<?= $Grid->RowIndex ?>_status" value="<?= HtmlEncode($Grid->status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglsubmit->Visible) { // tglsubmit ?>
        <td data-name="tglsubmit">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_tglsubmit" class="form-group npd_terms_tglsubmit">
<input type="<?= $Grid->tglsubmit->getInputTextType() ?>" data-table="npd_terms" data-field="x_tglsubmit" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" placeholder="<?= HtmlEncode($Grid->tglsubmit->getPlaceHolder()) ?>" value="<?= $Grid->tglsubmit->EditValue ?>"<?= $Grid->tglsubmit->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Grid->tglsubmit->ReadOnly && !$Grid->tglsubmit->Disabled && !isset($Grid->tglsubmit->EditAttrs["readonly"]) && !isset($Grid->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsgrid", "x<?= $Grid->RowIndex ?>_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_tglsubmit" class="form-group npd_terms_tglsubmit">
<span<?= $Grid->tglsubmit->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglsubmit->getDisplayValue($Grid->tglsubmit->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_tglsubmit" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglsubmit" id="x<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_tglsubmit" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglsubmit" id="o<?= $Grid->RowIndex ?>_tglsubmit" value="<?= HtmlEncode($Grid->tglsubmit->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sifat_order->Visible) { // sifat_order ?>
        <td data-name="sifat_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_sifat_order" class="form-group npd_terms_sifat_order">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Grid->sifat_order->isInvalidClass() ?>" data-table="npd_terms" data-field="x_sifat_order" name="x<?= $Grid->RowIndex ?>_sifat_order[]" id="x<?= $Grid->RowIndex ?>_sifat_order_681158" value="1"<?= ConvertToBool($Grid->sifat_order->CurrentValue) ? " checked" : "" ?><?= $Grid->sifat_order->editAttributes() ?>>
    <label class="custom-control-label" for="x<?= $Grid->RowIndex ?>_sifat_order_681158"></label>
</div>
<div class="invalid-feedback"><?= $Grid->sifat_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_sifat_order" class="form-group npd_terms_sifat_order">
<span<?= $Grid->sifat_order->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_sifat_order_<?= $Grid->RowCount ?>" class="custom-control-input" value="<?= $Grid->sifat_order->ViewValue ?>" disabled<?php if (ConvertToBool($Grid->sifat_order->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_sifat_order_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_sifat_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_sifat_order" id="x<?= $Grid->RowIndex ?>_sifat_order" value="<?= HtmlEncode($Grid->sifat_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_sifat_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sifat_order[]" id="o<?= $Grid->RowIndex ?>_sifat_order[]" value="<?= HtmlEncode($Grid->sifat_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ukuran_utama->Visible) { // ukuran_utama ?>
        <td data-name="ukuran_utama">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_ukuran_utama" class="form-group npd_terms_ukuran_utama">
<input type="<?= $Grid->ukuran_utama->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_utama" name="x<?= $Grid->RowIndex ?>_ukuran_utama" id="x<?= $Grid->RowIndex ?>_ukuran_utama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran_utama->getPlaceHolder()) ?>" value="<?= $Grid->ukuran_utama->EditValue ?>"<?= $Grid->ukuran_utama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran_utama->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_ukuran_utama" class="form-group npd_terms_ukuran_utama">
<span<?= $Grid->ukuran_utama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ukuran_utama->getDisplayValue($Grid->ukuran_utama->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_utama" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ukuran_utama" id="x<?= $Grid->RowIndex ?>_ukuran_utama" value="<?= HtmlEncode($Grid->ukuran_utama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_utama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran_utama" id="o<?= $Grid->RowIndex ?>_ukuran_utama" value="<?= HtmlEncode($Grid->ukuran_utama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_isi->Visible) { // utama_harga_isi ?>
        <td data-name="utama_harga_isi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_isi" class="form-group npd_terms_utama_harga_isi">
<input type="<?= $Grid->utama_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi" name="x<?= $Grid->RowIndex ?>_utama_harga_isi" id="x<?= $Grid->RowIndex ?>_utama_harga_isi" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_isi->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_isi->EditValue ?>"<?= $Grid->utama_harga_isi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_isi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_isi" class="form-group npd_terms_utama_harga_isi">
<span<?= $Grid->utama_harga_isi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_isi->getDisplayValue($Grid->utama_harga_isi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_isi" id="x<?= $Grid->RowIndex ?>_utama_harga_isi" value="<?= HtmlEncode($Grid->utama_harga_isi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_isi" id="o<?= $Grid->RowIndex ?>_utama_harga_isi" value="<?= HtmlEncode($Grid->utama_harga_isi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
        <td data-name="utama_harga_isi_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_isi_order" class="form-group npd_terms_utama_harga_isi_order">
<input type="<?= $Grid->utama_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi_order" name="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_isi_order->EditValue ?>"<?= $Grid->utama_harga_isi_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_isi_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_isi_order" class="form-group npd_terms_utama_harga_isi_order">
<span<?= $Grid->utama_harga_isi_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_isi_order->getDisplayValue($Grid->utama_harga_isi_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="x<?= $Grid->RowIndex ?>_utama_harga_isi_order" value="<?= HtmlEncode($Grid->utama_harga_isi_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_isi_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_isi_order" id="o<?= $Grid->RowIndex ?>_utama_harga_isi_order" value="<?= HtmlEncode($Grid->utama_harga_isi_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_primer->Visible) { // utama_harga_primer ?>
        <td data-name="utama_harga_primer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_primer" class="form-group npd_terms_utama_harga_primer">
<input type="<?= $Grid->utama_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer" name="x<?= $Grid->RowIndex ?>_utama_harga_primer" id="x<?= $Grid->RowIndex ?>_utama_harga_primer" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_primer->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_primer->EditValue ?>"<?= $Grid->utama_harga_primer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_primer->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_primer" class="form-group npd_terms_utama_harga_primer">
<span<?= $Grid->utama_harga_primer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_primer->getDisplayValue($Grid->utama_harga_primer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_primer" id="x<?= $Grid->RowIndex ?>_utama_harga_primer" value="<?= HtmlEncode($Grid->utama_harga_primer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_primer" id="o<?= $Grid->RowIndex ?>_utama_harga_primer" value="<?= HtmlEncode($Grid->utama_harga_primer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
        <td data-name="utama_harga_primer_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_primer_order" class="form-group npd_terms_utama_harga_primer_order">
<input type="<?= $Grid->utama_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer_order" name="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_primer_order->EditValue ?>"<?= $Grid->utama_harga_primer_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_primer_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_primer_order" class="form-group npd_terms_utama_harga_primer_order">
<span<?= $Grid->utama_harga_primer_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_primer_order->getDisplayValue($Grid->utama_harga_primer_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="x<?= $Grid->RowIndex ?>_utama_harga_primer_order" value="<?= HtmlEncode($Grid->utama_harga_primer_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_primer_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_primer_order" id="o<?= $Grid->RowIndex ?>_utama_harga_primer_order" value="<?= HtmlEncode($Grid->utama_harga_primer_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
        <td data-name="utama_harga_sekunder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_sekunder" class="form-group npd_terms_utama_harga_sekunder">
<input type="<?= $Grid->utama_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_sekunder->EditValue ?>"<?= $Grid->utama_harga_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_sekunder->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_sekunder" class="form-group npd_terms_utama_harga_sekunder">
<span<?= $Grid->utama_harga_sekunder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_sekunder->getDisplayValue($Grid->utama_harga_sekunder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder" value="<?= HtmlEncode($Grid->utama_harga_sekunder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_sekunder" id="o<?= $Grid->RowIndex ?>_utama_harga_sekunder" value="<?= HtmlEncode($Grid->utama_harga_sekunder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
        <td data-name="utama_harga_sekunder_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_sekunder_order" class="form-group npd_terms_utama_harga_sekunder_order">
<input type="<?= $Grid->utama_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_sekunder_order->EditValue ?>"<?= $Grid->utama_harga_sekunder_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_sekunder_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_sekunder_order" class="form-group npd_terms_utama_harga_sekunder_order">
<span<?= $Grid->utama_harga_sekunder_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_sekunder_order->getDisplayValue($Grid->utama_harga_sekunder_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" value="<?= HtmlEncode($Grid->utama_harga_sekunder_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" id="o<?= $Grid->RowIndex ?>_utama_harga_sekunder_order" value="<?= HtmlEncode($Grid->utama_harga_sekunder_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_label->Visible) { // utama_harga_label ?>
        <td data-name="utama_harga_label">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_label" class="form-group npd_terms_utama_harga_label">
<input type="<?= $Grid->utama_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label" name="x<?= $Grid->RowIndex ?>_utama_harga_label" id="x<?= $Grid->RowIndex ?>_utama_harga_label" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_label->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_label->EditValue ?>"<?= $Grid->utama_harga_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_label->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_label" class="form-group npd_terms_utama_harga_label">
<span<?= $Grid->utama_harga_label->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_label->getDisplayValue($Grid->utama_harga_label->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_label" id="x<?= $Grid->RowIndex ?>_utama_harga_label" value="<?= HtmlEncode($Grid->utama_harga_label->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_label" id="o<?= $Grid->RowIndex ?>_utama_harga_label" value="<?= HtmlEncode($Grid->utama_harga_label->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
        <td data-name="utama_harga_label_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_label_order" class="form-group npd_terms_utama_harga_label_order">
<input type="<?= $Grid->utama_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label_order" name="x<?= $Grid->RowIndex ?>_utama_harga_label_order" id="x<?= $Grid->RowIndex ?>_utama_harga_label_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_label_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_label_order->EditValue ?>"<?= $Grid->utama_harga_label_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_label_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_label_order" class="form-group npd_terms_utama_harga_label_order">
<span<?= $Grid->utama_harga_label_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_label_order->getDisplayValue($Grid->utama_harga_label_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_label_order" id="x<?= $Grid->RowIndex ?>_utama_harga_label_order" value="<?= HtmlEncode($Grid->utama_harga_label_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_label_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_label_order" id="o<?= $Grid->RowIndex ?>_utama_harga_label_order" value="<?= HtmlEncode($Grid->utama_harga_label_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_total->Visible) { // utama_harga_total ?>
        <td data-name="utama_harga_total">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_total" class="form-group npd_terms_utama_harga_total">
<input type="<?= $Grid->utama_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total" name="x<?= $Grid->RowIndex ?>_utama_harga_total" id="x<?= $Grid->RowIndex ?>_utama_harga_total" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_total->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_total->EditValue ?>"<?= $Grid->utama_harga_total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_total->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_total" class="form-group npd_terms_utama_harga_total">
<span<?= $Grid->utama_harga_total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_total->getDisplayValue($Grid->utama_harga_total->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_total" id="x<?= $Grid->RowIndex ?>_utama_harga_total" value="<?= HtmlEncode($Grid->utama_harga_total->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_total" id="o<?= $Grid->RowIndex ?>_utama_harga_total" value="<?= HtmlEncode($Grid->utama_harga_total->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
        <td data-name="utama_harga_total_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_utama_harga_total_order" class="form-group npd_terms_utama_harga_total_order">
<input type="<?= $Grid->utama_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total_order" name="x<?= $Grid->RowIndex ?>_utama_harga_total_order" id="x<?= $Grid->RowIndex ?>_utama_harga_total_order" size="30" placeholder="<?= HtmlEncode($Grid->utama_harga_total_order->getPlaceHolder()) ?>" value="<?= $Grid->utama_harga_total_order->EditValue ?>"<?= $Grid->utama_harga_total_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->utama_harga_total_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_utama_harga_total_order" class="form-group npd_terms_utama_harga_total_order">
<span<?= $Grid->utama_harga_total_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->utama_harga_total_order->getDisplayValue($Grid->utama_harga_total_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_utama_harga_total_order" id="x<?= $Grid->RowIndex ?>_utama_harga_total_order" value="<?= HtmlEncode($Grid->utama_harga_total_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_utama_harga_total_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_utama_harga_total_order" id="o<?= $Grid->RowIndex ?>_utama_harga_total_order" value="<?= HtmlEncode($Grid->utama_harga_total_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ukuran_lain->Visible) { // ukuran_lain ?>
        <td data-name="ukuran_lain">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_ukuran_lain" class="form-group npd_terms_ukuran_lain">
<input type="<?= $Grid->ukuran_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_lain" name="x<?= $Grid->RowIndex ?>_ukuran_lain" id="x<?= $Grid->RowIndex ?>_ukuran_lain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->ukuran_lain->getPlaceHolder()) ?>" value="<?= $Grid->ukuran_lain->EditValue ?>"<?= $Grid->ukuran_lain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ukuran_lain->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_ukuran_lain" class="form-group npd_terms_ukuran_lain">
<span<?= $Grid->ukuran_lain->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ukuran_lain->getDisplayValue($Grid->ukuran_lain->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_lain" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ukuran_lain" id="x<?= $Grid->RowIndex ?>_ukuran_lain" value="<?= HtmlEncode($Grid->ukuran_lain->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_ukuran_lain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ukuran_lain" id="o<?= $Grid->RowIndex ?>_ukuran_lain" value="<?= HtmlEncode($Grid->ukuran_lain->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_isi->Visible) { // lain_harga_isi ?>
        <td data-name="lain_harga_isi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_isi" class="form-group npd_terms_lain_harga_isi">
<input type="<?= $Grid->lain_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi" name="x<?= $Grid->RowIndex ?>_lain_harga_isi" id="x<?= $Grid->RowIndex ?>_lain_harga_isi" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_isi->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_isi->EditValue ?>"<?= $Grid->lain_harga_isi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_isi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_isi" class="form-group npd_terms_lain_harga_isi">
<span<?= $Grid->lain_harga_isi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_isi->getDisplayValue($Grid->lain_harga_isi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_isi" id="x<?= $Grid->RowIndex ?>_lain_harga_isi" value="<?= HtmlEncode($Grid->lain_harga_isi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_isi" id="o<?= $Grid->RowIndex ?>_lain_harga_isi" value="<?= HtmlEncode($Grid->lain_harga_isi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
        <td data-name="lain_harga_isi_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_isi_order" class="form-group npd_terms_lain_harga_isi_order">
<input type="<?= $Grid->lain_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi_order" name="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_isi_order->EditValue ?>"<?= $Grid->lain_harga_isi_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_isi_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_isi_order" class="form-group npd_terms_lain_harga_isi_order">
<span<?= $Grid->lain_harga_isi_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_isi_order->getDisplayValue($Grid->lain_harga_isi_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="x<?= $Grid->RowIndex ?>_lain_harga_isi_order" value="<?= HtmlEncode($Grid->lain_harga_isi_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_isi_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_isi_order" id="o<?= $Grid->RowIndex ?>_lain_harga_isi_order" value="<?= HtmlEncode($Grid->lain_harga_isi_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_primer->Visible) { // lain_harga_primer ?>
        <td data-name="lain_harga_primer">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_primer" class="form-group npd_terms_lain_harga_primer">
<input type="<?= $Grid->lain_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer" name="x<?= $Grid->RowIndex ?>_lain_harga_primer" id="x<?= $Grid->RowIndex ?>_lain_harga_primer" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_primer->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_primer->EditValue ?>"<?= $Grid->lain_harga_primer->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_primer->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_primer" class="form-group npd_terms_lain_harga_primer">
<span<?= $Grid->lain_harga_primer->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_primer->getDisplayValue($Grid->lain_harga_primer->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_primer" id="x<?= $Grid->RowIndex ?>_lain_harga_primer" value="<?= HtmlEncode($Grid->lain_harga_primer->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_primer" id="o<?= $Grid->RowIndex ?>_lain_harga_primer" value="<?= HtmlEncode($Grid->lain_harga_primer->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
        <td data-name="lain_harga_primer_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_primer_order" class="form-group npd_terms_lain_harga_primer_order">
<input type="<?= $Grid->lain_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer_order" name="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_primer_order->EditValue ?>"<?= $Grid->lain_harga_primer_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_primer_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_primer_order" class="form-group npd_terms_lain_harga_primer_order">
<span<?= $Grid->lain_harga_primer_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_primer_order->getDisplayValue($Grid->lain_harga_primer_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="x<?= $Grid->RowIndex ?>_lain_harga_primer_order" value="<?= HtmlEncode($Grid->lain_harga_primer_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_primer_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_primer_order" id="o<?= $Grid->RowIndex ?>_lain_harga_primer_order" value="<?= HtmlEncode($Grid->lain_harga_primer_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
        <td data-name="lain_harga_sekunder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_sekunder" class="form-group npd_terms_lain_harga_sekunder">
<input type="<?= $Grid->lain_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_sekunder->EditValue ?>"<?= $Grid->lain_harga_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_sekunder->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_sekunder" class="form-group npd_terms_lain_harga_sekunder">
<span<?= $Grid->lain_harga_sekunder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_sekunder->getDisplayValue($Grid->lain_harga_sekunder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder" value="<?= HtmlEncode($Grid->lain_harga_sekunder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_sekunder" id="o<?= $Grid->RowIndex ?>_lain_harga_sekunder" value="<?= HtmlEncode($Grid->lain_harga_sekunder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
        <td data-name="lain_harga_sekunder_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_sekunder_order" class="form-group npd_terms_lain_harga_sekunder_order">
<input type="<?= $Grid->lain_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_sekunder_order->EditValue ?>"<?= $Grid->lain_harga_sekunder_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_sekunder_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_sekunder_order" class="form-group npd_terms_lain_harga_sekunder_order">
<span<?= $Grid->lain_harga_sekunder_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_sekunder_order->getDisplayValue($Grid->lain_harga_sekunder_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="x<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" value="<?= HtmlEncode($Grid->lain_harga_sekunder_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" id="o<?= $Grid->RowIndex ?>_lain_harga_sekunder_order" value="<?= HtmlEncode($Grid->lain_harga_sekunder_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_label->Visible) { // lain_harga_label ?>
        <td data-name="lain_harga_label">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_label" class="form-group npd_terms_lain_harga_label">
<input type="<?= $Grid->lain_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label" name="x<?= $Grid->RowIndex ?>_lain_harga_label" id="x<?= $Grid->RowIndex ?>_lain_harga_label" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_label->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_label->EditValue ?>"<?= $Grid->lain_harga_label->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_label->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_label" class="form-group npd_terms_lain_harga_label">
<span<?= $Grid->lain_harga_label->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_label->getDisplayValue($Grid->lain_harga_label->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_label" id="x<?= $Grid->RowIndex ?>_lain_harga_label" value="<?= HtmlEncode($Grid->lain_harga_label->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_label" id="o<?= $Grid->RowIndex ?>_lain_harga_label" value="<?= HtmlEncode($Grid->lain_harga_label->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
        <td data-name="lain_harga_label_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_label_order" class="form-group npd_terms_lain_harga_label_order">
<input type="<?= $Grid->lain_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label_order" name="x<?= $Grid->RowIndex ?>_lain_harga_label_order" id="x<?= $Grid->RowIndex ?>_lain_harga_label_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_label_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_label_order->EditValue ?>"<?= $Grid->lain_harga_label_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_label_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_label_order" class="form-group npd_terms_lain_harga_label_order">
<span<?= $Grid->lain_harga_label_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_label_order->getDisplayValue($Grid->lain_harga_label_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_label_order" id="x<?= $Grid->RowIndex ?>_lain_harga_label_order" value="<?= HtmlEncode($Grid->lain_harga_label_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_label_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_label_order" id="o<?= $Grid->RowIndex ?>_lain_harga_label_order" value="<?= HtmlEncode($Grid->lain_harga_label_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_total->Visible) { // lain_harga_total ?>
        <td data-name="lain_harga_total">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_total" class="form-group npd_terms_lain_harga_total">
<input type="<?= $Grid->lain_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total" name="x<?= $Grid->RowIndex ?>_lain_harga_total" id="x<?= $Grid->RowIndex ?>_lain_harga_total" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_total->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_total->EditValue ?>"<?= $Grid->lain_harga_total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_total->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_total" class="form-group npd_terms_lain_harga_total">
<span<?= $Grid->lain_harga_total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_total->getDisplayValue($Grid->lain_harga_total->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_total" id="x<?= $Grid->RowIndex ?>_lain_harga_total" value="<?= HtmlEncode($Grid->lain_harga_total->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_total" id="o<?= $Grid->RowIndex ?>_lain_harga_total" value="<?= HtmlEncode($Grid->lain_harga_total->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
        <td data-name="lain_harga_total_order">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_lain_harga_total_order" class="form-group npd_terms_lain_harga_total_order">
<input type="<?= $Grid->lain_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total_order" name="x<?= $Grid->RowIndex ?>_lain_harga_total_order" id="x<?= $Grid->RowIndex ?>_lain_harga_total_order" size="30" placeholder="<?= HtmlEncode($Grid->lain_harga_total_order->getPlaceHolder()) ?>" value="<?= $Grid->lain_harga_total_order->EditValue ?>"<?= $Grid->lain_harga_total_order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lain_harga_total_order->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_lain_harga_total_order" class="form-group npd_terms_lain_harga_total_order">
<span<?= $Grid->lain_harga_total_order->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lain_harga_total_order->getDisplayValue($Grid->lain_harga_total_order->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total_order" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lain_harga_total_order" id="x<?= $Grid->RowIndex ?>_lain_harga_total_order" value="<?= HtmlEncode($Grid->lain_harga_total_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_lain_harga_total_order" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lain_harga_total_order" id="o<?= $Grid->RowIndex ?>_lain_harga_total_order" value="<?= HtmlEncode($Grid->lain_harga_total_order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
        <td data-name="isi_bahan_aktif">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_isi_bahan_aktif" class="form-group npd_terms_isi_bahan_aktif">
<input type="<?= $Grid->isi_bahan_aktif->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_aktif" name="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_bahan_aktif->getPlaceHolder()) ?>" value="<?= $Grid->isi_bahan_aktif->EditValue ?>"<?= $Grid->isi_bahan_aktif->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_bahan_aktif->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_isi_bahan_aktif" class="form-group npd_terms_isi_bahan_aktif">
<span<?= $Grid->isi_bahan_aktif->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isi_bahan_aktif->getDisplayValue($Grid->isi_bahan_aktif->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_aktif" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="x<?= $Grid->RowIndex ?>_isi_bahan_aktif" value="<?= HtmlEncode($Grid->isi_bahan_aktif->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_aktif" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_bahan_aktif" id="o<?= $Grid->RowIndex ?>_isi_bahan_aktif" value="<?= HtmlEncode($Grid->isi_bahan_aktif->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
        <td data-name="isi_bahan_lain">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_isi_bahan_lain" class="form-group npd_terms_isi_bahan_lain">
<input type="<?= $Grid->isi_bahan_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_lain" name="x<?= $Grid->RowIndex ?>_isi_bahan_lain" id="x<?= $Grid->RowIndex ?>_isi_bahan_lain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_bahan_lain->getPlaceHolder()) ?>" value="<?= $Grid->isi_bahan_lain->EditValue ?>"<?= $Grid->isi_bahan_lain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_bahan_lain->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_isi_bahan_lain" class="form-group npd_terms_isi_bahan_lain">
<span<?= $Grid->isi_bahan_lain->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isi_bahan_lain->getDisplayValue($Grid->isi_bahan_lain->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_lain" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isi_bahan_lain" id="x<?= $Grid->RowIndex ?>_isi_bahan_lain" value="<?= HtmlEncode($Grid->isi_bahan_lain->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_bahan_lain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_bahan_lain" id="o<?= $Grid->RowIndex ?>_isi_bahan_lain" value="<?= HtmlEncode($Grid->isi_bahan_lain->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isi_parfum->Visible) { // isi_parfum ?>
        <td data-name="isi_parfum">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_isi_parfum" class="form-group npd_terms_isi_parfum">
<input type="<?= $Grid->isi_parfum->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_parfum" name="x<?= $Grid->RowIndex ?>_isi_parfum" id="x<?= $Grid->RowIndex ?>_isi_parfum" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_parfum->getPlaceHolder()) ?>" value="<?= $Grid->isi_parfum->EditValue ?>"<?= $Grid->isi_parfum->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_parfum->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_isi_parfum" class="form-group npd_terms_isi_parfum">
<span<?= $Grid->isi_parfum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isi_parfum->getDisplayValue($Grid->isi_parfum->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_parfum" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isi_parfum" id="x<?= $Grid->RowIndex ?>_isi_parfum" value="<?= HtmlEncode($Grid->isi_parfum->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_parfum" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_parfum" id="o<?= $Grid->RowIndex ?>_isi_parfum" value="<?= HtmlEncode($Grid->isi_parfum->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isi_estetika->Visible) { // isi_estetika ?>
        <td data-name="isi_estetika">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_isi_estetika" class="form-group npd_terms_isi_estetika">
<input type="<?= $Grid->isi_estetika->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_estetika" name="x<?= $Grid->RowIndex ?>_isi_estetika" id="x<?= $Grid->RowIndex ?>_isi_estetika" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->isi_estetika->getPlaceHolder()) ?>" value="<?= $Grid->isi_estetika->EditValue ?>"<?= $Grid->isi_estetika->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->isi_estetika->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_isi_estetika" class="form-group npd_terms_isi_estetika">
<span<?= $Grid->isi_estetika->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->isi_estetika->getDisplayValue($Grid->isi_estetika->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_isi_estetika" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isi_estetika" id="x<?= $Grid->RowIndex ?>_isi_estetika" value="<?= HtmlEncode($Grid->isi_estetika->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_isi_estetika" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isi_estetika" id="o<?= $Grid->RowIndex ?>_isi_estetika" value="<?= HtmlEncode($Grid->isi_estetika->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kemasan_wadah->Visible) { // kemasan_wadah ?>
        <td data-name="kemasan_wadah">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_kemasan_wadah" class="form-group npd_terms_kemasan_wadah">
<input type="<?= $Grid->kemasan_wadah->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_wadah" name="x<?= $Grid->RowIndex ?>_kemasan_wadah" id="x<?= $Grid->RowIndex ?>_kemasan_wadah" size="30" placeholder="<?= HtmlEncode($Grid->kemasan_wadah->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_wadah->EditValue ?>"<?= $Grid->kemasan_wadah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_wadah->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_kemasan_wadah" class="form-group npd_terms_kemasan_wadah">
<span<?= $Grid->kemasan_wadah->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kemasan_wadah->getDisplayValue($Grid->kemasan_wadah->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_wadah" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kemasan_wadah" id="x<?= $Grid->RowIndex ?>_kemasan_wadah" value="<?= HtmlEncode($Grid->kemasan_wadah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_wadah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasan_wadah" id="o<?= $Grid->RowIndex ?>_kemasan_wadah" value="<?= HtmlEncode($Grid->kemasan_wadah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kemasan_tutup->Visible) { // kemasan_tutup ?>
        <td data-name="kemasan_tutup">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_kemasan_tutup" class="form-group npd_terms_kemasan_tutup">
<input type="<?= $Grid->kemasan_tutup->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_tutup" name="x<?= $Grid->RowIndex ?>_kemasan_tutup" id="x<?= $Grid->RowIndex ?>_kemasan_tutup" size="30" placeholder="<?= HtmlEncode($Grid->kemasan_tutup->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_tutup->EditValue ?>"<?= $Grid->kemasan_tutup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_tutup->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_kemasan_tutup" class="form-group npd_terms_kemasan_tutup">
<span<?= $Grid->kemasan_tutup->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kemasan_tutup->getDisplayValue($Grid->kemasan_tutup->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_tutup" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kemasan_tutup" id="x<?= $Grid->RowIndex ?>_kemasan_tutup" value="<?= HtmlEncode($Grid->kemasan_tutup->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_tutup" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasan_tutup" id="o<?= $Grid->RowIndex ?>_kemasan_tutup" value="<?= HtmlEncode($Grid->kemasan_tutup->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
        <td data-name="kemasan_sekunder">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_kemasan_sekunder" class="form-group npd_terms_kemasan_sekunder">
<input type="<?= $Grid->kemasan_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_sekunder" name="x<?= $Grid->RowIndex ?>_kemasan_sekunder" id="x<?= $Grid->RowIndex ?>_kemasan_sekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->kemasan_sekunder->getPlaceHolder()) ?>" value="<?= $Grid->kemasan_sekunder->EditValue ?>"<?= $Grid->kemasan_sekunder->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kemasan_sekunder->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_kemasan_sekunder" class="form-group npd_terms_kemasan_sekunder">
<span<?= $Grid->kemasan_sekunder->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kemasan_sekunder->getDisplayValue($Grid->kemasan_sekunder->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_sekunder" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kemasan_sekunder" id="x<?= $Grid->RowIndex ?>_kemasan_sekunder" value="<?= HtmlEncode($Grid->kemasan_sekunder->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_kemasan_sekunder" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kemasan_sekunder" id="o<?= $Grid->RowIndex ?>_kemasan_sekunder" value="<?= HtmlEncode($Grid->kemasan_sekunder->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->label_desain->Visible) { // label_desain ?>
        <td data-name="label_desain">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_label_desain" class="form-group npd_terms_label_desain">
<input type="<?= $Grid->label_desain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_desain" name="x<?= $Grid->RowIndex ?>_label_desain" id="x<?= $Grid->RowIndex ?>_label_desain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_desain->getPlaceHolder()) ?>" value="<?= $Grid->label_desain->EditValue ?>"<?= $Grid->label_desain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_desain->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_label_desain" class="form-group npd_terms_label_desain">
<span<?= $Grid->label_desain->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->label_desain->getDisplayValue($Grid->label_desain->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_label_desain" data-hidden="1" name="x<?= $Grid->RowIndex ?>_label_desain" id="x<?= $Grid->RowIndex ?>_label_desain" value="<?= HtmlEncode($Grid->label_desain->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_label_desain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_label_desain" id="o<?= $Grid->RowIndex ?>_label_desain" value="<?= HtmlEncode($Grid->label_desain->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->label_cetak->Visible) { // label_cetak ?>
        <td data-name="label_cetak">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_label_cetak" class="form-group npd_terms_label_cetak">
<input type="<?= $Grid->label_cetak->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_cetak" name="x<?= $Grid->RowIndex ?>_label_cetak" id="x<?= $Grid->RowIndex ?>_label_cetak" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_cetak->getPlaceHolder()) ?>" value="<?= $Grid->label_cetak->EditValue ?>"<?= $Grid->label_cetak->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_cetak->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_label_cetak" class="form-group npd_terms_label_cetak">
<span<?= $Grid->label_cetak->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->label_cetak->getDisplayValue($Grid->label_cetak->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_label_cetak" data-hidden="1" name="x<?= $Grid->RowIndex ?>_label_cetak" id="x<?= $Grid->RowIndex ?>_label_cetak" value="<?= HtmlEncode($Grid->label_cetak->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_label_cetak" data-hidden="1" name="o<?= $Grid->RowIndex ?>_label_cetak" id="o<?= $Grid->RowIndex ?>_label_cetak" value="<?= HtmlEncode($Grid->label_cetak->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->label_lainlain->Visible) { // label_lainlain ?>
        <td data-name="label_lainlain">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_label_lainlain" class="form-group npd_terms_label_lainlain">
<input type="<?= $Grid->label_lainlain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_lainlain" name="x<?= $Grid->RowIndex ?>_label_lainlain" id="x<?= $Grid->RowIndex ?>_label_lainlain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->label_lainlain->getPlaceHolder()) ?>" value="<?= $Grid->label_lainlain->EditValue ?>"<?= $Grid->label_lainlain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->label_lainlain->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_label_lainlain" class="form-group npd_terms_label_lainlain">
<span<?= $Grid->label_lainlain->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->label_lainlain->getDisplayValue($Grid->label_lainlain->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_label_lainlain" data-hidden="1" name="x<?= $Grid->RowIndex ?>_label_lainlain" id="x<?= $Grid->RowIndex ?>_label_lainlain" value="<?= HtmlEncode($Grid->label_lainlain->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_label_lainlain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_label_lainlain" id="o<?= $Grid->RowIndex ?>_label_lainlain" value="<?= HtmlEncode($Grid->label_lainlain->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->delivery_pickup->Visible) { // delivery_pickup ?>
        <td data-name="delivery_pickup">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_delivery_pickup" class="form-group npd_terms_delivery_pickup">
<input type="<?= $Grid->delivery_pickup->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_pickup" name="x<?= $Grid->RowIndex ?>_delivery_pickup" id="x<?= $Grid->RowIndex ?>_delivery_pickup" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_pickup->getPlaceHolder()) ?>" value="<?= $Grid->delivery_pickup->EditValue ?>"<?= $Grid->delivery_pickup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_pickup->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_delivery_pickup" class="form-group npd_terms_delivery_pickup">
<span<?= $Grid->delivery_pickup->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->delivery_pickup->getDisplayValue($Grid->delivery_pickup->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_pickup" data-hidden="1" name="x<?= $Grid->RowIndex ?>_delivery_pickup" id="x<?= $Grid->RowIndex ?>_delivery_pickup" value="<?= HtmlEncode($Grid->delivery_pickup->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_pickup" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_pickup" id="o<?= $Grid->RowIndex ?>_delivery_pickup" value="<?= HtmlEncode($Grid->delivery_pickup->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
        <td data-name="delivery_singlepoint">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_delivery_singlepoint" class="form-group npd_terms_delivery_singlepoint">
<input type="<?= $Grid->delivery_singlepoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_singlepoint" name="x<?= $Grid->RowIndex ?>_delivery_singlepoint" id="x<?= $Grid->RowIndex ?>_delivery_singlepoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_singlepoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_singlepoint->EditValue ?>"<?= $Grid->delivery_singlepoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_singlepoint->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_delivery_singlepoint" class="form-group npd_terms_delivery_singlepoint">
<span<?= $Grid->delivery_singlepoint->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->delivery_singlepoint->getDisplayValue($Grid->delivery_singlepoint->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_singlepoint" data-hidden="1" name="x<?= $Grid->RowIndex ?>_delivery_singlepoint" id="x<?= $Grid->RowIndex ?>_delivery_singlepoint" value="<?= HtmlEncode($Grid->delivery_singlepoint->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_singlepoint" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_singlepoint" id="o<?= $Grid->RowIndex ?>_delivery_singlepoint" value="<?= HtmlEncode($Grid->delivery_singlepoint->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->delivery_multipoint->Visible) { // delivery_multipoint ?>
        <td data-name="delivery_multipoint">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_delivery_multipoint" class="form-group npd_terms_delivery_multipoint">
<input type="<?= $Grid->delivery_multipoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_multipoint" name="x<?= $Grid->RowIndex ?>_delivery_multipoint" id="x<?= $Grid->RowIndex ?>_delivery_multipoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_multipoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_multipoint->EditValue ?>"<?= $Grid->delivery_multipoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_multipoint->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_delivery_multipoint" class="form-group npd_terms_delivery_multipoint">
<span<?= $Grid->delivery_multipoint->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->delivery_multipoint->getDisplayValue($Grid->delivery_multipoint->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_multipoint" data-hidden="1" name="x<?= $Grid->RowIndex ?>_delivery_multipoint" id="x<?= $Grid->RowIndex ?>_delivery_multipoint" value="<?= HtmlEncode($Grid->delivery_multipoint->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_multipoint" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_multipoint" id="o<?= $Grid->RowIndex ?>_delivery_multipoint" value="<?= HtmlEncode($Grid->delivery_multipoint->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
        <td data-name="delivery_jumlahpoint">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_delivery_jumlahpoint" class="form-group npd_terms_delivery_jumlahpoint">
<input type="<?= $Grid->delivery_jumlahpoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_jumlahpoint" name="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_jumlahpoint->getPlaceHolder()) ?>" value="<?= $Grid->delivery_jumlahpoint->EditValue ?>"<?= $Grid->delivery_jumlahpoint->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_jumlahpoint->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_delivery_jumlahpoint" class="form-group npd_terms_delivery_jumlahpoint">
<span<?= $Grid->delivery_jumlahpoint->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->delivery_jumlahpoint->getDisplayValue($Grid->delivery_jumlahpoint->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_jumlahpoint" data-hidden="1" name="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="x<?= $Grid->RowIndex ?>_delivery_jumlahpoint" value="<?= HtmlEncode($Grid->delivery_jumlahpoint->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_jumlahpoint" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_jumlahpoint" id="o<?= $Grid->RowIndex ?>_delivery_jumlahpoint" value="<?= HtmlEncode($Grid->delivery_jumlahpoint->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->delivery_termslain->Visible) { // delivery_termslain ?>
        <td data-name="delivery_termslain">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_delivery_termslain" class="form-group npd_terms_delivery_termslain">
<input type="<?= $Grid->delivery_termslain->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_termslain" name="x<?= $Grid->RowIndex ?>_delivery_termslain" id="x<?= $Grid->RowIndex ?>_delivery_termslain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->delivery_termslain->getPlaceHolder()) ?>" value="<?= $Grid->delivery_termslain->EditValue ?>"<?= $Grid->delivery_termslain->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->delivery_termslain->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_delivery_termslain" class="form-group npd_terms_delivery_termslain">
<span<?= $Grid->delivery_termslain->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->delivery_termslain->getDisplayValue($Grid->delivery_termslain->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_termslain" data-hidden="1" name="x<?= $Grid->RowIndex ?>_delivery_termslain" id="x<?= $Grid->RowIndex ?>_delivery_termslain" value="<?= HtmlEncode($Grid->delivery_termslain->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_delivery_termslain" data-hidden="1" name="o<?= $Grid->RowIndex ?>_delivery_termslain" id="o<?= $Grid->RowIndex ?>_delivery_termslain" value="<?= HtmlEncode($Grid->delivery_termslain->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dibuatdi->Visible) { // dibuatdi ?>
        <td data-name="dibuatdi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_dibuatdi" class="form-group npd_terms_dibuatdi">
<input type="<?= $Grid->dibuatdi->getInputTextType() ?>" data-table="npd_terms" data-field="x_dibuatdi" name="x<?= $Grid->RowIndex ?>_dibuatdi" id="x<?= $Grid->RowIndex ?>_dibuatdi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->dibuatdi->getPlaceHolder()) ?>" value="<?= $Grid->dibuatdi->EditValue ?>"<?= $Grid->dibuatdi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dibuatdi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_dibuatdi" class="form-group npd_terms_dibuatdi">
<span<?= $Grid->dibuatdi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dibuatdi->getDisplayValue($Grid->dibuatdi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_dibuatdi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dibuatdi" id="x<?= $Grid->RowIndex ?>_dibuatdi" value="<?= HtmlEncode($Grid->dibuatdi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_dibuatdi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dibuatdi" id="o<?= $Grid->RowIndex ?>_dibuatdi" value="<?= HtmlEncode($Grid->dibuatdi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->created_at->Visible) { // created_at ?>
        <td data-name="created_at">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_npd_terms_created_at" class="form-group npd_terms_created_at">
<input type="<?= $Grid->created_at->getInputTextType() ?>" data-table="npd_terms" data-field="x_created_at" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" placeholder="<?= HtmlEncode($Grid->created_at->getPlaceHolder()) ?>" value="<?= $Grid->created_at->EditValue ?>"<?= $Grid->created_at->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->created_at->getErrorMessage() ?></div>
<?php if (!$Grid->created_at->ReadOnly && !$Grid->created_at->Disabled && !isset($Grid->created_at->EditAttrs["readonly"]) && !isset($Grid->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsgrid", "x<?= $Grid->RowIndex ?>_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_npd_terms_created_at" class="form-group npd_terms_created_at">
<span<?= $Grid->created_at->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->created_at->getDisplayValue($Grid->created_at->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="npd_terms" data-field="x_created_at" data-hidden="1" name="x<?= $Grid->RowIndex ?>_created_at" id="x<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="npd_terms" data-field="x_created_at" data-hidden="1" name="o<?= $Grid->RowIndex ?>_created_at" id="o<?= $Grid->RowIndex ?>_created_at" value="<?= HtmlEncode($Grid->created_at->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fnpd_termsgrid","load"], function() {
    fnpd_termsgrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fnpd_termsgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("npd_terms");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
