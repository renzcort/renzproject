<h1>
  <?php 
    echo (isset($title) ? $title : $header);
  ?> 
  <small><?php echo (isset($subheader) ? $subheader : ''); ?></small>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
  <li class="active"><?php echo (isset($title) ? $title : $session['title']); ?></li>
  <?php if (isset($header)) { ?>
    <li class="active"><?php echo (isset($header) ? $header : ''); ?></li>
  <?php } ?>
</ol>