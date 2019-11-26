<?php


namespace Lessipe\Larabase\Generators;


use Lessipe\Larabase\Contracts\Generator;

class ServiceGenerator extends Generator
{
    /**
     * @return string
     */
    protected function getStub(): string
    {
        $path = __DIR__ . '/../stubs/ServiceStub.stub';
        $fp = fopen($path, 'r');
        $stub = fread($fp, filesize($path));
        fclose($fp);

        return $stub;
    }

    /**
     * @param string $rootNamespace
     * @return array
     */
    protected function getReplacements(string $rootNamespace): array
    {
        return [
            'NAMESPACE' => $rootNamespace . '\\Services' . $this->namespacePrefix,
            'CLASS_NAME' => $this->name,
        ];
    }

    /**
     * @param string $basePath
     * @return string
     */
    protected function getFilePath(string $basePath): string
    {
        return $basePath . '/Services' . $this->pathPrefix . '/' . $this->name . '.php';
    }
}
