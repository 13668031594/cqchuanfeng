<?php

namespace App\Vendor\Excel;

use Exception;

class ExcelException extends Exception
{
    public function render()
    {
        $error = parent::getMessage();
dd($error);
        return back()->withErrors([$error])->withInput();
    }
}
