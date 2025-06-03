<?php

namespace App\Console\Commands;

use App\Http\Controllers\NeuronAI\MyAgentController;
use Illuminate\Console\Command;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\Observability\AgentMonitoring;
use NunoMaduro\Collision\Adapters\Laravel\Inspector;

class Agent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:agent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = MyAgentController::make()
            ->observe(
                new AgentMonitoring(inspector())
            )
            ->chat(
                new UserMessage("What about this video: https://www.youtube.com/watch?v=WmVLcj-XKnM")
            );
            
        echo $response->getContent();
    }
}
