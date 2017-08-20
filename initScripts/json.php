<?php
    function init() {
        $json_data = Array (
            "total_users" => 1,
            "users_online" => 0,
			"total_uploads" => 0,
            "total_downloads" => 0,
            "new_upload_requests" => 0,
            "accepted_requests" => 0,
            "rejected_requests" => 0,
			"ongoing_uploads_count" => 0,
			"ongoing_downloads_count" => 0,
			"ongoing_uploads" => Array(),
			"done_uploads" => Array(),
			"failed_uploads" => Array(),
			"ongoing_downloads" => Array(),
			"done_downloads" => Array(),
			"Failed_downloads" => Array(),
			"storage" => Array(
                "upload_folder_size" => 0,
                "folders" => Array(
                    "image" => 0,
                    "music" => 0,
                    "movies" => 0,
                    "software" => 0,
                    "studies" => 0,
                    "tutorial" => 0,
                    "videos" => 0
                ),
                "total_space" => 0,
                "free_space" => 0,
                "consumed" => 0,
                "free" => 0
            ),

        );

        $json = json_encode($json_data);
        if (file_put_contents("../logs/data.json", $json))
            echo $json;
        else
            echo "Oops! Error creating json file...\n";
    }

    init();
?>
