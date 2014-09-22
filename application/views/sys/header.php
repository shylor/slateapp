<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/verek.css">
  </head>
  <body>
  
    <?php if(isset($msg_type)): ?>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <?php if($msg_type == 's'): ?>
              <div class="alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $msg_text ?>
              </div>
            <?php elseif($msg_type == 'e'): ?>
              <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $msg_text ?>
              </div>
            <?php elseif($msg_type == 'w'): ?>
              <div class="alert alert-dismissable alert-warning">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $msg_text ?>
              </div>
            <?php elseif($msg_type == 'i'): ?>
              <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $msg_text ?>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    <?php elseif($this->session->flashdata('msg_type')): ?>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <?php if($this->session->flashdata('msg_type') == 's'): ?>
              <div class="alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $this->session->flashdata('msg_text') ?>
              </div>
            <?php elseif($this->session->flashdata('msg_type') == 'e'): ?>
              <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $this->session->flashdata('msg_text') ?>
              </div>
            <?php elseif($this->session->flashdata('msg_type') == 'w'): ?>
              <div class="alert alert-dismissable alert-warning">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $this->session->flashdata('msg_text') ?>
              </div>
            <?php elseif($this->session->flashdata('msg_type') == 'i'): ?>
              <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $this->session->flashdata('msg_text') ?>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    <?php endif ?>