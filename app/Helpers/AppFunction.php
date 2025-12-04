<?php

namespace App\Helpers;

class AppFunction{

    //* Menerima request tipe boolean dan mengconvertnya ke tinyInt
    public static function booleanRequest ($value)
    {
        if ($value == 'true' || $value == 1) {
            return 1;
        } else if ($value == 'false' || $value == 0){
            return 0;
        }
    }
    
    //* Memberi response boolean dari convert tinyInt
    public static function booleanResponse ($value)
    {
        if ($value == 1) {
            return true;
        } else if ($value == 0){
            return false;
        }
    }
    
    //* Menghitung umur
    public static function findAge ($bornDate)
    {
        if (is_null($bornDate)) {
            return null;
        }
        $currentDate = substr(now(), 0, 4);
        $bornDate = substr($bornDate, 0, 4);
        return $currentDate - $bornDate;
    }

    //* get image name
    public static function getImageName($image) {
        return time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
    }
    
    //* get image name
    public static function getFileName($file) {
        return time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
    }
}
