<?php
if ($this->session->flashdata('notifikasi') != "") {
    if ($this->session->flashdata('notifikasi') === "pendaftaran_berhasil") {
        echo '<script>swal("Pendaftaran berhasil!", "Pendaftaran Berhasil, silahkan cek email untuk verifikasi", "success");</script>';
    } else if ($this->session->flashdata('notifikasi') === "pendaftaran_gagal") {
        echo '<script>swal("Pendaftaran gagal!", "Pendaftaran gagal, silahkan coba lagi", "error");</script>';
    } else if ($this->session->flashdata('notifikasi') === "verifikasi_berhasil") {
        echo '<script>swal("Verifikasi berhasil!", "verifikasi email berhasil! silahkan login", "success");</script>';
    } else if ($this->session->flashdata('notifikasi') === "verifikasi_gagal") {
        echo '<script>swal("Verifikasi berhasil!", "Verifikasi gagal", "success");</script>';
    } else if ($this->session->flashdata('notifikasi') === "login_gagal") {
        echo '<script>swal("Login gagal!", "Email atau password salah atau Email tidak terdaftar", "error");</script>';
    } else if ($this->session->flashdata('notifikasi') === "logout_berhasil") {
        echo '<script>swal("Logout berhasil!", "Berhasil keluar", "success");</script>';
    } else if ($this->session->flashdata('notifikasi') === "ganti_berhasil") {
        echo '<script>swal("Ganti password berhasil!", "Ganti password berhasil", "success");</script>';
    } else if ($this->session->flashdata('notifikasi') === "ganti_gagal") {
        echo '<script>swal("Ganti password gagal!", "Ganti password gagal", "error");</script>';
    } else if ($this->session->flashdata('notifikasi') === "password_notmatches") {
        echo '<script>swal("Ganti password gagal!", "password anda tidak sesuai dengan akun anda!=", "error");</script>';
    } else if ($this->session->flashdata('notifikasi') === "proses_berhasil") {
        echo '<script>swal("Withdraw berhasil!", "Withdraw berhasil diupdate dan transfer", "success");</script>';
    } else if ($this->session->flashdata('notifikasi') === "proses_gagal") {
        echo '<script>swal("Withdraw gagal!", "Withdraw gagal diupdate dan transfer", "error");</script>';
    } else if ($this->session->flashdata('notifikasi') === "sendContact_berhasil") {
        echo '<script>swal("Contact berhasil!", "Pesan berhasil dikirim ke maskost", "success");</script>';
    } else if ($this->session->flashdata('notifikasi') === "sendContact_gagal") {
        echo '<script>swal("Contact gagal!", "Pesan gagal dikirim ke maskost", "error");</script>';
    } else if ($this->session->flashdata('notifikasi') === "forgetpasswordsend_success") {
        echo '<script>swal("Reset berhasil!", "Silahkan cek email untuk reset password", "success");</script>';
    } else if ($this->session->flashdata('notifikasi' === "forgetpasswordsend_error")) {
        echo '<script>swal("Reset gagal!", "Kesalahan sistem", "error");</script>';
    } else if ($this->session->flashdata('notifikasi' === "forgetpassword_success")) {
        echo '<script>swal("Berhasil!", "Ganti password berhasil diganti", "success");</script>';
    } else if ($this->session->flashdata('notifikasi' === "forgetpassword_error")) {
        echo '<script>swal("Gagal!", "Kesalahan sistem", "error");</script>';
    } else if ($this->session->flashdata('notifikasi' === "token_or_email_invalid")) {
        echo '<script>swal("Gagal!", "Email atau token yang anda gunakan tidak valid", "error");</script>';
    }
}
