<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <div class="container">
    <?php if ($title == 'Home'): ?>
      <li class="breadcrumb-item"><a href="<?php echo base_url('admin/home'); ?>">Home</a></li>
    <?php else :?>
      <?php if ($breadcrumb): ?>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/home'); ?>">Home</a></li>
        <?php foreach ($breadcrumb as $key): ?>
        <li class="breadcrumb-item"><a href="<?php echo base_url("admin/{$key}"); ?>"><?php echo ucfirst($key); ?></a></li>
        <?php endforeach ?>
        <li <?php echo ($subbreadcrumb ? 'class="breadcrumb-item"' : 'class="breadcrumb-item active" aria-current="page" ');?>>
          <?php echo ($subbreadcrumb ? '<a href="'.base_url("admin/{$title}").'">'.ucfirst($title).'</a>' : ucfirst($title)); ?>
        </li>
        <?php if ($subbreadcrumb): ?>
          <?php foreach ($subbreadcrumb as $key): ?>
          <li class="breadcrumb-item <?php echo ((end($subbreadcrumb) == $key) ? 'active aria-current="page"' : ''); ?>">
            <?php echo ((end($subbreadcrumb) == $key) ? ucfirst($key) : '<a href="">'.ucfirst($key).'</a>');?>
          </li>  
        <?php endforeach ?>
        <?php endif ?>
      <?php else : ?>
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
        <?php if ($button_link == 'Upload'){ ?>
          <div class="header-upload">
            <button class="btn btn-danger btn-sm mx-1"><?php echo ucfirst($button);?></button>
            <input type="file" name="file" id="file" />
          </div>
        <?php } elseif ($button_link == 'dropdown') { ?>
          <a href="<?php echo $button_link; ?>" 
            class="btn btn-danger btn-sm mx-1" 
            type="button"
            id="dropdownMenuButton" 
            data-toggle="dropdown" 
            aria-haspopup="true" 
            aria-expanded="false"
            name="<?php echo (isset($button_name) ? $button_name : ''); ?>">
            <?php echo ucfirst($button);?>
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php if (isset($button_dropdown)) {
              foreach ($button_dropdown as $key) {
                echo '<a class="dropdown-item" href="'.$key->handle.'/create">'.ucfirst($key->name).'</a>';
              }
            } ?>
          </div>
        <?php } else { ?>
          <a href="<?php echo $button_link; ?>" 
            class="btn btn-danger btn-sm mx-1" 
            type="<?php echo (isset($button_type) ? $button_type : '') ?>"
            name="<?php echo (isset($button_name) ? $button_name : ''); ?>">
            <?php echo ucfirst($button);?>
          </a>
        <?php } ?>
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
