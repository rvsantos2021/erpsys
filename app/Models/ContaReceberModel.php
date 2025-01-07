<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ContaReceber;

class ContaReceberModel extends Model
{
    protected $table            = 'contas_receber';
    protected $primaryKey       = 'id';
    protected $returnType       = ContaReceber::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'cliente_id', 
        'conta_pai_id', 
        'numero_documento', 
        'descricao', 
        'valor_total', 
        'valor_previsto',
        'valor_desconto', 
        'valor_acrescimo', 
        'valor_pago', 
        'data_emissao', 
        'data_vencimento', 
        'data_pagamento', 
        'status', 
        'tipo_conta', 
        'numero_parcela', 
        'total_parcelas', 
        'classificacao_conta_id', 
        'forma_pagamento_id',
        'conta_corrente_id',
        'previsao',
        'active',
        'deleted_at',
    ];
    
    // Definição dos campos de data
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Definir condições padrão para busca
    protected $beforeFind = ['filterActive'];

    // Adicione um método para depuração
    public function getFilteredAccounts($conditions)
    {
        return $this->where($conditions)
            ->orderBy('data_vencimento', 'ASC')
            ->findAll();
    }
        
    public function filterActive(array $params)
    {
        // Adicionar condição para buscar apenas registros ativos
        if (!isset($params['conditions'])) {
            $params['conditions'] = [];
        }
    
        // Adicionar condição de active apenas se não for uma operação de exclusão
        if (!isset($params['method']) || $params['method'] !== 'delete') {
            $params['conditions']['active'] = 1;
        }
    
        return $params;
    }

    // Método para buscar com todos os registros, incluindo inativos
    public function withInactive()
    {
        // Limpar condições de beforeFind para incluir todos os registros
        $this->beforeFind = [];
        
        // Garantir que a condição de active seja específica para a tabela
        $this->builder()->resetQuery();
        
        return $this;
    }
    
    // Método para buscar todos os registros, incluindo inativos
    public function findAllWithInactive($limit = null, $offset = 0)
    {
        // Remover filtro de ativos temporariamente
        $this->beforeFind = [];
        $result = $this->findAll($limit, $offset);
        
        // Restaurar filtro de ativos
        $this->beforeFind = ['filterActive'];
        
        return $result;
    }
    
    // Sobrescrever métodos para garantir tratamento correto
    public function findAll(?int $limit = null, int $offset = 0)
    {
        $this->builder()->where('contas_receber.active', 1);
        return parent::findAll($limit, $offset);
    }
        
    public function countAllResults(bool $reset = true, bool $test = false): int
    {
        $this->builder()->where('contas_receber.active', 1);
        return parent::countAllResults($reset, $test);
    }
                
    public function selectSum(string $select, string $alias = null)
    {
        $this->builder()->where('contas_receber.active', 1);
        
        // Se nenhum alias for fornecido, usar o nome da coluna como alias
        if ($alias === null) {
            $alias = $select;
        }
        
        return parent::selectSum($select, $alias);
    }
    
    // Sobrescrever método de exclusão para usar soft delete
    public function delete($id = null, bool $purge = false)
    {
        // Se purge for true, realizar exclusão permanente
        if ($purge) {
            return parent::delete($id, true);
        }
    
        // Soft delete
        try {
            $data = [
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s') // Definir timestamp de exclusão
            ];
            
            $resultado = $this->update($id, $data);
            
            return $resultado;
        } catch (\Exception $e) {
            log_message('error', 'Erro no soft delete: ' . $e->getMessage());
            throw $e;
        }
    }
    
    // Método para restaurar registro
    public function restore($id)
    {
        try {
            $data = [
                'active' => true,
                'deleted_at' => null
            ];
            
            $resultado = $this->update($id, $data);
            
            return $resultado;
        } catch (\Exception $e) {
            log_message('error', 'Erro na restauração: ' . $e->getMessage());
            throw $e;
        }
    }

    // Relacionamentos
    protected $with = [
        'cliente', 
        'classificacaoConta', 
        'formaPagamento', 
        'contaCorrente'
    ];
    
    // Definir relacionamentos
    public function cliente()
    {
        return $this->belongsTo(ClienteModel::class, 'cliente_id');
    }

    public function classificacaoConta()
    {
        return $this->belongsTo(ClassificacaoContaModel::class, 'classificacao_conta_id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamentoModel::class, 'forma_pagamento_id');
    }

    public function contaCorrente()
    {
        return $this->belongsTo(ContaCorrente::class, 'conta_corrente_id');
    }
        
    public function contaPai()
    {
        return $this->belongsTo(self::class, 'conta_pai_id');
    }

    public function contasFilhas()
    {
        return $this->hasMany(self::class, 'conta_pai_id');
    }

    public function create($data)
    {
        // Preparar dados para conta avulsa
        $dadosConta = [
            'cliente_id' => $data['cliente_id'],
            'classificacao_conta_id' => $data['classificacao_conta_id'],
            'forma_pagamento_id' => $data['forma_pagamento_id'],
            'valor_total' => $data['valor_total'],
            'valor_previsto' => $data['valor_previsto'],
            'data_vencimento' => $data['data_vencimento'],
            'data_emissao' => $data['data_emissao'],
            'numero_documento' => $data['numero_documento'] ?? null,
            'descricao' => $data['descricao'] ?? null,
            'tipo_conta' => 'avulsa',
            'previsao' => $data['previsao'] ?? 0
        ];
    
        // Inserir conta
        $contaId = $this->insert($dadosConta);
        
        // Retornar objeto da conta
        return $this->find($contaId);
    }

    public function createParcelas($parcelasData)
    {
        // Validar dados das parcelas
        if (empty($parcelasData)) {
            throw new \Exception('Nenhuma parcela fornecida');
        }
    
        // Inserir parcelas em lote
        return $this->insertBatch($parcelasData);
    }

    /**
     * Método para gerar contas parceladas
     * @param array $dadosConta Dados da conta original
     * @param int $numeroParcelas Número de parcelas
     * @return array Contas geradas
     */
    public function gerarContasParceladas(array $dadosConta, int $numeroParcelas)
    {
        $contasParcelas = [];
        $valorParcela = round($dadosConta['valor_total'] / $numeroParcelas, 2);
        $dataVencimento = new Time($dadosConta['data_vencimento']);

        for ($i = 1; $i <= $numeroParcelas; $i++) {
            $dadosParcela = $dadosConta;
            $dadosParcela['valor_total'] = $valorParcela;
            $dadosParcela['numero_parcela'] = $i;
            $dadosParcela['total_parcelas'] = $numeroParcelas;
            $dadosParcela['tipo_conta'] = 'PARCELADA';
            $dadosParcela['data_vencimento'] = $dataVencimento->addMonths($i - 1)->toDateString();

            $contasParcelas[] = $this->insert($dadosParcela);
        }

        return $contasParcelas;
    }

    public function createParceladaAccount($data)
    {
        // Preparar dados para conta parcelada
        $dadosContaPai = [
            'cliente_id' => $data['cliente_id'],
            'classificacao_conta_id' => $data['classificacao_conta_id'],
            'forma_pagamento_id' => $data['forma_pagamento_id'],
            'valor_total' => $data['valor_total'],
            'data_vencimento' => $data['data_vencimento'],
            'numero_documento' => $data['numero_documento'] ?? null,
            'descricao' => $data['descricao'] ?? null,
            'tipo_conta' => 'parcelada',
            'previsao' => $data['previsao'] ?? 0
        ];
    
        // Inserir conta pai
        $contaPaiId = $this->insert($dadosContaPai);
        
        // Retornar objeto da conta pai para usar no cadastro de parcelas
        return $this->find($contaPaiId);
    }
    
    public function updateParcela($parcelaId, $data)
    {
        // Validar dados da parcela
        $dadosValidados = [
            'valor' => $data['valor'] ?? null,
            'data_vencimento' => $data['data_vencimento'] ?? null
        ];
    
        // Atualizar parcela
        return $this->update($parcelaId, $dadosValidados);
    }

    /**
     * Método para realizar pagamento de conta
     * @param int $id ID da conta
     * @param float $valorPago Valor pago
     * @return bool Sucesso do pagamento
     */
    public function pagarConta(int $id, float $valorPago)
    {
        $conta = $this->find($id);

        if (!$conta) {
            throw new \Exception("Conta não encontrada");
        }

        $saldoRestante = $conta->valor_total - $valorPago;

        // Atualiza status e valor pago
        $dadosAtualizacao = [
            'valor_pago' => $valorPago,
            'data_pagamento' => Time::now()->toDateString(),
        ];

        // Define status baseado no valor pago
        if ($valorPago >= $conta->valor_total) {
            $dadosAtualizacao['status'] = 'RECEBIDO';
        } elseif ($valorPago > 0) {
            $dadosAtualizacao['status'] = 'PARCIAL';

            // Gera nova conta para o saldo restante
            $this->gerarContaRestante($conta, $saldoRestante);
        }

        return $this->update($id, $dadosAtualizacao);
    }

    /**
     * Gera uma nova conta para o saldo restante
     * @param ContaReceber $contaOriginal Conta original
     * @param float $saldoRestante Saldo restante
     * @return int ID da nova conta
     */
    private function gerarContaRestante(ContaReceber $contaOriginal, float $saldoRestante)
    {
        $dadosNovaContaRestante = [
            'cliente_id' => $contaOriginal->cliente_id,
            'conta_pai_id' => $contaOriginal->id,
            'numero_documento' => $contaOriginal->numero_documento,
            'descricao' => "Saldo restante - {$contaOriginal->descricao}",
            'valor_total' => $saldoRestante,
            'valor_pago' => 0,
            'data_emissao' => Time::now()->toDateString(),
            'data_vencimento' => $contaOriginal->data_vencimento,
            'status' => 'PENDENTE',
            'tipo_conta' => $contaOriginal->tipo_conta,
            'classificacao_conta_id' => $contaOriginal->classificacao_conta_id,
            'forma_pagamento_id' => $contaOriginal->forma_pagamento_id,
        ];

        return $this->insert($dadosNovaContaRestante);
    }

    /**
     * Método para filtrar contas com diversos parâmetros
     * @param array $filtros Filtros para busca
     * @return array Contas filtradas
     */
    public function filtrarContas(array $filtros)
    {
        $builder = $this->builder();

        if (!empty($filtros['data_emissao_inicio'])) {
            $builder->where('data_emissao >=', $filtros['data_emissao_inicio']);
        }

        if (!empty($filtros['data_emissao_fim'])) {
            $builder->where('data_emissao <=', $filtros['data_emissao_fim']);
        }

        if (!empty($filtros['data_vencimento_inicio'])) {
            $builder->where('data_vencimento >=', $filtros['data_vencimento_inicio']);
        }

        if (!empty($filtros['data_vencimento_fim'])) {
            $builder->where('data_vencimento <=', $filtros['data_vencimento_fim']);
        }

        if (!empty($filtros['cliente_id'])) {
            $builder->where('cliente_id', $filtros['cliente_id']);
        }

        if (!empty($filtros['status'])) {
            $builder->where('status', $filtros['status']);
        }

        if (!empty($filtros['tipo_conta'])) {
            $builder->where('tipo_conta', $filtros['tipo_conta']);
        }

        return $this->findAll();
    }

    // Método para calcular o saldo remanescente
    public function calcularSaldoRemanescente($conta, $valorPago, $valorDesconto = 0, $valorAcrescimo = 0)
    {
        $valorTotal = $conta->valor_total;
        $valorLiquido = $valorTotal - $valorDesconto + $valorAcrescimo;
        $saldoRemanescente = $valorLiquido - $valorPago;

        return $saldoRemanescente > 0 ? $saldoRemanescente : 0;
    }

    // Método para gerar conta filha de saldo remanescente
    public function gerarContaFilha($contaOriginal, $saldoRemanescente, $dadosAdicionais = [])
    {
        $dadosContaFilha = [
            'numero_documento' => $contaOriginal->numero_documento . '-SALDO',
            'cliente_id' => $contaOriginal->cliente_id,
            'classificacao_conta_id' => $contaOriginal->classificacao_conta_id,
            'data_emissao' => date('Y-m-d'),
            'data_vencimento' => date('Y-m-d', strtotime('+30 days')),
            'valor_total' => $saldoRemanescente,
            'descricao' => 'Saldo remanescente de ' . $contaOriginal->descricao,
            'status' => 'PENDENTE',
            'tipo_conta' => 'saldo'
        ];

        // Mesclar dados adicionais
        $dadosContaFilha = array_merge($dadosContaFilha, $dadosAdicionais);

        return $this->insert($dadosContaFilha);
    }

    // Método para realizar baixa de conta
    public function realizarBaixa($id, $dadosBaixa)
    {
        try {
            // Iniciar transação
            $this->db->transStart();

            // Buscar conta original
            $conta = $this->find($id);

            if (!$conta) {
                throw new \Exception('Conta não encontrada');
            }

            // Calcular saldo remanescente
            $saldoRemanescente = $this->calcularSaldoRemanescente(
                $conta, 
                $dadosBaixa['valor_pago'], 
                $dadosBaixa['valor_desconto'] ?? 0, 
                $dadosBaixa['valor_acrescimo'] ?? 0
            );

            // Preparar dados de atualização
            $dadosAtualizacao = [
                'valor_pago' => $dadosBaixa['valor_pago'],
                'valor_desconto' => $dadosBaixa['valor_desconto'] ?? 0,
                'valor_acrescimo' => $dadosBaixa['valor_acrescimo'] ?? 0,
                'data_pagamento' => $dadosBaixa['data_pagamento'],
                'forma_pagamento_id' => $dadosBaixa['forma_pagamento_id'],
                'conta_corrente_id' => $dadosBaixa['conta_corrente_id'],
                'status' => $saldoRemanescente > 0 ? 'PARCIAL' : 'RECEBIDO'
            ];

            // Atualizar conta
            $this->update($id, $dadosAtualizacao);

            // Gerar conta filha se houver saldo remanescente
            if ($saldoRemanescente > 0) {
                $this->gerarContaFilha($conta, $saldoRemanescente, [
                    'forma_pagamento_id' => $dadosBaixa['forma_pagamento_id'],
                    'conta_corrente_id' => $dadosBaixa['conta_corrente_id']
                ]);
            }

            // Finalizar transação
            $this->db->transComplete();

            return $dadosAtualizacao;
        } catch (\Exception $e) {
            // Reverter transação em caso de erro
            $this->db->transRollback();
            
            throw $e;
        }
    }    
}
