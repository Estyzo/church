<?php

namespace app\controllers;

use app\components\RoleAccess;
use app\models\Contribution;
use app\models\ContributionsType;
use app\models\Dependant;
use app\models\Messages;
use app\models\Report;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ContributionSearch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index', 'report', 'export'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'report', 'export'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => static fn() => RoleAccess::hasAny(['admin', 'clerk', 'viewer']),
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $this->layout = 'mainnew';

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $searchModel = new ContributionSearch();
        $dataProvider = $searchModel->searchRecent();

        $washarika = User::find()->count();
        $tegemezi = Dependant::find()->count();
        $matoleo = Contribution::find()->count();
        $ainamatoleo = ContributionsType::find()->count();
        $ujumbe = Messages::find()->count();
        $yearStart = date('Y-01-01');
        $yearEnd = date('Y-12-31');
        $mapatoKwaMwaka = (float) (Contribution::find()
            ->andWhere(['between', 'date_of_payment', $yearStart, $yearEnd])
            ->sum('amount') ?? 0);



        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'washarika' => $washarika,
                'tegemezi' => $tegemezi,
                'matoleo' => $matoleo,
                'ainamatoleo' => $ainamatoleo,
                'ujumbe' => $ujumbe,
                'mapatoKwaMwaka' => $mapatoKwaMwaka
            ]
        );
    }

    /**
     * Login action.
     *
     * @return Response|string
     */



    public function actionLogin()
    {
        $this->layout = 'mainlogin';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // return $this->goBack();
            return $this->redirect('index');
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('login');
        //return $this->goHome();

    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    /**
     * Displays Report page.
     *
     * @return Response|string
     */
    public function actionReport()
    {
        $model = new Report();


        $contributionTypes = ContributionsType::find()
            ->select(['id', 'name'])
            ->orderBy('id')
            ->asArray()
            ->all();


        $selectParts = ["DATE(date_of_payment) AS date_of_payment"];
        foreach ($contributionTypes as $type) {
            $alias = preg_replace('/\s+/', '_', $type['name']); // replace spaces with _
            $selectParts[] = "SUM(CASE WHEN contribution_type_id = {$type['id']} THEN amount ELSE 0 END) AS `{$alias}`";
        }

        $sql = "
            SELECT " . implode(",\n", $selectParts) . "
            FROM contributions
            WHERE date_of_payment BETWEEN :start AND :end
            GROUP BY DATE(date_of_payment)
            ORDER BY date_of_payment ASC
        ";



        $provider = null;


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {


                $startDate = date('Y-m-d', strtotime($model->start_date));
                $endDate = date('Y-m-d', strtotime($model->end_date));


                $command = Yii::$app->db->createCommand($sql)
                    ->bindValue(':start', $startDate)
                    ->bindValue(':end', $endDate);

                $data = $command->queryAll();

                $provider = new \yii\data\ArrayDataProvider([
                    'allModels' => $data,
                    'pagination' => false,
                ]);

                $columns = [
                    ['attribute' => 'date_of_payment', 'label' => 'TAREHE'],
                ];


                foreach ($contributionTypes as $type) {
                    $columns[] = [
                        'attribute' => preg_replace('/\s+/', '_', $type['name']),
                        'label' => $type['name'],
                        'footer' => Yii::$app->formatter->asDecimal(array_sum(array_column($provider->allModels, preg_replace('/\s+/', '_', $type['name']))), 2),
                    ];
                }


                return $this->render('report', [
                    'model' => $model,
                    'provider' => $provider,
                    'columns' => $columns
                ]);

            }
        }

        return $this->render('report', [
            'model' => $model,
            'provider' => $provider
        ]);
    }
    public function actionExport()
    {
        // Disable layout and view rendering
        Yii::$app->controller->layout = false;
        Yii::$app->response->format = Response::FORMAT_RAW;

        // Increase limits if necessary
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        // Get dates from query params
        $startDate = Yii::$app->request->get('start_date');
        $endDate = Yii::$app->request->get('end_date');

        if (!$startDate || !$endDate) {
            throw new \yii\web\BadRequestHttpException("Start and end dates are required.");
        }

        // Format dates
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

        // Dynamic contribution types
        $contributionTypes = ContributionsType::find()
            ->select(['id', 'name'])
            ->orderBy('id')
            ->asArray()
            ->all();

        // Build select parts
        $selectParts = ["DATE(date_of_payment) AS date_of_payment"];
        foreach ($contributionTypes as $type) {
            $alias = preg_replace('/\s+/', '_', $type['name']);
            $selectParts[] = "SUM(CASE WHEN contribution_type_id = {$type['id']} THEN amount ELSE 0 END) AS `{$alias}`";
        }

        // Final SQL query
        $sql = "
        SELECT " . implode(", ", $selectParts) . "
        FROM contributions
        WHERE date_of_payment BETWEEN :start AND :end
        GROUP BY DATE(date_of_payment)
        ORDER BY date_of_payment ASC
    ";

        // Fetch data
        $rows = Yii::$app->db->createCommand($sql)
            ->bindValue(':start', $startDate)
            ->bindValue(':end', $endDate)
            ->queryAll();

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['TAREHE'];
        foreach ($contributionTypes as $type) {
            $headers[] = $type['name'];
        }
        $sheet->fromArray($headers, null, 'A1');

        // Populate rows
        $rowNum = 2;
        foreach ($rows as $row) {
            $line = [$row['date_of_payment']];
            foreach ($contributionTypes as $type) {
                $key = preg_replace('/\s+/', '_', $type['name']);
                $line[] = $row[$key] ?? 0;
            }
            $sheet->fromArray($line, null, 'A' . $rowNum++);
        }

        // Output file
        $filename = 'Contribution_Report.xls';

        // Clean output buffer to avoid corrupt Excel
        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new Xls($spreadsheet);
        $writer->save('php://output');

        Yii::$app->end(); // terminate cleanly



    }


}
