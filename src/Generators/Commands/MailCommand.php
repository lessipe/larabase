<?php


namespace Lessipe\Larabase\Generators\Commands;


use Illuminate\Console\Command;
use Lessipe\Larabase\Generators\FileAlreadyExistsException;
use Lessipe\Larabase\Generators\MailGenerator;
use Symfony\Component\Console\Input\InputArgument;

class MailCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'gen:mail';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new mail.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Mail';


    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            (new MailGenerator([
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