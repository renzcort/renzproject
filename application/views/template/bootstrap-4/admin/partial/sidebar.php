<div class="d-flex flex-column flex-wrap justify-content-center align-items-stretch">
  <div class="d-flex flex-wrap justify-content-start align-items-center" id="users-bar">
    <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
    <div class="users-info">
      <p><?php echo (isset($session['userdata']['username']) ? $session['userdata']['username'] : ''); ?></p>
      <p class="online">Online</p>
    </div>
  </div>
  <div class="d-flex flex-column justify-content-start align-items-start" id="sidebar-menu">
    <ul class="nav">
      <li class="nav-item header">Main Dashboard</li>
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(2) == 'home') ? 'active' : '') ?>" href="<?php echo base_url('admin/home') ?>">
          <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
        </a>
      </li>

        <?php
          if ($session['sidebar_activated']['section'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(2) == 'entries') ? 'active' : '').'" href="'.base_url('admin/entries').'">
                <i class="fas fa-cogs"></i><span>Entries</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['globals'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(2) == 'globals') ? 'active' : '').'" href="'.base_url('admin/globals').'">
                <i class="fas fa-cogs"></i><span>Globals</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['categories'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(2) == 'categories') ? 'active' : '').'" href="'.base_url('admin/categories').'">
                <i class="fas fa-cogs"></i><span>Categories</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['assets'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(2) == 'assets') ? 'active' : '').'" href="'.base_url('admin/assets').'">
                <i class="fas fa-cogs"></i><span>Assets</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['usersgroup'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link '.(($this->uri->segment(2) == 'users') ? 'active' : '').'" href="'.base_url('admin/users').'">
                <i class="fas fa-cogs"></i><span>Users</span>
              </a>
            </li>';
          }
        ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (($this->uri->segment(2) == 'settings') ? 'active' : '') ?>" href="<?php echo base_url('admin/settings') ?>">
          <i class="fas fa-cogs"></i><span>Settings</span>
        </a>
      </li>
    </ul>
  </div>
</div>