<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/template/bootstrap-4/') ?>css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <title>Hello, world!</title>
    <style type="text/css">
    </style>
  </head>
  <body>
    <?php $this->load->view('template/bootstrap-4/partial/nav'); ?>
    <div class="wraper">
      <div class="">
        <div class="body d-flex flex-row justify-content-between align-content-start align-items-start">
          <div class="left-bar">
            <?php $this->load->view('template/bootstrap-4/partial/sidebar'); ?>
          </div>
          <div class="right-bar ml-auto mt-4 mb-3 pl-0 pt-4">
            <div class="main container">
              <?php $this->load->view('template/bootstrap-4/partial/header'); ?>
              <div class="content">
                <div class="d-flex flex-row justify-content-start">
                  <?php $this->load->view($content); ?>
                </div>
              </div>
              <div class="footer p-3 my-5 pt-5 text-muted text-center text-small">
                <?php $this->load->view('template/bootstrap-4/partial/footer'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Group Field</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label class="heading" for="inputNameGroup">What do you want to name the group?</label>
            <input type="text" name="name-group" class="form-control form-control-sm">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- end Jquery -->
<script type="text/javascript">
  $(document).ready(function(){
    $('select[name=field-type]').change(function(){
      var field_type = $('select[name=field-type]').val();
      $('.fields').addClass('d-none');
      $('select[name=field-type] option:selected').each(function(){
        $('#'+field_type).removeClass('d-none');
      });
    });

    $('#customSwitch1:checked').click(function() {
      alert();
      var enabled = $('custom-control-input:selected').val();
      if (enabled == 'on') {
        $('.base-url').removeClass('d-none');
      } else {
        $('.base-url').addClass('d-none');
      }
    });


    $('.new-tabs button').click(function(){
      $('.field-tabs').append('<div class="field-group"> <ul class="nav nav-tabs" id="myTab" role="tablist"> <li class="nav-item"> <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a> </li> </ul> <div class="tab-content" id="myTabContent"> <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"> <ul id="sortable1" class="text-center list-group connectedSortable"> <li class="list-group-item active">Lion</li> <li class="list-group-item">Dog</li> <li class="list-group-item">Cat</li> <li class="list-group-item">Tiger</li> </ul> </div> </div> </div>'); });

    $("#sortable1, #sortable2").sortable({
      connectWith: ".connectedSortable"
    });
  })

  window.onscroll = function() {myFunction()};
  var leftbar = document.getElementById('left-content');
  var leftbarTop = leftbar.offsetTop;
  var leftbarButton = leftbar.offsetHeight;
  var rightbar = document.getElementById('right-content');
  var rightbarTop = rightbar.offsetHeight;
  
  function myFunction() {
    if (window.pageYOffset >= leftbarTop && window.pageYOffset <= leftbarButton) {
      leftbar.classList.add("fixed-bar")
    } else {
      leftbar.classList.remove("fixed-bar");
    }
  }
</script>
</body>
</html>