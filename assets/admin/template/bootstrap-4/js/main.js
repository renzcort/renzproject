  var base_url = "http://renzproject.localhost/";
  function layout(){
    var leftcontent        = document.getElementById('left-content');
    var leftcontentTop     = leftcontent.offsetTop;
    var leftcontentHeight  = leftcontent.offsetHeight;
    var rightcontent       = document.getElementById('right-content');
    var rightcontentHeight = rightcontent.offsetHeight;
    window.onscroll = function() {
      if (window.pageYOffset >= 100) {
        if (window.pageYOffset >= leftcontentTop && window.pageYOffset <= leftcontentHeight) {
          leftcontent.classList.add("fixed-left-content");
          rightcontent.classList.add("fixed-right-content");
        } else {
          leftcontent.classList.remove("fixed-left-content");
          rightcontent.classList.remove("fixed-right-content");
        }
      } else {
        leftcontent.classList.remove("fixed-left-content");
        rightcontent.classList.remove("fixed-right-content");
      }
    };
  }

  /**
   * GROUPS API
   * @return {[type]} [description]
   */
  function manageGroups() {
    var table       = $('#sidebar-groups').data('table'),
        table_group = $('#sidebar-groups').data('table-group'),
        action      = $('#sidebar-groups').data('action');

    // Rename Groups 
    $('#groups-rename').click(function() {
      var group_id = $('#sidebar-groups .nav-link.active').data('id');
      $.ajax({
        type: 'POST',
        datatype: 'json',
        data: {
          table: table,
          table_group: table_group,
          group_id: group_id,
        },
        // url: '<?php echo base_url("admin/Api/jsonGetGroupsById") ?>',
        url: base_url + "admin/Api/jsonModalShowGroupsById",
      }).done(function(data) {
        modalUpdateGroups(data);
      }).fail(function(jqXHR, textStatus, errorThrown) {});
      return false;
    });

    // function update modal success
    function modalUpdateGroups(data) {
      $('#groupsModal .modal-body').append('<input type="hidden" name="id" value="' + data.id + '" class="form-control">');
      $('#groupsModal input[type="text"]').val(data.name);
      $('#groupsModal textarea').val(data.description);
      $('#groupsModal button[type="submit"]').attr('name', 'update');
      $('#groupsModal button[type="submit"]').text('Update');
      $('#groupsModal').modal('show');
    }

    // Delete Groups
    $('#groups-delete').click(function() {
      var group_id = $('#sidebar-groups .nav-link.active').data('id');
      if (confirm("Are you sure?")) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          data: {
            table: table,
            table_group : table_group,
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

    // Display List  Fields By Groups name
    $('#sidebar-groups .nav-item').click(function() {
      var group_id = $('#sidebar-groups .nav-link.active').data('id');
      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          table: table,
          table_group: table_group,
          action: action,
          group_id: group_id
        },
        // url : '<?php echo base_url("admin/Api/jsonGetDataByIdGroups") ?>',
        url: base_url + "admin/Api/jsonDisplayDataByGroups",
      }).done(function(data) {
        $('#right-content table').remove();
        $('#right-content .empty-data').remove();
        $('#right-content').append(data);
      }).fail(function(error) {});
    });
  }
  /*END Groups*/

  /**
   * tHIS FUNCTION USE TO SHOW DATA IN MODAL WHEN ASSETS BUTTON CLICK
   */
  function modalAssets() {
    var parent_table  = $('input[name="parent_table"]').val();
    var parent_id     = $('input[name="parent_id"]').val();
    var table_content = $('input[name="table_content"]').val();
    var id            = $('input[name="id"]').val();
    var assets_fields = $('[data-target="#assetsModal"]').data('assets-fields');
    var assets_id     = $('[data-target="#assetsModal"]').data('assets-id');
    var assets_limit  = $('[data-target="#assetsModal"]').data('assets-limit');
    var assets_source = $('[data-target="#assetsModal"]').data('assets-source');

    /*Show Modal Assets*/
    $('[data-target="#assetsModal"]').click(function(e) {
      e.preventDefault();
      var list_selected = $('.assets-list').map(function() {
          return this.value;
      }).get();

      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          parent_table : parent_table,
          parent_id : parent_id,
          table_content : table_content,
          id : id,
          assets_fields: assets_fields,
          assets_id: assets_id,
          assets_limit: assets_limit,
          assets_source: assets_source,
          list_selected : list_selected,
        },
        // url : '<?php echo base_url("admin/Api/jsonAssetsEntriesUpload") ?>',
        url: base_url + "admin/Api/jsonDisplayModalAssets",
      }).done(function(data) {
        $('#assetsModal .modal-body').html(data);

        var table = $('table.datatableModal').DataTable();
        $('.datatableModal tbody').on('click', 'tr', function() {
          $(this).toggleClass('selected');
        });
        $('#button').click(function() {
          alert(table.rows('.selected').data().length + ' row(s) selected');
        });
      }).fail(function(error) {});
    });

    /*Select List Modal Assets*/
    $('#assets-modal-select').click(function(e) {
      e.preventDefault();
      var list_selected = $('.assets-list').map(function() {
          return this.value;
      }).get();

      var assets_content_Id = [];
      $("tbody tr.selected").each(function() {
        assets_content_Id.push($('tr.selected input').data('id'));
        $(this).toggleClass("selected");
      });

      $.ajax({
          // url: '<?php echo base_url('admin/api/jsonAssetsSelectSubmit') ?>',
          url: base_url + "admin/Api/jsonSubmitModalAssets",
          type: 'POST',
          dataType: 'json',
          data: {
            parent_table : parent_table,
            parent_id : parent_id,
            table_content : table_content,
            id : id,
            assets_fields: assets_fields,
            assets_id: assets_id,
            assets_limit: assets_limit,
            assets_source: assets_source,
            list_selected : list_selected,
            assets_content_Id: assets_content_Id,
          },
      }).done(function(data) {
        $('#assetscontent-list-selected .selected').html(data.html);
        if (data.counter > 0) {
          if (data.counter >= assets_limit) {
            $('#assetscontent-list-selected button').attr('disabled', 'disabled');
          } else {
            $('#assetscontent-list-selected button').removeAttr("disabled", "disabled");
          }
        }

        $("#assetscontent-list-selected .fa-times").click(function(e) {
          $(this).closest('li').remove();
          var list_selected = $('.assets-list').map(function() {
            return this.value;
          }).get();

          if (data.counter > 0) {
            if (list_selected.length < assets_limit) {
              $('#assetscontent-list-selected button').removeAttr("disabled", "disabled");
            } else {
              $('#assetscontent-list-selected button').attr('disabled', 'disabled');
            }
          }
        });
        console.log("error");
      }).always(function() {
        console.log("complete");
      });
    });
    
    /*Upload Modal Assets*/
    $('#assets-modal-file').change(function() {
      var name          = document.getElementById("assets-modal-file").files[0].name;
      var form_data     = new FormData();
      var ext           = name.split('.').pop().toLowerCase();
      var assets_id     = $("#assetsModal .modal-body [name='assets_id']").val();
      var assets_source = $("#assetsModal .modal-body [name='assets_source']").val();
      form_data.append("assets_id", assets_id);
      form_data.append("assets_source", assets_source);
      if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        alert("Invalid Image File");
      }
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("assets-modal-file").files[0]);
      var f = document.getElementById("assets-modal-file").files[0];
      var fsize = f.size || f.fileSize;
      if (fsize > 2000000) {
        alert("Image File Size is very big");
      } else {
        form_data.append("assets-modal-file", document.getElementById('assets-modal-file').files[0]);
        $.ajax({
          // url: '<?php echo base_url("admin/Api/jsonUploadAssetsInEntries") ?>',
          url: base_url + "admin/Api/jsonUploadModalAssets",
          type: "POST",
          data: form_data,
          dataType: 'json',
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('#assetsModal .modal-body .tab-content .assets-content-list').html("<label class='text-success'>Image Uploading...</label>");
            $('#assetsModal .modal-body .tab-content .assets-content-list').empty();
          },
          success: function(data) {
            // location.reload();
            $('#assetsModal .modal-body .tab-content .assets-content-list').empty();
            $('#assetsModal .modal-body .tab-content .assets-content-list').html(data);

            var table = $('table.datatableModal').DataTable();
            $('.datatableModal tbody').on('click', 'tr', function() {
              $(this).toggleClass('selected');
            });
            $('#button').click(function() {
              alert(table.rows('.selected').data().length + ' row(s) selected');
            });
          }
        });
      }
    });
  
    /*Delete Modal Assets*/
    $("#assetscontent-list-selected .fa-times").click(function(e) {
      $(this).closest('li').remove();
    });
  }
  
  /**
   * tHIS FUNCTION USE TO SHOW MODAL WHEN CLICK BUTTON CATEGORIES IN ENTRIES FORM
   */
  function modalCategories() {
    var parent_table      = $('input[name="parent_table"]').val();
    var parent_id         = $('input[name="parent_id"]').val();
    var table_content     = $('input[name="table_content"]').val();
    var id                = $('input[name="id"]').val();
    var categories_fields = $('[data-target="#categoriesModal"]').data('categories-fields');
    var categories_id     = $('[data-target="#categoriesModal"]').data('categories-id');
    var categories_limit  = $('[data-target="#categoriesModal"]').data('categories-limit');
    
    $('[data-target="#categoriesModal"]').click(function(e) {
      e.preventDefault();
      var list_selected = $('.categories-list').map(function() {
        return this.value;
      }).get();

      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          parent_table : parent_table,
          parent_id : parent_id,
          table_content : table_content,
          id : id,
          categories_fields: categories_fields,
          categories_id: categories_id,
          categories_limit: categories_limit,
          list_selected : list_selected,
        },
        // url : '<?php echo base_url("admin/Api/jsonAssetsEntriesUpload") ?>',
        url: base_url + "admin/Api/jsonDisplayModalCategories",
      }).done(function(data) {
        $('#categoriesModal .modal-body').html(data);

        var table = $('table.datatableModal').DataTable();
        $('.datatableModal tbody').on('click', 'tr', function() {
          $(this).toggleClass('selected');
        });
        $('#button').click(function() {
          alert(table.rows('.selected').data().length + ' row(s) selected');
        });
      }).fail(function(error) {});
    });

    $('#categories-modal-select').click(function(e) {
      e.preventDefault();
      var list_selected = $('.categories-list').map(function() {
        return this.value;
      }).get();

      var categories_content_id = [];
      $("tbody tr.selected").each(function() {
        categories_content_id.push($('tr.selected input').data('id'));
        $(this).toggleClass("selected");
      });

      $.ajax({
        // url: '<?php echo base_url('admin/api/jsonAssetsSelectSubmit') ?>',
        url: base_url + "admin/Api/jsonSubmitModalCategories",
        type: 'POST',
        dataType: 'json',
        data: {
          parent_table : parent_table,
          parent_id : parent_id,
          table_content : table_content,
          id : id,
          categories_fields: categories_fields,
          categories_id: categories_id,
          categories_limit: categories_limit,
          list_selected : list_selected,
          categories_content_id : categories_content_id,
        },
      })
      .done(function(data) {
        $('#categoriescontent-list-selected .selected').html(data.list_view);

        if (data.counter > 0) {
          if (data.counter >= categories_limit) {
            $('#categoriescontent-list-selected button').attr('disabled', 'disabled');
          } else {
            $('#categoriescontent-list-selected button').removeAttr("disabled", "disabled");
          }
        }

        $("#categoriescontent-list-selected .fa-times").click(function(e) {
          $(this).closest('li').remove();
          var list_selected = $('.ent-list').map(function() {
            return this.value;
          }).get();
          if (data.counter > 0) {
            if (list_selected.length < categories_limit) {
              $('#categoriescontent-list-selected button').removeAttr("disabled", "disabled");
            } else {
              $('#categoriescontent-list-selected button').attr('disabled', 'disabled');
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

    $("#categoriescontent-list-selected .fa-times").click(function(e) {
      $(this).closest('li').remove();
    });
  }

  /**
   * tHIS FUNCTION USE TO SHOW MODAL WHEN CLICK BUTTON CATEGORIES IN ENTRIES FORM
   */
  function modalEntries() {
    var parent_table   = $('input[name="parent_table"]').val(),
        parent_id      = $('input[name="parent_id"]').val(),
        table_content  = $('input[name="table_content"]').val(),
        id             = $('input[name="id"]').val(),
        entries_fields = $('[data-target="#entriesModal"]').data('entries-fields'),
        section_id     = $('[data-target="#entriesModal"]').data('section-id'),
        entries_limit  = $('[data-target="#entriesModal"]').data('entries-limit');


    $('[data-target="#entriesModal"]').click(function(e) {
      e.preventDefault();
      var list_selected = $('.entries-list').map(function() {
        return this.value;
      }).get();

      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
          parent_table : parent_table,
          parent_id : parent_id,
          table_content : table_content,
          id : id,
          entries_fields: entries_fields,
          section_id: section_id,
          entries_limit: entries_limit,
        },
        // url : '<?php echo base_url("admin/Api/jsonAssetsEntriesUpload") ?>',
        url: base_url + "admin/Api/jsonDisplayModalEntries",
      }).done(function(data) {
        // $('ul.entries-groups').html(data.name);
        $('#entriesModal .modal-body').html(data);

        var table = $('table.datatableModal').DataTable();
        $('.datatableModal tbody').on('click', 'tr', function() {
          $(this).toggleClass('selected');
        });
        $('#button').click(function() {
          alert(table.rows('.selected').data().length + ' row(s) selected');
        });
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });

    $('#entries-modal-select').click(function(e) {
      e.preventDefault();
      var list_selected = $('.entries-list').map(function() {
        return this.value;
      }).get();

      var entries_content_id = [];
      $("tbody tr.selected").each(function() {
        entries_content_id.push($('tr.selected input').data('id'));
        $(this).toggleClass("selected");
      });
      
      $.ajax({
          // url: '<?php echo base_url('admin/api/jsonAssetsSelectSubmit') ?>',
          url: base_url + "admin/Api/jsonSubmitModalEntries",
          type: 'POST',
          dataType: 'json',
          data: {
            parent_table : parent_table,
            parent_id : parent_id,
            table_content : table_content,
            id : id,
            entries_fields: entries_fields,
            section_id: section_id,
            entries_limit: entries_limit,
            list_selected : list_selected,
            entries_content_id: entries_content_id,
          },
        })
        .done(function(data) {
          $('#entriescontent-list-selected .selected').html(data.list_view);

          if (data.counter > 0) {
            if (data.counter >= entries_limit) {
              $('#entriescontent-list-selected button').attr('disabled', 'disabled');
            } else {
              $('#entriescontent-list-selected button').removeAttr("disabled", "disabled");
            }
          }

          $("#entriescontent-list-selected .fa-times").click(function(e) {
            $(this).closest('li').remove();
            var list_selected = $('.ent-list').map(function() {
              return this.value;
            }).get();

            if (data.counter > 0) {
              if (list_selected.length < entries_limit) {
                $('#entriescontent-list-selected button').removeAttr("disabled", "disabled");
              } else {
                $('#entriescontent-list-selected button').attr('disabled', 'disabled');
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

    $("#entriescontent-list-selected .fa-times").click(function(e) {
      $(this).closest('li').remove();
    });
  }


  /**
   * This Function Used To Manage Assets Uploads
   * @return {[type]} [description]
   */
  function manageAssets() {
    var table       = $('#sidebar-groups').data('table'),
        table_group = $('#sidebar-groups').data('table-group'),
        action      = $('#sidebar-groups').data('action');


    /*Upload Assets File Without submit button*/
    $('#file').change(function() {
      var name      = document.getElementById("file").files[0].name;
      var form_data = new FormData();
      var ext       = name.split('.').pop().toLowerCase();
      var group_id  = $('#left-content .nav-link.active').data('id');
      form_data.append("group_id", group_id);

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
          url: base_url + "admin/Api/jsonUploadAssetsList",
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


  /**
   * This is function to tabs add and remoave 
   */
  function tabsMultisortable() {
    $('#dialog').append('<form> <fieldset class="ui-helper-reset"> <label for="tab_title">Title</label><input type="text" name="tab_title" id="tab_title" value="Tab Title" class="ui-widget-content ui-corner-all"></fieldset> </form>');
    var tabTitle = $( "#tab_title" ),
      tabContent = $( "#tab_content" ),
      // tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
      tabTemplate = '<a href="#{href}" class="nav-link active #{id}"  data-toggle="tab" role="tab" aria-controls="#{id}" aria-selected="true">#{label} <span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span> <span class="ui-icon ui-icon-pencil" role="presentation">Edit Tab</span></a>'; 
      
    /*Get Counter Tabs*/
    if ($('.my-tabs').length) {
      var tabCounter = $('.my-tabs').last().data('count') + 1
    } else {
      var tabCounter = 1;
    }

     // add tabs layout
    $('#add_tab').click(function() {
      $("#dialog_id").remove();
      if ($('.my-tabs').length >= 3) {
        $(this).attr('disabled', 'disabled');
        dialog.dialog( "close" );
      } else {
        $(this).removeAttr('disabled', 'disabled');
        dialog.dialog( "open" );
      }
    });

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
      if ($('.my-tabs').length >= 3) {
        $('#add_tab').attr('disabled', 'disabled');
      } else {
        $('#add_tab').removeAttr('disabled', 'disabled');
      }
    });
  
   // Update Title Heading 
   $('span.ui-icon-pencil').click(function(event) {
      event.preventDefault();
      $("#dialog_id").remove();
      var panelId  = $( this ).closest('a').attr( "aria-controls" );
      var tabTitle = $.trim($( this ).closest('a').clone().children().remove().end().text());
      $('#tab_title').val(tabTitle);
      $('#dialog').find("fieldset").append("<input type='hidden' id='dialog_id' value='"+panelId+"'>");
      dialog.dialog( "open" );
    });
 
    // Modal dialog init: custom buttons and a "close" callback resetting the form inside
    var dialog = $( "#dialog" ).dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Submit: function() {
          if ($("#dialog_id").length == 0) {
            addTab();
          } else {
            updateTab();
          }
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
      if ( $("#dialog_id").length == 0 ) {
        addTab();
      } else {
        updateTab();
      }
      dialog.dialog( "close" );
      event.preventDefault();
    });
 
    // Actual addTab function: adds new tab using the input from the form above
    function addTab() {
      var label = tabTitle.val().charAt(0).toUpperCase() + tabTitle.val().slice(1) || "Tab " + tabCounter,
        slug = label.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,''),
        id = "tabs-" + tabCounter,
        li = tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ).replace( /#\{id\}/g, id ),
        tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";

      $('#fields-tabs-group').append('<div class="fields-group my-tabs" id="'+ id +'" data-count="'+ tabCounter +'"> <ul class="nav nav-tabs" role="tablist"> <li class="nav-item" data-tabs-title="'+slug+'">' + li + '</li> </ul> <div class="tab-content"> <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab"> <ul id="sortable-in" class="sortable text-center list-group connectedSortable"></ul> </div> </div> </div>');
      tabCounter++;

      $(".sortable, #sortable1, #sortable2").sortable({
        connectWith: ".connectedSortable"
      }).disableSelection();

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

        if ($('.my-tabs').length >= 3) {
          $('#add_tab').attr('disabled', 'disabled');
        } else {
          $('#add_tab').removeAttr('disabled', 'disabled');
        }
      });

      // Update Icon Label Tabs
       $("#"+id).on( "click", "span.ui-icon-pencil", function( event ) {
        // event.preventDefault();
        $("#dialog_id").remove();
        var panelId  = $( this ).closest('a').attr( "aria-controls" );
        var tabTitle = $.trim($( this ).closest('a').clone().children().remove().end().text());
        $('#tab_title').val(tabTitle);
        $('#dialog').find("fieldset").append("<input type='hidden' id='dialog_id' value='"+panelId+"'>");
        dialog.dialog( "open" );
      });
    }

    function updateTab() {
      var label = tabTitle.val().charAt(0).toUpperCase() + tabTitle.val().slice(1) || "Tab " + tabCounter, 
          slug = label.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,''),
          id = $("#dialog_id").val(),
          li = tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ).replace( /#\{id\}/g, id ),
          dataTabsTitle = "#" + id + " li.nav-item",
          panelTitle    = "#" + id + " .nav-link";

      $( dataTabsTitle ).removeAttr('data-tabs-title');
      $( dataTabsTitle ).attr('data-tabs-title', slug);
      $( panelTitle ).remove();
      $("#" + id).find("ul.nav-tabs .nav-item").append(li);      


      $(".sortable, #sortable1, #sortable2").sortable({
        connectWith: ".connectedSortable"
      }).disableSelection();


      $("#"+id).on( "click", "span.ui-icon-pencil", function( event ) {
        // event.preventDefault();
        $('#dialog').find("fieldset #id").remove();
        var panelId  = $( this ).closest('a').attr( "aria-controls" );
        var tabTitle = $.trim($( this ).closest('a').clone().children().remove().end().text());
        $('#tab_title').val(tabTitle);
        $('#dialog').find("fieldset").append("<input type='hidden' id='id' value='"+panelId+"'>");
        dialog2.dialog( "open" );
      });
    }
  }

  /**
   * This Function For Tabs Layout 
   * @return {[type]} [description]
   */
  function tabsFieldsListLayout() {
    var fieldsId = $('#sortable-in .fields-list').map(function() {
      return $(this).data('fieldsid');
    }).get();

    /*Multiple sortable tabs*/
    var id_maps, tabs_title, lists = [];
    var list;
    var multipleTabs = $(".my-tabs").each(function() {
      var tabs_fields = [];
      var id = $(this).attr('id');
      var title = $("#"+id+" li.nav-item").data('tabs-title');
      var count = $("#"+id).data('count');
      var fields = $("#"+id+" #sortable-in .fields-list").each(function() {
        tabs_fields.push($(this).data('fieldsid'));
      });
      if (tabs_fields.length != 0) {
        list = {
          'id' : id,
          'title' : title,
          'count' : count,
          'fields' : tabs_fields,
        };
        lists.push(list);
      }
      console.log(lists);
    });

    var jTable = ConvertFormToJSON();
    var jFields = {
      fieldsId: fieldsId,
      multipleTabs : lists,
    };

    // assets FIELD
    if ($(".entries-template").length) {
      var jData = $('#MyForm').serializeJSON();
      // var url   = '<?php echo base_url("admin/Api/jsonEntriesManage") ?>';
      var url = base_url + "admin/Api/jsonSubmitEntriesForm";
    } else if ($(".users-form").length) {
      var jData = $('#MyForm').serializeJSON();
      // var url   = '<?php echo base_url("admin/Api/jsonUsersFieldsForm") ?>';
      var url = base_url + "admin/Api/jsonSubmitUsersForm";
    } else {
      var jData = Object.assign(jTable, jFields);
      // var url   = '<?php echo base_url("admin/Api/jsonTabsFields") ?>';
      var url = base_url + "admin/Api/jsonSubmitLayoutTabsFields";
    }

    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: jData,
      url: url,
      beforeSend: 
        function(){
          $("#wait").show();
        },
    }).done(function(data) {
      $("#wait").hide();
      if (data.status == true) {
        // window.location.href = '<?php echo base_url() ?>'+data.action;
        window.location.href = base_url + data.action;
      } else {
        $.each(data.errors, function(key, val) {
          $('input[name="' + key + '"]').next().html(val).addClass('form-error');
        });
      }
    }).fail(function(error) {
      $("#wait").hide();
    });

    function ConvertFormToJSON() {
      var array = jQuery($('#MyForm')).serializeArray();
      var json = {};
      jQuery.each(array, function() {
        json[this.name] = this.value || '';
      });
      return json;
    }
  }

  /**
   * This Function Used To Entries Layout to change option entries in form entries template side right
   * @return {[type]} [description]
   */
  function manageEntrieslayout() {
    var parent_table  = $('input[name="parent_table"]').val(), 
        section_id    = $('input[name="section_id"]').val(), 
        table_content = $('input[name="table_content"]').val(), 
        id            = $('input[name="id"]').val(), 
        button        = $('input[name="button"]').val(), 
        action        = $('input[name="action"]').val() 
        element_table = $('input[name="element_table"]').val();

    /**
     * jsonChangeFormByEntryTypes
     * This Function Used TO Changes Form In Entries Layout By Entrytypes Option 
     */
    $('#right-content-entries select[name="entrytypes"]').change(function() {
      var entrytypes_id = $('#right-content-entries select[name="entrytypes"] option:selected').attr('data-id');
      $.ajax({
        // url: '<?php echo base_url('admin/api/jsonSelectEntriesType') ?>',
        url: base_url + "admin/Api/jsonChangeFormByEntryTypes",
        type: 'POST',
        dataType: 'json',
        data: {
          parent_table : parent_table,
          section_id : section_id,
          table_content : table_content,
          id: id,
          button : button,
          action : action,
          element_table : element_table,
          entrytypes_id : entrytypes_id
        },
      })
      .done(function(data) {
        console.log("success");
        $('#entries.entries-form ul#myTab').empty();
        $('#entries.entries-form ul#myTab').html(data.tabs);
        $('#entries.entries-form #myTabContent').empty();
        $('#entries.entries-form #myTabContent').html(data.content);
        modalAssets();
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });
  }

  /**
   * This Function Used To Manage Users Settings Form
   * @return {[type]} [description]
   */
  function manageUsersSettings() {
    if ($('#users [name="generalAccessCP"]').is(':checked') == true) {
      $('#users [name="generalPerformPluginUpdate"]').removeAttr("disabled", "disabled");
      $('#users [name="generalAccessCPOffline"]').removeAttr("disabled", "disabled");
    } else {
      $('#users [name="generalPerformPluginUpdate"]').attr("disabled", "disabled");
      $('#users [name="generalAccessCPOffline"]').attr("disabled", "disabled");
    }

    $('#users [name="generalAccessCP"]').click(function() {
      if ($(this).is(':checked') == true) {
        $('#users [name="generalPerformPluginUpdate"]').removeAttr("disabled", "disabled");
        $('#users [name="generalAccessCPOffline"]').removeAttr("disabled", "disabled");
      } else {
        $('#users [name="generalPerformPluginUpdate"]').attr("disabled", "disabled");
        $('#users [name="generalPerformPluginUpdate"]').attr("checked", false);
        $('#users [name="generalAccessCPOffline"]').attr("disabled", "disabled");
        $('#users [name="generalAccessCPOffline"]').attr("checked", false);
      }
    });

    if ($('#users [name="usersEdit"]').is(':checked') == true) {
      $('#users [name="usersModerate"]').removeAttr("disabled", "disabled");
      $('#users [name="usersAssignEdit"]').removeAttr("disabled", "disabled");
      $('#users [name="usersAssignGroups"]').removeAttr("disabled", "disabled");
      $('#users [name="usersAdministrate"]').removeAttr("disabled", "disabled");
      $('#users [name="usersImpersonate"]').removeAttr("disabled", "disabled");
      $('#users [name*="usersAssigns"]').removeAttr("disabled", "disabled");
    } else {
      $('#users [name="usersModerate"]').attr("disabled", "disabled");
      $('#users [name="usersAssignEdit"]').attr("disabled", "disabled");
      $('#users [name="usersAssignGroups"]').attr("disabled", "disabled");
      $('#users [name="usersAdministrate"]').attr("disabled", "disabled");
      $('#users [name="usersImpersonate"]').attr("disabled", "disabled");
      $('#users [name*="usersAssigns"]').attr("disabled", "disabled");
    }
    
    $('#users [name="usersEdit"]').click(function() {
      if ($(this).is(':checked') == true) {
        $('#users [name="usersModerate"]').removeAttr("disabled", "disabled");
        $('#users [name="usersAssignEdit"]').removeAttr("disabled", "disabled");
        $('#users [name="usersAssignGroups"]').removeAttr("disabled", "disabled");
        $('#users [name="usersAdministrate"]').removeAttr("disabled", "disabled");
        $('#users [name="usersImpersonate"]').removeAttr("disabled", "disabled");
        // $('#users [name*="usersAssigns"]').removeAttr("disabled", "disabled");
      } else {
        $('#users [name="usersModerate"]').attr("disabled", "disabled");
        $('#users [name="usersModerate"]').attr("checked", false);
        $('#users [name="usersAssignEdit"]').attr("disabled", "disabled");
        $('#users [name="usersAssignEdit"]').attr("checked", false);
        $('#users [name="usersAssignGroups"]').attr("disabled", "disabled");
        $('#users [name="usersAssignGroups"]').attr("checked", false);
        $('#users [name="usersAdministrate"]').attr("disabled", "disabled");
        $('#users [name="usersAdministrate"]').attr("checked", false);
        $('#users [name="usersImpersonate"]').attr("disabled", "disabled");
        $('#users [name="usersImpersonate"]').attr("checked", false);
        $('#users [name*="usersAssigns"]').attr("disabled", "disabled");
        $('#users [name*="usersAssigns"]').attr("checked", false);
      }
    });

    $('#users [name="usersAssignGroups"]').click(function() {
      if ($(this).is(':checked') == true) {
        $('#users [name*="usersAssigns"]').removeAttr("disabled", "disabled");
      } else {
        $('#users [name*="usersAssigns"]').attr("disabled", "disabled");
        $('#users [name*="usersAssigns"]').attr("checked", false);
      }
    });


    /**
     * [section description]
     * This function use to checked permissions to users 
     * @type {Array}
     */
    var section = [];
    $('#users [id="section"]').each(function() {
      // section.push($(this).data('handle'));
      var section = $(this).data('handle');
      if ($('#users [name="sectionEdit[' + section + ']"]').is(':checked') == true) {
        $('#users [name="sectionPublishLiveChange[' + section + ']"]').removeAttr("disabled", "disabled");
        $('#users [name="sectionEditOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
      } else {
        $('#users [name="sectionPublishLiveChange[' + section + ']"]').attr("disabled", "disabled");
        $('#users [name="sectionEditOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
        $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
        $('#users [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
      }

      if ($('#users [name="sectionEditOtherAuthors[' + section + ']"]').is(':checked') == true) {
        $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
        $('#users [name="sectionDelete[' + section + ']"]').removeAttr("disabled", "disabled");
      } else {
        $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
        $('#users [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
      }

      // alert(section);
      $('#users [name="sectionEdit[' + section + ']"]').click(function() {
        if ($(this).is(':checked') == true) {
          $('#users [name="sectionPublishLiveChange[' + section + ']"]').removeAttr("disabled", "disabled");
          $('#users [name="sectionEditOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
        } else {
          $('#users [name="sectionPublishLiveChange[' + section + ']"]').attr("disabled", "disabled");
          $('#users [name="sectionPublishLiveChange[' + section + ']"]').attr("checked", false);
          $('#users [name="sectionEditOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
          $('#users [name="sectionEditOtherAuthors[' + section + ']"]').attr("checked", false);
          $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
          $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').attr("checked", false);
          $('#users [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
          $('#users [name="sectionDelete[' + section + ']"]').attr("checked", false);
        }
      });

      $('#users [name="sectionEditOtherAuthors[' + section + ']"]').click(function() {
        if ($(this).is(':checked') == true) {
          $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').removeAttr("disabled", "disabled");
          $('#users [name="sectionDelete[' + section + ']"]').removeAttr("disabled", "disabled");
        } else {
          $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').attr("disabled", "disabled");
          $('#users [name="sectionPublishOtherAuthors[' + section + ']"]').attr("checked", false);
          $('#users [name="sectionDelete[' + section + ']"]').attr("disabled", "disabled");
          $('#users [name="sectionDelete[' + section + ']"]').attr("checked", false);
        }
      });
    });


    /**
     * [assets description]
     * This function use to checked permissions to users 
     * @type {Array}
     */
    var assets = [];
    $('#users [id="assets"]').each(function() {
      // assets.push($(this).data('handle'));
      var assets = $(this).data('handle');
      if ($('#users [name="volumeView[' + assets + ']"]').is(':checked') == true) {
        $('#users [name="volumeUploadFiles[' + assets + ']"]').removeAttr("disabled", "disabled");
        $('#users [name="volumeCreateSubfolder[' + assets + ']"]').removeAttr("disabled", "disabled");
        $('#users [name="volumeRemoveFilesAndFolders[' + assets + ']"]').removeAttr("disabled", "disabled");
        $('#users [name="volumeEditImages[' + assets + ']"]').removeAttr("disabled", "disabled");
      } else {
        $('#users [name="volumeUploadFiles[' + assets + ']"]').attr("disabled", "disabled");
        $('#users [name="volumeCreateSubfolder[' + assets + ']"]').attr("disabled", "disabled");
        $('#users [name="volumeRemoveFilesAndFolders[' + assets + ']"]').attr("disabled", "disabled");
        $('#users [name="volumeEditImages[' + assets + ']"]').attr("disabled", "disabled");
      }

      // alert(assets);
      $('#users [name="volumeView[' + assets + ']"]').click(function() {
        if ($(this).is(':checked') == true) {
          $('#users [name="volumeUploadFiles[' + assets + ']"]').removeAttr("disabled", "disabled");
          $('#users [name="volumeCreateSubfolder[' + assets + ']"]').removeAttr("disabled", "disabled");
          $('#users [name="volumeRemoveFilesAndFolders[' + assets + ']"]').removeAttr("disabled", "disabled");
          $('#users [name="volumeEditImages[' + assets + ']"]').removeAttr("disabled", "disabled");
        } else {
          $('#users [name="volumeUploadFiles[' + assets + ']"]').attr("disabled", "disabled");
          $('#users [name="volumeUploadFiles[' + assets + ']"]').attr("checked", false);
          $('#users [name="volumeCreateSubfolder[' + assets + ']"]').attr("disabled", "disabled");
          $('#users [name="volumeCreateSubfolder[' + assets + ']"]').attr("checked", false);
          $('#users [name="volumeRemoveFilesAndFolders[' + assets + ']"]').attr("disabled", "disabled");
          $('#users [name="volumeRemoveFilesAndFolders[' + assets + ']"]').attr("checked", false);
          $('#users [name="volumeEditImages[' + assets + ']"]').attr("disabled", "disabled");
          $('#users [name="volumeEditImages[' + assets + ']"]').attr("checked", false);
        }
      });
    });

    /*Users Settings List*/
    $('#users.users-list [name="allowRegistration"]').click(function() {
      if ($(this).is(':checked') == true) {
        $('#users.users-list .default-group').removeClass('d-none');
      } else {
        $('#users.users-list .default-group').addClass('d-none');
      }
    });
  }



  /**
   * Fields Forms 
   * @param  {[type]} $('input[name [description]
   * @return {[type]}               [description]
   */
  function manageFields(){
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

    /*Field Type Change Function*/
    $('select[name=fields-group]').change(function() {
      var field_group = $('select[name=fields-group]').val();
      $('select[name=fields-group] option:selected').each(function() {
        var field_id = $('select[name=fields-group] option:selected').attr('data-id');
        $('input[name=fieldsgroupId]').val(field_id);
      });
    });

    $('select[name=fields-type]').change(function() {
      var field_type = $('select[name=fields-type]').val();
      $('.fields').addClass('d-none');
      $('select[name=fields-type] option:selected').each(function() {
        var field_id = $('select[name=fields-type] option:selected').attr('data-id');
        $('input[name=fieldstypeId]').val(field_id);
        $('#' + field_type).removeClass('d-none');
      });
    });

    $('input[name="assetsSourcesAll"]').click(function() {
      if ($(this).prop('checked') == true) {
        $('input[name="assetsSources"]').attr('disabled', 'disabled');
        $('input[name="assetsSources"]').prop("checked", true);
        // $('input[name="assetsSources"]').attr('checked', true);
      } else {
        $('input[name="assetsSources"]').prop("checked", false);
        $('input[name="assetsSources"]').removeAttr('disabled', 'disabled');
        // $('input[name="assetsSources"]').attr('checked', false);
      }
    });

  }

  /**
   * Manage Section Forms
   */
  function manageSection() {
    $('#section .section-form [name="section-type"]').change(function() {
      if ($(this).val() == '5') {
        $('#site-settings .status').addClass('d-none');
      } else {
        $('#site-settings .status').removeClass('d-none');
      }
    });
  }

  /**
   * Manage Sites Form
   */
  function manageSites() {
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
  }

  /**
   * Manage Navbar 
   */
  function manageNavbar() {
    /*Navbar Collapse*/
    $('[data-target="#sidebar"]').on('click', function() {
      $('#sidebarCollapse').toggleClass('active');
      $('#contentCollapse').toggleClass('active');
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
        tabsFieldsListLayout();
      } else {
        $('#MyForm').submit();
      }
    });
  }

