<?php

namespace PHPMaker2021\distributor;

// Page object
$Laporansales = &$Page;
?>
<?php
    $dateFrom = date('Y-m-01');
    $dateTo = date('Y-m-t');
    $listmarketing = ExecuteQuery("SELECT id, kode, nama FROM pegawai ORDER BY id ASC")->fetchAll();

    if(isset($_POST['srhDate'])){
        $dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
        $dateTo = date('Y-m-d', strtotime($_POST['dateTo']));

        if ($_POST['marketing'] == "all") {
            $query = "SELECT p.id, p.nama AS namapegawai, IFNULL(vlo.totalcustomer,0) AS totalcustomer, IFNULL(vlo.totalorder,0) AS totalorder, 
                            IFNULL(vlo.totalproduct,0) AS totalproduct,  IFNULL(vlo.totalbarang,0) AS totalbarang, IFNULL(vlo.totaltagihan,0) AS totaltagihan 
                        FROM pegawai p 
                        LEFT JOIN (
                            SELECT o.idpegawai, COUNT(o.idcustomer) AS totalcustomer, COUNT(o.id) AS totalorder, SUM(od.totalpod) AS totalproduct, 
                                SUM(od.totalbarang) AS totalbarang, SUM(od.totaltagihan) AS totaltagihan
                            FROM `order` o
                            JOIN (
                                SELECT o.id, COUNT(od.id) AS totalpod, SUM(od.jumlah) AS totalbarang, SUM(od.total) AS totaltagihan, o.tanggal
                                FROM order_detail od, `order` o
                                WHERE od.idorder = o.id  AND o.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}'
                                GROUP BY o.id
                            ) od ON od.id = o.id
                            GROUP BY o.idpegawai
                        ) vlo ON p.id = vlo.idpegawai";
        } else {
            $query = "SELECT o.tanggal, o.kode as kodeorder, c.nama as nama_customer, SUM(od.total) as total_order, 
                            p.nama as pegawai, COUNT(od.idproduct) AS jumlah_barang, SUM(od.jumlah) + SUM(od.bonus) AS jumlah_order
                        FROM `order` o
                        JOIN order_detail od ON o.id = od.idorder 
                        JOIN customer c ON c.id = o.idcustomer
                        JOIN pegawai p ON p.id = c.idpegawai
                        WHERE o.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}' AND p.id = {$_POST['marketing']}
                        GROUP BY od.idorder";
            //$mr_selected = ExecuteRows("SELECT nama FROM pegawai WHERE id = $_POST['marketing']");
            $marketing = ExecuteRow("SELECT kode, nama FROM pegawai WHERE id = {$_POST['marketing']}");
        }

        $result = ExecuteQuery($query)->fetchAll();
    }
 ?>
<style>
.text-justify{
    text-align: justify;
    text-justify: inter-word;
}
</style>
<div class="container">
    <div class="row">
        <form action="<?php echo CurrentPage()->PageObjName ?>" method="post">
            <?php if (Config("CHECK_TOKEN")) : ?>
                <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
                <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
            <?php endif; ?>

            <div class="col-md-12">
                <ul class="list-unstyled">
                    <li class="d-inline-block">
                        <label class="d-block">M.R.:</label>
                        <select name="marketing" class="form-control">
                            <option selected value="all">-- All --</option>
                            <?php foreach ($listmarketing as $mr) {
                                $selected = ($_POST['marketing'] != "all") ? ($_POST['marketing'] == $mr['id']) ? "selected" : "" : "";
                                echo "<option value=".$mr['id']." {$selected}>".$mr['kode'] . " - " . $mr['nama']."</option>";
                            }?>
                        </select>
                    </li>
                    <li class="d-inline-block">
                        <label class="d-block">Date Range</label>
                        <input type="date" class="form-control input-md" name="dateFrom" value="<?php echo $dateFrom ?>">
                    </li>
                    to
                    <li class="d-inline-block">
                        <input type="date" class="form-control input-md" name="dateTo" value="<?php echo $dateTo ?>">
                    </li>
                    <li class="d-inline-block">
                        <button class="btn btn-primary btn-md p-2" type="submit" name="srhDate">Search <i class="fa fa-search h-3"></i></button>
                    </li>
                    <?php if(isset($_POST['srhDate'])) : ?>
                    <li class="d-inline-block">
                        <button type="button" class="btn btn-info btn-md p-2" onclick="exportTableToExcel('printTable')"><i class="mr-2 far fa-file-excel"></i>Export to Excel</button>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </form>
    </div>
    <div class="row">
        <?php if(isset($_POST['srhDate'])) : ?>
        <table class="table ew-table table-bordered" id="printTable">
        <?php if ($_POST['marketing'] == "all"): ?>
            <thead>
                <tr>
                    <th colspan="6" class="text-center">
                        <h4 class="my-2">Laporan Sales</h4>
                        <p class="mt-3">Marketing: All<br />Periode: <?php echo tgl_indo($dateFrom) . ' - '. tgl_indo($dateTo) ?></p>
                    </th>
                </tr>
                <tr class="ew-table-header">
                    <th class="text-center">Marketing</th>
                    <th class="text-center">Total Pelanggan</th>
                    <th class="text-center">Jumlah Order</th>
                    <th class="text-center">Jenis S.K.U</th>
                    <th class="text-center" colspan="2">Total Order</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($result)): ?>
                    <?php $total = ['order' => 0, 'barang' => 0, 'jumlah' => 0, 'customer' => 0]; ?>
                    <?php foreach ($result as $data): ?>
                    <tr>
                        <td class="text-center"><?= $data['namapegawai'] ?></td>
                        <td class="text-center"><?= rupiah($data['totalcustomer'], 'without-decimal') ?></td>
                        <td class="text-center"><?= rupiah($data['totalorder'], 'without-decimal') ?></td>
                        <td class="text-center"><?= rupiah($data['totalbarang'], 'without-decimal') ?></td>
                        <td>Rp. <span class="float-right"><?php echo rupiah($data['totaltagihan']) ?></span></td>
                    </tr>
                    <?php
                        $total['customer'] += $data['totalcustomer'];
                        $total['order'] += $data['totalorder'];
                        $total['barang'] += $data['totalbarang'];
                        $total['jumlah'] += $data['totaltagihan'];
                    ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" align="center">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <?php if (!empty($result)):  ?>
            <tfoot>
                <tr class="ew-table-footer">
                    <td class="text-right"><b>Grand Total :</b></td>
                    <td class="text-center"><b><?= rupiah($total['customer'], 'without-decimal') ?></b></td>
                    <td class="text-center"><b><?= rupiah($total['order'], 'without-decimal') ?></b></td>
                    <td class="text-center"><b><?= rupiah($total['barang'], 'without-decimal') ?></b></td>
                    <td><strong>Rp. <span class="float-right"><?php echo rupiah($total['jumlah']) ?></strong></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        <?php else: ?>
            <thead>
                <tr>
                    <th colspan="7" class="text-center">
                        <h4 class="my-2">Laporan Sales</h4>
                        <p class="mt-3">Marketing: <?php echo $marketing['kode'] . ' - ' .$marketing['nama'] ?><br />Periode: <?php echo tgl_indo($dateFrom) . ' - '. tgl_indo($dateTo) ?></p>
                    </th>
                </tr>
                <tr class="ew-table-header">
                    <th class="text-center">No.</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Kode Order</th>
                    <th class="text-center">Pelanggan</th>
                    <th class="text-center">Jumlah Order</th>
                    <th class="text-center">Jumlah S.K.U</th>
                    <th class="text-center">Total Order</th>
                </tr>
            </thead>
            <tbody>
                <?php $ext = ['jumlah_order' => 0, 'jumlah_barang' => 0, 'total_order' => 0]; ?>
                <?php if (!empty($result)): ?>
                    <?php $i = 0; ?>
                    <?php foreach ($result as $row): ?>
                    <tr>
                        <td class="text-center"><?= ++$i ?></td>
                        <td class="text-center"><?= tgl_indo($row['tanggal']) ?></td>
                        <td class="text-center"><?= $row['kodeorder'] ?></td>
                        <td><?= $row['nama_customer'] ?></td>
                        <td class="text-center"><?php echo rupiah($row['jumlah_order'], 'without-decimal') ?></td>
                        <td class="text-center"><?php echo rupiah($row['jumlah_barang'], 'without-decimal') ?></td>
                        <td>Rp <span class="float-right"><?php echo rupiah($row['total_order']) ?></span></td>
                    </tr>
                    <?php 
                        $ext['jumlah_order'] += $row['jumlah_order']; 
                        $ext['jumlah_barang'] += $row['jumlah_barang']; 
                        $ext['total_order'] += $row['total_order']; 
                    ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" align="center">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <?php if (!empty($result)):  ?>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Grand Total :</th>
                    <th class="text-center"><?php echo rupiah($ext['jumlah_order'], 'without-decimal') ?></th>
                    <th class="text-center"><?php echo rupiah($ext['jumlah_barang'], 'without-decimal') ?></th>
                    <th>Rp. <span class="float-right"><?php echo rupiah($ext['total_order']) ?></span></th>
                </tr>
            </tfoot>
            <?php endif; ?>
        <?php endif; ?>
        </table>
        <script>
            function exportTableToExcel(tableID, filename = '') {
                var downloadLink;
                var dataType = 'data:application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = encodeURIComponent(tableSelect.outerHTML);
                var d = new Date();

                // Specify file name
                filename = filename ? filename + '.xls' : 'Laporan Sales '+ d.toDateString() +'.xls';

                // Create download link element
                downloadLink = document.createElement("a");

                document.body.appendChild(downloadLink);

                if (navigator.msSaveOrOpenBlob) {
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob(blob, filename);
                } else {
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                    // Setting the file name
                    downloadLink.download = filename;

                    //triggering the function
                    downloadLink.click();
                }
            }
        </script>
        <?php endif; ?>
    </div>
</div>
<?= GetDebugMessage() ?>
