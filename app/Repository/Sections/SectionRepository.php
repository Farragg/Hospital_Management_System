<?php

namespace App\Repository\Sections;

use App\Events\MyEvent;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Models\Doctor;
use App\Models\Section;
use PhpParser\Comment\Doc;

class SectionRepository implements SectionRepositoryInterface
{
    public function index()
    {
        $sections= Section::all();
        return view('Dashboard.Sections.index', compact('sections'));
    }

    public function store($request)
    {
        Section::create([
            'name'=> $request->input('name'),
        ]);
        session()->flash('add');
        return redirect()->route('Sections.index');
    }

    public function update($request)
    {
        $section = Section::findOrFail($request->id);
        $section->update([
            'name' => $request->input('name'),
        ]);
        session()->flash('edit');
        return redirect()->route('Sections.index');
    }

    public function destroy($request)
    {
        $section = Section::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('Sections.index');
    }

    public function show($id)
    {
        $doctors= Section::findOrFail($id)->doctors;
        $section = Section::findOrFail($id);
        return view('Dashboard.Sections.show_doctors', compact('doctors', 'section'));
    }
}
