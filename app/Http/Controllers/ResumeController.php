<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResumeController extends Controller
{
    public function index()
    {
        $resumes = auth()->user()->resumes()->latest()->get();
        return Inertia::render('Resumes/Index', [
            'resumes' => $resumes
        ]);
    }

    public function create()
    {
        $defaultContent = [
            'sections' => [
                [
                    'type' => 'personal',
                    'title' => 'Personal Information',
                    'content' => [
                        'name' => '',
                        'email' => '',
                        'phone' => '',
                        'address' => '',
                    ]
                ],
                [
                    'type' => 'education',
                    'title' => 'Education',
                    'content' => []
                ],
                [
                    'type' => 'experience',
                    'title' => 'Work Experience',
                    'content' => []
                ],
                [
                    'type' => 'skills',
                    'title' => 'Skills',
                    'content' => []
                ]
            ]
        ];

        return Inertia::render('Resumes/Create', [
            'defaultContent' => $defaultContent
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|array',
            'template' => 'required|string'
        ]);

        $resume = auth()->user()->resumes()->create($validated);

        return redirect()->route('resumes.edit', $resume);
    }

    public function edit(Resume $resume)
    {
        $this->authorize('update', $resume);
        
        // Ensure content has the required structure
        if (empty($resume->content) || !isset($resume->content['sections'])) {
            $resume->content = [
                'sections' => [
                    [
                        'type' => 'personal',
                        'title' => 'Personal Information',
                        'content' => [
                            'name' => '',
                            'email' => '',
                            'phone' => '',
                            'address' => '',
                        ]
                    ],
                    [
                        'type' => 'education',
                        'title' => 'Education',
                        'content' => []
                    ],
                    [
                        'type' => 'experience',
                        'title' => 'Work Experience',
                        'content' => []
                    ],
                    [
                        'type' => 'skills',
                        'title' => 'Skills',
                        'content' => []
                    ]
                ]
            ];
            $resume->save();
        }
        
        return Inertia::render('Resumes/Edit', [
            'resume' => $resume
        ]);
    }

    public function update(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|array',
            'template' => 'required|string'
        ]);

        $resume->update($validated);

        return redirect()->route('resumes.edit', $resume);
    }

    public function destroy(Resume $resume)
    {
        $this->authorize('delete', $resume);
        
        $resume->delete();

        return redirect()->route('resumes.index');
    }
}
