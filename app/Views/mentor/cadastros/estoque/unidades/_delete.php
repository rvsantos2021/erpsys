                    <div class="card-body pb-3 pt-4">
                        <div class="text-center">
                            <div class="pt-1 bg-img m-auto">
                                <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-unidade.png'); ?>" alt="Unidade" />
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-1"><?php echo $table->descricao; ?></h4>
                                <ul class="nav justify-content-between mt-4 px-3 py-2">
                                    <li class="flex-fill">
                                        <p><strong>Cadastrado em</strong></p>
                                        <p><?php echo formatDateTime($table->created_at); ?></p>
                                    </li>
                                    <li class="flex-fill">
                                        <p><strong>Última Atualização</strong></p>
                                        <p><?php echo formatDateTime($table->updated_at); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $table->id; ?>" />
                            <input type="hidden" name="method_del" value="remove" />
                        </div>
                    </div>