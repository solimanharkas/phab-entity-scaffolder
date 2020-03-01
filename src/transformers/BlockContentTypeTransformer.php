<?php

namespace Phabalicious\Scaffolder\Transformers;

use Phabalicious\Scaffolder\Transformers\Utils\BlockContentEntity;
use Phabalicious\Scaffolder\Transformers\Utils\PlaceholderService;
use Phabalicious\Scaffolder\Transformers\Utils\ConfigService;
use Phabalicious\Method\TaskContextInterface;
use Phabalicious\Utilities\Utilities;

class BlockContentTypeTransformer extends YamlTransformer implements DataTransformerInterface
{
    public static function getName()
    {
        return 'block_content';
    }

    public static function requires()
    {
        return "3.4";
    }

    public function transform(TaskContextInterface $context, array $files): array
    {
        $results = [];
        $placeholder_service = new PlaceholderService();
        foreach ($this->iterateOverFiles($context, $files) as $data) {
            $config_service = new ConfigService();
            $transformer = new BlockContentEntity($config_service, $placeholder_service, $data);
            $results += $transformer->getConfigurations();
        }
        $placeholder_service->postTransform($results);
        return $this->asYamlFiles($results);
    }

}
