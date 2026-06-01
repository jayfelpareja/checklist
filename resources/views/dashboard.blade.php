<!DOCTYPE html>
<html lang="en" class="h-full antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tracked Progress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="min-h-full flex flex-col bg-[#f5f7fa] text-[#111827] dark:bg-[#0f1115] dark:text-white transition-colors duration-200">

    <header class="sticky top-0 z-50 border-b backdrop-blur border-black/5 bg-white/90 dark:border-white/5 dark:bg-[#0f1115]/90">
        <div class="mx-auto flex min-h-14 max-w-7xl items-center justify-between px-4">
            <div>
                <h1 class="text-[16px] font-semibold">Deployment Overview</h1>
                <p class="text-[12px] text-zinc-500">Global Website Progress Matrix</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('checklist.index') }}" class="rounded-lg bg-zinc-100 px-3 py-1.5 text-[12px] font-medium hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 transition">
                    ← Back to Tasks
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 py-6 flex-1">
        
        <div class="mb-6 max-w-md">
            <form method="GET" action="{{ route('checklist.dashboard') }}" class="relative">
                <input type="text" name="search_project" placeholder="Filter websites by url..." value="{{ $searchProject ?? '' }}"
                    class="h-10 w-full rounded-xl border px-4 text-xs outline-none border-black/10 bg-white dark:border-white/10 dark:bg-[#181b21]">
                @if(!empty($searchProject))
                    <a href="{{ route('checklist.dashboard') }}" class="absolute right-3 top-3 text-zinc-400 hover:text-zinc-600 text-xs">✕</a>
                @endif
            </form>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($projects as $proj)
                <div class="rounded-2xl border p-5 bg-white border-black/10 dark:border-white/10 dark:bg-[#181b21] flex flex-col justify-between shadow-sm">
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="truncate text-[15px] font-semibold text-blue-500 dark:text-blue-400" title="{{ $proj->project_url }}">
                                {{ $proj->project_url }}
                            </h3>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-bold tracking-wider uppercase {{ $proj->progress == 100 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400' }}">
                                {{ $proj->progress == 100 ? 'Live' : 'In Progress' }}
                            </span>
                        </div>
                        
                        <p class="mt-1 text-[12px] text-zinc-400">
                            Tasks: <span class="font-medium text-zinc-700 dark:text-zinc-200">{{ $proj->completed_tasks }}</span> / {{ $proj->total_tasks }} completed
                        </p>
                    </div>

                    <div class="mt-6">
                        <div class="mb-1.5 flex items-center justify-between text-[11px] font-medium">
                            <span class="text-zinc-500">Completion Weight</span>
                            <span class="text-zinc-900 dark:text-white font-bold">{{ $proj->progress }}%</span>
                        </div>
                        
                        <div class="h-2 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-emerald-500 transition-all duration-500" style="width: {{ $proj->progress }}%"></div>
                        </div>

                        <a href="{{ route('checklist.index', ['project' => $proj->project_url]) }}" class="mt-4 block text-center rounded-lg border border-black/5 bg-zinc-50 py-2 text-[12px] font-medium hover:bg-zinc-100 dark:border-white/5 dark:bg-[#14171d] dark:hover:bg-zinc-800/50 transition">
                            Open Checklist Workspace →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center rounded-2xl border border-dashed border-black/10 dark:border-white/10">
                    <p class="text-zinc-500 text-sm">No website progress data available.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>