                                    <div class="tab-pane fade" id="estoque" role="tabpanel" aria-labelledby="estoque-tab">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-cubes"></i> Depósitos</legend>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div id="tableWrapper" style="min-height: 323px; max-height: 323px; overflow-y: auto;">
                                                        <table id="table-estoque" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                                <tr class="text-custom">
                                                                    <th>DEPÓSITO</th>
                                                                    <th class="form-group col-xs-2 text-right">QUANTIDADE</th>
                                                                    <th class="form-group col-xs-1 text-center">AÇÃO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista-estoque">
                                                                <?php foreach ($estoques as $estoque) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="estoque_id[]" value="<?php echo $estoque->id; ?>" />
                                                                            <input type="hidden" name="deposito_id[]" value="<?php echo $estoque->deposito_id; ?>" />
                                                                            <?php echo $estoque->descricao; ?>
                                                                        </td>
                                                                        <td class="form-group col-xs-2 text-right">
                                                                            <?php echo formatPercent($estoque->estoque, false, 2); ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-estoque"><i class="ti ti-trash"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
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
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="estoque" name="estoque" <?php echo $table->estoque == 1 ? 'checked' : ''; ?> />
                                                        <label for="estoque" class="form-check-label">Controla Estoque</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="estoque_inicial">Estoque Inicial</label>
                                                    <input type="text" class="form-control text-right" name="estoque_inicial" placeholder="Estoque Inicial" value="<?php echo formatPercent($table->estoque_inicial, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="estoque_minimo">Estoque Mínimo</label>
                                                    <input type="text" class="form-control text-right" name="estoque_minimo" placeholder="Estoque Mínimo" value="<?php echo formatPercent($table->estoque_minimo, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="estoque_maximo">Estoque Máximo</label>
                                                    <input type="text" class="form-control text-right" name="estoque_maximo" placeholder="Estoque Máximo" value="<?php echo formatPercent($table->estoque_maximo, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="estoque_atual">Estoque Atual</label>
                                                    <input type="text" class="form-control text-right" name="estoque_atual" placeholder="Estoque Atual" value="<?php echo formatPercent($table->estoque_atual, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="estoque_reservado">Estoque Reservado</label>
                                                    <input type="text" class="form-control text-right" name="estoque_reservado" placeholder="Estoque Reservado" value="<?php echo formatPercent($table->estoque_reservado, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="estoque_real">Estoque Real</label>
                                                    <input type="text" class="form-control text-right" name="estoque_real" placeholder="Estoque Real" value="<?php echo formatPercent($table->estoque_real, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>