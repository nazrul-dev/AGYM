<?php

use Carbon\Carbon;

function type_trans($value){
        if($value == 'new_member'){
            return 'Member Baru';
        }
        if($value == 'renew_member'){
            return 'Perpanjangan';
        }
        if($value == 'sale'){
            return 'Penjualan';
        }
        if($value == 'rent'){
            return 'Sewa Gym';
        }
        if($value == 'cashin'){
            return 'Kas Masuk';
        }

        if($value == 'cashout'){
            return 'Kas Keluar';
        }
    }
    function check_member_active($date){
        if(Carbon::now() <= $date){
            return 'Aktif';
        }

        return 'Non Aktif';
    }


    function changeLangStock($value){
        if($value == 'warehouse'){
            return ' Gudang';
        }

        if($value == 'store'){
            return 'Toko';
        }
    }

    function formTypeLang($value){
        if($value == 'add'){
            return ' Tambah';
        }

        if($value == 'edit'){
            return 'Ubah';
        }

        return $value;
    }

    function checkCharge($total,$amount){
        if($amount > $total){
            return $amount - $total;
        }

        return  $total - $amount;
    }

    function codeRandom($length = 16)
    {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
?>
