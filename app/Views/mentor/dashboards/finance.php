<?= $this->extend('/mentor/layout/main') ?>

<?= $this->section('title') ?>
<?= APP_NAME . ' - ' . APP_VERSION . ' - ' . $title ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Resumo Financeiro -->
    <div class="row">
        <!-- Total Contas a Pagar -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-info">
                            <i class="fe fe-credit-card"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_total_contas_pagar'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Total Contas a Pagar</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contas a Pagar Pendentes -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-warning">
                            <i class="fe fe-alert-triangle"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_contas_pagar_pendentes'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Contas a Pagar Pendentes</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_pagar_pendentes'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_pagar_pendentes'] ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contas a Pagar Atrasadas -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-danger">
                            <i class="fe fe-calendar"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_contas_pagar_atrasadas'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Contas a Pagar Atrasadas</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_pagar_atrasadas'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_pagar_atrasadas'] ?>%
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
        <!-- -->
        <!-- Total Contas a Receber -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-primary">
                            <i class="ti ti-check-box"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_total_contas_receber'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-primary">
                        <h6 class="text-muted">Total Contas a Receber</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contas a Receber Pendentes -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-warning">
                            <i class="ti ti-wallet"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_contas_receber_pendentes'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Contas a Receber Pendentes</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_receber_pendentes'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_receber_pendentes'] ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contas a Receber Atrasadas -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-danger">
                            <i class="ti ti-timer"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_contas_receber_atrasadas'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Contas a Receber Atrasadas</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_receber_atrasadas'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_receber_atrasadas'] ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Recebido -->
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="btn btn-icon btn-round btn-inverse-success">
                            <i class="ti ti-receipt"></i>
                        </span>
                        <div class="dash-count mt-2">
                            <h3>R$ <?= number_format($resumoFinanceiro['valor_total_recebido'], 2, ',', '.') ?></h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Total Recebido</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success text-dark" style="width: <?= $resumoFinanceiro['percentual_contas_recebidas'] ?>%">
                                <?= $resumoFinanceiro['percentual_contas_recebidas'] ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gráficos -->
    <div class="row">
        <!-- Status das Contas a Pagar -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Status das Contas a Pagar</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="chart-container">
                        <canvas id="statusContasPagarChart" height="300"></canvas>
                    </div>
                    <div class="chart-bottom-title">
                        <?php 
                        $total = array_sum(array_column($graficosContasPagar['status_contas_pagar'], 'total'));

                        foreach ($graficosContasPagar['status_contas_pagar'] as $status): 
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

        <!-- Status das Contas a Receber -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Status das Contas a Receber</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="chart-container">
                        <canvas id="statusContasReceberChart" height="300"></canvas>
                    </div>
                    <div class="chart-bottom-title">
                        <?php 
                        $total = array_sum(array_column($graficosContasReceber['status_contas_receber'], 'total'));

                        foreach ($graficosContasReceber['status_contas_receber'] as $status): 
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
                    <h4 class="card-title">Contas a Pagar por Fornecedor</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="chart-container">
                        <canvas id="contasPagarPorFornecedorChart" height="300"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <!--
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
                                    $totalContasFornecedores = array_sum(array_column($graficosContasPagar['contas_pagar_por_fornecedor'], 'total_contas'));

                                    foreach ($graficosContasPagar['contas_pagar_por_fornecedor'] as $fornecedor): 
                                        $percentual = $totalContasFornecedores > 0 
                                            ? round(($fornecedor['total_contas'] / $totalContasFornecedores) * 100, 1) 
                                            : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <span class="avatar avatar-sm">
                                                        <i class="ti ti-truck"></i>
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
                            -->
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
                                    // Ordenar fornecedores por total de contas, do maior para o menor
                                    $fornecedores = $graficosContasPagar['contas_pagar_por_fornecedor'];

                                    usort($fornecedores, function($a, $b) {
                                        return $b['total_contas'] <=> $a['total_contas'];
                                    });

                                    // Definir limite de fornecedores
                                    $MAX_FORNECEDORES = 6;

                                    // Calcular total geral
                                    $totalContasFornecedores = array_sum(array_column($fornecedores, 'total_contas'));

                                    // Verificar se há mais fornecedores que o máximo
                                    if (count($fornecedores) > $MAX_FORNECEDORES) {
                                        // Separar top fornecedores e calcular outros
                                        $topFornecedores = array_slice($fornecedores, 0, $MAX_FORNECEDORES - 1);
                                        $outrosFornecedores = array_slice($fornecedores, $MAX_FORNECEDORES - 1);

                                        // Calcular total de outros fornecedores
                                        $totalOutrosFornecedores = array_sum(array_column($outrosFornecedores, 'total_contas'));

                                        // Adicionar entrada de outros fornecedores
                                        $topFornecedores[] = [
                                            'nome_fantasia' => 'Outros Fornecedores',
                                            'total_contas' => $totalOutrosFornecedores
                                        ];
                                    } else {
                                        // Se não houver mais fornecedores que o máximo, usar a lista original
                                        $topFornecedores = $fornecedores;
                                    }

                                    // Iterar sobre fornecedores
                                    foreach ($topFornecedores as $fornecedor): 
                                        $percentual = $totalContasFornecedores > 0 
                                            ? round(($fornecedor['total_contas'] / $totalContasFornecedores) * 100, 1) 
                                            : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <span class="avatar avatar-sm">
                                                        <i class="ti ti-truck <?= $fornecedor['nome_fantasia'] === 'Outros Fornecedores' ? 'text-muted' : '' ?>"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 <?= $fornecedor['nome_fantasia'] === 'Outros Fornecedores' ? 'text-muted' : '' ?>">
                                                        <?= $fornecedor['nome_fantasia'] ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-dark" role="progressbar" 
                                                    style="width: <?= $percentual ?>%; 
                                                        background-color: <?= $fornecedor['nome_fantasia'] === 'Outros Fornecedores' ? 'rgba(128,128,128,0.6)' : 'rgba(54, 162, 235, 0.6)' ?>">
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

        <!-- Contas por Cliente -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contas a Receber por Cliente</h4>
                </div>
                <div class="card-body pb-0">
                    <div class="chart-container">
                        <canvas id="contasReceberPorClienteChart" height="300"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="table-responsive">
                            <!--
                            <table class="table mb-0" style="width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Cliente</th>
                                        <th></th>
                                        <th class="text-right">Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalContasClientes = array_sum(array_column($graficosContasReceber['contas_receber_por_cliente'], 'total_contas'));

                                    foreach ($graficosContasReceber['contas_receber_por_cliente'] as $cliente): 
                                        $percentual = $totalContasClientes > 0 
                                            ? round(($cliente['total_contas'] / $totalContasClientes) * 100, 1) 
                                            : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <span class="avatar avatar-sm">
                                                        <i class="ti ti-medall"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= $cliente['nome_fantasia'] ?></h6>
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
                                            R$ <?= number_format($cliente['total_contas'], 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            -->
                            <table class="table mb-0" style="width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Cliente</th>
                                        <th></th>
                                        <th class="text-right">Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Ordenar clientes por total de contas, do maior para o menor
                                    $clientes = $graficosContasReceber['contas_receber_por_cliente'];
                                    
                                    usort($clientes, function($a, $b) {
                                        return $b['total_contas'] <=> $a['total_contas'];
                                    });

                                    // Definir limite de clientes
                                    $MAX_CLIENTES = 6;

                                    // Calcular total geral
                                    $totalContasClientes = array_sum(array_column($clientes, 'total_contas'));

                                    // Verificar se há mais clientes que o máximo
                                    if (count($clientes) > $MAX_CLIENTES) {
                                        // Separar top clientes e calcular outros
                                        $topClientes = array_slice($clientes, 0, $MAX_CLIENTES - 1);
                                        $outrosClientes = array_slice($clientes, $MAX_CLIENTES - 1);

                                        // Calcular total de outros clientes
                                        $totalOutrosClientes = array_sum(array_column($outrosClientes, 'total_contas'));

                                        // Adicionar entrada de outros clientes
                                        $topClientes[] = [
                                            'nome_fantasia' => 'Outros Clientes',
                                            'total_contas' => $totalOutrosClientes
                                        ];
                                    } else {
                                        // Se não houver mais clientes que o máximo, usar a lista original
                                        $topClientes = $clientes;
                                    }

                                    // Iterar sobre clientes
                                    foreach ($topClientes as $cliente): 
                                        $percentual = $totalContasClientes > 0 
                                            ? round(($cliente['total_contas'] / $totalContasClientes) * 100, 1) 
                                            : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <span class="avatar avatar-sm">
                                                        <i class="ti ti-medall <?= $cliente['nome_fantasia'] === 'Outros Clientes' ? 'text-muted' : '' ?>"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 <?= $cliente['nome_fantasia'] === 'Outros Clientes' ? 'text-muted' : '' ?>">
                                                        <?= $cliente['nome_fantasia'] ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-dark" role="progressbar" 
                                                    style="width: <?= $percentual ?>%; 
                                                        background-color: <?= $cliente['nome_fantasia'] === 'Outros Clientes' ? 'rgba(128,128,128,0.6)' : 'rgba(54, 162, 235, 0.6)' ?>">
                                                    <?= $percentual ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            R$ <?= number_format($cliente['total_contas'], 2, ',', '.') ?>
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
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const statusContasPagarChart = document.getElementById('statusContasPagarChart');
        const contasPagarPorFornecedorChart = document.getElementById('contasPagarPorFornecedorChart');

        if (!statusContasPagarChart || !contasPagarPorFornecedorChart) {
            console.warn('Um ou mais elementos de gráfico não encontrados');
            return;
        }

        const statusColors = <?= json_encode($statusColors) ?>;

        // Gráfico de Status das Contas a Pagar - Início
        var statusContasPagarCtx = statusContasPagarChart.getContext('2d');

        // Dados dos status das contas a pagar
        var statusContasPagarRaw = <?= json_encode($graficosContasPagar['status_contas_pagar']) ?>.map(item => ({
            ...item,
            total: parseFloat(item.total) || 0
        }));

        // Calcular o valor total a pagar
        var totalValorPagar = statusContasPagarRaw.reduce((sum, item) => sum + item.total, 0);

        // Preparar dados para o gráfico de Status das Contas a Pagar
        var statusContasPagarData = {
            labels: statusContasPagarRaw.map(item => item.status),
            datasets: [{
                data: statusContasPagarRaw.map(item => item.total),
                backgroundColor: statusContasPagarRaw.map(item => 
                    statusColors[item.status.toUpperCase()] || '#6c757d'
                )
            }]
        };

        // Criar o gráfico de Status das Contas a Pagar
        new Chart(statusContasPagarCtx, {
            type: 'doughnut',
            data: statusContasPagarData,
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
        // Gráfico de Status das Contas a Pagar - Fim

        // Gráfico de Contas a Pagar por Fornecedor - Inicio
        var contasPagarPorFornecedorCtx = contasPagarPorFornecedorChart.getContext('2d');

        // Definir número máximo de fornecedores a exibir
        const MAX_FORNECEDORES = 6;

        // Dados dos fornecedores
        var contasPagarPorFornecedorRaw = <?= json_encode($graficosContasPagar['contas_pagar_por_fornecedor']) ?>.map(item => ({
            ...item,
            total_contas: parseFloat(item.total_contas) || 0
        }));

        // Verificar se há mais fornecedores que o máximo
        if (contasPagarPorFornecedorRaw.length > MAX_FORNECEDORES) {
            // Ordenar do maior para o menor
            contasPagarPorFornecedorRaw.sort((a, b) => b.total_valor - a.total_valor);
            
            // Pegar os top MAX_FORNECEDORES - 1
            const topFornecedores = contasPagarPorFornecedorRaw.slice(0, MAX_FORNECEDORES - 1);
            
            // Calcular o valor total dos demais fornecedores
            const outrosValor = contasPagarPorFornecedorRaw
                .slice(MAX_FORNECEDORES - 1)
                .reduce((sum, item) => sum + item.total_contas, 0);
            
            // Adicionar categoria "Outros"
            topFornecedores.push({
                nome_fantasia: 'Outros Fornecedores',
                total_contas: outrosValor
            });
            
            // Substituir os dados originais
            contasPagarPorFornecedorRaw = topFornecedores;
        }

        // Calcular o valor total
        var totalValorFornecedores = contasPagarPorFornecedorRaw.reduce((sum, item) => sum + item.total_contas, 0);

        // Preparar dados para o gráfico
        var contasPagarPorFornecedorData = {
            labels: contasPagarPorFornecedorRaw.map(item => item.nome_fantasia),
            datasets: [{
                data: contasPagarPorFornecedorRaw.map(item => item.total_contas),
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        };

        // Criar o gráfico de Contas a Pagar por Fornecedor
        new Chart(contasPagarPorFornecedorCtx, {
            type: 'bar',
            data: contasPagarPorFornecedorData,
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
        // Gráfico de Contas a Pagar por Fornecedor - Fim
    });

    document.addEventListener('DOMContentLoaded', function() {
        const statusContasReceberChart = document.getElementById('statusContasReceberChart');
        const contasReceberPorClienteChart = document.getElementById('contasReceberPorClienteChart');

        if (!statusContasReceberChart || !contasReceberPorClienteChart) {
            console.warn('Um ou mais elementos de gráfico não encontrados');
            return;
        }

        const statusColors = <?= json_encode($statusColors) ?>;

        // Gráfico de Status das Contas a Receber - Início
        var statusContasReceberCtx = statusContasReceberChart.getContext('2d');
        
        // Dados dos status das contas a receber
        var statusContasReceberRaw = <?= json_encode($graficosContasReceber['status_contas_receber']) ?>.map(item => ({
            ...item,
            total: parseFloat(item.total) || 0
        }));
        
        // Calcular o valor total a receber
        var totalValorReceber = statusContasReceberRaw.reduce((sum, item) => sum + item.total, 0);

        // Preparar dados para o gráfico de Status das Contas a Receber
        var statusContasReceberData = {
            labels: statusContasReceberRaw.map(item => item.status),
            datasets: [{
                data: statusContasReceberRaw.map(item => item.total),
                backgroundColor: statusContasReceberRaw.map(item => 
                    statusColors[item.status.toUpperCase()] || '#6c757d'
                )
            }]
        };

        // Criar o gráfico de Status das Contas a Receber
        new Chart(statusContasReceberCtx, {
            type: 'pie',
            data: {
                labels: statusContasReceberRaw.map(item => item.status),
                datasets: [{
                    label: 'Contas a Receber',
                    data: statusContasReceberRaw.map(item => item.total),
                    backgroundColor: statusContasReceberRaw.map(item => 
                        statusColors[item.status.toUpperCase()] || 'rgba(54, 162, 235, 0.6)'
                    ),
                    hoverOffset: 15 // Efeito de destaque ao passar o mouse
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom', // Legenda na parte inferior
                        labels: {
                            usePointStyle: true, // Ícones arredondados na legenda
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const currentValue = context.parsed;
                                const percentage = total > 0 
                                    ? ((currentValue/total) * 100).toFixed(1) 
                                    : '0.0';
                                return `R$ ${currentValue.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (${percentage}%)`;
                            }
                        }
                    },
                    animation: {
                        animateRotate: true, // Animação de rotação
                        animateScale: true  // Animação de escala
                    }
                }
            }
        });
        // Gráfico de Status das Contas a Receber - Fim

        // Gráfico de Contas a Receber por Cliente - Inicio
        var contasReceberPorClienteCtx = contasReceberPorClienteChart.getContext('2d');

        // Definir número máximo de clientes a exibir
        const MAX_CLIENTES = 6;

        // Dados dos clientes
        var contasReceberPorClienteRaw = <?= json_encode($graficosContasReceber['contas_receber_por_cliente']) ?>.map(item => ({
            ...item,
            total_contas: parseFloat(item.total_contas) || 0
        }));
        
        // Verificar se há mais clientes que o máximo
        if (contasReceberPorClienteRaw.length > MAX_CLIENTES) {
            // Ordenar do maior para o menor
            contasReceberPorClienteRaw.sort((a, b) => b.total_contas - a.total_contas);
            
            // Pegar os top MAX_CLIENTES - 1
            const topClientes = contasReceberPorClienteRaw.slice(0, MAX_CLIENTES - 1);
            
            // Calcular o valor total dos demais clientes
            const outrosValorReceber = contasReceberPorClienteRaw
                .slice(MAX_CLIENTES - 1)
                .reduce((sum, item) => sum + item.total_contas, 0);
            
            // Adicionar categoria "Outros"
            topClientes.push({
                nome_fantasia: 'Outros Clientes',
                total_contas: outrosValorReceber
            });
            
            // Substituir os dados originais
            contasReceberPorClienteRaw = topClientes;
        }

        // Calcular o valor total
        var totalValorClientes = contasReceberPorClienteRaw.reduce((sum, item) => sum + item.total_contas, 0);

        // Preparar dados para o gráfico
        var contasReceberPorClienteData = {
            labels: contasReceberPorClienteRaw.map(item => item.nome_fantasia),
            datasets: [{
                data: contasReceberPorClienteRaw.map(item => item.total_contas),
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        };
        
        // Gráfico de Contas a Receber por Cliente
        var contasReceberPorClienteCtx = contasReceberPorClienteChart.getContext('2d');

        // Criar o gráfico de Contas a Receber por Cliente
        if (contasReceberPorClienteRaw && contasReceberPorClienteRaw.length > 0) {
            new Chart(contasReceberPorClienteCtx, {
                type: 'line',
                data: {
                    labels: contasReceberPorClienteRaw.map(item => item.nome_fantasia || 'Cliente Desconhecido'),
                    datasets: [{
                        label: 'Contas a Receber por Cliente',
                        data: contasReceberPorClienteRaw.map(item => item.total_contas || 0),
                        borderColor: 'rgba(75, 192, 192, 1)', 
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', 
                        tension: 0.4,
                        fill: true,
                        pointRadius: 7,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointHoverRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const currentValue = context.parsed.y;
                                    const percentage = total > 0 
                                        ? ((currentValue/total) * 100).toFixed(1) 
                                        : '0.0';
                                    return `R$ ${currentValue.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Valor Recebido (R$)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Clientes'
                            }
                        }
                    }
                }
            });
        } else {
            contasReceberPorClienteChart.innerHTML = '<p>Sem dados disponíveis</p>';
        }
    });
</script>
<?= $this->endSection() ?>