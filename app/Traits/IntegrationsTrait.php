<?php

namespace App\Traits;

trait IntegrationsTrait
{
    public function apiViaCep(string $cep)
    {
        // URL da API ViaCEP
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        // Retirar o "-" do CEP
        $cep = str_replace('-', '', $cep);

        // Abre a conexão curl
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Executar a consulta
        $response = curl_exec($curl);

        // Verificar se houve algum erro
        $error = curl_error($curl);
        $return = [];

        if ($error) {
            $return['error'] = $error;

            return $return;
        }

        $query = json_decode($response);

        if (isset($query->erro) && (!isset($query->cep))) {
            session()->set('blockCep', true);

            $return['error'] = '<span class="text-danger">Informe um CEP válido!</span>';

            return $return;
        }

        session()->set('blockCep', false);

        $return['logradouro'] = esc($query->logradouro);
        $return['bairro'] = esc($query->bairro);
        $return['cidade'] = esc($query->localidade);
        $return['uf'] = esc($query->uf);
        $return['cod_ibge'] = esc($query->ibge);

        return $return;
    }
}
