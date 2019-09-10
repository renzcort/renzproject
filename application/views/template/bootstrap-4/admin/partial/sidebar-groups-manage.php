<div class="sidebar-content">
  <div class="sidebar-groups-list">
    <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="sidebar-groups" 
      data-table="<?php echo ($table ? $table : ''); ?>" 
      data-action="<?php echo ($action ? $action : '');?>"
      data-table-group="<?php echo ($group_name ? $group_name : ''); ?>"
      <?php echo (empty($element_name) ? '' : 'data-element= "'.$element_name.'"')?>>       
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
  </div>
  <div class="d-flex flex-row flex-wrap justify-content-start sidebar-button">
    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#groupsModal">+ New Group</button>
    <?php if ($group_count >= 1) { ?>
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-cog"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" id="groups-rename">Rename Group Selected</a>
          <a class="dropdown-item" id="groups-delete">Delete Group Selected</a>
        </div>
      </div>
    <?php } ?>
  </div>
</div>