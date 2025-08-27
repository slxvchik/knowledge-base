<?php

namespace app\interfaces;

interface ThemeServiceInterface
{
    /***
     * @return DisplayableThemeInterface[]
     */
    public function getAll(): array;
    public function getAjaxUrl(): string;
}