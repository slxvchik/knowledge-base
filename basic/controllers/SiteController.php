<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $themes = array();
        for ($themeNum = 1; $themeNum < 11; $themeNum++) {
            for($subThemeNum = 1; $subThemeNum <= 10; $subThemeNum++){
                $themes[$themeNum][$subThemeNum] = "Some text linked to the Subtheme " . $themeNum . "." . $subThemeNum;
            }
        }
        return $this->render('index', [
            "themes" => $themes
        ]);
    }

}
