<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php if ($title != 'Home'): ?>
      <?php if ($subtitle): ?>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/home'); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href=""><?php echo ($title ? ucfirst($title) : ''); ?></a></li>
        <?php foreach ($subtitle as $key): ?>
        <li class="breadcrumb-item <?php echo ((end($subtitle) == $key) ? 'active aria-current="page"' : ''); ?>">
          <?php echo ((end($subtitle) == $key) ? ucfirst($key) : '<a href="">'.ucfirst($key).'</a>');?>
        </li>  
        <?php endforeach ?>
      <?php else:?>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/home'); ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo ($title ? ucfirst($title) : ''); ?></li>
      <?php endif ?>
    <?php endif ?>
  </ol>
</nav>
<div class="container d-flex flex-row flex-wrap justify-content-between align-items-center">
  <h4 class="title"><?php echo ($title ? ucfirst($title) : '') ;?></h4>
  <?php if ($button): ?>
    <button class="btn btn-danger btn-sm mx-3"><?php echo $button;?></button>
    <?php echo (($button_conf == TRUE) ?  '<button class="btn btn-danger btn-sm mx-3">'.$button_conf.'</button>' : ''); ?>
  <?php endif ?>
</div>
