<?php

namespace App\Services;

use Image;
use Illuminate\Http\Request;

class FileServices
{

    static function uploadFilesRequest( Request $request, $data, $path )
    {
        $langs = all_langs();
        $files = $request->files->all();
        $dataFiles = [];

        // add file for lang
        foreach ($langs as $lang) {
            if (key_exists($lang->code, $files)) {
                foreach ($files[$lang->code] as $key => $file) {
                    if (isset($file)) {
                        $dataFiles[$lang->code][$key] = FileServices::uploadFilebyRequest($file, $path, $lang->code);
                    }
                }
            }
        }

        //add file generals
        foreach ($files as $key => $file) {
            $found = false;
            foreach ($langs as $lang) {

                if ($lang->code == $key) {
                    $found = true;
                }
            }

            if (!$found) {
                $data[$key] = FileServices::uploadFilebyRequest($file, $path);
            }
        }

        // unificando data
        foreach ($langs as $lang) {
            if (key_exists($lang->code, $data)) {
                foreach ($data[$lang->code] as $key => $value) {
                    if (!empty($dataFiles[$lang->code][$key])) {
                        $data[$lang->code][$key] = $dataFiles[$lang->code][$key];
                    } else {
                        if (empty($value)) {
                            unset($data[$lang->code][$key]);
                        }
                    }
                }
            }
        }

        return $data;
    }

    static function uploadFilebyRequest( $file, $path, $lang = false )
    {
        $path = !empty($lang) ? $path . $lang : $path;
        $uploadPath = public_path($path);
        $ext = $file->getClientOriginalExtension();
        $ext = strtolower($ext);

        $imageName = str_replace(' ', '_', $file->getClientOriginalName());
        $imageName = strtolower($imageName);

        if ($ext == 'jpg' || $ext = 'png' || $ext == 'jepg') {
            if ($path == 'files/products/') {
                $image = Image::make($file->getRealPath());
                $image->widen(564)->resizeCanvas(564, 384, 'center', false, 'ffffff')->save($path . $imageName);
            } else if ($path == 'files/news/') {
                $image = Image::make($file->getRealPath());
                $image->widen(640)->resizeCanvas(640, 581, 'center', false, 'ffffff')->save($path . $imageName);
            }
        } else {
            $file->move($uploadPath, $imageName);
        }

        return $imageName;
    }

    static function flipImage( $imagePath )
    {
        // create Image from file
        $img = Image::make($imagePath);
        // flip image vertically
        $img->flip('v');
        return $imagePath;
    }

}
