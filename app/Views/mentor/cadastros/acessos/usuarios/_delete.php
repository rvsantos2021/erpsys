                    <div class="card-body pb-3 pt-4">
                        <div class="text-center">
                            <div class="pt-1 bg-img m-auto">
                                <?php if ($user->photo == null) : ?>
                                    <img class="img-fluid" src="<?= site_url('assets/images/avatar-user.png'); ?>" alt="Foto não cadastrada" />
                                <?php else : ?>
                                    <img class="img-fluid" src="<?= site_url("users/show_photo/$user->photo"); ?>" alt="Foto do usuário" />
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-1"><?= $user->name; ?></h4>
                                <p class="mb-0 text-muted">
                                    <a href="mailto:<?= esc($user->email); ?>" target="_blank"><?= esc($user->email); ?></a>
                                </p>
                                <ul class="nav justify-content-between mt-4 px-3 py-2">
                                    <li class="flex-fill">
                                        <p><strong>Cadastrado em</strong></p>
                                        <p><?= formatDateTime($user->created_at); ?></p>
                                    </li>
                                    <li class="flex-fill">
                                        <p><strong>Última Atualização</strong></p>
                                        <p><?= formatDateTime($user->updated_at); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="id" value="<?= $user->id ?>" />
                            <input type="hidden" name="method_del" value="remove" />
                        </div>
                    </div>