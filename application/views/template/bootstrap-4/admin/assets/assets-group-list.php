  <div id="left-content" class="left-content">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="assetsButton">
        <li class="nav-item">
          <a class="nav-link active" data-id="volumes">Volumes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-id="transforms">Images Transforms</a>
        </li>
      </ul>
    </div>
  </div>
  <div id="right-content" class="right-content ml-auto">
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
  </div>