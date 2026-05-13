<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Models\Banner;
use App\Services\BannerImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::query()
            ->orderBy('placement')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(20);

        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.banners.create');
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

        return redirect()->route('admin.banners.index')->with('status', 'Banner actualizado.');
    }

    public function destroy(Banner $banner, BannerImageStorage $storage): RedirectResponse
    {
        $storage->delete($banner->image_path);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('status', 'Banner eliminado.');
    }
}
