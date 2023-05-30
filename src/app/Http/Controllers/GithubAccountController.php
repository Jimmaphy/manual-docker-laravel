<?php

namespace App\Http\Controllers;

use App\Models\GithubAccount;
use Illuminate\Http\Request;

class GithubAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $githubAccounts = GithubAccount::all();
        return view('github-accounts.index', compact('githubAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('github-accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $githubAccount = GithubAccount::create($request->all());
        return redirect()->route('github-accounts.show', $githubAccount->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $githubAccount = GithubAccount::findOrFail($id);
        return view('github-accounts.show', compact('githubAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $githubAccount = GithubAccount::findOrFail($id);
        return view('github-accounts.edit', compact('githubAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $githubAccount = GithubAccount::findOrFail($id);
        $githubAccount->update($request->all());
        return redirect()->route('github-accounts.show', $githubAccount->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $githubAccount = GithubAccount::findOrFail($id);
        $githubAccount->delete();
        return redirect()->route('github-accounts.index');
    }
}
