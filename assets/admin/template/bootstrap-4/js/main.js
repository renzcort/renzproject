  var base_url = "http://renzproject.localhost/";
  function layout(){
    var leftbar = document.getElementById('left-content');
    var leftbarTop = leftbar.offsetTop;
    var leftbarButton = leftbar.offsetHeight;
    var rightbar = document.getElementById('right-content');
    var rightbarTop = rightbar.offsetHeight;
    window.onscroll = function() { 
      myFunction()
    };
  }

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
    $('#groupsRename').click(function() {
      var group_name = $('#sidebarGroups').data('groups-name');
      var table = $('#sidebarGroups').data('table');
      var group_id = $(".sidebar-content .nav-link.active").attr('data-id');
      $.ajax({
          type: 'POST',
          datatype: 'json',
          data: {
            group_name: group_name,
            group_id: group_id,
            table: table
          },
          // url: '<?php echo base_url("admin/Api/jsonGetGroupsById") ?>',
          url: base_url + "admin/Api/jsonGetGroupsById",
        })
        .done(function(data) {
          updateGroupsModal(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {});
      return false;
    });
  }

  // function update modal success
  function updateGroupsModal(data) {
    $('#groupsModal .modal-body').append('<input type="hidden" name="id" value="' + data.id + '" class="form-control">');
    $('#groupsModal input[type="text"]').val(data.name);
    $('#groupsModal textarea').val(data.description);
    $('#groupsModal button[type="submit"]').attr('name', 'update');
    $('#groupsModal button[type="submit"]').text('Update');
    $('#groupsModal').modal('show');
  }

  function deleteGroupsById() {
    // Delete Groups
    $('#groupsDelete').click(function() {
      var table = $('#sidebarGroups').data('table');
      var group_name = $('#sidebarGroups').data('groups-name');
      var element_name = $('#sidebarGroups').data('element');
      var group_id = $(".sidebar-content .nav-link.active").attr('data-id');

      if (confirm("Are you sure?")) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          data: {
            table: table,
            group_name: group_name,
            element_name: element_name,
            group_id: group_id
          },
          // url: '<?php echo base_url("admin/Api/jsonDeleteGroupsById") ?>',
          url: base_url + "admin/Api/jsonDeleteGroupsById",
        }).done(function(data) {
          window.location.reload();
        }).fail(function(error) {});
      }
      return false;
    });
  }

  function getDataByIdGroups() {
    // Show Fields By Groups
    $('#sidebarGroups .nav-item').click(function() {
      var table = $('#sidebarGroups').data('table');
      var action_name = $('#sidebarGroups').data('action-name');
      var group_name = $('#sidebarGroups').data('groups-name');
      var group_id = $('#sidebarGroups .nav-link.active').data('id');
      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          table: table,
          group_name: group_name,
          action_name: action_name,
          group_id: group_id
        },
        // url : '<?php echo base_url("admin/Api/jsonGetDataByIdGroups") ?>',
        url: base_url + "admin/Api/jsonGetDataByIdGroups",
      }).done(function(data) {
        $('#right-content table').remove();
        $('#right-content .empty-data').remove();
        $('#right-content').append(data);
      }).fail(function(error) {

      });
    });
  }
  /*END Groups*/

  function deleteFieldsById() {
    // Delete Fields List
    $('#deleteFields').click(function() {
      var id = $('#deleteFields').data('id');
      if (confirm("are you sure?")) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          data: {
            id: id
          },
          // url : '<?php echo base_url("admin/Api/jsonDeleteFieldsById") ?>'
          url: base_url + "admin/Api/jsonDeleteFieldsById",
        }).done(function(data) {
          window.location.reload();
        }).fail(function(error) {

        });
      }
      return false;
    })
  }

  function getTabsFieldsList() {
    var fieldsId = $('#sortable1 .fields-list').map(function() {
      return $(this).data('fieldsid');
    }).get();
    var jTable = ConvertFormToJSON();
    var jFields = {
      fieldsId: fieldsId
    };

    // assets FIELD
    if ($("#entries-template").length) {
      var jData = $('#MyForm').serializeJSON();
      // var url   = '<?php echo base_url("admin/Api/jsonEntriesManage") ?>';
      var url = base_url + "admin/Api/jsonEntriesManage";
    } else if ($("#users-settings").length) {
      var jData = Object.assign(jTable, jFields);
      // var url   = '<?php echo base_url("admin/Api/jsonUsersFieldsForm") ?>';
      var url = base_url + "admin/Api/jsonUsersFieldsForm";
    } else {
      var jData = Object.assign(jTable, jFields);
      // var url   = '<?php echo base_url("admin/Api/jsonTabsFields") ?>';
      var url = base_url + "admin/Api/jsonTabsFields";
    }

    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: jData,
      url: url,
    }).done(function(data) {
      if (data.status == true) {
        // window.location.href = '<?php echo base_url() ?>'+data.action;
        window.location.href = base_url + data.action;
      } else {
        $.each(data.errors, function(key, val) {
          $('input[name="' + key + '"]').next().html(val).addClass('form-error');
        });
      }
    }).fail(function(errot) {

    });
  }

  function ConvertFormToJSON() {
    var array = jQuery($('#MyForm')).serializeArray();
    var json = {};
    jQuery.each(array, function() {
      json[this.name] = this.value || '';
    });
    return json;
  }

  /*this function for upload file content*/
  function uploadWithoutSubmit() {
    $('#file').change(function() {
      var name      = document.getElementById("file").files[0].name;
      var form_data = new FormData();
      var ext       = name.split('.').pop().toLowerCase();
      var group_id  = $(".sidebar-content .nav-link.active").attr('data-id');
      var assets_source = $('#assets-source').val();
      console.log(group_id);
      form_data.append("group_id", group_id);
      form_data.append("assets_source", assets_source);

      if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        alert("Invalid Image File");
      }
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("file").files[0]);
      var f = document.getElementById("file").files[0];
      var fsize = f.size || f.fileSize;
      if (fsize > 2000000) {
        alert("Image File Size is very big");
      } else {
        form_data.append("file", document.getElementById('file').files[0]);
        $.ajax({
          // url: '<?php echo base_url("admin/Api/jsonUploadWithoutSubmit") ?>',
          url: base_url + "admin/Api/jsonUploadWithoutSubmit",
          type: "POST",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('#table-content').html("<label class='text-success'>Image Uploading...</label>");
            $('#table-content').empty();
          },
          success: function(data) {
            location.reload();
            // $('#table-content').empty(); 
            // $('#table-content').html(data);
          }
        });
      }
    });
  }


  /*change option entries in form entries template side right*/
  function changeEntriesType() {
    $('#entries-form').change(function() {
      var id = $('#entries-form option:selected').attr('data-id');
      $.ajax({
          // url: '<?php echo base_url('admin/api/jsonSelectEntriesType') ?>',
          url: base_url + "admin/Api/jsonSelectEntriesType",
          type: 'POST',
          dataType: 'json',
          data: {
            id: id
          },
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
  function uploadAssetsInEntries() {
    $('#entries-file').change(function() {
      var name = document.getElementById("entries-file").files[0].name;
      var form_data = new FormData();
      var ext = name.split('.').pop().toLowerCase();
      var group_id = $(".assets-list .active").attr('data-id');
      var assets_source = $('#assets-source').val();
      form_data.append("group_id", group_id);
      form_data.append("assets_source", assets_source);

      if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        alert("Invalid Image File");
      }
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("entries-file").files[0]);
      var f = document.getElementById("entries-file").files[0];
      var fsize = f.size || f.fileSize;
      if (fsize > 2000000) {
        alert("Image File Size is very big");
      } else {
        form_data.append("entries-file", document.getElementById('entries-file').files[0]);
        $.ajax({
          // url: '<?php echo base_url("admin/Api/jsonUploadAssetsInEntries") ?>',
          url: base_url + "admin/Api/jsonUploadAssetsInEntries",
          type: "POST",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('#uploadModal').html("<label class='text-success'>Image Uploading...</label>");
            $('#uploadModal').empty();
          },
          success: function(data) {
            // location.reload();
            $('#uploadModal').empty();
            $('#uploadModal').html(data);
            var table = $('#datatableModal').DataTable();
            $('#datatableModal tbody').on('click', 'tr', function() {
              $(this).toggleClass('selected');
            });
            $('#button').click(function() {
              alert(table.rows('.selected').data().length + ' row(s) selected');
            });
          }
        });
      }
    });
  }

  /*Manage Users Settings Form*/
  function manageUsersSettings() {
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
      if ($('#usersgroup-form [name="sectionEdit[' + section + ']"]').is(':checked') == true) {
        $('#usersgroup-form [name="sectionPublishLiveChange[' + section + ']"]').removeAttr("disabled", "disabled");
        $('#usersgroup-form [name="sectionEditOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
      } else {
        $('#usersgroup-form [name="sectionPublishLiveChange[' + section + ']"]').attr("disabled", "disabled");
        $('#usersgroup-form [name="sectionEditOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
        $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
        $('#usersgroup-form [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
      }

      if ($('#usersgroup-form [name="sectionEditOtherAuthors[' + section + ']"]').is(':checked') == true) {
        $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
        $('#usersgroup-form [name="sectionDelete[' + section + ']"]').removeAttr("disabled", "disabled");
      } else {
        $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
        $('#usersgroup-form [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
      }

      // alert(section);
      $('#usersgroup-form [name="sectionEdit[' + section + ']"]').click(function() {
        if ($(this).is(':checked') == true) {
          $('#usersgroup-form [name="sectionPublishLiveChange[' + section + ']"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="sectionEditOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
        } else {
          $('#usersgroup-form [name="sectionPublishLiveChange[' + section + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="sectionPublishLiveChange[' + section + ']"]').attr("checked", false);
          $('#usersgroup-form [name="sectionEditOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="sectionEditOtherAuthors[' + section + ']"]').attr("checked", false);
          $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').attr("checked", false);
          $('#usersgroup-form [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="sectionDelete[' + section + ']"]').attr("checked", false);
        }
      });

      $('#usersgroup-form [name="sectionEditOtherAuthors[' + section + ']"]').click(function() {
        if ($(this).is(':checked') == true) {
          $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="sectionDelete[' + section + ']"]').removeAttr("disabled", "disabled");
        } else {
          $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="sectionPublishOtherAuthors[' + section + ']"]').attr("checked", false);
          $('#usersgroup-form [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="sectionDelete[' + section + ']"]').attr("checked", false);
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
      if ($('#usersgroup-form [name="volumeView[' + assets + ']"]').is(':checked') == true) {
        $('#usersgroup-form [name="volumeUploadFiles[' + assets + ']"]').removeAttr("disabled", "disabled");
        $('#usersgroup-form [name="volumeCreateSubfolder[' + assets + ']"]').removeAttr("disabled", "disabled");
        $('#usersgroup-form [name="volumeRemoveFilesAndFolders[' + assets + ']"]').removeAttr("disabled", "disabled");
        $('#usersgroup-form [name="volumeEditImages[' + assets + ']"]').removeAttr("disabled", "disabled");
      } else {
        $('#usersgroup-form [name="volumeUploadFiles[' + assets + ']"]').attr("disabled", "disabled");
        $('#usersgroup-form [name="volumeCreateSubfolder[' + assets + ']"]').attr("disabled", "disabled");
        $('#usersgroup-form [name="volumeRemoveFilesAndFolders[' + assets + ']"]').attr("disabled", "disabled");
        $('#usersgroup-form [name="volumeEditImages[' + assets + ']"]').attr("disabled", "disabled");
      }

      // alert(assets);
      $('#usersgroup-form [name="volumeView[' + assets + ']"]').click(function() {
        if ($(this).is(':checked') == true) {
          $('#usersgroup-form [name="volumeUploadFiles[' + assets + ']"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="volumeCreateSubfolder[' + assets + ']"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="volumeRemoveFilesAndFolders[' + assets + ']"]').removeAttr("disabled", "disabled");
          $('#usersgroup-form [name="volumeEditImages[' + assets + ']"]').removeAttr("disabled", "disabled");
        } else {
          $('#usersgroup-form [name="volumeUploadFiles[' + assets + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="volumeUploadFiles[' + assets + ']"]').attr("checked", false);
          $('#usersgroup-form [name="volumeCreateSubfolder[' + assets + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="volumeCreateSubfolder[' + assets + ']"]').attr("checked", false);
          $('#usersgroup-form [name="volumeRemoveFilesAndFolders[' + assets + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="volumeRemoveFilesAndFolders[' + assets + ']"]').attr("checked", false);
          $('#usersgroup-form [name="volumeEditImages[' + assets + ']"]').attr("disabled", "disabled");
          $('#usersgroup-form [name="volumeEditImages[' + assets + ']"]').attr("checked", false);
        }
      });
    });

    /*Users Settings List*/
    $('#users-settings [name="allowRegistration"]').click(function() {
      if ($(this).is(':checked') == true) {
        $('#users-settings .default-group').removeClass('d-none');
      } else {
        $('#users-settings .default-group').addClass('d-none');
      }
    });
  }


  /**
   * tHIS FUNCTION USE TO SHOW DATA IN MODAL WHEN ASSETS BUTTON CLICK
   * @return {[type]} [description]
   */
  function getModalAssets() {
    var table_content = $('input[name="table"]').val();
    var id            = $('input[name="id"]').val();
    var parent_id     = $('input[name="parent_id"]').val();
    var assets_id     = $('[data-target="#assetsModal"]').data('assets-id');
    var assets_fields = $('[data-target="#assetsModal"]').data('assets-fields');
    var assets_source = $('[data-target="#assetsModal"]').data('assets-source');
    var ass_limit     = $('[data-target="#assetsModal"]').data('assets-limit');

    $('[data-target="#assetsModal"]').click(function(e) {
      e.preventDefault();
      var list_selected = $('.ass-list').map(function() {
          return this.value;
      }).get();

      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          table : table_content,
          id : id,
          parent_id : parent_id,
          assets_id: assets_id,
          assets_fields: assets_fields,
          assets_source: assets_source,
          list_selected : list_selected,
          ass_limit: ass_limit
        },
        // url : '<?php echo base_url("admin/Api/jsonAssetsEntriesUpload") ?>',
        url: base_url + "admin/Api/jsonAssetsEntriesUpload",
      }).done(function(data) {
        $('li.assets-groups').html(data.name);
        $('#assetsModal .right-modal').html(data.table);

        var table = $('table.datatableModal').DataTable();
        $('.datatableModal tbody').on('click', 'tr', function() {
          $(this).toggleClass('selected');
        });
        $('#button').click(function() {
          alert(table.rows('.selected').data().length + ' row(s) selected');
        });
      }).fail(function(errot) {});
    });

    $('#select-assets').click(function(e) {
      e.preventDefault();
      var list_selected = $('.ass-list').map(function() {
          return this.value;
      }).get();

      var id_content = [];
      $("tbody tr.selected").each(function() {
        id_content.push($('tr.selected input').data('id'));
        $(this).toggleClass("selected");
      });

      $.ajax({
          // url: '<?php echo base_url('admin/api/jsonAssetsSelectSubmit') ?>',
          url: base_url + "admin/Api/jsonAssetsSelectSubmit",
          type: 'POST',
          dataType: 'json',
          data: {
            table : table_content,
            id : id,
            parent_id : parent_id,
            assets_id: assets_id,
            assets_fields: assets_fields,
            assets_content_Id: id_content,
            list_selected : list_selected,
            ass_limit: ass_limit
          },
      }).done(function(data) {
        $('#fields-assets-entries .selected').html(data.html);
        
        if (data.counter > 0) {
          if (data.counter >= ass_limit) {
            $('#fields-assets-entries button').attr('disabled', 'disabled');
          } else {
            $('#fields-assets-entries button').removeAttr("disabled", "disabled");
          }
        }

        $("#fields-assets-entries ul.selected li a").click(function(e) {
          $(this).closest('li').remove();
          var list_selected = $('.ent-list').map(function() {
            return this.value;
          }).get();
          if (data.counter > 0) {
            if (list_selected.length < ass_limit) {
              $('#fields-assets-entries button').removeAttr("disabled", "disabled");
            } else {
              $('#fields-assets-entries button').attr('disabled', 'disabled');
            }
          }
        });
      }).fail(function() {
        console.log("error");
      }).always(function() {
        console.log("complete");
      });
    });

    $("#fields-assets-entries ul.selected li a").click(function(e) {
      $(this).closest('li').remove();
    });
  }

  /**
   * tHIS FUNCTION USE TO SHOW MODAL WHEN CLICK BUTTON CATEGORIES IN ENTRIES FORM
   */
  function getModalCategories() {
    var table_content = $('input[name="table"]').val();
    var id            = $('input[name="id"]').val();
    var parent_id     = $('input[name="parent_id"]').val();
    var cat_id        = $('[data-target="#categoriesModal"]').data('categories-id');
    var cat_fields    = $('[data-target="#categoriesModal"]').data('categories-fields');
    var cat_limit     = $('[data-target="#categoriesModal"]').data('categories-limit');

    $('[data-target="#categoriesModal"]').click(function(e) {
      e.preventDefault();
      var list_selected = $('.cat-list').map(function() {
        return this.value;
      }).get();
      console.log(list_selected);

      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          table: table_content,
          id: id,
          parent_id: parent_id,
          cat_id: cat_id,
          cat_fields: cat_fields,
          cat_limit: cat_limit
        },
        // url : '<?php echo base_url("admin/Api/jsonAssetsEntriesUpload") ?>',
        url: base_url + "admin/Api/jsonCategoriesEntriesUpload",
      }).done(function(data) {
        $('#categoriesModal .middle-modal').empty();
        $('#categoriesModal .middle-modal').html(data.table);

        var table = $('table.datatableModal').DataTable();
        $('.datatableModal tbody').on('click', 'tr', function() {
          $(this).toggleClass('selected');
        });
        $('#button').click(function() {
          alert(table.rows('.selected').data().length + ' row(s) selected');
        });
      }).fail(function(errot) {});
    });

    $('#select-categories').click(function(e) {
      e.preventDefault();
      var list_selected = $('.cat-list').map(function() {
        return this.value;
      }).get();

      var id_content = [];
      $("tbody tr.selected").each(function() {
        id_content.push($('tr.selected input').data('id'));
        $(this).toggleClass("selected");
      });

      $.ajax({
          // url: '<?php echo base_url('admin/api/jsonAssetsSelectSubmit') ?>',
          url: base_url + "admin/Api/jsonCategoriesSelectSubmit",
          type: 'POST',
          dataType: 'json',
          data: {
            table: table_content,
            id: id,
            parent_id: parent_id,
            cat_id: cat_id,
            cat_fields: cat_fields,
            cat_content_Id: id_content,
            list_selected: list_selected,
            cat_limit: cat_limit
          },
        })
        .done(function(data) {
          $('#fields-categories-entries .selected').html(data.html);

          if (data.counter > 0) {
            if (data.counter >= cat_limit) {
              $('#fields-categories-entries button').attr('disabled', 'disabled');
            } else {
              $('#fields-categories-entries button').removeAttr("disabled", "disabled");
            }
          }

          $("#fields-categories-entries ul.selected li a").click(function(e) {
            $(this).closest('li').remove();
            var list_selected = $('.ent-list').map(function() {
              return this.value;
            }).get();
            if (data.counter > 0) {
              if (list_selected.length < cat_limit) {
                $('#fields-categories-entries button').removeAttr("disabled", "disabled");
              } else {
                $('#fields-categories-entries button').attr('disabled', 'disabled');
              }
            }
          });
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    });

    $("#fields-categories-entries ul.selected li a").click(function(e) {
      $(this).closest('li').remove();
    });
  }

  /**
   * tHIS FUNCTION USE TO SHOW MODAL WHEN CLICK BUTTON CATEGORIES IN ENTRIES FORM
   */
  function getModalEntries() {
    var table_content = $('input[name="table"]').val();
    var id            = $('input[name="id"]').val();
    var parent_id     = $('input[name="parent_id"]').val();
    var ent_id        = $('[data-target="#entriesModal"]').data('entries-id');
    var ent_fields    = $('[data-target="#entriesModal"]').data('entries-fields');
    var ent_limit     = $('[data-target="#entriesModal"]').data('entries-limit');

    $('[data-target="#entriesModal"]').click(function(e) {
      e.preventDefault();
      var list_selected = $('.ent-list').map(function() {
        return this.value;
      }).get();
      console.log(list_selected.length);

      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          table: table_content,
          id: id,
          parent_id: parent_id,
          ent_id: ent_id,
          ent_fields: ent_fields,
          ent_limit: ent_limit
        },
        // url : '<?php echo base_url("admin/Api/jsonAssetsEntriesUpload") ?>',
        url: base_url + "admin/Api/jsonEntEntriesUpload",
      }).done(function(data) {
        $('li.entries-groups').html(data.name);
        $('#entriesModal .right-modal').html(data.table);

        var table = $('table.datatableModal').DataTable();
        $('.datatableModal tbody').on('click', 'tr', function() {
          $(this).toggleClass('selected');
        });
        $('#button').click(function() {
          alert(table.rows('.selected').data().length + ' row(s) selected');
        });
      }).fail(function(errot) {});
    });

    $('#select-entries').click(function(e) {
      e.preventDefault();
      var list_selected = $('.ent-list').map(function() {
        return this.value;
      }).get();

      var id_content = [];
      $("tbody tr.selected").each(function() {
        id_content.push($('tr.selected input').data('id'));
        $(this).toggleClass("selected");
      });

      $.ajax({
          // url: '<?php echo base_url('admin/api/jsonAssetsSelectSubmit') ?>',
          url: base_url + "admin/Api/jsonEntSelectSubmit",
          type: 'POST',
          dataType: 'json',
          data: {
            table: table_content,
            id: id,
            parent_id: parent_id,
            ent_id: ent_id,
            ent_fields: ent_fields,
            ent_content_Id: id_content,
            list_selected: list_selected,
            ent_limit: ent_limit
          },
        })
        .done(function(data) {
          $('#fields-entries-entries .selected').html(data.html);

          if (data.counter > 0) {
            if (data.counter >= ent_limit) {
              $('#fields-entries-entries button').attr('disabled', 'disabled');
            } else {
              $('#fields-entries-entries button').removeAttr("disabled", "disabled");
            }
          }

          $("#fields-entries-entries ul.selected li a").click(function(e) {
            $(this).closest('li').remove();
            var list_selected = $('.ent-list').map(function() {
              return this.value;
            }).get();

            if (data.counter > 0) {
              if (list_selected.length < ent_limit) {
                $('#fields-entries-entries button').removeAttr("disabled", "disabled");
              } else {
                $('#fields-entries-entries button').attr('disabled', 'disabled');
              }
            }
          });
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    });

    $("#fields-entries-entries ul.selected li a").click(function(e) {
      $(this).closest('li').remove();
    });
  }

  /**
   * This is function to tabs add and remoave 
   */
  function tabsMultisortable() {
    $('#dialog').append('<form> <fieldset class="ui-helper-reset"> <label for="tab_title">Title</label><input type="text" name="tab_title" id="tab_title" value="Tab Title" class="ui-widget-content ui-corner-all"></fieldset> </form>');
    var tabTitle = $( "#tab_title" ),
      tabContent = $( "#tab_content" ),
      // tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
      tabTemplate = '<a href="#{href}" class="nav-link active #{id}"  data-toggle="tab" role="tab" aria-controls="#{id}" aria-selected="true">#{label}<span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span></a>',
      tabCounter = 2;

     // add tabs layout
    removeTab();
    $('#add_tab').click(function() {
      dialog.dialog( "open" );
    });
 
    // Modal dialog init: custom buttons and a "close" callback resetting the form inside
    var dialog = $( "#dialog" ).dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Add: function() {
          addTab();
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
      }
    });
 
    // AddTab form: calls addTab function on submit and closes the dialog
    var form = dialog.find( "form" ).on( "submit", function( event ) {
      addTab();
      dialog.dialog( "close" );
      event.preventDefault();
    });
 
    // Actual addTab function: adds new tab using the input from the form above
    function addTab() {
      var label = tabTitle.val() || "Tab " + tabCounter,
        id = "tabs-" + tabCounter,
        li = tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ).replace( /#\{id\}/g, id ),
        tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";

      $('.field-tabs').append('<div class="field-group" id="'+ id +'"> <ul class="nav nav-tabs" role="tablist"> <li class="nav-item" data-id="'+id+'">' + li + '</li> </ul> <div class="tab-content" id="myTabContent"> <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab"> <ul class="sortable text-center list-group connectedSortable"></ul> </div> </div> </div>');
      
      tabCounter++;

      $('.sortable').multisortable({
        items: 'li',
        connectWith: '.sortable',
        container: '.tab-content',
      });

      // Close icon: removing the tab on click
      $("#"+id).on( "click", "span.ui-icon-close", function( event ) {
        event.preventDefault();
        var panelId = $( this ).closest('a').attr( "aria-controls" );
        var panelSelector = "#" + panelId + " .sortable";
        var count   = $(panelSelector).children().length;
        if (count == 0) {
          $( "#" + panelId ).remove();
        } else {
          confirm("your tabs is not empty, please drag and drop your list");
        }
      });
    }
  
    function removeTab() {
      // Close icon: removing the tab on click
      $('span.ui-icon-close').on( "click", function( event ) {
        event.preventDefault();
        var panelId = $( this ).closest('a').attr( "aria-controls" );
        var panelSelector = "#" + panelId + " .sortable";
        var count   = $(panelSelector).children().length;
        if (count == 0) {
          $( "#" + panelId ).remove();
        } else {
          confirm("your tabs is not empty, please drag and drop your list");
        }
      });
    }
  }

