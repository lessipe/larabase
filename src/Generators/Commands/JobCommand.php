<?php

namespace Lessipe\Larabase\Generators\Commands;

use Illuminate\Console\Command;
use Lessipe\Larabase\Generators\FileAlreadyExistsException;
use Symfony\Component\Console\Input\InputArgument;
use Lessipe\Larabase\Generators\JobGenerator;
use Lessipe\Larabase\Generators\JobInterfaceGenerator;

class JobCommand extends Command
{

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'gen:job';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new job.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job';


    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            (new JobGenerator([
                'name'  => $this->argument('name'),
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
                'The name of model for which the presenter is being generated.',
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
