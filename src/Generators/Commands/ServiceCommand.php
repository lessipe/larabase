<?php
namespace Visualplus\Larabase\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Visualplus\Larabase\Generators\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Visualplus\Larabase\Generators\ServiceGenerator;
use Visualplus\Larabase\Generators\ValidatorGenerator;

class ServiceCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'gen:service';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new service.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * @var Collection
     */
    protected $generators = null;


    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $validatorGenerator = new ValidatorGenerator([
            'name' => $this->argument('name')
        ]);

        $validatorGenerator->run();

        try {
            (new ServiceGenerator([
                'name'      => $this->argument('name'),
            ]))->run();

            $this->info($this->type . " created successfully.");
        } catch (FileAlreadyExistsException $e) {
            $this->error($this->type . ' already exists!');

            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of class being generated.',
                null
            ],
        ];
    }


    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
        ];
    }
}
