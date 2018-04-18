<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\filters\AccessControl;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SortPosition;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'update', 'delete','index','create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'update', 'delete','index','create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
           $model->user_id = Yii::$app->user->id;
           $model->save();
           $modelSortPosition = SortPosition::findOne(['user_id'=>Yii::$app->user->id]);
           if(isset($modelSortPosition)){
            $modelSortPosition->post_id_position = strval($modelSortPosition->post_id_position).','.$model->id; 
           }
           else {
            $modelSortPosition = new SortPosition();
            $modelSortPosition->user_id = Yii::$app->user->id;
            $modelSortPosition->post_id_position = strval($model->id);
           }
           $modelSortPosition->save();
          
           return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $id = $_POST['post'];
        $this->findModel($id)->delete();
        $modelSortPosition = SortPosition::findOne(['user_id'=>Yii::$app->user->id]);
        if(isset($modelSortPosition)){
            $positions = $modelSortPosition->post_id_position;
            $array = explode(',', $positions);
            $key = array_search($id, $array);
            unset($array[$key]);
            $positions = implode(',', $array);
            $modelSortPosition->post_id_position = $positions;
            $modelSortPosition->save();

        }


        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangePostPosition(){
        $model = SortPosition::findOne(['user_id'=>Yii::$app->user->id]);
        if(isset($model)){
            $model->post_id_position = $_POST['position']; 
            $model->save();
        }
    }
}
