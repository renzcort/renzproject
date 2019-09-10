<div class="content-body d-flex flex-row flex-grow-1 justify-content-start sites-list" id="sites">
  <div id="left-content">
    <?php $this->load->view('template/bootstrap-4/admin/partial/sidebar-groups-manage'); ?>
  </div>
  <div id="right-content">
    <?php if ($record_all): ?>
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="row">#</th>
          <th scope="col">Name</th>
          <th scope="col">Handle</th>
          <th scope="col">Language</th>
          <th scope="col">Primary</th>
          <th scope="col">Base URL</th>
          <th scope="row"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($record_all as $key): ?>
        <tr>
          <td scope="row"><?php echo ++$no; ?></td>
          <td><a href="<?php echo base_url($action.'/edit/'.$key->id); ?>"><?php echo $key->name; ?></a></td>
          <td><?php echo $key->handle; ?></td>
          <td><?php echo $key->language; ?></td>
          <td><?php echo (!empty($key->primary) ? 'Yes' : 'No');?></td>
          <td><?php echo (!empty($key->url) ? $key->url : ''); ?></td>
          <td scope="row">
            <a href="<?php echo base_url($action.'/delete/'.$key->id); ?>"><i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <?php else: ?>
    <p class="empty-data">Data is Empty</p>
    <?php endif ?>
  </div>
</div>