  <div id="left-content" class="left-content" id="assets-group-list">
    <div class="sidebar-content">
      <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start" id="assetsButton"
      data-table="<?php echo ($table ? $table : ''); ?>">
        <li class="nav-item">
          <a href="volumes" class="nav-link <?php echo (($this->uri->segment(4) == 'volumes') ? 'active' : '')?>" data-id="volumes">Volumes</a>
        </li>
        <li class="nav-item">
          <a href="transforms" class="nav-link <?php echo (($this->uri->segment(4) == 'transforms') ? 'active' : '')?>" data-id="transforms">Images Transforms</a>
        </li>
      </ul>
    </div>
  </div>
  <div id="right-content" class="right-content ml-auto">
    <?php $this->load->view($right_content); ?>
  </div>