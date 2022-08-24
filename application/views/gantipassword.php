<?php $this->load->view('dist/_partials/header'); ?>

<div class="main-content">
    <?php $this->load->view('dist/_partials/notif') ?>
    <div class="col-5">
        <div class="card">
            <div class="card-header">
                Ganti password
            </div>
            <div class="card-body">
                <form action="<?= base_url('profile/gantipassword') ?>" method="POST">
                    <div class="form-group">
                        <label for="password_baru">Password baru</label>
                        <input type="password" name="password_baru" id="password_baru" class="form-control" value="<?= set_value('password_baru') ?>">
                        <small class="text-danger">
                            <?= form_error('password_baru') ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Password lama</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?= set_value('password') ?>">
                        <small class="text-danger">
                            <?= form_error('password') ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Ulangi password lama</label>
                        <input type="password" name="password2" id="password2" class="form-control" value="<?= set_value('password2') ?>">
                        <small class="text-danger">
                            <?= form_error('password2') ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="showPass"> Show password
                    </div>
                    <button type="submit" class="btn btn-md btn-primary float-right">Ganti</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>
<script>
    $(document).ready(function() {

        $('#showPass').on('click', function() {
            var passBaru = $("#password_baru");
            var pass = $("#password");
            var pass2 = $("#password2");
            if (passBaru.attr('type') === 'password') {
                passBaru.attr('type', 'text');
                pass.attr('type', 'text');
                pass2.attr('type', 'text');
            } else {
                passBaru.attr('type', 'password');
                pass.attr('type', 'password');
                pass2.attr('type', 'password');
            }
        })
    })
</script>