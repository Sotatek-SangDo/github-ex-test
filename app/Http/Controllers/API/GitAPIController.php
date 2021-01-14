<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use GrahamCampbell\GitHub\Facades\GitHub;
use App\Models\GitRepo;

class GitAPIController extends Controller
{
    public function getRepos(Request $request)
    {
        $result = [
            'success' => true,
            'code'    => 200,
            'data' => GitHub::api('user')->repositories($request->name)
        ];
        return Response::json($result);
    }

    public function saveRepo(Request $request)
    {
        $params = $request->only(['user_id', 'repo_name', 'owner']);
        GitRepo::insert($params);
        $result = [
            'success' => true,
            'code'    => 200
        ];
        return Response::json($result);
    }
}
