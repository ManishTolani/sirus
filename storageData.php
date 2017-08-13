<?php
    function check_storage() {
        $final = array();

        $res = shell_exec("du /opt/lampp/htdocs/ltz/uploads/");
        $res_main = exec("df /");

        $res = preg_split('/\s+/', trim($res));
        $res_main = preg_split('/\s+/', trim($res_main));

        $result = array();
        for ($i=1; $i < count($res)-2 ; $i+=2) {
            $item = explode('/', $res[$i]);
            if($item[6] != '') {
                $result[$item[6]] = (int)($res[$i - 1]/1024);
            }
        }

        $final['upload_folder_size'] = (int)($res[$i-1]/1024);
        $final['folders'] = $result;

        $final['total_space'] = (int)(((int)$res_main[3] + (int)$res[$i-1])/1024);
        $final['free_space'] = (int)($res_main[3]/1024);

        $consumed = (($final['total_space'] - $final['free_space'])/$final['total_space']) * 100;
        $free = ($final['free_space']/$final['total_space']) * 100;

        $final['consumed'] = sprintf('%0.02f', $consumed);
        $final['free'] = sprintf('%0.02f', $free);

		$data = json_decode(file_get_contents("logs/data.json"), true);
        $data['storage'] = $final;

		$fh = fopen("logs/data.json", 'w') or die("Error opening output file");
		fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
		fclose($fh);

		return $final;
    }

	echo json_encode(check_storage());
?>
