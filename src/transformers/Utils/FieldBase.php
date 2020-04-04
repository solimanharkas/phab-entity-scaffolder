<?php

namespace Phabalicious\Scaffolder\Transformers\Utils;

use Phabalicious\Method\TaskContextInterface;
use Phabalicious\Utilities\Utilities;
use Phabalicious\Scaffolder\Transformers\Utils\PlaceholderService;
use Phabalicious\Scaffolder\Transformers\Utils\EntityPropertyBase;
use Symfony\Component\Yaml\Yaml;

abstract class FieldBase extends EntityPropertyBase
{
    protected $entity_type;
    protected $data;
    protected $parent;

    protected function getFieldBaseType()
    {
        return explode('/', $this->data['type'])[0] ?? null;
    }

    protected function getFieldSubType()
    {
        return explode('/', $this->data['type'])[1] ?? 'default';
    }

    protected function getTemplateDir()
    {
        return __DIR__ . '/templates';
    }

    public function __construct($entity_type, $data, $parent)
    {
        $this->entity_type = $entity_type;
        $this->data = $data;
        $this->parent = $parent;
        $this->template = Yaml::parseFile($this->getTemplateFile());
        $config = Utilities::mergeData($this->template, $this->getTemplateOverrideData());
        $this->setConfig($config);
    }

    public function getFieldName()
    {
        // @TODO Check if field_ prefix can be dropped in D8 too.
        return 'field_' . $this->parent['id'] . '_' . $this->data['id'];
    }
}
