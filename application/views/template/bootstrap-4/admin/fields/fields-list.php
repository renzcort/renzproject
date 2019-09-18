<div class="content-body d-flex flex-row flex-grow-1 justify-content-start fields-list" id="fields">
  <div id="left-content" class="d-none d-lg-block d-xl-block">
    <?php $this->load->view('template/bootstrap-4/admin/partial/sidebar-groups-manage'); ?>
  </div>
  <div id="right-content" class="table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
    <?php if ($record_all) { ?>
    <table class="table table-sm text-left">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Handle</th>
          <th scope="col">Type</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($record_all as $key): ?>
        <tr>
          <td scope="row"><?php echo ++$no; ?></td>
          <td><a href="<?php echo base_url($action."/edit/".$key->id); ?>"><?php echo ucfirst($key->name); ?></a></td>
          <td><?php echo ($key->handle ? $key->handle : ''); ?></td>
          <td><?php echo ($key->type_name ? $key->type_name : ''); ?></td>
          <td><a href="<?php echo base_url($action."/delete/".$key->id); ?>" data-id="<?php echo $key->id; ?>">
            <i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
      <?php } else { ?>
      <p class="empty-data">Data is Empty</p>
    <?php } ?>
  </div>
</div>
