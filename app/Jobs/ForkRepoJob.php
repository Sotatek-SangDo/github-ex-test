<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Github;
use App\Models\GitRepo;
use Config;
use App\Events\ForkRepoEvent;

class ForkRepoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $_repoInfo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($repoInfo)
    {
        $this->_repoInfo = $repoInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Config::set('github.connections.main.token', $this->_repoInfo['token']);
        $client = \GitHub::connection('main');
        $r = $client->api('repo')->forks()->create($this->_repoInfo['owner'], $this->_repoInfo['repo_name']);
        GitRepo::where('id', $this->_repoInfo['r_id'])
            ->update([
                'is_progress' => false,
                'repo_fork_url' => $r['html_url']
            ]);
        event(new ForkRepoEvent($this->_repoInfo['repo_name']));
    }
}
