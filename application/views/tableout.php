            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-data__tool">
                                    <div class="table-data__tool-right">
                                        <a href="<?= base_url(); ?>Data/insertdataout/<?= $out2; ?>" class="au-btn au-btn-icon au-btn--green au-btn--small" style="color: #ffffff">
                                            <i class="zmdi zmdi-plus"></i>Tambah Data Keluar</a>
                                    </div>
                                </div>
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
                                        <thead>
                                            <tr>
                                                <th>Jumlah</th>
                                                <th>Tgl. Keluar</th>
                                                <th>Keterangan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                  <?php
                                    foreach ($out as $data) {
                                      echo '
                                            <tr class="tr-shadow">
                                                <td align="center">'.$data->jumlah.'</td>
                                                <td>'.$data->tgl_keluar.'</td>
                                                <td>'.$data->keterangan.'</td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="#" class="item" data-toggle="modal" data-target="#modal_ubah">
                                                            <i class="zmdi zmdi-edit" onclick="prepare_update_barang('.$data->id_detil.')"></i>
                                                        </a>
                                                        <a href="'.base_url().'data/deleteout/'.$data->id_detil.'/'.$data->id_barang.'" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="spacer"></tr>
                                              ';
                                            }
                                          ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2019. All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->

            <!-- modal scroll -->
            <div class="modal fade" id="modal_ubah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="scrollmodalLabel">Ubah Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                    <div class="card-body card-block">
                                        <form action="<?= base_url('data/editout'); ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                            <input type="hidden" name="edit_id_detil" id="edit_id_detil">
                                            <input type="hidden" name="edit_id_barang" id="edit_id_barang">
                    
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Jumlah</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="edit_jumlah" name="edit_jumlah" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Tgl. Keluar</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="date" id="edit_tgl_keluar" name="edit_tgl_keluar" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="textarea-input" class=" form-control-label">Keterangan</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="edit_ket" id="edit_ket" rows="9" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        <input name="submit" type="submit" class="btn btn-primary btn-sm" value="Submit"/>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                        </form>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal scroll -->

    <script type="text/javascript">
        function prepare_update_barang(id_detil)
        {
            $('#edit_jumlah').empty();
            $('#edit_tgl_keluar').empty();
            $('#edit_ket').empty();

            $.getJSON('<?php echo base_url(); ?>Data/get_detilout_by_id/' + id_detil, function(data){
                $('#edit_id_detil').val(data.id_detil);
                $('#edit_id_barang').val(data.id_barang);
                $('#edit_jumlah').val(data.jumlah);
                $('#edit_tgl_keluar').val(data.tgl_keluar);
                $('#edit_ket').val(data.keterangan);
            });
        }
    </script>