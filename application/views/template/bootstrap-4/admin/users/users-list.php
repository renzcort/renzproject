<div class="content-body d-flex flex-row flex-grow-1 justify-content-start users-list" id="users">
  <div id="left-content">
    <?php $this->load->view('template/bootstrap-4/admin/partial/sidebar-groups'); ?>
  </div>
  <div id="right-content">
    <div class="right-content-body">
      <?php $this->load->view('template/bootstrap-4/admin/partial/right-content-filter'); ?>
      <?php if ($record_all): ?>
      <div class="right-content-table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl" id="content-table">
        <table class="table table-sm">
          <thead>
            <tr>
              <th style="width:5%" scope="row">#</th>
              <th scope="col">Users</th>
              <th scope="col">Fullname</th>
              <th scope="col">Email</th>
              <th scope="col">Date Created</th>
              <th scope="col">Last Login</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($record_all as $key) :?>
            <tr>
              <th style="width:5%" scope="row"><?php echo ++$no; ?></th>
              <td><a href="<?php echo base_url($action."/edit/".$key->id); ?>"><?php echo $key->username; ?></a></td>
              <td><?php echo $key->firstname.' '.$key->lastname; ?></td>
              <td><?php echo $key->email; ?></td>
              <td><?php echo ($key->created_at ? date("d/m/Y", strtotime($key->created_at)): ''); ?></td>
              <td><?php echo ($key->last_login ? date("d/m/Y h:i A", strtotime($key->last_login)) : 'Not Yet'); ?></td>
              <td><a href="<?php echo base_url($action."/delete/".$key->id); ?>" data-id="<?php echo $key->id; ?>">
              <i class="fas fa-minus-circle"></i></a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
        </table>
      </div>
      <?php else: ?>
      <p class="empty-data">Data is Empty</p>
      <?php endif ?>
    </div>
  </div>
</div>