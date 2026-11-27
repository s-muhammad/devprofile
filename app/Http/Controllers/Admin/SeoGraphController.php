<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoKeyword;
use App\Models\SeoTask;

class SeoGraphController extends Controller
{
    public function index()
    {
        $keywords = SeoKeyword::query()
            ->with(['tasks' => fn ($query) => $query->orderBy('status')->orderBy('due_date')])
            ->orderBy('keyword')
            ->get();

        $orphanTasks = SeoTask::query()
            ->whereNull('seo_keyword_id')
            ->orderBy('title')
            ->get();

        $nodes = [];
        $edges = [];

        foreach ($keywords as $keyword) {
            $nodes[] = [
                'id' => 'keyword-'.$keyword->id,
                'type' => 'keyword',
                'label' => $keyword->keyword,
                'status' => $keyword->status,
                'searchVolume' => $keyword->search_volume,
                'rank' => $keyword->current_rank,
                'tooltip' => implode("\n", array_filter([
                    'کلمه کلیدی: '.$keyword->keyword,
                    'وضعیت: '.$keyword->statusLabel(),
                    $keyword->search_volume !== null ? 'حجم جستجو: '.number_format($keyword->search_volume) : null,
                    $keyword->current_rank !== null ? 'رتبه فعلی: '.$keyword->current_rank : null,
                ])),
            ];

            foreach ($keyword->tasks as $task) {
                $nodes[] = $this->taskNode($task, $keyword->keyword);
                $edges[] = [
                    'source' => 'keyword-'.$keyword->id,
                    'target' => 'task-'.$task->id,
                ];
            }
        }

        foreach ($orphanTasks as $task) {
            $nodes[] = $this->taskNode($task);
        }

        $stats = [
            'keywords' => $keywords->count(),
            'tasks' => $keywords->sum(fn (SeoKeyword $keyword) => $keyword->tasks->count()) + $orphanTasks->count(),
            'links' => count($edges),
            'orphans' => $orphanTasks->count(),
        ];

        return view('admin.seo.graph.index', compact('nodes', 'edges', 'stats'));
    }

    /**
     * @return array<string, mixed>
     */
    private function taskNode(SeoTask $task, ?string $keywordName = null): array
    {
        return [
            'id' => 'task-'.$task->id,
            'type' => 'task',
            'label' => $task->title,
            'status' => $task->status,
            'priority' => $task->priority,
            'tooltip' => implode("\n", array_filter([
                'کار: '.$task->title,
                'وضعیت: '.$task->statusLabel(),
                'اولویت: '.$task->priorityLabel(),
                $keywordName ? 'کلمه کلیدی: '.$keywordName : 'بدون کلمه کلیدی',
                $task->due_date ? 'سررسید: '.jalali_date($task->due_date) : null,
            ])),
        ];
    }
}
