                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-tipo-produto.png'); ?>" alt="Tipo de Produto" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="entrada" name="movimento" value="E" <?php echo $table->movimento == 'E' ? 'checked' : ''; ?> />
                                        <label for="entrada" class="form-check-label">Entrada</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="saida" name="movimento" value="S" <?php echo $table->movimento == 'S' ? 'checked' : ''; ?> />
                                        <label for="saida" class="form-check-label">Saída</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="transferencia" name="movimento" value="T" <?php echo $table->movimento == 'T' ? 'checked' : ''; ?> />
                                        <label for="transferencia" class="form-check-label">Transferência</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="estoque" name="estoque" <?php echo $table->estoque == 1 ? 'checked' : ''; ?> />
                                        <label for="estoque" class="form-check-label">Movimenta Estoque</label>
                                    </div>
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