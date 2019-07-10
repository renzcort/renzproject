<div id="left-content" class="left-content overflow-auto">
  <div class="sidebar-content">
    <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start"
      data-table="<?php echo ($table ? $table : ''); ?>"
      data-action-name="<?php echo ($action ? $action : '');?>"
      data-content-name="<?php echo ($content_name ? $content_name : ''); ?>">
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(3) == 'all') ? 'active' : '') ?>" data-id="all" href="all">All Assets</a>
        <a class="nav-link <?php echo (($this->uri->segment(3) == 'default') ? 'active' : '') ?>" data-id="default" href="default">Default</a>
      </li>
      <?php
      echo '<li class="nav-item">
        <a class="nav-link '.(($this->uri->segment(3) == $key->handle) ? 'active' : '').'"
          href="'.$key->handle.'"
          data-id="'.$key->id.'">
        '.ucfirst($key->name).'</a>
      </li>';
      ?>
    </ul>
  </div>
</div>
<div id="right-content" class="right-content ml-auto">
  
</div>