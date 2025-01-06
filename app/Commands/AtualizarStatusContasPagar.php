<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\ContaPagarModel;

class AtualizarStatusContasPagar extends BaseCommand
{
    protected $group       = 'Financeiro';
    protected $name        = 'contas:atualizar-status';
    protected $description = 'Atualiza o status das contas a pagar vencidas';

    public function run(array $params)
    {
        $contaPagarModel = new ContaPagarModel();

        // Buscar contas pendentes com data de vencimento menor que a data atual
        $contasParaAtualizar = $contaPagarModel
            ->where('status', 'PENDENTE')
            ->where('data_vencimento <', date('Y-m-d'))
            ->findAll();

        $totalAtualizadas = 0;

        foreach ($contasParaAtualizar as $conta) {
            // Atualizar status para ATRASADO usando o ID da entidade
            $contaPagarModel->update($conta->id, [
                'status' => 'ATRASADO'
            ]);
            $totalAtualizadas++;
        }

        // Log de atualização
        log_message('info', "Contas a pagar atualizadas para status ATRASADO: {$totalAtualizadas}");

        // Saída no console
        CLI::write("Total de contas atualizadas para ATRASADO: {$totalAtualizadas}", 'green');
    }
}