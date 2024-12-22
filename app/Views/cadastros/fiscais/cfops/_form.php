                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="cfop">CFOP</label>
                                    <input type="text" class="form-control input-sm" name="cfop" placeholder="CFOP" value="<?php echo $table->cfop; ?>" maxlength="4" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" maxlength="100" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="origem_destino" data-toggle="tooltip" data-original-title="Origem / Destino">Origem / Destino</label>
                                    <select data-plugin-selectTwo class="form-control input-sm" name="origem_destino" data-plugin-options='{ "allowClear": false }' required>
                                        <option value=""></option>
                                        <option value="D" <?php echo $table->origem_destino == 'D' ? 'selected' : ''; ?>>MESMO ESTADO</option>
                                        <option value="F" <?php echo $table->origem_destino == 'F' ? 'selected' : ''; ?>>OUTRO ESTADO</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>