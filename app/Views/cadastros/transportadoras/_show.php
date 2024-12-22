            <div class="modal-wrapper-custom">
                <fieldset class="border pt-4 pb-4 pr-4 pl-4 mb-2 rounded">
                    <div class="pr-4 pl-4">
                        <div class="row row-title">
                            <div class="col-md-1">
                                <span class="text-bold">ID</span>
                            </div>
                            <div class="col-md-2">
                                <span class="text-bold" id="cnpj-label">CNPJ</span>
                            </div>
                            <div class="col-md-2">
                                <span class="text-bold" id="ie-label">INSCR. ESTADUAL</span>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-1">
                                <span class="text-bold">STATUS</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-1">
                                <span><?php echo $transportadora->id; ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $transportadora->cnpj; ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $transportadora->inscricao_estadual; ?></span>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-1">
                                <?php echo ($transportadora->active == true ? '<span class="text-success">ATIVO</span>' : '<span class="text-danger">INATIVO</span>'); ?>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-8">
                                <span class="text-bold" id="razao-label">RAZÃO SOCIAL</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-bold" id="fantasia-label">NOME FANTASIA</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-8">
                                <span><?php echo $transportadora->razao_social; ?></span>
                            </div>
                            <div class="col-md-4">
                                <span><?php echo $transportadora->nome_fantasia; ?></span>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-3">
                                <span class="text-bold">TELEFONE</span>
                            </div>
                            <div class="col-md-3">
                                <span class="text-bold">CELULAR</span>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-3">
                                <span><?php echo $transportadora->telefone; ?></span>
                            </div>
                            <div class="col-md-3">
                                <span><?php echo $transportadora->celular; ?></span>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-6">
                                <span class="text-bold">E-MAIL</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-6">
                                <span><?php echo $transportadora->email; ?></span>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-12">
                                <span class="text-bold">OBSERVAÇÕES</span>
                            </div>
                        </div>
                        <div class="row row-textarea">
                            <div class="col-md-12">
                                <span><?php echo $transportadora->obs; ?></span>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-12">
                                <span class="text-bold">VEÍCULOS</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-12">
                                <div id="tableWrapper" style="min-height: 120px; max-height: 120px; overflow-y: auto;">
                                    <table id="table-veiculos" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th>PLACA</th>
                                                <th>UF</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista-veiculos">
                                            <?php foreach ($veiculos as $veiculo) : ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="vei_id[]" value="<?php echo $veiculo->id; ?>" />
                                                        <input type="hidden" name="vei_placa[]" value="<?php echo $veiculo->placa; ?>" />
                                                        <span><?php echo $veiculo->placa; ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="vei_uf[]" value="<?php echo $veiculo->uf; ?>" />
                                                        <span><?php echo $veiculo->uf; ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="panel-featured panel-featured-custom text-custom">
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-4">
                        <span class="text-primary">
                            <i class="fas fa-clock"></i><strong> Última Atualização:</strong> <?php echo formatDateTime($transportadora->updated_at); ?>
                        </span>
                    </div>
                </div>
            </div>