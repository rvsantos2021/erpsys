                <div class="form-row">
                    <div class="form-group col-md-2">
                        <div class="text-center">
                            <img src="<?php echo site_url('assets/images/avatar-vendedor.png'); ?>" class="rounded-circle" alt="Vendedor" />
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <fieldset class="border pb-2 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label id="labelCNPJ">CNPJ</label>
                                    <input type="text" class="form-control" name="cnpj" value="<?php echo $table->cnpj; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label id="labelIE">Inscr. Estadual</label>
                                    <input type="text" class="form-control" name="inscricao_estadual" value="<?php echo $table->inscricao_estadual; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_nascimento" id="labelData">Data Fundação</label>
                                    <input type="date" class="form-control" name="data_nascimento" value="<?php echo $table->data_nascimento; ?>" disabled />
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-check float-right">
                                        <input type="radio" class="form-check-input" id="tipo-pf" name="tipo" value="F" <?php echo $table->tipo == 'F' ? 'checked' : ''; ?> disabled />
                                        <label for="tipo-pf" class="form-check-label">Pessoa Física</label>
                                    </div>
                                    <div class="form-check float-right">
                                        <input type="radio" class="form-check-input" id="tipo-pj" name="tipo" value="J" <?php echo $table->tipo == 'J' ? 'checked' : ''; ?> disabled />
                                        <label for="tipo-pj" class="form-check-label">Pessoa Jurídica</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label id="labelRazao">Razão Social</label>
                                    <input type="text" class="form-control" name="razao_social" value="<?php echo $table->razao_social; ?>" disabled />
                                </div>
                                <div class="form-group col-md-5">
                                    <label id="labelFantasia">Nome Fantasia</label>
                                    <input type="text" class="form-control" name="nome_fantasia" value="<?php echo $table->nome_fantasia; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-2 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-comment"></i> Contato</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control inputmask" name="telefone" value="<?php echo $table->telefone; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control inputmask" name="celular" value="<?php echo $table->celular; ?>" disabled />
                                </div>
                                <div class="form-group col-md-8">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $table->email; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-2 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-money"></i> Financeiro</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="perc_comissao">% Comissão</label>
                                    <input type="text" class="form-control text-right" name="perc_comissao" placeholder="Ex.: 2,00%" value="<?php echo formatPercent($table->perc_comissao, false); ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-file-text"></i> Informações Adicionais</legend>
                            <div class="form-frow">
                                <textarea class="form-control" rows="2" name="obs" disabled><?php echo $table->obs; ?></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-2 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="ti ti-info-alt"></i> Logs</legend>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Cadastrado em</label>
                                    <input type="text" class="form-control" name="created_at" value="<?php echo formatDateTime($table->created_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Última atualização</label>
                                    <input type="text" class="form-control" name="updated_at" value="<?php echo formatDateTime($table->updated_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Excluído em</label>
                                    <input type="text" class="form-control" name="deleted_at" value="<?php echo formatDateTime($table->deleted_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-check float-right">
                                        <input type="checkbox" class="form-check-input" name="active" <?php echo $table->active == 1 ? 'checked' : ''; ?> />
                                        <label>Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- custom app -->
                <script src="<?php echo site_url('mentor/assets/'); ?>js/cadastros/vendedores_form.js"></script>