<?php


namespace Lessipe\Larabase\Generators\Commands;


use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Lessipe\Larabase\Generators\ComposerGenerator;
use Lessipe\Larabase\Generators\FileAlreadyExistsException;

class ComposerCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'gen:composer';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new view composer.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Composer';


    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            (new ComposerGenerator([
                'name' => $this->argument('name')
            ]))->run();
            $this->info($this->type . ' created successfully.');
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
                'The name of model for which the composer is being generated.',
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