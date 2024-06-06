<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php echo $title ?> | <?php echo $this->data['company_data']->company_name ?></title>
  <meta charset="utf-8">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <meta name="description" content="A Freelance Web Developer from Palembang, Indonesia">
  <meta name="author" content="Azmi Cole Jr">
  <!-- Theme -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="<?php echo base_url() ?>assets/template/frontend/css/core.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url() ?>assets/template/frontend/css/custom.css" rel="stylesheet">
  <script src="<?php echo base_url() ?>assets/plugins/jquery/jquery-3.3.1.js" rel="stylesheet"></script>
  <script src="<?php echo base_url() ?>assets/template/frontend/js/popper.min.js" rel="stylesheet"></script>
  <script src="<?php echo base_url() ?>assets/template/frontend/js/bootstrap.min.js" rel="stylesheet"></script>
  <script src="<?php echo base_url() ?>assets/template/frontend/js/moment.min.js" rel="stylesheet"></script>
  <script>
    $(document).ready(function () {
      var autocompleteInput = $('#autocompleteInput');
      var autocompleteResults = $('#autocompleteResults');

      autocompleteInput.on('input', function () {
        var searchValue = $(this).val();
        console.log(searchValue);
        $.ajax({
          url: "<?php echo base_url('beranda/get_data'); ?>",
          type: "POST",
          data: {
            search: searchValue
          },
          dataType: "json",
          success: function (data) {
            autocompleteResults.empty();
            $.each(data.items, function (index, item) {
              var resultItem = $('<div class="result-item">' + item
                .nama_kost + '</div>');
              autocompleteResults.append(resultItem);
            });
            autocompleteResults.show();
          }
        });
      });

      // Event delegation untuk menangani hasil yang diklik
      autocompleteResults.on('click', '.result-item', function () {
        var selectedItem = $(this).text();
        autocompleteInput.val(selectedItem);
        autocompleteResults.hide();
      });

      // Sembunyikan hasil pencarian saat klik di luar elemen input atau hasil
      $(document).on('click', function (event) {
        if (!$(event.target).closest('#autocompleteInput, #autocompleteResults').length) {
          autocompleteResults.hide();
        }
      });
    });
  </script>
  <link href="<?php echo base_url() ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
    type="text/css" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url('assets/images/kostq.png') ?>" />
</head>