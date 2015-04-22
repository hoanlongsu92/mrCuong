<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Question;
use frontend\models\Unit;

class QuestionForm extends Model
{
    public $question;

    public function rules()
    {
        return [
            [['question'], 'required'],
        ];
    }
	
    public function save()
    {
    	if(Unit::IsGlobal(Yii::$app->user->identity->id)){
            $type='global';
	    $currentAc = Question::find()->where(['status' => 1])->all();
            if(count($currentAc)!=0){
		foreach ($currentAc as $cr) {
                    $cr->status = 0;
                    $cr->update();
		}			
            }
	}
        else{
            $type = 'office';
            $currentAc = Question::find()->where(['status' => 1,'user_id'=>Yii::$app->user->identity->id])->all();
            if(count($currentAc)!=0){
                foreach ($currentAc as $cr) {
                    $cr->status = 0;
                    $cr->update();
                }			
            }			
        }
		
        $date = date('Y-m-d H:i:s');
        $qs = new Question();
        $qs->question = $this->question;
        $qs->user_id = Yii::$app->user->identity->id;
        $qs->date =  $date;
        $qs->status = 1;
        $qs->type = $type;
       	if($qs->save(0)){
            return true;	
       	}
    }
}
