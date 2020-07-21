<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TASK_child".
 *
 * @property float $id
 * @property float $task
 * @property float $child
 *
 * @property Task $tASK
 */
class TaskChild extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'task', 'child'], 'number'],
            [['task', 'child'], 'required'],
            [['task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'task' => 'Task',
            'child' => 'Child',
        ];
    }

    /**
     * Gets query for [[task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function gettask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task']);
    }
}
