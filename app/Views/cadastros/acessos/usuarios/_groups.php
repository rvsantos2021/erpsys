                <link href="<?php echo site_url('assets/'); ?>vendor/selectize/css/selectize.bootstrap4.css" rel="stylesheet">

                <div class="row">
                    <div class="col-md-8">
                        <h4 class="name text-semibold"><?php echo $user->name; ?></h4>
                        <h5 class="role">
                            <a href="mailto:<?php echo esc($user->email); ?>" target="_blank"><?php echo esc($user->email); ?></a>
                        </h5>
                        <?php if (empty($user->groups)) : ?>
                            <hr />
                            <h5 class="contributions text-warning">
                                Esse usuário não possui grupo de acesso definido
                            </h5>
                        <?php else : ?>
                            <table id="table-groups" class="table table-striped table-sm" style="width: 100%">
                                <thead>
                                    <tr class="text-custom">
                                        <th>GRUPO</th>
                                        <th class="center col-xs-1">AÇÃO</th>
                                    </tr>
                                </thead>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo form_open('/', ['id' => 'formGroup'], ['id' => "$user->id"]) ?>
                        <input type="hidden" name="method" value="groups_save" />
                        <h5 class="card-title text-bold">Grupos disponíveis</h5>
                        <label class="form-control-label">Selecione o(s) grupo(s)</label>
                        <select name="group_id[]" class="form-control selectize" multiple="multiple">
                            <?php foreach ($groups_list as $group) : ?>
                                <option value="<?php echo $group->id; ?>">
                                    <?php echo esc($group->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"></div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

                <script src="<?php echo site_url('assets/'); ?>vendor/selectize/js/selectize.min.js"></script>
                <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#table-groups").DataTable({
                            "oLanguage": language_PTBR,
                            "ajax": "<?php echo site_url('usuarios/fetch_groups/') . $user->id ?>",
                            "columns": [{
                                    "data": "name"
                                },
                                {
                                    "data": "actions"
                                },
                            ],
                            "columnDefs": [{
                                "targets": 1,
                                "className": "center",
                                "orderable": false,
                                "order": []
                            }],
                            "deferRender": true,
                            "stateSave": true,
                            "responsive": true,
                            "ordering": false,
                            "searching": false,
                            "info": false,
                            "lengthChange": false,
                            "pagingType": "simple",
                        });

                        $('.selectize').selectize();
                    });
                </script>