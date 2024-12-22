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
                                <span><?php echo $fornecedor->id; ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $fornecedor->cnpj; ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $fornecedor->inscricao_estadual; ?></span>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-1">
                                <?php echo ($fornecedor->active == true ? '<span class="text-success">ATIVO</span>' : '<span class="text-danger">INATIVO</span>'); ?>
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
                                <span><?php echo $fornecedor->razao_social; ?></span>
                            </div>
                            <div class="col-md-4">
                                <span><?php echo $fornecedor->nome_fantasia; ?></span>
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
                                <span class="text-bold">DATA FUNDAÇÃO</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-3">
                                <span><?php echo $fornecedor->telefone; ?></span>
                            </div>
                            <div class="col-md-3">
                                <span><?php echo $fornecedor->celular; ?></span>
                            </div>
                            <div class="col-md-6">
                                <span><?php echo formatDate($fornecedor->data_nascimento); ?></span>
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
                                <span><?php echo $fornecedor->email; ?></span>
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
                                <span><?php echo $fornecedor->obs; ?></span>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-12">
                                <span class="text-bold">ENDEREÇOS</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-12">
                                <div id="tableWrapper" style="min-height: 120px; max-height: 120px; overflow-y: auto;">
                                    <table id="table-enderecos" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th>CEP</th>
                                                <th>LOGRADOURO</th>
                                                <th>NÚMERO</th>
                                                <th>COMPLEMENTO</th>
                                                <th>BAIRRO</th>
                                                <th>CIDADE/UF</th>
                                                <th>TIPO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista-enderecos">
                                            <?php foreach ($enderecos as $endereco) : ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="end_id[]" value="<?php echo $endereco->id; ?>" />
                                                        <input type="hidden" name="end_cep[]" value="<?php echo $endereco->cep; ?>" />
                                                        <span><?php echo $endereco->cep; ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="end_log[]" value="<?php echo $endereco->logradouro; ?>" />
                                                        <span><?php echo $endereco->logradouro; ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="end_nro[]" value="<?php echo $endereco->numero; ?>" />
                                                        <span><?php echo $endereco->numero; ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="end_cpl[]" value="<?php echo $endereco->complemento; ?>" />
                                                        <span><?php echo $endereco->complemento; ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="end_bai[]" value="<?php echo $endereco->bairro; ?>" />
                                                        <span><?php echo $endereco->bairro; ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="end_cid[]" value="<?php echo $endereco->cidade_id; ?>" />
                                                        <span><?php echo $endereco->cidade . '/' . $endereco->uf; ?></span>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="end_tip[]" value="<?php echo $endereco->tipo; ?>" />
                                                        <span><?php echo setTipoEndereco($endereco->tipo); ?></span>
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
                            <i class="fas fa-clock"></i><strong> Última Atualização:</strong> <?php echo formatDateTime($fornecedor->updated_at); ?>
                        </span>
                    </div>
                </div>
            </div>