<?php

namespace app\controllers;

use app\models\Wolf;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
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
     * View list of all wolves
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $wolves = Wolf::find()->all();
        if ($wolves === []) {
            throw new NotFoundHttpException("No wolves found");
        }
        return $wolves;
    }

    /**
     * View specific wolf
     *
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
     * Create a new model with name
     * other attributes are optional
     *
     * @return Wolf
     * @throws BadRequestHttpException|InvalidConfigException
     */
    public function actionCreate()
    {
        $bodyParams = Yii::$app->request->getBodyParams();
        // Check if name is defined, otherwise cancel wolf creation
        if (empty($bodyParams["name"])) {
            throw new BadRequestHttpException("Missing body parameter: 'name' is empty.");
        }
        $wolf = new Wolf();
        $wolf = $this->setWolfParams($wolf, $bodyParams);
        $wolf->save();
        return $wolf;
    }

    /**
     * Apply all the request body parameters to the model
     *
     * @param Wolf $wolf
     * @param array $bodyParams
     * @return Wolf
     * @throws InvalidConfigException
     */
    private function setWolfParams(Wolf $wolf, array $bodyParams)
    {
        if (!empty($bodyParams["name"])) {
            $wolf->name = $bodyParams["name"];
        }
        if (!empty($bodyParams["gender"])) {
            $wolf->gender = $bodyParams["gender"];
        }
        if (!empty($bodyParams["birthdate"])) {
            $wolf->birthdate = Yii::$app->formatter->asDate($bodyParams["birthdate"]);
        }
        // Round latitude and longitude to 6 decimal places
        if (!empty($bodyParams["latitude"])) {
            $wolf->latitude = number_format($bodyParams["latitude"], 6);
        }
        if (!empty($bodyParams["longitude"])) {
            $wolf->longitude = number_format($bodyParams["longitude"], 6);
        }
        return $wolf;
    }

    /**
     * Update existing wolf
     *
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
     * Delete existing wolf
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
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