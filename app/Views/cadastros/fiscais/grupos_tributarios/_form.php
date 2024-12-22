                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-9">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="100" required />
                                </div>
                                <div class="col-md-3">
                                    <label for="tipo_grupo" data-toggle="tooltip" data-original-title="Tipo">Tipo</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="tipo_grupo" data-plugin-options='{ "allowClear": false }' required>
                                        <option value=""></option>
                                        <option value="ICMS" <?php echo $table->tipo_grupo == 'ICMS' ? 'selected' : ''; ?>>ICMS</option>
                                        <option value="ISS" <?php echo $table->tipo_grupo == 'ISS' ? 'selected' : ''; ?>>ISS</option>
                                        <option value="NF" <?php echo $table->tipo_grupo == 'NF' ? 'selected' : ''; ?>>NÃO FISCAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="tipo_tributacao" data-toggle="tooltip" data-original-title="Tipo">Tipo de Tributação</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="tipo_tributacao" data-plugin-options='{ "allowClear": false }' required>
                                        <option value=""></option>
                                        <option value="TR" <?php echo $table->tipo_tributacao == 'TR' ? 'selected' : ''; ?>>TRIBUTADA</option>
                                        <option value="ST" <?php echo $table->tipo_tributacao == 'ST' ? 'selected' : ''; ?>>SUBSTITUIÇÃO TRIBUTÁRIA</option>
                                        <option value="IS" <?php echo $table->tipo_tributacao == 'IS' ? 'selected' : ''; ?>>ISENTA</option>
                                        <option value="NT" <?php echo $table->tipo_tributacao == 'NT' ? 'selected' : ''; ?>>NÃO TRIBUTADA</option>
                                        <option value="DC" <?php echo $table->tipo_tributacao == 'DC' ? 'selected' : ''; ?>>DESCONTOS</option>
                                        <option value="AC" <?php echo $table->tipo_tributacao == 'AC' ? 'selected' : ''; ?>>ACRÉSCIMOS</option>
                                        <option value="CN" <?php echo $table->tipo_tributacao == 'CN' ? 'selected' : ''; ?>>CANCELAMENTOS</option>
                                        <option value="NF" <?php echo $table->tipo_tributacao == 'NF' ? 'selected' : ''; ?>>NÃO FISCAL</option>
                                        <option value="OU" <?php echo $table->tipo_tributacao == 'OU' ? 'selected' : ''; ?>>OUTRAS OPERAÇÕES</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">
                                    <label for="aliquota">Alíquota (%)</label>
                                    <input type="text" class="form-control input-sm text-right" name="aliquota" placeholder="Alíquota (%)" value="<?php echo formatPercent($table->aliquota, false, 2); ?>" maxlength="16" />
                                </div>
                                <div class="col-md-2">
                                    <label for="reducao">Redução (%)</label>
                                    <input type="text" class="form-control input-sm text-right" name="reducao" placeholder="Redução (%)" value="<?php echo formatPercent($table->reducao, false, 2); ?>" maxlength="16" />
                                </div>
                                <div class="col-md-2">
                                    <label for="cst">CST</label>
                                    <input type="text" class="form-control input-sm" name="cst" placeholder="CST" value="<?php echo $table->cst; ?>" maxlength="3" required />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/custom/grupos_tributarios_form.js"></script>