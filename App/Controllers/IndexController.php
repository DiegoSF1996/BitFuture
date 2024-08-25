<?php
require 'Controller.php';

class IndexController extends Controller
{

    public function __construct()
    {
        Parent::__construct();
    }

    public function index()
    {
        $dados = $this->obterDados();
        $mayer_multiple = $this->calcularMayerMultiple($dados);

        $this->render('Index', ['mayer_multiple' => $mayer_multiple]);
    }

    public function calcularMayerMultiple($data)
    {
        try {

            $sum_prices = 0;
            foreach ($data as $day_data) {
                $sum_prices += $day_data['price_close'];
            }
            $moving_average = $sum_prices / count($data);
            $mayer_multiple = round($data[0]['price_close'] / $moving_average, 3);
            //return ['moving_average' => $moving_average, 'mayer_multiple' => $mayer_multiple];
            return $mayer_multiple;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function obterDados()
    {
        $dados_btcusdt = $this->obterDadosPorJsonFile();
        // print_r($dados_btcusdt); 
        if ($dados_btcusdt == false) {
            $dados_btcusdt = $this->obterDadosPorApi();
        }
        $this->salvarCotacaoJson($dados_btcusdt);
        return $dados_btcusdt;
    }
    function obterDadosPorJsonFile()
    {
        try {
            $dados_btcusdt = file_get_contents('App/Storage/btcusdt.json');
            $dados_btcusdt = json_decode($dados_btcusdt, true);
            if (is_array($dados_btcusdt) && count($dados_btcusdt) > 0) {
                return $dados_btcusdt;
            }
            return false;
        } catch (\Exception $e) {
            print_r($e);
            return false;
        }
    }
    function obterDadosPorApi()
    {
        try {
            $dados_btcusdt = file_get_contents('https://rest.coinapi.io/v1/ohlcv/BINANCE_SPOT_BTC_USDT/history?period_id=1DAY&limit=2&apikey=AFAE4C7D-4AB8-4FEF-A570-B0C05E83AD23');
            $dados_btcusdt =  json_decode($dados_btcusdt, true);
            if (is_array($dados_btcusdt) && count($dados_btcusdt) > 0) {
                return $dados_btcusdt;
            }
            return false;
        } catch (\Exception $e) {
            print_r($e);
            return false;
        }
    }

    public function salvarCotacaoJson($dados_btcusdt)
    {
        date_default_timezone_set('UTC');
        // Data e hora fornecida (em formato ISO 8601)
        $givenDate = $dados_btcusdt['time_close'];

        // Obter a hora atual
        $currentDateTime = new DateTime();

        // Converter a string de data fornecida para um objeto DateTime
        $givenDateTime = new DateTime($givenDate);
        if ($givenDateTime->modify('+15 minutes')  >= $currentDateTime) {
            //file_put_contents('App/Storage/btcusdt.json', json_encode($dados_btcusdt, JSON_PRETTY_PRINT));
            $file = fopen('App/Storage/btcusdt.json', 'w');
            fwrite($file, json_encode($dados_btcusdt, JSON_PRETTY_PRINT));
            fclose($file);
        }
    }
}
