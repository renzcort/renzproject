<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><?php echo (isset($title) ? ucfirst($title) : ''); ?></a></li>
    <?php if (isset($subtitle)): ?>
      <?php foreach ($subtitle as $key): ?>
      <li class="breadcrumb-item <?php echo ((end($subtitle) == $key) ? 'active' : ''); ?>" aria-current="page">
        <?php echo ((end($subtitle) == $key) ? ucfirst($key) : '<a href="">'.ucfirst($key).'</a>');?>
      </li>  
      <?php endforeach ?>
    <?php endif ?>
  </ol>
</nav>
<div class="d-flex flex-row flex-wrap justify-content-between align-items-center">
  <h4 class="title"><?php echo (isset($title) ? $title : '') ;?></h4>
  <button class="btn btn-danger btn-sm mx-3"><?php echo (isset($button) ? $button : '') ;?></button>
</div>
