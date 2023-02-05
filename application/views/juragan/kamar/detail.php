<?php $this->load->view('dist/_partials/header'); ?>
<div class="main-content">
    <?= $this->session->userdata('status'); ?>
    <section class="detail-kamar">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">
                            <a href="<?= base_url('juragan/kamar') ?>"><i class="fa-solid fa-circle-arrow-left"></i> </a> Detail Kost - <?= $kamar[0]['nama'] ?> (penghuni : <?= ($transaksi) ? $transaksi[0]['fnama'] . ' ' . $transaksi[0]['lnama'] : '-' ?>)
                        </h4>
                        <div class="hapus-kamar">
                            <button class="btn btn-sm btn-sm btn-danger" onClick="hapus(this)" uid_kamar="<?= $kamar[0]['uid_kamar'] ?>" uid_kamar="<?= $kamar[0]['uid_gambar'] ?>" uid_gambar="<?= $kamar[0]['uid_gambar'] ?>"><i class="fa-solid fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="edit-form" action="<?= base_url('juragan/kamar/update') ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <input type="hidden" name="uid_kamar" class="uid_kamar" id="uid_kamar" value="<?= $kamar[0]['uid_kamar'] ?>">
                                    <input type="hidden" name="uid_gambar" class="uid_gambar" id="uid_gambar" value="<?= $kamar[0]['uid_gambar'] ?>">
                                    <input type="hidden" name="uid_member" class="uid_member" id="uid_member" value="<?= $kamar[0]['uid_member'] ?>">
                                    <input type="hidden" name="date_post" class="date_post" id="date_post" value="<?= $kamar[0]['date_post'] ?>">
                                    <div class="form-group">
                                        <label for="nama">Nama kamar</label>
                                        <input type="text" class="form-control nama" id="nama" value="<?= $kamar[0]['nama'] ?>" name="nama" required>
                                        <div class="invalid-feedback">
                                            Nama harus diisi!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label for="tipekamar">Tipe Kamar</label>
                                        <select name="tipe" id="tipe" class="form-control" required>
                                            <option value="A" <?= ($kamar[0]['tipe'] == 'A') ? 'selected' : '' ?>>Tipe A Maks. 1 orang/ kamar</option>
                                            <option value="B" <?= ($kamar[0]['tipe'] == 'B') ? 'selected' : '' ?>>Tipe B Maks. 2 orang/ kamar</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Tipe kamar harus dipilih!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label class="">Validasi Kamar</label>
                                    <?php
                                    if ($kamar[0]['status'] == 'DITOLAK') {
                                        echo '<input type="text" name="status" value="VALIDASI" hidden>';
                                    } else if ($kamar[0]['status'] == 'VALIDASI') {
                                        echo '<input type="text" name="status" value="VALIDASI" hidden>';
                                    } else if ($kamar[0]['status'] == 'APPROVE') {
                                        echo '<input type="text" name="status" value="APPROVE" hidden>';
                                    }
                                    ?>

                                    <a tabindex="0" class="btn btn-sm 
                                    <?php
                                    if ($kamar[0]['status'] == 'APPROVE') echo 'btn-success';
                                    if ($kamar[0]['status'] == 'VALIDASI') echo 'btn-warning';
                                    if ($kamar[0]['status'] == 'DITOLAK') echo 'btn-danger'; ?>
                                    " role="button" data-toggle="popover" data-trigger="focus" title="" data-content="Validasi kamar yaitu kamar sedang dicek oleh admin apakah data kamar layak tampil diwebsite atau tidak (APPROVE LOLOS VERIFIKASI, DITOLAK TIDAK LOLOS VERIFIKASI, PROSES VALIDASI SEDANG PROSES VERIFIKASI)" data-original-title="Validasi kamar">
                                        <?php
                                        if ($kamar[0]['status'] == 'APPROVE') echo 'APPROVE';
                                        if ($kamar[0]['status'] == 'VALIDASI') echo 'PROSES VALIDASI';
                                        if ($kamar[0]['status'] == 'DITOLAK') echo 'DI TOLAK';
                                        ?></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="harga">Jumlah kamar</label>
                                        <input class="form-control" type="number" name="jumlah_kamar" id="jumlah_kamar" min="<?= $kamar[0]['terjual'] ?>" value="<?= $kamar[0]['jumlah_kamar'] ?>" required>
                                        <span class="text-danger terjual"></span>
                                        <div class="invalid-feedback">
                                            Jumlah kamar harus diisi!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="nama">Harga kamar</label>
                                        <input type="text" class="form-control harga" min="100000" max="20000000" id="harga" name="harga" value="<?= $kamar[0]['harga'] ?>" required>
                                        <div class="invalid-feedback">
                                            Harga harus diisi! minimal Rp 100.000
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="nama">Diskon kamar</label>
                                        <input type="text" class="form-control diskon" id="diskon" name="diskon" value="<?= $kamar[0]['diskon'] ?>" required>
                                        <div class="invalid-feedback">
                                            Diskon harus diisi!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="font-weight-bold">FASILITAS</p>
                            <div class="row mb-2">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Fasilitas Umum</label>
                                        <select class="form-control select2" multiple name="f_umum[]" id="f_umum" style="width: 100%">
                                            <?php foreach ($f_umum as $f_umum) : ?>
                                                <option value="<?= $f_umum['uid_fasilitas'] ?>"><?= $f_umum['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Fasilitas Kamar</label>
                                        <select class="form-control select2" multiple name="f_kamar[]" id="f_kamar" style="width: 100%" required>
                                            <?php foreach ($f_kamar as $f_kamar) : ?>
                                                <option value="<?= $f_kamar['uid_fasilitas'] ?>"><?= $f_kamar['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Fasilitas Kamar harus dipilih!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Fasilitas Kamar Mandi</label>
                                        <select class="form-control select2" multiple name="f_kamar_mandi[]" id="f_kamar_mandi" style="width: 100%" required>
                                            <?php foreach ($f_kamar_mandi as $f_kamar_mandi) : ?>
                                                <option value="<?= $f_kamar_mandi['uid_fasilitas'] ?>"><?= $f_kamar_mandi['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Fasilitas Kamar Mandi harus dipilih!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Fasilitas Parkiran</label>
                                        <select class="form-control select2" multiple name="f_parkiran[]" id="f_parkiran" style="width: 100%">
                                            <?php foreach ($f_parkiran as $f_parkiran) : ?>
                                                <option value="<?= $f_parkiran['uid_fasilitas'] ?>"><?= $f_parkiran['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p class="font-weight-bold">DURASI DAN KATEGORI KAMAR:</p>
                            <div class="row mb-2">
                                <div class="col-lg-5 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Durasi</label>
                                        <select class="form-control select2 durasi" multiple name="durasi[]" id="durasi" required>
                                            <?php foreach ($durasi as $durasi) : ?>
                                                <option value="<?= $durasi['uid_durasi'] ?>"><?= $durasi['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Durasi harus dipilih!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label>Kategori kamar</label>
                                        <select class="form-control" name="kategori" id="kategori" style="width:100%;" required>
                                            <option value="">pilih kategori</option>
                                            <?php foreach ($kategori as $kategori) : ?>
                                                <option value="<?= $kategori['uid_kategori'] ?>" <?= ($kategori['uid_kategori'] === $kamar[0]['uid_kategori']) ? 'selected' : ''; ?>><?= $kategori['nama_kategori'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Kategori harus dipilih!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="luaskamar">Luas kamar</label>
                                        <input type="text" class="form-control luaskamar" name="luaskamar" id="luaskamar" value="<?= $kamar[0]['luas_kamar'] ?>" required>
                                        <div class="invalid-feedback">
                                            Luas kamar harus diisi!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi kamar</label>
                                        <textarea name="deskripsi" class="deskripsi" id="deskripsi" style="height: 200px;" required><?= $kamar[0]['deskripsi'] ?></textarea>
                                        <div class="invalid-feedback">
                                            Diskripsi harus diisi!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="Alamat">Alamat</label>
                                        <input type="text" class="form-control alamat" name="alamat" id="alamat" style="height: 80px;" placeholder="Masukan alamat lengkap" value="<?= $kamar[0]['alamat'] ?>" required>
                                        <div class="invalid-feedback">
                                            Alamat harus diisi!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="Provinsi">Provinsi</label>
                                        <select class="form-control provinsi" name="provinsi" id="provinsi" required>
                                        </select>
                                        <div class="invalid-feedback">
                                            Provinsi harus dipilih!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="Kota">Kota</label>
                                        <select class="form-control kota" name="kota" id="kota" required>
                                            <option value="">Pilih Kota/Kabupaten</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Kota/kabupaten harus dipilih!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="Kota">Lokasi Maps embed</label><br>
                                        <small>Tutorial mengambil embed maps? <a href="">Cara Embed</a></small>
                                        <input type="text" class="form-control maps" id="maps" name="maps" placeholder="Masukan iframe dari embed maps jika ingin menggunakan maps pada lokasi kost anda">
                                        <input type="text" hidden name="hidden_maps" id="hidden_maps" value="<?= $kamar[0]['maps'] ?>">
                                        <small>Maps lokasi kost anda:</small>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 maps-frame" id="maps-frame">
                                                <?= $kamar[0]['maps'] != "" ? $this->secure->decrypt_url($kamar[0]['maps']) : ''; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h6>Gambar kamar</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="gambar_satu">Gambar 1</label>
                                                <input class="form-control" type="file" name="gambar_satu" id="gambar_satu" accept="img/*">
                                                <input class="form-control" type="text" name="gambar_satu_hidden" id="gambar_satu_hidden" value="<?= ($gambar[0]['gambar_satu'] != "") ? $gambar[0]['gambar_satu'] : "" ?>" hidden>
                                                <img class="gambar_satu_pre" id="gambar_satu_pre" src=""></img>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="gambar_dua">Gambar 2</label>
                                                <input class="form-control" type="file" name="gambar_dua" id="gambar_dua" accept="img/*">
                                                <input class="form-control" type="text" name="gambar_dua_hidden" id="gambar_dua_hidden" value="<?= ($gambar[0]['gambar_dua'] != "") ? $gambar[0]['gambar_dua'] : "" ?>" hidden>
                                                <img class="gambar_dua_pre" id="gambar_dua_pre"></img>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="gambar_tiga">Gambar 3</label>
                                                <input class="form-control" type="file" name="gambar_tiga" id="gambar_tiga" accept="img/*">
                                                <input class="form-control" type="text" name="gambar_tiga_hidden" id="gambar_tiga_hidden" value="<?= ($gambar[0]['gambar_tiga'] != "") ? $gambar[0]['gambar_tiga'] : "" ?>" hidden>
                                                <img class="gambar_tiga_pre" id="gambar_tiga_pre"></img>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="gambar_empat">Gambar 4</label>
                                                <input class="form-control" type="file" name="gambar_empat" id="gambar_empat" accept="img/*">
                                                <input class="form-control" type="text" name="gambar_empat_hidden" id="gambar_empat_hidden" value="<?= ($gambar[0]['gambar_empat'] != "") ? $gambar[0]['gambar_empat'] : "" ?>" hidden>
                                                <img class="gambar_empat_pre" id="gambar_empat_pre"></img>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="gambar_lima">Gambar 5</label>
                                                <input class="form-control" type="file" name="gambar_lima" id="gambar_lima" accept="img/*">
                                                <input class="form-control" type="text" name="gambar_lima_hidden" id="gambar_lima_hidden" value="<?= ($gambar[0]['gambar_lima'] != "") ? $gambar[0]['gambar_lima'] : "" ?>" hidden>
                                                <img class="gambar_lima_pre" id="gambar_lima_pre"></img>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($kamar[0]['status'] == 'DITOLAK') {
                                echo '<button type="submit" name="submit" class="next btn btn-info simpan" id="simpan">Ajukan Ulang</button>';
                            } else if ($kamar[0]['status'] == 'VALIDASI') {
                                // echo '<button type="submit" name="submit" class="next btn btn-info simpan" id="simpan" disabled>PROSES VALIDASI</button>';
                            } else if ($kamar[0]['status'] == 'APPROVE') {
                                echo '<button type="submit" name="submit" class="next btn btn-info simpan" id="simpan">Simpan</button>';
                            }
                            ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('dist/_partials/footer'); ?>
<script>
    var prov_id;
    $(document).ready(function() {
        $('#jumlah_kamar').change(function() {
            var terjual = '<?= $kamar[0]['terjual'] ?>';
            if ($('#jumlah_kamar').val() < terjual) {
                console.log($('#jumlah_kamar').val())
                $('.terjual').html('Kamar tersewa ' + terjual + ', tidak bisa merubah dibawah ' + terjual);
                $('.simpan').prop('disabled', 'disabled');
                swal({
                    icon: 'warning',
                    text: 'Kamar tersewa ' + terjual + ', tidak bisa merubah dibawah ' + terjual
                })
            } else {
                $('.simpan').removeAttr('disabled');
                $('.terjual').html('');
            }
        })
        <?php
        if ($kamar[0]['status'] == "VALIDASI") {
        ?>
            swal({
                title: 'kamar sedang proses validasi oleh tim',
                text: 'Data kamar anda sedang proses validasi, sehingga anda tidak dapat melakukan perubahan',
                icon: 'warning'
            })
            $('#deskripsi').summernote('disable');
            $('#edit-form :input').prop('disabled', true);
        <?php
        } else if ($kamar[0]['status'] == 'DITOLAK') {
        ?>
            swal({
                title: 'kamar ditolak oleh tim',
                text: 'kamar anda ditolak, silahkan ajukan kamar lagi dengan mengedit terlebih dahulu',
                icon: 'error'
            })

        <?php
        }
        ?>
        <?php if (isset($_SESSION['response']) && $_SESSION['response'] !== '') : ?>
            swal({
                title: "<?php echo $_SESSION['response']['status']; ?>",
                text: "<?php echo $_SESSION['response']['message']; ?>",
                icon: "<?php echo $_SESSION['response']['status']; ?>"
            });
        <?php unset($_SESSION['response']);
        endif; ?>

        // set fasilitas umum
        var fasilitas = new Array();
        var f = 0;
        <?php
        $faSet = explode(',', $kamar[0]['uid_fasilitas']);
        $fa = 0;
        if (!empty($faSet[0])) {
            while ($fa < count($faSet)) {
        ?>
                fasilitas[f] = <?= $faSet[$fa] ?>;
                f++;
            <?php
                $fa++;
            }
            ?>
            $('#f_umum').val(fasilitas);
            $('#f_umum').trigger('change');
        <?php
        } else {
        }
        ?>
        <?php
        $faSet = explode(',', $kamar[0]['uid_fasilitas']);
        $fa = 0;
        if (!empty($faSet[0])) {
            while ($fa < count($faSet)) {
        ?>
                fasilitas[f] = <?= $faSet[$fa] ?>;
                f++;
            <?php
                $fa++;
            }
            ?>
            $('#f_kamar').val(fasilitas);
            $('#f_kamar').trigger('change');
        <?php
        } else {
        }
        ?>
        <?php
        $faSet = explode(',', $kamar[0]['uid_fasilitas']);
        $fa = 0;
        if (!empty($faSet[0])) {
            while ($fa < count($faSet)) {
        ?>
                fasilitas[f] = <?= $faSet[$fa] ?>;
                f++;
            <?php
                $fa++;
            }
            ?>
            $('#f_kamar_mandi').val(fasilitas);
            $('#f_kamar_mandi').trigger('change');
        <?php
        } else {
        }
        ?>
        <?php
        $faSet = explode(',', $kamar[0]['uid_fasilitas']);
        $fa = 0;
        if (!empty($faSet[0])) {
            while ($fa < count($faSet)) {
        ?>
                fasilitas[f] = <?= $faSet[$fa] ?>;
                f++;
            <?php
                $fa++;
            }
            ?>
            $('#f_parkiran').val(fasilitas);
            $('#f_parkiran').trigger('change');
        <?php
        } else {
        }
        ?>

        // set durasi
        var durasi = new Array();
        var d = 0;
        <?php
        $duSet = explode(',', $kamar[0]['uid_durasi']);
        $du = 0;
        if (!empty($duSet[0])) {
            while ($du < count($duSet)) {
        ?>
                durasi[d] = <?= $duSet[$du] ?>;
                d++;
            <?php
                $du++;
            }
            ?>
            $('#durasi').val(durasi);
            $('#durasi').trigger('change');
        <?php
        } else {
        }
        ?>
        // set kategori

        var kategori = new Array();
        var k = 0;
        <?php
        $kaSet = explode(',', $kamar[0]['uid_kategori']);
        $ka = 0;
        if (!empty($kaSet[0])) {
            while ($ka < count($kaSet)) {
        ?>
                kategori[k] = <?= $kaSet[$ka] ?>;
                k++;
            <?php
                $ka++;
            }
            ?>
            $('#kategori').val(kategori);
            $('#kategori').trigger('change');
        <?php
        } else {
        }
        ?>

        $('#edit-form').submit(function(e) {
            e.preventDefault();
            form = $(this);
            var status = $('#status_hide').val();
            if (status == 1) {
                swal({
                        title: "Apakah anda yakin?",
                        text: "Kamar berstatus penghuni!, jika anda edit status penghuni, maka data transaksi penghuni akan berubah statusnya selesai",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willUpdate) => {
                        if (willUpdate) {
                            $.ajax({
                                url: "<?= base_url('juragan/kamar/update') ?>",
                                type: "POST",
                                dataType: "JSON",
                                data: new FormData(this),
                                processData: false,
                                contentType: false,
                                cache: false,
                                async: false,
                                success: function(data) {
                                    location.reload();
                                }
                            })
                        } else {}
                    });
            } else {
                $.ajax({
                    url: "<?= base_url('juragan/kamar/update') ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(data) {
                        location.reload();
                    }
                })
            }
        })

        // deskripsi kamar
        $('#deskripsi').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
        });

        var app = {
            show: function() {
                $.ajax({
                    url: "<?= base_url('assets/wilayah/provinces.json') ?>",
                    method: "GET",
                    success: function(data) {
                        var html = '';
                        var provinsi = data;
                        for (var i = 0; i < provinsi.length; i++) {
                            if ("<?= $kamar[0]['provinsi'] ?>" === provinsi[i].name) {
                                html += '<option value="' + provinsi[i].name + '" kota-id="' + provinsi[i].id + '" selected>' + provinsi[i].name + '</option>';
                            } else {
                                html += '<option value="' + provinsi[i].name + '" kota-id="' + provinsi[i].id + '">' + provinsi[i].name + '</option>';
                            }

                        }
                        $("#provinsi").html(html);
                    }
                })
            },
            tampil: function() {
                var provinsi_id = $(this);
                var kotaId = $('option:selected', this).attr('kota-id');
                $.ajax({
                    url: "<?= base_url('assets/wilayah/regencies/') ?>" + kotaId + '.json',
                    method: "GET",
                    success: function(data) {
                        var html = '';
                        var kabupaten = data;
                        for (var i = 0; i < kabupaten.length; i++) {
                            html += '<option value="' + kabupaten[i].name + '">' + kabupaten[i].name + '</option>';
                        }
                        $("#kota").html(html);
                    }
                })
            },
            replace: function(prov_id) {
                var provinsi_id = $(this);
                var kotaId = $('option:selected', this).attr('kota-id');
                $.ajax({
                    url: "<?= base_url('api/kabupaten/') ?>" + prov_id,
                    method: "GET",
                    success: function(data) {
                        var html = '';
                        var kabupaten = JSON.parse(data);
                        for (var i = 0; i < kabupaten.length; i++) {
                            if ("<?= $kamar[0]['kota'] ?>" === kabupaten[i].name) {
                                html += '<option value="' + kabupaten[i].name + '" kota-id="' + kabupaten[i].id + '" selected>' + kabupaten[i].name + '</option>';
                            } else {
                                html += '<option value="' + kabupaten[i].name + '" kota-id="' + kabupaten[i].id + '">' + kabupaten[i].name + '</option>';
                            }
                        }
                        $("#kota").html(html);
                    }
                })
            }
        };
        window.addEventListener('load', function() {
            var eles = document.getElementById('provinsi').selectedOptions;
            prov_id = eles[0].attributes[1].value;
            console.log(prov_id)
            app.replace(prov_id);
        })
        app.show();
        $(document).on("change", "#provinsi", app.tampil);

        gambar();
        response();
        var frame = $('#maps-frame iframe').length;
        if (frame != 0) {
            $('#maps-frame iframe')[0].attributes[1].textContent = "100%";
            $('#maps-frame iframe')[0].attributes[2].textContent = "300px";
        } else {
            $('#maps').on('change', function() {
                $('.maps-frame').html($(this).val());
            })
        }
    })

    function response() {
        <?php
        if ($this->session->userdata('status') === "success") {
        ?>
            swal({
                text: "data berhasil di update!",
            });
        <?php
        } else {
            $this->session->unset_userdata('status');
        }
        ?>
    }

    // function gambar
    function gambar() {
        // section gambar
        gambar_satu = document.getElementById('gambar_satu');
        gambar_satu_pre = document.getElementById('gambar_satu_pre');
        gambar_dua = document.getElementById('gambar_dua');
        gambar_dua_pre = document.getElementById('gambar_dua_pre');
        gambar_tiga = document.getElementById('gambar_tiga');
        gambar_tiga_pre = document.getElementById('gambar_tiga_pre');
        gambar_empat = document.getElementById('gambar_empat');
        gambar_empat_pre = document.getElementById('gambar_empat_pre');
        gambar_lima = document.getElementById('gambar_lima');
        gambar_lima_pre = document.getElementById('gambar_lima_pre');
        <?php
        if ($gambar[0]['gambar_satu'] != NULL) {
        ?> gambar_satu_pre.src = '<?= base_url('public/images/kamar/') . $gambar[0]['gambar_satu'] ?>';
            document.getElementById('gambar_satu_pre').classList.add('image-upload');
        <?php
        }
        if ($gambar[0]['gambar_dua'] != NULL) {
        ?> gambar_dua_pre.src = '<?= base_url('public/images/kamar/') . $gambar[0]['gambar_dua'] ?>';
            document.getElementById('gambar_dua_pre').classList.add('image-upload');
        <?php
        }
        if ($gambar[0]['gambar_tiga'] != NULL) {
        ?> gambar_tiga_pre.src = '<?= base_url('public/images/kamar/') . $gambar[0]['gambar_tiga'] ?>';
            document.getElementById('gambar_tiga_pre').classList.add('image-upload');
        <?php
        }
        if ($gambar[0]['gambar_empat'] != NULL) {
        ?> gambar_empat_pre.src = '<?= base_url('public/images/kamar/') . $gambar[0]['gambar_empat'] ?>';
            document.getElementById('gambar_empat_pre').classList.add('image-upload');
        <?php
        }
        if ($gambar[0]['gambar_lima'] != NULL) {
        ?> gambar_lima_pre.src = '<?= base_url('public/images/kamar/') . $gambar[0]['gambar_lima'] ?>';
            document.getElementById('gambar_lima_pre').classList.add('image-upload');
        <?php
        }
        ?> gambar_satu.onchange = evt => {
            const [file] = gambar_satu.files;
            if (file) {
                gambar_satu_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_satu_pre').classList.add('image-upload');
            }
        }
        gambar_dua.onchange = evt => {
            const [file] = gambar_dua.files;
            if (file) {
                gambar_dua_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_dua_pre').classList.add('image-upload');
            }
        }
        gambar_tiga.onchange = evt => {
            const [file] = gambar_tiga.files;
            if (file) {
                gambar_tiga_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_tiga_pre').classList.add('image-upload');
            }
        }
        gambar_empat.onchange = evt => {
            const [file] = gambar_empat.files;
            if (file) {
                gambar_empat_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_empat_pre').classList.add('image-upload');
            }
        }
        gambar_lima.onchange = evt => {
            const [file] = gambar_lima.files;
            if (file) {
                gambar_lima_pre.src = URL.createObjectURL(file);
                document.getElementById('gambar_lima_pre').classList.add('image-upload');
            }
        }
    }

    function hapus(data) {
        var uid_kamar = $(data).attr('uid_kamar');
        var uid_gambar = $(data).attr('uid_gambar');
        swal({
                title: "Apakah anda yakin?",
                text: "ketika anda hapus, maka data tidak bisa dikembalikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '<?= base_url('juragan/kamar/delete') ?>',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            uid_kamar: uid_kamar,
                            uid_gambar: uid_gambar
                        },
                        success: function(response) {
                            if (response['code'] === 200) {
                                swal(response['message'], {
                                    icon: response['status'],
                                });
                                window.location.replace('<?= base_url('juragan/kamar') ?>');
                            } else {
                                swal(response['message'], {
                                    icon: response['status'],
                                });
                                window.location.replace('<?= base_url('juragan/kamar') ?>');
                            }
                        }
                    })
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });

    }
</script>