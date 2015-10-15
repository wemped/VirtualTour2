<!DOCTYPE html>
<html>
<head>
    <title>Staff | CS Virtual Tour WWU</title>
    <link href="/dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/dependencies/css/sb-admin-2.css" rel="stylesheet">
    <link href="/dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                    <h1 class="page-header">Edit Map (<?= $map['title'] ?>)</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h4>Edit Map Info</h4>
                    <?php if($this->session->flashdata('edit_info')){ ?>
                        <div class="alert alert-warning">
                            <?=$this->session->flashdata('edit_info')?>
                        </div>
                    <?php } ?>
                    <form action=<?= "/maps/edit/{$map['id']}"?> method="post" id="info-form">
                        <fieldset>
                            <div class="form-group">
                                Title : <input class="form-control" placeholder="Map Title (ex: 'CF Fourth Floor')" name="title" type="text" value='<?= $map['title'] ?>' >
                            </div>
                            <div class="form-group">
                                Order : <input class="form-control" placeholder="Tour Order (ex. 2)" name="order" type="number" value=<?= $map['position'] ?> >
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type='submit' class="btn btn-lg btn-primary">Save info</button>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class='row'>
                <div class="col-lg-12">
                    <h4>Edit Map Image</h4>
                    <?php if($this->session->flashdata('upload_error')){ ?>
                        <div class="alert alert-danger">
                            <?=$this->session->flashdata('upload_error')?>
                        </div>
                    <?php } ?>
                    <form action=<?="/maps/edit/image/{$map['id']}" ?> method="post" enctype='multipart/form-data'>
                        <fieldset>
                            <div class="form-group">
                                <input type='file' name='fileToUpload' id='fileToUpload'>
                            </div>
                            <button type='submit' name="submit" class="btn btn-lg btn-primary">Upload and Update</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
     </div>
     <script src="/dependencies/jquery/dist/jquery.min.js"></script>
     <script src="/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>