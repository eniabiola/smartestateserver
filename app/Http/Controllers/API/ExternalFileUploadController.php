<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ExternalFileUploadController extends Controller
{

    public function iterate_dir($path)
    {
        $files = [];
        if (is_dir($path) & is_readable($path)) {
            $dir = dir($path);
            while (false !== ($file = $dir->read())) {
                // skip . and ..
                if (('.' == $file) || ('..' == $file)) {
                    continue;
                }
                if (is_dir("$path/$file")) {
                    $files = array_merge($files, iterate_dir("$path/$file"));
                } else {
                    $files[] = $file;
                }
            }
            $dir->close();
        }
        return $files;
    }

    public function callFolderIteration(Request $request)
    {
//        return $this->iterate_dir("/Users/pc/Sites/edms-backend/app/http/Controllers/Api/");
        $files = [];
        $folder_structure = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('/Users/pc/Sites/edms-backend/app/http/Controllers/Api/'));
        foreach ($iterator as $file) {
            if ($file->isDir()) continue;
            $files[] = $file->getFilename();
            $folder_structure[] = $file->getPathname();
        }
        return ['files' => $files, 'folders'  => $folder_structure];
    }
}
