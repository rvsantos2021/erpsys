                                    <div id="estoque" class="tab-pane">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-cubes"></i> Depósitos</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="tableWrapper" style="min-height: 323px; max-height: 323px; overflow-y: auto;">
                                                        <table id="table-estoque" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                                <tr class="text-custom">
                                                                    <th>DEPÓSITO</th>
                                                                    <th class="col-xs-2 text-right">QUANTIDADE</th>
                                                                    <th class="col-xs-1 center">AÇÃO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista-estoque">
                                                                <?php foreach ($estoques as $estoque) : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="estoque_id[]" value="<?= $estoque->id; ?>" />
                                                                            <input type="hidden" name="deposito_id[]" value="<?= $estoque->deposito_id; ?>" />
                                                                            <?= $estoque->descricao; ?>
                                                                        </td>
                                                                        <td class="col-xs-2 text-right">
                                                                            <?= formatPercent($estoque->estoque, false, 2); ?>
                                                                        </td>
                                                                        <td class="center">
                                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-xs btn-default btn-width-27 btn-del-estoque"><i class="fas fa-trash-alt text-danger"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                            <tfoot class="panel-featured panel-featured-custom text-custom">
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-cubes"></i> Estoque</legend>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div class="checkbox-custom checkbox-warning">
                                                        <input type="checkbox" name="estoque" <?php echo ($table->estoque == 1 ? 'checked' : ''); ?> />
                                                        <label for="estoque">Controla Estoque</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="estoque_inicial">Estoque Inicial</label>
                                                    <input type="text" class="form-control input-sm text-right" name="estoque_inicial" placeholder="Estoque Inicial" value="<?php echo formatPercent($table->estoque_inicial, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="estoque_minimo">Estoque Mínimo</label>
                                                    <input type="text" class="form-control input-sm text-right" name="estoque_minimo" placeholder="Estoque Mínimo" value="<?php echo formatPercent($table->estoque_minimo, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="estoque_maximo">Estoque Máximo</label>
                                                    <input type="text" class="form-control input-sm text-right" name="estoque_maximo" placeholder="Estoque Máximo" value="<?php echo formatPercent($table->estoque_maximo, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="estoque_atual">Estoque Atual</label>
                                                    <input type="text" class="form-control input-sm text-right" name="estoque_atual" placeholder="Estoque Atual" value="<?php echo formatPercent($table->estoque_atual, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="estoque_reservado">Estoque Reservado</label>
                                                    <input type="text" class="form-control input-sm text-right" name="estoque_reservado" placeholder="Estoque Reservado" value="<?php echo formatPercent($table->estoque_reservado, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="estoque_real">Estoque Real</label>
                                                    <input type="text" class="form-control input-sm text-right" name="estoque_real" placeholder="Estoque Real" value="<?php echo formatPercent($table->estoque_real, false, 2); ?>" maxlength="15" />
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>