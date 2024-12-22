        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-body">
                        <?php echo form_open('/', ['id' => 'form-comp'], ['produto_id' => "$produto->id"]); ?>
                        <section class="panel panel-group">
                            <header>
                                <div class="mt-3">
                                    <h4 class="mb-1"><?php echo $produto->descricao; ?></h4>
                                    <input type="hidden" name="id" value="<?php echo $produto->id; ?>" />
                                </div>
                            </header>
                            <div class="form-row mt-3 mb-3">
                                <div class="form-group col-md-8">
                                    <label for="produtoSelect" class="form-label">Produto</label>
                                    <select class="js-basic-single form-control" name="produtoSelect" id="produtoSelect" data-js-container=".modal">
                                        <option value="">--- Selecione ---</option>
                                        <!-- Opções serão carregadas via backend -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="quantidade" class="form-label">Quantidade</label>
                                    <input type="number" id="quantidade" class="form-control" placeholder="Quantidade" min="1">
                                </div>
                                <div class="form-group col-md-1 text-right">
                                    <button type="button" class="btn btn-primary mt-26 btn-add-comp"><i class="fa fa-arrow-circle-down"></i></button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div id="tableWrapper" style="min-height: 150px; max-height: 150px; overflow-y: auto;">
                                        <table id="table-composicao" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Produto</th>
                                                    <th class="text-right col-xs-1">Qtd.</th>
                                                    <th class="text-center col-xs-1">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Linhas serão adicionadas dinamicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php echo form_close(); ?>
                        <div id="response_comp"></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".js-basic-single").select2({
                    dropdownParent: $("#modalComposicao")
                });
            });
        </script>