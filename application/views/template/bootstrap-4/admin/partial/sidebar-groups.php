<div class="sidebar-content">
  <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" 
    data-table="<?php echo ($table ? $table : ''); ?>" 
    data-action="<?php echo ($action ? $action : '');?>"
    <?php echo (empty($group_name) ? '' : 'data-table-group-"'.$group_name.'"');?>
    <?php echo (empty($element_name) ? '' : 'data-element = "'.$element_name.'"')?>       
    <?php echo (empty($content_name) ? '' : 'data-content-"'.$content_name.'"');?>>
    
    <?php if (in_array($table, array('usersgroup', 'users_settings'))) { ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(4) == 'groups') ? 'active' : '') ?>" 
          data-id="usersgroups" 
          href="groups">Users Groups
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(4) == 'fields') ? 'active' : '') ?>" 
          data-id="fields" 
          href="fields">Fields
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(4) == 'settings') ? 'active' : '') ?>" 
          data-id="settings" 
          href="settings">Settings
        </a>
      </li>
    <?php } elseif (in_array($table, array('assets', 'assets_transforms'))) { ?>
      <li class="nav-item">
        <a href="volumes" class="nav-link <?php echo (($this->uri->segment(4) == 'volumes') ? 'active' : '')?>" data-id="volumes">Volumes</a>
      </li>
      <li class="nav-item">
        <a href="transforms" class="nav-link <?php echo (($this->uri->segment(4) == 'transforms') ? 'active' : '')?>" data-id="transforms">Images Transforms</a>
      </li>
    <?php } elseif ($table == 'content') { ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(3) == 'all') ? 'active' : '') ?>" data-id="all" href="all">All Fields</a>
      </li> 
      <?php 
        if ($section) {
          echo '
            <li class="nav-item disabled">SITE PAGES</li>
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(3) == 'singles') ? 'active' : '').'" data-id="singles" href="singles">Singles</a>
            </li>';
          echo '<li class="nav-item disabled">CHANNEL</li>';
          foreach ($section as $key) {
            if ($key->type_id == 6) {
              echo '
                <li class="nav-item">
                  <a class="nav-link '.(($this->uri->segment(3) == $key->handle) ? 'active' : '').'" 
                  href="'.$key->handle.'" 
                  data-id="'.$key->id.'">
                  '.ucfirst($key->name).'</a>
                </li>';
            }
          } 
        } 
      ?> 
     <?php } else  { ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(3) == 'all') ? 'active' : '') ?>" 
          data-id="all" href="all">All <?php echo ucfirst($group_name); ?></a>
        <?php if ($table == 'assets_content' ) { ?>
          <a class="nav-link <?php echo (($this->uri->segment(3) == 'default') ? 'active' : '') ?>" 
            data-id="default" href="default">Default</a>
        <?php } ?>
      </li>
     <?php 
      if ($group) {
        foreach ($group as $key) {
          echo '
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(3) == $key->handle) ? 'active' : '').'" 
              href="'.$key->handle.'" data-id="'.$key->id.'">'.ucfirst($key->name).'</a>
            </li>';
        } 
       }
      ?>
    <?php } ?>
  </ul>
</div>
