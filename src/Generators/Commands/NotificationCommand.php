<?php


namespace Lessipe\Larabase\Generators\Commands;


use Illuminate\Console\Command;
use Lessipe\Larabase\Generators\FileAlreadyExistsException;
use Lessipe\Larabase\Generators\NotificationGenerator;
use Symfony\Component\Console\Input\InputArgument;

class NotificationCommand extends Command
{
    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'gen:notification';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new notification.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Notification';


    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            (new NotificationGenerator([
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