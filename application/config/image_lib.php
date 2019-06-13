<?php
 defined('BASEPATH') OR exit('no direct script allowed');
 
  $config['setting_image'] = array(
    'image_library'    => 'gd2',
    'library_path'     => '',
    'source_image'     => '',
    'create_thumb'     => TRUE,
    'maintain_ratio'   => TRUE,
    'width'            => 75,
    'height'           => 50,
    'new_image'        => '',
    'thumb_marker'     => '_thumb',
    'dynamic_output'   => FALSE,
    'file_permissions' => 0644,
    'quality'          => 90,
    'master_dim'       => 'auto',
    'rotation_angle'   => '',
    'x_axis'           => '',
    'y_axis'           => '',
  ); 
?>