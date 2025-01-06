                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-condicao-pagamento.png'); ?>" alt="Condição de Pagamento" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="nome" value="<?php echo $table->nome; ?>" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tabela_id">Tabela de Preço</label>
                                    <select class="js-basic-single form-control" id="tabela_id" name="tabela_id" data-js-container=".modal">
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($tabelas as $tabela) { ?>
                                            <option value="<?php echo $tabela->id; ?>" <?php echo $table->tabela_id === $tabela->id ? 'selected' : ''; ?>><?php echo $tabela->descricao; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="entrada" id="entrada" <?php echo $table->entrada == 1 ? 'checked' : ''; ?> />
                                        <label for="entrada">Exige Entrada</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>% Entrada</label>
                                    <input type="text" class="form-control text-right" name="perc_entrada" value="<?php echo $table->perc_entrada; ?>" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nº Parcelas</label>
                                    <input type="number" class="form-control" name="qtd_parcelas" value="<?php echo $table->qtd_parcelas; ?>" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>1ª Parcela</label>
                                    <input type="number" class="form-control" name="dias_parcela1" value="<?php echo $table->dias_parcela1; ?>" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Entre Parcela</label>
                                    <input type="number" class="form-control" name="dias_parcelas" value="<?php echo $table->dias_parcelas; ?>" />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?php echo $this->include('mentor/layout/_response'); ?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $(".js-basic-single").select2({
                            dropdownParent: $("#modalForm")
                        });
                    });
                </script>