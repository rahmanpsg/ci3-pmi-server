<?php $this->load->view('pmi/header') ?>
<link rel="stylesheet" href="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/lib/gijgo/gijgo.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/lib/bootstrap-validator/bootstrapValidator.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/lib/toast/toast.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/lib/bootstrap-select/bootstrap-select.min.css') ?>">
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="showback">
                    <h3><i class="fa fa-angle-right"></i> Form Data Stok Darah</h3>
                    <div class="col text-right">
                        <button class="btn btn-sm btn-danger" onclick="setModalTambah()">
                            <div>
                                <i class="fa fa-plus"></i>
                                <span>Tambah Stok</span>
                            </div>
                        </button>
                    </div>
                    <div class="adv-table mt">
                        <table class="table align-items-center table-flush" id="myTable" data-url='<?= $TBL_URL; ?>' data-toggle="table" data-detail-view="true" data-detail-formatter="detailFormatter" data-unique-id="gol_darah">
                            <thead class="bg-theme04 text-center" style="color: white;">
                                <tr>
                                    <th data-field="no" data-formatter="indexFormatter" class="font-14 text-center">#</th>
                                    <th data-field="gol_darah" data-formatter="golDarahFormatter" class="text-center">Golongan Darah</th>
                                    <th data-field="total" data-formatter="totalFormatter" class="text-center">Total</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- /row -->
        <!-- Modal -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Form Tambah Data</h4>
                    </div>
                    <div class="modal-body">
                        <form id="myForm">
                            <div class="form-group row">
                                <label for="gol_darah" class="col-sm-3 col-form-label">Golongan Darah</label>
                                <div class="col-sm-9">
                                    <select name="gol_darah" id="gol_darah" class="selectpicker show-tick form-control" data-style="btn-outline-light" data-bv-notempty="true" data-bv-notempty-message="Golongan Darah belum dipilih" title="- Pilih Golongan Darah -">
                                        <?php
                                        foreach ($dataGolDarah as $val) {

                                            echo "<option value='$val[gol_darah]'>$val[gol_darah]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pendonor" class="col-sm-3 col-form-label">Pendonor</label>
                                <div class="col-sm-9">
                                    <select name="pendonor" id="pendonor" class="selectpicker show-tick form-control" data-style="btn-outline-light" data-bv-notempty="true" data-bv-notempty-message="Pendonor belum dipilih" title=" - Pilih Golongan Darah Terlebih Dahulu -" data-live-search="true">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" data-bv-notempty="true" data-bv-notempty-message="Jumlah tidak boleh kosong" min="1">
                                </div>
                            </div>

                            <div class="col text-right">
                                <button id="submitBtn" type="submit" class="btn btn-info">
                                    <div>
                                        <i class="fa fa-save"></i>
                                        <span>Simpan</span>
                                    </div>
                                </button>
                                <button class="btn btn-danger" data-dismiss="modal">
                                    <div>
                                        <i class="fa fa-window-close"></i>
                                        <span>Batal</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </section>
</section>
<!--main content end-->
<?php $this->load->view('pmi/footer') ?>
<script src="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table-id-ID.js') ?>"></script>
<script src="<?= base_url('/assets/lib/gijgo/gijgo.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-validator/bootstrapValidator.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-validator/id_ID.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-select/bootstrap-select.min.js'); ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-select/defaults-id_ID.min.js'); ?>"></script>
<script src="<?= base_url('/assets/lib/toast/toast.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/moment/moment-with-locales.min.js') ?>"></script>
<script src="<?= base_url('/assets/formProses.js') ?>"></script>

<script>
    formProses = new formProses('<?php echo base_url('api/manajemen') ?>', 'stok');
    const myModal = $('#myModal');
    const myForm = $('#myForm');
    const myTabel = $('#myTable');

    $(document).ready(() => {
        myForm.bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'fa fa-exclamation-circle',
                validating: 'fa fa-spin fa-refresh'
            },
            excluded: ':disabled',
            fields: {
                designator: {
                    message: 'Designator telah ada',
                    validators: {
                        callback: {
                            callback: function(value, validator, $fields) {
                                if (value == '') {
                                    return true;
                                }
                                return true;
                            }
                        }
                    }
                }
            }
        })
    })

    $('#gol_darah').on('change', (evt) => {
        const selected = evt.target.value

        $('#pendonor')
            .empty()
            .selectpicker({
                title: '- Pilih Pendonor -'
            })
            .selectpicker('refresh');
        const URL = '<?= base_url('api/getDataPendonor/') . $this->id ?>';
        const cek = formProses.getData(URL, {
            gol_darah: selected
        });

        cek.map(v => {
            $('#pendonor').append(`<option value="${v.id}" data-subtext='${v.id}'>${v.nama}</option>`)
        })

        $('#pendonor')
            .selectpicker('refresh');
    })

    function setModalTambah() {
        myForm.bootstrapValidator('resetForm', true);
        myForm.trigger("reset");

        myModal.modal();
        $('#myModalLabel').html("Form Tambah Stok Darah");

        $('.selectpicker').selectpicker('refresh');

        $('#submitBtn').html('<div><i class = "fa fa-save"></i><span> Simpan</span></div>');
    }

    myForm.submit((evt) => {
        evt.preventDefault();
    })

    $('#submitBtn').on('click', (e) => {
        myForm.data('bootstrapValidator').validate();

        const hasErr = myForm.find(".has-error").length;

        if (hasErr == 0) {
            const data = myForm.serializeArray()
                .reduce(function(a, x) {
                    a[x.name] = x.value;
                    return a;
                }, {});

            const id = formProses.getData('<?php echo base_url('api/generate_id') ?>', {
                tabel: 'tbl_stok',
                kode: 'STK',
                panjang: 6
            });

            data['id'] = id;
            data['user'] = '<?= $this->id ?>';
            data['status'] = 'Ditambahkan';

            const ButtonText = $('#submitBtn').text();

            if (ButtonText == " Simpan") {
                const res = formProses.tambah(data);
                if (res[0] == true) {
                    toastr.success('Data stok berhasil ditambahkan', 'Informasi', {
                        timeOut: 1000
                    })
                    myModal.modal('toggle');

                    const ID = res[1]['gol_darah'];

                    const total = myTabel.bootstrapTable('getRowByUniqueId', ID)['total'];

                    let resTotal;

                    resTotal = parseInt(total != undefined ? total : 0) + parseInt(res[1]['jumlah'])

                    myTabel.bootstrapTable('updateByUniqueId', {
                        id: ID,
                        row: {
                            total: resTotal
                        }
                    });
                }
            } else
            if (ButtonText == " Update") {
                const id = $('#id').val();
                const res = formProses.update(data, {
                    id
                });
                if (res[0] == true) {
                    toastr.success('Data stok berhasil diubah', 'Informasi', {
                        timeOut: 1000
                    })
                    myModal.modal('toggle');

                    myTabel.bootstrapTable('updateByUniqueId', {
                        id,
                        row: res[1]
                    });
                }
            }
        }
    })
</script>

<script>
    function indexFormatter(val, row, index) {
        return index + 1;
    }

    function golDarahFormatter(val) {
        return `<span class="badge bg-important style="font-size:20px;">${val}</span>`
    }

    function totalFormatter(val, row) {
        if (parseInt(val) > 0) {
            return val + ' Kantong';
        } else {
            return 'Kosong';
        }
    }

    function buildTable($el, gol_darah) {
        $el.bootstrapTable({
            url: encodeURI('<?= base_url('api/getHistoryStok/') . $this->id . '?gol_darah=' ?>' + gol_darah),
            pagination: true,
            sortable: true,
            pageSize: 5,
            search: true,
            columns: [{
                //     field: 'id',
                //     title: 'ID',
                //     align: 'center'
                // }, {
                //     field: 'pendonor',
                //     title: 'Pendonor'
                // }, {
                field: 'status',
                title: 'Status',
                align: 'center',
                sortable: true
            }, {
                field: 'jumlah',
                title: 'Jumlah',
                align: 'center',
                sortable: true
            }, {
                field: 'tanggal',
                title: 'Tanggal',
                align: 'center',
                sortable: true
            }],
        });
    }

    function detailFormatter(index, row, element) {
        buildTable(element.html('<table></table>').find('table'), row.gol_darah);
    }
</script>
</body>

</html>