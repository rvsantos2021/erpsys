                                    <div class="tab-pane fade" id="precos" role="tabpanel" aria-labelledby="precos-tab">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-money"></i> Preço de Custo</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="custo_bruto">Custo Bruto</label>
                                                    <input type="text" class="form-control text-right" name="custo_bruto" placeholder="Custo Bruto" value="<?php echo formatPercent($table->custo_bruto, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_perc_ipi">% IPI</label>
                                                    <input type="text" class="form-control text-right" name="custo_perc_ipi" placeholder="% IPI" value="<?php echo formatPercent($table->custo_perc_ipi, false, 2); ?>" maxlength="16" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_valor_ipi">Valor IPI</label>
                                                    <input type="text" class="form-control text-right" name="custo_valor_ipi" placeholder="Valor IPI" value="<?php echo formatPercent($table->custo_valor_ipi, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_perc_st">% ST</label>
                                                    <input type="text" class="form-control text-right" name="custo_perc_st" placeholder="% ST" value="<?php echo formatPercent($table->custo_perc_st, false, 2); ?>" maxlength="16" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_valor_st">Valor ST</label>
                                                    <input type="text" class="form-control text-right" name="custo_valor_st" placeholder="Valor ST" value="<?php echo formatPercent($table->custo_valor_st, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label for="custo_perc_frete">% Frete</label>
                                                    <input type="text" class="form-control text-right" name="custo_perc_frete" placeholder="% Frete" value="<?php echo formatPercent($table->custo_perc_frete, false, 2); ?>" maxlength="16" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_valor_frete">Valor Frete</label>
                                                    <input type="text" class="form-control text-right" name="custo_valor_frete" placeholder="Valor Frete" value="<?php echo formatPercent($table->custo_valor_frete, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_perc_desconto">% Desconto</label>
                                                    <input type="text" class="form-control text-right" name="custo_perc_desconto" placeholder="% Desconto" value="<?php echo formatPercent($table->custo_perc_desconto, false, 2); ?>" maxlength="16" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_valor_desconto">Valor Desconto</label>
                                                    <input type="text" class="form-control text-right" name="custo_valor_desconto" placeholder="Valor Desconto" value="<?php echo formatPercent($table->custo_valor_desconto, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="custo_real">Preço Custo</label>
                                                    <input type="text" class="form-control text-right" name="custo_real" placeholder="Preço Custo" value="<?php echo formatPercent($table->custo_real, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-usd"></i> Preço de Venda</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="tabela">Tabela de Preço</label>
                                                    <select class="js-basic-single form-control" name="tabela" id="tabela" <?php echo $method == 'show' ? 'disabled' : '' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($tabelas as $tabela) { ?>
                                                            <option value="<?php echo $tabela->id; ?>"><?php echo $tabela->descricao; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="margem_lucro">% Margem Lucro</label>
                                                    <input type="text" class="form-control text-right" name="margem_lucro" placeholder="% Margem Lucro" value="<?php echo formatPercent(0, false, 2); ?>" maxlength="16" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="valor_venda">Valor Venda</label>
                                                    <input type="text" class="form-control text-right" name="valor_venda" placeholder="Valor Venda" value="<?php echo formatPercent(0, false, 2); ?>" maxlength="15" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-1">
                                                </div>
                                                <div class="form-group col-md-1 text-right">
                                                    <button type="button" class="btn btn-sm btn-default mt-25 btn-inc-preco"><i class="ti ti-arrow-down"></i></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div id="tableWrapper" style="min-height: 201px; max-height: 201px; overflow-y: auto;">
                                                        <table id="table-precos" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                                <tr class="text-custom">
                                                                    <th>TABELA</th>
                                                                    <th class="form-group col-xs-2 text-right">% MARGEM LUCRO</th>
                                                                    <th class="form-group col-xs-2 text-right">VALOR VENDA</th>
                                                                    <th class="form-group col-xs-1 text-center">AÇÃO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista-precos">
                                                                <?php foreach ($precos as $preco) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="pre_id[]" value="<?php echo $preco->id; ?>" />
                                                                            <input type="hidden" name="pre_tab[]" value="<?php echo $preco->tabela_id; ?>" />
                                                                            <?php echo $preco->tabela; ?>
                                                                        </td>
                                                                        <td class="form-group col-xs-2 text-right">
                                                                            <input type="hidden" name="pre_mar[]" value="<?php echo formatPercent($preco->perc_lucro, false); ?>" />
                                                                            <?php echo formatPercent($preco->perc_lucro, false); ?>
                                                                        </td>
                                                                        <td class="form-group col-xs-2 text-right">
                                                                            <input type="hidden" name="pre_vlr[]" value="<?php echo formatCurrency($preco->preco_venda, false); ?>" />
                                                                            <?php echo formatCurrency($preco->preco_venda, false); ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-preco"><i class="ti ti-trash"></i></button>
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
                                    </div>