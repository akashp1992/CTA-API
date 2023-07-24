<?php

namespace App\Repositories;

use App\Models\Page;

class PagesRepository
{
    protected $page;

    public function __construct()
    {
        $this->page = new Page();
    }

    public function getPages()
    {
        return $this->page
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public function getPageById($slug)
    {
        $page = $this->page
            ->where('slug', $slug)
            ->first();

        if (!isset($page)) {
            throw new \Exception('No query results for model [App\Models\Page] ' . $slug, 201);
        }

        return $page;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->page->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->page->create($data);
    }

    public function update($data, $id)
    {
        return $this->page->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $page = $this->page->where('slug', $slug)->first();

        if (!isset($page)) {
            throw new \Exception('No query results for model [App\Models\Page] ' . $slug, 201);
        }

        return $page->delete();
    }
}
