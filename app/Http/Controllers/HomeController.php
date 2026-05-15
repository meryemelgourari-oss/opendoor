<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class HomeController extends Controller
{
    public function index()
    {
        $latestProperties = Property::with(['ressources.resourceable'])
            ->where('status', 'publiee')
            ->where('is_approved', true)
            ->latest()
            ->get();

        $newPropertiesCount = Property::where('status', 'publiee')
            ->where('is_approved', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return view('welcome', compact('latestProperties', 'newPropertiesCount'));
    }
}
