<?php

namespace App\Services;

use Image;
use Illuminate\Http\Request;

class FileServices
{

    static function uploadFilesRequest( Request $request, $data, $path, $dimensions = [] )
    {
        $langs = all_langs();
        $files = $request->files->all();

        //add file generals
        foreach ($files as $key => $file) {
            if (!is_array($file)) {
                $data[$key] = FileServices::uploadFilebyRequest($file, $path,  $key, $dimensions);
                unset($data[$key . '_prev']);
            }
        }

        // add file for lang
        foreach ($langs as $lang) {
            if (key_exists($lang->code, $files)) {
                foreach ($files[$lang->code] as $key => $file) {
                    if (isset($file)) {
                        
                        $data[$lang->code][$key] = FileServices::uploadFilebyRequest($file, $path .  $lang->code, $key, $dimensions);
                        unset($data[$lang->code][$key . '_prev']);
                    }
                }
            }
        }

        return $data;
    }

    static function uploadFilebyRequest( $file, $path, $key = false, $dimensions = [] )
    {
        $uploadPath = public_path($path);
        $ext = $file->getClientOriginalExtension();
        $ext = strtolower($ext);

        $imageName = str_replace(' ', '_', $file->getClientOriginalName());
        $imageName = strtolower($imageName);
        $imageName = str_replace('.', '_'.$key.'.', $imageName);

        if ($ext == 'jpg' || $ext = 'png' || $ext == 'jepg') {
            if (isset($dimensions[$key])) {
                $image = Image::make($file->getRealPath());
                if (isset($dimensions[$key]['w']) && $dimensions[$key]['w'] > 0) {
                    $image->widen($dimensions[$key]['w']);
                }

                if (isset($dimensions[$key]['h']) && $dimensions[$key]['h'] > 0) {
                    $image->resizeCanvas($dimensions[$key]['w'], $dimensions[$key]['h'], 'center', false, 'ffffff');
                }

                $image->save($uploadPath . $imageName);
            } else {
                $file->move($uploadPath, $imageName);
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
