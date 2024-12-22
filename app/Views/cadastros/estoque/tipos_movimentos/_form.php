                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="100" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="movimento" data-toggle="tooltip" data-original-title="Movimento">Tipo</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="movimento" data-plugin-options='{ "allowClear": false }' required>
                                        <option value=""></option>
                                        <option value="E" <?php echo $table->movimento == 'E' ? 'selected' : ''; ?>>ENTRADA</option>
                                        <option value="S" <?php echo $table->movimento == 'S' ? 'selected' : ''; ?>>SAÍDA</option>
                                        <option value="T" <?php echo $table->movimento == 'T' ? 'selected' : ''; ?>>TRANSFERÊNCIA</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="estoque" data-toggle="tooltip" data-original-title="Tipo">Mov. Estoque</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="estoque" data-plugin-options='{ "allowClear": false }' required>
                                        <option value=""></option>
                                        <option value="1" <?php echo $table->estoque == 1 ? 'selected' : ''; ?>>SIM</option>
                                        <option value="0" <?php echo $table->estoque == 0 ? 'selected' : ''; ?>>NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>