<?php 
	defined('BASEPATH') OR exit('No direct script allowed');

  // pagination
  $config['setting_pagination'] = array(
		// 'base_url'              => base_url($settings['action'),
		// 'total_rows'            => $this->general_m->count_all_results($settings['table'),
		// 'per_page'              => 10,
		// 'uri_segment'           => 4,
		// 'num_links'             => round($num_pages),
		'use_page_numbers'      => FALSE,
		'page_query_string'     => FALSE,
		'reuse_query_string'    => FALSE,
		'prefix'                => '',
		'suffix'                => '',
		'use_global_url_suffix' => FALSE,
		'full_tag_open'         => '<ul class="pagination">',
		'full_tag_close'        => '</ul>',
		'first_link'            => 'FIRST',
		'first_tag_open'        => '<li class="page-item">',
		'first_tag_close'       => '</li>',
		'first_url'             => '',
		'last_link'             => 'LAST',
		'last_tag_open'         => '<li class="page-item">',
		'next_link'             => '&gt,',
		'next_tag_open'         => '<li class="page-item">',
		'next_tag_close'        => '</li>',
		'prev_tag_open'         => '<li class="page-item">',
		'prev_tag_close'        => '</li>',
		'cur_tag_open'          => '<li class="page-item active"><a href="" class="page-link">',
		'cur_tag_close'         => '</a></li>',
		'num_tag_open'          => '<li class="page-item">',
		'num_tag_close'         => '</li>',
		'display_pages'         => TRUE,
  );
  //end pagination    

