<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\ResetPasswordForm;
use app\models\SystemUser;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class SystemUserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['change-password'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'create', 'update', 'delete', 'reset-password'],
                        'matchCallback' => static function () {
                            $identity = \Yii::$app->user->identity;
                            return $identity && isset($identity->role) && $identity->role === 'admin';
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SystemUser::find()->with('center')->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new SystemUser();
        $model->scenario = 'create';

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ((int)\Yii::$app->user->id === (int)$model->id) {
            \Yii::$app->session->setFlash('error', 'You cannot delete your own account.');
            return $this->redirect(['index']);
        }

        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        if ($model->load(\Yii::$app->request->post()) && $model->change()) {
            \Yii::$app->session->setFlash('success', 'Password changed successfully.');
            return $this->redirect(['/site/index']);
        }

        return $this->render('change-password', ['model' => $model]);
    }

    public function actionResetPassword($id)
    {
        $user = $this->findModel($id);
        if ((int)\Yii::$app->user->id === (int)$user->id) {
            throw new ForbiddenHttpException('Use "Change Password" to update your own password.');
        }

        $form = new ResetPasswordForm();
        if ($form->load(\Yii::$app->request->post()) && $form->apply($user)) {
            \Yii::$app->session->setFlash('success', 'Password reset successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('reset-password', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    protected function findModel($id): SystemUser
    {
        $model = SystemUser::findOne((int)$id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
