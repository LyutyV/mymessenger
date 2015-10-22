<?php
use app\modules\chat\ChatAsset;
$bundle = ChatAsset::register($this);
?>
<div id="wrapper">

          <!-- Sidebar -->
          <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Users list
                    </a>
                </li>
                <?=$data['userList']?>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Hide userlist</a>
                        <div class="box box-success">
                            <div class="box-header ui-sortable-handle" style="cursor: move;">
                                <i class="fa fa-comments-o"></i>
                                <h3 class="box-title">Chat</h3>
                            </div>
                            <div class="slimScrollDiv" style="position: relative; overflow: scroll; width: auto; height: 350px;">
                                <div id="chat-box" class="box-body chat" style="overflow: hidden; width: auto;">
                                    <?php
                                        //var_dump($data['chat']);
                                        //echo $data['chat'];
                                    ?>
                                </div>
                                <div class="slimScrollBar" style="background: none repeat scroll 0% 0% rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px; height: 187.126px;"></div>
                                <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: none repeat scroll 0% 0% rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                                    
                            </div><!-- /.chat -->
                            <div class="box-footer">
                                <div class="input-group">
                                    <input name="Chat[message]" id="chat_message" placeholder="Type message..." class="form-control">
                                    <div class="input-group-btn">
                                        <button class="btn btn-success btn-send-comment" data-url="<?=$url;?>" data-model="<?=$userModel;?>" data-userfield="<?=$userField;?>" data-loading="<?=$loading;?>"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box (chat box) -->  
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>