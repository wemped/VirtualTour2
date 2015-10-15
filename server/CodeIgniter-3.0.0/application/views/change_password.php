<!DOCTYPE html>
<html>
<head>
    <title>Change Password | CS Virtual Tour WWU</title>
    <link href="./dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="./dependencies/css/sb-admin-2.css" rel="stylesheet">
    <?php //$this->load->view('meta')?>
    <!-- link css -->
    <!-- link jquery -->
</head>
<body>
 <div id="wrapper">
    <?php $this->load->view('nav') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Change Password</h1>
            </div>
        </div>
        <div class="col-lg-4">
            <?php if($this->session->flashdata('change_pass_err')){ ?>
                <div class="alert alert-danger">
                    <?=$this->session->flashdata('change_pass_err')?>
                </div>
            <?php }elseif ($this->session->flashdata('change_pass_succ')) { ?>
                <div class="alert alert-success">
                    <?=$this->session->flashdata('change_pass_succ')?>
                </div>
            <?php } ?>
            <form action ="/password" method="post">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="New Password" name="new_password" type="password" autofocus />
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Confirm Password" name="confirm_password" type="password" autofocus />
                    </div>
                    <a href="#" onclick="$('form').submit();" class="btn btn-lg btn-warning">Change</a>
                </fieldset>
            </form>
        </div>
    </div>
 </div>
 <script src="./dependencies/jquery/dist/jquery.min.js"></script>
 <script src="./dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>