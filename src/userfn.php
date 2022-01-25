<?php

namespace PHPMaker2021\distributor;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    $app->get('/getMax/{table}/{column}', function ($request, $response, $args) {
      	$column = $args['column'] ?? null;
      	$table = $args['table'] ?? null;
      	if ($column !== null && $table !== null) {
           	return $response->withJson(ExecuteRow("SELECT MAX(".$column.") FROM `".$table."`"));
      	} else {
      		return;
      	}
    });
    $app->get('/nextKodeNpd/{idCustomer}', function ($request, $response, $args) {
    	$idCustomer = $args['idCustomer'];
    	if ($idCustomer == null) {
    		return;
    	}
    	return $response->withJson(getNextKodeNpd($idCustomer));;
    });

//    $app->get('/jumlahKirimInvoice/{idOrderDetail}', function ($request, $response, $args) {
//    	$idOrderDetail = $args['idOrderDetail'];
//    	if ($idOrderDetail == null) { return; }
//    	$total = ExecuteRow("SELECT s.idorder_detail, s.jumlah jumlahkirim, p.harga, (s.jumlah*p.harga) total FROM stock s, product p WHERE s.idproduct = p.id AND s.idorder_detail=".$idOrderDetail);
//    	return $response->withJson($total);
//    });
	$app->get('/nextKodeOrder/{titipmerk}', function ($request, $response, $args) {
        $kode = getNextKodeOrder($args['titipmerk']);
        return $response->withJson($kode);
    });
    $app->get('/nextKodeInvoice/{idorder}', function ($request, $response, $args) {
        $kode = getNextKodeInvoice($args['idorder']);
        return $response->withJson($kode);
    });
    $app->get('/nextKode/{tipe}/{id}', function ($request, $response, $args) {
    	$tipe = $args['tipe'];
    	$id = $args['id'];
    	$kode = getNextKode($tipe, $id);
        return $response->withJson($kode);
    });
    $app->get('/get/brandData/{idBrand}', function($request, $response, $args) {
    	$idBrand = $args['idBrand'];
    	$datas = ExecuteRow("SELECT b.logo, c.ktp, c.npwp, b.aktaperusahaan FROM customer c, brand b WHERE b.idcustomer = c.id AND b.id = ".$idBrand);
    	return $response->withJson($datas);
    });

    // dipanggil di npd_confirm
    $app->get('/get/dataReview/{idreview}', function($request, $response, $args) {
    	$idreview = $args['idreview'];
    	$datas = ExecuteRow("SELECT nama, ukuran from npd_review where id = ".$idreview);
    	return $response->withJson($datas);
    });

    // dipanggil di ijinbpom_detail
    $app->get('/get/finalKodeSample/{idnpd}', function($request, $response, $args) {
    	$idnpd = $args['idnpd'];
    	$kode = ExecuteRow("SELECT kode FROM npd_sample WHERE idnpd=".$idnpd." AND id IN (SELECT idnpd_sample FROM npd_harga WHERE idnpd=".$idnpd.")");
    	return $response->withJson($kode);
    });

    // dipanggil di ijinbpom
    $app->get('/ijinbpom/selesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$children = ExecuteQuery("select * from ijinbpom_detail where idijinbpom=".$id);
    	foreach ($children as $child) {
    		addNpdToProduct($child['idnpd']);
    	}
    	$update = ExecuteUpdate("UPDATE ijinbpom SET selesai=1, readonly=1, `status`='Selesai' WHERE id=".$id);
    	return $response->withJson(1);
    });
    $app->get('/ijinbpom/belumselesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$children = ExecuteQuery("select * from ijinbpom_detail where idijinbpom=".$id);
    	foreach ($children as $child) {
    		removeNpdFromProduct($child['idnpd']);
    	}
    	$update = ExecuteUpdate("UPDATE ijinbpom SET selesai=0 WHERE id=".$id);
    	updateStatus("ijinbpom", $id);
    	return $response->withJson(1);
    });

    // dipanggil di ijinbpom_detail
    $app->get('/ijinbpom_detail/selesai/{id}/{nama}', function($request, $response, $args) {
    	$id = $args['id'];
    	$nama = $args['nama'];
    	$idnpd = ExecuteScalar("SELECT idnpd FROM ijinbpom_detail WHERE id = ".$id);
    	addNpdToProduct2($idnpd, $nama);
    	$updatedetail = ExecuteUpdate("UPDATE ijinbpom_detail SET selesai = 1, namaalt = '".addslashes($nama)."' WHERE id = ".$id);
    	return $response->withJson(1);
    });
    $app->get('/ijinbpom_detail/belumselesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$idnpd = ExecuteScalar("SELECT idnpd FROM ijinbpom_detail WHERE id = ".$id);
    	removeNpdFromProduct($idnpd);
    	$updatedetail = ExecuteUpdate("UPDATE ijinbpom_detail SET selesai = 0 WHERE id = ".$id);
    	return $response->withJson(1);
    });

    // dipanggil di npd
    $app->get('/npd/selesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$npdharga = ExecuteScalar("SELECT COUNT(*) FROM npd_harga WHERE disetujui=1 AND idnpd=".$id);
    	if ($npdharga) {
    		$update = ExecuteUpdate("UPDATE npd SET selesai=1, `status`='Selesai' WHERE id=".$id);
    		return $response->withJson(1);
    	} else {
    		return $response->withJson("Belum ada permintaan harga yang disetujui.");
    	}
    });
    $app->get('/npd/belumselesai/{id}', function($request, $response, $args) {
    	$id = $args['id'];
    	$update = ExecuteUpdate("UPDATE npd SET selesai=0 WHERE id=".$id);
    	updateStatus("npd", $id);
    	return $response->withJson(1);
    });
    $app->get('/dashboard-order', function ($request, $response, $args) {
        $query = "SELECT o.kode AS kode_order, 
                        DATE_FORMAT(o.tanggal, '%d-%m-%Y') AS tgl_order, 
                        p.kode AS kode_marketing, 
                        p.nama AS nama_marketing, 
                        c.kode AS kode_customer, 
                        c.nama AS nama_customer,
                        b.title AS brand
                    FROM `order` o  
                    JOIN pegawai p ON p.id = o.idpegawai
                    JOIN customer c ON c.id = o.idcustomer
                    JOIN brand b ON b.id = o.idbrand
                    JOIN order_detail od ON o.id = od.idorder
                    WHERE od.sisa > 0
                    GROUP BY o.id";
        $result = ExecuteQuery($query)->fetchAll();
        $html = "<div class=\"table-responsive\">";
        $html .= "<table class=\"table table-bordered\">";
        $html .= "<tr>
                    <th width=\"5%\">No.</th>
                    <th>Kode Order</th>
                    <th>Tanggal Order</th>
                    <th>Marketing</th>
                    <th>Customer</th>
                    <th>Brand</th>
                </tr>";
        if (count($result) > 0) {
            $no=1;
            foreach ($result as $row) {
                $html .= "<tr>
                        <td>{$no}</td>
                        <td>{$row['kode_order']}</td>
                        <td>{$row['tgl_order']}</td>
                        <td>{$row['kode_marketing']}, {$row['nama_marketing']}</td>
                        <td>{$row['kode_customer']}, {$row['nama_customer']}</td>
                        <td>{$row['brand']}</td>
                    </tr>";
                $no++;
            }
        } else {
            $html .= "<tr><td class=\"text-center\" colspan=\"10\">Tidak ada data.</td></tr>";
        }
        $html .= "</table>";
        $html .= "</div>";
        return $response->withJson($html);
    });
    $app->get('/dashboard-delivery', function ($request, $response, $args) {
        $query = "SELECT d.kode as kode_delivery, 
                        DATE_FORMAT(d.tanggal, '%d-%m-%Y') AS tgl_delivery, 
                        COUNT(dd.idorder) AS jumlah_order
                    FROM deliveryorder d
                    JOIN deliveryorder_detail dd ON dd.iddeliveryorder = d.id
                    JOIN order_detail od ON od.id = dd.idorder_detail
                    WHERE od.sisa > 0
                    GROUP BY d.id";
        $result = ExecuteQuery($query)->fetchAll();
        $html = "<div class=\"table-responsive\">";
        $html .= "<table class=\"table table-bordered\">";
        $html .= "<tr>
                    <th width=\"5%\">No.</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                </tr>";
        if (count($result) > 0) {
            $no=1;
            foreach ($result as $row) {
                $html .= "<tr>
                        <td>{$no}</td>
                        <td>{$row['kode_delivery']}</td>
                        <td>{$row['tgl_delivery']}</td>
                        <td>{$row['jumlah_order']}</td>
                    </tr>";
                $no++;
            }
        } else {
            $html .= "<tr><td class=\"text-center\" colspan=\"10\">Tidak ada data.</td></tr>";
        }
        $html .= "</table>";
        $html .= "</div>";
        return $response->withJson($html);
    });
    $app->get('/dashboard-invoice-unpaid', function ($request, $response, $args) {
        $query = "SELECT i.kode AS kode_invoice,
                    DATE_FORMAT(i.tglinvoice, '%d-%m-%Y') AS tgl_invoice, 
                    o.kode AS kode_order,
                    DATE_FORMAT(o.tanggal, '%d-%m-%Y') AS tgl_order, 
                    c.kode AS kode_customer,
                    c.nama AS nama_customer,
                    i.totaltagihan,
                    i.sisabayar
                FROM invoice i
                JOIN `order` o ON o.id = i.idorder
                JOIN customer c ON c.id = i.idcustomer
                WHERE i.sisabayar > 0";
        $result = ExecuteQuery($query)->fetchAll();
        $html = "<div class=\"table-responsive\">";
        $html .= "<table class=\"table table-bordered\">";
        $html .= "<tr>
                    <th width=\"5%\">No.</th>
                    <th>Kode Invoice</th>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Total Tagihan</th>
                    <th>Sisa Bayar</th>
                </tr>";
        if (count($result) > 0) {
            $no=1;
            foreach ($result as $row) {
                $html .= "<tr>
                        <td>{$no}</td>
                        <td>{$row['kode_invoice']}, {$row['tgl_invoice']}</td>
                        <td>{$row['kode_order']}, {$row['tgl_order']}</td>
                        <td>{$row['kode_customer']}, {$row['nama_customer']}</td>
                        <td>Rp. ".rupiah($row['totaltagihan'])."</td>
                        <td>Rp. ".rupiah($row['sisabayar'])."</td>
                    </tr>";
                $no++;
            }
        } else {
            $html .= "<tr><td class=\"text-center\" colspan=\"10\">Tidak ada data.</td></tr>";
        }
        $html .= "</table>";
        $html .= "</div>";
        return $response->withJson($html);
    });
    $app->get('/dashboard-invoice-unsent', function ($request, $response, $args) {
        $query = "SELECT i.kode AS kode_invoice,
                    DATE_FORMAT(i.tglinvoice, '%d-%m-%Y') AS tgl_invoice, 
                    o.kode AS kode_order,
                    DATE_FORMAT(o.tanggal, '%d-%m-%Y') AS tgl_order, 
                    c.kode AS kode_customer,
                    c.nama AS nama_customer,
                    i.totaltagihan,
                    i.sisabayar
                FROM invoice i
                JOIN `order` o ON o.id = i.idorder
                JOIN customer c ON c.id = i.idcustomer
                WHERE i.sent < 1";
        $result = ExecuteQuery($query)->fetchAll();
        $html = "<div class=\"table-responsive\">";
        $html .= "<table class=\"table table-bordered\">";
        $html .= "<tr>
                    <th width=\"5%\">No.</th>
                    <th>Kode Invoice</th>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Total Tagihan</th>
                    <th>Sisa Bayar</th>
                </tr>";
        if (count($result) > 0) {
            $no=1;
            foreach ($result as $row) {
                $html .= "<tr>
                        <td>{$no}</td>
                        <td>{$row['kode_invoice']}, {$row['tgl_invoice']}</td>
                        <td>{$row['kode_order']}, {$row['tgl_order']}</td>
                        <td>{$row['kode_customer']}, {$row['nama_customer']}</td>
                        <td>Rp. ".rupiah($row['totaltagihan'])."</td>
                        <td>Rp. ".rupiah($row['sisabayar'])."</td>
                    </tr>";
                $no++;
            }
        } else {
            $html .= "<tr><td class=\"text-center\" colspan=\"10\">Tidak ada data.</td></tr>";
        }
        $html .= "</table>";
        $html .= "</div>";
        return $response->withJson($html);
    });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}
$API_ACTIONS["getTagihan"] = function(Request $request, Response &$response) {
	$vars = Param("idcustomer", Route(1));
    if ($vars !== NULL) {
        $idcustomer = AdjustSql($vars);
        $status = true;
        $message = null;
        $limit_kredit = 5000000; // DEFAULT LIMA Juta;
        $limit_poaktif = 3; // DEFAULT PO Aktif MAKSIMAL DUA P.O (Belum DIBAYAR/Belum LUNAS);

        // CEK TOTAL EXISTING TAGIHAN
        // $existing_tagihan = cek_totaltagihan_po_aktif($idcustomer);

        // CEK KREDIT APPROVAL
        $approval = get_approval($idcustomer);
        if ($approval) {
        	// $limit_kredit = $approval['sisalimitkredit'];
        	$limit_poaktif = $approval['limit_po_aktif'];
        }

        // if ($existing_tagihan > $limit_kredit) {
        //     if ($limit_kredit != 5000000) {
        //         $message = "Transaksi melebihi limit kredit dari pengajuan approval.";
        //         $status = false;
        //     }
        //     $message = "Transaksi melebihi limit yang di approve.<br />Silakan mengajukan approval khusus ke atasan.";
        //     $status = false;
        // }

        // CEK TAGIHAN BELUM LUNAS / BELUM BAYAR
        $existing_count_tagihan = cek_po_aktif($idcustomer);
        if ($existing_count_tagihan >= $limit_poaktif) {
            if ($limit_poaktif > 3) {
                $message = "P.O. berikut melebihi P.O. aktif dari pengajuan approval.<br />Limit P.O. Aktif sebanyak {$limit_poaktif}";
                $status = false;
            }
            $message = "P.O. berikut melebihi jumlah P.O. aktif sebelumnya.<br />Silakan mengajukan approval ke atasan untuk proses khusus.<br />Limit P.O. Aktif sebanyak {$limit_poaktif}";
            $status = false;
        }
        WriteJson(compact('status', 'message'));
    }
};

function get_approval($cust_id) {
	return ExecuteRow("SELECT * FROM po_limit_approval WHERE aktif = 1 AND idcustomer = {$cust_id} ORDER BY id DESC");
}

function url_integrasi() {
    return "http://13.213.61.244/sinergi/api/";
}

function status_delivery($iddeliveryorder, $detail = "undetail") {
    $conditions = ($detail != "detail") ? " AND dd.iddeliveryorder = '{$iddeliveryorder}'" : " AND dd.id = '{$iddeliveryorder}'";
    $row = ExecuteRow("SELECT SUM(od.sisa) AS totalsisa FROM deliveryorder_detail dd JOIN order_detail od ON od.id = dd.idorder_detail WHERE 1=1 {$conditions}");
    if ($row['totalsisa'] > 0) {
        return 'Belum Lengkap';
    }
    return 'Lengkap';
}

function status_pembayaran($idinvoice) {
    $row = ExecuteRow("SELECT SUM(sisabayar) AS sisabayar, totaltagihan FROM invoice WHERE id = '{$idinvoice}' GROUP BY id");
    if ($row['sisabayar'] < 1) {
        return 'Lunas';
    }
    if ($row['sisabayar'] == $row['totaltagihan']) {
        return 'Belum Lunas';
    }
    return 'Lunas Sebagian';
}

function get_kodeorder($idorder) {
    return ExecuteRow("SELECT kode FROM `order` WHERE id = '{$idorder}'")['kode'];
}

function getCustomer($id, $table="order") {
    $row = [];
    if ($table == 'order') {
        $row = ExecuteRow("SELECT idcustomer FROM `order` WHERE id = {$id}");
    }
    if ($table == 'invoice') {
        $row = ExecuteRow("SELECT idcustomer FROM `invoice` WHERE id = {$id}");
    }
	return $row['idcustomer'];
}

function update_status_order($idinvoice, $attr="") {
    $idorder = ExecuteRow("SELECT idorder FROM invoice WHERE id = {$idinvoice}")['idorder'];
    if (!empty($attr) && $attr == 'invoice') {
        return ExecuteUpdate("UPDATE `order` SET `status` = 'Proses Invoice' WHERE id = {$idorder}");
    }
    if (!empty($attr) && $attr == 'bayar-sebagian') {
        return ExecuteUpdate("UPDATE `order` SET `status` = 'Bayar Sebagian' WHERE id = {$idorder}");
    }
    if (!empty($attr) && $attr == 'bayar-lunas') {
        return ExecuteUpdate("UPDATE `order` SET `status` = 'Pembayaran Lunas' WHERE id = {$idorder}");
    }
    return true;
}

//-- FUNGSI TERBILANG --//
function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
	}     
	return $temp;
}

function terbilang($nilai) {
	if($nilai<0) {
		$hasil = "minus ". trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil;
}
//!-- FUNGSI TERBILANG --//

// dipanggil di deliveryorder_detail, invoice_detail
function addStock($idorderdetail, $jumlah) {
	$idProduct = ExecuteScalar("SELECT idproduct FROM order_detail WHERE id = ".$idorderdetail);
    $id = ExecuteScalar("SELECT id FROM stock WHERE idorder_detail = ".$idorderdetail);
    if ($id != null) {
    	$myResult = ExecuteUpdate("UPDATE stock SET jumlah = IFNULL(jumlah,0)+(".$jumlah."), idproduct=".$idProduct." WHERE id = ".$id);
    } else {
    	$myResult = ExecuteUpdate("INSERT INTO stock (idorder_detail, idproduct, jumlah) VALUES (".$idorderdetail.", ".$idProduct.", ".$jumlah.")");
    }
}

// dipanggil di deliveryorder_detail
function checkCloseOrder($idOrderDetail) {
	$data = ExecuteRow("SELECT idorder, sisa FROM order_detail WHERE id=".$idOrderDetail);
	$update = ExecuteUpdate("UPDATE order_detail SET aktif=".($data['sisa'] > 0 ? 1 : 0)." WHERE id=".$idOrderDetail);

	//$orderAktif = ExecuteScalar("SELECT COUNT(id) FROM order_detail WHERE aktif=1 and idorder=".$data['idorder']);

	//$update = ExecuteUpdate("UPDATE `order` SET aktif=".($orderAktif > 0 ? 1 : 0)." WHERE id=".$data['idorder']);
}

// dipanggil di invoice_detail, redeem_bonus
function addBlackBonus($idCustomer, $jumlah) {
//	$update = ExecuteUpdate("UPDATE customer SET budget_bonus_rp=IFNULL(budget_bonus_rp,0)+(".$jumlah.") WHERE id=".$idCustomer);
}

// dipanggil di pembayaran
function checkCloseInvoice($idinvoice) {
	$sisaBayar = ExecuteScalar("SELECT sisabayar FROM invoice WHERE id=".$idinvoice);
	if ($sisaBayar <= 0) {
		$update = ExecuteUpdate("UPDATE invoice SET aktif=0 WHERE id=".$idinvoice);
	} else {
		$update = ExecuteUpdate("UPDATE invoice SET aktif=1 WHERE id=".$idinvoice);
	}
}

// dipanggil di invoice_detail
function updateInvoice($idInvoice) {
	$oldInvoice = ExecuteRow("SELECT * FROM invoice WHERE id=".$idInvoice);
	$updateInvoice = ExecuteUpdate("UPDATE invoice SET totalnonpajak=(SELECT IFNULL(SUM(totaltagihan), 0) FROM invoice_detail WHERE idinvoice=".$idInvoice."), totaltagihan=totalnonpajak+((pajak/100)*totalnonpajak), sisabayar=totaltagihan WHERE id=".$idInvoice);

//	$newInvoice = ExecuteRow("SELECT * FROM invoice WHERE id=".$idInvoice);
//	$selisih = $newInvoice['totaltagihan']-$oldInvoice['totaltagihan'];
//	$sisaBayar = $oldInvoice['sisabayar']
//	$updateSisaBayar = ExecuteUpdate("UPDATE invoice SET sisabayar=".." WHERE id=".$idInvoice);
}

// dipanggil di deliveryorder_detail
function checkReadOnly($table, $id) {
    switch ($table) {
        case "order":
            $data = ExecuteScalar("SELECT count(id) FROM deliveryorder_detail WHERE idorder=".$id);     
            break;
        case "order_detail":
            $data = ExecuteScalar("SELECT count(id) FROM deliveryorder_detail WHERE idorder_detail=".$id);
            break;
        case "invoice":
            $data = ExecuteScalar("SELECT count(id) FROM pembayaran WHERE idinvoice=".$id);
            break;
        default:
            // code...
            break;
    }
    $readOnly = ($data > 0 ? 1 : 0);
    if (!empty($table)) {        
        $updateReadOnly = ExecuteUpdate("UPDATE `".$table."` SET readonly=".$readOnly." WHERE id=".$id);
    }
}

// dipanggil di npd_status, ijinhaki_status, ijinbpom_status
function updateStatus($table, $id) {
	if ($table = "npd") {
		updateStatusNpd($id);
		return;
	}
	$status = ExecuteScalar("SELECT COUNT(*) FROM ".$table."_status WHERE id".$table."=".$id);
	$updateReadOnly = ExecuteUpdate("UPDATE `".$table."` SET readonly=".($status > 0 ? 1 : 0)." WHERE id=".$id);
	if ($status > 0) {
		$updateStatus = ExecuteUpdate("update `".$table."` SET `status`=(SELECT `status` FROM ".$table."_status WHERE id".$table."=".$id." order BY created_at desc LIMIT 1) WHERE id=".$id);
	} else {
		$updateStatus = ExecuteUpdate("update `".$table."` SET `status`='Baru' WHERE id=".$id);
	}
}

function updateStatusNpd($id) {
	$status = ExecuteRow("SELECT * FROM (SELECT ns.`status`, ns.created_at FROM npd_status ns WHERE ns.idnpd=".$id." UNION SELECT if(nsa.`status`=1, 'Sample Diterima', if(nsa.`status`=-1, 'Sample Ditolak', 'Sample Belum Direview')) `status`, nsa.created_at FROM npd_sample nsa WHERE nsa.idnpd=".$id." UNION SELECT if(nr.`status`=1, 'Review Diterima', if(nr.`status`=-1, 'DROP NPD', 'Revisi Sample')) `status`, nr.created_at FROM npd_review nr WHERE nr.idnpd=".$id." UNION SELECT if(nc.idnpd_sample IS NOT NULL, 'Sample Dikonfirmasi', 'Sample Belum Dikonfirmasi') `status`, nc.created_at FROM npd_confirm nc WHERE nc.idnpd=".$id." UNION SELECT if(nh.disetujui=1, 'Harga Disetujui', 'Harga Ditolak') `status`, nh.created_at FROM npd_harga nh WHERE nh.idnpd=".$id.") npdstatusss order BY created_at DESC LIMIT 1");
	if (!empty($status['status'])) {
		$updateReadOnly = ExecuteUpdate("UPDATE `npd` SET readonly=1 WHERE id=".$id);
		$updateStatus = ExecuteUpdate("update `npd` SET `status`='".$status['status']."' WHERE id=".$id);
	} else {
		$updateReadOnly = ExecuteUpdate("UPDATE `npd` SET readonly=0 WHERE id=".$id);
		$updateStatus = ExecuteUpdate("update `npd` SET `status`='Baru' WHERE id=".$id);
	}
}

function addNpdToProduct($idNpd) {
	$npd = ExecuteRow("SELECT n.idpegawai, n.idproduct, n.idbrand, n.kodeorder kode, id.nama, NULL satuan, n.ukuran netto, n.idkategoribarang, n.idjenisbarang, n.idkualitasbarang, 1 aktif, 1 ijinbpom, n.idproduct_acuan, n.bahan, n.ukuran, nh.hargapcs harga, n.warna, n.parfum, n.tambahan, n.idkemasanbarang, n.label FROM npd n, npd_harga nh, ijinbpom_detail id WHERE n.id=nh.idnpd AND nh.disetujui=1 AND n.id=id.idnpd AND n.id=".$idNpd);
	if (empty($npd['idproduct'])) {
		$insert = ExecuteUpdate("INSERT INTO `product` (`idbrand`, `kode`, `nama`, `satuan`, `netto`, `idkategoribarang`, `idjenisbarang`, `idkualitasbarang`, `aktif`, `ijinbpom`, `idproduct_acuan`, `bahan`, `ukuran`, `harga`, `warna`, `parfum`, `tambahan`, `idkemasanbarang`, `label`, `created_by`) VALUES ('".$npd['idbrand']."', '".$npd['kode']."', '".addslashes($npd['nama'])."', '".$npd['satuan']."', '".$npd['netto']."', '".$npd['idkategoribarang']."', '".$npd['idjenisbarang']."', '".$npd['idkualitasbarang']."', '".$npd['aktif']."', '".$npd['ijinbpom']."', '".$npd['idproduct_acuan']."', '".$npd['bahan']."', '".$npd['ukuran']."', '".$npd['harga']."', '".$npd['warna']."', '".addslashes($npd['parfum'])."', '".$npd['tambahan']."', '".$npd['idkemasanbarang']."', '".$npd['label']."', '".$npd['idpegawai']."')");
		$update = ExecuteUpdate("UPDATE npd SET idproduct=(select id from product where kode='".$npd['kode']."' limit 1) WHERE id=".$idNpd);
	} else {
		$update = ExecuteUpdate("UPDATE product SET aktif=1, ijinbpom=1, nama='".addslashes($npd['nama'])."', harga='".$npd['harga']."', ukuran='".$npd['ukuran']."' WHERE id=".$npd['idproduct']);
	}
}

function addNpdToProduct2($idNpd, $nama) {
	$npd = ExecuteRow("SELECT n.idpegawai, n.idproduct, n.idbrand, n.kodeorder kode, id.nama, NULL satuan, n.ukuran netto, n.idkategoribarang, n.idjenisbarang, n.idkualitasbarang, 1 aktif, 1 ijinbpom, n.idproduct_acuan, n.bahan, n.ukuran, nh.hargapcs harga, n.warna, n.parfum, n.tambahan, n.kemasanbarang, n.label FROM npd n, npd_harga nh, ijinbpom_detail id WHERE n.id=nh.idnpd AND nh.disetujui=1 AND n.id=id.idnpd AND n.id=".$idNpd);
	if (empty($npd['idproduct'])) {
		$insert = ExecuteUpdate("INSERT INTO `product` (`idbrand`, `kode`, `nama`, `satuan`, `netto`, `idkategoribarang`, `idjenisbarang`, `idkualitasbarang`, `aktif`, `ijinbpom`, `idproduct_acuan`, `bahan`, `ukuran`, `harga`, `warna`, `parfum`, `tambahan`, `kemasanbarang`, `label`, `created_by`) VALUES ('".$npd['idbrand']."', '".$npd['kode']."', '".addslashes($nama)."', '".$npd['satuan']."', '".$npd['netto']."', '".$npd['idkategoribarang']."', '".$npd['idjenisbarang']."', '".$npd['idkualitasbarang']."', '".$npd['aktif']."', '".$npd['ijinbpom']."', '".$npd['idproduct_acuan']."', '".$npd['bahan']."', '".$npd['ukuran']."', '".$npd['harga']."', '".$npd['warna']."', '".addslashes($npd['parfum'])."', '".$npd['tambahan']."', '".$npd['kemasanbarang']."', '".$npd['label']."', '".$npd['idpegawai']."')");
		$update = ExecuteUpdate("UPDATE npd SET idproduct=(select id from product where kode='".$npd['kode']."' limit 1) WHERE id=".$idNpd);
	} else {
		$update = ExecuteUpdate("UPDATE product SET aktif=1, ijinbpom=1, nama='".addslashes($nama)."', harga='".$npd['harga']."', ukuran='".$npd['ukuran']."', kemasanbarang='".$npd['kemasanbarang']."' WHERE id=".$npd['idproduct']);
	}
}

function removeNpdFromProduct($idNpd) {
	$update = ExecuteUpdate("UPDATE product SET aktif=0, ijinbpom=0 WHERE id=(SELECT idproduct FROM npd WHERE id=".$idNpd.")");
}

// UNTUK API
function getNextKodeNpd($idCustomer) {
	$kode = ExecuteScalar("SELECT kodenpd FROM customer WHERE id = {$idCustomer}");
    $kode = "TM-".$kode."-";
   	$maxKode = ExecuteScalar("SELECT MAX(kodeorder) FROM npd WHERE kodeorder LIKE '{$kode}%'");
   	if ($maxKode == null) {
   		return $kode."001";
   	} else {
		$temp = explode("-", $maxKode);
   		$nominal = (intval(end($temp)))+1;
   		if($nominal <= 9) {
   			$kode = $kode."00".$nominal;
   		} else if ($nominal > 9 && $nominal <= 99) {
   			$kode = $kode."0".$nominal;
   		} else {
   			$kode = $kode.$nominal;
   		}
   	}
    return $kode;
}

function getNextKodeInvoice($idorder) {
    $format = "INV/%YY%MM-%URUTAN"; // %MM BULAN FAKTUR IKUT BULAN PO
    $digit_length = 4;
    $exists = ExecuteRow("SELECT COUNT(*) AS total, max(kode) AS kode FROM invoice WHERE idorder = {$idorder}");
    if ($exists['total'] > 0) {
        $alphabets = [0, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
        $kode = $exists['total'] >= 2 ? substr($exists['kode'], 0, -1) : $exists['kode'];
        return $kode . $alphabets[$exists['total'] + 1];
    }
    $order = ExecuteRow("SELECT tanggal FROM `order` WHERE id = {$idorder}")['tanggal'];
    $lastkodeinvoice = "INV/".date('ym', strtotime($order));
    $maxKode = ExecuteRow("SELECT kode FROM invoice WHERE created_at = (SELECT MAX(created_at) FROM invoice WHERE kode LIKE '{$lastkodeinvoice}%')");
    $format = str_replace('%MM', date('m', strtotime($order)), $format);
    $reformat = penomoran_date_replace($format);
    if (!$maxKode['kode']) {
        return str_replace('%URUTAN', str_pad(1, $digit_length, 0, STR_PAD_LEFT), $reformat);
    } else {
        $string = explode("%URUTAN", $reformat);
        $trim_prefix = str_replace($string[0], '', $maxKode['kode']);
        $trim_suffix = str_replace($string[1], '', $trim_prefix);
        return $string[0].str_pad(intval($trim_suffix)+1, $digit_length, 0, STR_PAD_LEFT).$string[1];
    }
}

function getNextKodeOrder($idbrand=1) {
    date_default_timezone_set('Asia/Jakarta');
    $digit_length = 3;
    $cutoff = "14:00:00";
    if ($idbrand > 1) {
        $format = "SP%URUTANTM-%DD%MM%YY/BSD";
        $status = " AND kode LIKE '%TM%'";
    } else {
        $format = "SP%URUTAN-%DD%MM%YY/BSD";
        $status = " AND kode NOT LIKE '%TM%'";
    }
    if (date('H:i:s') > date('H:i:s', strtotime($cutoff))) {
        $lastkode = date('dmy', strtotime("+1 day"));
        $format = str_replace('%DD', date('d', strtotime('+1 day')), $format);
    } else {
        $lastkode = date('dmy');
    }
    $maxKode = ExecuteRow("SELECT kode, created_at AS last_post FROM `order` WHERE created_at = (SELECT MAX(created_at) FROM `order` WHERE 
        kode LIKE '%{$lastkode}/BSD' {$status})");

    // KOND.1 DATA KOSONG
    // KOND.2 DATA TERAKHIR 2 HARI YG LALU, JAM SAAT INI 12:00 BUAT KODE DENGAN URUTAN BARU DI TANGGAL SAAT INI
    // KOND.3 DATA TERAKHIR 2 HARI YG LALU, JAM SAAT INI JAM 15:00 BUAT KODE DENGAN URUTAN BARU DI TANGGAL  BESOK (CUTOFF 14:00)

    // KOND.4 DATA TERAKHIR KEMARIN JAM 9:00, JAM SAAT INI 12:00 KODE DILANJUT
    // KOND.5 DATA TERAKHIR KEMARIN JAM 12:00, JAM SAAT INI 15:00 BUAT KODE URUTAN BARU DENGAN TANGGAL BESOK (CUTOFF 14:00)

    // KOND.6 DATA TERAKHIR HARI INI JAM 9:00, JAM SAAT INI 12:00 KODE DILANJUT
    // KOND.7 DATA TERAKHIR HARI INI JAM 9:00, JAM SAAT INI 15:00 BUAT KODE URUTAN BARU DENGAN TANGGAL BESOK (CUTOFF 14:00)
    $reformat = penomoran_date_replace($format);
    if (!$maxKode['kode']) {
        return str_replace('%URUTAN', str_pad(1, $digit_length, 0, STR_PAD_LEFT), $reformat);
    };
    $string = explode("%URUTAN", $reformat);
    $trim_prefix = str_replace($string[0], '', $maxKode['kode']);
    $trim_suffix = str_replace($string[1], '', $trim_prefix);
    return $string[0].str_pad(intval($trim_suffix)+1, $digit_length, 0, STR_PAD_LEFT).$string[1];
}

function getNextKode($tipe, $id) {
    if ($tipe == null) { return; }
    $format = $column = $table = "";
    $digit_length = 4; // default three digits
   	if ($tipe == "pegawai") {
   		$table = "pegawai";
   		$column = "kode";
   		$format = "PEG-%URUTAN";
   	} elseif ($tipe == "customer") {
   		$table = "customer";
   		$column = "kode";
   		$format = "LD. %URUTAN";
   	} elseif ($tipe == "suratjalan") {
   		$table = "suratjalan";
   		$format = "SJ/%YY%MM-%URUTAN";
   	} elseif ($tipe == "pembayaran") {
   		$table = "pembayaran";
   		$format = "PB/%YY%MM-%URUTAN";
   	} elseif ($tipe == "stock_order") {
   		$table = "stock_order";
   		$format = "ST/ORD/%YY%MM-%URUTAN";
   	}
    if (strpos($format, "%MM") !== false || strpos($format, "%YY") !== false) {
        $maxKode = ExecuteRow("SELECT kode, created_at AS last_post FROM `{$table}` WHERE created_at = (SELECT MAX(created_at) FROM `{$table}`)");
    } else {
        $maxKode = ExecuteRow("SELECT MAX({$column}) as kode FROM `{$table}`");
    }
   	if (!$maxKode['kode']) {
        $reformat = penomoran_date_replace($format);
        return str_replace('%URUTAN', str_pad(1, $digit_length, 0, STR_PAD_LEFT), $reformat);
   	}
    empty($maxKode['last_post']) ? $maxKode['last_post'] = date('Y-m-d') : $maxKode['last_post'];
    $start = date_create(date('Y-m-d H:i:s', strtotime($maxKode['last_post'])));
    $end = date_create(date('Y-m-d H:i:s'));
    $reformat = penomoran_date_replace($format);
    if (($end->getTimestamp() - $start->getTimestamp()) < 1) {
        return str_replace('%URUTAN', str_pad(1, $digit_length, 0, STR_PAD_LEFT), $reformat);
    }
    $string = explode("%URUTAN", $reformat);
    $trim_prefix = str_replace($string[0], '', $maxKode['kode']);
    $trim_suffix = str_replace($string[1], '', $trim_prefix);
    return $string[0].str_pad(intval($trim_suffix)+1, $digit_length, 0, STR_PAD_LEFT).$string[1];
}

function penomoran_date_replace($format) {
    if (strpos($format, "%YY") !== false) {
        $format = str_replace("%YY", date('y'), $format);
    }
    if (strpos($format, "%MM") !== false) {
        $format = str_replace("%MM", date('m'), $format);
    }
    if (strpos($format, "%DD") !== false) {
        $format = str_replace("%DD", date('d'), $format);
    }
    return $format;
}

// function getNextKode($tipe, $id) {
//     $kode = $column = $table = "";
//     if ($tipe == "pegawai") {
//         $table = "pegawai";
//         $column = "kode";
//         $kode = "PEG-";
//     } elseif ($tipe == "customer") {
//         $table = "customer";
//         $column = "kode";
//         $kode = "LD. ";
//     } elseif ($tipe == "order") {
//         $table = "`order`";
//         $column = "kode";
//         $kode = "SP-";
//     } elseif ($tipe == "deliveryorder") {
//         $table = "deliveryorder";
//         $column = "kode";
//         $kode = "FD-";
//     } elseif ($tipe == "invoice") {
//         $table = "invoice";
//         $column = "kode";
//         $kode = "BSD-";
//     } elseif ($tipe == "suratjalan") {
//         $table = "suratjalan";
//         $column = "kode";
//         $kode = "SJ-";
//     } elseif ($tipe == "pembayaran") {
//         $table = "pembayaran";
//         $column = "kode";
//         $kode = "PB-";
//     }

//     $maxKode = ExecuteScalar("SELECT MAX(".$column.") FROM ".$table);
//     if ($maxKode == null) {
//         $kode = $kode."0001";
//     } else {
//         $pecah = explode("-", $maxKode);
//         if ($tipe == "customer") {
//             $pecah = explode(" ", $maxKode);
//         }
//         $nominal = intval(end($pecah))+1;
//         if($nominal <= 9) {
//             $kode = $kode."000".$nominal;
//         } else if ($nominal > 9 && $nominal <= 99) {
//             $kode = $kode."00".$nominal;
//         } else if ($nominal > 99 && $nominal <= 999) {
//             $kode = $kode."0".$nominal;
//         } else {
//             $kode = $kode.$nominal;
//         }
//     }

//     return $kode;
// }
function tgl_indo($tanggal, $format='date'){
	$bulan = array (
		1 => 'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);	
    switch ($format) {
        case 'datetime':
            return date('d', strtotime($tanggal)) . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . date('Y', strtotime($tanggal)) .  ' ' . date('H:i:s', strtotime($tanggal));
            break;
        case 'month-year':
            return $bulan[ (int)$pecahkan[1] ] . ' ' . date('Y', strtotime($tanggal));
            break;
        default:
            return date('d', strtotime($tanggal)) . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . date('Y', strtotime($tanggal));
            break;
    }
}

function cek_po_aktif($idcustomer) {
    return ExecuteRow("SELECT COUNT(*) AS jumlah
                    FROM (
                    SELECT idorder AS idorder, idcustomer
                    FROM invoice
                    WHERE sisabayar > 0 
                    UNION
                    SELECT `order`.id AS idorder, idcustomer
                    FROM `order`
                    JOIN order_detail ON `order`.id = order_detail.idorder AND order_detail.sisa > 0
                    LEFT JOIN stock ON stock.idorder_detail = order_detail.id AND stock.jumlah > 0
                    GROUP BY `order`.id
                    ) po_aktif
                    WHERE idcustomer = {$idcustomer}
                ")['jumlah'];    
}

function cek_totaltagihan_po_aktif($idcustomer) {
    return ExecuteRow("SELECT tagihan AS totaltagihan
                    FROM (
                    SELECT idorder, idcustomer, sisabayar AS tagihan
                    FROM invoice
                    WHERE sisabayar > 0
                    UNION
                    SELECT `order`.id AS idorder, idcustomer, 
                     SUM(((ifnull(stock.jumlah,0) + order_detail.sisa) - bonus) * harga) AS tagihan
                    FROM `order` 
                    JOIN order_detail ON `order`.id = order_detail.idorder
                    LEFT JOIN stock ON stock.idorder_detail = order_detail.id
                    GROUP BY `order`.id
                    ) po_aktif WHERE idcustomer = {$idcustomer}
                ")['totaltagihan'];
}

/*
CATATAN TRANSAKSI PENJUALAN
order baru => order.aktif = 1 & order.readonly = 0
order masuk do, kirim sebagian => order.aktif = 1 & order.readonly = 1
order masuk do, dengan jumlah penuh => order.aktif = 0 & order.readonly = 1 & do.readonly = 0
order masuk invoice => do.readonly = 1 & invoice.aktif = 1 & invoice.readonly = 0 & invoice.sent = 0
order masuk surat jalan => invoice.sent = 1
order masuk bayar sebagian => invoice.aktif = 1 & invoice.readonly = 1 invoice.sent = 0
order masuk bayar lunas => invoice.aktif = 0
*/
function rupiah($number, $decimal='with-decimal') {
    if (!is_numeric($number)) {
        return "Bad Format!";
    }
    if ($number < 1000) {
        return $number;
    }
    switch ($decimal) {
        case 'without-decimal':
            return number_format($number, 0, ",", ".");
            break;
        default:
            return number_format($number, 2, ",", ".");
            break;
    }
}

function base_url() {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https://" : "http://";
    $script = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    return $protocol . $_SERVER['HTTP_HOST'] . $script;
}

function check_kpi_existing($idpegawai, $bulan) {
	$check = ExecuteRow("SELECT COUNT(*) as jumlah FROM kpi_marketing WHERE idpegawai = {$idpegawai} AND bulan = '".date('Y-m-01', strtotime($bulan))."'");
    if ($check['jumlah'] > 0) {
        return false;
    } 
    return true;
}

function curl_post($url, $data, $url_auth=""){
    // Prepare new cURL resource
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Authentication PHPMAKER
    // $url_auth = 'http://localhost/pabrik/api/login?username=admin&password=admin123';
    $token = null;
    if (!empty($url_auth)) {
        $token = json_decode(curl_get($url_auth), true)['JWT'];
        $token = "X-Authorization: {$token}";
    }

    // Set HTTP Header for POST request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        $token
    ));

    // Submit the POST request
    $result = curl_exec($ch);

    // Close cURL session handle
    curl_close($ch);     
    return $result;
}

function curl_get($url){
    // persiapan curl
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // menampilkan hasil curl
    return $output;
}
$API_ACTIONS['confirmation-bot-queue'] = function(Request $request, Response &$response) {
    $type = Param("type", Route(1));
    $items = Param("items", Route(2));
    if (empty($items)) {
        echo json_encode([]); die;
    }
    $process = true;
    $message = '';
    $data = explode(',', urldecode($items));
    if ($type == 'cancel') {
        $status = '-2';
        $canceled = ", canceled_at = '".date('Y-m-d H:i:s')."'";
        $message = 'Data has been canceled successfully.';
    } else {
        $status = '0';
        $canceled = null;
        $message = 'Data has been queued successfully.';
    }
    foreach ($data as $value) {
        $update = ExecuteUpdate("UPDATE bot_history SET status = '{$status}' {$canceled} WHERE id = {$value}");
        if (!$update) {
            $process = false;
        }
    }

    /*
     * STATUS BOT
     * -2 CANCEL
     * -1 PENDING / WAITING TO CONFIRM CANCEL/QUEUING
     * 1 QUEUING TO DELIVER
     * 0 DELIVERED
    */
    WriteJson(['status' => $process, 'message' => $message]);
};
$API_ACTIONS['goto-reminder'] = function(Request $request, Response &$response) {
    $items = Param("items", Route(1));
    $tanggal = Param("tanggal", Route(2));
    if (empty($items)) {
        echo json_encode([]); die;
    }
    $status = true;
    $data = explode(',', urldecode($items));
    foreach ($data as $value) { 
        $row = ExecuteRow("SELECT o.id AS idorder,
                            c.nama AS nama_customer,
                            c.hp AS nomor_handphone,
                            i.kode AS kode_faktur,
                            DATE_FORMAT(i.tglinvoice + INTERVAL `t`.`value` DAY, '%Y-%m-%d') AS jatuhtempo,
                            TIMESTAMPDIFF(DAY, i.tglinvoice + INTERVAL `t`.`value` DAY, '{$tanggal}') AS umur_faktur,
                            i.totaltagihan AS nilai_faktur, 
                            i.sisabayar AS piutang
                        FROM `order` o
                        JOIN customer c ON c.id = o.idcustomer
                        LEFT JOIN invoice i ON i.idorder = o.id
                        LEFT JOIN termpayment t ON i.idtermpayment = t.id
                        WHERE i.sisabayar > 0 AND o.id = '{$value}'");

        // $totalumurfaktur = $row['umur_faktur'] + $row['term_payment'];
        $tagihan = $row['piutang'] < $row['nilai_faktur'] ? $row['piutang'] : $row['nilai_faktur'];
        if ($row['umur_faktur'] < -1) {
            $message = "Yth. {$row['nama_customer']}, Selamat Siang kami dari CV.Beautie Surya Derma menyampaikan tentang adanya Faktur yang akan jatuh tempo dalam beberapa hari kedepan untuk mohon dapat dibantu pembayarannya.
                \nNo Faktur : {$row['kode_faktur']}
                \nNilai Faktur : Rp. ".rupiah($tagihan, 'without-decimal')."
                \nJatuh Tempo : {$row['jatuhtempo']}
                \nMohon dapat diinformasikan kembali ke kami di Nomor ini apabila sudah ditransfer, dan mohon abaikan chat ini apabila sudah ditransfer.
                \nTerimakasih atas kesetiaan dan kepercayaannya kepada kami. Semoga {$row['nama_customer']} sehat selalu";
        }
        if ($row['umur_faktur'] >= 0 && $row['umur_faktur'] <= 7) {
            $message = "Yth. {$row['nama_customer']}, Selamat Siang kami dari CV.Beautie Surya Derma menginformasikan Tagihan Faktur sbb:
                \nNo Faktur : {$row['kode_faktur']}
                \nNilai Faktur : Rp. ".rupiah($tagihan, 'without-decimal')."
                \nJatuh Tempo : {$row['jatuhtempo']}
                \nPembayaran bisa melalui transfer rekening BCA 8290977593 a/n. Suryo Sudibyo SE, dan utk memudahkan proses tracking serta menghindari penagihan kembali mohon pd saat transfer diberi keterangan “Nama_Klinik_Merek_Nomor Faktur”.
                \nApabila sudah ditransfer mohon dapat di informasikan ke nomor ini juga.
                \nTerimakasih atas kerjasama dan kepercayaannya kepada kami. Semoga {$row['nama_customer']} sehat selalu";
        }
        if ($row['umur_faktur'] > 7) {
            $message = "Yth. {$row['nama_customer']}, Selamat Siang kami dari CV.Beautie Surya Derma mengingatkan kembali Tagihan Faktur sbb:
                \nNo Faktur : {$row['kode_faktur']}
                \nNilai Faktur : Rp. ".rupiah($tagihan, 'without-decimal')."
                \nJatuh Tempo : {$row['jatuhtempo']}
                \nPembayaran bisa melalui transfer rekening BCA 8290977593 a/n. Suryo Sudibyo SE, dan utk memudahkan proses tracking serta menghindari penagihan kembali mohon pd saat transfer diberi keterangan “Nama_Klinik_Merek_Nomor Faktur”.
                \nApabila sudah ditransfer mohon dapat di informasikan ke nomor ini juga.
                \nTerimakasih atas kerjasama dan kepercayaannya kepada kami. Semoga {$row['nama_customer']} sehat selalu";
        }

        // keterangan column
        $keterangan = "Umur Faktur: {$row['umur_faktur']},\nTgl Penagihan: " . tgl_indo($tanggal) . ".";
        $insert = ExecuteUpdate("INSERT INTO bot_history (prop_code, prop_name, phone, messages, status, keterangan, created_at) VALUES ('{$row['kode_faktur']}', 'Penagihan {$row['nama_customer']}', '{$row['nomor_handphone']}', '{$message}', '-1', '{$keterangan}', '".date('Y-m-d H:i:s')."')");
        if (!$insert) $status = false;
    }
    WriteJson(['status' => $status]);
};
$API_ACTIONS['sync-do-sip'] = function(Request $request, Response &$response) {
    $json = curl_get(url_integrasi() . "?action=sync-delivery-order");
    $data = json_decode($json, true);
    $status = true;
    $check = [];
    foreach($data['data'] as $row) {
        // INISIALISASI
        $do = true;
        $do_detail = true;

        // CHECK EXISTING DELIVERY ORDER
        $delivery = ExecuteRow("SELECT id FROM deliveryorder WHERE kode = '{$row['no_suratjalan']}' AND tanggal = '{$row['tgl_kirim']}'")['id'];
        foreach ($row['penjualan'] as $ord) {
            // GET JUMLAH DATA DARI DB            
            $db_orders = ExecuteRows("SELECT o.id as idorder, od.id as idorderdetail, od.jumlah + od.bonus as totalorder FROM order_detail od JOIN `order` o ON o.id = od.idorder WHERE o.kode = '{$ord['no_penjualan']}'");

            // IF NOT EXIST CREATE DELIVERY ORDER
            if (!$delivery && $db_orders) {
                $do = Execute("INSERT INTO deliveryorder (kode, tanggal, created_at, readonly) VALUES ('{$row['no_suratjalan']}', '{$row['tgl_kirim']}', '".date('Y-m-d H:i:s')."', 1)");
                $delivery = ExecuteRow("SELECT id FROM deliveryorder WHERE kode = '{$row['no_suratjalan']}' AND tanggal = '{$row['tgl_kirim']}'")['id'];
            }

            // CEK EXISTING DATA DELIVERY & DATA ORDER
            if ($delivery && $db_orders) {
                $datas = [];
                // INSERT DATA DARI API TO deliveryorder_detail
                foreach ($ord['penjualan_detil'] as $val) {
                    $detail = ExecuteRow("SELECT o.id as idorder, od.id as idorderdetail, od.jumlah + od.bonus as totalorder, p.id as idproduct FROM order_detail od JOIN `order` o ON o.id = od.idorder JOIN product p ON p.id = od.idproduct WHERE o.kode = '{$ord['no_penjualan']}' AND p.kode = '{$val['kode_barang']}'");

                    // AKUMULASI SISA ORDER
                    $sisa = $detail['totalorder'] - $val['jumlah_kirim'];
                    $deliverydetil_exist = "SELECT COUNT(*) AS jumlah
                                            FROM deliveryorder ded
                                            JOIN deliveryorder_detail dedd ON dedd.iddeliveryorder = ded.id
                                            JOIN `order` o ON o.id = dedd.idorder
                                            JOIN order_detail od ON od.id = dedd.idorder_detail
                                            JOIN product p ON p.id = od.idproduct
                                            WHERE ded.kode = '{$row['no_suratjalan']}' 
                                            AND ded.tanggal = '{$row['tgl_kirim']}' 
                                            AND p.kode = '{$val['kode_barang']}' 
                                            AND o.kode = '{$ord['no_penjualan']}'";
                    $existing = ExecuteRow($deliverydetil_exist)['jumlah'];

                    // CEK EXISTING DATA deliveryorder_detail
                    if (!$existing) {
                        // INSERT TO DB deliveryorder_detail
                        $do_detail = Execute("INSERT INTO deliveryorder_detail (iddeliveryorder, idorder, idorder_detail, totalorder, jumlahkirim, sisa) VALUES ({$delivery}, {$detail['idorder']}, {$detail['idorderdetail']}, {$detail['totalorder']}, {$val['jumlah_kirim']}, {$sisa})");

                        // UPDATE SISA ORDER DETAIL
                        ExecuteUpdate("UPDATE order_detail SET sisa = sisa-({$val['jumlah_kirim']}) WHERE id = {$detail['idorderdetail']}");

                        // ADD JUMLAH KIRIM TO STOCK
                        addStock($detail['idorderdetail'], $val['jumlah_kirim']);

                        // CEK CLOSE ORDER
                        checkCloseOrder($detail['idorderdetail']);

                        // CEK READONLY ORDER DETAIL
                        checkReadOnly("order_detail", $detail['idorderdetail']);

                        // CEK READONLY ORDER
                        checkReadOnly("order", $detail['idorder']);
                    }

                    // INSERT TO TEMP ARRAY FOR CHECKING EXISTING DATA
                    $datas[] = $detail['idorderdetail'];
                }

                /* 
                 * CEK JUMLAH DATA ORDER:
                 * JIKA JUMLAH DATA DARI API KURANG DARI JUMLAH DATA ORDER DI DB, 
                 * MAKA DITAMBAHKAN DGN JUMLAH KIRIM 0
                 */
                if (count($ord['penjualan_detil']) < count($db_orders)) {
                    // INSERT DATA DENGAN JUMLAH KIRIM 0, UNTUK DATA YANG TIDAK DIKIRIM
                    foreach ($db_orders as $dbo) {
                        $deliverydetil_exist = "SELECT COUNT(*) AS jumlah
                                                FROM deliveryorder ded
                                                JOIN deliveryorder_detail dedd ON dedd.iddeliveryorder = ded.id
                                                JOIN `order` o ON o.id = dedd.idorder
                                                JOIN order_detail od ON od.id = dedd.idorder_detail
                                                WHERE ded.kode = '{$row['no_suratjalan']}' 
                                                AND ded.tanggal = '{$row['tgl_kirim']}' 
                                                AND od.id = {$dbo['idorderdetail']}
                                                AND o.kode = '{$ord['no_penjualan']}'";
                        $existing = ExecuteRow($deliverydetil_exist)['jumlah'];

                        // JIKA DATA SUDAH ADA DI ARRAY MAKA TIDAK PERLU DI INSERT
                        if (!in_array($dbo['idorderdetail'], $datas) && !$existing) {
                            $do_detail = Execute("INSERT INTO deliveryorder_detail (iddeliveryorder, idorder, idorder_detail, totalorder, jumlahkirim, sisa) VALUES ({$delivery}, {$dbo['idorder']}, {$dbo['idorderdetail']}, {$dbo['totalorder']}, 0, {$dbo['totalorder']})");
                        }
                    }
                }

                // UPDATE STATUS ORDER
                ExecuteUpdate("UPDATE `order` SET `status` = '{$ord['status']}', catatan = '{$ord['catatan']}' WHERE kode = '{$ord['no_penjualan']}'");
            }
        }

        // check error
        if (!$do || !$do_detail) {
            $check[] = false;
        }
    }

    // CEK SYNC STATUS
    if (in_array(false, $check)) {
        $status = false;
    }

    // OUTPUT
    WriteJson(['status' => $status, 'rows' => count($check) . ' row(s) updated!']);
};
$API_ACTIONS['sync-order-sip'] = function(Request $request, Response &$response) {
    $json = curl_get(url_integrasi() . "?action=sync-bsd-order");
    $data = json_decode($json, true);
    $status = true;
    $check = [];
    foreach($data['data'] as $row) {
        $order = ExecuteRow("SELECT id, status FROM `order` WHERE kode = '{$row['no_penjualan']}'");
        if ($order && $order['status'] != $row['status']) {
            $update = ExecuteUpdate("UPDATE `order` SET `status` = '{$row['status']}', catatan = '{$row['catatan']}' WHERE id = {$order['id']}");
            if (!$update) {
                $check[] = false;
            }
        }
    }
    if (in_array(false, $check)) {
        $status = false;
    }
    WriteJson(['status' => $status, 'rows' => count($check) . ' row(s) updated!']);
};

// OPSI 1 (URL DENGAN CALLBACK)
// $API_ACTIONS['delivery_order'] = function(Request $request, Response &$response) {
//     $json = file_get_contents('php://input');
//     $data = json_decode($json, true);

//     $status = true;
//     $query = Execute("INSERT INTO deliveryorder (kode, tanggal, created_at) VALUES ('{$data['data'][0]['nomor']}', '{$data['data'][0]['tanggal']}', '".date('Y-m-d H:i:s')."')");
//     $do = ExecuteRow("SELECT id FROM deliveryorder WHERE kode = '{$data['data'][0]['nomor']}'");

//     foreach ($data['data'][0]['details'] as $row) {
//         $order = ExecuteRow("SELECT od.id as idorderdetail, idorder, jumlah + bonus as totalorder FROM order_detail od JOIN `order` o ON o.id = od.idorder JOIN product p ON p.id = od.idproduct WHERE o.kode = '{$row['kode_penjualan']}' AND p.kode = '{$row['kode_produk']}'");
//         $query = Execute("INSERT INTO deliveryorder_detail (iddeliveryorder, idorder, idorder_detail, totalorder, sisa, jumlahkirim) VALUES ({$do['id']}, {$order['idorder']}, {$order['idorderdetail']}, {$order['totalorder']}, {$row['jumlah_kirim']}, {$order['totalorder']} - {$row['jumlah_kirim']})");
//     }
//     WriteJson(['status' => $status]);
// };
