<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\AuthenticationLog;

class AuthenticationLogController extends Controller {

    use ApiResponser;

    private $request;

    public function __construct(Request $request) {

        $this->request = $request;

    }

    public function getLogs() {

        $logs = AuthenticationLog::all();

        return response()->json($logs, 200);

    }

    /**
     * Return the list of logs
     * @return Illuminate\Http\Response
     */
    public function index() {

        $logs = AuthenticationLog::all();

        return $this->successResponse($logs);

    }

    public function add(Request $request) {
        
        $rules = [
            'auth_id' => 'required|max:20',
        ];

        $this->validate($request, $rules);

        $logs = AuthenticationLog::create($request->all());

        return $this->successResponse($logs, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one log
     * @return Illuminate\Http\Response
     */
    public function show($id) {

        $logs = AuthenticationLog::findOrFail($id);

        return $this->successResponse($logs);
    }

    /**
     * Remove an existing log
     * @return Illuminate\Http\Response
     */
    public function delete($id) {

        $logs = AuthenticationLog::findOrFail($id);

        $logs->delete();

        return $this->successResponse($logs);
    }
}