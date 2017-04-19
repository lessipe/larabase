<?php

namespace Visualplus\Larabase\Generators;

/**
 * Class ServiceGenerator
 * @package Visualplus\Larabase\Generators
 */
class ServiceGenerator extends Generator
{
    /**
     * @var string
     */
    protected $stub = 'serivce/service';

    /**
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'services';
    }

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode());
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getName() . 'Service.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('larabase.generator.basePath', app_path());
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        $repository = parent::getRootNamespace() . parent::getConfigGeneratorClassPath('interfaces') . '\\' . $this->name . 'Repository;';
        $repository = str_replace([
            "\\",
            '/'
        ], '\\', $repository);

        return array_merge(parent::getReplacements(), [
            'use_validator' => $this->getValidatorUse(),
            'repository'    => $repository,
        ]);
    }

    public function getValidatorUse()
    {
        $validator = $this->getValidator();

        return "use {$validator};";
    }

    public function getValidator()
    {
        $validatorGenerator = new ValidatorGenerator([
            'name'  => $this->name,
            'rules' => $this->rules,
            'force' => $this->force,
        ]);

        $validator = $validatorGenerator->getRootNamespace() . '\\' . $validatorGenerator->getName();

        return str_replace([
                "\\",
                '/'
            ], '\\', $validator) . 'Validator';

    }
}