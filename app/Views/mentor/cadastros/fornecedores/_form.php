                <div class="form-row">
                    <div class="form-group col-md-2">
                        <div class="text-center">
                            <?php if ($table->photo == null) : ?>
                                <img src="<?= site_url('assets/images/avatar-fornecedor.png'); ?>" class="rounded-circle" alt="Fornecedor" />
                            <?php else : ?>
                                <img src="<?= site_url("fornecedores/show_photo/$table->photo"); ?>" class="rounded-circle" alt="Foto do Fornecedor" />
                            <?php endif; ?>
                        </div>
                        <div class="text-center">
                            <?php if ($method == "update") : ?>
                                <a href="#" class="btn btn-primary btn-sm mt-3 openPopupPhoto">Alterar Foto</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label id="labelCNPJ">CNPJ</label>
                                    <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ" value="<?php echo $table->cnpj; ?>" data-mask="99.999.999/9999-99" required />
                                    <input type="text" class="form-control invisible" name="cnpj" id="cpf" placeholder="CPF" value="<?php echo $table->cnpj; ?>" data-mask="999.999.999-99" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label id="labelIE">Inscr. Estadual</label>
                                    <input type="text" class="form-control" name="inscricao_estadual" placeholder="Inscr. Estadual" value="<?php echo $table->inscricao_estadual; ?>" />
                                </div>
                                <div class="form-group col-md-8">
                                    <div class="form-check float-right">
                                        <input type="radio" class="form-check-input" id="tipo-pf" name="tipo" value="F" <?= ($table->tipo == 'F' ? 'checked' : ''); ?> />
                                        <label for="tipo-pf" class="form-check-label">Pessoa Física</label>
                                    </div>
                                    <div class="form-check float-right">
                                        <input type="radio" class="form-check-input" id="tipo-pj" name="tipo" value="J" <?= ($table->tipo == 'J' ? 'checked' : ''); ?> />
                                        <label for="tipo-pj" class="form-check-label">Pessoa Jurídica</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label id="labelRazao">Razão Social</label>
                                    <input type="text" class="form-control" name="razao_social" placeholder="Razão Social" value="<?php echo $table->razao_social; ?>" required />
                                </div>
                                <div class="form-group col-md-5">
                                    <label id="labelFantasia">Nome Fantasia</label>
                                    <input type="text" class="form-control" name="nome_fantasia" placeholder="Nome Fantasia" value="<?php echo $table->nome_fantasia; ?>" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-comment"></i> Contato</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control inputmask" name="telefone" placeholder="Telefone" value="<?php echo $table->telefone; ?>" data-mask="(99) 9999-9999" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control inputmask" name="celular" placeholder="Celular" value="<?php echo $table->celular; ?>" data-mask="(99) 99999-9999" />
                                </div>
                                <div class="form-group col-md-8">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?php echo $table->email; ?>" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-file-text"></i> Informações Adicionais</legend>
                            <div class="form-frow">
                                <textarea class="form-control" rows="2" name="obs"><?php echo $table->obs; ?></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-map-marker"></i> Endereços</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>CEP</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control inputmask" name="cep" placeholder="CEP" data-mask="99999-999" val="" />
                                        <span class="input-group-append">
                                            <button class="btn btn-primary btn-cep" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    <span class="error cep-error"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Logradouro</label>
                                    <input type="text" class="form-control" name="logradouro" placeholder="Logradouro" />
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Número</label>
                                    <input type="text" class="form-control" name="numero" placeholder="Número" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Complemento</label>
                                    <input type="text" class="form-control" name="complemento" placeholder="Complemento" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control input-sm" name="bairro" placeholder="Bairro" />
                                </div>
                                <div class="form-group selects-contant col-md-4">
                                    <label for="cidade">Cidade / UF</label>
                                    <select class="js-basic-single form-control" name="cidade" id="cidade" data-js-container=".modal">
                                        <option value=""></option>
                                        <?php foreach ($cidades as $cidade) : ?>
                                            <option value="<?= (int)$cidade->id; ?>">
                                                <?= esc($cidade->nome) . '/' . esc($cidade->uf); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group selects-contant col-md-2">
                                    <label for="tipo_end">Tipo de Endereço</label>
                                    <select class="js-basic-single form-control" name="tipo_end" id="tipo_end" data-js-container=".modal">
                                        <option></option>
                                        <option value="R">Residencial</option>
                                        <option value="C">Comercial</option>
                                        <option value="F">Cobrança</option>
                                        <option value="E">Entrega</option>
                                    </select>
                                    <input type="hidden" name="cidade_id" />
                                    <input type="hidden" name="cidade_nome" />
                                    <input type="hidden" name="cidade_uf" />
                                </div>
                                <div class="form-group col-md-1 text-right">
                                    <button type="button" class="btn btn-primary mt-26 btn-add-end"><i class="fa fa-arrow-circle-down"></i></button>
                                </div>
                            </div>
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
                                                        <td class="text-center">
                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-end"><i class="ti ti-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?= $this->include('mentor/layout/_response'); ?>