<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%answers}}".
 *
 * @property integer $id
 * @property integer $office_id
 * @property integer $question_id
 * @property integer $answer
 * @property string $time
 *
 * @property User $office
 * @property Question $question
 */
class Answers extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%answers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['office_id', 'question_id', 'answer', 'time'], 'required'],
            [['office_id', 'question_id', 'answer'], 'integer'],
            [['time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'office_id' => 'Office ID',
            'question_id' => 'Question ID',
            'answer' => 'Answer',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffice() {
        return $this->hasOne(User::className(), ['id' => 'office_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion() {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

}
