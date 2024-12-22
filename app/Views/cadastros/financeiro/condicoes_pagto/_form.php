                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control input-sm" name="nome" placeholder="Condição de Pagamento" value="<?php echo $table->nome; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label for="tabela_id" data-toggle="tooltip" data-original-title="Tabela de Preço">Tabela de Preço</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="tabela_id" data-plugin-options='{ "allowClear": true }' required>
                                        <option value=""></option>
                                        <?php foreach ($tabelas as $tabela) : ?>
                                            <option value="<?php echo $tabela->id; ?>" <?php echo ($table->tabela_id === $tabela->id ? 'selected' : ''); ?>><?php echo $tabela->descricao; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="entrada" data-toggle="tooltip" data-original-title="Exige percentual de entrada">Exige Entrada</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="entrada" data-plugin-options='{ "allowClear": true }' required>
                                        <option value=""></option>
                                        <option value="1" <?php echo $table->entrada == 1 ? 'selected' : ''; ?>>SIM</option>
                                        <option value="0" <?php echo $table->entrada == 0 ? 'selected' : ''; ?>>NÃO</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="perc_entrada" data-toggle="tooltip" data-original-title="Percentual de entrada">% Entrada</label>
                                    <input type="number" class="form-control input-sm" name="perc_entrada" value="<?php echo $table->perc_entrada; ?>" min="0" max="100" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="qtd_parcelas" data-toggle="tooltip" data-original-title="Quantidade de parcelas">Parcelas</label>
                                    <input type="number" class="form-control input-sm" name="qtd_parcelas" value="<?php echo $table->qtd_parcelas; ?>" min="1" max="60" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="dias_parcela1" data-toggle="tooltip" data-original-title="Número de dias para 1ª parcela">1ª parc.</label>
                                    <input type="number" class="form-control input-sm" name="dias_parcela1" value="<?php echo $table->dias_parcela1; ?>" min="0" max="180" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="dias_parcelas" data-toggle="tooltip" data-original-title="Número de dias entre parcelas">Entre parcelas</label>
                                    <input type="number" class="form-control input-sm" name="dias_parcelas" value="<?php echo $table->dias_parcelas; ?>" min="0" max="180" required />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>