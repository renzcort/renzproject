<?php if ($record_all): ?>
<table class="table table-sm">
  <thead>
    <tr>
      <th scope="row">#</th>
      <th scope="col">Name</th>
      <th scope="col">Handle</th>
      <th scope="col">Type</th>
      <th scope="row"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($record_all as $key): ?>
      <tr>
        <td scope="row"><?php echo ++$no; ?></td>
        <td><a href="<?php echo base_url($action.'/edit/'.$key->id); ?>"><?php echo ucfirst($key->name); ?></a></td>
        <td><?php echo $key->handle; ?></td>
        <td><?php echo $key->type; ?></td>
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