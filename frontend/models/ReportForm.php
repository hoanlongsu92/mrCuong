<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Question;
use frontend\models\Unit;

class ReportForm extends Model
{
    public $type;
	public $area;

    public function rules()
    {
        return [
            [['type','area'], 'required'],
        ];
    }
}
