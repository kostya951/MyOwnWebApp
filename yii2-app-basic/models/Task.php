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
        return 'TASK';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'completion', 'order', 'priority', 'status'], 'number'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['priority'], 'exist', 'skipOnError' => true, 'targetClass' => Priority::className(), 'targetAttribute' => ['priority' => 'id']],
            [['duration'],'number','min'=>1],
            [['parent'],'number']
        ];
    }


    public function behaviors()
    {
        return [
            'datetime' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'CREATED',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'LAST_UPDATED',
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
            'id' => 'id',
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
    public function getpriority()
    {
        return $this->hasOne(Priority::className(), ['id' => 'priority']);
    }

    /**
     * Gets query for [[TaskChildren]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskChildren()
    {
        return $this->hasMany(TaskChild::className(), ['TASK' => 'id']);
    }
    public function setUser($value){
        $this->user=$value;
    }
    public function getUser(){
        return $this->hasOne(TodoUser::className(),['user'=>'id']);
    }
}
