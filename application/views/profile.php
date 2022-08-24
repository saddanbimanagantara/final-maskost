<?php $this->load->view('dist/_partials/header'); ?>

<style>
    .imagePreview {
        background: url("<?= base_url("assets/img/profile/") . $member['otoritas'] . '/' . $member['image'] ?>");
    }

    .avatar-upload {
        position: relative;
        max-width: 205px;
        margin: 50px auto;
    }

    .avatar-upload .avatar-edit {
        position: absolute;
        right: 12px;
        z-index: 1;
        top: 10px;
    }

    .avatar-upload .avatar-edit input {
        display: none;
    }

    .avatar-upload .avatar-edit input+label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #ffffff;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }

    .avatar-upload .avatar-edit input+label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }

    .avatar-upload .avatar-edit input+label:after {
        content: "\f040";
        font-family: "FontAwesome";
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    .avatar-upload .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #f8f8f8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }

    .avatar-upload .avatar-preview>div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<div class="main-content">
    <?php
    if ($this->session->flashdata('message')) {
    ?>
        <script src="http://localhost/sk-kost/assets/modules/sweetalert/sweetalert.min.js"></script>
        <script>
            swal({
                title: "<?= $this->session->flashdata('icon') ?>",
                text: "<?= $this->session->flashdata('message') ?>",
                icon: "<?= $this->session->flashdata('icon') ?>"
            })
        </script>
    <?php
    }
    ?>
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, <?= $member['fnama'] . ' ' . $member['lnama'] ?>!</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>
            <div class="card">
                <form action="<?= base_url('profile/edit') ?>" method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="avatar-upload d-flex justify-content-center">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" class="imagePreview">
                                        </div>
                                        <div class="avatar-name mt-3 d-flex justify-content-center">
                                            <h6><?= $member['fnama'] . ' ' . $member['lnama'] ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-8">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama depan</label>
                                        <input type="text" class="form-control" id="fnama" name="fnama" value="<?= $member['fnama'] ?>" required="">
                                        <div class="invalid-feedback">
                                            Tolong masukan nama depan
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama belakang</label>
                                        <input type="text" class="form-control" id="lnama" name="lnama" value="<?= $member['lnama'] ?>" required="">
                                        <div class="invalid-feedback">
                                            Tolong masukan nama belakang
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-8 col-8">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $member['email'] ?>" required="" disabled>
                                        <div class="invalid-feedback">
                                            Tolong masukan email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-4">
                                        <label>No telepon</label>
                                        <input type="tel" class="form-control" id="no_hp" name="no_hp" value="<?= $member['no_hp'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control"><?= $member['alamat']; ?></textarea>
                                        <div class="invalid-feedback">
                                            Tolong masukan alamat
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary float-right mb-2">simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('dist/_partials/footer'); ?>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
        var file_data = $('#imageUpload').prop('files')[0];
        console.log(file_data);
        var form_data = new FormData();
        form_data.append('imageUpload', file_data);
        $.ajax({
            url: "<?= base_url('profile/do_upload') ?>",
            data: form_data,
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            dataType: "JSON",
            success: function(response) {
                swal({
                    title: response.icon,
                    text: response.message,
                    icon: response.icon
                })
            }
        })
    });
</script>