<?php

namespace app\services;

use app\interfaces\DisplayableThemeInterface;
use app\interfaces\ThemeServiceInterface;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;

class ThemeProviderService
{
    /***
     * @var ThemeServiceInterface[]
     */
    private array $entityServices;

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function __construct()
    {
        $container = Yii::$container;
        $this->entityServices = [
            'contact' => $container->get(ContactService::class),
            'deal' => $container->get(DealService::class),
        ];

        foreach ($this->entityServices as $type => $service) {
            if (!$service instanceof ThemeServiceInterface) {
                throw new InvalidArgumentException('Service for ' . $type . ' must implement ThemeServiceInterface');
            }
        }
    }

    public function getEntitiesByType(string $type): array
    {
        if (!isset($this->entityServices[$type])) {
            throw new InvalidArgumentException("Unknown entity type: $type");
        }

        $entities = $this->entityServices[$type]->getAll();

        return array_map(function (DisplayableThemeInterface $entity) {
            return [
                'id' => $entity->getId(),
                'label' => $entity->getLabel(),
                'type' => $entity->getType()
            ];
        }, $entities);
    }

    public function getAllThemes(): array
    {
        $result = array();
        foreach ($this->entityServices as $type => $service) {
            $result[$type] = [
                'items' => $this->getEntitiesByType($type),
                'ajaxUrl' => $this->getAjaxUrlByType($type),
            ];
        }
        return $result;
    }

    public function getThemeServices(): array
    {
        return $this->entityServices;
    }

    public function getAjaxUrlByType(string $type): string
    {
        if (!isset($this->entityServices[$type])) {
            throw new InvalidArgumentException("Unknown entity type: $type");
        }

        return $this->entityServices[$type]->getAjaxUrl();
    }
}