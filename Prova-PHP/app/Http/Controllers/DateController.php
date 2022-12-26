<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function home()
    {
        $date = $this->dateManipulation();
        return view('date', compact('date'));
    }

    public function dateManipulation()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $today = Carbon::now()->settings(['locale' => 'pt_BR']);
        //$today = Carbon::create('2022/04/21')->settings(['locale' => 'pt_BR']); //adicionar data para teste

        $todayDia = $today->isoFormat('YYYY/MM/DD');

        /*
        Datas de feriados que o sistema aceita:
        "Confraternização Universal" => "2022/01/01"
        "Tiradentes" => "2022/04/21"
        "Dia do Trabalhador" => "2022/05/01"
        "Dia da Independência" => "2022/09/07"
        "N. S. Aparecida" => "2022/10/12"
        "Todos os santos" => "2022/11/02"
        "Proclamação da republica" => "2022/11/15"
        "Natal" => "2022/12/25"
        "3ºferia Carnaval" => "2022/03/01"
        "6ºfeira Santa" => "2022/04/15"
        "Pascoa" => "2022/04/17"
        "Corpus Cirist" => "2022/06/16"*/

        $diaDaSemana = $today->isoFormat('dddd D');


        $feriados = $this->dias_feriados();

        foreach ($feriados as $key => $value) {
            if ($value == $todayDia) {
                $keyFeriado = $key;
            }
        }

        if(empty($keyFeriado)){
            $nomeFeriado = "Essa data Não tem Feriado";
        }else{
            $nomeFeriado = $keyFeriado;
        }


        $result = $todayDia . " - " . $diaDaSemana . "  -  " . $nomeFeriado;

        return $result;
    }

    function dias_feriados($ano = null)
    {
        if (empty($ano)) {
            $ano = intval(date('Y'));
        }

        $pascoa = easter_date($ano); // Limite de 1970 ou após 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
        $dia_pascoa = date('j', $pascoa);
        $mes_pascoa = date('n', $pascoa);
        $ano_pascoa = date('Y', $pascoa);

        $feriados = array(
            // Tatas Fixas dos feriados Nacionail Basileiras
           "Confraternização Universal"    => \Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 1, 1, $ano))->isoFormat('YYYY/MM/DD'), // Confraternização Universal - Lei nº 662, de 06/04/49
           "Tiradentes"    => \Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 4, 21, $ano))->isoFormat('YYYY/MM/DD'), // Tiradentes - Lei nº 662, de 06/04/49
           "Dia do Trabalhador"    =>\Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 5, 1, $ano))->isoFormat('YYYY/MM/DD'), // Dia do Trabalhador - Lei nº 662, de 06/04/49
           "Dia da Independência"    => \Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 9, 7, $ano))->isoFormat('YYYY/MM/DD'), // Dia da Independência - Lei nº 662, de 06/04/49
           "N. S. Aparecida"    =>\Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 10, 12, $ano))->isoFormat('YYYY/MM/DD'), // N. S. Aparecida - Lei nº 6802, de 30/06/80
           "Todos os santos"    =>\Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 11, 2, $ano))->isoFormat('YYYY/MM/DD'), // Todos os santos - Lei nº 662, de 06/04/49
           "Proclamação da republica"    => \Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 11, 15, $ano))->isoFormat('YYYY/MM/DD'), // Proclamação da republica - Lei nº 662, de 06/04/49
           "Natal"    => \Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, 12, 25, $ano))->isoFormat('YYYY/MM/DD'), // Natal - Lei nº 662, de 06/04/49

            // Essas Datas depem diretamente da data de Pascoa
            // mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48, $ano_pascoa), //2ºferia Carnaval
            "3ºferia Carnaval"    => \Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47, $ano_pascoa))->isoFormat('YYYY/MM/DD'), //3ºferia Carnaval
            "6ºfeira Santa"    => \Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2, $ano_pascoa))->isoFormat('YYYY/MM/DD'), //6ºfeira Santa
            "Pascoa"    =>\Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, $mes_pascoa, $dia_pascoa, $ano_pascoa))->isoFormat('YYYY/MM/DD'), //Pascoa
            "Corpus Cirist"    =>\Carbon\Carbon::createFromTimestamp(mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60, $ano_pascoa))->isoFormat('YYYY/MM/DD'), //Corpus Cirist

        );


        return $feriados;
    }

}
