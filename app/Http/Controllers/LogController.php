<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Log;

class LogController extends Controller
{

    /**
     * Show Log List view
     *
     * @return $this
     */
    public function logList()
    {
        $Logs = Log::paginate();
        $Logs->render();
        return view('logs.list')
            ->with(['Logs' => $Logs]);
    }

    /**
     * Delete all logs action
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteAll()
    {
        Log::truncate();
        return redirect('logs');
    }

}
