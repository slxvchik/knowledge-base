<?php

namespace app\interfaces;

interface DisplayableThemeInterface
{
    function getId();
    function getLabel(): string;
    function getType(): string;
}