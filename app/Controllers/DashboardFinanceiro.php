<?php
namespace App\Controllers;

use App\Models\ContaPagarModel;
use App\Models\FornecedorModel;
use App\Models\ContaReceberModel;
use App\Models\ClienteModel;

class DashboardFinanceiro extends BaseController 
{
    protected $contasPagarModel;
    protected $fornecedorModel;
    protected $contasReceberModel;
    protected $clienteModel;

    public function __construct()
    {
        $this->contasPagarModel = new ContaPagarModel();
        $this->fornecedorModel = new FornecedorModel();
        $this->contasReceberModel = new ContaReceberModel();
        $this->clienteModel = new ClienteModel();
    }

    private function obterResumoFinanceiro()
    {
        // Total de contas a pagar
        $totalContasPagar = $this->contasPagarModel
            ->withInactive()
            ->select('SUM(valor_total) as total_valor')
            ->first()->total_valor ?? 0;

        // Total de contas a receber
        $totalContasReceber = $this->contasReceberModel
            ->withInactive()
            ->select('SUM(valor_total) as total_valor')
            ->first()->total_valor ?? 0;
            
        // Total de contas pagas
        $totalContasPagas = $this->contasPagarModel
            ->where('status', 'PAGO')
            ->select('SUM(valor_total) as total_pago')
            ->first()->total_pago ?? 0;

        // Total de contas recebidas
        $totalContasRecebidas = $this->contasReceberModel
            ->where('status', 'RECEBIDO')
            ->select('SUM(valor_total) as total_pago')
            ->first()->total_pago ?? 0;
            
        // Contas a Pagar Pendentes
        $contasPagarPendentes = $this->contasPagarModel
            ->where('status', 'PENDENTE')
            ->countAllResults();

        // Contas a Receber Pendentes
        $contasReceberPendentes = $this->contasReceberModel
            ->where('status', 'PENDENTE')
            ->countAllResults();
            
        // Valor total de contas a pagar pendentes
        $valorContasPagarPendentes = $this->contasPagarModel
            ->where('status', 'PENDENTE')
            ->select('SUM(valor_total) as total_pendente')
            ->first()->total_pendente ?? 0;

        // Valor total de contas a receber pendentes
        $valorContasReceberPendentes = $this->contasReceberModel
            ->where('status', 'PENDENTE')
            ->select('SUM(valor_total) as total_pendente')
            ->first()->total_pendente ?? 0;
            
        // Contas a Pagar Atrasadas
        $contasPagarAtrasadas = $this->contasPagarModel
            ->where('status', 'ATRASADO')
            ->countAllResults();

        // Contas a Receber Atrasadas
        $contasReceberAtrasadas = $this->contasReceberModel
            ->where('status', 'ATRASADO')
            ->countAllResults();
            
        // Valor total de contas a pagar atrasadas
        $valorContasPagarAtrasadas = $this->contasPagarModel
            ->where('status', 'ATRASADO')
            ->select('SUM(valor_total) as total_atrasado')
            ->first()->total_atrasado ?? 0;

        // Valor total de contas a receber atrasadas
        $valorContasReceberAtrasadas = $this->contasReceberModel
            ->where('status', 'ATRASADO')
            ->select('SUM(valor_total) as total_atrasado')
            ->first()->total_atrasado ?? 0;
            
        // Percentual de contas pagas
        $percentualPago = $totalContasPagar > 0 
            ? round(($totalContasPagas / $totalContasPagar) * 100, 2) 
            : 0;

        // Percentual de contas recebidas
        $percentualRecebido = $totalContasReceber > 0 
            ? round(($totalContasRecebidas / $totalContasReceber) * 100, 2) 
            : 0;
            
        // Percentual de contas a pagar pendentes
        $percentualPagarPendente = $totalContasPagar > 0 
            ? round(($valorContasPagarPendentes / $totalContasPagar) * 100, 2) 
            : 0;

        // Percentual de contas a receber pendentes
        $percentualReceberPendente = $totalContasReceber > 0 
            ? round(($valorContasReceberPendentes / $totalContasReceber) * 100, 2) 
            : 0;
            
        // Percentual de contas a pagar atrasadas
        $percentualPagarAtrasado = $totalContasPagar > 0 
            ? round(($valorContasPagarAtrasadas / $totalContasPagar) * 100, 2) 
            : 0;
            
        // Percentual de contas a receber atrasadas
        $percentualReceberAtrasado = $totalContasReceber > 0 
            ? round(($valorContasReceberAtrasadas / $totalContasReceber) * 100, 2) 
            : 0;
    
        return [
            'total_contas_pagar' => $this->contasPagarModel->withInactive()->countAllResults(),
            'valor_total_contas_pagar' => $totalContasPagar,
            'valor_total_pago' => $totalContasPagas,
            'percentual_total_contas_pagar' => 100,                 // Sempre 100%
            'percentual_contas_pagas' => $percentualPago,           // Percentual real de contas pagas
            'contas_pagar_pendentes' => $contasPagarPendentes,
            'valor_contas_pagar_pendentes' => $valorContasPagarPendentes,
            'percentual_contas_pagar_pendentes' => $percentualPagarPendente,
            'contas_pagar_atrasadas' => $contasPagarAtrasadas,
            'valor_contas_pagar_atrasadas' => $valorContasPagarAtrasadas,
            'percentual_contas_pagar_atrasadas' => $percentualPagarAtrasado,

            'total_contas_receber' => $this->contasReceberModel->withInactive()->countAllResults(),
            'valor_total_contas_receber' => $totalContasReceber,
            'valor_total_recebido' => $totalContasRecebidas,
            'percentual_total_contas_receber' => 100,               // Sempre 100%
            'percentual_contas_recebidas' => $percentualRecebido,   // Percentual real de contas pagas
            'contas_receber_pendentes' => $contasReceberPendentes,
            'valor_contas_receber_pendentes' => $valorContasReceberPendentes,
            'percentual_contas_receber_pendentes' => $percentualReceberPendente,
            'contas_receber_atrasadas' => $contasReceberAtrasadas,
            'valor_contas_receber_atrasadas' => $valorContasReceberAtrasadas,
            'percentual_contas_receber_atrasadas' => $percentualReceberAtrasado,
        ];
    }

    private function gerarGraficosContasPagar()
    {
        // Total de contas a pagar
        $totalContasPagar = $this->contasPagarModel
            ->withInactive()
            ->select('SUM(valor_total) as total_valor')
            ->first()->total_valor ?? 0;
    
        // Gráfico de status de contas a pagar com percentuais calculados
        $statusContasPagar = $this->contasPagarModel
            ->withInactive()
            ->select('status, SUM(valor_total) as total_valor')
            ->groupBy('status')
            ->findAll();
    
        // Converter para array simples com percentuais
        $statusContasPagarArray = array_map(function($item) use ($totalContasPagar) {
            $valorStatusPagar = is_object($item) ? $item->total_valor : $item['total_valor'];
            $percentualPagar = $totalContasPagar > 0 
                ? round(($valorStatusPagar / $totalContasPagar) * 100, 2) 
                : 0;
    
            return [
                'status' => is_object($item) ? $item->status : $item['status'],
                'total' => $valorStatusPagar,
                'percentual' => $percentualPagar
            ];
        }, $statusContasPagar);
    
        // Se não houver dados, criar um conjunto padrão
        if (empty($statusContasPagarArray)) {
            $statusContasPagarArray = [
                ['status' => 'Sem Dados', 'total' => 0, 'percentual' => 100]
            ];
        }
    
        // Gráfico de contas a pagar por fornecedor
        $contasPagarPorFornecedor = $this->contasPagarModel
            ->withInactive()
            ->select('fornecedores.nome_fantasia, SUM(valor_total) as total_valor')
            ->join('fornecedores', 'fornecedores.id = contas_pagar.fornecedor_id')
            ->groupBy('fornecedores.id')
            ->orderBy('total_valor', 'DESC')
            //->limit(5)
            ->findAll();
    
        // Converter para array simples
        $contasPagarPorFornecedorArray = array_map(function($item) {
            return [
                'nome_fantasia' => is_object($item) ? $item->nome_fantasia : $item['nome_fantasia'],
                'total_contas' => is_object($item) ? $item->total_valor : $item['total_valor']
            ];
        }, $contasPagarPorFornecedor);
    
        // Se não houver dados de fornecedores, criar um conjunto padrão
        if (empty($contasPagarPorFornecedorArray)) {
            $contasPagarPorFornecedorArray = [
                ['nome_fantasia' => 'Sem Dados', 'total_contas' => 1]
            ];
        }
    
        return [
            'status_contas_pagar' => $statusContasPagarArray,
            'contas_pagar_por_fornecedor' => $contasPagarPorFornecedorArray
        ];
    }

    private function gerarGraficosContasReceber()
    {
        // Total de contas a receber
        $totalContasReceber = $this->contasReceberModel
            ->withInactive()
            ->select('SUM(valor_total) as total_valor')
            ->first()->total_valor ?? 0;
    
        // Gráfico de status de contas a receber com percentuais calculados
        $statusContasReceber = $this->contasReceberModel
            ->withInactive()
            ->select('status, SUM(valor_total) as total_valor')
            ->groupBy('status')
            ->findAll();
    
        // Converter para array simples com percentuais
        $statusContasReceberArray = array_map(function($item) use ($totalContasReceber) {
            $valorStatusReceber = is_object($item) ? $item->total_valor : $item['total_valor'];
            $percentualReceber = $totalContasReceber > 0 
                ? round(($valorStatusReceber / $totalContasReceber) * 100, 2) 
                : 0;
    
            return [
                'status' => is_object($item) ? $item->status : $item['status'],
                'total' => $valorStatusReceber,
                'percentual' => $percentualReceber
            ];
        }, $statusContasReceber);
    
        // Se não houver dados, criar um conjunto padrão
        if (empty($statusContasReceberArray)) {
            $statusContasReceberArray = [
                ['status' => 'Sem Dados', 'total' => 0, 'percentual' => 100]
            ];
        }
    
        // Gráfico de contas a receber por cliente
        $contasReceberPorCliente = $this->contasReceberModel
            ->withInactive()
            ->select('clientes.nome_fantasia, SUM(valor_total) as total_valor')
            ->join('clientes', 'clientes.id = contas_receber.cliente_id')
            ->groupBy('clientes.id')
            ->orderBy('total_valor', 'DESC')
            //->limit(5)
            ->findAll();
    
        // Converter para array simples
        $contasReceberPorClienteArray = array_map(function($item) {
            return [
                'nome_fantasia' => is_object($item) ? $item->nome_fantasia : $item['nome_fantasia'],
                'total_contas' => is_object($item) ? $item->total_valor : $item['total_valor']
            ];
        }, $contasReceberPorCliente);
    
        // Se não houver dados de clientes, criar um conjunto padrão
        if (empty($contasReceberPorClienteArray)) {
            $contasReceberPorClienteArray = [
                ['nome_fantasia' => 'Sem Dados', 'total_contas' => 1]
            ];
        }
    
        return [
            'status_contas_receber' => $statusContasReceberArray,
            'contas_receber_por_cliente' => $contasReceberPorClienteArray,
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
        return $this->contasReceberModel
            ->where('data_vencimento >=', $dataInicio)
            ->where('data_vencimento <=', $dataFim)
            ->select('SUM(valor_total) as total_entradas')
            ->first()->total_entradas ?? 0;
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
            'RECEBIDO' => '#28a745',     // text-success
            'CANCELADO' => '#007bff',    // text-primary
            'ATRASADO' => '#dc3545'      // text-danger
        ];

        $data = [
            'title' => 'Home',
            'resumoFinanceiro' => $this->obterResumoFinanceiro(),
            'graficosContasPagar' => $this->gerarGraficosContasPagar(),
            'graficosContasReceber' => $this->gerarGraficosContasReceber(),
            'previsioesCaixa' => $this->calcularPrevisioesCaixa(),
            'alertasFinanceiros' => $this->gerarAlertasFinanceiros(),
            'statusColors' => $statusColors  // Adicionar mapeamento de cores
        ];

        return view('mentor/dashboards/finance', $data);
    }
}