<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Json;

$this->title = 'My Knowledge system';

$themesJson = Json::encode($themes);

$js = <<<JS
(function($) {
    
    const themesData = $themesJson;
    
    let currentThemeKey = parseInt(Object.keys(themesData)[0]);
    let currentTheme = themesData[currentThemeKey];
    
    let currentSubThemeKey = parseInt(Object.keys(currentTheme)[0]);
    let currentSubTheme = currentTheme[currentSubThemeKey];
    
    function selectTheme(themeKey) {
        currentThemeKey = themeKey;
        currentTheme = themesData[themeKey];
        
        currentSubThemeKey = Object.keys(currentTheme)[0];
        currentSubTheme = currentTheme[currentSubThemeKey];
        
        updateUI();
        updateContent();
    }
    
    function selectSubtheme(subthemeKey) {
        currentSubThemeKey = subthemeKey;
        currentSubTheme = currentTheme[subthemeKey];
        
        updateUI();
        updateContent();
    }
    
    function updateUI() {
    
        $('.table__panel_item').removeClass('active');
        
        $('[data-theme="' + currentThemeKey + '"]').not('[data-subtheme]').addClass('active');
        
        $('[data-theme="' + currentThemeKey + '"][data-subtheme="' + currentSubThemeKey + '"]').addClass('active');
        
        $('#subthemes .table__panel_item').each(function() {
            if ($(this).data('theme') === currentThemeKey) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    function updateContent() {
        $('#content').text(currentSubTheme || '');
    }
    
    $(document).ready(function(){
        console.log('DOM ready');
        
        $('[data-theme]').not('[data-subtheme]').on('click', function() {
            selectTheme($(this).data('theme'));
        });
        
        $('[data-subtheme]').on('click', function() {
            selectSubtheme($(this).data('subtheme'));
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
                    <?php foreach ($themes as $themeNum => $subThemes): ?>
                    <li class="table__panel_item" data-theme="<?= Html::encode($themeNum); ?>">
                        <?= "Тема " . Html::encode($themeNum);?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="table__col">
                <h2>Подтема</h2>
                <ul class="table__panel" id="subthemes">
                    <?php foreach ($themes as $themeNum => $subThemes): ?>
                        <?php foreach ($subThemes as $subThemeNum => $content): ?>
                    <li class="table__panel_item" style="display: none" data-theme="<?= Html::encode($themeNum); ?>" data-subtheme="<?= Html::encode($subThemeNum); ?>">
                        <?= "Подтема " . Html::encode($subThemeNum); ?>
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
