  <div id="left-content" class="left-content">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="sidebarGroups" data-groups-name="<?php echo ($group_name ? $group_name : ''); ?>" data-table="<?php echo ($table ? $table : ''); ?>">
        <li class="nav-item">
          <a class="nav-link active" href="#" data-id="all">All Fields</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-id="default">Default</a>
        </li>
        <?php if ($group): ?>
          <?php foreach ($group as $key): ?>
            <li class="nav-item">
              <a class="nav-link" href="#" data-id="<?php echo $key->id; ?>"><?php echo ucfirst($key->name); ?></a>
            </li>
          <?php endforeach ?>
        <?php endif ?>
      </ul>
      <div class="btn-new text-center d-flex flex-row flex-wrap justify-content-start">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#groupsModal">+ New Group</button>
        <?php if ($group_count >= 1) { ?>
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
          <th scope="row">#</th>
          <th scope="col">Name</th>
          <th scope="col">Handle</th>
          <th scope="col">Type</th>
          <th scope="row"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>
            <a href=""><i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>
            <a href=""><i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
          <td>
            <a href=""><i class="fas fa-minus-circle"></i></a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>