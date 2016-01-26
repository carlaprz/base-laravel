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
                $dataAux = FileServices::uploadFilebyRequest($file, $path, $key, $dimensions);

                $data[$key] = $dataAux["imageName"];
                $data[$key . "_showCrop"] = $dataAux["showCrop"];
                if ($dataAux["showCrop"] === true) {
                    $data["showCrop"][] = $key;
                }

                if ($key === 'image') {
                    $dataAux = FileServices::uploadFilebyRequest($file, $path, "thumb", $dimensions);
                    $data["thumb"] = $dataAux["imageName"];
                    if ($dataAux["showCrop"] === true) {
                        $data["showCrop"][] = "thumb";
                    }
                    unset($data['thumb_prev']);
                }

                unset($data[$key . '_prev']);
            }
        }

        // add file for lang
        foreach ($langs as $lang) {
            if (key_exists($lang->code, $files)) {
                foreach ($files[$lang->code] as $key => $file) {
                    if (isset($file)) {
                        $dataAux = FileServices::uploadFilebyRequest($file, $path . $lang->code, $key, $dimensions);
                        $data[$lang->code][$key] = $dataAux["imageName"];
                        if ($dataAux["showCrop"] === true) {
                            $data[$lang->code]["showCrop"][] = $key;
                        }
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
        $imageName = str_replace('.', '_' . $key . '.', $imageName);
        $data['imageName'] = $imageName;
        if ($ext == 'jpg' || $ext = 'png' || $ext == 'jepg') {
            if (isset($dimensions[$key])) {
                $image = Image::make($file->getRealPath());
                $data['showCrop'] = false;

                $w = $image->width();
                $h = $image->height();
                $realRelation = $w / $h;
                $dimensionsRelation = false;

                if (!empty($dimensions[$key]['w']) && !empty($dimensions[$key]['h'])) {
                    $dimensionsRelation = $dimensions[$key]['w'] / $dimensions[$key]['h'];
                } else if (!empty($dimensions[$key]['w'])) {
                    //si solo tengo defino el ancho.
                    $image->widen($dimensions[$key]['w']);
                }

                if ($dimensionsRelation != FALSE && $dimensionsRelation == $realRelation) {
                    //si tiene la misma proporcion le cambio el tamaño
                    $image->resize($dimensions[$key]['w'], $dimensions[$key]['h']);
                } else if ($dimensionsRelation != FALSE) {
                    $data['showCrop'] = true;
                }

                $image->save($uploadPath . $imageName);
            } else {
                $file->move($uploadPath, $imageName);
            }
        } else {
            $file->move($uploadPath, $imageName);
        }

        return $data;
    }

    static function flipImage( $imagePath )
    {
        $img = Image::make($imagePath);
        $img->flip('v');
        return $imagePath;
    }

    static function cropImage( $path, $data, $finalWidth )
    {
        $uploadPath = public_path($path);
        $imagen = Image::make($uploadPath . '/' . $data['name']);
        $imagen->crop($data['w'], $data['h'], $data['x'], $data['y']);
        $imagen->widen($finalWidth);
        $imagen->save($uploadPath . $data['name']);
    }

}
