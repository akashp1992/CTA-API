<?php

namespace App\Http\Controllers;

use App\Repositories\GovernoratesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GovernoratesController extends Controller
{
    protected $governorates_repository;

    public function __construct()
    {
        $this->governorates_repository = new GovernoratesRepository();
    }

    public function index()
    {
        try {
            $governorates = $this->governorates_repository->getGovernorates();
            return view('governorates.index', compact('governorates'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('governorates.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('governorates.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'title'       => 'required',
                'a_title'     => 'required',
                'description' => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('governorates.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) && $data['is_active'] == 1 ? 1 : 0;
            $this->governorates_repository->store($data);

            $notification = prepare_notification_array('success', 'Governorate has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('governorates.index')
            ->withInput()
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $governorate = $this->governorates_repository->getGovernorateById($id);
            return view('governorates.show', compact('governorate'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('governorates.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $governorate = $this->governorates_repository->getGovernorateById($id);
            return view('governorates.manage', compact('governorate'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('governorates.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method');
            $validator = Validator::make($data, array(
                'title'       => 'required',
                'a_title'     => 'required',
                'description' => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('governorates.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) && $data['is_active'] == 1 ? 1 : 0;
            $this->governorates_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Governorate has been updated.');
            return redirect()
                ->route('governorates.index')
                ->withInput()
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('governorates.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->governorates_repository->delete($id);
            $notification = prepare_notification_array('success', 'Governorate has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('governorates.index')
            ->with('notification', $notification);
    }
}
