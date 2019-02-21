<div class="list" id="index">
  <div class="row">
    <div class="col-sm-12 col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Manage <?php echo (isset($title) ? ucfirst($title) : ''); ?></h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <thead>
              <th>No. </th>
              <th></th>
              <th>Name</th>
              <th>Action</th>
            </thead>
            <tbody>
              <?php foreach ($record_all as $key) { ?>
                <td></td>
                <td><input type="checkbox" name="checklist"></td>
                <td><?php echo $key->name; ?></td>
                <td colspan="2">
                  <a href="<?php echo base_url('admin/users/role/update/'.$key->id) ?>">Edit</a>
                  <a href="<?php echo base_url('admin/users/role/delete/'.$key->id) ?>">Edit</a>
                </td>
              <?PHP } ?>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </table>
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