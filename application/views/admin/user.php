<?php $this->load->view('admin/header') ?>
<link rel="stylesheet" href="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/lib/gijgo/gijgo.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/lib/bootstrap-validator/bootstrapValidator.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/lib/toast/toast.min.css') ?>">
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="showback">
                    <h3><i class="fa fa-angle-right"></i> Form Data User</h3>
                    <div class="col text-right">
                        <button class="btn btn-sm btn-danger" onclick="setModalTambah()">
                            <div>
                                <i class="fa fa-plus"></i>
                                <span>Tambah Data</span>
                            </div>
                        </button>
                    </div>
                    <div class="adv-table">
                        <table class="table align-items-center table-flush" id="myTable" data-url='<?= $TBL_URL; ?>' data-toggle="table" data-pagination="true" data-search="true" data-unique-id="id">
                            <thead class="bg-theme04 text-center" style="color: white;">
                                <tr>
                                    <th data-field="no" data-formatter="indexFormatter" class="font-14 text-center">#</th>
                                    <th data-field="username">Username</th>
                                    <th data-field="nama">Nama</th>
                                    <th data-field="telp" class="text-center">Nomor Telpon</th>
                                    <th data-field="jenis_kelamin" class="text-center">Jenis Kelamin</th>
                                    <th data-field="tgl_lahir" data-formatter="tglFormatter" class="text-center">Tanggal Lahir</th>
                                    <th data-field="email" class="text-center">Email</th>
                                    <th data-field="aksi" data-formatter="aksiFormatter" data-events="window.aksiEvents" class="text-center">Aksi</th>
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
                            <input type="hidden" id="id">
                            <input type="hidden" id="defaultUsername">
                            <input type="hidden" id="defaultEmail">
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" data-bv-notempty="true" data-bv-notempty-message="Username tidak boleh kosong">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" data-bv-notempty="true" data-bv-notempty-message="Nama tidak boleh kosong">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telp" class="col-sm-3 col-form-label">Nomor Telpon</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="telp" name="telp" placeholder="Nomor Telpon" data-bv-notempty="true" data-bv-notempty-message="Nomor Telpon tidak boleh kosong">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-9">
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="show-tick form-control" data-style="btn-outline-light" data-bv-notempty="true" data-bv-notempty-message="Jenis Kelamin belum dipilih">
                                        <option value="" disabled selected>- Pilih Jenis Kelamin -</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" data-bv-notempty="true" data-bv-notempty-message="Tanggal Lahir tidak boleh kosong">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" data-bv-notempty="true" data-bv-notempty-message="Email tidak boleh kosong">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" data-bv-notempty="true" data-bv-notempty-message="Password tidak boleh kosong">
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
<?php $this->load->view('admin/footer') ?>
<script src="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table-id-ID.js') ?>"></script>
<script src="<?= base_url('/assets/lib/gijgo/gijgo.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-validator/bootstrapValidator.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-validator/id_ID.js') ?>"></script>
<script src="<?= base_url('/assets/lib/toast/toast.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/moment/moment-with-locales.min.js') ?>"></script>
<script src="<?= base_url('/assets/formProses.js') ?>"></script>

<script>
    formProses = new formProses('<?php echo base_url('api/manajemen') ?>', 'user');
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
                username: {
                    message: 'Username telah digunakan',
                    validators: {
                        notEmpty: {
                            message: 'Username tidak boleh kosong'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: 'Username harus lebih dari 6 karakter'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: 'Username hanya dapat terdiri dari abjad, angka, dan garis bawah'
                        },
                        callback: {
                            callback: function(value, validator, $fields) {
                                if (value == '') {
                                    return true;
                                }

                                return true;
                            }
                        }
                    }
                },
                password: {
                    message: 'Password tidak sesuai',
                    validators: {
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: 'Password harus lebih dari 6 karakter'
                        }
                    }
                },
                email: {
                    message: 'Email telah digunakan',
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

    $('input[name=username]').on('focusout', (evt) => {
        const value = evt.target.value;

        var send = [{
            'name': 'username'
        }, {
            'value': value
        }]

        if (value !== $('input[id=defaultUsername]').val()) {
            formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'admin', send)
                .then((res) => {
                    if (res) {
                        myForm
                            .bootstrapValidator('updateStatus', 'username', 'INVALID', 'callback')
                            .bootstrapValidator('validateField', 'username');
                    }
                });

            formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'pmi', send)
                .then((res) => {
                    if (res) {
                        myForm
                            .bootstrapValidator('updateStatus', 'username', 'INVALID', 'callback')
                            .bootstrapValidator('validateField', 'username');
                    }
                });

            formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'user', send)
                .then((res) => {
                    if (res) {
                        myForm
                            .bootstrapValidator('updateStatus', 'username', 'INVALID', 'callback')
                            .bootstrapValidator('validateField', 'username');
                    }
                });
        }
    })

    $('input[name=email]').on('focusout', (evt) => {
        const value = evt.target.value;

        var send = [{
            'name': 'email'
        }, {
            'value': value
        }]

        if (value !== $('input[id=defaultEmail]').val()) {
            formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'user', send)
                .then((res) => {
                    if (res) {
                        myForm
                            .bootstrapValidator('updateStatus', 'email', 'INVALID', 'callback')
                            .bootstrapValidator('validateField', 'email');
                    }
                });
        }
    })

    function setModalTambah() {
        myForm.bootstrapValidator('resetForm', true);
        myForm.trigger("reset");

        myModal.modal();
        $('#myModalLabel').html("Form Tambah Data User");

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
                tabel: 'tbl_user',
                kode: 'USR',
                panjang: 6
            });

            data['id'] = id;

            const ButtonText = $('#submitBtn').text();

            if (ButtonText == " Simpan") {
                const res = formProses.tambah(data);
                if (res[0] == true) {
                    toastr.success('Data user berhasil ditambahkan', 'Informasi', {
                        timeOut: 1000
                    })
                    myModal.modal('toggle');

                    myTabel.bootstrapTable('append', res[1]);
                }
            } else
            if (ButtonText == " Update") {
                const id = $('#id').val();
                const res = formProses.update(data, {
                    id
                });
                if (res[0] == true) {
                    toastr.success('Data user berhasil diubah', 'Informasi', {
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

    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

    setInputFilter(document.getElementById("telp"), function(value) {
        return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
    });
</script>

<script>
    function indexFormatter(val, row, index) {
        return index + 1;
    }

    function tglFormatter(val) {
        moment.locale('id');
        return moment(val).format('DD MMMM YYYY');
    }

    function golDarahFormatter(val) {
        return `<span class="badge bg-important">${val}</span>`
    }

    function totalFormatter(val, row) {
        if (val == undefined) {
            return '0';
        }
        return val;
    }

    function aksiFormatter(val) {
        return ["<button button data-toggle='tooltip' title='Ubah' class='ubah btn btn-theme btn-sm' > ",
            "<i class='fa fa-pencil'></i>",
            "</button>",
            "<button data-toggle='tooltip' title='Hapus' class='hapus btn btn-theme04 btn-sm'>",
            "<i class='fa fa-trash'></i>",
            "</button>",

        ].join(' ');
    }

    window.aksiEvents = {
        'click .ubah': function(e, value, row, index) {
            myForm.bootstrapValidator('resetForm', true);
            myForm.trigger("reset");

            myModal.modal();
            $('#myModalLabel').html("Form Ubah User");

            $('#id').val(row.id);
            $('#defaultUsername').val(row.username);
            $('#username').val(row.username);
            $('#defaultEmail').val(row.email);
            $('#telp').val(row.telp);
            $('#email').val(row.email);
            $('#password').val(row.password);
            $('#nama').val(row.nama);
            $('#jenis_kelamin').val(row.jenis_kelamin);
            $('#tgl_lahir').val(row.tgl_lahir);

            $('#submitBtn').html('<div><i class = "fa fa-edit"></i><span> Update</span></div>');
        },
        'click .hapus': function(e, value, row, index) {
            toastr.options = {
                "preventDuplicates": true
            };
            toastr.info("<br /><button type='button' class='btn btn-info' value='yes'>Ya</button> <button type='button' class='btn btn-danger' value='no' >Tidak</button>", 'Anda yakin untuk menghapus data ini?', {
                allowHtml: true,
                onclick: function(toast) {
                    value = toast.target.value
                    if (value == 'yes') {
                        const res = formProses.hapus({
                            id: row.id
                        });

                        if (res == true) {
                            toastr.remove();

                            toastr.success('Data user berhasil dihapus', 'Informasi', {
                                timeOut: 1000
                            })
                            myTabel.bootstrapTable('remove', {
                                field: 'id',
                                values: row.id
                            });
                        }

                    } else if (value == 'no') {
                        toastr.remove();
                    }
                }

            })

        }
    }
</script>
</body>

</html>