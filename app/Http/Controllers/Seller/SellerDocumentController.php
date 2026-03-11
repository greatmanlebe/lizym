<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use App\Models\SellerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDocumentController extends Controller
{

    public function index()
    {
        $seller = Auth::guard('seller')->user();

        return inertia('seller/Documents', [
            'documents' => $seller->documents,
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'type' => 'required|string',
        'file' => 'required|file|max:2048',
    ]);

    $seller = Auth::guard('seller')->user();
    $slug = $seller->slug;

    // Create folder if not exists
    $folderPath = public_path("img/{$slug}");
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Generate unique filename
    $filename = time() . '_' . $request->file('file')->getClientOriginalName();

    // Move file to public/img/{slug}/
    $request->file('file')->move($folderPath, $filename);

    // Save in DB
    SellerDocument::create([
        'seller_id' => $seller->id,
        'type' => $request->type,
        'file_path' => "img/{$slug}/{$filename}",
        'status' => 'pending',
    ]);

    return back()->with('success', 'Document uploaded successfully');
}
}
