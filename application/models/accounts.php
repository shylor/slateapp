<?php
class Accounts extends CI_Model {

  public function is_user($stop_redirect=false) {
    $user = false;
    $session_signin = false;
    if($this->session->userdata('online')) {
      $query['session'] = $this->db->get_where('accounts', array('id'=>$this->session->userdata('uid')));
      if($query['session']->num_rows() == 1) {
        $user = $query['session']->row();
        $session_signin = true;
      }
    }

    if(!$session_signin && $this->input->cookie('aid')) {
      $this->db->where('cookie_code', $this->input->cookie('aid'));
      $this->db->where('cookie_expires >', time());
      $query['cookie'] = $this->db->get('accounts');
      if($query['cookie']->num_rows() == 1) {
        $user = $query['cookie']->row();
        $this->session->set_userdata(array('online'=>true,'uid'=>$user->id));
      }
    }

    if($user) {
      return $user;
    } else {
      if($stop_redirect == false) {
        $this->load->helper('url');
        redirect('/signin');
      } else {
        return false;
      }
    }
  }

  public function signup() {
    $email_code = md5($this->input->post('email1').time());
    $pass_salt  = md5(rand(1,5000).rand(1,5000));

    $user = array(
      'eid'        => md5($this->input->post('username').time()).md5(time().$this->input->post('username')),
      'username'   => $this->input->post('username'),
      'email'      => $this->input->post('email1'),
      'access'     => 1,
      'password'   => $this->_hash_password($this->input->post('password1'), $pass_salt),
      'salt'       => $pass_salt,
      'email_code' => $email_code
    );

    if($this->db->insert('accounts', $user)) {
      return $email_code;
    } else {
      return false;
    }
  }

  public function signin() {
    $user = array(
      'username' => $this->input->post('username')
    );

    $query['account'] = $this->db->get_where('accounts', $user);

    if($query['account']->num_rows() == 1) {
      $user = $query['account']->row();

      if($this->_hash_password($this->input->post('password'), $user->salt) == $user->password) {
        if($user->access != 0 && $user->email_confirm != 0) {
          $this->session->set_userdata(array('online'=>true,'uid'=>$user->id));
          if($this->input->post('remember') == 'on') {
            $cookie_code = $this->_set_cookie($user->id);
            return $cookie_code;
          } else {
            return 'off'; // remember cookie not set
          }
        } else {
          return false; // blocked or did not confirm yet
        }
      } else {
        return false; // password salt check
      }
    } else {
      return false; // no account found
    }
  }

  public function activate($code) {
    $this->db->where('email_code', $code);
    $this->db->update('accounts', array('email_confirm'=>'1'));

    if($this->db->affected_rows() == 1) {
      return true;
    } else {
      return false;
    }
  }

  public function forgot() {
    $email_code = md5($this->input->post('email1').time());

    $user = array(
      'email_code' => $email_code
    );

    $this->db->where('email', $this->input->post('email'));
    $this->db->update('accounts', $user);

    if($this->db->affected_rows() == 1) {
      return $email_code;
    } else {
      return false;
    }
  }

  public function reset($code) {
    $pass_salt  = md5(rand(1,5000).rand(1,5000));

    $user = array(
      'password' => $this->_hash_password($this->input->post('password1'), $pass_salt),
      'salt'     => $pass_salt
    );

    $this->db->where('email_code', $code);
    $this->db->update('accounts', $user);

    if($this->db->affected_rows() == 1) {
      return true;
    } else {
      return false;
    }
  }

  public function get_user($value, $type='id') {
    switch($type) {
      case 'id':
        $query['user'] = $this->db->get_where('accounts', array('id'=>$value));
        break;
      case 'eid':
        $query['user'] = $this->db->get_where('accounts', array('eid'=>$value));
        break;
      case 'username':
        $query['user'] = $this->db->get_where('accounts', array('username'=>$value));
        break;
      case 'email':
        $query['user'] = $this->db->get_where('accounts', array('email'=>$value));
        break;
      default:
          return false;
    }
    if($query['user']->num_rows() == 1) {
      return $query['user']->row;
    } else {
      return false;
    }
  }

  public function change_email($uid, $email) {
    $this->db->where('id', $uid);
    $this->db->update('accounts', array('email'=>$email));

    if($this->db->affected_rows() == 1) {
      return true;
    } else {
      return false;
    }
  }

  public function change_password($uid, $password) {
    $pass_salt  = md5(rand(1,5000).rand(1,5000));

    $this->db->where('id', $uid);
    $this->db->update('accounts', array('password'=>$this->_hash_password($password, $pass_salt)));

    if($this->db->affected_rows() == 1) {
      return true;
    } else {
      return false;
    }
  }

  private function _set_cookie($id) {
    $code = md5($id.md5(time()));
    $this->db->where('id', $id);
    $this->db->update('accounts', array('cookie_code'=>$code,'cookie_expires'=>time()+2592000));
    return $code;
  }

  private function _hash_password($password, $salt) {
    $code_1 = $this->config->item('password_code_1');
    $code_2 = $this->config->item('password_code_2');
    $code_3 = $this->config->item('password_code_3');
    $code_4 = $this->config->item('password_code_4');
    return md5(md5($password.$code_3.$salt).md5($salt.$password.$code_1).$password).md5(md5($password.$salt.$code_4).md5($password.$code_2.$salt).$password);
  }

}