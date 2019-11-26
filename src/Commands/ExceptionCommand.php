<?php


namespace Lessipe\Larabase\Commands;

use Illuminate\Console\Command;
use Lessipe\Larabase\Generators\ExceptionGenerator;

class ExceptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:exception {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new ExceptionGenerator($this->argument('name')))->generate();
    }
}
