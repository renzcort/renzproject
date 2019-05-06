<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <div class="container">
    <?php if ($title != 'Home'): ?>
      <?php if ($subbreadcrumb): ?>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/home'); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href=""><?php echo ($title ? ucfirst($title) : ''); ?></a></li>
        <?php foreach ($subbreadcrumb as $key): ?>
        <li class="breadcrumb-item <?php echo ((end($subbreadcrumb) == $key) ? 'active aria-current="page"' : ''); ?>">
          <?php echo ((end($subbreadcrumb) == $key) ? ucfirst($key) : '<a href="">'.ucfirst($key).'</a>');?>
        </li>  
        <?php endforeach ?>
      <?php else:?>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/home'); ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo ($title ? ucfirst($title) : ''); ?></li>
      <?php endif ?>
    <?php endif ?>
    </div>
  </ol>
</nav>
<div class="container title d-flex flex-row flex-wrap justify-content-between align-items-center">
  <h4><?php echo ($subtitle ? ucfirst($title).'&nbsp;'.ucfirst($subtitle) : ucfirst($title)) ;?></h4>
  <?php if (isset($button)): ?>
    <div class="d-flex flex-row flex-wrap justify-content-start">
    	<?php if (isset($button_link)): ?>
	      <a href="<?php echo $button_link; ?>" 
	        class="btn btn-danger btn-sm mx-1" 
	        type="<?php echo (isset($button_type) ? $button_type : '') ?>"
	        name="<?php echo (isset($button_name) ? $button_name : ''); ?>">
	        <?php echo ucfirst($button);?>
	      </a>
      <?php else : ?>
	    	<button id="buttonHeader" 
	        class="btn btn-danger btn-sm mx-1" 
	        type="<?php echo (isset($button_type) ? $button_type : '') ?>"
	        name="<?php echo (isset($button_name) ? $button_name : ''); ?>"
          data-tabs="<?php echo ((isset($button_tabs) && $button_tabs == TRUE) ? '1' : '') ?>">
	        <?php echo ucfirst($button);?>
	      </button>  	
    	<?php endif ?>
      <?php echo (isset($button_conf) ?  '<button class="btn btn-danger btn-sm">'.ucfirst($button_conf).'</button>' : ''); ?>
    </div>
  <?php endif ?>
</div>
