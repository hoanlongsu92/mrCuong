<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\QuestionForm;
use frontend\models\ReportForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Question;
use frontend\models\Unit;
use common\models\User;
use frontend\models\Answers;
use yii\base\Model;

/**
 * Site controller
 */
class SiteController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
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

    public function actionIndex() {
        if (!\Yii::$app->user->isGuest) {
            return $this->render('dashboard');
        } else {
            return $this->render('index');
        }
    }

    public function actionNewqs() {
        $model = new QuestionForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'New question updated!');
            }
            return $this->refresh();
        } else {
            return $this->render('question', [
                        'model' => $model,
            ]);
        }
    }

    public function actionQsmng() {
        if (Unit::IsGlobal(Yii::$app->user->identity->id)) {
            return $this->redirect(['site/global-qs-mng']);
        } else {
            return $this->redirect(['site/office-qs-mng', 'id' => Yii::$app->user->identity->id]);
        }
    }

    public function actionColectAnswers() {
        if ((isset($_REQUEST['data'])) && (!empty($_REQUEST['data']))) {
            $rs = json_encode($_REQUEST['data']);
            echo $rs;
        } else {
            $rs = [
                'Result' => false,
                'Message' => 'No data',
            ];
            echo json_encode($rs);
        }        
    }

    public function actionGlobalQsMng() {
        $qsList = Question::find()
                ->orderBy('id DESC')
                ->all();
        return $this->render('qsmng', ['qsList' => $qsList]);
    }

    public function actionReport() {
        $office = User::find()->all();
        $model = new ReportForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('report', [
                        'model' => $model,
                        'office' => $office,
            ]);
        } else {
            return $this->render('report', [
                        'model' => $model,
                        'office' => $office,
            ]);
        }
    }

    public function actionOfficeQsMng($id) {
        $allList = Question::find()
                ->where(['user_id' => 1])
                ->orderBy('id ASC')
                ->all();

        $qsList = Question::find()
                ->where(['user_id' => $id])
                ->orderBy('id DESC')
                ->all();
        return $this->render('ofqsmng', ['qsList' => $qsList, 'allList' => $allList]);
    }

    public function actionRegister() {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $user = User::find()->where(['username' => $username])->one();
        if (!is_null($user)) {
            $rs = array(
                'Result' => false,
                'Message' => 'user exist',);
        } else {
            $newUser = new User();
            $newUser->username = $username;
            $newUser->setPassword($password);
            $newUser->generateAuthKey();
            $newUser->save();

            $globalQs = Question::find()->where(['type' => 'global', 'status' => 1])->one();
            $rs = array(
                'Result' => true,
                'Message' => '',
                'Questions' => [
                    ['ServerId' => $globalQs->id, 'Question' => $globalQs->question, 'Type' => $globalQs->type]
                ],
                'Profile' => [
                    'ServerId' => User::find()->where(['username' => $username])->one()->id,
                    'UserName' => $username,
                    'PassWord' => $password,
                ],
            );
        }
        echo json_encode($rs);
    }

    public function actionDeleteqs($id) {
        $qs = Question::find()->where(['id' => $id])->one()->delete();
        return $this->redirect(['site/qsmng']);
    }

    public function actionGetQuestion() {
        $userid = $_REQUEST['userid'];
        $globalQs = Question::find()->where(['type' => 'global', 'status' => 1])->one();
        $officeQs = Question::find()->where(['user_id' => $userid, 'status' => 1])->one();
        $rs = [
            'Result' => true,
            'Questions' => [
                ['ServerId' => $globalQs->id, 'Question' => $globalQs->question, 'type' => $globalQs->type],
                ['ServerId' => $officeQs->id, 'Question' => $officeQs->question, 'type' => $officeQs->type],
            ],
        ];
        echo json_encode($rs);
    }

    public function actionCreateSampleData($user_id, $question_id) {
        $numberOfRecord = mt_rand(200, 500);
        for ($i = 1; $i < $numberOfRecord; $i++) {
            $aw = new Answers();
            $aw->office_id = $user_id;
            $aw->question_id = $question_id;
            $aw->answer = mt_rand(1, 4);
            $aw->time = date('Y-m-d H:i:s', strtotime('+' . mt_rand(-90, 90) . ' days ' . mt_rand(2, 13) . 'Hours ' . mt_rand(0, 60) . 'Minutes'));
            if ($aw->save(0)) {
                echo json_encode(array(
                    'office_id' => $aw->office_id,
                    'question_id' => $aw->question_id,
                    'answer' => $aw->answer,
                    'time' => $aw->time,
                ));
            }
        }
    }

    public function actionGetactivequestion() {
        $acQs = Question::find()->where(['status' => 1])->one();
        if (!is_null($acQs)) {
            $rs = array(
                'success' => true,
                'question' => $acQs->question,
                'question_id' => $acQs->id,
            );
        } else {
            $rs = array('success' => FALSE,);
        }
        echo json_encode($rs);
    }

    public function actionChangeactive($id) {
        $currentAc = Question::find()->where(['status' => 1, 'user_id' => Yii::$app->user->identity->id])->all();
        if (count($currentAc) > 0) {
            foreach ($currentAc as $cr) {
                $cr->status = 0;
                $cr->update();
            }
        }
        $ac = Question::find()->where(['id' => $id])->one();
        $ac->status = 1;
        $ac->update();
        return $this->redirect(['site/qsmng']);
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
