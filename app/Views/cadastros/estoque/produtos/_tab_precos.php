                                    <div id="precos" class="tab-pane">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-money"></i> Preço de Custo</legend>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label for="custo_bruto">Custo Bruto</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_bruto" placeholder="Custo Bruto" value="<?php echo formatPercent($table->custo_bruto, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_perc_ipi">% IPI</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_perc_ipi" placeholder="% IPI" value="<?php echo formatPercent($table->custo_perc_ipi, false, 2); ?>" maxlength="16" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_valor_ipi">Valor IPI</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_valor_ipi" placeholder="Valor IPI" value="<?php echo formatPercent($table->custo_valor_ipi, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_perc_st">% ST</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_perc_st" placeholder="% ST" value="<?php echo formatPercent($table->custo_perc_st, false, 2); ?>" maxlength="16" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_valor_st">Valor ST</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_valor_st" placeholder="Valor ST" value="<?php echo formatPercent($table->custo_valor_st, false, 2); ?>" maxlength="15" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-2">
                                                    <label for="custo_perc_frete">% Frete</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_perc_frete" placeholder="% Frete" value="<?php echo formatPercent($table->custo_perc_frete, false, 2); ?>" maxlength="16" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_valor_frete">Valor Frete</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_valor_frete" placeholder="Valor Frete" value="<?php echo formatPercent($table->custo_valor_frete, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_perc_desconto">% Desconto</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_perc_desconto" placeholder="% Desconto" value="<?php echo formatPercent($table->custo_perc_desconto, false, 2); ?>" maxlength="16" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_valor_desconto">Valor Desconto</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_valor_desconto" placeholder="Valor Desconto" value="<?php echo formatPercent($table->custo_valor_desconto, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="custo_real">Preço Custo</label>
                                                    <input type="text" class="form-control input-sm text-right" name="custo_real" placeholder="Preço Custo" value="<?php echo formatPercent($table->custo_real, false, 2); ?>" maxlength="15" />
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-usd"></i> Preço de Venda</legend>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="tabela">Tabela de Preço</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-tabela"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="tabela" data-plugin-options='{ "allowClear": true }'>
                                                            <option value=""></option>
                                                            <?php foreach ($tabelas as $tabela) : ?>
                                                                <option value="<?php echo $tabela->id; ?>"><?php echo $tabela->descricao; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="margem_lucro">% Margem Lucro</label>
                                                    <input type="text" class="form-control input-sm text-right" name="margem_lucro" placeholder="% Margem Lucro" value="<?php echo formatPercent(0, false, 2); ?>" maxlength="16" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="valor_venda">Valor Venda</label>
                                                    <input type="text" class="form-control input-sm text-right" name="valor_venda" placeholder="Valor Venda" value="<?php echo formatPercent(0, false, 2); ?>" maxlength="15" />
                                                </div>
                                                <div class="col-md-1">
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <button type="button" class="btn btn-sm btn-default mt-26 btn-inc-preco"><i class="fa fa-arrow-circle-down"></i></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="tableWrapper" style="min-height: 201px; max-height: 201px; overflow-y: auto;">
                                                        <table id="table-precos" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                                <tr class="text-custom">
                                                                    <th>TABELA</th>
                                                                    <th class="col-xs-2 text-right">% MARGEM LUCRO</th>
                                                                    <th class="col-xs-2 text-right">VALOR VENDA</th>
                                                                    <th class="col-xs-1 center">AÇÃO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista-precos">
                                                                <?php foreach ($precos as $preco) : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="pre_id[]" value="<?= $preco->id; ?>" />
                                                                            <input type="hidden" name="pre_tab[]" value="<?= $preco->tabela_id; ?>" />
                                                                            <?= $preco->tabela; ?>
                                                                        </td>
                                                                        <td class="col-xs-2 text-right">
                                                                            <input type="hidden" name="pre_mar[]" value="<?= formatPercent($preco->perc_lucro, false); ?>" />
                                                                            <?= formatPercent($preco->perc_lucro, false); ?>
                                                                        </td>
                                                                        <td class="col-xs-2 text-right">
                                                                            <input type="hidden" name="pre_vlr[]" value="<?= formatCurrency($preco->preco_venda, false); ?>" />
                                                                            <?= formatCurrency($preco->preco_venda, false); ?>
                                                                        </td>
                                                                        <td class="center">
                                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-xs btn-default btn-width-27 btn-del-preco"><i class="fas fa-trash-alt text-danger"></i></button>
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
                                    </div>