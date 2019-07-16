


<div class="sidebar d-flex flex-column flex-wrap justify-content-center">
  <div class="users-bar mx-3 d-flex flex-row flex-wrap justify-content-start align-items-center">
    <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image" class="rounded-circle">
    <div class="users-info pl-2">
      <p><?php echo (isset($session['userdata']['username']) ? $session['userdata']['username'] : ''); ?></p>
      <p class="online">Online</p>
    </div>
  </div>
  <div class="menu-bar">
    <ul class="nav d-flex flex-column justify-content-start align-content-start align-items-start">
      <li class="nav-item header">Main Dashboard</li>
      <li class="nav-item">
        <a class="nav-link active" href="#">
          <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
        </a>
      </li>

        <?php
          if ($session['sidebar_activated']['section'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link" href="'.base_url('admin/entries').'">
                <i class="fas fa-cogs"></i><span>Entries</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['globals'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link" href="'.base_url('admin/globals').'">
                <i class="fas fa-cogs"></i><span>Globals</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['categories'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link" href="'.base_url('admin/categories').'">
                <i class="fas fa-cogs"></i><span>Categories</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['assets'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link" href="'.base_url('admin/assets').'">
                <i class="fas fa-cogs"></i><span>Assets</span>
              </a>
            </li>';
          }
          if ($session['sidebar_activated']['usersgroup'] != 0) {
            echo '
            <li class="nav-item">
              <a class="nav-link" href="'.base_url('admin/users').'">
                <i class="fas fa-cogs"></i><span>Users</span>
              </a>
            </li>';
          }
        ?>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fab fa-elementor"></i><span>Entries</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-globe"></i><span>Globals</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="far fa-folder-open"></i><span>Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-images"></i><span>Assets</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-wrench"></i><span>Utilites</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('admin/settings') ?>">
          <i class="fas fa-cogs"></i><span>Settings</span>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-plug"></i><span>Plugins Store</span>
        </a>
      </li> -->
    </ul>
  </div>
</div>