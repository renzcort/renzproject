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
        <div class="box-header"></div>
        <div class="box-body">
          <?php if ($entries) { ?>
          <ul class="entries-list">
            <li><a href="<?php echo base_url("{$action}"); ?>">All Entries</a></li>
          <?php foreach ($entries as $key) {?>
            <li><a href="<?php echo base_url("{$action}/?entries_id={$key->id}"); ?>"><?php echo $key->name; ?></a></li>
          <?php } ?>
          </ul>
          <?php } else { ?>
            <div class="m-5">
              <h3 class="text-center">Data is Empty</h3>
            </div>
          <?php } ?>
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
            <a href="<?php echo base_url("{$action}/create/?entries_id={$entries_id}"); ?>" class="btn btn-block btn-primary">+ Add <?php echo (isset($title) ? ucfirst($title) : ucfirst($header)); ?></a>
          </div>
          <?php if($record_all) { ?>
          <table id="example2" class="table table-bordered table-hover text-center">
            <thead>
              <tr>
                <th width="5%">No. </th>
                <th width="5%"><input type="checkbox" name="checkall"></th>
                <th>Title</th>
                <th>Post Date</th>
                <th>Expiry Date</th>
                <th>Author</th>
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
                <td><?php echo $key->title; ?></td>
                <td><?php echo $key->updated_at; ?></td>
                <td><?php echo $key->updated_at; ?></td>
                <td><?php echo (!empty($key->updated_by) ? $key->updated_by : $key->created_by ); ?></td>
                <td colspan="2">
                  <a href="<?php echo base_url("{$action}/edit/{$key->id}/?entries_id={$key->entries_id}"); ?>">Edit |</a>
                  <a href="<?php echo base_url("{$action}/delete/{$key->id}/?entries_id={$key->entries_id}"); ?>">Delete</a>
                </td>
              <tr>
              <?PHP } ?>
            </tbody>
            <tfoot>
            <tr>
              <th width="5%">No. </th>
              <th width="5%"></th>
                <th>Title</th>
                <th>Post Date</th>
                <th>Expiry Date</th>
                <th>Author</th>
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
