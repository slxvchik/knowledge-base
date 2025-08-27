<?php

namespace app\controllers;

use app\services\ContactService;
use app\services\DealService;
use app\services\ThemeProviderService;
use yii\web\Controller;

class SiteController extends Controller
{

    private ThemeProviderService $themeProviderService;

    public function __construct($id, $module, ThemeProviderService $themeProviderService, $config = []) {
        $this->themeProviderService = $themeProviderService;
        parent::__construct($id, $module, $config);
    }

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
    public function actionIndex(): string
    {

        $allThemes = $this->themeProviderService->getAllThemes();

        $themes = array();
        foreach ($allThemes as $type => $themeInfo) {
            $themes[$type] = [
                'name' => $this->getEntityTypeName($type),
                'items' => $themeInfo['items'],
                'ajaxUrl' => $themeInfo['ajaxUrl'],
            ];
        }

        return $this->render('index', [
            "themes" => $themes
        ]);
    }

    private function getEntityTypeName(string $type): string
    {
        $names = [
            'contact' => 'Контакты',
            'deal' => 'Сделки',
        ];

        return $names[$type] ?? ucfirst($type);
    }

}
