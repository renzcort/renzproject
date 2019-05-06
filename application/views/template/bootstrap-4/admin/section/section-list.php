<div class="middle-content flex-grow-1">
  <?php if ($record_all): ?>
  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Handle</th>
        <th scope="col">Type</th>
        <th scope="col">Entry Types</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody> 
    <?php foreach ($record_all as $key): ?>
      <tr>
        <td scope="row"><?php echo ++$no; ?></td>
        <td><a href="<?php echo base_url($action.'/edit/'.$key->id); ?>"><?php echo $key->name; ?></a></td>
        <td><?php echo $key->handle; ?></td>
        <td><?php echo $key->type_name; ?></td>
        <td class="dropdown">
            <a href="<?php echo base_url($action.'/'.$key->id.'/entrytypes'); ?>" class="mr-2">Dropdown link <span class="badge badge-info">4</span></a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
              <span class="sr-only">Toggle Dropdown</span>
            </button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </td>
        <td scope="row">
          <a href="<?php echo base_url($action.'/delete/'.$key->id); ?>"><i class="fas fa-minus-circle"></i></a>
        </td>
      </tr>
     <?php endforeach ?>       
    </tbody>
  </table>
  <?php else: ?>
  <?php endif ?>

</div>