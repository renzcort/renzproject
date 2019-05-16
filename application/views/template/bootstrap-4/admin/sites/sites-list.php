  <div id="left-content" class="left-content">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="sidebarGroups" 
        data-groups-name="<?php echo ($group_name ? $group_name : ''); ?>" data-table="<?php echo ($table ? $table : ''); ?>" 
        data-element="<?php echo ($element_name ? $element_name : ''); ?>">
        <li class="nav-item">
          <a class="nav-link active" data-id="all">All Fields</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-id="default">Default</a>
        </li>
        <?php if ($group): ?>
          <?php foreach ($group as $key): ?>
            <li class="nav-item">
              <a class="nav-link" data-id="<?php echo $key->id; ?>"><?php echo ucfirst($key->name); ?></a>
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
              <a class="dropdown-item" id="groupsRename">Rename Selected Group</a>
              <a class="dropdown-item" id="groupsDelete">Delete Selected Group</a>
            </div>
          </div>
        <?php } ?>
      </div>
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
          <th scope="col">Languange</th>
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
          <td><?php echo $key->locale; ?></td>
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