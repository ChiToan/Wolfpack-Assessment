<?php

namespace app\controllers;

use app\models\Wolf;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class WolfController
 * @package app\controllers
 */
class WolfController extends Controller
{
    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $wolves = Wolf::find()->all();
        if ($wolves === null) {
            throw new NotFoundHttpException("Wolf not found");
        }
        return $wolves;
    }

    /**
     * @param $id
     * @return Wolf
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $wolf = Wolf::findOne($id);
        if ($wolf === null) {
            throw new NotFoundHttpException("Wolf not found");
        }
        return $wolf;
    }


    /**
     * @return array
     * @throws BadRequestHttpException|InvalidConfigException
     */
    public function actionCreate()
    {
        $bodyParams = Yii::$app->request->getBodyParams();
        // Check if name is defined, otherwise cancel wolf creation
        if (!isset($bodyParams["name"])) {
            throw new BadRequestHttpException("Missing body parameter: 'name' not defined.");
        }
        $wolf = new Wolf();
        $wolf = $this->setWolfParams($wolf, $bodyParams);
        $wolf->save();
        return [
            'message' => $wolf,
            'code' => 201
        ];
    }

    /**
     * @param Wolf $wolf
     * @param array $bodyParams
     * @return Wolf
     * @throws InvalidConfigException
     */
    private function setWolfParams(Wolf $wolf, array $bodyParams)
    {
        if (isset($bodyParams["name"])) {
            $wolf->name = $bodyParams["name"];
        }
        if (isset($bodyParams["gender"])) {
            $wolf->gender = $bodyParams["gender"];
        }
        if (isset($bodyParams["birthdate"])) {
            $wolf->birthdate = Yii::$app->formatter->asDate($bodyParams["birthdate"]);
        }
        // Round latitude and longitude to 6 decimal places
        if (isset($bodyParams["latitude"])) {
            $wolf->latitude = number_format($bodyParams["latitude"], 6);
        }
        if (isset($bodyParams["longitude"])) {
            $wolf->longitude = number_format($bodyParams["longitude"], 6);
        }
        return $wolf;
    }

    /**
     * @param $id
     * @return Wolf
     * @throws NotFoundHttpException|InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $wolf = Wolf::findOne($id);
        if ($wolf == null) {
            throw new NotFoundHttpException("Wolf not found");
        }

        $bodyParams = Yii::$app->request->getBodyParams();
        $wolf = $this->setWolfParams($wolf, $bodyParams);
        $wolf->save();
        return $wolf;
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $wolf = Wolf::findOne($id);
        if ($wolf == null) {
            throw new NotFoundHttpException("Wolf not found");
        }
        $wolf->delete();
        return [
            'message' => 'Wolf successfully deleted',
            'code' => 204,
        ];

    }
}