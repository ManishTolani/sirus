 <?php
    session_start();

	function objectToArray($d) {
		if(is_object($d)) {
			$d = get_object_vars($d);
		}
		if(is_array($d)) {
			return array_map(__FUNCTION__, $d); // recursive
		} else {
			return $d;
		}
	}

	$data = json_decode(file_get_contents("data.json", true));
	$data = objectToArray($data);

	array_push($data['successfull_uploads'], $data['ongoing_uploads'][1]);
	array_push($data['failed_uploads'], $data['ongoing_uploads'][2]);

	unset($data['ongoing_uploads'][2]);
	unset($data['ongoing_uploads'][1]);

	echo json_encode($data);
?>
