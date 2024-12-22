<?php

function formatDateTime(string $date = null)
{
    if ($date == null)
        return '';

    $dia = date('d', strtotime($date));
    $mes = date('m', strtotime($date));
    $ano = date('Y', strtotime($date));
    $hora = date('H:i', strtotime($date));

    if ($ano == '-0001')
        return '';
    else
        return $dia . '/' . $mes . '/' . $ano . ' ' . $hora;
}

function formatDate(string $date = null)
{
    if ($date == null)
        return '';

    $dia = date('d', strtotime($date));
    $mes = date('m', strtotime($date));
    $ano = date('Y', strtotime($date));

    if ($ano == '-0001')
        return '';
    else
        return $dia . '/' . $mes . '/' . $ano;
}

function formatCurrency(float $value = null, bool $simbol = true)
{
    if ($value == null) {
        $value = 0;
    }

    if ($simbol) {
        return "R$ " . number_format($value, 2, ',', '.');
    } else {
        return number_format($value, 2, ',', '.');
    }
}

function formatPercent(float $value = null, bool $simbol = true, int $dec = 2)
{
    if ($value == null) {
        $value = 0;
    }

    if ($simbol) {
        return number_format($value, $dec, ',', '.') . "%";
    } else {
        return number_format($value, $dec, ',', '.');
    }
}

function setTipoEndereco(string $tipo)
{
    if ($tipo == 'R') {
        return 'Residencial';
    } elseif ($tipo == 'C') {
        return 'Comercial';
    } elseif ($tipo == 'F') {
        return 'Cobrança';
    } elseif ($tipo == 'E') {
        return 'Entrega';
    } else {
        return '';
    }
}

function setTipoMovimento(string $tipo)
{
    if ($tipo == 'E') {
        return 'Entrada';
    } elseif ($tipo == 'S') {
        return 'Saída';
    } elseif ($tipo == 'T') {
        return 'Transferência';
    } else {
        return '';
    }
}

function convertDecimal($valor)
{
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);

    return $valor;
}

function formatCnpjCpf($value)
{
    $cnpj_cpf = preg_replace("/\D/", '', $value);

    if (strstr($value, "+") == TRUE) {
        return "";
    }

    if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    }

    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}
