<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

header("Content-Type:application/json");
	include('db.php');
//	print_r($_POST);
$json = file_get_contents('php://input');
$data = json_decode($json);
// 		$response['sukses'] = $data;
// 		$json_response = json_encode($response);
// 		echo $json_response;
// 		

if ($data->mtd=="INSERTPENAGIHAN")
{
	$sql = "INSERT into penagihan (messages,nomor_handphone) VALUES ('".$data->messages."','".$data->nohp."')";
	$result = mysqli_query($con,$sql);
	if($result)
	{
		$response['sukses'] = "OK";
		$response['sql'] = $sql;
		$json_response = json_encode($response);

	} else {
		$response['sukses'] = "FAIL";
		$response['sql'] = $sql;
		$json_response = json_encode($response);
	}
	echo $json_response;

}



	function gen_uuid() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	
			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),
	
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,
	
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,
	
			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}

?>


