                                    <div class="tab-pane fade active show" id="produto" role="tabpanel" aria-labelledby="produto-tab">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-cube"></i> Dados Principais</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-9">
                                                    <label for="descricao">Descrição</label>
                                                    <input type="text" class="form-control" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="100" <?php echo $method == 'show' ? 'disabled' : 'required' ?>/>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="tipo_id">Tipo de Produto</label>
                                                    <select class="js-basic-single form-control" name="tipo_id" id="tipo_id" <?php echo $method == 'show' ? 'disabled' : 'required' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($tipos as $tipo) { ?>
                                                            <option value="<?php echo $tipo->id; ?>" <?php echo $table->tipo_id === $tipo->id ? 'selected' : ''; ?>><?php echo $tipo->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="codigo_barras">Código de Barras</label>
                                                    <input type="text" class="form-control" name="codigo_barras" placeholder="Código de Barras" value="<?php echo $table->codigo_barras; ?>" maxlength="20" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="referencia">Referência</label>
                                                    <input type="text" class="form-control" name="referencia" placeholder="Referência" value="<?php echo $table->referencia; ?>" maxlength="30" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="unidade_entrada_id">Unidade Entrada</label>
                                                    <select class="js-basic-single form-control" name="unidade_entrada_id" id="unidade_entrada_id" <?php echo $method == 'show' ? 'disabled' : 'required' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($unidades as $unidade) { ?>
                                                            <option value="<?php echo $unidade->id; ?>" <?php echo $table->unidade_entrada_id === $unidade->id ? 'selected' : ''; ?>><?php echo $unidade->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="unidade_saida_id">Unidade Saída</label>
                                                    <select class="js-basic-single form-control" name="unidade_saida_id" id="unidade_saida_id" <?php echo $method == 'show' ? 'disabled' : 'required' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($unidades as $unidade) { ?>
                                                            <option value="<?php echo $unidade->id; ?>" <?php echo $table->unidade_saida_id === $unidade->id ? 'selected' : ''; ?>><?php echo $unidade->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="marca_id">Marca</label>
                                                    <select class="js-basic-single form-control" name="marca_id" id="marca_id" <?php echo $method == 'show' ? 'disabled' : '' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($marcas as $marca) { ?>
                                                            <option value="<?php echo $marca->id; ?>" <?php echo $table->marca_id === $marca->id ? 'selected' : ''; ?>><?php echo $marca->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="modelo_id">Modelo</label>
                                                    <select class="js-basic-single form-control" name="modelo_id" id="modelo_id" <?php echo $method == 'show' ? 'disabled' : '' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($modelos as $modelo) { ?>
                                                            <option value="<?php echo $modelo->id; ?>" <?php echo $table->modelo_id === $modelo->id ? 'selected' : ''; ?>><?php echo $modelo->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="grupo_id">Grupo</label>
                                                    <select class="js-basic-single form-control" name="grupo_id" id="grupo_id" <?php echo $method == 'show' ? 'disabled' : '' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($grupos as $grupo) { ?>
                                                            <option value="<?php echo $grupo->id; ?>" <?php echo $table->grupo_id === $grupo->id ? 'selected' : ''; ?>><?php echo $grupo->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="secao_id">Seção</label>
                                                    <select class="js-basic-single form-control" name="secao_id" id="secao_id" <?php echo $method == 'show' ? 'disabled' : '' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($secoes as $secao) { ?>
                                                            <option value="<?php echo $secao->id; ?>" <?php echo $table->secao_id === $secao->id ? 'selected' : ''; ?>><?php echo $secao->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-fax"></i> Dados Fiscais</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="codigo_ncm">Código NCM</label>
                                                    <input type="text" class="form-control" name="codigo_ncm" placeholder="Código NCM" value="<?php echo $table->codigo_ncm; ?>" maxlength="8" <?php echo $method == 'show' ? 'disabled' : 'required' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="peso_bruto">Peso Bruto</label>
                                                    <input type="text" class="form-control text-right" name="peso_bruto" placeholder="Peso Bruto" value="<?php echo formatPercent($table->peso_bruto, false, 4); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="peso_liquido">Peso Líquido</label>
                                                    <input type="text" class="form-control text-right" name="peso_liquido" placeholder="Peso Líquido" value="<?php echo formatPercent($table->peso_liquido, false, 4); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>