<div id="left-content" class="left-content overflow-auto">
  <div class="sidebar-content">
    <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start"
      data-table="<?php echo ($table ? $table : ''); ?>"
      data-action-name="<?php echo ($action ? $action : '');?>">
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
    </ul>
  </div>
</div>
<div id="right-content" class="right-content ml-auto">
    <?php $this->load->view($right_content); ?>
</div>