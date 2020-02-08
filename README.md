# phab-entity-scaffolder
Port of entity-scaffolder for D8 using phabalicious for scaffolding files.

## Installation

As long as this project is not available at packagist.org, add this repo to your composer.json:

```
{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:factorial-io/phab-entity-scaffolder.git"
    }
  ]
}
```

Then require this project via composer:
```
composer require --dev factorial/phab-entity-scaffolder:dev-master
```
This should download the project and install it into vendor.

Add this to your yml-file which controls the scaffolding:

```
questions: []
assets: []

plugins:
  - vendor/factorial/phab-entity-scaffolder/src/transformers

scaffold:
  - ...
```

