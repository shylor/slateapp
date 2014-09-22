<?php
class App extends CI_Controller {
  
  public function index() {
    $this->load->view('sys/header');
    $this->load->view('app/home');
    $this->load->view('sys/footer');
  }
  
  public function dashboard() {
    $data['user'] = $this->accounts->is_user();
    
    $this->load->view('sys/header', $data);
    $this->load->view('app/dashboard');
    $this->load->view('sys/footer');
  }
  
}