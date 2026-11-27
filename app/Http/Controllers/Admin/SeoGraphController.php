<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoKeyword;
use App\Models\SeoTask;

class SeoGraphController extends Controller
{
    private const PRIORITY_WEIGHTS = [
        'low' => 1,
        'medium' => 2,
        'high' => 3,
    ];

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
        $briefs = [];
        $tasksCount = 0;
        $priorityScore = 0;

        foreach ($keywords as $keyword) {
            $keywordNodeId = 'keyword-'.$keyword->id;
            $keywordTaskCount = $keyword->tasks->count();

            $nodes[] = [
                'id' => $keywordNodeId,
                'type' => 'keyword',
                'label' => $keyword->keyword,
                'status' => $keyword->status,
                'taskCount' => $keywordTaskCount,
                'radius' => 16 + (int) round(min(14, sqrt(max($keywordTaskCount, 1)) * 5)),
                'tooltip' => implode("\n", array_filter([
                    'کلمه کلیدی: '.$keyword->keyword,
                    'وضعیت: '.$keyword->statusLabel(),
                    $keyword->search_volume !== null ? 'حجم جستجو: '.number_format($keyword->search_volume) : null,
                    $keyword->current_rank !== null ? 'رتبه فعلی: '.$keyword->current_rank : null,
                    'کارهای مرتبط: '.$keywordTaskCount,
                ])),
            ];

            $briefTasks = [];
            $internalLinks = [];

            if ($keyword->target_url) {
                $internalLinks[] = $keyword->target_url;
            }

            foreach ($keyword->tasks as $task) {
                $taskNodeId = 'task-'.$task->id;
                $tasksCount++;
                $priorityScore += self::PRIORITY_WEIGHTS[$task->priority] ?? 2;

                $nodes[] = [
                    'id' => $taskNodeId,
                    'type' => 'task',
                    'label' => $task->title,
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'keywordId' => $keywordNodeId,
                    'radius' => 9,
                    'tooltip' => implode("\n", array_filter([
                        'کار: '.$task->title,
                        'وضعیت: '.$task->statusLabel(),
                        'اولویت: '.$task->priorityLabel(),
                        'کلمه کلیدی: '.$keyword->keyword,
                        $task->due_date ? 'سررسید: '.jalali_date($task->due_date) : null,
                    ])),
                ];

                $edges[] = [
                    'source' => $keywordNodeId,
                    'target' => $taskNodeId,
                ];

                $briefTasks[] = [
                    'title' => $task->title,
                    'status' => $task->status,
                    'statusLabel' => $task->statusLabel(),
                    'priorityLabel' => $task->priorityLabel(),
                    'dueDate' => $task->due_date ? jalali_date($task->due_date) : null,
                    'relatedUrl' => $task->related_url,
                ];

                if ($task->related_url) {
                    $internalLinks[] = $task->related_url;
                }

                $briefs[$taskNodeId] = $this->taskBrief($task, $keyword->keyword, $keywordNodeId);
            }

            $briefs[$keywordNodeId] = [
                'type' => 'keyword',
                'title' => $keyword->keyword,
                'status' => $keyword->status,
                'statusLabel' => $keyword->statusLabel(),
                'intentLabel' => $keyword->intent ? (SeoKeyword::INTENTS[$keyword->intent] ?? $keyword->intent) : null,
                'difficultyLabel' => $keyword->difficulty ? (SeoKeyword::DIFFICULTIES[$keyword->difficulty] ?? $keyword->difficulty) : null,
                'searchVolume' => $keyword->search_volume,
                'rank' => $keyword->current_rank,
                'targetUrl' => $keyword->target_url,
                'notes' => $keyword->notes,
                'tasks' => $briefTasks,
                'internalLinks' => array_values(array_unique($internalLinks)),
            ];
        }

        foreach ($orphanTasks as $task) {
            $taskNodeId = 'task-'.$task->id;
            $tasksCount++;
            $priorityScore += self::PRIORITY_WEIGHTS[$task->priority] ?? 2;

            $nodes[] = [
                'id' => $taskNodeId,
                'type' => 'task',
                'label' => $task->title,
                'status' => $task->status,
                'priority' => $task->priority,
                'keywordId' => null,
                'radius' => 9,
                'tooltip' => implode("\n", array_filter([
                    'کار: '.$task->title,
                    'وضعیت: '.$task->statusLabel(),
                    'اولویت: '.$task->priorityLabel(),
                    'بدون کلمه کلیدی',
                    $task->due_date ? 'سررسید: '.jalali_date($task->due_date) : null,
                ])),
            ];

            $briefs[$taskNodeId] = $this->taskBrief($task);
        }

        $stats = [
            'keywords' => $keywords->count(),
            'tasks' => $tasksCount,
            'links' => count($edges),
            'published' => $keywords->where('status', 'published')->count(),
            'avg_priority' => $tasksCount > 0 ? round($priorityScore / $tasksCount, 1) : null,
        ];

        return view('admin.seo.graph.index', compact('nodes', 'edges', 'briefs', 'stats'));
    }

    /**
     * @return array<string, mixed>
     */
    private function taskBrief(SeoTask $task, ?string $keywordName = null, ?string $keywordNodeId = null): array
    {
        return [
            'type' => 'task',
            'title' => $task->title,
            'status' => $task->status,
            'statusLabel' => $task->statusLabel(),
            'priorityLabel' => $task->priorityLabel(),
            'dueDate' => $task->due_date ? jalali_date($task->due_date) : null,
            'description' => $task->description,
            'relatedUrl' => $task->related_url,
            'keywordId' => $keywordNodeId,
            'keywordTitle' => $keywordName,
        ];
    }
}
