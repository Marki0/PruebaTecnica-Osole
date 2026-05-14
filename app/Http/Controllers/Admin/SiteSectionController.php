<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSectionRequest;
use App\Models\SiteSection;
use App\Services\NosotrosBlockImageStorage;
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

    public function update(UpdateSiteSectionRequest $request, SiteSection $site_section, NosotrosBlockImageStorage $blockImages): RedirectResponse
    {
        $validated = $request->validated();

        if ($this->isNosotrosPageBlock($site_section->key)) {
            $extra = array_merge($site_section->extra ?? [], [
                'nikitos_image' => isset($validated['nikitos_image']) ? trim((string) $validated['nikitos_image']) : null,
                'image_alt' => isset($validated['image_alt']) ? trim((string) $validated['image_alt']) : null,
            ]);
            if ($extra['nikitos_image'] === '') {
                $extra['nikitos_image'] = null;
            }
            if ($extra['image_alt'] === '') {
                $extra['image_alt'] = null;
            }

            if ($request->boolean('remove_block_image')) {
                $blockImages->delete($site_section->extra['image_path'] ?? null);
                $extra['image_path'] = null;
            }

            if ($request->hasFile('image')) {
                $blockImages->delete($site_section->extra['image_path'] ?? null);
                $extra['image_path'] = $blockImages->store($request->file('image'));
            }

            unset($validated['nikitos_image'], $validated['image_alt'], $validated['image'], $validated['remove_block_image']);
            $validated['extra'] = $extra;
        }

        $site_section->update($validated);

        return redirect()
            ->route('admin.site-sections.index')
            ->with('status', 'Texto actualizado.');
    }

    private function isNosotrosPageBlock(string $key): bool
    {
        return in_array($key, SiteSection::NOSOTROS_PAGE_BLOCK_KEYS, true);
    }
}
