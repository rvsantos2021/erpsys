                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="50" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="abreviatura">Abreviatura</label>
                                    <input type="text" class="form-control input-sm" name="abreviatura" placeholder="Abreviatura" value="<?php echo $table->abreviatura; ?>" maxlength="5" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="quantidade">Quantidade</label>
                                    <input type="number" class="form-control input-sm" name="quantidade" value="<?php echo $table->quantidade; ?>" required />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>