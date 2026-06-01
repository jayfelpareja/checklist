<!DOCTYPE html>
<html lang="en" class="h-full antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCJ Checklist - Laravel</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        /* Smooth animation styling for the View More container toggle */
        details[open] summary ~ * {
            animation: sweep .2s ease-in-out;
        }
        @keyframes sweep {
            0% { opacity: 0; transform: translateY(-4px) }
            100% { opacity: 1; transform: translateY(0) }
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-[#f5f7fa] text-[#111827] dark:bg-[#0f1115] dark:text-white transition-colors duration-200">

    <header class="sticky top-0 z-50 border-b backdrop-blur border-black/5 bg-white/90 dark:border-white/5 dark:bg-[#0f1115]/90">
        <div class="mx-auto flex min-h-16 max-w-7xl flex-col gap-3 px-4 py-3 lg:h-16 lg:flex-row lg:items-center lg:justify-between lg:py-0">
            
            <div class="shrink-0">
                <h1 class="text-[15px] font-semibold tracking-tight">TCJ Checklist</h1>
                <p class="text-[11px] text-zinc-500">WordPress Deployment Tracker</p>
            </div>

            <div class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 max-w-2xl w-full mx-auto">
                
                <form method="GET" action="{{ route('checklist.index') }}" class="relative flex-1">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="project" value="{{ $activeProject }}">
                    
                    <input type="text" name="search_project" placeholder="🔍 Search tracked sites..." value="{{ $searchProject ?? '' }}"
                        class="h-9 w-full rounded-lg border px-3 text-[12px] outline-none border-black/10 bg-zinc-50 dark:border-white/10 dark:bg-[#14171d] pr-8"
                        oninput="this.form.submit()">
                    
                    @if(!empty($searchProject))
                        <a href="?project={{ urlencode($activeProject) }}&tab={{ urlencode($activeTab) }}&search={{ urlencode($search) }}" 
                           class="absolute right-2.5 top-2.5 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 text-xs">✕</a>
                    @endif
                </form>

                <div class="relative min-w-[200px]">
                    <select onchange="window.location.href=this.value" 
                            class="h-9 w-full rounded-lg border px-3 text-[12px] font-medium outline-none border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21] text-zinc-700 dark:text-zinc-200 cursor-pointer focus:border-blue-500">
                        <option value="" disabled {{ empty($activeProject) ? 'selected' : '' }}>Select Tracked Website...</option>
                        @foreach($projects as $proj)
                            <option value="?project={{ urlencode($proj->project_url) }}&tab={{ urlencode($activeTab) }}&search_project={{ urlencode($searchProject) }}&search={{ urlencode($search) }}"
                                    {{ $activeProject === $proj->project_url ? 'selected' : '' }}>
                                {{ $proj->project_url }} ({{ $proj->progress }}%)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 shrink-0">
                <a href="{{ route('checklist.dashboard') }}" class="flex h-9 items-center justify-center rounded-lg bg-blue-500 px-3 text-[12px] font-medium text-white hover:bg-blue-600 transition">
                    📊 Dashboard
                </a>

                @if($activeProject)
                    <div class="rounded-lg px-2.5 py-1.5 text-[12px] font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                        {{ $overallProgress }}% Done
                    </div>
                @endif

                <button id="theme-toggle" class="flex h-9 w-9 items-center justify-center rounded-lg border border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21] transition-colors">
                    <span class="dark:hidden">🌙</span>
                    <span class="hidden dark:inline">☀️</span>
                </button>
            </div>   
        </div>
    </header>

    <div class="mx-auto flex w-full max-w-7xl flex-col gap-4 px-3 py-4 lg:flex-row lg:px-4 lg:py-6 flex-1">
        
        <aside class="w-full shrink-0 order-2 lg:w-64 lg:order-1 flex flex-col gap-4">
            
            <div class="rounded-2xl border p-4 border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21]">
                <div class="mb-2 text-[12px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Add Website</div>
                <form action="{{ route('checklist.store') }}" method="POST" class="space-y-2">
                    @csrf
                    <input type="text" name="website_url" placeholder="clientwebsite.com" required
                        class="h-10 w-full rounded-lg border px-3 text-[12px] outline-none border-black/10 bg-zinc-50 dark:border-white/10 dark:bg-[#14171d] focus:border-blue-500">
                    <button type="submit" class="flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-blue-500 text-[12px] font-medium text-white hover:bg-blue-600 transition">
                        + Add Website
                    </button>
                </form>
            </div>

            <div class="rounded-2xl border p-4 border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21]">
                <div class="mb-2 text-[12px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Recently Added</div>
                
                <div class="space-y-2">
                    @forelse($projects->take(5) as $proj)
                        <div class="group relative rounded-xl border p-2.5 transition {{ $activeProject === $proj->project_url ? 'border-blue-500 bg-blue-500/5' : 'border-black/5 dark:border-white/5 bg-zinc-50/50 dark:bg-[#14171d]/50' }}">
                            <a href="?project={{ urlencode($proj->project_url) }}&tab={{ urlencode($activeTab) }}&search_project={{ urlencode($searchProject) }}&search={{ urlencode($search) }}" class="block pr-6">
                                <p class="truncate text-[12px] font-medium tracking-tight text-zinc-700 dark:text-zinc-300">{{ $proj->project_url }}</p>
                                <div class="mt-1 flex items-center gap-2 text-[11px] text-zinc-400">
                                    <span>Progress:</span>
                                    <span class="font-medium text-zinc-600 dark:text-zinc-400">{{ $proj->progress }}%</span>
                                </div>
                            </a>
                            <form action="{{ route('checklist.destroy', $proj->project_url) }}" method="POST" class="absolute right-2 top-2 opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('Delete this project permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete Profile" class="text-zinc-400 hover:text-red-500 text-[11px]">✕</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-zinc-400 dark:text-zinc-500 text-[11px] text-center py-2">No active sites tracked.</p>
                    @endforelse

                    @if($projects->count() > 5)
                        <details class="group/details mt-2">
                            <summary class="list-none flex items-center justify-center py-1.5 rounded-lg border border-dashed border-black/10 dark:border-white/10 text-[11px] font-medium text-zinc-500 hover:text-blue-500 cursor-pointer select-none transition">
                                <span class="group-open/details:hidden">▼ View More ({{ $projects->count() - 5 }} hidden)</span>
                                <span class="hidden group-open/details:inline">▲ View Less</span>
                            </summary>
                            <div class="space-y-2 mt-2 pt-2 border-t border-black/5 dark:border-white/5">
                                @foreach($projects->skip(5) as $proj)
                                    <div class="group relative rounded-xl border p-2.5 transition {{ $activeProject === $proj->project_url ? 'border-blue-500 bg-blue-500/5' : 'border-black/5 dark:border-white/5 bg-zinc-50/50 dark:bg-[#14171d]/50' }}">
                                        <a href="?project={{ urlencode($proj->project_url) }}&tab={{ urlencode($activeTab) }}&search_project={{ urlencode($searchProject) }}&search={{ urlencode($search) }}" class="block pr-6">
                                            <p class="truncate text-[12px] font-medium tracking-tight text-zinc-700 dark:text-zinc-300">{{ $proj->project_url }}</p>
                                            <div class="mt-1 flex items-center gap-2 text-[11px] text-zinc-400">
                                                <span>Progress:</span>
                                                <span class="font-medium text-zinc-600 dark:text-zinc-400">{{ $proj->progress }}%</span>
                                            </div>
                                        </a>
                                        <form action="{{ route('checklist.destroy', $proj->project_url) }}" method="POST" class="absolute right-2 top-2 opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('Delete this project permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Profile" class="text-zinc-400 hover:text-red-500 text-[11px]">✕</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endif
                </div>
            </div>
        </aside>

        <section class="w-full order-1 lg:order-2 flex-1">
            @if(empty($activeProject))
                <div class="flex flex-col items-center justify-center p-12 text-center rounded-2xl border border-dashed border-black/20 dark:border-white/20 h-64 bg-white dark:bg-[#181b21]">
                    <p class="text-zinc-400 text-sm">No website selected. Choose a tracking URL from the header menu context or add a new workspace on the left sidebar to begin tracking.</p>
                </div>
            @else
                <div class="mb-3 flex h-10 items-center gap-2 rounded-xl border px-3 border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21]">
                    <form method="GET" action="{{ route('checklist.index') }}" class="w-full flex items-center">
                        <input type="hidden" name="project" value="{{ $activeProject }}">
                        <input type="hidden" name="tab" value="{{ $activeTab }}">
                        <input type="hidden" name="search_project" value="{{ $searchProject }}">
                        <input type="text" name="search" placeholder="Filter active tasks by keyword..." value="{{ $search }}"
                            class="w-full bg-transparent text-[12px] outline-none" oninput="this.form.submit()">
                    </form>
                </div>

                <div class="mb-4 flex gap-2 overflow-x-auto pb-1">
                    @foreach($categories as $cat)
                        <a href="?project={{ urlencode($activeProject) }}&tab={{ urlencode($cat) }}&search={{ urlencode($search) }}&search_project={{ urlencode($searchProject) }}"
                           class="whitespace-nowrap rounded-lg border px-3 py-2 text-[12px] font-medium transition {{ $activeTab === $cat ? 'border-blue-500 bg-blue-500 text-white' : 'border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21]' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>

                <div class="overflow-hidden rounded-xl border border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21]">
                    @forelse($checklistItems as $item)
                        <div class="flex items-start gap-3 border-b border-black/5 dark:border-white/5 px-3 py-3 lg:px-4">
                            <form action="{{ route('checklist.toggle', $item->id) }}" method="POST" class="mt-0.5">
                                @csrf
                                <input type="checkbox" {{ $item->completed ? 'checked' : '' }} onchange="this.form.submit()"
                                       class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </form>
                            <span class="select-text text-[13px] leading-relaxed {{ $item->completed ? 'text-zinc-400 line-through' : 'text-zinc-800 dark:text-zinc-200' }}">
                                {{ $item->task }}
                            </span>
                        </div>
                    @empty
                        <p class="p-8 text-zinc-400 text-xs text-center">No tasks match your search parameters inside this tab.</p>
                    @endforelse
                </div>
            @endif
        </section>
    </div>

    <footer class="mt-auto py-4 text-center text-xs border-t border-black/5 dark:border-white/5 text-zinc-500">
        &copy; {{ date('Y') }} TCJ Checklist App. Built by Jayfel.
    </footer>

    <script>
        const btn = document.getElementById('theme-toggle');
        btn.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>
</html>