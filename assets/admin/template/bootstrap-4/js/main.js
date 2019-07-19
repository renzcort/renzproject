      $(document).ready(function(){
        var base_url = "http://renzproject.localhost/";
        // datepicker
        $( ".datepicker" ).datepicker();

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
        $('.new-tabs button').click(function(){
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
        $('#buttonHeader[type="submit"]').click(function(){
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
              // url : '<?php echo base_url("admin/Api/jsonUpdateOrderEntrytypes") ?>',
              url : base_url+"admin/Api/jsonUpdateOrderEntrytypes",
            }).done(function(data){

            }).fail(function(error){

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
        $('#sites [name="url"]').click(function(){
          if($(this).prop("checked") == true){
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
        $('#fields input[name=plainLineBreak]').click(function(){
          if ($(this).prop("checked") == false) {
            $('#fields [name="plainInitialRows"]').val('');
          }
          $('#fields .plainLineBreak').toggle();
        })

        $('#fields .assetsRestrictUpload').hide();
        $('#fields input[name=assetsRestrictUpload]').click(function(){
          $('#fields .noAssetsRestrictUpload').toggle();
          $('#fields .assetsRestrictUpload').toggle();
        })

        $('#fields .assetsRestrictFileType').hide();
        $('#fields input[name=assetsRestrictFileType]').click(function(){
          $('#fields .assetsRestrictFileType').toggle();
        })

        // add row table checkboxes
        $('#fields #checkboxes button').click(function(){
          $('#checkboxes table tr:last ').after('<tr> <td><input type="text" name="checkboxesLabel[]" class="form-control"></td> <td><input type="text" name="checkboxesValue[]" class="form-control"></td> <td class="action"><input type="checkbox" name="checkboxesDefault"></td> <td scope="row" colspan="2"> <a href="#"><i class="fas fa-arrows-alt"></i></a> <a class="remove-row"><i class="fas fa-minus-circle"></i></a> </td> </tr>') 
        }); 
        $(document).on('click', '.remove-row', function() {
          $(this).closest("tr").remove();
          $('#checkboxes table').focus();
        });
        // add row table dropdown
        $('#fields #dropdown button').click(function(){
          $('#dropdown table tr:last ').after('<tr> <td><input type="text" name="dropdownLabel[]" class="form-control"></td> <td><input type="text" name="dropdownValue[]" class="form-control"></td> <td class="action"><input type="checkbox" name="dropdownDefault"></td> <td scope="row" colspan="2"> <a href="#"><i class="fas fa-arrows-alt"></i></a> <a class="remove-row"><i class="fas fa-minus-circle"></i></a> </td> </tr>') 
        }); 
        $(document).on('click', '.remove-row', function() {
          $(this).closest("tr").remove();
          $('#dropdown table').focus();
        });
        // add row table Radio
        $('#fields #radio button').click(function(){
          $('#radio table tr:last ').after('<tr> <td><input type="text" name="radioLabel[]" class="form-control"></td> <td><input type="text" name="radioValue[]" class="form-control"></td> <td class="action"><input type="checkbox" name="radioDefault"></td> <td scope="row" colspan="2"> <a href="#"><i class="fas fa-arrows-alt"></i></a> <a class="remove-row"><i class="fas fa-minus-circle"></i></a> </td> </tr>') 
        }); 
        $(document).on('click', '.remove-row', function() {
          $(this).closest("tr").remove();
          $('#radio table').focus();
        });
        /*END Fields Forms*/


        /**
         * Sections
         */
        $('#sections-form [name="section-type"]').change(function(){
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
        changeEntriesType();
        uploadWithoutSubmit();
        uploadAssetsInEntries();
        manageUsersSettings();

        var leftbar = document.getElementById('left-content');
        var leftbarTop = leftbar.offsetTop;
        var leftbarButton = leftbar.offsetHeight;
        var rightbar = document.getElementById('right-content');
        var rightbarTop = rightbar.offsetHeight;
        window.onscroll = function() {myFunction()};


      })

      
      function myFunction() {
        if (window.pageYOffset >= leftbarTop && window.pageYOffset <= leftbarButton) {
          leftbar.classList.add("fixed-bar")
        } else {
          leftbar.classList.remove("fixed-bar");
        }
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
              // url: '<?php echo base_url("admin/Api/jsonGetGroupsById") ?>',
              url: base_url+"admin/Api/jsonGetGroupsById",
          })
          .done(function (data) {
              updateGroupsModal(data); 
          })
          .fail(function (jqXHR, textStatus, errorThrown) { 
          });
          return false;
        });
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
              // url: '<?php echo base_url("admin/Api/jsonDeleteGroupsById") ?>',
              url: base_url+"admin/Api/jsonDeleteGroupsById",
            }).done(function(data) {
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
          var action_name = $('#sidebarGroups').data('action-name');
          var group_name  = $('#sidebarGroups').data('groups-name');
          var group_id    = $('#sidebarGroups .nav-link.active').data('id');
          $.ajax({
            type : 'POST',
            dataType : 'json',
            data : {table: table, group_name: group_name, action_name : action_name, group_id : group_id},
            // url : '<?php echo base_url("admin/Api/jsonGetDataByIdGroups") ?>',
            url : base_url+"admin/Api/jsonGetDataByIdGroups",
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
              // url : '<?php echo base_url("admin/Api/jsonDeleteFieldsById") ?>'
              url : base_url+"admin/Api/jsonDeleteFieldsById",
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
        
        // assets FIELD
        if ($("#entries-template").length) {
          var jData = $('#MyForm').serializeJSON();
          // var url   = '<?php echo base_url("admin/Api/jsonEntriesManage") ?>';
          var url   = base_url+"admin/Api/jsonEntriesManage";
        } else if ($("#users-settings").length) {
          var jData = Object.assign(jTable, jFields);
          // var url   = '<?php echo base_url("admin/Api/jsonUsersFieldsForm") ?>';
          var url   = base_url+"admin/Api/jsonUsersFieldsForm";
        } else {
          var jData = Object.assign(jTable, jFields);
          // var url   = '<?php echo base_url("admin/Api/jsonTabsFields") ?>';
          var url   = base_url+"admin/Api/jsonTabsFields";
        }

        $.ajax({
          type : 'POST',
          dataType : 'json',
          data : jData,
          url : url,
        }).done(function(data){
          if (data.status == true) {
            // window.location.href = '<?php echo base_url() ?>'+data.action;
            window.location.href = base_url+data.action;
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

      /*this function for upload file content*/
      function uploadWithoutSubmit(){
        $('#file').change(function(){
          var name      = document.getElementById("file").files[0].name;
          var form_data = new FormData();
          var ext       = name.split('.').pop().toLowerCase();
          var group_id  = $(".sidebar-content .nav-link.active").attr('data-id');
          var astSource = $('#assets-source').val();
          form_data.append("group_id", group_id);
          form_data.append("assets_Source", astSource);

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
             // url: '<?php echo base_url("admin/Api/jsonUploadWithoutSubmit") ?>',
             url: base_url+"admin/Api/jsonUploadWithoutSubmit",
             type: "POST",
             data:  form_data,
             contentType: false,
             cache: false,
             processData:false,
            beforeSend:function(){
             $('#table-content').html("<label class='text-success'>Image Uploading...</label>");
             $('#table-content').empty(); 
            },   
            success:function(data){
              location.reload();
             // $('#table-content').empty(); 
             // $('#table-content').html(data);
            }
           });
          }
        });
      }

      function getModalAssets(){
        $('[data-target="#assetsModal"]').click(function(e) {
          var assets_id     = $(this).data('assets-id');
          var assets_fields = $(this).data('assets-fields');
          var assets_source = $(this).data('assets-source');
          $.ajax({
            type : 'POST',
            dataType : 'json',
            data : {id:assets_id, assets_fields:assets_fields, assets_source:assets_source},
            // url : '<?php echo base_url("admin/Api/jsonAssetsEntriesUpload") ?>',
            url : base_url+"admin/Api/jsonAssetsEntriesUpload",
          }).done(function(data){
            $('li.assets-list').html(data.name);
            $('#assetsModal .right-modal').html(data.table);
            
            var table = $('#datatableModal').DataTable();
            $('#datatableModal tbody').on( 'click', 'tr', function () {
              $(this).toggleClass('selected');
            });
            $('#button').click( function () {
              alert( table.rows('.selected').data().length +' row(s) selected' );
            });

            // $('tbody tr').click(function() {
            //   if ($(this).hasClass('selected') ) {
            //     $(this).removeClass('selected');
            //   } else {
            //     $('tr.selected').removeClass('selected');
            //     $(this).addClass('selected');
            //   }
            // });

            $('#select-assets').click(function(e){
              var assets_content_id = $('tr.selected input').data('id');
              var id = [];
              $( "tbody tr.selected" ).each(function() {
                id.push($('tr.selected input').data('id'));
                $( this ).toggleClass( "selected" );
              });

              $.ajax({
                // url: '<?php echo base_url('admin/api/jsonAssetsSelectSubmit') ?>',
                url: base_url+"admin/Api/jsonAssetsSelectSubmit",
                type: 'POST',
                dataType: 'json',
                data: {assetsContentId: id, assets_fields : assets_fields},
              })
              .done(function(data) {
                $('.selected').html(data.html);
                console.log("success");
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
            });
          }).fail(function(errot){
          });
        });
        $("#fields-assets-entries ul.selected li a").click(function (e) {
          $(this).closest('li').remove();
        });
      }

      /*change option entries in form entries template side right*/
      function changeEntriesType(){
        $('#entries').change(function(){
          var id = $('#entries option:selected').attr('data-id');
          $.ajax({
            // url: '<?php echo base_url('admin/api/jsonSelectEntriesType') ?>',
            url: base_url+"admin/Api/jsonSelectEntriesType",
            type: 'POST',
            dataType: 'json',
            data: {id: id},
          })
          .done(function(data) {
            console.log("success");
            $('#entries-fields').empty(); 
            $('#entries-fields').html(data);
            getModalAssets();
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
        });
      }

      /*Function for upload assets in modal in entries template*/
      function uploadAssetsInEntries(){
        $('#entries-file').change(function(){
          var name      = document.getElementById("entries-file").files[0].name;
          var form_data = new FormData();
          var ext       = name.split('.').pop().toLowerCase();
          var group_id  = $(".assets-list .active").attr('data-id');
          var astSource = $('#assets-source').val();
          form_data.append("group_id", group_id);
          form_data.append("assets_Source", astSource);

          if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
          {
           alert("Invalid Image File");
          }
          var oFReader = new FileReader();
          oFReader.readAsDataURL(document.getElementById("entries-file").files[0]);
          var f = document.getElementById("entries-file").files[0];
          var fsize = f.size||f.fileSize;
          if(fsize > 2000000)
          {
           alert("Image File Size is very big");
          }
          else
          {
           form_data.append("entries-file", document.getElementById('entries-file').files[0]);
           $.ajax({
             // url: '<?php echo base_url("admin/Api/jsonUploadAssetsInEntries") ?>',
             url: base_url+"admin/Api/jsonUploadAssetsInEntries",
             type: "POST",
             data:  form_data,
             contentType: false,
             cache: false,
             processData:false,
            beforeSend:function(){
             $('#uploadModal').html("<label class='text-success'>Image Uploading...</label>");
             $('#uploadModal').empty(); 
            },   
            success:function(data){
              // location.reload();
              $('#uploadModal').empty(); 
              $('#uploadModal').html(data);
              var table = $('#datatableModal').DataTable();
              $('#datatableModal tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
              });
              $('#button').click( function () {
                alert( table.rows('.selected').data().length +' row(s) selected' );
              });
            }
           });
          }
        });
      }

      /*Manage Users Settings Form*/
      function manageUsersSettings(){
        if ($('#usersgroup-form [name="generalAccessCP"]').is(':checked') == true) {
          $('#usersgroup-form [name="generalPerformPluginUpdate"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="generalAccessCPOffline"]').removeAttr("disabled", "disabled");
        } else {
          $('#usersgroup-form [name="generalPerformPluginUpdate"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="generalAccessCPOffline"]').attr("disabled", "disabled");
        }
        $('#usersgroup-form [name="generalAccessCP"]').click(function() {
          if ($(this).is(':checked') == true) {
            $('#usersgroup-form [name="generalPerformPluginUpdate"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="generalAccessCPOffline"]').removeAttr("disabled", "disabled");
          } else {
            $('#usersgroup-form [name="generalPerformPluginUpdate"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="generalPerformPluginUpdate"]').attr("checked", false);
            $('#usersgroup-form [name="generalAccessCPOffline"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="generalAccessCPOffline"]').attr("checked", false);
          }
        });

      if ($('#usersgroup-form [name="usersEdit"]').is(':checked') == true) {
          $('#usersgroup-form [name="usersModerate"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="usersAssignEdit"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="usersAssignGroups"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="usersAdministrate"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="usersImpersonate"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name*="usersAssigns"]').removeAttr("disabled", "disabled");
        } else {
          $('#usersgroup-form [name="usersModerate"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="usersAssignEdit"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="usersAssignGroups"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="usersAdministrate"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="usersImpersonate"]').attr("disabled", "disabled");
          $('#usersgroup-form [name*="usersAssigns"]').attr("disabled", "disabled");
        }
        $('#usersgroup-form [name="usersEdit"]').click(function() {
          if ($(this).is(':checked') == true) {
            $('#usersgroup-form [name="usersModerate"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="usersAssignEdit"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="usersAssignGroups"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="usersAdministrate"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="usersImpersonate"]').removeAttr("disabled", "disabled");
            // $('#usersgroup-form [name*="usersAssigns"]').removeAttr("disabled", "disabled");
          } else {
            $('#usersgroup-form [name="usersModerate"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="usersModerate"]').attr("checked", false);
            $('#usersgroup-form [name="usersAssignEdit"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="usersAssignEdit"]').attr("checked", false);
            $('#usersgroup-form [name="usersAssignGroups"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="usersAssignGroups"]').attr("checked", false);
            $('#usersgroup-form [name="usersAdministrate"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="usersAdministrate"]').attr("checked", false);
            $('#usersgroup-form [name="usersImpersonate"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="usersImpersonate"]').attr("checked", false);
            $('#usersgroup-form [name*="usersAssigns"]').attr("disabled", "disabled");
            $('#usersgroup-form [name*="usersAssigns"]').attr("checked", false);
          }
        });

        $('#usersgroup-form [name="usersAssignGroups"]').click(function() {
          if ($(this).is(':checked') == true) {
            $('#usersgroup-form [name*="usersAssigns"]').removeAttr("disabled", "disabled");
          } else {
            $('#usersgroup-form [name*="usersAssigns"]').attr("disabled", "disabled");
            $('#usersgroup-form [name*="usersAssigns"]').attr("checked", false);
          }
        });

        /**
         * [section description]
         * This function use to checked permissions to users 
         * @type {Array}
         */
        var section = [];
        $('#usersgroup-form [id="section"]').each(function() {
          // section.push($(this).data('handle'));
          var section = $(this).data('handle');
          if ($('#usersgroup-form [name="sectionEdit['+section+']"]').is(':checked') == true) {
            $('#usersgroup-form [name="sectionPublishLiveChange['+section+']"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="sectionEditOtherAuthors['+section+']"]').removeAttr("disabled", "disabled");
          } else {
            $('#usersgroup-form [name="sectionPublishLiveChange['+section+']"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="sectionEditOtherAuthors['+section+']"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="sectionDelete['+section+']"]').attr("disabled", "disabled");
          }

          if ($('#usersgroup-form [name="sectionEditOtherAuthors['+section+']"]').is(':checked') == true) {
            $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="sectionDelete['+section+']"]').removeAttr("disabled", "disabled");
          } else {
            $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="sectionDelete['+section+']"]').attr("disabled", "disabled");
          }
          
          // alert(section);
          $('#usersgroup-form [name="sectionEdit['+section+']"]').click(function() {
            if ($(this).is(':checked') == true) {
              $('#usersgroup-form [name="sectionPublishLiveChange['+section+']"]').removeAttr("disabled", "disabled");
              $('#usersgroup-form [name="sectionEditOtherAuthors['+section+']"]').removeAttr("disabled", "disabled");
            } else {
              $('#usersgroup-form [name="sectionPublishLiveChange['+section+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="sectionPublishLiveChange['+section+']"]').attr("checked", false);
              $('#usersgroup-form [name="sectionEditOtherAuthors['+section+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="sectionEditOtherAuthors['+section+']"]').attr("checked", false);
              $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').attr("checked", false);
              $('#usersgroup-form [name="sectionDelete['+section+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="sectionDelete['+section+']"]').attr("checked", false);
            }
          });

          $('#usersgroup-form [name="sectionEditOtherAuthors['+section+']"]').click(function() {
            if ($(this).is(':checked') == true) {
              $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').removeAttr("disabled", "disabled");
              $('#usersgroup-form [name="sectionDelete['+section+']"]').removeAttr("disabled", "disabled");
            } else {
              $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="sectionPublishOtherAuthors['+section+']"]').attr("checked", false);
              $('#usersgroup-form [name="sectionDelete['+section+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="sectionDelete['+section+']"]').attr("checked", false);
            }
          });
        });


        /**
         * [assets description]
         * This function use to checked permissions to users 
         * @type {Array}
         */
        var assets = [];
        $('#usersgroup-form [id="assets"]').each(function() {
          // assets.push($(this).data('handle'));
          var assets = $(this).data('handle');
          if ($('#usersgroup-form [name="volumeView['+assets+']"]').is(':checked') == true) {
            $('#usersgroup-form [name="volumeUploadFiles['+assets+']"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="volumeCreateSubfolder['+assets+']"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="volumeRemoveFilesAndFolders['+assets+']"]').removeAttr("disabled", "disabled");
            $('#usersgroup-form [name="volumeEditImages['+assets+']"]').removeAttr("disabled", "disabled");
          } else {
            $('#usersgroup-form [name="volumeUploadFiles['+assets+']"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="volumeCreateSubfolder['+assets+']"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="volumeRemoveFilesAndFolders['+assets+']"]').attr("disabled", "disabled");
            $('#usersgroup-form [name="volumeEditImages['+assets+']"]').attr("disabled", "disabled");
          }
          
          // alert(assets);
          $('#usersgroup-form [name="volumeView['+assets+']"]').click(function() {
            if ($(this).is(':checked') == true) {
              $('#usersgroup-form [name="volumeUploadFiles['+assets+']"]').removeAttr("disabled", "disabled");
              $('#usersgroup-form [name="volumeCreateSubfolder['+assets+']"]').removeAttr("disabled", "disabled");
              $('#usersgroup-form [name="volumeRemoveFilesAndFolders['+assets+']"]').removeAttr("disabled", "disabled");
              $('#usersgroup-form [name="volumeEditImages['+assets+']"]').removeAttr("disabled", "disabled");
            } else {
              $('#usersgroup-form [name="volumeUploadFiles['+assets+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="volumeUploadFiles['+assets+']"]').attr("checked", false);
              $('#usersgroup-form [name="volumeCreateSubfolder['+assets+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="volumeCreateSubfolder['+assets+']"]').attr("checked", false);
              $('#usersgroup-form [name="volumeRemoveFilesAndFolders['+assets+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="volumeRemoveFilesAndFolders['+assets+']"]').attr("checked", false);
              $('#usersgroup-form [name="volumeEditImages['+assets+']"]').attr("disabled", "disabled");
              $('#usersgroup-form [name="volumeEditImages['+assets+']"]').attr("checked", false);
            }
          });
        });

        /*Users Settings List*/
        $('#users-settings [name="allowRegistration"]').click(function(){
          if ($(this).is(':checked') == true) {
            $('#users-settings .default-group').removeClass('d-none');
          } else {
            $('#users-settings .default-group').addClass('d-none');
          }
        });
        
      }

