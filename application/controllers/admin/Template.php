<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends My_Controller {

  public function index()
  {
    $label = array(
      'label 1',
      'label 2',
      'label 3',
    );
    $val = array(
      'value 1',
      'value 2',
      'value 3',
    );

    $i = 0;
    foreach ($label as $key => $value) {
      $data[] = array(
                  'label' => $value,
                  'value' => $val[$i],
                );
      $i++;
    }

    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;

    $settings['content'] = 'template/bootstrap-4/admin/section/section-list';
    $this->load->view('template/bootstrap-4/admin/layout/_default', $settings);
    // $this->load->view('template/bootstrap-4/layout/_activate', $settings);
  }

}

/* End of file Template.php */
/* Location: ./application/controllers/admin/Template.php */