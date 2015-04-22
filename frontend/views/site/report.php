<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Question;
use frontend\models\Answers;

$this->title = 'Report';
$this->params['breadcrumbs'][] = $this->title;
$list = [];
$lable = [];
$series = [];
$emotion = ['Very Happy', 'Happy', 'Boring', 'Sad'];
foreach ($office as $of) {
    $list[$of->id] = $of->username;
}
if (!is_null($model->area)) {
    $qsid = [];
    $indexs = [];
    $datas = Question::find()->where(['status' => 1])->where(['IN', 'user_id', $model->area])->all();
    /* @var $datas Question[] */
    foreach ($datas as $data) {
        $qsid[] = $data->id;
    }
    $ansdatas = Answers::find()->where(['IN', 'question_id', $qsid])->all();
    /* @var $ansdatas Answers[] */
    $index = 0;

    foreach ($ansdatas as $ans) {
        $time = strtotime($ans->time);
        switch ($model->type) {
            case 'byday':
                $day = date('j', $time);
                break;
            case 'byhour':
                $day = date('h A', $time);
                break;
            case 'byweek':
                $day = date('l', $time);
                break;
            default :
                $day = date('j', $time);
                break;
        }

        if (!in_array($day, $lable)) {
            $lable[$index] = $day;
            $indexs[$day] = $index;
            $index ++;
        }
        sort($lable);
        if (!isset($series[$ans->answer - 1])) {
            $series[$ans->answer - 1] = ['name' => $emotion[$ans->answer - 1], 'data' => []];
        }
        if (!isset($series[$ans->answer - 1]['data'][$indexs[$day]])) {
            $series[$ans->answer - 1]['data'][$indexs[$day]] = 0;
        }
        $series[$ans->answer - 1]['data'][$indexs[$day]] ++;
    }
    for ($j = 0; $j < 4; $j++) {
        for ($i = 0; $i < $index; $i++) {
            if (!isset($series[$j])) {
                $series[$j] = ['name' => 'answer ' . $j, 'data' => []];
            }
            if (!isset($series[$j]['data'][$i])) {
                $series[$j]['data'][$i] = 0;
            }
        }
        ksort($series[$j]['data']);
    }
}

//foreach ($series as $sr) {
//    var_dump($sr['data']);
//    foreach ($lable as $lb) {
//        if (in_array($lb, $sr['data'])) {
//            echo $lb . ' ';
//        }
//    }
//    echo '</br>';
//}
//
//var_dump($lable);
//echo '</br>';
//var_dump($series);
//foreach ($ansdatas as $ans){
//    $time=strtotime($ans->time);
//    $day= date('j',$time);
//    if(!in_array($day,$lable)){
//        $lable[$index]=$day;
//        $indexs[$day]=$index;
//        $index ++;
//    }
//    if(!isset($series[$ans->answer-1])){
//        $series[$ans->answer-1]=['name'=>'answer '.$ans->answer,'data'=>[]];
//    }
//    if(!isset($series[$ans->answer-1]['data'][ $indexs[$day]])){
//        $series[$ans->answer-1]['data'][ $indexs[$day]] = 0;
//    }
//    $series[$ans->answer-1]['data'][ $indexs[$day]]++;
//}
?>
<div class="col-lg-3">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Option
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'report-form']); ?>
            <?php echo $form->field($model, 'type')->dropDownList(['byhour' => 'Group by hour', 'byday' => 'Group by day of month', 'byweek' => 'Group by day of week']); ?>
            <?php echo $form->field($model, 'area')->checkboxList($list) ?>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'report-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<div class="col-lg-9">
<?php
echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    'options' => [
        'chart' => [
            'type' => 'column'
        ],
        'title' => [
            'text' => 'Emotional  column chart',
        ],
        'xAxis' => [
            'categories' => $lable,
        ],
        'yAxis' => [
            'min' => 0,
            'title' => [
                'text' => 'Total person consider',
            ],
            'stackLabels' => [
                'enabled' => true,
                'style' => [
                    'fontWeight' => 'bold',
                    'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "gray"'),
                ],
            ],
        ],
        'legend' => [
            'align' => 'right',
            'x' => -30,
            'verticalAlign' => 'top',
            'y' => 25,
            'floating' => true,
            'backgroundColor' => new JsExpression('(Highcharts.theme && Highcharts.theme.background2) || "while"'),
            'borderColor' => '#CCC',
            'borderWidth' => 1,
            'shadow' => false,
        ],
        'tooltip' => [
            'formatter' => new JsExpression('function(){ return "<b>" + this.x + "</b><br/>" + this.series.name + ": " + this.y + "<br/>" + "Total: " + this.point.stackTotal; }'),
        ],
        'plotOptions' => [
            'column' => [
                'stacking' => 'nomal',
                'dataLabels' => [
                    'enabled' => true,
                    'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "while"'),
                    'style' => [
                        'textShadow' => '0 0 0px',
                    ],
                ],
            ],
        ],
        'series' => $series,
    ]
]);
?>	
</div>

