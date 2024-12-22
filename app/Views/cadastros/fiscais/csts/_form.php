                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="cst">CST / CSOSN</label>
                                    <input type="text" class="form-control input-sm" name="cst" placeholder="CST / CSOSN" value="<?php echo $table->cst; ?>" maxlength="3" required />
                                </div>
                                <div class="col-md-10">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="100" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="tabela" data-toggle="tooltip" data-original-title="Tabela">Tabela</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="tabela" data-plugin-options='{ "allowClear": false }' required>
                                        <option value=""></option>
                                        <option value="ICMS" <?php echo $table->tabela == 'ICMS' ? 'selected' : ''; ?>>ICMS</option>
                                        <option value="IPI" <?php echo $table->tabela == 'IPI' ? 'selected' : ''; ?>>IPI</option>
                                        <option value="PIS/COFINS" <?php echo $table->tabela == 'PIS/COFINS' ? 'selected' : ''; ?>>PIS/COFINS</option>
                                        <option value="CSOSN" <?php echo $table->tabela == 'CSOSN' ? 'selected' : ''; ?>>CSOSN</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="operacao" data-toggle="tooltip" data-original-title="Operação">Operação</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="operacao" data-plugin-options='{ "allowClear": false }' required>
                                        <option value=""></option>
                                        <option value="A" <?php echo $table->operacao == 'A' ? 'selected' : ''; ?>>AMBAS</option>
                                        <option value="E" <?php echo $table->operacao == 'E' ? 'selected' : ''; ?>>ENTRADA</option>
                                        <option value="S" <?php echo $table->operacao == 'S' ? 'selected' : ''; ?>>SAÍDA</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>