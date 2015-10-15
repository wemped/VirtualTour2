<!DOCTYPE html>
<html>
<head>
    <title>Staff | CS Virtual Tour WWU</title>
    <link href="./dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./dependencies/css/sb-admin-2.css" rel="stylesheet">
    <link href="./dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <?php //$this->load->view('meta')?>
    <!-- link css -->
    <!-- link jquery -->
</head>
<body>
      <div id="wrapper">
         <?php $this->load->view('nav')?>
         <div id="page-wrapper">
             <div class="row">
                 <div class="col-lg-12">
                     <h1 class="page-header">Tour Editors</h1>
                 </div>
             </div>
             <div class="row">
                <div class='col-lg-12'>
                    <?php if($this->session->flashdata('new_user_err')){ ?>
                        <div class="alert alert-danger">
                            <?=$this->session->flashdata('new_user_err')?>
                        </div>
                    <?php }elseif ($this->session->flashdata('new_user_succ')) { ?>
                        <div class="alert alert-success">
                            <?=$this->session->flashdata('new_user_succ')?>
                        </div>
                    <?php } ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Admin</th>
                                    <?php if ($this->session->userdata('admin') == 1){ ?>
                                        <th>Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($staff as $user){ ?>
                                    <tr>
                                        <td><?=$user['username']?></td>
                                        <td>
                                            <?php if ($user['admin'] == 1){
                                                echo "Yes";
                                            }else{
                                                echo "No";
                                            }?>
                                        </td>
                                        <td>
                                            <?php if ($this->session->userdata('admin') == 1){ ?>
                                                <?php if ($user['admin'] != 1){ ?>
                                                    <a href= <?php echo "users/delete/{$user['id']}" ?>>Delete </a>
                                                <? } ?>
                                            <? } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
            <?php if ($this->session->userdata('admin') == 1){ ?>
             <div class="row">
                <div class='col-lg-3'>
                    <h4>Create a new Tour Editor</h4>
                    <form action="/users/add" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="admin" type="checkbox" value="1">Admin
                                </label>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Confirm Password" name="confirm_password" type="password">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <a href="#" onclick="$('form').submit();" class="btn btn-lg btn-primary btn-block">Create User</a>
                        </fieldset>
                    </form>
                </div>
            </div>
            <?php } ?>
         </div>
     </div>
     <script src="./dependencies/jquery/dist/jquery.min.js"></script>
     <script src="./dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>