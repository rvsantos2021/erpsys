                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-7">
                                    <label for="banco_id">Banco</label>
                                    <div class="input-group btn-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-default btn-add-banco"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <select data-plugin-selectTwo class="form-control input-sm" name="banco_id" data-plugin-options='{ "placeholder": "Informe o Banco", "allowClear": true }' required>
                                            <option value=""></option>
                                            <?php foreach ($bancos as $banco) : ?>
                                                <option value="<?php echo $banco->id; ?>" <?php echo ($table->banco_id === $banco->id ? 'selected' : ''); ?>><?php echo $banco->descricao; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="numero">Número</label>
                                    <input type="text" class="form-control input-sm" name="numero" placeholder="Número" value="<?php echo $table->numero; ?>" maxlength="10" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="agencia">Agência</label>
                                    <input type="text" class="form-control input-sm" name="agencia" placeholder="Agência" value="<?php echo $table->agencia; ?>" maxlength="10" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="50" required />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>vendor/selectize/js/selectize.min.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/custom/contas_corrente_form.js"></script>