<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <h1>404</h1>
            <div class="page-description">
              The page you were looking for could not be found.
            </div>
            <div class="page-search">
              <div class="mt-3">
                <a href="<?php echo base_url(); ?>">Back to Home</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php $this->load->view('dist/_partials/js'); ?>