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



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js"></script> -->

    <script type="text/javascript">
      $(document).ready(function(){
        
        // collapse 
        $('[data-target="#sidebar"]').on('click', function () {
          $('#sidebarCollapse').toggleClass('active');
          $('#contentCollapse').toggleClass('active');
        });

        // Field Type Change
        $('select[name=fieldsGroup]').change(function(){
          var field_group = $('select[name=fieldsGroup]').val();
          $('select[name=fieldsGroup] option:selected').each(function(){
            var field_id = $('select[name=fieldsGroup] option:selected').attr('data-id');
            $('input[name=fieldsGroupId]').val(field_id);
          });
        });

        $('select[name=fieldsType]').change(function(){
          var field_type = $('select[name=fieldsType]').val();
          $('.fields').addClass('d-none');
          $('select[name=fieldsType] option:selected').each(function(){
            var field_id = $('select[name=fieldsType] option:selected').attr('data-id');
            $('input[name=fieldsTypeId]').val(field_id);
            $('#'+field_type).removeClass('d-none');
          });
        });


        // change enable switch
        $('#customSwitch1').click(function() {
          var enabled = $('#customSwitch1:checked').val();
          if (enabled == 'on') {
            $('#base-url').removeClass('d-none');
            $('label.custom-control-label').text('Enabled');
          } else {
            $('#base-url').addClass('d-none');
            $('label.custom-control-label').text('Disabled');
          }
        });

        // add tabs layout
        $('.new-tabs button').click(function(){
          $('.field-tabs').append('<div class="field-group"> <ul class="nav nav-tabs" id="myTab" role="tablist"> <li class="nav-item"> <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a> </li> </ul> <div class="tab-content" id="myTabContent"> <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"> <ul id="sortable1" class="text-center list-group connectedSortable"> <li class="list-group-item active">Lion</li> <li class="list-group-item">Dog</li> <li class="list-group-item">Cat</li> <li class="list-group-item">Tiger</li> </ul> </div> </div> </div>'); 
        });

        // add row table checkboxes
        $('#checkboxes button').click(function(){
          $('#checkboxes table tr:last ').after('<tr> <td><input type="text" name="checkboxesLabel[]" class="form-control"></td> <td><input type="text" name="checkboxesValue[]" class="form-control"></td> <td class="action"><input type="checkbox" name="checkboxesDefault"></td> <td scope="row" colspan="2"> <a href="#"><i class="fas fa-arrows-alt"></i></a> <a href="#" class="remove-row"><i class="fas fa-minus-circle"></i></a> </td> </tr>') 
        }); 
        $(document).on('click', '.remove-row', function() {
          $(this).closest("tr").remove();
          $('#checkboxes table').focus();
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
        $('#buttonHeader').click(function(){
          if ($(this).data("tabs") == 1) {
            // get fields list value
            getTabsFieldsList();
          } else {
           $('#MyForm').submit();
          }
        });

        /**
         * Fields Forms 
         * @param  {[type]} $('input[name [description]
         * @return {[type]}               [description]
         */
        if ($('input[name=plainLineBreak]').attr('checked')) {
          $('.plainLineBreak').show();
        } else {
          $('.plainLineBreak').hide();
        }
        $('input[name=plainLineBreak]').click(function(){
          $('.plainLineBreak').toggle();
        })

        $('.assetsRestrictUpload').hide();
        $('input[name=assetsRestrictUpload]').click(function(){
          $('.noAssetsRestrictUpload').toggle();
          $('.assetsRestrictUpload').toggle();
        })

        $('.assetsRestrictFileType').hide();
        $('input[name=assetsRestrictFileType]').click(function(){
          $('.assetsRestrictFileType').toggle();
        })
        /*END Fields Forms*/

        /**
         * Tabs Fields
         */
        $( "#sortable1, #sortable2" ).sortable({
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
              type : 'POST',
              dataType : 'json',
              data : {id : id, order : order},
              url : '<?php echo base_url("admin/api/jsonUpdateOrderEntrytypes") ?>',
            }).done(function(data){

            }).fail(function(error){

            });
           }
        });

        var leftbar = document.getElementById('left-content');
        var leftbarTop = leftbar.offsetTop;
        var leftbarButton = leftbar.offsetHeight;
        var rightbar = document.getElementById('right-content');
        var rightbarTop = rightbar.offsetHeight;
        window.onscroll = function() {myFunction()};

        getGroupsById();
        deleteGroupsById();
        getDataByIdGroups();
        deleteFieldsById();
        getTabsFieldsList();
        uploadWithoutSubmit();
      })

      
      function myFunction() {
        if (window.pageYOffset >= leftbarTop && window.pageYOffset <= leftbarButton) {
          leftbar.classList.add("fixed-bar")
        } else {
          leftbar.classList.remove("fixed-bar");
        }
      }
      // function update modal success
      function updateGroupsModal(data){
        $('#groupsModal .modal-body').append('<input type="hidden" name="id" value="'+data.id+'" class="form-control">');
        $('#groupsModal input[type="text"]').val(data.name);
        $('#groupsModal textarea').val(data.description);
        $('#groupsModal button[type="submit"]').attr('name', 'update');
        $('#groupsModal button[type="submit"]').text('Update');
        $('#groupsModal').modal('show');
      }


      /**
       * GROUPS API
       * @return {[type]} [description]
       */
      function getGroupsById() {
        // Rename Groups 
        $('#groupsRename').click(function(){
          var group_name = $('#sidebarGroups').data('groups-name');
          var table = $('#sidebarGroups').data('table');
          var group_id = $(".sidebar-content .nav-link.active").attr('data-id');
          $.ajax({
              type: 'POST',
              datatype: 'json',
              data: {group_name: group_name, group_id : group_id, table : table},
              url: '<?php echo base_url("admin/api/jsonGetGroupsById") ?>',
          })
          .done(function (data) {
              updateGroupsModal(data); 
          })
          .fail(function (jqXHR, textStatus, errorThrown) { 
          });
          return false;
        });
      }

      function deleteGroupsById(){
        // Delete Groups
        $('#groupsDelete').click(function(){
          var table        = $('#sidebarGroups').data('table');
          var group_name   = $('#sidebarGroups').data('groups-name');
          var element_name = $('#sidebarGroups').data('element');
          var group_id     = $(".sidebar-content .nav-link.active").attr('data-id');

          if (confirm("Are you sure?")) {
            $.ajax({
              type: 'POST',
              dataType: 'json',
              data: {table: table, group_name: group_name, element_name : element_name, group_id : group_id},
              url: '<?php echo base_url("admin/api/jsonDeleteGroupsById") ?>',
            }).done(function(data) {
              alert(data);
              window.location.reload();
            }).fail(function(error) {
            });
          }
          return false;
        });
      }

      function getDataByIdGroups(){
        // Show Fields By Groups
        $('#sidebarGroups .nav-item').click(function(){
          var table       = $('#sidebarGroups').data('table');
          var group_name  = $('#sidebarGroups').data('groups-name');
          var action_name = $('#sidebarGroups').data('action-name');
          var group_id    = $('#sidebarGroups .nav-link.active').data('id');
          $.ajax({
            type : 'POST',
            dataType : 'json',
            data : {table: table, group_name: group_name, action_name : action_name, group_id : group_id},
            url : '<?php echo base_url("admin/api/jsonGetDataByIdGroups") ?>',
          }).done(function(data){
            $('#right-content table').remove();
            $('#right-content .empty-data').remove();
            $('#right-content').append(data);
          }).fail(function(error){

          });
        });
      }
      /*END Groups*/

      function deleteFieldsById(){
        // Delete Fields List
        $('#deleteFields').click(function(){
          var id = $('#deleteFields').data('id');
          if (confirm("are you sure?")) {
            $.ajax({
              type : 'POST',
              dataType : 'json',
              data : {id : id},
              url : '<?php echo base_url("admin/api/jsonDeleteFieldsById") ?>'
            }).done(function(data) {
              window.location.reload();
            }).fail(function(error) {

            });
          } 
          return false;
        })
      }

      function getTabsFieldsList() {
        var fieldsId = $('#sortable1 .fields-list').map(function(){
          return $(this).data('fieldsid');
        }).get();
        var jTable = ConvertFormToJSON();
        var jFields = {fieldsId : fieldsId};
        var jData = Object.assign(jTable, jFields);
        $.ajax({
          type : 'POST',
          dataType : 'json',
          data : jData,
          url : '<?php echo base_url("admin/api/jsonTabsFields") ?>',
        }).done(function(data){
          if (data.status == true) {
            window.location.href = '<?php echo base_url() ?>'+data.action;
          } else {
           $.each(data.errors, function(key, val){
            $('input[name="'+key+'"]').next().html(val).addClass('form-error');
           }); 
          }
        }).fail(function(errot){

        });
      }

      function ConvertFormToJSON(){
        var array = jQuery($('#MyForm')).serializeArray();
        var json = {};
        jQuery.each(array, function() {
            json[this.name] = this.value || '';
        });
        return json;
      }

      function uploadWithoutSubmit(){
        $('#file').change(function(){
          var name = document.getElementById("file").files[0].name;
          var form_data = new FormData();
          var ext = name.split('.').pop().toLowerCase();
          var group_id = $(".sidebar-content .nav-link.active").attr('data-id');
          form_data.append("group_id", group_id);
          console.log(form_data);

          if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
          {
           alert("Invalid Image File");
          }
          var oFReader = new FileReader();
          oFReader.readAsDataURL(document.getElementById("file").files[0]);
          var f = document.getElementById("file").files[0];
          var fsize = f.size||f.fileSize;
          if(fsize > 2000000)
          {
           alert("Image File Size is very big");
          }
          else
          {
           form_data.append("file", document.getElementById('file').files[0]);
           $.ajax({
             url: '<?php echo base_url("admin/api/uploadWithoutSubmit") ?>',
             type: "POST",
             data:  form_data,
             contentType: false,
             cache: false,
             processData:false,
            beforeSend:function(){
             $('#table-content').html("<label class='text-success'>Image Uploading...</label>");
            },   
            success:function(data)
            {
             $('#table-content').empty(); 
             $('#table-content').html(data);
            }
           });
          }
        });
      }

    </script>
  </body>
</html>