<!DOCTYPE html>
<html>
<head>
    <title>Add Stop | CS Virtual Tour WWU</title>
    <link href="/dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/dependencies/css/sb-admin-2.css" rel="stylesheet">
    <link href="/dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                   <h1 class="page-header">Add a Tour Stop</h1>
               </div>
           </div>
           <div class="row">
                <?php if($this->session->flashdata('add_stop_err')){ ?>
                    <div class="alert alert-warning">
                        <?=$this->session->flashdata('add_stop_err')?>
                    </div>
                <?php } ?>
                <form action="/stops/add" method="post">
                    <div class='form-group'>
                        Tour Stop Title <input type="text" name='title' class='form-control' />
                    </div>
                    <div class='form-group'>
                        Tour Stop Room <input type="text" name='room' class='form-control' />
                    </div>
                    <div class='form-group'>
                        Order <input type="number" name='position' class='form-control' />
                    </div>
                    <div class='form-group'>
                        Map
                        <select name='map'>
                            <?php foreach ($maps as $map) { ?>
                                <option value=<?= $map['id']?>><?= $map['title']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type='submit' class="btn btn-lg btn-success">Save</button>
                </form>
           </div>
       </div>
   </div>
</body>
</html>