<?php if ($this->session->userdata('message')) { ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-ban"></i> Well done!</h4>
  <?php echo $this->session->userdata('message'); ?>
</div>
<?php } ?>

<div class="list" id="index">
  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage <?php echo (isset($title) ? ucfirst($title) : ''); ?></h3>
        </div>
        <div class="box-body">
          <?php if($record_all) { ?>
          <table class="table table-bordered table-striped text-center">
            <thead>
              <th width="5%">No. </th>
              <th width="5%"></th>
              <th>Name</th>
              <th>Action</th>
            </thead>
            <tbody>
              <?php
                $i = 0; 
                foreach ($record_all as $key) { 
              ?>
                <td><?php echo ++$i; ?></td>
                <td><input type="checkbox" name="checklist"></td>
                <td><?php echo $key->name; ?></td>
                <td colspan="2">
                  <a href="<?php echo base_url('admin/users/role/edit/'.$key->id) ?>">Edit |</a>
                  <a href="<?php echo base_url('admin/users/role/delete/'.$key->id) ?>">Delete</a>
                </td>
              <?PHP } ?>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </table>
          <?php } else { ?>
            <h3>Data is Empty</h3>
          <?php } ?>
        </div>
      </div>
      <table>
        <thead>
                    
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
</div>