<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sort_position".
 *
 * @property int $id
 * @property int $user_id
 * @property string $post_id_position
 */
class SortPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sort_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id_position'], 'required'],
            [['user_id'], 'integer'],
            [['post_id_position'], 'string'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'post_id_position' => 'Post Id Position',
        ];
    }
}
