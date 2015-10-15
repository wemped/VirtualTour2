<!DOCTYPE html>
<html>
<head>
    <title>Login | CS Virtual Tour WWU</title>
    <link href="./dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="./dependencies/css/sb-admin-2.css" rel="stylesheet">
    <?php //$this->load->view('meta')?>
    <!-- link css -->
    <!-- link jquery -->
</head>
<body>
     <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Log In To WWU CS Virtual Tour</h3>
                    </div>
                    <div class='panel-body'>
                        <?php if($this->session->flashdata('login_error')){ ?>
                            <div class="alert alert-danger">
                                <?=$this->session->flashdata('login_error')?>
                            </div>
                        <?php } ?>
                        <form action ="/login" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus />
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" autofocus />
                                </div>
                                <a href="#" onclick="$('form').submit();" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
    <script src="./dependencies/jquery/dist/jquery.min.js"></script>
    <script src="./dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>