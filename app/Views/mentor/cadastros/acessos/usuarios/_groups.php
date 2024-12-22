                <div class="row select-wrapper">
                    <div class="col-md-8">
                        <h4><?= $user->name; ?></h4>
                        <label>
                            <a href="mailto:<?= esc($user->email); ?>" target="_blank"><?= esc($user->email); ?></a>
                        </label>
                        <?php if (empty($user->groups)) : ?>
                            <hr />
                            <h5 class="text-warning">
                                Esse usuário não possui grupo de acesso definido
                            </h5>
                        <?php else : ?>
                            <div class="grid-150">
                                <table id="table-groups" class="table table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Grupo</th>
                                            <th class="text-center col-xs-1">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($groups as $group) { ?>
                                            <tr>
                                                <td>
                                                    <?= $group->name; ?>
                                                </td>
                                                <td class="text-center col-xs-1">
                                                    <button title="Excluir" data-id="" class="btn btn-xs btn-icon btn-outline-danger btn-round btn-del-group" <?= ($group->id == 1) ? 'disabled' : ''; ?>><i class="ti ti-close"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 selects-contant">
                        <?= form_open('/', ['id' => 'formGroup'], ['id' => "$user->id"]) ?>
                        <input type="hidden" name="method" value="groups_save" />
                        <h4>Grupos disponíveis</h4>
                        <label>
                            Selecione o(s) grupo(s)
                        </label>
                        <select name="group_id[]" class="js-basic-multiple form-control" data-js-container=".modal" multiple="multiple">
                            <?php foreach ($groups_list as $group) : ?>
                                <option value="<?= $group->id; ?>">
                                    <?= esc($group->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"></div>
                        <?= form_close(); ?>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $(".js-basic-multiple").select2({
                            dropdownParent: $("#modalGroup")
                        });
                    });
                </script>