                                    <div class="tab-pane fade" id="imagens" role="tabpanel" aria-labelledby="imagens-tab">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-cube"></i> Imagens</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="tableWrapper" style="min-height: 455px; max-height: 455px; overflow-y: auto;">
                                                        <table id="table-imagens" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                                <tr class="text-custom">
                                                                    <th class="text-center col-xs-1">IMAGEM</th>
                                                                    <th>DESCRIÇÃO</th>
                                                                    <th class="text-enter col-xs-1">DESTAQUE</th>
                                                                    <th class="text-center col-xs-1">AÇÃO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista-imagens">
                                                                <?php foreach ($imagens as $imagem) { ?>
                                                                    <?php
                                                                    $url_image = site_url("estoque/produtos/show_photo/$imagem->photo");
                                                                    $image = [
                                                                        'src' => site_url("estoque/produtos/show_photo/$imagem->photo"),
                                                                        'class' => 'rounded-circle img-fluid',
                                                                        'title' => 'Ampliar',
                                                                        'width' => '32',
                                                                    ];
                                                                    //$link_image = '<div class="img-thumbnail">'.'<a href="'.$url_image.'" target="_blank">'.$imagem->photo = img($image).'</a>'.'</div>';
                                                                    $link_image = '<a href="'.$url_image.'" target="_blank">'.$imagem->photo = img($image).'</a>';
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="imagem_id[]" value="<?php echo $imagem->id; ?>" />
                                                                            <?php echo $link_image; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $imagem->descricao; ?>
                                                                        </td>
                                                                        <td class="text-center col-xs-1">
                                                                            <?php echo $imagem->destaque == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Sim"><i class="fa fa-check" title="Sim"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Não"><i class="fa fa-times" title="Não"></i></span>'; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-imagem"><i class="ti ti-trash"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                            <tfoot class="panel-featured panel-featured-custom text-custom">
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>