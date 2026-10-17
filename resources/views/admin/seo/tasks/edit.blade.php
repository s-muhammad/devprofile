@extends('admin.layout.app')
@section('main')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
        <div class="w-full max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">ویرایش کار</h2>
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                @include('admin.seo.tasks._form', [
                    'action' => route('admin.seo.tasks.update', $task),
                    'method' => 'PUT',
                    'task' => $task,
                    'keywords' => $keywords,
                ])
            </div>
        </div>
    </main>
@endsection
