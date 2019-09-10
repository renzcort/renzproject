<div class="middle-content flex-grow-1 fields-type-list" id="fields">
  <?php if ($record_all): ?>
  <table class="table table-sm">
    <thead>
      <tr>
        <th width="5%">No. </th>
        <th>Name</th>
        <th>Handle</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($record_all as $key): ?>
    <tr>
      <td><?php echo ++$no; ?></td>
      <td><?php echo ucfirst($key->name); ?></td>
      <td><?php echo $key->handle; ?></td>
      <td><?php echo $key->type; ?></td>
      <td colspan="2">
        <a href="<?php echo base_url("{$action}/edit/{$key->id}") ?>">Edit |</a>
        <a href="<?php echo base_url("{$action}/delete/{$key->id}") ?>">Delete</a>
      </td>
      <tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <?php else: ?>
  <p class="empty-data">Data is Empty</p>
  <?php endif ?>
</div>