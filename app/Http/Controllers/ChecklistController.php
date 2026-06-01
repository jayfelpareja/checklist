<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem;
use Database\Seeders\DefaultChecklistSeeder;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Main task workspace view
     */
    public function index(Request $request)
    {
        // 1. Capture the project sidebar search filter keyword
        $searchProject = $request->get('search_project', '');

        // 2. Get unique website URLs for the sidebar, filtering by search keyword if typed
        $projects = ChecklistItem::select('project_url')
            ->distinct()
            ->when($searchProject, function ($query) use ($searchProject) {
                return $query->where('project_url', 'like', '%' . $searchProject . '%');
            })
            ->get()
            ->map(function ($item) {
                // Calculate progress percentage per project dynamically
                $total = ChecklistItem::where('project_url', $item->project_url)->count();
                $completed = ChecklistItem::where('project_url', $item->project_url)->where('completed', true)->count();
                $item->progress = $total > 0 ? round(($completed / $total) * 100) : 0;
                return $item;
            });

        // 3. Figure out which website is currently active (Fallback to first project found in the filtered list)
        $activeProject = $request->get('project', $projects->first()?->project_url ?? '');

        // 4. Keep track of live checklist task keyword search
        $search = $request->get('search', '');

        // 5. Force a strict default layout fallback category tab so layout variables never vanish
        $activeTab = $request->get('tab', 'Website Development');

        // 6. Gather checklist tasks if an active project exists
        $checklistItems = collect();
        if (!empty($activeProject)) {
            $checklistItems = ChecklistItem::where('project_url', $activeProject)
                ->where('category', $activeTab)
                ->when($search, function ($query) use ($search) {
                    return $query->where('task', 'like', '%' . $search . '%');
                })
                ->get();
        }

        // 7. Global progress calculations for the main banner card header
        $overallProgress = 0;
        if (!empty($activeProject)) {
            $totalActive = ChecklistItem::where('project_url', $activeProject)->count();
            $completedActive = ChecklistItem::where('project_url', $activeProject)->where('completed', true)->count();
            $overallProgress = $totalActive > 0 ? round(($completedActive / $totalActive) * 100) : 0;
        }

        // 8. Core structural categories matching your master array
        $categories = ['Website Development', 'Install necessary plugins and themes', 'Launch new website'];

        return view('checklist', compact(
            'projects',
            'activeProject',
            'checklistItems',
            'activeTab',
            'categories',
            'overallProgress',
            'search',
            'searchProject'
        ));
    }

    /**
     * Add a new project profile and seed it with tasks
     */
    public function store(Request $request)
    {
        // Intercept both field naming variations to protect against mismatch errors
        $inputUrl = $request->input('website_url') ?? $request->input('project_url');

        if (empty($inputUrl)) {
            return back()->withErrors(['project_url' => 'The website field is required.']);
        }

        // Clean domain strings exactly like your original configuration rules
        $url = str_replace(['https://', 'http://'], '', $inputUrl);
        $url = trim($url, '/ ');

        // Seed data structures into MySQL on successful submission
        if (ChecklistItem::where('project_url', $url)->count() === 0) {
            $defaultTasks = DefaultChecklistSeeder::getDefaultTasks();
            foreach ($defaultTasks as $task) {
                ChecklistItem::create([
                    'project_url' => $url,
                    'category' => $task['category'],
                    'task' => $task['task'],
                    'completed' => false,
                ]);
            }
        }

        // Redirect back directly matching our layout structure variables
        return redirect()->route('checklist.index', ['project' => $url, 'tab' => 'Website Development']);
    }

    /**
     * Check/Uncheck an item state
     */
    public function toggle($id)
    {
        $item = ChecklistItem::findOrFail($id);
        $item->completed = !$item->completed;
        $item->save();

        return back();
    }

    /**
     * Completely remove a project profile and its accompanying tasks
     */
    public function destroy($project_url)
    {
        ChecklistItem::where('project_url', $project_url)->delete();
        return redirect()->route('checklist.index');
    }

    /**
     * Separate standalone overview dashboard view
     */
    public function dashboard(Request $request)
    {
        // Capture optional search keyword to filter your dashboard layout
        $searchProject = $request->get('search_project', '');

        // Gather all distinct websites with computed metrics
        $projects = ChecklistItem::select('project_url')
            ->distinct()
            ->when($searchProject, function ($query) use ($searchProject) {
                return $query->where('project_url', 'like', '%' . $searchProject . '%');
            })
            ->get()
            ->map(function ($item) {
                $total = ChecklistItem::where('project_url', $item->project_url)->count();
                $completed = ChecklistItem::where('project_url', $item->project_url)->where('completed', true)->count();
                
                $item->total_tasks = $total;
                $item->completed_tasks = $completed;
                $item->progress = $total > 0 ? round(($completed / $total) * 100) : 0;
                return $item;
            });

        return view('dashboard', compact('projects', 'searchProject'));
    }
}