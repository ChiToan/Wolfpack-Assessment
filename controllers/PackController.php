<?php

namespace app\controllers;

use app\models\Pack;
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
class PackController extends Controller
{
    /**
     * View list of all packs
     *
     * @return array of packs
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $packs = Pack::find()->all();
        if ($packs === []) {
            throw new NotFoundHttpException("No packs found");
        }
        $view = array();
        foreach ($packs as $pack) {
            array_push($view, $this->createPackView($pack));
        }
        return $view;
    }

    /**
     * Create a view for a pack containing its wolves
     *
     * @param Pack $pack
     * @return array of the pack
     */
    private function createPackView(Pack $pack)
    {
        $wolves = $pack->getWolves()->select(['id', 'name'])->all();
        return [
            'id' => $pack->id,
            'name' => $pack->name,
            'wolves' => $wolves
        ];
    }

    /**
     * View specific pack
     *
     * @param $id
     * @return array of a pack
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $pack = Pack::findOne($id);
        if ($pack === null) {
            throw new NotFoundHttpException("Pack not found");
        }
        return $this->createPackView($pack);
    }

    /**
     * Create a new pack, with one or more wolves
     *
     * @return array
     * @throws BadRequestHttpException|InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $bodyParams = Yii::$app->request->getBodyParams();
        $pack = new Pack();
        // Check if name is defined, otherwise cancel pack creation
        if (empty($bodyParams["name"])) {
            throw new BadRequestHttpException("Missing body parameter: 'name' is empty.");
        } else {
            $pack->name = $bodyParams["name"];
        }
        if (empty($bodyParams["wolves"])) {
            throw new BadRequestHttpException("Missing body parameter: 'wolves' is empty.");
        }
        // Validate the wolves before creating database entry to be able to link the pack with the wolves
        $validWolves = $this->validateWolves($bodyParams["wolves"]);
        if ($validWolves) {
            $pack->save();
            foreach ($validWolves as $wolf) {
                Wolf::findOne($wolf)->link('packs', $pack);
            }
        }
        return $this->createPackView($pack);
    }

    /**
     * Check if the wolves of the given ids are existing
     *
     * @param $wolfIDs
     * @return false|string[]
     * @throws NotFoundHttpException
     */
    private function validateWolves($wolfIDs)
    {
        $wolfIDs = explode(",", $wolfIDs);
        foreach ($wolfIDs as $wolf) {
            if (Wolf::findOne($wolf) === null) {
                throw new NotFoundHttpException("Wolf with id " . $wolf . " does not exist!");
            }
        }
        return $wolfIDs;
    }


    /**
     * Modify a preexisting pack
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException|InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $pack = Pack::findOne($id);
        if ($pack == null) {
            throw new NotFoundHttpException("Pack not found");
        }

        $bodyParams = Yii::$app->request->getBodyParams();
        if (!empty($bodyParams["name"])) {
            $pack->name = $bodyParams["name"];
        }
        if (!empty($bodyParams["wolves"])) {
            $validWolves = $this->validateWolves($bodyParams["wolves"]);
            if ($validWolves) {
                foreach ($validWolves as $wolf) {
                    Wolf::findOne($wolf)->link('packs', $pack);
                }
            }
        }
        $pack->save();
        return $this->createPackView($pack);
    }

    /**
     * Delete pack
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     * @throws StaleObjectException|Throwable
     */
    public function actionDelete($id)
    {
        $pack = Pack::findOne($id);
        if ($pack == null) {
            throw new NotFoundHttpException("Pack not found");
        }
        $pack->delete();
        return [
            'message' => 'Pack successfully deleted',
            'code' => 204,
        ];

    }
}