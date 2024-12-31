<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ContaPagarModel;
use App\Models\FornecedorModel;
use App\Models\ClassificacaoContaModel;
use App\Models\FormaPagamentoModel;
use CodeIgniter\HTTP\ResponseInterface;

class ContasPagar extends BaseController
{
    protected $contaPagarModel;
    protected $fornecedorModel;
    protected $classificacaoContaModel;
    protected $formaPagamentoModel;

    private $viewFolder = '/mentor/financeiro/contas_pagar';
    private $route = 'contaspagar';

    public function __construct()
    {
        $this->contaPagarModel = new ContaPagarModel();
        $this->fornecedorModel = new FornecedorModel();
        $this->classificacaoContaModel = new ClassificacaoContaModel();
        $this->formaPagamentoModel = new FormaPagamentoModel();
    }

    public function index()
    {
        $data = [
            'menu' => 'Financeiro',
            'title' => 'Contas a Pagar',
            'fornecedores' => $this->fornecedorModel->findAll(),
            'classificacoes' => $this->classificacaoContaModel->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->findAll()
        ];

        return view($this->viewFolder.'/index', $data);
    }

    public function datatables()
    {
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        $search = $_POST['search']['value'];

        $builder = $this->contaPagarModel->builder();
        $builder->select('contas_pagar.*, fornecedores.razao_social as fornecedor_nome');
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
        $builder->orderBy($columnName, $columnSortOrder);

        // Limitar resultados
        $builder->limit($length, $start);

        $records = $builder->get()->getResult();

        $data = [];
        foreach ($records as $record) {
            $data[] = [
                'id' => $record->id,
                'numero_documento' => $record->numero_documento,
                'fornecedor_nome' => $record->fornecedor_nome,
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

        if (!empty($filtros['data_emissao_inicio'])) {
            $builder->where('data_emissao >=', $filtros['data_emissao_inicio']);
        }
        if (!empty($filtros['data_emissao_fim'])) {
            $builder->where('data_emissao <=', $filtros['data_emissao_fim']);
        }
        if (!empty($filtros['fornecedor_id'])) {
            $builder->where('fornecedor_id', $filtros['fornecedor_id']);
        }
        if (!empty($filtros['status'])) {
            $builder->where('status', $filtros['status']);
        }
    }

    private function formatarStatus($status)
    {
        $cores = [
            'PENDENTE' => 'warning',
            'PARCIAL' => 'info',
            'PAGO' => 'success',
            'CANCELADO' => 'danger'
        ];

        return sprintf(
            '<span class="badge bg-%s">%s</span>', 
            $cores[$status] ?? 'secondary', 
            $status
        );
    }

    private function gerarBotoesAcao($registro)
    {
        $btnEditar = '<button class="btn btn-sm btn-icon btn-outline-primary btn-edit" data-id="' . $registro->id . '"><i class="ti ti-edit"></i></button>';
        $btnExcluir = '<button class="btn btn-sm btn-icon btn-outline-danger btn-del" data-id="' . $registro->id . '"><i class="ti ti-trash"></i></button>';
        $btnBaixa = '<button class="btn btn-sm btn-icon btn-outline-success btn-baixa" data-id="' . $registro->id . '"><i class="ti ti-cash"></i></button>';
        $btnUpload = '<button class="btn btn-sm btn-icon btn-outline-secondary btn-upload" data-id="' . $registro->id . '"><i class="ti ti-upload"></i></button>';

        return "<div class='btn-group'>{$btnEditar}{$btnBaixa}{$btnUpload}{$btnExcluir}</div>";
    }

    public function create()
    {
        $data = [
            'fornecedores' => $this->fornecedorModel->findAll(),
            'classificacoes' => $this->classificacaoContaModel->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->findAll(),
            'response' => 'response',
        ];

        // Renderiza o conteúdo do modal diretamente
        return view($this->viewFolder.'/create', $data);
    }

    public function store()
    {
        $rules = [
            'fornecedor_id' => 'required|integer',
            'valor_total' => 'required|numeric',
            'data_vencimento' => 'required|valid_date',
            'tipo_conta' => 'required|in_list[AVULSA,PARCELADA]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $dadosConta = $this->request->getPost();

        try {
            if ($dadosConta['tipo_conta'] == 'PARCELADA' && !empty($dadosConta['total_parcelas'])) {
                $this->contaPagarModel->gerarContasParceladas($dadosConta, $dadosConta['total_parcelas']);
            } else {
                $this->contaPagarModel->insert($dadosConta);
            }

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Conta cadastrada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $conta = $this->contaPagarModel->find($id);

        $data = [
            'conta' => $conta,
            'fornecedores' => $this->fornecedorModel->findAll(),
            'classificacoes' => $this->classificacaoContaModel->findAll(),
            'formasPagamento' => $this->formaPagamentoModel->findAll(),
            'response' => 'response',
        ];

        return view($this->viewFolder.'/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'fornecedor_id' => 'required|integer',
            'valor_total' => 'required|numeric',
            'data_vencimento' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $dadosConta = $this->request->getPost();

        try {
            $this->contaPagarModel->update($id, $dadosConta);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Conta atualizada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $this->contaPagarModel->delete($id);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Conta excluída com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function restore($id)
    {
        try {
            $this->contaPagarModel->update($id, ['deleted_at' => null]);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Conta restaurada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function baixa($id)
    {
        $rules = [
            'valor_pago' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $valorPago = $this->request->getPost('valor_pago');

        try {
            $this->contaPagarModel->pagarConta($id, $valorPago);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Pagamento realizado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

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
}