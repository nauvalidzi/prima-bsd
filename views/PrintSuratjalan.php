<?php

namespace PHPMaker2021\production2;

// Page object
$PrintSuratjalan = &$Page;
?>
<?php
	$idSj = $_GET['id'] ? $_GET['id'] : die;

	$sj= ExecuteRow("SELECT sj.kode, sj.tglsurat,
                        c.nama as namacustomer, 
                        ac.penerima,
                        ac.telepon,
                        ac.alamat,
                        kel.nama AS kel, 
                        kec.nama AS kec, 
                        kab.nama AS kab, 
                        prov.`name` AS prov
                    FROM suratjalan sj
                    JOIN customer c ON sj.idcustomer=c.id 
                    LEFT JOIN alamat_customer ac ON ac.idcustomer = c.id
                    LEFT JOIN kelurahan kel ON ac.idkelurahan = kel.id
                    LEFT JOIN kecamatan kec ON ac.idkecamatan = kec.id
                    LEFT JOIN kabupaten kab ON ac.idkabupaten = kab.id
                    LEFT JOIN provinsi prov ON ac.idprovinsi = prov.id
                    WHERE sj.id = {$idSj}");

	$query = ExecuteQuery("SELECT sjd.idinvoice, i.kode FROM suratjalan_detail sjd, invoice i WHERE sjd.idinvoice = i.id and idsuratjalan=".$idSj);
    $details = $query->fetchAll();

    $invoices = [];
    foreach ($details as $detail) {
        $query = ExecuteQuery("SELECT p.nama, id.jumlahkirim, id.jumlahbonus, p.satuan FROM product p, order_detail od, invoice_detail id WHERE p.id = od.idproduct AND od.id = id.idorder_detail AND id.idinvoice = ".$detail['idinvoice']);
        $invoices[$detail['kode']] = $query->fetchAll();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <head>
        <title>SURAT JALAN</title>
        <style>
            * {
				font-family: 'Arial';
				font-size: 11pt;
				line-height: 1.05em;
            }
            h1 {
                font-size: 16pt;
                line-height: 1pt;
            }
            h2 {
                font-size: 14pt;
                line-height: 14pt;
            }
            table {
				text-align: center;
				vertical-align: middle;
                width: 100%;
				border-collapse: collapse;
				border-color: #000000;
            }
            thead {
                display: table-header-group
            }
            tr {
                page-break-inside: avoid
            }
            sup {
                font-size: 8pt;
            }
            table.bordered th, table.bordered td {
                border: 2px solid;
                border-collapse: collapse;
            }

            .main-header, .main-sidebar, .content-header, .main-footer {
            	display: none;
            }

            .red {
                color: red;
            }
            .section {
                page-break-after: always;
                page-break-inside: avoid;
            }
            .bordered {
                border: 1px solid #000000 !important;
                border-collapse: collapse;
            }
            .no-border {
                border: none;
            }
            .no-break {
                page-break-inside: avoid;
            }
            .text-center {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
            .text-top, .text-top td {
                vertical-align: top;
            }
            td.fit-content {
                width: 1%;
                white-space: nowrap;
            }
            .padding-side {
                padding: 0 0.5em;
            }
            .padding-right {
                padding-right: 1em;
            }
            .tanda-tangan {
                padding: 0 2em;
            }
			.blank-row
			{
				height: 10px !important; /* overwrites any other rules */
				background-color: #FFFFFF;
			}
			tr.noBorder td {
				border: 0px !important;
			}
			
			.no-border-top {
				border-top: 0px !important;
			}
			
			.no-border-bottom {
				border-bottom: 0px !important;
			}
			
			.border-right {
				border-right: 1px solid #000000 !important;
			}
			.border-left {
				border-left: 1px solid #000000 !important;
			}
			.border-side {
				border-left: 1px solid #000000 !important;
				border-right: 1px solid #000000 !important;
			}
			.border-top {
				border-top: 1px solid #000000 !important;
			}
			.border-bottom {
				border-bottom: 1px solid #000000 !important;
			}
			.tab{
				padding-left: 50px;
			}
			
			body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .main-footer, body:not(.sidebar-mini-md) .main-header {
				margin-left: 0;
			}

        </style>
		<style type="text/css" media="print">
		@media print { 
			@page { 
				size: auto;   /* auto is the initial value */
				margin: 0; 
			} 
			body { 
				padding-top: 72px; 
				padding-bottom: 72px ; 
			} 
		} 
		</style>
    </head>
    <body>
        
        <br>
		
		<table class="text-center">
            <tr>
                <td colspan="3">
                    <b>
                    SURAT JALAN<br><br>
                    </b>
                </td>
            </tr>
            <tr class="text-left">
                <td width="30%" class="bordered">
                    Tanggal: <?= date('d/m/Y', strtotime($sj['tglsurat'])) ?><br>
                    No. SJ: <b><?= $sj['kode'] ?></b></td>
                <td></td>
                <td width="30%" class="bordered">
                    Kepada Yth. <?= $sj['namacustomer'] ?> (<?= $sj['penerima'] ?>)<br>
                    <?= $sj['telepon']  ?><br>
                    <?php
                        if (!empty($sj['alamat'])) {
                            echo "{$sj['alamat']}<br>";
                        }
                        if (!empty($sj['kec'])) {
                            echo ucwords(strtolower($sj['kec'])) . ", ";
                        }
                        if (!empty($sj['kab'])) {
                            echo ucwords(strtolower($sj['kab'])) . ", ";
                        }
                        if (!empty($sj['prov'])) {
                            echo "<br>".ucwords(strtolower($sj['prov']));
                        }
                    ?>
                </td>
            </tr>
		</table>
		<br>

        <table>
            <tr>
                <th class="bordered">No.</th>
                <th class="bordered">Nama Barang</th>
                <th class="bordered">Unit</th>
            </tr>

            <?php
            $i = 1;
            foreach ($invoices as $key => $invoice) {
            ?>
            <tr>
                <td colspan="4" class="text-left bordered padding-side">
                    <b><?= $key ?></b>
                </td>
            </tr>
            <?php
                foreach ($invoice as $item) {
            ?>
            <tr>
                <td class="bordered"><?= $i++ ?></td>
                <td class="text-left bordered padding-side"><?= $item['nama'] ?></td>
                <td class="bordered"><?= ($item['jumlahkirim']+$item['jumlahbonus']) ?></td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
			
		<br>
		<br>
		<br>
        
		<table class="text-center text-top">
			<tr>
                <td width="30%">
					Pengirim
					<br><br><br><br>
				</td>
				<td></td>
				<td width="30%">
					Penerima
					<br><br><br><br>
				</td>
			</tr>
			<tr>
                <td>_______________________</td>
				<td></td>
				<td>_______________________</td>
			</tr>
		</table>
        <hr style="border-bottom: 2px dashed; margin: 2em 0 1em">
        <div style="border: 1px solid; padding: 1em;">
            <p><?= $sj['namacustomer'] ?> (<?= $sj['penerima'] ?>)<br><?= $sj['telepon'] ?></p>
            <p><?php
                if (!empty($sj['alamat'])) {
                    echo "{$sj['alamat']}<br>";
                }
                if (!empty($sj['kec'])) {
                    echo ucwords(strtolower($sj['kec'])) . ", ";
                }
                if (!empty($sj['kab'])) {
                    echo ucwords(strtolower($sj['kab'])) . ", ";
                }
                if (!empty($sj['prov'])) {
                    echo "<br>".ucwords(strtolower($sj['prov']));
                }
            ?></p>
        </div>
    </body>
</html>

<?= GetDebugMessage() ?>
