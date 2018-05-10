<?php

namespace Zeropingheroes\Lanager\Http\Controllers;

use Illuminate\Support\Facades\View;
use Zeropingheroes\Lanager\Page;
use Illuminate\Http\Request;
use Zeropingheroes\Lanager\Requests\StorePageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return View::make('pages.page.index')
            ->with('pages', Page::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('pages.page.create')
            ->with('page', new Page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $httpRequest
     * @return \Illuminate\Http\Response
     * @internal param Request|StoreRoleAssignmentRequest $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $httpRequest)
    {
        $this->authorize('create', Page::class);

        $input = $httpRequest->only(['title', 'content', 'published']);

        $request = new StorePageRequest($input);

        if ($request->invalid()) {
            return redirect()
                ->back()
                ->withErrors($request->errors())
                ->withInput();
        }
        $page = Page::create($input);

        return redirect()
            ->route('pages.index')
            ->with(
                'alerts',
                [
                    [
                        'message' => __('phrase.page-successfully-created', ['title' => $page->title]),
                        'type' => 'success'
                    ]
                ]
            );
    }


    /**
     * Display the specified resource.
     *
     * @param  \Zeropingheroes\Lanager\Page $page
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Page $page)
    {
        return View::make('pages.page.show')
            ->with('page', $page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Zeropingheroes\Lanager\Page $page
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Page $page)
    {
        $this->authorize('update', $page);

        return View::make('pages.page.edit')
            ->with('page', $page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $httpRequest
     * @param  \Zeropingheroes\Lanager\Page $page
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $httpRequest, Page $page)
    {
        $this->authorize('update', $page);

        $input = $httpRequest->only(['title', 'content']);

        $input['published'] = $httpRequest->has('published');

        $request = new StorePageRequest($input);

        if ($request->invalid()) {
            return redirect()
                ->back()
                ->withErrors($request->errors())
                ->withInput();
        }
        $page->update($input);

        return redirect()
            ->route('pages.show', $page)
            ->with(
                'alerts',
                [
                    [
                        'message' => __('phrase.page-successfully-updated', ['title' => $page->title]),
                        'type' => 'success'
                    ]
                ]
            );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Zeropingheroes\Lanager\Page $page
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);

        Page::destroy($page->id);

        return redirect()
            ->route('pages.index')
            ->with('alerts', [
                [
                    'message' => __('phrase.page-successfully-updated', ['title' => $page->title]),
                    'type' => 'success'
                ]
            ]);
    }
}