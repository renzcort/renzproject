<div class="middle-content flex-grow-1">
  <?php if ($record_all): ?>
  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Handle</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($record_all as $key): ?>
      <tr>
        <th scope="row">1</th>
        <td><a href="<?php echo base_url($action.'/edit/'.$key->id); ?>"><?php echo $key->name; ?></a></td>
        <td><?php echo $key->handle; ?></td>
        <td scope="row" colspan="2">
          <a href=""><i class="fas fa-arrows-alt"></i></a>
          <a href="<?php echo base_url($action.'/delete/'.$key->id); ?>"><i class="fas fa-minus-circle"></i></a>
        </td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <?php endif ?>
</div>