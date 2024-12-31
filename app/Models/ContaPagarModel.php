<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ContaPagar;
use CodeIgniter\I18n\Time;

class ContaPagarModel extends Model
{
    protected $table            = 'contas_pagar';
    protected $primaryKey       = 'id';
    protected $returnType       = ContaPagar::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'fornecedor_id', 
        'conta_pai_id', 
        'numero_documento', 
        'descricao', 
        'valor_total', 
        'valor_pago', 
        'data_emissao', 
        'data_vencimento', 
        'data_pagamento', 
        'status', 
        'tipo_conta', 
        'numero_parcela', 
        'total_parcelas', 
        'classificacao_conta_id', 
        'forma_pagamento_id'
    ];

    // Definição dos campos de data
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Relacionamentos
    protected $with = ['fornecedor', 'classificacaoConta', 'formaPagamento'];

    // Definir relacionamentos
    public function fornecedor()
    {
        return $this->belongsTo(FornecedorModel::class, 'fornecedor_id');
    }

    public function classificacaoConta()
    {
        return $this->belongsTo(ClassificacaoContaModel::class, 'classificacao_conta_id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamentoModel::class, 'forma_pagamento_id');
    }

    public function contaPai()
    {
        return $this->belongsTo(self::class, 'conta_pai_id');
    }

    public function contasFilhas()
    {
        return $this->hasMany(self::class, 'conta_pai_id');
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
            $dadosAtualizacao['status'] = 'PAGO';
        } elseif ($valorPago > 0) {
            $dadosAtualizacao['status'] = 'PARCIAL';

            // Gera nova conta para o saldo restante
            $this->gerarContaRestante($conta, $saldoRestante);
        }

        return $this->update($id, $dadosAtualizacao);
    }

    /**
     * Gera uma nova conta para o saldo restante
     * @param ContaPagar $contaOriginal Conta original
     * @param float $saldoRestante Saldo restante
     * @return int ID da nova conta
     */
    private function gerarContaRestante(ContaPagar $contaOriginal, float $saldoRestante)
    {
        $dadosNovaContaRestante = [
            'fornecedor_id' => $contaOriginal->fornecedor_id,
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

        if (!empty($filtros['fornecedor_id'])) {
            $builder->where('fornecedor_id', $filtros['fornecedor_id']);
        }

        if (!empty($filtros['status'])) {
            $builder->where('status', $filtros['status']);
        }

        if (!empty($filtros['tipo_conta'])) {
            $builder->where('tipo_conta', $filtros['tipo_conta']);
        }

        return $this->findAll();
    }
}