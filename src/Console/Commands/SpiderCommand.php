<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Dannetrichard\Spider\Spider;

class SpiderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider {--r}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Spider $spider)
    {
        parent::__construct();
        $this->spider =  $spider;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->option('r')){
    		$this->spider->refresh();
    	}else{
    		$this->spider->index(); 
    	}
    }
}
