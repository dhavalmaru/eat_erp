<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loading_screen_log_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

  
 function insertQ(){
    $loadtime = $this->input->post('loadtime');
    $url = $this->input->post('url');
    $this->db->insert('loading_screen_log', array('loadtime' =>$loadtime, 'url' => $url));
}
}?>