<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAdminStoreAndUpdateAcquisition;
use App\Models\Acquisition;
use App\Models\AcquisitionAction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class AcquisitionController extends Controller
{
    // =================
    // APPLICATION ADMIN
    // =================
    public function admin_acquisition_index($filter_read = "all")
    {
        $acquisitions = Acquisition::select(
            'acquisitions.id as id',
            'acquisitions.email as email',
            'acquisitions.branch as branch',
            'acquisitions.last_action_date as last_action_date',
            'acquisitions.last_action_name as last_action_name',
            'acquisitions.running as running',
            'acquisitions.successful as successful',
        )
            ->filterAcquisition(Request::only('search'))
        //
            ->where(function ($q) use ($filter_read) {
                if ($filter_read == "running") {
                    $q->where('acquisitions.running', '=', true);
                }
                if ($filter_read == "completed") {
                    $q->where('acquisitions.running', '=', false);
                }
            })
        //
            ->orderBy('last_action_date', 'desc')
            ->paginate(10)
            ->withQueryString();
        //
        $filterAcquisitionsText = null;
        //
        if ($filter_read == "running") {
            $filterAcquisitionsText = "Es werden nur laufende Akquisitionen angezeigt.";
        }
        if ($filter_read == "completed") {
            $filterAcquisitionsText = "Es werden nur beendete Akquisitionen angezeigt.";
        }
        //
        return Inertia::render('Application/Admin/AcquisitionList', [
            'filters' => Request::all('search'),
            'filterAcquisitionsText' => $filterAcquisitionsText,
            'acquisitions' => $acquisitions,
        ]);
    }
    //
    public function admin_acquisition_show(Acquisition $acquisition)
    {
        $acquisition_actions = $acquisition->acquisition_actions;
        //
        return Inertia::render('Application/Admin/AcquisitionShow', [
            'acquisition' => $acquisition,
            'acquisition_actions' => $acquisition_actions,
        ]);
    }
    //
    public function admin_acquisition_create()
    {
        $acquisition = new Acquisition;
        $acquisition->id = 0;
        $acquisition->email = null;
        $acquisition->branch = "Online-Shop";
        //
        return Inertia::render('Application/Admin/AcquisitionForm', [
            'acquisition' => $acquisition,
        ]);
    }
    //
    public function admin_acquisition_store(RequestAdminStoreAndUpdateAcquisition $request)
    {
        $acquisition = Acquisition::Create([
            'email' => $request->email,
            'branch' => $request->branch,
            'running' => true,
            'successful' => false,
            'notes' => $request->notes,
        ]);
        //
        return Redirect::route('admin.acquisition.edit', $acquisition->id)
            ->with(['success' => 'Die Daten der neuen Akquisition wurden erfolgreich abgespeichert.']);
    }
    //
    public function admin_acquisition_edit(Acquisition $acquisition)
    {
        //
        return Inertia::render('Application/Admin/AcquisitionForm', [
            'acquisition' => $acquisition,
        ]);
    }
    //
    public function admin_acquisition_update(Acquisition $acquisition, RequestAdminStoreAndUpdateAcquisition $request)
    {
        $acquisition->email = $request->email;
        $acquisition->branch = $request->branch;
        $acquisition->notes = $request->notes;
        $acquisition->save();
        //
        return Redirect::route('admin.acquisition.edit', $acquisition->id)
            ->with(['success' => 'Die Daten der Akquisition wurden erfolgreich geändert.']);
    }
    //
    public function admin_acquisition_update_running_true(Acquisition $acquisition)
    {
        $acquisition->running = true;
        $acquisition->save();
        //
        return Redirect::route('admin.acquisition.show', $acquisition->id)
            ->with(['success' => 'Die Akquisition wurde in laufend geändert.']);
    }
    //
    public function admin_acquisition_update_running_false(Acquisition $acquisition)
    {
        $acquisition->running = false;
        $acquisition->save();
        //
        return Redirect::route('admin.acquisition.show', $acquisition->id)
            ->with(['success' => 'Die Akquisition wurde in beendet geändert.']);
    }
    //
    public function admin_acquisition_update_successful_true(Acquisition $acquisition)
    {
        $acquisition->successful = true;
        $acquisition->save();
        //
        return Redirect::route('admin.acquisition.show', $acquisition->id)
            ->with(['success' => 'Die Akquisition wurde in erfolgreich geändert.']);
    }
    //
    public function admin_acquisition_update_successful_false(Acquisition $acquisition)
    {
        $acquisition->successful = false;
        $acquisition->save();
        //
        return Redirect::route('admin.acquisition.show', $acquisition->id)
            ->with(['success' => 'Die Akquisition wurde in erfolglos geändert.']);
    }
    //
    public function admin_acquisition_delete(Acquisition $acquisition)
    {
        // lösche alle Datensätze in acquisition_actions
        $acquisition_actions = $acquisition->acquisition_actions()->get();
        foreach ($acquisition_actions as $acquisition_action) {
            $acquisition_action->delete();
        }
        //
        $acquisition->delete();
        //
        return Redirect::route('admin.acquisition.index')
            ->with(['success' => 'Die Akquisition wurde erfolgreich gelöscht.']);
    }
    //
    public function admin_acquisition_action_create(Acquisition $acquisition, $action_number)
    {
        //
        //Log::info('admin_acquisition_action_create', [
        //    'acquisition->id' => $acquisition->id,
        //    'action_number' => $action_number,
        //]);
        // validiere $action_number
        if ($action_number != 1 && $action_number != 2) {
            $error = "Die vorgegebene Aktion ist unbekannt.<br />";
            //
            return Redirect::route('admin.acquisition.show', $acquisition->id)
                ->with([
                    'error' => $error,
                ]);
        }
        // bestimme action_name
        if ($action_number == 1) {
            $action_name = "Erste Mail an einen Online-Shop";
        }
        if ($action_number == 2) {
            $action_name = "Zweite Mail an einen Online-Shop";
        }
        // create dataset for acquisition_actions
        $Zeitpunkt = Carbon::now();
        //
        AcquisitionAction::create([
            'acquisition_id' => $acquisition->id,
            'action_date' => $Zeitpunkt,
            'action_name' => $action_name,
        ]);
        // passe Attribute in acquisitions an
        $acquisition->last_action_date = $Zeitpunkt;
        $acquisition->last_action_name = $action_name;
        $acquisition->save();
        //
        $message = "Die Aktion wurde dokumentiert.<br />";
        //
        return Redirect::route('admin.acquisition.show', $acquisition->id)
            ->with([
                'success' => $message,
            ]);
    }

}
