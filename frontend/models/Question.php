<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "{{%question}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 * @property integer $status
 * @property string $question
 * @property string $type
 *
 * @property User $user
 */
class Question extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'date', 'status', 'question', 'type'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['question'], 'string'],
            [['type'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'status' => 'Status',
            'question' => 'Question',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
