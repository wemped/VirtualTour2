<!DOCTYPE html>
<html>
<head>
    <title>Stops for <?=$map['title']?> | CS Virtual Tour WWU</title>
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
       <?php $this->load->view('nav') ?>
       <div id="page-wrapper">
           <div class="row">
               <div class="col-lg-12">
                   <h1 class="page-header">Tour Stops for <?= $map['title'] ?></h1>
               </div>
           </div>
           <div class="row">
                <div class="col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img class='map_img' src = <?= $map_image_path . $map['src'] ?> >
                        </div>
                    </div>
                </div>
           </div>
           <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Room</th>
                                    <th>Order</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stops as $stop) {
                                    if ($stop['active'] == 1){ ?>
                                        <tr class="success">
                                    <?php }else{ ?>
                                        <tr class="danger">
                                    <?php } ?>
                                        <td><?= $stop['title'] ?></td>
                                        <td><?= $stop['room'] ?></td>
                                        <td><?= $stop['position'] ?></td>
                                        <td>
                                            <?php if ($stop['active'] == 1) {
                                                echo "YES";
                                            }else{
                                                echo "NO";
                                            } ?>
                                        </td>
                                        <td>
                                            <a href=<?= "/stops/edit/{$stop['id']}"?> >Edit</a>
                                            <a href=<?= "/stops/delete/{$stop['id']}"?> >Delete</a>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
           </div>
           <div class="row">
                <a href="/stops/add" class="btn btn-lg btn-primary">Add a Tour Stop</a>
           </div>
       </div>
   </div>

    <script src="/dependencies/jquery/dist/jquery.min.js"></script>
    <script src="/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>