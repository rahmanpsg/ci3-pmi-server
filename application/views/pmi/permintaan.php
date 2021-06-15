<?php $this->load->view('pmi/header') ?>
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
                    <h3><i class="fa fa-angle-right"></i> Form Permintaan Darah</h3>
                    <div class="adv-table">
                        <table class="table align-items-center table-flush" id="myTable" data-url='<?= $TBL_URL; ?>' data-toggle="table" data-pagination="true" data-search="true" data-detail-view="true" data-detail-formatter="detailFormatter" data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="no" data-formatter="indexFormatter" class="font-14 text-center">#</th>
                                    <th data-field="id">ID</th>
                                    <th data-field="gol_darah" data-formatter="golDarahFormatter" class="text-center">Golongan Darah</th>
                                    <th data-field="jumlah" data-formatter="jumlahFormatter" class="text-center">Jumlah</th>
                                    <th data-field="nama" class="text-center">Dari</th>
                                    <th data-field="telp" class="text-center">Nomor Telpon</th>
                                    <th data-field="file" data-formatter="fileFormatter" class="text-center">Surat Pengantar</th>
                                    <th data-field="status" data-formatter="statusFormatter" class="text-center">Status</th>
                                    <th data-field="aksi" data-formatter="aksiFormatter" data-events="window.aksiEvents" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /row -->

    </section>
</section>
<!--main content end-->
<?php $this->load->view('pmi/footer') ?>
<script src="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/bootstrap-table/bootstrap-table-id-ID.js') ?>"></script>
<script src="<?= base_url('/assets/lib/toast/toast.min.js') ?>"></script>
<script src="<?= base_url('/assets/lib/moment/moment-with-locales.min.js') ?>"></script>
<script src="<?= base_url('/assets/formProses.js') ?>"></script>

<script type="text/javascript">
    formProses = new formProses('<?php echo base_url('api/manajemenOrder') ?>', 'Permintaan');
    const myTabel = $('#myTable');

    function kirimAksi(status, id, teks, token) {
        const data = {
            status
        }

        toastr.options = {
            "preventDuplicates": true
        };
        toastr.info("<br /><button type='button' class='btn btn-info' value='yes'>Ya</button> <button type='button' class='btn btn-danger' value='no' >Tidak</button>", teks, {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {
                    const res = formProses.update(data, {
                        id: id
                    });

                    console.log(res);

                    if (res[0] == true) {
                        toastr.remove();

                        toastr.success(`Permintaan material berhasil ${status}`, 'Informasi', {
                            timeOut: 1000
                        })
                        myTabel.bootstrapTable('updateByUniqueId', {
                            id: id,
                            row: res[1]
                        });

                        let body;

                        switch(status){
                            case 'Dikonfirmasi':
                                body = 'Permintaan darah anda telah dikonfirmasi';
                                break;
                            case 'Ditolak':
                                body = 'Maaf permintaan darah anda ditolak';
                                break;
                            case 'Diterima':
                                body = 'Terimakasih telah mengorder darah di UTD Palang Merah Indonesia';
                                break;
                        }

                        formProses.kirimNotikasi('<?= base_url('api/kirimNotifikasi') ?>','UTD Palang Merah Indonesia', body, token);                        
                    }

                } else if (value == 'no') {
                    toastr.remove();
                }
            }

        })
    }
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
        return `<span class="badge bg-important style="font-size:20px;">${val}</span>`
    }

    function jumlahFormatter(val, row) {
        return `${val} Kantong`;
    }

    function fileFormatter(val, row) {
        const URL = "<?= base_url('file') ?>/" + `${row.id}/${val}`;

        return `<a href='${URL}' target='_blank' data-toggle='tooltip' title='Download Surat Pengantar' class='btn btn-theme btn-sm'><i class='fa fa-download'></i> Download</a>`;
    }

    function detailFormatter(index, row) {
        var html = [],
            nilai = [];

        html.push("<table class='table table-sm table-striped' style='width:400px'>");

        html.push("<tr><th colspan='3' class='text-center'>History Order</th></tr>");
        $.each(JSON.parse(row.history), function(key, val) {
            html.push('<tr><td>' + `Tanggal ${key}` + '</td><td>:</td><td>' + moment(val).format('HH:mm:ss DD/MM/YYYY') + '</td></tr>');
        })

        html.push("</table>");

        return html.join('')
    }

    function statusFormatter(val, row) {
        switch (val) {
            case 'Order':
                return `<span class="label label-default">Belum dikonfirmasi</span>`
                break;
            case 'Ditolak':
                return `<span class="label label-danger">${val}</span>`
                break;
            case 'Dikonfirmasi':
                return `<span class="label label-info">${val}</span>`
                break;
            case 'Diterima':
                return `<span class="label label-success">${val}</span>`
                break;
        }
    }

    function aksiFormatter(val, row) {
        switch (row.status) {
            case 'Order':
                return ["<button button data-toggle='tooltip' title='Konfirmasi' class='konfirmasi btn btn-theme btn-sm' > ",
                    "<i class='fa fa-check'></i>",
                    "</button>",
                    "<button data-toggle='tooltip' title='Tolak' class='tolak btn btn-theme04 btn-sm'>",
                    "<i class='fa fa-close'></i>",
                    "</button>"
                ].join(' ');
                break;
            case 'Ditolak':
                return `-`
                break;
            case 'Dikonfirmasi':
                return ["<button button data-toggle='tooltip' title='Diterima jika darah telah diterima oleh user' class='diterima btn btn-theme btn-sm' > ",
                    "<i class='fa fa-check'></i> Konfirmasi Penerimaan",
                    "</button>"
                ].join(' ');
                break;
            case 'Diterima':
                return `<span class="label label-success">Selesai</span>`
                break;
        }
    }

    window.aksiEvents = {
        'click .konfirmasi': function(e, value, row, index) {
            const cek = formProses.getData('<?php echo base_url('api/getTotalDarah/') . $this->id  ?>', {
                gol_darah: row.gol_darah
            }, 'GET');

            console.log(cek);

            if (parseInt(row.jumlah) > parseInt(cek)) {
                toastr.error(`Total stok darah tidak mencukupi`, {
                    timeOut: 500
                })
            } else {
                kirimAksi('Dikonfirmasi', row.id, 'Anda yakin untuk konfirmasi orderan ini?', row.token);
            }
        },
        'click .tolak': function(e, value, row, index) {
            kirimAksi('Ditolak', row.id, 'Anda yakin untuk menolak orderan ini?', row.token);
        },
        'click .diterima': function(e, value, row, index) {
            kirimAksi('Diterima', row.id, 'Stok darah akan otomatis berkurang setelah dikonfirmasi', row.token);
        }
    }
</script>
</body>

</html>