<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSectionRequest;
use App\Models\SiteSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteSectionController extends Controller
{
    public function index(): View
    {
        $sections = SiteSection::query()->orderBy('key')->get();

        return view('admin.site-sections.index', compact('sections'));
    }

    public function edit(SiteSection $site_section): View
    {
        return view('admin.site-sections.edit', compact('site_section'));
    }

    public function update(UpdateSiteSectionRequest $request, SiteSection $site_section): RedirectResponse
    {
        $site_section->update($request->validated());

        return redirect()
            ->route('admin.site-sections.index')
            ->with('status', 'Texto actualizado.');
    }
}
