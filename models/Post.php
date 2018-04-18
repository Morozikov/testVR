<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id'], 'integer'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'body' => 'Body',
        ];
    }


    public static function getPostsByUserId($user_id)
    {
        $arrayPost = array();
        $model = self::findAll(['user_id'=>$user_id]);
        if(isset($model)){
            foreach ($model as $model) {
                $arrayPost[$model->id] = ['content'=>'<div><a href="'.Url::toRoute(['post/update','id'=>$model->id]).'"><h4>'.$model->title.'</h4></a><div>'.$model->body.'</div><button type="button" onclick="isDel(event)" data-post_id="'.$model->id.'" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i> Удалить</button></div>'];
            }
        }
        return $arrayPost;
    }
}
