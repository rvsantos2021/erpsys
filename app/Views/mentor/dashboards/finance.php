<?= $this->extend('/mentor/layout/main') ?>

<?= $this->section('title') ?>
<?= APP_NAME . ' - ' . APP_VERSION . ' - ' . $title ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.chart-bottom-details {
    margin-bottom: 15px;
}

.chart-bottom-details p {
    font-size: 0.875rem;
}
.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #f1f3f9;
    color: #6c757d;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Resumo Financeiro -->
    <div class="row">
        <!-- Total Contas a Pagar -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-primary">
                            <i class="fe fe-credit-card"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_total_contas_pagar'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Total Contas a Pagar</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contas Pendentes -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-warning">
                            <i class="fe fe-alert-triangle"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3><?= $resumoFinanceiro['contas_pendentes'] ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Contas Pendentes</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_pendentes'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_pendentes'] ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contas Atrasadas -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-danger">
                            <i class="fe fe-calendar"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3><?= $resumoFinanceiro['contas_atrasadas'] ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Contas Atrasadas</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_atrasadas'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_atrasadas'] ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Pago -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-success">
                            <i class="fe fe-dollar-sign"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_total_pago'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Total Pago</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_pagas'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_pagas'] ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gráficos -->
    <div class="row">
        <!-- Status das Contas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Status das Contas</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="chart-container">
                        <canvas id="statusContasChart" height="300"></canvas>
                    </div>
                    <div class="chart-bottom-title">
                        <?php 
                        $total = array_sum(array_column($graficosContas['status_contas'], 'total'));
                        foreach ($graficosContas['status_contas'] as $status): 
                            $percentual = $total > 0 ? round(($status['total'] / $total) * 100, 1) : 0;
                            $color = $statusColors[strtoupper($status['status'])] ?? '#6c757d';
                        ?>
                        <div class="chart-bottom-details">
                            <p class="mb-0">
                                <span class="text-truncate"><?= $status['status'] ?></span>
                                <span class="float-right">R$ <?= number_format($status['total'], 2, ',', '.') ?></span>
                            </p>
                            <div class="progress progress-sm">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: <?= $percentual ?>%; background-color: <?= $color ?>">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contas por Fornecedor -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contas por Fornecedor</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="chart-container">
                        <canvas id="contasPorFornecedorChart" height="300"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table class="table mb-0" style="width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fornecedor</th>
                                        <th></th>
                                        <th class="text-right">Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalContasFornecedores = array_sum(array_column($graficosContas['contas_por_fornecedor'], 'total_contas'));
                                    foreach ($graficosContas['contas_por_fornecedor'] as $fornecedor): 
                                        $percentual = $totalContasFornecedores > 0 
                                            ? round(($fornecedor['total_contas'] / $totalContasFornecedores) * 100, 1) 
                                            : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <span class="avatar avatar-sm">
                                                        <i class="fas ti ti-package"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= $fornecedor['nome_fantasia'] ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-dark" role="progressbar" style="width: <?= $percentual ?>%; background-color: rgba(54, 162, 235, 0.6)">
                                                    <?= $percentual ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            R$ <?= number_format($fornecedor['total_contas'], 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se os elementos existem antes de criar os gráficos
    const statusContasChart = document.getElementById('statusContasChart');
    const contasPorFornecedorChart = document.getElementById('contasPorFornecedorChart');

    if (!statusContasChart || !contasPorFornecedorChart) {
        console.warn('Um ou mais elementos de gráfico não encontrados');
        return;
    }

    const statusColors = <?= json_encode($statusColors) ?>;

    // Gráfico de Status das Contas
    var statusContasCtx = statusContasChart.getContext('2d');
    
    // Dados dos status das contas
    var statusContasRaw = <?= json_encode($graficosContas['status_contas']) ?>.map(item => ({
        ...item,
        total: parseFloat(item.total) || 0
    }));
    
    // Calcular o valor total
    var totalValor = statusContasRaw.reduce((sum, item) => sum + item.total, 0);

    // Preparar dados para o gráfico
    var statusContasData = {
        labels: statusContasRaw.map(item => item.status),
        datasets: [{
            data: statusContasRaw.map(item => item.total),
            backgroundColor: statusContasRaw.map(item => 
                statusColors[item.status.toUpperCase()] || '#6c757d'
            )
        }]
    };

    // Criar o gráfico de Status das Contas
    new Chart(statusContasCtx, {
        type: 'doughnut',
        data: statusContasData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 70,
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[0];
                        var total = dataset.data.reduce((a, b) => a + b, 0);
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = total > 0 
                            ? ((currentValue/total) * 100).toFixed(1) 
                            : '0.0';
                        return `${data.labels[tooltipItem.index]}: R$ ${currentValue.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (${percentage}%)`;
                    }
                }
            }
        }
    });

    // Gráfico de Contas por Fornecedor
    var contasPorFornecedorCtx = contasPorFornecedorChart.getContext('2d');
    
    // Dados dos fornecedores
    var contasPorFornecedorRaw = <?= json_encode($graficosContas['contas_por_fornecedor']) ?>.map(item => ({
        ...item,
        total_contas: parseFloat(item.total_contas) || 0
    }));
    
    // Calcular o valor total
    var totalValorFornecedores = contasPorFornecedorRaw.reduce((sum, item) => sum + item.total_contas, 0);

    // Preparar dados para o gráfico
    var contasPorFornecedorData = {
        labels: contasPorFornecedorRaw.map(item => item.nome_fantasia),
        datasets: [{
            data: contasPorFornecedorRaw.map(item => item.total_contas),
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    };
    
    // Criar o gráfico de Contas por Fornecedor
    new Chart(contasPorFornecedorCtx, {
        type: 'bar',
        data: contasPorFornecedorData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: false  // Oculta os labels dos fornecedores no eixo X
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                        var currentValue = data.datasets[0].data[tooltipItem.index];
                        var percentage = total > 0 
                            ? ((currentValue/total) * 100).toFixed(1) 
                            : '0.0';
                        return `${data.labels[tooltipItem.index]}: R$ ${currentValue.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (${percentage}%)`;
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>