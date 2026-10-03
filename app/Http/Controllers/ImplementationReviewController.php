<?php

namespace App\Http\Controllers;

use App\Models\ImplementationReview;
use App\Http\Requests\StoreReviewRequest;

class ImplementationReviewController extends Controller
{
    // Menampilkan daftar dokumen dengan Pagination
    public function index()
    {
        $reviews = ImplementationReview::latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    // Menampilkan halaman form input
    public function create()
    {
        return view('reviews.create');
    }

    // Menyimpan data ke database
    public function store(StoreReviewRequest $request)
    {
        $review = ImplementationReview::create($request->validated());
        return redirect()->route('reviews.show', $review->id)
                         ->with('success', 'Dokumen berhasil disimpan dan siap dicetak.');
    }

    // Menampilkan halaman siap cetak
    public function show(ImplementationReview $review)
    {
        return view('reviews.show', compact('review'));
    }

    // Menampilkan halaman form edit dengan data yang sudah ada
    public function edit(ImplementationReview $review)
    {
        return view('reviews.edit', compact('review'));
    }

    // Menyimpan perubahan data (update) ke database
    public function update(StoreReviewRequest $request, ImplementationReview $review)
    {
        $review->update($request->validated());
        return redirect()->route('reviews.index')
                         ->with('success', 'Dokumen berhasil diperbarui.');
    }

    // Menghapus data dari database
    public function destroy(ImplementationReview $review)
    {
        $review->delete();
        return redirect()->route('reviews.index')
                         ->with('success', 'Dokumen berhasil dihapus.');
    }
}