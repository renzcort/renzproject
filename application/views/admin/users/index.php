<?php if ($this->session->userdata('message')) { ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-ban"></i> Well done!</h4>
  <?php echo $this->session->userdata('message'); ?>
</div>
<?php } ?>

<div class="content list" id="index">
  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage <?php echo (isset($title) ? ucfirst($title) : ucfirst($header)); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="pull-left">
            <a href="<?php echo base_url($action.'/create'); ?>" class="btn btn-block btn-primary">+ Add <?php echo (isset($title) ? ucfirst($title) : ucfirst($header)); ?></a>
          </div>
          <?php if($record_all) { ?>
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="5%">No. </th>
                <th width="5%"></th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $i = 0;
                foreach ($record_all as $key) {
              ?>
              <tr>
                <td><?php echo ++$i; ?></td>
                <td><input type="checkbox" name="checklist"></td>
                <td><?php echo $key->username; ?></td>
                <td><?php echo $key->email; ?></td>
                <td><?php echo $key->role_id; ?></td>
                <td colspan="2">
                  <a href="<?php echo base_url($action.'/edit/'.$key->id) ?>">Edit |</a>
                  <a href="<?php echo base_url($action.'/delete/'.$key->id) ?>">Delete</a>
                </td>
              <tr>
              <?PHP } ?>
            </tbody>
            <tfoot>
            <tr>
              <th width="5%">No. </th>
              <th width="5%"></th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
            </tfoot>
          </table>
          <div class="row">
            <div class="col-lg-12">
              <?php echo $links; ?>
            </div>
          </div>
          <?php } else { ?>
          <div class="m-5">
            <h3 class="text-center">Data is Empty</h3>
          </div>
          <?php } ?>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</div>