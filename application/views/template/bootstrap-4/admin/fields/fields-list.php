  <div id="left-content" class="left-content">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
        <li class="nav-item">
          <a class="nav-link active" href="#">All Fields</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Default</a>
        </li>
        <?php foreach ($fields_group as $key): ?>
          <li class="nav-item">
            <a class="nav-link" href="#" data-id="<?php echo $key->id; ?>"><?php echo ucfirst($key->name); ?></a>
          </li>
        <?php endforeach ?>
      </ul>
      <div class="btn-new text-center d-flex flex-row flex-wrap justify-content-start">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#groupsModal">+ New Group</button>
        <?php if ($fields_group_count >= 1) { ?>
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-cog"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#" id="groupsRename">Rename Selected Group</a>
              <a class="dropdown-item" href="#" id="groupsDelete">Delete Selected Group</a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div id="right-content" class="right-content ml-auto">
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Handle</th>
          <th scope="col">Type</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($record_all as $key): ?>
        <tr>
          <th scope="row"><?php echo ++$no; ?></th>
          <td><?php echo ($key->name ? $key->name : ''); ?></td>
          <td><?php echo ($key->handle ? $key->handle : ''); ?></td>
          <td><?php echo ($key->type_name ? $key->type_name : ''); ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>