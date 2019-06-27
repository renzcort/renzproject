<div class="middle-content flex-grow-1">
  <?php if ($record_all): ?>
  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody> 
    <?php foreach ($record_all as $key): ?>
      <tr>
        <td scope="row"><?php echo ++$no; ?></td>
        <td><a href="<?php echo base_url($action.'/edit/'.$key->id); ?>"><?php echo $key->name; ?></a></td>
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