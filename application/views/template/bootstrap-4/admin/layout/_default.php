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

  </head>
  <body>

    <?php $this->load->view('template/bootstrap-4/admin/partial/nav'); ?>
    <div class="wraper">
      <div class="">
        <div class="d-flex flex-row flex-wrap justify-content-start align-items-start">
          <div class="left-column" id="sidebarCollapse">
            <?php $this->load->view('template/bootstrap-4/admin/partial/sidebar'); ?>
          </div>
          <div class="right-column ml-auto flex-fill flex-grow-1" id="contentCollapse">
           <main role="main" class="container">
            <div class="main d-flex flex-column">
              <div class="header">
                <?php $this->load->view('template/bootstrap-4/admin/partial/header'); ?>
              </div>
              <?php if ($this->session->userdata('message')) { ?>
                <div class="message alert alert-danger alert-dismissible text-center mx-auto" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $this->session->userdata('message'); ?>
                </div>
              <?php } ?>
              <div class="content container-fluid">
                <div class="content-body d-flex flex-row flex-wrap justify-content-start">
                  <?php $this->load->view($content); ?>
                </div>
              </div>
              <div class="footer text-center">
                <?php $this->load->view('template/bootstrap-4/admin/partial/footer'); ?>
              </div>
            </div>  
           </main>
          </div>
        </div>
      </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="groupsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Group <?php echo (isset($title) ? ucfirst($title) : ''); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open('admin/groups', ''); ?>
      <div class="modal-body">
          <input type="hidden" name="group_name" value="<?php echo (isset($group_name) ? $group_name : ''); ?>">
          <input type="hidden" name="table" value="<?php echo (isset($table) ? $table : ''); ?>">
          <div class="form-group">
            <label class="heading" for="inputNameGroup">What do you want to name the group?</label>
            <input type="text" name="name" class="form-control form-control-sm">
          </div>
          <div class="form-group">
            <label class="heading" for="inputDescGroup">Desctription</label>
            <textarea class="form-control form-control-sm" name="description"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="create">Save</button>
      </div>
    <? echo form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="assetsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Assets</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body d-flex flex-row flex-wrap justify-content-between p-1">
        <div class="left-modal">
          <ul>
            <li class="nav-item assets-groups list-unstyled"></li> 
          </ul>
        </div>
        <div class="right-modal">
        </div>
      </div>
      <div class="modal-footer">
        <input type="file" name="assets" id="entries-file" class="btn btn-primary mr-auto p-2 ">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select-assets" data-dismiss="modal">Select</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Categories</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="middle-modal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select-categories" data-dismiss="modal">Select</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="entriesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Categories</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body d-flex flex-row flex-wrap justify-content-between p-1">
        <div class="left-modal">
          <ul>
            <li class="nav-item entries-groups list-unstyled"></li> 
          </ul>
        </div>
        <div class="right-modal">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select-entries" data-dismiss="modal">Select</button>
      </div>
    </div>
  </div>
</div>



    <!-- Optional JavaScript -->
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
    <script type="text/javascript" src="<?php echo base_url('assets/admin/template/bootstrap-4/')?>js/main.js"></script>

    <script type="text/javascript">
      
      $(document).ready(function() {
        // datepicker
        $(".datepicker").datepicker({
          dateFormat: 'dd/mm/yy'
        });

        // collapse 
        $('[data-target="#sidebar"]').on('click', function() {
          $('#sidebarCollapse').toggleClass('active');
          $('#contentCollapse').toggleClass('active');
        });

        // Field Type Change
        $('select[name=fieldsGroup]').change(function() {
          var field_group = $('select[name=fieldsGroup]').val();
          $('select[name=fieldsGroup] option:selected').each(function() {
            var field_id = $('select[name=fieldsGroup] option:selected').attr('data-id');
            $('input[name=fieldsGroupId]').val(field_id);
          });
        });

        $('select[name=fieldsType]').change(function() {
          var field_type = $('select[name=fieldsType]').val();
          $('.fields').addClass('d-none');
          $('select[name=fieldsType] option:selected').each(function() {
            var field_id = $('select[name=fieldsType] option:selected').attr('data-id');
            $('input[name=fieldsTypeId]').val(field_id);
            $('#' + field_type).removeClass('d-none');
          });
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

        // add tabs layout
        $('.new-tabs button').click(function() {
          $('.field-tabs').append('<div class="field-group"> <ul class="nav nav-tabs" id="myTab" role="tablist"> <li class="nav-item"> <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a> </li> </ul> <div class="tab-content" id="myTabContent"> <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"> <ul id="sortable1" class="text-center list-group connectedSortable"> <li class="list-group-item active">Lion</li> <li class="list-group-item">Dog</li> <li class="list-group-item">Cat</li> <li class="list-group-item">Tiger</li> </ul> </div> </div> </div>');
        });


        // click navbar active
        $('.sidebar .nav-link').click(function(event) {
          console.log($(this));
          $('.sidebar .nav-item').find('.active').removeClass('active');
          $(this).addClass('active');
        });

        $('.sidebar-content .nav-link').click(function(event) {
          console.log($(this));
          $('.sidebar-content .nav-item').find('.active').removeClass('active');
          $(this).addClass('active');
        });

        // Button Submit
        $('#buttonHeader[type="submit"]').click(function() {
          if ($(this).data("tabs") == 1) {
            // get fields list value
            getTabsFieldsList();
          } else {
            $('#MyForm').submit();
          }
        });


        /**
         * Tabs Fields
         */
        $("#sortable1, #sortable2").sortable({
          connectWith: ".connectedSortable"
        }).disableSelection();
        /*End Tabs Fields*/

        $('#section-entries-list tbody').sortable({
          update: function(event, ui) {
            var order = $(this).sortable('toArray');
            var id = $("#section-entries-list tbody tr").map(function() {
              return $(this).data("id");
            }).get();
            var section_id = $("input[name=section_id]").val();
            $.ajax({
              type: 'POST',
              dataType: 'json',
              data: {
                id: id,
                order: order
              },
              url: '<?php echo base_url("admin/api/jsonUpdateOrderEntrytypes") ?>',
            }).done(function(data) {

            }).fail(function(error) {

            });
          }
        });

        // SITES;
        // $('#sites [name="url"]').val('1');
        if ($('#sites [name="url"]').val() == '1') {
          $('#sites [name="url"]').prop("checked", true);
          $('#baseUrl').removeClass('d-none');
        } else {
          $('#sites [name="url"]').prop("checked", false);
          $('#baseUrl').addClass('d-none');
        }
        $('#sites [name="url"]').click(function() {
          if ($(this).prop("checked") == true) {
            $(this).val(1);
            $('#baseUrl').removeClass('d-none');
          } else {
            $(this).val(0);
            $('#baseUrl').addClass('d-none');
            $('#baseUrl').empty();
          }
        });

        /**
         * Fields Forms 
         * @param  {[type]} $('input[name [description]
         * @return {[type]}               [description]
         */
        if ($('#fields input[name=plainLineBreak]').attr('checked')) {
          $('#fields .plainLineBreak').show();
        } else {
          $('#fields .plainLineBreak').hide();
        }
        $('#fields input[name=plainLineBreak]').click(function() {
          if ($(this).prop("checked") == false) {
            $('#fields [name="plainInitialRows"]').val('');
          }
          $('#fields .plainLineBreak').toggle();
        })

        $('#fields .assetsRestrictUpload').hide();
        $('#fields input[name=assetsRestrictUpload]').click(function() {
          $('#fields .noAssetsRestrictUpload').toggle();
          $('#fields .assetsRestrictUpload').toggle();
        })

        $('#fields .assetsRestrictFileType').hide();
        $('#fields input[name=assetsRestrictFileType]').click(function() {
          $('#fields .assetsRestrictFileType').toggle();
        })

        // add row table checkboxes
        $('#fields #checkboxes button').click(function() {
          $('#checkboxes table tr:last ').after('<tr> <td><input type="text" name="checkboxesLabel[]" class="form-control"></td> <td><input type="text" name="checkboxesValue[]" class="form-control"></td> <td class="action"><input type="checkbox" name="checkboxesDefault"></td> <td scope="row" colspan="2"> <a href="#"><i class="fas fa-arrows-alt"></i></a> <a class="remove-row"><i class="fas fa-minus-circle"></i></a> </td> </tr>')
        });
        $(document).on('click', '.remove-row', function() {
          $(this).closest("tr").remove();
          $('#checkboxes table').focus();
        });
        // add row table dropdown
        $('#fields #dropdown button').click(function() {
          $('#dropdown table tr:last ').after('<tr> <td><input type="text" name="dropdownLabel[]" class="form-control"></td> <td><input type="text" name="dropdownValue[]" class="form-control"></td> <td class="action"><input type="checkbox" name="dropdownDefault"></td> <td scope="row" colspan="2"> <a href="#"><i class="fas fa-arrows-alt"></i></a> <a class="remove-row"><i class="fas fa-minus-circle"></i></a> </td> </tr>')
        });
        $(document).on('click', '.remove-row', function() {
          $(this).closest("tr").remove();
          $('#dropdown table').focus();
        });
        // add row table Radio
        $('#fields #radio button').click(function() {
          $('#radio table tr:last ').after('<tr> <td><input type="text" name="radioLabel[]" class="form-control"></td> <td><input type="text" name="radioValue[]" class="form-control"></td> <td class="action"><input type="checkbox" name="radioDefault"></td> <td scope="row" colspan="2"> <a href="#"><i class="fas fa-arrows-alt"></i></a> <a class="remove-row"><i class="fas fa-minus-circle"></i></a> </td> </tr>')
        });
        $(document).on('click', '.remove-row', function() {
          $(this).closest("tr").remove();
          $('#radio table').focus();
        });

        /*Fields type entries*/
        $('#fields .entriesSourceAll').attr("checked", true);
        if ($('#fields .entriesSource').is(":checked")) {
          $('#fields .entriesSourceAll').attr("checked", false);
          if ($('#fields .entriesSourceAll').is(':checked') == true) {
            $('#fields .entriesSource').attr("disabled", "disabled");
            $('#fields .entriesSource').attr("checked", true);
          } else {
            if ($('#fields .entriesSource').is(":checked")) {
              var val = $('#fields .entriesSource').val();
              if ($(this).val() == val) {
                $('#fields .entriesSource[value="' + val + '"]').attr('checked', true);
              } else {
                $('#fields .entriesSource').removeAttr("disabled", "disabled");
              }
            } else {
              $(this).attr("disabled", "disabled");
              $(this).attr("checked", false);
            }
          }
        } else {
          $('#fields .entriesSource').attr("disabled", "disabled");
          $('#fields .entriesSource').attr("checked", true);
        }

        $('#fields .entriesSourceAll').click(function() {
          if ($(this).is(':checked') == true) {
            $('#fields .entriesSource').attr("disabled", "disabled");
            $('#fields .entriesSource').attr("checked", true);
          } else {
            $('#fields .entriesSource').removeAttr("disabled", "disabled");
            $('#fields .entriesSource').attr("checked", false);
          }
        });
        /*END Fields Forms*/


        /**
         * Sections
         */
        $('#sections-form [name="section-type"]').change(function() {
          if ($(this).val() == '5') {
            $('#site-settings .status').addClass('d-none');
          } else {
            $('#site-settings .status').removeClass('d-none');
          }
        });
        /*end Section*/


        // getTabsFieldsList();
        getGroupsById();
        deleteGroupsById();
        getDataByIdGroups();
        deleteFieldsById();
        getModalAssets();
        getModalCategories();
        getModalEntries();
        changeEntriesType();
        uploadWithoutSubmit();
        uploadAssetsInEntries();
        manageUsersSettings();
        layout();
      })
    </script>
  </body>
</html>