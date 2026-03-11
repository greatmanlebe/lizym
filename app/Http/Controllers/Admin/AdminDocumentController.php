<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerDocument;
use Illuminate\Http\Request;

class AdminDocumentController extends Controller
{
    public function approve(SellerDocument $document)
    {
        $document->update([
            'status' => 'approved',
            'admin_comment' => 'Approved by admin'
        ]);

        return back();
    }

    public function reject(Request $request, SellerDocument $document)
    {
        $document->update([
            'status' => 'rejected',
            'admin_comment' => $request->comment ?? 'Rejected by admin'
        ]);

        return back();
    }
}