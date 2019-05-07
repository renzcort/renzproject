<div class="middle-content flex-grow-1">
  <?php if ($record_all): ?>
  <table class="table table-sm" id="section-entries-list">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Handle</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $i = 0; 
        foreach ($record_all as $key): 
      ?>
      <tr data-id="<?php echo $key->id; ?>" id="<?php echo ++$i; ?>">
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

      <h3><span id = "sortable-9"></span></h3>
  <?php endif ?>
</div>