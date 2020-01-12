            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-data__tool">
                                    <div class="table-data__tool-right">
                                        <a href="<?= base_url('data/insertdata'); ?>" class="au-btn au-btn-icon au-btn--green au-btn--small" style="color: #ffffff">
                                            <i class="zmdi zmdi-plus"></i>Tambah Data Barang
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-data2">
                                        <thead>
                                            <tr>
                                                <th>Part Number</th>
                                                <th>Tgl. Masuk</th>
                                                <th>Deskripsi</th>
                                                <th>Unit</th>
                                                <th>Harga</th>
                                                <th>Jumlah Masuk</th>
                                                <th>Jumlah Keluar</th>
                                                <th>Total Harga</th>
                                                <th>Sisa</th>
                                                <th>Keluar</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                  <?php
                                    foreach ($barang as $data) {
                                      echo '
                                            <tr class="tr-shadow">
                                                <td align="center">'.$data->nomor.'</td>
                                                <td>'.$data->tgl_masuk.'</td>
                                                <td>'.$data->deskripsi.'</td>
                                                <td>'.$data->unit.'</td>
                                                <td>Rp. '.number_format($data->harga,0,'','.').'</td>
                                                <td>'.$data->jumlah_masuk.'</td>
                                                <td>'.$data->total_keluar.'</td>
                                                <td>Rp. '.number_format($data->total_harga,0,'','.').'</td>
                                                <td>'.$data->sisa.'</td>
                                                <td>
                                                    <a href="'.base_url().'data/detilout/'.$data->id_barang.'">Barang Keluar</a>
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="#" class="item" data-toggle="modal" data-target="#modal_ubah">
                                                            <i class="zmdi zmdi-edit" onclick="prepare_update_barang('.$data->id_barang.')"></i>
                                                        </a>
                                                        <a href="'.base_url().'data/delete/'.$data->id_barang.'" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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
                            <h5 class="modal-title" id="scrollmodalLabel">Ubah Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                    <div class="card-body card-block">
                                        <form action="<?= base_url('data/edit'); ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                            <input type="hidden" name="edit_id_barang" id="edit_id_barang">
                    
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Part Number</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="edit_nomor" name="edit_nomor" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Tgl. Masuk</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="date" id="edit_tgl_masuk" name="edit_tgl_masuk" class="form-control">
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
                                                    <label for="textarea-input" class="form-control-label">Deskripsi</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="edit_deskripsi" id="edit_deskripsi" rows="9" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Unit</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="edit_unit" name="edit_unit" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Harga</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="edit_harga" name="edit_harga" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Jumlah</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="edit_jumlah_masuk" name="edit_jumlah_masuk" class="form-control">
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
        function prepare_update_barang(id_barang)
        {
            $('#edit_nomor').empty();
            $('#edit_tgl_masuk').empty();
            $('#edit_tgl_keluar').empty();
            $('#edit_deskripsi').empty();
            $('#edit_unit').empty();
            $('#edit_harga').empty();
            $('#edit_jumlah_masuk').empty();
            $('#edit_ket').empty();

            $.getJSON('<?php echo base_url(); ?>Data/get_barang_by_id/' + id_barang, function(data){
                $('#edit_id_barang').val(data.id_barang);
                $('#edit_nomor').val(data.nomor);
                $('#edit_tgl_masuk').val(data.tgl_masuk);
                $('#edit_tgl_keluar').val(data.tgl_keluar);
                $('#edit_deskripsi').val(data.deskripsi);
                $('#edit_unit').val(data.unit);
                $('#edit_harga').val(data.harga);
                $('#edit_jumlah_masuk').val(data.jumlah_masuk);
                $('#edit_ket').val(data.keterangan);
            });
        }
    </script>