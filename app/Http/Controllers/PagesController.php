<?php

namespace App\Http\Controllers;

use App\Repositories\PagesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    protected $pages_repository;

    public function __construct()
    {
        $this->pages_repository = new PagesRepository();
    }

    public function index()
    {
        try {
            $pages = $this->pages_repository->getPages();
            return view('pages.index', compact('pages'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('pages.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('pages.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'title'     => 'required',
                'content'   => 'required',
                'a_title'   => 'required',
                'a_content' => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('pages.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) && $data['is_active'] == 1 ? 1 : 0;
            $this->pages_repository->store($data);

            $notification = prepare_notification_array('success', 'Page has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('pages.index')
            ->withInput()
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $page = $this->pages_repository->getPageById($id);
            return view('pages.show', compact('page'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('pages.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $page = $this->pages_repository->getPageById($id);
            return view('pages.manage', compact('page'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('pages.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method');
            $validator = Validator::make($data, array(
                'title'     => 'required',
                'content'   => 'required',
                'a_title'   => 'required',
                'a_content' => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('pages.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) && $data['is_active'] == 1 ? 1 : 0;
            $this->pages_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Page has been updated.');
            return redirect()
                ->route('pages.index')
                ->withInput()
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('pages.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->pages_repository->delete($id);
            $notification = prepare_notification_array('success', 'Page has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('pages.index')
            ->with('notification', $notification);
    }
}
