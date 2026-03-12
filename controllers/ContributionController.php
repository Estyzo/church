<?php

namespace app\controllers;

use app\components\RoleAccess;
use Yii;
use app\models\Contribution;
use app\models\ContributionSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


/**
 * ContributionController implements the CRUD actions for Contribution model.
 */
class ContributionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'view'],
                        'matchCallback' => static fn() => RoleAccess::hasAny(['admin', 'clerk', 'viewer']),
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['create', 'contribution', 'update', 'delete'],
                        'matchCallback' => static fn() => RoleAccess::hasAny(['admin', 'clerk']),
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

    /**
     * Lists all Contribution models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ContributionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contribution model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Contribution model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContribution($id)
    {
        $paymentType = Contribution::paymentModeOptions();
        $paymentChannel = Contribution::paymentModeOptions();
        $member = $this->findUserModel($id);

        $model = new Contribution([
            'user_id' => $member->id,
        ]);
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->user_id = $id;
            $model->created_by = Yii::$app->user->id;
            $model->save();
            return $this->redirect(['user/view', 'id' => $id]);
        }

        return $this->render('create', array_merge([
            'model' => $model,
            'paymentType' => $paymentType,
            'paymentChannel' => $paymentChannel,
        ], $this->buildMemberFormOptions($member)));
    }

    /**
     * Creates a new Contribution model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Contribution();

        $paymentType = Contribution::paymentModeOptions();
        $paymentChannel = Contribution::paymentModeOptions();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->created_by = Yii::$app->user->id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', array_merge([
            'model' => $model,
            'paymentType' => $paymentType,
            'paymentChannel' => $paymentChannel,
        ], $this->buildMemberFormOptions()));
    }

    /**
     * Updates an existing Contribution model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $paymentType = Contribution::paymentModeOptions();
        $paymentChannel = Contribution::paymentModeOptions();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', array_merge([
            'model' => $model,
            'paymentType' => $paymentType,
            'paymentChannel' => $paymentChannel,
        ], $this->buildMemberFormOptions()));
    }

    /**
     * Deletes an existing Contribution model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Contribution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Contribution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contribution::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Ukurasa ulioombwa haupo.');
    }

    protected function findUserModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Msharika aliyeombwa hapatikani.');
    }

    private function buildMemberFormOptions(?User $lockedMember = null): array
    {
        $members = $lockedMember !== null
            ? [$lockedMember]
            : User::find()
                ->orderBy([
                    'first_name' => SORT_ASC,
                    'middle_name' => SORT_ASC,
                    'last_name' => SORT_ASC,
                ])
                ->all();

        $userOptions = [];
        $userDesignations = [];

        foreach ($members as $member) {
            $fullName = trim(implode(' ', array_filter([
                $member->first_name,
                $member->middle_name,
                $member->last_name,
            ])));

            $userOptions[$member->id] = $fullName !== '' ? $fullName : 'Msharika #' . $member->id;
            $userDesignations[$member->id] = $member->designation_designation ?: 'Haijawekwa';
        }

        return [
            'userOptions' => $userOptions,
            'userDesignations' => $userDesignations,
            'lockUser' => $lockedMember !== null,
            'selectedUserName' => $lockedMember !== null ? ($userOptions[$lockedMember->id] ?? '') : null,
        ];
    }
}
