<h1>
  <?php echo ($title ? $title : ''); ?> <small><?php echo ((isset($subtitle)) ? $subtitle : ''); ?></small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
  <li class="active"><?php echo ($title ? $title : ''); ?></li>
</ol>