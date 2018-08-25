<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public static function corrigirValor($valor)
    {
        if (substr_count($valor, '.') > 0) {
            return str_replace('.', ',', $valor);
        } elseif (substr_count($valor, ',') == 0) {
            return floatval(str_replace(',', '.', $valor));
        } else{
            return $valor.',00';
        }
    }
}
