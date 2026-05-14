<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Models\Banner;
use App\Services\BannerImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $bannersByPlacement = Banner::query()
            ->whereIn('placement', Banner::sectionPlacementKeys())
            ->get()
            ->keyBy('placement');

        $slots = collect(Banner::sectionBannersDefinition())
            ->map(function (string $label, string $placement) use ($bannersByPlacement) {
                return [
                    'placement' => $placement,
                    'label' => $label,
                    'banner' => $bannersByPlacement->get($placement),
                ];
            });

        return view('admin.banners.index', compact('slots'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $keys = Banner::sectionPlacementKeys();
        $used = Banner::query()->whereIn('placement', $keys)->pluck('placement')->all();
        $available = collect($keys)->diff($used)->values();

        if ($available->isEmpty()) {
            return redirect()
                ->route('admin.banners.index')
                ->with('status', 'Los cuatro banners de sección ya están creados. Editá cada uno para cambiar la imagen.');
        }

        $placement = $request->query('placement');
        if (! is_string($placement) || ! $available->contains($placement)) {
            $placement = $available->first();
        }

        return view('admin.banners.create', [
            'presetPlacement' => $placement,
            'availablePlacements' => $available,
        ]);
    }

    public function store(StoreBannerRequest $request, BannerImageStorage $storage): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = (int) $data['sort_order'];

        if ($request->hasFile('image')) {
            $data['image_path'] = $storage->store($request->file('image'));
        } else {
            $data['image_path'] = null;
        }

        unset($data['image']);

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner creado.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(UpdateBannerRequest $request, Banner $banner, BannerImageStorage $storage): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = (int) $data['sort_order'];

        if ($request->boolean('remove_image')) {
            $storage->delete($banner->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            $storage->delete($banner->image_path);
            $data['image_path'] = $storage->store($request->file('image'));
        }

        unset($data['image'], $data['remove_image']);

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner actualizado. La imagen se refleja en la web si el banner está activo.');
    }

    public function destroy(Banner $banner, BannerImageStorage $storage): RedirectResponse
    {
        if ($banner->isSectionHero()) {
            return redirect()
                ->route('admin.banners.index')
                ->withErrors(['banner' => 'No se eliminan los banners de sección. Editá la imagen o desmarcá «Activo» si no querés mostrarla.']);
        }

        $storage->delete($banner->image_path);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('status', 'Banner eliminado.');
    }
}
