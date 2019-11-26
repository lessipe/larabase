<?php


namespace Lessipe\Larabase\Contracts;


abstract class Generator
{
    /**
     * @var array
     */
    private $config;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $pathPrefix;
    /**
     * @var string
     */
    protected $namespacePrefix;

    /**
     * Generator constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->config = config('larabase');

        $arr = explode('/', $name);
        $this->name = array_pop($arr);

        if (count($arr) > 0) {
            $this->namespacePrefix = '\\\\' . implode('\\\\', $arr);
            $this->pathPrefix = '/' . implode('/', $arr);
        }
    }

    /**
     *
     */
    public function generate(): void
    {
        $filePath = $this->getFilePath($this->config['base_path']);

        $fp = fopen($filePath, 'w');
        fwrite($fp, $this->parse());
        fclose($fp);
    }

    /**
     * @return string
     */
    private function parse(): string
    {
        $stub = $this->getStub();

        foreach ($this->getReplacements($this->config['root_namespace']) as $key => $value) {
            $stub = str_replace('$' . $key . '$', $value, $stub);
        }

        return $stub;
    }

    /**
     * @return string
     */
    abstract protected function getStub(): string;

    /**
     * @param string $rootNamespace
     * @return array
     */
    abstract protected function getReplacements(string $rootNamespace): array;

    /**
     * @param string $basePath
     * @return string
     */
    abstract protected function getFilePath(string $basePath): string;
}
