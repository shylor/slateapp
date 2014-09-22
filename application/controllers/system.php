<?php
class System extends CI_Controller {

  public function signup() {
    $data = array();
    if($_POST) {
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username', 'username', 'required|max_length[24]|min_length[3]|is_unique[accounts.username]|alpha_numeric');
      $this->form_validation->set_rules('email1', 'email', 'required|max_length[128]|is_unique[accounts.email|matches[email2]|valid_email');
      $this->form_validation->set_rules('password1', 'password', 'required|matches[password2]|min_length[8]');

      if($this->form_validation->run() === true) {

        if($email_code = $this->accounts->signup()) {
          $this->load->library('email');
          $this->load->helper('url');

          $email = array(
            'base_url' => base_url(),
            'project_name' => $this->config->item('project_name'),
            'project_team' => $this->config->item('project_team'),
            'email_code' => $email_code
          );

          $this->email->from($this->config->item('email_address'), $this->config->item('email_name'));
          $this->email->to($this->input->post('email1'));

          $this->email->subject($this->config->item('project_name').' Activation');
          $this->email->message($this->load->view('emails/activation', $email, true));

          $this->email->send();

          $data['msg_type'] = 's';
          $data['msg_text'] = 'Please check your email to complete the process!';
        } else {
          $$data['msg_type'] = 'e';
          $data['msg_text'] = 'Internal error. Please try again later!';
        }
      } else {
        $data['msg_type'] = 'e';
        $data['msg_text'] = 'Please fix the information below and try again!<br><ul>'.validation_errors('<li>','</li>').'</ul>';
      }
    }

    $this->load->view('sys/header', $data);
    $this->load->view('sys/signup');
    $this->load->view('sys/footer');
  }

  public function signin() {
    $data = array();
    if($_POST) {
      $this->load->library('form_validation');

      $this->form_validation->set_rules('username', 'username', 'required');
      $this->form_validation->set_rules('password', 'password', 'required');

      if($this->form_validation->run() === true) {
        $signin = $this->accounts->signin();
        $this->load->helper('url');
        if($signin == 'off') {
          redirect($this->config->item('login_redirect'));
        } elseif($signin) {
          $this->input->set_cookie('aid', $signin, time()+2592000);
          redirect($this->config->item('login_redirect'));
        } elseif(!$signin) {
          $data['msg_type'] = 'e';
          $data['msg_text'] = 'Failed to sign in. Invalid username or password!';
        }
      }
    }

    $this->load->view('sys/header', $data);
    $this->load->view('sys/signin');
    $this->load->view('sys/footer');
  } 
  
  public function logout() {
    $this->input->set_cookie('aid', '', 0);
    $this->session->sess_destroy();
    $this->load->helper('url');
    redirect('/');
  }
  
  public function forgot() {
    $data = array();
    if($_POST) {
      $this->load->library('form_validation');

      $this->form_validation->set_rules('email', 'email', 'required|valid_email');

      if($this->form_validation->run() === true) {

        if($email_code = $this->accounts->forgot()) {
          $this->load->library('email');
          $this->load->helper('url');

          $email = array(
            'base_url' => base_url(),
            'project_name' => $this->config->item('project_name'),
            'project_team' => $this->config->item('project_team'),
            'email_code' => $email_code
          );

          $this->email->from($this->config->item('email_address'), $this->config->item('email_name'));
          $this->email->to($this->input->post('email'));

          $this->email->subject($this->config->item('project_name').' Password Reset');
          $this->email->message($this->load->view('emails/forgot', $email, true));

          $this->email->send();

          $data['msg_type'] = 's';
          $data['msg_text'] = 'Please check your email to complete the process!';
        } else {
          $$data['msg_type'] = 'e';
          $data['msg_text'] = 'Internal error. Please try again later!';
        }
      } else {
        $data['msg_type'] = 'e';
        $data['msg_text'] = 'Please enter a valid email address!';
      }
    }

    $this->load->view('sys/header');
    $this->load->view('sys/forgot');
    $this->load->view('sys/footer');
  }

  public function reset($code) {
    $data['code'] = $code;
    if($_POST) {
      $this->load->library('form_validation');

      $this->form_validation->set_rules('password1', 'password', 'required|matches[password2]');

      if($this->form_validation->run() === true) {
        if($this->accounts->reset($code)) {
          $this->load->helper('url');
          redirect('/signin');
        } else {
          $data['msg_type'] = 'e';
          $data['msg_text'] = 'Internal error. Please try again later!';
        }
      } else {
        $data['msg_type'] = 'e';
        $data['msg_text'] = 'Your passwords do not match!';
      }
    }

    $this->load->view('sys/header', $data);
    $this->load->view('sys/reset');
    $this->load->view('sys/footer');
  }
  
  public function activate($code) {
    $data = array();
    
    if($this->accounts->activate($code)) {
      $this->session->set_flashdata('msg_type', 's');
      $this->session->set_flashdata('msg_text', 'Your account is activated and you can now sign in!');
    } else {
      $this->session->set_flashdata('msg_type', 'e');
      $this->session->set_flashdata('msg_text', 'We could not find your account or something went wrong. Try again later!');
    }
    $this->load->helper('url');
    redirect('/signin');
  }

}