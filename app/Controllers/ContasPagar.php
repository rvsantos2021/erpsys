<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ContaPagarModel;
use App\Models\FornecedorModel;
use App\Models\ClassificacaoContaModel;
use App\Models\FormaPagamentoModel;
use App\Models\ContaCorrenteModel;
use App\Models\LancamentoFinanceiroModel;

class ContasPagar extends BaseController
{
    protected $db;
    protected $contaPagarModel;
    protected $fornecedorModel;
    protected $classificacaoContaModel;
    protected $formaPagamentoModel;
    protected $contaCorrenteModel;
    protected $lancamentoFinanceiroModel;

    private $viewFolder = '/mentor/financeiro/contas_pagar';
    private $route = 'contaspagar';

    function converterParaNumero($valor)
    {
        if (!$valor) return 0;
        return floatval(str_replace(['.', ','], ['', '.'], $valor));
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->contaPagarModel = new ContaPagarModel();
        $this->fornecedorModel = new FornecedorModel();
        $this->classificacaoContaModel = new ClassificacaoContaModel();
        $this->formaPagamentoModel = new FormaPagamentoModel();
        $this->contaCorrenteModel = new ContaCorrenteModel();
        $this->lancamentoFinanceiroModel = new LancamentoFinanceiroModel();
    }

    public function index()
    {
        $data = [
            'menu' => 'Financeiro',
            'title' => 'Contas a Pagar',
            'fornecedores' => $this->fornecedorModel->orderBy('nome_fantasia', 'ASC')->orderBy('razao_social', 'ASC')->findAll(),
            'classificacoes' => $this->classificacaoContaModel->orderBy('codigo', 'ASC')->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->orderBy('nome', 'ASC')->findAll(),
            'contasCorrente' => $this->contaCorrenteModel->orderBy('descricao', 'ASC')->findAll(),
        ];
    
        // Filtro padrão para os últimos 60 dias
        $dataInicio = date('Y-m-d', strtotime('-60 days'));
        $dataFim = date('Y-m-d');
    
        // Verificar se há filtros de data no request
        $filterDataInicio = $this->request->getGet('data_vencimento_inicio');
        $filterDataFim = $this->request->getGet('data_vencimento_fim');
    
        // Usar filtros do usuário se fornecidos, senão usar padrão de 60 dias
        $dataInicio = $filterDataInicio ?: $dataInicio;
        $dataFim = $filterDataFim ?: $dataFim;
    
        // Passar datas de filtro para a view
        $data['filtro_data_inicio'] = $dataInicio;
        $data['filtro_data_fim'] = $dataFim;
    
        return view($this->viewFolder.'/index', $data);
    }

    public function datatables()
    {
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        $search = $_POST['search']['value'];

        $builder = $this->contaPagarModel->builder();
        $builder->select('contas_pagar.*, fornecedores.razao_social, fornecedores.nome_fantasia');
        $builder->join('fornecedores', 'fornecedores.id = contas_pagar.fornecedor_id', 'left');

        // Aplicar filtros de busca
        if (!empty($search)) {
            $builder->groupStart()
                ->like('numero_documento', $search)
                ->orLike('descricao', $search)
                ->orLike('fornecedores.razao_social', $search)
                ->groupEnd();
        }

        // Aplicar filtros do formulário
        $this->aplicarFiltrosDataTable($builder);

        // Contagem total de registros
        $totalRecords = $this->contaPagarModel->countAllResults(false);
        $filteredRecords = $this->contaPagarModel->countAllResults(false);

        // Ordenação
        $order = $_POST['order'][0];
        $columnIndex = $order['column'];
        $columnName = $_POST['columns'][$columnIndex]['data'];
        $columnSortOrder = $order['dir'];

        // Mapeamento de colunas para campos do banco de dados
        $columnMap = [
            'id' => 'contas_pagar.id',
            'numero_documento' => 'contas_pagar.numero_documento',
            'fornecedor_nome' => 'fornecedores.razao_social',
            'descricao' => 'contas_pagar.descricao',
            'valor_total' => 'contas_pagar.valor_total',
            'data_vencimento' => 'contas_pagar.data_vencimento',
            'status' => 'contas_pagar.status'
        ];

        // Usar mapeamento de colunas para ordenação
        $orderColumn = $columnMap[$columnName] ?? 'contas_pagar.id';
        $builder->orderBy($orderColumn, $columnSortOrder);

        // Limitar resultados
        $builder->limit($length, $start);

        $records = $builder->get()->getResult();

        $data = [];
        foreach ($records as $record) {
            $data[] = [
                'id' => $record->id,
                'numero_documento' => $record->numero_documento,
                'fornecedor_nome' => $record->nome_fantasia == '' ? $record->razao_social : $record->nome_fantasia,
                'descricao' => $record->descricao,
                'valor_total' => 'R$ ' . number_format($record->valor_total, 2, ',', '.'),
                'data_vencimento' => date('d/m/Y', strtotime($record->data_vencimento)),
                'status' => $this->formatarStatus($record->status),
                'acoes' => $this->gerarBotoesAcao($record)
            ];
        }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];

        return $this->response->setJSON($response);
    }

    private function aplicarFiltrosDataTable($builder)
    {
        $filtros = $this->request->getPost();

        if (!empty($filtros['data_vencimento_inicio'])) {
            $builder->where('data_vencimento >=', $filtros['data_vencimento_inicio']);
        }
        if (!empty($filtros['data_vencimento_fim'])) {
            $builder->where('data_vencimento <=', $filtros['data_vencimento_fim']);
        }
        if (!empty($filtros['fornecedor_id'])) {
            $builder->where('fornecedor_id', $filtros['fornecedor_id']);
        }
        if (!empty($filtros['status'])) {
            $builder->where('status', $filtros['status']);
        }
    }

    private function formatarStatus($row)
    {
        $cores = [
            'PENDENTE' => [
                'icon' => 'ti ti-alert',
                'color' => 'btn-outline-warning',
                'title' => 'Pendente'
            ],
            'PARCIAL' => [
                'icon' => 'ti ti-split-h',
                'color' => 'btn-outline-info',
                'title' => 'Pagamento Parcial'
            ],
            'PAGO' => [
                'icon' => 'ti ti-check',
                'color' => 'btn-outline-success',
                'title' => 'Pago'
            ],
            'CANCELADO' => [
                'icon' => 'ti ti-close',
                'color' => 'btn-outline-primary',
                'title' => 'Cancelado'
            ],
            'ATRASADO' => [
                'icon' => 'ti ti-timer',
                'color' => 'btn-outline-danger',
                'title' => 'Atrasado'
            ]
        ];
    
        // Verificar se $row é um objeto ou uma string
        $status = is_object($row) ? $row->status : $row;
    
        $statusInfo = $cores[$status] ?? [
            'icon' => 'ti ti-help',
            'color' => 'text-secondary',
            'title' => 'Status Desconhecido'
        ];
    
        return sprintf(
            '<button class="btn btn-sm btn-icon btn-round %s" title="%s" data-original-title="%s" data-toggle="tooltip">
                <i class="%s me-1"></i>
            </button>',
            $statusInfo['color'],
            $statusInfo['title'],
            $statusInfo['title'],
            $statusInfo['icon'],
        );
    }

    private function gerarBotoesAcao($row)
    {
        $dropdownId = 'dropdown-actions-' . $row->id;
        
        // Definir permissões de ações baseadas no status
        $blnEdt = in_array($row->status, ['PENDENTE', 'PARCIAL', 'ATRASADO']);
        $blnPay = in_array($row->status, ['PENDENTE', 'ATRASADO']);
        $blnDel = in_array($row->status, ['PENDENTE', 'ATRASADO']);
        $blnUpl = in_array($row->status, ['PENDENTE', 'ATRASADO']);
    
        $linkViw = 'javascript:view(' . $row->id . ')';

        // Botão de Edição
        if ($blnEdt) {
            $linkEdt = 'javascript:edit(' . $row->id . ')';
        }
        else {
            $linkEdt = "javascript:void()";
        }
    
        // Botão de Baixa
        if ($blnPay) {
            $linkPay = 'javascript:payable(' . $row->id . ')';
        }
        else {
            $linkPay = "javascript:void()";
        }
    
        // Botão de Exclusão
        if ($blnDel) {
            $linkDel = 'javascript:remove(' . $row->id . ')';
        }
        else {
            $linkDel = "javascript:void()";
        }

        // Botão de Upload
        if ($blnUpl) {
            $linkUpl = 'javascript:upload(' . $row->id . ')';
        }
        else {
            $linkUpl = "javascript:void()";
        }
        /*        
        $html = '                
                <div class="btn-group btn-group-sm" role="group">
                    <button id="' . $dropdownId . '" type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Ações">
                        <i class="ti ti-more"></i>
                    </button>
                    <div class="dropdown-menu custom-dropdown p-4" aria-labelledby="' . $dropdownId . '">
                        <a class="dropdown-item text-info" href="' . $linkViw . '">
                            <i class="ti ti-eye me-2"></i>Visualizar
                        </a>
                        <a class="dropdown-item text-primary" href="' . $linkEdt . '">
                            <i class="ti ti-pencil me-2"></i>Editar
                        </a>
                        <a class="dropdown-item text-warning" href="' . $linkUpl . '">
                            <i class="ti ti-clip me-2"></i>Anexar
                        </a>
                        <a class="dropdown-item text-success" href="' . $linkPay . '">
                            <i class="ti ti-money me-2"></i>Baixar
                        </a>
                        <a class="dropdown-item text-danger" href="' . $linkDel . '">
                            <i class="ti ti-trash me-2"></i>Excluir
                        </a>
                    </div>
                </div>
                ';
        */
        $html = '                
                <div class="btn-group btn-group-sm" role="group">
                    <button id="' . $dropdownId . '" type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Ações">
                        <i class="ti ti-more"></i>
                    </button>
                    <div class="dropdown-menu custom-dropdown p-4" aria-labelledby="' . $dropdownId . '">
                        <a class="dropdown-item text-info" href="' . $linkViw . '">
                            <i class="ti ti-eye me-2"></i>Visualizar
                        </a>
                        <a class="dropdown-item text-primary" href="' . $linkEdt . '">
                            <i class="ti ti-pencil me-2"></i>Editar
                        </a>
                        <a class="dropdown-item text-success" href="' . $linkPay . '">
                            <i class="ti ti-money me-2"></i>Baixar
                        </a>
                        <a class="dropdown-item text-danger" href="' . $linkDel . '">
                            <i class="ti ti-trash me-2"></i>Excluir
                        </a>
                    </div>
                </div>
                ';

        return $html;
    }

    public function create()
    {
        $data = [
            'fornecedores' => $this->fornecedorModel->orderBy('razao_social', 'ASC')->findAll(),
            'classificacoes' => $this->classificacaoContaModel->orderBy('codigo', 'ASC')->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->orderBy('nome', 'ASC')->findAll(),
            'contasCorrente' => $this->contaCorrenteModel->orderBy('descricao', 'ASC')->findAll(),
        ];

        return view($this->viewFolder.'/create', $data);
    }

    public function store()
    {
        // Validação de regras
        $rules = [
            'fornecedor_id' => 'required|integer|is_natural_no_zero',
            'classificacao_conta_id' => 'required|integer|is_natural_no_zero',
            'valor_total' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo Valor Total é obrigatório.'
                ]
            ],
            'data_vencimento' => 'required|valid_date',
            'tipo_conta' => 'required|in_list[avulsa,parcelada]'
        ];
    
        // Dados do formulário
        $data = $this->request->getPost();
    
        // Converter valor monetário antes da validação
        $data['valor_total'] = $this->converterParaNumero($data['valor_total']);
    
        // Validar dados
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro de validação',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
    
        try {
            // Definir previsão
            if (isset($data['previsao'])) {
                $data['previsao'] = ($data['previsao'] == 'on' ? true : false);
            } else {
                $data['previsao'] = false;
            }
    
            // Definir valor previsto
            $data['valor_previsto'] = $data['previsao'] == true ? $data['valor_total'] : 0;

            // Definir data de emissão como data atual
            $data['data_emissao'] = date('Y-m-d');

            // Tratamento para Forma de Pagamento
            if ($data['forma_pagamento_id'] === '') {
                $data['forma_pagamento_id'] = null;
            }

            // Tratamento para Conta Corrente
            if ($data['conta_corrente_id'] === '') {
                $data['conta_corrente_id'] = null;
            }

            // Instanciar Model
            $model = new ContaPagarModel();
    
            // Verificar se é conta parcelada
            if ($data['tipo_conta'] === 'parcelada' && !empty($data['parcela_valor'])) {
                // Preparar dados das parcelas
                $parcelasData = [];

                foreach ($data['parcela_valor'] as $index => $valor) {
                    $parcelasData[] = [
                        'fornecedor_id' => $data['fornecedor_id'],
                        'classificacao_conta_id' => $data['classificacao_conta_id'],
                        'forma_pagamento_id' => $data['forma_pagamento_id'],
                        'valor_total' => $this->converterParaNumero($valor),
                        'valor_previsto' => $data['previsao'] == true ? $this->converterParaNumero($valor) : 0,
                        'data_vencimento' => $data['parcela_data_vencimento'][$index],
                        'data_emissao' => $data['data_emissao'],
                        'numero_documento' => $data['numero_documento'] . " - " . ($index + 1) . "/" . count($data['parcela_valor']) ?? null,
                        'descricao' => $data['descricao'] . " - Parcela " . ($index + 1) . "/" . count($data['parcela_valor']),
                        'tipo_conta' => 'parcelada',
                        'numero_parcela' => $index + 1,
                        'total_parcelas' => count($data['parcela_valor']),
                        'previsao' => $data['previsao']
                    ];
                }
                
                // Criar parcelas
                $model->createParcelas($parcelasData);
                
                return $this->response->setJSON([
                    'status' => 'success', 
                    'message' => 'Conta parcelada criada com sucesso'
                ]);
            }
            
            // Criação de conta avulsa
            $conta = $model->create($data);
            
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Conta criada com sucesso'
            ]);
    
        } catch (\Exception $e) {
            log_message('error', 'Erro ao salvar conta: ' . $e->getMessage());

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao salvar a conta: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function edit($id)
    {
        $conta = $this->contaPagarModel->find($id);
    
        // Verificar se a conta existe
        if (!$conta) {
            return redirect()->back()->with('error', 'Conta não encontrada');
        }

        // Adicionar campos faltantes com valores padrão
        $conta->tipo_conta = $conta->tipo_conta ?? 'avulsa';
        $conta->previsao = $conta->previsao ?? 0;
        $conta->valor_total = $conta->valor_total ?? 0;
        $conta->numero_documento = $conta->numero_documento ?? '';
        $conta->descricao = $conta->descricao ?? '';
    
        $data = [
            'conta' => $conta,
            'fornecedores' => $this->fornecedorModel->orderBy('razao_social', 'ASC')->findAll(),
            'classificacoes' => $this->classificacaoContaModel->orderBy('codigo', 'ASC')->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->orderBy('nome', 'ASC')->findAll(),
            'contasCorrente' => $this->contaCorrenteModel->orderBy('descricao', 'ASC')->findAll(),
        ];
    
        return view($this->viewFolder.'/edit', $data);
    }

    public function update()
    {
        // Validação de regras
        $rules = [
            'id' => 'required|integer|is_natural_no_zero',
            'fornecedor_id' => 'required|integer|is_natural_no_zero',
            'classificacao_conta_id' => 'required|integer|is_natural_no_zero',
            'valor_total' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo Valor Total é obrigatório.'
                ]
            ],
            'data_vencimento' => 'required|valid_date'
        ];
    
        // Dados do formulário
        $data = $this->request->getPost();
    
        // Converter valor monetário antes da validação
        $data['valor_total'] = $this->converterParaNumero($data['valor_total']);
    
        // Validar dados
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro de validação',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
    
        try {
            // Definir previsão
            $data['previsao'] = $this->request->getPost('previsao') ? 1 : 0;
    
            // Tratamento para Forma de Pagamento
            if ($data['forma_pagamento_id'] === '') {
                $data['forma_pagamento_id'] = null;
            }

            // Tratamento para Conta Corrente
            if ($data['conta_corrente_id'] === '') {
                $data['conta_corrente_id'] = null;
            }

            // Instanciar Model
            $model = new ContaPagarModel();
    
            // Atualizar conta
            $model->update($data['id'], $data);
            
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Conta atualizada com sucesso',
                'reload_table' => true
            ]);
    
        } catch (\Exception $e) {
            log_message('error', 'Erro ao atualizar conta: ' . $e->getMessage());

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao atualizar a conta: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function delete($id = null)
    {
        // Tentar obter ID do POST se não for passado como parâmetro
        if ($id === null) {
            $id = $this->request->getPost('id');
            log_message('error', 'ID obtido do POST: ' . ($id ?? 'NULO'));
        }
    
        // Se ainda não tiver ID, tentar obter de diferentes formas
        if ($id === null) {
            // Tentar obter do corpo da requisição
            $input = $this->request->getBody();
    
            // Tentar parsear como JSON
            try {
                $jsonInput = json_decode($input, true);
                $id = $jsonInput['id'] ?? null;
            } catch (\Exception $e) {
                log_message('error', 'Erro ao parsear JSON: ' . $e->getMessage());
            }
        }
    
        // Validar ID
        if ($id === null) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ID da conta não fornecido'
            ])->setStatusCode(400);
        }
    
        try {
            // Verificar se o registro existe
            $conta = $this->contaPagarModel->find($id);
            
            if (!$conta) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Conta não encontrada'
                ])->setStatusCode(404);
            }
    
            // Soft delete
            $resultado = $this->contaPagarModel->delete($id);
            
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Conta excluída com sucesso!',
                'data' => [
                    'id' => $id,
                    'active' => false
                ]
            ]);
        } catch (\Exception $e) {
            // Log do erro
            log_message('error', 'Erro na exclusão da conta: ' . $e->getMessage());
            log_message('error', 'Trace do erro: ' . $e->getTraceAsString());
            
            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function view($id)
    {
        $conta = $this->contaPagarModel->find($id);
    
        // Verificar se a conta existe
        if (!$conta) {
            return redirect()->back()->with('error', 'Conta não encontrada');
        }

        $data = [
            'title' => 'Visualizar Conta',
            'conta' => $conta,
            'fornecedores' => $this->fornecedorModel->orderBy('razao_social', 'ASC')->findAll(),
            'classificacoes' => $this->classificacaoContaModel->orderBy('codigo', 'ASC')->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->orderBy('nome', 'ASC')->findAll(),
            'contasCorrente' => $this->contaCorrenteModel->orderBy('descricao', 'ASC')->findAll(),
            'method' => 'view',
        ];
    
        return view($this->viewFolder.'/baixa', $data);
    }

    public function payable($id)
    {
        $conta = $this->contaPagarModel->find($id);
    
        // Verificar se a conta existe
        if (!$conta) {
            return redirect()->back()->with('error', 'Conta não encontrada');
        }

        // Adicionar campos faltantes com valores padrão
        $conta->tipo_conta = $conta->tipo_conta ?? 'avulsa';
        $conta->previsao = $conta->previsao ?? 0;
        $conta->valor_total = $conta->valor_total ?? 0;
        $conta->numero_documento = $conta->numero_documento ?? '';
        $conta->descricao = $conta->descricao ?? '';
    
        $data = [
            'title' => 'Baixar Conta a Pagar',
            'conta' => $conta,
            'fornecedores' => $this->fornecedorModel->orderBy('razao_social', 'ASC')->findAll(),
            'classificacoes' => $this->classificacaoContaModel->orderBy('codigo', 'ASC')->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->orderBy('nome', 'ASC')->findAll(),
            'contasCorrente' => $this->contaCorrenteModel->orderBy('descricao', 'ASC')->findAll(),
            'method' => 'payable',
        ];
    
        return view($this->viewFolder.'/baixa', $data);
    }

    public function paybill()
    {
        // Validar regras de entrada
        $rules = [
            'id' => 'required|integer|is_natural_no_zero',
            'forma_pagamento_id' => 'required|integer|is_natural_no_zero',
            'conta_corrente_id' => 'required|integer|is_natural_no_zero',
            'valor_pago' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo Valor Pago é obrigatório.'
                ]
            ],
            'data_pagamento' => 'required|valid_date'
        ];
    
        // Obter dados do formulário
        $data = $this->request->getPost();
    
        // Converter valores monetários
        $data['valor_pago'] = $this->converterParaNumero($data['valor_pago']);
        $data['valor_desconto'] = $this->converterParaNumero($data['valor_desconto'] ?? 0);
        $data['valor_acrescimo'] = $this->converterParaNumero($data['valor_acrescimo'] ?? 0);

        // Verificar se as regras são válidas
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
        
        // Iniciar transação
        $this->db->transStart();

        try {
            // Buscar conta original
            $conta = $this->contaPagarModel->find($data['id']);
            
            if (!$conta) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Conta não encontrada'
                ])->setStatusCode(404);
            }
    
            // Calcular valor total com descontos e acréscimos
            $valorTotal = $conta->valor_total;
            $valorPago = $data['valor_pago'];
            $valorDesconto = $data['valor_desconto'];
            $valorAcrescimo = $data['valor_acrescimo'];
            $valorLiquido = $valorTotal - $valorDesconto + $valorAcrescimo;
            $dataCompetencia = str_replace(' 00:00:00', '', $conta->data_vencimento);

            // Verificar se o valor pago é suficiente
            if ($valorPago < $valorLiquido) {
                // Criar conta filha com o valor restante
                $contaFilha = [
                    'numero_documento' => $conta->numero_documento . '-SALDO',
                    'fornecedor_id' => $conta->fornecedor_id,
                    'classificacao_conta_id' => $conta->classificacao_conta_id,
                    'forma_pagamento_id' => $data['forma_pagamento_id'],
                    'conta_corrente_id' => $data['conta_corrente_id'],
                    'data_emissao' => date('Y-m-d'),
                    'data_vencimento' => date('Y-m-d', strtotime('+30 days')),
                    'valor_total' => $valorLiquido - $valorPago,
                    'descricao' => 'Saldo remanescente de ' . $conta->descricao,
                    'status' => 'PENDENTE',
                    'tipo_conta' => 'SALDO'
                ];
    
                $this->contaPagarModel->insert($contaFilha);
            }
    
            // Preparar dados para atualização
            $dadosAtualizacao = [
                'valor_pago' => $valorPago,
                'valor_desconto' => $valorDesconto,
                'valor_acrescimo' => $valorAcrescimo,
                'data_pagamento' => $data['data_pagamento'],
                'forma_pagamento_id' => $data['forma_pagamento_id'],
                'conta_corrente_id' => $data['conta_corrente_id'],
                'status' => ($valorPago >= $valorLiquido) ? 'PAGO' : 'PARCIAL'
            ];
    
            // Atualizar conta
            $resultado = $this->contaPagarModel->update($data['id'], $dadosAtualizacao);
    
            if (!$resultado) {
                throw new \Exception('Erro ao atualizar a conta.');
            }
    
            // Inserir lancamento financeiro
            $lancamentoFinanceiro = [
                'tipo_lancamento' => 'DESPESA',
                'origem_lancamento' => 'CONTA CORRENTE',
                'conta_origem_id' => $data['conta_corrente_id'],
                'valor' => $valorPago,
                'data_lancamento' => $data['data_pagamento'],
                'data_competencia' => $dataCompetencia,
                'descricao' => "Pagamento de {$conta->descricao}",
                'classificacao_conta_id' => $conta->classificacao_conta_id,
                'fornecedor_id' => $conta->fornecedor_id,
                'numero_documento' => $conta->numero_documento,
                'status' => 'CONCLUIDO',
                'user_id' => userIsLogged()->id,
            ];

            if (!$this->lancamentoFinanceiroModel->insert($lancamentoFinanceiro)) {
                throw new \Exception('Erro ao inserir o lancamento financeiro.');
            }

            // Completar transação
            $this->db->transComplete();
    
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Baixa realizada com sucesso!',
                'data' => [
                    'conta_id' => $data['id'],
                    'valor_pago' => $valorPago,
                    'status' => $dadosAtualizacao['status']
                ]
            ]);
    
        } catch (\Exception $e) {
            // $lastQuery = $this->db->getLastQuery();
            // print_r($lastQuery);

            $this->db->transRollback();
            
            // Log do erro
            log_message('error', 'Erro na baixa da conta: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Erro ao realizar baixa: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    /*
    public function upload($id)
    {
        $file = $this->request->getFile('documento');

        if (!$file->isValid()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Arquivo inválido.'
            ]);
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/contas_pagar', $newName);

        // Aqui você pode salvar o caminho do arquivo no banco de dados se necessário
        // Por exemplo, criar uma tabela de documentos relacionados

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Documento enviado com sucesso!'
        ]);
    }
    */
}