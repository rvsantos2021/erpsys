        <div class="panel-body">
            <div class="modal-wrapper-custom">
                <?php echo form_open_multipart('/', ['id' => 'form', 'class' => 'form-validate']) ?>
                <input type="hidden" name="method" value="upload" />
                <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                    <legend class="legend"> <i class="fas fa-file-code"></i> Importar Arquivo</legend>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="xml">Selecione o XML</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="xml" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="progress progress-striped progress-sm m-md light">
                                <div id="dynamic" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
                                    <span class="sr-only">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>