<?php

namespace App\Core\Excel;

use Excel;

final class ExcelTransformator
{

    public function transform( array $data )
    {
        Excel::create(time(), function($excel) use ($data)
        {

            $excel->sheet('Pag. 1', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }

}
