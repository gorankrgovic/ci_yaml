<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example Controller
 */

class Example extends CI_Controller {

    public function index() {

        //Load library
        $this->load->library('yamls');
        //parse the yaml file
        $yaml = $this->yamls->parse('settings');

        print_r($yaml);

        //Write to yaml file
        $array = array(
            'foo' => 'bar',
            'bar' => array('foo' => 'bar', 'bar' => 'baz new'),
        );

        $this->yamls->write($array, 'settings');
    }

}
