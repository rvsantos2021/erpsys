                    <div class="card-body pb-3 pt-4">
                        <div class="text-center">
                            <div class="pt-1 bg-img m-auto">
                                <?php if ($cliente->photo == null) : ?>
                                    <img src="<?= site_url('assets/images/avatar-cliente.png'); ?>" class="rounded-circle rounded-circle-60" alt="Cliente" />
                                <?php else : ?>
                                    <img src="<?= site_url("clientes/show_photo/$cliente->photo"); ?>" class="rounded-circle rounded-circle-60" alt="Foto do Cliente" />
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-1"><?= $cliente->razao_social; ?></h4>
                                <p class="mb-0 text-muted">
                                    <a href="mailto:<?= esc($cliente->email); ?>" target="_blank"><?= esc($cliente->email); ?></a>
                                </p>
                                <ul class="nav justify-content-between mt-4 px-3 py-2">
                                    <li class="flex-fill">
                                        <p><strong>Cadastrado em</strong></p>
                                        <p><?= formatDateTime($cliente->created_at); ?></p>
                                    </li>
                                    <li class="flex-fill">
                                        <p><strong>Última Atualização</strong></p>
                                        <p><?= formatDateTime($cliente->updated_at); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="id" value="<?= $cliente->id ?>" />
                            <input type="hidden" name="method_del" value="remove" />
                        </div>
                    </div>