<?php

namespace Lessipe\Larabase\Generators;


use Lessipe\Larabase\Contracts\Generator;

class NotificationGenerator extends Generator
{
    /**
     * @inheritDoc
     */
    protected function getStub(): string
    {
        $path = __DIR__ . '/../stubs/NotificationStub.stub';
        $fp = fopen($path, 'r');
        $stub = fread($fp, filesize($path));
        fclose($fp);

        return $stub;
    }

    /**
     * @inheritDoc
     */
    protected function getReplacements(string $rootNamespace): array
    {
        return [
            'NAMESPACE' => $rootNamespace . 'Notifications' . $this->namespacePrefix,
            'CLASS_NAME' => $this->name,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getFilePath(string $basePath): string
    {
        return $basePath . '/Notifications' . $this->pathPrefix . '/' . $this->name . '.php';
    }
}
