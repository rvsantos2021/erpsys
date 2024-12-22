                <div class="form-row">
                    <div class="form-group col-md-2">
                        <div class="text-center">
                            <?php if ($fornecedor->photo == null) : ?>
                                <img src="<?= site_url('assets/images/avatar-fornecedor.png'); ?>" class="rounded-circle" alt="Fornecedor" />
                            <?php else : ?>
                                <img src="<?= site_url("fornecedores/show_photo/$fornecedor->photo"); ?>" class="rounded-circle" alt="Foto do Fornecedor" />
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label id="labelCNPJ">CNPJ</label>
                                    <input type="text" class="form-control" name="cnpj" value="<?php echo $fornecedor->cnpj; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label id="labelIE">Inscr. Estadual</label>
                                    <input type="text" class="form-control" name="inscricao_estadual" value="<?php echo $fornecedor->inscricao_estadual; ?>" disabled />
                                </div>
                                <div class="form-group col-md-8">
                                    <div class="form-check float-right">
                                        <input type="radio" class="form-check-input" id="tipo-pf" name="tipo" value="F" <?= ($fornecedor->tipo == 'F' ? 'checked' : ''); ?> disabled />
                                        <label for="tipo-pf" class="form-check-label">Pessoa Física</label>
                                    </div>
                                    <div class="form-check float-right">
                                        <input type="radio" class="form-check-input" id="tipo-pj" name="tipo" value="J" <?= ($fornecedor->tipo == 'J' ? 'checked' : ''); ?> disabled />
                                        <label for="tipo-pj" class="form-check-label">Pessoa Jurídica</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label id="labelRazao">Razão Social</label>
                                    <input type="text" class="form-control" name="razao_social" value="<?php echo $fornecedor->razao_social; ?>" disabled />
                                </div>
                                <div class="form-group col-md-5">
                                    <label id="labelFantasia">Nome Fantasia</label>
                                    <input type="text" class="form-control" name="nome_fantasia" value="<?php echo $fornecedor->nome_fantasia; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-comment"></i> Contato</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control inputmask" name="telefone" value="<?php echo $fornecedor->telefone; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control inputmask" name="celular" value="<?php echo $fornecedor->celular; ?>" disabled />
                                </div>
                                <div class="form-group col-md-8">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $fornecedor->email; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-file-text"></i> Informações Adicionais</legend>
                            <div class="form-frow">
                                <textarea class="form-control" rows="2" name="obs" disabled><?php echo $fornecedor->obs; ?></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-map-marker"></i> Endereços</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="tableWrapper" style="min-height: 120px; max-height: 120px; overflow-y: auto;">
                                        <table id="table-enderecos" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>CEP</th>
                                                    <th>Logradouro</th>
                                                    <th>Número</th>
                                                    <th>Complemnto</th>
                                                    <th>Bairro</th>
                                                    <th>Cidade/UF</th>
                                                    <th>Tipo de End.</th>
                                                    <th class="text-center col-xs-1">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lista-enderecos">
                                                <?php foreach ($enderecos as $endereco) : ?>
                                                    <tr>
                                                        <td>
                                                            <span><?php echo $endereco->cep; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $endereco->logradouro; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $endereco->numero; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $endereco->complemento; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $endereco->bairro; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo $endereco->cidade . '/' . $endereco->uf; ?></span>
                                                        </td>
                                                        <td>
                                                            <span><?php echo setTipoEndereco($endereco->tipo); ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-sm btn-icon btn-outline-danger btn-round" disabled>
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="ti ti-info-alt"></i> Logs</legend>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Cadastrado em</label>
                                    <input type="text" class="form-control" name="created_at" value="<?= formatDateTime($fornecedor->created_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Última atualização</label>
                                    <input type="text" class="form-control" name="updated_at" value="<?= formatDateTime($fornecedor->updated_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Excluído em</label>
                                    <input type="text" class="form-control" name="deleted_at" value="<?= formatDateTime($fornecedor->deleted_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-check float-right">
                                        <input type="checkbox" class="form-check-input" name="active" <?= ($fornecedor->active == 1 ? 'checked' : ''); ?> />
                                        <label>Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>