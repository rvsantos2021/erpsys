                                    <div id="produto" class="tab-pane active">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-cube"></i> Dados Principais</legend>
                                            <div class="form-group row">
                                                <div class="col-md-9">
                                                    <label for="descricao">Descrição</label>
                                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="100" required />
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="tipo_id" data-toggle="tooltip" data-original-title="Tipo de Produto">Tipo de Produto</label>
                                                    <select data-plugin-selectTwo class="form-control input-sm" name="tipo_id" data-plugin-options='{ "allowClear": true }' required>
                                                        <option value=""></option>
                                                        <?php foreach ($tipos as $tipo) : ?>
                                                            <option value="<?php echo $tipo->id; ?>" <?php echo ($table->tipo_id === $tipo->id ? 'selected' : ''); ?>><?php echo $tipo->descricao; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label for="codigo_barras">Código de Barras</label>
                                                    <input type="text" class="form-control input-sm" name="codigo_barras" placeholder="Código de Barras" value="<?php echo $table->codigo_barras; ?>" maxlength="20" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="referencia">Referência</label>
                                                    <input type="text" class="form-control input-sm" name="referencia" placeholder="Referência" value="<?php echo $table->referencia; ?>" maxlength="30" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="unidade_entrada_id">Unidade Entrada</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-unidade"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="unidade_entrada_id" data-plugin-options='{ "allowClear": true }' required>
                                                            <option value=""></option>
                                                            <?php foreach ($unidades as $unidade) : ?>
                                                                <option value="<?php echo $unidade->id; ?>" <?php echo ($table->unidade_entrada_id === $unidade->id ? 'selected' : ''); ?>><?php echo $unidade->descricao; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="unidade_saida_id">Unidade Saída</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-unidade"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="unidade_saida_id" data-plugin-options='{ "allowClear": true }' required>
                                                            <option value=""></option>
                                                            <?php foreach ($unidades as $unidade) : ?>
                                                                <option value="<?php echo $unidade->id; ?>" <?php echo ($table->unidade_saida_id === $unidade->id ? 'selected' : ''); ?>><?php echo $unidade->descricao; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="marca_id">Marca</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-marca"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="marca_id" data-plugin-options='{ "allowClear": true }'>
                                                            <option value=""></option>
                                                            <?php foreach ($marcas as $marca) : ?>
                                                                <option value="<?php echo $marca->id; ?>" <?php echo ($table->marca_id === $marca->id ? 'selected' : ''); ?>><?php echo $marca->descricao; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="modelo_id">Modelo</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-modelo"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="modelo_id" data-plugin-options='{ "allowClear": true }'>
                                                            <option value=""></option>
                                                            <?php foreach ($modelos as $modelo) : ?>
                                                                <option value="<?php echo $modelo->id; ?>" <?php echo ($table->modelo_id === $modelo->id ? 'selected' : ''); ?>><?php echo $modelo->descricao; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="grupo_id">Grupo</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-grupo"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="grupo_id" data-plugin-options='{ "allowClear": true }'>
                                                            <option value=""></option>
                                                            <?php foreach ($grupos as $grupo) : ?>
                                                                <option value="<?php echo $grupo->id; ?>" <?php echo ($table->grupo_id === $grupo->id ? 'selected' : ''); ?>><?php echo $grupo->descricao; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="secao_id">Seção</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-secao"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="secao_id" data-plugin-options='{ "allowClear": true }'>
                                                            <option value=""></option>
                                                            <?php foreach ($secoes as $secao) : ?>
                                                                <option value="<?php echo $secao->id; ?>" <?php echo ($table->secao_id === $secao->id ? 'selected' : ''); ?>><?php echo $secao->descricao; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-fax"></i> Dados Fiscais</legend>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label for="codigo_ncm">Código NCM</label>
                                                    <input type="text" class="form-control input-sm" name="codigo_ncm" placeholder="Código NCM" value="<?php echo $table->codigo_ncm; ?>" maxlength="8" required />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="peso_bruto">Peso Bruto</label>
                                                    <input type="text" class="form-control input-sm text-right" name="peso_bruto" placeholder="Peso Bruto" value="<?php echo formatPercent($table->peso_bruto, false, 4); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="peso_liquido">Peso Líquido</label>
                                                    <input type="text" class="form-control input-sm text-right" name="peso_liquido" placeholder="Peso Líquido" value="<?php echo formatPercent($table->peso_liquido, false, 4); ?>" maxlength="15" />
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>