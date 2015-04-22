<?php
$this->title = 'Dashboard';
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-question-sign" style="font-size:45px;"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h4>New Question</h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/newqs']) ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-star"  style="font-size:45px;"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h4>Question Manager</h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/qsmng']) ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-list-alt"  style="font-size:45px;"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h4>Report</h4>
                                </div>
                            </div>
                        </div>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/report']) ?>">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-user" style="font-size:45px;"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <h4>User</h4>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>            
        </div>