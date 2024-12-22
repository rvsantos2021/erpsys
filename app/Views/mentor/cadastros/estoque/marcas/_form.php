                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-marca.png'); ?>" alt="Marca" />
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
                        </fieldset>
                    </div>
                </div>
                <?php echo $this->include('mentor/layout/_response'); ?>