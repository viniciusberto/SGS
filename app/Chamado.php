<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Chamado extends Model
{
    const STATUS_ANALISE = 1;
    const STATUS_ABERTO = 2;
    const STATUS_ANALISE_ACEITACAO = 3;
    const STATUS_ACEITO = 4;
    const STATUS_ATENDIMENTO = 5;
    const STATUS_ANALISE_FECHAMENTO = 6;
    const STATUS_FECHADO = 7;

    public static function verificarStatus($sts)
    {
        switch ($sts) {
            case Chamado::STATUS_ANALISE:
                return "Analise";
                break;

            case Chamado::STATUS_ABERTO:
                return "Aberto";
                break;

            case Chamado::STATUS_ACEITO:
                return "Aceito";
                break;

            case Chamado::STATUS_FECHADO:
                return "Fechado";
                break;

            case Chamado::STATUS_ANALISE_ACEITACAO:
                return "Analise Aceitação";
                break;

            case Chamado::STATUS_ANALISE_FECHAMENTO:
                return "Analise Fechamento";
                break;

            case Chamado::STATUS_ATENDIMENTO:
                return "Em atendimento";
                break;


            case "Analise":
                return Chamado::STATUS_ANALISE;
                break;

            case "Aberto":
                return Chamado::STATUS_ABERTO;
                break;

            case "Aceito":
                return Chamado::STATUS_ACEITO;
                break;

            case "Fechado":
                return Chamado::STATUS_FECHADO;
                break;

            case "Analise Aceitação":
                return Chamado::STATUS_ANALISE_ACEITACAO;
                break;

            case "Analise Fechamento":
                return Chamado::STATUS_ANALISE_FECHAMENTO;
                break;

            case "Em atendimento":
                return Chamado::STATUS_ATENDIMENTO;
                break;
        }
    }
}
