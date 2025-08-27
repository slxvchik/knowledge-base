<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Json;

$this->title = 'My Knowledge system';

$themesJson = Json::encode($themes);

$js = <<<JS
(function($) {
    
    const themesData = $themesJson;
    
    let currentThemeKey = Object.keys(themesData)[0];
    let currentTheme = themesData[currentThemeKey];
    
    let currentSubTheme = Object.keys(currentTheme['items'])[0];
    
    function selectTheme(themeKey) {
        currentThemeKey = themeKey;
        currentTheme = themesData[themeKey];
        
        currentSubTheme = Object.keys(currentTheme['items'])[0];
        
        updateUI();
        updateContent();
    }
    
    function selectSubtheme(subthemeKey) {
        
        currentSubTheme = subthemeKey;
        
        updateUI();
        updateContent();
    }
    
    function updateUI() {
    
        $('.table__panel_item').removeClass('active');
        
        $('[data-theme="' + currentThemeKey + '"]').not('[data-subtheme-key]').addClass('active');
        
        $('[data-theme="' + currentThemeKey + '"][data-subtheme-key="' + currentSubTheme + '"]').addClass('active');

        $('#subthemes .table__panel_item').each(function() {
            if ($(this).data('theme') === currentThemeKey) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    let currentAjaxRequest = null;
    
    function updateContent() {
        let ajaxUrl = $('[data-theme="' + currentThemeKey + '"][data-subtheme-key="' + currentSubTheme + '"]').data('ajax');
        
        if (currentAjaxRequest) {
            currentAjaxRequest.abort();
        }

        currentAjaxRequest = $.ajax({
            url: ajaxUrl,
            type: 'GET',
            success: function(response) {
                $('#content').html(response);
                console.log(response);
            }
        });
    }
    
    $(document).ready(function(){
        
        $('[data-theme]').not('[data-subtheme]').on('click', function() {
            selectTheme($(this).data('theme'));
        });
        
        $('[data-subtheme-key]').on('click', function() {
            selectSubtheme($(this).data('subtheme-key'));
        });
        
        updateUI();
        updateContent();
    });
})(jQuery);

JS;

$this->registerJs($js);

?>
<div class="site-index">

    <div class="body-content">
        <div class="table">

            <div class="table__col">
                <h2>Тема</h2>
                <ul class="table__panel" id="themes">
                    <?php foreach ($themes as $themeId => $themeInfo): ?>
                    <li class="table__panel_item" data-ajax="<?= Html::encode($themeInfo['ajaxUrl']); ?>" data-theme="<?= Html::encode($themeId); ?>">
                        <?= Html::encode($themeInfo['name']); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="table__col">
                <h2>Подтема</h2>
                <ul class="table__panel" id="subthemes">
                    <?php foreach ($themes as $themeId => $themeInfo): ?>
                        <?php foreach ($themeInfo['items'] as $itemKey => $item): ?>
                    <li class="table__panel_item" data-ajax="<?= Html::encode($themeInfo['ajaxUrl'] . '/' . $item['id']); ?>"  data-theme="<?= Html::encode($themeId); ?>" data-subtheme-key="<?= Html::encode($itemKey); ?>">
                        <?= Html::encode($item['label']); ?>
                    </li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="table__col">
                <h2>Содержание</h2>
                <div class="table__text" id="content">
                </div>
            </div>

        </div>

    </div>
</div>
