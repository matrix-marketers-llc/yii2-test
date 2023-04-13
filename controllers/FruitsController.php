<?php

namespace app\controllers;

use Yii;
use yii\base\Request;
use yii\web\Controller;
use app\models\Fruits;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class FruitsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','favorite','fav','unfavorite'],
                        'roles' => ['@','*','?'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Fruits::find();

        $name = isset($_GET['Fruits']['name']) ? $_GET['Fruits']['name'] : null;
        if ($name) {
            $query->andWhere(['like', 'name', $name]);
        }
    
        $family = isset($_GET['Fruits']['family']) ? $_GET['Fruits']['family'] : null;
        if ($family) {
            $query->andWhere(['like', 'family', $family]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'name' => $name,
            'family' => $family,
        ]);
    }

    public function actionFavorite($id)
    {
        $model = $this->findModel($id);
    
        $favoriteFruits = Fruits::find()->where(['is_favorite' => true])->count();
        if ($favoriteFruits >= 10) {
            Yii::$app->session->setFlash('error', 'You can only add up to 10 fruits to your favorites list.');
        } else if ($model->is_favorite) {
            Yii::$app->session->setFlash('error', 'This fruit is already in your favorites list.');
        } else {
            $model->is_favorite = true;
            $model->save();
            Yii::$app->session->setFlash('success', 'Fruit added to favorites successfully!');
        }
        
        return $this->redirect(['index']);
    }

    public function actionUnfavorite($id)
    {
        $model = $this->findModel($id);
        
        if (!$model->is_favorite) {
            Yii::$app->session->setFlash('error', 'This fruit is not in your favorites list.');
        } else {
            $model->is_favorite = false;
            $model->save();
            Yii::$app->session->setFlash('success', 'Fruit removed from favorites successfully!');
        }
            
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Fruits::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionFav()
    {
        $favoriteFruits = Fruits::find()->where(['is_favorite' => true])->all();
        return $this->render('favorites', [
            'favoriteFruits' => $favoriteFruits,
        ]);
    }


}
