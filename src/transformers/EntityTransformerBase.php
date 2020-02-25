<?php

namespace Phabalicious\Scaffolder\Transformers;

use Phabalicious\Method\TaskContextInterface;
use Phabalicious\Utilities\Utilities;

abstract class EntityTransformerBase extends EntityScaffolderTransformerBase
{
    const ENTITY_NAME = '???';

    public function transform(TaskContextInterface $context, array $files): array
    {
        $results = [];
        foreach ($this->iterateOverFiles($context, $files) as $data) {
            $result = Utilities::mergeData($this->template, $this->getTemplateOverrideData($data));
            $results[$this->getTemplateFileName($data['id'])] = $result;
            $results += $this->transformFields($data);
        }
        $this->postTransform($results);
        return $this->asYamlFiles($results);
    }

    protected function transformFields($data) {
        $field_configs = [];
        if (!empty($data['fields'])) {
            $weight = 0;
            foreach ($data['fields'] as $key => $field) {
                $field['id'] = $key;
                $weight++;
                if (empty($field['weight'])) {
                    $field['weight'] = $weight;
                }
                $fieldStorageTransformer = new FieldStorageTransformer($this::ENTITY_NAME, $field, $data);
                $field_configs += $fieldStorageTransformer->transformDependend();
                $fieldFieldTransformer = new FieldFieldTransformer($this::ENTITY_NAME, $field, $data);
                $field_configs += $fieldFieldTransformer->transformDependend();
            }
        }
        return $field_configs;
    }

    protected function getTemplateOverrideData($data = []) 
    {
        $out = [];

        $manddatory_keys_map = [
            'id' => 'id',
            'label' => 'label',
        ];

        foreach($manddatory_keys_map as $key => $target) {
            $out[$key] = $data[$target];
        }

        $optional_keys_map = [
            'description' => 'description',
        ];

        foreach($optional_keys_map as $key => $target) {
            if (isset($data[$target])) {
                $out[$key] = $data[$target];
            }
        }

        $out['uuid'] = $this::PRESERVE_IF_AVAILABLE;

        return $out;
    }
}
