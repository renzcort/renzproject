<?php if ($this->session->userdata('message')) { ?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-ban"></i> Well done!</h4>
  <?php echo $this->session->userdata('message'); ?>
</div>
<?php } ?>

<div class="content list" id="index">
  <div class="row">
    <div class="col-sm-3 col-xs-3">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage <?php echo (isset($title) ? ucfirst($title) : ucfirst($header)); ?></h3>
        </div>
        <div class="box-body">
          <ul class="group list">
            <li><a href="<?php echo base_url("{$action}"); ?>">All Fields</a></li>
            <?php foreach ($group as $key) { ?>
              <li><a href="<?php echo base_url("{$action}/?group_id={$key->id}"); ?>"><?php echo $key->name; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      
    </div>
    <div class="col-sm-9 col-xs-9">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage <?php echo (isset($title) ? ucfirst($title) : ucfirst($header)); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="pull-left">
            <a href="<?php echo base_url("{$action}/create/?group_id={$group_id}"); ?>" class="btn btn-block btn-primary">+ Add <?php echo (isset($title) ? ucfirst($title) : ucfirst($header)); ?></a>
          </div>
          <?php if($record_all) { ?>
          <table id="example2" class="table table-bordered table-hover text-center">
            <thead>
              <tr>
                <th width="5%">No. </th>
                <th width="5%"><input type="checkbox" name="checkall"></th>
                <th>Name</th>
                <th>Handle</th>
                <th>Type</th>
                <th>Group</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach ($record_all as $key) {
              ?>
              <tr>
                <td><?php echo ++$no; ?></td>
                <td><input type="checkbox" name="checklist[]"></td>
                <td><?php echo $key->name; ?></td>
                <td><?php echo $key->handle; ?></td>
                <td><?php echo $key->type_name; ?></td>
                <td><?php echo $key->group_name; ?></td>
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
                <th>Name</th>
                <th>Handle</th>
                <th>Type</th>
                <th>Group</th>
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
