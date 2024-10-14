<?php

namespace App\Extensions;

use Illuminate\Support\Facades\File;

class FileHelper
{
    protected $publicPath;

    public function __construct() {
        $this->publicPath = public_path();
    }

 	public function getBase64($fileName)
 	{
        $filePath = $this->publicPath . '/' . $fileName;
        $filetype = pathinfo($filePath, PATHINFO_EXTENSION);
        
        if ($filetype==='svg'){
            $filetype .= '+xml';
        }

        $image = File::get($filePath);
        return 'data:image/' . $filetype . ';base64,' . base64_encode($image);	
    }
}
