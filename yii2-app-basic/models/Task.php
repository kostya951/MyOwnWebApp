<?php

namespace app\models;

use omnilight\datetime\DateTimeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "TASK".
 *
 * @property float $id
 * @property string $name
 * @property string|null $description
 * @property float|null $parent
 * @property float $completion
 * @property float|null $order
 * @property float $priority
 * @property float $status
 *
 * @property Priority $pRIORITY
 * @property TaskChild[] $taskChildren
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'completion', 'order', 'priority', 'status'], 'number'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['duration'],'number','min'=>1],
        ];
    }


    public function behaviors()
    {
        return [
            'datetime' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'last_updated',
                ],
                'value' => function() { return date('d.m.yy H:i:s'); },
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Name',
            'description' => 'Description',
            'parent' => 'Parent',
            'completion' => 'Completion',
            'order' => 'Order',
            'priority' => 'Priority',
            'status' => 'Status',
            'duration'=>'Duration'
        ];
    }

    /**
     * Gets query for [[priority]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPriority()
    {
        return $this->hasOne(Priority::className(), ['id' => 'priority'])->one();
    }

    public function setUser($value){
        $this->user=$value;
    }
    public function getUser(){
        return $this->hasOne(TodoUser::className(),['user'=>'id']);
    }
}
