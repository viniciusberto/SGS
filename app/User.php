<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{   
    use HasApiTokens, Notifiable;
    const TIPO_ADMIN = 1;
    const TIPO_TECNICO = 2;
    const TIPO_SOLICITANTE = 3;
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'tipo', 'empresa','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function verificarTipo($tipo){
        switch ($tipo) {
            case User::TIPO_ADMIN:
            return "Administrador";
            break;

            case User::TIPO_TECNICO:
            return "Técnico";
            break;

            case User::TIPO_SOLICITANTE:
            return "Solicitante";
            break;

            case "Administrador":
            return User::TIPO_ADMIN;
            break;

            case "Técnico":
            return User::TIPO_TECNICO;
            break;

            case "Solicitante":
            return User::TIPO_SOLICITANTE;
            break;
        }
    }
}
