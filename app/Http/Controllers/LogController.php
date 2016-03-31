<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Log;

class LogController extends Controller
{

    /**
     * Delete log by id
     * @param $id
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $Log = Log::find($id);
        try {
            $Log->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return redirect('logs')
            ->with('success_message', 'Log has been deleted.');
    }

    /**
     * Show Log List
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
     * Delete logs by filter
     */
    public function deleteAll()
    {
        Log::truncate();
        return redirect('logs');
    }

}
