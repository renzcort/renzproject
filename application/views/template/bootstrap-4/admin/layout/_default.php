<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/template/bootstrap-4/') ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <title><?php echo ($title ? ucfirst($title) : ''); ?></title>
    <style type="text/css">
    #dialog label, #dialog input { display:block; }
    #dialog label { margin-top: 0.5em; }
    #dialog input, #dialog textarea { width: 95%; }
    #tabs { margin-top: 1em; }
    #tabs li .ui-icon-close { float: left; margin: 0.4em 0.2em 0 0; cursor: pointer; }
    #add_tab { cursor: pointer; }
    </style>
  </head>
  <body>
    <?php $this->load->view('template/bootstrap-4/admin/partial/nav'); ?>
    <div class="wraper">
      <div class="d-flex flex-wrap align-items-stretch justify-content-start">
        <div class="left-main" id="sidebar-main">
          <?php $this->load->view('template/bootstrap-4/admin/partial/sidebar'); ?>
        </div>
        <div class="right-main ml-auto flex-grow-1" id="content-main">
          <main role="main">
            <div class="main d-flex flex-column">
              <div id="header">
                <?php $this->load->view('template/bootstrap-4/admin/partial/header'); ?>
              </div>
              <div class="container d-flex flex-row flex-wrap justify-content-start" id="content-wraper">
                <?php $this->load->view($content); ?>
              </div>
              <div class="text-center" id="footer">
                <?php $this->load->view('template/bootstrap-4/admin/partial/footer'); ?>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>
    <!-- Show Modal Dialog  -->
    <?php $this->load->view('template/bootstrap-4/admin/partial/modal-dialog'); ?>
    <!-- Optional JavaScript -->
    <div id="wait">
      <div class="icon">
        <img src='<?php echo base_url('assets/admin/image/ajax-loader.gif') ?>' width="64" height="64" /><br>Loading..
      </div>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script> -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js"></script> -->
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/2.9.0/jquery.serializejson.min.js"></script>
    <script src="<?php echo base_url('assets/admin/template/bootstrap-4/')?>js/adminlte.js"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/admin/template/bootstrap-4/')?>js/jquery.multisortable.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/template/bootstrap-4/')?>js/main.js"></script>
    <script type = "text/javascript">
      $(document).ready(function() {
          // datepicker
          $(".datepicker").datepicker({
              dateFormat: 'dd/mm/yy'
          });

          // change enable switch
          $('.customSwitch').click(function() {
              if ($(this).is(':checked') == true) {
                  $('#base-url').removeClass('d-none');
                  $('label.custom-control-label').text('Enabled');
                  $(this).val('1');
              } else {
                  $('#base-url').addClass('d-none');
                  $('label.custom-control-label').text('Disabled');
                  $(this).val('0');
              }
          });

          /*Tabs Fields*/
          $(".sortable, #sortable1, #sortable2").sortable({
              connectWith: ".connectedSortable"
          }).disableSelection();

          /*Section entry types changes position order*/
          $('#section .section-entries-list tbody').sortable({
              update: function(event, ui) {
                  var table = $("#section-entries-list").data('table');
                  var section_id = $("#section-entries-list").data('section');
                  var order = $(this).sortable('toArray');
                  var entrytypes_id = $("#section-entries-list tbody tr").map(function() {
                      return $(this).data("id");
                  }).get();
                  $.ajax({
                      type: 'POST',
                      dataType: 'json',
                      data: {
                          table: table,
                          section_id: section_id,
                          entrytypes_id: entrytypes_id,
                          order: order
                      },
                      url: '<?php echo base_url("admin/api/jsonChangeOrderEntryTypes") ?>',
                  }).done(function(data) {
                      console.log(data);
                  }).fail(function(error) {
                      console.log("error");
                  });
              }
          });

          manageNavbar();
          manageGroups();
          modalAssets();
          modalCategories();
          modalEntries();
          manageAssets();
          manageFields();
          manageSection();
          manageSites();
          manageEntrieslayout();
          tabsMultisortable();
          manageUsersSettings();
          layout();
      })
    </script>
  </body>
</html>