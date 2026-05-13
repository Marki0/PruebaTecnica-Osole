<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SiteSectionController extends Controller
{
    public function index(): View
    {
        return view('admin.stub', ['title' => 'Textos y secciones']);
    }
}
