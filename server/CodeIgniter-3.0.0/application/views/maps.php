<!DOCTYPE html>
<html>
<head>
    <title>Maps | CS Virtual Tour WWU</title>
    <link href="/dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/dependencies/css/sb-admin-2.css" rel="stylesheet">
    <link href="/dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/dependencies/css/maps.css" rel="stylesheet" type="text/css">

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
                    <h1 class="page-header">Maps</h1>
                </div>
            </div>
            <?php foreach ($maps as $map) { ?>
                <div class='row'>
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?= "<h3>" . $map['title'] . "</h3>" . " <a href='/stops/map/{$map['id']}' >Show Tour Stops</a>"?>
                            </div>
                            <div class="panel-body">
                                <img class='map_img' src = <?php echo $map_image_path . $map['src'] ?> >
                            </div>
                            <div class="panel-footer">
                                <?php
                                    echo "<a href='/maps/edit/{$map['id']}' class='delete btn btn-lg btn-primary'>Edit Map</a> - ";
                                    echo "<a href='/maps/delete/{$map['id']}' class='delete btn btn-lg btn-danger' >Delete Map</a>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-4">
                    <h4>Create a new Map</h4>
                    <?php if($this->session->flashdata('upload_error')){ ?>
                        <div class="alert alert-danger">
                            <?=$this->session->flashdata('upload_error')?>
                        </div>
                    <?php } ?>
                    <form action="/maps/create" method="post" enctype='multipart/form-data'>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Map Title (ex: 'CF Fourth Floor')" name="title" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Tour Order (ex. 2)" name="order" type="number">
                            </div>
                            <div class="form-group">
                                <input type='file' name='fileToUpload' id='fileToUpload'>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type='submit' name="submit"  class="btn btn-lg btn-primary btn-block">Create Map</button>
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