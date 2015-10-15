<!DOCTYPE html>
<html>
<head>
    <title>Edit Stop | CS Virtual Tour WWU</title>
    <link href="/dependencies/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/dependencies/css/sb-admin-2.css" rel="stylesheet">
    <link href="/dependencies/css/edit_stop.css" rel="stylesheet">
    <link href="/dependencies/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <?php //$this->load->view('meta')?>
    <!-- link css -->
    <!-- link jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<?php $index=0; //Counts the number of text/img/vid components for the stop?>
<?php //phpinfo() ?>
<body>
    <div id="wrapper">
       <?php $this->load->view('nav')?>
       <div id="page-wrapper">
           <div class="row">
               <div class="col-lg-12">
                   <h1 class="page-header">Edit Tour Stop (<?= $stop['title'] ?>)</h1>
               </div>
           </div>
           <div class="row">
                <div class="col-lg-3">
                    <h4>Edit Stop Info</h4>
                    <!-- Edit Basic Tour Stop Info Form -->
                    <form id="content_form" action=<?= "/stops/edit/{$stop['id']}"?> method="post">
                        <input type="hidden" name="content" id="json_input" />
                        <fieldset>
                            <div class="form-group">
                                Tour Stop Title <input class="form-control" name="title" type="text" value='<?= $stop['title']?>' >
                            </div>
                            <div class="form-group">
                                Tour Stop Room <input class="form-control" name="room" type="text" value='<?= $stop['room'] ?>' >
                            </div>
                            <div class="form-group">
                                Tour Stop Order <input type='number' name='position' value='<?=$stop['position']?>' >
                            </div>
                            <div class="form-group">
                                Map <select name="map_id" >
                                    <?php  foreach ($maps as $map) { ?>
                                        <option value='<?= $map['id']?>' ><?= $map['title']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                Active <input type="checkbox" name='active' value='1' <?php if ($stop['active'] == 1) {echo "checked";}?> />
                            </div>
                        </fieldset>
                    </form>
                </div>
           </div>
           <div class="row">
                <div class="col-lg-9">
                    <h4>Edit Stop Content</h4>
                    <?php if($this->session->flashdata('upload_error')){ ?>
                        <div class="alert alert-warning">
                            <?=$this->session->flashdata('upload_error')?>
                        </div>
                    <?php } ?>
                    <div id='content_editor'>
                        <!-- Editing the stop content components -->
                       <?php if ($img_filename){ ?>
                           <!-- If we just uploaded an image, but haven't saved it yet, display its component -->
                           <div class='add_img component' id=<?= 'component' . strval($index) ?> data-index=<?= $index ?> data-src= <?= $img_filename?>>
                               <div class='panel panel-info'>
                                   <div class='panel-body'>
                                        Title : <input type='text' class='add_img_title form-control'  />
                                        <img src=<?= $img_dir . $img_filename ?> >
                                   </div>
                                   <div class="panel-footer">
                                       <button class='move_up btn btn-lg btn-default'>Move Up</button>
                                       <button class='move_down btn btn-lg btn-default'>Move Down</button>
                                       <button class='delete btn btn-lg btn-danger'>Delete</button>
                                   </div>
                               </div>
                           </div>
                       <?php
                            $index++;
                       } ?>
                       <?php if ($vid_filename){ ?>
                           <!-- If we just uploaded an video, but haven't saved it yet, display its component -->
                           <div class='add_vid component' id=<?= 'component' . strval($index) ?> data-index=<?= $index ?> data-src= <?= $vid_filename?>>
                               <div class='panel panel-info'>
                                   <div class='panel-body'>
                                        Title : <input type='text' class='add_img_title form-control'  />
                                        <video src=<?=$vid_dir . $vid_filename ?> controls>
                                   </div>
                                   <div class="panel-footer">
                                       <button class='move_up btn btn-lg btn-default'>Move Up</button>
                                       <button class='move_down btn btn-lg btn-default'>Move Down</button>
                                       <button class='delete btn btn-lg btn-danger'>Delete</button>
                                   </div>
                               </div>
                           </div>
                       <?php
                            $index++;
                       } ?>
                       <?php if ($stop['content']){
                            //Display components already saved in the stop
                           $json = json_decode($stop['content'],true);
                           foreach ($json as $component) {
                               if ($component['type'] == "text"){
                       ?>
                               <div class='add_text component' id=<?= "component" . strval($index) ?> data-index=<?= $index ?> >
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            Title : <input type='text' class='add_vid_title form-control' value='<?= $component['title']?>' />
                                            Content : <textarea class='add_text_content form-control'><?= $component['content']?></textarea>
                                        </div>
                                        <div class="panel-footer">
                                            <button class='move_up btn btn-lg btn-default'>Move Up</button>
                                            <button class='move_down btn btn-lg btn-default'>Move Down</button>
                                            <button class='delete btn btn-lg btn-danger'>Delete</button>
                                        </div>
                                    </div>
                               </div>
                       <?php
                               // $index++;
                               }elseif($component['type'] == "img"){
                        ?>
                                <div class='add_img component' id=<?= 'component' . strval($index) ?> data-index=<?= $index ?> data-src=<?= $component['src']?> >
                                    <div class='panel panel-info'>
                                        <div class='panel-body'>
                                            <h4><?=$component['title']?></h4>
                                            <img src=<?=$img_dir .  $component['src'] ?> />
                                        </div>
                                        <div class="panel-footer">
                                            <button class='move_up btn btn-lg btn-default'>Move Up</button>
                                            <button class='move_down btn btn-lg btn-default'>Move Down</button>
                                            <button class='delete btn btn-lg btn-danger'>Delete</button>
                                        </div>
                                    </div>
                                </div>
                        <?php
                                // $index++;
                               }elseif ($component['type'] == 'vid') {
                        ?>
                                <div class='add_vid component' id=<?= 'component' . strval($index) ?> data-index=<?= $index ?> data-src= <?= $component['src'] ?>>
                                    <div class='panel panel-info'>
                                        <div class='panel-body'>
                                             <h4><?=$component['title']?></h4>
                                             <video src=<?=$vid_dir . $component['src'] ?> controls>
                                        </div>
                                        <div class="panel-footer">
                                            <button class='move_up btn btn-lg btn-default'>Move Up</button>
                                            <button class='move_down btn btn-lg btn-default'>Move Down</button>
                                            <button class='delete btn btn-lg btn-danger'>Delete</button>
                                        </div>
                                    </div>
                                </div>
                        <?php
                               }
                               $index++;
                           }
                       }?>
                    </div>
                    <button id="add_text" class="btn btn-lg btn-primary">Add Text</button>
                    <form id="upload_img" action=<?= "/stops/upload_img/" . $stop['id'] ?> method="post" enctype='multipart/form-data'>
                        <!-- One click file upload -->
                        <fieldset>
                            <div class="form-group">
                                <input name="fileToUpload" id="add_img" type="file" class="filestyle btn btn-lg btn-info" data-buttonText="Add an Image" data-input="false" data-icon="false" data-buttonName="btn btn-lg btn-info">
                            </div>
                        </fieldset>
                    </form>
                    <form id="upload_vid" action=<?= "/stops/upload_vid/" . $stop['id'] ?> method="post" enctype='multipart/form-data'>
                        <!-- One click file upload -->
                        <fieldset>
                            <div class="form-group">
                                <input name="vidToUpload" id="add_vid" type="file" class="filestyle btn btn-lg btn-warning" data-buttonText="Add a Video" data-input="false" data-icon="false" data-buttonName="btn btn-lg btn-warning">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class='row' >
                <div class="col-lg-3">
                    <button id="save_content" class="btn btn-lg btn-success">Save</button>
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
    $(document).ready(function (){
        /*Set the already saved components buttons*/
        $('.move_up').click(move_up);
        $('.move_down').click(move_down);
        $('.delete').click(delete_component);
        <?php if ($index){ //If there were components in the stop already this $index will be >0?>
            <?= "var i=" . $index . ";\n"?>
        <?php }else{ ?>
            <?= "var i=0;\n"?>
        <?php } ?>

        //Create an empty text component
        $('#add_text').click(function (){
            var add_text_html ="<div class='add_text component' id='component" + i + "'data-index=" + i + " >"
                                                + "<div class='panel panel-primary'>"
                                                    + "<div class='panel-body'>"
                                                       + "Title : <input type='text' class='add_text_title form-control' />"
                                                       + "Content : <textarea class='add_text_content form-control'></textarea>"
                                                    + "</div>"
                                                    + "<div class='panel-footer'>"
                                                        + "<button class='move_up btn btn-lg btn-default'>Move Up</button>"
                                                        + "<button class='move_down btn btn-lg btn-default'>Move Down</button>"
                                                        + "<button class='delete btn btn-lg btn-default'>Delete</button>"
                                                    + "</div>"
                                                + "</div>"
                                        + "</div>";
            $('#content_editor').append(add_text_html);
            $('#component' + i + '  .move_up').click(move_up);
            $('#component' + i + '  .move_down').click(move_down);
            $('#component' + i + '  .delete').click(delete_component);
            i++;
        });

        //Upload an image
        $('#add_img').change(function (){
            $("#upload_img").submit();
        });
        $('#add_vid').change(function (){
            $("#upload_vid").submit();
        });


        //Move a component up
        function move_up(event){
            var clicked_div = $(event.target).parent().parent().parent();
            var clicked_div_id = clicked_div.attr('id');
            var title_val = $("#" + clicked_div_id + " .add_text_title").val();
            var content_val = $("#" + clicked_div_id + " .add_text_content").val();
            var clicked_index = parseInt(clicked_div.attr('data-index'));
            if (clicked_index == 0){
                console.log("clicked_index was 0");
                return;
            }
            var prev_div_id = "component" + (clicked_index - 1);
            if ($("#" + prev_div_id).length == 0){
                console.log("prev div had length 0 : " + prev_div_id);
                return;
            }
            var prev_div = ($("#" + prev_div_id));
            var prev_div_index = $("#" + prev_div_id).attr('data-index');
            clicked_div.attr('id', prev_div_id);
            clicked_div.attr('data-index', prev_div_index);
            clicked_div_html = clicked_div[0].outerHTML;
            clicked_div.remove();
            prev_div.before(clicked_div_html);
            prev_div.attr('id', clicked_div_id);
            prev_div.attr('data-index', clicked_index);
            $("#" + prev_div_id + " .add_text_title").val(title_val);
            $("#" + prev_div_id + " .add_text_content").val(content_val);
            $("#" + prev_div_id + " .move_up").click(move_up);
            $("#" + prev_div_id + " .move_down").click(move_down);
            $("#" + prev_div_id + " .delete").click(delete_component);

        }
        //Move a component down
        function move_down(event){
            var clicked_div = $(event.target).parent().parent().parent();
            console.log(clicked_div);
            var clicked_div_id = clicked_div.attr("id");
            var title_val = $("#" + clicked_div_id + "  .add_text_title").val();
            var content_val = $("#" + clicked_div_id + "  .add_text_content").val();
            var clicked_index = parseInt(clicked_div.attr('data-index'));
            var next_div_id = "component" + (clicked_index + 1);
            if ($("#" + next_div_id).length == 0){
                console.log("clicked_index = " + clicked_index);
                console.log("next div had length 0");
                return;
            }
            var next_div = ($("#" + next_div_id));
            var next_div_index = $("#" + next_div_id).attr("data-index");
            clicked_div.attr('id',next_div_id);
            clicked_div.attr('data-index', next_div_index);
            clicked_div_html = clicked_div[0].outerHTML;
            clicked_div.remove();
            next_div.after(clicked_div_html);
            next_div.attr('id', clicked_div_id);
            next_div.attr('data-index', clicked_index);
            $("#" + next_div_id + " .add_text_title").val(title_val);
            $("#" + next_div_id + " .add_text_content").val(content_val);
            $("#" + next_div_id + " .move_up").click(move_up);
            $("#" + next_div_id + " .move_down").click(move_down);
            $("#" + next_div_id + " .delete").click(delete_component);

        }

        function delete_component(event){
            var clicked_div = $(event.target).parent().parent().parent();
            var clicked_div_id = clicked_div.attr("id");
            var clicked_index = parseInt(clicked_div.attr("data-index"));
            var next_div_id = "component" + (clicked_index + 1);
            clicked_div.remove();
            var new_index = clicked_index;
            while ($("#" + next_div_id).length > 0){
                var next_div = $("#" + next_div_id);
                next_div.attr("id","component" + new_index);
                next_div.attr("data-index", new_index);
                next_div_id = "component" + (new_index + 1);
            }
        }

        //Fills up a json object and sends it the db
        $("#save_content").click(function (){
            var components = [];

            $('.component').each(function(index){
                var component = {};
                var div_id = "#component" + index;
                if ($( this ).hasClass("add_text")){
                    component.type = "text";
                    component.title = $(div_id + " .add_text_title").val();
                    component.content = $(div_id + " .add_text_content").val();
                    components.push(component);
                }else if($( this ).hasClass("add_img")){
                    component.type = "img";
                    component.title = $(div_id + " .add_img_title").val();
                    component.src = $(div_id).attr("data-src");
                    components.push(component);
                }else if($( this ).hasClass("add_vid")){
                    component.type = "vid";
                    component.title = $(div_id + " .add_vid_title").val();
                    component.src = $(div_id).attr("data-src");
                    components.push(component);
                }
            });
            json = JSON.stringify(components);
            $("#json_input").val(json);
            $("#content_form").submit();
        });
    });
</script>