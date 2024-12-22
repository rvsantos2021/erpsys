                    <link href="<?php echo site_url('assets/'); ?>vendor/selectize/css/selectize.bootstrap4.css" rel="stylesheet">

                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="codigo">Código</label>
                                    <input type="text" class="form-control input-sm" name="codigo" value="<?php echo $table->codigo; ?>" disabled />
                                </div>
                                <div class="col-md-10">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="50" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="tipo">Tipo</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="tipo" data-plugin-options='{ "placeholder": "Selecione o Tipo", "allowClear": false }' required>
                                        <option value="" <?php echo ($table->tipo === '' ? 'selected' : ''); ?>></option>
                                        <option value="P" <?php echo ($table->tipo === 'P' ? 'selected' : ''); ?>>Despesa</option>
                                        <option value="R" <?php echo ($table->tipo === 'R' ? 'selected' : ''); ?>>Receita</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="id_pai">Classificação Pai</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="id_pai" data-plugin-options='{ "placeholder": "Informe a Classificação Pai", "allowClear": true }'>
                                        <option value=""></option>
                                        <?php foreach ($classificacoes as $table_pai) : ?>
                                            <option value="<?php echo $table_pai->id; ?>" <?php echo ($table->id_pai === $table_pai->id ? 'selected' : ''); ?>><?php echo $table_pai->codigo . ' - ' . $table_pai->descricao; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>vendor/selectize/js/selectize.min.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('.selectize').selectize();
                        });
                    </script>