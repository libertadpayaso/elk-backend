<?php

namespace App\Extensions;

class FileHelper
{
    protected $contextOptions = [];

    public function __construct() {
        if (env("APP_ENV") != 'prod') {
            $this->contextOptions = [
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ],
            ];  
        }
    }

 	public function getBase64($filePath)
 	{
        $filetype = pathinfo($filePath, PATHINFO_EXTENSION);
        
        if ($filetype==='svg'){
            $filetype .= '+xml';
        }

        $image = file_get_contents($filePath, false, stream_context_create($this->contextOptions));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($image);	
    }
}
