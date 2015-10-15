<!DOCTYPE html>
<html>
<head>
    <title>Edit Stop | CS Virtual Tour WWU</title>
    <link href="/dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/dependencies/css/sb-admin-2.css" rel="stylesheet">
    <link href="/dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/dependencies/css/media.css" rel="stylesheet">
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
                   <h1 class="page-header">Media</h1>
               </div>
           </div>
           <div class="row">
              <div class='col-lg-10'>
                  <h3>Maps</h3>
                  <?php foreach ($maps as $map) { ?>
                    <div class='panel panel-info'>
                        <div class="panel-heading">
                          <?= $map['filename'] ?>
                        </div>
                        <div class='panel-body'>
                             <img src=<?= $map['src'] ?> >
                        </div>
                        <div class="panel-footer">
                          <?php if ($map['deletable']){ ?>
                            <a href=<?php echo "/media/maps/delete/" . str_replace(".", "/", $map['filename']) ?> class='delete btn btn-lg btn-danger'>Delete</a>
                          <?php }else{ ?>
                            <a href="#" class="delete btn btn-lg btn-default disabled">Delete</a>
                            You are unable to delete this because it is still connected to Map '<?=$map['connected']?>'. Go to <a href="/maps">Maps</a> to delete it.
                          <?php } ?>
                        </div>
                    </div>
                  <? }?>
              </div>
           </div>
           <div class="row">
              <div class='col-lg-10'>
                  <h3>Stop Images</h3>
                  <?php foreach ($stop_images as $image) { ?>
                    <div class='panel panel-info'>
                        <div class="panel-heading">
                          <?= $image['filename'] ?>
                        </div>
                        <div class='panel-body'>
                             <img src=<?= $image['src'] ?> >
                        </div>
                        <div class="panel-footer">
                          <?php if ($image['deletable']){ ?>
                            <a href=<?php echo "/media/stop_images/delete/" . str_replace(".", "/", $image['filename']) ?> class='delete btn btn-lg btn-danger'>Delete</a>
                          <?php }else{ ?>
                            <a href="#" class="delete btn btn-lg btn-default disabled">Delete</a>
                            You are unable to delete this because it is still connected to Stop '<?=$image['connected']?>'. Go to <a href=<?="/stops/edit/{$image['stop_id']}"?> >Stop</a> to delete it.
                          <?php } ?>
                        </div>
                    </div>
                  <? }?>
              </div>
           </div>
           <div class="row">
              <div class='col-lg-10'>
                  <h3>Stop Videos</h3>
                  <?php foreach ($stop_videos as $video) { ?>
                    <div class='panel panel-info'>
                        <div class="panel-heading">
                          <?= $video['filename'] ?>
                        </div>
                        <div class='panel-body'>
                             <video src=<?= $video['src'] ?> >
                        </div>
                        <div class="panel-footer">
                          <?php if ($video['deletable']){ ?>
                            <a href=<?php echo "/media/stop_videos/delete/" . str_replace(".", "/", $video['filename']) ?> class='delete btn btn-lg btn-danger'>Delete</a>
                          <?php }else{ ?>
                            <a href="#" class="delete btn btn-lg btn-default disabled">Delete</a>
                            You are unable to delete this because it is still connected to Stop '<?=$video['connected']?>'. Go to <a href=<?="/stops/edit/{$video['stop_id']}"?> >Stop</a> to delete it.
                          <?php } ?>
                        </div>
                    </div>
                  <? }?>
              </div>
           </div>
       </div>
   </div>
</body>
</html>
<script src="/dependencies/jquery/dist/jquery.min.js"></script>
<script src="/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/dependencies/bootstrap/js/bootstrap-filestyle.min.js"></script>
<script type="text/javascript">

</script>