  <div id="left-content" class="left-content">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="assetsButton"
      data-table="<?php echo ($table ? $table : ''); ?>">
        <li class="nav-item">
          <a href="<?php echo base_url($action); ?>" class="nav-link active" data-id="volumes">Volumes</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url($action.'/transforms'); ?>" class="nav-link" data-id="transforms">Images Transforms</a>
        </li>
      </ul>
    </div>
  </div>
  <div id="right-content" class="right-content ml-auto">
    <?php $this->load->view($right_content); ?>
  </div>