<?php
namespace App\Controllers;

use App\Models\ContaPagarModel;
use App\Models\FornecedorModel;

class DashboardFinanceiro extends BaseController 
{
    protected $contasPagarModel;
    protected $fornecedorModel;

    public function __construct()
    {
        $this->contasPagarModel = new ContaPagarModel();
        $this->fornecedorModel = new FornecedorModel();
    }

    private function obterResumoFinanceiro()
    {
        // Total de contas a pagar
        $totalContasPagar = $this->contasPagarModel
            ->withInactive()
            ->select('SUM(valor_total) as total_valor')
            ->first()->total_valor ?? 0;
    
        // Total de contas pagas
        $totalContasPagas = $this->contasPagarModel
            ->where('status', 'PAGO')
            ->select('SUM(valor_total) as total_pago')
            ->first()->total_pago ?? 0;
    
        // Contas Pendentes
        $contasPendentes = $this->contasPagarModel
            ->where('status', 'PENDENTE')
            ->countAllResults();
    
        // Valor total de contas pendentes
        $valorContasPendentes = $this->contasPagarModel
            ->where('status', 'PENDENTE')
            ->select('SUM(valor_total) as total_pendente')
            ->first()->total_pendente ?? 0;
    
        // Contas Atrasadas
        $contasAtrasadas = $this->contasPagarModel
            ->where('status', 'ATRASADO')
            ->countAllResults();
    
        // Valor total de contas atrasadas
        $valorContasAtrasadas = $this->contasPagarModel
            ->where('status', 'ATRASADO')
            ->select('SUM(valor_total) as total_atrasado')
            ->first()->total_atrasado ?? 0;
    
        // Percentual de contas pagas
        $percentualPago = $totalContasPagar > 0 
            ? round(($totalContasPagas / $totalContasPagar) * 100, 2) 
            : 0;
    
        // Percentual de contas pendentes
        $percentualPendente = $totalContasPagar > 0 
            ? round(($valorContasPendentes / $totalContasPagar) * 100, 2) 
            : 0;
    
        // Percentual de contas atrasadas
        $percentualAtrasado = $totalContasPagar > 0 
            ? round(($valorContasAtrasadas / $totalContasPagar) * 100, 2) 
            : 0;
    
        return [
            'total_contas_pagar' => $this->contasPagarModel->withInactive()->countAllResults(),
            'valor_total_contas_pagar' => $totalContasPagar,
            'valor_total_pago' => $totalContasPagas,
            'percentual_total_contas_pagar' => 100,         // Sempre 100%
            'percentual_contas_pagas' => $percentualPago,   // Percentual real de contas pagas
            'contas_pendentes' => $contasPendentes,
            'valor_contas_pendentes' => $valorContasPendentes,
            'percentual_contas_pendentes' => $percentualPendente,
            'contas_atrasadas' => $contasAtrasadas,
            'valor_contas_atrasadas' => $valorContasAtrasadas,
            'percentual_contas_atrasadas' => $percentualAtrasado
        ];
    }
    /*
    private function gerarGraficosContas()
    {
        // Gráfico de status de contas
        $statusContas = $this->contasPagarModel
            ->withInactive()
            ->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->findAll();
    
        // Converter para array simples
        $statusContasArray = array_map(function($item) {
            return [
                'status' => is_object($item) ? $item->status : $item['status'],
                'total' => is_object($item) ? $item->total : $item['total']
            ];
        }, $statusContas);
    
        // Se não houver dados, criar um conjunto padrão
        if (empty($statusContasArray)) {
            $statusContasArray = [
                ['status' => 'Sem Dados', 'total' => 1]
            ];
        }
    
        // Gráfico de contas por fornecedor
        $contasPorFornecedor = $this->contasPagarModel
            ->withInactive()
            ->select('fornecedores.nome_fantasia, COUNT(*) as total_contas')
            ->join('fornecedores', 'fornecedores.id = contas_pagar.fornecedor_id')
            ->groupBy('fornecedores.id')
            ->orderBy('total_contas', 'DESC')
            ->limit(5)
            ->findAll();
    
        // Converter para array simples
        $contasPorFornecedorArray = array_map(function($item) {
            return [
                'nome_fantasia' => is_object($item) ? $item->nome_fantasia : $item['nome_fantasia'],
                'total_contas' => is_object($item) ? $item->total_contas : $item['total_contas']
            ];
        }, $contasPorFornecedor);
    
        // Se não houver dados de fornecedores, criar um conjunto padrão
        if (empty($contasPorFornecedorArray)) {
            $contasPorFornecedorArray = [
                ['nome_fantasia' => 'Sem Dados', 'total_contas' => 1]
            ];
        }
    
        return [
            'status_contas' => $statusContasArray,
            'contas_por_fornecedor' => $contasPorFornecedorArray
        ];
    }
    */
    private function gerarGraficosContas()
    {
        // Total de contas a pagar
        $totalContasPagar = $this->contasPagarModel
            ->withInactive()
            ->select('SUM(valor_total) as total_valor')
            ->first()->total_valor ?? 0;
    
        // Gráfico de status de contas com percentuais calculados
        $statusContas = $this->contasPagarModel
            ->withInactive()
            ->select('status, SUM(valor_total) as total_valor')
            ->groupBy('status')
            ->findAll();
    
        // Converter para array simples com percentuais
        $statusContasArray = array_map(function($item) use ($totalContasPagar) {
            $valorStatus = is_object($item) ? $item->total_valor : $item['total_valor'];
            $percentual = $totalContasPagar > 0 
                ? round(($valorStatus / $totalContasPagar) * 100, 2) 
                : 0;
    
            return [
                'status' => is_object($item) ? $item->status : $item['status'],
                'total' => $valorStatus,
                'percentual' => $percentual
            ];
        }, $statusContas);
    
        // Se não houver dados, criar um conjunto padrão
        if (empty($statusContasArray)) {
            $statusContasArray = [
                ['status' => 'Sem Dados', 'total' => 1, 'percentual' => 100]
            ];
        }
    
        // Gráfico de contas por fornecedor
        $contasPorFornecedor = $this->contasPagarModel
            ->withInactive()
            ->select('fornecedores.nome_fantasia, SUM(valor_total) as total_valor')
            ->join('fornecedores', 'fornecedores.id = contas_pagar.fornecedor_id')
            ->groupBy('fornecedores.id')
            ->orderBy('total_valor', 'DESC')
            ->limit(5)
            ->findAll();
    
        // Converter para array simples
        $contasPorFornecedorArray = array_map(function($item) {
            return [
                'nome_fantasia' => is_object($item) ? $item->nome_fantasia : $item['nome_fantasia'],
                'total_contas' => is_object($item) ? $item->total_valor : $item['total_valor']
            ];
        }, $contasPorFornecedor);
    
        // Se não houver dados de fornecedores, criar um conjunto padrão
        if (empty($contasPorFornecedorArray)) {
            $contasPorFornecedorArray = [
                ['nome_fantasia' => 'Sem Dados', 'total_contas' => 1]
            ];
        }
    
        return [
            'status_contas' => $statusContasArray,
            'contas_por_fornecedor' => $contasPorFornecedorArray
        ];
    }

    private function calcularPrevisioesCaixa()
    {
        $dataInicio = date('Y-m-01');
        $dataFim = date('Y-m-t');

        return [
            'previsao_entrada' => $this->calcularPrevisoesEntrada($dataInicio, $dataFim),
            'previsao_saida' => $this->calcularPrevissoesSaida($dataInicio, $dataFim)
        ];
    }

    private function gerarAlertasFinanceiros()
    {
        return [
            'contas_vencendo' => $this->contasPagarModel
                ->where('status', 'PENDENTE')
                ->where('data_vencimento <=', date('Y-m-d', strtotime('+7 days')))
                ->findAll(),
            
            'contas_atrasadas' => $this->contasPagarModel
                ->where('status', 'ATRASADO')
                ->findAll()
        ];
    }

    private function calcularPrevisoesEntrada($dataInicio, $dataFim)
    {
        // Implementação futura para contas a receber
        return 0;
    }

    private function calcularPrevissoesSaida($dataInicio, $dataFim)
    {
        return $this->contasPagarModel
            ->where('data_vencimento >=', $dataInicio)
            ->where('data_vencimento <=', $dataFim)
            ->select('SUM(valor_total) as total_saidas')
            ->first()->total_saidas ?? 0;
    }

    public function index()
    {
        // Mapeamento de status válidos
        $statusColors = [
            'PENDENTE' => '#ffc107',     // text-warning
            'PARCIAL' => '#17a2b8',      // text-info
            'PAGO' => '#28a745',         // text-success
            'CANCELADO' => '#007bff',    // text-primary
            'ATRASADO' => '#dc3545'      // text-danger
        ];

        $data = [
            'title' => 'Home',
            'resumoFinanceiro' => $this->obterResumoFinanceiro(),
            'graficosContas' => $this->gerarGraficosContas(),
            'previsioesCaixa' => $this->calcularPrevisioesCaixa(),
            'alertasFinanceiros' => $this->gerarAlertasFinanceiros(),
            'statusColors' => $statusColors  // Adicionar mapeamento de cores
        ];

        return view('mentor/dashboards/finance', $data);
    }
}