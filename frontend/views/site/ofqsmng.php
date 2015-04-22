<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\User;
use frontend\models\Unit;

$this->title = 'Question Manager';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        My Office Question list
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>         
                        <th>Create time</th>
                        <th>Question</th>
                        <th>Is active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tmp = 0;
                    foreach ($qsList as $qs) {
                        $tmp++;
                        // $time = date('m/d/Y H:i:s', $qs->date);

                        $delete = Yii::$app->urlManager->createUrl(['site/deleteqs', 'id' => $qs->id]);
                        if ($qs->status == 1) {
                            $active = 'class="danger"';
                            $star = "<i class='glyphicon glyphicon-star' style='font-size:20px; color:gold'>";
                        } else {
                            $active = '';
                            $activeChange = Yii::$app->urlManager->createUrl(['site/changeactive', 'id' => $qs->id]);
                            $star = "<a href='{$activeChange}' <i class='glyphicon glyphicon-star-empty' style='font-size:20px;'>";
                        }
                        echo <<<EOF
		<tr {$active}>
            <td>{$tmp}</td>
            <td>{$qs->date}</td>
            <td>{$qs->question}</td>
            <td>{$star}</td>
            <td><a href='{$delete}' <i class='glyphicon glyphicon-remove' style='font-size:15px; color:red'></i></td>
        </tr>
EOF;
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>

<div class="panel panel-default">
    <div class="panel-heading">
        Global question
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>                        
                        <th>Office</th>
                        <th>Create time</th>
                        <th>Question</th>
                        <th>Is active</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tmp = 0;
                    foreach ($allList as $qs) {
                        $tmp++;
                        // $time = date('m/d/Y H:i:s', $qs->date);

                        $delete = Yii::$app->urlManager->createUrl(['site/deleteqs', 'id' => $qs->id]);
                        if ($qs->status == 1) {
                            $active = 'class="danger"';
                            $star = "<i class='glyphicon glyphicon-star' style='font-size:20px; color:gold'>";
                        } else {
                            $active = '';
                            $activeChange = Yii::$app->urlManager->createUrl(['site/changeactive', 'id' => $qs->id]);
                            $star = "<i class='glyphicon glyphicon-star-empty' style='font-size:20px;'>";
                        }
                        echo <<<EOF
		<tr {$active}>
            <td>{$tmp}</td>
            <td>{$qs->user->username}</td>
            <td>{$qs->date}</td>
            <td>{$qs->question}</td>
            <td>{$star}</td>
            <td>{$qs->type}</td>
        </tr>
EOF;
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>