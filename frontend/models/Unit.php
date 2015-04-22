<?php

namespace frontend\models;

use Yii;
use common\models\User;

class Unit{
    public function IsGlobal($id)
    {
    	if(Yii::$app->user->identity->id == 1){
    		return true;
    	}
        return FALSE;
    }
}
