<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GitRepo;
use Config;
use App\Jobs\ForkRepoJob;
use App\Events\ForkRepoEvent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $repos = \Auth::user()->repos;
        return view('home', compact('repos'));
    }

    public function repo()
    {
        $repos = GitRepo::where('user_id', \Auth::id())->paginate(10);
        return view('repo', compact('repos'));
    }

    public function forkRepo(Request $request)
    {
        $repo = GitRepo::where('id', $request->id)->where('is_progress', false)->first();
        if (empty($repo)) {
            return \Redirect::back()->with('message', 'Fork repo is progressing!');
        }
        $info = [
            'token' => \Auth::user()->token,
            'repo_name' => $repo->repo_name,
            'owner' => $repo->owner,
            'r_id' => $request->id
        ];
        GitRepo::where('id', $request->id)->update(['is_progress' => true]);
        dispatch(new ForkRepoJob($info));
        return \Redirect::back()->with('message', 'Fork repository progressed');
    }

    public function test()
    {
        // $repo = 'app_store';
        // $owner = 'Sotatek-SangDo';
        // $token = \Auth::user()->token;
        // Config::set('github.connections.main.token', $token);
        // $a = \GitHub::connection('main');
        // dd($a->api('repo')->forks()->create($owner, $repo));
        // event(new ForkRepoEvent('TESTLARAVEL'));
        return 'success';
    }
}
