<?php


namespace Lessipe\Larabase\Generators;


use Lessipe\Larabase\Contracts\Generator;

class PresenterGenerator extends Generator
{
    /**
     * @return string
     */
    protected function getStub(): string
    {
        $path = __DIR__ . '/../stubs/PresenterStub.stub';
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
            'NAMESPACE' => $rootNamespace . '\\Presenters' . $this->namespacePrefix,
            'CLASS_NAME' => $this->name,
        ];
    }

    /**
     * @param string $basePath
     * @return string
     */
    protected function getFilePath(string $basePath): string
    {
        return $basePath . '/Presenters' . $this->pathPrefix . '/' . $this->name . '.php';
    }
}
